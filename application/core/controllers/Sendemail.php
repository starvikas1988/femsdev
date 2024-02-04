<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendemail extends CI_Controller {

		private $aside = "admin/aside.php";

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    function __construct() {
		parent::__construct();
			$this->load->model('common_model');
		
	 }
	 
    public function index()
    {
	
				
		$role_id= get_role_id();
		$current_user = get_user_id();
		//echo $current_user;
		//////////////////////////////////
		$user_site_id= get_user_site_id();
		//////////////////////////////////
					
		 $config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => '10.29.0.65', ///10.29.0.65 , smtp.office365.com
		  'smtp_port' => 10025,  //587
		  //'smtp_user' => 'root', // change it to yours
		  //'smtp_pass' => 'yv2kol55', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
		$this->load->library('email', $config);
		
		$message = 'Please submit a LOA request because agent is Called in for 5 days.';
		
		$this->email->set_newline("\r\n");
		$this->email->from('noreply.sox@fusionbposervices.com', 'SOX System');
		$this->email->to('saikat.ray@fusionbposervices.com');
		$this->email->cc('lawrence.gandhar@fusionbposervices.com,skt.saikat@gmail.com,samaresh.math@fusionbposervices.com');
		$this->email->subject('Test Mail. Email notification for LOA /CI');
		$this->email->message($message);
		
		if($this->email->send()){
			echo 'Email sent.';
		}else{
			show_error($this->email->print_debugger());
		}

		//$data["aside_template"] = $this->get_aside_template($role_id);
		//$data["content_template"] = "attendance/att_main.php";
		//$this->load->view('dashboard',$data);
			
	   
    }
	
	
	private function is_access_page($_role_id)
	{
		$_role_arr = array("admin"=>1,"manager"=>4);
		if(in_array($_role_id,$_role_arr ))
		{
			return true;
		}else{
			return false;
		}
	}
	
		
	
}

?>