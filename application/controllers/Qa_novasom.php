<?php 

 class Qa_novasom extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_novasom/qa_novasom_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,40) and is_assign_process (id,52) and status=1  order by name";
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
			}else if(get_login_type()=="client"){
				$ops_cond .=" where audit_type not in ('Operation Audit','Trainer Audit')";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_novasom_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_novasom_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from  	qa_novasom_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_novasom_data"] = $this->Common_model->get_query_result_array($qSql);
		////////////
			$qSql1 = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_bioserenity_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["bioserenity"] = $this->Common_model->get_query_result_array($qSql1);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_novasom/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,40) and is_assign_process (id,52) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"evaluation_date" => mmddyy2mysql($this->input->post('date_of_evaluation')),
					"customer_name" => $this->input->post('customer_name'),
					"order_number" => $this->input->post('order_no'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"earned_score" => $this->input->post('earned_score'),
					"incorrect_entry_contact" => $this->input->post('incorrect_entry_contact'),
					"cmt_incorrect_entry_contact" => $this->input->post('cmt_incorrect_entry_contact'),
					"incorrect_entry_address" => $this->input->post('incorrect_entry_address'),
					"cmt_incorrect_entry_address" => $this->input->post('cmt_incorrect_entry_address'),
					"incorrect_entry_name" => $this->input->post('incorrect_entry_name'),
					"cmt_incorrect_entry_name" => $this->input->post('cmt_incorrect_entry_name'),
					"incorrect_entry_dob" => $this->input->post('incorrect_entry_dob'),
					"cmt_incorrect_entry_dob" => $this->input->post('cmt_incorrect_entry_dob'),
					"incorrect_entry_gender" => $this->input->post('incorrect_entry_gender'),
					"cmt_incorrect_entry_gender" => $this->input->post('cmt_incorrect_entry_gender'),
					"incorrect_entry_lang" => $this->input->post('incorrect_entry_lang'),
					"cmt_incorrect_entry_lang" => $this->input->post('cmt_incorrect_entry_lang'),
					"physician_update" => $this->input->post('physician_update'),
					"cmt_physician_update" => $this->input->post('cmt_physician_update'),
					"wrong_physician" => $this->input->post('wrong_physician'),
					"cmt_wrong_physician" => $this->input->post('cmt_wrong_physician'),
					"physician_address" => $this->input->post('physician_address'),
					"cmt_physician_address" => $this->input->post('cmt_physician_address'),
					"physician_attachment" => $this->input->post('physician_attachment'),
					"cmt_physician_attachment" => $this->input->post('cmt_physician_attachment'),
					"dme_fax_mismatch" => $this->input->post('dme_fax_mismatch'),
					"cmt_dme_fax_mismatch" => $this->input->post('cmt_dme_fax_mismatch'),
					"wrong_order_type" => $this->input->post('wrong_order_type'),
					"order_was_not_missing" => $this->input->post('order_was_not_missing'),
					"cmt_order_was_not_missing" => $this->input->post('cmt_order_was_not_missing'),
					"failure_uncheck" => $this->input->post('failure_uncheck'),
					"cmt_failure_uncheck" => $this->input->post('cmt_failure_uncheck'),
					"mr_flag" => $this->input->post('mr_flag'),
					"cmt_mr_flag" => $this->input->post('cmt_mr_flag'),
					"did_not_flag_attestation" => $this->input->post('did_not_flag_attestation'),
					"cmt_did_not_flag_attestation" => $this->input->post('cmt_did_not_flag_attestation'),
					"attestation_accepted" => $this->input->post('attestation_accepted'),
					"cmt_attestation_accepted" => $this->input->post('cmt_attestation_accepted'),
					"placed_order_missing_info" => $this->input->post('placed_order_missing_info'),
					"cmt_placed_order_missing_info" => $this->input->post('cmt_placed_order_missing_info'),
					"unable_to_add_symptom" => $this->input->post('unable_to_add_symptom'),
					"cmt_unable_to_add_symptom" => $this->input->post('cmt_unable_to_add_symptom'),
					"epworth_score" => $this->input->post('epworth_score'),
					"cmt_epworth_score" => $this->input->post('cmt_epworth_score'),
					"failure_to_add_icd" => $this->input->post('failure_to_add_icd'),
					"cmt_failure_to_add_icd" => $this->input->post('cmt_failure_to_add_icd'),
					"incorrect_entry_height_weight" => $this->input->post('incorrect_entry_height_weight'),
					"cmt_incorrect_entry_height_weight" => $this->input->post('cmt_incorrect_entry_height_weight'),
					"no_cpap_oxygen" => $this->input->post('no_cpap_oxygen'),
					"cmt_no_cpap_oxygen" => $this->input->post('cmt_no_cpap_oxygen'),
					"unable_to_update_insurance" => $this->input->post('unable_to_update_insurance'),
					"cmt_unable_to_update_insurance" => $this->input->post('cmt_unable_to_update_insurance'),
					"insurance_not_marked" => $this->input->post('insurance_not_marked'),
					"cmt_insurance_not_marked" => $this->input->post('cmt_insurance_not_marked'),
					"insurance_uncheck" => $this->input->post('insurance_uncheck'),
					"cmt_insurance_uncheck" => $this->input->post('cmt_insurance_uncheck'),
					"failure_self_pay" => $this->input->post('failure_self_pay'),
					"cmt_failure_self_pay" => $this->input->post('cmt_failure_self_pay'),
					"self_pay_uncheck" => $this->input->post('self_pay_uncheck'),
					"cmt_self_pay_uncheck" => $this->input->post('cmt_self_pay_uncheck'),
					"secondary_insurance" => $this->input->post('secondary_insurance'),
					"cmt_secondary_insurance" => $this->input->post('cmt_secondary_insurance'),
					"uncheck_insurance_verification" => $this->input->post('uncheck_insurance_verification'),
					"cmt_uncheck_insurance_verification" => $this->input->post('cmt_uncheck_insurance_verification'),
					"referral_flag_removed" => $this->input->post('referral_flag_removed'),
					"cmt_referral_flag_removed" => $this->input->post('cmt_referral_flag_removed'),
					"changed_verified_insurance_info" => $this->input->post('changed_verified_insurance_info'),
					"cmt_changed_verified_insurance_info" => $this->input->post('cmt_changed_verified_insurance_info'),
					"confirm_fax_failure_physician" => $this->input->post('confirm_fax_failure_physician'),
					"cmt_confirm_fax_failure_physician" => $this->input->post('cmt_confirm_fax_failure_physician'),
					"wrong_fax_disposition" => $this->input->post('wrong_fax_disposition'),
					"cmt_wrong_fax_disposition" => $this->input->post('cmt_wrong_fax_disposition'),
					"wrong_attachment_another_patient" => $this->input->post('wrong_attachment_another_patient'),
					"cmt_wrong_attachment_another_patient" => $this->input->post('cmt_wrong_attachment_another_patient'),
					"creation_duplicate_order" => $this->input->post('creation_duplicate_order'),
					"cmt_creation_duplicate_order" => $this->input->post('cmt_creation_duplicate_order'),
					"wrong_attachment_different_patient" => $this->input->post('wrong_attachment_different_patient'),
					"cmt_wrong_attachment_different_patient" => $this->input->post('cmt_wrong_attachment_different_patient'),
					"new_referrel_to_old_order" => $this->input->post('new_referrel_to_old_order'),
					"cmt_new_referrel_to_old_order" => $this->input->post('cmt_new_referrel_to_old_order'),
					"hipaa_violation" => $this->input->post('hipaa_violation'),
					"cmt_hipaa_violation" => $this->input->post('cmt_hipaa_violation'),
					"failure_to_attach_workout" => $this->input->post('failure_to_attach_workout'),
					"cmt_failure_to_attach_workout" => $this->input->post('cmt_failure_to_attach_workout'),
					"failure_to_save_shared_drive" => $this->input->post('failure_to_save_shared_drive'),
					"cmt_failure_to_save_shared_drive" => $this->input->post('cmt_failure_to_save_shared_drive'),
					"putting_faxes_not_working" => $this->input->post('putting_faxes_not_working'),
					"cmt_putting_faxes_not_working" => $this->input->post('cmt_putting_faxes_not_working'),
					"unworked_assigned_three_days_old" => $this->input->post('unworked_assigned_three_days_old'),
					"cmt_unworked_assigned_three_days_old" => $this->input->post('cmt_unworked_assigned_three_days_old'),
					"cherry_picking_unapproved_date" => $this->input->post('cherry_picking_unapproved_date'),
					"cmt_cherry_picking_unapproved_date" => $this->input->post('cmt_cherry_picking_unapproved_date'),
					"refaxing" => $this->input->post('refaxing'),
					"cmt_refaxing" => $this->input->post('cmt_refaxing'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime					
				);
				$rowid= data_inserter('qa_novasom_feedback',$field_array);
				redirect('Qa_novasom');
			}			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_novasom_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_novasom/mgnt_novasom_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,40) and is_assign_process (id,52) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_novasom_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["novasom_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["novasomid"]=$id;
			
			$qSql="Select * FROM qa_novasom_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_novasom_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('novasomid'))
			{
				$novasomid=$this->input->post('novasomid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"evaluation_date" => mmddyy2mysql($this->input->post('date_of_evaluation')),
					"customer_name" => $this->input->post('customer_name'),
					"order_number" => $this->input->post('order_no'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"earned_score" => $this->input->post('earned_score'),
					"incorrect_entry_contact" => $this->input->post('incorrect_entry_contact'),
					"cmt_incorrect_entry_contact" => $this->input->post('cmt_incorrect_entry_contact'),
					"incorrect_entry_address" => $this->input->post('incorrect_entry_address'),
					"cmt_incorrect_entry_address" => $this->input->post('cmt_incorrect_entry_address'),
					"incorrect_entry_name" => $this->input->post('incorrect_entry_name'),
					"cmt_incorrect_entry_name" => $this->input->post('cmt_incorrect_entry_name'),
					"incorrect_entry_dob" => $this->input->post('incorrect_entry_dob'),
					"cmt_incorrect_entry_dob" => $this->input->post('cmt_incorrect_entry_dob'),
					"incorrect_entry_gender" => $this->input->post('incorrect_entry_gender'),
					"cmt_incorrect_entry_gender" => $this->input->post('cmt_incorrect_entry_gender'),
					"incorrect_entry_lang" => $this->input->post('incorrect_entry_lang'),
					"cmt_incorrect_entry_lang" => $this->input->post('cmt_incorrect_entry_lang'),
					"physician_update" => $this->input->post('physician_update'),
					"cmt_physician_update" => $this->input->post('cmt_physician_update'),
					"wrong_physician" => $this->input->post('wrong_physician'),
					"cmt_wrong_physician" => $this->input->post('cmt_wrong_physician'),
					"physician_address" => $this->input->post('physician_address'),
					"cmt_physician_address" => $this->input->post('cmt_physician_address'),
					"physician_attachment" => $this->input->post('physician_attachment'),
					"cmt_physician_attachment" => $this->input->post('cmt_physician_attachment'),
					"dme_fax_mismatch" => $this->input->post('dme_fax_mismatch'),
					"cmt_dme_fax_mismatch" => $this->input->post('cmt_dme_fax_mismatch'),
					"wrong_order_type" => $this->input->post('wrong_order_type'),
					"order_was_not_missing" => $this->input->post('order_was_not_missing'),
					"cmt_order_was_not_missing" => $this->input->post('cmt_order_was_not_missing'),
					"failure_uncheck" => $this->input->post('failure_uncheck'),
					"cmt_failure_uncheck" => $this->input->post('cmt_failure_uncheck'),
					"mr_flag" => $this->input->post('mr_flag'),
					"cmt_mr_flag" => $this->input->post('cmt_mr_flag'),
					"did_not_flag_attestation" => $this->input->post('did_not_flag_attestation'),
					"cmt_did_not_flag_attestation" => $this->input->post('cmt_did_not_flag_attestation'),
					"attestation_accepted" => $this->input->post('attestation_accepted'),
					"cmt_attestation_accepted" => $this->input->post('cmt_attestation_accepted'),
					"placed_order_missing_info" => $this->input->post('placed_order_missing_info'),
					"cmt_placed_order_missing_info" => $this->input->post('cmt_placed_order_missing_info'),
					"unable_to_add_symptom" => $this->input->post('unable_to_add_symptom'),
					"cmt_unable_to_add_symptom" => $this->input->post('cmt_unable_to_add_symptom'),
					"epworth_score" => $this->input->post('epworth_score'),
					"cmt_epworth_score" => $this->input->post('cmt_epworth_score'),
					"failure_to_add_icd" => $this->input->post('failure_to_add_icd'),
					"cmt_failure_to_add_icd" => $this->input->post('cmt_failure_to_add_icd'),
					"incorrect_entry_height_weight" => $this->input->post('incorrect_entry_height_weight'),
					"cmt_incorrect_entry_height_weight" => $this->input->post('cmt_incorrect_entry_height_weight'),
					"no_cpap_oxygen" => $this->input->post('no_cpap_oxygen'),
					"cmt_no_cpap_oxygen" => $this->input->post('cmt_no_cpap_oxygen'),
					"unable_to_update_insurance" => $this->input->post('unable_to_update_insurance'),
					"cmt_unable_to_update_insurance" => $this->input->post('cmt_unable_to_update_insurance'),
					"insurance_not_marked" => $this->input->post('insurance_not_marked'),
					"cmt_insurance_not_marked" => $this->input->post('cmt_insurance_not_marked'),
					"insurance_uncheck" => $this->input->post('insurance_uncheck'),
					"cmt_insurance_uncheck" => $this->input->post('cmt_insurance_uncheck'),
					"failure_self_pay" => $this->input->post('failure_self_pay'),
					"cmt_failure_self_pay" => $this->input->post('cmt_failure_self_pay'),
					"self_pay_uncheck" => $this->input->post('self_pay_uncheck'),
					"cmt_self_pay_uncheck" => $this->input->post('cmt_self_pay_uncheck'),
					"secondary_insurance" => $this->input->post('secondary_insurance'),
					"cmt_secondary_insurance" => $this->input->post('cmt_secondary_insurance'),
					"uncheck_insurance_verification" => $this->input->post('uncheck_insurance_verification'),
					"cmt_uncheck_insurance_verification" => $this->input->post('cmt_uncheck_insurance_verification'),
					"referral_flag_removed" => $this->input->post('referral_flag_removed'),
					"cmt_referral_flag_removed" => $this->input->post('cmt_referral_flag_removed'),
					"changed_verified_insurance_info" => $this->input->post('changed_verified_insurance_info'),
					"cmt_changed_verified_insurance_info" => $this->input->post('cmt_changed_verified_insurance_info'),
					"confirm_fax_failure_physician" => $this->input->post('confirm_fax_failure_physician'),
					"cmt_confirm_fax_failure_physician" => $this->input->post('cmt_confirm_fax_failure_physician'),
					"wrong_fax_disposition" => $this->input->post('wrong_fax_disposition'),
					"cmt_wrong_fax_disposition" => $this->input->post('cmt_wrong_fax_disposition'),
					"wrong_attachment_another_patient" => $this->input->post('wrong_attachment_another_patient'),
					"cmt_wrong_attachment_another_patient" => $this->input->post('cmt_wrong_attachment_another_patient'),
					"creation_duplicate_order" => $this->input->post('creation_duplicate_order'),
					"cmt_creation_duplicate_order" => $this->input->post('cmt_creation_duplicate_order'),
					"wrong_attachment_different_patient" => $this->input->post('wrong_attachment_different_patient'),
					"cmt_wrong_attachment_different_patient" => $this->input->post('cmt_wrong_attachment_different_patient'),
					"new_referrel_to_old_order" => $this->input->post('new_referrel_to_old_order'),
					"cmt_new_referrel_to_old_order" => $this->input->post('cmt_new_referrel_to_old_order'),
					"hipaa_violation" => $this->input->post('hipaa_violation'),
					"cmt_hipaa_violation" => $this->input->post('cmt_hipaa_violation'),
					"failure_to_attach_workout" => $this->input->post('failure_to_attach_workout'),
					"cmt_failure_to_attach_workout" => $this->input->post('cmt_failure_to_attach_workout'),
					"failure_to_save_shared_drive" => $this->input->post('failure_to_save_shared_drive'),
					"cmt_failure_to_save_shared_drive" => $this->input->post('cmt_failure_to_save_shared_drive'),
					"putting_faxes_not_working" => $this->input->post('putting_faxes_not_working'),
					"cmt_putting_faxes_not_working" => $this->input->post('cmt_putting_faxes_not_working'),
					"unworked_assigned_three_days_old" => $this->input->post('unworked_assigned_three_days_old'),
					"cmt_unworked_assigned_three_days_old" => $this->input->post('cmt_unworked_assigned_three_days_old'),
					"cherry_picking_unapproved_date" => $this->input->post('cherry_picking_unapproved_date'),
					"cmt_cherry_picking_unapproved_date" => $this->input->post('cmt_cherry_picking_unapproved_date'),
					"refaxing" => $this->input->post('refaxing'),
					"cmt_refaxing" => $this->input->post('cmt_refaxing'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime	
				);
				$this->db->where('id', $novasomid);
				$this->db->update('qa_novasom_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $novasomid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_novasom_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $intakeid);
					$this->db->update('qa_novasom_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_novasom');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////	

	public function agent_novasom_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_novasom/agent_novasom_feedback.php";
			$data["agentUrl"] = "qa_novasom/agent_novasom_feedback";
				
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$campaign=$this->input->get('campaign');
			
			if($campaign!=''){
				
				if($campaign=='novasom'){
					$qSql1="Select count(id) as value from qa_novasom_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					$qSql2="Select count(id) as value from qa_novasom_feedback where id  not in (select fd_id from qa_novasom_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
				}else if($campaign=='bioserenity'){
					$qSql1="Select count(id) as value from qa_bioserenity_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					$qSql2="Select count(id) as value from qa_bioserenity_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
				}
				$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql1);
				$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql2);
				
				if($this->input->get('btnView')=='View')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
					
					if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
					
					if($campaign=='novasom'){
						$qSql_agent = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_novasom_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_novasom_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_rvw_name from qa_novasom_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
					}else if($campaign=='bioserenity'){
						$qSql_agent = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bioserenity_feedback $cond And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					}
					$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql_agent);
						
				}
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_novasom_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_novasom/agent_novasom_feedback_rvw.php";
			$data["agentUrl"] = "qa_novasom/agent_novasom_feedback";
						
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,40) and is_assign_process (id,52) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_novasom_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["novasom_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["novasomid"]=$id;
			
			$qSql="Select * FROM qa_novasom_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_novasom_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('novasomid'))
			{
				$novasomid=$this->input->post('novasomid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $novasomid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_novasom_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $intakeid);
					$this->db->update('qa_novasom_agent_rvw',$field_array1);
				}	
				redirect('qa_novasom/agent_novasom_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_bioserenity_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_novasom/agent_bioserenity_rvw.php";
			$data["agentUrl"] = "qa_novasom/agent_novasom_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bioserenity_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["bioserenity"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["rvwacpt"]=$id;
			
			if($this->input->post('rvwacpt'))
			{
				$rvwacpt=$this->input->post('rvwacpt');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $rvwacpt);
				$this->db->update('qa_bioserenity_feedback',$field_array1);
					
				redirect('qa_novasom/agent_novasom_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////// Bioserenity ///////////////////////////////////////////
	
	public function add_edit_bioserenity($bio_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_novasom/add_edit_bioserenity.php";
			$data['bio_id']=$bio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,40) and is_assign_process (id,52) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_bioserenity_feedback where id='$bio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["bioserenity"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			//$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"customer_name" => $this->input->post('customer_name'),
					"order_number" => $this->input->post('order_number'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"customerErnd" => $this->input->post('customerErnd'),
					"businessErnd" => $this->input->post('businessErnd'),
					"complianceErnd" => $this->input->post('complianceErnd'),
					"customerPsbl" => $this->input->post('customerPsbl'),
					"businessPsbl" => $this->input->post('businessPsbl'),
					"compliancePsbl" => $this->input->post('compliancePsbl'),
					"customerTotal" => $this->input->post('customerTotal'),
					"businessTotal" => $this->input->post('businessTotal'),
					"complianceTotal" => $this->input->post('complianceTotal'),
					"patient_information" => $this->input->post('patient_information'),
					"physician" => $this->input->post('physician'),
					"order_information" => $this->input->post('order_information'),
					"diagnostic" => $this->input->post('diagnostic'),
					"insurance" => $this->input->post('insurance'),
					"order_history" => $this->input->post('order_history'),
					"attachment" => $this->input->post('attachment'),
					"order_creation" => $this->input->post('order_creation'),
					"major_errors" => $this->input->post('major_errors'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"cmt27" => $this->input->post('cmt27'),
					"cmt28" => $this->input->post('cmt28'),
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
					"cmt32" => $this->input->post('cmt32'),
					"cmt33" => $this->input->post('cmt33'),
					"cmt34" => $this->input->post('cmt34'),
					"cmt35" => $this->input->post('cmt35'),
					"cmt36" => $this->input->post('cmt36'),
					"cmt37" => $this->input->post('cmt37'),
					"cmt38" => $this->input->post('cmt38'),
					"cmt39" => $this->input->post('cmt39'),
					"cmt40" => $this->input->post('cmt40'),
					"cmt41" => $this->input->post('cmt41'),
					"cmt42" => $this->input->post('cmt42'),
					"cmt43" => $this->input->post('cmt43'),
					"cmt44" => $this->input->post('cmt44'),
					"cmt45" => $this->input->post('cmt45'),
					"cmt46" => $this->input->post('cmt46'),
					"cmt47" => $this->input->post('cmt47'),
					"cmt48" => $this->input->post('cmt48'),
					"cmt49" => $this->input->post('cmt49'),
					"cmt50" => $this->input->post('cmt50'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($bio_id==0){
					
					/* $a = $this->meesho_upload_files($_FILES['attach_file'], $path='.qa_files/qa_meesho/supplier_support/cmb/');
					$field_array["attach_file"] = implode(',',$a);*/
					$rowid= data_inserter('qa_bioserenity_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_bioserenity_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_bioserenity_feedback',$field_array1);
					/*******************Fatal Call Email Send functionality added on 14-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_bioserenity_feedback";
						$sql = "SELECT tname.*, ip.email_id_off, ip_tl.email_id_off as tl_email, concat(s.fname, ' ', s.lname) as fullname,
							(SELECT concat(tls.fname, ' ', tls.lname) as tl_fullname FROM signin tls WHERE tls.id=tname.tl_id) as tl_fullname
							FROM $tablename tname
							LEFT JOIN info_personal ip ON ip.user_id=tname.agent_id 
							LEFT JOIN signin s ON s.id=tname.agent_id
							LEFT JOIN signin tl ON tl.id = tname.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = tname.tl_id
							WHERE tname.id=$rowid";
						$result= $this->Common_model->get_query_row_array($sql);				
						$sqlParam ="SELECT process_id,params_columns, fatal_param, param_column_desc FROM qa_defect where table_name='$tablename'"; 
						$resultParams = $this->Common_model->get_query_row_array($sqlParam);
						
						$process = floor($resultParams['process_id']);
						$sqlProcess ="SELECT name FROM process where id='$process'"; 
						$resultProcess = $this->Common_model->get_query_row_array($sqlProcess);
						
						$params = explode(",", $resultParams['params_columns']);
						$fatal_params = explode(",", $resultParams['fatal_param']);
						$descArr = explode(",", $resultParams['param_column_desc']);
						
						$msgTable = "<Table BORDER=1>";
						$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
						
						$i=1;
						$j=0;
						foreach($params as $par){
							//echo $str = str_replace('_', ' ', $par)."<BR>";
							if($result[$par]=='No'){
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD style='color:#FF0000'>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}else{
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}
							
							$i++;
							$j++;
						}
						///////////////////////////
						//$j=1;
						/* if(!empty($fatal_params)){
							foreach($fatal_params as $fatal_par){
								if(!empty($fatal_par)){
								$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['cmt'.($i-10)]."</TD></TR>";
								
								$i++;
								}
							}
						} */
						$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
						$msgTable .= "</Table>";

						$eccA=array();
						//$to = $result['tl_email']; // Have to open when email will trigger to the Respective TL of the Agent
						$to = 'francis.garcia@fusionbposervices.com,sherryl.demape@fusionbposervices.com,vincent.butaya@fusionbposervices.com,Zephaniah.Satiembre@fusionbposervices.com,bryan.carpio@fusionbposervices.com,Acha.Joseph@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						$ebody .= "<p>Order Number :  ".$result['order_number']."</p>";
						$ebody .= "<p>Date of Evaluation : ".$result['call_date']."</p>";
						$ebody .= "<p>Audit Date time : ".ConvServerToLocal($result['entry_date'])."</p>";
						$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
						$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
						$ebody .= "<p>Customer Critical : ".$result['customerTotal']."</p><br><br>";
						$ebody .= "<p>Business Critical : ".$result['businessTotal']."</p><br><br>";
						$ebody .= "<p>Compliance Critical : ".$result['complianceTotal']."</p><br><br>";
						$ebody .= "<p>Please listen the call from the MWP Tool and share feedback acceptancy :</p>";
						$ebody .=  $msgTable;
						$ebody .= "<p>Regards,</p>";
						$ebody .= "<p>MWP Team</p>";
						$esubject = "Fatal Call Alert - "." For Process - ".$resultProcess['name'].", Agent Name - ".$result['fullname']." Audit Date - ".$result['audit_date'];
						$eccA[]="Bompalli.Somasundaram@omindtech.com";
						$eccA[]="deb.dasgupta@omindtech.com";
						$eccA[]="sumitra.bagchi@omindtech.com";
						$eccA[]="anshuman.sarkar@fusionbposervices.com";
						/* $eccA[]="danish.khan@fusionbposervices.com";
						$eccA[]="Faisal.Anwar@fusionbposervices.com"; */
						$ecc = implode(',',$eccA);
						$path = "";
						$from_email="";
						$from_name="";
						//echo $esubject."<br>";
						//echo $ebody."<br>";
						//exit;
						//$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
						unset($eccA);
					}
					/*******************Fatal Call Email Send functionality added on 12-12-22 END ***********************/
					
				}else{
					
					$this->db->where('id', $bio_id);
					$this->db->update('qa_bioserenity_feedback',$field_array);
					/////////
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
					$this->db->where('id', $bio_id);
					$this->db->update('qa_bioserenity_feedback',$field_array1);
					
				}
				
				redirect('Qa_novasom');
			}
			//$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function qa_novasom_report(){
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
			$data["content_template"] = "qa_novasom/qa_novasom_report.php";
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$campaign=$this->input->get('campaign');
			
			$data["qa_novasom_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
				
				if($audit_type=="All") $cond .= "";
				else $cond .=" and audit_type='$audit_type'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else if(get_login_type()=="client"){
					$cond1 .=" And audit_type not in ('Operation Audit','Trainer Audit')";
				}else{
					$cond1 .="";
				}
				
				if($campaign=='bioserenity'){
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
					from qa_bioserenity_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}else if($campaign=='novasom'){
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, DATE_FORMAT(entry_date,'%m-%Y') AS m_Y from qa_novasom_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_novasom_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_novasom_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
				}
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_novasom_list"] = $fullAray;
				$this->create_qa_novasom_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_novasom/download_qa_novasom_CSV/".$campaign;			
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['campaign']=$campaign;
			$data['audit_type']=$audit_type;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_qa_novasom_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_novasom_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=='novasom'){
			$header = array("Auditor Name","Audit Date","Agent","Customer Name","Order Number","Evaluation Date","Audit Type","VOC","Earned Score","Total Score","Incorrect entry/Did not add patient's phone # alternate phone #s employment phone #/work phone #/emergency contact #","Incorrect entry/Did not add patient's street address apartment # city state and zip code","Incorrect entry of patient's first and last name","Incorrect entry of patient's date of birth","Incorrect entry of patient's gender","Incorrect entry of patient's language","Failure to update physician status in their profile (from pending to active)","Wrong physician selected","Did not update physician’s practice address phone # and fax #/wrong physician's office selected","Order was flagged for Missing Physician even if the physician was in the attachment","DME not entered/DME fax number selected did not match on the order form","Wrong order type selected/did not update order type","Placed the order into Sales Follow-up but the order wasn’t missing anything","Failure to uncheck “Missing Info” after attaching MR (MI)","Attached medical records/keyed in an order that includes MR but did not flag order for MR review (did not check off “Medical Record for Internal Review”) even if there’s form error “Medical Records Needed from Dr”","Did not flag the order for attestation (did not check off Accept Medical Judgment or did not check off Missing Physician Signed order)","Accepted attestation/Checked off “Accept Medical Judgment” on an unsigned order form","Order was placed into Sales Follow-up even if the missing info such as insurance info address etc are found on the previous order","Unable to add available symptoms/diagnosis","Epworth score was not added","Failure to add needed ICD 10 code","Incorrect entry of patient's height and weight","Did not select No for CPAP and No for Oxygen even if it’s indicated on the attachment","Unable to add/update insurance info to the order","Insurance info was added but order was not marked for Insurance Verification","Order was flagged for Insurance Verification. Failed to uncheck “Needs Insurance Verification” when there’s missing insurance info","Failure to mark of “Offer Cash Price” for Self-Pay order","Failure to uncheck “Needs Insurance Verification” for Self-Pay order","Did not add secondary insurance info","Unchecked “Needs Insurance Verification” even if the order has never got verified for insurance","Referral flag was removed when it should not have been","Changed the insurance info even if the insurance is already verified e.g. changed the carrier name and subscriber id #","Failure to send physician fax confirmation","Wrong fax attachment disposition","Wrong attachment to order belonging to another patient","Creation of duplicate order","Creation of new order for a patient but the attached order form is for a different patient","New referral attached to old order but did not key in new order","HIPAA violation – rep mistakenly fax document to incorrect physician or practice address","Failure to attach the records/documents needed for each order worked out","Failure to save the orders in the Shared Drive","Putting faxes on non-order but not working on it","Unworked assigned pods that are 3 days old","Cherry picking/Processing on faxes with unapproved receiving date","Putting notes on the order that refaxing was done but none was actually faxed","Call Summary","Feedback","Agent Review Date","Agent Note","Management Review Date","Management Name","Management Note");
		}else if($campaign=='bioserenity'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "TL Name", "Customer Name", "Order Number", "Evaluation Date", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Total Score", "Customer Critical", "Business Critical", "Compliance Critical", "1)PATIENT INFORMATION", "Q1 - Comment1", "Q1 - Comment2", "Q1 - Comment3", "Q1 - Comment4", "Q1 - Comment5", "Q1 - Comment6", "Q1 - Comment7", "2)PHYSICIAN", "Q2 - Comment1", "Q2 - Comment2", "Q2 - Comment3", "Q2 - Comment4", "Q2 - Comment5", "Q2 - Comment6", "3)ORDER INFORMATION", "Q3 - Comment1", "Q3 - Comment2", "Q3 - Comment3", "Q3 - Comment4", "Q3 - Comment5", "Q3 - Comment6", "Q3 - Comment7", "Q3 - Comment8", "4)DIAGNOSTIC", "Q4 - Comment1", "Q4 - Comment2", "Q4 - Comment3", "Q4 - Comment4", "Q4 - Comment5", "Q4 - Comment6", "5)INSURANCE", "Q5 - Comment1", "Q5 - Comment2", "Q5 - Comment3", "Q5 - Comment4", "Q5 - Comment5", "Q5 - Comment6", "Q5 - Comment7", "Q5 - Comment8", "Q5 - Comment9", "6)ORDER HISTORY", "Q6 - Comment", "7)ATTACHMENT", "Q7 - Comment1", "Q7 - Comment2", "8)ORDER CREATION", "Q8 - Comment1", "Q8 - Comment2", "Q8 - Comment3", "** 9)MAJOR ERRORS", "Q9 - Comment1", "Q9 - Comment2", "Q9 - Comment3", "Q9 - Comment4", "Q9 - Comment5", "Q9 - Comment6", "Q9 - Comment7", "Q9 - Comment8", "Call Summary", "Feedback", "Agent Review Date", "Agent Note", "Management Rerview By", "Management Review Date", "Management Review Note");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row	=	"";
		
		if($campaign=='novasom'){
			
			foreach($rr as $user){
				$row .= '"'.$user["auditor_name"].'",';
				$row .= '"'.$user["audit_date"].'",';
				$row .= '"'.$user["fname"]." ".$user["lname"].'",';
				$row .= '"'.$user["customer_name"].'",';
				$row .= '"'.$user["order_number"].'",';
				$row .= '"'.$user["evaluation_date"].'",';
				$row .= '"'.$user["audit_type"].'",';
				$row .= '"'.$user["voc"].'",';
				$row .= '"'.$user["earned_score"].'",';
				$row .= '"'.$user["overall_score"].'",';
				$row .= '"'.$user["incorrect_entry_contact"].'",';
				$row .= '"'.$user["incorrect_entry_address"].'",';
				$row .= '"'.$user["incorrect_entry_name"].'",';
				$row .= '"'.$user["incorrect_entry_dob"].'",';
				$row .= '"'.$user["incorrect_entry_gender"].'",';
				$row .= '"'.$user["incorrect_entry_lang"].'",';
				$row .= '"'.$user["physician_update"].'",';
				$row .= '"'.$user["wrong_physician"].'",';
				$row .= '"'.$user["physician_address"].'",';
				$row .= '"'.$user["physician_attachment"].'",';
				$row .= '"'.$user["dme_fax_mismatch"].'",';
				$row .= '"'.$user["wrong_order_type"].'",';
				$row .= '"'.$user["order_was_not_missing"].'",';
				$row .= '"'.$user["failure_uncheck"].'",';
				$row .= '"'.$user["mr_flag"].'",';
				$row .= '"'.$user["did_not_flag_attestation"].'",';
				$row .= '"'.$user["attestation_accepted"].'",';
				$row .= '"'.$user["placed_order_missing_info"].'",';
				$row .= '"'.$user["unable_to_add_symptom"].'",';
				$row .= '"'.$user["epworth_score"].'",';
				$row .= '"'.$user["failure_to_add_icd"].'",';
				$row .= '"'.$user["incorrect_entry_height_weight"].'",';
				$row .= '"'.$user["no_cpap_oxygen"].'",';
				$row .= '"'.$user["unable_to_update_insurance"].'",';
				$row .= '"'.$user["insurance_not_marked"].'",';
				$row .= '"'.$user["insurance_uncheck"].'",';
				$row .= '"'.$user["failure_self_pay"].'",';
				$row .= '"'.$user["self_pay_uncheck"].'",';
				$row .= '"'.$user["secondary_insurance"].'",';
				$row .= '"'.$user["uncheck_insurance_verification"].'",';
				$row .= '"'.$user["referral_flag_removed"].'",';
				$row .= '"'.$user["changed_verified_insurance_info"].'",';
				$row .= '"'.$user["confirm_fax_failure_physician"].'",';
				$row .= '"'.$user["wrong_fax_disposition"].'",';
				$row .= '"'.$user["wrong_attachment_another_patient"].'",';
				$row .= '"'.$user["creation_duplicate_order"].'",';
				$row .= '"'.$user["wrong_attachment_different_patient"].'",';
				$row .= '"'.$user["new_referrel_to_old_order"].'",';
				$row .= '"'.$user["hipaa_violation"].'",';
				$row .= '"'.$user["failure_to_attach_workout"].'",';
				$row .= '"'.$user["failure_to_save_shared_drive"].'",';
				$row .= '"'.$user["putting_faxes_not_working"].'",';
				$row .= '"'.$user["unworked_assigned_three_days_old"].'",';
				$row .= '"'.$user["cherry_picking_unapproved_date"].'",';
				$row .= '"'.$user["refaxing"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';		
				fwrite($fopen,$row."\r\n");
				$row	=	"";
			}
			fclose($fopen);
		
		}else if($campaign=='bioserenity'){
			
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				$row .= '"'.$user["auditor_name"].'",';
				$row .= '"'.$user["audit_date"].'",';
				$row .= '"'.$user["fusion_id"].'",';
				$row .= '"'.$user["fname"]." ".$user["lname"].'",';
				$row .= '"'.$user["tl_name"].'",';
				$row .= '"'.$user["customer_name"].'",';
				$row .= '"'.$user["order_number"].'",';
				$row .= '"'.$user["call_date"].'",';
				$row .= '"'.$user["audit_type"].'",';
				$row .= '"'.$user["voc"].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user["earned_score"].'",';
				$row .= '"'.$user["possible_score"].'",';
				$row .= '"'.$user["overall_score"].'%'.'",';
				$row .= '"'.$user["customerTotal"].'%'.'",';
				$row .= '"'.$user["businessTotal"].'%'.'",';
				$row .= '"'.$user["complianceTotal"].'%'.'",';
				$row .= '"'.$user["patient_information"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user["physician"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user["order_information"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'.$user["diagnostic"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
				$row .= '"'.$user["insurance"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt30'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt31'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt32'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt33'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt34'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt35'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt36'])).'",';
				$row .= '"'.$user["order_history"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt37'])).'",';
				$row .= '"'.$user["attachment"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt38'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt39'])).'",';
				$row .= '"'.$user["order_creation"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt40'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt41'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt42'])).'",';
				$row .= '"'.$user["major_errors"].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt43'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt44'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt45'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt46'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt47'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt48'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt49'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt50'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",'; 
				$row .= '"'.$user['mgnt_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				fwrite($fopen,$row."\r\n");
				$row	=	"";
			}
			fclose($fopen);
			
		}	
	
	}
	
	
	
 }