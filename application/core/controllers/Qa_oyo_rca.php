<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_oyo_rca extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');		
		$this->load->model('Qa_oyorca_model');		
	 }
	 
	
	public function index(){
		if(check_logged_in()){
			$current_user=get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_rca/oyo_rca_management_feedback_entry.php"; 
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function oyo_rca_feedback_review(){
		if(check_logged_in()){
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_rca/oyo_rca_management_review.php"; 
			
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			$field_array = array
			(
				"from_date"=>$from_date,
				"to_date" => $to_date,
			);	
			
			$data["oyorca_management_review"] = $this->Qa_oyorca_model->oyorca_management_review_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	
	
	
	public function get_agent_information(){
		
		$fusion_id = $this->input->post('fusion_id');
		
		$query = $this->db->query('SELECT signin.id AS agent_id, CONCAT(signin.fname," ",signin.lname) AS agent_name,signin.phno as agent_phone,get_client_names(signin.id) AS client_name, a.id AS team_leader_id, CONCAT(a.fname," ",a.lname) AS team_leader_name, b.id AS manager_id, CONCAT(b.fname," ",b.lname) AS manager_name FROM signin
			LEFT JOIN signin AS a ON a.id=signin.assigned_to
			LEFT JOIN signin AS b ON b.id=a.assigned_to WHERE signin.fusion_id="'.$fusion_id.'"');
			
		$response = array();
		if($query->num_rows() > 0){
			$response['stat'] = true;
			$response['datas'] = $query->row();
		}
		else{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	
	
	public function process_oyo_rca(){
		
		$form_data = $this->input->post();
		$insert_columns = [];
		$insert_values = [];
		foreach($form_data as $key=>$value)
		{
			/* if($key=='audit_date'){
				$value=mmddyy2mysql($value);
				$insert_columns[] = $key;
				$insert_values[] = $value;
			}else{
				$insert_columns[] = $key;
				$insert_values[] = $this->db->escape($value);
			} */
			
			$insert_columns[] = $key;
			$insert_values[] = $this->db->escape($value);
		}
		$current_user = get_user_id();
		$this->db->trans_start();
		$this->db->query('INSERT INTO `qa_oyo_rca`('.implode(",",$insert_columns).',added_by,added_date) VALUES ('.implode(",",$insert_values).',"'.$current_user.'",now())');
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$response['stat'] = false;
		}
		else
		{
			$response['stat'] = true;
		}
		echo json_encode($response);
	}
	
	 
}
?>