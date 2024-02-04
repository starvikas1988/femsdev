<?php 

 class Qa_checkpoint_chat extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_checkpoint_chat_model');
	}
	 


	 
	public function index(){
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint_chat/qa_checkpoint_chat_feedback.php";
			
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
			
			$data["qa_checkpoint_chat_data"] = $this->Qa_checkpoint_chat_model->get_checkpoint_data($field_array);
			
			//$data["qa_puppyspot_pc_data"] = $this->Qa_checkpoint_email_model->get_puppyspot_pc_data($field_array);
			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////PuppySpot PA//////////////////////////////
	
	public function add_checkpoint_chat_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint_chat/add_checkpoint_chat_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_checkpoint_chat_model->get_agent_id(26,38);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => mmddyy2mysql($this->input->post('audit_date')),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					
					"opening_spiel" => $this->input->post('opening_spiel'),
					"offered_assistance" => $this->input->post('offered_assistance'),
					"empathy" => $this->input->post('empathy'),
					"being_polite" => $this->input->post('being_polite'),
					"peta" => $this->input->post('peta'),
					"reduced_response_time" => $this->input->post('reduced_response_time'),
					"chat_flow" => $this->input->post('chat_flow'),
					"understanding_issue" => $this->input->post('understanding_issue'),
					"proper_probing" => $this->input->post('proper_probing'),
					"accuracy" => $this->input->post('accuracy'),
					"product_service_info" => $this->input->post('product_service_info'),
					"technical_procedures" => $this->input->post('technical_procedures'),
					"case_logs" => $this->input->post('case_logs'),
					"actions_taken" => $this->input->post('actions_taken'),
					"correct_grammar" => $this->input->post('correct_grammar'),
					"proper_use_msg" => $this->input->post('proper_use_msg'),
					"cust_satisfaction" => $this->input->post('cust_satisfaction'),
					
					"opening_spiel_rmk" => $this->input->post('opening_spiel_rmk'),
					"offered_assistance_rmk" => $this->input->post('offered_assistance_rmk'),
					"empathy_rmk" => $this->input->post('empathy_rmk'),
					"being_polite_rmk" => $this->input->post('being_polite_rmk'),
					"peta_rmk" => $this->input->post('peta_rmk'),
					"reduced_response_time_rmk" => $this->input->post('reduced_response_time_rmk'),
					"chat_flow_rmk" => $this->input->post('chat_flow_rmk'),
					"understanding_issue_rmk" => $this->input->post('understanding_issue_rmk'),
					"proper_probing_rmk" => $this->input->post('proper_probing_rmk'),
					"accuracy_rmk" => $this->input->post('accuracy_rmk'),
					"product_service_info_rmk" => $this->input->post('product_service_info_rmk'),
					"technical_procedures_rmk" => $this->input->post('technical_procedures_rmk'),
					"case_logs_rmk" => $this->input->post('case_logs_rmk'),
					"actions_taken_rmk" => $this->input->post('actions_taken_rmk'),
					"correct_grammar_rmk" => $this->input->post('correct_grammar_rmk'),
					"proper_use_msg_rmk" => $this->input->post('proper_use_msg_rmk'),
					"cust_satisfaction_rmk" => $this->input->post('cust_satisfaction_rmk'),
										
					"recommendations" => $this->input->post('recommendations'),					
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->checkpoint_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_checkpoint_chat_feedback',$field_array);
				redirect('Qa_checkpoint_chat');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function checkpoint_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_checkpoint/checkpoint_chat/';
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
	
	
	public function mgnt_checkpoint_chat_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpoint_chat/mgnt_checkpoint_chat_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_checkpoint_chat_model->get_agent_id(26,38);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["get_checkpoint_chat_feedback"] = $this->Qa_checkpoint_chat_model->view_checkpoint_chat_feedback($id);
			
			$data["paid"]=$id;
			
			$data["row1"] = $this->Qa_checkpoint_chat_model->view_agent_checkpoint_chat_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_checkpoint_chat_model->view_mgnt_checkpoint_chat_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('pa_id'))
			{
				$pa_id=$this->input->post('pa_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => mmddyy2mysql($this->input->post('audit_date')),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					
					"opening_spiel" => $this->input->post('opening_spiel'),
					"offered_assistance" => $this->input->post('offered_assistance'),
					"empathy" => $this->input->post('empathy'),
					"being_polite" => $this->input->post('being_polite'),
					"peta" => $this->input->post('peta'),
					"reduced_response_time" => $this->input->post('reduced_response_time'),
					"chat_flow" => $this->input->post('chat_flow'),
					"understanding_issue" => $this->input->post('understanding_issue'),
					"proper_probing" => $this->input->post('proper_probing'),
					"accuracy" => $this->input->post('accuracy'),
					"product_service_info" => $this->input->post('product_service_info'),
					"technical_procedures" => $this->input->post('technical_procedures'),
					"case_logs" => $this->input->post('case_logs'),
					"actions_taken" => $this->input->post('actions_taken'),
					"correct_grammar" => $this->input->post('correct_grammar'),
					"proper_use_msg" => $this->input->post('proper_use_msg'),
					"cust_satisfaction" => $this->input->post('cust_satisfaction'),
					
					"opening_spiel_rmk" => $this->input->post('opening_spiel_rmk'),
					"offered_assistance_rmk" => $this->input->post('offered_assistance_rmk'),
					"empathy_rmk" => $this->input->post('empathy_rmk'),
					"being_polite_rmk" => $this->input->post('being_polite_rmk'),
					"peta_rmk" => $this->input->post('peta_rmk'),
					"reduced_response_time_rmk" => $this->input->post('reduced_response_time_rmk'),
					"chat_flow_rmk" => $this->input->post('chat_flow_rmk'),
					"understanding_issue_rmk" => $this->input->post('understanding_issue_rmk'),
					"proper_probing_rmk" => $this->input->post('proper_probing_rmk'),
					"accuracy_rmk" => $this->input->post('accuracy_rmk'),
					"product_service_info_rmk" => $this->input->post('product_service_info_rmk'),
					"technical_procedures_rmk" => $this->input->post('technical_procedures_rmk'),
					"case_logs_rmk" => $this->input->post('case_logs_rmk'),
					"actions_taken_rmk" => $this->input->post('actions_taken_rmk'),
					"correct_grammar_rmk" => $this->input->post('correct_grammar_rmk'),
					"proper_use_msg_rmk" => $this->input->post('proper_use_msg_rmk'),
					"cust_satisfaction_rmk" => $this->input->post('cust_satisfaction_rmk'),
					
					"recommendations" => $this->input->post('recommendations'),	
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$this->db->where('id', $pa_id);
				$this->db->update('qa_checkpoint_chat_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_checkpoint_chat_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_checkpoint_chat_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_checkpoint_chat');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
//////////////////////PuppySpot PC//////////////////////////////
	
	public function add_pc_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/add_pc_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_puppyspot_model->get_agent_id(99,206);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => mmddyy2mysql($this->input->post('audit_date')),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"correct_greeting" => $this->input->post('correct_greeting'),
					"customer_greeting" => $this->input->post('customer_greeting'),
					"reached_greeting" => $this->input->post('reached_greeting'),
					"rapport_greeting" => $this->input->post('rapport_greeting'),
					"website_handle" => $this->input->post('website_handle'),
					"choice_handle" => $this->input->post('choice_handle'),
					"excitement_sale" => $this->input->post('excitement_sale'),
					"objection_sale" => $this->input->post('objection_sale'),
					"call_skill" => $this->input->post('call_skill'),
					"professional_skill" => $this->input->post('professional_skill'),
					"clear_skill" => $this->input->post('clear_skill'),
					"listening_skill" => $this->input->post('listening_skill'),
					"sales_closing" => $this->input->post('sales_closing'),
					"cost_closing" => $this->input->post('cost_closing'),
					"travel_closing" => $this->input->post('travel_closing'),
					"screening_closing" => $this->input->post('screening_closing'),
					"pup_closing" => $this->input->post('pup_closing'),
					"vca_closing" => $this->input->post('vca_closing'),
					"pcdefine_closing" => $this->input->post('pcdefine_closing'),
					"contact_notation" => $this->input->post('contact_notation'),
					"call_summary" => $this->input->post('call_summary'),
					"violation_explain" => $this->input->post('violation_explain'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->pc_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_puppyspot_pc_feedback',$field_array);
				redirect('Qa_puppyspot');
			}
			$data["array"] = $a;		
			
			$this->load->view("dashboard",$data);
		}
	}

	
	private function pc_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_puppyspot/puppyspot_pc/';
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
	
	
	public function mgnt_puppysopt_pc_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/mgnt_puppyspot_pc_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_puppyspot_model->get_agent_id(99,206);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);	
			
			$data["get_puppyspot_pc_feedback"] = $this->Qa_puppyspot_model->view_puppytspot_pc_feedback($id);
			
			$data["pcid"]=$id;
			
			$data["row1"] = $this->Qa_puppyspot_model->view_agent_puppyspot_pc_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_puppyspot_model->view_mgnt_puppyspot_pc_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('pc_id'))
			{
				$pc_id=$this->input->post('pc_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => mmddyy2mysql($this->input->post('audit_date')),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"correct_greeting" => $this->input->post('correct_greeting'),
					"customer_greeting" => $this->input->post('customer_greeting'),
					"reached_greeting" => $this->input->post('reached_greeting'),
					"rapport_greeting" => $this->input->post('rapport_greeting'),
					"website_handle" => $this->input->post('website_handle'),
					"choice_handle" => $this->input->post('choice_handle'),
					"excitement_sale" => $this->input->post('excitement_sale'),
					"objection_sale" => $this->input->post('objection_sale'),
					"call_skill" => $this->input->post('call_skill'),
					"professional_skill" => $this->input->post('professional_skill'),
					"clear_skill" => $this->input->post('clear_skill'),
					"listening_skill" => $this->input->post('listening_skill'),
					"sales_closing" => $this->input->post('sales_closing'),
					"cost_closing" => $this->input->post('cost_closing'),
					"travel_closing" => $this->input->post('travel_closing'),
					"screening_closing" => $this->input->post('screening_closing'),
					"pup_closing" => $this->input->post('pup_closing'),
					"vca_closing" => $this->input->post('vca_closing'),
					"pcdefine_closing" => $this->input->post('pcdefine_closing'),
					"contact_notation" => $this->input->post('contact_notation'),
					"call_summary" => $this->input->post('call_summary'),
					"violation_explain" => $this->input->post('violation_explain'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $pc_id);
				$this->db->update('qa_puppyspot_pc_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $pc_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_puppyspot_pc_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pc_id);
					$this->db->update('qa_puppyspot_pc_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_puppyspot');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

/////////////////Puppyspot Agent part//////////////////////////	

	public function agent_checkpoint_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_checkpint/agent_checkpoint_feedback.php";
			$data["agentUrl"] = "qa_checkpoint/agent_checkpoint_feedback";
			
			
			$qSql="Select count(id) as value from qa_puppyspot_pa_feedback where agent_id='$current_user'";
			$data["tot_checkpoint_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_checkpoint_feedback where id  not in (select fd_id from qa_checkpoint_agent_rvw) and agent_id='$current_user'";
			$data["tot_checkpoint_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		////////////
			$qSql="Select count(id) as value from qa_puppyspot_pc_feedback where agent_id='$current_user'";
			$data["tot_agent_pc_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_puppyspot_pc_feedback where id  not in (select fd_id from qa_puppyspot_pc_agent_rvw) and agent_id='$current_user'";
			$data["tot_agent_pc_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
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

				$data["agent_pa_review_list"] = $this->Qa_puppyspot_model->get_agent_pa_review_data($field_array);
				$data["agent_pc_review_list"] = $this->Qa_puppyspot_model->get_agent_pc_review_data($field_array);
					
			}else{	
				$data["agent_pa_review_list"] = $this->Qa_puppyspot_model->get_agent_not_pa_review_data($current_user);		
				$data["agent_pc_review_list"] = $this->Qa_puppyspot_model->get_agent_not_pc_review_data($current_user);		
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
			
			$data["row1"] = $this->Qa_puppyspot_model->view_agent_puppyspot_pa_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_puppyspot_model->view_mgnt_puppyspot_pa_rvw($id);//MGNT PURPOSE
			
		
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
					$rowid= data_inserter('qa_puppyspot_pa_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_puppyspot_pa_agent_rvw',$field_array1);
				}	
				redirect('Qa_puppyspot/agent_puppyspot_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_puppysopt_pc_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/agent_puppyspot_pc_feedback_rvw.php";
			$data["agentUrl"] = "qa_puppyspot/agent_puppyspot_feedback";
						
			
			$data["get_puppyspot_pc_feedback"] = $this->Qa_puppyspot_model->view_puppytspot_pc_feedback($id);
			
			$data["pcid"]=$id;
			
			$data["row1"] = $this->Qa_puppyspot_model->view_agent_puppyspot_pc_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_puppyspot_model->view_mgnt_puppyspot_pc_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('pc_id'))
			{
				$pc_id=$this->input->post('pc_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $pc_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_puppyspot_pc_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pc_id);
					$this->db->update('qa_puppyspot_pc_agent_rvw',$field_array1);
				}	
				redirect('Qa_puppyspot/agent_puppyspot_feedback');
				
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
			//$qSql = "Select * FROM signin where id = '$aid'";
				//echo $qSql;
			$qSql = "Select s.id, s.assigned_to,  CONCAT(s1.fname,' ' ,s1.lname) as tl_name, 
            s.fusion_id, get_process_names(s.id) as process_name FROM signin s 
            left join signin s1 on s1.id = s.assigned_to where s.id ='$aid'";
				
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA PuppySpot REPORT ////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_puppyspot_report(){
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
			$data["content_template"] = "qa_puppyspot/qa_puppyspot_report.php";
			
			
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
			
			
			
			$data["qa_puppyspot_list"] = array();
			
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
						"process_id" => $pValue
					);
					
				
				if($pValue=='PuppySpot PA'){
					
					$fullAray = $this->Qa_puppyspot_model->qa_puppyspot_report_model($field_array);
					$data["qa_puppyspot_list"] = $fullAray;
					$this->create_qa_puppyspot_pa_CSV($fullAray);	
					$dn_link = base_url()."qa_puppyspot/download_qa_puppyspot_pa_CSV";
				
				}else{
					
					$fullAray = $this->Qa_puppyspot_model->qa_puppyspot_report_model($field_array);
					$data["qa_puppyspot_list"] = $fullAray;
					$this->create_qa_puppyspot_pc_CSV($fullAray);	
					$dn_link = base_url()."qa_puppyspot/download_qa_puppyspot_pc_CSV";
				
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
	 
	
//////////////////PuppySpot PA///////////////////
	public function download_qa_puppyspot_pa_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA PuppySpot Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_puppyspot_pa_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Customer ID", "Call Date", "Call ID", "Phone", "Campaign", "Audit Type", "VOC", "Did the PA use correct greeting?", "Did the PA ask the customer for their name?", "Did the PA establish rapport by asking questions?", "Did the PA ask the customer to visit our website?", "Did the PA ask for the puppy of choice and/or recommend a puppy?", "Did the PA build excitement?", "Did the PA offer overcome customers objection?", "Did the PA avoid long silences during the call?", "Did the PA display a professional manner throughout the call?", "Did the PA sounded clear and confident throughout the call?", "Did the PA demonstrate active listening?", "Did the PA set an appointment? Did the PA transferred the call?", "Did the PA confirm the final cost?", "Did the PA complete the Sales recap?", "Did the PA set proper Travel expectations?", "Did the PA ask all screening questions?", "If no sale did the PA define the next steps?", "Did the PA effectively notate the contact?", "Overall Score", "Call Summary", "Opportunities", "Were there any violations in the call?If yes please explain", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['correct_greeting']==2.1) $correct_greeting='N/A';
			else $correct_greeting=$user['correct_greeting'];
			
			if($user['customer_greeting']==3.1) $customer_greeting='N/A';
			else $customer_greeting=$user['customer_greeting'];
			
			if($user['rapport_greeting']==10.1) $rapport_greeting='N/A';
			else $rapport_greeting=$user['rapport_greeting'];
			
			if($user['website_greeting']==10.1) $website_greeting='N/A';
			else $website_greeting=$user['website_greeting'];
			
			if($user['puppy_greeting']==10.1) $puppy_greeting='N/A';
			else $puppy_greeting=$user['puppy_greeting'];
			
			if($user['excitement_sale']==3.1) $excitement_sale='N/A';
			else $excitement_sale=$user['excitement_sale'];
			
			if($user['objection_sale']==7.1) $objection_sale='N/A';
			else $objection_sale=$user['objection_sale'];
			
			if($user['silence_sale']==3.1) $silence_sale='N/A';
			else $silence_sale=$user['silence_sale'];
			
			if($user['professional_sale']==3.1) $professional_sale='N/A';
			else $professional_sale=$user['professional_sale'];
			
			if($user['sound_sale']==3.1) $sound_sale='N/A';
			else $sound_sale=$user['sound_sale'];
			
			if($user['listening_sale']==5.1) $listening_sale='N/A';
			else $listening_sale=$user['listening_sale'];
			
			if($user['transfer_closing']==10.1) $transfer_closing='N/A';
			else $transfer_closing=$user['transfer_closing'];
			
			if($user['cost_closing']==3.1) $cost_closing='N/A';
			else $cost_closing=$user['cost_closing'];
			
			if($user['sales_closing']==3.1) $sales_closing='N/A';
			else $sales_closing=$user['sales_closing'];
			
			if($user['travel_closing']==5.1) $travel_closing='N/A';
			else $travel_closing=$user['travel_closing'];
			
			if($user['screening_closing']==5.1) $screening_closing='N/A';
			else $screening_closing=$user['screening_closing'];
			
			if($user['step_closing']==5.1) $step_closing='N/A';
			else $step_closing=$user['step_closing'];
			
			if($user['contact_notation']==10.1) $contact_notation='N/A';
			else $contact_notation=$user['contact_notation'];
			
			
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
			$row .= '"'.$correct_greeting.'",'; 
			$row .= '"'.$customer_greeting.'",';
			$row .= '"'.$rapport_greeting.'",';
			$row .= '"'.$website_greeting.'",';
			$row .= '"'.$puppy_greeting.'",';
			$row .= '"'.$excitement_sale.'",';
			$row .= '"'.$objection_sale.'",';
			$row .= '"'.$silence_sale.'",';
			$row .= '"'.$professional_sale.'",';
			$row .= '"'.$sound_sale.'",';
			$row .= '"'.$listening_sale.'",';
			$row .= '"'.$transfer_closing.'",';
			$row .= '"'.$cost_closing.'",';
			$row .= '"'.$sales_closing.'",';
			$row .= '"'.$travel_closing.'",';
			$row .= '"'.$screening_closing.'",';
			$row .= '"'.$step_closing.'",';
			$row .= '"'.$contact_notation.'",';
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['opportunity'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['violation_explain'])).'",';
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
	
	
//////////////////PuppySpot PC///////////////////
	public function download_qa_puppyspot_pc_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA PuppySpot PC Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_puppyspot_pc_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Customer ID", "Call Date", "Call ID", "Phone", "Campaign", "Audit Type", "VOC", "Did the PC use correct greeting?", "Did the PC ask the customer for their name?", "Has anyone from PuppySpot ever reached out to you before?", "Did the PC establish rapport by asking questions?", "Did the PC ask the customer to visit our web site?", "Did the PC ask for the puppy of choice and/or recommend a puppy?", "Did the PC build excitement?", "Did the PC offer overcome customers objection?", "Did the PC avoid long silences during the call?", "Did the PC display a professional manner throughout the call?", "Did the PC sound clear and confident throughout the call?", "Did the PC demonstrate active listening?", "Did the PC ask for the sale?", "Did the PC complete the Sales recap including final cost?", "Did the PC set proper Travel expectations?", "Did the PC ask all screening questions?", "Did the PC offer/explain the value of the Pup Pack?", "Did the PC explain our VIP Puppy program using VCA as value prop?", "If no sale did the PC define the next steps?", "Did the PC effectively notate the contact?", "Overall Score", "Call Summary", "Were there any violations in the call?If yes please explain", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['correct_greeting']==2.1) $correct_greeting='N/A';
			else $correct_greeting=$user['correct_greeting'];
			
			if($user['customer_greeting']==2.1) $customer_greeting='N/A';
			else $customer_greeting=$user['customer_greeting'];
			
			if($user['reached_greeting']==3.1) $reached_greeting='N/A';
			else $reached_greeting=$user['reached_greeting'];
			
			if($user['rapport_greeting']==8.1) $rapport_greeting='N/A';
			else $rapport_greeting=$user['rapport_greeting'];
			
			if($user['website_handle']==8.1) $website_handle='N/A';
			else $website_handle=$user['website_handle'];
			
			if($user['choice_handle']==8.1) $choice_handle='N/A';
			else $choice_handle=$user['choice_handle'];
			
			if($user['excitement_sale']==3.1) $excitement_sale='N/A';
			else $excitement_sale=$user['excitement_sale'];
			
			if($user['objection_sale']==7.1) $objection_sale='N/A';
			else $objection_sale=$user['objection_sale'];
			
			if($user['call_skill']==2.1) $call_skill='N/A';
			else $call_skill=$user['call_skill'];
			
			if($user['professional_skill']==3.1) $professional_skill='N/A';
			else $professional_skill=$user['professional_skill'];
			
			if($user['clear_skill']==3.1) $clear_skill='N/A';
			else $clear_skill=$user['clear_skill'];
			
			if($user['listening_skill']==5.1) $listening_skill='N/A';
			else $listening_skill=$user['listening_skill'];
			
			if($user['sales_closing']==8.1) $sales_closing='N/A';
			else $sales_closing=$user['sales_closing'];
			
			if($user['cost_closing']==5.1) $cost_closing='N/A';
			else $cost_closing=$user['cost_closing'];
			
			if($user['travel_closing']==5.1) $travel_closing='N/A';
			else $travel_closing=$user['travel_closing'];
			
			if($user['screening_closing']==5.1) $screening_closing='N/A';
			else $screening_closing=$user['screening_closing'];
			
			if($user['pup_closing']==5.1) $pup_closing='N/A';
			else $pup_closing=$user['pup_closing'];
			
			if($user['vca_closing']==5.1) $vca_closing='N/A';
			else $vca_closing=$user['vca_closing'];
			
			if($user['pcdefine_closing']==5.1) $pcdefine_closing='N/A';
			else $pcdefine_closing=$user['pcdefine_closing'];
			
			if($user['contact_notation']==8.1) $contact_notation='N/A';
			else $contact_notation=$user['contact_notation'];
			
			
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
			$row .= '"'.$correct_greeting.'",'; 
			$row .= '"'.$customer_greeting.'",';
			$row .= '"'.$reached_greeting.'",';
			$row .= '"'.$rapport_greeting.'",';
			$row .= '"'.$website_handle.'",';
			$row .= '"'.$choice_handle.'",';
			$row .= '"'.$excitement_sale.'",';
			$row .= '"'.$objection_sale.'",';
			$row .= '"'.$call_skill.'",';
			$row .= '"'.$professional_skill.'",';
			$row .= '"'.$clear_skill.'",';
			$row .= '"'.$listening_skill.'",';
			$row .= '"'.$sales_closing.'",';
			$row .= '"'.$cost_closing.'",';
			$row .= '"'.$travel_closing.'",';
			$row .= '"'.$screening_closing.'",';
			$row .= '"'.$pup_closing.'",';
			$row .= '"'.$vca_closing.'",';
			$row .= '"'.$pcdefine_closing.'",';
			$row .= '"'.$contact_notation.'",';
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['violation_explain'])).'",';
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
	
	
	
	
	
	
 }