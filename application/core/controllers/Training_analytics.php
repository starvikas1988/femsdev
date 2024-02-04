<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training_analytics extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->model('Email_model');
		$this->load->library('excel');
	}
	
	
//==================================== TRAINING ANALYTICS =================================//	

	public function training()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$batch="";
			$cond="";
			$filterCond="";
			$filterCond2="";
			$filterCond3 = "";
			$filterCond4 = " and trn_batch_status = '1' ";
			$filterCond5 = " and (tb.trn_batch_status = '1' OR (nest.id <> '' AND nest.trn_batch_status = '1'))";
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="" ) $oValue=$user_office_id;
			$data['oValue']=$oValue;
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				if($this->check_all_training_access())
				{
					$access_office_ids = $this->check_all_training_access('office');
					$extra_access_office = implode("','", $access_office_ids);
					$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
					$query = $this->db->query($sql_office);
					$data['location_list'] = $query->result_array();
				}
			}
			
			
			if($oValue!="ALL" ){
					$filterCond = " and (location='$oValue' OR tb.batch_office_id = '$oValue') ";
					$filterCond2 = " and (location_id='$oValue' OR tb.batch_office_id = '$oValue') ";
			}
			
			
			
			if($this->input->get('searchtraining'))
			{
				$daterange_full = $this->input->get('daterange');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$filterCond3 = " AND tb.trn_start_date >= '$startdate_range' AND tb.trn_start_date <= '$enddate_range'";
				$filterCond4 = ""; $filterCond5 = "";
				
			}	
			
			if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
				
				$qSql = "Select tb.id, tb.trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, tb.batch_office_id, tb.batch_name, location, tb.trn_start_date, tb.trn_batch_status, CASE WHEN tb.batch_office_id <> '' THEN tb.batch_office_id ELSE location end as office_loc, nest.trn_batch_status as nest_status 
				from training_batch tb 
				left join process p on p.id= tb.process_id
				left join client c on c.id= tb.client_id
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
				LEFT JOIN training_batch nest ON nest.ref_id=tb.id
				where tb.trn_type=2 $filterCond5 $filterCond $filterCond3			
				group by office_loc, tb.client_id, tb.process_id";				
				$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
				
			}else{
				
				$qSql = "Select tb.id, tb.trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, tb.batch_office_id, tb.batch_name, location, job_title, tb.trn_start_date, tb.trn_batch_status,  CASE WHEN tb.batch_office_id <> '' THEN tb.batch_office_id ELSE location end as office_loc, nest.trn_batch_status as nest_status   
				from training_batch tb
				left join process p on p.id= tb.process_id
				left join client c on c.id= tb.client_id
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
				LEFT JOIN training_batch nest ON nest.ref_id=tb.id
				where tb.trainer_id='$current_user' and tb.trn_type=2 $filterCond5 $filterCond3
				group by office_loc, tb.client_id, tb.process_id";				
				$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
				
			}
			
			//echo $qSql;
			foreach($process_batch as $token)
			{
				//echo "<pre>" .print_r($token) ."</pre>";
				$trainer_id= $token['trainer_id'];
				$batch_id= $token['id'];
				$client_id= $token['client_id'];
				$process_id= $token['process_id'];
				$location= $token['location'];
		
				if(!empty($token['batch_office_id'])){ $location = $token['batch_office_id']; }
				if(!empty($token['batch_name'])){ $batch_name = $token['batch_name']; }				
				$key = $location."-".$client_id."-".$process_id;
				
				/*$qSql = "Select tb.id, tb.trn_batch_status, tb.trainer_id, tb.client_id, tb.process_id, 
				        CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id, dfr.location, dfr.job_title, dfr.requisition_id, tb.trn_start_date, total_trainees, avg_rating 
				        from training_batch tb 
						LEFT JOIN signin as s ON s.id=tb.trainer_id
						LEFT JOIN dfr_requisition dfr ON dfr.id=tb.ref_id
						LEFT JOIN (SELECT count(*) as total_trainees, trn_batch_id from training_details GROUP BY trn_batch_id) as d ON d.trn_batch_id = tb.id
						LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, training_batch from training_post_classroom_survey GROUP BY training_batch) as sv ON sv.training_batch = tb.id
						WHERE trn_type=2 $filterCond4
						AND (location='$location' OR batch_office_id = '$location') AND tb.client_id = '$client_id' AND tb.process_id = '$process_id'";
				*/		
						
				$qSql = "SELECT tb.id, tb.trn_batch_status, tb.trainer_id, tb.client_id, tb.process_id, tb.batch_name,
				        CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id, dfr.location, dfr.job_title, dfr.requisition_id, tb.trn_start_date, d.total_trainees, sv.avg_rating, w.w_batch_id, w.w_user_id, w.w_weightage, d.trn_attritions, d.attrition_types, d.recertifys, d.certifys, nw.nw_batch_id, nw.nw_user_id, nw.nw_weightage, n_trn_ref_id, n_trn_ref_type, cb.passing_percentile					
				        from training_batch tb 
						LEFT JOIN signin as s ON s.id=tb.trainer_id
						LEFT JOIN dfr_requisition dfr ON dfr.id=tb.ref_id
						LEFT JOIN (SELECT count(id) as total_trainees, GROUP_CONCAT(trn_attrition) as trn_attritions, GROUP_CONCAT(attrition_type) as attrition_types, GROUP_CONCAT(is_recertify) as recertifys, GROUP_CONCAT(is_certify) as certifys, trn_batch_id from training_details GROUP BY trn_batch_id) as d ON d.trn_batch_id = tb.id
						LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, training_batch from training_post_classroom_survey GROUP BY training_batch) as sv ON sv.training_batch = tb.id
						LEFT JOIN (SELECT tc.passing_percentile, MAX(tc.id) as cert_id, tc.trn_batch_id as cert_batch_id from training_cert_design as tc GROUP BY tc.trn_batch_id) as cb ON cb.cert_batch_id = tb.id
						LEFT JOIN (SELECT t.trn_batch_id as w_batch_id, GROUP_CONCAT(t.user_id) as w_user_id, GROUP_CONCAT(t.weightage) as w_weightage from 
						(SELECT c.trn_batch_id, c.user_id, CASE WHEN c.kpi_value <= 1 THEN SUM((c.kpi_value * (k.kpi_weightage/100)) * 100) ELSE SUM((c.kpi_value * (k.kpi_weightage/100))) END as weightage
						FROM training_cert_data as c
						LEFT JOIN training_cert_kpi as k ON k.id = c.kpi_id
						WHERE k.kpi_name != 'status' GROUP BY c.user_id, c.trn_batch_id) 
						as t GROUP BY t.trn_batch_id) as w ON w.w_batch_id = tb.id
						
						LEFT JOIN (SELECT nt.n_trn_batch_id as nw_batch_id, GROUP_CONCAT(nt.n_user_id) as nw_user_id, n_trn_ref_id, n_trn_ref_type, GROUP_CONCAT(nt.n_weightage) as nw_weightage from 
						(SELECT nc.trn_batch_id as n_trn_batch_id, nb.ref_id as n_trn_ref_id, nb.ref_type as n_trn_ref_type, nc.user_id as n_user_id, SUM((nc.kpi_value * (nk.kpi_weightage/100)) * 100) as n_weightage
						FROM training_nesting_data as nc
						LEFT JOIN training_nesting_kpi as nk ON nk.id = nc.kpi_id
						LEFT JOIN training_batch as nb ON nb.id = nc.trn_batch_id
						WHERE nk.kpi_name != 'status' GROUP BY nc.user_id, nc.trn_batch_id) 
						as nt GROUP BY nt.n_trn_batch_id) as nw ON nw.n_trn_ref_id = tb.id AND nw.n_trn_ref_type = 'T'
						
						LEFT JOIN training_batch nest ON nest.ref_id=tb.id
						
						WHERE tb.trn_type=2 $filterCond5
						AND (location='$location' OR tb.batch_office_id = '$location') AND tb.client_id = '$client_id' AND tb.process_id = '$process_id'";		
				
				$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
				//echo $qSql  ."<br/>----<br/>";	
			}
			
			$data['allBatchArray'] = $AllBatchArray;		
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training_analytics/training_analytics.php";
			$data["content_js"] = "training_analytics/training_analytics_js.php";
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	
	public function recursive()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$batch="";
			$cond="";
			$filterCond="";
			$filterCond2="";
			$filterCond3 = "";
			$filterCond4 = " and trn_batch_status = '1' ";
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="" ) $oValue=$user_office_id;
			$data['oValue']=$oValue;
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				if($this->check_all_training_access())
				{
					$access_office_ids = $this->check_all_training_access('office');
					$extra_access_office = implode("','", $access_office_ids);
					$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
					$query = $this->db->query($sql_office);
					$data['location_list'] = $query->result_array();
				}
			}
			
			
			if($oValue!="ALL" ){
					$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue') ";
					$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue') ";
			}
			
			
			
			if($this->input->get('searchtraining'))
			{
				$daterange_full = $this->input->get('daterange');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
				$filterCond4 = "";
				
			}	
			
			if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
				
				$qSql = "Select tb.id, trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, batch_office_id, batch_name, location, trn_start_date, trn_batch_status from training_batch tb 
				left join process p on p.id= tb.process_id
				left join client c on c.id= tb.client_id
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
				where trn_type=4 $filterCond4 $filterCond $filterCond3			
				group by location, client_id, tb.process_id";				
				$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
				
			}else{
				
				$qSql = "Select tb.id, trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, batch_office_id, batch_name, location, job_title, trn_start_date, trn_batch_status from training_batch tb
				left join process p on p.id= tb.process_id
				left join client c on c.id= tb.client_id
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
				where trainer_id='$current_user' and trn_type=4 $filterCond4 $filterCond3
				group by location, client_id, tb.process_id";				
				$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
				
			}
			
			foreach($process_batch as $token)
			{
				//echo "<pre>" .print_r($token) ."</pre>";
				$trainer_id= $token['trainer_id'];
				$batch_id= $token['id'];
				$client_id= $token['client_id'];
				$process_id= $token['process_id'];
				$location= $token['location'];
		
				if(!empty($token['batch_office_id'])){ $location = $token['batch_office_id']; }
				if(!empty($token['batch_name'])){ $batch_name = $token['batch_name']; }				
				$key = $location."-".$client_id."-".$process_id;
				
				/*$qSql = "Select tb.id, tb.trn_batch_status, tb.trainer_id, tb.client_id, tb.process_id, 
				        CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id, dfr.location, dfr.job_title, dfr.requisition_id, tb.trn_start_date, total_trainees, avg_rating 
				        from training_batch tb 
						LEFT JOIN signin as s ON s.id=tb.trainer_id
						LEFT JOIN dfr_requisition dfr ON dfr.id=tb.ref_id
						LEFT JOIN (SELECT count(*) as total_trainees, trn_batch_id from training_details GROUP BY trn_batch_id) as d ON d.trn_batch_id = tb.id
						LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, training_batch from training_post_classroom_survey GROUP BY training_batch) as sv ON sv.training_batch = tb.id
						WHERE trn_type=2 $filterCond4
						AND (location='$location' OR batch_office_id = '$location') AND tb.client_id = '$client_id' AND tb.process_id = '$process_id'";
				*/		
						
				$qSql = "SELECT tb.id, tb.trn_batch_status, tb.trainer_id, tb.client_id, tb.process_id, tb.batch_name,
				        CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id, tb.trn_start_date, d.total_trainees, sv.avg_rating, w.w_batch_id, w.w_user_id, w.w_weightage, iw.w_batch_id as iw_batch_id, iw.w_user_id as iw_user_id, iw.w_weightage as iw_weightage, icb.passing_percentile  as i_passing_percentile					
				        from training_batch tb 
						LEFT JOIN signin as s ON s.id=tb.trainer_id
						
						LEFT JOIN (SELECT count(id) as total_trainees, GROUP_CONCAT(trn_attrition) as trn_attritions, trn_batch_id from training_details GROUP BY trn_batch_id) as d ON d.trn_batch_id = tb.id
						
						LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, training_batch from training_post_classroom_survey GROUP BY training_batch) as sv ON sv.training_batch = tb.id
						
						LEFT JOIN (SELECT t.trn_batch_id as w_batch_id, GROUP_CONCAT(t.user_id) as w_user_id, GROUP_CONCAT(t.weightage) as w_weightage from 
						(SELECT c.trn_batch_id, c.user_id, SUM((c.kpi_value * (k.kpi_weightage/100)) * 100) as weightage
						FROM training_recursive_data as c
						LEFT JOIN training_recursive_kpi as k ON k.id = c.kpi_id
						WHERE k.kpi_name != 'status' GROUP BY c.user_id, c.trn_batch_id) 
						as t GROUP BY t.trn_batch_id) as w ON w.w_batch_id = tb.id
						
						LEFT JOIN (SELECT itc.passing_percentile, MAX(itc.id) as cert_id, itc.trn_batch_id as cert_batch_id from training_recursive_incub_design as itc GROUP BY itc.trn_batch_id) as icb ON icb.cert_batch_id = tb.id
						LEFT JOIN (SELECT it.trn_batch_id as w_batch_id, GROUP_CONCAT(it.user_id) as w_user_id, GROUP_CONCAT(it.weightage) as w_weightage from 
						(SELECT ic.trn_batch_id, ic.user_id, SUM((ic.kpi_value * (ik.kpi_weightage/100)) * 100) as weightage
						FROM training_recursive_incub_data as ic
						LEFT JOIN training_recursive_incub_kpi as ik ON ik.id = ic.kpi_id
						WHERE ik.kpi_name != 'status' GROUP BY ic.user_id, ic.trn_batch_id) 
						as it GROUP BY it.trn_batch_id) as iw ON iw.w_batch_id = tb.id
						
						WHERE trn_type=4 $filterCond4
						AND batch_office_id = '$location' AND tb.client_id = '$client_id' AND tb.process_id = '$process_id'";		
				
				$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
				//echo $qSql  ."<br/>----<br/>";	
			}
			
			$data['allBatchArray'] = $AllBatchArray;		
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training_analytics/recursive_analytics.php";
			$data["content_js"] = "training_analytics/training_analytics_js.php";
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	public function upskill()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$batch="";
			$cond="";
			$filterCond="";
			$filterCond2="";
			$filterCond3 = "";
			$filterCond4 = " and trn_batch_status = '1' ";
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="" ) $oValue=$user_office_id;
			$data['oValue']=$oValue;
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				if($this->check_all_training_access())
				{
					$access_office_ids = $this->check_all_training_access('office');
					$extra_access_office = implode("','", $access_office_ids);
					$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
					$query = $this->db->query($sql_office);
					$data['location_list'] = $query->result_array();
				}
			}
			
			
			if($oValue!="ALL" ){
					$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue') ";
					$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue') ";
			}
			
			
			
			if($this->input->get('searchtraining'))
			{
				$daterange_full = $this->input->get('daterange');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
				$filterCond4 = "";
				
			}	
			
			if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
				
				$qSql = "Select tb.id, trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, batch_office_id, batch_name, location, trn_start_date, trn_batch_status from training_batch tb 
				left join process p on p.id= tb.process_id
				left join client c on c.id= tb.client_id
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
				where trn_type=5 $filterCond4 $filterCond $filterCond3			
				group by location, client_id, tb.process_id";				
				$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
				
			}else{
				
				$qSql = "Select tb.id, trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, batch_office_id, batch_name, location, job_title, trn_start_date, trn_batch_status from training_batch tb
				left join process p on p.id= tb.process_id
				left join client c on c.id= tb.client_id
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
				where trainer_id='$current_user' and trn_type=5 $filterCond4 $filterCond3
				group by location, client_id, tb.process_id";				
				$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
				
			}
			
			foreach($process_batch as $token)
			{
				//echo "<pre>" .print_r($token) ."</pre>";
				$trainer_id= $token['trainer_id'];
				$batch_id= $token['id'];
				$client_id= $token['client_id'];
				$process_id= $token['process_id'];
				$location= $token['location'];
		
				if(!empty($token['batch_office_id'])){ $location = $token['batch_office_id']; }
				if(!empty($token['batch_name'])){ $batch_name = $token['batch_name']; }				
				$key = $location."-".$client_id."-".$process_id;
				
				/*$qSql = "Select tb.id, tb.trn_batch_status, tb.trainer_id, tb.client_id, tb.process_id, 
				        CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id, dfr.location, dfr.job_title, dfr.requisition_id, tb.trn_start_date, total_trainees, avg_rating 
				        from training_batch tb 
						LEFT JOIN signin as s ON s.id=tb.trainer_id
						LEFT JOIN dfr_requisition dfr ON dfr.id=tb.ref_id
						LEFT JOIN (SELECT count(*) as total_trainees, trn_batch_id from training_details GROUP BY trn_batch_id) as d ON d.trn_batch_id = tb.id
						LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, training_batch from training_post_classroom_survey GROUP BY training_batch) as sv ON sv.training_batch = tb.id
						WHERE trn_type=2 $filterCond4
						AND (location='$location' OR batch_office_id = '$location') AND tb.client_id = '$client_id' AND tb.process_id = '$process_id'";
				*/		
						
				$qSql = "SELECT tb.id, tb.trn_batch_status, tb.trainer_id, tb.client_id, tb.process_id, tb.batch_name,
				        CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id, tb.trn_start_date, d.total_trainees, sv.avg_rating, w.w_batch_id, w.w_user_id, w.w_weightage, iw.w_batch_id as iw_batch_id, iw.w_user_id as iw_user_id, iw.w_weightage as iw_weightage, icb.passing_percentile as i_passing_percentile					
				        from training_batch tb 
						LEFT JOIN signin as s ON s.id=tb.trainer_id
						
						LEFT JOIN (SELECT count(id) as total_trainees, GROUP_CONCAT(trn_attrition) as trn_attritions, trn_batch_id from training_details GROUP BY trn_batch_id) as d ON d.trn_batch_id = tb.id
						
						LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, training_batch from training_post_classroom_survey GROUP BY training_batch) as sv ON sv.training_batch = tb.id
						
						LEFT JOIN (SELECT t.trn_batch_id as w_batch_id, GROUP_CONCAT(t.user_id) as w_user_id, GROUP_CONCAT(t.weightage) as w_weightage from 
						(SELECT c.trn_batch_id, c.user_id, SUM((c.kpi_value * (k.kpi_weightage/100)) * 100) as weightage
						FROM training_upskill_data as c
						LEFT JOIN training_upskill_kpi as k ON k.id = c.kpi_id
						WHERE k.kpi_name != 'status' GROUP BY c.user_id, c.trn_batch_id) 
						as t GROUP BY t.trn_batch_id) as w ON w.w_batch_id = tb.id
						
						LEFT JOIN (SELECT itc.passing_percentile, MAX(itc.id) as cert_id, itc.trn_batch_id as cert_batch_id from training_upskill_incub_design as itc GROUP BY itc.trn_batch_id) as icb ON icb.cert_batch_id = tb.id
						LEFT JOIN (SELECT it.trn_batch_id as w_batch_id, GROUP_CONCAT(it.user_id) as w_user_id, GROUP_CONCAT(it.weightage) as w_weightage from 
						(SELECT ic.trn_batch_id, ic.user_id, SUM((ic.kpi_value * (ik.kpi_weightage/100)) * 100) as weightage
						FROM training_upskill_incub_data as ic
						LEFT JOIN training_upskill_incub_kpi as ik ON ik.id = ic.kpi_id
						WHERE ik.kpi_name != 'status' GROUP BY ic.user_id, ic.trn_batch_id) 
						as it GROUP BY it.trn_batch_id) as iw ON iw.w_batch_id = tb.id
						
						WHERE trn_type=5 $filterCond4
						AND batch_office_id = '$location' AND tb.client_id = '$client_id' AND tb.process_id = '$process_id'";		
				
				$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
				//echo $qSql  ."<br/>----<br/>";	
			}
			
			$data['allBatchArray'] = $AllBatchArray;		
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training_analytics/upskill_analytics.php";
			$data["content_js"] = "training_analytics/training_analytics_js.php";
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	
	//===================== BATCH DETAILS ========================================//
	public function training_batch_details()
	{
		$todayDate = CurrDate();
		$batch_id = $data['batch_id'] = $this->input->get('batchid');
		$batchDetails = "SELECT td.*, s.*, yy.*, d.*, trm.*, ts.avg_rating_score, ts.trainee_id as survey_id, b.trn_type as trn_batch_type, 
		                 (Select name from event_master e where e.id=s.disposition_id) as disp_name from training_details td 
						 LEFT JOIN training_batch b on td.trn_batch_id = b.id
						 LEFT JOIN signin s on td.user_id = s.id
						 LEFT JOIN training_post_classroom_survey ts on ts.trainee_id = td.user_id AND ts.training_batch = td.trn_batch_id
						 LEFT JOIN 
						(select user_id as luid, sum(TIME_TO_SEC(timediff(logout_time,login_time))) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."' group by user_id) yy on (td.user_id=yy.luid)
						LEFT JOIN 
						(select start_date,end_date,user_id as duid from event_disposition where start_date <= '".$todayDate."' and end_date >= '".$todayDate."' group by duid ) d on (td.user_id=d.duid)
						Left Join (select user_id as tuid, is_term_complete, max(terms_date) as terms_date from terminate_users where is_term_complete='Y' group by user_id ) trm ON (td.user_id=trm.tuid) 
						WHERE td.trn_batch_id = '$batch_id' order by fname ";
		$candidatedata = $this->Common_model->get_query_result_array($batchDetails);
		$data['candidate_details'][$batch_id] = $candidatedata;
		
		$scoreType = 2;
		foreach($candidatedata as $crow)
		{
			$user_id = $crow['user_id'];
			$scoreType = $crow['trn_batch_type'];
			
			// GET CERTIFICATION SCORE
			$sqlcertification = "SELECT t.is_certify as value FROM training_details as t WHERE t.trn_batch_id = '$batch_id' AND t.user_id = '$user_id'";
			$querycertification = $this->Common_model->get_single_value($sqlcertification);
			
			// GET CERTIFICATION SCORE
			$sqlcertification = "SELECT t.is_certify, t.is_recertify FROM training_details as t WHERE t.trn_batch_id = '$batch_id' AND t.user_id = '$user_id'";
			$querycertification = $this->Common_model->get_query_row_array($sqlcertification);
			$is_certify = 0; $is_recertify = 0;
			if(!empty($querycertification['is_certify'])){ $is_certify = $querycertification['is_certify']; }
			if(!empty($querycertification['is_recertify'])){ $is_recertify = $querycertification['is_recertify']; }
			
			$scoreTable = "training_rag_data";
			if($scoreType == 2){ $scoreTable = "training_rag_data"; }
			if($scoreType == 4){ $scoreTable = "training_recursive_rag_data"; }
			if($scoreType == 5){ $scoreTable = "training_upskill_rag_data"; }
			
			// GET RAG SCORE
			$sqlrag = "SELECT kpi_value as value FROM $scoreTable 
			           WHERE trn_batch_id = '$batch_id' AND user_id = '$user_id'order by id DESC LIMIT 1";
			$queryrag = $this->Common_model->get_single_value($sqlrag);
			
			$data['candidate_result'][$batch_id]['certification'][$user_id] = $is_certify;
			$data['candidate_result'][$batch_id]['recertification'][$user_id] = $is_recertify;
			$data['candidate_result'][$batch_id]['rag'][$user_id] = $queryrag;

		}
		
		// RAG CHECK
		$scoreDesign = "training_rag_design";
		if($scoreType == 2){ $scoreTable = "training_rag_data"; $scoreDesign = "training_rag_design"; }
		if($scoreType == 4){ $scoreTable = "training_recursive_rag_data"; $scoreDesign = "training_recursive_rag_design"; }
		if($scoreType == 5){ $scoreTable = "training_upskill_rag_data"; $scoreDesign = "training_upskill_rag_design"; }
		$sqlDesign = "SELECT id as value FROM $scoreDesign WHERE trn_batch_id = '$batch_id' order by id DESC LIMIT 1";
		$data['ragDesign'] = $this->Common_model->get_single_value($sqlDesign);
		
		// CERTIFICATE CHECK
		$scoreDesign = "training_cert_design";
		if($scoreType == 2){ $scoreTable = "training_cert_data"; $scoreDesign = "training_cert_design"; }
		if($scoreType == 4){ $scoreTable = "training_recursive_data"; $scoreDesign = "training_recursive_design"; }
		if($scoreType == 5){ $scoreTable = "training_upskill_data"; $scoreDesign = "training_upskill_design"; }
		$sqlDesign = "SELECT id as value FROM $scoreDesign WHERE trn_batch_id = '$batch_id' order by id DESC LIMIT 1";
		$data['certDesign'] = $this->Common_model->get_single_value($sqlDesign);
		
		$this->load->view('training_analytics/ta_batch_details',$data);
		
	}
	
	
	public function training_certificate_details()
	{
		$batch_id = $data['batch_id'] = $this->input->get('batchid');
		$user_id = $data['user_id'] = $this->input->get('userid');
		$scoreType = $data['score_type'] = $this->input->get('scoretype');
		
		$kpiTable = "training_cert_kpi";
		$scoreTable = "training_cert_data";
		$designTable = "training_cert_design";
		$designID = "crtdid";
		if($scoreType == 2)
		{
			$kpiTable = "training_cert_kpi";
			$scoreTable = "training_cert_data";
			$designTable = "training_cert_design";
			$designID = "crtdid";
		}
		if($scoreType == 4)
		{
			$kpiTable = "training_recursive_kpi";
			$scoreTable = "training_recursive_data";
			$designTable = "training_recursive_design";
			$designID = "ntdid";
		}
		if($scoreType == 5)
		{
			$kpiTable = "training_upskill_kpi";
			$scoreTable = "training_upskill_data";
			$designTable = "training_upskill_design";
			$designID = "ntdid";
		}
		
		$maxNumber = 0;
		$batchDetails = "SELECT d.*, s.fusion_id, CONCAt(s.fname, ' ', s.lname) as fullname from training_details as d
						INNER JOIN signin as s ON s.id = d.user_id
		                WHERE trn_batch_id = '$batch_id'";
		$data['candidate_details'][$batch_id]['users'] = $queryBatchDetails = $this->Common_model->get_query_result_array($batchDetails);
		foreach($queryBatchDetails as $token)
		{
			$batchDetails = "SELECT c.*, k.kpi_name, k.kpi_weightage FROM $scoreTable as c
						 INNER JOIN $designTable as d ON c.$designID = d.id
						 INNER JOIN $kpiTable as k ON k.id = c.kpi_id AND k.did = d.id
						 WHERE d.trn_batch_id = '$batch_id'";
			$candidatedata = $this->Common_model->get_query_result_array($batchDetails);
			foreach($candidatedata as $token)
			{
				$kpiID = $token['kpi_id'];
				$kpiValue = $token['kpi_value'];
				$kpi_userid = $token['user_id'];
				$data['candidate_details'][$batch_id]['certificate']['data'][$kpi_userid][$kpiID] = $kpiValue;
				
				if($kpiValue > $maxNumber && !ctype_alpha($kpiValue) && $kpiValue!="")
				{ 
					$maxNumber = $kpiValue; 
				}
			}
			
		}
		
		$uptoRag = 1;
		if($maxNumber <= 10){ $uptoRag = 10; }		
		if($maxNumber <= 1){ $uptoRag = 100; }
		$data['maxRag'] = $maxNumber;
		$data['uptoRag'] = $uptoRag;
		
		$kpiDetails = "SELECT k.* from $kpiTable as k
		               INNER JOIN $designTable as d ON d.id = k.did
					   WHERE d.trn_batch_id = '$batch_id'";
		$data['candidate_details'][$batch_id]['certificate']['kpi'] = $this->Common_model->get_query_result_array($kpiDetails);
		
	    //echo "<pre>".print_r($data['candidate_details'], 1)."</pre>";	
		$this->load->view('training_analytics/ta_batch_certification',$data);
		
	}
	
	
	public function training_rag_details()
	{
		$batch_id = $data['batch_id'] = $this->input->get('batchid');
		$user_id = $data['user_id'] = $this->input->get('userid');
		$scoreType = $data['score_type'] = $this->input->get('scoretype');
		
		$kpiTable = "training_rag_kpi";
		$scoreTable = "training_rag_data";
		$designTable = "training_rag_design";
		$designID = "ragdid";
		if($scoreType == 2)
		{
			$kpiTable = "training_rag_kpi";
			$scoreTable = "training_rag_data";
			$designTable = "training_rag_design";
			$designID = "ragdid";
		}
		if($scoreType == 4)
		{
			$kpiTable = "training_recursive_rag_kpi";
			$scoreTable = "training_recursive_rag_data";
			$designTable = "training_recursive_rag_design";
			$designID = "ntdid";
		}
		if($scoreType == 5)
		{
			$kpiTable = "training_upskill_rag_kpi";
			$scoreTable = "training_upskill_rag_data";
			$designTable = "training_upskill_rag_design";
			$designID = "ntdid";
		}
		
		$maxNumber = 0;
		$batchDetails = "SELECT d.*, s.fusion_id, CONCAt(s.fname, ' ', s.lname) as fullname from training_details as d
						INNER JOIN signin as s ON s.id = d.user_id
		                WHERE trn_batch_id = '$batch_id'";
		$data['candidate_details'][$batch_id]['users'] = $queryBatchDetails = $this->Common_model->get_query_result_array($batchDetails);
		foreach($queryBatchDetails as $token)
		{
			$batchDetails = "SELECT r.*, k.kpi_name FROM $scoreTable as r
						 INNER JOIN $designTable as d ON r.$designID = d.id
						 INNER JOIN $kpiTable as k ON k.id = r.kpi_id AND k.did = d.id
						 WHERE d.trn_batch_id = '$batch_id'";
			$candidatedata = $this->Common_model->get_query_result_array($batchDetails);
			foreach($candidatedata as $token)
			{
				$kpiID = $token['kpi_id'];
				$kpiValue = $token['kpi_value'];
				$kpi_userid = $token['user_id'];
				$data['candidate_details'][$batch_id]['certificate']['data'][$kpi_userid][$kpiID] = $kpiValue;
				if($kpiValue > $maxNumber && !ctype_alpha($kpiValue) && $kpiValue!="")
				{ 
					$maxNumber = $kpiValue; 
				}
			}
			
		}
		
		$uptoRag = 1;
		if($maxNumber <= 10){ $uptoRag = 10; }		
		if($maxNumber <= 1){ $uptoRag = 100; }
		$data['maxRag'] = $maxNumber;
		$data['uptoRag'] = $uptoRag;
		
		
		$kpiDetails = "SELECT k.* from $kpiTable as k
		               INNER JOIN $designTable as d ON d.id = k.did
					   WHERE d.trn_batch_id = '$batch_id'";
		$data['candidate_details'][$batch_id]['certificate']['kpi'] = $this->Common_model->get_query_result_array($kpiDetails);
		
	    //echo "<pre>".print_r($data['candidate_details'], 1)."</pre>";	
		$this->load->view('training_analytics/ta_batch_rag',$data);
		
	}
	
	
	
	//===================== BATCH DETAILS ========================================//
	public function	ta_updateBatchDetails()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('batch_id');
		$batch_name = $this->input->post('batch_name');
		
		if($batch_id != "" && $batch_name != "")
		{
			$data = [ 'batch_name' => $batch_name ];
			$this->db->where('id', $batch_id);
			$this->db->update('training_batch', $data);
		}		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	
	
	//===============================================================================
	//  NESTING RAG PERFORMANCE
	//===============================================================================
	
	public function nesting_rag_performance()
	{
		$current_user = get_user_id();
		$ses_fusion_id = get_user_fusion_id();
		$user_office_id= get_user_office_id();
		$filterCond = "";
		$filterCond3 = "";
		$filterCond4 = " and tb.trn_batch_status = '1'";
		
		// FILTER CHECK
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue = trim($this->input->get('office_id'));
		if($oValue=="" ) $oValue=$user_office_id;
		$data['oValue']=$oValue;		
		if($oValue!="ALL" ){
			$filterCond = " and tb.batch_office_id = '$oValue' ";
		}		
		if($this->input->get('searchtraining'))
		{
			$daterange_full = $this->input->get('daterange');
			$daterange_explode = explode('-',$daterange_full);
			$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
			$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
			$filterCond3 = " AND tb.trn_start_date >= '$startdate_range' AND tb.trn_start_date <= '$enddate_range'";
			$filterCond4 = ""; $filterCond5 = "";
			
		}
		
		// LOCATION DROPDOWN		
		if(get_global_access()=="1"){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			if($this->check_all_training_access())
			{
				$access_office_ids = $this->check_all_training_access('office');
				$extra_access_office = implode("','", $access_office_ids);
				$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
				$query = $this->db->query($sql_office);
				$data['location_list'] = $query->result_array();
			}
		}
					
		// BATCH LIST
		if(get_global_access()=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access())
		{
									
			$qSql="Select tb.*, GROUP_CONCAT(d.user_id) as user_ids, c.shname as client_name, p.name as process_name, CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin s ON  s.id=tb.trainer_id
					LEFT JOIN training_details d ON  d.trn_batch_id=tb.id					
					WHERE tb.trn_type=3 $filterCond4 $filterCond $filterCond3  group by tb.id order by tb.id desc";
			$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
			
		} else {
			
			$qSql="Select tb.*, GROUP_CONCAT(d.user_id) as user_ids, c.shname as client_name, p.name as process_name, CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id from training_batch tb 
				   LEFT JOIN client c ON  c.id=tb.client_id 
				   LEFT JOIN process p ON  p.id=tb.process_id 
				   LEFT JOIN signin s ON  s.id=tb.trainer_id 
				   LEFT JOIN training_details d ON  d.trn_batch_id=tb.id 
				   WHERE trainer_id='$current_user' and trn_type=3 $filterCond4 $filterCond3 group by tb.id order by tb.id desc";					
			$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
		}
		
		$data['nestingBatchList'] = $get_assigned_batch;		
		$data["aside_template"] = "training/aside.php";
		$data["content_template"] = "training_analytics/nesting/nesting_performance.php";
		$data["content_js"] = "training_analytics/nesting_analytics_js.php";
		
		$this->load->view('dashboard',$data);
		
	}
	
	public function nesting_batch_details()
	{
		$todayDate = CurrDate();
		$batch_id = $data['batch_id'] = $this->input->get('batchid');
		$batchDetails = "SELECT * from training_batch WHERE id = '$batch_id'";
		$queryDetails = $this->Common_model->get_query_row_array($batchDetails);
		$batchStartDate = $queryDetails['trn_start_date'];
		
		$t_client = $queryDetails['client_id'];
		$t_process = $queryDetails['process_id'];

		
		// GET DATES
		$weeks = array();
		$dateStartChecker = $batchStartDate;
		$weeks[1]['start'] = $dateStartChecker;
		$weeks[1]['end'] = $dateStartChecker = date('Y-m-d', strtotime("+6 day", strtotime($dateStartChecker)));
		$weeks[2]['start'] = $dateStartChecker = date('Y-m-d', strtotime("+1 day", strtotime($dateStartChecker)));
		$weeks[2]['end'] = $dateStartChecker = date('Y-m-d', strtotime("+6 day", strtotime($dateStartChecker)));
		$weeks[3]['start'] = $dateStartChecker = date('Y-m-d', strtotime("+1 day", strtotime($dateStartChecker)));
		$weeks[3]['end'] = $dateStartChecker = date('Y-m-d', strtotime("+6 day", strtotime($dateStartChecker)));
		$weeks[4]['start'] = $dateStartChecker = date('Y-m-d', strtotime("+1 day", strtotime($dateStartChecker)));
		$weeks[4]['end'] = $dateStartChecker = date('Y-m-d', strtotime("+6 day", strtotime($dateStartChecker)));
		
		// GET MONTHS
		$month = array();
		$month[0] = $batchStartDate;
		$month[30] = $complete30 = date('Y-m-d', strtotime("+30 days", strtotime($batchStartDate)));
		$month[31] = $complete31 = date('Y-m-d', strtotime("+31 days", strtotime($batchStartDate)));
		$month[60] = $complete60 = date('Y-m-d', strtotime("+60 days", strtotime($batchStartDate)));
		$month[61] = $complete61 = date('Y-m-d', strtotime("+61 days", strtotime($batchStartDate)));
		$month[90] = $complete90 = date('Y-m-d', strtotime("+90 days", strtotime($batchStartDate)));
		
		
		$userIDs_sql = "SELECT d.*, CONCAT(s.fname, ' ', s.lname) as agent_name, s.office_id, s.fusion_id from training_details as d LEFT JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batch_id'";
		$userIDs_query = $this->Common_model->get_query_result_array($userIDs_sql);
		$userID_col = array_column($userIDs_query, 'user_id');
		$userIDs = implode(',', $userID_col);
		if(empty($userIDs)){ $userIDs = 0; }
		
		$_sql = "SELECT DISTINCT(i.process_id), p.name as process_name from info_assign_process as i LEFT JOIN process as p ON p.id = i.process_id WHERE i.user_id IN ($userIDs)";
		$_query = $this->Common_model->get_query_result_array($_sql);
		$processsID_col = array_column($_query, 'process_id');
		$processsIDs = implode(',', $processsID_col);
		
		//echo "UserIds : " .$userIDs ."<br/> Process ID : " .$processsIDs ."<br/><br/>";
		
		$dbName = $this->db->database;
		
		$processArray = $_query;
		$processDefectArray = array();
		$finalWeekArray = array();
		$finalWeekOverallArray = array();
		$mtdArray = array();
		$TargetArray = array();
		$overAllArray = array();
		foreach($processsID_col as $tokenCol)
		{
			$currentProcessID = $tokenCol;
			
			// QA DEFECT PROCESS Selection
			$sqlQAProcess = "SELECT q.process_id, q.client_id, q.table_name, p.name as process_name, p.id as d_process_id, c.shname as client_name 
						     FROM qa_defect as q
						     LEFT JOIN process as p ON p.id = FLOOR(q.process_id)
						     LEFT JOIN client as c ON c.id = q.client_id 
						     WHERE FLOOR(process_id) = '$tokenCol'
						     ORDER by q.table_name";
			$data['qaDefectList'] = $qaDefectList = $this->Common_model->get_query_result_array($sqlQAProcess);
			
			foreach($qaDefectList as $token)
			{
				$currentDefectProcessID = $token['process_id'];
				$processDefectArray[] = $token;
				
				$def_client = $token['client_id'];
				$def_process = $currentProcessID;
				$def_campaign = $token['process_id'];
				
				// FIND TABLE
				$tableFound = false;
				$currentTable = trim($token['table_name']);
									
				$sqlCheck = "SELECT count(*) as value FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$currentTable'";
				$countCheck = $this->Common_model->get_single_value($sqlCheck);
				if($countCheck > 0){ $tableFound = true; }
				if($tableFound){
					
				$sqlTargets = "SELECT * from training_batch_qa_target WHERE batch_id = '$batch_id' AND client_id = '$def_client' AND process_id = '$def_process' AND campaign_id = '$def_campaign'";
				$queryTargets = $this->Common_model->get_query_row_array($sqlTargets);
				$TargetArray[$batch_id][$def_client][$def_process][$def_campaign] = $queryTargets;
				
				
				// MTD 30 TARGET
				$data['mtd'][30]['start'] = $startDate = $batchStartDate;
				$data['mtd'][30]['end'] = $endDate = $complete30;				
				$getScores = "SELECT qa.agent_id, count(*) as auditCount, avg(qa.overall_score) as score, 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
				$scoresArray = $this->Common_model->get_query_result_array($getScores);
				$mtdArray[$batch_id][$def_client][$def_process][$def_campaign]['score'][30] = $this->d_array_indexed($scoresArray, 'agent_id');
							
				$getFatalScores = "SELECT qa.agent_id, count(*) as auditCount 
						  from $currentTable as qa 
						  LEFT JOIN signin as s ON s.id = qa.agent_id
						  LEFT JOIN signin as l ON l.id = s.assigned_to
						  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
						  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
				$scoresFatalArray = $this->Common_model->get_query_result_array($getScores);
				$mtdArray[$batch_id][$def_client][$def_process][$def_campaign]['fatal'][30] = $this->d_array_indexed($scoresFatalArray, 'agent_id');
				
				
				$getScores = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
				$scoresArray = $this->Common_model->get_query_row_array($getScores);
				$overAllArray[$batch_id][$def_client][$def_process][$def_campaign]['score'][30] = $scoresArray;
				
				$getFatalScores = "SELECT count(*) as auditCount 
						  from $currentTable as qa 
						  LEFT JOIN signin as s ON s.id = qa.agent_id
						  LEFT JOIN signin as l ON l.id = s.assigned_to
						  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
						  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
				$scoresFatalArray = $this->Common_model->get_query_row_array($getScores);
				$overAllArray[$batch_id][$def_client][$def_process][$def_campaign]['fatal'][30] = $scoresArray;
				
				// MTD 60 TARGET
				$data['mtd'][60]['start'] = $startDate = date('Y-m-d', strtotime('+1 day', strtotime($complete30)));
				$data['mtd'][60]['end'] = $endDate = $complete60;				
				$getScores = "SELECT qa.agent_id, count(*) as auditCount, avg(qa.overall_score) as score, 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
				$scoresArray = $this->Common_model->get_query_result_array($getScores);
				$mtdArray[$batch_id][$def_client][$def_process][$def_campaign]['score'][60] = $this->d_array_indexed($scoresArray, 'agent_id');
				
				$getFatalScores = "SELECT qa.agent_id, count(*) as auditCount 
						  CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
						  from $currentTable as qa 
						  LEFT JOIN signin as s ON s.id = qa.agent_id
						  LEFT JOIN signin as l ON l.id = s.assigned_to
						  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
						  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
				$scoresFatalArray = $this->Common_model->get_query_result_array($getScores);
				$mtdArray[$batch_id][$def_client][$def_process][$def_campaign]['fatal'][60] = $this->d_array_indexed($scoresFatalArray, 'agent_id');
				
				$getScores = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
				$scoresArray = $this->Common_model->get_query_row_array($getScores);
				$overAllArray[$batch_id][$def_client][$def_process][$def_campaign]['score'][60] = $scoresArray;
				
				$getFatalScores = "SELECT count(*) as auditCount 
						  from $currentTable as qa 
						  LEFT JOIN signin as s ON s.id = qa.agent_id
						  LEFT JOIN signin as l ON l.id = s.assigned_to
						  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
						  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
				$scoresFatalArray = $this->Common_model->get_query_row_array($getScores);
				$overAllArray[$batch_id][$def_client][$def_process][$def_campaign]['fatal'][60] = $scoresArray;
				
				// MTD 90 TARGET
				$data['mtd'][90]['start'] = $startDate = date('Y-m-d', strtotime('+1 day', strtotime($complete60)));
				$data['mtd'][90]['end'] = $endDate = $complete60;				
				$getScores = "SELECT qa.agent_id, count(*) as auditCount, avg(qa.overall_score) as score, 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
				$scoresArray = $this->Common_model->get_query_result_array($getScores);
				$mtdArray[$batch_id][$def_client][$def_process][$def_campaign]['score'][90] = $this->d_array_indexed($scoresArray, 'agent_id');
				
				$getFatalScores = "SELECT qa.agent_id, count(*) as auditCount 
						  CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
						  from $currentTable as qa 
						  LEFT JOIN signin as s ON s.id = qa.agent_id
						  LEFT JOIN signin as l ON l.id = s.assigned_to
						  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
						  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
				$scoresFatalArray = $this->Common_model->get_query_result_array($getScores);
				$mtdArray[$batch_id][$def_client][$def_process][$def_campaign]['fatal'][90] = $this->d_array_indexed($scoresFatalArray, 'agent_id');
				
				$getScores = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
				$scoresArray = $this->Common_model->get_query_row_array($getScores);
				$overAllArray[$batch_id][$def_client][$def_process][$def_campaign]['score'][90] = $scoresArray;
				
				$getFatalScores = "SELECT count(*) as auditCount 
						  from $currentTable as qa 
						  LEFT JOIN signin as s ON s.id = qa.agent_id
						  LEFT JOIN signin as l ON l.id = s.assigned_to
						  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
						  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
				$scoresFatalArray = $this->Common_model->get_query_row_array($getScores);
				$overAllArray[$batch_id][$def_client][$def_process][$def_campaign]['fatal'][90] = $scoresArray;
				
				for($i=1; $i<=4; $i++)
				{
					$startDate = $weeks[$i]['start'];
					$endDate = $weeks[$i]['end'];
					$getScores = "SELECT qa.agent_id, count(*) as auditCount, avg(qa.overall_score) as score, 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
					$scoresArray = $this->Common_model->get_query_result_array($getScores);
					$finalWeekArray[$currentDefectProcessID][$i]['score'] = $this->d_array_indexed($scoresArray, 'agent_id');
					
					$getFatalScores = "SELECT qa.agent_id, count(*) as auditCount 
				              CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
							  from $currentTable as qa 
				              LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs) GROUP BY qa.agent_id";
					$scoresFatalArray = $this->Common_model->get_query_result_array($getScores);
					$finalWeekArray[$currentDefectProcessID][$i]['fatal'] = $this->d_array_indexed($scoresFatalArray, 'agent_id');
					
					$getScores = "SELECT count(*) as auditCount, avg(qa.overall_score) as score, 
								  CONCAT(s.fname, ' ' ,s.lname) as agent_name, CONCAT(l.fname, ' ' ,l.lname) as l1_supervisor 
								  from $currentTable as qa 
								  LEFT JOIN signin as s ON s.id = qa.agent_id
								  LEFT JOIN signin as l ON l.id = s.assigned_to
								  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate'  
								  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
					$scoresArray = $this->Common_model->get_query_row_array($getScores);
					$finalWeekOverallArray[$currentDefectProcessID][$i]['score'] = $scoresArray;
					
					$getFatalScores = "SELECT count(*) as auditCount 
							  from $currentTable as qa 
							  LEFT JOIN signin as s ON s.id = qa.agent_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  WHERE DATE(qa.audit_date) >= '$startDate' AND DATE(qa.audit_date) <= '$endDate' AND  qa.overall_score = '0' 
							  AND qa.audit_type = 'CQ Audit' AND qa.agent_id IN ($userIDs)";
					$scoresFatalArray = $this->Common_model->get_query_row_array($getScores);
					$finalWeekOverallArray[$currentDefectProcessID][$i]['fatal'] = $scoresFatalArray;
				}
				
				}				
			}
		}
		
		$data['d_overallArray'] = $overAllArray;
		$data['d_mtdArray'] = $mtdArray;
		$data['d_targetArray'] = $TargetArray;
		$data['d_weekArray'] = $finalWeekArray;
		$data['d_weekOverallArray'] = $finalWeekOverallArray;
		$data['d_processArray'] = $processArray;
		$data['d_processDefectArray'] = $processDefectArray;
		$data['c_weeks'] = $weeks;
		$data['c_month'] = $month;
		$data['c_users'] = $userIDs_query;
		$data['c_batch'] = $queryDetails;
		
		$this->load->view('training_analytics/nesting/nesting_performance_ajax',$data);
		
		/*
		echo "<pre>" .print_r($weeks, true) ."</pre>";
		echo "<pre>" .print_r($userIDs_query, true) ."</pre>";
		echo "<pre>" .print_r($processArray, true) ."</pre>";
		echo "<pre>" .print_r($processDefectArray, true) ."</pre>";
		echo "<pre>" .print_r($finalWeekArray, true) ."</pre>";
		*/
	}
	
	
	public function nesting_batch_target_ajax()
	{
		$todayDate = CurrDate();
		$batch_id = $data['batch_id'] = $this->input->get('batchid');
		$batchDetails = "SELECT * from training_batch WHERE id = '$batch_id'";
		$queryDetails = $this->Common_model->get_query_row_array($batchDetails);
		$batchStartDate = $queryDetails['trn_start_date'];		
		
		$userIDs_sql = "SELECT d.*, CONCAT(s.fname, ' ', s.lname) as agent_name, s.office_id, s.fusion_id from training_details as d LEFT JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batch_id'";
		$userIDs_query = $this->Common_model->get_query_result_array($userIDs_sql);
		$userID_col = array_column($userIDs_query, 'user_id');
		$userIDs = implode(',', $userID_col);
		if(empty($userIDs)){ $userIDs = 0; }
		
		$_sql = "SELECT DISTINCT(i.process_id), p.name as process_name from info_assign_process as i LEFT JOIN process as p ON p.id = i.process_id WHERE i.user_id IN ($userIDs)";
		$_query = $this->Common_model->get_query_result_array($_sql);
		$processsID_col = array_column($_query, 'process_id');
		$processsIDs = implode(',', $processsID_col);
		
		$processArray = $_query;
		$processDefectArray = array();
		$TargetArray = array();
		foreach($processsID_col as $tokenCol)
		{
			$currentProcessID = $tokenCol;
			
			// QA DEFECT PROCESS Selection
			$sqlQAProcess = "SELECT q.process_id, q.client_id, q.table_name, p.name as process_name, p.id as d_process_id, c.shname as client_name 
						     FROM qa_defect as q
						     LEFT JOIN process as p ON p.id = FLOOR(q.process_id)
						     LEFT JOIN client as c ON c.id = q.client_id 
						     WHERE FLOOR(process_id) = '$tokenCol'
						     ORDER by q.table_name";
			$data['qaDefectList'] = $qaDefectList = $this->Common_model->get_query_result_array($sqlQAProcess);
			foreach($qaDefectList as $token)
			{
				$currentDefectProcessID = $token['process_id'];
				$processDefectArray[] = $token;
				
				$def_client = $token['client_id'];
				$def_process = $currentProcessID;
				$def_campaign = $token['process_id'];
				
				$sqlTargets = "SELECT * from training_batch_qa_target WHERE batch_id = '$batch_id' AND client_id = '$def_client' AND process_id = '$def_process' AND campaign_id = '$def_campaign'";
				$queryTargets = $this->Common_model->get_query_row_array($sqlTargets);
				$TargetArray[$batch_id][$def_client][$def_process][$def_campaign] = $queryTargets;
			}
			
		}
		
		$data['d_targetArray'] = $TargetArray;
		$data['d_processArray'] = $processArray;
		$data['d_processDefectArray'] = $processDefectArray;
		$data['batchDetails'] = $queryDetails;
		
		$this->load->view('training_analytics/nesting/nesting_performance_target_ajax',$data);
		
	}
	
	
	public function nesting_batch_target_submit()
	{
		$todayDate = CurrDate();
		$batch_id = $this->input->post('batch_id');
		
		$batchDetails = "SELECT * from training_batch WHERE id = '$batch_id'";
		$queryDetails = $this->Common_model->get_query_row_array($batchDetails);
		//echo "<pre>".print_r($_POST, true) ."</pre>";
		
		if(!empty($queryDetails['id']))
		{
			$campaign_id = $this->input->post('campaign_id');
			$client_id = $this->input->post('client_id');
			$process_id = $this->input->post('process_id');
			$week_1_target = $this->input->post('week_1_target');
			$week_2_target = $this->input->post('week_2_target');
			$week_3_target = $this->input->post('week_3_target');
			$week_4_target = $this->input->post('week_4_target');
			$mtd_30_target = $this->input->post('mtd_30_target');
			$mtd_60_target = $this->input->post('mtd_60_target');
			$mtd_90_target = $this->input->post('mtd_90_target');
			
			$totalCampaign = 0;
			if(!empty($campaign_id)){
				$totalCampaign = count($campaign_id);
			}
			
			for($i=0; $i<$totalCampaign;$i++)
			{
				$currentCampaign = $campaign_id[$i];
				$currentClient = $client_id[$i];
				$currentProcess = $process_id[$i];
				$sqlTargets = "SELECT * from training_batch_qa_target WHERE batch_id = '$batch_id' AND client_id = '$currentClient' AND process_id = '$currentProcess' AND campaign_id = '$currentCampaign'";
				$queryTargets = $this->Common_model->get_query_row_array($sqlTargets);
				if(!empty($queryTargets['id'])){
					$dataArray = [
						"week_1_target" => $week_1_target[$i],
						"week_2_target" => $week_2_target[$i],
						"week_3_target" => $week_3_target[$i],
						"week_4_target" => $week_4_target[$i],
						"mtd_30_target" => $mtd_30_target[$i],
						"mtd_60_target" => $mtd_60_target[$i],
						"mtd_90_target" => $mtd_90_target[$i],
						"date_modified" => CurrMySqlDate(),
					];
					$this->db->where('batch_id', $batch_id);
					$this->db->where('client_id', $currentClient);
					$this->db->where('process_id', $currentProcess);
					$this->db->where('campaign_id', $currentCampaign);
					$this->db->update('training_batch_qa_target', $dataArray);							
				} else {
					$dataArray = [
						"batch_id" => $batch_id,
						"client_id" => $currentClient,
						"process_id" => $currentProcess,
						"campaign_id" => $campaign_id[$i],
						"week_1_target" => $week_1_target[$i],
						"week_2_target" => $week_2_target[$i],
						"week_3_target" => $week_3_target[$i],
						"week_4_target" => $week_4_target[$i],
						"mtd_30_target" => $mtd_30_target[$i],
						"mtd_60_target" => $mtd_60_target[$i],
						"mtd_90_target" => $mtd_90_target[$i],
						"date_added" => CurrMySqlDate(),
						"date_modified" => CurrMySqlDate(),
					];
					data_inserter('training_batch_qa_target', $dataArray);
				}
			
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	public function get_interview_details()
    {
	   $userID = $this->input->get('uid');
	   if(!empty($userID)){
		   $userID = $this->uri->segment(3);
	   }
	
	   $data['resultData'] = "hi";
	   $this->load->view('training_analytics/interview_details_ajax',$data);
    }
	
	
	//==============================================================================
	//  TRAINING ACCESS MANAGER LEVEL
	//==============================================================================
	
	  public function check_all_training_access($type = 'access')
	   {
		   $ses_fusion_id = get_user_fusion_id();
		   $result_access = false;
		   if($this->cebu_training_access())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->cebu_training_access('office'); }
		   }
		   if($this->jamaica_training_access())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->jamaica_training_access('office'); }
		   }
		   if($this->only_cebu_training_access())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->only_cebu_training_access('office'); }
		   }
		   return $result_access;
	   }
	   
	   public function only_cebu_training_access($type = 'access')
	   {
		   $access_ids = "FCEB000029";		  
		   $office_access = "CEB";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	
	  public function cebu_training_access($type = 'access')
	   {
		   $access_ids = "FCEB000079,FCEB000076,FCEB000078,FMAN000410";		  
		   $office_access = "CEB,MAN";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   public function jamaica_training_access($type = 'access')
	   {
		   $access_ids = "FJAM004945,FJAM004129,FCEB000001";
		   $office_access = "JAM,ELS";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   
	   
		public function d_array_indexed($dataArray = NULL, $column = "")
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
	
	
	
	
}

	
	