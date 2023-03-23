<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_acceptance_new extends CI_Controller {


	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');
		$this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();
		//error_reporting(1);
		//ini_set('display_errors', 1);
		//$this->db->db_debug=true;

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
			$data['process_list'] = array();

			// ============  FILTER OFFICE ========================================//

			$search_office[] = $user_office_id;
			if(!empty($this->input->get('select_office'))){
				$search_office = $this->input->get('select_office');

				$search_office_string =implode("','", $search_office);
			}
			$data['selected_office'] = $search_office;

			// ============  FILTER PROCESS ========================================//

			$search_process_id = "";
			$search_process_id = $this->input->get('select_process')?$this->input->get('select_process'):2;

			// if(!empty($this->input->get('select_process'))){
			// 	$search_process_id = $this->input->get('select_process');
			// }
			$data['selected_process'] = $search_process_id;


			/* Process list start*/
			$sqlNewProcess = "SELECT id, name as process_name FROM process where id !=0 ";

			$data['process_list_new'] = $NewProcess = $this->Common_model->get_query_result_array($sqlNewProcess);
			/* Process list end*/
			$data['lobs'] = $this->db->query("SELECT id, campaign FROM campaign WHERE is_active = 1 and process_id=".$search_process_id)->result();
			$data['selected_lob'] = $lob = $this->input->get("lob");

			//===================== DROPDOWN FILTERS ======================================//

			$search_client_id = "";
			if(!empty($this->input->get('select_client'))){
				$search_client_id = $this->input->get('select_client');
			}
			$data['selected_client'] = $search_client_id;




			//===================== USER DROPDOWN FILTERS ======================================//
			$extraFilter = "";
			if(!empty($search_process_id) && $search_process_id != 'ALL'){
				$extraFilter .= " AND is_assign_process(s.id, $search_process_id) ";
			}

			if($lob != "" && !in_array("ALL", $lob))
			{
				$lob_implode = implode("','", $lob);
				$extraFilter .= "AND s.assigned_campaign IN ('$lob_implode')";
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

			// $SQLtxt = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id FROM signin as s
			//           LEFT JOIN role as r ON r.id = s.role_id
			// 		  LEFT JOIN signin as sl ON sl.id = s.assigned_to
			// 		  where 1 AND r.folder='tl' $extraFilter order by fullname";

			$SQLtxt = "Select s.id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname from signin s where s.status=1 and s.role_id not in (select r.id from role r where r.folder='agent') AND s.dept_id = 6 AND s.office_id IN ('BLR')  order by fullname asc ";
			//echo $SQLtxt;
			//exit();
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
					  where 1 AND r.folder='agent' and s.dept_id = 6 $extraFilter order by fullname";
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
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);


			//===================== CALCULATE ======================================//

			if(!empty($search_process_id))
			{
				// GET DEFECT TABLES

				//$lob = $this->input->get("lob");
				if($search_process_id == 1){
					$lob_id=implode('","', $lob);
					 // $sql_defect_columns = $this->db->query('SELECT table_name, process_id, params_columns,fatal_param FROM qa_defect Where campaign_id in ("'.$lob_id.'")');

				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.campaign_id in ($lob_id)";
				}else if($search_process_id == 2){
					$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_process_id'";
				}
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);

			//	exit;
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
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit'  $extraUserFilter";
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
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND overall_score = '0'  $extraUserFilter";
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
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= 64 $extraUserFilter GROUP BY qa.agent_id";
				$c_bucket = $this->Common_model->get_query_result_array($sql_bucket);
				$c_bucketCount[$currentBucket] = !empty($c_bucket) ? count($c_bucket) : 0;
				//echo "<pre>".print_r($c_bucket, 1)."</pre>";die();

				$currentBucket = "2";
				/* $sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= 55 AND qa.overall_score < 64 $extraUserFilter GROUP BY qa.agent_id"; */
				$sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= 55 AND qa.overall_score < 64 $extraUserFilter GROUP BY qa.agent_id";
				$c_bucket = $this->Common_model->get_query_result_array($sql_bucket);
				$c_bucketCount[$currentBucket] = !empty($c_bucket) ? count($c_bucket) : 0;

				$currentBucket = "3";
				/* $sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.overall_score < 55 $extraUserFilter GROUP BY qa.agent_id"; */
				$sql_bucket = "SELECT count(*) as auditCount, qa.agent_id from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id LEFT JOIN signin as sl ON sl.id = s.assigned_to
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $locFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score < 55 $extraUserFilter GROUP BY qa.agent_id";

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
									$locFilter AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorChecker.")  $extraUserFilter";

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
									$locFilter AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorChecker.")  $extraUserFilter GROUP BY qa.agent_id ORDER BY auditCount DESC LIMIT 5";

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


			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "Qa_acceptance_new/qa_program_level.php";
			$data["content_js"] = "Qa_acceptance_new/qa_program_level_js.php";
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

		 $fetch_user_sql = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id, rl.folder
		FROM `signin` s LEFT JOIN `role` rl ON rl.id=s.role_id WHERE 1 $condition AND rl.folder!='agent' AND s.dept_id = 6 order by fullname";
		$json_array = $this->Common_model->get_query_result_array($fetch_user_sql);
		echo json_encode($json_array);
	}

	public function select_user_agent(){
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

		 $fetch_user_sql = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id, rl.folder
		FROM `signin` s LEFT JOIN `role` rl ON rl.id=s.role_id WHERE 1 $condition AND rl.folder ='agent' AND s.dept_id = 6 order by fullname";
		$json_array = $this->Common_model->get_query_result_array($fetch_user_sql);
		echo json_encode($json_array);
	}


	//==========================================================================================//
	//            DEFECT LEVEL
	//==========================================================================================//

	public function defect_level()
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
			if(!empty($this->input->get('select_office'))){
				$search_office = $this->input->get('select_office');
				if(in_array('ALL',$search_office)){
					$office_str="";
				}else{
					$office_str=implode("','",$search_office);
				}
			}
			$data['selected_office'] = $search_office;

			// ============  FILTER PROCESS ========================================//

			$search_process_id = "";
			if(!empty($this->input->get('select_process'))){
				$search_process_id = $this->input->get('select_process');
			}
			$data['selected_process'] = $search_process_id;



			//===================== DROPDOWN FILTERS ======================================//

			$search_client_id = "";
			if(!empty($this->input->get('select_client'))){
				$search_client_id = $this->input->get('select_client');
			}
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
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id WHERE q.client_id IN ($my_client_ids)  AND q.process_id NOT IN ('304') ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);


			//===================== CALCULATE ======================================//

			if(!empty($search_process_id))
			{
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
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
					$offCondi="";
					if(!empty($office_str)){
					 $offCondi .= "AND s.office_id IN ('".$office_str."')";
					}
				// office condition - office multiselect - 17-03-22

				// CQ SCORE
				$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $offCondi AND qa.audit_type = 'CQ Audit'";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				///$avgCQScore = round($c_qaScore['score']);
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);

				// CQ FATAL
				$sql_qaScore = "SELECT count(*) as auditCount, SUM(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $offCondi AND qa.audit_type = 'CQ Audit' AND overall_score = '0'";
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

					$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
								$offCondi AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorChecker.")";
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

					$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
								$offCondi AND qa.audit_type = 'CQ Audit' AND (qa.$token IN (".$errorChecker."))";
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
								$offCondi AND qa.audit_type = 'CQ Audit' AND qa.$token IN (".$errorNACheck.")";
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


			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "Qa_acceptance_new/qa_defect_level.php";
			$data["content_js"] = "Qa_acceptance_new/qa_defect_level_js.php";

			$this->load->view('dashboard',$data);

		}

	}



	//==========================================================================================//
	//            TENDER LEVEL
	//==========================================================================================//

	public function tender_level()
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

			// ============  FILTER DATE ========================================//

			$search_month = date('m');
			$search_year = date('Y');
			$start_time = "00:00:00";
			$end_time = "23:59:59";

			if(!empty($this->input->post('select_month'))){ $search_month = $this->input->post('select_month'); }
			if(!empty($this->input->post('select_year'))){ $search_year = $this->input->post('select_year'); }
			if(!empty($this->input->get('select_month'))){ $search_month = $this->input->get('select_month'); }
			if(!empty($this->input->get('select_year'))){ $search_year = $this->input->get('select_year'); }
			$process_id = $this->input->get('process_id')?$this->input->get('process_id'):2;
			$data['process_id'] = $process_id;

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
			if(!empty($this->input->get('select_office'))){
				$search_office = $this->input->get('select_office');
				if(in_array('ALL',$search_office)){
					$office_str="";
				}else{
					$office_str=implode("','",$search_office);
				}
			}
			$data['selected_office'] = $search_office;

			// ============  FILTER PROCESS ========================================//

			/* $process_id = "";
			if(!empty($this->input->get('process_id'))){
				$process_id = $this->input->get('process_id');
			}
			$data['process_id'] = $process_id;*/

			//===================== DROPDOWN FILTERS ======================================//

			/* $search_client_id = "";
			if(!empty($this->input->get('select_client'))){
				$search_client_id = $this->input->get('select_client');
			}
			$data['selected_client'] = $search_client_id;

			// Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client; */

			// Office Selection
			if($is_global_access==1 || (get_dept_folder()=="qa" and get_role_dir()=="manager")){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}

			// Process Selection
			/* $sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id WHERE q.client_id IN ($my_client_ids) ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess); */

			/* Process list start*/
			$sqlNewProcess = "SELECT id, name as process_name FROM process where id !=0 ";
			$data['process_list'] = $NewProcess = $this->Common_model->get_query_result_array($sqlNewProcess);
			/* Process list end*/
			$data['lobs'] = $this->db->query("SELECT id, campaign FROM campaign WHERE is_active = 1 and process_id=".$process_id)->result();
			//===================== CALCULATE ======================================//

			if(!empty($process_id))
			{
				// GET DEFECT TABLES
				/* $sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$process_id'";
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns); */
				$data['selected_lob'] = $lob = $this->input->get("lob");
				if($process_id == 1){
					$lob_id=implode('","', $lob);
					$query = $this->db->query('SELECT table_name, process_id, params_columns,fatal_param FROM qa_defect Where campaign_id in ("'.$lob_id.'")');
				}else if($process_id == 2){
					$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name,fatal_param as process_name FROM qa_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id)');
				}
				$row = $query->row();

				//$c_defect_table  =  trim($get_defect_columns['table_name']);
				$c_defect_table  = $row->table_name;
				$lobCond = "";
				if($lob != "" && !in_array("ALL", $lob)){
					$lob_implode = implode("','", $lob);
					$lobCond = "AND s.assigned_campaign IN ('$lob_implode')";
				}

				/* $tableFound = false;
				$dbName = $this->db->database;
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$c_defect_table'";
				$countCheck = $this->Common_model->get_single_value($sqlCheck);
				if($countCheck > 0){ $tableFound = true; } */

				//if($tableFound){

				// office condition - office multiselect - 17-03-22
					$offCondi="";
					if(!empty($office_str)){
					$offCondi .= "AND s.office_id IN ('".$office_str."')";
					}
				// office condition - office multiselect - 17-03-22
				$audit_excluded = implode("','", getExcluded_Audits());


				$sqlAgents = "SELECT qa.agent_id, count(*) as auditCount, s.doj from $c_defect_table as qa
							  INNER JOIN signin as s ON s.id = qa.agent_id
							  WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') ".$offCondi." $lobCond AND qa.audit_type NOT IN ('$audit_excluded') GROUP BY qa.agent_id";
				$queryAgents = $this->Common_model->get_query_result_array($sqlAgents);
				$currentDay = CurrDate();
				$agentTender = array();
				foreach($queryAgents as $tokeng)
				{
					$joiningDay = $tokeng['doj'];
					if(!empty($joiningDay) && $joiningDay != "0000-00-00")
					{
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
					$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $offCondi AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($currentAgentIDs)";
					$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
					$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
					$totalAuditCount = $c_auditCount;
					$totalAuditScore = !empty($c_qaScore['score']) ? sprintf('%.2f', $c_qaScore['score']) : 0;

					$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									INNER JOIN signin as s ON s.id = qa.agent_id
									WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."') $offCondi AND qa.audit_type = 'CQ Audit' AND overall_score = '0' AND qa.agent_id IN ($currentAgentIDs)";
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

			//}

			}



			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "Qa_acceptance_new/qa_tenure_level.php";
			$data["content_js"] = "Qa_acceptance_new/qa_tenure_level_js.php";

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
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_defect as p
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
							p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_defect as p
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
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
								   LEFT JOIN process as p ON p.id = q.process_id
								   LEFT JOIN client as c ON c.id = q.client_id ORDER by q.table_name";
			$data['process_list'] = $processArray = $this->Common_model->get_query_result_array($sqlProcess);


			//===================== CALCULATE ======================================//

			if(!empty($search_process_id))
			{
				// GET DEFECT TABLES
				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
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

			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "Qa_acceptance_new/qa_agent_level.php";
			$data["content_js"] = "Qa_acceptance_new/qa_agent_level_js.php";

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
			$sqlDefectTable = "SELECT * from qa_defect WHERE process_id = '$process_id'";
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
		$this->load->view('Qa_acceptance_new/qa_agent_level_details',$data);
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
			$sqlDefectTable = "SELECT * from qa_defect WHERE process_id = '$process_id'";
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
		$this->load->view('Qa_acceptance_new/qa_tl_level_details',$data);
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
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_defect as p
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
							p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_defect as p
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

			$search_process_id = "";
			$search_process_id = $this->input->get('select_process')?$this->input->get('select_process'):2;

			$data['selected_process'] = $search_process_id;

			$extraFilter = "";
			if($lob != "" && !in_array("ALL", $lob))
			{
				$lob_implode = implode("','", $lob);
				$extraFilter .= "AND s.assigned_campaign IN ('$lob_implode')";
			}


			/* Process list start*/
			$sqlNewProcess = "SELECT id, name as process_name FROM process where id !=0 ";

			$data['process_list_new'] = $NewProcess = $this->Common_model->get_query_result_array($sqlNewProcess);
			/* Process list end*/
			$data['lobs'] = $this->db->query("SELECT id, campaign FROM campaign WHERE is_active = 1 and process_id=".$search_process_id)->result();
			$data['selected_lob'] = $lob = $this->input->get("lob");

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
			// $search_campaign_id = "";
			// if(!empty($this->input->get('select_campaign'))){
			// 	$search_campaign_id = $this->input->get('select_campaign');
			// }
			// $data['selected_campaign'] = $search_campaign_id;

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
				$sendUrl = base_url() ."Qa_acceptance_new/tl_level?submitgraph=search";
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
				//$sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){
					$sendUrl .= "&select_process=".$search_process_id;
				}

				if($lob != "" && !in_array("ALL", $lob))
				{
					$sendUrl .= "&lob=".$lob;
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
				$sendUrl = base_url() ."Qa_acceptance_new/manager_level?submitgraph=search";
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
				// $sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){
					$sendUrl .= "&select_process=".$search_process_id;
				}
				// if(!empty($search_campaign_id) && $search_campaign_id != "ALL"){
				// 	$sendUrl .= "&select_campaign=".$search_campaign_id;
				// }
				if($lob != "" && !in_array("ALL", $lob))
				{
					$sendUrl .= "&lob=".$lob;
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

			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
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

				$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' $locationCondi $extraMangerCut AND s.role_id IN('14','224')";
				$data['managersList'] = $queryManagers = $this->Common_model->get_query_result_array($sqlManagers);

				if(!empty($search_manger_id))
				{

					$sqlTls = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_manger_id' $extraTLCut";
					$data['tlList'] = $queryTls = $this->Common_model->get_query_result_array($sqlTls);

					if(!empty($search_tl_id))
					{
						$sqlAgents = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' $locationCondi AND s.assigned_to = '$search_tl_id' $extraAgentCut";
					    $data['agentList'] = $queryAgents = $this->Common_model->get_query_result_array($sqlAgents);
					}
				}
			}

			//===================== CALCULATE ======================================//

			if(!empty($search_process_id))
			{
				// GET DEFECT TABLES
				// $sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
				// 					   LEFT JOIN process as p ON p.id = q.process_id
				// 					   LEFT JOIN client as c ON c.id = q.client_id
				// 					   WHERE q.process_id = '$search_campaign_id'";
				// $get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				// $c_defect_table  =  trim($get_defect_columns['table_name']);

				if($search_process_id == 1){
					$lob_id=implode('","', $lob);
					 // $sql_defect_columns = $this->db->query('SELECT table_name, process_id, params_columns,fatal_param FROM qa_defect Where campaign_id in ("'.$lob_id.'")');

				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.campaign_id in ($lob_id)";
				}else if($search_process_id == 2){
					$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_process_id'";
				}
				$get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				$c_defect_table  =  trim($get_defect_columns['table_name']);


				// GET USERS FILTER
				$userSearch = 0;
				$extraUserSearch = "";
				if(!empty($search_manger_id) && $search_manger_id != "ALL"){

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

				$sqlManagers = "SELECT s.id as user_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE  i.process_id = '$search_process_id' $locationCondi $extraUserSearch";
				$queryManagers = $this->Common_model->get_query_result_array($sqlManagers);
				if(!empty($queryManagers)){ $userSearch = implode(',', array_column($queryManagers, 'user_id')); }
				$extraUserFilter = " AND qa.agent_id IN ($userSearch)";

				// CQ SCORE

				$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
								$locationCondi AND qa.audit_type = 'CQ Audit'
								$extraUserFilter $extraFilter";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);

				//exit();
				//========= AGENT TENDER SCORE ========================================================//

				$sqlAgent = "SELECT qa.agent_id, count(qa.overall_score) as total_count, avg(qa.overall_score) as average_score, s.doj, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
							 $locationCondi AND qa.audit_type = 'CQ Audit' $extraUserFilter $extraFilter GROUP BY qa.agent_id";
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

				$sqlTopAgent = "SELECT qa.agent_id, avg(qa.overall_score) as overall_score, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
							$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score >= '85' $extraUserFilter $extraFilter GROUP BY qa.agent_id";

				$queryTopAgent = $this->Common_model->get_query_result_array($sqlTopAgent);
				//arsort(array_column($queryTopAgent['overall_score']));
				if(!empty($queryTopAgent))arsort(array_column($queryTopAgent,"overall_score"));


				// CQ FATAL

				$sql_qaScore_fatal = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
								$locationCondi AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraUserFilter  $extraFilter GROUP BY qa.agent_id";
				$c_qaScore_fatal = $this->Common_model->get_query_result_array($sql_qaScore_fatal);


				// CQ AUTOFAIL

				$sql_qaScore_fail = "SELECT qa.agent_id, count(qa.overall_score) as total_count, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id  from $c_defect_table as qa
							    INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraUserFilter $extraFilter GROUP BY qa.agent_id";
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


							$sql_qaScore = "SELECT count(*) as auditCount, avg(qa.overall_score) as score from $c_defect_table as qa
									        INNER JOIN signin as s ON s.id = qa.agent_id
									        WHERE (DATE(qa.audit_date) >= '".$letsStart."' AND DATE(qa.audit_date) <='".$letsend."')
											$locationCondi AND qa.audit_type = 'CQ Audit'
											$extraUserFilter $extraFilter";
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
											$locationCondi AND qa.audit_type = 'CQ Audit'
											$extraUserFilter $extraFilter";
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
								$locationCondi AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail') $extraUserFilter $extraFilter";
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

			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "Qa_acceptance_new/qa_tl_level.php";
			$data["content_js"] = "Qa_acceptance_new/qa_tl_level_js.php";

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
			//error_reporting(E_ALL ^ E_NOTICE ^E_WARNING);
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
			$search_process_id = $this->input->get('select_process')?$this->input->get('select_process'):2;
				$data['selected_process'] = $search_process_id;


			/* Process list start*/
			$sqlNewProcess = "SELECT id, name as process_name FROM process where id !=0 ";

			$data['process_list_new'] = $NewProcess = $this->Common_model->get_query_result_array($sqlNewProcess);
			/* Process list end*/
			$data['lobs'] = $this->db->query("SELECT id, campaign FROM campaign WHERE is_active = 1 and process_id=".$search_process_id)->result();
			$data['selected_lob'] = $lob = $this->input->get("lob");

			// if(!empty($search_process_id))
			// {
			// 	$cProcessQ = $this->input->get('select_process');
			// 	$extraCheck = " AND p.id IN ($cProcessQ)";
			// 	$extraQCheck = " AND FLOOR(p.process_id) IN ($cProcessQ)";
			// }

			$extraFilter = "";
			if(!empty($search_process_id) && $search_process_id != 'ALL'){
				$extraQCheck = " AND is_assign_process(ip.id, $search_process_id) ";
			}

			if($lob != "" && !in_array("ALL", $lob))
			{
				$lob_implode = implode("','", $lob);
				$extraFilter .= "AND s.assigned_campaign IN ('$lob_implode')";
			}

			// $search_client_id = "";
			// $extraClientheck = "";
			// if(!empty($this->input->get('select_client'))){
			// 	$search_client_id = $this->input->get('select_client');
			// 	if($search_client_id != "ALL"){
			// 	$extraClientheck = " AND p.client_id IN ($search_client_id)";
			// 	}
			// }

			//$data['selected_client'] = $search_client_id;

			//Client Selection
			$sql_client = "SELECT * FROM client WHERE is_active=1 AND id IN ($my_client_ids) ORDER BY shname";
			$result_client = $this->Common_model->get_query_result_array($sql_client);
			$data['client_list'] = $result_client;


			$sqlProcess = "SELECT p.name as process_name, i.process_id, c.shname as client_name, c.id as client_id from info_assign_process as i
						   LEFT JOIN process as p ON p.id = i.process_id
						   LEFT JOIN client as c ON c.id = p.client_id
						   WHERE i.user_id = '$current_user' AND p.is_active = '1' AND p.client_id IN ($my_client_ids) ";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
			$sqlDefectProcess = "SELECT REPLACE(REPLACE(REPLACE(p.table_name, 'qa_',''), '_feedback', ''), '_', ' ') as process_name,
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_defect as p
			                    INNER JOIN info_assign_process as i ON i.process_id = FLOOR(p.process_id)
			                    LEFT JOIN client as c ON c.id = p.client_id
								LEFT JOIN process as ip ON ip.id = p.process_id
								WHERE i.user_id = '$current_user' AND p.client_id IN ($my_client_ids) ";
			$queryDefectProcess = $this->Common_model->get_query_result_array($sqlDefectProcess);



			if((get_role_dir() != 'agent' && get_role_dir() != 'tl') || get_global_access())
			{
				$sqlProcess = "SELECT p.name as process_name, p.id as process_id, c.shname as client_name, c.id as client_id from process as p
							   LEFT JOIN client as c ON c.id = p.client_id
							   WHERE p.is_active = '1' AND p.client_id IN ($my_client_ids)  ORDER by p.name";
				$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);

				$sqlDefectProcess = "SELECT REPLACE(REPLACE(REPLACE(p.table_name, 'qa_',''), '_feedback', ''), '_', ' ') as process_name,
							p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_defect as p
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
			//$search_process_id = "";
			if(!empty($this->input->get('select_process'))){
				$search_process_id = $this->input->get('select_process');
			}
			//$data['selected_process'] = $search_process_id;

			// ============  FILTER CAMPAIGN ========================================//
			// $search_campaign_id = "";
			// if(!empty($this->input->get('select_campaign'))){
			// 	$search_campaign_id = $this->input->get('select_campaign');
			// }
			// $data['selected_campaign'] = $search_campaign_id;

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
				if($search_tl_id != "ALL" && !empty($search_manger_id) && !empty($search_process_id)){
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
				$sendUrl = base_url() ."Qa_acceptance_new/tl_level?submitgraph=search";
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
				//$sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){
					$sendUrl .= "&select_process=".$search_process_id;
				}
				// if(!empty($search_campaign_id) && $search_campaign_id != "ALL"){
				// 	$sendUrl .= "&select_campaign=".$search_campaign_id;
				// }

				if($lob != "" && !in_array("ALL", $lob))
				{
					$sendUrl .= "&lob=".$lob;
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
				$sendUrl = base_url() ."Qa_acceptance_new/manager_level?submitgraph=search";
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
				//$sendUrl .= "&select_client=".$search_client_id;
				if(!empty($search_process_id) && $search_process_id != "ALL"){
					$sendUrl .= "&select_process=".$search_process_id;
				}
				// if(!empty($search_campaign_id) && $search_campaign_id != "ALL"){
				// 	$sendUrl .= "&select_campaign=".$search_campaign_id;
				// }

				if($lob != "" && !in_array("ALL", $lob))
				{
					$sendUrl .= "&lob=".$lob;
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
			$sqlProcess = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
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
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' $locationCondi AND s.role_id IN('14','224')";
						//AND s.role_id=224
				//echo $sqlManagers;
				$data['managersListDropDown'] = $queryManagers = $this->Common_model->get_query_result_array($sqlManagers);

				if(!empty($search_manger_id) && $search_manger_id != "ALL")
				{
					/*if any manager selected start*/
					$sqlManagers = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname, s.id, s.fusion_id, s.office_id FROM info_assign_process as i
						INNER JOIN signin as s ON s.id = i.user_id
						INNER JOIN role as r ON r.id = s.role_id
						WHERE r.folder = 'manager' AND i.process_id = '$search_process_id' $locationCondi  AND s.role_id IN('14','224')AND s.id=$search_manger_id";
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
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi  AND s.assigned_to = '$search_manger_id'";
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

			if(!empty($search_process_id))
			{
				// GET DEFECT TABLES
				// $sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
				// 					   LEFT JOIN process as p ON p.id = q.process_id
				// 					   LEFT JOIN client as c ON c.id = q.client_id
				// 					   WHERE q.process_id = '$search_process_id'";
				// $get_defect_columns = $this->Common_model->get_query_row_array($sql_defect_columns);
				// $c_defect_table  =  trim($get_defect_columns['table_name']);

				if($search_process_id == 1){
					$lob_id=implode('","', $lob);
					 // $sql_defect_columns = $this->db->query('SELECT table_name, process_id, params_columns,fatal_param FROM qa_defect Where campaign_id in ("'.$lob_id.'")');

				$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.campaign_id in ($lob_id)";
				}else if($search_process_id == 2){
					$sql_defect_columns = "SELECT q.*, p.name as process_name, c.shname as client_name FROM qa_defect as q
									   LEFT JOIN process as p ON p.id = q.process_id
									   LEFT JOIN client as c ON c.id = q.client_id
									   WHERE q.process_id = '$search_process_id'";
				}
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
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi $extraFilter AND s.assigned_to = '$search_manger_id'";
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
						WHERE  i.process_id = '$search_process_id' $locationCondi $extraFilter $extraUserSearch";
			//	echo"<br>";
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
						WHERE r.folder = 'tl' AND i.process_id = '$search_process_id' $locationCondi $extraFilter AND s.assigned_to = '$currentManager'";
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
									$locationCondi $extraFilter  AND qa.audit_type = 'CQ Audit' AND s.assigned_to IN ($userSearchManagerTls)";

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
									$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
									 AND s.assigned_to IN ($userSearchManagerTls)";
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
									$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
									 AND s.assigned_to IN ($userSearchManagerTls)";
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
								$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit'
								$extraTLFilter GROUP BY s.assigned_to";
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
								$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
								$extraTLFilter  GROUP BY s.assigned_to";

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
								$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
								$extraTLFilter  GROUP BY s.assigned_to";
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
								$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit'
								$extraUserFilter";
				$c_qaScore = $this->Common_model->get_query_row_array($sql_qaScore);
				$c_auditCount = !empty($c_qaScore['auditCount']) ? $c_qaScore['auditCount'] : 0;
				$totalAuditCount = $c_auditCount;
				$avgCQScore = sprintf('%.2f', $c_qaScore['score']);
				//echo $sql_qaScore ;
				//exit;

				//========= AGENT SCORER ========================================================//
				/* $sqlAgent = "SELECT qa.agent_id, count(qa.overall_score) as total_count, avg(qa.overall_score) as average_score, s.doj, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
							 AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' $extraUserFilter GROUP BY qa.agent_id"; */
				$sqlAgent = "SELECT qa.agent_id, count(qa.overall_score) as total_count, avg(qa.overall_score) as average_score, s.doj, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from $c_defect_table as qa
							 INNER JOIN signin as s ON s.id = qa.agent_id
							 WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
							 $locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' $extraUserFilter GROUP BY qa.agent_id";
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
								$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' AND (qa.overall_score = '0')
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
								$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' AND qa.overall_score < '85'
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
											$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit'
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
											$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit'
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
					/* $sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
								AND s.office_id = '$search_office' AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail')"; */
					$sqlToken = "SELECT count(*) as auditCount from $c_defect_table as qa INNER JOIN signin as s ON s.id = qa.agent_id
							    WHERE (DATE(qa.audit_date) >= '".$start_date."' AND DATE(qa.audit_date) <='".$end_date."')
								$locationCondi $extraFilter AND qa.audit_type = 'CQ Audit' AND qa.$token IN ('0', 'No', 'Unacceptable', 'Fail')";
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

			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "Qa_acceptance_new/qa_manager_level.php";
			$data["content_js"] = "Qa_acceptance_new/qa_manager_level_js.php";

			$this->load->view('dashboard',$data);

		}
	}


	public function search_campaign_ajax()
	{
		$process_id = $this->input->get('pid');
		$sqlDefectProcess = "SELECT REPLACE(REPLACE(REPLACE(p.table_name, 'qa_', ''),'_',' '), 'feedback','') as process_name,
			                    p.process_id as process_id, c.shname as client_name, c.id as client_id FROM qa_defect as p
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
			$sqlDefectTable = "SELECT * from qa_defect WHERE process_id = '$process_id'";
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
		$this->load->view('Qa_acceptance_new/qa_agent_level_details',$data);
	}


//================= ACCEPTANCE DASHBOARD =================================================//

	public function excel_Qa_acceptance_new(){
			date_default_timezone_set("Asia/Kolkata");

			$default_val[] = 'ALL';

			$process_id = $this->input->get('select_process');
	$ofc_id = $this->input->get('select_office')?$this->input->get('select_office'):$default_val;
		$lob_id = $this->input->get('lob_id')?$this->input->get('lob_id'):$default_val;
		$tl_id = $this->input->get('l1_super')?$this->input->get('l1_super'):$default_val;
		$qa_id = $this->input->get('select_qa')?$this->input->get('select_qa'):$default_val;



	$from_date = $this->input->get('from_date')?$this->input->get('from_date'):date('Y-m-01');
		$to_date = $this->input->get('to_date')?$this->input->get('to_date'):date('Y-m-d');

// echo 	$process_id;
// die;

if($process_id=='1'||$process_id=='2')
{
	$process_sql = "SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=FLOOR(qa_defect.process_id) Where qa_defect.is_active = 1 AND process.id='$process_id'" ;
}

else {
	$process_sql ="SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=qa_defect.process_id Where qa_defect.is_active = 1";
}


		//
			$no_of_process = $this->db->query($process_sql)->num_rows();
			$process_data = $this->Common_model->get_query_result_array($process_sql);



// echo "<pre>"; print_r($process_data);
//
// die;
				// $this->objPHPExcel->createSheet();
				// $this->objPHPExcel->setActiveSheetIndex();
				$objWorksheet = $this->objPHPExcel->getActiveSheet();
				$objWorksheet->setTitle("Acceptance Report");

				// START GRIDLINES HIDE AND SHOW//
				$objWorksheet->setShowGridlines(true);
				// END GRIDLINES HIDE AND SHOW//
				//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);

			$column = 'A';
			for($i = 0; $i <= 12; $i++) {
				$objWorksheet->getColumnDimension($column)->setWidth(20);
				$column++;
			}

				$style = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				);

				$objWorksheet->getStyle("A1:L1")->applyFromArray($style);
				$sheet = $this->objPHPExcel->getActiveSheet();

				unset($style);

				// CELL BACKGROUNG COLOR
	                $styleArrayh =array(
									'type' => PHPExcel_Style_Fill::FILL_SOLID,
									'startcolor' => array(
										 'rgb' => "35B8E0"
									),
									'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
								);
				$this->objPHPExcel->getActiveSheet()->getStyle("A3:K3")->getFill()->applyFromArray($styleArrayh);

				// CELL FONT AND FONT COLOR
				$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 14,
					'name'  => 'Algerian',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				));

				$style = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
				);

				$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
				//$this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);

				$style_table_name = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '000000'),
						'size'  => 10,
						'name'  => 'Verdana',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					));

				//$total_column = PHPExcel_Cell::stringFromColumnIndex(12);
				$sheet = $this->objPHPExcel->getActiveSheet();
				$sheet->getDefaultStyle()->applyFromArray($style);
				$sheet->setCellValueByColumnAndRow(0, 1, "Acceptance Report");
				$sheet->mergeCells('A1:L1');

					$colh1=0;
					$rowh1=3;

					// Agent Count % List
					$this->objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_table_name);
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,"Overall Acceptance Analytics");
					$sheet->mergeCells('A2:K2');
					$header_column_ol = array("Process","Feedback Raised","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %","Rebuttal Raised","Rebuttal Raised %");
					foreach($header_column_ol as $val){
							$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh1,$rowh1,$val);
							$colh1++;
					}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					foreach($process_data as $p_data)
					{
						$process_1 = substr($p_data['table_name'],9,-9);
						if (strpos($process_1, 'posp') !== false) {
							$process = 'POSP';
						}else{
							$process = ucwords($process_1);
						}


						//
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// $overall_sql = "select count(t.id) as total_feedback,'$process' as process,
						// sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
						// sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
						// sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
						// sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
						// sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
						// from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
						// where date(t.audit_date) between '$from_date' and '$to_date'";

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

												if($ofc_id!=""){
															if (in_array("ALL",$ofc_id, TRUE)){
																$off_cond='';
															}else{
																$off_id=implode('","', $ofc_id);
																$off_cond .=' and s.office_id in ("'.$off_id.'")';
															}
														}

						$overall_sql = "select count(t.id) as total_feedback,'$process' as process,
											sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
												sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
						 					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
											sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
										sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
											from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
										where date(t.audit_date) between '$from_date' and '$to_date' $lob_cond $tl_cond $qa_cond 	$off_cond  ";
//
// echo "<pre>"; print_r($overall_sql); echo "</pre>";
// die;

						$overall_data[] = $this->Common_model->get_query_row_array($overall_sql);







						$locationwise_sql = "select count(t.id) as total_feedback,'$process' as process,s.office_id,
												sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
												sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
							 					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
							 					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
												sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
						 					from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
											where date(t.audit_date) between '$from_date' and '$to_date' $lob_cond $tl_cond $qa_cond 	$off_cond  group by s.office_id";







						$locationwise_data[] = $this->Common_model->get_query_result_array($locationwise_sql);








						$lobwise_sql = "select count(t.id) as total_feedback,t.lob_campaign,
												sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
												sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
												sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
											sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
												sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
											from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
												where date(t.audit_date) between '$from_date' and '$to_date' $lob_cond $tl_cond $qa_cond 	$off_cond  group by t.lob_campaign";





						$lobwise_data[] = $this->Common_model->get_query_result_array($lobwise_sql);



						$tlwise_sql = "select count(t.id) as total_feedback,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name,
										sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
						 					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
						 					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
											sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
										where date(t.audit_date) between '$from_date' and '$to_date' $lob_cond $tl_cond $qa_cond  	$off_cond   group by t.tl_id";

										//echo "<pre>"; print_r($tlwise_sql); echo "</pre>";

									//	die;


						$tlwise_data[] = $this->Common_model->get_query_result_array($tlwise_sql);



						$qawise_sql = "select count(t.id) as total_feedback,t.entry_by, (select concat(fname,' ',lname) as qa_name FROM signin WHERE signin.id = t.entry_by) as qa_name, (select d.description FROM signin si join department d on si.dept_id = d.id WHERE si.id = t.entry_by) as department,
		 					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
		 					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
		 					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
							sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
		 					where date(t.audit_date) between '$from_date' and '$to_date'  $lob_cond $tl_cond $qa_cond 	$off_cond     group by t.entry_by";

						$qawise_data[] = $this->Common_model->get_query_result_array($qawise_sql);




						$agentwise_sql = "select count(t.id) as total_feedback,concat(s.fname,' ',s.lname) as agent_name,s.xpoid,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name,
		 					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
							sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
						sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
							sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
		 					where date(t.audit_date) between '$from_date' and '$to_date'  $lob_cond $tl_cond $qa_cond  	$off_cond       group by s.id";

						$agentwise_data[] = $this->Common_model->get_query_result_array($agentwise_sql);
					}

					// echo "<pre>";
					// print_r($overall_data);
					// echo "</pre>";die;



					$accept_per=$post_24_acpt=$post_24_accept_per=$overall_accept_per=$not_accept_per=$accept_per_gt=$post_24_acpt_gt=$post_24_accept_per_gt=$overall_accept_per_gt=$not_accept_per_gt=0;


					foreach($overall_data as $pro_data){
						$pros_array[] = $pro_data['process'];
					}
					$pross_list = array_unique($pros_array);

					$row1=4;
					unset($ttl);
					$ttl = array();
				   foreach ($pross_list as $key => $pro) {
				   unset($ol);
				   $ol = array();

					   foreach ($overall_data as $key => $od) {
						   if ($pro==$od['process']) {
							    $ol['process'] = $od['process'];
							   $ol['feedback_count'] += $od['total_feedback'];
							   $ol['approved_audit'] += $od['approved_audit'];
							   $ol['accept_in_24'] += $od['tntfr_hr_acpt'];
							   $ol['total_accept'] += $od['accept_count'];
							   $ol['total_not_accept'] += $od['not_accepted_count'];

							   $ttl['total_feedback'] += $od['total_feedback'];
							   $ttl['approved_audit'] += $od['approved_audit'];
							   $ttl['total_in_24'] += $od['tntfr_hr_acpt'];
							   $ttl['total_accept'] += $od['accept_count'];
							   $ttl['total_not_accept'] += $od['not_accepted_count'];
						   }
				   }



				   if($ol['accept_in_24']!=0 ){
					$accept_per = number_format(($ol['accept_in_24']/$ol['approved_audit'])*100,2);
					}else{
						$accept_per = 0;
					}
					$post_24_acpt = $ol['total_accept'] - $ol['accept_in_24'];
					if($post_24_acpt!=0 ){
					$post_24_accept_per = number_format(($post_24_acpt/$ol['approved_audit'])*100,2);
					}else{
						$post_24_accept_per = 0;
					}
					if($ol['total_accept']!=0 ){
					$overall_accept_per = number_format(($ol['total_accept']/$ol['approved_audit'])*100,2);
					}else{
						$overall_accept_per = 0;
					}
					if($ol['total_not_accept']!=0 ){
					$not_accept_per = number_format(($ol['total_not_accept']/$ol['approved_audit'])*100,2);
					}else{
						$not_accept_per = 0;
					}
						$col1 = 0;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['process']);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['feedback_count']);
						 $col1++;
						 $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['approved_audit']);
						 $col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['accept_in_24']);
						 $col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$accept_per.'%');
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_acpt);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_accept_per.'%');
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['total_accept']);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$overall_accept_per.'%');
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['total_not_accept']);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$not_accept_per.'%');
						$col1++;

						$row1++;
					 }

					 if($ttl['total_in_24']==0){

				 			$accept_per_gt = 0;
				 	}





					$accept_per_gt = number_format(($ttl['total_in_24']/$ttl['approved_audit'])*100,2);

					$post_24_acpt_gt = $ttl['total_accept'] - $ttl['total_in_24'];
					if($ttl['approved_audit']==0 || $post_24_acpt_gt==0){

						$post_24_accept_per_gt = 0;
				 }
					$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$ttl['approved_audit'])*100,2);

					$overall_accept_per_gt = number_format(($ttl['total_accept']/$ttl['approved_audit'])*100,2);

					if($ttl['total_accept']==0){

				 		$overall_accept_per_gt = 0;
				 }





					$not_accept_per_gt = number_format(($ttl['total_not_accept']/$ttl['approved_audit'])*100,2);
					if($ttl['total_not_accept']==0){

					$not_accept_per_gt = 0;
					}



					$row_gt = $row1;
					$col_gt = 0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,'Grand Total');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_feedback']);
						$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['approved_audit']);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_in_24']);
						$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$accept_per_gt.'%');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_acpt_gt);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_accept_per_gt.'%');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_accept']);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$overall_accept_per_gt.'%');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_not_accept']);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$not_accept_per_gt.'%');
					$col_gt++;

					$row_gt++;


					$colh2 = 0;
					$rowt2 = $row_gt+1;
					$rowh2 = $rowt2+1;
					//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
					$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh2.":K".$rowh2)->getFill()->applyFromArray($styleArrayh);
					$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt2)->applyFromArray($style_table_name);
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt2,"Location wise Acceptance Analytics");
					$sheet->mergeCells('A'.$rowt2.':K'.$rowt2);
					$header_column_loc = array("Location","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

					foreach($header_column_loc as $val){
							$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh2,$rowh2,$val);
							$colh2++;
					}

					 foreach($locationwise_data as $office_data){
					 	foreach ($office_data as $key => $loc_data) {
						$location_array[] = $loc_data['office_id'];

					}
				}
				$loc_list = array_unique($location_array);

				//for ($i=0; $i <=count($loc_list) ; $i++) {
					$rloc = $rowh2+1;
					unset($gt_loc);
					$gt_loc = array();
					foreach ($loc_list as $key => $office) {
					unset($data);
					$data = array();
					foreach($locationwise_data as $office_datas){
						foreach ($office_datas as $key => $loc_datas) {
							if ($office==$loc_datas['office_id']) {
								$data['office_id'] = $loc_datas['office_id'];
								$data['feedback_count'] += $loc_datas['total_feedback'];
								$data['approved_audit'] += $loc_datas['approved_audit'];
								$data['accept_in_24'] += $loc_datas['tntfr_hr_acpt'];
								$data['total_accept'] += $loc_datas['accept_count'];
								$data['total_not_accept'] += $loc_datas['not_accepted_count'];

								$gt_loc['total_feedback'] += $loc_datas['total_feedback'];
								$gt_loc['approved_audit'] += $loc_datas['approved_audit'];
								$gt_loc['total_in_24'] += $loc_datas['tntfr_hr_acpt'];
								$gt_loc['total_accept'] += $loc_datas['accept_count'];
								$gt_loc['total_not_accept'] += $loc_datas['not_accepted_count'];
							}
					}
				}
				if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
				$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
				}else{
					$accept_per = 0;
				}
				$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
				if($post_24_acpt!=0 || $data['approved_audit']!=0){
				$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
				}else{
					$post_24_accept_per = 0;
				}
				if($data['total_accept']!=0 || $data['approved_audit']!=0){
				$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
				}else{
					$overall_accept_per = 0;
				}
				if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
				$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
				}else{
					$not_accept_per = 0;
				}

				// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
				// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
				// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
				// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
				// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
				$cloc = 0;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['office_id']);
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['feedback_count']);
					$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['approved_audit']);
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['accept_in_24']);
					$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$accept_per.'%');
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_acpt);
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_accept_per.'%');
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_accept']);
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$overall_accept_per.'%');
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_not_accept']);
				$cloc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$not_accept_per.'%');
				$cloc++;

				$rloc++;
				}

				$accept_per_gt = number_format(($gt_loc['total_in_24']/$gt_loc['approved_audit'])*100,2);
				$post_24_acpt_gt = $gt_loc['total_accept'] - $gt_loc['total_in_24'];
				$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_loc['approved_audit'])*100,2);
				$overall_accept_per_gt = number_format(($gt_loc['total_accept']/$gt_loc['approved_audit'])*100,2);
				$not_accept_per_gt = number_format(($gt_loc['total_not_accept']/$gt_loc['approved_audit'])*100,2);
				$row_gt_loc = $rloc;
				$col_gt_loc = 0;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,'Grand Total');
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_feedback']);
					$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['approved_audit']);
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_in_24']);
					$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$accept_per_gt.'%');
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_acpt_gt);
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_accept_per_gt.'%');
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_accept']);
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$overall_accept_per_gt.'%');
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_not_accept']);
				$col_gt_loc++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$not_accept_per_gt.'%');
				$col_gt_loc++;

				$row_gt_loc++;

				//lobwise table
				$colh3 = 0;
				$rowt3 = $row_gt_loc+1;
				$rowh3 = $rowt3+1;
				//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
				$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh3.":K".$rowh3)->getFill()->applyFromArray($styleArrayh);
				$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt3)->applyFromArray($style_table_name);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt3,"LOB wise Acceptance Analytics");
				$sheet->mergeCells('A'.$rowt3.':K'.$rowt3);
				$header_column_lob = array("LOB","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

				foreach($header_column_lob as $val){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh3,$rowh3,$val);
						$colh3++;
				}

					foreach($lobwise_data as $lob_data){
					foreach ($lob_data as $key => $campaign_data) {
					$lob_array[] = $campaign_data['lob_campaign'];

				}
			}
			$lob_list = array_unique($lob_array);

			//for ($i=0; $i <=count($loc_list) ; $i++) {
				$rlob = $rowh3+1;
				unset($gt_lob);
				$gt_lob = array();
				foreach ($lob_list as $key => $lob) {
				unset($data);
				$data = array();
				foreach($lobwise_data as $campaign_datas){
					foreach ($campaign_datas as $key => $lob_datas) {
						if ($lob==$lob_datas['lob_campaign']) {
							$data['lob'] = $lob_datas['lob_campaign'];
							$data['feedback_count'] += $lob_datas['total_feedback'];
							$data['approved_audit'] += $lob_datas['approved_audit'];
							$data['accept_in_24'] += $lob_datas['tntfr_hr_acpt'];
							$data['total_accept'] += $lob_datas['accept_count'];
							$data['total_not_accept'] += $lob_datas['not_accepted_count'];

							$gt_lob['total_feedback'] += $lob_datas['total_feedback'];
							$gt_lob['approved_audit'] += $lob_datas['approved_audit'];
							$gt_lob['total_in_24'] += $lob_datas['tntfr_hr_acpt'];
							$gt_lob['total_accept'] += $lob_datas['accept_count'];
							$gt_lob['total_not_accept'] += $lob_datas['not_accepted_count'];
						}
				}
			}
			if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
			$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
			}else{
				$accept_per = 0;
			}
			$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
			if($post_24_acpt!=0 || $data['approved_audit']!=0){
			$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
			}else{
				$post_24_accept_per = 0;
			}
			if($data['total_accept']!=0 || $data['approved_audit']!=0){
			$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
			}else{
				$overall_accept_per = 0;
			}
			if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
			$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
			}else{
				$not_accept_per = 0;
			}

			// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
			// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
			// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
			// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
			// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
			$clob = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['lob']);
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['feedback_count']);
				$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['approved_audit']);
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['accept_in_24']);
				$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$accept_per.'%');
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_acpt);
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_accept_per.'%');
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_accept']);
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$overall_accept_per.'%');
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_not_accept']);
			$clob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$not_accept_per.'%');
			$clob++;

			$rlob++;
			}

			$accept_per_gt = number_format(($gt_lob['total_in_24']/$gt_lob['approved_audit'])*100,2);
			$post_24_acpt_gt = $gt_lob['total_accept'] - $gt_lob['total_in_24'];
			$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_lob['approved_audit'])*100,2);
			$overall_accept_per_gt = number_format(($gt_lob['total_accept']/$gt_lob['approved_audit'])*100,2);
			$not_accept_per_gt = number_format(($gt_lob['total_not_accept']/$gt_lob['approved_audit'])*100,2);
			$row_gt_lob = $rlob;
			$col_gt_lob = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,'Grand Total');
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_feedback']);
				$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['approved_audit']);
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_in_24']);
				$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$accept_per_gt.'%');
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_acpt_gt);
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_accept_per_gt.'%');
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_accept']);
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$overall_accept_per_gt.'%');
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_not_accept']);
			$col_gt_lob++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$not_accept_per_gt.'%');
			$col_gt_lob++;

			$row_gt_lob++;

			//tlwise table
			$colh4 = 0;
			$rowt4 = $row_gt_lob+1;
			$rowh4 = $rowt4+1;
			//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
			$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh4.":K".$rowh4)->getFill()->applyFromArray($styleArrayh);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt4)->applyFromArray($style_table_name);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt4,"TL wise Acceptance Analytics");
			$sheet->mergeCells('A'.$rowt4.':K'.$rowt4);
			$header_column_tl = array("TL Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

			foreach($header_column_tl as $val){
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh4,$rowh4,$val);
					$colh4++;
			}

				foreach($tlwise_data as $l1_data){
				foreach ($l1_data as $key => $tl_data) {
				$tl_array[] = $tl_data['tl_name'];

			}
		}
		$tl_list = array_unique($tl_array);

		//for ($i=0; $i <=count($loc_list) ; $i++) {
			$rtl = $rowh4+1;
			unset($gt_tl);
			$gt_tl = array();
			foreach ($tl_list as $key => $tl) {
			unset($data);
			$data = array();
			foreach($tlwise_data as $l1_datas){
				foreach ($l1_datas as $key => $tl_datas) {
					if ($tl==$tl_datas['tl_name']) {
						$data['tl_name'] = $tl_datas['tl_name'];
						$data['feedback_count'] += $tl_datas['total_feedback'];
						$data['approved_audit'] += $tl_datas['approved_audit'];
						$data['accept_in_24'] += $tl_datas['tntfr_hr_acpt'];
						$data['total_accept'] += $tl_datas['accept_count'];
						$data['total_not_accept'] += $tl_datas['not_accepted_count'];

						$gt_tl['total_feedback'] += $tl_datas['total_feedback'];
						$gt_tl['approved_audit'] += $tl_datas['approved_audit'];
						$gt_tl['total_in_24'] += $tl_datas['tntfr_hr_acpt'];
						$gt_tl['total_accept'] += $tl_datas['accept_count'];
						$gt_tl['total_not_accept'] += $tl_datas['not_accepted_count'];
					}
			}
		}
		if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
		$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
		}else{
			$accept_per = 0;
		}
		$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
		if($post_24_acpt!=0 || $data['approved_audit']!=0){
		$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
		}else{
			$post_24_accept_per = 0;
		}
		if($data['total_accept']!=0 || $data['approved_audit']!=0){
		$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
		}else{
			$overall_accept_per = 0;
		}
		if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
		$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
		}else{
			$not_accept_per = 0;
		}

		// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
		// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
		// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
		// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
		// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
		$ctl = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['tl_name']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['feedback_count']);
			$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['approved_audit']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['accept_in_24']);
			$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$accept_per.'%');
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_acpt);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_accept_per.'%');
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_accept']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$overall_accept_per.'%');
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_not_accept']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$not_accept_per.'%');
		$ctl++;

		$rtl++;
		}

		$accept_per_gt = number_format(($gt_tl['total_in_24']/$gt_tl['approved_audit'])*100,2);
		$post_24_acpt_gt = $gt_tl['total_accept'] - $gt_tl['total_in_24'];
		$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_tl['approved_audit'])*100,2);
		$overall_accept_per_gt = number_format(($gt_tl['total_accept']/$gt_tl['approved_audit'])*100,2);
		$not_accept_per_gt = number_format(($gt_tl['total_not_accept']/$gt_tl['approved_audit'])*100,2);
		$row_gt_tl = $rtl;
		$col_gt_tl = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,'Grand Total');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_feedback']);
			$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['approved_audit']);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_in_24']);
			$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$accept_per_gt.'%');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_acpt_gt);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_accept_per_gt.'%');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_accept']);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$overall_accept_per_gt.'%');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_not_accept']);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$not_accept_per_gt.'%');
		$col_gt_tl++;

		$row_gt_tl++;

		//qawise table
		$colh5 = 0;
		$rowt5 = $row_gt_tl+1;
		$rowh5 = $rowt5+1;
		//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
		$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh5.":K".$rowh5)->getFill()->applyFromArray($styleArrayh);
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt5)->applyFromArray($style_table_name);
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt5,"QA wise Acceptance Analytics");
		$sheet->mergeCells('A'.$rowt5.':K'.$rowt5);
		$header_column_qa = array("QA Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

		foreach($header_column_qa as $val){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh5,$rowh5,$val);
				$colh5++;
		}

			foreach($qawise_data as $entry_by_data){
			foreach ($entry_by_data as $key => $qa_data) {
			$qa_array[] = $qa_data['qa_name'];

		}
	}
	$qa_list = array_unique($qa_array);

	//for ($i=0; $i <=count($loc_list) ; $i++) {
		$rqa = $rowh5+1;
		unset($gt_qa);
		$gt_qa = array();
		foreach ($qa_list as $key => $qa) {
		unset($data);
		$data = array();
		foreach($qawise_data as $entry_by_datas){
			foreach ($entry_by_datas as $key => $qa_datas) {
				if ($qa==$qa_datas['qa_name']) {
					$data['qa_name'] = $qa_datas['qa_name'];
					$data['feedback_count'] += $qa_datas['total_feedback'];
					$data['approved_audit'] += $qa_datas['approved_audit'];
					$data['accept_in_24'] += $qa_datas['tntfr_hr_acpt'];
					$data['total_accept'] += $qa_datas['accept_count'];
					$data['total_not_accept'] += $qa_datas['not_accepted_count'];

					$gt_qa['total_feedback'] += $qa_datas['total_feedback'];
					$gt_qa['approved_audit'] += $qa_datas['approved_audit'];
					$gt_qa['total_in_24'] += $qa_datas['tntfr_hr_acpt'];
					$gt_qa['total_accept'] += $qa_datas['accept_count'];
					$gt_qa['total_not_accept'] += $qa_datas['not_accepted_count'];
				}
		}
	}
	if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
	$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
	}else{
		$accept_per = 0;
	}
	$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	if($post_24_acpt!=0 || $data['approved_audit']!=0){
	$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
	}else{
		$post_24_accept_per = 0;
	}
	if($data['total_accept']!=0 || $data['approved_audit']!=0){
	$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
	}else{
		$overall_accept_per = 0;
	}
	if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
	$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
	}else{
		$not_accept_per = 0;
	}

	// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
	// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
	// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
	// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
	$cqa = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['qa_name']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['feedback_count']);
		$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['approved_audit']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['accept_in_24']);
		$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$accept_per.'%');
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_acpt);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_accept_per.'%');
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_accept']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$overall_accept_per.'%');
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_not_accept']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$not_accept_per.'%');
	$cqa++;

	$rqa++;
	}

	$accept_per_gt = number_format(($gt_qa['total_in_24']/$gt_qa['approved_audit'])*100,2);
	$post_24_acpt_gt = $gt_qa['total_accept'] - $gt_qa['total_in_24'];
	$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_qa['approved_audit'])*100,2);
	$overall_accept_per_gt = number_format(($gt_qa['total_accept']/$gt_qa['approved_audit'])*100,2);
	$not_accept_per_gt = number_format(($gt_qa['total_not_accept']/$gt_qa['approved_audit'])*100,2);
	$row_gt_qa = $rqa;
	$col_gt_qa = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,'Grand Total');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_feedback']);
		$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['approved_audit']);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_in_24']);
		$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$accept_per_gt.'%');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_acpt_gt);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_accept_per_gt.'%');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_accept']);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$overall_accept_per_gt.'%');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_not_accept']);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$not_accept_per_gt.'%');
	$col_gt_qa++;

	$row_gt_qa++;

	//Agentwise table
	$colh6 = 0;
	$rowt6 = $row_gt_qa+1;
	$rowh6 = $rowt6+1;
	//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
	$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh6.":M".$rowh6)->getFill()->applyFromArray($styleArrayh);
	$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt6)->applyFromArray($style_table_name);
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt6,"Agent wise Acceptance Analytics");
	$sheet->mergeCells('A'.$rowt6.':M'.$rowt6);
	$header_column_agent = array("Employee ID","Agent Name","Supervisor Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

	foreach($header_column_agent as $val){
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh6,$rowh6,$val);
			$colh6++;
	}

		foreach($agentwise_data as $agent_wise_data){
		foreach ($agent_wise_data as $key => $agent_data) {
		$agent_array[] = $agent_data['agent_name'];

	}
	}
	$agent_list = array_unique($agent_array);

	//for ($i=0; $i <=count($loc_list) ; $i++) {
	$ragent = $rowh6+1;
	unset($gt_agent);
	$gt_agent = array();
	foreach ($agent_list as $key => $agent) {
	unset($data);
	$data = array();
	foreach($agentwise_data as $agent_wise_datas){
		foreach ($agent_wise_datas as $key => $agent_datas) {
			if ($agent==$agent_datas['agent_name']) {
				$data['emp_id'] = $agent_datas['xpoid'];
				$data['agent_name'] = $agent_datas['agent_name'];
				$data['tl_name'] = $agent_datas['tl_name'];
				$data['feedback_count'] += $agent_datas['total_feedback'];
				$data['approved_audit'] += $agent_datas['approved_audit'];
				$data['accept_in_24'] += $agent_datas['tntfr_hr_acpt'];
				$data['total_accept'] += $agent_datas['accept_count'];
				$data['total_not_accept'] += $agent_datas['not_accepted_count'];

				$gt_agent['total_feedback'] += $agent_datas['total_feedback'];
				$gt_agent['approved_audit'] += $agent_datas['approved_audit'];
				$gt_agent['total_in_24'] += $agent_datas['tntfr_hr_acpt'];
				$gt_agent['total_accept'] += $agent_datas['accept_count'];
				$gt_agent['total_not_accept'] += $agent_datas['not_accepted_count'];
			}
	}
	}
	if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
	$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
	}else{
		$accept_per = 0;
	}
	$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	if($post_24_acpt!=0 || $data['approved_audit']!=0){
	$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
	}else{
		$post_24_accept_per = 0;
	}
	if($data['total_accept']!=0 || $data['approved_audit']!=0){
	$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
	}else{
		$overall_accept_per = 0;
	}
	if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
	$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
	}else{
		$not_accept_per = 0;
	}
	$cagent = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['emp_id']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,ucwords(strtolower($data['agent_name'])));
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['tl_name']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['feedback_count']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['approved_audit']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['accept_in_24']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$accept_per.'%');
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_acpt);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_accept_per.'%');
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_accept']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$overall_accept_per.'%');
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_not_accept']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$not_accept_per.'%');
	$cagent++;

	$ragent++;
	}

	$accept_per_gt = number_format(($gt_agent['total_in_24']/$gt_agent['approved_audit'])*100,2);
	$post_24_acpt_gt = $gt_agent['total_accept'] - $gt_agent['total_in_24'];
	$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_agent['approved_audit'])*100,2);
	$overall_accept_per_gt = number_format(($gt_agent['total_accept']/$gt_agent['approved_audit'])*100,2);
	$not_accept_per_gt = number_format(($gt_agent['total_not_accept']/$gt_agent['approved_audit'])*100,2);
	$row_gt_agent = $ragent;
	$col_gt_agent = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'Grand Total');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_feedback']);
		$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['approved_audit']);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_in_24']);
		$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$accept_per_gt.'%');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_acpt_gt);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_accept_per_gt.'%');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_accept']);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$overall_accept_per_gt.'%');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_not_accept']);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$not_accept_per_gt.'%');
	$col_gt_agent++;

	$row_gt_agent++;




					/////////////////

					ob_end_clean();
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="acceptance_report.xlsx"');
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
					$objWriter->setIncludeCharts(TRUE);
					$objWriter->save('php://output');


		}

	////////////////////////////////////////////////////////////////////////////////14-12-20222////////////////////////////
	public function acceptance_dashboard()
	{
		if(check_logged_in()){
			date_default_timezone_set("Asia/Kolkata");
			$current_user     = get_user_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();

			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "qa_acceptance/qa_acceptance_dashboard_new.php";
			$data["content_js"] = "qa_acceptance/qa_acceptance_dashboard_new_js.php";
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$qaSql="Select id, fusion_id, xpoid, concat(fname,' ',lname) as qa_name from signin where status=1 and dept_id=5";
			$data['qa_list'] = $this->Common_model->get_query_result_array($qaSql);

			// $sqlLob = "Select id, campaign from campaign where is_active=1";
			// $data['lob_campaign'] = $this->Common_model->get_query_result_array($sqlLob);

			////////////////////////////VIKAS//////////////////////////////////////////

			$data['selected_month'] = $month = $this->input->get('select_month') ? $this->input->get('select_month') : array(date('m'));

			$data['selected_year'] = $year = $this->input->get('select_year') ? $this->input->get('select_year') : date('Y');

			$data['data_show_type'] = $rep_type = !empty($this->input->get('rep_type')) ? $this->input->get('rep_type') : 'monthly';

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['selected_location'] = $office_location = !empty($this->input->get('select_office')) ? $this->input->get('select_office') : array('ALL');

			$office_condition = "";
			if(!empty($office_location)){ 					
				if(!in_array('ALL',$office_location)){
					$extracted_office_location = implode("','",$office_location);
					$office_condition = " AND l.abbr IN('".$extracted_office_location."')";
				}
			}

			/*Client List*/
			$sql = "SELECT c.id AS client_id,c.fullname AS client_name FROM client c WHERE c.id <> 0 AND c.is_active = 1";
			$data['client_list'] = $all_client =  $this->db->query($sql)->result_array();

			$data['selected_client_id'] = $client_id = !empty($this->input->get('select_client')) ? $this->input->get('select_client') : 133;

			$campaign_id = !empty($this->input->get('select_campaign')) ? $this->input->get('select_campaign') : array('ALL');

			$selected_process = !empty($this->input->get('select_process')) ? $this->input->get('select_process') : 259;
			
			$campaign_condition = "";
			if(!in_array('ALL',$campaign_id)){
				$campaign_id = implode(',',$campaign_id);
				$campaign_condition = "AND qd.id IN ($campaign_id)";
			}

			/*Date condition*/
			$dateCondition = "";
			if(in_array($rep_type,['daily','weekly'])){

				$data['select_from_date'] = $start_date = date('Y-m-d',strtotime($this->input->get('select_from_date')));
				$data['select_to_date'] = $end_date = date('Y-m-d',strtotime($this->input->get('select_to_date')));

				$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";
			}
			elseif($rep_type =='monthly'){

				$data['selected_month'] = $month = !empty($this->input->get('select_month')) ? $this->input->get('select_month') : array(date('m'));
				$mnth_strng = implode(',',$month);

				$data['selected_year'] = $year = !empty($this->input->get('select_year')) ? $this->input->get('select_year') : date('Y');
				$s_mnth = min($month);
				$e_mnth = max($month);
				$start_date = date('Y-m-01',strtotime($year.'-'.$s_mnth.'-1'));
				$end_date = date('Y-m-t',strtotime($year.'-'.$e_mnth.'-1'));

				$dateCondition = " AND MONTH(qa.audit_date) in($mnth_strng) AND YEAR(qa.audit_date) = $year";
			}
			else
			{
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
				$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";
			}	
			/*Date condition*/

			/*How many weeks in a date range*/
			$start_date = date('Y-m-d',strtotime($start_date));
			$end_date = date('Y-m-d',strtotime($end_date));
			$startTime = strtotime($start_date);
			$endTime = strtotime($end_date);

			$weeks = array();

			while ($startTime <= $endTime) {  

			    $objDT      = new DateTime(date('Y-m-d',$startTime));
		        $weeks[]    = $objDT->format('W');
		        $startTime += strtotime('+1 day', 0);
			}
			$weeks = array_unique($weeks);

		

			//////////////////////////////////////////////////////////////////////

			$tl_sql = "SELECT DISTINCT s.id, concat(s.fname,' ',s.lname) as tl_name FROM signin s join signin si on s.id = si.assigned_to where si.status = 1 and s.dept_id = 6";
			$data['tl_details'] = $this->Common_model->get_query_result_array($tl_sql);
			////////////////////////
			$data['process_list'] = array();

			

			//print_r($ofc_id);die;
			$tl_id = $this->input->get('l1_super')?$this->input->get('l1_super'):$default_val;
			$qa_id = $this->input->get('select_qa')?$this->input->get('select_qa'):$default_val;
			///////////////////////////vikas/////////////////////////////////////////////
		
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

			$sql = "SELECT DISTINCT id as qa_defect_id FROM qa_defect qd WHERE qd.id <> 0 AND qd.is_active = 1 AND qd.client_id = $client_id AND FLOOR(process_id) = $selected_process $campaign_condition";
			$rowDefect = $this->db->query($sql)->result_array();

			// echo"<pre>";
			// print_r($rowDefect);
			// echo"</pre>";
			// exit();	
			if(!empty($rowDefect)){

				foreach($rowDefect as $defect){
					$query = 'SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=FLOOR(qa_defect.process_id) Where qa_defect.id='.$defect['qa_defect_id'];


					$p_data = $this->Common_model->get_query_row_array($query);
					$process = $p_data['process_name'];
					$overall_sql = "select count(qa.id) as total_feedback,'$process' as process,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond";
					//echo $overall_sql;

					$overall_data[] = $this->Common_model->get_query_row_array($overall_sql);

				$tlwise_sql = "select count(qa.id) as total_feedback,qa.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = qa.tl_id) as tl_name,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond group by qa.tl_id";

					$tl_wise_data[] = $this->Common_model->get_query_result_array($tlwise_sql);
					//echo $tlwise_sql;
					$qawise_sql = "select count(qa.id) as total_feedback,qa.entry_by, (select concat(fname,' ',lname) as qa_name FROM signin WHERE signin.id = qa.entry_by) as qa_name, (select d.description FROM signin si join department d on si.dept_id = d.id WHERE si.id = qa.entry_by) as department,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond  group by qa.entry_by";

					$qa_wise_data[] = $this->Common_model->get_query_result_array($qawise_sql);

					$agentwise_sql = "select count(qa.id) as total_feedback,concat(s.fname,' ',s.lname) as agent_name,s.xpoid,qa.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = qa.tl_id) as tl_name,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond  group by s.id";

					$agent_wise_data[] = $this->Common_model->get_query_result_array($agentwise_sql);	
					//echo $agentwise_sql;
				}
			}	

		// echo"<pre>";
		// print_r($tl_wise_data);
		// echo"</pre>";

		// echo"<pre>";
		// print_r($agent_wise_data);
		// echo"</pre>";
				
		// die();

		//process_wise
		foreach($overall_data as $pro_data){
			$pros_array[] = $pro_data['process'];
		}
		$pross_list = array_unique($pros_array);
		foreach ($pross_list as $key => $pro) {
			unset($pro_wise_data);
			$pro_wise_data = array();
			foreach($overall_data as $pro_datas){
					if ($pro==$pro_datas['process']) {
						$pro_wise_data['process'] = $pro_datas['process'];
						$pro_wise_data['total_feedback'] += $pro_datas['total_feedback'];
						$pro_wise_data['approved_audit'] += $pro_datas['approved_audit'];
						$pro_wise_data['tntfr_hr_acpt'] += $pro_datas['tntfr_hr_acpt'];
						$pro_wise_data['accept_count'] += $pro_datas['accept_count'];
						$pro_wise_data['rebuttal_count'] += $pro_datas['rebuttal_count'];
						$pro_wise_data['not_accepted_count'] += $pro_datas['not_accepted_count'];
					}
		}
		$new_pro_data[] = $pro_wise_data;
		}
		// echo "<pre>";
		// print_r($new_pro_data);
		// echo "</pre>";die;
		$data['pro_wise_data'] = $new_pro_data;		
		unset($ovrl_data);
		$ovrl_data = array();

		foreach($overall_data as $ov_datas){
					$ovrl_data['process'] = 'Grand Total';
					$ovrl_data['total_feedback'] += $ov_datas['total_feedback'];
					$ovrl_data['approved_audit'] += $ov_datas['approved_audit'];
					$ovrl_data['tntfr_hr_acpt'] += $ov_datas['tntfr_hr_acpt'];
					$ovrl_data['accept_count'] += $ov_datas['accept_count'];
					$ovrl_data['rebuttal_count'] += $ov_datas['rebuttal_count'];
					$ovrl_data['not_accepted_count'] += $ov_datas['not_accepted_count'];
		}
		$data['overall_data'] = $ovrl_data;

		//tl_wise tlwise_data
	foreach($tl_wise_data as $l1_data){
		foreach ($l1_data as $key => $tl_data) {
		$tl_array[] = $tl_data['tl_name'];
		}
	}
	$tl_list = array_unique($tl_array);
	// echo "<pre>";
	// print_r($tl_list);
	// echo "</pre>";die;

	foreach ($tl_list as $key => $tl) {
	unset($tlwise_data);
	$tlwise_data = array();
	foreach($tl_wise_data as $l1_datas){
		foreach ($l1_datas as $key => $tl_datas) {
			if ($tl==$tl_datas['tl_name']) {
				$tlwise_data['tl_name'] = $tl_datas['tl_name'];
				$tlwise_data['total_feedback'] += $tl_datas['total_feedback'];
				$tlwise_data['approved_audit'] += $tl_datas['approved_audit'];
				$tlwise_data['tntfr_hr_acpt'] += $tl_datas['tntfr_hr_acpt'];
				$tlwise_data['accept_count'] += $tl_datas['accept_count'];
				$tlwise_data['rebuttal_count'] += $tl_datas['rebuttal_count'];
				$tlwise_data['not_accepted_count'] += $tl_datas['not_accepted_count'];
			}
		}
	}
	$new_tl_data[] = $tlwise_data;
	}
	// echo"<pre>";
	// print_r($new_tl_data);
	// echo"</pre>";
	// exit();

	$data['tlwise_data'] = $new_tl_data;

	//qa_wise
	foreach($qa_wise_data as $entry_by_data){
		foreach ($entry_by_data as $key => $qa_data) {
		$qa_array[] = $qa_data['qa_name'];
		}
	}
	$qa_list = array_unique($qa_array);
	foreach ($qa_list as $key => $qa) {
	unset($qawise_data);
	$qawise_data = array();
	foreach($qa_wise_data as $entry_by_datas){
		foreach ($entry_by_datas as $key => $qa_datas) {
			if ($qa==$qa_datas['qa_name']) {
				$qawise_data['qa_name'] = $qa_datas['qa_name'];
				$qawise_data['department'] = $qa_datas['department'];
				$qawise_data['total_feedback'] += $qa_datas['total_feedback'];
				$qawise_data['approved_audit'] += $qa_datas['approved_audit'];
				$qawise_data['tntfr_hr_acpt'] += $qa_datas['tntfr_hr_acpt'];
				$qawise_data['accept_count'] += $qa_datas['accept_count'];
				$qawise_data['rebuttal_count'] += $qa_datas['rebuttal_count'];
				$qawise_data['not_accepted_count'] += $qa_datas['not_accepted_count'];
			}
		}
	}
	$new_qa_data[] = $qawise_data;
	}
	$data['qawise_data'] = $new_qa_data;

	//agent_wise
	foreach($agent_wise_data as $agentt_wise_data){
		foreach ($agentt_wise_data as $key => $agent_data) {
		$agent_array[] = $agent_data['agent_name'];
		}
	}
	$agent_list = array_unique($agent_array);
	foreach ($agent_list as $key => $agent) {
	unset($agentwise_data);
	$agentwise_data = array();
	foreach($agent_wise_data as $agentt_wise_datas){
		foreach ($agentt_wise_datas as $key => $agent_datas) {
			if ($agent==$agent_datas['agent_name']) {
				$agentwise_data['xpoid'] = $agent_datas['xpoid'];
				$agentwise_data['agent_name'] = $agent_datas['agent_name'];
				$agentwise_data['tl_name'] = $agent_datas['tl_name'];
				$agentwise_data['total_feedback'] += $agent_datas['total_feedback'];
				$agentwise_data['approved_audit'] += $agent_datas['approved_audit'];
				$agentwise_data['tntfr_hr_acpt'] += $agent_datas['tntfr_hr_acpt'];
				$agentwise_data['accept_count'] += $agent_datas['accept_count'];
				$agentwise_data['rebuttal_count'] += $agent_datas['rebuttal_count'];
				$agentwise_data['not_accepted_count'] += $agent_datas['not_accepted_count'];
			}
		}
	}
	$new_agent_data[] = $agentwise_data;
	}
	$data['agentwise_data'] = $new_agent_data;

			
		$this->load->view('dashboard',$data);
	}
}

/////////////////////////////START VIKAS////////////////////////////////////////////

	public function excel_qa_graph(){
			date_default_timezone_set("Asia/Kolkata");

			$default_val[] = 'ALL';

			$process_id = $this->input->get('select_process');
	$ofc_id = $this->input->get('select_office')?$this->input->get('select_office'):$default_val;
		$lob_id = $this->input->get('lob_id')?$this->input->get('lob_id'):$default_val;
		$tl_id = $this->input->get('l1_super')?$this->input->get('l1_super'):$default_val;
		$qa_id = $this->input->get('select_qa')?$this->input->get('select_qa'):$default_val;



	$from_date = $this->input->get('from_date')?$this->input->get('from_date'):date('Y-m-01');
		$to_date = $this->input->get('to_date')?$this->input->get('to_date'):date('Y-m-d');

		    $data['selected_month'] = $month = $this->input->get('select_month') ? $this->input->get('select_month') : array(date('m'));

			$data['selected_year'] = $year = $this->input->get('select_year') ? $this->input->get('select_year') : date('Y');

			$data['data_show_type'] = $rep_type = !empty($this->input->get('rep_type')) ? $this->input->get('rep_type') : 'monthly';

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['selected_location'] = $office_location = !empty($this->input->get('select_office')) ? $this->input->get('select_office') : array('ALL');

			$office_condition = "";
			if(!empty($office_location)){ 					
				if(!in_array('ALL',$office_location)){
					$extracted_office_location = implode("','",$office_location);
					$office_condition = " AND l.abbr IN('".$extracted_office_location."')";
				}
			}

			/*Client List*/
			$sql = "SELECT c.id AS client_id,c.fullname AS client_name FROM client c WHERE c.id <> 0 AND c.is_active = 1";
			$data['client_list'] = $all_client =  $this->db->query($sql)->result_array();

			$data['selected_client_id'] = $client_id = !empty($this->input->get('select_client')) ? $this->input->get('select_client') : 133;

			$campaign_id = !empty($this->input->get('select_campaign')) ? $this->input->get('select_campaign') : array('ALL');

			$selected_process = !empty($this->input->get('select_process')) ? $this->input->get('select_process') : 259;
			
			$campaign_condition = "";
			if(!in_array('ALL',$campaign_id)){
				$campaign_id = implode(',',$campaign_id);
				$campaign_condition = "AND qd.id IN ($campaign_id)";
			}

			/*Date condition*/
			$dateCondition = "";
			if(in_array($rep_type,['daily','weekly'])){

				$data['select_from_date'] = $start_date = date('Y-m-d',strtotime($this->input->get('select_from_date')));
				$data['select_to_date'] = $end_date = date('Y-m-d',strtotime($this->input->get('select_to_date')));

				$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";
			}
			elseif($rep_type =='monthly'){

				$data['selected_month'] = $month = !empty($this->input->get('select_month')) ? $this->input->get('select_month') : array(date('m'));
				$mnth_strng = implode(',',$month);

				$data['selected_year'] = $year = !empty($this->input->get('select_year')) ? $this->input->get('select_year') : date('Y');
				$s_mnth = min($month);
				$e_mnth = max($month);
				$start_date = date('Y-m-01',strtotime($year.'-'.$s_mnth.'-1'));
				$end_date = date('Y-m-t',strtotime($year.'-'.$e_mnth.'-1'));

				$dateCondition = " AND MONTH(qa.audit_date) in($mnth_strng) AND YEAR(qa.audit_date) = $year";
			}
			else
			{
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
				$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";
			}	
			/*Date condition*/

			/*How many weeks in a date range*/
			$start_date = date('Y-m-d',strtotime($start_date));
			$end_date = date('Y-m-d',strtotime($end_date));
			$startTime = strtotime($start_date);
			$endTime = strtotime($end_date);

			$weeks = array();

			while ($startTime <= $endTime) {  

			    $objDT      = new DateTime(date('Y-m-d',$startTime));
		        $weeks[]    = $objDT->format('W');
		        $startTime += strtotime('+1 day', 0);
			}
			$weeks = array_unique($weeks);



// echo 	$process_id;
// die;

// if($process_id=='1'||$process_id=='2')
// {
// 	$process_sql = "SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=FLOOR(qa_defect.process_id) Where qa_defect.is_active = 1 AND process.id='$process_id'" ;
// }

// else {
// 	$process_sql ="SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=qa_defect.process_id Where qa_defect.is_active = 1";
// }
	$sql = "SELECT DISTINCT id as qa_defect_id FROM qa_defect qd WHERE qd.id <> 0 AND qd.is_active = 1 AND qd.client_id = $client_id AND FLOOR(process_id) = $selected_process $campaign_condition";
	$rowDefect = $this->db->query($sql)->result_array();


		//
			$no_of_process = $this->db->query($sql)->num_rows();
			//$process_data = $this->Common_model->get_query_result_array($process_sql);



// echo "<pre>"; print_r($process_data);

//  die;
				// $this->objPHPExcel->createSheet();
				// $this->objPHPExcel->setActiveSheetIndex();
				$objWorksheet = $this->objPHPExcel->getActiveSheet();
				$objWorksheet->setTitle("Acceptance Report");

				// START GRIDLINES HIDE AND SHOW//
				$objWorksheet->setShowGridlines(true);
				// END GRIDLINES HIDE AND SHOW//
				//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);

			$column = 'A';
			for($i = 0; $i <= 12; $i++) {
				$objWorksheet->getColumnDimension($column)->setWidth(20);
				$column++;
			}

				$style = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				);

				$objWorksheet->getStyle("A1:L1")->applyFromArray($style);
				$sheet = $this->objPHPExcel->getActiveSheet();

				unset($style);

				// CELL BACKGROUNG COLOR
	                $styleArrayh =array(
									'type' => PHPExcel_Style_Fill::FILL_SOLID,
									'startcolor' => array(
										 'rgb' => "35B8E0"
									),
									'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
								);
				$this->objPHPExcel->getActiveSheet()->getStyle("A3:L3")->getFill()->applyFromArray($styleArrayh);

				// CELL FONT AND FONT COLOR
				$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 14,
					'name'  => 'Algerian',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				));

				$style = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
				);

				$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
				//$this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);

				$style_table_name = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '000000'),
						'size'  => 10,
						'name'  => 'Verdana',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					));

				//$total_column = PHPExcel_Cell::stringFromColumnIndex(12);
				$sheet = $this->objPHPExcel->getActiveSheet();
				$sheet->getDefaultStyle()->applyFromArray($style);
				$sheet->setCellValueByColumnAndRow(0, 1, "Acceptance Report");
				$sheet->mergeCells('A1:L1');

					$colh1=0;
					$rowh1=3;

					// Agent Count % List
					$this->objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_table_name);
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,"Overall Acceptance Analytics");
					$sheet->mergeCells('A2:L2');
					$header_column_ol = array("Process","Feedback Raised","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %","Rebuttal Raised","Rebuttal Raised %");
					foreach($header_column_ol as $val){
							$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh1,$rowh1,$val);
							$colh1++;
					}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				foreach($rowDefect as $defect){
					$query = 'SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=FLOOR(qa_defect.process_id) Where qa_defect.id='.$defect['qa_defect_id'];
						$p_data = $this->Common_model->get_query_row_array($query);
					    $process = $p_data['process_name'];

						// $process_1 = substr($p_data['table_name'],9,-9);
						// if (strpos($process_1, 'posp') !== false) {
						// 	$process = 'POSP';
						// }else{
						// 	$process = ucwords($process_1);
						// }


						//
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

												if($ofc_id!=""){
															if (in_array("ALL",$ofc_id, TRUE)){
																$off_cond='';
															}else{
																$off_id=implode('","', $ofc_id);
																$off_cond .=' and s.office_id in ("'.$off_id.'")';
															}
														}

						
					$overall_sql = "select count(qa.id) as total_feedback,'$process' as process,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond";				
//
// echo "<pre>"; print_r($overall_sql); echo "</pre>";
// die;

						$overall_data[] = $this->Common_model->get_query_row_array($overall_sql);


						$locationwise_sql = "select count(qa.id) as total_feedback,'$process' as process,s.office_id,
												sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
							 					sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
							 					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
												sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
						 					from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
											where 1 $office_condition $dateCondition $tl_cond $qa_cond";

						$locationwise_data[] = $this->Common_model->get_query_result_array($locationwise_sql);



						$tlwise_sql = "select count(qa.id) as total_feedback,qa.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = qa.tl_id) as tl_name,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond group by qa.tl_id";

										//echo "<pre>"; print_r($tlwise_sql); echo "</pre>";

									//	die;


						$tlwise_data[] = $this->Common_model->get_query_result_array($tlwise_sql);



						$qawise_sql = "select count(qa.id) as total_feedback,qa.entry_by, (select concat(fname,' ',lname) as qa_name FROM signin WHERE signin.id = qa.entry_by) as qa_name, (select d.description FROM signin si join department d on si.dept_id = d.id WHERE si.id = qa.entry_by) as department,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond  group by qa.entry_by";

						$qawise_data[] = $this->Common_model->get_query_result_array($qawise_sql);




						$agentwise_sql = "select count(qa.id) as total_feedback,concat(s.fname,' ',s.lname) as agent_name,s.xpoid,qa.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = qa.tl_id) as tl_name,
					sum(case when qa.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when qa.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when qa.agnt_fd_acpt is null then 1 else 0 end) as not_accepted_count,
					sum(case when qa.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(qa.agent_rvw_date)/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." qa join signin s on qa.agent_id = s.id
					where 1 $office_condition $dateCondition $tl_cond $qa_cond  group by s.id";

						$agentwise_data[] = $this->Common_model->get_query_result_array($agentwise_sql);
					}

					// echo "<pre>";
					// print_r($overall_data);
					// echo "</pre>";die;



					$accept_per=$post_24_acpt=$post_24_accept_per=$overall_accept_per=$not_accept_per=$accept_per_gt=$post_24_acpt_gt=$post_24_accept_per_gt=$overall_accept_per_gt=$not_accept_per_gt=0;


					foreach($overall_data as $pro_data){
						$pros_array[] = $pro_data['process'];
					}
					$pross_list = array_unique($pros_array);

					$row1=4;
					unset($ttl);
					$ttl = array();
				   foreach ($pross_list as $key => $pro) {
				   unset($ol);
				   $ol = array();

					   foreach ($overall_data as $key => $od) {
						   if ($pro==$od['process']) {
							    $ol['process'] = $od['process'];
							   $ol['feedback_count'] += $od['total_feedback'];
							   $ol['accept_in_24'] += $od['tntfr_hr_acpt'];
							   $ol['total_accept'] += $od['accept_count'];
							   $ol['total_not_accept'] += $od['not_accepted_count'];
							   $ol['total_rebuttal_count'] += $od['rebuttal_count'];

							   $ttl['total_feedback'] += $od['total_feedback'];
							   //$ttl['approved_audit'] += $od['approved_audit'];
							   $ttl['total_rebuttal_count'] += $od['rebuttal_count'];
							   $ttl['total_in_24'] += $od['tntfr_hr_acpt'];
							   $ttl['total_accept'] += $od['accept_count'];
							   $ttl['total_not_accept'] += $od['not_accepted_count'];
						   }
				   }



				   if($ol['accept_in_24']!=0 ){
					$accept_per = number_format(($ol['accept_in_24'])*100,2);
					}else{
						$accept_per = 0;
					}
					$post_24_acpt = $ol['total_accept'] - $ol['accept_in_24'];
					if($post_24_acpt!=0 ){
					$post_24_accept_per = number_format(($post_24_acpt)*100,2);
					}else{
						$post_24_accept_per = 0;
					}
					if($ol['total_accept']!=0 ){
					$overall_accept_per = number_format(($ol['total_accept'])*100,2);
					}else{
						$overall_accept_per = 0;
					}
					if($ol['total_not_accept']!=0 ){
					$not_accept_per = number_format(($ol['total_not_accept'])*100,2);
					}else{
						$not_accept_per = 0;
					}
					if($ol['total_rebuttal_count']!=0 ){
					$total_rebuttal_count_per = number_format(($ol['total_rebuttal_count'])*100,2);
					}else{
						$total_rebuttal_count_per = 0;
					}
						$col1 = 0;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['process']);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['feedback_count']);
						 $col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['accept_in_24']);
						 $col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$accept_per.'%');
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_acpt);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_accept_per.'%');
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['total_accept']);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$overall_accept_per.'%');
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['total_not_accept']);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$not_accept_per.'%');
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['total_rebuttal_count']);
						$col1++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$total_rebuttal_count_per.'%');
						$col1++;

						$row1++;
					 }

					 if($ttl['total_in_24']==0){

				 			$accept_per_gt = 0;
				 	}





					$accept_per_gt = number_format(($ttl['total_in_24'])*100,2);

					$post_24_acpt_gt = $ttl['total_accept'] - $ttl['total_in_24'];
					if($post_24_acpt_gt==0){

						$post_24_accept_per_gt = 0;
				 }
					$post_24_accept_per_gt = number_format(($post_24_acpt_gt)*100,2);

					$overall_accept_per_gt = number_format(($ttl['total_accept'])*100,2);

					if($ttl['total_accept']==0){

				 		$overall_accept_per_gt = 0;
				 }





					$not_accept_per_gt = number_format(($ttl['total_not_accept'])*100,2);
					if($ttl['total_not_accept']==0){

					$not_accept_per_gt = 0;
					}

					$total_rebuttal_per_gt = number_format(($ttl['total_rebuttal_count'])*100,2);
					if($ttl['total_rebuttal_count']==0){

					$total_rebuttal_per_gt = 0;
					}



					$row_gt = $row1;
					$col_gt = 0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,'Grand Total');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_feedback']);
						$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_in_24']);
						$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$accept_per_gt.'%');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_acpt_gt);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_accept_per_gt.'%');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_accept']);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$overall_accept_per_gt.'%');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_not_accept']);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$not_accept_per_gt.'%');
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_rebuttal_count']);
					$col_gt++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$total_rebuttal_per_gt.'%');
					$col_gt++;

					$row_gt++;


				// 	$colh2 = 0;
				// 	$rowt2 = $row_gt+1;
				// 	$rowh2 = $rowt2+1;
				// 	//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
				// 	$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh2.":K".$rowh2)->getFill()->applyFromArray($styleArrayh);
				// 	$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt2)->applyFromArray($style_table_name);
				// 	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt2,"Location wise Acceptance Analytics");
				// 	$sheet->mergeCells('A'.$rowt2.':K'.$rowt2);
				// 	$header_column_loc = array("Location","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

				// 	foreach($header_column_loc as $val){
				// 			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh2,$rowh2,$val);
				// 			$colh2++;
				// 	}

				// 	 foreach($locationwise_data as $office_data){
				// 	 	foreach ($office_data as $key => $loc_data) {
				// 		$location_array[] = $loc_data['office_id'];

				// 	}
				// }
				// $loc_list = array_unique($location_array);
				// 	$rloc = $rowh2+1;
				// 	unset($gt_loc);
				// 	$gt_loc = array();
				// 	foreach ($loc_list as $key => $office) {
				// 	unset($data);
				// 	$data = array();
				// 	foreach($locationwise_data as $office_datas){
				// 		foreach ($office_datas as $key => $loc_datas) {
				// 			if ($office==$loc_datas['office_id']) {
				// 				$data['office_id'] = $loc_datas['office_id'];
				// 				$data['feedback_count'] += $loc_datas['total_feedback'];
				// 				$data['approved_audit'] += $loc_datas['approved_audit'];
				// 				$data['accept_in_24'] += $loc_datas['tntfr_hr_acpt'];
				// 				$data['total_accept'] += $loc_datas['accept_count'];
				// 				$data['total_not_accept'] += $loc_datas['not_accepted_count'];

				// 				$gt_loc['total_feedback'] += $loc_datas['total_feedback'];
				// 				$gt_loc['approved_audit'] += $loc_datas['approved_audit'];
				// 				$gt_loc['total_in_24'] += $loc_datas['tntfr_hr_acpt'];
				// 				$gt_loc['total_accept'] += $loc_datas['accept_count'];
				// 				$gt_loc['total_not_accept'] += $loc_datas['not_accepted_count'];
				// 			}
				// 	}
				// }
				// if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
				// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
				// }else{
				// 	$accept_per = 0;
				// }
				// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
				// if($post_24_acpt!=0 || $data['approved_audit']!=0){
				// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
				// }else{
				// 	$post_24_accept_per = 0;
				// }
				// if($data['total_accept']!=0 || $data['approved_audit']!=0){
				// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
				// }else{
				// 	$overall_accept_per = 0;
				// }
				// if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
				// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
				// }else{
				// 	$not_accept_per = 0;
				// }

				// $cloc = 0;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['office_id']);
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['feedback_count']);
				// 	$cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['approved_audit']);
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['accept_in_24']);
				// 	$cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$accept_per.'%');
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_acpt);
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_accept_per.'%');
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_accept']);
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$overall_accept_per.'%');
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_not_accept']);
				// $cloc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$not_accept_per.'%');
				// $cloc++;

				// $rloc++;
				// }

				// $accept_per_gt = number_format(($gt_loc['total_in_24']/$gt_loc['approved_audit'])*100,2);
				// $post_24_acpt_gt = $gt_loc['total_accept'] - $gt_loc['total_in_24'];
				// $post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_loc['approved_audit'])*100,2);
				// $overall_accept_per_gt = number_format(($gt_loc['total_accept']/$gt_loc['approved_audit'])*100,2);
				// $not_accept_per_gt = number_format(($gt_loc['total_not_accept']/$gt_loc['approved_audit'])*100,2);
				// $row_gt_loc = $rloc;
				// $col_gt_loc = 0;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,'Grand Total');
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_feedback']);
				// 	$col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['approved_audit']);
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_in_24']);
				// 	$col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$accept_per_gt.'%');
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_acpt_gt);
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_accept_per_gt.'%');
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_accept']);
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$overall_accept_per_gt.'%');
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_not_accept']);
				// $col_gt_loc++;
				// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$not_accept_per_gt.'%');
				// $col_gt_loc++;

				// $row_gt_loc++;

				//lobwise table
			// 	$colh3 = 0;
			// 	$rowt3 = $row_gt_loc+1;
			// 	$rowh3 = $rowt3+1;
			// 	//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
			// 	$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh3.":K".$rowh3)->getFill()->applyFromArray($styleArrayh);
			// 	$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt3)->applyFromArray($style_table_name);
			// 	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt3,"LOB wise Acceptance Analytics");
			// 	$sheet->mergeCells('A'.$rowt3.':K'.$rowt3);
			// 	$header_column_lob = array("LOB","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

			// 	foreach($header_column_lob as $val){
			// 			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh3,$rowh3,$val);
			// 			$colh3++;
			// 	}

			// 		foreach($lobwise_data as $lob_data){
			// 		foreach ($lob_data as $key => $campaign_data) {
			// 		$lob_array[] = $campaign_data['lob_campaign'];

			// 	}
			// }
			// $lob_list = array_unique($lob_array);

			// //for ($i=0; $i <=count($loc_list) ; $i++) {
			// 	$rlob = $rowh3+1;
			// 	unset($gt_lob);
			// 	$gt_lob = array();
			// 	foreach ($lob_list as $key => $lob) {
			// 	unset($data);
			// 	$data = array();
			// 	foreach($lobwise_data as $campaign_datas){
			// 		foreach ($campaign_datas as $key => $lob_datas) {
			// 			if ($lob==$lob_datas['lob_campaign']) {
			// 				$data['lob'] = $lob_datas['lob_campaign'];
			// 				$data['feedback_count'] += $lob_datas['total_feedback'];
			// 				$data['approved_audit'] += $lob_datas['approved_audit'];
			// 				$data['accept_in_24'] += $lob_datas['tntfr_hr_acpt'];
			// 				$data['total_accept'] += $lob_datas['accept_count'];
			// 				$data['total_not_accept'] += $lob_datas['not_accepted_count'];

			// 				$gt_lob['total_feedback'] += $lob_datas['total_feedback'];
			// 				$gt_lob['approved_audit'] += $lob_datas['approved_audit'];
			// 				$gt_lob['total_in_24'] += $lob_datas['tntfr_hr_acpt'];
			// 				$gt_lob['total_accept'] += $lob_datas['accept_count'];
			// 				$gt_lob['total_not_accept'] += $lob_datas['not_accepted_count'];
			// 			}
			// 	}
			// }
			// if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
			// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
			// }else{
			// 	$accept_per = 0;
			// }
			// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
			// if($post_24_acpt!=0 || $data['approved_audit']!=0){
			// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
			// }else{
			// 	$post_24_accept_per = 0;
			// }
			// if($data['total_accept']!=0 || $data['approved_audit']!=0){
			// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
			// }else{
			// 	$overall_accept_per = 0;
			// }
			// if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
			// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
			// }else{
			// 	$not_accept_per = 0;
			// }

			
			// $clob = 0;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['lob']);
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['feedback_count']);
			// 	$clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['approved_audit']);
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['accept_in_24']);
			// 	$clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$accept_per.'%');
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_acpt);
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_accept_per.'%');
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_accept']);
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$overall_accept_per.'%');
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_not_accept']);
			// $clob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$not_accept_per.'%');
			// $clob++;

			// $rlob++;
			// }

			// $accept_per_gt = number_format(($gt_lob['total_in_24']/$gt_lob['approved_audit'])*100,2);
			// $post_24_acpt_gt = $gt_lob['total_accept'] - $gt_lob['total_in_24'];
			// $post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_lob['approved_audit'])*100,2);
			// $overall_accept_per_gt = number_format(($gt_lob['total_accept']/$gt_lob['approved_audit'])*100,2);
			// $not_accept_per_gt = number_format(($gt_lob['total_not_accept']/$gt_lob['approved_audit'])*100,2);
			// $row_gt_lob = $rlob;
			// $col_gt_lob = 0;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,'Grand Total');
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_feedback']);
			// 	$col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['approved_audit']);
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_in_24']);
			// 	$col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$accept_per_gt.'%');
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_acpt_gt);
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_accept_per_gt.'%');
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_accept']);
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$overall_accept_per_gt.'%');
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_not_accept']);
			// $col_gt_lob++;
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$not_accept_per_gt.'%');
			// $col_gt_lob++;

			// $row_gt_lob++;		

			//tlwise table row_gt
			$colh4 = 0;
			//$rowt4 = $row_gt_lob+1;
			$rowt4 = $row_gt+1;
			$rowh4 = $rowt4+1;
			//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
			$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh4.":L".$rowh4)->getFill()->applyFromArray($styleArrayh);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt4)->applyFromArray($style_table_name);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt4,"TL wise Acceptance Analytics");
			$sheet->mergeCells('A'.$rowt4.':L'.$rowt4);
			$header_column_tl = array("TL Name","Feedback Raised","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %","Rebuttal Raised","Rebuttal Raised %");

			foreach($header_column_tl as $val){
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh4,$rowh4,$val);
					$colh4++;
			}

				foreach($tlwise_data as $l1_data){
				foreach ($l1_data as $key => $tl_data) {
				$tl_array[] = $tl_data['tl_name'];

			}
		}
		$tl_list = array_unique($tl_array);

		//for ($i=0; $i <=count($loc_list) ; $i++) {
			$rtl = $rowh4+1;
			unset($gt_tl);
			$gt_tl = array();
			foreach ($tl_list as $key => $tl) {
			unset($data);
			$data = array();
			foreach($tlwise_data as $l1_datas){
				foreach ($l1_datas as $key => $tl_datas) {
					if ($tl==$tl_datas['tl_name']) {
						$data['tl_name'] = $tl_datas['tl_name'];
						$data['feedback_count'] += $tl_datas['total_feedback'];
						$data['accept_in_24'] += $tl_datas['tntfr_hr_acpt'];
						$data['total_accept'] += $tl_datas['accept_count'];
						$data['total_not_accept'] += $tl_datas['not_accepted_count'];

						$gt_tl['total_feedback'] += $tl_datas['total_feedback'];
						//$gt_tl['approved_audit'] += $tl_datas['approved_audit'];
						$data['total_rebuttal_count'] += $tl_datas['rebuttal_count'];
						$gt_tl['total_in_24'] += $tl_datas['tntfr_hr_acpt'];
						$gt_tl['total_accept'] += $tl_datas['accept_count'];
						$gt_tl['total_not_accept'] += $tl_datas['not_accepted_count'];
						$gt_tl['total_rebuttal_count'] += $tl_datas['rebuttal_count'];
					}
			}
		}
		if($data['accept_in_24']!=0){
		$accept_per = number_format(($data['accept_in_24'])*100,2);
		}else{
			$accept_per = 0;
		}
		$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
		if($post_24_acpt!=0){
		$post_24_accept_per = number_format(($post_24_acpt)*100,2);
		}else{
			$post_24_accept_per = 0;
		}
		if($data['total_accept']!=0){
		$overall_accept_per = number_format(($data['total_accept'])*100,2);
		}else{
			$overall_accept_per = 0;
		}
		if($data['total_not_accept']!=0){
		$not_accept_per = number_format(($data['total_not_accept'])*100,2);
		}else{
			$not_accept_per = 0;
		}
		if($data['total_rebuttal_count']!=0){
		$total_rebuttal_count = number_format(($data['total_rebuttal_count'])*100,2);
		}else{
			$total_rebuttal_count = 0;
		}

		$ctl = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['tl_name']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['feedback_count']);
			$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['accept_in_24']);
			$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$accept_per.'%');
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_acpt);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_accept_per.'%');
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_accept']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$overall_accept_per.'%');
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_not_accept']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$not_accept_per.'%');
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_rebuttal_count']);
		$ctl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$total_rebuttal_count.'%');
		$ctl++;

		$rtl++;
		}

		$accept_per_gt = number_format(($gt_tl['total_in_24'])*100,2);
		$post_24_acpt_gt = $gt_tl['total_accept'] - $gt_tl['total_in_24'];
		$post_24_accept_per_gt = number_format(($post_24_acpt_gt)*100,2);
		$overall_accept_per_gt = number_format(($gt_tl['total_accept'])*100,2);
		$not_accept_per_gt = number_format(($gt_tl['total_not_accept'])*100,2);
		$total_rebuttal_per_gt = number_format(($gt_tl['total_rebuttal_count'])*100,2);
		$row_gt_tl = $rtl;
		$col_gt_tl = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,'Grand Total');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_feedback']);
			$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_in_24']);
			$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$accept_per_gt.'%');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_acpt_gt);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_accept_per_gt.'%');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_accept']);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$overall_accept_per_gt.'%');
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_not_accept']);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$not_accept_per_gt.'%');
		$col_gt_tl++;

		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_rebuttal_count']);
		$col_gt_tl++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$total_rebuttal_per_gt.'%');
		$col_gt_tl++;

		$row_gt_tl++;

		//qawise table
		$colh5 = 0;
		$rowt5 = $row_gt_tl+1;
		$rowh5 = $rowt5+1;
		//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
		$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh5.":L".$rowh5)->getFill()->applyFromArray($styleArrayh);
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt5)->applyFromArray($style_table_name);
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt5,"QA wise Acceptance Analytics");
		$sheet->mergeCells('A'.$rowt5.':L'.$rowt5);
		$header_column_qa = array("QA Name","Feedback Raised","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %","Rebuttal Raised","Rebuttal Raised %");

		foreach($header_column_qa as $val){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh5,$rowh5,$val);
				$colh5++;
		}

			foreach($qawise_data as $entry_by_data){
			foreach ($entry_by_data as $key => $qa_data) {
			$qa_array[] = $qa_data['qa_name'];

		}
	}
	$qa_list = array_unique($qa_array);

	//for ($i=0; $i <=count($loc_list) ; $i++) {
		$rqa = $rowh5+1;
		unset($gt_qa);
		$gt_qa = array();
		foreach ($qa_list as $key => $qa) {
		unset($data);
		$data = array();
		foreach($qawise_data as $entry_by_datas){
			foreach ($entry_by_datas as $key => $qa_datas) {
				if ($qa==$qa_datas['qa_name']) {
					$data['qa_name'] = $qa_datas['qa_name'];
					$data['feedback_count'] += $qa_datas['total_feedback'];
					$data['accept_in_24'] += $qa_datas['tntfr_hr_acpt'];
					$data['total_accept'] += $qa_datas['accept_count'];
					$data['total_not_accept'] += $qa_datas['not_accepted_count'];
					$data['total_rebuttal_count'] += $qa_datas['rebuttal_count'];

					$gt_qa['total_feedback'] += $qa_datas['total_feedback'];
					$gt_qa['total_rebuttal_count'] += $qa_datas['rebuttal_count'];
					$gt_qa['total_in_24'] += $qa_datas['tntfr_hr_acpt'];
					$gt_qa['total_accept'] += $qa_datas['accept_count'];
					$gt_qa['total_not_accept'] += $qa_datas['not_accepted_count'];
				}
		}
	}
	if($data['accept_in_24']!=0){
	$accept_per = number_format(($data['accept_in_24'])*100,2);
	}else{
		$accept_per = 0;
	}
	$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	if($post_24_acpt!=0){
	$post_24_accept_per = number_format(($post_24_acpt)*100,2);
	}else{
		$post_24_accept_per = 0;
	}
	if($data['total_accept']!=0){
	$overall_accept_per = number_format(($data['total_accept'])*100,2);
	}else{
		$overall_accept_per = 0;
	}
	if($data['total_not_accept']!=0){
	$not_accept_per = number_format(($data['total_not_accept'])*100,2);
	}else{
		$not_accept_per = 0;
	}
	if($data['total_rebuttal_count']!=0){
	$total_rebuttal_per = number_format(($data['total_rebuttal_count'])*100,2);
	}else{
		$total_rebuttal_per = 0;
	}

	$cqa = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['qa_name']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['feedback_count']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['accept_in_24']);
		$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$accept_per.'%');
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_acpt);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_accept_per.'%');
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_accept']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$overall_accept_per.'%');
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_not_accept']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$not_accept_per.'%');
	$cqa++;

	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_rebuttal_count']);
	$cqa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$total_rebuttal_per.'%');
	$cqa++;

	$rqa++;
	}

	$accept_per_gt = number_format(($gt_qa['total_in_24'])*100,2);
	$post_24_acpt_gt = $gt_qa['total_accept'] - $gt_qa['total_in_24'];
	$post_24_accept_per_gt = number_format(($post_24_acpt_gt)*100,2);
	$overall_accept_per_gt = number_format(($gt_qa['total_accept'])*100,2);
	$not_accept_per_gt = number_format(($gt_qa['total_not_accept'])*100,2);
	$total_rebuttal_per_gt = number_format(($gt_qa['total_rebuttal_count'])*100,2);
	$row_gt_qa = $rqa;
	$col_gt_qa = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,'Grand Total');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_feedback']);
		$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_in_24']);
		$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$accept_per_gt.'%');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_acpt_gt);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_accept_per_gt.'%');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_accept']);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$overall_accept_per_gt.'%');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_not_accept']);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$not_accept_per_gt.'%');
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_rebuttal_count']);
	$col_gt_qa++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$total_rebuttal_per_gt.'%');
	$col_gt_qa++;

	$row_gt_qa++;

	//Agentwise table
	$colh6 = 0;
	$rowt6 = $row_gt_qa+1;
	$rowh6 = $rowt6+1;
	//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
	$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh6.":N".$rowh6)->getFill()->applyFromArray($styleArrayh);
	$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt6)->applyFromArray($style_table_name);
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt6,"Agent wise Acceptance Analytics");
	$sheet->mergeCells('A'.$rowt6.':N'.$rowt6);
	$header_column_agent = array("Employee ID","Agent Name","Supervisor Name","Feedback Raised","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %","Rebuttal Raised","Rebuttal Raised %");

	foreach($header_column_agent as $val){
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh6,$rowh6,$val);
			$colh6++;
	}

		foreach($agentwise_data as $agent_wise_data){
		foreach ($agent_wise_data as $key => $agent_data) {
		$agent_array[] = $agent_data['agent_name'];

	}
	}
	$agent_list = array_unique($agent_array);

	//for ($i=0; $i <=count($loc_list) ; $i++) {
	$ragent = $rowh6+1;
	unset($gt_agent);
	$gt_agent = array();
	foreach ($agent_list as $key => $agent) {
	unset($data);
	$data = array();
	foreach($agentwise_data as $agent_wise_datas){
		foreach ($agent_wise_datas as $key => $agent_datas) {
			if ($agent==$agent_datas['agent_name']) {
				$data['emp_id'] = $agent_datas['xpoid'];
				$data['agent_name'] = $agent_datas['agent_name'];
				$data['tl_name'] = $agent_datas['tl_name'];
				$data['feedback_count'] += $agent_datas['total_feedback'];
				$data['total_rebuttal_count'] += $agent_datas['rebuttal_count'];
				$data['accept_in_24'] += $agent_datas['tntfr_hr_acpt'];
				$data['total_accept'] += $agent_datas['accept_count'];
				$data['total_not_accept'] += $agent_datas['not_accepted_count'];

				$gt_agent['total_feedback'] += $agent_datas['total_feedback'];
				$gt_agent['total_rebuttal_count'] += $agent_datas['rebuttal_count'];
				$gt_agent['total_in_24'] += $agent_datas['tntfr_hr_acpt'];
				$gt_agent['total_accept'] += $agent_datas['accept_count'];
				$gt_agent['total_not_accept'] += $agent_datas['not_accepted_count'];
			}
	}
	}
	if($data['accept_in_24']!=0){
	$accept_per = number_format(($data['accept_in_24'])*100,2);
	}else{
		$accept_per = 0;
	}
	$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	if($post_24_acpt!=0){
	$post_24_accept_per = number_format(($post_24_acpt)*100,2);
	}else{
		$post_24_accept_per = 0;
	}
	if($data['total_accept']!=0){
	$overall_accept_per = number_format(($data['total_accept'])*100,2);
	}else{
		$overall_accept_per = 0;
	}
	if($data['total_not_accept']!=0){
	$not_accept_per = number_format(($data['total_not_accept'])*100,2);
	}else{
		$not_accept_per = 0;
	}
	if($data['total_rebuttal_count']!=0){
	$total_rebuttal_per = number_format(($data['total_rebuttal_count'])*100,2);
	}else{
		$total_rebuttal_per = 0;
	}
	$cagent = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['emp_id']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,ucwords(strtolower($data['agent_name'])));
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['tl_name']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['feedback_count']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['accept_in_24']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$accept_per.'%');
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_acpt);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_accept_per.'%');
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_accept']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$overall_accept_per.'%');
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_not_accept']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$not_accept_per.'%');
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_rebuttal_count']);
	$cagent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$total_rebuttal_per.'%');
	$cagent++;

	$ragent++;
	}

	$accept_per_gt = number_format(($gt_agent['total_in_24'])*100,2);
	$post_24_acpt_gt = $gt_agent['total_accept'] - $gt_agent['total_in_24'];
	$post_24_accept_per_gt = number_format(($post_24_acpt_gt)*100,2);
	$overall_accept_per_gt = number_format(($gt_agent['total_accept'])*100,2);
	$not_accept_per_gt = number_format(($gt_agent['total_not_accept'])*100,2);
	$total_rebuttal_per_gt = number_format(($gt_agent['total_rebuttal_count'])*100,2);
	$row_gt_agent = $ragent;
	$col_gt_agent = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'Grand Total');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_feedback']);
		$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_in_24']);
		$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$accept_per_gt.'%');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_acpt_gt);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_accept_per_gt.'%');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_accept']);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$overall_accept_per_gt.'%');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_not_accept']);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$not_accept_per_gt.'%');
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_rebuttal_count']);
	$col_gt_agent++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$total_rebuttal_per_gt.'%');
	$col_gt_agent++;

	$row_gt_agent++;
					/////////////////

					ob_end_clean();
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="acceptance_report.xlsx"');
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
					$objWriter->setIncludeCharts(TRUE);
					$objWriter->save('php://output');
}



/////////////////////////////END VIKAS////////////////////////////////////////

	public function acceptance_mail(){
		date_default_timezone_set("Asia/Kolkata");
		$process_sql = "SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=qa_defect.process_id Where qa_defect.is_active = 1";
		$no_of_process = $this->db->query($process_sql)->num_rows();
		$process_data = $this->Common_model->get_query_result_array($process_sql);
		$from_date = date('Y-m-01');
		//$from_date = '2022-05-10';
		$to_date = date('Y-m-d');

			// $this->objPHPExcel->createSheet();
			// $this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Acceptance Report");

			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);

		$column = 'A';
		for($i = 0; $i <= 12; $i++) {
			$objWorksheet->getColumnDimension($column)->setWidth(20);
			$column++;
		}

			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);

			$objWorksheet->getStyle("A1:L1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);

			// CELL BACKGROUNG COLOR
                $styleArrayh =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "35B8E0"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							);
			$this->objPHPExcel->getActiveSheet()->getStyle("A3:K3")->getFill()->applyFromArray($styleArrayh);

			// CELL FONT AND FONT COLOR
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14,
				'name'  => 'Algerian',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			));

			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			//$this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);

			$style_table_name = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 10,
					'name'  => 'Verdana',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				));

			//$total_column = PHPExcel_Cell::stringFromColumnIndex(12);
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "Acceptance Report");
			$sheet->mergeCells('A1:L1');

				$colh1=0;
				$rowh1=3;

				// Agent Count % List
				$this->objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_table_name);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,"Overall Acceptance Analytics");
				$sheet->mergeCells('A2:K2');
				$header_column_ol = array("Process","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");
				foreach($header_column_ol as $val){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh1,$rowh1,$val);
						$colh1++;
				}

				foreach($process_data as $p_data){
					$process = $p_data['process_name'];
					$overall_sql = "select count(t.id) as total_feedback,'$process' as process,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date'";

					$overall_data[] = $this->Common_model->get_query_row_array($overall_sql);

					$locationwise_sql = "select count(t.id) as total_feedback,'$process' as process,s.office_id,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by s.office_id";

					$locationwise_data[] = $this->Common_model->get_query_result_array($locationwise_sql);

					$lobwise_sql = "select count(t.id) as total_feedback,t.lob_campaign,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by t.lob_campaign";

					$lobwise_data[] = $this->Common_model->get_query_result_array($lobwise_sql);

					$tlwise_sql = "select count(t.id) as total_feedback,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by t.tl_id";

					$tlwise_data[] = $this->Common_model->get_query_result_array($tlwise_sql);

					$qawise_sql = "select count(t.id) as total_feedback,t.entry_by, (select concat(fname,' ',lname) as qa_name FROM signin WHERE signin.id = t.entry_by) as qa_name, (select d.description FROM signin si join department d on si.dept_id = d.id WHERE si.id = t.entry_by) as department,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by t.entry_by";

					$qawise_data[] = $this->Common_model->get_query_result_array($qawise_sql);

					$agentwise_sql = "select count(t.id) as total_feedback,concat(s.fname,' ',s.lname) as agent_name,s.xpoid,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by s.id";

					$agentwise_data[] = $this->Common_model->get_query_result_array($agentwise_sql);
				}

				// echo "<pre>";
				// print_r($locationwise_data);
				// echo "</pre>";die;
				$row1=4;
				unset($ol);
				$ol = array();
				 foreach($overall_data as $od){
				 	if ($od['total_feedback'] == 0) {
				 		continue; }else{
					$accept_per = number_format(($od['tntfr_hr_acpt']/$od['approved_audit'])*100,2);
					$post_24_acpt = $od['accept_count'] - $od['tntfr_hr_acpt'];
					$post_24_accept_per = number_format(($post_24_acpt/$od['approved_audit'])*100,2);
					$overall_accept_per = number_format(($od['accept_count']/$od['approved_audit'])*100,2);
					$not_accept_per = number_format(($od['not_accepted_count']/$od['approved_audit'])*100,2);
					$rebuttal_per = number_format(($od['rebuttal_count']/$od['approved_audit'])*100,2);
					$ol['total_feedback'] += $od['total_feedback'];
					$ol['approved_audit'] += $od['approved_audit'];
					$ol['total_in_24'] += $od['tntfr_hr_acpt'];
					$ol['total_accept'] += $od['accept_count'];
					$ol['total_not_accept'] += $od['not_accepted_count'];
					$col1 = 0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$od['process']);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$od['total_feedback']);
					 $col1++;
					 $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$od['approved_audit']);
					 $col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$od['tntfr_hr_acpt']);
					 $col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$accept_per.'%');
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_acpt);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_accept_per.'%');
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$od['accept_count']);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$overall_accept_per.'%');
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$od['not_accepted_count']);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$not_accept_per.'%');
					$col1++;

					$row1++;
				 }
				}
				$accept_per_gt = number_format(($ol['total_in_24']/$ol['approved_audit'])*100,2);
				$post_24_acpt_gt = $ol['total_accept'] - $ol['total_in_24'];
				$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$ol['approved_audit'])*100,2);
				$overall_accept_per_gt = number_format(($ol['total_accept']/$ol['approved_audit'])*100,2);
				$not_accept_per_gt = number_format(($ol['total_not_accept']/$ol['approved_audit'])*100,2);
				$row_gt = $row1;
				$col_gt = 0;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,'Grand Total');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ol['total_feedback']);
					$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ol['approved_audit']);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ol['total_in_24']);
					$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$accept_per_gt.'%');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_acpt_gt);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_accept_per_gt.'%');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ol['total_accept']);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$overall_accept_per_gt.'%');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ol['total_not_accept']);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$not_accept_per_gt.'%');
				$col_gt++;

				$row_gt++;


				$colh2 = 0;
				$rowt2 = $row_gt+1;
				$rowh2 = $rowt2+1;
				//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
				$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh2.":K".$rowh2)->getFill()->applyFromArray($styleArrayh);
				$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt2)->applyFromArray($style_table_name);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt2,"Location wise Acceptance Analytics");
				$sheet->mergeCells('A'.$rowt2.':K'.$rowt2);
				$header_column_loc = array("Location","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

				foreach($header_column_loc as $val){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh2,$rowh2,$val);
						$colh2++;
				}

				 foreach($locationwise_data as $office_data){
				 	foreach ($office_data as $key => $loc_data) {
					$location_array[] = $loc_data['office_id'];

				}
			}
			$loc_list = array_unique($location_array);

			//for ($i=0; $i <=count($loc_list) ; $i++) {
				$rloc = $rowh2+1;
				unset($gt_loc);
				$gt_loc = array();
				foreach ($loc_list as $key => $office) {
				unset($data);
				$data = array();
				foreach($locationwise_data as $office_datas){
					foreach ($office_datas as $key => $loc_datas) {
						if ($office==$loc_datas['office_id']) {
							$data['office_id'] = $loc_datas['office_id'];
							$data['feedback_count'] += $loc_datas['total_feedback'];
							$data['approved_audit'] += $loc_datas['approved_audit'];
							$data['accept_in_24'] += $loc_datas['tntfr_hr_acpt'];
							$data['total_accept'] += $loc_datas['accept_count'];
							$data['total_not_accept'] += $loc_datas['not_accepted_count'];

							$gt_loc['total_feedback'] += $loc_datas['total_feedback'];
							$gt_loc['approved_audit'] += $loc_datas['approved_audit'];
							$gt_loc['total_in_24'] += $loc_datas['tntfr_hr_acpt'];
							$gt_loc['total_accept'] += $loc_datas['accept_count'];
							$gt_loc['total_not_accept'] += $loc_datas['not_accepted_count'];
						}
				}
			}
			if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
			$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
			}else{
				$accept_per = 0;
			}
			$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
			if($post_24_acpt!=0 || $data['approved_audit']!=0){
			$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
			}else{
				$post_24_accept_per = 0;
			}
			if($data['total_accept']!=0 || $data['approved_audit']!=0){
			$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
			}else{
				$overall_accept_per = 0;
			}
			if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
			$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
			}else{
				$not_accept_per = 0;
			}

			// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
			// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
			// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
			// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
			// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
			$cloc = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['office_id']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['feedback_count']);
				$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['approved_audit']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['accept_in_24']);
				$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$accept_per.'%');
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_acpt);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_accept_per.'%');
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_accept']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$overall_accept_per.'%');
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_not_accept']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$not_accept_per.'%');
			$cloc++;

			$rloc++;
			}

			$accept_per_gt = number_format(($gt_loc['total_in_24']/$gt_loc['approved_audit'])*100,2);
			$post_24_acpt_gt = $gt_loc['total_accept'] - $gt_loc['total_in_24'];
			$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_loc['approved_audit'])*100,2);
			$overall_accept_per_gt = number_format(($gt_loc['total_accept']/$gt_loc['approved_audit'])*100,2);
			$not_accept_per_gt = number_format(($gt_loc['total_not_accept']/$gt_loc['approved_audit'])*100,2);
			$row_gt_loc = $rloc;
			$col_gt_loc = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,'Grand Total');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_feedback']);
				$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['approved_audit']);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_in_24']);
				$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$accept_per_gt.'%');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_acpt_gt);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_accept_per_gt.'%');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_accept']);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$overall_accept_per_gt.'%');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_not_accept']);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$not_accept_per_gt.'%');
			$col_gt_loc++;

			$row_gt_loc++;

			//lobwise table
			$colh3 = 0;
			$rowt3 = $row_gt_loc+1;
			$rowh3 = $rowt3+1;
			//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
			$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh3.":K".$rowh3)->getFill()->applyFromArray($styleArrayh);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt3)->applyFromArray($style_table_name);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt3,"LOB wise Acceptance Analytics");
			$sheet->mergeCells('A'.$rowt3.':K'.$rowt3);
			$header_column_lob = array("LOB","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

			foreach($header_column_lob as $val){
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh3,$rowh3,$val);
					$colh3++;
			}

				foreach($lobwise_data as $lob_data){
				foreach ($lob_data as $key => $campaign_data) {
				$lob_array[] = $campaign_data['lob_campaign'];

			}
		}
		$lob_list = array_unique($lob_array);

		//for ($i=0; $i <=count($loc_list) ; $i++) {
			$rlob = $rowh3+1;
			unset($gt_lob);
			$gt_lob = array();
			foreach ($lob_list as $key => $lob) {
			unset($data);
			$data = array();
			foreach($lobwise_data as $campaign_datas){
				foreach ($campaign_datas as $key => $lob_datas) {
					if ($lob==$lob_datas['lob_campaign']) {
						$data['lob'] = $lob_datas['lob_campaign'];
						$data['feedback_count'] += $lob_datas['total_feedback'];
						$data['approved_audit'] += $lob_datas['approved_audit'];
						$data['accept_in_24'] += $lob_datas['tntfr_hr_acpt'];
						$data['total_accept'] += $lob_datas['accept_count'];
						$data['total_not_accept'] += $lob_datas['not_accepted_count'];

						$gt_lob['total_feedback'] += $lob_datas['total_feedback'];
						$gt_lob['approved_audit'] += $lob_datas['approved_audit'];
						$gt_lob['total_in_24'] += $lob_datas['tntfr_hr_acpt'];
						$gt_lob['total_accept'] += $lob_datas['accept_count'];
						$gt_lob['total_not_accept'] += $lob_datas['not_accepted_count'];
					}
			}
		}
		if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
		$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
		}else{
			$accept_per = 0;
		}
		$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
		if($post_24_acpt!=0 || $data['approved_audit']!=0){
		$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
		}else{
			$post_24_accept_per = 0;
		}
		if($data['total_accept']!=0 || $data['approved_audit']!=0){
		$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
		}else{
			$overall_accept_per = 0;
		}
		if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
		$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
		}else{
			$not_accept_per = 0;
		}


		$clob = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['lob']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['feedback_count']);
			$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['approved_audit']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['accept_in_24']);
			$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$accept_per.'%');
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_acpt);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_accept_per.'%');
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_accept']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$overall_accept_per.'%');
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_not_accept']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$not_accept_per.'%');
		$clob++;

		$rlob++;
		}

		$accept_per_gt = number_format(($gt_lob['total_in_24']/$gt_lob['approved_audit'])*100,2);
		$post_24_acpt_gt = $gt_lob['total_accept'] - $gt_lob['total_in_24'];
		$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_lob['approved_audit'])*100,2);
		$overall_accept_per_gt = number_format(($gt_lob['total_accept']/$gt_lob['approved_audit'])*100,2);
		$not_accept_per_gt = number_format(($gt_lob['total_not_accept']/$gt_lob['approved_audit'])*100,2);
		$row_gt_lob = $rlob;
		$col_gt_lob = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,'Grand Total');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_feedback']);
			$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['approved_audit']);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_in_24']);
			$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$accept_per_gt.'%');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_acpt_gt);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_accept_per_gt.'%');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_accept']);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$overall_accept_per_gt.'%');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_not_accept']);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$not_accept_per_gt.'%');
		$col_gt_lob++;

		$row_gt_lob++;

		//tlwise table
		$colh4 = 0;
		$rowt4 = $row_gt_lob+1;
		$rowh4 = $rowt4+1;
		//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
		$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh4.":L".$rowh4)->getFill()->applyFromArray($styleArrayh);
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt4)->applyFromArray($style_table_name);
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt4,"TL wise Acceptance Analytics");
		$sheet->mergeCells('A'.$rowt4.':L'.$rowt4);
		$header_column_tl = array("TL Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

		foreach($header_column_tl as $val){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh4,$rowh4,$val);
				$colh4++;
		}

			foreach($tlwise_data as $l1_data){
			foreach ($l1_data as $key => $tl_data) {
			$tl_array[] = $tl_data['tl_name'];

		}
	}
	$tl_list = array_unique($tl_array);

	//for ($i=0; $i <=count($loc_list) ; $i++) {
		$rtl = $rowh4+1;
		unset($gt_tl);
		$gt_tl = array();
		foreach ($tl_list as $key => $tl) {
		unset($data);
		$data = array();
		foreach($tlwise_data as $l1_datas){
			foreach ($l1_datas as $key => $tl_datas) {
				if ($tl==$tl_datas['tl_name']) {
					$data['tl_name'] = $tl_datas['tl_name'];
					$data['feedback_count'] += $tl_datas['total_feedback'];
					$data['approved_audit'] += $tl_datas['approved_audit'];
					$data['accept_in_24'] += $tl_datas['tntfr_hr_acpt'];
					$data['total_accept'] += $tl_datas['accept_count'];
					$data['total_not_accept'] += $tl_datas['not_accepted_count'];

					$gt_tl['total_feedback'] += $tl_datas['total_feedback'];
					$gt_tl['approved_audit'] += $tl_datas['approved_audit'];
					$gt_tl['total_in_24'] += $tl_datas['tntfr_hr_acpt'];
					$gt_tl['total_accept'] += $tl_datas['accept_count'];
					$gt_tl['total_not_accept'] += $tl_datas['not_accepted_count'];
				}
		}
	}
	if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
	$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
	}else{
		$accept_per = 0;
	}
	$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	if($post_24_acpt!=0 || $data['approved_audit']!=0){
	$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
	}else{
		$post_24_accept_per = 0;
	}
	if($data['total_accept']!=0 || $data['approved_audit']!=0){
	$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
	}else{
		$overall_accept_per = 0;
	}
	if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
	$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
	}else{
		$not_accept_per = 0;
	}


	$ctl = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['tl_name']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['feedback_count']);
		$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['approved_audit']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['accept_in_24']);
		$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$accept_per.'%');
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_acpt);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_accept_per.'%');
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_accept']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$overall_accept_per.'%');
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_not_accept']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$not_accept_per.'%');
	$ctl++;

	$rtl++;
	}

	$accept_per_gt = number_format(($gt_tl['total_in_24']/$gt_tl['approved_audit'])*100,2);
	$post_24_acpt_gt = $gt_tl['total_accept'] - $gt_tl['total_in_24'];
	$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_tl['approved_audit'])*100,2);
	$overall_accept_per_gt = number_format(($gt_tl['total_accept']/$gt_tl['approved_audit'])*100,2);
	$not_accept_per_gt = number_format(($gt_tl['total_not_accept']/$gt_tl['approved_audit'])*100,2);
	$row_gt_tl = $rtl;
	$col_gt_tl = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,'Grand Total');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_feedback']);
		$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['approved_audit']);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_in_24']);
		$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$accept_per_gt.'%');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_acpt_gt);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_accept_per_gt.'%');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_accept']);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$overall_accept_per_gt.'%');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_not_accept']);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$not_accept_per_gt.'%');
	$col_gt_tl++;

	$row_gt_tl++;

	//qawise table
	$colh5 = 0;
	$rowt5 = $row_gt_tl+1;
	$rowh5 = $rowt5+1;
	//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
	$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh5.":K".$rowh5)->getFill()->applyFromArray($styleArrayh);
	$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt5)->applyFromArray($style_table_name);
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt5,"QA wise Acceptance Analytics");
	$sheet->mergeCells('A'.$rowt5.':K'.$rowt5);
	$header_column_qa = array("QA Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

	foreach($header_column_qa as $val){
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh5,$rowh5,$val);
			$colh5++;
	}

		foreach($qawise_data as $entry_by_data){
		foreach ($entry_by_data as $key => $qa_data) {
		$qa_array[] = $qa_data['qa_name'];

	}
}
$qa_list = array_unique($qa_array);

//for ($i=0; $i <=count($loc_list) ; $i++) {
	$rqa = $rowh5+1;
	unset($gt_qa);
	$gt_qa = array();
	foreach ($qa_list as $key => $qa) {
	unset($data);
	$data = array();
	foreach($qawise_data as $entry_by_datas){
		foreach ($entry_by_datas as $key => $qa_datas) {
			if ($qa==$qa_datas['qa_name']) {
				$data['qa_name'] = $qa_datas['qa_name'];
				$data['feedback_count'] += $qa_datas['total_feedback'];
				$data['approved_audit'] += $qa_datas['approved_audit'];
				$data['accept_in_24'] += $qa_datas['tntfr_hr_acpt'];
				$data['total_accept'] += $qa_datas['accept_count'];
				$data['total_not_accept'] += $qa_datas['not_accepted_count'];

				$gt_qa['total_feedback'] += $qa_datas['total_feedback'];
				$gt_qa['approved_audit'] += $qa_datas['approved_audit'];
				$gt_qa['total_in_24'] += $qa_datas['tntfr_hr_acpt'];
				$gt_qa['total_accept'] += $qa_datas['accept_count'];
				$gt_qa['total_not_accept'] += $qa_datas['not_accepted_count'];
			}
	}
}
if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
}else{
	$accept_per = 0;
}
$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
if($post_24_acpt!=0 || $data['approved_audit']!=0){
$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
}else{
	$post_24_accept_per = 0;
}
if($data['total_accept']!=0 || $data['approved_audit']!=0){
$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
}else{
	$overall_accept_per = 0;
}
if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
}else{
	$not_accept_per = 0;
}


$cqa = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['qa_name']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['feedback_count']);
	$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['approved_audit']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['accept_in_24']);
	$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$accept_per.'%');
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_acpt);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_accept_per.'%');
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_accept']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$overall_accept_per.'%');
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_not_accept']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$not_accept_per.'%');
$cqa++;

$rqa++;
}

$accept_per_gt = number_format(($gt_qa['total_in_24']/$gt_qa['approved_audit'])*100,2);
$post_24_acpt_gt = $gt_qa['total_accept'] - $gt_qa['total_in_24'];
$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_qa['approved_audit'])*100,2);
$overall_accept_per_gt = number_format(($gt_qa['total_accept']/$gt_qa['approved_audit'])*100,2);
$not_accept_per_gt = number_format(($gt_qa['total_not_accept']/$gt_qa['approved_audit'])*100,2);
$row_gt_qa = $rqa;
$col_gt_qa = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,'Grand Total');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_feedback']);
	$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['approved_audit']);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_in_24']);
	$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$accept_per_gt.'%');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_acpt_gt);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_accept_per_gt.'%');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_accept']);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$overall_accept_per_gt.'%');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_not_accept']);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$not_accept_per_gt.'%');
$col_gt_qa++;

$row_gt_qa++;

//Agentwise table
$colh6 = 0;
$rowt6 = $row_gt_qa+1;
$rowh6 = $rowt6+1;
//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh6.":M".$rowh6)->getFill()->applyFromArray($styleArrayh);
$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt6)->applyFromArray($style_table_name);
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt6,"Agent wise Acceptance Analytics");
$sheet->mergeCells('A'.$rowt6.':M'.$rowt6);
$header_column_agent = array("Employee ID","Agent Name","Supervisor Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

foreach($header_column_agent as $val){
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh6,$rowh6,$val);
		$colh6++;
}

	foreach($agentwise_data as $agent_wise_data){
	foreach ($agent_wise_data as $key => $agent_data) {
	$agent_array[] = $agent_data['agent_name'];

}
}
$agent_list = array_unique($agent_array);

//for ($i=0; $i <=count($loc_list) ; $i++) {
$ragent = $rowh6+1;
unset($gt_agent);
$gt_agent = array();
foreach ($agent_list as $key => $agent) {
unset($data);
$data = array();
foreach($agentwise_data as $agent_wise_datas){
	foreach ($agent_wise_datas as $key => $agent_datas) {
		if ($agent==$agent_datas['agent_name']) {
			$data['emp_id'] = $agent_datas['xpoid'];
			$data['agent_name'] = $agent_datas['agent_name'];
			$data['tl_name'] = $agent_datas['tl_name'];
			$data['feedback_count'] += $agent_datas['total_feedback'];
			$data['approved_audit'] += $agent_datas['approved_audit'];
			$data['accept_in_24'] += $agent_datas['tntfr_hr_acpt'];
			$data['total_accept'] += $agent_datas['accept_count'];
			$data['total_not_accept'] += $agent_datas['not_accepted_count'];

			$gt_agent['total_feedback'] += $agent_datas['total_feedback'];
			$gt_agent['approved_audit'] += $agent_datas['approved_audit'];
			$gt_agent['total_in_24'] += $agent_datas['tntfr_hr_acpt'];
			$gt_agent['total_accept'] += $agent_datas['accept_count'];
			$gt_agent['total_not_accept'] += $agent_datas['not_accepted_count'];
		}
}
}
if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
}else{
	$accept_per = 0;
}
$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
if($post_24_acpt!=0 || $data['approved_audit']!=0){
$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
}else{
	$post_24_accept_per = 0;
}
if($data['total_accept']!=0 || $data['approved_audit']!=0){
$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
}else{
	$overall_accept_per = 0;
}
if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
}else{
	$not_accept_per = 0;
}
$cagent = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['emp_id']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,ucwords(strtolower($data['agent_name'])));
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['tl_name']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['feedback_count']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['approved_audit']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['accept_in_24']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$accept_per.'%');
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_acpt);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_accept_per.'%');
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_accept']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$overall_accept_per.'%');
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_not_accept']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$not_accept_per.'%');
$cagent++;

$ragent++;
}

$accept_per_gt = number_format(($gt_agent['total_in_24']/$gt_agent['approved_audit'])*100,2);
$post_24_acpt_gt = $gt_agent['total_accept'] - $gt_agent['total_in_24'];
$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_agent['approved_audit'])*100,2);
$overall_accept_per_gt = number_format(($gt_agent['total_accept']/$gt_agent['approved_audit'])*100,2);
$not_accept_per_gt = number_format(($gt_agent['total_not_accept']/$gt_agent['approved_audit'])*100,2);
$row_gt_agent = $ragent;
$col_gt_agent = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'Grand Total');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_feedback']);
	$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['approved_audit']);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_in_24']);
	$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$accept_per_gt.'%');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_acpt_gt);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_accept_per_gt.'%');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_accept']);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$overall_accept_per_gt.'%');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_not_accept']);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$not_accept_per_gt.'%');
$col_gt_agent++;

$row_gt_agent++;




				/////////////////

				// ob_end_clean();
				// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				// header('Content-Disposition: attachment;filename="acceptance_report.xlsx"');
				// header('Cache-Control: max-age=0');
				// $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				// $objWriter->setIncludeCharts(TRUE);
				// $objWriter->save('php://output');

				//////////////////////

				ob_end_clean();
				$path = './uploads/test_uploads/acceptance_report.xlsx';
				$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save($path);

			//$to_[] = "siltu.koley@omindtech.com";
			$to_[] = "bompalli.somasundaram@omindtech.com";

			$to = implode(",",$to_);
			$ecc[] = 'deb.dasgupta@omindtech.com';
			$ecc[] = 'siltu.koley@omindtech.com';
			$ecc[] = 'sumitra.bagchi@omindtech.com';
			$ebody = "Hi,<br>";
			$ebody .= "<p>This mail is for testing only.</p>";
			$ebody .= "<p>Please find the Acceptance Report data sheet attached.</p>";
			$ebody .= "<p>Regards,</p>";
			$ebody .= "<p>Digit MWP Team</p>";
			$esubject = "Acceptance Report";

			//$ecc="";
			 $send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
			 unlink($path);


	return 1;

	}

	public function acceptance_report_csv(){
		date_default_timezone_set("Asia/Kolkata");
		$process_sql = "SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id=qa_defect.process_id Where qa_defect.is_active = 1";
		$no_of_process = $this->db->query($process_sql)->num_rows();
		$process_data = $this->Common_model->get_query_result_array($process_sql);
		$from_date = date('Y-m-01');
		//$from_date = '2022-05-10';
		$to_date = date('Y-m-d');

			// $this->objPHPExcel->createSheet();
			// $this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Acceptance Report");

			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);

		$column = 'A';
		for($i = 0; $i <= 12; $i++) {
			$objWorksheet->getColumnDimension($column)->setWidth(20);
			$column++;
		}

			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);

			$objWorksheet->getStyle("A1:L1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);

			// CELL BACKGROUNG COLOR
                $styleArrayh =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "35B8E0"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							);
			$this->objPHPExcel->getActiveSheet()->getStyle("A3:K3")->getFill()->applyFromArray($styleArrayh);

			// CELL FONT AND FONT COLOR
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14,
				'name'  => 'Algerian',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			));

			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			//$this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);

			$style_table_name = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 10,
					'name'  => 'Verdana',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				));

			//$total_column = PHPExcel_Cell::stringFromColumnIndex(12);
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "Acceptance Report");
			$sheet->mergeCells('A1:L1');

				$colh1=0;
				$rowh1=3;

				// Agent Count % List
				$this->objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_table_name);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,"Overall Acceptance Analytics");
				$sheet->mergeCells('A2:K2');
				$header_column_ol = array("Process","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");
				foreach($header_column_ol as $val){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh1,$rowh1,$val);
						$colh1++;
				}

				foreach($process_data as $p_data){
					$process_1 = substr($p_data['table_name'],9,-9);
					if (strpos($process_1, 'posp') !== false) {
						$process = 'POSP';
					}else{
						$process = ucwords($process_1);
					}
					$overall_sql = "select count(t.id) as total_feedback,'$process' as process,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date'";

					$overall_data[] = $this->Common_model->get_query_row_array($overall_sql);

					$locationwise_sql = "select count(t.id) as total_feedback,'$process' as process,s.office_id,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by s.office_id";

					$locationwise_data[] = $this->Common_model->get_query_result_array($locationwise_sql);

					$lobwise_sql = "select count(t.id) as total_feedback,t.lob_campaign,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
					sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
					from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by t.lob_campaign";

					$lobwise_data[] = $this->Common_model->get_query_result_array($lobwise_sql);

					$tlwise_sql = "select count(t.id) as total_feedback,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by t.tl_id";

					$tlwise_data[] = $this->Common_model->get_query_result_array($tlwise_sql);

					$qawise_sql = "select count(t.id) as total_feedback,t.entry_by, (select concat(fname,' ',lname) as qa_name FROM signin WHERE signin.id = t.entry_by) as qa_name, (select d.description FROM signin si join department d on si.dept_id = d.id WHERE si.id = t.entry_by) as department,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by t.entry_by";

					$qawise_data[] = $this->Common_model->get_query_result_array($qawise_sql);

					$agentwise_sql = "select count(t.id) as total_feedback,concat(s.fname,' ',s.lname) as agent_name,s.xpoid,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name,
					sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
					sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
					sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
					sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
					where date(t.audit_date) between '$from_date' and '$to_date' group by s.id";

					$agentwise_data[] = $this->Common_model->get_query_result_array($agentwise_sql);
				}

				// echo "<pre>";
				// print_r($locationwise_data);
				// echo "</pre>";die;

				foreach($overall_data as $pro_data){
					$pros_array[] = $pro_data['process'];
				}
				$pross_list = array_unique($pros_array);

				$row1=4;
				unset($ttl);
				$ttl = array();
			   foreach ($pross_list as $key => $pro) {
			   unset($ol);
			   $ol = array();

				   foreach ($overall_data as $key => $od) {
					   if ($pro==$od['process']) {
						   $ol['process'] = $od['process'];
						   $ol['feedback_count'] += $od['total_feedback'];
						   $ol['approved_audit'] += $od['approved_audit'];
						   $ol['accept_in_24'] += $od['tntfr_hr_acpt'];
						   $ol['total_accept'] += $od['accept_count'];
						   $ol['total_not_accept'] += $od['not_accepted_count'];

						   $ttl['total_feedback'] += $od['total_feedback'];
						   $ttl['approved_audit'] += $od['approved_audit'];
						   $ttl['total_in_24'] += $od['tntfr_hr_acpt'];
						   $ttl['total_accept'] += $od['accept_count'];
						   $ttl['total_not_accept'] += $od['not_accepted_count'];
					   }
			   }

			   if($ol['accept_in_24']!=0 ){
				$accept_per = number_format(($ol['accept_in_24']/$ol['approved_audit'])*100,2);
				}else{
					$accept_per = 0;
				}
				$post_24_acpt = $ol['total_accept'] - $ol['accept_in_24'];
				if($post_24_acpt!=0 ){
				$post_24_accept_per = number_format(($post_24_acpt/$ol['approved_audit'])*100,2);
				}else{
					$post_24_accept_per = 0;
				}
				if($ol['total_accept']!=0 ){
				$overall_accept_per = number_format(($ol['total_accept']/$ol['approved_audit'])*100,2);
				}else{
					$overall_accept_per = 0;
				}
				if($ol['total_not_accept']!=0 ){
				$not_accept_per = number_format(($ol['total_not_accept']/$ol['approved_audit'])*100,2);
				}else{
					$not_accept_per = 0;
				}
					$col1 = 0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['process']);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['feedback_count']);
					 $col1++;
					 $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['approved_audit']);
					 $col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['accept_in_24']);
					 $col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$accept_per.'%');
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_acpt);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$post_24_accept_per.'%');
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['total_accept']);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$overall_accept_per.'%');
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$ol['total_not_accept']);
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$not_accept_per.'%');
					$col1++;

					$row1++;
				 }

				$accept_per_gt = number_format(($ttl['total_in_24']/$ttl['approved_audit'])*100,2);
				$post_24_acpt_gt = $ttl['total_accept'] - $ttl['total_in_24'];
				$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$ttl['approved_audit'])*100,2);
				$overall_accept_per_gt = number_format(($ttl['total_accept']/$ttl['approved_audit'])*100,2);
				$not_accept_per_gt = number_format(($ttl['total_not_accept']/$ttl['approved_audit'])*100,2);
				$row_gt = $row1;
				$col_gt = 0;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,'Grand Total');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_feedback']);
					$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['approved_audit']);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_in_24']);
					$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$accept_per_gt.'%');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_acpt_gt);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$post_24_accept_per_gt.'%');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_accept']);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$overall_accept_per_gt.'%');
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$ttl['total_not_accept']);
				$col_gt++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt,$row_gt,$not_accept_per_gt.'%');
				$col_gt++;

				$row_gt++;


				$colh2 = 0;
				$rowt2 = $row_gt+1;
				$rowh2 = $rowt2+1;
				//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
				$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh2.":K".$rowh2)->getFill()->applyFromArray($styleArrayh);
				$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt2)->applyFromArray($style_table_name);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt2,"Location wise Acceptance Analytics");
				$sheet->mergeCells('A'.$rowt2.':K'.$rowt2);
				$header_column_loc = array("Location","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

				foreach($header_column_loc as $val){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh2,$rowh2,$val);
						$colh2++;
				}

				 foreach($locationwise_data as $office_data){
				 	foreach ($office_data as $key => $loc_data) {
					$location_array[] = $loc_data['office_id'];

				}
			}
			$loc_list = array_unique($location_array);

			//for ($i=0; $i <=count($loc_list) ; $i++) {
				$rloc = $rowh2+1;
				unset($gt_loc);
				$gt_loc = array();
				foreach ($loc_list as $key => $office) {
				unset($data);
				$data = array();
				foreach($locationwise_data as $office_datas){
					foreach ($office_datas as $key => $loc_datas) {
						if ($office==$loc_datas['office_id']) {
							$data['office_id'] = $loc_datas['office_id'];
							$data['feedback_count'] += $loc_datas['total_feedback'];
							$data['approved_audit'] += $loc_datas['approved_audit'];
							$data['accept_in_24'] += $loc_datas['tntfr_hr_acpt'];
							$data['total_accept'] += $loc_datas['accept_count'];
							$data['total_not_accept'] += $loc_datas['not_accepted_count'];

							$gt_loc['total_feedback'] += $loc_datas['total_feedback'];
							$gt_loc['approved_audit'] += $loc_datas['approved_audit'];
							$gt_loc['total_in_24'] += $loc_datas['tntfr_hr_acpt'];
							$gt_loc['total_accept'] += $loc_datas['accept_count'];
							$gt_loc['total_not_accept'] += $loc_datas['not_accepted_count'];
						}
				}
			}
			if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
			$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
			}else{
				$accept_per = 0;
			}
			$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
			if($post_24_acpt!=0 || $data['approved_audit']!=0){
			$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
			}else{
				$post_24_accept_per = 0;
			}
			if($data['total_accept']!=0 || $data['approved_audit']!=0){
			$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
			}else{
				$overall_accept_per = 0;
			}
			if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
			$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
			}else{
				$not_accept_per = 0;
			}

			// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
			// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
			// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
			// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
			// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
			$cloc = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['office_id']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['feedback_count']);
				$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['approved_audit']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['accept_in_24']);
				$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$accept_per.'%');
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_acpt);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$post_24_accept_per.'%');
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_accept']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$overall_accept_per.'%');
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$data['total_not_accept']);
			$cloc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cloc,$rloc,$not_accept_per.'%');
			$cloc++;

			$rloc++;
			}

			$accept_per_gt = number_format(($gt_loc['total_in_24']/$gt_loc['approved_audit'])*100,2);
			$post_24_acpt_gt = $gt_loc['total_accept'] - $gt_loc['total_in_24'];
			$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_loc['approved_audit'])*100,2);
			$overall_accept_per_gt = number_format(($gt_loc['total_accept']/$gt_loc['approved_audit'])*100,2);
			$not_accept_per_gt = number_format(($gt_loc['total_not_accept']/$gt_loc['approved_audit'])*100,2);
			$row_gt_loc = $rloc;
			$col_gt_loc = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,'Grand Total');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_feedback']);
				$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['approved_audit']);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_in_24']);
				$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$accept_per_gt.'%');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_acpt_gt);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$post_24_accept_per_gt.'%');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_accept']);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$overall_accept_per_gt.'%');
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$gt_loc['total_not_accept']);
			$col_gt_loc++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_loc,$row_gt_loc,$not_accept_per_gt.'%');
			$col_gt_loc++;

			$row_gt_loc++;

			//lobwise table
			$colh3 = 0;
			$rowt3 = $row_gt_loc+1;
			$rowh3 = $rowt3+1;
			//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
			$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh3.":K".$rowh3)->getFill()->applyFromArray($styleArrayh);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt3)->applyFromArray($style_table_name);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt3,"LOB wise Acceptance Analytics");
			$sheet->mergeCells('A'.$rowt3.':K'.$rowt3);
			$header_column_lob = array("LOB","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

			foreach($header_column_lob as $val){
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh3,$rowh3,$val);
					$colh3++;
			}

				foreach($lobwise_data as $lob_data){
				foreach ($lob_data as $key => $campaign_data) {
				$lob_array[] = $campaign_data['lob_campaign'];

			}
		}
		$lob_list = array_unique($lob_array);

		//for ($i=0; $i <=count($loc_list) ; $i++) {
			$rlob = $rowh3+1;
			unset($gt_lob);
			$gt_lob = array();
			foreach ($lob_list as $key => $lob) {
			unset($data);
			$data = array();
			foreach($lobwise_data as $campaign_datas){
				foreach ($campaign_datas as $key => $lob_datas) {
					if ($lob==$lob_datas['lob_campaign']) {
						$data['lob'] = $lob_datas['lob_campaign'];
						$data['feedback_count'] += $lob_datas['total_feedback'];
						$data['approved_audit'] += $lob_datas['approved_audit'];
						$data['accept_in_24'] += $lob_datas['tntfr_hr_acpt'];
						$data['total_accept'] += $lob_datas['accept_count'];
						$data['total_not_accept'] += $lob_datas['not_accepted_count'];

						$gt_lob['total_feedback'] += $lob_datas['total_feedback'];
						$gt_lob['approved_audit'] += $lob_datas['approved_audit'];
						$gt_lob['total_in_24'] += $lob_datas['tntfr_hr_acpt'];
						$gt_lob['total_accept'] += $lob_datas['accept_count'];
						$gt_lob['total_not_accept'] += $lob_datas['not_accepted_count'];
					}
			}
		}
		if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
		$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
		}else{
			$accept_per = 0;
		}
		$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
		if($post_24_acpt!=0 || $data['approved_audit']!=0){
		$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
		}else{
			$post_24_accept_per = 0;
		}
		if($data['total_accept']!=0 || $data['approved_audit']!=0){
		$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
		}else{
			$overall_accept_per = 0;
		}
		if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
		$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
		}else{
			$not_accept_per = 0;
		}

		// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
		// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
		// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
		// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
		// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
		$clob = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['lob']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['feedback_count']);
			$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['approved_audit']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['accept_in_24']);
			$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$accept_per.'%');
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_acpt);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$post_24_accept_per.'%');
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_accept']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$overall_accept_per.'%');
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$data['total_not_accept']);
		$clob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clob,$rlob,$not_accept_per.'%');
		$clob++;

		$rlob++;
		}

		$accept_per_gt = number_format(($gt_lob['total_in_24']/$gt_lob['approved_audit'])*100,2);
		$post_24_acpt_gt = $gt_lob['total_accept'] - $gt_lob['total_in_24'];
		$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_lob['approved_audit'])*100,2);
		$overall_accept_per_gt = number_format(($gt_lob['total_accept']/$gt_lob['approved_audit'])*100,2);
		$not_accept_per_gt = number_format(($gt_lob['total_not_accept']/$gt_lob['approved_audit'])*100,2);
		$row_gt_lob = $rlob;
		$col_gt_lob = 0;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,'Grand Total');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_feedback']);
			$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['approved_audit']);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_in_24']);
			$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$accept_per_gt.'%');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_acpt_gt);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$post_24_accept_per_gt.'%');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_accept']);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$overall_accept_per_gt.'%');
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$gt_lob['total_not_accept']);
		$col_gt_lob++;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_lob,$row_gt_lob,$not_accept_per_gt.'%');
		$col_gt_lob++;

		$row_gt_lob++;

		//tlwise table
		$colh4 = 0;
		$rowt4 = $row_gt_lob+1;
		$rowh4 = $rowt4+1;
		//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
		$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh4.":K".$rowh4)->getFill()->applyFromArray($styleArrayh);
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt4)->applyFromArray($style_table_name);
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt4,"TL wise Acceptance Analytics");
		$sheet->mergeCells('A'.$rowt4.':K'.$rowt4);
		$header_column_tl = array("TL Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

		foreach($header_column_tl as $val){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh4,$rowh4,$val);
				$colh4++;
		}

			foreach($tlwise_data as $l1_data){
			foreach ($l1_data as $key => $tl_data) {
			$tl_array[] = $tl_data['tl_name'];

		}
	}
	$tl_list = array_unique($tl_array);

	//for ($i=0; $i <=count($loc_list) ; $i++) {
		$rtl = $rowh4+1;
		unset($gt_tl);
		$gt_tl = array();
		foreach ($tl_list as $key => $tl) {
		unset($data);
		$data = array();
		foreach($tlwise_data as $l1_datas){
			foreach ($l1_datas as $key => $tl_datas) {
				if ($tl==$tl_datas['tl_name']) {
					$data['tl_name'] = $tl_datas['tl_name'];
					$data['feedback_count'] += $tl_datas['total_feedback'];
					$data['approved_audit'] += $tl_datas['approved_audit'];
					$data['accept_in_24'] += $tl_datas['tntfr_hr_acpt'];
					$data['total_accept'] += $tl_datas['accept_count'];
					$data['total_not_accept'] += $tl_datas['not_accepted_count'];

					$gt_tl['total_feedback'] += $tl_datas['total_feedback'];
					$gt_tl['approved_audit'] += $tl_datas['approved_audit'];
					$gt_tl['total_in_24'] += $tl_datas['tntfr_hr_acpt'];
					$gt_tl['total_accept'] += $tl_datas['accept_count'];
					$gt_tl['total_not_accept'] += $tl_datas['not_accepted_count'];
				}
		}
	}
	if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
	$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
	}else{
		$accept_per = 0;
	}
	$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	if($post_24_acpt!=0 || $data['approved_audit']!=0){
	$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
	}else{
		$post_24_accept_per = 0;
	}
	if($data['total_accept']!=0 || $data['approved_audit']!=0){
	$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
	}else{
		$overall_accept_per = 0;
	}
	if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
	$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
	}else{
		$not_accept_per = 0;
	}

	// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
	// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
	// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
	// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
	// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
	$ctl = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['tl_name']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['feedback_count']);
		$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['approved_audit']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['accept_in_24']);
		$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$accept_per.'%');
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_acpt);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$post_24_accept_per.'%');
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_accept']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$overall_accept_per.'%');
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$data['total_not_accept']);
	$ctl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ctl,$rtl,$not_accept_per.'%');
	$ctl++;

	$rtl++;
	}

	$accept_per_gt = number_format(($gt_tl['total_in_24']/$gt_tl['approved_audit'])*100,2);
	$post_24_acpt_gt = $gt_tl['total_accept'] - $gt_tl['total_in_24'];
	$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_tl['approved_audit'])*100,2);
	$overall_accept_per_gt = number_format(($gt_tl['total_accept']/$gt_tl['approved_audit'])*100,2);
	$not_accept_per_gt = number_format(($gt_tl['total_not_accept']/$gt_tl['approved_audit'])*100,2);
	$row_gt_tl = $rtl;
	$col_gt_tl = 0;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,'Grand Total');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_feedback']);
		$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['approved_audit']);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_in_24']);
		$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$accept_per_gt.'%');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_acpt_gt);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$post_24_accept_per_gt.'%');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_accept']);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$overall_accept_per_gt.'%');
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$gt_tl['total_not_accept']);
	$col_gt_tl++;
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_tl,$row_gt_tl,$not_accept_per_gt.'%');
	$col_gt_tl++;

	$row_gt_tl++;

	//qawise table
	$colh5 = 0;
	$rowt5 = $row_gt_tl+1;
	$rowh5 = $rowt5+1;
	//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
	$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh5.":K".$rowh5)->getFill()->applyFromArray($styleArrayh);
	$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt5)->applyFromArray($style_table_name);
	$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt5,"QA wise Acceptance Analytics");
	$sheet->mergeCells('A'.$rowt5.':K'.$rowt5);
	$header_column_qa = array("QA Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

	foreach($header_column_qa as $val){
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh5,$rowh5,$val);
			$colh5++;
	}

		foreach($qawise_data as $entry_by_data){
		foreach ($entry_by_data as $key => $qa_data) {
		$qa_array[] = $qa_data['qa_name'];

	}
}
$qa_list = array_unique($qa_array);

//for ($i=0; $i <=count($loc_list) ; $i++) {
	$rqa = $rowh5+1;
	unset($gt_qa);
	$gt_qa = array();
	foreach ($qa_list as $key => $qa) {
	unset($data);
	$data = array();
	foreach($qawise_data as $entry_by_datas){
		foreach ($entry_by_datas as $key => $qa_datas) {
			if ($qa==$qa_datas['qa_name']) {
				$data['qa_name'] = $qa_datas['qa_name'];
				$data['feedback_count'] += $qa_datas['total_feedback'];
				$data['approved_audit'] += $qa_datas['approved_audit'];
				$data['accept_in_24'] += $qa_datas['tntfr_hr_acpt'];
				$data['total_accept'] += $qa_datas['accept_count'];
				$data['total_not_accept'] += $qa_datas['not_accepted_count'];

				$gt_qa['total_feedback'] += $qa_datas['total_feedback'];
				$gt_qa['approved_audit'] += $qa_datas['approved_audit'];
				$gt_qa['total_in_24'] += $qa_datas['tntfr_hr_acpt'];
				$gt_qa['total_accept'] += $qa_datas['accept_count'];
				$gt_qa['total_not_accept'] += $qa_datas['not_accepted_count'];
			}
	}
}
if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
}else{
	$accept_per = 0;
}
$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
if($post_24_acpt!=0 || $data['approved_audit']!=0){
$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
}else{
	$post_24_accept_per = 0;
}
if($data['total_accept']!=0 || $data['approved_audit']!=0){
$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
}else{
	$overall_accept_per = 0;
}
if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
}else{
	$not_accept_per = 0;
}

// $accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
// $post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
// $post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
// $overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
// $not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
$cqa = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['qa_name']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['feedback_count']);
	$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['approved_audit']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['accept_in_24']);
	$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$accept_per.'%');
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_acpt);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$post_24_accept_per.'%');
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_accept']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$overall_accept_per.'%');
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$data['total_not_accept']);
$cqa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cqa,$rqa,$not_accept_per.'%');
$cqa++;

$rqa++;
}

$accept_per_gt = number_format(($gt_qa['total_in_24']/$gt_qa['approved_audit'])*100,2);
$post_24_acpt_gt = $gt_qa['total_accept'] - $gt_qa['total_in_24'];
$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_qa['approved_audit'])*100,2);
$overall_accept_per_gt = number_format(($gt_qa['total_accept']/$gt_qa['approved_audit'])*100,2);
$not_accept_per_gt = number_format(($gt_qa['total_not_accept']/$gt_qa['approved_audit'])*100,2);
$row_gt_qa = $rqa;
$col_gt_qa = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,'Grand Total');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_feedback']);
	$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['approved_audit']);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_in_24']);
	$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$accept_per_gt.'%');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_acpt_gt);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$post_24_accept_per_gt.'%');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_accept']);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$overall_accept_per_gt.'%');
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$gt_qa['total_not_accept']);
$col_gt_qa++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_qa,$row_gt_qa,$not_accept_per_gt.'%');
$col_gt_qa++;

$row_gt_qa++;

//Agentwise table
$colh6 = 0;
$rowt6 = $row_gt_qa+1;
$rowh6 = $rowt6+1;
//$column_index = PHPExcel_Cell::stringFromColumnIndex($total_rows);
$this->objPHPExcel->getActiveSheet()->getStyle("A".$rowh6.":M".$rowh6)->getFill()->applyFromArray($styleArrayh);
$this->objPHPExcel->getActiveSheet()->getStyle('A'.$rowt6)->applyFromArray($style_table_name);
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowt6,"Agent wise Acceptance Analytics");
$sheet->mergeCells('A'.$rowt6.':M'.$rowt6);
$header_column_agent = array("Employee ID","Agent Name","Supervisor Name","Feedback Raised","Approved Feedback","Feedback accepted <24 hrs","Feedback accepted <24 hrs %","Feedback accepted Post 24 hrs","Feedback accepted Post 24 hrs %","Feedback Accepted","Overall Acceptance %","Feedback not accepted","Feedback not accepted %");

foreach($header_column_agent as $val){
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colh6,$rowh6,$val);
		$colh6++;
}

	foreach($agentwise_data as $agent_wise_data){
	foreach ($agent_wise_data as $key => $agent_data) {
	$agent_array[] = $agent_data['agent_name'];

}
}
$agent_list = array_unique($agent_array);

//for ($i=0; $i <=count($loc_list) ; $i++) {
$ragent = $rowh6+1;
unset($gt_agent);
$gt_agent = array();
foreach ($agent_list as $key => $agent) {
unset($data);
$data = array();
foreach($agentwise_data as $agent_wise_datas){
	foreach ($agent_wise_datas as $key => $agent_datas) {
		if ($agent==$agent_datas['agent_name']) {
			$data['emp_id'] = $agent_datas['xpoid'];
			$data['agent_name'] = $agent_datas['agent_name'];
			$data['tl_name'] = $agent_datas['tl_name'];
			$data['feedback_count'] += $agent_datas['total_feedback'];
			$data['approved_audit'] += $agent_datas['approved_audit'];
			$data['accept_in_24'] += $agent_datas['tntfr_hr_acpt'];
			$data['total_accept'] += $agent_datas['accept_count'];
			$data['total_not_accept'] += $agent_datas['not_accepted_count'];

			$gt_agent['total_feedback'] += $agent_datas['total_feedback'];
			$gt_agent['approved_audit'] += $agent_datas['approved_audit'];
			$gt_agent['total_in_24'] += $agent_datas['tntfr_hr_acpt'];
			$gt_agent['total_accept'] += $agent_datas['accept_count'];
			$gt_agent['total_not_accept'] += $agent_datas['not_accepted_count'];
		}
}
}
if($data['accept_in_24']!=0 || $data['approved_audit']!=0){
$accept_per = number_format(($data['accept_in_24']/$data['approved_audit'])*100,2);
}else{
	$accept_per = 0;
}
$post_24_acpt = $data['total_accept'] - $data['accept_in_24'];
if($post_24_acpt!=0 || $data['approved_audit']!=0){
$post_24_accept_per = number_format(($post_24_acpt/$data['approved_audit'])*100,2);
}else{
	$post_24_accept_per = 0;
}
if($data['total_accept']!=0 || $data['approved_audit']!=0){
$overall_accept_per = number_format(($data['total_accept']/$data['approved_audit'])*100,2);
}else{
	$overall_accept_per = 0;
}
if($data['total_not_accept']!=0 || $data['approved_audit']!=0){
$not_accept_per = number_format(($data['total_not_accept']/$data['approved_audit'])*100,2);
}else{
	$not_accept_per = 0;
}
$cagent = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['emp_id']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,ucwords(strtolower($data['agent_name'])));
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['tl_name']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['feedback_count']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['approved_audit']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['accept_in_24']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$accept_per.'%');
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_acpt);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$post_24_accept_per.'%');
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_accept']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$overall_accept_per.'%');
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$data['total_not_accept']);
$cagent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cagent,$ragent,$not_accept_per.'%');
$cagent++;

$ragent++;
}

$accept_per_gt = number_format(($gt_agent['total_in_24']/$gt_agent['approved_audit'])*100,2);
$post_24_acpt_gt = $gt_agent['total_accept'] - $gt_agent['total_in_24'];
$post_24_accept_per_gt = number_format(($post_24_acpt_gt/$gt_agent['approved_audit'])*100,2);
$overall_accept_per_gt = number_format(($gt_agent['total_accept']/$gt_agent['approved_audit'])*100,2);
$not_accept_per_gt = number_format(($gt_agent['total_not_accept']/$gt_agent['approved_audit'])*100,2);
$row_gt_agent = $ragent;
$col_gt_agent = 0;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'Grand Total');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,'');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_feedback']);
	$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['approved_audit']);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_in_24']);
	$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$accept_per_gt.'%');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_acpt_gt);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$post_24_accept_per_gt.'%');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_accept']);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$overall_accept_per_gt.'%');
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$gt_agent['total_not_accept']);
$col_gt_agent++;
$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_gt_agent,$row_gt_agent,$not_accept_per_gt.'%');
$col_gt_agent++;

$row_gt_agent++;




				/////////////////

				ob_end_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="acceptance_report.xlsx"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save('php://output');


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

			$SQLtxt = "SELECT process_id as id, REPLACE(REPLACE(REPLACE(table_name, 'qa_',''), '_feedback', ''), '_', ' ') as name FROM qa_defect where 1 $extraFilter  AND process_id NOT IN ('304') order by name";

			if(get_login_type() == 'client'){
				$my_client_ids = !empty(get_clients_client_id()) ? get_clients_client_id() : -1;
				$my_process_ids = !empty(get_clients_process_id()) ? get_clients_process_id() : -1;
				$SQLtxt = "SELECT process_id as id, REPLACE(table_name, 'qa_','') as name FROM qa_defect where 1  AND client_id IN ($my_client_ids) AND FLOOR(process_id) IN ($my_process_ids) $extraFilter order by name";
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

	

	public function getLOB(){
		$pid = $this->input->post('pid');

		$sqlLob = "SELECT id, campaign FROM campaign where process_id=$pid AND is_active=1";
		echo json_encode($this->Common_model->get_query_result_array($sqlLob));
	}
	
	public function get_process_by_client(){

		if(check_logged_in()){
			$client_id = $this->input->post('clientId');

			$sql = "SELECT p.id as process_id,p.name as process_name FROM process p WHERE p.id <> 0 AND p.is_active = 1 AND p.client_id = $client_id";
			$process_list = $this->db->query($sql)->result_array();

			echo json_encode(array('success'=>true,'processList'=>$process_list));
		}
	}

	public function get_campaign_by_process(){

		if(check_logged_in()){
			$client_id = $this->input->post('clientId');
			$process_id = $this->input->post('processId');

			$sql = "SELECT qd.id as campaign_id,REPLACE(REPLACE(REPLACE(qd.table_name,'qa_',''),'_feedback',''),'_',' ') as campaign_name FROM qa_defect qd WHERE qd.id <> 0 AND qd.is_active = 1 AND qd.client_id = $client_id AND FLOOR(qd.process_id) = $process_id";
			$campaign_list = $this->db->query($sql)->result_array();

			echo json_encode(array('success'=>true,'campaignList'=>$campaign_list));
		}
	}	
}
