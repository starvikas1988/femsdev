<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_tracing_follett extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();
	}
	
//==========================================================================================
///=========================== CONTACT TRACING CRM  ================================///
     public function index(){
		
		//$caseType = $this->uri->segment(3);
		/*if(!empty($caseType) && $this->case_crm_type($caseType) == true){
			redirect(base_url()."contact_tracing_follett/form/");
		} else {
			show_error('Something Went Wrong!');
		}*/
		redirect(base_url()."contact_tracing_follett/overview");
	 }
	 
	 
	public function get_master_emailIDs(){
		$emailIDs = "contacttracing@follett.com";
		//$emailIDs = "sachin.paswan@fusionbposervices.com";
		return $emailIDs;
	}
	
	 
	 //=================================== CRM OVERVIEW =============================================//
	
	public function overview()
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
		$todayStartDate = date('Y-m-01', strtotime(CurrDate()))." 00:00:00"; 
		$todayEndDate = CurrDate()." 23:59:59";
		
		if(!empty($this->input->get('start')))
		{ 
			$todayStartDate = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$todayEndDate = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";			
		}		
		
		if($role_dir == "agent" && get_login_type != 'client' && !get_global_access())
		{
			//$extraFilter .= " AND (c.added_by = '$current_user') ";
			//$extraTotal .= " AND (c.added_by = '$current_user') ";
		}
		
		$extraFilter .= " AND (c.date_of_call >= '$todayStartDate' AND c.date_of_call <= '$todayEndDate') ";
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		// TABLES
		$data['tableArray'] = $tableArray = $this->master_case_types();
		
		$total_records = 0;
		$todays_records = 0;
		foreach($tableArray as $key=>$val)
		{
			$addFilter = " AND i.p_type_of_case = '$key'";
			$sql = "SELECT count(*) as value from contact_tracing_follett as c INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id WHERE 1 $addFilter $extraTotal";
			$data['total'][$key] = $total = $this->Common_model->get_single_value($sql);
			
			$sql = "SELECT count(*) as value from contact_tracing_follett as c INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id WHERE 1 $addFilter $extraFilter";
			$data['today'][$key] = $today = $this->Common_model->get_single_value($sql);
						
			$total_records = $total_records + $total;
			$todays_records = $todays_records + $today;
			
		}
		
		$sql = "SELECT count(*) as value from contact_tracing_follett as c INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id WHERE 1 $extraTotal";
		$total_records = $total = $this->Common_model->get_single_value($sql);
		
		$sql = "SELECT count(*) as value from contact_tracing_follett as c INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id WHERE 1 $extraFilter";
		$todays_records = $today = $this->Common_model->get_single_value($sql);
		
		$addFilterClosed = " AND (c.case_status <> 'C' OR c.case_status IS NULL)";
		$sql = "SELECT count(*) as value from contact_tracing_follett as c INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id WHERE 1 $addFilterClosed $extraTotal";
		$data['caseStatus']['total']['open'] = $closedC = $this->Common_model->get_single_value($sql);
		
		$sql = "SELECT count(*) as value from contact_tracing_follett as c INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id WHERE 1 $addFilterClosed $extraFilter";
		$data['caseStatus']['today']['open'] = $openC = $this->Common_model->get_single_value($sql);
		
		$data['total_records'] = $total_records;
		$data['todays_records'] = $todays_records;
		
		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_overview.php";				
		$data["content_js"] = "contact_tracing/folletts/contact_tracing_follett_overview_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function analytics()
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
				
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
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
			$sql_users = "SELECT count(cid) as casecounts, c.caller_store_location as p_store_location, i.p_is_diagonised, i.p_type_of_case  from contact_tracing_follett as c 
			              INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id
						  WHERE c.date_of_call >= '$start_date_full' AND c.date_of_call <= '$end_date_full'
						  GROUP BY c.caller_store_location, i.p_is_diagonised ORDER by casecounts DESC";
			$query_users = $this->Common_model->get_query_result_array($sql_users);
			$positiveCases = array_filter($query_users, function($n){
				if($n['p_is_diagonised'] == 'Yes'){ return $n; }
				//if($n['p_type_of_case'] == 'C' || $n['p_type_of_case'] == 'D'){ return $n; }
			});
			$negativeCases = array_filter($query_users, function($n){
				if($n['p_is_diagonised'] == 'No'){ return $n; }
				//if($n['p_type_of_case'] == 'A' || $n['p_type_of_case'] == 'B'){ return $n; }
			});
			$data['months'][$i]['positive'] = $positiveCases;
			$data['months'][$i]['negative'] = $negativeCases;
			
			$totalCases = 0; $locationArray = array();
			foreach($positiveCases as $tokenSum){
				$totalCases = $totalCases + $tokenSum['casecounts'];
				if(!empty($tokenSum['p_store_location'])){
					$currentLoc = $tokenSum['p_store_location'];
					if(empty($locationArray[$currentLoc])){ $locationArray[$currentLoc] = 0; }
					$locationArray[$currentLoc] = $locationArray[$currentLoc] + $tokenSum['casecounts'];
				}
			}
			$data['months'][$i]['total']['positive'] = $totalCases;
			
			$totalCases = 0;
			foreach($negativeCases as $tokenSum){
				$totalCases = $totalCases + $tokenSum['casecounts'];
				if(!empty($tokenSum['p_store_location'])){
					$currentLoc = $tokenSum['p_store_location'];
					if(empty($locationArray[$currentLoc])){ $locationArray[$currentLoc] = 0; }
					$locationArray[$currentLoc] = $locationArray[$currentLoc] + $tokenSum['casecounts'];
				}
			}
			$data['months'][$i]['total']['negative'] = $totalCases;
			$data['months'][$i]['locations']['cases'] = $locationArray;
			
			//$data['search'][$i]['data'] = $query_users;
			$data['search'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['search'][$i]['year'] = $selected_year;
			
			$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
			$weekCheck = 0;
			foreach($weekArray as $tokenW)
			{
				$currentDay = $tokenW['week_start'];
				$startCurrentDay = $tokenW['week_start'];
				$endCurrentDay = $tokenW['week_end'];
				$startDay = $tokenW['week_start'] ." " .$time_start;
				$endDay = $tokenW['week_end'] ." " .$time_end;
				
				$sql_users = "SELECT count(cid) as casecounts, c.caller_store_location as p_store_location, i.p_is_diagonised  from contact_tracing_follett as c 
			              INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id
						  WHERE c.date_of_call >= '$startCurrentDay' AND c.date_of_call <= '$endCurrentDay'
						  GROUP BY c.caller_store_location, i.p_is_diagonised  ORDER by casecounts DESC";
				$query_users = $this->Common_model->get_query_result_array($sql_users);
				$positiveCases = array_filter($query_users, function($n){
					if($n['p_is_diagonised'] == 'Yes'){ return $n; }
				});
				$negativeCases = array_filter($query_users, function($n){
					if($n['p_is_diagonised'] == 'No'){ return $n; }
				});			
				$data['months'][$i]['weekly'][$weekCheck]['positive'] = $positiveCases;
				$data['months'][$i]['weekly'][$weekCheck]['negative'] = $negativeCases;
				$data['months'][$i]['weekly'][$weekCheck]['start'] = $tokenW['week_start'];
				$data['months'][$i]['weekly'][$weekCheck]['end'] = $tokenW['week_end'];
				
				$weekCheck++;
			}
			
			$data['months'][$i]['weekcount'] = count($weekArray);
			
			
			$data['search'][$i]['weeks'] = count($weekArray);
			$data['search'][$i]['weekdates'] = $weekArray;
			
			//echo "<pre>".print_r($data['questions'], 1) ."</pre>";
			
		}
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "cases")
		{
			$this->generate_cases_analytic_reports_xls($data);
		}
		
		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_analytics.php";				
		$data["content_js"] = "contact_tracing/folletts/contact_tracing_follett_analytics_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	 private function case_crm_type($type, $checker = 1){		 		
		$caseCRM = array();
		$caseCRM['zovio'] = array(
			"name" => "Zovio", 		
			"short" => "zovio", 		
		);
		$caseCRM['follets'] = array(
			"name" => "Follets", 		
			"url" => "follets", 		
		);
		$flag = false;
		if(!empty($caseCRM[$type])){ $flag = true; }
		if($checker == 0){ return $caseCRM[$type];	} else{
			return $flag;
		}		
	 }
	 
	
	public function case_list()
	{
		$caseType = $this->uri->segment(3);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
				
		$data['caseTypes'] = $caseTypes = $this->master_case_types();					
		$currStartDate = date('Y-m-01', strtotime(CurrDate())); 
		$currEndDate = CurrDate();
		$currMainType = "";
		$currCaseType = "";
		$currReportType = "excel";
		$filter_MainType = "";
		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')))
		{
			$currStartDate = date('Y-m-d', strtotime($this->input->get('start_date')));
			$currEndDate = date('Y-m-d', strtotime($this->input->get('end_date')));
		}
		if(!empty($this->input->get('main_type')))
		{
			$currMainType = $this->input->get('main_type');
			if(!empty($currMainType)){ $filter_MainType = " AND i.p_type_of_case = '$currMainType'"; }	
		}
		if(!empty($this->input->get('case_status')))
		{
			$currCaseType = $this->input->get('case_status');
			if(!empty($currCaseType)){ 
				if($currCaseType == 'C'){
					$filter_CaseType = " AND c.case_status = '$currCaseType'"; 
				} else {
					//$filter_CaseType = " AND (c.case_status = '$currCaseType' OR c.case_status IS NULL)"; 
					$filter_CaseType = " AND (c.case_status <> 'C' OR c.case_status IS NULL)"; 
				}
			}			
		}
		$data['start_date'] = date('m/d/Y', strtotime($currStartDate));
		$data['end_date'] = date('m/d/Y', strtotime($currEndDate));
		$data['main_type'] = $currMainType;
		$data['case_type'] = $currCaseType;
		$data['report_type'] = $currReportType;
		
		$extraFilter = "";
		if(get_role_dir() == "agent" && get_login_type != 'client' && !get_global_access())
		{
			//$extraFilter = " AND (c.added_by = '$current_user') ";
		}
		
		$_sql_case = "SELECT c.*, i.*, CONCAT(s.fname, ' ', s.lname) as added_by_name from contact_tracing_follett as c 
			         LEFT JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id
					 LEFT JOIN signin as s ON s.id = c.added_by
					 WHERE c.date_of_call >= '$currStartDate' AND c.date_of_call <= '$currEndDate' $filter_MainType $filter_CaseType $extraFilter";
		$data['case_list'] = $querycase = $this->Common_model->get_query_result_array($_sql_case);
		
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_form_list.php";
		$data["content_js"] = "contact_tracing/folletts/contact_tracing_follett_list_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function case_search()
	{
		$caseType = $this->uri->segment(3);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
				
		$data['caseTypes'] = $caseTypes = $this->master_case_types();
		$search_keyword = "";
		$currMainType = "";
		$filter_MainType = "";
		$data['totaldata'] = 0;
		$data['case_list'] = array();				
		if(!empty($this->input->get('search_keyword')))
		{
			$search_keyword = $this->input->get('search_keyword');
			$currMainType = $this->input->get('main_type');
			if(!empty($currMainType)){ $filter_MainType = " AND i.p_type_of_case = '$currMainType'"; }
			if(!empty($search_keyword)){ $filter_MainType .= " AND (c.crm_id = '$search_keyword' OR c.fname LIKE '%$search_keyword%' OR c.lname LIKE '%$search_keyword%' OR c.caller_phone LIKE '%$search_keyword%')"; }
			$_sql_case = "SELECT c.*, i.*, CONCAT(s.fname, ' ', s.lname) as added_by_name from contact_tracing_follett as c 
			         LEFT JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id
					 LEFT JOIN signin as s ON s.id = c.added_by
					 WHERE 1 $filter_MainType";
			$querycase = $this->Common_model->get_query_result_array($_sql_case);
			if(!empty($querycase)){ 
				$data['totaldata'] = count($querycase);
				$data['case_list'] = $querycase;
			}
			
		}
		$data['search_keyword'] = $search_keyword;
		$data['main_type'] = $currMainType;		
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_search.php";
		$data["content_js"] = "contact_tracing/folletts/contact_tracing_follett_list_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	
	//============================= CRM ID =============================================================//
	
	public function generate_crm_id()
	{
		$sql = "SELECT count(*) as value from contact_tracing_follett ORDER by cid DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_crm_id = "CF" .mt_rand(11,99) .sprintf('%06d', $lastid + 1);
		return $new_crm_id;
	}
	
	//============================= CASE TYPES =============================================================//
	
	public function master_case_types($type="")
	{
		$caseTypeArray = [
			"A" => "A. CONFIRMED TEAM MEMBER COVID-19 DIAGNOSIS",
			"B" => "B. CONFIRMED TEAM MEMBER CLOSE CONTACT EXPOSURE TO SOMEONE DIAGNOSED WITH COVID-19",
			"C" => "C. CALLER PROXIMATE EXPOSURE TO SOMEONE DIAGNOSED WITH COVID-19",
			"D" => "D. CALLER SECOND HAND EXPOSURE TO SOMEONE DIAGNOSED WITH COVID-19",
			"E" => "E. CALLER ILLNESS",
			"F" => "F. THIRD PARTY VENDOR EXPOSURE",
			"G" => "G. MANAGER OF TEAM MEMBER CALLING TO CONFIRM POSITIVE TEAM MEMBER"
		];		
		if(!empty($type)){ return $caseTypeArray[$type]; } else {
			return $caseTypeArray;
		}
	}
	
	
	public function master_case_work_status($type="")
	{
		$caseTypeArray = [
			"A" => "At home quarantined with others",
			"B" => "At home isolating alone",
			"C" => "Actively Working at Location",
			"D" => "Actively Working Remotely",
			"E" => "Other"
		];		
		if(!empty($type)){ return $caseTypeArray[$type]; } else {
			return $caseTypeArray;
		}
	}
	
	
	//============================= CRM FORM =============================================================//
	
	public function form()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['crmid'] = $this->generate_crm_id();
		$data['currentDate'] = CurrDate();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_form.php";
		
		$data['urlSection'] = $this->uri->segment(4);
		$data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		//$data['allCountries'] = $this->master_countries();						
																	
		if($this->uri->segment(4) == 'personal'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);	
			$data["content_template"] = "contact_tracing_crm/folletts/covid_case_form.php";			
		}
		
		if($this->uri->segment(4) == 'case'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);	
			$data["caseTypes"] = $this->master_case_types();	
			$data["content_template"] = "contact_tracing_crm/folletts/covid_case_form_2_case.php";			
		}
		
		if($this->uri->segment(4) == 'condition'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);	
			$data["caseTypes"] = $this->master_case_work_status();	
			$data["content_template"] = "contact_tracing_crm/folletts/covid_case_form_3_condition.php";			
		}
		
		if($this->uri->segment(4) == 'exposure'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data["crmexposure"] = $this->covid_case_details_exposure($crmid, 'exposure');
			$data["content_template"] = "contact_tracing_crm/folletts/covid_case_form_4_exposure.php";			
		}
		
		if($this->uri->segment(4) == 'final'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data["caseTypes"] = $this->master_case_types();
			$data["content_template"] = "contact_tracing_crm/folletts/covid_case_form_5_final.php";			
		}
		
		$data["content_js"] = "contact_tracing/folletts/contact_tracing_follett_js.php";
		$this->load->view('dashboard',$data);
	 
	}
	
	//============================= CRM FORM UPDATE =============================================================//
	
	
	public function updatecase()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "covid19_case/aside.php";
		$data["content_template"] = "covid19_case/covid_case_form_update.php";
		
		if(!empty($this->input->post('case_search')))
		{
			$data['casecrmid'] = $crm_id = $this->input->post('crm_id');
			$data['casename'] = $case_name = $this->input->post('case_name');
			$data['casephone'] = $case_phone = $this->input->post('case_phone');
			$data['caseemail'] = $case_email = $this->input->post('case_email');
			
			$extrawhere = "";
			if(!empty($crm_id)){ $extrawhere .= " AND c.crm_id = '$crm_id'"; }
			if(!empty($case_name)){ $extrawhere .= " AND c.fname LIKE '%$case_name%' OR c.lname LIKE '%$case_name%'"; }
			if(!empty($case_phone)){ $extrawhere .= " AND i.p_phone LIKE '%$case_phone%'"; }
			if(!empty($case_email)){ $extrawhere .= " AND i.p_email LIKE '%$case_email%'"; }
			
			$sqlcheck = "SELECT c.*,s.*,i.p_phone,i.p_email, c.fname as case_fname, c.lname as case_lname, c.date_added as case_added from covid19_case as c LEFT JOIN covid19_case_info i on i.crm_id = c.crm_id LEFT JOIN signin as s ON s.id = c.added_by
			             WHERE 1 $extrawhere";
			$querycheck = $this->Common_model->get_query_result_array($sqlcheck);
			if($querycheck > 0){ 
				$data['totaldata'] = count($querycheck);
				$data['case_list'] = $querycheck;
			}
			else { redirect('contact_tracing_crm/updatecase/error'); }
		}

		$this->load->view('dashboard',$data);
	 
	}
	 
	
	public function sendtoform($formid = 1, $crmid='', $type='success')
	{
		if($formid == 1){
			redirect('contact_tracing_follett/form/'.$crmid.'/personal/'.$type);
		}
		if($formid == 2){
			redirect('contact_tracing_follett/form/'.$crmid.'/case/'.$type);
		}
		if($formid == 3){
			redirect('contact_tracing_follett/form/'.$crmid.'/condition/'.$type);
		}
		if($formid == 4){
			redirect('contact_tracing_follett/form/'.$crmid.'/exposure/'.$type);
		}
		if($formid == 5){
			redirect('contact_tracing_follett/form/'.$crmid.'/final/'.$type);
		}
	}
	
	
	
	public function covid_case_logs($crmid, $disposition='C', $comments='Auto', $type = 'personal', $interval = '')
	{
		$logs_array = [
		    'crm_id' => $crmid,
			'cl_disposition' => $disposition,
			'cl_comments' => $comments,
			'cl_section' => $type,
			'cl_added_by' => get_user_id(),
			'cl_date_added' => CurrMySqlDate(),
			'cl_logs' => get_logs()
		];
		if(!empty($interval)){ $logs_array += [ 'cl_interval' => $interval ]; } 
		data_inserter('contact_tracing_follett_logs', $logs_array);		
	}
	
	public function covid_case_closure($crmid, $disposition='N')
	{
		$logs_array = [
			'case_status' => $disposition
		];
		$this->db->where('crm_id', $crmid);
		$this->db->update('contact_tracing_follett', $logs_array);	
	}
	
	
	public function covid_case_move_next($crmid)
	{
		redirect(base_url().'contact_tracing_follett/form');
	}
	

	//============================= CRM DETAILS =============================================================//	
	
	public function check_logs()
	{
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_tracker.php";
		
		$crm_id = $this->uri->segment(3);
		$data["crmdetails"] = $this->covid_case_details($crm_id);
		$sql = "SELECT l.*, CONCAT(s.fname, ' ', s.lname) as full_name from contact_tracing_follett_logs as l LEFT JOIN signin as s ON l.cl_added_by = s.id WHERE l.crm_id = '$crm_id' ORDER by l.cl_date_added DESC";
		$data['logdetails'] = $logsdetails = $this->Common_model->get_query_result_array($sql);
		
		$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(cl_interval))) as value from contact_tracing_follett_logs WHERE crm_id = '$crm_id'";
		$data['total_time_spent'] = $this->Common_model->get_single_value($sql);
		
		$this->load->view('dashboard',$data);
	}	
	
	
	
	public function covid_case_details($cid)
	{
		$sql = "SELECT * from contact_tracing_follett as c 
		        LEFT JOIN contact_tracing_follett_info as cf ON cf.crm_id = c.crm_id
				WHERE c.crm_id = '$cid'";
		$covidCase = $this->Common_model->get_query_row_array($sql);
		return $covidCase;
	}
	
	public function covid_case_details_exposure($cid, $type = '', $day = '')
	{
		$extraq = "";
		if(!empty($type)){ $extraq .= " AND c.e_type = '$type'"; }
		if(!empty($day)){ $extraq .= " AND c.e_day = '$day'"; }
		
		$sql = "SELECT * from contact_tracing_follett_exposure as c 
		        LEFT JOIN contact_tracing_follett as cf ON cf.crm_id = c.crm_id
				WHERE c.crm_id = '$cid' $extraq";
		$covidCase = $this->Common_model->get_query_result_array($sql);
		return $covidCase;
	}
	
	
	
	//======================================== CASE SUBMISSION =========================================//
	
	// 1. Personal
	public function submit_personal_information()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$time_interval = $this->input->post('time_interval');
		
		$case_array = [			
			'fname' => $this->input->post('case_fname'),
			'lname' => $this->input->post('case_lname'),
		];
		
		if(!empty($this->input->post('date_of_call'))){
			$case_array += [ 'date_of_call' => date('Y-m-d', strtotime($this->input->post('date_of_call'))) ];
		}
		
		$cl_type = 'personal';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type, $time_interval);
		
		$case_array += [
			'caller_phone' => $this->input->post('caller_phone'),
			'store_phone' => $this->input->post('store_phone'),
			'caller_store_location' => $this->input->post('caller_store_location'),
			'caller_manager_name' => $this->input->post('caller_manager_name'),
		];
		
		$sqlcheck = "SELECT count(*) as value from contact_tracing_follett WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('contact_tracing_follett', $case_array);			
			$this->sendtoform('2',$crm_id, 'update');
		} 
		else {
			$caseSource = 'agent';
			$caseStatus = 'P';
			$case_array += [ 
				'crm_id' => $crm_id,
				'case_source' => $caseSource,
				'case_status' => $caseStatus,
				'added_by' => $current_user,
				'date_added' => CurrMySqlDate(),
				'logs' => get_logs()
			];			
			data_inserter('contact_tracing_follett', $case_array);
			
			$info_array = [ 'crm_id' => $crm_id ];
			data_inserter('contact_tracing_follett_info', $info_array);
			
			$this->sendtoform('2',$crm_id, 'success');
		}
	}
	
	
	
	// 2. Case
	public function submit_case_information()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$time_interval = $this->input->post('time_interval');
		
		$flag = "error";		
		$data_array = [
			'p_is_incident' => $this->input->post('p_is_incident'),
			'p_incident' => $this->input->post('p_incident'),
			'p_type_of_case' => $this->input->post('p_type_of_case'),
			'p_is_diagonised' => $this->input->post('p_is_diagonised'),
			'p_is_diagonised_details' => $this->input->post('p_is_diagonised_details'),
			'p_store_location' => $this->input->post('p_store_location'),
			//'p_comments' => $this->input->post('p_comments'),
		];
		
		if(!empty($this->input->post('p_date_of_test'))){
			$data_array += [ 'p_date_of_test' => date('Y-m-d', strtotime($this->input->post('p_date_of_test'))) ];
		}		
		if(!empty($this->input->post('p_date_of_result'))){
			$data_array += [ 'p_date_of_result' => date('Y-m-d', strtotime($this->input->post('p_date_of_result'))) ];
		}
				
		$cl_type = 'case';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type, $time_interval);
		
		$sqlcheck = "SELECT count(*) as value from contact_tracing_follett_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('contact_tracing_follett_info', $data_array);
			$flag = "update";
		} 
		else {
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('contact_tracing_follett_info', $data_array);
			$flag = "insert";
		}
		
		if($flag == "update"){ $this->sendtoform('3',$crm_id, 'update'); }
		if($flag == "insert"){ $this->sendtoform('3',$crm_id, 'success'); }
		if($flag == "error"){ redirect('contact_tracing_follett/case_search'); }
		if($flag == "closure"){ $this->covid_case_move_next($crm_id);  }
	}
	
	
	// 3. Condition
	public function submit_condition_information()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$time_interval = $this->input->post('time_interval');
		
		$symptomps = $this->input->post('s_symptoms');
		$mySymptoms = "";
		if(!empty($symptomps)){
			$mySymptoms = implode(',',$symptomps);
		}
		
		$flag = "error";		
		$data_array = [
			's_symptoms' => $mySymptoms,
			's_exposure_event' => $this->input->post('s_exposure_event'),
			's_exposure_notes' => $this->input->post('s_exposure_notes'),
			's_is_symptom' => $this->input->post('s_is_symptom'),
			's_protocol_followed' => $this->input->post('s_protocol_followed'),
			's_is_face_covered' => $this->input->post('s_is_face_covered'),
			's_is_social_distance' => $this->input->post('s_is_social_distance'),
			's_is_high_cleaning' => $this->input->post('s_is_high_cleaning'),
			's_is_daily_certification' => $this->input->post('s_is_daily_certification'),
			's_is_thermometer' => $this->input->post('s_is_thermometer'),
			's_cleaning' => $this->input->post('s_cleaning'),
			's_work_status' => $this->input->post('s_work_status'),
			's_any_contact' => $this->input->post('s_any_contact'),
			's_any_contact_notes' => $this->input->post('s_any_contact_notes'),
			's_feeling' => $this->input->post('s_feeling'),
			's_feeling_notes' => $this->input->post('s_feeling_notes'),
			's_department' => $this->input->post('s_department'),
			's_department_notes' => $this->input->post('s_department_notes'),
			's_shift' => $this->input->post('s_shift'),
			's_shift_notes' => $this->input->post('s_shift_notes'),
			's_reside' => $this->input->post('s_reside'),
			's_reside_notes' => $this->input->post('s_reside_notes'),
		];
		
		if(!empty($this->input->post('s_last_work'))){
			$data_array += [ 's_last_work' => date('Y-m-d', strtotime($this->input->post('s_last_work'))) ];
		}		
		if(!empty($this->input->post('s_date_of_symptom'))){
			$data_array += [ 's_date_of_symptom' => date('Y-m-d', strtotime($this->input->post('s_date_of_symptom'))) ];
		}
		if(!empty($this->input->post('s_date_isolating'))){
			$data_array += [ 's_date_isolating' => date('Y-m-d', strtotime($this->input->post('s_date_isolating'))) ];
		}
				
		$cl_type = 'condition';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type, $time_interval);
		
		$sqlcheck = "SELECT count(*) as value from contact_tracing_follett_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('contact_tracing_follett_info', $data_array);
			$flag = "update";
		} 
		else {
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('contact_tracing_follett_info', $data_array);
			$flag = "insert";
		}
		
		if($flag == "update"){ $this->sendtoform('4',$crm_id, 'update'); }
		if($flag == "insert"){ $this->sendtoform('4',$crm_id, 'success'); }
		if($flag == "error"){ redirect('contact_tracing_follett/case_search'); }
		if($flag == "closure"){ $this->covid_case_move_next($crm_id);  }
	}
	
	
	// 4. Exposure
	public function submit_exposure()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$time_interval = $this->input->post('time_interval');
		$e_type = "exposure";
		$flag = "error";
		
		for($i=0; $i<17; $i++){
			
			$e_day = $i-2;
			$data_array = [
				'e_date' => $this->input->post('e_date_'.$i),
				'e_location' => $this->input->post('e_location_'.$i),
				'e_contacts' => $this->input->post('e_contacts_'.$i),
				'e_type' => $e_type,
			];
			
			$sqlcheck = "SELECT count(*) as value from contact_tracing_follett_exposure WHERE crm_id = '$crm_id' AND e_day = '$e_day' AND e_type = '$e_type'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0)
			{
				$this->db->where('crm_id', $crm_id);
				$this->db->where('e_day', $e_day);
				$this->db->where('e_type', $e_type);
				$this->db->update('contact_tracing_follett_exposure', $data_array);
				$flag = "update";
			} 
			else {
				$data_array += [ 'crm_id' => $crm_id, 'e_day' => $e_day ];
				data_inserter('contact_tracing_follett_exposure', $data_array);
				$flag = "insert";
			}
		}
		
		
		$cl_type = 'exposure';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type, $time_interval);
		
		if($flag == "update"){ $this->sendtoform('5',$crm_id, 'update'); }
		if($flag == "insert"){ $this->sendtoform('5',$crm_id, 'success'); }
		if($flag == "error"){ redirect('contact_tracing_follett/case_search'); }
		
	}
	
	
	// 5. Final
	public function submit_final_information()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$time_interval = $this->input->post('time_interval');
		
		$flag = "error";		
		$data_array = [
			'f_individuals' => $this->input->post('f_individuals'),
			'f_other_individual' => $this->input->post('f_other_individual'),
			'f_is_positive_working' => $this->input->post('f_is_positive_working'),
			'f_is_third_party' => $this->input->post('f_is_third_party'),
			'f_notes' => $this->input->post('f_notes')
		];
				
		$cl_type = 'final';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type, $time_interval);
		
		$sqlcheck = "SELECT count(*) as value from contact_tracing_follett_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('contact_tracing_follett_info', $data_array);			
			$caseStatusUD = $this->input->post('case_final_status');
			$this->update_case_status_db($crm_id, $caseStatusUD);
			$flag = "update";
		} 
		else {
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('contact_tracing_follett_info', $data_array);
			$flag = "insert";
		}
		
		$emailID = $this->get_master_emailIDs();
		$this->send_email_contact_tracing_check($crm_id, $emailID, $current_user);
		
		if($flag == "update"){ $this->covid_case_move_next($crm_id); }
		if($flag == "insert"){ $this->covid_case_move_next($crm_id); }
		if($flag == "error"){ redirect('contact_tracing_follett/case_search'); }
		if($flag == "closure"){ $this->covid_case_move_next($crm_id);  }
	}
	
	
	
	public function update_case_status()
	{			
		$crmID = $this->uri->segment(3);
		if(empty($crmID)){
			$crmID = $this->input->get('cid');
		}
		$status = 'C';
		$data_array = [
			'case_status' => $status,			
		];
		$updateStatus = $this->update_case_status_db($crmID, 'C');
		if($updateStatus){
			redirect($_SERVER['HTTP_REFERER'].'/success');
		} else {
			redirect($_SERVER['HTTP_REFERER'].'/error');
		}
	}
	
	public function update_case_status_db($crmID, $status = 'P')
	{			
		$data_array = [
			'case_status' => $status,			
		];
		$sqlcheck = "SELECT count(*) as value from contact_tracing_follett WHERE crm_id = '$crmID'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crmID);
			$this->db->update('contact_tracing_follett', $data_array);
			return true;
		} else {
			return false;
		}
	}
	
	
	//=========================== MASTER LOCATION =================================//
		
	public function master_countries()
	{
		$sql = "SELECT * FROM master_countries ORDER BY name ASC";
		$query = $this->Common_model->get_query_result_array($sql);
		$lastdata = $this->uri->segment($this->uri->total_segments());
		if($lastdata == 'data'){ 
			echo json_encode($query);
		} else {
			return $query;
		}
	}
	
	public function master_states()
	{
		$country = $this->input->post('country');
		if(empty($country)){ $country = $this->uri->segment(3); }
		if(!empty($country)){ $extrafilter = " AND country_id = '$country' "; }
		
		$sql = "SELECT * FROM master_states WHERE 1 $extrafilter ORDER BY name ASC";
		$query = $this->Common_model->get_query_result_array($sql);
		$lastdata = $this->uri->segment($this->uri->total_segments());
		if($lastdata == 'data'){ 
			echo json_encode($query);
		} else {
			return $query;
		}
	}
	
	public function master_cities()
	{
		$state = $this->input->post('state');
		if(empty($state)){ $state = $this->uri->segment(3); }
		if(!empty($state)){ $extrafilter = " AND state_id = '$state' "; }
		
		$sql = "SELECT * FROM master_cities WHERE 1 $extrafilter ORDER BY name ASC";
		$query = $this->Common_model->get_query_result_array($sql);
		$lastdata = $this->uri->segment($this->uri->total_segments());
		if($lastdata == 'data'){ 
			echo json_encode($query);
		} else {
			return $query;
		}
	}
	
	
	// INTELLIGENCE DATA ANALYZE
	public function ai_check_address($crmid)
	{
		$get_filled_details = $this->covid_case_details($crmid);
		$p_address = $get_filled_details['p_address'];
		$p_country = $get_filled_details['p_country'];
		$p_state = $get_filled_details['p_state'];
		$p_city = $get_filled_details['p_city'];
		$check_address = "SELECT ci.*, c.* from covid19_case_info as ci 
		LEFT JOIN covid19_case as c ON c.crm_id = ci.crm_id  
		WHERE (ci.p_address LIKE '%$p_address%' 
		OR (ci.p_country LIKE '%$p_country%' AND ci.p_state LIKE '%$p_state%' AND ci.p_city LIKE '%$p_city%'))
		AND ci.crm_id NOT IN ('$crmid') AND c.case_status = 'POSITIVE'";
		$query_address = $this->Common_model->get_query_result_array($check_address);
		return $query_address;		
	}
	
	
	// LOCK - UNLOCK CASES
	public function unlock()
	{
		$crmid = $this->uri->segment(3);
		$backto = $this->uri->segment(4);
		$flag = "error";
		
		$data_array = [ "ongoing_status" => 'P' ];
		
		$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crmid'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0){ 
			$this->db->where('crm_id', $crmid);
			$this->db->update('covid19_case', $data_array);
			$flag = "update";
		}
		
		if($flag = "update"){ redirect('covid_case/form/'.$crmid.'/'.$backto.'/update'); }
		if($flag = "error"){ redirect('covid_case/form/'.$crmid.'/'.$backto); }
		
	}
	
	public function lock()
	{
		$crmid = $this->uri->segment(3);
		$backto = $this->uri->segment(4);
		$flag = "error";
		
		$data_array = [ "ongoing_status" => 'N' ];
		
		$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crmid'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0){ 
			$this->db->where('crm_id', $crmid);
			$this->db->update('covid19_case', $data_array);
			$flag = "update";
		}
		
		if($flag = "update"){ redirect('covid_case/form/'.$crmid.'/'.$backto.'/update'); }
		if($flag = "error"){ redirect('covid_case/form/'.$crmid.'/'.$backto); }
		
	}
	

	//========================= SEND EMAIL =========================================================//
	
	
	public function get_form_public_url()
	{
		$formBaseUrl = "https://10.100.10.153/covid19/form/";
		return $formBaseUrl;
		
	}
	
	public function send_email()
	{
		$current_user = get_user_id();
		//$crmid = $this->uri->segment(3);
		$form_crm_id = $this->input->post('form_crm_id');
		$form_email_id = $this->input->post('form_email_id');
		$form_send_type = $this->input->post('form_send_type');
		
		if(!empty($form_crm_id) && !empty($form_email_id))
		{
			$this->send_email_contact_tracing_check($form_crm_id, $form_email_id, $current_user, 'mail');
		}	
		if($form_send_type == 1){
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	
	public function send_email_contact_tracing_check($crmid = '', $emailid = '', $uid = '', $type='crm')
	{
		$eto="";
		$ecc="";
		$nbody="";
		if(!empty($crmid)){		
		$qSql="SELECT c.*, ci.* from contact_tracing_follett as c LEFT JOIN contact_tracing_follett_info as ci ON ci.crm_id = c.crm_id WHERE c.crm_id = '$crmid'";
		$contactQ = $this->Common_model->get_query_row_array($qSql);
		if(count($contactQ) > 0)
		{	
			if($contactQ['is_mail'] != 1 && $type == 'crm'){
				$dataUpdateArray = [ "is_mail" =>  1 ];
				$this->db->where('cid', $contactQ['cid']);
				$this->db->update('contact_tracing_follett', $dataUpdateArray);
			}
			
			if(($contactQ['is_mail'] != 1 && $type == 'crm') || $type == 'mail'){
				
				$email_subject = "New Case | Follett | ".$contactQ['fname'] ." " .$contactQ['lname'] ." | " .$contactQ['caller_store_location'] ." | " .$contactQ['crm_id'];
				$eto = $emailid;
				if(empty($eto)){ $eto = "sachin.paswan@fusionbposervices.com"; }
				//$ecc = 'sachin.paswan@fusionbposervices.com';
				$from_email="noreply.fems@fusionbposervices.com";
				$from_name="Fusion FEMS";
				
				$caseTypes = $this->master_case_types();
				
				$nbody='<b>CONTACT TRACING FOLLETT</b><br/><br/>
							New Case Entry Found on ' .	$contactQ["date_of_call"] .'
						</br>
						</br>
								
						<b>CASE Details :</b><br/></br>
						<table border="1" width="80%" cellpadding="0" cellspacing="0">
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Case ID:</td>
									<td style="padding:2px 0px 2px 8px">'.$contactQ["crm_id"].'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Name:</td>
									<td style="padding:2px 0px 2px 8px">'.$contactQ["fname"] .' ' .$contactQ["lname"].'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Phone:</td>
									<td style="padding:2px 0px 2px 8px">'.$contactQ["caller_phone"].'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Case Type:</td>
									<td style="padding:2px 0px 2px 8px">'.$caseTypes[$contactQ["p_type_of_case"]].'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Is Exposed:</td>
									<td style="padding:2px 0px 2px 8px">'.$contactQ["p_is_incident"].'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Symptoms:</td>
									<td style="padding:2px 0px 2px 8px">'.$contactQ["s_symptoms"].'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Diagnosed as Positive:</td>
									<td style="padding:2px 0px 2px 8px">'.$contactQ["p_is_diagonised"].'</td>
								</tr>
						</table>
						
						<br/><br/>
						** Case Details have been attached, please check your attachment.
						
					</br>
					</br>
					</br>
							
					Regards, </br>
					Fusion - FEMS	</br>
					';
				
				$this->generate_crm_report_pdf($contactQ["crm_id"], 'F');
				$crmID   = $contactQ["crm_id"];
				$pdfFilePath = "contact_tracing_" .$crmID.".pdf";
				$uploadDir = FCPATH.'/uploads/contact_tracing/follett/'.$crmID.'/' .$pdfFilePath;

				
				$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, $uploadDir,$from_email,$from_name,'N');	
				//$this->test_send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, $uploadDir,$from_email,$from_name,'N');	
				
				// LOGGER			
				$mailData = [
					"type" => 'follett',
					"mail_to" => $eto,
					"mail_cc" => $ecc,
					"mail_subject" => $email_subject,
					"mail_id" => $contactQ["cid"],
					"mail_crm_id" => $contactQ["crm_id"],
					"mail_trigger" => $type,
					"added_by" => get_user_id(),
					"date_added" => CurrMySqlDate(),
					"logs" => get_logs()				
				];
				$this->covid_email_sent_logs($mailData);
			
			}
			
		}
		}			
				
	}
			
	public function covid_email_sent_logs($data)
	{
		if(!empty($data)){
			data_inserter('contact_tracing_mail_logs', $data);
		}
	}
	
	//=================================== CRM REPORT =============================================//
	
	public function case_report()
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
		
		$data['caseTypes'] = $caseTypes = $this->master_case_types();
		
		$currStartDate = date('Y-m-01', strtotime(CurrDate())); 
		$currEndDate = CurrDate();
		$currMainType = "";
		$currCaseType = "";
		$currReportType = "excel";
		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')))
		{
			$currStartDate = date('Y-m-d', strtotime($this->input->get('start_date')));
			$currEndDate = date('Y-m-d', strtotime($this->input->get('end_date')));
			$currMainType = $this->input->get('main_type');
			$currCaseType = $this->input->get('case_status');
			$currReportType = $this->input->get('report_type');
			
			$filter_MainType = "";
			$filter_CaseType = "";
			if(!empty($currMainType)){ $filter_MainType = " AND i.p_type_of_case = '$currMainType'"; }
			if(!empty($currCaseType) && $currCaseType != 'P'){ $filter_CaseType = " AND c.case_status = '$currCaseType'"; }
			$_sql = "SELECT c.*, i.*, CONCAT(s.fname, ' ', s.lname) as added_by_name, s.office_id, s.fusion_id from contact_tracing_follett as c 
			         LEFT JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id
					 LEFT JOIN signin as s ON s.id = c.added_by
					 WHERE c.date_of_call >= '$currStartDate' AND c.date_of_call <= '$currEndDate' $filter_MainType $filter_CaseType";
			$data['resultData'] = $resultData = $this->Common_model->get_query_result_array($_sql);
			$this->generate_crm_report_xls($currStartDate, $currEndDate, $resultData);
		}
		$data['start_date'] = date('m/d/Y', strtotime($currStartDate));
		$data['end_date'] = date('m/d/Y', strtotime($currEndDate));
		$data['main_type'] = $currMainType;
		$data['case_type'] = $currCaseType;
		$data['report_type'] = $currReportType;
		
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_report.php";			
		$data["content_js"] = "contact_tracing/folletts/contact_tracing_follett_list_js.php";			
		
		$this->load->view('dashboard',$data);
	}
	
	//====================== GENERATE ARCHIEVE ===========================//
	
	public function generate_crm_archieve($reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "contact_tracing_follett_archieve"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/contact_tracing_follett_report.xlsx";
		$this->zip->read_file($csvfile, "contact_tracing_follett_report.xlsx");
		
        foreach ($reportArray as $token)
		{
			$crm_id   = $token["crm_id"];
			$firstname = $token["fname"];
			$fileName = FCPATH.'/uploads/contact_tracing/follett/'.$crm_id.'/'.'contact_tracing_' .$crm_id.'.pdf';
			
			$newFileName = "case_".$crm_id."_".$firstname.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName)){
				$this->zip->read_file($fileName, $newFileName);
			}			
        }		
        $this->zip->download($zipFileName.'.zip');		
	}
	
	
	public function generate_crm_report_xls($from_date ='', $to_date='', $crm_list, $type = 'excel')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['caseTypes'] = $caseTypes = $this->master_case_types();
		$data['workTypes'] = $workTypes = $this->master_case_work_status();
		$title = "FOLLETT RECORDS";
		$sheet_title = "CONTACT TRACING - FOLLETT RECORDS (" .date('Y-m-d',strtotime($from_date)) ." - " .date('Y-m-d',strtotime($to_date)).")";
		$file_name = "Contact_Tracing_Records_".date('Y-m-d',strtotime($from_date));
				
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AT1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
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
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AH')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AI')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AJ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AK')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AL')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AM')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AN')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AO')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AP')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AQ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AR')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AS')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AT')->setAutoSize(true);
		
		
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
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AT2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AT2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "CRM ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date of Call");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Case Status");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Name");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Phone");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Secondary Phone");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Store Location");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Manager");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Is Exposed?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Exposure Info");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Exposure Status");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Has been Diagnosed as Positive?");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Diagnosed Details");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date of Test");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date of Result");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Caller Symptoms");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Exposure Event");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notes");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Last Work");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Symptoms Date");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Self Isolating");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "COVID safety protocols followed");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Cleaning of Work Area");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Work Status");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Close contact with any Team Member");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notes");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Have any shortness of breath?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notes");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "May I ask what department you work");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notes");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Also, what shift do you work on?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notes");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Do you reside with any other Team Members employed at your same location?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notes");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Are there 2 or more individuals who have been in contact with the Positive team member within the last 14 days?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Are there other individuals who have tested positive from the same location within the last 14 days?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Are you still actively working onsite?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Is the caller a 3rd party (trash collector, police officer, someone who came in contact at the location but does not work there)? Or is the call about a 3rd Party?");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notes");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Added By");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date Added");	
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 10 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 10 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 10 ));
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 10 ));
		
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{	
			$currentCol = $i+2;
			$bgv_color = "";
			if(!empty($wv['p_type_of_case'])){
				$bgv_color = $wv['p_type_of_case'] == 'A' || $wv['p_type_of_case'] == 'B' || $wv['p_type_of_case'] == 'E' ? $noArray : $yesArray;
				$backColour = $wv['p_type_of_case'] == 'A' || $wv['p_type_of_case'] == 'B' || $wv['p_type_of_case'] == 'E' ? "ff8b8b" : "fffb8b";
				$this->objPHPExcel->getActiveSheet()->getStyle('L'.$currentCol)->applyFromArray($bgv_color);
				$this->objPHPExcel->getActiveSheet()->getStyle('L'.$currentCol)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($backColour);
			}
		
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["crm_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['date_of_call']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['case_status'] == 'C' ? 'Closed' : 'Open');			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fname"] ." " .$wv["lname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["caller_phone"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["store_phone"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["caller_store_location"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["caller_store_manager"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["p_is_incident"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["p_incident"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, !empty($wv["p_type_of_case"]) ? $caseTypes[$wv["p_type_of_case"]] : "");
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["p_is_diagonised"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["p_is_diagonised_details"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["p_date_of_test"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["p_date_of_result"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_symptoms"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_exposure_event"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_exposure_notes"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_last_work"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_date_of_symptom"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_date_isolating"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_protocol_followed"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_cleaning"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, !empty($wv["s_work_status"]) ? $workTypes[$wv["s_work_status"]] : "");
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_any_contact"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_any_contact_notes"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_feeling"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_feeling_notes"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_department"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_department_notes"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_shift"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_shift_notes"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_reside"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["s_reside_notes"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["f_individuals"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["f_other_individual"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["f_is_positive_working"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["f_is_third_party"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["f_notes"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["added_by_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added"])));
			$i++;
			
			
			
			if($type == 'pdf')
			{
				//$this->generate_crm_report_pdf($wv["id"], 'F');
			}
			
		}
		
		if($type == 'excel')
		{
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);
			$objWriter->save('php://output');
			exit(); 
		}
		
		if($type == 'pdf')
		{
			$filename = "./assets/reports/contact_tracing_follett.xlsx";
			ob_end_clean();
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);	
			$objWriter->save($filename);
			return $filename;
		}
		
	}
	
	
	///===================== EXCEL REPORT =================================//
	
	public function generate_cases_analytic_reports_xls($data)
	{
		$excel_Type = "Follett Case Anaytics";
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
		
		$data['caseTypes'] = $caseTypes = $this->master_case_types();
		$data['workTypes'] = $workTypes = $this->master_case_work_status();
		
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
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Month");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Positive");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Negative");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$grayArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$title = "Follett Case Analytics  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(30); 
		$objWorksheet->getColumnDimension('C')->setWidth(15);
		$objWorksheet->getColumnDimension('D')->setWidth(15);
				
		$counter=0;		
		$c++; $r=0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['search'][$i]['month']);
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['months'][$i]['total']['positive']);
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['months'][$i]['total']['negative']);
		
		$weekCheck = 0; $curentWeek = 0;
		foreach($data['search'][$i]['weekdates'] as $tokenW)
		{
			$curentWeek++;
			$currentDay = $tokenW['week_start'];
			$weekDates = date('d M', strtotime($tokenW['week_start'])) ." - " .date('d M Y', strtotime($tokenW['week_end']));
			if(strtotime($tokenW['week_start']) <= strtotime(date('Y-m-d'))){
			$r=0; $c++;
			$r=0; $c++;
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$c.':C'.$c);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c)->applyFromArray($headerArray);
			$this->objPHPExcel->getActiveSheet()->getRowDimension($c)->setRowHeight(40);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, 'WEEK '.$curentWeek.' ('.$weekDates.')');
			
			$r=0; $c++; $startc = $c;
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->applyFromArray($grayArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f3f3f3');
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Positive");
			
			$sl=0; 
			foreach($data['months'][$i]['weekly'][$weekCheck]['positive'] as $tokenData)
			{
				$c++; $r=0; $sl++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['p_store_location']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['casecounts']);
			}
			
			
			$r=0; $c++; $startc = $c;
			$r=0; $c++; $startc = $c;
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->applyFromArray($grayArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f3f3f3');
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Negative");
			
			$sl=0; 
			foreach($data['months'][$i]['weekly'][$weekCheck]['negative'] as $tokenData)
			{
				$c++; $r=0; $sl++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['p_store_location']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['casecounts']);
			}
			}
			
			$weekCheck++;	
			
			
		}
		
		
				
		//========= EXCEL ANALYTICS ================================//
		$sqlLike = "SELECT *  from contact_tracing_follett as c 
			              INNER JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id
						  WHERE c.date_of_call >= '$start_date_full' AND c.date_of_call <= '$end_date_full'";
		$queryLike = $this->Common_model->get_query_result_array($sqlLike);		
		$likedArray = array_filter($queryLike, function ($var) { return (strtolower(trim($var['p_is_diagonised'])) == 'no'); });
		$dislikedArray = array_filter($queryLike, function ($var) { return (strtolower(trim($var['p_is_diagonised'])) == 'yes'); });
		
		//=========== WORKSHEET 1 - Positive FEEDBACK =====================//
		$excel_Type2 = "Positive Cases";
		$this->objPHPExcel->createSheet(1);
		$this->objPHPExcel->setActiveSheetIndex(1);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(1);
		$objWorksheet->setTitle($excel_Type2);		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet(1)->getHighestRow())->getAlignment()->setWrapText(true);		
		$r=0; $c = 2; $counter=0;
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Caller Name");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Caller Phone");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Case Type");	
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Has Caller Been Diagnosed as Positive ?");	
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Date Of Test");		
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Symptoms");		
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Case Status");		
		$title = "Positive Cases  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:K1');
		$this->objPHPExcel->getActiveSheet(1)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet(1)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A1')->applyFromArray($headerArray);		
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A2:K2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');		
		$objWorksheet->getColumnDimension('A')->setWidth(10);		
		$objWorksheet->getColumnDimension('B')->setWidth(15);		
		$objWorksheet->getColumnDimension('C')->setWidth(20);		
		$objWorksheet->getColumnDimension('D')->setWidth(40);		
		$objWorksheet->getColumnDimension('E')->setWidth(15);		
		$objWorksheet->getColumnDimension('F')->setWidth(40);		
		$objWorksheet->getColumnDimension('G')->setWidth(15);		
		$objWorksheet->getColumnDimension('H')->setWidth(15);		
		$objWorksheet->getColumnDimension('I')->setWidth(20);		
		$objWorksheet->getColumnDimension('J')->setWidth(15);		
		$objWorksheet->getColumnDimension('K')->setWidth(15);		
		foreach($dislikedArray as $token)
		{
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['date_of_call']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['caller_store_location']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['fname'] ." " .$token['lname']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['caller_phone']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, !empty($caseTypes[$token['p_type_of_case']]) ? $caseTypes[$token['p_type_of_case']] : "-");
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['p_is_diagonised']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['p_date_of_test']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['s_symptoms']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['case_status'] == 'C' ? 'Closed' : 'Open');
		}		
		$highestRow = $this->objPHPExcel->getActiveSheet(1)->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet(1)->getHighestColumn();
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		//=========== WORKSHEET 2 - Negative FEEDBACK =====================//
		$excel_Type2 = "Negative Cases";
		$this->objPHPExcel->createSheet(2);
		$this->objPHPExcel->setActiveSheetIndex(2);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(2);
		$objWorksheet->setTitle($excel_Type2);		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet(2)->getHighestRow())->getAlignment()->setWrapText(true);		
		$r=0; $c = 2; $counter=0;
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Caller Name");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Caller Phone");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Case Type");	
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Has Caller Been Diagnosed as Positive ?");	
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Date Of Test");		
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Symptoms");		
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Case Status");	
		$title = "Negative Cases  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(2)->mergeCells('A1:K1');
		$this->objPHPExcel->getActiveSheet(2)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet(2)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A1')->applyFromArray($headerArray);		
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A2:K2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');		
		$objWorksheet->getColumnDimension('A')->setWidth(10);		
		$objWorksheet->getColumnDimension('B')->setWidth(15);		
		$objWorksheet->getColumnDimension('C')->setWidth(20);		
		$objWorksheet->getColumnDimension('D')->setWidth(40);		
		$objWorksheet->getColumnDimension('E')->setWidth(15);		
		$objWorksheet->getColumnDimension('F')->setWidth(40);		
		$objWorksheet->getColumnDimension('G')->setWidth(15);		
		$objWorksheet->getColumnDimension('H')->setWidth(15);		
		$objWorksheet->getColumnDimension('I')->setWidth(20);		
		$objWorksheet->getColumnDimension('J')->setWidth(15);		
		$objWorksheet->getColumnDimension('K')->setWidth(15);			
		foreach($likedArray as $token)
		{
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['date_of_call']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['caller_store_location']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['fname'] ." " .$token['lname']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['caller_phone']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, !empty($caseTypes[$token['p_type_of_case']]) ? $caseTypes[$token['p_type_of_case']] : "-");
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['p_is_diagonised']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['p_date_of_test']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['s_symptoms']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['case_status'] == 'C' ? 'Closed' : 'Open');
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
	
	
	///===================== PDF REPORT =================================//
	
	public function generate_crm_report_pdf($pid = '1', $type = 'D')
	{			
		if(check_logged_in()){
				
			$this->load->library('m_pdf');
			
			$crm_id = $pid;
			if(!empty($this->uri->segment(3))){ $crm_id = $this->uri->segment(3); }			
			if(!empty($this->uri->segment(4))){ 
				if($this->uri->segment(4) == 'download'){ $type = 'D'; } 
				if($this->uri->segment(4) == 'view'){ $type = 'I'; }
			}			
			
			// CHECK DB VERIFY		
			if(!empty($crm_id))
			{
				$_sql_case = "SELECT c.*, i.*, CONCAT(s.fname, ' ', s.lname) as added_by_name, s.office_id as office_location 
				               from contact_tracing_follett as c 
				               LEFT JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id 
				               LEFT JOIN signin as s ON s.id = c.added_by 
							   WHERE c.crm_id = '$crm_id'";
				$case_details = $this->Common_model->get_query_row_array($_sql_case);
				if(!empty($case_details['crm_id']))
				{
					$crm_id = $case_details['crm_id'];
					$exposureDetails = $this->covid_case_details_exposure($crm_id, 'exposure');
			
					$logs_sql = "SELECT l.*, CONCAT(s.fname, ' ', s.lname) as full_name from contact_tracing_follett_logs as l 
					             LEFT JOIN signin as s ON l.cl_added_by = s.id WHERE l.crm_id = '$crm_id' ORDER by l.cl_date_added DESC";
					$log_details = $this->Common_model->get_query_result_array($logs_sql);
				}
			}
			
			$data['crm_id'] = $crm_id;
			$data['crm_details'] = $case_details;
			$data['crmexposure'] = $exposureDetails;
			$data['log_details'] = $log_details;
					
			$data['caseTypes'] = $caseTypes = $this->master_case_types();
			$data['workTypes'] = $caseTypes = $this->master_case_work_status();
			$html=$this->load->view('contact_tracing_crm/folletts/covid_case_pdf', $data,true);
			
			$finalDir = "contact_tracing_invalid.pdf";
			if(!empty($case_details['crm_id'])){ $finalDir = "contact_tracing_".$case_details['crm_id'].".pdf"; }
			
			if((!empty($case_details['crm_id']) && $type == 'F') || $type == 'I' || $type == 'D')
			{
				if($type == 'F')
				{
					$crmID   = $case_details["crm_id"];
					$pdfFilePath = "contact_tracing_" .$crmID.".pdf";
					$uploadDir = FCPATH.'/uploads/contact_tracing/follett/'.$crmID.'/';
					$finalDir = $uploadDir .$pdfFilePath;
					if (!file_exists($uploadDir)) {
						mkdir($uploadDir, 0777, true);
					}				
				}				
				$pdf = new m_pdf();
				//$pdf->pdf->AddPage('L');			
				//$pdf->pdf->shrink_tables_to_fit;;			
				$pdf->pdf->WriteHTML($html);			
				$pdf->pdf->Output($finalDir, $type);
			}
		}			
	}
	
	////============== MAILING LOGS ==========================================//
	
	public function case_mail_report()
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
		
		$data['caseTypes'] = $caseTypes = $this->master_case_types();
		
		$currStartDate = date('Y-m-01', strtotime(CurrDate())); 
		$currEndDate = CurrDate();
		$currMainType = "";
		$currCaseType = "";
		$currReportType = "excel";
		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')))
		{
			$currStartDate = date('Y-m-d', strtotime($this->input->get('start_date')));
			$currEndDate = date('Y-m-d', strtotime($this->input->get('end_date')));
			
			$_sql = "SELECT l.*, c.crm_id, c.cid, c.date_of_call, c.fname, c.lname, c.case_status, CONCAT(s.fname, ' ', s.lname, ' (', s.fusion_id, ')') as added_by_name
			         from contact_tracing_mail_logs as l
			         LEFT JOIN contact_tracing_follett as c ON c.cid = l.mail_id
			         LEFT JOIN contact_tracing_follett_info as i ON i.crm_id = c.crm_id
					 LEFT JOIN signin as s ON s.id = l.added_by
					 WHERE DATE(l.date_added) >= '$currStartDate' AND DATE(l.date_added) <= '$currEndDate' AND l.type = 'follett'";
			$data['resultData'] = $resultData = $this->Common_model->get_query_result_array($_sql);
			$this->generate_crm_mail_report_xls($currStartDate, $currEndDate, $resultData);
		}
		$data['start_date'] = date('m/d/Y', strtotime($currStartDate));
		$data['end_date'] = date('m/d/Y', strtotime($currEndDate));
		$data['report_type'] = $currReportType;
		
		$data["aside_template"] = "contact_tracing_crm/folletts/aside.php";
		$data["content_template"] = "contact_tracing_crm/folletts/covid_case_mail_report.php";			
		$data["content_js"] = "contact_tracing/folletts/contact_tracing_follett_list_js.php";			
		
		$this->load->view('dashboard',$data);
	}
	
	public function generate_crm_mail_report_xls($from_date ='', $to_date='', $crm_list, $type = 'excel')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$title = "FOLLETT MAILING LOGS";
		$sheet_title = "CONTACT TRACING - FOLLETT MAILING RECORDS (" .date('Y-m-d',strtotime($from_date)) ." - " .date('Y-m-d',strtotime($to_date)).")";
		$file_name = "Contact_Tracing_Records_".date('Y-m-d',strtotime($from_date));
				
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:M1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:M1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $sheet_title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "CRM ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date of Call");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Case Status");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Case Name");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mail To");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mail CC");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mail Subject");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mail Type");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mail Date");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mail By");
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 10 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 10 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 10 ));
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 10 ));
		
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{	
			$currentCol = $i+2;
			$bgv_color = "";
		
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["crm_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['date_of_call']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['case_status'] == 'C' ? 'Closed' : 'Open');			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fname"] ." " .$wv["lname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['mail_to']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['mail_cc']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['mail_subject']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['mail_trigger'] == 'crm' ? 'Auto' : 'Manual');			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added"])));
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['added_by_name']);
			$i++;
			
		}
		
		if($type == 'excel')
		{
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);
			$objWriter->save('php://output');
			exit(); 
		}
		
	}
	
	
	/// ================== ONLY FOR TESTING PURPOSE ===========================================================//
	
	public function test_send_email_sox($uid,$eto,$ecc,$ebody,$esubject,$attch_file="",$from_email="noreply.fems@fusionbposervices.com",$from_name="Fusion FEMS", $isBcc="Y")
	{
		
		$ebody .="<br/><br/><p style='font-size:9px'>Note: please do not reply.</p>";
		
		if(trim($from_email)=="")$from_email="noreply.fems@fusionbposervices.com";
		if(trim($from_name)=="")$from_name="Fusion FEMS";
		
		//Open it for testing
		$esubject = " TEST - " . $esubject;
		
		$eto = str_replace(';', ',', $eto);
		$ecc = str_replace(';', ',', $ecc);
		
		//Open it for testing and add your email id
		//$eto = 'sachin.paswan@fusionbposervices.com';
		
		$this->load->library('email');
		$this->email->clear(TRUE);
		
		$this->email->set_newline("\r\n");
		$this->email->from($from_email, $from_name);
		
		$this->email->to($eto);
		
		if($ecc!="") $this->email->cc($ecc);
		
		//$this->email->bcc('kunal.bose@fusionbposervices.com, saikat.ray@fusionbposervices.com, manash.kundu@fusionbposervices.com, arif.anam@fusionbposervices.com');
		//if($isBcc=="Y") $this->email->bcc('saikat.ray@fusionbposervices.com, kunal.bose@fusionbposervices.com');
				
		$this->email->subject($esubject);
		$this->email->message($ebody);
				
		if($attch_file!="") $this->email->attach($attch_file);
		
		//-----------------------------------//
		$ebody=addslashes($ebody);
		$eto=addslashes($eto);
		$esubj=addslashes($esubject);
		
		$myCDate=CurrMySqlDate();	
		if($eto!=""){
			if($this->email->send()){
				return true;
			}else{
				$log=addslashes($this->email->print_debugger());
				return false;
				//show_error($this->email->print_debugger());
			}
		}
		
		
	}
	
	
	/// ================== WEEKLY REPORT ===========================================================//
	
	private function getWeekMonthly($month, $year)
	{
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$startDate = $year."-".$month."-01";
		$endDate   = $year.'-'.$month.'-'.$totalDays;
		$startWeek = date("W", strtotime($startDate));
		$endWeek = date("W", strtotime($endDate));
		$counter = 0; $weekArray = array();
		$counterStartWeek = $startWeek;
		if($startWeek > $endWeek){ $counterStartWeek = 0; }
		for($i=$counterStartWeek; $i<=$endWeek; $i++)
		{
			if($i == 0){
				$yearCheck = $year - 1;
				$weekInfo = $this->getWeekInfo($startWeek, $yearCheck);
				$weekArray[$counter] = $weekInfo;
				$weekArray[$counter]['week'] = sprintf('%02d',$startWeek);
			} else {
				$weekInfo = $this->getWeekInfo($i, $year);
				$weekArray[$counter] = $weekInfo;
				$weekArray[$counter]['week'] = sprintf('%02d',$i);
			}		
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