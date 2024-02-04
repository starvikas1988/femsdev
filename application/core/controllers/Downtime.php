<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downtime extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){
				
		redirect(base_url()."downtime/ameridial");
	 
	}
	
	///=========================== DOWNTIME AMERIDIAL TRACK ================================///

	
	public function ameridial()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
				
		$data["aside_template"] = "downtime/ameridial_aside.php";
		$data["content_template"] = "downtime/ameridial_form.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function ameridial_list()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		$extraFilter = "";
		$extraOffice = "";
		$ticket_no = "";
		$extraLimit = "LIMIT 500";
		$start_time = "00:00:00";
		$end_time = "23:59:59";
		
		// FILTER DATE CHECK 
		$month_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
		$from_date = date('Y-m-01', strtotime('-1 month', strtotime(CurrMySqlDate())));
		$to_date = date('Y-m-' .$month_days);
		
		if(!empty($this->input->get('search_from_date')))
		{ 
			$from_date = date('Y-m-d',strtotime($this->input->get('search_from_date')));
			$to_date = date('Y-m-d',strtotime($this->input->get('search_to_date')));
			$from_date_full = $from_date ." ". $start_time;
			$to_date_full = $to_date ." ". $end_time;
			$extraFilter .= " AND (c.issue_date >= '$from_date' AND c.issue_date <= '$to_date') ";			
			$extraLimit = "";
		}	
		
		// FILTER TICKET
		if(!empty($this->input->get('search_ticket_id')))
		{ 
			$ticket_no = $this->input->get('search_ticket_id');
			$extraFilter .= " AND c.ticket_no = '$ticket_no' ";
		}
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['ticket_no'] = $ticket_no;
		
		if(is_access_downtime_tracker_reports())
		{
			if($this->office_wise_downtime_access())
			{ 
				$extraOffice = " AND s.office_id = '$user_office_id'";				
			}			
		}
		
		//if(get_role_dir() == 'agent'){  $extraFilter .= " AND c.agent_id = '$current_user' "; }
		
		if($this->global_downtime_access())
		{
			$extraOffice = "";	
		}
		
		if($this->check_all_downtime_access())
		{
			$access_office_ids = $this->check_all_downtime_access('office');
			$access_office = implode("','", $access_office_ids);			
			$extraOffice = " AND s.office_id IN ('$access_office')";
		}
		
		
		$list_sql = "SELECT c.*, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, CONCAT(sl.fname, ' ', sl.lname) as approved_by_name from ameridial_downtime_tracker as c 
		               LEFT JOIN signin as s ON c.agent_id = s.id
					   LEFT JOIN signin as sl ON c.approved_by = sl.id
					   WHERE 1 $extraFilter $extraOffice 
					   ORDER by date_added DESC $extraLimit";		
		$data['ameridialList'] = $this->Common_model->get_query_result_array($list_sql);
		
		$data['approvalAccess'] = false;
		if($this->downtime_approval_access() || $this->check_all_downtime_access()){
			$data['approvalAccess'] = true;
		}
		$data["aside_template"] = "downtime/ameridial_aside.php";
		$data["content_template"] = "downtime/ameridial_list.php";
		$data["content_js"] = "downtime/downtime_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function my_ameridial_list()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		$extraFilter = "";
		$extraOffice = "";
		$ticket_no = "";
		$extraLimit = "LIMIT 500";
		$start_time = "00:00:00";
		$end_time = "23:59:59";
		
		// FILTER DATE CHECK 
		$month_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
		$from_date = date('Y-m-01', strtotime('-1 month', strtotime(CurrMySqlDate())));
		$to_date = date('Y-m-' .$month_days);
		
		if(!empty($this->input->get('search_from_date')))
		{ 
			$from_date = date('Y-m-d',strtotime($this->input->get('search_from_date')));
			$to_date = date('Y-m-d',strtotime($this->input->get('search_to_date')));
			$from_date_full = $from_date ." ". $start_time;
			$to_date_full = $to_date ." ". $end_time;
			$extraFilter .= " AND (c.issue_date >= '$from_date' AND c.issue_date <= '$to_date') ";			
			$extraLimit = "";
		}	
		
		// FILTER TICKET
		if(!empty($this->input->get('search_ticket_id')))
		{ 
			$ticket_no = $this->input->get('search_ticket_id');
			$extraFilter .= " AND c.ticket_no = '$ticket_no' ";
		}
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['ticket_no'] = $ticket_no;
				
		if(is_access_downtime_tracker_reports() || $this->check_all_downtime_access() || $this->global_downtime_access() || $this->office_wise_downtime_access())
		{
			if($this->office_wise_downtime_access())
			{ 
				$extraOffice = " AND s.office_id = '$user_office_id'";				
			}
			
			if($this->global_downtime_access())
			{
				$extraOffice = "";	
			}

			if($this->check_all_downtime_access())
			{
				$access_office_ids = $this->check_all_downtime_access('office');
				$access_office = implode("','", $access_office_ids);			
				$extraOffice = " AND s.office_id IN ('$access_office')";
			}
			
		} else {
			
			if(get_role_dir() == 'agent'){  $extraFilter .= " AND s.id = '$current_user' "; }
			if(get_role_dir() != 'agent'){  $extraFilter .= " AND (s.assigned_to = '$current_user' OR s.id = '$current_user') "; }
		}
		
		$list_sql = "SELECT c.*, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, CONCAT(sl.fname, ' ', sl.lname) as approved_by_name from ameridial_downtime_tracker as c 
		               LEFT JOIN signin as s ON c.agent_id = s.id
					   LEFT JOIN signin as sl ON c.approved_by = sl.id
					   WHERE 1 $extraFilter $extraOffice
					   ORDER by date_added DESC $extraLimit";
		$data['ameridialList'] = $this->Common_model->get_query_result_array($list_sql);
		
		$data['approvalAccess'] = false;
		if($this->downtime_approval_access() || $this->check_all_downtime_access()){
			$data['approvalAccess'] = true;
		}
		
		$data["aside_template"] = "downtime/ameridial_aside.php";
		$data["content_template"] = "downtime/my_ameridial_list.php";
		$data["content_js"] = "downtime/downtime_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function my_ameridial_list_edit($id = null)
	{
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();

		$currentdate = CurrMySqlDate();
        $sql = "SELECT id,issue_date, issue_time,ticket_no,issue,remarks FROM ameridial_downtime_tracker WHERE id = $id";
        $data['ameridialData'] = $this->Common_model->get_query_row_array($sql);

        $agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
		
		$data["aside_template"] = "downtime/ameridial_aside.php";
		$data["content_template"] = "downtime/ameridial_form.php";
		$data["content_js"] = "downtime/downtime_js.php";

		$this->load->view('dashboard',$data);

	}
	
	
	public function my_ameridial_list_approve($id = null)
	{
		 
		$current_user = get_user_id();
		$currentdate = CurrMySqlDate();

		$sql = "UPDATE ameridial_downtime_tracker SET approved_by = $current_user, approved_date = '$currentdate' WHERE id = $id ";		
		$this->db->query($sql);
		$this->load->helper('url');

		redirect('Downtime/my_ameridial_list');

	}
	
	public function submit_ameridial_form()
	{
		$current_user = get_user_id();
		$id = $this->input->post('id')?$this->input->post('id'):'';
		if(!empty($id)){

			$issue_date = $this->input->post('issue_date');
			$issue_time = $this->input->post('issue_time');
			$ticket_no = $this->input->post('ticket_no');
			$issue = $this->input->post('issue');
			$remarks = $this->input->post('remarks');

			$data = [ "issue_date" => $issue_date, "issue_time" => $issue_time, "ticket_no"=> $ticket_no,"issue"=>$issue,"remarks"=>$remarks];
			$this->db->where('id', $id);
			$this->db->update('ameridial_downtime_tracker', $data);

			$this->load->helper('url');

			redirect('Downtime/my_ameridial_list');
		}else
		{
			$data_array = [
				'agent_id' => $this->input->post('agent_uid'),
				'issue_date' => $this->input->post('issue_date'),
				'issue_time' => $this->input->post('issue_time'),
				'ticket_no' => $this->input->post('ticket_no'),
				'issue' => $this->input->post('issue'),
				'remarks' => $this->input->post('remarks'),
				'date_added' => CurrMySqlDate(),
				'date_added_local' => GetLocalTime(),
				'added_by' => $current_user,
				'logs' => get_logs()
			];
			
			data_inserter('ameridial_downtime_tracker', $data_array);
			redirect(base_url()."downtime/ameridial");
	    }
	
	}
	
	public function ameridial_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['showAll'] = false;
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);			
			if($this->global_downtime_access())
			{
				$data['showAll'] = true;
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}
			if($this->check_all_downtime_access())
			{
				$access_office_ids = $this->check_all_downtime_access('office');
				$extra_access_office = implode("','", $access_office_ids);
				$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
				$query = $this->db->query($sql_office);
				$data['location_list'] = $query->result_array();
			}
		}		
		
		$data["aside_template"] = "downtime/ameridial_aside.php";
		$data["content_template"] = "downtime/ameridial_reports.php";
		
		if($this->input->post('excel_office_id')){
			$data['OfficeSelected'] = $officeSelection = $this->input->post('excel_office_id');
			$this->generate_ameridial_report_xls($officeSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function generate_ameridial_report_xls($officeq)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		
		$get_office_id = $officeq;
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND s.office_id = '$get_office_id' ";
		}
		
		$extraFilter = "";
		 
		if(is_access_downtime_tracker_reports() || $this->check_all_downtime_access() || $this->global_downtime_access())
		{
			if($this->office_wise_downtime_access())
			{ 
				$extraOffice = " AND s.office_id = '$user_office_id'";				
			}
			
			if($this->global_downtime_access())
			{
				$extraOffice = "";	
			}

			if($this->check_all_downtime_access())
			{
				$access_office_ids = $this->check_all_downtime_access('office');
				$access_office = implode("','", $access_office_ids);			
				$extraOffice = " AND s.office_id IN ('$access_office')";
			}			
		} else {		
			if(get_role_dir() == 'agent'){  $extraFilter .= " AND s.id = '$current_user' "; }
			//if(get_role_dir() != 'agent'){  $extraFilter .= " AND (s.assigned_to = '$current_user' OR s.id = '$current_user') "; }
		}
				
		$reports_sql = "SELECT s.fusion_id,  CONCAT(ms.fname, ' ', ms.lname) as approver,CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*
							  from ameridial_downtime_tracker as f
				              LEFT JOIN signin as s ON f.added_by = s.id
				              LEFT JOIN signin as ms ON f.approved_by = ms.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
				              WHERE 1 $extraoffice $extraFilter ORDER by date_added DESC";
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Ameridial Downtime Tracker');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Issue Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Issue Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Ticket No");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Issue");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Detail the Issue please, including how you handled this");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Approved By");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Approved On");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "AMERIDIAL DOWNTIME REPORTS");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];
			// $approver = $wv['approved_by'];
			// $query = "SELECT CONCAT(s.fname, ' ', s.lname) as fullname FROM ameridial_downtime_tracker as f
			// 	      LEFT JOIN signin as s ON f.approved_by = s.id";
		 //    $approver = $this->Common_model->get_query_row_array($query);
			// var_dump($approver);
			// exit;
			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["issue_date"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('h:i A', strtotime($wv["issue_time"])));
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["ticket_no"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["issue"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["remarks"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["approver"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["approved_date"]);		
			
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Ameridial_Downtime_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	//==============================================================================
	//  OFFICE WISE MANAGER LEVEL ACCESS
	//==============================================================================
	
	  public function check_all_downtime_access($type = 'access')
	   {
		   $ses_fusion_id = get_user_fusion_id();
		   $result_access = false;
		   if($this->only_manager_Els())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->only_manager_Els('office'); }
		   }
		   if($this->only_manager_HigSpin())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->only_manager_HigSpin('office'); }
		   }
		   if($this->only_supervisor_MinSpinUtahHigbee())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->only_supervisor_MinSpinUtahHigbee('office'); }
		   }
		   if($this->only_manager_MinSpinUtahHigbeeEls())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->only_manager_MinSpinUtahHigbeeEls('office'); }
		   }
		   return $result_access;
	   }
	   
	   public function only_supervisor_MinSpinUtahHigbee($type = 'access')
	   {
		   $access_ids = "FSPI000019,FSPI000026,FSPI000020,FSPI000009,FSPI000047,FSPI000029,FHIG000425,FHIG000007,FSPI000166,FSPI000158,FHIG000422,FSPI000109,FHIG000365,FHIG000027,FHIG000041,FHIG000047,FHIG000308,FHIG000051,FHIG000103,FHIG000025,FHIG000239,FHIG000165,FHIG000173,FHIG000211,FHIG000202,FHIG000155,FHIG000195,FSPI000086,FSPI000010,FSPI000103,FSPI000117,FSPI000108,FSPI000116,FSPI000110,FSPI000158,FSPI000087,FSPI000321,FSPI000255,FUTA000007,FHIG000319,FHIG000323,FHIG000139";		  
		   $office_access = "SPI,MIN,UTA,HIG";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   
	   public function only_manager_MinSpinUtahHigbeeEls($type = 'access')
	   {
		   $access_ids = "FHIG000142,FHIG000303,FHIG000302,FHIG000160";		  
		   $office_access = "SPI,MIN,UTA,HIG,ELS";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   public function only_manager_HigSpin($type = 'access')
	   {
		   $access_ids = "FHIG000001,FHIG000013,FHIG000006,FSPI000001,FSPI000003,FSPI000002,FSPI000105";		  
		   $office_access = "HIG,SPI";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   public function only_manager_Els($type = 'access')
	   {
		   $access_ids = "FELS003398,FELS004299,FELS003519";		  
		   $office_access = "ELS";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   
	   
	  //==== PREVIOUS OFFICE WISE DOWNTIME ==========//
	  
	  public function office_wise_downtime_access()
	  {
		   $ses_fusion_id = get_user_fusion_id();
		   $result_access = false;
		   $access_ids = "FHIG000013,FHIG000170,FHIG000309,FSPI000105,FSPI000022,FUTA000001,FMIN000011";		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   if(in_array($ses_fusion_id, $access_array))
		   { 
			 $result_access = true;
		   }
		   return $result_access;	   
	  }
	  
	  
	  //==== PREVIOUS GLOBAL DOWNTIME ==========//
	  public function global_downtime_access()
	  {
		  $ses_fusion_id = get_user_fusion_id();		  
		  $access_ids = "FHIG000302,FHIG000314,FHIG000142,FHIG000301,FKOL001754,FKOL004711,FKOL000077,FELS004872,FELS004873,FELS004874,FELS004875,FELS004876,FHIG000295,FHIG000210,FMIN000049,FSPI000005,FSPI000006,FSPI000004,FHIG000189,FKOL006793";		  
		  $access_array = explode(',', $access_ids);		   
		  $result_access = false;
		  if(in_array($ses_fusion_id, $access_array))
		  { 
			$result_access = true;
		  }
		  
		  return $result_access;
	   }
	  
	//=========== APPROVAL ACCESS ===================//  
	  public function downtime_approval_access()
	  {
		  $ses_fusion_id = get_user_fusion_id();		  
		  $access_ids = "FSPI000086,FMIN000011";		  
		  $access_array = explode(',', $access_ids);		   
		  $result_access = false;
		  if(in_array($ses_fusion_id, $access_array))
		  { 
			$result_access = true;
		  }
		  
		  return $result_access;
	   }
	   
	   
	   

}