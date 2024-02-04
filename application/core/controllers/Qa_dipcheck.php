<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_dipcheck extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');	
		$this->load->model('Profile_model');
	 }
	 
	 
	public function index()
	{
		if(check_logged_in()){
			
			$client_id=get_client_ids();
			$process_id=get_process_ids();
			$data["aside_template"] = "qa/aside.php";
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			$data['current_user'] = get_user_id();
			
			$data["content_template"] = "qa_dipcheck/dipcheck.php";
						
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$_filterCond="";
						
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$client_id = $this->input->get('client_id');
			$process_id = $this->input->get('process_id');
						
			if($is_global_access!=1 && $oValue=="" ) $oValue=$user_office_id;
			
			if( $is_global_access!=1) $_filterCond .=" and (location_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',location_id,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location_id='".$oValue."'";
				else $_filterCond .= " and location_id='".$oValue."'";
			}
									
			if($client_id!="ALL" && $client_id!=""){
				if($_filterCond=="") $_filterCond .= " and qa_dipcheck.client_id='".$client_id."'";
				else $_filterCond .= " and qa_dipcheck.client_id='".$client_id."'";
			}
			
			if($process_id!="ALL" && $process_id!="" && $process_id!="0"){
				if($_filterCond=="") $_filterCond .= " and qa_dipcheck.process_id='".$process_id."'";
				else $_filterCond .= " and qa_dipcheck.process_id='".$process_id."'";
			}
						
			if(get_role_dir()=="super" || $is_global_access==1 || get_user_fusion_id()=='FKOL000023'){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//$qSql="Select * FROM qa_dipcheck  Where is_active =1 $_filterCond ORDER BY id ASC";
			
			$qSql="Select *, lt_examination.title as QPaper, client.shname AS client_name,GROUP_CONCAT(process.name SEPARATOR ', ') AS process_name  FROM qa_dipcheck LEFT JOIN lt_examination ON lt_examination.id=qa_dipcheck.exam_id LEFT JOIN client ON client.id=qa_dipcheck.client_id LEFT JOIN process ON FIND_IN_SET(process.id,qa_dipcheck.process_id) Where qa_dipcheck.is_active =1 $_filterCond GROUP BY qa_dipcheck.id ORDER BY qa_dipcheck.id ASC";
			
			//echo $qSql;
			
			$data["get_dipcheck_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * FROM lt_examination  Where type = 'QA' and status=1";
			$data["exam_list"] = $this->Common_model->get_query_result_array($qSql);
						
			//echo $qSql;
			
			$data['oValue']=$oValue;
			$data['client_id']=$client_id;
			$data['process_id']=$process_id;
			
			$this->load->view('dashboard',$data);
			
		}	
	}
	
	
	public function savedipcheck()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			
			
			$log=get_logs();
			$evt_date=CurrMySqlDate();
						
			$location_id = trim($this->input->post('location_id'));
			$exam_id = trim($this->input->post('exam_id'));
			$client_id = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$open_date = trim($this->input->post('open_date'));
			$close_date = trim($this->input->post('close_date'));
			$description = trim($this->input->post('description'));
			
			$field_array = array(
				"location_id" => $location_id,
				"exam_id" => $exam_id,
				"client_id" => $client_id,
				"process_id" => $process_id,
				"open_date" => $open_date,
				"close_date" => $close_date,
				"description" => $description,
				"added_by" => $current_user,
				"added_time" => $evt_date
			); 
			
			$timeDays = dateDiffCount($open_date, $close_date);
			$timeMinu= $timeDays*24*60;
			
			//print_r($field_array);
			
			$this->db->trans_start();
			
			$rowid = data_inserter('qa_dipcheck',$field_array);
			
			$qSql = 'SELECT id as value  FROM lt_question_set WHERE exam_id="'.$exam_id.'" and status=1 ORDER BY RAND() LIMIT 1';
			$set_id=$this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT count(id) as value FROM lt_questions where set_id = '$set_id' AND status = 1";
			$total_ques=$this->Common_model->get_single_value($qSql);
			
			
			$qSql="Select id,fusion_id from signin Where office_id = '$location_id' and is_assign_client(id,$client_id)=1 and is_assign_process(id,$process_id)=1 and status=1 ";
			
			$userArray = $this->Common_model->get_query_result_array($qSql);
			
			foreach($userArray as $row){
				
				$user_id=$row['id'];
				
				$qSql = 'REPLACE INTO lt_exam_schedule (module_id,module_type,user_id, exam_id, allotted_time, allotted_set_id, exam_start_time, added_by, added_date, exam_status,no_of_question) VALUES ("'.$rowid.'","QA","'.$user_id.'","'.$exam_id.'","'.$timeMinu.'","'.$set_id.'","'.$open_date.'","'.$current_user.'",now(),0,"'.$total_ques.'")';
				$query = $this->db->query($qSql);
			}
						
			if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
			else $this->db->trans_commit();
				
			redirect('qa_dipcheck', 'refresh');
			
			
		}
	}
	
	
	public function exam_panel()
	{
		if(check_logged_in())
		{
				
			$form_data = $this->input->post();
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			
			$data["is_global_access"] = get_global_access();
			
			$data["is_role_dir"] = get_role_dir();
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$data["exam_schedule_id"] = $form_data['lt_exam_schedule_id'];
			
			$query_scheduled_exam = $this->db->query('SELECT * FROM `lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].'');
			
			//print_r($form_data);
			
			
			$row = $query_scheduled_exam->row();
					
			$data["questions"] = $this->generate_question($row);
			
			$query_scheduled_exam = $this->db->query('SELECT * FROM `lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].'');
			$row = $query_scheduled_exam->row();
			$data["exam_info"] = $row;
						
			$data["content_template"] = "qa_dipcheck/exam_panel.php";
			$data["content_js"] = "qa_dipcheck/exam_panel_js.php";
			
			$this->load->view('dashboard_single_col',$data);
		}
	}
	
	private function generate_question($row)
	{
		$current_user = get_user_id();
		
		$question_info = array();
		
		//print_r($row);
		
		if($row->exam_status == 2 || $row->exam_status == 0)
		{
						
			$query = $this->db->query('SELECT id FROM lt_questions WHERE set_id= "'.$row->allotted_set_id.'" ORDER BY RAND() LIMIT '.$row->no_of_question .'' );
			
			$this->db->query('DELETE FROM `lt_user_exam_answer` WHERE exam_schedule_id="'.$row->id.'"');
			
			$rows = $query->result_object();
			$allotted_question_ids = array();
			$question_info = array();
			foreach($rows as $key=>$value)
			{
				$allotted_question_ids[] = $value->id;
				$question_info['question_id'][] = $value->id;
				$question_info['question_status'][] = 0;
				
				$this->db->query('INSERT INTO `lt_user_exam_answer`(`exam_schedule_id`, `ques_id`, `status`, `added_time`) VALUES ("'.$row->id.'","'.$value->id.'","0",now())');
			}
			
			$this->db->query('UPDATE lt_exam_schedule SET exam_status="3",exam_start_time="'.ConvServerToLocal(date('Y-m-d H:i:s')).'" WHERE id='.$row->id.'');
		}
		else if($row->exam_status == 3)
		{
			$minutes_to_add = $row->allotted_time;
			$time = new DateTime($row->exam_start_time);
			$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

			$end_time = $time->format('Y-m-d H:i:s');
			if(strtotime($end_time) < ConvServerToLocal(date('Y-m-d H:i:s')))
			{
				$this->db->query('UPDATE lt_exam_schedule SET exam_status="1" WHERE id='.$row->id.'');
				
				redirect('qa_dipcheck/qa_dashboard', 'refresh');
			}
			
			$qSql = 'SELECT lt_questions.id,lt_user_exam_answer.status FROM lt_questions INNER JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id WHERE set_id= "'.$row->allotted_set_id.'" and exam_schedule_id = "'. $row->id .'" ';
			
			//echo $qSql;
			
			$query = $this->db->query($qSql);
			
			$rows = $query->result_object();
			$allotted_question_ids = array();
			$question_info = array();
			foreach($rows as $key=>$value)
			{
				$allotted_question_ids[] = $value->id;
				$question_info['question_id'][] = $value->id;
				$question_info['question_status'][] = $value->status;
			}
		}
		
		//print_r ($question_info);
		
		return $question_info;
		
	}
	
	public function get_first_question()
	{
		$form_data = $this->input->post();
		
		$qSql = 'SELECT lt_questions.id,lt_questions.title,lt_questions_ans_options.id AS option_id,lt_questions_ans_options.text,lt_questions_ans_options.correct_answer,lt_user_exam_answer.status,lt_user_exam_answer.ans_id FROM lt_questions LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id
			LEFT JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id
			WHERE lt_questions.id="'.$form_data['question_id'].'" AND exam_schedule_id="'.$form_data['exam_schedule_id'].'"';
		
		//echo $qSql;
		
		$query = $this->db->query($qSql);
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function submit_question()
	{
		$form_data = $this->input->post();
		$query = false;
		if($form_data['option_id'] != 0)
		{
			$query = $this->db->query('UPDATE lt_user_exam_answer SET ans_id="'.$form_data['option_id'].'",status="1"  WHERE exam_schedule_id="'.$form_data['exam_schedule_id'].'" AND ques_id="'.$form_data['question_id'].'"');
		}
		
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	public function get_question()
	{
		$form_data = $this->input->post();
		
		$query = $this->db->query('SELECT lt_questions.id,lt_questions.title,lt_questions_ans_options.id AS option_id,lt_questions_ans_options.text,lt_questions_ans_options.correct_answer,lt_user_exam_answer.status,lt_user_exam_answer.ans_id FROM lt_questions LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id
			LEFT JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id
			WHERE lt_questions.id="'.$form_data['question_id'].'" AND exam_schedule_id="'.$form_data['exam_schedule_id'].'"');
			
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function submit_exam()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		//$query = false;
		
		$this->db->query('UPDATE lt_exam_schedule SET exam_status="1"  WHERE id="'.$form_data['exam_schedule_id'].'"');
		$query = $this->db->query('SELECT * FROM lt_exam_schedule WHERE id="'.$form_data['exam_schedule_id'].'"');
		$row = $query->row();
		
		
		//check if any more exam left
		$query1 = $this->db->query('SELECT COUNT(*) as available_exam FROM lt_exam_schedule WHERE module_id="'.$row->module_id.'" AND exam_status != 1');
		
		$results = $query1->row();
				
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	
	
	//****************************************************************************************//
	// CANDIDATE EXAMINATION REPORT ///
	//****************************************************************************************//
	
	public function dipcheck_report(){
		if(check_logged_in()){
			 
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "reports/dipcheck.php";
			$data["content_js"] = "qa_dipcheck/dipcheck_js.php";
			
			$SQLtxt ="SELECT * FROM qa_dipcheck ORDER BY id ASC";
			$data_fields = $this->db->query($SQLtxt);
			
			$data['campaign'] = $data_fields->result();
			
			$this->load->view("dashboard",$data);
			
		}
	}
	
	public function download_dipcheck_rep(){
		if(check_logged_in()){
			if($_GET['process_download'] == "Download" &&  $_GET['campaign_id']!=""){ 

				$SQLtxt ="SELECT allotted_set_id, exam_status FROM lt_examination INNER JOIN lt_exam_schedule ON lt_examination.id = lt_exam_schedule.exam_id where lt_exam_schedule.exam_id=". $_GET['campaign_id'] ." GROUP BY allotted_set_id";
				
				$data_fields = $this->db->query($SQLtxt);
				$data['set_count'] = $data_fields->result_array();
											
				$this->generate_dipcheck_xls($_GET['campaign_id'],$_GET['desc'],$data['set_count']);
				
			}else{
				redirect('reports/dipcheck','refresh');
			}
		}
	}
	
	
	private function generate_dipcheck_xls($campaign_id, $heading, $set_count ){
		if(check_logged_in()){
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
			$objWorksheet->getColumnDimension('E')->setWidth(50);
			$objWorksheet->getColumnDimension('F')->setWidth(50);
			$objWorksheet->getColumnDimension('G')->setWidth(50);
			$objWorksheet->getColumnDimension('H')->setWidth(50);
			$objWorksheet->getColumnDimension('I')->setWidth(50);
			$objWorksheet->getColumnDimension('J')->setWidth(50);
			$objWorksheet->getColumnDimension('K')->setWidth(50);
			$objWorksheet->getColumnDimension('L')->setWidth(50);
			$objWorksheet->getColumnDimension('M')->setWidth(50);
			$objWorksheet->getColumnDimension('N')->setWidth(50);
			$objWorksheet->getColumnDimension('O')->setWidth(50);
			$objWorksheet->getColumnDimension('P')->setWidth(50);
			$objWorksheet->getColumnDimension('Q')->setWidth(50);
			$objWorksheet->getColumnDimension('R')->setWidth(50);
			$objWorksheet->getColumnDimension('S')->setWidth(50);
			$objWorksheet->getColumnDimension('T')->setWidth(50);
			$objWorksheet->getColumnDimension('U')->setWidth(50);
			$objWorksheet->getColumnDimension('V')->setWidth(50);
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:P1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:O2")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "F28A8C"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
                );
       
			// CELL FONT AND FONT COLOR 
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14,
				'name'  => 'Algerian',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			));
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "Dip Check ".$heading);
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
							
					 /*
					    $SQLtxt="Select fusion_id,fname,lname,(Select CONCAT(fname,' ' ,lname) from signin where signin.id=s.assigned_to) as asign_tl, user_id,set_id,exam_id,exam_schedule_id,ques_id,ans_id, (SELECT text FROM lt_questions_ans_options QA_O WHERE QA_O.id = ua.ans_id )AS User_answer from lt_exam_schedule x inner JOIN lt_questions y on y.set_id = x.allotted_set_id
						inner JOIN lt_user_exam_answer ua on ua.exam_schedule_id = x.id and ua.ques_id = y.id
						left JOIN signin s on s.id = x.user_id
						where exam_id =". $campaign_id ." and allotted_set_id = ". $no_set['allotted_set_id'] ."
						order by user_id,ques_id";
					*/
						
					   $SQLtxt="Select fusion_id,fname,lname,(Select CONCAT(fname,' ' ,lname) from signin where signin.id=s.assigned_to) as asign_tl, user_id,set_id,exam_id,exam_schedule_id, ua.ques_id, no_of_question, ans_id, QA_O.text AS User_answer, QA_O.correct_answer from lt_exam_schedule x 
						inner JOIN lt_questions y on y.set_id = x.allotted_set_id
						inner JOIN lt_user_exam_answer ua on ua.exam_schedule_id = x.id and ua.ques_id = y.id
						LEFT JOIN lt_questions_ans_options QA_O ON QA_O.id=ua.ans_id
						left JOIN signin s on s.id = x.user_id
						where exam_id =". $campaign_id ." and allotted_set_id = ". $no_set['allotted_set_id'] ."
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
							 if($recRow['User_answer'] =='') $recRow['User_answer'] ="NA";
							 
								//if($data['Questions'][$i]['fusion_id'] != $old_fusion_id){
								if($recRow['fusion_id'] == $old_fusion_id ){
									
									$col++;
									$correct_answer += $recRow['correct_answer'];
									//FOR COLOR TEST LIGHT GREEN 
									if($recRow['correct_answer'] == 1){
										$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFF99');
									}
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['User_answer']  );
									 
									//$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
									
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
									//FOR COLOR TEST LIGHT GREEN 
									if($recRow['correct_answer'] == 1){
										$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFF99');
									}
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['User_answer']  );
									$correct_answer += $recRow['correct_answer'];  
									
									
								}
								
								
								  
							}
							
					}


  
		    ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="dipcheck_'.$heading.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
            	
		}
	}
	
	
	
	
	
}

?>