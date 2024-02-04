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
								
								
				
				
				//detect completed and pass exam
				
				$qSql="Select count(id) as value from train_fems_user_exam_attempt where user_id='$current_user' and is_complete_exam=1 and result >= $pass_mark ";
				//echo $qSql;
				
				$is_complete_exam=$this->Common_model->get_single_value($qSql);
				
				if($is_complete_exam > 0){
					
					redirect('fems_certification/show_result');
					
				}else{
					
					$failed_exam_infos = $this->db->query('SELECT * FROM `train_fems_user_exam_attempt` WHERE is_complete_exam = "1" and user_id="'.$current_user.'" and result < '.$pass_mark.'');
					
					$data["failed_exam_infos"] = $failed_exam_infos->result_object();
										
					//detect pending exam
					$query = $this->db->query('SELECT * FROM `train_fems_user_exam_attempt` WHERE is_complete_exam = "0" and user_id="'.$current_user.'"');
					$data["pending_exam"] = $query->result_object();
										
					$this->load->view('dashboard_single_col',$data);
				
				}
			
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
				$TotQuesDisplay = $this->config->item('fems_certificate_total_question');
			    $time_per_ques =   $this->config->item('fems_certificate_time_per_ques');
				
				$cond= " where is_active = 1";
				$TotQuesInDB = $this->Common_model->get_total("train_fems_questions ",$cond);
				
				
				$quesArray =  $this->randomDigits($TotQuesDisplay, 1, $TotQuesInDB);
				
				$this->session->set_userdata('question',$quesArray);
				
				$qSql="Select max(attempt_id) as value from train_fems_user_exam_attempt where is_complete_exam = '0' and user_id='$current_user' ";
				$attempt_id=$this->Common_model->get_single_value($qSql);
				$this->session->set_userdata('attempt_id',$attempt_id);
								
				$qSql = " Select count(user_id) as value from train_users_question_answer  where attempt_id = '$attempt_id' and user_id='$current_user' ";
				
				$ques_counter=$this->Common_model->get_single_value($qSql);
				
				
				$this->session->set_userdata('ques_counter',$ques_counter);
				
				$this->session->set_userdata('exam_rem_time', ($time_per_ques * ($TotQuesDisplay - $ques_counter) ) );
								
				redirect('fems_certification/show_questions');
				
			}
		}
		
		
		
	
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
			$time_per_ques =   $this->config->item('fems_certificate_time_per_ques');
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
						
			 $qSql="Select count(id) as value from train_fems_user_exam_attempt where user_id='$current_user' and is_complete_exam=1 and result >  $pass_mark";
			$is_complete_exam=$this->Common_model->get_single_value($qSql);
			
			//echo "is_complete_exam :: ". $is_complete_exam;
			
			if($is_complete_exam > 0){
				
				redirect('fems_certification/show_result');
				
			}else{
				
				$qSql="Select max(attempt_id) as value from train_fems_user_exam_attempt where user_id='$current_user' ";
				
				$attempt_id=$this->Common_model->get_single_value($qSql);
				$attempt_id++;
				
				$cond= " where is_active = 1";
				$TotQuesInDB = $this->Common_model->get_total("train_fems_questions ",$cond);
				
				$quesArray =  $this->randomDigits($TotQuesDisplay, 1, $TotQuesInDB);
				
				$this->session->set_userdata('question',$quesArray);
				$this->session->set_userdata('ques_counter',0);
				$this->session->set_userdata('attempt_id',$attempt_id);
				
				$this->session->set_userdata('exam_rem_time', ($time_per_ques * $TotQuesDisplay));
				
				$this->session->set_userdata('is_started', 1);
				
				$_field_array = array(
					"user_id" => $current_user,
					"attempt_id" => $attempt_id,
					"is_complete_exam" => 0,
					"total_question" => $TotQuesDisplay,
					//"total_question_attempted" => $total_question_no,
					"exam_datetime" => date('Y-m-d'),
					"result" => 0,
					//"log" => $log
				); 
			
			data_inserter('train_fems_user_exam_attempt',$_field_array);
			
			redirect('fems_certification/show_questions');
			  
				
			}
			
	}
			
 }
 
 public function show_questions(){

				
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				
				$data["aside_template"] = "dfr/aside.php";
				$data["content_template"] = "certification/processexam.php";
				
				$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
				
				
				$TotQuesDisplay =  $this->config->item('fems_certificate_total_question');
				$question_counter  =  $this->session->userdata('ques_counter');
				
				$questin_array = $this->session->userdata('question');
				$attempt_id = $this->session->userdata('attempt_id');
				
				$question_id= $questin_array[$question_counter];
				
				if($question_counter < $TotQuesDisplay ){
					
					$qSql ="SELECT * FROM `train_fems_questions` AS fq  where fq.id= $question_id";
					$data['fems_question'] = $this->Common_model->get_query_result_array($qSql);
					
					$qSql ="SELECT * FROM train_fems_answers AS a  where a.question_id= $question_id";
					$data['fems_question_ans'] = $this->Common_model->get_query_result_array($qSql);
					
					$data['attempt_id'] = $attempt_id;
					$data['ques_counter'] = $question_counter;
					
					$this->load->view('dashboard_single_col',$data);
						
				}else{
					
					
					$qSql=" Select  user_id, attempt_id, count(user_id) as tot_answer, sum((select count(id) from train_fems_answers fans where fans.question_id = uans.question_id and  fans.id = uans.answer_id and is_correct=1 )) as tot_corr_ans, (select concat(fname, ' ', lname) as name from signin s where s.id=user_id) as user_name FROM train_users_question_answer uans where user_id = '$current_user' and attempt_id = '$attempt_id' ";
				
					$res = $this->Common_model->get_query_result_array($qSql);
					$tot_corr_ans = $res[0]['tot_corr_ans'];
					$exam_res= round((($tot_corr_ans/$TotQuesDisplay)*100), 2);
					
					$iSql="REPLACE INTO train_fems_user_exam_attempt (user_id,attempt_id, is_complete_exam,total_question,total_question_attempted, result) Values($current_user, $attempt_id, '1',$TotQuesDisplay, $question_counter, $exam_res );";
					$this->db->query($iSql);
					
				
					
					redirect('fems_certification/show_result');
				}

		}
	
	}
	
	
	public function exam_timeout(){
				
				if(check_logged_in())
				{
					$role_id= get_role_id();
					$current_user = get_user_id();
					
					$TotQuesDisplay =  $this->config->item('fems_certificate_total_question');
					$question_counter  =  $this->session->userdata('ques_counter');															
					$attempt_id = $this->session->userdata('attempt_id');
					
					
					$qSql=" Select  user_id, attempt_id, count(user_id) as tot_answer, sum((select count(id) from train_fems_answers fans where fans.question_id = uans.question_id and  fans.id = uans.answer_id and is_correct=1 )) as tot_corr_ans, (select concat(fname, ' ', lname) as name from signin s where s.id=user_id) as user_name FROM train_users_question_answer uans where user_id = '$current_user' and attempt_id = '$attempt_id' ";
				
					$res = $this->Common_model->get_query_result_array($qSql);
					$tot_corr_ans = $res[0]['tot_corr_ans'];
					$exam_res= round((($tot_corr_ans/$TotQuesDisplay)*100), 2);
					
					$iSql="REPLACE INTO train_fems_user_exam_attempt (user_id,attempt_id, is_complete_exam,total_question,total_question_attempted, result) Values($current_user, $attempt_id, '1',$TotQuesDisplay, $question_counter, $exam_res );";
					$this->db->query($iSql);
					
					redirect('fems_certification/show_result');
					
					
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
				
				$question_counter  =  $this->session->userdata('ques_counter');
				
				$attempt_id = $this->session->userdata('attempt_id');
				
				$TotQuesDisplay =  $this->config->item('fems_certificate_total_question');
				$Pass_marks =  $this->config->item('fems_certificate_pass_marks');
				
				$qSql="Select  user_id, attempt_id, count(user_id) as tot_answer, sum((select count(id) from train_fems_answers fans where fans.question_id = uans.question_id and  fans.id = uans.answer_id and is_correct=1 )) as tot_corr_ans, (select concat(fname, ' ', lname) as name from signin s where s.id=user_id) as user_name FROM train_users_question_answer uans where user_id = '$current_user' and attempt_id = '$attempt_id' ";
				
				$data["get_user_result"] = $res = $this->Common_model->get_query_result_array($qSql);
				
				$data["TotQuesDisplay"] = $TotQuesDisplay;
				
				$this->session->unset_userdata('question');
				$this->session->unset_userdata('ques_counter');
				$this->session->unset_userdata('exam_rem_time');
				
				//remove the remtime for javascript
				setcookie("remtime", "", time() - 3600);
				
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
					$rem_time = trim($this->input->post('rem_time'));
					
					$log=get_logs();
					
					if($qid!="" && $ansid!=""){
						
						$_field_array = array(
							"user_id" => $current_user,
							"question_id" => $qid,
							"answer_id" => $ansid,
							"attempt_id" => $attempt_id,
							"log" => $log
						); 
						
						
						$this->session->set_userdata('exam_rem_time',$rem_time);
						data_inserter('train_users_question_answer',$_field_array);
						
						
						
						$question_counter  =  $this->session->userdata('ques_counter');
						$question_counter++;
						$this->session->set_userdata('ques_counter',$question_counter);
						
						
					}
					
				}
		}
	
	
	

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