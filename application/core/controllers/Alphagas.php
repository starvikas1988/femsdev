<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alphagas extends CI_Controller {
	
	
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
//==========================================================================================
///=========================== ALPHA GAS CRM  ================================///

    public function index()
	{		 		
		redirect(base_url()."alphagas/dashboard");	 
	}
	 
	
	//--------- CRM FORM ID	
	public function generate_crm_id()
	{
		$sql = "SELECT count(*) as value from crm_alpha_gas ORDER by cid DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_crm_id = "ALPG" .mt_rand(11,99) .sprintf('%06d', $lastid + 1);
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
		
		
		//--------  DATE FILTER
		
		$startDate = date('Y-m-01', strtotime(CurrDate()));
		$endDate   = CurrDate();		
		$start_time = "00:00:00";
		$end_time   = "23:59:59";
		
		$extraFilter = ""; $extraTotal = "";
		if(!empty($this->input->get('start')))
		{ 
			$startDate = date('Y-m-d',strtotime($this->input->get('start')));
			$endDate = date('Y-m-d',strtotime($this->input->get('end')));			
		}
		$startDateFull = $startDate ." " .$start_time;
		$endDateFull = $endDate ." " .$end_time;
		
		$data['currMonth'] = $get_month = date('m', strtotime($startDateFull));
		$data['currYear'] = $get_year = date('Y', strtotime($startDateFull));
		$data['totalDays'] = $totalDays = cal_days_in_month(CAL_GREGORIAN, $get_month, $get_year);
		
		$data['from_date'] = $startDate;
		$data['to_date'] = $endDate;
		$data['from_month'] = $from_month = $get_year ."-" .$get_month ."-" ."01";
		$data['to_month'] = $to_month = $get_year ."-" .$get_month ."-" .$totalDays;
		
		//--------  AGENT FILTER
		if($role_dir == "agent")
		{
			$extraFilter .= " AND (c.added_by = '$current_user') ";
			$extraTotal .= " AND (c.added_by = '$current_user') ";
		}
		
		//--------- DATE FITLER COUNTS
		$extraFilter .= " AND (c.date_added >= '$startDateFull' AND c.date_added <= '$endDateFull') ";
		
		$sql = "SELECT count(*) as value from crm_alpha_gas as c WHERE 1 $extraFilter";
		$data['todays_records'] = $todays_records = $this->Common_model->get_single_value($sql);
		
		$sql = "SELECT count(*) as counter, c.c_status from crm_alpha_gas as c WHERE 1 $extraFilter GROUP BY c.c_status";
		$data['dispoisition_records'] = $todays_records = $this->Common_model->get_query_result_array($sql);
		
		$sqlDatas = "SELECT c.*, CONCAT(s.fname, ' ' ,s.lname) as fullname, s.fusion_id 
		             from crm_alpha_gas as c LEFT JOIN signin as s ON c.agent_id = s.id 
					 WHERE 1 $extraFilter";
		$queryDatas = $this->Common_model->get_query_result_array($sqlDatas);
		
		$data['allTotal'] = count($queryDatas);
		$data['allUsers'] = $allUsers = array_unique(array_column($queryDatas, 'agent_id'));
		
		foreach($queryDatas as $token)
		{
			$current_date = date('Y-m-d', strtotime($token['date_added']));			
			$current_user = $token['agent_id'];
			$current_status = $token['c_status'];
			if($current_date >= $from_month &&  $current_date <= $to_month){
				$data['monthly']['date'][$current_date][] = $token;
			}
			$data['monthly']['user'][$current_user][] = $token;
			$data['monthly']['userinfo'][$current_user]['name'] = $token['fullname'];
			$data['monthly']['userinfo'][$current_user]['fusion_id'] = $token['fusion_id'];
			$data['monthly']['status'][$current_status][] = $token;
		}
		
		for($i=0; $i<$totalDays; $i++)
		{
			$currentDate = $get_year ."-" .$get_month ."-" .sprintf('%02d', $i);
			$data['month'][$get_month]['date'][$i] = !empty($data['monthly']['date'][$currentDate]) ? count($data['monthly']['date'][$currentDate]) : "0";
		}
		
		foreach($allUsers as $tokenu)
		{
			$current_user = $tokenu;
			$data['month'][$get_month]['user'][$tokenu] = !empty($data['monthly']['user'][$current_user]) ? count($data['monthly']['user'][$current_user]) : "0";
		}
		//echo "<pre>".print_r($data['month'], 1)."</pre>"; die();
		
		//-------- TOTAL COUNT
		$sql = "SELECT count(*) as value from crm_alpha_gas as c WHERE 1 $extraTotal";
		$data['total_records'] = $total_records = $this->Common_model->get_single_value($sql);
		
		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data["aside_template"] = "alpha_gas/aside.php";
		$data["content_template"] = "alpha_gas/alpha_gas_dashboard.php";				
		$data["content_js"] = "alpha_gas/alpha_gas_graph_js.php";				
		
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
		
		$data['cancellationArray'] = $this->dropdown_cancellation();
		$data['currentDate'] = $currentDate = CurrDate();
		$data['crmid'] = $this->generate_crm_id();
		$data["aside_template"] = "alpha_gas/aside.php";
		$data["content_template"] = "alpha_gas/alpha_gas_form.php";				
		$data["content_js"] = "alpha_gas/alpha_gas_js.php";				
		
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
		
		$data['cancellationArray'] = $this->dropdown_cancellation();
		$data['crmid'] = $crmid = $this->uri->segment(3);
		$crm_query = "SELECT * from crm_alpha_gas WHERE crm_id = '$crmid'";
		$data["crm_details"] = $this->Common_model->get_query_row_array($crm_query);
		
		$data["aside_template"] = "alpha_gas/aside.php";
		$data["content_template"] = "alpha_gas/alpha_gas_form_update.php";				
		$data["content_js"] = "alpha_gas/alpha_gas_js.php";				
		
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
		
		$data["aside_template"] = "alpha_gas/aside.php";
		$data["content_template"] = "alpha_gas/alpha_gas_list.php";
		$data["content_js"] = "alpha_gas/alpha_gas_list_js.php";

		$extraFilter = "";
		$extraLimit = " LIMIT 500";
		
		//--------  DATE FILTER
		$startDate = CurrDate();
		$endDate   = CurrDate();
		$start_time = "00:00:00";
		$end_time   = "23:59:59";		
		
		if(!empty($this->input->get('start')))
		{ 
			$startDate = date('Y-m-d',strtotime($this->input->get('start')));
			$endDate = date('Y-m-d',strtotime($this->input->get('end')));			
		}
		$startDateFull = $startDate ." " .$start_time;
		$endDateFull = $endDate ." " .$end_time;
		$extraFilter .= " AND (c.date_added >= '$startDateFull' AND c.date_added <= '$endDateFull') ";
		
		
		//--------  AGENT FILTER
		if(get_role_dir() == "agent")
		{
			$extraFilter .= " AND (c.added_by = '$current_user') ";
		}
		
		//--------  STATUS FILTER
		$crmStatus = "all";
		if(!empty($this->input->get('status')) && $this->input->get('status') != "all")
		{ 
			$crmStatus = $this->input->get('status');
			$extraFilter .= " AND c.c_status = '$crmStatus' ";
		}
		
		$data['call_type'] = $crmStatus;
		$data['from_date'] = $startDate;
		$data['to_date'] = $endDate;
		
		$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from crm_alpha_gas as c LEFT JOIN signin as s ON s.id = c.added_by 
		            WHERE 1 $extraFilter ORDER by c.cid DESC $extraLimit";
		$data['crm_list'] = $querycase = $this->Common_model->get_query_result_array($sqlcase);
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function CustomerSearch()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data["aside_template"] = "alpha_gas/aside.php";
		$data["content_template"] = "alpha_gas/alpha_gas_search.php";
		$data["content_js"] = "alpha_gas/alpha_gas_list_js.php";

		$extraFilter = "";
		$search_terms = "";
		
		//--------  AGENT FILTER
		if(get_role_dir() == "agent")
		{
			$extraFilter .= " AND (c.added_by = '$current_user') ";
		}
		
		//--------  SEARCH NAME
		$s_name = "";
		if(!empty($this->input->get('s_name')))
		{	
			$search_terms = 1;
			$s_name = $this->input->get('s_name');
			$extraFilter .= " AND (c.c_fname LIKE '%$s_name%' OR c.c_lname LIKE '%$s_name%') ";
		}
		
		//--------  SEARCH PHONE
		$s_phone = "";
		if(!empty($this->input->get('s_phone')))
		{ 
			$search_terms = 1;
			$s_phone = $this->input->get('s_phone');
			$extraFilter .= " AND (c.c_phone = '$s_phone') ";
		}
		
		//--------  SEARCH ELECTRIC
		$s_electric = "";
		if(!empty($this->input->get('s_electric')))
		{ 
			$search_terms = 1;
			$s_electric = $this->input->get('s_electric');
			$extraFilter .= " AND (c.c_electric_account = '$s_electric') ";
		}
		
		//--------  SEARCH GAS
		$s_gas = "";
		if(!empty($this->input->get('s_gas')))
		{ 
			$search_terms = 1;
			$s_gas = $this->input->get('s_gas');
			$extraFilter .= " AND (c.c_gas_account = '$s_gas') ";
		}
		
		$data['s_name'] = $s_name;
		$data['s_phone'] = $s_phone;
		$data['s_electric'] = $s_electric;
		$data['s_gas'] = $s_gas;
		$data['search_terms'] = $search_terms;
		
		$data['crm_list'] = NULL;
		if(!empty($search_terms)){
			$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from crm_alpha_gas as c LEFT JOIN signin as s ON s.id = c.added_by 
						WHERE 1 $extraFilter ORDER by c.cid DESC $extraLimit";
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
		
		$data["aside_template"] = "alpha_gas/aside.php";
		$data["content_template"] = "alpha_gas/alpha_gas_reports.php";
		$data["content_js"] = "alpha_gas/alpha_gas_list_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function crm_logs_list()
	{
		$cid = $this->uri->segment(3);
		$data['crmCase'] = NULL; 
		if($cid != ""){
			$data['crmCase'] = $crmCase = $this->crm_logs_record_details($cid);			
		}
		$this->load->view('alpha_gas/alpha_gas_logs',$data);
	}
	
	public function crm_logs_record_details($cid)
	{
		$sql = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from crm_alpha_gas_logs as c 
			    LEFT JOIN signin as s ON s.id = c.cl_added_by  WHERE c.crm_id = '$cid' ORDER by c.lid ASC";
		$jurysCase = $this->Common_model->get_query_result_array($sql);
		return $jurysCase;
	}
	
	
	
	public function generate_crm_reports($from_date ='', $to_date='', $call_type='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$extraFilter = "";
		
		// FILTER DATE CHECK
		$startDate = CurrDate();
		$endDate   = CurrDate();		
		$start_time = "00:00:00";
		$end_time   = "23:59:59";		
		if(!empty($this->input->get('start')))
		{ 
			$startDate = date('Y-m-d',strtotime($this->input->get('start')));
			$endDate = date('Y-m-d',strtotime($this->input->get('end')));			
		}		
		$startDateFull = $startDate ." " .$start_time;
		$endDateFull = $endDate ." " .$end_time;
		$extraFilter .= " AND (c.date_added >= '$startDateFull' AND c.date_added <= '$endDateFull') ";
				
		// FILTER AGENT
		if(get_role_dir() == "agent"){  $extraFilter .= " AND (c.added_by = '$current_user') "; }
		
		// FILTER EXTRA CHECK
		if(!empty($this->input->get('status')) && $this->input->get('status') != "all")
		{ 
			$crmStatus = $this->input->get('status');
			$extraFilter .= " AND c.c_status = '$crmStatus' ";
		}
		
		$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name, concat(l1.fname,' ', l1.lname) as l1_supervisor, r.name as designation from crm_alpha_gas as c 
		            LEFT JOIN signin as s ON s.id = c.agent_id
		            LEFT JOIN signin as l1 ON l1.id = s.assigned_to
		            LEFT JOIN role as r ON r.id = s.role_id
					WHERE 1 $extraFilter";
		$crm_list = $this->Common_model->get_query_result_array($sqlcase);
		
		$title = "ALPHA GAS";
		$sheet_title = "ALPHA GAS - CUSTOMER RECORDS (" .date('Y-m-d',strtotime($startDateFull)) ." - " .date('Y-m-d',strtotime($endDateFull)).")";
		$file_name = "Alpha_Gas_Records_".date('Y-m-d',strtotime($from_date));
		
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:U1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		
		$objWorksheet->getColumnDimension('N')->setWidth('30');
		$objWorksheet->getColumnDimension('S')->setWidth('75');
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:T1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $sheet_title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:U2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:U2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "CRM ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Agent");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "L1 Supervisor");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Designation");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Call AHT");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Talk Time");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Hold Time");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Customer Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Phone");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Address");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "No of Hold");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Reason for Hold");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Utility Electric");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Account No Electric");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Utility Gas");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Account No Gas");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Comments");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Status");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Cancellation Reason");
		
		
			
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{	
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["crm_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added"])));
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['added_by_name']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['l1_supervisor']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['designation']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_call_aht"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_call"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_hold_time"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_fname"] ." " .$wv["c_lname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_phone_no"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_address"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_hold"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_hold_reason"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_utility_electric"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_electric_account"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_utility_gas"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_gas_account"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_comments"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, ucwords($wv["c_status"]));
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, ucwords($wv["c_cancellation"]));
			$i++;			
		}
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:T'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	public function submit_alpha_gas()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$crm_date = $this->input->post('c_date');
		$time_interval = $this->input->post('time_interval');
		$cl_disposition = $this->input->post('cl_disposition');
		$c_cancellation = $this->input->post('c_cancellation');
		$cl_comments = $this->input->post('cl_comments');
		
		// CALL DETAILS
		$c_date              = "";
		$c_fname             = $this->input->post('c_firstname');
		$c_lname             = $this->input->post('c_lastname');
		$c_language          = $this->input->post('c_language');
		$c_phone_no          = $this->input->post('c_phone_no');
		$c_address           = $this->input->post('c_address');
		$c_utility_electric  = $this->input->post('c_utility_electric');
		$c_electric_account  = $this->input->post('c_electric_account');
		$c_utility_gas       = $this->input->post('c_utility_gas');
		$c_gas_account    = $this->input->post('c_gas_account');
		if(!empty($crm_date)){ $c_date = date('Y-m-d', strtotime($crm_date)); }
		
		$c_outbound         = $this->input->post('c_outbound');
		$c_outbound_reason  = $this->input->post('c_outbound_reason');
		$c_call             = $this->input->post('timer_start');
		$c_hold             = $this->input->post('c_hold');
		$c_holdtime         = $this->input->post('c_holdtime');
		$c_hold_reason      = $this->input->post('c_hold_reason');
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
			'agent_id' => $current_user,
			'c_fname' => $c_fname,
			'c_lname' => $c_lname,
			'c_language' => $c_language,
			'c_phone_no' => $c_phone_no,
			'c_address' => $c_address,
			'c_utility_electric' => $c_utility_electric,
			'c_electric_account' => $c_electric_account,
			'c_utility_gas' => $c_utility_gas,
			'c_gas_account' => $c_gas_account,
			'c_comments' => $cl_comments,
			'c_status' => $cl_disposition,
			'c_cancellation' => $c_cancellation,
		];
	
		$sqlcheck = "SELECT count(*) as value from crm_alpha_gas WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{			
			$this->db->where('crm_id', $crm_id);
			$this->db->update('crm_alpha_gas', $case_array);
			$flag = "update";
		} 
		else {
			$case_array += [ 'crm_id' => $crm_id ];
			$case_array += [ 'c_hold' => $c_hold ];
			$case_array += [ 'c_hold_time' => $c_holdtime ];
			$case_array += [ 'c_hold_reason' => $c_hold_reason ];
			$case_array += [ 'c_call' => $c_call ];
			$case_array += [ 'c_call_aht' => $call_aht ];
			$case_array += [ 'added_by' => $current_user ];
			$case_array += [ 'date_added' => CurrMySqlDate() ];
			$case_array += [ 'date_added_local' => GetLocalTime() ];
			$case_array += [ 'logs' => get_logs() ];
			data_inserter('crm_alpha_gas', $case_array);			
			$flag = "insert";
		}
		
		// UPDATE LOGS
		$this->crm_update_logs($crm_id, $cl_disposition, $cl_comments, $time_interval);
		
		if(!empty($crm_id)){
			$this->send_email_crm_logs($crm_id);
		}
		
		if($flag=="insert"){ redirect(base_url()."alphagas/newCustomer"); }
		if($flag=="update"){ redirect(base_url()."alphagas/updateCustomer/".$crm_id); }
		if($flag=="error"){ redirect(base_url()."alphagas/newCustomer"); }
	}
	
	
	
	//--------- CRM JURYS INN LOGS
	
	public function crm_update_logs($crmid, $disposition='', $comments='', $interval = '')
	{
		$logs_array = [
		    'crm_id' => $crmid,
			'cl_disposition' => $disposition,
			'cl_comments' => $comments,
			'cl_interval' => $interval,
			'cl_added_by' => get_user_id(),
			'cl_date_added' => CurrMySqlDate(),
			'cl_date_added_local' => GetLocalTime(),
			'cl_logs' => get_logs()
		];
		if(!empty($interval)){ $logs_array += [ 'cl_interval' => $interval ]; } 
		data_inserter('crm_alpha_gas_logs', $logs_array);		
	}
	
	public function crm_entry_delete()
	{
		$crmdeletID = $this->input->get('crmid');
		if(!empty($crmdeletID))
		{
			$sqlcheck = "SELECT count(*) as value from crm_alph_gas WHERE crm_id = '$crmdeletID'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0)
			{			
				$this->db->where('crm_id', $crmdeletID);
				$this->db->delete('crm_alph_gas');
				
				$this->db->where('crm_id', $crmdeletID);
				$this->db->delete('crm_alpha_gas_logs');
				echo "DELETED";
				
			} else {
				
				echo "NOT FOUND";
			}
			
		} else {
			echo "INVALID";
		}
	}
	
	//====================== MAILIGN LOGS =============================================//
	
	public function send_email_crm_logs($submission_id = "")
	{
		//$submission_id = "ALPG63000001";
		$eto="";
		$ecc="";
		$nbody="";
		
		$sql_dataLog = "SELECT c.*, CONCAT(s.fname,' ', s.lname) as added_by_name, r.name as designation, s.fusion_id,
		                      get_process_names(s.id) as process_name, CONCAT(l.fname, ' ', l.lname) as l1_supervisor
		                      from crm_alpha_gas as c 
		                      LEFT JOIN signin as s ON s.id = c.added_by
							  LEFT JOIN signin as l ON l.id = s.assigned_to
		                      LEFT JOIN role as r ON r.id = s.role_id 
							  WHERE c.crm_id = '$submission_id' ORDER by cid DESC LIMIT 1";
		$datLogs = $this->Common_model->get_query_row_array($sql_dataLog);
		if(!empty($datLogs['crm_id']))
		{
			$hold_reason = !empty($datLogs['c_hold_reason']) ? $datLogs['c_hold_reason'] : "n/a";
			$email_subject = "Alpha Gas | New Disposition | " .$datLogs['fusion_id'] ." | " .$datLogs['date_added'];
			
			//$eto = 'sachin.paswan@fusionbposervices.com';
			//$ecc = '';
			
			$eto = 'bella.fabricante@fusionbposervices.com,amanda.krasinski@alphagne.com,janillee.rama@fusionbposervices.com,gloria.salazar@fusionbposervices.com';
			$ecc = 'sam.bensinger@alphagne.com,eliott.wolbrom@alphagne.com,jane.minoza@fusionbposervices.com';
			
			$from_email="noreply.fems@fusionbposervices.com";
			$from_name="Fusion FEMS";
						
			$nbody='<h4><b>New Disposition for Alpha Gas</b></h4><br/>
					Please find the details below : </br></br>
					<b>Disposition Status : '.strtoupper($datLogs['c_status']) .'</b><br/>
					<b>Call AHT : '.$datLogs['c_call_aht'] .'</b><br/><br/>
					<b>Call Time : </b>'.$datLogs['c_call'] .'<br/>
					<b>Hold Time : </b>'.$datLogs['c_hold_time'] .'<br/>
					<b>No Of Hold : </b>'.$datLogs['c_hold'] .'<br/>					
					<b>Hold Reason : </b>'.$hold_reason .'<br/><br/>
							
					<b>Disposition Details :</b><br/><br/>
					<table border="1" width="80%" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Customer Name :</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_fname"] ." " .$datLogs["c_lname"] .'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Language :</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_language"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Phone :</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_phone_no"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Address :</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_address"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Utility Electric :</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_utility_electric"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Electric A/C No :</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_electric_account"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Utility Gas</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_utility_gas"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Gas A/C No</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_gas_account"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Comments</td>
								<td style="padding:2px 0px 2px 8px">'.$datLogs["c_comments"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Status</td>
								<td style="padding:2px 0px 2px 8px">'.ucwords($datLogs["c_status"]).'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Cancellation Reason</td>
								<td style="padding:2px 0px 2px 8px">'.ucwords($datLogs["c_cancellation"]).'</td>
							</tr>
					</table>
									
				</br>
				</br>';
			$nbody .= '<br/><b>Added By : </b> '.$datLogs['added_by_name'] .'<br/>
					<b>Designation : </b> '.$datLogs['designation'] .'<br/>
					<b>Supervisor : </b> '.$datLogs['l1_supervisor'] .'<br/>
					<b>Process : </b> '.$datLogs['process_name'] .'<br/>
					<b>Date Added : </b> '.$datLogs['date_added'] .'<br/>
					</br>';
					
			$nbody .= '</br><b>Regards, </br>
					   Fusion - FEMS	</b></br>
				      ';
			
			//echo $nbody;
			$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "",$from_email,$from_name,'N');	
			
		}			
				
	}
		
	
	public function dropdown_cancellation(){
		$cancellationArray = array(
			"High Rate",
			"Not Aware of the enrollment",
			"Double charges",
			"Personal reason",
			"Wanted to remain with the utility as a supplier",
			"Asking for a refund",
			"Inquiry",
		);
		return $cancellationArray;
	}
	
		
}