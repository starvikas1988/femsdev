<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_pm extends CI_Controller {

    private $aside = "reports_pm/aside.php";
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
		$this->load->model('Dfr_model');
		$this->reports_model->set_report_database("report");
		
		$this->objPHPExcel = new PHPExcel();
		
	 }


	 	public function index()
    {
        if(check_logged_in())
        {
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$data["aside_template"] = $this->aside;

			$_s = $this->db->query("SELECT DISTINCT client_id,client.shname FROM `pm_design_v2` 
									LEFT JOIN `client` ON client.id=pm_design_v2.client_id");

			$rows = $_s->result_object();
			$data["client_options"] = $rows;
				
			$data["content_template"] = "reports_pm/rep_main.php";
			
			$this->load->view('dashboard',$data);
		}
	}

	public function generate_bank_status_xls()
	{
		$form_data = $this->input->post();
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle('PMetrix Report');
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			 $this->objPHPExcel->getActiveSheet()->getStyle('A1:J1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
			
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
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:J1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:J2")->getFill()->applyFromArray(
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
				'size'  => 16,
				'name'  => 'Algerian'
			));

			$this->objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 1, "PMetrix Report");
			$sheet->mergeCells('A1:J1');
					
			
			
          $header = array("Module Name", "Fusion Id","Name","Role","Client Name","Process Name","L1","L2","View Time","Download");

			$col=0;
			$row=2;
		
			foreach($header as  $excel_header){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $excel_header);	
					$col++; 
			}
			
			$row=3;
			$col = 0;

			$_sql = 'SELECT log_pm.*,signin.fusion_id,signin.fname,signin.lname,client.shname AS client_name,process.name AS process_name,concat(l1.fname," ",l1.lname) AS l1_name,concat(l2.fname," ",l2.lname) AS l2_name,role_organization.name AS org_role 
			FROM `log_pm`
			LEFT JOIN signin ON signin.id=log_pm.user_id
			LEFT JOIN info_assign_client ON info_assign_client.user_id=signin.id
			LEFT JOIN client ON info_assign_client.client_id=client.id
			LEFT JOIN info_assign_process ON info_assign_process.user_id=signin.id
			LEFT JOIN process ON info_assign_process.process_id=process.id

			LEFT JOIN signin AS l1 ON l1.id=signin.assigned_to
			LEFT JOIN signin AS l2 ON l2.id=l1.assigned_to
			LEFT JOIN role_organization ON role_organization.id=signin.org_role_id
			WHERE module="'.$form_data['search_for'].'" AND `time` >="'.$form_data['start_date'].' 00:00:00" 
			AND `time` <="'.$form_data['end_date'].' 23:59:59"';

			if($form_data["client_for"]!=""){
				$_sql .= ' and client.id = "'.$form_data["client_for"].'"';
			}
			
			//print $_sql;

			$query = $this->db->query($_sql);

			$rows = $query->result_object();
			foreach($rows as $key=>$value)
			{
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row, $value->description);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row, $value->fusion_id);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$row, $value->fname.' '.$value->lname);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row, $value->org_role);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row, $value->client_name);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$row, $value->process_name);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $value->l1_name);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$row, $value->l2_name);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(8, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$row, $value->time);
				
				if($value->download == 0)
				{
					$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(9, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$row, 'No');
				}
				else
				{
					$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(9, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$row, 'Yes');
				}
				
				$row ++;
			}
			
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$form_data['search_for'].'_user_log.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
			
	}	
	
		
}

?>