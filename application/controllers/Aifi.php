<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH . "/libraries/IMap.php");

class Aifi extends CI_Controller{

	var $emailMasters;
	var $ematCounters;

	public function __construct(){
		parent::__construct();
		$this->load->helper('emat_helper');
		$this->load->model('user_model');
		$this->load->model('aifi_model');
		$this->load->model('ematnew_model');

		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->model('Emat_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();

	}

	public function index()
	{
		// echo "aifi";die;
		global $CI;
		$user_id = get_user_id();
		$ses_fusion_id = get_user_fusion_id();
		$sql="CALL fusion_id_exist_for_aifi_crm_access_proc('$ses_fusion_id')";
		$query = $CI->db->query($sql);
		$query->next_result(); 
		$res = $query->row_array();
		$data=$res['STATUS'];
		// echo $data;die;
		// return  $data;
		if($data=='1' || get_global_access()=='1'){
		redirect(base_url('aifi/dashboard'));
		}
		else{
		redirect(base_url().'home');
		}

	}

	// Creating New Unique ID for Transtion form

	public function generate_unique_id()
	{
		// date_default_timezone_set("Asia/Calcutta");
		$date = date("y-m-d-H-i-s");
		$sql = "SELECT count(*) as value from aifi_transaction_details ORDER by id DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_crm_id = "AF-" .$date."-" .sprintf('%02d', $lastid + 1);
		// echo $new_crm_id;die;
		return $new_crm_id;
	}

	public function dashboard()
	{

			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$ses_dept_id   = get_dept_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
			$current_user  = get_user_id();
			$data["current_user"]     =$current_user;
			$sql="SELECT count(etd.id) as count_data, etd.transaction_type_name, ett.trans_type_name FROM aifi_transaction_details etd left join aifi_transaction_type ett on etd.transaction_type_name=ett.id group by transaction_type_name";
			//echo $sql;
		//	die;
			$data["count_details"]=$this->Common_model->get_query_result_array($sql);

			$sql7="SELECT COUNT(etd.id) AS count_data, ett.fusion_id, UPPER(concat(ett.fname,' ', ett.lname)) as added_by_name FROM aifi_transaction_details etd LEFT JOIN signin ett ON etd.created_by = ett.id GROUP BY etd.created_by";
			$data["user_count_details"]=$this->Common_model->get_query_result_array($sql7);

			$sql1 = "SELECT COUNT(id) as count FROM `aifi_transaction_details` WHERE created_by ='$current_user' AND  `trans_date` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
			 $data["day_details"] = $this->Common_model->get_query_result_array($sql1);
			$sql2 = "SELECT COUNT(id) as count FROM `aifi_transaction_details` WHERE created_by ='$current_user' AND `trans_date` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
			$data["week_details"] = $this->Common_model->get_query_result_array($sql2);
			$sql3 = "SELECT COUNT(id) as count FROM `aifi_transaction_details` WHERE created_by ='$current_user' AND `trans_date` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
			$data["month_details"] = $this->Common_model->get_query_result_array($sql3);

			$sql4 = "SELECT total_time FROM `aifi_transaction_details` WHERE created_by ='$current_user' ";
			 $data["ath_details"] = $this->Common_model->get_query_result_array($sql4);

			$data["is_show_graph"] = 1;
			$data["page_name"] = "Dashboard";
			$data["content_template"] = "home.php";
			$this->load->view('aifi/index.php',$data);
	}





	public function search_details()
	{

		$user_site_id  = get_user_site_id();
		$srole_id      = get_role_id();
		$current_user  = get_user_id();
		$ses_dept_id   = get_dept_id();
		$user_office_id   = get_user_office_id();
		$is_global_access = get_global_access();
		$curDateTime      = CurrMySqlDate();
		$Lfull_name=get_username();
		$LOMid=get_user_omuid();
		// $qSqlcomp = "Select * from aifi_transaction_type where is_active = 1 order by id asc";
		// $data["transaction_type"] = $this->Common_model->get_query_result_array($qSqlcomp);
		$data["transaction_type"] = $this->aifi_model->aifi_transaction_type();
		$extraFilter = ""; //$extraLimit = " LIMIT 500";
		$from_date = $this->input->get('from_date');//date('Y-m-d',strtotime($this->input->get('from_date')));
		$to_date = $this->input->get('to_date');//date('Y-m-d',strtotime($this->input->get('to_date')));
		// FILTER EXTRA CHECK
		$call_type = $this->input->get('transaction_types');
		// print_r($call_type);die;
		$current_user  = get_user_id();
		$data["current_user"]     =$current_user;
		$btn=$this->input->get('search');
		if($btn!=''){
			$fetch_array = array(
				"userid" => $current_user,
				"from_date" => $from_date,
				"to_date" => $to_date,
				"call_type" => $call_type
			);
		$data['crm_list'] = $this->aifi_model->get_aifi_transaction_details($fetch_array);
		$search_date_time=date('Y-m-d H:i:s');
		}else{
			$data['crm_list'] = "";
		}
		//print_r($data['crm_list'] );die;
		$data['transaction_types'] = $call_type;
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['search_time']=$search_date_time;
		$data["content_template"] = "search_details.php";
		$data["content_js"] = "aifi/aifi_js.php";
		$data["page_name"] = "Search Details";
		$this->load->view('aifi/index.php',$data);
	}
	public function new_transaction()
	{
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			$data["current_user"]     =$current_user;
			$generate_unique_id = $this->generate_unique_id();
			$data['crmid'] = $this->generate_unique_id();
			$data['currentDate'] = $currentDate = CurrMySqlDate();
			$data['agent_full_name'] = $current_user;
			$qSqlcomp = "Select * from aifi_transaction_type where is_active = 1 order by id asc";
			$qSqlcomp_store = "Select * from aifi_stores_master where is_active = 1 order by id asc";
			$data["stores_details"] = $this->Common_model->get_query_result_array($qSqlcomp_store);
			$data["transaction_type"] = $this->Common_model->get_query_result_array($qSqlcomp);
			$qSqlcomps = "Select id,fusion_id, CONCAT(fname, ' ', lname) as full_name from signin where id = '$current_user' ";
			$data["content_template"] = "new_transaction.php"; 
			$data["content_js"] = "aifi/aifi_js.php";
			$data["page_name"] = "New Transaction";
			$this->load->view('aifi/index.php',$data);

	}

	// Submited New transaction details according to form

	public function new_transaction_for_plonogram()
	{
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			$data["current_user"]     =$current_user;
			$generate_unique_id = $this->generate_unique_id();
			$data['crmid'] = $this->generate_unique_id();
			$data['currentDate'] = $currentDate = CurrMySqlDate();
			$data['agent_full_name'] = $current_user;
			$qSqlcomp = "Select * from aifi_transaction_type_for_planogram where is_active = 1 order by id asc";
			$qSqlcomp_store = "Select * from aifi_stores_master where is_active = 1 order by id asc";
			$data["transaction_type"] = $this->Common_model->get_query_result_array($qSqlcomp);
			$data["stores_details"] = $this->Common_model->get_query_result_array($qSqlcomp_store);
			$qSqlcomps = "Select id,fusion_id, CONCAT(fname, ' ', lname) as full_name from signin where id = '$current_user' ";
			$data["content_template"] = "new_transaction_for_plonogram_mistake_tracker.php"; 
			$data["content_js"] = "aifi/aifi_js.php";
			$data["page_name"] = "New Transaction";
			$this->load->view('aifi/index.php',$data);

	}
	// Submited New transaction for plonogram details according to form
	public function new_transaction_for_tech_issue_tracker()
	{
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			$data["current_user"]     =$current_user;
			$generate_unique_id = $this->generate_unique_id();
			$data['crmid'] = $this->generate_unique_id();
			$data['currentDate'] = $currentDate = CurrMySqlDate();
			$data['agent_full_name'] = $current_user;
			$qSqlcomp = "Select * from aifi_transaction_type_for_type_of_tech where is_active = 1 order by id asc";
			$data["transaction_type"] = $this->Common_model->get_query_result_array($qSqlcomp);
			$qSqlcomp_store = "Select * from aifi_stores_master where is_active = 1 order by id asc";
			$data["stores_details"] = $this->Common_model->get_query_result_array($qSqlcomp_store);
			$qSqlcomps = "Select id,fusion_id, CONCAT(fname, ' ', lname) as full_name from signin where id = '$current_user' ";
			$data["content_template"] = "new_transaction_for_tech_issues.php"; 
			$data["content_js"] = "aifi/aifi_js.php";
			$data["page_name"] = "New Transaction";
			$this->load->view('aifi/index.php',$data);

	}
	
	public function submit_new_transaction()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$crm_date = $this->input->post('c_date');
		// $ticket_id = $this->input->post('ticket_id');
		// $flight_id = $this->input->post('flight_id');
		// $flight_date = $this->input->post('flight_date');
		// $type = $this->input->post('type');
		$transaction_types = $this->input->post('transaction_types');
		$agent_full_name = $this->input->post('agent_full_name');
		$is_resolved = $this->input->post('is_resolved');
		$source = $this->input->post('source');
		$store_number= $this->input->post('store_number');		
		$outbond_call = $this->input->post('outbond_call');
		$completed_cases = $this->input->post('completed_cases');
		$reason_for_leaving = $this->input->post('reason_for_leaving');
		$hat_link = $this->input->post('hat_link');
		$c_call             = $this->input->post('timer_start');
		$c_hold             = $this->input->post('c_hold');
		$c_holdtime         = $this->input->post('c_holdtime');
		$case_array = [
			'trans_unique_id' => $crm_id,
			'trans_date' => date('Y-m-d H:i:s', strtotime($crm_date)) ,
			// 'trans_ticket_id' => $ticket_id,
			// 'trans_flight_id' => $flight_id,
			// 'trans_flight_date' => $flight_date,
			// 'transaction_type' => $type,
			'transaction_type_name' => $transaction_types,
			'is_resolved' => $is_resolved,
			'source' => $source,
			'store_number' => $store_number,
			'outbound_call' => $outbond_call,
			'completed_cases' => $completed_cases,
			'reason_for_leaving' => $reason_for_leaving,
			'hat_link' => $hat_link,
			'created_by' => $current_user,
			'log' => get_logs()

		];
		// echo "<pre>";
		// print_r($case_array);die;

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


			$case_array += [ 'c_hold' => $c_hold ];
			$case_array += [ 'c_hold_time' => $c_holdtime ];
			$case_array += [ 'c_call' => $c_call ];
			$case_array += [ 'total_time' => $call_aht ];
			//print_r($case_array);
		data_inserter('aifi_transaction_details', $case_array);
		// $this->session->flashdata('message');
		// $data['message'] = 'Successfully store the details!';
		redirect(base_url()."aifi/new_transaction");
	}
	public function submit_new_transaction_for_planogram()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$crm_date = $this->input->post('c_date');
		$transaction_types = $this->input->post('transaction_types');
		$agent_full_name = $this->input->post('agent_full_name');
		$is_resolved = $this->input->post('is_resolved');
		$source = $this->input->post('source');
		$store_number= $this->input->post('store_number');		
		$outbond_call = $this->input->post('outbond_call');
		$reason = $this->input->post('reason');
		$hat_link = $this->input->post('hat_link');
		$c_call             = $this->input->post('timer_start');
		$c_hold             = $this->input->post('c_hold');
		$c_holdtime         = $this->input->post('c_holdtime');
		$case_array = [
			'trans_unique_id' => $crm_id,
			'trans_date' => date('Y-m-d H:i:s', strtotime($crm_date)) ,
			'transaction_type_name' => $transaction_types,
			'is_resolved' => $is_resolved,
			'source' => $source,
			'store_number' => $store_number,
			'outbound_call' => $outbond_call,
			'remarks' => $reason,
			'hat_link' => $hat_link,
			'created_by' => $current_user,
			'log' => get_logs()

		];
		// echo "<pre>";
		// print_r($case_array);die;

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


			$case_array += [ 'c_hold' => $c_hold ];
			$case_array += [ 'c_hold_time' => $c_holdtime ];
			$case_array += [ 'c_call' => $c_call ];
			$case_array += [ 'total_time' => $call_aht ];
			//print_r($case_array);
		data_inserter('aifi_transaction_details_for_planogram', $case_array);
		// $this->session->flashdata('message');
		// $data['message'] = 'Successfully store the details!';
		redirect(base_url()."aifi/new_transaction_for_plonogram");
	}
	public function submit_new_transaction_for_tech()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$crm_date = $this->input->post('c_date');
		$transaction_types = $this->input->post('transaction_types');
		$agent_full_name = $this->input->post('agent_full_name');
		$is_resolved = $this->input->post('is_resolved');
		$source = $this->input->post('source');
		$store_number= $this->input->post('store_number');	
		$outbond_call = $this->input->post('outbond_call');
		$reason = $this->input->post('reason');
		$hat_link = $this->input->post('hat_link');
		$c_call             = $this->input->post('timer_start');
		$c_hold             = $this->input->post('c_hold');
		$c_holdtime         = $this->input->post('c_holdtime');
		$case_array = [
			'trans_unique_id' => $crm_id,
			'trans_date' => date('Y-m-d H:i:s', strtotime($crm_date)) ,
			'transaction_type_name' => $transaction_types,
			'is_resolved' => $is_resolved,
			'source' => $source,
			'store_number' => $store_number,
			'outbound_call' => $outbond_call,
			'remarks' => $reason,
			'hat_link' => $hat_link,
			'created_by' => $current_user,
			'log' => get_logs()

		];
		// echo "<pre>";
		// print_r($case_array);die;

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


			$case_array += [ 'c_hold' => $c_hold ];
			$case_array += [ 'c_hold_time' => $c_holdtime ];
			$case_array += [ 'c_call' => $c_call ];
			$case_array += [ 'total_time' => $call_aht ];
			//print_r($case_array);
		data_inserter('aifi_transaction_details_for_type_of_tech_issues', $case_array);
		// $this->session->flashdata('message');
		// $data['message'] = 'Successfully store the details!';
		redirect(base_url()."aifi/new_transaction_for_tech_issue_tracker");
	}

	public function break_on()
	{
		if(check_logged_in()){


		$current_user = get_user_id();
		$_field_array = array(
			"last_break_on_time" => date("Y-m-d H:i:s"),
			"is_break_on" => 1
		);

		//print_r($_field_array);
		if($this->ematnew_model->check_dialer_logged_in($current_user)===true){
			$this->db->update("ematnew_signin_details",$_field_array,array("userid"=>$current_user));
		}else{
			$_insert_array = array(
					"userid" => $current_user,
					"last_break_on_time" => date("Y-m-d H:i:s"),
					"is_logged_in"=>1,
					"is_break_on" => 1,
					"log" =>get_logs()
				);
				//print_r($_insert_array);
			$_table = "ematnew_signin_details";
			$this->db->insert($_table,$_insert_array);

		}

		//$this->db->update("signin",$_field_array,array("id"=>$current_user));

		//////////LOG////////

		$Lfull_name=get_username();
		$LOMid=get_user_omuid();

		$LogMSG="Others Break Timer on";
		log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );

		//////////


		if($this->ematnew_model->check_dialer_logged_in($current_user)===true) print true;
		else print false;
		}
	}

	public function break_off()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$log=get_logs();
			$currDate=CurrMySqlDate();

			$out_time = $this->ematnew_model->get_break_on_time($current_user);
			$out_time_local = getEstToLocalCurrUser($out_time);
			$in_time_local= getEstToLocalCurrUser($currDate);

			$_insert_array = array(
					"user_id" => $current_user,
					"out_time" => $out_time,
					"out_time_local" => $out_time_local,
					"in_time" => $currDate,
					"in_time_local" => $in_time_local,
					"break_type"=>'Break',
					"log" =>get_logs()
				);
				//print_r($_insert_array);
			$_table = "ematnew_break_details";

			if($this->ematnew_model->check_break_on($current_user)===true)
			{

				$this->db->update("ematnew_signin_details",array("last_break_on_time"=>"","is_break_on" =>0),array("userid"=>$current_user));

				$this->db->insert($_table,$_insert_array);

				//////////LOG////////
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();

				$LogMSG="Others Break Timer off";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
				//////////

				if($this->db->affected_rows() > 0) print true;
				else print false;
			}
			else print false;
		}

	}

		public function break_on_ld()
	{
		if(check_logged_in())
		{

			$current_user = get_user_id();
			$_field_array = array(
					"last_break_on_time_ld" => date("Y-m-d H:i:s"),
					"is_break_on_ld" => 1
				);
			if($this->ematnew_model->check_dialer_logged_in($current_user)===true){
			$this->db->update("ematnew_signin_details",$_field_array,array("userid"=>$current_user));
		}else{
			$_insert_array = array(
					"userid" => $current_user,
					"last_break_on_time_ld" => date("Y-m-d H:i:s"),
					"is_logged_in"=>1,
					"is_break_on_ld" => 1,
					"log" =>get_logs()
				);
			$_table = "ematnew_signin_details";
			$this->db->insert($_table,$_insert_array);

		}
			//$this->db->update("ematnew_signin_details",$_field_array,array("userid"=>$current_user));

			//////////LOG////////

			$Lfull_name=get_username();
			$LOMid=get_user_omuid();

			$LogMSG="Lunch/Dinner Break Timer on";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );

			//////////

			if($this->ematnew_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}

	public function break_off_ld()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$currDate=CurrMySqlDate();
			$log=get_logs();

			$out_time = $this->ematnew_model->get_break_on_time_ld($current_user);
			$out_time_local = getEstToLocalCurrUser($out_time);
			$in_time_local= getEstToLocalCurrUser($currDate);

			$_insert_array = array(
					"user_id" => $current_user,
					"out_time" => $out_time,
					"out_time_local" => $out_time_local,
					"in_time" => $currDate,
					"in_time_local" => $in_time_local,
					"break_type"=>'Lunch',
					"log" => get_logs()
				);

			$_table = "ematnew_break_details";

			if($this->ematnew_model->check_break_on_ld($current_user)===true)
			{

				$this->db->update("ematnew_signin_details",array("last_break_on_time_ld"=>" ","is_break_on_ld" =>0),array("userid"=>$current_user));

				$this->db->insert($_table,$_insert_array);

				if($this->db->affected_rows() > 0) print true;
				else print false;
			}
			else print false;
		}

	}
	public function break_on_coaching()
	{
		if(check_logged_in())
		{

			$current_user = get_user_id();
			$_field_array = array(
								"last_break_on_time_cb" => date("Y-m-d H:i:s"),
								"is_break_on_cb" => 1
							);

				if($this->ematnew_model->check_dialer_logged_in($current_user)===true){
			$this->db->update("ematnew_signin_details",$_field_array,array("userid"=>$current_user));
		}else{
			$_insert_array = array(
					"userid" => $current_user,
					"last_break_on_time_cb" => date("Y-m-d H:i:s"),
					"is_logged_in"=>1,
					"is_break_on_cb" => 1,
					"log" =>get_logs()
				);
			$_table = "ematnew_signin_details";
			$this->db->insert($_table,$_insert_array);

		}

			//////////LOG////////

			$Lfull_name=get_username();
			$LOMid=get_user_omuid();

			$LogMSG="Coaching Break Timer on";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );

			//////////


			if($this->ematnew_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}

	public function break_off_coaching()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$log=get_logs();
			$currDate=CurrMySqlDate();

			$out_time = $this->ematnew_model->get_break_on_time_cb($current_user);
			$out_time_local = getEstToLocalCurrUser($out_time);
			$in_time_local= getEstToLocalCurrUser($currDate);

			$_insert_array = array(
					"user_id" => $current_user,
					"out_time" => $out_time,
					"out_time_local" => $out_time_local,
					"in_time" => $currDate,
					"in_time_local" => $in_time_local,
					"log" => get_logs(),
					"break_type" => 'Available'
				);

			$_table = "ematnew_break_details";

			if($this->ematnew_model->check_break_on_cb($current_user)===true)
			{


				$this->db->update("ematnew_signin_details",array("last_break_on_time_cb"=>" ","is_break_on_cb" =>0),array("userid"=>$current_user));

				$this->db->insert($_table,$_insert_array);

				if($this->db->affected_rows() > 0) print true;
				else print false;
			}
			else print false;
		}

	}


	public function report()
	{

			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			// $qSqlcomp = "Select * from emat_transaction_type where is_active = 1 order by id asc";
			// $data["transaction_type"] = $this->Common_model->get_query_result_array($qSqlcomp);
			$data["transaction_type"] = $this->aifi_model->aifi_transaction_type();
			$data["stores_details"] = $this->aifi_model->aifi_store_details();
			$data["stores_number"] = $this->aifi_model->aifi_store_number_details_for_report();

			$extraFilter = ""; //$extraLimit = " LIMIT 500";
			$from_date = $this->input->get('from_date');//date('Y-m-d',strtotime($this->input->get('from_date')));
			$to_date = $this->input->get('to_date');//date('Y-m-d',strtotime($this->input->get('to_date')));
			// FILTER EXTRA CHECK
			$call_type = $this->input->get('transaction_types');
			$source = $this->input->get('source');
			$s_number = $this->input->get('s_number');
			$resolved = $this->input->get("is_resolved");
			// $type = $this->input->get("ticket_type");
			$fusion_id = $this->input->get("fusion_id");
			// $btn=$this->input->get('search');
			$current_user = get_user_id();
			$data["current_user"] = $current_user;
			$btn=$this->input->get('view_report');

			$page = ($this->input->get('page')) ? $this->input->get('page') : 0;
			// if($page != 0){
				$page_ = round($page/10);
			// }
			$data['page'] = $page_;
			if($btn!=''){
				$fetch_array = array(
					"userid" => $current_user,
					"from_date" => $from_date,
					"to_date" => $to_date,
					"call_type" => $call_type,
					"resolved"  =>$resolved,
					"fusion_id"	=>$fusion_id,
					"source"	=>$source,
					"s_number"	=>$s_number,
					"page"		=>$page

				);
			$data['crm_list'] = $this->aifi_model->report_data_aifi_transaction_details($fetch_array);
			$count_sql = $this->aifi_model->report_data_aifi_transaction_details_total_count($fetch_array);

			// $sqlcount = "SELECT c.* from aifi_transaction_details as c LEFT JOIN signin as s ON s.id = c.created_by WHERE 1 $extraFilter";
			// $count_sql = $this->Common_model->get_query_result_array($sqlcount);

			$total_rows = count($count_sql);
			$last_page = round($total_rows/10);
				$link = array();
			for ($i=1; $i <$last_page ; $i++) {
					$page_row = $i*10; 
					$full_url = str_replace('/femsdev/aifi/', '', $_SERVER['REQUEST_URI']);
					// $gets = explode('&', $full_url);
					// $replace_chck = '&'.$gets[count($gets)-1];
					// $urlll = str_replace($replace_chck,'',$full_url);
				$link[] = $full_url."&page=$page_row";

			}

			$data['links'] = $link;
			$search_date_time=date('Y-m-d H:i:s');

					}else{
						// $data['crm_list'] = "";
					}
			// print_r($data['crm_list']);die;
			$data['transaction_types'] = $call_type;
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['source'] = $source;
			$data['s_number'] = $s_number;
			$data['search_time']=$search_date_time;
			$data['resolved'] = $resolved;
			$data["content_template"] = "report.php";
			$data["content_js"] = "aifi/aifi_js.php";
			$data["page_name"] = "Report";
			$this->load->view('aifi/index.php',$data);
	}
	
	public function report_for_planogram()
	{
			$this->load->library('form_validation');
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
			$data["transaction_type"] = $this->aifi_model->aifi_transaction_type_for_planogram();
			$data["stores_details"] = $this->aifi_model->aifi_store_details();
			$data["stores_number"] = $this->aifi_model->aifi_store_number_details_for_report_planogram();

			$extraFilter = ""; //$extraLimit = " LIMIT 500";
			$from_date = $this->input->get('from_date');//date('Y-m-d',strtotime($this->input->get('from_date')));
			$to_date = $this->input->get('to_date');//date('Y-m-d',strtotime($this->input->get('to_date')));
			// FILTER EXTRA CHECK
			$call_type = $this->input->get('transaction_types');
			$source = $this->input->get('source');
			$s_number = $this->input->get('s_number');
			$resolved = $this->input->get("is_resolved");
			// $type = $this->input->get("ticket_type");
			$fusion_id = $this->input->get("fusion_id");
			$trans_unique_id = $this->input->get("unique_id");
			// $btn=$this->input->get('search');
			$current_user = get_user_id();
			$data["current_user"] = $current_user;
			$btn=$this->input->get('view_report');

			$page = ($this->input->get('page')) ? $this->input->get('page') : 0;
			// if($page != 0){
				$page_ = round($page/10);
			// }
			

			$data['page'] = $page_;
			if($btn!=''){
				$this->form_validation->set_rules('source', 'Source', 'required');
			// $this->form_validation->set_rules('password', 'Password', 'required',
			// 		array('required' => 'You must provide a %s.')
			// );
			// $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
			// $this->form_validation->set_rules('email', 'Email', 'required');

			// if ($this->form_validation->run() == FALSE)
			// {		
			// 		echo "form validation errors";
			// 		$this->load->view('myform');
			// }
			// else{
			// 	echo "true";
			// }
				$fetch_array = array(
					"userid" => $current_user,
					"from_date" => $from_date,
					"to_date" => $to_date,
					"call_type" => $call_type,
					"resolved"  =>$resolved,
					// "type"		=>$type,
					"fusion_id"	=>$fusion_id,
					"unique_id" =>$trans_unique_id,
					"source"	=>$source,
					"s_number"  =>$s_number,
					"page"		=>$page

				);
			$data['crm_list'] = $this->aifi_model->report_data_aifi_transaction_details_for_planogram($fetch_array);
			$count_sql = $this->aifi_model->report_data_aifi_transaction_details_total_count_for_planogram($fetch_array);
			$total_rows = count($count_sql);
			$last_page = round($total_rows/10);
				$link = array();
			for ($i=1; $i <$last_page ; $i++) {
					$page_row = $i*10; 
					$full_url = str_replace('/femsdev/aifi/', '', $_SERVER['REQUEST_URI']);
					// $gets = explode('&', $full_url);
					// $replace_chck = '&'.$gets[count($gets)-1];
					// $urlll = str_replace($replace_chck,'',$full_url);
				$link[] = $full_url."&page=$page_row";

			}

			$data['links'] = $link;
			$search_date_time=date('Y-m-d H:i:s');
					}else{
						$data['crm_list'] = "";
					}
			// print_r($data['crm_list']);die;
			$data['transaction_types'] = $call_type;
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['source'] = $source;
			$data['s_number'] = $s_number;
			$data['search_time']=$search_date_time;
			$data['resolved'] = $resolved;
			$data['unique_id'] = $trans_unique_id;
			$data["content_template"] = "report_for_planogram.php";
			$data["content_js"] = "aifi/aifi_js.php";
			$data["page_name"] = "Report";
			$this->load->view('aifi/index.php',$data);
	}
	public function report_for_tech()
	{

			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
			$data["transaction_type"] = $this->aifi_model->aifi_transaction_type_for_tech();
			$data["stores_details"] = $this->aifi_model->aifi_store_details();
			$data["stores_number"] = $this->aifi_model->aifi_store_number_details_for_report_tech();


			$extraFilter = ""; //$extraLimit = " LIMIT 500";
			$from_date = $this->input->get('from_date');//date('Y-m-d',strtotime($this->input->get('from_date')));
			$to_date = $this->input->get('to_date');//date('Y-m-d',strtotime($this->input->get('to_date')));
			// FILTER EXTRA CHECK
			$call_type = $this->input->get('transaction_types');
			$source = $this->input->get('source');
			$s_number = $this->input->get('s_number');
			$resolved = $this->input->get("is_resolved");
			// $type = $this->input->get("ticket_type");
			$fusion_id = $this->input->get("fusion_id");
			$trans_unique_id = $this->input->get("unique_id");
			// $btn=$this->input->get('search');
			$current_user = get_user_id();
			$data["current_user"] = $current_user;
			$btn=$this->input->get('view_report');

			$page = ($this->input->get('page')) ? $this->input->get('page') : 0;
			// if($page != 0){
				$page_ = round($page/10);
			// }
			$data['page'] = $page_;
			if($btn!=''){
				$fetch_array = array(
					"userid" => $current_user,
					"from_date" => $from_date,
					"to_date" => $to_date,
					"call_type" => $call_type,
					"resolved"  =>$resolved,
					// "type"		=>$type,
					"fusion_id"	=>$fusion_id,
					"unique_id" =>$trans_unique_id,
					"source"	=>$source,
					"s_number"  =>$s_number,
					"page"		=>$page

				);
			$data['crm_list'] = $this->aifi_model->report_data_aifi_transaction_details_for_tech($fetch_array);
			$count_sql = $this->aifi_model->report_data_aifi_transaction_details_total_count_for_tech($fetch_array);
			$total_rows = count($count_sql);
			$last_page = round($total_rows/10);
				$link = array();
			for ($i=1; $i <$last_page ; $i++) {
					$page_row = $i*10; 
					$full_url = str_replace('/femsdev/aifi/', '', $_SERVER['REQUEST_URI']);
					// $gets = explode('&', $full_url);
					// $replace_chck = '&'.$gets[count($gets)-1];
					// $urlll = str_replace($replace_chck,'',$full_url);
				$link[] = $full_url."&page=$page_row";

			}

			$data['links'] = $link;
			$search_date_time=date('Y-m-d H:i:s');
					}else{
						$data['crm_list'] = "";
					}
			// print_r($data['crm_list']);die;
			$data['transaction_types'] = $call_type;
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['source'] = $source;
			$data['s_number'] = $s_number;
			$data['search_time']=$search_date_time;
			$data['resolved'] = $resolved;
			$data['unique_id'] = $trans_unique_id;
			$data["content_template"] = "report_for_tech.php";
			$data["content_js"] = "aifi/aifi_js.php";
			$data["page_name"] = "Report";
			$this->load->view('aifi/index.php',$data);
	}

	public function master_access()
	{
			$sql_note="call aifi_access_master_proc()";
			// echo $sql_note;die;
			$result3 = $this->db->query($sql_note);
			$result3->next_result(); 
			$result=$result3->result_array();
			$data['access_details_show']=$result;
			$data["content_template"] = "master_access_details.php";
			$data["content_js"] = "aifi/aifi_js.php";
			$data["page_name"] = "Report";
			$this->load->view('aifi/index.php',$data);

	}

	public function validate_existest_accessid(){
		if (check_logged_in()) {
            $fusion_id = $this->input->post('fusion_id');
            $qSql = "select fusion_id FROM aifi_access_master where fusion_id='$fusion_id' and status=1 ";
            $fields1 = $this->db->query($qSql);

            $ref_email = $fields1->result();

            if ($fields1->num_rows() > 0) {
                echo "Access already exist";
            } else {
                echo "OK";
            }
        }
	}
	public function access_submit(){
		
		$field_name = array_unique($this->input->post('field_name'));
		// print_r($field_name);die;
		foreach($field_name as $value){
			$date=date('Y-m-d H:i:s');
			$current_user=get_user_id();
			$logs=get_logs();
			$sql="CALL insert_update_aifi_access_proc ('$value','1','$date','$current_user','$logs')";
			$result = $this->db->query($sql);
	}
	redirect($_SERVER['HTTP_REFERER']);
	}
	public function remove_access(){
		$current_user = get_user_id();
		$fusion_id = trim($this->input->post('fusion_id'));
		$date=date('Y-m-d H:i:s');
		$sql="CALL remove_aifi_access ('$fusion_id','$date','$current_user','master')";
		$result = $this->db->query($sql);
	}

	public function update_transaction()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		$data['trans_unique_id'] = $trans_unique_id = $this->uri->segment(3);
		$data["crm_details"] = $this->aifi_record_details($trans_unique_id);
		// echo "<pre>";
	    // print_r($data["crm_details"]);die;
		// $qSqlcomp23 = "SELECT c.* ,concat(s.fname,' ', s.lname) as added_by_name from emat_new_log_details as c LEFT JOIN signin as s ON s.id = c.added_by WHERE c.new_transation_id = '$trans_unique_id' ORDER by c.id DESC";
		// 	$data["log_details"] = $this->Common_model->get_query_result_array($qSqlcomp23);
		$data["log_details"]=$this->aifi_model->get_log_details_for_aifi($trans_unique_id);
		//$data["log_details"] = $this->emat_log_details($trans_unique_id);
		//print_r($data["log_details"]);die;
		// $qSqlcomp = "Select * from emat_transaction_type where is_active = 1 order by id asc";
		// 	$data["transaction_type"] = $this->Common_model->get_query_result_array($qSqlcomp);
		$data["transaction_type"] = $this->aifi_model->aifi_transaction_type();
		// print_r($data["transaction_type"]);die;
		$data["content_template"] = "aifi_form_update.php";				
					
		
		$data["page_name"] = "New Transaction Update";
		$this->load->view('aifi/index.php',$data);
	 
	}
	public function submit_update_transaction()
	{
		// $current_user = get_user_id();
		// $crm_id = $this->input->post('crm_id');
		// //echo $crm_id;
		// $ticket_id = $this->input->post('ticket_id');
		// $flight_id = $this->input->post('flight_id');
		// $crm_id = $this->input->post('crm_id');
		// $flight_date = $this->input->post('flight_date');
		// $type = $this->input->post('type');
		// $transaction_types = $this->input->post('transaction_types');
		// $is_resolved = $this->input->post('is_resolved');
		// $source = $this->input->post('source');
		// $outbond_call = $this->input->post('outbond_call');
		// $remarks = $this->input->post('remarks');
		// $notes = $this->input->post('notes');
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$crm_date = $this->input->post('c_date');
		// $ticket_id = $this->input->post('ticket_id');
		// $flight_id = $this->input->post('flight_id');
		// $flight_date = $this->input->post('flight_date');
		// $type = $this->input->post('type');
		$transaction_types = $this->input->post('transaction_types');
		$agent_full_name = $this->input->post('agent_full_name');
		$is_resolved = $this->input->post('is_resolved');
		$source = $this->input->post('source');
		$outbond_call = $this->input->post('outbond_call');
		$completed_cases = $this->input->post('completed_cases');
		$reason_for_leaving = $this->input->post('reason_for_leaving');
		$hat_link = $this->input->post('hat_link');
		$case_array = [
			'transaction_type' => $transaction_types,
			'transaction_type_name' => $transaction_types,
			'is_resolved' => $is_resolved,
			'source' => $source,
			'outbound_call' => $outbond_call,
			'completed_cases' => $completed_cases,
			'reason_for_leaving' => $reason_for_leaving,
			'hat_link' => $hat_link
			

		];
		//print_r($case_array);die;
			$this->db->where('trans_unique_id', $crm_id);
			$this->db->update('aifi_transaction_details', $case_array);

		$update_log_array = [
			'new_transation_id' => $crm_id,
			'ticket_status' => $is_resolved,
			'completed_cases' => $completed_cases,
			'reason_for_leaving' => $reason_for_leaving,
			'hat_link' => $hat_link,
			'added_by' => $current_user,
			'added_date' => CurrMySqlDate(),
			'logs' => get_logs()
		];

		//print_r($update_log_array);die;
		data_inserter('aifi_log_details', $update_log_array);
		redirect(base_url()."aifi/view_transaction/".$crm_id);
		//redirect(base_url()."emat_new/view_transaction/.$crm_id.");
	}
	public function aifi_record_details($trans_unique_id)
	{
		$view_data_for_particular_one_transaction_id=$this->aifi_model->list_data_for_particular_one_transaction_id($trans_unique_id);
		 return $view_data_for_particular_one_transaction_id->row_array();
	}
	public function emat_log_details($trans_unique_id)
	{
		$sql = "SELECT c.* from emat_transaction_details as c WHERE c.new_transation_id = '$trans_unique_id'";
		//$sql = "SELECT c.* ,concat(s.fname,' ', s.lname) as added_by_name from emat_new_log_details as c LEFT JOIN signin as s ON s.id = c.added_by WHERE c.new_transation_id = '$trans_unique_id' ORDER by c.id DESC ";
		$emat_new = $this->Common_model->get_query_row_array($sql);
		return $emat_new;
	}
	public function view_transaction()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		$data['trans_unique_id'] = $trans_unique_id = $this->uri->segment(3);
		$data["crm_details"] = $this->aifi_record_details($trans_unique_id);
		// echo "<pre>";
		//  print_r($data["crm_details"]);die;
		// $qSqlcomp23 = "SELECT c.* ,concat(s.fname,' ', s.lname) as added_by_name from emat_new_log_details as c LEFT JOIN signin as s ON s.id = c.added_by WHERE c.new_transation_id = '$trans_unique_id' ORDER by c.id DESC";

		// $data["log_details"] = $this->Common_model->get_query_result_array($qSqlcomp23);
		$data["log_details"]=$this->aifi_model->get_log_details_for_aifi($trans_unique_id);
		// echo "<pre>";
		// print_r($data["log_details"]);die;;
		
		$data["content_template"] = "aifi_view_transaction.php";				
	
		$data["page_name"] = "View Transaction Details";
		$this->load->view('aifi/index.php',$data);
	 
	}
	/*public function cb_form_data()
	{
		$current_user = get_user_id();
		$button_cb = $this->input->post('button_cb');
		echo $button_cb;die;
		
		$case_array = [
			'trans_unique_id' => $button_cb
		];

		data_inserter('emat_transaction_details', $case_array);
		redirect(base_url()."emat_new");
	}*/

	public function download_report()
	{
		
		

		// $flight_start_date = $this->input->get("flight_from_date");
		// $flight_end_date = $this->input->get("flight_to_date");

		// $flight_id = $this->input->get("flight_id");
		// $ticket_id = $this->input->get("ticket_id");

		$fusion_id = $this->input->get("fusion_id");
		$from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');
		$resolved = $this->input->get("is_resolved");
		$call_type = $this->input->get('transaction_types');
		$source = $this->input->get('source');
		$current_user = get_user_id();
		$fetch_array = array(
			"userid" => $current_user,
			"from_date" => $from_date,
			"to_date" => $to_date,
			"call_type" => $call_type,
			"resolved"  =>$resolved,
			"fusion_id"	=>$fusion_id,
			"source"	=>$source
		);
		$crm_list = $this->aifi_model->report_data_aifi_transaction_details_for_excel($fetch_array);

		// if(!empty($from_date) && !empty($to_date)){
		// 	$extraFilter .= " AND (date(c.trans_date) >= '$from_date' AND date(c.trans_date) <= '$to_date') ";
		// }

		// if(!empty($flight_start_date) && !empty($flight_end_date)){
		// 	$extraFilter .= " AND (c.trans_flight_date >= '$flight_start_date' AND c.trans_flight_date <= '$flight_end_date') ";
		// }
		// // FILTER EXTRA CHECK
		// $call_type = $this->input->get('transaction_types');
		// $source = $this->input->get('source');

		// if(!empty($call_type) ){
		// 	$extraFilter .= " AND (c.transaction_type_name = '$call_type') ";
		// }
		// if(!empty($flight_id)){
		// 	$extraFilter .= " AND (c.trans_flight_id = '$flight_id')";
		// }
		// if(!empty($ticket_id)){
		// 	$extraFilter .= " AND (c.trans_ticket_id = '$ticket_id')";
		// }
		// if(!empty($source)){
		// 	$extraFilter .= " AND (c.source = '$source')";
		// }
		// if($resolved!=""){
		// 	if($resolved=="n"){
		// 		$resolved=0;
		// 	}
		// 	$extraFilter .= " AND (c.is_resolved = '$resolved')";
		// }
		// if($type!=""){
		// 	if($type=="n"){
		// 		$type=0;
		// 	}
		// 	$extraFilter .= " AND (c.transaction_type = '$type')";
		// }
		// if(!empty($fusion_id)){
		// 	$extraFilter .= " AND (s.fusion_id = '$fusion_id')";
		// }


		// $sqlcase = "SELECT c.*, s.fusion_id as added_id,e.trans_type_name as transaction_type_name, concat(s.fname,' ', s.lname) as added_by_name from aifi_transaction_details as c
		// LEFT JOIN signin as s ON s.id = c.created_by
		// LEFT JOIN aifi_transaction_type as e ON e.id = c.transaction_type_name
		// WHERE 1 $extraFilter ORDER by c.id DESC";

			   
		// $crm_list = $this->Common_model->get_query_result_array($sqlcase);


		//  print_r($crm_list);die();

		$this->generate_report_xls($crm_list);


	}



	public function generate_report_xls($userData) {
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();

		$current_user = get_user_id();
		$user_site_id = get_user_site_id();
		$user_office_id = get_user_office_id();
		$user_oth_office = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir = get_role_dir();
		$get_dept_id = get_dept_id();


		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Report');

		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Q1' . $this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true);
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setWidth('30');
		$objWorksheet->getColumnDimension('I')->setWidth('30');
		$objWorksheet->getColumnDimension('J')->setAutoSize(true);
		$objWorksheet->getColumnDimension('K')->setAutoSize(true);
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);

		$r = 0;
		$c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Type");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Transaction ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "source");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Completed Cases");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Hat Link");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Transaction Type");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Agent Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Agent ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Status");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Hold Count");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "TTT");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "AHT");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Source");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Outbound Call");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Reason For Leaving");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Search date with time");

		$styleArray = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF'),
				'size' => 10
		));


		$headerArray = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '000000'),
				'size' => 14
		));

		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:R1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "Report");
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);


		$this->objPHPExcel->getActiveSheet()->getStyle('A2:R2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:R2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');

		$yesArray = array('font' => array('bold' => true, 'color' => array('rgb' => '05c605'), 'size' => 12));
		$noArray = array('font' => array('bold' => true, 'color' => array('rgb' => 'ec3232'), 'size' => 12));
		$i = 0;

		$currentDate = CurrDate();
		$currentLocalDate = GetLocalDate();
		$currentDateTime = CurrMySqlDate();
		$currentLocalDate = $localDate;
		foreach ($userData as $token) {

			$i++;
			if ($token['is_resolved'] == 1) {
				$status = "Closed";
				
			}elseif ($token['is_resolved'] == 2) {
				$status = "Pending";
			}else{
				$status = "No Action Required";
			}
			$c++;
			$r = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['transaction_type'] == '1' ? "Ticket" : "Email");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['trans_unique_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, date('d - m -Y -H:i:s', strtotime($token['trans_date'])));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['source']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['completed_cases']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['hat_link']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['transaction_type_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['added_by_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['added_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $status);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, ($token['c_hold']==0)?"-":$token['c_hold']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, ($token['c_hold']==0)?"-":$token['c_hold_time']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['total_time']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['source']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['outbound_call'] == '1' ? "Yes":"No");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['reason_for_leaving']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, date('Y-m-d H:i:s'));
		}

		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit();
	}
	//download report for planogram start here
	public function download_report_for_planogram()
	{
		$fusion_id = $this->input->get("fusion_id");
		$from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');
		$resolved = $this->input->get("is_resolved");
		$trans_unique_id = $this->input->get("unique_id");
		$call_type = $this->input->get('transaction_types');
		$source = $this->input->get('source');
		$current_user = get_user_id();
		$extraFilter='';
		$fetch_array = array(
			"userid" => $current_user,
			"from_date" => $from_date,
			"to_date" => $to_date,
			"call_type" => $call_type,
			"resolved"  =>$resolved,
			"fusion_id"	=>$fusion_id,
			"unique_id" =>$trans_unique_id,
			"source"	=>$source
		);
		$crm_list = $this->aifi_model->report_data_aifi_transaction_details_for_planogram_excel($fetch_array);
		$this->generate_report_xls_for_planogram($crm_list);


	}
	public function download_report_for_tech()
	{
		$fusion_id = $this->input->get("fusion_id");
		$from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');
		$resolved = $this->input->get("is_resolved");
		$trans_unique_id = $this->input->get("unique_id");
		$call_type = $this->input->get('transaction_types');
		$source = $this->input->get('source');
		$current_user = get_user_id();
		$extraFilter='';
		$fetch_array = array(
			"userid" => $current_user,
			"from_date" => $from_date,
			"to_date" => $to_date,
			"call_type" => $call_type,
			"resolved"  =>$resolved,
			"fusion_id"	=>$fusion_id,
			"unique_id" =>$trans_unique_id,
			"source"	=>$source
		);
		$crm_list = $this->aifi_model->report_data_aifi_transaction_details_for_tech_excel($fetch_array);
		$this->generate_report_xls_for_tech($crm_list);


	}


	// download report for planogram end here

	public function generate_report_xls_for_planogram($userData) {
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();

		$current_user = get_user_id();
		$user_site_id = get_user_site_id();
		$user_office_id = get_user_office_id();
		$user_oth_office = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir = get_role_dir();
		$get_dept_id = get_dept_id();


		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Report');

		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Q1' . $this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true);
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setWidth('30');
		$objWorksheet->getColumnDimension('I')->setWidth('30');
		$objWorksheet->getColumnDimension('J')->setAutoSize(true);
		$objWorksheet->getColumnDimension('K')->setAutoSize(true);
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);

		$r = 0;
		$c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Type");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Transaction ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "source");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Remarks");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Hat Link");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Transaction Type");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Agent Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Agent ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Status");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Hold Count");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "TTT");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "AHT");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Source");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Outbound Call");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Search date with time");

		$styleArray = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF'),
				'size' => 10
		));


		$headerArray = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '000000'),
				'size' => 14
		));

		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Q1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "Report");
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);


		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');

		$yesArray = array('font' => array('bold' => true, 'color' => array('rgb' => '05c605'), 'size' => 12));
		$noArray = array('font' => array('bold' => true, 'color' => array('rgb' => 'ec3232'), 'size' => 12));
		$i = 0;

		$currentDate = CurrDate();
		$currentLocalDate = GetLocalDate();
		$currentDateTime = CurrMySqlDate();
		$currentLocalDate = $localDate;
		foreach ($userData as $token) {

			$i++;
			if ($token['is_resolved'] == 1) {
				$status = "Closed";
				
			}elseif ($token['is_resolved'] == 2) {
				$status = "Pending";
			}else{
				$status = "No Action Required";
			}
			$c++;
			$r = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['transaction_type'] == '1' ? "Ticket" : "Email");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['trans_unique_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, date('d - m -Y -H:i:s', strtotime($token['trans_date'])));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['source']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['remarks']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['hat_link']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['transaction_type_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['added_by_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['added_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $status);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, ($token['c_hold']==0)?"-":$token['c_hold']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, ($token['c_hold']==0)?"-":$token['c_hold_time']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['total_time']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['source']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['outbound_call'] == '1' ? "Yes":"No");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, date('Y-m-d H:i:s'));
		}

		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit();
	}
	public function generate_report_xls_for_tech($userData) {
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();

		$current_user = get_user_id();
		$user_site_id = get_user_site_id();
		$user_office_id = get_user_office_id();
		$user_oth_office = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir = get_role_dir();
		$get_dept_id = get_dept_id();


		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Report');

		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Q1' . $this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true);
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setWidth('30');
		$objWorksheet->getColumnDimension('I')->setWidth('30');
		$objWorksheet->getColumnDimension('J')->setAutoSize(true);
		$objWorksheet->getColumnDimension('K')->setAutoSize(true);
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);

		$r = 0;
		$c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Type");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Transaction ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "source");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Remarks");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Hat Link");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Transaction Type");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Agent Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Agent ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Status");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Hold Count");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "TTT");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "AHT");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Source");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Outbound Call");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, "Search date with time");

		$styleArray = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF'),
				'size' => 10
		));


		$headerArray = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '000000'),
				'size' => 14
		));

		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Q1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "Report");
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);


		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');

		$yesArray = array('font' => array('bold' => true, 'color' => array('rgb' => '05c605'), 'size' => 12));
		$noArray = array('font' => array('bold' => true, 'color' => array('rgb' => 'ec3232'), 'size' => 12));
		$i = 0;

		$currentDate = CurrDate();
		$currentLocalDate = GetLocalDate();
		$currentDateTime = CurrMySqlDate();
		$currentLocalDate = $localDate;
		foreach ($userData as $token) {

			$i++;
			if ($token['is_resolved'] == 1) {
				$status = "Closed";
				
			}elseif ($token['is_resolved'] == 2) {
				$status = "Pending";
			}else{
				$status = "No Action Required";
			}
			$c++;
			$r = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['transaction_type'] == '1' ? "Ticket" : "Email");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['trans_unique_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, date('d - m -Y -H:i:s', strtotime($token['trans_date'])));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['source']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['remarks']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['hat_link']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['transaction_type_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['added_by_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['added_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $status);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, ($token['c_hold']==0)?"-":$token['c_hold']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, ($token['c_hold']==0)?"-":$token['c_hold_time']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['total_time']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['source']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, $token['outbound_call'] == '1' ? "Yes":"No");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++, $c, date('Y-m-d H:i:s'));
		}

		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit();
	}


}
?>
