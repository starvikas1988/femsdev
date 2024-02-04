<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Covid19_pre_check extends CI_Controller {
	
	private $objPHPExcel;
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->library('excel');
		
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
	public function index(){
		if(check_logged_in()){
			$current_user = get_user_id();
			
			$data["aside_template"] = "covid19_pre_check/aside.php";
            $data["content_template"] = "covid19_pre_check/covid19_pre_check.php";
			
			$qSql="Select s.id, s.fusion_id, s.fname, s.lname, FLOOR(DATEDIFF(CURDATE(), s.dob)/365) as age, get_client_names(s.id) as clientName, get_process_names(s.id) as processName, ip.address_present, ip.phone from signin s Left Join info_personal ip on s.id=ip.user_id where s.id='$current_user'";
			$data["userstat"] = $this->Common_model->get_query_row_array($qSql);
			
			$qSql="Select co.*, s.fname, s.lname, s.fusion_id, s.office_id from covid_19_preliminary_check co Left Join signin s On co.user_id=s.id where co.user_id='$current_user'";
			$data["preCovidList"] = $this->Common_model->get_query_result_array($qSql);
			
			if($this->input->post('submit')== 'SUBMIT')
			{
				$field_array = array(
					"user_id" => $current_user,
					
					"pre_exist_asthma" => $this->input->post('pre_exist_asthma'),
					"pre_exist_hyper" => $this->input->post('pre_exist_hyper'),
					"pre_exist_transmit" => $this->input->post('pre_exist_transmit'),
					"pre_exist_diabates" => $this->input->post('pre_exist_diabates'),
					"pre_exist_pregnant" => $this->input->post('pre_exist_pregnant'),
					"pre_exist_pregnant_text" => $this->input->post('pre_exist_pregnant_text'),
					"pre_exist_disease" => $this->input->post('pre_exist_disease'),
					"pre_exist_disease_text" => $this->input->post('pre_exist_disease_text'),
					"pre_exist_exposer" => $this->input->post('pre_exist_exposer'),
					"pre_exist_contact" => $this->input->post('pre_exist_contact'),
					"pre_exist_none" => $this->input->post('pre_exist_none'),
					
					"symptoms_fever" => $this->input->post('symptoms_fever'),
					"fever_how_long" => $this->input->post('fever_how_long'),
					"symptoms_headache" => $this->input->post('symptoms_headache'),
					"symptoms_muscle" => $this->input->post('symptoms_muscle'),
					"symptoms_fgatigue" => $this->input->post('symptoms_fgatigue'),
					"symptoms_cough" => $this->input->post('symptoms_cough'),
					"cough_how_long" => $this->input->post('cough_how_long'),
					"symptoms_cold" => $this->input->post('symptoms_cold'),
					"symptoms_breath" => $this->input->post('symptoms_breath'),
					"symptoms_dificult_breath" => $this->input->post('symptoms_dificult_breath'),
					"symptoms_throat" => $this->input->post('symptoms_throat'),
					"symptoms_nausea" => $this->input->post('symptoms_nausea'),
					"symptoms_diarrhea" => $this->input->post('symptoms_diarrhea'),
					"symptoms_abdominal" => $this->input->post('symptoms_abdominal'),
					"symptoms_loss_taste" => $this->input->post('symptoms_loss_taste'),
					"symptoms_loss_smell" => $this->input->post('symptoms_loss_smell'),
					"symptoms_none" => $this->input->post('symptoms_none'),
					
					"status" => $this->input->post('status'),
					"entry_by" => $current_user,
					"entry_date" => CurrMySqlDate()
				);
				$rowid = data_inserter('covid_19_preliminary_check',$field_array);
				
				redirect('covid19_pre_check');
			}	
			
			$this->load->view('dashboard',$data);
		}
	}
	
//////////////////////////////////////////////////////////////////////////////	
	
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
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "covid19_pre_check/report.php";
			
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
	
}
?>	