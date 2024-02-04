<?php 

 class Qa_zovio_follet extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function zf_upload_files($files,$path){
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
	
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/qa_zovio_feedback.php";
			$data["content_js"] = "qa_ameridial_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,184) or is_assign_client (id,185)) and (is_assign_process (id,378) or is_assign_process (id,379)) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_zovio_feedback $cond and audit_type not in ('Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["zovio"] = $this->Common_model->get_query_result_array($qSql);
		//////// Others Audit //////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_zovio_feedback $cond and audit_type in ('Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["zovio_oth"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_zovio($zovio_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/add_edit_zovio.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data['zovio_id']=$zovio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,184) or is_assign_client (id,185)) and (is_assign_process (id,378) or is_assign_process (id,379)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_zovio_feedback where id='$zovio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["zovio"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_no" => $this->input->post('call_no'),
					"call_type" => $this->input->post('call_type'),
					"caller_type" => $this->input->post('caller_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"overall_score" => $this->input->post('overall_score'),
					"rep_greet_caller" => $this->input->post('rep_greet_caller'),
					"rep_use_pleasant_tone" => $this->input->post('rep_use_pleasant_tone'),
					"rep_answer_timely" => $this->input->post('rep_answer_timely'),
					"rep_collect_customer_info" => $this->input->post('rep_collect_customer_info'),
					"rep_collect_caller_location" => $this->input->post('rep_collect_caller_location'),
					"agent_define_case_type" => $this->input->post('agent_define_case_type'),
					"rep_marked_test_date" => $this->input->post('rep_marked_test_date'),
					"rep_record_caller_address" => $this->input->post('rep_record_caller_address'),
					"agent_speak_clearly" => $this->input->post('agent_speak_clearly'),
					"agent_demonstrate_call_email" => $this->input->post('agent_demonstrate_call_email'),
					"agent_use_please_through_call" => $this->input->post('agent_use_please_through_call'),
					"agent_minimize_silence_on_call" => $this->input->post('agent_minimize_silence_on_call'),
					"agent_speak_sincere_voice" => $this->input->post('agent_speak_sincere_voice'),
					"agent_use_correct_sentence" => $this->input->post('agent_use_correct_sentence'),
					"agent_demonstrate_call_patience" => $this->input->post('agent_demonstrate_call_patience'),
					"caller_give_agnet_KUDOS" => $this->input->post('caller_give_agnet_KUDOS'),
					"rep_completely_document_call" => $this->input->post('rep_completely_document_call'),
					"rep_complete_closing" => $this->input->post('rep_complete_closing'),
					"rep_provide_correct_instruction" => $this->input->post('rep_provide_correct_instruction'),
					"rep_assist_the_caller" => $this->input->post('rep_assist_the_caller'),
					"rep_make_appropiate_contact" => $this->input->post('rep_make_appropiate_contact'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($zovio_id==0){
					
					$a = $this->zf_upload_files($_FILES['attach_file'], $path='./qa_files/qa_zovio/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_zovio_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_zovio_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_zovio_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $zovio_id);
					$this->db->update('qa_zovio_feedback',$field_array);
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
					$this->db->where('id', $zovio_id);
					$this->db->update('qa_zovio_feedback',$field_array1);
					
				}
				
				redirect('qa_zovio_follet');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_zovio_follet_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/agent_zovio_follet_feedback.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data["agentUrl"] = "qa_zovio_follet/agent_zovio_follet_feedback";
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			if($campaign=="follet"){ 
				$cmp_tbl="qa_amd_follet_feedback";
			}else if($campaign=="zovio"){
				$cmp_tbl="qa_zovio_feedback";
			}
			
			if($campaign!=''){
				if($this->input->get('btnView')=='View')
				{
					$qSql="Select count(id) as value from $cmp_tbl where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
					$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
					
					$qSql="Select count(id) as value from $cmp_tbl where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
					$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate !="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from $cmp_tbl $cond ) xx Left Join
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
	
	
	public function agent_zovio_follet_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/agent_zovio_follet_rvw.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data["agentUrl"] = "qa_zovio_follet/agent_zovio_follet_feedback";
			$data["campaign"] = $campaign;
			
			if($campaign=="follet"){ 
				$cmp_tbl="qa_amd_follet_feedback";
			}else if($campaign=="zovio"){
				$cmp_tbl="qa_zovio_feedback";
			}
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from $cmp_tbl where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update($cmp_tbl,$field_array1);
					
				redirect('qa_zovio_follet/agent_zovio_follet_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////// Nuwave //////////////////
	public function agent_nuwave_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/agent_nuwave_feedback.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data["agentUrl"] = "qa_zovio_follet/agent_nuwave_feedback";
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$qSql="Select count(id) as value from qa_amd_nuwave_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_amd_nuwave_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			$data["agent_rvw_list"] = array();
			
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
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_nuwave_feedback $cond ) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_nuwave_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_nuwave_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/agent_nuwave_rvw.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data["agentUrl"] = "qa_zovio_follet/agent_nuwave_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_nuwave_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_amd_nuwave_feedback',$field_array1);
					
				redirect('qa_zovio_follet/agent_nuwave_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////// Magnilife //////////////////
	public function agent_magnilife_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/agent_magnilife_feedback.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data["agentUrl"] = "qa_zovio_follet/agent_magnilife_feedback";
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$qSql="Select count(id) as value from qa_amd_magnilife_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_amd_magnilife_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			$data["agent_rvw_list"] = array();
			
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
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_magnilife_feedback $cond ) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_magnilife_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_magnilife_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/agent_magnilife_rvw.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data["agentUrl"] = "qa_zovio_follet/agent_magnilife_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_magnilife_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_amd_magnilife_feedback',$field_array1);
					
				redirect('qa_zovio_follet/agent_magnilife_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////// 
///////////////////////////// QA Zovio Follet REPORT ////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_zovio_follet_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/qa_zovio_follet_report.php";
			$data["content_js"] = "qa_ameridial_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$campaign = $this->input->get('campaign');
			if($campaign=="follet"){ 
				$cmp_tbl="qa_amd_follet_feedback";
			}else if($campaign=="zovio"){
				$cmp_tbl="qa_zovio_feedback";
			}
			
			$data["qa_zovio_follet_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from $cmp_tbl) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_zovio_follet_list"] = $fullAray;
				$this->create_qa_zovio_follet_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_zovio_follet/download_qa_zovio_follet_CSV/".$campaign;	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_zovio_follet_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_zovio_follet_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=='follet'){
			$header = array("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Phone","Call Date","Call Duration","File No","Audit Type","Auditor Type","VOC","Audit Start Time","Audit End Time","Interval (in second)","Overall Score ","Possible Score ","Earned Score ","Did the rep greet the caller promptly and properly? ","Did the rep use a pleasant respectful tone? ","Did the rep answer in a timely manner? ","Did the rep collect and verify the customers information appropriately and accurately? ","Did the rep correctly collect caller's work location and store phone number ","Did the agent correctly define Type of Case? ","Did the rep correctly mark the Date of Test and Expected Results? ","Did the rep correctly idently the Team Member's store location using the provided Excel sheet? ","Did the agent speak clearly concisely and at an appropriate pace? ","Did the agent demonstrate a strong use of empathy in responses where required on the call and in email? ","Did the agent use (please) and (thank you) throughout the call and in email communication? ","Did the agent minimize extended silences throughout the call? ","Did the agent speak with sincere warmth in his/her voice? ","Did the agent use correct sentence structure and grammar in email commumnication? ","Did the agent demonstrate patience with the caller on call and in email communication? ","Did the caller give the agent a KUDOS or express happiness with the rep during this call? ","Did the rep accurately and completely document the call? ","Did the rep complete the correct confirmation and closing? ","Did the rep provide the correct instructions based upon the Type of Case? ","Did the rep do everything possible to assist the caller? ","Did the rep make appropriate phone calls to managers and Health Dept ","Comments 1 ","Comments 2 ","Comments 3 ","Comments 4 ","Comments 5 ","Comments 6 ","Comments 7 ","Comments 8 ","Comments 9 ","Comments 10 ","Comments 11 ","Comments 12 ","Comments 13 ","Comments 14 ","Comments 15 ","Comments 16 ","Comments 17 ","Comments 18 ","Comments 19 ","Comments 20 ","Comments 21 ","Call Summary ","Feedback","Client entry by ","Mgnt review by ","Mgnt review note ","Mgnt review date ","Agent review note ","Agent review date ","Client review by ","Client review note ","Client_rvw_date");
		}else if($campaign=='zovio'){
			$header = array("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Call Date","Call Number","Call Type","Caller Type","Audit Type","Auditor Type", "VOC","Audit Start Time","Audit End Time","Interval (in second)","Overall Score ","Possible Score ","Earned Score ","Did the rep greet the caller promptly and properly? ","Did the rep use a pleasant respectful tone? ","Did the rep answer in a timely manner?","Did the rep collect and verify the customers information appropriately and accurately?","Did the rep correctly collect callers work location and store phone number","Did the agent correctly define Type of Case?","Did the rep correctly mark the Date of Test and Expected Results?","2.5 Did the rep correctly record the callers address?","Did the agent speak clearly concisely and at an appropriate pace?","Did the agent demonstrate a strong use of empathy in responses where required on the call and in email? ","Did the agent use please and thank you throughout the call and in email communication?","Did the agent minimize extended silences throughout the call?","Did the agent speak with sincere warmth in his/her voice? ","Did the agent use correct sentence structure and grammar in email commumnication? ","Did the agent demonstrate patience with the caller on call and in email communication? ","Did the caller give the agent a KUDOS or express happiness with the rep during this call? ","Did the rep accurately and completely document the call? ","Did the rep complete the correct confirmation and closing? ","Did the rep provide the correct instructions based upon the Type of Case? ","Did the rep do everything possible to assist the caller? ","Did the rep make appropriate phone calls to managers and Health Dept ","Comments 1 ","Comments 2 ","Comments 3 ","Comments 4 ","Comments 5 ","Comments 6 ","Comments 7 ","Comments 8 ","Comments 9 ","Comments 10 ","Comments 11 ","Comments 12 ","Comments 13 ","Comments 14 ","Comments 15 ","Comments 16 ","Comments 17 ","Comments 18 ","Comments 19 ","Comments 20 ","Comments 21 ","Call Summary ","Feedback ","Client entry by ","Mgnt review by ","Mgnt review note ","Mgnt review date ","Agent review note ","Agent review date ","Client review by ","Client review note ","Client_rvw_date");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='follet'){
		
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
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['identifynameatbeginning'].'",';
				$row .= '"'.$user['assurancetsatementverbatim'].'",';
				$row .= '"'.$user['msbFinancial'].'",';
				$row .= '"'.$user['speakingtorightparty'].'",';
				$row .= '"'.$user['SbSResolution'].'",';
				$row .= '"'.$user['demographicsinformation'].'",';
				$row .= '"'.$user['minimirandadisclosure'].'",';
				$row .= '"'.$user['statetheclientname'].'",';
				$row .= '"'.$user['askforbalancedue'].'",';
				$row .= '"'.$user['completeinformationtaken'].'",';
				$row .= '"'.$user['askforpaymentonphone'].'",';
				$row .= '"'.$user['askforpostdelaypayment'].'",';
				$row .= '"'.$user['accountforfollowupcall'].'",';
				$row .= '"'.$user['promisetopayaccount'].'",';
				$row .= '"'.$user['splitbalanceinpart'].'",';
				$row .= '"'.$user['offersumsettlement'].'",';
				$row .= '"'.$user['paymentplanwithpayment'].'",';
				$row .= '"'.$user['collectorfollowpropernegotiation'].'",';
				$row .= '"'.$user['didcerpromote'].'",';
				$row .= '"'.$user['didceranswer'].'",';
				$row .= '"'.$user['wascerproactive'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'.$user['cmt20'].'",';
				$row .= '"'.$user['cmt21'].'",';
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
			
		}else if($campaign=='zovio'){
			
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
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_no'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['caller_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['rep_greet_caller'].'",';
				$row .= '"'.$user['rep_use_pleasant_tone'].'",';
				$row .= '"'.$user['rep_answer_timely'].'",';
				$row .= '"'.$user['rep_collect_customer_info'].'",';
				$row .= '"'.$user['rep_collect_caller_location'].'",';
				$row .= '"'.$user['agent_define_case_type'].'",';
				$row .= '"'.$user['rep_marked_test_date'].'",';
				$row .= '"'.$user['rep_record_caller_address'].'",';
				$row .= '"'.$user['agent_speak_clearly'].'",';
				$row .= '"'.$user['agent_demonstrate_call_email'].'",';
				$row .= '"'.$user['agent_use_please_through_call'].'",';
				$row .= '"'.$user['agent_minimize_silence_on_call'].'",';
				$row .= '"'.$user['agent_speak_sincere_voice'].'",';
				$row .= '"'.$user['agent_use_correct_sentence'].'",';
				$row .= '"'.$user['agent_demonstrate_call_patience'].'",';
				$row .= '"'.$user['caller_give_agnet_KUDOS'].'",';
				$row .= '"'.$user['rep_completely_document_call'].'",';
				$row .= '"'.$user['rep_complete_closing'].'",';
				$row .= '"'.$user['rep_provide_correct_instruction'].'",';
				$row .= '"'.$user['rep_assist_the_caller'].'",';
				$row .= '"'.$user['rep_make_appropiate_contact'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'.$user['cmt20'].'",';
				$row .= '"'.$user['cmt21'].'",';
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
	
	
///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////////// QA Nuwave REPORT ////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_nuwave_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/qa_nuwave_report.php";
			$data["content_js"] = "qa_ameridial_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_nuwave_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_amd_nuwave_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_nuwave_list"] = $fullAray;
				$this->create_qa_nuwave_CSV($fullAray);	
				$dn_link = base_url()."qa_zovio_follet/download_qa_nuwave_CSV/";	
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
	
	public function download_qa_nuwave_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Nuwave Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_nuwave_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "File No", "Order ID", "Call Duration", "Interaction", "Audit Type", "VOC", "Overall Score", "Greeting & Identification: Example Thank you for calling NuWave", "Asked and Verified Customer Information: May I please have your Order ID Primary name or e-mail address?", "Used the Callers Name: CSR should address the customer as he/she addresses him/herself Mr. Mrs. Dr. Rev. etc.", "Active Listening: Doesnt interrupt the customer understands customers frame of reference doesnt anticipate or make assumptions", "Communication Skills: Converses in a clear concise manner", "Professionalism: Avoids the use of slang jargon and acronyms", "Empathy Towards Customer: CSR sounds sincere about helping the customer and apologizes", "Courtesy: CSR sounds helpful upbeat friendly and patient", "Put On Hold: Asked customer May I put you on hold or Could you hold while I research this further please?", "Thanked Customer for Holding: CSR thanked customer for holding upon returning to customers call", "Hold Time/Reason Appropriate/Inappropriate: Was it really necessary for the CSR to put the customer on hold?", "Escalation/Referral Procedures: Utilized established guidelines and procedures policy from the leadership team", "Fact Finding: Used probing questions and resources to identify problem", "Verbally Verified Problem Reported: Clearly defined and restated needs reported by the customer", "Managed Customer Expectations: Regarding the order of the product and the shipping time", "Explained: Reason for troubleshooting for possible resolution", "Used Available Resources Well: Referred to knowledge training or other resource programs for order troubleshooting", "Complete & Accurate Customer Documentation: Complete description of the order and or the troubleshooting steps", "Trial Close: Confirmed customer is comfortable with outcome", "Additional Needs Uncovered: CSR asked Is there anything else that I can assist you with today?", "Upsale: Ask customer if the product completely serves their needs", "Used Correct Closing Gave Customer Order Number: Mr. Ms. Mrs. I would like to thank you for ordering with NuWave", "Infractions", "Sub-Infractions", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
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
			
			$row = '"'.$auditorName.'",';
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['file_no'].'",';
			$row .= '"'.$user['order_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['interaction'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['greeting_identification'].'",';
			$row .= '"'.$user['verified_customer'].'",';
			$row .= '"'.$user['use_caller_CSR_name'].'",';
			$row .= '"'.$user['doesnot_interrupt_customer'].'",';
			$row .= '"'.$user['converses_clear_concise_mannaer'].'",';
			$row .= '"'.$user['avoid_use_slang_jargon'].'",';
			$row .= '"'.$user['empathy_toward_customer'].'",';
			$row .= '"'.$user['CSR_sound_helpful'].'",';
			$row .= '"'.$user['gain_customer_permission'].'",';
			$row .= '"'.$user['thanks_customer_holding'].'",';
			$row .= '"'.$user['hold_time_appropiate'].'",';
			$row .= '"'.$user['utilized_established_guidelines'].'",';
			$row .= '"'.$user['use_probing_question'].'",';
			$row .= '"'.$user['verbally_verfied_problem'].'",';
			$row .= '"'.$user['manage_customer_expectation'].'",';
			$row .= '"'.$user['reason_for_troubleshooting'].'",';
			$row .= '"'.$user['use_available_resources'].'",';
			$row .= '"'.$user['complete_customer_documentation'].'",';
			$row .= '"'.$user['customer_comfortable_with_outcome'].'",';
			$row .= '"'.$user['additional_needs_uncovered'].'",';
			$row .= '"'.$user['product_served_their_needs'].'",';
			$row .= '"'.$user['used_correct_closing'].'",';
			$row .= '"'.$user['infractions'].'",';
			$row .= '"'.$user['sub_infractions'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
	}
	
///////////////////////////////////////////////////////////////////////////////////// 
//////////////////////////////// QA Magnilife REPORT ////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_magnilife_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zovio_follet/qa_nuwave_report.php";
			$data["content_js"] = "qa_ameridial_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_magnilife_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_amd_magnilife_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_magnilife_list"] = $fullAray;
				$this->create_qa_magnilife_CSV($fullAray);	
				$dn_link = base_url()."qa_zovio_follet/download_qa_magnilife_CSV/";	
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
	
	public function download_qa_magnilife_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Magnilife Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_magnilife_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","File No","Call Date","Call Duration","Audit Type","Auditor Type","VOC","disposition","Overall Score","Greeting (Agent complied with greeting mentioned Brand and call reason )","Enthusiasm (Agent sounds with enthusiasm good energy when speaking)","Clarity (Agent demonstrate a good level of grammar pronunciation pace and confidence at the time of speaking)","Professionalism (listening skills phone etiquette maintain call control and ethics agent's ethics)","Product knowledge (Agent answers product questions sounds as a product expert)","Accuracy (Agent provides accurate product information to the customer avoid providing false expectation/information to the customer)","Efficiency (Agent works effectively during the call to complete the purpose of the call )","System Knowledge (Agent demonstrates program knowledge)","Offer Information (Agents read offer information to the customer including price and features with good and clear pace)","Purchase confirmation (Agent confirms purchase information including prices provides confirmation number to the customer)","Call Summary","Feedback","Entry By","Entry Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent Feedback Acceptance","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");
		
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
			
			$row = '"'.$auditorName.'",';
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['file_no'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['disposition'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['identifynameatbeginning'].'",';
			$row .= '"'.$user['assurancetsatementverbatim'].'",';
			$row .= '"'.$user['msbFinancial'].'",';
			$row .= '"'.$user['speakingtorightparty'].'",';
			$row .= '"'.$user['SbSResolution'].'",';
			$row .= '"'.$user['demographicsinformation'].'",';
			$row .= '"'.$user['minimirandadisclosure'].'",';
			$row .= '"'.$user['statetheclientname'].'",';
			$row .= '"'.$user['askforbalancedue'].'",';
			$row .= '"'.$user['completeinformationtaken'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
	}
	
	
 }