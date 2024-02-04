<?php 

 class Qa_rugdoctor extends CI_Controller{
	
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
			$data["content_template"] = "qa_rugdoctor/qa_rugdoctor_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,47) and is_assign_process (id,59) and status=1  order by name";
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_rugdoctor_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_rugdoctor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_rugdoctor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_rugdoctor_data"] = $this->Common_model->get_query_result_array($qSql);			
			
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
			$data["content_template"] = "qa_rugdoctor/add_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,47) and is_assign_process (id,59) and status=1  order by name";
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
					"phone" => $this->input->post('phone'),
					"call_duration" => $this->input->post('call_duration'),
					"customer_name" => $this->input->post('customer_name'),
					"issue" => $this->input->post('issue'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"point_earned" => $this->input->post('point_earned'),
					"rdCustomerErnd" => $this->input->post('rdCustomerErnd'),
					"rdBusinessErnd" => $this->input->post('rdBusinessErnd'),
					"rdComplianceErnd" => $this->input->post('rdComplianceErnd'),
					"rdCustomerPsbl" => $this->input->post('rdCustomerPsbl'),
					"rdBusinessPsbl" => $this->input->post('rdBusinessPsbl'),
					"rdCompliancePsbl" => $this->input->post('rdCompliancePsbl'),
					"rdCustomerTotal" => $this->input->post('rdCustomerTotal'),
					"rdBusinessTotal" => $this->input->post('rdBusinessTotal'),
					"rdComplianceTotal" => $this->input->post('rdComplianceTotal'),
					"greeting_caller" => $this->input->post('greeting_caller'),
					"greeting_caller_comment" => $this->input->post('greeting_caller_comment'),
					"verification_confirm" => $this->input->post('verification_confirm'),
					"verification_confirm_comment" => $this->input->post('verification_confirm_comment'),
					"verification_request" => $this->input->post('verification_request'),
					"verification_request_comment" => $this->input->post('verification_request_comment'),
					"discovery_identity" => $this->input->post('discovery_identity'),
					"discovery_identity_comment" => $this->input->post('discovery_identity_comment'),
					"discovery_demo" => $this->input->post('discovery_demo'),
					"discovery_demo_comment" => $this->input->post('discovery_demo_comment'),
					"customer_maintain" => $this->input->post('customer_maintain'),
					"customer_maintain_comment" => $this->input->post('customer_maintain_comment'),
					"customer_word" => $this->input->post('customer_word'),
					"customer_word_comment" => $this->input->post('customer_word_comment'),
					"customer_treat" => $this->input->post('customer_treat'),
					"customer_treat_comment" => $this->input->post('customer_treat_comment'),
					"customer_avoid" => $this->input->post('customer_avoid'),
					"customer_avoid_comment" => $this->input->post('customer_avoid_comment'),
					"customer_follow" => $this->input->post('customer_follow'),
					"customer_follow_comment" => $this->input->post('customer_follow_comment'),
					"customer_accurate" => $this->input->post('customer_accurate'),
					"customer_accurate_comment" => $this->input->post('customer_accurate_comment'),
					"skill_demo" => $this->input->post('skill_demo'),
					"skill_demo_comment" => $this->input->post('skill_demo_comment'),
					"resolution_provide" => $this->input->post('resolution_provide'),
					"resolution_provide_comment" => $this->input->post('resolution_provide_comment'),
					"resolution_accurate" => $this->input->post('resolution_accurate'),
					"resolution_accurate_comment" => $this->input->post('resolution_accurate_comment'),
					"resolution_resolve" => $this->input->post('resolution_resolve'),
					"resolution_resolve_comment" => $this->input->post('resolution_resolve_comment'),
					"closing_offer" => $this->input->post('closing_offer'),
					"closing_offer_comment" => $this->input->post('closing_offer_comment'),
					"closing_summarize" => $this->input->post('closing_summarize'),
					"closing_summarize_comment" => $this->input->post('closing_summarize_comment'),
					"closing_educate" => $this->input->post('closing_educate'),
					"closing_educate_comment" => $this->input->post('closing_educate_comment'),
					"closing_thank" => $this->input->post('closing_thank'),
					"closing_thank_comment" => $this->input->post('closing_thank_comment'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				$a = $this->rd_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_rugdoctor_feedback',$field_array);
				redirect('Qa_rugdoctor');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function rd_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_rugdoctor/';
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
				
            } else {
                return false;
            }
        }
        return $images;
    }
	
	
	public function mgnt_rugdoctor_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rugdoctor/mgnt_rugdoctor_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,47) and is_assign_process (id,59) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_rugdoctor_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["rd_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["rdid"]=$id;
			
			$qSql="Select * FROM qa_rugdoctor_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_rugdoctor_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);;//MGNT PURPOSE
			
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('rd_id'))
			{
				$rd_id=$this->input->post('rd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"call_duration" => $this->input->post('call_duration'),
					"customer_name" => $this->input->post('customer_name'),
					"issue" => $this->input->post('issue'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"point_earned" => $this->input->post('point_earned'),
					"rdCustomerErnd" => $this->input->post('rdCustomerErnd'),
					"rdBusinessErnd" => $this->input->post('rdBusinessErnd'),
					"rdComplianceErnd" => $this->input->post('rdComplianceErnd'),
					"rdCustomerPsbl" => $this->input->post('rdCustomerPsbl'),
					"rdBusinessPsbl" => $this->input->post('rdBusinessPsbl'),
					"rdCompliancePsbl" => $this->input->post('rdCompliancePsbl'),
					"rdCustomerTotal" => $this->input->post('rdCustomerTotal'),
					"rdBusinessTotal" => $this->input->post('rdBusinessTotal'),
					"rdComplianceTotal" => $this->input->post('rdComplianceTotal'),
					"greeting_caller" => $this->input->post('greeting_caller'),
					"greeting_caller_comment" => $this->input->post('greeting_caller_comment'),
					"verification_confirm" => $this->input->post('verification_confirm'),
					"verification_confirm_comment" => $this->input->post('verification_confirm_comment'),
					"verification_request" => $this->input->post('verification_request'),
					"verification_request_comment" => $this->input->post('verification_request_comment'),
					"discovery_identity" => $this->input->post('discovery_identity'),
					"discovery_identity_comment" => $this->input->post('discovery_identity_comment'),
					"discovery_demo" => $this->input->post('discovery_demo'),
					"discovery_demo_comment" => $this->input->post('discovery_demo_comment'),
					"customer_maintain" => $this->input->post('customer_maintain'),
					"customer_maintain_comment" => $this->input->post('customer_maintain_comment'),
					"customer_word" => $this->input->post('customer_word'),
					"customer_word_comment" => $this->input->post('customer_word_comment'),
					"customer_treat" => $this->input->post('customer_treat'),
					"customer_treat_comment" => $this->input->post('customer_treat_comment'),
					"customer_avoid" => $this->input->post('customer_avoid'),
					"customer_avoid_comment" => $this->input->post('customer_avoid_comment'),
					"customer_follow" => $this->input->post('customer_follow'),
					"customer_follow_comment" => $this->input->post('customer_follow_comment'),
					"customer_accurate" => $this->input->post('customer_accurate'),
					"customer_accurate_comment" => $this->input->post('customer_accurate_comment'),
					"skill_demo" => $this->input->post('skill_demo'),
					"skill_demo_comment" => $this->input->post('skill_demo_comment'),
					"resolution_provide" => $this->input->post('resolution_provide'),
					"resolution_provide_comment" => $this->input->post('resolution_provide_comment'),
					"resolution_accurate" => $this->input->post('resolution_accurate'),
					"resolution_accurate_comment" => $this->input->post('resolution_accurate_comment'),
					"resolution_resolve" => $this->input->post('resolution_resolve'),
					"resolution_resolve_comment" => $this->input->post('resolution_resolve_comment'),
					"closing_offer" => $this->input->post('closing_offer'),
					"closing_offer_comment" => $this->input->post('closing_offer_comment'),
					"closing_summarize" => $this->input->post('closing_summarize'),
					"closing_summarize_comment" => $this->input->post('closing_summarize_comment'),
					"closing_educate" => $this->input->post('closing_educate'),
					"closing_educate_comment" => $this->input->post('closing_educate_comment'),
					"closing_thank" => $this->input->post('closing_thank'),
					"closing_thank_comment" => $this->input->post('closing_thank_comment'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->rd_upload_files($_FILES['attach_file']);
					$field_array['attach_file'] = implode(',',$a);
				}
				
				$this->db->where('id', $rd_id);
				$this->db->update('qa_rugdoctor_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $rd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_rugdoctor_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rd_id);
					$this->db->update('qa_rugdoctor_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_rugdoctor');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			$data["array"] = $a;
		}
	}
	
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

/////////////////RugDoctor Agent part//////////////////////////	

	public function agent_rugdoctor_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rugdoctor/agent_rugdoctor_feedback.php";
			$data["agentUrl"] = "qa_rugdoctor/agent_rugdoctor_feedback";
			
			
			$qSql="Select count(id) as value from qa_rugdoctor_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_rugdoctor_feedback where id  not in (select fd_id from qa_rugdoctor_agent_rvw) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_rugdoctor_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_rugdoctor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_rugdoctor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";

				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
				
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_rugdoctor_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_rugdoctor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_rugdoctor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_rugdoctor_agent_rvw)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);		
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_rugdoctor_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rugdoctor/agent_rugdoctor_feedback_rvw.php";
			$data["agentUrl"] = "qa_rugdoctor/agent_rugdoctor_feedback";
						
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_rugdoctor_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["rd_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["rdid"]=$id;
			
			$qSql="Select * FROM qa_rugdoctor_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_rugdoctor_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);;//MGNT PURPOSE
			
		
			if($this->input->post('rd_id'))
			{
				$rd_id=$this->input->post('rd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $rd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_rugdoctor_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rd_id);
					$this->db->update('qa_rugdoctor_agent_rvw',$field_array1);
				}	
				redirect('Qa_rugdoctor/agent_rugdoctor_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA RugDoctor REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_rugdoctor_report(){
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
			$data["content_template"] = "qa_rugdoctor/qa_rugdoctor_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			$office_id = $this->input->get('office_id');
			$audit_type = $this->input->get('audit_type');
			
			if($date_from==""){ 
				$date_from=CurrDate();
			}else{
				$date_from = mmddyy2mysql($date_from);
			}
			
			if($date_to==""){ 
				$date_to=CurrDate();
			}else{
				$date_to = mmddyy2mysql($date_to);
			}
			
			$data["qa_rugdoctor_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
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
		
			
				$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_rugdoctor_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_rugdoctor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_rugdoctor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_rugdoctor_list"] = $fullAray;
				$this->create_qa_rugdoctor_CSV($fullAray);	
				$dn_link = base_url()."qa_rugdoctor/download_qa_rugdoctor_CSV";
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
	 

	public function download_qa_rugdoctor_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA RugDoctor Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_rugdoctor_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Phone", "Call Duration", "Customer Name", "Issue", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Greet the caller by Thanking them for the call?", "Comment", "Confirm the customer's identity?", "Comment", "Request for machine serial number?", "Comment", "Identify the correct reason the customer is calling?", "Comment", "Demonstrate active listening skills?", "Comment", "Maintain control of the call?", "Comment", "Words and tone of voice communicates confidence and assurance?", "Comment", "Treat the caller with care?", "Comment", "Avoid long periods of silence?", "Comment", "Follow the correct procedures for telephone handling?", "Comment", "Accurately communicate during the interaction?", "Comment", "Demonstrate efficient and effective use of all systems to handle the call?", "Comment", "Provide correct/complete information based on policies and procedures?", "Comment", "Accurately document the call?", "Comment", "Resolve the customers reason for calling to the extent possible during the interaction?", "Comment", "Offer to provide the customer with their ticket number?", "Comment", "Summarize action taken and ask the customer if there is anything else they need help with?", "Comment", "Educate the customer on self-help options for the future?", "Comment", "Thank the caller for calling?", "Comment", "Overall Score", "Earned Score", "Customer Critical", "Business Critical", "Compliance Critical", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['greeting_caller']==1) $greeting_caller='Yes';
			else $greeting_caller='No';
			
			if($user['verification_confirm']==2) $verification_confirm='Yes';
			else $verification_confirm='No';
			
			if($user['verification_request']==2) $verification_request='Yes';
			else $verification_request='No';
			
			if($user['discovery_identity']==4) $discovery_identity='Yes';
			else $discovery_identity='No';
			
			if($user['discovery_demo']==1) $discovery_demo='Yes';
			else $discovery_demo='No';
			
			if($user['customer_maintain']==2) $customer_maintain='Yes';
			else $customer_maintain='No';
			
			if($user['customer_word']==3) $customer_word='Yes';
			else $customer_word='No';
			
			if($user['customer_treat']==4) $customer_treat='Yes';
			else $customer_treat='No';
			
			if($user['customer_avoid']==1) $customer_avoid='Yes';
			else $customer_avoid='No';
			
			if($user['customer_follow']==1) $customer_follow='Yes';
			else $customer_follow='No';
			
			if($user['customer_accurate']==1) $customer_accurate='Yes';
			else $customer_accurate='No';
			
			if($user['skill_demo']==2) $skill_demo='Yes';
			else $skill_demo='No';
			
			if($user['resolution_provide']==5) $resolution_provide='Yes';
			else $resolution_provide='No';
			
			if($user['resolution_accurate']==4) $resolution_accurate='Yes';
			else $resolution_accurate='No';
			
			if($user['resolution_resolve']==5) $resolution_resolve='Yes';
			else $resolution_resolve='No';
			
			if($user['closing_offer']==1) $closing_offer='Yes';
			else $closing_offer='No';
			
			if($user['closing_summarize']==1) $closing_summarize='Yes';
			else $closing_summarize='No';
			
			if($user['closing_educate']==1) $closing_educate='Yes';
			else $closing_educate='No';
			
			if($user['closing_thank']==1) $closing_thank='Yes';
			else $closing_thank='No';
			
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['customer_name'].'",';
			$row .= '"'.$user['issue'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$greeting_caller.'",';
			$row .= '"'.$user['greeting_caller_comment'].'",';
			$row .= '"'.$verification_confirm.'",';
			$row .= '"'.$user['verification_confirm_comment'].'",';
			$row .= '"'.$verification_request.'",';
			$row .= '"'.$user['verification_request_comment'].'",';
			$row .= '"'.$discovery_identity.'",';
			$row .= '"'.$user['discovery_identity_comment'].'",';
			$row .= '"'.$discovery_demo.'",';
			$row .= '"'.$user['discovery_demo_comment'].'",';
			$row .= '"'.$customer_maintain.'",';
			$row .= '"'.$user['customer_maintain_comment'].'",';
			$row .= '"'.$customer_word.'",';
			$row .= '"'.$user['customer_word_comment'].'",';
			$row .= '"'.$customer_treat.'",';
			$row .= '"'.$user['customer_treat_comment'].'",';
			$row .= '"'.$customer_avoid.'",';
			$row .= '"'.$user['customer_avoid_comment'].'",';
			$row .= '"'.$customer_follow.'",';
			$row .= '"'.$user['customer_follow_comment'].'",';
			$row .= '"'.$customer_accurate.'",';
			$row .= '"'.$user['customer_accurate_comment'].'",';
			$row .= '"'.$skill_demo.'",';
			$row .= '"'.$user['skill_demo_comment'].'",';
			$row .= '"'.$resolution_provide.'",';
			$row .= '"'.$user['resolution_provide_comment'].'",';
			$row .= '"'.$resolution_accurate.'",';
			$row .= '"'.$user['resolution_accurate_comment'].'",';
			$row .= '"'.$resolution_resolve.'",';
			$row .= '"'.$user['resolution_resolve_comment'].'",';
			$row .= '"'.$closing_offer.'",';
			$row .= '"'.$user['closing_offer_comment'].'",';
			$row .= '"'.$closing_summarize.'",';
			$row .= '"'.$user['closing_summarize_comment'].'",';
			$row .= '"'.$closing_educate.'",';
			$row .= '"'.$user['closing_educate_comment'].'",';
			$row .= '"'.$closing_thank.'",';
			$row .= '"'.$user['closing_thank_comment'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['point_earned'].'",'; 
			$row .= '"'.$user['rdCustomerTotal'].'",'; 
			$row .= '"'.$user['rdBusinessTotal'].'",'; 
			$row .= '"'.$user['rdComplianceTotal'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	

	
 }