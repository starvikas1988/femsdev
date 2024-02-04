<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_resign extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('email_model');
		$this->load->model('Common_model');
				
	}
	
	//////////////////////////////////////
	////////Remind Pending Resign////////
	////////////////////////////////////
	public function remind_pending_resign()
	{
		//$query = $this->db->query('SELECT user_id FROM `user_resign` where resign_status="P" and DATEDIFF(released_date,resign_date)/3<DATEDIFF(now(),resign_date)');
		$query = $this->db->query('SELECT user_resign.*,signin.office_id,signin.fname,signin.lname,signin.fusion_id FROM `user_resign` left join signin on signin.id=user_resign.user_id where resign_status="P" and DATEDIFF(released_date,resign_date)/3 < DATEDIFF(now(),resign_date)');
		$rows = $query->result_object();
		if($query->num_rows() <= 0)
		{
			echo 'No Pending Mail To Send.';
		}
						
		foreach($rows as $key=>$value)
		{
			if($this->email_model->remind_resignation($value))
			{
				echo 'Mail Send To '.$value->fname.' '.$value->lname.' - '.$value->fusion_id.'<br>';
			}
			else
			{
				echo 'Unable To Send Mail To '.$value->fname.' '.$value->lname.' - '.$value->fusion_id.'<br>';
			}
		}
	}
	
///////////////////////////////////////////////////////////////////
///////////Approve resignation/////////////////////////////////////
///////////////////////////////////////////////////////////////////
	
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
				$ses_client_ids=get_client_ids();
				$ses_process_ids=get_process_ids();
			
				$data["aside_template"] = "user_resign/aside.php";
				$data["content_template"] = "user_resign/user_resign_list.php";
				
				$data["is_role_dir"]=$is_role_dir;
				
				$qSql="SELECT (select resign_period_day from office_location a where a.abbr=b.office_id) as value FROM signin b where b.status='1' and b.id='$current_user'";
				$data["resign_period_day"]= $this->Common_model->get_single_value($qSql);
				
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$_filterCond="";
			
				if(get_role_dir()!="super" && $is_global_access!=1){
					if($oValue=="") $oValue=$user_office_id;
				}
				
				if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
				
				if($oValue!="ALL" && $oValue!=""){
					if($_filterCond=="") $_filterCond .= " and office_id='".$oValue."'";
					else $_filterCond .= " And office_id='".$oValue."'";
				}
				
				
				if(get_role_dir()=="super" || $is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
			
			
				/// GET NOTICE PERIOD //
				$qSql="SELECT (select resign_period_day from office_location a where a.abbr=s.office_id) as days, c.user_id, s.fname FROM user_resign c 
				       LEFT JOIN signin s ON s.id = c.user_id ";

				$data["notice_period_list"] = $this->Common_model->get_query_result_array($qSql);	
			
			
			//////////Resign Accept list//////////	
				
				if($is_global_access=='1'){
					
					$qSql="Select b.*, (select concat(fname, ' ', lname) as name from signin s where s.id=b.approved_by) as approved_name, resign_date AS resigndate, released_date AS releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, get_client_names(a.id) as client, get_process_names(a.id) as process from signin a, user_resign b where a.id=b.user_id and b.resign_status='P' $_filterCond ";
					
					$data["pending_resign_list"] = $this->Common_model->get_query_result_array($qSql);
				
					
				}else if($is_role_dir=="admin" || get_dept_folder()=="hr"){
					
					$qSql="Select b.*, (select concat(fname, ' ', lname) as name from signin s where s.id=b.approved_by) as approved_name, resign_date AS resigndate, released_date AS releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, a.assigned_to, get_client_names(a.id) as client, get_process_names(a.id) as process from signin a, user_resign b where a.id=b.user_id and  b.resign_status='P' and b.user_id!='$current_user' $_filterCond ";
															
					$data["pending_resign_list"] = $this->Common_model->get_query_result_array($qSql);
					
				}else if($is_role_dir=="manager"){
															
					if(get_dept_folder()=="operations"){
						
						//(is_assign_client(a.id,'$ses_client_ids')=1 AND a.dept_id='$get_dept_id')
						//(is_assign_process(a.id,'$ses_process_ids')=1 AND a.dept_id='$get_dept_id')
						
						$assToCond = " AND (assigned_to='$current_user' OR (is_assign_client(a.id,'$ses_client_ids')=1 AND a.dept_id='$get_dept_id') OR (assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' )))) ";
					}else{
						
						//$assToCond = " AND (a.dept_id='$get_dept_id') ";
						
						$assToCond = " AND (assigned_to='$current_user'  OR (assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' )))) ";
					}
					
					
					//$qSql="Select b.*, (select concat(fname, ' ', lname) as name from signin s where s.id=b.approved_by) as approved_name, resign_date AS resigndate, released_date AS releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, a.assigned_to, a.dept_id, get_client_names(a.id) as client, get_process_names(a.id) as process from signin a, user_resign b where a.id=b.user_id and  b.resign_status='P' and b.user_id!='$current_user' and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) and a.dept_id='$get_dept_id' $_filterCond";
					
					$qSql="Select b.*, (select concat(fname, ' ', lname) as name from signin s where s.id=b.approved_by) as approved_name, resign_date AS resigndate, released_date AS releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, a.assigned_to, a.dept_id, get_client_names(a.id) as client, get_process_names(a.id) as process from signin a, user_resign b where a.id=b.user_id and  b.resign_status='P' and b.user_id!='$current_user'  $assToCond $_filterCond";
					
					//echo $qSql;
					
					$data["pending_resign_list"] = $this->Common_model->get_query_result_array($qSql);
					
					
				}else if($is_role_dir=="tl" || get_role_dir()=="trainer"){
					
					$qSql="Select b.*, (select concat(fname, ' ', lname) as name from signin s where s.id=b.approved_by) as approved_name, resign_date AS resigndate, released_date AS releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, a.assigned_to, get_client_names(a.id) as client, get_process_names(a.id) as process from signin a, user_resign b where a.id=b.user_id and a.assigned_to='$current_user' and resign_status!='C' and b.user_id!='$current_user' $_filterCond ";
						// and  b.resign_status='P'
					$data["pending_resign_list"] = $this->Common_model->get_query_result_array($qSql);	
					
					
				}else{
					redirect('user_resign/resignation');
				}
				
			
			//////////Resign Approved List/////////////		
				
				if( $is_global_access=='1'){
					$qSql="Select b.*, b.id as resign_id, resign_date AS resigndate, released_date AS releaseddate, approved_released_date AS org_releaseddate, accepted_released_date AS acpt_releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, (Select concat(fname, ' ', lname) as name from signin x where x.id=b.approved_by) as approved_name, (Select concat(fname, ' ', lname) from signin s where s.id=b.accepted_by) as accepted_name , get_client_names(a.id) as client, get_process_names(a.id) as process  from signin a, user_resign b where a.id=b.user_id and b.resign_status in ('A','AC') $_filterCond ";
					
					$data["approved_resign_list"] = $this->Common_model->get_query_result_array($qSql);
					
				
				}else if(get_dept_folder()=="hr" ){		/* $is_role_dir=="manager" || $is_role_dir=="admin" ||  */
					
					$qSql="Select b.*, b.id as resign_id, resign_date AS resigndate, released_date AS releaseddate, approved_released_date AS org_releaseddate, accepted_released_date AS acpt_releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, (Select concat(fname, ' ', lname) as name from signin x where x.id=b.approved_by) as approved_name,(Select concat(fname, ' ', lname) from signin s where s.id=b.accepted_by) as accepted_name , get_client_names(a.id) as client, get_process_names(a.id) as process  from signin a, user_resign b where a.id=b.user_id and b.resign_status in ('A','AC') and b.user_id!='$current_user' $_filterCond ";
					
										
					$data["approved_resign_list"] = $this->Common_model->get_query_result_array($qSql);
					
				
				
				 }else if($is_role_dir=="tl" || get_role_dir()=="trainer" || $is_role_dir=="manager" || $is_role_dir=="admin"){
					
					//$qSql="Select b.*, resign_date AS resigndate, released_date AS releaseddate, approved_released_date AS org_releaseddate, accepted_released_date AS acpt_releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, (Select concat(fname, ' ', lname) as name from signin x where x.id=b.approved_by) as approved_name, (Select concat(fname, ' ', lname) from signin s where s.id=b.accepted_by) as accepted_name   from signin a, user_resign b where a.id=b.user_id and b.resign_status in ('A','AC') and a.assigned_to='$current_user' and b.user_id!='$current_user'";
				
					$data["approved_resign_list"] = array(); //$this->Common_model->get_query_result_array($qSql);	 
					
				}else{
					//redirect('user_resign/resignation');
				}
				
			///////////////Released User List////////////////////	
			
			if( $is_global_access=='1' || get_dept_folder()=="hr"){	
				$qSql="Select b.*, resign_date AS resigndate, released_date AS releaseddate, approved_released_date AS org_releaseddate, accepted_released_date AS acpt_releaseddate, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, (Select concat(fname, ' ', lname) as name from signin x where x.id=b.approved_by) as approved_name, (Select concat(fname, ' ', lname) from signin s where s.id=b.accepted_by) as accepted_name   from signin a, user_resign b where a.id=b.user_id and b.resign_status='C'  $_filterCond ";
				
				$data["term_release"] = $this->Common_model->get_query_result_array($qSql);
			}	

			////////////////////////
				$data['oValue']=$oValue;
				$this->load->view('dashboard',$data);
			}
		}
		
		
///////////////////////////////		
		
		public function approved_resign_user(){
			if(check_logged_in()){
				$user_id = $this->input->post('user_id');
				$current_user = get_user_id();
				$approved_remarks = $this->input->post('approved_remarks');
				
				$is_rehire = $this->input->post('is_rehire');
				$is_notice = $this->input->post('is_notice');
				$domain_id_deletion = $this->input->post('domain_id_deletion');
				$email_id_deletion = $this->input->post('email_id_deletion');
				$login_credential_deletion = $this->input->post('login_credential_deletion');
				$phone_login_deletion = $this->input->post('phone_login_deletion');
				
				$approved_current_date = CurrMySqlDate();
				
				if(isIndiaLocation(get_user_office_id())==true){
					$approved_released_date = ddmmyy2mysql($this->input->post('approved_released_date'));
				}else{
					$approved_released_date = mmddyy2mysql($this->input->post('approved_released_date'));
				}
				
				$user_office_id = get_user_office_id();
				$log=get_logs();
				
				/* $qSql="SELECT (select resign_period_day from office_location a where a.abbr=b.office_id) as value FROM signin b where b.status='1' and b.id='$user_id' ";
				$data["resign_period_day"] = $this->Common_model->get_single_value($qSql);
				
				$period = array("id"=>$data["resign_period_day"]);
				echo json_encode($period); */
				
				if($user_id!=""){
					$field_array = array(
						"approved_by" => $current_user,
						"approved_remarks" => $approved_remarks,
						"approved_date" => $approved_current_date,
						"approved_released_date" => $approved_released_date,
						"resign_status" => 'A',
						"is_rehire" => $is_rehire,
						"domain_id_deletion" => $domain_id_deletion,
						"email_id_deletion" => $email_id_deletion,
						"login_credential_deletion" => $login_credential_deletion,
						"phone_login_deletion" => $phone_login_deletion
					);
					$this->db->where('user_id', $user_id);
					$this->db->where('resign_status', 'P');
					$this->db->update('user_resign', $field_array);
					
					
					$ans="Done";
				}else{
					$ans="error";
				}
				
				echo $ans;
					
			}
		}
		
		
		public function decline_resign_user(){
			if(check_logged_in()){
				$user_id = $this->input->post('user_id');
				$current_user = get_user_id();
				$approved_remarks = $this->input->post('approved_remarks');
				$approved_current_date = CurrMySqlDate();
				$log=get_logs();
				
				if($user_id!=""){
					$field_array = array(
						"approved_by" => $current_user,
						"approved_remarks" => $approved_remarks,
						"approved_date" => $approved_current_date,
						"resign_status" => 'R'
					);
					$this->db->where('user_id', $user_id);
					$this->db->where('resign_status', 'P');
					$this->db->update('user_resign', $field_array);
					
					$ans="Done";
				}else{
					$ans="error";
				}
				echo $ans;
				
			}
		}
		

//////////////////Accept & Retain Resign (HR section)-16/08/2019//////////////////////

			public function accepted_resign_user(){
				
				if(check_logged_in()){
					$user_id = $this->input->post('uid');
					$current_user = get_user_id();
					$accepted_remarks = $this->input->post('accepted_remarks');
					$is_rehire = $this->input->post('is_rehire');
					$resign_id = $this->input->post('resign_id');
					
					
					$accepted_date = CurrMySqlDate();
															
					if(isIndiaLocation(get_user_office_id())==true){
						$accepted_released_date = ddmmyy2mysql($this->input->post('accepted_released_date'));
					}else{
						$accepted_released_date = mmddyy2mysql($this->input->post('accepted_released_date'));
					}
				
					$user_office_id = get_user_office_id();
					$log=get_logs();
					
										
					if($user_id!=""){
						$field_array = array(
						    "is_rehire" => $is_rehire,
							"accepted_by" => $current_user,
							"accepted_remarks" => $accepted_remarks,
							"accepted_date" => $accepted_date,
							"accepted_released_date" => $accepted_released_date,
							"resign_status" => 'AC'
						);
						$this->db->where('user_id', $user_id);
						$this->db->where('resign_status', 'A');
						$this->db->update('user_resign', $field_array);
						
						
						$_field_array = array(
						    "resign_id" => $resign_id,
							"user_id" => $user_id,
							"it_helpdesk_status" => 'P',
							"it_security_status" => 'P',
							"payroll_status" => 'P',
							"fnf_status" => 'P',
							"updated" => $accepted_date,
							"date_added" => $accepted_date,
							"log" => $log
						);
						
						
						data_inserter('user_fnf',$_field_array);
												
						$this->email_model->send_email_resignation_hr_accept($user_id,$field_array,$user_office_id);
						
						$this->email_model->send_fnf_email($user_id,"resign",$accepted_released_date);
					
						$ans="Done";
					}else{
						$ans="error";
					}
					
					echo $ans;
						
				}
			}
			
			
			public function reject_resign_user(){
			if(check_logged_in()){
				$user_id = $this->input->post('uid');
				$current_user = get_user_id();
				$accepted_remarks = $this->input->post('accepted_remarks');
				$accepted_date = CurrMySqlDate();
				$log=get_logs();
				
				if($user_id!=""){
					$field_array = array(
						"accepted_by" => $current_user,
						"accepted_remarks" => $accepted_remarks,
						"accepted_date" => $accepted_date,
						"resign_status" => 'R'
					);
					$this->db->where('user_id', $user_id);
					$this->db->where('resign_status', 'A');
					$this->db->update('user_resign', $field_array);
					
					$ans="Done";
				}else{
					$ans="error";
				}
				echo $ans;
				
			}
		}
		
		
/////////////////////////////////////////////		
		public function release_term(){
			
			if(check_logged_in()){
				
				$current_user = get_user_id();
				$uid = $this->input->post('uid');
				$term_remarks = $this->input->post('term_remarks');
				$term_date = $this->input->post('term_date');
				
				
				$log= "Employee Exit # ". get_logs();
				
				$event_by= get_user_id();
				$evt_date=CurrMySqlDate();
				$event_master_id = 7;
				$start_date= $term_date;
				$end_date= $term_date;
				
				if($uid!="" && $term_date !=""){
					
					$qSql = "SELECT is_rehire as value FROM user_resign WHERE user_id = '$uid' AND resign_status = 'AC' order by id desc limit 1";
					
					$is_rehire = $this->Common_model->get_single_value($qSql);
		
			
					$term_date=mmddyy2mysql($term_date);
					
					$this->db->trans_start();
						
						$field_array = array(
							"term_remarks" => $term_remarks,
							"resign_status" => 'C',
							"term_by" => $current_user,
							"term_date" => $term_date,
							"log" => $log
						);
						$this->db->where('user_id', $uid);
						$this->db->where('resign_status', 'AC');
						$this->db->update('user_resign', $field_array);
						
											
						$this->db->where('id', $uid);
						$this->db->update('signin', array('status' =>'0', 'disposition_id' => $event_master_id));
						
						$_field_array = array(
							"user_id" => $uid,
							"event_time" => $evt_date,
							"event_by" => $event_by,
							"event_master_id" => $event_master_id,
							"start_date" => $start_date,
							"end_date" => $end_date,
							"remarks" => $term_remarks,
							"log" => $log
						); 
						
						data_inserter('event_disposition',$_field_array);
						
						$_field_array = array(
									"user_id" => $uid,
									"terms_date" => $term_date,
									"comments" => $term_remarks,
									"t_type" => '9',
									"sub_t_type" => '2',
									"terms_by" => $event_by,
									"is_term_complete" => "Y",
									"evt_date" => $evt_date,
									"lwd" => $term_date,
									"is_rehire"  => $is_rehire,
									"update_date" => $evt_date,
									"update_remarks" => "Employee Exit",
									"update_by" => $event_by
						);
						
						data_inserter('terminate_users',$_field_array);
						
						///
						
						$this->db->trans_complete();
						
						$this->user_model->update_after_term_l1_supervisor($uid);
						
					
					$ans="Done";
				}else{
					$ans="error";
				}
				echo $ans;
			}
		}
		
	
	
//////////////////////////////////////////////////////////
//////////////////// Resignation part ////////////////////
//////////////////////////////////////////////////////////	

	public function resignation(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			$fusion_id=get_user_fusion_id();
			$is_role_dir = get_role_dir();
			$user_office_id = get_user_office_id();
			$get_dept_id = get_dept_id();
			$log=get_logs();
			
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "user_resign/aside.php";
            $data["content_template"] = "user_resign/resignation.php";
			
			$data["is_role_dir"]=$is_role_dir;
			
			if($get_dept_id=='6' && $is_role_dir=='agent'){
				$qSql="SELECT (select resign_period_prod_agent from office_location a where a.abbr=b.office_id) as value FROM signin b where b.status='1' and b.id='$current_user'";
				$data["resign_period_day"]= $this->Common_model->get_single_value($qSql);
			}else{
				$qSql="SELECT (select resign_period_day from office_location a where a.abbr=b.office_id) as value FROM signin b where b.status='1' and b.id='$current_user'";
				$data["resign_period_day"]= $this->Common_model->get_single_value($qSql);
			}
			
			//$qSql="Select email_id, phno from signin where id='$current_user' ";
			$qSql="Select email_id_per as email_id, phone as phno from info_personal where user_id='$current_user'";
			$data["get_email_phno"]= $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="Select * from master_resign_reason where is_active=1";
			$data["get_resign_reason"]= $this->Common_model->get_query_result_array($qSql);
			
			
			
			$qSql="Select b.*, a.id, a.fusion_id, (select concat(fname, ' ', lname) as name from signin x where x.id=b.user_id) as full_name, (select concat(fname, ' ', lname) as name from signin y where y.id=b.approved_by) as approved_name  from signin a, user_resign b where a.id=b.user_id and user_id='$current_user' and b.resign_status!='R' order by resign_date desc ";
			
			//echo $qSql;
			
			$data["get_resign_status"]= $this->Common_model->get_query_result_array($qSql);
					
			$data_array = $this->Common_model->get_query_result_array($qSql);
			
		
			//print_r($data["get_resign_status"]);
			
			if($this->input->post('submit')== 'SAVE' )
			{
				$resign_date = mmddyy2mysql($this->input->post('resign_date'));
				$released_date = mmddyy2mysql($this->input->post('released_date'));
				
				
				$user_reason = $this->input->post('user_reason');
				$user_remarks = $this->input->post('user_remarks');
				$submit_date = date('Y-m-d H:i:s');
				
				$field_array = array(
					"user_id" => $current_user,
					"user_email" => $this->input->post('user_email'),
					"user_phone" => $this->input->post('user_phone'),
					"resign_date" => $resign_date,
					"user_reason" => $user_reason,
					"user_remarks" => $user_remarks,
					"submit_date" => $submit_date,
					"released_date" => $released_date,
					"resign_status" => "P"
				);
				
				$rowid = data_inserter('user_resign',$field_array);
								
				$this->email_model->send_email_resignation($current_user,$field_array,$user_office_id);
				redirect('user_resign/resignation');
			}	
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
}
?>	