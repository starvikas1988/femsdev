<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_joiners_feedback_form extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();		
	}
	
	
//==========================================================================================
///=========================== NEW JOINER FEEDBACK  ================================///

    public function index(){		 		
		redirect(base_url()."new_joiners_feedback_form/dashboard");	 
	}

	public function dashboard()
	{
		$is_global_access = get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		//IF TABLE NOT AVAILABLE CREATE
		$sqlCheck = "SELECT count(*) as value from info_personal WHERE user_id = '$current_user'";
		$counterCheck = $this->Common_model->get_single_value($sqlCheck);
		if($counterCheck < 1){
			$dataCounter = [ 'user_id' => $current_user ];
			data_inserter('info_personal', $dataCounter);
		}
		
		// CHECK SKIP STATUS
		$skipHiringFeedback_1 = $this->session->userdata('skipHiringFeedback_1');
		$skipHiringFeedback_2 = $this->session->userdata('skipHiringFeedback_2');
		if($skipHiringFeedback_1 == 'Y' || $skipHiringFeedback_2 == 'Y'){
			redirect(base_url('home'));
		}
		
		$sql = "SELECT * from new_joiners_feedback WHERE added_by = $current_user";
		$getData =  $this->Common_model->get_query_result_array($sql);

		$data["content_template"] = "new_joiners_feedback_form/new_joiners_feedback_form_dashboard.php";	 
		if(!empty($getData)){ $data["content_template"] = "new_joiners_feedback_form/new_joiners_feedback_form_thankyou.php"; }
		
		$userInfo = "SELECT s.*, r.name as designation, d.shname as department, CONCAT(s.fname, ' ', s.lname) as full_name, 
		             CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor from signin as s 
		             LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 LEFT JOIN signin as ls ON ls.id = s.assigned_to
					 WHERE s.id = '$current_user'";
		$queryInfo = $this->Common_model->get_query_row_array($userInfo);
		$data['userDetails'] = $queryInfo;
		
		// GET DOJ CHECK
		$data['currentDate'] = $currentDay = CurrDate();
		$data['currentDOJ'] = $currentDOJ = $queryInfo['doj'];
				
		$currentFormStatus = 1; $skipStatus = 1;
		if(!empty($queryInfo['doj']))
		{
			$day_7 = date('Y-m-d', strtotime('+7 days', strtotime($currentDOJ)));
			$day_10 = date('Y-m-d', strtotime('+10 days', strtotime($currentDOJ)));
			$day_18 = date('Y-m-d', strtotime('+18 days', strtotime($currentDOJ)));
			$day_21 = date('Y-m-d', strtotime('+30 days', strtotime($currentDOJ)));
			if(strtotime($currentDay) >= strtotime($day_7)){ $currentFormStatus = 1; $skipStatus = 1; }
			if(strtotime($currentDay) >= strtotime($day_10)){ $currentFormStatus = 1; $skipStatus = 0; }
			
			if(!empty($getData)){			
				if(strtotime($currentDay) >= strtotime($day_18)){
					redirect('new_joiners_feedback_form/two');
				} else {
					redirect(base_url('home'));
				}
			}
		}
		
		$data['skipStatus'] = $skipStatus;
		
		//$data["aside_template"] = "new_joiners_feedback_form/aside.php";		
		// $data["content_js"] = "new_joiners_feedback_form/new_joiners_feedback_form_js.php";		
		
		$this->load->view("dashboard_single_col",$data);
	}
	
	public function two()
	{
		$is_global_access = get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		//IF TABLE NOT AVAILABLE CREATE
		$sqlCheck = "SELECT count(*) as value from info_personal WHERE user_id = '$current_user'";
		$counterCheck = $this->Common_model->get_single_value($sqlCheck);
		if($counterCheck < 1){
			$dataCounter = [ 'user_id' => $current_user ];
			data_inserter('info_personal', $dataCounter);
		}
		
		// CHECK SKIP STATUS
		$skipHiringFeedback_1 = $this->session->userdata('skipHiringFeedback_1');
		$skipHiringFeedback_2 = $this->session->userdata('skipHiringFeedback_2');
		if($skipHiringFeedback_2 == 'Y'){
			redirect(base_url('home'));
		}
		
		$sql = "SELECT * from new_joiners_feedback_two WHERE added_by = $current_user";
		$getData =  $this->Common_model->get_query_result_array($sql);
		
		$data["content_template"] = "new_joiners_feedback_form/new_joiners_feedback_form_two.php";	 
		if(!empty($getData)){ $data["content_template"] = "new_joiners_feedback_form/new_joiners_feedback_form_thankyou.php"; }
		
		$userInfo = "SELECT s.*, r.name as designation, d.shname as department, CONCAT(s.fname, ' ', s.lname) as full_name, 
		             CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor from signin as s 
		             LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 LEFT JOIN signin as ls ON ls.id = s.assigned_to
					 WHERE s.id = '$current_user'";
		$queryInfo = $this->Common_model->get_query_row_array($userInfo);
		$data['userDetails'] = $queryInfo;
		
		// GET DOJ CHECK
		$data['currentDate'] = $currentDay = CurrDate();
		$data['currentDOJ'] = $currentDOJ = $queryInfo['doj'];
		
		$currentFormStatus = 2; $skipStatus = 1;
		if(!empty($queryInfo['doj']))
		{
			$day_7 = date('Y-m-d', strtotime('+7 days', strtotime($currentDOJ)));
			$day_10 = date('Y-m-d', strtotime('+10 days', strtotime($currentDOJ)));
			$day_18 = date('Y-m-d', strtotime('+10 days', strtotime($currentDOJ)));
			$day_21 = date('Y-m-d', strtotime('+21 days', strtotime($currentDOJ)));
			if(strtotime($currentDay) >= strtotime($day_7)){ $currentFormStatus = 1; $skipStatus = 1; }
			if(strtotime($currentDay) >= strtotime($day_10)){ $currentFormStatus = 1; $skipStatus = 0; }
			if(strtotime($currentDay) >= strtotime($day_18)){ $currentFormStatus = 2; $skipStatus = 1; }
			if(strtotime($currentDay) >= strtotime($day_21)){ $currentFormStatus = 2; $skipStatus = 0; }
			
			if(!empty($getData)){
				redirect(base_url('home'));
			}
		}
		
		$data['skipStatus'] = $skipStatus;
		
		//$data["aside_template"] = "new_joiners_feedback_form/aside.php";		
		// $data["content_js"] = "new_joiners_feedback_form/new_joiners_feedback_form_js.php";
		
		$this->load->view("dashboard_single_col",$data);
	}

	public function process_form()
	{  
		$tablename = 'new_joiners_feedback';
		$current_user   = get_user_id();
		$infos = $this->input->post();

		$data = array(
					"understanding_role" => $infos['understanding_role'],
					"recruiting_process" => $infos['recruiting_process'],
					"online_induction" => $infos['online_induction'],
					"joining_formalities" => $infos['joining_formalities'],
					"induction_kit" => $infos['induction_kit'],
					"introduction" => $infos['introduction'],
					"clarity_to_job" => $infos['clarity_to_job'],
					"adequate_resources" => $infos['adequate_resources'],
					"adequate_support" => $infos['adequate_support'],
					"technical_training" => $infos['technical_training'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);
		// var_dump($data);
    	if(!empty($infos['understanding_role']) && !empty($infos['recruiting_process']) && !empty($infos['online_induction']) && !empty($infos['joining_formalities']) && !empty($infos['induction_kit']) && !empty($infos['introduction']) && !empty($infos['clarity_to_job']) && !empty($infos['adequate_resources']) && !empty($infos['adequate_support']) && !empty($infos['technical_training']) ){
			$this->db->insert($tablename, $data);
			$insert_id = $this->db->insert_id();
			if (!empty($insert_id)) {
				if($insert_id != null){
					
					$updateArray = [ 'is_hiring_feedback_1' => 1 ];
					$this->db->where('user_id', $current_user);
					$this->db->update('info_personal', $updateArray);
					
					redirect(base_url()."new_joiners_feedback_form/dashboard");	
				}
				 
			}
	    }
    }

    public function process_form_ii()
	{  
		$tablename = 'new_joiners_feedback_two';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		var_dump($infos);
		$data = array(
					"previous_feedback" => $infos['previous_feedback'],
					"duties_and_responsibilities" => $infos['duties_and_responsibilities'],
					"id_and_biometric" => $infos['id_and_biometric'],
					"device_and_email" => $infos['device_and_email'],
					"received_hr_policy" => $infos['received_hr_policy'],
					"training_policy" => $infos['training_policy'],
					"adequate_cooperation" => $infos['adequate_cooperation'],
					"questions_related_to_org" => $infos['questions_related_to_org'],
					"day_need_to_show" => $infos['day_need_to_show'],
					"work_culture" => $infos['work_culture'],
					"technical_training" => $infos['technical_training'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);
		// var_dump($data);
    	if(!empty($infos['previous_feedback']) && !empty($infos['duties_and_responsibilities']) && !empty($infos['id_and_biometric']) && !empty($infos['device_and_email']) && !empty($infos['received_hr_policy']) && !empty($infos['training_policy']) && !empty($infos['adequate_cooperation']) && !empty($infos['questions_related_to_org']) && !empty($infos['day_need_to_show']) && !empty($infos['work_culture']) && !empty($infos['technical_training']) ){
			
			$this->db->insert($tablename, $data);
			$insert_id = $this->db->insert_id();
			if (!empty($insert_id)) {
				if($insert_id != null){
					
					$updateArray = [ 'is_hiring_feedback_2' => 1 ];
					$this->db->where('user_id', $current_user);
					$this->db->update('info_personal', $updateArray);
					
					redirect(base_url()."new_joiners_feedback_form/two");	
				}
				 
			}

	    }
    }
	
	public function skip_now()
	{  	
		$current_user   = get_user_id();
		$type = $this->input->get('fd');
		if(!empty($type)){
			$column = 'is_hiring_feedback_1'; $skipper = 'skipHiringFeedback_1'; 
			if($type == 2){ $column = 'is_hiring_feedback_2'; $skipper = 'skipHiringFeedback_2';  }
			$updateArray = [ $column => 2 ];
			$this->db->where('user_id', $current_user);
			$this->db->update('info_personal', $updateArray);
			$this->session->set_userdata($skipper, 'Y');
			redirect(base_url('home'));	
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
    }

}