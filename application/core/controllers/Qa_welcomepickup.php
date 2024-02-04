<?php 

 class Qa_welcomepickup extends CI_Controller{
	
	private $objPHPExcel;
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_welcomepickup_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();
	}
	 

	public function call_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_welcome_pickups/qa_welcome_pickups_feedback.php";

			$data["link"] = "add_calls_feedback";
			$data["link_title"] = " Calls Monitoring";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			
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
			);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			
			$data["records"] = $this->Qa_welcomepickup_model->get_records($form_type = 2,$from_date, $to_date, $current_user);
			
			$this->load->view("dashboard",$data);
		}
	}

	public function ticket_feedback(){
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_welcome_pickups/qa_welcome_pickups_feedback.php";

			$data["link"] = "add_ticket_feedback";
			$data["link_title"] = " Tickets Monitoring";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			
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
			);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$data["records"] = $this->Qa_welcomepickup_model->get_records($form_type = 1,$from_date, $to_date);
			
			$this->load->view("dashboard",$data);
		}
	}

	//////////////////////Welcome Pickups - Ticket//////////////////////////////
	
	public function add_ticket_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_welcome_pickups/add_tickets_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_welcomepickup_model->get_agent_id(94,156);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			if($this->input->post('save_button')=="save"){
				$curDateTime=CurrMySqlDate();

				$_field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"ticket_no" => $this->input->post('ticket_no'),
					"order_no" => $this->input->post('order_no'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => mmddyy2mysql($this->input->post('caller_date')),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"approach_greeting_1" => $this->input->post('approach_greeting_1'),
					"approach_greeting_2" => $this->input->post('approach_greeting_2'),
					"approach_greeting_3" => $this->input->post('approach_greeting_3'),
					"discovery_1" => $this->input->post('discovery_1'),
					"discovery_2" => $this->input->post('discovery_2'),
					"verification" => $this->input->post('verification'),
					"process_1" => $this->input->post('process_1'),
					"process_2" => $this->input->post('process_2'),
					"process_3" => $this->input->post('process_3'),
					"process_4" => $this->input->post('process_4'),
					"process_5" => $this->input->post('process_5'),
					"communication_1" => $this->input->post('communication_1'),
					"closing_1" => $this->input->post('closing_1'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"approach_greeting_1_cmt" => $this->input->post('approach_greeting_1_cmt'),
					"approach_greeting_2_cmt" => $this->input->post('approach_greeting_2_cmt'),
					"approach_greeting_3_cmt" => $this->input->post('approach_greeting_3_cmt'),
					"discovery_1_cmt" => $this->input->post('discovery_1_cmt'),
					"discovery_2_cmt" => $this->input->post('discovery_2_cmt'),
					"verification_cmt" => $this->input->post('verification_cmt'),
					"process_1_cmt" => $this->input->post('process_1_cmt'),
					"process_2_cmt" => $this->input->post('process_2_cmt'),
					"process_3_cmt" => $this->input->post('process_3_cmt'),
					"process_4_cmt" => $this->input->post('process_4_cmt'),
					"process_5_cmt" => $this->input->post('process_5_cmt'),
					"communication_1_cmt" => $this->input->post('communication_1_cmt'),
					"closing_1_cmt" => $this->input->post('closing_1_cmt'),
					"form_type" => 1,
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->welcome_pickup_upload_files($_FILES['attach_file']);
				$_field_array["attach_file"] = implode(',',$a);
				
				data_inserter('qa_welcome_pickups_tickets',$_field_array);
				redirect(base_url()."Qa_welcomepickup/ticket_feedback/","refresh");
			}			
			
			$this->load->view("dashboard",$data);
		}
	}
	

	//////////////////////Welcome Pickups - Calls//////////////////////////////
	
	public function add_calls_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_welcome_pickups/add_calls_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_welcomepickup_model->get_agent_id(94,156);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			if($this->input->post('save_button')=="save"){
				$curDateTime=CurrMySqlDate();
				
				$_field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"ticket_no" => $this->input->post('ticket_no'),
					"order_no" => $this->input->post('order_no'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => mmddyy2mysql($this->input->post('caller_date')),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"approach_greeting_1" => $this->input->post('approach_greeting_1'),
					"approach_greeting_2" => $this->input->post('approach_greeting_2'),
					"approach_greeting_3" => $this->input->post('approach_greeting_3'),
					"approach_greeting_4" => $this->input->post('approach_greeting_4'),
					"discovery_1" => $this->input->post('discovery_1'),
					"discovery_2" => $this->input->post('discovery_2'),
					"discovery_3" => $this->input->post('discovery_3'),
					"verification" => $this->input->post('verification'),
					"process_1" => $this->input->post('process_1'),
					"process_2" => $this->input->post('process_2'),
					"process_3" => $this->input->post('process_3'),
					"process_4" => $this->input->post('process_4'),
					"communication_1" => $this->input->post('communication_1'),
					"closing_1" => $this->input->post('closing_1'),
					"closing_2" => $this->input->post('closing_2'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"approach_greeting_1_cmt" => $this->input->post('approach_greeting_1_cmt'),
					"approach_greeting_2_cmt" => $this->input->post('approach_greeting_2_cmt'),
					"approach_greeting_3_cmt" => $this->input->post('approach_greeting_3_cmt'),
					"approach_greeting_4_cmt" => $this->input->post('approach_greeting_4_cmt'),
					"discovery_1_cmt" => $this->input->post('discovery_1_cmt'),
					"discovery_2_cmt" => $this->input->post('discovery_2_cmt'),
					"discovery_3_cmt" => $this->input->post('discovery_3_cmt'),
					"verification_cmt" => $this->input->post('verification_cmt'),
					"process_1_cmt" => $this->input->post('process_1_cmt'),
					"process_2_cmt" => $this->input->post('process_2_cmt'),
					"process_3_cmt" => $this->input->post('process_3_cmt'),
					"process_4_cmt" => $this->input->post('process_4_cmt'),
					"communication_1_cmt" => $this->input->post('communication_1_cmt'),
					"closing_1_cmt" => $this->input->post('closing_1_cmt'),
					"closing_2_cmt" => $this->input->post('closing_2_cmt'),
					"form_type" => 2,
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->welcome_pickup_upload_files($_FILES['attach_file']);
				$_field_array["attach_file"] = implode(',',$a);
				
				data_inserter('qa_welcome_pickups_tickets',$_field_array);
				redirect(base_url()."Qa_welcomepickup/call_feedback/","refresh");
			}
				
			$this->load->view("dashboard",$data);
		}
	}
	
	/****************** File Upload ********************/
	private function welcome_pickup_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_welcome_pickup/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv';
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
	
	/////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, doj FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

	////////////////////////////////////////////////////////////////////
	public function edit_tickets_feedback(){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$type	=	$this->uri->segment(3, 0);
			$id		=	$this->uri->segment(4, 0);
			$curDateTime=CurrMySqlDate();
			if($this->input->post('update_button')=="update")
			{
				$_field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"ticket_no" => $this->input->post('ticket_no'),
					"order_no" => $this->input->post('order_no'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => mmddyy2mysql($this->input->post('caller_date')),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"approach_greeting_1" => $this->input->post('approach_greeting_1'),
					"approach_greeting_2" => $this->input->post('approach_greeting_2'),
					"approach_greeting_3" => $this->input->post('approach_greeting_3'),
					"discovery_1" => $this->input->post('discovery_1'),
					"discovery_2" => $this->input->post('discovery_2'),
					"verification" => $this->input->post('verification'),
					"process_1" => $this->input->post('process_1'),
					"process_2" => $this->input->post('process_2'),
					"process_3" => $this->input->post('process_3'),
					"process_4" => $this->input->post('process_4'),
					"process_5" => $this->input->post('process_5'),
					"communication_1" => $this->input->post('communication_1'),
					"closing_1" => $this->input->post('closing_1'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"approach_greeting_1_cmt" => $this->input->post('approach_greeting_1_cmt'),
					"approach_greeting_2_cmt" => $this->input->post('approach_greeting_2_cmt'),
					"approach_greeting_3_cmt" => $this->input->post('approach_greeting_3_cmt'),
					"discovery_1_cmt" => $this->input->post('discovery_1_cmt'),
					"discovery_2_cmt" => $this->input->post('discovery_2_cmt'),
					"verification_cmt" => $this->input->post('verification_cmt'),
					"process_1_cmt" => $this->input->post('process_1_cmt'),
					"process_2_cmt" => $this->input->post('process_2_cmt'),
					"process_3_cmt" => $this->input->post('process_3_cmt'),
					"process_4_cmt" => $this->input->post('process_4_cmt'),
					"process_5_cmt" => $this->input->post('process_5_cmt'),
					"communication_1_cmt" => $this->input->post('communication_1_cmt'),
					"closing_1_cmt" => $this->input->post('closing_1_cmt')
					
				);
				$this->db->update('qa_welcome_pickups_tickets', $_field_array, array('id' => $id));
				////////////	
				$field_array1=array(
					"fd_id" => $id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_welcome_pickups_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $id);
					$this->db->update('qa_welcome_pickups_mgnt_rvw',$field_array1);
				}
				///////////	
				redirect(base_url()."Qa_welcomepickup/ticket_feedback/","refresh");	
			}
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_welcome_pickups/edit_tickets_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_welcomepickup_model->get_agent_id(94,156);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$data["record_data"] = $this->Qa_welcomepickup_model->get_record_data($type,$id);
			$data["row1"] = $this->Qa_welcomepickup_model->view_agent_welcome_pickup_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_welcomepickup_model->view_mgnt_welcome_pickup_rvw($id);//MGNT PURPOSE
				
			$this->load->view("dashboard",$data);
		}
	}
	
	////////////////////////////////////////////////////////////////////
	public function edit_calls_feedback(){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$type	=	$this->uri->segment(3, 0);
			$id		=	$this->uri->segment(4, 0);
			$curDateTime=CurrMySqlDate();
			if($this->input->post('update_button')=="update")
			{
				$_field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"ticket_no" => $this->input->post('ticket_no'),
					"order_no" => $this->input->post('order_no'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => mmddyy2mysql($this->input->post('caller_date')),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"approach_greeting_1" => $this->input->post('approach_greeting_1'),
					"approach_greeting_2" => $this->input->post('approach_greeting_2'),
					"approach_greeting_3" => $this->input->post('approach_greeting_3'),
					"approach_greeting_4" => $this->input->post('approach_greeting_4'),
					"discovery_1" => $this->input->post('discovery_1'),
					"discovery_2" => $this->input->post('discovery_2'),
					"discovery_3" => $this->input->post('discovery_3'),
					"verification" => $this->input->post('verification'),
					"process_1" => $this->input->post('process_1'),
					"process_2" => $this->input->post('process_2'),
					"process_3" => $this->input->post('process_3'),
					"process_4" => $this->input->post('process_4'),
					"communication_1" => $this->input->post('communication_1'),
					"closing_1" => $this->input->post('closing_1'),
					"closing_2" => $this->input->post('closing_2'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"approach_greeting_1_cmt" => $this->input->post('approach_greeting_1_cmt'),
					"approach_greeting_2_cmt" => $this->input->post('approach_greeting_2_cmt'),
					"approach_greeting_3_cmt" => $this->input->post('approach_greeting_3_cmt'),
					"approach_greeting_4_cmt" => $this->input->post('approach_greeting_4_cmt'),
					"discovery_1_cmt" => $this->input->post('discovery_1_cmt'),
					"discovery_2_cmt" => $this->input->post('discovery_2_cmt'),
					"discovery_3_cmt" => $this->input->post('discovery_3_cmt'),
					"verification_cmt" => $this->input->post('verification_cmt'),
					"process_1_cmt" => $this->input->post('process_1_cmt'),
					"process_2_cmt" => $this->input->post('process_2_cmt'),
					"process_3_cmt" => $this->input->post('process_3_cmt'),
					"process_4_cmt" => $this->input->post('process_4_cmt'),
					"communication_1_cmt" => $this->input->post('communication_1_cmt'),
					"closing_1_cmt" => $this->input->post('closing_1_cmt'),
					"closing_2_cmt" => $this->input->post('closing_2_cmt')
				);
				$this->db->update('qa_welcome_pickups_tickets', $_field_array, array('id' => $id));
				////////////	
				$field_array1=array(
					"fd_id" => $id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_welcome_pickups_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $id);
					$this->db->update('qa_welcome_pickups_mgnt_rvw',$field_array1);
				}
				///////////	
				redirect(base_url()."Qa_welcomepickup/call_feedback/","refresh");
			}
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_welcome_pickups/edit_calls_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_welcomepickup_model->get_agent_id(94,156);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$data["record_data"] = $this->Qa_welcomepickup_model->get_record_data($type,$id);
			$data["row1"] = $this->Qa_welcomepickup_model->view_agent_welcome_pickup_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_welcomepickup_model->view_mgnt_welcome_pickup_rvw($id);//MGNT PURPOSE
			$this->load->view("dashboard",$data);
		}
	}
	
	/******************** Report Section *******************/
	
	public function qa_welcome_pickup_report()
	{
		if(check_logged_in()){
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_welcome_pickups/qa_welcome_pickup_reports.php";
			$from_date="";
			$to_date="";
			$action="";
			$form_type ="";
			$dn_link="";
			$welcome_pickup_data = array();
			
			if($this->input->get('show')=='Show')
			{
				$from_date = $this->input->get('start_date');
				$to_date = $this->input->get('end_date');
				$form_type = $this->input->get('type');
				if($from_date!="" && $to_date!="")
				{
					$welcome_pickup_data =	$this->Qa_welcomepickup_model->qa_welcome_pickup_report_model($form_type,mmddyy2mysql($from_date),mmddyy2mysql($to_date));
				}
				$this->create_qa_welcome_pickup_CSV($welcome_pickup_data,$form_type);
				$dn_link = base_url()."Qa_welcomepickup/download_qa_welcome_pickup_CSV/".$form_type;
			}
			$data["start_date"] = $from_date;
            $data["end_date"] = $to_date;
			$data['type'] = $form_type;
			$data['welcome_pickup_data'] =	$welcome_pickup_data;
			$data['download_link']=$dn_link;
			$this->load->view("dashboard",$data);
		}
	}
	/****************QA Welcome pickup CSV Generator*****************/
	public function create_qa_welcome_pickup_CSV($rr,$form_type)
	{
		if($form_type == 1)
			$type = "Ticket";
		elseif($form_type == 2)
			$type = "Call";
		$filename = "./assets/reports/qa_welcome_pickup_report-".$type."-".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		if($form_type == 1)
		{
			$header = array("Auditor Name", "Audit Date","Audit Time","Agent Name","Ticket No","Order No","Caller Title","Caller Name","Caller Date","Audit Type","VOC","Overall Score","Greeting - Followed proper greeting","Realistic Acknowledgment - Provided appropriate responses and timely acknowledgment","Empathy - Used appropriate empathy statement","Comprehension - Understood the customers questions and answered it thoroughly","Probing - Made appropriate use of probing questions","Order Verification - Asked and verified at least one or two customers data points (email address or order no etc.)","Tools and Resources - Used all the resources available to determine the root cause of the problem/possible resolution and sought assistance from others as needed when unsure","Resolution and Processes/Guidelines - Used good judgment and decision making while resolving the issue conveyed every detail of the process clearly and accurately","Usage of Macro - Used the correct macro if there's one applicable and modified it appropriately","Ticket Status and Tagging- Used the correct ticket status and tagging","Documentation - Documented the necessary information during the email interaction if needed","Grammar - Used grammatically correct English","Look back and Learn - Proactive and offered additional assistance","Call Summary","Feedback","Form Type","Created On","Greeting - Followed proper greeting Comment","Realistic Acknowledgment - Provided appropriate responses and timely acknowledgment Comment","Empathy - Used appropriate empathy statement Comment","Comprehension - Understood the customers questions and answered it thoroughly Comment","Probing - Made appropriate use of probing questions Comment","Order Verification - Asked and verified at least one or two customers data points (email address or order no etc.) Comment","Tools and Resources - Used all the resources available to determine the root cause of the problem/possible resolution and sought assistance from others as needed when unsure Comment","Resolution and Processes/Guidelines - Used good judgment and decision making while resolving the issue conveyed every detail of the process clearly and accurately Comment","Usage of Macro - Used the correct macro if there's one applicable and modified it appropriately Comment","Ticket Status and Tagging- Used the correct ticket status and tagging Comment","Documentation - Documented the necessary information during the email interaction if needed Comment","Grammar - Used grammatically correct English Comment","Look back and Learn - Proactive and offered additional assistance Comment");
		}
		elseif($form_type == 2)
		{
			$header = array("Auditor Name", "Audit Date","Audit Time","Agent Name","Ticket No","Order No","Caller Title","Caller Name","Caller Date","Audit Type","VOC","Overall Score","Greeting - Followed proper greeting","Assistance - Offered sincere and immediate assistance and let the customer feel important","Pace - Adapted to caller's style and pace and put the customer at ease","Empathy - Used empathy statement in a timely manner","Active Listening - Actively listened to the customer and responded appropriately","Paraphrasing and Probing - Paraphrased the concern and made appropriate use of probing questions","Comprehension - Understand the customers' questions and answered it thoroughly","Order Verification - Asked and verified at least one or two customers' data points (email address or order no etc.)","Tools and Resources - Used all the resources available to determine the root cause of the problem/possible resolution and sought assistance from others as needed when unsure","Resolution and Processes/Guidelines - Used good judgment and decision making while resolving the issue conveyed every detail of the process clearly and accurately","Documentation - Documented the necessary information during the interaction if needed","GDPR Compliance - Delivered the GDPR Script onset of the call","Pronunciation and Right Verbiage - Spoke to the customer using correct English grammar","Look back and Learn - Proactive and offered additional assistance","Closing Spiel- Thanked the customer for calling","Call Summary","Feedback","Form Type","Created On","Greeting - Followed proper greeting Comment","Assistance - Offered sincere and immediate assistance and let the customer feel important Comment","Pace - Adapted to caller's style and pace and put the customer at ease Comment","Empathy - Used empathy statement in a timely manner Comment","Active Listening - Actively listened to the customer and responded appropriately Comment","Paraphrasing and Probing - Paraphrased the concern and made appropriate use of probing questions Comment","Comprehension - Understand the customers' questions and answered it thoroughly Comment","Order Verification - Asked and verified at least one or two customers data points (email address or order no etc.) Comment","Tools and Resources - Used all the resources available to determine the root cause of the problem/possible resolution and sought assistance from others as needed when unsure Comment","Resolution and Processes/Guidelines - Used good judgment and decision making while resolving the issue conveyed every detail of the process clearly and accurately Comment","Documentation - Documented the necessary information during the interaction if needed Comment","GDPR Compliance - Delivered the GDPR Script onset of the call Comment","Pronunciation and Right Verbiage - Spoke to the customer using correct English grammar Comment","Look back and Learn - Proactive and offered additional assistance Comment","Closing Spiel- Thanked the customer for calling Comment");
		}

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		if($form_type == 1)
		{
			foreach($rr as $rdata)
			{	
				
				$row = '"'.$rdata['auditor_name'].'",';
				$row .= '"'.$rdata['audit_date'].'",';
				$row .= '"'.$rdata['audit_time'].'",';
				$row .= '"'.$rdata['agent_name'].'",';
				$row .= '"'.$rdata['ticket_no'].'",';
				$row .= '"'.$rdata['order_no'].'",';
				$row .= '"'.$rdata['caller_title'].'",';
				$row .= '"'.$rdata['caller_name'].'",';
				$row .= '"'.$rdata['caller_date'].'",';
				$row .= '"'.$rdata['audit_type'].'",';
				$row .= '"'.$rdata['voc'].'",';
				$row .= '"'.$rdata['overall_score'].'",';

				$row .= '"'.$rdata['approach_greeting_1'].'",';
				$row .= '"'.$rdata['approach_greeting_2'].'",';
				$row .= '"'.$rdata['approach_greeting_3'].'",';
				$row .= '"'.$rdata['discovery_1'].'",';
				$row .= '"'.$rdata['discovery_2'].'",';
				$row .= '"'.$rdata['verification'].'",';
				$row .= '"'.$rdata['process_1'].'",';
				$row .= '"'.$rdata['process_2'].'",';
				$row .= '"'.$rdata['process_3'].'",';
				$row .= '"'.$rdata['process_4'].'",';
				$row .= '"'.$rdata['process_5'].'",';
				$row .= '"'.$rdata['communication_1'].'",';
				$row .= '"'.$rdata['closing_1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['feedback'])).'",';	
				$row .= '"'.$form_type.'",';
				$row .= '"'.$rdata['entry_date'].'",';
				
				$row .= '"'.$rdata['approach_greeting_1_cmt'].'",';
				$row .= '"'.$rdata['approach_greeting_2_cmt'].'",';
				$row .= '"'.$rdata['approach_greeting_3_cmt'].'",';
				$row .= '"'.$rdata['discovery_1_cmt'].'",';
				$row .= '"'.$rdata['discovery_2_cmt'].'",';
				$row .= '"'.$rdata['verification_cmt'].'",';
				$row .= '"'.$rdata['process_1_cmt'].'",';
				$row .= '"'.$rdata['process_2_cmt'].'",';
				$row .= '"'.$rdata['process_3_cmt'].'",';
				$row .= '"'.$rdata['process_4_cmt'].'",';
				$row .= '"'.$rdata['process_5_cmt'].'",';
				$row .= '"'.$rdata['communication_1_cmt'].'",';
				$row .= '"'.$rdata['closing_1_cmt'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			
			fclose($fopen);
		}
		elseif($form_type == 2)
		{	foreach($rr as $rdata)
			{	
				
				$row = '"'.$rdata['auditor_name'].'",';
				$row .= '"'.$rdata['audit_date'].'",';
				$row .= '"'.$rdata['audit_time'].'",';
				$row .= '"'.$rdata['agent_name'].'",';
				$row .= '"'.$rdata['ticket_no'].'",';
				$row .= '"'.$rdata['order_no'].'",';
				$row .= '"'.$rdata['caller_title'].'",';
				$row .= '"'.$rdata['caller_name'].'",';
				$row .= '"'.$rdata['caller_date'].'",';
				$row .= '"'.$rdata['audit_type'].'",';
				$row .= '"'.$rdata['voc'].'",';
				$row .= '"'.$rdata['overall_score'].'",';
				
				$row .= '"'.$rdata['approach_greeting_1'].'",';
				$row .= '"'.$rdata['approach_greeting_2'].'",';
				$row .= '"'.$rdata['approach_greeting_3'].'",';
				$row .= '"'.$rdata['approach_greeting_4'].'",';
				$row .= '"'.$rdata['discovery_1'].'",';
				$row .= '"'.$rdata['discovery_2'].'",';
				$row .= '"'.$rdata['discovery_3'].'",';
				$row .= '"'.$rdata['verification'].'",';
				$row .= '"'.$rdata['process_1'].'",';
				$row .= '"'.$rdata['process_2'].'",';
				$row .= '"'.$rdata['process_3'].'",';
				$row .= '"'.$rdata['process_4'].'",';
				$row .= '"'.$rdata['communication_1'].'",';
				$row .= '"'.$rdata['closing_1'].'",';
				$row .= '"'.$rdata['closing_2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['feedback'])).'",';	
				$row .= '"'.$form_type.'",';
				$row .= '"'.$rdata['entry_date'].'"';
				
				$row .= '"'.$rdata['approach_greeting_1_cmt'].'",';
				$row .= '"'.$rdata['approach_greeting_2_cmt'].'",';
				$row .= '"'.$rdata['approach_greeting_3_cmt'].'",';
				$row .= '"'.$rdata['approach_greeting_4_cmt'].'",';
				$row .= '"'.$rdata['discovery_1_cmt'].'",';
				$row .= '"'.$rdata['discovery_2_cmt'].'",';
				$row .= '"'.$rdata['discovery_3_cmt'].'",';
				$row .= '"'.$rdata['verification_cmt'].'",';
				$row .= '"'.$rdata['process_1_cmt'].'",';
				$row .= '"'.$rdata['process_2_cmt'].'",';
				$row .= '"'.$rdata['process_3_cmt'].'",';
				$row .= '"'.$rdata['process_4_cmt'].'",';
				$row .= '"'.$rdata['communication_1_cmt'].'",';
				$row .= '"'.$rdata['closing_1_cmt'].'",';
				$row .= '"'.$rdata['closing_2_cmt'].'",';
				
				fwrite($fopen,$row."\r\n");
			}
			
			fclose($fopen);
		}
		
	}
	public function download_qa_welcome_pickup_CSV($form_type)
	{
		if($form_type == 1)
			$type = "Ticket";
		elseif($form_type == 2)
			$type = "Call";
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/qa_welcome_pickup_report-".$type."-".get_user_id().".csv";
		$newfile="QA Welcome Pickup ".$type." List-".$currDate.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	/***************Agent Section****************/
	public function agent_welcome_pickup_feedback()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_welcome_pickups/agent_welcome_pickup_feedback.php";
			$data["agentUrl"] = "Qa_welcomepickup/agent_welcome_pickup_feedback";
			
			
			$qSql="Select count(id) as value from qa_welcome_pickups_tickets where agent_id='$current_user'";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_welcome_pickups_tickets where id  not in (select fd_id from qa_welcome_pickups_agent_rvw ) and agent_id='$current_user'";
			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
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

				$data["agent_review_list"] = $this->Qa_welcomepickup_model->get_agent_review_data($field_array);
					
			 }else{	
				$data["agent_review_list"] = $this->Qa_welcomepickup_model->get_agent_not_review_data($current_user);			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function agent_welcome_pickup_feedback_rvw($type,$id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			if($type == 1)
			{
				$data["content_template"] = "qa_welcome_pickups/agent_welcome_pickup_ticket_feedback_rvw.php";
			}
			elseif($type == 2)
			{
				$data["content_template"] = "qa_welcome_pickups/agent_welcome_pickup_call_feedback_rvw.php";
			}
			$data["agentUrl"] = "Qa_welcomepickup/agent_welcome_pickup_feedback";
			$data["get_welcome_pickup_feedback"] = $this->Qa_welcomepickup_model->view_welcome_pickup_feedback($id);
			
			$data["rdid"]=$id;
			
			$data["row1"] = $this->Qa_welcomepickup_model->view_agent_welcome_pickup_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_welcomepickup_model->view_mgnt_welcome_pickup_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('rd_id'))
			{
				$rd_id=$this->input->post('rd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $rd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_welcome_pickups_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rd_id);
					$this->db->update('qa_welcome_pickups_agent_rvw',$field_array1);
				}	
				redirect('Qa_welcomepickup/agent_welcome_pickup_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	public function view_welcome_pickup_feedback($_id)
	{
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_rugdoctor_feedback where id='$_id') xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid)";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
 }