<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
		require_once APPPATH .'/third_party/PhpOffice/vendor/autoload.php';
	
		use PhpOffice\PhpPresentation\PhpPresentation;
		use PhpOffice\PhpPresentation\IOFactory;
		use PhpOffice\PhpPresentation\Style\Color;
		use PhpOffice\PhpPresentation\Style\Alignment;
 

class Php_office {
	 
	public function __construct(){
		$CI = & get_instance(); 
    }
	
}



