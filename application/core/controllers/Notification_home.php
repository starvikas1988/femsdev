<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_home extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){				
		redirect(base_url('home'));	 
	}
	 
	


//==========================================================================================
///=========================== PROFILE VERIFICATION SURVEY  ================================///

	
	public function profile()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['surveyHome'] = 0;
		if($this->uri->segment(3) == 'check'){
			$data['surveyHome'] = 1;
		}
		
		$agent_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id, r.name as designation, d.shname as department, p.* from signin as s
		              LEFT JOIN info_personal as p ON s.id = p.user_id
		              LEFT JOIN role as r ON r.id = s.role_id
		              LEFT JOIN department as d ON d.id = s.dept_id
					  WHERE s.id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$country_pre_Sql="Select * FROM master_countries WHERE name = 'India' ORDER BY name ASC";
		$data["get_countries"] = $this->Common_model->get_query_result_array($country_pre_Sql);
		
		$state_pre_Sql="Select * FROM master_states WHERE country_id IN (select id from master_countries where name ='India') ORDER BY name ASC";
		$data["get_states"] = $this->Common_model->get_query_result_array($state_pre_Sql);
		
		$city_pre_Sql="Select * FROM master_cities WHERE state_id in (select id from master_states where country_id ='101') ORDER BY name ASC";
		$data["get_cities"] = $this->Common_model->get_query_result_array($city_pre_Sql);
		
		$data['surveySubmission'] = 0;
		$survey_sql = "SELECT * from survey_profile_validation WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_row_array($survey_sql);
		if(count($data['surveySubmission']) > 0){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "notification_home/profile_validation_aside.php";
		$data["content_template"] = "notification_home/profile_validation.php";
		$data["content_js"] = "notification_home/profile_validation_js.php";
		
		if($data['surveyHome'] == 1){
			$this->load->view('dashboard_single_col',$data);
		} else {
			$this->load->view('dashboard',$data);
		}
	 
	}
	 
	
	public function submit_profile_info()
	{
		$current_user = get_user_id();
		
		$sqlCheck = "SELECT * from info_personal WHERE user_id = '$current_user'";
		$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
		if(empty($queryCheck)){
			$dataInsert = [ "user_id" => $current_user ];
			data_inserter('info_personal', $dataInsert);
		}
		
		$agent_uid = $this->input->post('agent_uid');
		$permanent_address_confirm = $this->input->post('permanent_address_confirm');		
		$u_address_permanent = $this->input->post('u_address_permanent');
		$u_per_country = $this->input->post('u_per_country');
		$u_per_state = $this->input->post('u_per_state');
		$u_per_city = $this->input->post('u_per_city');
		$u_per_city_other = $this->input->post('u_per_city_other');
		$u_per_pin = $this->input->post('u_per_pin');
		
		$present_address_confirm = $this->input->post('present_address_confirm');
		$u_address_present = $this->input->post('u_address_present');
		$u_pre_country = $this->input->post('u_pre_country');
		$u_pre_state = $this->input->post('u_pre_state');
		$u_pre_city = $this->input->post('u_pre_city');
		$u_pre_city_other = $this->input->post('u_pre_city_other');
		$u_pre_pin = $this->input->post('u_pre_pin');
		
		$phone_no_confirm = $this->input->post('phone_no_confirm');
		$u_phone_parents = $this->input->post('u_phone_parents');
		
		$my_phone_no_confirm = $this->input->post('my_phone_no_confirm');
		$u_my_phone_no = $this->input->post('u_my_phone_no');
		
		$email_id_confirm = $this->input->post('email_id_confirm');
		$u_email_active = $this->input->post('u_email_active');
		
		$data_array = array();
		if($permanent_address_confirm == "No"){
			if($u_per_city == 'other' || empty($u_per_city)){
			    $u_per_city = $u_per_city_other;
			}
			$data_array += [
				'address_permanent' => $u_address_permanent,
				'pin' => $u_per_pin,
				'city' => $u_per_city,
				'state' => $u_per_state,
				'country' => $u_per_country,
			];
		}
		
		if($present_address_confirm == "No"){
			if($u_pre_city == 'other' || empty($u_pre_city)){
			    $u_pre_city = $u_pre_city_other;
			}
			$data_array += [
				'address_present' => $u_address_present,
				'pin_pre' => $u_pre_pin,
				'city_pre' => $u_pre_city,
				'state_pre' => $u_pre_state,
				'country_pre' => $u_pre_country,
			];
		}
		
		if($phone_no_confirm == "No"){
			$data_array += [
				'phone_emar' => $u_phone_parents,
			];
		}
		
		if($my_phone_no_confirm == "No"){
			$data_array += [
				'phone' => $u_my_phone_no,
			];
		}
		
		if($email_id_confirm == "No"){
			$data_array += [
				'email_id_per' => $u_email_active,
			];
		}
		if(!empty($data_array)){
			$this->db->where('user_id', $current_user);
			$this->db->update('info_personal', $data_array);
		}
		
		//echo "<pre>".print_r($data_array, 1)."</pre>";
		$surveyUpdate = [
			"agent_id" => $current_user,
			"permanent_address_confirm" => $permanent_address_confirm,
			"present_address_confirm" => $present_address_confirm,
			"phone_no_confirmation" => $my_phone_no_confirm,
			"phone_no_parents_confirmation" => $phone_no_confirm,
			"email_id_confirmation" => $email_id_confirm,
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'date_added_local' => GetLocalDate(),
			'logs' => get_logs()
		];
		data_inserter('survey_profile_validation', $surveyUpdate);		
		
		//redirect($_SERVER['HTTP_REFERER']);
		redirect(base_url('home'));
	
	}
	
	
}

?>