<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurys_inn extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
//==========================================================================================
///=========================== JURYS INN  ================================///

    public function index(){		 		
		redirect(base_url()."jurys_inn/dashboard");	 
	}
	 
	
	//--------- CRM FORM ID
	
	public function generate_crm_id()
	{
		$sql = "SELECT count(*) as value from jurys_inn_crm ORDER by cid DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_crm_id = "JURY" .mt_rand(11,99) .sprintf('%06d', $lastid + 1);
		return $new_crm_id;
	}
	
	public function dashboard()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
			
		$extraFilter = ""; $extraTotal = "";
		$todayStartDate = CurrDate()." 00:00:00"; $todayEndDate = CurrDate()." 23:59:59";
		if(!empty($this->input->get('start')))
		{ 
			$todayStartDate = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$todayEndDate = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";			
		}		
		
		if($role_dir == "agent")
		{
			$extraFilter .= " AND (c.added_by = '$current_user') ";
			$extraTotal .= " AND (c.added_by = '$current_user') ";
		}
		
		$sql = "SELECT count(*) as value from jurys_inn_crm as c WHERE 1 $extraTotal";
		$data['total_records'] = $total_records = $this->Common_model->get_single_value($sql);
		
		$extraFilter .= " AND (c.date_added >= '$todayStartDate' AND c.date_added <= '$todayEndDate') ";
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		$sql = "SELECT count(*) as value from jurys_inn_crm as c WHERE 1 $extraFilter";
		$data['todays_records'] = $todays_records = $this->Common_model->get_single_value($sql);
		
		$sql = "SELECT count(*) as counter, c.c_disposition from jurys_inn_crm as c WHERE 1 $extraFilter GROUP BY c.c_disposition";
		$data['dispoisition_records'] = $todays_records = $this->Common_model->get_query_result_array($sql);

		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data['main_category'] = $this->disposition_Main_Category('data');		
		$data['sub_category'] = $this->disposition_Sub_Category('','data','N');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data["aside_template"] = "jurys_inn/aside.php";
		$data["content_template"] = "jurys_inn/jurys_inn_dashboard.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function dashboard_analytics()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
			
		$extraFilter = ""; $extraTotal = "";
		$todayStartDate = CurrDate()." 00:00:00"; $todayEndDate = CurrDate()." 23:59:59";
		if(!empty($this->input->get('start')))
		{ 
			$todayStartDate = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$todayEndDate = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";			
		}		
		
		if($role_dir == "agent")
		{
			$extraFilter .= " AND (c.added_by = '$current_user') ";
			$extraTotal .= " AND (c.added_by = '$current_user') ";
		}
		
		$extraFilter .= " AND (c.date_added >= '$todayStartDate' AND c.date_added <= '$todayEndDate') ";
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		$sql = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from jurys_inn_crm as c LEFT JOIN signin as s ON s.id = c.added_by 
		        WHERE 1 $extraFilter ORDER by c.cid DESC";
		$data['crm_records'] = $crm_records = $this->Common_model->get_query_result_array($sql);
		
		$data['total_submission'] = !empty($crm_records) ? count($crm_records) : '0';
		
		$report = array();
		$report['disposition'] = $records_counters_disp = array_count_values(array_column($crm_records, 'c_disposition'));
		$report['added_by'] = $records_counters_added_by = array_count_values(array_column($crm_records, 'added_by_name'));
		$data['reports'] = $report;
		
		//echo "<pre>".print_r($crm_records_counters_added_by, 1) ."</pre>"; die();
		
		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data['main_category'] = $this->disposition_Main_Category('data');		
		$data['sub_category'] = $this->disposition_Sub_Category('','data','N');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data["aside_template"] = "jurys_inn/aside.php";
		$data["content_template"] = "jurys_inn/jurys_inn_dashboard_analytics.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	public function newCustomer()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['currentDate'] = $currentDate = CurrDate();
		$data['crmid'] = $this->generate_crm_id();
		$data['main_category'] = $this->disposition_Main_Category('data');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data["aside_template"] = "jurys_inn/aside.php";
		$data["content_template"] = "jurys_inn/jurys_inn_form.php";				
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function updateCustomer()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['crmid'] = $crmid = $this->uri->segment(3);
		$data["crm_details"] = $this->jurys_inn_record_details($crmid);
		$data['main_category'] = $this->disposition_Main_Category('data');
		$data['sub_category'] = $this->disposition_Sub_Category('', 'data', 'N');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data['jurysCaseLogs'] = $jurysCaseLogs = $this->jurys_inn_logs_record_details($crmid);	
		$data["aside_template"] = "jurys_inn/aside.php";
		$data["content_template"] = "jurys_inn/jurys_inn_form_update.php";				
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function CustomerList()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['main_category'] = $this->disposition_Main_Category('data');
		$data['sub_category'] = $this->disposition_Sub_Category('','data','N');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data["aside_template"] = "jurys_inn/aside.php";
		$data["content_template"] = "jurys_inn/jurys_inn_form_list.php";

		$extraFilter = ""; $extraLimit = " LIMIT 500";

		// FILTER DATE CHECK 
		$from_date = CurrMySqlDate();
		$to_date = CurrMySqlDate();
		if(!empty($this->input->get('search_from_date')))
		{ 
			$from_date = date('Y-m-d',strtotime($this->input->get('search_from_date'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('search_to_date'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
			$extraLimit = "";
		}
		
		// FILTER EXTRA CHECK
		$call_type = $this->input->get('search_call_type');
		if(!empty($call_type) && $call_type != "0")
		{ 
			$extraFilter .= " AND (c.c_disposition = '$call_type') ";
			$extraLimit = "";
		}
		
		if($is_role_dir == "agent")
		{
			$extraFilter .= " AND (c.added_by = '$current_user') ";
		}
				
		$data['call_type'] = $call_type;
		$data['from_date'] = date('Y-m-d',strtotime($from_date));
		$data['to_date'] = date('Y-m-d',strtotime($to_date));
		
		$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from jurys_inn_crm as c LEFT JOIN signin as s ON s.id = c.added_by 
		            WHERE 1 $extraFilter ORDER by c.cid DESC $extraLimit";
		$data['crm_list'] = $querycase = $this->Common_model->get_query_result_array($sqlcase);
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function customerSearch()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['main_category'] = $this->disposition_Main_Category('data');
		$data['sub_category'] = $this->disposition_Sub_Category('','data','N');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data["aside_template"] = "jurys_inn/aside.php";
		$data["content_template"] = "jurys_inn/jurys_inn_form_search.php";

		$search_crm = "";
		if(!empty($this->input->get('search_crm')))
		{ 
			$search_crm = $this->input->get('search_crm');
			$extraFilter .= " AND c.crm_id = '$search_crm' ";
		}
		
		$search_name = "";
		if(!empty($this->input->get('search_name')))
		{ 
			$search_name = $this->input->get('search_name');
			//$extraFilter .= " AND (c.c_fname LIKE '%$search_name%' OR c.c_lname LIKE '%$search_name%') ";
		}
		
		$search_phone = "";
		if(!empty($this->input->get('search_phone')))
		{ 
			$search_phone = $this->input->get('search_phone');
			//$extraFilter .= " AND c.c_phone_no = '$search_phone' ";
		}
		
		$search_reservation = "";
		if(!empty($this->input->get('search_reservation')))
		{ 
			$search_reservation = $this->input->get('search_reservation');
			$extraFilter .= " AND c.c_reservation_no = '$search_reservation' ";
		}
		
		$data['crm_list'] = NULL;		
		$data['search_crm'] = $search_crm;
		$data['search_name'] = $search_name;
		$data['search_phone'] = $search_phone;
		$data['search_reservation'] = $search_reservation;
		
		
		if($search_crm != "" || $search_phone != "" || $search_name != "" || $search_reservation != "")
		{
			$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from jurys_inn_crm as c LEFT JOIN signin as s ON s.id = c.added_by 
		                 WHERE 1 $extraFilter";
			$data['crm_list'] = $querycase = $this->Common_model->get_query_result_array($sqlcase);
		}
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	
	public function CustomerReport()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$from_date = CurrMySqlDate();
		$to_date = CurrMySqlDate();
		$data['from_date'] = date('Y-m-d',strtotime($from_date));
		$data['to_date'] = date('Y-m-d',strtotime($to_date));
		
		$data['main_category'] = $this->disposition_Main_Category('data');
		$data['sub_category'] = $this->disposition_Sub_Category('data');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data["aside_template"] = "jurys_inn/aside.php";
		$data["content_template"] = "jurys_inn/jurys_inn_form_reports.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function jurys_logs_list()
	{
		$cid = $this->uri->segment(3);
		$data['main_category'] = $this->disposition_Main_Category('data');
		$data['sub_category'] = $this->disposition_Sub_Category('', 'data', 'N');
		$data['call_queue'] = $this->disposition_Call_Queue('data');
		$data['jurysCase'] = NULL; 
		if($cid != ""){
			$data['jurysCase'] = $jurysCase = $this->jurys_inn_logs_record_details($cid);			
		}
		$this->load->view('jurys_inn/jurys_inn_form_logs',$data);
	}
	
	
	public function jurys_inn_record_details($cid)
	{
		$sql = "SELECT c.* from jurys_inn_crm as c WHERE c.crm_id = '$cid'";
		$jurysCase = $this->Common_model->get_query_row_array($sql);
		return $jurysCase;
	}
	
	public function jurys_inn_logs_record_details($cid)
	{
		$sql = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from jurys_inn_crm_logs as c 
			    LEFT JOIN signin as s ON s.id = c.cl_added_by  WHERE c.crm_id = '$cid' ORDER by c.lid ASC";
		$jurysCase = $this->Common_model->get_query_result_array($sql);
		return $jurysCase;
	}
	
	
	//--------- CRM JURYS DISPOSITON CATEGORY 
	
	public function submit_jurys_inn()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$crm_date = $this->input->post('c_date');
		$time_interval = $this->input->post('time_interval');
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_disposition_sub = $this->input->post('cl_disposition_sub');
		$cl_comments = $this->input->post('cl_comments');
		
		// CALL DETAILS
		$c_fname            = ""; 
		$c_phone_no         = "";
		$c_date             = "";
		//$c_fname          = $this->input->post('c_fname');
		//$c_phone_no       = $this->input->post('c_phone_no');
		$c_reservation_no   = $this->input->post('c_reservation_no');
		if(!empty($crm_date)){ $c_date = date('Y-m-d', strtotime($crm_date)); }
		
		$c_outbound         = $this->input->post('c_outbound');
		$c_outbound_reason  = $this->input->post('c_outbound_reason');
		$c_call             = $this->input->post('timer_start');
		$c_hold             = $this->input->post('c_hold');
		$c_holdtime         = $this->input->post('c_holdtime');
		$c_hold_reason      = $this->input->post('c_hold_reason');
		$c_issue            = $this->input->post('c_issue');
		$c_issue_resolution = $this->input->post('c_issue_resolution');
		$c_call_queue       = $this->input->post('c_call_queue');
		$c_reasons       = $this->input->post('c_reasons');
				
		$c_lob                  = $this->input->post('c_lob');
		$c_transaction          = $this->input->post('c_transaction');
		$c_arrival              = $this->input->post('c_arrival');
		$c_departure            = $this->input->post('c_departure');
		$c_what_customer        = $this->input->post('c_what_customer');
		$c_customer_comments    = $this->input->post('c_customer_comments');
		$c_access_mindfaq       = $this->input->post('c_access_mindfaq');
		$c_call_complexity      = $this->input->post('c_call_complexity');
		
		$flag = "error";
		
		// CALCULATE AHT
		$explodetime = explode(':', $c_call);
		$call_seconds = sprintf('%02d', ($explodetime[0] * 3600)) + sprintf('%02d', ($explodetime[1] * 60)) + sprintf('%02d', $explodetime[2]);
		$explodetime = explode(':', $c_holdtime);
		$hold_seconds = ($explodetime[0] * 3600) + ($explodetime[1] * 60) + $explodetime[2];
		$total_seconds = $call_seconds + $hold_seconds;
		$hours = floor($total_seconds / 3600);
		$minutes = floor(($total_seconds / 60) % 60);
		$seconds = $total_seconds % 60;
		$call_aht = sprintf('%02d', $hours) .":" .sprintf('%02d', $minutes) .":" .sprintf('%02d', $seconds);
		$case_array = [
			'c_date' => $c_date,
			'c_fname' => $c_fname,
			'c_phone_no' => $c_phone_no,
			'c_reservation_no' => $c_reservation_no,
			'c_outbound' => $c_outbound,
			'c_outbound_reason' => $c_outbound_reason,
			'c_issue' => $c_issue,
			'c_issue_resolution' => $c_issue_resolution,
			'c_disposition' => $cl_disposition,
			'c_disposition_sub' => $cl_disposition_sub,
			'c_call_queue' => $c_call_queue,
			'c_lob' => $c_lob,
			'c_transaction' => $c_transaction,
			'c_what_customer' => $c_what_customer,
			'c_customer_comments' => $c_customer_comments,
			'c_access_mindfaq' => $c_access_mindfaq,
			'c_call_complexity' => $c_call_complexity,
		];
		if(!empty($c_arrival)){ $case_array += [ 'c_arrival' => date('Y-m-d', strtotime($c_arrival)) ]; }
		if(!empty($c_departure)){ $case_array += [ 'c_departure' => date('Y-m-d', strtotime($c_departure)) ]; }
				
		$sqlcheck = "SELECT count(*) as value from jurys_inn_crm WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{			
			$this->db->where('crm_id', $crm_id);
			$this->db->update('jurys_inn_crm', $case_array);
			$flag = "update";
		} 
		else {
			$case_array += [ 'crm_id' => $crm_id ];
			$case_array += [ 'c_hold' => $c_hold ];
			$case_array += [ 'c_hold_time' => $c_holdtime ];
			$case_array += [ 'c_hold_reason' => $c_hold_reason ];
			$case_array += [ 'c_reasons' => $c_reasons ];
			$case_array += [ 'c_call' => $c_call ];
			$case_array += [ 'c_call_aht' => $call_aht ];
			$case_array += [ 'added_by' => $current_user ];
			$case_array += [ 'date_added' => CurrMySqlDate() ];
			$case_array += [ 'date_added_local' => GetLocalTime() ];
			$case_array += [ 'logs' => get_logs() ];
			data_inserter('jurys_inn_crm', $case_array);			
			$flag = "insert";
		}
		
		// UPDATE LOGS
		$this->jurys_update_logs($crm_id, $cl_disposition, $cl_disposition_sub, $cl_comments, $time_interval);
		
		if($flag=="insert"){ redirect(base_url()."jurys_inn/newCustomer"); }
		if($flag=="update"){ redirect(base_url()."jurys_inn/updateCustomer/".$crm_id); }
		if($flag=="error"){ redirect(base_url()."jurys_inn/newCustomer"); }
	}
	
	
	
	//--------- CRM JURYS INN LOGS
	
	public function jurys_update_logs($crmid, $disposition='', $dispositionSub = '', $comments='', $interval = '')
	{
		$logs_array = [
		    'crm_id' => $crmid,
			'cl_disposition' => $disposition,
			'cl_disposition_subtype' => $dispositionSub,
			'cl_comments' => $comments,
			'cl_interval' => $interval,
			'cl_type' => $type,
			'cl_added_by' => get_user_id(),
			'cl_date_added' => CurrMySqlDate(),
			'cl_date_added_local' => GetLocalTime(),
			'cl_logs' => get_logs()
		];
		if(!empty($interval)){ $logs_array += [ 'cl_interval' => $interval ]; } 
		data_inserter('jurys_inn_crm_logs', $logs_array);		
	}
	
	public function jurys_entry_delete()
	{
		$crmdeletID = $this->input->get('crmid');
		if(!empty($crmdeletID))
		{
			$sqlcheck = "SELECT count(*) as value from jurys_inn_crm WHERE crm_id = '$crmdeletID'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0)
			{			
				$this->db->where('crm_id', $crmdeletID);
				$this->db->delete('jurys_inn_crm');
				
				$this->db->where('crm_id', $crmdeletID);
				$this->db->delete('jurys_inn_crm_logs');
				echo "DELETED";
				
			} else {
				
				echo "NOT FOUND";
			}
			
		} else {
			echo "INVALID";
		}
	}
	
	
	
	//--------- CRM JURYS DISPOSITON CATEGORY 
	
	public function disposition_Call_Queue($resultType = '')
	{
		if($resultType == ""){ $resultType = $this->uri->segment(3); }
		if($resultType == ""){ $resultType = 'data'; }
		
		$main_category = array( 
			"CROYDON" => "Jurys Inn Croydon",
			"WATFORD" => "Jurys Inn Watford",
			"ABERDEEN" => "Jurys inn Aberdeen",
			"ABERDEENAIR" => "Jurys Inn Aberdeen Airport",
			"EDINBURGH" => "Jurys Inn Edinburgh",
			"GLASGOW" => "Jurys Inn Glasgow",
			"BELFAST" => "Jurys Inn Belfast",
			"INVERNESS" => "Jurys Inn Inverness",
			"BRADFORD" => "Jurys Inn Bradford",
			"MANCHESTOR" => "Jurys Inn Manchester",
			"NEWCASTLE" => "Jurys Inn Newcastle",
			"GATESHEAD" => "Jurys Inn Newcastle Gateshead",
			"LEEDS" => "Jurys Inn Leeds",
			"LIVERPOOL" => "Jurys Inn Liverpool",
			"MIDDLESBROUGH" => "Jurys Inn Middlesbrough",
			"KEYNES" => "Jurys Inn Milton Keynes",
			"NOTTINGHAM" => "Jurys Inn Nottingham",
			"SHEFFIELD" => "Jurys Inn Sheffield",
			"BIRMINGHAM" => "Jurys Inn Birmingham",
			"DERBY" => "Jurys Inn Derby",
			"MIDLANDSAIR" => "Jurys Inn East Midlands Airport",
			"OXFORD" => "Jurys Inn Oxford",
			"HINCKLEY" => "Jurys Inn Hinckley Island",
			"CHELTENHAM" => "Jurys Inn Cheltenham",
			"BRIGHTON" => "Jurys Inn Brighton",
			"WATERFRONT" => "Jurys Inn Brighton Waterfront",
			"SOUTHAMPTON" => "Jurys Inn Southampton",
			"SWINDON" => "Jurys Inn Swindon",
			"EXETER" => "Jurys Inn Exeter",
			"PLYMOUTH" => "Jurys Inn Plymouth",
			"CARDIFF" => "Jurys Inn Cardiff",
			"CHRISTCHURCH" => "Jurys Inn Christchurch",
			"PARNELL" => "Jurys Inn Parnell Street",
			"GALWAY" => "Jurys Inn Galway",
			"CORK" => "Jurys Inn Cork",
			"LEOMURRAYFIELD" => "Leonardo Hotel Edinburgh Murrayfield",
			"LEOEDINBURGH" => "Leonardo Boutique Hotel Edinburgh City",
			"LEOGLASGOWWEST" => "Leonardo Inn Hotel Glasgow West End",
			"LEOHAYMARKET" => "Leonardo Royal Hotel Edinburgh Haymarket",
			"LEOABERDEEN" => "Leonardo Inn Hotel Aberdeen Airport",
			"LEOHUNTINGTOWER" => "Leonardo Boutique Hotel Huntingtower Perth",
			"LEOSOUTHAMPTON" => "Leonardo Royal Hotel Southampton Grand Harbour",
			"LEOMANCHESTOR" => "The Midland Manchester",
			"LEOHEATHROW" => "Leonardo Hotel London Heathrow Airport",
			"LEOLONDON" => "Leonardo Royal Hotel London City",
			"LEOTOWERBRIDGE" => "Leonardo Royal Hotel London Towerbridge",
			"LEOROYAL" => "Leonardo Royal Hotel London St Pauls",
			"LEOHOLBORN" => "Jurys Inn London Holborn",
		);
		
		if($resultType == 'json'){ echo json_encode($main_category); }
		if($resultType == 'data'){ return $main_category; }
	}
	
	public function disposition_Main_Category($resultType = '')
	{
		if($resultType == ""){ $resultType = $this->uri->segment(3); }
		if($resultType == ""){ $resultType = 'data'; }
		
		$main_category = array( 
			"AMD" => "Ammendment",
			"AVL" => "Availability Check",
			"BEC" => "B.com / Expedia Call",
			"CNC" => "Cancellation",
			"CAR" => "Car Parking/Directions",
			"COM" => "Complaint",
			"IHG" => "In-House Guest",
			"REC" => "Reception",
			"RIP" => "Reception (ie. Invoice, Lost Property)",
			"REQ" => "Reservation Requests (ie. Early Check-in, late check-out etc)",
			"RES" => "Restaurant",
			"REW" => "Rewards/Voucher",
			"GHO" => "Ghost Call", 
			"DIS" => "Disconnected",
			"FLC" => "Failed Calls",
			"IVR" => "IVR Cancellation",
		);
		
		if($resultType == 'json'){ echo json_encode($main_category); }
		if($resultType == 'data'){ return $main_category; }
	}
	
	public function disposition_Sub_Category($subType = '', $resultType = '' ,$type = 'URL')
	{
		if($resultType == ""){ $resultType = $this->uri->segment(4); }
		if($resultType == ""){ $resultType = 'data'; }
		
		if($subType == ""){ $subType = $this->uri->segment(3); }
		if($type == 'N'){ $subType = ''; }
		
		$sub_category = array( 
			"AMD" => array( 
				"AMD1" => "Amend reservation/booking date (customer)", 
				"AMD2" => "Amend reservation/booking date (3rd Party)", 
				"AMD3" => "Update Information (customer)", 
				"AMD4" => "Update Information (3rd Party)",
			),
			"AVL" => array( 
				"AVL1" => "General enquiry", 
				"AVL2" => "Group booking (Meeting & Events)", 
				"AVL3" => "Check availability", 
				"AVL4" => "Confirmation enquiry (online error while booking a reservation)",
				"AVL5" => "Confirmation of booking/reservation",
				"AVL6" => "Confirmation for cancelled booking/reservation (customer)",
				"AVL7" => "Confirmation for cancelled booking/reservation (3rd Party)",
			),
			"BEC" => array(),
			"CNC" => array( 
				"CNC1" => "Request to cancel (customer)", 
				"CNC2" => "Request to cancel (3rd Party)", 
				"CNC3" => "Enquiring about Cancellation Policy", 
				"CNC4" => "Request to cancel duplicate booking/reservation (customer)",
			),
			"CAR" => array(),
			"COM" => array(),
			"IHG" => array(),
			"REC" => array(
				"REC1" => "Refund (customer)",
				"REC2" => "Refund (3rd Party)",
				"REC3" => "Invoice Request",
			),
			"RIP" => array(),
			"REQ" => array(),
			"RES" => array(),
			"REW" => array(),
			"GHO" => array(),
			"DIS" => array(),
			"FLC" => array(),
			"IVR" => array(),
		);
		
		if($resultType == 'json'){ 
			if(!empty($subType)){ echo json_encode($sub_category[$subType], JSON_UNESCAPED_SLASHES); } 
			else { echo json_encode($sub_category, JSON_UNESCAPED_SLASHES); } 
		}
		
		if($resultType == 'data'){ 
			if(!empty($subType)){ return $sub_category[$subType]; } 
			else { return $sub_category; } 
		}
	}
	
	
	
	///===================== EXCEL REPORT =================================//
	
	public function generate_jurys_inn_reports($from_date ='', $to_date='', $call_type='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		// FILTER DATE CHECK
		$from_date = CurrMySqlDate();
		$to_date = CurrMySqlDate();
		$extraFilter = "";
		if(!empty($this->input->get('start')))
		{ 
			$from_date = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
		}
		
		// FILTER EXTRA CHECK
		$call_type = $this->input->get('calltype');
		if(!empty($call_type) && $call_type != "0")
		{ 
			$extraFilter .= " AND (c.c_disposition = '$call_type') ";
		}
		
		$main_category = $this->disposition_Main_Category('data');
		$sub_category = $this->disposition_Sub_Category('', 'data', 'N');
		$call_queue = $this->disposition_Call_Queue('data');
		$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name, l.cl_comments from jurys_inn_crm as c 
		            LEFT JOIN signin as s ON s.id = c.added_by 
					LEFT JOIN jurys_inn_crm_logs as l ON l.crm_id = c.crm_id 
					AND l.lid = (SELECT MAX(l2.lid) FROM jurys_inn_crm_logs as l2 WHERE l2.crm_id = c.crm_id)
					WHERE 1 $extraFilter";
		$crm_list = $this->Common_model->get_query_result_array($sqlcase);
		
		$title = "JURYS INN";
		$sheet_title = "JURYS INN - CUSTOMER RECORDS (" .date('Y-m-d',strtotime($from_date)) ." - " .date('Y-m-d',strtotime($to_date)).")";
		$file_name = "Jurys_Inn_Records_".date('Y-m-d',strtotime($from_date));
		
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AC1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true);
		$objWorksheet->getColumnDimension('K')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);
		$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		$objWorksheet->getColumnDimension('W')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);		
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);		
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);		
		//$objWorksheet->getColumnDimension('AA')->setAutoSize(true);		
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);		
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);		
		
		$objWorksheet->getColumnDimension('L')->setWidth('50');
		$objWorksheet->getColumnDimension('N')->setWidth('30');
		$objWorksheet->getColumnDimension('P')->setWidth('50');
		$objWorksheet->getColumnDimension('AA')->setWidth('75');
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:S1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $sheet_title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "CRM ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Call Type");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Call Sub Type");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Call AHT");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Talk Time");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Hold Time");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Call Queue");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Reservation No");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Outbound");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Reason for Outbound");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "No of Hold");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Reason for Hold");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Issue Resolved");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Resolution Provided");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "LOB");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Transaction Type");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Arrival Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Departure Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "What does the customer want?");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Customer comments on resolution,policies");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Accessed MindFAQ?");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Call Complexity");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Added By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date Added");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Comments");
		
			
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{	
			$sub_type = ''; $callQueue = ""; $callArrival = ""; $callDeparture= "";
			if(!empty($wv['c_disposition_sub'])){ $sub_type = $sub_category[$wv['c_disposition']][$wv['c_disposition_sub']]; }
			if(!empty($wv["c_call_queue"])){ $callQueue = !empty($call_queue[$wv['c_call_queue']]) ? $call_queue[$wv['c_call_queue']] : ""; }
			if(!empty($wv["c_arrival"])){ $callArrival = !empty($wv['c_arrival']) ? $wv['c_arrival'] : ""; }
			if(!empty($wv["c_departure"])){ $callDeparture = !empty($wv['c_departure']) ? $wv['c_departure'] : ""; }
			
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["crm_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $main_category[$wv['c_disposition']]);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $sub_type);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_call_aht"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_call"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_hold_time"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $callQueue);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_reservation_no"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_outbound"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_outbound_reason"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_hold"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_hold_reason"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_issue"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_issue_resolution"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_lob"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_transaction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $callArrival);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $callDeparture);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_what_customer"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_customer_comments"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_access_mindfaq"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_call_complexity"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["added_by_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added"])));
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["cl_comments"]);
			$i++;			
		}
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:AC'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	
	
	//==========================================================================================
	///=========================== JURYS INN  ================================///
	
	public function reports_jurys_inn_users()
	{
		$sql = "SELECT GROUP_CONCAT(user_id) as value from info_assign_client WHERE client_id = '124'";
		$user_ids = $this->Common_model->get_single_value($sql);
		$access_ids = $user_ids;
		return $access_ids;
	}

    public function reports_visitors()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
			$selected_fusion = $this->input->get('f');
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		$data['selected_fusion'] = $selected_fusion;
		
		
		$data['reportType'] = $reportType = $this->uri->segment(3);
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_jurys_inn_users();
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			$sql_visitor = "SELECT jury.*, CONCAT(s.fname, ' ', s.lname) as full_name,
					d.shname as department, r.name as designation, 
					CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor from jurysinn_search as jury
					INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
					LEFT JOIN department as d ON d.id = s.dept_id
					LEFT JOIN role as r ON r.id = s.role_id
					LEFT JOIN signin as sp ON sp.id = s.assigned_to
					WHERE 
					jury.entry_date >= '$start_date_full' 
					AND jury.entry_date <= '$end_date_full' AND s.id IN ($jurys_inn_users)";
			$visitor_query = $this->Common_model->get_query_result_array($sql_visitor);
			
			//$data['visitors'][$i]['data'] = $visitor_query;
			$data['visitors'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['visitors'][$i]['year'] = $selected_year;
			
			if($reportType == "monthly" || $reportType == "all"){				
			for($j=1;$j<=$total_days;$j++)
			{
				$currentDay = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
				$startDay = $currentDay ." " .$time_start;
				$endDay = $currentDay ." " .$time_end;
				
				$visitor_day_query = array_filter($visitor_query, function($n) use ($startDay, $endDay){
					if($n['entry_date'] >= $startDay && $n['entry_date'] <= $endDay){
						return $n;
					}
				});
				//$data['visitors_daily'][$i][$currentDay]['counters']['data'] = $visitor_day_query;
				$data['visitors_daily'][$i][$currentDay]['counters']['date'] = $currentDay;
			    $data['visitors_daily'][$i][$currentDay]['counters']['count'] = count($visitor_day_query);
			}
			}
			
			
			//========================= GET USERWISE VISITORS =================================//
			
			$sql_users = "SELECT jury.fusion_id, count(jury.id) as total_visits, CONCAT(s.fname, ' ', s.lname) as full_name,
						d.shname as department, r.name as designation, CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor 
						from jurysinn_search as jury
						INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
						LEFT JOIN department as d ON d.id = s.dept_id
						LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN signin as sp ON sp.id = s.assigned_to
						WHERE 
						jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
						AND s.id IN ($jurys_inn_users)
						group by jury.fusion_id 
						order by total_visits DESC LIMIT 25";
			$query_users = $this->Common_model->get_query_result_array($sql_users);
			
			
			//========================= GET FEEDBACK =================================//
			$sql_dislike = "SELECT count(jury.id) as value from jurysinn_feedback as jury 
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			                WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							AND jury.feedback_status = 'dislike' AND s.id IN ($jurys_inn_users)";
			$query_dislike = $this->Common_model->get_single_value($sql_dislike);
			
			$sql_like = "SELECT count(jury.id) as value from jurysinn_feedback as jury 
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			                WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							AND jury.feedback_status = 'like'  AND s.id IN ($jurys_inn_users)";
			$query_like = $this->Common_model->get_single_value($sql_like);
			$data['visitors'][$i]['feedback']['like'] = $query_like;
			$data['visitors'][$i]['feedback']['dislike'] = $query_dislike;
			
			$sqlLike = "SELECT count(jury.id) as feedbacks, jury.question_intent FROM jurysinn_feedback as jury
					 INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			         WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full' 
					 AND jury.feedback_status = 'like' AND s.id IN ($jurys_inn_users) 
		             GROUP by jury.question_intent ORDER BY feedbacks DESC";
			$data['visitors'][$i]['feedback']['data']['like'] = $queryLike = $this->Common_model->get_query_result_array($sqlLike);
			
			$sqlDisLike = "SELECT count(jury.id) as feedbacks, jury.question_intent FROM jurysinn_feedback as jury
					 INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			         WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full' 
					 AND jury.feedback_status = 'dislike' AND s.id IN ($jurys_inn_users)  
		             GROUP by jury.question_intent ORDER BY feedbacks DESC";
			$data['visitors'][$i]['feedback']['data']['dislike'] = $queryDisLike = $this->Common_model->get_query_result_array($sqlDisLike);
			
			
			$weekArray = $this->getWeekMonthlyOnly(sprintf('%02d', $i), $selected_year);
			$data['visitors'][$i]['count'] = count($visitor_query);
			$data['visitors'][$i]['weeks'] = count($weekArray);
			$data['visitors'][$i]['weekdates'] = $weekArray;
			$data['visitors'][$i]['users'] = $query_users;
			
			//echo "<pre>".print_r($data['visitors'][$i]['weekdates'], 1) ."</pre>";
			
		}
		
		
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "visitors")
		{
			$this->generate_jurys_inn_reports_visitors_xls($data);
		}
		
		if($this->input->get('ex') == "visitors_users")
		{
			$this->generate_jurys_inn_reports_visitors_users_xls($data);
		}
		
		if($this->input->get('ex') == "visitors_feedback")
		{
			$this->generate_jurys_inn_reports_questions_feedback_xls($data);
		}
		
		
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_js"] = "jurys_inn/jurys_inn_graph_js.php";
		$data["content_template"] = "jurys_inn/jurys_inn_reports_visitors.php";
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	public function reports_questions()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
			$selected_fusion = $this->input->get('f');
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		$data['selected_fusion'] = $selected_fusion;
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_jurys_inn_users();
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		$data['reportType'] = $reportType = $this->uri->segment(3);
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			//========================= GET TOP QUESTIONS =================================//
			$sql_users = "SELECT jury.question_intent, count(jury.fusion_id) as total_users 
							from jurysinn_search as jury
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
							WHERE 
							jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							 AND s.id IN ($jurys_inn_users)
							group by jury.question_intent 
							order by total_users DESC LIMIT 10";
			$query_users = $this->Common_model->get_query_result_array($sql_users);
			
			//$data['search'][$i]['data'] = $query_users;
			$data['search'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['search'][$i]['year'] = $selected_year;
			
			$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
			
			if($reportType == "monthly" || $reportType == "all"){
			$weekCheck = 0;
			foreach($weekArray as $tokenW)
			{
				$currentDay = $tokenW['week_start'];
				$startDay = $tokenW['week_start'] ." " .$time_start;
				$endDay = $tokenW['week_end'] ." " .$time_end;
				
				$sql_Week = "SELECT jury.question_intent, count(jury.fusion_id) as total_users 
							from jurysinn_search as jury
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
							WHERE 
							jury.entry_date >= '$startDay' AND jury.entry_date <= '$endDay'
							AND s.id IN ($jurys_inn_users)
							group by jury.question_intent 
							order by total_users DESC LIMIT 10";
				$query_Week = $this->Common_model->get_query_result_array($sql_Week);
			
				$data['questions'][$i]['weeklyQuestions'][$weekCheck]['data'] = $query_Week;
				$data['questions'][$i]['weeklyQuestions'][$weekCheck]['start'] = $tokenW['week_start'];
				$data['questions'][$i]['weeklyQuestions'][$weekCheck]['end'] = $tokenW['week_end'];
			    $data['questions'][$i]['weeklyQuestions'][$weekCheck]['count'] = count($query_Week);
				
				$weekCheck++;
			}
			
				$data['questions'][$i]['weekcount'] = count($weekArray);
			
			}
			
			$data['search'][$i]['count'] = count($visitor_query);
			$data['search'][$i]['weeks'] = count($weekArray);
			$data['search'][$i]['weekdates'] = $weekArray;
			$data['search'][$i]['questions'] = $query_users;
			
			//echo "<pre>".print_r($data['questions'], 1) ."</pre>";
			
		}
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "questions")
		{
			$this->generate_jurys_inn_reports_questions_xls($data);
		}
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
								   
		$data['colorShades'] = ["#660000", "#CC0000","#FF0000","#FF3333",  "#FF6666", "#FF9933", "#FF9999", "#FFCC99", "#FFCCCC", "#FFE5CC"];
								   
		$data["aside_template"] = "reports/aside.php";
		$data["content_js"] = "jurys_inn/jurys_inn_graph_js.php";
		$data["content_template"] = "jurys_inn/jurys_inn_reports_questions.php";
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	
	public function reports_users()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
			$selected_fusion = $this->input->get('f');
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		$data['selected_fusion'] = $selected_fusion;
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_jurys_inn_users();
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		$data['reportType'] = $reportType = $this->uri->segment(3);
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			//========================= GET USERS QUESTIONS =================================//
			$sql_users = "SELECT jury.fusion_id, count(jury.id) as total_quest, CONCAT(s.fname, ' ', s.lname) as full_name,
						d.shname as department, r.name as designation, CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor 
						from jurysinn_search as jury
						INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
						LEFT JOIN department as d ON d.id = s.dept_id
						LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN signin as sp ON sp.id = s.assigned_to
						WHERE 
						jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
						AND s.id IN ($jurys_inn_users)
						group by jury.fusion_id 
						order by total_quest DESC";
			$query_users = $this->Common_model->get_query_result_array($sql_users);
			
			//$data['search'][$i]['data'] = $query_users;
			$data['search'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['search'][$i]['year'] = $selected_year;
			
			$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);			
			$data['search'][$i]['count'] = count($visitor_query);
			$data['search'][$i]['weeks'] = count($weekArray);
			$data['search'][$i]['weekdates'] = $weekArray;
			$data['search'][$i]['users'] = $query_users;
			
			//echo "<pre>".print_r($data['questions'], 1) ."</pre>";
			
		}
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "allusers")
		{
			$this->generate_jurys_inn_reports_users_xls($data);
		}
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
								   
		$data['colorShades'] = ["#660000", "#CC0000","#FF0000","#FF3333",  "#FF6666", "#FF9933", "#FF9999", "#FFCC99", "#FFCCCC", "#FFE5CC"];
								   
		$data["aside_template"] = "reports/aside.php";
		$data["content_js"] = "jurys_inn/jurys_inn_graph_js.php";
		$data["content_template"] = "jurys_inn/jurys_inn_reports_users.php";
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	//====================== JURYS INN EXCEL EXPORT =============================//
	
	
	public function generate_jurys_inn_reports_visitors_xls($data)
	{
		$excel_Type = "Daily Visitors";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:C1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Visitors");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$title = "Daily Visitors  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(30); 
		$objWorksheet->getColumnDimension('C')->setWidth(30);
		
		$i = round($selected_month);
		$month = $data['visitors'][$i]['month'];
		$year = $data['visitors'][$i]['year'];
		
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_loop = 1; $end_loop = $total_days;
		for($j=$start_loop; $j<=$end_loop; $j++)
		{
			$currentDay = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
			$date_visit = date('d M, Y', strtotime($data['visitors_daily'][$i][$currentDay]['counters']['date']));
			$all_visit = $data['visitors_daily'][$i][$currentDay]['counters']['count'];
					
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $j);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $date_visit);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $all_visit);
			
		}
		
		$c++; $r=0;
		
		$fileImage = "uploads/report_graph/jurysinn_daily_visitors_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E6');        //set image to cell
			$objDrawing->setWidth(400);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function generate_jurys_inn_reports_visitors_users_xls($data)
	{
		$excel_Type = "Top Users";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "User");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Visits");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$title = "Users Visits  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(30); 
		$objWorksheet->getColumnDimension('C')->setWidth(30);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		
		$i = round($selected_month);
		$month = $data['visitors'][$i]['month'];
		$year = $data['visitors'][$i]['year'];
		$users = $data['visitors'][$i]['users'];
		
		$counter=0;
		foreach($users as $token)
		{	
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['total_visits']);
			
		}
		
		$fileImage = "uploads/report_graph/jurysinn_daily_visitors_users_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E6');        //set image to cell
			$objDrawing->setWidth(400);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	public function generate_jurys_inn_reports_questions_feedback_xls($data)
	{
		$excel_Type = "Questions Feedback";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$sqlLike = "SELECT jury.question_intent, GROUP_CONCAT(jury.feedback_status) as feedbacks FROM jurysinn_feedback as jury  WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full' GROUP BY jury.question_intent";
		$queryLike = $this->Common_model->get_query_result_array($sqlLike);
				
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Question");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Likes");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Dislikes");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$title = "Questions Feedback  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(100); 
		$objWorksheet->getColumnDimension('C')->setWidth(15);
		$objWorksheet->getColumnDimension('D')->setWidth(15);
				
		$month = $data['visitors'][$i]['month'];
		$year = $data['visitors'][$i]['year'];
		$users = $data['visitors'][$i]['users'];
		
		$counter=0;
		foreach($queryLike as $token)
		{	
			$feedbackC = explode(',', $token['feedbacks']);
			$likeC = array_filter($feedbackC, function($n){
				if($n == 'like'){ return $n; }
			});
			$no_of_likes = count($likeC);
			$no_of_dislikes = count($feedbackC) - $no_of_likes;
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $no_of_likes);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $no_of_dislikes);
			
		}
		
		$fileImage = "uploads/report_graph/jurysinn_feedback_questions_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E3');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_jurys_inn_users();
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		//========= EXCEL FEEDBACK ================================//
		$sqlLike = "SELECT jury.* FROM jurysinn_feedback as jury
					INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
		             WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full' 
		             AND s.id IN ($jurys_inn_users)
		             ORDER by jury.question_intent, jury.feedback_status ASC";
		$queryLike = $this->Common_model->get_query_result_array($sqlLike);		
		$likedArray = array_filter($queryLike, function ($var) { return (strtolower(trim($var['feedback_status'])) == 'like'); });
		$dislikedArray = array_filter($queryLike, function ($var) { return (strtolower(trim($var['feedback_status'])) == 'dislike'); });
		
		//=========== WORKSHEET 1 - DISLIKED FEEDBACK =====================//
		$excel_Type2 = "Disliked Feedbacks";
		$this->objPHPExcel->createSheet(1);
		$this->objPHPExcel->setActiveSheetIndex(1);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(1);
		$objWorksheet->setTitle($excel_Type2);		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);		
		$r=0; $c = 2; $counter=0;
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Question");
		//$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Answer");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Comments");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Feedback");		
		$title = "Disliked Feedbacks  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet(1)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet(1)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A1')->applyFromArray($headerArray);		
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(65); 
		$objWorksheet->getColumnDimension('C')->setWidth(50);
		$objWorksheet->getColumnDimension('D')->setWidth(15);		
		foreach($dislikedArray as $token)
		{
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			//$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['answer']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['comment']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, ucwords($token['feedback_status']));
		}		
		$highestRow = $this->objPHPExcel->getActiveSheet(1)->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet(1)->getHighestColumn();
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		//=========== WORKSHEET 1 - LIKED FEEDBACK =====================//
		$excel_Type2 = "Liked Feedbacks";
		$this->objPHPExcel->createSheet(2);
		$this->objPHPExcel->setActiveSheetIndex(2);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(2);
		$objWorksheet->setTitle($excel_Type2);		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);		
		$r=0; $c = 2; $counter=0;
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Question");
		//$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Answer");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Comments");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Feedback");		
		$title = "Liked Feedbacks  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(2)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet(2)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet(2)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A1')->applyFromArray($headerArray);		
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(65); 
		$objWorksheet->getColumnDimension('C')->setWidth(50);
		$objWorksheet->getColumnDimension('D')->setWidth(15);		
		foreach($likedArray as $token)
		{
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			//$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['answer']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['comment']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, ucwords($token['feedback_status']));
		}		
		$highestRow = $this->objPHPExcel->getActiveSheet(2)->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet(2)->getHighestColumn();
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);	
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function generate_jurys_inn_reports_questions_xls($data)
	{
		$excel_Type = "Top 10 Questions";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
						
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:C1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Question");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Users");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$title = "Top 10 Questions  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(100); 
		$objWorksheet->getColumnDimension('C')->setWidth(15);
				
		$month = $data['search'][$i]['month'];
		$year = $data['search'][$i]['year'];
		$questions = $data['search'][$i]['questions'];
		
		$counter=0;
		foreach($questions as $token)
		{				
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['total_users']);
			
		}
		
		$weekCheck = 0; $curentWeek = 0;
		foreach($data['search'][$i]['weekdates'] as $tokenW)
		{
			$curentWeek++;
			$currentDay = $tokenW['week_start'];
			$weekDates = date('d M', strtotime($tokenW['week_start'])) ." - " .date('d M Y', strtotime($tokenW['week_end']));
			
			$r=0; $c++;
			$r=0; $c++;
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$c.':C'.$c);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c)->applyFromArray($headerArray);
			$this->objPHPExcel->getActiveSheet()->getRowDimension($c)->setRowHeight(40);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, 'WEEK '.$curentWeek.' ('.$weekDates.')');
			
			$r=0; $c++; $startc = $c;
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#cccccc');
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Question");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Users");
			
			$sl=0; 
			foreach($data['questions'][$i]['weeklyQuestions'][$weekCheck]['data'] as $tokenData)
			{
				$c++; $r=0; $sl++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['question_intent']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['total_users']);
			}
			$weekCheck++;
			
			$fileImage = "uploads/report_graph/jurysinn_weekly_".$weekCheck."_top_questions_img.png";
			if(file_exists($fileImage))
			{
				$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
				$objDrawing->setName('Jurys Inn');        //set name to image
				$objDrawing->setDescription('Jurys Inn'); //set description to image
				$signature = $fileImage;    //Path to signature .jpg file
				$objDrawing->setPath($signature);
				$objDrawing->setOffsetX(25);                       //setOffsetX works properly
				$objDrawing->setOffsetY(10);                       //setOffsetY works properly
				$objDrawing->setCoordinates('E' .$startc);        //set image to cell
				$objDrawing->setWidth(350);                 //set width, height
				$objDrawing->setHeight(250);
				$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
			}
			
		}
		
		
		$fileImage = "uploads/report_graph/jurysinn_monthly_top_questions_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E1');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		for($j=1;$j<$weekCheck;$j++)
		{
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function generate_jurys_inn_reports_users_xls($data)
	{
		$excel_Type = "Questions asked by users";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$full_month  = date('F', strtotime('2019-'.$selected_month .'-01'));
	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:F1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Full Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Questions");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$title = "Questions asked by Users  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(25); 
		$objWorksheet->getColumnDimension('C')->setWidth(40);
		$objWorksheet->getColumnDimension('D')->setWidth(40);
		$objWorksheet->getColumnDimension('E')->setWidth(30);
		$objWorksheet->getColumnDimension('F')->setWidth(20);
		
		$i = round($selected_month);
		$month = $data['search'][$i]['month'];
		$year = $data['search'][$i]['year'];
		$users = $data['search'][$i]['users'];
		
		$counter=0;
		foreach($users as $token)
		{	
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['designation']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['l1_supervisor']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['total_quest']);
			
		}
		
		$fileImage = "uploads/report_graph/jurysinn_users_questions_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('I3');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		
		$fileImage = "uploads/report_graph/jurysinn_users_histogram_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('I22');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$full_month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	public function saveImageOnServer()
	{
		$imgData = $_POST['filData'];
		$imgName = $_POST['fileName'];
		$img = str_replace('data:image/png;base64,', '', $imgData);
		$img = str_replace(' ', '+', $img);
		$fileData = base64_decode($img);		
		if(!empty($imgName))
		{
			$fileName = 'uploads/report_graph/' .$imgName;
			file_put_contents($fileName, $fileData);
		}
	}
	
	
	private function getWeekMonthly($month, $year)
	{
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$startDate = $year."-".$month."-01";
		$endDate   = $year.'-'.$month.'-'.$totalDays;
		$startWeek = date("W", strtotime($startDate));
		$endWeek = date("W", strtotime($endDate));
		$counter = 0; $weekArray = array();
		for($i=$startWeek; $i<=$endWeek; $i++)
		{
			$weekInfo = $this->getWeekInfo($i, $year);
			$weekArray[$counter] = $weekInfo;
			$weekArray[$counter]['week'] = sprintf('%02d',$i);
			$counter++;
		}		
		return $weekArray;
	}
	
	private function getWeekInfo($week, $year)
	{
	  $dto = new DateTime();
	  $ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
	  $ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
	  return $ret;
	}
	
	private function getWeekMonthlyOnly($month, $year)
	{
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$startDate = $year."-".$month."-01";
		$endDate   = $year.'-'.$month.'-'.$totalDays;
		$startWeek = date("W", strtotime($startDate));
		$endWeek = date("W", strtotime($endDate));
		$counter = 0; $weekArray = array();
		for($i=$startWeek; $i<=$endWeek; $i++)
		{
			$weekInfo = $this->getMonthWeekInfo($i, $month, $year);
			$weekArray[$counter] = $weekInfo;
			$weekArray[$counter]['week'] = sprintf('%02d',$i);
			$counter++;
		}		
		return $weekArray;
	}
	
	private function getMonthWeekInfo($week, $month, $year)
	{
	  $dto = new DateTime();
	  $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	  $start_date = $year ."-". $month ."-01";
	  $end_date   = $year ."-". $month ."-" .$total_days;
	  $ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
	  $ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
	  if(date('m', strtotime($ret['week_start'])) < $month){ $ret['week_start'] = $start_date; }
	  if(date('m', strtotime($ret['week_end'])) > $month){ $ret['week_end'] = $end_date; }
	  $ret['start_day'] = date('d', strtotime($ret['week_start']));
	  $ret['end_day'] = date('d', strtotime($ret['week_end']));
	  return $ret;
	}

	
}