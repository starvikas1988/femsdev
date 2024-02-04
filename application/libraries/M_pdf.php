<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(1);
include_once APPPATH.'/third_party/mpdf-5.7/mpdf.php';

class M_pdf {

    public $param;
    public $pdf;

    public function __construct($param = '"en-GB-x","A4","","",8,8,8,8,5,5')
    {
		$CI = & get_instance();
        $this->param =$param;
        //$this->pdf = new mPDF($this->param);
		$this->pdf = new mPDF('c');
    }
}
