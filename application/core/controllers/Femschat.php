<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Femschat extends CI_Controller {
		
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');
		
	 }

	public function index(){
		if(check_logged_in()){
						
			$current_user = get_user_id();
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			
			$user_fusion_id = get_user_fusion_id();
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($user_fusion_id);				
			$chatDB = $this->load->database('femschat',TRUE);
			$qSQL="SELECT userSecret FROM users where userEmail='$user_fusion_id'";
			$query = $chatDB->query($qSQL);
			$res=$query->row_array();
		    $userSecret= $res["userSecret"];
			$chat_url = $this->config->item("chat_url")."/initfemschat";
			//$chat_url = $this->config->item("chat_url")."/initfemschat?fid=".$user_fusion_id."&t="."$userSecret";
			//redirect($chat_url,"refresh");
			
			echo '<body onload="document.redirectform.submit()">   
				<form method="POST" action="'.$chat_url.'" name="redirectform" style="display:none">
				<input name="fid" value=' . $user_fusion_id. '>
				<input name="t" value=' . $userSecret. '>
				</form>
			</body>';
			
		}
	}
	
}