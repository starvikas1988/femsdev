<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clinic_portal extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){		
		if(get_role_dir() == 'agent'){
			redirect(base_url()."clinic_portal/documents");
		} else {
			redirect(base_url()."clinic_portal/dashboard");
		}
	 
	}
	
	public function dashboard()
	{
		
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
			
		$extraFilter = ""; $extraTotal = "";
		$todayStartDate = CurrDate()." 00:00:00"; $todayEndDate = CurrDate()." 23:59:59";
		if(!empty($this->input->get('start')))
		{ 
			$todayStartDate = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$todayEndDate = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";			
		}
		
		$sql = "SELECT count(*) as value from clinic_patient as c WHERE 1 $extraTotal";
		$data['total_records'] = $total_records = $this->Common_model->get_single_value($sql);
		
		$extraFilter .= " AND (c.date_added >= '$todayStartDate' AND c.date_added <= '$todayEndDate') ";
		
		$sql = "SELECT count(*) as value from clinic_patient as c WHERE 1 $extraFilter";
		$data['today_records'] = $today_records = $this->Common_model->get_single_value($sql);
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		$selected_year = date('Y');
		$selected_month = date('m');
		
		$selected_year = date('Y');
		for($i = 1; $i <= 12; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			$sql_visitor = "SELECT count(c.id) as value from clinic_patient as c WHERE c.date_added >= '$start_date_full' AND c.date_added <= '$end_date_full'";
			$visitor_query = $this->Common_model->get_single_value($sql_visitor);
			
			$data['visitors'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['visitors'][$i]['year'] = $selected_year;
			$data['visitors'][$i]['count'] = $visitor_query;
			
		}
		
		$data['selected_year'] = $selected_year;
		$data['selected_month'] = $selected_month;

		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data["aside_template"] = "clinic_portal/aside.php";
		$data["content_template"] = "clinic_portal/clinic_dashboard.php";				
		$data["content_js"] = "clinic_portal/clinic_portal_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function documents()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
			
		$extraFilter = ""; $extraTotal = "";
		$todayStartDate = CurrDate()." 00:00:00"; $todayEndDate = CurrDate()." 23:59:59";
		
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		
		$data['selected_year'] = $selected_year;
		$data['selected_month'] = $selected_month;

		$data["aside_template"] = "clinic_portal/aside.php";
		$data["content_template"] = "clinic_portal/clinic_documents.php";				
		$data["content_js"] = "clinic_portal/clinic_portal_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	public function check_documents($file_name,$view='')
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$get_fusion_id=get_user_fusion_id();
			$file_id = base64_decode(urldecode($file_name));
			
			//if($uid == $current_user || get_global_access()=='1' || is_update_system_data()==true){
			
			$file = FCPATH .'assets/clinic_portal/'.$file_id;
			
			$content_type=mime_content_type($file);
			if($content_type=="") $content_type="application/octet-stream";
			
			//echo $content_type;
			
				if(file_exists($file) && ($view != true || $view =='')) {
					
					 $ext = pathinfo($file, PATHINFO_EXTENSION);
						header("Content-type: ".$content_type);
						header('Content-Disposition: attachment; filename="'.basename($file).'"');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						@readfile($file);
				}elseif(file_exists($file) && $view == true ) {
						header("Content-type: ". $content_type);
						header('Content-Disposition: inline; filename="'.basename($file).'"');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						readfile($file);
				}
					
			/*}else{
				echo "You are not authorised to View";
			}*/
		}
	}
	
	
	public function patient()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		// INITIALIZE DATA
		$patient_id = "";
		$patient_details = array();
		$medical_details = array();
		$physical_details = array();
		$log_details = array();
		
		// CHECK URL VERIFY
		$type = "add";
		$pid  = "";
		if(!empty($this->uri->segment(3)) && !empty($this->uri->segment(4)))
		{
			if($this->uri->segment(3) == 'edit')
			{
				$type = $this->uri->segment(3);
				$pid = $this->uri->segment(4);
			}
		}
		
		// CHECK DB VERIFY		
		if(!empty($pid))
		{
			$patient_sql = "SELECT * from clinic_patient WHERE id = '$pid'";
			$patient_details = $this->Common_model->get_query_row_array($patient_sql);
			if(!empty($patient_details['id']))
			{
				$patient_id = $patient_details['id'];
				
				$medical_sql = "SELECT * from clinic_doctor_consult WHERE patient_id = '$pid'";
				$medical_details = $this->Common_model->get_query_result_array($medical_sql);
				
				$physical_sql = "SELECT * from clinic_physical WHERE patient_id = '$pid'";
				$physical_details = $this->Common_model->get_query_result_array($physical_sql);
				
				$logs_sql = "SELECT * from clinic_logs WHERE patient_id = '$pid'";
				$log_details = $this->Common_model->get_query_result_array($logs_sql);
			} else {
				redirect(base_url('clinic_portal'));
			}
		}
		
		$data['patient_id'] = $patient_id;
		$data['patient_details'] = $patient_details;
		$data['medical_details'] = $medical_details;
		$data['physical_details'] = $physical_details;
		$data['log_details'] = $log_details;
		
		$user_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['user_details'] = $this->Common_model->get_query_row_array($user_sql);
				
		$data["aside_template"] = "clinic_portal/aside.php";
		$data["content_template"] = "clinic_portal/clinic_profile.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function patient_search()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data["aside_template"] = "clinic_portal/aside.php";
		$data["content_template"] = "clinic_portal/clinic_search.php";

		$search_crm = "";
		if(!empty($this->input->get('search_crm')))
		{ 
			$search_crm = $this->input->get('search_crm');
			$extraFilter .= " AND c.patient_code = '$search_crm' ";
		}
		
		$search_name = "";
		if(!empty($this->input->get('search_name')))
		{ 
			$search_name = $this->input->get('search_name');
			$extraFilter .= " AND (c.c_name LIKE '%$search_name%')";
		}
		
		$data['crm_list'] = NULL;		
		$data['search_crm'] = $search_crm;
		$data['search_name'] = $search_name;
		
		
		if($search_crm != "" || $search_name != "")
		{
			$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from clinic_patient as c LEFT JOIN signin as s ON s.id = c.added_by 
		                 WHERE 1 $extraFilter";
			$data['crm_list'] = $querycase = $this->Common_model->get_query_result_array($sqlcase);
		}
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function patient_list()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data["aside_template"] = "clinic_portal/aside.php";
		$data["content_template"] = "clinic_portal/clinic_list.php";

		$extraFilter = ""; $extraLimit = " LIMIT 500";

		// FILTER DATE CHECK 
		$from_date = CurrMySqlDate();
		$to_date = CurrMySqlDate();
		if(!empty($this->input->get('search_from_date')))
		{ 
			$from_date = date('Y-m-d',strtotime($this->input->get('search_from_date'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('search_to_date'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
			$extraLimit = "";
		}
				
		if($is_role_dir == "agent")
		{
			$extraFilter .= " AND (c.added_by = '$current_user') ";
		}
				
		$data['call_type'] = $call_type;
		$data['from_date'] = date('Y-m-d',strtotime($from_date));
		$data['to_date'] = date('Y-m-d',strtotime($to_date));
		
		$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from clinic_patient as c LEFT JOIN signin as s ON s.id = c.added_by 
		            WHERE 1 $extraFilter ORDER by c.id DESC $extraLimit";
		$data['crm_list'] = $querycase = $this->Common_model->get_query_result_array($sqlcase);
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	//--------- CRM PATIENT ID	
	public function generate_patient_id()
	{
		$sql = "SELECT count(*) as value from clinic_patient ORDER by id DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_crm_id = "PT" .mt_rand(11,99) .sprintf('%06d', $lastid + 1);
		return $new_crm_id;
	}
	
	//--------- ADD PATIENT 
	public function addPatient()
	{
		$current_user = get_user_id();
		
		$patient_id   = $this->input->post('c_patient_id');
		$c_name       = $this->input->post('c_name');
		$c_birthdate  = $this->input->post('c_birthdate');
		$c_gender     = $this->input->post('c_gender');
		$c_address    = $this->input->post('c_address');
		$c_blood      = $this->input->post('c_blood');
		$c_allergy    = $this->input->post('c_allergy');
		$c_medical    = $this->input->post('c_medical');
		$c_medical_remarks = $this->input->post('c_medical_remarks');
		
		
		$d_date         = $this->input->post('d_date');
		$d_complaint    = $this->input->post('d_complaint');
		$d_assessment   = $this->input->post('d_assessment');
		$d_intervention = $this->input->post('d_intervention');
		$d_user_id 		= $this->input->post('d_user_id');
		$d_ref_id 		= $this->input->post('d_ref_id');
		
		$p_year 		= $this->input->post('p_year');
		$p_cbc 			= $this->input->post('p_cbc');
		$p_urinalysis   = $this->input->post('p_urinalysis');
		$p_xray 		= $this->input->post('p_xray');
		$p_drugtest 	= $this->input->post('p_drugtest');
		$p_physical 	= $this->input->post('p_physical');
		$p_clearance 	= $this->input->post('p_clearance');
		$p_user_id 		= $this->input->post('p_user_id');
		$p_ref_id 		= $this->input->post('p_ref_id');
				
		$case_array = [
			'c_name' 	   => $c_name,
			'c_birth' 	   => date('Y-m-d', strtotime($c_birthdate)),
			'c_gender'     => $c_gender,
			'c_blood'      => $c_blood,
			'c_address'    => $c_address,
			'c_allergy'    => $c_allergy,
			'c_medical'    => $c_medical,
			'c_medical_remarks' => $c_medical_remarks,
		];
		
		$querycheck = 0;
		if(!empty($patient_id)){
			$sqlcheck = "SELECT count(*) as value from clinic_patient WHERE id = '$patient_id'";
			$querycheck = $this->Common_model->get_single_value($sqlcheck);
		}
		if($querycheck > 0)
		{			
			$this->db->where('id', $patient_id);
			$this->db->update('clinic_patient', $case_array);
		} 
		else {			
			$patient_code = $this->generate_patient_id();
			$case_array += [ 'patient_code' => $patient_code ];
			$case_array += [ 'added_by' => $current_user ];
			$case_array += [ 'date_added' => CurrMySqlDate() ];
			$case_array += [ 'date_added_local' => GetLocalTime() ];
			$case_array += [ 'logs' => get_logs() ];
			$patient_id = data_inserter('clinic_patient', $case_array);
		}
		
		if(!empty($patient_id))
		{
		
			// DOCTORS CONSULTANT
			$count_consultant = count($d_date);
			for($i=0; $i<$count_consultant; $i++)
			{
				if(!empty($d_complaint[$i]) && !empty($d_assessment[$i]))
				{
					$data_array = [
						"d_date" 			=> date('Y-m-d', strtotime($d_date[$i])),
						"d_complaint" 		=> $d_complaint[$i],
						"d_assessment" 		=> $d_assessment[$i],
						"d_intervention" 	=> $d_intervention[$i],
					];
						
					if(!empty($d_ref_id[$i]))
					{						
						$this->db->where('d_id', $d_ref_id[$i]);
						$this->db->where('patient_id', $patient_id);
						$this->db->update('clinic_doctor_consult', $data_array);
						
					} else {
						
						$data_array += [ "patient_id" 	=> $patient_id ];
						$data_array += [ "added_by" 	=> $current_user ];
						$data_array += [ 'date_added' => CurrMySqlDate() ];
						$data_array += [ 'date_added_local' => GetLocalTime() ];
						$data_array += [ 'logs' => get_logs() ];				
						data_inserter('clinic_doctor_consult', $data_array);
					}
				}
				
			}
			
			// PHYSICAL EXAMINATION
			$count_physical = count($p_year);
			for($i=0; $i<$count_physical; $i++)
			{
				if(!empty($p_year[$i]) && !empty($p_cbc[$i]))
				{
					$data_array = [
						"p_year" 		=> $p_year[$i],
						"p_cbc" 		=> $p_cbc[$i],
						"p_urinalysis" 	=> $p_urinalysis[$i],
						"p_xray" 		=> $p_xray[$i],
						"p_drugtest" 	=> $p_drugtest[$i],
						"p_physical" 	=> $p_physical[$i],
						"p_clearance" 	=> $p_clearance[$i],
					];
						
					if(!empty($p_ref_id[$i]))
					{						
						$this->db->where('p_id', $p_ref_id[$i]);
						$this->db->where('patient_id', $patient_id);
						$this->db->update('clinic_physical', $data_array);
						
					} else {
						
						$data_array += [ "patient_id" 	=> $patient_id ];
						$data_array += [ "added_by" 	=> $current_user ];
						$data_array += [ 'date_added' => CurrMySqlDate() ];
						$data_array += [ 'date_added_local' => GetLocalTime() ];
						$data_array += [ 'logs' => get_logs() ];				
						data_inserter('clinic_physical', $data_array);
					}
				}
				
			}
			
			// UPDATE LOGS
			$update_remarks = $this->input->post('update_remarks');
			if(empty($update_remarks)){ $update_remarks = "New Patient"; }
			$this->patient_update_logs($patient_id, $update_remarks, $current_user);
		
		}
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
	//--------- PATIENT UPDATE LOGS	
	public function patient_update_logs($patientid, $remarks, $current_user)
	{
		$logs_array = [
		    'patient_id' 	=> $patientid,
			'remarks' 		=> $remarks,
			'added_by' 		=> $current_user,
			'date_added' 	=> CurrMySqlDate(),
			'date_added_local' => GetLocalTime(),
			'logs' 			=> get_logs()
		];
		data_inserter('clinic_logs', $logs_array);		
	}
	
	public function del_patient_consult()
	{		
		$did = $this->input->get('did');
		if(empty($did)){ $did = $this->uri->segment(4); }
		$pid = $this->input->get('pid');
		if(empty($pid)){ $pid = $this->uri->segment(3); }
		
		if(!empty($did) && !empty($pid))
		{
			$this->db->where('patient_id', $pid);
			$this->db->where('d_id', $did);
			$this->db->delete('clinic_doctor_consult');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function del_patient_physical()
	{		
		$did = $this->input->get('did');
		if(empty($did)){ $did = $this->uri->segment(4); }
		$pid = $this->input->get('pid');
		if(empty($pid)){ $pid = $this->uri->segment(3); }
		
		if(!empty($did) && !empty($pid))
		{
			$this->db->where('patient_id', $pid);
			$this->db->where('p_id', $did);
			$this->db->delete('clinic_physical');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function del_patient()
	{	
		$current_user = get_user_id();
		
		$did = $this->input->get('did');
		if(empty($did)){ $did = $this->uri->segment(3); }
		if(!empty($did))
		{
			$sqlcheck = "SELECT * from clinic_patient WHERE id = '$did'";
			$querycheck = $this->Common_model->get_query_row_array($sqlcheck);
			if(!empty($querycheck['id'])){
				$this->db->where('id', $did);
				$this->db->delete('clinic_patient');
				
				$this->db->where('patient_id', $did);
				$this->db->delete('clinic_physical');
				
				$this->db->where('patient_id', $did);
				$this->db->delete('clinic_doctor_consult');
				
				$update_remarks = "DELETED " .$querycheck['patient_code'] ." - " .$querycheck['c_name'] ." (" .$querycheck['c_gender'] .")";
				$this->patient_update_logs($did, $update_remarks, $current_user);
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	
	
	//========================== REPORTS =====================================//
	
	public function patient_report()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$from_date = CurrMySqlDate();
		$to_date = CurrMySqlDate();
		$data['from_date'] = date('Y-m-d',strtotime($from_date));
		$data['to_date'] = date('Y-m-d',strtotime($to_date));
		
		if(!empty($this->input->get('start')))
		{	
			// FILTER DATE CHECK
			$from_date = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$to_date = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";
			$extraFilter .= " AND (c.date_added >= '$from_date' AND c.date_added <= '$to_date') ";
		
			// GET DATA
			$sqlcase = "SELECT c.*, concat(s.fname,' ', s.lname) as added_by_name from clinic_patient as c LEFT JOIN signin as s ON s.id = c.added_by WHERE 1 $extraFilter";
			$crm_list = $this->Common_model->get_query_result_array($sqlcase);
			
			$report_type = $this->input->get('rtype');
			if($report_type == 'excel')
			{
				$this->generate_patient_report_xls($from_date, $to_date, $crm_list);
			}
			if($report_type == 'pdf')
			{
				$excelReport = $this->generate_patient_report_xls($from_date, $to_date, $crm_list, $report_type);
				$this->generate_patient_archieve($crm_list, $excelReport);
			}			
		}
		
		$data["aside_template"] = "clinic_portal/aside.php";
		$data["content_template"] = "clinic_portal/clinic_reports.php";
		
		$reportAside = $this->uri->segment(3);		
		if($reportAside == "view"){ $data["aside_template"] = "reports/aside.php"; }
		
		$this->load->view('dashboard',$data);
	 
	}
	
	//====================== GENERATE ARCHIEVE ===========================//
	
	public function generate_patient_archieve($reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "clinic_patient_archieve"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/clinic_patient_report.xlsx";
		$this->zip->read_file($csvfile, "clinic_patient_report.xlsx");
		
        foreach ($reportArray as $token)
		{
			$patient_id   = $token["patient_code"];
			$fullnameAr  = explode(' ', $token["c_name"]);
			$firstname = !empty($fullnameAr[0]) ? $fullnameAr[0] : "";
			$fileName = FCPATH.'/uploads/clinic_portal/'.$patient_id.'/'.'clinic_patient_' .$patient_id.'.pdf';
			
			$newFileName = "patient_".$patient_id."_".$firstname.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName)){
				$this->zip->read_file($fileName, $newFileName);
			}			
        }
		
        $this->zip->download($zipFileName.'.zip');		
	}
	
	
	///===================== PDF REPORT =================================//
	
	public function generate_patient_report_pdf($pid = '1', $type = 'D')
	{			
		if(check_logged_in()){
				
			$this->load->library('m_pdf');
			
			$patient_id = $pid;
			if(!empty($this->uri->segment(3))){ $patient_id = $this->uri->segment(3); }			
			if(!empty($this->uri->segment(4))){ 
				if($this->uri->segment(4) == 'download'){ $type = 'D'; } 
				if($this->uri->segment(4) == 'view'){ $type = 'I'; }
			}			
			
			// CHECK DB VERIFY		
			if(!empty($patient_id))
			{
				$patient_sql = "SELECT p.*, CONCAT(s.fname, ' ', s.lname) as added_by_name from clinic_patient as p LEFT JOIN signin as s ON s.id = p.added_by WHERE p.id = '$patient_id'";
				$patient_details = $this->Common_model->get_query_row_array($patient_sql);
				if(!empty($patient_details['id']))
				{
					$patient_id = $patient_details['id'];
					
					$medical_sql = "SELECT * from clinic_doctor_consult WHERE patient_id = '$patient_id'";
					$medical_details = $this->Common_model->get_query_result_array($medical_sql);
					
					$physical_sql = "SELECT * from clinic_physical WHERE patient_id = '$patient_id'";
					$physical_details = $this->Common_model->get_query_result_array($physical_sql);
					
					$logs_sql = "SELECT * from clinic_logs WHERE patient_id = '$patient_id'";
					$log_details = $this->Common_model->get_query_result_array($logs_sql);
				}
			}
			
			$data['patient_id'] = $patient_id;
			$data['patient_details'] = $patient_details;
			$data['medical_details'] = $medical_details;
			$data['physical_details'] = $physical_details;
			$data['log_details'] = $log_details;
					
			
			$html=$this->load->view('clinic_portal/clinic_reports_pdf', $data,true);
			
			$finalDir = "clinic_patient_invalid.pdf";
			if(!empty($patient_details['id'])){ $finalDir = "patient_".$patient_details['patient_code'].".pdf"; }
			
			if((!empty($patient_details['id']) && $type == 'F') || $type == 'I' || $type == 'D')
			{
				if($type == 'F')
				{
					$patientID   = $patient_details["patient_code"];
					$pdfFilePath = "clinic_patient_" .$patientID.".pdf";
					$uploadDir = FCPATH.'/uploads/clinic_portal/'.$patientID.'/';
					$finalDir = $uploadDir .$pdfFilePath;
					if (!file_exists($uploadDir)) {
						mkdir($uploadDir, 0777, true);
					}				
				}
				
				$pdf = new m_pdf();
				//$pdf->pdf->AddPage('L');			
				//$pdf->pdf->shrink_tables_to_fit;;			
				$pdf->pdf->WriteHTML($html);			
				$pdf->pdf->Output($finalDir, $type);
			}
		}			
	}
	
	///===================== EXCEL REPORT =================================//
	
	public function generate_patient_report_xls($from_date ='', $to_date='', $crm_list, $type = 'excel')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
				
		$title = "PATIENT RECORDS";
		$sheet_title = "CLINIC - PATIENT RECORDS (" .date('Y-m-d',strtotime($from_date)) ." - " .date('Y-m-d',strtotime($to_date)).")";
		$file_name = "Clinic_Patient_Records_".date('Y-m-d',strtotime($from_date));
				
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:L1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $sheet_title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Patient ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Patient Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Gender");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Birthdate");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Address");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Blood");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Allergies");	
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Medical Condition");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Medical Remarks");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Added By");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date Added");	
		
			
		$i = 1;		
		foreach($crm_list as $wk=>$wv)
		{		
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["patient_code"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv['c_name']);			
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_gender"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_birth"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_address"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_blood"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_allergy"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_medical"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["c_medical_remarks"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["added_by_name"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added"])));
			$i++;
				
			if($type == 'pdf')
			{
				$this->generate_patient_report_pdf($wv["id"], 'F');
			}
			
		}
		
		if($type == 'excel')
		{
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);
			$objWriter->save('php://output');
			exit(); 
		}
		
		if($type == 'pdf')
		{
			$filename = "./assets/reports/clinic_patient_report.xlsx";
			ob_end_clean();
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);	
			$objWriter->save($filename);
			return $filename;
		}
		
	}
	
	
}
	 