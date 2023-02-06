<?php 

 class Qa_homeward_health extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	private function homeward_upload_files($files,$path){
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
			$data["content_template"] = "qa_homeward_health/qa_homeward_health_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and is_assign_process (id,754) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_homeward_health_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["homeward_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////	
	public function add_edit_homeward_health($homeward_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeward_health/add_edit_homeward_health.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and is_assign_process (id,754) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['homeward_id']=$homeward_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_homeward_health_feedback where id='$homeward_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["homeward_health"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"call_id" => $this->input->post('call_id'),
					"campaign" => $this->input->post('campaign'),
					"phone_number" => $this->input->post('phone_number'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"custSenEarned" => $this->input->post('custSenEarned'),
					"busiSenEarned" => $this->input->post('busiSenEarned'),
					"complSenEarned" => $this->input->post('complSenEarned'),
					"custSenPossible" => $this->input->post('custSenPossible'),
					"busiSenPossible" => $this->input->post('busiSenPossible'),
					"complSenPossible" => $this->input->post('complSenPossible'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),

					"call_opening" => $this->input->post('call_opening'),
					"confirm_first_name" => $this->input->post('confirm_first_name'),
					"appropriate_scripting" => $this->input->post('appropriate_scripting'),
					"greetings_inbound" => $this->input->post('greetings_inbound'),
					"active_listening" => $this->input->post('active_listening'),
					"positive_tone" => $this->input->post('positive_tone'),
					"positive_language" => $this->input->post('positive_language'),
					"effective_time" => $this->input->post('effective_time'),
					"pace_speech" => $this->input->post('pace_speech'),
					"effective_management" => $this->input->post('effective_management'),
					"address_caller" => $this->input->post('address_caller'),
					"interrupt_caller" => $this->input->post('interrupt_caller'),
					"correct_retension" => $this->input->post('correct_retension'),
					"probing_questions" => $this->input->post('probing_questions'),
					"hold_policy" => $this->input->post('hold_policy'),
					"dead_air" => $this->input->post('dead_air'),
					"hold_verbiage" => $this->input->post('hold_verbiage'),
					"accomplish_resolution" => $this->input->post('accomplish_resolution'),
					"followup_steps" => $this->input->post('followup_steps'),
					"answered_caller" => $this->input->post('answered_caller'),
					"policies_procedures" => $this->input->post('policies_procedures'),
					"offers_telephone" => $this->input->post('offers_telephone'),
					"verify_members" => $this->input->post('verify_members'),
					"additional_assistance" => $this->input->post('additional_assistance'),
					"thanks_member" => $this->input->post('thanks_member'),
					"call_documentated" => $this->input->post('call_documentated'),
					"unprofessionalism" => $this->input->post('unprofessionalism'),
					"critical_error" => $this->input->post('critical_error'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
				);
				
				// echo"<pre>";
				// print_r($field_array);
				// echo"</pre>";
			
				if($homeward_id==0){
					
					$a = $this->homeward_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeward_health/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_homeward_health_feedback',$field_array);
					//echo ($this->db->last_query()); 
					//	exit();
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_homeward_health_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_homeward_health_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $homeward_id);
					$this->db->update('qa_homeward_health_feedback',$field_array);
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
					$this->db->where('id', $homeward_id);
					$this->db->update('qa_homeward_health_feedback',$field_array1);
					
				}
				//exit;
				redirect('Qa_homeward_health');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function agent_homeward_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeward_health/agent_homeward_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_homeward_health/agent_homeward_feedback";

			//$data["agentUrl"] = "qa_sensio/agent_sensio_feedback";
			
			$qSql="Select count(id) as value from qa_homeward_health_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_homeward_health_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_homeward_health_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_homeward_health_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_homeward_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeward_health/agent_homeward_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_homeward_health/agent_homeward_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_homeward_health_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["homeward_health"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_homeward_health_feedback',$field_array1);
					
				redirect('qa_homeward_health/agent_homeward_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////// QA Homeward Health ////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_homeward_health_report(){
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
			$data["content_template"] = "qa_homeward_health/qa_homeward_health_report.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$data["qa_homeward_health_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_homeward_health_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_homeward_health_list"] = $fullAray;
				$this->create_qa_homeward_health_CSV($fullAray);	
				$dn_link = base_url()."Qa_homeward_health/download_qa_homeward_health_CSV";	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_homeward_health_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Homeward Health Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_homeward_health_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call ID", "Call Duration", "Campaign", "Phone Number", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Customer score","Business score","Compliance score",
		 "Call Opening: Agent Name and Brand Name", "Confirm the Members First Name", "Use the appropriate scripting", "Greeting for inbound: answered within 5 seconds", "Serving with Empathy - Active Listening", "Serving with Empathy - Positive Tone", "Serving with Empathy - Positive Language/ Rapport Building", "Acknowledgements timely and effectively", "Pace of Speech", "Did the agent used effective engagement", "Address Caller by Name", "Did not Interrupt the caller", "Did the agent used correct USP (unique selling point) for retention", "Asked probing questions effectively or timely", "Hold Policy (60 Seconds)",
		 "Dead Air","Hold Verbiage","Accomplish the resolution accurately and completely","Performed follow-up steps","Answered the caller inquiries","Read out Policies & Procedures","Offers Internal/External Telephone","Verify the Members Full Name/ DOB/ Address/ and Phone Number (All 4)","Offer Additional Assistance","Thanks Member for Calling or taking the time to speak with us","Was the Call Documented appropriately","Unprofessionalism","Critical Error",
		 "Call Opening: Agent Name and Brand Name Remarks", "Confirm the Members First Name Remarks", "Use the appropriate scripting Remarks", "Greeting for inbound: answered within 5 seconds Remarks", "Serving with Empathy - Active Listening Remarks", "Serving with Empathy - Positive Tone Remarks", "Serving with Empathy - Positive Language/ Rapport Building Remarks", "Acknowledgements timely and effectively Remarks", "Pace of Speech Remarks", "Did the agent used effective engagement Remarks", "Address Caller by Name Remarks", "Did not Interrupt the caller Remarks", "Did the agent used correct USP (unique selling point) for retention Remarks", "Asked probing questions effectively or timely Remarks", "Hold Policy (60 Seconds) Remarks",
		 "Dead Air Remarks","Hold Verbiage Remarks","Accomplish the resolution accurately and completely Remarks","Performed follow-up steps Remarks","Answered the caller inquiries Remarks","Read out Policies & Procedures Remarks","Offers Internal/External Telephone Remarks","Verify the Members Full Name/ DOB/Address/ and Phone Number (All 4) Remarks","Offer Additional Assistance Remarks","Thanks Member for Calling or taking the time to speak with us Remarks","Was the Call Documented appropriately Remarks","Unprofessionalism Remarks","Critical Error Remarks",
		 "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
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

			$interrupt_caller =  $user['interrupt_caller'];
			$dead_air = $user['dead_air'];

			if($interrupt_caller== 'Yes'){
				$interrupt_caller = 'No';
			}
			if($interrupt_caller== 'No'){
				$interrupt_caller = 'Yes';
			}

			if($dead_air== 'Yes'){
				$dead_air = 'No';
			}
			if($dead_air== 'No'){
				$dead_air = 'Yes';
			}
		
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['phone_number'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['customer_score'].'%'.'",';
			$row .= '"'.$user['business_score'].'%'.'",';
			$row .= '"'.$user['compliance_score'].'%'.'",';
			$row .= '"'.$user['call_opening'].'",';
			$row .= '"'.$user['confirm_first_name'].'",';
			$row .= '"'.$user['appropriate_scripting'].'",';
			$row .= '"'.$user['greetings_inbound'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['positive_tone'].'",';
			$row .= '"'.$user['positive_language'].'",';
			$row .= '"'.$user['effective_time'].'",';
			$row .= '"'.$user['pace_speech'].'",';
			$row .= '"'.$user['effective_management'].'",';
			$row .= '"'.$user['address_caller'].'",';
			$row .= '"'.$interrupt_caller.'",';
			$row .= '"'.$user['correct_retension'].'",';
			$row .= '"'.$user['probing_questions'].'",';
			$row .= '"'.$user['hold_policy'].'",';
			$row .= '"'.$dead_air.'",';
			$row .= '"'.$user['hold_verbiage'].'",';
			$row .= '"'.$user['accomplish_resolution'].'",';
			$row .= '"'.$user['followup_steps'].'",';
			$row .= '"'.$user['answered_caller'].'",';
			$row .= '"'.$user['policies_procedures'].'",';
			$row .= '"'.$user['offers_telephone'].'",';
			$row .= '"'.$user['verify_members'].'",';
			$row .= '"'.$user['additional_assistance'].'",';
			$row .= '"'.$user['thanks_member'].'",';
			$row .= '"'.$user['call_documentated'].'",';
			$row .= '"'.$user['unprofessionalism'].'",';
			$row .= '"'.$user['critical_error'].'",';
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
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
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