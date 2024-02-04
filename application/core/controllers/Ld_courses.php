<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ld_courses extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->load->model('Ld_courses_model');
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
//==========================================================================================
///=========================== L&D COURSES  REGISTRATION ================================///

    public function index(){		 		
		redirect(base_url()."ld_courses/registration");	 
	}
	 	
		
	public function generate_registration_id()
	{
		$sql = "SELECT count(*) as value from ld_registrations ORDER by id DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		//mt_rand(11,99) 
		$new_crm_id = "LDREG" .sprintf('%06d', $lastid + 1);
		return $new_crm_id;
	}
	
	public function course_calendar()
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
		
		$data["course_list"] = $this->info_courses_list();
		$data["calendar_list"] = $this->master_calendar_list();
		
		$data["aside_template"] = "ld_courses/aside.php";
		$data["content_template"] = "ld_courses/ld_courses_calendar.php";				
		$data["content_js"] = "ld_courses/ld_courses_registration_list_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	public function registration()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
				
		$data['agent_details'] = $this->info_agent_details($current_user);
		
		$data['crmid'] = $this->generate_registration_id();
		$data['currentDate'] = $currentDate = CurrDate();	

		$data['course_list'] = $this->info_courses_list();
		$data['office_list'] = $this->info_office_list();
		$data['site_list'] = $this->info_site_list();
		$data['role_list'] = $this->info_role_list();
		$data['department_list'] = $this->info_department_list();
		//$data['supervisor_list'] = $this->info_supervisor_list();
		
		$sqlRegData = "SELECT r.*, c.course_name, l.batch_name, l.batch_start_date from ld_registrations as r 
		               LEFT JOIN ld_courses as c ON c.id = r.course_id 
					   LEFT JOIN ld_courses_calendar as l ON r.schedule_id = l.id
					   WHERE user_id = '$current_user' ORDER by id DESC";
		$queryRegData = $this->Common_model->get_query_result_array($sqlRegData);
		$data['infoSubmission'] = 0;
		$data['infoSubmissionDetails'] = array();
		if(!empty($queryRegData)){
			$data['infoSubmission'] = 1;
			$data['infoSubmissionDetails'] = $queryRegData[0];
		}
		
		
		$data["aside_template"] = "ld_courses/aside.php";
		$data["content_template"] = "ld_courses/ld_courses_registration_form.php";				
		$data["content_js"] = "ld_courses/ld_courses_registration_list_js.php";				
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function info_agent_details($userID)
	{
		$sql = "SELECT s.*, CONCAT(s.fname, ' ' , s.lname) as agent_name, CONCAT(l.fname, ' ' , l.lname) as l1_supervisor_name, r.name as designation, d.shname as department, 
		        p.email_id_off as office_email_id, p.email_id_per as personal_email_id, lp.email_id_off as l1_office_email_id, lp.email_id_per as l1_personal_email_id		         
		        from signin as s 
				LEFT JOIN signin as l ON l.id = s.assigned_to 
				LEFT JOIN department as d ON d.id = s.dept_id 
				LEFT JOIN role as r ON r.id = s.role_id 
				LEFT JOIN info_personal as p ON p.id = s.id 
				LEFT JOIN info_personal as lp ON lp.id = l.id 
				WHERE (s.id = '$userID' OR s.fusion_id = '$userID')";
		$query = $this->Common_model->get_query_row_array($sql);
		return $query;
	}
	
	public function info_courses_list()
	{
		$sql = "SELECT * from ld_courses WHERE is_active = '1'";
		$query = $this->Common_model->get_query_result_array($sql);
		return $query;
	}
	
	public function info_courses_batch_list($courseID = "")
	{
		$courseID = $this->input->get('cid');
		if(empty($courseID)){ $courseID = $this->uri->segment(3); }
		$sql = "SELECT * from ld_courses_calendar WHERE course_id = '$courseID' AND is_active = '1'";
		$query = $this->Common_model->get_query_result_array($sql);
		echo json_encode($query);
	}
	
	public function info_courses_batch_details($batchID = "")
	{
		$batchID = $this->input->get('bid');
		if(empty($batchID)){ $batchID = $this->uri->segment(3); }
		$sql = "SELECT * from ld_courses_calendar WHERE id = '$batchID'";
		$query = $this->Common_model->get_query_result_array($sql);
		echo json_encode($query);
	}
	
	public function info_office_list()
	{
		$sql = "SELECT * from office_location WHERE is_active = '1'";
		$query = $this->Common_model->get_query_result_array($sql);
		return $query;
	}
	
	public function info_department_list()
	{
		$sql = "SELECT * from department WHERE is_active = '1'";
		$query = $this->Common_model->get_query_result_array($sql);
		return $query;
	}
	
	public function info_role_list()
	{
		$sql = "SELECT * from role WHERE is_active = '1'";
		$query = $this->Common_model->get_query_result_array($sql);
		return $query;
	}
	
	public function info_site_list()
	{
		$siteArray = array(
			"ALBANIA" => array("name" => "ALBANIA"),
			"CANADA" => array("name" => "CANADA"),
			"EL SALVADOR" => array("name" => "EL SALVADOR"),
			"INDIA" => array("name" => "INDIA"),
			"JAMAICA" => array("name" => "JAMAICA"),
			"PHILIPPINES" => array("name" => "PHILIPPINES"),
			"UK" => array("name" => "UK"),
			"USA-VITAL" => array("name" => "USA-VITAL"),
			"USA-AMERIDIAL" => array("name" => "USA-AMERIDIAL"),
		);
		return $siteArray;
	}
	
	public function info_supervisor_list($office = "")
	{
		$extraFilter = "";
		if(!empty($office)){
			$extraFilter = " AND s.office_id = '$office'"; 
		}
		$sql = "SELECT * from signin as s INNER JOIN role as r ON r.id = s.role_id WHERE r.is_active = '1' AND s.status IN (1,4) AND r.folder = 'tl' $extraFilter";
		$query = $this->Common_model->get_query_result_array($sql);
		return $query;
	}
	
	
	public function crm_records_list($extraFilter = "")
	{
		$sqlcase = "SELECT c.*, s.fusion_id, s.office_id, concat(s.fname,' ', s.lname) as agent_name,  concat(l.fname,' ', l.lname) as l1_supervisor_name,
					r.name as designation_name, d.shname as department_name, lc.course_name, p.batch_name, p.batch_trainer, p.batch_start_date, p.schedule_info
		            from ld_registrations as c 
		            LEFT JOIN ld_courses_calendar as p ON p.id = c.schedule_id 
		            LEFT JOIN signin as s ON s.id = c.user_id 
		            LEFT JOIN signin as l ON l.id = c.supervisor_id 
		            LEFT JOIN department as d ON d.id = c.user_department 
		            LEFT JOIN role as r ON r.id = c.user_role 
		            LEFT JOIN ld_courses as lc ON lc.id = c.course_id 
		            WHERE 1 $extraFilter ORDER by c.id DESC";
		$querycase = $this->Common_model->get_query_result_array($sqlcase);
		return $querycase;
	}
	
		
	public function registrationList()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['course_list'] = $this->info_courses_list();
		$data['office_list'] = $this->info_office_list();
		$data['site_list'] = $this->info_site_list();
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
		
		$search_course_batch = $this->input->get('search_course_batch');
		if(!empty($search_course_batch) && $search_course_batch != "ALL")
		{ 
			$extraFilter .= " AND (c.schedule_id = '$search_course_batch') ";
		}
				
		$data['search_course_type'] = $search_course_type;
		$data['search_office'] = $serach_office;
		$data['search_site'] = $search_site;
		$data['search_course_batch'] = $search_course_batch;
		$data['from_date'] = date('Y-m-d',strtotime($from_date));
		$data['to_date'] = date('Y-m-d',strtotime($to_date));
		
		$data['crm_list'] = $querycase = $this->crm_records_list($extraFilter);
			
		$data["aside_template"] = "ld_courses/aside.php";
		$data["content_template"] = "ld_courses/ld_courses_registration_list.php";
		$data["content_js"] = "ld_courses/ld_courses_registration_list_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	
	public function registrationReport()
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
		
		$data['course_list'] = $this->info_courses_list();
		$data['office_list'] = $this->info_office_list();
		$data['site_list'] = $this->info_site_list();
		
		$data["aside_template"] = "ld_courses/aside.php";
		$data["content_template"] = "ld_courses/ld_courses_registration_reports.php";
		$data["content_js"] = "ld_courses/ld_courses_registration_list_js.php";
		
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
		$search_site = $this->input->get('search_site');
		if(!empty($search_site) && $search_site != "ALL")
		{ 
			$extraFilter .= " AND (c.user_site = '$search_site') ";
		}
		$search_course_batch = $this->input->get('search_course_batch');
		if(!empty($search_course_batch) && $search_course_batch != "ALL")
		{ 
			$extraFilter .= " AND (c.schedule_id = '$search_course_batch') ";
		}
				
		$crm_list = $this->crm_records_list($extraFilter);
		
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
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Training Course");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Batch Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Training Start Date");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Faciliator");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Schedule");		
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
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["batch_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["course_start_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["batch_trainer"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["schedule_info"]);
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
		$batch_id         = $this->input->post('batch_id');
		$course_start_date = date('Y-m-d', strtotime($this->input->post('course_start_date')));
		
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
			'schedule_id' => $batch_id,
			'course_start_date' => $course_start_date,
		];
	
		$sqlcheck = "SELECT count(*) as value from ld_registrations WHERE registration_no = '$registration_no'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{			
			$this->db->where('registration_no', $registration_no);
			$this->db->update('ld_registrations', $case_array);
			$flag = "update";
		} 
		else {
			$case_array += [ 'registration_no' => $registration_no ];
			$case_array += [ 'registration_date' => $registration_date ];
			$case_array += [ 'added_by' => $current_user ];
			$case_array += [ 'date_added' => CurrMySqlDate() ];
			$case_array += [ 'date_added_local' => GetLocalTime() ];
			$case_array += [ 'logs' => get_logs() ];
			data_inserter('ld_registrations', $case_array);			
			$flag = "insert";
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	
	public function registration_entry_delete()
	{
		$crmdeletID = $this->input->get('crmid');
		if(!empty($crmdeletID))
		{
			$sqlcheck = "SELECT count(*) as value from ld_registrations WHERE registration_no = '$crmdeletID'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0)
			{			
				$this->db->where('registration_no', $crmdeletID);
				$this->db->delete('ld_registrations');
				echo "DELETED";
				
			} else {				
				echo "NOT FOUND";
			}			
		} else {
			echo "INVALID";
		}
	}
	
	
	
	
	//===== TRAINING CALENDAR =============================//
	
	public function master_ld_calendar()
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
		
		$data["course_list"] = $this->info_courses_list();
		$data["calendar_list"] = $this->master_calendar_list();
		
		$data["aside_template"] = "ld_courses/aside.php";
		$data["content_template"] = "ld_courses/ld_courses_master.php";				
		$data["content_js"] = "ld_courses/ld_courses_registration_list_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	public function master_calendar_list()
	{
		$dropdownOptions = "SELECT l.*, c.course_name from ld_courses_calendar as l INNER JOIN ld_courses as c ON c.id = l.course_id WHERE l.is_active = '1'";
		$resultArray = $this->Common_model->get_query_result_array($dropdownOptions);
		return $resultArray;
	}
	
	public function submit_calendar_master()
	{
		$id    = $this->input->post('id');
		$course_id    = $this->input->post('course_id');
		$batch_name    = $this->input->post('batch_name');
		$batch_trainer = $this->input->post('batch_trainer');
		//$batch_id = $this->input->post('batch_id');
		//$trainer_id = $this->input->post('trainer_id');
		$batch_start_date = date('Y-m-d', strtotime($this->input->post('batch_start_date')));
		$batch_end_date = date('Y-m-d', strtotime($this->input->post('batch_end_date')));
		$schedule_info = $this->input->post('schedule_info');
		
		$data = [
			"course_id" => $course_id,
			"batch_name" => $batch_name,
			"batch_trainer" => $batch_trainer,
			"batch_start_date" => $batch_start_date,
			"batch_end_date" => $batch_end_date,
			"schedule_info" => $schedule_info,
		];
		if(empty($id)){ 
			$data += [
				"added_by" => get_user_id(),
				"date_added" => CurrMySqlDate(),
				"is_active" => 1,
			];
			data_inserter('ld_courses_calendar', $data);
		} else {
			$this->db->where('id', $id);
			$this->db->update('ld_courses_calendar', $data);
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function delete_calendar_master()
	{
		$id= $this->input->get('did');
		$data = [
			"is_active" => 0,
		];
		$this->db->where('id', $id);
		$this->db->update('ld_courses_calendar', $data);
		redirect($_SERVER['HTTP_REFERER']);
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
		
		$data["course_list"] = $this->info_courses_list();
		
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
				 AND r.folder='agent' ORDER by trainee_name ASC";
		$data["select_trainee"] = $this->Common_model->get_query_result_array($qSql);
			
		$data["aside_template"] = "ld_courses/aside.php";
		$data["content_template"] = "ld_courses/ld_courses_create_batch.php";
		$data["content_js"] = "ld_courses/ld_courses_js.php";
		
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
			$course_type = trim($this->input->post('course_id'));			
			$batch_start_date = date('Y-m-d', strtotime($this->input->post('batch_start_date')));	
			
			$trainer_id   = $this->input->post('trainer_id');
			$trainee_id = $this->input->post('trainee_id_select');
			$unique_trainee_list = array_unique($trainee_id);
			$total_id = count($unique_trainee_list);		
			
			if($total_id > 0){
				
			$field_array = array(
				"batch_name"   => $batch_name,
				"batch_start_date"   => $batch_start_date,
				"course_type"   => $course_type,
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
			$data["aside_template"] = "ld_courses/aside.php";
			$data["content_template"] = "ld_courses/ld_batch_list.php";
			$data["content_js"] = "ld_courses/ld_courses_js.php";
			
			//==================== FILTER SEARCH
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue=$user_office_id;
			$data['oValue']=$oValue;			
			if($oValue!="ALL"){
				$filterCond .= " and (office_id = '$oValue')";
			}			
			if($this->input->get('searchtraining'))
			{
				$daterange_full    = $this->input->get('daterange');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$filterCond .= " AND batch_start_date >= '$startdate_range' AND batch_start_date <= '$enddate_range'";
			}	
		
			if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training"))
			{				
				$qSql = "SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name, c.course_code  
						 from ld_programs_batch as b
						 LEFT JOIN ld_programs as c ON c.id = b.course_type
						 LEFT JOIN signin as s ON s.id = b.trainer_id
						 ORDER BY b.course_type, b.batch_start_date";				
				$batchList = $this->Common_model->get_query_result_array($qSql);
			} else {
				$myteamIDs = $this->get_team_id($current_user);
				$qSql="SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, c.course_name  
					   from ld_programs_batch as b
					   LEFT JOIN ld_programs as c ON c.id = b.course_type
					   LEFT JOIN signin as s ON s.id = b.trainer_id
					   ORDER BY b.course_type, b.batch_start_date";				
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
	
}