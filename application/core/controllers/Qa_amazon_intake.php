<?php 

 class Qa_amazon_intake extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
///////////////////////////////Amazon Intake///////////////////////////////////////////	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/qa_intake_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,109) and status=1  order by name";
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
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_intake_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_intake_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_amazon_intake_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["amazon_intake_data"] = $this->Common_model->get_query_result_array($qSql);
			
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
			$data["content_template"] = "qa_amazon_intake/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,109) and status=1  order by name";
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
					"case_no" => $this->input->post('case_no'),
					"call_id" => $this->input->post('call_id'),
					"followup_need" => $this->input->post('followup_need'),
					"emp_status" => $this->input->post('emp_status'),
					"product" => $this->input->post('product'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"call_probing" => $this->input->post('call_probing'),
					"call_solve" => $this->input->post('call_solve'),
					"call_question" => $this->input->post('call_question'),
					"call_address" => $this->input->post('call_address'),
					"call_proactive" => $this->input->post('call_proactive'),
					"call_inform" => $this->input->post('call_inform'),
					"call_csr" => $this->input->post('call_csr'),
					"call_hold" => $this->input->post('call_hold'),
					"call_permission" => $this->input->post('call_permission'),
					"call_twice" => $this->input->post('call_twice'),
					"call_listen" => $this->input->post('call_listen'),
					"call_task" => $this->input->post('call_task'),
					"call_email" => $this->input->post('call_email'),
					"call_outbound" => $this->input->post('call_outbound'),
					"call_handle_score" => $this->input->post('call_handle_score'),
					"call_handle_earned" => $this->input->post('call_handle_earned'),
					"call_handle_possible" => $this->input->post('call_handle_possible'),
					"personal_tone" => $this->input->post('personal_tone'),
					"personal_exhibit" => $this->input->post('personal_exhibit'),
					"personal_conversion" => $this->input->post('personal_conversion'),
					"personal_refrain" => $this->input->post('personal_refrain'),
					"personal_coherent" => $this->input->post('personal_coherent'),
					"personal_avoid" => $this->input->post('personal_avoid'),
					"personal_service_score" => $this->input->post('personal_service_score'),
					"personal_service_earned" => $this->input->post('personal_service_earned'),
					"personal_service_possible" => $this->input->post('personal_service_possible'),
					"knowledge_ask" => $this->input->post('knowledge_ask'),
					"knowledge_anticipate" => $this->input->post('knowledge_anticipate'),
					"knowledge_focus" => $this->input->post('knowledge_focus'),
					"knowledge_care" => $this->input->post('knowledge_care'),
					"knowledge_handle" => $this->input->post('knowledge_handle'),
					"knowledge_holistic" => $this->input->post('knowledge_holistic'),
					"knowledge_item" => $this->input->post('knowledge_item'),
					"knowledge_confirm" => $this->input->post('knowledge_confirm'),
					"knowledge_security" => $this->input->post('knowledge_security'),
					"knowledge_promote" => $this->input->post('knowledge_promote'),
					"knowledge_script" => $this->input->post('knowledge_script'),
					"knowledge_question" => $this->input->post('knowledge_question'),
					"knowledge_caller" => $this->input->post('knowledge_caller'),
					"knowledge_survey" => $this->input->post('knowledge_survey'),
					"knowledge_claim" => $this->input->post('knowledge_claim'),
					"knowledge_score" => $this->input->post('knowledge_score'),
					"knowledge_earned" => $this->input->post('knowledge_earned'),
					"knowledge_possible" => $this->input->post('knowledge_possible'),
					"ia_eligibility" => $this->input->post('ia_eligibility'),
					"ia_contact" => $this->input->post('ia_contact'),
					"ia_clinical" => $this->input->post('ia_clinical'),
					"ia_amz" => $this->input->post('ia_amz'),
					"ia_emergency" => $this->input->post('ia_emergency'),
					"ia_interview" => $this->input->post('ia_interview'),
					"ia_rtw" => $this->input->post('ia_rtw'),
					"ia_call" => $this->input->post('ia_call'),
					"ia_provider" => $this->input->post('ia_provider'),
					"ia_work" => $this->input->post('ia_work'),
					"ia_leave" => $this->input->post('ia_leave'),
					"ia_note" => $this->input->post('ia_note'),
					"ia_documentation" => $this->input->post('ia_documentation'),
					"ia_specific_score" => $this->input->post('ia_specific_score'),
					"ia_specific_earned" => $this->input->post('ia_specific_earned'),
					"ia_specific_possible" => $this->input->post('ia_specific_possible'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime					
				);
				
				$a = $this->pa_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_amazon_intake_feedback',$field_array);
				redirect('Qa_amazon_intake');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function pa_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_amazon/amazon_intake/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }

        return $images;
    }
	
	
	public function mgnt_amazon_intake_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/mgnt_amazon_intake_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,109) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_intake_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["intake_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["intakeid"]=$id;
			
			$qSql="Select * FROM qa_amazon_intake_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_amazon_intake_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('intakeid'))
			{
				$intakeid=$this->input->post('intakeid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"case_no" => $this->input->post('case_no'),
					"call_id" => $this->input->post('call_id'),
					"followup_need" => $this->input->post('followup_need'),
					"emp_status" => $this->input->post('emp_status'),
					"product" => $this->input->post('product'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"call_probing" => $this->input->post('call_probing'),
					"call_solve" => $this->input->post('call_solve'),
					"call_question" => $this->input->post('call_question'),
					"call_address" => $this->input->post('call_address'),
					"call_proactive" => $this->input->post('call_proactive'),
					"call_inform" => $this->input->post('call_inform'),
					"call_csr" => $this->input->post('call_csr'),
					"call_hold" => $this->input->post('call_hold'),
					"call_permission" => $this->input->post('call_permission'),
					"call_twice" => $this->input->post('call_twice'),
					"call_listen" => $this->input->post('call_listen'),
					"call_task" => $this->input->post('call_task'),
					"call_email" => $this->input->post('call_email'),
					"call_outbound" => $this->input->post('call_outbound'),
					"call_handle_score" => $this->input->post('call_handle_score'),
					"call_handle_earned" => $this->input->post('call_handle_earned'),
					"call_handle_possible" => $this->input->post('call_handle_possible'),
					"personal_tone" => $this->input->post('personal_tone'),
					"personal_exhibit" => $this->input->post('personal_exhibit'),
					"personal_conversion" => $this->input->post('personal_conversion'),
					"personal_refrain" => $this->input->post('personal_refrain'),
					"personal_coherent" => $this->input->post('personal_coherent'),
					"personal_avoid" => $this->input->post('personal_avoid'),
					"personal_service_score" => $this->input->post('personal_service_score'),
					"personal_service_earned" => $this->input->post('personal_service_earned'),
					"personal_service_possible" => $this->input->post('personal_service_possible'),
					"knowledge_ask" => $this->input->post('knowledge_ask'),
					"knowledge_anticipate" => $this->input->post('knowledge_anticipate'),
					"knowledge_focus" => $this->input->post('knowledge_focus'),
					"knowledge_care" => $this->input->post('knowledge_care'),
					"knowledge_handle" => $this->input->post('knowledge_handle'),
					"knowledge_holistic" => $this->input->post('knowledge_holistic'),
					"knowledge_item" => $this->input->post('knowledge_item'),
					"knowledge_confirm" => $this->input->post('knowledge_confirm'),
					"knowledge_security" => $this->input->post('knowledge_security'),
					"knowledge_promote" => $this->input->post('knowledge_promote'),
					"knowledge_script" => $this->input->post('knowledge_script'),
					"knowledge_question" => $this->input->post('knowledge_question'),
					"knowledge_caller" => $this->input->post('knowledge_caller'),
					"knowledge_survey" => $this->input->post('knowledge_survey'),
					"knowledge_claim" => $this->input->post('knowledge_claim'),
					"knowledge_score" => $this->input->post('knowledge_score'),
					"knowledge_earned" => $this->input->post('knowledge_earned'),
					"knowledge_possible" => $this->input->post('knowledge_possible'),
					"ia_eligibility" => $this->input->post('ia_eligibility'),
					"ia_contact" => $this->input->post('ia_contact'),
					"ia_clinical" => $this->input->post('ia_clinical'),
					"ia_amz" => $this->input->post('ia_amz'),
					"ia_emergency" => $this->input->post('ia_emergency'),
					"ia_interview" => $this->input->post('ia_interview'),
					"ia_rtw" => $this->input->post('ia_rtw'),
					"ia_call" => $this->input->post('ia_call'),
					"ia_provider" => $this->input->post('ia_provider'),
					"ia_work" => $this->input->post('ia_work'),
					"ia_leave" => $this->input->post('ia_leave'),
					"ia_note" => $this->input->post('ia_note'),
					"ia_documentation" => $this->input->post('ia_documentation'),
					"ia_specific_score" => $this->input->post('ia_specific_score'),
					"ia_specific_earned" => $this->input->post('ia_specific_earned'),
					"ia_specific_possible" => $this->input->post('ia_specific_possible'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime	
				);
				$this->db->where('id', $intakeid);
				$this->db->update('qa_amazon_intake_feedback',$field_array);
				
			////////////
				$field_array1=array(
					"fd_id" => $intakeid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_amazon_intake_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $intakeid);
					$this->db->update('qa_amazon_intake_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_amazon_intake');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////	

	public function agent_amazon_intake_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/agent_amazon_intake_feedback.php";
			$data["agentUrl"] = "qa_amazon_intake/agent_amazon_intake_feedback";
			
			
			$qSql="Select count(id) as value from qa_amazon_intake_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_amazon_intake_feedback where id  not in (select fd_id from qa_amazon_intake_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["yet_to_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_intake_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_intake_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_amazon_intake_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				$data["agent_pa_review_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_intake_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_intake_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_amazon_intake_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_amazon_intake_agent_rvw)";
				$data["agent_pa_review_list"] = $this->Common_model->get_query_result_array($qSql);	
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_amazon_intake_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/agent_amazon_intake_feedback_rvw.php";
			$data["agentUrl"] = "qa_amazon_intake/agent_amazon_intake_feedback";
						
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_intake_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["intake_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["intakeid"]=$id;
			
			$qSql="Select * FROM qa_amazon_intake_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_amazon_intake_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('intakeid'))
			{
				$intakeid=$this->input->post('intakeid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $intakeid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_amazon_intake_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $intakeid);
					$this->db->update('qa_amazon_intake_agent_rvw',$field_array1);
				}	
				redirect('Qa_amazon_intake/agent_amazon_intake_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
//////////////////////////////////////// QA AMAZON REPORT /////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_amazon_intake_report(){
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
			$data["content_template"] = "qa_amazon_intake/qa_amazon_intake_report.php";
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			$data['pValue']=$pValue;
			
			$data["qa_amazon_list"] = array();
			
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
				
				if($pValue=='Intake'){
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, DATE_FORMAT(entry_date,'%m-%Y') AS m_Y from qa_amazon_intake_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_intake_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_amazon_intake_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
					
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_amazon_list"] = $fullAray;
					$this->create_qa_amazon_intake_CSV($fullAray,$pValue);	
					$dn_link = base_url()."qa_amazon_intake/download_qa_amazon_intake_CSV/".$pValue;
				}
				if($pValue=='Question'){
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, DATE_FORMAT(entry_date,'%m-%Y') AS m_Y from qa_amazon_question_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_question_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_amazon_question_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
					
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_amazon_list"] = $fullAray;
					$this->create_qa_amazon_intake_CSV($fullAray,$pValue);	
					$dn_link = base_url()."qa_amazon_intake/download_qa_amazon_intake_CSV/".$pValue;
				}				
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 
	
///////////////////////////Amazon Intake///////////////////////////
	public function download_qa_amazon_intake_CSV($type)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		if($type == "Intake")
		{
			$newfile="QA Amazon Intake Audit List-'".$currDate."'.csv";
		}
		else
		{
			$newfile="QA Amazon Question Audit List-'".$currDate."'.csv";
		}
		
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_amazon_intake_CSV($rr,$type)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Review week", "Case Number", "Call ID", "Audit Date", "CM/CSR/IA Name", "Agent ID", "Site", "Follow up needed?", "Ops Manager", "Auditor Name", "Employee Status", "Product", "SECTION 1: CALL HANDLING", "SECTION 2: PERSONAL SERVICE", "SECTION 3: KNOWLEDGE", "SECTION 4: IA SPECIFIC", "Asks revelvant probing questions", "Solves problems", "Answers questions", "Addresses concerns within a timely and helpful manner", "Anticipates the callers needs and is proactive", "Informs caller what to expect during the call", "How the CM/CSR handles the call and level sets expectations", "2 min max hold time with reason for hold", "Asks permission to be placed on hold", "Hold not used more than twice", "Listens to caller to determine if referral to vendor partner is required", "Sets appropriate task based on caller need", "Confirm caller email or reg mail preference for correspondence", "Follows outbound call security measures", "Tone", "Exhibits Empathy", "Conversational vs Transactional", "Refrains from use of Jargon", "Uses coherent complete and concise sentences", "Avoids slang and inappropriate topics", "Asks appropriate questions regarding the context of the call", "Anticipates the callers needs and is proactive in handling the situation", "Conversation is solution focused", "Does not hand call off to another care/case manager", "Handles and offers opinions", "Holistic Review", "Reiterates what the call was about and indicates action items", "Confirms EE understanding", "Follows best practice measures for call validation/security", "Did they promote the use of the self service portal on the call?", "Used correct closure script", "Asked if they had other questions", "Thanked caller", "Transfered to call survey if applicable", "Claim notes reflect the content of the converstation", "Provided accurate details about eligibility", "Provider Contact Information documented accurately in 360", "Clinical Information documented accurately in 360", "360 AMZ PTO task was entered when appropriate", "Obtained EE emergency contact information", "Conducted EE Interview in the employee had time", "EE was educated accurately on the RTW process", "360 EE Interview task was thoroughly documented based on the call", "360 was correctly documented if the Provider can be contacted", "360 Work Place Injury indicator selected appropriately", "360 Leave Reason was selected appropriately", "360 was documented with applicable notes related to the case", "360 leave dates were documented correctly based on callers information", "Possible Point", "Correct Point", "Incorrect Point", "Overall Score", "1 Count of Pass", "2 Count of Pass", "3 Count of Pass", "4 Count of Pass", "Review Month/Year", "Call Summary", "Feedback", "Audit Type", "VOC", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['call_probing']==1) $call_probing='Pass';
			else $call_probing=1;
			if($user['call_solve']==1) $call_solve='Pass';
			else $call_solve=1;
			if($user['call_question']==1) $call_question='Pass';
			else $call_question=1;
			if($user['call_address']==1) $call_address='Pass';
			else $call_address=1;
			if($user['call_proactive']==1) $call_proactive='Pass';
			else $call_proactive=1;
			if($user['call_inform']==1) $call_inform='Pass';
			else $call_inform=1;
			if($user['call_csr']==1) $call_csr='Pass';
			else $call_csr=1;
			if($user['call_hold']==1) $call_hold='Pass';
			else $call_hold=1;
			if($user['call_permission']==1) $call_permission='Pass';
			else $call_permission=1;
			if($user['call_twice']==1) $call_twice='Pass';
			else $call_twice=1;
			if($user['call_listen']==1) $call_listen='Pass';
			else $call_listen=1;
			if($user['call_task']==1) $call_task='Pass';
			else $call_task=1;
			if($user['call_email']==1) $call_email='Pass';
			else $call_email=1;
			if($user['call_outbound']==1) $call_outbound='Pass';
			else $call_outbound=1;
			if($user['personal_tone']==1) $personal_tone='Pass';
			else $personal_tone=1;
			if($user['personal_exhibit']==1) $personal_exhibit='Pass';
			else $personal_exhibit=1;
			if($user['personal_conversion']==1) $personal_conversion='Pass';
			else $personal_conversion=1;
			if($user['personal_refrain']==1) $personal_refrain='Pass';
			else $personal_refrain=1;
			if($user['personal_coherent']==1) $personal_coherent='Pass';
			else $personal_coherent=1;
			if($user['personal_avoid']==1) $personal_avoid='Pass';
			else $personal_avoid=1;
			if($user['knowledge_ask']==1) $knowledge_ask='Pass';
			else $knowledge_ask=1;
			if($user['knowledge_anticipate']==1) $knowledge_anticipate='Pass';
			else $knowledge_anticipate=1;
			if($user['knowledge_focus']==1) $knowledge_focus='Pass';
			else $knowledge_focus=1;
			if($user['knowledge_care']==1) $knowledge_care='Pass';
			else $knowledge_care=1;
			if($user['knowledge_handle']==1) $knowledge_handle='Pass';
			else $knowledge_handle=1;
			if($user['knowledge_holistic']==1) $knowledge_holistic='Pass';
			else $knowledge_holistic=1;
			if($user['knowledge_item']==1) $knowledge_item='Pass';
			else $knowledge_item=1;
			if($user['knowledge_confirm']==1) $knowledge_confirm='Pass';
			else $knowledge_confirm=1;
			if($user['knowledge_security']==1) $knowledge_security='Pass';
			else $knowledge_security=1;
			if($user['knowledge_promote']==1) $knowledge_promote='Pass';
			else $knowledge_promote=1;
			if($user['knowledge_script']==1) $knowledge_script='Pass';
			else $knowledge_script=1;
			if($user['knowledge_question']==1) $knowledge_question='Pass';
			else $knowledge_question=1;
			if($user['knowledge_caller']==1) $knowledge_caller='Pass';
			else $knowledge_caller=1;
			if($user['knowledge_survey']==1) $knowledge_survey='Pass';
			else $knowledge_survey=1;
			if($user['knowledge_claim']==1) $knowledge_claim='Pass';
			else $knowledge_claim=1;
			if($user['ia_eligibility']==1) $ia_eligibility='Pass';
			else $ia_eligibility=1;
			if($user['ia_contact']==1) $ia_contact='Pass';
			else $ia_contact=1;
			if($user['ia_clinical']==1) $ia_clinical='Pass';
			else $ia_clinical=1;
			if($user['ia_amz']==1) $ia_amz='Pass';
			else $ia_amz=1;
			if($user['ia_emergency']==1) $ia_emergency='Pass';
			else $ia_emergency=1;
			if($user['ia_interview']==1) $ia_interview='Pass';
			else $ia_interview=1;
			if($user['ia_rtw']==1) $ia_rtw='Pass';
			else $ia_rtw=1;
			if($user['ia_call']==1) $ia_call='Pass';
			else $ia_call=1;
			if($user['ia_provider']==1) $ia_provider='Pass';
			else $ia_provider=1;
			if($user['ia_work']==1) $ia_work='Pass';
			else $ia_work=1;
			if($user['ia_leave']==1) $ia_leave='Pass';
			else $ia_leave=1;
			if($user['ia_note']==1) $ia_note='Pass';
			else $ia_note=1;
			if($user['ia_documentation']==1) $ia_documentation='Pass';
			else $ia_documentation=1;
			
			$dateString = $user['audit_date'];
			  list($year, $month, $mday) = explode("-", $dateString);
			  $firstWday = date("w",strtotime("$year-$month-1"));
			  $week = floor(($mday + $firstWday - 1)/7) + 1;
			
			$incorrect_score = ($user['possible_score'] - $user['earned_score']);
			$call_handle = ($user['call_handle_possible'] - $user['call_handle_earned']);
			$personal_service = ($user['personal_service_possible'] - $user['personal_service_earned']);
			$knowledge = ($user['knowledge_possible'] - $user['knowledge_earned']);
			$ia_specific = ($user['ia_specific_possible'] - $user['ia_specific_earned']);
			
			$row = '"'.$week.'",';
			$row .= '"'.$user['case_no'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['office_id'].'",';
			$row .= '"'.$user['followup_need'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['emp_status'].'",';
			$row .= '"'.$user['product'].'",';
			$row .= '"'.$user['call_handle_score'].'",';
			$row .= '"'.$user['personal_service_score'].'",';
			$row .= '"'.$user['knowledge_score'].'",';
			$row .= '"'.$user['ia_specific_score'].'",';
			$row .= '"'.$call_probing.'",';
			$row .= '"'.$call_solve.'",';
			$row .= '"'.$call_question.'",';
			$row .= '"'.$call_address.'",';
			$row .= '"'.$call_proactive.'",';
			$row .= '"'.$call_inform.'",';
			$row .= '"'.$call_csr.'",';
			$row .= '"'.$call_hold.'",';
			$row .= '"'.$call_permission.'",';
			$row .= '"'.$call_twice.'",';
			$row .= '"'.$call_listen.'",';
			$row .= '"'.$call_task.'",';
			$row .= '"'.$call_email.'",';
			$row .= '"'.$call_outbound.'",';
			$row .= '"'.$personal_tone.'",';
			$row .= '"'.$personal_exhibit.'",';
			$row .= '"'.$personal_conversion.'",';
			$row .= '"'.$personal_refrain.'",';
			$row .= '"'.$personal_coherent.'",';
			$row .= '"'.$personal_avoid.'",';
			$row .= '"'.$knowledge_ask.'",';
			$row .= '"'.$knowledge_anticipate.'",';
			$row .= '"'.$knowledge_focus.'",';
			$row .= '"'.$knowledge_care.'",';
			$row .= '"'.$knowledge_handle.'",';
			$row .= '"'.$knowledge_holistic.'",';
			$row .= '"'.$knowledge_item.'",';
			$row .= '"'.$knowledge_confirm.'",';
			$row .= '"'.$knowledge_security.'",';
			$row .= '"'.$knowledge_promote.'",';
			$row .= '"'.$knowledge_script.'",';
			$row .= '"'.$knowledge_question.'",';
			$row .= '"'.$knowledge_caller.'",';
			$row .= '"'.$knowledge_survey.'",';
			$row .= '"'.$knowledge_claim.'",';
			$row .= '"'.$ia_eligibility.'",';
			$row .= '"'.$ia_contact.'",';
			$row .= '"'.$ia_clinical.'",';
			$row .= '"'.$ia_amz.'",';
			$row .= '"'.$ia_emergency.'",';
			$row .= '"'.$ia_interview.'",';
			$row .= '"'.$ia_rtw.'",';
			$row .= '"'.$ia_call.'",';
			$row .= '"'.$ia_provider.'",';
			$row .= '"'.$ia_work.'",';
			$row .= '"'.$ia_leave.'",';
			$row .= '"'.$ia_note.'",';
			$row .= '"'.$ia_documentation.'",';
			$row .= '"'.$user['possible_score'].'",'; 
			$row .= '"'.$user['earned_score'].'",';  
			$row .= '"'.$incorrect_score.'",'; 
			$row .= '"'.$user['overall_score']."%".'",';
			$row .= '"'.$call_handle.'",';
			$row .= '"'.$personal_service.'",';
			$row .= '"'.$knowledge.'",';
			$row .= '"'.$ia_specific.'",';
			$row .= '"'.$user['m_Y'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
/*****************************************************************************************/	
/***********************************Amazon Question **************************************/
/*****************************************************************************************/
	public function qa_amazon_question()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/qa_question_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,109) and status=1  order by name";
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
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_question_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_question_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_amazon_question_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["amazon_question_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function question_add_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/question_add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,109) and status=1  order by name";
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
					"case_no" => $this->input->post('case_no'),
					"call_id" => $this->input->post('call_id'),
					"followup_need" => $this->input->post('followup_need'),
					"emp_status" => $this->input->post('emp_status'),
					"product" => $this->input->post('product'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"call_probing" => $this->input->post('call_probing'),
					"call_solve" => $this->input->post('call_solve'),
					"call_question" => $this->input->post('call_question'),
					"call_address" => $this->input->post('call_address'),
					"call_proactive" => $this->input->post('call_proactive'),
					"call_inform" => $this->input->post('call_inform'),
					"call_csr" => $this->input->post('call_csr'),
					"call_hold" => $this->input->post('call_hold'),
					"call_permission" => $this->input->post('call_permission'),
					"call_twice" => $this->input->post('call_twice'),
					"call_listen" => $this->input->post('call_listen'),
					"call_task" => $this->input->post('call_task'),
					"call_email" => $this->input->post('call_email'),
					"call_outbound" => $this->input->post('call_outbound'),
					"call_handle_score" => $this->input->post('call_handle_score'),
					"call_handle_earned" => $this->input->post('call_handle_earned'),
					"call_handle_possible" => $this->input->post('call_handle_possible'),
					"personal_tone" => $this->input->post('personal_tone'),
					"personal_exhibit" => $this->input->post('personal_exhibit'),
					"personal_conversion" => $this->input->post('personal_conversion'),
					"personal_refrain" => $this->input->post('personal_refrain'),
					"personal_coherent" => $this->input->post('personal_coherent'),
					"personal_avoid" => $this->input->post('personal_avoid'),
					"personal_service_score" => $this->input->post('personal_service_score'),
					"personal_service_earned" => $this->input->post('personal_service_earned'),
					"personal_service_possible" => $this->input->post('personal_service_possible'),
					"knowledge_ask" => $this->input->post('knowledge_ask'),
					"knowledge_anticipate" => $this->input->post('knowledge_anticipate'),
					"knowledge_focus" => $this->input->post('knowledge_focus'),
					"knowledge_care" => $this->input->post('knowledge_care'),
					"knowledge_handle" => $this->input->post('knowledge_handle'),
					"knowledge_holistic" => $this->input->post('knowledge_holistic'),
					"knowledge_item" => $this->input->post('knowledge_item'),
					"knowledge_confirm" => $this->input->post('knowledge_confirm'),
					"knowledge_security" => $this->input->post('knowledge_security'),
					"knowledge_promote" => $this->input->post('knowledge_promote'),
					"knowledge_script" => $this->input->post('knowledge_script'),
					"knowledge_question" => $this->input->post('knowledge_question'),
					"knowledge_caller" => $this->input->post('knowledge_caller'),
					"knowledge_survey" => $this->input->post('knowledge_survey'),
					"knowledge_claim" => $this->input->post('knowledge_claim'),
					"knowledge_score" => $this->input->post('knowledge_score'),
					"knowledge_earned" => $this->input->post('knowledge_earned'),
					"knowledge_possible" => $this->input->post('knowledge_possible'),
					"ia_eligibility" => $this->input->post('ia_eligibility'),
					"ia_contact" => $this->input->post('ia_contact'),
					"ia_clinical" => $this->input->post('ia_clinical'),
					"ia_amz" => $this->input->post('ia_amz'),
					"ia_emergency" => $this->input->post('ia_emergency'),
					"ia_interview" => $this->input->post('ia_interview'),
					"ia_rtw" => $this->input->post('ia_rtw'),
					"ia_call" => $this->input->post('ia_call'),
					"ia_provider" => $this->input->post('ia_provider'),
					"ia_work" => $this->input->post('ia_work'),
					"ia_leave" => $this->input->post('ia_leave'),
					"ia_note" => $this->input->post('ia_note'),
					"ia_documentation" => $this->input->post('ia_documentation'),
					"ia_specific_score" => $this->input->post('ia_specific_score'),
					"ia_specific_earned" => $this->input->post('ia_specific_earned'),
					"ia_specific_possible" => $this->input->post('ia_specific_possible'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime					
				);
				
				$a = $this->pa_question_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_amazon_question_feedback',$field_array);
				redirect('Qa_amazon_intake/qa_amazon_question');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	private function pa_question_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_amazon/amazon_question/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }

        return $images;
    }
	
	public function mgnt_amazon_question_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/mgnt_amazon_question_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,109) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_question_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["question_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["questionid"]=$id;
			
			$qSql="Select * FROM qa_amazon_question_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_amazon_question_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('questionid'))
			{
				$questionid=$this->input->post('questionid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"case_no" => $this->input->post('case_no'),
					"call_id" => $this->input->post('call_id'),
					"followup_need" => $this->input->post('followup_need'),
					"emp_status" => $this->input->post('emp_status'),
					"product" => $this->input->post('product'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"call_probing" => $this->input->post('call_probing'),
					"call_solve" => $this->input->post('call_solve'),
					"call_question" => $this->input->post('call_question'),
					"call_address" => $this->input->post('call_address'),
					"call_proactive" => $this->input->post('call_proactive'),
					"call_inform" => $this->input->post('call_inform'),
					"call_csr" => $this->input->post('call_csr'),
					"call_hold" => $this->input->post('call_hold'),
					"call_permission" => $this->input->post('call_permission'),
					"call_twice" => $this->input->post('call_twice'),
					"call_listen" => $this->input->post('call_listen'),
					"call_task" => $this->input->post('call_task'),
					"call_email" => $this->input->post('call_email'),
					"call_outbound" => $this->input->post('call_outbound'),
					"call_handle_score" => $this->input->post('call_handle_score'),
					"call_handle_earned" => $this->input->post('call_handle_earned'),
					"call_handle_possible" => $this->input->post('call_handle_possible'),
					"personal_tone" => $this->input->post('personal_tone'),
					"personal_exhibit" => $this->input->post('personal_exhibit'),
					"personal_conversion" => $this->input->post('personal_conversion'),
					"personal_refrain" => $this->input->post('personal_refrain'),
					"personal_coherent" => $this->input->post('personal_coherent'),
					"personal_avoid" => $this->input->post('personal_avoid'),
					"personal_service_score" => $this->input->post('personal_service_score'),
					"personal_service_earned" => $this->input->post('personal_service_earned'),
					"personal_service_possible" => $this->input->post('personal_service_possible'),
					"knowledge_ask" => $this->input->post('knowledge_ask'),
					"knowledge_anticipate" => $this->input->post('knowledge_anticipate'),
					"knowledge_focus" => $this->input->post('knowledge_focus'),
					"knowledge_care" => $this->input->post('knowledge_care'),
					"knowledge_handle" => $this->input->post('knowledge_handle'),
					"knowledge_holistic" => $this->input->post('knowledge_holistic'),
					"knowledge_item" => $this->input->post('knowledge_item'),
					"knowledge_confirm" => $this->input->post('knowledge_confirm'),
					"knowledge_security" => $this->input->post('knowledge_security'),
					"knowledge_promote" => $this->input->post('knowledge_promote'),
					"knowledge_script" => $this->input->post('knowledge_script'),
					"knowledge_question" => $this->input->post('knowledge_question'),
					"knowledge_caller" => $this->input->post('knowledge_caller'),
					"knowledge_survey" => $this->input->post('knowledge_survey'),
					"knowledge_claim" => $this->input->post('knowledge_claim'),
					"knowledge_score" => $this->input->post('knowledge_score'),
					"knowledge_earned" => $this->input->post('knowledge_earned'),
					"knowledge_possible" => $this->input->post('knowledge_possible'),
					"ia_eligibility" => $this->input->post('ia_eligibility'),
					"ia_contact" => $this->input->post('ia_contact'),
					"ia_clinical" => $this->input->post('ia_clinical'),
					"ia_amz" => $this->input->post('ia_amz'),
					"ia_emergency" => $this->input->post('ia_emergency'),
					"ia_interview" => $this->input->post('ia_interview'),
					"ia_rtw" => $this->input->post('ia_rtw'),
					"ia_call" => $this->input->post('ia_call'),
					"ia_provider" => $this->input->post('ia_provider'),
					"ia_work" => $this->input->post('ia_work'),
					"ia_leave" => $this->input->post('ia_leave'),
					"ia_note" => $this->input->post('ia_note'),
					"ia_documentation" => $this->input->post('ia_documentation'),
					"ia_specific_score" => $this->input->post('ia_specific_score'),
					"ia_specific_earned" => $this->input->post('ia_specific_earned'),
					"ia_specific_possible" => $this->input->post('ia_specific_possible'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime	
				);
				$this->db->where('id', $questionid);
				$this->db->update('qa_amazon_question_feedback',$field_array);
				
			////////////
				$field_array1=array(
					"fd_id" => $questionid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_amazon_question_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $questionid);
					$this->db->update('qa_amazon_question_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_amazon_intake/qa_amazon_question');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	/////////////////////////Agent part/////////////////////////////////	

	public function agent_amazon_question_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/agent_amazon_question_feedback.php";
			$data["agentUrl"] = "qa_amazon_intake/agent_amazon_question_feedback";
			
			
			$qSql="Select count(id) as value from qa_amazon_question_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_amazon_question_feedback where id  not in (select fd_id from qa_amazon_question_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["yet_to_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_question_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_question_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_amazon_question_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				$data["agent_pa_review_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_question_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_amazon_question_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_amazon_question_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_amazon_question_agent_rvw)";
				$data["agent_pa_review_list"] = $this->Common_model->get_query_result_array($qSql);	
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function agent_amazon_question_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_amazon_intake/agent_amazon_question_feedback_rvw.php";
			$data["agentUrl"] = "qa_amazon_intake/agent_amazon_question_feedback";
						
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amazon_question_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["question_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["questionid"]=$id;
			
			$qSql="Select * FROM qa_amazon_question_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_amazon_question_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('questionid'))
			{
				$intakeid=$this->input->post('questionid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $intakeid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_amazon_question_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $intakeid);
					$this->db->update('qa_amazon_question_agent_rvw',$field_array1);
				}	
				redirect('Qa_amazon_intake/agent_amazon_question_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

 }