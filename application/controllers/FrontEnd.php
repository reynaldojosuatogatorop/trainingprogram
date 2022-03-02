<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontEnd extends CI_Controller {
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

function __construct()
{
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('Picture');
    $this->load->library('Custom');

}
public function home()
{   
    $modul = $this->input->get('menu');
    $data['loginData'] = $this->cekLogin();
    if($modul == 'data-produk'){
        $data['dataTableHalaman'] = (object) array(
            "Menu"      => "Master Data Produk",
            "Cari"      => true,
            "Tabel"     => "#datatable",
            "ajaxUrl"   => base_url('DataTable/dataProduk'),
        );
    }else if($modul == 'keranjang'){
        $data['dataTableHalaman'] = (object) array(
            "Menu"      => "Keranjang Pesanan",
            "Cari"      => true,
            "Tabel"     => "#datatable",
            "ajaxUrl"   => base_url('DataTable/dataPesanan'),
        );
    }else if($modul == 'pesanan'){
        $data['dataTableHalaman'] = (object) array(
            "Menu"      => "Pesanan Belum Dibayar",
            "Cari"      => true,
            "Tabel"     => "#datatable",
            "ajaxUrl"   => base_url('DataTable/dataPesananBelumDibayar'),
        );
    }else if($modul == 'pesanan-masuk'){
        $data['dataTableHalaman'] = (object) array(
            "Menu"      => "Pesanan Masuk",
            "Cari"      => true,
            "Tabel"     => "#datatable",
            "ajaxUrl"   => base_url('DataTable/dataPesananMasuk'),
        );
    }else if($modul == 'pesanan-selesai'){
        $data['dataTableHalaman'] = (object) array(
            "Menu"      => "Pesanan Masuk",
            "Cari"      => true,
            "Tabel"     => "#datatable",
            "ajaxUrl"   => base_url('DataTable/dataPesananSelesai'),
        );
    }else{

        if($data['loginData']->data->hak_akses == "Admin")
        {
            $table = '#datatable';
            $cari = true;
            $ajax = base_url('DataTable/dataSisaStok');
        }else{
            $table = '';
            $cari = false;
            $ajax = "";
        }
        $data['dataTableHalaman'] = (object) array(
            "Menu"      => "Data Ukur Ulang Kayu Bulat",
            "Cari"      => $cari,
            "Tabel"     => $table,
            "ajaxUrl"   => $ajax,
        );
    }

    $data['menu'] = $this->input->get('menu');
    $data['modul'] = $this->input->get('modul');
    $this->load->view('layout', $data);
}

public function login()
{
    $this->load->view('login');
}

public function daftar()
{
    $this->load->view('daftar');
}

public function keluar()
{
    $this->session->sess_destroy();

    redirect(base_url());
}
}
