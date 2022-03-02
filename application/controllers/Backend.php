<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Picture');
        $this->load->library('Custom');
        $this->load->library('PHPExcel');
    }

    private function cekLogin(){
        $cekLogin=$this->session->userdata("loginData");
        if ($cekLogin==""){
            $aksi=(object) array("status"=>false);
        } else {
            $cekLogin=json_decode(base64_decode($cekLogin));
            if ($cekLogin==null){
                $aksi=(object) array("status"=>false);
            } else {
                $aksi=(object) array("status"=>true,"data"=>$cekLogin);
            }
        }
        return $aksi;
    }
    public function keluar()
    {
        $this->session->sess_destroy();

        redirect(base_url());
    }

    public function Proseslogin(){
        $data = $this->input->post('data');
        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        }


        $email = $data['email'];
        $password = $data['password'];
        $sql = "SELECT * FROM tbl_users WHERE email = '$email'";
        $query = $this->db->query($sql)->row();

        if ($query == NULL) {
            $aksi = array("status"=>false, "notifikasi"=>'Maaf email anda belum terdaftar !');
        }else{
            $dbPassword = $query->password;

            if ($dbPassword != $password) {
                $aksi = array("status"=>false, "notifikasi"=>'Password yang anda masukkan salah !');
            }else{
               $keyLogin = base64_encode(json_encode($query));
                    $this->session->set_userdata(array("loginData" => $keyLogin));
                    $aksi = array('status' => true, 'akses'=>$query->hak_akses);
            }
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function ImportExcel()
    {
        $data = $_POST;
        $dataLogin = $this->cekLogin();
        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');header('Content-Type: application/json');echo json_encode($aksi,JSON_PRETTY_PRINT);die();  
        }
        if ($dataLogin->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');header('Content-Type: application/json');echo json_encode($respon,JSON_PRETTY_PRINT);die();
        }

        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);

            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();    
                for($row=3; $row<=$highestRow; $row++)
                {

                    $sumberlog = $data['sumber_log'];
                    $tanggal = $data['tanggal'];
                    $shift = 1;
                    $diangkut_oleh = $data['diangkut_oleh'];

                    $no_seri = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $id_barcode = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $jenis_log = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $panjang_log = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $rata_rata = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $growong = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $gubal = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $persen_growong = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $persen_gubal = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $v60 = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $v50_59 = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $v49 = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $mutu_log = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $keterangan = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $aksi = array(
                        'tanggal'       => $tanggal,
                        'shift'         => $shift,
                        'diangkut_oleh' => $diangkut_oleh,
                        'no_seri'       => $no_seri,
                        'id_barcode'    => $id_barcode,
                        'jenis_log'     => $jenis_log,
                        'panjang_log'   => $panjang_log,
                        'rata_rata'     => $rata_rata,
                        'growong'       => $growong,
                        'gubal'         => $gubal,
                        'persen_gubal'  => $persen_gubal,
                        'persen_growong'=> $persen_growong,
                        'volume60'      => $v60,
                        'volume50_59'   => $v50_59,
                        'volume49'      => $v49,
                        'mutu_log'      => $mutu_log,
                        'keterangan'    => $keterangan,
                    ); 
                    $this->db->set($aksi);
                    $insert = $this->db->insert('tbl_daftar_ukur_ulang_kayu_bulat', $aksi); 
                }
                if($insert){
                    $aksi = array("status"=>true, "notifikasi"=>'Data berhasil diimport !');
                }else{
                    $aksi = array("status"=>false, "notifikasi"=>'Data gagal diimport !');
                }
            }


        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Tidak ada data yang masuk !');
        }
        header('Content-Type: application/json');
        echo json_encode($aksi);
    }


    public function TambahDataUsers()
    {
        $data = $this->input->post('data');
        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }

        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 

        $aksi = array(
            "nama" => $data['nama'],
            "password" => $data['password'],
            "jabatan" => $data['jabatan'],
        );

        $this->db->set($aksi);

        $simpanData = $this->db->insert("tbl_daftar_pegawai");
        if ($simpanData) {
            $aksi = array("status"=>true, "notifikasi"=>'Data user berhasil disimpan !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Maaf data user gagal dibuat !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function Register()
    {
        $data = $this->input->post('data');

        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 

        $aksi = array(
            "nama"           => $data['nama'],
            "password"       => $data['password'],
            "email"          => $data['email'],
            "nomor_telepon"  => $data['nomor_telepon'],
            "alamat"         => $data['alamat'],
            "tanggal_daftar" => date('Y-m-d H:m:i'),
            "hak_akses"      => 'Pembeli',
        );

        $this->db->set($aksi);

        $simpanData = $this->db->insert("tbl_users");
        if ($simpanData) {
            $aksi = array("status"=>true, "notifikasi"=>'Akun anda berhasil dibuat !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Akun anda gagal dibuat !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function HapusDataUsers()
    {
        $loginCek=$this->cekLogin();
        $data = $this->input->post('data');
        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 
        $aksi = array(
            "id" => substr(base64_decode($data['tokenData']), 22),
        );

        $this->db->set($aksi);
        $hapusData = $this->db->where('id', $aksi['id']);
        $hapusData = $this->db->delete('tbl_daftar_pegawai');

        if ($hapusData) {
            $aksi = array("status"=>true, "notifikasi"=>'Data anda berhasil dihapus !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Data anda gagal dihapus !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function ProsesProduk($args)
    {
        $data = $this->input->post('data');

        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }

        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 

        $gambar=json_decode($data['gambar']);
        if ($gambar==null){
            $gambar=$data['gambar'];
        } else {
            $gambar=base64_encode("a".date("ymdhis"));
            $this->picture->uploadTextFile($data['gambar'], $gambar );
        }
        $aksi = array(
            "produk" => $data['nama_produk'],
            "jenis_produk" => $data['jenis_produk'],
            "harga" => $data['harga'],
            "satuan" => $data['satuan_produk'],
            "deskripsi_produk" => $data['deskripsi'],
            "jumlah_stok" => $data['stok_awal'],
            "gambar_produk" => $gambar,
        );

        $this->db->set($aksi);

        if($args == "Tambah")
        {
            $simpanData = $this->db->insert("tbl_produk");
            $pesan = "Data Produk Berhasil Disimpan";
        }else{
            $simpanData = $this->db->where('id', $data['tokenID']);
            $simpanData = $this->db->update("tbl_produk");
            $pesan = "Data Produk Berhasil Diubah";
        }
       
        if ($simpanData) {
            $aksi = array("status"=>true, "notifikasi"=>$pesan);
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Maaf data produk gagal untuk di proses !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function HapusProduk()
    {
        $data = $this->input->post('data');
        $idToken = str_replace("ReynaldoJosuaTogatorop",'',base64_decode($data['tokenID']));

        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }

        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 

        $hapusData = $this->db->where('id', $idToken);
        $hapusData = $this->db->delete("tbl_produk");
       
        if ($hapusData) {
            $aksi = array("status"=>true, "notifikasi"=>'Data produk berhasil dihapus !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Maaf data produk gagal untuk di proses !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function Keranjang()
    {
        $data = $this->input->post('data');
        
        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }

        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 

        $aksi = array(
            "id_users"  => $loginCek->data->id,
            "id_produk" => $data['tokenID'],
            "jumlah"    => $data['jumlah'],
            "tanggal"   => date('Y-m-d'),
        );

        $this->db->set($aksi);
        $hapusData = $this->db->insert("tbl_keranjang", $aksi);
       
        if ($hapusData) {
            $aksi = array("status"=>true, "notifikasi"=>'Data produk berhasil masuk kedalam keranjang !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Maaf data produk gagal untuk di proses !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function HapusKeranjang()
    {
        $data = $this->input->post('data');
        $idToken = str_replace("ReynaldoJosuaTogatorop",'',base64_decode($data['tokenID']));

        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }

        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 

        $hapusData = $this->db->where('id', $idToken);
        $hapusData = $this->db->delete("tbl_keranjang");
       
        if ($hapusData) {
            $aksi = array("status"=>true, "notifikasi"=>'Data produk berhasil dihapus !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Maaf data produk gagal untuk di proses !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function pesan()
    {
        
        $now = DateTime::createFromFormat('U.u', microtime(true));
        $nomorInvoice = "INV".$now->format("YmdHisu");
        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }


        $update = $this->db->where('id_users', $loginCek->data->id);
        $update = $this->db->update("tbl_keranjang", array('invoice'=>$nomorInvoice));
       
        if ($update) {
        $aksi = array(
            "invoice"       => $nomorInvoice,
            "tanggal_pesan" => date('Y-m-d H:m:i'),
            "id_users"      => $loginCek->data->id,
            "status"        => "Belum Dibayar"
        );

        $this->db->set($aksi);
            $simpan = $this->db->insert('tbl_pesanan', $aksi);
            $aksi = array("status"=>true, "notifikasi"=>'Pesanan anda berhasil di selesaikan, silahkan pergi kekasir untuk membayar !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Maaf data produk gagal untuk di proses !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }

    public function DataPesananDetail()
    {
        $data = $this->input->post('data');
        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }
        $detailDataProduk = $this->db->where('invoice', $data)->get('v_data_pesanan_keranjang')->result();

        foreach($detailDataProduk as $produk)
        {
            echo '<tr>
                <td>'.$produk->produk.'</td>
                <td>'.$produk->jumlah.'</td>
                <td>'.$produk->satuan.'</td>
                <td>Rp.'.$this->custom->decimal($produk->harga).',-</td>
            </tr>';
        }

    }

    public function PesananSelesai()
    {
        $data = $this->input->post('data');
        $loginCek=$this->cekLogin();
        if ($loginCek->status==false){
            $respon=array("status" => false,'notifikasi'=>'Maaf anda harus melakukan login terlebih dahulu !');
            header('Content-Type: application/json');
            echo json_encode($respon,JSON_PRETTY_PRINT); 
            die();
        }

        if ($data==null)
        {  
            $aksi=array("status" => false,'notifikasi'=>'The requested URL was rejected. Please consult with your administrator!');  
            header('Content-Type: application/json');  
            echo json_encode($aksi,JSON_PRETTY_PRINT);  
            die();  
        } 

        $aksi = array(
            "total_item"    => $data['total_item'],
            "harga_total"   => $data['harga_total'],
            "total_bayar"  => $data['jumlah_bayar'],
            "kembalian"     => $data['kembalian'],
            "status"        => $data['status'],
        );

        $this->db->set($aksi);

        $simpanData = $this->db->where('id', $data['id']);
        $simpanData = $this->db->update("tbl_pesanan", $aksi);
       
        if ($simpanData) {
            $aksi = array("status"=>true, "notifikasi"=>'Pesanan telah berhasil dibayar, silahkan ambil bukti pembayaran anda !');
        }else{
            $aksi = array("status"=>false, "notifikasi"=>'Maaf data produk gagal untuk di proses !');
        }

        header('Content-Type: application/json');
        echo json_encode($aksi);
    }
}