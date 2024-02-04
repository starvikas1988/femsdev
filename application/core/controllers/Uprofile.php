<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uprofile extends CI_Controller {
    
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
        if(check_logged_in()){
			
			$prof_fid=$this->uri->segment(3);
			
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			if($prof_fid=="") $prof_fid=get_user_fusion_id();
			$data['prof_fid']=$prof_fid;
			
			$this->load->view('profile/profile',$data);
			
		}
    }
	
}

?>