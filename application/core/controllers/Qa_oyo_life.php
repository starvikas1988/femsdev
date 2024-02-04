<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_oyo_life extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_oyolife_model');
		
	 }

///////////////////////////////////////////////////////////////////////////////////////////	 
/*----------------------------OYO LIFE INBOUND/OUTBOUND----------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////

	public function index(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_ib_ob/qa_oyolife_ib_ob_feedback.php";
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
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
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id,
				"current_user" => $current_user
			);
			$data["qa_oyolife_ib_ob_data"] = $this->Qa_oyolife_model->get_qa_oyolife_ib_ob_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function add_oyolife_ib_ob_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_ib_ob/add_ib_ob_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_oyolife_ibob_disposition where is_active=1";
			$data['ibob_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				
				if($this->input->post('welcome_customer')=='5') $wc_reason = 'N/A';
				else $wc_reason = $this->input->post('wc_reason');
				if($this->input->post('know_customer')=='5') $kyc_reason = 'N/A';
				else $kyc_reason = $this->input->post('kyc_reason');
				if($this->input->post('effective_communication')=='10') $ec_reason = 'N/A';
				else $ec_reason = $this->input->post('ec_reason');
				if($this->input->post('building_rapport')=='15') $br_reason = 'N/A';
				else $br_reason = $this->input->post('br_reason');
				if($this->input->post('maintain_courtesy')=='10') $mc_reason = 'N/A';
				else $mc_reason = $this->input->post('mc_reason');
				if($this->input->post('probing_assistance')=='10') $pa_reason = 'N/A';
				else $pa_reason = $this->input->post('pa_reason');
				if($this->input->post('significance_info')=='20') $si_reason = 'N/A';
				else $si_reason = $this->input->post('si_reason');
				if($this->input->post('action_solution')=='15') $as_reason = 'N/A';
				else $as_reason = $this->input->post('as_reason');
				if($this->input->post('proper_docu')=='10') $pd_reason = 'N/A';
				else $pd_reason = $this->input->post('pd_reason');
				if($this->input->post('zero_tolerance')=='N/A') $ztp_reason = 'N/A';
				else $ztp_reason = $this->input->post('ztp_reason');
				
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrMySqlDate(),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"lob" => $this->input->post('lob'),
					"overall_score" => $this->input->post('total_score'),
					"welcome_customer" => $this->input->post('welcome_customer'),
					"know_customer" => $this->input->post('know_customer'),
					"effective_communication" => $this->input->post('effective_communication'),
					"building_rapport" => $this->input->post('building_rapport'),
					"maintain_courtesy" => $this->input->post('maintain_courtesy'),
					"probing_assistance" => $this->input->post('probing_assistance'),
					"significance_info" => $this->input->post('significance_info'),
					"action_solution" => $this->input->post('action_solution'),
					"proper_docu" => $this->input->post('proper_docu'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"wc_reason" => $wc_reason,
					"kyc_reason" => $kyc_reason,
					"ec_reason" => $ec_reason,
					"br_reason" => $br_reason,
					"mc_reason" => $mc_reason,
					"pa_reason" => $pa_reason,
					"si_reason" => $si_reason,
					"as_reason" => $as_reason,
					"pd_reason" => $pd_reason,
					"ztp_reason" => $ztp_reason,
					"agent_disposition" => $this->input->post('agent_disposition'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"correct_incorrect" => $this->input->post('correct_incorrect'),
					"oppor_nonoppor" => $this->input->post('oppor_nonoppor'),
					"rebuttals_probing" => $this->input->post('rebuttals_probing'),
					"acpt" => $this->input->post('acpt'),
					"observation_l1" => $this->input->post('observation_l1'),
					"audit_observe" => $this->input->post('audit_observe'),
					"agent_info" => $this->input->post('agent_info'),
					"customer_agreed" => $this->input->post('customer_agreed'),
					"correct_property" => $this->input->post('correct_property'),
					"valid_invalid" => $this->input->post('valid_invalid'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->life_ib_ob_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_oyolife_ib_ob_feedback',$field_array);
				redirect('Qa_oyo_life');
			}
			$data["array"] = $a;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	private function life_ib_ob_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_oyo_life/oyo_life_ibob/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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
	
	
	public function mgnt_oyolife_ib_ob_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_ib_ob/mgnt_oyolife_ib_ob_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_oyolife_ibob_disposition where is_active=1";
			$data['ibob_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql="Select fusion_id, concat(fname, ' ', lname) as name from signin where (role_id in (select id from role where folder not in ('agent', 'support', 'super')) or dept_id=11 )  and status=1 order by fusion_id";
			$data["get_coach_name"] = $this->Common_model->get_query_result_array($qSql); */
			
			
			$data["get_oyolife_ib_od_feedback"] = $this->Qa_oyolife_model->view_oyolife_ib_od_feedback($id);
			
			$data["lio_id"]=$id;
			
			$data["row1"] = $this->Qa_oyolife_model->view_agent_oyolife_ib_ob_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_oyolife_model->view_mgnt_oyolife_ib_ob_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('lio_id'))
			{
				$lio_id=$this->input->post('lio_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				if($this->input->post('welcome_customer')=='5') $wc_reason = 'N/A';
				else $wc_reason = $this->input->post('wc_reason');
				if($this->input->post('know_customer')=='5') $kyc_reason = 'N/A';
				else $kyc_reason = $this->input->post('kyc_reason');
				if($this->input->post('effective_communication')=='10') $ec_reason = 'N/A';
				else $ec_reason = $this->input->post('ec_reason');
				if($this->input->post('building_rapport')=='15') $br_reason = 'N/A';
				else $br_reason = $this->input->post('br_reason');
				if($this->input->post('maintain_courtesy')=='10') $mc_reason = 'N/A';
				else $mc_reason = $this->input->post('mc_reason');
				if($this->input->post('probing_assistance')=='10') $pa_reason = 'N/A';
				else $pa_reason = $this->input->post('pa_reason');
				if($this->input->post('significance_info')=='20') $si_reason = 'N/A';
				else $si_reason = $this->input->post('si_reason');
				if($this->input->post('action_solution')=='15') $as_reason = 'N/A';
				else $as_reason = $this->input->post('as_reason');
				if($this->input->post('proper_docu')=='10') $pd_reason = 'N/A';
				else $pd_reason = $this->input->post('pd_reason');
				if($this->input->post('zero_tolerance')=='N/A') $ztp_reason = 'N/A';
				else $ztp_reason = $this->input->post('ztp_reason');
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"lob" => $this->input->post('lob'),
					"overall_score" => $this->input->post('total_score'),
					"welcome_customer" => $this->input->post('welcome_customer'),
					"know_customer" => $this->input->post('know_customer'),
					"effective_communication" => $this->input->post('effective_communication'),
					"building_rapport" => $this->input->post('building_rapport'),
					"maintain_courtesy" => $this->input->post('maintain_courtesy'),
					"probing_assistance" => $this->input->post('probing_assistance'),
					"significance_info" => $this->input->post('significance_info'),
					"action_solution" => $this->input->post('action_solution'),
					"proper_docu" => $this->input->post('proper_docu'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"wc_reason" => $wc_reason,
					"kyc_reason" => $kyc_reason,
					"ec_reason" => $ec_reason,
					"br_reason" => $br_reason,
					"mc_reason" => $mc_reason,
					"pa_reason" => $pa_reason,
					"si_reason" => $si_reason,
					"as_reason" => $as_reason,
					"pd_reason" => $pd_reason,
					"ztp_reason" => $ztp_reason,
					"agent_disposition" => $this->input->post('agent_disposition'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"correct_incorrect" => $this->input->post('correct_incorrect'),
					"oppor_nonoppor" => $this->input->post('oppor_nonoppor'),
					"rebuttals_probing" => $this->input->post('rebuttals_probing'),
					"acpt" => $this->input->post('acpt'),
					"observation_l1" => $this->input->post('observation_l1'),
					"audit_observe" => $this->input->post('audit_observe'),
					"agent_info" => $this->input->post('agent_info'),
					"customer_agreed" => $this->input->post('customer_agreed'),
					"correct_property" => $this->input->post('correct_property'),
					"valid_invalid" => $this->input->post('valid_invalid'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $lio_id);
				$this->db->update('qa_oyolife_ib_ob_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $lio_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_oyolife_ib_ob_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $lio_id);
					$this->db->update('qa_oyolife_ib_ob_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_oyo_life');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////	 
/*--------------------------------OYO LIFE FOLLOW UP-------------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_oyolife_followup_feedback(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_followup/qa_oyolife_followup_feedback.php";
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
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
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id,
				"current_user" => $current_user
			);
			$data["qa_oyolife_followup_data"] = $this->Qa_oyolife_model->get_qa_oyolife_followup_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function add_oyolife_followup_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_followup/add_oyolife_followup_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_oyolife_followup_disposition where is_active=1";
			$data['followup_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				
				if($this->input->post('opening')=='15') $opening_reason='N/A';
				else $opening_reason = $this->input->post('opening_reason');
				if($this->input->post('product')=='15') $product_reason='N/A';
				else $product_reason = $this->input->post('product_reason');
				if($this->input->post('rebuttals')=='25') $rebuttals_reason='N/A';
				else $rebuttals_reason = $this->input->post('rebuttals_reason');
				if($this->input->post('sales_effort')=='20') $sales_effort_reason='N/A';
				else $sales_effort_reason = $this->input->post('sales_effort_reason');
				if($this->input->post('closing')=='10') $closing_reason='N/A';
				else $closing_reason = $this->input->post('closing_reason');
				if($this->input->post('compliance')=='15') $compliance_reason='N/A';
				else $compliance_reason = $this->input->post('compliance_reason');
				if($this->input->post('zero_tolerance')=='N/A') $ztp_reason='N/A';
				else $ztp_reason = $this->input->post('ztp_reason');
				
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrMySqlDate(),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"overall_score" => $this->input->post('total_score'),
					"opening" => $this->input->post('opening'),
					"product" => $this->input->post('product'),
					"rebuttals" => $this->input->post('rebuttals'),
					"sales_effort" => $this->input->post('sales_effort'),
					"closing" => $this->input->post('closing'),
					"compliance" => $this->input->post('compliance'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"opening_reason" => $opening_reason,
					"product_reason" => $product_reason,
					"rebuttals_reason" => $rebuttals_reason,
					"sales_effort_reason" => $sales_effort_reason,
					"closing_reason" => $closing_reason,
					"compliance_reason" => $compliance_reason,
					"ztp_reason" => $ztp_reason,
					"agent_dispo" => $this->input->post('agent_dispo'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"correct_incorrect" => $this->input->post('correct_incorrect'),
					"acpt" => $this->input->post('acpt'),
					"audit_observe" => $this->input->post('audit_observe'),
					"l1_observe" => $this->input->post('l1_observe'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->life_followup_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_oyolife_followup_feedback',$field_array);
				redirect('Qa_oyo_life/qa_oyolife_followup_feedback');
			}
			$data["array"] = $a;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	private function life_followup_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_oyo_life/oyo_life_followup/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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
	
	public function mgnt_oyolife_followup_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_followup/mgnt_oyolife_followup_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_oyolife_followup_disposition where is_active=1";
			$data['followup_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql="Select fusion_id, concat(fname, ' ', lname) as name from signin where (role_id in (select id from role where folder not in ('agent', 'support', 'super')) or dept_id=11 )  and status=1 order by fusion_id";
			$data["get_coach_name"] = $this->Common_model->get_query_result_array($qSql); */
			
			
			$data["get_oyolife_followup_feedback"] = $this->Qa_oyolife_model->view_oyolife_followup_feedback($id);
			
			$data["fu_id"]=$id;
			
			$data["row1"] = $this->Qa_oyolife_model->view_agent_oyolife_followup_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_oyolife_model->view_mgnt_oyolife_followup_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('fu_id'))
			{
				$fu_id=$this->input->post('fu_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				if($this->input->post('opening')=='15') $opening_reason='N/A';
				else $opening_reason = $this->input->post('opening_reason');
				if($this->input->post('product')=='15') $product_reason='N/A';
				else $product_reason = $this->input->post('product_reason');
				if($this->input->post('rebuttals')=='25') $rebuttals_reason='N/A';
				else $rebuttals_reason = $this->input->post('rebuttals_reason');
				if($this->input->post('sales_effort')=='20') $sales_effort_reason='N/A';
				else $sales_effort_reason = $this->input->post('sales_effort_reason');
				if($this->input->post('closing')=='10') $closing_reason='N/A';
				else $closing_reason = $this->input->post('closing_reason');
				if($this->input->post('compliance')=='15') $compliance_reason='N/A';
				else $compliance_reason = $this->input->post('compliance_reason');
				if($this->input->post('zero_tolerance')=='N/A') $ztp_reason='N/A';
				else $ztp_reason = $this->input->post('ztp_reason');
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"overall_score" => $this->input->post('total_score'),
					"opening" => $this->input->post('opening'),
					"product" => $this->input->post('product'),
					"rebuttals" => $this->input->post('rebuttals'),
					"sales_effort" => $this->input->post('sales_effort'),
					"closing" => $this->input->post('closing'),
					"compliance" => $this->input->post('compliance'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"opening_reason" => $opening_reason,
					"product_reason" => $product_reason,
					"rebuttals_reason" => $rebuttals_reason,
					"sales_effort_reason" => $sales_effort_reason,
					"closing_reason" => $closing_reason,
					"compliance_reason" => $compliance_reason,
					"ztp_reason" => $ztp_reason,
					"agent_dispo" => $this->input->post('agent_dispo'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"correct_incorrect" => $this->input->post('correct_incorrect'),
					"acpt" => $this->input->post('acpt'),
					"audit_observe" => $this->input->post('audit_observe'),
					"l1_observe" => $this->input->post('l1_observe'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $fu_id);
				$this->db->update('qa_oyolife_followup_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $fu_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_oyolife_followup_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $fu_id);
					$this->db->update('qa_oyolife_followup_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_oyo_life/qa_oyolife_followup_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
///////////////////////////////////////////////////////////////////////////////////////////	 
/*----------------------------------OYO LIFE BOOKING-------------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////	
	
	public function qa_oyolife_booking_feedback(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_booking/qa_oyolife_booking_feedback.php";
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
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
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id,
				"current_user" => $current_user
			);
			$data["qa_oyolife_booking_data"] = $this->Qa_oyolife_model->get_qa_oyolife_booking_data($field_array);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function add_oyolife_booking_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_booking/add_oyolife_booking_feedback.php";
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_oyolife_followup_disposition where is_active=1";
			$data['followup_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				if($this->input->post('opening')=='15') $opening_reason='N/A';
				else $opening_reason = $this->input->post('opening_reason');
				if($this->input->post('product')=='15') $product_reason='N/A';
				else $product_reason = $this->input->post('product_reason');
				if($this->input->post('rebuttals')=='25') $rebuttals_reason='N/A';
				else $rebuttals_reason = $this->input->post('rebuttals_reason');
				if($this->input->post('sales_effort')=='20') $sales_effort_reason='N/A';
				else $sales_effort_reason = $this->input->post('sales_effort_reason');
				if($this->input->post('closing')=='10') $closing_reason='N/A';
				else $closing_reason = $this->input->post('closing_reason');
				if($this->input->post('compliance')=='15') $compliance_reason='N/A';
				else $compliance_reason = $this->input->post('compliance_reason');
				if($this->input->post('zero_tolerance')=='N/A') $ztp_reason='N/A';
				else $ztp_reason = $this->input->post('ztp_reason');
				
				$field_array=array(
					"audit_date" => CurrMySqlDate(),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"overall_score" => $this->input->post('total_score'),
					"opening" => $this->input->post('opening'),
					"product" => $this->input->post('product'),
					"rebuttals" => $this->input->post('rebuttals'),
					"sales_effort" => $this->input->post('sales_effort'),
					"closing" => $this->input->post('closing'),
					"compliance" => $this->input->post('compliance'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"opening_reason" => $opening_reason,
					"product_reason" => $product_reason,
					"rebuttals_reason" => $rebuttals_reason,
					"sales_effort_reason" => $sales_effort_reason,
					"closing_reason" => $closing_reason,
					"compliance_reason" => $compliance_reason,
					"ztp_reason" => $ztp_reason,
					"agent_dispo" => $this->input->post('agent_dispo'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"correct_incorrect" => $this->input->post('correct_incorrect'),
					"acpt" => $this->input->post('acpt'),
					"audit_observe" => $this->input->post('audit_observe'),
					"l1_observe" => $this->input->post('l1_observe'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->life_booking_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_oyolife_booking_feedback',$field_array);
				redirect('Qa_oyo_life/qa_oyolife_booking_feedback');
			}
			$data["array"] = $a;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	private function life_booking_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_oyo_life/oyo_life_booking/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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
	
	public function mgnt_oyolife_booking_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_booking/mgnt_oyolife_booking_feedback_rvw.php";
			
			$data["agentName"] = $this->Qa_oyolife_model->get_agent_id(90,145);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_oyolife_followup_disposition where is_active=1";
			$data['followup_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql="Select fusion_id, concat(fname, ' ', lname) as name from signin where (role_id in (select id from role where folder not in ('agent', 'support', 'super')) or dept_id=11 )  and status=1 order by fusion_id";
			$data["get_coach_name"] = $this->Common_model->get_query_result_array($qSql); */
			
			
			$data["get_oyolife_booking_feedback"] = $this->Qa_oyolife_model->view_oyolife_booking_feedback($id);
			
			$data["fu_id"]=$id;
			
			$data["row1"] = $this->Qa_oyolife_model->view_agent_oyolife_booking_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_oyolife_model->view_mgnt_oyolife_booking_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('fu_id'))
			{
				$fu_id=$this->input->post('fu_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				if($this->input->post('opening')=='15') $opening_reason='N/A';
				else $opening_reason = $this->input->post('opening_reason');
				if($this->input->post('product')=='15') $product_reason='N/A';
				else $product_reason = $this->input->post('product_reason');
				if($this->input->post('rebuttals')=='25') $rebuttals_reason='N/A';
				else $rebuttals_reason = $this->input->post('rebuttals_reason');
				if($this->input->post('sales_effort')=='20') $sales_effort_reason='N/A';
				else $sales_effort_reason = $this->input->post('sales_effort_reason');
				if($this->input->post('closing')=='10') $closing_reason='N/A';
				else $closing_reason = $this->input->post('closing_reason');
				if($this->input->post('compliance')=='15') $compliance_reason='N/A';
				else $compliance_reason = $this->input->post('compliance_reason');
				if($this->input->post('zero_tolerance')=='N/A') $ztp_reason='N/A';
				else $ztp_reason = $this->input->post('ztp_reason');
				
				$field_array = array(
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"overall_score" => $this->input->post('total_score'),
					"opening" => $this->input->post('opening'),
					"product" => $this->input->post('product'),
					"rebuttals" => $this->input->post('rebuttals'),
					"sales_effort" => $this->input->post('sales_effort'),
					"closing" => $this->input->post('closing'),
					"compliance" => $this->input->post('compliance'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"opening_reason" => $opening_reason,
					"product_reason" => $product_reason,
					"rebuttals_reason" => $rebuttals_reason,
					"sales_effort_reason" => $sales_effort_reason,
					"closing_reason" => $closing_reason,
					"compliance_reason" => $compliance_reason,
					"ztp_reason" => $ztp_reason,
					"agent_dispo" => $this->input->post('agent_dispo'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"correct_incorrect" => $this->input->post('correct_incorrect'),
					"acpt" => $this->input->post('acpt'),
					"audit_observe" => $this->input->post('audit_observe'),
					"l1_observe" => $this->input->post('l1_observe'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $fu_id);
				$this->db->update('qa_oyolife_booking_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $fu_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_oyolife_booking_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $fu_id);
					$this->db->update('qa_oyolife_booking_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_oyo_life/qa_oyolife_booking_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////Agent Part/////////////////////////
	public function agent_oyo_life_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/agent_oyolife_feedback.php";
			$data["agentUrl"] = "qa_oyo_life/agent_oyo_life_feedback";
			
			
			$qSql="Select count(id) as value from qa_oyolife_ib_ob_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_ib_ob_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_oyolife_ib_ob_feedback where id  not in (select fd_id from qa_oyolife_ib_ob_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_ib_ob_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
		////////////

			$qSql="Select count(id) as value from qa_oyolife_followup_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_followup_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_oyolife_followup_feedback where id  not in (select fd_id from qa_oyolife_followup_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_followup_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
		////////////

			$qSql="Select count(id) as value from qa_oyolife_booking_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_booking_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_oyolife_booking_feedback where id  not in (select fd_id from qa_oyolife_booking_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_booking_yet_rvw"] =  $this->Common_model->get_single_value($qSql);	
				
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

				$data["get_agent_review_list"] = $this->Qa_oyolife_model->oyolife_ibob_agent_rvw($field_array);
				$data["get_agent_fu_review_list"] = $this->Qa_oyolife_model->oyolife_followup_agent_rvw($field_array);
				$data["get_agent_booking_review_list"] = $this->Qa_oyolife_model->oyolife_booking_agent_rvw($field_array);
					
			}else{	
				$data["get_agent_review_list"] = $this->Qa_oyolife_model->oyolife_ibob_agent_not_rvw($current_user);			
				$data["get_agent_fu_review_list"] = $this->Qa_oyolife_model->oyolife_followup_agent_not_rvw($current_user);			
				$data["get_agent_booking_review_list"] = $this->Qa_oyolife_model->oyolife_booking_agent_not_rvw($current_user);			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
/*------------------Agent IB/OB Part-----------------------*/	
	public function agent_oyolife_ibob_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_ib_ob/agent_oyolife_ib_ob_feedback_rvw.php";
			$data["agentUrl"] = "qa_oyo_life/agent_oyo_life_feedback";
			
			$qSql="Select * from qa_oyolife_ibob_disposition where is_active=1";
			$data['ibob_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["get_oyolife_ib_od_feedback"] = $this->Qa_oyolife_model->view_oyolife_ib_od_feedback($id);
			
			$data["lio_id"]=$id;
			
			$data["row1"] = $this->Qa_oyolife_model->view_agent_oyolife_ib_ob_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_oyolife_model->view_mgnt_oyolife_ib_ob_rvw($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				
				$field_array=array(
					"fd_id" => $fd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_oyolife_ib_ob_agent_rvw',$field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_oyolife_ib_ob_agent_rvw',$field_array);
				}
				redirect('Qa_oyo_life/agent_oyo_life_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}
	
/*------------------Agent Follow Up Part-----------------------*/	
	 
	public function agent_oyolife_followup_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_followup/agent_oyolife_followup_feedback_rvw.php";
			$data["agentUrl"] = "qa_oyo_life/agent_oyo_life_feedback";
			
			$qSql="Select * from qa_oyolife_followup_disposition where is_active=1";
			$data['followup_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["get_oyolife_followup_feedback"] = $this->Qa_oyolife_model->view_oyolife_followup_feedback($id);
			
			$data["fu_id"]=$id;
			
			$data["row1"] = $this->Qa_oyolife_model->view_agent_oyolife_followup_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_oyolife_model->view_mgnt_oyolife_followup_rvw($id);//MGNT PURPOSE
			
			
			if($this->input->post('fu_id'))
			{
				$fu_id=$this->input->post('fu_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				
				$field_array=array(
					"fd_id" => $fu_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_oyolife_followup_agent_rvw',$field_array);
				}else{
					$this->db->where('fd_id', $fu_id);
					$this->db->update('qa_oyolife_followup_agent_rvw',$field_array);
				}
				redirect('Qa_oyo_life/agent_oyo_life_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}
	
/*------------------Agent Booking Part-----------------------*/	
	 
	public function agent_oyolife_booking_feedback_rvw($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyolife/oyolife_booking/agent_oyolife_booking_feedback_rvw.php";
			$data["agentUrl"] = "qa_oyo_life/agent_oyo_life_feedback";
			
			$qSql="Select * from qa_oyolife_followup_disposition where is_active=1";
			$data['followup_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["get_oyolife_booking_feedback"] = $this->Qa_oyolife_model->view_oyolife_booking_feedback($id);
			
			$data["fu_id"]=$id;
			
			$data["row1"] = $this->Qa_oyolife_model->view_agent_oyolife_booking_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_oyolife_model->view_mgnt_oyolife_booking_rvw($id);//MGNT PURPOSE
			
			
			if($this->input->post('fu_id'))
			{
				$fu_id=$this->input->post('fu_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				
				$field_array=array(
					"fd_id" => $fu_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_oyolife_booking_agent_rvw',$field_array);
				}else{
					$this->db->where('fd_id', $fu_id);
					$this->db->update('qa_oyolife_booking_agent_rvw',$field_array);
				}
				redirect('Qa_oyo_life/agent_oyo_life_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}	
	}
	
	
////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "SELECT * from (Select id, assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name, fusion_id, get_process_names(id) as process_name FROM signin m where id = '$aid') xx Left Join (Select user_id, phone from info_personal) yy On (xx.id=yy.user_id) ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	 
}
?>