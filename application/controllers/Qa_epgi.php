<?php
class Qa_epgi extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}

	public function createPath($path)
	{

		if (!empty($path))
		{

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

	private function epgi_upload_files($files,$path) // this is for file uploaging purpose
	{
	    $result=$this->createPath($path);
	    if($result){
	    $config['upload_path'] = $path;
	    $config['allowed_types'] = '*';

		  $config['allowed_types'] = 'm4a|mp4|mp3|wav';
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

	public function getSiteLocation(){
		if(check_logged_in()){
			$aid=$this->input->post('agent_id');
			$qSql = "Select id,office_id FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_epgi/qa_epgi_feedback.php";
			$data["content_js"] = "qa_epgi_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,401) and is_assign_process (id,883) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_epgi_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["epgi_data"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_epgi($epgi_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_epgi/add_edit_epgi.php";
			$data["content_js"] = "qa_epgi_js.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data['epgi_id']=$epgi_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}


			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,401) and is_assign_process(id,883) and status=1  order by name";
	          $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_epgi_feedback where id='$epgi_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["epgi_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($epgi_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->epgi_upload_files($_FILES['attach_file'], $path='./qa_files/qa_epgi/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_epgi_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_epgi_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_epgi/")){
							mkdir("./qa_files/qa_epgi/");
						}
						$a = $this->epgi_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_epgi/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $epgi_id);
					$this->db->update('qa_epgi_feedback',$field_array1);
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
					$this->db->where('id', $epgi_id);
					$this->db->update('qa_epgi_feedback',$edit_array);

				}

				redirect('Qa_epgi');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	public function agent_epgi_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_epgi/agent_epgi_feedback.php";
			$data["content_js"] = "qa_epgi_js.php";
			$data["agentUrl"] = "qa_epgi/agent_epgi_feedback";


			$qSql="Select count(id) as value from qa_epgi_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_epgi_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";

			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);


			$from_date = '';
			$to_date = '';
			$cond="";
			$user="";

			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));

				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_epgi_feedback $cond and agent_id ='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_epgi_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}

	public function agent_epgi_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_epgi/agent_epgi_rvw.php";
			$data["agentUrl"] = "qa_epgi/agent_epgifeedback";
			$data["content_js"] = "qa_epgi_js.php";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_epgi_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["epgi_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["epgi_id"]=$id;			
			
			if($this->input->post('epgi_id'))
			{
				$epgi_id=$this->input->post('epgi_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $epgi_id);
				$this->db->update('qa_epgi_feedback',$field_array);
				
				redirect('Qa_epgi/agent_epgi_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////// QA EPGI REPORT ////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_epgi_report(){
		if(check_logged_in()){

			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;

			$data["aside_template"] = "reports_qa/aside.php";
			$data["content_template"] = "qa_epgi/qa_epgi_report.php";
			$data["content_js"] = "qa_epgi_js.php";

			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$cond2="";
			$audit_type="";

			$date_from = ($this->input->get('from_date'));
			$date_to = ($this->input->get('to_date'));

			if($date_from==""){
					$date_from=CurrDate();
				}else{
					$date_from = mmddyy2mysql($date_from);
				}

				if($date_to==""){
					$date_to=CurrDate();
				}else{
					$date_to = mmddyy2mysql($date_to);
			}

			$data["qa_epgi_list"] = array();
			//if($this->input->get('show')=='Show') {
			   // $campaign = $this->input->get('campaign');
				
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";

				if($audit_type=="All" || $audit_type=="") $cond2 .= "";
				else $cond2 .=" and audit_type='$audit_type'";

				

				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";

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
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_epgi_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_epgi_list"] = $fullAray;
			 

				$this->create_qa_epgi_CSV($fullAray);

				$dn_link = base_url()."Qa_epgi/download_Qa_epgi_CSV";


			//}
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['from_date'] = $date_from;
			$data['to_date'] = $date_to;
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;

			$this->load->view('dashboard',$data);
		}
	}

	public function download_Qa_epgi_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="EPGI Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_epgi_CSV($rr)
	{

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
	
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "ACPT","Call Type","Call Id","Site", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Phone Number","Possible Score", "Earned Score", "Overall Score","Compliance Score","Customer Score","Business Score",
			"The appropriate greeting was used (inbound/outbound)",
			"The appropriate greeting was used (inbound/outbound) - Remarks",
			"Identifying the company (inbound/outbound)",
			"Identifying the company (inbound/outbound) - Remarks",
			"Offer Assistance (inbound willingness statement)",
			"Offer Assistance (inbound willingness statement) - Remarks",
			"The representative fully explained the purpose for the call. (outbound)",
			"The representative fully explained the purpose for the call. (outbound) - Remarks",
			"Correctly verified & entered patient demographics (existing and new patients)",
			"Correctly verified & entered patient demographics (existing and new patients) - Remarks",
			"Verified insurance is Accepted at EPGI/Offices",
			"Verified insurance is Accepted at EPGI/Offices - Remarks",
			"Correctly entered patients information",
			"Correctly entered patients information - Remarks",
			"Correctly scheduled office visit",
			"Correctly scheduled office visit - Remarks",
			"Correctly scheduled telehealth visit",
			"Correctly scheduled telehealth visit - Remarks",
			"Correctly scheduled hospital follow-up",
			"Correctly scheduled hospital follow-up - Remarks",
			"Correctly sent patient messaging/pods",
			"Correctly sent patient messaging/pods - Remarks",
			"Correctly utilized EPIC link",
			"Correctly utilized EPIC link - Remarks",
			"Correctly utilized phone system with little to no delay in communication",
			"Correctly utilized phone system with little to no delay in communication - Remarks",
			"Used correct procedure for transferring to staff extension or department",
			"Used correct procedure for transferring to staff extension or department - Remarks",
			"Avoided long silences during the call",
			"Avoided long silences during the call - Remarks",
			"Did not interrupt the caller",
			"Did not interrupt the caller - Remarks",
			"Was polite friendly and professional",
			"Was polite friendly and professional - Remarks",
			"Call was kept to the point and utilized time efficiently",
			"Call was kept to the point and utilized time efficiently - Remarks",
			"Conveyed appropriate empathy when necessary while maintaining control of the call",
			"Conveyed appropriate empathy when necessary while maintaining control of the call - Remarks",
			"Offered further assistance",
			"Offered further assistance - Remarks",
			"Call ended on a positive note with a summary/verification of actions and date of appointment(s)",
			"Call ended on a positive note with a summary/verification of actions and date of appointment(s) - Remarks",
			"Thanked the caller for his/her time and branded the call",
			"Thanked the caller for his/her time and branded the call - Remarks",
		    "Call Summary/Observation","Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)","Feedback","Agent Feedback Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

		

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				 if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				 	$interval1 = '---';
				 }else{
				 	$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				 }

				$row = '"'.$user['auditor_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['site'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['compliance_overall_score'].'",';
				$row .= '"'.$user['customer_overall_score'].'",';
				$row .= '"'.$user['business_overall_score'].'",';
				$row .= '"'.$user['appropriate_greeting'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['Identify_company'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['offer_assistance'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['purpose_for_call'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['patient_demographics'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['verified_insurance'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['patients_information'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['office_visit'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['scheduled_telehealth_visit'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['hospital_follow_up'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'.$user['patient_pods'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['utilized_EPIC_link'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['delay_in_communication'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['transferring_to_staff'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['avoided_long_silences'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['interrupt_caller'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['polite'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['utilized_time_efficiently'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['appropriate_empathy'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'.$user['further_assistance'].'",';
				$row .= '"'.$user['cmt20'].'",';
				$row .= '"'.$user['summary_verification'].'",';
				$row .= '"'.$user['cmt21'].'",';
				$row .= '"'.$user['thanked_caller'].'",';
				$row .= '"'.$user['cmt22'].'",';

				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
			    $row .= '"'.$user['entry_date'].'",';
			    $row .= '"'.$interval1.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_name'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';

		  		$row .= '"'.$user['client_rvw_date'].'",';

				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
	}
}
?>