<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fnf extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model');		
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	
//==========================================================================================
///=========================== FNF PART FOR RESIGNATION ================================///
     public function index(){
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "fnf/fnf_aside.php";
		$data["content_template"] = "fnf/user_fnf.php";
		
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$extraoffice = ""; 
		$get_office_id = $this->input->get('office_id');
		if($get_office_id=="") $get_office_id = $user_office_id;
		
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND s.office_id = '$get_office_id' ";  
		}
		
		$data['getOffice'] = $get_office_id;
		$extra_release_term_check="";
		$extra_terminate_check = " AND (t.t_type<>'11' || t.t_type IS NULL)";
		//$extra_release_term_check = " AND f.user_id NOT IN (SELECT user_id from terminate_users WHERE is_term_complete = 'Y')";
		
		
		$fnf_list = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, r.user_email, r.user_phone, r.resign_date,r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd 
					from user_fnf as f 
		            LEFT JOIN signin as s ON s.id = f.user_id
					LEFT JOIN user_resign as r on r.id = f.resign_id
					LEFT JOIN terminate_users as t on t.id = f.term_id
					WHERE f.fnf_status = 'P' $extra_terminate_check
					$extraoffice $extra_release_term_check order by s.fname";
		$data['local_list'] = $this->Common_model->get_query_result_array($fnf_list);
		
		
		/*$fnf_list = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, r.user_email, r.user_phone, r.resign_date,r.accepted_released_date, r.domain_id_deletion as domain_check, r.email_id_deletion as email_check, r.login_credential_deletion as login_check, r.phone_login_deletion as phone_check, date(t.terms_date) as terms_date, t.lwd 
					from user_fnf as f 
		            LEFT JOIN signin as s ON s.id = f.user_id
					LEFT JOIN user_resign as r on r.id = f.resign_id
					LEFT JOIN terminate_users as t on t.id = f.term_id
					WHERE f.fnf_status = 'P' $extra_terminate_check
					$extraoffice $extra_release_term_check order by s.fname";
		$data['helpdesk_list'] = $this->Common_model->get_query_result_array($fnf_list);
		
		
		$fnf_list = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, r.user_email, r.user_phone, r.resign_date,r.accepted_released_date, 
		r.domain_id_deletion as domain_check, r.email_id_deletion as email_check, r.login_credential_deletion as login_check, r.phone_login_deletion as phone_check,
		date(t.terms_date) as terms_date, t.lwd  
					from user_fnf as f 
		            LEFT JOIN signin as s ON s.id = f.user_id
					LEFT JOIN user_resign as r on r.id = f.resign_id
					LEFT JOIN terminate_users as t on t.id = f.term_id
					WHERE f.fnf_status = 'P' $extra_terminate_check
					$extraoffice $extra_release_term_check order by s.fname";
		$data['security_list'] = $this->Common_model->get_query_result_array($fnf_list);
		*/
		
		
		$fnf_list = "SELECT f.*, p.*, f.user_id as f_user_id, f.id as f_id, f.payroll_status as f_payroll_status, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, r.user_email, r.user_phone, r.resign_date,r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd, l.leaves_present  
					from user_fnf as f 
		            LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND p.payroll_status IN ('C','R') AND p.is_active = '1'
		            LEFT JOIN signin as s ON s.id = f.user_id
					LEFT JOIN user_resign as r on r.id = f.resign_id
					LEFT JOIN terminate_users as t on t.id = f.term_id
					LEFT JOIN leave_avl_emp as l ON l.user_id = s.id 
					AND l.leave_criteria_id IN (SELECT LC.id FROM leave_criteria LC
					INNER JOIN leave_type LT ON LT.id = LC.leave_type_id
					WHERE LC.office_abbr = s.office_id AND LT.abbr = 'PL')
					WHERE f.fnf_status = 'P' $extra_terminate_check
					$extraoffice $extra_release_term_check";
		$data['payroll_list'] = $this->Common_model->get_query_result_array($fnf_list);
		
		
		
		$fnf_list = "SELECT p.*, p.id as p_payment_id, f.user_id as f_user_id, f.id as f_id, f.payroll_status as f_payroll_status, 
		            f.account_status as f_account_status, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, r.user_email, r.user_phone, 
					r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd  
					from user_fnf as f 
		            LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id  AND p.payroll_status IN ('C','R') AND p.is_active = '1'
		            LEFT JOIN signin as s ON s.id = f.user_id
					LEFT JOIN user_resign as r on r.id = f.resign_id
					LEFT JOIN terminate_users as t on t.id = f.term_id
					WHERE f.fnf_status = 'P' AND f.payroll_status IN ('C') $extra_terminate_check  
					$extraoffice $extra_release_term_check";
		$data['accounts_list'] = $this->Common_model->get_query_result_array($fnf_list);
				
		$fnf_list = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd 
		             from user_fnf as f 
		             LEFT JOIN signin as s ON s.id = f.user_id
					 LEFT JOIN user_resign as r on r.id = f.resign_id
					 LEFT JOIN terminate_users as t on t.id = f.term_id
					 WHERE f.fnf_status = 'P' $extra_terminate_check
					 $extraoffice $extra_release_term_check order by s.fname";
		
		//echo $fnf_list;
		
		$data['hr_checklist'] = $this->Common_model->get_query_result_array($fnf_list);
		
		
		// GENERATE EXCEL
		if(!empty($this->input->get('office')) &&  !empty($this->input->get('excel')))
		{
			$_filterCond = " ";
			$excel_Office = $this->input->get('office');
			if($excel_Office!="ALL" && $excel_Office!="") $_filterCond .= " AND s.office_id='".$excel_Office."'";
			
			$sqlReport = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd,
				p.leave_encashment, p.last_month_unpaid, p.notice_pay, p.pf_deduction, p.esic_deduction, p.ptax_deduction, p.tds_deductions, p.loan_recovery, p.total_deduction, p.net_payment, 
				p.payroll_by, concat(it_p.fname,' ',it_p.lname) as payroll_fullname, p.date_added as payroll_date,
				p.accounts_remarks, p.accounts_status, p.accounts_by, p.accounts_date, concat(it_a.fname,' ',it_a.lname) as accounts_fullname,
				concat(it_l.fname,' ',it_l.lname) as it_local_fullname, concat(it_n.fname,' ',it_n.lname) as it_netowrk_fullname, 
				concat(it_h.fname,' ',it_h.lname) as it_global_helpdesk_fullname, concat(it_s.fname,' ',it_s.lname) as it_security_fullname,
				concat(it_hr.fname,' ',it_hr.lname) as hr_fullname
						from user_fnf as f 
						LEFT JOIN signin as s ON s.id = f.user_id
						LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND is_active = '1'
						LEFT JOIN user_resign as r on r.id = f.resign_id
						LEFT JOIN terminate_users as t on t.id = f.term_id
						LEFT JOIN signin as it_l on it_l.id = f.it_local_by
						LEFT JOIN signin as it_n on it_n.id = f.it_network_by
						LEFT JOIN signin as it_h on it_h.id = f.it_global_helpdesk_by
						LEFT JOIN signin as it_s on it_s.id = f.it_security_by
						LEFT JOIN signin as it_p on it_p.id = f.payroll_by
						LEFT JOIN signin as it_a on it_a.id = f.account_by
						LEFT JOIN signin as it_hr on it_hr.id = f.final_update_by
						WHERE f.fnf_status IN ('P') $extra_terminate_check $_filterCond";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				
				$this->generate_fnf_excel_reports($queryReport, $excel_Office ."_FNF_Pending", "FNF Pending List");
		}
		
		$this->load->view('dashboard',$data);
	 
	 }
	 
	 
	 public function bulk_fnf_hr()
	 {
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "fnf/fnf_aside.php";
		$data["content_template"] = "fnf/user_fnf.php";
		
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$extraoffice = ""; 
		$get_office_id = $this->input->get('office_id');
		if($get_office_id=="") $get_office_id = $user_office_id;
		
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND s.office_id = '$get_office_id' ";  
		}
		
		$data['getOffice'] = $get_office_id;
		$extra_release_term_check="";
		$extra_terminate_check = " AND (t.t_type<>'11' || t.t_type IS NULL)";
		//$extra_release_term_check = " AND f.user_id NOT IN (SELECT user_id from terminate_users WHERE is_term_complete = 'Y')";
				
		$fnf_list = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd 
		             from user_fnf as f 
		             LEFT JOIN signin as s ON s.id = f.user_id
					 LEFT JOIN user_resign as r on r.id = f.resign_id
					 LEFT JOIN terminate_users as t on t.id = f.term_id
					 WHERE f.fnf_status = 'P' $extra_terminate_check
					 $extraoffice $extra_release_term_check order by s.fname";		
		$data['hr_checklist'] = $this->Common_model->get_query_result_array($fnf_list);
				
		$this->load->view('fnf/user_fnf_bulk_submit',$data);
	 
	 }
	 
	 
	 public function bulk_fnf_hr_submission()
	 {
		 
		$allData = $this->input->post();
		//echo "<pre>".print_r($allData, 1)."</pre>";
		
		$fnfidAr = $this->input->post('check_bulk_box');
		$final_comments = $this->input->post('final_comments_bulk');
				
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		foreach($fnfidAr as $fnfid){
			
			if($fnfid != "" && $final_comments != ""){		
				$field_array = array(
					"fnf_status" => "C",
					"final_comments" => $final_comments,
					"final_update_by" => $current_user,
					"final_update_date" => $current_date
				);
				
				$this->db->where('id', $fnfid);
				$this->db->update('user_fnf', $field_array);					
				
				$this->send_release_letter($fnfid);				
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);

	 }
	
	
	public function completed()
	{
			$data["aside_template"] = "fnf/fnf_aside.php";
			$data["content_template"] = "fnf/user_fnf_complete.php";
			$data["content_js"] = "user_fnf_js.php";
							
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
					
			//================ DATE FILTER				
			$sdate = GetLocalDate();
			$edate = GetLocalDate();
			
			$usergetdate_start = $this->input->get('start_date');
			$usergetdate_end = $this->input->get('end_date');
		    if($usergetdate_start != ""){ $sdate = $usergetdate_start; $edate = $usergetdate_end; }
						
			$data['date_now'] = GetLocalDate();
			$data['start_date'] = $sdate;
			$data['end_date'] = $edate;
		
		    //================ OFFICE FILTER
			$data['office_now'] = $user_office_id; $oValue = "";
			if($oValue=="") 
			{	
				$oValue = trim($this->input->get('office_id'));
				if($oValue!=""){ $data['office_now'] = $oValue; }
			}
						
			$_filterCond = " AND DATE(f.final_update_date) >= '$sdate' AND DATE(f.final_update_date) <= '$edate'";
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " AND s.office_id='".$oValue."'";
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$report_start = $this->input->get('start_date');
			$report_end = $this->input->get('end_date');
			
			$data['search'] = false;
			if(!empty($report_start) && !empty($report_end))
			{
				$data['search'] = true;
				
				//========= DOWNLOAD CSV
				$sqlReport = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd, 
				p.leave_encashment, p.last_month_unpaid, p.notice_pay, p.pf_deduction, p.esic_deduction, p.ptax_deduction, p.tds_deductions, p.loan_recovery, p.total_deduction, p.net_payment,
				p.payroll_by, concat(it_p.fname,' ',it_p.lname) as payroll_fullname, p.date_added as payroll_date,
				p.accounts_remarks, p.accounts_status, p.accounts_by, p.accounts_date, concat(it_a.fname,' ',it_a.lname) as accounts_fullname,
				concat(it_l.fname,' ',it_l.lname) as it_local_fullname, concat(it_n.fname,' ',it_n.lname) as it_netowrk_fullname, 
				concat(it_h.fname,' ',it_h.lname) as it_global_helpdesk_fullname, concat(it_s.fname,' ',it_s.lname) as it_security_fullname,
				concat(it_hr.fname,' ',it_hr.lname) as hr_fullname
						from user_fnf as f 
						LEFT JOIN signin as s ON s.id = f.user_id
						LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND is_active = '1'
						LEFT JOIN user_resign as r on r.id = f.resign_id
						LEFT JOIN terminate_users as t on t.id = f.term_id
						LEFT JOIN signin as it_l on it_l.id = f.it_local_by
						LEFT JOIN signin as it_n on it_n.id = f.it_network_by
						LEFT JOIN signin as it_h on it_h.id = f.it_global_helpdesk_by
						LEFT JOIN signin as it_s on it_s.id = f.it_security_by
						LEFT JOIN signin as it_p on it_p.id = f.payroll_by
						LEFT JOIN signin as it_a on it_a.id = f.account_by
						LEFT JOIN signin as it_hr on it_hr.id = f.final_update_by
						WHERE f.fnf_status NOT IN ('P','R') $_filterCond order by s.fname";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				$data['fnf_complete'] = $queryReport;
				
			} else {
				
				//========= DOWNLOAD CSV
				$sqlReport = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd, 
				p.leave_encashment, p.last_month_unpaid, p.notice_pay, p.pf_deduction, p.esic_deduction, p.ptax_deduction, p.tds_deductions, p.loan_recovery, p.total_deduction, p.net_payment,
				p.payroll_by, concat(it_p.fname,' ',it_p.lname) as payroll_fullname, p.date_added as payroll_date,
				p.accounts_remarks, p.accounts_status, p.accounts_by, p.accounts_date, concat(it_a.fname,' ',it_a.lname) as accounts_fullname,
				concat(it_l.fname,' ',it_l.lname) as it_local_fullname, concat(it_n.fname,' ',it_n.lname) as it_netowrk_fullname, 
				concat(it_h.fname,' ',it_h.lname) as it_global_helpdesk_fullname, concat(it_s.fname,' ',it_s.lname) as it_security_fullname,
				concat(it_hr.fname,' ',it_hr.lname) as hr_fullname
						from user_fnf as f 
						LEFT JOIN signin as s ON s.id = f.user_id
						LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND is_active = '1'
						LEFT JOIN user_resign as r on r.id = f.resign_id
						LEFT JOIN terminate_users as t on t.id = f.term_id
						LEFT JOIN signin as it_l on it_l.id = f.it_local_by
						LEFT JOIN signin as it_n on it_n.id = f.it_network_by
						LEFT JOIN signin as it_h on it_h.id = f.it_global_helpdesk_by
						LEFT JOIN signin as it_s on it_s.id = f.it_security_by
						LEFT JOIN signin as it_p on it_p.id = f.payroll_by
						LEFT JOIN signin as it_a on it_a.id = f.account_by
						LEFT JOIN signin as it_hr on it_hr.id = f.final_update_by
						WHERE f.fnf_status NOT IN ('P','R') order by f.id DESC LIMIT 100";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				$data['fnf_complete'] = $queryReport;
				
			}
			
			$this->load->view('dashboard',$data);
		
	}

	// EXCEL FUNCTIONS
	public function fnf_export_report_excel()
	{
		$_filterCond = " "; $excel_section = '0';
		$excel_Office = $this->input->get('office');
		$excel_section = $this->input->get('type');
		$extra_terminate_check = " AND (t.t_type<>'11' || t.t_type IS NULL)";
		if($excel_Office!="ALL" && $excel_Office!=""){ $_filterCond .= " AND s.office_id='".$excel_Office."'"; }
		if($excel_section == '6'){ $_filterCond .= "  AND f.payroll_status IN ('C') "; }
		
		$sqlReport = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd,
				p.leave_encashment, p.last_month_unpaid, p.notice_pay, p.pf_deduction, p.esic_deduction, p.ptax_deduction, p.tds_deductions, p.loan_recovery, p.total_deduction, p.net_payment, 
				p.payroll_by, concat(it_p.fname,' ',it_p.lname) as payroll_fullname, p.date_added as payroll_date,
				p.accounts_remarks, p.accounts_status, p.accounts_by, p.accounts_date, concat(it_a.fname,' ',it_a.lname) as accounts_fullname,
				concat(it_l.fname,' ',it_l.lname) as it_local_fullname, concat(it_n.fname,' ',it_n.lname) as it_netowrk_fullname, 
				concat(it_h.fname,' ',it_h.lname) as it_global_helpdesk_fullname, concat(it_s.fname,' ',it_s.lname) as it_security_fullname,
				concat(it_hr.fname,' ',it_hr.lname) as hr_fullname
				from user_fnf as f 
				LEFT JOIN signin as s ON s.id = f.user_id
				LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND is_active = '1'
				LEFT JOIN user_resign as r on r.id = f.resign_id
				LEFT JOIN terminate_users as t on t.id = f.term_id
				LEFT JOIN signin as it_l on it_l.id = f.it_local_by
				LEFT JOIN signin as it_n on it_n.id = f.it_network_by
				LEFT JOIN signin as it_h on it_h.id = f.it_global_helpdesk_by
				LEFT JOIN signin as it_s on it_s.id = f.it_security_by
				LEFT JOIN signin as it_p on it_p.id = f.payroll_by
				LEFT JOIN signin as it_a on it_a.id = f.account_by
				LEFT JOIN signin as it_hr on it_hr.id = f.final_update_by
				WHERE f.fnf_status IN ('P') $extra_terminate_check $_filterCond ORDER by s.fname";
		$queryReport = $this->Common_model->get_query_result_array($sqlReport);
		
		$this->generate_fnf_section_excel_reports($queryReport, $excel_Office ."_FNF_Pending", "FNF Pending List", $excel_section);
		
	}

	
/*	 
	 public function fnf_helpdesk_checkpoint(){
	 
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		
		$email_id_deletion = "0";
		$phone_login_deletion = "0";
		$login_credential_deletion = "0";
		$phone_login_deletion = "0";
		
		$domain_id_deletion = $this->input->post('domain_id_deletion'); if(!$domain_id_deletion) $domain_id_deletion = "0";
		$email_id_deletion = $this->input->post('email_id_deletion');   if(!$email_id_deletion) $email_id_deletion = "0";
		$login_credential_deletion = $this->input->post('login_credential_deletion'); if(!$login_credential_deletion) $login_credential_deletion = "0";
		$phone_login_deletion = $this->input->post('phone_login_deletion');  if(!$phone_login_deletion) $phone_login_deletion = "0";
		
		$computer_items = $this->input->post('computer_items');   
		$security_comments = $this->input->post('security_comments'); 
		$all_check = $this->input->post('all_check');
		
		//echo $domain_id_deletion .$email_id_deletion .$login_credential_deletion .$phone_login_deletion;
		
		if(($user_id != "") && ($fnf_id != "")){
			
			$field_array = array(
				"domain_id_deletion" => $domain_id_deletion,
				"email_id_deletion" => $email_id_deletion,
				"login_id_deletion" => $login_credential_deletion,
				"phone_login_deletion" => $phone_login_deletion,
				"computer_items_returned" => $computer_items,
				"security_comments" => $security_comments,
				"department_clearance" => $all_check,
				"it_helpdesk_by" => $current_user,
				"updated" => $current_date
			);
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			//$this->db->where('resign_id', $resign_id);
			$this->db->update('user_fnf', $field_array);
			
			
			// UPDATE STATUS CHECK
			$fnf_list = "SELECT f.*, r.domain_id_deletion as domain_check, r.email_id_deletion as email_check, 
			         r.login_credential_deletion as login_check, r.phone_login_deletion as phone_check from user_fnf as f
					 LEFT JOIN user_resign as r on r.id = f.resign_id
					 WHERE f.user_id = '$user_id' AND f.id = '$fnf_id' ORDER by id DESC LIMIT 1";
			$fnf_status = $this->Common_model->get_query_row_array($fnf_list);
			$countcheck = 0; $submissioncheck = 0;
			if($fnf_status['domain_check'] == 1){ $countcheck++; if($fnf_status['domain_id_deletion'] == 1){ $submissioncheck++; } }
			if($fnf_status['email_check'] == 1){ $countcheck++; if($fnf_status['email_id_deletion'] == 1){ $submissioncheck++; } }
			if($fnf_status['login_check'] == 1){ $countcheck++; if($fnf_status['login_id_deletion'] == 1){ $submissioncheck++; } }
			if($fnf_status['phone_check'] == 1){ $countcheck++; if($fnf_status['phone_login_deletion'] == 1){ $submissioncheck++; } }
			
			$countcheck = $countcheck + 2;
			if($fnf_status['computer_items_returned'] != ''){ if($fnf_status['computer_items_returned'] != 'No'){ $submissioncheck++; } } 
			if($fnf_status['department_clearance'] != ''){ if($fnf_status['department_clearance'] != 'No'){ $submissioncheck++; }  }
			
			$status_array['it_helpdesk_status'] = 'P';
			if($submissioncheck == $countcheck){ $status_array['it_helpdesk_status'] = 'C'; }
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			//$this->db->where('resign_id', $resign_id);
			$this->db->update('user_fnf', $status_array);
						
			$ans="Done";
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
		
	 }
	 
	 
	 
	 
	 
	 public function fnf_security_checkpoint(){
	 
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
				
		$laptop_returned = $this->input->post('laptop_returned'); 
		//$computer_items = $this->input->post('computer_items');   
		//$security_comments = $this->input->post('security_comments'); 
		//$all_check = $this->input->post('all_check');  
		
		//echo $domain_id_deletion .$email_id_deletion .$login_credential_deletion .$phone_login_deletion;
		
		if(($user_id != "") && ($fnf_id != "")){
			
			$field_array = array(
				"laptop_returned" => $laptop_returned,
				//"computer_items_returned" => $computer_items,
				//"security_comments" => $security_comments,
				//"department_clearance" => $all_check,
				"it_security_by" => $current_user,
				"updated" => $current_date
			);
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			//$this->db->where('resign_id', $resign_id);
			$this->db->update('user_fnf', $field_array);
			
			
			// UPDATE STATUS CHECK
			$fnf_list = "SELECT f.* from user_fnf as f WHERE f.user_id = '$user_id' AND f.id = '$fnf_id' ORDER by id DESC LIMIT 1";
			$fnf_status = $this->Common_model->get_query_row_array($fnf_list);
			$countcheck = 1; $submissioncheck = 0;
			if($fnf_status['laptop_returned'] != ''){ if($fnf_status['laptop_returned'] != 'No'){ $submissioncheck++; } } 
			//if($fnf_status['computer_items_returned'] != ''){ if($fnf_status['computer_items_returned'] != 'No'){ $submissioncheck++; } } 
			//if($fnf_status['department_clearance'] != ''){ if($fnf_status['department_clearance'] != 'No'){ $submissioncheck++; }  }
			
			$status_array['it_security_status'] = 'P';
			if($submissioncheck == $countcheck){ $status_array['it_security_status'] = 'C'; }
			
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			//$this->db->where('resign_id', $resign_id);
			$this->db->update('user_fnf', $status_array);
			
					
			$ans="Done";
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
		
	 }
	 
	 
	
	public function fnf_payroll_checkpoint(){
	 
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
				
		$last_month_unpaid = $this->input->post('last_month_unpaid'); 
		$leave_encashment = $this->input->post('leave_encashment'); 
		//$loss_of_pay = $this->input->post('loss_of_pay');   
		$notice_pay = $this->input->post('notice_pay'); 
		$pf_deduction = $this->input->post('pf_deduction'); 
		$esic_deduction = $this->input->post('esic_deduction'); 
		$ptax_deduction = $this->input->post('ptax_deduction'); 
		//$misc_deductions = $this->input->post('misc_deductions');  
		$tds_deductions = $this->input->post('tds_deductions');  
		//$others_pay = $this->input->post('others_pay');  
		$loan_recovery = $this->input->post('loan_recovery'); 
		$total_deduction = $this->input->post('total_deduction'); 
		$net_payment = $this->input->post('net_payment'); 
		
		//echo $domain_id_deletion .$email_id_deletion .$login_credential_deletion .$phone_login_deletion;
		
		if(($user_id != "") && ($fnf_id != "")){
			
			// MAKE OTHERS INACTIVE
			$field_array = array(
				"is_active" => '0',
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('fnf_id', $fnf_id);
			$this->db->update('user_fnf_payroll', $field_array);
			
			$field_array = array(
			    "user_id" => $user_id,
				"fnf_id" => $fnf_id,
				"last_month_unpaid" => $last_month_unpaid,
				"leave_encashment" => $leave_encashment,
				//"loss_of_pay" => $loss_of_pay,
				"notice_pay" => $notice_pay,
				"pf_deduction" => $pf_deduction,
				"esic_deduction" => $esic_deduction,
				"ptax_deduction" => $ptax_deduction,
				//"misc_deductions" => $misc_deductions,
				"tds_deductions" => $tds_deductions,
				//"others_pay" => $others_pay,
				"loan_recovery" => $loan_recovery,
				"total_deduction" => $total_deduction,
				"net_payment" => $net_payment,
				"payroll_by" => $current_user,
				"payroll_status" => 'C',
				"is_active" => '1',
				"date_added" => $current_date,
				"logs" => $logs
			);
			
			data_inserter('user_fnf_payroll', $field_array);
			
			$field_array = array(
				"payroll_by" => $current_user,
				"payroll_status" => 'C',
				"updated" =>  $current_date
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $fnf_id);
			$this->db->update('user_fnf', $field_array);
			
			$ans="Done";
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
		
	}
	
	
	public function fnf_accounts_checkpoint(){
	 
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$payment_id = $this->input->post('payment_id');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
				
		$leave_encashment = $this->input->post('leave_encashment'); 
		//$loss_of_pay = $this->input->post('loss_of_pay');   
		$notice_pay = $this->input->post('notice_pay'); 
		//$misc_deductions = $this->input->post('misc_deductions');  
		$tds_deductions = $this->input->post('tds_deductions');  
		//$others_pay = $this->input->post('others_pay');  
		$loan_recovery = $this->input->post('loan_recovery'); 
		
		$account_status = $this->input->post('account_status'); 
		$account_remarks = $this->input->post('account_remarks'); 
		
		//echo $domain_id_deletion .$email_id_deletion .$login_credential_deletion .$phone_login_deletion;
		
		if(($user_id != "") && ($fnf_id != "") && ($payment_id != "") && ($account_status != "")){
			
			$payroll_status = 'C';
			
			if($account_status == "R"){
				$payroll_status = "R";
			}
			
			$field_array = array(
				"payroll_status" => $payroll_status,
				"accounts_remarks" => $account_remarks,
				"accounts_status" => $account_status,
				"accounts_by" => $current_user,
				"accounts_date" => $current_date
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('fnf_id', $fnf_id);
			$this->db->where('id', $payment_id);
			$this->db->update('user_fnf_payroll', $field_array);
			
			
			$field_array = array(
				"payroll_status" => $payroll_status,
				"account_by" => $current_user,
				"account_status" => $account_status,
				"updated" =>  $current_date
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $fnf_id);
			$this->db->update('user_fnf', $field_array);
			
			$ans="Done";
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
		
	}
	  
	
	public function move_to_checkpoint(){
		if(check_logged_in()){
		
			$type = $this->uri->segment(3);
			$fid = $this->uri->segment(4);
			
			if($type == 'helpdesk'){
				$sql = "UPDATE user_fnf SET it_helpdesk_status = 'C' WHERE id = '$fid'";
				$this->db->query($sql);
			}
			
			if($type == 'security'){
				$sql = "UPDATE user_fnf SET it_security_status = 'C' WHERE id = '$fid'";
				$this->db->query($sql);
			}
			
			if($type == 'payroll'){
				$sql = "UPDATE user_fnf SET payroll_status = 'C' WHERE id = '$fid'";
				$this->db->query($sql);
			}
			
		    redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
*/
	
	
//==========================================================================================================	
//  FNF NEW FLOW
//==========================================================================================================

	public function fnf_details_ajax()
	{
		$fnfID = $this->input->post('fnf_id');
		if(empty($fnfID)){ $fnfID = $this->uri->segment(3); }
		$sqlReport = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd,
				p.leave_encashment, p.last_month_unpaid, p.notice_pay, p.pf_deduction, p.esic_deduction, p.ptax_deduction, p.tds_deductions, p.loan_recovery, p.total_deduction, p.net_payment, p.payroll_status as p_payroll_status, p.id as payment_id, p.payroll_by as p_payroll_by, concat(it_p.fname,' ',it_p.lname) as p_payroll_fullname, p.date_added as p_payroll_date, p.accounts_remarks as p_accounts_remarks, p.accounts_status as p_accounts_status, p.accounts_by as p_accounts_by, p.accounts_date as p_accounts_date, concat(it_a.fname,' ',it_a.lname) as p_accounts_fullname,
				concat(it_hr.fname,' ',it_hr.lname) as hr_fullname
				from user_fnf as f 
				LEFT JOIN signin as s ON s.id = f.user_id
				LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND is_active = '1'
				LEFT JOIN user_resign as r on r.id = f.resign_id
				LEFT JOIN terminate_users as t on t.id = f.term_id
				LEFT JOIN signin as it_p on it_p.id = f.payroll_by
				LEFT JOIN signin as it_a on it_a.id = f.account_by
				LEFT JOIN signin as it_hr on it_hr.id = f.final_update_by
				WHERE f.id = '$fnfID'";
		$queryReport = $this->Common_model->get_query_row_array($sqlReport);
		echo json_encode($queryReport);
	}
	
	public function fnf_details_view()
	{
		$fnfID = $this->input->get('fid');
		if(empty($fnfID)){ $fnfID = $this->uri->segment(3); }
		$sqlReport = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd,
				p.leave_encashment, p.last_month_unpaid, p.notice_pay, p.pf_deduction, p.esic_deduction, p.ptax_deduction, p.tds_deductions, p.loan_recovery, p.total_deduction, p.net_payment, p.payroll_status as p_payroll_status, p.id as payment_id, p.payroll_by as p_payroll_by, concat(it_p.fname,' ',it_p.lname) as p_payroll_fullname, p.date_added as p_payroll_date, p.accounts_remarks as p_accounts_remarks, p.accounts_status as p_accounts_status, p.accounts_by as p_accounts_by, p.accounts_date as p_accounts_date, concat(it_a.fname,' ',it_a.lname) as p_accounts_fullname,
				concat(it_hr.fname,' ',it_hr.lname) as hr_fullname
				from user_fnf as f 
				LEFT JOIN signin as s ON s.id = f.user_id
				LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND is_active = '1'
				LEFT JOIN user_resign as r on r.id = f.resign_id
				LEFT JOIN terminate_users as t on t.id = f.term_id
				LEFT JOIN signin as it_p on it_p.id = f.payroll_by
				LEFT JOIN signin as it_a on it_a.id = f.account_by
				LEFT JOIN signin as it_hr on it_hr.id = f.final_update_by
				WHERE f.id = '$fnfID'";
		$data['fnfdetails'] = $this->Common_model->get_query_row_array($sqlReport);
		$this->load->view('fnf/user_fnf_details',$data);
	}
	
	public function fnf_logs($fnf_id, $type, $reference, $remarks)
	{
		$fieldDate = [
			"fnf_id" => $fnf_id,
			"type" => $type,
			"reference" => $reference,
			"remarks" => $remarks,
			"fnf_id" => $fnf_id,
			"added_by" => get_user_id(),
			"date_added" => CurrMysqlDate(),
			"logs" => get_logs(),			
		];
		$returnID = data_inserter('user_fnf_logs', $fieldDate);
		return $returnID;
	}


//========================================================================================================
// FINAL HR STATUS
//========================================================================================================
	 
	 public function hr_final_status(){
	 
		$fnfid = $this->input->get('fnfid');
		$final_comments = $this->input->get('final_comments');
				
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		if($fnfid != "" && $final_comments != ""){
			
			$field_array = array(
				"fnf_status" => "C",
				"final_comments" => $final_comments,
				"final_update_by" => $current_user,
				"final_update_date" => $current_date
			);
			
			$this->db->where('id', $fnfid);
			$this->db->update('user_fnf', $field_array);					
			
			$this->send_release_letter($fnfid);
			
			$ans="Done";
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
	 }
	 
	 
	 public function send_release_letter($fnfid, $send_mail='Y', $isredirect='N'){
			
			$filename = ''; 
															
			$SQLtxt = "SELECT f.*,f.id as fnfid, s.doj, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd, (select email_id_off from info_personal WHERE info_personal.user_id = s.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = s.id )as personal_email,(select name from role where role.id= s.role_id) as designation,(select location from office_location WHERE s.office_id = office_location.abbr )as location
		             from user_fnf as f 
		             LEFT JOIN signin as s ON s.id = f.user_id
					 LEFT JOIN user_resign as r on r.id = f.resign_id
					 LEFT JOIN terminate_users as t on t.id = f.term_id
					 WHERE office_id in ('KOL','HWH','BLR','CHE','NOI') AND f.id = '$fnfid' ";
			
						
			$data['individual_user']  = $crow = $this->Common_model->get_query_row_array($SQLtxt);
			
			if($crow['fnfid']!=""){
				
				$fname= $crow['fname'];
				$lname= $crow['lname'];
			
				$filename = 'Release_letter_'.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				$esubj='Release Letter of '.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				
				$eto = array();
				$eto[] = $crow['personal_email'];
				$eto[] = $crow['office_email'];
									
				$qSql="SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='".$user_id."');";
				$l1_email_off= $this->Common_model->get_single_value($qSql);					
				$ecc = array();
				$ecc[] = "employee.connect@fusionbposervices.com";
				$ecc[] = $l1_email_off;
					
				//implode(',',$eto)
					
				$html = $this->load->view('letters/release_letter', $data, TRUE); 
				
				if($send_mail=="Y"){
						
					$attachment_path = $this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
					
					sleep(1);
					
					$eBody = 'Please find your attached Release Letter';
					
					if(file_exists($attachment_path)){
						
						$is_send=$this->Email_model->send_email_sox($crow['id'],implode(',',$eto),implode(',',$ecc),$eBody,$esubj,$attachment_path);
						
						if($is_send == true){
							$SQLtxt ="UPDATE user_fnf SET is_resign_email_sent ='Y' WHERE id=". $crow['fnfid'] ."";
							$this->db->query($SQLtxt);
						}
					}
					if($isredirect=='Y'){
						$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "fnf";
						redirect($referer);
					}else{
						return "done";
					}
				
				}else{
					
					$this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
				}
			}
			
	}
			
	private function generate_pdf_files($html,$filename,$individual_user,$flags,$isSave='Y'){
		
		//ob_start();  // start output buffering
		$this->load->library('m_pdf');
		$this->m_pdf->pdf = new mPDF('c');
		
		//KOL,BLR,CHE,HWH,NOI
		
		if($flags == 1){
			 if($individual_user['office_id'] == 'HWH' ){
				 
				 $header_html = "<div><img src='". APPPATH ."/../assets/images/logohwr.png' height='70px'></div>";
				
				$header_footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>WINDOW TECHNOLOGIES PVT LTD.</span><br>
				<span style='text-align:center; font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
				<span style='text-align:center; font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
				<span style='text-align:center; font-size:11px'>www. xplore-tech.com</span><br>
				<span style='text-align:center; font-size:11px'>www.fusionbposervices.com</span></p>";
								
			 }else{
				
				$header_html = "<div class><img src='". APPPATH ."/../assets/images/logoxt.jpg' height='70px'></div>";
				
				$header_footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>XPLORE-TECH SERVICES PRIVATE LIMITED</span><br>
				<span style='text-align:center; font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
				<span style='text-align:center; font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
				<span style='text-align:center; font-size:11px'>www. xplore-tech.com</span><br>
				<span style='text-align:center; font-size:11px'>www.fusionbposervices.com</span></p>";
			 }
			
			$this->m_pdf->pdf->SetHTMLHeader($header_html);
			$this->m_pdf->pdf->SetHTMLFooter($header_footer);	
		}
				
		$filename=str_replace(' ', '_', $filename);
		
		$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);
		$attachment_path =FCPATH."temp_files/hr_letters/".$filename.".pdf";
		
			if($isSave=="Y") {
				
				$this->m_pdf->pdf->Output($attachment_path, "F");
				
				//ob_clean();
				return $attachment_path;
			}
			else{
				//ob_clean();
				$this->m_pdf->pdf->Output($filename.".pdf", "D");
			}
	}


//==========================================================================================================	
//  7. HOLD TEAM
//==========================================================================================================

	public function fnf_it_hold_team_checkpoint()
	{		 
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		$f_type = $this->input->post('f_type');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		$it_hold_status = $this->input->post('it_hold_status');
		$it_hold_remarks = $this->input->post('it_hold_remarks');
		
		$sqlUser = "SELECT s.fusion_id as value from signin as s WHERE s.id = '$user_id'";
		$user_fusionID = $this->Common_model->get_single_value($sqlUser);
				
		if(($user_id != "") && ($fnf_id != "") && ($user_fusionID != "")){
			
			if($it_hold_status == 1){
				
				$logID = $this->fnf_logs($fnf_id, 7, 'logs', $it_hold_remarks);
				
				$field_array = array(
					"is_hold" => $it_hold_status,
					"is_hold_by" => $current_user,				
					"is_hold_remarks" => $it_hold_remarks,
					"is_hold_date" => $current_date,
					"is_hold_log_id" => $logID
				);
			
				$this->db->where('id', $fnf_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_fnf', $field_array);
				
			} else {
				
				$logID = $this->fnf_logs($fnf_id, 8, 'logs', $it_hold_remarks);
				
				$field_array_2 = array(
					"is_hold" => 0,
				);
			
				$this->db->where('id', $fnf_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_fnf', $field_array_2);
			}
								
			$ans="Done";			
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
	}
	

//==========================================================================================================	
//  6. IT SECURITY TEAM 
//==========================================================================================================

	public function fnf_it_security_team_checkpoint()
	{		 
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		$f_type = $this->input->post('f_type');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		$it_security_remarks = $this->input->post('it_security_remarks');
		
		$sqlUser = "SELECT s.fusion_id as value from signin as s WHERE s.id = '$user_id'";
		$user_fusionID = $this->Common_model->get_single_value($sqlUser);
				
		if(($user_id != "") && ($fnf_id != "") && ($user_fusionID != "")){
			
			$logID = $this->fnf_logs($fnf_id, 6, 'logs', $it_security_remarks);
			
			$field_array = array(
				"it_security_by" => $current_user,
				"it_security_status" => 'C',				
				"it_security_remarks" => $it_security_remarks,
				"it_security_updated" => $current_date,
				"updated" => $current_date
			);
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('user_fnf', $field_array);
								
			$ans="Done";			
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
	}


//==========================================================================================================	
//  1. IT LOCAL TEAM 
//==========================================================================================================

	public function fnf_it_local_checkpoint()
	{		 
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		$f_type = $this->input->post('f_type');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		$return_computer_date = $this->input->post('return_computer_date');   
		$return_computer_headset = $this->input->post('return_computer_headset'); 
		$return_computer_tools = $this->input->post('return_computer_tools');
		$disable_dialer_id = $this->input->post('disable_dialer_id');
		$disable_crm_id = $this->input->post('disable_crm_id');
		
		$is_return_computer_date = $this->input->post('is_return_computer_date');   
		$is_return_computer_headset = $this->input->post('is_return_computer_headset'); 
		$is_return_computer_tools = $this->input->post('is_return_computer_tools');
		$is_disable_dialer_id = $this->input->post('is_disable_dialer_id');
		$is_disable_crm_id = $this->input->post('is_disable_crm_id');
		
		$sqlUser = "SELECT s.fusion_id as value from signin as s WHERE s.id = '$user_id'";
		$user_fusionID = $this->Common_model->get_single_value($sqlUser);
				
		if(($user_id != "") && ($fnf_id != "") && ($user_fusionID != "")){
			
			if($f_type == 2){
				
				$security_remarks = $this->input->post('security_remarks');  
				$field_array = array(
					"it_local_remarks" => $security_remarks,
					"updated" => CurrMySqlDate(),
				);
				$this->db->where('id', $fnf_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_fnf', $field_array);
				
				$this->fnf_logs($fnf_id, 1, 'security', $security_remarks);
				
			} else {
			
			$field_array = array(
				"return_date_computer" => $return_computer_date,
				"return_date_headset" => $return_computer_headset,
				"return_date_accessories" => $return_computer_tools,
				"disablement_date_dialer" => $disable_dialer_id,
				"disablement_date_crm" => $disable_crm_id,
				"is_return_date_computer" => $is_return_computer_date,
				"is_return_date_headset" => $is_return_computer_headset,
				"is_return_date_accessories" => $is_return_computer_tools,
				"is_disablement_date_dialer" => $is_disable_dialer_id,
				"is_disablement_date_crm" => $is_disable_crm_id,
				"it_local_by" => $current_user,
				"it_local_status" => 'C',
				"updated" => $current_date
			);
			
			// UPLOAD CONFIG
			$uploadDir = FCPATH .'/uploads/user_fnf/' .$user_fusionID.'/';
			if(!is_dir($uploadDir)){ mkdir($uploadDir, 0777, true); }
				
			$config['upload_path']   = $uploadDir;
			$config['allowed_types'] = 'jpg|png|jpeg|docx|doc|xls|xlsx|pdf';
			$config['max_size']      = 1024000;
			$this->load->library('upload', $config);
			
			// FILES UPDATE
			$return_computer_date_file = $_FILES['return_computer_date_file']['name'];
			if(!empty($return_computer_date_file))
			{
				if (!$this->upload->do_upload('return_computer_date_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 $fileName = $dataFile['file_name'];
					 $field_array += [ "return_date_computer_file" => $fileName ];
				}
			}
			
			// FILES UPDATE
			$disable_dialer_id_file = $_FILES['disable_dialer_id_file']['name'];
			if(!empty($disable_dialer_id_file))
			{
				if (!$this->upload->do_upload('disable_dialer_id_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 $fileName = $dataFile['file_name'];
					 $field_array += [ "disablement_date_dialer_file" => $fileName ];
				}
			}
			
			// FILES UPDATE
			$disable_crm_id_file = $_FILES['disable_crm_id_file']['name'];
			if(!empty($disable_crm_id_file))
			{
				if (!$this->upload->do_upload('disable_crm_id_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 $fileName = $dataFile['file_name'];
					 $field_array += [ "disablement_date_crm_file" => $fileName ];
				}
			}
			
			
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('user_fnf', $field_array);
								
			$ans="Done";
			
			}
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
	}


//==========================================================================================================	
//  2. IT NETWORK TEAM 
//==========================================================================================================
	
	public function fnf_it_network_checkpoint()
	{
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		$f_type = $this->input->post('f_type');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		$disablement_date_vpn = $this->input->post('disablement_date_vpn');   
		$disablement_date_firewall = $this->input->post('disablement_date_firewall');
		$is_disablement_date_vpn = $this->input->post('is_disablement_date_vpn');   
		$is_disablement_date_firewall = $this->input->post('is_disablement_date_firewall');
		
		$sqlUser = "SELECT s.fusion_id as value from signin as s WHERE s.id = '$user_id'";
		$user_fusionID = $this->Common_model->get_single_value($sqlUser);
				
		if(($user_id != "") && ($fnf_id != "") && ($user_fusionID != "")){
			
			if($f_type == 2){
				
				$security_remarks = $this->input->post('security_remarks');  
				$field_array = array(
					"it_network_remarks" => $security_remarks,
					"updated" => CurrMySqlDate(),
				);
				$this->db->where('id', $fnf_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_fnf', $field_array);
				
				$this->fnf_logs($fnf_id, 2, 'security', $security_remarks);
				
			} else {
			
			$field_array = array(
				"disablement_date_vpn" => $disablement_date_vpn,
				"disablement_date_firewall" => $disablement_date_firewall,
				"is_disablement_date_vpn" => $is_disablement_date_vpn,
				"is_disablement_date_firewall" => $is_disablement_date_firewall,
				"it_network_by" => $current_user,
				"it_network_status" => 'C',
				"updated" => $current_date
			);
			
			// UPLOAD CONFIG
			$uploadDir = FCPATH .'/uploads/user_fnf/' .$user_fusionID.'/';
			if(!is_dir($uploadDir)){ mkdir($uploadDir, 0777, true); }
				
			$config['upload_path']   = $uploadDir;
			$config['allowed_types'] = 'jpg|png|jpeg|docx|doc|xls|xlsx|pdf';
			$config['max_size']      = 1024000;
			$this->load->library('upload', $config);
			
			// FILES UPDATE
			$disablement_date_firewall_file = $_FILES['disablement_date_firewall_file']['name'];
			if(!empty($disablement_date_firewall_file))
			{
				if (!$this->upload->do_upload('disablement_date_firewall_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 echo $fileName = $dataFile['file_name'];
					 $field_array += [ "disablement_date_firewall_file" => $fileName ];
				}
			}			
			
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('user_fnf', $field_array);
								
			$ans="Done";
			
			}
			
		} else {
			$ans="Error";
		}
		
		echo $ans;	

	}


//==========================================================================================================	
//  3. IT GLOBAL HELPDESK TEAM 
//==========================================================================================================
	
	public function fnf_it_globalhelpdesk_checkpoint()
	{
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		$f_type = $this->input->post('f_type');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		$disablement_date_domain = $this->input->post('disablement_date_domain');   
		$disablement_date_email = $this->input->post('disablement_date_email');
		$disablement_date_ticket = $this->input->post('disablement_date_ticket');
		
		$is_disablement_date_domain = $this->input->post('is_disablement_date_domain');   
		$is_disablement_date_email = $this->input->post('is_disablement_date_email');
		$is_disablement_date_ticket = $this->input->post('is_disablement_date_ticket');
		
		$sqlUser = "SELECT s.fusion_id as value from signin as s WHERE s.id = '$user_id'";
		$user_fusionID = $this->Common_model->get_single_value($sqlUser);
				
		if(($user_id != "") && ($fnf_id != "") && ($user_fusionID != "")){
			
			if($f_type == 2){
				
				$security_remarks = $this->input->post('security_remarks');  
				$field_array = array(
					"it_global_helpdesk_remarks" => $security_remarks,
					"updated" => CurrMySqlDate(),
				);
				$this->db->where('id', $fnf_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_fnf', $field_array);
				
				$this->fnf_logs($fnf_id, 3, 'security', $security_remarks);
				
			} else {
				
			$field_array = array(
				"disablement_date_domain" => $disablement_date_domain,
				"disablement_date_email" => $disablement_date_email,
				"disablement_date_ticket" => $disablement_date_ticket,
				"is_disablement_date_domain" => $is_disablement_date_domain,
				"is_disablement_date_email" => $is_disablement_date_email,
				"is_disablement_date_ticket" => $is_disablement_date_ticket,
				"it_global_helpdesk_by" => $current_user,
				"it_global_helpdesk_status" => 'C',
				"updated" => $current_date
			);
			
			// UPLOAD CONFIG
			$uploadDir = FCPATH .'/uploads/user_fnf/' .$user_fusionID.'/';
			if(!is_dir($uploadDir)){ mkdir($uploadDir, 0777, true); }
				
			$config['upload_path']   = $uploadDir;
			$config['allowed_types'] = 'jpg|png|jpeg|docx|doc|xls|xlsx|pdf';
			$config['max_size']      = 1024000;
			$this->load->library('upload', $config);
			
			// FILES UPDATE
			$disablement_date_domain_file = $_FILES['disablement_date_domain_file']['name'];
			if(!empty($disablement_date_domain_file))
			{
				if (!$this->upload->do_upload('disablement_date_domain_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 echo $fileName = $dataFile['file_name'];
					 $field_array += [ "disablement_date_domain_file" => $fileName ];
				}
			}
			
			// FILES UPDATE
			$disablement_date_email_file = $_FILES['disablement_date_email_file']['name'];
			if(!empty($disablement_date_email_file))
			{
				if (!$this->upload->do_upload('disablement_date_email_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 $fileName = $dataFile['file_name'];
					 $field_array += [ "disablement_date_email_file" => $fileName ];
				}
			}
			
			// FILES UPDATE
			$disablement_date_ticket_file = $_FILES['disablement_date_ticket_file']['name'];
			if(!empty($disablement_date_ticket_file))
			{
				if (!$this->upload->do_upload('disablement_date_ticket_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 $fileName = $dataFile['file_name'];
					 $field_array += [ "disablement_date_ticket_file" => $fileName ];
				}
			}			
			
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('user_fnf', $field_array);
								
			$ans="Done";
			
			}
			
		} else {
			$ans="Error";
		}
		
		echo $ans;	

	}


//==========================================================================================================	
//  4. PAYROLL TEAM 
//==========================================================================================================
	
	public function fnf_it_payrollteam_checkpoint()
	{
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		$f_type = $this->input->post('f_type');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		$last_month_unpaid = $this->input->post('last_month_unpaid');   
		$leave_encashment = $this->input->post('leave_encashment');
		$notice_pay = $this->input->post('notice_pay');
		$pf_deduction = $this->input->post('pf_deduction');
		$esic_deduction = $this->input->post('esic_deduction');
		$ptax_deduction = $this->input->post('ptax_deduction');
		$tds_deductions = $this->input->post('tds_deductions');
		$loan_recovery = $this->input->post('loan_recovery');
		$total_deduction = $this->input->post('total_deduction');
		$net_payment = $this->input->post('net_payment');
		$biometric_access_revocation = $this->input->post('biometric_access_revocation');
		
		$sqlUser = "SELECT s.fusion_id as value from signin as s WHERE s.id = '$user_id'";
		$user_fusionID = $this->Common_model->get_single_value($sqlUser);
				
		if(($user_id != "") && ($fnf_id != "") && ($user_fusionID != "")){
			
			if($f_type == 2){
				
				$security_remarks = $this->input->post('security_remarks');  
				$field_array = array(
					"payroll_remarks" => $security_remarks,
					"updated" => CurrMySqlDate(),
				);
				$this->db->where('id', $fnf_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('user_fnf', $field_array);
				
				$this->fnf_logs($fnf_id, 4, 'security', $security_remarks);
				
			} else {
			
						
			// MAKE OTHERS INACTIVE
			$field_array = array(
				"is_active" => '0',
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('fnf_id', $fnf_id);
			$this->db->update('user_fnf_payroll', $field_array);
			
			
			$field_array = array(
				"user_id" => $user_id,
				"fnf_id" => $fnf_id,
				"last_month_unpaid" => $last_month_unpaid,
				"leave_encashment" => $leave_encashment,
				"notice_pay" => $notice_pay,
				"pf_deduction" => $pf_deduction,
				"esic_deduction" => $esic_deduction,
				"ptax_deduction" => $ptax_deduction,
				"tds_deductions" => $tds_deductions,
				"loan_recovery" => $loan_recovery,
				"total_deduction" => $total_deduction,
				"net_payment" => $net_payment,
				"payroll_by" => $current_user,
				"payroll_status" => 'C',
				"is_active" => '1',
				"date_added" => $current_date,
				"logs" => $logs
			);
			data_inserter('user_fnf_payroll', $field_array);
			
			$field_array = array(
				"biometric_access_revocation" => $biometric_access_revocation,
				"payroll_by" => $current_user,
				"payroll_status" => 'C',
				"updated" =>  $current_date
			);			
			
			// UPLOAD CONFIG
			$uploadDir = FCPATH .'/uploads/user_fnf/' .$user_fusionID.'/';
			if(!is_dir($uploadDir)){ mkdir($uploadDir, 0777, true); }
				
			$config['upload_path']   = $uploadDir;
			$config['allowed_types'] = 'jpg|png|jpeg|docx|doc|xls|xlsx|pdf';
			$config['max_size']      = 1024000;
			$this->load->library('upload', $config);
			
			// FILES UPDATE
			$biometric_access_revocation_file = $_FILES['biometric_access_revocation_file']['name'];
			if(!empty($biometric_access_revocation_file))
			{
				if (!$this->upload->do_upload('biometric_access_revocation_file'))
				{
					$ans="Error";
				} else {
					 $dataFile = $this->upload->data();
					 $fileName = $dataFile['file_name'];
					 $field_array += [ "biometric_access_revocation_file" => $fileName ];
				}
			}		
			
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('user_fnf', $field_array);
								
			$ans="Done";
			
			}
			
		} else {
			$ans="Error";
		}
		
		echo $ans;	

	}
	
	
//==========================================================================================================	
//  5. ACCOUNTS TEAM 
//==========================================================================================================
	
	public function fnf_accountsteam_checkpoint()
	{
		$user_id = $this->input->post('user_id');
		$fnf_id = $this->input->post('fnf_id');
		$resign_id = $this->input->post('resign_id');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		$last_month_unpaid = $this->input->post('last_month_unpaid');   
		$leave_encashment = $this->input->post('leave_encashment');
		$notice_pay = $this->input->post('notice_pay');
		$pf_deduction = $this->input->post('pf_deduction');
		$esic_deduction = $this->input->post('esic_deduction');
		$ptax_deduction = $this->input->post('ptax_deduction');
		$tds_deductions = $this->input->post('tds_deductions');
		$loan_recovery = $this->input->post('loan_recovery');
		$total_deduction = $this->input->post('total_deduction');
		$net_payment = $this->input->post('net_payment');
		$biometric_access_revocation = $this->input->post('biometric_access_revocation');
		
		$sqlUser = "SELECT s.fusion_id as value from signin as s WHERE s.id = '$user_id'";
		$user_fusionID = $this->Common_model->get_single_value($sqlUser);
				
		$payment_id = $this->input->post('payment_id');
		$account_status = $this->input->post('account_status'); 
		$account_remarks = $this->input->post('account_remarks'); 
		
		$status_salary_loan = $this->input->post('status_salary_loan'); 
		$status_credit_card = $this->input->post('status_credit_card'); 
		$status_gift_card = $this->input->post('status_gift_card'); 
		$status_reimbursement = $this->input->post('status_reimbursement'); 
		$status_incentive = $this->input->post('status_incentive'); 
				
		if(($user_id != "") && ($fnf_id != "") && ($user_fusionID != "") && ($payment_id != "")  && ($account_status != "")){
						
			$payroll_status = 'C';			
			if($account_status == "R"){
				$payroll_status = "R";
			}			
			$field_array = array(
				"payroll_status" => $payroll_status,
				"accounts_remarks" => $account_remarks,				
				"accounts_status" => $account_status,
				"accounts_by" => $current_user,
				"accounts_date" => $current_date
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('fnf_id', $fnf_id);
			$this->db->where('id', $payment_id);
			$this->db->update('user_fnf_payroll', $field_array);
			
			
			$field_array = array(
				"payroll_status" => $payroll_status,
				"status_salary_loan" => $status_salary_loan,
				"status_credit_card" => $status_credit_card,
				"status_gift_card" => $status_gift_card,
				"status_reimbursement" => $status_reimbursement,
				"status_incentive" => $status_incentive,
				"account_by" => $current_user,
				"account_status" => $account_status,
				"updated" =>  $current_date
			);
			
			$this->db->where('id', $fnf_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('user_fnf', $field_array);
								
			$ans="Done";
			
		} else {
			$ans="Error";
		}
		
		echo $ans;	

	}
	

//================ REPORTS CSV =========================================//
	
	public function fnf_notification_report()
	{    
			$data["aside_template"] = "fnf/fnf_aside.php";
			$data["content_template"] = "fnf/fnf_notification_report.php";
			$data["content_js"] = "user_fnf_js.php";
							
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
					

			$sqlReport = "SELECT ufr.*, CONCAT(s.fname,' ',s.lname) as user_name, s.fusion_id
			              from user_fnf_records as ufr
			              LEFT JOIN signin as s ON s.id = ufr.user_id GROUP BY ufr.user_id ORDER BY user_name";
			$data['queryReportnotification'] = $this->Common_model->get_query_result_array($sqlReport);
			

			//================ DATE FILTER				
			$sdate = GetLocalDate();
			$edate = GetLocalDate();
			
			$usergetdate_start = $this->input->post('start_date');
			$usergetdate_end = $this->input->post('end_date');
			$userget_id = $this->input->post('user_id');
		    if($usergetdate_start != ""){ $sdate = $usergetdate_start; $edate = $usergetdate_end; }
						
			$data['date_now'] = GetLocalDate();
			$data['start_date'] = $sdate;
			$data['end_date'] = $edate;
			$data['user_id'] = $userid;
		
		    //================ OFFICE FILTER
			$report_start = $this->input->post('start_date');
			$report_end = $this->input->post('end_date');
			$user_id = $this->input->post('user_id');
			$filter = "";
			if(!empty($user_id) && $user_id != 'ALL'){ 
				$filter .= " AND (ufr.user_id='$user_id')"; 
			}
			 
			if(!empty($report_start) && !empty($report_end))
			{
				$filter .= " AND ( ufr.date_added_local >= '".$report_start."' and  ufr.date_added_local <= '".$report_end."')";
			}	
				//========= DOWNLOAD CSV
				$sqlReport = "SELECT ufr.*, CONCAT(s.fname, ' ', s.lname) as fullname, s.fusion_id, d.shname as department, r.name as designation, s.office_id 
				              from user_fnf_records as ufr 
							  INNER JOIN signin as s ON s.id = ufr.user_id
							  LEFT JOIN role as r ON r.id = s.role_id
							  LEFT JOIN department as d ON d.id = s.dept_id
							  WHERE 1 $filter";				
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				
				//========= USER WISE COUNTS
				$sqlReportGroup = "SELECT ufr.*, COUNT(ufr.id) as counter, CONCAT(s.fname, ' ', s.lname) as fullname, 
				              s.fusion_id, d.shname as department, r.name as designation, s.office_id, fd.fnf_count as last_fnf_count
				              from user_fnf_records as ufr 
							  INNER JOIN signin as s ON s.id = ufr.user_id
							  LEFT JOIN role as r ON r.id = s.role_id
							  LEFT JOIN department as d ON d.id = s.dept_id
							  LEFT JOIN user_fnf_records as fd ON fd.user_id = ufr.user_id AND fd.id IN (SELECT MAX(id) from user_fnf_records GROUP BY user_id)
							  WHERE 1 $filter GROUP BY ufr.user_id, ufr.type ORDER BY fullname, ufr.type";
				$groupReport = $this->Common_model->get_query_result_array($sqlReportGroup);
				
				if($this->input->post('fnf_download')!=""){
					$this->generate_fnf_excel_reports_notification($queryReport, $sdate ."_fnf_notification", "FNF Notification Logs", $groupReport);
				}
			
			$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_fnf_excel_reports_notification($result_array, $xlName = "excel_report", $title="Report", $groupReport)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
	
		$this->objPHPExcel->createSheet();
		
		$activeSheet = 0;
		$this->objPHPExcel->setActiveSheetIndex($activeSheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($activeSheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet($activeSheet)->getStyle('A1:I1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet($activeSheet)->getStyle('A1:I1')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($activeSheet)->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "SL");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Office");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Name");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Department");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Designation");		
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Type");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Fnf Count");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Date");
				
		$i = 1;
				
		foreach($result_array as $wk=>$wv)
		{				
			$j = 0;
			$this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $i);			
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["department"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["designation"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, ucwords($wv["type"]));
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["fnf_count"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["date_added_local"]);
			
			$i++;			
		}
		
		$title = "FNF Notification Status";
		$activeSheet = 1;
		$this->objPHPExcel->setActiveSheetIndex($activeSheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($activeSheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet($activeSheet)->getStyle('A1:I1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet($activeSheet)->getStyle('A1:I1')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($activeSheet)->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "SL");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Office");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Name");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Department");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Designation");		
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Type");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Count");
		$i++; $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($i,1, "Last FNF Pending");
				
		$i = 1;
				
		foreach($groupReport as $wk=>$wv)
		{				
			$j = 0;
			$this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $i);			
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["department"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["designation"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, ucwords($wv["type"]));
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["counter"]);
			$j++;  $this->objPHPExcel->getActiveSheet($activeSheet)->setCellValueByColumnAndRow($j,$i+1, $wv["last_fnf_count"]);
			
			$i++;			
		}
		
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$xlName.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	

    public function reports_archieve()
	{    
			$data["aside_template"] = "fnf/fnf_aside.php";
			$data["content_template"] = "fnf/reports_archieve.php";
							
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
					
			//================ DATE FILTER				
			$sdate = GetLocalDate();
			$edate = GetLocalDate();
			
			$usergetdate_start = $this->input->post('start_date');
			$usergetdate_end = $this->input->post('end_date');
		    if($usergetdate_start != ""){ $sdate = $usergetdate_start; $edate = $usergetdate_end; }
						
			$data['date_now'] = GetLocalDate();
			$data['start_date'] = $sdate;
			$data['end_date'] = $edate;
		
		    //================ OFFICE FILTER
			$data['office_now'] = $user_office_id; $oValue = "";
			if($oValue=="") 
			{	
				$oValue = trim($this->input->post('office_id'));
				if($oValue!=""){ $data['office_now'] = $oValue; }
			}
						
			$_filterCond = " AND DATE(f.final_update_date) >= '$sdate' AND DATE(f.final_update_date) <= '$edate'";
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " AND s.office_id='".$oValue."'";
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$report_start = $this->input->post('start_date');
			$report_end = $this->input->post('end_date');
			
			if(!empty($report_start) && !empty($report_end))
			{
				//========= DOWNLOAD CSV
				$sqlReport = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				r.user_email, r.user_phone, r.resign_date, r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd, 
				p.leave_encashment, p.last_month_unpaid, p.notice_pay, p.pf_deduction, p.esic_deduction, p.ptax_deduction, p.tds_deductions, p.loan_recovery, p.total_deduction, p.net_payment,
				p.payroll_by, concat(it_p.fname,' ',it_p.lname) as payroll_fullname, p.date_added as payroll_date,
				p.accounts_remarks, p.accounts_status, p.accounts_by, p.accounts_date, concat(it_a.fname,' ',it_a.lname) as accounts_fullname,
				concat(it_l.fname,' ',it_l.lname) as it_local_fullname, concat(it_n.fname,' ',it_n.lname) as it_netowrk_fullname, 
				concat(it_h.fname,' ',it_h.lname) as it_global_helpdesk_fullname, concat(it_s.fname,' ',it_s.lname) as it_security_fullname,
				concat(it_hr.fname,' ',it_hr.lname) as hr_fullname
						from user_fnf as f 
						LEFT JOIN signin as s ON s.id = f.user_id
						LEFT JOIN user_fnf_payroll as p ON p.fnf_id = f.id AND is_active = '1'
						LEFT JOIN user_resign as r on r.id = f.resign_id
						LEFT JOIN terminate_users as t on t.id = f.term_id
						LEFT JOIN signin as it_l on it_l.id = f.it_local_by
						LEFT JOIN signin as it_n on it_n.id = f.it_network_by
						LEFT JOIN signin as it_h on it_h.id = f.it_global_helpdesk_by
						LEFT JOIN signin as it_s on it_s.id = f.it_security_by
						LEFT JOIN signin as it_p on it_p.id = f.payroll_by
						LEFT JOIN signin as it_a on it_a.id = f.account_by
						LEFT JOIN signin as it_hr on it_hr.id = f.final_update_by
						WHERE f.fnf_status NOT IN ('P','R') $_filterCond order by s.fname";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				
				$this->generate_fnf_excel_reports($queryReport, $sdate ."_fnf_archive", "FNF Archive");
			}
			
			$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_fnf_excel_reports($result_array, $xlName = "excel_report", $title="Report")
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AN1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true); 				
		$objWorksheet->getColumnDimension('M')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);			
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);			
		$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		$objWorksheet->getColumnDimension('W')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AH')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AI')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AJ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AK')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AL')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AM')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AN')->setAutoSize(true);
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:I1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('G1', "IT Local Team Checklist");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:L1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('J1', "IT Network Team Checklist");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:O1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('M1', "IT Global Helpdesk Checklist");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('P1:R1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('P1', "IT Security Team Checklist");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('S1:V1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('S1', "Final HR Checklist");
		
		/*$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('S1:AF1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('S1', "Payroll Checklist");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AG1:AJ1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AG1', "Accounts Checklist");
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AK1:AN1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AK1', "Final HR Checklist");
		*/
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AN2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AN2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		$this->objPHPExcel->getActiveSheet()->getStyle('G1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('bedfeb');
		$this->objPHPExcel->getActiveSheet()->getStyle('J1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('c9b2e7');
		$this->objPHPExcel->getActiveSheet()->getStyle('M1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f6c6f0');
		$this->objPHPExcel->getActiveSheet()->getStyle('P1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d8f6c6');
		$this->objPHPExcel->getActiveSheet()->getStyle('S1:AF1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		$this->objPHPExcel->getActiveSheet()->getStyle('AG1:AJ1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffe0ee');
		$this->objPHPExcel->getActiveSheet()->getStyle('AK1:AN1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('42f593');		
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Resign/Term Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Release Date/LWD");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Local");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Local By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Local Remarks");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Network");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Network By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Network Remarks");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Helpdesk");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Helpdesk By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Helpdesk Remarks");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Security");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Security By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Security Reamrks");
		/*
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Checklist");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Last Month Unpaid");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Leave Encashment");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notice Pay");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "PF Deduction");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "ESIC Deduction");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "PTAX Deduction");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "TDS Deductions");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Loan Recovery");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Total Deduction");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Net Payment");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Checklist By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Remarks");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Accounts Status");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Account Remarks");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Accounts By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Accounts Date");
		*/
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "HR Checklist By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "HR Updated Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Final Status");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Final Comments");
		
		$i = 1;
				
		foreach($result_array as $wk=>$wv)
		{	
			
			$rnt_date=$wv['resign_date'];
			if($rnt_date=="") $rnt_date=$wv['terms_date'];
						
			$lwd_date=$wv['dol'];
			if($lwd_date=="") $lwd_date=$wv['accepted_released_date'];
			if($lwd_date=="") $lwd_date=$wv['lwd'];
									
			
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $rnt_date);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $lwd_date);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_local_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_local_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_local_remarks"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_network_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_network_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_network_remarks"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_global_helpdesk_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_global_helpdesk_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_global_helpdesk_reamrks"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_security_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_security_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_security_remarks"]);
			/*
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["last_month_unpaid"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["leave_encashment"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["notice_pay"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["pf_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["esic_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["ptax_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["tds_deductions"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["loan_recovery"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["total_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["net_payment"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_remarks"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["account_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["accounts_remarks"]);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["accounts_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["accounts_date"]);
			*/
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["hr_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["final_update_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fnf_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["final_comments"]);
			$i++;			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$xlName.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	
	public function generate_fnf_section_excel_reports($result_array, $xlName = "excel_report", $title="Report", $section = '0')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AN1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true); 				
		$objWorksheet->getColumnDimension('M')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);			
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);			
		$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		$objWorksheet->getColumnDimension('W')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AH')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AI')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AJ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AK')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AL')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AM')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AN')->setAutoSize(true);
			
		//$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AB1:AE1');
		//$this->objPHPExcel->getActiveSheet()->setCellValue('AB1', "Final HR Checklist");
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AN2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:AN2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('AB1:AE1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('42f593');		
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Resign/Term Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Release Date/LWD");
		if($section >= 1)
		{
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:I1'); 
			$this->objPHPExcel->getActiveSheet()->setCellValue('G1', "IT Local Team Checklist");
			$this->objPHPExcel->getActiveSheet()->getStyle('G1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('bedfeb');
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Local");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Local By");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Local Remarks");
		}
		if($section >= 2)
		{
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:L1');
			$this->objPHPExcel->getActiveSheet()->getStyle('J1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('c9b2e7');
			$this->objPHPExcel->getActiveSheet()->setCellValue('J1', "IT Network Team Checklist");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Network");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Network By");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Network Remarks");
		}
		if($section >= 3)
		{
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:O1');
			$this->objPHPExcel->getActiveSheet()->getStyle('M1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f6c6f0');
			$this->objPHPExcel->getActiveSheet()->setCellValue('M1', "IT Global Helpdesk Checklist");			
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Helpdesk");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Helpdesk By");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Helpdesk Remarks");
		}
		if($section >= 4)
		{
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('P1:R1');
			$this->objPHPExcel->getActiveSheet()->getStyle('P1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d8f6c6');
			$this->objPHPExcel->getActiveSheet()->setCellValue('P1', "IT Security Team Checklist");			
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Security");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Security By");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "IT Security Reamrks");
		}
		if($section >= 5)
		{
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('S1:AF1');
			$this->objPHPExcel->getActiveSheet()->setCellValue('S1', "Payroll Checklist");
			$this->objPHPExcel->getActiveSheet()->getStyle('S1:AF1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Checklist");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Last Month Unpaid");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Leave Encashment");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Notice Pay");		
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "PF Deduction");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "ESIC Deduction");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "PTAX Deduction");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "TDS Deductions");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Loan Recovery");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Total Deduction");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Net Payment");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Checklist By");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Date");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Payroll Remarks");
		}
		if($section >= 5)
		{			
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AG1:AJ1');
			$this->objPHPExcel->getActiveSheet()->setCellValue('AG1', "Accounts Checklist");
			$this->objPHPExcel->getActiveSheet()->getStyle('AG1:AJ1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffe0ee');
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Accounts Status");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Account Remarks");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Accounts By");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Accounts Date");
		}
		if($section >= 5)
		{			
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('AK1:AN1');
			$this->objPHPExcel->getActiveSheet()->setCellValue('AK1', "Final HR Checklist");
			$this->objPHPExcel->getActiveSheet()->getStyle('AK1:AN1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('42f593');		
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "HR Checklist By");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "HR Updated Date");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Final Status");
			$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Final Comments");
		}
		
		$i = 1;				
		foreach($result_array as $wk=>$wv)
		{	
			
			$rnt_date=$wv['resign_date'];
			if($rnt_date=="") $rnt_date=$wv['terms_date'];
						
			$lwd_date=$wv['dol'];
			if($lwd_date=="") $lwd_date=$wv['accepted_released_date'];
			if($lwd_date=="") $lwd_date=$wv['lwd'];
									
			
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["office_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $rnt_date);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $lwd_date);
			if($section >= 1)
			{
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_local_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_local_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_local_remarks"]);
			}
			if($section >= 2)
			{
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_network_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_network_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_network_remarks"]);
			}
			if($section >= 3)
			{
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_global_helpdesk_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_global_helpdesk_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_global_helpdesk_reamrks"]);
			}
			if($section >= 4)
			{
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_security_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_security_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["it_security_remarks"]);
			}
			if($section >= 5)
			{
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["last_month_unpaid"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["leave_encashment"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["notice_pay"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["pf_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["esic_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["ptax_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["tds_deductions"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["loan_recovery"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["total_deduction"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["net_payment"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["payroll_remarks"]);
			}
			if($section >= 5)
			{
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["account_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["accounts_remarks"]);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["accounts_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["accounts_date"]);
			}
			if($section >= 5)
			{
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["hr_fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["final_update_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fnf_status"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["final_comments"]);
			}			
			$i++;			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$xlName.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	
	private function array_to_csv_download( $array, $filename = "export.csv", $delimiter="," )
	{
		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '";' );

		ob_end_clean();
		
		$handle = fopen( 'php://output', 'w' );

		fputcsv( $handle, array_keys( $array['0'] ) );

		foreach ( $array as $value ) {
			fputcsv( $handle, $value , $delimiter );
		}

		fclose( $handle );
		ob_flush();
		exit();
	}
	
	

//=================== AUTO MAIL ===============================================//

	function cron_automail_fnf_lastdate()
	{	
		$this->load->model('dfr_email_model');
		$this->dfr_email_model->send_email_autocron_notification_supervisor();
		
	}
	
	function automail_fnf_trigger_lwd_mailids()
	{	
		$mailsIDs = "sachin.paswan@fusionbposervices.com";
		return $mailsIDs;
	}
	
	
	function automail_fnf_trigger_lwd()
	{	
		$currentDate = CurrDate();
		$currentDate = "2020-04-02";
		$extra_terminate_check = " AND (t.t_type<>'11' OR t.t_type IS NULL)";
		
		$extra_today_termination = " AND ( ";
		$extra_today_termination  .= "(f.dol <> '' AND f.dol IS NOT NULL AND DATE_SUB(f.dol, INTERVAL 24 HOUR) = '$currentDate') ";
		$extra_today_termination  .= " OR (r.accepted_released_date <> '' AND r.accepted_released_date IS NOT NULL AND DATE_SUB(r.accepted_released_date, INTERVAL 24 HOUR) = '$currentDate') ";
		$extra_today_termination  .= " OR (t.lwd <> '' AND t.lwd IS NOT NULL AND DATE_SUB(t.lwd, INTERVAL 24 HOUR) = '$currentDate') ";
		$extra_today_termination  .= " )";
		
		
		///== MAIL BODY
		$counter = 0;
		$mailBODY = '<h4><b>NOTE : It is an automated mail, kindly please do not reply.</b></h4><br/>
					Tomorrow is the last working day for the following employees, kindly please process their fnf accordingly.</br></br>
					<b>DATE : '.date('d M, Y', strtotime($currentDate)) .'</b><br/><br/>';
		
		
		$sql_dataLog = "SELECT f.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, d.shname as department, rs.name as designation, 
		               get_process_names(s.id) as process_names, get_client_names(s.id) as client_names, concat(l.fname,' ',l.lname) as l1_supervisor,
		                r.user_email, r.user_phone, r.resign_date,r.accepted_released_date, date(t.terms_date) as terms_date, t.lwd 
						from user_fnf as f 
						INNER JOIN signin as s ON s.id = f.user_id
						LEFT JOIN department as d ON s.dept_id = d.id
						LEFT JOIN role as rs ON rs.id = s.role_id
						LEFT JOIN signin as l ON l.id = s.assigned_to
						LEFT JOIN user_resign as r on r.id = f.resign_id
						LEFT JOIN terminate_users as t on t.id = f.term_id
						WHERE 
						f.fnf_status = 'P'
						$extra_today_termination
						$extra_terminate_check 
						order by s.fname";
		$datLogs = $this->Common_model->get_query_result_array($sql_dataLog);
		foreach($datLogs as $token)
		{
			$counter++;
			$e_name = $token['fullname'];
			$e_fusionID = $token['fusion_id'];
			$e_officeID = $token['office_id'];
			$e_supervisor = $token['l1_supervisor'];
			$e_process = $token['process_names'];
			$e_client = $token['client_names'];
			$e_designation = $token['designation'];
			$e_department = $token['department'];
			
			$lwd_date=$token['dol'];
			if($lwd_date=="") $lwd_date=$token['accepted_released_date'];
			if($lwd_date=="") $lwd_date=$token['lwd'];
			
			$mailBODY .= ' 				
					<b>'.$counter.'. ' .$e_name.' (' .$e_fusionID .') :</b><br/><br/>
					<table border="1" width="80%" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Employee Name :</td>
								<td style="padding:2px 0px 2px 8px">'.$e_name .'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Fusion ID :</td>
								<td style="padding:2px 0px 2px 8px">'.$e_fusionID.'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Office :</td>
								<td style="padding:2px 0px 2px 8px">'.$e_officeID.'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Department :</td>
								<td style="padding:2px 0px 2px 8px">'.$e_department.'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Designation :</td>
								<td style="padding:2px 0px 2px 8px">'.$e_designation.'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Client :</td>
								<td style="padding:2px 0px 2px 8px">'.$e_client.'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Process :</td>
								<td style="padding:2px 0px 2px 8px">'.$e_process.'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">l1 Supervisor</td>
								<td style="padding:2px 0px 2px 8px">'.$e_supervisor.'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Last Working Day</td>
								<td style="padding:2px 0px 2px 8px">'.$lwd_date.'</td>
							</tr>
					</table>
									
				</br>
				</br>';		
			
		}
		
		$mailBODY .= '</br><b>Regards, </br>
					   Fusion - FEMS	</b></br>
				      ';
		echo $mailBODY;
		
		$mailsIDs = $this->automail_fnf_trigger_lwd_mailids();
		$mailsSub = "FNF Pending | Last Working day for Employeee";
		//$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "",$from_email,$from_name,'N');	
		
	}
	
	
	
	
	//=====================================================================================//
	//  FNF INFO
	//====================================================================================//
	
	public function fnf_info()
	{
		//error_reporting(1);
		//ini_set('display_errors', true);
		//$this->db->db_debug = true;
		
		// FNF CHECK
		$currentUser = get_user_id();
		$currentDate = CurrDate();
		$sqlCheck = "SELECT fc.* from user_fnf_records as fc INNER JOIN signin as s ON s.id = fc.user_id WHERE fc.user_id = '$currentUser' AND DATE(fc.date_added) = '$currentDate' AND s.office_id IN ('KOL','HWH','BLR','CHE','NOI','MUM')";
		$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
		$showUPFnf = true;
		if(!empty($queryCheck)){
			$showUPFnf = false;
		}
		
		// OLD FNF TEST
		$last3Days = date('Y-m-d', strtotime('-3 days', strtotime($currentDate)));
		$sqlOLD = "SELECT fc.* from user_fnf_records as fc INNER JOIN signin as s ON s.id = fc.user_id WHERE fc.user_id = '$currentUser' AND DATE(fc.date_added) <= '$last3Days'  AND s.office_id IN ('KOL','HWH','BLR','CHE','NOI','MUM') ORDER BY fc.id DESC LIMIT 1";
		$queryOLD = $this->Common_model->get_query_result_array($sqlOLD);
		$data['last3Days'] = $queryOLD;
		
		$extra_terminate_check = " AND (t.t_type<>'11' || t.t_type IS NULL)";
		
		$data['showup'] = "";
		
		// IT LOCAL
		if(isAccessFNFITHelpdesk()==true){			
			$data['showup'] = "IT LOCAL";			
			$sqlFnfCount = "SELECT count(f.id) as value, s.office_id from user_fnf as f 
							INNER JOIN signin as s ON s.id = f.user_id
							LEFT JOIN user_resign as r on r.id = f.resign_id
							LEFT JOIN terminate_users as t on t.id = f.term_id
							WHERE f.it_local_status != 'C' AND f.fnf_status = 'P' $extra_terminate_check
							GROUP BY s.office_id ORDER BY value DESC
							";
			$fnfCount = $this->Common_model->get_query_result_array($sqlFnfCount);
			//echo $fnfCount ."<hr/>";
			//echo "<pre>" .print_r($fnfCount, 1) ."</pre>";
		}
		
		// IT NETWORK
		if(isAccessFNFITHelpdesk()==true){
			$data['showup'] = "IT LOCAL";
			$sqlFnfCount = "SELECT count(f.id) as value, s.office_id   from user_fnf as f 
							INNER JOIN signin as s ON s.id = f.user_id
							LEFT JOIN user_resign as r on r.id = f.resign_id
							LEFT JOIN terminate_users as t on t.id = f.term_id
							WHERE f.it_network_status != 'C' AND f.fnf_status = 'P' $extra_terminate_check
							GROUP BY s.office_id ORDER BY value DESC
							";
			$fnfCount = $this->Common_model->get_query_result_array($sqlFnfCount);
			//echo "<pre>" .print_r($fnfCount, 1) ."</pre>";
		}
		
		
		// IT HELPDESK
		if(isAccessFNFITHelpdesk()==true){
			$data['showup'] = "IT GLOBAL HELPDESK";
			$sqlFnfCount = "SELECT count(f.id) as value, s.office_id   from user_fnf as f 
							INNER JOIN signin as s ON s.id = f.user_id
							LEFT JOIN user_resign as r on r.id = f.resign_id
							LEFT JOIN terminate_users as t on t.id = f.term_id
							WHERE f.it_global_helpdesk_status != 'C' AND f.fnf_status = 'P' $extra_terminate_check
							GROUP BY s.office_id ORDER BY value DESC
							";
			$fnfCount = $this->Common_model->get_query_result_array($sqlFnfCount);
			//echo "<pre>" .print_r($fnfCount, 1) ."</pre>";
		}
		
		$data['showup'] = "IT";
		//if(get_global_access()){ $data['showup'] = ""; }
			
		// IT SECURITY
		if(isAccessFNFITSecurity()==true){
			$data['showup'] = "IT SECURITY";
			$sqlFnfCount = "SELECT count(f.id) as value, s.office_id   from user_fnf as f 
							INNER JOIN signin as s ON s.id = f.user_id
							LEFT JOIN user_resign as r on r.id = f.resign_id
							LEFT JOIN terminate_users as t on t.id = f.term_id
							WHERE f.it_security_status != 'C' AND f.fnf_status = 'P' 
							AND (f.it_local_status = 'C' OR f.it_network_status = 'C' OR f.it_global_helpdesk_status = 'C') $extra_terminate_check
							GROUP BY s.office_id ORDER BY value DESC
							";
			$fnfCount = $this->Common_model->get_query_result_array($sqlFnfCount);
			//echo "<pre>" .print_r($fnfCount, 1) ."</pre>";
		}
		
		// HR PENDING
		if(isAccessFNFHr()==true){
			$data['showup'] = "HR";
			$sqlFnfCount = "SELECT count(f.id) as value, s.office_id   from user_fnf as f 
							INNER JOIN signin as s ON s.id = f.user_id
							LEFT JOIN user_resign as r on r.id = f.resign_id
							LEFT JOIN terminate_users as t on t.id = f.term_id
							WHERE f.fnf_status = 'P' 
							AND (f.it_local_status = 'C' AND f.it_network_status = 'C' AND f.it_global_helpdesk_status = 'C' AND f.it_security_status ='C') $extra_terminate_check
							GROUP BY s.office_id ORDER BY value DESC
							";
			$fnfCount = $this->Common_model->get_query_result_array($sqlFnfCount);
		}
		
		$data['fnf_list'] = $fnfCount;
		$data['total'] = !empty($fnfCount) ? array_sum(array_column($fnfCount, 'value')) : '0';
		
		if(empty($data['total'])){
			$dataUpdate = [
				"type" => 'skip',
				"user_id" => $currentUser,
				"fnf_count" => $data['total'],
				"date_added" => CurrMysqlDate(),
				"date_added_local" => GetLocalTime(),
				"logs" => get_logs()
			];		
			data_inserter('user_fnf_records', $dataUpdate);
			redirect(base_url('home'));
		}		
		
		$data["content_template"] = "fnf/fnf_notification_view.php";
		$this->load->view('dashboard_single_col',$data);
		
	}
	
	
	public function fnf_submission_info()
	{
		$currentType = $this->uri->segment(3);
		$currentCount = $this->uri->segment(4);
		
		if(empty($currentCount)){
			$currentCount = 0;
		}
		
		if(empty($currentType)){
			$currentType = 'skip';
		}
		
		$currentUser = get_user_id();
		$currentDate = CurrMysqlDate();
		
		$dataUpdate = [
			"type" => $currentType,
			"user_id" => $currentUser,
			"fnf_count" => $currentCount,
			"date_added" => CurrMysqlDate(),
			"date_added_local" => GetLocalTime(),
			"logs" => get_logs()
		];		
		data_inserter('user_fnf_records', $dataUpdate);
		
		if($currentType == 'skip'){
			redirect(base_url('home'));
		} else {
			redirect(base_url('fnf'));
		}
		
	}

	
}