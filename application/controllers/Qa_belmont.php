<?php 

 class Qa_belmont extends CI_Controller{
	
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
	
	/* private function audio_upload_files($files,$path)
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
    } */
	
	
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
			$data["content_template"] = "qa_belmont/qa_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$from_date="";
			$to_date="";
			$agent_id="";
			$cond="";
			$ops_cond="";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,820) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select count(blm.id) as audit_cnt, (select count(b1.id) from qa_belmont_feedback b1 where b1.id=blm.id and b1.agnt_fd_acpt='Acceptance') as agn_accepted, (select count(b2.id) from qa_belmont_feedback b2 where b2.id=blm.id and b2.agnt_fd_acpt='Not Acceptance') as agn_not_accepted from qa_belmont_feedback blm";
			$data["barChartData"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select AVG(blm.overall_score) as score from qa_belmont_feedback blm group by blm.audit_type";
			$data["pieChartData"] = $this->Common_model->get_query_row_array($qSql);
			
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
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_belmont_feedback $cond) xx Left Join
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
			$data["content_template"] = "qa_belmont/add_edit_audit.php";
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
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,820) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_belmont_feedback where id='$adt_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
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
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_belmont/');
						$field_array["attach_file"] = implode(',',$a);
					}
					$rowid= data_inserter('qa_belmont_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_belmont_feedback',$add_array);
				/////////////
					$client_report_url = $this->Common_model->get_single_value('Select qa_report_url as value from client where id=375');
					if($client_report_url==""){
						$this->db->query("Update client set qa_report_url='qa_belmont/qa_report' where id=375");
					}
					
					$process_report_url = $this->Common_model->get_single_value('Select qa_url as value from process where id=820');
					if($process_report_url==""){
						$this->db->query("Update process set qa_url='qa_belmont/qa_feedback', qa_agent_url='qa_belmont/agent_belmont_feedback' where id=820");
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_belmont/');
						$field_array1["attach_file"] = implode(',',$a);
					}
					$this->db->where('id', $adt_id);
					$this->db->update('qa_belmont_feedback',$field_array1);
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
					$this->db->update('qa_belmont_feedback',$edit_array);
					
				}
				redirect('qa_belmont/qa_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/*--------------------------------------------------------------------------------------------------*/
/*------------------------------------------ Agent Part --------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function agent_belmont_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_belmont/agent_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_belmont/agent_belmont_feedback";
			$from_date = '';
			$to_date = '';
			$adtType = '';
			$cond="";
			
			$adtType .=" audit_type not in ('Calibration','Pre-Certificate Mock Call','Certification Audit')";
			
			$qSql="Select count(id) as value from qa_belmont_feedback where agent_id='$current_user' and $adtType";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_belmont_feedback where agent_id='$current_user' and agent_rvw_date is Null and $adtType";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_belmont_feedback $cond and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_belmont_feedback where agent_id='$current_user' and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_belmont_rvw($adt_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_belmont/agent_rvw.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_belmont/agent_belmont_feedback";
			$data["pnid"]=$adt_id;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_belmont_feedback where id='$adt_id') xx Left Join
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
				$this->db->update('qa_belmont_feedback',$field_array1);
					
				redirect('qa_belmont/agent_belmont_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
/*--------------------------------------------------------------------------------------------------*/
/*----------------------------------------- Report Part --------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function qa_belmont_report(){
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
			$data["content_template"] = "qa_belmont/qa_report.php";
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_belmont_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date"; 
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["auditData"] = $fullAray;
				$this->create_qa_belmont_CSV($fullAray);	
				$dn_link = base_url()."qa_belmont/download_qa_belmont_CSV/";	
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
	 

	public function download_qa_belmont_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Belmont Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_belmont_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor", "Agent", "Employee MWP ID", "L1/TL Name", "Audit Date", "Ticket/Call ID", "Call Date", "Duration", "Phone Number", "Account#", "ACPT", "L1 Drilldown", "L2 Drilldown", "Audit Type", "Auditor Type", "Predictive CSAT", "Audit Start Date and Time", "Audit End Date and Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "Audit Link",
		"The appropriate greeting was used (in/outbound) or Identifying the company (in/outbound) or Identifying agents name? (in/outbound) or Offer Assistance (inbound) or The customer was informed that the call may be recorded. (outbound) or The representative fully explained the purpose for the call. (outbound)", "Ask for name/account number Or Ask for address Or Ask for last 4 numbers of SSN Or Ask for email", "The customer was informed of full amount due (either current or delinquent)?", "Previous method of payment was mentioned?", "All payment methods were explained (ACH CBP CC etc)?", "Account information was verified prior to saving payment (card number/exp date or routing/account number)?", "The representative offered a reference number?", "The customer was informed of the next payment due date and/or next auto-payment draft date?", "The representative provided accurate account information (balance last payment date etc)?", "Was the representative able to uncover the real issue by asking leading questions (payment date wrong amt too high etc)?", "Did the representative review the account to determine any relevant information?", "Did the representative offer alternative solutions (payment arrangement/settlement advancement re-write payment frequency)?", "Did agent offer confirmation number", "If an answer was unknown by the representative did they ask to place caller on hold to obtain the appropriate information Or Did the representative follow the correct procedures for transferring a call?", "The representative avoided long silences during the call Or Was the customer allowed to speak uninterrupted? Or Was the call kept to the point and efficient? Or Was the call kept to the point and efficient? or Did the representative convey appropriate empathy while maintaining control of the call?", "Did the representative offer any further assistance to the customer? Or Was the call ended on a positive note with a summary/verification of actions taken? Or Did the representative thank the customer for the call?", "Complete Collection",
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
			
			$main_urls = base_url().'qa_belmont/add_edit_audit/'.$user['id'];
			
			$row = '"'.$auditorName.'",';  
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['ticket_id'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['account'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['l1'].'",';
			$row .= '"'.$user['l2'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$main_urls.'",';
			$row .= '"'.$user['appropiate_greeting_used'].'",';
			$row .= '"'.$user['ask_for_name_account'].'",';
			$row .= '"'.$user['customer_was_informed'].'",';
			$row .= '"'.$user['method_payment_mentioned'].'",';
			$row .= '"'.$user['method_payment_explained'].'",';
			$row .= '"'.$user['verify_account_information'].'",';
			$row .= '"'.$user['representative_offered'].'",';
			$row .= '"'.$user['customer_inform_next_payment'].'",';
			$row .= '"'.$user['provide_account_information'].'",';
			$row .= '"'.$user['uncover_real_issue'].'",';
			$row .= '"'.$user['review_account_representative'].'",';
			$row .= '"'.$user['offer_alternative_solution'].'",';
			$row .= '"'.$user['offer_comfirmation_number'].'",';
			$row .= '"'.$user['telephone_skill'].'",';
			$row .= '"'.$user['soft_skill'].'",';
			$row .= '"'.$user['end_call'].'",';
			$row .= '"'.$user['complete_collection'].'",';
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
