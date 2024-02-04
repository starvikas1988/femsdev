<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kyt_crm extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->load->model('Kyt_model');
		$this->objPHPExcel = new PHPExcel();
	}
	
//==========================================================================================
///=========================== KYT CRM  ================================///
     public function index(){
		redirect(base_url()."kyt_crm/overview");
	 }
	 public function form()
	 {		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt_crm/aside.php";
		 $data["content_template"] = "kyt_crm/demo_class_form.php";
		 
		 $data['urlSection'] = $this->uri->segment(4);
		 $data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		 //$data['allCountries'] = $this->master_countries();
		 $data['level_master'] = $this->Kyt_model->get_level_master_data();	
		 $data['course_master'] = $this->Kyt_model->get_course_master_data();
		 $data['teacher_time_slot'] = $this->Kyt_model->get_teacher_time_slot_list();																				 
		 
		 //echo'<pre>';print_r($data);
		 $data["content_js"] = "kyt_crm/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);
	  
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
			
		}
		
		$extraFilter .= " AND (c.date_of_call >= '$todayStartDate' AND c.date_of_call <= '$todayEndDate') ";
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		// AGENT WISE
		//========================= AGENT WISE =================================//
		$sql_users = "SELECT count(cid) as casecounts, c.added_by, s.fusion_id, s.id, CONCAT(s.fname, ' ', s.lname) as fullname  from contact_tracing_zovio as c 
					  INNER JOIN contact_tracing_zovio_info as i ON i.crm_id = c.crm_id
					  INNER JOIN signin as s ON s.id = c.added_by
					  WHERE 1 $extraFilter
					  GROUP BY c.added_by ORDER by casecounts DESC";
		$query_users = $this->Common_model->get_query_result_array($sql_users);
		$data['agentsArray'] = $query_users;
		
		
		
		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data["aside_template"] = "kyt_crm/aside.php";
		$data["content_template"] = "kyt_crm/kyt_crm_dashboard.php";				
		//$data["content_js"] = "kyt/kyt_overview_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function modify_availability_set()
	 {		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt/ldc_aside.php";
		 $data["content_template"] = "kyt/ldc_add_availability_set.php";
		 $data["content_js"] = "kyt/kyt_modify_js.php";
		 
		 
 
		 $sqlTeacher = "SELECT * from signin_client WHERE role='teacher' AND status = '1'";
		 $data['teachersgroup'] = $this->Common_model->get_query_result_array($sqlTeacher);
		 $data['time_slots']	= $this->Kyt_model->get_slots_list();
		 
		 $this->load->view('dashboard',$data);
	  
	 }
	 
	 public function get_modify_availability_data()
	 {	
		$startDate = date('Y-m-d', strtotime($this->input->get('start')));
		$teacher = $this->input->get('teacher');
		$data['teacher'] = $teacher;
		$data['start_date'] = $startDate;
		
		$sqlDate = "SELECT * from kyt_availability_records WHERE avail_date = '$startDate' AND teacher_id = '$teacher' AND is_active = '1'";
		$data['availData'] = $queryDate = $this->Common_model->get_query_result_array($sqlDate);
		$data['allSlotSet'] = $allDataSet = $this->array_indexed($queryDate, 'avail_slot');
		$data['availableIDs'] = $allDataSet = $this->array_indexed($queryDate, 'avail_slot');
		
		
		// echo "<pre>" .print_r($allDataSet, 1) ."</pre>";
		 
		$slotsSql = "SELECT * from kyt_slots";
		$data['slotData'] = $querySlot = $this->Common_model->get_query_result_array($slotsSql);
		//echo "<pre>" .print_r($querySlot, 1) ."</pre>";
		
		$leaveDate = "SELECT * from kyt_leave_master WHERE '$startDate' >= DATE(from_date) AND '$startDate' <= DATE(from_date) AND employee_id = '$teacher'";
		$data['leaveData'] = $queryDate = $this->Common_model->get_query_result_array($leaveDate);
		
		$this->load->view('kyt/ldc_add_availability_data_set', $data);
		
	 }
	 
	function modify_add_set_availability()
	{
		
		$current_user = get_user_id();
		
		$postData   = $this->input->post();
		$teacher_id  = $this->input->post('teacher_id');		
		$course_id  = $this->input->post('course_id');		
		$from_date = $this->input->post('select_from_date');
		
		$slqID = "SELECT id as value from kyt_availability ORDER BY ID DESC LIMIT 1";
		$lastID = $this->Common_model->get_single_value($slqID);
		
		$slqCourse = "SELECT course_id as value from info_personal_client WHERE user_id = '$teacher_id' ORDER BY ID DESC LIMIT 1";
		$course_id = $this->Common_model->get_single_value($slqCourse);
		
		$timeSlotsArray	= $this->Kyt_model->get_slots_list();
		$timeSlots = $this->array_indexed($timeSlotsArray, 'id');
		
		if(empty($batch_code)){
			$batch_code = strtoupper(date('M')).mt_rand(111,999).sprintf('%04d', $lastID+1);
		}
		
		//echo "<pre>".print_r($postData, 1)."</pre>";
		//die();
		
		$this->db->trans_begin();
		$flag = "ok";
		
		
		
		// AVAILABILITY RECORDS
		$startDate = date('Y-m-d', strtotime($from_date));
		$endDate = date('Y-m-d', strtotime($from_date));			
		$currentDay = $startDate;
		$currentDayName = strtoupper(date('D', strtotime($currentDay)));
		
		$sqlCheck = "UPDATE kyt_availability_records SET is_active = '0' WHERE avail_date = '$startDate' AND avail_day = '$currentDayName' AND teacher_id = '$teacher_id'";
		$queryCheck = $this->db->query($sqlCheck);
		
		if(!empty($postData[$currentDayName]))
		{ 	
			foreach($postData[$currentDayName] as $slotVal){
				if(!empty($slotVal)){
					
					$sqlCheck = "SELECT * from kyt_availability_records WHERE avail_date = '$startDate' AND avail_day = '$currentDayName' AND avail_slot = '$slotVal' AND teacher_id = '$teacher_id'";
					$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
					
					if(!empty($queryCheck)){
						$dataArray = [
							"teacher_id" => $teacher_id, 
							"course_id" => $course_id,
							"is_approved" => 1,
							"is_active" => 1,
						];
						
						$this->db->where('id',$queryCheck[0]['id'] );
						$this->db->update('kyt_availability_records',$dataArray );
						
						
					} else {
						$startTime = $timeSlots[$slotVal]['start_time'];
						$endTime = $timeSlots[$slotVal]['end_time'];
						$slotData = [
							"teacher_id" => $teacher_id, 
							"course_id" => $course_id,
							"avail_date" => $currentDay,
							"avail_day" => $currentDayName,
							"avail_slot" => $slotVal,
							"is_approved" => 1,
							"is_active" => 1,
							"avail_start_time" => $startTime,
							"avail_end_time" => $endTime,
							"avail_timezone" => 'IST',
							"created_by" => $current_user,
							"created_on" => CurrMySqlDate(),
							"ref_code" => $batch_code,
						];
						data_inserter('kyt_availability_records', $slotData);
				  }
				}
			}
		}
		
		
		
		if($flag=="error"){
			$this->db->trans_rollback();
		}
		
		$this->db->trans_complete();
		redirect($_SERVER['HTTP_REFERER']);
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
	 
	 
	 
	 private function days_list()
	 {
		$daysArray = [
			"MON" => "Monday",
			"TUE" => "Tuesday",
			"WED" => "Wednesday",
			"THU" => "Thursday",
			"FRI" => "Friday",
			"SAT" => "Saturday",
			"SUN" => "Sunday",
		];
		return $daysArray;
	 }
	 
	 
	 
	
	 //================================Leave==============================//

	 public function leave()
	 {		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt_crm/aside.php";
		 $data["content_template"] = "kyt_crm/leave.php";
		 
		 $data['urlSection'] = $this->uri->segment(4);
		 $data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		 //$data['allCountries'] = $this->master_countries();
		 if($is_global_access==1){
		 $sql_leave = "Select * from kyt_leave_master";	
		 }
		 else{
			$sql_leave = "Select * from kyt_leave_master where employee_id=".$current_user;
		 }

		 $leave_data = $this->Common_model->get_query_result_array($sql_leave);															 
		 $data['leave_master'] = $leave_data ;
		 
		 $data["content_js"] = "kyt_crm/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);
	  
	 }
	 public function leave_applied(){
		 $frmdate = date('Y-m-d',strtotime($this->input->post('firstDate')));
		 $snddate = ($this->input->post('secondDate')!="")?$this->input->post('secondDate'):$frmdate;
		 $snddate = date('Y-m-d',strtotime( $snddate));
		 $data['employee_id'] = $this->input->post('emp_id');
		 $data['from_date'] = $frmdate;
		 $data['to_date'] = $snddate;
		 $data['no_of_days'] = $this->input->post('no_of_days');
		 $data['reason'] = $this->input->post('reason');
		 $data['contact_details'] = $this->input->post('contact_details');
		 $this->db->insert('kyt_leave_master',$data);
		 $insert_id = $this->db->insert_id();
		 $this->session->set_flashdata('response',"Information Inserted Successfully");
		 redirect('kyt_crm/leave'); 

	 }
	 public function change_leave_status(){
		 $id = $this->input->post('id');
		 $status = $this->input->post('status');
		 $this->db->set('status', $status, true);
		 $this->db->where('id', $id);
         $this->db->update('kyt_leave_master');
		 echo $status;
	 }
	 public function leave_master_csv(){
		$filename = 'kyt_leave_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$header = array("Employee Name","From Date","To Date","No Of Days","Reason","Contact Details","Status"); 
		$id = $this->input->get('id');
		if($id!=""){
			$sql_lev = "select k.*,(select CONCAT(s.fname,s.lname) as fullname from signin s where s.id =k.employee_id) from  kyt_leave_master k where employee_id=".$id;
		}
		else
		{
			$sql_lev = "select k.*,(select CONCAT(s.fname,s.lname) as fullname from signin s where s.id =k.employee_id) from  kyt_leave_master k ";
		}
		$summary =  $this->Common_model->get_query_result_array($sql_lev);
		$file = fopen('php://output', 'w');
			fputcsv($file, $header);

			foreach($summary as $key => $val){
					$body = array();
					$status =($val['status']=='disapproved')?'Rejected':$val['status'];
					$body[]=$val['employee_id'];
					$body[]=date('Y-m-d',strtotime($val['from_date']));
					$body[]=date('Y-m-d',strtotime($val['to_date']));
					$body[]=$val['no_of_days'];
					$body[]=$val['reason'];
					$body[]=$val['contact_details'];
					$body[]=ucwords($status);
					fputcsv($file, $body);		
				}

			fclose($file); 
			exit; 
	 }
	 //================================Availability==========================//	
	 public function availability()
	 {		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt_crm/aside.php";
		 $data["content_template"] = "kyt_crm/availability.php";
		 
		 $data['urlSection'] = $this->uri->segment(4);
		 $data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		 $con="";
		 if($_GET['date_from']!=""){
			$con.= "and a.from_date>='".date('Y-m-d',strtotime($_GET['date_from']))."'";
		 }
		 if($_GET['date_to']!=""){
			$con.= "and a.to_date<='".date('Y-m-d',strtotime($_GET['date_to']))."'";
		 }
		  $sql= "SELECT k.*,a.*,(SELECT name FROM `kyt_course_master` c where c.id=a.course_id) as course_name  
		 		from signin_client k left join `kyt_teacher_availability` a on a.teacher_id=k.id 
				WHERE k.role='teacher' AND k.status = '1' AND k.allow_kyt = '1' $con group by(`group_id`)";
		 $data['teacher_list']	= $this->Kyt_model->get_teacher_list_for_availiable($sql);	
		 //$data['allCountries'] = $this->master_countries();						

		 
		 
		 $data["content_js"] = "kyt_crm/kyt_list_js.php";
		 $this->load->view('dashboard',$data);
	  
	 }

	 //================================My Calendar==========================//	
	 public function my_calendar()
	 {		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt_crm/aside.php";
		 $data["content_template"] = "kyt_crm/my_calender.php";
		 
		 $data['urlSection'] = $this->uri->segment(4);
		 $data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		 //$data['allCountries'] = $this->master_countries();						
		 $data['result'] = $this->db->get("events")->result();
   
		 foreach ($data['result'] as $key => $value) {
			 $data['data'][$key]['title'] = $value->title;
			 $data['data'][$key]['start'] = $value->start_date;
			 $data['data'][$key]['end'] = $value->end_date;
			 $data['data'][$key]['backgroundColor'] = "#00a65a";
		 }															 
		 
		 
		 //$data["content_js"] = "kyt_crm/my_calender.php";
		 $this->load->view('dashboard',$data);
	  
	 }

	 //================================My Calendar==========================//	
	 public function demo_class_report()
	 {		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt_crm/aside.php";
		 $data["content_template"] = "kyt_crm/demo_class_report.php";
		 
		 $data['urlSection'] = $this->uri->segment(4);
		 $data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		 //$data['allCountries'] = $this->master_countries();						
																	 
		 
		 
		 $data["content_js"] = "kyt_crm/kyt_list_js.php";
		 $this->load->view('dashboard',$data);
	  
	 }

	 public function insert(){
		 //echo'<pre>';print_r($_POST);
		 $current_user = get_user_id();
		$data_ins = array(
			"parent_name" => $this->input->post('parent_name'),
			"phone_number" => $this->input->post('phone_number'),
			"alt_phone_number" => $this->input->post('alt_phone_number'),
			"email" => $this->input->post('email'),
			"alt_email" => $this->input->post('alt_email'),
			"city" => $this->input->post('city'),
			"state" => $this->input->post('state'),
			"country" => $this->input->post('country'),
			"demo_date" => $this->input->post('demo_date'),
			"Slots_time" => $this->input->post('Slots_time'),
			"time_zone" => $this->input->post('time_zone'),
			"kids_name" => $this->input->post('kids_name'),
			"age" => $this->input->post('age'),
			"course" => $this->input->post('course'),
			"levels" => $this->input->post('levels'),
			"laptop" => $this->input->post('laptop'),
			"camera" => $this->input->post('camera'),
			"smart_phone" => $this->input->post('smart_phone'),
			"internet" => $this->input->post('internet'),
			"browser_update" => $this->input->post('browser_update'),
			"parent_presence" => $this->input->post('parent_presence'),
			"cl_comments" => $this->input->post('cl_comments'),
			"created_by"=> $current_user,
		);

		$this->db->insert('kyt_demo_class', $data_ins);
		$this->session->set_flashdata('response',"Information Inserted Successfully");
		redirect('kyt_crm/form');

	 }
	 function add_edit_availability(){
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 $teacherid = $this->input->get('id');
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt_crm/aside.php";
		 $data["content_template"] = "kyt_crm/add_edit_availability.php";
		 
		 $data['urlSection'] = $this->uri->segment(4);
		 $data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		 //$data['allCountries'] = $this->master_countries();
		 $data['level_master']  = $this->Kyt_model->get_level_master_data();	
		 $data['course_master'] = $this->Kyt_model->get_course_master_data();
		 $data['time_slots']	= $this->Kyt_model->get_teacher_time_slot_list();
		 $data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherid);
		 			
																	 
		 $data["content_js"] = "kyt_crm/kyt_list_js.php";
		 $this->load->view('dashboard',$data);
	}
	public function generate_crm_reports($from_date ='', $to_date='')
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
		$qstdate = date('d/m/Y',strtotime($this->input->get('start')));
		$qeddate = date('d/m/Y',strtotime($this->input->get('end')));
		$sqlcase = "SELECT *,(select name from `kyt_course_master` where id = p.course) as course_name,(select name from `kyt_level_master` where id = p.levels) as level_name from kyt_demo_class p where demo_date between '".$qstdate."' and '".$qeddate."'";
		$crm_list = $this->Common_model->get_query_result_array($sqlcase);

		$title = "KYT";
		$sheet_title = "KYT - Demo_Class (" .date('Y-m-d',strtotime($startDate))." - " .date('Y-m-d',strtotime($endDate)).")";
		$file_name = "KYT_Records_(" .date('Y-m-d',strtotime($startDate))." - " .date('Y-m-d',strtotime($endDate)).")";
		
		//==================================  generate CSV file code start ==============================================//
		
		    $filename = $file_name.'.csv'; 
   			header("Content-Description: File Transfer"); 
   			header("Content-Disposition: attachment; filename=$filename"); 
   			header("Content-Type: application/csv; ");
		    $header = array("SL","Parent Name","Phone Number","Alternative Phone Number","Email","Alternative Email","City",
							"State","Country","Demo Class Date","Slot Time","Time Zone","Kids Name","Age","Course","Level",
							"Comment","Laptop/Desktop","Microphone & Camera","Smart Phone","Internet Connection","Browser Update","Parent Presence");

			
			$file = fopen('php://output', 'w');
   			fputcsv($file, $header);
				$i=0;
			   foreach($crm_list as $key => $val){
					$body=array();$i++;
					$body[] = $i;
					$body[] = $val["parent_name"];
					$body[] = $val["phone_number"];
					$body[] = $val["alt_phone_number"];
					$body[] = $val["email"];
					$body[] = $val["alt_email"];
					$body[] = $val["city"];
					$body[] = $val["state"];
					$body[] = $val["country"];
					$body[] = $val["demo_date"];
					$body[] = $val["Slots_time"];
					$body[] = $val["time_zone"];
					//$body[] = $val["c_fname"] ." " .$val["c_lname"];
					$body[] = $val["kids_name"];
					$body[] = $val["age"];
					$body[] = $val["course_name"];
					$body[] = $val["level_name"];
					$body[] = $val["cl_comments"];
					$body[] = $val["laptop"];
					$body[] = $val["camera"];
					$body[] = $val["smart_phone"];
					$body[] = $val["internet"];
					$body[] = $val["browser_update"];
					$body[] = $val["parent_presence"];
					fputcsv($file, $body);	
			   }
				
			fclose($file); 
   			exit; 
		//==================================  generate CSV file code End ==============================================//		
		
	}
	public function insert_avaliability(){
		$total_no_day = $d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
		$current_date = date('Y-m-d');
		$cd = date('d');
		$current_user = get_user_id();
		$course_id    = $this->input->post('course_id');
		$mon		  = $this->input->post('mon');
		$tue		  = $this->input->post('tue');
		$wed		  = $this->input->post('wed');
		$thur		  = $this->input->post('thur');
		$fri		  = $this->input->post('fri');
		$sat		  = $this->input->post('sat');
		$sun		  = $this->input->post('sun'); 
		$teacherid    = $this->input->post('teacher_id');
		$f            = $this->input->post('select_from_date');
		$t            = $this->input->post('select_to_date');
		$frm_date = date('Y-m-d', strtotime($f));
		$to_date = date('Y-m-d', strtotime($t));
		 $datediff = round(($to_date-$frm_date) / (60 * 60 * 24));
		 $groupid =  date('M').rand(pow(10, 3-1), pow(10, 3)-1);
		

		$dd1 = explode('/',$this->input->post('date_one'));
		$dd2 = explode('/',$this->input->post('date_two'));
		$dd3 = explode('/',$this->input->post('date_three'));
		$dd4 = explode('/',$this->input->post('date_four'));

		$lv1		  = $dd1['2'].'-'.$dd1['1'].'-'.$dd1['0'];
		$lv2		  = $dd2['2'].'-'.$dd2['1'].'-'.$dd2['0'];
		$lv3		  = $dd3['2'].'-'.$dd3['1'].'-'.$dd3['0'];
		$lv4		  = $dd4['2'].'-'.$dd4['1'].'-'.$dd4['0'];
		$darr         = array($lv1,$lv2,$lv3,$lv4);
		//echo'<pre>'.print_r($this->input->post(), 1) ."</pre>";
		$dateone = $this->input->post('date_one');
		//echo date('Y-m-d', strtotime($dateone));
		

		$postData = $this->input->post();

		// AVAILABILITY
		$dayArray = array("MON", "TUE","WED","THU","FRI","SAT","SUN");
		foreach($dayArray as $k=>$rows){
			if(!empty($postData[strtolower($rows)])){
				//echo "hi"; die();
				$slotTimes = implode(',', $postData[strtolower($rows)]); 

				$query = $this->db->query("SELECT * FROM kyt_teacher_availability where `teacher_id`=$teacherid and course_id=$course_id and from_date='".$frm_date."' and to_date ='".$to_date."'");
				$numrows =  $query->num_rows();

				$dataArray = [
					"teacher_id"=>$teacherid, 
					"course_id"=>$course_id,
					//"level_id"=>
					"day"=>$rows,
					"time_zone"=>'IST',
					"time_slots"=>$slotTimes,
					"from_date"=>date('Y-m-d', strtotime($f)),
					"to_date"=>date('Y-m-d', strtotime($t)),
					"group_id"=>$groupid
				];
				//print_r($dataArray);
				if($numrows==0){
					data_inserter('kyt_teacher_availability', $dataArray);
				}
				else{
					$qrs = $query->result_array();
					foreach($qrs as $q=>$rr){
						$rr['id'];
						$this->db->where('id', $rr['id']);
						$this->db->delete('kyt_teacher_availability');
						$this->db->where('group_id', $rr['group_id']);
						$this->db->delete('kyt_leave_master');
						
					}	
					data_inserter('kyt_teacher_availability', $dataArray);

				}



			}
		}
		

		$dayArray = array("date_one", "date_two","date_three","date_four");
		foreach($dayArray as $k=>$rows){
			if(!empty($postData[$rows])){
				$postDate = $postData[$rows];
				$currDate = date('Y-m-d', strtotime($postDate));
				$dataArray = [
					"employee_id"=>$teacherid, 
					//"level_id"=>
					"from_date"=>$currDate,
					"to_date"=>$currDate,
					"no_of_days"=>'1',
					"reason"=>'OFF',
					"contact_details"=>'',
					"applied_from"=>'availability',
					"group_id"=>$groupid
				];
				//print_r($dataArray);
				data_inserter('kyt_leave_master', $dataArray);
			}
		}
		
		

		// LEAVE


		/*for($i=1;$i<=$total_no_day;$i++){
			if($cd<=$i){
				$dt = date('Y-m').'-'.$i;
				if($frm_date<=$dt&&$to_date>=$dt){
				if(!in_array($dt,$darr)){
					if(date('D',strtotime($dt))=='mon'){
						
					}
				}
			}
			}	
		}*/
		redirect('kyt_crm/availability');
	}
	 //================================My Calendar==========================//	
	public function time_slots_master(){
		$current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt_crm/aside.php";
		 $data["content_template"] = "kyt_crm/time_slots_form.php";
		 
		 $data['urlSection'] = $this->uri->segment(4);
		 $data['mysections'] = array('personal', 'case', 'condition', 'exposure', 'final');
		 //$data['allCountries'] = $this->master_countries();
		 $data['level_master'] = $this->Kyt_model->get_level_master_data();	
		 $data['course_master'] = $this->Kyt_model->get_course_master_data();
		 $data['teacher_time_slot'] = $this->Kyt_model->get_teacher_time_slot_list();																				 
		 
		 //echo'<pre>';print_r($data);
		 $data["content_js"] = "kyt_crm/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);
	}
	public function generate_available_reports($from_date ='', $to_date='')
	{
		
		$qstdate = date('d/m/Y',strtotime($this->input->get('date_from')));
		$qeddate = date('d/m/Y',strtotime($this->input->get('date_to')));
		$con="";
		 if($_GET['date_from']!=""){
			$con.= "and a.from_date>='".date('Y-m-d',strtotime($_GET['date_from']))."'";
		 }
		 if($_GET['date_to']!=""){
			$con.= "and a.to_date<='".date('Y-m-d',strtotime($_GET['date_to']))."'";
		 }

		$sqlcase = "SELECT k.*,a.*,(SELECT name FROM `kyt_course_master` c where c.id=a.course_id) as course_name  
		from signin_client k left join `kyt_teacher_availability` a on a.teacher_id=k.id 
	   WHERE k.role='teacher' AND k.status = '1' AND k.allow_kyt = '1' $con";
		$crm_list = $this->Common_model->get_query_result_array($sqlcase);

		$title = "KYT";
		$sheet_title = "KYT - Available_teachers";
		$file_name = "KYT_Available_Teachers";
		
		//==================================  generate CSV file code start ==============================================//
		
		    $filename = $file_name.'.csv'; 
   			header("Content-Description: File Transfer"); 
   			header("Content-Disposition: attachment; filename=$filename"); 
   			header("Content-Type: application/csv; ");
		    $header = array("Teacher Name","Sex","Email address","Course","Day","Time Slots");

			
			$file = fopen('php://output', 'w');
   			fputcsv($file, $header);
				$i=0;
			   foreach($crm_list as $key => $val){
					$body=array();
					$body[] = $val["fname"].' '.$val['lname'];
					$body[] = $val["sex"];
					$body[] = $val["email_id"];
					$body[] = $val["course_name"];
					$body[] = $val["day"];
					$body[] = $val["time_slots"];
					fputcsv($file, $body);	
			   }
				
			fclose($file); 
   			exit; 
		//==================================  generate CSV file code End ==============================================//		
		
	}

	private function get_leave_dates($teacherID = '', $type = 'all')
	{
		$extraFilter = "";
		$overallDates = array();
		$leaveDates = array();
		$offDates = array();
		if(!empty($teacherID)){
			$extraFilter = " AND employee_id = '$teacherID' ";
		}
		$leave_sql = "SELECT * from kyt_leave_master WHERE 1 $extraFilter AND applied_from = 'leave'";
		$leaveData = $this->Common_model->get_query_result_array($leave_sql);
		foreach($leaveData as $token)
		{
			$employeeID = $token['employee_id'];
			$fromDate = $token['from_date'];
			$toDate = $token['to_date'];
			if(strtotime($toDate) >= strtotime($fromDate))
			{
				$currentDay = $fromDate; $counter = 0;
				while(strtotime($currentDay) <= strtotime($toDate))
				{
					$leaveDates[$employeeID][] = $currentDay;
					$overallDates[$employeeID][] = $currentDay;
					$counter++;
					$currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
					if($counter > 150){
						show_error('Something is Wrong!');
					}
				}
			}
		}
		
		$off_sql = "SELECT * from kyt_leave_master WHERE 1 $extraFilter AND applied_from = 'availability'";
		$offData = $this->Common_model->get_query_result_array($off_sql);
		foreach($offData as $token)
		{
			$employeeID = $token['employee_id'];
			$fromDate = $token['from_date'];
			$toDate = $token['to_date'];
			$offDates[$employeeID][] = $fromDate;
			$overallDates[$employeeID][] = $fromDate;
		}
		
		$resultArray = array();
		$resultArray['leave']['data'] = $leaveData;
		$resultArray['leave']['dates'] = $leaveDates;
		$resultArray['off']['data'] = $offData;
		$resultArray['off']['dates'] = $offDates;
		$resultArray['overall'] = $overallDates;
		
		return $resultArray;
	}
	public function mail_calendar(){

	$dtstartdate = date('Ymd').'T'.date('His')."Z\n"; 
	$createddate = date('Ymd').'T'.date('His')."Z\n"; 
	$dtend = date('Ymd').'T'.date('His')."Z\n"; 
	$lmodifydate = date('Ymd').'T'.date('His')."Z\n"; 
	$location = "KYT ACADEMY";
	$teacher= "SOUVIK BANNERJEE";


	/***************************************end setting section *********************************/

	$v="BEGIN:VCALENDAR\n";
	$v.="PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n";
	$v.="VERSION:2.0\n";
	$v.="METHOD:PUBLISH\n";
	$v.="X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n";
	$v.="BEGIN:VEVENT\n";
	$v.="CLASS:PUBLIC\n";
	$v.="CREATED:$createddate\n";
	
	$v.="DESCRIPTION:teacher: $teacher\n";
	$v.="DTEND:$dtend\n";
	$v.="DTSTAMP:$createddate\n";
	$v.="DTSTART:$dtstartdate\n";
	$v.="LAST-MODIFIED:$lmodifydate\n";
	$v.="LOCATION:$location\n";
	$v.="PRIORITY:5\n";
	$v.="SEQUENCE:0\n";
	$v.="SUMMARY;LANGUAGE=en-us:KYT ACADEMY\n";
	$v.="TRANSP:OPAQUE\n";
	$v.="UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000\n";
	$v.="X-MICROSOFT-CDO-BUSYSTATUS:BUSY\n";
	$v.="X-MICROSOFT-CDO-IMPORTANCE:1\n";
	$v.="X-MICROSOFT-DISALLOW-COUNTER:FALSE\n";
	$v.="X-MS-OLK-ALLOWEXTERNCHECK:TRUE\n";
	$v.="X-MS-OLK-AUTOFILLLOCATION:FALSE\n";
	$v.="X-MS-OLK-CONFTYPE:0\n";
	//Here is to set the reminder for the event.
	$v.="BEGIN:VALARM\n";
	$v.="TRIGGER:-PT1440M\n";
	$v.="ACTION:DISPLAY\n";
	$v.="DESCRIPTION:Reminder\n";
	$v.="END:VALARM\n";
	$v.="END:VEVENT\n";
	$v.="END:VCALENDAR\n";
	
	$fp = fopen('/opt/lampp/htdocs/femsdev/uploads/kyt_calendar/calendar.ics', 'w');
	fwrite($fp, $v);
	fclose($fp);

    $this->load->library('email');
	//$this->email->initialize($config);
	$this->email->clear(TRUE);
	$this->email->set_newline("\r\n");

	
	$message= "   
	Dear Teacher,<br><br>";
	$message.="Kindly add this event to your calendar for meeting alerts in your google email.<br><br> <b>Regards</b>&nbsp' KYT Academy <br><h<br>
	";

	 	$this->email->from("noreply.fems@fusionbposervices.com", 'Fusion FEMS');
        //$this->email->to('sachinkrpaswan17@gmail.com'); 
		$this->email->to('souvikjaantje@gmail.com'); 

        $this->email->subject('Email Test');
        $this->email->message($message);  
		$this->email->attach('/opt/lampp/htdocs/femsdev/uploads/kyt_calendar/calendar.ics');

        $this->email->send();	
		
	}

	public function calendar_availability_details(){

		//start time
		//endtime
		//date

		// availbility with schedule
		//leave date filter

		//ifshedule
		//schedule

		//noschedule
		//available 

		$date = $this->input->get('date');
		$startTime = $this->input->get('startTime');
		$endTime = $this->input->get('endTime');

		$sql=" SELECT s.*,su.session_type as session_type,su.age_group as age_group,
						su.child_name as child_name,concat(t.fname,' ',t.lname) as teacher_name 
	 				FROM `kyt_availability_records` s 
	 				left join signin_client t on s.teacher_id =t.id 
	 				left join kyt_schedule_upload su on s.schedule_id = su.id 
	 				WHERE s.avail_date='".$date."' and s.avail_start_time='".$startTime."' and s.avail_end_time='".$endTime."'";
		     $details = $this->Common_model->get_query_result_array($sql);

		// $leaves = $this->get_leave_dates($id, $type = 'all');
		//$total_leave = $leaves['overall'][$id];

		echo'<table>';
		foreach($details as $key=>$rows)
		{
			echo'<tr>';
			echo'<th>Teacher Name</th>';
			echo'<th>Availability Date</th>';
			echo'<th>Availability Day</th>';
			echo'<th>Start Time</th>';
			echo'<th>End Time</th>';
			echo'<th>Time Zone</th>';
			if($rows['schedule_id']!=''){
			echo'<th>Session Type </th>';
			echo'<th>Age Group </th>';
			echo'<th>Child Name</th>';
			}
			echo'</tr>';
			echo'<tr>';
			echo'<td>'.$rows['teacher_name'].'</td>';
			echo'<td>'.$rows['avail_date'].'</td>';
			echo'<td>'.$rows['avail_day'].'</td>';
			echo'<td>'.$rows['avail_start_time'].'</td>';
			echo'<td>'.$rows['avail_end_time'].'</td>';
			echo'<td>'.$rows['avail_timezone'].'</td>';
			if($rows['schedule_id']!=''){
			echo'<td>'.$rows['session_type'].' </td>';
			echo'<td>'.$rows['age_group'].'</td>';
			echo'<td>'.$rows['child_name'].'</td>';
			}
			echo'</tr>';

		

		}
		echo'</table>';
	}
	public function teacher_availability_details(){

		//avaialibity id
		//table details
		//shdule info if available

		$id = $this->input->get('id');
		 $sql1 =" SELECT t.*,su.session_type as session_type,su.age_group as age_group,su.child_name as child_name,concat(c.fname,' ',c.lname)as teacher_name,cr.name as course_name  
					FROM `kyt_availability_records` t 
					left join signin_client c on t.teacher_id=c.id 
					left join  kyt_course_master cr on t.course_id = cr.id 
					left join  kyt_schedule_upload su on t.schedule_id = su.id
				WHERE t.id = '".$id ."'";

		$details = $this->Common_model->get_query_result_array($sql1);
		//echo'<pre>';print_r($details);
		///$leaves = $this->get_leave_dates($id, $type = 'all');
		//$total_leave = $leaves['overall'][$id];
		echo'<table>';
		foreach($details as $key=>$rows){
			//if(!in_array($rows['avail_date'],$total_leave)){
				if($rows['schedule_id']!=''){
					echo'<tr>';
					echo'<th>Teacher Name</th>';
					echo'<th>Course Name</th>';
					echo'<th>Availability Date</th>';
					echo'<th>Availability Day</th>';
					echo'<th>Start Time</th>';
					echo'<th>End Time</th>';
					echo'<th>Time Zone</th>';
					echo'<th>Session_type</th>';
					echo'<th>Age Group</th>';
					echo'<th>Child Name</th>';
					echo'</tr>';
					echo'<tr>';
					echo'<td>'.$rows['teacher_name'].'</td>';
					echo'<td>'.$rows['course_name'].'</td>';
					echo'<td>'.$rows['avail_date'].'</td>';
					echo'<td>'.$rows['avail_day'].'</td>';
					echo'<td>'.$rows['avail_start_time'].'</td>';
					echo'<td>'.$rows['avail_end_time'].'</td>';
					echo'<td>'.$rows['avail_timezone'].'</td>';
					echo'<td>'.$rows['session_type'].'</td>';
					echo'<td>'.$rows['age_group'].'</td>';
					echo'<td>'.$rows['child_name'].'</td>';
					echo'</tr>';
				}
				else{

					echo'<tr>';
					echo'<th>Teacher Name</th>';
					echo'<th>Course Name</th>';
					echo'<th>Availability Date</th>';
					echo'<th>Availability Day</th>';
					echo'<th>Start Time</th>';
					echo'<th>End Time</th>';
					echo'<th>Time Zone</th>';
					echo'<th>Teacher Name</th>';
					echo'</tr>';
					echo'<tr>';
					echo'<td>'.$rows['teacher_name'].'</td>';
					echo'<td>'.$rows['course_name'].'</td>';
					echo'<td>'.$rows['avail_date'].'</td>';
					echo'<td>'.$rows['avail_day'].'</td>';
					echo'<td>'.$rows['avail_start_time'].'</td>';
					echo'<td>'.$rows['avail_end_time'].'</td>';
					echo'<td>'.$rows['avail_timezone'].'</td>';
					echo'</tr>';

				}
			//}

		}
		echo'</table>';
	}
	
}