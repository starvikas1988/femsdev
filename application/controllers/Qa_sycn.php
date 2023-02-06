<?php 

 class Qa_sycn extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_philip_model');
	}
	
	
	private function zc_upload_files($files,$path)
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
			$data["content_template"] = "qa_sycn/qa_sycn_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,49) and is_assign_process (id,61) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			$ops_cond="";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["sycn"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_outbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["sycn_outbound"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_sycn($sycn_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sycn/add_edit_sycn.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['sycn_id']=$sycn_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,49) and is_assign_process (id,61) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_sycn_feedback where id='$sycn_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sycn"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"caller_id" => $this->input->post('caller_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"sycn_autofail" => $this->input->post('sycn_autofail'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),
					"agent_welcome_carrier" => $this->input->post('agent_welcome_carrier'),
					"agent_acknowledge" => $this->input->post('agent_acknowledge'),
					"agent_responded_appropiately" => $this->input->post('agent_responded_appropiately'),
					"agent_listen_actively" => $this->input->post('agent_listen_actively'),
					"agent_use_hold_procedure" => $this->input->post('agent_use_hold_procedure'),
					"agent_polite_professional" => $this->input->post('agent_polite_professional'),
					"agent_thank_carrier" => $this->input->post('agent_thank_carrier'),
					"agent_verify_caller" => $this->input->post('agent_verify_caller'),
					"agent_convey_every_details" => $this->input->post('agent_convey_every_details'),
					"agent_escalate_concern" => $this->input->post('agent_escalate_concern'),
					"agent_use_good_jugment" => $this->input->post('agent_use_good_jugment'),
					"agent_leave_complete_notes" => $this->input->post('agent_leave_complete_notes'),
					"agent_follow_correct_procedure" => $this->input->post('agent_follow_correct_procedure'),
					"agent_use_correct_pronounce" => $this->input->post('agent_use_correct_pronounce'),
					"agent_understand_grammar" => $this->input->post('agent_understand_grammar'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($sycn_id==0){
					
					$a = $this->zc_upload_files($_FILES['attach_file'], $path='./qa_files/qa_sycn/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_sycn_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_sycn_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_sycn_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $sycn_id);
					$this->db->update('qa_sycn_feedback',$field_array);
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
					$this->db->where('id', $sycn_id);
					$this->db->update('qa_sycn_feedback',$field_array1);
					
				}
				
				redirect('qa_sycn');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}



	public function add_edit_sycn_outbound($sycn_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sycn/add_edit_sycn_outbound.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['sycn_id']=$sycn_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,49) and is_assign_process (id,61) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_sycn_outbound_feedback where id='$sycn_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sycn"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"caller_id" => $this->input->post('caller_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"sycn_autofail" => $this->input->post('sycn_autofail'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),
					"the_carrier" => $this->input->post('the_carrier'),
					"be_recorded" => $this->input->post('be_recorded'),
					"order_ID" => $this->input->post('order_ID'),
					"speaking_with" => $this->input->post('speaking_with'),
					"give_assurance" => $this->input->post('give_assurance'),
					"active_listening" => $this->input->post('active_listening'),
					"during_the_call" => $this->input->post('during_the_call'),
					"proper_documentation" => $this->input->post('proper_documentation'),
					"courteous_and_helpful" => $this->input->post('courteous_and_helpful'),
					"ending_the_call" => $this->input->post('ending_the_call'),
					"proper_closing" => $this->input->post('proper_closing'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($sycn_id==0){
					
					$a = $this->zc_upload_files($_FILES['attach_file'], $path='./qa_files/qa_sycn/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_sycn_outbound_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_sycn_outbound_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_sycn_outbound_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $sycn_id);
					$this->db->update('qa_sycn_outbound_feedback',$field_array);
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
					$this->db->where('id', $sycn_id);
					$this->db->update('qa_sycn_outbound_feedback',$field_array1);
					
				}
				
				redirect('qa_sycn');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_sycn_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sycn/agent_sycn_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_sycn/agent_sycn_feedback";
			
			
			$qSql1="Select count(id) as value from qa_sycn_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
			
			$qSql2="Select count(id) as value from qa_sycn_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);
		///////////////////////
			$qSql3="Select count(id) as value from qa_sycn_outbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback_outbound"] =  $this->Common_model->get_single_value($qSql3);
			
			$qSql4="Select count(id) as value from qa_sycn_outbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw_outbound"] =  $this->Common_model->get_single_value($qSql4);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') ";
				
				$inbSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_feedback $cond ) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($inbSql);
			///////////////
				$obSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_outbound_feedback $cond ) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list1"] = $this->Common_model->get_query_result_array($obSql);
					
			}else{
	
				$inbSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($inbSql);
			/////////////
				$obSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_outbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list1"] = $this->Common_model->get_query_result_array($obSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_sycn_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sycn/agent_sycn_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_sycn/agent_sycn_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["sycn"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_sycn_feedback',$field_array1);
					
				redirect('Qa_sycn/agent_sycn_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}



	public function agent_sycn_outbound_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sycn/agent_sycn_outbound_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_sycn/agent_sycn_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sycn_outbound_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["sycn"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_sycn_outbound_feedback',$field_array1);
					
				redirect('Qa_sycn/agent_sycn_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
		
///////////////////////////////////////// Report Part ////////////////////////////////////////////

	public function qa_sycn_report(){
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
			$data["content_template"] = "qa_sycn/qa_sycn_report.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_sycn_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if($audit_type=="All"){ 
					if(get_login_type()=="client"){
						$cond .= "audit_type not in ('Operation Audit','Trainer Audit')";
					}else{
						$cond .= "";
					}
				}else{ 
					$cond .=" and audit_type='$audit_type'";
				}
				
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if((get_role_dir()=='tl' && get_user_fusion_id()!='FMAN000616') && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
				
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_sycn_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_sycn_list"] = $fullAray;
				$this->create_qa_sycn_CSV($fullAray);	
				$dn_link = base_url()."qa_sycn/download_qa_sycn_CSV";	
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
	 

	public function download_qa_sycn_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Ship Your Car Now Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_sycn_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Caller ID", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Autofail", "Overall Score", "Customer Critical", "Business Critical", "Compliance Critical", "Did the agent welcome the carrier with the name and company?", "Did the agent acknowledge empathize and gave assurance?", "Did the agent responded appropriately and in a timely manner?", "Did the agent listen actively and intently to the carrier?", "Did the agent use correct Hold procedure?", "Was the agent polite and professional throughout the interaction and remained courteous and helpful?", "Did the agent thank the carrier and give proper closing?", "Did the agent verify that the caller is associated with the order or the person on record?", "Did the agent convey every detail of the process clearly and accurately?", "Did the agent escalate the concern as needed?", "Did the agent use good judgement and decision making while resolving or assisting the carrier?", "Did the agent leave complete notes and proper documentation?", "Did the agent follow correct or proper procedure based on company policy?", "Did the agent use correct pronunciation and proper diction?", "Was the agent easy to understand grammar?", "Remarks1", "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11", "Remarks12", "Remarks13", "Remarks14", "Remarks15", "Call Summary", "Feedback", "Agent Acceptance Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
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
			$row .= '"'.$user['caller_id'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['sycn_autofail'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['customer_score'].'%'.'",';
			$row .= '"'.$user['business_score'].'%'.'",';
			$row .= '"'.$user['compliance_score'].'%'.'",';
			$row .= '"'.$user['agent_welcome_carrier'].'",';
			$row .= '"'.$user['agent_acknowledge'].'",';
			$row .= '"'.$user['agent_responded_appropiately'].'",';
			$row .= '"'.$user['agent_listen_actively'].'",';
			$row .= '"'.$user['agent_use_hold_procedure'].'",';
			$row .= '"'.$user['agent_polite_professional'].'",';
			$row .= '"'.$user['agent_thank_carrier'].'",';
			$row .= '"'.$user['agent_verify_caller'].'",';
			$row .= '"'.$user['agent_convey_every_details'].'",';
			$row .= '"'.$user['agent_escalate_concern'].'",';
			$row .= '"'.$user['agent_use_good_jugment'].'",';
			$row .= '"'.$user['agent_leave_complete_notes'].'",';
			$row .= '"'.$user['agent_follow_correct_procedure'].'",';
			$row .= '"'.$user['agent_use_correct_pronounce'].'",';
			$row .= '"'.$user['agent_understand_grammar'].'",';
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
	//////////////////////////////////////////////////////////////////////////////////////

	function import_voice_inbound_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","call_date","caller_id","audit_type","auditor_type","voc","sycn_autofail","possible_score","earned_score","overall_score","customer_score","business_score","compliance_score","agent_welcome_carrier","agent_acknowledge","agent_responded_appropiately","agent_listen_actively","agent_use_hold_procedure","agent_polite_professional","agent_thank_carrier","agent_verify_caller","agent_convey_every_details","agent_escalate_concern","agent_use_good_jugment","agent_leave_complete_notes","agent_follow_correct_procedure","agent_use_correct_pronounce","agent_understand_grammar","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","call_summary","feedback");
			
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
						}else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->sycn_voice_inbound_data($user_list);
				redirect('Qa_sycn');
			}
		}
	}

	function import_voice_outbound_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","call_date","caller_id","audit_type","auditor_type","voc","sycn_autofail","possible_score","earned_score","overall_score","customer_score","business_score","compliance_score","the_carrier","be_recorded","order_ID","speaking_with","give_assurance","active_listening","during_the_call","proper_documentation","courteous_and_helpful","ending_the_call","proper_closing","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","call_summary","feedback");
			
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
						}else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->sycn_voice_outbound_data($user_list);
				redirect('Qa_sycn');
			}
		}
	}



	public function sample_voice_inbound_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_sycn/sample_voice_inbound_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_voice_outbound_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_sycn/sample_voice_outbound_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
	
}