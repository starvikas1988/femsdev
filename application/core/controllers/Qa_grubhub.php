<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_grubhub extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_grubhub_model');
		
	 }
	 
   
	//////////////// management filtering data ////////////////////////
	public function management_sorting_feedback()
	{
		if(check_logged_in()){
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/management_feedback_review.php"; 
			
			
			$ticket_id = $this->input->get('ticket_id');
			$agent_id = $this->input->get('agent_id');
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_status = $this->input->get('agent_status');
			$mgnt_status = $this->input->get('mgnt_status');
			$tl_id = $this->input->get('tl_id');
			$critical_error = $this->input->get('critical_error');
			$non_critical_error = $this->input->get('non_critical_error');
			$was_concession = $this->input->get('was_concession');
			$follow_wiki = $this->input->get('follow_wiki');
			
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
				"ticket_id" => $ticket_id,
				"agent_id" => $agent_id,
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_status" => $agent_status,
				"mgnt_status" => $mgnt_status,
				"tl_id" => $tl_id,
				"critical_error" => $critical_error,
				"non_critical_error" => $non_critical_error,
				"was_concession" => $was_concession,
				"follow_wiki" => $follow_wiki,
				"current_user" => $current_user
			);	
			
			$data["get_management_review_list"] = $this->Qa_grubhub_model->get_management_review_data($field_array);
			
			/* if(get_role_dir()!="agent"){
				$data["get_management_review_list"] = $this->Qa_grubhub_model->get_management_review_data($field_array);
			}else{
				if($this->input->get('btnView')=='View'){
					$data["get_management_review_list"] = $this->Qa_grubhub_model->get_agent_review_data($field_array);
				}else{
					$data["get_management_review_list"] = $this->Qa_grubhub_model->get_agent_not_review_data($current_user);
				}
			} */
			
			$data["get_name"] = $this->Qa_grubhub_model->get_agent_id(6,15);
			$data["get_tl"] = $this->Qa_grubhub_model->get_tl_name();	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["agent_status"] = $agent_status;
			$data["mgnt_status"] = $mgnt_status;
			$data["ticket_id"] = $ticket_id;
			$data["tl_id"] = $tl_id;
			$data["critical_error"] = $critical_error;
			$data["non_critical_error"] = $non_critical_error;
			$data["was_concession"] = $was_concession;
			$data["follow_wiki"] = $follow_wiki;
			
			
			$this->load->view('dashboard',$data);
		}
	}

///* review page of the feedback management portal *///
	
	
	public function management_status_form($id)
	{
		if(check_logged_in())
		{
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/management_status_form.php"; 
			
			
			$data["get_agent_id_list"] = $this->Qa_grubhub_model->get_agent_id(6,15);
			$data["get_tl_id_list"] = $this->Qa_grubhub_model->get_tl_id();
			
			////ajax portion start////
			$qSql="Select id,description from qa_grubhub_master_primary_reason where is_active='1' order by description asc";
			$data["prim_reason"]= $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from qa_grubhub_category where is_active='1' order by description asc";
			$data["category_reason"]= $this->Common_model->get_query_result_array($qSql);
			////ajax portion end////
			
			$data["get_view_feedback_entry"] = $this->Qa_grubhub_model->view_feedback_entry_data($id);
			
			$data["fid"]=$id;
			
			$data["row1"] = $this->Qa_grubhub_model->view_agent_review_data($id);//AGENT PURPOSE
			
			$data["row2"] = $this->Qa_grubhub_model->view_management_review_data($id);//MGNT PURPOSE
			
			//print_r($data["row2"]);
			
			
			if($this->input->post('btnSave')=='SAVE')
			{
				
				$fd_id=$this->input->post('fd_id');
				
				
				$field_array=array(
					"fd_id" => $fd_id,
					"mgnt_review_date" => mmddyy2mysql($this->input->post('mgnt_review_date')),
					"mgnt_status" => $this->input->post('mgnt_status'),
					"coach_name" => $this->input->post('coach_name'),
					"note" => $this->input->post('note'),
					"log" => get_logs()
				);
				
				if($this->input->post('action')==''){
					
					$this->Qa_grubhub_model->data_insert_mgnt_feedback_entry($field_array);
					
				}else{
					
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_grubhub_mgnt_review',$field_array );
				}
				
				
				redirect('qa_grubhub/management_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
	
///* add management page of the feedback management portal *///	
	
	public function management_feedback_entry()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["get_agent_id_list"] = $this->Qa_grubhub_model->get_agent_id(6,15);
			$data["get_tl_id_list"] = $this->Qa_grubhub_model->get_tl_id();
			
			$data["get_agent_accure_reason"] = $this->Qa_grubhub_model->agent_accure_reason();
			$data["get_non_agent_accure_reason"] = $this->Qa_grubhub_model->non_agent_accure_reason();
			$data["get_non_critical_reason"] = $this->Qa_grubhub_model->non_critical_reason();
			$data["get_busi_critical_reason"] = $this->Qa_grubhub_model->busi_critical_reason();
			
			$data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_grubhub/management_feedback_entry.php"; 
			
			
			$qSql="Select id,description from qa_grubhub_master_primary_reason where is_active='1' order by description asc";
			$data["prim_reason"]= $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from qa_grubhub_category where is_active='1' order by description asc";
			$data["category_reason"]= $this->Common_model->get_query_result_array($qSql);
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
						
			global $a;
			global $a1;
			global $b;
			global $c;
			
			if($this->input->post('auditor_name'))
			{
				  
				if(is_array($this->input->post('agent_critical_reason'))){
					 $a= implode(",",$this->input->post('agent_critical_reason'));
				}else{
					  $a= $this->input->post('agent_critical_reason');
				}
				
				if(is_array($this->input->post('non_agent_critical_reason'))){
					 $a1= implode(",",$this->input->post('non_agent_critical_reason'));
				}else{
					  $a1= $this->input->post('non_agent_critical_reason');
				}
				
				if(is_array($this->input->post('non_critical_reason'))){
					 $b= implode(",",$this->input->post('non_critical_reason'));
				}else{
					$b = $this->input->post('non_critical_reason');
				}
				
				if(is_array($this->input->post('busi_critical_reason'))){
					 $c= implode(",",$this->input->post('busi_critical_reason'));
				}else{
					$c = $this->input->post('busi_critical_reason');
				}
				
				
				
				 $field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_type" => $this->input->post('audit_type'),
					"ticket_id" => $this->input->post('ticket_id'),
					"chat_date" => mmddyy2mysql($this->input->post('chat_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"office" => $this->input->post('off_id'),
					"reason_for_chat" => $this->input->post('reason_for_chat'),
					"reason_for_chat_s" => $this->input->post('reason_for_chat_s'),
					"critical_error" => $this->input->post('critical_error'),
					"rel_critical_error" => $this->input->post('rel_critical_error'),
					"agent_critical_reason" => $a,
					"non_agent_critical_reason" => $a1,
					"non_critical_error" => $this->input->post('non_critical_error'),
					"non_critical_reason" => $b,
					"busi_critical" => $this->input->post('busi_critical'),
					"busi_critical_reason" => $c,
					"critical_accuracy" => $this->input->post('critical_accuracy'),
					"critical_accuracy_reason" => $this->input->post('critical_accuracy_reason'),
					"was_critical_fail" => $this->input->post('was_critical_fail'),
					"follow_wiki" => $this->input->post('follow_wiki'),
					"wiki_link" => $this->input->post('wiki_link'),
					"wiki_link_text" => $this->input->post('wiki_link_text'),
					"was_concession" => $this->input->post('was_concession'),
					"should_concession" => $this->input->post('should_concession'),
					"correct_concession" => $this->input->post('correct_concession'),
					"concession_amount" => $this->input->post('concession_amount'),
					"correct_concession_amount" => $this->input->post('correct_concession_amount'),
					"overall_score" => $this->input->post('overall_score'),
					"mishandled" => $this->input->post('mishandled'),
					"category" => $this->input->post('category'),
					"sub_category" => $this->input->post('sub_category'),
					"step_to_follow" => $this->input->post('step_to_follow'),
					"step_score" => $this->input->post('step_score'),
					"preparation" => $this->input->post('preparation'),
					"greeting" => $this->input->post('greeting'),
					"owndership" => $this->input->post('owndership'),
					"solving_problem" => $this->input->post('solving_problem'),
					"start_wrapping" => $this->input->post('start_wrapping'),
					"end_possitive_note" => $this->input->post('end_possitive_note'),
					"chat_transcript" => $this->input->post('chat_transcript'),
					"qa_comment" => $this->input->post('qa_comment'),
					"entry_by" => $current_user,
					"status" => 1,
					"log" => get_logs()
				);
				
			$data["insert_feedback_entry"] = $this->Qa_grubhub_model->data_insert_feedback_entry($field_array); 
			redirect('qa_grubhub/management_sorting_feedback');
			}

			$this->load->view('dashboard',$data); 
			
			
		}
	}
	
	
	public function getSecondaryReasonList()
	{
		if(check_logged_in())
		{
			$pid=$this->input->post('pid');
			$qSql="Select id,description from qa_grubhub_master_secondary_reason where pid='$pid' and is_active='1' order by description asc";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}
	}
	
	
	public function getSubcategory()
	{
		if(check_logged_in())
		{
			$cid=$this->input->post('cid');
			$qSql="Select id,description from qa_grubhub_subcategory where cid='$cid' and is_active='1' order by description asc";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}
	}
	
	public function getTLname()
	{
		if(check_logged_in())
		{
			$aid=$this->input->post('aid');
			
			$qSql = "SELECT assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name FROM signin m where id = '$aid' and status='1' ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	public function getOfficeName()
	{
		if(check_logged_in())
		{
			$aid=$this->input->post('aid');
			
			$qSql = "SELECT office_id, (select location from office_location o where o.abbr=m.office_id) as office_name FROM signin m where id = '$aid' and status='1' ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
/////////////////////////////////	

//////////////////Agent QA Feedback///////////////////////

	public function agent_sorting_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/agent_feedback_review.php"; 
			$data["agentUrl"] = "qa_grubhub/agent_sorting_feedback"; 
			
			$qSql="Select count(id) as value from qa_grubhub_feedback where agent_id = '$current_user' ";
			$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_grubhub_feedback where id not in (select fd_id from qa_grubhub_agent_review ) and agent_id='$current_user'";
			$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
			
			$ticket_id="";
			$agent_status="";
			$mgnt_status="";
			$critical_error="";
			$non_critical_error="";
			$was_concession="";
			$follow_wiki="";
			
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
			
			
		if($this->input->get('btnView')=='View')
		{
			$ticket_id = $this->input->get('ticket_id');
			$agent_status = $this->input->get('agent_status');
			$mgnt_status = $this->input->get('mgnt_status');
			$critical_error = $this->input->get('critical_error');
			$non_critical_error = $this->input->get('non_critical_error');
			$was_concession = $this->input->get('was_concession');
			$follow_wiki = $this->input->get('follow_wiki');
			
			$current_user = get_user_id();
			
				$field_array = array(
					"ticket_id" => $ticket_id,
					"agent_status" => $agent_status,
					"mgnt_status" => $mgnt_status,
					"from_date"=>$from_date,
					"to_date" => $to_date,
					"critical_error" => $critical_error,
					"non_critical_error" => $non_critical_error,
					"was_concession" => $was_concession,
					"follow_wiki" => $follow_wiki,
					
					"current_user" => $current_user
					
				);

				$data["get_agent_review_list"] = $this->Qa_grubhub_model->get_agent_review_data($field_array);	
				
		}	else{
				
				$data["get_agent_review_list"] = $this->Qa_grubhub_model->get_agent_not_review_data($current_user);	
				
		}
			
			$data["ticket_id"] = $ticket_id;
			$data["agent_status"] = $agent_status;
			$data["mgnt_status"] = $mgnt_status;
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["critical_error"] = $critical_error;
			$data["non_critical_error"] = $non_critical_error;
			$data["was_concession"] = $was_concession;
			$data["follow_wiki"] = $follow_wiki;
			
			
			//$data["get_name"] = $this->Qa_grubhub_model->get_agent_fullname();
			
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
///* review page of the feedback agent portal *///

	public function agent_status_form($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/agent_status_form.php"; 
			/* $data["page_title"] = "Agent Review ";
			$data["breadcrumbs"] = array(
										"Home" => base_url().get_controller()."/dashboard",
										"Feedback" => base_url()."agent/agent_sorting_feedback/",
									); */	
			
			$data["fid"]=$id;
			
			$data["row1"] = $this->Qa_grubhub_model->view_agent_review_data($id);//AGENT PURPOSE
			
			$data["row2"] = $this->Qa_grubhub_model->view_management_review_data($id);//MGNT PURPOSE
			
			$data["get_view_feedback_entry"] = $this->Qa_grubhub_model->view_feedback_entry_data_agent($id);//all agent data 
			
			if($this->input->post('btnSave')=='SAVE')
			{
				$fd_id=$this->input->post('fd_id');
				
				$field_array=array(
					"fd_id" => $fd_id,
					"review_date" => mmddyy2mysql($this->input->post('review_date')),
					"agent_status" => $this->input->post('agent_status'),
					"note" => $this->input->post('note')
				);
				
				if($this->input->post('action')==''){
					
					$this->Qa_grubhub_model->data_insert_agent_feedback_entry($field_array);
					
				}else{
					
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_grubhub_agent_review',$field_array );
				}
				
				redirect('qa_grubhub/agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////////
	//////////////////////////// KPI Feedback //////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	
	public function kpi_feedback_entry()
	{
		if(check_logged_in())
		{
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/kpi_feedback_entry.php"; 
			
			$data["get_agent_id_list"] = $this->Qa_grubhub_model->get_agent_id(6,15);
			$data["get_kpi_reason"] = $this->Qa_grubhub_model->get_kpi_reason_list();
			
			$current_user=get_user_id();
			$logs=get_logs();
			
			global $x;
			
			
			if($this->input->post('submit')== 'SAVE' )
			{
			
			/*------ KPI feedback attached part ------*/ 
				$config['upload_path'] = './uploads/kpi_feedback/';
				$config['allowed_types'] = 'doc|docx|pdf';
				$config['max_size']     = '100000';
				$config['max_width'] = '1024';
				$config['max_height'] = '768';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
						
				if (!$this->upload->do_upload('kpi_attached_file')){
					$error = $this->upload->display_errors();
					$data['message'] = $error;
				}else{
					$_kpi_file = $this->upload->data();
				}
			
				
				
				if(is_array($this->input->post('agent_id'))){
					 $agentName= implode(",",$this->input->post('agent_id'));
				}else{
					  $agentName= $this->input->post('agent_id');
				}
				
				if(is_array($this->input->post('feedback_reason'))){
					 $feedbackReason= implode(",",$this->input->post('feedback_reason'));
				}else{
					  $feedbackReason= $this->input->post('feedback_reason');
				}
				
				
				$field_array=array(
					"agent_id" => $agentName,
					"tl_id" => $this->input->post('tl_name'),
					"feedback_date" => mmddyy2mysql($this->input->post('feedback_date')),
					"feedback_type" => $this->input->post('feedback_type'),
					"feedback_reason" => $feedbackReason,
					"kpi_attached_file" => $_kpi_file['file_name'],
					"agent_feedback" => $this->input->post('agent_feedback'),
					"tl_feedback" => $this->input->post('tl_feedback'),
					"coached_by" => $this->input->post('coached_by'),
					"entry_by" => $current_user,
					"status" => 1,
					"log" => $logs
				);
				$data["insert_feedback_entry"] = $this->Qa_grubhub_model->kpi_insert_feedback_entry($field_array); 
				redirect('qa_grubhub/kpi_feedback_entry');
			}	
			
			$this->load->view('dashboard',$data); 
		}	
	}
	
	
	
	public function get_TL_name()
	{
		if(check_logged_in())
		{
			$aid= implode(",",$this->input->post('agent_id'));
			
			 $qSql = "SELECT distinct (assigned_to),(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name FROM signin m where id in ($aid) and status='1' ";
			
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
////////////////////////////	
	
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////  Real Time CSAT ///////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	
	
	public function management_realtime_csat()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/management_realtime_csat.php"; 
			
			$chat_date = $this->input->get('chat_date');
			$agent_id = $this->input->get('agent_id');
			$tl_id = $this->input->get('tl_id');
			$category = $this->input->get('category');
			
			if($chat_date==""){ 
				$chat_date=CurrDate();
			}else{
				$chat_date = mmddyy2mysql($chat_date);
			}
			
			
			$field_array = array
			(
				"chat_date" => $chat_date,
				"agent_id" => $agent_id,
				"tl_id" => $tl_id,
				"category" => $category
			);	
			
			
			
			$data["get_name"] = $this->Qa_grubhub_model->get_agent_fullname();
			$data["get_tl"] = $this->Qa_grubhub_model->get_tl_name();
			$data["get_category"] = $this->Qa_grubhub_model->get_csat_category();
			
			$data["get_realtime_csat"] = $this->Qa_grubhub_model->get_management_real_time_csat($field_array);
			
			$data["chat_date"] = $chat_date;
			$data["agent_id"] = $agent_id;
			$data["tl_id"] = $tl_id;
			$data["category"] = $category;
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	public function real_time_csat()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/real_time_csat.php"; 
			
			$data["get_agent_id_list"] = $this->Qa_grubhub_model->get_agent_id(6,15);
			$data["get_real_time_category"] = $this->Qa_grubhub_model->real_time_category();
			
			$current_user=get_user_id();
			$logs=get_logs();
			
			if($this->input->post('submit')== 'SAVE' )
			{
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"chat_date" => mmddyy2mysql($this->input->post('chat_date')),
					"ticket_id" => $this->input->post('ticket_id'),
					"category" => $this->input->post('category'),
					"sub_category" => $this->input->post('sub_category'),
					"true_reason" => $this->input->post('true_reason'),
					"is_coached" => $this->input->post('is_coached'),
					"coach_name" => $this->input->post('coach_name'),
					"coach_date" => mmddyy2mysql($this->input->post('coach_date')),
					"evaluator" => $this->input->post('evaluator'),
					"evaluator_comment" => $this->input->post('evaluator_comment'),
					"customer_comment" => $this->input->post('customer_comment'),
					"coach_comment" => $this->input->post('coach_comment'),
					"status" => 1,
					"entry_by" => $current_user,
					"log" => $logs
				);
				$data["insert_real_time"] = $this->Qa_grubhub_model->real_time_csat_entry($field_array); 
				redirect('qa_grubhub/management_realtime_csat');
				
			}	
			
			$this->load->view('dashboard',$data); 
		}	
	}
	
	
	public function edit_real_time_csat_form($id)
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_grubhub/edit_realtime_csat.php"; 
			
			$data["get_agent_id_list"] = $this->Qa_grubhub_model->get_agent_id(6,15);
			$data["get_real_time_category"] = $this->Qa_grubhub_model->real_time_category();
			
			
			$data["edit_real_time_status"] = $this->Qa_grubhub_model->view_real_time_csat($id);
			
			$current_user=get_user_id();
			$logs=get_logs();
			
			
			if($this->input->post('submit')== 'SAVE' )
			{
				$real_time_id = $this->input->post('real_time_id');
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"chat_date" => mmddyy2mysql($this->input->post('chat_date')),
					"ticket_id" => $this->input->post('ticket_id'),
					"category" => $this->input->post('category'),
					"sub_category" => $this->input->post('sub_category'),
					"true_reason" => $this->input->post('true_reason'),
					"is_coached" => $this->input->post('is_coached'),
					"coach_name" => $this->input->post('coach_name'),
					"coach_date" => $this->input->post('coach_date'),
					"evaluator" => $this->input->post('evaluator'),
					"evaluator_comment" => $this->input->post('evaluator_comment'),
					"customer_comment" => $this->input->post('customer_comment'),
					"coach_comment" => $this->input->post('coach_comment'),
					"status" => 1,
					"entry_by" => $current_user,
					"log" => $logs
				);
				$this->db->where('id', $real_time_id);
				$this->db->update('qa_grubhub_real_time_csat', $field_array);
				
				redirect('qa_grubhub/management_realtime_csat');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
    
	
	
	public function get_sub_category()
	{
		if(check_logged_in())
		{
			$catid=$this->input->post('catid');
			$qSql="Select id,description from qa_grubhub_real_time_sub_category where real_time_cat_id='$catid' and is_active='1' order by description asc";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	public function get_real_time_true_reason()
	{
		if(check_logged_in())
		{
			$sub_catid=$this->input->post('sub_catid');
			$qSql="Select id,description from qa_grubhub_real_time_true_reason where real_time_subcat_id='$sub_catid' and is_active='1' order by description asc";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
////////////////////////////	
	
	
	
	
}

?>