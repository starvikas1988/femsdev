<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_login extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
    public function index()
    {
       
		  $user_id=2;
		  $dates="2020-11-02,2020-11-03,2020-11-04,2020-11-05,2020-11-06,2020-11-09,2020-11-10,2020-11-11,2020-11-12,2020-11-13,2020-11-16,2020-11-17,2020-11-18,2020-11-19,2020-11-20,2020-11-23,2020-11-24,2020-11-25,2020-11-26,2020-11-27,2020-11-30,2020-12-01,2020-12-02,2020-12-03";
		  
		  $datesArray=explode(',', $dates);
		  
		  foreach($datesArray as $key => $val) {
				echo "$key = $val<br>";
				$hr=rand(7,9);
				$hrl=$hr+14;
				
				$min=rand(01,50);
				$sec=rand(01,50);
				$minl=$min-1;
				$secl=$sec-rand(1,5);
				$login_time=$val." ". $hr.":".$min.":".$sec;
				$logout_time=$val." ". $hrl.":".$minl.":".$secl;
				
				$qSql="INSERT INTO `logged_in_details` (`id`, `user_id`, `login_time`, `login_time_local`, `logout_time`, `logout_time_local`, `logout_by`, `log`, `comments`) VALUES (NULL, '2', '$login_time', '', '$logout_time', '0', '', NULL, NULL)";
				//$this->db->query($qSql);
				
				
		  }
			
		
    }
	  
}

?>