<?php 

 class Qa_kabbage extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function kabbage_upload_files($files,$path)
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
			$data["content_template"] = "qa_kabbage/qa_kabbage_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,140) and is_assign_process (id,285) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["kabbage_data"] = $this->Common_model->get_query_result_array($qSql);
		/////////////	
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["kabbage_new"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_two_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["kabbage_new_two"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////	
	public function add_new_feedback($kbg_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kabbage/add_new_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,140) and is_assign_process (id,285) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['kbg_id']=$kbg_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_kabbage_new_feedback where id='$kbg_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["kabbage_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"event" => $this->input->post('event'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_type" => $this->input->post('call_type'),
					"kuserid" => $this->input->post('kuserid'),
					"ticket_id" => $this->input->post('ticket_id'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"overall_score" => $this->input->post('overall_score'),
					"answer_the_call" => $this->input->post('answer_the_call'),
					"reason_for_calling" => $this->input->post('reason_for_calling'),
					"show_empathy" => $this->input->post('show_empathy'),
					"how_help_customer" => $this->input->post('how_help_customer'),
					"hold_distraction" => $this->input->post('hold_distraction'),
					"hold_distraction_chk1" => $this->input->post('hold_distraction_chk1'),
					"hold_distraction_chk2" => $this->input->post('hold_distraction_chk2'),
					"hold_distraction_chk3" => $this->input->post('hold_distraction_chk3'),
					"demonstrate_active_listening" => $this->input->post('demonstrate_active_listening'),
					"thank_caller_choosing_Kabbage" => $this->input->post('thank_caller_choosing_Kabbage'),
					"request_appropiate_document" => $this->input->post('request_appropiate_document'),
					"verify_information" => $this->input->post('verify_information'),
					"verify_information_chk1" => $this->input->post('verify_information_chk1'),
					"verify_information_chk2" => $this->input->post('verify_information_chk2'),
					"verify_information_chk3" => $this->input->post('verify_information_chk3'),
					"verify_information_chk4" => $this->input->post('verify_information_chk4'),
					"verify_information_chk5" => $this->input->post('verify_information_chk5'),
					"disclosing_account" => $this->input->post('disclosing_account'),
					"abide_legal_reruirement" => $this->input->post('abide_legal_reruirement'),
					"gave_correct_information" => $this->input->post('gave_correct_information'),
					"documented_call" => $this->input->post('documented_call'),
					"documented_call_chk1" => $this->input->post('documented_call_chk1'),
					"documented_call_chk2" => $this->input->post('documented_call_chk2'),
					"documented_call_chk3" => $this->input->post('documented_call_chk3'),
					"documented_call_chk4" => $this->input->post('documented_call_chk4'),
					"documented_call_chk5" => $this->input->post('documented_call_chk5'),
					"documented_call_chk6" => $this->input->post('documented_call_chk6'),
					"documented_call_chk7" => $this->input->post('documented_call_chk7'),
					"necessary_single_contact" => $this->input->post('necessary_single_contact'),
					"ask_other_concern" => $this->input->post('ask_other_concern'),
					"auto_fail" => $this->input->post('auto_fail'),
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
					"connect_overall" => $this->input->post('connect_overall'),
					"resolve_overall" => $this->input->post('resolve_overall'),
					"madeeasy_overall" => $this->input->post('madeeasy_overall'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				
				if($kbg_id==0){
					
					$a = $this->kabbage_upload_files($_FILES['attach_file'],$path='./qa_files/qa_kabbage/new_audio/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_kabbage_new_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_kabbage_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_kabbage_new_feedback',$field_array1);
					
				}else{
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->kabbage_upload_files($_FILES['attach_file'],$path='./qa_files/qa_kabbage/new_audio/');
						$field_array['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $kbg_id);
					$this->db->update('qa_kabbage_new_feedback',$field_array);
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
					$this->db->where('id', $kbg_id);
					$this->db->update('qa_kabbage_new_feedback',$field_array1);
					
				}
				redirect('Qa_kabbage');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function colDet()
	{
		return array("opening_spiel","identify_correct","maintain_friendly","distraction_minimum","closing_spiel","appropriate_documents","all_info","specific_info","regulatory_requirements","correct_complete","auto_zero","one_touch");
	}

	public function mainTitle(){
		return array("Did the agent execute the opening spiel properly?","Did the agent ask the correct probing questions and identify the correct reason for calling?","Did the agent show empathy and maintain a friendly, confident, professional tone and demonstrated Active Listening during the entire conversation? - Auto zero for rudeness only","Did the agent keep holds and distractions to a minimum level?","Did the agent execute the closing spiel properly?","Did the agent request all appropriate documents from the caller?","Did the agent verify all information is good?","Did the agent refrain from disclosing account specific information without proper account verification?","Did the agent abide all Legal and Regulatory Requirements? - Auto Zero","Did the agent give Correct and Complete Information? (Set proper Expectations)","Did the agent documented the call properly? (If no, check the box below) - Auto zero for no notes","Did the agent apply the necessary information to create a single contact or one-touch resolution?");
	}

	public function score(){
		return array(3,10,10,10,2,3,10,5,2,10,10,25);
	}

	public function scoreCard(){
		return array("Yes","No","N/A");
	}

	///////////////////////////////////////////////////////////////////	
	public function add_new_two_feedback($kbg_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kabbage/add_new_two_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,140) and is_assign_process (id,285) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			$data["col_det"] = $this->colDet();
			$data["mainTitle"] = $this->mainTitle();
			$data["score"]=$this->score();
			$data["scoreCard"]=$this->scoreCard();

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['kbg_id']=$kbg_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			    from qa_kabbage_new_two_feedback where id='$kbg_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["kabbage_new_two"] = $this->Common_model->get_query_row_array($qSql);
			$curDateTime=CurrMySqlDate();
			$a = array();
			// print_r($data);
			// die;
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
					// print_r($field_array);
			  //      die;
				if($kbg_id==0){
					
					$a = $this->kabbage_upload_files($_FILES['attach_file'],$path='./qa_files/qa_kabbage/new_audio/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_kabbage_new_two_feedback',$field_array);
					print_r($rowid);
					die;
					/////////
					$field_array2['audit_date']=CurrDate();
					$field_array2['audit_start_time'] = $this->input->post('audit_start_time');
					$this->db->where('id', $rowid);
					$this->db->update('qa_kabbage_new_two_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1['entry_by']=$current_user;
					}else{
						$field_array1['entry_by']=$current_user;
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_kabbage_new_two_feedback',$field_array1);
					
				}else{
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->kabbage_upload_files($_FILES['attach_file'],$path='./qa_files/qa_kabbage/new_audio/');
						$field_array['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $kbg_id);
					$this->db->update('qa_kabbage_new_two_feedback',$field_array);
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
					$this->db->where('id', $kbg_id);
					$this->db->update('qa_kabbage_new_two_feedback',$field_array1);
					
				}
				redirect('Qa_kabbage');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////
	
//////////////////////////////////////////////////////////////
	public function mgnt_kabbage_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kabbage/mgnt_kabbage_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,140) and is_assign_process (id,285) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["kabbage_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"event" => $this->input->post('event'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_type" => $this->input->post('call_type'),
					"kuserid" => $this->input->post('kuserid'),
					"ticket_id" => $this->input->post('ticket_id'),
					"overall_score" => $this->input->post('overall_score'),
					"agentanswerthecall" => $this->input->post('agentanswerthecall'),
					"agentrequestdocuments" => $this->input->post('agentrequestdocuments'),
					"documentallsystem" => $this->input->post('documentallsystem'),
					"agentasktohelpcustomer" => $this->input->post('agentasktohelpcustomer'),
					"agentverifyallinformation" => $this->input->post('agentverifyallinformation'),
					"procedural_possible" => $this->input->post('procedural_possible'),
					"procedural_earned" => $this->input->post('procedural_earned'),
					"procedural_score" => $this->input->post('procedural_score'),
					"agentaskkabbagename" => $this->input->post('agentaskkabbagename'),
					"agentaskcallerforSSnumber" => $this->input->post('agentaskcallerforSSnumber'),
					"agentrefraindisclosingAccount" => $this->input->post('agentrefraindisclosingAccount'),
					"agentabideallrequirement" => $this->input->post('agentabideallrequirement'),
					"compliance_possible" => $this->input->post('compliance_possible'),
					"compliance_earned" => $this->input->post('compliance_earned'),
					"compliance_score" => $this->input->post('compliance_score'),
					"agentprovideaccurateinformation" => $this->input->post('agentprovideaccurateinformation'),
					"agentcreatesinglecontact" => $this->input->post('agentcreatesinglecontact'),
					"agentengagedincall" => $this->input->post('agentengagedincall'),
					"agentmaintainfriendlytone" => $this->input->post('agentmaintainfriendlytone'),
					"agentkeepdistractions" => $this->input->post('agentkeepdistractions'),
					"agentasktoendcall" => $this->input->post('agentasktoendcall'),
					"agentthankthecaller" => $this->input->post('agentthankthecaller'),
					//"agentencouragetotalecash" => $this->input->post('agentencouragetotalecash'),
					"customerexp_possible" => $this->input->post('customerexp_possible'),
					"customerexp_earned" => $this->input->post('customerexp_earned'),
					"customerexp_score" => $this->input->post('customerexp_score'),
					"auto_fail" => $this->input->post('auto_fail'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->kabbage_upload_files($_FILES['attach_file'],$path='./qa_files/qa_kabbage/');
					$field_array['attach_file'] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_kabbage_feedback',$field_array);
			/////////////	
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
				$this->db->update('qa_kabbage_feedback',$field_array1);
			///////////	
				redirect('Qa_kabbage');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			$data["array"] = $a;
		}
	}
/////////////////////////////////////////////////////////////////////////////////


	public function agent_kabbage_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kabbage/agent_kabbage_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_kabbage/agent_kabbage_feedback";
			
			$qSql="Select count(id) as value from qa_kabbage_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_kabbage_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		/////////
			$qSql="Select count(id) as value from qa_kabbage_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_kbg_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_kabbage_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_kbg_rvw"] =  $this->Common_model->get_single_value($qSql);

			/////////
			$qSql="Select count(id) as value from qa_kabbage_new_two_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_kbg_feedback_two"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_kabbage_new_two_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_kbg_rvw_two"] =  $this->Common_model->get_single_value($qSql);
				
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			/////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_new_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_two_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_new_two_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			///////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_new_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_two_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_new_two_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_kabbage_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kabbage/agent_kabbage_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_kabbage/agent_kabbage_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["kabbage_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_kabbage_feedback',$field_array1);
					
				redirect('Qa_kabbage/agent_kabbage_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	public function agent_kbg_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kabbage/agent_kbg_new_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_kabbage/agent_kabbage_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["kabbage_new"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_kabbage_new_feedback',$field_array1);
					
				redirect('Qa_kabbage/agent_kabbage_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	////////////////////////////////////////////////////// NEW TWO ////////////////////////////////////////////////////////////////

	public function agent_kbg_new_two_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kabbage/agent_kbg_new_two_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_kabbage/agent_kabbage_feedback";
			$data["col_det"] = $this->colDet();
			$data["mainTitle"] = $this->mainTitle();
			$data["score"]=$this->score();
			$data["scoreCard"]=$this->scoreCard();
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kabbage_new_two_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["kabbage_new"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_kabbage_new_two_feedback',$field_array1);
					
				redirect('Qa_kabbage/agent_kabbage_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////// QA Kabbage REPORT ////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_kabbage_report(){
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
			$data["content_template"] = "qa_kabbage/qa_kabbage_report.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$data["qa_kabbage_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$campaign = $this->input->get('campaign');
				
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_kabbage_list"] = $fullAray;
				$this->create_qa_kabbage_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_kabbage/download_qa_kabbage_CSV";	
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
	 

	public function download_qa_kabbage_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Kabbage Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_kabbage_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=='kabbage'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Event", "Call Duration", "Audit Type", "VOC", "Call Type", "KUSERID", "Ticket ID", "Auto Fail", "Overall Score", "1) Did the agent answer the call with their name?", "2) Did the agent request all appropriate documents from the caller", "3) Did the agent document all systems appropriately?", "4) Did the agent ask how they could help the customer?", "5) Did the agent verify all information is good?", "Procedural Earned Score", "Procedural Possible Score", "Procedural Score", "6) Did the agent ask the caller for their Kabbage User Name?", "7) Did the agent ask the caller for the last four digits of their Social Security Number?", "8) Did the agent refrain from disclosing account specific information", "9) Did the agent abide by all legal and regulatory requirements?", "Compliance Earned Score", "Compliance Possible Score", "Compliance Score", "10) Did the agent provide the caller with accurate information", "11) Did the agent do everything necessary and reasonable to create a single contact", "12) Was the agent engaged in the call with the caller in an effort to resolve the callers issue?", "13) Did the agent maintain a friendly professional tone?", "14) Did the agent keep holds and distractions to a minimum?", "15) Did the agent ask the caller if all their issues were resolved prior to ending the call?", "16) Did the agent thank the caller for choosing Kabbage?", "Customer Experience Earned Score", "Customer Experience Possible Score", "Customer Experience Score", "Procedural Comment1", "Procedural Comment2", "Procedural Comment3", "Procedural Comment4", "Procedural Comment5", "Compliance Comment1", "Compliance Comment2", "Compliance Comment3", "Compliance Comment4", "Customer Experience Comment1", "Customer Experience Comment2", "Customer Experience Comment3", "Customer Experience Comment4", "Customer Experience Comment5", "Customer Experience Comment6", "Customer Experience Comment7", "Customer Experience Comment8", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='kabbage_new'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Event", "Call Duration", "Audit Type", "VOC", "Call Type", "KUSERID", "Ticket ID", "Auto Fail", "Overall Score", "1) Did the agent answer the call with their name and the name of the product?", "2) Identified the correct reason for calling", "3) Did the agent show empathy and maintain professional tone", "4) Did the agent ask how they could help the customer?", "5) Did the agent keep holds and distractions to a minimum?", "5) Checkbox 1", "5) Checkbox 2", "5) Checkbox 3", "6) Demonstrated Active Listening", "7) Did the agent thank the caller for choosing Kabbage?", "8) Did the agent request all appropriate documents from the caller?", "9) Did the agent verify all information is good?", "9) Checkbox 1", "9) Checkbox 2", "9) Checkbox 3", "9) Checkbox 4", "9) Checkbox 5", "10) Refrain from disclosing account specific information", "11) Abide By All Legal and Regulatory Requirements", "12) Gave Correct and Complete Information", "13) Documented the call properly", "13) Checkbox 1", "13) Checkbox 2", "13) Checkbox 3", "13) Checkbox 4", "13) Checkbox 5", "13) Checkbox 6", "13) Checkbox 7", "14) Did the agent do everything necessary and reasonable to create a single contact", "15) Asked for Other Concerns", "Connect Overall(%)", "Resolve Overall(%)", "Made Easy Overall(%)", "Connect Comment1", "Connect Comment2", "Connect Comment3", "Connect Comment4", "Connect Comment5", "Connect Comment6", "Connect Comment7", "Resolve Comment8", "Resolve Comment9", "Resolve Comment10", "Resolve Comment11", "Resolve Comment12", "Resolve Comment13", "Made it easy Comment14", "Made it easy Comment15", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='kabbage'){
			
			foreach($rr as $user){	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
			
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['event'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['kuserid'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['auto_fail'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentanswerthecall'].'",';
				$row .= '"'.$user['agentrequestdocuments'].'",';
				$row .= '"'.$user['documentallsystem'].'",';
				$row .= '"'.$user['agentasktohelpcustomer'].'",';
				$row .= '"'.$user['agentverifyallinformation'].'",';
				$row .= '"'.$user['procedural_possible'].'",';
				$row .= '"'.$user['procedural_earned'].'",';
				$row .= '"'.$user['procedural_score'].'%'.'",';
				$row .= '"'.$user['agentaskkabbagename'].'",';
				$row .= '"'.$user['agentaskcallerforSSnumber'].'",';
				$row .= '"'.$user['agentrefraindisclosingAccount'].'",';
				$row .= '"'.$user['agentabideallrequirement'].'",';
				$row .= '"'.$user['compliance_possible'].'",';
				$row .= '"'.$user['compliance_earned'].'",';
				$row .= '"'.$user['compliance_score'].'%'.'",';
				$row .= '"'.$user['agentprovideaccurateinformation'].'",';
				$row .= '"'.$user['agentcreatesinglecontact'].'",';
				$row .= '"'.$user['agentengagedincall'].'",';
				$row .= '"'.$user['agentmaintainfriendlytone'].'",';
				$row .= '"'.$user['agentkeepdistractions'].'",';
				$row .= '"'.$user['agentasktoendcall'].'",';
				$row .= '"'.$user['agentthankthecaller'].'",';
				//$row .= '"'.$user['agentencouragetotalecash'].'",';
				$row .= '"'.$user['customerexp_possible'].'",';
				$row .= '"'.$user['customerexp_earned'].'",';
				$row .= '"'.$user['customerexp_score'].'%'.'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
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
		
		}else if($campaign=='kabbage_new'){
			
			foreach($rr as $user){	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
			
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['event'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['kuserid'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['auto_fail'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['answer_the_call'].'",';
				$row .= '"'.$user['reason_for_calling'].'",';
				$row .= '"'.$user['show_empathy'].'",';
				$row .= '"'.$user['how_help_customer'].'",';
				$row .= '"'.$user['hold_distraction'].'",';
				$row .= '"'.$user['hold_distraction_chk1'].'",';
				$row .= '"'.$user['hold_distraction_chk2'].'",';
				$row .= '"'.$user['hold_distraction_chk3'].'",';
				$row .= '"'.$user['demonstrate_active_listening'].'",';
				$row .= '"'.$user['thank_caller_choosing_Kabbage'].'",';
				$row .= '"'.$user['request_appropiate_document'].'",';
				$row .= '"'.$user['verify_information'].'",';
				$row .= '"'.$user['verify_information_chk1'].'",';
				$row .= '"'.$user['verify_information_chk2'].'",';
				$row .= '"'.$user['verify_information_chk3'].'",';
				$row .= '"'.$user['verify_information_chk4'].'",';
				$row .= '"'.$user['verify_information_chk5'].'",';
				$row .= '"'.$user['disclosing_account'].'",';
				$row .= '"'.$user['abide_legal_reruirement'].'",';
				$row .= '"'.$user['gave_correct_information'].'",';
				$row .= '"'.$user['documented_call'].'",';
				$row .= '"'.$user['documented_call_chk1'].'",';
				$row .= '"'.$user['documented_call_chk2'].'",';
				$row .= '"'.$user['documented_call_chk3'].'",';
				$row .= '"'.$user['documented_call_chk4'].'",';
				$row .= '"'.$user['documented_call_chk5'].'",';
				$row .= '"'.$user['documented_call_chk6'].'",';
				$row .= '"'.$user['documented_call_chk7'].'",';
				$row .= '"'.$user['necessary_single_contact'].'",';
				$row .= '"'.$user['ask_other_concern'].'",';
				$row .= '"'.$user['connect_overall'].'",';
				$row .= '"'.$user['resolve_overall'].'",';
				$row .= '"'.$user['madeeasy_overall'].'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
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
	
	
 }