<?php  defined('BASEPATH') OR exit('No direct script access allowed');


  class Fems_certification extends CI_Controller{
	  
		public function __construct(){
			parent::__construct();
			
			$this->load->model('Profile_model');		
			$this->load->model('Common_model');
		}
	  
	  
		public function index(){
			
			if(check_logged_in())
			{
				$this->session->unset_userdata('start');
				$current_user = get_user_id();
				$data["aside_template"] = "dfr/aside.php";
				$data["content_template"] = "certification/index.php";
				$log=get_logs();
				$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
				$pass_mark = $this->config->item('fems_certificate_pass_marks');
				$data["total_question_no"] = $this->config->item('fems_certificate_total_question');
				$data["pass_mark"] = $this->config->item('fems_certificate_pass_marks');
				$data["per_question_time"] = $this->config->item('fems_certificate_time_per_ques');
				
				//get failed exam infos
				$failed_exam_infos = $this->db->query('SELECT * FROM `train_fems_user_exam_attempt` WHERE is_complete_exam = "1" and user_id="'.$current_user.'" and result < '.$pass_mark.'');
				
				if($failed_exam_infos->num_rows() > 0)
				{
					$data["failed_exam_infos"] = $failed_exam_infos->result_object();
				}
				else{
					/* //detect pending exam
					$query = $this->db->query('SELECT attempt_id FROM `train_fems_user_exam_attempt` WHERE is_complete_exam = "0" and user_id="'.$current_user.'"');
					if($query->num_rows() > 0)
					{
						$rows = $query->result_object();
						$attempt_id = $rows[0]->attempt_id;
						//$pending_exam = 'SELECT * FROM train_fems_questions WHERE train_fems_questions.id NOT IN(SELECT train_users_question_answer.question_id FROM train_users_question_answer WHERE train_users_question_answer.user_id="'.$current_user.'" AND train_users_question_answer.attempt_id="'.$attempt_id.' ORDER BY train_fems_questions.id ASC")';
						//$pending_questions = $this->Common_model->get_query_result_array($pending_exam);
						//print_r($pending_questions);
						//$data["start"] = $this->session->set_userdata('start',$pending_questions[0]['id']);
						//$data["all_questions"] = $pending_questions;
						//$this->load->view('certification/pendingexam',$data);
					}
					else{
						$data["total_question_no"] = $this->config->item('fems_certificate_total_question');
						$data["pass_mark"] = $this->config->item('fems_certificate_pass_marks');
						$data["per_question_time"] = $this->config->item('fems_certificate_time_per_ques');
						
					
						
						$this->load->view('dashboard_single_col',$data);
					} */
					
				}
				
				//detect pending exam
				$query = $this->db->query('SELECT * FROM `train_fems_user_exam_attempt` WHERE is_complete_exam = "0" and user_id="'.$current_user.'"');
				if($query->num_rows() > 0)
				{
					$data["pending_exam"] = $query->result_object();
					$query = $this->db->query('SELECT * FROM `train_fems_user_exam_attempt` WHERE is_complete_exam = "0" and user_id="'.$current_user.'"');
					$data["pending_exam"] = $query->result_object();
				}
				
				$this->load->view('dashboard_single_col',$data);
				
			}
			
		}
		
		public function pendingexam($attempt_id)
		{
			if(check_logged_in())
			{
		
				$current_user = get_user_id();
				$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
				$data["content_template"] = "certification/pendingexam.php";
				$data["user_id"] = $current_user;
				$total_question_no = $this->config->item('fems_certificate_total_question');
				$log=get_logs();
				if(!$this->session->userdata('start'))
				{
					$this->session->set_userdata('start',1);
					$_field_array = array(
							"user_id" => $current_user,
							"attempt_id" => 1,
							"is_complete_exam" => 0,
							"total_question" => $total_question_no,
							"exam_datetime" => date('Y-m-d'),
							"result" => 0,
							"log" => $log
						); 
					data_inserter('train_fems_user_exam_attempt',$_field_array);
				}
				$data["start"] = $this->session->userdata('start');
				
				
				$query = 'SELECT train_fems_questions.*,GROUP_CONCAT(train_fems_answers.id SEPARATOR ",") AS option_id,GROUP_CONCAT(train_fems_answers.answer SEPARATOR ",") AS options, GROUP_CONCAT(train_fems_answers.is_correct SEPARATOR ",") AS correct FROM train_fems_questions  LEFT JOIN train_fems_answers ON train_fems_answers.question_id=train_fems_questions.id WHERE train_fems_questions.id NOT IN(SELECT train_users_question_answer.question_id FROM train_users_question_answer WHERE train_users_question_answer.user_id="'.$current_user.'" AND train_users_question_answer.attempt_id="'.$attempt_id.'" ORDER BY train_fems_questions.id ASC) GROUP BY train_fems_questions.id LIMIT 0,3';
				$data["all_questions"] = $this->Common_model->get_query_result_array($query);
				$this->load->view('dashboard_single_col',$data);
			}
		}
		
		/*
		public function startexam()
		{
			if(check_logged_in())
			{
		
				$current_user = get_user_id();
				$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
				$data["content_template"] = "certification/startexam.php";
				$data["user_id"] = $current_user;
				$total_question_no = $this->config->item('fems_certificate_total_question');
				$log=get_logs();
				if(!$this->session->userdata('start'))
				{
					$this->session->set_userdata('start',1);
					$_field_array = array(
							"user_id" => $current_user,
							"attempt_id" => 1,
							"is_complete_exam" => 0,
							"total_question" => $total_question_no,
							"exam_datetime" => date('Y-m-d'),
							"result" => 0,
							"log" => $log
						); 
					data_inserter('train_fems_user_exam_attempt',$_field_array);
				}
				$data["start"] = $this->session->userdata('start');
				
				
				$query = 'SELECT train_fems_questions.*,GROUP_CONCAT(train_fems_answers.id SEPARATOR ",") AS option_id,GROUP_CONCAT(train_fems_answers.answer SEPARATOR ",") AS options, GROUP_CONCAT(train_fems_answers.is_correct SEPARATOR ",") AS correct FROM train_fems_questions LEFT JOIN train_fems_answers ON train_fems_answers.question_id=train_fems_questions.id GROUP BY train_fems_questions.id LIMIT 0,'.$total_question_no.'';
				$data["all_questions"] = $this->Common_model->get_query_result_array($query);
				$this->load->view('dashboard_single_col',$data);
			}
		}
	*/
	
	public function startexam(){
			
			if(check_logged_in())
			{
				
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$pass_mark = $this->config->item('fems_certificate_pass_marks');
			$TotQuesDisplay =  $this->config->item('fems_certificate_total_question');
			
			$start = 1;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			
			$qSql="Select count(id) as value from train_fems_user_exam_attempt where user_id='$current_user' and is_complete_exam=1 and result >  $pass_mark";
			$is_complete_exam=$this->Common_model->get_single_value($qSql);
			
			//echo "is_complete_exam :: ". $is_complete_exam;
			
			if($is_complete_exam > 0){
				
				redirect('fems_certification/show_result');
				
			}else{
				
				$qSql="Select max(attempt_id) as value from train_fems_user_exam_attempt where user_id='$current_user' ";
				
				$attempt_count=$this->Common_model->get_single_value($qSql);
				$attempt_count++;
				
				$cond= " where is_active = 1";
				$TotQuesInDB = $this->Common_model->get_total("train_fems_questions ",$cond);
				
				$quesArray =  $this->randomDigits($TotQuesDisplay, $start, $TotQuesInDB);
				
				$this->session->set_userdata('question',$quesArray);
				$this->session->set_userdata('ques_counter',0);
				
				
				
				$_field_array = array(
					"user_id" => $current_user,
					"attempt_id" => $attempt_count,
					"is_complete_exam" => 0,
					"total_question" => $total_question_no,
					"exam_datetime" => date('Y-m-d'),
					"result" => 0,
					"log" => $log
				); 
			
			data_inserter('train_fems_user_exam_attempt',$_field_array);
			redirect('fems_certification/show_questions');
				
				
			}
			
	}
			
 }
 
		
	
	public function show_questions(){
			
			if(check_logged_in())
			{
					
				$data["aside_template"] = "dfr/aside.php";
				$data["content_template"] = "certification/processexam.php";
				
				$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
				
				
				$TotQuesDisplay =  $this->config->item('fems_certificate_total_question');
				$question_counter  =  $this->session->userdata('ques_counter');
				
				$questin_array = $this->session->userdata('question');
				
				
				$question_id= $questin_array[$question_counter];
				
				
				if($question_counter < $TotQuesDisplay ){
					
					$qSql ="SELECT * FROM `train_fems_questions` AS fq  where fq.id= $question_id";
					$data['fems_question'] = $this->Common_model->get_query_result_array($qSql);
					
					$qSql ="SELECT * FROM train_fems_answers AS a  where a.question_id= $question_id";
					$data['fems_question_ans'] = $this->Common_model->get_query_result_array($qSql);
					
					$question_counter++;
					$data['ques_counter']= $question_counter;
						
					$this->load->view('dashboard_single_col',$data);
						
						
				}else{
					
					
					redirect('fems_certification/show_result');
				}

		}
	}
		
		
		public function show_result(){
				
				if(check_logged_in())
				{
					
				$role_id= get_role_id();
				$current_user = get_user_id();
				
				$role_dir= get_role_dir();
				
				$user_office_id=get_user_office_id();
				$ses_dept_id=get_dept_id();
			
				$data["aside_template"] = "dfr/aside.php";
				$data["content_template"] = "certification/result.php";
				
				$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
				
				$question_counter  =  $this->session->userdata('counter');
				$TotQuesDisplay =  $this->config->item('fems_certificate_total_question');
				$Pass_marks =  $this->config->item('fems_certificate_pass_marks');
				
			///////////	
				$qSql="SELECT * from
				(Select user_id, COUNT(user_id) as tot_corr_ans, (select concat(fname, ' ', lname) as name from signin s where s.id=user_id) as user_name from
					(select user_id, question_id, answer_id FROM train_users_question_answer where user_id='$current_user') xx INNER JOIN
					(select id as corr_id, question_id as q_id FROM train_fems_answers where is_correct=1) yy ON
					(xx.question_id=yy.q_id) WHERE answer_id=corr_id group by user_id) aa INNER JOIN 
					(select COUNT(answer_id) as tot_answer, user_id as uid from train_users_question_answer group by user_id) bb ON (aa.user_id=bb.uid)";
				
				
				$data["get_user_result"] = $res = $this->Common_model->get_query_result_array($qSql);
				
				$exam_res=88;
				
				
				if($question_counter >= $TotQuesDisplay){
					$iSql="REPLACE INTO train_fems_user_exam_attempt (user_id,is_complete_exam,total_question, result) Values($current_user, '1', $question_counter,$exam_res );";
					$this->db->query($iSql);
				}
				
				
				$this->session->unset_userdata('question');
				$this->session->unset_userdata('counter');
				
					
				$this->load->view('dashboard_single_col',$data);
						
				}		
				
		}
		
		
		
		public function update_answare(){
				
				if(check_logged_in())
				{
					$role_id= get_role_id();
					$current_user = get_user_id();
									
					$qid = trim($this->input->post('qid'));
					$ansid = trim($this->input->post('ansid'));
					$attempt_id = trim($this->input->post('attempt_id'));
					$total_question_avail = trim($this->input->post('total_question_avail'));
					$correct = trim($this->input->post('correct'));
					
					if(!isset($correct_ans))
					{
						$correct_ans = 0;
					}
					$correct_ans = $correct_ans + $correct;
					$log=get_logs();
					
					if($qid!="" && $ansid!=""){
						
						$_field_array = array(
							"user_id" => $current_user,
							"question_id" => $qid,
							"answer_id" => $ansid,
							"attempt_id" => $attempt_id,
							"log" => $log
						); 
						data_inserter('train_users_question_answer',$_field_array);
					
					
						$ans['status']=true;
						$ans['start'] = $this->session->userdata('start');
						if($total_question_avail == $this->session->userdata('start'))
						{
							$this->session->unset_userdata('start');
							$this->db->query('UPDATE train_fems_user_exam_attempt SET is_complete_exam="1", exam_datetime=now() WHERE user_id="'.$current_user.'" and attempt_id="'.$attempt_id.'"');
						}
						else{
							$this->session->set_userdata('start', ($qid+1));
						}
					}else{
						$ans['status']=false;
					}
					echo json_encode($ans);
				}
	
						
						
				
		}
		
		
		
		
	/*	
		public function show_questions(){
				$arr = array();
				$question_counter  =  $this->session->userdata('counter') + 1;
				$this->session->set_userdata('counter',$question_counter);
				
				$questin_array = $this->session->userdata('question');
				
				
				if($question_counter <= count($questin_array)){	
					
					$SQLtxt ="SELECT * FROM `train_fems_questions` AS fq  where fq.id= $questin_array[$question_counter]";
					$colums  = $this->db->query($SQLtxt);
					
						$fields  = $colums->result();
						
							$SQLtxt1 ="SELECT * FROM train_fems_answers AS a  where a.question_id= $questin_array[$question_counter]";
							$colums1  = $this->db->query($SQLtxt1);
								
							$fields1  = $colums1->result();	

								foreach($fields1 as $ans){
									$arr[$fields[0]->id][$fields[0]->question_name][$ans->id]  =  $ans->answer;
								}
								
						echo json_encode($arr);
				}else{
					
					$this->session->unset_userdata('question');
					$this->session->unset_userdata('counter');
					
				}
					 
		}
			  
		*/


		function randomDigits($length , $start , $end){
			$digits;
			$numbers = range($start,$end);
			shuffle($numbers);
			
			for($i = 0; $i < $length; $i++){
				//global $digits;
				
					$digits[] = $numbers[$i];
				
			}
			return $digits;
		}
		
	  
	  
	  
	  
	  
  }




?>