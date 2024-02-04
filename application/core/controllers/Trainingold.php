<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trainingold extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		//$this->load->helper(array('form', 'url','training_functions'));
		
				
	}
	
//////////////////////////////	
	
		public function index(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				
				$String = "";
				
				
				
				
				$data["aside_template"] = "trainingold/aside.php";
				$data["content_template"] = "trainingold/training.php";
				
				
				if(get_role_dir()=="super" || get_role_dir()=="manager"){
					$qSql="SELECT * from (Select requisition_id FROM trainingold) xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="SELECT * from (Select requisition_id FROM trainingold where trainer_id='$current_user') xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}
				
				
				$data["get_assessment_list"] = array();
				
				if($this->input->get('show')=='Show')
				{
					$batch = $this->input->get('batch');
					
					if($batch!="") $cond .=" where batch='$batch'";
					
					
					if(get_role_dir()=="super" || get_role_dir()=="manager"){
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2) xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid)
								 $cond ";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}else{
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2 and trainer_id='$current_user') xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid)
								 $cond ";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}
				
				}
				
				$data['batch']=$batch;
				$this->load->view('dashboard',$data);
			}
		}
		
		
		
		public function add_assessment(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$data["aside_template"] = "trainingold/aside.php";
				$data["content_template"] = "trainingold/add_assessment.php";
				
				$batch="";
				$cond="";
				
				$batch = $this->input->get('batch');
				
				
				if(get_role_dir()=="super" || get_role_dir()=="manager"){
					$qSql="SELECT * from (Select requisition_id FROM trainingold) xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="SELECT * from (Select requisition_id FROM trainingold where trainer_id='$current_user') xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}
				
				
				$data["get_assessment_list"] = array();
				
				if($this->input->get('show')=='Show')
				{
					
					if($batch!="") $cond .=" where batch='$batch'";
					
					if(get_role_dir()=="super" || get_role_dir()=="manager"){
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2) xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid)
								 $cond ";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}else{
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2 and trainer_id='$current_user') xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid)
								 $cond ";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}
					
				}
				
			////////////////////
				$uid_array = $this->input->post('uid');
				$score_array = $this->input->post('score');
				$assessment_name = $this->input->post('assessment_name');
				$assessment_date = $this->input->post('assessment_date');
				//$added_date = CurrMySqlDate();
				$i=0;
				
				if($this->input->post('submit')=='SAVE'){
					
					foreach ($uid_array as $key => $value){
						
						$train_assess_Arr = array(
							"user_id" => $value,
							"asmnt_name" => $assessment_name,
							"asmnt_date" => mmddyy2mysql($assessment_date),
							"score" => $score_array[$i],
							"added_by" => $current_user,
							"added_date" => CurrMySqlDate()
						); 
						$userid= data_inserter('trainingold_assessment',$train_assess_Arr);
						
						$i++;
						
					}
					
					redirect('trainingold');
				}
			//////////////
				
				$data['batch']=$batch;
				$this->load->view('dashboard',$data);
			}
		}
		
		
		public function certification(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$data["aside_template"] = "trainingold/aside.php";
				$data["content_template"] = "trainingold/certification.php";
				
				$batch="";
				$cond="";
				
				$batch = $this->input->get('batch');
				
				
				if(get_role_dir()=="super" || get_role_dir()=="manager"){
					$qSql="SELECT * from (Select requisition_id FROM trainingold) xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="SELECT * from (Select requisition_id FROM trainingold where trainer_id='$current_user') xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}
				
				
				$data["get_assessment_list"] = array();
				
				if($this->input->get('show')=='Show')
				{
					
					if($batch!="") $cond .=" where batch='$batch'";
					
					if(get_role_dir()=="super" || get_role_dir()=="manager"){
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2) xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid) Left join 
								(select user_id as user_score, asmnt_name, asmnt_date, score from trainingold_assessment) bb On (xx.user_id=bb.user_score)
								 $cond  group by user_id";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}else{
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2 and trainer_id='$current_user') xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid) Left join
								(select user_id as user_score, asmnt_name, asmnt_date, score from trainingold_assessment) bb On (xx.user_id=bb.user_score)
								 $cond  group by user_id ";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}
					
				}
				
			////////////////////
				$uid_array = $this->input->post('uid');
				$certification_arr = $this->input->post('certification');
				$feedback_arr = $this->input->post('feedback');
				$i=0;
				
				if($this->input->post('submit')=='SAVE'){
					
					foreach ($uid_array as $key => $value){	
						$userArr = array(
								"certification" => $certification_arr[$i],
								"feedback" => $feedback_arr[$i]
							); 
						$this->db->where('user_id', $value);
						$this->db->update('trainingold', $userArr);
						
						$i++;
					}
					
					redirect('trainingold/certification');
				}
			/////////////////	
				
				$data['batch']=$batch;
				$this->load->view('dashboard',$data);
			}
		}
		
	/////////////////////////////////////////////////////////////////////
		public function assmnt_score(){
			if(check_logged_in()){
				$assmntUid = $this->input->post('assmntUid');
				$curr_date=date('Y-m-d');
				
				$qSql="Select * FROM trainingold_assessment where user_id='$assmntUid'";
				$oth_brk_details = $this->Common_model->get_query_result_array($qSql);

				
				echo "<table id='default-datatable' data-plugin='DataTable' class='table table-striped skt-table' cellspacing='0' width='100%'>";
					echo "<thead><tr class=''><th>SL</th><th>Assessment Name</th><th>Assessment Date</th><th>Assessment Score</th></tr></thead>";
					
					echo "<tbody>";
					
					$i=1;
					foreach($oth_brk_details as $row){
						
						echo "<tr>";
							echo "<td>".$i++."</td>";
							echo "<td>".$row['asmnt_name']."</td>";
							echo "<td>".$row['asmnt_date']."</td>";
							echo "<td>".$row['score']."</td>";
						echo "</tr>";
								
					}
								 
					echo "</tbody>";
				echo "</table>";
		
			}
		}
	//////////////////////////////////////////////////
		
		
		public function move_production(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				
				$data["aside_template"] = "trainingold/aside.php";
				$data["content_template"] = "trainingold/move_production.php";
				
				$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1 and role_id not in (select id from role where folder='agent') and office_id='$user_office_id' order by name asc ";
				$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
				
				
				if(get_role_dir()=="super" || get_role_dir()=="manager"){
					$qSql="SELECT * from (Select requisition_id FROM trainingold) xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="SELECT * from (Select requisition_id FROM trainingold where trainer_id='$current_user') xx left join (Select id as rid, job_title as batch_code FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) group by batch_code";
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}
				
				
				$data["get_assessment_list"] = array();
				
				if($this->input->get('show')=='Show')
				{
					$batch = $this->input->get('batch');
					
					if($batch!="") $cond .=" where batch='$batch'";
					
					if(get_role_dir()=="super" || get_role_dir()=="manager"){
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2) xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid)
								 $cond ";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}else{
						$qSql="SELECT * from (Select * FROM trainingold where phase_status=2 and trainer_id='$current_user') xx left join 
								(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
								(select id, fusion_id, fname, lname, role_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id) left join
								(select user_id as ip_userid, email_id_off, phone from info_personal) aa on (xx.user_id=aa.ip_userid)
								 $cond ";
						$data["get_assessment_list"] = $this->Common_model->get_query_result_array($qSql);
					}
					
				}
				
			////////////////////
				$uid_array = $this->input->post('uid');
				$move_to = $this->input->post('move_to');
				$remarks = $this->input->post('remarks');
				$moveproduction_array = $this->input->post('move_production');
				$l1_supervisor = $this->input->post('l1_supervisor');
				$currentDate = CurrMySqlDate();
				$i=0;
				
				if($this->input->post('submit')=='Move To'){
					
					foreach ($uid_array as $key => $value){	
						$userArr = array(
								"move_production_by" => $current_user,
								"move_to" => $move_to,
								"remarks" => $remarks,
								"l1_supervisor" => $l1_supervisor,
								"move_production_date" => $currentDate
							); 
						$this->db->where('user_id', $value);
						$this->db->update('trainingold_assessment', $userArr);
					 
						$i++;
						
					/*----Phase History----*/	
						$this->db->query("Update phase_history set end_date='$currentDate' where user_id='$value' and phase_type=2");
						
						$phaseArr = array(
							"user_id" => $value,
							"phase_type" => $move_to,
							"start_date" => $currentDate,
							"remarks" => $remarks,
							"event_by" => $current_user
						);
						$rowid= data_inserter('phase_history',$phaseArr);
					/*--------*/	
						
						if($move_to=='3' || $move_to=='4'){	
							$this->db->query("Update signin set assigned_to='$l1_supervisor', phase='$move_to' where id='$value'");
						}else{
							$this->db->query("Update signin set assigned_to=null, phase='$move_to' where id='$value'");
						}
					
					}
					
					redirect('trainingold/move_production');
				}
			//////////////	
				
				$data['batch']=$batch;
				$this->load->view('dashboard',$data);
			}
		}
	

////////////////////////////////////////////////////////////////////////////	
/*-------------------Manager View------------------------------*/		
		public function training_manager_view(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$data["aside_template"] = "trainingold/aside.php";
				$data["content_template"] = "trainingold/trn_manager_view.php";
				
				$qSql = "SELECT * from (Select trainer_id, (select concat(fname, ' ', lname) as name from signin s where s.id=trainer_id) as trn_name from trainingold group by trainer_id) xx left join (Select id, fusion_id, office_id from signin) yy on (xx.trainer_id=yy.id) where office_id='$user_office_id'";
				$data["assn_trainer"] = $assn_trainer = $this->Common_model->get_query_result_array($qSql);
				
				$trnAttchArray=array();
				//$t = array();
				
				foreach($assn_trainer as $row):
					$trnId=$row['trainer_id'];
					$t = $row['trn_name'];
					
					$QSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin x where x.id=trainer_id) as trn_name FROM trainingold where 
						phase_status=2 and trainer_id='$trnId') xx left join 
						(Select id as rid, job_title as batch FROM dfr_requisition) yy ON (xx.requisition_id=yy.rid) left join
						(select id, fusion_id, fname, lname, role_id, office_id, (select name from role r where r.id=role_id) as rolename from signin) zz ON (xx.user_id=zz.id)";
					
					$query = $this->db->query($QSql);
					$trnAttchArray[$t]=$query->result_array(); 
				endforeach;
				
				$data['trainee_list'] = $trnAttchArray;
				
			///////////	
				$uid_array = $this->input->post('uid');
				$asgn_trainerArr = $this->input->post('trnid');
				$asgn_trainer = $this->input->post('asgn_trainer');
				$trn_batch = $this->input->post('trn_batch');
				$i=0;
				
				if($asgn_trainer!=''){
					$trnAsgn=$asgn_trainer;
				}else{
					$trnAsgn=$asgn_trainerArr[$i];
				}
				
				if($this->input->post('submit')=='Assign Trainer & Batch'){
					foreach ($uid_array as $key => $value){	
						$userArr = array(
								"trainer_id" => $trnAsgn,
								"trn_batch" => $trn_batch
							); 
						$this->db->where('user_id', $value);
						$this->db->update('trainingold', $userArr);
					}
					redirect('trainingold/training_manager_view');
				}
			/////////	
				$this->load->view('dashboard',$data);
			}
		}
/*----------------------*/	
		
		
}
?>	