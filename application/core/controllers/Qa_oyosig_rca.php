<?php 

 class Qa_oyosig_rca extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	 


	 
	public function index(){
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyosig_rca/qa_oyosig_rca_feedback.php";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date_time) >= '$from_date' and date(audit_date_time) <= '$to_date' ) ";
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_oyosig_rca $cond) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) order by audit_date_time";
			$data["qa_oyosig_rca_data"] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyosig_rca/add_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,90) and is_assign_process (id,153) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_oyosig_rca_category where is_active=1";
			$data['getCategory'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_oyosig_rca_subcategory where is_active=1";
			$data['getSubcategory'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			
			if($this->input->post('audit_date_time')){
				$field_array=array(
					"audit_date_time" => CurrMySqlDate(),
					"ticket_id" => $this->input->post('ticket_id'),
					"rating" => $this->input->post('rating'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"czentrix_id" => $this->input->post('czentrix_id'),
					"issue_category" => $this->input->post('issue_category'),
					"issue_subcategory" => $this->input->post('issue_subcategory'),
					"guest_call_issue" => $this->input->post('guest_call_issue'),
					"control_uncontrol" => $this->input->post('control_uncontrol'),
					"acpt" => $this->input->post('acpt'),
					"why1" => $this->input->post('why1'),
					"why2" => $this->input->post('why2'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$rowid= data_inserter('qa_oyosig_rca',$field_array);
				redirect('Qa_oyosig_rca');
			}
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function edit_oyosig_rca_feedback($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyosig_rca/edit_oyosig_rca_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,90) and is_assign_process (id,153) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_oyosig_rca_category where is_active=1";
			$data['getCategory'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM qa_oyosig_rca_subcategory where is_active=1";
			$data['getSubcategory'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_oyo_dsat_why1 where is_active=1";
			$data['getacptwhy1'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select description from qa_oyosig_rca_category rc where rc.id=issue_category) as issue_cat, (select description from qa_oyosig_rca_subcategory rsc where rsc.id=issue_subcategory) as issue_subcat from qa_oyosig_rca where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) order by audit_date_time";
			$data["oyosig_rca"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["rcaid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('rca_id'))
			{
				$rca_id=$this->input->post('rca_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"ticket_id" => $this->input->post('ticket_id'),
					"rating" => $this->input->post('rating'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"czentrix_id" => $this->input->post('czentrix_id'),
					"issue_category" => $this->input->post('issue_category'),
					"issue_subcategory" => $this->input->post('issue_subcategory'),
					"guest_call_issue" => $this->input->post('guest_call_issue'),
					"control_uncontrol" => $this->input->post('control_uncontrol'),
					"acpt" => $this->input->post('acpt'),
					"why1" => $this->input->post('why1'),
					"why2" => $this->input->post('why2'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $rca_id);
				$this->db->update('qa_oyosig_rca',$field_array);
				
				redirect('Qa_oyosig_rca');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
/*--------------------------------------------------------Social Media Escalation RCA-------------------------------------------------*/
	public function qa_sme_rca_feedback(){
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyosig_rca/qa_sme_rca_feedback.php";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
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
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_oyosig_sme_rca $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["qa_oyosig_sme_rca_data"] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_sme_rca_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyosig_rca/add_sme_rca_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, get_process_names(id) as process_name FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,90) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_oyosig_rca_category where is_active=1";
			$data['getCategory'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_oyosig_rca_subcategory where is_active=1";
			$data['getSubcategory'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			
			if($this->input->post('booking_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"booking_id" => $this->input->post('booking_id'),
					"ticket1" => $this->input->post('ticket1'),
					"ticket2" => $this->input->post('ticket2'),
					"ticket3" => $this->input->post('ticket3'),
					"caller_no" => $this->input->post('caller_no'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"orm_ticket" => $this->input->post('orm_ticket'),
					"complaint_type" => $this->input->post('complaint_type'),
					"transaction" => $this->input->post('transaction'),
					"defective_transaction" => $this->input->post('defective_transaction'),
					"escalated_date" => mmddyy2mysql($this->input->post('escalated_date')),
					"week" => $this->input->post('week'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"fusion_prevent" => $this->input->post('fusion_prevent'),
					"monetory_loss" => $this->input->post('monetory_loss'),
					"amount" => $this->input->post('amount'),
					"acpt" => $this->input->post('acpt'),
					"why1" => $this->input->post('why1'),
					"why2" => $this->input->post('why2'),
					"action_policy" => $this->input->post('action_policy'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$rowid= data_inserter('qa_oyosig_sme_rca',$field_array);
				redirect('Qa_oyosig_rca/qa_sme_rca_feedback');
			}
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function edit_sigsme_rca_feedback($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyosig_rca/edit_sme_rca_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, get_process_names(id) as process_name FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,90) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);	
			
			$qSql = "SELECT * FROM qa_oyo_dsat_why1 where is_active=1";
			$data['dsat_why1'] = $this->Common_model->get_query_result_array($qSql);	
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_oyosig_sme_rca where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["sme_rca"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["smeid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('sme_id'))
			{
				$sme_id=$this->input->post('sme_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"booking_id" => $this->input->post('booking_id'),
					"ticket1" => $this->input->post('ticket1'),
					"ticket2" => $this->input->post('ticket2'),
					"ticket3" => $this->input->post('ticket3'),
					"caller_no" => $this->input->post('caller_no'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"orm_ticket" => $this->input->post('orm_ticket'),
					"complaint_type" => $this->input->post('complaint_type'),
					"transaction" => $this->input->post('transaction'),
					"defective_transaction" => $this->input->post('defective_transaction'),
					"escalated_date" => mmddyy2mysql($this->input->post('escalated_date')),
					"week" => $this->input->post('week'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"fusion_prevent" => $this->input->post('fusion_prevent'),
					"monetory_loss" => $this->input->post('monetory_loss'),
					"amount" => $this->input->post('amount'),
					"acpt" => $this->input->post('acpt'),
					"why1" => $this->input->post('why1'),
					"why2" => $this->input->post('why2'),
					"action_policy" => $this->input->post('action_policy'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $sme_id);
				$this->db->update('qa_oyosig_sme_rca',$field_array);
				
				redirect('Qa_oyosig_rca/qa_sme_rca_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	public function issueSubcategory(){
		if(check_logged_in()){
			$cid=$this->input->post('cid');
			$qSql="Select id,description from qa_oyosig_rca_subcategory where cat_id='$cid' and is_active='1' order by description asc";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function acptwhy1(){
		if(check_logged_in()){
			$acptid=$this->input->post('acptid');
			$qSql="Select id,description from qa_oyo_dsat_why1 where acpt='$acptid' and is_active='1' order by description asc";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
 }