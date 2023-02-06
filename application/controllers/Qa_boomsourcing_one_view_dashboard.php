<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Qa_boomsourcing_one_view_dashboard extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();
		//error_reporting(1); 
		//ini_set('display_errors', 1);
		//$this->db->db_debug=true;
		$getExcluded_Audits = array('Calibration', 'Certificate Audit', 'OJT');
	}

	//==========================================================================================//
	//            DEFECT LEVEL
	//==========================================================================================//
	
	public function one_view_dashboard(){
		if(check_logged_in()){
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$my_client_ids = 275;
			//$my_client_ids = $this->accessClientIds();

			$currentDate = date('Y-m-d');
			
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
			$search_office[] = $user_office_id;
			$offCondi="";
			if(!empty($this->input->get('select_office'))){ 					
				$search_office = $this->input->get('select_office');
				if(in_array('ALL',$search_office,TRUE)){
					$office_str="";
				}else{
					$office_str=implode("','",$search_office);
					$offCondi .=' and s.office_id in ("'.$office_str.'")';
				}
			}

			// if($ofc_id!=""){
			// 	if (in_array("ALL",$ofc_id, TRUE)){
			// 		$off_cond='';
			// 	}else{
			// 		$off_id=implode('","', $ofc_id);
			// 		$off_cond .=' and s.office_id in ("'.$off_id.'")';
			// 	}
			// }
			$data['selected_office'] = $search_office;
			
			// ============  FILTER PROCESS ========================================//
			
			$search_process_id = "";
			if(!empty($this->input->get('select_process'))){ 					
				$search_process_id = $this->input->get('select_process');
			}			
			$data['selected_process'] = $search_process_id;

			//===================== DROPDOWN FILTERS ======================================//
			
			// $search_client_id = "";
			// if(!empty($this->input->get('select_client'))){ 					
			// 	$search_client_id = $this->input->get('select_client');
			// }			
			// $data['selected_client'] = $search_client_id;
			// // Client Selection
			// $sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			// $result_client = $this->Common_model->get_query_result_array($sql_client);
			// $data['client_list'] = $result_client;
			
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
					// office condition - office multiselect - 17-03-22
					
					// if(!empty($office_str)){$offCondi .= "AND s.office_id IN ('".$office_str."')";}
				
					$audit_excluded = implode("','", $getExcluded_Audits);

					//Date Wise
					$dateWise_sql = "SELECT COUNT(qa.id) as audit_count,
						qa.audit_date,
						(SELECT COUNT(qa1.id) 
						FROM $c_defect_table qa1
						WHERE qa1.audit_date = qa.audit_date
						$offCondi
						AND qa1.audit_type NOT IN ('$audit_excluded')) as audit_count_ex,
						(SELECT AVG(qa1.overall_score)
						FROM $c_defect_table qa1
						WHERE qa1.audit_date = qa.audit_date
						$offCondi
						AND qa1.audit_type NOT IN ('$audit_excluded')) as average_score
					FROM $c_defect_table qa
					LEFT JOIN signin s ON s.id = qa.agent_id
					WHERE DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date' $offCondi
					GROUP BY qa.audit_date";
					$data['date_wise'] = $this->Common_model->get_query_result_array($dateWise_sql);
					$this->createDateWiseCSV($data['date_wise']);

					//Evaluator Wise
					$evaluator_sql = "SELECT COUNT(qa.id) as audit_count,
						(SELECT COUNT(qa_sub.id) FROM $c_defect_table qa_sub INNER JOIN signin s ON s.id = qa_sub.entry_by
							LEFT JOIN office_location l ON l.abbr = s.office_id INNER JOIN signin sagent ON sagent.id = qa_sub.agent_id WHERE DATE(qa_sub.audit_date) = DATE('$currentDate') $offCondi AND qa_sub.entry_by = qa.entry_by) as ftd_count,
						CONCAT(s.fname, ' ', s.lname) as auditor_name,
						(select AVG(qa1.overall_score) from $c_defect_table qa1 where qa.entry_by = qa1.entry_by and qa1.audit_type NOT IN ('$audit_excluded') and DATE(qa1.audit_date) >= '$start_date' AND DATE(qa1.audit_date) <= '$end_date') as average_score
					FROM $c_defect_table qa
					INNER JOIN signin s ON s.id = qa.entry_by
					LEFT JOIN office_location l ON l.abbr = s.office_id
					INNER JOIN signin sagent ON sagent.id = qa.agent_id
					WHERE DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date' $offCondi
					GROUP BY auditor_name";
					//echo $evaluator_sql;die;
					$data['evaluator_wise'] = $this->Common_model->get_query_result_array($evaluator_sql);
					$this->createEvalWiseCSV($data['evaluator_wise']);

					//TL Wise
					$tlWise_sql = "SELECT COUNT(qa.id) as audit_count, CONCAT(s.fname, ' ', s.lname) as tl_name, (select AVG(qa1.overall_score) from $c_defect_table qa1 where qa.tl_id = qa1.tl_id and qa1.audit_type NOT IN ('$audit_excluded') and DATE(qa1.audit_date) >= '$start_date' AND DATE(qa1.audit_date) <= '$end_date') as average_score
					FROM $c_defect_table qa
					INNER JOIN signin s ON s.id = qa.tl_id
					LEFT JOIN office_location l ON l.abbr = s.office_id
					INNER JOIN signin sagent ON sagent.id = qa.agent_id
					WHERE DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date' $offCondi
					GROUP BY tl_name";
					$data['tl_wise'] = $this->Common_model->get_query_result_array($tlWise_sql);
					$this->createTLWiseCSV($data['tl_wise']);

					//Agent Wise
					$agentWise_sql = "SELECT COUNT(qa.id) as audit_count, CONCAT(s.fname, ' ', s.lname) as agent_name, 
					(select AVG(qa1.overall_score) from $c_defect_table qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and DATE(qa1.audit_date) >= '$start_date' AND DATE(qa1.audit_date) <= '$end_date') as average_score
					FROM $c_defect_table qa
					INNER JOIN signin s ON s.id = qa.agent_id
					LEFT JOIN office_location l ON l.abbr = s.office_id
					WHERE DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date' $offCondi
					GROUP BY agent_name";
					$data['agentWise'] = $this->Common_model->get_query_result_array($agentWise_sql);
					$this->createAgentWiseCSV($data['agentWise']);

					// Vertical Wise
					// $verticalWise_sql = "SELECT COUNT(qa.id) as audit_count,
					// 	(SELECT vert.name FROM qa_vertical_data vert WHERE vert.id = s.vertical_id) as vertical_name,
					// 	(select AVG(qa1.overall_score) from $c_defect_table qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and DATE(qa1.audit_date) >= '$start_date' AND DATE(qa1.audit_date) <= '$end_date') as average_score
					// FROM $c_defect_table qa
					// INNER JOIN signin s ON s.id = qa.agent_id
					// LEFT JOIN office_location l ON l.abbr = s.office_id
					// WHERE DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date' $offCondi
					// GROUP BY vertical_name";
					// $data['verticalWise'] = $this->Common_model->get_query_result_array($verticalWise_sql);
					// $this->createVerticalWiseReport($data['verticalWise']);

					// Channel Wise
					// $channelWise_sql = "SELECT COUNT(qa.id) as audit_count,
					// 	(SELECT channel.name FROM qa_channel_data channel WHERE channel.id = s.channel_id) as channel_name,
					// 	(select AVG(qa1.overall_score) from $c_defect_table qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and DATE(qa1.audit_date) >= '$start_date' AND DATE(qa1.audit_date) <= '$end_date') as average_score
					// FROM $c_defect_table qa
					// INNER JOIN signin s ON s.id = qa.agent_id
					// LEFT JOIN office_location l ON l.abbr = s.office_id
					// WHERE DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date' $offCondi
					// GROUP BY channel_name";
					// $data['channelWise'] = $this->Common_model->get_query_result_array($channelWise_sql);
					// $this->createChannelWiseReport($data['channelWise']);

					// Tenurity Wise
					$tenurityWise_sql = "SELECT COUNT(qa.id) as audit_count,
						(DATEDIFF(DATE(NOW()), DATE(s.created_date))) as tenurity,
						(select AVG(qa1.overall_score) from $c_defect_table qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and DATE(qa1.audit_date) >= '$start_date' AND DATE(qa1.audit_date) <= '$end_date') as average_score
					FROM $c_defect_table qa
					LEFT JOIN signin s ON s.id = qa.agent_id
					WHERE DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date' $offCondi
					GROUP BY tenurity";
					$data['tenurityWise'] = $this->Common_model->get_query_result_array($tenurityWise_sql);
					$this->createTenureWiseCSV($data['tenurityWise']);
				
					/* end */
						
					// CQ SCORE
					$sql_qaScore = "SELECT count(qa.id) as auditCount_ex, 
					(select count(qa.id) from $c_defect_table as qa
						INNER JOIN signin as s ON s.id = qa.agent_id
						WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date')
						$offCondi AND s.status=1) as auditCount,
					avg(qa.overall_score) as score
						FROM $c_defect_table as qa
						INNER JOIN signin as s ON s.id = qa.agent_id
						WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date')
						$offCondi AND qa.audit_type NOT IN ('$audit_excluded') AND s.status=1";
					$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
					
					$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
					$totalAuditCount = $c_auditCount;
					///$avgCQScore = round($c_qaScore['score']);
					$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
					
					// CQ FATAL
					$sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $offCondi AND qa.audit_type NOT IN ('$audit_excluded') AND overall_score = '0'";
								
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
					foreach($paramsArray as $token){
						//=== NO 
						$errorChecker = $errorNoCheck;
						if($token == 'misrepresentation'){
							$errorChecker = $errorYesCheck;
						}
						$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$offCondi AND qa.$token IN (".$errorChecker.")";					
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
						
						$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$offCondi AND (qa.$token IN (".$errorChecker."))";	
						$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
						$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
						$paramsPercent = 0;
						if($totalAuditCount > 0){
							$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
						}
						$params2['count'][$token]['yes'] = $c_ParamCount;
						$params2['percent'][$token]['yes'] = $paramsPercent;		
						
						
						//=== NA
						$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') 
									$offCondi AND qa.$token IN (".$errorNACheck.")";
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

					//Create Parameter Wise CSV
					$this->createParameterWiseCSV($paramsArray, $params2);

					// New Location Wise Data [Logic]
					$location_sql = "SELECT COUNT(qa.id) as total_audit_count_ex,
						(select count(qa1.id) 
						FROM $c_defect_table qa1 
						join signin si ON si.id=qa1.agent_id 
						where si.office_id = s.office_id AND (DATE(qa1.audit_date) >= '$start_date' AND DATE(qa1.audit_date) <='$end_date')
						) as total_audit_count,
						s.office_id,
						l.office_name, 
						ROUND(AVG(qa.overall_score), 2) as cq_score 
					FROM $c_defect_table qa 
					INNER JOIN signin s ON s.id=qa.agent_id 
					LEFT JOIN office_location l ON l.abbr = s.office_id 
					WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <='$end_date') 
						$offCondi 
						AND qa.audit_type NOT IN ('$audit_excluded') 
					GROUP BY office_name";
					$loc_locations = $this->db->query($location_sql)->result_array();
					$location_fatal_sql = "SELECT COUNT(qa.id) as fatal_count, s.office_id, l.office_name FROM $c_defect_table qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr=s.office_id WHERE (DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date') $offCondi AND qa.audit_type NOT IN ('$audit_excluded') AND qa.overall_score=0 GROUP BY office_name";
					$location_fatal = $this->db->query($location_fatal_sql)->result_array();
					$data['location_Data'] = array(
						"generic"=>$loc_locations,
						"defect_count"=>array(),
						"total_parameters"=>count($paramsArray),
						"fatal_count"=>$location_fatal
					);
					foreach($paramsArray as $param){
						$agentDefect_sql = "SELECT COUNT(qa.id) as defect_count, l.office_name, qa.$param FROM $c_defect_table qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr=s.office_id WHERE (DATE(qa.audit_date)>='$start_date' AND DATE(qa.audit_date)<='$end_date') $offCondi AND qa.audit_type NOT IN ('$audit_excluded') AND (qa.$param IN ($errorNoCheck)) GROUP BY office_name";
						$agentDefect = $this->db->query($agentDefect_sql)->result_array();
						if(!empty($agentDefect))array_push($data['location_Data']['defect_count'], $agentDefect);
					}
					// echo "<pre>";
					// print_r($data['location_Data']['defect_count']);
					// echo "</pre>";
					// die;
					$this->createLocWiseCSV($data['location_Data'], count($paramsArray));

					$weekly_sql = "SELECT WEEK(qa.audit_date) as currWeek, COUNT(qa.id) FROM $c_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) AND YEAR('$start_date') $offCondi GROUP BY WEEK(qa.audit_date)";
					$weekly_audit_count = $this->db->query($weekly_sql)->result_array();
					$data['weekly']['month_name'] = date("F", strtotime($start_date));
					$data['weekly']['total_defect']['no_of_weeks'] = count($weekly_audit_count);
					$data['weekly']['total_defect']['weeklyData'] = array();
					$data['weekly']['total_defect']['monthlyData'] = array();
					$data['weekly']['quality'] = array();
					//$data['weekly']['quality']['bucket'] = array();
					$fatal_params = $get_defect_columns['fatal_param'];
					$fatal_paramsArray = explode(",", $fatal_params);
					//Monthly Data
					$monthlyData = $this->db->query("SELECT COUNT(qa.id) as total_audit_ex,(select count(qa.id) from $c_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) AND YEAR('$start_date') $offCondi) as total_audit, SUM(qa.overall_score) as total_cq FROM $c_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) AND YEAR('$start_date') $offCondi AND qa.audit_type NOT IN ('$audit_excluded')")->result_array()[0];
					
					$totalMonthlyDefect = 0;
					foreach($paramsArray as $token){
						$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $c_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE (qa.$token IN ('No', 'Fail')) AND MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) AND YEAR('$start_date') $offCondi AND qa.audit_type NOT IN ('$audit_excluded')";
						//echo "<pre>";
						//print_r($this->db->query($defect_sql)->result_array());echo "</pre>";
						$totalMonthlyDefect += $this->db->query($defect_sql)->result_array()[0]['def_count'];
					}
					$MonthlyfatalCounter = 0;
					foreach($fatal_paramsArray as $fatal_param){
						$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $c_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$start_date') AND (qa.$fatal_param IN ('No')) $offCondi AND qa.audit_type NOT IN ('$audit_excluded')";
						$MonthlyfatalCounter += $this->db->query($defect_sql)->result_array()[0]['fatal_count'];
					}
					array_push($data['weekly']['total_defect']['monthlyData'], array(
						"totalAudit"=>$monthlyData['total_audit'],
						"total_defect"=>$totalMonthlyDefect,
						"total_fatal"=>$MonthlyfatalCounter,
						"cq_score"=>$monthlyData['total_cq'],
						"monthlyData"=>$monthlyData
					));
					//Weekly Data
					if(count($weekly_audit_count) > 0){
						$weekCounter = 1;
						foreach($weekly_audit_count as $week){
							$total_defect_sum = 0;
							$curr_week = $week['currWeek'];
							foreach($paramsArray as $token){
								$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $c_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE (qa.$token IN ('No', 'Fail')) AND WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) = YEAR(NOW()) $offCondi AND qa.audit_type NOT IN ('$audit_excluded')";
								//echo "<pre>";
								//print_r($this->db->query($defect_sql)->result_array());echo "</pre>";
								$total_defect_sum += $this->db->query($defect_sql)->result_array()[0]['def_count'];
							}
							$fatalCounter = 0;
							foreach($fatal_paramsArray as $fatal_param){
								$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $c_defect_table qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) = YEAR(NOW()) AND (qa.$fatal_param IN ('No')) $offCondi AND qa.audit_type NOT IN ('$audit_excluded')";
								$fatalCounter += $this->db->query($defect_sql)->result_array()[0]['fatal_count'];
							}
							$weeklyCount = $this->db->query("SELECT COUNT(qa.id) as weeklyCount, (SELECT COUNT(qa1.id) FROM $c_defect_table qa1 WHERE WEEK(qa1.audit_date) = '$curr_week' AND MONTH(qa1.audit_date) = MONTH('$start_date') AND YEAR(qa1.audit_date) = YEAR(NOW()) AND qa1.audit_type NOT IN ('$audit_excluded')) as weeklyCount_ex FROM $c_defect_table qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date)='$curr_week' AND MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) = YEAR(NOW()) $offCondi")->result_array()[0];
							$weeklyCQScore = $this->db->query("SELECT AVG(qa.overall_score) as cq_score FROM $c_defect_table qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$start_date') AND YEAR(qa.audit_date) = YEAR(NOW()) $offCondi AND qa.audit_type NOT IN ('$audit_excluded')")->result_array()[0]['cq_score'];
							array_push($data['weekly']['total_defect']['weeklyData'], array(
								"week"=>$curr_week,
								"cq_score"=>$weeklyCQScore,
								"weeklyAuditCount"=>$weeklyCount,
								"fatalCount_$weekCounter"=>$fatalCounter,
								"week_$weekCounter" => $total_defect_sum
							));
							++$weekCounter;
						}
						//exit;
					}
					//Quality Bucket
					$monthlyAgent_Data = $this->db->query("SELECT COUNT(DISTINCT qa.agent_id) as total_agents FROM $c_defect_table qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$start_date') $offCondi")->result_array()[0];
					$agentQuality_Data = $this->db->query("SELECT COUNT(qa.agent_id) as total_agentAudit, qa.agent_id, (SELECT SUM(qa_sub.overall_score) FROM $c_defect_table qa_sub WHERE qa_sub.audit_type NOT IN ('$audit_excluded') AND MONTH(qa_sub.audit_date) = MONTH('$start_date') AND qa_sub.agent_id = qa.agent_id GROUP BY qa_sub.agent_id) as agent_quality FROM $c_defect_table qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$start_date') $offCondi GROUP BY qa.agent_id")->result_array();
					$monthlyAudit = $this->db->query("SELECT COUNT(qa.id) as total_audit FROM $c_defect_table qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$start_date') $offCondi AND s.status=1")->result_array()[0];

					// New LOgic
					$bucket_sql = "SELECT qa.agent_id, ROUND(AVG(qa.overall_score), 2) as quality_score FROM $c_defect_table qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date)=MONTH('$start_date') $offCondi AND qa.audit_type NOT IN ('$audit_excluded') GROUP BY qa.agent_id";
					$buckets = $this->db->query($bucket_sql)->result_array();
					$bucketCount = array("bucket0"=>0,"bucket1"=>0,"bucket2"=>0,"bucket3"=>0,"bucket4"=>0);
					// echo "<pre>";
					// print_r($buckets);
					foreach($buckets as $bucket){
						if($bucket['quality_score'] >= 90)++$bucketCount['bucket4'];
						else if($bucket['quality_score'] >= 80 && $bucket['quality_score'] < 90)++$bucketCount['bucket3'];
						else if($bucket['quality_score'] >= 60 && $bucketCount['quality_score'] < 80)++$bucketCount['bucket2'];
						else if($bucket['quality_score'] >= 30 && $bucketCount['quality_score'] < 60)++$bucketCount['bucket1'];
						else if($bucket['quality_score'] < 30)++$bucketCount['bucket0'];
					}
					$data['weekly']['quality']['bucketCount'] = $bucketCount;
					// print_r($bucketCount);
					// echo "</pre>";
					array_push($data['weekly']['quality'], array(
						"monthlyAudit"=>$monthlyAudit,
						"total_cq"=>$monthlyData['total_cq'],
						"monthlyAgentData"=>$monthlyAgent_Data,
						"agentQuality_Data"=>$agentQuality_Data
					));
					$i=0;
					foreach($paramsArray as $param){
						if($i<count($paramsArray)-1){
							$subQuery .= "SUM(select count(ss.id) from $c_defect_table ss where ss.audit_date=qa.audit_date and ($param='No' or $param='Fail'))+";
						}else{
							$subQuery .= "SUM(select count(ss.id) from $c_defect_table ss where ss.audit_date=qa.audit_date and ($param='No' or $param='Fail'))";
						}
						$i++;
					}
					$weekly_sql1 = "SELECT WEEK(qa.audit_date), COUNT(qa.id), ($subQuery) as total_sum 
					FROM $c_defect_table qa 
					LEFT JOIN signin s ON s.id=qa.agent_id
					WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND s.status=1 GROUP BY WEEK(qa.audit_date)";
					$data['weekly']['monthly'] = $this->db->query($weekly_sql)->result_array();
				}
			}
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing_one_view_dashboard/qa_boomsourcing_one_view_dashboard.php";
			$data["content_js"] = "qa_boomsourcing_one_view_dashboard/qa_boomsourcing_one_view_dashboard_js.php";
			$this->load->view('dashboard',$data);
		}
	}
	/**
	 * TODO: Function to create Date Wise CSV Report
	 * Edited By Samrat 30-May-22
	 */
	private function createDateWiseCSV($queryResult){
		$header = array('Date', 'Audit Count', 'Quality Score');
		$filename = "./assets/reports/OneView_DateWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			foreach($queryResult as $report){
				$row = '"'.$report['audit_date'].'",';
				$row .= '"'.$report['audit_count'].'",';
				$row .= '"'.number_format((float)$report['average_score'], 2).'%",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create Location Wise CSV Report
	 * Edited By Samrat 30-May-22
	 */
	private function createLocWiseCSV($queryResult, $paramCount){
		$header = array('#', 'Location', 'No of Audit', 'Total Parameters', 'Total Defects', 'Total Defect(%)', 'Fatal Count', 'Quality Score');
		$filename = "./assets/reports/OneView_LocationWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			$counter = 1;
			$total_defect_counts = array();
			$total_fatal_counts = array();
			foreach($queryResult['generic'] as $location){
				$total_defect_counts[$location['office_name']] = 0;
				$total_fatal_counts[$location['office_name']] = 0;
			}
			foreach($queryResult['defect_count'] as $defect){
				for($i = 0; $i < count($defect); $i++){
					$total_defect_counts[$defect[$i]['office_name']] += $defect[$i]['defect_count'];
				}
			}
			foreach($queryResult['fatal_count'] as $fatal)
				$total_fatal_counts[$fatal['office_name']] += $fatal['fatal_count'];
			foreach($queryResult['generic'] as $report){
				$row = '"'.$counter++.'",';
				$row .= '"'.$report['office_name'].'",';
				$row .= '"'.$report['total_audit_count'].'",';
				$row .= '"'.$paramCount * $report['total_audit_count'].'",';
				$row .= '"'.$total_defect_counts[$report['office_name']].'",';
				$row .= '"'.number_format(($total_defect_counts[$report['office_name']]/($report['total_audit_count']*$queryResult['total_parameters']))*100, 2).'%",';
				$row .= '"'.$total_fatal_counts[$report['office_name']].'",';
				$row .= '"'.$report['cq_score'].'",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create Evaluator Wise CSV Report
	 * Edited By Samrat 30-May-22
	 */
	private function createEvalWiseCSV($queryResult){
		$header = array('Evaluator Name', 'MTD Audit Count', 'FTD Audit COUNT', 'Quality Score');
		$filename = "./assets/reports/OneView_EvalWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			foreach($queryResult as $report){
				$row = '"'.$report['auditor_name'].'",';
				$row .= '"'.$report['audit_count'].'",';
				$row .= '"'.$report['ftd_count'].'",';
				$row .= '"'.number_format((float)$report['average_score'], 2).'%",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create Tenurity Wise CSV Report
	 * ! Edited By Samrat 9-Aug-22
	 */
	private function createTenureWiseCSV($queryResult){
		$header = array('Tenurity', 'MTD Audit Count', 'Quality Score');
		$filename = "./assets/reports/OneView_TenureWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			foreach($queryResult as $report){
				$row = '"'.$report['tenurity'].' days",';
				$row .= '"'.$report['audit_count'].'",';
				$row .= '"'.number_format((float)$report['average_score'], 2).'%",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create TL Wise CSV Report
	 * Edited By Samrat 30-May-22
	 */
	private function createTLWiseCSV($queryResult){
		$header = array('TL Name', 'MTD Audit Count', 'Quality Score');
		$filename = "./assets/reports/OneView_TLWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			foreach($queryResult as $report){
				$row = '"'.$report['tl_name'].'",';
				$row .= '"'.$report['audit_count'].'",';
				$row .= '"'.number_format((float)$report['average_score'], 2).'%",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create Agent Wise CSV Report
	 * Edited By Samrat 30-May-22
	 */
	private function createAgentWiseCSV($queryResult){
		$header = array('Agent Name', 'MTD Audit Count', 'Quality Score');
		$filename = "./assets/reports/OneView_AgentWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			foreach($queryResult as $report){
				$row = '"'.$report['agent_name'].'",';
				$row .= '"'.$report['audit_count'].'",';
				$row .= '"'.number_format((float)$report['average_score'], 2).'%",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create Vertical Wise CSV Report
	 * ! Edited By Samrat 15-Jul-22
	 */
	private function createVerticalWiseReport($queryResult){
		$header = array('Vertical Name', 'MTD Audit Count', 'Quality Score');
		$filename = "./assets/reports/OneView_VerticalWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			foreach($queryResult as $report){
				$row = '"'.$report['vertical_name'].'",';
				$row .= '"'.$report['audit_count'].'",';
				$row .= '"'.number_format((float)$report['average_score'], 2).'%",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create Channel Wise CSV Report
	 * ! Edited By Samrat 15-Jul-22
	 */
	private function createChannelWiseReport($queryResult){
		$header = array('Channel Name', 'MTD Audit Count', 'Quality Score');
		$filename = "./assets/reports/OneView_ChannelWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($queryResult) > 0){
			foreach($queryResult as $report){
				$row = '"'.$report['channel_name'].'",';
				$row .= '"'.$report['audit_count'].'",';
				$row .= '"'.number_format((float)$report['average_score'], 2).'%",';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to create Parameter Wise CSV Report
	 * Edited By Samrat 30-May-22
	 */
	private function createParameterWiseCSV($parameters, $param_dets){
		$header = array('#', 'Overall Parameters', 'Yes', 'No', 'NA', 'Grand Total', 'Score%', 'Error Count%');
		$filename = "./assets/reports/OneView_ParameterWise_Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$row = "";
		$cn = 1;
		foreach($header as $header_row) $row .= ''.$header_row.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		if(count($parameters) > 0){
			foreach($parameters as $token){
				$row = '"'.$cn++.'",';
				$row .= '"'.$token.'",';
				$row .= '"'.$param_dets['count'][$token]['yes'].'",';
				$row .= '"'.$param_dets['count'][$token]['no'].'",';
				$row .= '"'.$param_dets['count'][$token]['na'].'",';
				$row .= '"'.($param_dets['count'][$token]['yes'] + $param_dets['count'][$token]['no'] + $param_dets['count'][$token]['na']).'",';
				$row .= '"'.$param_dets['percent'][$token]['yes'].'%",';
				$row .= '"'.$param_dets['percent'][$token]['no'].'%"';
				fwrite($fopen,$row."\r\n");
			}
		}else{
			fwrite($fopen,rtrim("No Data Found",",")."\r\n");
		}
		fclose($fopen);
	}
	/**
	 * TODO: Function to export Date Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_dateWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_DateWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Date Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export Location Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_locationWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_LocationWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Location Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export Evaluator Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_EvalWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_EvalWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Evaluator Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export TL Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_TLWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_TLWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View TL Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export Agent Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_AgentWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_AgentWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Agent Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export Vertical Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_VerticalWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_VerticalWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Vertical Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export Channel Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_ChannelWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_ChannelWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Channel Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export Tenure Wise Report
	 * ! Edited By Samrat 9-Aug-22
	 */
	public function download_TenurityWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_TenureWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Tenure Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to export Parameter Wise Report
	 * Edited By Samrat 30-May-22
	 */
	public function download_ParameterWiseReport(){
		if(check_logged_in()){
			$filename = "./assets/reports/OneView_ParameterWise_Report".get_user_id().".csv";
			//ob_end_clean();
			$newfile="Dunzo - One View Parameter Wise Report.csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
		}
	}
	/**
	 * TODO: Function to create Daily Report [Monthly]
	 * ! Edited By Samrat 30-May-22
	 */
	private function createDailyReport(){
		$currentDate = date("Y-m-d");
		$search_process_id = 2;
		$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
		LEFT JOIN process as p ON p.id = q.process_id
		LEFT JOIN client as c ON c.id = q.client_id
		WHERE q.is_active = 1";
		$get_defect_columns = $this->db->query($sql_defect_columns)->result_array();
		
		for($index = 0; $index < count($get_defect_columns); $index++){
			if($index > 0){
				$this->objPHPExcel->createSheet();
			}
			$this->objPHPExcel->setActiveSheetIndex($index);
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle($get_defect_columns[$index]['process_name']);

			$campaign  =  trim($get_defect_columns[$index]['table_name']);

			$objWorksheet->setShowGridlines(true);
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
			$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 9,
					'name'  => 'Calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$audit_excluded = implode("','", $getExcluded_Audits);

			// CQ SCORE
			$sql_qaScore = "SELECT count(qa.id) as auditCount_ex, 
			(select count(qa.id) from $campaign as qa
				INNER JOIN signin as s ON s.id = qa.agent_id
				WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
				AND s.status=1) as auditCount,
			avg(qa.overall_score) as score
				FROM $campaign as qa
				INNER JOIN signin as s ON s.id = qa.agent_id
				WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
				AND qa.audit_type NOT IN ('$audit_excluded') AND s.status=1";
			$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
			
			$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
			$totalAuditCount = $c_auditCount;
			///$avgCQScore = round($c_qaScore['score']);
			$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
			
			// CQ FATAL
			$sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $campaign as qa
			INNER JOIN signin as s ON s.id = qa.agent_id
			WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')) AND qa.audit_type NOT IN ('$audit_excluded') AND overall_score = '0'";
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
			$paramColumns = $get_defect_columns[$index]['params_columns'];
			$paramsArray = explode(',', $paramColumns);
			$totalErrorCount = 0;
			
			// GET CUSTOM PARAMS
			$errorCheckGrant = true; 
			$errorNoCheck = "'0', 'No', 'no', 'Unacceptable', 'Fail', 'Absent', 'Action needed'";
			$errorYesCheck = "'1', 'Yes', 'yes', 'Acceptable', 'Pass', 'Awesome', 'Average'";
			$errorNACheck = "'N/A', 'NA', 'na', 'n/a'";
			$customParams = array();
			if($get_defect_columns[$index]['process_id'] == "171" || $get_defect_columns[$index]['process_id'] == "181"){
				$customParams = $this->custom_error_parameters($get_defect_columns[$index]['process_id']);
				$errorCheckGrant = false;
			}
			foreach($paramsArray as $token){
				//=== NO 
				$errorChecker = $errorNoCheck;
				if($token == 'misrepresentation'){
					$errorChecker = $errorYesCheck;
				}
				$sqlToken = "SELECT count(*) as auditCount from $campaign as qa INNER JOIN signin as s ON s.id = qa.agent_id
							WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) AND qa.$token IN (".$errorChecker.")";					
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
				
				
				$sqlToken = "SELECT count(*) as auditCount from $campaign as qa INNER JOIN signin as s ON s.id = qa.agent_id
							WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) AND (qa.$token IN (".$errorChecker."))";							
				$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
				$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
				$paramsPercent = 0;
				if($totalAuditCount > 0){
					$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
				}
				$params2['count'][$token]['yes'] = $c_ParamCount;
				$params2['percent'][$token]['yes'] = $paramsPercent;		
				
				
				//=== NA
				$sqlToken = "SELECT count(*) as auditCount from $campaign as qa INNER JOIN signin as s ON s.id = qa.agent_id
							WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) AND qa.$token IN (".$errorNACheck.")";
				$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
				$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
				$paramsPercent = 0;
				if($totalAuditCount > 0){
					$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
				}
				$params2['count'][$token]['na'] = $c_ParamCount;
				$params2['percent'][$token]['na'] = $paramsPercent;
			}

			// $filename = "./assets/reports/OneView_Daily_Report".get_user_id().".csv";
			// $fopen = fopen($filename,"w+");

			//Date Wise
			$dateWise_sql = "SELECT COUNT(qa.id) as audit_count,
				qa.audit_date,
				(SELECT COUNT(qa1.id) 
				FROM $campaign qa1
				WHERE qa1.audit_date = qa.audit_date
				AND qa1.audit_type NOT IN ('$audit_excluded')) as audit_count_ex,
				(SELECT AVG(qa1.overall_score)
				FROM $campaign qa1
				WHERE qa1.audit_date = qa.audit_date
				AND qa1.audit_type NOT IN ('$audit_excluded')) as average_score
			FROM $campaign qa
			LEFT JOIN signin s ON s.id = qa.agent_id
			WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')
			GROUP BY qa.audit_date";
			// $dateWise_sql = "SELECT COUNT(qa.id) as audit_count, qa.audit_date, AVG(qa.overall_score) as average_score 
			// FROM $campaign qa 
			// INNER JOIN signin s ON s.id = qa.agent_id 
			// LEFT JOIN office_location l ON l.abbr = s.office_id 
			// WHERE (MONTH(qa.audit_date) = MONTH('$currentDate')) AND qa.audit_type IN ('CQ Audit', 'BQ Audit', 'OJT')
			// GROUP BY qa.audit_date";
			$date_wise = $this->Common_model->get_query_result_array($dateWise_sql);

			//Header Style Array
			$titleStyleArray = array(
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 9,
					'name'  => 'Calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '188ae2')
				)
			);
			$headerStyleArray = array(
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 9,
					'name'  => 'Calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '18dbe2')
				)
			);
			//Write Date Wise Header
			//Set Header
			$rowCounter = 1;
			$objWorksheet->setCellValue("A$rowCounter", "Date Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Date");
			$objWorksheet->setCellValue("C$rowCounter", "Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Date Wise Data
			if(count($date_wise) > 0){
				$counter = 1;
				foreach($date_wise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['audit_date']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}
			
			//Location Wise

			// New Location Wise Data [Logic]
			$location_sql = "SELECT COUNT(qa.id) as total_audit_count_ex,
				(select count(qa1.id) 
				FROM $campaign qa1 
				join signin si ON si.id=qa1.agent_id 
				where si.office_id = s.office_id AND (MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate'))
				) as total_audit_count,
				s.office_id,
				l.office_name, 
				ROUND(AVG(qa.overall_score), 2) as cq_score 
			FROM $campaign qa 
			INNER JOIN signin s ON s.id=qa.agent_id 
			LEFT JOIN office_location l ON l.abbr = s.office_id 
			WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))  
				AND qa.audit_type NOT IN ('$audit_excluded') 
			GROUP BY office_name";
			// $location_sql = "SELECT COUNT(qa.id) as total_audit_count,s.office_id,l.office_name, ROUND(AVG(qa.overall_score), 2) as cq_score FROM $campaign qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND qa.audit_type IN ('CQ Audit', 'BQ Audit', 'OJT') GROUP BY office_name";
			$loc_locations = $this->db->query($location_sql)->result_array();
			
			$location_fatal_sql = "SELECT COUNT(qa.id) as fatal_count, s.office_id, l.office_name FROM $campaign qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr=s.office_id WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')) AND qa.audit_type NOT IN ('$audit_excluded') AND qa.overall_score=0 GROUP BY office_name";
			$location_fatal = $this->db->query($location_fatal_sql)->result_array();
			// $all_locations = $this->db->query("SELECT office_name FROM office_location l RIGHT JOIN signin s ON s.office_id=l.abbr INNER JOIN $campaign qa ON qa.agent_id=s.id")->result_array()[0];
			//echo "<pre>";print_r($all_locations);echo "</pre>";die;
			$location_Data = array(
				"generic"=>$loc_locations,
				"defect_count"=>array(),
				"total_parameters"=>count($paramsArray),
				"fatal_count"=>$location_fatal
			);
			foreach($paramsArray as $param){
				$agentDefect_sql = "SELECT COUNT(qa.id) as defect_count, l.office_name, qa.$param FROM $campaign qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr=s.office_id WHERE (MONTH(qa.audit_date)=MONTH('$currentDate') AND YEAR(qa.audit_date)=YEAR('$currentDate')) AND qa.audit_type NOT IN ('$audit_excluded') AND (qa.$param IN ($errorNoCheck)) GROUP BY office_name";
				$agentDefect = $this->db->query($agentDefect_sql)->result_array();
				if(!empty($agentDefect))array_push($location_Data['defect_count'], $agentDefect);
			}

			//Write Location Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly Location Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Location");
			$objWorksheet->setCellValue("C$rowCounter", "No of Audit");
			$objWorksheet->setCellValue("D$rowCounter", "Total Parameters");
			$objWorksheet->setCellValue("E$rowCounter", "Total Defects");
			$objWorksheet->setCellValue("F$rowCounter", "Total Defect %");
			$objWorksheet->setCellValue("G$rowCounter", "Fatal Count");
			$objWorksheet->setCellValue("H$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:H$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Location Date
			if(count($location_Data['generic']) == 0){
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:G$rowCounter");
				++$rowCounter;
			}else{
				$counter = 1;
				$total_defect_counts = array();
				$total_fatal_counts = array();
				foreach($location_Data['generic'] as $location){
					$total_defect_counts[$location['office_name']] = 0;
					$total_fatal_counts[$location['office_name']] = 0;
				}
				foreach($location_Data['defect_count'] as $defect){
					for($i = 0; $i < count($defect); $i++){
						$total_defect_counts[$defect[$i]['office_name']] += $defect[$i]['defect_count'];
					}
				}
				foreach($location_Data['fatal_count'] as $fatal)
					$total_fatal_counts[$fatal['office_name']] += $fatal['fatal_count'];
				foreach($location_Data['generic'] as $location){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $location['office_name']);
					$objWorksheet->setCellValue("C$rowCounter", $location['total_audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", count($paramsArray)*$location['total_audit_count']);
					$objWorksheet->setCellValue("E$rowCounter", $total_defect_counts[$location['office_name']]);
					$objWorksheet->setCellValue("F$rowCounter", number_format((float)($total_defect_counts[$location['office_name']]/($location['total_audit_count']*$location_Data['total_parameters']))*100, 2)."%");
					$objWorksheet->setCellValue("G$rowCounter", $total_fatal_counts[$location['office_name']]);
					$objWorksheet->setCellValue("H$rowCounter", $location['cq_score']."%");
					++$rowCounter;
				}
			}

			//Evaluator Wise
			$evaluator_sql = "SELECT COUNT(qa.id) as audit_count,
			(SELECT COUNT(qa_sub.id) FROM $campaign qa_sub INNER JOIN signin s ON s.id = qa_sub.entry_by
				LEFT JOIN office_location l ON l.abbr = s.office_id WHERE DATE(qa_sub.audit_date) = DATE('$currentDate') AND qa_sub.entry_by = qa.entry_by) as ftd_count,
			CONCAT(s.fname, ' ', s.lname) as auditor_name,
			(SELECT AVG(qa1.overall_score) FROM $campaign qa1 where qa.entry_by = qa1.entry_by and qa1.audit_type NOT IN ('$audit_excluded') and MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate')) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.entry_by
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY auditor_name";
			$evaluator_wise = $this->Common_model->get_query_result_array($evaluator_sql);

			//Write Evaluator Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Evaluator Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:E$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Evaluator Name");
			$objWorksheet->setCellValue("C$rowCounter", "MTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "FTD Audit Count");
			$objWorksheet->setCellValue("E$rowCounter", "MTD Quality Score");
			$objWorksheet->getStyle("A$rowCounter:E$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Evaluator Date
			if(count($evaluator_wise) > 0){
				$counter = 1;
				foreach($evaluator_wise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['auditor_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", $report['ftd_count']);
					$objWorksheet->setCellValue("E$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:E$rowCounter");
				++$rowCounter;
			}

			//TL Wise
			$tlWise_sql = "SELECT COUNT(qa.id) as audit_count, 
				CONCAT(s.fname, ' ', s.lname) as tl_name, 
				(SELECT AVG(qa1.overall_score) from $campaign qa1 where qa.tl_id = qa1.tl_id and qa1.audit_type NOT IN ('$audit_excluded') and MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate')) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.tl_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY tl_name";
			$tl_wise = $this->Common_model->get_query_result_array($tlWise_sql);

			//Write TL Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly TL Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "TL Name");
			$objWorksheet->setCellValue("C$rowCounter", "MTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write TL Data
			if(count($tl_wise) > 0){
				$counter = 1;
				foreach($tl_wise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['tl_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			//Agent Wise
			$agentWise_sql = "SELECT COUNT(qa.id) as audit_count, 
				CONCAT(s.fname, ' ', s.lname) as agent_name, 
				(select AVG(qa1.overall_score) 
				from $campaign qa1 
				where qa.agent_id = qa1.agent_id 
					and qa1.audit_type NOT IN ('$audit_excluded') 
					and (MONTH(qa1.audit_date) = MONTH('$currentDate') 
					AND YEAR(qa1.audit_date) = YEAR('$currentDate'))
				) as average_score,
				(SELECT name FROM qa_channel_data WHERE id = s.channel_id) as channel_name,
				(SELECT name FROM qa_vertical_data WHERE id = s.vertical_id) as vertical_name
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.agent_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY agent_name";
			$agentWise = $this->Common_model->get_query_result_array($agentWise_sql);

			//Write Agent Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly Agent Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:F$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Agent Name");
			$objWorksheet->setCellValue("C$rowCounter", "Channel Name");
			$objWorksheet->setCellValue("D$rowCounter", "Vertical Name");
			$objWorksheet->setCellValue("E$rowCounter", "MTD Audit Count");
			$objWorksheet->setCellValue("F$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:F$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Agent Data
			if(count($agentWise) > 0){
				$counter = 1;
				foreach($agentWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['agent_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['channel_name']);
					$objWorksheet->setCellValue("D$rowCounter", $report['vertical_name']);
					$objWorksheet->setCellValue("E$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("F$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			//Vertical Wise
			$verticalWise_sql = "SELECT COUNT(qa.id) as audit_count, (SELECT vert.name FROM qa_vertical_data vert WHERE vert.id = s.vertical_id) as vertical_name, (select AVG(qa1.overall_score) from $campaign qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and (MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate'))) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.agent_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY vertical_name";
			$verticalWise = $this->Common_model->get_query_result_array($verticalWise_sql);

			//Write Vertical Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly Vertical Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Vertical Name");
			$objWorksheet->setCellValue("C$rowCounter", "MTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Vertical Data
			if(count($verticalWise) > 0){
				$counter = 1;
				foreach($verticalWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['vertical_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			//Channel Wise
			$channelWise_sql = "SELECT COUNT(qa.id) as audit_count, (SELECT channel.name FROM qa_channel_data channel WHERE channel.id = s.channel_id) as channel_name, (select AVG(qa1.overall_score) from $campaign qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and (MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate'))) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.agent_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY channel_name";
			$channelWise = $this->Common_model->get_query_result_array($channelWise_sql);

			//Write Channel Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly Channel Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Channel Name");
			$objWorksheet->setCellValue("C$rowCounter", "MTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Channel Data
			if(count($channelWise) > 0){
				$counter = 1;
				foreach($channelWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['channel_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			// Tenure Wise
			$tenurityWise_sql = "SELECT COUNT(qa.id) as audit_count,
			(DATEDIFF(DATE(NOW()), DATE(s.created_date))) as tenurity,
			(select AVG(qa1.overall_score) from $campaign qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate') as average_score
			FROM $campaign qa
			LEFT JOIN signin s ON s.id = qa.agent_id
			WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')
			GROUP BY tenurity";
			$tenurityWise = $this->Common_model->get_query_result_array($tenurityWise_sql);
			//Write Tenure Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly Tenure Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Tenure");
			$objWorksheet->setCellValue("C$rowCounter", "MTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Tenure Data
			if(count($tenurityWise) > 0){
				$counter = 1;
				foreach($tenurityWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['tenurity']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}
			// Parameter Wise
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly Parameter Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Overall Parameters");
			$objWorksheet->setCellValue("C$rowCounter", "Yes");
			$objWorksheet->setCellValue("D$rowCounter", "No");
			$objWorksheet->setCellValue("E$rowCounter", "NA");
			$objWorksheet->setCellValue("F$rowCounter", "Grand Total");
			$objWorksheet->setCellValue("G$rowCounter", "Score%");
			$objWorksheet->setCellValue("H$rowCounter", "Error Count%");
			$objWorksheet->getStyle("A$rowCounter:H$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			if(count($paramsArray) > 0){
				$cn = 1;
				foreach($paramsArray as $token){
					$objWorksheet->setCellValue("A$rowCounter", $cn++);
					$objWorksheet->setCellValue("B$rowCounter", $token);
					$objWorksheet->setCellValue("C$rowCounter", $params2['count'][$token]['yes']);
					$objWorksheet->setCellValue("D$rowCounter", $params2['count'][$token]['no']);
					$objWorksheet->setCellValue("E$rowCounter", $params2['count'][$token]['na']);
					$objWorksheet->setCellValue("F$rowCounter", ($params2['count'][$token]['yes'] + $params2['count'][$token]['no'] + $params2['count'][$token]['na']));
					$objWorksheet->setCellValue("G$rowCounter", $params2['percent'][$token]['yes']."%");
					$objWorksheet->setCellValue("H$rowCounter", $params2['percent'][$token]['no']."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
				++$rowCounter;
			}

			//Weekly Trend
			$weekly_sql = "SELECT WEEK(qa.audit_date) as currWeek, COUNT(qa.id) FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) GROUP BY WEEK(qa.audit_date)";
			$weekly_audit_count = $this->db->query($weekly_sql)->result_array();
			$weekly['month_name'] = date("F", strtotime($currentDate));
			$weekly['total_defect']['no_of_weeks'] = count($weekly_audit_count);
			$weekly['total_defect']['weeklyData'] = array();
			$weekly['total_defect']['monthlyData'] = array();
			$weekly['quality'] = array();
			$fatal_params = $get_defect_columns[$index]['fatal_param'];
			$fatal_paramsArray = explode(",", $fatal_params);
			//Monthly Data
			$monthlyData = $this->db->query("SELECT COUNT(qa.id) as total_audit_ex,(select count(qa.id) from $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) as total_audit, SUM(qa.overall_score) as total_cq FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate') AND qa.audit_type NOT IN ('$audit_excluded')")->result_array()[0];

			$totalMonthlyDefect = 0;
			foreach($paramsArray as $token){
				$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE (qa.$token IN ('No', 'Fail')) AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate') AND qa.audit_type NOT IN ('$audit_excluded')";
				//echo "<pre>";
				//print_r($this->db->query($defect_sql)->result_array());echo "</pre>";
				$totalMonthlyDefect += $this->db->query($defect_sql)->result_array()[0]['def_count'];
			}
			$MonthlyfatalCounter = 0;
			foreach($fatal_paramsArray as $fatal_param){
				$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND (qa.$fatal_param IN ('No')) AND qa.audit_type NOT IN ('$audit_excluded')";
				$MonthlyfatalCounter += $this->db->query($defect_sql)->result_array()[0]['fatal_count'];
			}
			array_push($weekly['total_defect']['monthlyData'], array(
				"totalAudit"=>$monthlyData['total_audit'],
				"total_defect"=>$totalMonthlyDefect,
				"total_fatal"=>$MonthlyfatalCounter,
				"cq_score"=>$monthlyData['total_cq'],
				"monthlyData"=>$monthlyData
			));
			//Weekly Data
			if(count($weekly_audit_count) > 0){
				$weekCounter = 1;
				foreach($weekly_audit_count as $week){
					$total_defect_sum = 0;
					$curr_week = $week['currWeek'];
					foreach($paramsArray as $token){
						$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE (qa.$token IN ('No', 'Fail')) AND WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) AND qa.audit_type NOT IN ('$audit_excluded')";
						$total_defect_sum += $this->db->query($defect_sql)->result_array()[0]['def_count'];
					}
					$fatalCounter = 0;
					foreach($fatal_paramsArray as $fatal_param){
						$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) AND (qa.$fatal_param IN ('No')) AND qa.audit_type NOT IN ('$audit_excluded')";
						$fatalCounter += $this->db->query($defect_sql)->result_array()[0]['fatal_count'];
					}
					$weeklyCount = $this->db->query("SELECT COUNT(qa.id) as weeklyCount, (SELECT COUNT(qa1.id) FROM $campaign qa1 WHERE WEEK(qa1.audit_date) = '$curr_week' AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR(NOW()) AND qa1.audit_type NOT IN ('$audit_excluded')) as weeklyCount_ex FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date)='$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')")->result_array()[0];
					$weeklyCQScore = $this->db->query("SELECT AVG(qa.overall_score) as cq_score FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) AND qa.audit_type NOT IN ('$audit_excluded')")->result_array()[0]['cq_score'];
					array_push($weekly['total_defect']['weeklyData'], array(
						"week"=>$curr_week,
						"cq_score"=>$weeklyCQScore,
						"weeklyAuditCount"=>$weeklyCount,
						"fatalCount_$weekCounter"=>$fatalCounter,
						"week_$weekCounter" => $total_defect_sum
					));
					++$weekCounter;
				}
				//exit;
			}
			//Weekly Trend/Quality Bucket
			$monthlyAgent_Data = $this->db->query("SELECT COUNT(DISTINCT qa.agent_id) as total_agents FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')")->result_array()[0];
			$agentQuality_Data = $this->db->query("SELECT COUNT(qa.agent_id) as total_agentAudit, qa.agent_id, (SELECT SUM(qa_sub.overall_score) FROM $campaign qa_sub WHERE qa_sub.audit_type NOT IN ('$audit_excluded') AND MONTH(qa_sub.audit_date) = MONTH('$currentDate') AND YEAR(qa_sub.audit_date) = YEAR('$currentDate') AND qa_sub.agent_id = qa.agent_id GROUP BY qa_sub.agent_id) as agent_quality FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate') GROUP BY qa.agent_id")->result_array();
			
			$monthlyAudit = $this->db->query("SELECT COUNT(qa.id) as total_audit FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')")->result_array()[0];
			array_push($weekly['quality'], array(
				"total_cq"=>$monthlyData['total_cq'],
				"monthlyAgentData"=>$monthlyAgent_Data,
				"agentQuality_Data"=>$agentQuality_Data
			));
			
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Trend");
			$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "");
			$objWorksheet->setCellValue("B$rowCounter", "No of Audit");
			$objWorksheet->setCellValue("C$rowCounter", "Total Parameters");
			$objWorksheet->setCellValue("D$rowCounter", "Total Defect");
			$objWorksheet->setCellValue("E$rowCounter", "Defect(%)");
			$objWorksheet->setCellValue("F$rowCounter", "Fatal Defects");
			$objWorksheet->setCellValue("G$rowCounter", "Fatal Defect(%)");
			$objWorksheet->setCellValue("H$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:H$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			$weekCounter = 1;
			$monthlyData = $weekly['total_defect']['monthlyData'];
			foreach($monthlyData as $monthly){
				$objWorksheet->setCellValue("A$rowCounter", date("F", strtotime($currentDate)));
				$objWorksheet->setCellValue("B$rowCounter", $monthly['totalAudit']);
				$objWorksheet->setCellValue("C$rowCounter", count($paramsArray)*$monthly['totalAudit']);
				$objWorksheet->setCellValue("D$rowCounter", $monthly['total_defect']);
				$defect_percent = number_format(($monthly['total_defect']/(count($paramsArray)*$monthly['totalAudit']))*100, 2);
				$objWorksheet->setCellValue("E$rowCounter", $defect_percent."%");
				if($monthly['total_fatal'] != 0){
					$objWorksheet->setCellValue("F$rowCounter", $monthly['total_fatal']);
					$objWorksheet->setCellValue("G$rowCounter",(number_format((float)($monthly['total_fatal']/$monthly['total_defect'])*100, 2))."%");
				}else{
					$objWorksheet->setCellValue("F$rowCounter", "-");
					$objWorksheet->setCellValue("G$rowCounter", "0.00%");
				}
				$objWorksheet->setCellValue("H$rowCounter", number_format((float)($monthly['cq_score']/$monthly['monthlyData']['total_audit_ex']), 2)."%");
				++$rowCounter;
			}
			foreach($weekly['total_defect']['weeklyData'] as $week){
				$objWorksheet->setCellValue("A$rowCounter", "wk-".$week['week']."-".date("y", strtotime($currentDate)));
				$objWorksheet->setCellValue("B$rowCounter", $week['weeklyAuditCount']['weeklyCount']);
				$objWorksheet->setCellValue("C$rowCounter", count($paramsArray)*$week['weeklyAuditCount']['weeklyCount']);
				$objWorksheet->setCellValue("D$rowCounter", $week["week_$weekCounter"]);
				$defect_percent_weekly = number_format(($week["week_$weekCounter"]/(count($paramsArray)*$week['weeklyAuditCount']['weeklyCount_ex']))*100, 2);
				$objWorksheet->setCellValue("E$rowCounter", $defect_percent_weekly."%");
				$objWorksheet->setCellValue("F$rowCounter", $week["fatalCount_$weekCounter"]);
				if($week["week_$weekCounter"] != 0){
					$objWorksheet->setCellValue("G$rowCounter", (number_format((float)($week["fatalCount_$weekCounter"]/$week["week_$weekCounter"])*100, 2))."%");
				}else{
					$objWorksheet->setCellValue("G$rowCounter", "0.00%");
				}
				$objWorksheet->setCellValue("H$rowCounter", number_format($week['cq_score'], 2)."%");
				++$rowCounter;
				++$weekCounter;
			}
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Monthly Quality Bucket Evaluation");
			$objWorksheet->mergeCells("A$rowCounter:C$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;

			// New LOgic
			$bucket_sql = "SELECT qa.agent_id, ROUND(AVG(qa.overall_score), 2) as quality_score FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE MONTH(qa.audit_date)=MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate') AND qa.audit_type NOT IN ('$audit_excluded') GROUP BY qa.agent_id";
			$buckets = $this->db->query($bucket_sql)->result_array();
			$bucketCount = array("bucket0"=>0,"bucket1"=>0,"bucket2"=>0,"bucket3"=>0,"bucket4"=>0);
			// echo "<pre>";
			// print_r($buckets);
			foreach($buckets as $bucket){
				if($bucket['quality_score'] >= 90)++$bucketCount['bucket4'];
				else if($bucket['quality_score'] >= 80 && $bucket['quality_score'] < 90)++$bucketCount['bucket3'];
				else if($bucket['quality_score'] >= 60 && $bucketCount['quality_score'] < 80)++$bucketCount['bucket2'];
				else if($bucket['quality_score'] >= 30 && $bucketCount['quality_score'] < 60)++$bucketCount['bucket1'];
				else if($bucket['quality_score'] < 30)++$bucketCount['bucket0'];
			}
			$objWorksheet->setCellValue("A$rowCounter", "Quality Bucket");
			$objWorksheet->setCellValue("B$rowCounter", "Agent Count");
			$objWorksheet->setCellValue("C$rowCounter", "Contribution");
			$objWorksheet->getStyle("A$rowCounter:C$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			$qualityData = $weekly['quality'];
			$bucketType = array("<30%", "30% to 60%", "60% to 80%", "80% to 90%", ">90%");
			$bucketCounter = 0;
			$totalAgents = $qualityData[0]['monthlyAgentData']['total_agents'];
			foreach($bucketCount as $bucket){
				$objWorksheet->setCellValue("A$rowCounter", $bucketType[$bucketCounter]);
				$objWorksheet->setCellValue("B$rowCounter", $bucket);
				$objWorksheet->setCellValue("C$rowCounter", (number_format((float)(($bucket/$totalAgents)*100), 2))."%");
				++$bucketCounter;
				++$rowCounter;
			}

			$objWorksheet->getColumnDimension("A")->setAutoSize(true);
			$objWorksheet->getColumnDimension("B")->setAutoSize(true);
			$objWorksheet->getColumnDimension("C")->setAutoSize(true);
			$objWorksheet->getColumnDimension("D")->setAutoSize(true);
			$objWorksheet->getColumnDimension("E")->setAutoSize(true);
			$objWorksheet->getColumnDimension("F")->setAutoSize(true);
			$objWorksheet->getColumnDimension("G")->setAutoSize(true);
			$objWorksheet->getColumnDimension("H")->setAutoSize(true);
		}
		$path = "./assets/reports/Dunzo_OneView_Daily_Report.xlsx";
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save($path);
	}
	/**
	 * TODO: Function to create Daily Report [Weekly]
	 * ! Edited By Samrat 19-Jul-22
	 */
	private function createWeeklyReport(){
		$currentDate = date("Y-m-d");
		$search_process_id = 2;
		$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_boomsourcing_defect as q
		LEFT JOIN process as p ON p.id = q.process_id
		LEFT JOIN client as c ON c.id = q.client_id
		WHERE q.is_active = 1";
		$get_defect_columns = $this->db->query($sql_defect_columns)->result_array();
		
		for($index = 0; $index < count($get_defect_columns); $index++){
			if($index > 0){
				$this->objPHPExcel->createSheet();
			}
			$this->objPHPExcel->setActiveSheetIndex($index);
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle($get_defect_columns[$index]['process_name']);

			$campaign  =  trim($get_defect_columns[$index]['table_name']);

			$objWorksheet->setShowGridlines(true);
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
			$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 9,
					'name'  => 'Calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$audit_excluded = implode("','", $getExcluded_Audits);

			// CQ SCORE
			$sql_qaScore = "SELECT count(qa.id) as auditCount_ex, 
			(select count(qa.id) from $campaign as qa
				INNER JOIN signin as s ON s.id = qa.agent_id
				WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
				AND s.status=1) as auditCount,
			avg(qa.overall_score) as score
				FROM $campaign as qa
				INNER JOIN signin as s ON s.id = qa.agent_id
				WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
				AND qa.audit_type NOT IN ('$audit_excluded') AND s.status=1";
			$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
			
			$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
			$totalAuditCount = $c_auditCount;
			///$avgCQScore = round($c_qaScore['score']);
			$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
			
			// CQ FATAL
			$sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $campaign as qa
			INNER JOIN signin as s ON s.id = qa.agent_id
			WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')) AND qa.audit_type NOT IN ('$audit_excluded') AND overall_score = '0'";
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
			$paramColumns = $get_defect_columns[$index]['params_columns'];
			$paramsArray = explode(',', $paramColumns);
			$totalErrorCount = 0;
			
			// GET CUSTOM PARAMS
			$errorCheckGrant = true; 
			$errorNoCheck = "'0', 'No', 'no', 'Unacceptable', 'Fail', 'Absent', 'Action needed'";
			$errorYesCheck = "'1', 'Yes', 'yes', 'Acceptable', 'Pass', 'Awesome', 'Average'";
			$errorNACheck = "'N/A', 'NA', 'na', 'n/a'";
			$customParams = array();
			if($get_defect_columns[$index]['process_id'] == "171" || $get_defect_columns[$index]['process_id'] == "181"){
				$customParams = $this->custom_error_parameters($get_defect_columns[$index]['process_id']);
				$errorCheckGrant = false;
			}
			foreach($paramsArray as $token){
				//=== NO 
				$errorChecker = $errorNoCheck;
				if($token == 'misrepresentation'){
					$errorChecker = $errorYesCheck;
				}
				$sqlToken = "SELECT count(*) as auditCount from $campaign as qa INNER JOIN signin as s ON s.id = qa.agent_id
							WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) AND qa.$token IN (".$errorChecker.")";					
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
				
				
				$sqlToken = "SELECT count(*) as auditCount from $campaign as qa INNER JOIN signin as s ON s.id = qa.agent_id
							WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) AND (qa.$token IN (".$errorChecker."))";							
				$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
				$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
				$paramsPercent = 0;
				if($totalAuditCount > 0){
					$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
				}
				$params2['count'][$token]['yes'] = $c_ParamCount;
				$params2['percent'][$token]['yes'] = $paramsPercent;		
				
				
				//=== NA
				$sqlToken = "SELECT count(*) as auditCount from $campaign as qa INNER JOIN signin as s ON s.id = qa.agent_id
							WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) AND qa.$token IN (".$errorNACheck.")";
				$c_qaScore = $this->Common_model->get_query_row_array($sqlToken);
				$c_ParamCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;					
				$paramsPercent = 0;
				if($totalAuditCount > 0){
					$paramsPercent = sprintf('%.2f',($c_ParamCount / $totalAuditCount) * 100);
				}
				$params2['count'][$token]['na'] = $c_ParamCount;
				$params2['percent'][$token]['na'] = $paramsPercent;
			}

			$filename = "./assets/reports/OneView_Daily_Report.csv";
			$fopen = fopen($filename,"w+");

			//Date Wise
			$dateWise_sql = "SELECT COUNT(qa.id) as audit_count,
				qa.audit_date,
				(SELECT COUNT(qa1.id) 
				FROM $campaign qa1
				WHERE qa1.audit_date = qa.audit_date
				AND qa1.audit_type NOT IN ('$audit_excluded')) as audit_count_ex,
				(SELECT AVG(qa1.overall_score)
				FROM $campaign qa1
				WHERE qa1.audit_date = qa.audit_date
				AND qa1.audit_type NOT IN ('$audit_excluded')) as average_score
			FROM $campaign qa
			LEFT JOIN signin s ON s.id = qa.agent_id
			WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')
			GROUP BY qa.audit_date";
			// $dateWise_sql = "SELECT COUNT(qa.id) as audit_count, qa.audit_date, AVG(qa.overall_score) as average_score 
			// FROM $campaign qa 
			// INNER JOIN signin s ON s.id = qa.agent_id 
			// LEFT JOIN office_location l ON l.abbr = s.office_id 
			// WHERE (MONTH(qa.audit_date) = MONTH('$currentDate')) AND qa.audit_type IN ('CQ Audit', 'BQ Audit', 'OJT')
			// GROUP BY qa.audit_date";
			$date_wise = $this->Common_model->get_query_result_array($dateWise_sql);

			//Header Style Array
			$titleStyleArray = array(
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 9,
					'name'  => 'Calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '188ae2')
				)
			);
			$headerStyleArray = array(
				'font'  => array(
					'color' => array('rgb' => '000000'),
					'size'  => 9,
					'name'  => 'Calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '18dbe2')
				)
			);
			//Write Date Wise Header
			//Set Header
			$rowCounter = 1;
			$objWorksheet->setCellValue("A$rowCounter", "Date Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Date");
			$objWorksheet->setCellValue("C$rowCounter", "Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Date Wise Data
			if(count($date_wise) > 0){
				$counter = 1;
				foreach($date_wise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['audit_date']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}
			
			//Location Wise

			// New Location Wise Data [Logic]
			$location_sql = "SELECT COUNT(qa.id) as total_audit_count_ex,
				(select count(qa1.id) 
				FROM $campaign qa1 
				join signin si ON si.id=qa1.agent_id 
				where si.office_id = s.office_id AND (WEEK(qa1.audit_date) = WEEK('$currentDate') AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate'))
				) as total_audit_count,
				s.office_id,
				l.office_name, 
				ROUND(AVG(qa.overall_score), 2) as cq_score 
			FROM $campaign qa 
			INNER JOIN signin s ON s.id=qa.agent_id 
			LEFT JOIN office_location l ON l.abbr = s.office_id 
			WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))  
				AND qa.audit_type NOT IN ('$audit_excluded') 
			GROUP BY office_name";
			// $location_sql = "SELECT COUNT(qa.id) as total_audit_count,s.office_id,l.office_name, ROUND(AVG(qa.overall_score), 2) as cq_score FROM $campaign qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE MONTH(qa.audit_date) = MONTH('$currentDate') AND qa.audit_type IN ('CQ Audit', 'BQ Audit', 'OJT') GROUP BY office_name";
			$loc_locations = $this->db->query($location_sql)->result_array();
			
			$location_fatal_sql = "SELECT COUNT(qa.id) as fatal_count, s.office_id, l.office_name FROM $campaign qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr=s.office_id WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')) AND qa.audit_type NOT IN ('$audit_excluded') AND qa.overall_score=0 GROUP BY office_name";
			$location_fatal = $this->db->query($location_fatal_sql)->result_array();
			// $all_locations = $this->db->query("SELECT office_name FROM office_location l RIGHT JOIN signin s ON s.office_id=l.abbr INNER JOIN $campaign qa ON qa.agent_id=s.id")->result_array()[0];
			//echo "<pre>";print_r($all_locations);echo "</pre>";die;
			$location_Data = array(
				"generic"=>$loc_locations,
				"defect_count"=>array(),
				"total_parameters"=>count($paramsArray),
				"fatal_count"=>$location_fatal
			);
			foreach($paramsArray as $param){
				$agentDefect_sql = "SELECT COUNT(qa.id) as defect_count, l.office_name, qa.$param FROM $campaign qa INNER JOIN signin s ON s.id=qa.agent_id LEFT JOIN office_location l ON l.abbr=s.office_id WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date)=MONTH('$currentDate') AND YEAR(qa.audit_date)=YEAR('$currentDate')) AND qa.audit_type NOT IN ('$audit_excluded') AND (qa.$param IN ($errorNoCheck)) GROUP BY office_name";
				$agentDefect = $this->db->query($agentDefect_sql)->result_array();
				if(!empty($agentDefect))array_push($location_Data['defect_count'], $agentDefect);
			}

			//Write Location Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Location Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Location");
			$objWorksheet->setCellValue("C$rowCounter", "No of Audit");
			$objWorksheet->setCellValue("D$rowCounter", "Total Parameters");
			$objWorksheet->setCellValue("E$rowCounter", "Total Defects");
			$objWorksheet->setCellValue("F$rowCounter", "Total Defect %");
			$objWorksheet->setCellValue("G$rowCounter", "Fatal Count");
			$objWorksheet->setCellValue("H$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:H$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Location Date
			if(count($location_Data['generic']) == 0){
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:G$rowCounter");
				++$rowCounter;
			}else{
				$counter = 1;
				$total_defect_counts = array();
				$total_fatal_counts = array();
				foreach($location_Data['generic'] as $location){
					$total_defect_counts[$location['office_name']] = 0;
					$total_fatal_counts[$location['office_name']] = 0;
				}
				foreach($location_Data['defect_count'] as $defect){
					for($i = 0; $i < count($defect); $i++){
						$total_defect_counts[$defect[$i]['office_name']] += $defect[$i]['defect_count'];
					}
				}
				foreach($location_Data['fatal_count'] as $fatal)
					$total_fatal_counts[$fatal['office_name']] += $fatal['fatal_count'];
				foreach($location_Data['generic'] as $location){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $location['office_name']);
					$objWorksheet->setCellValue("C$rowCounter", $location['total_audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", count($paramsArray)*$location['total_audit_count']);
					$objWorksheet->setCellValue("E$rowCounter", $total_defect_counts[$location['office_name']]);
					$objWorksheet->setCellValue("F$rowCounter", number_format((float)($total_defect_counts[$location['office_name']]/($location['total_audit_count']*$location_Data['total_parameters']))*100, 2)."%");
					$objWorksheet->setCellValue("G$rowCounter", $total_fatal_counts[$location['office_name']]);
					$objWorksheet->setCellValue("H$rowCounter", $location['cq_score']."%");
					++$rowCounter;
				}
			}

			//Evaluator Wise
			$evaluator_sql = "SELECT COUNT(qa.id) as audit_count,
			(SELECT COUNT(qa_sub.id) FROM $campaign qa_sub INNER JOIN signin s ON s.id = qa_sub.entry_by
				LEFT JOIN office_location l ON l.abbr = s.office_id WHERE DATE(qa_sub.audit_date) = DATE('$currentDate') AND qa_sub.entry_by = qa.entry_by) as ftd_count,
			CONCAT(s.fname, ' ', s.lname) as auditor_name,
			(SELECT AVG(qa1.overall_score) FROM $campaign qa1 where qa.entry_by = qa1.entry_by and qa1.audit_type NOT IN ('$audit_excluded') and WEEK(qa1.audit_date) = WEEK('$currentDate') AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate')) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.entry_by
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY auditor_name";
			$evaluator_wise = $this->Common_model->get_query_result_array($evaluator_sql);

			//Write Evaluator Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Evaluator Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:E$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Evaluator Name");
			$objWorksheet->setCellValue("C$rowCounter", "WTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "FTD Audit Count");
			$objWorksheet->setCellValue("E$rowCounter", "WTD Quality Score");
			$objWorksheet->getStyle("A$rowCounter:E$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Evaluator Date
			if(count($evaluator_wise) > 0){
				$counter = 1;
				foreach($evaluator_wise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['auditor_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", $report['ftd_count']);
					$objWorksheet->setCellValue("E$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:E$rowCounter");
				++$rowCounter;
			}

			//TL Wise
			$tlWise_sql = "SELECT COUNT(qa.id) as audit_count, 
				CONCAT(s.fname, ' ', s.lname) as tl_name, 
				(SELECT AVG(qa1.overall_score) from $campaign qa1 where qa.tl_id = qa1.tl_id and qa1.audit_type NOT IN ('$audit_excluded') and WEEK(qa1.audit_date) = WEEK('$currentDate') AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate')) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.tl_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY tl_name";
			$tl_wise = $this->Common_model->get_query_result_array($tlWise_sql);

			//Write TL Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly TL Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "TL Name");
			$objWorksheet->setCellValue("C$rowCounter", "WTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write TL Data
			if(count($tl_wise) > 0){
				$counter = 1;
				foreach($tl_wise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['tl_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			//Agent Wise
			$agentWise_sql = "SELECT COUNT(qa.id) as audit_count, 
				CONCAT(s.fname, ' ', s.lname) as agent_name, 
				(select AVG(qa1.overall_score) 
				from $campaign qa1 
				where qa.agent_id = qa1.agent_id 
					and qa1.audit_type NOT IN ('$audit_excluded') 
					and (WEEK(qa1.audit_date) = WEEK('$currentDate') 
					AND MONTH(qa1.audit_date) = MONTH('$currentDate') 
					AND YEAR(qa1.audit_date) = YEAR('$currentDate'))
				) as average_score,
				(SELECT name FROM qa_channel_data WHERE id = s.channel_id) as channel_name,
				(SELECT name FROM qa_vertical_data WHERE id = s.vertical_id) as vertical_name
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.agent_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY agent_name";
			$agentWise = $this->Common_model->get_query_result_array($agentWise_sql);

			//Write Agent Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Agent Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:F$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Agent Name");
			$objWorksheet->setCellValue("C$rowCounter", "Channel Name");
			$objWorksheet->setCellValue("D$rowCounter", "Vertical Name");
			$objWorksheet->setCellValue("E$rowCounter", "WTD Audit Count");
			$objWorksheet->setCellValue("F$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:F$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Agent Data
			if(count($agentWise) > 0){
				$counter = 1;
				foreach($agentWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['agent_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['channel_name']);
					$objWorksheet->setCellValue("D$rowCounter", $report['vertical_name']);
					$objWorksheet->setCellValue("E$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("F$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			//Vertical Wise
			$verticalWise_sql = "SELECT COUNT(qa.id) as audit_count, (SELECT vert.name FROM qa_vertical_data vert WHERE vert.id = s.vertical_id) as vertical_name, (select AVG(qa1.overall_score) from $campaign qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and (WEEK(qa1.audit_date) = WEEK('$currentDate') AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate'))) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.agent_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY vertical_name";
			$verticalWise = $this->Common_model->get_query_result_array($verticalWise_sql);

			//Write Vertical Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Vertical Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Vertical Name");
			$objWorksheet->setCellValue("C$rowCounter", "WTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Vertical Data
			if(count($verticalWise) > 0){
				$counter = 1;
				foreach($verticalWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['vertical_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			//Channel Wise
			$channelWise_sql = "SELECT COUNT(qa.id) as audit_count, (SELECT channel.name FROM qa_channel_data channel WHERE channel.id = s.channel_id) as channel_name, (select AVG(qa1.overall_score) from $campaign qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and (WEEK(qa1.audit_date) = WEEK('$currentDate') AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate'))) as average_score
			FROM $campaign qa
			INNER JOIN signin s ON s.id = qa.agent_id
			LEFT JOIN office_location l ON l.abbr = s.office_id
			WHERE (WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate'))
			GROUP BY channel_name";
			$channelWise = $this->Common_model->get_query_result_array($channelWise_sql);

			//Write Channel Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Channel Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Channel Name");
			$objWorksheet->setCellValue("C$rowCounter", "WTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Channel Data
			if(count($channelWise) > 0){
				$counter = 1;
				foreach($channelWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['channel_name']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			// Tenurity Wise
			$tenurityWise_sql = "SELECT COUNT(qa.id) as audit_count,
				(DATEDIFF(DATE(NOW()), DATE(s.created_date))) as tenurity,
				(select AVG(qa1.overall_score) from $campaign qa1 where qa.agent_id = qa1.agent_id and qa1.audit_type NOT IN ('$audit_excluded') and WEEK(qa1.audit_date) = WEEK('$currentDate') AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR('$currentDate')) as average_score
			FROM $campaign qa
			LEFT JOIN signin s ON s.id = qa.agent_id
			WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')
			GROUP BY tenurity";
			$tenurityWise = $this->Common_model->get_query_result_array($tenurityWise_sql);
			//Write Channel Header
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Tenure Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Tenure");
			$objWorksheet->setCellValue("C$rowCounter", "MTD Audit Count");
			$objWorksheet->setCellValue("D$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:D$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			//Write Channel Data
			if(count($tenurityWise) > 0){
				$counter = 1;
				foreach($tenurityWise as $report){
					$objWorksheet->setCellValue("A$rowCounter", $counter++);
					$objWorksheet->setCellValue("B$rowCounter", $report['tenurity']);
					$objWorksheet->setCellValue("C$rowCounter", $report['audit_count']);
					$objWorksheet->setCellValue("D$rowCounter", number_format((float)$report['average_score'], 2)."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:D$rowCounter");
				++$rowCounter;
			}

			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Parameter Wise Data");
			$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "#");
			$objWorksheet->setCellValue("B$rowCounter", "Overall Parameters");
			$objWorksheet->setCellValue("C$rowCounter", "Yes");
			$objWorksheet->setCellValue("D$rowCounter", "No");
			$objWorksheet->setCellValue("E$rowCounter", "NA");
			$objWorksheet->setCellValue("F$rowCounter", "Grand Total");
			$objWorksheet->setCellValue("G$rowCounter", "Score%");
			$objWorksheet->setCellValue("H$rowCounter", "Error Count%");
			$objWorksheet->getStyle("A$rowCounter:H$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			if(count($paramsArray) > 0){
				$cn = 1;
				foreach($paramsArray as $token){
					$objWorksheet->setCellValue("A$rowCounter", $cn++);
					$objWorksheet->setCellValue("B$rowCounter", $token);
					$objWorksheet->setCellValue("C$rowCounter", $params2['count'][$token]['yes']);
					$objWorksheet->setCellValue("D$rowCounter", $params2['count'][$token]['no']);
					$objWorksheet->setCellValue("E$rowCounter", $params2['count'][$token]['na']);
					$objWorksheet->setCellValue("F$rowCounter", ($params2['count'][$token]['yes'] + $params2['count'][$token]['no'] + $params2['count'][$token]['na']));
					$objWorksheet->setCellValue("G$rowCounter", $params2['percent'][$token]['yes']."%");
					$objWorksheet->setCellValue("H$rowCounter", $params2['percent'][$token]['no']."%");
					++$rowCounter;
				}
			}else{
				$objWorksheet->setCellValue("A$rowCounter", "No Data Found");
				$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
				++$rowCounter;
			}

			//Weekly Trend
			$weekly_sql = "SELECT WEEK(qa.audit_date) as currWeek, COUNT(qa.id) FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) GROUP BY WEEK(qa.audit_date)";
			$weekly_audit_count = $this->db->query($weekly_sql)->result_array();
			$weekly['month_name'] = date("F", strtotime($currentDate));
			$weekly['total_defect']['no_of_weeks'] = count($weekly_audit_count);
			$weekly['total_defect']['weeklyData'] = array();
			$weekly['total_defect']['monthlyData'] = array();
			$weekly['quality'] = array();
			$fatal_params = $get_defect_columns[$index]['fatal_param'];
			$fatal_paramsArray = explode(",", $fatal_params);
			//Monthly Data
			$monthlyData = $this->db->query("SELECT COUNT(qa.id) as total_audit_ex,(select count(qa.id) from $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate')) as total_audit, SUM(qa.overall_score) as total_cq FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate') AND qa.audit_type NOT IN ('$audit_excluded')")->result_array()[0];

			$totalMonthlyDefect = 0;
			foreach($paramsArray as $token){
				$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE (qa.$token IN ('No', 'Fail')) AND WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) AND YEAR('$currentDate') AND qa.audit_type NOT IN ('$audit_excluded')";
				//echo "<pre>";
				//print_r($this->db->query($defect_sql)->result_array());echo "</pre>";
				$totalMonthlyDefect += $this->db->query($defect_sql)->result_array()[0]['def_count'];
			}
			$MonthlyfatalCounter = 0;
			foreach($fatal_paramsArray as $fatal_param){
				$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND (qa.$fatal_param IN ('No')) AND qa.audit_type NOT IN ('$audit_excluded')";
				$MonthlyfatalCounter += $this->db->query($defect_sql)->result_array()[0]['fatal_count'];
			}
			array_push($weekly['total_defect']['monthlyData'], array(
				"totalAudit"=>$monthlyData['total_audit'],
				"total_defect"=>$totalMonthlyDefect,
				"total_fatal"=>$MonthlyfatalCounter,
				"cq_score"=>$monthlyData['total_cq'],
				"monthlyData"=>$monthlyData
			));
			//Weekly Data
			if(count($weekly_audit_count) > 0){
				$weekCounter = 1;
				foreach($weekly_audit_count as $week){
					$total_defect_sum = 0;
					$curr_week = $week['currWeek'];
					foreach($paramsArray as $token){
						$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $campaign qa LEFT JOIN signin s ON s.id = qa.agent_id WHERE (qa.$token IN ('No', 'Fail')) AND WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) AND qa.audit_type NOT IN ('$audit_excluded')";
						$total_defect_sum += $this->db->query($defect_sql)->result_array()[0]['def_count'];
					}
					$fatalCounter = 0;
					foreach($fatal_paramsArray as $fatal_param){
						$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) AND (qa.$fatal_param IN ('No')) AND qa.audit_type NOT IN ('$audit_excluded')";
						$fatalCounter += $this->db->query($defect_sql)->result_array()[0]['fatal_count'];
					}
					$weeklyCount = $this->db->query("SELECT COUNT(qa.id) as weeklyCount, (SELECT COUNT(qa1.id) FROM $campaign qa1 WHERE WEEK(qa1.audit_date) = '$curr_week' AND MONTH(qa1.audit_date) = MONTH('$currentDate') AND YEAR(qa1.audit_date) = YEAR(NOW()) AND qa1.audit_type NOT IN ('$audit_excluded')) as weeklyCount_ex FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date)='$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')")->result_array()[0];
					$weeklyCQScore = $this->db->query("SELECT AVG(qa.overall_score) as cq_score FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = '$curr_week' AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR(NOW()) AND qa.audit_type NOT IN ('$audit_excluded')")->result_array()[0]['cq_score'];
					array_push($weekly['total_defect']['weeklyData'], array(
						"week"=>$curr_week,
						"cq_score"=>$weeklyCQScore,
						"weeklyAuditCount"=>$weeklyCount,
						"fatalCount_$weekCounter"=>$fatalCounter,
						"week_$weekCounter" => $total_defect_sum
					));
					++$weekCounter;
				}
				//exit;
			}
			//Weekly Trend/Quality Bucket
			$monthlyAgent_Data = $this->db->query("SELECT COUNT(DISTINCT qa.agent_id) as total_agents FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')")->result_array()[0];
			$agentQuality_Data = $this->db->query("SELECT COUNT(qa.agent_id) as total_agentAudit, qa.agent_id, (SELECT SUM(qa_sub.overall_score) FROM $campaign qa_sub WHERE qa_sub.audit_type NOT IN ('$audit_excluded') AND WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa_sub.audit_date) = MONTH('$currentDate') AND YEAR(qa_sub.audit_date) = YEAR('$currentDate') AND qa_sub.agent_id = qa.agent_id GROUP BY qa_sub.agent_id) as agent_quality FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate') GROUP BY qa.agent_id")->result_array();
			
			$monthlyAudit = $this->db->query("SELECT COUNT(qa.id) as total_audit FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date) = MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate')")->result_array()[0];
			array_push($weekly['quality'], array(
				"total_cq"=>$monthlyData['total_cq'],
				"monthlyAgentData"=>$monthlyAgent_Data,
				"agentQuality_Data"=>$agentQuality_Data
			));
			
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Trend");
			$objWorksheet->mergeCells("A$rowCounter:H$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "");
			$objWorksheet->setCellValue("B$rowCounter", "No of Audit");
			$objWorksheet->setCellValue("C$rowCounter", "Total Parameters");
			$objWorksheet->setCellValue("D$rowCounter", "Total Defect");
			$objWorksheet->setCellValue("E$rowCounter", "Defect(%)");
			$objWorksheet->setCellValue("F$rowCounter", "Fatal Defects");
			$objWorksheet->setCellValue("G$rowCounter", "Fatal Defect(%)");
			$objWorksheet->setCellValue("H$rowCounter", "Quality Score");
			$objWorksheet->getStyle("A$rowCounter:H$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			$weekCounter = 1;
			$monthlyData = $weekly['total_defect']['monthlyData'];
			foreach($monthlyData as $monthly){
				$objWorksheet->setCellValue("A$rowCounter", date("F", strtotime($currentDate)));
				$objWorksheet->setCellValue("B$rowCounter", $monthly['totalAudit']);
				$objWorksheet->setCellValue("C$rowCounter", count($paramsArray)*$monthly['totalAudit']);
				$objWorksheet->setCellValue("D$rowCounter", $monthly['total_defect']);
				$defect_percent = number_format(($monthly['total_defect']/(count($paramsArray)*$monthly['totalAudit']))*100, 2);
				$objWorksheet->setCellValue("E$rowCounter", $defect_percent."%");
				if($monthly['total_fatal'] != 0){
					$objWorksheet->setCellValue("F$rowCounter", $monthly['total_fatal']);
					$objWorksheet->setCellValue("G$rowCounter",(number_format((float)($monthly['total_fatal']/$monthly['total_defect'])*100, 2))."%");
				}else{
					$objWorksheet->setCellValue("F$rowCounter", "-");
					$objWorksheet->setCellValue("G$rowCounter", "0.00%");
				}
				$objWorksheet->setCellValue("H$rowCounter", number_format((float)($monthly['cq_score']/$monthly['monthlyData']['total_audit_ex']), 2)."%");
				++$rowCounter;
			}
			foreach($weekly['total_defect']['weeklyData'] as $week){
				$objWorksheet->setCellValue("A$rowCounter", "wk-".$week['week']."-".date("y", strtotime($currentDate)));
				$objWorksheet->setCellValue("B$rowCounter", $week['weeklyAuditCount']['weeklyCount']);
				$objWorksheet->setCellValue("C$rowCounter", count($paramsArray)*$week['weeklyAuditCount']['weeklyCount']);
				$objWorksheet->setCellValue("D$rowCounter", $week["week_$weekCounter"]);
				$defect_percent_weekly = number_format(($week["week_$weekCounter"]/(count($paramsArray)*$week['weeklyAuditCount']['weeklyCount_ex']))*100, 2);
				$objWorksheet->setCellValue("E$rowCounter", $defect_percent_weekly."%");
				$objWorksheet->setCellValue("F$rowCounter", $week["fatalCount_$weekCounter"]);
				if($week["week_$weekCounter"] != 0){
					$objWorksheet->setCellValue("G$rowCounter", (number_format((float)($week["fatalCount_$weekCounter"]/$week["week_$weekCounter"])*100, 2))."%");
				}else{
					$objWorksheet->setCellValue("G$rowCounter", "0.00%");
				}
				$objWorksheet->setCellValue("H$rowCounter", number_format($week['cq_score'], 2)."%");
				++$rowCounter;
				++$weekCounter;
			}
			++$rowCounter;
			$objWorksheet->setCellValue("A$rowCounter", "Weekly Quality Bucket Evaluation");
			$objWorksheet->mergeCells("A$rowCounter:C$rowCounter");
			$objWorksheet->getStyle("A$rowCounter")->getFont()->setSize(16);
			$objWorksheet->getStyle("A$rowCounter")->applyFromArray($titleStyleArray);
			++$rowCounter;

			// New LOgic
			$bucket_sql = "SELECT qa.agent_id, ROUND(AVG(qa.overall_score), 2) as quality_score FROM $campaign qa LEFT JOIN signin s ON s.id=qa.agent_id WHERE WEEK(qa.audit_date) = WEEK('$currentDate') AND MONTH(qa.audit_date)=MONTH('$currentDate') AND YEAR(qa.audit_date) = YEAR('$currentDate') AND qa.audit_type NOT IN ('$audit_excluded') GROUP BY qa.agent_id";
			$buckets = $this->db->query($bucket_sql)->result_array();
			$bucketCount = array("bucket0"=>0,"bucket1"=>0,"bucket2"=>0,"bucket3"=>0,"bucket4"=>0);
			// echo "<pre>";
			// print_r($buckets);
			foreach($buckets as $bucket){
				if($bucket['quality_score'] >= 90)++$bucketCount['bucket4'];
				else if($bucket['quality_score'] >= 80 && $bucket['quality_score'] < 90)++$bucketCount['bucket3'];
				else if($bucket['quality_score'] >= 60 && $bucketCount['quality_score'] < 80)++$bucketCount['bucket2'];
				else if($bucket['quality_score'] >= 30 && $bucketCount['quality_score'] < 60)++$bucketCount['bucket1'];
				else if($bucket['quality_score'] < 30)++$bucketCount['bucket0'];
			}
			$objWorksheet->setCellValue("A$rowCounter", "Quality Bucket");
			$objWorksheet->setCellValue("B$rowCounter", "Agent Count");
			$objWorksheet->setCellValue("C$rowCounter", "Contribution");
			$objWorksheet->getStyle("A$rowCounter:C$rowCounter")->applyFromArray($headerStyleArray);
			++$rowCounter;
			$qualityData = $weekly['quality'];
			$bucketType = array("<30%", "30% to 60%", "60% to 80%", "80% to 90%", ">90%");
			$bucketCounter = 0;
			$totalAgents = $qualityData[0]['monthlyAgentData']['total_agents'];
			foreach($bucketCount as $bucket){
				$objWorksheet->setCellValue("A$rowCounter", $bucketType[$bucketCounter]);
				$objWorksheet->setCellValue("B$rowCounter", $bucket);
				$objWorksheet->setCellValue("C$rowCounter", (number_format((float)(($bucket/$totalAgents)*100), 2))."%");
				++$bucketCounter;
				++$rowCounter;
			}

			$objWorksheet->getColumnDimension("A")->setAutoSize(true);
			$objWorksheet->getColumnDimension("B")->setAutoSize(true);
			$objWorksheet->getColumnDimension("C")->setAutoSize(true);
			$objWorksheet->getColumnDimension("D")->setAutoSize(true);
			$objWorksheet->getColumnDimension("E")->setAutoSize(true);
			$objWorksheet->getColumnDimension("F")->setAutoSize(true);
			$objWorksheet->getColumnDimension("G")->setAutoSize(true);
			$objWorksheet->getColumnDimension("H")->setAutoSize(true);
		}
		$path = "./assets/reports/Dunzo_OneView_Weekly_Report.xlsx";
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save($path);
	}
	/**
	 * TODO: Function for autoEmail Trigger
	 * Edited By Samrat 30-May-22
	 */
	public function emailMyReport(){
		$this->createDailyReport();
		$filename = "./assets/reports/Dunzo_OneView_Daily_Report.xlsx";
		$file_name = "One View Daily Report.xlsx";
		// header('Content-Disposition: attachment; filename='.$file_name);
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//readfile($filename);
		$currentDate = date("Y-m-d");
		//Prepare to send the mail
		//Get email address from 'signin' table
		$fusion_id = "FBLR000008";
		$email_address = $this->db->query("SELECT ip.email_id_off as '1', ip.email_id_per as '2' FROM info_personal ip LEFT JOIN signin s ON s.id = ip.user_id WHERE s.fusion_id='$fusion_id'")->result_array();
		$ccEmail_FusionID = "FBLR000107";
		$cc_email_address = $this->db->query("SELECT ip.email_id_off as '1', ip.email_id_per as '2' FROM info_personal ip LEFT JOIN signin s ON s.id = ip.user_id WHERE s.fusion_id='$ccEmail_FusionID'")->result_array();
		$to = 'deb.dasgupta@omindtech.com, somnath.bhattacharya@omindtech.com';
		//$to = $email_address[0][$i];
		$ebody = "Hi,\r\n\r\n";
		$ebody .= "Please find the One View Daily Report attached.";
		$esubject = "Dunzo - One View Daily Report for $currentDate";
		$date=date("Y-m-d");
		$ecc = "samrat.bhadra@omindtech.com";
		//$ecc="deepali.yadav@fusionbposervices.com, sumitra.bagchi@omindtech.com, samrat.bhadra@omindtech.com, somu.b@fusionbposervices.com, krishanu.roychoudhury@fusionbposervices.com";
		// Send the mail
		$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $filename, $from_email, $from_name, $isBcc="Y");
		// for($i = 1; $i <= count($email_address[0]); $i++){
		// 	//$to = 'samrat.bhadra@omindtech.com';
		// 	$to = $email_address[0][$i];
		// 	$ebody = "Hi,\r\n\r\n";
		// 	$ebody .= "Please find the One View Daily Report attached.\r\n\r\n";
		// 	$ebody .= "With regards,\r\n";
		// 	$ebody .= "Digit MWP Team";
		// 	$esubject = "One View Daily Report for $currentDate";
		// 	$date=date("Y-m-d");
		// 	$ecc="deepali.yadav@fusionbposervices.com, somu.b@fusionbposervices.com,".$cc_email_address[0][1];
		// 	//Send the mail
		// 	$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $filename, $from_email, $from_name, $isBcc="Y");
		// }
	}
	public function emailMyWeeklyReport(){
		$this->createWeeklyReport();
		$filename = "./assets/reports/Dunzo_OneView_Weekly_Report.xlsx";
		$file_name = "One View Daily Report[weekly].xlsx";
		// header('Content-Disposition: attachment; filename='.$file_name);
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//readfile($filename);
		$currentDate = date("Y-m-d");
		$date = new DateTime($currentDate);
		$week = $date->format("W");
		$prevSunday = date("Y-m-d", strtotime("monday this week"));
		$nextSunday = date("Y-m-d", strtotime("sunday this week"));
		//Prepare to send the mail
		//Get email address from 'signin' table
		$fusion_id = "FBLR000008";
		$email_address = $this->db->query("SELECT ip.email_id_off as '1', ip.email_id_per as '2' FROM info_personal ip LEFT JOIN signin s ON s.id = ip.user_id WHERE s.fusion_id='$fusion_id'")->result_array();
		$ccEmail_FusionID = "FBLR000107";
		$cc_email_address = $this->db->query("SELECT ip.email_id_off as '1', ip.email_id_per as '2' FROM info_personal ip LEFT JOIN signin s ON s.id = ip.user_id WHERE s.fusion_id='$ccEmail_FusionID'")->result_array();
		$to = 'deb.dasgupta@omindtech.com, somnath.bhattacharya@omindtech.com';
		//$to = 'deb.dasgupta@omindtech.com';
		//$to = $email_address[0][$i];
		$ebody = "Please find the One View Weekly Report attached.".PHP_EOL;
		$esubject = "Dunzo - One View Weekly Report [$prevSunday - $nextSunday]";
		$date=date("Y-m-d");
		$ecc = "samrat.bhadra@omindtech.com";
		//$ecc="deepali.yadav@fusionbposervices.com, sumitra.bagchi@omindtech.com, samrat.bhadra@omindtech.com, somu.b@fusionbposervices.com, krishanu.roychoudhury@fusionbposervices.com";
		// Send the mail
		$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $filename, $from_email, $from_name, $isBcc="Y");
		// for($i = 1; $i <= count($email_address[0]); $i++){
		// 	//$to = 'samrat.bhadra@omindtech.com';
		// 	$to = $email_address[0][$i];
		// 	$ebody = "Hi,\r\n\r\n";
		// 	$ebody .= "Please find the One View Daily Report attached.\r\n\r\n";
		// 	$ebody .= "With regards,\r\n";
		// 	$ebody .= "Digit MWP Team";
		// 	$esubject = "One View Daily Report for $currentDate";
		// 	$date=date("Y-m-d");
		// 	$ecc="deepali.yadav@fusionbposervices.com, somu.b@fusionbposervices.com,".$cc_email_address[0][1];
		// 	//Send the mail
		// 	$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $filename, $from_email, $from_name, $isBcc="Y");
		// }
	}
	//==========================================================================================//
	//            MANAGER LEVEL
	//==========================================================================================//
	public function search_campaign_ajax(){
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
			
			$SQLtxt = "SELECT process_id as id, REPLACE(REPLACE(REPLACE(table_name, 'qa_',''), '_feedback', ''), '_', ' ') as name FROM qa_boomsourcing_defect where 1 $extraFilter  order by name";
			
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
	
	public function accessClientIds(){
		$result = "1";
		return $result;
	}

}


