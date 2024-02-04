<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kyt extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->model('Client_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->load->model('Kyt_model');
		$this->objPHPExcel = new PHPExcel();
	}
	
//==========================================================================================
///  KYT ACADEMY CRM  
//==========================================================================================

     public function index(){
		redirect(base_url()."kyt/overview");
	 }
	 
	 
    //==========================================================================================
	///  OVERVIEW & ANALYTICS 
	//==========================================================================================
	
	public function overview()
	{
		$current_user   = get_user_id();
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
			
		$extraAFilter = ""; $extraFilter = ""; $extraTotal = ""; 
		$maxDay = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 
		$todayStartDate = date('Y-m-01', strtotime(CurrDate())); 
		$todayEndDate = date('Y-m-'.$maxDay, strtotime(CurrDate()));		
		if(!empty($this->input->get('start')))
		{ 
			$todayStartDate = date('Y-m-d',strtotime($this->input->get('start')));
			$todayEndDate = date('Y-m-d',strtotime($this->input->get('end')));			
		}	
		if(get_role() == 'teacher')
		{
			$extraFilter .= " AND c.teacher_id = '$current_user'";
			$extraAFilter .= " AND c.teacher_id = '$current_user'";
		}		
		$extraFilter .= " AND (c.schedule_date >= '$todayStartDate' AND c.schedule_date <= '$todayEndDate') ";
		$extraAFilter .= " AND (c.avail_date >= '$todayStartDate' AND c.avail_date <= '$todayEndDate') ";
			
		
		$sql = "SELECT count(*) as value from kyt_schedule_upload as c WHERE 1 $extraFilter";
		$data['todays_records'] = $todays_records = $this->Common_model->get_single_value($sql);
		
		$sql = "SELECT count(*) as value from signin_client as c WHERE role='teacher' AND allow_kyt = '1' AND status = '1'";
		$data['total_records'] = $total_records = $this->Common_model->get_single_value($sql);
		
		$sql = "SELECT count(c.id) as count, k.name as course_name from kyt_availability_records as c 
		        LEFT JOIN kyt_course_master as k ON k.id = c.course_id
				WHERE (c.schedule_id = '' OR c.schedule_id IS NULL) $extraAFilter AND c.is_active = '1'
		        GROUP BY c.course_id";
		$data['course_data'] = $course_records = $this->Common_model->get_query_result_array($sql);
		
		
		#---- ANALYTICS
		$sql = "SELECT c.*, CONCAT(k.fname, ' ', k.lname) as teacher_name from kyt_availability_records as c 
		        LEFT JOIN signin_client as k ON k.id = c.teacher_id
				WHERE (c.schedule_id = '' OR c.schedule_id IS NULL) $extraAFilter AND c.is_active = '1'";
		$data['teacher_data'] = $teacher_records = $this->Common_model->get_query_result_array($sql);
		$data['allTotal'] = count($teacher_records);
		$data['allUsers'] = $allUsers = array_unique(array_column($teacher_records, 'teacher_id'));
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));	
		$data['currMonth'] = $get_month = date('m', strtotime($todayStartDate));
		$data['currYear'] = $get_year = date('Y', strtotime($todayStartDate));
		$data['totalDays'] = $totalDays = cal_days_in_month(CAL_GREGORIAN, $get_month, $get_year);
		$data['from_month'] = $from_month = $get_year ."-" .$get_month ."-" ."01";
		$data['to_month'] = $to_month = $get_year ."-" .$get_month ."-" .$totalDays;
		
		foreach($teacher_records as $token)
		{
			$current_date = date('Y-m-d', strtotime($token['avail_date']));			
			$current_user = $token['teacher_id'];
			if($current_date >= $from_month &&  $current_date <= $to_month){
				$data['monthly']['date'][$current_date][] = $token;
			}
			$data['monthly']['user'][$current_user][] = $token;
			$data['monthly']['userinfo'][$current_user]['name'] = $token['teacher_name'];
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
		
		
		
		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data["aside_template"] = "kyt/ldc_aside.php";
		$data["content_template"] = "kyt/kyt_crm_dashboard.php";				
		$data["content_js"] = "kyt/kyt_overview_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	
	//==========================================================================================
	///  DEMO CLASS
	//==========================================================================================
	
	public function form()
	{		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt/ldc_aside.php";
		 $data["content_template"] = "kyt/kyt_demo_class_form.php";
		 
		 //$data['allCountries'] = $this->master_countries();
		 $data['level_master'] = $this->Kyt_model->get_level_master_data();	
		 $data['course_master'] = $this->Kyt_model->get_course_master_data();
		 $data['teacher_time_slot'] = $this->Kyt_model->get_teacher_time_slot_list();																				 
		 
		 //echo'<pre>';print_r($data);
		 $data["content_js"] = "kyt/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);
	  
	 }

	 public function insert_demo_class(){
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
		redirect('kyt/form');

	 }
	 	 
	 public function demo_class_report()
	 {		 
		 $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt/ldc_aside.php";
		 $data["content_template"] = "kyt/kyt_demo_class_report.php";
		 	 
		 $data["content_js"] = "kyt/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);
	  
	 }
	 
	public function generate_demo_class_reports($from_date ='', $to_date='')
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
	}
	
	
	//==========================================================================================
	///  LEAVE
	//==========================================================================================

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
		 $data["aside_template"] = "kyt/ldc_aside.php";
		 $data["content_template"] = "kyt/kyt_leave.php";
		 //$data["content_js"] = "kyt/ldc_master_js.php";
		 $from_date = $this->input->get('date_from');
		 $to_date = $this->input->get('date_to');

		 
		 // TEACHER ID
		$extraFilter = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND employee_id = '$teacherID'";
		}
		if($from_date!=""){
			$extraFilter.= " AND m.from_date >= '$from_date'";
		}
		if($to_date!=""){
			$extraFilter.= " AND m.to_date <= '$to_date'";
		}
		 
		 $sql_leave = "Select m.*, CONCAT(s.fname, ' ', s.lname) as teacher_name, s.email_id from kyt_leave_master as m
		               LEFT JOIN signin_client as s ON s.id = m.employee_id
					   WHERE applied_from = 'leave' $extraFilter";
		 $leave_data = $this->Common_model->get_query_result_array($sql_leave);															 
		 $data['leave_master'] = $leave_data ;
		 $data['search_from'] = $from_date;
		 $data['search_to'] = $to_date;
		 
		 $data["content_js"] = "kyt/kyt_crm_js.php";
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
		 redirect('kyt/leave'); 
	 }
	 
	 public function change_leave_status(){
				 $id = $this->input->post('id');
		 $status = $this->input->post('status');
		 $this->db->set('status', $status, true);
		 $this->db->where('id', $id);
         $this->db->update('kyt_leave_master');
		 echo $status;
	 }


	 public function change_partical_leave_status(){

		  $id = $this->input->post('id');
		 $status = $this->input->post('status');
		 $this->db->set('status', $status, true);
		 $this->db->where('id', $id);
         $this->db->update('kyt_partical_leave_table');

          $sqlI="select * from kyt_partical_leave_table where id ='".$id."'";
          $leave_data = $this->Common_model->get_query_result_array($sqlI);
          $avail_id = $leave_data[0]['avail_record_id'];
          if($status=='A'){
	          $data=array('is_leave'=>1);
			 $this->db->where('id',  $avail_id);
	         $this->db->update('kyt_availability_records',$data);	
     	}else
     	{
		 	$data=array('is_leave'=>0);
			 $this->db->where('id',  $avail_id);
	         $this->db->update('kyt_availability_records',$data);	
     	}
     	echo $status;
	 }
	 
	 public function leave_master_csv(){
		$filename = 'kyt_leave_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$header = array("Employee Name","Email","From Date","To Date","No Of Days","Reason","Contact Details","Status"); 
		$id = $this->input->get('id');
		$extra = "";
		$search_from = str_replace("\'","'",$this->input->get('search_from'));
		$search_to = str_replace("\'","'",$this->input->get('search_to'));
		if($search_from!=""){
			$extra.= "and k.from_date>=$search_from";
		}
		if($search_to!=""){
			$extra.= "and k.to_date<=$search_to";
		}
		if($id!=""){
			$sql_lev = "select k.*,(select CONCAT(s.fname,s.lname) as fullname from signin s where s.id =k.employee_id) as fullname,(select email_id as email from signin s where s.id =k.employee_id) as email from  kyt_leave_master k where applied_from='leave' and employee_id=".$id." ".$extra;
		}
		else
		{
			$sql_lev = "select k.*,(select CONCAT(s.fname,s.lname) as fullname from signin s where s.id =k.employee_id) as fullname ,(select email_id as email from signin s where s.id =k.employee_id) as email from  kyt_leave_master k where applied_from='leave' ".$extra;
		}
		//echo $sql_lev;die();
		$summary =  $this->Common_model->get_query_result_array($sql_lev);
		$file = fopen('php://output', 'w');
			fputcsv($file, $header);

			foreach($summary as $key => $val){
					$body = array();
					$status =($val['status']=='disapproved')?'Rejected':$val['status'];
					$body[]=$val['fullname'];
					$body[]=$val['email'];
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
	 
	 
	 //===========================================================================================================//
	 // AVAILABILITY
	 //==========================================================================================================//
	 
	 function my_availability()
	 {
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_my_availability_list.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
        
		// Teacher ID 
		$teacherID = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND id = '$teacherID'";
		}
		
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 	
		}
		
		if(!empty($this->input->get('teacher_id'))){	
			
			$teacherID = $this->input->get('teacher_id');
		}
		$data['teacher_id'] = $teacherID;	
		if(!empty($teacherID)){
			$data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherID);
		}
		
		$extraOPFilter = "";
		if(get_role() == 'teacher'){
			$extraOPFilter = " AND k.teacher_id = '".$teacherID."'";
		}
		if(!empty($teacherID)){
			$extraOPFilter = " AND k.teacher_id = '".$teacherID."'";
		}

		$sqlTeacher = "SELECT * from signin_client WHERE role='teacher' $extraFilter";
		$data['teachersList'] = $this->Common_model->get_query_result_array($sqlTeacher);

		//Course List//

		$courseID = ""; $extraFilter = "";
		if(!empty($this->input->get('course_id'))){		
			$courseID = $this->input->get('course_id');
		}
		if(!empty($this->uri->segment(3))){		
			$courseID = $this->uri->segment(3);			
		}
		$data['course_id'] = $courseID;
		if($courseID!=""){
			if($courseID!="All Course"){
				$extraOPFilter.= " AND k.course_id = '".$courseID."'";
			}
			
		}
		
		 // Master Data
		 $sqlCourse = "SELECT * from kyt_course_master WHERE 1 $extraFilter";
		 $data['courseList'] = $this->Common_model->get_query_result_array($sqlCourse);
		
		// DATE SEARCH
		$fromDate = $this->input->get('date_from');
		$toDate = $this->input->get('date_to');
		
		if(!empty($fromDate) && !empty($toDate))
		{
			$search_from = date('Y-m-d', strtotime($fromDate));
			$search_to =  date('Y-m-d', strtotime($toDate));
			//$extraOPFilter .= " AND (k.from_date >= '$search_from' AND k.to_date <= '$search_to')";
			
			// GET ALL DATES
			$datesAr = array();
			$startDate = $search_from;
			$endDate = $search_to;
			$datesAr[] = $startDate;
			if(strtotime($endDate) >= strtotime($startDate))
			{
				$checkDate = $startDate; $counter = 0;
				while(strtotime($checkDate) <= strtotime($endDate))
				{
					$counter++;
					$datesAr[] = $checkDate;
					$checkDate = date('Y-m-d', strtotime('+1 day', strtotime($checkDate)));
					if($counter > 180){ break; }
				}
			}
			//$gotDates = implode('","', array_unique($datesAr));
			//$extraDATEFilter .= " ( k.from_date >='$tokend' AND k.to_date <='$tokend') ";
			if(!empty($datesAr)){
				$extraDATEFilter = " AND (";
				$cn=0;
				foreach($datesAr as $tokend){
					$checkUp = "";
					if($cn>0){ $extraDATEFilter .= " OR "; }
					$extraDATEFilter .= " ('$tokend' >= k.from_date AND '$tokend' <= k.to_date) ";
					//$extraDATEFilter .= " ( k.from_date >='$tokend' AND k.to_date <='$tokend') ";
					$cn++;
				}
				$extraDATEFilter .= ")";
				$extraOPFilter .= $extraDATEFilter;
			} else {
				$extraOPFilter = " AND 0 ";
			}
		}
	
		if(!empty($course)){
				$extraOPFilter .= " AND k.course_id=$courseID";	
		}
		
		$data['search_from'] = $fromDate;
		$data['search_to'] = $toDate;
		
		// Dropdown Data
	    $sqlAvailability = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name from kyt_availability as k 
		                    LEFT JOIN signin_client as c ON c.id = k.teacher_id 
		                    LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id 
							WHERE 1 AND k.is_active = '1' $extraOPFilter GROUP BY batch_code ORDER by ID ASC";
		$data['availabilityList'] = $this->Common_model->get_query_result_array($sqlAvailability);
		
		//echo'<pre>';print_r($data['availabilityList']);die
		$this->load->view('dashboard',$data);
	}
	
	 function set_availability()
	 {
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_set_availability.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
        
		// Teacher ID 
		$teacherID = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND id = '$teacherID'";
		}
		if(!empty($this->input->get('teacher_id'))){		
			$teacherID = $this->input->get('teacher_id'); 
		}
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 
		}
		$data['teacher_id'] = $teacherID;
		
		// Dropdown Data
		$data['level_master']  = $this->Kyt_model->get_level_master_data();	
		$data['course_master'] = $this->Kyt_model->get_course_master_data();
		$data['time_slots']	= $this->Kyt_model->get_slots_list();
		
		if(!empty($teacherID)){
			$data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherID);
		}
		
		// Get Last Scheduled
		$lastDate = "";
		$sqlDate = "SELECT to_date as value from kyt_availability WHERE teacher_id = '$teacherID' AND is_active = '1'  ORDER by ID DESC LIMIT 1";
		$queryDate = $this->Common_model->get_single_value($sqlDate);
		if(!empty($queryDate)){
			$lastDate = $queryDate;
		}
		$data['lastDate'] = $lastDate;
		
		$this->load->view('dashboard',$data);
	}
	
	
	 function update_availability()
	 {
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_update_availability.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
        
		// Teacher ID 
		$teacherID = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND id = '$teacherID'";
		}
		if(!empty($this->input->get('teacher_id'))){		
			$teacherID = $this->input->get('teacher_id'); 
		}
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 
		}
		$data['teacher_id'] = $teacherID;
		
		// Avaliability ID 
		$batchCode = "0";
		if(!empty($this->input->get('batch_code'))){		
			$batchCode = $this->input->get('batch_code'); 
		}
		if(!empty($this->uri->segment(4))){		
			$batchCode = $this->uri->segment(4); 
		}
		$data['batchCode'] = $batchCode;
		
		// Availability Details
		$sqlAvailability = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name from kyt_availability as k 
		                    LEFT JOIN signin_client as c ON c.id = k.teacher_id 
		                    LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id 
							WHERE batch_code = '$batchCode' ORDER by ID ASC";
		$data['availabilityData'] = $this->Common_model->get_query_result_array($sqlAvailability);
		$data['availabilityDayData'] = $this->array_indexed($data['availabilityData'], 'day');
		
		$sqlLeave = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name from kyt_leave_master as k 
		                    LEFT JOIN signin_client as c ON c.id = k.employee_id 
							WHERE group_id = '$batchCode' ORDER by from_date ASC";
		$data['unavailableData'] = $this->Common_model->get_query_result_array($sqlLeave);
		
		// Dropdown Data
		$data['level_master']  = $this->Kyt_model->get_level_master_data();	
		$data['course_master'] = $this->Kyt_model->get_course_master_data();
		$data['time_slots']	= $this->Kyt_model->get_slots_list();
		
		if(!empty($teacherID)){
			$data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherID);
		}
		
		$this->load->view('dashboard',$data);
	}

	/**************************partical leave********************************/
	function partical_leave_form()
	 {
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_update_partial_availability.php";
         $data["content_js"] = "kyt/ldc_master_js.php";

		// Teacher ID 
		$teacherID = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND id = '$teacherID'";
		}
		if(!empty($this->input->get('teacher_id'))){		
			$teacherID = $this->input->get('teacher_id');
		}
		/*
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 
			
		}*/
		$data['teacher_id'] = $teacherID;	
		$extraOPFilter = "";
		if(!empty($teacherID)){
			$data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherID);
			$extraOPFilter = " AND k.teacher_id = '".$teacherID."'";
		}
		
		
		//if(get_role() == 'teacher'){
			
		//}

		$sqlTeacher = "SELECT * from signin_client WHERE role='teacher' $extraFilter";
		$data['teachersList'] = $this->Common_model->get_query_result_array($sqlTeacher);

		// DATE SEARCH
		$fromDate = $this->input->get('select_from_date');
		$toDate = $this->input->get('select_to_date');
		
		if(!empty($fromDate))
		{
			$search_from = date('Y-m-d', strtotime($fromDate));
			//$search_to =  date('Y-m-d', strtotime($toDate));
			$extraOPFilter .= " AND k.avail_date = '$search_from'";
		}
	
		if(!empty($course)){
				$extraOPFilter .= " AND k.course_id=$courseID";	
		}
		
		$data['search_from'] = $fromDate;
		//$data['search_to'] = $toDate;
		
		// Avaliability ID 
		$batchCode = "0";
		if(!empty($this->input->get('batch_code'))){		
			$batchCode = $this->input->get('batch_code'); 
		}
		if(!empty($this->uri->segment(4))){		
			$batchCode = $this->uri->segment(4); 
		}
		$data['batchCode'] = $batchCode;
		
		// Availability Details
		$sqlAvailability = "SELECT k.*,r.id as partical, CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name from kyt_availability_records as k 
		                    LEFT JOIN signin_client as c ON c.id = k.teacher_id 
		                    LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id 
		                    LEFT JOIN kyt_partical_leave_table as r on r.avail_record_id=k.id
							WHERE is_leave='0' and is_approved='1'".$extraOPFilter." ORDER by ID desc";
		$data['availabilityData'] = $this->Common_model->get_query_result_array($sqlAvailability);
		$data['availabilityDayData'] = $this->array_indexed($data['availabilityData'], 'day');
		
		$sqlLeave = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name from kyt_leave_master as k 
		                    LEFT JOIN signin_client as c ON c.id = k.employee_id 
							WHERE group_id = '$batchCode' ORDER by from_date ASC";
		$data['unavailableData'] = $this->Common_model->get_query_result_array($sqlLeave);
		
		// Dropdown Data
		$data['level_master']  = $this->Kyt_model->get_level_master_data();	
		$data['course_master'] = $this->Kyt_model->get_course_master_data();
		$data['time_slots']	= $this->Kyt_model->get_slots_list();
		$avail_slot=array();
		$ap =array();
		foreach($data['availabilityData'] as $key=>$rows){
			$avail_slot[]=$rows['avail_slot'];
			if($rows['partical']!=''){
				$ap[]=$rows['avail_slot'];
			}
		}
		//print_r($ap);die();
		$data['partical']=$ap;
		$data['availslot'] = $avail_slot;

		//echo'<pre>';print_r($data['availslot']);die();
		$data['success']=$this->input->get('success');
		$this->load->view('dashboard',$data);
	}
	

	/*************************End Partical Leave****************************/

	/************************Apply Partical Leave**************************/
	public function apply_partical_leave()
	{
		
		$current_user = get_user_id();
		$current_date = date('Y-m-d H:i:s');
		$pleave = explode(",",$this->input->post('pleave'));
		$apply_date = date('Y-m-d',strtotime($this->input->post('apply_date')));
		$apply_teacher = $this->input->post('app_techer_id');
		foreach($pleave as $key=>$lv){
			//$lv='7';
			 $slqID = "SELECT * from kyt_availability_records 
						where teacher_id='".$apply_teacher."' and  avail_date='".$apply_date."' and avail_slot='".$lv."' and is_approved='1'
						ORDER BY ID DESC LIMIT 1";
			$rows = $this->Common_model->get_query_result_array($slqID);
			//echo $rows[0]['id'];
			$data_ins= array(
				'schedule_id'=>$rows[0]['schedule_id'],
				'avail_record_id'=>$rows[0]['id'],
				'apply_date'=>$apply_date,
				'apply_slot'=>$lv,
				'teacher_id'=>$apply_teacher,
				'applied_by'=>$current_user,
				'applied_on'=>$current_date
			);
			$this->db->insert('kyt_partical_leave_table', $data_ins);
			
			if(sizeof($rows)==0){
				
			}
			else{
				/*$data_up = array("is_leave"=>'1');
				$this->db->where('id',$rows[0]['id']);
				$this->db->update('kyt_availability_records',$data_up);*/
			}
			
		}
		
		redirect('kyt/partical_leave_form?teacher_id='.$apply_teacher.'&select_from_date='.$apply_date.'&success=success');
		// alert("hello");
		
	}
	public function partial_leave_apply_list(){

		$current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();

		 $from_date = $this->input->get('date_from');
		 $to_date = $this->input->get('date_to');

		 $data['search_from']=$from_date;
		 $data['search_to']=$to_date;
		 
		 //$data['crmid'] = $this->generate_crm_id();
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt/ldc_aside.php";
		 $data["content_template"] = "kyt/kyt_partial_leave.php";
		 
		 // TEACHER ID
		$extraFilter = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND teacher_id = '$teacherID'";
		}
		if((!empty($from_date))&&(!empty($to_date))){
			$extraFilter.= " AND m.apply_date>='$from_date' and m.apply_date<='$to_date'";
		}
		 
		$sql_leave = "Select m.*, CONCAT(s.fname, ' ', s.lname) as teacher_name, s.email_id,t.start_time,t.end_time from kyt_partical_leave_table as m
		               LEFT JOIN signin_client as s ON s.id = m.teacher_id
		               LEFT JOIN kyt_slots as t ON t.id = m.apply_slot
					   WHERE 1 $extraFilter Order by m.apply_date";
		 $leave_data = $this->Common_model->get_query_result_array($sql_leave);															 
		 $data['leave_master'] = $leave_data ;
		 
		 $data["content_js"] = "kyt/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);
	  
	}
	public function partial_leave_master_csv(){
		$filename = 'kyt_partial_leave_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$header = array("Teacher Name","Email","Apply Date","Time Slot(s)","Contact Details","Status"); 
		$id = $this->input->get('id');
		 // TEACHER ID
		 $extraFilter = "";
		 if(get_role() == 'teacher'){
			 $teacherID = get_user_id();
			 $extraFilter = " AND teacher_id = '$teacherID'";
		 }
		 $from_date = str_replace("\'","'",$this->input->get('search_from'));
		 $to_date = str_replace("\'","'",$this->input->get('search_to'));
		 if((!empty($from_date))&&(!empty($to_date))){
			 $extraFilter.= " AND m.apply_date>=$from_date and m.apply_date<=$to_date";
		 }
		$sql_leave = "Select m.*, CONCAT(s.fname, ' ', s.lname) as teacher_name, s.email_id,t.start_time,t.end_time from kyt_partical_leave_table as m
		               LEFT JOIN signin_client as s ON s.id = m.teacher_id
		               LEFT JOIN kyt_slots as t ON t.id = m.apply_slot
					   WHERE 1 $extraFilter Order by m.apply_date";
		//echo $sql_leave;die();
		$summary =  $this->Common_model->get_query_result_array($sql_leave);
		$file = fopen('php://output', 'w');
			fputcsv($file, $header);

			foreach($summary as $key => $val){
					$body = array();
					$status ="";
					if($val['status']=='I')$status='Applied';
					if($val['status']=='A')$status='Approved';
					if($val['status']=='D')$status='Rejected';
					$body[]=$val['teacher_name'];
					$body[]=$val['email_id'];
					$body[]=date('Y-m-d',strtotime($val['apply_date']));
					$body[]=$val['start_time'].' - '.$val['end_time'];
					$body[]=$val['contact_details'];
					$body[]=ucwords($status);
					fputcsv($file, $body);		
				}

			fclose($file); 
			exit; 
	 }
	function add_set_availability()
	{
		
		$current_user = get_user_id();
		
		$postData   = $this->input->post();
		$teacher_id  = $this->input->post('teacher_id');		
		$course_id  = $this->input->post('course_id');		
		$from_date = $this->input->post('select_from_date');
		$to_date   = $this->input->post('select_to_date');
		$batch_code   = $this->input->post('batch_code');
		
		$slqID = "SELECT id as value from kyt_availability ORDER BY ID DESC LIMIT 1";
		$lastID = $this->Common_model->get_single_value($slqID);
		
		$timeSlotsArray	= $this->Kyt_model->get_slots_list();
		$timeSlots = $this->array_indexed($timeSlotsArray, 'id');
		
		if(empty($batch_code)){
			$batch_code = strtoupper(date('M')).mt_rand(111,999).sprintf('%04d', $lastID+1);
		}
		
		//echo "<pre>".print_r($postData, 1)."</pre>";
		//die();
		
		$this->db->trans_begin();
		$flag = "ok";
		
		 // AVAILIBILITY
		 $this->db->where('batch_code', $batch_code);
		 $this->db->where('teacher_id', $teacher_id);
		 $this->db->delete('kyt_availability');
		 
		 //$this->db->where('ref_code', $batch_code);
		 //$this->db->where('teacher_id', $teacher_id);
		 //$this->db->delete('kyt_availability_records');
		 
		 $sqlCheck = "UPDATE kyt_availability_records SET is_active = '0' WHERE ref_code = '$batch_code' AND teacher_id = '$teacher_id' AND is_additional = '0'";
		 $queryCheck = $this->db->query($sqlCheck);
			
		 $sqlData = "SELECT * from kyt_availability_records WHERE ref_code = '$batch_code' AND teacher_id = '$teacher_id'";
		 $availabilityDATA = $this->Common_model->get_query_result_array($sqlData);
		 
		$dayArray = $this->days_list();
		foreach($dayArray as $k=>$val){			
			if(!empty($postData[$k]))
			{
				$slotIDs = implode(',', $postData[$k]);
				$ustatus = 'P';
				if(get_login_type() == 'client' && get_role() != 'teacher'){
					$ustatus = 'C';
				}
				if(!empty($slotIDs)){
					$dataArray = [
						"batch_code" => $batch_code,
						"teacher_id" => $teacher_id, 
						"course_id" => $course_id,
						"from_date" => date('Y-m-d', strtotime($from_date)),
						"to_date" => date('Y-m-d', strtotime($to_date)),
						"day" => $k,
						"slot_ids" => $slotIDs,
						"timezone" => 'IST',
						"created_by" => $current_user,
						"created_on" => CurrMySqlDate(),
						"status" => $ustatus
					];
					if(get_login_type() == 'client' && get_role() != 'teacher'){
						$dataArray += [ "is_approved" => 1 ];
						$dataArray += [ "approved_by" => $current_user ];
						$dataArray += [ "approved_on" => CurrMySqlDate() ];
					}
					data_inserter('kyt_availability', $dataArray);
				}
			}
		}
		
		// AVAILABILITY RECORDS
		$startDate = date('Y-m-d', strtotime($from_date));
		$endDate = date('Y-m-d', strtotime($to_date));
		if(strtotime($endDate) >= strtotime($startDate))
		{				
			$currentDay = $startDate; $counter = 0;
			while(strtotime($currentDay) <= strtotime($endDate))
			{
				$currentDayName = strtoupper(date('D', strtotime($currentDay)));
				if(!empty($postData[$currentDayName]))
				{ 	
					foreach($postData[$currentDayName] as $slotVal){
						if(!empty($slotVal)){
							$startTime = $timeSlots[$slotVal]['start_time'];
							$endTime = $timeSlots[$slotVal]['end_time'];
							$checkArray = array();
							$checkArray['teacher_id'] = $teacher_id;
							$checkArray['course_id'] = $course_id;
							$checkArray['avail_date'] = $currentDay;
							$checkArray['avail_day'] = $currentDayName;
							$checkArray['avail_slot'] = $slotVal;
							$checkArray['avail_start_time'] = $startTime;
							$checkArray['avail_end_time'] = $endTime;
							$checkAVAIL = array();
							$checkAVAIL = array_filter($availabilityDATA, function($tokenV) use ($checkArray){
								if($tokenV['teacher_id'] == $checkArray['teacher_id'] && $tokenV['course_id'] == $checkArray['course_id'] && $tokenV['avail_date'] == $checkArray['avail_date'] && $tokenV['avail_slot'] == $checkArray['avail_slot'] && $tokenV['avail_start_time'] == $checkArray['avail_start_time'] && $tokenV['avail_end_time'] == $checkArray['avail_end_time']){
									return $tokenV;
								}
							});
							if(!empty($checkAVAIL)){
								$counter = 0;
								foreach($checkAVAIL as $tokenCC){
								if($counter < 1){
										
									if($tokenCC['is_additional'] == 1){
									} else {											
										$dataUpdate = [ "is_active" => 1 ];
										if(get_login_type() == 'client' && get_role() != 'teacher'){
											$dataUpdate += [ "is_approved" => 1 ];
											$dataUpdate += [ "approved_by" => $current_user ];
											$dataUpdate += [ "approved_on" => CurrMySqlDate() ];
										}
										$this->db->where('id', $tokenCC['id']);
										$this->db->where('teacher_id', $tokenCC['teacher_id']);
										$this->db->where('course_id', $tokenCC['course_id']);
										$this->db->where('avail_date', $tokenCC['avail_date']);
										$this->db->update('kyt_availability_records', $dataUpdate);										
									}
									
								}
									$counter++;
								}								
								
							} else {
							
								$startTime = $timeSlots[$slotVal]['start_time'];
								$endTime = $timeSlots[$slotVal]['end_time'];
								
								$this->db->where('teacher_id', $teacher_id);
								$this->db->where('course_id', $course_id);
								$this->db->where('avail_date', $currentDay);
								$this->db->where('avail_day', $currentDayName);
								$this->db->where('avail_slot', $slotVal);
								$this->db->where('avail_start_time', $startTime);
								$this->db->where('avail_end_time', $endTime);
								$this->db->delete('kyt_availability_records');
								
								
								$slotData = [
									"teacher_id" => $teacher_id, 
									"course_id" => $course_id,
									"avail_date" => $currentDay,
									"avail_day" => $currentDayName,
									"avail_slot" => $slotVal,
									"avail_start_time" => $startTime,
									"avail_end_time" => $endTime,
									"avail_timezone" => 'IST',
									"created_by" => $current_user,
									"created_on" => CurrMySqlDate(),
									"ref_code" => $batch_code,
								];
								
								if(get_login_type() == 'client' && get_role() != 'teacher'){
									$slotData += [ "is_approved" => 1 ];
									$slotData += [ "approved_by" => $current_user ];
									$slotData += [ "approved_on" => CurrMySqlDate() ];
								}
								
								
								data_inserter('kyt_availability_records', $slotData);
							
							}
						}
					}
				}
				$counter++;
				$currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
				if($counter > 180){
					//die();
					$flag = "error";
				}
			}
		}
		
		
		// UNAVAILABLE DATA
		$unavailableArray = array("date_one", "date_two","date_three","date_four");
		foreach($unavailableArray as $token){
			if(!empty($postData[$token])){
				$postDate = $postData[$token];
				$currDate = date('Y-m-d', strtotime($postDate));
				$dataArray = [
					"employee_id" => $teacher_id,
					"from_date" => $currDate,
					"to_date" => $currDate,
					"no_of_days" => '1',
					"reason" => 'OFF',
					"contact_details" => '',
					"applied_from" => 'availability',
					"group_id" => $batch_code
				];
				data_inserter('kyt_leave_master', $dataArray);
			}
		}
		
		if($flag=="error"){
			$this->db->trans_rollback();
		}
		
		$this->db->trans_complete();
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function availability_update_status()
	{
		if(!empty($this->uri->segment(3))){		
			$batch_code = $this->uri->segment(3); 
		}
		$current_user = get_user_id();
		$approve_date = date('Y-m-d H:i:s');
		$data = array('status'=>'C','approved_by'=>$current_user,'approved_on'=>$approve_date, 'is_approved'=> 1);
		$this->db->where('batch_code', $batch_code);
		$this->db->update('kyt_availability', $data);
		
		$data = array('approved_by'=>$current_user,'approved_on'=>$approve_date, 'is_approved'=> 1);
		$this->db->where('ref_code', $batch_code);
		$this->db->update('kyt_availability_records', $data);
		
		redirect('kyt/my_availability');
	}
	
	
	public function multi_avail_update_status()
	{
		$list = $this->input->post('selectsllist');
		$current_user = get_user_id();
		$approve_date = date('Y-m-d H:i:s');
		foreach($list as $k=>$ids){
			$data = array('status'=>'C','approved_by'=>$current_user,'approved_on'=>$approve_date, 'is_approved'=> 1);
			$this->db->where('batch_code', $ids);
			$this->db->update('kyt_availability', $data);
			
			$data = array('approved_by'=>$current_user,'approved_on'=>$approve_date, 'is_approved'=> 1);
			$this->db->where('ref_code', $ids);
			$this->db->update('kyt_availability_records', $data);
		}
		redirect('kyt/my_availability');
	}
	
	public function availability_delete()
	{
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 
		}
	}
	
	
	 //===========================================================================================================//
	 // SCHEDULE
	 //==========================================================================================================//
	 
	 function schedule_list()
	 {
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_schedule_list.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
        
		// Teacher ID 
		$teacherID = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND id = '$teacherID'";
		}
		if(!empty($this->input->get('teacher_id'))){		
			$teacherID = $this->input->get('teacher_id');
			$teacher_id = $this->input->get('teacher_id');
		}
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 
			
		}
		$data['teacher_id'] = $teacherID;	
		if(!empty($teacherID)){
			$data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherID);
		}
		
		$extraOPFilter = "";
		if(get_role() == 'teacher'){
			$extraOPFilter = " AND k.teacher_id = '$teacherID'";
		}
		
		// DATE SEARCH
		$fromDate = $this->input->get('date_from');
		$toDate = $this->input->get('date_to');

		// Teacher ID 
		$teacherID = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND id = '$teacherID'";
		}
		if(!empty($this->input->get('teacher_id'))){		
			$teacherID = $this->input->get('teacher_id');
		}
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 
			
		}
		$data['teacher_id'] = $teacherID;	
		if(!empty($teacherID)){
			$data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherID);
		}
		
		$extraOPFilter = "";
		if(get_role() == 'teacher'){
			$extraOPFilter = " AND k.teacher_id = '".$teacherID."'";
		}
		
		if(!empty($teacherID)){
			$extraOPFilter = " AND k.teacher_id = '".$teacherID."'";
		}
		$course_id = $this->input->get('course_id');
		if(!empty($course_id)){
			$extraOPFilter.= " AND k.course_id = '".$course_id."'";
		}
		$data['course_id']=$course_id;
		
		$session_type = $this->input->get('session_type');
		if(!empty($session_type)){
			$extraOPFilter.= " AND ks.session_type = '".$session_type."'";
		}
		$data['session_type']=$session_type;
		
		$age_group = $this->input->get('age_group');
		if(!empty($age_group)){
			$extraOPFilter.= " AND ks.age_group = '".$age_group."'";
		}
		$data['age_group']=$age_group;

		if(!empty($fromDate) && !empty($toDate))
		{
			$search_from = date('Y-m-d', strtotime($fromDate));
			$search_to =  date('Y-m-d', strtotime($toDate));
			$extraOPFilter .= " AND (k.avail_date >= '$search_from' AND k.avail_date <= '$search_to')";
		}
		$data['search_from'] = $fromDate;
		$data['search_to'] = $toDate;
		$extraOPFilter.='and ks.is_active=1';

		$sqlTeacher = "SELECT * from signin_client WHERE role='teacher' $extraFilter";
		$data['teachersList'] = $this->Common_model->get_query_result_array($sqlTeacher);

		$sqlcourse = "SELECT *  from `kyt_course_master` WHERE is_active =1";
		$data['courselist']= $this->Common_model->get_query_result_array($sqlcourse);
		
		$sqlcourseSession = "SELECT DISTINCT(session_type) as session_type  from `kyt_schedule_upload` WHERE is_active =1";
		$data['sessionList']= $this->Common_model->get_query_result_array($sqlcourseSession);
		
		$sqlAgeSession = "SELECT DISTINCT(age_group) as age_group  from `kyt_schedule_upload` WHERE is_active =1";
		$data['ageList']= $this->Common_model->get_query_result_array($sqlAgeSession);
		
		// Dropdown Data
		$sqlSchedule = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name, ks.age_group, ks.session_type from kyt_availability_records as k 
		                    INNER JOIN kyt_schedule_upload as ks ON ks.id = k.schedule_id 
		                    LEFT JOIN signin_client as c ON c.id = k.teacher_id 
		                    LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id 
							WHERE 1 AND k.is_active = '1' AND k.is_leave=0 AND k.is_approved = '1' $extraOPFilter ORDER by k.avail_date,k.avail_start_time ASC";
		$data['scheduleList'] = $this->Common_model->get_query_result_array($sqlSchedule);

		if($this->input->get('download')){

				//==================================  generate CSV file code start ==============================================//
				$file_name = "Schedule_list".date('HmdHis');
				$filename = $file_name.'.csv'; 
				header("Content-Description: File Transfer"); 
				header("Content-Disposition: attachment; filename=$filename"); 
				header("Content-Type: application/csv; ");
				$header = array("Sl", "Teacher Name", "Course", "Date", "Day", "Start Time", "End Time");

				
				$file = fopen('php://output', 'w');
				fputcsv($file, $header);
					$i=0; 
				foreach($data['scheduleList'] as $key => $val){
						$body=array();
						$body[] = ++$i;
						$body[] = $val["teacher_name"];
						$body[] = $val["course_name"];
						$body[] = date('d M, Y', strtotime($val['avail_date']));
						$body[] = $val["avail_day"];
						$body[] = $val["avail_start_time"];
						$body[] = $val["avail_end_time"];
						fputcsv($file, $body);	
				}
					
				fclose($file); 
				exit;		
		}
		else{		
		$this->load->view('dashboard',$data);
		}
	}
	 
	 function upload_schedule()
	{
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_upload_schedule.php";
         $data["content_js"] = "kyt/ldc_upload_js.php";
		 
		
		// UPLOAD CHECK
		$uploadData = array();
		if(!empty($this->input->post('upload_file')))
		{
			$outputFile = FCPATH ."uploads/schedule_log_file/";
			$config = [
				'upload_path'   => $outputFile,
				'allowed_types' => 'csv',
				'max_size' => '1024000',
			];
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->overwrite = true;
			if (!$this->upload->do_upload('userfile'))
			{
				redirect($_SERVER['HTTP_REFERER']);
			}			
			$upload_data = $this->upload->data();
			$file_name = $outputFile .$upload_data['file_name'];
			
			$uploadData = $this->upload_schedule_check($file_name);	
			
			// CSV SAVE
			$errorLog = $outputFile."upload_schedule_log.csv";
			$csv_handler = fopen ($errorLog,'w');
			$headerArray = array("SL","Status","Remarks","Date","Day","Teacher Name","Teacher Email","Start Time","End Time",
			"Session Type","Course Category","Age Group","Child","Notes","Row No", "Is Email");
			fputcsv($csv_handler, $headerArray);
			$counter = 0;
			foreach($uploadData['csv'] as $row) {
				$counter++;
				$statusMsg = !empty($row['remarks']['error']) ? $row['remarks']['error'] ."," .$row['remarks']['success'] : $row['remarks']['success'];
				$csvLine = array( $counter, $row['status'], $statusMsg, $row['date'], $row['day'], $row['name'], $row['email'], $row['start_time'], $row['end_time'], $row['session_type'], $row['course_category'], $row['age_group'], $row['child_name'], $row['notes'], $row['row_no'], $row['is_email'] );
				fputcsv($csv_handler, $csvLine);
			}  
			fclose($csv_handler);
			
			
			//echo "<pre>".print_r($uploadData, 1)."</pre>";
			//die();
		}
        
		$data['uploadData'] = $uploadData;
		

		$this->load->view('dashboard',$data);
	}
	
	public function download_upload_log(){
		if(check_logged_in())
		{			
			$file = FCPATH .'uploads/schedule_log_file/upload_schedule_log.csv';
			ob_end_clean();
			header('Content-Description: File Transfer');
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);					 
		}
	}
	
	public function download_sample_log(){
		if(check_logged_in())
		{			
			$file = FCPATH .'uploads/schedule_log_file/sample_shift_upload_format.csv';
			ob_end_clean();
			header('Content-Description: File Transfer');
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);					 
		}
	}
	
	
	function upload_schedule_check($fileName)
	{
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Presets
		 $dayArray = $this->days_list();
		 $fullDayArray = array_flip($dayArray);
		 
		 $timeSlotsArray = $this->Kyt_model->get_slots_list();
		 $cp_timeSlots = $this->array_indexed($timeSlotsArray, 'start_time');
		 
		 $courseArray = $this->Kyt_model->get_course_master_data();
		 $cp_courseName = $this->array_indexed($courseArray, 'name');
		 
		 $csvRelation = [
			"date" => '0',
			"day" => '1',
			"name" => '2',
			"email" => '3',
			"start_time" => '4',
			"end_time" => '5',
			"session_type" => '6',
			"course_category" => '7',
			"age_group" => '8',
			"child_name" => '9',
			"notes" => '10',
		 ];
		 
		 //======= GET CSV DATA
		 $csvData = array();
		 $headerData = array();
		 $handle = fopen($fileName, "r");
		 $counter=0;
         while (($result = fgetcsv($handle)) !== false)
		 {
			$counter++;
			if($counter == 1){
				$headerData = $result;
			} else {
				$csvData[] = array_map('trim', $result);
			}
		 }
		 //echo "<pre>".print_r($csvData, 1)."</pre>";
		 //echo "<pre>".print_r($cp_courseName, 1)."</pre>";
		 
		 $checkerArray = array();
		 $teachersCSV = array();
		 
		 //========  CHECK TEACHERS DATA
		 $teacherFlag = true;
		 $teacherFlagEmail = array();		 
		 $teacherFlagSuccessEmail = array();
		 
		 #-- EmailID
		 $relationEmail = $csvRelation['email'];
		 $emailIDs = array_column($csvData, $relationEmail);
		 $gotEmailIds = implode("','", $emailIDs);
		 $teachersDataSql = "SELECT * from signin_client WHERE email_id IN ('".$gotEmailIds."') AND role='teacher'";
		 $teachersDataAr = $this->Common_model->get_query_result_array($teachersDataSql);
		 $teachersData = $this->array_indexed($teachersDataAr, 'email_id');
		 $uniqueTeachers = array_unique($emailIDs);
		 foreach($uniqueTeachers as $tokenEmail)
		 {
			 if(empty($teachersData[$tokenEmail])){
				 $teacherFlag = false;
				 $teacherFlagEmail[] = $tokenEmail;
			 } else {
				  $teacherFlagSuccessEmail[] = $tokenEmail;
				  
				  #--- Teachers Data
				  $teachersCSV[$tokenEmail] = array_filter($csvData, function($token) use ($tokenEmail, $relationEmail){
					if($token[$relationEmail] == trim($tokenEmail)){
						return $token;
					}
				  });
				  
				  #--- Teachers Name
				  $teacherName = $teachersData[$token]['fname'].$teachersData[$token]['lname'];
				  $teacherName = preg_replace('/\s+/', '', $teacherName);
			 }
		 }
		 $checkerArray['teacher']['check'] = $teacherFlag;
		 $checkerArray['teacher']['error'] = $teacherFlagEmail;
		 $checkerArray['teacher']['success'] = $teacherFlagSuccessEmail;
		 
		 //echo "<pre>".print_r($teachersCSV, 1)."</pre>";
		 
		 
		 
		 //========  SCHEDULE CHECK
		 $errorData = array();
		 $insertArray = array();
		 $scheduleData = array();
		 $availaibilityData = array();
		 $allOffDates = array();
		 $allLeaveDates = array();
		 $leaveDates = array();
		 $getMaxDate = array();
		 
		 foreach($uniqueTeachers as $key)
		 {
			 $curr_teachersData = $teachersData[$key];
			 $curr_teacher_id = $curr_teachersData['id'];
			 $curr_teacher_email = trim($curr_teachersData['email_id']);
			 $curr_teacher_name = $curr_teachersData['fname'] ." " .$curr_teachersData['lname'];
			 
			 foreach($teachersCSV[$curr_teacher_email] as $token)
			 {
				 $gotDate = $token[$csvRelation['date']];
				 $dateCheck = explode('/', $gotDate);
				 $getDateSet = $dateCheck[2] ."-" .sprintf('%02d', $dateCheck[1]) ."-" .sprintf('%02d', $dateCheck[0]);
				 
				 #--- Date Check
				 $flag_Date = false;
				 if(!empty($dateCheck[2]) && strlen($dateCheck[2]) == '4'){
					$flag_Date = true;
				 }
				 
				 $getDay = $token[$csvRelation['day']];
				 $getDaySet = !empty($fullDayArray[ucwords($getDay)]) ? $fullDayArray[ucwords($getDay)] : "";
				 
				 $getStartTime = $token[$csvRelation['start_time']].":00";
				 $getEndTime = $token[$csvRelation['end_time']].":00";
				 if(!empty($dataRow[$csvRelation['start_time']])){
					 $timeFound = explode(':', $dataRow[$csvRelation['start_time']]);
					 if(strlen($timeFound[0]) == 1 && $timeFound[0] < 9){
						 $timeStamp_1 = sprintf('%02d', $timeFound[0]);
						 $timeStamp_2 = sprintf('%02d', $timeFound[1]);
						 $customTime = $timeStamp_1.":".$timeStamp_2.":00";
						 $getStartTime = $customTime;
					 }					 
				 }
				 if(!empty($dataRow[$csvRelation['end_time']])){
					 $timeFound = explode(':', $dataRow[$csvRelation['end_time']]);
					 if(strlen($timeFound[0]) == 1 && $timeFound[0] < 9){
						 $timeStamp_1 = sprintf('%02d', $timeFound[0]);
						 $timeStamp_2 = sprintf('%02d', $timeFound[1]);
						 $customTime = $timeStamp_1.":".$timeStamp_2.":00";
						 $getEndTime = $customTime;
					 }					 
				 }
				 
				 $getEmail = $token[$csvRelation['email']];
				 $getName = $token[$csvRelation['name']];
				 $getCourseCategory = trim($token[$csvRelation['course_category']]);
				 $getSessionType = $token[$csvRelation['session_type']];
				 $getAgeGroup = $token[$csvRelation['age_group']];
				 $getChild = $token[$csvRelation['child_name']];
				 $getNotes = $token[$csvRelation['notes']];
				 
				 $getSlotID = !empty($cp_timeSlots[$getStartTime]) ? $cp_timeSlots[$getStartTime]['id'] : "";
				 $getCourseID = !empty($cp_courseName[$getCourseCategory]) ? $cp_courseName[$getCourseCategory]['id'] : "";
				 
				 $scheduleData[$curr_teacher_email][] = [
					"teacher_id" => $curr_teacher_id,
					"course_id" => $getCourseID,
					"slot_id" => $getSlotID,
					"date" => $getDateSet,
					"day" => $getDaySet,
					"name" => $getName,
					"email" => $getEmail,
					"start_time" => $getStartTime,
					"end_time" => $getEndTime,
					"session_type" => $getSessionType,
					"course_category" => $getCourseCategory,
					"age_group" => $getAgeGroup,
					"child_name" => $getChild,
					"notes" => $getNotes
				 ];
			 }			 
			 
			 
			 if(!empty($scheduleData[$curr_teacher_email])){				 
				$getMaxDate[$curr_teacher_email]['max'] = $maxDate = max(array_column($scheduleData[$curr_teacher_email], 'date'));
				$getMaxDate[$curr_teacher_email]['min'] = $minDate = min(array_column($scheduleData[$curr_teacher_email], 'date'));
				
				$sqlAvailability = "SELECT * from kyt_availability_records WHERE avail_date >= '$minDate' AND avail_date <= '$maxDate' AND teacher_id = '$curr_teacher_id' AND is_active = '1' AND  is_approved = '1'";
				$queryData = $this->Common_model->get_query_result_array($sqlAvailability);
				$availaibilityData[$curr_teacher_email] = $queryData;

				$leaveDates[$curr_teacher_email] = $this->get_leave_dates($curr_teacher_id);
				$allLeaveDates[$curr_teacher_email] = $leaveDates[$curr_teacher_email]['leave']['dates'];
				$allOffDates[$curr_teacher_email] = $leaveDates[$curr_teacher_email]['off']['dates'];				
			 }			 
		 }

		 		 
		 //=================================================================================================
		 //--  UPLOAD CSV
		 //==================================================================================================
		 $this->db->trans_begin();
		 		 
		 $checkedCSV = array(); $counter = 0;
		 foreach($csvData as $dataRow)
		 {
			 $counter++;			 
			 $errorRemarks = array();
			 $successRemarks = array();
			 
			 $gotDate = $dataRow[$csvRelation['date']];
			 $dateCheck = explode('/', $gotDate);
			 $getDateSet = $dateCheck[2] ."-" .sprintf('%02d', $dateCheck[1]) ."-" .sprintf('%02d', $dateCheck[0]);
			 
			 $getDay = $dataRow[$csvRelation['day']];
			 $getDaySet = !empty($fullDayArray[ucwords($getDay)]) ? $fullDayArray[ucwords($getDay)] : "";
			 
			 $getStartTime = $dataRow[$csvRelation['start_time']].":00";
			 $getEndTime = $dataRow[$csvRelation['end_time']].":00";
			 if(!empty($dataRow[$csvRelation['start_time']])){
				 $timeFound = explode(':', $dataRow[$csvRelation['start_time']]);
				 if(strlen($timeFound[0]) == 1 && $timeFound[0] < 9){
					 $timeStamp_1 = sprintf('%02d', $timeFound[0]);
					 $timeStamp_2 = sprintf('%02d', $timeFound[1]);
					 $customTime = $timeStamp_1.":".$timeStamp_2.":00";
					 $getStartTime = $customTime;
				 }					 
			 }
			 if(!empty($dataRow[$csvRelation['end_time']])){
				 $timeFound = explode(':', $dataRow[$csvRelation['end_time']]);
				 if(strlen($timeFound[0]) == 1 && $timeFound[0] < 9){
					 $timeStamp_1 = sprintf('%02d', $timeFound[0]);
					 $timeStamp_2 = sprintf('%02d', $timeFound[1]);
					 $customTime = $timeStamp_1.":".$timeStamp_2.":00";
					 $getEndTime = $customTime;
				 }					 
			 }
				 
			 $getEmail = $dataRow[$csvRelation['email']];
			 $getName = $dataRow[$csvRelation['name']];
			 $getCourseCategory = trim($dataRow[$csvRelation['course_category']]);
			 $getSessionType = $dataRow[$csvRelation['session_type']];
			 $getAgeGroup = $dataRow[$csvRelation['age_group']];
			 $getChild = $dataRow[$csvRelation['child_name']];
			 $getNotes = $dataRow[$csvRelation['notes']];
			 
			 $getSlotID = !empty($cp_timeSlots[$getStartTime]) ? $cp_timeSlots[$getStartTime]['id'] : "";
			 $getCourseID = !empty($cp_courseName[$getCourseCategory]) ? $cp_courseName[$getCourseCategory]['id'] : "";
				 
			 #--- Teacher Check
			 $flag_Email = false;
			 $curr_teachersData = $teachersData[$getEmail];
			 $curr_teacher_id = "";
			 if(!empty($curr_teachersData)){
				 $flag_Email = true;
				 $curr_teacher_id = $curr_teachersData['id'];
				 $curr_teacher_email = trim($curr_teachersData['email_id']);
				 $curr_teacher_name = $curr_teachersData['fname'] ." " .$curr_teachersData['lname'];
			 } else {
				 $errorRemarks[] = "Email ID Not Found";		
			 }
			 
			 #--- Date Check
			$flag_Date = false;
			if(!empty($dateCheck[2]) && strlen($dateCheck[2]) == '4'){
				$flag_Date = true;
			}
			if($flag_Date == false){
				$errorRemarks[] = "Invalid Day/Date";
			}
			 
			#--- Day Check
			$flag_Day = true;
			if(strtoupper(date('D', strtotime($getDateSet))) != strtoupper($getDaySet)){
				$errorRemarks[] = "Invalid Day/Date";
				$flag_Day = false;
			}
			
			#--- Course Check
			$flag_Course = true;
			if(empty($getCourseID)){
				$errorRemarks[] = "Invalid Course";
				$flag_Course = false;
			}
			
			#--- Slot Check
			$flag_Slot = true;
			if(empty($getSlotID)){
				$errorRemarks[] = "Invalid Slot";
				$flag_Slot = false;
			}
			
			$overallFlag = true;
			if($flag_Email == false || $flag_Day == false || $flag_Course == false || $flag_Slot == false || $flag_Date == false){
				$overallFlag = false;
			}
			 
			 $currentData = [
				"teacher_id" => $curr_teacher_id,
				"course_id" => $getCourseID,
				"slot_id" => $getSlotID,
				"date" => $getDateSet,
				"day" => $getDaySet,
				"name" => $getName,
				"email" => $getEmail,
				"start_time" => $getStartTime,
				"end_time" => $getEndTime,
				"session_type" => $getSessionType,
				"course_category" => $getCourseCategory,
				"age_group" => $getAgeGroup,
				"child_name" => $getChild,
				"notes" => $getNotes
			 ];
			 
			$insertArrayData = [
				"teacher_id" => $currentData['teacher_id'],
				"course_id" => $currentData['course_id'],
				"schedule_date" => $currentData['date'],
				"schedule_day" => $currentData['day'],
				"slot_id" => $currentData['slot_id'],
				"start_time" =>  $currentData['start_time'],
				"end_time" =>  $currentData['end_time'],
				"timezone" => 'IST',
				"session_type" => $currentData['session_type'],
				"course_category" => $currentData['course_category'],
				"age_group" => $currentData['age_group'],
				"child_name" => $currentData['child_name'],
				"comments" => $currentData['notes'],
				"is_email" => 1,
				"is_active" => 1
			];
			
			
			$found = 0;
			$status = 'error';
			$is_scheduled = 0;
			$is_email = '0';
			
			if($overallFlag){
			//&& $token['course_id'] == $scheduleChecker['course_id']
			#--- Find Availiability		
			$availabilityData = NULL;
			$availabilityData = array_filter($availaibilityData[$curr_teacher_email], function($token) use ($currentData){
				$scheduleChecker = $currentData;
				if($token['avail_date'] == $scheduleChecker['date'] && $token['teacher_id'] == $scheduleChecker['teacher_id'] && $token['avail_slot'] == $scheduleChecker['slot_id'] && $token['avail_start_time'] == $scheduleChecker['start_time'] ){
					return $token;
				}
			});
			
			$flag_Leave = false;
			if(!empty($allLeaveDates[$curr_teacher_email][$curr_teacher_id]) && in_array($getDateSet, $allLeaveDates[$curr_teacher_email][$curr_teacher_id])){
				$flag_Leave = true;
				$errorRemarks[] = "Leave";
			}
			
			$flag_Off = false;
			if(!empty($allOffDates[$curr_teacher_email][$curr_teacher_id]) && in_array($getDateSet, $allOffDates[$curr_teacher_email][$curr_teacher_id])){
				$flag_Off = true;
				$errorRemarks[] = "Off";
			}
			
			$flag_Leave = false;
			if($token['is_leave']==1){
				$flag_Leave = true;
				$errorRemarks[] = "Leave";
			}
			
			#--- Availability Status
			if(!empty($availabilityData) && $flag_Leave == false && $flag_Off == false){
				$found = 1;
				$status = 'success';
				$insertArray[] = $insertArrayData;
				$errorData['available'][] = $currentData;
				foreach($availabilityData as $tokenData){
					$scheduleID = $tokenData['schedule_id'];
					$availabilityID = $tokenData['id'];
					$isleave = $tokenData['is_leave'];

				}

				
				//echo'<pre>';print_r($isleave);die();

				if(!empty($scheduleID)){
					$is_scheduled = 1;
					$currentData['schedule_id'] = $scheduleID;
					$errorData['schedule']['old'] = $currentData;
					$successRemarks[] = "Already Scheduled";
										
					if(!empty($getName) && !empty($getEmail) && !empty($getDateSet) && !empty($getStartTime) && !empty($getEndTime) && !empty($getCourseCategory))
					{
						$e_info = array();
						$e_info['start_time'] = $getDateSet ." " .$getStartTime;
						$e_info['end_time'] = $getDateSet ." " .$getEndTime;
						$e_info['course_name'] = $getCourseCategory;
						//$this->Kyt_model->send_ical_email($getEmail, $getName, $e_info);
					}
					
					
				} else {
					if($isleave==0){
					
						$is_email = '1';
						$errorData['schedule']['new'] = $currentData;					
						
						#-- Insert Data
						$valueKeys = implode(",",array_keys($insertArrayData));
						$valueData = implode("','",array_values($insertArrayData));
						$sqlReplace = "REPLACE INTO kyt_schedule_upload ($valueKeys) values ('$valueData')";
						$this->db->query($sqlReplace);
						$cp_schedule = $this->db->insert_id();
						//$cp_schedule = data_inserter('kyt_schedule_upload', $insertArrayData);
						
						#-- Update Schedule
						$updateArray = [ "schedule_id" => $cp_schedule ];
						$this->db->where('id', $availabilityID);
						$this->db->update('kyt_availability_records', $updateArray);
						//echo $this->db->last_query();
						
						if(!empty($getName) && !empty($getEmail) && !empty($getDateSet) && !empty($getStartTime) && !empty($getEndTime) && !empty($getCourseCategory))
						{
							$courseSummary = "";
							$courseSummary .= $getCourseCategory;
							if(!empty($getSessionType)){
							$courseSummary .= ",".$getSessionType;
							}
							if(!empty($getAgeGroup)){
							$courseSummary .= ",".$getAgeGroup;
							}
							if(!empty($getChild)){
							$courseSummary .= ",".$getChild;
							}
							
							$e_info = array();
							$e_info['uid'] = $cp_schedule;
							$e_info['start_time'] = $getDateSet ." " .$getStartTime;
							$e_info['end_time'] = $getDateSet ." " .$getEndTime;
							$e_info['course_name'] = $courseSummary;
							$e_info['only_course'] = $getCourseCategory;
							$e_info['session_type'] = $getSessionType;
							$e_info['age_group'] = $getAgeGroup;
							$e_info['child_name'] = $getChild;
							$e_info['remarks'] = $getNotes;
							$this->Kyt_model->send_ical_email($getEmail, $getName, $e_info);
						}
						
						
						$currentData['schedule_id'] = $cp_schedule;
						$successRemarks[] = "Scheduled & Email Sent";
					
					}
					else{
						$status = 'error';
						$errorData['unavailable'][] = $currentData;
						$errorRemarks[] = "Leave";
					}
				}
				
			} else {
				$status = 'error';
				$errorData['unavailable'][] = $currentData;
				$errorRemarks[] = "Teacher Unavailable";
			}
			
			}
			
			$currentData['available'] = $found;
			$currentData['schedule_status'] = $is_scheduled;
			$currentData['email_status'] = $is_email;
			$currentData['row_no'] = $counter;
			$currentData['status'] = $status;
			$currentData['remarks']['success'] = implode(', ', $successRemarks);
			$currentData['remarks']['error'] = implode(', ', $errorRemarks);
						
			$checkedCSV[] = $currentData;
			
			
			if($overallFlag == false || $status = 'error')
			{
				//$this->db->trans_rollback();
				//break;
			}
			 
		 }
		 
		 $this->db->trans_complete();
		 
		 $checkerArray['csv'] = $checkedCSV;		 
		 $checkerArray['available'] = $availaibilityData;		 
		 $checkerArray['data'] = $errorData;

		  //echo "<pre>".print_r($checkerArray, 1)."</pre>";
		  //echo "<pre>".print_r($insertArray, 1)."</pre>";
		  //echo "<pre>".print_r($scheduleData, 1)."</pre>";
		  //echo "<pre>".print_r($availaibilityData, 1)."</pre>";
		  //echo "<pre>".print_r($getMaxDate, 1)."</pre>";
		 
		  return $checkerArray;
		 
	}
	
	public function delete_schedule(){
		if(!empty($this->uri->segment(3))){		
			$scheduleid = $this->uri->segment(3); 
		}
		$userid = get_user_id();
		$del_data = array('is_active'=>'0');

		$this->db->where('schedule_id',$scheduleid);
		$this->db->update('kyt_availability_records',$del_data);
		$this->db->where('id',$scheduleid);
		$this->db->update('kyt_schedule_upload',$del_data);
		
		$this->Kyt_model->cancel_schedule($scheduleid);
		
		redirect('kyt/schedule_list');
	}

	public function schedule_multi_del(){

		$list = $this->input->post('selectsllist');
		echo'<pre>';print_r($list);
		foreach($list as $kt=>$rows)
		{
			$del_data = array('is_active'=>'0');

			$this->db->where('schedule_id',$rows);
			$this->db->update('kyt_availability_records',$del_data);
			$this->db->where('id',$rows);
			$this->db->update('kyt_schedule_upload',$del_data);
			
			$this->Kyt_model->cancel_schedule($rows);
			
		}	
		redirect('kyt/schedule_list');
	}
	public function availability_update_data(){
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_schedule_edit.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
		 if(!empty($this->uri->segment(3))){		
			$scheduleID = $this->uri->segment(3); 
		}
		  
		  $sql = "select * from kyt_schedule_upload where id='".$scheduleID."'";
		  $data['scheduleData'] = $this->Common_model->get_query_result_array($sql);
		  $teacherid = $data['scheduleData'][0]['teacher_id'];

		  $teachersDataSql = "SELECT * from signin_client WHERE id ='". $teacherid."' AND role='teacher'";
		  $data['teachersDataAr'] = $this->Common_model->get_query_result_array($teachersDataSql);
		  $sqllist= "select * from kyt_slots ORDER by start_time";
		  $data['slotlist'] = $this->Common_model->get_query_result_array($sqllist);
		 $this->load->view('dashboard',$data);
        
	}

	public function update_schedule_data()
	{
		$id = $this->input->post('id');
		$schedule_date = date('Y-m-d',strtotime($this->input->post('schedule_date')));
		$schedule_days = $this->input->post('schedule_days');
		$slots_time = $this->input->post('slots_time');
		$age_group = $this->input->post('age_group');
		$child_name = $this->input->post('child_name');
		$cl_comments = $this->input->post('cl_comments');
		$teacher_id = $this->input->post('teacher_id');
		$course_id = $this->input->post('course_id');
		$session_typ = $this->input->post('session_type');
		//get start time and end time//
		$sqlt= "select start_time,end_time from kyt_slots where id = $slots_time";
		$stm = $this->Common_model->get_query_result_array($sqlt);

		$start_time = $stm[0]['start_time'];
		$end_time =$stm[0]['end_time'];

		$sqlcnt= "select count(id) as value from kyt_schedule_upload where schedule_date='".$schedule_date."' and slot_id = '".$slots_time."' and teacher_id='".$teacher_id."' AND is_active = '1'";
	    $cnt=$this->Common_model->get_single_value($sqlcnt);

		
		$session_type="";
		if(!empty($session_typ)){
			$session_type=$session_typ;
		}
		//echo $session_type;
		
		if($cnt<1){
			 $sqlchk = " select count(id) as count,id from kyt_availability_records Where avail_date='".$schedule_date."' and avail_slot = '".$slots_time."' and teacher_id='".$teacher_id."' AND is_active = '1' AND is_leave=0 AND is_approved = '1' and schedule_id!=''";
			$chk=$this->Common_model->get_query_result_array($sqlchk);

			if(!empty($chk[0]['count']) && $chk[0]['count']>=1){
				if(get_role()=='teacher'){
					$date=array(
						'schedule_date'=>$schedule_date,
						'schedule_day'=>$schedule_days,
						'slot_id'=>$slots_time,
						'age_group'=>$age_group,
						'child_name'=>$child_name,
						'comments'=>$cl_comments,
						'start_time'=>$start_time,
						'end_time'=>$end_time,
						'session_type'=>$session_type,
						'teacher_id'=>$teacher_id,
						'course_id'=>$course_id,
						'timezone'=>'IST',
					);

				}
				else
				{
					$date=array(
							'schedule_date'=>$schedule_date,
							'schedule_day'=>$schedule_days,
							'slot_id'=>$slots_time,
							'age_group'=>$age_group,
							'child_name'=>$child_name,
							'comments'=>$cl_comments,
							'start_time'=>$start_time,
							'end_time'=>$end_time,
							'teacher_id'=>$teacher_id,
							'session_type'=>$session_type,
							'course_id'=>$course_id,
							'timezone'=>'IST',
							'is_active'=>'1'
					);
				}
				
				// DELETE OLD
				$changedata = array('is_active'=>'0');
				$this->db->where('id',$id);
				$this->db->update('kyt_schedule_upload',$changedata);
				
				$change = array('schedule_id'=>'');
				$this->db->where('schedule_id',$id);
				$this->db->update('kyt_availability_records',$change);
				
				// INSERT NEW
				$this->db->insert('kyt_schedule_upload', $date);
				$insert_id = $this->db->insert_id();
				
				$change = array('schedule_id'=>$insert_id);
				$this->db->where('id',$chk[0]['id']);
				$this->db->update('kyt_availability_records',$change);
				
				redirect("kyt/availability_update_data/$insert_id");
				
			}
			else
			{
			redirect("kyt/availability_update_data/$id?m=Data updation failed");
			}


		}
		else
		{
			$dates=array(
				'age_group'=>$age_group,
				'child_name'=>$child_name,
				'comments'=>$cl_comments,
				'session_type'=>$session_type
			);
			//print_r($dates);
			$this->db->where('id',$id);
			$this->db->update('kyt_schedule_uploads',$dates);
			redirect("kyt/availability_update_data/$id?m=Data updated successfully");
		}

	}

	public function admin_add_availibility_data()
	{
		
		$current_user = get_user_id();
		
		$postData   = $this->input->post();
		$teacher_id  = $this->input->post('teacher_id');		
		$course_id  = $this->input->post('course_id');		
		$from_date = $this->input->post('select_from_date');
		$to_date   = $this->input->post('select_to_date');
		$batch_code   = $this->input->post('batch_code');
		
		$slqID = "SELECT id as value from kyt_availability ORDER BY ID DESC LIMIT 1";
		$lastID = $this->Common_model->get_single_value($slqID);
		
		$timeSlotsArray	= $this->Kyt_model->get_slots_list();
		$timeSlots = $this->array_indexed($timeSlotsArray, 'id');
		
		if(empty($batch_code)){
			$batch_code = strtoupper(date('M')).mt_rand(111,999).sprintf('%04d', $lastID+1);
		}
		if(empty($$course_id)){
			$sql = "select course_id from info_personal_client where user_id='".$teacher_id."'";
			$course = $this->Common_model->get_query_result_array($sql);
			$cr_id = explode(",",$course[0]['course_id']);
			$course_id = $cr_id[0];
			//print_r($course_id);
		}
		
		//echo "<pre>".print_r($postData, 1)."</pre>";
		//die();
		
		$this->db->trans_begin();
		$flag = "ok";
		
		 // AVAILIBILITY
		 $this->db->where('batch_code', $batch_code);
		 $this->db->where('teacher_id', $teacher_id);
		 $this->db->delete('kyt_availability');
		 
		 $this->db->where('ref_code', $batch_code);
		 $this->db->where('teacher_id', $teacher_id);
		 $this->db->delete('kyt_availability_records');
		 
		$dayArray = $this->days_list();
		foreach($dayArray as $k=>$val){			
			if(!empty($postData[$k]))
			{
				$slotIDs = implode(',', $postData[$k]);
				if(!empty($slotIDs)){
					$dataArray = [
						"batch_code" => $batch_code,
						"teacher_id" => $teacher_id, 
						"course_id" => $course_id,
						"from_date" => date('Y-m-d', strtotime($from_date)),
						"to_date" => date('Y-m-d', strtotime($to_date)),
						"day" => $k,
						"slot_ids" => $slotIDs,
						"timezone" => 'IST',
						"created_by" => $current_user,
						"created_on" => CurrMySqlDate(),
						"status" => 'C',
						"is_approved"=>'1',
						"approved_by"=>$current_user,
						"approved_on"=>CurrMySqlDate()
					];
					data_inserter('kyt_availability', $dataArray);
				}
			}
		}
		
		// AVAILABILITY RECORDS
		$startDate = date('Y-m-d', strtotime($from_date));
		$endDate = date('Y-m-d', strtotime($to_date));
		if(strtotime($endDate) >= strtotime($startDate))
		{				
			$currentDay = $startDate; $counter = 0;
			while(strtotime($currentDay) <= strtotime($endDate))
			{
				$currentDayName = strtoupper(date('D', strtotime($currentDay)));
				if(!empty($postData[$currentDayName]))
				{ 	
					foreach($postData[$currentDayName] as $slotVal){
						if(!empty($slotVal)){
							$startTime = $timeSlots[$slotVal]['start_time'];
							$endTime = $timeSlots[$slotVal]['end_time'];
							$sqlchk = " select count(id) as count,id from kyt_availability_records Where avail_date='".$currentDay."' and avail_slot = '".$slotVal."' and teacher_id='".$teacher_id."' AND is_active = '1' AND is_leave=0 AND is_approved = '1' and schedule_id!=''";
							$chk=$this->Common_model->get_query_result_array($sqlchk);
							
							if(!empty($chk[0]['count']) && $chk[0]['count']>=1){
								$slotData = [
									"teacher_id" => $teacher_id, 
									"course_id" => $course_id,
									"avail_date" => $currentDay,
									"avail_day" => $currentDayName,
									"avail_slot" => $slotVal,
									"avail_start_time" => $startTime,
									"avail_end_time" => $endTime,
									"avail_timezone" => 'IST',
									"created_by" => $current_user,
									"created_on" => CurrMySqlDate(),
									"ref_code" => $batch_code,
									"is_approved"=>'1',
									"approved_by"=>$current_user,
									"approved_on"=>CurrMySqlDate()
								];
								data_inserter('kyt_availability_records', $slotData);
							}else{
								$slotData = [
									"teacher_id" => $teacher_id, 
									"course_id" => $course_id,
									"avail_date" => $currentDay,
									"avail_day" => $currentDayName,
									"avail_slot" => $slotVal,
									"avail_start_time" => $startTime,
									"avail_end_time" => $endTime,
									"avail_timezone" => 'IST',
									"created_by" => $current_user,
									"created_on" => CurrMySqlDate(),
									"ref_code" => $batch_code,
									"is_approved"=>'1',
									"approved_by"=>$current_user,
									"approved_on"=>CurrMySqlDate()
								];
								data_inserter('kyt_availability_records', $slotData);
							}
						}
					}
				}
				$counter++;
				$currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
				if($counter > 180){
					//die();
					$flag = "error";
				}
			}
		}
		
		
		// UNAVAILABLE DATA
		$unavailableArray = array("date_one", "date_two","date_three","date_four");
		foreach($unavailableArray as $token){
			if(!empty($postData[$token])){
				$postDate = $postData[$token];
				$currDate = date('Y-m-d', strtotime($postDate));
				$dataArray = [
					"employee_id" => $teacher_id,
					"from_date" => $currDate,
					"to_date" => $currDate,
					"no_of_days" => '1',
					"reason" => 'OFF',
					"contact_details" => '',
					"applied_from" => 'availability',
					"group_id" => $batch_code
				];
				data_inserter('kyt_leave_master', $dataArray);
			}
		}
		
		if($flag=="error"){
			$this->db->trans_rollback();
		}
		
		$this->db->trans_complete();
		redirect('kyt/my_availability');
	}

	
	
	 //===========================================================================================================//
	 // CALENDAR
	 //==========================================================================================================//
	 
	function availability_calendar()
	{
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_availability_calendar.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
        
		// Teacher ID 
		$teacherID = "";
		if(get_role() == 'teacher'){
			$teacherID = get_user_id();
			$extraFilter = " AND id = '$teacherID'";
		}
		if(!empty($this->input->get('teacher_id'))){		
			$teacherID = $this->input->get('teacher_id');
		}
		if(!empty($this->uri->segment(3))){		
			$teacherID = $this->uri->segment(3); 
		}
		$data['teacher_id'] = $teacherID;	
		if(!empty($teacherID)){
			$data['teacherDetails']	= $this->Kyt_model->get_teacher_details($teacherID);
		}
		
		 // Master Data
		 $sqlTeacher = "SELECT * from signin_client WHERE role='teacher' $extraFilter";
		 $data['teachersList'] = $this->Common_model->get_query_result_array($sqlTeacher);
		
		 $timeSlotsArray = $this->Kyt_model->get_slots_list();
		 $cp_timeSlots = $this->array_indexed($timeSlotsArray, 'id');
		 
		 $courseArray = $this->Kyt_model->get_course_master_data();
		 $cp_courseName = $this->array_indexed($courseArray, 'id');
		
		// Availability Data
		$sqlAvailability = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name from kyt_availability_records as k 
		                    LEFT JOIN signin_client as c ON c.id = k.teacher_id 
		                    LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id
							WHERE k.teacher_id = '$teacherID' AND k.is_active = '1' AND k.is_approved = '1'";
		$data['availabilityList'] = $availabilityList = $this->Common_model->get_query_result_array($sqlAvailability);
		
		$leaveDates = $this->get_leave_dates($teacherID);
		$allLeaveDates = $leaveDates['leave']['dates'];
		$allOffDates = $leaveDates['off']['dates'];


		
		$unavailableColor = "#c9c78b";
		$availableColor = "#00a65a";
		$scheduleColor = "#0084e7";
		$leaveColor = "#fc03e3";
		$demo ="#f20f0f";
		$beginner="#ece319";
		$intermediate="#ec8e19";
		$partical = "#4D0000";
		//$advanced = "#19a7ec";
		
		
		$data['calendar_result'] = array();
		foreach($availabilityList as $token)
		{
			$currentAvailID = $token['id'];
			$currentDate = $token['avail_date'];
			$currentStartTime = $token['avail_start_time'];
			$currentEndTime = $token['avail_end_time'];
			$currentSlot = $token['avail_slot'];
			$currentCourse = $token['course_id'];
			$currentTeacher = $token['teacher_id'];
			$is_leave =$token['is_leave'];
			
			$slotData = $cp_timeSlots[$currentSlot];
			$slot_name = $slotData['slot_name'];
			$slot_statTime = $currentDate ." " .$slotData['start_time'];
			$slot_endTime = $currentDate ." " .$slotData['end_time'];
			
			$c_slot_name = date('h:i A', strtotime($currentStartTime));
			$c_slot_statTime = $currentDate ." " .$currentStartTime;
			$c_slot_endTime = $currentDate ." " .$currentEndTime;
			
			
			$schedule_id = $token['schedule_id'];
			
			$extraAdd = "";
			$checkColor = $availableColor;
			if(!empty($schedule_id)){
				$checkColor = $scheduleColor;  $extraAdd=" (Sch)";
				$session_type = $this->get_session_type($schedule_id);
				if($session_type=='Demo'){
					$checkColor = $demo;
				}
				else if($session_type=='Beginner'){
					$checkColor = $beginner;
				}
				else if($session_type=='Intermediate'){
					$checkColor = $intermediate;
				}
				else if($session_type=='Advanced'){
					$checkColor = $scheduleColor;
				}
			}
			//echo $currentDate;
			if(!empty($allLeaveDates[$currentTeacher]) && in_array($currentDate, $allLeaveDates[$currentTeacher])){
				$checkColor = $leaveColor; $extraAdd=" (Leave)";

			}
			if(!empty($allOffDates[$currentTeacher]) && in_array($currentDate, $allOffDates[$currentTeacher])){
				$checkColor = $unavailableColor; $extraAdd=" (Off)";
			}
			if($is_leave=='1'){
				$checkColor = $partical; $extraAdd=" (leave)";
			}
			$linkURL = base_url('kyt/teacher_calendar_details/'.$currentAvailID);
			$data['calendar_result'][] = [ 
				'title' => $c_slot_name .$extraAdd,
				'start' => $c_slot_statTime,
				'end' => $c_slot_endTime,
				'allDay' =>  false,
				'url' => $linkURL,
				'backgroundColor' => $checkColor
			];
		}
		
		$this->load->view('dashboard',$data);
	}
	
	
	function courses_calendar2()
	{
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_courses_calendar2.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
        
		// Teacher ID 
		$courseID = ""; $extraFilter = "";
		if(!empty($this->input->get('course_id'))){		
			$courseID = $this->input->get('course_id');
		}
		if(!empty($this->uri->segment(3))){		
			$courseID = $this->uri->segment(3);			
		}
		$data['course_id'] = $courseID;
		
		 // Master Data
		 $sqlCourse = "SELECT * from kyt_course_master WHERE 1 $extraFilter";
		 $data['courseList'] = $this->Common_model->get_query_result_array($sqlCourse);
				
		// Availability Data
		$sqlAvailability = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name from kyt_availability_records as k 
		                    LEFT JOIN signin_client as c ON c.id = k.teacher_id 
		                    LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id
							WHERE k.course_id = '$courseID'";
		$data['availabilityList'] = $availabilityList = $this->Common_model->get_query_result_array($sqlAvailability);
		
		$leaveDates = $this->get_leave_dates();
		$allLeaveDates = $leaveDates['leave']['dates'];
		$allOffDates = $leaveDates['off']['dates'];
		
		$unavailableColor = "#c9c78b";
		$availableColor = "#00a65a";
		$scheduleColor = "#0084e7";
		$leaveColor = "#f94848";
		$partical = "#4D0000";
		
		$data['calendar_result'] = array();
		foreach($availabilityList as $token)
		{
			$currentDate = $token['avail_date'];
			$currentStartTime = $token['avail_start_time'];
			$currentEndTime = $token['avail_end_time'];
			$currentSlot = $token['avail_slot'];
			$currentCourse = $token['course_id'];
			$currentTeacher = $token['teacher_id'];
			$currentTeacherName = $token['teacher_name'];
			
			$slotData = $cp_timeSlots[$currentSlot];
			$slot_name = $slotData['slot_name'];
			$slot_statTime = $currentDate ." " .$slotData['start_time'];
			$slot_endTime = $currentDate ." " .$slotData['end_time'];
			
			$c_slot_name = date('h:i A', strtotime($currentStartTime));
			$c_slot_statTime = $currentDate ." " .$currentStartTime;
			$c_slot_endTime = $currentDate ." " .$currentEndTime;
			
			
			$schedule_id = $token['schedule_id'];
			
			$extraAdd = "";
			$checkColor = $availableColor;
			if(!empty($schedule_id)){
				$checkColor = $scheduleColor;  $extraAdd=" (Sch)";
			}
			if(!empty($allLeaveDates[$currentTeacher]) && in_array($currentDate, $allLeaveDates[$currentTeacher])){
				$checkColor = $leaveColor; $extraAdd=" (leave)";
			}
			if(!empty($allOffDates[$currentTeacher]) && in_array($currentDate, $allOffDates[$currentTeacher])){
				$checkColor = $unavailableColor; $extraAdd=" (Off)";
			}
			if($token['is_leave']==1){
				$checkColor = $partical; $extraAdd=" (leave)";
			}
			$data['calendar_result'][] = [ 
				'title' => $currentTeacherName .$extraAdd,
				'start' => $c_slot_statTime,
				'end' => $c_slot_endTime,
				'allDay' =>  false,
				'description' =>  $currentTeacherName .$extraAdd,
				'backgroundColor' => $checkColor
			];
		}
		
		$this->load->view('dashboard',$data);
	}
	
	
	function courses_calendar()
	{
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_courses_calendar.php";
         $data["content_js"] = "kyt/ldc_master_js.php";
        
		// Teacher ID 
		$courseID = ""; $extraFilter = "";
		if(!empty($this->input->get('course_id'))){		
			$courseID = $this->input->get('course_id');
		}
		if(!empty($this->uri->segment(3))){		
			$courseID = $this->uri->segment(3);			
		}
		$data['course_id'] = $courseID;
		
		 // Master Data
		 $sqlCourse = "SELECT * from kyt_course_master WHERE 1 $extraFilter";
		 $data['courseList'] = $this->Common_model->get_query_result_array($sqlCourse);
				
		// Availability Data
		$sqlAvailability = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name from kyt_availability_records as k 
		                    LEFT JOIN signin_client as c ON c.id = k.teacher_id 
		                    LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id
							WHERE k.course_id = '$courseID' AND k.is_active = '1' AND k.is_approved = '1' ORDER BY k.avail_date, k.avail_start_time";
		$data['availabilityList'] = $availabilityList = $this->Common_model->get_query_result_array($sqlAvailability);

		
		$leaveDates = $this->get_leave_dates();
		$allLeaveDates = $leaveDates['leave']['dates'];
		$allOffDates = $leaveDates['off']['dates'];
		
		$unavailableColor = "#c9c78b";
		$availableColor = "#00a65a";
		$scheduleColor = "#0084e7";
		$leaveColor = "#f94848";
		$partical = "#4D0000";
		
		$data['calendar_result'] = array();
		$data['calendar_result_create'] = array();
		$data['calendar_result_timeup'] = array();
		$data['calendar_result_scheduled'] = array();
		foreach($availabilityList as $token)
		{
			$currentDate = $token['avail_date'];
			$currentStartTime = $token['avail_start_time'];
			$currentEndTime = $token['avail_end_time'];
			$currentSlot = $token['avail_slot'];
			$currentCourse = $token['course_id'];
			$currentTeacher = $token['teacher_id'];
			$currentTeacherName = $token['teacher_name'];
			
			$slotData = $cp_timeSlots[$currentSlot];
			$slot_name = $slotData['slot_name'];
			$slot_statTime = $currentDate ." " .$slotData['start_time'];
			$slot_endTime = $currentDate ." " .$slotData['end_time'];
			
			$c_slot_name = date('h:i A', strtotime($currentStartTime));
			$c_slot_statTime = $currentDate ." " .$currentStartTime;
			$c_slot_endTime = $currentDate ." " .$currentEndTime;
			
			
			$schedule_id = $token['schedule_id'];
			
			$extraAdd = "";
			$checkColor = $availableColor;
			if(!empty($schedule_id)){
				$checkColor = $scheduleColor;  $extraAdd=" (Sch)";
			}
			$flagLeave = false;
			if(!empty($allLeaveDates[$currentTeacher]) && in_array($currentDate, $allLeaveDates[$currentTeacher])){
				$checkColor = $leaveColor; $extraAdd=" (leave)"; $flagLeave = true;
			}
			if(!empty($allOffDates[$currentTeacher]) && in_array($currentDate, $allOffDates[$currentTeacher])){
				$checkColor = $unavailableColor; $extraAdd=" (Off)"; $flagLeave = true;
			}
			if($token['is_leave']==1){
				$checkColor = $partical; $extraAdd=" (leave)"; $flagLeave = true;
			}
			if($flagLeave == false){
				$data['calendar_result_create'][] = [ 
					'title' => $currentTeacherName .$extraAdd,
					'start' => $c_slot_statTime,
					'end' => $c_slot_endTime,
					'is_schedule' => $schedule_id,
					'allDay' =>  false,
					'description' =>  $currentTeacherName .$extraAdd,
					'backgroundColor' => $checkColor
				];
				$data['calendar_result_timeup'][$c_slot_statTime] = [ 
					'title' => $currentTeacherName .$extraAdd,
					'start' => $c_slot_statTime,
					'end' => $c_slot_endTime,
					'is_schedule' => $schedule_id,
					'allDay' =>  false,
					'description' =>  $currentTeacherName .$extraAdd,
					'backgroundColor' => $checkColor
				];
				if(!empty($schedule_id)){
					$data['calendar_result_scheduled'][] = [ 
						'title' => $currentTeacherName .$extraAdd,
						'start' => $c_slot_statTime,
						'end' => $c_slot_endTime,
						'is_schedule' => $schedule_id,
						'allDay' =>  false,
						'description' =>  $currentTeacherName .$extraAdd,
						'backgroundColor' => $checkColor
					];
				}
			}
		}
		
		$getStartTimeCount = array_count_values(array_column($data['calendar_result_create'], 'start'));
		$getStartTimeCount_Scheduled = array_count_values(array_column($data['calendar_result_scheduled'], 'start'));
		//echo'<pre>';print_r($data['calendar_result_timeup']);die();
		foreach($data['calendar_result_timeup'] as $token)
		{
			$currentStartTime = $token['start'];
			$ScheduleCountCheck = !empty($getStartTimeCount_Scheduled[$currentStartTime]) ? $getStartTimeCount_Scheduled[$currentStartTime] : "0";
			$ScheduleCount = !empty($getStartTimeCount_Scheduled[$currentStartTime]) ? " | " .$getStartTimeCount_Scheduled[$currentStartTime] ." Sh" : "";
			$ScheduleCountFull = !empty($getStartTimeCount_Scheduled[$currentStartTime]) ? " | " .$getStartTimeCount_Scheduled[$currentStartTime] ." Scheduled" : "";
			$availCount = !empty($getStartTimeCount[$currentStartTime]) ? $getStartTimeCount[$currentStartTime] : "0";
			$availCountShow = "";
			$checkColor = $scheduleColor;
			$gotCount = $availCount - $ScheduleCountCheck;
			if($gotCount > 0){
				$availCountShow = $gotCount ." Avl";
				$availCountShowFull = $gotCount ." Available";
				$checkColor = $availableColor;
			}
			$dateGot = date('Y-m-d', strtotime($currentStartTime));
			$startTime = date('H:i:s', strtotime($currentStartTime));
			$endTime = date('H:i:s', strtotime($token['end']));
			$linkURL = base_url('kyt/course_calendar_details?date='.$dateGot.'&startTime='.$startTime.'&endTime='.$endTime.'&course_id='.$courseID);
			$data['calendar_result'][] = [ 
				'title' => $availCountShow .$ScheduleCount,
				'start' => $currentStartTime,
				'end' => $token['end'],
				'url' => $linkURL,
				'allDay' =>  false,
				'description' =>  $availCountShowFull.$ScheduleCountFull,
				'backgroundColor' => $checkColor
			];
		}
		//print_r($getStartTimeCount); die();
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function course_calendar_details()
	{

		$date = $this->input->get('date');
		$startTime = $this->input->get('startTime');
		$endTime = $this->input->get('endTime');
		$courseId = $this->input->get('course_id');

		$sql=" SELECT s.*,su.session_type as session_type,su.age_group as age_group,
					su.child_name as child_name,concat(t.fname,' ',t.lname) as teacher_name, t.email_id 
	 				FROM `kyt_availability_records` s 
	 				left join signin_client t on s.teacher_id =t.id 
	 				left join kyt_schedule_upload su on s.schedule_id = su.id 
	 				WHERE s.avail_date='".$date."' and s.avail_start_time='".$startTime."' and s.avail_end_time='".$endTime."' and s.course_id = '".$courseId."' AND s.is_active = '1' AND s.is_approved = '1'";
		$details = $this->Common_model->get_query_result_array($sql);
		$currentTeacher = !empty($details) ? $details[0]['teacher_id'] : "";
		
		if(!empty($currentTeacher)){
			$leaveDates = $this->get_leave_dates();
			$allLeaveDates = $leaveDates['leave']['dates'];
			$allOffDates = $leaveDates['off']['dates'];
		}
		
			
		$availableTable = "";
		$scheduleTable = "";
		$trStyle = ' style=""';
		$thStyle = ' style="font-weight:800;text-align:center;background-color: #ede9e9;"';
		$thStyle2 = ' style="font-weight:800;text-align:left;background-color: #ede9e9;"';
		$tdStyle = ' style="text-align:center"';
		$tdStyle2 = ' style="text-align:left"';
		$tdStyle3 = ' style="text-align:center;background-color: #ede9e9"';
		
		$availableCount = 0;
		$scheduleCount = 0;
		
		
		$availableTable .= '<tr '.$trStyle.'>';
		$availableTable .= '<th '.$thStyle.'>Sl</th>';
		$availableTable .= '<th '.$thStyle2.'>Teacher Name</th>';
		$availableTable .= '<th '.$thStyle.'>Date</th>';
		$availableTable .= '<th '.$thStyle.'>Day</th>';
		$availableTable .= '<th '.$thStyle.'>Start Time</th>';
		$availableTable .= '<th '.$thStyle.'>End Time</th>';
		$availableTable .= '</tr>';
		
		$scheduleTable .= '<tr '.$trStyle.'>';
		$scheduleTable .= '<th '.$thStyle.'>Sl</th>';
		$scheduleTable .= '<th '.$thStyle2.'>Teacher Name</th>';
		$scheduleTable .= '<th '.$thStyle.'>Date</th>';
		$scheduleTable .= '<th '.$thStyle.'>Day</th>';
		$scheduleTable .= '<th '.$thStyle.'>Start</th>';
		$scheduleTable .= '<th '.$thStyle.'>End</th>';
		$scheduleTable .= '<th '.$thStyle.'>Info</th>';
		$scheduleTable .= '</tr>';
		
		$flagLeave = false;
		foreach($details as $key=>$rows)
		{
			$teacherId = $rows['teacher_id'];
			
			if(empty($rows['schedule_id']))
			{
						
				// CHECK LEAVE
				if(!empty($allLeaveDates[$teacherId]) && in_array($date, $allLeaveDates[$teacherId])){
					$flagLeave = true;
				}
				if(!empty($allOffDates[$teacherId]) && in_array($date, $allOffDates[$teacherId])){
					$flagLeave = true;
				}
				if($flagLeave == false){
					$availableCount++;			
					$availableTable .= '<tr '.$trStyle.'>';
					$availableTable .= '<td '.$tdStyle3.'><b>'.$availableCount.'</b></td>';
					$availableTable .= '<td '.$tdStyle2.'><b>'.$rows['teacher_name'].'</b><br/>' .$rows['email_id'].'</td>';
					$availableTable .= '<td '.$tdStyle.'>'.date('d M, Y', strtotime($rows['avail_date'])).'</td>';
					$availableTable .= '<td '.$tdStyle.'>'.$rows['avail_day'].'</td>';
					$availableTable .= '<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['avail_start_time'])).'</td>';
					$availableTable .= '<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['avail_end_time'])).'</td>';;
					$availableTable .= '</tr>';
				}
				
			} else {
				
				$scheduleCount++;				
				$extraInfo = "Schedule : " .$rows['session_type'] ."<br/>Age Group : " .$rows['age_group'] ."<br/>" .$rows['child_name'];
				$scheduleTable .= '<tr '.$trStyle.'>';
				$scheduleTable .= '<td '.$tdStyle3.'><b>'.$scheduleCount.'</b></td>';
				$scheduleTable .= '<td '.$tdStyle2.'><b>'.$rows['teacher_name'].'</b><br/>' .$rows['email_id'].'</td>';
				$scheduleTable .= '<td '.$tdStyle.'>'.date('d M, Y', strtotime($rows['avail_date'])).'</td>';
				$scheduleTable .= '<td '.$tdStyle.'>'.$rows['avail_day'].'</td>';
				$scheduleTable .= '<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['avail_start_time'])).'</td>';
				$scheduleTable .= '<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['avail_end_time'])).'</td>';
				$scheduleTable .= '<td '.$tdStyle.'>'.$extraInfo.' </td>';
				$scheduleTable .= '</tr>';
			}
		}
		
		echo '<div style="background-color: #f7f7f7;padding: 32px 20px;">';
		echo '<span style="font-size:20px;color:#60ea60"><b>Available - '. $availableCount.'</b></span>';
		echo "<br/>";
		if($availableCount > 0){
			echo'<table style="width:100%">';
			echo $availableTable;
			echo'</table>';
		}
		echo "<br/><hr/><br/>";
		
		echo '<span style="font-size:20px;color:blue"><b>Scheduled - '. $scheduleCount.'</b></span>';
		echo "<br/>";
		if($scheduleCount > 0){
			echo'<table style="width:100%">';
			echo $scheduleTable;		
			echo'</table>';
		}
			
		echo "</div>";
	}
	
	
	
	public function teacher_calendar_details()
	{
		// Availability ID 
		$availID = "0"; $extraFilter = "";
		if(!empty($this->input->get('cid'))){		
			$availID = $this->input->get('cid');
		}
		if(!empty($this->uri->segment(3))){		
			$availID = $this->uri->segment(3);			
		}
		
		$sql1 =" SELECT t.*,su.session_type as session_type,su.age_group as age_group,su.child_name as child_name,
		            concat(c.fname,' ',c.lname)as teacher_name,cr.name as course_name  
					FROM `kyt_availability_records` t 
					left join signin_client c on t.teacher_id=c.id 
					left join  kyt_course_master cr on t.course_id = cr.id 
					left join  kyt_schedule_upload su on t.schedule_id = su.id
				     WHERE t.id = '".$availID ."'";
		$details = $this->Common_model->get_query_result_array($sql1);
		
		
		if(!empty($details[0]['teacher_id'])){
			$teacherDate = $details[0]['avail_date'];
			$teacherID = $details[0]['teacher_id'];
			$leaveDates = $this->get_leave_dates($teacherID);
			$allLeaveDates = $leaveDates['leave']['dates'];
			$allOffDates = $leaveDates['off']['dates'];
			$flagLeave = false;
			$flagOff = false;
			if(!empty($allLeaveDates[$teacherID]) && in_array($teacherDate, $allLeaveDates[$teacherID])){
				$flagLeave = true;
			}
			if(!empty($allOffDates[$teacherID]) && in_array($teacherDate, $allOffDates[$teacherID])){
				$flagOff = true;
			}
			if($details[0]['is_leave']==1){
				$flagLeave = true;
			}
		}

		
		$trStyle = ' style=""';
		$thStyle = ' style="font-weight:800;text-align:right"';
		$tdStyle = ' style="padding-left:30px"';
		
		$t_Status = '<span style="color:green"><b>Available</b></span>';
		
		if($flagLeave == true){ $t_Status = '<span style="color:red"><b>Leave</b></span>'; }
		if($flagOff == true){ $t_Status = '<span style="color:red"><b>Off</b></span>'; }
		
		echo '<div style="background-color: #f7f7f7;padding: 32px 20px;">';
		echo'<table>';
		foreach($details as $key=>$rows){
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Teacher Name</th>';
			echo'<td '.$tdStyle.'>'.$rows['teacher_name'].'</td>';
			echo'</tr>';
			
			/*echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Course</th>';
			echo'<td '.$tdStyle.'>'.$rows['course_name'].'</td>';
			echo'</tr>';*/
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Availability Date</th>';
			echo'<td '.$tdStyle.'>'.date('d M, Y', strtotime($rows['avail_date'])).'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Availability Day</th>';
			echo'<td '.$tdStyle.'>'.$rows['avail_day'].'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Start Time</th>';
			echo'<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['avail_start_time'])).'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>End Time</th>';
			echo'<td '.$tdStyle.'>'.date('h:i A', strtotime($rows['avail_end_time'])).'</td>';
			echo'</tr>';
			
			if(!empty($rows['schedule_id'])){
				
			$t_Status = '<span style="color:red"><b>Scheduled</b></span>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Session_type</th>';
			echo'<td '.$tdStyle.'>'.$rows['session_type'].'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Age Group</th>';
			echo'<td '.$tdStyle.'>'.$rows['age_group'].'</td>';
			echo'</tr>';
			
			echo'<tr '.$trStyle.'>';
			echo'<th '.$thStyle.'>Child Name</th>';
			echo'<td '.$tdStyle.'>'.$rows['child_name'].'</td>';
			echo'</tr>';
			
			}

		}
		echo'</table>';
		echo'<hr/>';
		
		echo'<table>';
		echo'<tr '.$trStyle.'>';
		echo'<th '.$thStyle.'>Status</th>';
		echo'<td '.$tdStyle.'>'.$t_Status.'</td>';
		echo'</tr>';
		echo'</table>';
		
		echo'<hr/>';
		echo '</div>';
	}
	
	
	
	//===========================================================================================================//
	// AVAILABLE REPORT
	//==========================================================================================================//
		
	public function generate_available_reports($from_date ='', $to_date='', $teacher_id='')
	{
		$current_user = get_user_id();
		$qstdate = date('d/m/Y',strtotime($this->input->get('date_from')));
		$qeddate = date('d/m/Y',strtotime($this->input->get('date_to')));
		$teacher_id = $this->input->get('teacher_id');
		$con="";
		 if($_GET['date_from']!=""){
			$con.= "and k.avail_date>='".date('Y-m-d',strtotime($_GET['date_from']))."'";
		 }
		 if($_GET['date_to']!=""){
			$con.= "and k.avail_date<='".date('Y-m-d',strtotime($_GET['date_to']))."'";
		 }
		 if(empty($teacher_id)){
			 $teacher_id = $this->input->get('teacher_id');
		 }
		 if(!empty($teacher_id)&&(get_role()!='teacher')){
			$con.= "and k.teacher_id = '$teacher_id'";
		 }		 
		 if(get_role()=='teacher'){
			 if(empty($teacher_id)){
				$con.= "and k.teacher_id = '$current_user'";
			 }
		 }

		$sqlcase = "SELECT k.*, s.email_id, CONCAT(s.fname,' ', s.lname) as teacher_name,c.name as course_name  
		from kyt_availability_records k 
		left join `signin_client` s on s.id=k.teacher_id 
		left join kyt_course_master c on c.id=k.course_id 
	    WHERE s.role='teacher' AND s.status = '1' AND s.allow_kyt = '1' and k.is_active=1 and is_leave=0 $con
		ORDER BY k.avail_date,k.avail_start_time";
		$crm_list = $this->Common_model->get_query_result_array($sqlcase);

		$leaveDates = $this->get_leave_dates();
		$allLeaveDates = $leaveDates['leave']['dates'];
		$allOffDates = $leaveDates['off']['dates'];

		//echo'<pre>';print_r($allOffDates);die();

		$title = "KYT";
		$sheet_title = "KYT - Available_teachers";
		$file_name = "KYT_Available_Teachers";
		
		//==================================  generate CSV file code start ==============================================//
		
		    $filename = $file_name.'.csv'; 
   			header("Content-Description: File Transfer"); 
   			header("Content-Disposition: attachment; filename=$filename"); 
   			header("Content-Type: application/csv; ");
		    $header = array("Sl", "Teacher Name", "Course", "Date", "Day", "Start Time", "End Time", "Email address");

			
			$file = fopen('php://output', 'w');
   			fputcsv($file, $header);
				$i=0; 
			   foreach($crm_list as $key => $val){
				   $teacherID = $val['teacher_id'];
				   if((!in_array($val['avail_date'],$allOffDates[$teacherID]))&&(!in_array($val['avail_date'],$allLeaveDates[$teacherID]))){
						$body=array();
						$body[] = ++$i;
						$body[] = $val["teacher_name"];
						$body[] = $val["course_name"];
						$body[] = $val["avail_date"];
						$body[] = $val["avail_day"];
						$body[] = $val["avail_start_time"];
						$body[] = $val["avail_end_time"];
						$body[] = $val["email_id"];
						fputcsv($file, $body);
						
				   }

			   }
				
			fclose($file); 
   			exit;		
	}
	
	
	//===========================================================================================================//
	// COURSE MASTER
	//==========================================================================================================//
	
	public function course_master()
	{
        $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt/ldc_aside.php";
		 $data["content_template"] = "kyt/kyt_courseMaster.php";
		 		 
		 $sql_leave = "Select * from kyt_course_master where is_active = 1";
		 $leave_data = $this->Common_model->get_query_result_array($sql_leave);															 
		 $data['courseMaster'] = $leave_data;
		 
		 $data["content_js"] = "kyt/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);	  
    }

    public function add_course(){		
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');	
		$edit_id = $this->input->post('edit_id');
		if(!empty($edit_id)){
			$this->db->where('id',$edit_id);
			$this->db->update('kyt_course_master',$data);
		} else {
			$this->db->insert('kyt_course_master',$data);		
			$insert_id = $this->db->insert_id();
		}	
        redirect($_SERVER['HTTP_REFERER']); 
    }
    
	public function delete_course(){
		if(check_logged_in()){  
			$id = $this->input->get('id');
			$data_array = array( "is_active" => "0" );
			$this->db->where('id',$id);		
			$this->db->update('kyt_course_master', $data_array);                
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function level_master()
	{
        $current_user = get_user_id();
		 $user_site_id= get_user_site_id();
		 $user_office_id= get_user_office_id();
		 $user_oth_office=get_user_oth_office();
		 $is_global_access=get_global_access();
		 $is_role_dir=get_role_dir();
		 $get_dept_id=get_dept_id();
		 
		 $data['currentDate'] = CurrDate();
		 
		 $data['is_role_dir'] = $is_role_dir;
		 $data["aside_template"] = "kyt/ldc_aside.php";
		 $data["content_template"] = "kyt/kyt_levelMaster.php";
		 		 
		 $sql_leave = "Select * from kyt_level_master where status='A'";
		 $leave_data = $this->Common_model->get_query_result_array($sql_leave);															 
		 $data['levelMaster'] = $leave_data;
		 
		 $data["content_js"] = "kyt/kyt_crm_js.php";
		 $this->load->view('dashboard',$data);	  
    }

	public function add_level(){		
        $data['name'] = $this->input->post('name');
		$edit_id = $this->input->post('edit_id');
		if(!empty($edit_id)){
			$this->db->where('id',$edit_id);
			$this->db->update('kyt_level_master',$data);
		} else {
			$this->db->insert('kyt_level_master',$data);		
			$insert_id = $this->db->insert_id();
		}	
        redirect($_SERVER['HTTP_REFERER']); 
    }
    
	public function delete_level(){
		if(check_logged_in()){  
			$id = $this->input->get('id');
			$data_array = array( "status" => "D" );
			$this->db->where('id',$id);		
			$this->db->update('kyt_level_master', $data_array);                
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	
	
	public function send_email(){
		//echo $v_createdDate = date('Ymd\THis\Z');
		echo date('Y-m-d H:i:s');
		
		$scheduleStartDate = "2021-02-24 10:30:00";
		$scheduleEndDate = "2021-02-24 11:30:00";
		
		date_default_timezone_set('Asia/Kolkata');

		// VCARD DATES
		$v_Location = "KYT ACADEMY";
		echo "<br/>V-" .$v_createdDate = date('Ymd\THis\Z');
		echo "<br/>End - " .$v_scheduleStartDate = date('Ymd\THis\Z', strtotime($scheduleStartDate));
		echo "<br/>Start - " .$v_scheduleEndDate = date('Ymd\THis\Z', strtotime($scheduleEndDate));
		
		
		
		$this->Kyt_model->send_ical_email();
		echo "<br/>NOW -" .date('Y-m-d H:i:s');
	}
	
	
	//===========================================================================================================//
	// REQUIRED FUNCTIONS
	//==========================================================================================================//
	 
	private function get_leave_dates($teacherID = '', $type = 'all', $timeInfo = NULL)
	{
		$extraFilter = "";
		$overallDates = array();
		$leaveDates = array();
		$offDates = array();
		if(!empty($teacherID)){
			$extraFilter = " AND employee_id = '$teacherID' ";
		}
		
		if(!empty($timeInfo)){
			$startSearch = $timeInfo['start'];
			$endSearch = $timeInfo['end'];
			//$extraFilter .= " AND (from_date >= '$startSearch' AND to_date <= '$endSearch')";
		}
		$leave_sql = "SELECT * from kyt_leave_master WHERE 1 $extraFilter AND applied_from = 'leave' and status ='approved'";
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
	 
	 
	 
	 
	 //==========================================report==================================//
	 public function teacher_given_hours(){

			 // Prediefined
			 $data['current_user'] = $current_user = get_user_id();
			 $data['current_role'] = $current_role = get_role();
			 $data['current_date'] = $current_date = CurrMySqlDate();
			 
			 // Content Pages
			 $data["aside_template"] = "kyt/ldc_aside.php";
			 $data["content_template"] = "kyt/ldc_teacher_given_hours.php";
			 $data["content_js"] = "kyt/ldc_master_js.php";

			$teachersDataSql = "SELECT * from signin_client WHERE  role='teacher'";
		    $data['teachersData'] = $this->Common_model->get_query_result_array($teachersDataSql);

			  $teacher_id =$this->input->get('teacher_id');
			 if($teacher_id!=''){
				$sql = "SELECT k.*,(select count(id) from `kyt_availability_records` where teacher_id='".$teacher_id."' and avail_date =k.avail_date)as cont FROM `kyt_availability_records` k where teacher_id='".$teacher_id."' group by avail_date";
				$data['tech'] = $this->Common_model->get_query_result_array($sql);
				
			 }	
			 $this->load->view('dashboard',$data);
	 }
	 
	 
	  //==================================================================================//
	  //   REPORTS ANALYTICS
	  //==================================================================================//
	  
	  public function teacher_hourly_report()
	  {
			 // Prediefined
			 $data['current_user'] = $current_user = get_user_id();
			 $data['current_role'] = $current_role = get_role();
			 $data['current_date'] = $current_date = CurrMySqlDate();
			 
			 // Content Pages
			 $data["aside_template"] = "kyt/ldc_aside.php";
			 $data["content_template"] = "kyt/ldc_teacher_hourly_report.php";
			 $data["content_js"] = "kyt/kyt_graph_js.php";

			$teachersDataSql = "SELECT * from signin_client WHERE  role='teacher'";
		    $data['teachersData'] = $this->Common_model->get_query_result_array($teachersDataSql);
			
			// GET SEARCH
			$gotMonth = $this->input->get('monthSelect');
			$gotYear = $this->input->get('yearSelect');
			$gotTeacher = $this->input->get('teacher_id');
			
			if(!empty($gotMonth) && !empty($gotYear) && !empty($gotTeacher))
			{
				$data['gotMonth'] = $gotMonth;
				$data['gotYear'] = $gotYear;
				$data['gotTeacher'] = $gotTeacher;			
			} else {
				$data['gotMonth'] = date('m');
				$data['gotYear'] = date('Y');
				$data['gotTeacher'] = '';
			}
			
			$maxDay = cal_days_in_month(CAL_GREGORIAN, $gotMonth, $gotYear); 
			$data['report'] = false;
			if(!empty($gotMonth) && !empty($gotYear) && !empty($gotTeacher))
			{
				$data['report'] = true;
				$startDay = $gotYear ."-" .sprintf('%02d', $gotMonth) ."-" ."01";
				$endDay = $gotYear ."-" .sprintf('%02d', $gotMonth) ."-" .$maxDay;
				
				$leaveDates = $this->get_leave_dates($gotTeacher);
				$allLeaveDates = $leaveDates['leave']['dates'];
				$allOffDates = $leaveDates['off']['dates'];
				
				$dayReport = array(); $totalAvaibaleSeconds = 0; $totalScheduleSeconds = 0; 
				$sqlReport = "SELECT k.*, TIME_TO_SEC(TIMEDIFF(CONCAT(k.avail_date, ' ', k.avail_end_time), CONCAT(k.avail_date, ' ', k.avail_start_time))) as total_seconds, 
				CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name
				from kyt_availability_records as k 
				LEFT JOIN signin_client as c ON c.id = k.teacher_id
				LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id
				WHERE k.teacher_id='$gotTeacher' AND k.avail_date >= '$startDay' AND k.avail_date <= '$endDay' AND k.is_active = '1' AND k.is_approved = '1'";
				$resultArray = $this->Common_model->get_query_result_array($sqlReport);
				foreach($resultArray as $token)
				{
					$currentDay = $token['avail_date'];
					$currentTime = $token['total_seconds'];
					$currentTeacher = $token['teacher_id'];
					$currentTeacherName = $token['teacher_name'];
					$currentCourseName = $token['course_name'];
					
					$flagLeave = false;
					if(!empty($allLeaveDates[$gotTeacher]) && in_array($currentDay, $allLeaveDates[$gotTeacher])){
						$flagLeave = true;
					}
					if(!empty($allOffDates[$gotTeacher]) && in_array($currentDay, $allOffDates[$gotTeacher])){
						$flagLeave = true;
					}				
					if($flagLeave == false)
					{
						$totalAvaibaleSeconds = $totalAvaibaleSeconds + $currentTime;
						$dayReport[$currentDay][$currentTeacher]['all'][] = $currentTime;					
						if(!empty($token['schedule_id'])){
							 $totalScheduleSeconds =  $totalScheduleSeconds + $currentTime;
							$dayReport[$currentDay][$currentTeacher]['schedule'][] = $currentTime;
						}			
					}					
				}
			}

			$data['reporting'] = $dayReport;
			$data['overall'][$currentTeacher]['available'] = $totalAvaibaleSeconds;
			$data['overall'][$currentTeacher]['schedule'] = $totalScheduleSeconds;
			$data['maxDay'] = $maxDay;
			
			$overaalUtilistaion = 0;
			$diffTime = $totalAvaibaleSeconds - $totalScheduleSeconds;
			if($diffTime > 0)
			{
				$overaalUtilistaion = ($totalScheduleSeconds/$totalAvaibaleSeconds) * 100;
			}
			$data['overall'][$currentTeacher]['utilise'] = $overaalUtilistaion;
			//print_r($dayReport);die();
			
			$this->load->view('dashboard',$data);
	 }
	 
	 
	 
	 
	  public function teacher_overview_report()
	  {
			 // Prediefined
			 $data['current_user'] = $current_user = get_user_id();
			 $data['current_role'] = $current_role = get_role();
			 $data['current_date'] = $current_date = CurrMySqlDate();
			 
			 // Content Pages
			 $data["aside_template"] = "kyt/ldc_aside.php";
			 $data["content_template"] = "kyt/ldc_teacher_utilise_report.php";
			 $data["content_js"] = "kyt/kyt_graph_js.php";

			$teachersDataSql = "SELECT * from signin_client WHERE  role='teacher' AND status = '1'";
		    $data['teachersData'] = $this->Common_model->get_query_result_array($teachersDataSql);
		    $data['teachersDataIndex'] = $this->array_indexed($data['teachersData'], 'id');
			
			// GET SEARCH
			$gotStart = $this->input->get('start_date');
			$gotEnd = $this->input->get('end_date');
			
			if(!empty($gotStart) && !empty($gotEnd))
			{
				$data['gotStart'] = $gotStart;
				$data['gotEnd'] = $gotEnd;		
			} else {
				$gotMonth = date('m');
				$gotYear = date('Y');
				$maxDay = cal_days_in_month(CAL_GREGORIAN, $gotMonth, $gotYear);
				$data['gotStart'] = $gotYear ."-" .sprintf('%02d', $gotMonth) ."-" ."01";
				$data['gotEnd'] = $gotYear ."-" .sprintf('%02d', $gotMonth) ."-" .$maxDay;
			}
			
			$data['report'] = false;
			if(!empty($gotStart) && !empty($gotEnd))
			{
				$data['report'] = true;
				$startDay = date('Y-m-d', strtotime($gotStart));
				$endDay = date('Y-m-d', strtotime($gotEnd));
				
				
				
				$gotLeave = array(); $gotTeacherArray = array(); $overviewReport = array();
				$dayReport = array(); $totalAvaibaleSeconds = 0; $totalScheduleSeconds = 0; 
				$sqlReport = "SELECT k.*, TIME_TO_SEC(TIMEDIFF(CONCAT(k.avail_date, ' ', k.avail_end_time), CONCAT(k.avail_date, ' ', k.avail_start_time))) as total_seconds, 
				CONCAT(c.fname, ' ', c.lname) as teacher_name, mc.name as course_name
				from kyt_availability_records as k 
				LEFT JOIN signin_client as c ON c.id = k.teacher_id
				LEFT JOIN kyt_course_master as mc ON mc.id = k.course_id
				WHERE k.avail_date >= '$startDay' AND k.avail_date <= '$endDay' AND k.is_active = '1' AND k.is_approved = '1'";
				$resultArray = $this->Common_model->get_query_result_array($sqlReport);
				foreach($resultArray as $token)
				{
					
					
					$currentDay = $token['avail_date'];
					$currentTime = $token['total_seconds'];
					$currentTeacher = $token['teacher_id'];
					$currentTeacherName = $token['teacher_name'];
					$currentCourseName = $token['course_name'];
					$gotTeacherArray[$currentTeacher] = $data['teachersDataIndex'][$currentTeacher];
					$gotTeacher = $currentTeacher;
					
					if(empty($gotLeave[$currentTeacher]))
					{
						$leaveDates[$currentTeacher] = $this->get_leave_dates($currentTeacher);
						$allLeaveDates[$currentTeacher] = $leaveDates[$currentTeacher]['leave']['dates'][$currentTeacher];
						$allOffDates[$currentTeacher] = $leaveDates[$currentTeacher]['off']['dates'][$currentTeacher];
						$gotLeave[$currentTeacher] = 1;
					}
					
					$flagLeave = false;
					if(!empty($allLeaveDates[$gotTeacher]) && in_array($currentDay, $allLeaveDates[$gotTeacher])){
						$flagLeave = true;
					}
					if(!empty($allOffDates[$gotTeacher]) && in_array($currentDay, $allOffDates[$gotTeacher])){
						$flagLeave = true;
					}				
					if($flagLeave == false)
					{
						$totalAvaibaleSeconds = $totalAvaibaleSeconds + $currentTime;
						$dayReport[$currentDay][$currentTeacher]['all'][] = $currentTime;					
						$overviewReport[$currentTeacher]['all'][] = $currentTime;					
						if(!empty($token['schedule_id'])){
							 $totalScheduleSeconds =  $totalScheduleSeconds + $currentTime;
							$overviewReport[$currentTeacher]['schedule'][] = $currentTime;
						}			
					}					
				}
				
			}

			$data['reporting'] = $dayReport;
			$data['overview'] = $overviewReport;
			$data['teacherArray'] = $gotTeacherArray;
			
			$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
			$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
			$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
			$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
			$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
			
			//echo "<pre>".print_r($data,1)."</pre>"; die();
			
			$this->load->view('dashboard',$data);
	 }
	 
	 
	 
	 public function teacher_leave_report()
	 {
			 // Prediefined
			 $data['current_user'] = $current_user = get_user_id();
			 $data['current_role'] = $current_role = get_role();
			 $data['current_date'] = $current_date = CurrMySqlDate();
			 
			 // Content Pages
			 $data["aside_template"] = "kyt/ldc_aside.php";
			 $data["content_template"] = "kyt/ldc_teacher_leave_report.php";
			 $data["content_js"] = "kyt/kyt_graph_js.php";

			$teachersDataSql = "SELECT * from signin_client WHERE  role='teacher' AND status = '1'";
		    $data['teachersData'] = $this->Common_model->get_query_result_array($teachersDataSql);
		    $data['teachersDataIndex'] = $this->array_indexed($data['teachersData'], 'id');
			
			// GET SEARCH
			$gotStart = $this->input->get('start_date');
			$gotEnd = $this->input->get('end_date');
			
			if(!empty($gotStart) && !empty($gotEnd))
			{
				$data['gotStart'] = $gotStart;
				$data['gotEnd'] = $gotEnd;		
			} else {
				$gotMonth = date('m');
				$gotYear = date('Y');
				$maxDay = cal_days_in_month(CAL_GREGORIAN, $gotMonth, $gotYear);
				$data['gotStart'] = $gotYear ."-" .sprintf('%02d', $gotMonth) ."-" ."01";
				$data['gotEnd'] = $gotYear ."-" .sprintf('%02d', $gotMonth) ."-" .$maxDay;
			}
			
			$data['report'] = false;
			if(!empty($gotStart) && !empty($gotEnd))
			{
				$data['report'] = true;
				$startDay = date('Y-m-d', strtotime($gotStart));
				$endDay = date('Y-m-d', strtotime($gotEnd));
								
				$leaveDates = array(); $teacherArray = array(); $overallDates = array();
				$sqlReport = "SELECT k.*, CONCAT(c.fname, ' ', c.lname) as teacher_name
				from kyt_leave_master as k 
				LEFT JOIN signin_client as c ON c.id = k.employee_id
				WHERE k.from_date >= '$startDay' AND k.to_date <= '$endDay' AND k.applied_from = 'leave'";
				$resultArray = $this->Common_model->get_query_result_array($sqlReport);
				foreach($resultArray as $token)
				{
					$employeeID = $token['employee_id'];
					$fromDate = $token['from_date'];
					$toDate = $token['to_date'];
					$teacherArray[$employeeID] = $token;
					if(strtotime($toDate) >= strtotime($fromDate))
					{
						$currentDay = $fromDate; $counter = 0;
						while(strtotime($currentDay) <= strtotime($toDate))
						{
							$leaveDates[$employeeID][] = $currentDay;
							$overallDates[$employeeID][] = $currentDay;
							$counter++;
							$currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
							if($counter > 365){
								show_error('Something is Wrong!');
							}
						}
					}					
				}
				
			}

			$data['leaveDates'] = $leaveDates;
			$data['overallDates'] = $overallDates;
			$data['teacherArray'] = $teacherArray;
			
			$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
			$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
			$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
			$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
			$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
			
			//echo "<pre>".print_r($data,1)."</pre>"; die();
			
			$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
			$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
			$this->load->view('dashboard',$data);
	 }
	 
	 
	 
	 //==================================================================================//
	  //   CRON CHECK
	  //==================================================================================//
	 
	 
	 public function cron_notification_schedule_class()
	 {
			date_default_timezone_set('Asia/Kolkata');
			$today = date('Y-m-d');
			$notifyTime = date('H:i:s', strtotime('+15 min', strtotime("now")));
	
			echo $sqlCheckSchedule = "SELECT k.*, CONCAT(s.fname, ' ', s.lname) as teacher_name, s.email_id, c.name as course_name 
			from kyt_availability_records as k 
			LEFT JOIN kyt_schedule_upload as sd ON sd.id = k.schedule_id
			LEFT JOIN signin_client as s ON s.id = k.teacher_id
			LEFT JOIN kyt_course_master as c ON c.id = k.course_id
			WHERE k.avail_date = '$today' AND '$notifyTime' >= k.avail_start_time 
			AND (k.schedule_id IS NOT NULL AND k.schedule_id <> '') 
			AND k.is_notify = '0' AND k.is_approved = '1'";
			$queryCheckSchedule = $this->Common_model->get_query_result_array($sqlCheckSchedule);
			foreach($queryCheckSchedule as $token)
			{
				$e_info = array();
				$e_info['email_id'] = $token['email_id'];
				$e_info['teacher_name'] = $token['teacher_name'];
				$e_info['course_name'] = $token['course_name'];
				$e_info['start_time'] = $token['avail_start_time'];
				$e_info['end_time'] = $token['avail_end_time'];
				$e_info['avail_date'] = $token['avail_date'];
				$e_info['avail_day'] = $token['avail_day'];
				
				$this->Kyt_model->notify_teacher_mail_alert($token['email_id'], $token['teacher_name'], $e_info);
				$dataUpdate = [ "is_notify" => 1 ];
				$this->db->where('id', $token['id']);
				$this->db->update('kyt_availability_records', $dataUpdate);
			}
	 }
	 
	//  add availability admin
	public function add_availability_admin()
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
		 $data["content_template"] = "kyt/add_availability_admin.php";
		 
		 
 
		 $sqlTeacher = "SELECT * from signin_client WHERE role='teacher'";
		 $data['teachersgroup'] = $this->Common_model->get_query_result_array($sqlTeacher);
		 $data['time_slots']	= $this->Kyt_model->get_slots_list();
		 
		 $data["content_js"] = "kyt/ldc_master_js.php";
		 $this->load->view('dashboard',$data);
	  
	 }
	 
	 
	 
	 //==================================================================================//
	 //   KYT TEACHER
	 //==================================================================================//
	 
	 
	function upload_teachers()
	{
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Content Pages
         $data["aside_template"] = "kyt/ldc_aside.php";
         $data["content_template"] = "kyt/ldc_upload_teachers.php";
         $data["content_js"] = "kyt/ldc_upload_js.php";
		 
		 $data['client_list'] = $this->Common_model->get_client_list();
		$data['process_list'] = $this->Common_model->get_process_for_assign();
		$data['location_list'] = $this->Common_model->get_office_location_list();
			
		 if(get_login_type() == 'client'){
			$data['client_list'] = $this->Client_model->get_my_client_list();
			$data['process_list'] = $this->Client_model->get_my_process_list();
		}
		
		// UPLOAD CHECK
		$uploadData = array();
		if(!empty($this->input->post('upload_file')))
		{
			$outputFile = FCPATH ."uploads/schedule_log_file/";
			$config = [
				'upload_path'   => $outputFile,
				'allowed_types' => 'csv',
				'max_size' => '1024000',
			];
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->overwrite = true;
			if (!$this->upload->do_upload('userfile'))
			{
				redirect($_SERVER['HTTP_REFERER']);
			}			
			$upload_data = $this->upload->data();
			$file_name = $outputFile .$upload_data['file_name'];
			
			$uploadData = $this->import_teachers($file_name);	
			
			redirect($_SERVER['HTTP_REFERER']);
			//echo "GOT IT";
			//echo "<pre>".print_r($uploadData, 1)."</pre>";
			//die();
		}
        
		$data['uploadData'] = $uploadData;
		
		

		$this->load->view('dashboard',$data);
	}
	
	
	function import_teachers($fileName)
	{
		 // Prediefined
		 $data['current_user'] = $current_user = get_user_id();
		 $data['current_role'] = $current_role = get_role();
		 $data['current_date'] = $current_date = CurrMySqlDate();
		 
		 // Presets		 		 
		 $courseArray = $this->Kyt_model->get_course_master_data();
		 $cp_courseName = $this->array_indexed($courseArray, 'name');
		 
		 $office_id = $this->input->post('office_id');
		 $multiple_office_id = implode(',', $office_id);
		 
		 $client_id = $this->input->post('client_id');
		 $process_id = $this->input->post('process_id'); 
		 
		 $csvRelation = [
			"email" => '0',
			"fname" => '1',
			"lname" => '2',
			"phno" => '3',
			"course" => '4'
		 ];
		 
		 //======= GET CSV DATA
		 $csvData = array();
		 $headerData = array();
		 $handle = fopen($fileName, "r");
		 $counter=0;
         while (($result = fgetcsv($handle)) !== false)
		 {
			$counter++;
			if($counter == 1){
				$headerData = $result;
			} else {
				$csvData[] = array_map('trim', $result);
			}
		 }		
		 //echo "<pre>".print_r($csvData, 1)."</pre>";
		 
		 $checkerArray = array();
		 $teachersCSV = array();
		 
		 //========  CHECK COURSE DATA
		 $courseFlag = true;
		 
		 #-- Course
		 $relationEmail = $csvRelation['course'];
		 $courseNames = array_unique(array_column($csvData, $relationEmail));
		 //echo "<pre>".print_r($courseNames, 1)."</pre>";
		 foreach($courseNames as $token){
			 //echo "<br/>" .$cp_courseName[$token]['name'];
			 if(empty($cp_courseName[$token])){
				  $courseFlag = false;
			 }
		 }
		 
		 if($courseFlag != false){
			 foreach($csvData as $token)
			 {
				  if(!empty($cp_courseName[$token[$csvRelation['course']]])){
					
					$sqlCheck = "SELECT * from signin_client WHERE email_id = '".$token[$csvRelation['email']]."'";
					$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
					if(empty($queryCheck))
					{

						$_field_array = array(
							"office_id" =>  $multiple_office_id,
							"passwd" => 'fusion@123',
							"fname" => $token[$csvRelation['fname']],
							"lname" => $token[$csvRelation['lname']],
							"sex" => 'Male',
							"client_id" => $client_id,
							"process_id" => $process_id,
							"email_id" => $token[$csvRelation['email']],
							"phno" => $token[$csvRelation['phno']],
							"dob" => '2000-01-01',
							"role" => 'teacher',				
							"allow_kyt" => '1',
							"status" => '1',
						  );
						  $rowid = data_inserter('signin_client',$_field_array);
						  $infoArray = [
							"user_id" => $rowid,
							"course_id" => $cp_courseName[$token[$csvRelation['course']]]['id'],
						 ];
						 data_inserter('info_personal_client',$infoArray);
					}			   
					  
				  }		  
				  
			 }			 
		 }		 
	}
	public function get_session_type($id){
		//$id = $this->input->get('id');
		$sql="select session_type from kyt_schedule_upload where id='".$id."'";
		$dt = $this->Common_model->get_query_result_array($sql);
		return $dt[0]['session_type'];
	}
	
	
	
	
	//==================== MODIFY ADD SINGEL AVAILABILITY ==============================//
		
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
			 
			$slotsSql = "SELECT * from kyt_slots ORDER by start_time";
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
			$cr_id = $this->Common_model->get_single_value($slqCourse);
			$course = explode(",",$cr_id);
			$course_id =  $course[0];
			
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
								"is_additional" => 1,
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
								"is_additional" => 1,
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
	
}