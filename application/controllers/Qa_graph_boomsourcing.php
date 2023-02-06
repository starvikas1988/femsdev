<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_graph_boomsourcing extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->library('excel');
		//error_reporting(1); 
		//ini_set('display_errors', 1);
		//$this->db->db_debug=true;
		$getExcluded_Audits = array('Calibration', 'Certificate Audit', 'OJT');
		
	}
		
	public function index()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = $this->accessClientIds();
			
			$extra_process_filter = "";
			$extra_client_filter = "";
			$extra_process_each = "";
			if(get_dept_folder()=="operations"){
				$user_client_ids = get_client_ids();
				$user_process_ids = get_process_ids();
				$extra_process_filter = " AND qa.client_id IN ($user_client_ids) ";
				$extra_client_filter = " AND qa.process_id IN ($user_process_ids) ";
				$extra_process_each = "  AND id IN ($user_process_ids) ";
			}
			
			
			// ============  FILTER DATE ========================================//
			
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
						
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
								
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);				
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;
			
			
			// ============  FILTER OFFICE ========================================//
			
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
			}
			$data['selected_office'] = $search_office;
			$checkOffice = explode(',', $search_office);			
			if(count($checkOffice) > 1){
				$search_office = implode("','", $checkOffice);
			}
			
			// ============  FILTER CLIENT ========================================//
			
			$searchFilter = false;
			$search_client_ids = $my_client_ids;
			if(!empty($this->input->get('select_client'))){ 					
				$client_ids = $this->input->get('select_client');
				$search_client_ids = implode(',', $client_ids);
				if($search_client_ids == 'ALL'){ 
					$search_client_ids = ""; 
				} else {
					$searchFilter = true;
				}
			}
			
			$search_process_ids = "";
			if(!empty($this->input->get('select_process'))){ 					
				$process_ids = $this->input->get('select_process');
				$search_process_ids = implode(',', $process_ids);
				if($search_process_ids == 'ALL'){ 
					$search_process_ids = ""; 
				} else {
					//$searchFilter = true;
				}
				
				//echo "<pre>" .print_r($_POST, 1) ."</pre>"; die();
			}
			
			$data['selected_process'] = $search_process_ids;
			$data['selected_client'] = $search_client_ids;
			
			
			
			//===================== DROPDOWN FILTERS ======================================//
			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			// Process Selection
			$processArray = array();
			if(!empty($search_client_ids))
			{
				$sqlProcess = "SELECT p.* from process as p WHERE p.client_id IN ($search_client_ids) AND p.id NOT IN ('304')";
				$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
				$processArray = $queryProcess;
			}
			$data['process_list'] = $processArray;
			
			$getLocationName = array();
			$checkLocation[] = $search_office;
			if($search_office == 'ALL'){
				$checkLocation = array();
				foreach($data['location_list'] as $token){
					$checkLocation[] = $token['abbr'];
					$getLocationName[$token['abbr']] = $token['office_name'];
				}
			}
			
			if(!$searchFilter){			
			
				////=========== TOTAL ACCOUNTS =====================/////
				$sql_account   = "SELECT count(*) as value from process WHERE is_active = '1' $extra_process_each";
				$query_account = $this->Common_model->get_single_value($sql_account);
				

				////========== QA DEFECT - PROGRAMS ===========////
				$sqlTables = "SELECT * from qa_boomsourcing_defect WHERE 1 AND client_id IN ($my_client_ids) AND process_id NOT IN ('304')";
				$queryTables = $this->Common_model->get_query_result_array($sqlTables);
				$qa_table_name = array_column($queryTables, 'table_name');				
				$allData = array(); 
				$final_audit_count = 0;
				$total_programs = 0;
				foreach($queryTables as $token)
				{
					if($token['table_name'] != "qa_amd_patchology_feedback" && $token['table_name'] != "qa_amd_puritycare_new_feedback"){
					$currentTable = trim($token['table_name']);
					$currentProcess = round($token['process_id']);
					$currentClient = $token['client_id'];					
					$processChecker = $token['process_id'] - $currentProcess;
					
					$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, p.name as process_name, c.shname as client_name from $currentTable as qa
					              INNER JOIN signin as s ON s.id = qa.agent_id
					              INNER JOIN process as p ON p.id = '$currentProcess'
					              INNER JOIN client as c ON c.id = '$currentClient'
								  WHERE qa.audit_type = 'CQ Audit' AND (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id IN ('$search_office')";
					$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
					
					$myProcess = !empty($processChecker) ? strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', $currentTable)))) : $c_qaScore['process_name'];
					
					$currentProcessArray = array(						
						"process" => $myProcess,
						"client" => $c_qaScore['client_name'],
						"table" => $currentTable,
						"score" => sprintf('%.2f', $c_qaScore['score']),
						"count" => $c_qaScore['auditCount'],
						"office" => $search_office,
						"start" => $start_date,
						"end" => $end_date,
						"process_id" => $token['process_id'],
						"client_id" => $token['client_id'],
					);
					
					$total_programs++;
					$final_audit_count = $final_audit_count + $c_qaScore['auditCount'];
					$allData[] = $currentProcessArray;
					}
				}
				array_multisort(array_column($allData, 'score'), SORT_DESC, $allData);
				
				$counterCheck = 0;
				foreach($allData as $token)
				{
					if($token['score'] > 0){						
						$counterCheck++;
						if($counterCheck <= 10){						
							// QA SCORE
							$qa_data_value_array[] = $token['score'];
							$qa_data_label_array[] = $token['process']; 					
							$qa_data_process_array[] = $token['process_id']; 
							
							$processID = $token['process_id'];
							
							// GET TARGET SCORE
							$processID = $token['process_id'];
							$sqlTarget = "SELECT * from target_qa_score WHERE process_id = '$processID' AND month = '$search_month' AND year = '$search_year'  AND office_id IN ('$search_office') ORDER by id DESC LIMIT 1";
							$queryTarget = $this->Common_model->get_query_row_array($sqlTarget);
							$target_score = $queryTarget['target_score'];
							if(empty($target_score)){ $target_score = 0; }
							$qa_data_target_array[] = $target_score;
							
							$c_defect_table   = $token['table'];
							$current_process_id   = $token['process_id'];
							$current_process_name = $token['process'];
							$csatscore = $this->get_qa_boomsourcing_defect_csat_score($c_defect_table, $start_date, $end_date, $search_office);
							$npsscore = $this->get_qa_boomsourcing_defect_nps_score($c_defect_table, $start_date, $end_date, $search_office);
							$data_csat_value_array[] = round($csatscore,2);
							$data_nps_value_array[] = round($npsscore,2);						
						}
					}
				}				
				$csatmaxvalue = !empty($data_csat_value_array) ? ceil(max($data_csat_value_array) / 10) * 10 : "0";
				$npsmaxvalue = !empty($data_nps_value_array) ? ceil(max($data_nps_value_array) / 10) * 10 : "0";
				if($csatmaxvalue >= $npsmaxvalue){ $maximum_y_limit = $csatmaxvalue + 30; }
				if($npsmaxvalue >= $csatmaxvalue){ $maximum_y_limit = $npsmaxvalue + 30; }
				$data['max_y_limit'] = $maximum_y_limit;
				
				if(empty($qa_data_value_array)){ $qa_data_value_array[] = "0"; $qa_data_label_array[] = "No Records Found"; }
				
				$data['total_account'] = $total_programs;
				$data['total_audit'] = $final_audit_count;
				
				$data['qa_data_label'] = $qa_data_label = !empty($qa_data_label_array) ? implode('","', $qa_data_label_array) : '';
				$data['qa_data_value'] = $qa_data_value = !empty($qa_data_value_array) ? implode(',', $qa_data_value_array) : '';
				$data['qa_target_value'] = $qa_target_value = !empty($qa_data_target_array) ? implode(',', $qa_data_target_array) : '';
				$data['qa_csat_value'] = $qa_csat_value = !empty($data_csat_value_array) ? implode(',', $data_csat_value_array) : '';
				$data['qa_nps_value'] = $qa_nps_value = !empty($data_nps_value_array) ? implode(',', $data_nps_value_array) : '';
										
			} else {
				
				
				$total_account = 0;
				$final_audit_count = 0;
				$maximum_y_limit = 100;			
				
				$qa_data_label_array = array();
				$qa_data_value_array = array();
				$qa_data_target_array = array();
				$data_csat_value_array = array();
				$data_nps_value_array = array();
				
				
				// GET PROCESS IDS
				$sqlProcess = "SELECT p.*, c.shname as client_name from process as p 
							   LEFT JOIN client as c ON c.id = p.client_id
							   WHERE p.client_id IN ($search_client_ids)  AND p.client_id IN ($my_client_ids)  AND p.id NOT IN ('304') AND p.is_active = 1";
				$dataProcessIds = $this->Common_model->get_query_result_array($sqlProcess);
				$_processIDs = array_column($dataProcessIds, 'id');
				$searchedProcessIds = implode(',', $_processIDs);
				$get_process_ids = $searchedProcessIds;
				if(!empty($process_ids) && $process_ids != "ALL"){
					$get_process_ids = $search_process_ids;
				}
				
				if(!empty($get_process_ids)){
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE FLOOR(q.process_id) IN ($get_process_ids) AND q.client_id IN ($search_client_ids) AND q.process_id NOT IN ('304') ";
				$get_defect_columns = $this->Common_model->get_query_result_array($sql_defect_columns);
				foreach($get_defect_columns as $tokenCol)
				{
					$total_account++;
					
					$g_processID              =  round($tokenCol['process_id']);
					$c_processID              =  $tokenCol['process_id'];
					$c_clientID               =  $tokenCol['client_id'];
					$c_processName            =  $tokenCol['process_name'];
					$c_clientName             =  $tokenCol['client_name'];
					$c_defect_table           =  trim($tokenCol['table_name']);
					$c_defect_column_key      =  $tokenCol['defect_columns'];
					$c_defect_column_name_key =  $tokenCol['defect_column_names'];
					
					// PROCESS NAME
					$_preProcessName = strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', $c_defect_table))));
					if(empty($c_processName)){ $c_processName = $_preProcessName; }	

					$extraSearchOffice = "";
					if(!empty($search_office) && $search_office != "ALL")
					{
						$extraSearchOffice = " AND s.office_id IN ('$search_office')";
					}
					
					foreach($checkLocation as $tokenLoc){
						
					$extraSearchOffice = "";
					if(!empty($tokenLoc) && $tokenLoc != "ALL")
					{
						$extraSearchOffice = " AND s.office_id IN ('$tokenLoc')";
					}
					
					// CQ SCORE
					$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
					              INNER JOIN signin as s ON s.id = qa.agent_id
								  WHERE qa.audit_type = 'CQ Audit' AND (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $extraSearchOffice";
					$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
					
					$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
					$final_audit_count = $final_audit_count + $c_auditCount;
					
					$data['process'][$currentProcessID]['name'] = $c_processName;
					$data['process'][$currentProcessID]['client'] = $c_clientName;
					$data['process'][$currentProcessID]['score'] = !empty($c_qaScore['score']) ? $c_qaScore['score'] : 0;
					$data['process'][$currentProcessID]['sdate'] = $start_date;
					$data['process'][$currentProcessID]['edate'] = $end_date;
										
					// FOR GRAPH
					$qa_data_value_array[] = round($c_qaScore['score'],2);
					$qa_data_label_array[] = $c_processName; 					
					//$qa_data_label_array[] = !empty($getLocationName[$tokenLoc]) ? $getLocationName[$tokenLoc] : $tokenLoc; 					
					$qa_data_process_array[] = $c_processID; 
					
					$csatscore = $this->get_qa_boomsourcing_defect_csat_score($c_defect_table, $start_date, $end_date, $tokenLoc);
					$npsscore = $this->get_qa_boomsourcing_defect_nps_score($c_defect_table, $start_date, $end_date, $tokenLoc);
					$data_csat_value_array[] = round($csatscore,2);
					$data_nps_value_array[] = round($npsscore,2);
					
					$csatscore = $this->get_qa_boomsourcing_defect_csat_score($c_defect_table, $start_date, $end_date, $search_office);
					$npsscore = $this->get_qa_boomsourcing_defect_nps_score($c_defect_table, $start_date, $end_date, $search_office);
					$data_csat_value_array[] = round($csatscore,2);
					$data_nps_value_array[] = round($npsscore,2);
					
					if(!empty($tokenLoc) && $tokenLoc != "ALL")
					{
						$sqlTarget = "SELECT * from target_qa_score WHERE process_id = '$c_processID' AND month = '$search_month' AND year = '$search_year' AND office_id IN ('$search_office') AND client_id = '$c_clientID' ORDER by id DESC LIMIT 1";
						$queryTarget = $this->Common_model->get_query_row_array($sqlTarget);
						$target_score = $queryTarget['target_score'];
					} else {
						$sqlTarget = "SELECT * from target_qa_score WHERE process_id = '$c_processID' AND month = '$search_month' AND year = '$search_year' AND office_id  IN ('$search_office') AND client_id = '$c_clientID' ORDER by target_score DESC LIMIT 1";
						$queryTarget = $this->Common_model->get_query_row_array($sqlTarget);
						$target_score = $queryTarget['target_score'];
					}
					
					if(empty($target_score)){ $target_score = 0; }
					$qa_data_target_array[] = $target_score;
					
					}
					
				}
				
				
				$csatmaxvalue = !empty($data_csat_value_array) ? ceil(max($data_csat_value_array) / 10) * 10 : "0";
				$npsmaxvalue = !empty($data_nps_value_array) ? ceil(max($data_nps_value_array) / 10) * 10 : "0";
				if($csatmaxvalue >= $npsmaxvalue){ $maximum_y_limit = $csatmaxvalue + 30; }
				if($npsmaxvalue >= $csatmaxvalue){ $maximum_y_limit = $npsmaxvalue + 30; }
				$data['max_y_limit'] = $maximum_y_limit;
				
				if(empty($qa_data_value_array)){ $qa_data_value_array[] = "0"; $qa_data_label_array[] = "No Records Found"; }
						
				
				}
				
				$data['total_account'] = $total_account;
				$data['total_audit'] = $final_audit_count;
				$data['max_y_limit'] = $maximum_y_limit;				
				$data['qa_data_label'] = $qa_data_label = !empty($qa_data_label_array) ? implode('","', $qa_data_label_array) : '';
				$data['qa_data_value'] = $qa_data_value = !empty($qa_data_value_array) ? implode(',', $qa_data_value_array) : '';
				$data['qa_target_value'] = $qa_target_value = !empty($qa_data_target_array) ? implode(',', $qa_data_target_array) : '';
				$data['qa_csat_value'] = $qa_csat_value = !empty($data_csat_value_array) ? implode(',', $data_csat_value_array) : '';
				$data['qa_nps_value'] = $qa_nps_value = !empty($data_nps_value_array) ? implode(',', $data_nps_value_array) : '';
				
				$data['alllocation'] = $checkLocation;
			
			
			}		
			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_graph_boomsourcing/Qa_graph_boomsourcing_score_test.php";
							
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	//===================================================================================================================================//
	// QA GRAPH WEEK/MONTH/DAILY
	//===================================================================================================================================//
	
	public function summary()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = $this->accessClientIds();
			
			$extra_process_filter = "";
			$extra_client_filter = "";
			$extra_process_each = "";
			if(get_dept_folder()=="operations"){
				$user_client_ids = get_client_ids();
				$user_process_ids = get_process_ids();
				$extra_process_filter = " AND qa.client_id IN ($user_client_ids) ";
				$extra_client_filter = " AND qa.process_id IN ($user_process_ids) ";
				$extra_process_each = "  AND id IN ($user_process_ids) ";
			}
			
			$data['currentGraphType'] = $currentGraphType = "";
			$currentGraphType = $this->uri->segment(3);
			if(strtolower($currentGraphType) == 'monthly' || strtolower($currentGraphType) == 'weekly' || strtolower($currentGraphType) == 'daily' || strtolower($currentGraphType) == 'overview'){
				$data['currentGraphType'] = $currentGraphType;
			} else {
				redirect('Qa_graph_boomsourcing/summary/monthly');
			}
			
			
			// ============  FILTER DATE ========================================//
			
			
			// ============  FILTER YEAR ========================================//
			$search_year = $user_office_id;
			if(!empty($this->input->get('select_year'))){ 					
				$search_year = $this->input->get('select_year');
			}
			$data['selected_year'] = $search_year;
			
			// ============  FILTER OFFICE ========================================//
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
			}
			$data['selected_office'] = $search_office;
			
			// ============  FILTER DATES ========================================//
			$search_start_date = date('Y-m-01');
			if(!empty($this->input->get('select_start_date'))){ 					
				$search_start_date = date('Y-m-d', strtotime($this->input->get('select_start_date')));
			}
			$data['selected_start_date'] = $search_start_date;
			
			$search_end_date = date('Y-m-d');
			if(!empty($this->input->get('select_end_date'))){ 					
				$search_end_date =  date('Y-m-d', strtotime($this->input->get('select_end_date')));
			}
			$data['selected_end_date'] = $search_end_date;
			
			
			// ============  FILTER MONTH ========================================//
			$searchFilter = false; $monthCounts = 1;
			$search_months_ids = "";
			if(!empty($this->input->get('select_allmonth'))){ 					
				$month_ids = $this->input->get('select_allmonth');
				$search_months_ids = implode(',', $month_ids);
				if($search_months_ids == 'ALL'){ 
					$search_months_ids = "";
					$monthCounts = 12;
				} else {
					$monthCounts = count($month_ids);
					$searchFilter = true;
				}
			}			
			$data['selected_allmonth'] = $search_months_ids;
			
			// ============  FILTER CLIENT ========================================//			
			$searchFilter = false;
			$search_client_ids = $my_client_ids;
			if(!empty($this->input->get('select_client'))){ 					
				$client_ids = $this->input->get('select_client');
				$search_client_ids = implode(',', $client_ids);
				if($search_client_ids == 'ALL'){ 
					$search_client_ids = ""; 
				} else {
					$searchFilter = true;
				}
			}
			
			$search_process_ids = "";
			if(!empty($this->input->get('select_process'))){ 					
				$process_ids = $this->input->get('select_process');
				$search_process_ids = implode(',', $process_ids);
				if($search_process_ids == 'ALL'){ 
					$search_process_ids = ""; 
				} else {
					$searchFilter = true;
				}
			}
			if(empty($this->input->get('select_process')) && !empty($this->input->get('select_client')))
			{
				$sq_process_ids = "SELECT GROUP_CONCAT(id) as value from process WHERE client_id IN ($search_client_ids)";
				$search_process_ids = $this->Common_model->get_single_value($sq_process_ids);
			}
			
			$data['selected_process'] = $search_process_ids;
			$data['selected_client'] = $search_client_ids;
			
			
			
			//===================== DROPDOWN FILTERS ======================================//
			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1  AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			// Process Selection
			$processArray = array();
			if(!empty($search_client_ids))
			{
				$sqlProcess = "SELECT p.* from process as p WHERE p.client_id IN ($search_client_ids) AND p.client_id IN ($my_client_ids)  AND p.id NOT IN ('304') ";
				$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
				$processArray = $queryProcess;
			}
			$data['process_list'] = $processArray;
			
			
			if(!$searchFilter){
					
			} else {
				
				$total_account = 0;
				$final_audit_count = 0;
				$maximum_y_limit = 100;	
				
				$campaignArray = array();
				$monthArray = array();
				$monthList = array();
				$weekCQ = array();				
				
				// GET PROCESS IDS
				$sqlProcess = "SELECT p.*, c.shname as client_name from process as p 
							   LEFT JOIN client as c ON c.id = p.client_id
							   WHERE p.client_id IN ($search_client_ids)  AND p.client_id IN ($my_client_ids) AND p.is_active = 1 AND p.id NOT IN ('304') ";
				$dataProcessIds = $this->Common_model->get_query_result_array($sqlProcess);
				$_processIDs = array_column($dataProcessIds, 'id');
				$searchedProcessIds = implode(',', $_processIDs);
				$get_process_ids = $searchedProcessIds;
				if(!empty($process_ids)){
					$get_process_ids = $search_process_ids;
				}
				
				
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE FLOOR(q.process_id) IN ($get_process_ids) AND q.client_id IN ($search_client_ids) AND q.process_id NOT IN ('304') ";
				$get_defect_columns = $this->Common_model->get_query_result_array($sql_defect_columns);
				foreach($get_defect_columns as $tokenCol)
				{
					$total_account++;
					
					$g_processID              =  round($tokenCol['process_id']);
					$c_processID              =  $tokenCol['process_id'];
					$c_clientID               =  $tokenCol['client_id'];
					$c_processName            =  $tokenCol['process_name'];
					$c_clientName             =  $tokenCol['client_name'];
					$c_defect_table           =  trim($tokenCol['table_name']);
					$c_defect_column_key      =  $tokenCol['defect_columns'];
					$c_defect_column_name_key =  $tokenCol['defect_column_names'];
					
					$campaignArray[] = $tokenCol;
					
					// PROCESS NAME
					$_preProcessName = strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', $c_defect_table))));
					if(empty($c_processName)){ $c_processName = $_preProcessName; }				
					
					
					if($currentGraphType == 'monthly')
					{
						$monthList['names'] = NULL;
						$monthList['id'] = NULL;
						for($i=1; $i<=12; $i++)
						{
							
							$currentMonth = sprintf('%02d', $i);
							if((!empty($search_months_ids) && in_array($currentMonth, $month_ids)) || in_array('ALL', $month_ids)){
							$start_time = "00:00:00";
							$end_time = "23:59:59";
							$start_date = $search_year ."-" .$currentMonth ."-" ."01";
							$end_date   = $search_year ."-" .$currentMonth ."-" .cal_days_in_month(CAL_GREGORIAN, $currentMonth, $search_year);				
							$start_date_full = $start_date ." " .$start_time;
							$end_date_full = $end_date ." " .$end_time;
							
							$monthList['names'][] = date('F', strtotime($start_date));
							$monthList['id'][] = $i;
							
							// CQ SCORE
							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
					              INNER JOIN signin as s ON s.id = qa.agent_id
								  WHERE qa.audit_type = 'CQ Audit' AND (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office'";
							$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
							$monthArray[$c_processID][$i]['score'] = !empty($c_qaScore['score']) ? sprintf('%.2d', $c_qaScore['score']) : "0";
							$monthArray[$c_processID][$i]['audit'] = $c_qaScore['auditCount'];					
							$final_audit_count = $final_audit_count + $c_qaScore['auditCount'];					
							$csatscore = $this->get_qa_boomsourcing_defect_csat_score($c_defect_table, $start_date, $end_date, $search_office);
							$npsscore = $this->get_qa_boomsourcing_defect_nps_score($c_defect_table, $start_date, $end_date, $search_office);
							$monthArray[$c_processID][$i]['csat'] = !empty($csatscore) ? sprintf('%.2d', $csatscore) : "0";
							$monthArray[$c_processID][$i]['nps'] = !empty($npsscore) ? sprintf('%.2d', $npsscore) : "0";
							
							$sqlTarget = "SELECT * from target_qa_score WHERE process_id = '$c_processID' AND month = '$currentMonth' AND year = '$search_year' AND office_id = '$search_office' AND client_id = '$c_clientID' ORDER by id DESC LIMIT 1";
							$queryTarget = $this->Common_model->get_query_row_array($sqlTarget);
							$monthArray[$c_processID][$i]['target'] = !empty($queryTarget['target_score']) ? $queryTarget['target_score'] : 0;
							
							$monthList[$c_processID]['score'][] = $monthArray[$c_processID][$i]['score'];
							$monthList[$c_processID]['csat'][] = $monthArray[$c_processID][$i]['csat'];
							$monthList[$c_processID]['nps'][] = $monthArray[$c_processID][$i]['nps'];
							$monthList[$c_processID]['target'][] = $monthArray[$c_processID][$i]['target'];
							}

						}
					}
					
					if($currentGraphType == 'weekly')
					{
						if(strtotime($search_end_date) > strtotime($search_start_date))
						{
							$weekArray = NULL;
							$weekCount = 0;
							$startDate = $search_start_date;
							$checkerDate = $search_end_date;
							$end_date = $search_end_date;
							while(strtotime($checkerDate) <= strtotime($search_end_date))
							{
								$weekCount++;
								
								$weekArray[$weekCount]['start'] = date('Y-m-d', strtotime('+1 days', strtotime($end_date)));
								if($weekCount == 1){ $weekArray[$weekCount]['start'] = $startDate; }
								$start_date = $weekArray[$weekCount]['start'];								
								
								$weekArray[$weekCount]['end'] = date('Y-m-d', strtotime('+6 days', strtotime($start_date)));
								$end_date = $weekArray[$weekCount]['end'];
								$checkerDate = $end_date;
								if($search_end_date <= $checkerDate){
									$end_date = $search_end_date;
									$weekArray[$weekCount]['end'] = $search_end_date;
								}
								$weekArray[$weekCount]['name'] = "Week " .$weekCount;
								$weekArray[$weekCount]['fullname'] = "Week " .$weekCount ." (" .$start_date ." - " .$end_date.")";
								$weekArray[$weekCount]['count'] = $weekCount;
								
								// CQ SCORE
								$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									  INNER JOIN signin as s ON s.id = qa.agent_id
									  WHERE qa.audit_type = 'CQ Audit' AND (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office'";
								$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
								$weekCQ[$c_processID][$weekCount]['score'] = !empty($c_qaScore['score']) ? sprintf('%.2d', $c_qaScore['score']) : "0";
								$weekCQ[$c_processID][$weekCount]['audit'] = $c_qaScore['auditCount'];					
								$final_audit_count = $final_audit_count + $c_qaScore['auditCount'];					
								$csatscore = $this->get_qa_boomsourcing_defect_csat_score($c_defect_table, $start_date, $end_date, $search_office);
								$npsscore = $this->get_qa_boomsourcing_defect_nps_score($c_defect_table, $start_date, $end_date, $search_office);
								$weekCQ[$c_processID][$weekCount]['csat'] = !empty($csatscore) ? sprintf('%.2d', $csatscore) : "0";
								$weekCQ[$c_processID][$weekCount]['nps'] = !empty($npsscore) ? sprintf('%.2d', $npsscore) : "0";
								
								//$sqlTarget = "SELECT * from target_qa_score WHERE process_id = '$c_processID' AND month = '$currentMonth' AND year = '$search_year' AND office_id = '$search_office' AND client_id = '$c_clientID' ORDER by id DESC LIMIT 1";
								//$queryTarget = $this->Common_model->get_query_row_array($sqlTarget);
								//$weekCQ[$c_processID][$weekCount]['target'] = !empty($queryTarget['target_score']) ? $queryTarget['target_score'] : 0;
								
								$weekCQ[$c_processID]['score'][] = $weekCQ[$c_processID][$weekCount]['score'];
								$weekCQ[$c_processID]['csat'][] = $weekCQ[$c_processID][$weekCount]['csat'];
								$weekCQ[$c_processID]['nps'][] = $weekCQ[$c_processID][$weekCount]['nps'];
								//$weekCQ[$c_processID]['target'][] = $weekCQ[$c_processID][$weekCount]['target'];
								
								if($weekCount > 54){ break; }
							}
							
							
						}
					}
					
					if($currentGraphType == 'daily')
					{
						if(strtotime($search_end_date) > strtotime($search_start_date))
						{
							$weekArray = NULL;
							$weekCount = 0;
							$startDate = $search_start_date;
							$checkerDate = $search_end_date;
							$end_date = $search_end_date;
							while(strtotime($checkerDate) <= strtotime($search_end_date))
							{
								$weekCount++;
								
								$weekArray[$weekCount]['start'] = date('Y-m-d', strtotime('+1 days', strtotime($start_date)));
								if($weekCount == 1){ $weekArray[$weekCount]['start'] = $startDate; }
								$start_date = $weekArray[$weekCount]['start'];
								$checkerDate = $start_date;
								if($checkerDate <= $search_end_date){
								$weekArray[$weekCount]['name'] = "Day " .$weekCount;
								$weekArray[$weekCount]['fullname'] = $start_date;
								$weekArray[$weekCount]['count'] = $weekCount;
								}
								
								// CQ SCORE
								$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									  INNER JOIN signin as s ON s.id = qa.agent_id
									  WHERE qa.audit_type = 'CQ Audit' AND (DATE(qa.audit_date) = '".$start_date."') AND s.office_id = '$search_office'";
								$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
								$weekCQ[$c_processID][$weekCount]['score'] = !empty($c_qaScore['score']) ? sprintf('%.2d', $c_qaScore['score']) : "0";
								$weekCQ[$c_processID][$weekCount]['audit'] = $c_qaScore['auditCount'];					
								$final_audit_count = $final_audit_count + $c_qaScore['auditCount'];					
								$csatscore = $this->get_qa_boomsourcing_defect_csat_score($c_defect_table, $start_date, $end_date, $search_office);
								$npsscore = $this->get_qa_boomsourcing_defect_nps_score($c_defect_table, $start_date, $end_date, $search_office);
								$weekCQ[$c_processID][$weekCount]['csat'] = !empty($csatscore) ? sprintf('%.2d', $csatscore) : "0";
								$weekCQ[$c_processID][$weekCount]['nps'] = !empty($npsscore) ? sprintf('%.2d', $npsscore) : "0";
								
								//$sqlTarget = "SELECT * from target_qa_score WHERE process_id = '$c_processID' AND month = '$currentMonth' AND year = '$search_year' AND office_id = '$search_office' AND client_id = '$c_clientID' ORDER by id DESC LIMIT 1";
								//$queryTarget = $this->Common_model->get_query_row_array($sqlTarget);
								//$weekCQ[$c_processID][$weekCount]['target'] = !empty($queryTarget['target_score']) ? $queryTarget['target_score'] : 0;
								
								$weekCQ[$c_processID]['score'][] = $weekCQ[$c_processID][$weekCount]['score'];
								$weekCQ[$c_processID]['csat'][] = $weekCQ[$c_processID][$weekCount]['csat'];
								$weekCQ[$c_processID]['nps'][] = $weekCQ[$c_processID][$weekCount]['nps'];
								//$weekCQ[$c_processID]['target'][] = $weekCQ[$c_processID][$weekCount]['target'];
								
								if($weekCount > 54){ break; }
							}
							
							
						}
					}
					
				}
				
				$data['total_account'] = $total_account;
				$data['total_audit'] = $final_audit_count;
				$data['monthList'] = $monthList;
				$data['monthCQ'] = $monthArray;
				$data['weekCQ'] = $weekCQ;
				$data['weekList'] = $weekArray;
				$data['campaignCQ'] = $campaignArray;				
				//echo "<pre>".print_r($weekArray, 1)."</pre>"; 
				//echo "<pre>".print_r($weekCQ, 1)."</pre>"; die();
			}		
			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/Qa_graph_boomsourcing_summary_all.php";
			$data["content_js"] = "Qa_graph_boomsourcing/Qa_graph_boomsourcing_summary_all_js.php";
							
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	//==========================================================================================//
	//            PROGRAM LEVEL
	//==========================================================================================//
	
	public function program_level()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			//$this->db->db_debug=true;
			// ============  FILTER DATE ========================================//		
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
			$select_agent = "";
			$select_tl = "";
			$report_type = "month";

			// Vertical
			$data['vertical_list'] = $this->db->query("SELECT * FROM qa_vertical_data WHERE is_active = 1")->result_array();
			$data['select_vertical'] = $selected_vertical = $this->input->get("select_vertical");
			if($selected_vertical != "All" && $selected_vertical != "") $verticalCond = "AND s.vertical_id = $selected_vertical";

			// Channel
			$data['channel_list'] = $this->db->query("SELECT * FROM qa_channel_data WHERE is_active = 1")->result_array();
			$data['select_channel'] = $selected_channel = $this->input->get("select_channel");
			if($selected_channel != "All" && $selected_channel != "") $channelCond = "AND s.channel_id = $selected_channel";
			
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
			if(!empty($this->input->get('select_agent'))){ $select_agent = $this->input->get('select_agent'); }
			if(!empty($this->input->get('select_tl'))){ $select_tl = $this->input->get('select_tl'); }
			
			if(!empty($this->input->get('report_type'))){ $report_type = $this->input->get('report_type'); }
			if(!empty($this->input->get('select_start_date'))){ $select_start_date = $this->input->get('select_start_date'); }
			if(!empty($this->input->get('select_end_date'))){ $select_end_date = $this->input->get('select_end_date'); }
										
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);				
			
			
			if(!empty($select_start_date) && $report_type == 'date'){
				$start_date = date('Y-m-d', strtotime($select_start_date));
			}
			if(!empty($select_end_date) && $report_type == 'date'){
				$end_date = date('Y-m-d', strtotime($select_end_date));
			}
			
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;
			$data['selected_agent']  = $select_agent;
			$data['selected_tl']  = $select_tl;
			$data['report_type']  = $report_type;
			
			// ============  FILTER OFFICE ========================================//
			
			$search_office[] = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
				
				$search_office_string =implode("','", $search_office);
			}
			$data['selected_office'] = $search_office;
			
			// ============  FILTER PROCESS ========================================//
			
			$search_process_id = "";
			if(!empty($this->input->get('select_process'))){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;
			
			//===================== DROPDOWN FILTERS ======================================//
						
			$search_client_id = "1";
			// if(!empty($this->input->get('select_client'))){ 					
			// 	$search_client_id = $this->input->get('select_client');
			// }
			$data['selected_client'] = $search_client_id;
			
			//===================== USER DROPDOWN FILTERS ======================================//
			$extraFilter = "";
			if(!empty($search_client_id) && $search_client_id != 'ALL'){
				$extraFilter .= " AND is_assign_client(s.id, $search_client_id) ";
			}
			
			/* if(!empty($search_office) && $search_office != 'ALL'){
				$extraFilter .= " AND s.office_id = '$search_office' ";
			} */
			/* Multiselect location condition */
			 $locFilter = "";
			if(is_array($search_office)){
				if(in_array("ALL", $search_office)){
					$extraFilter .= "";	
					$locFilter ="";
				}else{
					$extraFilter .= " AND s.office_id IN ('".$search_office_string."')";
					$locFilter = "AND s.office_id IN ('".$search_office_string."')";
				}
			}else{
					$extraFilter .=" AND s.office_id IN ('".$search_office."')";
					$locFilter = "AND s.office_id IN ('".$search_office."')";
			} 
			/* end */
						
			$SQLtxt = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id FROM signin as s 
			          LEFT JOIN role as r ON r.id = s.role_id 
					  LEFT JOIN signin as sl ON sl.id = s.assigned_to 
					  where 1 AND r.folder='tl' $extraFilter order by fullname";	
			//echo $SQLtxt;
			//echo "<br>";
			$resultUser = $this->Common_model->get_query_result_array($SQLtxt);
			$data['tl_list'] = $resultUser;
			
			$extraFilter = "";
			if(!empty($select_tl) && $select_tl != 'ALL'){
				$extraFilter .= " AND s.assigned_to = '$select_tl' ";
			}
			$SQLtxt = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id FROM signin as s 
			          LEFT JOIN role as r ON r.id = s.role_id 
					  LEFT JOIN signin as sl ON sl.id = s.assigned_to 
					  where 1 AND r.folder='agent' $extraFilter order by fullname";		
			//echo $SQLtxt;
			$resultUser = $this->Common_model->get_query_result_array($SQLtxt);
			$data['agent_list'] = $resultUser;
			
			
			$extraUserFilter = "";
			if(!empty($select_tl) && $select_tl != 'ALL')
			{
				$extraUserFilter .= " AND sl.id IN ($select_tl)";
			}
			if(!empty($select_agent) && $select_agent != 'ALL')
			{
				$extraUserFilter .= " AND s.id IN ($select_agent)";
			}
			
			
			if($search_client_id == '79'){
				$select_product_209 = "";
				if(!empty($this->input->get('select_product_209'))){ $select_product_209 = $this->input->get('select_product_209'); }
				$select_product_99 = "";
				if(!empty($this->input->get('select_product_99'))){ $select_product_99 = $this->input->get('select_product_99'); }
				$data['select_product_209']  = $select_product_209;
				$data['select_product_99']  = $select_product_99;
			}
			
			
			//===================== OFFICE CLIENT PROCESS DROPDOWN ======================================//			
			
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// Process Selection
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);
			
			
			//===================== CALCULATE ======================================//
			
			if(!empty($search_process_id))
			{
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_process_id'";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);
				
				$tableFound = false;
				$dbName = $this->db->database;
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$c_defect_table'";
				$countCheck = $this->Common_model->get_single_value($sqlCheck);
				if($countCheck > 0){ $tableFound = true; }
				
				if($tableFound){
				
				
				if($search_process_id == 99 && !empty($select_product_99)){
					$extraUserFilter .= " AND qa.product = '$select_product_99'";
				}
				if($search_process_id == 209 && !empty($select_product_209)){
					$extraUserFilter .= " AND qa.product = '$select_product_209'";
				}
				
				// CQ SCORE locFilter
				/* $sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'  $extraUserFilter"; */
				
				$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit'  $extraUserFilter $verticalCond $channelCond";
				//echo $sql_qaScore;
				//echo "<br>";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				///$avgCQScore = round($c_qaScore['score']);
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
				
				// CQ FATAL
				/* $sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND overall_score = '0'  $extraUserFilter"; */
				$sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND overall_score = '0'  $extraUserFilter $verticalCond $channelCond";
				//echo $sql_qaScore;
				
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_fatalCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalFatalCount = $c_fatalCount;
				$fatalPercent = 0;
				if($totalAuditCount > 0){
					//$fatalPercent = ($totalFatalCount / $totalAuditCount) * 100;
					$fatalPercent = sprintf('%.2f',($totalFatalCount / $totalAuditCount) * 100);
				}
				
				// GET CUSTOM PARAMS
				$errorCheckGrant = true; 
				$errorNoCheck = "'0', 'No', 'no', 'Unacceptable', 'Fail', 'Absent', 'Action needed','Below Expectation','Well below Expectation','AFD'";
				$errorYesCheck = "'1', 'Yes', 'yes', 'Acceptable', 'Pass', 'Awesome', 'Average','Above Expectation','Meeting Expectation'";
				$errorNACheck = "'N/A', 'NA', 'na', 'n/a'";
				$customParams = array();
				if($get_defect_columns['process_id'] == "171" || $get_defect_columns['process_id'] == "181"){
					$customParams = $this->custom_error_parameters($get_defect_columns['process_id']);
					$errorCheckGrant = false;
				}
				
				
				// BUCKET SCORE
				$c_bucketCount = array();
				$currentBucket = "1";
				/* $sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= 64 $extraUserFilter GROUP BY qa.agent_id"; */
				$sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= 64 $extraUserFilter $verticalCond $channelCond GROUP BY qa.agent_id";
				$c_bucket = $this->Common_model->get_query_result_array($sql_bucket);
				$c_bucketCount[$currentBucket] = !empty($c_bucket) ? count($c_bucket) : 0;
				//echo "<pre>".print_r($c_bucket, 1)."</pre>";die();
				
				$currentBucket = "2";
				/* $sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= 55 AND qa.overall_score < 64 $extraUserFilter GROUP BY qa.agent_id"; */
				$sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= 55 AND qa.overall_score < 64 $extraUserFilter $verticalCond $channelCond GROUP BY qa.agent_id";				
				$c_bucket = $this->Common_model->get_query_result_array($sql_bucket);
				$c_bucketCount[$currentBucket] = !empty($c_bucket) ? count($c_bucket) : 0;
				
				$currentBucket = "3";
				/* $sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score < 55 $extraUserFilter GROUP BY qa.agent_id"; */
				$sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to 
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score < 55 $extraUserFilter $verticalCond $channelCond GROUP BY qa.agent_id";
				
				$c_bucket = $this->Common_model->get_query_result_array($sql_bucket);
				$c_bucketCount[$currentBucket] = !empty($c_bucket) ? count($c_bucket) : 0;
				$data['bucketCount'] = $c_bucketCount;
					
				// PARAMS SCORE
				$params = array();
				$paramColumns = $get_defect_columns['params_columns'];
				$paramsArray = explode(',', $paramColumns);
			
				foreach($paramsArray as $token)
				{				
					$flagExecuter = true;
					if($search_process_id == '285' && $token == 'auto_fail'){ $flagExecuter = false; }
					if($flagExecuter == true){
						//=== NO 
						$errorChecker = $errorNoCheck;
						if($token == 'misrepresentation'){
							$errorChecker = $errorYesCheck;
						}
						if($token == 'advocate_get_combative'){
							$errorChecker = $errorYesCheck;
						}
						if($token == 'repgiveMedicaladvice'){
							$errorChecker = $errorYesCheck;
						}
						if($token == 'agentMiscodeCall'){
							$errorChecker = $errorYesCheck;
						}
						if($get_defect_columns['process_id'] == "171" || $get_defect_columns['process_id'] == "181"){
							if(in_array($token, $customParams['yes'])){ $errorChecker = $errorNoCheck; }
							if(in_array($token, $customParams['no'])){ $errorChecker = $errorYesCheck;  }
						}
						
						/* $sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa 
						            INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorChecker.")  $extraUserFilter"; */
						$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa 
						            INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$locFilter AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorChecker.")  $extraUserFilter $verticalCond $channelCond";
						
						$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
						$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
						$paramsPercent = 0;
						if($totalAuditCount > 0){
							//$paramsPercent = ($c_ParamCount / $totalAuditCount) * 100;
							$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
						}
						$params['count'][$token] = $c_ParamCount;
						$params['percent'][$token] = $paramsPercent;
						
						
						// GET USER NAMES
						/* $sqlToken = "SELECT CONCAT(s.fname, ' ', s.lname) as agent_name, s.fusion_id, count(*) as auditCount from $c_defect_table as qa 
						            INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorChecker.")  $extraUserFilter GROUP BY qa.agent_id ORDER BY auditCount DESC LIMIT 5"; */
						$sqlToken = "SELECT CONCAT(s.fname, ' ', s.lname) as agent_name, s.fusion_id, count(*) as auditCount from $c_defect_table as qa 
						            INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$locFilter AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorChecker.")  $extraUserFilter $verticalCond $channelCond GROUP BY qa.agent_id ORDER BY auditCount DESC LIMIT 5";
						
						$c_qaScore = $this->Common_model->get_query_result_array($sqlToken);
						$params['users'][$token] = $c_qaScore;

						
					}
				}
				
				
				arsort($params['count']);
				arsort($params['percent']);
				$params['graph'][1] = array("#ffc000", "#fff2cc");
				$params['graph'][2] = array("#7f7f7f", "#e5e5e5");
				$params['graph'][3] = array("#7f6000", "#e5dfcc");
				$params['graph'][4] = array("#4d1e62", "#dbd2e0");
				$params['graph'][5] = array("#00b0f0", "#cceffc");
				
				
				$data['cq']['params'] = $params;
				$data['cq']['fatal']['percent'] = $fatalPercent;
				$data['cq']['fatal']['total'] = $totalFatalCount;
				$data['cq']['audit']['percent'] = $avgCQScore;
				$data['cq']['audit']['total'] = $totalAuditCount;
			
				//echo "<pre>" .print_r($data['cq'], 1) ."</pre>"; die();
				
			}
			
			}
			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_program_level.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_program_level_js.php";
			$data["disable_ameyo_chat"] = 1;
							
			$this->load->view('dashboard',$data);
			
		}
		
	}

	//Edited By Samrat 31/1/2022
	public function select_user(){
		$client_id = $this->input->get("client_id");
		$office_id = $this->input->get("office");
		$offArr = explode(",", $office_id);
		$office_id = implode("','", $offArr);
		$tl_id = $this->input->get("tl_id");
		$role = $this->input->get("role");

		$condition ="";
		if($tl_id!="" && $tl_id!="ALL"){
			$condition .=" AND s.assigned_to=$tl_id";
		}
		if($client_id!=""){
			//$condition .=" AND s.client_id=$client_id";
		}
		if($office_id!=""){
			$condition .=" AND s.office_id IN ('".$office_id."')";
		}

		$json_array['sql'] = $fetch_user_sql = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id, rl.folder 
		FROM `signin` s LEFT JOIN `role` rl ON rl.id=s.role_id WHERE 1 $condition AND rl.folder='$role'";
		$json_array = $this->Common_model->get_query_result_array($fetch_user_sql);
		echo json_encode($json_array);
	}
	
	
	//==========================================================================================//
	//            DEFECT LEVEL
	//==========================================================================================//
	
	public function defect_level(){
		if(check_logged_in()){
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = $this->accessClientIds();
			
			// ============  FILTER DATE ========================================//
			
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
						
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
								
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);				
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;
			
			// Vertical
			$data['vertical_list'] = $this->db->query("SELECT * FROM qa_vertical_data WHERE is_active = 1")->result_array();
			$data['select_vertical'] = $selected_vertical = $this->input->get("select_vertical");
			if($selected_vertical != "All") $verticalCond = "AND s.vertical_id = $selected_vertical";

			// Channel
			$data['channel_list'] = $this->db->query("SELECT * FROM qa_channel_data WHERE is_active = 1")->result_array();
			$data['select_channel'] = $selected_channel = $this->input->get("select_channel");
			if($selected_channel != "All") $channelCond = "AND s.channel_id = $selected_channel";

			// ============  FILTER OFFICE ========================================//
			
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
			}
			$data['selected_office'] = $search_office;
			
			// ============  FILTER PROCESS ========================================//
			
			$search_process_id = "";
			if(!empty($this->input->get('select_process'))){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;
			
			
			
			//===================== DROPDOWN FILTERS ======================================//
			
			$search_client_id = "1";
			// if(!empty($this->input->get('select_client'))){ 					
			// 	$search_client_id = $this->input->get('select_client');
			// }
			$data['selected_client'] = $search_client_id;
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}	
			
			// Process Selection
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id WHERE q.client_id IN ($my_client_ids)  AND q.process_id NOT IN ('304') ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);
			
			
			//===================== CALCULATE ======================================//
			
			if(!empty($search_process_id)){
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_process_id'";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);
				
				$tableFound = false;
				$dbName = $this->db->database;
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$c_defect_table'";
				$countCheck = $this->Common_model->get_single_value($sqlCheck);
				if($countCheck > 0){ $tableFound = true; }
				
				if($tableFound){
					
				// CQ SCORE
				$sql_qaScore = "SELECT COUNT(*) AS auditCount, 
					AVG(qa.overall_score) AS score
				FROM $c_defect_table AS qa
				INNER JOIN signin AS s ON s.id = qa.agent_id
				WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
					AND s.office_id = '$search_office' 
					AND qa.audit_type = 'CQ Audit'
					$verticalCond
					$channelCond";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				///$avgCQScore = round($c_qaScore['score']);
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
				
				// CQ FATAL
				$sql_qaScore = "SELECT COUNT(*) AS auditCount, 
					SUM(qa.overall_score) AS score
				FROM $c_defect_table AS qa
				INNER JOIN signin AS s ON s.id = qa.agent_id
				WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
					AND s.office_id = '$search_office' 
					AND qa.audit_type = 'CQ Audit' 
					AND overall_score = '0'
					$verticalCond
					$channelCond";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_fatalCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalFatalCount = $c_fatalCount;
				$fatalPercent = 0;
				if($totalAuditCount > 0){
					//$fatalPercent = ($totalFatalCount / $totalAuditCount) * 100;
					$fatalPercent = sprintf('%.2f',($totalFatalCount / $totalAuditCount) * 100);
				}
					
				// PARAMS SCORE
				$params = array();
				$params2 = array();
				$paramColumns = $get_defect_columns['params_columns'];
				$paramsArray = explode(',', $paramColumns);
				$totalErrorCount = 0;
				
				// GET CUSTOM PARAMS
				$errorCheckGrant = true; 
				$errorNoCheck = "'0', 'No', 'no', 'Unacceptable', 'Fail', 'Absent', 'Action needed'";
				$errorYesCheck = "'1', 'Yes', 'yes', 'Acceptable', 'Pass', 'Awesome', 'Average'";
				$errorNACheck = "'N/A', 'NA', 'na', 'n/a'";
				$customParams = array();
				if($get_defect_columns['process_id'] == "171" || $get_defect_columns['process_id'] == "181"){
					$customParams = $this->custom_error_parameters($get_defect_columns['process_id']);
					$errorCheckGrant = false;
				}
				
				$data['fatalParam'] = $fatalParameters = $this->custom_error_fatal_parameters(base64_encode($get_defect_columns['process_id']));
				foreach($paramsArray as $token)
				{
					//=== NO 
					$errorChecker = $errorNoCheck;
					if($token == 'misrepresentation'){
						$errorChecker = $errorYesCheck;
					}
					if($get_defect_columns['process_id'] == "171" || $get_defect_columns['process_id'] == "181"){
						if(in_array($token, $customParams['yes'])){ $errorChecker = $errorNoCheck; }
						if(in_array($token, $customParams['no'])){ $errorChecker = $errorYesCheck;  }
					}
					
					$sqlToken = "SELECT COUNT(*) AS auditCount 
					FROM $c_defect_table AS qa 
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit' 
						AND qa.$token IN (".$errorChecker.")
						$verticalCond
						$channelCond";					
					$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
					$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
					$paramsPercent = 0;
					if($totalAuditCount > 0){
						$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
					}
					$params['count'][$token] = $c_ParamCount;
					$params['percent'][$token] = $paramsPercent;					
					$params2['count'][$token]['no'] = $c_ParamCount;
					$params2['percent'][$token]['no'] = $paramsPercent;
					$totalErrorCount = $totalErrorCount + $c_ParamCount;
					
					//=== YES 
					$errorChecker = $errorYesCheck;
					if($token == 'misrepresentation'){
						$errorChecker = $errorNoCheck;
					}
					if($get_defect_columns['process_id'] == "171" || $get_defect_columns['process_id'] == "181"){
						if(in_array($token, $customParams['yes'])){ $errorChecker = $errorYesCheck; }
						if(in_array($token, $customParams['no'])){ $errorChecker = $errorNoCheck;  }
					}
					
					$sqlToken = "SELECT COUNT(*) AS auditCount
					FROM $c_defect_table AS qa 
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit' 
						AND (qa.$token IN (".$errorChecker."))
						$verticalCond
						$channelCond";							
					$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
					$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
					$paramsPercent = 0;
					if($totalAuditCount > 0){
						$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
					}
					$params2['count'][$token]['yes'] = $c_ParamCount;
					$params2['percent'][$token]['yes'] = $paramsPercent;		
					
					
					//=== NA
					$sqlToken = "SELECT COUNT(*) AS auditCount
					FROM $c_defect_table AS qa 
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit' 
						AND qa.$token IN (".$errorNACheck.")
						$verticalCond
						$channelCond";
					$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
					$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
					$paramsPercent = 0;
					if($totalAuditCount > 0){
						$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
					}
					$params2['count'][$token]['na'] = $c_ParamCount;
					$params2['percent'][$token]['na'] = $paramsPercent;
				}
				
				arsort($params['count']);
				arsort($params['percent']);
				$params['graph'][1] = array("#ffc000", "#fff2cc");
				$params['graph'][2] = array("#7f7f7f", "#e5e5e5");
				$params['graph'][3] = array("#7f6000", "#e5dfcc");
				$params['graph'][4] = array("#4d1e62", "#dbd2e0");
				$params['graph'][5] = array("#00b0f0", "#cceffc");
				
				
				$data['cq']['parameterArray'] = $paramsArray;
				$data['cq']['params'] = $params;
				$data['cq']['params2'] = $params2;
				$data['cq']['fatal']['percent'] = $fatalPercent;
				$data['cq']['fatal']['total'] = $totalFatalCount;
				$data['cq']['audit']['percent'] = $avgCQScore;
				$data['cq']['audit']['total'] = $totalAuditCount;
				$data['cq']['audit']['error'] = !empty($totalErrorCount) ? $totalErrorCount : 0;
			
				//echo "<pre>" .print_r($data['cq'], 1) ."</pre>"; die();
				
			}
			
			}
			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_boomsourcing_defect_level.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_boomsourcing_defect_level_js.php";
			$this->load->view('dashboard',$data);
			
		}
		
	}
	
	
	
	//==========================================================================================//
	//            TENDER LEVEL
	//==========================================================================================//
	
	public function tender_level(){
		if(check_logged_in()){
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			
			$my_client_ids = $this->accessClientIds();
			
			// ============  FILTER DATE ========================================//
			
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
						
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
								
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);				
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;
			

			// Vertical
			$data['vertical_list'] = $this->db->query("SELECT * FROM qa_vertical_data WHERE is_active = 1")->result_array();
			$data['select_vertical'] = $selected_vertical = $this->input->get("select_vertical");
			if($selected_vertical != "All") $verticalCond = "AND s.vertical_id = $selected_vertical";

			// Channel
			$data['channel_list'] = $this->db->query("SELECT * FROM qa_channel_data WHERE is_active = 1")->result_array();
			$data['select_channel'] = $selected_channel = $this->input->get("select_channel");
			if($selected_channel != "All") $channelCond = "AND s.channel_id = $selected_channel";
			
			// ============  FILTER OFFICE ========================================//
			
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
			}
			$data['selected_office'] = $search_office;
			
			// ============  FILTER PROCESS ========================================//
			
			$search_process_id = "";
			if(!empty($this->input->get('select_process'))){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;
			
			//===================== DROPDOWN FILTERS ======================================//
			
			$search_client_id = "1";
			// if(!empty($this->input->get('select_client'))){ 					
			// 	$search_client_id = $this->input->get('select_client');
			// }
			$data['selected_client'] = $search_client_id;
			
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// Process Selection
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id WHERE q.client_id IN ($my_client_ids) ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);
			
			
			//===================== CALCULATE ======================================//
			
			if(!empty($search_process_id)){
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_process_id'";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);
				
				$tableFound = false;
				$dbName = $this->db->database;
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$c_defect_table'";
				$countCheck = $this->Common_model->get_single_value($sqlCheck);
				if($countCheck > 0){ $tableFound = true; }
				
				if($tableFound){
					
				$sqlAgents = "SELECT qa.agent_id, 
					COUNT(*) AS auditCount, 
					s.doj
				FROM $c_defect_table AS qa
				INNER JOIN signin AS s ON s.id = qa.agent_id
				WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
					AND s.office_id = '$search_office' 
					AND qa.audit_type = 'CQ Audit' 
					$verticalCond
					$channelCond
				GROUP BY qa.agent_id";
				$queryAgents = $this->Common_model->get_query_result_array($sqlAgents);
				$currentDay = CurrDate();
				$agentTender = array();
				foreach($queryAgents as $tokeng){
					$joiningDay = $tokeng['doj'];
					if(!empty($joiningDay) && $joiningDay != "0000-00-00"){
						$earlier = new DateTime($joiningDay);
						$later = new DateTime($currentDay);
						$diff = $later->diff($earlier)->format("%a");
						$getNoOfDays = $diff;
						if($getNoOfDays < 60){
							$agentTender[30][] = $tokeng['agent_id']; 
						}
						if($getNoOfDays >= 60 && $getNoOfDays <= 90){
							$agentTender[60][] = $tokeng['agent_id']; 
						}
						if($getNoOfDays > 90 &&  $getNoOfDays <= 120){
							$agentTender[90][] = $tokeng['agent_id']; 
						}
						if($getNoOfDays > 120 &&  $getNoOfDays <= 150){
							$agentTender[120][] = $tokeng['agent_id']; 
						}
						if($getNoOfDays > 150 &&  $getNoOfDays <= 180){
							$agentTender[150][] = $tokeng['agent_id']; 
						}
						if($getNoOfDays > 180){
							$agentTender[180][] = $tokeng['agent_id']; 
						}
					}
				}
				
				
				// TENDERS
				$tenders = array( 30, 60 , 90, 120, 150, 180 );
				$tendersNames = array( "0-60", "60-90" , "90-120", "120-150", "150-180", "Above 180");
				$tendersScoreArray = array();
				$cn=0;
				foreach($tenders as $tokenq)
				{
					$currentAgentIDs = "0";
					if(!empty($agentTender[$tokenq])){
						$currentAgentIDs = implode(',', $agentTender[$tokenq]);
					}
					// CQ SCORE
					$sql_qaScore = "SELECT count(*) AS auditCount, 
						avg(qa.overall_score) AS score 
					FROM $c_defect_table AS qa
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit' 
						AND qa.agent_id IN ($currentAgentIDs)
						$verticalCond
						$channelCond";
					$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
					$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
					$totalAuditCount = $c_auditCount;
					$totalAuditScore = !empty($c_qaScore['score']) ? sprintf('%.2f', $c_qaScore['score']) : 0;
										
					$sql_qaScore = "SELECT count(*) AS auditCount, 
						avg(qa.overall_score) AS score
					FROM $c_defect_table AS qa
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit' 
						AND overall_score = '0' 
						AND qa.agent_id IN ($currentAgentIDs)
						$verticalCond
						$channelCond";
					$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
					$c_fatalCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
					$totalFatalCount = $c_fatalCount;
					
					$tendersScoreArray[$tokenq]['name'] = $tendersNames[$cn++];
					$tendersScoreArray[$tokenq]['audit'] = $totalAuditCount;
					$tendersScoreArray[$tokenq]['fatal'] = $totalFatalCount;
					$tendersScoreArray[$tokenq]['score'] = $totalAuditScore;
					$tendersScoreArray[$tokenq]['fatalpercent'] = 0;
					if($totalAuditCount > 0){
						$tendersScoreArray[$tokenq]['fatalpercent'] = sprintf('%.2f',($totalFatalCount/$totalAuditCount) * 100);
					}
									
				}
				
				$data['tenders'] = $tenders;
				$data['tendersArray'] = $tendersScoreArray;
				$data['$agentTender'] = $$agentTender;
					
				
			
				//echo "<pre>" .print_r($tendersScoreArray, 1) ."</pre>"; die();
				
			}
			
			}

			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_tenure_level.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_tenure_level_js.php";
			$this->load->view('dashboard',$data);
			
		}
		
	}
	
	
	//==========================================================================================//
	//            AGENT LEVEL
	//==========================================================================================//
	
	public function agent_level()
	{ 
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = $this->accessClientIds();
			
			$selected_tl_process = "";
			if(!empty($this->input->get('select_tl_process'))){ 
				$selected_tl_process = $this->input->get('select_tl_process'); 
			}
			$selected_tl_client = "";
			if(!empty($this->input->get('select_tl_client'))){ 
				$selected_tl_client = $this->input->get('select_tl_client'); 
			}
			$selected_tl_agent = "";
			if(!empty($this->input->get('select_tl_agent'))){ 
				$selected_tl_agent = $this->input->get('select_tl_agent');
				$current_user = $selected_tl_agent; 
			}
			$data['selected_tl_client'] = $selected_tl_client;
			$data['selected_tl_agent'] = $selected_tl_agent;
			$data['selected_tl_process'] = $selected_tl_process;
						
			// ============  FILTER OFFICE ========================================//			
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
			}
			$data['selected_office'] = $search_office;
			
			
			// ============  FILTER PROCESS ========================================//
			$search_process_id = !empty($queryDefectProcess[0]['process_id']) ? $queryDefectProcess[0]['process_id'] : "";
			if(!empty($this->input->get('select_process'))){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;
			
			
			//=========== USER DETAILS =====================//
			$sqlUser = "SELECT s.*, CONCAT(s.fname, ' ', s.lname) as fullName, CONCAT(tl.fname, ' ', tl.lname) as tlName, CONCAT(m.fname, ' ', m.lname) as managerName,
						tl.id as tl_id, m.id as manager_id, get_process_names(s.id) as process_names
			            from signin as s
						LEFT JOIN signin as tl ON tl.id = s.assigned_to
						LEFT JOIN signin as m ON m.id = tl.assigned_to
						WHERE s.id = '$current_user'";
			$userDetails = $this->Common_model->get_query_row_array($sqlUser);
			$dateOfJoining = new DateTime($userDetails['doj']);
			$tenureDays = 0;
			if(!empty($dateOfJoining) || $dateOfJoining == "0000-00-00")
			{
				$currentDate = new DateTime(CurrDate());
				//$tenureDays = strtotime($currentDate) - strtotime($dateOfJoining);
				$tenureDays = $currentDate->diff($dateOfJoining)->format("%a");
			}
			
			// Client Selection
			$sql_client = "SELECT c.shname as shname, c.id as id from info_assign_client as i
						   LEFT JOIN client as c ON c.id = i.client_id						   
						   WHERE i.user_id = '$current_user' AND  c.is_active=1 AND c.id IN ($my_client_ids) ORDER BY c.shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			$sqlProcess = "SELECT p.name as process_name, i.process_id, c.shname as client_name, c.id as client_id from info_assign_process as i 
						   LEFT JOIN process as p ON p.id = i.process_id
						   LEFT JOIN client as c ON c.id = p.client_id						   
						   WHERE i.user_id = '$current_user' AND c.id IN ($my_client_ids) ";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
						
			$sqlDefectProcess = "SELECT CASE 
			                    WHEN ip.name <> '' OR ip.name IS NOT NULL THEN ip.name 
								ELSE REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' ') 
			                    END as process_name,
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p 
			                    INNER JOIN info_assign_process as i ON i.process_id = FLOOR(p.process_id) 
			                    LEFT JOIN client as c ON c.id = p.client_id 
								LEFT JOIN process as ip ON ip.id = p.process_id
								WHERE i.user_id = '$current_user' AND p.client_id IN ($my_client_ids) ";
			$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
			
			$mergeArray = array_merge($queryProcess,$queryDefectProcess);
			$finalProcess = array_unique($mergeArray, SORT_REGULAR);
			array_multisort( array_column( $finalProcess, 'client_name' ), SORT_ASC, $finalProcess );
			
			$usersArrayAll = array();
			if((get_role_dir() != 'agent' && get_role_dir() != 'tl') || get_global_access())
			{	
				
				// Client Selection
				$sql_client = "SELECT * FROM client WHERE is_active=1  AND id IN ($my_client_ids) ORDER BY shname";
				$result_client = $this->Common_model->get_query_result_array($sql_client);
				$data['client_list'] = $result_client;
				
				$extraCampaignFilter = "";
				if(!empty($selected_tl_process)){
					$extraCampaignFilter = " AND FLOOR(p.process_id) = '$selected_tl_process'";			
					$sqlUsers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'agent' AND i.process_id = '$selected_tl_process' AND s.office_id = '$search_office' GROUP BY s.id";
					$usersArrayAll = $this->Common_model->get_query_result_array($sqlUsers);
					
				}				
				$sqlProcess = "SELECT p.name as process_name, p.id as process_id, c.shname as client_name, c.id as client_id from process as p
							   LEFT JOIN client as c ON c.id = p.client_id						   
							   WHERE p.is_active = '1'  AND p.client_id IN ($my_client_ids) ORDER by p.name";
				$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
				
				$sqlDefectProcess = "SELECT REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' ') as process_name,
							p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p
							LEFT JOIN client as c ON c.id = p.client_id 
							LEFT JOIN process as ip ON ip.id = p.process_id WHERE 1   AND p.client_id IN ($my_client_ids) $extraCampaignFilter";
				$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);				
			}
			
			
			//============ USER INFO ============================//
			$data['tenureDays'] = $tenureDays;
			$data['userInfo'] = $userDetails;
			$data['userProcess'] = $queryDefectProcess;
			$data['userAllProcess'] = $queryProcess;			
			$currentAgent = $userDetails['id'];
			$data['agentList'] = $usersArrayAll;
			
			// ============  FILTER DATE ========================================//			
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
			$weekArrayCheck = array();
			$monthArrayCheck = array();
			
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
			if(!empty($this->input->get('search_from_date'))){ $from_date = $this->input->get('search_from_date'); }
			if(!empty($this->input->get('search_to_date'))){ $to_date = $this->input->get('search_to_date'); }
			
			if(!empty($from_date) && !empty($to_date))
			{
				$search_month = date('m', strtotime($from_date));
				$search_year = date('Y', strtotime($from_date));
			}
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);				
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			if(empty($from_date) && empty($to_date))
			{
				$from_date = $start_date;
				$to_date = $end_date;
			}			
			$data['from_date'] = $from_date;				
			$data['to_date'] = $to_date;				
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;			
			$data['selected_user'] = $current_user;
			
			//===================== DROPDOWN FILTERS ======================================//			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// Process Selection
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);
			
			
			//===================== CALCULATE ======================================//
			
			if(!empty($search_process_id))
			{
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_process_id'";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);
				
				// CQ SCORE
				$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
								AND qa.agent_id = '$currentAgent'";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
				
				// CQ FATAL
				$sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND (overall_score = '0')
								AND qa.agent_id = '$currentAgent'";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_fatalCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalFatalCount = $c_fatalCount;
				$fatalPercent = 0;
				if($totalAuditCount > 0){
					$fatalPercent = sprintf('%.2f',($totalFatalCount / $totalAuditCount) * 100);
				}
				
				
				// CQ AUTOFAIL
				$sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND overall_score < '85'
								AND qa.agent_id = '$currentAgent'";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_autofatalCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAutoFatalCount = $c_autofatalCount;
				$autofatalPercent = 0;
				if($totalAuditCount > 0){
					$autofatalPercent = sprintf('%.2f',($totalAutoFatalCount / $totalAuditCount) * 100);
				}
				
				//========= SAMRT VIEW SCORE ========================================================//
				if(!empty($from_date) && !empty($to_date))
				{
					$search_from_date = $from_date;
					$search_to_date = $to_date;
					
					$d1=new DateTime($search_from_date); 
					$d2=new DateTime($search_to_date);                                  
					$Months = $d2->diff($d1); 
					$howeverManyMonths = (($Months->y) * 12) + ($Months->m);
					$showType = 'week';
					if($howeverManyMonths >= 2)
					{
						$showType = 'month';
					}				
					
					if($showType == 'week')
					{
						$enderDate = new DateTime($search_to_date);
						$starterDate = new DateTime($search_from_date);
						$weekCheck = 0; $week = array();
						while(strtotime($starterDate->format('Y-m-d')) <= strtotime($enderDate->format('Y-m-d')))
						{
							$weekCheck++;
							if($weekCheck > 1){ $starterDate->modify('+1 day'); }						
							$letsStart = $starterDate->format('Y-m-d');
							$starterDate->modify('+6 day');
							$letsend = $starterDate->format('Y-m-d');
							if(strtotime($letsend) >= strtotime($enderDate->format('Y-m-d')))
							{
								$letsend = $enderDate->format('Y-m-d');
							}
							
							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$letsStart."' AND DATE(qa.audit_date) <='".$letsend."') 
											AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
											AND qa.agent_id = '$currentAgent'";
							$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
							$myAuditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
							$myCQScore = sprintf('%.2f', $c_qaScore['score']);
							
							$weekArray = array(
							    "week" => "Week " .$weekCheck,
								"start_date" => $letsStart,
								"end_date" => $letsend,
								"audit" => $myAuditCount,
								"score" => $myCQScore
							);
							$weekArrayCheck[] = $weekArray;
						}
						
					}
					
					if($showType == 'month')
					{
						$checkStartYear = date('Y', strtotime($from_date));					
						$checkendYear = date('Y', strtotime($to_date));
						$startingMonth = date('m', strtotime($from_date));
						$endingMonth = date('m', strtotime($to_date));
						$looper = true; $sn = 0;
						
						$currentMonth = $startingMonth;
						$currentYear = $checkStartYear;
						while($looper == true)
						{
							$sn++;						
							if($currentMonth >= $endingMonth && $currentYear >= $checkendYear){ 
								$looper = false; 
							}
							$m_start_date = $currentYear ."-" .sprintf('%02d',$currentMonth) ."-" ."01";
							$m_end_date   = $currentYear ."-" .sprintf('%02d',$currentMonth) ."-" .cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);					
							if($currentMonth == 12 && $currentYear < $checkendYear){ $currentMonth = 0; $currentYear++; }
							$currentMonth++;
							
							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$m_start_date."' AND DATE(qa.audit_date) <='".$m_end_date."') 
											AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
											AND qa.agent_id = '$currentAgent'";
							$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
							$myAuditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
							$myCQScore = sprintf('%.2f', $c_qaScore['score']);
							
							$monthArray = array(
								"month" => date('F', strtotime($m_start_date)),
								"year" => date('Y', strtotime($m_start_date)),
								"start_date" => $m_start_date,
								"end_date" => $m_end_date,
								"score" => $myCQScore,
								"audit" => $myAuditCount
							);
							$monthArrayCheck[] = $monthArray;
							if($sn > 50){ $looper = false; }
						}
					}
				}
				
				$data['showtype'] = $showType;
				$data['monthArray'] = $monthArrayCheck;
				$data['weekArray'] = $weekArrayCheck;
				
					
				//============== PARAMETER DEFECT SCORE ================================================//
				$params = array();
				$paramColumns = $get_defect_columns['params_columns'];
				$paramsArray = explode(',', $paramColumns);
				foreach($paramsArray as $token)
				{
					$sqlToken = "SELECT count(*) as auditCount, avg(overall_score) as score from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail') AND qa.agent_id = '$currentAgent'";
					$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
					$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
					$paramsPercent = 0;
					if($totalAuditCount > 0){
						//$paramsPercent = ($c_ParamCount / $totalAuditCount) * 100;
						$paramsPercent = ($c_ParamCount / $totalAuditCount) * 100;
						$paramsPercent = sprintf('%.2f',$paramsPercent);
					}
					$params['count'][$token] = $c_ParamCount;
					$params['percent'][$token] = $paramsPercent;					
				}
				
				arsort($params['count']);
				arsort($params['percent']);
				$params['graph'][1] = array("#ffc000", "#fff2cc");
				$params['graph'][2] = array("#7f7f7f", "#e5e5e5");
				$params['graph'][3] = array("#7f6000", "#e5dfcc");
				$params['graph'][4] = array("#4d1e62", "#dbd2e0");
				$params['graph'][5] = array("#00b0f0", "#cceffc");
				
				
				$data['cq']['params'] = $params;
				$data['cq']['fatal']['percent'] = $fatalPercent;
				$data['cq']['fatal']['total'] = $totalFatalCount;
				$data['cq']['audit']['percent'] = $avgCQScore;
				$data['cq']['audit']['total'] = $totalAuditCount;
				$data['cq']['audit']['cq'] = $c_auditCount;
				$data['cq']['audit']['autofail'] = $totalFatalCount;
				$data['cq']['audit']['fail'] = $totalAutoFatalCount;
				$data['cq']['percent']['cq'] = $avgCQScore;
				$data['cq']['percent']['autofail'] = $autofatalPercent;
				$data['cq']['percent']['fail'] = $fatalPercent;
			
				//echo "<pre>" .print_r($data['cq'], 1) ."</pre>"; die();
				
			}		
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_agent_level.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_agent_level_js.php";
							
			$this->load->view('dashboard',$data);			
		}		
	}	
	
	public function agent_level_details()
	{
		$process_id = $this->input->get('pid');
		$office_id = $this->input->get('oid');
		$user_id = $this->input->get('uid');
		$start_date = $this->input->get('sdate');
		$end_date = $this->input->get('edate');
		$data['scoreDetails'] = NULL;
		
		$search_month = date('m');
		$search_year = date('Y');				
		$start_time = "00:00:00";
		$end_time = "23:59:59";
		if(empty($start_date) && empty($end_date)){				
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);	
		}
		$start_date_full = $start_date ." " .$start_time;
		$end_date_full = $end_date ." " .$end_time;
		
		$data['start_date'] = $start_date;				
		$data['end_date']   = $end_date;
		$data['start_date_full'] = $start_date_full;
		$data['end_date_full']   = $end_date_full;
		
		if($process_id != "" && $office_id != "" && $user_id != ""){
			$sqlDefectTable = "SELECT * from qa_boomsourcing_defect WHERE process_id = '$process_id'";
			$queryDefectTable = $this->Common_model->get_query_result_array($sqlDefectTable);
			foreach($queryDefectTable as $token)
			{
				$defectTable = trim($token['table_name']);
				$defectParam = $token['params_columns'];
				$sqlData = "SELECT q.*, CONCAT(s.fname, ' ', s.lname) as fullName, s.fusion_id from $defectTable as q
				            INNER JOIN signin as s ON s.id = q.agent_id
							WHERE DATE(q.audit_date) >= '$start_date' AND DATE(q.audit_date) <= '$end_date' AND q.agent_id = '$user_id' AND q.audit_type = 'CQ Audit'";
				$data['scoreDetails'] = $datDetails = $this->Common_model->get_query_result_array($sqlData);			
				$data['paramColumns'] = explode(',', $defectParam);
			}
			
		}
		$this->load->view('Qa_graph_boomsourcing/qa_agent_level_details',$data);
	}
	
	
	public function tl_level_wise_details()
	{
		$process_id = $this->input->get('pid');
		$office_id = $this->input->get('oid');
		$user_id = $this->input->get('uid');
		$tl_id = $this->input->get('tid');
		$m_id = $this->input->get('mid');
		$start_date = $this->input->get('sdate');
		$end_date = $this->input->get('edate');
		$data['scoreDetails'] = NULL;

		$search_month = date('m');
		$search_year = date('Y');				
		$start_time = "00:00:00";
		$end_time = "23:59:59";
		if(empty($start_date) && empty($end_date)){				
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);	
		}
		$start_date_full = $start_date ." " .$start_time;
		$end_date_full = $end_date ." " .$end_time;
		
		$data['process_id'] = $process_id;				
		$data['office_id'] = $office_id;			
		$data['start_date'] = $start_date;				
		$data['end_date']   = $end_date;
		$data['start_date_full'] = $start_date_full;
		$data['end_date_full']   = $end_date_full;
		
		$extraTLFilter = "";
		if(!empty($tl_id) && $tl_id != "ALL"){ $extraTLFilter .= " AND s.assigned_to IN ($tl_id)"; }
		
		$locationCondi = "";
		$locArr = explode(",",$office_id);
		if(is_array($locArr)){
			if(in_array('ALL',$locArr)){
					$locationCondi = "";
			}else{
					$gotLocation = implode("','", $locArr);
					$locationCondi = " AND s.office_id IN ('".$gotLocation."')";
			}
		}
		
		if($process_id != "" && $office_id != ""){
			$sqlDefectTable = "SELECT * from qa_boomsourcing_defect WHERE process_id = '$process_id'";
			$queryDefectTable = $this->Common_model->get_query_result_array($sqlDefectTable);
			foreach($queryDefectTable as $token)
			{
				$c_defect_table = trim($token['table_name']);
				
				// ALL OVERALL CQ SCORE
				/* $sql_tlScore = "SELECT count(*) as auditCount, qa.agent_id, avg(qa.overall_score) as score, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$office_id' AND qa.audit_type = 'CQ Audit'
								$extraTLFilter GROUP BY qa.agent_id"; */
				$sql_tlScore = "SELECT count(*) as auditCount, qa.agent_id, avg(qa.overall_score) as score, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit'
								$extraTLFilter GROUP BY qa.agent_id";
				$data['tllist'] = $c_tlScoreArray = $this->Common_model->get_query_result_array($sql_tlScore);
								
				// CQ FATAL
				/* $sql_qaScore_fatal_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$office_id' AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraTLFilter  GROUP BY qa.agent_id"; */
				$sql_qaScore_fatal_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraTLFilter  GROUP BY qa.agent_id";
				$data['fatal'] = $c_qaScore_fatal_tl = $this->Common_model->get_query_result_array($sql_qaScore_fatal_tl);
				
				
				// CQ AUTOFAIL
				/* $sql_qaScore_fail_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$office_id' AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraTLFilter  GROUP BY qa.agent_id"; */
				$sql_qaScore_fail_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraTLFilter  GROUP BY qa.agent_id";
				$data['autofail'] = $c_qaScore_autofail_tl = $this->Common_model->get_query_result_array($sql_qaScore_fail_tl);
				
				$data['tlOverview']['total'] = $c_tlScoreArray;
				$data['tlOverview']['fatal'] = $this->array_indexed($c_qaScore_fatal_tl, 'fusion_id');
				$data['tlOverview']['autofail'] = $this->array_indexed($c_qaScore_autofail_tl, 'fusion_id');
			}			
		}
		$this->load->view('Qa_graph_boomsourcing/qa_tl_level_details',$data);
	}
	
	
	
	//==========================================================================================//
	//            TL LEVEL
	//==========================================================================================//
	
	public function tl_level()
	{ 
		if(check_logged_in())
		{
			//$this->output->enable_profiler('true');
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = $this->accessClientIds();
			
			//=========== USER DETAILS =====================//
			$sqlUser = "SELECT s.*, CONCAT(s.fname, ' ', s.lname) as fullName, CONCAT(tl.fname, ' ', tl.lname) as tlName, CONCAT(m.fname, ' ', m.lname) as managerName,
						tl.id as tl_id, m.id as manager_id, get_process_names(s.id) as process_names
			            from signin as s
						LEFT JOIN signin as tl ON tl.id = s.assigned_to
						LEFT JOIN signin as m ON m.id = tl.assigned_to
						WHERE s.id = '$current_user'";
			$userDetails = $this->Common_model->get_query_row_array($sqlUser);
			$dateOfJoining = new DateTime($userDetails['doj']);
			$tenureDays = 0;
			if(!empty($dateOfJoining) || $dateOfJoining == "0000-00-00")
			{
				$currentDate = new DateTime(CurrDate());
				//$tenureDays = strtotime($currentDate) - strtotime($dateOfJoining);
				$tenureDays = $currentDate->diff($dateOfJoining)->format("%a");
			}			
			
			
			$search_client_id = "";
			$extraClientheck = "";
			if(!empty($this->input->get('select_client'))){						
				$search_client_id = $this->input->get('select_client');
				if($search_client_id != "ALL"){
				$extraClientheck = " AND p.client_id IN ($search_client_id)";
				}				
			}			
			$data['selected_client'] = $search_client_id;
			
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			$sqlProcess = "SELECT p.name as process_name, i.process_id, c.shname as client_name, c.id as client_id from info_assign_process as i 
						   LEFT JOIN process as p ON p.id = i.process_id
						   LEFT JOIN client as c ON c.id = p.client_id						   
						   WHERE i.user_id = '$current_user'  AND c.id IN ($my_client_ids) $extraClientheck AND p.is_active = '1'";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);						
			$sqlDefectProcess = "SELECT REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' ') as process_name,
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p 
			                    INNER JOIN info_assign_process as i ON i.process_id = FLOOR(p.process_id) 
			                    LEFT JOIN client as c ON c.id = p.client_id 
								LEFT JOIN process as ip ON ip.id = p.process_id
								WHERE i.user_id = '$current_user' AND p.client_id IN ($my_client_ids) ";
			$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
			
			
			// USER DETAILS
			$currentUser = get_user_id();
			if(!empty($this->input->get('select_tl')) && $this->input->get('select_tl') != "ALL"){ $currentUser = $this->input->get('select_tl'); }
			if(get_role_dir() == 'tl' || get_role_dir() == 'agent')
			{			
				$sqlmyDetails = "SELECT s.id, s.assigned_to, get_process_ids(s.id) as process_ids from signin as s WHERE s.id IN ($currentUser)";
				$myDetails = $this->Common_model->get_query_row_array($sqlmyDetails);
				$myTL = $myDetails['assigned_to'];
				$myProcessIds = $myDetails['process_ids'];
				$myProcessArray = explode(',', $myProcessIds);
			}
			
			
			if((get_role_dir() != 'agent' && get_role_dir() != 'tl') || get_global_access())
			{
				$sqlProcess = "SELECT p.name as process_name, p.id as process_id, c.shname as client_name, c.id as client_id from process as p
							   LEFT JOIN client as c ON c.id = p.client_id						   
							   WHERE p.is_active = '1'  AND p.client_id IN ($my_client_ids) $extraClientheck ORDER by p.name";
				$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
				
				$sqlDefectProcess = "SELECT REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' ') as process_name,
							p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p
							LEFT JOIN client as c ON c.id = p.client_id 
							LEFT JOIN process as ip ON ip.id = p.process_id
							WHERE  p.client_id IN ($my_client_ids) ";
				$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
			}
			
			
			$mergeArray = array_merge($queryProcess,$queryDefectProcess);
			$finalProcess = array_unique($mergeArray, SORT_REGULAR);
			array_multisort( array_column( $finalProcess, 'client_name' ), SORT_ASC, $finalProcess );
			
			//============ USER INFO ============================//
			$data['tenureDays'] = $tenureDays;
			$data['userInfo'] = $userDetails;
			$data['userProcess'] = $queryProcess;
			$data['campaignProcess'] = $queryDefectProcess;
			$currentAgent = $userDetails['id'];
			//echo "<pre>".print_r($queryDefectProcess, 1)."</pre>"; die();
			
			// ============  FILTER DATE ========================================//			
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
			$weekArrayCheck = array();
			$monthArrayCheck = array();
			
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
			if(!empty($this->input->get('search_from_date'))){ $from_date = $this->input->get('search_from_date'); }
			if(!empty($this->input->get('search_to_date'))){ $to_date = $this->input->get('search_to_date'); }
			
			if(!empty($from_date) && !empty($to_date))
			{
				$search_month = date('m', strtotime($from_date));
				$search_year = date('Y', strtotime($from_date));
			}
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);
			
			if(empty($from_date) && empty($to_date))
			{
				$from_date = $start_date;
				$to_date = $end_date;
			}
			if(!empty($from_date) && !empty($to_date))
			{
				$start_date = $from_date;
				$end_date   = $to_date;
			}							
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			$data['from_date'] = $from_date;				
			$data['to_date'] = $to_date;				
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;			
			$data['selected_user'] = $current_user;
			
			$filterDashboard = 'tl';
			
			// ============  FILTER OFFICE ========================================//			
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
				//print_r($this->input->get('select_office'));
				$search_office_string =implode("','", $search_office); // Added on 01-02-22
			}
			$data['selected_office'] = $search_office;
			
			// ============  FILTER PROCESS ========================================//			
			//$search_process_id = !empty($queryProcess[0]['process_id']) ? $queryProcess[0]['process_id'] : "";
			$search_process_id = "";
			if(!empty($this->input->get('select_process'))){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;
			
			// ============  FILTER CAMPAIGN ========================================//			
			$search_campaign_id = "";
			if(!empty($this->input->get('select_campaign'))){ 					
				$search_campaign_id = $this->input->get('select_campaign');
			}			
			$data['selected_campaign'] = $search_campaign_id;
			
			// ============  FILTER MANAGER ========================================//			
			$search_manger_id = "";
			if(!empty($this->input->get('select_manager')) && $this->input->get('select_manager') != "ALL"){ 					
				$search_manger_id = $this->input->get('select_manager');
			}			
			$data['selected_manager'] = $search_manger_id;
			
			// ============  FILTER TL ========================================//			
			$search_tl_id = "";
			if(!empty($this->input->get('select_tl'))){ 					
				$search_tl_id = $this->input->get('select_tl');
			}			
			$data['selected_tl'] = $search_tl_id;
			if($search_tl_id == 'ALL')
			{
				$filterDashboard = 'manager';
			}
			
			// ============  FILTER AGENT ========================================//			
			$search_agent_id = "";
			if(!empty($this->input->get('select_agent'))){ 					
				$search_agent_id = $this->input->get('select_agent');
			}			
			$data['selected_agent'] = $search_agent_id;
			
			
			
			
			// ============== DASHBOARD SELECTION ===========================//
			if($filterDashboard == 'tl')
			{
				$sendUrl = base_url() ."Qa_graph_boomsourcing/tl_level?submitgraph=search";
				$sendUrl .= "&search_from_date=".$from_date;
				$sendUrl .= "&search_to_date=".$to_date;
				//$sendUrl .= "&select_office=".$search_office;
				if(is_array($search_office)){
					foreach($search_office as $off){
						$sendUrl .= "&select_office%5B%5D=".$off;
					}
				}else{
					$sendUrl .= "&select_office=".$search_office;
				}
				$sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){  
					$sendUrl .= "&select_process=".$search_process_id;
				}
				if(!empty($search_campaign_id) && $search_campaign_id != "ALL"){  
					$sendUrl .= "&select_campaign=".$search_campaign_id;
				}
				if(!empty($search_manger_id) && $search_manger_id != "ALL"){  
					$sendUrl .= "&select_manager=".$search_manger_id;
				}
				if(!empty($search_tl_id) && $search_tl_id != "ALL"){  
					$sendUrl .= "&select_tl=".$search_tl_id;
				}
				if(!empty($search_agent_id) && $search_agent_id != "ALL"){  
					$sendUrl .= "&select_agent=".$search_agent_id;
				}
				//redirect($sendUrl);
			}
			
			if($filterDashboard == 'manager')
			{
				$sendUrl = base_url() ."Qa_graph_boomsourcing/manager_level?submitgraph=search";
				$sendUrl .= "&search_from_date=".$from_date;
				$sendUrl .= "&search_to_date=".$to_date;
				//$sendUrl .= "&select_office=".$search_office;
				if(is_array($search_office)){
					foreach($search_office as $off){
						$sendUrl .= "&select_office%5B%5D=".$off;
					}
				}else{
					$sendUrl .= "&select_office=".$search_office;
				}
				$sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){  
					$sendUrl .= "&select_process=".$search_process_id;
				}
				if(!empty($search_campaign_id) && $search_campaign_id != "ALL"){  
					$sendUrl .= "&select_campaign=".$search_campaign_id;
				}
				if(!empty($search_manger_id) && $search_manger_id != "ALL"){  
					$sendUrl .= "&select_manager=".$search_manger_id;
				}
				//if(!empty($search_tl_id) && $search_tl_id != "ALL"){  
					$sendUrl .= "&select_tl=".$search_tl_id;
				//}
				if(!empty($search_agent_id) && $search_agent_id != "ALL"){  
					$sendUrl .= "&select_agent=".$search_agent_id;
				}
				redirect($sendUrl);
			}
			
			
			
			//===================== DROPDOWN FILTERS ======================================//			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);
			
			$data['managersList'] = array();
			$data['tlList'] = array();
			$data['agentList'] = array();
			
			if(empty($search_process_id) && get_role_dir() == 'tl')
			{
				$search_process_id = !empty($myProcessArray[0]) ? $myProcessArray[0] : "";
			}
			
			/* Multiselect location condition Added on 01-02-22*/
			$locationCondi = "";
			if(is_array($search_office)){
				if(in_array("ALL", $search_office)){
					$locationCondi = "";	
				}else{
					$locationCondi = " AND s.office_id IN ('".$search_office_string."')";
				}
			}else{
					$locationCondi = " AND s.office_id IN ('".$search_office."')";
			}
			/* end */
			
			if(!empty($search_process_id))
			{
				$extraMangerCut = "";
				$extraTLCut = "";
				$extraAgentCut = "";
				if(get_role_dir() == 'tl'){
					$search_manger_id = $myTL;
					$search_tl_id = $currentUser;
					$extraMangerCut = " AND s.id IN ($myTL)"; 
					$extraTLCut = " AND s.id IN ($currentUser)"; 
					$extraAgentCut = " AND s.assigned_to IN ($currentUser)"; 
				}
				/*$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' AND s.office_id = '$search_office' $extraMangerCut";*/
				$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' $locationCondi $extraMangerCut AND s.role_id=224";
				$data['managersList'] = $queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
				
				if(!empty($search_manger_id))
				{
					/* $sqlTls = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' AND s.office_id = '$search_office' AND s.assigned_to = '$search_manger_id' $extraTLCut"; */
						
					$sqlTls = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_manger_id' $extraTLCut";
					$data['tlList'] = $queryTls = $this->Common_model->get_query_result_array($sqlTls);
					
					if(!empty($search_tl_id))
					{
						/* $sqlAgents = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' AND s.office_id = '$search_office' AND s.assigned_to = '$search_tl_id' $extraAgentCut"; */
						$sqlAgents = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_tl_id' $extraAgentCut";
					    $data['agentList'] = $queryAgents = $this->Common_model->get_query_result_array($sqlAgents);
					}
				}
			}
			
			//===================== CALCULATE ======================================//
			
			if(!empty($search_campaign_id))
			{
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_campaign_id'";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);
				
				// GET USERS FILTER
				$userSearch = 0;
				$extraUserSearch = "";
				if(!empty($search_manger_id) && $search_manger_id != "ALL"){
					/* $sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' AND s.office_id = '$search_office' AND s.assigned_to = '$search_manger_id'"; */
					$sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_manger_id'";
					$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
					$userSearchTls = 0;
					if(!empty($queryManagers)){ $userSearchTls = implode(',', array_column($queryManagers, 'user_id')); }
					$extraUserSearch .= " AND s.assigned_to IN ($userSearchTls)"; 
				}
				if(!empty($search_tl_id) && $search_tl_id != "ALL"){ $extraUserSearch .= " AND s.assigned_to IN ($search_tl_id)"; }
				if(!empty($search_agent_id) && $search_agent_id != "ALL"){ $extraUserSearch .= " AND s.id IN ($search_agent_id)"; }
				/* $sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' AND s.office_id = '$search_office' $extraUserSearch"; */
				$sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' $locationCondi $extraUserSearch";
				$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
				if(!empty($queryManagers)){ $userSearch = implode(',', array_column($queryManagers, 'user_id')); }
				$extraUserFilter = " AND qa.agent_id IN ($userSearch)";
				
				// CQ SCORE
				/* $sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
								$extraUserFilter"; */
				$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit'
								$extraUserFilter";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
				
				
				//========= AGENT TENDER SCORE ========================================================//
				/* $sqlAgent = "SELECT qa.agent_id, count(qa.overall_score) as total_count, avg(qa.overall_score) as average_score, s.doj, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
							 AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' $extraUserFilter GROUP BY qa.agent_id"; */
				$sqlAgent = "SELECT qa.agent_id, count(qa.overall_score) as total_count, avg(qa.overall_score) as average_score, s.doj, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
							 $locationCondi AND qa.audit_type = 'CQ Audit' $extraUserFilter GROUP BY qa.agent_id";
				$queryAgent = $this->Common_model->get_query_result_array($sqlAgent);
				$AgnetList = $queryAgent;				
				$currentDate = CurrDate();
				$tenure1_Ar = array_filter($AgnetList, function ($token) use ($currentDate) {
					if($token['doj'] != ""){
						if(strtotime($currentDate) <= strtotime("+30 days", strtotime($token['doj'])))
						{
							return $token;
						}
					}
				});
				//$t1_average_score_sum = array_sum($tenure1_Ar, array_column('average_score'));
				$t1_average_score_sum = array_sum(array_column($tenure1_Ar,'average_score'));
				$t1_average_score_percent = 0;
				if(!empty($tenure1_Ar) || !empty($t1_average_score_sum)){ $t1_average_score_percent = ($t1_average_score_sum / count($tenure1_Ar)); }
				
				$tenure2_Ar = array_filter($AgnetList, function ($token) use ($currentDate) {
					if($token['doj'] != ""){
						if(strtotime($currentDate) > strtotime("+30 days", strtotime($token['doj'])) && strtotime($currentDate) <= strtotime("+60 days", strtotime($token['doj'])))
						{
							return $token;
						}
					}
				});
				//$t2_average_score_sum = array_sum($tenure2_Ar, array_column('average_score'));
				$t2_average_score_sum = array_sum(array_column($tenure2_Ar,'average_score'));
				$t2_average_score_percent = 0;
				if(!empty($tenure2_Ar) || !empty($t2_average_score_sum)){ $t2_average_score_percent = ($t2_average_score_sum / count($tenure2_Ar)); }
				
				$tenure3_Ar = array_filter($AgnetList, function ($token) use ($currentDate) {
					if($token['doj'] != ""){
						if(strtotime($currentDate) > strtotime("+60 days", strtotime($token['doj'])))
						{
							return $token;
						}
					}
				});
				
				$t3_average_score_sum = array_sum(array_column($tenure3_Ar, 'average_score'));
				$t3_average_score_percent = 0;
				if(!empty($tenure3_Ar) || !empty($t3_average_score_sum)){ $t3_average_score_percent = ($t3_average_score_sum / count($tenure3_Ar)); }
				
				//========= TOP 85% SCORE ========================================================//
				/* $sqlTopAgent = "SELECT qa.agent_id, avg(qa.overall_score) as overall_score, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
							 AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= '85' $extraUserFilter GROUP BY qa.agent_id"; */
				$sqlTopAgent = "SELECT qa.agent_id, avg(qa.overall_score) as overall_score, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
							$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= '85' $extraUserFilter GROUP BY qa.agent_id";
				
				$queryTopAgent = $this->Common_model->get_query_result_array($sqlTopAgent);
				//arsort(array_column($queryTopAgent['overall_score']));
				if(!empty($queryTopAgent))arsort(array_column($queryTopAgent,"overall_score"));
				
				
				// CQ FATAL
				/* $sql_qaScore_fatal = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraUserFilter  GROUP BY qa.agent_id"; */
				$sql_qaScore_fatal = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraUserFilter  GROUP BY qa.agent_id";
				$c_qaScore_fatal = $this->Common_model->get_query_result_array($sql_qaScore_fatal);
				
				
				// CQ AUTOFAIL
				/* $sql_qaScore_fail = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraUserFilter  GROUP BY qa.agent_id"; */
				$sql_qaScore_fail = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraUserFilter  GROUP BY qa.agent_id";
				$c_qaScore_autofail = $this->Common_model->get_query_result_array($sql_qaScore_fail);
				
				
				
				//========= SAMRT VIEW SCORE ========================================================//
				if(!empty($from_date) && !empty($to_date))
				{
					$search_from_date = $from_date;
					$search_to_date = $to_date;
					
					$d1=new DateTime($search_from_date); 
					$d2=new DateTime($search_to_date);                                  
					$Months = $d2->diff($d1); 
					$howeverManyMonths = (($Months->y) * 12) + ($Months->m);
					$showType = 'week';
					if($howeverManyMonths >= 2)
					{
						$showType = 'month';
					}				
					
					if($showType == 'week')
					{
						$enderDate = new DateTime($search_to_date);
						$starterDate = new DateTime($search_from_date);
						$weekCheck = 0; $week = array();
						while(strtotime($starterDate->format('Y-m-d')) <= strtotime($enderDate->format('Y-m-d')))
						{
							$weekCheck++;
							if($weekCheck > 1){ $starterDate->modify('+1 day'); }						
							$letsStart = $starterDate->format('Y-m-d');
							$starterDate->modify('+6 day');
							$letsend = $starterDate->format('Y-m-d');
							if(strtotime($letsend) >= strtotime($enderDate->format('Y-m-d')))
							{
								$letsend = $enderDate->format('Y-m-d');
							}
							
							/* $sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$letsStart."' AND DATE(qa.audit_date) <='".$letsend."') 
											AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
											$extraUserFilter"; */
							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$letsStart."' AND DATE(qa.audit_date) <='".$letsend."') 
											$locationCondi AND qa.audit_type = 'CQ Audit'
											$extraUserFilter";
							$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
							$myAuditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
							$myCQScore = sprintf('%.2f', $c_qaScore['score']);
							
							$weekArray = array(
							    "week" => "Week " .$weekCheck,
								"start_date" => $letsStart,
								"end_date" => $letsend,
								"audit" => $myAuditCount,
								"score" => $myCQScore
							);
							$weekArrayCheck[] = $weekArray;
						}
						
					}
					
					if($showType == 'month')
					{
						$checkStartYear = date('Y', strtotime($from_date));					
						$checkendYear = date('Y', strtotime($to_date));
						$startingMonth = date('m', strtotime($from_date));
						$endingMonth = date('m', strtotime($to_date));
						$looper = true; $sn = 0;
						
						$currentMonth = $startingMonth;
						$currentYear = $checkStartYear;
						while($looper == true)
						{
							$sn++;						
							if($currentMonth >= $endingMonth && $currentYear >= $checkendYear){ 
								$looper = false; 
							}
							$m_start_date = $currentYear ."-" .sprintf('%02d',$currentMonth) ."-" ."01";
							$m_end_date   = $currentYear ."-" .sprintf('%02d',$currentMonth) ."-" .cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);					
							if($currentMonth == 12 && $currentYear < $checkendYear){ $currentMonth = 0; $currentYear++; }
							$currentMonth++;
							
							/* $sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$m_start_date."' AND DATE(qa.audit_date) <='".$m_end_date."') 
											AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
											$extraUserFilter"; */
							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$m_start_date."' AND DATE(qa.audit_date) <='".$m_end_date."') 
											$locationCondi AND qa.audit_type = 'CQ Audit'
											$extraUserFilter";
							$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
							$myAuditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
							$myCQScore = sprintf('%.2f', $c_qaScore['score']);
							
							$monthArray = array(
								"month" => date('F', strtotime($m_start_date)),
								"year" => date('Y', strtotime($m_start_date)),
								"start_date" => $m_start_date,
								"end_date" => $m_end_date,
								"score" => $myCQScore,
								"audit" => $myAuditCount
							);
							$monthArrayCheck[] = $monthArray;
							if($sn > 50){ $looper = false; }
						}
					}
				}
				
				$data['showtype'] = $showType;
				$data['monthArray'] = $monthArrayCheck;
				$data['weekArray'] = $weekArrayCheck;
				
					
				//============== PARAMETER DEFECT SCORE ================================================//
				$params = array();
				$paramColumns = $get_defect_columns['params_columns'];
				$paramsArray = explode(',', $paramColumns);
				foreach($paramsArray as $token)
				{
					/* $sqlToken = "SELECT count(*) as auditCount, avg(overall_score) as score from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail') $extraUserFilter"; */
					$sqlToken = "SELECT count(*) as auditCount, avg(overall_score) as score from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail') $extraUserFilter";
					$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
					$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
					$paramsPercent = 0;
					if($totalAuditCount > 0){
						$paramsPercent = ($c_ParamCount / $totalAuditCount) * 100;
						$paramsPercent = sprintf('%.2f',$paramsPercent);
						//$paramsPercent = !empty($c_qaScore['score']) ? sprintf('%.2f',($c_qaScore['score'])) : 0;
					}
					$params['count'][$token] = $c_ParamCount;
					$params['percent'][$token] = $paramsPercent;					
				}
				
				arsort($params['count']);
				arsort($params['percent']);
				$params['graph'][1] = array("#ffc000", "#fff2cc");
				$params['graph'][2] = array("#7f7f7f", "#e5e5e5");
				$params['graph'][3] = array("#7f6000", "#e5dfcc");
				$params['graph'][4] = array("#4d1e62", "#dbd2e0");
				$params['graph'][5] = array("#00b0f0", "#cceffc");
				
				
				$data['cq']['params'] = $params;
				$data['cq']['audit']['percent'] = $avgCQScore;
				$data['cq']['audit']['total'] = $totalAuditCount;
				$data['cq']['audit']['cq'] = $c_auditCount;				
				
				$data['overview']['total_count'] = $totalAuditCount;
				$data['overview']['cq_score'] = $avgCQScore;
				$data['overview']['total_agent'] = count($AgnetList);
				$data['overview']['top_array'] = $queryTopAgent;
				
				$data['overview']['tenure_1'] = count($tenure1_Ar);
				$data['overview']['tenure_2'] = count($tenure2_Ar);
				$data['overview']['tenure_3'] = count($tenure3_Ar);
				$data['overview']['tenure_1_score'] = sprintf('%0.2f', $t1_average_score_percent);
				$data['overview']['tenure_2_score'] = sprintf('%0.2f', $t2_average_score_percent);
				$data['overview']['tenure_3_score'] = sprintf('%0.2f', $t3_average_score_percent);
				
				$data['agentOverview']['total'] = $queryAgent;
				$data['agentOverview']['fatal'] = $this->array_indexed($c_qaScore_fatal, 'agent_id');
				$data['agentOverview']['autofail'] = $this->array_indexed($c_qaScore_autofail, 'agent_id');
				
				//echo "<pre>" .print_r($data['overview'], 1) ."</pre>"; die();
				
			}			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_tl_level.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_tl_level_js.php";
							
			$this->load->view('dashboard',$data);
			
		}
		
	}
	
	
	
	//==========================================================================================//
	//            MANAGER LEVEL
	//==========================================================================================//
	
	public function manager_level()
	{ 
		if(check_logged_in())
		{
			//$this->output->enable_profiler('true');
			//$this->db->db_debug = true;
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = $this->accessClientIds();

			// Vertical
			$data['vertical_list'] = $this->db->query("SELECT * FROM qa_vertical_data WHERE is_active = 1")->result_array();
			$data['select_vertical'] = $selected_vertical = $this->input->get("select_vertical");
			if($selected_vertical != "All" && $selected_vertical != "") $verticalCond = "AND s.vertical_id = $selected_vertical";

			// Channel
			$data['channel_list'] = $this->db->query("SELECT * FROM qa_channel_data WHERE is_active = 1")->result_array();
			$data['select_channel'] = $selected_channel = $this->input->get("select_channel");
			if($selected_channel != "All" && $selected_channel != "") $channelCond = "AND s.channel_id = $selected_channel";
			
			//=========== USER DETAILS =====================//
			$sqlUser = "SELECT s.*, CONCAT(s.fname, ' ', s.lname) as fullName, CONCAT(tl.fname, ' ', tl.lname) as tlName, CONCAT(m.fname, ' ', m.lname) as managerName,
						tl.id as tl_id, m.id as manager_id, get_process_names(s.id) as process_names
			            from signin as s
						LEFT JOIN signin as tl ON tl.id = s.assigned_to
						LEFT JOIN signin as m ON m.id = tl.assigned_to
						WHERE s.id = '$current_user'";
			$userDetails = $this->Common_model->get_query_row_array($sqlUser);
			$dateOfJoining = new DateTime($userDetails['doj']);
			$tenureDays = 0;
			if(!empty($dateOfJoining) || $dateOfJoining == "0000-00-00")
			{
				$currentDate = new DateTime(CurrDate());
				//$tenureDays = strtotime($currentDate) - strtotime($dateOfJoining);
				$tenureDays = $currentDate->diff($dateOfJoining)->format("%a");
			}			
			
			$extraCheck = "";
			$extraQCheck = "";
			if(!empty($this->input->get('select_process')))
			{
				$cProcessQ = $this->input->get('select_process');
				$extraCheck = " AND p.id IN ($cProcessQ)";				
				$extraQCheck = " AND FLOOR(p.process_id) IN ($cProcessQ)";
			}
			
			$search_client_id = "1";
			$extraClientheck = " AND p.client_id IN ($search_client_id)";
			// if(!empty($this->input->get('select_client'))){						
			// 	$search_client_id = $this->input->get('select_client');
			// 	if($search_client_id != "ALL"){
			// 	$extraClientheck = " AND p.client_id IN ($search_client_id)";
			// 	}
			// }
			$data['selected_client'] = $search_client_id;
			
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			
			$sqlProcess = "SELECT p.name as process_name, i.process_id, c.shname as client_name, c.id as client_id from info_assign_process as i 
						   LEFT JOIN process as p ON p.id = i.process_id
						   LEFT JOIN client as c ON c.id = p.client_id						   
						   WHERE i.user_id = '$current_user' AND c.id IN ($my_client_ids)  $extraClientheck AND p.is_active = '1'";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);						
			$sqlDefectProcess = "SELECT REPLACE(REPLACE(REPLACE(p.table_name, 'qa_',''), '_feedback', ''), '_', ' ') as process_name,
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p 
			                    INNER JOIN info_assign_process as i ON i.process_id = FLOOR(p.process_id) 
			                    LEFT JOIN client as c ON c.id = p.client_id 
								LEFT JOIN process as ip ON ip.id = p.process_id
								WHERE i.user_id = '$current_user' AND p.client_id IN ($my_client_ids) ";
			$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
			
			
			
			if((get_role_dir() != 'agent' && get_role_dir() != 'tl') || get_global_access())
			{
				$sqlProcess = "SELECT p.name as process_name, p.id as process_id, c.shname as client_name, c.id as client_id from process as p
							   LEFT JOIN client as c ON c.id = p.client_id						   
							   WHERE p.is_active = '1' AND p.client_id IN ($my_client_ids) $extraClientheck ORDER by p.name";
				$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
				
				$sqlDefectProcess = "SELECT REPLACE(REPLACE(REPLACE(p.table_name, 'qa_',''), '_feedback', ''), '_', ' ') as process_name,
							p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p
							LEFT JOIN client as c ON c.id = p.client_id 
							LEFT JOIN process as ip ON ip.id = p.process_id WHERE 1 AND p.client_id IN ($my_client_ids) $extraQCheck";
				$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
			}
			
			
			$mergeArray = array_merge($queryProcess,$queryDefectProcess);
			$finalProcess = array_unique($mergeArray, SORT_REGULAR);
			array_multisort( array_column( $finalProcess, 'client_name' ), SORT_ASC, $finalProcess );
			
			//============ USER INFO ============================//
			$data['tenureDays'] = $tenureDays;
			$data['userInfo'] = $userDetails;
			$data['userProcess'] = $queryProcess;
			$data['campaignProcess'] = $queryDefectProcess;
			$currentAgent = $userDetails['id'];
			//echo "<pre>".print_r($queryDefectProcess, 1)."</pre>"; die();
			
			// ============  FILTER DATE ========================================//			
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
			$weekArrayCheck = array();
			$monthArrayCheck = array();
			
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
			if(!empty($this->input->get('search_from_date'))){ $from_date = $this->input->get('search_from_date'); }
			if(!empty($this->input->get('search_to_date'))){ $to_date = $this->input->get('search_to_date'); }
			
			if(!empty($from_date) && !empty($to_date))
			{
				$search_month = date('m', strtotime($from_date));
				$search_year = date('Y', strtotime($from_date));
			}
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);
			
			if(empty($from_date) && empty($to_date))
			{
				$from_date = $start_date;
				$to_date = $end_date;
			}
			if(!empty($from_date) && !empty($to_date))
			{
				$start_date = $from_date;
				$end_date   = $to_date;
			}							
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			$data['from_date'] = $from_date;				
			$data['to_date'] = $to_date;				
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;			
			$data['selected_user'] = $current_user;
			
			$filterDashboard = 'manager';
			
			// ============  FILTER OFFICE ========================================//			
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
				//print_r($search_office);
				$search_office_string =implode("','", $search_office);
			}
			$data['selected_office'] = $search_office;
			
			// ============  FILTER PROCESS ========================================//			
			//$search_process_id = !empty($queryProcess[0]['process_id']) ? $queryProcess[0]['process_id'] : "";
			$search_process_id = "";
			if(!empty($this->input->get('select_process'))){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;
			
			// ============  FILTER CAMPAIGN ========================================//			
			$search_campaign_id = "";
			if(!empty($this->input->get('select_campaign'))){ 					
				$search_campaign_id = $this->input->get('select_campaign');
			}			
			$data['selected_campaign'] = $search_campaign_id;
			
			// ============  FILTER MANAGER ========================================//			
			$search_manger_id = "";
			if(!empty($this->input->get('select_manager')) && $this->input->get('select_manager') != "ALL"){ 					
				$search_manger_id = $this->input->get('select_manager');
			}			
			$data['selected_manager'] = $search_manger_id;
			
			// ============  FILTER TL ========================================//			
			$search_tl_id = "";
			if(!empty($this->input->get('select_tl'))){				
				$search_tl_id = $this->input->get('select_tl');
				if($search_tl_id != "ALL" && !empty($search_manger_id) && !empty($search_campaign_id) && !empty($search_process_id)){ 
					$filterDashboard = 'tl'; 
				}
			}			
			$data['selected_tl'] = $search_tl_id;
			
			// ============  FILTER AGENT ========================================//			
			$search_agent_id = "";
			if(!empty($this->input->get('select_agent'))){ 					
				$search_agent_id = $this->input->get('select_agent');
			}			
			$data['selected_agent'] = $search_agent_id;
			
			
			// ============== DASHBOARD SELECTION ===========================//
			if($filterDashboard == 'tl')
			{
				$sendUrl = base_url() ."Qa_graph_boomsourcing/tl_level?submitgraph=search";
				$sendUrl .= "&search_from_date=".$from_date;
				$sendUrl .= "&search_to_date=".$to_date;
				//$sendUrl .= "&select_office=".$search_office;
				if(is_array($search_office)){
					foreach($search_office as $off){
						$sendUrl .= "&select_office%5B%5D=".$off;
					}
				}else{
					$sendUrl .= "&select_office=".$search_office;
				}
				$sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){  
					$sendUrl .= "&select_process=".$search_process_id;
				}
				if(!empty($search_campaign_id) && $search_campaign_id != "ALL"){  
					$sendUrl .= "&select_campaign=".$search_campaign_id;
				}
				if(!empty($search_manger_id) && $search_manger_id != "ALL"){  
					$sendUrl .= "&select_manager=".$search_manger_id;
				}
				if(!empty($search_tl_id) && $search_tl_id != "ALL"){  
					$sendUrl .= "&select_tl=".$search_tl_id;
				}
				if(!empty($search_agent_id) && $search_agent_id != "ALL"){  
					$sendUrl .= "&select_agent=".$search_agent_id;
				}
				redirect($sendUrl);
			}
			
			if($filterDashboard == 'manager')
			{
				$sendUrl = base_url() ."Qa_graph_boomsourcing/manager_level?submitgraph=search";
				$sendUrl .= "&search_from_date=".$from_date;
				$sendUrl .= "&search_to_date=".$to_date;
				//$sendUrl .= "&select_office=".$search_office;
				 if(is_array($search_office)){
					foreach($search_office as $off){
						$sendUrl .= "&select_office%5B%5D=".$off;
					}
				}else{
					$sendUrl .= "&select_office=".$search_office;
				} 
				$sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){  
					$sendUrl .= "&select_process=".$search_process_id;
				}
				if(!empty($search_campaign_id) && $search_campaign_id != "ALL"){  
					$sendUrl .= "&select_campaign=".$search_campaign_id;
				}
				if(!empty($search_manger_id) && $search_manger_id != "ALL"){  
					$sendUrl .= "&select_manager=".$search_manger_id;
				}
				//if(!empty($search_tl_id) && $search_tl_id != "ALL"){  
					$sendUrl .= "&select_tl=".$search_tl_id;
				//}
				if(!empty($search_agent_id) && $search_agent_id != "ALL"){  
					$sendUrl .= "&select_agent=".$search_agent_id;
				}
				//redirect($sendUrl);
			}
			
			
			
			
			//===================== DROPDOWN FILTERS ======================================//			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// Process Selection
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);
			
			$data['managersList'] = array();
			$data['tlList'] = array();
			$data['agentList'] = array();
			
			/* Multiselect location condition */
			$locationCondi = "";
			if(is_array($search_office)){
				if(in_array("ALL", $search_office)){
					$locationCondi = "";	
				}else{
					$locationCondi = " AND s.office_id IN ('".$search_office_string."')";
				}
			}else{
					$locationCondi = " AND s.office_id IN ('".$search_office."')";
			}
			/* end */
			if(!empty($search_process_id))
			{
				
				/*$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' AND s.office_id = '$search_office'";*/
				
				 $sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' $locationCondi AND s.role_id=224";
				//echo $sqlManagers; 
				$data['managersListDropDown'] = $queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
								
				if(!empty($search_manger_id) && $search_manger_id != "ALL")
				{
					/*if any manager selected start*/
					$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' $locationCondi AND s.role_id=224 AND s.id=$search_manger_id";
					//echo $sqlManagers; 
					$data['managersList'] = $queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
					/*if any manager selected end */
					
					/* $sqlTls = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' AND s.office_id = '$search_office' AND s.assigned_to = '$search_manger_id'"; */
					$sqlTls = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_manger_id'";
					$data['tlList'] = $queryTls = $this->Common_model->get_query_result_array($sqlTls);
					
					if(!empty($search_tl_id) && $search_tl_id != "ALL")
					{
						/* $sqlAgents = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' AND s.office_id = '$search_office' AND s.assigned_to = '$search_tl_id'"; */
						
						$sqlAgents = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_tl_id'";
						
					    $data['agentList'] = $queryAgents = $this->Common_model->get_query_result_array($sqlAgents);
					}
				}else{
					/*if all manager selected start*/
					$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' $locationCondi AND s.role_id=224";
					//echo $sqlManagers; 
					$data['managersList'] = $queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
					/*if all manager selected end */
				}
			}
			
			//===================== CALCULATE ======================================//
			
			if(!empty($search_campaign_id))
			{
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_campaign_id'";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);
				
				// GET USERS FILTER
				$userSearch = 0;
				$extraUserSearch = "";
				$extraTLFilter = "";
				if(!empty($search_manger_id) && $search_manger_id != "ALL"){
					/* $sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' AND s.office_id = '$search_office' AND s.assigned_to = '$search_manger_id'"; */
					$sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_manger_id'";
					$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
					$userSearchTls = 0;
					if(!empty($queryManagers)){
						$userSearchTls = implode(',', array_column($queryManagers, 'user_id'));						
					}
					$extraUserSearch .= " AND s.assigned_to IN ($userSearchTls)"; 
					$extraTLFilter .= " AND s.assigned_to IN ($userSearchTls)"; 
				}
				if(!empty($search_tl_id) && $search_tl_id != "ALL"){
					$extraTLFilter .= " AND s.assigned_to IN ($search_tl_id)";
					$extraUserSearch .= " AND s.assigned_to IN ($search_tl_id)"; 
				}
				if(!empty($search_agent_id) && $search_agent_id != "ALL"){ 
					$extraUserSearch .= " AND s.id IN ($search_agent_id)"; 
				}
				
				
				/* $sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' AND s.office_id = '$search_office' $extraUserSearch"; */
				$sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' $locationCondi $extraUserSearch";
				$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
				if(!empty($queryManagers)){ $userSearch = implode(',', array_column($queryManagers, 'user_id')); }
				$extraUserFilter = " AND qa.agent_id IN ($userSearch)";
				
				
				//==== MANAGERS
				
				$managerAgents = array();
				$managerCQScore = array();
				if(empty($selected_manager)){
				foreach($data['managersList'] as $tokenManagers)
				{
					$currentManager = $tokenManagers['id'];
					/* $sqlMTls = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' AND s.office_id = '$search_office' AND s.assigned_to = '$currentManager'"; */
					$sqlMTls = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$currentManager'";
					$queryMTls = $this->Common_model->get_query_result_array($sqlMTls);					
					$userSearchManagerTls = 0;
					if(!empty($queryMTls)){
						$userSearchManagerTls = implode(',', array_column($queryMTls, 'id'));						
					}
					$managerAgents[$currentManager]['tl'] = $userSearchManagerTls; 
					$managerAgents[$currentManager]['id'] = $tokenManagers['id']; 
					$managerAgents[$currentManager]['fullname'] = $tokenManagers['fullname']; 
					$managerAgents[$currentManager]['data'] = $tokenManagers; 
					
					
					// ==== MANAGER 
				
					// ALL OVERALL CQ SCORE
					/* $sql_tlScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									INNER JOIN signin as l ON l.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND s.assigned_to IN ($userSearchManagerTls)"; */
					$sql_tlScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									INNER JOIN signin as l ON l.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$locationCondi AND qa.audit_type = 'CQ Audit' AND s.assigned_to IN ($userSearchManagerTls) $verticalCond $channelCond";
					$cm_tlScoreArray = $this->Common_model->get_query_row_array($sql_tlScore);
					$cm_auditCount = !empty($cm_tlScoreArray['auditCount']) ? $cm_tlScoreArray['auditCount'] : 0;
					$cm_totalAuditCount = $cm_auditCount;
					$cm_avgCQScore = sprintf('%.2f', $cm_tlScoreArray['score']);
					
					
					
					// CQ FATAL
					/* $sql_qaScore_fatal_tl = "SELECT count(qa.overall_score) as total_count from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									INNER JOIN signin as l ON l.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
									 AND s.assigned_to IN ($userSearchManagerTls)"; */
					$sql_qaScore_fatal_tl = "SELECT count(qa.overall_score) as total_count from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									INNER JOIN signin as l ON l.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$locationCondi AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
									 AND s.assigned_to IN ($userSearchManagerTls) $verticalCond $channelCond";
					$cm_qaScore_fatal_tl = $this->Common_model->get_query_row_array($sql_qaScore_fatal_tl);
					
					
					// CQ AUTOFAIL
					/* $sql_qaScore_fail_tl = "SELECT count(qa.overall_score) as total_count from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									INNER JOIN signin as l ON l.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
									 AND s.assigned_to IN ($userSearchManagerTls)"; */
					$sql_qaScore_fail_tl = "SELECT count(qa.overall_score) as total_count from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									INNER JOIN signin as l ON l.id = s.assigned_to
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
									 AND s.assigned_to IN ($userSearchManagerTls) $verticalCond $channelCond";
					$cm_qaScore_autofail_tl = $this->Common_model->get_query_row_array($sql_qaScore_fail_tl);
					
					$managerCQScore[$currentManager]['audit'] = $cm_totalAuditCount;
					$managerCQScore[$currentManager]['cq'] = $cm_avgCQScore;
					$managerCQScore[$currentManager]['fatal'] = $cm_qaScore_fatal_tl['total_count'];
					$managerCQScore[$currentManager]['fatalpercent'] = "0.00";
					if(!empty($cm_totalAuditCount)){
						$managerCQScore[$currentManager]['fatalpercent'] = sprintf('%.2f', ($cm_qaScore_fatal_tl['total_count'] / $cm_totalAuditCount * 100));
					}					
					$managerCQScore[$currentManager]['autofail'] = $cm_qaScore_autofail_tl['total_count'];
				}	
				}
				
				
				//========= TL
				
				// ALL OVERALL CQ SCORE
				/* $sql_tlScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
								$extraTLFilter GROUP BY s.assigned_to"; */
				$sql_tlScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit'
								$extraTLFilter $verticalCond $channelCond GROUP BY s.assigned_to";
				$c_tlScoreArray = $this->Common_model->get_query_result_array($sql_tlScore);
								
				// CQ FATAL
				/* $sql_qaScore_fatal_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraTLFilter  GROUP BY s.assigned_to"; */
				$sql_qaScore_fatal_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraTLFilter $verticalCond $channelCond GROUP BY s.assigned_to";
				
				$c_qaScore_fatal_tl = $this->Common_model->get_query_result_array($sql_qaScore_fatal_tl);
				
				
				// CQ AUTOFAIL
				/* $sql_qaScore_fail_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraTLFilter  GROUP BY s.assigned_to"; */
				$sql_qaScore_fail_tl = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(l.fname, ' ', l.lname) as fullname, l.fusion_id, l.id as tl_id  
				                from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    INNER JOIN signin as l ON l.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraTLFilter $verticalCond $channelCond GROUP BY s.assigned_to";
				$c_qaScore_autofail_tl = $this->Common_model->get_query_result_array($sql_qaScore_fail_tl);
				
				
				// OVERALL CQ SCORE
				/* $sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
								$extraUserFilter"; */
				$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit'
								$extraUserFilter $verticalCond $channelCond";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
				
				
				//========= AGENT SCORER ========================================================//
				/* $sqlAgent = "SELECT qa.agent_id, count(qa.overall_score) as total_count, avg(qa.overall_score) as average_score, s.doj, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
							 AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' $extraUserFilter GROUP BY qa.agent_id"; */
				$sqlAgent = "SELECT qa.agent_id, count(qa.overall_score) as total_count, avg(qa.overall_score) as average_score, s.doj, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
							 $locationCondi AND qa.audit_type = 'CQ Audit' $extraUserFilter $verticalCond $channelCond GROUP BY qa.agent_id";
				$queryAgent = $this->Common_model->get_query_result_array($sqlAgent);
				$AgnetList = $queryAgent;				
				
				// CQ FATAL
				/* $sql_qaScore_fatal = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraUserFilter  GROUP BY qa.agent_id"; */
				$sql_qaScore_fatal = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraUserFilter $verticalCond $channelCond GROUP BY qa.agent_id";
				$c_qaScore_fatal = $this->Common_model->get_query_result_array($sql_qaScore_fatal);
				
				
				// CQ AUTOFAIL
				/* $sql_qaScore_fail = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraUserFilter  GROUP BY qa.agent_id"; */
				$sql_qaScore_fail = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraUserFilter $verticalCond $channelCond GROUP BY qa.agent_id";
				$c_qaScore_autofail = $this->Common_model->get_query_result_array($sql_qaScore_fail);
				
				
				
				//========= SAMRT VIEW SCORE ========================================================//
				if(!empty($from_date) && !empty($to_date))
				{
					$search_from_date = $from_date;
					$search_to_date = $to_date;
					
					$d1=new DateTime($search_from_date); 
					$d2=new DateTime($search_to_date);                                  
					$Months = $d2->diff($d1); 
					$howeverManyMonths = (($Months->y) * 12) + ($Months->m);
					$showType = 'week';
					if($howeverManyMonths >= 2)
					{
						$showType = 'month';
					}				
					
					if($showType == 'week')
					{
						$enderDate = new DateTime($search_to_date);
						$starterDate = new DateTime($search_from_date);
						$weekCheck = 0; $week = array();
						while(strtotime($starterDate->format('Y-m-d')) <= strtotime($enderDate->format('Y-m-d')))
						{
							$weekCheck++;
							if($weekCheck > 1){ $starterDate->modify('+1 day'); }						
							$letsStart = $starterDate->format('Y-m-d');
							$starterDate->modify('+6 day');
							$letsend = $starterDate->format('Y-m-d');
							if(strtotime($letsend) >= strtotime($enderDate->format('Y-m-d')))
							{
								$letsend = $enderDate->format('Y-m-d');
							}
							
							/* $sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$letsStart."' AND DATE(qa.audit_date) <='".$letsend."') 
											AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
											$extraUserFilter"; */
							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$letsStart."' AND DATE(qa.audit_date) <='".$letsend."') 
											$locationCondi AND qa.audit_type = 'CQ Audit'
											$extraUserFilter $verticalCond $channelCond";
							$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
							$myAuditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
							$myCQScore = sprintf('%.2f', $c_qaScore['score']);
							
							$weekArray = array(
							    "week" => "Week " .$weekCheck,
								"start_date" => $letsStart,
								"end_date" => $letsend,
								"audit" => $myAuditCount,
								"score" => $myCQScore
							);
							$weekArrayCheck[] = $weekArray;
						}
						
					}
					
					if($showType == 'month')
					{
						$checkStartYear = date('Y', strtotime($from_date));					
						$checkendYear = date('Y', strtotime($to_date));
						$startingMonth = date('m', strtotime($from_date));
						$endingMonth = date('m', strtotime($to_date));
						$looper = true; $sn = 0;
						
						$currentMonth = $startingMonth;
						$currentYear = $checkStartYear;
						while($looper == true)
						{
							$sn++;						
							if($currentMonth >= $endingMonth && $currentYear >= $checkendYear){ 
								$looper = false; 
							}
							$m_start_date = $currentYear ."-" .sprintf('%02d',$currentMonth) ."-" ."01";
							$m_end_date   = $currentYear ."-" .sprintf('%02d',$currentMonth) ."-" .cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);					
							if($currentMonth == 12 && $currentYear < $checkendYear){ $currentMonth = 0; $currentYear++; }
							$currentMonth++;
							
							/* $sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$m_start_date."' AND DATE(qa.audit_date) <='".$m_end_date."') 
											AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
											$extraUserFilter"; */
							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$m_start_date."' AND DATE(qa.audit_date) <='".$m_end_date."') 
											$locationCondi AND qa.audit_type = 'CQ Audit'
											$extraUserFilter $verticalCond $channelCond";
							$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
							$myAuditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
							$myCQScore = sprintf('%.2f', $c_qaScore['score']);
							
							$monthArray = array(
								"month" => date('F', strtotime($m_start_date)),
								"year" => date('Y', strtotime($m_start_date)),
								"start_date" => $m_start_date,
								"end_date" => $m_end_date,
								"score" => $myCQScore,
								"audit" => $myAuditCount
							);
							$monthArrayCheck[] = $monthArray;
							if($sn > 50){ $looper = false; }
						}
					}
				}
				
				$data['showtype'] = $showType;
				$data['monthArray'] = $monthArrayCheck;
				$data['weekArray'] = $weekArrayCheck;
				
					
				//============== PARAMETER DEFECT SCORE ================================================//
				$params = array();
				$paramColumns = $get_defect_columns['params_columns'];
				$paramsArray = explode(',', $paramColumns);
				foreach($paramsArray as $token)
				{
					/* $sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail')"; */
					$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail') $verticalCond $channelCond";
					$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
					$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
					$paramsPercent = 0;
					if($totalAuditCount > 0){
						//$paramsPercent = ($c_ParamCount / $totalAuditCount) * 100;
						$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
					}
					$params['count'][$token] = $c_ParamCount;
					$params['percent'][$token] = $paramsPercent;					
				}
				
				arsort($params['count']);
				arsort($params['percent']);
				$params['graph'][1] = array("#ffc000", "#fff2cc");
				$params['graph'][2] = array("#7f7f7f", "#e5e5e5");
				$params['graph'][3] = array("#7f6000", "#e5dfcc");
				$params['graph'][4] = array("#4d1e62", "#dbd2e0");
				$params['graph'][5] = array("#00b0f0", "#cceffc");
				
				
				$data['cq']['params'] = $params;
				$data['cq']['audit']['percent'] = $avgCQScore;
				$data['cq']['audit']['total'] = $totalAuditCount;
				$data['cq']['audit']['cq'] = $c_auditCount;				
				
				$data['overview']['total_count'] = $totalAuditCount;
				$data['overview']['cq_score'] = $avgCQScore;
				$data['overview']['total_agent'] = count($AgnetList);
				$data['overview']['total_tl'] = count($c_tlScoreArray);
				$data['overview']['tl_array'] = $c_tlScoreArray;
				
				$data['agentOverview']['total'] = $queryAgent;
				$data['agentOverview']['fatal'] = $this->array_indexed($c_qaScore_fatal, 'agent_id');
				$data['agentOverview']['autofail'] = $this->array_indexed($c_qaScore_autofail, 'agent_id');
				
				$data['tlOverview']['total'] = $c_tlScoreArray;
				$data['tlOverview']['fatal'] = $this->array_indexed($c_qaScore_fatal_tl, 'fusion_id');
				$data['tlOverview']['autofail'] = $this->array_indexed($c_qaScore_autofail_tl, 'fusion_id');
				
				$data['managerCQScore'] = $managerCQScore;
				$data['managerAgents'] = $managerAgents;
				
				//echo "<pre>" .print_r($data['overview'], 1) ."</pre>"; die();
				
			}			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_manager_level.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_manager_level_js.php";
							
			$this->load->view('dashboard',$data);
			
		}
		
	}
	
	
	public function search_campaign_ajax()
	{
		$process_id = $this->input->get('pid');
		$sqlDefectProcess = "SELECT REPLACE(REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' '), 'feedback','') as process_name,
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p
			                    LEFT JOIN client as c ON c.id = p.client_id 
								LEFT JOIN process as ip ON ip.id = p.process_id
								WHERE FLOOR(p.process_id) = '$process_id' AND p.process_id NOT IN ('304') ";
		$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
		echo json_encode($queryDefectProcess);
	}
	
	public function search_manager_ajax()
	{
		$process_id = $this->input->get('pid');
		$office_id = $this->input->get('oid');
		$offArr = explode(",", $office_id);
		if(in_array('ALL',$offArr)){
			//$office_id = implode("','", $offArr);
			$offCondi = "";
		}else{
			$office_id = implode("','", $offArr);
			$offCondi = " AND s.office_id IN  ('".$office_id."')";
		}
		$currentUser = get_user_id();
		if(get_role_dir() == 'tl' || get_role_dir() == 'agent')
		{			
			$sqlmyDetails = "SELECT s.id, s.assigned_to, get_process_ids(s.id) as process_ids from signin as s WHERE s.id IN ($currentUser)";
			$myDetails = $this->Common_model->get_query_row_array($sqlmyDetails);
			$myTL = $myDetails['assigned_to'];
			$myProcessIds = $myDetails['process_ids'];
			$myProcessArray = explode(',', $myProcessIds);
		}
		
		$extraMangerCut = "";
		$extraTLCut = "";
		$extraAgentCut = "";		
		if(get_role_dir() == 'tl'){
			$search_manger_id = $myTL;
			$search_tl_id = $currentUser;
			$extraMangerCut = " AND s.id IN ($myTL)"; 
			$extraTLCut = " AND s.id IN ($currentUser)"; 
			$extraAgentCut = " AND s.assigned_to IN ($currentUser)"; 
		}
		
		/*$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$process_id' AND s.office_id = '$office_id' $extraMangerCut  GROUP BY s.id";*/
		
		$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$process_id' $offCondi $extraMangerCut AND s.role_id=224  GROUP BY s.id";
						
		$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
		echo json_encode($queryManagers);
	}
	
	public function search_tl_ajax()
	{
		$process_id = $this->input->get('pid');
		$office_id = $this->input->get('oid');
		$manager_id = $this->input->get('mid');
		
		$offArr = explode(",", $office_id);
		if(in_array('ALL',$offArr)){
			//$office_id = implode("','", $offArr);
			$offCondi = "";
		}else{
			$office_id = implode("','", $offArr);
			$offCondi = " AND s.office_id IN  ('".$office_id."')";
		}
		
		$currentUser = get_user_id();
		$extraTLCut = "";
		if(get_role_dir() == 'tl' || get_role_dir() == 'agent')
		{	
			$extraTLCut = " AND s.id IN ($currentUser)"; 
		}
		
		/* $sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$process_id' AND s.office_id = '$office_id' AND s.assigned_to = '$manager_id' $extraTLCut  GROUP BY s.id";
							*/
		$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$process_id' $offCondi AND s.assigned_to = '$manager_id' $extraTLCut  GROUP BY s.id";
		$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
		echo json_encode($queryManagers);
	}
	
	public function search_agent_ajax()
	{
		$process_id = $this->input->get('pid');
		$office_id = $this->input->get('oid');
		$manager_id = $this->input->get('mid');
		$offArr = explode(",", $office_id);
		if(in_array('ALL',$offArr)){
			//$office_id = implode("','", $offArr);
			$offCondi = "";
		}else{
			$office_id = implode("','", $offArr);
			$offCondi = " AND s.office_id IN  ('".$office_id."')";
		}
		$tl_id = $this->input->get('tid');
		/* $sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$process_id' AND s.office_id = '$office_id' AND s.assigned_to = '$tl_id' GROUP BY s.id"; */
		$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$process_id' $offCondi AND s.assigned_to = '$tl_id' GROUP BY s.id";
		$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
		echo json_encode($queryManagers);
	}
	
	public function search_agent_process_ajax()
	{
		$process_id = $this->input->get('pid');
		$office_id = $this->input->get('oid');
		$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE   r.folder = 'agent' AND i.process_id = '$process_id' AND s.office_id = '$office_id' GROUP BY s.id";
		$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
		echo json_encode($queryManagers);
	}
	
	public function tl_level_details()
	{
		$process_id = $this->input->post('pid');
		$office_id = $this->input->post('oid');
		$user_id = $this->input->post('uid');
		$data['scoreDetails'] = NULL;
		
		$search_month = date('m');
		$search_year = date('Y');				
		$start_time = "00:00:00";
		$end_time = "23:59:59";
							
		$start_date = $search_year ."-" .$search_month ."-" ."01";
		$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);				
		$start_date_full = $start_date ." " .$start_time;
		$end_date_full = $end_date ." " .$end_time;
		
		$data['start_date'] = $start_date;				
		$data['end_date']   = $end_date;
		$data['start_date_full'] = $start_date_full;
		$data['end_date_full']   = $end_date_full;
		
		if($process_id != "" && $office_id != "" && $user_id != ""){
			$sqlDefectTable = "SELECT * from qa_boomsourcing_defect WHERE process_id = '$process_id'";
			$queryDefectTable = $this->Common_model->get_query_result_array($sqlDefectTable);
			foreach($queryDefectTable as $token)
			{
				$defectTable = trim($token['table_name']);
				$defectParam = $token['params_columns'];
				$sqlData = "SELECT q.*, CONCAT(s.fname, ' ', s.lname) as fullName from $defectTable as q
				            INNER JOIN signin as s ON s.id = q.agent_id
							";
				$data['scoreDetails'] = $datDetails = $this->Common_model->get_query_result_array($sqlData);			
				$data['paramColumns'] = explode(',', $defectParam);
			}
			
		}
		$this->load->view('Qa_graph_boomsourcing/qa_agent_level_details',$data);
	}
	
	
//================= ACCEPTANCE DASHBOARD =================================================//
	public function acceptance_dashboard(){

		if(check_logged_in()){

			date_default_timezone_set("Asia/Kolkata");
			$current_user     = get_user_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
						
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_graph_boomsourcing/qa_acceptance_dashboard.php";
			$data["content_js"] = "qa_graph_boomsourcing/qa_acceptance_dashboard_js.php";
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$qaSql="Select id, fusion_id, xpoid, concat(fname,' ',lname) as qa_name from signin where status=1 and dept_id=5";
			$data['qa_list'] = $this->Common_model->get_query_result_array($qaSql);

			
			$tl_sql = "SELECT DISTINCT s.id, concat(s.fname,' ',s.lname) as tl_name FROM signin s join signin si on s.id = si.assigned_to where si.status = 1 and s.dept_id = 6";
			$data['tl_details'] = $this->Common_model->get_query_result_array($tl_sql);

			$data['process_list'] = array();
			
			if(get_global_access()=='1' || $ses_client_id==0){
				$qaCond='';
			}else{
				$qaCond = "WHERE p.client_id in ( $ses_client_id ) AND p.id in ( $ses_process_id )";
			}
			
			$qSql = "SELECT p.id AS pro_id,p.name AS process_name FROM qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond";
			$process_arr1 = $this->Common_model->get_query_result_array($qSql);

			$NotINnqSql = "( SELECT p.id FROM qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond )";

			$qSql = "SELECT q.process_id AS pro_id,q.table_name AS process_name from qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id = FLOOR(q.process_id) $qaCond and q.process_id not in $NotINnqSql";
			$process_arr2 = $this->Common_model->get_query_result_array($qSql);

			$marge_array=array_unique(array_merge($process_arr1,$process_arr2)); 
			$data['process_list'] = $marge_array;

			$default_val[] = 'ALL'; 
			$ofc_id = $this->input->get('select_office')?$this->input->get('select_office'):$default_val;
			$process_id = $this->input->get('select_process')?$this->input->get('select_process'):578;
			$lob_id = $this->input->get('lob_id')?$this->input->get('lob_id'):$default_val;
			$tl_id = $this->input->get('l1_super')?$this->input->get('l1_super'):$default_val;
			$qa_id = $this->input->get('select_qa')?$this->input->get('select_qa'):$default_val;	
			$from_date = $this->input->get('from_date')?$this->input->get('from_date'):date('Y-m-01');	
			$to_date = $this->input->get('to_date')?$this->input->get('to_date'):date('Y-m-d');	
			
			$data['selected_office'] = $ofc_id;
			$data['selected_process'] = $process_id;
			$data['selected_lob'] = $lob_id;
			$data['selected_tl'] = $tl_id;
			$data['selected_qa'] = $qa_id;
			$data['selected_from_date'] = $from_date;
			$data['selected_to_date'] = $to_date;
			if($ofc_id!=""){
				if (in_array("ALL",$ofc_id, TRUE)){
					$off_cond='';
				}else{
					$off_id=implode('","', $ofc_id);
					$off_cond .=' and s.office_id in ("'.$off_id.'")';
				}
			}
			if($lob_id!=""){
				if (in_array("ALL",$lob_id, TRUE)){
					$lob_cond='';
				}else{
					$campaign_id=implode('","', $lob_id);
					$lob_cond .=' and s.assigned_campaign in ("'.$campaign_id.'")';
				}
			}
			if($tl_id!=""){
				if (in_array("ALL",$tl_id, TRUE)){
					$tl_cond='';
				}else{
					$l1_id=implode('","', $tl_id);
					$tl_cond .=' and s.assigned_to in ("'.$l1_id.'")';
				}
			}
			if($qa_id!=""){
				if (in_array("ALL",$qa_id, TRUE)){
					$qa_cond='';
				}else{
					$assigned_qa=implode('","', $qa_id);
					$qa_cond .=' and s.assigned_qa in ("'.$assigned_qa.'")';
				}
			}

			if($process_id!='a')
			{
				
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_boomsourcing_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET("'.$process_id.'",process_id)');
				$row = $query->row();
				$table = $row->table_name;
				$pros_name = $row->table_name;
				$data['process_name'] = $row->process_name;
				$audit_excluded = implode('","', $getExcluded_Audits);
				//exit;
				/*sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,*/
				$overall_sql = "select count(t.id) as total_feedback,'$pros_name' as process,
				sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
				sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
				sum(case when t.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
				sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
				from $table t join signin s on t.agent_id = s.id
				where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $tl_cond $qa_cond";

				/*$lob_cond */
				$overall_data = $this->Common_model->get_query_row_array($overall_sql);
				if ($overall_data['total_feedback'] == 0) {
					$data['overall_data'] = [];
				}else{
					$data['overall_data'] = $overall_data;
				}

				$lobwise_sql = "select count(t.id) as total_feedback,t.lob_campaign,
				sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
				sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
				sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
				sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
				sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.agent_rvw_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
				from $table t join signin s on t.agent_id = s.id
				where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $lob_cond $tl_cond $qa_cond group by t.lob_campaign";
				// $data['lobwise_data'] = $this->Common_model->get_query_result_array($lobwise_sql);
				$data['lobwise_data'] = '';

				/*sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,*/
				$tlwise_sql = "select count(t.id) as total_feedback,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name, sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
				sum(case when t.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
				sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from $table t join signin s on t.agent_id = s.id
				where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $tl_cond $qa_cond group by t.tl_id";
				$data['tlwise_data'] = $this->Common_model->get_query_result_array($tlwise_sql);

				/*sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,*/
				$qawise_sql = "select count(t.id) as total_feedback,t.entry_by, (select concat(fname,' ',lname) as qa_name FROM signin WHERE signin.id = t.entry_by) as qa_name, (select d.description FROM signin si join department d on si.dept_id = d.id WHERE si.id = t.entry_by) as department, sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
				sum(case when t.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
				sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from $table t join signin s on t.agent_id = s.id
				where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $lob_cond $tl_cond $qa_cond group by t.entry_by";
				$data['qawise_data'] = $this->Common_model->get_query_result_array($qawise_sql);

				/*sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,*/
				$agentwise_sql = "select count(t.id) as total_feedback,concat(s.fname,' ',s.lname) as agent_name,s.xpoid,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name, sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
				sum(case when t.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
				sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from $table t join signin s on t.agent_id = s.id
				where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $lob_cond $tl_cond $qa_cond group by s.id";
				$data['agentwise_data'] = $this->Common_model->get_query_result_array($agentwise_sql);
			}
		
		$this->load->view('dashboard',$data);
	}
}
	public function acceptance_dashboard_old()
	{ 
		if(check_logged_in())
		{
			//$this->output->enable_profiler('true');
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = $this->accessClientIds();

			// Vertical
			$data['vertical_list'] = $this->db->query("SELECT * FROM qa_vertical_data WHERE is_active = 1")->result_array();
			$data['select_vertical'] = $selected_vertical = $this->input->get("select_vertical");
			if($selected_vertical != "All" && $selected_vertical != "") $verticalCond = "AND s.vertical_id = $selected_vertical";

			// Channel
			$data['channel_list'] = $this->db->query("SELECT * FROM qa_channel_data WHERE is_active = 1")->result_array();
			$data['select_channel'] = $selected_channel = $this->input->get("select_channel");
			if($selected_channel != "All" && $selected_channel != "") $channelCond = "AND s.channel_id = $selected_channel";
			
			// ============  FILTER OFFICE ========================================//			
			$search_office = $user_office_id;
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
			}
			$data['selected_office'] = $search_office;
			
			
			// ============  FILTER PROCESS ========================================//
			$search_process_id = "";
			if(!empty($this->input->get('select_process')) && $this->input->get('select_process') != "ALL"){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;
			
			$search_client_id = "1";
			// if(!empty($this->input->get('select_client'))){ 					
			// 	$search_client_id = $this->input->get('select_client');
			// }
			$data['selected_client'] = $search_client_id;
			
			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;
			
			$sqlProcess = "SELECT p.name as process_name, i.process_id, c.shname as client_name, c.id as client_id from info_assign_process as i 
						   LEFT JOIN process as p ON p.id = i.process_id
						   LEFT JOIN client as c ON c.id = p.client_id						   
						   WHERE i.user_id = '$current_user'  AND c.id IN ($my_client_ids) ";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
						
			$sqlDefectProcess = "SELECT CASE 
			                    WHEN ip.name <> '' OR ip.name IS NOT NULL THEN ip.name 
								ELSE REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' ') 
			                    END as process_name,
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p 
			                    INNER JOIN info_assign_process as i ON i.process_id = FLOOR(p.process_id) 
			                    LEFT JOIN client as c ON c.id = p.client_id 
								LEFT JOIN process as ip ON ip.id = p.process_id
								WHERE i.user_id = '$current_user' AND p.client_id IN ($my_client_ids) ";
			$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
			
			$mergeArray = array_merge($queryProcess,$queryDefectProcess);
			$finalProcess = array_unique($mergeArray, SORT_REGULAR);
			array_multisort( array_column( $finalProcess, 'client_name' ), SORT_ASC, $finalProcess );
			
			$usersArrayAll = array();
			//if((get_role_dir() != 'agent' && get_role_dir() != 'tl') || get_global_access())
			//{						
				$sqlProcess = "SELECT p.name as process_name, p.id as process_id, c.shname as client_name, c.id as client_id from process as p
							   LEFT JOIN client as c ON c.id = p.client_id						   
							   WHERE p.is_active = '1'  AND p.client_id IN ($my_client_ids) ORDER by p.name";
				$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
				
				$sqlDefectProcess = "SELECT REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' ') as process_name,
							p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_boomsourcing_defect as p
							LEFT JOIN client as c ON c.id = p.client_id 
							LEFT JOIN process as ip ON ip.id = p.process_id AND p.client_id IN ($my_client_ids) ";
				$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);				
			//}
			
			
			//============ USER INFO ============================//
			$data['userProcess'] = $queryDefectProcess;
			$data['userAllProcess'] = $queryProcess;
			$data['agentList'] = $usersArrayAll;
			
			// ============  FILTER DATE ========================================//			
			$search_month = date('m');
			$search_year = date('Y');				
			$start_time = "00:00:00";
			$end_time = "23:59:59";
			$weekArrayCheck = array();
			$monthArrayCheck = array();
			
			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
			
			$start_date = $search_year ."-" .$search_month ."-" ."01";
			$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);				
			$start_date_full = $start_date ." " .$start_time;
			$end_date_full = $end_date ." " .$end_time;
			
			//$start_date = "2018" ."-" .$search_month ."-" ."01";
			
			$data['start_date'] = $start_date;				
			$data['end_date']   = $end_date;
			$data['start_date_full'] = $start_date_full;
			$data['end_date_full']   = $end_date_full;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;			
			$data['selected_user'] = $current_user;
			
			//===================== DROPDOWN FILTERS ======================================//			
			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$extraProcessFilter = "";
			if(!empty($search_process_id))
			{
				$extraProcessFilter = " AND q.process_id = '$search_process_id'";
			}
			
			// QA DEFECT PROCESS Selection
			$sqlQAProcess = "SELECT q.*, p.name as process_name, c.shname as client_name 
			                       FROM qa_boomsourcing_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id 
								   WHERE 1  AND q.client_id IN ($my_client_ids) $extraProcessFilter
								   ORDER by q.table_name";
			$data['processQAlist'] = $processQAArray = $this->Common_model->get_query_result_array($sqlQAProcess);
			
			
			
			////========== QA DEFECT - PROGRAMS ===========////
			$totalProcess = 0;
			$totalFeedBackRaised = 0;
			$totalFeedBackAccepted = 0;
			$dbName = $this->db->database;
			//$qa_table_name = array_column($queryTables, 'table_name');				
			$allData = array(); 
			$final_audit_count = 0;
			$total_programs = 0;
			foreach($processQAArray as $token)
			{
				// FIND TABLE
				$tableFound = false;
				$currentTable = trim($token['table_name']);
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$currentTable'";
				$countCheck = $this->Common_model->get_single_value($sqlCheck);
				if($countCheck > 0){ $tableFound = true; }
				
				//$result = "<b>NOT FOUND</b> <br/><hr/>";
				//if($tableFound){ $result = "ALL OK  <b>||</b> "; }
				//echo "TABLE : " .$currentTable ." - " .$result;
				
			if($tableFound){
				
				$currentTable = trim($token['table_name']);
				$currentsubProcess = $token['process_id'];
				$currentProcess = round($token['process_id']);
				$currentClient = $token['client_id'];					
				$processChecker = $token['process_id'] - $currentProcess;
				$myProcess = strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', $currentTable))));
				
				$found = false;
				$type = "column";
				$agent_column_rvw = "agent_rvw_note";
				$mgnt_column_rvw = "mgnt_rvw_note";
				
				// CHECK COLUMNS
				if(!$found){
					$agentTable = $currentTable;
					$mgntTable = $currentTable;
					$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$currentTable' AND (COLUMN_NAME = '$agent_column_rvw' OR COLUMN_NAME = '$mgnt_column_rvw')";
					$countCheck = $this->Common_model->get_single_value($sqlCheck);
					if($countCheck > 0){ $type = "column"; $found = true; }
				}
				
				if(!$found){
					$agentTable = str_replace('_feedback', '', $currentTable);
					$agentTable = str_replace('_tickets', '', $agentTable);
					$agentTable = $agentTable.'_agent_rvw';
					$mgntTable = str_replace('_feedback', '', $currentTable);
					$mgntTable = str_replace('_tickets', '', $mgntTable);
					$mgntTable = $mgntTable.'_mgnt_rvw';
					$sqlCheck = "SELECT count(*) as value FROM information_schema.tables WHERE table_schema = '$dbName' AND table_name = '$agentTable' LIMIT 1";
					$countCheck = $this->Common_model->get_single_value($sqlCheck);
					if($countCheck > 0){
						$sqlCheck = "SELECT count(*) as value FROM information_schema.tables WHERE table_schema = '$dbName' AND table_name = '$mgntTable' LIMIT 1";
						$countCheck = $this->Common_model->get_single_value($sqlCheck);
						if($countCheck > 0){ $type = "table"; $found = true; }
					}					
				}
				
				if(!$found){
					$agentTable = str_replace('_feedback', '', $currentTable);
					$agentTable = str_replace('_tickets', '', $agentTable);
					$agentTable = $agentTable.'_agent_review';
					$mgntTable = str_replace('_feedback', '', $currentTable);
					$mgntTable = str_replace('_tickets', '', $mgntTable);
					$mgntTable = $mgntTable.'_mgnt_review';
					$sqlCheck = "SELECT count(*) as value FROM information_schema.tables WHERE table_schema = '$dbName' AND table_name = '$agentTable' LIMIT 1";
					$countCheck = $this->Common_model->get_single_value($sqlCheck);
					if($countCheck > 0){
						$sqlCheck = "SELECT count(*) as value FROM information_schema.tables WHERE table_schema = '$dbName' AND table_name = '$mgntTable' LIMIT 1";
						$countCheck = $this->Common_model->get_single_value($sqlCheck);
						if($countCheck > 0){ 
							$type = "custom";
							$found = true; 
						} else {
							$mgntTable = str_replace('feedback', 'mngr_review', $currentTable);
							$sqlCheck = "SELECT count(*) as value FROM information_schema.tables WHERE table_schema = '$dbName' AND table_name = '$mgntTable' LIMIT 1";
							$countCheck = $this->Common_model->get_single_value($sqlCheck);
							if($countCheck > 0){ $type = "custom"; $found = true; }
						}
					}					
				}
				
				// COUNT FEEDBACK RAISED
				$sqlCount = "SELECT COUNT(*) AS value
				FROM $currentTable AS qa 
				INNER JOIN signin AS s ON s.id = qa.agent_id
				WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
					AND s.office_id = '$search_office' 
					AND qa.audit_type = 'CQ Audit'
					$verticalCond
					$channelCond";
				$countFeedback = $this->Common_model->get_single_value($sqlCount);
				
				// GET ACCEPTED FEEDBACK
				if($type == "column"){
					
					$agent_column_rvw = "agent_rvw_note";				
					$agent_column_date = "agent_rvw_date";
					$mgnt_column_rvw = "mgnt_rvw_note";
					$mgnt_column_date = "mgnt_rvw_date";
					
					$sqlAccepted = "SELECT COUNT(*) AS value
					FROM $agentTable AS qa
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit'
						AND (qa.$agent_column_rvw <> '' AND qa.$agent_column_rvw IS NOT NULL)
						$verticalCond
						$channelCond";
					/* OR qa.overall_score = 100) */
					$countAccepted = $this->Common_model->get_single_value($sqlAccepted);
					
					$sqlTimeAccepted = "SELECT COUNT(*) AS value
					FROM $agentTable AS qa
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit'
						AND (qa.$agent_column_rvw <> '' AND qa.$agent_column_rvw IS NOT NULL) 
						AND qa.$agent_column_date <= DATE_ADD(qa.entry_date, INTERVAL 24 HOUR)
						$verticalCond
						$channelCond";
					/* OR qa.overall_score = 100) */
					$countTimeAccepted = $this->Common_model->get_single_value($sqlTimeAccepted);					
					$countAfterTimeAccepted = $countAccepted - $countTimeAccepted;
					
					$sqlMgAccepted = "SELECT COUNT(*) AS value
					FROM $mgntTable AS qa
					INNER JOIN signin AS s ON s.id = qa.agent_id
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						AND s.office_id = '$search_office' 
						AND qa.audit_type = 'CQ Audit'
						AND ((qa.$mgnt_column_rvw <> '' AND qa.$mgnt_column_rvw IS NOT NULL) OR qa.overall_score = 100)
						$verticalCond
						$channelCond";
					$countMgAccepted = $this->Common_model->get_single_value($sqlAccepted);
				}
				
				if($type == "table"){
					
					$agent_column_rvw = "note";				
					$agent_column_date = "entry_date";
					$mgnt_column_rvw = "note";
					$mgnt_column_date = "entry_date";
					
					$sqlCheck = "SELECT COLUMN_NAME as value FROM information_schema.COLUMNS 
					             WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$agentTable' AND COLUMN_NAME IN ('entry_date', 'added_date') LIMIT 1";
					$agent_column_date = $this->Common_model->get_single_value($sqlCheck);
					
					$sqlAccepted = "SELECT count(*) as value from $agentTable as fd
									INNER JOIN $currentTable as qa ON qa.id = fd.fd_id
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
									AND (fd.$agent_column_rvw <> '' AND fd.$agent_column_rvw IS NOT NULL) $verticalCond $channelCond";
									/* OR qa.overall_score = 100) */
					$countAccepted = $this->Common_model->get_single_value($sqlAccepted);
					
					$sqlTimeAccepted = "SELECT count(*) as value from $agentTable as fd
									INNER JOIN $currentTable as qa ON qa.id = fd.fd_id
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
									AND (fd.$agent_column_rvw <> '' AND fd.$agent_column_rvw IS NOT NULL) 
									AND fd.$agent_column_date <= DATE_ADD(qa.entry_date, INTERVAL 24 HOUR) $verticalCond $channelCond";
									/* OR qa.overall_score = 100) */
					$countTimeAccepted = $this->Common_model->get_single_value($sqlTimeAccepted);					
					$countAfterTimeAccepted = $countAccepted - $countTimeAccepted;
					
					$sqlMgAccepted = "SELECT count(*) as value from $mgntTable as fd
									INNER JOIN $currentTable as qa ON qa.id = fd.fd_id
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
									AND ((fd.$mgnt_column_rvw <> '' AND fd.$mgnt_column_rvw IS NOT NULL) OR qa.overall_score = 100) $verticalCond $channelCond";
					$countMgAccepted = $this->Common_model->get_single_value($sqlAccepted);
				}
				
				
				if($type == "custom"){
					
					$agent_column_rvw = "note";				
					$agent_column_date = "entry_date";
					$mgnt_column_rvw = "note";
					$mgnt_column_date = "entry_date";
					
					$sqlCheck = "SELECT COLUMN_NAME as value FROM information_schema.COLUMNS 
					             WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$agentTable' AND COLUMN_NAME IN ('entry_date', 'added_date') LIMIT 1";
					$agent_column_date = $this->Common_model->get_single_value($sqlCheck);
										
					// GET COLUMN NAME - AGENT
					$sqlCheck = "SELECT COLUMN_NAME as value FROM information_schema.COLUMNS 
					             WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$agentTable' AND ORDINAL_POSITION = '2' LIMIT 1";
					$fdColumn = $this->Common_model->get_single_value($sqlCheck);
					
					$sqlCheck = "SELECT COLUMN_NAME as value FROM information_schema.COLUMNS 
					             WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$agentTable' AND COLUMN_NAME IN ('remarks', 'note', 'review') LIMIT 1";
					$agent_column_rvw = $this->Common_model->get_single_value($sqlCheck);
					
					$sqlAccepted = "SELECT count(*) as value from $agentTable as fd
									INNER JOIN $currentTable as qa ON qa.id = fd.$fdColumn
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
									AND (fd.$agent_column_rvw <> '' AND fd.$agent_column_rvw IS NOT NULL) $verticalCond $channelCond";
									/* OR qa.overall_score = 100) */
					$countAccepted = $this->Common_model->get_single_value($sqlAccepted);
					
					$sqlAccepted = "SELECT count(*) as value from $agentTable as fd
									INNER JOIN $currentTable as qa ON qa.id = fd.$fdColumn
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
									AND (fd.$agent_column_rvw <> '' AND fd.$agent_column_rvw IS NOT NULL) 
									AND fd.$agent_column_date <= DATE_ADD(qa.entry_date, INTERVAL 24 HOUR) $verticalCond $channelCond";
									/* OR qa.overall_score = 100) */
					$countTimeAccepted = $this->Common_model->get_single_value($sqlAccepted);					
					$countAfterTimeAccepted = $countAccepted - $countTimeAccepted;
					
					// GET COLUMN NAME - MANAGER
					$sqlCheck = "SELECT COLUMN_NAME as value FROM information_schema.COLUMNS 
					             WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$mgntTable' AND ORDINAL_POSITION = '2' LIMIT 1";
					$fdColumn = $this->Common_model->get_single_value($sqlCheck);
					
					$sqlCheck = "SELECT COLUMN_NAME as value FROM information_schema.COLUMNS 
					             WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$mgntTable' AND COLUMN_NAME IN ('remarks', 'note', 'review')  LIMIT 1";
					$mgnt_column_rvw = $this->Common_model->get_single_value($sqlCheck);
					
					$sqlMgAccepted = "SELECT count(*) as value from $mgntTable as fd
									INNER JOIN $currentTable as qa ON qa.id = fd.$fdColumn
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit'
									AND ((fd.$mgnt_column_rvw <> '' AND fd.$mgnt_column_rvw IS NOT NULL) OR qa.overall_score = 100) $verticalCond $channelCond";
					$countMgAccepted = $this->Common_model->get_single_value($sqlMgAccepted);
					
				}
					
				
				
				//=============== CHECKING TABLE OK STATUS DETAILS =====================================//
				/*
				$result = "<b>NOT FOUND</b>";
				if($found){ $result = "ALL OK"; }
				echo "CHECKING : " .$currentTable ." - " .$result;
				echo "<hr/>";
				*/
				
				/*
				echo "CHECKING : " .$currentTable;
			
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$currentTable' AND COLUMN_NAME = 'agent_rvw_note'";
				$queryCheck = $this->Common_model->get_single_value($sqlCheck);				
				echo "<br/>" .$sqlCheck ." - <b>" .$queryCheck ."</b>";
				
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$currentTable' AND COLUMN_NAME = 'mgnt_rvw_note'";
				$queryCheck = $this->Common_model->get_single_value($sqlCheck);				
				echo "<br/>" .$sqlCheck ." - <b>" .$queryCheck ."</b>";
				
				echo "<br/><br/>";
				
				$sqlCheck = "SELECT count(*) as value FROM information_schema.tables WHERE table_schema = '$dbName' AND table_name = '$agentTable' LIMIT 1";
				$queryCheck = $this->Common_model->get_single_value($sqlCheck);				
				echo "<br/>" .$sqlCheck ." - <b>" .$queryCheck ."</b>";
				
				$sqlCheck = "SELECT count(*) as value FROM information_schema.tables WHERE table_schema = '$dbName' AND table_name = '$mgntTable' LIMIT 1";
				$queryCheck = $this->Common_model->get_single_value($sqlCheck);
				echo "<br/>" .$sqlCheck ." - <b>" .$queryCheck ."</b>";
				
				echo "<br/><br/><hr/>";				
				*/
				//=============== END OF CHECKING =====================================//
				
				
				
				/*$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, p.name as process_name, c.shname as client_name from $currentTable as qa
							  INNER JOIN signin as s ON s.id = qa.agent_id
							  INNER JOIN process as p ON p.id = '$currentProcess'
							  INNER JOIN client as c ON c.id = '$currentClient'
							  WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office'";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				*/
				
				$percentAccepted = 0;
				if(!empty($countAccepted))
				{
					$percentAccepted = ($countAccepted/$countFeedback) * 100;
				}
				
				$qaAcceptance['feedback'][$currentsubProcess]['total'] = $countFeedback;
				$qaAcceptance['feedback'][$currentsubProcess]['agent'] = $countAccepted;
				$qaAcceptance['feedback'][$currentsubProcess]['manager'] = $countMgAccepted;
				$qaAcceptance['feedback'][$currentsubProcess]['details'] = array(
					"total_feedback" => $countFeedback,							
					"agent_review" => $countAccepted,
					"manager_review" => $countMgAccepted,
					"agent_before24" => $countTimeAccepted,
					"agent_after24" => $countAfterTimeAccepted,
					"manager_review" => $countMgAccepted,
					"feedback_percent" => sprintf('%.2f', $percentAccepted),
					"qa_name" => $myProcess,
					"qa_process_id" => $currentsubProcess,
					"qa_table" => $currentTable,
					"qa_agent_table" => $agentTable,
					"qa_manager_table" => $mgntTable,
					"qa_table_type" => $type,
					"qa_column_agent_review" => $agent_column_rvw,
					"qa_column_manager_review" => $mgnt_column_rvw,							
				);
				$qaAcceptance['review'][] = $qaAcceptance['feedback'][$currentsubProcess]['details'];
				//echo "DONE : " .$currentTable ."<br/><hr/>";
				
				$totalFeedBackRaised = $totalFeedBackRaised + $countFeedback;
				$totalFeedBackAccepted = $totalFeedBackAccepted + $countAccepted;
				$totalProcess++;
							
			}
			}
			
			
			$data['overview']['process_count'] = $totalProcess;
			$data['overview']['feedback_raised'] = $totalFeedBackRaised;
			$data['overview']['feedback_accepted'] = $totalFeedBackAccepted;
			$data['overview']['feedback_trend'] = !empty($totalFeedBackAccepted) ? ($totalFeedBackAccepted/$totalFeedBackRaised) * 100 : 0;
			$data['overview']['feedback_trend'] = sprintf('%.2f', $data['overview']['feedback_trend']);
			
			array_multisort(array_column($qaAcceptance['review'], 'total_feedback'), SORT_DESC, $qaAcceptance['review']);
			$data['overview']['reviewData'] = $qaAcceptance['review'];
			
			array_multisort(array_column($qaAcceptance['review'], 'agent_review'), SORT_DESC, $qaAcceptance['review']);
			$data['overview']['reviewAgent'] = $qaAcceptance['review'];
			
			//echo "<pre>".print_r($qaAcceptance['review'],1)."</pre>";
			//die();
			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_acceptance_dashboard.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_acceptance_dashboard_js.php";
							
			$this->load->view('dashboard',$data);
			
		}
		
	}	
	
	
	
	
	
	
//================ OTHER DASHBOARDS =============================================================================//
	
	public function opsview()
	{
		if(check_logged_in())
		{
			//$this->output->enable_profiler(TRUE);
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			
			// MONTH YEAR SELECTION
			$search_month = $this->input->get('select_month');
			$search_year  = $this->input->get('select_year');
			$select_office   = $this->input->get('select_office');
			$select_client   = $this->input->get('select_client');
			$select_process  = $this->input->get('select_process');
			
			if($search_month == ""){ $search_month = date('m'); }
			if($search_year == ""){ $search_year = date('Y'); }
			
			if(($search_month  != "") && ($search_year  != "")){
				
				$start_date = $search_year ."-" .$search_month ."-" ."01";
				$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);
				
				$start_date_full = $start_date ." 00:00:00";
				$end_date_full   = $end_date ." 23:59:59";
				
			}
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;
			
			// OFFICE >> CLIENT >> PROCESS
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if(get_dept_folder()=="operations"){
				$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN (SELECT client_id from info_assign_client where user_id='$current_user') ORDER BY shname";
				$result_client = $this->db->query($sql_client);
				$data['client_list'] = $result_client->result();
			} else {
				$data['client_list'] = $this->Common_model->get_client_list();
			}
			
			if(($select_office != "") && ($select_client != "") && ($select_process != "") && ($search_month != "") && ($search_year != ""))
			{
			
			$data['searchfilter'] = "yes";
			
			// PROCESS LIST UPDATE
			$sqlp = "SELECT * from process WHERE client_id = '$select_client'";
			$data['selected_process_list'] = $queryp = $this->Common_model->get_query_result_array($sqlp);
				
			$data['selected_office'] = $select_office;
			$data['selected_client'] = $select_client;
			$data['selected_process'] = $select_process;
			
			$data['total_defect_dc'] = 0;
			///==================== GET DEFECTS TABLE ========================///
			$sql_defect_columns = "SELECT count(*) as countdc, table_name, defect_columns, defect_column_names FROM qa_boomsourcing_defect WHERE FIND_IN_SET(".$select_process.",process_id)";
		    $get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
			$count_dc = $get_defect_columns['countdc'];
			$defect_table = $get_defect_columns['table_name'];
			$defect_column_key = $get_defect_columns['defect_columns'];
			$defect_column_name_key = $get_defect_columns['defect_column_names'];
			
			// GET TABLE NAME
			$current_table = 'v_qa_score'; $data['records_found'] = $records_found = '0';
			if(!empty($defect_table)){ $current_table = $defect_table; $data['records_found'] = $records_found = '1'; }
			
			$manager_list  = array();
			
			//============== GET MANAGER LIST
			$manager_id_array = "-1";
			$managerSql	=	"SELECT concat(fname,' ',lname) as fullname,r.name as roleName, s.id as userid FROM signin as s 
			 INNER JOIN role AS r ON r.id = s.role_id
			 WHERE s.office_id='".$select_office."' AND r.folder='manager' AND is_assign_client(s.id, '".$select_client."') 
			 AND is_assign_process(s.id,'".$select_process."') ORDER BY s.fname,s.lname";
			
			
			if($records_found == 1){
				
			if(isADLocation($select_office)==true)
			{
				$managerSql = "SELECT concat(s.fname,' ',s.lname) as fullname, r.name as roleName, s.id as userid
					           FROM $current_table  as q INNER JOIN signin as s ON s.id = q.tl_id 
							   LEFT JOIN role as r ON r.id = s.role_id GROUP BY q.tl_id ORDER BY s.fname,s.lname";
				
			}
			
			$data['managers_list'] = $manager_list = $this->Common_model->get_query_result_array($managerSql);
			
			
			
		    $final_agent_array = "";
			foreach($manager_list as $tokeni)
			{ 
			
				$current_manger_id = $tokeni['userid'];
			    $tl_id_all = NULL;
				$agent_id_all = NULL;
				
				//========= GET NO OF TL
				if(isADLocation($select_office)==false)
				{					
					$tlSql = "SELECT concat(fname,' ',lname) as fullname, (select name from role r where r.id=s.role_id) as roleName, s.id as userid FROM signin as s WHERE assigned_to IN (".$current_manger_id.") AND role_id in (select id from role where folder='tl') AND office_id = '".$select_office."' AND is_assign_client(s.id, '".$select_client."') AND is_assign_process(s.id,'".$select_process."') ORDER BY s.fname,s.lname";
					$data[$current_manger_id]['tl_list'] = $tl_list = $this->Common_model->get_query_result_array($tlSql);
					foreach($tl_list as $token_l){ $tl_id_all[] = $token_l['userid']; }
					$tl_id_array = implode(',',$tl_id_all);
					if($tl_id_array == ""){ $tl_id_array = "-1"; }
					$data['managers'][$current_manger_id]['tl_count'] = count($tl_list);					
				}
				
				
				if(isADLocation($select_office)==true)
				{
					$tl_id_all = NULL;
					$data[$current_manger_id]['tl_list'] = $tl_list = $manager_list;
					foreach($tl_list as $token_l){ $tl_id_all[] = $token_l['userid']; }
					$tl_id_array = implode(',',$tl_id_all);
					if($tl_id_array == ""){ $tl_id_array = "-1"; }	
					$data['managers'][$current_manger_id]['tl_count'] = count($tl_list);
				}
				
				
				//========= GET NO OF AGENTS				
				if(isADLocation($select_office)==false)
				{
					$agentSql	=	"SELECT concat(fname,' ',lname) as fullname, (select name from role r where r.id=s.role_id) as roleName, s.id as userid FROM signin as s WHERE assigned_to IN ($tl_id_array) AND office_id = '".$select_office."' AND is_assign_client(s.id, '".$select_client."') AND is_assign_process(s.id,'".$select_process."') ORDER BY s.fname,s.lname";
					$data[$current_manger_id]['agents_list'] = $agent_list = $this->Common_model->get_query_result_array($agentSql);
					foreach($agent_list as $token_a){ $agent_id_all[] = $token_a['userid']; }
					$agent_id_array = implode(',',$agent_id_all);
					if($agent_id_array != ""){ $all_agent_array[] = $agent_id_array; }
					if($agent_id_array == ""){ $agent_id_array = "-1"; }
					
					$data['managers'][$current_manger_id]['agent_count'] = count($agent_list);
				
				}
				
				if(isADLocation($select_office)==true)
				{
					$agent_id_all = NULL;
					$agentSql = "SELECT concat(s.fname,' ',s.lname) as fullname, r.name as roleName, s.id as userid
					           FROM $current_table as q INNER JOIN signin as s ON s.id = q.agent_id 
							   LEFT JOIN role as r ON r.id = s.role_id WHERE q.tl_id IN ($current_manger_id) GROUP BY q.agent_id  ORDER BY s.fname,s.lname";
					$data[$current_manger_id]['agents_list'] = $agent_list = $this->Common_model->get_query_result_array($agentSql);
					foreach($agent_list as $token_a){ $agent_id_all[] = $token_a['userid']; }
					$agent_id_array = implode(',',$agent_id_all);
					if($agent_id_array != ""){ $all_agent_array[] = $agent_id_array; }
					if($agent_id_array == ""){ $agent_id_array = "-1"; }
					
					$data['managers'][$current_manger_id]['agent_count'] = count($agent_list);
				}
				
				
				// GET AUDIT COMPLETED
				$sqlaudit = "SELECT count(*) as value FROM $current_table WHERE agent_id IN ($agent_id_array) AND (audit_date >= '$start_date' AND audit_date <= '$end_date')";
				$totalaudit = $this->Common_model->get_single_value($sqlaudit);
				
				$data['managers'][$current_manger_id]['audit_count'] = $totalaudit;
				//echo $tl_id_array ."<br/>" .$agent_id_array ."</br><br/><br/>"  .$sqlaudit;
				
				//=================== GET WEEK DATES ====================//
				$data_weeks = $data['week_dates_data'] = $this->getweekCount($search_year, $search_month);
				
				
				// GET WEEK WISE CQ SCORE ---- WEEK 1
				$cqscore_week_1 = "SELECT avg(overall_score) as value from $current_table WHERE (audit_date >= '".$data_weeks[0]['week_start']."' AND audit_date <='".$data_weeks[0]['week_end']."')  AND agent_id IN ($agent_id_array)";
				$cqscore_week_1 = $data['managers'][$current_manger_id]['week_1'] = $this->Common_model->get_single_value($cqscore_week_1);
				
				// GET WEEK WISE CQ SCORE ---- WEEK 2
				$cqscore_week_2 = "SELECT avg(overall_score) as value from $current_table WHERE (audit_date >= '".$data_weeks[1]['week_start']."' AND audit_date <='".$data_weeks[1]['week_end']."')  AND agent_id IN ($agent_id_array)";
				$cqscore_week_2 = $data['managers'][$current_manger_id]['week_2'] = $this->Common_model->get_single_value($cqscore_week_2);
				
				// GET WEEK WISE CQ SCORE ---- WEEK 3
				$cqscore_week_3 = "SELECT avg(overall_score) as value from $current_table WHERE (audit_date >= '".$data_weeks[2]['week_start']."' AND audit_date <='".$data_weeks[2]['week_end']."')  AND agent_id IN ($agent_id_array)";
				$cqscore_week_3 = $data['managers'][$current_manger_id]['week_3'] = $this->Common_model->get_single_value($cqscore_week_3);
				
				// GET WEEK WISE CQ SCORE ---- WEEK 4
				$cqscore_week_4 = "SELECT avg(overall_score) as value from $current_table WHERE (audit_date >= '".$data_weeks[3]['week_start']."' AND audit_date <='".$data_weeks[3]['week_end']."') AND agent_id IN ($agent_id_array)";
				$cqscore_week_4 = $data['managers'][$current_manger_id]['week_4'] = $this->Common_model->get_single_value($cqscore_week_4);
				
			
			}
			
			
			///==================== TENURE SCORE VIEW ========================///
			//AND q.agent_id IN ($final_agent_array) 
			
			$final_agent_array = implode(',',$all_agent_array);
			if($final_agent_array == ""){ $final_agent_array = "-1"; }
			
			//-- 0-30 DAYS TENURE AGENTS
			$sql_agents_30 = "SELECT avg(overall_score) as value from $current_table as q 
			INNER JOIN signin as s ON s.id = q.agent_id
			WHERE (DATEDIFF(CURDATE(), s.doj) >= 0 AND DATEDIFF(CURDATE(), s.doj) <= 30) 
			AND (q.audit_date >= '$start_date' AND q.audit_date <= '$end_date') AND s.office_id = '$select_office'";
			$tenure_30_score = $data['tenure']['0-30'] = $this->Common_model->get_single_value($sql_agents_30);
			
			$sql_agents_60 = "SELECT avg(overall_score) as value from $current_table as q 
			INNER JOIN signin as s ON s.id = q.agent_id
			WHERE (DATEDIFF(CURDATE(), s.doj) >= 31 AND DATEDIFF(CURDATE(), s.doj) <= 60) 
			AND (q.audit_date >= '$start_date' AND q.audit_date <= '$end_date') AND s.office_id = '$select_office'";
			$tenure_60_score = $data['tenure']['31-60'] = $this->Common_model->get_single_value($sql_agents_60);
			
			$sql_agents_60_above = "SELECT avg(overall_score) as value from $current_table as q 
			INNER JOIN signin as s ON s.id = q.agent_id
			WHERE (DATEDIFF(CURDATE(), s.doj) >= 60) 
			AND (q.audit_date >= '$start_date' AND q.audit_date <= '$end_date') AND s.office_id = '$select_office'";
			$tenure_60_score_above = $data['tenure']['above-60'] = $this->Common_model->get_single_value($sql_agents_60_above);
						
			//echo "<pre>" .print_r($data_weeks,true) ."</pre>";die();
			
			
			
			/*$data['total_defect_dc'] = 0;
			///==================== GET DEFECTS TABLE ========================///
			$sql_defect_columns = "SELECT count(*) as countdc, table_name, defect_columns, defect_column_names FROM qa_boomsourcing_defect WHERE FIND_IN_SET(".$select_process.",process_id)";
		    $get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
			$count_dc = $get_defect_columns['countdc'];
			$defect_table = $get_defect_columns['table_name'];
			$defect_column_key = $get_defect_columns['defect_columns'];
			$defect_column_name_key = $get_defect_columns['defect_column_names'];
			*/
			if($count_dc > 0){
				
				$defect_columns_ar = explode(',',$defect_column_key);
				$defect_columns_name_ar = explode(',',$defect_column_name_key);
				//$data['total_defect_dc'] = count($defect_columns_name_ar);
				
				foreach($defect_columns_ar as $each_key=>$each_column)
				{
					$sql_defect_data = "SELECT avg($each_column) as value from $current_table as d WHERE (d.audit_date >= $start_date AND d.audit_date <= $end_date)";
					$sql_defect_data_sum = "SELECT sum($each_column) as value from $current_table as d WHERE (d.audit_date >= $start_date AND d.audit_date <= $end_date)";
					$data['defect_dc'][$each_key]['avgscore'] = $my_avgscore_defect = $this->Common_model->get_single_value($sql_defect_data);
					$data['defect_dc'][$each_key]['sumscore'] = $my_sumscore_defect = $this->Common_model->get_single_value($sql_defect_data_sum);
					$data['defect_dc'][$each_key]['name'] = ucwords($defect_columns_name_ar[$each_key]);
					
					$data['defect_dc_graph']['labels'][] = ucwords($defect_columns_name_ar[$each_key]);
					$data['defect_dc_graph']['data'][] = number_format(round($my_avgscore_defect,2),2);
					$data['defect_dc_graph']['datasum'][] = number_format(round($my_sumscore_defect));
				}	
			
			}
			//echo  implode(',',$data['defect_dc_graph']['labels']);
			//echo "<pre>".print_r($data['defect_dc_graph']['labels'],true)."</pre>";die();
			
			
			
			
			////=========== TOTAL AUDIT =====================/////
			$sql_total_audit   = "SELECT count(*) as value from $current_table as q LEFT JOIN signin as s ON q.agent_id = s.id WHERE (q.audit_date >= '$start_date' AND q.audit_date <= '$end_date') AND s.office_id = '$select_office'";
			$query_total_audit = $this->Common_model->get_single_value($sql_total_audit);
			
			////=========== TOTAL FATAL PERCENTAGE =====================/////
			$sql_fatal   = "SELECT count(*) as value from $current_table as q LEFT JOIN signin as s ON q.agent_id = s.id WHERE q.overall_score = '0' AND (date(q.audit_date) >= '$start_date' AND date(q.audit_date) <= '$end_date')  AND s.office_id = '$select_office'";
			$query_fatal = $this->Common_model->get_single_value($sql_fatal);
			$fatalpercentage = ($query_fatal/$query_total_audit) * 100;
			if($query_total_audit == 0){ $fatalpercentage = 0; }
			
			$data['total_audit'] = $query_total_audit;
			$data['total_fatal'] = round($fatalpercentage);
			
			
			}
			}
			
			$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff", "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_ops_view.php";
							
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	
	
	public function globalview()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			
			// MONTH YEAR SELECTION
			$search_month = $this->input->get('select_month');
			$search_year  = $this->input->get('select_year');
			$select_office   = $this->input->get('select_office');
			$select_client   = $this->input->get('select_client');
			
			if($search_month == ""){ $search_month = date('m'); }
			if($search_year == ""){ $search_year = date('Y'); }
			
			if(($search_month  != "") && ($search_year  != "")){ 
				//$start_date = $search_year ."-" .$search_month ."-" ."01" ." 00:00:00";
				//$end_date   = $search_year ."-" .$search_month ."-" ."31" ." 00:00:00";
				
				$start_date = $search_year ."-" .$search_month ."-" ."01" ."";
				$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year) ."";
				
			}
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;
			
			//echo get_dept_folder() . ">" . get_role_dir();
			
			// OFFICE >> CLIENT >> PROCESS
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if(get_dept_folder()=="operations"){
				$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN (SELECT client_id from info_assign_client where user_id='$current_user') ORDER BY shname";
				$result_client = $this->db->query($sql_client);
				$data['client_list'] = $result_client->result();
			} else {
				$data['client_list'] = $this->Common_model->get_client_list();
			}
			
			
			//============== AFTER SEARCH FILTER
			
			if(($select_office != "") && ($select_client != "") && ($search_month != "") && ($search_year != ""))
			{
				
			$data['selected_office'] = $select_office;
			$data['selected_client'] = $select_client;
			$data['searchfilter'] = "yes";
			
			// PROCESS LIST ARRAY
			$sql_process = "SELECT q.id as pid, q.name as pname from process as q WHERE q.client_id = '$select_client'";
			
			if($select_client == 'allclient')
			{
				$sql_process = "SELECT q.id as pid, q.name as pname from process as q";
			}
			
			$query_process = $data['process_list'] = $this->Common_model->get_query_result_array($sql_process);
			
			
			$sql_process_g = "SELECT distinct(q.process_id) as pid, p.name as pname from v_qa_score as q 
			LEFT JOIN process as p ON p.id = q.process_id 
			LEFT JOIN signin as s ON s.id = q.agent_id
			WHERE (q.audit_date >= $start_date AND q.audit_date <= $end_date) AND s.office_id = 'KOL'";
			//$query_process_g = $data['process_list_g'] = $this->Common_model->get_query_result_array($sql_process_g);
		    
			$count = 0;
			foreach($query_process as $tokenp)
			{
				
				$process_id   = $tokenp['pid'];
				$process_name = $tokenp['pname'];
				
				///==================== GET DEFECTS TABLE ========================///
				$sql_defect_columns = "SELECT count(*) as countdc, table_name, defect_columns, defect_column_names FROM qa_boomsourcing_defect WHERE FIND_IN_SET(".$process_id.",process_id)";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$count_dc = $get_defect_columns['countdc'];
				$defect_table = trim($get_defect_columns['table_name']);
				$defect_column_key = $get_defect_columns['defect_columns'];
				$defect_column_name_key = $get_defect_columns['defect_column_names'];
				
				$data_weeks = $this->getweekCount($search_year, $search_month);
				
				if(!empty($defect_table)){
					
				$count++;
				$data['process'][$count]['info']['id'] = $process_id;
				$data['process'][$count]['info']['name'] = $process_name;
				$data['process'][$count]['info']['client'] = $select_client;
				$data['process'][$count]['info']['office'] = $select_office;

				
				// GET WEEK WISE CQ SCORE ---- WEEK 1
				$cqscore_week_1 = "SELECT avg(overall_score) as value from $defect_table as q LEFT JOIN signin as s ON (s.id = q.agent_id) WHERE (q.audit_date >= '".$data_weeks[0]['week_start']."' AND q.audit_date <='".$data_weeks[0]['week_end']."') AND s.office_id = '".$select_office."'";
				$cqscore_week_1 = $this->Common_model->get_single_value($cqscore_week_1);
				
				// GET WEEK WISE CQ SCORE ---- WEEK 2
				$cqscore_week_2 = "SELECT avg(overall_score) as value from $defect_table as q LEFT JOIN signin as s ON (s.id = q.agent_id) WHERE (q.audit_date >= '".$data_weeks[1]['week_start']."' AND q.audit_date <='".$data_weeks[1]['week_end']."') AND s.office_id = '".$select_office."'";
				$cqscore_week_2 = $this->Common_model->get_single_value($cqscore_week_2);
				
				// GET WEEK WISE CQ SCORE ---- WEEK 3
				$cqscore_week_3 = "SELECT avg(overall_score) as value from $defect_table as q LEFT JOIN signin as s ON (s.id = q.agent_id) WHERE (q.audit_date >= '".$data_weeks[2]['week_start']."' AND q.audit_date <='".$data_weeks[2]['week_end']."') AND s.office_id = '".$select_office."'";
				$cqscore_week_3 = $this->Common_model->get_single_value($cqscore_week_3);
				
				// GET WEEK WISE CQ SCORE ---- WEEK 4
				$cqscore_week_4 = "SELECT avg(overall_score) as value from $defect_table as q LEFT JOIN signin as s ON (s.id = q.agent_id) WHERE (q.audit_date >= '".$data_weeks[3]['week_start']."' AND q.audit_date <='".$data_weeks[3]['week_end']."') AND s.office_id = '".$select_office."'";
				$cqscore_week_4 = $this->Common_model->get_single_value($cqscore_week_4);
				
				// ARRAY WEEK SCORES
				$data['process'][$count]['week'][1] = number_format(round($cqscore_week_1,2));
				$data['process'][$count]['week'][2] = number_format(round($cqscore_week_2,2));
				$data['process'][$count]['week'][3] = number_format(round($cqscore_week_3,2));
				$data['process'][$count]['week'][4] = number_format(round($cqscore_week_4,2));
				
				}
				
			}
			
			$data['process']['total'] = $count;
			$data['colors'][1] = "#cc3300";
			$data['colors'][2] = "#cc6600";
			$data['colors'][3] = "#99cc00";
			$data['colors'][4] = "#0099cc";
			
			
			}
			
			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_global_view.php";
							
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	public function leadview()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			// OFFICE >> CLIENT >> PROCESS
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data['client_list'] = $this->Common_model->get_client_list();
			
			// MONTH YEAR SELECTION
			$search_month = $this->input->get('select_month');
			$search_year  = $this->input->get('select_year');
			$select_process = $this->input->get('select_process');
			$select_office = $this->input->get('select_office');
			
			if($search_month == ""){ $search_month = date('m'); }
			if($search_year == ""){ $search_year = date('Y'); }
			
			if(($search_month  != "") && ($search_year  != "")){ 
				//$start_date = $search_year ."-" .$search_month ."-" ."01" ." 00:00:00";
				//$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year) ." 23:59:59";
				
				$start_date = $search_year ."-" .$search_month ."-" ."01" ."";
				$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year) ."";
			}
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;
			$data['selected_process'] = $select_process;
			$data['selected_office'] = $select_office;
			
			// PROCESS LIST
			//$sql_process_list = "SELECT distinct(process_id) as pid, p.name as pname from v_qa_score as q LEFT JOIN process as p ON p.id = q.process_id";
			//$data['process_list'] = $this->Common_model->get_query_result_array($sql_process_list);
			
			$sql_process_list = "SELECT p.id as pid, p.name as pname from process as p order by pname ASC";
			$data['process_list'] = $this->Common_model->get_query_result_array($sql_process_list);
			
			//============== AFTER SEARCH FILTER
			if(($select_process != "") && ($select_office != "") && ($search_month != "") && ($search_year != ""))
			{
				
			$data['searchfilter'] = "yes";
			
			/*
			// GET QA PRODUCTIVITY
			$sql_productivity = 'SELECT q.entry_by, concat(s.fname, " ", s.lname) as auditor_name, count(entry_by) as audit_no, CAST(AVG(q.overall_score) AS DECIMAL(10,2)) as cq_score FROM v_qa_score as q LEFT JOIN signin as s ON s.id = q.entry_by WHERE q.audit_type="CQ Audit" AND (q.audit_date >= "'.$start_date.'" and q.audit_date <= "'.$end_date.'") AND q.process_id = "'.$select_process.'" AND s.office_id = "'.$select_office.'" GROUP BY auditor_name';
			$data['productivity'] = $result_productivity = $this->Common_model->get_query_result_array($sql_productivity);
			foreach($result_productivity as $tokena)
			{
				$entry_by = $tokena['entry_by'];
				$total_audit = $tokena['audit_no'];
				
				// DAYS PRESENT
				$sqldays = 'SELECT count(DISTINCT(DATE(l.login_time))) as value from logged_in_details as l WHERE l.user_id = "'.$entry_by.'" 
				AND (DATE(l.login_time)>="'.$start_date.'" AND DATE(l.logout_time)<="'.$end_date.'")';
				$data['auditor'][$entry_by]['dayslogin'] = $this->Common_model->get_single_value($sqldays);
				
				// GET FATAL PERCENTAGE
				$sqlfatal = 'SELECT count(*) as value from v_qa_score WHERE entry_by = "'.$entry_by.'" AND overall_score = 0 AND (audit_date >= "'.$start_date.'" and audit_date <= "'.$end_date.'")  AND process_id = "'.$select_process.'"';
				$totalfatal = $this->Common_model->get_single_value($sqlfatal);
				
				// GET TOTAL CALL DUARATION
				//$sqltotalcall = 'SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(call_duration))) as value FROM '.$get_table.' as q WHERE entry_by = "'.$entry_by.'"  AND (q.audit_date >= "'.$start_date.'" and q.audit_date <= "'.$end_date.'")';
				//$totalcallduration = $this->Common_model->get_single_value($sqltotalcall);				
				//$totalcalld =  explode('.',$totalcallduration);
				
				// GET TOTAL LOGIN DUARATION
				$sqltotallogin = 'SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(logout_time,login_time)))) as value FROM logged_in_details  as s WHERE s.user_id = "'.$entry_by.'"  AND (s.login_time >= "'.$start_date.'" AND s.logout_time <= "'.$end_date.'") AND s.logout_time > s.login_time';
				$totalloginduration = $this->Common_model->get_single_value($sqltotallogin);
				
				
				$fatalpercent = (round($totalfatal)/round($total_audit)) * 100;
				$data['auditor'][$entry_by]['fatalpercent'] = round($fatalpercent,2);
				$data['auditor'][$entry_by]['totalfatal'] = round($totalfatal);
				$data['auditor'][$entry_by]['totalaudit'] = round($total_audit);
				$data['auditor'][$entry_by]['callduration'] = $totalcalld[0];
				$data['auditor'][$entry_by]['loginduration'] = $totalloginduration;
				
				
			}
			*/
			
			
			
			
			//------------ FROM DEFECT TABLES DATA ----------------------------
			// GET TABLE DETAILS FROM PROCESS			
			$sql_defect_columns = "SELECT count(*) as countdc, table_name, defect_columns, defect_column_names FROM qa_boomsourcing_defect WHERE FIND_IN_SET(".$select_process.",process_id)";
			$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
			$count_dc = $get_defect_columns['countdc'];
			$defect_table = trim($get_defect_columns['table_name']);
			$defect_column_key = $get_defect_columns['defect_columns'];
			$defect_column_name_key = $get_defect_columns['defect_column_names'];
			
			$get_table = $defect_table;
			if(!empty($get_table)){
			// GET QA PRODUCTIVITY
			$sql_productivity = 'SELECT q.entry_by, concat(s.fname, " ", s.lname) as auditor_name, count(entry_by) as audit_no, CAST(AVG(q.overall_score) AS DECIMAL(10,2)) as cq_score FROM '.$get_table.' as q LEFT JOIN signin as s ON s.id = q.entry_by WHERE (q.audit_date >= "'.$start_date.'" and q.audit_date <= "'.$end_date.'") AND s.office_id = "'.$select_office.'" GROUP BY auditor_name';
			$data['productivity'] = $result_productivity = $this->Common_model->get_query_result_array($sql_productivity);
			foreach($result_productivity as $tokena)
			{
				$entry_by = $tokena['entry_by'];
				$total_audit = $tokena['audit_no'];
				
				// DAYS PRESENT
				$sqldays = 'SELECT count(user_id) as value from logged_in_details WHERE logged_in_details.user_id = "'.$entry_by.'" 
				AND (login_time>="'.$start_date.'" AND login_time<="'.$end_date.'")';
				$data['auditor'][$entry_by]['dayslogin'] = $this->Common_model->get_single_value($sqldays);
				
				// GET FATAL PERCENTAGE
				$sqlfatal = 'SELECT count(*) as value from '.$get_table.' WHERE entry_by = "'.$entry_by.'" AND overall_score = 0 AND (audit_date >= "'.$start_date.'" and audit_date <= "'.$end_date.'")';
				$totalfatal = $this->Common_model->get_single_value($sqlfatal);
				
				// GET TOTAL CALL DUARATION
				//$sqltotalcall = 'SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(call_duration))) as value FROM '.$get_table.' as q WHERE entry_by = "'.$entry_by.'"  AND (q.audit_date >= "'.$start_date.'" and q.audit_date <= "'.$end_date.'")';
				//$totalcallduration = $this->Common_model->get_single_value($sqltotalcall);				
				//$totalcalld =  explode('.',$totalcallduration);
				
				// GET TOTAL LOGIN DUARATION
				$sqltotallogin = 'SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(logout_time) - TIME_TO_SEC(login_time))) as value FROM logged_in_details  as s WHERE s.user_id = "'.$entry_by.'"  AND (s.login_time >= "'.$start_date.'" AND s.logout_time <= "'.$end_date.'") AND s.logout_time > s.login_time';
				$totalloginduration = $this->Common_model->get_single_value($sqltotallogin);
				
				
				$fatalpercent = (round($totalfatal)/round($total_audit)) * 100;
				$data['auditor'][$entry_by]['fatalpercent'] = round($fatalpercent,2);
				$data['auditor'][$entry_by]['totalfatal'] = round($totalfatal);
				$data['auditor'][$entry_by]['totalaudit'] = round($total_audit);
				$data['auditor'][$entry_by]['callduration'] = $totalcalld[0];
				$data['auditor'][$entry_by]['loginduration'] = $totalloginduration;
				
				
			}
			
			//$defects = $this->get_productivity_audit($row->table_name,$start_date,$end_date);
			//------------------------- ENDS -------------------------------
			
			
			}
			}
			
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_lead_view.php";
							
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	
	private function get_productivity_audit($table,$from_date,$to_date)
	{
		
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$f_date = $from_date;
		$t_date = $to_date;
		
		/*$sql_productivity = 'SELECT entry_by, 
		(SELECT concat(fname, " ", lname) as name from signin where signin.id=entry_by) as auditor_name, 
		count(entry_by) as audit_no, 
		CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score, 
		(SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(logout_time) - TIME_TO_SEC(login_time))) AS timediff from logged_in_details 
		WHERE logged_in_details.user_id = entry_by and (date(login_time)>="'.$f_date.'" and date(login_time)<="'.$t_date.'")) as total_login_time, 
		(SELECT count(user_id) as cnt_user from logged_in_details where logged_in_details.user_id = entry_by 
		AND (date(login_time)>="'.$f_date.'" and date(login_time)<="'.$t_date.'")) as days_present
		FROM '.$table.' 
		LEFT JOIN signin ON signin.id=entry_by WHERE audit_type="CQ Audit" 
		AND (date(audit_date) >= "'.$f_date.'" and date(audit_date) <= "'.$t_date.'") GROUP BY auditor_name';*/
		
		$sql_productivity = 'SELECT entry_by, concat(s.fname, " ", s.lname) as auditor_name, 
		count(entry_by) as audit_no, 
		CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score
		FROM '.$table.' as q
		LEFT JOIN signin as s ON s.id = q.entry_by 
		WHERE q.audit_type="CQ Audit" 
		AND (CAST(audit_date as CHAR(10)) >= "'.$f_date.'" and CAST(audit_date as CHAR(10)) <= "'.$t_date.'")
		GROUP BY auditor_name';
		$query = $this->db->query($sql_productivity);
		$response = array();
		if($query)
		{
			$defect_rows = $query->result_object();			
			$response['stat'] = true;
			$response['datas'] = $defect_rows;
			
		}else{
			$response['stat'] = false;
		}
		return $response;
	}
	
	
	public function get_productivity_scores($process_id, $from_date, $to_date)
	{		
		$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names,process.name as process_name FROM `qa_boomsourcing_defect` LEFT JOIN process ON process.id='.$process_id.' WHERE FIND_IN_SET('.$process_id.',process_id)');
		$row = $query->row();
		
		$defects = $this->get_product($row->table_name,$from_date,$to_date);
		
		$response = array();
		if($defects['stat'] == true)
		{
			$response['stat'] = true;
			
			$response['datas']['defects'] = $defects['datas'];
			
		}
		echo json_encode($response);
	}
	
	
	
/////////============= CALCULATE AVG CSAT SCORE PROCESS WISE  ==========================///////////////////////////////////

	private function get_avg_csat_process_score($table,$process_name,$location,$start_date,$end_date)
	{
	
		// office_id="'.$location.'" AND  
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$csat_4_5 = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where voc in (4,5) and process_name="'.$process_name.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
			$tot_audit = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where process_name="'.$process_name.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
		}else{
			$csat_4_5 = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id from '.$table.' LEFT JOIN signin ON signin.id=agent_id where office_id="'.$location.'" AND  voc in (4,5) AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
			$tot_audit = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id from '.$table.' LEFT JOIN signin ON signin.id=agent_id where office_id="'.$location.'" AND  (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
		}	
		if($tot_audit > 0){
			$csat_scr = ($csat_4_5 / $tot_audit) * 100;
		}else{
			$csat_scr=0;
		}
		
		if($csat_scr > 0){
			$response['datas'] = $csat_scr;
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	// VIEW BASED DATA
	private function get_avg_csat_process_score_view_based($process_id,$location,$start_date,$end_date)
	{
		
		$extra_filter = "";
		if(get_dept_folder()=="operations"){
			
			$user_client_ids = get_client_ids();
			$user_process_ids = get_process_ids();
			$extra_filter .= " AND client_id IN ($user_client_ids) ";
			$extra_filter .= " AND process_id IN ($user_process_ids) ";
		
		}
		
		// office_id="'.$location.'" AND  
		$csat_4_5_sql = 'Select count(*) as value from v_qa_score where voc in (4,5) and process_id="'.$process_id.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")' .$extra_filter;
		$csat_4_5 = $this->Common_model->get_single_value($csat_4_5_sql);
		
		$csat_1_2_sql = 'Select count(*) as value from v_qa_score where voc in (1,2) and process_id="'.$process_id.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")' .$extra_filter;
		$csat_1_2 = $this->Common_model->get_single_value($csat_1_2_sql);
		
		$tot_audit_sql = 'Select count(*) as value from v_qa_score where process_id="'.$process_id.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")' .$extra_filter;
		$tot_audit = $this->Common_model->get_single_value($tot_audit_sql);
		
		if($tot_audit > 0){
			$csat_scr = ($csat_4_5 / $tot_audit) * 100;
		}else{
			$csat_scr=0;
		}
		
		if($csat_scr > 0){
			$response['datas'] = $csat_scr;
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}

//==================================== CSAT - NPS SCORE ===========================================//

	private function get_qa_boomsourcing_defect_csat_score($table,$from_date,$to_date,$off_id = '',$m_id='',$tl_id='',$agent_id=''){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id IN ('$off_id')";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to IN ($m_id) OR s.assigned_to in (SELECT id FROM signin where assigned_to IN ($m_id)))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to IN ($tl_id)";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id IN ($agent_id)";
		
		$voc_4_5 = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and voc in (4,5) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		$tot_audit = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id  where audit_type in ('CQ Audit', 'BQ Audit') and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		if($tot_audit!=0){
			return $csat_percent = number_format(($voc_4_5*100)/$tot_audit, 2);
		}else{
			return $csat_percent = 0;
		}	 
	}
	
	private function get_qa_boomsourcing_defect_nps_score($table,$from_date,$to_date,$off_id='',$m_id='',$tl_id='',$agent_id=''){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id IN ('$off_id')";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to IN ($m_id) OR s.assigned_to in (SELECT id FROM signin where assigned_to IN ($m_id)))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to IN ($tl_id)";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id IN ($agent_id)";
		
		$voc_4_5 = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and voc in (4,5) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		$voc_1_2 = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and voc in (1,2) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		$tot_audit = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id  where audit_type in ('CQ Audit', 'BQ Audit') and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		if($tot_audit!=0 || $voc_4_5!=0 || $voc_1_2!=0){
			return $nps_percent = number_format((($voc_4_5/$tot_audit)*100)/($voc_1_2/$tot_audit), 2);
		}else{
			return $nps_percent = 0;
		} 
	}
	
	
	
	
/////////============= CALCULATE AVG NPS SCORE PROCESS WISE  ==========================///////////////////////////////////

	private function get_avg_nps_process_score($table,$process_name,$location,$start_date,$end_date)
	{
		//office_id="'.$location.'" AND 
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$csat_4_5 = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where voc in (4,5) and process_name="'.$process_name.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'") ');
			$csat_1_2 = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where voc in (1,2) and process_name="'.$process_name.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
			$tot_audit = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where process_name="'.$process_name.'" AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
		}else{	
			$csat_4_5 = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND  voc in (4,5) AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
			$csat_1_2 = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id FROM '.$table.'  LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND  voc in (1,2) AND (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
			$tot_audit = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND  (CAST(audit_date as CHAR(10)) >= "'.$start_date.'" AND CAST(audit_date as CHAR(10)) <= "'.$end_date.'")');
		}
		
		if($tot_audit>0){	
			$nps_scr = (($csat_4_5 - $csat_1_2) / $tot_audit) * 100;
		}else{
			$nps_scr=0;
		}
		
		if($nps_scr > 0){
			$response['datas'] = $nps_scr;
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	// VIEW BASED DATA
	private function get_avg_nps_process_score_view_based($process_id,$location,$start_date,$end_date)
	{
		
		$extra_filter = "";
		if(get_dept_folder()=="operations"){
			
			$user_client_ids = get_client_ids();
			$user_process_ids = get_process_ids();
			$extra_filter .= " AND client_id IN ($user_client_ids) ";
			$extra_filter .= " AND process_id IN ($user_process_ids) ";
		
		}
		
		//office_id="'.$location.'" AND 
		
		$csat_4_5_sql = 'Select count(*) as value from v_qa_score where voc in (4,5) and process_id="'.$process_id.'" AND (audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'")' .$extra_filter;
		$csat_4_5 = $this->Common_model->get_single_value($csat_4_5_sql);
		
		$csat_1_2_sql = 'Select count(*) as value from v_qa_score where voc in (1,2) and process_id="'.$process_id.'" AND (audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'")' .$extra_filter;
		$csat_1_2 = $this->Common_model->get_single_value($csat_1_2_sql);
		
		$tot_audit_sql = 'Select count(*) as value from v_qa_score where process_id="'.$process_id.'" AND (audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'")' .$extra_filter;
		$tot_audit = $this->Common_model->get_single_value($tot_audit_sql);
		
		if($tot_audit>0){	
			$nps_scr = (($csat_4_5 - $csat_1_2) / $tot_audit) * 100;
		}else{
			$nps_scr=0;
		}
		
		if($nps_scr > 0){
			$response['datas'] = $nps_scr;
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	
	private function getWeekDates($date, $start_date, $end_date)
	{
		$week =  date('W', strtotime($date));
		$year =  date('Y', strtotime($date));
		$from = date("Y-m-d", strtotime("{$year}-W{$week}+1"));
		if($from < $start_date) $from = $start_date;

		$to = date("Y-m-d", strtotime("{$year}-W{$week}-6")); 
		if($to > $end_date) $to = $end_date;

		$array1 = array(
				"week_start" => $from,
				"week_end" => $to,
		);
		return $array1;
	}


	private function getweekCount($yy, $mm)
	{
		$ld = cal_days_in_month(CAL_GREGORIAN, $mm, $yy);
		$startdate    = date($yy."-".$mm."-01") ;
		$current_date = date('Y-m-d');
		$lastday =$yy.'-'.$mm.'-'.$ld;
		
		$start_date = date('Y-m-d', strtotime($startdate));
		$end_date = date('Y-m-d', strtotime($lastday));
		$end_date1 = date('Y-m-d', strtotime($lastday." + 6 days"));
		$count_week=0;
		$week_array = array();

		for($date = $start_date; $date <= $end_date1; $date = date('Y-m-d', strtotime($date. ' + 7 days')))
		{
			$getarray=$this->getWeekDates($date, $start_date, $end_date);
			if(($getarray['week_start'] >= $startdate) && ($getarray['week_end'] >= $startdate)){
			$week_array[]=$getarray;
			}
			$count_week++;

		}
		
		return $week_array;
	}
	
	//==========================================================================================//
	//            QA SET TARGET 
	//==========================================================================================//
	
	public function set_target()
	{
		if(check_logged_in())
		{
			//$this->output->enable_profiler(TRUE);
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$officeSearch = $user_office_id;
			$clientSearch = "";
			$processSearch = "";
			$monthSearch = date('m', strtotime(CurrMysqlDate()));
			$yearSearch = date('Y', strtotime(CurrMysqlDate()));
			$data['selected_month'] = $monthSearch;
			$data['selected_year'] = $yearSearch;
			$data['selected_office'] = $officeSearch;
			$data['selected_client'] = $clientSearch;
			$data['selected_process'] = $processSearch;
			
			// OFFICE >> CLIENT >> PROCESS
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if(get_dept_folder()=="operations"){
				$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN (SELECT client_id from info_assign_client where user_id='$current_user') ORDER BY shname";
				$result_client = $this->Common_model->get_query_result_array($sql_client);
				$data['client_list'] = $result_client;
			} else {
				$sql_client = "SELECT * FROM client WHERE is_active=1 ORDER BY shname";
				$result_client = $this->Common_model->get_query_result_array($sql_client);
				$data['client_list'] = $result_client;
			}
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_monthly_target.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_target_js.php";
							
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	public function view_target()
	{
		if(check_logged_in())
		{
			//$this->output->enable_profiler(TRUE);
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			// OFFICE >> CLIENT >> PROCESS
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if(get_dept_folder()=="operations"){
				$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN (SELECT client_id from info_assign_client where user_id='$current_user') ORDER BY shname";
				$result_client = $this->Common_model->get_query_result_array($sql_client);
				$data['client_list'] = $result_client;
			} else {
				$sql_client = "SELECT * FROM client WHERE is_active=1 ORDER BY shname";
				$result_client = $this->Common_model->get_query_result_array($sql_client);
				$data['client_list'] = $result_client;
			}
			
			$monthSearch = date('m', strtotime(CurrMysqlDate()));
			$yearSearch = date('Y', strtotime(CurrMysqlDate()));
			$officeSearch = $user_office_id;
			$clientSearch = "";
			$processSearch = "";
			
			if(!empty($this->input->get('select_month')))
			{
				$monthSearch = $this->input->get('select_month');
				$yearSearch = $this->input->get('select_year');
				$clientSearch = $this->input->get('select_client');
				$processSearch = $this->input->get('select_process');
			}
			
			$extraFilter = "";
			if(!empty($clientSearch) && $clientSearch!= "ALL")
			{
				$extraFilter .= " AND q.client_id = '$clientSearch'";
			}
			if(!empty($processSearch) && $processSearch!= "ALL")
			{
				$extraFilter .= " AND q.process_id = '$processSearch'";
			}
			
			$sqlData = "SELECT q.*, c.shname as client_name, p.name as process_name, CONCAT(s.fname, ' ', s.lname) as fullname
               			from target_qa_score as q 
						LEFT JOIN process as p ON p.id = q.process_id
						LEFT JOIN client as c ON c.id = q.client_id
						LEFT JOIN signin as s ON s.id = q.updated_by
			            WHERE q.month = '$monthSearch' AND q.year = '$yearSearch' AND q.office_id = '$officeSearch' $extraFilter";
			$queryData = $this->Common_model->get_query_result_array($sqlData);
			
			$data['selected_month'] = $monthSearch;
			$data['selected_year'] = $yearSearch;
			$data['selected_client'] = $clientSearch;
			$data['selected_process'] = $processSearch;
			$data['selected_office'] = $officeSearch;
			$data['searchData'] = $queryData;
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_graph_boomsourcing/qa_monthly_target_list.php";
			$data["content_js"] = "Qa_graph_boomsourcing/qa_target_js.php";
							
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	public function upload_target_score()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			
			$outputFile = FCPATH ."uploads/Qa_graph_boomsourcing/";
			$config = [
				'upload_path'   => $outputFile,
				'allowed_types' => 'xls|xlsx',
				'max_size' => '1024000',
			];
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->overwrite = true;
			if (!$this->upload->do_upload('userfile'))
			{
				redirect(base_url().'Qa_graph_boomsourcing/set_target/upload/error');
			}
			
			$upload_data = $this->upload->data();
			$file_name = $outputFile .$upload_data['file_name'];
			
			$this->load->library('excel');
			$inputFileType = PHPExcel_IOFactory::identify($file_name);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$monthArray = array();
			for($j=1; $j <= 12; $j++)
			{
				$checkDate = "2020-".sprintf('%02d', $j)."-01";
				$monthName = date('F', strtotime($checkDate));
				$monthArray[strtolower($monthName)] = sprintf('%02d', $j);
			}
			
			$_flag = true;
			$this->db->trans_begin();
			
			$objPHPExcel = $objReader->load($file_name);
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
			{
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow();					
				$highestColumn      = $worksheet->getHighestColumn();					
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$sheetData = $worksheet->toArray(null,true,true,true);
				
				//echo "<pre>".print_r($monthArray, 1)."</pre>";
				//echo "<pre>".print_r($sheetData, 1)."</pre>";
				//die();
				
				$totalData = count($sheetData);
				for($i=3; $i<$totalData; $i++)
				{
					$currentDataSet = $sheetData[$i];
					
					$_office_id = $currentDataSet['B'];
					$_client_name = $currentDataSet['C'];
					$_process_name = $currentDataSet['D'];
					$_process_id = $currentDataSet['E'];
					$_month = $currentDataSet['F'];
					$_year = $currentDataSet['G'];
					$_score = $currentDataSet['H'];
					
					if(!empty($monthArray[strtolower($_month)]))
					{						
						$e_month = $monthArray[strtolower($_month)];
						
						$_var_process_id = substr($_process_id, 1);
						$_sub_process_id = explode('D', $_var_process_id);
						$_process_id = round($_sub_process_id[0]);
						if(!empty($_sub_process_id[1])){ $_process_id .= "." .round($_sub_process_id[1]); }
						
						$sqlProcess = "SELECT client_id as value from process WHERE id = '$_process_id' AND is_active = '1'";
						$_client_id = $this->Common_model->get_single_value($sqlProcess);
						if(empty($_client_id))
						{
							$sqlProcess = "SELECT client_id as value from qa_boomsourcing_defect WHERE process_id = '$_process_id'";
							$_client_id = $this->Common_model->get_single_value($sqlProcess);
						}
						if(!empty($_client_id))
						{
							$sqlCheck = "SELECT * from target_qa_score WHERE process_id = '$_process_id' AND client_id = '$_client_id' AND month = '$e_month' AND year = '$_year' ORDER by id DESC LIMIT 1";
							$queryCheck = $this->Common_model->get_query_row_array($sqlCheck);
							
								$_flag = true;
								if(!empty($queryCheck['process_id']))
								{
									$updtaeArray = [									
										"target_score"  => $_score, 
										"updated_by" 	=> $current_user, 
										"date_modified" => CurrMysqlDate()
									];
									$this->db->where('office_id', $_office_id);
									$this->db->where('client_id', $_client_id);
									$this->db->where('process_id', $_process_id);
									$this->db->where('month', $e_month);
									$this->db->where('year', $_year);
									$this->db->update('target_qa_score', $updtaeArray);
									
								} else {									
								
								if(!empty($_score))
								{
									$dataArray = [
										"office_id" 	=> $_office_id, 
										"client_id" 	=> $_client_id, 
										"process_id" 	=> $_process_id, 
										"month" 		=> $e_month, 
										"year" 			=> $_year, 
										"target_score"  => $_score, 
										"updated_by" 	=> $current_user, 
										"date_modified" => CurrMysqlDate(), 
										"added_by" 		=> $current_user, 
										"date_added" 	=> CurrMysqlDate(), 
										"is_active" 	=> 1, 
										"logs" 			=> get_logs()
									];
									data_inserter('target_qa_score', $dataArray);
								}	
									
								}
							
						} else {
							$_flag = false;
							$this->db->trans_rollback();
							redirect(base_url().'Qa_graph_boomsourcing/set_target/found/errordb');
						}
					} else {
						$_flag = false;
						$this->db->trans_rollback();
						redirect(base_url().'Qa_graph_boomsourcing/set_target/found/errormonth');
					}				
				}
				
				$this->db->trans_complete();				
			}
			
			if($_flag == false){ redirect(base_url().'Qa_graph_boomsourcing/set_target/found/errorfinal'); }
			redirect(base_url().'Qa_graph_boomsourcing/set_target');
		}
	}
	
	
	public function download_target_score_sample()
	{
		if(check_logged_in())
		{
			//$this->output->enable_profiler(TRUE);
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			
			$title = "Target Score";
			$sheet_title = "Target Score";
			$file_name = "Target_Score";
			
			$extraFilter = "";
			$extraDataFilter = "";
			$select_month = date('m', strtotime(CurrMysqlDate()));
			
			// SEARCH DATA
			$select_client = $this->input->post('select_client');
			$select_process = $this->input->post('select_process');
			$select_office = $this->input->post('select_office');
			$select_month = $this->input->post('select_month');
			$select_year = $this->input->post('select_year');
			
			$current_month = date('F', strtotime(CurrMysqlDate()));
			$current_year = date('Y', strtotime(CurrMysqlDate()));
			if(!empty($select_month)){ 
				$current_month = date('F', strtotime("2020-".$select_month."-01")); 
				$extraDataFilter .= " AND q.month = '$select_month'";
			}
			if(!empty($select_year)){ 
				$current_year = $select_year;
				$extraDataFilter .= " AND q.year = '$select_year'";			
			}
			if(!empty($select_office)){ 
				$extraDataFilter .= " AND q.office_id = '$select_office'";			
			}
			if(!empty($select_office)){ $user_office_id = $select_office; }
			
			if(!empty($select_client) && $select_client != "ALL")
			{
				$extraFilter .= " AND p.client_id = '$select_client'";
				$extraDataFilter .= " AND q.client_id = '$select_client'";
			}
			if(!empty($select_process) && $select_process != "ALL")
			{
				$extraFilter .= " AND FLOOR(p.id) = '$select_process'";
				$extraDataFilter = " AND FLOOR(q.process_id) = '$select_process'";
			}
					
			$this->objPHPExcel = new PHPExcel();
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle($title);
			
			$objWorksheet->setShowGridlines(true);
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objWorksheet->getColumnDimension('A')->setAutoSize(true);
			$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
			$objWorksheet->getColumnDimension('C')->setAutoSize(true); 
			$objWorksheet->getColumnDimension('D')->setAutoSize(true);
			$objWorksheet->getColumnDimension('E')->setAutoSize(true);
			$objWorksheet->getColumnDimension('F')->setWidth(20);
			$objWorksheet->getColumnDimension('G')->setWidth(20);
			$objWorksheet->getColumnDimension('H')->setWidth(20);
			
			
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14
			));
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1'); 
			$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $sheet_title);
			$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			$boldArray = array( 'font'  => array( 'bold'  => true, 'size'  => 12 ));
			$whiteArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
				'size'  => 10
			));
			$this->objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($whiteArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');			
					
			$i=0;		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Sl");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Client");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Process");		
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Process Code");	
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Month");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Year");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Target");
			
			// TARGET
			$dataArray = array();
			$sqlTarget = "SELECT q.* from target_qa_score as q WHERE 1 $extraDataFilter";
			$queryTarget = $this->Common_model->get_query_result_array($sqlTarget);
			foreach($queryTarget as $token)
			{
				$monthID = $token['month'];
				$yearID = $token['year'];
				$processID = $token['process_id'];
				$clientID = $token['client_id'];
				$officeID = $token['office_id'];
				$dataArray[$monthID][$yearID][$officeID][$clientID][$processID] = $token['target_score'];
			}
			
			$sqlProcess = "SELECT p.name as process_name, p.id as process_id, c.shname as client_name FROM process as p LEFT JOIN client as c ON c.id = p.client_id WHERE p.is_active = '1' $extraFilter AND p.client_id <> 0 ORDER BY p.name ASC";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
			
			$sqlDefectProcess = "SELECT CASE 
			                    WHEN ip.name <> '' OR ip.name IS NOT NULL THEN ip.name 
								ELSE REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' ') 
			                    END as process_name,
			                    p.process_id as process_id, c.shname as client_name FROM qa_boomsourcing_defect as p 
			                    LEFT JOIN client as c ON c.id = p.client_id 
								LEFT JOIN process as ip ON ip.id = process_id
								WHERE p.is_active = '1' $extraFilter AND p.client_id <> 0";
			$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);
			
			$mergeArray = array_merge($queryProcess,$queryDefectProcess);
			$finalProcess = array_unique($mergeArray, SORT_REGULAR);
			array_multisort( array_column( $finalProcess, 'client_name' ), SORT_ASC, $finalProcess );
			$sl=0;		
			$i=1;
			foreach($finalProcess as $wk=>$wv)
			{				
				$j = 0; $currRow = $i+2;
				$processCode = "P".sprintf('%04d', $wv["process_id"]);
				$subDecimal = explode('.', $wv["process_id"]);
				if(!empty($subDecimal[1])){ $processCode .= "D" .sprintf('%03d', $subDecimal[1]); }
				
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, ++$sl);
				$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, $user_office_id);
				$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, $wv['client_name']);			
				$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, $wv["process_name"]);
				$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, $processCode);
				$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, $current_month);
				$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, $current_year);
								
				// SEARCH FOR DATA
				$targetScore = 0; $_clientID = $wv['client_id']; $_processID = $wv['process_id'];
				if(!empty($dataArray[$select_month][$current_year][$user_office_id][$_clientID][$_processID]))
				{
					$targetScore = $dataArray[$select_month][$current_year][$user_office_id][$_clientID][$_processID];
					$this->objPHPExcel->getActiveSheet()->getStyle('H'.$currRow)->applyFromArray($boldArray);
				}				
				$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$currRow, $targetScore);
				
				$i++;				
			}
			
			$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
			$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
			
			$higlightStyle = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array('rgb' => 'ececec')
				),
				'alignment' => array(
					'wrap' => true
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => 'AAAAAA')
					)
				)
			);

			//$this->objPHPExcel->getActiveSheet()->getStyle('A3:E'.$highestRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDD7C9');
			$this->objPHPExcel->getActiveSheet()->getStyle('A3:E'.$highestRow)->applyFromArray($higlightStyle);
			
			$this->objPHPExcel->getActiveSheet()->getStyle('A3:A'.$highestRow)->applyFromArray($whiteArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A2:A'.$highestRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
			
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
	
	
	
	public function select_process(){
		$set_array = array ();
		if(check_logged_in())
		{
			$client_id = $this->input->get('client_id');

			$SQLtxt = "SELECT id,name FROM process where client_id in ($client_id)  AND id NOT IN ('304') order by name";
			if(get_login_type() == 'client'){
				$my_client_ids = !empty(get_clients_client_id()) ? get_clients_client_id() : -1;
				$my_process_ids = !empty(get_clients_process_id()) ? get_clients_process_id() : -1;
				$SQLtxt = "SELECT id,name FROM process where client_id in ($client_id) AND client_id IN ($my_client_ids) AND id IN ($my_process_ids) order by name";
			}			
			
			$fields = $this->db->query($SQLtxt);			
			$process_data =  $fields->result_array();			  
			echo  json_encode($process_data);
			 
		}
	}
	
	public function select_campaign(){
		$set_array = array ();
		if(check_logged_in())
		{
			$client_id = $this->input->get('client_id');
			
			$extraFilter = "";
			if(!empty($client_id) && $client_id != 'ALL'){
				$extraFilter = " AND client_id in ($client_id)";
			}
			
			$SQLtxt = "SELECT process_id as id, REPLACE(REPLACE(REPLACE(table_name, 'qa_',''), '_feedback', ''), '_', ' ') as name FROM qa_boomsourcing_defect where 1 $extraFilter  AND process_id NOT IN ('304') order by name";
			
			if(get_login_type() == 'client'){
				$my_client_ids = !empty(get_clients_client_id()) ? get_clients_client_id() : -1;
				$my_process_ids = !empty(get_clients_process_id()) ? get_clients_process_id() : -1;
				$SQLtxt = "SELECT process_id as id, REPLACE(table_name, 'qa_','') as name FROM qa_boomsourcing_defect where 1  AND client_id IN ($my_client_ids) AND FLOOR(process_id) IN ($my_process_ids) $extraFilter order by name";
			}
						
			$fields = $this->db->query($SQLtxt);			
			$process_data =  $fields->result_array();			  
			echo  json_encode($process_data);
			 
		}
	}
	
	
	private function array_indexed($dataArray = NULL, $column = "")
	{
		$result = array();
		if(!empty($dataArray) && !empty($column))
		{
			$arrOne = array_column($dataArray, $column);
			$arrTwo = $dataArray;
			$result = array_combine($arrOne, $arrTwo);
		}		
		return $result;
	}
	
	
	
	public function custom_error_parameters($process = ''){		
		$error['oyous']['yes'] = array('was_opening_correct','agent_ask_further_assistance','was_closure_correct','display_active_listening','agent_relevant_probing','agent_provide_correct_tariff','start_lowest_discount','offer_alternate_property','pitch_additional_night','create_call_urgency','give_property_details','agent_check_lifeline','check_with_PM','agent_summarize_call','pitch_for_on_call','was_tagging_correct','agent_adhere_to_SOP','capture_correct_information','agent_give_mandatory_info','create_correct_booking','acknowlegde_the_concern','agent_polite_on_call','show_emphaty_when_required','take_customer_name_twice','follow_hold_procedure','energetic_through_call');		
		$error['oyous']['no'] = array('delayed_opening','grammatical_error','MTI_observed_call','agent_provide_incorrect_info','ZTP_call_observe','any_dead_air_on_call');
		
		$result_array = $error['oyous'];
		if($process == '171' || $process == '181'){
			$result_array = $error['oyous'];
		}
		return $result_array;
	}
	
	
	public function custom_error_fatal_parameters($process = ''){		
		$result[base64_encode(245.1)]['nonfatal'] = array('opening','validateinfo','acknowledge','effectiveprobing','managedelay','provideselfhelp','correctspelling','closingstatement','professionalism');		
		$result[base64_encode(245.1)]['fatal'] = array('accurateresolution','leveragesystem','accurateowenship','crmaccuracy');
		
		$result[base64_encode(187)]['nonfatal'] = array('call_opening','identification','security_check','hold_procedure','closing_script','active_listening','effective_probing','apology_empathy','enthusiasm','fluency_structure','mentorship_pitch','addition_info');		
		$result[base64_encode(187)]['fatal'] = array('accurate_resolution_process','politeness_courtesy','crm_accuracy');
		
		$result[base64_encode(204)]['nonfatal'] = array('oprning_personalization','validation_customer_info','acknowledge_align_assure','effective_probing','manage_delay_grace','provide_self_help','used_correct_spelling','closing_statement','agent_write_brand_voice');		
		$result[base64_encode(204)]['fatal'] = array('accurate_resolution','used_template_correctly','used_necessary_custom','crm_accuracy');
		
		$result_array = !empty($result[$process]) ? $result[$process] : "";
		return $result_array;
	}
	
	
	
	public function accessClientIds(){
		$result = "1";
		return $result;
	}
	
}


