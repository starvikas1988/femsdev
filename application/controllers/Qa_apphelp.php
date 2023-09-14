<?php 

 class Qa_apphelp extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	public function createPath($path){
		if(!empty($path)){
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
	
	private function audio_upload_files($files,$path)
    {
		$result=$this->createPath($path);
    	if($result){
			$config['upload_path'] = $path;
			$config['allowed_types'] = '*';
			$config['max_size'] = '2024000';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$images = array();
			foreach ($files['name'] as $key => $image) {           
				$_FILES['images[]']['name']= $files['name'][$key];
				$_FILES['images[]']['type']= $files['type'][$key];
				$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
				$_FILES['images[]']['error']= $files['error'][$key];
				$_FILES['images[]']['size']= $files['size'][$key];

				if ($this->upload->do_upload('images[]')) {
					$info = $this->upload->data();
					$images[] = $info['file_name'];
				} else {
					return false;
				}
			}
			return $images;
		}
    }	
	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

/*--------------------------------------------------------------------------------------------------*/
/*------------------------------------------- QA Part ----------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function qa_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_apphelp/qa_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$from_date="";
			$to_date="";
			$agent_id="";
			$cond="";
			$ops_cond="";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,16) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["auditData"]=array();
			
			if($this->input->get('btnView')=='Show')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				$agent_id = $this->input->get('agent_id');
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
				if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$ops_cond=" Where assigned_to='$current_user'";
				}else if(get_login_type()=="client"){
					$ops_cond="";
				}else{
					$ops_cond="";
				}
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_apphelp_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_audit($adt_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_apphelp/add_edit_audit.php";
			$data["content_js"] = "qa_audit_js.php";
			$data['adt_id']=$adt_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,16) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_apphelp_feedback where id='$adt_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($adt_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_apphelp/');
						$field_array["attach_file"] = implode(',',$a);
					}
					$rowid= data_inserter('qa_apphelp_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_apphelp_feedback',$add_array);
				/////////////
					$client_report_url = $this->Common_model->get_single_value('Select qa_report_url as value from client where id=7');
					if($client_report_url==""){
						$this->db->query("Update client set qa_report_url='qa_apphelp/qa_apphelp_report' where id=7");
					}
					
					$process_report_url = $this->Common_model->get_single_value('Select qa_url as value from process where id=16');
					if($process_report_url==""){
						$this->db->query("Update process set qa_url='qa_apphelp/qa_feedback', qa_agent_url='qa_apphelp/agent_apphelp_feedback' where id=16");
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_apphelp/');
						$field_array1["attach_file"] = implode(',',$a);
					}
					$this->db->where('id', $adt_id);
					$this->db->update('qa_apphelp_feedback',$field_array1);
				/////////////
					if(get_login_type()=="client"){
						$edit_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $adt_id);
					$this->db->update('qa_apphelp_feedback',$edit_array);
					
				}
				redirect('qa_apphelp/qa_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/*--------------------------------------------------------------------------------------------------*/
/*------------------------------------------ Agent Part --------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function agent_apphelp_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_apphelp/agent_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_apphelp/agent_apphelp_feedback";
			$from_date = '';
			$to_date = '';
			$adtType = '';
			$cond="";
			
			$adtType .=" audit_type not in ('Calibration','Pre-Certificate Mock Call','Certification Audit')";
			
			$qSql="Select count(id) as value from qa_apphelp_feedback where agent_id='$current_user' and $adtType";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_apphelp_feedback where agent_id='$current_user' and agent_rvw_date is Null and $adtType";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			if($this->input->get('btnView')=='Show')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_apphelp_feedback $cond and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_apphelp_feedback where agent_id='$current_user' and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) ";
				//Where xx.agent_rvw_date is Null
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_apphelp_rvw($adt_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_apphelp/agent_rvw.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_apphelp/agent_apphelp_feedback";
			$data["pnid"]=$adt_id;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_apphelp_feedback where id='$adt_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_apphelp_feedback',$field_array1);
					
				redirect('qa_apphelp/agent_apphelp_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
/*--------------------------------------------------------------------------------------------------*/
/*----------------------------------------- Report Part --------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function qa_apphelp_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_qa/aside.php";
			$data["content_template"] = "qa_apphelp/qa_report.php";
			$data["content_js"] = "qa_audit_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$from_date="";
			$to_date="";
			$audit_type="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$data["auditData"] = array();
			
			if($this->input->get('btnView')=='Show')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				
				if($from_date!="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";
		
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_apphelp_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date"; 
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["auditData"] = $fullAray;
				$this->create_qa_apphelp_CSV($fullAray);	
				$dn_link = base_url()."qa_apphelp/download_qa_apphelp_CSV/";	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_apphelp_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA AppHelp Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_apphelp_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor", "Agent", "Employee MWP ID", "L1/TL Name", "Audit Date", "Ticket Number", "Call/Contact Date", "Partner Name", "External ID/Salesforce Acc #", "Account Holder Name", "KPI-ACPT", "Caller Name", "BPO Team", "LMI Session ID", "Five9 Disposition", "Five9 Campaign", "TW Ticket Status", "Call Driver", "Call ID", "Audit Type", "Auditor Type", "Predictive CSAT", "Audit Start Date and Time", "Audit End Date and Time", "Interval(In Second)", "Overall Score", "Soft Skill Score", "Sales Process Score", "Process and Procedure Score", "Technical Troubleshooting Score",
		"Warm Professional Greeting and First Impressions","Remarks","Fail Reasons1", 
		"Acknowledgement","Remarks","Fail Reasons2",
		"Active Listening and Paraphrasing","Remarks","Fail Reasons3",
		"Assurance","Remarks", "Fail Reasons4",
		"Empathy","Remarks", "Fail Reasons5",
		"Vocal Impact","Remarks", "Fail Reasons6",
		"Call or Chat Control","Remarks", "Fail Reasons7",
		"Professionalism","Remarks", "Fail Reasons8",
		"Closing and Last impressions","Remarks", "Fail Reasons9",
		"Understanding Needs & Buying Signals","Remarks", "Fail Reasons10",
		"Build Value","Remarks", "Fail Reasons11",
		"Overcoming Objections","Remarks", "Fail Reasons12",
		"Sales Accuracy and Confirming sale","Remarks", "Fail Reasons13",
		"Sales Retention","Remarks", "Fail Reasons14",
		"Account Verification","Remarks", "Fail Reasons15",
		"AFK Procedures and Set Proper Expectations","Remarks", "Fail Reasons16",
		"Followed correct TechWeb procedure","Remarks", "Fail Reasons17",
		"Followed correct Five9 procedures","Remarks", "Fail Reasons18", 
		"Followed correct LMI and CASL procedures","Remarks", "Fail Reasons19", 
		"Installed/Explained SPD","Remarks","Fail Reasons20",
		"Followed correct Scam Call Handling Procedures","Remarks","Fail Reasons21",
		"Followed Correct Eastlink/CSG procedures","Remarks",  "Fail Reasons22",
		"Followed Correct Virgin Media Processes","Remarks", "Fail Reasons23",
		"Survey","Remarks", "Fail Reasons24",
		"Technical Probing","Remarks", "Fail Reasons25",
		"Provided the most appropriate solution","Remarks","Fail Reasons26",
		"Provided relevant supporting documentation","Remarks", "Fail Reasons27",
		"Confirmed satisfactory resolution","Remarks", "Fail Reasons28",
		"Auto-Fail","Remarks",
		"Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date and Time", "Agent Review Comment", "Management Review By", "Management Review Date and Time", "Management Review Comment", "Client Review By", "Client Review Date and Time", "Client Review Comment");
		
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
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['ticket_id'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['partner_name'].'",';
			$row .= '"'.$user['salesforce_account'].'",';
			$row .= '"'.$user['account_holder_name'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['caller_name'].'",';
			$row .= '"'.$user['bpo_team'].'",';
			$row .= '"'.$user['session_id'].'",';
			$row .= '"'.$user['five9_disposition'].'",';
			$row .= '"'.$user['five9_campaign'].'",';
			$row .= '"'.$user['tw_ticket_status'].'",';
			$row .= '"'.$user['call_driver'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['soft_skill_score'].'",';
			$row .= '"'.$user['sales_skill_score'].'",';
			$row .= '"'.$user['process_procedure_score'].'",';
			$row .= '"'.$user['technical_troubleshooting_score'].'",';
			$row .= '"'.$user['warm_greeting'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'.$user['warm_greeting_Fail_reason'].'",';
			$row .= '"'.$user['acknowledge'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'.$user['acknowledge_Fail_reason'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'.$user['active_listening_Fail_reason'].'",';
			$row .= '"'.$user['assurance'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'.$user['assurance_Fail_reason'].'",';
			$row .= '"'.$user['empathy'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'.$user['empathy_Fail_reason'].'",';
			$row .= '"'.$user['vocal_impact'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'.$user['vocal_impact_Fail_reason'].'",';
			$row .= '"'.$user['call_chat_control'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'.$user['call_chat_control_Fail_reason'].'",';
			$row .= '"'.$user['professionalism'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'.$user['professionalism_Fail_reason'].'",';
			$row .= '"'.$user['closing_last_impression'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'.$user['closing_last_impression_Fail_reason'].'",';
			$row .= '"'.$user['buying_signal'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'.$user['buying_signal_Fail_reason'].'",';
			$row .= '"'.$user['build_value'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			$row .= '"'.$user['build_value_Fail_reason'].'",';
			$row .= '"'.$user['overcoming_object'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			$row .= '"'.$user['overcoming_object_Fail_reason'].'",';
			$row .= '"'.$user['sales_accuracy'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			$row .= '"'.$user['sales_accuracy_Fail_reason'].'",';
			$row .= '"'.$user['sales_retention'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			$row .= '"'.$user['sales_retention_Fail_reason'].'",';
			$row .= '"'.$user['account_verification'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			$row .= '"'.$user['account_verification_Fail_reason'].'",';
			$row .= '"'.$user['afk_procedure'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
			$row .= '"'.$user['afk_procedure_Fail_reason'].'",';
			$row .= '"'.$user['follow_correct_techweb'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
			$row .= '"'.$user['follow_correct_techweb_Fail_reason'].'",';
			$row .= '"'.$user['follow_correct_five9'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
			$row .= '"'.$user['follow_correct_five9_Fail_reason'].'",';
			$row .= '"'.$user['follow_correct_lmi'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
			$row .= '"'.$user['follow_correct_lmi_Fail_reason'].'",';
			$row .= '"'.$user['explain_spd'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
			$row .= '"'.$user['explain_spd_Fail_reason'].'",';
			$row .= '"'.$user['follow_correct_call_handling'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
			$row .= '"'.$user['follow_correct_call_handling_Fail_reason'].'",';
			$row .= '"'.$user['follow_correct_eastlink'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
			$row .= '"'.$user['follow_correct_eastlink_Fail_reason'].'",';
			$row .= '"'.$user['follow_correct_virgin_media'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
			$row .= '"'.$user['follow_correct_virgin_media_Fail_reason'].'",';
			$row .= '"'.$user['survey'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
			$row .= '"'.$user['survey_Fail_reason'].'",';
			$row .= '"'.$user['technical_probing'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
			$row .= '"'.$user['technical_probing_Fail_reason'].'",';
			$row .= '"'.$user['provided_appropiate_solution'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
			$row .= '"'.$user['provided_appropiate_solution_Fail_reason'].'",';
			$row .= '"'.$user['provided_relevant_support'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
			$row .= '"'.$user['provided_relevant_support_Fail_reason'].'",';
			$row .= '"'.$user['confirm_resolution'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
			$row .= '"'.$user['confirm_resolutionconfirm_resolution'].'",';
			$row .= '"'.$user['autofail'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
		
	}
	
	
	
 }
