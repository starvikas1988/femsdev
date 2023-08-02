<?php 

 class Qa_vfs extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_philip_model');
	}
	

	public function createPath($path){

		if (!empty($path)) {

	    	if(!file_exists($path)){

	    		$mainPath="./";
	    		$checkPath=str_replace($mainPath,'', $path);
	    		$checkPath=explode("/",$checkPath);
	    		$cnt=count($checkPath);
	    		for($i=0;$i<$cnt;$i++){

		    		$mainPath.=$checkPath[$i].'/';
		    		if (!file_exists($mainPath)) {
		    			$oldmask = umask(0);
						$mkdir=mkdir($mainPath, 0777);
						umask($oldmask);

						if ($mkdir) {
							return true;
						}else{
							return false;
						}
		    		}
	    		}

    		}else{
    			return true;
    		}
    	}
	}

	private function vfs_upload_files($files,$path)
    {
    	$result=$this->createPath($path);
    	if($result){
        $config['upload_path'] = $path;
		//$config['allowed_types'] = '*';
		//$config['detect_mime'] = FALSE;
		//$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
		$config['allowed_types'] = 'mp3|m4a|mp4|wav';
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
    }

	
	// private function vfs_upload_files($files,$path){
 //        $config['upload_path'] = $path;
	// 	$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
	// 	$config['max_size'] = '2024000';
	// 	$this->load->library('upload', $config);
	// 	$this->upload->initialize($config);
 //        $images = array();
 //        foreach ($files['name'] as $key => $image) {           
	// 		$_FILES['uFiles']['name']= $files['name'][$key];
	// 		$_FILES['uFiles']['type']= $files['type'][$key];
	// 		$_FILES['uFiles']['tmp_name']= $files['tmp_name'][$key];
	// 		$_FILES['uFiles']['error']= $files['error'][$key];
	// 		$_FILES['uFiles']['size']= $files['size'][$key];

 //            if ($this->upload->do_upload('uFiles')) {
	// 			$info = $this->upload->data();
	// 			$ext = $info['file_ext'];
	// 			$file_path = $info['file_path'];
	// 			$full_path = $info['full_path'];
	// 			$file_name = $info['file_name'];
	// 			if(strtolower($ext)== '.wav'){
	// 				$file_name = str_replace(".","_",$file_name).".mp3";
	// 				$new_path = $file_path.$file_name;
	// 				$comdFile=FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
	// 				$output = shell_exec( $comdFile);
	// 				sleep(2);
	// 			}
	// 			$images[] = $file_name;
 //            }else{
 //                return false;
 //            }
 //        }
 //        return $images;
 //    }
	
	 
	public function index(){
		if(check_logged_in())
		{			
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vfs/qa_vfs_feedback.php";
			$data["content_js"] = "qa_od_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,57) and status=1 order by name";
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vfs_chat_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["vfs_chat"] = $this->Common_model->get_query_result_array($qSql);
		//////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vfs_call_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["vfs_call"] = $this->Common_model->get_query_result_array($qSql);
		///////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vfs_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["vfs_email"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////	
	public function add_edit_vfs_chat($chat_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vfs/add_edit_vfs_chat.php";
			$data["content_js"] = "qa_od_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,57) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['chat_id']=$chat_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_vfs_chat_feedback where id='$chat_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["vfs_chat"] = $this->Common_model->get_query_row_array($qSql);
			
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
					"acpt" => $this->input->post('acpt'),
					"host_country" => $this->input->post('host_country'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"autofail_status" => $this->input->post('autofail_status'),
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
					//"update_ASM" => $this->input->post('update_ASM'),
					"hold_required" => $this->input->post('hold_required'),
					//"hold_guidelines" => $this->input->post('hold_guidelines'),
					"formatting" => $this->input->post('formatting'),
					"avoid_negative_statement" => $this->input->post('avoid_negative_statement'),
					"procedure_guide_step" => $this->input->post('procedure_guide_step'),
					"avoid_slangs" => $this->input->post('avoid_slangs'),
					"correct_grammar_use" => $this->input->post('correct_grammar_use'),
					"further_assistance" => $this->input->post('further_assistance'),
					"chat_adherence" => $this->input->post('chat_adherence'),
					"accurate_information" => $this->input->post('accurate_information'),
					"delayed_opening" => $this->input->post('delayed_opening'),
					"rude_on_chat" => $this->input->post('rude_on_chat'),
					"inacurate_information" => $this->input->post('inacurate_information'),
					"complaint_avoidance" => $this->input->post('complaint_avoidance'),
					"comm0" => $this->input->post('comm0'),
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
					"comm15" => $this->input->post('comm15'),
					"comm16" => $this->input->post('comm16'),
					"comm17" => $this->input->post('comm17'),
					"comm18" => $this->input->post('comm18'),
					"comm19" => $this->input->post('comm19'),
					"comm20" => $this->input->post('comm20'),
					"comm21" => $this->input->post('comm21'),
					"comm22" => $this->input->post('comm22'),
					"comm23" => $this->input->post('comm23'),
					"comm24" => $this->input->post('comm24'),
					"comm25" => $this->input->post('comm25'),
					"comm26" => $this->input->post('comm26'),
					"comm27" => $this->input->post('comm27'),
					"comm28" => $this->input->post('comm28'),
					"comm29" => $this->input->post('comm29'),
					"comm30" => $this->input->post('comm30'),
					"comm31" => $this->input->post('comm31'),
					"comm32" => $this->input->post('comm32'),
					"comm33" => $this->input->post('comm33'),
					"comm34" => $this->input->post('comm34'),
					"tenurity" => $this->input->post('tenurity'),
					"customer_called_first" => $this->input->post('customer_called_first'),
					"customer_contact_more_one_less_three" => $this->input->post('customer_contact_more_one_less_three'),
					"customer_contact_more_three" => $this->input->post('customer_contact_more_three'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				
				$a = $this->vfs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vfs/chat/');
				$field_array["attach_file"] = implode(',',$a);

				if($chat_id==0){
					
					
					$rowid= data_inserter('qa_vfs_chat_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_vfs_chat_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_vfs_chat_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $chat_id);
					$this->db->update('qa_vfs_chat_feedback',$field_array);
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
					$this->db->update('qa_vfs_chat_feedback',$field_array1);
					
				}
				redirect('Qa_vfs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_vfs_call($call_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vfs/add_edit_vfs_call.php";
			$data["content_js"] = "qa_od_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,57) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['call_id']=$call_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_vfs_call_feedback where id='$call_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["vfs_call"] = $this->Common_model->get_query_row_array($qSql);
			
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
					"acpt" => $this->input->post('acpt'),
					"host_country" => $this->input->post('host_country'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"tenurity" => $this->input->post('tenurity'),
					"autofail_status" => $this->input->post('autofail_status'),
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
					"hold_required" => $this->input->post('hold_required'),
					"further_assistance" => $this->input->post('further_assistance'),
					"CSAT_experience_feedback" => $this->input->post('CSAT_experience_feedback'), 
					"ownership_resolve" => $this->input->post('ownership_resolve'),
					"procuedure_request" => $this->input->post('procuedure_request'),
					"delayed_opening" => $this->input->post('delayed_opening'),
					"rude_on_call" => $this->input->post('rude_on_call'),
					"incomplete_information" => $this->input->post('incomplete_information'),
					"complaint_avoidance" => $this->input->post('complaint_avoidance'),
					"absence_disposition" => $this->input->post('absence_disposition'),
					"comm0" => $this->input->post('comm0'),
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
					"comm14" => $this->input->post('comm14'),
					"comm15" => $this->input->post('comm15'),
					"comm16" => $this->input->post('comm16'),
					"comm17" => $this->input->post('comm17'),
					"comm18" => $this->input->post('comm18'),
					"comm19" => $this->input->post('comm19'),
					"comm20" => $this->input->post('comm20'),
					"comm21" => $this->input->post('comm21'),
					"comm22" => $this->input->post('comm22'),
					"comm23" => $this->input->post('comm23'),
					"comm24" => $this->input->post('comm24'),
					"comm25" => $this->input->post('comm25'),
					"comm26" => $this->input->post('comm26'),
					"disposition" => $this->input->post('disposition'),
					"contacted_previously" => $this->input->post('contacted_previously'),
					"disposition_selected" => $this->input->post('disposition_selected'),
					"customer_called_first" => $this->input->post('customer_called_first'),
					"customer_called_less_three" => $this->input->post('customer_called_less_three'),
					"customer_called_more_three" => $this->input->post('customer_called_more_three'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time'),
				);
				
				$a = $this->vfs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vfs/call/');
				$field_array["attach_file"] = implode(',',$a);

				if($call_id==0){
					$rowid= data_inserter('qa_vfs_call_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_vfs_call_feedback',$field_array2);

					//print_r($field_array);
					//die();
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_vfs_call_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $call_id);
					$this->db->update('qa_vfs_call_feedback',$field_array);
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
					$this->db->update('qa_vfs_call_feedback',$field_array1);
					
				}
				redirect('Qa_vfs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_vfs_email($email_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vfs/add_edit_vfs_email.php";
			$data["content_js"] = "qa_od_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,57) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['email_id']=$email_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_vfs_email_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["vfs_email"] = $this->Common_model->get_query_row_array($qSql);
			
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
					"host_country" => $this->input->post('host_country'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"autofail_status" => $this->input->post('autofail_status'),
					"overall_score" => $this->input->post('overall_score'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					//"use_paragraph_idea" => $this->input->post('use_paragraph_idea'),
					"salutation" => $this->input->post('salutation'),
					"use_bullet_point" => $this->input->post('use_bullet_point'),
					//"adhered_word_limit" => $this->input->post('adhered_word_limit'),
					"definite_statements" => $this->input->post('definite_statements'),
					"template_adherence" => $this->input->post('template_adherence'),
					"interim_responce" => $this->input->post('interim_responce'),
					"FCR_achieved" => $this->input->post('FCR_achieved'),
					//"understand_issue" => $this->input->post('understand_issue'),
					//"attentiveness_display" => $this->input->post('attentiveness_display'),
					"customer_attentiveness" => $this->input->post('customer_attentiveness'),
					"use_available_resource" => $this->input->post('use_available_resource'),
					"standardized_subject" => $this->input->post('standardized_subject'),
					"VAS_option" => $this->input->post('VAS_option'),
					"awarreness_created" => $this->input->post('awarreness_created'),
					"correct_disposition" => $this->input->post('correct_disposition'),
					//"update_ASM" => $this->input->post('update_ASM'),
					"formatting" => $this->input->post('formatting'),
					//"show_customer_feel_value" => $this->input->post('show_customer_feel_value'),
					"procedure_guide_step" => $this->input->post('procedure_guide_step'),
					"avoid_slangs" => $this->input->post('avoid_slangs'),
					"correct_grammar_use" => $this->input->post('correct_grammar_use'),
					//"correct_closing" => $this->input->post('correct_closing'),
					//"further_assistance" => $this->input->post('further_assistance'),
					"correct_assistance" => $this->input->post('correct_assistance'),
					"used_applicant" => $this->input->post('used_applicant'),
					"complete_information" => $this->input->post('complete_information'),
					"rude_on_email" => $this->input->post('rude_on_email'),
					"inacurate_information" => $this->input->post('inacurate_information'),
					"email_hygiene" => $this->input->post('email_hygiene'),
					"complaint_avoidance" => $this->input->post('complaint_avoidance'),
					//"comm1" => $this->input->post('comm1'),
					"comm2" => $this->input->post('comm2'),
					//"comm3" => $this->input->post('comm3'),
					"comm4" => $this->input->post('comm4'),
					"comm5" => $this->input->post('comm5'),
					"comm6" => $this->input->post('comm6'),
					"comm7" => $this->input->post('comm7'),
					//"comm8" => $this->input->post('comm8'),
					//"comm9" => $this->input->post('comm9'),
					"comm10" => $this->input->post('comm10'),
					"comm11" => $this->input->post('comm11'),
					"comm12" => $this->input->post('comm12'),
					"comm13" => $this->input->post('comm13'),
					"comm14" => $this->input->post('comm14'),
					"comm15" => $this->input->post('comm15'),
					"comm16" => $this->input->post('comm16'),
					//"comm17" => $this->input->post('comm17'),
					"comm18" => $this->input->post('comm18'),
					"comm19" => $this->input->post('comm19'),
					"comm20" => $this->input->post('comm20'),
					//"comm21" => $this->input->post('comm21'),
					//"comm22" => $this->input->post('comm22'),
					"comm23" => $this->input->post('comm23'),
					"comm24" => $this->input->post('comm24'),
					"comm25" => $this->input->post('comm25'),
					"comm26" => $this->input->post('comm26'),
					"comm27" => $this->input->post('comm27'),
					"comm28" => $this->input->post('comm28'),
					"comm29" => $this->input->post('comm29'),
					"comm30" => $this->input->post('comm30'),
					"comm31" => $this->input->post('comm31'),
					"disposition" => $this->input->post('disposition'),
					"contacted_previously" => $this->input->post('contacted_previously'),
					"disposition_selected" => $this->input->post('disposition_selected'),
					"customer_called_first" => $this->input->post('customer_called_first'),
					"customer_called_less_three" => $this->input->post('customer_called_less_three'),
					"customer_called_more_three" => $this->input->post('customer_called_more_three'),
					"reason_for_fatal" => $this->input->post('reason_for_fatal'),
					"inprovement_area" => $this->input->post('inprovement_area'),
					"call_summary" => $this->input->post('call_summary'),
					"tenurity" => $this->input->post('tenurity'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				
				$a = $this->vfs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vfs/email/');
					$field_array["attach_file"] = implode(',',$a);
				
				if($email_id==0){
					$rowid= data_inserter('qa_vfs_email_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_vfs_email_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_vfs_email_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $email_id);
					$this->db->update('qa_vfs_email_feedback',$field_array);
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
					$this->db->update('qa_vfs_email_feedback',$field_array1);
					
				}
				redirect('Qa_vfs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function agent_vfs_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vfs/agent_vfs_feedback.php";
			$data["content_js"] = "qa_od_js.php";
			$data["agentUrl"] = "qa_vfs/agent_vfs_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			$campaign = $this->input->get('campaign');

			$fromDate = $this->input->get('from_date');
			$toDate = $this->input->get('to_date');
			

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
			
			if($campaign!=''){
				
				$qSql="Select count(id) as value from qa_vfs_".$campaign."_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_vfs_".$campaign."_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit') and agent_rvw_date is Null";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
					
					
					if($fromDate!="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit') ";
					}
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vfs_".$campaign."_feedback $cond) xx Left Join
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
	
	
	public function agent_vfs_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vfs/agent_vfs_rvw.php";
			$data["content_js"] = "qa_od_js.php";
			$data["agentUrl"] = "qa_vfs/agent_vfs_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vfs_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["agent_vfs"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data["campaign"]=$campaign;
			
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
				$this->db->update('qa_vfs_'.$campaign.'_feedback',$field_array1);
					
				redirect('Qa_vfs/agent_vfs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
////////////////////////////////////////////// VFS Report //////////////////////////////////////////////////

	public function qa_vfs_report(){
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
			$data["content_template"] = "qa_vfs/qa_vfs_report.php";
			$data["content_js"] = "qa_od_js.php";
			
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
			
			$data["qa_vfs_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_vfs_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_vfs_list"] = $fullAray;
				$this->create_qa_vfs_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_vfs/download_qa_vfs_CSV/".$campaign;
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
	 

	public function download_qa_vfs_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VFS ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_vfs_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "Qa_vfs";
		$main_url = "";
		
		$fopen = fopen($filename,"w+");
		
		if($campaign=='chat'){

			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Chat Date", "AHT", "Mission", "Recording ID", "Week", "Host/Country", "Audit Type", "VOC","Audit Link", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Fatal/Non Fatal","Agent Tenurity","ACPT", "Possible Score", "Earned Score", "Overall Score Percentage",
			 "Opening - a)Appropriate greeting as per script",
			 "Technical aspects - a)Response Time",
			 "Technical aspects - b)FCR achieved",
			 "Technical aspects - c)Complete and accurate information",
			 "Technical aspects - d)Understand the issue of the applicant & Attentiveness displayed", 
			 "Technical aspects - e)Paraphrasing", 
			 "Technical aspects - f)Used all the available resources for providing resolution", 
			 "Technical aspects - g)Appropriate Probing", 
			 "Additions - a)Offers VAS options wherever applicable", 
			 "Additions - b)Awareness created with regards to VFS website (wherever applicable)", 
			 "Documentation - a)Correct dispostion",
			 "Hold Protocol - a)Was Hold Required",
			 "Communication - a)Formatting", 
			 "Communication - b)Avoid Negative statements",
			 "Communication - c)Telling the customer what to do next Step by step procedure guide",
			 "Communication - d)Avoid Slangs & Jargons", 
			 "Communication - e)Correct and accurate grammar usage / Avoid spelling mistakes",
			 "Communication - f)Further assistance", 
			 "Chat Closing - a)Adherence to chat closing script",
			 "Fatal Parameter - a)Delayed opening",
			 "Fatal Parameter - b)Rude on chat", 
			 "Fatal Parameter - c)Incomplete/Inaccurate Information shared", 
			 "Fatal Parameter - d)Complaint Avoidance",
			 "Comments","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16","Comments 17","Comments 18","Comments 19","Comments 20","Comments 21","Comments 22",
			   "First Time Resolution (FTR):a. Disposition",
			   "Comments 23",
			   "First Time Resolution (FTR):b. Communication mode through which customer contacted previously",
			   "Comments 24",
			   "First Time Resolution (FTR):c. Description of Disposition selected",
			   "Comments 25",
			   "First Time Resolution (FTR):d. Was this the first time customer called us ?",
			   "Comments 26",
			   "First Time Resolution (FTR):e. Did the customer contact us more than once but less than 3 times ?",
			   "Comments 27",
			   "First Time Resolution (FTR):f. Did the customer contact us more than 3 times ?",
			   "Comments 28",
			   "Chat Summary", "Feedback", "Agent Review Date","Agent Acceptance", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='call'){
			
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "AHT", "Mission", "Recording ID", "Week", "Host Country", "Audit Type", "VOC","Audit Link","ACPT", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Fatal/Non Fatal","Agent Tenurity", "Possible Score", "Earned Score", "Overall Score Percentage", "Opening - a)Appropriate greeting - as per script & Clear and Crisp opening", "Communication - a)Voice modulation (Maintained proper tone & pitch & volume throughout the call) & Appropriate pace & clarity of speech", "Communication - b)Empathy on call & Personalization / Power words", "Communication - c)Adjusted to customer language & Courteous & Professional", "Communication - d)No jargons - simple words used & Avoid fumbling & fillers", "Communication - e)Active listening / Attentiveness & Paraphrasing & Acknowledgment", "Communication - f)Grammatically correct sentences & Comprehension","Technical aspects - a)Appropriate Probing", "Technical aspects - b)Took ownership to resolve customers concern", "Technical aspects - c)Escalate the issue wherever required", "Technical aspects - d)Call control","Technical aspects - e)Query resolved on call - FTR","Technical aspects - f)Step by step procuedure to resolve the QRC(Query/Request/Complaint)","Value Additons- a)Offers VAS options wherever applicable", "Value Additons - b. Awareness created with regards to VFS website (wherever applicable)", "Documentation - a)Correct dispostion", "Documentation - b)Update ASM V2","Hold Protocol - a)Hold Guidelines followed","Call Closing - a)Further assistance & Adherence to call closing script", "Call Closing - b)Attempt to take feedback on experience CSAT","Fatal Parameter - a)Delayed opening", "Fatal Parameter - b)Rude on chat", "Fatal Parameter - c)Incomplete/Inaccurate Information shared", "Fatal Parameter - d)Complaint Avoidance","Comments 0","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16","Comments 17","Comments 18","Comments 19","Comments 20","Comments 21","Comments 22","Comments 23","Disposition","Communication mode through which customer contacted previously","Description of Disposition selected","Was this the first time customer called us?","Did the customer call us more than once but less than 3 times?","Did the customer call us more than 3 times?","Comments 24","Comments 25","Comments 26",
				 "Call Summary", "Feedback","Agent Review Date","Agent Acceptance", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='email'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Chat Date", "AHT", "Mission", "Recording ID", "Week", "Host Country", "Audit Type", "VOC","Audit Link", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Fatal/Non Fatal","Agent Tenurity","Target", "Total Score", "Overall Score Percentage",
			 "Content Writing - a) Greeting & Salutation used correctly",
			 "Content Writing - b)Used bullet points where appropriate", 
			 "Content Writing - c)Used one idea per paragraph & Simple & definite statements", 
			 "Content Writing - d)Template Adherence where applicable", 
			 "Accuracy follow up - a)Interim response provided", 
			 "Accuracy follow up - b)FCR achieved", 
			 "Accuracy follow up -c) Complete and accurate information",
			 "Accuracy follow up - d)Understand the issue of the customer & Attentiveness displayed",
			 "Accuracy follow up - e)Used all the available resources for providing resolution",
			 "Accuracy follow up - f)Standardized subject line on trail mails", 
			 "Additions - a)Offers VAS options wherever applicable", 
			 "Additions - b)Awareness created with regards to VFS website", 
			 "Documentation - a)Correct dispostion", 
			 "Documentation - b)Update ASM V2", 
			 "Composition - a)Formatting", 
			 "Composition - b)Telling the customer what to do next", 
			 "Composition - c)Avoid Slangs & Jargons", 
			 "Composition - d)Correct and accurate grammar usage",  
			 "Composition - e)Further assistance & Correct closing",
			 "Fatal Parameter - a)Rude or unprofessional on email",
			 "Fatal Parameter - b)Incomplete", 
			 "Fatal Parameter - c)Email hygiene", 
			 "Fatal Parameter - d)Complaint Avoidance", 
			 "Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16","Comments 17","Comments 18","Comments 19","Comments 20","Comments 21","Comments 22", "Disposition","Communication mode through which customer contacted previously","Description of Disposition selected","Was this the first time customer called us?","Did the customer call us more than once but less than 3 times?","Did the customer call us more than 3 times?",
			 "Reason For Fatal Error", "Inprovement Area", "Email Summary", "Feedback", "Agent Review Date","Agent Acceptance", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='chat'){
			$edit_url = "add_edit_vfs_chat";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;
			
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
				$main_urls = $main_url.'/'.$user['id'];
			
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
				$row .= '"'.$user['host_country'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['autofail_status'].'",';
				$row .= '"'.$user['tenurity'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['appropiate_greeting'].'",';
				$row .= '"'.$user['response_time'].'",';
				$row .= '"'.$user['FCR_achieved'].'",';
				$row .= '"'.$user['accurate_information'].'",';
				$row .= '"'.$user['understand_issue'].'",';
				$row .= '"'.$user['paraphrasing'].'",';
				$row .= '"'.$user['use_available_resource'].'",';
				$row .= '"'.$user['appropiate_probing'].'",';
				$row .= '"'.$user['VAS_options'].'",';
				$row .= '"'.$user['awareness_created'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'.$user['hold_required'].'",';
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
				$row .='"'.$user['comm0'].'",';
				$row .='"'.$user['comm1'].'",';
				$row .='"'.$user['comm2'].'",';
				$row .='"'.$user['comm3'].'",';
				$row .='"'.$user['comm4'].'",';
				$row .='"'.$user['comm6'].'",';
				$row .='"'.$user['comm7'].'",';
				$row .='"'.$user['comm8'].'",';
				$row .='"'.$user['comm9'].'",';
				$row .='"'.$user['comm10'].'",';
				$row .='"'.$user['comm11'].'",';
				$row .='"'.$user['comm13'].'",';
				$row .='"'.$user['comm15'].'",';
				$row .='"'.$user['comm16'].'",';
				$row .='"'.$user['comm17'].'",';
				$row .='"'.$user['comm18'].'",';
				$row .='"'.$user['comm19'].'",';
				$row .='"'.$user['comm20'].'",';
				$row .='"'.$user['comm21'].'",';
				$row .='"'.$user['comm22'].'",';
				$row .='"'.$user['comm23'].'",';
				$row .='"'.$user['comm24'].'",';
				$row .='"'.$user['comm25'].'",';
				$row .='"'.$user['comm32'].'",';
				$row .='"'.$user['comm26'].'",';
				$row .='"'.$user['comm33'].'",';
				$row .='"'.$user['comm27'].'",';
				$row .='"'.$user['comm34'].'",';
				$row .='"'.$user['comm28'].'",';
				$row .='"'.$user['customer_called_first'].'",';
				$row .='"'.$user['comm29'].'",';
				$row .='"'.$user['customer_contact_more_one_less_three'].'",';
				$row .='"'.$user['comm30'].'",';
				$row .='"'.$user['customer_contact_more_three'].'",';
				$row .='"'.$user['comm31'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
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
			$edit_url = "add_edit_vfs_call";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;
			
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
				$main_urls = $main_url.'/'.$user['id'];
			
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
				$row .= '"'.$user['host_country'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['autofail_status'].'",';
				$row .= '"'.$user['tenurity'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['appropiate_greeting'].'",';
				$row .= '"'.$user['voice_modulation'].'",';
				$row .= '"'.$user['call_empathy'].'",';
				$row .= '"'.$user['adjust_customer_language'].'",';
				$row .= '"'.$user['simple_word_used'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['avoid_fumbling'].'",';
				$row .= '"'.$user['appropiate_probing'].'",';
				$row .= '"'.$user['ownership_resolve'].'",';
				$row .= '"'.$user['escalate_issue'].'",';
				$row .= '"'.$user['call_control'].'",';
				$row .= '"'.$user['query_resolved'].'",';
				$row .= '"'.$user['procuedure_request'].'",';
				$row .= '"'.$user['offers_VAS'].'",';
				$row .= '"'.$user['awareness_created'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'.$user['update_ASM'].'",';
				$row .= '"'.$user['hold_required'].'",';
				$row .= '"'.$user['further_assistance'].'",';
				$row .= '"'.$user['CSAT_experience_feedback'].'",';
				$row .= '"'.$user['delayed_opening'].'",';
				$row .= '"'.$user['rude_on_call'].'",';
				$row .= '"'.$user['incomplete_information'].'",';
				$row .= '"'.$user['complaint_avoidance'].'",';
				//$row .= '"'.$user['absence_disposition'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm0'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm20'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm21'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm23'])).'",';
				
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['contacted_previously'].'",';
				$row .= '"'.$user['disposition_selected'].'",';
				$row .= '"'.$user['customer_called_first'].'",';
				$row .= '"'.$user['customer_called_less_three'].'",';
				$row .= '"'.$user['customer_called_more_three'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm24'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm25'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm26'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
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
			$edit_url = "add_edit_vfs_email";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;
			
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
				$main_urls = $main_url.'/'.$user['id'];
			
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
				$row .= '"'.$user['host_country'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['autofail_status'].'",';
				$row .= '"'.$user['tenurity'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';

				$row .= '"'.$user['salutation'].'",';
				$row .= '"'.$user['use_bullet_point'].'",';
				//$row .= '"'.$user['adhered_word_limit'].'",';
				$row .= '"'.$user['definite_statements'].'",';
				$row .= '"'.$user['template_adherence'].'",';
				$row .= '"'.$user['interim_responce'].'",';
				$row .= '"'.$user['FCR_achieved'].'",';
				$row .= '"'.$user['complete_information'].'",';
				// $row .= '"'.$user['understand_issue'].'",';
				// $row .= '"'.$user['attentiveness_display'].'",';
				$row .= '"'.$user['customer_attentiveness'].'",';
				$row .= '"'.$user['use_available_resource'].'",';
				$row .= '"'.$user['standardized_subject'].'",';
				$row .= '"'.$user['VAS_option'].'",';
				$row .= '"'.$user['awarreness_created'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'.$user['update_ASM'].'",';
				$row .= '"'.$user['formatting'].'",';
				//$row .= '"'.$user['show_customer_feel_value'].'",';
				$row .= '"'.$user['procedure_guide_step'].'",';
				$row .= '"'.$user['avoid_slangs'].'",';
				$row .= '"'.$user['correct_grammar_use'].'",';
				//$row .= '"'.$user['correct_closing'].'",';
				//$row .= '"'.$user['further_assistance'].'",';
				$row .= '"'.$user['correct_assistance'].'",';
				$row .= '"'.$user['rude_on_email'].'",';
				$row .= '"'.$user['inacurate_information'].'",';
				$row .= '"'.$user['email_hygiene'].'",';
				$row .= '"'.$user['complaint_avoidance'].'",';
			
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm27'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm28'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm29'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm20'])).'",';
				
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm30'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm23'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm24'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm25'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm26'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['disposition'])).'",';

				$row .= '"'.$user['contacted_previously'].'",';
				$row .= '"'.$user['disposition_selected'].'",';
				$row .= '"'.$user['customer_called_first'].'",';
				$row .= '"'.$user['customer_called_less_three'].'",';
				$row .= '"'.$user['customer_called_more_three'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_for_fatal'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['inprovement_area'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
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
	
	function import_vfs_chat_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","call_date","call_duration","fusion_id","auditor_mwp_id","mission","recording_id","week","audit_type","auditor_type","voc","autofail_status","overall_score","possible_score","earned_score",
				"appropiate_greeting","response_time","FCR_achieved",
				"accurate_information","understand_issue","attentiveness_display","paraphrasing","use_available_resource","appropiate_probing","VAS_options","awareness_created","correct_disposition","update_ASM","hold_required","hold_guidelines","formatting","avoid_negative_statement","procedure_guide_step","avoid_slangs","correct_grammar_use","further_assistance","chat_adherence","used_applicant","delayed_opening","rude_on_chat","inacurate_information","complaint_avoidance","comm0","comm1","comm2","comm3","comm4","comm5","comm6","comm7","comm8","comm9","comm10","comm11","comm12","comm13","comm14","comm15","comm16","comm17","comm18","comm19","comm20","comm21","comm22","comm23","comm24","comm25","reason_for_fatal","inprovement_area",
				"call_summary","feedback");
			
			foreach($object->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				
				$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$adjustedColumnIndex = $columnIndex + $adjustment;
				$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			
				$dd = array();
				$user_list = array();
				
				for($col=0; $col<$adjustedColumnIndex; $col++){
					$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);
							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							$user_list[$row]['entry_by']   			=  $current_user;
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							// echo"<pre>";
							// print_r($tl_agent_ids);
							// echo"</pre>";

						}
						//else if($key=="actual_talk_time"){
						// 	$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						// }
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				// die();
			
				$this->Qa_philip_model->vfs_chat_insert_excel($user_list);
				redirect('Qa_vfs');
			}
		}
	}

	function import_vfs_call_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","call_date","call_duration","fusion_id","auditor_mwp_id","mission","recording_id","week","audit_type","auditor_type","voc","autofail_status","overall_score","possible_score","earned_score",
				"appropiate_greeting","clear_opening","voice_modulation","appropiate_pace","professional_courteous","call_empathy","adjust_customer_language","simple_word_used","active_listening","paraprasing","avoid_fumbling","appropiate_probing","escalate_issue","call_control","query_resolved","offers_VAS","awareness_created","correct_disposition","update_ASM","hold_required","hold_guidelines","dead_air_8sec","further_assistance","CSAT_experience_feedback","call_adherence","procuedure_request","ownership_resolve","used_applicant","delayed_opening","rude_on_call","incomplete_information","complaint_avoidance","absence_disposition","comm0","comm1","comm2","comm3","comm4","comm5","comm6","comm7","comm8","comm9","comm10","comm11","comm12","comm13","comm14","comm15","comm16","comm17","comm18","comm19","comm20","comm21","comm22","comm23","comm24","comm25","comm26","comm27","comm28","comm29","disposition","contacted_previously","disposition_selected","customer_called_first","customer_called_less_three","customer_called_more_three","reason_for_fatal","inprovement_area",
				"call_summary","feedback");
			
			foreach($object->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				
				$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$adjustedColumnIndex = $columnIndex + $adjustment;
				$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			
				$dd = array();
				$user_list = array();
				
				for($col=0; $col<$adjustedColumnIndex; $col++){
					$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);
							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							$user_list[$row]['entry_by']   			=  $current_user;
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							// echo"<pre>";
							// print_r($tl_agent_ids);
							// echo"</pre>";

						}
						//else if($key=="actual_talk_time"){
						// 	$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						// }
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				// die();
			
				$this->Qa_philip_model->vfs_call_insert_excel($user_list);
				redirect('Qa_vfs');
			}
		}
	}

	function import_vfs_email_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","call_date","call_duration","auditor_mwp_id","mission","recording_id","week","audit_type","auditor_type","voc","autofail_status","overall_score","earned_score","possible_score","use_paragraph_idea","use_bullet_point","adhered_word_limit","template_adherence","interim_responce","FCR_achieved","complete_information","understand_issue","attentiveness_display","use_available_resource","standardized_subject","VAS_option","awarreness_created","correct_disposition","update_ASM","formatting","show_customer_feel_value","procedure_guide_step","avoid_slangs","correct_grammar_use","correct_closing","further_assistance","used_applicant","rude_on_email","inacurate_information","email_hygiene","complaint_avoidance","reason_for_fatal","inprovement_area","comm1","comm2","comm3","comm4","comm5","comm6","comm7","comm8","comm9","comm10","comm11","comm12","comm13","comm14","comm15","comm16","comm17","comm18","comm19","comm20","comm21","comm22","comm23","comm24","comm25","comm26","disposition","contacted_previously","customer_called_first","customer_called_less_three","customer_called_more_three","disposition_selected","salutation","definite_statements","customer_attentiveness","correct_assistance","comm27","comm28","comm29","comm30","comm31","call_summary","feedback");
			
			foreach($object->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				
				$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$adjustedColumnIndex = $columnIndex + $adjustment;
				$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			
				$dd = array();
				$user_list = array();
				
				for($col=0; $col<$adjustedColumnIndex; $col++){
					$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);
							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							$user_list[$row]['entry_by']   			=  $current_user;
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							// echo"<pre>";
							// print_r($tl_agent_ids);
							// echo"</pre>";

						}
						//else if($key=="actual_talk_time"){
						// 	$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						// }
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				// die();
			
				$this->Qa_philip_model->vfs_email_insert_excel($user_list);
				redirect('Qa_vfs');
			}
		}
	}

	public function sample_vfs_chat_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_vfs/sample_vfs_chat_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
	public function sample_vfs_call_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_vfs/sample_vfs_call_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_vfs_email_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_vfs/sample_vfs_email_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
 }