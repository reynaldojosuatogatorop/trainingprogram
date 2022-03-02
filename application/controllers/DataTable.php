<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class DataTable extends CI_Controller
{
	
	function __construct()
	{
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('picture');
        $this->load->library('custom');
        $this->load->model('DataModel', 'model');
        $this->load->model('DataModelKonsumsi', 'modelKonsumsi');
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

    public function dataProduk()
    {
        $table = 'tbl_produk';
        $column_order = array(null, 'produk','jenis_produk', 'harga','satuan','jumlah_stok','deskripsi_produk','gambar_produk');
        $column_search = array('id','produk','jenis_produk', 'harga','satuan','jumlah_stok','deskripsi_produk','gambar_produk');
        $order = array('id' => 'desc'); 
        $this->model->data($table, $column_order, $column_search, $order);
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $model) {
            $no++;
            $id = base64_encode("ReynaldoJosuaTogatorop".$model->id);
            $modelData = base64_encode(json_encode($model));
            $gambar = $this->picture->GetPictureOriginal($model->gambar_produk);
            $row = array();
            $row[] = $no;
            $row[] = $model->produk;
            $row[] = $model->jenis_produk;
            $row[] = $model->harga;
            $row[] = $model->satuan;
            $row[] = $model->jumlah_stok;
            $row[] = $model->deskripsi_produk;
            $row[] = '<a href="'.$this->picture->GetPictureOriginal($model->gambar_produk).'" target="_blank"><img src='.$this->picture->GetPictureSmall($model->gambar_produk).'></a>';
            $row[] = "<a title='Ubah Data' href='javascript:tampilUbahData(`$modelData`,`$gambar`)' class='btn btn-sm btn-sm btn-info text-light'>
            <i class='fas fa-pen'></i>
            </a> 
            <a title='Hapus Data' href='javascript:hapusData(`$id`)' id='btnNameHapus' class='btn btn-sm btn-sm btn-danger text-light '>
            <i class='fas fa-trash-alt'></i>
            </a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function dataPesanan()
    {
        $loginCek=$this->cekLogin();
        $table = 'v_data_keranjang';
        $column_order = array(null, 'produk','jenis_produk', 'harga','satuan','gambar_produk');
        $column_search = array('id','produk','jenis_produk', 'harga','satuan','gambar_produk');
        $order = array('id' => 'desc'); 
        $this->model->data($table, $column_order, $column_search, $order, 'id_users',$loginCek->data->id);
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $model) {
            $no++;
            $id = base64_encode("ReynaldoJosuaTogatorop".$model->id);
            $modelData = base64_encode(json_encode($model));
            $gambar = $this->picture->GetPictureOriginal($model->gambar_produk);
            $row = array();
            $row[] = $no;
            $row[] = '<img src='.$this->picture->GetPictureSmall($model->gambar_produk).'>';
            $row[] = $model->produk;
            $row[] = $model->jenis_produk;
            $row[] = "Rp. ".$this->custom->decimal($model->harga).",-";
            $row[] = $model->satuan;
            $row[] = $model->jumlah_pesanan;
            $row[] = "Rp. ".$this->custom->decimal($model->harga * $model->jumlah_pesanan).",-";
            $row[] = "
            <a title='Hapus Data' href='javascript:hapusData(`$id`)' id='btnNameHapus' class='btn btn-sm btn-sm btn-danger text-light '>
            <i class='fas fa-trash-alt'></i>
            </a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function dataPesananBelumDibayar()
    {
        $loginCek=$this->cekLogin();
        $table = 'v_data_pesanan_belum_dibayar';
        $column_order = array(null, 'invoice','jumlah_pesanan', 'sub_total','tanggal_pesan','status');
        $column_search = array('id','invoice','jumlah_pesanan', 'sub_total','tanggal_pesan','status');
        $order = array('id' => 'desc'); 
        $this->model->data($table, $column_order, $column_search, $order, 'id_users',$loginCek->data->id);
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $model) {
            $no++;
            $id = base64_encode("ReynaldoJosuaTogatorop".$model->id);
            $modelData = base64_encode(json_encode($model));
            $row = array();
            $row[] = $no;
            $row[] = $model->invoice;
            $row[] = $model->jumlah_pesanan;
            $row[] = "Rp. ".$this->custom->decimal($model->sub_total).",-";
            $row[] = $model->tanggal_pesan;
            $row[] = $model->status;
            $row[] = "
            <a title='Detail Pesanan' href='?menu=detail-pesanan&invoice=".$model->invoice."' id='btnNameHapus' class='btn btn-sm btn-sm btn-info text-light '>
            Lihat Detail
            </a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function dataPesananMasuk()
    {
        $loginCek=$this->cekLogin();
        $table = 'v_data_pesanan_belum_dibayar';
        $column_order = array(null, 'invoice','nama','jumlah_pesanan', 'sub_total','tanggal_pesan');
        $column_search = array('id','invoice','nama','jumlah_pesanan', 'sub_total','tanggal_pesan');
        $order = array('id' => 'desc'); 
        $this->model->data($table, $column_order, $column_search, $order);
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $model) {
            $no++;
            $id = base64_encode("ReynaldoJosuaTogatorop".$model->id);
            $modelData = base64_encode(json_encode($model));
            $row = array();
            $row[] = $no;
            $row[] = $model->invoice;
            $row[] = $model->nama;
            $row[] = $model->jumlah_pesanan;
            $row[] = "Rp. ".$this->custom->decimal($model->sub_total).",-";
            $row[] = $model->tanggal_pesan;
            $row[] = "
            <a title='Checkout Pesanan' href='javascript:checkout(`".$modelData."`)' id='btnNameHapus' class='btn btn-sm btn-sm btn-success text-light '>
            Checkout
            </a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function dataPesananSelesai()
    {
        $loginCek=$this->cekLogin();
        $table = 'v_data_pesanan_selesai';
        $column_order = array(null, 'invoice','nama','jumlah_pesanan', 'sub_total','tanggal_pesan');
        $column_search = array('id','invoice','nama','jumlah_pesanan', 'sub_total','tanggal_pesan');
        $order = array('id' => 'desc'); 
        $this->model->data($table, $column_order, $column_search, $order);
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $model) {
            $no++;
            $id = base64_encode("ReynaldoJosuaTogatorop".$model->id);
            $modelData = base64_encode(json_encode($model));
            $row = array();
            $row[] = $no;
            $row[] = $model->invoice;
            $row[] = $model->nama;
            $row[] = $model->jumlah_pesanan;
            $row[] = "Rp. ".$this->custom->decimal($model->sub_total).",-";
            $row[] = $model->tanggal_pesan;
            $row[] = "
            <a title='Checkout Pesanan' href='?menu=invoice&invoice=".$model->invoice."' id='btnNameHapus' class='btn btn-sm btn-sm btn-success text-light '>
            Print
            </a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function dataSisaStok()
    {
        $loginCek=$this->cekLogin();
        $table = 'tbl_produk';
        $column_order = array(null, 'produk','gambar_produk', 'jumlah_stok');
        $column_search = array('id','produk','gambar_produk', 'jumlah_stok');
        $order = array('id' => 'desc'); 
        $this->model->data($table, $column_order, $column_search, $order);
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $model) {
            $no++;
            $id = base64_encode("ReynaldoJosuaTogatorop".$model->id);
            $modelData = base64_encode(json_encode($model));
            $row = array();
            $row[] = $no;
            $row[] = $model->produk;
            $row[] ='<img src='.$this->picture->GetPictureSmall($model->gambar_produk).'>';
            $row[] = $model->jumlah_stok;
            $sisa_stok = $this->db->query("SELECT sum(jumlah) as jumlah FROM tbl_keranjang WHERE id_produk =".$model->id)->row();
            if($sisa_stok->jumlah == NULL)
            {
                $jumlahSisa = 0;
            }else{
                $jumlahSisa = $sisa_stok->jumlah;
            }

             if($model->jumlah_stok >= 50 )
            {
                $stok = '<span class="badge badge-primary">Tersedia</span>';

            }else if($model->jumlah_stok >= 20)
            {
                $stok = '<span class="badge badge-warning">Hampir Habis</span>';
            }else{
                $stok = '<span class="badge badge-danger">Stok Habis</span>';

            }

            $row[] = $jumlahSisa;
            $row[] = $stok;
            
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

}
?>