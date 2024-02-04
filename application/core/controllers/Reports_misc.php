<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_misc extends CI_Controller {

    private $aside = "reports_misc/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////


    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Email_model');
		$this->load->model('Dfr_model');
		$this->reports_model->set_report_database("report");
		
		$this->objPHPExcel = new PHPExcel();
		
	 }


	///////////////////////////////////////////////////////////////////////////////////////////////	
/*-------------------Policy Acceptance-----------------------------*/	
	
	public function policy_acceptance_report_list(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$user_oth_office=get_user_oth_office();
			
			$ofc_id=="";
			if($user_oth_office!="") $ofc_id = "'".implode("','",explode(",",$user_oth_office))."'";
			
						
			$inOffice = "'".$user_office_id."'";
			if($ofc_id!="") $inOffice = $inOffice.",".$ofc_id;
						
			if(isDisableFusionPolicy()== false) $inOffice = "'ALL',".$inOffice;
				
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/policy_acceptance_report.php";
			
			$policy_id="";
			$action="";
			$dn_link="";
			
			if($is_global_access==1){
				$qSql="Select id, title ,office_id from policy_list where is_active=1 order by office_id ";
				$data['get_title'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				
				$qSql="Select id, title,office_id from policy_list where office_id in ($inOffice) and is_active=1 order by office_id ";
				//echo $qSql;
				$data['get_title'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["policy_acceptance_list"] = array();
			
			$policy_id = $this->input->get('policy_id');
			
			$qSql="Select title from policy_list where id='$policy_id'";
			$data['policy_title'] = $this->Common_model->get_query_result_array($qSql);
			
			
			if($this->input->get('show')=='Show')
			{
				
				$field_array = array(
						"policy_id" => $policy_id,
					);
			
				$fullAray = $this->reports_model->get_policy_acceptance_report($field_array);
				$data["policy_acceptance_list"] = $fullAray;
				
				$this->create_policyAcceptance_CSV($fullAray);
					
				$dn_link = base_url()."reports_misc/downloadpolicyAcceptance";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['policy_id'] = $policy_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadpolicyAcceptance()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="policy_acceptance_report-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_policyAcceptance_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Title", "Accepted By", "Fusion ID", "XPOID", "OMUID", "Location", "Designation", "Acceptance Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['policy_titile'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['userRoleName'].'",'; 
			$row .= '"'.$user['accptdate'].'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	} 


	public function vrs_list()
	{ 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		$extraFilter = "";
		$ticket_no = "";
		$extraLimit = "LIMIT 500";
		$start_time = "00:00:00";
		$end_time = "23:59:59";
		$extraLimit = " LIMIT 200";
		$list_pay = "SELECT DISTINCT pay_period FROM pm_vrs_bonus";		
		$data['pay_period_list'] = $this->Common_model->get_query_result_array($list_pay);
		$list_post = "SELECT DISTINCT post_period FROM pm_vrs_bonus";		
		$data['post_period_list'] = $this->Common_model->get_query_result_array($list_post);
		// var_dump($data);
		// FILTER 
		$data['searched'] = 0;
		if(!empty($this->input->get('post_period')))
		{ 
			$post_period = $this->input->get('post_period');
			$extraFilter .= " AND p.post_period = '$post_period' ";
			$extraLimit = "";
			$data['searched'] = 1;
		}

		if(!empty($this->input->get('pay_period')))
		{ 
			$pay_period = $this->input->get('pay_period');
			$extraFilter .= " AND p.pay_period = '$pay_period' ";
			$extraLimit = "";
			$data['searched'] = 1;
		}
		
		$data['post_period'] = $post_period;
		$data['pay_period'] = $pay_period;
		
		
		$list_sql = "SELECT p.*, CONCAT(s.fname,' ', s.lname) as fullname
		            FROM pm_vrs_bonus as p
					LEFT JOIN signin as s ON s.fusion_id = p.fems_id				
					WHERE 1 $extraFilter ORDER by id DESC $extraLimit";	
		
		if($data['searched'] == 1){
			$data['vrsList'] = $this->Common_model->get_query_result_array($list_sql);
		}
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/vrs_list.php";
		//$data["content_js"] = "downtime/downtime_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}

	
	public function vrs_reports()
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
		
		$post_period = "";
		$pay_period = "";
		if(!empty($this->input->get('post_period')))
		{ 
			$post_period = $this->input->get('post_period');
			// $extraFilter .= " AND post_period = '$post_period' ";
		}

		if(!empty($this->input->get('pay_period')))
		{ 
			$pay_period = $this->input->get('pay_period');
			// $extraFilter .= " AND pay_period = '$pay_period' ";
		}
		

		$this->generate_vrs_report_xls($post_period, $pay_period);
		
		// $this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_vrs_report_xls($post_period="", $pay_period="")
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		if(!empty($post_period)){
			$extraFilter .= " AND p.post_period = '$post_period' ";
		}
		if(!empty($pay_period)){
			$extraFilter .= " AND p.pay_period = '$pay_period' ";
		}
		
		$reports_sql = "SELECT p.*, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id,
		               r.name as designation, get_process_names(s.id) as process_name 
						FROM pm_vrs_bonus as p
						LEFT JOIN signin as s ON s.fusion_id = p.fems_id
						LEFT JOIN role as r ON r.id = s.role_id	
						WHERE 1 $extraFilter ORDER by id DESC";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('VRS Fems Reports');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Pay Period");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Post Period");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Erps");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Collector Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Unit");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Eligibile");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fees");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Budget");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Over Under");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Class");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Plan");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Level");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Raw Per");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Qm Avg");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Kqm");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Pro R");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Base Bonus");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Kicker");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Misc Bonus");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Total Bonus");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Deductions");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Accepted On");
				
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
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "VRS FEMS REPORTS");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AB2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AB2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];
			$acceptedOn =  "";
			if(!empty($wv['accepted_on']) && $wv['accepted_on'] != "0000-00-00"){ $acceptedOn =  date('d M, Y', strtotime($wv['accepted_on'])); } else { $acceptedOn =  " - "; } 
			
			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fems_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["pay_period"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["post_period"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["erps_id"]);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["collector_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["unit"]);
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('h:i A', strtotime($wv["issue_time"])));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["eligible"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fees"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["budget"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["over_under"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["class"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["plan"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["level"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["raw_per"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["qm_avg"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["kqm"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["pro_r"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["base_bonus"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["kicker"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["misc_bonus"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["total_bonus"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["deductions"]);		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $acceptedOn);		
			// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["class"]);		
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Vrs_Fems.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}

	 	//========================== REPORTS =====================================//
	
	public function patient_report()
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
		
		if(!empty($this->input->get('start')))
		{	
			// FILTER DATE CHECK
			$from_date = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
		
			// GET DATA
			$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from clinic_patient as c LEFT JOIN signin as s ON s.id = c.added_by WHERE 1 $extraFilter";
			$crm_list = $this->Common_model->get_query_result_array($sqlcase);
			
			$report_type = $this->input->get('rtype');
			if($report_type == 'excel')
			{
				$this->generate_patient_report_xls($from_date, $to_date, $crm_list);
			}
			if($report_type == 'pdf')
			{
				$excelReport = $this->generate_patient_report_xls($from_date, $to_date, $crm_list, $report_type);
				$this->generate_patient_archieve($crm_list, $excelReport);
			}			
		}
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/clinic_reports.php";
		
		$reportAside = $this->uri->segment(3);		
		if($reportAside == "view"){ $data["aside_template"] = "reports_misc/aside.php"; }
		
		$this->load->view('dashboard',$data);
	 
	}
	
	//====================== GENERATE ARCHIEVE ===========================//
	
	public function generate_patient_archieve($reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "clinic_patient_archieve"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/clinic_patient_report.xlsx";
		$this->zip->read_file($csvfile, "clinic_patient_report.xlsx");
		
        foreach ($reportArray as $token)
		{
			$patient_id   = $token["patient_code"];
			$fullnameAr  = explode(' ', $token["c_name"]);
			$firstname = !empty($fullnameAr[0]) ? $fullnameAr[0] : "";
			$fileName = FCPATH.'/uploads/clinic_portal/'.$patient_id.'/'.'clinic_patient_' .$patient_id.'.pdf';
			
			$newFileName = "patient_".$patient_id."_".$firstname.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName)){
				$this->zip->read_file($fileName, $newFileName);
			}			
        }
		
        $this->zip->download($zipFileName.'.zip');		
	}
	
	
	///===================== PDF REPORT =================================//
	
	public function generate_patient_report_pdf($pid = '1', $type = 'D')
	{			
		if(check_logged_in()){
				
			$this->load->library('m_pdf');
			
			$patient_id = $pid;
			if(!empty($this->uri->segment(3))){ $patient_id = $this->uri->segment(3); }			
			if(!empty($this->uri->segment(4))){ 
				if($this->uri->segment(4) == 'download'){ $type = 'D'; } 
				if($this->uri->segment(4) == 'view'){ $type = 'I'; }
			}			
			
			// CHECK DB VERIFY		
			if(!empty($patient_id))
			{
				$patient_sql = "SELECT p.*, CONCAT(s.fname, ' ', s.lname) as added_by_name from clinic_patient as p LEFT JOIN signin as s ON s.id = p.added_by WHERE p.id = '$patient_id'";
				$patient_details = $this->Common_model->get_query_row_array($patient_sql);
				if(!empty($patient_details['id']))
				{
					$patient_id = $patient_details['id'];
					
					$medical_sql = "SELECT * from clinic_doctor_consult WHERE patient_id = '$patient_id'";
					$medical_details = $this->Common_model->get_query_result_array($medical_sql);
					
					$physical_sql = "SELECT * from clinic_physical WHERE patient_id = '$patient_id'";
					$physical_details = $this->Common_model->get_query_result_array($physical_sql);
					
					$logs_sql = "SELECT * from clinic_logs WHERE patient_id = '$patient_id'";
					$log_details = $this->Common_model->get_query_result_array($logs_sql);
				}
			}
			
			$data['patient_id'] = $patient_id;
			$data['patient_details'] = $patient_details;
			$data['medical_details'] = $medical_details;
			$data['physical_details'] = $physical_details;
			$data['log_details'] = $log_details;
					
			
			$html=$this->load->view('clinic_portal/clinic_reports_pdf', $data,true);
			
			$finalDir = "clinic_patient_invalid.pdf";
			if(!empty($patient_details['id'])){ $finalDir = "patient_".$patient_details['patient_code'].".pdf"; }
			
			if((!empty($patient_details['id']) && $type == 'F') || $type == 'I' || $type == 'D')
			{
				if($type == 'F')
				{
					$patientID   = $patient_details["patient_code"];
					$pdfFilePath = "clinic_patient_" .$patientID.".pdf";
					$uploadDir = FCPATH.'/uploads/clinic_portal/'.$patientID.'/';
					$finalDir = $uploadDir .$pdfFilePath;
					if (!file_exists($uploadDir)) {
						mkdir($uploadDir, 0777, true);
					}				
				}
				
				$pdf = new m_pdf();
				//$pdf->pdf->AddPage('L');			
				//$pdf->pdf->shrink_tables_to_fit;;			
				$pdf->pdf->WriteHTML($html);			
				$pdf->pdf->Output($finalDir, $type);
			}
		}			
	}
	
	///===================== EXCEL REPORT =================================//
	
	public function generate_patient_report_xls($from_date ='', $to_date='', $crm_list, $type = 'excel')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
				
		$title = "PATIENT RECORDS";
		$sheet_title = "CLINIC - PATIENT RECORDS (" .date('Y-m-d',strtotime($from_date)) ." - " .date('Y-m-d',strtotime($to_date)).")";
		$file_name = "Clinic_Patient_Records_".date('Y-m-d',strtotime($from_date));
				
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
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Patient ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Patient Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Gender");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Birthdate");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Address");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Blood");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Allergies");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Medical Condition");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Medical Remarks");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Added By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date Added");	
		
			
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{		
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["patient_code"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['c_name']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_gender"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_birth"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_address"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_blood"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_allergy"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_medical"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_medical_remarks"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["added_by_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added"])));
			$i++;
				
			if($type == 'pdf')
			{
				$this->generate_patient_report_pdf($wv["id"], 'F');
			}
			
		}
		
		if($type == 'excel')
		{
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);
			$objWriter->save('php://output');
			exit(); 
		}
		
		if($type == 'pdf')
		{
			$filename = "./assets/reports/clinic_patient_report.xlsx";
			ob_end_clean();
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);	
			$objWriter->save($filename);
			return $filename;
		}
		
	}

	
	 public function bgv_report()
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
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/bgv_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->get('report_office_id')){
			
			$data['officeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');

			$get_office_id = $officeSelection; $extraOffice = "";
			if(($get_office_id != "") && ($get_office_id != "ALL")){
				$extraOffice = " AND s.office_id = '$get_office_id' ";
			}			
			$get_dept_id = $deptSelection; $extraDept = "";
			if(($get_dept_id != "") && ($get_dept_id != "ALL")){
				$extraDept = " AND s.dept_id = '$get_dept_id' ";
			}
					
			$reports_sql = "SELECT s.id as user_id, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, 
								  d.description as department, r.name as designation, s.office_id as office, 
								  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor, 
								  b.is_bgv, b.is_bgv_adhaar from signin as s
								  LEFT JOIN info_personal as b ON b.user_id = s.id
								  LEFT JOIN signin as ls ON ls.id = s.assigned_to
								  LEFT JOIN department as d on d.id=s.dept_id
								  LEFT JOIN role as r on r.id=s.role_id
								  WHERE 1 $extraOffice $extraDept";
			$report_list = $this->Common_model->get_query_result_array($reports_sql);
					
			$csvfile = $this->generate_bgv_report_xls($report_list, $officeSelection);
			$this->generate_download_archieve($report_list,$csvfile, $officeSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	public function generate_download_archieve($reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "bg_verification_".$office; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/bg_verification_report_.xlsx";
		$this->zip->read_file($csvfile, "bg_verification_report_".$office.".xlsx");
		
        foreach ($reportArray as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$department = $token["department"];
			$fileName = FCPATH.'/uploads/bg_verification/'.$fusionID.'/'.'bg_verification_' .$fusionID.'.pdf';
			
			$newFileName = $fusionID."_".$firstname."_".$office.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['is_bgv'] == 1){
				$this->zip->read_file($fileName, $newFileName);
			}			
        }
		
        $this->zip->download($zipFileName.'.zip');		
	}
	
	
	public function generate_bg_verification_pdf($uid = '1')
	{			
		if(check_logged_in()){
				
			$this->load->library('m_pdf');
			
			//$current_user = "15261";
			$current_user = $uid;
			$qSql = "SELECT p.*, concat(s.fname, ' ', s.lname) as fullname, s.fusion_id from info_personal as p LEFT JOIN signin as s ON s.id = p.user_id WHERE s.id = $current_user";
			$data['personal_row'] = $personal_row = $this->Common_model->get_query_row_array($qSql);
		
			$qSql = "SELECT * from info_experience WHERE user_id = $current_user";
			$data['experience_row'] = $this->Common_model->get_query_result_array($qSql);			
			
			$html=$this->load->view('bg_verification/pre_employement_bgv_pdf', $data,true);
			
			$fusionID   = $personal_row["fusion_id"];
			$pdfFilePath = "bg_verification_" .$fusionID.".pdf";
			$uploadDir = FCPATH.'/uploads/bg_verification/'.$fusionID.'/';
			$finalDir = $uploadDir .$pdfFilePath;
			if (!file_exists($uploadDir)) {
				mkdir($uploadDir, 0777, true);
			}			
			
			$pdf = new m_pdf();
			$pdf->pdf->AddPage('L');			
			//$pdf->pdf->shrink_tables_to_fit;;			
			$pdf->pdf->WriteHTML($html);			
			$pdf->pdf->Output($finalDir, "F");
			
		}			
	}
	
	
	public function generate_bgv_report_xls($reportArray, $office ='')
	{
		$current_user     = get_user_id();
		$user_site_id     = get_user_site_id();
		$user_office_id   = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir      = get_role_dir();
		$get_dept_id      = get_dept_id();
		
		$this->objPHPExcel = new PHPExcel();	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Background Verification Report');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:I1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		
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
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Is Background");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Is Ahdhaar");
				
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
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 13 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 13 ));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "Background Verification Report");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
			
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$report_files = array();		
		foreach($reportArray as $wk=>$wv)
		{
			$user_id = $wv['user_id'];
			$is_bgv = $wv['is_bgv'] == 1 ? 'Yes' : 'No';
			$is_adhaar = $wv['is_bgv_adhaar'] == 1 ? 'Yes' : 'No';
			
			$bgv_color = $wv['is_bgv'] == 1 ? $yesArray : $noArray;
			$adhaar_color = $wv['is_bgv_adhaar'] == 1 ? $yesArray : $noArray;
			
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
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_bgv);
			$this->objPHPExcel->getActiveSheet()->getStyle('I'.$c)->applyFromArray($bgv_color);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_adhaar);			
			$this->objPHPExcel->getActiveSheet()->getStyle('J'.$c)->applyFromArray($adhaar_color);
			
			
			if($wv['is_bgv'] == 1){ $this->generate_bg_verification_pdf($user_id); }			
			
		}
		
		
		/* ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="BG_Verification_Report_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); */
		
		$filename = "./assets/reports/BG_Verification_Report_".$office.".xlsx";
		ob_end_clean();
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);	
		$objWriter->save($filename);
		return $filename;
		
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
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/survey_cafeteria_reports.php";
		
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
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/survey_reports.php";
		
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

	 	public function docusign_reports()
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
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/docusign_reports.php";
		
		if($this->input->post('excel_office_id')){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('excel_office_id');
			$this->generate_docusign_reports_xls($officeSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_docusign_reports_xls($officeq)
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
							  from t2_docusign_capabilities as f
				              LEFT JOIN signin as s ON f.agent_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraoffice";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Docusign Questionnaire');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AA1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "HTML");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "CSS");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Javascript");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Bootstrap");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Angular");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Ruby on Rails");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Java/J Query etc..");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "C, C++ etc..");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ".Net");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Python");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "PHP");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "XML");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "SOAP");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "REST API");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Any cloud Technology? Like AWS, Azure");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Any CRM experience like MS Dynamics, Siebel CRM, Salesforce");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Share Point or other file share knowledge?");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Remarks/Comments");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:AA1');
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1, "DOCUSIGN QUESTIONNAIRE");
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		
		foreach($report_list as $wk=>$wv)
		{
			$agent_id = $wv['agent_id'];
			$is_html = $wv['is_html']; 
			$is_css = $wv['is_css']; 
			$is_javascript = $wv['is_javascript']; 
			$is_bootstrap = $wv['is_bootstrap']; 
			$is_angular = $wv['is_angular']; 
			$is_ruby_on_rails = $wv['is_ruby_on_rails']; 
			$is_java = $wv['is_java']; 
			$is_c = $wv['is_c']; 
			$is_dotnet = $wv['is_dotnet']; 
			$is_python = $wv['is_python']; 
			$is_php = $wv['is_php']; 
			$is_xml = $wv['is_xml']; 
			$is_soap = $wv['is_soap']; 
			$is_rest_api = $wv['is_rest_api']; 
			$is_any_cloud = $wv['is_any_cloud']; 
			$is_any_crm = $wv['is_any_crm']; 
			$is_share_point = $wv['is_share_point']; 
			$remarks = $wv['remarks']; 
			$added_by = $wv['added_by']; 
			$date_added = $wv['date_added']; 
			$logs = $wv['logs']; 
					
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
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $date_added);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_html);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_css);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_javascript);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_bootstrap);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_angular);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_ruby_on_rails);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_java);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_c);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_dotnet);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_python);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_php);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_xml);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_soap);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_rest_api);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_any_cloud);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_any_crm);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_share_point);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $remarks);
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DOCUSIGN_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	 }
	
	////////////////////------IT Assessment Report (09/03/2020)------/////////////////////
	public function itAssessment(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/it_assessment_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			$data["it_assessment_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond = " Where (date(entry_date) >= '$date_from' and date(entry_date) <= '$date_to' ) ";
				
				if($office_id=="All") $cond .= "";
				else $cond .= " And office_id='$office_id'";
				
				$qSql="SELECT * from
					(Select * from it_assessment) xx Left Join (Select id as sid, concat(fname, ' ', lname) as fullname, fusion_id, office_id from signin) yy on (xx.user_id=yy.sid) $cond";
					
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["it_assessment_list"] = $fullAray;
				$this->create_itAssessment_CSV($fullAray);	
				$dn_link = base_url()."reports_misc/download_itAssessment_CSV/";			
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_itAssessment_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="IT Assessment List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_itAssessment_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Name", "Location", "Do you have Desktop or Laptop at Home", "What Kind of Laptop/ Desktop you Have Make / Model - CPU", "What Kind of Laptop/ Desktop you Have Make / Model - RAM", "What Kind of Laptop/ Desktop you Have Make / Model - HDD", "What Internet Connection do you have?", "What is the Bandwith?", "Do you have Headset?", "Do you any kind of Power Back up?", "Created Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row	=	"";
		foreach($rr as $user)
		{	
			$row = '"'.$user["fusion_id"].'",';
			$row .= '"'.$user["fullname"].'",';
			$row .= '"'.$user["office_id"].'",';
			$row .= '"'.$user["dekstop_laptop"].'",';
			$row .= '"'.$user["what_kind_dl_cpu"].'",';
			$row .= '"'.$user["what_kind_dl_ram"].'",';
			$row .= '"'.$user["what_kind_dl_hdd"].'",';
			$row .= '"'.$user["what_internet_conn"].'",';
			$row .= '"'.$user["what_bandwidth"].'",';
			$row .= '"'.$user["have_headset"].'",';
			$row .= '"'.$user["kind_power_backup"].'",';
			$row .= '"'.$user["entry_date"].'",';
					
			fwrite($fopen,$row."\r\n");
			$row	=	"";
		}
		fclose($fopen);
	}
	
	
	
////////////////////------WORK FROM HOME SURVEY (27/03/2020)------/////////////////////
	public function survey_wrokhomereport(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/survey_workhome_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			$data["survey_wfh_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond = " WHERE (date(xx.entry_date) >= '$date_from' and date(xx.entry_date) <= '$date_to' ) ";
				
				if($office_id=="All") $cond .= "";
				else $cond .= " AND yy.office_id='$office_id'";
				
				$qSql="SELECT * from survey_work_home xx 
				       LEFT JOIN (SELECT id as sid, concat(fname, ' ', lname) as fullname, fusion_id, office_id from signin) yy on (xx.user_id=yy.sid) $cond";
					
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["survey_wfh_list"] = $fullAray;
				$this->create_survey_wrokhomereport_CSV($fullAray);	
				$dn_link = base_url()."reports_misc/download_survey_wrokhomereport_CSV/";			
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}	
	}
	public function download_survey_wrokhomereport_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/SurveyrReportWFH".get_user_id().".csv";
		$newfile="Survey Work from Home -'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_survey_wrokhomereport_CSV($rr)
	{
		$filename = "./assets/reports/SurveyrReportWFH".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Name", "Location", "Working from Home", "Are you happy that Fusion has shifted to a WAH setup", "Are you happy for How Fusion has handled the WAH deployment", "Choosen Hashtag", "Remarks/Suggestion", "Created Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row	=	"";
		foreach($rr as $user)
		{	
			$row = '"'.$user["fusion_id"].'",';
			$row .= '"'.$user["fullname"].'",';
			$row .= '"'.$user["office_id"].'",';
			$row .= '"'.$user["is_work_home"].'",';
			$row .= '"'.$user["is_shifted_happy"].'",';
			$row .= '"'.$user["how_shifted_happy"].'",';
			$row .= '"#'.$user["hashtag"].'",';
			$row .= '"'.$user["remarks"].'",';
			$row .= '"'.$user["entry_date"].'",';
					
			fwrite($fopen,$row."\r\n");
			$row	=	"";
		}
		fclose($fopen);
	}




//================ REPORTS CSV =========================================//	

    public function user_mood_reports()
	{    
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/user_mood_reports.php";
							
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
					
			//================ DATE FILTER				
			$sdate = GetLocalMDYDate();
			$edate = GetLocalMDYDate();
			
			$usergetdate_start = $this->input->post('start_date');
			$usergetdate_end = $this->input->post('end_date');

		    if($usergetdate_start != ""){ 
							
				$sdate = mmddyy2mysql($usergetdate_start);
				$edate = mmddyy2mysql($usergetdate_end);
			}
						
			$data['date_now'] = GetLocalMDYDate();
			$data['start_date'] = $sdate;
			$data['end_date'] = $edate;
		
		    //================ OFFICE FILTER
			$data['office_now'] = $user_office_id;
			$data['post_mood'] = "";
			
			//$report_start = $this->input->post('start_date');
			//$report_end = $this->input->post('end_date');
			$report_office = $this->input->post('office_id');
			$get_mood = $this->input->post('mood_id');
			
			if(!empty($get_mood)){ $data['post_mood'] = $get_mood; }
			if(!empty($report_office)){ $data['office_now'] = $report_office; }
			
			$_filterCond = "";			
			$_filterCond = " AND DATE(m.local_date) >= '$sdate' AND DATE(m.local_date) <= '$edate'";
			
			if($report_office!="") $_filterCond .= " AND s.office_id='".$data['office_now']."'";
			if($data['post_mood']!="ALL" && $data['post_mood']!="") $_filterCond .= " AND m.mood='".$data['post_mood']."'";
			
			
			//=============== DROPDOWN FILTER
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$sqlmood = "SELECT distinct(mood) as mood from user_mood";
			$data['all_mood'] = $this->Common_model->get_query_result_array($sqlmood);
			
			if(!empty($report_office))
			{
				//========= DOWNLOAD CSV
				$sqlReport = "SELECT m.*,get_client_names(s.id) as client_name,get_process_names(s.id) as process_name,ro.name as or_role_name, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				d.description as department, r.name as designation
						from user_mood as m 
						INNER JOIN signin as s ON s.id = m.entry_by
						LEFT JOIN department d on d.id=s.dept_id 
						LEFT JOIN role r on r.id=s.role_id 
						LEFT JOIN role_organization ro on ro.id=s.org_role_id
						WHERE 1 $_filterCond";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				// print_r($queryReport); exit;
				$this->user_mood_reports_excel($queryReport, $data['office_now']."_reports_mood", "User Mood Report");
				
			}
			
			$this->load->view('dashboard',$data);
	
	}
	
	
	
	
	public function user_mood_reports_excel($result_array, $xlName = "excel_report", $title="Report")
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:H1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setWidth('25');
		$objWorksheet->getColumnDimension('I')->setWidth('25');
		$objWorksheet->getColumnDimension('J')->setWidth('25');
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "User Mood");
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');	
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		//$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "user_id");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mood");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Department");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Client");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Process");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Designation");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Organization Role");
		$i = 1;
				
		foreach($result_array as $wk=>$wv)
		{				
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			//$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["entry_by"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["local_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["mood"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["department"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["client_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["process_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["designation"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["or_role_name"]);
			$i++;			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$xlName.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	



////////////////////sentiment user////////////////////////

	public function user_sentiment_reports()
	{    
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/user_sentiment_reports.php";
							
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
					
			//================ DATE FILTER				
			$sdate = GetLocalMDYDate();
			$edate = GetLocalMDYDate();
			
			$usergetdate_start = $this->input->post('start_date');
			$usergetdate_end = $this->input->post('end_date');

		    if($usergetdate_start != ""){ 
							
				$sdate = mmddyy2mysql($usergetdate_start);
				$edate = mmddyy2mysql($usergetdate_end);
			}
						
			$data['date_now'] = GetLocalMDYDate();
			$data['start_date'] = $sdate;
			$data['end_date'] = $edate;
		
		    //================ OFFICE FILTER
			$data['office_now'] = $user_office_id;
			// $data['post_mood'] = "";
			
			//$report_start = $this->input->post('start_date');
			//$report_end = $this->input->post('end_date');
			$report_office = $this->input->post('office_id');
			// $get_mood = $this->input->post('mood_id');
			
			// if(!empty($get_mood)){ $data['post_mood'] = $get_mood; }
			if(!empty($report_office)){ $data['office_now'] = $report_office; }
			
			$_filterCond = "";			
			$_filterCond = " AND DATE(m.date_added_local) >= '$sdate' AND DATE(m.date_added_local) <= '$edate'";
			
			if($report_office!='All' && $report_office!="") $_filterCond .= " AND s.office_id='".$data['office_now']."'";
			// if($data['post_mood']!="ALL" && $data['post_mood']!="") $_filterCond .= " AND m.mood='".$data['post_mood']."'";
			
			
			//=============== DROPDOWN FILTER
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// $sqlmood = "SELECT distinct(mood) as mood from user_mood";
			// $data['all_mood'] = $this->Common_model->get_query_result_array($sqlmood);
			
			if(!empty($report_office))
			{
				//========= DOWNLOAD CSV
				$sqlReport = "SELECT m.*,get_client_names(s.id) as client_name,get_process_names(s.id) as process_name,ro.name as or_role_name,sq.question as question, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				d.description as department, r.name as designation
						from user_sentiment_answare as m 
						INNER JOIN signin as s ON s.id = m.user_id
						LEFT JOIN department d on d.id=s.dept_id 
						LEFT JOIN role r on r.id=s.role_id 
						LEFT JOIN role_organization ro on ro.id=s.org_role_id
						LEFT JOIN user_sentiment_questions sq on sq.id=m.question_id
						WHERE 1 $_filterCond";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				// print_r($queryReport); exit;
				$this->user_sentiment_reports_excel($queryReport, $data['office_now']."_reports_sentiment", "User Sentiment Report");
				
			}
			
			$this->load->view('dashboard',$data);
	
	}
	
	
	
	
	public function user_sentiment_reports_excel($result_array, $xlName = "excel_report", $title="Report")
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:H1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setWidth('25');
		$objWorksheet->getColumnDimension('I')->setWidth('25');
		$objWorksheet->getColumnDimension('J')->setWidth('25');
		$objWorksheet->getColumnDimension('K')->setWidth('25');
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "User Sentiment");
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');	
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		//$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "user_id");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date");
		// $i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Sentiment");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Sentiment Question");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Answer");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Department");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Client");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Process");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Designation");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Organization Role");
		$i = 1;
		// print_r($result_array); exit;
		foreach($result_array as $wk=>$wv)
		{				
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			//$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["user_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["date_added_local"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["question"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["survey_answer"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["department"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["client_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["process_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["designation"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["or_role_name"]);
			$i++;			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$xlName.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}


	/////////////////////////////////////////////////////////////




	
////////////////// Profile Document Upload ///////////////////////////

	public function document_upload(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/document_upload_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$office_id = "";
			$dept_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			
			$data["docu_upl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				//$fusion_id = $this->input->get('fusion_id');
				
				if($office_id=='All') $cond .= "";
				else $cond .= " and office_id='$office_id'";
				
				if($dept_id=='All') $cond .= "";
				else $cond .= " and dept_id='$dept_id'";
				
				if($cValue=='All' || $cValue=='' || $cValue=='0' || $cValue=='ALL') $cond .= "";
				else $cond .= " and client='$cValue'";
				
				if($pValue=='All' || $pValue=='' || $pValue=='0' || $pValue=='ALL') $cond .= "";
				else $cond .= " and process='$pValue'";
				
				
				$qSql="SELECT * from 
				(select id, fusion_id, office_id, dept_id, (select description from department d where d.id=dept_id) as dept_name, concat(fname, ' ', lname) as name, status, get_client_ids(id) as client, get_process_ids(id) as process, get_client_names(id) as client_name, get_process_names(id) as process_name, (select GROUP_CONCAT(iod.info_type) as other_info FROM info_others_doc iod where iod.user_id=signin.id) as other_docu_info from signin) masdt Left Join 
				(select user_id as ie_uid, max(job_doc) as job_doc from info_experience group by ie_uid) aa On (masdt.id=aa.ie_uid) Left Join
				(select user_id as ib_uid, max(bank_doc) as bank_doc from info_bank group by ib_uid) bb On (masdt.id=bb.ib_uid) Left join
				(select user_id as ip_uid, max(passport_doc) as passport_doc from info_passport group by ip_uid) cc On (masdt.id=cc.ip_uid) Left join
				(select user_id as ied_uid, max(education_doc) as education_doc from info_education group by ied_uid) dd On (masdt.id=dd.ied_uid) Left join
				(select user_id as uid, marital_status from info_personal group by uid) ee On (masdt.id=ee.uid) Left Join
				(select user_id as idu_uid,pan_doc,aadhar_doc,nis_doc,birth_certi_doc,marrige_certi_doc,photograph,resume_doc,nit_doc,isss_doc,afp_info_doc,background_local_doc, sss_no_doc,tin_no_doc,philhealth_no_doc,dependent_birth_certi_doc,bir_2316_doc,nbi_clearance_doc,offer_letter,employment_contract,profile_sketch,updated_cv from info_document_upload) ff On (masdt.id=ff.idu_uid)
				where status=1 $cond GROUP BY fusion_id";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["docu_upl_list"] = $fullAray;
				$this->create_docu_upl_CSV($fullAray, $office_id);	
				$dn_link = base_url()."reports_misc/download_docu_upl_CSV/".$office_id;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_docu_upl_CSV($off)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Profile Document Upload List-'".$off."' - '".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_docu_upl_CSV($rr,$off)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($off=='JAM'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Tax Registration Number ID", "National Insurance Scheme ID", "Birth Certificate", "Married", "Marriage Certificate", "Bank Info", "Education Info", "Passport", "Other Document Upload");
		}else if($off=='KOL' || $off=='HWH' || $off=='BLR' || $off=='NOI' || $off=='CHE'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Aadhar Card / Social Secuirity No", "PAN Card", "Photograph", "Covid-19 Declaration", "Education Info", "Passport", "Experience Info", "Other Document Upload");
		}else if($off=='ELS'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Resume", "NIT", "ISSS Information", "AFP Information", "Background Local",  "Passport", "Other Document Upload");
		}else if($off=='CEB' || $off=='MAN'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "SSS Number", "TIN Number", "Birth Certificate", "Philhealth Number", "Dependents Birth Certificate",  "Married", "Marriage Certificate", "BIR 2316 from previous",  "NBI Clearance", "Offer Letter", "Employment Contract", "Profile Sketch", "Updated CV", "Other Document Upload");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($off=='JAM'){
			
			foreach($rr as $user)
			{
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['nis_doc']!='') $nis_doc='Yes';
				else $nis_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bank_doc']!='') $bank_doc='Yes';
				else $bank_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
			
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$nis_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bank_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='KOL' || $off=='HWH' || $off=='BLR' || $off=='NOI' || $off=='CHE'){
		
			foreach($rr as $user)
			{
				if($user['aadhar_doc']!='') $aadhar_doc='Yes';
				else $aadhar_doc='No';
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['photograph']!='') $photograph='Yes';
				else $photograph='No';
				if($user['covid19declare_doc']!='') $covid19declare_doc='Yes';
				else $covid19declare_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				if($user['job_doc']!='') $experience_doc='Yes';
				else $experience_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$aadhar_doc.'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$photograph.'",';
				$row .= '"'.$covid19declare_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$experience_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='ELS'){
		
			foreach($rr as $user)
			{
				if($user['resume_doc']!='') $resume_doc='Yes';
				else $resume_doc='No';
				if($user['nit_doc']!='') $nit_doc='Yes';
				else $nit_doc='No';
				if($user['isss_doc']!='') $isss_doc='Yes';
				else $isss_doc='No';
				if($user['afp_info_doc']!='') $afp_info_doc='Yes';
				else $afp_info_doc='No';
				if($user['background_local_doc']!='') $background_local_doc='Yes';
				else $background_local_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$resume_doc.'",';
				$row .= '"'.$nit_doc.'",';
				$row .= '"'.$isss_doc.'",';
				$row .= '"'.$afp_info_doc.'",';
				$row .= '"'.$background_local_doc.'",';
				$row .= '"'.$passport_doc.'"';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='CEB' || $off=='MAN'){
		
			foreach($rr as $user)
			{
				if($user['sss_no_doc']!='') $sss_no_doc='Yes';
				else $sss_no_doc='No';
				if($user['tin_no_doc']!='') $tin_no_doc='Yes';
				else $tin_no_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['philhealth_no_doc']!='') $philhealth_no_doc='Yes';
				else $philhealth_no_doc='No';
				if($user['dependent_birth_certi_doc']!='') $dependent_birth_certi_doc='Yes';
				else $dependent_birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bir_2316_doc']!='') $bir_2316_doc='Yes';
				else $bir_2316_doc='No';
				if($user['nbi_clearance_doc']!='') $nbi_clearance_doc='Yes';
				else $nbi_clearance_doc='No';
				if($user['offer_letter']!='') $m_offer_doc='Yes';
				else $m_offer_doc='No';
				if($user['employment_contract']!='') $m_contract_doc='Yes';
				else $m_contract_doc='No';
				if($user['profile_sketch']!='') $m_profile_doc='Yes';
				else $m_profile_doc='No';
				if($user['updated_cv']!='') $m_updatedcv_doc='Yes';
				else $m_updatedcv_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$sss_no_doc.'",';
				$row .= '"'.$tin_no_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$philhealth_no_doc.'",';
				$row .= '"'.$dependent_birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bir_2316_doc.'",';
				$row .= '"'.$nbi_clearance_doc.'",';
				$row .= '"'.$m_offer_doc.'",';
				$row .= '"'.$m_contract_doc.'",';
				$row .= '"'.$m_profile_doc.'",';
				$row .= '"'.$m_updatedcv_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		
		fclose($fopen);
	}
///////////////////////////////	
	
	
	
	//========================== REPORTS SELF DECLARTAION COVID ================================//
	
	public function covid_self_declaration_reports()
	{
		
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/covid_self_declaration_report.php";

			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('covid_start_date');
			$end_date   = $this->input->get('covid_end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$showreport = $this->input->get('showReports');
			
			if($office_id=="")  $office_id = $ses_office_id;
			if($dept_id=="")  $dept_id = $ses_dept_id;
			
			//------ LOCATION LIST
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//------ DEPARTMENT LIST
			if($is_global_access=='1' || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			$data["content_js"] = "covid_checkup_js.php";
			
			if($showreport == "Download Excel"){
				$this->generate_covid_self_declaration_excel_reports($start_date, $end_date, $dept_id, $office_id);
			} else {
				$this->load->view('dashboard',$data);
			}				
	}
	
	
	
	public function generate_covid_self_declaration_excel_reports($start_date, $end_date, $dept_id, $office_id)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$extraWhere = "";
		if($office_id != "ALL"){ $extraWhere .= " AND s.office_id = '$office_id'"; }
		if($dept_id != "ALL"){ $extraWhere .= " AND s.dept_id = '$dept_id'"; }
		
		$covid_start_date = $start_date ." 00:00:00"; $covid_end_date = $end_date ." 23:59:59"; 
		$sql_covid_consent = "SELECT c.*, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as my_office_location, sp.phone as employee_phone,
			                  CONCAT(l.fname, ' ', l.lname) as l1_supervisor, lp.phone as supervisor_phone, d.description as department, r.name as designation 
					          from covid19_screening_checkup as c
							  INNER JOIN signin as s ON s.id = c.user_id
							  LEFT JOIN department as d ON d.id=s.dept_id
							  LEFT JOIN role as r ON r.id=s.role_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  LEFT JOIN info_personal as lp ON lp.user_id = s.assigned_to
							  LEFT JOIN info_personal as sp ON sp.user_id = s.id
		                      WHERE c.date_added_local >= '$covid_start_date' AND c.date_added_local <= '$covid_end_date'
						      $extraWhere
							  ORDER by c.date_added_local, s.fname ASC";
		$covid_consent_details = $this->Common_model->get_query_result_array($sql_covid_consent);
		
		$title = "Covid Self Declaration";
		
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:O1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('M')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		
		//$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:J1'); 
		//$this->objPHPExcel->getActiveSheet()->setCellValue('G1', "IT Checklist");
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:O2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Employee Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Employee Phone");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Site");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Department");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Designation");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "L1 Supervisor");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Temperature Measured");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Last 30 Days Travelled Outside");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Any Symptom Found");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Is Exposed in past 14 Days");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Any Household Members in Quarantine");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Entered Symptoms");
		
			
		$i = 1;		
		foreach($covid_consent_details as $wk=>$wv)
		{	
						
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_phone"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["my_office_location"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["department"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["designation"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["l1_supervisor"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added_local"])));
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_temperature"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_outside"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_symptom"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_exposed"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_family_covid"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_symptoms"]);
			$i++;			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Covid_Self Declaration_'.$start_date.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}

		public function covid19_pre_check_report()
	{    
		if(check_logged_in())
		{
			$office_id = "";
			$dept_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$date_from="";
			$date_to="";
			$cond="";
			
			$data["aside_template"] = "reports_misc/aside.php";
			$data["content_template"] = "reports_misc/report.php";
			
			$action="";
			$dn_link="";
			
			
			$data["get_master_database"]= array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from=mmddyy2mysql($this->input->get('date_from'));				
				$date_to=mmddyy2mysql($this->input->get('date_to'));				
				$office_id=$this->input->get('office_id');				
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (date(entry_date) >= '$date_from' and date(entry_date) <= '$date_to' ) ";
				if($office_id !="") $cond .=" And office_id='$office_id'";
				
				$sqlReport="Select co.*, concat(s.fname, ' ', s.lname) as full_name, s.fusion_id, s.assigned_to, s.office_id, get_client_names(s.id) as client, get_process_names(s.id) as process, FLOOR(DATEDIFF(CURDATE(), s.dob)/365) as age, (select concat(fname, ' ', lname) as name from signin x where x.id=s.assigned_to) as l1_super, (select address_present from info_personal ip where ip.user_id=s.id) as address, (select phone from info_personal ip where ip.user_id=s.id) as phone from covid_19_preliminary_check co Left Join signin s On co.user_id=s.id  $cond";
				
				$fullAray = $this->Common_model->get_query_result_array($sqlReport);
				$data["get_master_database"] = $fullAray;
				
				$this->covid19_pre_check_xls($fullAray);
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			
			$this->load->view('dashboard',$data);
		}
	
	}
	
	
	
	
	public function covid19_pre_check_xls($rr)
	{
		$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle('Covid-19 PRE-CHECK REPORT');
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->objPHPExcel->getActiveSheet()->getStyle('A1:AF1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
			
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
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:AV1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A1:AF1")->getFill()->applyFromArray(
                $styleArray =array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'rgb' => "F28A8C"
					)
				)
            );
       
			// CELL FONT AND FONT COLOR 
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'name'  => 'Algerian'
			));

					
			
			
          $header = array("Fusion ID", "Full Name", "Client", "Process", "TL Name", "Age (In Years)", "Address", "MEDICAL CONDITIONS - Asthma", "Hypertension", "Sexually transmitted infections", "Diabetes Mellitus", "Pregnancy", "OTHER DISEASE", "Has exposure to a confirmed COVID-19 case?", "Has contact with anyone having fever, cough, colds, and sore throat for the past 2 weeks?", "MEDICAL CONDITIONS - NONE OF THE ABOVE", "SYMPTOMS CHECK - Fever", "Headache", "Muscle Pain", "Fatigue", "Cough", "Colds", "Shortness of breath", "Difficulty of breathing", "Sore Throat", "Nausea and Vomiting", "Diarrhea", "Abdominal Pain", "Loss of Taste", "Loss of Smell", "SYMPTOMS CHECK - NONE OF THE ABOVE", "Entry Date");

			$col=0;
			$row=1;
		
			foreach($header as  $excel_header){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $excel_header);	
					$col++; 
			}
			
			$row=2;
			foreach($rr as $user){

				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row, $user['fusion_id']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row, $user['full_name']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$row, $user['client']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row, $user['process']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row, $user['l1_super']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$row, $user['age']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $user['address']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$row, $user['pre_exist_asthma']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(8, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$row, $user['pre_exist_hyper']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(9, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$row, $user['pre_exist_transmit']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(10, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$row, $user['pre_exist_diabates']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(11, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$row, $user['pre_exist_pregnant']." - ".$user['pre_exist_pregnant_text']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(12, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$row, $user['pre_exist_disease']." - ".$user['pre_exist_disease_text']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(13, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$row, $user['pre_exist_exposer']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(14, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$row, $user['pre_exist_contact']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(15, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$row, $user['pre_exist_none']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(16, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$row, $user['symptoms_fever']." - ".$user['fever_how_long']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(17, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$row, $user['symptoms_headache']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(18, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$row, $user['symptoms_muscle']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(19, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$row, $user['symptoms_fgatigue']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(20, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$row, $user['symptoms_cough']." - ".$user['cough_how_long']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(21, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$row, $user['symptoms_cold']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(22, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$row, $user['symptoms_breath']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(23, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$row, $user['symptoms_dificult_breath']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(24, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$row, $user['symptoms_throat']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(25, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$row, $user['symptoms_nausea']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(26, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$row, $user['symptoms_diarrhea']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(27, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$row, $user['symptoms_abdominal']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(28, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$row, $user['symptoms_loss_taste']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(29, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29,$row, $user['symptoms_loss_smell']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(30, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30,$row, $user['symptoms_none']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(31, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31,$row, $user['entry_date'] );
				
				
				$row ++;
			
			}
		 
 
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Covid-19 PRE-CHECK REPORT.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit(); 
	}
	
	
	
	 public function logout_acknowledge()
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
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/logout_acknowledge.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->get('report_office_id')){
			
			$data['start_date'] = $start_date = $this->input->get('start_date');
			$data['end_date'] = $end_date = $this->input->get('end_date');
			
			$data['officeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
			
			$start_date = mmddyy2mysql($start_date);
			$end_date = mmddyy2mysql($end_date);
				
			$stdate=$start_date." 00:00:00";
			$eddate=$end_date." 23:59:59";
			$dtCond = " login_time_local >= '$stdate' and login_time_local <= '$eddate' ";
			
			$get_office_id = $officeSelection; $extraOffice = "";
			
			
			if($get_office_id == "ADL"){
				$extraOffice = " AND s.office_id in ('FTK', 'HIG', 'MIN', 'SPI', 'TEX', 'UTA', 'CAM' ) ";
			}else if(($get_office_id != "") && ($get_office_id != "ALL")){
				$extraOffice = " AND s.office_id = '$get_office_id' ";
			}
			
			$get_dept_id = $deptSelection; $extraDept = "";
			if(($get_dept_id != "") && ($get_dept_id != "ALL")){
				$extraDept = " AND s.dept_id = '$get_dept_id' ";
			}
			
			
					
			$reports_sql = "SELECT s.id as user_id, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, 
							d.description as department, r.name as designation, s.office_id as office, 
							get_process_names(s.id) as process_name, get_client_names(s.id) as client_name,
							CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
							ld.login_time, ld.login_time_local, ld.logout_time, ld.logout_time_local, ld.logout_by
							from signin as s
							LEFT JOIN logged_in_details as ld ON ld.user_id = s.id
							LEFT JOIN signin as ls ON ls.id = s.assigned_to
							LEFT JOIN department as d on d.id=s.dept_id
							LEFT JOIN role as r on r.id=s.role_id
							WHERE $dtCond $extraOffice $extraDept";
								  
			$report_list = $this->Common_model->get_query_result_array($reports_sql);
					
			$csvfile = $this->generate_logout_acknowledge_xls($report_list, $start_date, $end_date, $officeSelection);	
		}
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_logout_acknowledge_xls($reportArray, $start_date, $end_date, $office ='')
	{
		$current_user     = get_user_id();
		$user_site_id     = get_user_site_id();
		$user_office_id   = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir      = get_role_dir();
		$get_dept_id      = get_dept_id();
		
		$this->objPHPExcel = new PHPExcel();	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Logout Acknowledge Report');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:I1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('j')->setAutoSize(true);
		$objWorksheet->getColumnDimension('k')->setAutoSize(true);
		$objWorksheet->getColumnDimension('l')->setAutoSize(true);
		$objWorksheet->getColumnDimension('m')->setAutoSize(true);
		
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
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "login_time");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "login_time_local");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "logout_time");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "logout_time_local");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "is_acknowledge");
		
				
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
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 13 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 13 ));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "Logout Acknowledge Report");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
			
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
				
		$report_files = array();		
		foreach($reportArray as $wk=>$wv)
		{
			$user_id = $wv['user_id'];
			$logout_by = $wv['logout_by'];
			if($user_id == $logout_by) $is_acknowledge = 'Yes';
			else $is_acknowledge = 'No';
			
			$bgv_color = $is_acknowledge == 'Yes' ? $yesArray : $noArray;
						
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
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["login_time"]);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["login_time_local"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["logout_time"]);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["logout_time_local"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_acknowledge);
			$this->objPHPExcel->getActiveSheet()->getStyle('K'.$c)->applyFromArray($bgv_color);
			
		}
		
				
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Logout_acknowledgeReport_'.$start_date."_".$end_date."_".$office.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit();
		
	}
	
	
	
	//====================== SURVEY - FACILITIES DEPARTMETN REPORT ================================//
	
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
		
		$data["aside_template"] = "reports_misc/aside.php";
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
		
		$data["aside_template"] = "reports_misc/aside.php";
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
	
	
	//====================== SURVEY - HR AUDITS REPORT ================================//
	
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
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/hr_audit_reports.php";
		
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
	
	
	
	//====================== COVID PHILIPHINES REPORT ===================================================//
	
	public function covid_screening_report_phillipines()
	{
		if(check_logged_in()){

			$office_id = "";
			$error= "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["content_template"] = "reports_misc/reports_covid_phillipines.php";
			$data["aside_template"] = "reports_misc/aside.php";
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["get_covid_detail_list"]= array();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($this->input->get('show')=='Show' || $this->input->get('download')=='download')
			{	
				$start_time = "00:00:00";
				$end_time = "23:59:59";
				$office_id = $this->input->get('office_id');
				$is_dowloadable = $this->input->get('download');
				$from_date = $this->input->get('search_from_date');
				$to_date = $this->input->get('search_to_date');
				$search_from_date = date('Y-m-d', strtotime($from_date));
				$search_to_date = date('Y-m-d', strtotime($to_date));
				$from_date_full = $search_from_date ." ". $start_time;
				$to_date_full = $search_to_date ." ". $end_time;
				$data['search_from_date'] = $from_date;
				$data['search_to_date'] = $to_date;

				$extraFilter = " AND (ph.date_added_local >= '$from_date_full' AND ph.date_added_local <= '$to_date_full') ";
			
				$query = $this->db->query("SELECT ph.*,signin.office_id, signin.fname,signin.fusion_id, signin.lname, department.shname as department FROM covid19_screening_checkup_phil ph LEFT JOIN signin ON signin.id=ph.user_id LEFT JOIN department ON signin.dept_id=department.id WHERE 1 $extraFilter");
				$fullAray = $query->result_array();

				$this->generate_covid_screening_report_phillipines_excel($fullAray);
				$dn_link = "";
					
			} 
			
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			$data['error']=$error;
			
			$this->load->view('dashboard',$data);
		}
	}

	
	public function generate_covid_screening_report_phillipines_excel($rr)
	{
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Covid Screening');
			 
		// START GRIDLINES HIDE AND SHOW//
		$objWorksheet->setShowGridlines(true);
		// END GRIDLINES HIDE AND SHOW//
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:H1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
			
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);		
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);		
			
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$objWorksheet->getStyle("A1:H1")->applyFromArray($style);
		$sheet = $this->objPHPExcel->getActiveSheet();

		unset($style);
 
		// CELL BACKGROUNG COLOR
		$this->objPHPExcel->getActiveSheet()->getStyle("A2:H2")->getFill()->applyFromArray(
		$styleArray = array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							 'rgb' => "F28A8C"
						)
					)
		);
       
		// CELL FONT AND FONT COLOR 
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 16,
			'name'  => 'Algerian'
		));

		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		
		$sheet = $this->objPHPExcel->getActiveSheet();
		$sheet->setCellValueByColumnAndRow(0, 1, "Covid Screening Report");
		$sheet->mergeCells('A1:G1');
							
		$header = array("Sl", "Fusion ID", "Full Name", "Office", "Department", "Employee Wants Vaccine", "Date Added", "Date Added Local");

		$col=0;
		$row=2;
		
		foreach($header as  $excel_header){
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $excel_header);	
				$col++; 
		}
			
		$row=3;
		
		$counter = 0;
		foreach($rr as $user){ 
			
			$counter++;
			if($user['employee_will_vaccinated'] == "Y")$vaccine = "Yes"; else $vaccine = 'No';
			if($user['employee_acceptance'] == "1")$accpt = "Yes"; else $accpt = 'No';
			
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row, $counter);

			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row, $user['fusion_id']);
			
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$row, $user['fname'].' '.$user['lname']);
			
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row, $user['office_id']);
			
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row, $user['department']);
			
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$row, $vaccine);	
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $user['date_added']);
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$row, $user['date_added_local']);
			
				
			$row ++;
		
		}
	 

		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Covid_screening.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit();
	}
	
	
	
	//====================== AMERIDIAL PARTICIPANT REPORT ===================================================//
		
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
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/ameridial_participant_reports.php";
		
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
		
		$data["aside_template"] = "reports_misc/aside.php";
		$data["content_template"] = "reports_misc/ameridial_participant_graphical.php";
		
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
	