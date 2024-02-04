<?php 

 class Qa_verso extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_verso_model');
	}
	 


//////////////////////VERSO Inbound//////////////////////////////////////////////
	 
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_inbound/qa_verso_ib_feedback.php";
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_ib_id(9,18);
			
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
			$data["qa_verso_ib_data"] = $this->Qa_verso_model->get_qa_verso_ib_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_verso_ib_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_inbound/add_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_ib_id(9,18);
			
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
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_id" => $this->input->post('call_id'),
					"agent_crm_id" => $this->input->post('agent_crm_id'),
					"site" => $this->input->post('site'),
					"overall_score" => $this->input->post('total_score'),
					"call_opening" => $this->input->post('call_opening'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"enthusiasm" => $this->input->post('enthusiasm'),
					"politeness_courtesy" => $this->input->post('politeness_courtesy'),
					"fluency" => $this->input->post('fluency'),
					"accurate_resolution" => $this->input->post('accurate_resolution'),
					"crm_accuracy" => $this->input->post('crm_accuracy'),
					"closing" => $this->input->post('closing'),
					"active_listening" => $this->input->post('active_listening'),
					"hold_protocol" => $this->input->post('hold_protocol'),
					"effective_probing" => $this->input->post('effective_probing'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->verso_ib_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_verso_ib_feedback',$field_array);
				redirect('Qa_verso');
			}
			$data["array"] = $a;			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	private function verso_ib_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_verso/verso_inbound/';
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
	
	
	public function mgnt_verso_ib_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_inbound/mgnt_verso_ib_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_ib_id(9,18);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);		
			
			$data["get_verso_ib_feedback"] = $this->Qa_verso_model->view_verso_ib_feedback($id);
			
			$data["vib_id"]=$id;
			
			$data["row1"] = $this->Qa_verso_model->view_agent_verso_ib_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_verso_model->view_mgnt_verso_ib_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('vib_id'))
			{
				$vib_id=$this->input->post('vib_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_id" => $this->input->post('call_id'),
					"agent_crm_id" => $this->input->post('agent_crm_id'),
					"site" => $this->input->post('site'),
					"overall_score" => $this->input->post('total_score'),
					"call_opening" => $this->input->post('call_opening'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"enthusiasm" => $this->input->post('enthusiasm'),
					"politeness_courtesy" => $this->input->post('politeness_courtesy'),
					"fluency" => $this->input->post('fluency'),
					"accurate_resolution" => $this->input->post('accurate_resolution'),
					"crm_accuracy" => $this->input->post('crm_accuracy'),
					"closing" => $this->input->post('closing'),
					"active_listening" => $this->input->post('active_listening'),
					"hold_protocol" => $this->input->post('hold_protocol'),
					"effective_probing" => $this->input->post('effective_probing'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $vib_id);
				$this->db->update('qa_verso_ib_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $vib_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_verso_ib_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $vib_id);
					$this->db->update('qa_verso_ib_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_verso');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
/////////////////////////////VERSO Outbound////////////////////////////////////

/*---------full call audit---------------*/
	 
	public function qa_verso_ob_fc_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/qa_verso_ob_fc_feedback.php";
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_id(9,19,67);
			
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
			$data["qa_verso_ob_fc_data"] = $this->Qa_verso_model->get_qa_verso_ob_fc_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_ob_fc_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/add_ob_fc_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_id(9,19,67);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent') ";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"site" => $this->input->post('site'),
					"agent_crm_id" => $this->input->post('agent_crm_id'),
					"revenue" => $this->input->post('revenue'),
					"overall_score" => $this->input->post('total_score'),
					"tag_error" => $this->input->post('tag_error'),
					"tag_error_comment" => $this->input->post('tag_error_comment'),
					"probing_error" => $this->input->post('probing_error'),
					"probing_error_comment" => $this->input->post('probing_error_comment'),
					"other_error" => $this->input->post('other_error'),
					"other_error_comment" => $this->input->post('other_error_comment'),
					"fallout" => $this->input->post('fallout'),
					"fallout_comment" => $this->input->post('fallout_comment'),
					"ztp" => $this->input->post('ztp'),
					"call_status" => $this->input->post('call_status'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->verso_ob_fca_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_verso_ob_fca_feedback',$field_array);
				redirect('Qa_verso/qa_verso_ob_fc_feedback');
			}
			$data["array"] = $a;			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	private function verso_ob_fca_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_verso/verso_outbound_fca/';
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
	
	public function mgnt_verso_fca_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/mgnt_verso_ob_fc_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_id(9,19,67);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["get_verso_ob_fca_feedback"] = $this->Qa_verso_model->view_verso_ob_fc_feedback($id);
			
			$data["obfca_id"]=$id;
			
			$data["row1"] = $this->Qa_verso_model->view_agent_verso_ob_fca_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_verso_model->view_mgnt_verso_ob_fca_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('obfca_id'))
			{
				$obfca_id=$this->input->post('obfca_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"agent_crm_id" => $this->input->post('agent_crm_id'),
					"site" => $this->input->post('site'),
					"revenue" => $this->input->post('revenue'),
					"overall_score" => $this->input->post('total_score'),
					"tag_error" => $this->input->post('tag_error'),
					"tag_error_comment" => $this->input->post('tag_error_comment'),
					"probing_error" => $this->input->post('probing_error'),
					"probing_error_comment" => $this->input->post('probing_error_comment'),
					"other_error" => $this->input->post('other_error'),
					"other_error_comment" => $this->input->post('other_error_comment'),
					"fallout" => $this->input->post('fallout'),
					"fallout_comment" => $this->input->post('fallout_comment'),
					"ztp" => $this->input->post('ztp'),
					"call_status" => $this->input->post('call_status'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $obfca_id);
				$this->db->update('qa_verso_ob_fca_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $obfca_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_verso_ob_fca_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $obfca_id);
					$this->db->update('qa_verso_ob_fca_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_verso/qa_verso_ob_fc_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/*---------special call audit---------------*/
	 
	public function qa_verso_ob_sc_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/qa_verso_ob_sc_feedback.php";
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_id(9,19,67);
			
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
			$data["qa_verso_ob_sc_data"] = $this->Qa_verso_model->get_qa_verso_ob_sc_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_ob_sc_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/add_ob_sc_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_id(9,19,67);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"agent_crm_id" => $this->input->post('agent_crm_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"site" => $this->input->post('site'),
					"question_code" => $this->input->post('question_code'),
					"call_status" => $this->input->post('call_status'),
					"reject_reason" => $this->input->post('reject_reason'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->verso_ob_sca_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_verso_ob_sca_feedback',$field_array);
				redirect('Qa_verso/qa_verso_ob_sc_feedback');
			}
			$data["array"] = $a;			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	private function verso_ob_sca_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_verso/verso_outbound_sca/';
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
	
	
	public function mgnt_verso_sca_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/mgnt_verso_ob_sc_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_verso_model->get_agent_id(9,19,67);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["get_verso_ob_sca_feedback"] = $this->Qa_verso_model->view_verso_ob_sc_feedback($id);
			
			$data["obsca_id"]=$id;
			
			$data["row1"] = $this->Qa_verso_model->view_agent_verso_ob_sca_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_verso_model->view_mgnt_verso_ob_sca_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('obsca_id'))
			{
				$obsca_id=$this->input->post('obsca_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"agent_crm_id" => $this->input->post('agent_crm_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"site" => $this->input->post('site'),
					"question_code" => $this->input->post('question_code'),
					"call_status" => $this->input->post('call_status'),
					"reject_reason" => $this->input->post('reject_reason'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $obsca_id);
				$this->db->update('qa_verso_ob_sca_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $obsca_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_verso_ob_sca_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $obsca_id);
					$this->db->update('qa_verso_ob_sca_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_verso/qa_verso_ob_sc_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

/////////////////VERSO Inbound Agent part//////////////////////////	

	public function agent_verso_ib_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_inbound/agent_verso_ib_feedback.php";
			$data["agentUrl"] = "qa_verso/agent_verso_ib_feedback";
			
			
			$qSql="Select count(id) as value from qa_verso_ib_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_ib_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_verso_ib_feedback where id  not in (select fd_id from qa_verso_ib_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_ib_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
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

				$data["get_agent_review_list"] = $this->Qa_verso_model->verso_ib_agent_rvw($field_array);
					
			}else{	
				$data["get_agent_review_list"] = $this->Qa_verso_model->verso_ib_agent_not_rvw($current_user);		
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_verso_ib_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_inbound/agent_verso_ib_feedback_rvw.php";
			$data["agentUrl"] = "qa_verso/agent_verso_ib_feedback";
			
			$data["get_verso_ib_feedback"] = $this->Qa_verso_model->view_verso_ib_feedback($id);
			
			$data["vib_id"]=$id;
			
			$data["row1"] = $this->Qa_verso_model->view_agent_verso_ib_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_verso_model->view_mgnt_verso_ib_rvw($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				
				$field_array=array(
					"fd_id" => $fd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_verso_ib_agent_rvw',$field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_verso_ib_agent_rvw',$field_array);
				}
				redirect('Qa_verso/agent_verso_ib_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}
	
////////////////////////VERSO Outbound/////////////////////////	

	public function agent_verso_ob_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/agent_verso_ob_feedback.php";
			$data["agentUrl"] = "qa_verso/agent_verso_ob_feedback";
			
			
			$qSql="Select count(id) as value from qa_verso_ob_fca_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_fca_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_verso_ob_fca_feedback where id  not in (select fd_id from qa_verso_ob_fca_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_fca_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		//////////////	
			$qSql="Select count(id) as value from qa_verso_ob_sca_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_sca_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_verso_ob_sca_feedback where id  not in (select fd_id from qa_verso_ob_sca_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_sca_yet_rvw"] =  $this->Common_model->get_single_value($qSql); 
				
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

				$data["get_agent_fca_review_list"] = $this->Qa_verso_model->verso_ob_fca_agent_rvw($field_array);
				$data["get_agent_sca_review_list"] = $this->Qa_verso_model->verso_ob_sca_agent_rvw($field_array);
					
			}else{	
				$data["get_agent_fca_review_list"] = $this->Qa_verso_model->verso_ob_fca_agent_not_rvw($current_user);
				$data["get_agent_sca_review_list"] = $this->Qa_verso_model->verso_ob_sca_agent_not_rvw($current_user);
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
/*--------------VERSO Agent Full Call Audit--------------*/	
	public function agent_verso_ob_fca_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/agent_verso_ob_fc_feedback_rvw.php";
			$data["agentUrl"] = "qa_verso/agent_verso_ob_feedback";
			
			$data["get_verso_ob_fca_feedback"] = $this->Qa_verso_model->view_verso_ob_fc_feedback($id);
			
			$data["obfca_id"]=$id;
			
			$data["row1"] = $this->Qa_verso_model->view_agent_verso_ob_fca_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_verso_model->view_mgnt_verso_ob_fca_rvw($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				
				$field_array=array(
					"fd_id" => $fd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_verso_ob_fca_agent_rvw',$field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_verso_ob_fca_agent_rvw',$field_array);
				}
				redirect('Qa_verso/agent_verso_ob_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}
	
/*--------------VERSO Agent Special Call Audit--------------*/	
	public function agent_verso_ob_sca_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_verso/verso_outbound/agent_verso_ob_sc_feedback_rvw.php";
			$data["agentUrl"] = "qa_verso/agent_verso_ob_feedback";
			
			$data["get_verso_ob_sca_feedback"] = $this->Qa_verso_model->view_verso_ob_sc_feedback($id);
			
			$data["obsca_id"]=$id;
			
			$data["row1"] = $this->Qa_verso_model->view_agent_verso_ob_sca_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_verso_model->view_mgnt_verso_ob_sca_rvw($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				
				$field_array=array(
					"fd_id" => $fd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_verso_ob_sca_agent_rvw',$field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_verso_ob_sca_agent_rvw',$field_array);
				}
				redirect('Qa_verso/agent_verso_ob_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}	
	
	
	
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "SELECT * from (Select id, assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name, fusion_id, office_id, get_process_names(id) as process_name FROM signin m where id = '$aid') xx Left Join (Select user_id, phone from info_personal) yy On (xx.id=yy.user_id) ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA VERSO REPORT ////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_verso_report(){
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
			$data["content_template"] = "qa_verso/qa_verso_report.php";
			
			
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
			
			
			
			$data["qa_verso_list"] = array();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						//"office_id" => $office_id,
						"process_id" => $pValue,
						"current_user" => $current_user
					);
					
				
				if($pValue=='Customer Care'){
					
					$fullAray = $this->Qa_verso_model->qa_verso_report_model($field_array);
					$data["qa_verso_list"] = $fullAray;
					$this->create_qa_verso_inbound_CSV($fullAray);	
					$dn_link = base_url()."qa_verso/download_qa_verso_inbound_CSV";
				
				}else if($pValue=='Full Call'){
					
					$fullAray = $this->Qa_verso_model->qa_verso_report_model($field_array);
					$data["qa_verso_list"] = $fullAray;
					$this->create_qa_verso_ob_fca_CSV($fullAray);	
					$dn_link = base_url()."qa_verso/download_qa_verso_ob_fca_CSV";
				
				}else{
					
					$fullAray = $this->Qa_verso_model->qa_verso_report_model($field_array);
					$data["qa_verso_list"] = $fullAray;
					$this->create_qa_verso_ob_sca_CSV($fullAray);	
					$dn_link = base_url()."qa_verso/download_qa_verso_ob_sca_CSV";
				
				}
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}

/*------VERSO Customer Care Audit(Inbound)-------*/
	public function download_qa_verso_inbound_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Verso Customer Care Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_verso_inbound_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Phone", "Campaign", "Audit Type", "VOC", "Agent CRM ID", "Site", "Call ID", "Call Date", "Call Opening", "Apology/ Empathy", "Enthusiasm", "Politeness and Courtesy", "Fluency", "Complete & Accurate Resolution", "Correct CRM Entry/CRM Accuracy", "Closing", "Active Listening", "Hold Protocol", "Effective Probing", "Overall Score", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Management Review Date", "Management Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['call_opening']==10) $call_opening='Yes';
			else if($user['call_opening']==10.1) $call_opening='N/A';
			else $call_opening='No';
			
			if($user['apology_empathy']==10) $apology_empathy='Yes';
			else if($user['apology_empathy']==10.1) $apology_empathy='N/A';
			else $apology_empathy='No';
			
			if($user['enthusiasm']==10) $enthusiasm='Yes';
			else if($user['enthusiasm']==10.1) $enthusiasm='N/A';
			else $enthusiasm='No';
			
			if($user['politeness_courtesy']==10) $politeness_courtesy='Yes';
			else if($user['politeness_courtesy']==10.1) $politeness_courtesy='N/A';
			else $politeness_courtesy='No';
			
			if($user['fluency']==10) $fluency='Yes';
			else if($user['fluency']==10.1) $fluency='N/A';
			else $fluency='No';
			
			if($user['accurate_resolution']==10) $accurate_resolution='Yes';
			else if($user['accurate_resolution']==10.1) $accurate_resolution='N/A';
			else $accurate_resolution='No';
			
			if($user['crm_accuracy']==10) $crm_accuracy='Yes';
			else if($user['crm_accuracy ']==10.1) $crm_accuracy='N/A';
			else $crm_accuracy='No';
			
			if($user['closing']==10) $closing='Yes';
			else if($user['closing']==10.1) $closing='N/A';
			else $closing='No';
			
			if($user['active_listening']==10) $active_listening='Yes';
			else if($user['active_listening']==10.1) $active_listening='N/A';
			else $active_listening='No';
			
			if($user['hold_protocol']==5) $hold_protocol='Yes';
			else if($user['hold_protocol']==5.1) $hold_protocol='N/A';
			else $hold_protocol='No';
			
			if($user['effective_probing']==5) $effective_probing='Yes';
			else if($user['effective_probing']==5.1) $effective_probing='N/A';
			else $effective_probing='No';
			
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['campaign'].'",'; 
			$row .= '"'.$user['audit_type'].'",'; 
			$row .= '"'.$user['voc'].'",'; 
			$row .= '"'.$user['agent_crm_id'].'",'; 
			$row .= '"'.$user['site'].'",'; 
			$row .= '"'.$user['call_id'].'",'; 
			$row .= '"'.$user['call_date'].'",'; 
			$row .= '"'.$call_opening.'",'; 
			$row .= '"'.$apology_empathy.'",'; 
			$row .= '"'.$enthusiasm.'",'; 
			$row .= '"'.$politeness_courtesy.'",'; 
			$row .= '"'.$fluency.'",'; 
			$row .= '"'.$accurate_resolution.'",'; 
			$row .= '"'.$crm_accuracy.'",'; 
			$row .= '"'.$closing.'",'; 
			$row .= '"'.$active_listening.'",'; 
			$row .= '"'.$hold_protocol.'",'; 
			$row .= '"'.$effective_probing.'",'; 
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	

/*------VERSO Full Call Audit(Outbound)-------*/
	public function download_qa_verso_ob_fca_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Verso Full Call Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_verso_ob_fca_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Agent CRM ID", "Phone", "Campaign", "Audit Type", "VOC", "Site", "Revenue", "Tag Error", "Probing Error", "Other Error", "Fallout", "Fallout Comment", "Overall Score", "ZTP", "Call Status", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Management Review Date", "Management Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['tag_error']==40) $tag_error='No';
			else $call_opening='Yes';
			
			if($user['probing_error']==40) $probing_error='No';
			else $probing_error='Yes';
			
			if($user['other_error']==10) $other_error='No';
			else $other_error='Yes';
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['agent_crm_id'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['campaign'].'",'; 
			$row .= '"'.$user['audit_type'].'",'; 
			$row .= '"'.$user['voc'].'",'; 
			$row .= '"'.$user['site'].'",'; 
			$row .= '"'.$user['revenue'].'",'; 
			$row .= '"'.$tag_error.'",'; 
			$row .= '"'.$probing_error.'",'; 
			$row .= '"'.$other_error.'",'; 
			$row .= '"'.$user['fallout'].'",'; 
			$row .= '"'.$user['fallout_comment'].'",'; 
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'.$user['ztp'].'",'; 
			$row .= '"'.$user['call_status'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}

/*------VERSO Special Call Audit(Outbound)-------*/
	public function download_qa_verso_ob_sca_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Verso Special Call Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_verso_ob_sca_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Agent CRM ID", "Phone", "Campaign", "Audit Type", "VOC", "Site", "Question Code", "Call Status", "Reject Reason", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Management Review Date", "Management Comment");
		
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
			$row .= '"'.$user['agent_crm_id'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['campaign'].'",'; 
			$row .= '"'.$user['audit_type'].'",'; 
			$row .= '"'.$user['voc'].'",'; 
			$row .= '"'.$user['site'].'",'; 
			$row .= '"'.$user['question_code'].'",';
			$row .= '"'.$user['call_status'].'",'; 
			$row .= '"'.$user['reject_reason'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	
	
	 
	 
 }