<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_tracing extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
//==========================================================================================
///=========================== COVID CASE PART  ================================///
	
	public function index(){
				
		redirect(base_url()."contact_tracing/form/");
	 
	}
	 
	
	
	public function form()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$data['crmid'] = $crmid = $this->generate_crm_id();
		$data["crmid"] = $crmid = $this->uri->segment(3);
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "contact_tracing/aside.php";
		$data["content_template"] = "contact_tracing/covid_case_form.php";
		$data['uri'] = $this->uri->segment(4);
		$data['mysections'] = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 'exposure', 'risk', 'aftercase');
		$data['allCountries'] = $this->master_countries();						
		
		// CHECK CRM VALIDATION
		$sql_crm_check = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crmid' AND case_source = 'individual'";
		$query_crm_check = $this->Common_model->get_single_value($sql_crm_check);
		$data['crm_validation'] = $query_crm_check;
		
		if($query_crm_check > 0){
									
		if($this->uri->segment(4) == 'personal'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["content_template"] = "contact_tracing/covid_case_form.php";
		}
		
		if($this->uri->segment(4) == 'administrative'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data['ai_address'] = $this->ai_check_address($crmid);	
			$data["content_template"] = "contact_tracing/covid_case_form_administrative.php";
		}
		
		if($this->uri->segment(4) == 'demographics'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["content_template"] = "contact_tracing/covid_case_form_demographics.php";
		}
		
		if($this->uri->segment(4) == 'clinical'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["content_template"] = "contact_tracing/covid_case_form_clinical.php";
		}
		
		if($this->uri->segment(4) == 'treatment'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["content_template"] = "contact_tracing/covid_case_form_treatment.php";
		}
		
		if($this->uri->segment(4) == 'notes'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);
			$data['ai_address'] = $this->ai_check_address($crmid);	
			$data["content_template"] = "contact_tracing/covid_case_form_notes.php";
		}
		
		if($this->uri->segment(4) == 'exposure'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmrow"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["crmdetails"] = $this->covid_case_details_exposure($crmid, 'transmission');
			$data["content_template"] = "contact_tracing/covid_case_form_exposure.php";
		}
		
		if($this->uri->segment(4) == 'risk'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["content_template"] = "contact_tracing/covid_case_form_risk.php";
		}
		
		if($this->uri->segment(4) == 'transmission'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmrow"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["crmdetails"] = $this->covid_case_details_exposure($crmid, 'transmission');
			$data["onset"] = $this->covid_case_details_exposure($crmid, 'exposure', '-2');
			$data["content_template"] = "contact_tracing/covid_case_form_transmission.php";
		}
		
		if($this->uri->segment(4) == 'aftercase'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data["content_template"] = "contact_tracing/covid_case_form_aftercase.php";
		}
		
		if($this->uri->segment(4) == 'investigation'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data["crminvestigation"] = $this->covid_case_details_investigation($crmid);
			$data["content_template"] = "contact_tracing/covid_case_form_investigation_notes.php";
		}
		
		if($this->uri->segment(4) == 'contacts'){
			$data["crmid"] = $crmid = $this->uri->segment(3);
			$data["crmdetails"] = $this->covid_case_details($crmid);
			$data['crm_treatment'] = $this->check_treatment($crmid);	
			$data["crmcontact"] = $this->covid_case_details_contact_action($crmid);
			$data["content_template"] = "contact_tracing/covid_case_form_contact_actions.php";
		}
		
		} else {
		
			$data["content_template"] = "contact_tracing/covid_case_form_invalid.php";
		}
		
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function searchcase()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "contact_tracing/aside.php";
		$data["content_template"] = "contact_tracing/covid_case_form_search.php";
		
		if(!empty($this->input->post('case_search')))
		{
			$data['casecrmid'] = $crm_id = $this->input->post('crm_id');
			$data['casename'] = $case_name = $this->input->post('case_name');
			$data['casephone'] = $case_phone = $this->input->post('case_phone');
			$data['caseemail'] = $case_email = $this->input->post('case_email');
			
			$extrawhere = "";
			if(!empty($crm_id)){ $extrawhere .= " AND c.crm_id = '$crm_id'"; }
			if(!empty($case_name)){ $extrawhere .= " AND c.fname LIKE '%$case_name%' OR c.lname LIKE '%$case_name%'"; }
			if(!empty($case_phone)){ $extrawhere .= " AND i.p_phone LIKE '%$case_phone%'"; }
			if(!empty($case_email)){ $extrawhere .= " AND i.p_email LIKE '%$case_email%'"; }
			
			$sqlcheck = "SELECT c.*,s.*,i.p_phone,i.p_email, c.fname as case_fname, c.lname as case_lname, c.date_added as case_added from covid19_case as c LEFT JOIN covid19_case_info i on i.crm_id = c.crm_id LEFT JOIN signin as s ON s.id = c.added_by
			             WHERE 1 $extrawhere";
			$querycheck = $this->Common_model->get_query_result_array($sqlcheck);
			if($querycheck > 0){ 
				$data['totaldata'] = count($querycheck);
				$data['case_list'] = $querycheck;
			}
			else { redirect('covid_case/updatecase/error'); }
		}

		$this->load->view('dashboard',$data);
	 
	}
	 
	
	public function sendtoform($formid = 1, $crmid='', $type='success')
	{
		if($formid == 1)
		{
			redirect('contact_tracing/form/'.$crmid.'/personal/'.$type);
		}
		
		if($formid == 2)
		{
			redirect('contact_tracing/form/'.$crmid.'/administrative/'.$type);
		}
		
		if($formid == 3)
		{
			redirect('contact_tracing/form/'.$crmid.'/demographics/'.$type);
		}
		
		if($formid == 4)
		{
			redirect('contact_tracing/form/'.$crmid.'/clinical/'.$type);
		}
		
		if($formid == 5)
		{
			redirect('contact_tracing/form/'.$crmid.'/treatment/'.$type);
		}
		
		if($formid == 6)
		{
			redirect('contact_tracing/form/'.$crmid.'/notes/'.$type);
		}
		
		if($formid == 7)
		{
			redirect('contact_tracing/form/'.$crmid.'/exposure/'.$type);
		}
		
		if($formid == 8)
		{
			redirect('contact_tracing/form/'.$crmid.'/transmission/'.$type);
		}
		
		if($formid == 9)
		{
			redirect('contact_tracing/form/'.$crmid.'/risk/'.$type);
		}
		
		if($formid == 10)
		{
			redirect('contact_tracing/form/'.$crmid.'/aftercase/'.$type);
		}
		
		if($formid == 11)
		{
			redirect('contact_tracing/form/'.$crmid.'/investigation/'.$type);
		}
		
		if($formid == 12)
		{
			redirect('contact_tracing/form/'.$crmid.'/contacts/'.$type);
		}
	}
	
	
	public function check_logs()
	{
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "contact_tracing/aside.php";
		$data["content_template"] = "contact_tracing/covid_case_tracker.php";
		
		$crm_id = $this->uri->segment(3);
		$data["crmdetails"] = $this->covid_case_details($crm_id);
		$sql = "SELECT * from covid19_case_logs as l LEFT JOIN signin as s ON l.cl_added_by = s.id WHERE l.crm_id = '$crm_id' ORDER by l.cl_date_added DESC";
		$data['logdetails'] = $logsdetails = $this->Common_model->get_query_result_array($sql);
		
		$this->load->view('dashboard',$data);
	}	
	
	public function master_countries()
	{
		$sql = "SELECT * FROM master_countries ORDER BY name ASC";
		$query = $this->Common_model->get_query_result_array($sql);
		$lastdata = $this->uri->segment($this->uri->total_segments());
		if($lastdata == 'data'){ 
			echo json_encode($query);
		} else {
			return $query;
		}
	}
	public function master_states()
	{
		$country = $this->input->post('country');
		if(empty($country)){ $country = $this->uri->segment(3); }
		if(!empty($country)){ $extrafilter = " AND country_id = '$country' "; }
		
		$sql = "SELECT * FROM master_states WHERE 1 $extrafilter ORDER BY name ASC";
		$query = $this->Common_model->get_query_result_array($sql);
		$lastdata = $this->uri->segment($this->uri->total_segments());
		if($lastdata == 'data'){ 
			echo json_encode($query);
		} else {
			return $query;
		}
	}
	
	public function master_cities()
	{
		$state = $this->input->post('state');
		if(empty($state)){ $state = $this->uri->segment(3); }
		if(!empty($state)){ $extrafilter = " AND state_id = '$state' "; }
		
		$sql = "SELECT * FROM master_cities WHERE 1 $extrafilter ORDER BY name ASC";
		$query = $this->Common_model->get_query_result_array($sql);
		$lastdata = $this->uri->segment($this->uri->total_segments());
		if($lastdata == 'data'){ 
			echo json_encode($query);
		} else {
			return $query;
		}
	}
	
	//--------- CRM ID
	public function generate_crm_id()
	{
		$sql = "SELECT count(*) as value from covid19_case ORDER by cid DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_crm_id = "CV" .mt_rand(11,99) .sprintf('%06d', $lastid + 1);
		return $new_crm_id;
	}
	
	public function check_treatment($crmid)
	{
		$sql = "SELECT t_treatment_1, a_is_outbreak_related from covid19_case_info WHERE crm_id = '$crmid' LIMIT 1";
		$treatment_details = $this->Common_model->get_query_row_array($sql);
		$treatment_status = $treatment_details['t_treatment_1'];
		$outbreak_status = $treatment_details['a_is_outbreak_related'];
		if(($outbreak_status == 'N') || ($treatment_status != 'Y'))
		{
			$flag = "N";
		} else {
			$flag = "Y";
		}
		return $flag;
	}
	
	
	public function covid_case_details($cid)
	{
		$sql = "SELECT * from covid19_case as c 
		        LEFT JOIN covid19_case_info as cf ON cf.crm_id = c.crm_id
				WHERE c.crm_id = '$cid'";
		$covidCase = $this->Common_model->get_query_row_array($sql);
		return $covidCase;
	}
	
	public function covid_case_details_exposure($cid, $type = '', $day = '')
	{
		$extraq = "";
		if(!empty($type)){ $extraq .= " AND c.e_type = '$type'"; }
		if(!empty($day)){ $extraq .= " AND c.e_day = '$day'"; }
		
		$sql = "SELECT * from covid19_case_exposure as c 
		        LEFT JOIN covid19_case as cf ON cf.crm_id = c.crm_id
				WHERE c.crm_id = '$cid' $extraq";
		$covidCase = $this->Common_model->get_query_result_array($sql);
		return $covidCase;
	}
	
	public function covid_case_details_investigation($cid)
	{		
		$sql = "SELECT * from covid19_investigation_notes as c 
		        LEFT JOIN covid19_case as cf ON cf.crm_id = c.crm_id
				WHERE c.crm_id = '$cid'";
		$covidCase = $this->Common_model->get_query_result_array($sql);
		return $covidCase;
	}
	
	public function covid_case_details_contact_action($cid)
	{		
		$sql = "SELECT * from covid19_contact_action as c 
		        LEFT JOIN covid19_case as cf ON cf.crm_id = c.crm_id
				WHERE c.crm_id = '$cid'";
		$covidCase = $this->Common_model->get_query_result_array($sql);
		return $covidCase;
	}
	
	
	public function covid_case_logs($crmid, $disposition='C', $comments='Auto', $type = 'personal')
	{
		if(empty($disposition)){ $disposition = "C"; $comments='Individual'; }
		$logs_array = [
		    'crm_id' => $crmid,
			'cl_disposition' => $disposition,
			'cl_comments' => $comments,
			'cl_section' => $type,
			'cl_added_by' => get_user_id(),
			'cl_date_added' => CurrMySqlDate(),
			'cl_logs' => get_logs()
		];
		data_inserter('covid19_case_logs', $logs_array);		
	}
	
	public function covid_case_closure($crmid, $disposition='N')
	{
		$logs_array = [
			'case_status' => $disposition
		];
		$this->db->where('crm_id', $crmid);
		$this->db->update('covid19_case', $logs_array);	
	}
	
	
	
	
	//--------- CASE SUBMISSION
	public function submit_personal_information()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$crm_source = $this->input->post('crm_source');
		
		$case_array = [
			'fname' => $this->input->post('case_fname'),
			'lname' => $this->input->post('case_lname'),
			'case_source' => $crm_source,
			'added_by' => $current_user,
			'date_added' => CurrMySqlDate(),
			'logs' => get_logs()
		];
		
		$cl_type = 'personal';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);
		
		$data_array = [
			'p_dob' => date('Y-m-d', strtotime($this->input->post('case_dob'))),
			'p_gender' => $this->input->post('case_gender'),
			'p_alt_name' => $this->input->post('case_alt'),
			'p_phone' => $this->input->post('case_phone'),
			'p_email' => $this->input->post('case_email'),
			'p_address_type' => $this->input->post('case_addresstype'),
			'p_address' => $this->input->post('case_address'),
			'p_country' => $this->input->post('case_country'),
			'p_state' => $this->input->post('case_state'),
			'p_guardian_name' => $this->input->post('case_guardian'),
			'p_city' => $this->input->post('case_city'),
			'p_residence_type' => $this->input->post('case_residence'),
			'p_is_wa_resident' => $this->input->post('wa_resident'),
		];
		
		$sqlcheck = "SELECT count(*) as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			//$this->db->where('crm_id', $crm_id);
			//$this->db->update('covid19_case', $case_array);
			
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$this->sendtoform('2',$crm_id, 'update');
		} 
		else {
			$data_array += [ 'crm_id' => $crm_id ];
			$case_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case', $case_array);
			data_inserter('covid19_case_info', $data_array);
			$this->sendtoform('2',$crm_id, 'success');
		}
	}
	
	
	
	//--------- ADMINISTRATIVE LHJ SUBMISSION
	public function submit_administrative_lhj()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$flag = "error";
		
		$data_array = [
			'a_investigator' => $this->input->post('case_investigator'),
			'a_lhj_case_id' => $this->input->post('lhj_case_id'),
			'a_lhj_notification_date' => date('Y-m-d', strtotime($this->input->post('lhj_notification_date'))),
			'a_classification' => $this->input->post('case_classification'),
			'a_investigation_status' => $this->input->post('case_investigation_status'),
			'a_case_reason' => $this->input->post('case_reason'),
			'a_investigation_start_date' => date('Y-m-d', strtotime($this->input->post('case_investigation_start'))),
			'a_investigation_complete_date' => date('Y-m-d', strtotime($this->input->post('case_investigation_complete'))),
			'a_case_complete_date' => date('Y-m-d', strtotime($this->input->post('case_complete_date'))),
			'a_is_outbreak_related' => $this->input->post('case_outbreak'),
			'a_lhj_cluster_id' => $this->input->post('lhj_cluster'),
			'a_cluster_name' => $this->input->post('case_cluster_name')
		];
				
		$cl_type = 'administrative';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);
		
		$sqlcheck = "SELECT count(*)as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$flag = "update";
		} 
		else {
			$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0){ 
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case_info', $data_array);
			$flag = "insert";
			} else {
				redirect('covid_case/updatecase');
			}
		}
		
		if($flag == "update"){ if($this->input->post('case_outbreak') == 'N'){ $this->sendtoform('6',$crm_id, 'update'); } else { $this->sendtoform('3',$crm_id, 'update'); } }
		if($flag == "insert"){if($this->input->post('case_outbreak') == 'N'){ $this->sendtoform('6',$crm_id, 'update'); } else { $this->sendtoform('3',$crm_id, 'success'); } }
		if($flag == "error"){ redirect('covid_case/updatecase'); }
		if($flag == "closure"){ $this->covid_case_move_next($crm_id);  }
	}
	 
	
	//--------- DEMOGRAPHICS
	public function submit_demographics()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		
		$data_array = [
			//'d_age_at_symptom_month' => $this->input->post('d_age_at_symptom_month'),
			//'d_age_at_symptom_year' => $this->input->post('d_age_at_symptom_year'),
			'd_ethinicity' => $this->input->post('d_ethinicity'),
			'd_race' => $this->input->post('d_race'),
			'd_primary_language' => $this->input->post('d_primary_language'),
			'd_is_interpreter_needed' => $this->input->post('d_is_interpreter_needed'),
			'd_is_employed' => $this->input->post('d_is_employed'),
			'd_occupation' => $this->input->post('d_occupation'),
			'd_industry' => $this->input->post('d_industry'),
			'd_employer' => $this->input->post('d_employer'),
			'd_worksite' => $this->input->post('d_worksite'),
			'd_city' => $this->input->post('d_city'),
			'd_is_student_care' => $this->input->post('d_is_student_care'),
			'd_type_of_school' => $this->input->post('d_type_of_school'),
			'd_school_name' => $this->input->post('d_school_name'),
			'd_school_address' => $this->input->post('d_school_address'),
			'd_school_city' => $this->input->post('d_school_city'),
			//'d_school_zip' => $this->input->post('d_school_zip'),
			//'d_phone' => $this->input->post('d_phone'),
			'd_teacher_name' => $this->input->post('d_teacher_name'),
		];
		
		if(!empty($this->input->post('d_age_at_symptom_month'))){ $data_array += ['d_age_at_symptom_month' => $this->input->post('d_age_at_symptom_month'), ]; }
		if(!empty($this->input->post('d_age_at_symptom_year'))){ $data_array += ['d_age_at_symptom_year' => $this->input->post('d_age_at_symptom_year'), ]; }
		if(!empty($this->input->post('d_school_zip'))){ $data_array += ['d_school_zip' => $this->input->post('d_school_zip'), ]; }
		if(!empty($this->input->post('d_phone'))){ $data_array += ['d_phone' => $this->input->post('d_phone'), ]; }
		
		$cl_type = 'demographics';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);		
		
		$sqlcheck = "SELECT count(*)as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$this->sendtoform('4',$crm_id, 'update');
		} 
		else {
			$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0){ 
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case_info', $data_array);
			$this->sendtoform('4',$crm_id, 'success');
			} else {
				redirect('covid_case/updatecase');
			}
		}
	}
	
	
	
	//--------- CLINICAL INFORMATION
	public function submit_clinical_information()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
				
		$data_array = [
			'c_complainant_ill' => $this->input->post('c_complainant_ill'),
			'c_symptom_onset' => $this->input->post('c_symptom_onset'),
			'c_derived' => $this->input->post('c_derived'),
			//'c_diagnosis_date' => $this->input->post('c_diagnosis_date'),
			'c_illness_duration' => $this->input->post('c_illness_duration'),
			'c_illness_duration_type' => $this->input->post('c_illness_duration_type'),
			'c_illness_ongoing' => $this->input->post('c_illness_ongoing'),
			'c_clinical_info_1' => $this->input->post('c_clinical_info_1'),
			'c_clinincal_info_1_temp' => $this->input->post('c_clinincal_info_1_temp'),
			'c_clinincal_info_1_hightemp' => $this->input->post('c_clinincal_info_1_hightemp'),
			'c_clinical_info_2' => $this->input->post('c_clinical_info_2'),
			'c_clinical_info_3' => $this->input->post('c_clinical_info_3'),
			'c_clinical_info_4' => $this->input->post('c_clinical_info_4'),
			'c_clinical_info_5' => $this->input->post('c_clinical_info_5'),
			'c_clinical_info_6' => $this->input->post('c_clinical_info_6'),
			'c_clinical_info_7' => $this->input->post('c_clinical_info_7'),
			'c_clinical_info_8' => $this->input->post('c_clinical_info_8'),
			//'c_clinical_info_8_onset' => $this->input->post('c_clinical_info_8_onset'),
			'c_clinical_info_9' => $this->input->post('c_clinical_info_9'),
			//'c_clinical_info_9_onset' => $this->input->post('c_clinical_info_9_onset'),
			'c_clinical_info_10' => $this->input->post('c_clinical_info_10'),
			'c_clinical_info_11' => $this->input->post('c_clinical_info_11'),
			'c_clinical_info_11_result' => $this->input->post('c_clinical_info_11_result'),
			'c_clinical_info_12' => $this->input->post('c_clinical_info_12'),
			'c_clinical_info_13' => $this->input->post('c_clinical_info_13'),
			'c_clinical_info_14' => $this->input->post('c_clinical_info_14'),
			'c_clinical_info_15' => $this->input->post('c_clinical_info_15'),
			'c_clinical_info_16' => $this->input->post('c_clinical_info_16'),
			'c_clinical_info_17' => $this->input->post('c_clinical_info_17'),
			'c_clinical_info_18' => $this->input->post('c_clinical_info_18'),
			'c_clinical_info_19' => $this->input->post('c_clinical_info_19'),
			'c_clinical_info_19_other' => $this->input->post('c_clinical_info_19_other'),
			'c_predisposing_info_1' => $this->input->post('c_predisposing_info_1'),
			'c_predisposing_info_2' => $this->input->post('c_predisposing_info_2'),
			'c_predisposing_info_3' => $this->input->post('c_predisposing_info_3'),
			'c_predisposing_info_4' => $this->input->post('c_predisposing_info_4'),
			'c_predisposing_info_5' => $this->input->post('c_predisposing_info_5'),
			'c_predisposing_info_5_specify' => $this->input->post('c_predisposing_info_5_specify'),
			'c_predisposing_info_6' => $this->input->post('c_predisposing_info_6'),
			'c_predisposing_info_7' => $this->input->post('c_predisposing_info_7'),
			'c_predisposing_info_7_specify' => $this->input->post('c_predisposing_info_7_specify'),
			'c_predisposing_info_8' => $this->input->post('c_predisposing_info_8'),
			'c_predisposing_info_9' => $this->input->post('c_predisposing_info_9'),
			'c_predisposing_info_10' => $this->input->post('c_predisposing_info_10'),
			'c_predisposing_info_11' => $this->input->post('c_predisposing_info_11'),
			'c_predisposing_info_12' => $this->input->post('c_predisposing_info_12'),
			'c_predisposing_info_13' => $this->input->post('c_predisposing_info_13'),
			'c_predisposing_info_14' => $this->input->post('c_predisposing_info_14'),
			'c_predisposing_info_15' => $this->input->post('c_predisposing_info_15'),
			'c_predisposing_info_16' => $this->input->post('c_predisposing_info_16'),
			'c_predisposing_info_16_others' => $this->input->post('c_predisposing_info_16_others'),
			'c_clinical_testing_1' => $this->input->post('c_clinical_testing_1'),
			'c_clinical_testing_1_info' => $this->input->post('c_clinical_testing_1_info'),
			//'c_clinical_testing_1_date' => $this->input->post('c_clinical_testing_1_date'),
			'c_clinical_testing_2' => $this->input->post('c_clinical_testing_2'),
			'c_clinical_testing_2_info' => $this->input->post('c_clinical_testing_2_info'),
			//'c_clinical_testing_2_date' => $this->input->post('c_clinical_testing_2_date'),
			'c_clinical_testing_3_info' => $this->input->post('c_clinical_testing_3_info'),
			//'c_clinical_testing_3_date' => $this->input->post('c_clinical_testing_3_date'),
			'c_hospitalization_1' => $this->input->post('c_hospitalization_1'),
			'c_hospitalization_1_info' => $this->input->post('c_hospitalization_1_info'),
			//'c_hospitalization_1_admission' => $this->input->post('c_hospitalization_1_admission'),
			//'c_hospitalization_1_discharge' => $this->input->post('c_hospitalization_1_discharge'),
			'c_hospitalization_2' => $this->input->post('c_hospitalization_2'),
			'c_hospitalization_3' => $this->input->post('c_hospitalization_3'),
			'c_hospitalization_4' => $this->input->post('c_hospitalization_4'),
			'c_hospitalization_5' => $this->input->post('c_hospitalization_5'),
			//'c_hospitalization_4_death' => $this->input->post('c_hospitalization_4_death'),
		];
		
		if(!empty($this->input->post('c_clinical_testing_1_date'))){ $data_array += ['c_clinical_testing_1_date' => date('Y-m-d', strtotime($this->input->post('c_clinical_testing_1_date'))), ]; }
		if(!empty($this->input->post('c_clinical_testing_2_date'))){ $data_array += ['c_clinical_testing_2_date' => date('Y-m-d', strtotime($this->input->post('c_clinical_testing_2_date'))), ]; }
		if(!empty($this->input->post('c_clinical_testing_3_date'))){ $data_array += ['c_clinical_testing_3_date' => date('Y-m-d', strtotime($this->input->post('c_clinical_testing_3_date'))), ]; }
		if(!empty($this->input->post('c_hospitalization_1_admission'))){ $data_array += ['c_hospitalization_1_admission' => date('Y-m-d', strtotime($this->input->post('c_hospitalization_1_admission'))), ]; }
		if(!empty($this->input->post('c_hospitalization_1_discharge'))){ $data_array += ['c_hospitalization_1_discharge' => date('Y-m-d', strtotime($this->input->post('c_hospitalization_1_discharge'))), ]; }
		if(!empty($this->input->post('c_hospitalization_4_death'))){ $data_array += ['c_hospitalization_4_death' => date('Y-m-d', strtotime($this->input->post('c_hospitalization_4_death'))), ]; }
		if(!empty($this->input->post('c_diagnosis_date'))){ $data_array += ['c_diagnosis_date' => date('Y-m-d', strtotime($this->input->post('c_diagnosis_date'))), ]; }
		if(!empty($this->input->post('c_clinical_info_8_onset'))){ $data_array += ['c_clinical_info_8_onset' => date('Y-m-d', strtotime($this->input->post('c_clinical_info_8_onset'))), ]; }
		if(!empty($this->input->post('c_clinical_info_9_onset'))){ $data_array += ['c_clinical_info_9_onset' => date('Y-m-d', strtotime($this->input->post('c_clinical_info_9_onset'))), ]; }
		
		
		$c_clinical_info_11_diagnosis = $this->input->post('c_clinical_info_11_diagnosis');
		$c_clinical_info_12_diagnosis = $this->input->post('c_clinical_info_12_diagnosis');
		$c_clinical_info_20_first = $this->input->post('c_clinical_info_20_first');
		$c_clinical_info_20_pregnancy = $this->input->post('c_clinical_info_20_pregnancy');
		$data_array += [ 'c_clinical_info_11_diagnosis' => implode(',',$c_clinical_info_11_diagnosis), ];
		$data_array += [ 'c_clinical_info_12_diagnosis' => implode(',',$c_clinical_info_12_diagnosis), ];	
		$data_array += [ 'c_clinical_info_20_first' => implode(',',$c_clinical_info_20_first), ];
		$data_array += [ 'c_clinical_info_20_pregnancy' => implode(',',$c_clinical_info_20_pregnancy), ];
		
		$cl_type = 'clinical';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);	
		
		$sqlcheck = "SELECT count(*) as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$this->sendtoform('5',$crm_id, 'update');
		} 
		else {
			$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0){ 
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case_info', $data_array);
			$this->sendtoform('5',$crm_id, 'success');
			} else {
				redirect('covid_case/updatecase');
			}
		}
	}
	
	 
	
	//--------- TREATMENT INFORMATION
	public function submit_treatment_information()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		//echo "<pre>".print_r($_POST, true)."</pre>"; die();
		
		$t_treatment_1_info_medication = $this->input->post('t_treatment_1_info_medication');
		$t_treatment_prescribed_dose = $this->input->post('t_treatment_prescribed_dose');;
		$t_treatment_prescribed_unit_dose_arr = array();
		$iCheck = 0;
		foreach($t_treatment_1_info_medication as $token)
		{
			$iCheck++;
			$t_treatment_prescribed_unit_dose_arr[] = $this->input->post('t_treatment_prescribed_unit_dose_'.$iCheck);
		}
		
		$data_array = [
			't_treatment_1' => $this->input->post('t_treatment_1'),
			//'t_treatment_1_info' => $this->input->post('t_treatment_1_info'),
			't_treatment_days' => $this->input->post('t_treatment_days'),
			//'t_treatment_start_date' => $this->input->post('t_treatment_start_date'),
			//'t_treatment_end_date' => $this->input->post('t_treatment_end_date'),
			't_treatment_prescribed' => $this->input->post('t_treatment_prescribed'),
			't_treatment_prescribed_unit' => $this->input->post('t_treatment_prescribed_unit'),
			't_treatment_duration' => $this->input->post('t_treatment_duration'),
			't_treatment_duration_type' => $this->input->post('t_treatment_duration_type'),
			't_treatment_indication_other' => $this->input->post('t_treatment_indication_other'),
			't_treatment_2_medication' => $this->input->post('t_treatment_2_medication'),
			't_treatment_2_medication_info' => $this->input->post('t_treatment_2_medication_info'),
			't_treatment_prescribing' => $this->input->post('t_treatment_prescribing'),
			't_treatment_1_info' => implode('##',$t_treatment_1_info_medication),
			't_treatment_prescribed' => implode('##',$t_treatment_prescribed_dose),
			't_treatment_prescribed_unit' => implode('##',$t_treatment_prescribed_unit_dose_arr)
		];
		
		if(!empty($this->input->post('t_treatment_start_date'))){ $data_array += ['t_treatment_start_date' => date('Y-m-d', strtotime($this->input->post('t_treatment_start_date'))), ]; }
		if(!empty($this->input->post('t_treatment_end_date'))){ $data_array += ['t_treatment_end_date' => date('Y-m-d', strtotime($this->input->post('t_treatment_end_date'))), ]; }
		
		
		$t_treatment_1_medication = $this->input->post('t_treatment_1_medication');
		$t_treatment_indication = $this->input->post('t_treatment_indication');
		$data_array += [ 't_treatment_1_medication' => implode(',',$t_treatment_1_medication), ];
		$data_array += [ 't_treatment_indication' => implode(',',$t_treatment_indication), ];
		
		$cl_type = 'treatment';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);	
		
		$sqlcheck = "SELECT count(*) as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$this->sendtoform('6',$crm_id, 'update');
		} 
		else {
			$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0){ 
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case_info', $data_array);
			$this->sendtoform('6',$crm_id, 'success');
			} else {
				redirect('covid_case/updatecase');
			}
		}
	}
	
	
	//--------- NOTES INFORMATION
	public function submit_notes()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$flag = "error";
		
		$data_array = [
			'case_notes' => $this->input->post('case_notes'),
			'case_permission' => $this->input->post('case_permission')
		];
				
		$sqlcheck = "SELECT count(*) as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$flag = "update";
		} 
		else {
			$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0){ 
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case_info', $data_array);
			$flag = "insert";
			} else {
				redirect('covid_case/updatecase');
			}
		}
		
		
		$cl_type = 'notes';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		
		$case_closure_type = $this->input->post('case_closure_type');
		if(!empty($case_closure_type))
		{
			$cls_remarks = $this->input->post('cls_remarks');
			$cls_disposition = $this->input->post('cls_disposition');
				
			if($case_closure_type == 'Y')
			{
				$cl_disposition = 'N';
				$cl_comments = 'CASE NEGATIVE';
				if(!empty($cls_remarks)){ $cl_comments = $cls_disposition; }
				$this->covid_case_closure($crm_id, $cls_disposition);
				$flag = "closure";				
			}
		}
		
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);	
		
		if($flag == "update"){ $this->sendtoform('7',$crm_id, 'update'); }
		if($flag == "insert"){ $this->sendtoform('7',$crm_id, 'success'); }
		if($flag == "error"){ redirect('covid_case/updatecase'); }
		if($flag == "closure"){ $this->sendtoform('6',$crm_id, 'success'); }
		
	}
	
	
	
	
	//--------- EXPOSURE INFORMATION
	public function submit_exposure()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$e_type = "exposure";
		$flag = "error";
		
		for($i=14; $i>=0; $i--){
			
			$e_day = $i>0? "-".$i : 0;
			$data_array = [
				'e_date' => $this->input->post('e_date_'.$i),
				'e_location' => $this->input->post('e_location_'.$i),
				'e_contacts' => $this->input->post('e_contacts_'.$i),
				'e_type' => $e_type,
			];
			
			$sqlcheck = "SELECT count(*) as value from covid19_case_exposure WHERE crm_id = '$crm_id' AND e_day = '$e_day' AND e_type = '$e_type'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0)
			{
				$this->db->where('crm_id', $crm_id);
				$this->db->where('e_day', $e_day);
				$this->db->where('e_type', $e_type);
				$this->db->update('covid19_case_exposure', $data_array);
				$flag = "update";
			} 
			else {
				$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
				$querycheck = $this->Common_model->get_single_value($sqlcheck);
				if($querycheck > 0){ 
				$data_array += [ 'crm_id' => $crm_id, 'e_day' => $e_day ];
				data_inserter('covid19_case_exposure', $data_array);
				$flag = "insert";
				} else {
					redirect('covid_case/updatecase');
				}
			}
		}
		
		
		$cl_type = 'exposure';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);
		
		if($flag == "update"){ $this->sendtoform('8',$crm_id, 'update'); }
		if($flag == "insert"){ $this->sendtoform('8',$crm_id, 'success'); }
		if($flag == "error"){ redirect('covid_case/updatecase'); }
		
	}
	
	
	
	//--------- RISK INFORMATION
	public function submit_risk_response()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
				
		$data_array = [
			'r_patient_1_other' => $this->input->post('r_patient_1_other'),
			'r_setting_1_city' => $this->input->post('r_setting_1_city'),
			'r_setting_1_state' => $this->input->post('r_setting_1_state'),
			'r_setting_1_country' => $this->input->post('r_setting_1_country'),
			'r_setting_2_city' => $this->input->post('r_setting_2_city'),
			'r_setting_2_state' => $this->input->post('r_setting_2_state'),
			'r_setting_2_country' => $this->input->post('r_setting_2_country'),
			'r_setting_3_city' => $this->input->post('r_setting_3_city'),
			'r_setting_3_state' => $this->input->post('r_setting_3_state'),
			'r_setting_3_country' => $this->input->post('r_setting_3_country'),
			'r_risk_1' => $this->input->post('r_risk_1'),
			'r_risk_2_wdrs' => $this->input->post('r_risk_2_wdrs'),
			'r_risk_2_name' => $this->input->post('r_risk_2_name'),
			'r_risk_3_other' => $this->input->post('r_risk_3_other'),
			'r_risk_3_describe' => $this->input->post('r_risk_3_describe'),
		];
		
		if(!empty($this->input->post('r_setting_1_start'))){ $data_array += ['r_setting_1_start' => date('Y-m-d', strtotime($this->input->post('r_setting_1_start'))), ]; }
		if(!empty($this->input->post('r_setting_2_start'))){ $data_array += ['r_setting_2_start' => date('Y-m-d', strtotime($this->input->post('r_setting_2_start'))), ]; }
		if(!empty($this->input->post('r_setting_3_start'))){ $data_array += ['r_setting_3_start' => date('Y-m-d', strtotime($this->input->post('r_setting_3_start'))), ]; }
		if(!empty($this->input->post('r_setting_1_end'))){ $data_array += ['r_setting_1_end' => date('Y-m-d', strtotime($this->input->post('r_setting_1_end'))), ]; }
		if(!empty($this->input->post('r_setting_2_end'))){ $data_array += ['r_setting_2_end' => date('Y-m-d', strtotime($this->input->post('r_setting_2_end'))), ]; }
		if(!empty($this->input->post('r_setting_3_end'))){ $data_array += ['r_setting_3_end' => date('Y-m-d', strtotime($this->input->post('r_setting_3_end'))), ]; }
		if(!empty($this->input->post('r_risk_1_start'))){ $data_array += ['r_risk_1_start' => date('Y-m-d', strtotime($this->input->post('r_risk_1_start'))), ]; }
		if(!empty($this->input->post('r_risk_1_end'))){ $data_array += ['r_risk_1_end' => date('Y-m-d', strtotime($this->input->post('r_risk_1_end'))), ]; }		
		if(!empty($this->input->post('r_risk_2_dob'))){ $data_array += ['r_risk_2_dob' => date('Y-m-d', strtotime($this->input->post('r_risk_2_dob'))), ]; }
		
		
		$r_patient_1 = $this->input->post('r_patient_1');
		$r_setting_1 = $this->input->post('r_setting_1');
		$r_setting_2 = $this->input->post('r_setting_2');
		$r_setting_3 = $this->input->post('r_setting_3');
		$r_risk_3 = $this->input->post('r_risk_3');
		$data_array += [ 'r_patient_1' => implode(',',$r_patient_1), ];
		$data_array += [ 'r_setting_1' => implode(',',$r_setting_1), ];
		$data_array += [ 'r_setting_2' => implode(',',$r_setting_2), ];
		$data_array += [ 'r_setting_3' => implode(',',$r_setting_3), ];
		$data_array += [ 'r_risk_3' => implode(',',$r_risk_3), ];
		
		$cl_type = 'risk';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);
		
		$sqlcheck = "SELECT count(*) as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$this->sendtoform('10',$crm_id, 'update');
		} 
		else {
			$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0){ 
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case_info', $data_array);
			$this->sendtoform('10',$crm_id, 'success');
			} else {
				redirect('covid_case/updatecase');
			}
		}
	}
	
	
	//--------- TRANSMISSION INFORMATION
	public function submit_transmission()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$e_type = "transmission";
		$flag = "error";
		
		for($i=0; $i<17; $i++){
			
			$e_day = $i-2;
			$data_array = [
				'e_date' => $this->input->post('e_date_'.$i),
				'e_location' => $this->input->post('e_location_'.$i),
				'e_contacts' => $this->input->post('e_contacts_'.$i),
				'e_type' => $e_type,
			];
			
			$sqlcheck = "SELECT count(*) as value from covid19_case_exposure WHERE crm_id = '$crm_id' AND e_day = '$e_day' AND e_type = '$e_type'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0)
			{
				$this->db->where('crm_id', $crm_id);
				$this->db->where('e_day', $e_day);
				$this->db->where('e_type', $e_type);
				$this->db->update('covid19_case_exposure', $data_array);
				$flag = "update";
			} 
			else {
				$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
				$querycheck = $this->Common_model->get_single_value($sqlcheck);
				if($querycheck > 0){ 
				$data_array += [ 'crm_id' => $crm_id, 'e_day' => $e_day ];
				data_inserter('covid19_case_exposure', $data_array);
				$flag = "insert";
				} else {
					redirect('covid_case/updatecase');
				}
			}
		}
		
		$cl_type = 'transmission';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);
		
		if($flag == "update"){ $this->sendtoform('9',$crm_id, 'update'); }
		if($flag == "insert"){ $this->sendtoform('9',$crm_id, 'success'); }
		if($flag == "error"){ redirect('covid_case/updatecase'); }
		
	}
	
	
	
	//--------- AFTERCASE INFORMATION
	public function submit_aftercase()
	{
		$current_user = get_user_id();
		$crm_id = $this->input->post('crm_id');
		$flag = 'error';
		
		$data_array = [
			'af_1_visited' => $this->input->post('af_1_visited'),
			'af_setting_1_facility' => $this->input->post('af_setting_1_facility'),
			'af_setting_2_facility' => $this->input->post('af_setting_2_facility'),
			'af_setting_3_facility' => $this->input->post('af_setting_3_facility'),
			'af_setting_4_facility' => $this->input->post('af_setting_4_facility'),
			'af_setting_1_known' => $this->input->post('af_setting_1_known'),
			'af_setting_2_known' => $this->input->post('af_setting_2_known'),
			'af_setting_3_known' => $this->input->post('af_setting_3_known'),
			'af_setting_4_known' => $this->input->post('af_setting_4_known'),
		];
		
		if(!empty($this->input->post('af_setting_1_start'))){ $data_array += ['af_setting_1_start' => date('Y-m-d', strtotime($this->input->post('af_setting_1_start'))), ]; }
		if(!empty($this->input->post('af_setting_1_end'))){ $data_array += ['af_setting_1_end' => date('Y-m-d', strtotime($this->input->post('af_setting_1_end'))), ]; }
		if(!empty($this->input->post('af_setting_2_start'))){ $data_array += ['af_setting_2_start' => date('Y-m-d', strtotime($this->input->post('af_setting_2_start'))), ]; }
		if(!empty($this->input->post('af_setting_2_end'))){ $data_array += ['af_setting_2_end' => date('Y-m-d', strtotime($this->input->post('af_setting_2_end'))), ]; }
		if(!empty($this->input->post('af_setting_3_start'))){ $data_array += ['af_setting_3_start' => date('Y-m-d', strtotime($this->input->post('af_setting_3_start'))), ]; }
		if(!empty($this->input->post('af_setting_3_end'))){ $data_array += ['af_setting_3_end' => date('Y-m-d', strtotime($this->input->post('af_setting_3_end'))), ]; }
		if(!empty($this->input->post('af_setting_4_start'))){ $data_array += ['af_setting_4_start' => date('Y-m-d', strtotime($this->input->post('af_setting_4_start'))), ]; }
		if(!empty($this->input->post('af_setting_4_end'))){ $data_array += ['af_setting_4_end' => date('Y-m-d', strtotime($this->input->post('af_setting_4_end'))), ]; }
		
		
				
		$af_1 = $this->input->post('af_1');
		$data_array += [ 'af_1' => implode(',',$af_1), ];
				
		$sqlcheck = "SELECT count(*) as value from covid19_case_info WHERE crm_id = '$crm_id'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0)
		{
			$this->db->where('crm_id', $crm_id);
			$this->db->update('covid19_case_info', $data_array);
			$flag = 'update';
		} 
		else {
			$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crm_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
			if($querycheck > 0){ 
			$data_array += [ 'crm_id' => $crm_id ];
			data_inserter('covid19_case_info', $data_array);
			$flag = 'insert';
			} else {
				redirect('covid_case/updatecase');
			}
		}
		
		$cl_type = 'aftercase';
		$cl_disposition = $this->input->post('cl_disposition');
		$cl_comments = $this->input->post('cl_comments');
		$case_closure_type = $this->input->post('case_closure_type');
		
		if(!empty($case_closure_type))
		{
			$cls_remarks = $this->input->post('cls_remarks');
			$cls_disposition = $this->input->post('cls_disposition');
				
			if($case_closure_type == 'Y')
			{
				$cl_disposition = 'P';
				$cl_comments = 'CASE POSITIVE';
				
				if($cls_disposition == 'RECOVERED'){
					$cl_disposition = 'R';
					$cl_comments = 'CASE RECOVERED';
				}
				
				if(!empty($cls_remarks)){ $cl_comments = $cls_disposition; }
				$this->covid_case_closure($crm_id, $cls_disposition);
				$flag = "closure";				
			}
		}
		
		$this->covid_case_logs($crm_id, $cl_disposition, $cl_comments, $cl_type);
		
		if($flag == "update"){ $this->sendtoform('10',$crm_id, 'success'); }
		if($flag == "insert"){ $this->sendtoform('10',$crm_id, 'success'); }
		if($flag == "error"){ redirect('covid_case/updatecase'); }
		if($flag == "closure"){ $this->sendtoform('10',$crm_id, 'success');  }
		
	}
	
	
	
	// INTELLIGENCE DATA ANALYZE
	public function ai_check_address($crmid)
	{
		$get_filled_details = $this->covid_case_details($crmid);
		$p_address = $get_filled_details['p_address'];
		$p_country = $get_filled_details['p_country'];
		$p_state = $get_filled_details['p_state'];
		$p_city = $get_filled_details['p_city'];
		$check_address = "SELECT ci.*, c.* from covid19_case_info as ci 
		LEFT JOIN covid19_case as c ON c.crm_id = ci.crm_id  
		WHERE (ci.p_address LIKE '%$p_address%' 
		OR (ci.p_country LIKE '%$p_country%' AND ci.p_state LIKE '%$p_state%' AND ci.p_city LIKE '%$p_city%'))
		AND ci.crm_id NOT IN ('$crmid')";
		$query_address = $this->Common_model->get_query_result_array($check_address);
		return $query_address;		
	}
	
	
	// LOCK - UNLOCK CASES
	public function unlock()
	{
		$crmid = $this->uri->segment(3);
		$backto = $this->uri->segment(4);
		$flag = "error";
		
		$data_array = [ "ongoing_status" => 'P' ];
		
		$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crmid'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0){ 
			$this->db->where('crm_id', $crmid);
			$this->db->update('covid19_case', $data_array);
			$flag = "update";
		}
		
		if($flag = "update"){ redirect('covid_case/form/'.$crmid.'/'.$backto.'/update'); }
		if($flag = "error"){ redirect('covid_case/form/'.$crmid.'/'.$backto); }
		
	}
	
	public function lock()
	{
		$crmid = $this->uri->segment(3);
		$backto = $this->uri->segment(4);
		$flag = "error";
		
		$data_array = [ "ongoing_status" => 'N' ];
		
		$sqlcheck = "SELECT count(*) as value from covid19_case WHERE crm_id = '$crmid'";
		$querycheck = $this->Common_model->get_single_value($sqlcheck);
		if($querycheck > 0){ 
			$this->db->where('crm_id', $crmid);
			$this->db->update('covid19_case', $data_array);
			$flag = "update";
		}
		
		if($flag = "update"){ redirect('covid_case/form/'.$crmid.'/'.$backto.'/update'); }
		if($flag = "error"){ redirect('covid_case/form/'.$crmid.'/'.$backto); }
		
	}
	
	
	
	//======= SEND EMAIL
	public function send_email()
	{
		$current_user = get_user_id();
		$crmid = $this->uri->segment(3);
		$this->send_email_contact_tracing($crmid, $current_user);
	}
	
	
	public function send_email_contact_tracing($crmid, $uid)
	{
		$eto="";
		$ecc="";
		$nbody="";
				
		$qSql="SELECT c.*, ci.* from covid19_case as c LEFT JOIN covid19_case_info as ci ON ci.crm_id = c.crm_id WHERE c.crm_id = '$crmid'";
		$contactQ = $this->Common_model->get_query_row_array($qSql);
		if(count($contactQ) > 0)
		{
			
			// UPDATE CASE INDIVIDUAL
			$inv_array = array( 'case_source' => 'individual' );
			$this->db->where('crm_id', $contactQ['crm_id']);
			$this->db->update('covid19_case', $inv_array);
			
			$email_subject = "Please fill up the Contact Tracing Form | Fusion";
			$eto = 'sachin.paswan@fusionbposervices.com';
			$ecc = '';
			$from_email="noreply.fems@fusionbposervices.com";
			$from_name="Fusion FEMS";
			
			echo $nbody='Dear <b>'.$contactQ["fname"] .' ' .$contactQ["lname"].',</b></br></br>
					Thank you for giving us your precious time.</br> 
					Kindly, provide us your details for contact tracing.	
					</br>
					</br>
							
					CASE Details :</br>
					<table border="1" width="80%" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background-color:powderblue;">Case ID:</td>
								<td>'.$contactQ["crm_id"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Case Name:</td>
								<td>'.$contactQ["fname"] .' ' .$contactQ["lname"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Case Phone:</td>
								<td>'.$contactQ["p_phone"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;">Case Email:</td>
								<td>'.$contactQ["p_email"].'</td>
							</tr>
					</table>
					
					<br/><br/>
					<a target="_blank" href="'.base_url('contact_tracing/form/'.$contactQ["crm_id"].'/personal').'" style="background-color:#F15664;color:#fff;padding:4px 8px">
					Open Form</a>
					
				</br>
				</br>
				</br>
						
				Regards, </br>
				Fusion - FEMS	</br>
				';
				
			$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "",$from_email,$from_name,'N');	
			
		}
			
				
	}
		
	

	
}