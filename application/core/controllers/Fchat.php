<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fchat extends CI_Controller {
		
	function __construct() {
		parent::__construct();
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
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($user_fusion_id); 
			// $query = "SELECT * FROM signin WHERE fname LIKE '%".fname."%' ORDER BY fname ASC";
			$data['namess']= Array('Amit','Prasenjit','Lawrence','Laltu','saqlain','Noor');
			//$this->load->view("mpowerbot/chatbot.php",$data);
			$data["content_template"] = "fchat/index.php";
			$this->load->view('dashboard_single_col',$data);
		}
	}

	public function searchdata(){
		if(check_logged_in()){
			$searchedname = $this->input->get('word');
			// echo $searchedname;exit;
			$query = "SELECT id,fusion_id,fname,lname,concat(fname,' ',lname) as name FROM signin WHERE concat(fname,' ',lname) LIKE '%".$searchedname."%' ORDER BY fname ASC LIMIT 5";
			echo json_encode($this->Common_model->get_query_result_array($query));
		}
	}
	
}