<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Covid_survey_phill extends CI_Controller {
	

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Profile_model');	
		$this->load->model('Reports_model');
		$this->load->model('Progression_model');
		$this->load->model('Email_model');
		$this->load->model('Schedule_adherence_model');
		$this->load->model('Leave_model');
		$this->load->model('Survey_model');
		
	 }

	public function index(){

		$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());

		$covid_current_user = get_user_id();
			//$covid_current_date = GetLocalDate();
			$covid_current_date = CurrDate();
			$covid_user_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, 
			         CONCAT(l.fname, ' ', l.lname) as l1_supervisor, lp.phone as supervisor_phone, d.description as department, r.name as designation
			         from signin as s 
					 LEFT JOIN department as d on d.id=s.dept_id
					 LEFT JOIN role as r on r.id=s.role_id
					 LEFT JOIN signin as l ON l.id = s.assigned_to
					 LEFT JOIN info_personal as lp ON lp.user_id = s.assigned_to
					 WHERE s.id = '$covid_current_user'";
			$data['covid_user_data'] = $this->Common_model->get_query_row_array($covid_user_sql);			
			$covid_start_date = $covid_current_date ." 00:00:00";  $covid_end_date = $covid_current_date ." 23:59:59"; 
			// $user_office_id = "CEB";
			$sql_covid_consent = "SELECT * from covid19_screening_checkup_phil WHERE date_added >= '$covid_start_date' AND date_added <= '$covid_end_date' AND user_id = '$covid_current_user' ORDER by id DESC LIMIT 1";
			
			$data['covid_consent_details_phil'] = $this->Common_model->get_query_result_array($sql_covid_consent);

			$data['content_template'] = "home/covid_checkup_phil.php";

			$this->load->view('dashboard_single_col',$data);
	}
	

		//============== SELF DECLARATION COVID SUBMISSION ================================================//
	
	public function covid_check_screening_submit(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			
			$covid_submission_type = $this->input->post('covid_submission_type');
			
				$employee_will_vaccinated = $this->input->post('employee_will_vaccinated');
				$data_array = array(
					"user_id"     			   => $current_user,
					"employee_will_vaccinated"     => $employee_will_vaccinated,
					"employee_acceptance"      => 1,
					"date_added" => CurrMySqlDate(),
					"date_added_local" => GetLocalTime(),
					"added_by" => $current_user
				);
				$submission_id = data_inserter('covid19_screening_checkup_phil', $data_array);

			redirect('home');
			
		}
	}



		public function generate_covid_screening_report(){
		if(check_logged_in()){

			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$office_id = "";
			$error= "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["content_template"] = "home/generate_covid_screening_details.php";
			
			
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

				$extraFilter = " AND (ph.date_added >= '$from_date_full' AND ph.date_added <= '$to_date_full') ";
			
				$query = $this->db->query("SELECT ph.*,signin.fname,signin.fusion_id, signin.lname,s.fname as added_by_fname, s.lname as added_by_lname FROM covid19_screening_checkup_phil ph LEFT JOIN signin ON signin.id=ph.user_id LEFT JOIN signin s ON s.id=ph.added_by WHERE 1 $extraFilter");
				$fullAray = $query->result_array();

				$this->screening_report_phil($fullAray);
				$dn_link = "";
					
			} 
			
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			$data['error']=$error;
			
			$this->load->view('dashboard_single_col',$data);
		}
	}

	
	public function screening_report_phil($rr)
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
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:G1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
			
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);		
			
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$objWorksheet->getStyle("A1:G1")->applyFromArray($style);
		$sheet = $this->objPHPExcel->getActiveSheet();

		unset($style);
 
		// CELL BACKGROUNG COLOR
		$this->objPHPExcel->getActiveSheet()->getStyle("A2:G2")->getFill()->applyFromArray(
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
							
		$header = array("Sl", "Fusion ID","Full Name", "Employee Wants Vaccine", "Employee Acceptance", "Date Added", "Date Added Local");

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

			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row, $vaccine);		
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row, $accpt);
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$row, $user['date_added']);
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $user['date_added_local']);
			$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $user['added_by_fname'].' '.$user['added_by_lname']);
			
				
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

}

?>