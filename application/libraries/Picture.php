<?php if (!defined("BASEPATH")) exit("No direct script access allowed");
class Picture {
    private $_CI;

    public function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
    
    public function GetPictureOriginal($FileName){
        if ($FileName==""){
             $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
             $data      = 'data:image/png;base64,'.base64_encode($img);
        } else {
            $url       = base_url().'upload/'.$FileName;
            if ($this->get_http_response_code($url)== "200"){
                $img      = file_get_contents($url);
                $obj      = json_decode($img);
                $data     = $obj->Original;
            } else {
                $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
                $data      = 'data:image/png;base64,'.base64_encode($img);
            }
            
        }
        return $data;
    }
    public function GetPictureMedium($FileName){
        if ($FileName==""){
             $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
             $data      = 'data:image/png;base64,'.base64_encode($img);
        } else {
            $url       = base_url().'upload/'.$FileName;
            if ($this->get_http_response_code($url)== "200"){
                $img      = file_get_contents($url);
                $obj      = json_decode($img);
                $data     = $obj->Medium;
            } else {
               $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
               $data      = 'data:image/png;base64,'.base64_encode($img);
            }
        }
        return $data;
    }
 

    public function GetPictureSmall($FileName){
        if ($FileName==""){
             $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
             $data      = 'data:image/png;base64,'.base64_encode($img);
        } else {
                $url       = base_url().'upload/'.$FileName;
                if ($this->get_http_response_code($url)== "200"){
                    $img      = file_get_contents($url);
                    $obj      = json_decode($img);
                    $data     = $obj->Small;
                } else {
                   $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
                   $data      = 'data:image/png;base64,'.base64_encode($img);
                }
        }
        return $data;
    }
    
    public function GetPdf($FileName)
    {
        if ($FileName==""){
             $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
             $data      = 'data:image/pdf;base64,'.base64_encode($img);
        } else {
                $url       = base_url().'upload/'.$FileName;
                if ($this->get_http_response_code($url)== "200"){
                    $img      = file_get_contents($url);
                    $obj      = json_decode($img);
                    $data     = $obj->Small;
                } else {
                   $img       = file_get_contents(base_url('assets/Admin/img/petani.png'));
                   $data      = 'data:image/pdf;base64,'.base64_encode($img);
                }
        }
        return $data;
    }

    public function uploadFile($dt,$uniquesavename ){
    	$CI        = & get_instance();
         $CI->load->helper('file');
       
            
        $target_file        = "upload/".$uniquesavename ; 
        $dataImg            = array(
                              "Small"       => $dt['Small'],
                              "Medium"      => $dt['Medium'],
                              "Original"    => $dt['Original'],
                              );
        $output=write_file($target_file,json_encode($dataImg));
        return $output ;
    }
    
    public function uploadTextFile($TextFIle,$uniquesavename ){
    	$CI        = & get_instance();
        $CI->load->helper('file');
        $target_file        = "upload/".$uniquesavename ; 
        $output=write_file($target_file,$TextFIle);
        return $output ;
    }

 }