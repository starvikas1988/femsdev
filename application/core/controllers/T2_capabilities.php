<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T2_capabilities extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
//==========================================================================================
///=========================== T2 Capabilities Docusign  ================================///
	
	public function index(){
				
		redirect(base_url()."t2_capabilities/docusign_form");
	 
	}
	 
	
	
	public function docusign_form()
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
		$docusign_sql = "SELECT * from t2_docusign_capabilities WHERE agent_id = '$current_user'";
		$data['docusign'] = $this->Common_model->get_query_row_array($docusign_sql);
		if(count($data['docusign']) > 0){ $data['docuSubmission'] = 1; }
		
		$data["aside_template"] = "t2_capabilities/aside.php";
		$data["content_template"] = "t2_capabilities/docusign_form.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	 
	
	public function submit_docusign_form()
	{
		$current_user = get_user_id();
		
		$data_array = [
			'agent_id' => $this->input->post('agent_uid'),
			'is_html' => $this->input->post('is_html'),
			'is_css' => $this->input->post('is_css'),
			'is_javascript' => $this->input->post('is_javascript'),
			'is_bootstrap' => $this->input->post('is_bootstrap'),
			'is_angular' => $this->input->post('is_angular'),
			'is_ruby_on_rails' => $this->input->post('is_ruby_on_rails'),
			'is_java' => $this->input->post('is_java'),
			'is_c' => $this->input->post('is_c'),
			'is_dotnet' => $this->input->post('is_dotnet'),
			'is_python' => $this->input->post('is_python'),
			'is_php' => $this->input->post('is_php'),
			'is_xml' => $this->input->post('is_xml'),
			'is_soap' => $this->input->post('is_soap'),
			'is_rest_api' => $this->input->post('is_rest_api'),
			'is_any_cloud' => $this->input->post('is_any_cloud'),
			'is_any_crm' => $this->input->post('is_any_crm'),
			'is_share_point' => $this->input->post('is_share_point'),
			'remarks' => $this->input->post('remarks'),
			'added_by' => $this->input->post('remarks'),
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'logs' => get_logs()
		];
		
		data_inserter('t2_docusign_capabilities', $data_array);
		redirect(base_url()."t2_capabilities/docusign_form");
	
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
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "t2_capabilities/docusign_reports.php";
		
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
	
}
	