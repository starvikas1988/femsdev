<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    private $aside = "reports/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Dfr_model');
		$this->reports_model->set_report_database("report");
		
		$this->objPHPExcel = new PHPExcel();
		
	 }
	 
    public function index()
    {
				
        if(check_logged_in())
        {
			$this->check_access();
			
			
        }
    }
		
	
 
	private function is_access_reports($_role_id) 
	{
		$_role_arr = array("super"=>0,"admin"=>1,"tl"=>2,"manager"=>4,"trainer"=>5,"support"=>6,"trainee"=>7,"nesting"=>8,"supervisor"=>9);
		
		return true;
		
		//if(in_array($_role_id,$_role_arr ))
		//{
			//return true;
		//}else{
			//return false;
		//}
	}
	
	private function redirectors()
	{
		$role = get_role_id();
		if($role==1) return "admin";
		else return "tl";
	}
    
	
//////////////////////////////////////////////////////////////
///////////////////DFR Report section/////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Requisition Report-----------------------------*/	
	public function requisition_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/requisition_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$requisition_id="";
			$action="";
			$dn_link="";
			
			
			/* if($office_id=="ALL"){
				$data["req_code"]=$this->Dfr_model->get_requisition_id();
			}else{
				$data["req_code"]=$this->Dfr_model->get_requisition_id_list($user_office_id);
			} */
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id();
			
			$data["requisition_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
				
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$requisition_id = $this->input->get('requisition_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"requisition_id" => $requisition_id,
						"client_id" => $cValue,
						"process_id" => $pValue
					);
			
				$fullAray = $this->Dfr_model->get_requisition_report($field_array);
				$data["requisition_list"] = $fullAray;
				
				$this->create_Requisition_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadRequisitionCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['requisition_id']=$requisition_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadRequisitionCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="requisition_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Requisition_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition_id", "Location", "Due Date", "Requsition Type", "Department", "Client", "Process", "Role", "Req Qualification", "Req Exp Range", "Position Required", "Position Filled", "Total Applied", "Total Shortlisted", "Batch Code", "Job Desc", "Additional Info", "Raised By", "Raised Date/Time", "Status", "Approved/Decline By", "Approved/Decline Date/Time", "Approved/Decline Comment", "Updated By", "Updated Date/Time", "Assign L1-Supervisor", "Date of Assign L1", "Assign L1 By", "Req Closed By", "Req Closed Date", "Req Closed Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['requisition_status']=="A")  $status="Approved";
			else if($user['requisition_status']=="C")  $status="Cancel";
			else if($user['requisition_status']=="P")  $status="Pending";
			else $status="Decline";
		
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['off_location'].'",';
			$row .= '"'.$user['due_date'].'",';
			$row .= '"'.$user['req_type'].'",';
			$row .= '"'.$user['dept_name'].'",';
			$row .= '"'.$user['client_name'].'",';
			$row .= '"'.$user['process_name'].'",';
			$row .= '"'.$user['role_name'].'",';
			$row .= '"'.$user['req_qualification'].'",';
			$row .= '"'.$user['req_exp_range'].'",';
			$row .= '"'.$user['req_no_position'].'",';
			$row .= '"'.$user['count_canasempl'].'",';
			$row .= '"'.$user['candidate_applied'].'",';
			$row .= '"'.$user['shortlisted_candidate'].'",';
			$row .= '"'.$user['job_title'].'",';
			$row .= '"'.$user['job_desc'].'",';
			$row .= '"'.$user['additional_info'].'",';
			$row .= '"'.$user['raised_name'].'",';
			$row .= '"'.$user['raised_date'].'",';
			$row .= '"'.$status.'",';
			$row .= '"'.$user['approved_name'].'",';
			$row .= '"'.$user['approved_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['approved_comment'])).'",';
			$row .= '"'.$user['updated_name'].'",';
			$row .= '"'.$user['updated_date'].'",';
			$row .= '"'.$user['li_super'].'",';
			$row .= '"'.$user['assign_tl_date'].'",';
			$row .= '"'.$user['assign_li_by'].'",';
			$row .= '"'.$user['req_closed_by'].'",';
			$row .= '"'.$user['closed_date'].'",';
			$row .= '"'.$user['closed_comment'].'"';
						
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}


	
	public function getreqList()
	{
		if(check_logged_in())
		{
			$office_id = trim($this->input->get('office_id'));
			echo json_encode($this->Dfr_model->get_requisition_list($office_id));
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////	
	/*-------------------Candidate Report-----------------------------*/	
	public function candidate_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/candidate_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$requisition_id="";
			$action="";
			$dn_link="";
			
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id();
			
			$data["candidate_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
				
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$requisition_id = $this->input->get('requisition_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"requisition_id" => $requisition_id,
						"client_id" => $cValue,
						"process_id" => $pValue
					);
			
				$fullAray = $this->Dfr_model->get_candidate_report($field_array);
				$data["candidate_list"] = $fullAray;
				
				$this->create_Candidate_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadCandidateCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['requisition_id']=$requisition_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadCandidateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="candidate_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Candidate_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition ID", "Batch Code", "Client", "Process", "Location", "Due Date", "Position Applied For", "Hiring Source", "Source Name", "Candidate Name", "DOB", "Email", "Gender", "Phone", "Qualification", "Skill", "Total Exp", "Address", "Country", "State", "City", "Postcode", "Attachment", "Summary", "Added By", "Candidate Status", "Fusion ID", "User Status", "Added Date", "Approved By", "Approved Comment", "DOJ");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$c_status=$user['candidate_status'];
			//$a_status=$user['approved_status'];
			
			if($c_status=='CS') $cstatus="Selected";
			else if($c_status=='SL') $cstatus="Shortlisted";
			else if($c_status=='IP') $cstatus="In Progress";
			else if($c_status=='P') $cstatus="Pending";
			else if($c_status=='E') $cstatus="Add as an Employee";
			else $cstatus="Rejected";
			
			$userstatus=$user['user_status'];							
			$status_str ="";
			 
			if($user['candidate_status']=='E'){
				if($userstatus=='1') $status_str =  'Active'; 
				else if($userstatus=='0')  $status_str = 'Terms';
				else if($userstatus=='2')  $status_str = 'Pre-Terms';
				else  $status_str = 'Deactive';
			}	
										
			$ref_name = $user['ref_name'];
			
			if($user['ref_id'] !="" ) $ref_name = $ref_name .", " . $user['ref_id'];
			
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['batchCode'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['off_loc'].'",'; 
			$row .= '"'.$user['due_date'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['hiring_source'].'",'; 
			$row .= '"'.$ref_name.'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
			$row .= '"'.$user['dob'].'",';
			$row .= '"'.$user['email'].'",';
			$row .= '"'.$user['gender'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['last_qualification'].'",';
			$row .= '"'.$user['skill_set'].'",';
			$row .= '"'.$user['total_work_exp'].'",';
			$row .= '"'.$user['address'].'",';
			$row .= '"'.$user['country'].'",';
			$row .= '"'.$user['state'].'",';
			$row .= '"'.$user['city'].'",';
			$row .= '"'.$user['postcode'].'",';
			$row .= '"'.$user['attachment'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['summary'])).'",';
			$row .= '"'.$user['added_name'].'",';
			$row .= '"'.$cstatus.'",';
			$row .= '"'.$user['fusionid'].'",';
			$row .= '"'.$status_str.'",';
			$row .= '"'.$user['added_date'].'",';
			$row .= '"'.$user['approved_name'].'",';
			//$row .= '"'.$astatus.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['approved_comment'])).'",';
			$row .= '"'.$user['doj'].'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
		
//////////////////////////////////////////////////////////////	
	
	public function dfr_dashboard()
    {
				
        if(check_logged_in())
        {
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$data["aside_template"] = "client/aside.php";
			$data["content_template"] = "client/dfr_day_summ.php";
			
			$start_date = mysql2mmddyy(CurrDate());
			
			//$start_date = mysql2mmddyy(GetLocalDate());
						
			$location=get_user_office_id();
			//$dept=get_dept_id();
						
			//$data['department_list'] = $this->Common_model->get_department_list();	
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if($this->input->get('showReports')=='Show')
			{
				$start_date = $this->input->get('start_date');
				$location = $this->input->get('location');
				//$dept = $this->input->get('dept');
				
			}
						
			$data['start_date'] = $start_date;
			
			$start_date= mmddyy2mysql($start_date);
			
			$st_date = $start_date." 00:00:00";
			$en_date = $start_date." 23:59:59";
			
			$qSql='SELECT COUNT(*) AS opened_requisation FROM `dfr_requisition` WHERE requisition_status="A" AND due_date >= "'.$start_date.'" AND location="'.$location.'"';
						
			$query = $this->db->query($qSql);
			
			$result = $query->row();
			$data["opened_requisation"] = $result->opened_requisation;
			
			
			//$qSql = 'SELECT COUNT(*) AS candidate_registered FROM `dfr_candidate_details` dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE getEstToLocalAbbr(added_date,location) >= "'.$st_date.'" AND getEstToLocalAbbr(added_date,location) <= "'.$en_date.'" AND dr.location="'.$location.'"';
			
			$qSql = 'SELECT COUNT(*) AS candidate_registered FROM `dfr_candidate_details` dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE added_date >= "'.$st_date.'" AND added_date <= "'.$en_date.'" AND dr.location="'.$location.'"';
			
			
			$query = $this->db->query($qSql);
			
			
			$result = $query->row();
			$data["candidate_registered"] = $result->candidate_registered;
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_scheduled FROM `dfr_interview_schedules`  WHERE getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_scheduled FROM `dfr_interview_schedules`  WHERE creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_scheduled"] = $result->total_scheduled;
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_pending FROM `dfr_interview_schedules` WHERE sh_status="P" AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_pending FROM `dfr_interview_schedules` WHERE sh_status="P" AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_pending"] = $result->total_pending;
			
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_inprogress FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("IP") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_inprogress FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("IP") AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_inprogress"] = $result->total_inprogress;
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_shortlisted FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
						
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_shortlisted FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_shortlisted"] = $result->total_shortlisted;
			
						
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_selected FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("CS") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_selected FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("CS") AND creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
			
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_selected"] = $result->total_selected;
			
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_employee FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("E") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_employee FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("E") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_selected_employee"] = $result->total_employee;
			
			
			//$qSql='SELECT COUNT(*) AS total_interview_scheduled FROM `dfr_interview_schedules` WHERE   getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS total_interview_scheduled FROM `dfr_interview_schedules` WHERE   creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_interview_scheduled"] = $result->total_interview_scheduled;
			
			
			//$qSql='SELECT COUNT(*) AS interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N")  AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N")  AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["interview_completed"] = $result->interview_completed;
					

			//$qSql='SELECT COUNT(*) AS interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P")  AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P")  AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["interview_pending"] = $result->interview_pending;
			
			
			$data["interview_cancel"] = $data["total_interview_scheduled"] - $data["interview_completed"]- $data["interview_pending"];
			
			
			//$qSql='SELECT COUNT(*) AS hr_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS hr_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_completed"] = $result->hr_interview_completed;
			
			//$qSql='SELECT COUNT(*) AS hr_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS hr_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_cancel"] = $result->hr_interview_cancel;
			
			//$qSql='SELECT COUNT(*) AS hr_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="1"';
						
			$qSql='SELECT COUNT(*) AS hr_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="1"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_pending"] = $result->hr_interview_pending;
			
			//$qSql='SELECT COUNT(*) AS ops_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$qSql='SELECT COUNT(*) AS ops_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_completed"] = $result->ops_interview_completed;
			
			//$qSql='SELECT COUNT(*) AS ops_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$qSql='SELECT COUNT(*) AS ops_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_cancel"] = $result->ops_interview_cancel;
			
			$qSql='SELECT COUNT(*) AS ops_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$qSql='SELECT COUNT(*) AS ops_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_pending"] = $result->ops_interview_pending;
						
			//$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'"  and sh_status not in ("SL","E","CS") AND interview_site="'.$location.'" GROUP BY c_id');
								
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) as undefind_status FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE sh_status IN("C","N") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'"  and candidate_status not in ("SL","E","CS","R") AND interview_site="'.$location.'" ';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) as undefind_status FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" and candidate_status not in ("SL","E","CS","R") AND interview_site="'.$location.'" ';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_undefind_status"] =$result->undefind_status;
			
			$qSql='SELECT COUNT(*) AS candidate_rejected FROM `dfr_candidate_details`  dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE getEstToLocalAbbr(added_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(added_date,interview_site)  <= "'.$en_date.'" AND candidate_status="R" AND dr.location="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS candidate_rejected FROM `dfr_candidate_details`  dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE added_date >= "'.$st_date.'" and added_date <= "'.$en_date.'" AND candidate_status="R" AND dr.location="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_rejected"] = $result->candidate_rejected;
						
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" GROUP BY c_id');
			//$result = $query->row();
			$data["pending_cand_final_stat"] = $query->num_rows();
	
			
			$data['location'] = $location;
			//$data['dept'] = $dept;
			
			$this->load->view('dashboard',$data);
		}
	}
		
	//===== SIGNIN USER PHASE =======================//
	public function display_user_phase($phaseid="", $type="")
	{
		$phaseName = ""; 
		$phaseArr = array(
			'1' => "Hiring",
			'2' => "Training",
			'3' => "Nesting",
			'4' => "Production",
			'5' => "BENCH-PAID",
			'6' => "BENCH-UNPAID",
			'7' => "Recurisve Training",
		);
		foreach($phaseArr as $key => $value){
		  if($key == $phaseid){  $phaseName = $value; }
		}
		if($type == 'array'){ 
			return $phaseArr; 
		} else {
			return $phaseName;
		}		
	}
	
	
		
}

?>