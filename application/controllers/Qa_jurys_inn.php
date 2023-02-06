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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
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
		////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_input_cis_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["cis_gds"] = $this->Common_model->get_query_result_array($qSql);
		////////////////
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
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
					"correct_reason" => $this->input->post('correct_reason'),
					"correct_reason_comm" => $this->input->post('correct_reason_comm'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime
				);
				/* echo "<pre>";
				print_r($field_array);
				echo "</pre>";
				echo die(); */
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
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
					"correct_reason" => $this->input->post('correct_reason'),
					"correct_reason_comm" => $this->input->post('correct_reason_comm'),
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
	/* public function jurysinn_email(){
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
	} */


	public function add_email_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/add_email_feedback.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"ref_id" => $this->input->post('ref_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
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
					//"agentGDPRconfirm" => $this->input->post('agentGDPRconfirm'),
					//"agentfollowSOPcorrect" => $this->input->post('agentfollowSOPcorrect'),
					"agentensurespelling" => $this->input->post('agentensurespelling'),
					"agnetselectcorrectproperty" => $this->input->post('agnetselectcorrectproperty'),
					"agentselectcorrectdate" => $this->input->post('agentselectcorrectdate'),
					"agentselectcorrectroombook" => $this->input->post('agentselectcorrectroombook'),
					"agentuseproperratecode" => $this->input->post('agentuseproperratecode'),
					"agentusepropergurantee" => $this->input->post('agentusepropergurantee'),
					"agentusecorrectpayment" => $this->input->post('agentusecorrectpayment'),
					"agentmadeduplicatereservation" => $this->input->post('agentmadeduplicatereservation'),
					"bookingmadeoverbusiness" => $this->input->post('bookingmadeoverbusiness'),
					"agentmarkemailcorrectly" => $this->input->post('agentmarkemailcorrectly'),
					"incorrectbookingchange" => $this->input->post('incorrectbookingchange'),
					"escalationagainstemail" => $this->input->post('escalationagainstemail'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					//"cmt10" => $this->input->post('cmt10'),
					//"cmt11" => $this->input->post('cmt11'),
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
					"cmt29" => $this->input->post('cmt29'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"audit_start_time" => $this->input->post('audit_start_time'),
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
				redirect('Qa_jurys_inn');
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
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
					//"agentGDPRconfirm" => $this->input->post('agentGDPRconfirm'),
					//"agentfollowSOPcorrect" => $this->input->post('agentfollowSOPcorrect'),
					"agentensurespelling" => $this->input->post('agentensurespelling'),
					"agnetselectcorrectproperty" => $this->input->post('agnetselectcorrectproperty'),
					"agentselectcorrectdate" => $this->input->post('agentselectcorrectdate'),
					"agentselectcorrectroombook" => $this->input->post('agentselectcorrectroombook'),
					"agentuseproperratecode" => $this->input->post('agentuseproperratecode'),
					"agentusepropergurantee" => $this->input->post('agentusepropergurantee'),
					"agentusecorrectpayment" => $this->input->post('agentusecorrectpayment'),
					"agentmadeduplicatereservation" => $this->input->post('agentmadeduplicatereservation'),
					"bookingmadeoverbusiness" => $this->input->post('bookingmadeoverbusiness'),
					"agentmarkemailcorrectly" => $this->input->post('agentmarkemailcorrectly'),
					"incorrectbookingchange" => $this->input->post('incorrectbookingchange'),
					"escalationagainstemail" => $this->input->post('escalationagainstemail'),
					"customer_score" => $this->input->post('customer_score'),
					"business_score" => $this->input->post('business_score'),
					"compliance_score" => $this->input->post('compliance_score'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					//"cmt10" => $this->input->post('cmt10'),
					//"cmt11" => $this->input->post('cmt11'),
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
					"cmt29" => $this->input->post('cmt29'),
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
				redirect('Qa_jurys_inn');
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
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
		//////////////////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cis_contracts_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["cis_contracts_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cis_proposal_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["cis_proposal_new_data"] = $this->Common_model->get_query_result_array($qSql);
			///////////////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_call_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["me_call_data"] = $this->Common_model->get_query_result_array($qSql);

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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
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
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
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

	public function add_edit_ME_call_feedback($mecall_id=null){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/add_edit_me_call_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php"; 
			$data['mecall_id']=$mecall_id;
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_jurysinn_me_call_feedback where id='$mecall_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["me_call_feedback"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($mecall_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_jurys_inn/me_call_email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_jurysinn_me_call_feedback',$field_array);
					
					//echo $this->db->last_query();
					//die();
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_jurysinn_me_call_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/me_call_email/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $mecall_id);
					$this->db->update('qa_jurysinn_me_call_feedback',$field_array1);
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
					$this->db->where('id', $mecall_id);
					$this->db->update('qa_jurysinn_me_call_feedback',$edit_array);

				}
				redirect('qa_jurys_inn/jurysinn_ME_cis');
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
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
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
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

	// public function mgnt_jurysinn_me_call_rvw($id){
	// 	if(check_logged_in()){
	// 		$current_user=get_user_id();
	// 		$user_office_id=get_user_office_id();

	// 		$data["aside_template"] = "qa/aside.php";
	// 		$data["content_template"] = "qa_jurys_inn/mgnt_jurysinn_me_call_rvw.php";
	// 		$data["content_js"] = "qa_metropolis_js.php";

	// 		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,124) and status=1  order by name";
	// 		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

	// 		$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
	// 		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

	// 		$qSql="SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_call_feedback where id='$id') xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
	// 		$data["me_call_feedback"] = $this->Common_model->get_query_row_array($qSql);

	// 		$data["pnid"]=$id;
	// 		$a = array();

	// 	///////Edit Part///////
	// 		if($this->input->post('pnid'))
	// 		{
	// 			$pnid=$this->input->post('pnid');
	// 			$curDateTime=CurrMySqlDate();
	// 			$log=get_logs();

	// 			$field_array = array(
	// 				"agent_id" => $this->input->post('agent_id'),
	// 				"tl_id" => $this->input->post('tl_id'),
	// 				"call_date" => mmddyy2mysql($this->input->post('call_date')),
	// 				"call_duration" => $this->input->post('call_duration'),
	// 				"audit_type" => $this->input->post('audit_type'),
	// 				"auditor_type" => $this->input->post('auditor_type'),
	// 				"voc" => $this->input->post('voc'),
	// 				"possible_score" => $this->input->post('possible_score'),
	// 				"earned_score" => $this->input->post('earned_score'),
	// 				"overall_score" => $this->input->post('overall_score'),
	// 				"greetcustomerapprox" => $this->input->post('greetcustomerapprox'),
	// 				"agentoffername" => $this->input->post('agentoffername'),
	// 				"ascertaincustomername" => $this->input->post('ascertaincustomername'),
	// 				"clarifycallerfromcompany" => $this->input->post('clarifycallerfromcompany'),
	// 				"takedowncallercontact" => $this->input->post('takedowncallercontact'),
	// 				"callerheardthehotel" => $this->input->post('callerheardthehotel'),
	// 				"adoptOpenapproach" => $this->input->post('adoptOpenapproach'),
	// 				"establishedEventType" => $this->input->post('establishedEventType'),
	// 				"callerRequestLocation" => $this->input->post('callerRequestLocation'),
	// 				"callerMeetingtimedate" => $this->input->post('callerMeetingtimedate'),
	// 				"clearlydiscussAVCatering" => $this->input->post('clearlydiscussAVCatering'),
	// 				"determineaccomodationrequired" => $this->input->post('determineaccomodationrequired'),
	// 				"reconfirmdelegatenumber" => $this->input->post('reconfirmdelegatenumber'),
	// 				"determineagencyspecificprice" => $this->input->post('determineagencyspecificprice'),
	// 				"callerquotedcompetetion" => $this->input->post('callerquotedcompetetion'),
	// 				"establishchoiceofVenue" => $this->input->post('establishchoiceofVenue'),
	// 				"promptedbythecaller" => $this->input->post('promptedbythecaller'),
	// 				"keypackagefeatures" => $this->input->post('keypackagefeatures'),
	// 				"offertoplacemeeting" => $this->input->post('offertoplacemeeting'),
	// 				"offeralternatepositively" => $this->input->post('offeralternatepositively'),
	// 				"agentaskmeetingrequest" => $this->input->post('agentaskmeetingrequest'),
	// 				"agentclosetheCall" => $this->input->post('agentclosetheCall'),
	// 				"reconfirmallbookingdetails" => $this->input->post('reconfirmallbookingdetails'),
	// 				"offersendproposalviaEmail" => $this->input->post('offersendproposalviaEmail'),
	// 				"avoidsilencesduringCall" => $this->input->post('avoidsilencesduringCall'),
	// 				"displayprofessionalcall" => $this->input->post('displayprofessionalcall'),
	// 				"soundclearthroughCall" => $this->input->post('soundclearthroughCall'),
	// 				"soundFriendlyPoliteWelcome" => $this->input->post('soundFriendlyPoliteWelcome'),
	// 				"useeffectivequestionSkills" => $this->input->post('useeffectivequestionSkills'),
	// 				"demonstrateactivelistening" => $this->input->post('demonstrateactivelistening'),
	// 				"callercompleteCCCSurvey" => $this->input->post('callercompleteCCCSurvey'),
	// 				"cmt1" => $this->input->post('cmt1'),
	// 				"cmt2" => $this->input->post('cmt2'),
	// 				"cmt3" => $this->input->post('cmt3'),
	// 				"cmt4" => $this->input->post('cmt4'),
	// 				"cmt5" => $this->input->post('cmt5'),
	// 				"cmt6" => $this->input->post('cmt6'),
	// 				"cmt7" => $this->input->post('cmt7'),
	// 				"cmt8" => $this->input->post('cmt8'),
	// 				"cmt9" => $this->input->post('cmt9'),
	// 				"cmt10" => $this->input->post('cmt10'),
	// 				"cmt11" => $this->input->post('cmt11'),
	// 				"cmt12" => $this->input->post('cmt12'),
	// 				"cmt13" => $this->input->post('cmt13'),
	// 				"cmt14" => $this->input->post('cmt14'),
	// 				"cmt15" => $this->input->post('cmt15'),
	// 				"cmt16" => $this->input->post('cmt16'),
	// 				"cmt17" => $this->input->post('cmt17'),
	// 				"cmt18" => $this->input->post('cmt18'),
	// 				"cmt19" => $this->input->post('cmt19'),
	// 				"cmt20" => $this->input->post('cmt20'),
	// 				"cmt21" => $this->input->post('cmt21'),
	// 				"cmt22" => $this->input->post('cmt22'),
	// 				"cmt23" => $this->input->post('cmt23'),
	// 				"cmt24" => $this->input->post('cmt24'),
	// 				"cmt25" => $this->input->post('cmt25'),
	// 				"cmt26" => $this->input->post('cmt26'),
	// 				"cmt27" => $this->input->post('cmt27'),
	// 				"cmt28" => $this->input->post('cmt28'),
	// 				"cmt29" => $this->input->post('cmt29'),
	// 				"cmt30" => $this->input->post('cmt30'),
	// 				"cmt31" => $this->input->post('cmt31'),
	// 				"call_summary" => $this->input->post('call_summary'),
	// 				"feedback" => $this->input->post('feedback')
	// 			);

	// 			if($_FILES['attach_file']['tmp_name'][0]!=''){
	// 				$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/me_call_email/');
	// 				$field_array['attach_file'] = implode(',',$a);
	// 			}

	// 			$this->db->where('id', $pnid);
	// 			$this->db->update('qa_jurysinn_me_call_feedback',$field_array);

	// 		////////////
	// 			if(get_login_type()=="client"){
	// 				$field_array1 = array(
	// 					"client_rvw_by" => $current_user,
	// 					"client_rvw_note" => $this->input->post('note'),
	// 					"client_rvw_date" => $curDateTime
	// 				);
	// 			}else{
	// 				$field_array1 = array(
	// 					"mgnt_rvw_by" => $current_user,
	// 					"mgnt_rvw_note" => $this->input->post('note'),
	// 					"mgnt_rvw_date" => $curDateTime
	// 				);
	// 			}
	// 			$this->db->where('id', $pnid);
	// 			$this->db->update('qa_jurysinn_me_call_feedback',$field_array1);
	// 		///////////
	// 			redirect('Qa_jurys_inn/jurysinn_ME_cis');
	// 			$data["array"] = $a;
	// 		}else{
	// 			$this->load->view('dashboard',$data);
	// 		}
	// 	}
	// }

/////////////////////////////////////////////////////////////////////////
//////////////////////////// Stag and Hen ///////////////////////////////
	public function jurysinn_stag_hen(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/jurysinn_stag_hen.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_stag_hen_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["stag_hen"] = $this->Common_model->get_query_result_array($qSql);
		////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_cis_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["staghen_cis"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";

			$data["stag_hen_emails"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_esc_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";

			$data["stag_hen_esc"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_jurysinn_stag_hen($sh_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/add_edit_jurysinn_stag_hen.php";
			$data['sh_id']=$sh_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_jurysinn_stag_hen_feedback where id='$sh_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["stag_hen"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($sh_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_jurys_inn/stag_hen/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_jurysinn_stag_hen_feedback',$field_array);
					
					//echo $this->db->last_query();
					//die();
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_jurysinn_stag_hen_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/stag_hen/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $sh_id);
					$this->db->update('qa_jurysinn_stag_hen_feedback',$field_array1);
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
					$this->db->where('id', $sh_id);
					$this->db->update('qa_jurysinn_stag_hen_feedback',$edit_array);

				}
				redirect('qa_jurys_inn/jurysinn_stag_hen');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_jurysinn_staghen_cis($shcis_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/add_edit_jurysinn_staghen_cis.php";
			$data['shcis_id']=$shcis_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_jurysinn_staghen_cis_feedback where id='$shcis_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["staghen_cis"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($shcis_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_jurys_inn/stag_hen_cis/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_jurysinn_staghen_cis_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_jurysinn_staghen_cis_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/stag_hen_cis/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $shcis_id);
					$this->db->update('qa_jurysinn_staghen_cis_feedback',$field_array1);
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
					$this->db->where('id', $shcis_id);
					$this->db->update('qa_jurysinn_staghen_cis_feedback',$edit_array);

				}
				redirect('qa_jurys_inn/jurysinn_stag_hen');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_stag_hen_emails($shemails_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/add_edit_stag_hen_emails.php";
			$data['shemails_id']=$shemails_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_jurysinn_staghen_email_feedback where id='$shemails_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["staghen_cis"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($shemails_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_jurys_inn/stag_hen_emails/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_jurysinn_staghen_email_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_jurysinn_staghen_email_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/stag_hen_emails/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $shcis_id);
					$this->db->update('qa_jurysinn_staghen_email_feedback',$field_array1);
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
					$this->db->where('id', $shemails_id);
					$this->db->update('qa_jurysinn_staghen_email_feedback',$edit_array);

				}
				redirect('qa_jurys_inn/jurysinn_stag_hen');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_stag_hen_esc($shemails_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/add_edit_stag_hen_esc.php";
			$data['shemails_id']=$shemails_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_jurysinn_staghen_esc_feedback where id='$shemails_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["staghen_cis"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($shemails_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_jurys_inn/stag_hen_emails/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_jurysinn_staghen_esc_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_jurysinn_staghen_esc_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/stag_hen_emails/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $shcis_id);
					$this->db->update('qa_jurysinn_staghen_esc_feedback',$field_array1);
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
					$this->db->where('id', $shemails_id);
					$this->db->update('qa_jurysinn_staghen_esc_feedback',$edit_array);

				}
				redirect('qa_jurys_inn/jurysinn_stag_hen');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////// Inputting CIS Evaluation [GDS] //////////////////////////////
	public function jurysinn_input_cis_gds(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/cis_gds/jurysinn_input_cis_gds.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_gds_prearrival_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["gds_prearrival"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_jurysinn_input_cis_gds($gds_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/cis_gds/add_edit_jurysinn_input_cis_gds.php";
			$data['gds_id']=$gds_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_jurysinn_input_cis_feedback where id='$gds_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["cis_gds"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($gds_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_jurys_inn/cis_gds/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_jurysinn_input_cis_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_jurysinn_input_cis_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/cis_gds/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $gds_id);
					$this->db->update('qa_jurysinn_input_cis_feedback',$field_array1);
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
					$this->db->where('id', $gds_id);
					$this->db->update('qa_jurysinn_input_cis_feedback',$edit_array);

				}
				// redirect('qa_jurys_inn/jurysinn_input_cis_gds');
				redirect('qa_jurys_inn');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// GDS & Pre Arrival //////////////////////////////////
	/* public function jurysinn_gds_prearrival(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/gds_prearrival/jurysinn_gds_prearrival.php";

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_gds_prearrival_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["gds_prearrival"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	} */


	public function add_edit_jurysinn_gds_prearrival($gds_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/gds_prearrival/add_edit_jurysinn_gds_prearrival.php";
			$data['gds_id']=$gds_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_jurysinn_gds_prearrival_feedback where id='$gds_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["gds_prearrival"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($gds_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_jurys_inn/gds_prearrival/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_jurysinn_gds_prearrival_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_jurysinn_gds_prearrival_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_jurys_inn/gds_prearrival/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $gds_id);
					$this->db->update('qa_jurysinn_gds_prearrival_feedback',$field_array1);
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
					$this->db->where('id', $gds_id);
					$this->db->update('qa_jurysinn_gds_prearrival_feedback',$edit_array);

				}
				redirect('qa_jurys_inn/jurysinn_input_cis_gds');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////////////////////////////////////////////////
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
			$data["yet_me_call_rvw"] =  $this->Common_model->get_single_value($qSql);
		//////////////////
			$qSql="Select count(id) as value from qa_jurysinn_me_call_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_me_call_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_jurysinn_me_call_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_me_cis_rvw"] =  $this->Common_model->get_single_value($qSql);	
		//////////////////
			$qSql="Select count(id) as value from qa_".$page."_contracts_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_sa"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_".$page."_contracts_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw_sa"] =  $this->Common_model->get_single_value($qSql);
		//////////////////////
			$qSql="Select count(id) as value from qa_".$page."_proposal_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_ta"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_".$page."_proposal_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw_ta"] =  $this->Common_model->get_single_value($qSql);
		/////////////////////
			$stag_hen_Sql1="Select count(id) as value from qa_jurysinn_stag_hen_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["stag_hen_fd"] =  $this->Common_model->get_single_value($stag_hen_Sql1);

			$stag_hen_Sql2="Select count(id) as value from qa_jurysinn_stag_hen_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_stag_hen"] =  $this->Common_model->get_single_value($stag_hen_Sql2);

		/////////////////////
			$staghen_cis_Sql1="Select count(id) as value from qa_jurysinn_staghen_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["staghen_cis_fd"] =  $this->Common_model->get_single_value($staghen_cis_Sql1);

			$staghen_cis_Sql2="Select count(id) as value from qa_jurysinn_staghen_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_staghen_cis"] =  $this->Common_model->get_single_value($staghen_cis_Sql2);

		//////////Emails///////////
			$staghen_cis_emails1="Select count(id) as value from qa_jurysinn_staghen_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["staghen_emails_fd"] =  $this->Common_model->get_single_value($staghen_cis_emails1);

			$staghen_cis_emails2="Select count(id) as value from qa_jurysinn_staghen_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_staghen_emails"] =  $this->Common_model->get_single_value($staghen_cis_emails2);



			$qSql="Select count(id) as value from qa_jurysinn_staghen_esc_feedback where agent_id='$current_user'";
			$data["cis_esc_fd"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_jurysinn_staghen_esc_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_cis_esc"] =  $this->Common_model->get_single_value($qSql);
		
			$gds_Sql1="Select count(id) as value from qa_jurysinn_input_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["cis_gds_fd"] =  $this->Common_model->get_single_value($gds_Sql1);

			$gds_Sql2="Select count(id) as value from qa_jurysinn_input_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_cis_gds"] =  $this->Common_model->get_single_value($gds_Sql2);
		/////////////////////
			$gds_Sql1="Select count(id) as value from qa_jurysinn_gds_prearrival_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["gds_prearrival_fd"] =  $this->Common_model->get_single_value($gds_Sql1);

			$gds_Sql2="Select count(id) as value from qa_jurysinn_gds_prearrival_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_gds_prearrival"] =  $this->Common_model->get_single_value($gds_Sql2);

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
			//////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_call_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_me_call_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
			//////////////
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_contracts_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_contracts_agent_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_proposal_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_proposal_agent_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_stag_hen_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_stag_hen_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_cis_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_staghen_cis_list"] = $this->Common_model->get_query_result_array($qSql);
			/////////New Emails/////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_email_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_staghen_emails_list"] = $this->Common_model->get_query_result_array($qSql);



				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_esc_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_esc_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////////
				 $qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_input_cis_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_gds_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_gds_prearrival_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_gds_prearrival_list"] = $this->Common_model->get_query_result_array($qSql);

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
			//////////////
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_call_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_me_call_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
			//////////////
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_contracts_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_contracts_agent_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_proposal_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data[$page."_proposal_agent_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_stag_hen_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_stag_hen_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_staghen_cis_list"] = $this->Common_model->get_query_result_array($qSql);

			//////New Emails//////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_staghen_emails_list"] = $this->Common_model->get_query_result_array($qSql);


				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_esc_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_esc_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////
				 $qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_input_cis_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_gds_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_gds_prearrival_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_gds_prearrival_list"] = $this->Common_model->get_query_result_array($qSql);

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


	public function agent_jurysinn_esc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/agent_jurysinn_esc_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_esc_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["jurysinn_stag_hen"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_jurysinn_staghen_esc_feedback',$field_array1);
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

	public function agent_jurysinn_me_call_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/agent_jurysinn_me_call_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_me_call_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["me_call_feedback"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_jurysinn_me_call_feedback',$field_array1);
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_jurysinn_stag_hen_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/agent_jurysinn_stag_hen_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_stag_hen_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["jurysinn_stag_hen"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_jurysinn_stag_hen_feedback',$field_array1);
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


	public function agent_jurysinn_staghen_cis_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/agent_jurysinn_staghen_cis_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_cis_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["staghen_cis"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_jurysinn_staghen_cis_feedback',$field_array1);
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_jurysinn_staghen_emails_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/stag_hen/agent_jurysinn_staghen_emails_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_staghen_email_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["staghen_cis"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_jurysinn_staghen_email_feedback',$field_array1);
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


	public function agent_jurysinn_cis_gds_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/cis_gds/agent_jurysinn_cis_gds_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_input_cis_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["cis_gds"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_jurysinn_input_cis_feedback',$field_array1);
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


	public function agent_jurysinn_gds_prearrival_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_jurys_inn/gds_prearrival/agent_jurysinn_gds_prearrival_rvw.php";
			$data["agentUrl"] = "qa_jurys_inn/agent_jurys_inn_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_jurysinn_gds_prearrival_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["gds_prearrival"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_jurysinn_gds_prearrival_feedback',$field_array1);
				redirect('Qa_jurys_inn/agent_jurys_inn_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


/*----------------------------------------------------------*/
/*------------------------------------------------*/
/*----------------------------------------------------------*/
	/* public function jurys_inn_meCis(){
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
	} */


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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
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
				redirect('Qa_jurys_inn/jurysinn_ME_cis');
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'124,358') and status=1  order by name";
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
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
				redirect('Qa_jurys_inn/jurysinn_ME_cis');

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
				}else if($lob=="me_call"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_me_call_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
					}else if($lob=="stag_hen"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_stag_hen_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}else if($lob=="stag_hen_cis"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_staghen_cis_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}else if($lob=="stag_hen_emails"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_staghen_email_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}else if($lob=="cis_gds"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_input_cis_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				}else if($lob=="gds_prearrival"){
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
						(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_jurysinn_gds_prearrival_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
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
		}else if($lob=="me_call"){
			$campaign="M&E CALL Reservation";	
		}else if($lob=="stag_hen"){
			$campaign="Jurys Inn Stag and Hen";
		}else if($lob=="stag_hen_emails"){
			$campaign="Jurys Inn Stag and Hen Emails";
		}else if($lob=="stag_hen_cis"){
			$campaign="Jurys Inn Stag and Hen CIS Evaluation";
		}else if($lob=="cis_gds"){
			$campaign="Inputting CIS Evaluation";
		}else if($lob=="gds_prearrival"){
			$campaign="GDS Pre Arrival";
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
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Email Date", "Reference ID", "Query Type", "Sub Query Type", "Assessment Type", "Transaction Status", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "Customer Score", "Business Score", "Compliance Score", "Did the agent use an appropriate opening line at the beginning of the email?", "Did the agent use the guests name?", "Did the agent use the appropriate template? (If applicable)", "Was the email formatted correctly and consistently? (Same font and colour)", "Did the agent use their signature?", "Did the agent offer add on to maximise revenue? (Offer Breakfast and Superior Rooms)", "Did the agent close the email in a appropriate manner?", "Did the agent use all available information", "Did the agent reconfirm all details including terms and conditions?", "Did the agent follow the correct SOP?", "Did the agent state if there was anything else they could help the guest with?", "Did the agent offer any alternatives? (if applicable)", "Did the agent answer all the guests questions fully?", "Has the agent amended the subject line appropriately?", "Did the agent check if preferential rates were available? (If applicable)", "Did the agent send the email from the correct cluster?", "Did the agent ensure correct spelling on his/her response?", "Did the agent select the correct property?", "Did the agent select the correct date?", "Did the agent select correct amount of rooms booked?", "Did the agent use proper rate code?", "Did the agent use proper guarantee type?", "Did the agent use correct payment option?", "Did the agent made a duplicate reservation?", "Was the booking made over business or leisure based on group threshold?", "Did the agent mark the email complete correctly?", "Was an incorrect change made to a booking?", "Do we expect escalation against the email?","GREET & ENGAGE Comment1", "GREET & ENGAGE Comment2", "GREET & ENGAGE Comment3", "GREET & ENGAGE Comment4", "GREET & ENGAGE Comment5", "QUALIFICATION Comment1", "QUALIFICATION Comment2", "QUALIFICATION Comment3", "QUALIFICATION Comment4", "DILIGENCE Comment1", "DILIGENCE Comment2", "DILIGENCE Comment3", "DETAIL Comment1", "DETAIL Comment2", "DETAIL Comment3", "DETAIL Comment4", "DETAIL Comment5", "DETAIL Comment6", "DETAIL Comment7", "DETAIL Comment8", "DETAIL Comment9", "DETAIL Comment10", "DETAIL Comment11", "DETAIL Comment12", "DETAIL Comment13", "DETAIL Comment14", "DETAIL Comment15", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($lob=="me_cis"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Audit Type", "VOC", "Overall Score", "Earned Score", "Possible Score", "Did the agent Greet the Customer appropriately?", "Did the agent offer his/her name?", "Did the agent ascertain the customer name and use conversationally?", "Did the agent clarify if the caller is from a company or agency?", "Did the agent take down the callers contact details?", "Did the agent establish how the caller had heard of the hotel AND give an upbeat response?", "Did the agent adopt an open approach initially in order to establish the callers requirements?", "Did the agent establish the type purpose of the event?", "Did the agent confirm to the caller what location they are requesting?", "Did the agent confirm to caller dates days and times of the meeting?", "Were the following also clearly discussed?", "Did the agent determine if accommodation was required?", "Did the agent reconfirm delegate numbers & room layout?", "Did the agent determine if the company agency had a specific price range?", "Did the agent determine if the caller has been quoted by any competitors?", "Did the agent establish the most important factors in the choice of venue?", "Did the agent quote the rate without being prompted by the caller", "Were the key package features highlighted when the price was quoted?", "Did the agent offer to place the meeting space on hold?", "Did the agent offer alternates positively?", "Did the agent ask if there were any other meeting requests or if there was anything else?", "Did the agent close the call in an appropriate manner", "Did the agent reconfirm all booking details?", "Did the agent offer send a proposal via email?", "Did the agent avoid long silences during the call?", "Did the agent display a professional manner throughout the call?", "Did the agent sound clear and confident throughout the call?", "Did the agent sound friendly polite and welcoming?", "Did the agent use effective questioning skills?", "Did the agent demonstrate active listening?", "Did the agent ask the caller to complete the CCC Survey?", "GREET & ENGAGE Comment1", "GREET & ENGAGE Comment2", "GREET & ENGAGE Comment3", "GREET & ENGAGE Comment4", "GREET & ENGAGE Comment5", "GREET & ENGAGE Comment6", "QUALIFICATION Comment1", "QUALIFICATION Comment2", "QUALIFICATION Comment3", "QUALIFICATION Comment4", "QUALIFICATION Comment5", "QUALIFICATION Comment6", "QUALIFICATION Comment7", "RECOGNIZE Comment1", "RECOGNIZE Comment2", "RECOGNIZE Comment3", "RECOMMEND Comment1", "RECOMMEND Comment2", "OVERCOME OBJECTIONS Comment1", "OVERCOME OBJECTIONS Comment2", "APPROPRIATE CLOSURE Comment1", "APPROPRIATE CLOSURE Comment2", "APPROPRIATE CLOSURE Comment3", "APPROPRIATE CLOSURE Comment4", "SOFT SKILLS Comment1", "SOFT SKILLS Comment2", "SOFT SKILLS Comment3", "SOFT SKILLS Comment4", "SOFT SKILLS Comment5", "SOFT SKILLS Comment6", "SOFT SKILLS Comment7", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($lob=="me_call"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Audit Type", "VOC", "Overall Score", "Earned Score", "Possible Score", "Did the agent Greet the Customer appropriately?", "Did the agent offer his/her name?", "Did the agent ascertain the customer name and use conversationally?", "Did the agent clarify if the caller is from a company or agency?", "Did the agent ask an Open Question?", "Did the agent establish the type / purpose of the event?", "Did the agent reconfirm to the caller the location the caller is requesting?", "Did the agent reconfirm the meeting dates the caller is requesting?", "Did the agent reconfirm the timings of the meeting?", "Did the agent reconfirm delegate numbers & room layout?", "Did the agent discuss Catering AV and Breakout areas clearly?", "Did the agent determine if the customer had booked with us before?", "Did the agent determine if the customer had a specific price range?", "Did the agent offer add ons  upsell?", "Did the agent quote the rate without being prompted by the caller was it clear and was the tone encouraging?", "Did the agent explain the key package features highlighted when the price was quoted?", "Did the agent offer alternatives positively?", "Did the agent offer to place to meeting space on hold?", "Did the agent recap all the discussed details?", "Did the agent close the call in an appropriate manner?", "Did the agent ask if there was anything else?", "Did the agent avoid long silences during the call?", "Did the agent display a professional manner throughout the call?", "Did the agent refrain from using jargon throughout the call?", "Did the agent sound clear and confident throughout the call?", "Did the agent sound friendly polite and welcoming?", "Did the agent use effective questioning skills?", "Did the agent demonstrate active listening?", "GREET & ENGAGE Comment1", "GREET & ENGAGE Comment2", "GREET & ENGAGE Comment3", "GREET & ENGAGE Comment4", "GREET & ENGAGE Comment5", "QUALIFICATION Comment1", "QUALIFICATION Comment2", "QUALIFICATION Comment3", "QUALIFICATION Comment4", "QUALIFICATION Comment5", "QUALIFICATION Comment6", "RECOGNIZE Comment1", "RECOGNIZE Comment2",  "RECOMMEND Comment1", "RECOMMEND Comment2","RECOMMEND Comment3", "OVERCOME OBJECTIONS Comment1", "OVERCOME OBJECTIONS Comment2", "APPROPRIATE CLOSURE Comment1", "APPROPRIATE CLOSURE Comment2", "APPROPRIATE CLOSURE Comment3", "SOFT SKILLS Comment1", "SOFT SKILLS Comment2", "SOFT SKILLS Comment3", "SOFT SKILLS Comment4", "SOFT SKILLS Comment5", "SOFT SKILLS Comment6", "SOFT SKILLS Comment7", "Compliance Score","Customer Score","Business Score","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		}else if($lob=="stag_hen"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Block Code", "Call Type", "Sub Call Type", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "Did the agent Greet the Customer appropriately?", "Did the agent offer his/her name?", "Did the agent ascertain the customer name and use conversationally?", "Did the agent ask an Open Question?", "Did the agent reconfirm to caller when the customer wants to stay?", "Did the agent reconfirm to caller where the customer wants to stay?", "Did the agent determine the number of rooms and guests?", "Did the agent determine if the customer had an allocation/corporate/agreed rate?", "Did the agent build or use an already existing rapport?", "Did the agent quote the rate without being prompted by the caller? Was it clear and was the tone encouraging?", "Did the agent offer to place the bedrooms on hold?", "Did the agent offer alternates positively", "**Did the agent present terms and conditions positively (Cancellation Policy)", "Did the agent ask if there were any other reservations or if there was anything else?", "Did the agent follow the correct SOP?", "Did the agent close the call in an appropriate manner", "Did the agent offer to send the quote by email?", "Did the agent avoid long silences during the call?", "Did the agent display a professional manner throughout the call?", "Did the agent sound clear and confident throughout the call?", "Did the agent refrain from using jargon throughout the call?", "Did the agent sound friendly polite and welcoming?", "Did the agent use effective questioning skills?", "Did the agent demonstrate active listening?", "Greet & Engage Comment1", "Greet & Engage Comment2", "Greet & Engage Comment3", "Greet & Engage Comment4", "Qualification Comment1", "Qualification Comment2", "Qualification Comment3", "Qualification Comment4", "Recognise Comment1", "Recognise Comment2", "Overcome Objections Comment1", "Overcome Objections Comment2", "Overcome Objections Comment3", "Appropriate Closure Comment1", "Appropriate Closure Comment2", "Appropriate Closure Comment3", "Appropriate Closure Comment4", "Soft skills Comment1", "Soft skills Comment2", "Soft skills Comment3", "Soft skills Comment4", "Soft skills Comment5", "Soft skills Comment6", "Soft skills Comment7", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($lob=="stag_hen_emails"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Date email was sent", "Name","Email Type(availability check amendments traces final handover)", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score","Did the agent determine if the customer had an allocation/corporate/agreed rate?","Was the blackout document checked before quoting?", "Did the agent quote in the correct currency?","Did the agent use the correct template with the correct cancellation policy?", "Did the agent update the block notes correctly?", "Did the agent select/add the correct trace date?","Did the agent maximise resources?","Did the agent send from the S&H inbox and copy the Stag group for relevant emails?","Did the agent use their signature at the end of the email?", "Did the agent save to the Backup Drive correctly?","Comment 1", "Comment 2", "Comment 3", "Comment 4", "Comment 5", "Comment 6", "Comment 7", "Comment 8", "Comment 9", "Comment 10","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($lob=="stag_hen_cis"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Block Code", "Call Type", "Sub Call Type", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "1. Did the agent check if allocation was available?", "2. Did the agent load the block for the correct property and dates?", "3. Was the blackout document checked before loading the block?", "4. Did the agent created/ choose the correct contact profile for this booking with contact details stated?", "5. Is the market segments correctly inputted?", "6. Did the agent load bedrooms on the grid correctly?", "7. Did the agent add block notes to what was offered?", "8. Did the agent add the trace to the block with the correct trace date?", "9. Did the agent respond in the correct format?", "10. If rooms were taken from allocation was the allocation deducted from the master block?", "11. Did the the agent quote in the correct currency?", "12. Did the agent send it from the S and H Inbox?", "13. Did the agent use their signature at the end of the email?", "Comment 1", "Comment 2", "Comment 3", "Comment 4", "Comment 5", "Comment 6", "Comment 7", "Comment 8", "Comment 9", "Comment 10", "Comment 11", "Comment 12", "Comment 13", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($lob=="cis_gds"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Query Type", "Confirmation Number", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "1. Did the agent check that the reservation was not already in the system?", "2. Did the agent book under the correct company profile?", "3. Did the agent book under the correct agency profile?", "4. Did the agent ensure that the negotiated rates were picked up from the availability screen?", "5. Did the agent take the room from allocation if stated?", "6. Did the agent book the correct hotel?", "6. Did the agent book the correct hotel?", "7. Did the agent book the correct arrival date?", "8. Did the agent book the correct the number of nights?", "9. Did the agent book the correct number of guests?", "10. Did the agent book the correct number of rooms?", "11. Did the agent enter the guest details correctly?", "12. Are the market, source and origin segments correct?", "13. Are the billing instructions correct?", "14. Did the agent put the reference in the correct fields?", "COMMENT 1", "COMMENT 2", "COMMENT 3", "COMMENT 4", "COMMENT 5", "COMMENT 6", "COMMENT 7", "COMMENT 8", "COMMENT 9", "COMMENT 10", "COMMENT 11", "COMMENT 12", "COMMENT 13", "COMMENT 14", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($lob=="gds_prearrival"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Query Type", "Query Sub Type", "Reference ID", "Total Opportunity", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "Backups filtered into the correct folders?", "Guest Profile Correct?", "Reference numbers added?", "Arrival/Departure Dates Correct?", "Comments Updated Correctly?", "Hotel Alignment Correct?", "Travel Agent Profile Correct?", "Company Profile Correct?", "Routed Correctly?", "Room Type Correct?", "Correct Number of Rooms Checked?", "Occupancy Correct?", "Rate Correct?", "Market Segments Correct?", "Dinner Allowance Added?", "Check Symbol Added?", "Guest Profile Correct?", "Reference Numbers added?", "Arrival/Departure Dates Correct?", "Comments Updated Correctly?", "Travel Agent Profile Correct?", "Hotel Alignment Correct?", "Routed Correctly?", "Room Type Correct?", "Correct Number of Rooms Checked?", "Occupancy Correct?", "Rate Correct?", "Market Segments Correct?", "Breakfast Package Added?", "Dinner Allowance Added?", "Check Symbol Added?", "Card Details Added?", "Saved to Backup?", "Cancelled the correct number of rooms?", "JI Bookings - Changed to DPG?", "Email Sent in accordance to JI Standards?", "No Breach of Data Protection?", "Signature Added?", "Sent from AdminRes?", "No Abbrevations Used?", "Query Sent to Backups on time?", "Query Form sent as Copy & Paste NOT Snip?", "Stag & Hen/Groups Checked with Full Complete Handover?", "Occupancy / Rooming List Correct?", "Check Symbol Added?", "Payment / Confirmation of payment type received?", "Correct Rates?", "Arrival/Departure Dates Correct?", "Comments Updated Correctly?", "Is the Bookings Checked in the Correct Format?", "Guest Names in accordance to Brand Standards?", "Comments Updated with Appropriate Actions?", "COMMENT 1", "COMMENT 2", "COMMENT 3", "COMMENT 4", "COMMENT 5", "COMMENT 6", "COMMENT 7", "COMMENT 8", "COMMENT 9", "COMMENT 10", "COMMENT 11", "COMMENT 12", "COMMENT 13", "COMMENT 14", "COMMENT 15", "COMMENT 16", "COMMENT 17", "COMMENT 18", "COMMENT 19", "COMMENT 20", "COMMENT 21", "COMMENT 22", "COMMENT 23", "COMMENT 24", "COMMENT 25", "COMMENT 26", "COMMENT 27", "COMMENT 28", "COMMENT 29", "COMMENT 30", "COMMENT 31", "COMMENT 32", "COMMENT 33", "COMMENT 34", "COMMENT 35", "COMMENT 36", "COMMENT 37", "COMMENT 38", "COMMENT 39", "COMMENT 40", "COMMENT 41", "COMMENT 42", "COMMENT 43", "COMMENT 44", "COMMENT 45", "COMMENT 46", "COMMENT 47", "COMMENT 48", "COMMENT 49", "COMMENT 50", "COMMENT 51", "COMMENT 52", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['ref_id'].'",';
				$row .= '"'.$user['query_type'].'",';
				$row .= '"'.$user['query_sub_type'].'",';
				$row .= '"'.$user['asmnt_type'].'",';
				$row .= '"'.$user['tran_status'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['customer_score'].'%'.'",';
				$row .= '"'.$user['business_score'].'%'.'",';
				$row .= '"'.$user['compliance_score'].'%'.'",';
				$row .= '"'.$user['agentuseopening'].'",';
				$row .= '"'.$user['agentuseguestname'].'",';
				$row .= '"'.$user['agentusetemplate'].'",';
				$row .= '"'.$user['emailformatedcorrectly'].'",';
				$row .= '"'.$user['agentusesignature'].'",';
				$row .= '"'.$user['agentofferrevenue'].'",';
				$row .= '"'.$user['agentcloseemail'].'",';
				$row .= '"'.$user['agentuseinformation'].'",';
				$row .= '"'.$user['agentreconfirmterms'].'",';
				//$row .= '"'.$user['agentGDPRconfirm'].'",';
				//$row .= '"'.$user['agentfollowSOPcorrect'].'",';
				$row .= '"'.$user['agentstateguesthelp'].'",';
				$row .= '"'.$user['agentofferalternative'].'",';
				$row .= '"'.$user['agentanswerguestquestion'].'",';
				$row .= '"'.$user['agentamendedsubjectline'].'",';
				$row .= '"'.$user['agentcheckprefererate'].'",';
				$row .= '"'.$user['agentsendemailcluster'].'",';
				$row .= '"'.$user['agentensurespelling'].'",';
				$row .= '"'.$user['agnetselectcorrectproperty'].'",';
				$row .= '"'.$user['agentselectcorrectdate'].'",';
				$row .= '"'.$user['agentselectcorrectroombook'].'",';
				$row .= '"'.$user['agentuseproperratecode'].'",';
				$row .= '"'.$user['agentusepropergurantee'].'",';
				$row .= '"'.$user['agentusecorrectpayment'].'",';
				$row .= '"'.$user['agentmadeduplicatereservation'].'",';
				$row .= '"'.$user['bookingmadeoverbusiness'].'",';
				$row .= '"'.$user['agentmarkemailcorrectly'].'",';
				$row .= '"'.$user['incorrectbookingchange'].'",';
				$row .= '"'.$user['escalationagainstemail'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				//$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				//$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt30'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt31'])).'",';
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
		}else if($lob=="me_call"){

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
				$row .= '"'.$user['company_agency'].'",';
				$row .= '"'.$user['open_question'].'",';
				$row .= '"'.$user['purpose_event'].'",';
				$row .= '"'.$user['location_requesting'].'",';
				$row .= '"'.$user['caller_requesting'].'",';
				$row .= '"'.$user['timings_meeting'].'",';
				$row .= '"'.$user['room_layout'].'",';
				$row .= '"'.$user['breakout_areas'].'",';
				$row .= '"'.$user['customer_booked'].'",';
				$row .= '"'.$user['specific_price'].'",';
				$row .= '"'.$user['addons_upsell'].'",';
				$row .= '"'.$user['tone_encouraging'].'",';
				$row .= '"'.$user['features_highlighted'].'",';
				$row .= '"'.$user['alternativespositively'].'",';
				$row .= '"'.$user['meeting_space'].'",';
				$row .= '"'.$user['discussed_details'].'",';
				$row .= '"'.$user['appropriate_manner'].'",';
				$row .= '"'.$user['anything_else'].'",';
				$row .= '"'.$user['avoidsilencesduringCall'].'",';
				$row .= '"'.$user['displayprofessionalcall'].'",';
				$row .= '"'.$user['jargon_throughout'].'",';
				$row .= '"'.$user['soundclearthroughCall'].'",';
				$row .= '"'.$user['soundFriendlyPoliteWelcome'].'",';
				$row .= '"'.$user['useeffectivequestionSkills'].'",';
				$row .= '"'.$user['demonstrateactivelistening'].'",';
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
				$row .= '"'.$user['complJiCisScore'].'%'.'",';
				$row .= '"'.$user['custJiCisScore'].'%'.'",';
				$row .= '"'.$user['busiJiCisScore'].'%'.'",';
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

		}else if($lob=="stag_hen"){

			foreach($rr as $user)
			{
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
				$row .= '"'.$user['block_code'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['sub_call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['greet_customer_appropiately'].'",';
				$row .= '"'.$user['agent_offer_name'].'",';
				$row .= '"'.$user['agent_ascertain_customer'].'",';
				$row .= '"'.$user['agent_ask_open_question'].'",';
				$row .= '"'.$user['when_customer_stay'].'",';
				$row .= '"'.$user['where_customer_stay'].'",';
				$row .= '"'.$user['agent_determine_room_guest'].'",';
				$row .= '"'.$user['determine_customer_allocation'].'",';
				$row .= '"'.$user['build_existing_rapport'].'",';
        $row .= '"'.$user['prompt_quote_rate'].'",';
				$row .= '"'.$user['agent_offer_bedrrom_onhold'].'",';
				$row .= '"'.$user['agent_offer_alternate_possiblities'].'",';
				$row .= '"'.$user['agent_present_terms'].'",';
				$row .= '"'.$user['agent_ask_reservation'].'",';
				$row .= '"'.$user['agent_follow_correct_SOP'].'",';
				$row .= '"'.$user['close_call_appropiate_manner'].'",';
				$row .= '"'.$user['send_quote_by_email'].'",';
				$row .= '"'.$user['agent_avoid_long_silence'].'",';
				$row .= '"'.$user['agent_display_call'].'",';
				$row .= '"'.$user['agent_sound_clear'].'",';
				$row .= '"'.$user['agnet_reframe_using_jargon'].'",';
				$row .= '"'.$user['agent_sound_friendly'].'",';
				$row .= '"'.$user['agent_use_effective_question'].'",';
				$row .= '"'.$user['agent_demonstrate_active_listening'].'",';
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

		  }else if($lob=="stag_hen_emails"){
			foreach($rr as $user)
			{
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
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['email_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['the_agent_determine'].'",';
				$row .= '"'.$user['the_blackout_document'].'",';
				$row .= '"'.$user['the_agent_quote'].'",';
				$row .= '"'.$user['agent_use_the_correct'].'",';
				$row .= '"'.$user['the_agent_update'].'",';
				$row .= '"'.$user['agent_select_add'].'",';
				$row .= '"'.$user['agent_maximise_resources'].'",';
				$row .= '"'.$user['agent_send_from'].'",';
				$row .= '"'.$user['agent_use_their'].'",';
				$row .= '"'.$user['agent_save_to'].'",';
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

		}else if($lob=="stag_hen_cis"){

			foreach($rr as $user)
			{
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
				$row .= '"'.$user['block_code'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['sub_call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['agent_check_available_location'].'",';
				$row .= '"'.$user['agent_block_correct_property'].'",';
				$row .= '"'.$user['agent_block_correct_property'].'",';
				$row .= '"'.$user['agent_choose_correct_profile'].'",';
				$row .= '"'.$user['correct_input_market_segment'].'",';
				$row .= '"'.$user['agent_load_bedroom_grid'].'",';
				$row .= '"'.$user['agent_add_block_note'].'",';
				$row .= '"'.$user['agent_trace_correct_date'].'",';
				$row .= '"'.$user['agent_responce_email_format'].'",';
				$row .= '"'.$user['room_allocation'].'",';
				$row .= '"'.$user['agent_quote_correct_currency'].'",';
				$row .= '"'.$user['agent_send_SH_inbox'].'",';
				$row .= '"'.$user['agent_use_signature_in_email'].'",';
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

		}else if($lob=="cis_gds"){

			foreach($rr as $user)
			{
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
				$row .= '"'.$user['query_type'].'",';
				$row .= '"'.$user['confirmation_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['check_reservation_in_system'].'",';
				$row .= '"'.$user['book_under_correct_company'].'",';
				$row .= '"'.$user['book_under_correct_agency'].'",';
				$row .= '"'.$user['negociate_rate_picked_up'].'",';
				$row .= '"'.$user['take_room_from_allocation'].'",';
				$row .= '"'.$user['book_correct_hotel'].'",';
				$row .= '"'.$user['book_correct_arrival_date'].'",';
				$row .= '"'.$user['book_correct_night_number'].'",';
				$row .= '"'.$user['book_correct_guest_number'].'",';
				$row .= '"'.$user['book_correct_room_number'].'",';
				$row .= '"'.$user['enter_guest_details_correctly'].'",';
				$row .= '"'.$user['correct_origin_segment'].'",';
				$row .= '"'.$user['correct_billing_instructions'].'",';
				$row .= '"'.$user['put_reference_in_correct_fields'].'",';
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

		}else if($lob=="gds_prearrival"){

			foreach($rr as $user)
			{
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
				$row .= '"'.$user['query_type'].'",';
				$row .= '"'.$user['query_sub_type'].'",';
				$row .= '"'.$user['reference_id'].'",';
				$row .= '"'.$user['total_opportunity'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['backup_filter'].'",';
				$row .= '"'.$user['backup_guest_profile'].'",';
				$row .= '"'.$user['backup_reference_number'].'",';
				$row .= '"'.$user['backup_arrival_departure_date'].'",';
				$row .= '"'.$user['backup_comment_updated'].'",';
				$row .= '"'.$user['backup_hotel_alignment'].'",';
				$row .= '"'.$user['backup_travel_agent_profile'].'",';
				$row .= '"'.$user['backup_company_profile'].'",';
				$row .= '"'.$user['backup_routed_correctly'].'",';
				$row .= '"'.$user['backup_room_type'].'",';
				$row .= '"'.$user['backup_correct_room_number'].'",';
				$row .= '"'.$user['backup_correct_occupency'].'",';
				$row .= '"'.$user['backup_correct_rate'].'",';
				$row .= '"'.$user['backup_market_segment'].'",';
				$row .= '"'.$user['backup_dinner_allowences'].'",';
				$row .= '"'.$user['backup_symbol_check'].'",';
				$row .= '"'.$user['extranet_guest_profile'].'",';
				$row .= '"'.$user['extranet_reference_number'].'",';
				$row .= '"'.$user['extranet_arrival_departure_date'].'",';
				$row .= '"'.$user['extranet_comment_update'].'",';
				$row .= '"'.$user['extranet_travel_agent'].'",';
				$row .= '"'.$user['extranet_hotel_alignment'].'",';
				$row .= '"'.$user['extranet_routed_correctly'].'",';
				$row .= '"'.$user['extranet_correct_room_type'].'",';
				$row .= '"'.$user['extranet_correct_number'].'",';
				$row .= '"'.$user['extranet_occupency_correct'].'",';
				$row .= '"'.$user['extranet_correct_rate'].'",';
				$row .= '"'.$user['extranet_market_segment'].'",';
				$row .= '"'.$user['extranet_breakfast_package'].'",';
				$row .= '"'.$user['extranet_dinner_allowances'].'",';
				$row .= '"'.$user['extranet_check_symbol'].'",';
				$row .= '"'.$user['extranet_card_details'].'",';
				$row .= '"'.$user['extranet_backup_saved'].'",';
				$row .= '"'.$user['extranet_cancel_correct_room'].'",';
				$row .= '"'.$user['extranet_ji_booking'].'",';
				$row .= '"'.$user['email_send_ji_standard'].'",';
				$row .= '"'.$user['no_breach_data_protection'].'",';
				$row .= '"'.$user['signature_added'].'",';
				$row .= '"'.$user['send_AdminRes'].'",';
				$row .= '"'.$user['no_abbreviation_used'].'",';
				$row .= '"'.$user['query_sent_backup_time'].'",';
				$row .= '"'.$user['query_sent_not_snip'].'",';
				$row .= '"'.$user['stag_hen_group_check'].'",';
				$row .= '"'.$user['rooming_list_correct'].'",';
				$row .= '"'.$user['check_symbol_added'].'",';
				$row .= '"'.$user['payment_type_received'].'",';
				$row .= '"'.$user['groups_correct_rate'].'",';
				$row .= '"'.$user['groups_arrival_departure_date'].'",';
				$row .= '"'.$user['groups_comments_updated'].'",';
				$row .= '"'.$user['booking_check_correct_format'].'",';
				$row .= '"'.$user['guest_name_brand_standart'].'",';
				$row .= '"'.$user['comment_update_appropiate_standart'].'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt30'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt31'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt32'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt33'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt34'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt35'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt36'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt37'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt38'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt39'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt40'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt41'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt42'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt43'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt44'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt45'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt46'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt47'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt48'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt49'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt50'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt51'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt52'])).'",';
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
