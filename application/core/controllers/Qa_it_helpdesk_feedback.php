<?php 

 class Qa_it_helpdesk_feedback extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
    }
    
    public function index(){
		
		if(check_logged_in())
		{			
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_it_helpdesk_feedback/qa_it_helpdesk_feedback.php";
			$data["content_js"] = "qa_biomet_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=2 and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			$agnt_cond="";
			
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
			
			if(get_role_dir()=='agent' && get_dept_id()==2){
				$agnt_cond .=" Where agent_id='$current_user'";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_it_helpdesk_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $agnt_cond order by audit_date";
			$data["it_helpdesk_feedback"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
    }
    

    	
	public function add_edit_it_helpdesk_feedback($call_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_it_helpdesk_feedback/add_edit_it_helpdesk_feedback.php";
			$data["content_js"] = "qa_biomet_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=2 and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['call_id']=$call_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_it_helpdesk_feedback where id='$call_id') xx Left Join (Select id as sid, concat(fname, ' ', lname) as agent_name, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["it_helpdesk_feedback"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"ticket_date" => mmddyy2mysql($this->input->post('ticket_date')),
					"ticket_id" => $this->input->post('ticket_id'),
					"ticket_category" => $this->input->post('ticket_category'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"initial_responce" => $this->input->post('initial_responce'),
					"communication" => $this->input->post('communication'),
					"probing" => $this->input->post('probing'),
					"assistance_enthusiasm" => $this->input->post('assistance_enthusiasm'),
					"issue_identification" => $this->input->post('issue_identification'),
					"documentation" => $this->input->post('documentation'),
					"ownership" => $this->input->post('ownership'),
					"escalation" => $this->input->post('escalation'),
					"knowledge" => $this->input->post('knowledge'),
					"verbiage" => $this->input->post('verbiage'),
					"on_call_resolution" => $this->input->post('on_call_resolution'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				if($call_id==0){
					
					$rowid= data_inserter('qa_it_helpdesk_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"audit_start_time" => $this->input->post('audit_start_time'),
						"entry_date" => $curDateTime
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_it_helpdesk_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_it_helpdesk_feedback',$field_array1);
					
				}else{

					$this->db->where('id', $call_id);
					$this->db->update('qa_it_helpdesk_feedback',$field_array);
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
					$this->db->where('id', $call_id);
					$this->db->update('qa_it_helpdesk_feedback',$field_array1);
					
				}
				redirect('Qa_it_helpdesk_feedback');
			}
			$this->load->view("dashboard",$data);
		}
	}



	public function agent_it_helpdesk_feedback_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_it_helpdesk_feedback/agent_it_helpdesk_feedback_feedback.php";
			$data["content_js"] = "qa_it_helpdesk_feedback_js.php";
			$data["agentUrl"] = "qa_it_helpdesk_feedback/agent_it_helpdesk_feedback_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			$campaign = $this->input->get('campaign');
			
			if($campaign!=''){
				
				$qSql="Select count(id) as value from qa_it_helpdesk_feedback_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_it_helpdesk_feedback_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate!="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_it_helpdesk_feedback_".$campaign."_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_it_helpdesk_feedback_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_it_helpdesk_feedback/agent_it_helpdesk_feedback_rvw.php";
			$data["content_js"] = "qa_it_helpdesk_feedback_js.php";
			$data["agentUrl"] = "qa_it_helpdesk_feedback/agent_it_helpdesk_feedback_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_it_helpdesk_feedback_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["agent_it_helpdesk_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data["campaign"]=$campaign;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_it_helpdesk_feedback_'.$campaign.'_feedback',$field_array1);
					
				redirect('Qa_it_helpdesk_feedback/agent_it_helpdesk_feedback_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
	
	
 }
?>