<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_meesho extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('Common_model');
		//$this->load->model('Qa_meesho_model');
		
	 }
	 
	 
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "SELECT * from (Select id, assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name, fusion_id, get_process_names(id) as process_name, DATEDIFF(CURDATE(), doj) as tenure FROM signin m where id='$aid' and status='1') xx Left Join (Select user_id, phone from info_personal) yy On (xx.id=yy.user_id) ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	private function meesho_upload_files($files,$path){
        $config['upload_path'] = $path;
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        $images = array();
        foreach ($files['name'] as $key => $image) {           
			$_FILES['uFiles']['name']= $files['name'][$key];
			$_FILES['uFiles']['type']= $files['type'][$key];
			$_FILES['uFiles']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['uFiles']['error']= $files['error'][$key];
			$_FILES['uFiles']['size']= $files['size'][$key];

            if ($this->upload->do_upload('uFiles')) {
				$info = $this->upload->data();
				$ext = $info['file_ext'];
				$file_path = $info['file_path'];
				$full_path = $info['full_path'];
				$file_name = $info['file_name'];
				if(strtolower($ext)== '.wav'){
					$file_name = str_replace(".","_",$file_name).".mp3";
					$new_path = $file_path.$file_name;
					$comdFile=FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
					$output = shell_exec( $comdFile);
					sleep(2);
				}
				$images[] = $file_name;
            }else{
                return false;
            }
        }
        return $images;
    }

///////////////////////////////////////////////////////////////////////////////////////////	 
/*-------------------------------------Meesho Email---------------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////

	public function index()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/email_meesho/qa_meesho_email_feedback.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and (is_assign_process (id,204) or is_assign_process (id,0)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else if(get_login_type()=="client"){
				$ops_cond=" Where audit_type not in ('Operation Audit','Trainer Audit')";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_email_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function add_meesho_email_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/email_meesho/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and (is_assign_process (id,204) or is_assign_process (id,0)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql="Select * from qa_meesho_case_type where is_active=1";
			$data['caseType'] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql="Select id, description from qa_meesho_subcase_type where is_active='1' order by description asc";
			$data['subcaseType'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"email_date_time" => mdydt2mysql($this->input->post('email_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"order_no" => $this->input->post('order_no'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"language" => $this->input->post('language'),
					"week" => $this->input->post('week'),
					"zd_id" => $this->input->post('zd_id'),
					"contact_audit" => $this->input->post('contact_audit'),
					"satis_rating" => $this->input->post('satis_rating'),
					"ztp" => $this->input->post('ztp'),
					"agent_dispo" => $this->input->post('agent_dispo'),
					"correct_dispo" => $this->input->post('correct_dispo'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"overall_score" => $this->input->post('total_score'),
					"oprning_personalization" => $this->input->post('oprning_personalization'),
					"oprning_personalization_comment" => $this->input->post('oprning_personalization_comment'),
					"validation_customer_info" => $this->input->post('validation_customer_info'),
					"validation_customer_info_comment" => $this->input->post('validation_customer_info_comment'),
					"acknowledge_align_assure" => $this->input->post('acknowledge_align_assure'),
					"acknowledge_align_assure_comment" => $this->input->post('acknowledge_align_assure_comment'),
					"effective_probing" => $this->input->post('effective_probing'),
					"effective_probing_comment" => $this->input->post('effective_probing_comment'),
					"accurate_resolution" => $this->input->post('accurate_resolution'),
					"accurate_resolution_comment" => $this->input->post('accurate_resolution_comment'),
					"manage_delay_grace" => $this->input->post('manage_delay_grace'),
					"manage_delay_grace_comment" => $this->input->post('manage_delay_grace_comment'),
					"provide_self_help" => $this->input->post('provide_self_help'),
					"provide_self_help_comment" => $this->input->post('provide_self_help_comment'),
					"used_template_correctly" => $this->input->post('used_template_correctly'),
					"used_template_correctly_comment" => $this->input->post('used_template_correctly_comment'),
					"used_necessary_custom" => $this->input->post('used_necessary_custom'),
					"used_necessary_custom_comment" => $this->input->post('used_necessary_custom_comment'),
					"used_correct_spelling" => $this->input->post('used_correct_spelling'),
					"used_correct_spelling_comment" => $this->input->post('used_correct_spelling_comment'),
					"crm_accuracy" => $this->input->post('crm_accuracy'),
					"crm_accuracy_comment" => $this->input->post('crm_accuracy_comment'),
					"closing_statement" => $this->input->post('closing_statement'),
					"closing_statement_comment" => $this->input->post('closing_statement_comment'),
					"voice_of_customer" => $this->input->post('voice_of_customer'),
					"resolution_required_ob_call" => $this->input->post('resolution_required_ob_call'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"customer_satisfaction" => $this->input->post('customer_satisfaction'),
					"customer_issue_again" => $this->input->post('customer_issue_again'),
					"reason_for_repeat" => $this->input->post('reason_for_repeat'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->meesho_upload_files($_FILES['attach_file'], $path='./qa_files/qa_meesho/email_meesho/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_meesho_email_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_meesho_email_feedback',$field_array1);
			///////////		
				redirect('Qa_meesho');
			}
			$data["array"] = $a;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function mgnt_meesho_email_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$client_id=get_client_ids();
			$process_id=get_process_ids();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/email_meesho/mgnt_meesho_email_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and (is_assign_process (id,204) or is_assign_process (id,0)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_meesho_subcase_type where is_active=1";
			$data['subCaseType'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_email_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["meesho_email"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["efid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('efid'))
			{
				$efid=$this->input->post('efid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"email_date_time" => mdydt2mysql($this->input->post('email_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"order_no" => $this->input->post('order_no'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"language" => $this->input->post('language'),
					"week" => $this->input->post('week'),
					"zd_id" => $this->input->post('zd_id'),
					"contact_audit" => $this->input->post('contact_audit'),
					"satis_rating" => $this->input->post('satis_rating'),
					"ztp" => $this->input->post('ztp'),
					"agent_dispo" => $this->input->post('agent_dispo'),
					"correct_dispo" => $this->input->post('correct_dispo'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"overall_score" => $this->input->post('total_score'),
					"oprning_personalization" => $this->input->post('oprning_personalization'),
					"oprning_personalization_comment" => $this->input->post('oprning_personalization_comment'),
					"validation_customer_info" => $this->input->post('validation_customer_info'),
					"validation_customer_info_comment" => $this->input->post('validation_customer_info_comment'),
					"acknowledge_align_assure" => $this->input->post('acknowledge_align_assure'),
					"acknowledge_align_assure_comment" => $this->input->post('acknowledge_align_assure_comment'),
					"effective_probing" => $this->input->post('effective_probing'),
					"effective_probing_comment" => $this->input->post('effective_probing_comment'),
					"accurate_resolution" => $this->input->post('accurate_resolution'),
					"accurate_resolution_comment" => $this->input->post('accurate_resolution_comment'),
					"manage_delay_grace" => $this->input->post('manage_delay_grace'),
					"manage_delay_grace_comment" => $this->input->post('manage_delay_grace_comment'),
					"provide_self_help" => $this->input->post('provide_self_help'),
					"provide_self_help_comment" => $this->input->post('provide_self_help_comment'),
					"used_template_correctly" => $this->input->post('used_template_correctly'),
					"used_template_correctly_comment" => $this->input->post('used_template_correctly_comment'),
					"used_necessary_custom" => $this->input->post('used_necessary_custom'),
					"used_necessary_custom_comment" => $this->input->post('used_necessary_custom_comment'),
					"used_correct_spelling" => $this->input->post('used_correct_spelling'),
					"used_correct_spelling_comment" => $this->input->post('used_correct_spelling_comment'),
					"crm_accuracy" => $this->input->post('crm_accuracy'),
					"crm_accuracy_comment" => $this->input->post('crm_accuracy_comment'),
					"closing_statement" => $this->input->post('closing_statement'),
					"closing_statement_comment" => $this->input->post('closing_statement_comment'),
					//"agent_write_brand_voice" => $this->input->post('agent_write_brand_voice'),
					//"agent_write_brand_voice_comment" => $this->input->post('agent_write_brand_voice_comment'),
					"voice_of_customer" => $this->input->post('voice_of_customer'),
					"resolution_required_ob_call" => $this->input->post('resolution_required_ob_call'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"customer_satisfaction" => $this->input->post('customer_satisfaction'),
					"customer_issue_again" => $this->input->post('customer_issue_again'),
					"reason_for_repeat" => $this->input->post('reason_for_repeat')
				);
				$this->db->where('id', $efid);
				$this->db->update('qa_meesho_email_feedback',$field_array);
				
			////////////	
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
				$this->db->where('id', $efid);
				$this->db->update('qa_meesho_email_feedback',$field_array1);
			///////////	
				redirect('Qa_meesho');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}
	}
	
	
/////////////////Email Agent Part/////////////////////////	
	
	public function agent_meesho_email_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/email_meesho/agent_meesho_email_feedback.php";
			$data["agentUrl"] = "qa_meesho/agent_meesho_email_feedback";
			
			
			$qSql="Select count(id) as value from qa_meesho_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_agent_email_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_meesho_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["tot_agent_email_view_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_email_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["get_agent_review_list"] = $this->Common_model->get_query_result_array($qSql);	
					
			}else{	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["get_agent_review_list"] = $this->Common_model->get_query_result_array($qSql);		
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_meesho_email_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/email_meesho/agent_meesho_email_feedback_rvw.php";
			$data["agentUrl"] = "qa_meesho/agent_meesho_email_feedback";
			
			$data["eid"]=$id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_email_feedback where id='$id' and agent_id='$current_user') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["meesho_email"] = $this->Common_model->get_query_row_array($qSql);
			
			
			$eid=$this->input->post('eid');
			$curDateTime=CurrMySqlDate();
			$log=get_logs();
			
			if($this->input->post('eid'))
			{
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $eid);
				$this->db->update('qa_meesho_email_feedback',$field_array1);
				redirect('Qa_meesho/agent_meesho_email_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////	 
/*-------------------------------------Meesho Inbound---------------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////

	public function meesho_inbound()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/inbound_meesho/qa_meesho_inbound_feedback.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and (is_assign_process (id,187) or is_assign_process (id,0)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else if(get_login_type()=="client"){
					$ops_cond=" Where audit_type not in ('Operation Audit','Trainer Audit')";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_inbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_inbound_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	
	
	public function add_meesho_inbound_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/inbound_meesho/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and (is_assign_process (id,187) or is_assign_process (id,0)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_meesho_subcase_type where is_active=1";
			$data['subCaseType'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrMySqlDate(),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"order_no" => $this->input->post('order_no'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"language" => $this->input->post('language'),
					"record_no" => $this->input->post('record_no'),
					"recording_id" => $this->input->post('recording_id'),
					"week" => $this->input->post('week'),
					"contact_audit" => $this->input->post('contact_audit'),
					"satis_rating" => $this->input->post('satis_rating'),
					"aht_sec" => $this->input->post('aht_sec'),
					"agent_dispo" => $this->input->post('agent_dispo'),
					"correct_dispo" => $this->input->post('correct_dispo'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"overall_score" => $this->input->post('total_score'),
					"call_opening" => $this->input->post('call_opening'),
					"call_opening_comment" => $this->input->post('call_opening_comment'),
					"identification" => $this->input->post('identification'),
					"identification_comment" => $this->input->post('identification_comment'),
					"security_check" => $this->input->post('security_check'),
					"security_check_comment" => $this->input->post('security_check_comment'),
					"hold_procedure" => $this->input->post('hold_procedure'),
					"hold_procedure_comment" => $this->input->post('hold_procedure_comment'),
					"closing_script" => $this->input->post('closing_script'),
					"closing_script_comment" => $this->input->post('closing_script_comment'),
					"active_listening" => $this->input->post('active_listening'),
					"active_listening_comment" => $this->input->post('active_listening_comment'),
					"effective_probing" => $this->input->post('effective_probing'),
					"effective_probing_comment" => $this->input->post('effective_probing_comment'),
					"accurate_resolution_process" => $this->input->post('accurate_resolution_process'),
					"accurate_resolution_process_comment" => $this->input->post('accurate_resolution_process_comment'),
					"politeness_courtesy" => $this->input->post('politeness_courtesy'),
					"politeness_courtesy_comment" => $this->input->post('politeness_courtesy_comment'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"apology_empathy_comment" => $this->input->post('apology_empathy_comment'),
					"enthusiasm" => $this->input->post('enthusiasm'),
					"enthusiasm_comment" => $this->input->post('enthusiasm_comment'),
					/* "fluency_structure" => $this->input->post('fluency_structure'),
					"fluency_structure_comment" => $this->input->post('fluency_structure_comment'),
					"mentorship_pitch" => $this->input->post('mentorship_pitch'),
					"mentorship_pitch_comment" => $this->input->post('mentorship_pitch_comment'), */
					"crm_accuracy" => $this->input->post('crm_accuracy'),
					"crm_accuracy_comment" => $this->input->post('crm_accuracy_comment'),
					"addition_info" => $this->input->post('addition_info'),
					"addition_info_comment" => $this->input->post('addition_info_comment'),
					"aht_duration" => $this->input->post('aht_duration'),
					"lead_repeat_call" => $this->input->post('lead_repeat_call'),
					"ztp" => $this->input->post('ztp'),
					"voice_of_customer" => $this->input->post('voice_of_customer'),
					"resolution_required_ob_call" => $this->input->post('resolution_required_ob_call'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"customer_satisfaction" => $this->input->post('customer_satisfaction'),
					"customer_issue_again" => $this->input->post('customer_issue_again'),
					"reason_for_repeat" => $this->input->post('reason_for_repeat'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->meesho_upload_files($_FILES['attach_file'],$path='./qa_files/qa_meesho/inbound_meesho/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_meesho_inbound_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_meesho_inbound_feedback',$field_array1);
			///////////
				redirect('Qa_meesho/meesho_inbound');
			}
			$data["array"] = $a;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function mgnt_meesho_inbound_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/inbound_meesho/mgnt_meesho_inbound_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and (is_assign_process (id,187) or is_assign_process (id,0)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_meesho_subcase_type where is_active=1";
			$data['subCaseType'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_inbound_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["meesho_inbound"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["ibfid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('ibfid'))
			{
				$ibfid=$this->input->post('ibfid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"order_no" => $this->input->post('order_no'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"language" => $this->input->post('language'),
					"record_no" => $this->input->post('record_no'),
					"recording_id" => $this->input->post('recording_id'),
					"week" => $this->input->post('week'),
					"contact_audit" => $this->input->post('contact_audit'),
					"satis_rating" => $this->input->post('satis_rating'),
					"aht_sec" => $this->input->post('aht_sec'),
					"agent_dispo" => $this->input->post('agent_dispo'),
					"correct_dispo" => $this->input->post('correct_dispo'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"overall_score" => $this->input->post('total_score'),
					"call_opening" => $this->input->post('call_opening'),
					"call_opening_comment" => $this->input->post('call_opening_comment'),
					"identification" => $this->input->post('identification'),
					"identification_comment" => $this->input->post('identification_comment'),
					"security_check" => $this->input->post('security_check'),
					"security_check_comment" => $this->input->post('security_check_comment'),
					"hold_procedure" => $this->input->post('hold_procedure'),
					"hold_procedure_comment" => $this->input->post('hold_procedure_comment'),
					"closing_script" => $this->input->post('closing_script'),
					"closing_script_comment" => $this->input->post('closing_script_comment'),
					"active_listening" => $this->input->post('active_listening'),
					"active_listening_comment" => $this->input->post('active_listening_comment'),
					"effective_probing" => $this->input->post('effective_probing'),
					"effective_probing_comment" => $this->input->post('effective_probing_comment'),
					"accurate_resolution_process" => $this->input->post('accurate_resolution_process'),
					"accurate_resolution_process_comment" => $this->input->post('accurate_resolution_process_comment'),
					"politeness_courtesy" => $this->input->post('politeness_courtesy'),
					"politeness_courtesy_comment" => $this->input->post('politeness_courtesy_comment'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"apology_empathy_comment" => $this->input->post('apology_empathy_comment'),
					"enthusiasm" => $this->input->post('enthusiasm'),
					"enthusiasm_comment" => $this->input->post('enthusiasm_comment'),
					/* "fluency_structure" => $this->input->post('fluency_structure'),
					"fluency_structure_comment" => $this->input->post('fluency_structure_comment'),
					"mentorship_pitch" => $this->input->post('mentorship_pitch'),
					"mentorship_pitch_comment" => $this->input->post('mentorship_pitch_comment'), */
					"crm_accuracy" => $this->input->post('crm_accuracy'),
					"crm_accuracy_comment" => $this->input->post('crm_accuracy_comment'),
					"addition_info" => $this->input->post('addition_info'),
					"addition_info_comment" => $this->input->post('addition_info_comment'),
					"aht_duration" => $this->input->post('aht_duration'),
					"lead_repeat_call" => $this->input->post('lead_repeat_call'),
					"ztp" => $this->input->post('ztp'),
					"voice_of_customer" => $this->input->post('voice_of_customer'),
					"resolution_required_ob_call" => $this->input->post('resolution_required_ob_call'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"customer_satisfaction" => $this->input->post('customer_satisfaction'),
					"customer_issue_again" => $this->input->post('customer_issue_again'),
					"reason_for_repeat" => $this->input->post('reason_for_repeat')
				);
				$this->db->where('id', $ibfid);
				$this->db->update('qa_meesho_inbound_feedback',$field_array);
				
			////////////	
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
				$this->db->where('id', $ibfid);
				$this->db->update('qa_meesho_inbound_feedback',$field_array1);
			///////////		
				redirect('Qa_meesho/meesho_inbound');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}
	}
	
/////////////////Inbound Agent Part/////////////////////////	
	
	public function agent_meesho_inbound_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/inbound_meesho/agent_meesho_inbound_feedback.php";
			$data["agentUrl"] = "qa_meesho/agent_meesho_inbound_feedback";
			
			
			$qSql="Select count(id) as value from qa_meesho_inbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_agent_email_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_meesho_inbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["tot_agent_email_view_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_inbound_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["get_ib_agent_review_list"] = $this->Common_model->get_query_result_array($qSql);

				$data["get_ib_agent_review_list"] = $this->Qa_meesho_model->get_ib_agent_review_data($field_array);	
					
			}else{	
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_inbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["get_ib_agent_review_list"] = $this->Common_model->get_query_result_array($qSql);			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_meesho_inbound_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/inbound_meesho/agent_meesho_inbound_feedback_rvw.php";
			$data["agentUrl"] = "qa_meesho/agent_meesho_inbound_feedback";
			
			$data["ibfid"]=$id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_inbound_feedback where id='$id' and agent_id='$current_user') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["meesho_inbound"] = $this->Common_model->get_query_row_array($qSql);
			
			$ibfid=$this->input->post('ibfid');
			$curDateTime=CurrMySqlDate();
			$log=get_logs();
			
			if($this->input->post('ibfid'))
			{
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $ibfid);
				$this->db->update('qa_meesho_inbound_feedback',$field_array1);
				redirect('Qa_meesho/agent_meesho_inbound_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}
	
///////////////////////////////////////////////////////////////////////////////////////////	 
/*--------------------------------Meesho Supplier Support--------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////

	public function supplier_support(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/supplier_support/qa_supplier_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and is_assign_process (id,245) and status=1 order by name";
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
				$ops_cond=" Where audit_type not in ('Operation Audit','Trainer Audit')";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_supplier_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["supplier_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_supplier_cmb_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["supplier_cmb_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_supplier_onboarding_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["supplier_onboard_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_ss_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/supplier_support/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and is_assign_process (id,245) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"record_no" => $this->input->post('record_no'),
					"order_no" => $this->input->post('order_no'),
					"case_type" => $this->input->post('case_type'),
					"sub_type" => $this->input->post('sub_type'),
					"phone" => $this->input->post('phone'),
					"language" => $this->input->post('language'),
					"fcr" => $this->input->post('fcr'),
					"ticket_id" => $this->input->post('ticket_id'),
					"week" => $this->input->post('week'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"remarks_yes_repeat_call" => $this->input->post('remarks_yes_repeat_call'),
					"overall_score" => $this->input->post('overall_score'),
					"pre_fatal_score" => $this->input->post('pre_fatal_score'),
					"fatal_count" => $this->input->post('fatal_count'),
					"opening" => $this->input->post('opening'),
					"validateinfo" => $this->input->post('validateinfo'),
					"acknowledge" => $this->input->post('acknowledge'),
					"effectiveprobing" => $this->input->post('effectiveprobing'),
					"accurateresolution" => $this->input->post('accurateresolution'),
					"managedelay" => $this->input->post('managedelay'),
					"provideselfhelp" => $this->input->post('provideselfhelp'),
					"leveragesystem" => $this->input->post('leveragesystem'),
					"accurateowenship" => $this->input->post('accurateowenship'),
					"correctspelling" => $this->input->post('correctspelling'),
					"crmaccuracy" => $this->input->post('crmaccuracy'),
					"closingstatement" => $this->input->post('closingstatement'),
					"professionalism" => $this->input->post('professionalism'),
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					"comm5" => $this->input->post('comm5'),
					"comm6" => $this->input->post('comm6'),
					"comm7" => $this->input->post('comm7'),
					"comm8" => $this->input->post('comm8'),
					"comm9" => $this->input->post('comm9'),
					"comm10" => $this->input->post('comm10'),
					"comm11" => $this->input->post('comm11'),
					"comm12" => $this->input->post('comm12'),
					"comm13" => $this->input->post('comm13'),
					"customer_voice" => $this->input->post('customer_voice'),
					"outbound_call" => $this->input->post('outbound_call'),
					"satisfaction_level" => $this->input->post('satisfaction_level'),
					"customer_callissue" => $this->input->post('customer_callissue'),
					"repeat_reason" => $this->input->post('repeat_reason'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"acpt" => $this->input->post('acpt'),
					"l2_acpt" => $this->input->post('l2_acpt'),
					"l3_acpt" => $this->input->post('l3_acpt'),
					"l4_acpt" => $this->input->post('l4_acpt'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->meesho_upload_files($_FILES['attach_file'], $path='./qa_files/qa_meesho/supplier_support/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_meesho_supplier_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_meesho_supplier_feedback',$field_array1);
			///////////		
				redirect('Qa_meesho/supplier_support');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
	public function mgnt_supplier_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/supplier_support/mgnt_supplier_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and is_assign_process (id,245) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_supplier_feedback where id='$id') xx Left Join 
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["ss_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"record_no" => $this->input->post('record_no'),
					"order_no" => $this->input->post('order_no'),
					"case_type" => $this->input->post('case_type'),
					"sub_type" => $this->input->post('sub_type'),
					"phone" => $this->input->post('phone'),
					"language" => $this->input->post('language'),
					"fcr" => $this->input->post('fcr'),
					"ticket_id" => $this->input->post('ticket_id'),
					"week" => $this->input->post('week'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"remarks_yes_repeat_call" => $this->input->post('remarks_yes_repeat_call'),
					"overall_score" => $this->input->post('overall_score'),
					"pre_fatal_score" => $this->input->post('pre_fatal_score'),
					"fatal_count" => $this->input->post('fatal_count'),
					"opening" => $this->input->post('opening'),
					"validateinfo" => $this->input->post('validateinfo'),
					"acknowledge" => $this->input->post('acknowledge'),
					"effectiveprobing" => $this->input->post('effectiveprobing'),
					"accurateresolution" => $this->input->post('accurateresolution'),
					"managedelay" => $this->input->post('managedelay'),
					"provideselfhelp" => $this->input->post('provideselfhelp'),
					"leveragesystem" => $this->input->post('leveragesystem'),
					"accurateowenship" => $this->input->post('accurateowenship'),
					"correctspelling" => $this->input->post('correctspelling'),
					"crmaccuracy" => $this->input->post('crmaccuracy'),
					"closingstatement" => $this->input->post('closingstatement'),
					"professionalism" => $this->input->post('professionalism'),
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					"comm5" => $this->input->post('comm5'),
					"comm6" => $this->input->post('comm6'),
					"comm7" => $this->input->post('comm7'),
					"comm8" => $this->input->post('comm8'),
					"comm9" => $this->input->post('comm9'),
					"comm10" => $this->input->post('comm10'),
					"comm11" => $this->input->post('comm11'),
					"comm12" => $this->input->post('comm12'),
					"comm13" => $this->input->post('comm13'),
					"customer_voice" => $this->input->post('customer_voice'),
					"outbound_call" => $this->input->post('outbound_call'),
					"satisfaction_level" => $this->input->post('satisfaction_level'),
					"customer_callissue" => $this->input->post('customer_callissue'),
					"repeat_reason" => $this->input->post('repeat_reason'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"acpt" => $this->input->post('acpt'),
					"l2_acpt" => $this->input->post('l2_acpt'),
					"l3_acpt" => $this->input->post('l3_acpt'),
					"l4_acpt" => $this->input->post('l4_acpt')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_meesho_supplier_feedback',$field_array);
				
			////////////	
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_meesho_supplier_feedback',$field_array1);
			///////////		
				redirect('Qa_meesho/supplier_support');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	public function add_edit_cmb_supplier($ss_cmb){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/supplier_support/add_edit_cmb_supplier.php";
			$data['ss_cmb']=$ss_cmb;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and is_assign_process (id,245) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_meesho_supplier_cmb_feedback where id='$ss_cmb') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["cmb_supplier"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"record_no" => $this->input->post('record_no'),
					"order_no" => $this->input->post('order_no'),
					"case_type" => $this->input->post('case_type'),
					"sub_type" => $this->input->post('sub_type'),
					"phone" => $this->input->post('phone'),
					"language" => $this->input->post('language'),
					"fcr" => $this->input->post('fcr'),
					"ticket_id" => $this->input->post('ticket_id'),
					"week" => $this->input->post('week'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"customer_voice" => $this->input->post('customer_voice'),
					"outbound_call" => $this->input->post('outbound_call'),
					"satisfaction_level" => $this->input->post('satisfaction_level'),
					"customer_callissue" => $this->input->post('customer_callissue'),
					"repeat_reason" => $this->input->post('repeat_reason'),
					"acpt" => $this->input->post('acpt'),
					"l2_acpt" => $this->input->post('l2_acpt'),
					"l3_acpt" => $this->input->post('l3_acpt'),
					"l4_acpt" => $this->input->post('l4_acpt'),
					"remarks_yes_repeat_call" => $this->input->post('remarks_yes_repeat_call'),
					"call_duration" => $this->input->post('call_duration'),
					"overall_score" => $this->input->post('overall_score'),
					"pre_fatal_score" => $this->input->post('pre_fatal_score'),
					"fatal_count" => $this->input->post('fatal_count'),
					"call_opening" => $this->input->post('call_opening'),
					"rate_of_speech" => $this->input->post('rate_of_speech'),
					"avoid_interruption" => $this->input->post('avoid_interruption'),
					"hold_procedure_follow" => $this->input->post('hold_procedure_follow'),
					"dead_air" => $this->input->post('dead_air'),
					"casual_on_the_call" => $this->input->post('casual_on_the_call'),
					"empathy_rude" => $this->input->post('empathy_rude'),
					"provide_accrurate" => $this->input->post('provide_accrurate'),
					"cases_properly" => $this->input->post('cases_properly'),
					"updating_forms" => $this->input->post('updating_forms'),
					"proactive_information" => $this->input->post('proactive_information'),
					"survey_pitch" => $this->input->post('survey_pitch'),
					"call_closing" => $this->input->post('call_closing'),
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					"comm5" => $this->input->post('comm5'),
					"comm6" => $this->input->post('comm6'),
					"comm7" => $this->input->post('comm7'),
					"comm8" => $this->input->post('comm8'),
					"comm9" => $this->input->post('comm9'),
					"comm10" => $this->input->post('comm10'),
					"comm11" => $this->input->post('comm11'),
					"comm12" => $this->input->post('comm12'),
					"comm13" => $this->input->post('comm13'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($ss_cmb==0){
					
					$a = $this->meesho_upload_files($_FILES['attach_file'], $path='.qa_files/qa_meesho/supplier_support/cmb/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_meesho_supplier_cmb_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_meesho_supplier_cmb_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_meesho_supplier_cmb_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $ss_cmb);
					$this->db->update('qa_meesho_supplier_cmb_feedback',$field_array);
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
					$this->db->where('id', $ss_cmb);
					$this->db->update('qa_meesho_supplier_cmb_feedback',$field_array1);
					
				}
				
				redirect('Qa_meesho/supplier_support');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_onb_feedback($ss_onb){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/supplier_support/add_edit_onb_feedback.php";
			$data['ss_onb']=$ss_onb;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and is_assign_process (id,245) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_meesho_supplier_onboarding_feedback where id='$ss_onb') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["onb_supplier"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"record_no" => $this->input->post('record_no'),
					"order_no" => $this->input->post('order_no'),
					"case_type" => $this->input->post('case_type'),
					"sub_type" => $this->input->post('sub_type'),
					"phone" => $this->input->post('phone'),
					"language" => $this->input->post('language'),
					"fcr" => $this->input->post('fcr'),
					"ticket_id" => $this->input->post('ticket_id'),
					"week" => $this->input->post('week'),
					"audit_center" => $this->input->post('audit_center'),
					"agent_center" => $this->input->post('agent_center'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"customer_voice" => $this->input->post('customer_voice'),
					"outbound_call" => $this->input->post('outbound_call'),
					"satisfaction_level" => $this->input->post('satisfaction_level'),
					"customer_callissue" => $this->input->post('customer_callissue'),
					"repeat_reason" => $this->input->post('repeat_reason'),
					"acpt" => $this->input->post('acpt'),
					"l2_acpt" => $this->input->post('l2_acpt'),
					"l3_acpt" => $this->input->post('l3_acpt'),
					"l4_acpt" => $this->input->post('l4_acpt'),
					"remarks_yes_repeat_call" => $this->input->post('remarks_yes_repeat_call'),
					"overall_score" => $this->input->post('overall_score'),
					"pre_fatal_score" => $this->input->post('pre_fatal_score'),
					"fatal_count" => $this->input->post('fatal_count'),
					"call_opening" => $this->input->post('call_opening'),
					"identification" => $this->input->post('identification'),
					"active_listening" => $this->input->post('active_listening'),
					"patience" => $this->input->post('patience'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"supplier_info" => $this->input->post('supplier_info'),
					"catalog_creation" => $this->input->post('catalog_creation'),
					"order_management" => $this->input->post('order_management'),
					"logistic_process" => $this->input->post('logistic_process'),
					"return_issue" => $this->input->post('return_issue'),
					"payment" => $this->input->post('payment'),
					"closing_statement" => $this->input->post('closing_statement'),
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					"comm5" => $this->input->post('comm5'),
					"comm6" => $this->input->post('comm6'),
					"comm7" => $this->input->post('comm7'),
					"comm8" => $this->input->post('comm8'),
					"comm9" => $this->input->post('comm9'),
					"comm10" => $this->input->post('comm10'),
					"comm11" => $this->input->post('comm11'),
					"comm12" => $this->input->post('comm12'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($ss_onb==0){
					
					$a = $this->meesho_upload_files($_FILES['attach_file'], $path='.qa_files/qa_meesho/supplier_support/onboarding/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_meesho_supplier_onboarding_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_meesho_supplier_onboarding_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_meesho_supplier_onboarding_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $ss_onb);
					$this->db->update('qa_meesho_supplier_onboarding_feedback',$field_array);
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
					$this->db->where('id', $ss_onb);
					$this->db->update('qa_meesho_supplier_onboarding_feedback',$field_array1);
					
				}
				
				redirect('Qa_meesho/supplier_support');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////Agent part/////////////////////////////////	

	public function agent_supplier_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/supplier_support/agent_supplier_feedback.php";
			$data["agentUrl"] = "qa_meesho/agent_supplier_feedback";
				
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign!=''){
				
				$qSql="Select count(id) as value from qa_meesho_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
				$data["tot_ss_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_meesho_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null ";
				$data["yet_ss_rvw"] =  $this->Common_model->get_single_value($qSql);
			
				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate !="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_".$campaign."_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
						
				}
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_supplier_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/supplier_support/agent_supplier_feedback_rvw.php";
			$data["agentUrl"] = "qa_meesho/agent_supplier_feedback";
			$data["campaign"]=$campaign;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["ss_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('agent_rvw_note'),
					"agent_rvw_date" => $curDateTime
				);				
				$this->db->where('id', $pnid);
				$this->db->update('qa_meesho_'.$campaign.'_feedback',$field_array1);
				
				redirect('Qa_meesho/agent_supplier_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
///////////////////////// POP SHOP //////////////////////////
/////
	public function pop_shop(){
		if(check_logged_in())
		{			
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/pop_shop/qa_popshop_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and is_assign_process (id,304) and status=1  order by name";
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
				$ops_cond=" Where audit_type not in ('Operation Audit','Trainer Audit')";
			}else{
				$ops_cond="";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_popshop_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["pop_shop"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_popshop($pop_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/pop_shop/add_edit_popshop.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,105) and is_assign_process (id,304) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['pop_id']=$pop_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_meesho_popshop_feedback where id='$pop_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["php_shop"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"record_no" => $this->input->post('record_no'),
					"order_no" => $this->input->post('order_no'),
					"ticket_id" => $this->input->post('ticket_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"opening" => $this->input->post('opening'),
					"identification" => $this->input->post('identification'),
					"security_check" => $this->input->post('security_check'),
					"hold_procedure" => $this->input->post('hold_procedure'),
					"closing_script" => $this->input->post('closing_script'),
					"active_listening" => $this->input->post('active_listening'),
					"effective_probing" => $this->input->post('effective_probing'),
					"accurate_resolution" => $this->input->post('accurate_resolution'),
					"professionalism" => $this->input->post('professionalism'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"politeness_courtesy" => $this->input->post('politeness_courtesy'),
					"CRM_accuracy" => $this->input->post('CRM_accuracy'),
					"additional_information" => $this->input->post('additional_information'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"advisor_tagging" => $this->input->post('advisor_tagging'),
					"correct_tagging" => $this->input->post('correct_tagging'),
					"acpt" => $this->input->post('acpt'),
					"acpt_reason" => $this->input->post('acpt_reason'),
					"fatal_reason" => $this->input->post('fatal_reason'),
					"entry_date" => $curDateTime
				);
				
				if($pop_id==0){
					
					$a = $this->meesho_upload_files($_FILES['attach_file'], $path='./qa_files/qa_meesho/pop_shop/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_meesho_popshop_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_meesho_popshop_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_meesho_popshop_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $pop_id);
					$this->db->update('qa_meesho_popshop_feedback',$field_array);
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
					$this->db->where('id', $pop_id);
					$this->db->update('qa_meesho_popshop_feedback',$field_array1);
					
				}
				redirect('qa_meesho/pop_shop');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function agent_popshop_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/pop_shop/agent_popshop_feedback.php";
			$data["agentUrl"] = "qa_meesho/agent_popshop_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$qSql="Select count(id) as value from qa_meesho_popshop_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_meesho_popshop_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			if($this->input->get('btnView')=='View')
			{
				$fromDate = $this->input->get('from_date');
				if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
				
				$toDate = $this->input->get('to_date');
				if($toDate!="") $to_date = mmddyy2mysql($toDate);
				
				if($fromDate!="" && $toDate!=="" ){ 
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') ";
				}
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_popshop_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_popshop_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_popshop_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_meesho/pop_shop/agent_popshop_rvw.php";
			$data["agentUrl"] = "qa_meesho/agent_popshop_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_meesho_popshop_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["pop_shop"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["rvwacpt"]=$id;
			
			if($this->input->post('rvwacpt'))
			{
				$rvwacpt=$this->input->post('rvwacpt');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $rvwacpt);
				$this->db->update('qa_meesho_popshop_feedback',$field_array1);
					
				redirect('qa_meesho/agent_popshop_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////	 
///////////////////////////////////// QA MEESHO REPORT ////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_meesho_report(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_meesho/qa_meesho_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond='';
			$cond1='';
			$camp_cond='';
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['pValue']=$pValue;
			
			
			
			$data["qa_meesho_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (date(audit_date) >= '$date_from' and date(audit_date) <= '$date_to' ) ";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				/* if($audit_type=="All") $cond .= "";
				else $cond .=" and audit_type='$audit_type'"; */
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					if($audit_type=="All") $cond .=" and audit_type not in ('Calibration', 'Certification Audit') And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
					else $cond .=" and audit_type='$audit_type' and audit_type not in ('Calibration', 'Certification Audit') And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					if($audit_type=="All") $cond .=" and audit_type='Operation Audit' And assigned_to='$current_user'";
					else $cond .=" and audit_type='$audit_type' and audit_type='Operation Audit' And assigned_to='$current_user'";
				}else if(get_dept_folder()=="qa"){
					if($audit_type=="All") $cond .=" and audit_type!='Calibration'";
					else $cond .=" and audit_type='$audit_type' and audit_type!='Calibration'";
				}else if(get_dept_folder()=="qa" && (get_role_dir()=='tl' || get_role_dir()=='manager')){
					if($audit_type=="All") $cond .="";
					else $cond .=" and audit_type='$audit_type'";
				}else if(get_login_type()=="client"){
					$cond1 .=" And audit_type not in ('Operation Audit','Trainer Audit')";
				}else{
					$cond1 .="";
				}	
				
				if($pValue=='Inbound'){
					$camp_cond='qa_meesho_inbound_feedback';
				}else if($pValue=='Supplier_Support'){
					$camp_cond='qa_meesho_supplier_feedback';
				}else if($pValue=='Supplier_Support_CMB'){
					$camp_cond='qa_meesho_supplier_cmb_feedback';
				}else if($pValue=='Supplier_Support_Onboarding'){
					$camp_cond='qa_meesho_supplier_onboarding_feedback';
				}else if($pValue=='Email'){
					$camp_cond='qa_meesho_email_feedback';
				}else if($pValue=='Pop Shop'){
					$camp_cond='qa_meesho_popshop_feedback';
				}
				
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select email_id_off from info_personal ip where ip.user_id=entry_by) as auditor_email,
				(select email_id from signin_client sce where sce.id=client_entryby) as client_email,
				(select email_id_off from info_personal ips where ips.user_id=agent_id) as agent_email,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from $camp_cond) xx Left Join
				(Select id as sid, concat(fname, ' ', lname) as agent_name, fusion_id, doj, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 ";
					//echo $qSql;
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_meesho_list"] = $fullAray;
				$this->create_qa_meesho_CSV($fullAray,$pValue);	
				$dn_link = base_url()."qa_meesho/download_qa_meesho_CSV/".$pValue;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	

	public function download_qa_meesho_CSV($pid)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Meesho ".$pid." List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_meesho_CSV($rr,$pid)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($pid=='Inbound'){
			$header = array("Auditor Name", "Auditor Email", "Audit Date/Time", "Agent Name", "L1 Super", "Tenure", "Agent Status", "Record No", "Order No", "Phone", "Campaign", "Audit Center", "Agent Center", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Language", "Recording ID", "Call Date/Time",  "Week", "Contact Audit", "Satisfaction QA Rating", "AHT in secs", "Agent Disposition", "Correct Disposition", "Call Opening", "Call Opening Comment", "Identification", "Identification Comment", "Security Check", "Security Check Comment", "Hold Procedure", "Hold Procedure Comment", "Closing Script", "Closing Script Comment", "Active Listening", "Active Listening Comment", "Effective Probing", "Effective Probing Comment", "Accurate Resolution Process", "Accurate Resolution Process Comment", "Politeness Courtesy", "Politeness Courtesy Comment", "Apology Empathy", "Apology Empathy Comment", "Enthusiasm", "Enthusiasm Comment", "CRM accuracy", "CRM accuracy Comment", "Additional Info", "Additional Info Comment", "Total Score", "AHT Duration Reduction", "Will this Lead to Repeat Call for same Order", "ZTP", "Voice of customer any", "Resolution Requires an outbound call", "Call Summary", "Feedback", "Satisfaction level of the customer with resolution", "Will the customer call for the same issue again ?", "What would be the reason for repeat ?", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Client Review By", "Client Review Commnet", "Client Review Date");
		}else if($pid=='Email'){
			$header = array("Auditor Name", "Auditor Email", "Audit Date", "Agent Name", "L1 Super", "Tenure", "Agent Status", "Order No", "Phone", "Campaign", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Language", "Email Date/Time", "Week", "Audit Center", "Agent Center", "Contact Audit", "ZD Ticket ID", "Satisfaction rating", "Agent Disposition", "Correct Disposition", "ZTP", "Opening Personalization", "Opening Personalization Comment", "Validation Customer info", "Validation Customer info Comment", "Acknowledge Assure", "Acknowledge Assure Comment", "Effective Probing", "Effective Probing Comment", "Accurate Resolution", "Accurate Resolution Comment", "Managed delayed with grace", "Managed delayed with grace Comment", "Provided Additional Info", "Provided Additional Info Comment", "Used Templates correctly", "Used Templates correctly Comment", "Used Customization Templates", "Used Customization Templates Comment", "Use Correct Spelling", "Use Correct Spelling Comment", "CRM accuracy", "CRM accuracy Comment", "Closing Statement", "Closing Statement Comment", "Total Score", "Voice of Customer any", "Resolution Requires an outbound call", "Call Summary", "Feedback", "Satisfaction level of the customer with resolution", "Will the customer call for the same issue again ?", "What would be the reason for repeat ?", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Client Review By", "Client Review Commnet", "Client Review Date");
		}else if($pid=='Supplier_Support'){
			$header = array("Edit Audits", "QA name", "Process", "Agent Name", "TL Name", "Agent Status", "Tenurity", "Quality Score", "PreFatal Score", "Fatal", "Week", "Audit Center", "Agent Center", "Audit Date", "Employee ID", "Email Address", "Type of Contact Audit", "Email Date & Time", "Ticket ID", "Agent Selected Disposition", "Correct Disposition", "Call Summary", "Score", "Mobile No", "Language", "Order No", "Q1- Opening/Personalization", "Q1- Remarks", "Q2- Validation of customer information", "Q2- Reamarks", "Q3- Acknowledge", "Q3- Remarks", "Q4- Effecting Probing", "Q4- Remarks", "Q5- Accurate Resolution", "Q5- Remarks", "Q6- Managed delays with grace", "Q6- Remarks", "Q7- Provided self help", "Q7- Remarks", "Q8- Leverage System Tools", "Q8- Remarks", "Q9- Accurate Follow up", "Q9- Remarks", "Q10- Use correct spelling", "Q10- Remarks", "Q11- CRM accuracy", "Q11- Remarks", "Q12- Closing Statement", "Q12- Remarks", "Q13- Professionalism", "Q13- Remarks", "Voice of customer any", "Resolution Requires an outbound call", "Satisfaction level of the customer", "Will the customer call for the same issue again ?", "Remarks yes for repeat call", "What would be the reason for repeat ?", "ACPT", "L2", "L3", "L4", "Edit Audit", "Blank", "Blank", "Blank", "Blank", "Audit Date", "Tenurity(Date of certification)", "Tenure Days", "Fatal Count", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Client Review By", "Client Review Commnet", "Client Review Date", "Record No", "FCR", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Feedback");
		}else if($pid=='Supplier_Support_CMB'){
			$header = array("Edit Audits", "QA name", "Process", "Agent Name", "TL Name", "Agent Status", "Tenurity", "Quality Score", "PreFatal Score", "Fatal", "Week", "Audit Center", "Agent Center", "Audit Date", "Employee ID", "Email Address", "Type of Contact Audit", "Email Date & Time", "Mobile No", "Agent Selected Disposition", "Correct Disposition", "Call Summary", "Score", "Recording ID", "Language", "AHT", "Q1- Appropriate call opening", "Q1- Remarks", "Q2- Rate of speech/Grammar", "Q2- Remarks", "Q3- Avoid Interruption", "Q3- Remarks", "Q4- Hold Procedure", "Q4- Remarks", "Q5- Dead Air", "Q5- Remarks", "Q6- Casual on the call or not", "Q6- Remarks", "Q7 - Empathy", "Q7- Remarks", "Q8- Accurate Resolution as per the SOP", "Q8- Remarks", "Q9- comments/cases uses properly", "Q9- Remarks", "Q10- Updating forms in trackers", "Q10- Remarks", "Q11- Provide Proactive Information", "Q11- Remarks", "Q12- Survey pitch for solved cases", "Q12- Remarks", "Q13- Additional Information", "Q13- Remarks", "Voice of customer any", "Resolution Requires an outbound call", "Satisfaction level of the customer", "Will the customer call for the same issue again ?", "Remarks yes for repeat call", "What would be the reason for repeat ?", "ACPT", "L2", "L3", "L4", "Edit Audit", "Blank", "Blank", "Blank", "Blank", "Audit Date", "Tenurity(Date of certification)", "Tenure Days", "Fatal Count", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Client Review By", "Client Review Commnet", "Client Review Date", "Ticket ID", "Order No", "FCR", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Feedback");
		}else if($pid=='Supplier_Support_Onboarding'){
			$header = array("Edit Audits", "QA name", "Process", "Agent Name", "TL Name", "Agent Status", "Tenurity", "Quality Score", "PreFatal Score", "Fatal", "Week", "Audit Center", "Agent Center", "Audit Date", "Employee ID", "Email Address", "Type of Contact Audit", "Email Date & Time", "Supplier ID", "Agent Selected Disposition", "Correct Disposition", "Call Summary", "Score", "Recording ID", "Language", "Order No", "Q1- Call Opening", "Q1- Remarks", "Q2- Identification", "Q2- Remarks", "Q3- Active listening", "Q3- Remarks", "Q4- Patience", "Q4- Remarks", "Q5- Supplier Info", "Q5- Remarks", "Q6 - Catalog Creation and stock", "Q6- Remarks", "Q7 - Order management", "Q7- Remarks", "Q8 - Logistic Process", "Q8- Remarks", "Q9 - Return related issues and dashboard", "Q9- Remarks", "Q10 - Payments and penalties", "Q10- Remarks", "Q11 - Closing Statement", "Q11- Remarks", "Q12-Apology/Empathy", "Q12- Remarks", "Voice of customer any", "Resolution Requires an outbound call", "Satisfaction level of the customer", "Will the customer call for the same issue again ?", "Remarks yes for repeat call", "What would be the reason for repeat ?", "Blank", "Blank", "Blank", "Blank", "Blank", "Edit Audit", "Blank", "Blank", "Blank", "Blank", "Audit Date", "Tenurity(Date of certification)", "Tenure Days", "Fatal Count", "ACPT", "L2", "L3", "L4", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Client Review By", "Client Review Commnet", "Client Review Date", "Mobile No", "FCR", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Feedback");
		}else if($pid=='Pop Shop'){
			$header = array("Auditor Name", "Audit Date", "Agent Name", "L1 Super", "Phone", "Record No", "Order No", "Ticket ID", "Advisor Tagging", "Correct Tagging", "ACPT", "ACPT Reason", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Opening", "Identification", "Security check", "Hold Procedure", "Closing Script", "Active Listening", "Effective Probing", "**Accurate Resolution as per the SOP", "Professionalism", "Apology/Empathy", "**Politeness & Courtesy", "CRM accuracy", "Additional Information", "Opening Remarks", "Identification Remarks", "Security check Remarks", "Hold Procedure Remarks", "Closing Script Remarks", "Active Listening Remarks", "Effective Probing Remarks", "**Accurate Resolution as per the SOP Remarks", "Professionalism Remarks", "Apology/Empathy Remarks", "**Politeness & Courtesy Remarks", "CRM accuracy Remarks", "Additional Information Remarks", "Call Summary", "Feedback", "Fatal Reason", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Client Review By", "Client Review Commnet", "Client Review Date");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		
		if($pid=='Inbound'){
		
			foreach($rr as $user){
			
				if($user['call_opening']==5) $call_opening='Yes';
				else if($user['call_opening']==5.1) $call_opening='N/A';
				else $call_opening='No';
				
				if($user['identification']==5) $identification='Yes';
				else if($user['identification']==5.1) $identification='N/A';
				else $identification='No';
				
				if($user['security_check']==5) $security_check='Yes';
				else if($user['security_check']==5.1) $security_check='N/A';
				else $security_check='No';
				
				if($user['hold_procedure']==10) $hold_procedure='Yes';
				else if($user['hold_procedure']==10.1) $hold_procedure='N/A';
				else $hold_procedure='No';
				
				if($user['closing_script']==5) $closing_script='Yes';
				else if($user['closing_script']==5.1) $closing_script='N/A';
				else $closing_script='No';
				
				if($user['active_listening']==8) $active_listening='Yes';
				else if($user['active_listening']==8.1) $active_listening='N/A';
				else $active_listening='No';
				
				if($user['effective_probing']==5) $effective_probing='Yes';
				else if($user['effective_probing']==5.1) $effective_probing='N/A';
				else $effective_probing='No';
				
				if($user['accurate_resolution_process']==15) $accurate_resolution_process='Yes';
				else if($user['accurate_resolution_process']==15.1) $accurate_resolution_process='N/A';
				else $accurate_resolution_process='No';
				
				if($user['politeness_courtesy']==10) $politeness_courtesy='Yes';
				else if($user['politeness_courtesy']==10.1) $politeness_courtesy='N/A';
				else $politeness_courtesy='No';
				
				if($user['apology_empathy']==8) $apology_empathy='Yes';
				else if($user['apology_empathy']==8.1) $apology_empathy='N/A';
				else $apology_empathy='No';
				
				if($user['enthusiasm']==12) $enthusiasm='Yes';
				else if($user['enthusiasm']==12.1) $enthusiasm='N/A';
				else $enthusiasm='No';
				
				/* if($user['fluency_structure']==5) $fluency_structure='Yes';
				else if($user['fluency_structure']==5.1) $fluency_structure='N/A';
				else $fluency_structure='No';
				
				if($user['mentorship_pitch']==5) $mentorship_pitch='Yes';
				else if($user['mentorship_pitch']==5.1) $mentorship_pitch='N/A';
				else $mentorship_pitch='No'; */
				
				if($user['crm_accuracy']==10) $crm_accuracy='Yes';
				else if($user['crm_accuracy']==10.1) $crm_accuracy='N/A';
				else $crm_accuracy='No';
				
				if($user['addition_info']==2) $addition_info='Yes';
				else if($user['addition_info']==2.1) $addition_info='N/A';
				else $addition_info='No';
				
				if($user['tenure']>='30'){
					$agentStatus='BAU';
				}else{
					$agentStatus='OJT';
				}
				
				if($user['entry_by']!=''){
					$name_audt = $user['auditor_name'];
					$email_audt = $user['auditor_email'];
				}else{
					$name_audt = $user['client_name'].' [Client]';
					$email_audt = $user['client_email'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				$row = '"'.$name_audt.'",'; 
				$row .= '"'.$email_audt.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['tenure'].'",'; 
				$row .= '"'.$agentStatus.'",'; 
				$row .= '"'.$user['record_no'].'",'; 
				$row .= '"'.$user['order_no'].'",'; 
				$row .= '"'.$user['phone'].'",'; 
				$row .= '"'.$user['campaign'].'",'; 
				$row .= '"'.$user['audit_center'].'",'; 
				$row .= '"'.$user['agent_center'].'",'; 
				$row .= '"'.$user['audit_type'].'",'; 
				$row .= '"'.$user['voc'].'",'; 
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['language'].'",'; 
				$row .= '"'.$user['recording_id'].'",'; 
				$row .= '"'.$user['call_date_time'].'",';  
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['contact_audit'].'",';
				$row .= '"'.$user['satis_rating'].'",';
				$row .= '"'.$user['aht_sec'].'",';
				$row .= '"'.$user['agent_dispo'].'",';
				$row .= '"'.$user['correct_dispo'].'",';
				$row .= '"'.$call_opening.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_opening_comment'])).'",';
				$row .= '"'.$identification.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['identification_comment'])).'",';
				$row .= '"'.$security_check.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['security_check_comment'])).'",';
				$row .= '"'.$hold_procedure.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['hold_procedure_comment'])).'",';
				$row .= '"'.$closing_script.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['closing_script_comment'])).'",';
				$row .= '"'.$active_listening.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['active_listening_comment'])).'",';
				$row .= '"'.$effective_probing.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['effective_probing_comment'])).'",';
				$row .= '"'.$accurate_resolution_process.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['accurate_resolution_process_comment'])).'",';
				$row .= '"'.$politeness_courtesy.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['politeness_courtesy_comment'])).'",';
				$row .= '"'.$apology_empathy.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['apology_empathy_comment'])).'",';
				$row .= '"'.$enthusiasm.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['enthusiasm_comment'])).'",';
				/* $row .= '"'.$fluency_structure.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['fluency_structure_comment'])).'",';
				$row .= '"'.$mentorship_pitch.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mentorship_pitch_comment'])).'",'; */
				$row .= '"'.$crm_accuracy.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['crm_accuracy_comment'])).'",';
				$row .= '"'.$addition_info.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['addition_info_comment'])).'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['aht_duration'].'",';
				$row .= '"'.$user['lead_repeat_call'].'",';
				$row .= '"'.$user['ztp'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['voice_of_customer'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['resolution_required_ob_call'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_satisfaction'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_issue_again'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_for_repeat'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",'; 
				$row .= '"'.$user['agent_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",'; 
				$row .= '"'.$user['mgnt_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",'; 
				$row .= '"'.$user['client_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
				
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='Email'){
			
			foreach($rr as $user){
		
				if($user['oprning_personalization']==5) $oprning_personalization='Yes';
				else if($user['oprning_personalization']==5.1) $oprning_personalization='N/A';
				else $oprning_personalization='No';
				
				if($user['validation_customer_info']==5) $validation_customer_info='Yes';
				else if($user['validation_customer_info']==5.1) $validation_customer_info='N/A';
				else $validation_customer_info='No';
				
				if($user['acknowledge_align_assure']==5) $acknowledge_align_assure='Yes';
				else if($user['acknowledge_align_assure']==5.1) $acknowledge_align_assure='N/A';
				else $acknowledge_align_assure='No';
				
				if($user['effective_probing']==5) $effective_probing='Yes';
				else if($user['effective_probing']==5.1) $effective_probing='N/A';
				else $effective_probing='No';
				
				if($user['accurate_resolution']==10) $accurate_resolution='Yes';
				else if($user['accurate_resolution']==10.1) $accurate_resolution='N/A';
				else $accurate_resolution='No';
				
				if($user['manage_delay_grace']==5) $manage_delay_grace='Yes';
				else if($user['manage_delay_grace']==5.1) $manage_delay_grace='N/A';
				else $manage_delay_grace='No';
				
				if($user['provide_self_help']==10) $provide_self_help='Yes';
				else if($user['provide_self_help']==10.1) $provide_self_help='N/A';
				else $provide_self_help='No';
				
				if($user['used_template_correctly']==10) $used_template_correctly='Yes';
				else if($user['used_template_correctly']==10.1) $used_template_correctly='N/A';
				else $used_template_correctly='No';
				
				if($user['used_necessary_custom']==15) $used_necessary_custom='Yes';
				else if($user['used_necessary_custom']==15.1) $used_necessary_custom='N/A';
				else $used_necessary_custom='No';
				
				if($user['used_correct_spelling']==15) $used_correct_spelling='Yes';
				else if($user['used_correct_spelling']==15.1) $used_correct_spelling='N/A';
				else $used_correct_spelling='No';
				
				if($user['crm_accuracy']==10) $crm_accuracy='Yes';
				else if($user['crm_accuracy']==10.1) $crm_accuracy='N/A';
				else $crm_accuracy='No';
				
				if($user['closing_statement']==5) $closing_statement='Yes';
				else if($user['closing_statement']==5.1) $closing_statement='N/A';
				else $closing_statement='No';
				
				/* if($user['agent_write_brand_voice']==7) $agent_write_brand_voice='Yes';
				else if($user['agent_write_brand_voice']==7.1) $agent_write_brand_voice='N/A';
				else $agent_write_brand_voice='No'; */
				
				if($user['tenure']>='30'){
					$agentStatus='BAU';
				}else{
					$agentStatus='OJT';
				}
				
				if($user['entry_by']!=''){
					$name_audt = $user['auditor_name'];
					$email_audt = $user['auditor_email'];
				}else{
					$email_audt = $user['client_email'];
					$name_audt = $user['client_name'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				
				$row = '"'.$name_audt.'",'; 
				$row .= '"'.$email_audt.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$agentStatus.'",'; 
				$row .= '"'.$user['order_no'].'",'; 
				$row .= '"'.$user['phone'].'",'; 
				$row .= '"'.$user['campaign'].'",'; 
				$row .= '"'.$user['audit_type'].'",'; 
				$row .= '"'.$user['voc'].'",'; 
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['language'].'",';
				$row .= '"'.$user['email_date_time'].'",'; 
				$row .= '"'.$user['week'].'",'; 
				$row .= '"'.$user['audit_center'].'",'; 
				$row .= '"'.$user['agent_center'].'",';
				$row .= '"'.$user['contact_audit'].'",';
				$row .= '"'.$user['zd_id'].'",';  
				$row .= '"'.$user['satis_rating'].'",'; 
				$row .= '"'.$user['agent_dispo'].'",'; 
				$row .= '"'.$user['correct_dispo'].'",'; 
				$row .= '"'.$user['ztp'].'",'; 
				$row .= '"'.$oprning_personalization.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['oprning_personalization_comment'])).'",';
				$row .= '"'.$validation_customer_info.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['validation_customer_info_comment'])).'",';
				$row .= '"'.$acknowledge_align_assure.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acknowledge_align_assure_comment'])).'",';
				$row .= '"'.$effective_probing.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['effective_probing_comment'])).'",';
				$row .= '"'.$accurate_resolution.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['accurate_resolution_comment'])).'",';
				$row .= '"'.$manage_delay_grace.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['manage_delay_grace_comment'])).'",';
				$row .= '"'.$provide_self_help.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['provide_self_help_comment'])).'",';
				$row .= '"'.$used_template_correctly.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['used_template_correctly_comment'])).'",';
				$row .= '"'.$used_necessary_custom.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['used_necessary_custom_comment'])).'",';
				$row .= '"'.$used_correct_spelling.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['used_correct_spelling_comment'])).'",';
				$row .= '"'.$crm_accuracy.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['crm_accuracy_comment'])).'",';
				$row .= '"'.$closing_statement.'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['closing_statement_comment'])).'",';
				//$row .= '"'.$agent_write_brand_voice.'",'; 
				//$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_write_brand_voice_comment'])).'",';
				$row .= '"'.$user['overall_score'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['voice_of_customer'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['resolution_required_ob_call'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_satisfaction'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_issue_again'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_for_repeat'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",'; 
				$row .= '"'.$user['agent_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",'; 
				$row .= '"'.$user['mgnt_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",'; 
				$row .= '"'.$user['client_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
				
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='Supplier_Support'){
		
			foreach($rr as $user){
				$blank='';
				
				if($user['mgnt_rvw_by']!=''){
					$edit_audit='Edited';
				}else{
					$edit_audit='';
				}
				
				if($user['tenure']>='30'){
					$agentStatus='BAU';
				}else{
					$agentStatus='OJT';
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if($user['overall_score']==0){
					$fatal=100;
				}else{
					$fatal=0;
				}
				
				$row = '"'.$edit_audit.'",'; 
				$row .= '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['campaign'].'",'; 
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$agentStatus.'",';
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['pre_fatal_score'].'%'.'",';
				$row .= '"'.$fatal.'%'.'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['audit_center'].'",';
				$row .= '"'.$user['agent_center'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_email'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['case_type'].'",';
				$row .= '"'.$user['sub_type'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['language'].'",';
				$row .= '"'.$user['order_no'].'",';
				$row .= '"'.$user['opening'].'",';
				$row .= '"'.$user['comm1'].'",';
				$row .= '"'.$user['validateinfo'].'",';
				$row .= '"'.$user['comm2'].'",';
				$row .= '"'.$user['acknowledge'].'",';
				$row .= '"'.$user['comm3'].'",';
				$row .= '"'.$user['effectiveprobing'].'",';
				$row .= '"'.$user['comm4'].'",';
				$row .= '"'.$user['accurateresolution'].'",';
				$row .= '"'.$user['comm5'].'",';
				$row .= '"'.$user['managedelay'].'",';
				$row .= '"'.$user['comm6'].'",';
				$row .= '"'.$user['provideselfhelp'].'",';
				$row .= '"'.$user['comm7'].'",';
				$row .= '"'.$user['leveragesystem'].'",';
				$row .= '"'.$user['comm8'].'",';
				$row .= '"'.$user['accurateowenship'].'",';
				$row .= '"'.$user['comm9'].'",';
				$row .= '"'.$user['correctspelling'].'",';
				$row .= '"'.$user['comm10'].'",';
				$row .= '"'.$user['crmaccuracy'].'",';
				$row .= '"'.$user['comm11'].'",';
				$row .= '"'.$user['closingstatement'].'",';
				$row .= '"'.$user['comm12'].'",';
				$row .= '"'.$user['professionalism'].'",';
				$row .= '"'.$user['comm13'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_voice'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['outbound_call'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['satisfaction_level'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_callissue'])).'",';
				$row .= '"'.$user['remarks_yes_repeat_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['repeat_reason'])).'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['l2_acpt'].'",';
				$row .= '"'.$user['l3_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l4_acpt'])).'",';
				$row .= '"'.$edit_audit.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['doj'].'",';
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",'; 
				$row .= '"'.$user['agent_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",'; 
				$row .= '"'.$user['mgnt_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",'; 
				$row .= '"'.$user['client_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
				$row .= '"'.$user['record_no'].'",';
				$row .= '"'.$user['fcr'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='Supplier_Support_CMB'){
		
			foreach($rr as $user){
				$blank='';
				
				if($user['mgnt_rvw_by']!=''){
					$edit_audit='Edited';
				}else{
					$edit_audit='';
				}
				
				if($user['tenure']>='30'){
					$agentStatus='BAU';
				}else{
					$agentStatus='OJT';
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if($user['overall_score']==0){
					$fatal=100;
				}else{
					$fatal=0;
				}
				
				$row = '"'.$edit_audit.'",'; 
				$row .= '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['campaign'].'",'; 
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$agentStatus.'",';
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['pre_fatal_score'].'%'.'",';
				$row .= '"'.$fatal.'%'.'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['audit_center'].'",';
				$row .= '"'.$user['agent_center'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_email'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['case_type'].'",';
				$row .= '"'.$user['sub_type'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['record_no'].'",';
				$row .= '"'.$user['language'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['call_opening'].'",';
				$row .= '"'.$user['comm1'].'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['comm2'].'",';
				$row .= '"'.$user['avoid_interruption'].'",';
				$row .= '"'.$user['comm3'].'",';
				$row .= '"'.$user['hold_procedure_follow'].'",';
				$row .= '"'.$user['comm4'].'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'.$user['comm5'].'",';
				$row .= '"'.$user['casual_on_the_call'].'",';
				$row .= '"'.$user['comm6'].'",';
				$row .= '"'.$user['empathy_rude'].'",';
				$row .= '"'.$user['comm7'].'",';
				$row .= '"'.$user['provide_accrurate'].'",';
				$row .= '"'.$user['comm8'].'",';
				$row .= '"'.$user['cases_properly'].'",';
				$row .= '"'.$user['comm9'].'",';
				$row .= '"'.$user['updating_forms'].'",';
				$row .= '"'.$user['comm10'].'",';
				$row .= '"'.$user['proactive_information'].'",';
				$row .= '"'.$user['comm11'].'",';
				$row .= '"'.$user['survey_pitch'].'",';
				$row .= '"'.$user['comm12'].'",';
				$row .= '"'.$user['call_closing'].'",';
				$row .= '"'.$user['comm13'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_voice'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['outbound_call'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['satisfaction_level'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_callissue'])).'",';
				$row .= '"'.$user['remarks_yes_repeat_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['repeat_reason'])).'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['l2_acpt'].'",';
				$row .= '"'.$user['l3_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l4_acpt'])).'",';
				$row .= '"'.$edit_audit.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['doj'].'",';
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",'; 
				$row .= '"'.$user['agent_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",'; 
				$row .= '"'.$user['mgnt_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",'; 
				$row .= '"'.$user['client_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['order_no'].'",';
				$row .= '"'.$user['fcr'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='Supplier_Support_Onboarding'){
		
			foreach($rr as $user){
				$blank='';
				
				if($user['mgnt_rvw_by']!=''){
					$edit_audit='Edited';
				}else{
					$edit_audit='';
				}
				
				if($user['tenure']>='30'){
					$agentStatus='BAU';
				}else{
					$agentStatus='OJT';
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if($user['overall_score']==0){
					$fatal=100;
				}else{
					$fatal=0;
				}
				
				$row = '"'.$edit_audit.'",'; 
				$row .= '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['campaign'].'",'; 
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$agentStatus.'",';
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['pre_fatal_score'].'%'.'",';
				$row .= '"'.$fatal.'%'.'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['audit_center'].'",';
				$row .= '"'.$user['agent_center'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_email'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['case_type'].'",';
				$row .= '"'.$user['sub_type'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['record_no'].'",';
				$row .= '"'.$user['language'].'",';
				$row .= '"'.$user['order_no'].'",';
				$row .= '"'.$user['call_opening'].'",';
				$row .= '"'.$user['comm1'].'",';
				$row .= '"'.$user['identification'].'",';
				$row .= '"'.$user['comm2'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['comm3'].'",';
				$row .= '"'.$user['patience'].'",';
				$row .= '"'.$user['comm4'].'",';
				$row .= '"'.$user['supplier_info'].'",';
				$row .= '"'.$user['comm6'].'",';
				$row .= '"'.$user['catalog_creation'].'",';
				$row .= '"'.$user['comm7'].'",';
				$row .= '"'.$user['order_management'].'",';
				$row .= '"'.$user['comm8'].'",';
				$row .= '"'.$user['logistic_process'].'",';
				$row .= '"'.$user['comm9'].'",';
				$row .= '"'.$user['return_issue'].'",';
				$row .= '"'.$user['comm10'].'",';
				$row .= '"'.$user['payment'].'",';
				$row .= '"'.$user['comm11'].'",';
				$row .= '"'.$user['closing_statement'].'",';
				$row .= '"'.$user['comm12'].'",';
				$row .= '"'.$user['apology_empathy'].'",';
				$row .= '"'.$user['comm5'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_voice'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['outbound_call'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['satisfaction_level'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['customer_callissue'])).'",';
				$row .= '"'.$user['remarks_yes_repeat_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['repeat_reason'])).'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$edit_audit.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$blank.'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['doj'].'",';
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['l2_acpt'].'",';
				$row .= '"'.$user['l3_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l4_acpt'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",'; 
				$row .= '"'.$user['agent_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",'; 
				$row .= '"'.$user['mgnt_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",'; 
				$row .= '"'.$user['client_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['fcr'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='Pop Shop'){
		
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				$row = '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['record_no'].'",';
				$row .= '"'.$user['order_no'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['advisor_tagging'].'",';
				$row .= '"'.$user['correct_tagging'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['acpt_reason'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['opening'].'",';
				$row .= '"'.$user['identification'].'",';
				$row .= '"'.$user['security_check'].'",';
				$row .= '"'.$user['hold_procedure'].'",';
				$row .= '"'.$user['closing_script'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['effective_probing'].'",';
				$row .= '"'.$user['accurate_resolution'].'",';
				$row .= '"'.$user['professionalism'].'",';
				$row .= '"'.$user['apology_empathy'].'",';
				$row .= '"'.$user['politeness_courtesy'].'",';
				$row .= '"'.$user['CRM_accuracy'].'",';
				$row .= '"'.$user['additional_information'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['fatal_reason'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",'; 
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",'; 
				$row .= '"'.$user['mgnt_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",'; 
				$row .= '"'.$user['client_rvw_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		
	}

	
}
?>	 