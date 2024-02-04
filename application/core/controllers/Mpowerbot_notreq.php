<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpowerbot extends CI_Controller {
		
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');
		
	 }

	public function index(){
		if(check_logged_in()){
			
			if(is_access_mpower_modules()==false) redirect(base_url()."home","refresh");
			
			$is_global_access = get_global_access();
			$current_user = get_user_id();
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$get_client_id=get_client_ids();
			$get_process_id=get_process_ids();
			$role_id = get_role_id();
			$user_fusion_id = get_user_fusion_id();
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($user_fusion_id); 
			
			//$data["content_template"] = "mpowerbot/chatbot.php";
						
			$this->load->view("mpowerbot/chatbot.php",$data);
			
		}
	}
	
}