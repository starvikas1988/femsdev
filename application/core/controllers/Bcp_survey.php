<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bcp_survey extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		
		$this->load->model('Common_model');
				
	}
	
	public function index(){
		if(check_logged_in()){
			$current_user=get_user_id();
			
			$data["aside_template"] = "bcp_survey/aside.php";
			$data["content_template"] = "bcp_survey/bcp_survey.php";
			$data["content_js"] = "bcp_survey_js.php";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$cond="";
			
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(entry_date) >= '$from_date' and date(entry_date) <= '$to_date' ) ";
		
			$qSql = "SELECT * from (Select * from bcp_survey $cond) xx Left Join (Select id as sid, concat(fname, ' ', lname) as name, office_id, fusion_id, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.entry_by=yy.sid) where entry_by='$current_user'";
			$data["bcp_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$curDateTime=CurrMySqlDate();
			
			if($this->input->post('customer_name')){
				$field_array=array(
					"customer_name" => $this->input->post('customer_name'),
					"customer_phone" => $this->input->post('customer_phone'),
					"callback_datetime" => mdydt2mysql($this->input->post('callback_datetime')),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$rowid= data_inserter('bcp_survey',$field_array);
				$ans="Done";
			}else{
				$ans="error";
			}
				
			echo $ans;
		}
	}
	
	
	public function bcp_list(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "bcp_survey/aside.php";
			$data["content_template"] = "bcp_survey/bcp_survey_list.php";
			$data["content_js"] = "bcp_survey_js.php";
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$data["bcp_data"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (date(entry_date) >= '$date_from' and date(entry_date) <= '$date_to') ";
		
				if($office_id=="All") $cond1 = "";
				else $cond1 = " Where office_id='$office_id'";
		
				$qSql = "SELECT * from (Select * from bcp_survey $cond) xx Left Join (Select id as sid, concat(fname, ' ', lname) as name, office_id, fusion_id, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.entry_by=yy.sid) $cond1";
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["bcp_data"] = $fullAray;
				$this->create_bcpSurvey_CSV($fullAray);	
				$dn_link = base_url()."bcp_survey/download_bcpSurvey_CSV";
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function download_bcpSurvey_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="BCP Survey List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_bcpSurvey_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("User Fusion ID", "User Name", "User Location", "User Client Name", "User Process Name", "Customer Name", "Customer Phone", "Callback Date/time", "Inserted Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['name'].'",';
			$row .= '"'.$user['office_id'].'",';
			$row .= '"'.$user['client'].'",';
			$row .= '"'.$user['process'].'",';
			$row .= '"'.$user['customer_name'].'",';
			$row .= '"'.$user['customer_phone'].'",';
			$row .= '"'.$user['callback_datetime'].'",';
			$row .= '"'.$user['entry_date'].'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
}
?>	