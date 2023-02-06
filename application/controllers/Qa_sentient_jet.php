<?php 

 class Qa_sentient_jet extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function mt_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav|jpg|jpeg|png';
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
	
	
////////////////////// Sentient Jet /////////////////////////	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sentient_jet/qa_sentient_jet.php";
			$data["content_js"] = "qa_universal_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,257) and is_assign_process (id,535) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sentient_jet_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["gds_prearrival"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_sentient_jet($sentient_jet_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sentient_jet/add_edit_sentient_jet.php";
			$data["content_js"] = "qa_universal_js.php";
			$data['sentient_jet_id']=$sentient_jet_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,257) and is_assign_process (id,535) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_sentient_jet_feedback where id='$sentient_jet_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sentient_jet"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($sentient_jet_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_sentient_jet/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_sentient_jet_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_sentient_jet_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$this->db->where('id', $sentient_jet_id);
					$this->db->update('qa_sentient_jet_feedback',$field_array1);
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
					$this->db->where('id', $sentient_jet_id);
					$this->db->update('qa_sentient_jet_feedback',$edit_array);
					
				}
				redirect('qa_sentient_jet');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	

/////////////////////////////////////////////////////////////////////
/////////////////////////Agent part/////////////////////////////////	
public function agent_sentient_jet_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sentient_jet/agent_sentient_jet_feedback.php";
			$data["content_js"] = "qa_universal_js.php";
			$data["agentUrl"] = "Qa_sentient_jet/agent_sentient_jet_feedback";
			
			$qSql="Select count(id) as value from qa_sentient_jet_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_sentient_jet_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			$from_date = '';
			$to_date = '';
			$cond="";
			$user="";
			if(get_role_dir()=='agent'){
					$user .="where id ='$current_user'";
				}
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sentient_jet_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin $user) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			}else{
             $qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sentient_jet_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}

	public function agent_sentient_jet_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['gds_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_sentient_jet/agent_sentient_jet_rvw.php";
			$data["content_js"] = "qa_universal_js.php";
			$data["agentUrl"] = "Qa_sentient_jet/agent_sentient_jet_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sentient_jet_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sentient_jet"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["sentient_jet_id"]=$id;
			
			if($this->input->post('sentient_jet_id'))
			{
				$pnid=$this->input->post('sentient_jet_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_sentient_jet_feedback',$field_array1);
					
				redirect('Qa_sentient_jet/agent_sentient_jet_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Report Part //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_sentient_jet_report(){
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
			$data["content_template"] = "qa_sentient_jet/qa_sentient_jet_report.php";
			$data["content_js"] = "qa_universal_js.php";
			
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
			$user="";
			
			$campaign ="sentient_jet";
			
			$data["sentient_jet_list"] = array();
			
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
               
				if(get_role_dir()=='agent'){
					$user .="where id ='$current_user'";
				}
				
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_sentient_jet_feedback) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["sentient_jet_list"] = $fullAray;
				$this->create_qa_sentient_jet_CSV($fullAray,$campaign);	
				$dn_link = base_url()."Qa_sentient_jet/download_qa_sentient_jet_CSV/".$campaign;	
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
	 

	public function download_qa_sentient_jet_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_sentient_jet_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "qa_sentient_jet";
		$edit_url = "add_edit_sentient_jet";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");
		
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Email Date","Date Evaluated", "Ticket", "Flight ID", "Month","Week","Final","Audit Type", "Auditor Type", "Voc","Audit Link","Earn Score","Possible Score","Overall Score","Customer Score","Business Score",
				"Appropriate subject line correct greeting and opening","Did the agent ask for the outstanding details?","Sentence construction and tone of email","Did the CM label the ticket fields and submitted the ticket as solved?","Closing remarks and attachment(s)","Was the delivery information correct?","Did the CM submit the order to the appropriate vendor?","Did the order match the client's request?","Did the CM process a billback and was it correct?","Did the CM add revisions or catering instructions in the b2b?","Did the CM set the correct arranger/tracking for the GT request?","Did the CM utilize the correct car company?","Did the CM consider the number of luggage and pax for the vehicle type?","Did the CM set the correct date and spot time for the car service/rental car?","Did the CM provide the confirmation number?","Did the CM update the client and internal notes?","Did the CM update the flight worksheet?","Did the CM update the flight Leg?","Did the agent complete the To-Do task for CM?","Did the agent create a flight note to alert CM FP & FM?","Did the CM summarize ALL details of the task and was the disposition correct?","Remark 1","Remark 2","Remark 3","Remark 4","Remark 5","Remark 6","Remark 7","Remark 8","Remark 9","Remark 10","Remark 11","Remark 12","Remark 13","Remark 14","Remark 15","Remark 16","Remark 17","Remark 18","Remark 19","Remark 20","Remark 21","Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
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
				$main_urls = $main_url.'/'.$user['id'];
				
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['date_evaluated'].'",';
				$row .= '"'.$user['ticket'].'",';
				$row .= '"'.$user['flight_id'].'",';
				$row .= '"'.$user['month'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['final'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['customer_score'].'",';
				$row .= '"'.$user['business_score'].'",';
                $row .= '"'.$user['appropriate_subject'].'",';
				$row .= '"'.$user['did_the_agent_ask'].'",';
				$row .= '"'.$user['sentence_construction'].'",';
				$row .= '"'.$user['did_the_agent_tag'].'",';
				$row .= '"'.$user['closing_remarks'].'",';
				$row .= '"'.$user['correct_fbo_pax'].'",';
				$row .= '"'.$user['was_catering_submitted'].'",';
				$row .= '"'.$user['correct_items'].'",';
				$row .= '"'.$user['correctly_billed'].'",';
				$row .= '"'.$user['revisions_or_ca'].'",';
				$row .= '"'.$user['set_the_correct'].'",';
				$row .= '"'.$user['correct_gt_company'].'",';
				$row .= '"'.$user['does_car_meet'].'",';
				$row .= '"'.$user['is_car_service'].'",';
				$row .= '"'.$user['ensure_the_confirmation'].'",';
				$row .= '"'.$user['added_client_and'].'",';
				$row .= '"'.$user['complete_and_accurate'].'",';
				$row .= '"'.$user['complete_and_accurate_leg'].'",';
				$row .= '"'.$user['closed_flight_leg'].'",';
				$row .= '"'.$user['did_the_agent_create'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
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
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		

        }
	
 }