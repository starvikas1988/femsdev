<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_od extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		//$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_od_model');		
	 }
	
//////////////// management filtering data ////////////////////////
	
	public function qaod_management_sorting_feedback()
	{
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_management_feedback_review.php"; 
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			
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
				//"qa" => $qa,
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id,
				"current_user" => $current_user
			);	
			
			$data["get_management_review_list"] = $this->Qa_od_model->get_management_review_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}

///* review page of the feedback management portal *///

	public function qaod_management_status_form($id)
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_management_status_form.php"; 
			
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			$data["get_tl_id_list"] = $this->Qa_od_model->get_tl_id();
			
			$qSql="Select fusion_id, concat(fname, ' ', lname) as name from signin where (role_id in (select id from role where folder not in ('agent', 'support', 'super')) or dept_id in (5,11) )  and status=1 order by fusion_id";
			$data["get_coach_name"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data["get_view_feedback_entry"] = $this->Qa_od_model->view_feedback_entry_data($id);
			
			$data["fid"]=$id;
			
			$data["row1"] = $this->Qa_od_model->view_agent_review_data($id);//AGENT PURPOSE
			
			$data["row2"] = $this->Qa_od_model->view_management_review_data($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				
				$field_array1 = array(
					"agent_id" => $this->input->post('agent_id'),
					"chat_date" => mmddyy2mysql($this->input->post('chat_date')),
					"customer_id" => $this->input->post('customer_id'),
					"ani" => $this->input->post('ani'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"ack_chat_cust" => $this->input->post('ack_chat_cust'),
					"made_cust_feel_imp" => $this->input->post('made_cust_feel_imp'),
					"appro_sin_empathy" => $this->input->post('appro_sin_empathy'),
					"cust_clr_understood_crs" => $this->input->post('cust_clr_understood_crs'),
					"ccp_ask_sale" => $this->input->post('ccp_ask_sale'),
					"read_ack_understood_cust" => $this->input->post('read_ack_understood_cust'),
					"used_proper_guidelines" => $this->input->post('used_proper_guidelines'),
					"noted_appropriately" => $this->input->post('noted_appropriately'),
					"agent_maintained_control_chat" => $this->input->post('agent_maintained_control_chat'),
					"verified_info_appropriate_chat" => $this->input->post('verified_info_appropriate_chat'),
					"was_the_offer" => $this->input->post('was_the_offer'),
					"was_the_proper_dispo" => $this->input->post('was_the_proper_dispo'),
					"possible_score" => $this->input->post('possible_score'),
					"score" => $this->input->post('score'),					
					"call_summary" => $this->input->post('call_summary'),					
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fd_id);
				$this->db->update('qa_od_feedback',$field_array1);
			////////////	
				$field_array=array(
					"fd_id" => $fd_id,
					"mgnt_review_date" => CurrDate(),
					"coach_name" => $this->input->post('coach_name'),
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid = data_inserter('qa_od_mgnt_review', $field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_od_mgnt_review',$field_array);
				}
				
				redirect('qa_od/qaod_management_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
	
	
///* add management page of the OD feedback management portal *///		
	
	public function qaod_management_feedback_entry()
	{
		if(check_logged_in()){
			
			$user_office_id=get_user_office_id();
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			$data["get_tl_id_list"] = $this->Qa_od_model->get_tl_id();
			
			$data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_od/qaod_management_feedback_entry.php"; 
			
			
			$current_user=get_user_id();
			$curDateTime=date("Y-m-d h:i:sa");
			$log=get_logs();
			if($this->input->post('chat_date')!=''){
				$chat_date = mmddyy2mysql($this->input->post('chat_date'));
			}else{
				$chat_date = CurrDate();
			}
			
			
			if($this->input->post('agent_id'))
			{
				
				$config['upload_path'] = './qa_files/qa_od/';
				$config['allowed_types'] = 'mp3|avi|mp4|wmv';
				$config['max_size']     = '2024000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				$field_array=array(
					"chat_date" => $chat_date,
					"agent_id" => $this->input->post('agent_id'),
					"audit_date" => CurrDate(),
					"customer_id" => $this->input->post('customer_id'),
					"ani" => $this->input->post('ani'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"ack_chat_cust" => $this->input->post('ack_chat_cust'),
					"made_cust_feel_imp" => $this->input->post('made_cust_feel_imp'),
					"appro_sin_empathy" => $this->input->post('appro_sin_empathy'),
					"cust_clr_understood_crs" => $this->input->post('cust_clr_understood_crs'),
					"ccp_ask_sale" => $this->input->post('ccp_ask_sale'),
					"read_ack_understood_cust" => $this->input->post('read_ack_understood_cust'),
					"used_proper_guidelines" => $this->input->post('used_proper_guidelines'),
					"noted_appropriately" => $this->input->post('noted_appropriately'),
					"agent_maintained_control_chat" => $this->input->post('agent_maintained_control_chat'),
					"verified_info_appropriate_chat" => $this->input->post('verified_info_appropriate_chat'),
					"was_the_offer" => $this->input->post('was_the_offer'),
					"was_the_proper_dispo" => $this->input->post('was_the_proper_dispo'),
					"possible_score" => $this->input->post('possible_score'),
					"score" => $this->input->post('score'),					
					"call_summary" => $this->input->post('call_summary'),					
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				if (!$this->upload->do_upload('attach_file')){
					$error = $this->upload->display_errors();
					$data['message'] = $error;
					//$field_array["attach_file"] = $error;
					//echo $error;
				}else{
					$resume_file = $this->upload->data();
					//print_r($resume_file);
					$field_array["attach_file"] = $resume_file['file_name'];
				}
				
				$data["insert_feedback_entry"] = $this->Qa_od_model->data_insert_feedback_entry($field_array); 
				redirect('qa_od/qaod_management_sorting_feedback');
			}

			$this->load->view('dashboard',$data); 
			
		}
	}
	
	
	public function getTLname()
	{
		if(check_logged_in())
		{
			$aid=$this->input->post('aid');
			
			$qSql = "SELECT fusion_id, xpoid, batch_code, assigned_to, (select concat(fname, ' ', lname) as name from signin sx where sx.id=signin.assigned_to) as tl_name, DATEDIFF(CURDATE(), doj) as tenure from signin where id='$aid' and status='1'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
/////////////////////////////////		

//////////////////Agent QA OD Feedback///////////////////////

	public function qaod_agent_sorting_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_feedback_review.php"; 
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback"; 
			$url="qa_od/qaod_agent_sorting_feedback";
			$this->session->set_userdata('reroute',$url);
			
			$qSql="Select count(id) as value from qa_od_feedback where agent_id = '$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_od_feedback where id not in (select fd_id from qa_od_agent_review) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			
			if($from_date==""){ 
				$from_date='';
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date='';
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			
		if($this->input->get('btnView')=='View')
		{
				$field_array = array(
					"from_date"=>$from_date,
					"to_date" => $to_date,
					"current_user" => $current_user
				);

				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_review_data($field_array);
				
		}else{
				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_not_review_data($current_user);		

		}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
///* review page of the feedback agent portal *///

	public function qaod_agent_status_form($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_status_form.php";
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback";
			
			$data["view_agent_feedback_entry"] = $this->Qa_od_model->view_feedback_entry_data($id);//all agent data
			
			$data["fid"]=$id;
			
			$data["row1"] = $this->Qa_od_model->view_agent_review_data($id);//AGENT PURPOSE
			
			$data["row2"] = $this->Qa_od_model->view_management_review_data($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				
				$field_array=array(
					"fd_id" => $fd_id,
					"review_date" => CurrDate(),
					"agent_fd_acpt" => $this->input->post('agent_fd_acpt'),
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid = data_inserter('qa_od_agent_review', $field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_od_agent_review',$field_array );
				}
				
				redirect('qa_od/qaod_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
////////////////////////////////	
	public function qaod_report(){
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
			$data["content_template"] = "qa_od/qaod_report.php";
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$agent_id="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$date_from=$this->input->get('date_from');
			$date_to=$this->input->get('date_to');
			
			if($date_from==""){ 
				$date_from=CurrDate();
			}else{
				$date_from = mmddyy2mysql($date_from);
			}
			
			if($date_to==""){ 
				$date_to=CurrDate();
			}else{
				$date_to = mmddyy2mysql($date_to);
			}
			
			$data["qa_od_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = $date_from;
				$date_to = $date_to;
				$office_id = $this->input->get('office_id');
				$agent_id = $this->input->get('agent_id');
				$audit_type = $this->input->get('audit_type');
				
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
				if($agent_id!="") $cond .=" and agent_id='$agent_id'";
				if($audit_type!="")	$cond .=" and audit_type='$audit_type'";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
		
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=(select assigned_to from signin where id=agent_id)) as tl_name from qa_od_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, batch_code, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note,agent_fd_acpt, date(entry_date) as agent_rvw_date from qa_od_agent_review) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_od_mgnt_review) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_od_list"] = $fullAray;
				$this->create_qaod_CSV($fullAray);	
				$dn_link = base_url()."qa_od/download_qaod_CSV";
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['agent_id']=$agent_id;
			$data['audit_type']=$audit_type;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_qaod_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Office Depot Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qaod_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "WAVE", "Session ID/ANI", "Chat Date", "Customer ID", "Audit Type", "VOC", "Call Pass/Fail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "Acknowledged the chat customer", "Made the customer feel important", "Appropriate and sincere use of empathy", "Customer clearly understood the CSR", "The CCP must ASK FOR THE SALE", "Read acknowledged and understood the customer", "Used proper guidelines followed account level", "Noted appropriately", "Agent maintained control of the chat", "Verified information as appropriate to the chat", "Was the offer micro-conversion accepted", "Was the proper disposition code used on the chat", "Call Summary", "Feedback","Agent Review Status","Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['batch_code'].'",'; 
			$row .= '"'.$user['ani'].'",'; 
			$row .= '"'.$user['chat_date'].'",'; 
			$row .= '"'.$user['customer_id'].'",'; 
			$row .= '"'.$user['audit_type'].'",'; 
			$row .= '"'.$user['voc'].'",'; 
			$row .= '"'.$user['call_pass_fail'].'",'; 
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",'; 
			$row .= '"'.$user['score'].'",';
			$row .= '"'.$user['possible_score'].'",'; 
			$row .= '"'.$user['ack_chat_cust'].'",'; 
			$row .= '"'.$user['made_cust_feel_imp'].'",'; 
			$row .= '"'.$user['appro_sin_empathy'].'",'; 
			$row .= '"'.$user['cust_clr_understood_crs'].'",'; 
			$row .= '"'.$user['ccp_ask_sale'].'",'; 
			$row .= '"'.$user['read_ack_understood_cust'].'",'; 
			$row .= '"'.$user['used_proper_guidelines'].'",'; 
			$row .= '"'.$user['noted_appropriately'].'",'; 
			$row .= '"'.$user['agent_maintained_control_chat'].'",'; 
			$row .= '"'.$user['verified_info_appropriate_chat'].'",'; 
			$row .= '"'.$user['was_the_offer'].'",'; 
			$row .= '"'.$user['was_the_proper_dispo'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
}

?>