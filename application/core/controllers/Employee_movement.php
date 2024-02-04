<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_movement extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
	}


	
	public function index()
	{
		if(check_logged_in())
		{			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "employee_movement/aside.php";
			$data["content_template"] = "employee_movement/employee_movement.php";
			
			$qSql="Select *, (select name from role r where r.id=role_id) as role, (select shname from client c where c.id=client_id) as client, (select name from process p where p.id=process_id) as process, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as count_canasempl from dfr_requisition where requisition_status='CL' ";
			$data["get_closed_requisition"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
}
?>