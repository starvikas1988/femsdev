<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->model('Survey_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){
				
		redirect(base_url()."employee_feedback");
	 
	}
	 
	


//==========================================================================================
///=========================== CAFETERIA SURVEY  ================================///

	
	public function cafeteria()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveySubmission'] = 0;
		$survey_sql = "SELECT * from survey_cafeteria WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_row_array($survey_sql);
		if(count($data['surveySubmission']) > 0){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/survey_cafeteria_aside.php";
		$data["content_template"] = "survey/survey_cafeteria_form.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	 
	
	public function submit_cafeteria_survey_form()
	{
		$current_user = get_user_id();
		
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'survey_1' => $this->input->post('survey_1'),
			'survey_2' => $this->input->post('survey_2'),
			'survey_3' => $this->input->post('survey_3'),
			'survey_4' => $this->input->post('survey_4'),
			'survey_5' => $this->input->post('survey_5'),
			'survey_6' => $this->input->post('survey_6'),
			'survey_7' => $this->input->post('survey_7'),
			'survey_8' => $this->input->post('survey_8'),
			'survey_9' => $this->input->post('survey_9'),
			'survey_10' => $this->input->post('survey_10'),
			'survey_11' => $this->input->post('survey_11'),
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'logs' => get_logs()
		];
		
		data_inserter('survey_cafeteria', $data_array);
		redirect(base_url()."survey/cafeteria");
	
	}
	
	public function cafeteria_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "survey/survey_cafeteria_reports.php";
		
		if($this->input->post('excel_office_id')){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('excel_office_id');
			$this->generate_cafeteria_report_xls($officeSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_cafeteria_report_xls($officeq)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		
		$get_office_id = $officeq;
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND s.office_id = '$get_office_id' ";
		}
				
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_cafeteria as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraoffice";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Cafeteria Satisfaction Survey');
		
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Variety of food choices");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Taste & Flavour");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Freshness");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Order Accuracy");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Courteous staff");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Serving lines move quickly");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Clean tray return area");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Clean plates, glasses");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Clean dining table");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Value for Money");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Overall Dining Experience");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$answers_array = array(
			"5" => "Very Satisfied",
			"4" => "Satisfied",
			"3" => "Neutral",
			"2" => "Dissatisfied",
			"1" => "Very Dissatisfied",
		);
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "CAFETERIA SATISFACTION SURVEY");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:L1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('J1', "Food Quality");
		$this->objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:O1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('M1', "Serving Staff");
		$this->objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('P1:R1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('P1', "Food Services Facilities");
		$this->objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		
		foreach($report_list as $wk=>$wv)
		{
			$agent_id = $wv['agent_id'];
					
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_1"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_2"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_3"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_4"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_5"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_6"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_7"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_8"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_9"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_10"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_11"]]);
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Cafeteria_Survey_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	


//==========================================================================================
///=========================== EMPLOYEE PULSE SURVEY  ================================///

	
	public function employee_pulse()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveySubmission'] = 0;
		$survey_sql = "SELECT * from survey_employee_pulse WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_row_array($survey_sql);
		if(count($data['surveySubmission']) > 0){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/employee_pulse_aside.php";
		$data["content_template"] = "survey/employee_pulse_form.php";
		$data["content_js"] = "survey/survey_employee_pulse_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	 
	
	public function submit_employee_pulse_form()
	{
		$current_user = get_user_id();
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'survey_1' => $this->input->post('survey_1'),
			'survey_2' => $this->input->post('survey_2'),
			'survey_3' => $this->input->post('survey_3'),
			'survey_4' => $this->input->post('survey_4'),
			'survey_5' => $this->input->post('survey_5'),
			'survey_5_others' => $this->input->post('survey_5_others'),
			'survey_6' => $this->input->post('survey_6'),
			'survey_7' => $this->input->post('survey_7'),
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'date_added_local' => GetLocalDate(),
			'logs' => get_logs()
		];
		
		data_inserter('survey_employee_pulse', $data_array);
		redirect($_SERVER['HTTP_REFERER']);
	
	}
	
	public function employee_pulse_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/employee_pulse_aside.php";
		$data["content_template"] = "survey/employee_pulse_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_employee_pulse_report_xls($officeSelection, $deptSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_employee_pulse_report_xls($officeq='', $deptq='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
				
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_employee_pulse as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Employee Pulse Survey');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Q1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Are you feeling stress?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What do you usually do to unload stress?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Rate your job stress?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Do you feel you have a healthy work-life balance?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "How long are you in Fusion?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What is your age?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Suggestion");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$survey_opt = array(
			"Y" => "Yes",
			"N" => "No",
		);
		$survey_2_opt = array(
			"1" => "Sports",
			"2" => "Watching Movies",
			"3" => "Watching Series",
			"4" => "Watching Drama",
			"5" => "Cooking",
			"6" => "Reading",
			"7" => "Play Online Games",
			"8" => "Shopping",
			"9" => "Planting",
			"10" => "Social Media (Facebook/ Tik Tok/ Instagram etc.)",
			"11" => "Vlogging",
			"12" => "Spend quality time with family and friends"
		);
		$survey_6_opt = array(
			"1" => "0 - 5 months",
			"2" => "6 months - 1 year",
			"3" => "1 year, 1 month - 3 years",
			"4" => "3 years, 1 month- 5 years",
			"5" => "5 years, 1 month - 7 years",
			"6" => "7 years, 1 month - 10 years",
			"7" => "10 years, 1 month up"
		);
		$survey_7_opt = array(
			"1" => "18-25 years old",
			"2" => "25-35 years old",
			"3" => "35-45 years old",
			"4" => "45-55 years old",
			"5" => "56-60 years old"
		);
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "EMPLOYEE PULSE SURVEY");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		foreach($report_list as $wk=>$wv)
		{
			$i++;
			$agent_id = $wv['agent_id'];
			$survey_5_others = !empty($wv["survey_5_others"]) ? ", " .$wv["survey_5_others"] : "";	
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt[$wv["survey_1"]]);
			$this->objPHPExcel->getActiveSheet()->getStyle('K'.$c)->applyFromArray($wv['survey_1'] == 'Y' ? $yesArray : $noArray);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_2_opt[$wv["survey_2"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_4"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt[$wv["survey_5"]] .$survey_5_others);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_6_opt[$wv["survey_6"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_7_opt[$wv["survey_7"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_3"]);
			
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Employee_Pulse_Survey_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function employee_pulse_reports_analytics()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/employee_pulse_aside.php";
		$data["content_template"] = "survey/employee_pulse_reports_graphical.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		$data['deptSelected'] = $deptSelection = $get_dept_id;
		if($this->input->get('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
		}
		
		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
			
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
						  d.description as department, r.name as designation, s.office_id as office, f.*
						  from survey_employee_pulse as f
						  LEFT JOIN signin as s ON f.agent_id = s.id
						  LEFT JOIN signin as ls ON ls.id = s.assigned_to
						  LEFT JOIN department as d on d.id=s.dept_id
						  LEFT JOIN role as r on r.id=s.role_id
						  WHERE 1 $extraFilter";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$answersReport = array();
		$data['total_submission'] = $total_submission = count($report_list);
		
		$answersReport['survey_1'] = $survey_1 = array_count_values(array_column($report_list, 'survey_1'));		
		$answersReport['survey_2'] = $survey_2 = array_count_values(array_column($report_list, 'survey_2'));
		$answersReport['survey_4'] = $survey_4 = array_count_values(array_column($report_list, 'survey_4'));
		$answersReport['survey_5'] = $survey_5 = array_count_values(array_column($report_list, 'survey_5'));
		$answersReport['survey_6'] = $survey_6 = array_count_values(array_column($report_list, 'survey_6'));
		$answersReport['survey_7'] = $survey_7 = array_count_values(array_column($report_list, 'survey_7'));
		
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	
	}


	
//==========================================================================================
///=========================== COPC SUREVEY  ================================///

	public function copc()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveySubmission'] = 0;
		$survey_sql = "SELECT count(*) as value from survey_copc WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_single_value($survey_sql);
		if($data['surveySubmission'] > 0){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/copc_aside.php";
		$data["content_template"] = "survey/copc_form.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function submit_copc_survey_form()
	{		
		$current_user = get_user_id();		
		$survey_site = $this->input->post('survey_site');
		$survey_dept = $this->input->post('survey_dept');
		
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'survey_site' => $survey_site,
			'survey_dept' => $survey_dept,
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'date_added_local' => GetLocalDate(),
			'logs' => get_logs()
		];
		
		$survey_1_arr = $this->input->post('survey_1');
		$survey_1 = implode(',', $survey_1_arr);
		$data_array += [ 'survey_1' => $survey_1 ];
		
		$survey_1_others = $this->input->post('survey_1_others');
		$data_array += [ 'survey_1_others' => $survey_1_others ];
		
		$survey_2_arr = $this->input->post('survey_2');
		$survey_2 = implode(',', $survey_2_arr);
		$data_array += [ 'survey_2' => $survey_2 ];
		
		$survey_2_others = $this->input->post('survey_2_others');
		$data_array += [ 'survey_2_others' => $survey_2_others ];
		
		$survey_3_arr = $this->input->post('survey_3');
		$survey_3 = implode(',', $survey_3_arr);
		$data_array += [ 'survey_3' => $survey_3 ];
		
		$survey_3_others = $this->input->post('survey_3_others');
		$data_array += [ 'survey_3_others' => $survey_3_others ];
		
		$survey_8_arr = $this->input->post('survey_8');
		$survey_8 = implode(',', $survey_8_arr);
		$data_array += [ 'survey_8' => $survey_8 ];
		
		$survey_8_others = $this->input->post('survey_8_others');
		$data_array += [ 'survey_8_others' => $survey_8_others ];
		
		for($i='a'; $i<='p'; $i++)
		{
			$survey_4 = $this->input->post('survey_4_'.$i);
			$data_array += [ 'survey_4_'.$i => $survey_4 ];
		}
		
		for($i='a'; $i<='o'; $i++)
		{
			if($i != "e"){
				$survey_5 = $this->input->post('survey_5_'.$i);
				$data_array += [ 'survey_5_'.$i => $survey_5 ];
			}
		}
		
		$survey_5 = $this->input->post('survey_5_weightage');
		$data_array += [ 'survey_5' => $survey_5 ];
		
		$survey_6 = $this->input->post('survey_6');
		$data_array += [ 'survey_6' => $survey_6 ];
		
		$survey_7 = $this->input->post('survey_7');
		$data_array += [ 'survey_7' => $survey_7 ];
		
		$survey_9 = $this->input->post('survey_9');
		$data_array += [ 'survey_9' => $survey_9 ];
		
		//echo "<pre>" .print_r($data_array, 1) ."</pre>";
		//echo "<pre>" .print_r($_POST, 1) ."</pre>";
		
		data_inserter('survey_copc', $data_array);
		redirect($_SERVER['HTTP_REFERER']);
	
	}
	
	
	public function copc_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			//$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			//$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data["aside_template"] = "survey/copc_aside.php";
		$data["content_template"] = "survey/copc_reports.php";
		
		if($this->input->post('survey_site')){
			$data['survey_site'] = $officeSelection = $this->input->post('survey_site');
			$data['survey_dept'] = $deptSelection = $this->input->post('survey_dept');
			$this->generate_copc_report_xls($officeSelection, $deptSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function copc_graphical_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			//$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			//$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data["aside_template"] = "survey/copc_aside.php";
		$data["content_template"] = "survey/copc_reports_graphical.php";
		
		// CHECK ARRAYS
		$data['survey_dept_array'] = $survey_dept_array = array(
			"D1" => "Client Services",
			"D2" => "Hr Operations",
			"D3" => "Hr Talent Acquisition",
			"D4" => "Information Security",
			"D5" => "IT",
			"D6" => "Operations",
			"D7" => "Procurement /Finance",
			"D8" => "Quality",
			"D9" => "Sales",
			"D10" => "Training",
			"D11" => "Marketing",
			"D12" => "Transition",
			"D13" => "WFM",
			"D14" => "BA"
		);

		$data['survey_site_array'] = $survey_site_array = array(
			"S1" => "Montreal",
			"S2" => "EL Salvador",
			"S3" => "Jamaica",
			"S4" => "Cebu",
			"S5" => "Manila",
			"S6" => "Atlanta",
			"S7" => "India",
			"S8" => "Ameridial",
			"S9" => "Europe"
		);
		
		$data['survey_array_1'] = $survey_array_1 = array(
			"weekly" => "Once a week (Weekly)",
			"monthly" => "Once a month (Monthly)",
			"quarterly" => "Once in a quarter (Quarterly)",
			"annually" => "Once in Six Months (Twice Annually)",
			"others" => "Other (please specify)",
		);
		$data['survey_array_2'] = $survey_array_2 = array(
			"face" => "Face to face (Meeting Room, Video Calls, etc.)",
			"phone" => "On a Phone Call",
			"email" => "An e-mail is sent out with attached scorecard",
			"sharedrive" => "Scorecards is placed on the shared drive",
			"others" => "Other (please specify)",
		);
		$data['survey_array_3'] = $survey_array_3 = array(
			"monthly" => "Monthly",
			"quarterly" => "Quarterly",
			"annualy_twice" => "Twice annually",
			"annualy" => "Annualy",
			"others" => "Other (please specify)",
		);
		$data['survey_array_4'] = $survey_array_4 = array(
			"qualifier" => "Qualifier (Gate) Parameters",
			"performance" => "Performance (Weight) Parameters",
			"n/a" => "Not included in scorecards",
		);
		
		$data['survey_array_4_questions'] = $survey_array_4_questions = array(
			"survey_4_a" => "Attendance",
			"survey_4_b" => "Time on System/Utilization (Lunch Time, Breaks, Meetings Time, Other Aux uses etc.)",
			"survey_4_c" => "Efficiency Metrics (Handle Time, Cases per Hour, Emails per hour)",
			"survey_4_d" => "Weekly/Monthly Process & Product",
			"survey_4_e" => "Quiz Scores",
			"survey_4_f" => "Compliance Issues",
			"survey_4_g" => "Misconduct Occurrences",
			"survey_4_h" => "Customer Complaints",
			"survey_4_i" => "Customer Satisfaction Scores :(CSAT / DSAT etc.)",
			"survey_4_j" => "Service Journey Satisfaction : (NPS, Effort Score etc.)",
			"survey_4_k" => "Issue Resolution : (FCR, Contact Resolution)",
			"survey_4_l" => "Quality / Accuracy Scores : (Accuracy Rate, Error Rate)",
			"survey_4_m" => "Survey Response Rate : (IVR Push Rate, E-mail response rate, etc.)",
			"survey_4_n" => "Documentation Issues (Case Logging, Filling up Time Sheets, etc.)",
			"survey_4_o" => "Sales Performance (Conversion, Revenue, etc.)",
			"survey_4_p" => "Others (Add any parameter not included along with weightage)",
		);
		
		$data['survey_array_5_questions'] = $survey_array_5_questions = array(
			"survey_5_a" => "Attendance",
			"survey_5_b" => "Time on System/Utilization (Lunch Time, Breaks, Meetings Time, Other Aux uses etc.)",
			"survey_5_c" => "Efficiency Metrics (Handle Time, Cases per Hour, Emails per hour)",
			"survey_5_d" => "Weekly/Monthly Process & Product",
			"survey_5_f" => "Compliance Issues",
			"survey_5_g" => "Misconduct Occurrences",
			"survey_5_h" => "Customer Complaints",
			"survey_5_i" => "Customer Satisfaction Scores :(CSAT / DSAT etc.)",
			"survey_5_j" => "Service Journey Satisfaction : (NPS, Effort Score etc.)",
			"survey_5_k" => "Issue Resolution : (FCR, Contact Resolution)",
			"survey_5_l" => "Quality / Accuracy Scores : (Accuracy Rate, Error Rate)",
			"survey_5_m" => "Survey Response Rate : (IVR Push Rate, E-mail response rate, etc.)",
			"survey_5_n" => "Documentation Issues (Case Logging, Filling up Time Sheets, etc.)",
			"survey_5_o" => "Sales Performance (Conversion, Revenue, etc.)",
		);
		
		$data['survey_array_8'] = $survey_array_8 = array(
			"bellcurve" => "Bell Curve",
			"frequency" => "Frequency Distribution (Histogram etc.)",
			"quartile" => "Quartile Management",
			"coefficient" => "Coefficient of Variation (CV) / Variance Significance Factor (VSF)",
			"others" => "Other (please specify)",
		);
		
		$officeSelection = "ALL";
		$deptSelection = "ALL";
		
		$extraoffice = ""; $extradept = "";
		if($this->input->post('survey_site')){			
			$officeSelection = $this->input->post('survey_site');
			$deptSelection = $this->input->post('survey_dept');
			$get_office_id = $officeSelection; $get_dept_id = $deptSelection;
			if(($get_office_id != "") && ($get_office_id != "ALL")){
				$extraoffice = " AND f.survey_site = '$get_office_id' ";
			}
			if(($get_dept_id != "") && ($get_dept_id != "ALL")){
				$extradept = " AND f.survey_dept = '$get_dept_id' ";
			}			
		}
		
		$data['survey_site'] = $officeSelection;
		$data['survey_dept'] = $deptSelection;
			
		$reports_sql = "SELECT f.* from survey_copc as f WHERE 1 $extraoffice $extradept";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$answersReport = array();
		
		// SURVEY 1 GRAPH
		$array_answers = array_column($report_list, 'survey_1'); $total_count = count($array_answers);
		foreach($survey_array_1 as $search => $token)
		{
			$answersReport['data']['q1'][$search] = array_filter($array_answers, function ($item) use ($search) {
				if(stripos($item, $search) !== false) { return true; }
				return false;
			});
			$answersReport['count']['q1'][$search] = count($answersReport['data']['q1'][$search]);
			$answersReport['percent']['q1'][$search] = ($answersReport['count']['q1'][$search]/$total_count) * 100;
			if(empty($total_count)){ $answersReport['percent']['q1'][$search] = 0; }
		}
		
		// SURVEY 2 GRAPH
		$array_answers = array_column($report_list, 'survey_2'); $total_count = count($array_answers);
		foreach($survey_array_2 as $search => $token)
		{
			$answersReport['data']['q2'][$search] = array_filter($array_answers, function ($item) use ($search) {
				if(stripos($item, $search) !== false) { return true; }
				return false;
			});
			$answersReport['count']['q2'][$search] = count($answersReport['data']['q2'][$search]);
			$answersReport['percent']['q2'][$search] = ($answersReport['count']['q2'][$search]/$total_count) * 100;
			if(empty($total_count)){ $answersReport['percent']['q2'][$search] = 0; }
		}
		
		// SURVEY 3 GRAPH
		$array_answers = array_column($report_list, 'survey_3'); $total_count = count($array_answers);
		foreach($survey_array_3 as $search => $token)
		{
			$answersReport['data']['q3'][$search] = array_filter($array_answers, function ($item) use ($search) {
				if(stripos($item, $search) !== false) { return true; }
				return false;
			});
			$answersReport['count']['q3'][$search] = count($answersReport['data']['q3'][$search]);
			$answersReport['percent']['q3'][$search] = ($answersReport['count']['q3'][$search]/$total_count) * 100;
			if(empty($total_count)){ $answersReport['percent']['q3'][$search] = 0; }
		}
					
		// SURVEY 4 GRAPH			
		for($i='a'; $i<='p'; $i++)
		{
			$array_answers = array_column($report_list, 'survey_4_'.$i); $total_count = count($array_answers);
			foreach($survey_array_4 as $search => $token)
			{
				$answersReport['data']['q4'][$search][$i] = array_filter($array_answers, function ($item) use ($search) {
					if(stripos($item, $search) !== false) { return true; }
					return false;
				});
				$answersReport['count']['q4'][$search][$i] = count($answersReport['data']['q4'][$search][$i]);
				$answersReport['percent']['q4'][$search][$i] = ($answersReport['count']['q4'][$search][$i]/$total_count) * 100;
				if(empty($total_count)){ $answersReport['percent']['q4'][$search][$i] = 0; }
			}
		}
		
		// SURVEY 5 GRAPH	
		for($i='a'; $i<='o'; $i++)
		{
			if($i != 'e'){
				$array_answers = array_column($report_list, 'survey_5_'.$i); $total_count = count($array_answers);
				$answersReport['data']['q5'][$i] = $array_answers;
				$answersReport['count']['q5'][$i] = array_sum($answersReport['data']['q5'][$i]);
				$answersReport['percent']['q5'][$i] = $answersReport['count']['q5'][$i]/$total_count;
				if(empty($total_count)){ $answersReport['percent']['q5'][$i] = 0; }
			}
		}
		
		// SURVEY 6 GRAPH	
		$array_answers = array_column($report_list, 'survey_6'); $total_count = count($array_answers);
		$answersReport['data']['q6'] = $array_answers;
		$answersReport['count']['q6'] = array_sum($answersReport['data']['q6']);
		$answersReport['percent']['q6'] = $answersReport['count']['q6']/$total_count;
		if(empty($total_count)){ $answersReport['percent']['q6'] = 0; }
		
		// SURVEY 7 GRAPH	
		$array_answers = array_column($report_list, 'survey_7'); $total_count = count($array_answers);
		$answersReport['data']['q7'] = $array_answers;
		$answersReport['count']['q7'] = array_sum($answersReport['data']['q7']);
		$answersReport['percent']['q7'] = $answersReport['count']['q7']/$total_count;
		if(empty($total_count)){ $answersReport['percent']['q7'] = 0; }
		
		
		// SURVEY 8 GRAPH
		$array_answers = array_column($report_list, 'survey_8'); $total_count = count($array_answers);
		foreach($survey_array_8 as $search => $token)
		{
			$answersReport['data']['q8'][$search] = array_filter($array_answers, function ($item) use ($search) {
				if(stripos($item, $search) !== false) { return true; }
				return false;
			});
			$answersReport['count']['q8'][$search] = count($answersReport['data']['q8'][$search]);
			$answersReport['percent']['q8'][$search] = ($answersReport['count']['q8'][$search]/$total_count) * 100;
			if(empty($total_count)){ $answersReport['percent']['q8'][$search] = 0; }
		}
		
		
		// DEPARTMENTAL GRAPH
		$array_answers = array_column($report_list, 'survey_dept'); $total_count = count($array_answers);
		foreach($survey_dept_array as $search => $token)
		{
			$answersReport['data']['dept'][$search] = array_filter($array_answers, function ($item) use ($search) {
				if(stripos($item, $search) !== false) { return true; }
				return false;
			});
			$answersReport['count']['dept'][$search] = count($answersReport['data']['dept'][$search]);
			$answersReport['percent']['dept'][$search] = ($answersReport['count']['dept'][$search]/$total_count) * 100;
			if(empty($total_count)){ $answersReport['percent']['dept'][$search] = 0; }
		}
		
		// OFFICE GRAPH
		$array_answers = array_column($report_list, 'survey_site'); $total_count = count($array_answers);
		foreach($survey_site_array as $search => $token)
		{
			$answersReport['data']['site'][$search] = array_filter($array_answers, function ($item) use ($search) {
				if(stripos($item, $search) !== false) { return true; }
				return false;
			});
			$answersReport['count']['site'][$search] = count($answersReport['data']['site'][$search]);
			$answersReport['percent']['site'][$search] = ($answersReport['count']['site'][$search]/$total_count) * 100;
			if(empty($total_count)){ $answersReport['percent']['site'][$search] = 0; }
		}
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_copc_report_xls($officeq, $deptq)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		// CHECK ARRAYS
		$survey_dept_array = array(
			"D1" => "Client Services",
			"D2" => "Hr Operations",
			"D3" => "Hr Talent Acquisition",
			"D4" => "Information Security",
			"D5" => "IT",
			"D6" => "Operations",
			"D7" => "Procurement /Finance",
			"D8" => "Quality",
			"D9" => "Sales",
			"D10" => "Training",
			"D11" => "Marketing",
			"D12" => "Transition",
			"D13" => "WFM",
			"D14" => "BA"
		);

		$survey_site_array = array(
			"S1" => "Montreal",
			"S2" => "EL Salvador",
			"S3" => "Jamaica",
			"S4" => "Cebu",
			"S5" => "Manila",
			"S6" => "Atlanta",
			"S7" => "India",
			"S8" => "Ameridial",
			"S9" => "Europe"
		);
		
		$survey_array_1 = array(
			"weekly" => "Once a week (Weekly)",
			"monthly" => "Once a month (Monthly)",
			"quarterly" => "Once in a quarter (Quarterly)",
			"annually" => "Once in Six Months (Twice Annually)",
			"others" => "Other (please specify)",
		);
		$survey_array_2 = array(
			"face" => "Face to face (Meeting Room, Video Calls, etc.)",
			"phone" => "On a Phone Call",
			"email" => "An e-mail is sent out with attached scorecard",
			"sharedrive" => "Scorecards is placed on the shared drive",
			"others" => "Other (please specify)",
		);
		$survey_array_3 = array(
			"monthly" => "Monthly",
			"quarterly" => "Quarterly",
			"annualy_twice" => "Twice annually",
			"annualy" => "Annualy",
			"others" => "Other (please specify)",
		);
		$survey_array_4 = array(
			"qualifier" => "Qualifier (Gate) Parameters",
			"performance" => "Performance (Weight) Parameters",
			"n/a" => "Not included in scorecards",
		);
		
		$survey_array_4_questions = array(
			"survey_4_a" => "Attendance",
			"survey_4_b" => "Time on System/Utilization (Lunch Time, Breaks, Meetings Time, Other Aux uses etc.)",
			"survey_4_c" => "Efficiency Metrics (Handle Time, Cases per Hour, Emails per hour)",
			"survey_4_d" => "Weekly/Monthly Process & Product",
			"survey_4_e" => "Quiz Scores",
			"survey_4_f" => "Compliance Issues",
			"survey_4_g" => "Misconduct Occurrences",
			"survey_4_h" => "Customer Complaints",
			"survey_4_i" => "Customer Satisfaction Scores :(CSAT / DSAT etc.)",
			"survey_4_j" => "Service Journey Satisfaction : (NPS, Effort Score etc.)",
			"survey_4_k" => "Issue Resolution : (FCR, Contact Resolution)",
			"survey_4_l" => "Quality / Accuracy Scores : (Accuracy Rate, Error Rate)",
			"survey_4_m" => "Survey Response Rate : (IVR Push Rate, E-mail response rate, etc.)",
			"survey_4_n" => "Documentation Issues (Case Logging, Filling up Time Sheets, etc.)",
			"survey_4_o" => "Sales Performance (Conversion, Revenue, etc.)",
			"survey_4_p" => "Others (Add any parameter not included along with weightage)",
		);
		
		$survey_array_5_questions = array(
			"survey_5_a" => "Attendance",
			"survey_5_b" => "Time on System/Utilization (Lunch Time, Breaks, Meetings Time, Other Aux uses etc.)",
			"survey_5_c" => "Efficiency Metrics (Handle Time, Cases per Hour, Emails per hour)",
			"survey_5_d" => "Weekly/Monthly Process & Product",
			"survey_5_f" => "Compliance Issues",
			"survey_5_g" => "Misconduct Occurrences",
			"survey_5_h" => "Customer Complaints",
			"survey_5_i" => "Customer Satisfaction Scores :(CSAT / DSAT etc.)",
			"survey_5_j" => "Service Journey Satisfaction : (NPS, Effort Score etc.)",
			"survey_5_k" => "Issue Resolution : (FCR, Contact Resolution)",
			"survey_5_l" => "Quality / Accuracy Scores : (Accuracy Rate, Error Rate)",
			"survey_5_m" => "Survey Response Rate : (IVR Push Rate, E-mail response rate, etc.)",
			"survey_5_n" => "Documentation Issues (Case Logging, Filling up Time Sheets, etc.)",
			"survey_5_o" => "Sales Performance (Conversion, Revenue, etc.)",
		);
		
		$survey_array_8 = array(
			"bellcurve" => "Bell Curve",
			"frequency" => "Frequency Distribution (Histogram etc.)",
			"quartile" => "Quartile Management",
			"coefficient" => "Coefficient of Variation (CV) / Variance Significance Factor (VSF)",
			"others" => "Other (please specify)",
		);
		
		$extraoffice = ""; $extradept = "";
		$get_office_id = $officeq; $get_dept_id = $deptq;
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND f.survey_site = '$get_office_id' ";
		}
		if(($get_dept_id != "") && ($get_dept_id != "ALL")){
			$extradept = " AND f.survey_dept = '$get_dept_id' ";
		}
				
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_copc as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraoffice $extradept";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('COPC Survey');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AV1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		
		for($i='A'; $i <= 'Z'; $i++){
			$objWorksheet->getColumnDimension($i)->setAutoSize(true);
		}
		
		for($i='AA'; $i < 'AW'; $i++){
			$objWorksheet->getColumnDimension($i)->setAutoSize(true);
		}
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Survey Site");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Survey Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "How often one-on-one discussion with front line employees (CSS/CSRs/Advisors)?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "How does the one-on-one discussion on scorecards happen?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "How often do you review performance scorecards design?");
		
		foreach($survey_array_4_questions as $key => $token)
		{
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token);
		}
		
		foreach($survey_array_5_questions as $key => $token)
		{
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token);
		}
		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What percentage (approx.) of frontline employees become eligible?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What percentage (approx.) of frontline employees are put in a performance improvement plan (PIP)?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Which tools/methodology used to quantify variation in employee’s performance?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Additional Comments on how the employee’s scorecards can play an enabler");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$styleArray2 = array(
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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "COPC SURVEY");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('L1', "Question 1");
		$this->objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('M1', "Question 2");
		$this->objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('N1', "Question 3");
		$this->objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('O1:AD1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('O1', "Question 4 - Performance Parameters");
		$this->objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AE1:AR1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AE1', "Question 5 - Weightage");
		$this->objPHPExcel->getActiveSheet()->getStyle('AE1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AS1', "Question 6");
		$this->objPHPExcel->getActiveSheet()->getStyle('AS1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AT1', "Question 7");
		$this->objPHPExcel->getActiveSheet()->getStyle('AT1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AU1', "Question 8");
		$this->objPHPExcel->getActiveSheet()->getStyle('AU1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AV1', "Question 9");
		$this->objPHPExcel->getActiveSheet()->getStyle('AV1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b5d6ce');
		$this->objPHPExcel->getActiveSheet()->getStyle('M1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('e7e3ff');
		$this->objPHPExcel->getActiveSheet()->getStyle('N1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9cc9ad');
		$this->objPHPExcel->getActiveSheet()->getStyle('O1:AD1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f8c296');
		$this->objPHPExcel->getActiveSheet()->getStyle('AE1:AR1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f6e0e2');
		$this->objPHPExcel->getActiveSheet()->getStyle('AS1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('cfd571');
		$this->objPHPExcel->getActiveSheet()->getStyle('AT1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('bed578');
		$this->objPHPExcel->getActiveSheet()->getStyle('AU1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ec7788');
		$this->objPHPExcel->getActiveSheet()->getStyle('AV1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('cccccc');
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('L2:AV2')->applyFromArray($styleArray2);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		$this->objPHPExcel->getActiveSheet()->getStyle('L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b5d6ce');
		$this->objPHPExcel->getActiveSheet()->getStyle('M2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('e7e3ff');
		$this->objPHPExcel->getActiveSheet()->getStyle('N2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9cc9ad');
		$this->objPHPExcel->getActiveSheet()->getStyle('O2:AD2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f8c296');
		$this->objPHPExcel->getActiveSheet()->getStyle('AE2:AR2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f6e0e2');
		$this->objPHPExcel->getActiveSheet()->getStyle('AS2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('cfd571');
		$this->objPHPExcel->getActiveSheet()->getStyle('AT2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('bed578');
		$this->objPHPExcel->getActiveSheet()->getStyle('AU2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ec7788');
		$this->objPHPExcel->getActiveSheet()->getStyle('AV2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('cccccc');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		
		foreach($report_list as $wk=>$wv)
		{
			$agent_id = $wv['agent_id'];
					
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_site_array[$wv["survey_site"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_dept_array[$wv["survey_dept"]]);
			
			// SURVEY
			$answer_survey_1 = explode(',', $wv["survey_1"]); $answer_survey_1_arr = NULL;
			foreach($answer_survey_1 as $token){ 
				if($token == 'others'){ $answer_survey_1_arr[] = "Others - " .$wv["survey_1_others"]; } 
				else { $answer_survey_1_arr[] = ucwords($survey_array_1[$token]); }
			}
			$answer_survey_2 = explode(',', $wv["survey_2"]); $answer_survey_2_arr = NULL;
			foreach($answer_survey_2 as $token){ 
				if($token == 'others'){ $answer_survey_2_arr[] = "Others - " .$wv["survey_2_others"]; } 
				else { $answer_survey_2_arr[] = ucwords($survey_array_2[$token]); }
			}
			$answer_survey_3 = explode(',', $wv["survey_3"]); $answer_survey_3_arr = NULL;
			foreach($answer_survey_1 as $token){ 
				if($token == 'others'){ $answer_survey_3_arr[] = "Others - " .$wv["survey_3_others"]; } 
				else { $answer_survey_3_arr[] = ucwords($survey_array_3[$token]); }
			}
			$answer_survey_8 = explode(',', $wv["survey_8"]); $answer_survey_8_arr = NULL;
			foreach($answer_survey_8 as $token){ 
				if($token == 'others'){ $answer_survey_8_arr[] = "Others - " .$wv["survey_8_others"]; } 
				else { $answer_survey_8_arr[] = ucwords($survey_array_8[$token]); }
			}
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, implode(',', $answer_survey_1_arr));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, implode(',', $answer_survey_2_arr));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, implode(',', $answer_survey_3_arr));
			
			for($i='a'; $i<='p'; $i++)
			{
				$answercheck = $wv["survey_4_".$i];
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_array_4[$answercheck]);
			}
			
			for($i='a'; $i<='o'; $i++)
			{
				if($i != 'e'){
				$answercheck = $wv["survey_5_".$i];
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answercheck);
				}
			}
		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_6"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_7"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, implode(',', $answer_survey_8_arr));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_9"]);
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="COPC_Survey'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
//==========================================================================================
///=========================== TOWNHALL SUREVEY  ================================///
	
	
	public function townhall()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveySubmission'] = 0;
		$survey_sql = "SELECT * from survey_townhall WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_row_array($survey_sql);
		if(count($data['surveySubmission']) > 0){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/townhall_aside.php";
		$data["content_template"] = "survey/townhall_form.php";
		//$data["content_js"] = "survey/survey_employee_pulse_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function submit_townhall_form()
	{
		$current_user = get_user_id();
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'survey_1' => $this->input->post('survey_1'),
			'survey_2' => $this->input->post('survey_2'),
			'survey_3' => $this->input->post('survey_3'),
			'survey_4' => $this->input->post('survey_4'),
			'survey_5' => $this->input->post('survey_5'),
			'survey_6' => $this->input->post('survey_6'),
			'survey_7' => $this->input->post('survey_7'),
			'survey_8' => $this->input->post('survey_8'),
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'date_added_local' => GetLocalDate(),
			'logs' => get_logs()
		];
		
		data_inserter('survey_townhall', $data_array);
		redirect($_SERVER['HTTP_REFERER']);
	
	}
	
	public function townhall_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/townhall_aside.php";
		$data["content_template"] = "survey/townhall_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_townhall_report_xls($officeSelection, $deptSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	public function generate_townhall_report_xls($officeq='', $deptq='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
				
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_townhall as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Town Hall Survey');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:R1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "The Town Hall meeting met my expectations");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "The format of the Town Hall meeting was efficient");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Quality of the overall event");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scope of information presented");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Usefulness of the information");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "The presentation of the speakers covered the objectives of the event");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Overall, how would you rate the event?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "How did the conference influence your perception of the company?");
		
		$survey_opt = array(
			"A" => "Agree",
			"DA" => "Disagree",
		);
		$survey_opt_1 = array(
			"S" => "Satisfied",
			"DS" => "Dissatisfied",
		);
		$survey_opt_2 = array(
			"1" => "Excellent",
		    "2" => "Very Good",
			"3" => "Good",
			"4" => "Fair",
			"5" => "Poor",
		);
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "TOWN HALL SURVEY");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:R2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:R2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		foreach($report_list as $wk=>$wv)
		{
			$i++;
			$agent_id = $wv['agent_id'];
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt[$wv["survey_1"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt[$wv["survey_2"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt_1[$wv["survey_3"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt_1[$wv["survey_4"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt_1[$wv["survey_5"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt[$wv["survey_6"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_opt_2[$wv["survey_7"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_8"]);

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Townhall_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
//==========================================================================================
///=========================== TNA SUREVEY  ================================///
	
	
	public function tna()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveySubmission'] = 0;
		$survey_sql = "SELECT * from survey_tna WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_row_array($survey_sql);
		if(count($data['surveySubmission']) > 0){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/tna_aside.php";
		$data["content_template"] = "survey/tna_form.php";
		$data["content_js"] = "survey/survey_tna_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function submit_tna_form()
	{
		$current_user = get_user_id();
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'survey_1' => $this->input->post('survey_1'),
			'survey_2' => $this->input->post('survey_2'),
			'survey_3' => $this->input->post('survey_3'),
			'survey_4' => $this->input->post('survey_4'),
			'survey_5' => $this->input->post('survey_5'),
			'survey_6' => $this->input->post('survey_6'),
			'survey_7a' => $this->input->post('survey_7a'),
			'survey_7b' => $this->input->post('survey_7b'),
			'survey_7c' => $this->input->post('survey_7c'),
			'survey_8a' => $this->input->post('survey_8a'),
			'survey_8b' => $this->input->post('survey_8b'),
			'survey_8c' => $this->input->post('survey_8c'),
			'survey_9' => $this->input->post('survey_9'),
			'survey_10' => $this->input->post('survey_10'),
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'date_added_local' => GetLocalDate(),
			'logs' => get_logs()
		];
		
		data_inserter('survey_tna', $data_array);
		redirect($_SERVER['HTTP_REFERER']);
	
	}
	
	
	public function tna_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1 || is_access_tna_reports()){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/tna_aside.php";
		$data["content_template"] = "survey/tna_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_tna_report_xls($officeSelection, $deptSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	public function generate_tna_report_xls($officeq='', $deptq='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
				
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_tna as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Town Hall Survey');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:R1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What training did you attend in the recent past?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Overall, how interesting was the training?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "After the training, how inspired did you feel?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Do you feel the day provided value for you time and efforts?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What was the single best part of the training?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What is your recommend topic for training ?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Interesting and entertaining");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Relevant to you");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Inspiring");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Interesting and entertaining");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Relevant to you");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Inspiring");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "If you were a trainer, what would you have done differently?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Any final comments?");
		
		$optionsArray_1 = [
			"CT" => "Communication Training",
			"PT" => "Process Training",
			"TM" => "Time Management",
			"SM" => "Stress Management",
			"O" => "Any Other",
		];
		$optionsArray_5 = [
			"REL" => "Relevant",
			"INT" => "Interesting",
			"INV" => "Innovative",
			"INF" => "Informative",
			"ENT" => "Entertaining",
			"OTH" => "Other",
		];
		$optionsArray_6 = [
			"1" => "Effective Communication Skills",
			"2" => "Presentation Skills",
			"3" => "Email Etiquette",
			"4" => "People Management",
			"5" => "Stress Management",
			"6" => "Anger Management",
			"7" => "Conflict Management",
			"8" => "Leadership Management",
			"8" => "Change Management",
			"10" => "Customer Service",
			"11" => "Selling Skills",
			"12" => "Trainer/Training Skills",
			"13" => "Classroom Management",
			"14" => "Learner and Learner Style",
		];
		$optionsArray_7 = [
			"1" => "Not At All",
			"2" => "Not Really",
			"3" => "Somewhat",
			"4" => "Mostly",
			"5" => "Definitely",
		];
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "TNA FEEDBACK");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q1:S1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('Q1', "Presenter 1");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('T1:V1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('T1', "Presenter 2");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:X2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:X2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		$this->objPHPExcel->getActiveSheet()->getStyle('Q1:S1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		$this->objPHPExcel->getActiveSheet()->getStyle('T1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f5f5f5');
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		foreach($report_list as $wk=>$wv)
		{
			$i++;
			$agent_id = $wv['agent_id'];
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_1[$wv["survey_1"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_2"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_3"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_4"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_5[$wv["survey_5"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_6[$wv["survey_6"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_7[$wv["survey_7a"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_7[$wv["survey_7b"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_7[$wv["survey_7c"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_7[$wv["survey_8a"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_7[$wv["survey_8b"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $optionsArray_7[$wv["survey_8c"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_9"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_10"]);

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="TNA_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function tna_analytics()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1 || is_access_tna_reports()){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/tna_aside.php";
		$data["content_template"] = "survey/tna_reports_graphical.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		$data['deptSelected'] = $deptSelection = $get_dept_id;
		if($this->input->get('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
		}
		
		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
			
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
						  d.description as department, r.name as designation, s.office_id as office, f.*
						  from survey_tna as f
						  LEFT JOIN signin as s ON f.agent_id = s.id
						  LEFT JOIN signin as ls ON ls.id = s.assigned_to
						  LEFT JOIN department as d on d.id=s.dept_id
						  LEFT JOIN role as r on r.id=s.role_id
						  WHERE 1 $extraFilter";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$answersReport = array();
		$data['total_submission'] = $total_submission = count($report_list);
		
		$answersReport['survey_1'] = $survey_1 = array_count_values(array_column($report_list, 'survey_1'));		
		$answersReport['survey_2'] = $survey_2 = array_count_values(array_column($report_list, 'survey_2'));
		$answersReport['survey_3'] = $survey_3 = array_count_values(array_column($report_list, 'survey_3'));
		$answersReport['survey_4'] = $survey_4 = array_count_values(array_column($report_list, 'survey_4'));
		$answersReport['survey_5'] = $survey_5 = array_count_values(array_column($report_list, 'survey_5'));
		$answersReport['survey_6'] = $survey_6 = array_count_values(array_column($report_list, 'survey_6'));
		$answersReport['survey_7a'] = $survey_7a = array_count_values(array_column($report_list, 'survey_7a'));
		$answersReport['survey_7b'] = $survey_7b = array_count_values(array_column($report_list, 'survey_7b'));
		$answersReport['survey_7c'] = $survey_7c = array_count_values(array_column($report_list, 'survey_7c'));
		$answersReport['survey_8a'] = $survey_8a = array_count_values(array_column($report_list, 'survey_8a'));
		$answersReport['survey_8b'] = $survey_8b = array_count_values(array_column($report_list, 'survey_8b'));
		$answersReport['survey_8c'] = $survey_8c = array_count_values(array_column($report_list, 'survey_8c'));
		
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	
	
//===================================== SURVEY QA ===========================================================//

//==========================================================================================
///=========================== QA SURVEY  ================================///

	
	public function qa()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveySubmission'] = 0;
		$survey_sql = "SELECT * from survey_qa WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_row_array($survey_sql);
		if(count($data['surveySubmission']) > 0){ $data['surveySubmission'] = 1; }
		
		#$data["aside_template"] = "survey/survey_qa_aside.php";
		$data["content_template"] = "survey/survey_qa_form.php";
		
		$this->load->view('dashboard_single_col',$data);
	 
	}
	 
	
	public function submit_qa_survey_form()
	{
		$current_user = get_user_id();
		
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'rate_experience' => $this->input->post('rate_experience'),
			'rate_improve' => $this->input->post('rate_improve'),
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'logs' => get_logs()
		];
		
		data_inserter('survey_qa', $data_array);
		redirect(base_url()."survey/qa");
	
	}
	
	public function qa_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "survey/survey_qa_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('excel_office_id')){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('excel_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_qa_report_xls($officeSelection, $deptSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_qa_report_xls($officeq='', $deptq='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
				
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_qa as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Survey QA Module Survey');
		
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Rate your Experience");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What would you like us to improve");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$answers_array = array(
			"5" => "Very Helpful",
			"4" => "Helpful",
			"3" => "I cannot say now",
			"2" => "Not Helpful",
			"1" => "I am not using FEMS QA Module",
		);
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "SURVEY QA MODULE");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$counter = 0;
		foreach($report_list as $wk=>$wv)
		{
			$agent_id = $wv['agent_id'];
					
			$c++; $r=0;$counter++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["rate_experience"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["rate_improve"]);
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="QA_Survey_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	public function qa_analytics()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "survey/survey_qa_graphical.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		$data['deptSelected'] = $deptSelection = $get_dept_id;
		if($this->input->get('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
		}
		
		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
			
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
						  d.description as department, r.name as designation, s.office_id as office, f.*
						  from survey_qa as f
						  LEFT JOIN signin as s ON f.agent_id = s.id
						  LEFT JOIN signin as ls ON ls.id = s.assigned_to
						  LEFT JOIN department as d on d.id=s.dept_id
						  LEFT JOIN role as r on r.id=s.role_id
						  WHERE 1 $extraFilter";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$answersReport = array();
		$data['total_submission'] = $total_submission = count($report_list);
		
		$answersReport['survey_1'] = $survey_1 = array_count_values(array_column($report_list, 'rate_experience'));		
		$answersReport['survey_2'] = $survey_2 = array_count_values(array_column($report_list, 'rate_improve'));
		
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	
	//===================================================================================================================================//
	//   EMPLOYEE SENTIMENT - MOOD PULSE SURVEY 
	//===================================================================================================================================//
	
	public function submit_employees_sentiment_survey(){
		$question = $this->input->post('question');
		$answer = $this->input->post('answer');
		$agent = $this->input->post('agent');
		$this->Survey_model->survey_submission($question, $answer, $agent);
	}
	
	public function employees_sentiment_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "survey/survey_qa_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('excel_office_id')){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('excel_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_employees_sentiment_reports_xls($officeSelection, $deptSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_employees_sentiment_reports_xls($officeq='', $deptq='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
				
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_employee_mood as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Survey QA Module Survey');
		
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Rate your Experience");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "What would you like us to improve");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$answers_array = array(
			"5" => "Very Helpful",
			"4" => "Helpful",
			"3" => "I cannot say now",
			"2" => "Not Helpful",
			"1" => "I am not using FEMS QA Module",
		);
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "SURVEY QA MODULE");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:T2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$counter = 0;
		foreach($report_list as $wk=>$wv)
		{
			$agent_id = $wv['agent_id'];
					
			$c++; $r=0;$counter++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["rate_experience"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["rate_improve"]);
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="QA_Survey_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	public function employees_sentiment_analytics()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "survey/survey_qa_graphical.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		$data['deptSelected'] = $deptSelection = $get_dept_id;
		if($this->input->get('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
		}
		
		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
			
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
						  d.description as department, r.name as designation, s.office_id as office, f.*
						  from survey_qa as f
						  LEFT JOIN signin as s ON f.agent_id = s.id
						  LEFT JOIN signin as ls ON ls.id = s.assigned_to
						  LEFT JOIN department as d on d.id=s.dept_id
						  LEFT JOIN role as r on r.id=s.role_id
						  WHERE 1 $extraFilter";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$answersReport = array();
		$data['total_submission'] = $total_submission = count($report_list);
		
		$answersReport['survey_1'] = $survey_1 = array_count_values(array_column($report_list, 'rate_experience'));		
		$answersReport['survey_2'] = $survey_2 = array_count_values(array_column($report_list, 'rate_improve'));
		
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	
	}
	




//==========================================================================================
///=========================== DEPARTMENT FACILITIES SURVEY  ================================///
	
	
	public function facilities_department()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveyHome'] = 0;
		if($this->uri->segment(3) == 'check'){
			$data['surveyHome'] = 1;
		}
				
		$data['surveySubmission'] = 0;		
		$sv_currentDate = CurrMySqlDate();
		$sv_currentMonth = date('m', strtotime($sv_currentDate));
		$sv_currentYear = date('Y', strtotime($sv_currentDate));
		$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);		
		$sv_currentStartDate = date('Y-m-01', strtotime($sv_currentDate)) ." 00:00:00";
		$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
		
		$survey_sql = "SELECT * from survey_facilities_department WHERE agent_id = '$current_user' AND date_added >= '$sv_currentStartDate' AND date_added <= '$sv_currentEndDate'";
		$data['surveySubmission'] = $this->Common_model->get_query_result_array($survey_sql);
		if(!empty($data['surveySubmission'])){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/facilities_department_aside.php";
		$data["content_template"] = "survey/facilities_department_form.php";
		$data["content_js"] = "survey/survey_facilities_department_js.php";
		
		if($data['surveyHome'] == 1){
			$this->load->view('dashboard_single_col',$data);
		} else {
			$this->load->view('dashboard',$data);
		}
	 
	}
	
	public function submit_facilities_department_form()
	{
		$current_user = get_user_id();
		$sv_currentDate = CurrMySqlDate();
		$sv_currentMonth = date('m', strtotime($sv_currentDate));
		$sv_currentYear = date('Y', strtotime($sv_currentDate));
		$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);		
		$sv_currentStartDate = date('Y-m-01', strtotime($sv_currentDate)) ." 00:00:00";
		$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
		$survey_sql = "SELECT * from survey_facilities_department WHERE agent_id = '$current_user' AND date_added >= '$sv_currentStartDate' AND date_added <= '$sv_currentEndDate'";
		$submissionCheck = $this->Common_model->get_query_result_array($survey_sql);
		
			$data_array = [
				'agent_id' => $this->input->post('agent_uid'),
				'survey_1' => $this->input->post('survey_1'),
				'survey_1_reason' => $this->input->post('survey_1_reason'),
				'survey_2' => $this->input->post('survey_2'),
				'survey_2_reason' => $this->input->post('survey_2_reason'),
				'survey_3' => $this->input->post('survey_3'),
				'survey_3_reason' => $this->input->post('survey_3_reason'),
				'survey_4' => $this->input->post('survey_4'),
				'survey_5' => $this->input->post('survey_5'),
				'survey_6' => $this->input->post('survey_6'),
				'survey_7' => $this->input->post('survey_7'),
				'survey_8' => $this->input->post('survey_8'),
				'survey_9' => $this->input->post('survey_9'),
				'survey_10' => $this->input->post('survey_10'),
				'survey_11' => $this->input->post('survey_11'),
				'survey_12' => $this->input->post('survey_12'),
				'added_by' => $current_user,
				'date_added' => CurrMySqlDate(),
				'date_added_local' => GetLocalDate(),
				'logs' => get_logs()
			];	
			
		if(!empty($submissionCheck)){
			$this->db->where('id', $submissionCheck[0]['id']);
			$this->db->update('survey_facilities_department', $data_array);
		} else {
			data_inserter('survey_facilities_department', $data_array);			
		}
		
		redirect(base_url('home'));
	
	}
	
	
	public function facilities_department_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$sv_currentDate = CurrMySqlDate();
		$sv_currentMonth = date('m', strtotime($sv_currentDate));
		$sv_currentYear = date('Y', strtotime($sv_currentDate));
		if(!empty($this->input->post('report_month'))){
			$sv_currentMonth = $this->input->post('report_month');
		}
		if(!empty($this->input->post('report_year'))){
			$sv_currentYear = $this->input->post('report_year');
		}
		$data['selected_month'] = $sv_currentMonth;
		$data['selected_year'] = $sv_currentYear;
		
		if(get_role_dir()=="super" || $is_global_access==1 || is_access_tna_reports()){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/facilities_department_aside.php";
		$data["content_template"] = "survey/facilities_department_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_facilities_department_report_xls($officeSelection, $deptSelection, $sv_currentMonth, $sv_currentYear);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	public function generate_facilities_department_report_xls($officeq='', $deptq='', $sv_currentMonth='', $sv_currentYear='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
		
		$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);
		$sv_currentStartDate = $sv_currentYear ."-" .$sv_currentMonth ."-01 00:00:00";
		$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
		
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_facilities_department as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter  AND f.date_added >= '$sv_currentStartDate' AND f.date_added <= '$sv_currentEndDate'";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Facilities Department Service');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Z1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department Support Personnel");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "State one reason");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Guards");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "State one reason");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Utility Crews");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "State one reason");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Cleanliness of the Environment");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Security");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Health & Safety (Sanitation, Disinfection)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Email Responses");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Request Responses");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Pantry Services");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Additional Feedback");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Accounts (Optional)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Site");
		
		$answers_array = array(
			"5" => "Very Satisfied",
			"4" => "Satisfied",
			"3" => "Neutral",
			"2" => "Dissatisfied",
			"1" => "Very Dissatisfied",
		);
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "FACILITIES DEPARTMENT SURVEY");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:P1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('K1', "Survey");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q1:Y1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('Q1', "How satisfied are you with the Measures below handled by Facilities and Engineering Department");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		$this->objPHPExcel->getActiveSheet()->getStyle('K1:P1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		$this->objPHPExcel->getActiveSheet()->getStyle('Q1:Y1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f5f5f5');
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		foreach($report_list as $wk=>$wv)
		{
			$i++;
			$agent_id = $wv['agent_id'];
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_1"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_2"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_3"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_1_reason"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_2_reason"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_3_reason"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_5"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_6"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_7"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_8"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_9"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_10"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_10"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_11"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_12"]);

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DepatmentFacilities_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function facilities_department_analytics()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$sv_currentDate = CurrMySqlDate();
		$sv_currentMonth = date('m', strtotime($sv_currentDate));
		$sv_currentYear = date('Y', strtotime($sv_currentDate));
		if(!empty($this->input->get('report_month'))){
			$sv_currentMonth = $this->input->get('report_month');
		}
		if(!empty($this->input->get('report_year'))){
			$sv_currentYear = $this->input->get('report_year');
		}
		$data['selected_month'] = $sv_currentMonth;
		$data['selected_year'] = $sv_currentYear;
		if(get_role_dir()=="super" || $is_global_access==1 || is_access_tna_reports()){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/facilities_department_aside.php";
		$data["content_template"] = "survey/facilities_department_graphical.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		$data['deptSelected'] = $deptSelection = $get_dept_id;
		if($this->input->get('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
		}
		
		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
		$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);
		$sv_currentStartDate = $sv_currentYear ."-" .$sv_currentMonth ."-01 00:00:00";
		$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
		
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
						  d.description as department, r.name as designation, s.office_id as office, f.*
						  from survey_facilities_department as f
						  LEFT JOIN signin as s ON f.agent_id = s.id
						  LEFT JOIN signin as ls ON ls.id = s.assigned_to
						  LEFT JOIN department as d on d.id=s.dept_id
						  LEFT JOIN role as r on r.id=s.role_id
						  WHERE 1 $extraFilter  AND f.date_added >= '$sv_currentStartDate' AND f.date_added <= '$sv_currentEndDate'";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$answersReport = array();
		$data['total_submission'] = $total_submission = count($report_list);
		
		$answersReport['survey_1'] = $survey_1 = array_count_values(array_column($report_list, 'survey_1'));		
		$answersReport['survey_2'] = $survey_2 = array_count_values(array_column($report_list, 'survey_2'));
		$answersReport['survey_3'] = $survey_3 = array_count_values(array_column($report_list, 'survey_3'));
		$answersReport['survey_4'] = $survey_4 = array_count_values(array_column($report_list, 'survey_4'));
		$answersReport['survey_5'] = $survey_5 = array_count_values(array_column($report_list, 'survey_5'));
		$answersReport['survey_6'] = $survey_6 = array_count_values(array_column($report_list, 'survey_6'));
		$answersReport['survey_7'] = $survey_7 = array_count_values(array_column($report_list, 'survey_7'));
		$answersReport['survey_8'] = $survey_8 = array_count_values(array_column($report_list, 'survey_8'));
		$answersReport['survey_9'] = $survey_9 = array_count_values(array_column($report_list, 'survey_9'));
		$answersReport['survey_12'] = $survey_12 = array_count_values(array_column($report_list, 'survey_12'));
		
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	
	}




//==========================================================================================
///=========================== HR AUDIT SURVEY  ================================///


	public function hr_audit()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveyHome'] = 0;
		if($this->uri->segment(3) == 'check'){
			$data['surveyHome'] = 1;
		}
				
		$data['surveySubmission'] = 0;		
		$sv_currentDate = CurrMySqlDate();
		$sv_currentMonth = date('m', strtotime($sv_currentDate));
		$sv_currentYear = date('Y', strtotime($sv_currentDate));
		$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);		
		$sv_currentStartDate = date('Y-m-01', strtotime($sv_currentDate)) ." 00:00:00";
		$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
		
		$survey_sql = "SELECT * from survey_hr_audit WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_result_array($survey_sql);
		if(!empty($data['surveySubmission'])){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/hr_audit_aside.php";
		$data["content_template"] = "survey/hr_audit_form.php";
		
		if($data['surveyHome'] == 1){
			$this->load->view('dashboard_single_col',$data);
		} else {
			$this->load->view('dashboard',$data);
		}
	 
	}
	
	public function submit_hr_audit_form()
	{
		$current_user = get_user_id();
		$sv_currentDate = CurrMySqlDate();
		$sv_currentMonth = date('m', strtotime($sv_currentDate));
		$sv_currentYear = date('Y', strtotime($sv_currentDate));
		$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);		
		$sv_currentStartDate = date('Y-m-01', strtotime($sv_currentDate)) ." 00:00:00";
		$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
		$survey_sql = "SELECT * from survey_hr_audit WHERE agent_id = '$current_user'";
		$submissionCheck = $this->Common_model->get_query_result_array($survey_sql);
		
			$data_array = [
				'agent_id' => $this->input->post('agent_uid'),
				'job_levl' => $this->input->post('job_levl'),
				'dept' => $this->input->post('dept'),
				'tenure' => $this->input->post('tenure'),
				'hr_assist' => $this->input->post('hr_assist'),
				'survey_1' => $this->input->post('survey_1'),
				'survey_1a' => $this->input->post('survey_1a'),
				'survey_1b' => $this->input->post('survey_1b'),
				'survey_1c' => $this->input->post('survey_1c'),
				'survey_1_reason' => $this->input->post('survey_1_reason'),
				'survey_2' => $this->input->post('survey_2'),
				'survey_2a' => $this->input->post('survey_2a'),
				'survey_2b' => $this->input->post('survey_2b'),
				'survey_2c' => $this->input->post('survey_2c'),
				'survey_2_reason' => $this->input->post('survey_2_reason'),
				'survey_3' => $this->input->post('survey_3'),
				'survey_3a' => $this->input->post('survey_3a'),
				'survey_3b' => $this->input->post('survey_3b'),
				'survey_3c' => $this->input->post('survey_3c'),
				'survey_3_reason' => $this->input->post('survey_3_reason'),
				'survey_4' => $this->input->post('survey_4'),
				'survey_4a' => $this->input->post('survey_4a'),
				'survey_4b' => $this->input->post('survey_4b'),
				'survey_4c' => $this->input->post('survey_4c'),
				'survey_4d' => $this->input->post('survey_4d'),
				'survey_4_reason' => $this->input->post('survey_4_reason'),
				'survey_5' => $this->input->post('survey_5'),
				'survey_6' => $this->input->post('survey_6'),
				'added_by' => $current_user,
				'date_added' => CurrMySqlDate(),
				'date_added_local' => GetLocalDate(),
				'logs' => get_logs()
			];	
			
		if(!empty($submissionCheck)){
			$this->db->where('id', $submissionCheck[0]['id']);
			$this->db->update('survey_hr_audit', $data_array);
		} else {
			data_inserter('survey_hr_audit', $data_array);			
		}
		
		redirect(base_url('home'));
	
	}



	public function hr_audit_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$sv_currentDate = CurrMySqlDate();
		$sv_currentMonth = date('m', strtotime($sv_currentDate));
		$sv_currentYear = date('Y', strtotime($sv_currentDate));
		if(!empty($this->input->post('report_month'))){
			$sv_currentMonth = $this->input->post('report_month');
		}
		if(!empty($this->input->post('report_year'))){
			$sv_currentYear = $this->input->post('report_year');
		}
		$data['selected_month'] = $sv_currentMonth;
		$data['selected_year'] = $sv_currentYear;
		
		if(get_role_dir()=="super" || $is_global_access==1 || is_access_tna_reports()){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/hr_audit_aside.php";
		$data["content_template"] = "survey/hr_audit_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_hr_audit_report_xls($officeSelection, $deptSelection, $sv_currentMonth, $sv_currentYear);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}



	public function generate_hr_audit_report_xls($officeq='', $deptq='', $sv_currentMonth='', $sv_currentYear='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
		
		$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);
		$sv_currentStartDate = $sv_currentYear ."-" .$sv_currentMonth ."-01 00:00:00";
		$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
		
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_hr_audit as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AG1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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

		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Job Level");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Tenure");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "contact HR for assistance");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR responds to questions and inquiries in a timely manner");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR is available on the days and hours that needed");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "know whom to contact in HR for specific concerns");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Comments or suggestions for improvement");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR exhibits solid understanding of HR issues");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR provides accurate, helpful information");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "All issues discussed with HR are kept confidential");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Comments or suggestions for improvement");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR treats with courtesy and respect");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR is an easy department to work with");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR has a clear understanding of their customers need");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Comments or suggestions for improvement");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR continually improves its programs");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR department is able to rapidly initiate programs");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HR decisions/counsel are not biased in favor of any one group");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "The benefits information that HR provided is easy to understand");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Comments or suggestions for improvement");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Overall, how satisfied with the servicing of HR");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Is there anything else that you would like to add to improve overall HR experience");

		$answers_array2 = array(
			"5" => "Extremely Satisfied",
			"4" => "Somewhat Satisfied",
			"3" => "Satisfied",
			"2" => "Somewhat Dissatisfied",
			"1" => "Extremely Dissatisfied",
		);
		$answers_array = array(
			"5" => "Very Satisfied",
			"4" => "Satisfied",
			"3" => "Neutral",
			"2" => "Dissatisfied",
			"1" => "Very Dissatisfied",
		);
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:N1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "HR AUDIT SURVEY");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('O1:R1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('O1', "Access and Availability");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('S1:V1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('S1', "Reliability");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('W1:Z1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('W1', "Customer Relations");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA1:AE1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AA1', "HR Policies and Procedures");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AF1:AG1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AF1', "Satisfaction & Suggestion");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AG2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AG2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		$this->objPHPExcel->getActiveSheet()->getStyle('O1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		$this->objPHPExcel->getActiveSheet()->getStyle('S1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		$this->objPHPExcel->getActiveSheet()->getStyle('W1:Z1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		$this->objPHPExcel->getActiveSheet()->getStyle('AA1:AE1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		
		// $yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		// $noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		// print_r($report_list); exit;
		foreach($report_list as $wk=>$wv)
		{
			$i++;
			$agent_id = $wv['agent_id'];
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["job_levl"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["dept"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["tenure"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["hr_assist"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_1a"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_1b"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_1c"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_1_reason"]);

			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_2a"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_2b"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_2c"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_2_reason"]);

			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_3a"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_3b"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_3c"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_3_reason"]);

			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_4a"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_4b"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_4c"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array[$wv["survey_4d"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_4_reason"]);

			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $answers_array2[$wv["survey_5"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_6"]);
			

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="HR_AUDIT_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}





//==========================================================================================
///=========================== AMERIDIAL PARTICIPANT SURVEY ===============================///
	
	
	public function ameridial_participant()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['surveyHome'] = 0;
		if($this->uri->segment(3) == 'check'){
			$data['surveyHome'] = 1;
		}
				
		$data['surveySubmission'] = 0;		
		$survey_sql = "SELECT * from survey_ameridial_participant WHERE agent_id = '$current_user'";
		$data['surveySubmission'] = $this->Common_model->get_query_result_array($survey_sql);
		if(!empty($data['surveySubmission'])){ $data['surveySubmission'] = 1; }
		
		$data["aside_template"] = "survey/ameridial_participant_aside.php";
		$data["content_template"] = "survey/ameridial_participant_form.php";
		$data["content_js"] = "survey/survey_ameridial_participant_js.php";
		
		if($data['surveyHome'] == 1){
			$this->load->view('dashboard_single_col',$data);
		} else {
			$this->load->view('dashboard',$data);
		}
	 
	}
	
	public function submit_ameridial_participant_form()
	{
		$current_user = get_user_id();
		$survey_sql = "SELECT * from survey_ameridial_participant WHERE agent_id = '$current_user'";
		$submissionCheck = $this->Common_model->get_query_result_array($survey_sql);
		
		$survey_12 = $this->input->post('survey_12');
		$survey_12_values = "";
		if(!empty($survey_12)){
			$survey_12_values = implode(',',$survey_12);
		}
		
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'survey_1' => $this->input->post('survey_1'),			
			'survey_2' => $this->input->post('survey_2'),
			'survey_2_reason' => $this->input->post('survey_2_reason'),
			'survey_3' => $this->input->post('survey_3'),			
			'survey_4' => $this->input->post('survey_4'),
			'survey_5' => $this->input->post('survey_5'),
			'survey_6' => $this->input->post('survey_6'),
			'survey_7' => $this->input->post('survey_7'),
			'survey_8' => $this->input->post('survey_8'),
			'survey_9' => $this->input->post('survey_9'),
			'survey_10' => $this->input->post('survey_10'),
			'survey_10_reason' => $this->input->post('survey_10_reason'),
			'survey_11' => $this->input->post('survey_11'),
			'survey_12' => $survey_12_values,
			'survey_12_reason' => $this->input->post('survey_12_reason'),
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'date_added_local' => GetLocalDate(),
			'logs' => get_logs()
		];	
			
		if(!empty($submissionCheck)){
			$this->db->where('id', $submissionCheck[0]['id']);
			$this->db->update('survey_ameridial_participant', $data_array);
		} else {
			data_inserter('survey_ameridial_participant', $data_array);			
		}
		
		//redirect($_SERVER['HTTP_REFERER']);
		redirect(base_url('home'));
	
	}
	
	
	public function ameridial_participant_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1 || is_access_tna_reports()){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/ameridial_participant_aside.php";
		$data["content_template"] = "survey/ameridial_participant_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->post('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->post('report_dept_id');
			$this->generate_ameridial_participant_report_xls($officeSelection, $deptSelection, $sv_currentMonth, $sv_currentYear);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	public function generate_ameridial_participant_report_xls($officeq='', $deptq='', $sv_currentMonth='', $sv_currentYear='')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		$get_office_id = $officeq;
		$get_department_id = $deptq;
		if(!empty($get_office_id) && $get_office_id != "ALL"){
			$extraFilter .= " AND s.office_id = '$get_office_id' ";
		}
		if(!empty($get_department_id) && $get_department_id != "ALL"){
			$extraFilter .= " AND s.dept_id = '$get_department_id' ";
		}
		
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from survey_ameridial_participant as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraFilter";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Ameridal Participant Survey');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Z1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Are you currently contributing to your employer-sponsored retirement plan?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "If not contributing, why?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Other Reason");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "When I retire, my investments will represent of my retirement income");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "I am familiar with how to log on to utilize the retirement plan website");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "I feel like I am");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "I understand how to balance saving for retirement with saving for other financial goals");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, " I understand the investment lineup available for my retirement plan and the different options I have");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "I understand my retirement plan features / benefits");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "I understand the difference between my pre-tax and after-tax (Roth) contributions");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Over the last 12 months, how often have you reviewed your retirement account");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Other Remarks");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "I have designated beneficiaries for my employer-sponsored retirement plan");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Which of the financial topics are you interested in learning more about?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Other Remarks");
		
		$survey_op_1 = array(
			"Yes" => "I currently contribute to my plan",	
			"No" => "I am not contributing",
		);
		$survey_op_2 = array(
			"A" => "Budget Restraints",
			"B" => "Investing Elsewhere",
			"C" => "Lack of Knowledge of the Benefit",
			"D" => "Lack of Knowledge of Investing",
			"E" => "Contributing to Spouse/Partner's Plan",
			"OTHER" => "Other",
		);
		$survey_op_3 = array(
			"A" => "A minor part (less than 25%)",
			"B" => "An important part (25-75%)",
			"C" => "The majority (over 75%)",
		);
		$survey_op_4 = array(
			"A" => "Strongly Disagree",
			"B" => "Disagree",
			"C" => "Neutral/Not sure",
			"D" => "Agree",
			"E" => "Strongly Agree",
		);
		$survey_op_5 = array(
			"A" => "Ahead of my retirement savings goal",
			"B" => "On target to my retirement savings goal",
			"C" => "Slightly behind my retirement savings goal",
			"D" => "Far from reaching my retirement savings goal",
		);
		$survey_op_10 = array(
			"A" => "Every Month",
			"B" => "Every 2 Months",
			"C" => "Quaterly",
			"D" => "Every 6 months",
			"E" => "I haven't reviewed my retirement account",
			"OTHER" => "Other",
		);
		$survey_op_11 = array(
			"Yes" => "Yes",
			"No" => "No",
		);
		$survey_op_12 = array(
			"A" => "Retirement plan basics",
			"B" => "Financial health and financial planning",
			"C" => "Investment strategy",
			"D" => "Debt management",
			"E" => "Preparing for a financial emergency",
			"F" => "Nearing retirement",
			"G" => "Paying for college",
			"H" => "Tax considerations",
			"I" => "Navigating COVID-19 or financial uncertainty",
			"OTHER" => "Other",
		);
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "AMERIDIAL PARTICIPANT SURVEY");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:Z1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('K1', "Survey Questions");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		$this->objPHPExcel->getActiveSheet()->getStyle('K1:Z1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		foreach($report_list as $wk=>$wv)
		{
			$i++;
			$agent_id = $wv['agent_id'];
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["date_added"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_1[$wv["survey_1"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_2[$wv["survey_2"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_2_reason"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_3[$wv["survey_3"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_4[$wv["survey_4"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_5[$wv["survey_5"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_4[$wv["survey_6"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_4[$wv["survey_7"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_4[$wv["survey_8"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_4[$wv["survey_9"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_10[$wv["survey_10"]]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_10_reason"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_op_11[$wv["survey_11"]]);
			
			$survey_12 = $wv["survey_12"];
			$survey_12_data = "";
			if(!empty($survey_12)){
				$survey_12_ar = explode(',', $survey_12);
				$survey_12_values = array();
				foreach($survey_12_ar as $survey_12_token){
					$survey_12_values[] = $survey_op_12[$survey_12_token];
				}
				if(!empty($survey_12_values)){
					$survey_12_data = implode(', ', $survey_12_values);
				}
			}
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $survey_12_data);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["survey_12_reason"]);

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Ameridial_Participant_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function ameridial_participant_analytics()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1 || is_access_tna_reports()){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "survey/ameridial_participant_aside.php";
		$data["content_template"] = "survey/ameridial_participant_graphical.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		$data['deptSelected'] = $deptSelection = $get_dept_id;
		if($this->input->get('report_office_id') != ""){
			$data['OfficeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
		}
		
		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
		
		$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
						  d.description as department, r.name as designation, s.office_id as office, f.*
						  from survey_ameridial_participant as f
						  LEFT JOIN signin as s ON f.agent_id = s.id
						  LEFT JOIN signin as ls ON ls.id = s.assigned_to
						  LEFT JOIN department as d on d.id=s.dept_id
						  LEFT JOIN role as r on r.id=s.role_id
						  WHERE 1 $extraFilter";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$answersReport = array();
		$data['total_submission'] = $total_submission = count($report_list);
		
		$answersReport['survey_1'] = $survey_1 = array_count_values(array_column($report_list, 'survey_1'));		
		$answersReport['survey_2'] = $survey_2 = array_count_values(array_column($report_list, 'survey_2'));
		$answersReport['survey_3'] = $survey_3 = array_count_values(array_column($report_list, 'survey_3'));
		$answersReport['survey_4'] = $survey_4 = array_count_values(array_column($report_list, 'survey_4'));
		$answersReport['survey_5'] = $survey_5 = array_count_values(array_column($report_list, 'survey_5'));
		$answersReport['survey_6'] = $survey_6 = array_count_values(array_column($report_list, 'survey_6'));
		$answersReport['survey_7'] = $survey_7 = array_count_values(array_column($report_list, 'survey_7'));
		$answersReport['survey_8'] = $survey_8 = array_count_values(array_column($report_list, 'survey_8'));
		$answersReport['survey_9'] = $survey_9 = array_count_values(array_column($report_list, 'survey_9'));
		$answersReport['survey_10'] = $survey_12 = array_count_values(array_column($report_list, 'survey_10'));
		$answersReport['survey_11'] = $survey_12 = array_count_values(array_column($report_list, 'survey_11'));
		
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	
	}







	
	
}
	