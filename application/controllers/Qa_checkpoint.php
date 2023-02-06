<?php 

 class Qa_checkpoint extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_checkpoint_model');
		$this->load->model('Qa_philip_model');
	}
	 


	 
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint/qa_checkpoint_feedback.php";
			
			$data["agentName"] = $this->Qa_checkpoint_model->get_agent_id(26,38);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			
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
			
			$field_array = array(
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id,
				"current_user" => $current_user
			);
			
			$data["qa_checkpoint_data"] = $this->Qa_checkpoint_model->get_checkpoint_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////CheckPoint//////////////////////////////
	
	public function add_checkpoint_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint/add_checkpoint_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_checkpoint_model->get_agent_id(26,38);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"cust_score" => $this->input->post('cust_score'),
					"busi_score" => $this->input->post('busi_score'),
					"comp_score" => $this->input->post('comp_score'),
					
					"greetings_closing" => $this->input->post('greetings_closing'),
					"identify_reason_chatting" => $this->input->post('identify_reason_chatting'),
					"made_customer_feel" => $this->input->post('made_customer_feel'),
					"customers_multiple_concerns" => $this->input->post('customers_multiple_concerns'),
					"customer_more_concern" => $this->input->post('customer_more_concern'),
					"dead_air" => $this->input->post('dead_air'),
					"correct_information" => $this->input->post('correct_information'),
					"probing_assist" => $this->input->post('probing_assist'),
					"probing_tag" => $this->input->post('probing_tag'),
					"appropriate_instruction" => $this->input->post('appropriate_instruction'),
					"documents_chat" => $this->input->post('documents_chat'),
					"tags_zendesk" => $this->input->post('tags_zendesk'),
					"help_customer" => $this->input->post('help_customer'),
					"further_assistance" => $this->input->post('further_assistance'),
					"greetings_closing_rmk" => $this->input->post('greetings_closing_rmk'),
					"identify_reason_chatting_rmk" => $this->input->post('identify_reason_chatting_rmk'),
					"made_customer_feel_rmk" => $this->input->post('made_customer_feel_rmk'),
					"customers_multiple_concerns_rmk" => $this->input->post('customers_multiple_concerns_rmk'),
					"customer_more_concern_rmk" => $this->input->post('customer_more_concern_rmk'),
					"dead_air_rmk" => $this->input->post('dead_air_rmk'),
					"correct_information_rmk" => $this->input->post('correct_information_rmk'),
					"probing_assist_rmk" => $this->input->post('probing_assist_rmk'),
					"probing_tag_rmk" => $this->input->post('probing_tag_rmk'),
					"appropriate_instruction_rmk" => $this->input->post('appropriate_instruction_rmk'),
					"documents_chat_rmk" => $this->input->post('documents_chat_rmk'),
					"tags_zendesk_rmk" => $this->input->post('tags_zendesk_rmk'),
					"help_customer_rmk" => $this->input->post('help_customer_rmk'),
					"further_assistance_rmk" => $this->input->post('further_assistance_rmk'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->checkpoint_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_checkpoint_feedback',$field_array);
				redirect('Qa_checkpoint');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function checkpoint_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_checkpoint/checkpoint/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|doc|docx';
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
	
	
	public function mgnt_checkpoint_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint/mgnt_checkpoint_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_checkpoint_model->get_agent_id(26,38);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["get_checkpoint_feedback"] = $this->Qa_checkpoint_model->view_checkpoint_feedback($id);
			
			$data["paid"]=$id;
			
			$data["row1"] = $this->Qa_checkpoint_model->view_agent_checkpoint_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_checkpoint_model->view_mgnt_checkpoint_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('pa_id'))
			{
				$pa_id=$this->input->post('pa_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"cust_score" => $this->input->post('cust_score'),
					"busi_score" => $this->input->post('busi_score'),
					"comp_score" => $this->input->post('comp_score'),
					
					"greetings_closing" => $this->input->post('greetings_closing'),
					"identify_reason_chatting" => $this->input->post('identify_reason_chatting'),
					"made_customer_feel" => $this->input->post('made_customer_feel'),
					"customers_multiple_concerns" => $this->input->post('customers_multiple_concerns'),
					"customer_more_concern" => $this->input->post('customer_more_concern'),
					"dead_air" => $this->input->post('dead_air'),
					"correct_information" => $this->input->post('correct_information'),
					"probing_assist" => $this->input->post('probing_assist'),
					"probing_tag" => $this->input->post('probing_tag'),
					"appropriate_instruction" => $this->input->post('appropriate_instruction'),
					"documents_chat" => $this->input->post('documents_chat'),
					"tags_zendesk" => $this->input->post('tags_zendesk'),
					"help_customer" => $this->input->post('help_customer'),
					"further_assistance" => $this->input->post('further_assistance'),
					"greetings_closing_rmk" => $this->input->post('greetings_closing_rmk'),
					"identify_reason_chatting_rmk" => $this->input->post('identify_reason_chatting_rmk'),
					"made_customer_feel_rmk" => $this->input->post('made_customer_feel_rmk'),
					"customers_multiple_concerns_rmk" => $this->input->post('customers_multiple_concerns_rmk'),
					"customer_more_concern_rmk" => $this->input->post('customer_more_concern_rmk'),
					"dead_air_rmk" => $this->input->post('dead_air_rmk'),
					"correct_information_rmk" => $this->input->post('correct_information_rmk'),
					"probing_assist_rmk" => $this->input->post('probing_assist_rmk'),
					"probing_tag_rmk" => $this->input->post('probing_tag_rmk'),
					"appropriate_instruction_rmk" => $this->input->post('appropriate_instruction_rmk'),
					"documents_chat_rmk" => $this->input->post('documents_chat_rmk'),
					"tags_zendesk_rmk" => $this->input->post('tags_zendesk_rmk'),
					"help_customer_rmk" => $this->input->post('help_customer_rmk'),
					"further_assistance_rmk" => $this->input->post('further_assistance_rmk'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pa_id);
				$this->db->update('qa_checkpoint_feedback',$field_array);
				
			////////////
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_checkpoint_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_checkpoint_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_checkpoint');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


/////////////////CheckPoint Agent part//////////////////////////	

	public function agent_checkpoint_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint/agent_checkpoint_feedback.php";
			$data["agentUrl"] = "qa_checkpoint/agent_checkpoint_feedback";
			
		//////////// checkpoint start	
			$qSql="Select count(id) as value from qa_checkpoint_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_checkpoint_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_checkpoint_feedback where id  not in (select fd_id from qa_checkpoint_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_checkpoint_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		//////////// checkpoint email start
			$qSql="Select count(id) as value from qa_checkpoint_email_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_checkpoint_email_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_checkpoint_email_feedback where id  not in (select fd_id from qa_checkpoint_email_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_checkpoint_email_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				$field_array = array(
					"from_date"=>$from_date,
					"to_date" => $to_date,
					"current_user" => $current_user
				);

				$data["agent_pa_review_list"] = $this->Qa_checkpoint_model->get_agent_pa_review_data($field_array);
				$data["agent_checkpoint_email_review_list"] = $this->Qa_checkpoint_model->get_agent_checkpoint_email_review_data($field_array);
					
			}else{	
				$data["agent_pa_review_list"] = $this->Qa_checkpoint_model->get_agent_not_pa_review_data($current_user);		
				$data["agent_checkpoint_email_review_list"] = $this->Qa_checkpoint_model->get_agent_not_checkpoint_email_review_data($current_user);	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_checkpoint_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint/agent_checkpoint_feedback_rvw.php";
			$data["agentUrl"] = "qa_checkpoint/agent_checkpoint_feedback";
						
			
			$data["get_checkpoint_feedback"] = $this->Qa_checkpoint_model->view_checkpoint_feedback($id);
			
			$data["paid"]=$id;
			
			$data["row1"] = $this->Qa_checkpoint_model->view_agent_checkpoint_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_checkpoint_model->view_mgnt_checkpoint_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('pa_id'))
			{
				$pa_id=$this->input->post('pa_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_checkpoint_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_checkpoint_agent_rvw',$field_array1);
				}	
				redirect('Qa_checkpoint/agent_checkpoint_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	public function agent_checkpoint_email_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint/agent_checkpoint_email_feedback_rvw.php";
			$data["agentUrl"] = "qa_checkpoint/agent_checkpoint_feedback";
						
			
			$data["get_checkpoint_email_feedback"] = $this->Qa_checkpoint_model->view_checkpoint_email_feedback($id);
			
			$data["paid"]=$id;
			
			$data["row1"] = $this->Qa_checkpoint_model->view_agent_checkpoint_email_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_checkpoint_model->view_mgnt_checkpoint_email_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('pa_id'))
			{
				$pa_id=$this->input->post('pa_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_checkpoint_email_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_checkpoint_agent_email_rvw',$field_array1);
				}	
				redirect('Qa_checkpoint/agent_checkpoint_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_checkpoint_chat_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint/agent_checkpoint_chat_feedback_rvw.php";
			$data["agentUrl"] = "qa_checkpoint/agent_checkpoint_feedback";
						
			
			$data["get_checkpoint_chat_feedback"] = $this->Qa_checkpoint_model->view_checkpoint_chat_feedback($id);
			
			$data["paid"]=$id;
			
			$data["row1"] = $this->Qa_checkpoint_model->view_agent_checkpoint_chat_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_checkpoint_model->view_mgnt_checkpoint_chat_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('pa_id'))
			{
				$pa_id=$this->input->post('pa_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_checkpoint_chat_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_checkpoint_agent_chat_rvw',$field_array1);
				}	
				redirect('Qa_checkpoint/agent_checkpoint_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select s.id, s.assigned_to,  CONCAT(s1.fname,' ' ,s1.lname) as tl_name, s.fusion_id, get_process_names(s.id) as process_name FROM signin s left join signin s1 on s1.id = s.assigned_to where s.id ='$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA CheckPoint REPORT ////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_checkpoint_report(){
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
			
			/* $office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id; */
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_checkpoint/qa_checkpoint_report.php";
			
			
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			
			/* $cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id')); */
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			//$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			
			$data["qa_checkpoint_list"] = array();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				//$office_id = $this->input->get('office_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						//"office_id" => $office_id,
						"process_id" => $pValue,
						"current_user" => $current_user
					);
					
				
				if($pValue=='Checkpoint Email'){
					
					$fullAray = $this->Qa_checkpoint_model->qa_checkpoint_report_model($field_array);
					$data["qa_checkpoint_list"] = $fullAray;
					$this->create_qa_checkpoint_email_CSV($fullAray);	
					$dn_link = base_url()."qa_checkpoint/download_qa_checkpoint_Email_CSV";
				
				}else if($pValue=='Checkpoint Chat'){
					
					$fullAray = $this->Qa_checkpoint_model->qa_checkpoint_report_model($field_array);
					$data["qa_checkpoint_list"] = $fullAray;
					$this->create_qa_checkpoint_chat_CSV($fullAray);	
					$dn_link = base_url()."qa_checkpoint/download_qa_Checkpoint_Chat_CSV";
				
				}else{
					
					$fullAray = $this->Qa_checkpoint_model->qa_checkpoint_report_model($field_array);
					$data["qa_checkpoint_list"] = $fullAray;
					$this->create_qa_checkpoint_CSV($fullAray);	
					$dn_link = base_url()."qa_checkpoint/download_qa_Checkpoint_CSV";
				
				}
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			//$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 
	
//////////////////CheckPoint///////////////////
	public function download_qa_checkpoint_email_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Checkpoint email -'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_checkpoint_email_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Customer ID", "Call Date", "Call ID", "Phone", "Campaign", "Audit Type", "VOC", 
		"Probing Question (to assist)", "Probing Question (to tag ticket)", "Accuracy and appropriateness of information", "Does the customer have more than 2 concerns / questions?", "Did the rep review previous conversation?", "Resolution", "Offer Additional/Alternate Resolution", "Empathy and Enthusiasm (apologize when needed only)", "Simplicity and Politeness", "Grammar", "Are the thoughts and instruction on the email properly organized?", "Salutation", "Closing", "Escalation / Asked for proper assistance", "Use of Proper Tools:", "Proper Tags were used on the ticket", "Other notes", "Timeliness of response", "Status", 
		"Probing Question (to assist) Remarks", "Probing Question (to tag ticket) Remarks", "Accuracy and appropriateness of information Remarks", "Does the customer have more than 2 concerns / questions? Remarks", "Did the rep review previous conversation? Remarks", "Resolution Remarks", "Offer Additional/Alternate Resolution Remarks", "Empathy and Enthusiasm (apologize when needed only) Remarks", "Simplicity and Politeness Remarks", "Grammar Remarks", "Are the thoughts and instruction on the email properly organized? Remarks", "Salutation Remarks", "Closing Remarks", "Escalation / Asked for proper assistance Remarks", "Use of Proper Tools: Remarks", "Proper Tags were used on the ticket Remarks", "Other notes Remarks", "Timeliness of response Remarks", "Status Remarks", 
		"Overall Score", "Recommendations", "Feedback", 
		"Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			
			if($user['probing_que_assist'] == '0') $probing_que_assist = "No";
			else if($user['probing_que_assist'] == '-1') $probing_que_assist = "NA";
			else $probing_que_assist = "Yes";			
			$row .= '"'.$probing_que_assist.'",';
			
			if($user['probing_que_ticket'] == '0') $probing_que_ticket = "No";
			else if($user['probing_que_ticket'] == '-1') $probing_que_ticket = "NA";
			else $probing_que_ticket = "Yes";
			$row .= '"'.$probing_que_ticket.'",';
			
			if($user['accuracy_info'] == '0') $accuracy_info = "No";
			else if($user['accuracy_info'] == '-1') $accuracy_info = "NA";
			else $accuracy_info = "Yes";
			$row .= '"'.$accuracy_info.'",';
			
			if($user['more_concerns'] == '0') $more_concerns = "No";
			else if($user['more_concerns'] == '-1') $more_concerns = "NA";
			else $more_concerns = "Yes";
			$row .= '"'.$more_concerns.'",';
			
			if($user['review_conversation'] == '0') $review_conversation = "No";
			else if($user['review_conversation'] == '-1') $review_conversation = "NA";
			else $review_conversation = "Yes";
			$row .= '"'.$review_conversation.'",';
			
			if($user['resolution'] == '0') $resolution = "No";
			else if($user['resolution'] == '-1') $resolution = "NA";
			else $resolution = "Yes";
			$row .= '"'.$resolution.'",';
			
			if($user['offer_additional'] == '0') $offer_additional = "No";
			else if($user['offer_additional'] == '-1') $offer_additional = "NA";
			else $offer_additional = "Yes";			
			$row .= '"'.$offer_additional.'",';
			
			if($user['empathy_enthusiasm'] == '0') $empathy_enthusiasm = "No";
			else if($user['empathy_enthusiasm'] == '-1') $empathy_enthusiasm = "NA";
			else $empathy_enthusiasm = "Yes";
			$row .= '"'.$empathy_enthusiasm.'",';
			
			if($user['simplicity_politeness'] == '0') $simplicity_politeness = "No";
			else if($user['simplicity_politeness'] == '-1') $simplicity_politeness = "NA";
			else $simplicity_politeness = "Yes";
			$row .= '"'.$simplicity_politeness.'",';
			
			if($user['grammar'] == '0') $grammar = "No";
			else if($user['grammar'] == '-1') $grammar = "NA";
			else $grammar = "Yes";
			$row .= '"'.$grammar.'",';
			
			if($user['instruction_email'] == '0') $instruction_email = "No";
			else if($user['instruction_email'] == '-1') $instruction_email = "NA";
			else $instruction_email = "Yes";
			$row .= '"'.$instruction_email.'",';
			
			if($user['salutation'] == '0') $salutation = "No";
			else if($user['salutation'] == '-1') $salutation = "NA";
			else $salutation = "Yes";
			$row .= '"'.$salutation.'",';
			
			if($user['closing'] == '0') $closing = "No";
			else if($user['closing'] == '-1') $closing = "NA";
			else $closing = "Yes";
			$row .= '"'.$closing.'",';
			
			if($user['escalation'] == '0') $escalation = "No";
			else if($user['escalation'] == '-1') $escalation = "NA";
			else $escalation = "Yes";
			$row .= '"'.$escalation.'",';
			
			if($user['proper_tools'] == '0') $proper_tools = "No";
			else if($user['proper_tools'] == '-1') $proper_tools = "NA";
			else $proper_tools = "Yes";
			$row .= '"'.$proper_tools.'",';
			
			if($user['proper_tags'] == '0') $proper_tags = "No";
			else if($user['proper_tags'] == '-1') $proper_tags = "NA";
			else $proper_tags = "Yes";
			$row .= '"'.$proper_tags.'",';
			
			if($user['other_notes'] == '0') $other_notes = "No";
			else if($user['other_notes'] == '-1') $other_notes = "NA";
			else $other_notes = "Yes";
			$row .= '"'.$other_notes.'",';
			
			if($user['timeliness_response'] == '0') $timeliness_response = "No";
			else if($user['timeliness_response'] == '-1') $timeliness_response = "NA";
			else $timeliness_response = "Yes";
			$row .= '"'.$timeliness_response.'",';
			
			if($user['status'] == '0') $status = "No";
			else if($user['status'] == '-1') $status = "NA";
			else $status = "Yes";
			$row .= '"'.$status.'",';
			/*$row .= '"'.$user['probing_que_assist'].'",';
			$row .= '"'.$user['probing_que_ticket'].'",';
			$row .= '"'.$user['accuracy_info'].'",';
			$row .= '"'.$user['more_concerns'].'",';
			$row .= '"'.$user['review_conversation'].'",';
			$row .= '"'.$user['resolution'].'",';
			$row .= '"'.$user['offer_additional'].'",';
			$row .= '"'.$user['empathy_enthusiasm'].'",';
			$row .= '"'.$user['simplicity_politeness'].'",';
			$row .= '"'.$user['grammar'].'",';
			$row .= '"'.$user['instruction_email'].'",';
			$row .= '"'.$user['salutation'].'",';
			$row .= '"'.$user['closing'].'",';
			$row .= '"'.$user['escalation'].'",';
			$row .= '"'.$user['proper_tools'].'",';
			$row .= '"'.$user['proper_tags'].'",';
			$row .= '"'.$user['other_notes'].'",';
			$row .= '"'.$user['timeliness_response'].'",';
			$row .= '"'.$user['status'].'",';*/
			
			$row .= '"'.$user['probing_que_assist_rmk'].'",';
			$row .= '"'.$user['probing_que_ticket_rmk'].'",';
			$row .= '"'.$user['accuracy_info_rmk'].'",';
			$row .= '"'.$user['more_concerns_rmk'].'",';
			$row .= '"'.$user['review_conversation_rmk'].'",';
			$row .= '"'.$user['resolution_rmk'].'",';
			$row .= '"'.$user['offer_additional_rmk'].'",';
			$row .= '"'.$user['empathy_enthusiasm_rmk'].'",';
			$row .= '"'.$user['simplicity_politeness_rmk'].'",';
			$row .= '"'.$user['grammar_rmk'].'",';
			$row .= '"'.$user['instruction_email_rmk'].'",';
			$row .= '"'.$user['salutation_rmk'].'",';
			$row .= '"'.$user['closing_rmk'].'",';
			$row .= '"'.$user['escalation_rmk'].'",';
			$row .= '"'.$user['proper_tools_rmk'].'",';
			$row .= '"'.$user['proper_tags_rmk'].'",';
			$row .= '"'.$user['other_notes_rmk'].'",';
			$row .= '"'.$user['timeliness_response_rmk'].'",';
			$row .= '"'.$user['status_rmk'].'",';
			
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['recommendations'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	public function download_qa_checkpoint_chat_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Checkpoint Chat -'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_checkpoint_chat_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Customer ID", "Call Date", "Call ID", "Phone", "Campaign", "Audit Type", "VOC", 
		"Opening Spiel", "Offered Assistance", "Empathy", "Being Polite and Courteous", "PETA (Permission/ Explanation/ Time Frame/ Acknowledgment)", "Reduced Response Time (Quick/Timely Response)", "Chat Flow based on service SOPs and Protocols", "Understanding the issue", "Proper Probing", "Accuracy", "Product Service Information", "Technical Procedures", "Case Logs/Documentation", "Actions Taken (FF up email/ Escalation/ Etc.)", "Correct Grammar/ Spelling/ Punctuation and Verbiage", "Proper Use of Canned Messages", "Customer Satisfaction", 
		"Opening Spiel Remarks", "Offered Assistance Remarks", "Empathy Remarks", "Being Polite and Courteous Remarks", "PETA (Permission/ Explanation Remarks/ Time Frame/ Acknowledgment) Remarks", "Reduced Response Time (Quick/Timely Response) Remarks", "Chat Flow based on service SOPs and Protocols Remarks", "Understanding the issue Remarks", "Proper Probing Remarks", "Accuracy Remarks", "Product Service Information Remarks", "Technical Procedures Remarks", "Case Logs/Documentation Remarks", "Actions Taken (FF up email/ Escalation/ Etc.) Remarks", "Correct Grammar/ Spelling/ Punctuation and Verbiage Remarks", "Proper Use of Canned Messages Remarks", "Customer Satisfaction Remarks", 
		"Overall Score", "Recommendations", "Call Summary",
		"Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			
			$row .= '"'.$user['opening_spiel'].'",';
			$row .= '"'.$user['offered_assistance'].'",';
			$row .= '"'.$user['empathy'].'",';
			$row .= '"'.$user['being_polite'].'",';
			$row .= '"'.$user['peta'].'",';
			$row .= '"'.$user['reduced_response_time'].'",';
			$row .= '"'.$user['chat_flow'].'",';
			$row .= '"'.$user['understanding_issue'].'",';
			$row .= '"'.$user['proper_probing'].'",';
			$row .= '"'.$user['accuracy'].'",';
			$row .= '"'.$user['product_service_info'].'",';
			$row .= '"'.$user['technical_procedures'].'",';
			$row .= '"'.$user['case_logs'].'",';
			$row .= '"'.$user['actions_taken'].'",';
			$row .= '"'.$user['correct_grammar'].'",';
			$row .= '"'.$user['proper_use_msg'].'",';
			$row .= '"'.$user['cust_satisfaction'].'",';
			
			
			$row .= '"'.$user['opening_spiel_rmk'].'",';
			$row .= '"'.$user['offered_assistance_rmk'].'",';
			$row .= '"'.$user['empathy_rmk'].'",';
			$row .= '"'.$user['being_polite_rmk'].'",';
			$row .= '"'.$user['peta_rmk'].'",';
			$row .= '"'.$user['reduced_response_time_rmk'].'",';
			$row .= '"'.$user['chat_flow_rmk'].'",';
			$row .= '"'.$user['understanding_issue_rmk'].'",';
			$row .= '"'.$user['proper_probing_rmk'].'",';
			$row .= '"'.$user['accuracy_rmk'].'",';
			$row .= '"'.$user['product_service_info_rmk'].'",';
			$row .= '"'.$user['technical_procedures_rmk'].'",';
			$row .= '"'.$user['case_logs_rmk'].'",';
			$row .= '"'.$user['actions_taken_rmk'].'",';
			$row .= '"'.$user['correct_grammar_rmk'].'",';
			$row .= '"'.$user['proper_use_msg_rmk'].'",';
			$row .= '"'.$user['cust_satisfaction_rmk'].'",';
			
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['recommendations'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
//////////////////CheckPoint///////////////////
	public function download_qa_checkpoint_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Checkpoint Chat -'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_checkpoint_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Customer ID", "Call Date", "Call ID", "Phone", "Campaign", "Audit Type", "VOC", 
		"Greetings and closing", "Identify the correct reason for chatting", "Made the customer feel important and top priority", "Grammar. Thoughts are organized. Handles the customers multiple concerns one at a time", "Does the customer have more than 1 concern?", "Dead Air / Long Periods of Silence", "Gives correct information", "Probing Questions (to Assist)", "Probing Questions (to Tag)", "Gives correct and appropriate instruction (TS)", "Documents chat on Agent Prod Tracker", "Uses the correct Tags in Zendesk", "Demonstrates correct use of system tools (client or internal) to help the customer", "Sends an email for Escalation/ Suggestion/ Feedback/ Comment/ Asking for further assistance",
		"Greetings and closing Remarks", "Identify the correct reason for chatting Remarks", "Made the customer feel important and top priority Remarks", "Grammar. Thoughts are organized. Handles the customers multiple concerns one at a time Remarks", "Does the customer have more than 1 concern? Remarks", "Dead Air / Long Periods of Silence Remarks", "Gives correct information Remarks", "Probing Questions (to Assist) Remarks", "Probing Questions (to Tag) Remarks", "Gives correct and appropriate instruction (TS) Remarks", "Documents chat on Agent Prod Tracker Remarks", "Uses the correct Tags in Zendesk Remarks", "Demonstrates correct use of system tools (client or internal) to help the customer Remarks", "Sends an email for Escalation/ Suggestion/ Feedback/ Comment/ Asking for further assistance Remarks",
		"Overall Score", "Call Summary",
		"Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			
			$row .= '"'.$user['greetings_closing'].'",';
			$row .= '"'.$user['identify_reason_chatting'].'",';
			$row .= '"'.$user['made_customer_feel'].'",';
			$row .= '"'.$user['customers_multiple_concerns'].'",';
			if($user['customer_more_concern'] == '1.1')
				$row .= '"N/A",';
			else
				$row .= '"'.$user['customer_more_concern'].'",';
			$row .= '"'.$user['dead_air'].'",';
			$row .= '"'.$user['correct_information'].'",';
			$row .= '"'.$user['probing_assist'].'",';
			$row .= '"'.$user['probing_tag'].'",';
			$row .= '"'.$user['appropriate_instruction'].'",';
			$row .= '"'.$user['documents_chat'].'",';
			$row .= '"'.$user['tags_zendesk'].'",';
			$row .= '"'.$user['help_customer'].'",';
			$row .= '"'.$user['further_assistance'].'",';
			
			$row .= '"'.$user['greetings_closing_rmk'].'",';
			$row .= '"'.$user['identify_reason_chatting_rmk'].'",';
			$row .= '"'.$user['made_customer_feel_rmk'].'",';
			$row .= '"'.$user['customers_multiple_concerns_rmk'].'",';
			$row .= '"'.$user['customer_more_concern_rmk'].'",';
			$row .= '"'.$user['dead_air_rmk'].'",';
			$row .= '"'.$user['correct_information_rmk'].'",';
			$row .= '"'.$user['probing_assist_rmk'].'",';
			$row .= '"'.$user['probing_tag_rmk'].'",';
			$row .= '"'.$user['appropriate_instruction_rmk'].'",';
			$row .= '"'.$user['documents_chat_rmk'].'",';
			$row .= '"'.$user['tags_zendesk_rmk'].'",';
			$row .= '"'.$user['help_customer_rmk'].'",';
			$row .= '"'.$user['further_assistance_rmk'].'",';
			
			$row .= '"'.$user['overall_score'].'",'; 
			//$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			//$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['violation_explain'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
	////////////////////////////////////////////////////////////////////////

	function import_chekpoint_excel_data(){
		
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
			$clmarr = array("auditor_name","audit_date","fusion_id","customer_id","call_date","call_id","phone","campaign","audit_type","auditor_type","voc","overall_score","cust_score","busi_score","comp_score","greetings_closing","identify_reason_chatting","made_customer_feel","customers_multiple_concerns","customer_more_concern","dead_air","correct_information","probing_assist","probing_tag","appropriate_instruction","documents_chat","tags_zendesk","help_customer","further_assistance","greetings_closing_rmk","identify_reason_chatting_rmk","made_customer_feel_rmk","customers_multiple_concerns_rmk","customer_more_concern_rmk","dead_air_rmk","correct_information_rmk","probing_assist_rmk","probing_tag_rmk","appropriate_instruction_rmk","documents_chat_rmk","tags_zendesk_rmk","help_customer_rmk","further_assistance_rmk","call_summary","opportunity","violation_explain","feedback");
			
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
							$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							//$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

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
			
				$this->Qa_philip_model->chekpoint_excel_data($user_list);
				redirect('Qa_checkpoint');
			}
		}
	}

	public function sample_chekpoint_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_checkpoint/sample_chekpoint_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
	
	
	
}