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
			if( get_dept_folder()=="wfm" || get_dept_folder()=="hr" || get_role_dir()=="super"  || get_role_dir()=="manager"|| is_approve_requisition()==true )
			{
				//loading main content template
				$data["content_template"] = "examination/create_exam.php";
			}else{
				//if not above condition then redirect to apply method
				redirect('examination/giveexam', 'refresh');
			}
			if(get_role_dir()=="super" || $is_global_access==1){
				//return all office location list
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				//return all office location list for particular list
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data["content_js"] = "examination/create_exam_js.php";
			
			//get all department list
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_exam_list()
	{
		$form_data = $this->input->post();
		if(get_role_dir()=="super" || $is_global_access==1){
			$query = $this->db->query('SELECT * FROM `lt_examination` WHERE status=1 ORDER BY id DESC');
		}else{
			$query = $this->db->query('SELECT * FROM `lt_examination` WHERE location IN("'.$form_data['office_id'].'") AND status=1 ORDER BY id DESC');
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
			$form_data = $this->input->post();
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			
			$data["is_role_dir"] = get_role_dir();
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$data["content_template"] = "examination/exam_panel.php";
			$data["content_js"] = "examination/exam_panel_js.php";
			
			
			$query_scheduled_exam = $this->db->query('SELECT lt_exam_schedule.*,( getLocalToEst(lt_exam_schedule.exam_start_time,user_id) + INTERVAL lt_exam_schedule.allotted_time MINUTE) AS exam_end_time FROM `lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].'');
			$row = $query_scheduled_exam->row();
			$data["exam_info"] = $row;
			$data["exam_schedule_id"] = $form_data['lt_exam_schedule_id'];
			
			
			$data["questions"] = $this->generate_question($row);
			
			if($data["questions"]['no_of_ques'] == 0)
			{
				$this->db->query('UPDATE `lt_exam_schedule` SET `exam_status`=1 WHERE id='.$row->id.'');
				
				$row = $this->db->query('SELECT module_id FROM lt_exam_schedule WHERE id='.$form_data['exam_id'].'');
				$result = $row->row();
				
				//check if examination left
				$rows = $this->db->query('SELECT COUNT(*) as available_exam FROM lt_exam_schedule WHERE module_id="'.$result->module_id.'" AND exam_status=0');
				$results = $rows->row();
				if($results->available_exam == 0)
				{
					$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="FTD" WHERE requisition_id="'.$result->module_id.'"');
					$this->db->query('UPDATE ijp_requisition_applications SET status="FilterTestCompl" WHERE requisition_id="'.$result->module_id.'" AND user_id="'.$current_user.'"');
				}
				redirect('/examination/giveexam/', 'refresh');
				die();
			}
			$this->load->view('dashboard_single_col',$data);
		}
	}
	
	private function generate_question($row)
	{
		$current_user = get_user_id();
		$query_question = $this->db->query("SELECT lt_questions.*,GROUP_CONCAT(lt_questions_ans_options.text SEPARATOR '###') AS question_option,GROUP_CONCAT(lt_questions_ans_options.id SEPARATOR '###') AS option_id FROM `lt_questions` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id WHERE set_id='".$row->allotted_set_id."' AND lt_questions.id NOT IN(SELECT ques_id FROM `lt_user_exam_answer` WHERE lt_user_exam_answer.exam_schedule_id=".$row->id.") AND (SELECT count(*) FROM `lt_user_exam_answer` WHERE lt_user_exam_answer.exam_schedule_id=".$row->id.") < ".$row->no_of_question." GROUP BY lt_questions.id ORDER BY RAND() LIMIT 1");
			$query_result = $query_question->result_object();
		if($query_question->num_rows() > 0)
		{
			$question = array();
			$question['current_server_time'] = DATE('Y-m-d H:i:s');
			$question['revise'] = 'false';
			$question['no_of_ques'] = $query_question->num_rows();
			foreach($query_result as $key=>$value)
			{
				
				$question['question'] = $value->title;
				$question['option'] = $value->question_option;
				$question['question_id'] = $value->id;
				$question['exam_id'] = $row->id;
				$question['set_id'] = $row->allotted_set_id;
				$question['option_id'] = $value->option_id;
			}
			return $question;
		}
		else
		{
			$query_question = $this->db->query("SELECT lt_questions.*,GROUP_CONCAT(lt_questions_ans_options.text SEPARATOR '###') AS question_option,GROUP_CONCAT(lt_questions_ans_options.id SEPARATOR '###') AS option_id FROM `lt_questions` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id WHERE set_id='".$row->allotted_set_id."' AND lt_questions.id IN(SELECT ques_id FROM `lt_user_exam_answer` WHERE lt_user_exam_answer.exam_schedule_id=".$row->id." AND lt_user_exam_answer.status = 2) GROUP BY lt_questions.id ORDER BY RAND() LIMIT 1");
			$query_result = $query_question->result_object();
			$question = array();
			$question['current_server_time'] = DATE('Y-m-d H:i:s');
			$question['revise'] = 'true';
			$question['no_of_ques'] = $query_question->num_rows();
			foreach($query_result as $key=>$value)
			{
				
				$question['question'] = $value->title;
				$question['option'] = $value->question_option;
				$question['question_id'] = $value->id;
				$question['exam_id'] = $row->id;
				$question['set_id'] = $row->allotted_set_id;
				$question['option_id'] = $value->option_id;
			}
			return $question;
		}
	}
	
	public function submit_ans()
	{
		$form_data = $this->input->post();
		if($form_data['submit_type'] == 'final_ans')
		{
			$query = $this->db->query('INSERT INTO `lt_user_exam_answer`(`exam_schedule_id`, `ques_id`, `ans_id`, `status`, `added_time`) VALUES ("'.$form_data['exam_id'].'","'.$form_data['question_id'].'","'.$form_data['option_id'].'","1",now())');
		}
		else if($form_data['submit_type'] == 'review_ans')
		{
			$query = $this->db->query('INSERT INTO `lt_user_exam_answer`(`exam_schedule_id`, `ques_id`, `ans_id`, `status`, `added_time`) VALUES ("'.$form_data['exam_id'].'","'.$form_data['question_id'].'","'.$form_data['option_id'].'","2",now())');
		}
		else if($form_data['submit_type'] == 'skip_ans')
		{
			$query = $this->db->query('INSERT INTO `lt_user_exam_answer`(`exam_schedule_id`, `ques_id`, `ans_id`, `status`, `added_time`) VALUES ("'.$form_data['exam_id'].'","'.$form_data['question_id'].'","'.$form_data['option_id'].'","3",now())');
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
	
	public function submit_ans_revise()
	{
		$form_data = $this->input->post();
		if($form_data['submit_type'] == 'final_ans')
		{
			$query = $this->db->query('UPDATE lt_user_exam_answer SET ans_id="'.$form_data['option_id'].'", status="1" WHERE exam_schedule_id="'.$form_data['exam_id'].'" AND ques_id="'.$form_data['question_id'].'"');
		}
		else if($form_data['submit_type'] == 'review_ans')
		{
			$query = $this->db->query('UPDATE lt_user_exam_answer SET ans_id="'.$form_data['option_id'].'", status="2" WHERE exam_schedule_id="'.$form_data['exam_id'].'" AND ques_id="'.$form_data['question_id'].'"');
		}
		else if($form_data['submit_type'] == 'skip_ans')
		{
			$query = $this->db->query('UPDATE lt_user_exam_answer SET ans_id="'.$form_data['option_id'].'", status="3" WHERE exam_schedule_id="'.$form_data['exam_id'].'" AND ques_id="'.$form_data['question_id'].'"');
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
		$current_user = get_user_id();
		$query_question = $this->db->query("SELECT lt_questions.*,GROUP_CONCAT(lt_questions_ans_options.text SEPARATOR '###') AS question_option,GROUP_CONCAT(lt_questions_ans_options.id SEPARATOR '###') AS option_id FROM `lt_questions` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id WHERE set_id='".$form_data['set_id']."' AND lt_questions.id NOT IN(SELECT ques_id FROM `lt_user_exam_answer` WHERE lt_user_exam_answer.exam_schedule_id=".$form_data['exam_id'].") AND (SELECT count(*) FROM `lt_user_exam_answer` WHERE lt_user_exam_answer.exam_schedule_id=".$form_data['exam_id'].") < ".$form_data['no_of_ques']." GROUP BY lt_questions.id ORDER BY RAND() LIMIT 1");
			$query_result = $query_question->result_object();
			
		$question = array();
		$question['current_server_time'] = DATE('Y-m-d H:i:s');
		if($query_question)
		{
			if($query_question->num_rows() > 0)
			{
				$response['stat'] = true;
				foreach($query_result as $key=>$value)
				{
					$question['question'] = $value->title;
					$question['option'] = $value->question_option;
					$question['question_id'] = $value->id;
					$question['exam_id'] = $form_data['exam_id'];
					$question['set_id'] = $form_data['set_id'];
					$question['option_id'] = $value->option_id;
				}
				$response['datas'] = $question;
			}
			else
			{
				$response['stat'] = null;
			}
		}
		else
		{
			$response['stat'] = true;
		}
		echo json_encode($response);
	}
	
	public function get_review_question()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		$query_question = $this->db->query("SELECT lt_questions.*,GROUP_CONCAT(lt_questions_ans_options.text SEPARATOR '###') AS question_option,GROUP_CONCAT(lt_questions_ans_options.id SEPARATOR '###') AS option_id FROM `lt_questions` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id WHERE set_id='".$form_data['set_id']."' AND lt_questions.id IN(SELECT ques_id FROM `lt_user_exam_answer` WHERE lt_user_exam_answer.exam_schedule_id=".$form_data['exam_id']." AND lt_user_exam_answer.status = 2) GROUP BY lt_questions.id ORDER BY RAND() LIMIT 1");
			$query_result = $query_question->result_object();
			
		$question = array();
		$question['current_server_time'] = DATE('Y-m-d H:i:s');
		if($query_question)
		{
			if($query_question->num_rows() > 0)
			{
				$response['stat'] = true;
				foreach($query_result as $key=>$value)
				{
					$question['question'] = $value->title;
					$question['option'] = $value->question_option;
					$question['question_id'] = $value->id;
					$question['exam_id'] = $form_data['exam_id'];
					$question['set_id'] = $form_data['set_id'];
					$question['option_id'] = $value->option_id;
				}
				$response['datas'] = $question;
			}
			else
			{
				$response['stat'] = null;
			}
		}
		else
		{
			$response['stat'] = true;
		}
		echo json_encode($response);
	}
	
	public function submit_examination()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `lt_exam_schedule` SET `exam_status`=1 WHERE id='.$form_data['exam_id'].'');
		$row = $this->db->query('SELECT module_id FROM lt_exam_schedule WHERE id='.$form_data['exam_id'].'');
		$result = $row->row();
		
		//check if examination left
		$rows = $this->db->query('SELECT COUNT(*) as available_exam FROM lt_exam_schedule WHERE module_id="'.$result->module_id.'" AND exam_status=0');
		$results = $rows->row();
		if($results->available_exam == 0)
		{
			$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="FTD" WHERE requisition_id="'.$result->module_id.'"');
			$this->db->query('UPDATE ijp_requisition_applications SET status="FilterTestCompl" WHERE requisition_id="'.$result->module_id.'" AND user_id="'.$current_user.'"');
			
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
	
	public function examination_done_page()
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
			
			
			$data["content_template"] = "examination/exam_done.php";
			
			$this->load->view('dashboard_single_col',$data);
		}
	}
}