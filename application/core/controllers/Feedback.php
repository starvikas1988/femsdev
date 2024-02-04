<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->model('email_model');
		$this->load->model('Feedback_email_model');		
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){
				
		redirect(base_url()."feedback/mpower");
	 
	}
	
	public function mpower()
	{		
		
		$data['type'] = "form";
		$last = $this->uri->total_segments();
		$record_num = $this->uri->segment($last);
		if($record_num == 'thanks'){ $data['type'] = "done"; }
		
		$emailID = $this->input->post('eid');
		if(empty($emailID)){ $emailID = $this->input->get('eid'); }
		
		$crmID = $this->input->post('cid');
		if(empty($crmID)){ $crmID = $this->input->get('cid'); }
		
		// GET URL DATA
		$feedData = $this->uri->segment(3);
		if(!empty($feedData)){
			$feedData = base64_decode(urldecode($feedData));
			$feedArray = explode('#', $feedData);
			if($feedArray[0] == 'data')
			{
				$emailID = $feedArray[2];
				$crmID = $feedArray[1];
				$crmSqlDetails = "SELECT c.c_feedback_id, c.crm_id as c_crm_id, f.* from crm_mpower as c LEFT JOIN feedback_mpower as f ON f.id = c.c_feedback_id WHERE c.crm_id = '$crmID' ORDER by id DESC LIMIT 1";
				$crmDetails = $this->Common_model->get_query_row_array($crmSqlDetails);
				if(!empty($crmDetails['c_feedback_id'])){ $data['type'] = "done"; }
			}
		}
		$data['crmID'] = $crmID;
		$data['emailID'] = $emailID;
		
		//$data["content_template"] = "feedback/mpower_form.php";		
		//$this->load->view('public_single_col',$data);
		
		$this->load->view('feedback/mpower_form',$data);
	 
	}
	
	public function mpower_view()
	{		
		
		$data['type'] = "form";
		$last = $this->uri->total_segments();
		$record_num = $this->uri->segment($last);
		if($record_num == 'thanks'){ $data['type'] = "done"; }
		
		$emailID = $this->input->post('eid');
		if(empty($emailID)){ $emailID = $this->input->get('eid'); }
		
		$crmID = $this->input->post('cid');
		if(empty($crmID)){ $crmID = $this->input->get('cid'); }
		
		$crmDetails = array();
		// GET URL DATA
		$feedData = $this->uri->segment(3);
		if(!empty($feedData)){
			$feedData = base64_decode(urldecode($feedData));
			$feedArray = explode('#', $feedData);
			if($feedArray[0] == 'data')
			{
				$emailID = $feedArray[2];
				$crmID = $feedArray[1];
				$crmSqlDetails = "SELECT c.c_feedback_id, c.crm_id as c_crm_id, f.* from crm_mpower as c LEFT JOIN feedback_mpower as f ON f.id = c.c_feedback_id WHERE c.crm_id = '$crmID' ORDER by id DESC LIMIT 1";
				$crmDetails = $this->Common_model->get_query_row_array($crmSqlDetails);
			}
		}
		$data['crmID'] = $crmID;
		$data['emailID'] = $emailID;
		$data['crmDetails'] = $crmDetails;
		
		//$data["content_template"] = "feedback/mpower_form.php";		
		//$this->load->view('public_single_col',$data);
		
		$this->load->view('feedback/mpower_form_view',$data);
	 
	}
	
	public function mpower_send(){
		
		$toEmail = $this->input->post('form_email_id');
		$toCrmID = $this->input->post('form_crm_id');
		if(!empty($toEmail) && !empty($toCrmID))
		{
			$this->Feedback_email_model->mpower_send_feedback($toCrmID, $toEmail, '', 2);
			
			$updateData = [ 'c_feedback_mail' => 1 ];
			$this->db->where('crm_id', $toCrmID);
			$this->db->update('crm_mpower', $updateData);
			
			redirect($_SERVER['HTTP_REFERER'] ."/sent");
			
		} else {
			redirect($_SERVER['HTTP_REFERER'] ."/error");
		}
			
	}
	
	
	public function mpower_submit()
	{		
		$customer_crm = $this->input->post('crm_id');
		$customer_email = $this->input->post('email_id');
		$customer_experience = $this->input->post('experience');
		$customer_customer = $this->input->post('customer');
		$customer_likely = $this->input->post('likely');
		$customer_resolution = $this->input->post('resolution');
		$customer_comments = $this->input->post('comments');
		
		$user_ref = "";
		$this->load->library('user_agent');
		$user_agent = $this->agent->agent_string();
		$user_ip = $this->input->ip_address();
		$max_experience = 1;
		if(!empty($customer_experience)){
			$max_experience = max($customer_experience);
		}
		
		$max_customer = 1;
		if(!empty($customer_customer)){
			$max_customer = max($customer_customer);
		}
		
		$max_resolution = 1;
		if(!empty($customer_resolution)){
			$max_resolution = max($customer_resolution);
		}
		
		$max_likely = 0;
		if(!empty($customer_likely)){
			$max_likely = max($customer_likely);
		}
		
		//$getloc = json_decode(file_get_contents("http://ipinfo.io/"));
		//$city = $getloc->city;
		//$country = $getloc->country;
		//$user_country = $country;
		
		$currentDate = date('Y-m-d H:i:s');
		$dataArray = [
			"crm_id" => $customer_crm,
			"customer_email" => $customer_email,
			"customer_service" => $max_experience,
			"customer_experience" => $max_customer,
			"customer_comments" => $customer_comments,
			"customer_recommend" => $max_likely,
			"customer_resolution" => $max_resolution,
			"customer_agent" => $user_agent,
			"customer_ip" =>  $user_ip,
			//"customer_country" => $user_country,
			"customer_ref" => $user_ref,
			"date_added" => $currentDate
		];
		$fededbackID = data_inserter('feedback_mpower', $dataArray);
		
		if(!empty($fededbackID) && !empty($customer_crm))
		{
			$updateArray = [ 
				"c_feedback_id" =>  $fededbackID,		
			];
			$this->db->where('crm_id', $customer_crm);
			$this->db->update('crm_mpower', $updateArray);
			
			$cl_interval = "00:00:00";
			$cl_added_by = "1";
			$logs_array = [
				'crm_id' => $customer_crm,
				'cl_disposition' => 'feedback',
				'cl_comments' => $fededbackID,
				'cl_interval' => $cl_interval,
				'cl_added_by' => $cl_added_by,
				'cl_date_added' => $currentDate,
				'cl_date_added_local' => $currentDate,
				'cl_logs' => $customer_email
			]; 
			data_inserter('crm_mpower_logs', $logs_array);
		}
		
		redirect($_SERVER['HTTP_REFERER'] .'/thanks');
		
	}
	
	public function mpower_reports(){
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data["aside_template"] = "mpower_crm/aside.php";
		$data["content_template"] = "feedback/mpower_reports.php";
		$data["content_js"] = "feedback/mpower_reports_js.php";
				
		$month = date('m');
		$year = date('Y');
		$extraFilter = "";
		
		// FILTER DATE CHECK
		$startDate = CurrDate();
		$endDate   = CurrDate();		
		$start_time = "00:00:00";
		$end_time   = "23:59:59";
		
		$selectMonth = $this->input->get('monthSelect');
		$selectYear = $this->input->get('yearSelect');
		if(!empty($selectMonth)){ $month = $selectMonth; }
		if(!empty($selectYear)){  $year = $selectYear; }
		
		$startDate = $year ."-".$month."-01";
		$endDate = $year ."-".$month."-".cal_days_in_month(CAL_GREGORIAN,$month,$year);
		$startDateFull = $startDate ." " .$start_time;
		$endDateFull = $endDate ." " .$end_time;
		$extraFilter .= " AND (f.date_added >= '$startDateFull' AND f.date_added <= '$endDateFull') ";
		$extraFilterC .= " AND (m.date_added >= '$startDateFull' AND m.date_added <= '$endDateFull') ";
		
		$data['selected_month'] = $month;
		$data['selected_year'] = $year;
		
		//$reports_sql = "SELECT * from feedback_mpower";					 
		$reports_sql = "SELECT f.* FROM crm_mpower as m INNER JOIN feedback_mpower as f ON f.id = m.c_feedback_id WHERE 1 $extraFilterC";					 
		$data['report_array'] = $report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		// TOTAL FEEDBACK
		$crmFeedback = "SELECT count(*) as value from crm_mpower as m LEFT JOIN feedback_mpower as f ON f.id = m.c_feedback_id WHERE 1 $extraFilterC";
		$data['totalCRMCount'] = $this->Common_model->get_single_value($crmFeedback);
		$data['totalFeedbackCount'] = count($report_list);
		
		$answersReport = array();
		$data['total_submission'] = $total_submission = count($report_list);
		
		$answersReport['customer_service'] = $survey_1 = array_count_values(array_column($report_list, 'customer_service'));		
		$answersReport['customer_experience'] = $survey_2 = array_count_values(array_column($report_list, 'customer_experience'));
		$answersReport['customer_recommend'] = $survey_3 = array_count_values(array_column($report_list, 'customer_recommend'));
		$answersReport['customer_resolution'] = $survey_4 = array_count_values(array_column($report_list, 'customer_resolution'));
		
		//echo "<pre>".print_r($answersReport, 1)."</pre>"; die();
		$data['answers'] = $answersReport;		
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function generate_feedback_reports($from_date ='', $to_date='', $call_type='')
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

		$month = $this->input->get('monthSelect');
		$year = $this->input->get('yearSelect');
		$startDate = $year ."-".$month."-01";
		$endDate = $year ."-".$month."-".cal_days_in_month(CAL_GREGORIAN,$month,$year);
		
		if(!empty($this->input->get('start')))
		{ 
			$startDate = date('Y-m-d',strtotime($this->input->get('start')));
			$endDate = date('Y-m-d',strtotime($this->input->get('end')));			
		}		
		$startDateFull = $startDate ." " .$start_time;
		$endDateFull = $endDate ." " .$end_time;
		$extraFilter .= " AND (f.date_added >= '$startDateFull' AND f.date_added <= '$endDateFull') ";
		$extraFilterC .= " AND (c.date_added >= '$startDateFull' AND c.date_added <= '$endDateFull') ";
					
		$sqlcase = "SELECT f.* from  feedback_mpower as f INNER JOIN crm_mpower as c ON c.c_feedback_id = f.id
					WHERE 1 $extraFilter";
		$crm_list = $this->Common_model->get_query_result_array($sqlcase);
		
		$title = "MPOWER";
		$sheet_title = "MPOWER - CUSTOMER FEEDBACK (" .date('Y-m-d',strtotime($startDateFull)) ." - " .date('Y-m-d',strtotime($endDateFull)).")";
		$file_name = "Mpower_Feedback_Records_".date('Y-m-d',strtotime($from_date));
		
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:L1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true);
		$objWorksheet->getColumnDimension('K')->setAutoSize(true);
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $sheet_title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "CRM ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Customer Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Customer Email");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Rate based on Courtesy");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Rate based on Product knowledge");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Rate based on Resolution");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Rate based on Entire Experience with the Company");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Comments");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Customer Phone");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Customer Ref ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date Added");
		
		
			
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{	
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["crm_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_fname"] ." " .$wv["c_lname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["customer_email"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["customer_service"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["customer_experience"]);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["customer_resolution"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["customer_recommend"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["customer_comments"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_phone_no"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_call_ref"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added"])));
			$i++;			
		}
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:L'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	public function test_mail()
	{
		$this->Feedback_email_model->test_mail();
	}
	public function submit_test()
	{
		print_r($_POST);
	}
	
}