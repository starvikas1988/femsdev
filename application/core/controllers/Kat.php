<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kat extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');	
		$this->load->model('Profile_model');
		$this->load->library('excel');
	 }
	 
	 
	public function index()
	{
		if(check_logged_in()){
			
			if(isAccessKatExam()==false ) redirect('kat/agent_exam', 'refresh');
				
			$client_id=get_client_ids();
			$process_id=get_process_ids();
			$data["aside_template"] = "kat/aside.php";
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			$data['current_user'] = get_user_id();
			
			$data["content_template"] = "kat/kat.php";
						
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$_filterCond="";
						
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$client_id = $this->input->get('client_id');
			$process_id = $this->input->get('process_id');
						
			if($is_global_access!=1 && $oValue=="" ) $oValue=$user_office_id;
			
			if( $is_global_access!=1) $_filterCond .="where (location_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',location_id,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= "where (location_id='".$oValue."' OR location_id='ALL')";
				else $_filterCond .= "where (location_id='".$oValue."' OR location_id='ALL' )";
			}
									
			if($client_id!="ALL" && $client_id!=""){
				if($_filterCond=="") $_filterCond .= "where kat.client_id='".$client_id."'";
				else $_filterCond .= "where kat.client_id='".$client_id."'";
			}
			
			if($process_id!="ALL" && $process_id!="" && $process_id!="0"){
				if($_filterCond=="") $_filterCond .= "where kat.process_id='".$process_id."'";
				else $_filterCond .= "where kat.process_id='".$process_id."'";
			}
						
			if(get_role_dir()=="super" || $is_global_access==1 || get_user_fusion_id()=='FKOL000023'){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['department_list'] = $this->Common_model->get_department_list();
			
			//$qSql="Select * FROM kat  Where is_active =1 $_filterCond ORDER BY id ASC";
			
			$qSql="Select *, lt_examination.title as QPaper, client.shname AS client_name,GROUP_CONCAT(process.name SEPARATOR ', ') AS process_name, process.id as p_id,
			kat.id as kid, kat.is_active as katactive, kat.description as katdescription, department.description as department_name  FROM kat 
			LEFT JOIN lt_examination ON lt_examination.id=kat.exam_id 
			LEFT JOIN client ON client.id=kat.client_id 
			LEFT JOIN process ON FIND_IN_SET(process.id,kat.process_id) 
			LEFT JOIN department ON department.id = kat.dept_id
			$_filterCond GROUP BY kat.id ORDER BY kat.id ASC";
			
			//echo $qSql;
			
			$data["get_kat_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * FROM lt_examination  Where type = 'KAT' and status=1";
			$data["exam_list"] = $this->Common_model->get_query_result_array($qSql);
						
			//echo $qSql;
			
			$data['oValue']=$oValue;
			$data['client_id']=$client_id;
			$data['process_id']=$process_id;
			
			$this->load->view('dashboard',$data);
			
		}	
	}


	public function toggle_activate()
	{
		$key = $this->input->get('key');
		$id = $this->input->get('id');
		$this->db->set('is_active',$key);
		$this->db->where('id',$id);
		$this->db->update('kat');

		redirect($_SERVER['HTTP_REFERER']);
	}


	public function edit_kat(){

		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			
			
			$log=get_logs();
			$evt_date=CurrMySqlDate();
			$k_id = $this->input->post('k_id');
						
			$location_id = $this->input->post('location');
			// print_r($_POST); exit;
			$exam_id = trim($this->input->post('examid'));
			$client_id = trim($this->input->post('clientid'));
			$process_id = trim($this->input->post('processid'));
			$open_date = trim($this->input->post('opendate'));
			$close_date = trim($this->input->post('closedate'));
			$description = trim($this->input->post('desc'));
			$department_id = trim($this->input->post('departmentid'));
			$available_to = trim($this->input->post('availableto'));
			$start_time = trim($this->input->post('starttime'));
			$exam_duration = trim($this->input->post('examduration'));
			$exam_type = trim($this->input->post('examtype'));
			
			$selected_location = implode(',', $location_id);
			$field_array = array(
				"location_id" => $selected_location,
				"exam_id" => $exam_id,
				"kat_type" => $exam_type,
				"client_id" => $client_id,
				"process_id" => $process_id,
				"dept_id" => $department_id,
				"available_to" => $available_to,
				"open_date" => $open_date,
				"close_date" => $close_date,
				"description" => $description,
				"exm_duration_min" => $exam_duration,
				"open_time" => $start_time,
				"added_by" => $current_user,
				//"added_time" => $evt_date
			); 
						
			$timeDays = dateDiffCount($open_date, $close_date);
			$timeMinu= $timeDays*24*60;
			
			$exam_status = "2";
			if($exam_type == 'E')
			{ 				
				$exam_status = "0";
				if(!empty($start_time)){ $field_array += [ "open_time" => $start_time ]; $open_date = $open_date ." " .$start_time; }
				if(!empty($exam_duration)){ $field_array += [ "exm_duration_min" => $exam_duration ]; $timeMinu = $exam_duration; }
			}

			$this->db->where('id',$k_id);
			$this->db->update('kat',$field_array);

			redirect($_SERVER['HTTP_REFERER']);
		}

	}

	
	
	public function savekat()
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
						
			$location_id = $this->input->post('location_id');
			$exam_id = trim($this->input->post('exam_id'));
			$client_id = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$open_date = trim($this->input->post('open_date'));
			$close_date = trim($this->input->post('close_date'));
			$description = trim($this->input->post('description'));
			$department_id = trim($this->input->post('department_id'));
			$available_to = trim($this->input->post('available_to'));
			$start_time = trim($this->input->post('start_time'));
			$exam_duration = trim($this->input->post('exam_duration'));
			$exam_type = trim($this->input->post('exam_type'));
			
			$selected_location = implode(',', $location_id);
			$field_array = array(
				"location_id" => $selected_location,
				"exam_id" => $exam_id,
				"kat_type" => $exam_type,
				"client_id" => $client_id,
				"process_id" => $process_id,
				"dept_id" => $department_id,
				"available_to" => $available_to,
				"open_date" => $open_date,
				"close_date" => $close_date,
				"description" => $description,
				"exm_duration_min" => $exam_duration,
				"open_time" => $start_time,
				"added_by" => $current_user,
				//"added_time" => $evt_date
			); 
						
			$timeDays = dateDiffCount($open_date, $close_date);
			$timeMinu= $timeDays*24*60;
			
			$exam_status = "2";
			if($exam_type == 'E')
			{ 				
				$exam_status = "0";
				if(!empty($start_time)){ $field_array += [ "open_time" => $start_time ]; $open_date = $open_date ." " .$start_time; }
				if(!empty($exam_duration)){ $field_array += [ "exm_duration_min" => $exam_duration ]; $timeMinu = $exam_duration; }
			}
			//print_r($field_array);
			
			$qSql = 'SELECT id as value  FROM lt_question_set WHERE exam_id="'.$exam_id.'" and status=1 ORDER BY RAND() LIMIT 1';
			$set_id=$this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT count(id) as value FROM lt_questions where set_id = '$set_id' AND status = 1";
			$total_ques=$this->Common_model->get_single_value($qSql);
			
			if($total_ques>0){
				
				$this->db->trans_start();
				
				$rowid = data_inserter('kat',$field_array);
				
				//echo "<pre>".print_r($_POST, true) ."</pre>";die();
				
				if($selected_location=="ALL" || $selected_location==""){
					$filterLocation="";
					$cond="";
				}
				else {
										
					$filterLocation = implode("','", $location_id);
					$cond=" and s.office_id IN ('$filterLocation') ";
				}
				
				$filterProcess = ""; $filterClient = ""; $filterDepartment = "";
				
				if(!empty($client_id) && $client_id!=0){ $filterClient = " and is_assign_client(s.id,$client_id)=1"; }
				if(!empty($process_id) && $process_id!=0){ $filterProcess = " and is_assign_process(s.id,$process_id)=1"; }
				if(!empty($department_id) && $department_id!='' && $department_id!='0' && $department_id!='ALL'){ $filterDepartment = " and s.dept_id = '$department_id'"; }
			
				// AVAILABLE TO FILTER
				$extraFilter = "";
				if($available_to == "all"){ $extraFilter .= ""; }
				if($available_to == "agent"){ $extraFilter .= " AND r.folder = 'agent'"; }
				if($available_to == "tl"){ $extraFilter .= "  AND r.folder <> 'agent'"; }
								
				$qSql="SELECT s.id,s.fusion_id from signin as s
					   LEFT JOIN role as r ON r.id = s.role_id
				       WHERE status in (1,4) $cond $filterClient $filterProcess $filterDepartment $extraFilter";
				
				$userArray = $this->Common_model->get_query_result_array($qSql);
				
				foreach($userArray as $row){
					
					$user_id=$row['id'];
					
					$qSql = 'REPLACE INTO lt_exam_schedule (module_id,module_type,user_id, exam_id, allotted_time, allotted_set_id, exam_start_time, added_by, added_date, exam_status,no_of_question) VALUES ("'.$rowid.'","KAT","'.$user_id.'","'.$exam_id.'","'.$timeMinu.'","'.$set_id.'","'.$open_date.'","'.$current_user.'",now(),"'.$exam_status.'","'.$total_ques.'")';
					$query = $this->db->query($qSql);
				}
							
				if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
				else $this->db->trans_commit();
			}
			redirect('kat', 'refresh');
			
			
		}
	}
	
	public function start_exam()
	{
		$form_data = $this->input->post();
		foreach($form_data['candiates'] as $key=>$value)
		{
			$query = $this->db->query('UPDATE lt_exam_schedule SET exam_status="2" WHERE module_id="'.$form_data['kat_id'].'" AND user_id="'.$value.'"');
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
	
	
	public function start_exam_checkbox()
	{
		$modal_kat_id = $this->input->post('modal_kat_id');
		$usersList = $this->input->post('userCheckbox');
		foreach($usersList as $token)
		{
			$query = $this->db->query('UPDATE lt_exam_schedule SET exam_status="2" WHERE module_id="'.$modal_kat_id.'" AND user_id="'.$token.'"');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function exam_schedule_user_list()
	{
		$examid = $this->uri->segment(3);
		$sql = "SELECT l.*, concat(s.fname, ' ', s.lname) as fullname, s.fusion_id from lt_exam_schedule as l
		LEFT JOIN signin as s ON s.id = l.user_id
		WHERE l.module_id = '$examid' AND module_type = 'KAT'";
		$query = $this->Common_model->get_query_result_array($sql);
		echo json_encode($query);
	}
	
	
	public function agent_exam()
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
			
			$sqlexam = "Select *, TIMESTAMPDIFF(SECOND,getLocalToEst(open_date,user_id),now()) as is_open, xx.id as schedule_id,get_client_names(user_id) as client_name, get_process_names(user_id) as process_name  from (Select * From lt_exam_schedule Where user_id = '$current_user' and module_type='KAT') xx LEFT JOIN kat ON xx.module_id = kat.id";
			$data['kat_exam_list'] = $queryexam = $this->Common_model->get_query_result_array($sqlexam);
			
			$data["aside_template"] = "kat/aside.php";
			$data["content_template"] = "kat/agent_exam.php";
			$data["content_js"] = "kat/exam_panel_js.php";
			
			$this->load->view('dashboard',$data);
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
						
			$data["content_template"] = "kat/exam_panel.php";
			$data["content_js"] = "kat/exam_panel_js.php";
			
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
				
				redirect('kat/give_exam', 'refresh');
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
	
	
	//===========================================================================================
	//			KAT REPORTS 
	//===========================================================================================
	
	public function report()
	{
		if(check_logged_in())
		{			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();			
			
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"]      = get_role_dir();
			$data['current_user']     = get_user_id();
			
			$client_id=get_client_ids();
			$process_id=get_process_ids();
			
			$data["content_template"] = "kat/kat.php";
			$data["aside_template"] = "kat/aside.php";
			
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$_filterCond="";
						
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$client_id = $this->input->get('client_id');
			$process_id = $this->input->get('process_id');
						
			if($is_global_access!=1 && $oValue=="" ) $oValue=$user_office_id;
			
			if( $is_global_access!=1) $_filterCond .=" and (location_id like '%$user_office_id%' OR '$user_oth_office' like CONCAT('%',location_id,'%') )";	
						
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and (location_id like '%".$oValue."%' OR location_id='ALL')";
				else $_filterCond .= " and (location_id like '%".$oValue."%' OR location_id='ALL' )";
			}
			
			if($client_id!="ALL" && $client_id!=""){
				if($_filterCond=="") $_filterCond .= " and kat.client_id='".$client_id."'";
				else $_filterCond .= " and kat.client_id='".$client_id."'";
			}			
			if($process_id!="ALL" && $process_id!="" && $process_id!="0"){
				if($_filterCond=="") $_filterCond .= " and kat.process_id='".$process_id."'";
				else $_filterCond .= " and kat.process_id='".$process_id."'";
			}						
			if(get_role_dir()=="super" || $is_global_access==1 || get_user_fusion_id()=='FKOL000023'){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}			
			$data['department_list'] = $this->Common_model->get_department_list();
			
			
			$sqlkat = "Select *, lt_examination.title as QPaper, client.shname AS client_name,GROUP_CONCAT(process.name SEPARATOR ', ') AS process_name, 
			kat.id as kid, kat.description as katdescription, department.description as department_name  FROM kat 
			LEFT JOIN lt_examination ON lt_examination.id=kat.exam_id 
			LEFT JOIN client ON client.id=kat.client_id 
			LEFT JOIN process ON FIND_IN_SET(process.id,kat.process_id) 
			LEFT JOIN department ON department.id = kat.dept_id
			Where kat.is_active =1 $_filterCond GROUP BY kat.id ORDER BY kat.id ASC";
			$data['kat_exam_list'] = $queryexam = $this->Common_model->get_query_result_array($sqlkat);
			
			$data["aside_template"] = "kat/aside.php";
			$data["content_template"] = "kat/kat_reports.php";
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_kat_reports(){
		if(check_logged_in()){
			if($_GET['downloadKat'] == "Download" &&  $_GET['kat_exam']!=""){ 

				$SQLtxt ="SELECT allotted_set_id, exam_status, kat.* FROM lt_examination 
				          INNER JOIN lt_exam_schedule ON lt_examination.id = lt_exam_schedule.exam_id 
				          INNER JOIN kat ON kat.exam_id = lt_exam_schedule.exam_id 
						  WHERE kat.id=". $_GET['kat_exam'] ." GROUP BY allotted_set_id";
				$data_fields = $this->db->query($SQLtxt);
				$data['set_count'] = $data_fields->result_array();
				
				$desc = ""; $avail = "list";
				if(!empty($data['set_count'][0]['description'])){ $desc = $data['set_count'][0]['description']; }
				if(!empty($data['set_count'][0]['available_to'])){ $avail = $data['set_count'][0]['description'] ."-".$data['set_count'][0]['available_to']; }
										
				$this->generate_kat_report_xls( $_GET['kat_exam'],$avail,$data['set_count'], $desc);
				
			} else {
				redirect('kat/kat_reports','refresh');
			}
		}
	}
	
	
	public function generate_kat_report_xls($exam_id, $heading, $set_count, $desc = "")
	{
		if(check_logged_in()){
			$this->objPHPExcel = new PHPExcel();
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Exam Result Report");
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			
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
									 'rgb' => "fde3df"
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
				'name'  => 'Cambria',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			));
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "KAT EXAM - ".$desc);
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
							
							$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,'Score Percentage');
												   
					   $client_id = $no_set['client_id'];
					   $process_id = $no_set['process_id'];
					   $department_id = $no_set['dept_id'];
					   $available_to = $no_set['available_to'];
					   
					   $extraFilter = "";						
						if(!empty($client_id) && $client_id!=0){ $extraFilter .= " and is_assign_client(s.id,$client_id)=1"; }
						if(!empty($process_id) && $process_id!=0){ $extraFilter .= " and is_assign_process(s.id,$process_id)=1"; }
						if(!empty($department_id) && $department_id!='' && $department_id!='0' && $department_id!='ALL'){ 
							$extraFilter .= " and s.dept_id = '$department_id'"; 
						}
						
						
					   $location_id = $no_set['location_id'];
					   $filter_location_ar = explode(',', $location_id);
					   $filter_location = implode("','", $filter_location_ar);
					   if(!empty($location_id)){ $extraFilter .= " and s.office_id IN ('$filter_location')"; }
					   
						
						// AVAILABLE TO FILTER
						if($available_to == "all"){ $extraFilter .= ""; }
						if($available_to == "agent"){ $extraFilter .= " AND r.folder = 'agent'"; }
						if($available_to == "tl"){ $extraFilter .= "  AND r.folder <> 'agent'"; }
					   
					   
					   $SQLtxt="Select fusion_id,fname,lname,(Select CONCAT(fname,' ' ,lname) from signin where signin.id=s.assigned_to) as asign_tl, user_id,set_id,x.exam_id,exam_schedule_id, ua.ques_id, no_of_question, ans_id, QA_O.text AS User_answer, QA_O.correct_answer from lt_exam_schedule x 
						INNER JOIN lt_questions y on y.set_id = x.allotted_set_id
						INNER JOIN lt_user_exam_answer ua on ua.exam_schedule_id = x.id and ua.ques_id = y.id
						INNER JOIN kat k ON k.exam_id = x.exam_id 
						LEFT JOIN lt_questions_ans_options QA_O ON QA_O.id=ua.ans_id
						LEFT JOIN signin s on s.id = x.user_id
						LEFT JOIN role r on r.id = s.role_id
						where k.id =". $exam_id ." and allotted_set_id = ". $no_set['allotted_set_id'] ." $extraFilter
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
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row, sprintf('%0.2f', (($correct_answer / $no_of_question) * 100)));
									
									
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
            header('Content-Disposition: attachment;filename="kat_'.$heading.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
            	
		}
	}
	
	
	
	
}

?>