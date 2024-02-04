<?php 

 class Qa_superdaily extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function mt_upload_files($files,$path)
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
			$data["content_template"] = "qa_superdaily/qa_superdaily_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and status=1  order by name";
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
		
			/* $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["superdaily_data"] = $this->Common_model->get_query_result_array($qSql);

			
			$qSql1 = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["superdaily_call_data"] = $this->Common_model->get_query_result_array($qSql1);
		/////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["superdaily_new_call_data"] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["new_superdaily"] = $this->Common_model->get_query_result_array($qSql);
		/////////////////	
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_image_validate_new $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["image_validate"] = $this->Common_model->get_query_result_array($qSql);
		/////////////////	
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_complaint_resolution $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["complaint_reolution"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	/* public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and  (is_assign_process (id,278) or is_assign_process (id,327))  and status=1  order by name";
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
					"chat_date" => mdydt2mysql($this->input->post('chat_date')),
					"contact_no" => $this->input->post('contact_no'),
					"customer_id" => $this->input->post('customer_id'),
					"chat_weblink" => $this->input->post('chat_weblink'),
					"chat_type" => $this->input->post('chat_type'),
					"chat_dispo" => $this->input->post('chat_dispo'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"communication_score" => $this->input->post('communication_score'),
					"resolution_score" => $this->input->post('resolution_score'),
					"overall_score" => $this->input->post('overall_score'),
					"communicationchatopening" => $this->input->post('communicationchatopening'),
					"communicationchatclose" => $this->input->post('communicationchatclose'),
					"communicationcomprehension" => $this->input->post('communicationcomprehension'),
					"communicationrapportbuild" => $this->input->post('communicationrapportbuild'),
					"communicationprobing" => $this->input->post('communicationprobing'),
					"communicationgrammer" => $this->input->post('communicationgrammer'),
					"resolutionproblemsolving" => $this->input->post('resolutionproblemsolving'),
					"resolutioncustomerinformation" => $this->input->post('resolutioncustomerinformation'),
					"resolutionowenership" => $this->input->post('resolutionowenership'),
					"resolutionincorrectlebel" => $this->input->post('resolutionincorrectlebel'),
					"resolutionraisedtool" => $this->input->post('resolutionraisedtool'),
					"resolutionztp" => $this->input->post('resolutionztp'),
					"resolutioncallbackoffer" => $this->input->post('resolutioncallbackoffer'),
					"resolutionretoolaccuracy" => $this->input->post('resolutionretoolaccuracy'),
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					"comm5" => $this->input->post('comm5'),
					"comm6" => $this->input->post('comm6'),
					"reso1" => $this->input->post('reso1'),
					"reso2" => $this->input->post('reso2'),
					"reso3" => $this->input->post('reso3'),
					"reso4" => $this->input->post('reso4'),
					"reso5" => $this->input->post('reso5'),
					"reso6" => $this->input->post('reso6'),
					"reso7" => $this->input->post('reso7'),
					"reso8" => $this->input->post('reso8'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_superdaily/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_superdaily_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_superdaily_feedback',$field_array1);
			///////////	
				redirect('Qa_superdaily');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	} */

	/* public function add_call_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/add_call_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and (is_assign_process (id,278) or is_assign_process (id,327)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),//done check
					"tl_id" => $this->input->post('tl_id'),//done check
					"call_date" => mdydt2mysql($this->input->post('call_date')),//done check
					"emailid" => $this->input->post('emailid'),//done check but coulm create pending
					"contact_no" => $this->input->post('contact_no'),//done check
					"customer_id" => $this->input->post('customer_id'),//done check
					"channel" => $this->input->post('channel'),//done check
					"call_type" => $this->input->post('call_type'),//done check
					"actual_dispo" => $this->input->post('actual_dispo'),//done check
					"audit_type" => $this->input->post('audit_type'),//done check
					"auditor_type" => $this->input->post('auditor_type'),//done check
					"week" => $this->input->post('week'),//done check
					"communication_score" => $this->input->post('communication_score'),//done check
					"resolution_score" => $this->input->post('resolution_score'),//done check
					"overall_score" => $this->input->post('overall_score'),//done check
					
					"callhandlingskillopeningclosure" => $this->input->post('callhandlingskillopeningclosure'),
					"callhandlingskillacknowledgement" => $this->input->post('callhandlingskillacknowledgement'),
					"callhandlingskillrapportbuilding" => $this->input->post('callhandlingskillrapportbuilding'),
					"callhandlingskilldeadair" => $this->input->post('callhandlingskilldeadair'),
					//done check
					"communicationprobing" => $this->input->post('communicationprobing'),
					"communicationactivelestening" => $this->input->post('communicationactivelestening'),
					"communicationratespeech" => $this->input->post('communicationratespeech'),
					"communicationtonemanner" => $this->input->post('communicationtonemanner'),
					//done check
					"resolutionproblemsolving" => $this->input->post('resolutionproblemsolving'),
					"resolutioncustomerinformation" => $this->input->post('resolutioncustomerinformation'),
					"resolutionowenership" => $this->input->post('resolutionowenership'),
					"resolutionztp" => $this->input->post('resolutionztp'),
					"resolutionincorrectdispo" => $this->input->post('resolutionincorrectdispo'),
					"resolutionraisedrelevant" => $this->input->post('resolutionraisedrelevant'),
					"resolutioncallbackoffer" => $this->input->post('resolutioncallbackoffer'),
					"resolutionretoolaccuracy" => $this->input->post('resolutionretoolaccuracy'),
					//done check
					"chs1" => $this->input->post('chs1'),
					"chs2" => $this->input->post('chs2'),
					"chs3" => $this->input->post('chs3'),
					"chs4" => $this->input->post('chs4'),
					//done check
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					//done check
					"reso1" => $this->input->post('reso1'),
					"reso2" => $this->input->post('reso2'),
					"reso3" => $this->input->post('reso3'),
					"reso4" => $this->input->post('reso4'),
					"reso5" => $this->input->post('reso5'),
					"reso6" => $this->input->post('reso6'),
					"reso7" => $this->input->post('reso7'),
					"reso8" => $this->input->post('reso8'),
					
					"process_recommendation" => $this->input->post('process_recommendation'),
					"overall_observation" => $this->input->post('overall_observation'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);

				$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_superdaily/call_audit/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_superdaily_call_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_superdaily_call_feedback',$field_array1);
			///////////	
				redirect('Qa_superdaily');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	} */
	
	
	/* public function mgnt_superdaily_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/mgnt_superdaily_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and (is_assign_process (id,278) or is_assign_process (id,327)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["superdaily_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
					"chat_date" => mdydt2mysql($this->input->post('chat_date')),
					"contact_no" => $this->input->post('contact_no'),
					"customer_id" => $this->input->post('customer_id'),
					"chat_weblink" => $this->input->post('chat_weblink'),
					"chat_type" => $this->input->post('chat_type'),
					"chat_dispo" => $this->input->post('chat_dispo'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"communication_score" => $this->input->post('communication_score'),
					"resolution_score" => $this->input->post('resolution_score'),
					"overall_score" => $this->input->post('overall_score'),
					"communicationchatopening" => $this->input->post('communicationchatopening'),
					"communicationchatclose" => $this->input->post('communicationchatclose'),
					"communicationcomprehension" => $this->input->post('communicationcomprehension'),
					"communicationrapportbuild" => $this->input->post('communicationrapportbuild'),
					"communicationprobing" => $this->input->post('communicationprobing'),
					"communicationgrammer" => $this->input->post('communicationgrammer'),
					"resolutionproblemsolving" => $this->input->post('resolutionproblemsolving'),
					"resolutioncustomerinformation" => $this->input->post('resolutioncustomerinformation'),
					"resolutionowenership" => $this->input->post('resolutionowenership'),
					"resolutionincorrectlebel" => $this->input->post('resolutionincorrectlebel'),
					"resolutionraisedtool" => $this->input->post('resolutionraisedtool'),
					"resolutionztp" => $this->input->post('resolutionztp'),
					"resolutioncallbackoffer" => $this->input->post('resolutioncallbackoffer'),
					"resolutionretoolaccuracy" => $this->input->post('resolutionretoolaccuracy'),
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					"comm5" => $this->input->post('comm5'),
					"comm6" => $this->input->post('comm6'),
					"reso1" => $this->input->post('reso1'),
					"reso2" => $this->input->post('reso2'),
					"reso3" => $this->input->post('reso3'),
					"reso4" => $this->input->post('reso4'),
					"reso5" => $this->input->post('reso5'),
					"reso6" => $this->input->post('reso6'),
					"reso7" => $this->input->post('reso7'),
					"reso8" => $this->input->post('reso8'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_superdaily_feedback',$field_array);
				
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
				$this->db->update('qa_superdaily_feedback',$field_array1);
			///////////	
				redirect('Qa_superdaily');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	} */

//////////////////////mgnt call rvw/////////////////////////////////

	/* public function mgnt_superdaily_call_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/mgnt_superdaily_call_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and (is_assign_process (id,278) or is_assign_process (id,327)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["superdaily_call_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					//"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),//done check
					"tl_id" => $this->input->post('tl_id'),//done check
					"call_date" => mdydt2mysql($this->input->post('call_date')),//done check
					"emailid" => $this->input->post('emailid'),//done check but coulm create pending
					"contact_no" => $this->input->post('contact_no'),//done check
					"customer_id" => $this->input->post('customer_id'),//done check
					"channel" => $this->input->post('channel'),//done check
					"call_type" => $this->input->post('call_type'),//done check
					"actual_dispo" => $this->input->post('actual_dispo'),//done check
					"audit_type" => $this->input->post('audit_type'),//done check
					"auditor_type" => $this->input->post('auditor_type'),//done check
					"week" => $this->input->post('week'),//done check
					"communication_score" => $this->input->post('communication_score'),//done check
					"resolution_score" => $this->input->post('resolution_score'),//done check
					"overall_score" => $this->input->post('overall_score'),//done check
					
					"callhandlingskillopeningclosure" => $this->input->post('callhandlingskillopeningclosure'),
					"callhandlingskillacknowledgement" => $this->input->post('callhandlingskillacknowledgement'),
					"callhandlingskillrapportbuilding" => $this->input->post('callhandlingskillrapportbuilding'),
					"callhandlingskilldeadair" => $this->input->post('callhandlingskilldeadair'),
					//done check
					"communicationprobing" => $this->input->post('communicationprobing'),
					"communicationactivelestening" => $this->input->post('communicationactivelestening'),
					"communicationratespeech" => $this->input->post('communicationratespeech'),
					"communicationtonemanner" => $this->input->post('communicationtonemanner'),
					//done check
					"resolutionproblemsolving" => $this->input->post('resolutionproblemsolving'),
					"resolutioncustomerinformation" => $this->input->post('resolutioncustomerinformation'),
					"resolutionowenership" => $this->input->post('resolutionowenership'),
					"resolutionztp" => $this->input->post('resolutionztp'),
					"resolutionincorrectdispo" => $this->input->post('resolutionincorrectdispo'),
					"resolutionraisedrelevant" => $this->input->post('resolutionraisedrelevant'),
					"resolutioncallbackoffer" => $this->input->post('resolutioncallbackoffer'),
					"resolutionretoolaccuracy" => $this->input->post('resolutionretoolaccuracy'),
					//done check
					"chs1" => $this->input->post('chs1'),
					"chs2" => $this->input->post('chs2'),
					"chs3" => $this->input->post('chs3'),
					"chs4" => $this->input->post('chs4'),
					//done check
					"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					//done check
					"reso1" => $this->input->post('reso1'),
					"reso2" => $this->input->post('reso2'),
					"reso3" => $this->input->post('reso3'),
					"reso4" => $this->input->post('reso4'),
					"reso5" => $this->input->post('reso5'),
					"reso6" => $this->input->post('reso6'),
					"reso7" => $this->input->post('reso7'),
					"reso8" => $this->input->post('reso8'),
					
					"process_recommendation" => $this->input->post('process_recommendation'),
					"overall_observation" => $this->input->post('overall_observation'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_superdaily_call_feedback',$field_array);
				
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
				$this->db->update('qa_superdaily_call_feedback',$field_array1);
			///////////	
				redirect('Qa_superdaily');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	} */	


/////////////////////////////////////////////////////////////////////////
////////////////// Superdaily Call Audit New ////////////////////////////
	/* public function add_edit_new_call_feedback($new_call_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/add_edit_new_call_feedback.php";
			$data['new_call_id']=$new_call_id;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and (is_assign_process (id,278) or is_assign_process (id,327)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_superdaily_call_new_feedback where id='$new_call_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["new_call_data"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"contact_no" => $this->input->post('contact_no'),
					"customer_id" => $this->input->post('customer_id'),
					"channel" => $this->input->post('channel'),
					"call_type" => $this->input->post('call_type'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"ucp_score" => $this->input->post('ucp_score'),
					"tna_score" => $this->input->post('tna_score'),
					"cu_score" => $this->input->post('cu_score'),
					"hc_score" => $this->input->post('hc_score'),
					"interruption" => $this->input->post('interruption'),
					"listening_comprehension" => $this->input->post('listening_comprehension'),
					"repeat_customer_unnecessary" => $this->input->post('repeat_customer_unnecessary'),
					"asked_necessary_question" => $this->input->post('asked_necessary_question'),
					"necessary_acknowledge" => $this->input->post('necessary_acknowledge'),
					"complaint_created" => $this->input->post('complaint_created'),
					"complaint_post_call" => $this->input->post('complaint_post_call'),
					"escalation" => $this->input->post('escalation'),
					"entry_into_sheet" => $this->input->post('entry_into_sheet'),
					"follow_up" => $this->input->post('follow_up'),
					"hold_used" => $this->input->post('hold_used'),
					"complete_information" => $this->input->post('complete_information'),
					"hold_time_in_sec" => $this->input->post('hold_time_in_sec'),
					"dead_air" => $this->input->post('dead_air'),
					"customer_calling_back" => $this->input->post('customer_calling_back'),
					"explain_current_situation" => $this->input->post('explain_current_situation'),
					"informed_customer" => $this->input->post('informed_customer'),
					"follow_up_done" => $this->input->post('follow_up_done'),
					"spoke_chatted" => $this->input->post('spoke_chatted'),
					"ask_hold_permission" => $this->input->post('ask_hold_permission'),
					"answer_any_question" => $this->input->post('answer_any_question'),
					"ask_further_assistance" => $this->input->post('ask_further_assistance'),
					"wrap_up_call" => $this->input->post('wrap_up_call'),
					"polite" => $this->input->post('polite'),
					"emphathetic" => $this->input->post('emphathetic'),
					"tone" => $this->input->post('tone'),
					"rude" => $this->input->post('rude'),
					"sarcastic" => $this->input->post('sarcastic'),
					"deliberate_disconnect" => $this->input->post('deliberate_disconnect'),
					"abusive" => $this->input->post('abusive'),
					"inappropiate_language" => $this->input->post('inappropiate_language'),
					"agent_not_action" => $this->input->post('agent_not_action'),
					"product_damage" => $this->input->post('product_damage'),
					"policy_process" => $this->input->post('policy_process'),
					"customer_fraud" => $this->input->post('customer_fraud'),
					"not_recieve_OTP" => $this->input->post('not_recieve_OTP'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($new_call_id==0){
					
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_superdaily/call_audit_new/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_superdaily_call_new_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_call_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_call_new_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $new_call_id);
					$this->db->update('qa_superdaily_call_new_feedback',$field_array);
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
					$this->db->where('id', $new_call_id);
					$this->db->update('qa_superdaily_call_new_feedback',$field_array1);
					
				}
				
				redirect('Qa_superdaily');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	} */
	
	
/////////////////////////////////////////////////////////////////////////
/////////////////////// Superdaily Audit New ////////////////////////////
/////////////////////////////////////////////////////////////////////////
	public function add_edit_new_feedback($spdl_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/add_edit_new_feedback.php";
			$data['spdl_id']=$spdl_id;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_superdaily_new_feedback where id='$spdl_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["new_superdaily"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"contact_no" => $this->input->post('contact_no'),
					"chat_link" => $this->input->post('chat_link'),
					"audit_category" => $this->input->post('audit_category'),
					"disposition" => $this->input->post('disposition'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"ucp_earned" => $this->input->post('ucp_earned'),
					"tna_earned" => $this->input->post('tna_earned'),
					"cu_earned" => $this->input->post('cu_earned'),
					"hc_earned" => $this->input->post('hc_earned'),
					"ucp_score" => $this->input->post('ucp_score'),
					"tna_score" => $this->input->post('tna_score'),
					"cu_score" => $this->input->post('cu_score'),
					"hc_score" => $this->input->post('hc_score'),
					"overall_score" => $this->input->post('overall_score'),
					"interruption" => $this->input->post('interruption'),
					"listening_comprehension" => $this->input->post('listening_comprehension'),
					"repeat_customer_unnecessary" => $this->input->post('repeat_customer_unnecessary'),
					"asked_necessary_question" => $this->input->post('asked_necessary_question'),
					"necessary_acknowledge" => $this->input->post('necessary_acknowledge'),
					"personalization" => $this->input->post('personalization'),
					"complaint_created" => $this->input->post('complaint_created'),
					"retool_comment" => $this->input->post('retool_comment'),
					"escalation" => $this->input->post('escalation'),
					"entry_into_sheet" => $this->input->post('entry_into_sheet'),
					"follow_up" => $this->input->post('follow_up'),
					"hold_used" => $this->input->post('hold_used'),
					"complete_information" => $this->input->post('complete_information'),
					"hold_time_in_sec" => $this->input->post('hold_time_in_sec'),
					"dead_air" => $this->input->post('dead_air'),
					"customer_calling_back" => $this->input->post('customer_calling_back'),
					"explain_current_situation" => $this->input->post('explain_current_situation'),
					"informed_customer" => $this->input->post('informed_customer'),
					"follow_up_done" => $this->input->post('follow_up_done'),
					"spoke_chatted" => $this->input->post('spoke_chatted'),
					"ask_hold_permission" => $this->input->post('ask_hold_permission'),
					"answer_any_question" => $this->input->post('answer_any_question'),
					"ask_further_assistance" => $this->input->post('ask_further_assistance'),
					"wrap_up_call" => $this->input->post('wrap_up_call'),
					"polite" => $this->input->post('polite'),
					"emphathetic" => $this->input->post('emphathetic'),
					"tone" => $this->input->post('tone'),
					"Fatal" => $this->input->post('Fatal'),
					"ZTP" => $this->input->post('ZTP'),
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
					"classify_audit" => $this->input->post('classify_audit'),
					"acpt" => $this->input->post('acpt'),
					"why1" => $this->input->post('why1'),
					"why2" => $this->input->post('why2'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($spdl_id==0){
					
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_superdaily/new_superdaily/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_superdaily_new_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_new_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $spdl_id);
					$this->db->update('qa_superdaily_new_feedback',$field_array);
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
					$this->db->where('id', $spdl_id);
					$this->db->update('qa_superdaily_new_feedback',$field_array1);
					
				}
				
				redirect('Qa_superdaily');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////////////////////////////////////////////////////
////////////////// Superdaily Image Validation //////////////////////////
/////////////////////////////////////////////////////////////////////////
	public function add_edit_image_validate($spdl_img){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/add_edit_image_validate.php";
			$data['spdl_img']=$spdl_img;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_superdaily_image_validate_new where id='$spdl_img') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["image_validate"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"contact_no" => $this->input->post('contact_no'),
					"complaint_id" => $this->input->post('complaint_id'),
					"audit_category" => $this->input->post('audit_category'),
					"rca" => $this->input->post('rca'),
					"accurate_rca" => $this->input->post('accurate_rca'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"ucp_score" => $this->input->post('ucp_score'),
					"tna_score" => $this->input->post('tna_score'),
					"uwbd_score" => $this->input->post('uwbd_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agent_validate_image" => $this->input->post('agent_validate_image'),
					"correct_complaint_status" => $this->input->post('correct_complaint_status'),
					"valid_call_attempt" => $this->input->post('valid_call_attempt'),
					"delivary_check_proof" => $this->input->post('delivary_check_proof'),
					"refunded_SOP" => $this->input->post('refunded_SOP'),
					"customer_guided_properly" => $this->input->post('customer_guided_properly'),
					"call_notification_sent" => $this->input->post('call_notification_sent'),
					"acurate_retool_comment" => $this->input->post('acurate_retool_comment'),
					"fatal" => $this->input->post('fatal'),
					"ztp" => $this->input->post('ztp'),
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
					"acpt" => $this->input->post('acpt'),
					"why1" => $this->input->post('why1'),
					"why2" => $this->input->post('why2'),
					"classify_audit" => $this->input->post('classify_audit'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($spdl_img==0){
					
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_superdaily/image_validate/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_superdaily_image_validate_new',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_image_validate_new',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_image_validate_new',$field_array1);
					
				}else{
					
					$this->db->where('id', $spdl_img);
					$this->db->update('qa_superdaily_image_validate_new',$field_array);
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
					$this->db->where('id', $spdl_img);
					$this->db->update('qa_superdaily_image_validate_new',$field_array1);
					
				}
				
				redirect('Qa_superdaily');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////////////////////////////////////////////////////
///////////////// Superdaily Complaint Resolution ///////////////////////
/////////////////////////////////////////////////////////////////////////
	public function add_edit_complaint_resolution($spdl_reso){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/add_edit_complaint_resolution.php";
			$data['spdl_reso']=$spdl_reso;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,135) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_superdaily_complaint_resolution where id='$spdl_reso') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["complaint_resolution"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"contact_no" => $this->input->post('contact_no'),
					"complaint_id" => $this->input->post('complaint_id'),
					"audit_category" => $this->input->post('audit_category'),
					"rca" => $this->input->post('rca'),
					"accurate_rca" => $this->input->post('accurate_rca'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"ucp_earned" => $this->input->post('ucp_earned'),
					"tna_earned" => $this->input->post('tna_earned'),
					"cu_earned" => $this->input->post('cu_earned'),
					"hc_earned" => $this->input->post('hc_earned'),
					"ucp_score" => $this->input->post('ucp_score'),
					"tna_score" => $this->input->post('tna_score'),
					"cu_score" => $this->input->post('cu_score'),
					"hc_score" => $this->input->post('hc_score'),
					"overall_score" => $this->input->post('overall_score'),
					"interruption" => $this->input->post('interruption'),
					"listening_comprehension" => $this->input->post('listening_comprehension'),
					"asked_necessary_question" => $this->input->post('asked_necessary_question'),
					"necessary_acknowledge" => $this->input->post('necessary_acknowledge'),
					"personalization" => $this->input->post('personalization'),
					"complaint_created" => $this->input->post('complaint_created'),
					"retool_comment" => $this->input->post('retool_comment'),
					"correct_RCA_update" => $this->input->post('correct_RCA_update'),
					"proof_of_delivery" => $this->input->post('proof_of_delivery'),
					"DE_call_attempt" => $this->input->post('DE_call_attempt'),
					"customer_call_attempt" => $this->input->post('customer_call_attempt'),
					"correct_information" => $this->input->post('correct_information'),
					"correct_refund" => $this->input->post('correct_refund'),
					"cutomer_call_back" => $this->input->post('cutomer_call_back'),
					"current_situation_explain" => $this->input->post('current_situation_explain'),
					"inform_customer_what_we_done" => $this->input->post('inform_customer_what_we_done'),
					"spoke_chatted" => $this->input->post('spoke_chatted'),
					"ask_hold_permission" => $this->input->post('ask_hold_permission'),
					"answer_any_question" => $this->input->post('answer_any_question'),
					"ask_further_assistance" => $this->input->post('ask_further_assistance'),
					"wrap_up_call" => $this->input->post('wrap_up_call'),
					"polite" => $this->input->post('polite'),
					"emphathetic" => $this->input->post('emphathetic'),
					"tone" => $this->input->post('tone'),
					"Fatal" => $this->input->post('Fatal'),
					"ZTP" => $this->input->post('ZTP'),
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
					"classify_audit" => $this->input->post('classify_audit'),
					"acpt" => $this->input->post('acpt'),
					"why1" => $this->input->post('why1'),
					"why2" => $this->input->post('why2'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($spdl_reso==0){
					
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_superdaily/complaint_resolution/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_superdaily_complaint_resolution',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_complaint_resolution',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_superdaily_complaint_resolution',$field_array1);
					
				}else{
					
					$this->db->where('id', $spdl_reso);
					$this->db->update('qa_superdaily_complaint_resolution',$field_array);
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
					$this->db->where('id', $spdl_reso);
					$this->db->update('qa_superdaily_complaint_resolution',$field_array1);
					
				}
				redirect('Qa_superdaily');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_superdaily_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/agent_superdaily_feedback.php";
			$data["agentUrl"] = "qa_superdaily/agent_superdaily_feedback";
			
			
			/* $qSql="Select count(id) as value from qa_superdaily_feedback where agent_id='$current_user' And audit_type!='Calibration'";
			$qSql1="Select count(id) as value from qa_superdaily_call_feedback where agent_id='$current_user' And audit_type!='Calibration'";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$data["tot_call_feedback"] =  $this->Common_model->get_single_value($qSql1); */
			
			/* $qSql="Select count(id) as value from qa_superdaily_feedback where agent_id='$current_user' And audit_type!='Calibration' and agent_rvw_date is Null";
			$qSql1="Select count(id) as value from qa_superdaily_call_feedback where agent_id='$current_user' And audit_type!='Calibration' and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			$data["yet_call_rvw"] =  $this->Common_model->get_single_value($qSql1); */
		//////////
			/* $new_call_qSql1="Select count(id) as value from qa_superdaily_call_new_feedback where agent_id='$current_user' And audit_type!='Calibration'";
			$new_call_qSql2="Select count(id) as value from qa_superdaily_call_new_feedback where agent_id='$current_user' And audit_type!='Calibration' and agent_rvw_date is Null";
			$data["tot_new_call_audit"] =  $this->Common_model->get_single_value($new_call_qSql1);
			$data["yet_new_call_audit"] =  $this->Common_model->get_single_value($new_call_qSql2); */
		///////////
			$new_spdl_qSql1="Select count(id) as value from qa_superdaily_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$new_spdl_qSql2="Select count(id) as value from qa_superdaily_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["tot_new_spdl"] =  $this->Common_model->get_single_value($new_spdl_qSql1);
			$data["yet_new_spdl"] =  $this->Common_model->get_single_value($new_spdl_qSql2);
			
			$spdl_imgval_qSql1="Select count(id) as value from qa_superdaily_image_validate_new where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$spdl_imgval_qSql2="Select count(id) as value from qa_superdaily_image_validate_new where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["tot_spdl_imgval"] =  $this->Common_model->get_single_value($spdl_imgval_qSql1);
			$data["yet_spdl_imgval"] =  $this->Common_model->get_single_value($spdl_imgval_qSql2);
			
			$spdl_reso_qSql1="Select count(id) as value from qa_superdaily_complaint_resolution where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$spdl_reso_qSql2="Select count(id) as value from qa_superdaily_complaint_resolution where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["tot_spdl_reso"] =  $this->Common_model->get_single_value($spdl_reso_qSql1);
			$data["yet_spdl_reso"] =  $this->Common_model->get_single_value($spdl_reso_qSql2);
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') ";
				
				/* $qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql1 = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_feedback $cond and agent_id='$current_user' And audit_type!='Calibration') xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_call_list"] = $this->Common_model->get_query_result_array($qSql1);
				
				$new_call_qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_new_feedback $cond and agent_id='$current_user' And audit_type!='Calibration') xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["rvw_new_call_audit"] = $this->Common_model->get_query_result_array($new_call_qSql); */
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_new_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["rvw_new_spdl"] = $this->Common_model->get_query_result_array($qSql);
			////////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_image_validate_new $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["rvw_spdl_imgval"] = $this->Common_model->get_query_result_array($qSql);
			////////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_complaint_resolution $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["rvw_spdl_reso"] = $this->Common_model->get_query_result_array($qSql);

					
			}else{
	
				/* $qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql1="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_call_list"] = $this->Common_model->get_query_result_array($qSql1);	
			//////////////
				$qSql1="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_new_feedback where agent_id='$current_user' And audit_type!='Calibration') xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["rvw_new_call_audit"] = $this->Common_model->get_query_result_array($qSql1);	 */
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["rvw_new_spdl"] = $this->Common_model->get_query_result_array($qSql);
			/////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_image_validate_new where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["rvw_spdl_imgval"] = $this->Common_model->get_query_result_array($qSql);
			/////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_complaint_resolution where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["rvw_spdl_reso"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_superdaily_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/agent_superdaily_new_rvw.php";
			$data["agentUrl"] = "qa_superdaily/agent_superdaily_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["superdaily_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_superdaily_new_feedback',$field_array1);
					
				redirect('Qa_superdaily/agent_superdaily_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_superdaily_imgval_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/agent_superdaily_imgval_rvw.php";
			$data["agentUrl"] = "qa_superdaily/agent_superdaily_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_image_validate_new where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["spdl_imgval"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_superdaily_image_validate',$field_array1);
					
				redirect('Qa_superdaily/agent_superdaily_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_spdl_complaint_reso_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/agent_spdl_complaint_reso_rvw.php";
			$data["agentUrl"] = "qa_superdaily/agent_superdaily_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_complaint_resolution where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["complaint_resolution"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_superdaily_complaint_resolution',$field_array1);
					
				redirect('Qa_superdaily/agent_superdaily_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	/* public function agent_superdaily_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/agent_superdaily_rvw.php";
			$data["agentUrl"] = "qa_superdaily/agent_superdaily_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["superdaily_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_superdaily_feedback',$field_array1);
					
				redirect('Qa_superdaily/agent_superdaily_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_superdaily_call_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/agent_superdaily_call_rvw.php";
			$data["agentUrl"] = "qa_superdaily/agent_superdaily_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["superdaily_call_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_superdaily_call_feedback',$field_array1);
					
				redirect('Qa_superdaily/agent_superdaily_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_new_call_audit_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_superdaily/agent_superdaily_new_call_audit_rvw.php";
			$data["agentUrl"] = "qa_superdaily/agent_superdaily_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_superdaily_call_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["new_call_data"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_superdaily_call_new_feedback',$field_array1);
					
				redirect('Qa_superdaily/agent_superdaily_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	} */
	

///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////// QA Super Daily REPORT ////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_superdaily_report(){
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
			$data["content_template"] = "qa_superdaily/qa_superdaily_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_superdaily_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
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

				//$table=($this->input->get('department_id')=='sd_audit')?"qa_superdaily_feedback":"qa_superdaily_call_feedback";
				if($this->input->get('department_id')=='sd_audit'){
					$table='qa_superdaily_feedback';
				}else if($this->input->get('department_id')=='sd_call_audit'){
					$table='qa_superdaily_call_new_feedback';
				}else if($this->input->get('department_id')=='sd_new_audit'){
					$table='qa_superdaily_new_feedback';
				}else if($this->input->get('department_id')=='spdl_imgval'){
					$table='qa_superdaily_image_validate_new';
				}else if($this->input->get('department_id')=='spdl_imgval_old'){
					$table='qa_superdaily_image_validate';
				}else if($this->input->get('department_id')=='spdl_reso'){
					$table='qa_superdaily_complaint_resolution';
				}

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from $table) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_superdaily_list"] = $fullAray;
				$data['dep_id']=$this->input->get('department_id');
				
				if($this->input->get('department_id')=='sd_audit'){
					$this->create_qa_superdaily_CSV($fullAray);	
				}else if($this->input->get('department_id')=='sd_call_audit'){
					$this->create_qa_superdaily_call_CSV($fullAray);	
				}else if($this->input->get('department_id')=='sd_new_audit'){
					$this->create_qa_superdaily_new_CSV($fullAray);	
				}else if($this->input->get('department_id')=='spdl_imgval'){
					$this->create_qa_superdaily_imgval_new_CSV($fullAray);	
				}else if($this->input->get('department_id')=='spdl_imgval_old'){
					$this->create_qa_superdaily_imgval_CSV($fullAray);	
				}else if($this->input->get('department_id')=='spdl_reso'){
					$this->create_qa_superdaily_reso_CSV($fullAray);	
				}

				$dn_link = base_url()."qa_superdaily/download_qa_superdaily_CSV";


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
	 

	public function download_qa_superdaily_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Super Daily Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_superdaily_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Chat Date", "Contact No", "Customer ID", "Chat Weblink", "Chat Type", "Chat Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Communication", "Resolution", "Chat Opening", "Chat Opening Comment", "Chat Closure", "Chat Closure Comment", "Acknowledgement Comprehension", "Acknowledgement Comprehension Comment", "Rapport buliding and Empathy", "Rapport buliding and Empathy Comment", "Probing", "Probing Comment", "Grammar and Choice of Words", "Grammar and Choice of Words Comment", "Problem Solving Abilities", "Problem Solving Abilities Comment", "Providing complete and accurate information", "Providing complete and accurate information Comment", "Ownership", "Ownership Comment", "Incorrect Labelling", "Incorrect Labelling Comment", "Raised relevant complaint", "Raised relevant complaint Comment", "ZTP", "ZTP Comment", "Callback Offered/Required", "Callback Offered/Required Comment", "Retool Accuracy", "Retool Accuracy Comment", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['chat_date'].'",';
			$row .= '"'.$user['contact_no'].'",';
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['chat_weblink'].'",';
			$row .= '"'.$user['chat_type'].'",';
			$row .= '"'.$user['chat_dispo'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['communication_score'].'%'.'",';
			$row .= '"'.$user['resolution_score'].'%'.'",';
			$row .= '"'.$user['communicationchatopening'].'",';
			$row .= '"'.$user['comm1'].'",';
			$row .= '"'.$user['communicationchatclose'].'",';
			$row .= '"'.$user['comm2'].'",';
			$row .= '"'.$user['communicationcomprehension'].'",';
			$row .= '"'.$user['comm3'].'",';
			$row .= '"'.$user['communicationrapportbuild'].'",';
			$row .= '"'.$user['comm4'].'",';
			$row .= '"'.$user['communicationprobing'].'",';
			$row .= '"'.$user['comm5'].'",';
			$row .= '"'.$user['communicationgrammer'].'",';
			$row .= '"'.$user['comm6'].'",';
			$row .= '"'.$user['resolutionproblemsolving'].'",';
			$row .= '"'.$user['reso1'].'",';
			$row .= '"'.$user['resolutioncustomerinformation'].'",';
			$row .= '"'.$user['reso2'].'",';
			$row .= '"'.$user['resolutionowenership'].'",';
			$row .= '"'.$user['reso3'].'",';
			$row .= '"'.$user['resolutionincorrectlebel'].'",';
			$row .= '"'.$user['reso4'].'",';
			$row .= '"'.$user['resolutionraisedtool'].'",';
			$row .= '"'.$user['reso5'].'",';
			$row .= '"'.$user['resolutionztp'].'",';
			$row .= '"'.$user['reso6'].'",';
			$row .= '"'.$user['resolutioncallbackoffer'].'",';
			$row .= '"'.$user['reso7'].'",';
			$row .= '"'.$user['resolutionretoolaccuracy'].'",';
			$row .= '"'.$user['reso8'].'",';
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

	public function create_qa_superdaily_call_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Evaluator Name", "Audit Date", "Fusion ID", "Agent", "TL/AM Name", "Call Date/Time","Customer No", "Channel", "Call Type", "Chat Link", "Actual Disposition", "Week", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Understood Customer Problem", "Took necessary action to solve problem", "Customer understood what is being done", "Was helpful to customer", "1.1 Interruption", "1.1 Comment", "1.2 Listening Comprehension", "1.2 Comment", "1.3 Made the customer repeat unnecessarily", "1.3 Comment", "1.4 Asked necessary questions", "1.4 Comment", "1.5 Acknowledge where necessary", "1.5 Comment", "2.1 Complaint created or Updated", "2.1 Comment", "2.2 Complaint creation post call or chat", "2.2 Comment", "2.3 Escalation", "2.3 Comment", "2.4 Entry into any sheets", "2.4 Comment", "2.5 Follow-up", "2.5 Comment", "2.6 Hold used", "2.6 Comment", "2.7 Correct or complete information given", "2.7 Comment", "2.8 Hold time in secs", "2.8 Comment", "2.9 Dead air in sec", "2.9 Comment", "2.10 Possibility Customer calling back", "2.10 Comment", "3.1 Explained what is the current situation", "3.1 Comment", "3.2 Informed customer what we have now done", "3.2 Comment", "3.3 Follow-up done", "3.3 Comment", "3.4 Spoke or chatted to the Customer", "3.4 Comment", "3.5 Asked permission for hold", "3.5 Comment", "4.1 Answered any other questions patiently", "4.1 Comment", "4.2 Asked for further assistance if relevant", "4.2 Comment", "4.3 Eager to wrap up call or chat", "4.3 Comment", "4.4 Polite", "4.4 Comment", "4.5 Empathetic", "4.5 Comment", "4.6 Tone", "4.6 Comment", "*** 5.1 Rude", "5.1 Comment", "*** 5.2 Sarcastic", "5.1 Comment", "*** 5.3 Deliberate Disconnect", "5.3 Comment", "*** 6.1 Abusive", "6.1 Comment", "*** 6.2 Inappropriate language", "6.2 Comment", "Agent did not action as required", "Comment", "Product Quality damage expired quantity mismatch", "Comment", "SOP followed - to be explained in brief", "Comment", "Customer Expecting more than what can be done", "Comment", "Technology App issues like app does not load", "Comment", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['contact_no'].'",';
			$row .= '"'.$user['channel'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['actual_dispo'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['ucp_score'].'%'.'",';
			$row .= '"'.$user['tna_score'].'%'.'",';
			$row .= '"'.$user['cu_score'].'%'.'",';
			$row .= '"'.$user['hc_score'].'%'.'",';
			$row .= '"'.$user['interruption'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'.$user['listening_comprehension'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'.$user['repeat_customer_unnecessary'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'.$user['asked_necessary_question'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'.$user['necessary_acknowledge'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'.$user['complaint_created'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'.$user['complaint_post_call'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'.$user['escalation'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'.$user['entry_into_sheet'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'.$user['follow_up'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'.$user['hold_used'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			$row .= '"'.$user['complete_information'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			$row .= '"'.$user['hold_time_in_sec'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			$row .= '"'.$user['dead_air'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			$row .= '"'.$user['customer_calling_back'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			$row .= '"'.$user['explain_current_situation'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
			$row .= '"'.$user['informed_customer'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
			$row .= '"'.$user['follow_up_done'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
			$row .= '"'.$user['spoke_chatted'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
			$row .= '"'.$user['ask_hold_permission'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
			$row .= '"'.$user['answer_any_question'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
			$row .= '"'.$user['ask_further_assistance'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
			$row .= '"'.$user['wrap_up_call'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
			$row .= '"'.$user['polite'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
			$row .= '"'.$user['emphathetic'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
			$row .= '"'.$user['tone'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
			$row .= '"'.$user['rude'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
			$row .= '"'.$user['sarcastic'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
			$row .= '"'.$user['deliberate_disconnect'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
			$row .= '"'.$user['abusive'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt30'])).'",';
			$row .= '"'.$user['inappropiate_language'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt31'])).'",';
			$row .= '"'.$user['agent_not_action'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt32'])).'",';
			$row .= '"'.$user['product_damage'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt33'])).'",';
			$row .= '"'.$user['policy_process'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt34'])).'",';
			$row .= '"'.$user['customer_fraud'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt35'])).'",';
			$row .= '"'.$user['not_recieve_OTP'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt36'])).'",';
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
			// echo $row;
			// die;
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
///////////////// Superdaily New //////////////////////
	public function create_qa_superdaily_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Evaluator Name", "Audit Date", "Fusion ID", "Agent", "TL/AM Name", "Call Date/Time", "Customer No", "Chat Link", "Audit Category", "Disposition", "Actual Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Understood Customers Problem", "Took necessary action to solve problem", "Customer understood what is being done", "Was helpful to customer", "Overall Score", "1.1 Interruption", "1.1 Comment", "1.2 Listening Comprehension", "1.2 Comment", "1.3 Made the customer repeat unnecessarily", "1.3 Comment", "1.4 Asked necessary questions", "1.4 Comment", "1.5 Acknowledge where necessary", "1.5 Comment", "1.6 Personalization", "1.6 Comment", "2.1 Complaint created or Updated", "2.1 Comment", "2.2 Retool comments (customer VOC)", "2.2 Comment", "2.3 Escalation", "2.3 Comment", "2.4 Entry into any sheets", "2.4 Comment", "2.5 Follow-up", "2.5 Comment", "2.6 Hold used", "2.6 Comment", "2.7 Correct or complete information given", "2.7 Comment", "2.8 Hold time in secs", "2.8 Comment", "2.9 Dead air in sec", "2.9 Comment", "2.10 Possibility Customer calling back", "2.10 Comment", "3.1 Explained what is the current situation", "3.1 Comment", "3.2 Informed customer what we have now done", "3.2 Comment", "3.3 Follow-up done", "3.3 Comment", "3.4 Spoke or chatted to the Customer", "3.4 Comment", "3.5 Asked permission for hold", "3.5 Comment", "4.1 Answered any other questions patiently", "4.1 Comment", "4.2 Asked for further assistance if relevant", "4.2 Comment", "4.3 Eager to wrap up call or chat", "4.3 Comment", "4.4 Polite", "4.4 Comment", "4.5 Empathetic", "4.5 Comment", "4.6 Tone", "4.6 Comment", "*** 5.1 Fatal", "5.1 Comment", "*** 5.2 ZTP", "5.2 Comment", "ACPT", "WHY1", "WHY2", "Classify the Audit", "Call Summary", "Feedback", "Agent_Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['contact_no'].'",';
			$row .= '"'.$user['chat_link'].'",';
			$row .= '"'.$user['audit_category'].'",';
			$row .= '"'.$user['disposition'].'",';
			$row .= '"'.$user['actual_dispo'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['ucp_score'].'%'.'",';
			$row .= '"'.$user['tna_score'].'%'.'",';
			$row .= '"'.$user['cu_score'].'%'.'",';
			$row .= '"'.$user['hc_score'].'%'.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['interruption'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'.$user['listening_comprehension'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'.$user['repeat_customer_unnecessary'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'.$user['asked_necessary_question'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'.$user['necessary_acknowledge'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'.$user['personalization'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'.$user['complaint_created'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'.$user['retool_comment'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'.$user['escalation'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'.$user['entry_into_sheet'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'.$user['follow_up'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			$row .= '"'.$user['hold_used'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			$row .= '"'.$user['complete_information'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			$row .= '"'.$user['hold_time_in_sec'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			$row .= '"'.$user['dead_air'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			$row .= '"'.$user['customer_calling_back'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
			$row .= '"'.$user['explain_current_situation'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
			$row .= '"'.$user['informed_customer'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
			$row .= '"'.$user['follow_up_done'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
			$row .= '"'.$user['spoke_chatted'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
			$row .= '"'.$user['ask_hold_permission'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
			$row .= '"'.$user['answer_any_question'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
			$row .= '"'.$user['ask_further_assistance'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
			$row .= '"'.$user['wrap_up_call'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
			$row .= '"'.$user['polite'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
			$row .= '"'.$user['emphathetic'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
			$row .= '"'.$user['tone'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
			$row .= '"'.$user['Fatal'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
			$row .= '"'.$user['ZTP'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['why1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['why2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['classify_audit'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			// echo $row;
			// die;
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
///////////////// Superdaily Image Validation //////////////////////
	public function create_qa_superdaily_imgval_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "TL/AM Name", "Call Date/Time", "Contact No", "Chat Link", "Audit Category", "Disposition", "Actual Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Understood Customers Problem", "Took necessary action to solve problem", "Understood what is being done", "Overall Score", "1.1 Was agent able to identify the validity of image properly?", "1.2 If NO what should be the actual status of image?", "2.1 Was call Required in this case?", "2.2 Was call attempt made?", "2.3 POD Check done", "2.4 Have we refunded/credit amount given for the exact quantity", "3.1 Are retool comments clear", "**4.1 Fatal", "**4.2 ZTP", "1.1 Reason", "1.2 Reason", "2.1 Reason", "2.2 Reason", "2.3 Reason", "2.4 Reason", "3.1 Reason", "4.1 Reason", "4.2 Reason", "Call Summary", "Feedback", "Agent_Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['contact_no'].'",';
			$row .= '"'.$user['chat_link'].'",';
			$row .= '"'.$user['audit_category'].'",';
			$row .= '"'.$user['disposition'].'",';
			$row .= '"'.$user['actual_dispo'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['ucp_score'].'%'.'",';
			$row .= '"'.$user['tna_score'].'%'.'",';
			$row .= '"'.$user['uwbd_score'].'%'.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['identify_image_validity'].'",';
			$row .= '"'.$user['actual_image_status'].'",';
			$row .= '"'.$user['was_call_required'].'",';
			$row .= '"'.$user['was_call_attempt'].'",';
			$row .= '"'.$user['POD_check_done'].'",';
			$row .= '"'.$user['credit_amount_given'].'",';
			$row .= '"'.$user['retool_comment_clear'].'",';
			$row .= '"'.$user['fatal'].'",';
			$row .= '"'.$user['ztp'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
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
	
///////////////// Superdaily Image Validation (NEW) //////////////////////
	public function create_qa_superdaily_imgval_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "TL/AM Name", "Call Date/Time", "Customer No", "Complaint ID", "Audit Category", "RCA", "Accurate RCA", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Understood customers problem", "Took necessary action to solve problem", "Customer understood what is being done", "Agent validated the image properly", "1.1 Reason", "Correct complaint status updated by the agent", "2.1 Reason", "Valid call attempts", "2.2 Reason", "Proof of delivery check done for QED and WOD", "2.3 Reason", "Refunded as per the SOP/exact amount", "2.4 Reason", "Guided the customer properly for the invalid and rejected complaints", "3.1 Reason", "If the call went unanswered notification sent to the customer", "3.2 Reason", "Accurate retool comments", "3.3 Reason", "Fatal", "4.1 Reason", "ZTP", "4.2 Reason", "ACPT", "WHY1", "WHY2", "Classify Audit", "Call Summary", "Feedback", "Agent_Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['contact_no'].'",';
			$row .= '"'.$user['complaint_id'].'",';
			$row .= '"'.$user['audit_category'].'",';
			$row .= '"'.$user['rca'].'",';
			$row .= '"'.$user['accurate_rca'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['ucp_score'].'%'.'",';
			$row .= '"'.$user['tna_score'].'%'.'",';
			$row .= '"'.$user['uwbd_score'].'%'.'",';
			$row .= '"'.$user['agent_validate_image'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'.$user['correct_complaint_status'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'.$user['valid_call_attempt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'.$user['delivary_check_proof'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'.$user['refunded_SOP'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'.$user['customer_guided_properly'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'.$user['call_notification_sent'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'.$user['acurate_retool_comment'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'.$user['fatal'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'.$user['ztp'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['why1'].'",';
			$row .= '"'.$user['why2'].'",';
			$row .= '"'.$user['classify_audit'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
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
	
///////////////// Superdaily Image Validation (NEW) //////////////////////
	public function create_qa_superdaily_reso_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "TL/AM Name", "Call Date/Time", "Customer No", "Complaint ID", "Audit Category", "RCA", "Accurate RCA", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Understood Customers Problem", "Took necessary action to solve problem", "Customer understood what is being done", "Was helpful to customer", "1.1 Interruption", "1.1 Reason", "1.2 Listening Comprehension", "1.2 Comment", "1.3 Asked necessary questions", "1.3 Reason", "1.4 Acknowledge where necessary", "1.4 Reason", "1.5 Personalization", "1.5 Reason", "2.1 Complaint created/Updated", "2.1 Reason", "2.2 Retool comments", "2.2 Reason", "2.3 Correct RCA updated", "2.3 Reason", "2.4 Correct Proof of delivery feedback", "2.4 Reason", "2.5 DE call attempt", "2.5 Reason", "2.6 Customer call attempt", "2.6 Reason", "2.7 Correct/complete information given", "2.7 Reason", "2.8 Correct Refund Processed", "2.8 Reason", "2.9 Possibility Customer calling back", "2.9 Reason", "3.1 Explained what is the current situation", "3.1 Reason", "3.2 Informed customer what we have now done", "3.2 Reason", "3.3 Spoke/chatted in a way that is understandable to the custome", "3.3 Reason", "3.4 Asked permission for hold/mute etc", "3.4 Reason", "4.1 Answered any other questions patiently", "4.1 Reason", "4.2 Asked for further assistance if relevant", "4.2 Reason", "4.3 Eager to wrap up call/chat", "4.3 Reason", "4.4 Polite", "4.4 Reason", "4.5 Empathetic", "4.5 Reason", "4.6 Tone", "4.6 Reason", "5.1 FATAL", "5.1 Reason", "5.2 ZTP", "5.2 Reason", "ACPT", "WHY1", "WHY2", "Classify Audit", "Call Summary", "Feedback", "Agent_Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['contact_no'].'",';
			$row .= '"'.$user['complaint_id'].'",';
			$row .= '"'.$user['audit_category'].'",';
			$row .= '"'.$user['rca'].'",';
			$row .= '"'.$user['accurate_rca'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['ucp_score'].'%'.'",';
			$row .= '"'.$user['tna_score'].'%'.'",';
			$row .= '"'.$user['cu_score'].'%'.'",';
			$row .= '"'.$user['hc_score'].'%'.'",';
			$row .= '"'.$user['interruption'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'.$user['listening_comprehension'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'.$user['asked_necessary_question'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'.$user['necessary_acknowledge'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'.$user['personalization'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'.$user['complaint_created'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'.$user['retool_comment'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'.$user['correct_RCA_update'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'.$user['proof_of_delivery'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'.$user['DE_call_attempt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'.$user['customer_call_attempt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			$row .= '"'.$user['correct_information'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			$row .= '"'.$user['correct_refund'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			$row .= '"'.$user['cutomer_call_back'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			$row .= '"'.$user['current_situation_explain'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			$row .= '"'.$user['inform_customer_what_we_done'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
			$row .= '"'.$user['spoke_chatted'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
			$row .= '"'.$user['ask_hold_permission'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
			$row .= '"'.$user['answer_any_question'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
			$row .= '"'.$user['ask_further_assistance'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
			$row .= '"'.$user['wrap_up_call'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
			$row .= '"'.$user['polite'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
			$row .= '"'.$user['emphathetic'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
			$row .= '"'.$user['tone'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
			$row .= '"'.$user['Fatal'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
			$row .= '"'.$user['ZTP'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['why1'].'",';
			$row .= '"'.$user['why2'].'",';
			$row .= '"'.$user['classify_audit'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
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