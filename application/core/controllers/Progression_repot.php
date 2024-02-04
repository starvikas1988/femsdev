<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progression_repot extends CI_Controller {

   private $aside = "reports/aside.php";

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		//$this->reports_model->set_report_database("report");
		
	 }
	 
    public function index()
    {
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			
			$data["is_role_dir"] = get_role_dir();
			$data["aside_template"] = "progression/aside.php";
			
			
			if( get_dept_folder()=="wfm" || $is_role_dir=="super" || $is_global_access==1 )
			{
				$data["content_template"] = "progression/report.php";
			}else{
				redirect('progression/apply', 'refresh');
			}
			
			
			$data["department_data"] = $this->Common_model->get_department_list();
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			//if user is super or has global access
			if(get_dept_folder()=="wfm" || $is_role_dir=="super" || $is_global_access==1){
				
				//get all available requistion id with active status 1
				$qSql="Select requisition_id FROM ijp_requisitions WHERE is_active=1 ORDER BY id DESC";
				$data["get_requisition_ids"] = $this->Common_model->get_query_result_array($qSql);
				
				
			}else{
				
				//get active requisition with particular office location
				$qSql="Select requisition_id FROM ijp_requisitions where location_id='$user_office_id' and is_active=1 ORDER BY id DESC";
				$data["get_requisition_ids"] = $this->Common_model->get_query_result_array($qSql);
				
				
			}
			
			$this->load->view('dashboard',$data);
		}
    }
		
	public function createExcelFile()
	{
		$form_data = $this->input->post();
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
		->setCreator("FusionBPO")
		->setLastModifiedBy("FusionBPO")
		->setTitle("Progression Report For ".$form_data['requisition_id']."")
		->setSubject("Progression Report For ".$form_data['requisition_id']."")
		->setDescription("Progression Report For ".$form_data['requisition_id']."")
		->setKeywords("Progression Report For ".$form_data['requisition_id']."");
		$objPHPExcel->setActiveSheetIndex(0);
		
		$objPHPExcel->getActiveSheet()->getStyle("A1:L1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "IJP Requision ID");
		$objPHPExcel->getActiveSheet()->getColumnDimension('A') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', "Due Date");
		$objPHPExcel->getActiveSheet()->getColumnDimension('B') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', "Function");
		$objPHPExcel->getActiveSheet()->getColumnDimension('C') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', "Client");
		$objPHPExcel->getActiveSheet()->getColumnDimension('D') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', "Process");
		$objPHPExcel->getActiveSheet()->getColumnDimension('E') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', "Dept");
		$objPHPExcel->getActiveSheet()->getColumnDimension('F') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', "Sub Dept");
		$objPHPExcel->getActiveSheet()->getColumnDimension('G') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', "Position");
		$objPHPExcel->getActiveSheet()->getColumnDimension('H') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', "Request Reason");
		$objPHPExcel->getActiveSheet()->getColumnDimension('I') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', "Posting Type");
		$objPHPExcel->getActiveSheet()->getColumnDimension('J') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', "Movement Type");
		$objPHPExcel->getActiveSheet()->getColumnDimension('K') ->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', "Filter");
		$objPHPExcel->getActiveSheet()->getColumnDimension('L') ->setAutoSize(true);
		
		$requisition_info = $this->get_requisition_info($form_data['requisition_id']);
		$requisition_user_infos = $this->get_requisition_user_info($form_data['requisition_id']);
		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', $form_data['requisition_id']);
		$objPHPExcel->getActiveSheet()->SetCellValue('B2', $requisition_info->date_due);
		$objPHPExcel->getActiveSheet()->SetCellValue('C2', $requisition_info->ffunction);
		$objPHPExcel->getActiveSheet()->SetCellValue('D2', $requisition_info->client_name);
		$objPHPExcel->getActiveSheet()->SetCellValue('E2', $requisition_info->process_name);
		$objPHPExcel->getActiveSheet()->SetCellValue('F2', $requisition_info->dept_name);
		$objPHPExcel->getActiveSheet()->SetCellValue('G2', $requisition_info->sub_dept_name);
		$objPHPExcel->getActiveSheet()->SetCellValue('H2', $requisition_info->position);
		$objPHPExcel->getActiveSheet()->SetCellValue('I2', $requisition_info->request_reason);
		if($requisition_info->posting_type == 'I')
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('J2', "Internal");
		}
		else
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('J2', "External");
		}
		if($requisition_info->movement_type == 'V')
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('K2', "Vertical");
		}
		else if($requisition_info->movement_type == 'L')
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('K2', "Lateral");
		}
		else
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('K2', "Vertical/Lateral");
		}
		if($requisition_info->filter_type == '1')
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('L2', "Yes");
		}
		else
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('L2', "No");
		}
		
		
		$objPHPExcel->getActiveSheet()->getStyle("A4:I4")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->SetCellValue('A4', "Fusion ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('B4', "XPO ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('C4', "Name");
		$objPHPExcel->getActiveSheet()->SetCellValue('D4', "Dept");
		$objPHPExcel->getActiveSheet()->SetCellValue('E4', "Sub Dept");
		$objPHPExcel->getActiveSheet()->SetCellValue('F4', "Client");
		$objPHPExcel->getActiveSheet()->SetCellValue('G4', "Process");
		$objPHPExcel->getActiveSheet()->SetCellValue('H4', "L1 Supervisor");
		$objPHPExcel->getActiveSheet()->SetCellValue('I4', "DOJ");
		
		foreach($requisition_user_infos as $key=>$value)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.(4+($key+1)).'', $value->fusion_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.(4+($key+1)).'', $value->xpoid);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.(4+($key+1)).'', $value->user_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.(4+($key+1)).'', $value->dept_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.(4+($key+1)).'', $value->sub_department_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.(4+($key+1)).'', $value->client_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.(4+($key+1)).'', $value->process_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.(4+($key+1)).'', $value->l1_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.(4+($key+1)).'', $value->doj);
		}
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Progression Report For '.$form_data['requisition_id'].'.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	
	private function get_requisition_info($requisition_id)
	{
		$query = $this->db->query('SELECT ijp_requisitions.*,client.fullname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,ijp_request_reason.request_reason,role_organization.name AS position,DATE_FORMAT(due_date, "%m/%d/%Y") AS date_due FROM `ijp_requisitions` LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			WHERE requisition_id="'.$requisition_id.'"');
		return $query->row();
	}
	private function get_requisition_user_info($requisition_id)
	{
		$query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS user_name,signin.fusion_id,signin.xpoid,department.shname AS dept_name,sub_department.name AS sub_department_name,get_client_names(signin.id) AS client_name,get_process_names(signin.id) AS process_name,CONCAT(l1.fname," ",l1.lname) AS l1_name,signin.doj FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			LEFT JOIN department ON department.id=signin.dept_id
			LEFT JOIN sub_department ON sub_department.id=signin.sub_dept_id
			LEFT JOIN signin AS l1 ON l1.id=signin.assigned_to
			WHERE requisition_id="'.$requisition_id.'"');
		return $query->result_object();
	}
}