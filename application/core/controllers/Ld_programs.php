<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ld_programs extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->load->model('Ld_programs_model');
		$this->load->helper('ld_programs_helper');
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	public function index(){
		redirect('ld_programs/course_list/all');
	}
	
//============================================================================================//
///  L&D COURSES  BATCH 
//============================================================================================//
		
	public function create_batch()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		if($is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data["course_list"] = $this->Ld_programs_model->info_programs_list();
		
		// DROPDOWN TRIGGER
		if($is_global_access==1) $tr_cnd="";
		else $tr_cnd=" and ( s.office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',s.office_id,'%') ) ";
			
		// TRAINER
		$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id 
		          from signin s 
				  LEFT JOIN department d ON s.dept_id = d.id 
				  LEFT JOIN role r on r.id = s.role_id 
				  WHERE s.status=1 AND (r.folder='agent' OR s.dept_id=11) $tr_cnd ORDER BY name ASC";			
		$data["select_trainer"]  = $this->Common_model->get_query_result_array($qSqlt);
		
		// TRAINEE
		$qSql = "SELECT CONCAT(s.fname,' ' ,s.lname) as trainee_name, s.office_id, s.fusion_id, s.id as user_id 
		         from signin as s 
				 LEFT JOIN department d ON s.dept_id = d.id 
				 LEFT JOIN role r on r.id = s.role_id 
				 WHERE s.status IN (1,4) $tr_cnd 
				 AND (r.folder IN ('agent','tl')) ORDER by trainee_name ASC";
		$data["select_trainee"] = $this->Common_model->get_query_result_array($qSql);
			
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_batch_create.php";
		$data["content_js"] = "ld_programs/ld_programs_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function add_batch_form()
	{
		if(check_logged_in())
		{
						
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			
			$log = get_logs();
			$batch_type = '1';
						
			$office_id  = trim($this->input->post('office_id'));
			$batch_name = trim($this->input->post('batch_name'));			
			$course_id = trim($this->input->post('course_id'));			
			$batch_start_date = date('Y-m-d', strtotime($this->input->post('batch_start_date')));	
			
			$trainer_id   = $this->input->post('trainer_id');
			$trainee_id = $this->input->post('trainee_id_select');
			$unique_trainee_list = array_unique($trainee_id);
			$total_id = count($unique_trainee_list);		
			
			if($total_id > 0){
				
			$field_array = array(
				"batch_name"   => $batch_name,
				"batch_start_date"   => $batch_start_date,
				"course_id"   => $course_id,
				"office_id" => $office_id,
				"trn_type" => $batch_type,
				"trainer_id" => $trainer_id,
				"added_by" => $current_user,
				"date_added" => $curDateTime,
				"status" => '1',
				"logs"   => get_logs()
			);
			$insert_train = data_inserter('ld_programs_batch',$field_array);
			
			foreach($unique_trainee_list as $token_trainee){
								
				$field_array = array(
					"batch_id" => $insert_train,
					"user_id"    => $token_trainee,
					"date_added"  => $curDateTime,
				);
				data_inserter('ld_programs_batch_list',$field_array);
					
			}
			
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		
		}
	
	}

	public function batch_list()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$filterCond=""; 
			$data["aside_template"] = "ld_programs/aside.php";
			$data["content_template"] = "ld_programs/ld_batch_list.php";
			$data["content_js"] = "ld_programs/ld_programs_js.php";
			
			$data['location_list'] = $this->Ld_programs_model->info_office_list($current_user);
			$data['course_list'] = $this->Ld_programs_model->info_programs_list();
			
			$searchFilter = "";
			//==================== FILTER SEARCH			
			$office_id = $user_office_id;
			$search_office_id = trim($this->input->get('office_id'));		
			if($search_office_id !="ALL" && !empty($search_office_id)){
				$office_id = $search_office_id;
				$searchFilter .= " AND (b.office_id = '$office_id')";
			}
			if($search_office_id =="ALL"){
				$searchFilter .= " AND (b.office_id = '' OR b.office_id IS NULL)";
			}
			$data['office_id'] = $office_id;
		
			$course_id = "";
			$search_course_id = trim($this->input->get('course_id'));		
			if($search_course_id !="ALL" && !empty($search_course_id)){
				$course_id = $search_course_id;
				$searchFilter .= " AND (b.course_id = '$course_id')";
			}			
			$data['course_id'] = $course_id;	
			
			$dateRange = date('d/m/Y', strtotime('-1 month', strtotime('now'))) ." - " .date('d/m/Y');
			if($this->input->get('search_batch'))
			{
				$daterange_full    = $this->input->get('date_range');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$dateRange = trim($daterange_explode[0]) ." - " .trim($daterange_explode[1]);
				$searchFilter .= " AND b.batch_start_date >= '$startdate_range' AND b.batch_start_date <= '$enddate_range'";
			}
			$data['dateRange'] = $dateRange;
			
			
			//=============== BATCH LIST
			if(get_global_access() || is_access_ld_admin() || (get_role_dir()=="manager" && get_dept_folder()=="training"))
			{				
				$qSql = "SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name, c.course_code  
						 from ld_programs_batch as b
						 LEFT JOIN ld_programs as c ON c.id = b.course_id
						 LEFT JOIN signin as s ON s.id = b.trainer_id
						 WHERE 1 $searchFilter
						 ORDER BY b.course_id, b.batch_start_date";				
				$batchList = $this->Common_model->get_query_result_array($qSql);
			} else {
				$myteamIDs = $this->get_team_id($current_user);
				$qSql="SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name  
					   from ld_programs_batch as b
					   LEFT JOIN ld_programs as c ON c.id = b.course_id
					   LEFT JOIN signin as s ON s.id = b.trainer_id
					   WHERE 1 AND trainer_id IN ($myteamIDs) $searchFilter
					   ORDER BY b.course_id, b.batch_start_date";				
				$batchList = $this->Common_model->get_query_result_array($qSql);
			}
			
			$j=0; $batchTraineeList = array();
			foreach($batchList as $rowtoken)
			{
				$batch_id = $rowtoken['id'];				
				$sqltname = "SELECT bd.*, CONCAT(s.fname, ' ', s.lname) as full_name 
				             from ld_programs_batch_list as bd 
							 LEFT JOIN signin as s ON s.id = bd.user_id
							 LEFT JOIN department as d ON d.id = s.dept_id
							 LEFT JOIN role as r ON r.id = s.role_id
							 WHERE bd.batch_id = '$batch_id'";
				$batchTraineeList[$batch_id] = $this->Common_model->get_query_result_array($sqltname);
				$j++;
			}
			
			$data["allbatchList"]['data'] = $batchList;
			$data["allbatchList"]['trainees'] = $batchTraineeList;
			//echo "<pre>" .print_r($data["allbatchList"], true) ."</pre>";die();
			
						
			$this->load->view('dashboard',$data);
			
		}
	}
	
	public function batch_details_table()
	{
		$batch_id = $this->input->post('batch_id');
		$data['batch_id'] = $batch_id;
		
		$todayDate = CurrDate();
		$sqlInfo = "SELECT bd.*, yy.tLtime, CONCAT(s.fname, ' ', s.lname) as full_name, s.office_id,s.fusion_id, 
		            e.name as disposition_name, s.status as user_status, s.is_logged_in, s.disposition_id
					 from ld_programs_batch_list as bd 
					 LEFT JOIN signin as s ON s.id = bd.user_id
					 LEFT JOIN event_master as e ON e.id = s.disposition_id
					 LEFT JOIN 
					(select user_id as luid, sum(TIME_TO_SEC(timediff(logout_time,login_time))) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."' group by user_id) yy on (bd.user_id=yy.luid)
					 LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 WHERE bd.batch_id = '$batch_id'";
		$batchTrainees = $this->Common_model->get_query_result_array($sqlInfo);		
		$data['batchTrainees'] = $batchTrainees;
		
		
		
		$this->load->view('ld_programs/ld_batch_table_details',$data);
		
	}
	
	
	public function batch_performance_details_table()
	{
		$batch_id = $this->input->get('batch_id');
		if(empty($batch_id)){ $batch_id = $this->input->post('batch_id'); }
		$data['batch_id'] = $batch_id;
		
		$todayDate = CurrDate();
		$sqlInfo = "SELECT bd.*, yy.tLtime, CONCAT(s.fname, ' ', s.lname) as full_name, s.office_id,s.fusion_id, 
		            e.name as disposition_name, s.status as user_status, s.is_logged_in, s.disposition_id
					 from ld_programs_batch_list as bd 
					 LEFT JOIN signin as s ON s.id = bd.user_id
					 LEFT JOIN event_master as e ON e.id = s.disposition_id
					 LEFT JOIN 
					(select user_id as luid, sum(TIME_TO_SEC(timediff(logout_time,login_time))) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."' group by user_id) yy on (bd.user_id=yy.luid)
					 LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 WHERE bd.batch_id = '$batch_id'";
		$batchTrainees = $this->Common_model->get_query_result_array($sqlInfo);		
		$data['batchTrainees'] = $batchTrainees;
		
		
		$sqlDesignInfo = "SELECT * from ld_programs_cert_design WHERE batch_id = '$batch_id' ORDER by ID DESC LIMIT 1";
		$queryDesignInfo = $this->Common_model->get_query_result_array($sqlDesignInfo);
		$data['design_info'] = array();
		if(!empty($queryDesignInfo)){
			$data['design_info'] = $queryDesignInfo;
		}
		$data['design_id'] = !empty($queryDesignInfo[0]['id']) ? $queryDesignInfo[0]['id'] : "";
		
		$designKpi = array(); $designData = array(); $kpiData = array();
		foreach($queryDesignInfo as $token){			
			$designID = $token['id'];
			$qSql = "SELECT kp.*, km.name as kpi_type_name from ld_programs_cert_kpi kp 
					 LEFT JOIN pm_kpi_type_mas as km ON km.id = kp.kpi_type
					 WHERE kp.design_id = $designID";
			$designKpi[$designID]=$this->Common_model->get_query_result_array($qSql);
			
			$sqlDesignData = "SELECT * from ld_programs_cert_data WHERE batch_id = '$batch_id' AND design_id = '$designID'";
			$queryDesignData = $this->Common_model->get_query_result_array($sqlDesignData);			
			
			foreach($batchTrainees as $tokenBatch)
			{
				$currentTrainee = $tokenBatch['user_id'];
				$designData[$designID][$currentTrainee] = array_filter($queryDesignData, function($dataSet) use ($currentTrainee) {
					return($dataSet['user_id'] == $currentTrainee);
				});
				$kpiData[$designID][$currentTrainee] = $this->array_indexed($designData[$designID][$currentTrainee], 'kpi_id');
			}
		}
		
		$data['designKpi'] = $designKpi;
		$data['designData'] = $designData;
		$data['kpiData'] = $kpiData;
		
		$this->load->view('ld_programs/ld_batch_performance_table_details',$data);
		
	}
	
	
	public function batch_performance()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$filterCond=""; 
			$data["aside_template"] = "ld_programs/aside.php";
			$data["content_template"] = "ld_programs/ld_batch_performance.php";
			$data["content_js"] = "ld_programs/ld_programs_js.php";
			
			$data['location_list'] = $this->Ld_programs_model->info_office_list($current_user);
			$data['course_list'] = $this->Ld_programs_model->info_programs_list();
			
			$searchFilter = "";
			//==================== FILTER SEARCH			
			$office_id = $user_office_id;
			$search_office_id = trim($this->input->get('office_id'));		
			if($search_office_id !="ALL" && !empty($search_office_id)){
				$office_id = $search_office_id;
				$searchFilter .= " AND (b.office_id = '$office_id')";
			}
			if($search_office_id =="ALL"){
				$searchFilter .= " AND (b.office_id = '' OR b.office_id IS NULL)";
			}
			$data['office_id'] = $office_id;
		
			$course_id = "";
			$search_course_id = trim($this->input->get('course_id'));		
			if($search_course_id !="ALL" && !empty($search_course_id)){
				$course_id = $search_course_id;
				$searchFilter .= " AND (b.course_id = '$course_id')";
			}			
			$data['course_id'] = $course_id;	
			
			$dateRange = date('d/m/Y', strtotime('-1 month', strtotime('now'))) ." - " .date('d/m/Y');
			if($this->input->get('search_batch'))
			{
				$daterange_full    = $this->input->get('date_range');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$dateRange = trim($daterange_explode[0]) ." - " .trim($daterange_explode[1]);
				$searchFilter .= " AND b.batch_start_date >= '$startdate_range' AND b.batch_start_date <= '$enddate_range'";
			}
			$data['dateRange'] = $dateRange;
			
			
			//=============== BATCH LIST
			if(get_global_access() || is_access_ld_admin() || (get_role_dir()=="manager" && get_dept_folder()=="training"))
			{				
				$qSql = "SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name, c.course_code, d.id as design_id  
						 from ld_programs_batch as b
						 LEFT JOIN ld_programs as c ON c.id = b.course_id
						 LEFT JOIN ld_programs_cert_design as d ON d.batch_id = b.id
						 LEFT JOIN signin as s ON s.id = b.trainer_id
						 WHERE 1 $searchFilter
						 ORDER BY b.course_id, b.batch_start_date";				
				$batchList = $this->Common_model->get_query_result_array($qSql);
			} else {
				$myteamIDs = $this->get_team_id($current_user);
				$qSql="SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name, d.id as design_id   
					   from ld_programs_batch as b
					   LEFT JOIN ld_programs as c ON c.id = b.course_id
					   LEFT JOIN ld_programs_cert_design as d ON d.batch_id = b.id
					   LEFT JOIN signin as s ON s.id = b.trainer_id
					   WHERE 1 AND trainer_id IN ($myteamIDs) $searchFilter
					   ORDER BY b.course_id, b.batch_start_date";				
				$batchList = $this->Common_model->get_query_result_array($qSql);
			}
			
			$j=0; $batchTraineeList = array();
			foreach($batchList as $rowtoken)
			{
				$batch_id = $rowtoken['id'];				
				$sqltname = "SELECT bd.*, CONCAT(s.fname, ' ', s.lname) as full_name 
				             from ld_programs_batch_list as bd 
							 LEFT JOIN signin as s ON s.id = bd.user_id
							 LEFT JOIN department as d ON d.id = s.dept_id
							 LEFT JOIN role as r ON r.id = s.role_id
							 WHERE bd.batch_id = '$batch_id'";
				$batchTraineeList[$batch_id] = $this->Common_model->get_query_result_array($sqltname);
				$j++;
			}
			
			$data["allbatchList"]['data'] = $batchList;
			$data["allbatchList"]['trainees'] = $batchTraineeList;
			//echo "<pre>" .print_r($data["allbatchList"], true) ."</pre>";die();
			
						
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	public function batch_performance_design()
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
			
			$data["aside_template"]   = "ld_programs/aside.php";
			$data["content_template"] = "ld_programs/ld_batch_performance_design.php";
			$data["content_js"] = "ld_programs/ld_programs_js.php";
			
			//=========== SET TABLES AND NAME
			$data['design']['table'] = $design_table = "ld_programs_cert_design";
			$data['design']['name'] = $design_name = "Batch";
			$data['design']['kpi'] = $design_kpi = "ld_programs_cert_kpi";
			$data['design']['data'] = $design_data = "ld_programs_cert_data";
			$data['design']['url']['design'] = $url_design = "ld_programs_cert_design";
			$data['design']['url']['add_design'] = $url_add_design = "batch_performance_design_add";
			$data['design']['url']['update_design'] = $url_update_design = "batch_performance_design_update";
			
			//=========== OFFICE > COURSE FILTER
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$cValue = trim($this->input->post('course_id'));
			if($cValue=="") $cValue = trim($this->input->get('course_id'));
			
			$data['oValue']=$oValue;
			$data['cValue']=$cValue;
									
			$_filterCond="";
			//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
			//if($cValue!="ALL" && $cValue!="")  $_filterCond  = " AND course_id='".$oValue."'";
										
			$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
			$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
			$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" WHERE id = '$user_site_id'";
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data["course_list"] = $this->Ld_programs_model->info_programs_list();
			
			//============ FORM URL DATA
			$data['hide_normal'] = "off";
			$url_batch_id = "";			
			if(!empty($this->input->get('batch_id'))){ $url_batch_id = $this->input->get('batch_id');	}
			if(!empty($this->uri->segment(3))){ $url_batch_id = $this->uri->segment(3);	}
			$data['url_batch_id'] = $url_batch_id;
			
			// BATCH DETAILS
			$data['batch_info'] = $this->Ld_programs_model->batch_details($url_batch_id);
			$_courseID = $data['batch_info'][0]['course_id'];
				
			// CHECK ANY PREVIOUS DESIGN
			$sqldd = "SELECT d.id as value from $design_table as d 
			          INNER JOIN ld_programs_batch as b ON b.id = d.batch_id 
					  WHERE b.course_id = '".$_courseID."' ORDER BY d.ID DESC LIMIT 1";
			$data["previous_design"] = $this->Common_model->get_single_value($sqldd);
			if(!empty($data["previous_design"]))
			{
				$qSql = "SELECT kp.*, km.name as kpi_type_name from $design_kpi kp 
						 LEFT JOIN pm_kpi_type_mas as km ON km.id = kp.kpi_type
				         WHERE design_id = '".$data["previous_design"]."'";
				$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			// GET DESIGN DATA
			$qSql="SELECT * from $design_table WHERE is_active=1 AND batch_id = '$url_batch_id' $_filterCond";
			$data["design_table"] = $this->Common_model->get_query_result_array($qSql);			
			$pmkpiarray=array();
			foreach($data["design_table"] as $row):
				$mp_id= $row['id'];
				$qSql = "SELECT kp.*, km.name as kpi_type_name from $design_kpi kp 
				         LEFT JOIN pm_kpi_type_mas as km ON km.id = kp.kpi_type
						 WHERE kp.design_id = $mp_id";
				$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
			endforeach;			
			$data['design_kpi'] = $pmkpiarray;
					
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
   public function batch_performance_design_add()
   {
		if(check_logged_in())
		{
						
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			
			//=========== SET TABLES AND NAME
			$data['design']['table'] = $design_table = "ld_programs_cert_design";
			$data['design']['name'] = $design_name = "Batch";
			$data['design']['kpi'] = $design_kpi = "ld_programs_cert_kpi";
			$data['design']['data'] = $design_data = "ld_programs_cert_data";
			$data['design']['url']['design'] = $url_design = "ld_programs_cert_design";
			$data['design']['url']['add_design'] = $url_add_design = "batch_performance_design_add";
			$data['design']['url']['update_design'] = $url_update_design = "batch_performance_design_update";
			
			$_run = false;  
			
			$log = get_logs();
			
			$batch_id    = trim($this->input->post('batch_id'));
			$passing_percentile = trim($this->input->post('passing_percentile'));
			$design_title  = trim($this->input->post('design_title'));
			$kpi_name_arr = $this->input->post('kpi_name');
			$kpi_type_arr = $this->input->post('kpi_type');
			$kpi_weightage_arr = $this->input->post('kpi_weightage');
			
			$qSqlcheck      = "SELECT id as value from $design_table WHERE batch_id = '$batch_id'";
			$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
			if($uploadcheck != "")
			{
				redirect($_SERVER['HTTP_REFERER']);
				
			} else {
				
				$field_array = array(
					"batch_id"     => $batch_id,
					"description"  => $design_title,
					"passing_percentile"  => $passing_percentile,
					"added_by"     => $current_user,
					"is_active"    => '1',
					"added_date"   => $curDateTime,
					"logs"        => $log
				);
				
				$did = data_inserter($design_table,$field_array);
				
				foreach($kpi_name_arr as $index => $kpi_name){
					if($kpi_name<>""){
						$field_array = array(
							"design_id" => $did,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage" => $kpi_weightage_arr[$index],
							"is_del"       => '0',
							"added_by"    => $current_user,
							"added_date"  => $curDateTime,
							"logs"       => $log
						);
						data_inserter($design_kpi,$field_array);
					}
				}
			
				redirect($_SERVER['HTTP_REFERER']);
			}
			
	   }         
   }
   
   
   public function batch_performance_design_update()
   {
		if(check_logged_in())
		{
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			
			//=========== SET TABLES AND NAME
			$data['design']['table'] = $design_table = "ld_programs_cert_design";
			$data['design']['name'] = $design_name = "Batch";
			$data['design']['kpi'] = $design_kpi = "ld_programs_cert_kpi";
			$data['design']['data'] = $design_data = "ld_programs_cert_data";
			$data['design']['url']['design'] = $url_design = "ld_programs_cert_design";
			$data['design']['url']['add_design'] = $url_add_design = "batch_performance_design_add";
			$data['design']['url']['update_design'] = $url_update_design = "batch_performance_design_update";
			
			$_run = false;  
			
			$log = get_logs();
			
			$batch_id  = trim($this->input->post('batch_id'));
			$design_id = trim($this->input->post('design_id'));
			$passing_percentile = trim($this->input->post('passing_percentile'));
			$design_title  = trim($this->input->post('design_title'));
			$kpi_name_arr = $this->input->post('kpi_name');
			$kpi_type_arr = $this->input->post('kpi_type');
			$kpi_weightage_arr = $this->input->post('kpi_weightage');
			
			$qSqlcheck      = "SELECT id as value from $design_table WHERE id = '$design_id' AND batch_id = '$batch_id'";
			$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
			if(!empty($uploadcheck))
			{
				
				$field_array = array(
					"description"  => $design_title,
					"passing_percentile"  => $passing_percentile,
					"is_active"    => '1',
					"logs"        => $log
				);				
				$this->db->where('id', $design_id);
				$this->db->update($design_table, $field_array);
				
				$this->db->where('design_id', $design_id);
				$this->db->delete($design_kpi);
				
				foreach($kpi_name_arr as $index => $kpi_name){
					if($kpi_name<>""){
						$field_array = array(
							"design_id" => $design_id,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage" => $kpi_weightage_arr[$index],
							"is_del"       => '0',
							"added_by"    => $current_user,
							"added_date"  => $curDateTime,
							"logs"       => $log
						);
						data_inserter($design_kpi,$field_array);
					}
				}			
				
			}
			
			redirect($_SERVER['HTTP_REFERER']);
			
	   }         
   }
   
   
   
   public function download_batch_performance_header()
   {		
		$design_id = trim($this->input->get('design_id'));
		$batch_id = trim($this->input->get('batch_id'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "ld_programs_cert_design";
		$data['design']['name'] = $design_name = "Batch";
		$data['design']['kpi'] = $design_kpi = "ld_programs_cert_kpi";
		$data['design']['data'] = $design_data = "ld_programs_cert_data";
		$data['design']['url']['design'] = $url_design = "ld_programs_cert_design";
		$data['design']['url']['add_design'] = $url_add_design = "batch_performance_design_add";
		$data['design']['url']['update_design'] = $url_update_design = "batch_performance_design_update";
		
		
		$qSql = "SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name, c.course_code, d.id as design_id  
				 from ld_programs_batch as b
				 LEFT JOIN ld_programs as c ON c.id = b.course_id
				 LEFT JOIN ld_programs_cert_design as d ON d.batch_id = b.id
				 LEFT JOIN signin as s ON s.id = b.trainer_id
				 WHERE b.id = '$batch_id'";				
		$batchInfo = $this->Common_model->get_query_row_array($qSql);
				
		$qSqlcheck    = "SELECT * from $design_table WHERE id = '$design_id' AND batch_id = '$batch_id'";
		$uploadcheck  = $this->Common_model->get_query_row_array($qSqlcheck);
		
		$sqltname = "SELECT bd.*, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id 
					 from ld_programs_batch_list as bd 
					 LEFT JOIN signin as s ON s.id = bd.user_id
					 LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 WHERE bd.batch_id = '$batch_id'";
		$batchTraineeList = $this->Common_model->get_query_result_array($sqltname);
        
		if(!empty($batchInfo['id'])){
			
		$sht_title = "Batch_Trainees_".$batchInfo['id'];
		$filename = "./assets/reports/".$sht_title.".xls";
		$title = $batchInfo['batch_name'];
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle($sht_title);
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SL');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSION ID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batch_id)){			
			$slNo = 0; $r=2;			
			foreach($batchTraineeList as $rowD){
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['full_name']);			
			}
		}
		
		
		if(!empty($uploadcheck['id'])){
			
		$j=3; $r=2;		
		$designID = $uploadcheck['id'];		
		echo $qSql = "SELECT kp.*, km.name as kpi_type_name from $design_kpi kp 
				 LEFT JOIN pm_kpi_type_mas as km ON km.id = kp.kpi_type
				 WHERE kp.design_id = '".$designID."'";
		$design_kpi = $this->Common_model->get_query_result_array($qSql);
		$currentcellvalue = ord('C');
		
		foreach($design_kpi as $row):		
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if($row['kpi_name'] == "Status"){ 
			$getkpiname = "Status (Pass/Fail)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);			
		endforeach;
		
		}
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$sht_title.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel , 'Excel2007');
		$objWriter->save('php://output');
		exit(); 			
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}		
	}
	


	public function upload_batch_performance_data()
	{
		$current_user = get_user_id();				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "ld_programs_cert_design";
		$data['design']['name'] = $design_name = "Batch";
		$data['design']['kpi'] = $design_kpi = "ld_programs_cert_kpi";
		$data['design']['data'] = $design_data = "ld_programs_cert_data";
		$data['design']['url']['design'] = $url_design = "ld_programs_cert_design";
		$data['design']['url']['add_design'] = $url_add_design = "batch_performance_design_add";
		$data['design']['url']['update_design'] = $url_update_design = "batch_performance_design_update";
		
		$outputFile = FCPATH ."uploads/ld_programs/performance/";
		$config = [
			'upload_path'   => $outputFile,
			'allowed_types' => 'xls|xlsx',
			'max_size' => '1024000',
		];		
		$this->load->library('upload');
		$this->upload->initialize($config);
		$this->upload->overwrite = true;
		if (!$this->upload->do_upload('upload_result'))
		{
			redirect($_SERVER['HTTP_REFERER'].'/error');
		}		
		$upload_data = $this->upload->data();
		$file_path = $outputFile .$upload_data['file_name'];
		
		$design_id = trim($this->input->post('design_id'));
		$batch_id = trim($this->input->post('batch_id'));

		// GET KPI DETAILS
		$qSql = "SELECT * from $design_kpi kp where design_id = $design_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}		
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "SELECT id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{
				$qSqlcheck  = "SELECT id as value from $design_data where user_id ='$user_id' AND batch_id = '$batch_id' AND design_id = '$design_id' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck = $this->Common_model->get_single_value($qSqlcheck);
				
				$valueFound = $rag_data['fusion_id'][$starti][$j];
				if($valueFound == ""){ $valueFound = ""; }
				$field_array = array(
							"user_id"    => $user_id,
							"batch_id"   => $batch_id,
							"design_id"  => $design_id,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $valueFound,
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);				
				if($uploadcheck != ""){					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data, $field_array);					
				} else {					
					data_inserter($design_data,$field_array);				
				}			
			}	
			}			
		}
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			redirect($_SERVER['HTTP_REFERER'].'/error');
		}
		else
		{
			$this->db->trans_commit();
			redirect($_SERVER['HTTP_REFERER'].'/success');
		}
		
		} else {
			redirect($_SERVER['HTTP_REFERER'].'/error');
		}		
	}
		
	 
//================== BATCH ANALYTICS ===========================================================//

	public function batch_analytics()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$filterCond=""; 
			$data["aside_template"] = "ld_programs/aside.php";
			$data["content_template"] = "ld_programs/ld_batch_analytics.php";
			$data["content_js"] = "ld_programs/ld_programs_js.php";
			
			$data['location_list'] = $this->Ld_programs_model->info_office_list($current_user);
			$data['course_list'] = $this->Ld_programs_model->info_programs_list();
			
			$searchFilter = "";
			//==================== FILTER SEARCH			
			$office_id = $user_office_id;
			$search_office_id = trim($this->input->get('office_id'));		
			if($search_office_id !="ALL" && !empty($search_office_id)){
				$office_id = $search_office_id;
				$searchFilter .= " AND (b.office_id = '$office_id')";
			}
			if($search_office_id =="ALL"){
				$searchFilter .= " AND (b.office_id = '' OR b.office_id IS NULL)";
			}
			$data['office_id'] = $office_id;
		
			$course_id = "";
			$search_course_id = trim($this->input->get('course_id'));		
			if($search_course_id !="ALL" && !empty($search_course_id)){
				$course_id = $search_course_id;
				$searchFilter .= " AND (b.course_id = '$course_id')";
			}			
			$data['course_id'] = $course_id;	
			
			$dateRange = date('d/m/Y', strtotime('-1 month', strtotime('now'))) ." - " .date('d/m/Y');
			if($this->input->get('search_batch'))
			{
				$daterange_full    = $this->input->get('date_range');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$dateRange = trim($daterange_explode[0]) ." - " .trim($daterange_explode[1]);
				$searchFilter .= " AND b.batch_start_date >= '$startdate_range' AND b.batch_start_date <= '$enddate_range'";
			}
			$data['dateRange'] = $dateRange;
			
			
			//=============== BATCH LIST
			if(get_global_access() || is_access_ld_admin() || (get_role_dir()=="manager" && get_dept_folder()=="training"))
			{				
				$qSql = "SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name, c.course_code  
						 from ld_programs_batch as b
						 LEFT JOIN ld_programs as c ON c.id = b.course_id
						 LEFT JOIN signin as s ON s.id = b.trainer_id
						 WHERE 1 $searchFilter
						 ORDER BY b.course_id, b.batch_start_date";				
				$batchList = $this->Common_model->get_query_result_array($qSql);
			} else {
				$myteamIDs = $this->get_team_id($current_user);
				$qSql="SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name  
					   from ld_programs_batch as b
					   LEFT JOIN ld_programs as c ON c.id = b.course_id
					   LEFT JOIN signin as s ON s.id = b.trainer_id
					   WHERE 1 AND trainer_id IN ($myteamIDs) $searchFilter
					   ORDER BY b.course_id, b.batch_start_date";				
				$batchList = $this->Common_model->get_query_result_array($qSql);
			}
			
			$j=0; $batchTraineeList = array(); $batchAnalyticsList = array();
			foreach($batchList as $rowtoken)
			{
				$batch_id = $rowtoken['id'];				
				$sqltname = "SELECT bd.*, CONCAT(s.fname, ' ', s.lname) as full_name 
				             from ld_programs_batch_list as bd 
							 LEFT JOIN signin as s ON s.id = bd.user_id
							 LEFT JOIN department as d ON d.id = s.dept_id
							 LEFT JOIN role as r ON r.id = s.role_id
							 WHERE bd.batch_id = '$batch_id'";
				//$batchTraineeList[$batch_id] = $this->Common_model->get_query_result_array($sqltname);
				$j++;				
				
				$qSql = "SELECT tb.id, tb.status, tb.trainer_id, tb.batch_name, tb.office_id, c.course_name,
				        CONCAT(s.fname,' ' ,s.lname) as trainer_name, tb.batch_start_date, d.total_trainees, sv.avg_rating, w.w_batch_id, w.w_user_id, w.w_weightage, cd.passing_percentile					
				        from ld_programs_batch tb 
						LEFT JOIN signin as s ON s.id=tb.trainer_id
						LEFT JOIN ld_programs as c ON c.id = tb.course_id
						LEFT JOIN (SELECT count(id) as total_trainees, batch_id from ld_programs_batch_list GROUP BY batch_id) as d ON d.batch_id = tb.id						
						LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, batch_id from ld_programs_batch_survey GROUP BY batch_id) as sv ON sv.batch_id = tb.id
						LEFT JOIN ld_programs_cert_design as cd ON cd.batch_id = tb.id
						LEFT JOIN (SELECT t.batch_id as w_batch_id, GROUP_CONCAT(t.user_id) as w_user_id, GROUP_CONCAT(t.weightage) as w_weightage from 
						(SELECT c.batch_id, c.user_id, SUM((c.kpi_value * (k.kpi_weightage/100))) as weightage
						FROM ld_programs_cert_data as c
						LEFT JOIN ld_programs_cert_kpi as k ON k.id = c.kpi_id
						WHERE k.kpi_name != 'status' GROUP BY c.user_id, c.batch_id) 
						as t GROUP BY t.batch_id) as w ON w.w_batch_id = tb.id
						WHERE tb.id = '$batch_id'";
				$batchAnalyticsList[$batch_id] = $this->Common_model->get_query_result_array($qSql);			
			}
			
			$data["allbatchList"]['data'] = $batchList;
			$data["allbatchList"]['analytics'] = $batchAnalyticsList;
			//echo "<pre>" .print_r($data["allbatchList"], true) ."</pre>";die();
			
						
			$this->load->view('dashboard',$data);
			
		}
	}


	public function	ta_updateBatchDetails()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('batch_id');
		$batch_name = $this->input->post('batch_name');
		
		if($batch_id != "" && $batch_name != "")
		{
			$data = [ 'batch_name' => $batch_name ];
			$this->db->where('id', $batch_id);
			$this->db->update('ld_programs_batch', $data);
		}
		redirect($_SERVER['HTTP_REFERER']);
	}








//================== MASTER COURSES ===========================================================//
	
	public function create_course()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		if($is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data['course_category'] = $this->Ld_programs_model->info_course_category_list();
		
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_course_create.php";
		$data["content_js"] = "ld_programs/ld_programs_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function add_course_form()
	{
		if(check_logged_in())
		{						
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			
			$log = get_logs();
			$batch_type = '1';
						
			$course_id  = trim(strtoupper($this->input->post('course_id')));
			$course_code  = trim(strtoupper($this->input->post('course_code')));
			$course_name = trim($this->input->post('course_name'));			
			$course_snippet = trim($this->input->post('course_snippet'));			
			$course_description = trim($this->input->post('course_description'));			
			$course_category = trim($this->input->post('course_category'));			
			
			$courseCheck = "SELECT * from ld_programs WHERE course_code = '$course_code'";
			$courseChecker = $this->Common_model->get_query_result_array($courseCheck);
			
			if(empty($courseChecker)){
				// UPLOAD IMAGE
				$course_image = $_FILES['course_image']['name'];
				$upload_file_name = "";
				if(!empty($course_image)){
					$outputFile = FCPATH ."uploads/ld_programs/";
					$config = [
						'upload_path'   => $outputFile,
						'allowed_types' => 'jpg|png|jpeg|gif',
						'max_size' => '1024000',
					];			
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->overwrite = false;
					if(!$this->upload->do_upload('course_image'))
					{
						redirect(base_url().'ld_programs/create_course/error');
					}
					$upload_data = $this->upload->data();
					$upload_file_name = $upload_data['file_name'];
				}			
					
				$field_array = array(
					"course_code"   => $course_code,
					"course_name"   => $course_name,
					"category_id"   => $course_category,
					"course_snippet"   => $course_snippet,
					"course_description" => $course_description,
					"is_active" => '1',
					"logs"   => get_logs()
				);
				if(!empty($upload_file_name)){
					$field_array += [ "course_img" => $upload_file_name ];
				}
				
				if(empty($course_id)){
					$field_array += [ "added_by" => $current_user ];
					$field_array += [ "date_added" => $curDateTime ];
					$insert_train = data_inserter('ld_programs',$field_array);	
				} else {
					$this->db->where('id', $course_id);
					$this->db->update('ld_programs', $field_array);
				}		
			} else {
				redirect($_SERVER['HTTP_REFERER'].'/error');	
			}						
		}			
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	public function course_update_ajax()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		$data['course_id'] = $course_id  = trim($this->input->get('eid'));
		
		$data['course_info'] = $this->Ld_programs_model->info_programs_list($course_id);
		$data['course_category'] = $this->Ld_programs_model->info_course_category_list();
				
		$this->load->view('ld_programs/ld_course_edit',$data);
	}
	
	public function course_details_ajax()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		$data['course_id'] = $course_id  = trim($this->input->get('eid'));
		
		$data['course_info'] = $this->Ld_programs_model->info_programs_list($course_id);
		$data['course_category'] = $this->Ld_programs_model->info_course_category_list();
				
		$this->load->view('ld_programs/ld_course_details',$data);
	}
	
	public function course_list()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		if($is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data['category_list'] = $this->Ld_programs_model->info_course_category_list();
		$data['course_list'] = $this->Ld_programs_model->info_programs_list();
		
		$data['pageName'] = "All Course List";
		if($this->uri->segment(3) != 'all' && !empty($this->uri->segment(3)))
		{
			$catID = $this->uri->segment(3);
			$data['catInfo'] = $this->Ld_programs_model->info_course_category_list($catID);
			$data['course_list'] = $this->Ld_programs_model->info_programs_list('', $catID);
			$data['pageName'] = "Invalid Category";
			if(!empty($data['catInfo'])){
				$data['pageName'] = $data['catInfo'][0]['category_name'];
			}
			
		}
		
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_course_list.php";
		$data["content_js"] = "ld_programs/ld_programs_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function delete_course()
	{
		if(check_logged_in())
		{						
			$course_id  = trim($this->input->get('did'));
			$dataArray = [ 'is_active' => 0 ];
			$this->db->where('id', $course_id);
			$this->db->update('ld_programs', $dataArray);
		}
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
//================== COURSE CATEGORY ===========================================================// 	
	
	public function course_category()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		if($is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data['category_list'] = $this->Ld_programs_model->info_course_category_list();
		
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_course_category.php";
		$data["content_js"] = "ld_programs/ld_programs_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function add_course_category()
	{
		if(check_logged_in())
		{						
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			
			$log = get_logs();
			$batch_type = '1';
						
			$category_id  = trim($this->input->post('category_id'));
			$category_name  = trim($this->input->post('category_name'));
			$category_description  = trim($this->input->post('category_description'));			
			
			// UPLOAD IMAGE
			$category_image = $_FILES['category_image']['name'];
			$upload_file_name = "";
			if(!empty($category_image)){
				$outputFile = FCPATH ."uploads/ld_programs/";
				$config = [
					'upload_path'   => $outputFile,
					'allowed_types' => 'jpg|png|jpeg|gif',
					'max_size' => '1024000',
				];			
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->overwrite = false;
				if(!$this->upload->do_upload('category_image'))
				{
					redirect(base_url().'ld_programs/course_category/error');
				}
				$upload_data = $this->upload->data();
				$upload_file_name = $upload_data['file_name'];
			}			
					
			$field_array = array(
				"category_name"   => $category_name,
				"category_description"   => $category_description,
				"is_active" => '1',
				"logs"   => get_logs()
			);
			if(!empty($upload_file_name)){
				$field_array += [ "category_image" => $upload_file_name ];
			}
			
			if(empty($category_id)){
				$field_array += [ "added_by" => $current_user ];
				$field_array += [ "date_added" => $curDateTime ];
				$insert_train = data_inserter('ld_programs_category',$field_array);	
			} else {
				$this->db->where('id', $category_id);
				$this->db->update('ld_programs_category', $field_array);
			}			
								
		}		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	public function course_category_info_ajax()
	{
		if(check_logged_in())
		{						
			$category_id  = trim($this->input->get('eid'));
			$queryDetails = array();
			if(!empty($category_id)){
				$sqlDetails = "SELECT * from ld_programs_category WHERE id = '$category_id'";
				$queryDetails = $this->Common_model->get_query_row_array($sqlDetails);
			}
			echo json_encode($queryDetails);
		}
	}
	
	public function delete_course_category()
	{
		if(check_logged_in())
		{						
			$category_id  = trim($this->input->get('did'));
			$dataArray = [ 'is_active' => 0 ];
			$this->db->where('id', $category_id);
			$this->db->update('ld_programs_category', $dataArray);
		}
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	
	//================== COURSE SCHEDULE ===========================================================// 	
	
	public function course_schedule()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		if($is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data['course_list'] = $this->Ld_programs_model->info_programs_list();
		$data['schedule_list'] = $this->Ld_programs_model->info_schedule_list();
		
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_course_schedule.php";
		$data["content_js"] = "ld_programs/ld_programs_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function course_calendar()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		if($is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data['course_list'] = $this->Ld_programs_model->info_programs_list();
		$data['schedule_list'] = $this->Ld_programs_model->info_schedule_list();
				
		$course_id = "";
		if(!empty($this->input->get('course_id'))){
			$course_id = $this->input->get('course_id');
			$data['schedule_list'] = $this->Ld_programs_model->info_schedule_list('', $course_id);
		}
		
		$onlineColour = "#c9c78b";
		$offlineColour = "#00a65a";
		
		$data['calendar_result'] = array();
		foreach($data['schedule_list'] as $token)
		{
			$checkColor = "";
			if($token['schedule_type'] == "online"){ $checkColor = $onlineColour; }
			if($token['schedule_type'] == "online"){ $checkColor = $offlineColour; }
			$linkURL = base_url('ld_programs/course_calendar_details/'.$token['id']);
			$data['calendar_result'][] = [ 
				'title' => $token['course_name'],
				'start' => $token['start_time'],
				'end' => $token['end_time'],
				'allDay' =>  false,
				'url' => $linkURL,
				'backgroundColor' => $checkColor
			];
		}
		
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_course_calendar.php";
		$data["content_js"] = "ld_programs/ld_programs_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function course_calendar_details()
	{
		error_reporting(0);
		$availID = "0"; $extraFilter = "";
		if(!empty($this->input->get('cid'))){		
			$availID = $this->input->get('cid');
		}
		if(!empty($this->uri->segment(3))){		
			$availID = $this->uri->segment(3);			
		}
		
		$details = $this->Ld_programs_model->info_schedule_list($availID);		
			
		$trStyle = ' style=""';
		$thStyle = ' style="font-weight:800;text-align:right"';
		$tdStyle = ' style="padding-left:30px"';
		
		$t_Status = '<span style="color:green"><b>Offline</b></span>';
		
		if($details[0]['schedule_type'] == "online"){ $t_Status = '<span style="color:blue"><b>Online</b></span>'; }
		if($details[0]['schedule_type'] == "offline"){ $t_Status = '<span style="color:green"><b>Offline</b></span>'; }
		
		echo '<div style="background-color: #f7f7f7;padding: 32px 20px;">';
		echo'<table>';
		foreach($details as $key=>$rows){
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Course Name</th>';
			echo'<td '.$tdStyle.'>'.$rows['course_name'].'</td>';
			echo'</tr>';
						
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Course Category</th>';
			echo'<td '.$tdStyle.'>'.$rows['category_name'].'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Schedule Date</th>';
			echo'<td '.$tdStyle.'>'.date('d F, Y', strtotime($rows['schedule_date'])).'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Start Time</th>';
			echo'<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['start_time'])).'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>End Time</th>';
			echo'<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['end_time'])).'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Schedule Info</th>';
			echo'<td '.$tdStyle.'>'.$rows['schedule_info'].'</td>';
			echo'</tr>';			

		}
		echo'</table>';
		echo'<hr/>';
		
		echo'<table>';
		echo'<tr '.$trStyle.'>';
		echo'<th '.$thStyle.'>Schedule Status</th>';
		echo'<td '.$tdStyle.'>'.$t_Status.'</td>';
		echo'</tr>';
		echo'</table>';
		
		echo'<hr/>';
		echo '</div>';
		
		$data['course_id'] = $course_id  = $details[0]['course_id'];		
		$data['course_info'] = $this->Ld_programs_model->info_programs_list($course_id);
		$data['course_category'] = $this->Ld_programs_model->info_course_category_list();
		
		$this->load->view('ld_programs/ld_course_details_view',$data);
	}
	
	public function add_course_schedule()
	{
		if(check_logged_in())
		{						
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			
			$log = get_logs();
			$batch_type = '1';
						
			$schedule_id  = trim($this->input->post('schedule_id'));
			$course_id  = trim($this->input->post('course_id'));
			$schedule_type  = trim($this->input->post('schedule_type'));
			$schedule_info  = trim($this->input->post('schedule_info'));
			$schedule_date  = date('Y-m-d', strtotime($this->input->post('schedule_date')));
			$schedule_start_time  = date('Y-m-d H:i:s', strtotime($this->input->post('schedule_start_time')));			
			$schedule_end_time  = date('Y-m-d H:i:s', strtotime($this->input->post('schedule_end_time')));
					
			$field_array = array(
				"schedule_date"   => $schedule_date,
				"course_id"   => $course_id,
				"schedule_type"   => $schedule_type,
				"start_time"   => $schedule_start_time,
				"end_time"   => $schedule_end_time,
				"schedule_info"   => $schedule_info,
				"is_active"   => 1,
				"logs"   => get_logs()
			);
			if(empty($schedule_id)){
				$field_array += [ "added_by" => $current_user ];
				$field_array += [ "date_added" => $curDateTime ];
				$insert_train = data_inserter('ld_programs_schedule',$field_array);	
			} else {
				$this->db->where('id', $schedule_id);
				$this->db->update('ld_programs_schedule', $field_array);
			}			
								
		}		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	public function course_schedule_info_ajax()
	{
		if(check_logged_in())
		{						
			$category_id  = trim($this->input->get('eid'));
			$queryDetails = array();
			if(!empty($category_id)){
				$sqlDetails = "SELECT s.*, p.course_name from ld_programs_schedule as s LEFT JOIN ld_programs as p ON p.id = s.course_id WHERE s.id = '$category_id'";
				$queryDetails = $this->Common_model->get_query_row_array($sqlDetails);
			}
			echo json_encode($queryDetails);
		}
	}
	
	public function delete_course_schedule()
	{
		if(check_logged_in())
		{						
			$category_id  = trim($this->input->get('did'));
			$dataArray = [ 'is_active' => 0 ];
			$this->db->where('id', $category_id);
			$this->db->update('ld_programs_schedule', $dataArray);
		}
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	
//================= LD REGISTRATIONS ================================================================//
	
	public function generate_registration_id()
	{
		$sql = "SELECT count(*) as value from ld_programs_registrations ORDER by id DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		//mt_rand(11,99) 
		$new_crm_id = "LDREG" .sprintf('%06d', $lastid + 1);
		return $new_crm_id;
	}
	
	public function new_registration()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
				
		$data['agent_details'] = $this->Ld_programs_model->info_agent_details($current_user);
		
		$data['crmid'] = $this->generate_registration_id();
		$data['currentDate'] = $currentDate = CurrDate();	

		$data['course_list'] = $this->Ld_programs_model->info_programs_list();
		$data['office_list'] = $this->Ld_programs_model->info_office_list();
		$data['site_list'] = $this->Ld_programs_model->info_site_list();
		$data['role_list'] = $this->Ld_programs_model->info_role_list(0);
		$data['department_list'] = $this->Ld_programs_model->info_department_list();
		//$data['supervisor_list'] = $this->info_supervisor_list();
		
		$data['infoSubmission'] = 0;
		$data['infoSubmissionDetails'] = array();
		
		
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_registration_new.php";				
		$data["content_js"] = "ld_programs/ld_programs_js.php";				
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function submit_registration_info()
	{
		$current_user = get_user_id();
		$registration_no = $this->input->post('registration_no');
		$registration_date = $this->input->post('registration_date');
		
		if(empty($registration_no)){
			$registration_no = $this->generate_registration_id();
		}
		if(empty($registration_date)){
			$registration_date = CurrDate();
		}
		
		$user_id           = $current_user;
		$user_office       = $this->input->post('user_office');
		$user_department   = $this->input->post('user_department');
		$user_role         = $this->input->post('user_role');
		$user_site         = $this->input->post('user_site');
		$user_email        = $this->input->post('user_email');
		$supervisor_id     = $this->input->post('supervisor_id');
		$supervisor_name   = $this->input->post('supervisor_name');
		$supervisor_email  = $this->input->post('supervisor_email');
		$course_id         = $this->input->post('course_id');
		
		$case_array = [
			//'registration_date' => $registration_date,
			'user_id' => $user_id,
			'user_office' => $user_office,
			'user_department' => $user_department,
			'user_site' => $user_site,
			'user_role' => $user_role,
			'user_email' => $user_email,
			'supervisor_id' => $supervisor_id,
			'supervisor_name' => $supervisor_name,
			'supervisor_email' => $supervisor_email,
			'course_id' => $course_id,
		];
	
		$sqlcheck = "SELECT count(*) as value from ld_programs_registrations WHERE registration_no = '$registration_no'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{			
			$this->db->where('registration_no', $registration_no);
			$this->db->update('ld_programs_registrations', $case_array);
			$flag = "update";
		} 
		else {
			$case_array += [ 'registration_no' => $registration_no ];
			$case_array += [ 'registration_date' => $registration_date ];
			$case_array += [ 'added_by' => $current_user ];
			$case_array += [ 'date_added' => CurrMySqlDate() ];
			$case_array += [ 'date_added_local' => GetLocalTime() ];
			$case_array += [ 'logs' => get_logs() ];
			data_inserter('ld_programs_registrations', $case_array);			
			$flag = "insert";
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function my_registration_list()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['course_list'] = $this->Ld_programs_model->info_programs_list();
		$data['office_list'] = $this->Ld_programs_model->info_office_list();
		$data['site_list'] = $this->Ld_programs_model->info_site_list();
		$extraFilter = "";

		// FILTER DATE CHECK 
		$from_date = CurrMySqlDate();
		$to_date = CurrMySqlDate();
		if(!empty($this->input->get('search_from_date')))
		{ 
			$from_date = date('Y-m-d',strtotime($this->input->get('search_from_date'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('search_to_date'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
		}
		
		// FILTER EXTRA CHECK
		$search_course_type = $this->input->get('search_course_type');
		if(!empty($search_course_type) && $search_course_type != "ALL")
		{ 
			$extraFilter .= " AND (c.course_id = '$search_course_type') ";
		}
		
		$serach_office = $this->input->get('search_office');
		if(!empty($serach_office) && $serach_office != "ALL")
		{ 
			$extraFilter .= " AND (c.user_office = '$serach_office') ";
		}
		
		$search_site = $this->input->get('search_site');
		if(!empty($search_site) && $search_site != "ALL")
		{ 
			$extraFilter .= " AND (c.user_site = '$search_site') ";
		}
		
		$extraFilter .= " AND c.added_by = '$current_user'";
		
		$data['search_course_type'] = $search_course_type;
		$data['search_office'] = $serach_office;
		$data['search_site'] = $search_site;
		$data['from_date'] = date('Y-m-d',strtotime($from_date));
		$data['to_date'] = date('Y-m-d',strtotime($to_date));
		
		$data['crm_list'] = $querycase = $this->Ld_programs_model->registration_list($extraFilter);
			
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_registration_list.php";
		$data["content_js"] = "ld_programs/ld_list_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function registration_list()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['course_list'] = $this->Ld_programs_model->info_programs_list();
		$data['office_list'] = $this->Ld_programs_model->info_office_list();
		$data['site_list'] = $this->Ld_programs_model->info_site_list();
		$extraFilter = "";

		// FILTER DATE CHECK 
		$from_date = CurrMySqlDate();
		$to_date = CurrMySqlDate();
		if(!empty($this->input->get('search_from_date')))
		{ 
			$from_date = date('Y-m-d',strtotime($this->input->get('search_from_date'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('search_to_date'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
		}
		
		// FILTER EXTRA CHECK
		$search_course_type = $this->input->get('search_course_type');
		if(!empty($search_course_type) && $search_course_type != "ALL")
		{ 
			$extraFilter .= " AND (c.course_id = '$search_course_type') ";
		}
		
		$serach_office = $this->input->get('search_office');
		if(!empty($serach_office) && $serach_office != "ALL")
		{ 
			$extraFilter .= " AND (c.user_office = '$serach_office') ";
		}
		
		$search_site = $this->input->get('search_site');
		if(!empty($search_site) && $search_site != "ALL")
		{ 
			$extraFilter .= " AND (c.user_site = '$search_site') ";
		}
				
		$data['search_course_type'] = $search_course_type;
		$data['search_office'] = $serach_office;
		$data['search_site'] = $search_site;
		$data['from_date'] = date('Y-m-d',strtotime($from_date));
		$data['to_date'] = date('Y-m-d',strtotime($to_date));
		
		$data['crm_list'] = $querycase = $this->Ld_programs_model->registration_list($extraFilter);
			
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_registration_list.php";
		$data["content_js"] = "ld_programs/ld_list_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function registration_report()
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
		
		$data['course_list'] = $this->Ld_programs_model->info_programs_list();
		$data['office_list'] = $this->Ld_programs_model->info_office_list();
		$data['site_list'] = $this->Ld_programs_model->info_site_list();
		
		$data["aside_template"] = "ld_programs/aside.php";
		$data["content_template"] = "ld_programs/ld_registration_report.php";
		$data["content_js"] = "ld_programs/ld_list_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	///===================== EXCEL REPORT =================================//
	
	public function generate_registration_reports($from_date ='', $to_date='', $call_type='')
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
		if(!empty($this->input->get('start'))){ 
			$from_date = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
		}
		
		// FILTER EXTRA CHECK
		$search_course_type = $this->input->get('search_course_type');
		if(!empty($search_course_type) && $search_course_type != "ALL"){ 
			$extraFilter .= " AND (c.course_id = '$search_course_type') ";
		}		
		$serach_office = $this->input->get('search_office');
		if(!empty($serach_office) && $serach_office != "ALL"){ 
			$extraFilter .= " AND (c.user_office = '$serach_office') ";
		}
		$search_course_batch = $this->input->get('search_course_batch');
		if(!empty($search_course_batch) && $search_course_batch != "ALL")
		{ 
			$extraFilter .= " AND (c.schedule_id = '$search_course_batch') ";
		}
				
		$crm_list = $this->Ld_programs_model->registration_list($extraFilter);
		
		$title = "GLOBAL L&D Registration LIST";
		$sheet_title = "L&D - Registration Records (" .date('Y-m-d',strtotime($from_date)) ." - " .date('Y-m-d',strtotime($to_date)).")";
		$file_name = "LD_Registration_Records_".date('Y-m-d',strtotime($from_date));
		
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:T1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
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
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Reg No");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Reg Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Employee Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Course");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Site");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Department");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Designation");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office Email");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Supervisor");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Supervisor Email");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date Added");
		
			
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{	
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["registration_no"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["registration_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["agent_name"]);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["course_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["user_site"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["department_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["designation_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["user_email"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["supervisor_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["supervisor_email"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["date_added"]);
			$i++;			
		}
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:S'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
//================== USEFULL FUNCTIONS ===========================================================// 
	 
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
	 
	 public function get_team_id($user){
	   $sql = "SELECT * from signin WHERE assigned_to = '$user'";
	   $query = $this->Common_model->get_query_result_array($sql);
	   $resultIDs = "0";
	   if(!empty($query)){
			$result_col = array_column($query, 'id');
			$resultIDs = implode(',', $result_col);
	   }
	   return $resultIDs;
     }
	 
	 
	 
}