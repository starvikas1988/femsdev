<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : Saikat Ray 
 *  License    : Fusion Bpo  
 *  ======================================= 
 */  
 error_reporting(0);
 require_once APPPATH."/third_party/PHPExcel/IOFactory.php";
 require_once APPPATH."/third_party/PHPExcel.php"; 
 require_once APPPATH."/third_party/PHPExcel/Writer/CSV.php";

class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}
