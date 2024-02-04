<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Feedback_review_model');
		$this->load->model('Feedback_model');
		
	 }
	
	//////////////// management filtering data ////////////////////////
	public function management_sorting_feedback()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "feedback/management_feedback_review.php"; 
			
			$data["page_title"] = "Management Feedback Review";
			$data["breadcrumbs"] = array(
										"Home" => base_url().get_controller()."/dashboard",
										//"Feedback" => base_url()."feedback/",
									);
									
			
			$ticket_id = $this->input->get('ticket_id');
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			
			if($from_date=="") $from_date=CurrDate();
			if($to_date=="") $to_date=CurrDate();
			
			$field_array = array
			(
				"ticket_id" => $ticket_id,
				"from_date"=>$from_date,
				"to_date" => $to_date,
			);	
			
			
			
			/*$data["get_name"] = $this->Feedback_review_model->get_agent_fullname();
			$data["get_tl"] = $this->Feedback_review_model->get_tl_name();	 */
			
			$data["get_management_review_list"] = $this->Feedback_review_model->get_management_review_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["ticket_id"] = $ticket_id;
			
			$this->load->view('dashboard',$data);
		}
	}

///* review page of the feedback management portal *///
	
	
	public function management_status_form($id)
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "feedback/management_status_form.php"; 
			$data["page_title"] = "Management Status Form";
			$data["breadcrumbs"] = array(
										"Home" => base_url().get_controller()."/dashboard",
										"Feedback" => base_url()."feedback/management_sorting_feedback/",
									);	
			
			$data["get_agent_id_list"] = $this->Feedback_model->get_agent_id();
			$data["get_tl_id_list"] = $this->Feedback_model->get_tl_id();
			
			
			$data["get_view_feedback_entry"] = $this->Feedback_model->view_feedback_entry_data($id);
			
			$data["fid"]=$id;
			
			$data["row1"] = $this->Feedback_review_model->view_agent_review_data($id);//AGENT PURPOSE
			
			$data["row2"] = $this->Feedback_review_model->view_management_review_data($id);//MGNT PURPOSE
			
			
			if($this->input->post('btnSave')=='SAVE')
			{
				
				$oyo_fd_id=$this->input->post('oyo_fd_id');
				$curDateTime=date('Y-m-d h:i:sa');
				$log=get_logs();
				
				$field_array=array(
					"oyo_fd_id" => $oyo_fd_id,
					"mgnt_review_date" => $this->input->post('mgnt_review_date'),
					"coach_name" => $this->input->post('coach_name'),
					"note" => $this->input->post('mgnt_note'),
					"mgnt_status" => 1,
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"log" => $log
				);
				
				if($this->input->post('action')=='0'){
					
					$this->Feedback_review_model->data_insert_mgnt_feedback_entry($field_array);
					
				}else{
					
					$this->db->where('oyo_fd_id', $oyo_fd_id);
					$this->db->update('oyo_fd_mgnt_review',$field_array);
				}
				
				redirect('feedback/management_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
	
///* full view page of the feedback management portal [not required] *///	
	
	public function management_status_view($id)
	{
		if(check_logged_in())
		{
			
			$data["get_agent_id_list"] = $this->Feedback_model->get_agent_id();
			$data["get_tl_id_list"] = $this->Feedback_model->get_tl_id();
			
			$data["aside_template"] = get_aside_template();
            $data["content_template"] = "feedback/management_status_view.php"; 
			
			$data["page_title"] = "View Feedback";
			$data["breadcrumbs"] = array(
										"Home" => base_url().get_controller()."/dashboard",
										"Feedback" => base_url()."feedback/management_sorting_feedback/",
									);	
			$_page_url = base_url()."feedback_review/management_status_view";
			$data["get_view_feedback_entry"] = $this->Feedback_model->view_feedback_entry_data($id);
			$this->load->view('dashboard',$data);
			
		}
	}
////////////////////////////	
	
///* add management page of the OYO feedback management portal *///	
	
	public function management_feedback_entry()
	{
		if(check_logged_in())
		{
			
			$data["get_agent_id_list"] = $this->Feedback_model->get_agent_id();
			$data["get_tl_id_list"] = $this->Feedback_model->get_tl_id();
			
			$data["aside_template"] = get_aside_template();
            $data["content_template"] = "feedback/management_feedback_entry.php"; 
			
			$data["page_title"] = "Add Feedback";
			$data["breadcrumbs"] = array(
										"Home" => base_url().get_controller()."/dashboard",
										"Feedback" => base_url()."feedback/management_sorting_feedback/",
									);	
			$_page_url = base_url()."feedback_review/management_feedback_entry";
			
			
			$current_user=get_user_id();
			$curDateTime=date("Y-m-d h:i:sa");
			$log=get_logs();
			
			$cl_open_overall_score=(int)$this->input->post('cl_open_overall_score');
			$probing_overall_score=(int)$this->input->post('probing_overall_score');
			$soft_skill_overall_score=(int)$this->input->post('soft_skill_overall_score');
			$hold_dead_overall_score=(int)$this->input->post('hold_dead_overall_score');
			$resolution_fatal_overall_score=(int)$this->input->post('resolution_fatal_overall_score');
			$resolution_nonfatal_overall_score=(int)$this->input->post('resolution_nonfatal_overall_score');
			$fresh_desk_overall_score=(int)$this->input->post('fresh_desk_overall_score');
			$closing_overall_score=(int)$this->input->post('closing_overall_score');
			
			$o_score=$cl_open_overall_score + $probing_overall_score + $soft_skill_overall_score + $hold_dead_overall_score + $resolution_fatal_overall_score + $resolution_nonfatal_overall_score + $fresh_desk_overall_score + $closing_overall_score;
			
			if($resolution_fatal_overall_score==0 || $fresh_desk_overall_score==0 || $closing_overall_score==0){
				$overall_score=0;
			}else{
				$overall_score=$o_score;
			}
			
			if($this->input->post('auditor_name'))
			{
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => $this->input->post('audit_date'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"guest_phone" => $this->input->post('guest_phone'),
					"shift_timing" => $this->input->post('shift_timing'),
					"call_type" => $this->input->post('call_type'),
					"ticket_id" => $this->input->post('ticket_id'),
					"campaign" => $this->input->post('campaign'),
					"duration_length" => $this->input->post('duration_length'),
					"booking_id" => $this->input->post('booking_id'),
					"remarks" => $this->input->post('remarks'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"status" => 1,
					"log" => $log,
					"cl_open_5_sec" => $this->input->post('cl_open_5_sec'),
					"cl_open_self_intro" => $this->input->post('cl_open_self_intro'),
					"cl_open_overall_score" => $cl_open_overall_score,
					"probing_issue_indetify" => $this->input->post('probing_issue_indetify'),
					"probing_responce_positively" => $this->input->post('probing_responce_positively'),
					"probing_effective" => $this->input->post('probing_effective'),
					"probing_overall_score" => $probing_overall_score,
					"soft_skill_apology" => $this->input->post('soft_skill_apology'),
					"soft_skill_voice_intonation" => $this->input->post('soft_skill_voice_intonation'),
					"soft_skill_active_listening" => $this->input->post('soft_skill_active_listening'),
					"soft_skill_confidence" => $this->input->post('soft_skill_confidence'),
					"soft_skill_politeness" => $this->input->post('soft_skill_politeness'),
					"soft_skill_grammar" => $this->input->post('soft_skill_grammar'),
					"soft_skill_acknowledgement" => $this->input->post('soft_skill_acknowledgement'),
					"soft_skill_overall_score" => $soft_skill_overall_score,
					"hold_dead_ask_permission" => $this->input->post('hold_dead_ask_permission'),
					"hold_dead_unhold_procedure" => $this->input->post('hold_dead_unhold_procedure'),
					"hold_dead_took_guest_permission" => $this->input->post('hold_dead_took_guest_permission'),
					"hold_dead_do_not_refresh" => $this->input->post('hold_dead_do_not_refresh'),
					"hold_dead_avoid_dead_air" => $this->input->post('hold_dead_avoid_dead_air'),
					"hold_dead_overall_score" => $hold_dead_overall_score,
					"resolution_fatal_correct_booking" => $this->input->post('resolution_fatal_correct_booking'),
					"resolution_fatal_correct_information" => $this->input->post('resolution_fatal_correct_information'),
					"resolution_fatal_correct_refund" => $this->input->post('resolution_fatal_correct_refund'),
					"resolution_fatal_proper_follow_up" => $this->input->post('resolution_fatal_proper_follow_up'),
					"resolution_fatal_recon_adjustment" => $this->input->post('resolution_fatal_recon_adjustment'),
					"resolution_fatal_recon_adjustment" => $this->input->post('resolution_fatal_recon_adjustment'),
					"resolution_fatal_overall_score" => $resolution_fatal_overall_score,
					"resolution_nonfatal_gnc_closure" => $this->input->post('resolution_nonfatal_gnc_closure'),
					"resolution_nonfatal_duplicate_ticket" => $this->input->post('resolution_nonfatal_duplicate_ticket'),
					"resolution_nonfatal_ccb_process" => $this->input->post('resolution_nonfatal_ccb_process'),
					"resolution_nonfatal_case_library" => $this->input->post('resolution_nonfatal_case_library'),
					"resolution_nonfatal_email_to_sent" => $this->input->post('resolution_nonfatal_email_to_sent'),
					"resolution_nonfatal_overall_score" => $resolution_nonfatal_overall_score,
					"fresh_desk_complete_notes" => $this->input->post('fresh_desk_complete_notes'),
					"fresh_desk_tagging_issue" => $this->input->post('fresh_desk_tagging_issue'),
					"fresh_desk_incorrect_shifting" => $this->input->post('fresh_desk_incorrect_shifting'),
					"fresh_desk_correct_ticket_status" => $this->input->post('fresh_desk_correct_ticket_status'),
					"fresh_desk_did_agent_verify" => $this->input->post('fresh_desk_did_agent_verify'),
					"fresh_desk_agent_meet_compliant" => $this->input->post('fresh_desk_agent_meet_compliant'),
					"fresh_desk_overall_score" => $fresh_desk_overall_score,
					"closing_further_assistance" => $this->input->post('closing_further_assistance'),
					"closing_done_branding" => $this->input->post('closing_done_branding'),
					"closing_gsat_survey_pitched" => $this->input->post('closing_gsat_survey_pitched'),
					"closing_gsat_survey_avoidance" => $this->input->post('closing_gsat_survey_avoidance'),
					"closing_overall_score" => $closing_overall_score,
					"wow_factor_cl_take_positive" => $this->input->post('wow_factor_cl_take_positive'),
					"overall_result" => $this->input->post('overall_result'),
					"overall_score" => $overall_score
					
				);
				
			$data["insert_feedback_entry"] = $this->Feedback_model->data_insert_feedback_entry($field_array); 
			redirect('feedback/management_sorting_feedback');
			}

			$this->load->view('dashboard',$data); 
			
			
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
/////////////////////////////////		
	
	
	
	
}

?>