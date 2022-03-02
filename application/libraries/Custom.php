<?php if (!defined("BASEPATH")) exit("No direct script access allowed");
class Custom {
    private $_CI;
    
    
    public function decimal($x){
                
                $ex = explode('.',$x);
                $val=$ex[0];
                
                if (count($ex)==1){
                   $dec=0;
                } else {
                   $dec=$ex[1];
                }
               
                if ($dec==0){
                   $temp= number_format($val,0,",",".");
                } else {
                   $temp =number_format($val,0,",",".").",".$dec;
                }
                return $temp;
         }



}