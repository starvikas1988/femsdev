<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trreports extends CI_Controller {

    private $aside = "reports/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		$this->load->model('Common_model');						
		$this->objPHPExcel = new PHPExcel();
		
	 }
	 
    public function index()
    {
				
        if(check_logged_in())
        {
			/// Type your code
        }
    }
	
		
	//****************************************************************************************//
	// Assessment REPORT individual ///
	//****************************************************************************************//
	
	public function download_assmnt_dtls(){
		if(check_logged_in()){
			
				$assmnt_id = $_GET['assmnt_id'];
								
				if ($assmnt_id!=""){
				$qSql="SELECT module_id, (Select asmnt_name from training_assessment ta where ta.id =es.module_id  )as asmnt_name , exam_id, (Select title from lt_examination lte where lte.id =es.exam_id  )as exam_title, allotted_set_id, exam_status, no_of_question FROM lt_exam_schedule es Where module_id = '$assmnt_id' AND module_type = 'TR' group by module_id, module_type,exam_id,allotted_set_id";
				
				$examDtls = $this->Common_model->get_query_result_array($qSql);
				
				$asmnt_name = $examDtls[0]['asmnt_name'];
				 
				$exam_title = $examDtls[0]['exam_title'];
				$exam_id = $examDtls[0]['exam_id'];
				
				$this->generate_assessment_xls($exam_id,$asmnt_name,$examDtls);
				}
				
		}
		
		
	}
	
	
	private function generate_assessment_xls($exam_id, $heading, $set_count ){
		
		if(check_logged_in()){
			
			$letters = array(); 
			$k=0;
			 for ($i = 'A'; $i !== 'ZZ'; $i++){
				$letters[$k++]=$i;
			}
		
		
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Exam Result Report");
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);	
			
	   
			$objWorksheet->getColumnDimension('A')->setWidth(15);
			$objWorksheet->getColumnDimension('B')->setWidth(15);
			$objWorksheet->getColumnDimension('C')->setWidth(15);
			$objWorksheet->getColumnDimension('D')->setWidth(15);
			$objWorksheet->getColumnDimension('E')->setWidth(40);
			$objWorksheet->getColumnDimension('F')->setWidth(40);
			$objWorksheet->getColumnDimension('G')->setWidth(40);
			$objWorksheet->getColumnDimension('H')->setWidth(40);
			$objWorksheet->getColumnDimension('I')->setWidth(40);
			$objWorksheet->getColumnDimension('J')->setWidth(40);
			$objWorksheet->getColumnDimension('K')->setWidth(40);
			$objWorksheet->getColumnDimension('L')->setWidth(40);
			$objWorksheet->getColumnDimension('M')->setWidth(40);
			$objWorksheet->getColumnDimension('N')->setWidth(40);
			$objWorksheet->getColumnDimension('O')->setWidth(40);
			$objWorksheet->getColumnDimension('P')->setWidth(40);
			$objWorksheet->getColumnDimension('Q')->setWidth(40);
			$objWorksheet->getColumnDimension('R')->setWidth(40);
			$objWorksheet->getColumnDimension('S')->setWidth(40);
			$objWorksheet->getColumnDimension('T')->setWidth(40);
			$objWorksheet->getColumnDimension('U')->setWidth(40);
			$objWorksheet->getColumnDimension('V')->setWidth(40);
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:P1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			
				
			$styleGreen = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '#013220'),
			));
			
			$styleDef = array(
			'font'  => array(
				'bold'  => false,
				'color' => array('rgb' => '#000000'),
			));
			
			
				
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			//$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "Assessment_".$heading);
			
			$sheet->mergeCells('A1:J1');
					
			
					foreach($set_count as $no_set){
						
					$col1=0;
					$row1=2; 	
						
						$SQLtxt = "Select * from lt_questions where set_id = ". $no_set['allotted_set_id'] ." order by id";
						$data_fields1 = $this->db->query($SQLtxt);
						$data['candidate'] = $data_fields1->result_array();
						
						$header_column = array("SL No","FUSION ID","AGENT NAME","TL Name");
						
							foreach($header_column as $val){
								if($col1 < 4){
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,2,$val);	
									$col1++;
								}
							}
							
							foreach($data['candidate'] as $excel_header){
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$excel_header['title']);	 
									$col1++; 
									 
							}
							
							/*$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,'Score');
							$fcol = $col1;
							$fcol = $col1+1; */
							$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,'Score Percentage');
							
					 						
						$SQLtxt="Select fusion_id,fname,lname,(Select CONCAT(fname,' ' ,lname) from signin where signin.id=s.assigned_to) as asign_tl, user_id,set_id,exam_id,exam_schedule_id, ua.ques_id, no_of_question, ans_id, QA_O.text AS User_answer, QA_O.correct_answer from lt_exam_schedule x 
						inner JOIN lt_questions y on y.set_id = x.allotted_set_id
						inner JOIN lt_user_exam_answer ua on ua.exam_schedule_id = x.id and ua.ques_id = y.id
						LEFT JOIN lt_questions_ans_options QA_O ON QA_O.id=ua.ans_id
						left JOIN signin s on s.id = x.user_id
						where exam_id =". $exam_id ." and allotted_set_id = ". $no_set['allotted_set_id'] ."
						order by user_id,ques_id";
						
						
						$data_fields1 = $this->db->query($SQLtxt); 
						$data['Questions'] = $data_fields1->result_array();
					
						
						$no_of_question=$data['Questions'][0]['no_of_question'];
						
						$col=0;
						$row=2; 
						$cnt=1; 
						
							$correct_answer=0;
							$old_fusion_id=''; 
							/* for($i=0;$i<count($data['Questions']);$i++){ */
							foreach($data['Questions'] as $recRow){
								
							$cell=$letters[$col].$row;
							$this->objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray($styleDef);
							
							
							 if($recRow['User_answer'] =='') $recRow['User_answer'] ="NA";
							 
								//if($data['Questions'][$i]['fusion_id'] != $old_fusion_id){
								if($recRow['fusion_id'] == $old_fusion_id ){
									
									$col++;
									$correct_answer += $recRow['correct_answer'];
									
									$cell=$letters[$col].$row;
									if($recRow['correct_answer']==1){
										$this->objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray($styleGreen);
									}
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['User_answer']  );
									 
									$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row, ($correct_answer / $no_of_question));
									
								}else{
									
									
				
									$old_fusion_id =  $recRow['fusion_id'];
									$correct_answer=0;
									$col=0;
									$row++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $cnt++ );
									$col++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['fusion_id'] );
									$col++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['fname']." ".$recRow['lname'] );
									$col++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['asign_tl'] );
									$col++;
									
									$cell=$letters[$col].$row;
									if($recRow['correct_answer']==1){
										$this->objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray($styleGreen);
									}										
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['User_answer']  );
									
									$correct_answer += $recRow['correct_answer'];  
								}
								
								
								  
							}
							
					}


  
		 	ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Assessment_'.$heading.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();   
            	
		}
	}
	
	
 //////////////Work Shop Seed/////////////
	public function work_shop_seed(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/work_shop_seed.php";
			$action="";
			$dn_link="";
			
			$data["work_shop_seed_list"] = array();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				
				/* $field_array = array(
					"office_id"=>$office_id
				); */
				
				if($office_id=="ALL"){
					$query = $this->db->query('Select * from (Select *, date(added_date) as addedDate from work_shop_seed) xx Left Join (select id as uid, fusion_id, fname, lname, dept_id, role_id, (select shname from department d where d.id=dept_id) as dept_name, (select name from role r where r.id=role_id) as role_name from signin) yy On (xx.user_id=yy.uid) order by fname');
					$fullAray = $query->result_array();
				}else{
					$query = $this->db->query('Select * from (Select *, date(added_date) as addedDate from work_shop_seed where location_id="'.$office_id.'") xx Left Join (select id as uid, fusion_id, fname, lname, dept_id, role_id, (select shname from department d where d.id=dept_id) as dept_name, (select name from role r where r.id=role_id) as role_name from signin) yy On (xx.user_id=yy.uid) order by fname');
					$fullAray = $query->result_array();
				}
				
				$data["work_shop_seed_list"] = $fullAray;
				$this->create_workshopseed_CSV($fullAray);	
				$dn_link = base_url()."reports/download_workshopseed_CSV";
			}
				
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_workshopseed_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Work Shop Seed List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_workshopseed_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Name", "Role", "Department", "Phone", "Email", "Entry Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['email_id'].'",'; 
			$row .= '"'.$user['addedDate'].'"'; 
							
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
}

?>