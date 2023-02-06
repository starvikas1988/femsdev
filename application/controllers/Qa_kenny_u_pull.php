<?php 

 class Qa_kenny_u_pull extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function kenny_upload_files($files,$path){
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
			$data["content_template"] = "qa_kenny_u_pull/qa_kenny_u_pull_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,149) and is_assign_process (id,309) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kenny_u_pull_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["kenny_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////	
	public function add_edit_kenny_u_pull($kenny_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kenny_u_pull/add_edit_kenny_u_pull.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,149) and is_assign_process (id,309) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['kenny_id']=$kenny_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_kenny_u_pull_feedback where id='$kenny_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["kenny_u_pull"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"call_id" => $this->input->post('call_id'),
					"call_type" => $this->input->post('call_type'),
					"case" => $this->input->post('case'),
					"site_location" => $this->input->post('site_location'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),
					"introducing_self" => $this->input->post('introducing_self'),
					"greet_customer" => $this->input->post('greet_customer'),
					"car_complete" => $this->input->post('car_complete'),
					"the_deduction" => $this->input->post('the_deduction'),
					"negotiation" => $this->input->post('negotiation'),
					"accessibility" => $this->input->post('accessibility'),
					"expected_price" => $this->input->post('expected_price'),
					"branch_selection" => $this->input->post('branch_selection'),
					"postal_card" => $this->input->post('postal_card'),
					"file_opening" => $this->input->post('file_opening'),
					"vehicle_identification" => $this->input->post('vehicle_identification'),
					"mileage" => $this->input->post('mileage'),
					"aesthetic_conditions" => $this->input->post('aesthetic_conditions'),
					"mechanical_condition" => $this->input->post('mechanical_condition'),
					"towing_address" => $this->input->post('towing_address'),
					"drop_off" => $this->input->post('drop_off'),
					"active_listening" => $this->input->post('active_listening'),
					"interruption" => $this->input->post('interruption'),
					"tone_voice" => $this->input->post('tone_voice'),
					"dead_air" => $this->input->post('dead_air'),
					"ending_call" => $this->input->post('ending_call'),
					"confirm_phone" => $this->input->post('confirm_phone'),
					"confirm_address" => $this->input->post('confirm_address'),
					"confirm_date_time" => $this->input->post('confirm_date_time'),
					"purchase_process" => $this->input->post('purchase_process'),
					"adherence_process" => $this->input->post('adherence_process'),
					"rude_behaviour" => $this->input->post('rude_behaviour'),
					"call_avoidance" => $this->input->post('call_avoidance'),
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
			
				if($kenny_id==0){
					
					$a = $this->kenny_upload_files($_FILES['attach_file'],$path='./qa_files/qa_kenny_u_pull/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_kenny_u_pull_feedback',$field_array);
					//echo ($this->db->last_query()); 
					//	exit();
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_kenny_u_pull_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_kenny_u_pull_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $kenny_id);
					$this->db->update('qa_kenny_u_pull_feedback',$field_array);
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
					$this->db->where('id', $kenny_id);
					$this->db->update('qa_kenny_u_pull_feedback',$field_array1);
					
				}
				//exit;
				redirect('Qa_kenny_u_pull');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function agent_kenny_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kenny_u_pull/agent_kenny_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_kenny_u_pull/agent_kenny_feedback";

			//$data["agentUrl"] = "qa_sensio/agent_sensio_feedback";
			
			$qSql="Select count(id) as value from qa_kenny_u_pull_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_kenny_u_pull_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kenny_u_pull_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kenny_u_pull_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_kenny_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_kenny_u_pull/agent_kenny_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_kenny_u_pull/agent_kenny_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_kenny_u_pull_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["kenny_u_pull"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_kenny_u_pull_feedback',$field_array1);
					
				redirect('Qa_kenny_u_pull/agent_kenny_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////// QA KENNY REPORT ////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_kenny_u_pull_report(){
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
			$data["content_template"] = "qa_kenny_u_pull/qa_kenny_u_pull_report.php";
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
			
			$data["qa_kenny_u_pull_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_kenny_u_pull_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_kenny_u_pull_list"] = $fullAray;
				$this->create_qa_kenny_u_pull_CSV($fullAray);	
				$dn_link = base_url()."Qa_kenny_u_pull/download_qa_kenny_u_pull_CSV";	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_kenny_u_pull_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Kenny-U-Pull Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_kenny_u_pull_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call ID", "Call Duration", "Call Type", "case", "Audit Type", "VOC","Site/Location", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score",
		 "Introducing Self", "Greets the customer in a courteous manner", "Is the car complete?", "The Deductions", "Negotiation", "Accessibility – Snow removal (Winter period)", "Expected Price", "Branch Selection", "Phone Number and Postal Code", "File opening", "Vehicle identification Number(NIV – VIN)", "Mileage", "Aesthetic Conditions", "Mechanical Condition", "Towing Address",
		 "Customer Drops off his Vehicle (Drop-Off)","Active Listening","Interruption","Tone of Voice (from greeting to closing)","Hold & Dead air","Ending the call","Confirmation Phone Number","Address Confirmation","Confirmation of the tow date/time","Process after purchase","Process Adherence","Rude Remarks","Call Avoidance",
		  "Introducing Self Remarks", "Greets the customer in a courteous manner Remarks", "Is the car complete? Remarks", "The Deductions Remarks", "Negotiation Remarks", "Accessibility – Snow removal (Winter period) Remarks", "Expected Price Remarks", "Branch Selection Remarks", "Phone Number and Postal Code Remarks", "File opening Remarks", "Vehicle identification Number(NIV – VIN)Remarks", "Mileage Remarks", "Aesthetic Conditions Remarks", "Mechanical Condition Remarks", "Towing Address Remarks","Customer Drops off his Vehicle (Drop-Off) Remarks","Active Listening Remarks","Interruption Remarks","Tone of Voice (from greeting to closing) Remarks","Hold & Dead air Remarks","Ending the call Remarks","Confirmation Phone Number Remarks","Address Confirmation Remarks","Confirmation of the tow date/time Remarks","Process after purchase Remarks","Process Adherence Remarks","Rude Remarks Remarks","Call Avoidance Remarks",
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
		
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['case'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['site_location'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['introducing_self'].'",';
			$row .= '"'.$user['greet_customer'].'",';
			$row .= '"'.$user['car_complete'].'",';
			$row .= '"'.$user['the_deduction'].'",';
			$row .= '"'.$user['negotiation'].'",';
			$row .= '"'.$user['accessibility'].'",';
			$row .= '"'.$user['expected_price'].'",';
			$row .= '"'.$user['branch_selection'].'",';
			$row .= '"'.$user['postal_card'].'",';
			$row .= '"'.$user['file_opening'].'",';
			$row .= '"'.$user['vehicle_identification'].'",';
			$row .= '"'.$user['mileage'].'",';
			$row .= '"'.$user['aesthetic_conditions'].'",';
			$row .= '"'.$user['mechanical_condition'].'",';
			$row .= '"'.$user['towing_address'].'",';
			$row .= '"'.$user['drop_off'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['interruption'].'",';
			$row .= '"'.$user['tone_voice'].'",';
			$row .= '"'.$user['dead_air'].'",';
			$row .= '"'.$user['ending_call'].'",';
			$row .= '"'.$user['confirm_phone'].'",';
			$row .= '"'.$user['confirm_address'].'",';
			$row .= '"'.$user['confirm_date_time'].'",';
			$row .= '"'.$user['purchase_process'].'",';
			$row .= '"'.$user['adherence_process'].'",';
			$row .= '"'.$user['rude_behaviour'].'",';
			$row .= '"'.$user['call_avoidance'].'",';
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