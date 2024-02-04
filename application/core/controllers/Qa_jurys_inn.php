<?php 

 class Qa_jurys_inn extends CI_Controller{
	
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
	
	
////////////////////// Revised CIS /////////////////////////	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/qa_jurys_inn_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$reservation_no = $this->input->get('reservation_no');
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
			if($reservation_no !="")	$cond .=" and reservation_no like '%$reservation_no%'";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurys_inn_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";	
			$data["qa_jurys_inn_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["reservation_no"] = $reservation_no;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"reservation_no" => $this->input->post('reservation_no'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"pass_count" => $this->input->post('pass_count'),
					"fail_count" => $this->input->post('fail_count'),
					"na_count" => $this->input->post('na_count'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),
					"greet_customer" => $this->input->post('greet_customer'),
					"greet_name" => $this->input->post('greet_name'),
					"greet_conversation" => $this->input->post('greet_conversation'),
					"greet_question" => $this->input->post('greet_question'),
					"greet_utilise" => $this->input->post('greet_utilise'),
					"qualifi_determine" => $this->input->post('qualifi_determine'),
					"qualifi_reconfirm" => $this->input->post('qualifi_reconfirm'),
					"qualifi_customer" => $this->input->post('qualifi_customer'),
					"qualifi_guest" => $this->input->post('qualifi_guest'),
					"recognise_agent" => $this->input->post('recognise_agent'),
					"recognise_caller" => $this->input->post('recognise_caller'),
					"recognise_gdpr" => $this->input->post('recognise_gdpr'),
					"recomend_guest" => $this->input->post('recomend_guest'),
					"recomend_benefit" => $this->input->post('recomend_benefit'),
					"recomend_offer" => $this->input->post('recomend_offer'),
					"recomend_upsell" => $this->input->post('recomend_upsell'),
					"recomend_room" => $this->input->post('recomend_room'),
					"overcome_positive" => $this->input->post('overcome_positive'),
					"overcome_terms" => $this->input->post('overcome_terms'),
					"sale_business" => $this->input->post('sale_business'),
					"closure_booking" => $this->input->post('closure_booking'),
					"closure_email" => $this->input->post('closure_email'),
					"closure_advise" => $this->input->post('closure_advise'),
					"closure_ask" => $this->input->post('closure_ask'),
					"ss_avoid" => $this->input->post('ss_avoid'),
					"ss_display" => $this->input->post('ss_display'),
					"ss_volunteer" => $this->input->post('ss_volunteer'),
					"ss_sound" => $this->input->post('ss_sound'),
					"ss_refrain" => $this->input->post('ss_refrain'),
					"ss_welcome" => $this->input->post('ss_welcome'),
					"ss_question" => $this->input->post('ss_question'),
					"ss_demonstrate" => $this->input->post('ss_demonstrate'),
					"greet1_comm" => $this->input->post('greet1_comm'),
					"greet2_comm" => $this->input->post('greet2_comm'),
					"greet3_comm" => $this->input->post('greet3_comm'),
					"greet4_comm" => $this->input->post('greet4_comm'),
					"greet5_comm" => $this->input->post('greet5_comm'),
					"qualifi1_comm" => $this->input->post('qualifi1_comm'),
					"qualifi2_comm" => $this->input->post('qualifi2_comm'),
					"qualifi3_comm" => $this->input->post('qualifi3_comm'),
					"qualifi4_comm" => $this->input->post('qualifi4_comm'),
					"recognise1_comm" => $this->input->post('recognise1_comm'),
					"recognise2_comm" => $this->input->post('recognise2_comm'),
					"recognise3_comm" => $this->input->post('recognise3_comm'),
					"recomend1_comm" => $this->input->post('recomend1_comm'),
					"recomend2_comm" => $this->input->post('recomend2_comm'),
					"recomend3_comm" => $this->input->post('recomend3_comm'),
					"recomend4_comm" => $this->input->post('recomend4_comm'),
					"recomend5_comm" => $this->input->post('recomend5_comm'),
					"overcome1_comm" => $this->input->post('overcome1_comm'),
					"overcome2_comm" => $this->input->post('overcome2_comm'),
					"sale1_comm" => $this->input->post('sale1_comm'),
					"closure1_comm" => $this->input->post('closure1_comm'),
					"closure2_comm" => $this->input->post('closure2_comm'),
					"closure3_comm" => $this->input->post('closure3_comm'),
					"closure4_comm" => $this->input->post('closure4_comm'),
					"ss1_comm" => $this->input->post('ss1_comm'),
					"ss2_comm" => $this->input->post('ss2_comm'),
					"ss3_comm" => $this->input->post('ss3_comm'),
					"ss4_comm" => $this->input->post('ss4_comm'),
					"ss5_comm" => $this->input->post('ss5_comm'),
					"ss6_comm" => $this->input->post('ss6_comm'),
					"ss7_comm" => $this->input->post('ss7_comm'),
					"ss8_comm" => $this->input->post('ss8_comm'),
					"follow_SOP" => $this->input->post('follow_SOP'),
					"closure5_comm" => $this->input->post('closure5_comm'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_jurys_inn_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_jurys_inn_feedback',$field_array1);
			///////////		
				redirect('Qa_jurys_inn');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_jurys_inn_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/mgnt_jurys_inn_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurys_inn_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["jurys_inn_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"reservation_no" => $this->input->post('reservation_no'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"pass_count" => $this->input->post('pass_count'),
					"fail_count" => $this->input->post('fail_count'),
					"na_count" => $this->input->post('na_count'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),
					"greet_customer" => $this->input->post('greet_customer'),
					"greet_name" => $this->input->post('greet_name'),
					"greet_conversation" => $this->input->post('greet_conversation'),
					"greet_question" => $this->input->post('greet_question'),
					"greet_utilise" => $this->input->post('greet_utilise'),
					"qualifi_determine" => $this->input->post('qualifi_determine'),
					"qualifi_reconfirm" => $this->input->post('qualifi_reconfirm'),
					"qualifi_customer" => $this->input->post('qualifi_customer'),
					"qualifi_guest" => $this->input->post('qualifi_guest'),
					"recognise_agent" => $this->input->post('recognise_agent'),
					"recognise_caller" => $this->input->post('recognise_caller'),
					"recognise_gdpr" => $this->input->post('recognise_gdpr'),
					"recomend_guest" => $this->input->post('recomend_guest'),
					"recomend_benefit" => $this->input->post('recomend_benefit'),
					"recomend_offer" => $this->input->post('recomend_offer'),
					"recomend_upsell" => $this->input->post('recomend_upsell'),
					"recomend_room" => $this->input->post('recomend_room'),
					"overcome_positive" => $this->input->post('overcome_positive'),
					"overcome_terms" => $this->input->post('overcome_terms'),
					"sale_business" => $this->input->post('sale_business'),
					"closure_booking" => $this->input->post('closure_booking'),
					"closure_email" => $this->input->post('closure_email'),
					"closure_advise" => $this->input->post('closure_advise'),
					"closure_ask" => $this->input->post('closure_ask'),
					"ss_avoid" => $this->input->post('ss_avoid'),
					"ss_display" => $this->input->post('ss_display'),
					"ss_volunteer" => $this->input->post('ss_volunteer'),
					"ss_sound" => $this->input->post('ss_sound'),
					"ss_refrain" => $this->input->post('ss_refrain'),
					"ss_welcome" => $this->input->post('ss_welcome'),
					"ss_question" => $this->input->post('ss_question'),
					"ss_demonstrate" => $this->input->post('ss_demonstrate'),
					"greet1_comm" => $this->input->post('greet1_comm'),
					"greet2_comm" => $this->input->post('greet2_comm'),
					"greet3_comm" => $this->input->post('greet3_comm'),
					"greet4_comm" => $this->input->post('greet4_comm'),
					"greet5_comm" => $this->input->post('greet5_comm'),
					"qualifi1_comm" => $this->input->post('qualifi1_comm'),
					"qualifi2_comm" => $this->input->post('qualifi2_comm'),
					"qualifi3_comm" => $this->input->post('qualifi3_comm'),
					"qualifi4_comm" => $this->input->post('qualifi4_comm'),
					"recognise1_comm" => $this->input->post('recognise1_comm'),
					"recognise2_comm" => $this->input->post('recognise2_comm'),
					"recognise3_comm" => $this->input->post('recognise3_comm'),
					"recomend1_comm" => $this->input->post('recomend1_comm'),
					"recomend2_comm" => $this->input->post('recomend2_comm'),
					"recomend3_comm" => $this->input->post('recomend3_comm'),
					"recomend4_comm" => $this->input->post('recomend4_comm'),
					"recomend5_comm" => $this->input->post('recomend5_comm'),
					"overcome1_comm" => $this->input->post('overcome1_comm'),
					"overcome2_comm" => $this->input->post('overcome2_comm'),
					"sale1_comm" => $this->input->post('sale1_comm'),
					"closure1_comm" => $this->input->post('closure1_comm'),
					"closure2_comm" => $this->input->post('closure2_comm'),
					"closure3_comm" => $this->input->post('closure3_comm'),
					"closure4_comm" => $this->input->post('closure4_comm'),
					"ss1_comm" => $this->input->post('ss1_comm'),
					"ss2_comm" => $this->input->post('ss2_comm'),
					"ss3_comm" => $this->input->post('ss3_comm'),
					"ss4_comm" => $this->input->post('ss4_comm'),
					"ss5_comm" => $this->input->post('ss5_comm'),
					"ss6_comm" => $this->input->post('ss6_comm'),
					"ss7_comm" => $this->input->post('ss7_comm'),
					"ss8_comm" => $this->input->post('ss8_comm'),
					"follow_SOP" => $this->input->post('follow_SOP'),
					"closure5_comm" => $this->input->post('closure5_comm'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/');
					$field_array['attach_file'] = implode(',',$a);
				}
					
				$this->db->where('id', $pnid);
				$this->db->update('qa_jurys_inn_feedback',$field_array);
				
			////////////	
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_jurys_inn_feedback',$field_array1);
			///////////	
				redirect('Qa_jurys_inn');
				$data["array"] = $a;
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////////////////////////////////////////////	
////////////////////// Revised CIS Email/////////////////////////	
	public function jurysinn_email(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/qa_jurysinn_email_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_jurysinn_email_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_email_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/add_email_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"ref_id" => $this->input->post('ref_id'),
					"call_date" => $this->input->post('call_date'),
					"query_type" => $this->input->post('query_type'),
					"query_sub_type" => $this->input->post('query_sub_type'),
					"asmnt_type" => $this->input->post('asmnt_type'),
					"tran_status" => $this->input->post('tran_status'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentuseopening" => $this->input->post('agentuseopening'),
					"agentuseguestname" => $this->input->post('agentuseguestname'),
					"agentusetemplate" => $this->input->post('agentusetemplate'),
					"emailformatedcorrectly" => $this->input->post('emailformatedcorrectly'),
					"agentusesignature" => $this->input->post('agentusesignature'),
					"agentofferrevenue" => $this->input->post('agentofferrevenue'),
					"agentcloseemail" => $this->input->post('agentcloseemail'),
					"agentuseinformation" => $this->input->post('agentuseinformation'),
					"agentreconfirmterms" => $this->input->post('agentreconfirmterms'),
					"agentstateguesthelp" => $this->input->post('agentstateguesthelp'),
					"agentofferalternative" => $this->input->post('agentofferalternative'),
					"agentanswerguestquestion" => $this->input->post('agentanswerguestquestion'),
					"agentamendedsubjectline" => $this->input->post('agentamendedsubjectline'),
					"agentcheckprefererate" => $this->input->post('agentcheckprefererate'),
					"agentsendemailcluster" => $this->input->post('agentsendemailcluster'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/ji_email/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_jurysinn_email_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_jurysinn_email_feedback',$field_array1);
			///////////		
				redirect('Qa_jurys_inn/jurysinn_email');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_jurysinn_email_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/mgnt_jurysinn_email_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_email_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["jurysinn_email_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"ref_id" => $this->input->post('ref_id'),
					"call_date" => $this->input->post('call_date'),
					"query_type" => $this->input->post('query_type'),
					"query_sub_type" => $this->input->post('query_sub_type'),
					"asmnt_type" => $this->input->post('asmnt_type'),
					"tran_status" => $this->input->post('tran_status'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentuseopening" => $this->input->post('agentuseopening'),
					"agentuseguestname" => $this->input->post('agentuseguestname'),
					"agentusetemplate" => $this->input->post('agentusetemplate'),
					"emailformatedcorrectly" => $this->input->post('emailformatedcorrectly'),
					"agentusesignature" => $this->input->post('agentusesignature'),
					"agentofferrevenue" => $this->input->post('agentofferrevenue'),
					"agentcloseemail" => $this->input->post('agentcloseemail'),
					"agentuseinformation" => $this->input->post('agentuseinformation'),
					"agentreconfirmterms" => $this->input->post('agentreconfirmterms'),
					"agentstateguesthelp" => $this->input->post('agentstateguesthelp'),
					"agentofferalternative" => $this->input->post('agentofferalternative'),
					"agentanswerguestquestion" => $this->input->post('agentanswerguestquestion'),
					"agentamendedsubjectline" => $this->input->post('agentamendedsubjectline'),
					"agentcheckprefererate" => $this->input->post('agentcheckprefererate'),
					"agentsendemailcluster" => $this->input->post('agentsendemailcluster'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/ji_email/');
					$field_array['attach_file'] = implode(',',$a);
				}
					
				$this->db->where('id', $pnid);
				$this->db->update('qa_jurysinn_email_feedback',$field_array);
				
			////////////	
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_jurysinn_email_feedback',$field_array1);
			///////////	
				redirect('Qa_jurys_inn/jurysinn_email');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////////////////////////////////////////////	
/////////////////////////// M&E CIS /////////////////////////////	
	public function jurysinn_ME_cis(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/qa_jurysinn_me_cis_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_cis_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["me_cis_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_ME_cis_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/add_me_cis_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greetcustomerapprox" => $this->input->post('greetcustomerapprox'),
					"agentoffername" => $this->input->post('agentoffername'),
					"ascertaincustomername" => $this->input->post('ascertaincustomername'),
					"clarifycallerfromcompany" => $this->input->post('clarifycallerfromcompany'),
					"takedowncallercontact" => $this->input->post('takedowncallercontact'),
					"callerheardthehotel" => $this->input->post('callerheardthehotel'),
					"adoptOpenapproach" => $this->input->post('adoptOpenapproach'),
					"establishedEventType" => $this->input->post('establishedEventType'),
					"callerRequestLocation" => $this->input->post('callerRequestLocation'),
					"callerMeetingtimedate" => $this->input->post('callerMeetingtimedate'),
					"clearlydiscussAVCatering" => $this->input->post('clearlydiscussAVCatering'),
					"determineaccomodationrequired" => $this->input->post('determineaccomodationrequired'),
					"reconfirmdelegatenumber" => $this->input->post('reconfirmdelegatenumber'),
					"determineagencyspecificprice" => $this->input->post('determineagencyspecificprice'),
					"callerquotedcompetetion" => $this->input->post('callerquotedcompetetion'),
					"establishchoiceofVenue" => $this->input->post('establishchoiceofVenue'),
					"promptedbythecaller" => $this->input->post('promptedbythecaller'),
					"keypackagefeatures" => $this->input->post('keypackagefeatures'),
					"offertoplacemeeting" => $this->input->post('offertoplacemeeting'),
					"offeralternatepositively" => $this->input->post('offeralternatepositively'),
					"agentaskmeetingrequest" => $this->input->post('agentaskmeetingrequest'),
					"agentclosetheCall" => $this->input->post('agentclosetheCall'),
					"reconfirmallbookingdetails" => $this->input->post('reconfirmallbookingdetails'),
					"offersendproposalviaEmail" => $this->input->post('offersendproposalviaEmail'),
					"avoidsilencesduringCall" => $this->input->post('avoidsilencesduringCall'),
					"displayprofessionalcall" => $this->input->post('displayprofessionalcall'),
					"soundclearthroughCall" => $this->input->post('soundclearthroughCall'),
					"soundFriendlyPoliteWelcome" => $this->input->post('soundFriendlyPoliteWelcome'),
					"useeffectivequestionSkills" => $this->input->post('useeffectivequestionSkills'),
					"demonstrateactivelistening" => $this->input->post('demonstrateactivelistening'),
					"callercompleteCCCSurvey" => $this->input->post('callercompleteCCCSurvey'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/me_cis_email/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_jurysinn_me_cis_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_jurysinn_me_cis_feedback',$field_array1);
			///////////		
				redirect('Qa_jurys_inn/jurysinn_ME_cis');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_jurysinn_me_cis_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/mgnt_jurysinn_me_cis_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_cis_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["me_cis_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greetcustomerapprox" => $this->input->post('greetcustomerapprox'),
					"agentoffername" => $this->input->post('agentoffername'),
					"ascertaincustomername" => $this->input->post('ascertaincustomername'),
					"clarifycallerfromcompany" => $this->input->post('clarifycallerfromcompany'),
					"takedowncallercontact" => $this->input->post('takedowncallercontact'),
					"callerheardthehotel" => $this->input->post('callerheardthehotel'),
					"adoptOpenapproach" => $this->input->post('adoptOpenapproach'),
					"establishedEventType" => $this->input->post('establishedEventType'),
					"callerRequestLocation" => $this->input->post('callerRequestLocation'),
					"callerMeetingtimedate" => $this->input->post('callerMeetingtimedate'),
					"clearlydiscussAVCatering" => $this->input->post('clearlydiscussAVCatering'),
					"determineaccomodationrequired" => $this->input->post('determineaccomodationrequired'),
					"reconfirmdelegatenumber" => $this->input->post('reconfirmdelegatenumber'),
					"determineagencyspecificprice" => $this->input->post('determineagencyspecificprice'),
					"callerquotedcompetetion" => $this->input->post('callerquotedcompetetion'),
					"establishchoiceofVenue" => $this->input->post('establishchoiceofVenue'),
					"promptedbythecaller" => $this->input->post('promptedbythecaller'),
					"keypackagefeatures" => $this->input->post('keypackagefeatures'),
					"offertoplacemeeting" => $this->input->post('offertoplacemeeting'),
					"offeralternatepositively" => $this->input->post('offeralternatepositively'),
					"agentaskmeetingrequest" => $this->input->post('agentaskmeetingrequest'),
					"agentclosetheCall" => $this->input->post('agentclosetheCall'),
					"reconfirmallbookingdetails" => $this->input->post('reconfirmallbookingdetails'),
					"offersendproposalviaEmail" => $this->input->post('offersendproposalviaEmail'),
					"avoidsilencesduringCall" => $this->input->post('avoidsilencesduringCall'),
					"displayprofessionalcall" => $this->input->post('displayprofessionalcall'),
					"soundclearthroughCall" => $this->input->post('soundclearthroughCall'),
					"soundFriendlyPoliteWelcome" => $this->input->post('soundFriendlyPoliteWelcome'),
					"useeffectivequestionSkills" => $this->input->post('useeffectivequestionSkills'),
					"demonstrateactivelistening" => $this->input->post('demonstrateactivelistening'),
					"callercompleteCCCSurvey" => $this->input->post('callercompleteCCCSurvey'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/me_cis_email/');
					$field_array['attach_file'] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_jurysinn_me_cis_feedback',$field_array);
				
			////////////	
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_jurysinn_me_cis_feedback',$field_array1);
			///////////	
				redirect('Qa_jurys_inn/jurysinn_ME_cis');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}	

/////////////////////////Agent part/////////////////////////////////	

	public function agent_jurys_inn_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/agent_jurys_inn_feedback.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";
			$page="cis";
			
			$qSql="Select count(id) as value from qa_jurys_inn_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_jurys_inn_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		/////////////////////////
			$qSql="Select count(id) as value from qa_jurysinn_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_email_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_jurysinn_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_email_rvw"] =  $this->Common_model->get_single_value($qSql);
		/////////////////////////	
			$qSql="Select count(id) as value from qa_jurysinn_me_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_me_cis_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_jurysinn_me_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_me_cis_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_".$page."_contracts_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_sa"] =  $this->Common_model->get_single_value($qSql);
				
			$qSql="Select count(id) as value from qa_".$page."_contracts_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw_sa"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_".$page."_proposal_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_ta"] =  $this->Common_model->get_single_value($qSql);
				
			$qSql="Select count(id) as value from qa_".$page."_proposal_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw_ta"] =  $this->Common_model->get_single_value($qSql);
			
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurys_inn_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			//////////	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_email_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_email_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			//////////	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_cis_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_me_cis_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_contracts_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_contracts_agent_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_proposal_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_proposal_agent_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurys_inn_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			///////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_email_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			///////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_me_cis_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_contracts_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_contracts_agent_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_proposal_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_proposal_agent_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_jurys_inn_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/agent_jurys_inn_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurys_inn_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["jurys_inn_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_jurys_inn_feedback',$field_array1);
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_jurysinn_email_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/agent_jurysinn_email_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_email_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["jurysinn_email_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_jurysinn_email_feedback',$field_array1);	
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_jurysinn_me_cis_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/agent_jurysinn_me_cis_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_cis_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["me_cis_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_jurysinn_me_cis_feedback',$field_array1);	
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


public function jurys_inn_meCis(){
		if(check_logged_in())
		{
			$page="cis";
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/qa_".$page."_feedback.php";
			//$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$page."_contracts_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["cis_contracts_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$page."_proposal_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["cis_proposal_new_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


public function process($parm="",$formparam="",$table=""){

		if ($parm=="add") {
			$this->add_process($formparam,$table);
		}elseif ($parm=="mgnt_rvw") {
			$this->mgnt_process_rvw($formparam,$table);
		}elseif($parm=="agnt_feedback"){
			$this->agent_process_rvw($formparam,$table);
		}

	}


public function add_process($stratAuditTime,$table){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page="cis";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/".$table."/add_".$table.".php";
			//$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$table;
			$data['arrayField']=$this->arrayField();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data["stratAuditTime"]=$stratAuditTime;
			$curDateTime=CurrMySqlDate();
			$a = array();

			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->mt_upload_files_two($_FILES['attach_file'],$table);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_'.$table.'_feedback',$field_array);
				redirect('qa_jurys_inn/jurys_inn_meCis');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}


public function mgnt_process_rvw($id,$table){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page="cis";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/".$table."/mgnt_".$table."_rvw.php";
			//$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$table;
			$data['arrayField']=$this->arrayField();

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$table."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$table."_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				$file_str="";

				

				$field_array=$this->input->post('data');
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$table.'_feedback',$field_array);
				
			////////////	
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$table.'_feedback',$field_array1);
				// if (!empty($_FILES['attach_file'])) {					
				// 	$a = $this->mt_upload_files_two($_FILES['attach_file'],$table);
				// 	$field_array2=array("attach_file" => implode(',',$a));
				// 	// $this->db->where('id', $pnid);
				// 	$this->db->update('qa_'.$table.'_feedback',$field_array2);
				// }
			///////////	
				redirect('qa_jurys_inn/jurys_inn_meCis');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


private function mt_upload_files_two($files,$table)
    {
        $config['upload_path'] = './qa_files/qa_jurys_inn/'.$table;
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
    }
	
public function arrayField(){
		return $arrayName = array('Yes','No','N/A' );
	}

	
public function agent_process_rvw($id,$table){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page="cis";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/".$table."/agent_".$table."_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$page;
			$data['arrayField']=$this->arrayField();
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_".$table."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";

			$data[$page."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$table.'_feedback',$field_array);
				
				redirect('qa_jurys_inn/agent_jurys_inn_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	} 

///////////////////////////////////////////////////////////////////////////////////// 
///////////////////////////////// QA jurys_inn REPORT ///////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_jurys_inn_report(){
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
			$data["content_template"] = "qa_jurys_inn/qa_jurys_inn_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$lob="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_jurys_inn_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$lob = $this->input->get('lob');
				
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
				
				if($lob=="cis"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurys_inn_feedback) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}else if($lob=="email_cis"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_email_feedback) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}else if($lob=="me_cis"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_me_cis_feedback) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_jurys_inn_list"] = $fullAray;
				$this->create_qa_jurys_inn_CSV($fullAray,$lob);	
				$dn_link = base_url()."qa_jurys_inn/download_qa_jurys_inn_CSV/".$lob;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['lob']=$lob;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_jurys_inn_CSV($lob)
	{
		if($lob=="cis"){
			$campaign="Reservation CIS";
		}else if($lob=="email_cis"){
			$campaign="Email Reservation CIS";
		}else if($lob=="me_cis"){
			$campaign="M&E CIS Reservation";
		}
		
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_jurys_inn_CSV($rr,$lob)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($lob=="cis"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "Reservation Number", "Audit Type", "VOC", "Overall Score", "Earned Score", "Possible Score", "Pass Count", "Fail Count", "N/A Count", "Customer Score", "Business Score", "Compliance Score", "Did the agent Greet the Customer appropriately?", "Comment", "Did the agent offer his/her name?", "Comment", "Did the agent ascertain the customer name and use conversationally?", "Comment", "Did the agent ask an Open Question?", "Comment", "Did the agent utilise all resources available?", "Comment", "Did the agent determine if the call was for business?", "Comment", "Did the agent reconfirm to caller when the customer wants to stay?", "Comment", "Did the agent reconfirm to caller where the customer wants to stay?", "Comment", "Did the agent ask and reconfirm the number of rooms and guests?", "Comment", "Did the agent determine if the guest has stayed with us before?", "Comment", "Did the agent take relevant caller and profile information", "Comment", "Did the agent conform to GDPR requirements during the call?", "Comment", "Did the agent determine if the guest was a Jurys Rewards member?", "Comment", "Did the agent recommend the benefits of the Jurys Rewards programme?", "Comment", "Did the agent offer to enrol the guest on Jurys Rewards?", "Comment", "Did the agent upsell the room type and offer the benefits?", "Comment", "Did the agent offer Room Only and Bed & Breakfast?", "Comment", "Did the agent offer alternates positively", "Comment", "Did the agent present terms and conditions positively at the time of quoting?", "Comment", "Did the agent ask for the business?", "Comment", "Did the agent ask if the caller wants to proceed with the booking?", "Comment", "Did the agent follow the correct SOP?", "Comment", "Did the agent offer to send a confirmation email?", "Comment", "Did the agent advise that directions and parking information?", "Comment", "Did the agent ask if there was anything else?", "Comment", "Did the agent avoid long silences and Long-hold during the call?", "Comment", "Did the agent display a professional manner throughout the call?", "Comment", "Did the agent pro-actively volunteer additional info throughout the call?", "Comment", "Did the agent sound clear and confident throughout the call?", "Comment", "Did the agent refrain from using jargon throughout the call?", "Comment", "Did the agent sound polite and welcoming?", "Comment", "Did the agent use effective questioning skills?", "Comment", "Did the agent demonstrate active listening?", "Comment", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($lob=="email_cis"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Email Date", "Reference ID", "Query Type", "Sub Query Type", "Assessment Type", "Transaction Status", "Audit Type", "VOC", "Overall Score", "Earned Score", "Possible Score", "Did the agent use an appropriate opening line at the beginning of the email?", "Did the agent use the guests name?", "Did the agent use the appropriate template? (If applicable)", "Was the email formatted correctly and consistently? (Same font and colour)", "Did the agent use their signature?", "Did the agent offer add on to maximise revenue? (Offer Breakfast and Superior Rooms)", "Did the agent close the email in a appropriate manner?", "Did the agent use all available information", "Did the agent reconfirm all details including terms and conditions?", "Did the agent state if there was anything else they could help the guest with?", "Did the agent offer any alternatives? (if applicable)", "Did the agent answer all the guests questions fully?", "Has the agent amended the subject line appropriately?", "Did the agent check if preferential rates were available? (If applicable)", "Did the agent send the email from the correct cluster?", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		}else if($lob=="me_cis"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Audit Type", "VOC", "Overall Score", "Earned Score", "Possible Score", "Did the agent Greet the Customer appropriately?", "Did the agent offer his/her name?", "Did the agent ascertain the customer name and use conversationally?", "Did the agent clarify if the caller is from a company or agency?", "Did the agent take down the callers contact details?", "Did the agent establish how the caller had heard of the hotel AND give an upbeat response?", "Did the agent adopt an open approach initially in order to establish the callers requirements?", "Did the agent establish the type purpose of the event?", "Did the agent confirm to the caller what location they are requesting?", "Did the agent confirm to caller dates days and times of the meeting?", "Were the following also clearly discussed?", "Did the agent determine if accommodation was required?", "Did the agent reconfirm delegate numbers & room layout?", "Did the agent determine if the company agency had a specific price range?", "Did the agent determine if the caller has been quoted by any competitors?", "Did the agent establish the most important factors in the choice of venue?", "Did the agent quote the rate without being prompted by the caller", "Were the key package features highlighted when the price was quoted?", "Did the agent offer to place the meeting space on hold?", "Did the agent offer alternates positively?", "Did the agent ask if there were any other meeting requests or if there was anything else?", "Did the agent close the call in an appropriate manner", "Did the agent reconfirm all booking details?", "Did the agent offer send a proposal via email?", "Did the agent avoid long silences during the call?", "Did the agent display a professional manner throughout the call?", "Did the agent sound clear and confident throughout the call?", "Did the agent sound friendly polite and welcoming?", "Did the agent use effective questioning skills?", "Did the agent demonstrate active listening?", "Did the agent ask the caller to complete the CCC Survey?", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($lob=="cis"){
		
			foreach($rr as $user)
			{	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['reservation_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['pass_count'].'",';
				$row .= '"'.$user['fail_count'].'",';
				$row .= '"'.$user['na_count'].'",';
				$row .= '"'.$user['customer_score'].'%'.'",';
				$row .= '"'.$user['business_score'].'%'.'",';
				$row .= '"'.$user['compliance_score'].'%'.'",';
				$row .= '"'.$user['greet_customer'].'",';
				$row .= '"'.$user['greet1_comm'].'",';
				$row .= '"'.$user['greet_name'].'",';
				$row .= '"'.$user['greet2_comm'].'",';
				$row .= '"'.$user['greet_conversation'].'",';
				$row .= '"'.$user['greet3_comm'].'",';
				$row .= '"'.$user['greet_question'].'",';
				$row .= '"'.$user['greet4_comm'].'",';
				$row .= '"'.$user['greet_utilise'].'",';
				$row .= '"'.$user['greet5_comm'].'",';
				$row .= '"'.$user['qualifi_determine'].'",';
				$row .= '"'.$user['qualifi1_comm'].'",';
				$row .= '"'.$user['qualifi_reconfirm'].'",';
				$row .= '"'.$user['qualifi2_comm'].'",';
				$row .= '"'.$user['qualifi_customer'].'",';
				$row .= '"'.$user['qualifi3_comm'].'",';
				$row .= '"'.$user['qualifi_guest'].'",';
				$row .= '"'.$user['qualifi4_comm'].'",';
				$row .= '"'.$user['recognise_agent'].'",';
				$row .= '"'.$user['recognise1_comm'].'",';
				$row .= '"'.$user['recognise_caller'].'",';
				$row .= '"'.$user['recognise2_comm'].'",';
				$row .= '"'.$user['recognise_gdpr'].'",';
				$row .= '"'.$user['recognise3_comm'].'",';
				$row .= '"'.$user['recomend_guest'].'",';
				$row .= '"'.$user['recomend1_comm'].'",';
				$row .= '"'.$user['recomend_benefit'].'",';
				$row .= '"'.$user['recomend2_comm'].'",';
				$row .= '"'.$user['recomend_offer'].'",';
				$row .= '"'.$user['recomend3_comm'].'",';
				$row .= '"'.$user['recomend_upsell'].'",';
				$row .= '"'.$user['recomend4_comm'].'",';
				$row .= '"'.$user['recomend_room'].'",';
				$row .= '"'.$user['recomend5_comm'].'",';
				$row .= '"'.$user['overcome_positive'].'",';
				$row .= '"'.$user['overcome1_comm'].'",';
				$row .= '"'.$user['overcome_terms'].'",';
				$row .= '"'.$user['overcome2_comm'].'",';
				$row .= '"'.$user['sale_business'].'",';
				$row .= '"'.$user['sale1_comm'].'",';
				$row .= '"'.$user['closure_booking'].'",';
				$row .= '"'.$user['closure1_comm'].'",';
				$row .= '"'.$user['follow_SOP'].'",';
				$row .= '"'.$user['closure5_comm'].'",';
				$row .= '"'.$user['closure_email'].'",';
				$row .= '"'.$user['closure2_comm'].'",';
				$row .= '"'.$user['closure_advise'].'",';
				$row .= '"'.$user['closure3_comm'].'",';
				$row .= '"'.$user['closure_ask'].'",';
				$row .= '"'.$user['closure4_comm'].'",';
				$row .= '"'.$user['ss_avoid'].'",';
				$row .= '"'.$user['ss1_comm'].'",';
				$row .= '"'.$user['ss_display'].'",';
				$row .= '"'.$user['ss2_comm'].'",';
				$row .= '"'.$user['ss_volunteer'].'",';
				$row .= '"'.$user['ss3_comm'].'",';
				$row .= '"'.$user['ss_sound'].'",';
				$row .= '"'.$user['ss4_comm'].'",';
				$row .= '"'.$user['ss_refrain'].'",';
				$row .= '"'.$user['ss5_comm'].'",';
				$row .= '"'.$user['ss_welcome'].'",';
				$row .= '"'.$user['ss6_comm'].'",';
				$row .= '"'.$user['ss_question'].'",';
				$row .= '"'.$user['ss7_comm'].'",';
				$row .= '"'.$user['ss_demonstrate'].'",';
				$row .= '"'.$user['ss8_comm'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
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
		
		}else if($lob=="email_cis"){
		
			foreach($rr as $user)
			{	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				$row = '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['ref_id'].'",';
				$row .= '"'.$user['query_type'].'",';
				$row .= '"'.$user['query_sub_type'].'",';
				$row .= '"'.$user['asmnt_type'].'",';
				$row .= '"'.$user['tran_status'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['agentuseopening'].'",';
				$row .= '"'.$user['agentuseguestname'].'",';
				$row .= '"'.$user['agentusetemplate'].'",';
				$row .= '"'.$user['emailformatedcorrectly'].'",';
				$row .= '"'.$user['agentusesignature'].'",';
				$row .= '"'.$user['agentofferrevenue'].'",';
				$row .= '"'.$user['agentcloseemail'].'",';
				$row .= '"'.$user['agentuseinformation'].'",';
				$row .= '"'.$user['agentreconfirmterms'].'",';
				$row .= '"'.$user['agentstateguesthelp'].'",';
				$row .= '"'.$user['agentofferalternative'].'",';
				$row .= '"'.$user['agentanswerguestquestion'].'",';
				$row .= '"'.$user['agentamendedsubjectline'].'",';
				$row .= '"'.$user['agentcheckprefererate'].'",';
				$row .= '"'.$user['agentsendemailcluster'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
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
		
		}else if($lob=="me_cis"){
		
			foreach($rr as $user)
			{	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				$row = '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['greetcustomerapprox'].'",';
				$row .= '"'.$user['agentoffername'].'",';
				$row .= '"'.$user['ascertaincustomername'].'",';
				$row .= '"'.$user['clarifycallerfromcompany'].'",';
				$row .= '"'.$user['takedowncallercontact'].'",';
				$row .= '"'.$user['callerheardthehotel'].'",';
				$row .= '"'.$user['adoptOpenapproach'].'",';
				$row .= '"'.$user['establishedEventType'].'",';
				$row .= '"'.$user['callerRequestLocation'].'",';
				$row .= '"'.$user['callerMeetingtimedate'].'",';
				$row .= '"'.$user['clearlydiscussAVCatering'].'",';
				$row .= '"'.$user['determineaccomodationrequired'].'",';
				$row .= '"'.$user['reconfirmdelegatenumber'].'",';
				$row .= '"'.$user['determineagencyspecificprice'].'",';
				$row .= '"'.$user['callerquotedcompetetion'].'",';
				$row .= '"'.$user['establishchoiceofVenue'].'",';
				$row .= '"'.$user['promptedbythecaller'].'",';
				$row .= '"'.$user['keypackagefeatures'].'",';
				$row .= '"'.$user['offertoplacemeeting'].'",';
				$row .= '"'.$user['offeralternatepositively'].'",';
				$row .= '"'.$user['agentaskmeetingrequest'].'",';
				$row .= '"'.$user['agentclosetheCall'].'",';
				$row .= '"'.$user['reconfirmallbookingdetails'].'",';
				$row .= '"'.$user['offersendproposalviaEmail'].'",';
				$row .= '"'.$user['avoidsilencesduringCall'].'",';
				$row .= '"'.$user['displayprofessionalcall'].'",';
				$row .= '"'.$user['soundclearthroughCall'].'",';
				$row .= '"'.$user['soundFriendlyPoliteWelcome'].'",';
				$row .= '"'.$user['useeffectivequestionSkills'].'",';
				$row .= '"'.$user['demonstrateactivelistening'].'",';
				$row .= '"'.$user['callercompleteCCCSurvey'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
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
	
	
 }