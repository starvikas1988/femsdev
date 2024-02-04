<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examination extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');
		
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
			
			//loading aside template
			$data["aside_template"] = "examination/aside.php";
		if( get_dept_folder()=="wfm" || get_dept_folder()=="qa" || get_dept_folder()=="training" || get_dept_folder()=="hr" || $is_global_access==1  || get_role_dir()=="manager" || get_role_dir()=="admin" || is_approve_requisition()==true )
			{
				//loading main content template
				$data["content_template"] = "examination/create_exam.php";
			}else{
				//if not above condition then redirect to apply method
				redirect('examination/giveexam', 'refresh');
			}
			if($is_global_access==1){
				//return all office location list
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				//return all office location list for particular list
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$sqlexam = "SELECT distinct(type) from lt_examination";
			$data['examination_lt_type'] = $this->Common_model->get_query_result_array($sqlexam);
			
			$data["content_js"] = "examination/create_exam_js.php";
			
			//get all department list
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_exam_list()
	{
		$is_global_access = get_global_access();
		$addextrasql = "";
		
		$form_data = $this->input->post();
		$form_office_id = $form_data['office_id'];
		$form_lt_type = $form_data['lttype'];
		if($form_lt_type != ""){ $addextrasql = ' AND type IN ("'.$form_lt_type.'") '; }
		
		if($is_global_access==1){
			$query = $this->db->query('SELECT * FROM lt_examination WHERE status=1 '.$addextrasql.' ORDER BY id DESC');
		}else{
			$query = $this->db->query('SELECT * FROM lt_examination WHERE location IN ("'.$form_office_id.'") '.$addextrasql.' AND status=1 ORDER BY id DESC');
		}
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
	
	public function get_set_list()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT *,(SELECT COUNT(*) FROM `lt_questions` WHERE set_id=lt_question_set.id GROUP BY set_id) AS no_of_question FROM `lt_question_set` WHERE exam_id IN("'.$form_data['exam_id'].'") AND status=1 ORDER BY id DESC');
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
	
	public function create_exam()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		
		$query = $this->db->query('INSERT INTO `lt_examination`(`title`, `location`, `type`, `added_by`, `added_time`) VALUES ("'.$form_data['title'].'","'.$form_data['location_id'].'","'.$form_data['type'].'","'.$current_user.'",now())');
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
	
	public function create_set()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		
		$query = $this->db->query('INSERT INTO `lt_question_set`(`exam_id`, `title`, `status`, `added_by`, `added_time`) VALUES ("'.$form_data['exam_id'].'","'.$form_data['set_name'].'",1,"'.$current_user.'",now())');
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
	
	public function upload_exam_set()
	{
		$config['upload_path']          = './uploads/exam_set/';
		$config['allowed_types']        = 'xlsx';
		$config['max_size']             = 1024;
		$form_data = $this->input->post();
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload('upload_file'))
		{
			$response['stat'] = false;
			$response['datas'] = $this->upload->display_errors();
		}
		else
		{
			$datas = $this->upload->data();
			if($this->read_excel($datas['file_name'],$form_data['set_id']))
			{
				$query = $this->db->query('SELECT exam_id FROM lt_question_set WHERE id='.$form_data['set_id'].'');
				$row = $query->row();
				$response['stat'] = true;
				$datas = $this->upload->data();
				$response['datas'] = $datas;
				$response['datas']['exam_id'] = $row->exam_id;
			}
			else
			{
				$response['stat'] = false;
			}
		}
		echo json_encode($response);
	}
	
	public function read_excel($file_name,$set_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/exam_set/'.$file_name;
		
		$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		$question_ans = array();
		
		for($row = 2; $row <= $highestRow; $row++)
		{
			$question_ans['question'][] = $objWorksheet->getCell('B'.$row)->getValue();
			$question_ans['option1'][] = $objWorksheet->getCell('C'.$row)->getValue();
			$question_ans['option2'][] = $objWorksheet->getCell('D'.$row)->getValue();
			$question_ans['option3'][] = $objWorksheet->getCell('E'.$row)->getValue();
			$question_ans['option4'][] = $objWorksheet->getCell('F'.$row)->getValue();
			$question_ans['correct'][] = $objWorksheet->getCell('G'.$row)->getValue();
		}
		
		$this->db->trans_begin();
		foreach($question_ans['question'] as $key=>$value)
		{
			$this->db->query('INSERT INTO `lt_questions`(`set_id`, `title`, `status`, `added_by`, `added_time`) VALUES ('.$set_id.','.$this->db->escape($value).',1,"'.$current_user.'",now())');
			$insert_id = $this->db->insert_id();
			$option1 = 0;
			$option2 = 0;
			$option3 = 0;
			$option4 = 0;
			if($question_ans['correct'][$key] == 1)
			{
				$option1 = 1;
			}
			else if($question_ans['correct'][$key] == 2)
			{
				$option2 = 1;
			}
			else if($question_ans['correct'][$key] == 3)
			{
				$option3 = 1;
			}
			else if($question_ans['correct'][$key] == 4)
			{
				$option4 = 1;
			}
			
			$this->db->query('INSERT INTO `lt_questions_ans_options`(`ques_id`, `text`, `correct_answer`, `status`, `added_time`, `added_by`) VALUES ('.$insert_id.','.$this->db->escape($question_ans['option1'][$key]).','.$option1.',1,now(),"'.$current_user.'"),('.$insert_id.','.$this->db->escape($question_ans['option2'][$key]).','.$option2.',1,now(),"'.$current_user.'"),('.$insert_id.','.$this->db->escape($question_ans['option3'][$key]).','.$option3.',1,now(),"'.$current_user.'"),('.$insert_id.','.$this->db->escape($question_ans['option4'][$key]).','.$option4.',1,now(),"'.$current_user.'")');
		}
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
	
	//IJP
	
	public function giveexam()
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
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$data["content_template"] = "examination/give_exam.php";
			$data["content_js"] = "examination/give_exam_js.php";
			
			$qSql= 'SELECT lt_exam_schedule.*, getLocalToEst(lt_exam_schedule.exam_start_time,user_id) as exam_start_time_est,  NOW() AS current_server_time,(getLocalToEst(lt_exam_schedule.exam_start_time,user_id) + INTERVAL lt_exam_schedule.allotted_time MINUTE) AS exam_end_time FROM `lt_exam_schedule` WHERE user_id="'.$current_user.'" AND  (getLocalToEst(lt_exam_schedule.exam_start_time,user_id) - INTERVAL 30 MINUTE) <= NOW() AND (getLocalToEst(lt_exam_schedule.exam_start_time,user_id) + INTERVAL lt_exam_schedule.allotted_time MINUTE) >= now()';
			
			$get_alloted_set_query = $this->db->query($qSql);
			
			//echo $qSql;
			
			$get_alloted_set = $get_alloted_set_query->result_object();
			$data["available_exam"] = $get_alloted_set;
			$data["available_exam_count"] = $get_alloted_set_query->num_rows();
			
			$this->load->view('dashboard_single_col',$data);
		}
	}
	
	
	public function exam_panel()
	{
		if(check_logged_in())
		{
			if(!isset($_SERVER["HTTP_REFERER"]))
			{
				redirect('/progression/apply', 'refresh');
			}
			if($_SERVER["HTTP_REFERER"] != base_url('progression/apply'))
			{
				redirect('/progression/apply', 'refresh');
			}
	
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
			$row = $query_scheduled_exam->row();
			
			
			//print_r($row);
			
			$data["questions"] = $this->generate_question($row);
			
			$query_scheduled_exam = $this->db->query('SELECT * FROM `lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].'');
			$row = $query_scheduled_exam->row();
			$data["exam_info"] = $row;
						
			$data["content_template"] = "examination/exam_panel.php";
			$data["content_js"] = "examination/exam_panel_js.php";
			
			$this->load->view('dashboard_single_col',$data);
		}
	}
	
	private function generate_question($row)
	{
		$current_user = get_user_id();
		
		if($row->exam_status == 2)
		{
			//$query = $this->db->query('SELECT lt_questions.id,lt_user_exam_answer.status FROM lt_questions LEFT JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id WHERE set_id='.$row->allotted_set_id.' ORDER BY RAND() LIMIT 10');
			
			//$query = $this->db->query('SELECT id FROM lt_questions WHERE set_id= "'.$row->allotted_set_id.'" ORDER BY RAND() LIMIT 10');
			
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
				
				$this->db->query('UPDATE ijp_requisition_applications SET status="FilterTestDone"  WHERE requisition_id="'.$row->module_id.'" AND user_id="'.$row->user_id.'"');
		
				//check if any more exam left
				$query1 = $this->db->query('SELECT COUNT(*) as available_exam FROM lt_exam_schedule WHERE module_id="'.$row->module_id.'" AND exam_status != 1');
				$results = $query1->row();
				if($results->available_exam == 0)
				{
					$this->db->query('UPDATE ijp_requisitions SET life_cycle="FTD"  WHERE requisition_id="'.$row->module_id.'"');
				}
				redirect('progression/apply', 'refresh');
			}
	
			$query = $this->db->query('SELECT lt_questions.id,lt_user_exam_answer.status FROM lt_questions INNER JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id WHERE set_id= "'.$row->allotted_set_id.'" and exam_schedule_id = "'. $row->id .'" ');
			
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
		///
		$this->db->query('UPDATE ijp_requisition_applications SET status="FilterTestDone"  WHERE requisition_id="'.$row->module_id.'" AND user_id="'.$row->user_id.'"');
		
		//check if any more exam left
		$query1 = $this->db->query('SELECT COUNT(*) as available_exam FROM lt_exam_schedule WHERE module_id="'.$row->module_id.'" AND exam_status NOT IN (1,4)');
		
		$results = $query1->row();
		if($results->available_exam == 0)
		{
			$this->db->query('UPDATE ijp_requisitions SET life_cycle="FTD"  WHERE requisition_id="'.$row->module_id.'"');
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
	
	public function reject_exam()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		//$query = false;
		
		$this->db->query('UPDATE lt_exam_schedule SET exam_status="4"  WHERE id="'.$form_data['exam_schedule_id'].'"');
		$query = $this->db->query('SELECT * FROM lt_exam_schedule WHERE id="'.$form_data['exam_schedule_id'].'"');
		$row = $query->row();
		///
		$this->db->query('UPDATE ijp_requisition_applications SET status="MisFiltTest"  WHERE requisition_id="'.$row->module_id.'" AND user_id="'.$row->user_id.'"');
		
		//check if any more exam left
		$query1 = $this->db->query('SELECT COUNT(*) as available_exam FROM lt_exam_schedule WHERE module_id="'.$row->module_id.'" AND exam_status NOT IN (1,4)');
		
		$results = $query1->row();
		if($results->available_exam == 0)
		{
			$this->db->query('UPDATE ijp_requisitions SET life_cycle="FTD"  WHERE requisition_id="'.$row->module_id.'"');
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
	
	
	public function get_question_to_view()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT lt_questions.id AS question_id,lt_questions.title AS question,lt_questions_ans_options.text AS options,lt_questions_ans_options.correct_answer FROM `lt_questions` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id WHERE lt_questions.set_id="'.$form_data['set_id'].'" AND lt_questions.status=1');
		if($query)
		{
			$response['stat'] = true;
			$questions = $query->result_object();
			foreach($questions as $key=>$value)
			{
				$response['datas'][$value->question_id]['question'] = $value->question;
				$response['datas'][$value->question_id]['option'][] = $value->options;
				$response['datas'][$value->question_id]['option_correct'][] = $value->correct_answer;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	
}