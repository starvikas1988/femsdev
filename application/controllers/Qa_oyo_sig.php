<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_oyo_sig extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		//$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_oyosig_model');
		
	 }

	 //////////////////////////////////////
  public function getTLname(){
    if(check_logged_in()){
      $aid=$this->input->post('aid');
      $qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
      echo json_encode($this->Common_model->get_query_result_array($qSql));
    }
  }

  public function createPath($path){

    if (!empty($path)) {

        if(!file_exists($path)){

          $mainPath="./";
          $checkPath=str_replace($mainPath,'', $path);
          $checkPath=explode("/",$checkPath);
          $cnt=count($checkPath);
          for($i=0;$i<$cnt;$i++){

            $mainPath.=$checkPath[$i].'/';
            if (!file_exists($mainPath)) {
              $oldmask = umask(0);
            $mkdir=mkdir($mainPath, 0777);
            umask($oldmask);

            if ($mkdir) {
              return true;
            }else{
              return false;
            }
            }

          }

        }else{
          return true;
        }
      }


  }


  private function amd_upload_files($files,$path)
    {
      $result=$this->createPath($path);
      if($result){
        $config['upload_path'] = $path;
    $config['allowed_types'] = '*';
    //$config['detect_mime'] = FALSE;
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
            }else{
                return false;
            }
        }
        return $images;
      }
    }
	
	
	private function sig_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
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
            }else{
                return false;
            }
        }
        return $images;
    }
	
	
	public function getTLname2(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "SELECT fusion_id, assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name, batch_code, DATEDIFF(CURDATE(), doj) as tenurity, get_client_names(id) as client, get_process_names(id) as process FROM signin m where id = '$aid' ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
//////////////// management filtering data ////////////////////////
	public function qaoyo_management_sorting_feedback()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/qaoyo_management_feedback_review.php"; 
			
			$tl_mgnt_cond="";
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,153) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			//$ticket_id = $this->input->get('ticket_id');
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
			
			$field_array = array
			(
				//"ticket_id" => $ticket_id,
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id
			);	
			//$data["get_management_review_list"] = $this->Qa_oyosig_model->get_management_review_data($field_array);
			
		///////////
		
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_new_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["oyo_sig"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			//$data["ticket_id"] = $ticket_id;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}

///* review page of the feedback management portal *///
	
	
	public function qaoyo_management_status_form($id)
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/qaoyo_management_status_form.php"; 
			
			//$data["get_agent_id_list"] = $this->Qa_oyosig_model->get_agent_id(90,153);
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,153) and status=1 order by name";
			$data["get_agent_id_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["get_tl_id_list"] = $this->Qa_oyosig_model->get_tl_id();
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select fusion_id, concat(fname, ' ', lname) as name from signin where (role_id in (select id from role where folder not in ('agent', 'support', 'super')) or dept_id=11 )  and status=1 order by fusion_id";
			$data["get_coach_name"] = $this->Common_model->get_query_result_array($qSql);
			
			//$data["get_view_feedback_entry"] = $this->Qa_oyosig_model->view_feedback_entry_data($id);
			
			$qSql="SELECT * from 
				(Select f.*, ( select concat(fname, ' ', lname) FROM signin s where s.id=f.agent_id) as agent_name, (select concat(fname, ' ', lname) FROM signin s where s.id=f.tl_id) as tl_name, f.entry_date as entryDate, mr.mgnt_review_date, mr.mgnt_status, mr.note as mgnt_note FROM `qa_oyosig_feedback` f left join qa_oyosig_mgnt_review mr ON f.id = mr.oyo_fd_id where f.id='$id') xx 
				Left Join (Select * from qa_oyosig_agent_review) yy
				ON (xx.id=yy.oyo_fd_id)";
			$data["sig_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fid"]=$id;
			
			$qSql="Select * FROM qa_oyosig_agent_review where oyo_fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_oyosig_mgnt_review where oyo_fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
			
			if($this->input->post('oyo_fd_id'))
			{
				/* $cl_open_overall_score=(int)$this->input->post('cl_open_overall_score');
				$probing_overall_score=(int)$this->input->post('probing_overall_score');
				$soft_skill_overall_score=(int)$this->input->post('soft_skill_overall_score');
				$hold_dead_overall_score=(int)$this->input->post('hold_dead_overall_score');
				$resolution_fatal_overall_score=(int)$this->input->post('resolution_fatal_overall_score');
				$resolution_nonfatal_overall_score=(int)$this->input->post('resolution_nonfatal_overall_score');
				$fresh_desk_overall_score=(int)$this->input->post('fresh_desk_overall_score');
				$closing_overall_score=(int)$this->input->post('closing_overall_score'); */
				
				$oyo_fd_id=$this->input->post('oyo_fd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
			/////////////	
				$field_array1 = array(
					"ticket_id" => $this->input->post('ticket_id'),
					"auditor_name" => $this->input->post('auditor_name'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"guest_phone" => $this->input->post('guest_phone'),
					"tenurity" => $this->input->post('tenurity'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_type" => $this->input->post('call_type'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"batch_code" => $this->input->post('batch_code'),
					"shift_timing" => $this->input->post('duration_length'),
					"booking_id" => $this->input->post('booking_id'),
					"czentrix" => $this->input->post('czentrix'),
					"call_summary" => $this->input->post('call_summary'),
					"remarks" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
					
				);
				$this->db->where('id', $oyo_fd_id);
				$this->db->update('qa_oyosig_feedback',$field_array1);
			///////////	
				
				if(is_edit_sig_audit()==true){ 
					
					$update_score_arr = array(
						"cl_open_5_sec" => $this->input->post('co_opening5s'),
						"cl_open_self_intro" => $this->input->post('co_selfintro'),
						//"cl_open_overall_score" => $cl_open_overall_score,
						"probing_issue_indetify" => $this->input->post('prob_indentify'),
						"probing_effective" => $this->input->post('prob_effect'),
						//"probing_overall_score" => $probing_overall_score,
						"soft_skill_apology" => $this->input->post('ss_empathy'),
						"soft_skill_voice_intonation" => $this->input->post('ss_intonation'),
						"soft_skill_active_listening" => $this->input->post('ss_interrupt'),
						"soft_skill_confidence" => $this->input->post('ss_enthu'),
						"soft_skill_politeness" => $this->input->post('ss_polite'),
						"soft_skill_grammar" => $this->input->post('ss_grammar'),
						"soft_skill_acknowledgement" => $this->input->post('ss_guest'),
						//"soft_skill_overall_score" => $soft_skill_overall_score,
						"hold_dead_ask_permission" => $this->input->post('hd_permission'),
						"hold_dead_unhold_procedure" => $this->input->post('hd_unhold'),
						"hold_dead_took_guest_permission" => $this->input->post('hd_took'),
						"hold_dead_do_not_refresh" => $this->input->post('hd_refresh'),
						"hold_dead_avoid_dead_air" => $this->input->post('hd_avoid'),
						"hd_legit" => $this->input->post('hd_legit'),
						//"hold_dead_overall_score" => $hold_dead_overall_score,
						"resolution_fatal_correct_booking" => $this->input->post('rf_book'),
						"resolution_fatal_correct_information" => $this->input->post('rf_info'),
						"resolution_fatal_correct_refund" => $this->input->post('rf_refund'),
						"resolution_fatal_proper_follow_up" => $this->input->post('rf_follow'),
						"resolution_fatal_recon_adjustment" => $this->input->post('rf_czent'),
						//"resolution_fatal_overall_score" => $resolution_fatal_overall_score,
						"resolution_nonfatal_gnc_closure" => $this->input->post('rnf_closure'),
						"resolution_nonfatal_duplicate_ticket" => $this->input->post('rnf_duplicate'),
						"resolution_nonfatal_case_library" => $this->input->post('rnf_library'),
						"resolution_nonfatal_email_to_sent" => $this->input->post('rnf_email'),
						//"resolution_nonfatal_overall_score" => $resolution_nonfatal_overall_score,
						"fresh_desk_complete_notes" => $this->input->post('fd_note'),
						"fresh_desk_tagging_issue" => $this->input->post('fd_tagging'),
						"fresh_desk_incorrect_shifting" => $this->input->post('fd_shift'),
						"fresh_desk_correct_ticket_status" => $this->input->post('fd_ticket'),
						"fresh_desk_did_agent_verify" => $this->input->post('fd_verify'),
						"fresh_desk_agent_meet_compliant" => $this->input->post('fd_tat'),
						//"fresh_desk_overall_score" => $fresh_desk_overall_score,
						"closing_further_assistance" => $this->input->post('c_pitch'),
						"closing_done_branding" => $this->input->post('c_further'),
						"closing_gsat_survey_pitched" => $this->input->post('c_gsat'),
						"closing_gsat_survey_avoidance" => $this->input->post('c_survey'),
						"oyo_assist_pitch" => $this->input->post('c_oyo'),
						//"closing_overall_score" => $closing_overall_score,
						"wow_factor_cl_take_positive" => $this->input->post('wow_factor_cl_take_positive'),
						"overall_result" => $this->input->post('overall_result'),
						"overall_score" => $this->input->post('overall_score'),
						
						"dd_co_opening5s" => $this->input->post('dd_co_opening5s'),
						"dd_co_selfintro" => $this->input->post('dd_co_selfintro'),
						"dd_prob_effect" => $this->input->post('dd_prob_effect'),
						"dd_prob_indentify" => $this->input->post('dd_prob_indentify'),
						"dd_ss_empathy" => $this->input->post('dd_ss_empathy'),
						"dd_ss_intonation" => $this->input->post('dd_ss_intonation'),
						"dd_ss_interrupt" => $this->input->post('dd_ss_interrupt'),
						"dd_ss_enthu" => $this->input->post('dd_ss_enthu'),
						"dd_ss_polite" => $this->input->post('dd_ss_polite'),
						"dd_ss_grammar" => $this->input->post('dd_ss_grammar'),
						"dd_ss_guest" => $this->input->post('dd_ss_guest'),
						"dd_hd_permission" => $this->input->post('dd_hd_permission'),
						"dd_hd_unhold" => $this->input->post('dd_hd_unhold'),
						"dd_hd_took" => $this->input->post('dd_hd_took'),
						"dd_hd_refresh" => $this->input->post('dd_hd_refresh'),
						"dd_hd_avoid" => $this->input->post('dd_hd_avoid'),
						"dd_hd_legit" => $this->input->post('dd_hd_legit'),
						"dd_rf_book" => $this->input->post('dd_rf_book'),
						"dd_rf_info" => $this->input->post('dd_rf_info'),
						"dd_rf_refund" => $this->input->post('dd_rf_refund'),
						"dd_rf_follow" => $this->input->post('dd_rf_follow'),
						"dd_rf_czent" => $this->input->post('dd_rf_czent'),
						"dd_rnf_closure" => $this->input->post('dd_rnf_closure'),
						"dd_rnf_duplicate" => $this->input->post('dd_rnf_duplicate'),
						"dd_rnf_library" => $this->input->post('dd_rnf_library'),
						"dd_rnf_email" => $this->input->post('dd_rnf_email'),
						"dd_fd_note" => $this->input->post('dd_fd_note'),
						"dd_fd_tagging" => $this->input->post('dd_fd_tagging'),
						"dd_fd_shift" => $this->input->post('dd_fd_shift'),
						"dd_fd_ticket" => $this->input->post('dd_fd_ticket'),
						"dd_fd_verify" => $this->input->post('dd_fd_verify'),
						"dd_fd_tat" => $this->input->post('dd_fd_tat'),
						"dd_c_pitch" => $this->input->post('dd_c_pitch'),
						"dd_c_further" => $this->input->post('dd_c_further'),
						"dd_c_gsat" => $this->input->post('dd_c_gsat'),
						"dd_c_survey" => $this->input->post('dd_c_survey'),
						"dd_c_oyo" => $this->input->post('dd_c_oyo')
					);	
						
					$this->db->where('id', $oyo_fd_id);
					$this->db->update('qa_oyosig_feedback',$update_score_arr);
					
				}
				
			//////////////	
				$field_array=array(
					"oyo_fd_id" => $oyo_fd_id,
					"mgnt_review_date" => CurrDate(),
					"coach_name" => $this->input->post('coach_name'),
					"note" => $this->input->post('mgnt_note'),
					"mgnt_status" => 1,
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
					//"log" => $log
				);
				
				if($this->input->post('action')==''){
					
					$this->Qa_oyosig_model->data_insert_mgnt_feedback_entry($field_array);
					
				}else{
					
					$this->db->where('oyo_fd_id', $oyo_fd_id);
					$this->db->update('qa_oyosig_mgnt_review',$field_array);
				}
			////////////////	
				
				redirect('Qa_oyo_sig/qaoyo_management_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
	
////////////////////////////	
	
///* add management page of the OYO feedback management portal *///	
	
	public function qaoyo_management_feedback_entry()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_oyo_sig/qaoyo_management_feedback_entry.php"; 
			
			//$data["get_agent_id_list"] = $this->Qa_oyosig_model->get_agent_id(90,153);
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,153) and status=1 order by name";
			$data["get_agent_id_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["get_tl_id_list"] = $this->Qa_oyosig_model->get_tl_id();
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$log=get_logs();
			$i='';
			$a = array();
			
			/* $cl_open_overall_score=(int)$this->input->post('cl_open_overall_score');
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
			} */
			
			if($this->input->post('auditor_name'))
			{
				
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"guest_phone" => $this->input->post('guest_phone'),
					"shift_timing" => $this->input->post('duration_length'),
					"call_type" => $this->input->post('call_type'),
					"ticket_id" => $this->input->post('ticket_id'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"duration_length" => $this->input->post('duration_length'),
					"booking_id" => $this->input->post('booking_id'),
					"tenurity" => $this->input->post('tenurity'),
					"batch_code" => $this->input->post('batch_code'),
					"czentrix" => $this->input->post('czentrix'),
					"call_summary" => $this->input->post('call_summary'),
					"remarks" => $this->input->post('feedback'),
					"observation" => $this->input->post('observation'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"status" => 1,
					"log" => $log,
					
					"cl_open_5_sec" => $this->input->post('co_opening5s'),
					"cl_open_self_intro" => $this->input->post('co_selfintro'),
					//"cl_open_overall_score" => $cl_open_overall_score,
					"probing_issue_indetify" => $this->input->post('prob_indentify'),
					"probing_effective" => $this->input->post('prob_effect'),
					//"probing_overall_score" => $probing_overall_score,
					"soft_skill_apology" => $this->input->post('ss_empathy'),
					"soft_skill_voice_intonation" => $this->input->post('ss_intonation'),
					"soft_skill_active_listening" => $this->input->post('ss_interrupt'),
					"soft_skill_confidence" => $this->input->post('ss_enthu'),
					"soft_skill_politeness" => $this->input->post('ss_polite'),
					"soft_skill_grammar" => $this->input->post('ss_grammar'),
					"soft_skill_acknowledgement" => $this->input->post('ss_guest'),
					//"soft_skill_overall_score" => $soft_skill_overall_score,
					"hold_dead_ask_permission" => $this->input->post('hd_permission'),
					"hold_dead_unhold_procedure" => $this->input->post('hd_unhold'),
					"hold_dead_took_guest_permission" => $this->input->post('hd_took'),
					"hold_dead_do_not_refresh" => $this->input->post('hd_refresh'),
					"hold_dead_avoid_dead_air" => $this->input->post('hd_avoid'),
					"hd_legit" => $this->input->post('hd_legit'),
					//"hold_dead_overall_score" => $hold_dead_overall_score,
					"resolution_fatal_correct_booking" => $this->input->post('rf_book'),
					"resolution_fatal_correct_information" => $this->input->post('rf_info'),
					"resolution_fatal_correct_refund" => $this->input->post('rf_refund'),
					"resolution_fatal_proper_follow_up" => $this->input->post('rf_follow'),
					"resolution_fatal_recon_adjustment" => $this->input->post('rf_czent'),
					//"resolution_fatal_overall_score" => $resolution_fatal_overall_score,
					"resolution_nonfatal_gnc_closure" => $this->input->post('rnf_closure'),
					"resolution_nonfatal_duplicate_ticket" => $this->input->post('rnf_duplicate'),
					"resolution_nonfatal_case_library" => $this->input->post('rnf_library'),
					"resolution_nonfatal_email_to_sent" => $this->input->post('rnf_email'),
					//"resolution_nonfatal_overall_score" => $resolution_nonfatal_overall_score,
					"fresh_desk_complete_notes" => $this->input->post('fd_note'),
					"fresh_desk_tagging_issue" => $this->input->post('fd_tagging'),
					"fresh_desk_incorrect_shifting" => $this->input->post('fd_shift'),
					"fresh_desk_correct_ticket_status" => $this->input->post('fd_ticket'),
					"fresh_desk_did_agent_verify" => $this->input->post('fd_verify'),
					"fresh_desk_agent_meet_compliant" => $this->input->post('fd_tat'),
					//"fresh_desk_overall_score" => $fresh_desk_overall_score,
					"closing_further_assistance" => $this->input->post('c_pitch'),
					"closing_done_branding" => $this->input->post('c_further'),
					"closing_gsat_survey_pitched" => $this->input->post('c_gsat'),
					"closing_gsat_survey_avoidance" => $this->input->post('c_survey'),
					"oyo_assist_pitch" => $this->input->post('c_oyo'),
					//"closing_overall_score" => $closing_overall_score,
					"wow_factor_cl_take_positive" => $this->input->post('wow_factor_cl_take_positive'),
					"overall_result" => $this->input->post('overall_result'),
					"overall_score" => $this->input->post('overall_score'),
					
					"dd_co_opening5s" => $this->input->post('dd_co_opening5s'),
					"dd_co_selfintro" => $this->input->post('dd_co_selfintro'),
					"dd_prob_effect" => $this->input->post('dd_prob_effect'),
					"dd_prob_indentify" => $this->input->post('dd_prob_indentify'),
					"dd_ss_empathy" => $this->input->post('dd_ss_empathy'),
					"dd_ss_intonation" => $this->input->post('dd_ss_intonation'),
					"dd_ss_interrupt" => $this->input->post('dd_ss_interrupt'),
					"dd_ss_enthu" => $this->input->post('dd_ss_enthu'),
					"dd_ss_polite" => $this->input->post('dd_ss_polite'),
					"dd_ss_grammar" => $this->input->post('dd_ss_grammar'),
					"dd_ss_guest" => $this->input->post('dd_ss_guest'),
					"dd_hd_permission" => $this->input->post('dd_hd_permission'),
					"dd_hd_unhold" => $this->input->post('dd_hd_unhold'),
					"dd_hd_took" => $this->input->post('dd_hd_took'),
					"dd_hd_refresh" => $this->input->post('dd_hd_refresh'),
					"dd_hd_avoid" => $this->input->post('dd_hd_avoid'),
					"dd_hd_legit" => $this->input->post('dd_hd_legit'),
					"dd_rf_book" => $this->input->post('dd_rf_book'),
					"dd_rf_info" => $this->input->post('dd_rf_info'),
					"dd_rf_refund" => $this->input->post('dd_rf_refund'),
					"dd_rf_follow" => $this->input->post('dd_rf_follow'),
					"dd_rf_czent" => $this->input->post('dd_rf_czent'),
					"dd_rnf_closure" => $this->input->post('dd_rnf_closure'),
					"dd_rnf_duplicate" => $this->input->post('dd_rnf_duplicate'),
					"dd_rnf_library" => $this->input->post('dd_rnf_library'),
					"dd_rnf_email" => $this->input->post('dd_rnf_email'),
					"dd_fd_note" => $this->input->post('dd_fd_note'),
					"dd_fd_tagging" => $this->input->post('dd_fd_tagging'),
					"dd_fd_shift" => $this->input->post('dd_fd_shift'),
					"dd_fd_ticket" => $this->input->post('dd_fd_ticket'),
					"dd_fd_verify" => $this->input->post('dd_fd_verify'),
					"dd_fd_tat" => $this->input->post('dd_fd_tat'),
					"dd_c_pitch" => $this->input->post('dd_c_pitch'),
					"dd_c_further" => $this->input->post('dd_c_further'),
					"dd_c_gsat" => $this->input->post('dd_c_gsat'),
					"dd_c_survey" => $this->input->post('dd_c_survey'),
					"dd_c_oyo" => $this->input->post('dd_c_oyo')
				);
				
				$a = $this->sig_upload_files($_FILES['attach_file'],$path='./qa_files/qa_oyo_sig/');
				$field_array["attach_file"] = implode(',',$a);
				
				$data["insert_feedback_entry"] = $this->Qa_oyosig_model->data_insert_feedback_entry($field_array); 
				redirect('Qa_oyo_sig/qaoyo_management_sorting_feedback');
				
				
			}
			
			$data["array"] = $a;
			$this->load->view('dashboard',$data); 
			
		}
	}
		
	
/*---------------------------------Agent Feedback Part--------------------------------------------*/	
	
	//////////////// agent filtering data ////////////////////////
	public function qaoyo_agent_sorting_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/qaoyo_agent_feedback_review.php"; 
			$data["agentUrl"] = "qa_oyo_sig/qaoyo_agent_sorting_feedback"; 
			$data["content_js"] = "qa_oyo/uk_us_js.php";		
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
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
			
			$qSql="Select count(id) as value from qa_oyosig_new_feedback where agent_id='$current_user'";
			$data["total_oyosig_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_oyosig_new_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_oyosig_feedback"] =  $this->Common_model->get_single_value($qSql);

		////////////////////////	
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyosig_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["signew_agent_rvw"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}
	public function qaoyo_agent_feedback_review_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/qaoyo_agent_feedback_review_rvw.php";
			$data["agentUrl"] = "qa_oyo_sig/qaoyo_agent_sorting_feedback"; 
            $data["content_js"] = "qa_oyo/uk_us_js.php";
			$data["sig_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_oyosig_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["oyo_sig"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('sig_id'))
			{
				$sig_id=$this->input->post('sig_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $sig_id);
				$this->db->update('qa_oyosig_new_feedback',$field_array);
				redirect('qa_oyo_sig/qaoyo_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	public function qaoyo_agent_sorting_feedback2()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/qaoyo_agent_feedback_review.php"; 
			$data["agentUrl"] = "qa_oyo_sig/qaoyo_agent_sorting_feedback"; 
			
			
			$qSql="Select count(id) as value from qa_oyosig_feedback where agent_id = '$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["total_oyosig_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			//$qSql="Select count(id) as value from qa_oyosig_feedback where id  not in (select oyo_fd_id from qa_oyosig_agent_review) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["total_oyosig_review_needed"] =  $this->Common_model->get_single_value($qSql);
		/////////
			$qSql="Select count(id) as value from qa_oyosig_new_feedback where agent_id = '$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_oyosignew_fd"] =  $this->Common_model->get_single_value($qSql);
			
			//$qSql="Select count(id) as value from qa_oyosig_new_feedback where id  not in (select oyo_fd_id from qa_oyosig_agent_review) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_oyosignew_yet"] =  $this->Common_model->get_single_value($qSql);
			
			
			$ticket_id='';	
			$from_date = '';
			$to_date = '';
			$cond='';
			
			/* if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			} */
			
		if($this->input->get('btnView')=='View')
		{
			$from_date = mmddyy2mysql($this->input->get('from_date'));
			$to_date = mmddyy2mysql($this->input->get('to_date'));
			$ticket_id = $this->input->get('ticket_id');
				
			$field_array = array(
				"ticket_id" => $ticket_id,
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"current_user" => $current_user
			);

			//$data["get_agent_review_list"] = $this->Qa_oyosig_model->get_agent_review_data($field_array);

			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyosig_new_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["signew_agent_rvw"] = $this->Common_model->get_query_result_array($qSql);
				
		}else{
				
			$data["get_agent_review_list"] = $this->Qa_oyosig_model->get_agent_not_review_data($current_user);	
				
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyosig_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
			$data["signew_agent_rvw"] = $this->Common_model->get_query_result_array($qSql);
			
		} 
			
			$data["ticket_id"] = $ticket_id;
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$data["get_name"] = $this->Qa_oyosig_model->get_agent_fullname();
			
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
///* review page of the feedback agent portal *///

	public function qaoyo_agent_status_form($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/qaoyo_agent_status_form.php"; 
			$data["agentUrl"] = "qa_oyo_sig/qaoyo_agent_sorting_feedback"; 
			
			$data["fid"]=$id;
			
			$qSql="Select * FROM qa_oyosig_agent_review where oyo_fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_oyosig_mgnt_review where oyo_fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
			//$data["get_view_feedback_entry"] = $this->Qa_oyosig_model->view_feedback_entry_data($id);//all data 
			
			$qSql="SELECT * from 
				(Select f.*, ( select concat(fname, ' ', lname) FROM signin s where s.id=f.agent_id) as agent_name, (select concat(fname, ' ', lname) FROM signin s where s.id=f.tl_id) as tl_name, f.entry_date as entryDate, mr.mgnt_review_date, mr.mgnt_status, mr.note as mgnt_note FROM `qa_oyosig_feedback` f left join qa_oyosig_mgnt_review mr ON f.id = mr.oyo_fd_id where f.id='$id') xx 
				Left Join (Select * from qa_oyosig_agent_review) yy
				ON (xx.id=yy.oyo_fd_id)";
			$data["sig_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			
			$oyo_fd_id=$this->input->post('oyo_fd_id');
			$currdate = CurrDate();
			$curDateTime=CurrMySqlDate();
			$log=get_logs();
				
			//if($this->input->post('btnSave')=='SAVE')
			if($this->input->post('oyo_fd_id'))
			{	
				
				$field_array=array(
					"oyo_fd_id" => $oyo_fd_id,
					"review_date" => $currdate,
					"status" => 1,
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"remarks" => $this->input->post('remarks')
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_oyosig_agent_review',$field_array);
					
				}else{
					
					$this->db->where('oyo_fd_id', $oyo_fd_id);
					$this->db->update('qa_oyosig_agent_review',$field_array);
				}
				
				redirect('Qa_oyo_sig/qaoyo_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
	
	
	public function agent_oyosig_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/new_scorecard/agent_oyo_sig_rvw.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data["agentUrl"] = "qa_oyo_sig/qaoyo_agent_sorting_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyosig_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["oyo_sig"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
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
				$this->db->update('qa_oyosig_new_feedback',$field_array1);
					
				redirect('Qa_oyo_sig/qaoyo_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////

	public function add_edit_sig($sig_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/new_scorecard/add_edit_sig.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data['sig_id']=$sig_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,153) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_new_feedback where id='$sig_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["oyo_sig"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){

				if($sig_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->sig_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_sig/sig_new/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_oyosig_new_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyosig_new_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$this->db->where('id', $sig_id);
					$this->db->update('qa_oyosig_new_feedback',$field_array1);
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
					$this->db->where('id', $sig_id);
					$this->db->update('qa_oyosig_new_feedback',$edit_array);
				}
				redirect('qa_oyo_sig/qaoyo_management_sorting_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_sig66($sig_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/new_scorecard/add_edit_sig.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data['sig_id']=$sig_id;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,153) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_new_feedback where id='$sig_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["oyo_sig"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('call_date')=='' || $this->input->post('call_date')=='0000-00-00 00:00:00'){
				$call_date_time=CurrMySqlDate();
			}else{
				$call_date_time=mdydt2mysql($this->input->post('call_date'));
			}
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => $call_date_time,
					"campaign" => $this->input->post('campaign'),
					"call_duration" => $this->input->post('call_duration'),
					"czentrix_id" => $this->input->post('czentrix_id'),
					"phone" => $this->input->post('phone'),
					"call_type" => $this->input->post('call_type'),
					"disconnection_source" => $this->input->post('disconnection_source'),
					"call_id" => $this->input->post('call_id'),
					"monitor_file_name" => $this->input->post('monitor_file_name'),
					"conf_id" => $this->input->post('conf_id'),
					"czentrix_disposition" => $this->input->post('czentrix_disposition'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"call_opening_5sec" => $this->input->post('call_opening_5sec'),
					"call_opening_oyo_branding" => $this->input->post('call_opening_oyo_branding'),
					"effective_probong" => $this->input->post('effective_probong'),
					"issue_identified" => $this->input->post('issue_identified'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"voice_intonation" => $this->input->post('voice_intonation'),
					"active_listening" => $this->input->post('active_listening'),
					"confidence_enthusiasm" => $this->input->post('confidence_enthusiasm'),
					"politeness" => $this->input->post('politeness'),
					"sentence_construction" => $this->input->post('sentence_construction'),
					"acknowledgement" => $this->input->post('acknowledgement'),
					"adhere_hold_protocol" => $this->input->post('adhere_hold_protocol'),
					"dead_air_protocol" => $this->input->post('dead_air_protocol'),
					"legitimate_hold" => $this->input->post('legitimate_hold'),
					"correct_information" => $this->input->post('correct_information'),
					"correct_refund" => $this->input->post('correct_refund'),
					"proper_followup" => $this->input->post('proper_followup'),
					"gnc_closure" => $this->input->post('gnc_closure'),
					"assist_adherence" => $this->input->post('assist_adherence'),
					"account_verification" => $this->input->post('account_verification'),
					"ownership" => $this->input->post('ownership'),
					"correct_email" => $this->input->post('correct_email'),
					"correct_notes" => $this->input->post('correct_notes'),
					"accurate_tagging" => $this->input->post('accurate_tagging'),
					"call_disposed" => $this->input->post('call_disposed'),
					"correct_ticket_status" => $this->input->post('correct_ticket_status'),
					"piched_need_help" => $this->input->post('piched_need_help'),
					"further_assistance" => $this->input->post('further_assistance'),
					"Gsat_survey_pitched" => $this->input->post('Gsat_survey_pitched'),
					"Gsat_survey_avoidance" => $this->input->post('Gsat_survey_avoidance'),
					"closing_done_branding" => $this->input->post('closing_done_branding'),
					"remarks1" => $this->input->post('remarks1'),
					"remarks2" => $this->input->post('remarks2'),
					"remarks3" => $this->input->post('remarks3'),
					"remarks4" => $this->input->post('remarks4'),
					"remarks5" => $this->input->post('remarks5'),
					"remarks6" => $this->input->post('remarks6'),
					"remarks7" => $this->input->post('remarks7'),
					"remarks8" => $this->input->post('remarks8'),
					"remarks9" => $this->input->post('remarks9'),
					"remarks10" => $this->input->post('remarks10'),
					"remarks11" => $this->input->post('remarks11'),
					"remarks12" => $this->input->post('remarks12'),
					"remarks13" => $this->input->post('remarks13'),
					"remarks14" => $this->input->post('remarks14'),
					"remarks15" => $this->input->post('remarks15'),
					"remarks16" => $this->input->post('remarks16'),
					"remarks17" => $this->input->post('remarks17'),
					"remarks18" => $this->input->post('remarks18'),
					"remarks19" => $this->input->post('remarks19'),
					"remarks20" => $this->input->post('remarks20'),
					"remarks21" => $this->input->post('remarks21'),
					"remarks22" => $this->input->post('remarks22'),
					"remarks23" => $this->input->post('remarks23'),
					"remarks24" => $this->input->post('remarks24'),
					"remarks25" => $this->input->post('remarks25'),
					"remarks26" => $this->input->post('remarks26'),
					"remarks27" => $this->input->post('remarks27'),
					"remarks28" => $this->input->post('remarks28'),
					"remarks29" => $this->input->post('remarks29'),
					"remarks30" => $this->input->post('remarks30'),
					"remarks31" => $this->input->post('remarks31'),
					"issue_category" => $this->input->post('issue_category'),
					"sub_category" => $this->input->post('sub_category'),
					"sub_sub_category" => $this->input->post('sub_sub_category'),
					"actual_issue_category" => $this->input->post('actual_issue_category'),
					"actual_sub_category" => $this->input->post('actual_sub_category'),
					"actual_sub_sub_category" => $this->input->post('actual_sub_sub_category'),
					"actual_czentrix_dispo" => $this->input->post('actual_czentrix_dispo'),
					"booking_id" => $this->input->post('booking_id'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($sig_id==0){
					
					$a = $this->sig_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_sig/sig_new/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_oyosig_new_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyosig_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyosig_new_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $sig_id);
					$this->db->update('qa_oyosig_new_feedback',$field_array);
					/////////
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
					$this->db->where('id', $sig_id);
					$this->db->update('qa_oyosig_new_feedback',$field_array1);
					
				}
				
				redirect('qa_oyo_sig/qaoyo_management_sorting_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// OYO SIG Chat ////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

	public function oyo_sig_chat(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/sig_chat/qa_sig_chat_feedback.php";
			$data["content_js"] = "qa_oyo_sig_js.php";
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and (is_assign_process(id,286) or is_assign_process(id,384)) and status=1 $tl_mgnt_cond order by name";
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}
		
			$service_chat_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_chat_service_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["chat_service"] = $this->Common_model->get_query_result_array($service_chat_sql);
		////////////
			$escalation_chat_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_chat_escalation_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["chat_escalation"] = $this->Common_model->get_query_result_array($escalation_chat_sql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_sigchat_service($service_id){

    $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_oyo_sig/sig_chat/add_edit_sigchat_service.php";
      $data['service_id']=$service_id;
      $tl_mgnt_cond='';
      
      if(is_access_qa_oyo_fd_entry()==true){
        $tl_mgnt_cond="";
      }else{
        if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
          $tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
        }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
          $tl_mgnt_cond=" and assigned_to='$current_user'";
        }else{
          $tl_mgnt_cond="";
        }
      }
      $qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,384) and status=1 $tl_mgnt_cond order by name";
      $data["agentName"] = $this->Common_model->get_query_result_array($qSql);
      
      $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
      $data['tlname'] = $this->Common_model->get_query_result_array($qSql);
      
      $qSql = "SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
        from qa_oyosig_chat_service_feedback where id='$service_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["chat_service"] = $this->Common_model->get_query_row_array($qSql);

      
      $curDateTime=CurrMySqlDate();
      $a = array();

      $field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
      //print_r($this->input->post('data')); 
      //die;
      if($field_array['agent_id']){

        if($service_id==0){
          $field_array=$this->input->post('data');

          $field_array['audit_date']=CurrDate();
          $field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
          $field_array['entry_date']=$curDateTime;
          $field_array['audit_start_time']=$this->input->post('audit_start_time');

          $a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_sig/sig_chat_service/');
                    $field_array["attach_file"] = implode(',',$a);

          $rowid= data_inserter('qa_oyosig_chat_service_feedback',$field_array);
          if(get_login_type()=="client"){
            $add_array = array("client_entryby" => $current_user);
          }else{
            $add_array = array("entry_by" => $current_user);
          }
          $this->db->where('id', $rowid);
          $this->db->update('qa_oyosig_chat_service_feedback',$add_array);

        }else{
          $field_array1=$this->input->post('data');
          $field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
          $this->db->where('id', $service_id);
          $this->db->update('qa_oyosig_chat_service_feedback',$field_array1);
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
          $this->db->where('id', $service_id);
          $this->db->update('qa_oyosig_chat_service_feedback',$edit_array);

        }

        redirect('qa_oyo_sig/oyo_sig_chat');
      }
      $data["array"] = $a;

      $this->load->view("dashboard",$data);
    }
 // }
	
	
	public function add_edit_sigchat_service2($service_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/sig_chat/add_edit_sigchat_service.php";
			$data['service_id']=$service_id;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,384) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_chat_service_feedback where id='$service_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["chat_service"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"booking_id" => $this->input->post('booking_id'),
					"guest_number" => $this->input->post('guest_number'),
					"chat_link" => $this->input->post('chat_link'),
					"haptik_id" => $this->input->post('haptik_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"opening" => $this->input->post('opening'),
					"issue_identification" => $this->input->post('issue_identification'),
					"booking_details" => $this->input->post('booking_details'),
					"USPs" => $this->input->post('USPs'),
					"CRS_compliance" => $this->input->post('CRS_compliance'),
					"acknowledge_time" => $this->input->post('acknowledge_time'),
					"ID_notification" => $this->input->post('ID_notification'),
					"attentive_on_chat" => $this->input->post('attentive_on_chat'),
					"resolution_guest_concern" => $this->input->post('resolution_guest_concern'),
					"punctuation" => $this->input->post('punctuation'),
					"dialect_used_concern" => $this->input->post('dialect_used_concern'),
					"sentence_structure" => $this->input->post('sentence_structure'),
					"spell_check" => $this->input->post('spell_check'),
					"courteous_word" => $this->input->post('courteous_word'),
					"word_choice" => $this->input->post('word_choice'),
					"SMS_language" => $this->input->post('SMS_language'),
					"further_assistance" => $this->input->post('further_assistance'),
					"disconnect_check" => $this->input->post('disconnect_check'),
					"closing" => $this->input->post('closing'),
					"infraction_booking_details" => $this->input->post('infraction_booking_details'),
					"infraction_USPs" => $this->input->post('infraction_USPs'),
					"infraction_CRS_compliance" => $this->input->post('infraction_CRS_compliance'),
					"infraction_ID_notification" => $this->input->post('infraction_ID_notification'),
					"infraction_spell_check" => $this->input->post('infraction_spell_check'),
					"infraction_issue_identify" => $this->input->post('infraction_issue_identify'),
					"infraction_guest_concern" => $this->input->post('infraction_guest_concern'),
					"infraction_incomplete_sentence" => $this->input->post('infraction_incomplete_sentence'),
					"infraction_ownership_failure" => $this->input->post('infraction_ownership_failure'),
					"advisor_ZTP" => $this->input->post('advisor_ZTP'),
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
					"dd_val1" => $this->input->post('dd_val1'),
					"dd_val2" => $this->input->post('dd_val2'),
					"dd_val3" => $this->input->post('dd_val3'),
					"dd_val4" => $this->input->post('dd_val4'),
					"dd_val5" => $this->input->post('dd_val5'),
					"dd_val6" => $this->input->post('dd_val6'),
					"dd_val7" => $this->input->post('dd_val7'),
					"dd_val8" => $this->input->post('dd_val8'),
					"dd_val9" => $this->input->post('dd_val9'),
					"dd_val10" => $this->input->post('dd_val10'),
					"dd_val11" => $this->input->post('dd_val11'),
					"dd_val12" => $this->input->post('dd_val12'),
					"dd_val13" => $this->input->post('dd_val13'),
					"dd_val14" => $this->input->post('dd_val14'),
					"dd_val15" => $this->input->post('dd_val15'),
					"dd_val16" => $this->input->post('dd_val16'),
					"dd_val17" => $this->input->post('dd_val17'),
					"dd_val18" => $this->input->post('dd_val18'),
					"dd_val19" => $this->input->post('dd_val19'),
					"dd_val20" => $this->input->post('dd_val20'),
					"dd_val21" => $this->input->post('dd_val21'),
					"dd_val22" => $this->input->post('dd_val22'),
					"dd_val23" => $this->input->post('dd_val23'),
					"dd_val24" => $this->input->post('dd_val24'),
					"dd_val25" => $this->input->post('dd_val25'),
					"dd_val26" => $this->input->post('dd_val26'),
					"dd_val27" => $this->input->post('dd_val27'),
					"dd_val28" => $this->input->post('dd_val28'),
					"dd_val29" => $this->input->post('dd_val29'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($service_id==0){
					
					$a = $this->sig_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_sig/sig_chat_service/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_oyosig_chat_service_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyosig_chat_service_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyosig_chat_service_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $service_id);
					$this->db->update('qa_oyosig_chat_service_feedback',$field_array);
					/////////
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
					$this->db->where('id', $service_id);
					$this->db->update('qa_oyosig_chat_service_feedback',$field_array1);
					
				}
				redirect('qa_oyo_sig/oyo_sig_chat');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_sigchat_escalation($escalation_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/sig_chat/add_edit_sigchat_escalation.php";
			$data['escalation_id']=$escalation_id;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and is_assign_process(id,286) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_chat_escalation_feedback where id='$escalation_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["chat_escalation"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"guest_number" => $this->input->post('guest_number'),
					"chat_link" => $this->input->post('chat_link'),
					"escalation_ticket_id" => $this->input->post('escalation_ticket_id'),
					"booking_id" => $this->input->post('booking_id'),
					"haptik_id" => $this->input->post('haptik_id'),
					"tenurity" => $this->input->post('tenurity'),
					"conversation_identifier" => $this->input->post('conversation_identifier'),
					"aht" => $this->input->post('aht'),
					"crs_id" => $this->input->post('crs_id'),
					"haptik_category" => $this->input->post('haptik_category'),
					"haptik_subcategory" => $this->input->post('haptik_subcategory'),
					"od_reason" => $this->input->post('od_reason'),
					"od_category" => $this->input->post('od_category'),
					"od_subcategory" => $this->input->post('od_subcategory'),
					"od_actual_reason" => $this->input->post('od_actual_reason'),
					"od_actual_category" => $this->input->post('od_actual_category'),
					"od_actual_subcategory" => $this->input->post('od_actual_subcategory'),
					"chat_synopsis" => $this->input->post('chat_synopsis'),
					"monitor_filename_guest" => $this->input->post('monitor_filename_guest'),
					"monitor_filename_pm" => $this->input->post('monitor_filename_pm'),
					"monitor_filename_sm" => $this->input->post('monitor_filename_sm'),
					"var_1" => $this->input->post('var_1'),
					"var_2" => $this->input->post('var_2'),
					"var_3" => $this->input->post('var_3'),
					"property_code" => $this->input->post('property_code'),
					"agent_disposition" => $this->input->post('agent_disposition'),
					"qa_disposition" => $this->input->post('qa_disposition'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),

					"opening_salutation" => $this->input->post('opening_salutation'),
					"effective_probing" => $this->input->post('effective_probing'),
					"issue_identified" => $this->input->post('issue_identified'),
					"apology_empathy" => $this->input->post('apology_empathy'),
					"spacing_error_punctuation" => $this->input->post('spacing_error_punctuation'),
					"attentiveness" => $this->input->post('attentiveness'),
					"sms_language" => $this->input->post('sms_language'),
					"spell_check" => $this->input->post('spell_check'),
					"courteous_words" => $this->input->post('courteous_words'),
					"incomplete_sentence" => $this->input->post('incomplete_sentence'),
					"time_acknowledge" => $this->input->post('time_acknowledge'),
					
					"unnecessary_time_taken" => $this->input->post('unnecessary_time_taken'),
					
					"correct_information" => $this->input->post('correct_information'),
					"correct_refund" => $this->input->post('correct_refund'),
					"proper_followup" => $this->input->post('proper_followup'),
					
					"complete_notes" => $this->input->post('complete_notes'),
					"tagging_issue_category" => $this->input->post('tagging_issue_category'),
					
					"correct_ticket_status" => $this->input->post('correct_ticket_status'),
					
					"resolution_email" => $this->input->post('resolution_email'),
					"further_assistance" => $this->input->post('further_assistance'),
					"infraction_Gsat" => $this->input->post('infraction_Gsat'),
					"OYO_branding_closing_done" => $this->input->post('OYO_branding_closing_done'),
					"disconnect_check" => $this->input->post('disconnect_check'),
					
					"transaction_handled" => $this->input->post('transaction_handled'),
					"agent_profanity" => $this->input->post('agent_profanity'),
					"agent_sounded_rude" => $this->input->post('agent_sounded_rude'),
					"false_commitment" => $this->input->post('false_commitment'),
					"agent_raised_escalation" => $this->input->post('agent_raised_escalation'),
					"agent_raised_duplicate" => $this->input->post('agent_raised_duplicate'),
					"agent_adhered" => $this->input->post('agent_adhered'),
					
					"dd_val1" => $this->input->post('dd_val1'),
					"dd_val2" => $this->input->post('dd_val2'),
					"dd_val3" => $this->input->post('dd_val3'),
					"dd_val4" => $this->input->post('dd_val4'),
					"dd_val5" => $this->input->post('dd_val5'),
					"dd_val6" => $this->input->post('dd_val6'),
					"dd_val7" => $this->input->post('dd_val7'),
					"dd_val8" => $this->input->post('dd_val8'),
					"dd_val9" => $this->input->post('dd_val9'),
					"dd_val10" => $this->input->post('dd_val10'),
					"dd_val11" => $this->input->post('dd_val11'),
					"dd_val12" => $this->input->post('dd_val12'),
					"dd_val13" => $this->input->post('dd_val13'),
					"dd_val14" => $this->input->post('dd_val14'),
					"dd_val15" => $this->input->post('dd_val15'),
					"dd_val16" => $this->input->post('dd_val16'),
					"dd_val17" => $this->input->post('dd_val17'),
					"dd_val18" => $this->input->post('dd_val18'),
					"dd_val19" => $this->input->post('dd_val19'),
					"dd_val20" => $this->input->post('dd_val20'),
					"dd_val21" => $this->input->post('dd_val21'),
					"dd_val22" => $this->input->post('dd_val22'),
					"dd_val23" => $this->input->post('dd_val23'),
					
					
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($escalation_id==0){
					
					$a = $this->sig_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_sig/sig_chat_escalation/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_oyosig_chat_escalation_feedback',$field_array);
					// print_r($field_array);
					//exit();
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyosig_chat_escalation_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyosig_chat_escalation_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $escalation_id);
					$this->db->update('qa_oyosig_chat_escalation_feedback',$field_array);
					/////////
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
					$this->db->where('id', $escalation_id);
					$this->db->update('qa_oyosig_chat_escalation_feedback',$field_array1);
					
				}
				redirect('qa_oyo_sig/oyo_sig_chat');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function agent_oyosig_chat_fd()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/sig_chat/agent_oyosig_chat_fd.php";
			$data["agentUrl"] = "qa_oyo_sig/agent_oyosig_chat_fd";
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign!=''){
				
				$qSql="Select count(id) as value from qa_oyosig_chat_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_oyosig_chat_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate !="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyosig_chat_".$campaign."_feedback $cond) xx Left Join
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
	
	
	public function agent_sig_chat_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo_sig/sig_chat/agent_sig_chat_rvw.php";
			$data["agentUrl"] = "qa_oyo_sig/agent_oyosig_chat_fd";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyosig_chat_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["sig_chat"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data["campaign"] = $campaign;
			
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
				$this->db->update("qa_oyosig_chat_".$campaign."_feedback",$field_array1);
					
				redirect('qa_oyo_sig/agent_oyosig_chat_fd');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
}

?>