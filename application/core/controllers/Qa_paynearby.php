<?php 

 class Qa_paynearby extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	private function pnb_upload_files($files,$path){
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
				
				
            } else {
                return false;
            }
        }
        return $images;
    }
	 
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/qa_paynearby_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and is_assign_process(id,220) and status=1  order by name";
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_paynearby_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_paynearby_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_paynearby_data"] = $this->Common_model->get_query_result_array($qSql);
			
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
			$data["content_template"] = "qa_paynearby/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,115) and is_assign_process(id,220) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('call_date')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer" => $this->input->post('customer'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"grade" => $this->input->post('grade'),
					"overall_score" => $this->input->post('overall_score'),
					"opening_greeting" => $this->input->post('opening_greeting'),
					"initial_empathy" => $this->input->post('initial_empathy'),
					"agent_query" => $this->input->post('agent_query'),
					"proper_telephone" => $this->input->post('proper_telephone'),
					"ivr_promotion" => $this->input->post('ivr_promotion'),
					"efective_rebuttal" => $this->input->post('efective_rebuttal'),
					"fraud_alert" => $this->input->post('fraud_alert'),
					"sentence_acknowledge" => $this->input->post('sentence_acknowledge'),
					"polite_call" => $this->input->post('polite_call'),
					"good_behaviour" => $this->input->post('good_behaviour'),
					"good_listening" => $this->input->post('good_listening'),
					"not_interrupt" => $this->input->post('not_interrupt'),
					"proper_empathy" => $this->input->post('proper_empathy'),
					"proper_pace" => $this->input->post('proper_pace'),
					"agent_patience" => $this->input->post('agent_patience'),
					"energy_enthusias" => $this->input->post('energy_enthusias'),
					"confident_level" => $this->input->post('confident_level'),
					"error_fumbling" => $this->input->post('error_fumbling'),
					"dead_air" => $this->input->post('dead_air'),
					"dragged_call" => $this->input->post('dragged_call'),
					"rude_language" => $this->input->post('rude_language'),
					"exact_tat" => $this->input->post('exact_tat'),
					"wrong_provide" => $this->input->post('wrong_provide'),
					"correct_tagging" => $this->input->post('correct_tagging'),
					"minor_error" => $this->input->post('minor_error'),
					"satisfy_rapport" => $this->input->post('satisfy_rapport'),
					"closing_script" => $this->input->post('closing_script'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				$a = $this->pnb_upload_files($_FILES['attach_file'],$path='./qa_files/qa_paynearby/');
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_paynearby_feedback',$field_array);
				redirect('Qa_paynearby');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_paynearby_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/mgnt_paynearby_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and is_assign_process(id,220) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["paynearby_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			$qSql="Select * FROM qa_paynearby_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_paynearby_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer" => $this->input->post('customer'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"grade" => $this->input->post('grade'),
					"overall_score" => $this->input->post('overall_score'),
					"opening_greeting" => $this->input->post('opening_greeting'),
					"initial_empathy" => $this->input->post('initial_empathy'),
					"agent_query" => $this->input->post('agent_query'),
					"proper_telephone" => $this->input->post('proper_telephone'),
					"ivr_promotion" => $this->input->post('ivr_promotion'),
					"efective_rebuttal" => $this->input->post('efective_rebuttal'),
					"fraud_alert" => $this->input->post('fraud_alert'),
					"sentence_acknowledge" => $this->input->post('sentence_acknowledge'),
					"polite_call" => $this->input->post('polite_call'),
					"good_behaviour" => $this->input->post('good_behaviour'),
					"good_listening" => $this->input->post('good_listening'),
					"not_interrupt" => $this->input->post('not_interrupt'),
					"proper_empathy" => $this->input->post('proper_empathy'),
					"proper_pace" => $this->input->post('proper_pace'),
					"agent_patience" => $this->input->post('agent_patience'),
					"energy_enthusias" => $this->input->post('energy_enthusias'),
					"confident_level" => $this->input->post('confident_level'),
					"error_fumbling" => $this->input->post('error_fumbling'),
					"dead_air" => $this->input->post('dead_air'),
					"dragged_call" => $this->input->post('dragged_call'),
					"rude_language" => $this->input->post('rude_language'),
					"exact_tat" => $this->input->post('exact_tat'),
					"wrong_provide" => $this->input->post('wrong_provide'),
					"correct_tagging" => $this->input->post('correct_tagging'),
					"minor_error" => $this->input->post('minor_error'),
					"satisfy_rapport" => $this->input->post('satisfy_rapport'),
					"closing_script" => $this->input->post('closing_script'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_paynearby_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $pnid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_paynearby_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pnid);
					$this->db->update('qa_paynearby_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_paynearby');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////	

	public function agent_paynearby_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/agent_paynearby_feedback.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";
			
			
			$qSql="Select count(id) as value from qa_paynearby_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_paynearby_feedback where id not in (select fd_id from qa_paynearby_agent_rvw) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign!=''){
				if($this->input->get('btnView')=='View'){
					
					if($campaign=='inbound'){
						$qSql1="Select count(id) as value from qa_paynearby_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_feedback where id not in (select fd_id from qa_paynearby_agent_rvw) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else{
						$qSql1="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}
					$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
					$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);
					
				///////////
					
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate !="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else{
						$cond= " Where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}
					
					
					if($campaign=='inbound'){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, agnt_fd_acpt, note as agent_rvw_note, date(entry_date) as agent_rvw_date from qa_paynearby_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_rvw_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_rvw_name from qa_paynearby_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
					}else{
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($agnt_fd);
					
				}
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_paynearby_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/agent_paynearby_rvw.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["paynearby_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			$qSql="Select * FROM qa_paynearby_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_paynearby_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $pnid,
					"note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_paynearby_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pnid);
					$this->db->update('qa_paynearby_agent_rvw',$field_array1);
				}	
				redirect('Qa_paynearby/agent_paynearby_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_paynearby_ob_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/agent_paynearby_ob_rvw.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data["campaign"]=$campaign;
			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_paynearby_'.$campaign.'_feedback',$field_array);
				
				redirect('qa_paynearby/agent_paynearby_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////// OUTBOUND //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function paynearby_outbound(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/qa_paynearby_outbound_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and is_assign_process(id,220)=0 and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_sales_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_ob_sales"] = $this->Common_model->get_query_result_array($qSql);
		//////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_service_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_ob_service"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_ob_sales($sales_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_ob_sales.php";
			$data['sales_id']=$sales_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and is_assign_process(id,220)=0 and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_sales_feedback where id='$sales_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ob_sales"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"customer" => $this->input->post('customer'),
					"call_duration" => $this->input->post('call_duration'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"standart_call_opening" => $this->input->post('standart_call_opening'),
					"explain_about_product" => $this->input->post('explain_about_product'),
					"correct_tagging" => $this->input->post('correct_tagging'),
					"necessary_probing" => $this->input->post('necessary_probing'),
					"sales_picher" => $this->input->post('sales_picher'),
					"active_listening" => $this->input->post('active_listening'),
					"assurance_acknowledge" => $this->input->post('assurance_acknowledge'),
					"tone_modulation" => $this->input->post('tone_modulation'),
					"dragging_stammering" => $this->input->post('dragging_stammering'),
					"closing_procedure" => $this->input->post('closing_procedure'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($sales_id==0){
					
					$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/outbound/sales/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_ob_sales_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $sales_id);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array);
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
					$this->db->where('id', $sales_id);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array1);
					
				}
				
				redirect('qa_paynearby/paynearby_outbound');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_ob_service($service_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_ob_service.php";
			$data['service_id']=$service_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and is_assign_process(id,220)=0 and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_service_feedback where id='$service_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ob_service"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"customer" => $this->input->post('customer'),
					"call_duration" => $this->input->post('call_duration'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"standard_call_opening" => $this->input->post('standard_call_opening'),
					"necessary_probing" => $this->input->post('necessary_probing'),
					"explain_about_BNB_Amazon" => $this->input->post('explain_about_BNB_Amazon'),
					"explain_about_Flipkart" => $this->input->post('explain_about_Flipkart'),
					"wrong_call_information" => $this->input->post('wrong_call_information'),
					"active_listening" => $this->input->post('active_listening'),
					"rappo_building" => $this->input->post('rappo_building'),
					"tone_modulation" => $this->input->post('tone_modulation'),
					"dragging_stammering" => $this->input->post('dragging_stammering'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($service_id==0){
					
					$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/outbound/service/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_ob_service_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $service_id);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array);
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
					$this->db->where('id', $service_id);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array1);
					
				}
				
				redirect('qa_paynearby/paynearby_outbound');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
///////////////////////////////////////////// EMAIL //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function paynearby_email(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/qa_paynearby_email_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and is_assign_process(id,320) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_email_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_email"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_email($email_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_email.php";
			$data['email_id']=$email_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and is_assign_process(id,320) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_email_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["paynearby_email"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"mail_action_date" => mmddyy2mysql($this->input->post('mail_action_date')),
					"tat_replied_date" => mmddyy2mysql($this->input->post('tat_replied_date')),
					"status" => $this->input->post('status'),
					"tat" => $this->input->post('tat'),
					"email_no" => $this->input->post('email_no'),
					"msisdn" => $this->input->post('msisdn'),
					"email_id" => $this->input->post('email_id'),
					"interaction_id" => $this->input->post('interaction_id'),
					"category" => $this->input->post('category'),
					"sub_category" => $this->input->post('sub_category'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_query_answer" => $this->input->post('customer_query_answer'),
					"correct_process_follow" => $this->input->post('correct_process_follow'),
					"accurate_resolution_given" => $this->input->post('accurate_resolution_given'),
					"missing_details_for_CSE_call" => $this->input->post('missing_details_for_CSE_call'),
					"not_given_complete_solution" => $this->input->post('not_given_complete_solution'),
					"product_process_knowledge" => $this->input->post('product_process_knowledge'),
					"empathy_statement_use" => $this->input->post('empathy_statement_use'),
					"grammatical_error" => $this->input->post('grammatical_error'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($email_id==0){
					
					$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_email_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_email_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_email_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_email_feedback',$field_array);
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
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_email_feedback',$field_array1);
					
				}
				redirect('qa_paynearby/paynearby_email');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	/* public function agent_paynearby_ob_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/agent_paynearby_ob_feedback.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_ob_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign='';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			
			if($campaign!=''){	
			
				$qSql="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				$data["tot_ob_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				$data["yet_ob_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			
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
					
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	} */
	
	
	
///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA Paynearby REPORT ////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_paynearby_report(){
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
			$data["content_template"] = "qa_paynearby/qa_paynearby_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$campaign = $this->input->get('campaign');
			
			$data["qa_paynearby_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				//$dt_frm = getEstToLocal($date_from,agent_id);
				
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				//$dt_to = getEstToLocal($date_to,agent_id);
				
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (getLocalToEST(audit_date,agent_id) >= '$date_from' and getLocalToEST(audit_date,agent_id) <= '$date_to' ) ";
		
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
				
				if($campaign=='inbound'){
					/* $qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback) xx Left Join 
					(Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join 
					(Select fd_id, agnt_fd_acpt, note as agent_note, date(entry_date) as agent_rvw_date from qa_paynearby_agent_rvw) zz on (xx.id=zz.fd_id) Left Join 
					(Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_paynearby_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date"; */
					$qSql="Select P.*, concat(sa.fname, ' ', sa.lname) as auditor_name, concat(stl.fname, ' ', stl.lname) as tl_name, S.id as sid, S.fname, S.lname, S.fusion_id, 	S.office_id, get_process_names(S.id) as campaign, DATEDIFF(CURDATE(), S.doj) as tenure, S.assigned_to, PAR.fd_id, PAR.agnt_fd_acpt, PAR.note as agent_note, date(PAR.entry_date) as agent_rvw_date, PMR.fd_id as mgnt_fd_id, PMR.note as mgnt_note, date(PMR.entry_date) as mgnt_rvw_date, PMR.entry_by as mgnt_entry_by, concat(mrn.fname, ' ', mrn.lname) as mgnt_name
					from qa_paynearby_feedback P 
					Left Join signin S ON P.agent_id=S.id
					Left Join signin sa ON P.entry_by=sa.id
					Left Join signin stl ON P.tl_id=stl.id
					Left Join qa_paynearby_agent_rvw PAR ON P.id=PAR.fd_id
					Left Join qa_paynearby_mgnt_rvw PMR ON P.id=PMR.fd_id
					Left Join signin mrn ON PMR.entry_by=mrn.id $cond $cond1 order by audit_date";
				}else{
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				}
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_paynearby_list"] = $fullAray;
				$this->create_qa_paynearby_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_paynearby/download_qa_paynearby_CSV/".$campaign;
				
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
	 

	public function download_qa_paynearby_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		if($campaign=='inbound'){
			$pnb_hdr='Paynearby Inbound';
		}else if($campaign=='ob_sales'){
			$pnb_hdr='Paynearby Outbound - Sales';
		}else if($campaign=='ob_service'){
			$pnb_hdr='Paynearby Outbound - Service';
		}else if($campaign=='email'){
			$pnb_hdr='Paynearby Email';
		}
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$pnb_hdr." Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_paynearby_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=='inbound'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Opening with Greeting (incl late opening/Name confirmation)", "Initial Empathy with Assurance statement done", "DID AGENT UNDERSTOOD THE QUERY & NECESSARY PROBING DONE", "Followed proper Telephone etiquettes (mute hold transfer)", "IVR Promotion done", "Effective rebuttals on Objection Handling/Convincing skills", "Fraud Alert Message informed", "Appropriate sentences and acknowledgment used on call", "Did the Agent was Polite on call/Not done Arguments/Professional", "Good Behavior/Willingness", "Good in listening/Repetition not happened due to lack in listening skills/Attentive", "Not interrupted", "Proper Empathy done whenever required", "Did the agent maintained Proper Pace/tone modulation/clarity in speech", "Did the agent have Patience", "Energy/Enthusiasm", "Confidence Level", "Grammatical errors/Fumbling/Fillers", "No Dead Air found", "Not Dragged the call", "Rude flirting foul language Abusive with customer not happened", "Was Exact TAT informed (Not less than Actual)", "Not provided Wrong information on call", "Was Correct tagging done/raised proper ticket", "Not having (Minor Errors in Comments/Sub dispositions)", "Customer satisfied/Rapport building done", "Did the agent followed Proper call closing Script as per process", "Overall Score", "Grade", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='ob_sales'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "STANDARD CALL OPENING PROCEDURE", "** EXPLANATION ABOUT PRODUCT AND PROCESS WITH FULL INFORMATION", "**CORRECT TAGGINGS / WRONG INFORMATION", "NECESSARY PROBING DONE ON CALL BASED", "SALES PICHER POLITE PITCHING URGE FOR SALES & SERVICE", "ACTIVE LISTENING", "ASSURANCE ACKNOWLEDGEMENT STATEMENTS ON CALL", "TONE MODULATION", "DRAGGING / STAMMERING / JARGONS / FILLERS", "CLOSING PROCEDURE FOLLOWED", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='ob_service'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "STANDARD CALL OPENING WITH COMPANY NAME", "NECESSARY PROBING TO BE DONE & UNDERSTANDING THE CUSTOMER", "FOR BNB AND AMAZON EXPLAINATION ABOUT SHOP SET UP AS PER CHECK LIST", "**FOR FLIPKART- EXPLANATION ABOUT FLIPKART PROCESS WITH FULL INFORMATION", "**TAGGING / WRONG INFORAMTION ON CALL", "ACTIVE LISTENING", "RAPPO BUILDING / ASSURANCE", "TONE MODULATION", "DRAGGING / STAMMERING / JARGONS / FILLERS", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='email'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Date of Mail Received", "Date of Mail Action", "Status", "TAT", "Replied Date of TAT", "Email Number", "MSISDN", "Mail ID", "Interaction ID", "Category", "Sub Category", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Has all the queries of the customer answered", "Correct process followed", "Correct & Accurate Resolution given & completed on time", "For the missing details has the CSE called the customer to get those", "MINOR ERRORS - NOT GIVEN COMPLETE SOLUTION", "**Wrong or in complete information provided on mail", "Professional and Empathy statements used as per senario and acknowledge as per the query", "Email Etiquette Grammatical error punctuations font & spelling mistakes", "Email Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='inbound'){
			
			foreach($rr as $user){	
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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['opening_greeting'].'",';
				$row .= '"'.$user['initial_empathy'].'",';
				$row .= '"'.$user['agent_query'].'",';
				$row .= '"'.$user['proper_telephone'].'",';
				$row .= '"'.$user['ivr_promotion'].'",';
				$row .= '"'.$user['efective_rebuttal'].'",';
				$row .= '"'.$user['fraud_alert'].'",';
				$row .= '"'.$user['sentence_acknowledge'].'",';
				$row .= '"'.$user['polite_call'].'",';
				$row .= '"'.$user['good_behaviour'].'",';
				$row .= '"'.$user['good_listening'].'",';
				$row .= '"'.$user['not_interrupt'].'",';
				$row .= '"'.$user['proper_empathy'].'",';
				$row .= '"'.$user['proper_pace'].'",';
				$row .= '"'.$user['agent_patience'].'",';
				$row .= '"'.$user['energy_enthusias'].'",';
				$row .= '"'.$user['confident_level'].'",';
				$row .= '"'.$user['error_fumbling'].'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'.$user['dragged_call'].'",';
				$row .= '"'.$user['rude_language'].'",';
				$row .= '"'.$user['exact_tat'].'",';
				$row .= '"'.$user['wrong_provide'].'",';
				$row .= '"'.$user['correct_tagging'].'",';
				$row .= '"'.$user['minor_error'].'",';
				$row .= '"'.$user['satisfy_rapport'].'",';
				$row .= '"'.$user['closing_script'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.$user['grade'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($campaign=='ob_sales'){
			
			foreach($rr as $user){	
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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.$user['standart_call_opening'].'",';
				$row .= '"'.$user['explain_about_product'].'",';
				$row .= '"'.$user['correct_tagging'].'",';
				$row .= '"'.$user['necessary_probing'].'",';
				$row .= '"'.$user['sales_picher'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['assurance_acknowledge'].'",';
				$row .= '"'.$user['tone_modulation'].'",';
				$row .= '"'.$user['dragging_stammering'].'",';
				$row .= '"'.$user['closing_procedure'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($campaign=='ob_service'){
			
			foreach($rr as $user){	
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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.$user['standard_call_opening'].'",';
				$row .= '"'.$user['necessary_probing'].'",';
				$row .= '"'.$user['explain_about_BNB_Amazon'].'",';
				$row .= '"'.$user['explain_about_Flipkart'].'",';
				$row .= '"'.$user['wrong_call_information'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['rappo_building'].'",';
				$row .= '"'.$user['tone_modulation'].'",';
				$row .= '"'.$user['dragging_stammering'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($campaign=='email'){
			
			foreach($rr as $user){	
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['mail_action_date'].'",';
				$row .= '"'.$user['status'].'",';
				$row .= '"'.$user['tat'].'",';
				$row .= '"'.$user['tat_replied_date'].'",';
				$row .= '"'.$user['email_no'].'",';
				$row .= '"'.$user['msisdn'].'",';
				$row .= '"'.$user['email_id'].'",';
				$row .= '"'.$user['interaction_id'].'",';
				$row .= '"'.$user['category'].'",';
				$row .= '"'.$user['sub_category'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.$user['customer_query_answer'].'",';
				$row .= '"'.$user['correct_process_follow'].'",';
				$row .= '"'.$user['accurate_resolution_given'].'",';
				$row .= '"'.$user['missing_details_for_CSE_call'].'",';
				$row .= '"'.$user['not_given_complete_solution'].'",';
				$row .= '"'.$user['product_process_knowledge'].'",';
				$row .= '"'.$user['empathy_statement_use'].'",';
				$row .= '"'.$user['grammatical_error'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		
	}
	
	
 }