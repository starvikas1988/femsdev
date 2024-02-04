<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pip extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();
	}
	
	
	
//==========================================================================================
///=========================== PIP  ================================///

    public function index(){		 		
		redirect(base_url()."pip/pipList");	 
	}
	 
	
	//--------- CRM FORM ID
	
	public function generate_pip_id()
	{
		$sql = "SELECT count(*) as value from employee_pip ORDER by id DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_crm_id = "PIP" .mt_rand(11,99) .sprintf('%06d', $lastid + 1);
		return $new_crm_id;
	}
	
	
	public function plan()
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
		
		// ASSSIGN EMPLOYEE
		$extraFilter = " AND s.assigned_to = '$current_user'";
		if(get_global_access() == 1 || get_site_admin() == 1)
		{
			$extraFilter = "";
		}
		
		// OFFICE SELECTION
		if($is_global_access==1){
			$data['officeList'] = $this->Common_model->get_office_location_list();
		} else {
			$data['officeList'] = $this->Common_model->get_office_location_session_all($current_user);
		}
				
		// GET EMPLOYEE LIST
		$sqlEmployee = "SELECT s.*, CONCAT(s.fname, ' ', s.lname) as full_name, r.name as designation, d.description as department 
		                from signin as s
		                LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN department as d ON d.id = s.dept_id
						WHERE s.status IN (1,4) AND r.folder = 'agent' AND s.office_id = '$user_office_id' $extraFilter ORDER by s.fname";
		$queryEmployee = $this->Common_model->get_query_result_array($sqlEmployee);
		$data['employeeList'] = $queryEmployee;
		
		
		// SELECTION DATA
		$data['officeSelected'] = $user_office_id;
		$data['userSelected'] = $current_user;
		
		
		$data["aside_template"] = "pip/aside.php";
		$data["content_template"] = "pip/pip_selection.php";				
		$data["content_js"] = "pip/pip_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function entry()
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
		
		// FILTER DATA
		$employeeID = "";
		if(!empty($this->input->get('userSelection')))
		{
			$employeeID = $this->input->get('userSelection');
		}
		if(empty($employeeID))
		{
			redirect(base_url('pip/plan'));
		}
		
		
		// GET EMPLOYEE LIST
		$sqlEmployee = "SELECT s.*, CONCAT(s.fname, ' ', s.lname) as full_name, r.name as designation, d.description as department,
						CONCAT(tl.fname, ' ', tl.lname) as tlName, CONCAT(m.fname, ' ', m.lname) as managerName,
						tl.id as tl_id, m.id as manager_id, get_process_names(s.id) as process_names		
		                from signin as s
		                LEFT JOIN signin as tl ON tl.id = s.assigned_to
						LEFT JOIN signin as m ON m.id = tl.assigned_to
		                LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN department as d ON d.id = s.dept_id
						WHERE s.fusion_id = '$employeeID'";
		$infoEmployee = $this->Common_model->get_query_row_array($sqlEmployee);
		
		// INITIALIZE DATA
		$data['currentDate'] = CurrDate();
		$data['pipID'] = $this->generate_pip_id();
		$data['employeeID'] = $employeeID;
		$data['employeeInfo'] = $infoEmployee;
		
		$data["aside_template"] = "pip/aside.php";
		$data["content_template"] = "pip/pip_form.php";				
		$data["content_js"] = "pip/pip_js.php";				
		
		$this->load->view('dashboard',$data);
	}
		
	
	public function pipList()
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
		
		$extraStatusFilter = "";
		$listType = $this->uri->segment(3);
		if($listType == 'pending'){ $extraStatusFilter = " AND p.status IN ('P')"; }
		if($listType == 'rejected'){ $extraStatusFilter = " AND p.status IN ('R')"; }
		if($listType == 'employee'){ $extraStatusFilter = " AND p.status IN ('A')"; }
		if($listType == 'followup'){ $extraStatusFilter = " AND p.status IN ('C','E')"; }
		if($listType == 'hr'){ $extraStatusFilter = " AND p.status IN ('F')"; }
		if($listType == 'closed'){ $extraStatusFilter = " AND p.status IN ('S', 'X')"; }
		
		$data['pipStatus'] = $pipStatus = $this->pip_status();
		
		// ASSSIGN EMPLOYEE
		$extraFilter = " AND s.id = '$current_user'";
		if(get_role_dir() == 'agent')
		{
			$extraFilter = " AND s.id = '$current_user'";
		}
		if(get_role_dir() != 'agent')
		{
			$extraFilter = " AND s.assigned_to = '$current_user'";	
		}
		if(get_global_access() == 1 || get_site_admin() == 1 || get_dept_folder() == "hr")
		{
			$extraFilter = "";
		}
		
		
		// OFFICE SELECTION
		if($is_global_access==1){
			$data['officeList'] = $this->Common_model->get_office_location_list();
		} else {
			$data['officeList'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		// OFFICE FILTER
		$select_office = $this->input->get('select_office');
		if($select_office=="") $select_office = $user_office_id;
		if($select_office!="" && $select_office != "ALL")
		{
			$extraFilter .= " AND s.office_id = '$select_office'";
		}
		
		// GET PIP LIST
		$sqlPip = "SELECT p.*, s.office_id, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as employee_name, CONCAT(l.fname, ' ', l.lname) as tl_name, 
		                r.name as designation, d.description as department 
						from employee_pip as p
						INNER JOIN signin as s ON s.id = p.employee_id
						INNER JOIN signin as l ON l.id = p.is_accept_tl_by						
		                LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN department as d ON d.id = s.dept_id
						WHERE 1 $extraFilter $extraStatusFilter";
		$queryPip = $this->Common_model->get_query_result_array($sqlPip);
		$data['pipList'] = $queryPip;
		
		
		// SELECTION DATA
		$data['officeSelected'] = $select_office;
		$data['userSelected'] = $current_user;
		
		
		$data["aside_template"] = "pip/aside.php";
		$data["content_template"] = "pip/pip_list.php";				
		$data["content_js"] = "pip/pip_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function view_pip()
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
		
		$data['currentDate'] = CurrDate();
		$pipID = $this->input->post('pip');
		$hrApproval = $this->input->post('hr');
		$employeeAccept = $this->input->post('employee');
		
		// HR ACCEPT MODAL
		$data['hrAccept'] = 0;
		if($hrApproval == 1)
		{
			$data['hrAccept'] = 1;
		}
		
		// EMPLOYEE ACCEPT MODAL
		$data['employeeAccept'] = 0;
		if($employeeAccept == 1)
		{
			$data['employeeAccept'] = 1;
		}
		
		if(empty($pipID)){
			$pipID = $this->uri->segment(3);
		}
		// GET PIP LIST
		$sqlPip = "SELECT p.*, s.office_id, s.pic_ext, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as employee_name, CONCAT(l.fname, ' ', l.lname) as tl_name, 
		               CONCAT(m.fname, ' ', m.lname) as manager_name, l.id as tl_id, m.id as manager_id,
		                r.name as designation, d.description as department, get_process_names(s.id) as process_names 
						from employee_pip as p
						INNER JOIN signin as s ON s.id = p.employee_id
						INNER JOIN signin as l ON l.id = p.is_accept_tl_by
						LEFT JOIN signin as m ON m.id = l.assigned_to
		                LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN department as d ON d.id = s.dept_id
						WHERE p.pip_ref = '$pipID' OR p.id = '$pipID'";
		$queryPip = $this->Common_model->get_query_row_array($sqlPip);
		$data['pipDetails'] = $queryPip;
		
		$pip_id = $queryPip['id'];
		$sqlPipInfo = "SELECT p.* from employee_pip_followup as p WHERE p.pip_id = '$pip_id'";
		$queryPipInfo = $this->Common_model->get_query_result_array($sqlPipInfo);
		$data['pipInfo'] = $queryPipInfo;
		
		
		// SELECTION DATA
		$data['officeSelected'] = $user_office_id;
		$data['userSelected'] = $current_user;
			
		$data["aside_template"] = "pip/aside.php";
		$data["content_template"] = "pip/pip_view.php";				
		$data["content_js"] = "pip/pip_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function pipDetailsView()
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
		
		$data['currentDate'] = CurrDate();
		$pipID = $this->input->post('pip');
		$hrApproval = $this->input->post('hr');
		$employeeAccept = $this->input->post('employee');
		
		// HR ACCEPT MODAL
		$data['hrAccept'] = 0;
		if($hrApproval == 1)
		{
			$data['hrAccept'] = 1;
		}
		
		// EMPLOYEE ACCEPT MODAL
		$data['employeeAccept'] = 0;
		if($employeeAccept == 1)
		{
			$data['employeeAccept'] = 1;
		}
		
		if(empty($pipID)){
			$pipID = $this->uri->segment(3);
		}
		// GET PIP LIST
		$sqlPip = "SELECT p.*, s.office_id, s.pic_ext, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as employee_name, CONCAT(l.fname, ' ', l.lname) as tl_name, 
		               CONCAT(m.fname, ' ', m.lname) as manager_name, l.id as tl_id, m.id as manager_id,
		                r.name as designation, d.description as department, get_process_names(s.id) as process_names 
						from employee_pip as p
						INNER JOIN signin as s ON s.id = p.employee_id
						INNER JOIN signin as l ON l.id = p.is_accept_tl_by
						LEFT JOIN signin as m ON m.id = l.assigned_to
		                LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN department as d ON d.id = s.dept_id
						WHERE p.pip_ref = '$pipID' OR p.id = '$pipID'";
		$queryPip = $this->Common_model->get_query_row_array($sqlPip);
		$data['pipDetails'] = $queryPip;
		
		$pip_id = $queryPip['id'];
		$sqlPipInfo = "SELECT p.* from employee_pip_followup as p WHERE p.pip_id = '$pip_id'";
		$queryPipInfo = $this->Common_model->get_query_result_array($sqlPipInfo);
		$data['pipInfo'] = $queryPipInfo;
		
		
		// SELECTION DATA
		$data['officeSelected'] = $user_office_id;
		$data['userSelected'] = $current_user;
			
		$this->load->view('pip/pip_details', $data);
	}
	
	
	
	
	public function submit_pip_form()
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
		
		// PROCESS PIP LIST
		$form_pip_id = $this->input->post('pip_id');
		$form_employee_id = $this->input->post('employee_id');
		$form_tl_id = $this->input->post('tl_id');
		$form_pip_date = $this->input->post('pip_date');
		$form_area_absence = $this->input->post('area_absence');
		$form_area_tardiness = $this->input->post('area_tardiness');
		$form_area_work = $this->input->post('area_work');
		$form_area_service = $this->input->post('area_service');
		$form_area_behaviour = $this->input->post('area_behaviour');
		$form_area_policy = $this->input->post('area_policy');
		$form_area_others = $this->input->post('area_others');
		$form_area_kpi = $this->input->post('area_kpi');
		$form_area_kpi_others = $this->input->post('area_kpi_others');
		$form_addition_issues = $this->input->post('addition_issues');
		$form_addition_expectation = $this->input->post('addition_expectation');
		$form_addition_observation = $this->input->post('addition_observation');
		$form_is_acknoweldge_tl = $this->input->post('is_acknoweldge_tl');
		
		$form_area_absence = !empty($form_area_absence) ? $form_area_absence : 0;
		$form_area_tardiness = !empty($form_area_tardiness) ? $form_area_tardiness : 0;
		$form_area_work = !empty($form_area_work) ? $form_area_work : 0;
		$form_area_service = !empty($form_area_service) ? $form_area_service : 0;
		$form_area_behaviour = !empty($form_area_behaviour) ? $form_area_behaviour : 0;
		$form_area_policy = !empty($form_area_policy) ? $form_area_policy : 0;
		$form_area_others = !empty($form_area_others) ? $form_area_others : 0;
		$form_area_kpi = implode(',', $form_area_kpi);
		
		$form_w_selection = $this->input->post('w_selection');
		$form_w_week = $this->input->post('w_week');
		$form_w_date = $this->input->post('w_date');
		$form_w_goal = $this->input->post('w_goal');
		
		$pipArray = array(
			"pip_ref" => $form_pip_id,
			"employee_id" => $form_employee_id,
			"pip_date" => $form_pip_date,
			"area_absence" => $form_area_absence,
			"area_tardiness" => $form_area_tardiness,
			"area_work" => $form_area_work,
			"area_service" => $form_area_service,
			"area_behaviour" => $form_area_behaviour,
			"area_policy" => $form_area_policy,
			"area_others" => $form_area_others,
			"area_kpi" => $form_area_kpi,
			"area_kpi_others" => $form_area_kpi_others,
			"addition_issues" => $form_addition_issues,
			"addition_expectation" => $form_addition_expectation,
			"addition_observation" => $form_addition_observation,
			"area_others" => $form_area_kpi_others,
			"is_accept_tl" => $form_is_acknoweldge_tl,
			"is_accept_tl_by" => $form_tl_id,
			"is_accept_tl_date" => CurrMySqldate(),
			"status" => 'P',
			"added_by" => $current_user,
			"date_added" => CurrMySqldate(),
			'date_modified' => CurrMySqldate(),
			"logs" => get_logs()
		);
		$pip_id = data_inserter('employee_pip', $pipArray);
		
		$totalWeeks = count($form_w_week);
		for($i=0; $i<$totalWeeks; $i++)
		{
			$pipWeekArray = array(
				"pip_id" => $pip_id,
				"week_no" => $form_w_week[$i],
				"week_date" => $form_w_date[$i],
				"week_goal" => $form_w_goal[$i],
				"week_status" => 'P',
				"added_by" => $current_user,
				"date_added" => CurrMySqldate(),
				"logs" => get_logs()
			);
			data_inserter('employee_pip_followup', $pipWeekArray);
		}
		
		redirect('pip/plan');
	}
	
	public function submitHRAccept()
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
		
		$pipID = $this->input->post('pip_id');
		$hr_accept = $this->input->post('hr_accept');
		
		$uStatus = "R"; $uAccept = 'N'; 
		if($hr_accept == '1'){ $uStatus = "A"; $uAccept = 'Y'; }
		
		$data = [ 
			'status' => $uStatus,
            'is_accept_hr' => $uAccept,
			'is_accept_hr_by' => $current_user,
			'is_accept_hr_date' => CurrMySqldate(),
			'date_modified' => CurrMySqldate()
		];
		
		$this->db->where('id', $pipID);
		$this->db->update('employee_pip', $data);
				
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function submitEmployeeAccept()
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
		
		$pipID = $this->input->post('pip_id');
		
		$data = [ 
			'status' => 'C',
            'is_accept_employee' => '1',
			'is_accept_employee_date' => CurrMySqldate(),
			'date_modified' => CurrMySqldate()
		];
		
		$this->db->where('id', $pipID);
		$this->db->update('employee_pip', $data);
				
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function submitFollowUpWeek()
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
		
		$pip_id = $this->input->post('pip_id');
		$pip_ref = $this->input->post('pip_ref');
		$week_id = $this->input->post('week_id');
		$week_result = $this->input->post('week_result');		
		$week_remarks = $this->input->post('week_remarks');
		$pip_file = $_FILES['pip_file']['name'];
		
		if(!empty($pip_file))
		{
			// UPLOAD FILES
			$uploadDir = FCPATH .'/uploads/pip/' .$pip_ref.'/';
			if(!is_dir($uploadDir)){
				mkdir($uploadDir, 0777, true);
			}
			$config['upload_path']          = $uploadDir;
			$config['allowed_types']        = 'jpg|png|jpeg|docx|doc|xls|xlsx|pdf';
			$config['max_size']             = 1024000;

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('pip_file'))
			{
				redirect($_SERVER['HTTP_REFERER'] ."/error");
			} else {
				 $dataFile = $this->upload->data();
				 $fileName = $dataFile['file_name'];
			}
		}
		
		$data = [ 
			'week_result' => $week_result,
            'week_remarks' => $week_remarks,
            'week_status' => 'A',
            'is_followup' => 1,
            'followup_date' => CurrMySqldate(),
            'followup_by' => $current_user,
			'date_modified' => CurrMySqldate()
		];
		if(!empty($fileName))
		{
			$data += [ 'week_attachment' => $fileName ];			
		}
		
		$this->db->where('id', $week_id);
		$this->db->where('pip_id', $pip_id);
		$this->db->update('employee_pip_followup', $data);
				
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function submitWeekFollowup()
	{
		$form_pip_id = $this->input->post('followup_pip_id');
		$dataPIP = [ 
			'status' => 'F',
			"date_modified" => CurrMySqldate(),
		];
		$this->db->where('id', $form_pip_id);
		$this->db->update('employee_pip', $dataPIP);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
		
	public function submitWeekExtend()
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
		
		// PROCESS PIP LIST
		$form_pip_id = $this->input->post('w_extend_pip');		
		$form_w_selection = $this->input->post('w_selection');
		$form_w_week = $this->input->post('w_week');
		$form_w_date = $this->input->post('w_date');
		$form_w_goal = $this->input->post('w_goal');
		
		$totalWeeks = count($form_w_week);
		for($i=0; $i<$totalWeeks; $i++)
		{
			$pipWeekArray = array(
				"pip_id" => $form_pip_id,
				"week_no" => $form_w_week[$i],
				"week_date" => $form_w_date[$i],
				"week_goal" => $form_w_goal[$i],
				"week_status" => 'P',
				"week_type" => 2,
				"added_by" => $current_user,
				"date_modified" => CurrMySqldate(),
				"date_added" => CurrMySqldate(),
				"logs" => get_logs()
			);
			data_inserter('employee_pip_followup', $pipWeekArray);
		}
		
		$dataPIP = [ 
			'is_extended' => 1,
			'status' => 'E',
			"date_modified" => CurrMySqldate(),
		];
		$this->db->where('id', $form_pip_id);
		$this->db->update('employee_pip', $dataPIP);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function submitClosePIP()
	{
		$current_user   = get_user_id();
		$hr_pip_id = $this->input->post('hr_pip_id');
		$hr_final_remarks = $this->input->post('hr_final_remarks');
		$dataPIP = [ 
		    'is_approval_hr' => 1,
		    'is_approval_hr_by' => $current_user,
		    'is_approval_hr_date' => CurrMySqldate(),
		    'is_approval_hr_remarks' => $hr_final_remarks,
			'status' => 'S',
			"date_modified" => CurrMySqldate(),
		];
		$this->db->where('id', $hr_pip_id);
		$this->db->update('employee_pip', $dataPIP);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function submitTerminatePIP()
	{
		$hr_pip_id = $this->input->post('hr_pip_id');
		$hr_final_remarks = $this->input->post('hr_final_remarks');
		$dataPIP = [ 
			'is_approval_hr' => 1,
		    'is_approval_hr_by' => $current_user,
		    'is_approval_hr_date' => CurrMySqldate(),
		    'is_approval_hr_remarks' => $hr_final_remarks,
			'status' => 'X',
			"date_modified" => CurrMySqldate(),
		];
		$this->db->where('id', $hr_pip_id);
		$this->db->update('employee_pip', $dataPIP);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function pip_status()
	{
		$statusArray = array(
			"P" => 'Pending',
			"R" => 'Rejected',
			"A" => 'Approved',
			"C" => 'Accepted by Employee',
			"F" => 'In Followup',
			"E" => 'Extended by HR',
			"S" => 'Closed Successfully',
			"X" => 'Closed Unsuccessfully',
		);
		return $statusArray;
	}
	
	
	
//=============== AJAX FILTERS & APPENDS ========================================================//	
	
	//  WEEK DROPDOWN DIV
	public function ajax_week_dropdown()
	{
		$option = $this->input->get('ops');
		$currentDate = CurrDate();
		$dataRow = '<div class="row bRow"><div class="col-md-4">Week</div><div class="col-md-4">Date</div><div class="col-md-4">Goal/Target</div></div>';
		for($i=1; $i<= $option; $i++)
		{
			$dataRow .= '<div class="row text-center bCol">
				<div class="col-md-4">Week ' .$i .'</div>
				<div class="col-md-4">'.$currentDate.'</div>
				<div class="col-md-4">
				<input type="hidden" name="w_week[]" value="'.$i.'" required>
				<input type="hidden" name="w_date[]" value="'.$currentDate.'" required>
				<input type="number" style="width:60%;margin: 0 auto;" min="0" class="form-control" name="w_goal[]" required>
				</div>
			</div>';
			$currentDate = date('Y-m-d', strtotime('+7 day', strtotime($currentDate)));
		}
		echo $dataRow;		
	}
	
	public function ajax_week_extend_dropdown()
	{
		$option = $this->input->get('ops');
		$pipid = $this->input->get('pipid');
		$sqlLast = "SELECT * from employee_pip_followup WHERE pip_id = '$pipid' ORDER by id DESC LIMIT 1";
		$lastData = $this->Common_model->get_query_row_array($sqlLast);
		
		$weekDate = $lastData['week_date'];
		$weekNo = $lastData['week_no'];
		
		$currentDate = $weekDate;
		$dataRow = '<div class="row bRow"><div class="col-md-4">Week</div><div class="col-md-4">Date</div><div class="col-md-4">Goal/Target</div></div>';
		for($i=1; $i<= $option; $i++)
		{
			$currentWeek = $weekNo + $i;
			$currentDate = date('Y-m-d', strtotime('+7 day', strtotime($currentDate)));
			$dataRow .= '<div class="row text-center bCol">
				<div class="col-md-4">Week ' .$currentWeek .'</div>
				<div class="col-md-4">'.$currentDate.'</div>
				<div class="col-md-4">
				<input type="hidden" name="w_week[]" value="'.$currentWeek.'" required>
				<input type="hidden" name="w_date[]" value="'.$currentDate.'" required>
				<input type="number" style="width:60%;margin: 0 auto;" min="0" class="form-control" name="w_goal[]">
				</div>
			</div>';			
		}
		echo $dataRow;		
	}
	
	
	// FILTER USER SELECTIONS
	public function filter_office_user()
	{
		$office_id = $this->input->get('oid');		
		$currentUser = get_user_id();
		
		$extraTLCut = " AND s.id IN ($currentUser)";
		if(get_role_dir() == 'tl' || get_role_dir() == 'agent')
		{	
			$extraTLCut = " AND s.id IN ($currentUser)"; 
		}
		if(get_global_access() == 1 || get_site_admin() == 1)
		{
			$extraTLCut = "";
		}
		
		$sqlUsers = "SELECT s.*, CONCAT(s.fname, ' ', s.lname) as full_name, r.name as designation, d.description as department 
		                from signin as s
		                LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN department as d ON d.id = s.dept_id
						WHERE s.status IN (1,4)  AND r.folder = 'agent' AND s.office_id = '$office_id' $extraTLCut ORDER by s.fname";
		$queryUsers = $this->Common_model->get_query_result_array($sqlUsers);
		echo json_encode($queryUsers);
	}
	
}