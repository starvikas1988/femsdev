<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_RPM_Sentry extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_RPM_Sentry_model');
    }
    

    public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
            $qSql = "Select s.id, s.assigned_to,  CONCAT(s1.fname,' ' ,s1.lname) as tl_name, 
            s.fusion_id, get_process_names(s.id) as process_name FROM signin s 
            left join signin s1 on s1.id = s.assigned_to where s.id ='$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	 

    public function index()
	{
		if(check_logged_in()){
            redirect('/Qa_RPM_Sentry/rpm', 'refresh');
        }
    }

	public function rpm()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/qa_rpm.php"; 
			
			$from_date = $this->input->get('from_date');
			$to_date = 	$this->input->get('to_date');
			$agent = $this->input->get('agent');
			
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
						
			$data["from_date"] 	= $from_date;
            $data["to_date"] 	= $to_date;
            $data["agent"] 	= $agent;
            
			$rpm_data =	$this->Qa_RPM_Sentry_model->get_rpm_data($from_date,$to_date,$agent,$current_user);
			$data['rpm_data'] =	$rpm_data;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			$this->load->view('dashboard',$data);
		}
    }

    public function add_rpm_form(){
        if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/add_rpm_form.php"; 
			
            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
            $data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			
			$curDateTime=CurrMySqlDate();
			
            if($this->input->post('save_button')=='save'){
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					//"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_type" => $this->input->post('call_type'),
					"disposition_type" => $this->input->post('disposition_type'),
					"overall_score" => number_format($this->input->post('total_score'),2),
					"total_score_count" => $this->input->post('total_score_count'),
					"customer_information" => $this->input->post('customer_information'),
					"voice_delivery" => $this->input->post('voice_delivery'),
					"communication_skills" => $this->input->post('communication_skills'),
					"customer_service" => $this->input->post('customer_service'),
					"disposition" => $this->input->post('disposition'),
					"transfer" => $this->input->post('transfer'),
					"protocol" => $this->input->post('protocol'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
                );
				
                data_inserter('qa_rpm', $_field_array);
				redirect(base_url().'Qa_RPM_Sentry/rpm/','refresh');
            }
            $this->load->view('dashboard',$data);
        }
    }
    
	public function edit_rpm()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/edit_rpm_form_rvw.php"; 
			
            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$rpmId	=	$this->uri->segment(3);
			$curDateTime=CurrMySqlDate();
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
            $data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			$rpmSQL = "SELECT * FROM qa_rpm WHERE id='$rpmId'";
			$data["rpm_detail"] = $this->Common_model->get_query_result_array($rpmSQL);
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_rpm_agent_rvw($rpmId);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_rpm_mgnt_rvw($rpmId);//MGNT PURPOSE
			
            if($this->input->post('update_button')=='update'){
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					//"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_type" => $this->input->post('call_type'),
					"disposition_type" => $this->input->post('disposition_type'),
					"overall_score" => $this->input->post('total_score'),
					"total_score_count" => $this->input->post('total_score_count'),
					"customer_information" => $this->input->post('customer_information'),
					"voice_delivery" => $this->input->post('voice_delivery'),
					"communication_skills" => $this->input->post('communication_skills'),
					"customer_service" => $this->input->post('customer_service'),
					"disposition" => $this->input->post('disposition'),
					"transfer" => $this->input->post('transfer'),
					"protocol" => $this->input->post('protocol'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
                );
				$this->db->update('qa_rpm', $_field_array, array('id' => $rpmId));
				////////////	
				$field_array1=array(
					"fd_id" => $rpmId,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_rpm_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rpmId);
					$this->db->update('qa_rpm_mgnt_rvw',$field_array1);
				}
				///////////	
				redirect(base_url().'Qa_RPM_Sentry/rpm/','refresh');
            }
            $this->load->view('dashboard',$data);
        }
	}
	
	public function rpm_dashboard()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/rpm_dashboard.php"; 
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent = $this->input->get('agent');
			
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
						
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			if($this->input->get('agent'))
			{
				$rpm_data =	$this->Qa_RPM_Sentry_model->get_rpm_data($from_date,$to_date,$agent);
				$data['rpm_data'] = $rpm_data;
			}
			else
			{
				$data['rpm_data'] = array();
			}
			$this->load->view('dashboard',$data);
		}
	}
	
    public function sentry()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/sentry.php"; 
			$from_date = $this->input->get('from_date');
			$to_date = 	$this->input->get('to_date');
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
			$agent = $this->input->get('agent');			
			$data["from_date"] 	= $from_date;
            $data["to_date"] 	= $to_date;
			$data["agent"] 	= $agent;
			$sentry_data =	$this->Qa_RPM_Sentry_model->get_sentry_data($from_date,$to_date,$agent,$current_user);
			$data['sentry_data'] =	$sentry_data;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			$this->load->view('dashboard',$data);
		}
	}
	
	public function add_sentry()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/add_sentry_form.php"; 

            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$curDateTime=CurrMySqlDate();
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			if($this->input->post('save_button')=='save'){
				$caller_date = $this->input->post('caller_date');
				if($this->input->post('audit_result') == "YES"){
					$audit_result = 1;
				}
				else{
					$audit_result = 0;
				}
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => mmddyy2mysql($this->input->post('caller_date')),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"audit_result" => $audit_result,
					"overall_score" => number_format($this->input->post('total_score'),2),
					"total_score_count" => $this->input->post('total_score_count'),
					"verified_consumer" => $this->input->post('verified_consumer'),
					"advise_recording" => $this->input->post('advise_recording'),
					"professional" => $this->input->post('professional'),
					"speech" => $this->input->post('speech'),
					"objections" => $this->input->post('objections'),
					"fluidity" => $this->input->post('fluidity'),
					"experience" => $this->input->post('experience'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
                );

                data_inserter('qa_sentry', $_field_array);
				redirect(base_url()."Qa_RPM_Sentry/sentry/","refresh");
            }
			$this->load->view('dashboard',$data);
		}
	}
	
	public function edit_sentry()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/edit_sentry_form_rvw.php"; 

            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$sentryId	=	$this->uri->segment(3);
			$curDateTime=CurrMySqlDate();
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			$sentrySQL = "SELECT * FROM qa_sentry WHERE id=$sentryId";
			$data['sentry_detail'] = $this->Common_model->get_query_result_array($sentrySQL);
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_sentry_agent_rvw($sentryId);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_sentry_mgnt_rvw($sentryId);//MGNT PURPOSE
			if($this->input->post('update_button')=='update'){
				$caller_date = $this->input->post('caller_date');
				if($this->input->post('audit_result') == "YES"){
					$audit_result = 1;
				}
				else{
					$audit_result = 0;
				}
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => $this->input->post('caller_date'),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"audit_result" => $audit_result,
					"overall_score" => number_format($this->input->post('total_score'),2),
					"total_score_count" => $this->input->post('total_score_count'),
					"verified_consumer" => $this->input->post('verified_consumer'),
					"advise_recording" => $this->input->post('advise_recording'),
					"professional" => $this->input->post('professional'),
					"speech" => $this->input->post('speech'),
					"objections" => $this->input->post('objections'),
					"fluidity" => $this->input->post('fluidity'),
					"experience" => $this->input->post('experience'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
                );
				$this->db->update('qa_sentry', $_field_array, array('id' => $sentryId));
				////////////	
				$field_array1=array(
					"fd_id" => $sentryId,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_sentry_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $sentryId);
					$this->db->update('qa_sentry_mgnt_rvw',$field_array1);
				}
				///////////	
				redirect(base_url().'Qa_RPM_Sentry/sentry/','refresh');
			}
			$this->load->view('dashboard',$data);
		}
	}
	public function sentry_dashboard()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/sentry_dashboard.php"; 
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent = $this->input->get('agent');
			
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
						
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			if($this->input->get('agent'))
			{
				$sentry_data =	$this->Qa_RPM_Sentry_model->get_sentry_data($from_date,$to_date,$agent);
				$data['sentry_data'] = $sentry_data;
			}
			else
			{
				$data['sentry_data'] = array();
			}
			$this->load->view('dashboard',$data);
		}
	}
	/******************Agent Feedback********************/
	public function agent_rpm_feedback()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_rpm_feedback.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_rpm_feedback";
			
			
			$qSql="Select count(id) as value from qa_rpm where agent_id='$current_user'";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_rpm where id  not in (select fd_id from qa_rpm_agent_rvw ) and agent_id='$current_user'";
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

				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_rpm_agent_review_data($field_array);
					
			 }else{	
				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_rpm_agent_not_review_data($current_user);			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function agent_rpm_feedback_rvw($id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_rpm_feedback_rvw.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_rpm_feedback";
						
			$data["get_rpm_feedback"] = $this->Qa_RPM_Sentry_model->view_rpm_feedback($id);
			
			$data["rdid"]=$id;
			
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_rpm_agent_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_rpm_mgnt_rvw($id);//MGNT PURPOSE
			
		
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
					$rowid= data_inserter('qa_rpm_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rd_id);
					$this->db->update('qa_rpm_agent_rvw',$field_array1);
				}	
				redirect('Qa_RPM_Sentry/agent_rpm_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	public function agent_sentry_feedback()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_sentry_feedback.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_sentry_feedback";
			
			
			$qSql="Select count(id) as value from qa_sentry where agent_id='$current_user'";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_sentry where id  not in (select fd_id from qa_sentry_agent_rvw ) and agent_id='$current_user'";
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

				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_sentry_agent_review_data($field_array);
					
			 }else{	
				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_sentry_agent_not_review_data($current_user);			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function agent_sentry_feedback_rvw($id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_sentry_feedback_rvw.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_sentry_feedback";
						
			$data["get_sentry_feedback"] = $this->Qa_RPM_Sentry_model->view_sentry_feedback($id);
			
			$data["rdid"]=$id;
			
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_sentry_agent_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_sentry_mgnt_rvw($id);//MGNT PURPOSE
			
		
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
					$rowid= data_inserter('qa_sentry_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rd_id);
					$this->db->update('qa_sentry_agent_rvw',$field_array1);
				}	
				redirect('Qa_RPM_Sentry/agent_sentry_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	/****************QA RPM Report*****************/
	
	public function qa_rpm_report()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_rpm_sentry/qa_rpm_report.php";
			$from_date="";
			$to_date="";
			$action="";
			$agent ="";
			$dn_link="";
			$rpm_data = array();
			
			if($this->input->get('show')=='Show')
			{
				$from_date = $this->input->get('from_date');
				$to_date = $this->input->get('to_date');
				$agent = $this->input->get('agent');
				if($from_date!="" && $to_date!="")
				{
					$rpm_data =	$this->Qa_RPM_Sentry_model->qa_rpm_report(mmddyy2mysql($from_date),mmddyy2mysql($to_date),$agent,$current_user);
				}
				$this->create_qa_rpm_CSV($rpm_data);
				$dn_link = base_url()."Qa_RPM_Sentry/download_qa_rpm_CSV";
			}
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data['rpm_data'] =	$rpm_data;
			$data['download_link']=$dn_link;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			$this->load->view('dashboard',$data);
		}
	}
	/****************QA RPM CSV Generator*****************/
	public function create_qa_rpm_CSV($rr)
	{
		$filename = "./assets/reports/qa_rpm_report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date","Audit Time","Agent","Audit Type","VOC","Caller Title","Caller Name","Caller Phone","Call Type","Disposition Type","Total Score","Total Score Count","Customer Information/Opening","Voice Delivery","Communication Skills","Customer Service","Disposition","Transfer","Protocol","Call Summary","Feedback");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $rdata)
		{	
			$row = '"'.$rdata['auditor_name'].'",';
			$row .= '"'.$rdata['audit_date'].'",';
			$row .= '"'.$rdata['audit_time'].'",';
			$row .= '"'.$rdata['agent_name'].'",';
			$row .= '"'.$rdata['audit_type'].'",';
			$row .= '"'.$rdata['voc'].'",';
			$row .= '"'.$rdata['caller_title'].'",';
			$row .= '"'.$rdata['caller_name'].'",';
			$row .= '"'.$rdata['caller_phone'].'",';
			$row .= '"'.$rdata['call_type'].'",';
			$row .= '"'.$rdata['disposition_type'].'",';
			$row .= '"'.$rdata['overall_score'].'",';
			$row .= '"'.$rdata['total_score_count'].'",';
			$row .= '"'.$rdata['customer_information'].'",';
			$row .= '"'.$rdata['voice_delivery'].'",';
			$row .= '"'.$rdata['communication_skills'].'",';
			$row .= '"'.$rdata['customer_service'].'",';
			$row .= '"'.$rdata['disposition'].'",';
			$row .= '"'.$rdata['transfer'].'",';
			$row .= '"'.$rdata['protocol'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['feedback'])).'"';	
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	public function download_qa_rpm_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/qa_rpm_report".get_user_id().".csv";
		$newfile="QA RPM List-".$currDate.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	/****************QA Sentry Report*****************/
	public function qa_sentry_report()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_rpm_sentry/qa_sentry_report.php";
			
			$from_date="";
			$to_date="";
			$action="";
			$agent ="";
			$dn_link="";
			$sentry_data = array();
			
			if($this->input->get('show')=='Show')
			{
				$from_date = $this->input->get('from_date');
				$to_date = $this->input->get('to_date');
				$agent = $this->input->get('agent');
				if($from_date!="" && $to_date!="")
				{
					$sentry_data =	$this->Qa_RPM_Sentry_model->qa_sentry_report(mmddyy2mysql($from_date),mmddyy2mysql($to_date),$agent,$current_user);
				}
				$this->create_qa_sentry_CSV($sentry_data);
				$dn_link = base_url()."Qa_RPM_Sentry/download_qa_sentry_CSV";
			}
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data['sentry_data'] =	$sentry_data;
			$data['download_link']=$dn_link;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			$this->load->view('dashboard',$data);
		}
	}
	/****************QA Sentry CSV Generator*****************/
	public function create_qa_sentry_CSV($rr)
	{
		$filename = "./assets/reports/qa_sentry_report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date","Audit Time","Agent","Audit Type","VOC","Caller Name","Caller Date","Caller Phone","Audit Result","Total Score","Total Score Count","Verified Consumer","Advise Recording","Professional","Speech","Objections","Fluidity","Experience","Call Summary","Feedback");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $rdata)
		{	
		
			
			$row = '"'.$rdata['auditor_name'].'",';
			$row .= '"'.$rdata['audit_date'].'",';
			$row .= '"'.$rdata['audit_time'].'",';
			$row .= '"'.$rdata['agent_name'].'",';
			$row .= '"'.$rdata['audit_type'].'",';
			$row .= '"'.$rdata['voc'].'",';
			$row .= '"'.$rdata['caller_name'].'",';
			$row .= '"'.$rdata['caller_date'].'",';
			$row .= '"'.$rdata['caller_phone'].'",';
			$row .= '"'.$rdata['audit_result'].'",';
			$row .= '"'.$rdata['overall_score'].'",';
			$row .= '"'.$rdata['total_score_count'].'",';
			$row .= $rdata['verified_consumer']==0?'"No",':'"Yes",';
			$row .= $rdata['advise_recording']==0?'"No",':'"Yes",';
			$row .= '"'.$rdata['professional'].'",';
			$row .= '"'.$rdata['speech'].'",';
			$row .= '"'.$rdata['objections'].'",';
			$row .= '"'.$rdata['fluidity'].'",';
			$row .= '"'.$rdata['experience'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['feedback'])).'"';	
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	public function download_qa_sentry_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/qa_sentry_report".get_user_id().".csv";
		$newfile="QA Sentry List-".$currDate.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
}