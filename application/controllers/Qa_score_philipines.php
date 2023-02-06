<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_score_philipines extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Email_model'); // Added Email model 
		
		$this->objPHPExcel = new PHPExcel();
	}
	

	public function index()
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids(); 
			
			$data["aside_template"] 	= "qa/aside.php";
			$data["content_template"] 	= "qa_score_philipines/qa_score_philipines.php";
			$data["content_js"] 		= "qa_philipines_dashboard_js.php";
			
			$cond="";
			//$from_date = $this->input->get('from_date');
			//$to_date = $this->input->get('to_date');
			$from_date = $this->input->get('month_year')?$this->input->get('month_year'):date('Y-m-01');
			if ($this->input->get('month_year') != "") {
				$to_date = date('Y-m-t', strtotime($from_date));
			}else{
				$to_date = date('Y-m-t');
			}

			$search_month = $this->input->get('select_month');
			$search_year  = $this->input->get('select_year');
			if($search_month == ""){ $search_month = date('m'); }
			if($search_year == ""){ $search_year = date('Y'); }
			
			if(($search_month  != "") && ($search_year  != "")){
				
				$start_date = $search_year ."-" .$search_month ."-" ."01";
				$end_date   = $search_year ."-" .$search_month ."-" .cal_days_in_month(CAL_GREGORIAN, $search_month, $search_year);
				
				$start_date_full = $start_date ." 00:00:00";
				$end_date_full   = $end_date ." 23:59:59";
				
			}
			
			//$data['start_date'] = $start_date;
			//$data['end_date']   = $end_date;
			$data['selected_month'] = $search_month;
			$data['selected_year']  = $search_year;

			//$process_id = $this->input->get('process_id');
			$select_client   = $this->input->get('select_client');
			$select_process  = $this->input->get('select_process');
			

			// $sqlPhilipines = "SELECT s.office_id,c.id as client_id,i.process_id,c.fullname as 					clientName,p.name as processName
			// 					FROM info_assign_process i 
			// 					LEFT JOIN signin s ON s.id=i.user_id
			// 					LEFT JOIN process p ON p.id=i.process_id
			// 					LEFT JOIN client c ON p.client_id=c.id
			// 					LEFT JOIN info_assign_client ic ON c.id=ic.client_id
			// 					where c.is_active=1 and p.client_id not in (0) and s.office_id in ('CEB','MAN') and c.id not in('4','90','291','312','324','339','342','345','352','355','357') group by p.id order by s.office_id
			// 				 ";

			$sqlPhilipines = "SELECT def.table_name,s.office_id,c.id as clientId,def.process_id,c.fullname as clientName,p.name as processName
                                FROM qa_defect def
                                LEFT JOIN client c
                                ON def.client_id = c.id
                                LEFT JOIN process p 
                                ON def.process_id=p.id
                                LEFT JOIN info_assign_client ic
                                ON c.id = ic.client_id
                                LEFT JOIN signin s ON s.id=ic.user_id
                                where c.is_active=1 and def.client_id not in (0) and s.office_id in ('CEB','MAN') and c.id not in('134','275','4','90','291','312','324','339','342','345','352','355','357') group by def.process_id order by c.fullname";				 
			$resPhilipines = $this->Common_model->get_query_result_array($sqlPhilipines);
			// echo"<pre>";
			// print_r($resPhilipines);
			// echo"</pre>";
			// exit();
			//Debt Solution 123 : qa_loanxm_voicemail_feedback has no process id in process table and no entry in qa_defect table.it has same process id as qa_loanxm_feedback as process_id= 49 client_id=37

			$resultData = array();
			
			//if($this->input->get('btnView')=='View')
			//{
				foreach($resPhilipines as $key=> $rowQuery)
				{
					// $process_id = $rowPhilipines['process_id'];
					// $office_id  = $rowPhilipines['office_id'];
					// if($office_id == 'CEB' || $office_id == 'MAN'){
					// $query = 'SELECT table_name, process_id,process.client_id as clientId, params_columns,defect_column_names, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id)';	
					
					//  $rowQuery = $this->Common_model->get_query_row_array($query);

					if($rowQuery)
					{
					 	
					 	if ($this->db->field_exists('business_score', $rowQuery['table_name']) && $this->db->field_exists('customer_score', $rowQuery['table_name']) && $this->db->field_exists('compliance_score', $rowQuery['table_name'])
					 		)
						{
						    $qm_sql1 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
						 (select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,
								CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,
								CAST(SUM(business_score) AS DECIMAL(10,2)) as business_score,
								CAST(SUM(customer_score) AS DECIMAL(10,2)) as customer_score,
								CAST(SUM(compliance_score) AS DECIMAL(10,2)) as complience_score,
								(select count(ph.id) as business_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.business_score != "") as business_cnt,
								(select count(ph.id) as customer_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.customer_score != "") as customer_cnt,
								(select count(ph.id) as compliance_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.compliance_score != "") as compliance_cnt,  
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach1 =  $this->Common_model->get_query_row_array($qm_sql1);
								if($resultDataEach1){
									$resultData[] = $resultDataEach1;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								
									//exit();
								}
								
								// echo"<pre>";
								// print_r($resultData);
								// echo"</pre>";
								// exit();

								//$resultData[] =  $this->Common_model->get_query_row_array($qm_sql1);
						}else if($this->db->field_exists('business_score', $rowQuery['table_name'])){

							$qm_sql4 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
						 (select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,CAST(AVG(business_score) AS DECIMAL(10,2)) as business_score,
								(select count(ph.id) as business_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.business_score != "") as business_cnt,  
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where  ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach4 =  $this->Common_model->get_query_row_array($qm_sql4);
								if($resultDataEach1){
									$resultData[] = $resultDataEach4;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}

						}else if($this->db->field_exists('customer_score', $rowQuery['table_name'])){

							$qm_sql5 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
						 (select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,CAST(AVG(customer_score) AS DECIMAL(10,2)) as customer_score,
								(select count(ph.id) as customer_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.customer_score != "") as customer_cnt, 
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where  ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach5 =  $this->Common_model->get_query_row_array($qm_sql5);
								if($resultDataEach5){
									$resultData[] = $resultDataEach5;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}

						}else if($this->db->field_exists('compliance_score', $rowQuery['table_name'])){
							$qm_sql6 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
						 (select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,CAST(AVG(compliance_score) AS DECIMAL(10,2)) as complience_score,
								(select count(ph.id) as compliance_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.compliance_score != "") as compliance_cnt,  
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where  ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach6 =  $this->Common_model->get_query_row_array($qm_sql6);
								if($resultDataEach6){
									$resultData[] = $resultDataEach6;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}
						}else if($this->db->field_exists('business_score', $rowQuery['table_name']) && $this->db->field_exists('customer_score', $rowQuery['table_name'])){
							$qm_sql7 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
						 (select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,CAST(AVG(business_score) AS DECIMAL(10,2)) as business_score,CAST(AVG(customer_score) AS DECIMAL(10,2)) as customer_score,
								(select count(ph.id) as business_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.business_score != "") as business_cnt,
								(select count(ph.id) as customer_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.customer_score != "") as customer_cnt, 
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where  ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach7 =  $this->Common_model->get_query_row_array($qm_sql7);
								if($resultDataEach7){
									$resultData[] = $resultDataEach7;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}

						}else if($this->db->field_exists('business_score', $rowQuery['table_name']) && $this->db->field_exists('compliance_score', $rowQuery['table_name'])){
							$qm_sql8 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
						 (select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,CAST(AVG(business_score) AS DECIMAL(10,2)) as business_score,CAST(AVG(compliance_score) AS DECIMAL(10,2)) as complience_score,
								(select count(ph.id) as business_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.business_score != "") as business_cnt,
								(select count(ph.id) as compliance_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.compliance_score != "") as compliance_cnt,  
								count(phs.entry_by) as audit_no,
								(select count(id) as autoFail from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0 as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach8 =  $this->Common_model->get_query_row_array($qm_sql8);
								if($resultDataEach8){
									$resultData[] = $resultDataEach8;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}

						}else if($this->db->field_exists('customer_score', $rowQuery['table_name']) && $this->db->field_exists('compliance_score', $rowQuery['table_name'])){
							$qm_sql9 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
						 (select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,CAST(AVG(customer_score) AS DECIMAL(10,2)) as customer_score,CAST(AVG(compliance_score) AS DECIMAL(10,2)) as complience_score,
								(select count(ph.id) as customer_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.customer_score != "") as customer_cnt,
								(select count(ph.id) as compliance_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.compliance_score != "") as compliance_cnt,  
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach9 =  $this->Common_model->get_query_row_array($qm_sql9);
								if($resultDataEach9){
									$resultData[] = $resultDataEach9;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}

						}
						else if($this->db->field_exists('businessscore', $rowQuery['table_name']) && $this->db->field_exists('customerscore', $rowQuery['table_name']) && $this->db->field_exists('businessscore', $rowQuery['table_name'])
							){
							 $qm_sql3 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
							(select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score,CAST(SUM(business_score_percent) AS DECIMAL(10,2)) as business_score,CAST(SUM(customer_score_percent) AS DECIMAL(10,2)) as customer_score,CAST(SUM(compliance_score_percent) AS DECIMAL(10,2)) as complience_score,
								(select count(ph.id) as business_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.businessscore != "") as business_cnt,
								(select count(ph.id) as customer_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.customerscore != "") as customer_cnt,
								(select count(ph.id) as compliance_cnt from '.$rowQuery['table_name'].'  ph where ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.compliancescore != "") as compliance_cnt,  
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where  ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach3 =  $this->Common_model->get_query_row_array($qm_sql3);
								if($resultDataEach3){
									$resultData[] = $resultDataEach3;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}
								//$resultData[] =  $this->Common_model->get_query_row_array($qm_sql3);
						}
						else
						{
							$qm_sql2 = 'Select phs.agent_id, (select concat(fname, " ", lname)as name from signin where signin.id=phs.agent_id) as agent_name, (select xpoid as xpoid from signin where signin.id=phs.agent_id) as xpoid,
							(select p.name as processName  from process p WHERE p.id='.$rowQuery['process_id'].') as processName,
						 (select c.fullname as clientName  from client c WHERE c.id='.$rowQuery['clientId'].') as clientName,
								(select location from office_location where abbr=(select office_id from signin os where os.id=phs.agent_id)) as qa_location,CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score, 
								count(phs.entry_by) as audit_no,
								(select count(ph.id) as autoFail from '.$rowQuery['table_name'].'  ph where  ph.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(ph.audit_date) = "'.$search_month.'") and YEAR(ph.audit_date) = "'.$search_year.'" and ph.overall_score = 0) as autoFail
								FROM '.$rowQuery['table_name'].' phs LEFT JOIN signin ON signin.id=phs.entry_by 
								WHERE phs.audit_type NOT IN ("OJT", "Certificate Audit", "Calibration") AND ( MONTH(phs.audit_date) = "'.$search_month.'") and YEAR(phs.audit_date) = "'.$search_year.'" group by qa_location order by phs.overall_score desc';
								$resultDataEach2 =  $this->Common_model->get_query_row_array($qm_sql2);
								if($resultDataEach2){
									$resultData[] = $resultDataEach2;
									$resultData[] = array("table_name" => $rowQuery['table_name'], "office_abbr" => $rowQuery['office_id']);
									//$resultData2 = array_merge($resultData, $resultData1);
								}
						}	
							//exit();					
					}
				}
			}

			// echo"<pre>";
			// print_r($resultData);
			// echo"</pre>";
			// die();
			$data['resultData']  = $resultData;
			$this->load->view("dashboard",$data);
		}
	}
?>