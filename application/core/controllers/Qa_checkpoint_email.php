<?php 

 class Qa_checkpoint_email extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_checkpoint_email_model');
	}
	 


	 
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint_email/qa_checkpoint_email_feedback.php";
			
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
				"current_user" => $current_user
			);
			
			$data["qa_checkpoint_email_data"] = $this->Qa_checkpoint_email_model->get_checkpoint_data($field_array);
			
			//$data["qa_puppyspot_pc_data"] = $this->Qa_checkpoint_email_model->get_puppyspot_pc_data($field_array);
			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_checkpoint_email_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint_email/add_checkpoint_email_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_checkpoint_email_model->get_agent_id(26,38);
			
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
					
					"probing_que_assist" => $this->input->post('probing_que_assist'),
					"probing_que_ticket" => $this->input->post('probing_que_ticket'),
					"accuracy_info" => $this->input->post('accuracy_info'),
					"more_concerns" => $this->input->post('more_concerns'),
					"review_conversation" => $this->input->post('review_conversation'),
					"resolution" => $this->input->post('resolution'),
					"offer_additional" => $this->input->post('offer_additional'),
					"empathy_enthusiasm" => $this->input->post('empathy_enthusiasm'),
					"simplicity_politeness" => $this->input->post('simplicity_politeness'),
					"grammar" => $this->input->post('grammar'),
					"instruction_email" => $this->input->post('instruction_email'),
					"salutation" => $this->input->post('salutation'),
					"closing" => $this->input->post('closing'),
					"escalation" => $this->input->post('escalation'),
					"proper_tools" => $this->input->post('proper_tools'),
					"proper_tags" => $this->input->post('proper_tags'),
					"other_notes" => $this->input->post('other_notes'),
					"timeliness_response" => $this->input->post('timeliness_response'),
					"status" => $this->input->post('status'),
					"probing_que_assist_rmk" => $this->input->post('probing_que_assist_rmk'),
					"probing_que_ticket_rmk" => $this->input->post('probing_que_ticket_rmk'),
					"accuracy_info_rmk" => $this->input->post('accuracy_info_rmk'),
					"more_concerns_rmk" => $this->input->post('more_concerns_rmk'),
					"review_conversation_rmk" => $this->input->post('review_conversation_rmk'),
					"resolution_rmk" => $this->input->post('resolution_rmk'),
					"offer_additional_rmk" => $this->input->post('offer_additional_rmk'),
					"empathy_enthusiasm_rmk" => $this->input->post('empathy_enthusiasm_rmk'),
					"simplicity_politeness_rmk" => $this->input->post('simplicity_politeness_rmk'),
					"grammar_rmk" => $this->input->post('grammar_rmk'),
					"instruction_email_rmk" => $this->input->post('instruction_email_rmk'),
					"salutation_rmk" => $this->input->post('salutation_rmk'),
					"closing_rmk" => $this->input->post('closing_rmk'),
					"escalation_rmk" => $this->input->post('escalation_rmk'),
					"proper_tools_rmk" => $this->input->post('proper_tools_rmk'),
					"proper_tags_rmk" => $this->input->post('proper_tags_rmk'),
					"other_notes_rmk" => $this->input->post('other_notes_rmk'),
					"timeliness_response_rmk" => $this->input->post('timeliness_response_rmk'),
					"status_rmk" => $this->input->post('status_rmk'),
					
					"recommendations" => $this->input->post('recommendations'),					
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->checkpoint_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_checkpoint_email_feedback',$field_array);
				redirect('Qa_checkpoint_email');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function checkpoint_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_checkpoint/checkpoint_email/';
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
	
	
	public function mgnt_checkpoint_email_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint_email/mgnt_checkpoint_email_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_checkpoint_email_model->get_agent_id(26,38);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["get_checkpoint_email_feedback"] = $this->Qa_checkpoint_email_model->view_checkpoint_email_feedback($id);
			
			$data["paid"]=$id;
			
			$data["row1"] = $this->Qa_checkpoint_email_model->view_agent_checkpoint_email_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_checkpoint_email_model->view_mgnt_checkpoint_email_rvw($id);//MGNT PURPOSE
			
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
					
					"probing_que_assist" => $this->input->post('probing_que_assist'),
					"probing_que_ticket" => $this->input->post('probing_que_ticket'),
					"accuracy_info" => $this->input->post('accuracy_info'),
					"more_concerns" => $this->input->post('more_concerns'),
					"review_conversation" => $this->input->post('review_conversation'),
					"resolution" => $this->input->post('resolution'),
					"offer_additional" => $this->input->post('offer_additional'),
					"empathy_enthusiasm" => $this->input->post('empathy_enthusiasm'),
					"simplicity_politeness" => $this->input->post('simplicity_politeness'),
					"grammar" => $this->input->post('grammar'),
					"instruction_email" => $this->input->post('instruction_email'),
					"salutation" => $this->input->post('salutation'),
					"closing" => $this->input->post('closing'),
					"escalation" => $this->input->post('escalation'),
					"proper_tools" => $this->input->post('proper_tools'),
					"proper_tags" => $this->input->post('proper_tags'),
					"other_notes" => $this->input->post('other_notes'),
					"timeliness_response" => $this->input->post('timeliness_response'),
					"status" => $this->input->post('status'),
					"probing_que_assist_rmk" => $this->input->post('probing_que_assist_rmk'),
					"probing_que_ticket_rmk" => $this->input->post('probing_que_ticket_rmk'),
					"accuracy_info_rmk" => $this->input->post('accuracy_info_rmk'),
					"more_concerns_rmk" => $this->input->post('more_concerns_rmk'),
					"review_conversation_rmk" => $this->input->post('review_conversation_rmk'),
					"resolution_rmk" => $this->input->post('resolution_rmk'),
					"offer_additional_rmk" => $this->input->post('offer_additional_rmk'),
					"empathy_enthusiasm_rmk" => $this->input->post('empathy_enthusiasm_rmk'),
					"simplicity_politeness_rmk" => $this->input->post('simplicity_politeness_rmk'),
					"grammar_rmk" => $this->input->post('grammar_rmk'),
					"instruction_email_rmk" => $this->input->post('instruction_email_rmk'),
					"salutation_rmk" => $this->input->post('salutation_rmk'),
					"closing_rmk" => $this->input->post('closing_rmk'),
					"escalation_rmk" => $this->input->post('escalation_rmk'),
					"proper_tools_rmk" => $this->input->post('proper_tools_rmk'),
					"proper_tags_rmk" => $this->input->post('proper_tags_rmk'),
					"other_notes_rmk" => $this->input->post('other_notes_rmk'),
					"timeliness_response_rmk" => $this->input->post('timeliness_response_rmk'),
					"status_rmk" => $this->input->post('status_rmk'),
					
					"recommendations" => $this->input->post('recommendations'),	
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$this->db->where('id', $pa_id);
				$this->db->update('qa_checkpoint_email_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_checkpoint_email_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_checkpoint_email_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_checkpoint_email');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	

	
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			//$qSql = "Select id, assigned_to,(Select CONCAT(fname,' ' ,lname) as name from signin s where s.id=assigned_to) as tl_name, fusion_id, get_process_names(id) as process_name FROM signin where id = '$aid'";
			$qSql = "Select s.id, s.assigned_to,  CONCAT(s1.fname,' ' ,s1.lname) as tl_name, 
            s.fusion_id, get_process_names(s.id) as process_name FROM signin s 
            left join signin s1 on s1.id = s.assigned_to where s.id ='$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
 }