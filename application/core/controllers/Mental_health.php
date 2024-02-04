<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mental_health extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
//==========================================================================================
///=========================== Mental Health Capabilities  ================================///
	
	public function index(){
				
		redirect(base_url()."mental_health/survey");
	 
	}
	 
	
	
	public function survey()
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
		
		$data['docuSubmission'] = 0;
		$docusign_sql = "SELECT count(*) as value from survey_mental_health WHERE agent_id = '$current_user'";
		$data['docusign'] = $this->Common_model->get_single_value($docusign_sql);
		//if(count($data['docusign']) > 0){ $data['docuSubmission'] = 1; }
		
		$data["aside_template"] = "survey_mental_health/aside.php";
		$data["content_template"] = "survey_mental_health/survey_form.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function survey_list()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
				
		$docusign_sql = "SELECT m.*, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id from survey_mental_health as m
						 LEFT JOIN signin as s ON s.id = m.agent_id
		                 WHERE m.agent_id = '$current_user'";
		$data['docusignList'] = $this->Common_model->get_query_result_array($docusign_sql);
		
		$data['rating_array'] = array(
			"G" => "Good",
			"V" => "Very Good",
			"P" => "Poor",
			"E" => "Excellent",
		);
		
		$data["aside_template"] = "survey_mental_health/aside.php";
		$data["content_template"] = "survey_mental_health/survey_list.php";
		$data["content_js"] = "survey/survey_mental_health_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	 
	
	public function submit_mental_health_form()
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
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'logs' => get_logs()
		];
		
		data_inserter('survey_mental_health', $data_array);
		redirect(base_url()."mental_health/survey");
	
	}
	
	public function survey_reports()
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
		$data["content_template"] = "survey_mental_health/survey_reports.php";
		
		if($this->input->post('excel_office_id')){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('excel_office_id');
			$this->generate_survey_report_xls($officeSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_survey_report_xls($officeq)
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
							  from survey_mental_health as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraoffice ORDER by s.fusion_id";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Mental Health Survey');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:S1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "felt nervous, anxious or on edge");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "felt not being able to stop or control worrying");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "worrytoo much about different things");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "trouble relaxing");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "so restless that it is hard to sit still");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "easily annoyed or irritable");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "felt afraid, as if something awful might happen");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "felt down, depressed, or hopeles");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "thoughts that you would be better off dead, or of hurting yourself");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Rate your mental health");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$answers_array = array(
			"1" => "Not at all",
			"2" => "Several days",
			"3" => "More than half the days",
			"4" => "Nearly every day",
		);
		
		$rating_array = array(
			"G" => "Good",
			"V" => "Very Good",
			"P" => "Poor",
			"E" => "Excellent",
		);
		
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "MENTAL HEALTH STATUS SURVEY");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
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
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $rating_array[$wv["survey_10"]]);
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Mental_Health_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
}
	