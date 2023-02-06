<?php 

 class Qa_biomet extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
    }
    
    public function index(){
		
		if(check_logged_in())
		{			
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_biomet/qa_biomet_call_feedback.php";
			$data["content_js"] = "qa_biomet_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,102)  and is_assign_process (id,279) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}
			

		//////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_biomet_call_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["biomet_call"] = $this->Common_model->get_query_result_array($qSql);
		///////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_biomet_chat_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["biomet_chat"] = $this->Common_model->get_query_result_array($qSql);
		///////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_biomet_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["biomet_email"] = $this->Common_model->get_query_result_array($qSql);
		///////////////
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
    }
    

    	
	public function add_edit_biomet_call($call_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_biomet/add_edit_biomet_call.php";
			$data["content_js"] = "qa_biomet_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,102) and is_assign_process (id,279) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['call_id']=$call_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_biomet_call_feedback where id='$call_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["biomet_call"] = $this->Common_model->get_query_row_array($qSql);

		
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"mission" => $this->input->post('mission'),
					"recording_id" => $this->input->post('recording_id'),
					"week" => $this->input->post('week'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"appropiate_greeting" => $this->input->post('appropiate_greeting'),
					"clear_opening" => $this->input->post('clear_opening'),
					"voice_modulation" => $this->input->post('voice_modulation'),
					"appropiate_pace" => $this->input->post('appropiate_pace'),
					"professional_courteous" => $this->input->post('professional_courteous'),
					"call_empathy" => $this->input->post('call_empathy'),
					"adjust_customer_language" => $this->input->post('adjust_customer_language'),
					"simple_word_used" => $this->input->post('simple_word_used'),
					"active_listening" => $this->input->post('active_listening'),
					"paraprasing" => $this->input->post('paraprasing'),
					"avoid_fumbling" => $this->input->post('avoid_fumbling'),
					"appropiate_probing" => $this->input->post('appropiate_probing'),
					"escalate_issue" => $this->input->post('escalate_issue'),
					"call_control" => $this->input->post('call_control'),
					"query_resolved" => $this->input->post('query_resolved'),
					"offers_VAS" => $this->input->post('offers_VAS'),
					"awareness_created" => $this->input->post('awareness_created'),
					"correct_disposition" => $this->input->post('correct_disposition'),
					"update_ASM" => $this->input->post('update_ASM'),
					"capture_query" => $this->input->post('capture_query'),
					"hold_required" => $this->input->post('hold_required'),
					"hold_guidelines" => $this->input->post('hold_guidelines'),
					"dead_air_8sec" => $this->input->post('dead_air_8sec'),
					"further_assistance" => $this->input->post('further_assistance'),
					"CSAT_experience_feedback" => $this->input->post('CSAT_experience_feedback'),
					"call_adherence" => $this->input->post('call_adherence'),
					// "used_applicant" => $this->input->post('used_applicant'),
					"delayed_opening" => $this->input->post('delayed_opening'),
					"rude_on_call" => $this->input->post('rude_on_call'),
					"incomplete_information" => $this->input->post('incomplete_information'),
					"complaint_avoidance" => $this->input->post('complaint_avoidance'),
					"reason_for_fatal" => $this->input->post('reason_for_fatal'),
					"improvement_area" => $this->input->post('improvement_area'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				
				if($call_id==0){
					
					// $a = $this->biomet_upload_files($_FILES['attach_file'],$path='./qa_files/qa_biomet/call/');
					// $field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_biomet_call_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_biomet_call_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_biomet_call_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $call_id);
					$this->db->update('qa_biomet_call_feedback',$field_array);
				//////////
					if(get_login_type()=="client"){
						$field_array1 = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$field_array1 = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $call_id);
					$this->db->update('qa_biomet_call_feedback',$field_array1);
					
				}
				redirect('Qa_biomet');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
// chat

public function add_edit_biomet_chat($chat_id){
	if(check_logged_in())
	{
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_biomet/add_edit_biomet_chat.php";
		$data["content_js"] = "qa_biomet_js.php";
		
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,102)  and is_assign_process (id,279) and status=1  order by name";
		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
		$data['chat_id']=$chat_id;
		
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_biomet_chat_feedback where id='$chat_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
		$data["biomet_chat"] = $this->Common_model->get_query_row_array($qSql);
		
		$curDateTime=CurrMySqlDate();
		$a = array();
		
		if($this->input->post('agent_id')){
			$field_array=array(
				"agent_id" => $this->input->post('agent_id'),
				"tl_id" => $this->input->post('tl_id'),
				"call_date" => mmddyy2mysql($this->input->post('call_date')),
				"call_duration" => $this->input->post('call_duration'),
				"mission" => $this->input->post('mission'),
				"recording_id" => $this->input->post('recording_id'),
				"week" => $this->input->post('week'),
				"audit_type" => $this->input->post('audit_type'),
				"auditor_type" => $this->input->post('auditor_type'),
				"voc" => $this->input->post('voc'),
				"overall_score" => $this->input->post('overall_score'),
				"earned_score" => $this->input->post('earned_score'),
				"possible_score" => $this->input->post('possible_score'),
				"appropiate_greeting" => $this->input->post('appropiate_greeting'),
				"response_time" => $this->input->post('response_time'),
				"FCR_achieved" => $this->input->post('FCR_achieved'),
				"understand_issue" => $this->input->post('understand_issue'),
				"attentiveness_display" => $this->input->post('attentiveness_display'),
				"paraphrasing" => $this->input->post('paraphrasing'),
				"use_available_resource" => $this->input->post('use_available_resource'),
				"appropiate_probing" => $this->input->post('appropiate_probing'),
				"VAS_options" => $this->input->post('VAS_options'),
				"awareness_created" => $this->input->post('awareness_created'),
				"correct_disposition" => $this->input->post('correct_disposition'),
				"update_ASM" => $this->input->post('update_ASM'),
				"capture_query" => $this->input->post('capture_query'),
				"hold_required" => $this->input->post('hold_required'),
				"hold_guidelines" => $this->input->post('hold_guidelines'),
				"formatting" => $this->input->post('formatting'),
				"avoid_negative_statement" => $this->input->post('avoid_negative_statement'),
				"procedure_guide_step" => $this->input->post('procedure_guide_step'),
				"avoid_slangs" => $this->input->post('avoid_slangs'),
				"correct_grammar_use" => $this->input->post('correct_grammar_use'),
				"further_assistance" => $this->input->post('further_assistance'),
				"chat_adherence" => $this->input->post('chat_adherence'),
				// "used_applicant" => $this->input->post('used_applicant'),
				"delayed_opening" => $this->input->post('delayed_opening'),
				"rude_on_chat" => $this->input->post('rude_on_chat'),
				"inacurate_information" => $this->input->post('inacurate_information'),
				"complaint_avoidance" => $this->input->post('complaint_avoidance'),
				"reason_for_fatal" => $this->input->post('reason_for_fatal'),
				"improvement_area" => $this->input->post('improvement_area'),
				"call_summary" => $this->input->post('call_summary'),
				"feedback" => $this->input->post('feedback'),
				"entry_date" => $curDateTime
			);
			
			if($chat_id==0){
				
				// $a = $this->biomet_upload_files($_FILES['attach_file'],$path='./qa_files/qa_biomet/chat/');
				// $field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_biomet_chat_feedback',$field_array);
				/////////
				$field_array2 = array(
					"audit_date" => CurrDate(),
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$this->db->where('id', $rowid);
				$this->db->update('qa_biomet_chat_feedback',$field_array2);
				///////////
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_biomet_chat_feedback',$field_array1);
				
			}else{
				
				$this->db->where('id', $chat_id);
				$this->db->update('qa_biomet_chat_feedback',$field_array);
			//////////
				if(get_login_type()=="client"){
					$field_array1 = array(
						"client_rvw_by" => $current_user,
						"client_rvw_note" => $this->input->post('note'),
						"client_rvw_date" => $curDateTime
					);
				}else{
					$field_array1 = array(
						"mgnt_rvw_by" => $current_user,
						"mgnt_rvw_note" => $this->input->post('note'),
						"mgnt_rvw_date" => $curDateTime
					);
				}
				$this->db->where('id', $chat_id);
				$this->db->update('qa_biomet_chat_feedback',$field_array1);
				
			}
			redirect('Qa_biomet');
		}
		$data["array"] = $a;
		$this->load->view("dashboard",$data);
	}
}

// email

public function add_edit_biomet_email($email_id){
	if(check_logged_in())
	{
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_biomet/add_edit_biomet_email.php";
		$data["content_js"] = "qa_biomet_js.php";
		
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,102)  and is_assign_process (id,279) and status=1  order by name";
		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
		$data['email_id']=$email_id;
		
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_biomet_email_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
		$data["biomet_email"] = $this->Common_model->get_query_row_array($qSql);
		
		$curDateTime=CurrMySqlDate();
		$a = array();
		
		if($this->input->post('agent_id')){
			$field_array=array(
				"agent_id" => $this->input->post('agent_id'),
				"tl_id" => $this->input->post('tl_id'),
				"call_date" => mmddyy2mysql($this->input->post('call_date')),
				"call_duration" => $this->input->post('call_duration'),
				"mission" => $this->input->post('mission'),
				"recording_id" => $this->input->post('recording_id'),
				"week" => $this->input->post('week'),
				"audit_type" => $this->input->post('audit_type'),
				"auditor_type" => $this->input->post('auditor_type'),
				"voc" => $this->input->post('voc'),
				"overall_score" => $this->input->post('overall_score'),
				"earned_score" => $this->input->post('earned_score'),
				"possible_score" => $this->input->post('possible_score'),
				"use_paragraph_idea" => $this->input->post('use_paragraph_idea'),
				"use_bullet_point" => $this->input->post('use_bullet_point'),
				"adhered_word_limit" => $this->input->post('adhered_word_limit'),
				"template_adherence" => $this->input->post('template_adherence'),
				"interim_responce" => $this->input->post('interim_responce'),
				"FCR_achieved" => $this->input->post('FCR_achieved'),
				"understand_issue" => $this->input->post('understand_issue'),
				"attentiveness_display" => $this->input->post('attentiveness_display'),
				"use_available_resource" => $this->input->post('use_available_resource'),
				"standardized_subject" => $this->input->post('standardized_subject'),
				"VAS_option" => $this->input->post('VAS_option'),
				"awarreness_created" => $this->input->post('awarreness_created'),
				"correct_disposition" => $this->input->post('correct_disposition'),
				"update_ASM" => $this->input->post('update_ASM'),
				"capture_query" => $this->input->post('capture_query'),
				"formatting" => $this->input->post('formatting'),
				"show_customer_feel_value" => $this->input->post('show_customer_feel_value'),
				"procedure_guide_step" => $this->input->post('procedure_guide_step'),
				"avoid_slangs" => $this->input->post('avoid_slangs'),
				"correct_grammar_use" => $this->input->post('correct_grammar_use'),
				"correct_closing" => $this->input->post('correct_closing'),
				"further_assistance" => $this->input->post('further_assistance'),
				// "used_applicant" => $this->input->post('used_applicant'),
				"rude_on_email" => $this->input->post('rude_on_email'),
				"inacurate_information" => $this->input->post('inacurate_information'),
				"email_hygiene" => $this->input->post('email_hygiene'),
				"complaint_avoidance" => $this->input->post('complaint_avoidance'),
				
				"reason_for_fatal" => $this->input->post('reason_for_fatal'),
				"improvement_area" => $this->input->post('improvement_area'),
				"call_summary" => $this->input->post('call_summary'),
				"feedback" => $this->input->post('feedback'),
				"entry_date" => $curDateTime
			);
			
			if($email_id==0){
				
				// $a = $this->biomet_upload_files($_FILES['attach_file'],$path='./qa_files/qa_biomet/email/');
				// $field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_biomet_email_feedback',$field_array);
				/////////
				$field_array2 = array(
					"audit_date" => CurrDate(),
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$this->db->where('id', $rowid);
				$this->db->update('qa_biomet_email_feedback',$field_array2);
				///////////
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_biomet_email_feedback',$field_array1);
				
			}else{
				
				$this->db->where('id', $email_id);
				$this->db->update('qa_biomet_email_feedback',$field_array);
			//////////
				if(get_login_type()=="client"){
					$field_array1 = array(
						"client_rvw_by" => $current_user,
						"client_rvw_note" => $this->input->post('note'),
						"client_rvw_date" => $curDateTime
					);
				}else{
					$field_array1 = array(
						"mgnt_rvw_by" => $current_user,
						"mgnt_rvw_note" => $this->input->post('note'),
						"mgnt_rvw_date" => $curDateTime
					);
				}
				$this->db->where('id', $email_id);
				$this->db->update('qa_biomet_email_feedback',$field_array1);
				
			}
			redirect('Qa_biomet');
		}
		$data["array"] = $a;
		$this->load->view("dashboard",$data);
	}
}

	public function agent_biomet_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_biomet/agent_biomet_feedback.php";
			$data["content_js"] = "qa_biomet_js.php";
			$data["agentUrl"] = "qa_biomet/agent_biomet_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			$campaign = $this->input->get('campaign');
			
			if($campaign!=''){
				
				$qSql="Select count(id) as value from qa_biomet_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_biomet_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate!="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_biomet_".$campaign."_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_biomet_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_biomet/agent_biomet_rvw.php";
			$data["content_js"] = "qa_biomet_js.php";
			$data["agentUrl"] = "qa_biomet/agent_biomet_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_biomet_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["agent_biomet"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data["campaign"]=$campaign;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_biomet_'.$campaign.'_feedback',$field_array1);
					
				redirect('Qa_biomet/agent_biomet_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	////////////////////////////////////////////// Biomet Report //////////////////////////////////////////////////

	public function qa_biomet_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_biomet/qa_biomet_report.php";
			$data["content_js"] = "qa_biomet_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$campaign = $this->input->get('campaign');
			
			$data["qa_biomet_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
		
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_biomet_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_biomet_list"] = $fullAray;
				$this->create_qa_biomet_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_biomet/download_qa_biomet_CSV/".$campaign;
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['campaign']=$campaign;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_biomet_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA biomet ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_biomet_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=='chat'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Chat Date", "AHT", "Mission", "Recording ID", "Week", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Opening - a)Appropriate greeting as per script", "Technical aspects - a)Response Time", "Technical aspects - b)FCR achieved", "Technical aspects - c)Understand the issue of the applicant", "Technical aspects - d)Attentiveness displayed", "Technical aspects - e)Paraphrasing", "Technical aspects - f)Used all the available resources for providing resolution", "Technical aspects - g)Appropriate Probing", "Additions - a)Offers VAS options wherever applicable", "Additions - b)Awareness created with regards to VFS", "Documentation - a)Correct dispostion", "Documentation - b)Correct disposition sub-type","Documentation - c)Captured response query precisely", "Hold Protocol - a)Was Hold Required", "Hold Protocol - b)Hold Guidelines followed", "Communication - a)Formatting", "Communication - b)Avoid Negative statements", "Communication - c)Telling the customer what to do next", "Communication - d)Avoid Slangs & Jargons", "Communication - e)Correct and accurate grammar usage", "Communication - f)Further assistance", "Chat Closing - a)Adherence to chat closing script","used_applicant", "Fatal Parameter - a)Delayed opening", "Fatal Parameter - b)Rude on chat",  "Fatal Parameter - c)Incomplete Information", "Fatal Parameter - d)Complaint Avoidance", "Reason For Fatal Error", "Improvement Area", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='call'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Chat Date", "AHT", "Mission", "Recording ID", "Week", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Opening - a)Appropriate greeting as per script", "Opening - b)Clear and Crisp opening", "Communication - a)Voice modulation", "Communication - b)Appropriate pace", "Communication - c)Courteous and professional", "Communication - d)Empathy on call", "Communication - e)Adjusted to customer language", "Communication - f)No jargons simple words used", "Communication - g)Active listening", "Communication - h)Paraprashing", "Communication - i)Grammatically correct sentences", "Technical aspects - a)Appropriate Probing", "Technical aspects - b)Escalate the issue wherever required", "Technical aspects - c)Call control", "Technical aspects - d)Query resolved on call FTR", "Additons - a)Offers VAS options wherever applicable", "Additons - b. Awareness created with regards to VFS", "Documentation - a)Correct dispostion", "Documentation - b)Correct disposition sub-type","Documentation - c)Captured response query precisely", "Hold Protocol - a)Was Hold Required", "Hold Protocol - b)Hold Guidelines followed", "Hold Protocol - c)Dead Air <= 8 seconds", "Call Closing - a)Further assistance", "Call Closing - b)Attempt to take feedback on experience CSAT", "Call Closing - c)Adherence to call closing script", "Fatal Parameter - a)Delayed opening", "Fatal Parameter - b)Rude on chat", "Fatal Parameter - c)Incomplete/Inaccurate Information shared","used_applicant", "Fatal Parameter - d)Complaint Avoidance", "Reason For Fatal Error", "Improvement Area", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='email'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Chat Date", "AHT", "Mission", "Recording ID", "Week", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Content Writing - a)a. Used one idea per paragraph", "Content Writing - b)Used bullet points where appropriate", "Content Writing - c)Adhered word limit per sentence", "Content Writing - d)Template Adherence where applicable", "Accuracy follow up - a)Interim response provided", "Accuracy follow up - b)FCR achieved", "Accuracy follow up - c)Understand the issue of the applicant", "Accuracy follow up - d)Attentiveness displayed", "Accuracy follow up - e)Used all the available resources for providing resolution", "Accuracy follow up - f)Standardized subject line on trail mails", "Additions - a)Offers VAS options wherever applicable", "Additions - b)Awareness created with regards to VFS website", "Documentation - a)Correct dispostion", "Documentation - b)Correct disposition sub-type","Documentation - c)Captured response query precisely", "Composition - a)Formatting", "Composition - b)Shows respect and makes the customer feel valued", "Composition - c)Telling the customer what to do next", "Composition - d)Avoid Slangs & Jargons", "Composition - e)Correct and accurate grammar usage", "Composition - f)Correct closing", "Composition - g)Further assistance", "Fatal Parameter - a)Rude or unprofessional on email","used_applicant", "Fatal Parameter - b)Incomplete", "Fatal Parameter - c)Email hygiene", "Fatal Parameter - d)Complaint Avoidance", "Reason For Fatal Error", "Improvement Area", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='chat'){
			
			foreach($rr as $user){	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
			
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['mission'].'",';
				$row .= '"'.$user['recording_id'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['appropiate_greeting'].'",';
				$row .= '"'.$user['response_time'].'",';
				$row .= '"'.$user['FCR_achieved'].'",';
				$row .= '"'.$user['understand_issue'].'",';
				$row .= '"'.$user['attentiveness_display'].'",';
				$row .= '"'.$user['paraphrasing'].'",';
				$row .= '"'.$user['use_available_resource'].'",';
				$row .= '"'.$user['appropiate_probing'].'",';
				$row .= '"'.$user['VAS_options'].'",';
				$row .= '"'.$user['awareness_created'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'.$user['update_ASM'].'",';
				$row .= '"'.$user['capture_query'].'",';
				$row .= '"'.$user['hold_required'].'",';
				$row .= '"'.$user['hold_guidelines'].'",';
				$row .= '"'.$user['formatting'].'",';
				$row .= '"'.$user['avoid_negative_statement'].'",';
				$row .= '"'.$user['procedure_guide_step'].'",';
				$row .= '"'.$user['avoid_slangs'].'",';
				$row .= '"'.$user['correct_grammar_use'].'",';
				$row .= '"'.$user['further_assistance'].'",';
				$row .= '"'.$user['chat_adherence'].'",';
				
				$row .= '"'.$user['delayed_opening'].'",';
				$row .= '"'.$user['rude_on_chat'].'",';
				$row .= '"'.$user['inacurate_information'].'",';
				$row .= '"'.$user['complaint_avoidance'].'",';
				
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_for_fatal'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['improvement_area'])).'",';
				
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_date'].'",';
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';	
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}if($campaign=='call'){
			
			foreach($rr as $user){	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
			
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['mission'].'",';
				$row .= '"'.$user['recording_id'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['appropiate_greeting'].'",';
				$row .= '"'.$user['clear_opening'].'",';
				$row .= '"'.$user['voice_modulation'].'",';
				$row .= '"'.$user['appropiate_pace'].'",';
				$row .= '"'.$user['professional_courteous'].'",';
				$row .= '"'.$user['call_empathy'].'",';
				$row .= '"'.$user['adjust_customer_language'].'",';
				$row .= '"'.$user['simple_word_used'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['paraprasing'].'",';
				$row .= '"'.$user['avoid_fumbling'].'",';
				$row .= '"'.$user['appropiate_probing'].'",';
				$row .= '"'.$user['escalate_issue'].'",';
				$row .= '"'.$user['call_control'].'",';
				$row .= '"'.$user['query_resolved'].'",';
				$row .= '"'.$user['offers_VAS'].'",';
				$row .= '"'.$user['awareness_created'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'.$user['update_ASM'].'",';
				$row .= '"'.$user['capture_query'].'",';
				$row .= '"'.$user['hold_required'].'",';
				$row .= '"'.$user['hold_guidelines'].'",';
				$row .= '"'.$user['dead_air_8sec'].'",';
				$row .= '"'.$user['further_assistance'].'",';
				$row .= '"'.$user['CSAT_experience_feedback'].'",';
				$row .= '"'.$user['call_adherence'].'",';
				
				$row .= '"'.$user['delayed_opening'].'",';
				$row .= '"'.$user['rude_on_call'].'",';
				$row .= '"'.$user['incomplete_information'].'",';
				$row .= '"'.$user['complaint_avoidance'].'",';
				
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_for_fatal'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['improvement_area'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_date'].'",';
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';	
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}if($campaign=='email'){
			
			foreach($rr as $user){	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
			
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['mission'].'",';
				$row .= '"'.$user['recording_id'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['use_paragraph_idea'].'",';
				$row .= '"'.$user['use_bullet_point'].'",';
				$row .= '"'.$user['adhered_word_limit'].'",';
				$row .= '"'.$user['template_adherence'].'",';
				$row .= '"'.$user['interim_responce'].'",';
				$row .= '"'.$user['FCR_achieved'].'",';
				$row .= '"'.$user['understand_issue'].'",';
				$row .= '"'.$user['attentiveness_display'].'",';
				$row .= '"'.$user['use_available_resource'].'",';
				$row .= '"'.$user['standardized_subject'].'",';
				$row .= '"'.$user['VAS_option'].'",';
				$row .= '"'.$user['awarreness_created'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'.$user['update_ASM'].'",';
				$row .= '"'.$user['capture_query'].'",';
				$row .= '"'.$user['formatting'].'",';
				$row .= '"'.$user['show_customer_feel_value'].'",';
				$row .= '"'.$user['procedure_guide_step'].'",';
				$row .= '"'.$user['avoid_slangs'].'",';
				$row .= '"'.$user['correct_grammar_use'].'",';
				$row .= '"'.$user['correct_closing'].'",';
				$row .= '"'.$user['further_assistance'].'",';
				
				$row .= '"'.$user['rude_on_email'].'",';
				$row .= '"'.$user['inacurate_information'].'",';
				$row .= '"'.$user['email_hygiene'].'",';
				$row .= '"'.$user['complaint_avoidance'].'",';
				
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_for_fatal'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['improvement_area'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_date'].'",';
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';	
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}
		
	}
	
	
 }
?>