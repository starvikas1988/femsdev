<?php 

 class Qa_zoomcar extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
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
			$data["content_template"] = "qa_zoomcar/qa_zoomcar_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,162) and is_assign_process (id,348) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_zoomcar_inb_feedback $cond and audit_type not in ('Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["zoomcar"] = $this->Common_model->get_query_result_array($qSql);
		//////// Others Audit //////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_zoomcar_inb_feedback $cond and audit_type in ('Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["zoomcar_oth"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_zoomcar($zoomcar_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zoomcar/add_edit_zoomcar.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['zoomcar_id']=$zoomcar_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,162) and is_assign_process (id,348) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_zoomcar_inb_feedback where id='$zoomcar_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["zoomcar"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"booking_date" => mmddyy2mysql($this->input->post('booking_date')),
					"customer_no" => $this->input->post('customer_no'),
					"booking_id" => $this->input->post('booking_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"active_listening" => $this->input->post('active_listening'),
					"unnecessary_information" => $this->input->post('unnecessary_information'),
					"call_control" => $this->input->post('call_control'),
					"nonbusiness_conversation" => $this->input->post('nonbusiness_conversation'),
					"hold_time" => $this->input->post('hold_time'),
					"unnecessary_hold" => $this->input->post('unnecessary_hold'),
					"call_repitition" => $this->input->post('call_repitition'),
					"stayed_on_call" => $this->input->post('stayed_on_call'),
					"not_confirm_customer_detals" => $this->input->post('not_confirm_customer_detals'),
					"not_follow_right_hold_script" => $this->input->post('not_follow_right_hold_script'),
					"maintain_rate_of_speech" => $this->input->post('maintain_rate_of_speech'),
					"not_follow_right_transfer" => $this->input->post('not_follow_right_transfer'),
					"call_dead_air" => $this->input->post('call_dead_air'),
					"promoting_APP" => $this->input->post('promoting_APP'),
					"not_follow_call_opening" => $this->input->post('not_follow_call_opening'),
					"not_follow_call_closing" => $this->input->post('not_follow_call_closing'),
					"internal_jargans" => $this->input->post('internal_jargans'),
					"sentence_construction" => $this->input->post('sentence_construction'),
					"matching_customer_language" => $this->input->post('matching_customer_language'),
					"incomplete_notes" => $this->input->post('incomplete_notes'),
					"incorrect_issue" => $this->input->post('incorrect_issue'),
					"accurate_action" => $this->input->post('accurate_action'),
					"creating_duplicate" => $this->input->post('creating_duplicate'),
					"tracker_incomplete_notes" => $this->input->post('tracker_incomplete_notes'),
					"not_capture_customer_number" => $this->input->post('not_capture_customer_number'),
					"backend_tracker_not_filled" => $this->input->post('backend_tracker_not_filled'),
					"unnecessary_tags" => $this->input->post('unnecessary_tags'),
					"address_all_queries" => $this->input->post('address_all_queries'),
					"not_provide_issue_resolution" => $this->input->post('not_provide_issue_resolution'),
					"not_create_ticket" => $this->input->post('not_create_ticket'),
					"ticket_assign_to_right_queue" => $this->input->post('ticket_assign_to_right_queue'),
					"unnecessary_internal_transfer" => $this->input->post('unnecessary_internal_transfer'),
					"explain_customer_clarification" => $this->input->post('explain_customer_clarification'),
					"provide_accurate_information" => $this->input->post('provide_accurate_information'),
					"setting_wrong_expectation" => $this->input->post('setting_wrong_expectation'),
					"committed_fatal" => $this->input->post('committed_fatal'),
					"unnecessary_customer_routing" => $this->input->post('unnecessary_customer_routing'),
					"rude_urgumentive" => $this->input->post('rude_urgumentive'),
					"call_disconnected" => $this->input->post('call_disconnected'),
					"laughting_customer_situation" => $this->input->post('laughting_customer_situation'),
					"maintain_professionalism" => $this->input->post('maintain_professionalism'),
					"coughed_without_mute" => $this->input->post('coughed_without_mute'),
					"denial_escalation" => $this->input->post('denial_escalation'),
					"did_not_acknowledge" => $this->input->post('did_not_acknowledge'),
					"demonstrate_empathy" => $this->input->post('demonstrate_empathy'),
					"applogize_failed" => $this->input->post('applogize_failed'),
					"applogy_over_applogy" => $this->input->post('applogy_over_applogy'),
					"not_express_adequate" => $this->input->post('not_express_adequate'),
					"not_ask_appropiate_probing" => $this->input->post('not_ask_appropiate_probing'),
					"service_denial_handling" => $this->input->post('service_denial_handling'),
					"use_negative_phrase" => $this->input->post('use_negative_phrase'),
					"interrupt_over_customer" => $this->input->post('interrupt_over_customer'),
					"helping_in_resolution" => $this->input->post('helping_in_resolution'),
					"attempt_deescalation" => $this->input->post('attempt_deescalation'),
					"on_call_assistance" => $this->input->post('on_call_assistance'),
					"query_paraphrasing" => $this->input->post('query_paraphrasing'),
					"efficiency_score" => $this->input->post('efficiency_score'),
					"call_handling_score" => $this->input->post('call_handling_score'),
					"sentence_construction_score" => $this->input->post('sentence_construction_score'),
					"record_accuracy_score" => $this->input->post('record_accuracy_score'),
					"appropiate_resolution_score" => $this->input->post('appropiate_resolution_score'),
					"was_respectful_score" => $this->input->post('was_respectful_score'),
					"demonstrate_desire_score" => $this->input->post('demonstrate_desire_score'),
					"customer_help_score" => $this->input->post('customer_help_score'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($zoomcar_id==0){
					
					$a = $this->zc_upload_files($_FILES['attach_file'], $path='./qa_files/qa_zoomcar/inbound/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_zoomcar_inb_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_zoomcar_inb_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_zoomcar_inb_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $zoomcar_id);
					$this->db->update('qa_zoomcar_inb_feedback',$field_array);
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
					$this->db->where('id', $zoomcar_id);
					$this->db->update('qa_zoomcar_inb_feedback',$field_array1);
					
				}
				
				redirect('qa_zoomcar');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_zoomcar_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zoomcar/agent_zoomcar_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_zoomcar/agent_zoomcar_feedback";
			
			
			$qSql="Select count(id) as value from qa_zoomcar_inb_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_zoomcar_inb_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_zoomcar_inb_feedback $cond ) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_zoomcar_inb_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_zoomcar_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_zoomcar/agent_zoomcar_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_zoomcar/agent_zoomcar_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_zoomcar_inb_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["zoomcar"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_zoomcar_inb_feedback',$field_array1);
					
				redirect('Qa_zoomcar/agent_zoomcar_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////// 
///////////////////////////////// QA Chegg REPORT ///////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_zoomcar_report(){
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
			$data["content_template"] = "qa_zoomcar/qa_zoomcar_report.php";
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
			
			
			$data["qa_zoomcar_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_zoomcar_inb_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_zoomcar_list"] = $fullAray;
				$this->create_qa_zoomcar_CSV($fullAray);	
				$dn_link = base_url()."qa_zoomcar/download_qa_zoomcar_CSV";	
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
	 

	public function download_qa_zoomcar_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Zoom Car Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_zoomcar_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Customer Number", "Booking ID", "Booking Date", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "1.1 Efficiency Score", "1.2 Call handling Score", "1.3 Sentence Construction Score", "1.4 Record Accuracy Score", "2.1 Appropriate Resolution Score", "2.2 Respectful and Courteous Score", "2.3 Demonstrate desire Score", "2.4 Customer Willingness Score", "1.1.1 Active listening", "1.1.2 Un-necessary information sought", "1.1.3 Call control and confidence", "1.1.4 Agent initiated Non Business Related conversation", "1.1.5 Had more hold time/instance", "1.1.6 Had un-necessary hold", "1.1.7 Repetition on the call", "1.1.8 Stayed on call after customer exit (15 sec)", "1.2.1 Did not confirm customer details(Email id/ DOB)", "1.2.2 Did not follow right hold script", "1.2.3 Maintained understandable rate of speech", "1.2.4 Did not follow right transfer script", "1.2.5 Dead air on the call", "1.2.6 Promoting APP on required scenarios", "1.2.7 Did not follow call opening", "1.2.8 Did not follow call closing script", "1.3.1 Internal Jargons", "1.3.2 Grammatical/ pronunciation /sentence construction", "1.3.3 Matching customer preferred Language", "1.4.1 Failed/Inappropriate notes/Incomplete notes on Incident", "1.4.2 Incorrect Issue Types", "1.4.3 Accurate action on customers booking if any", "1.4.4 Creating duplicate ticket", "1.4.5 Incomplete notes in the tracker for backend action", "1.4.6 Did not Capture Customer Alternate Mobile number", "1.4.7 Backend tracker not filled", "1.4.8 Creating duplicate Tags", "2.1.1 Addresses all Queries of the customer", "2.1.2 Issue resolution not provided", "2.1.3 Did not create Ticket when necessary", "2.1.4 Ticket assigning to the right queue", "2.1.5 Unnecessary Internal Transfer", "2.1.6 Explain appropriately when customer sought clarification", "2.1.7 Provided complete and accurate information", "2.1.8 Setting wrong expectation on TAT", "2.1.9 Committed Fatal however Impact was avoided", "2.1.10 Un-necessary customer routing", "2.2.1 Was rude argumentative", "2.2.2 Disconnected the call", "2.2.3 Laughing at the customer/situation", "2.2.4 Maintain professionalism", "2.2.5 Lack of apology when Yawned/Sneezed without mute", "2.2.6 Denial of Escalation", "2.3.1 Did not acknowledge appropriately", "2.3.2 Demonstrated Empathy", "2.3.3 Failed to Apologize", "2.3.4 Un-necessary apology", "2.3.5 Did not express interest in the Customer query", "2.3.6 Did not ask appropriate probing questions", "2.3.7 Service Denial Justification", "2.3.8 Usage of negative phrases", "2.3.9 Talk over the customer", "2.4.1 Did not acknowledge appropriately", "2.4.2 Attempted De escalation", "2.4.3 On call Assistance", "2.4.4 Paraphrasing the query", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
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
			$row .= '"'.$user['customer_no'].'",';
			$row .= '"'.$user['booking_id'].'",';
			$row .= '"'.$user['booking_date'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['efficiency_score'].'",';
			$row .= '"'.$user['call_handling_score'].'",';
			$row .= '"'.$user['sentence_construction_score'].'",';
			$row .= '"'.$user['record_accuracy_score'].'",';
			$row .= '"'.$user['appropiate_resolution_score'].'",';
			$row .= '"'.$user['was_respectful_score'].'",';
			$row .= '"'.$user['demonstrate_desire_score'].'",';
			$row .= '"'.$user['customer_help_score'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['unnecessary_information'].'",';
			$row .= '"'.$user['call_control'].'",';
			$row .= '"'.$user['nonbusiness_conversation'].'",';
			$row .= '"'.$user['hold_time'].'",';
			$row .= '"'.$user['unnecessary_hold'].'",';
			$row .= '"'.$user['call_repitition'].'",';
			$row .= '"'.$user['stayed_on_call'].'",';
			$row .= '"'.$user['not_confirm_customer_detals'].'",';
			$row .= '"'.$user['not_follow_right_hold_script'].'",';
			$row .= '"'.$user['maintain_rate_of_speech'].'",';
			$row .= '"'.$user['not_follow_right_transfer'].'",';
			$row .= '"'.$user['call_dead_air'].'",';
			$row .= '"'.$user['promoting_APP'].'",';
			$row .= '"'.$user['not_follow_call_opening'].'",';
			$row .= '"'.$user['not_follow_call_closing'].'",';
			$row .= '"'.$user['internal_jargans'].'",';
			$row .= '"'.$user['sentence_construction'].'",';
			$row .= '"'.$user['matching_customer_language'].'",';
			$row .= '"'.$user['incomplete_notes'].'",';
			$row .= '"'.$user['incorrect_issue'].'",';
			$row .= '"'.$user['accurate_action'].'",';
			$row .= '"'.$user['creating_duplicate'].'",';
			$row .= '"'.$user['tracker_incomplete_notes'].'",';
			$row .= '"'.$user['not_capture_customer_number'].'",';
			$row .= '"'.$user['backend_tracker_not_filled'].'",';
			$row .= '"'.$user['unnecessary_tags'].'",';
			$row .= '"'.$user['address_all_queries'].'",';
			$row .= '"'.$user['not_provide_issue_resolution'].'",';
			$row .= '"'.$user['not_create_ticket'].'",';
			$row .= '"'.$user['ticket_assign_to_right_queue'].'",';
			$row .= '"'.$user['unnecessary_internal_transfer'].'",';
			$row .= '"'.$user['explain_customer_clarification'].'",';
			$row .= '"'.$user['provide_accurate_information'].'",';
			$row .= '"'.$user['setting_wrong_expectation'].'",';
			$row .= '"'.$user['committed_fatal'].'",';
			$row .= '"'.$user['unnecessary_customer_routing'].'",';
			$row .= '"'.$user['rude_urgumentive'].'",';
			$row .= '"'.$user['call_disconnected'].'",';
			$row .= '"'.$user['laughting_customer_situation'].'",';
			$row .= '"'.$user['maintain_professionalism'].'",';
			$row .= '"'.$user['coughed_without_mute'].'",';
			$row .= '"'.$user['denial_escalation'].'",';
			$row .= '"'.$user['did_not_acknowledge'].'",';
			$row .= '"'.$user['demonstrate_empathy'].'",';
			$row .= '"'.$user['applogize_failed'].'",';
			$row .= '"'.$user['applogy_over_applogy'].'",';
			$row .= '"'.$user['not_express_adequate'].'",';
			$row .= '"'.$user['not_ask_appropiate_probing'].'",';
			$row .= '"'.$user['service_denial_handling'].'",';
			$row .= '"'.$user['use_negative_phrase'].'",';
			$row .= '"'.$user['interrupt_over_customer'].'",';
			$row .= '"'.$user['helping_in_resolution'].'",';
			$row .= '"'.$user['attempt_deescalation'].'",';
			$row .= '"'.$user['on_call_assistance'].'",';
			$row .= '"'.$user['query_paraphrasing'].'",';
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