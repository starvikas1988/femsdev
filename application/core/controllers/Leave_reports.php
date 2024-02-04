<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_reports extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){
				
		redirect(base_url()."Leave_reports/leave_list");
	 
	}
	
	///=========================== DOWNTIME AMERIDIAL TRACK ================================///
	
	public function leave_list()
	{ 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$office_list = "SELECT * FROM `office_location` WHERE is_active = 1  and abbr IN ('KOL', 'CHE', 'NOI', 'BLR','HWH') ORDER BY `abbr` ASC";
		$data['office_list'] = $this->Common_model->get_query_result_array($office_list);

		$dept_list = "SELECT id,shname FROM `department`WHERE is_active = 1";		
		$data['dept_list'] = $this->Common_model->get_query_result_array($dept_list);
		$leave_list = "SELECT abbr FROM `leave_type` WHERE abbr='PL' ORDER BY `abbr` ASC";
		$data['leave_list'] = $this->Common_model->get_query_result_array($leave_list);

		// var_dump($data);
		// FILTER 
		$data['searched'] = 0;
		$extraSearch = "";
		
		$search_Office_ID = $get_dept_id;
		if(!empty($this->input->get('office_abbr')))
		{ 
			$search_Office_ID = $this->input->get('office_abbr');			
			if($search_Office_ID != "ALL" && !empty($search_Office_ID)){
				$extraSearch .= " AND s.office_id = '$search_Office_ID'";
			}
			$data['searched'] = 1;
		}
		
		
		$search_department_id = $this->input->get('dept');			
		if(!empty($this->input->get('dept')))
		{ 
			$search_department_id = $this->input->get('dept');			
			if($search_department_id != "ALL" && !empty($search_department_id)){
				$extraSearch .= " AND s.dept_id = '$search_department_id'";
			}			
			$data['searched'] = 1;
		}
		
		$search_fusion_id = "";
		if(!empty($this->input->get('fusion_id')))
		{ 
			$search_fusion_idArr = $this->input->get('fusion_id');
			$search_fusion_id = implode("','", $search_fusion_idArr);
			$_SESSION['fusion_leave_reports_id'] = $search_fusion_id;
			if($search_fusion_id != "" && !empty($search_fusion_id)){
				$extraSearch .= " AND (s.fusion_id IN ('$search_fusion_id') OR s.xpoid IN ('$search_fusion_id')) ";
			}	
			// var_dump($extraSearch);exit;		
			$data['searched'] = 1;
		}
		
		$search_leave_type = "PL";
		if(!empty($this->input->get('leave_type')))
		{ 
			$search_leave_type = $this->input->get('leave_type');
			$data['searched'] = 1;
		}
		
		$data['office_abbr'] = $search_Office_ID;
		$data['dept'] = $search_department_id;
		$data['fusion_id'] = $search_fusion_id;
		$data['leave_type'] = $search_leave_type;
		
		$list_sql = "SELECT CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, r.name as designation, get_process_names(s.id) as process_name, ls.leaves_present from signin as s LEFT JOIN role as r ON s.role_id = r.id LEFT JOIN leave_avl_emp as ls ON ls.user_id = s.id AND leave_criteria_id in (SELECT LC.id FROM leave_criteria LC INNER JOIN leave_type LT ON LT.id = LC.leave_type_id WHERE LC.office_abbr = s.office_id AND LT.abbr = '$search_leave_type') WHERE 1 $extraSearch";	
		
		if($data['searched'] == 1){
			$data['details'] = $this->Common_model->get_query_result_array($list_sql);
		}
		
		$data["aside_template"] = "leave_reports/aside.php";
		$data["content_template"] = "leave_reports/leave_reports.php";
		$data["content_js"] = "leave_reports/leave_reports_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}

	/*public function fetch_fems_id(){
		if($this->input->get('dept_id') & $this->input->get('offc_id')){
		$dept_id = $this->input->get('dept_id');
		$offc_id = $this->input->get('offc_id');
		echo $this->fetch_data($dept_id,$offc_id);
		}
	}

	public function fetch_data($dept_id,$offc_id){
		$sql = "SELECT fusion_id FROM `signin` where office_id ='$offc_id' and dept_id='$dept_id' ";
			$details = $this->Common_model->get_query_result_array($list_sql);
			$output = '<option value="">Select Id</option>';
			foreach ($details as $value) {
				$output .= '<option value="'.$value['fusion_id'].'">'.$value['fusion_id'].'</option>';
			}
			return $output;
	}*/
	
	public function dropdown_users(){
		if(check_logged_in())
		{
			$dept_id = $this->input->get('dept_id');
			$offc_id = $this->input->get('offc_id');
			
			$extraSearch = "";
			if($dept_id != "" && $dept_id != "ALL"){ $extraSearch .= " AND s.dept_id ='$dept_id' "; }
			if($offc_id != "" && $offc_id != "ALL"){ $extraSearch .= " AND s.office_id='$offc_id' "; }
			$SQLtxt = "SELECT s.fusion_id as id, CONCAT(s.fname,' ', s.lname) as name FROM signin as s where s.status IN (1,4) $extraSearch";
			$fields = $this->db->query($SQLtxt);
			
			$result_data =  $fields->result_array();
			  
			echo  json_encode($result_data);
			 
		}
	}
	
	public function leave_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$extraSearch = "";
		if(!empty($this->input->get('office_abbr')))
		{ 
			$search_Office_ID = $this->input->get('office_abbr');
			if($search_Office_ID != "ALL" && !empty($search_Office_ID)){
				$extraSearch .= " AND s.office_id = '$search_Office_ID'";
			}
		}

		if(!empty($this->input->get('dept')))
		{ 
			$search_department_id = $this->input->get('dept');
			if($search_department_id != "ALL" && !empty($search_department_id)){
				$extraSearch .= " AND s.dept_id = '$search_department_id'";
			}	
		}

	//	if(!empty($this->input->get('fusion_id')))
		if(!empty($_SESSION['fusion_leave_reports_id']))
		{ 
			// $search_fusion_idArr = $this->input->get('fusion_id');
			// $search_fusion_id = implode("','", $search_fusion_idArr);
			$search_fusion_id = $_SESSION['fusion_leave_reports_id'] ;
			if($search_fusion_id != "" && !empty($search_fusion_id)){
				$extraSearch .= " AND (s.fusion_id IN ('$search_fusion_id') OR s.xpoid IN ('$search_fusion_id')) ";
			}	
		}
		if(!empty($this->input->get('leave_type')))
		{ 
			$search_leave_type = $this->input->get('leave_type');
		}
		

		$this->generate_leave_report_xls($search_Office_ID, $search_department_id, $search_fusion_id, $search_leave_type, $extraSearch);
	
	}
	
	
	public function generate_leave_report_xls($search_Office_ID="", $search_department_id="", $search_fusion_id="", $search_leave_type, $extraSearch)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$reports_sql = "SELECT CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, r.name as designation, get_process_names(s.id) as process_name, ls.leaves_present 
		from signin as s 
		LEFT JOIN role as r ON s.role_id = r.id 
		LEFT JOIN leave_avl_emp as ls ON ls.user_id = s.id AND leave_criteria_id in (SELECT LC.id FROM leave_criteria LC INNER JOIN leave_type LT ON LT.id = LC.leave_type_id WHERE LC.office_abbr = s.office_id AND LT.abbr = '$search_leave_type') 
		WHERE 1 $extraSearch";	
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Leave Reports');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:F1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Full Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leaves Present");
				
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
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "LEAVE REPORTS");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];
			$acceptedOn =  "";
			if(!empty($wv['accepted_on']) && $wv['accepted_on'] != "0000-00-00"){ $acceptedOn =  date('d M, Y', strtotime($wv['accepted_on'])); } else { $acceptedOn =  " - "; } 
			
			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, round($wv["leaves_present"]));
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Leave_reports.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
}