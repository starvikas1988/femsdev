<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('Feedback_review_model');
	}
	
		
	public function feedback()
	{
		
		if(check_logged_in()){
			
						
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
						
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$ticket_id="";
			$from_date="";
			$to_date="";
			
			$action="";
			$dn_link="";

			
			//$data["office_list"] = $this->Common_model->get_office_location_list();
			
			//$data["process_list"] = $this->Common_model->get_process_for_assign();
			
			
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "reports/feedback.php";
			$data["error"] = '';
			
			$data["page_title"] = "Feedback Report";
			$data["breadcrumbs"] = array(
				"Home" => base_url()."user/dashboard",
				"Feedback Reports" => base_url()."reports/feedback",
			);
			
			$data["get_review_list"]=array();
			
			/* $data["get_name"] = $this->Feedback_review_model->get_agent_fullname();
			$data["get_tl"] = $this->Feedback_review_model->get_tl_name(); */
			
			if($this->input->get('showReports')=='Show'){
				
				$ticket_id = $this->input->get('ticket_id');
				$from_date = $this->input->get('from_date');
				$to_date = $this->input->get('to_date');
				
				$field_array = array
				(
					"ticket_id"=>$ticket_id,
					"from_date"=>$from_date,
					"to_date" => $to_date,
				);	
				
				//$data["get_name"] = $this->Feedback_review_model->get_agent_fullname();
				//$data["get_tl"] = $this->Feedback_review_model->get_tl_name();	
				
				$fullArray=$this->Feedback_review_model->get_review_data($field_array);
				$data["get_review_list"] = $fullArray;
				
				$this->create_CSV($fullArray);
				
				$dn_link = base_url()."reports/downloadCsv";
					
				
			}
			
			$data['download_link']=$dn_link;
			
			$data["ticket_id"] = $ticket_id;
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$data["action"] = $action;
			
			$this->load->view('dashboard',$data);	
		}
	}
	
	
	public function downloadCsv()
	{		
		$curr_date=date('Y-m-d');
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="oyo_feedback_report'".$curr_date."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_CSV($rr)
	{
				
		$filename = "./assets/reports/Report".get_user_id().".csv";
		
		$fopen = fopen($filename,"w+");
	
		$header = array("Auditor", "Audit Date", "Ticket ID", "Agent", "TL", "Call Date/Time", "Guest Phone", "Shift Timing", "Call Type", "Campaign", "Length Duration", "Booking ID", "Overall Score", "Overall Result", "QA Remarks", "call Open 5sec", "call Open Self Intro", "call Open Score", "Probing Issue Indetify", "Probing Responce Positively", "Probing Effective", "Probing Score", "Soft Skill Apology", "Soft Skill Voice Intonation", "Soft Skill Active Listening", "Soft Skill Confidence", "Soft Skill Politeness", "Soft Skill Grammar", "Soft Skill Acknowledgement", "Soft Skill Score", "Hold Dead Ask Permission", "Hold Dead Unhold Procedure", "Hold Dead Took Guest Permission", "Hold Dead do not Refresh", "Hold Dead avoid Dead Air", "Hold Dead Score", "Resolution Fatal Correct Booking", "Resolution Fatal Correct Information", "Resolution Fatal Correct Refund", "Resolution Fatal Proper Follow up", "Resolution Fatal Recon Adjustment", "Resolution Fatal Score", "Resolution Nonfatal gnc Closure", "Resolution Nonfatal Duplicate Ticket", "Resolution Nonfatal ccb Process", "Resolution Nonfatal case Library", "Resolution Nonfatal Email to Sent", "Resolution Nonfatal Score", "Fresh Desk Complete Notes", "Fresh Desk Tagging Issue", "Fresh Desk Incorrect Shifting", "Fresh Desk Correct Ticket Status", "Fresh Desk did Agent Verify", "Fresh Desk Agent meet Compliant", "Fresh Desk Score", "Closing Further Assistance", "Closing Done Branding", "Closing gsat Survey Pitched", "Closing gsat Survey Avoidance", "Closing Score", "Wow Factor Call Take Positive", "Entry By", "Entry Date", "Agent Remarks", "Agent Review Date", "Mgnt Remarks", "Mgnt Review Date");
		
		
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['ticket_id'].'",'; 
			$row .= '"'.$user['agent_name'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['callDate'].'",';
			$row .= '"'.$user['guest_phone'].'",';
			$row .= '"'.$user['shift_timing'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['duration_length'].'",';
			$row .= '"'.$user['booking_id'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['overall_result'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks'])) .'",'; 			
			$row .= '"'.$user['cl_open_5_sec'].'",';
			$row .= '"'.$user['cl_open_self_intro'].'",';
			$row .= '"'.$user['cl_open_overall_score'].'",';
			$row .= '"'.$user['probing_issue_indetify'].'",';
			$row .= '"'.$user['probing_responce_positively'].'",';
			$row .= '"'.$user['probing_effective'].'",';
			$row .= '"'.$user['probing_overall_score'].'",';
			$row .= '"'.$user['soft_skill_apology'].'",';
			$row .= '"'.$user['soft_skill_voice_intonation'].'",';
			$row .= '"'.$user['soft_skill_active_listening'].'",';
			$row .= '"'.$user['soft_skill_confidence'].'",';
			$row .= '"'.$user['soft_skill_politeness'].'",';
			$row .= '"'.$user['soft_skill_grammar'].'",';
			$row .= '"'.$user['soft_skill_acknowledgement'].'",';
			$row .= '"'.$user['soft_skill_overall_score'].'",';
			$row .= '"'.$user['hold_dead_ask_permission'].'",';
			$row .= '"'.$user['hold_dead_unhold_procedure'].'",';
			$row .= '"'.$user['hold_dead_took_guest_permission'].'",';
			$row .= '"'.$user['hold_dead_do_not_refresh'].'",';
			$row .= '"'.$user['hold_dead_avoid_dead_air'].'",';
			$row .= '"'.$user['hold_dead_overall_score'].'",';
			$row .= '"'.$user['resolution_fatal_correct_booking'].'",';
			$row .= '"'.$user['resolution_fatal_correct_information'].'",';
			$row .= '"'.$user['resolution_fatal_correct_refund'].'",';
			$row .= '"'.$user['resolution_fatal_proper_follow_up'].'",';
			$row .= '"'.$user['resolution_fatal_recon_adjustment'].'",';
			$row .= '"'.$user['resolution_fatal_overall_score'].'",';
			$row .= '"'.$user['resolution_nonfatal_gnc_closure'].'",';
			$row .= '"'.$user['resolution_nonfatal_duplicate_ticket'].'",';
			$row .= '"'.$user['resolution_nonfatal_ccb_process'].'",';
			$row .= '"'.$user['resolution_nonfatal_case_library'].'",';
			$row .= '"'.$user['resolution_nonfatal_email_to_sent'].'",';
			$row .= '"'.$user['resolution_nonfatal_overall_score'].'",';
			$row .= '"'.$user['fresh_desk_complete_notes'].'",';
			$row .= '"'.$user['fresh_desk_tagging_issue'].'",';
			$row .= '"'.$user['fresh_desk_incorrect_shifting'].'",';
			$row .= '"'.$user['fresh_desk_correct_ticket_status'].'",';
			$row .= '"'.$user['fresh_desk_did_agent_verify'].'",';
			$row .= '"'.$user['fresh_desk_agent_meet_compliant'].'",';
			$row .= '"'.$user['fresh_desk_overall_score'].'",';
			$row .= '"'.$user['closing_further_assistance'].'",';
			$row .= '"'.$user['closing_done_branding'].'",';
			$row .= '"'.$user['closing_gsat_survey_pitched'].'",';
			$row .= '"'.$user['closing_gsat_survey_avoidance'].'",';
			$row .= '"'.$user['closing_overall_score'].'",';
			$row .= '"'.$user['wow_factor_cl_take_positive'].'",';
			$row .= '"'.$user['entry_name'].'",';
			$row .= '"'.$user['entryDate'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_remarks'])) .'",'; 
			$row .= '"'.$user['review_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])) .'",'; 
			$row .= '"'.$user['mgnt_review_date'].'",';
			
			
			fwrite($fopen,$row."\r\n");			
			
			
		}
		
		fclose($fopen);
		
	}
	
	
	
}