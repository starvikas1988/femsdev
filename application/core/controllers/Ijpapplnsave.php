<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ijpapplnsave extends CI_Controller {

	function __construct() {
		parent::__construct();
		
	}
	
	
	public function index()
	{
		if(check_logged_in())
		{
		
			$current_user = get_user_id();
			$curr_date = CurrMySqlDate();
			$log=get_logs();
			if($this->input->post('app_post') !=""){
				
				$field_array = array(
					"user_id" => $current_user,
					"location" => trim($this->input->post('location')),
					"app_post" => trim($this->input->post('app_post')),
					"email_id" => trim($this->input->post('email_id')),
					"phone" => trim($this->input->post('phone')),
					"added_time" => $curr_date
				);
				
				//print_r($field_array);
				$rowid = data_inserter('ijp_application_temp',$field_array);
				
			}
			
			echo "Done";
			
		}
	}
	
}	


?>