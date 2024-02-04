<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Versoportals extends CI_Controller {

    private $aside = "versoportals/aside.php";
	
	 
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');
		
	 }

	public function index(){
		if(check_logged_in()){
			
			$is_global_access = get_global_access();
			$current_user = get_user_id();
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$get_client_id=get_client_ids();
			$get_process_id=get_process_ids();
			$role_id = get_role_id();
			$user_fusion_id = get_user_fusion_id();
			$user_xpoid = get_user_omuid();
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($user_fusion_id); 
			$vUrl="";
			//$vUrl=base_url()."SO_Mobile/SO_Survey/survey.aspx?center=Center01&userName=".$user_fusion_id."&userId=0&user=SO&guid=SO";			
			$vUrl=base_url()."SO_Mobile/";	
			
			$data["content_template"] = "versoportals/frame.php";
			$data["vUrl"]=$vUrl;
			
			$this->load->view('dashboard_single_col',$data);
			
		}
	}
	
}

?>