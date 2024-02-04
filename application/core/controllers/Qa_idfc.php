<?php 

 class Qa_idfc extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function idfc_upload_files($files,$path)
    {
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
			$data["content_template"] = "qa_idfc/qa_idfc_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,144) and is_assign_process (id,293) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["idfc_data"] = $this->Common_model->get_query_result_array($qSql);
		////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["idfc_new"] = $this->Common_model->get_query_result_array($qSql);
			
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
			$data["content_template"] = "qa_idfc/add_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,144) and is_assign_process (id,293) and status=1  order by name";
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
					"week" => $this->input->post('week'),
					"cycle_date" => mmddyy2mysql($this->input->post('cycle_date')),
					"phone" => $this->input->post('phone'),
					"customer_name" => $this->input->post('customer_name'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"disposition" => $this->input->post('disposition'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"agentopencallin3sec" => $this->input->post('agentopencallin3sec'),
					"agentintroducehimself" => $this->input->post('agentintroducehimself'),
					"agentintroducecompany" => $this->input->post('agentintroducecompany'),
					"agentusedprescribedscript" => $this->input->post('agentusedprescribedscript'),
					"agentclearlyexplained" => $this->input->post('agentclearlyexplained'),
					"agentquotedpreviouscall" => $this->input->post('agentquotedpreviouscall'),
					"agentgetsagreement" => $this->input->post('agentgetsagreement'),
					"agentcreateurjency" => $this->input->post('agentcreateurjency'),
					"agentreiteratedtheimpact" => $this->input->post('agentreiteratedtheimpact'),
					"agentgaveeffectiverebruttal" => $this->input->post('agentgaveeffectiverebruttal'),
					"agentpromotedpaidC" => $this->input->post('agentpromotedpaidC'),
					"agentdidrightprobing" => $this->input->post('agentdidrightprobing'),
					"agentcheckrelevanttool" => $this->input->post('agentcheckrelevanttool'),
					"3rdpartydisclosure" => $this->input->post('3rdpartydisclosure'),
					"agentupdatedcalltime" => $this->input->post('agentupdatedcalltime'),
					"agentusedverbalnods" => $this->input->post('agentusedverbalnods'),
					"agentavoidspeakingover" => $this->input->post('agentavoidspeakingover'),
					"agentemphathizedappropiate" => $this->input->post('agentemphathizedappropiate'),
					"agentsoundedconfident" => $this->input->post('agentsoundedconfident'),
					"clearexpansion" => $this->input->post('clearexpansion'),
					"agentrateofspeech" => $this->input->post('agentrateofspeech'),
					"agentsoundedenergetic" => $this->input->post('agentsoundedenergetic'),
					"listeningandcomprehensive" => $this->input->post('listeningandcomprehensive'),
					"agentnotprovideinfo" => $this->input->post('agentnotprovideinfo'),
					"agentnotfollowincorrectprocedure" => $this->input->post('agentnotfollowincorrectprocedure'),
					"agentresponceonquestion" => $this->input->post('agentresponceonquestion'),
					"agentfollowHoldprocedure" => $this->input->post('agentfollowHoldprocedure'),
					"agentfollowtransferprocedure" => $this->input->post('agentfollowtransferprocedure'),
					"agentnotDisconnectcall" => $this->input->post('agentnotDisconnectcall'),
					"agentwasnotabuseonCall" => $this->input->post('agentwasnotabuseonCall'),
					"agentnotSitetakingonCall" => $this->input->post('agentnotSitetakingonCall'),
					"agentcompiledoncall" => $this->input->post('agentcompiledoncall'),
					"agenttoneappropiateonCall" => $this->input->post('agenttoneappropiateonCall'),
					"followupcallwiththeCustomer" => $this->input->post('followupcallwiththeCustomer'),
					"greetingscore" => $this->input->post('greetingscore'),
					"purposecallscore" => $this->input->post('purposecallscore'),
					"collectiontechniquescore" => $this->input->post('collectiontechniquescore'),
					"communicatioskillscore" => $this->input->post('communicatioskillscore'),
					"telephoneetiquettescore" => $this->input->post('telephoneetiquettescore'),
					"callclosingscore" => $this->input->post('callclosingscore'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->idfc_upload_files($_FILES['attach_file'],$path='./qa_files/qa_idfc/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_idfc_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_idfc_feedback',$field_array1);
			///////////	
				redirect('Qa_idfc');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_idfc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/mgnt_idfc_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,144) and is_assign_process (id,293) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
					"week" => $this->input->post('week'),
					"cycle_date" => mmddyy2mysql($this->input->post('cycle_date')),
					"phone" => $this->input->post('phone'),
					"customer_name" => $this->input->post('customer_name'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"disposition" => $this->input->post('disposition'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"agentopencallin3sec" => $this->input->post('agentopencallin3sec'),
					"agentintroducehimself" => $this->input->post('agentintroducehimself'),
					"agentintroducecompany" => $this->input->post('agentintroducecompany'),
					"agentusedprescribedscript" => $this->input->post('agentusedprescribedscript'),
					"agentclearlyexplained" => $this->input->post('agentclearlyexplained'),
					"agentquotedpreviouscall" => $this->input->post('agentquotedpreviouscall'),
					"agentgetsagreement" => $this->input->post('agentgetsagreement'),
					"agentcreateurjency" => $this->input->post('agentcreateurjency'),
					"agentreiteratedtheimpact" => $this->input->post('agentreiteratedtheimpact'),
					"agentgaveeffectiverebruttal" => $this->input->post('agentgaveeffectiverebruttal'),
					"agentpromotedpaidC" => $this->input->post('agentpromotedpaidC'),
					"agentdidrightprobing" => $this->input->post('agentdidrightprobing'),
					"agentcheckrelevanttool" => $this->input->post('agentcheckrelevanttool'),
					"3rdpartydisclosure" => $this->input->post('3rdpartydisclosure'),
					"agentupdatedcalltime" => $this->input->post('agentupdatedcalltime'),
					"agentusedverbalnods" => $this->input->post('agentusedverbalnods'),
					"agentavoidspeakingover" => $this->input->post('agentavoidspeakingover'),
					"agentemphathizedappropiate" => $this->input->post('agentemphathizedappropiate'),
					"agentsoundedconfident" => $this->input->post('agentsoundedconfident'),
					"clearexpansion" => $this->input->post('clearexpansion'),
					"agentrateofspeech" => $this->input->post('agentrateofspeech'),
					"agentsoundedenergetic" => $this->input->post('agentsoundedenergetic'),
					"listeningandcomprehensive" => $this->input->post('listeningandcomprehensive'),
					"agentnotprovideinfo" => $this->input->post('agentnotprovideinfo'),
					"agentnotfollowincorrectprocedure" => $this->input->post('agentnotfollowincorrectprocedure'),
					"agentresponceonquestion" => $this->input->post('agentresponceonquestion'),
					"agentfollowHoldprocedure" => $this->input->post('agentfollowHoldprocedure'),
					"agentfollowtransferprocedure" => $this->input->post('agentfollowtransferprocedure'),
					"agentnotDisconnectcall" => $this->input->post('agentnotDisconnectcall'),
					"agentwasnotabuseonCall" => $this->input->post('agentwasnotabuseonCall'),
					"agentnotSitetakingonCall" => $this->input->post('agentnotSitetakingonCall'),
					"agentcompiledoncall" => $this->input->post('agentcompiledoncall'),
					"agenttoneappropiateonCall" => $this->input->post('agenttoneappropiateonCall'),
					"followupcallwiththeCustomer" => $this->input->post('followupcallwiththeCustomer'),
					"greetingscore" => $this->input->post('greetingscore'),
					"purposecallscore" => $this->input->post('purposecallscore'),
					"collectiontechniquescore" => $this->input->post('collectiontechniquescore'),
					"communicatioskillscore" => $this->input->post('communicatioskillscore'),
					"telephoneetiquettescore" => $this->input->post('telephoneetiquettescore'),
					"callclosingscore" => $this->input->post('callclosingscore'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_idfc_feedback',$field_array);
				
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
				$this->db->update('qa_idfc_feedback',$field_array1);
			///////////	
				redirect('Qa_idfc');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////////////////////////////////////////////	
/////////////////////// IDFC (NEW) //////////////////////////
	public function add_edit_idfc_new($idfc_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/add_edit_idfc_new.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data['idfc_id']=$idfc_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,144) and is_assign_process (id,293) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_idfc_new_feedback where id='$idfc_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_new"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"week" => $this->input->post('week'),
					"cycle_date" => mmddyy2mysql($this->input->post('cycle_date')),
					"phone" => $this->input->post('phone'),
					"customer_name" => $this->input->post('customer_name'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"disposition" => $this->input->post('disposition'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"greeting" => $this->input->post('greeting'),
					"self_introduction" => $this->input->post('self_introduction'),
					"call_purpose" => $this->input->post('call_purpose'),
					"correct_information" => $this->input->post('correct_information'),
					"incomplete_information" => $this->input->post('incomplete_information'),
					"wrong_information" => $this->input->post('wrong_information'),
					"PU_PTP_details" => $this->input->post('PU_PTP_details'),
					"remarks_in_CRM" => $this->input->post('remarks_in_CRM'),
					"referred_customer_payment" => $this->input->post('referred_customer_payment'),
					"use_convincing_skill" => $this->input->post('use_convincing_skill'),
					"appropriate_probing" => $this->input->post('appropriate_probing'),
					"accurate_reason_payment" => $this->input->post('accurate_reason_payment'),
					"customer_rebuttal" => $this->input->post('customer_rebuttal'),
					"online_payment_pitched" => $this->input->post('online_payment_pitched'),
					"active_listening" => $this->input->post('active_listening'),
					"speech_clarity" => $this->input->post('speech_clarity'),
					"tone_voice_modulation" => $this->input->post('tone_voice_modulation'),
					"empathy" => $this->input->post('empathy'),
					"confidence" => $this->input->post('confidence'),
					"grammer_language" => $this->input->post('grammer_language'),
					"hold_procedure" => $this->input->post('hold_procedure'),
					"call_disconnection" => $this->input->post('call_disconnection'),
					"CRM_protocol" => $this->input->post('CRM_protocol'),
					"capture_alternate_number" => $this->input->post('capture_alternate_number'),
					"CRM_protocol_field" => $this->input->post('CRM_protocol_field'),
					"CRM_protocol_disposition" => $this->input->post('CRM_protocol_disposition'),
					"summarization" => $this->input->post('summarization'),
					"PU_PTP_strong_assurance" => $this->input->post('PU_PTP_strong_assurance'),
					"closing" => $this->input->post('closing'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($idfc_id==0){
					
					$a = $this->idfc_upload_files($_FILES['attach_file'], $path='./qa_files/qa_idfc/idfc_new/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_idfc_new_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_idfc_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_idfc_new_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $idfc_id);
					$this->db->update('qa_idfc_new_feedback',$field_array);
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
					$this->db->where('id', $idfc_id);
					$this->db->update('qa_idfc_new_feedback',$field_array1);
					
				}
				
				redirect('qa_idfc');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_idfc_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/agent_idfc_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_idfc/agent_idfc_feedback";
			
			
			$qSql="Select count(id) as value from qa_idfc_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_idfc_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		///////////
			$qSql="Select count(id) as value from qa_idfc_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_idfcNew"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_idfc_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_idfc_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			/////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_idfc_new_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			//////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_idfc_new_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_idfc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/agent_idfc_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_idfc/agent_idfc_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
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
				$this->db->update('qa_idfc_feedback',$field_array1);
					
				redirect('Qa_idfc/agent_idfc_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_idfc_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/agent_idfc_new_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_idfc/agent_idfc_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
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
				$this->db->update('qa_idfc_new_feedback',$field_array1);
					
				redirect('Qa_idfc/agent_idfc_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////// 
///////////////////////////////// QA IDFC REPORT ////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_idfc_report(){
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
			$data["content_template"] = "qa_idfc/qa_idfc_report.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
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
			
			
			$data["qa_idfc_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$campaign = $this->input->get('campaign');
				$audit_type = $this->input->get('audit_type');
				
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_idfc_list"] = $fullAray;
				$this->create_qa_idfc_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_idfc/download_qa_idfc_CSV";	
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
	 

	public function download_qa_idfc_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA IDFC Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_idfc_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=='idfc'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date Time", "Week", "Cycle Date", "Phone", "Customer Name", "Disposition", "Call Duration", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Agent opened the call with the desired enthusiasm in 3 seconds", "Agent clearly introduced himself/herself to the customer", "Agent introduced the company he/she is calling from", "Agent used the prescribed script as per previous disposition", "Agent clearly explained the objective of calling the customer", "Agent quoted the previous call commitment made my the customer", "Agent reminds and gets agreement of a customer on number of broken PTP or Already Paid as applicable", "Agent created the urgency in the call to collect the payment", "Agent reiterated the impact due to delay in payment like cibil adhar etc", "Agent gave appropriate and effective rebuttal when the payment was delayed or being differed", "Agent promoted paid C modes to the customer", "Agent did the right probing to gather information from the customer in case of already paid", "Agent checked relevent tools notes details and historry before call back", "Third party disclosure", "Agent updated correct time for call back customer details updated accurately in COSMOS and VICI dial", "Agent used verbal nods to display interest in customers avoids dead-air", "Agent avoided speaking over or interrupt the customer and apologized if interrupted", "Agent acknowledged and/or empathized where appropriate", "Agent sounded confident and showed no sign of hesitancy to convey information", "Clear Explanations - Articulation sentence construction grammar etc", "Agents rate of speech was moderate", "Agent sounded courteous and energetic", "Listening and comprehension", "Agent did not provide/ confirm Incorrect/ incomplete information", "Agent did not follow Incorrect procedure followed to resolve an issue raised by the customer or made No promise", "Agent responded on question or query raised by the customer", "Agent followed the correct Hold procedure", "Agent followed the correct transfer procedure", "Agent did not Disconnect call before the customer or hung up on customer", "Agent was not abusive during the call", "Agent was not side-talking or speaking to another colleague while customer on line", "Agent complied to the call closure script", "Agents tone was appropriate while closing the call", "Follow-up call and appointment fixed as agreed with the customer", "Greeting Score", "Purpose Call Score", "Collection Technique Score", "Communicatio Skill Score", "Telephone Etiquette Score", "Call Closing Score", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='idfc_new'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date Time", "Week", "Cycle Date", "Phone", "Customer Name", "Disposition", "Call Duration", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Greeting & Customer Identification", "Self Introduction & Reaching RPC", "Purpose of call", "Complete & Correct information Minor Impact", "** Incomplete or Incorrect information", "** Incomplete or Wrong Information", "Confirmed PU and PTP details", "Referred the Trail remarks in CRM", "Referred customers Payment history", "** Use convincing skills for early payment", "Follow appropriate and relevant probing as per the process", "Identify accurate reasons of payment delay", "Objection Handing", "Online payment effectively pitched", "Active Listening", "Clarity of Speech & Rate of Speech", "Tone and Voice Modulation", "Empathy", "Confidence", "Language and Grammar", "Telephone Etiquettes & Hold Procedure", "** Rudeness or Unprofessionalism", "CRM protocol", "Capture Alternate number", "CRM protocol - Field and Remark Updation", "CRM protocol - Disposition", "Summarization", "Strong assurance on PU PTP", "Closing", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='idfc'){
		
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
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date_time'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['cycle_date'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentopencallin3sec'].'",';
				$row .= '"'.$user['agentintroducehimself'].'",';
				$row .= '"'.$user['agentintroducecompany'].'",';
				$row .= '"'.$user['agentusedprescribedscript'].'",';
				$row .= '"'.$user['agentclearlyexplained'].'",';
				$row .= '"'.$user['agentquotedpreviouscall'].'",';
				$row .= '"'.$user['agentgetsagreement'].'",';
				$row .= '"'.$user['agentcreateurjency'].'",';
				$row .= '"'.$user['agentreiteratedtheimpact'].'",';
				$row .= '"'.$user['agentgaveeffectiverebruttal'].'",';
				$row .= '"'.$user['agentpromotedpaidC'].'",';
				$row .= '"'.$user['agentdidrightprobing'].'",';
				$row .= '"'.$user['agentcheckrelevanttool'].'",';
				$row .= '"'.$user['3rdpartydisclosure'].'",';
				$row .= '"'.$user['agentupdatedcalltime'].'",';
				$row .= '"'.$user['agentusedverbalnods'].'",';
				$row .= '"'.$user['agentavoidspeakingover'].'",';
				$row .= '"'.$user['agentemphathizedappropiate'].'",';
				$row .= '"'.$user['agentsoundedconfident'].'",';
				$row .= '"'.$user['clearexpansion'].'",';
				$row .= '"'.$user['agentrateofspeech'].'",';
				$row .= '"'.$user['agentsoundedenergetic'].'",';
				$row .= '"'.$user['listeningandcomprehensive'].'",';
				$row .= '"'.$user['agentnotprovideinfo'].'",';
				$row .= '"'.$user['agentnotfollowincorrectprocedure'].'",';
				$row .= '"'.$user['agentresponceonquestion'].'",';
				$row .= '"'.$user['agentfollowHoldprocedure'].'",';
				$row .= '"'.$user['agentfollowtransferprocedure'].'",';
				$row .= '"'.$user['agentnotDisconnectcall'].'",';
				$row .= '"'.$user['agentwasnotabuseonCall'].'",';
				$row .= '"'.$user['agentnotSitetakingonCall'].'",';
				$row .= '"'.$user['agentcompiledoncall'].'",';
				$row .= '"'.$user['agenttoneappropiateonCall'].'",';
				$row .= '"'.$user['followupcallwiththeCustomer'].'",';
				$row .= '"'.$user['greetingscore'].'",';
				$row .= '"'.$user['purposecallscore'].'",';
				$row .= '"'.$user['collectiontechniquescore'].'",';
				$row .= '"'.$user['communicatioskillscore'].'",';
				$row .= '"'.$user['telephoneetiquettescore'].'",';
				$row .= '"'.$user['callclosingscore'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
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
		
		}else if($campaign=='idfc_new'){
		
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
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['cycle_date'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greeting'].'",';
				$row .= '"'.$user['self_introduction'].'",';
				$row .= '"'.$user['call_purpose'].'",';
				$row .= '"'.$user['correct_information'].'",';
				$row .= '"'.$user['incomplete_information'].'",';
				$row .= '"'.$user['wrong_information'].'",';
				$row .= '"'.$user['PU_PTP_details'].'",';
				$row .= '"'.$user['remarks_in_CRM'].'",';
				$row .= '"'.$user['referred_customer_payment'].'",';
				$row .= '"'.$user['use_convincing_skill'].'",';
				$row .= '"'.$user['appropriate_probing'].'",';
				$row .= '"'.$user['accurate_reason_payment'].'",';
				$row .= '"'.$user['customer_rebuttal'].'",';
				$row .= '"'.$user['online_payment_pitched'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['speech_clarity'].'",';
				$row .= '"'.$user['tone_voice_modulation'].'",';
				$row .= '"'.$user['empathy'].'",';
				$row .= '"'.$user['confidence'].'",';
				$row .= '"'.$user['grammer_language'].'",';
				$row .= '"'.$user['hold_procedure'].'",';
				$row .= '"'.$user['call_disconnection'].'",';
				$row .= '"'.$user['CRM_protocol'].'",';
				$row .= '"'.$user['capture_alternate_number'].'",';
				$row .= '"'.$user['CRM_protocol_field'].'",';
				$row .= '"'.$user['CRM_protocol_disposition'].'",';
				$row .= '"'.$user['summarization'].'",';
				$row .= '"'.$user['PU_PTP_strong_assurance'].'",';
				$row .= '"'.$user['closing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
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