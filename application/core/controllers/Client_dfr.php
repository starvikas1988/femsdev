<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_dfr extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('Client_model');
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->model('Dfr_model');
		
	 }
	 
	 
	public function index(){	
		if(check_logged_in()){
			
			$current_user=get_user_id();
			
			$qSql="Select yy.*, ii.*,ii.id as sch_id from (Select r.id as rid, r.requisition_id, r.req_no_position, r.filled_no_position, r.department_id, r.role_id, r.location, r.due_date, c.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name from dfr_requisition r, dfr_candidate_details c where r.id=c.r_id and c.candidate_status='IP') yy Right Join (Select dis.* from dfr_interview_schedules dis where interview_type='5' and assign_interviewer = '$current_user') ii ON (ii.c_id=yy.id)";
			$data["get_assigned_client"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, concat(fname, ' ', lname) as name from signin_client where status=1 order by name asc ";
			$data["user_client"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["aside_template"] = "clientlogin/aside_dfr.php";
			$data["content_template"] = "clientlogin/client_dfr.php";

			$this->load->view('dashboard',$data);
			
		}
    }
	
	
	public function dashboard(){
		if(check_logged_in()){
			
			$current_user=get_user_id();
			$data["error"] = '';
			
			$current_user = get_user_id();
			$start_date = mysql2mmddyy(CurrDate());
			
			$client_id=get_clients_client_id();
			
			$process_id=get_clients_process_id();
									
			$location=get_user_office_id(); // client office may be multiple
			$location_array=explode(",",$location);
			$data['location']=$location_array[0];
				
			$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
						
			$qSql	=	"SELECT id, name FROM process WHERE client_id in ( $client_id ) AND id in ( $process_id )";
			$data['process_list']	=	$this->Common_model->get_query_result_array($qSql);
			
			$data['process']="";
			
			if($this->input->get('showReports')=='Show')
			{
				$start_date = $this->input->get('start_date');
				$location = $this->input->get('location');
				$process = $this->input->get('process');
				if($process!="ALL" && $process=="") $process_id = $process;
				
				$data['process']=$process;
				$data['location']=$location;
			}
							
			$data['start_date'] = $start_date;
			
			$start_date= mmddyy2mysql($start_date);
			
			$st_date = $start_date." 00:00:00";
			$en_date = $start_date." 23:59:59";
			
			$qSql='SELECT COUNT(*) AS opened_requisation FROM `dfr_requisition` WHERE requisition_status="A" AND due_date >= "'.$start_date.'" AND location="'.$location.'" and process_id in ('.$process_id.')';
						
			$query = $this->db->query($qSql);
			
			$result = $query->row();
			$data["opened_requisation"] = $result->opened_requisation;
									
			
			$qSql = 'SELECT COUNT(*) AS candidate_registered FROM `dfr_candidate_details` dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE added_date >= "'.$st_date.'" AND added_date <= "'.$en_date.'" AND dr.location="'.$location.'" and dr.process_id in ('.$process_id.')';
						
			$query = $this->db->query($qSql);
						
			$result = $query->row();
			$data["candidate_registered"] = $result->candidate_registered;
						
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_scheduled FROM `dfr_interview_schedules` di 
			LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id  WHERE creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_scheduled"] = $result->total_scheduled;
			
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_pending FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status="P" AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"  and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_pending"] = $result->total_pending;
			
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_inprogress FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE dc.candidate_status IN("IP") AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"  and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_inprogress"] = $result->total_inprogress;
			
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_shortlisted FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE dc.candidate_status IN("SL") AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_shortlisted"] = $result->total_shortlisted;
						
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_selected FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id  WHERE dc.candidate_status IN("CS") AND creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_selected"] = $result->total_selected;
			
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_employee FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE dc.candidate_status IN("E") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_selected_employee"] = $result->total_employee;
						
			$qSql='SELECT COUNT(*) AS total_interview_scheduled FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE   creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_interview_scheduled"] = $result->total_interview_scheduled;
						
			$qSql='SELECT COUNT(*) AS interview_completed FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("C","N")  AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["interview_completed"] = $result->interview_completed;
						
			$qSql='SELECT COUNT(*) AS interview_pending FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("P")  AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["interview_pending"] = $result->interview_pending;
						
			$data["interview_cancel"] = $data["total_interview_scheduled"] - $data["interview_completed"]- $data["interview_pending"];
			
			$qSql='SELECT COUNT(*) AS hr_interview_completed FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_completed"] = $result->hr_interview_completed;
			
						
			$qSql='SELECT COUNT(*) AS hr_interview_cancel FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("R") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_cancel"] = $result->hr_interview_cancel;
									
			$qSql='SELECT COUNT(*) AS hr_interview_pending FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("P") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="1" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_pending"] = $result->hr_interview_pending;
						
			$qSql='SELECT COUNT(*) AS ops_interview_completed FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2" and dr.process_id in ('.$process_id.')';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_completed"] = $result->ops_interview_completed;
						
			$qSql='SELECT COUNT(*) AS ops_interview_cancel FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("R") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_cancel"] = $result->ops_interview_cancel;
			
			$qSql='SELECT COUNT(*) AS ops_interview_pending FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("P") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_pending"] = $result->ops_interview_pending;
			
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) as undefind_status FROM `dfr_interview_schedules` di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" and dc.candidate_status not in ("SL","E","CS","R") AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.')';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_undefind_status"] =$result->undefind_status;
			
						
			$qSql='SELECT COUNT(*) AS candidate_rejected FROM `dfr_candidate_details`  dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE added_date >= "'.$st_date.'" and added_date <= "'.$en_date.'" AND dc.candidate_status="R" AND dr.location="'.$location.'" and dr.process_id in ('.$process_id.')'; 
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_rejected"] = $result->candidate_rejected;
			
			$qSql='SELECT * FROM `dfr_interview_schedules`  di LEFT JOIN dfr_candidate_details dc on dc.id =di.c_id Left Join dfr_requisition dr on dc.r_id =dr.id WHERE dc.candidate_status IN("SL") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" and dr.process_id in ('.$process_id.') GROUP BY c_id';
			
			$query = $this->db->query($qSql);
			$data["pending_cand_final_stat"] = $query->num_rows();
			
			$data["aside_template"] = "clientlogin/aside_dfr.php";
			$data["content_template"] = "clientlogin/dfr_day_summ.php";

			$this->load->view('dashboard',$data);
			
		}
    }
	
	public function requisition_report(){
		
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$start_date = mysql2mmddyy(CurrDate());
			
			$client_id=get_clients_client_id();
						
			$process_id=get_clients_process_id();
			
			$location=get_user_office_id(); // client office may be multiple
			$location_array=explode(",",$location);					
			$data['location'] = $office_id = $location_array[0];
						
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
									
			$date_from="";
			$date_to="";
			$requisition_id="";
			$action="";
			$dn_link="";
			$data['process']="";
						
			$data["requisition_list"] = array();
				
			$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
			
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
						
			$qSql	=	"SELECT id, name FROM process WHERE client_id in ( $client_id ) AND id in ( $process_id )";
			$data['process_list']	=	$this->Common_model->get_query_result_array($qSql);
					
			$process="";
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				
				$office_id = $this->input->get('office_id');
				$process = trim($this->input->get('process'));
			
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"requisition_id" => $requisition_id,
						"client_id" => $client_id,
						"process_id" => $process
					);
			
				$fullAray = $this->Dfr_model->get_requisition_report($field_array);
				$data["requisition_list"] = $fullAray;
				
				$this->create_Requisition_CSV($fullAray);
					
				$dn_link = base_url()."client_dfr/downloadRequisitionCsv";
					
			}
			
			$data['client_id']=$client_id;
			$data['process']=$process;
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
								
			
			$data["aside_template"] = "clientlogin/aside_dfr.php";
			$data["content_template"] = "clientlogin/dfr_req_report.php";

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


	
	//////////////DFR Part start//////////////	
	public function cancel_interviewSchedule(){
		if(check_logged_in()){
			
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$sch_id=trim($this->input->post('sch_id'));
			$cancel_reason=trim($this->input->post('cancel_reason'));
			
			if($c_id!=""){
				$field_array = array(
					"sh_status" => 'R',
					"cancel_reason" => $cancel_reason
				);
				$this->db->where('id', $sch_id);
				$this->db->where('c_id', $c_id);
				$this->db->update('dfr_interview_schedules', $field_array);
				
			}
			
			redirect(base_url()."client_dfr");
		}
	}
	
	
	public function add_candidate_interview(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			$sh_status = trim($this->input->post('sh_status'));
			$updated_date = date("Y-m-d h:i:sa");
			$interview_status=trim($this->input->post('interview_status'));
			$log=get_logs();
			
			$field_array = array(
				"c_id" => $c_id,
				"sch_id" => $sch_id,
				"interviewer_id" => trim($this->input->post('interviewer_id')),
				"result" => trim($this->input->post('result')),
				"interview_status" => $interview_status,
				"interview_date" => mdydt2mysql(trim($this->input->post('interview_date'))),
				"interview_remarks" => trim($this->input->post('interview_remarks')),
				"educationtraining_param" => trim($this->input->post('educationtraining_param')),
				"jobknowledge_param" => trim($this->input->post('jobknowledge_param')),
				"workexperience_param" => trim($this->input->post('workexperience_param')),
				"analyticalskills_param" => trim($this->input->post('analyticalskills_param')),
				"technicalskills_param" => trim($this->input->post('technicalskills_param')),
				"generalawareness_param" => trim($this->input->post('generalawareness_param')),
				"bodylanguage_param" => trim($this->input->post('bodylanguage_param')),
				"englishcomfortable_param" => trim($this->input->post('englishcomfortable_param')),
				"mti_param" => trim($this->input->post('mti_param')),
				"enthusiasm_param" => trim($this->input->post('enthusiasm_param')),
				"leadershipskills_param" => trim($this->input->post('leadershipskills_param')),
				"customerimportance_param" => trim($this->input->post('customerimportance_param')),
				"jobmotivation_param" => trim($this->input->post('jobmotivation_param')),
				"resultoriented_param" => trim($this->input->post('resultoriented_param')),
				"logicpower_param" => trim($this->input->post('logicpower_param')),
				"initiative_param" => trim($this->input->post('initiative_param')),
				"assertiveness_param" => trim($this->input->post('assertiveness_param')),
				"decisionmaking_param" => trim($this->input->post('decisionmaking_param')),
				"overall_assessment" => trim($this->input->post('overall_assessment')),
				"updated_by" => $current_user,
				"updated_date" => $updated_date,
				"log" => $log
			);
			
			$rowid= data_inserter('dfr_interview_details',$field_array);
			
			if($sch_id!=""){
				$field_array1 = array(
					"sh_status" => $interview_status
				);
				$this->db->where('id', $sch_id);
				$this->db->update('dfr_interview_schedules', $field_array1);
			}
						
			if($interview_status=="N" && $interview_status=="C"){
				
				$field_array2 = array(
					"candidate_status" => 'IP'
				);
				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array2);
				
			}			
			
			redirect(base_url()."client_dfr");
		
		}
		
	}
	
	public function edit_interview(){
		if(check_logged_in()){
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			
			if($sch_id!=""){
				$field_array = array(
					"interviewer_id" => trim($this->input->post('interviewer_id')),
					"result" => trim($this->input->post('result')),
					"educationtraining_param" => trim($this->input->post('educationtraining_param')),
					"jobknowledge_param" => trim($this->input->post('jobknowledge_param')),
					"workexperience_param" => trim($this->input->post('workexperience_param')),
					"analyticalskills_param" => trim($this->input->post('analyticalskills_param')),
					"technicalskills_param" => trim($this->input->post('technicalskills_param')),
					"generalawareness_param" => trim($this->input->post('generalawareness_param')),
					"bodylanguage_param" => trim($this->input->post('bodylanguage_param')),
					"englishcomfortable_param" => trim($this->input->post('englishcomfortable_param')),
					"mti_param" => trim($this->input->post('mti_param')),
					"enthusiasm_param" => trim($this->input->post('enthusiasm_param')),
					"leadershipskills_param" => trim($this->input->post('leadershipskills_param')),
					"customerimportance_param" => trim($this->input->post('customerimportance_param')),
					"jobmotivation_param" => trim($this->input->post('jobmotivation_param')),
					"resultoriented_param" => trim($this->input->post('resultoriented_param')),
					"logicpower_param" => trim($this->input->post('logicpower_param')),
					"initiative_param" => trim($this->input->post('initiative_param')),
					"assertiveness_param" => trim($this->input->post('assertiveness_param')),
					"decisionmaking_param" => trim($this->input->post('decisionmaking_param')),
					"overall_assessment" => trim($this->input->post('overall_assessment'))
				);
				$this->db->where('sch_id', $sch_id);
				$this->db->update('dfr_interview_details', $field_array);
			}
			redirect(base_url()."client_dfr");
		}
	}
	
	
/*----------------------PDF part-----------------------*/	
	
	public function candidate_details_pdf($c_id){
			
			if(check_logged_in()){
				
			//load mPDF library
			$this->load->library('m_pdf');
			
			
			$qSql="SELECT * from (Select *, DATE_FORMAT(added_date, '%m/%d/%Y') as addedDate from dfr_candidate_details where id='$c_id') xx Left Join (Select *, (select name from role r where r.id=dfr_requisition.role_id) as position_name from dfr_requisition) yy On (xx.r_id=yy.id)";
			
			$data["candidate_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="SELECT * FROM dfr_qualification_details where candidate_id='$c_id'";
			$data["can_education_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_experience_details where candidate_id='$c_id'";
			$data["can_experience_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_candidate_family_info where candidate_id='$c_id'";
			$data["can_family_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data['c_id'] = $c_id;  
			
			
			$html=$this->load->view('client/candidatedetails_pdf', $data, true);

			//this the the PDF filename that user will get to download
			$pdfFilePath = "candidate_details.pdf";
			
			$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");		
			
			}
			
		}
	
	
	public function view_candidate_details($c_id){
		if(check_logged_in()){
			
			//$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			//$data["aside_template"] = "dfr/aside.php";
			//$data["content_template"] = "";
			
			$qSql="SELECT * from (Select *, DATE_FORMAT(added_date, '%m/%d/%Y') as addedDate from dfr_candidate_details where id='$c_id') xx Left Join (Select *, (select name from role r where r.id=dfr_requisition.role_id) as position_name from dfr_requisition) yy On (xx.r_id=yy.id)";
			
			$data["candidate_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="SELECT * FROM dfr_qualification_details where candidate_id='$c_id'";
			$data["can_education_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_experience_details where candidate_id='$c_id'";
			$data["can_experience_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_candidate_family_info where candidate_id='$c_id'";
			$data["can_family_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$data['c_id'] = $c_id;  
			 
			$this->load->view('client/candidate_details.php',$data);
			
		}
	}
	
	
	///////////////////////////////
	
	public function view_candidate_interview($c_id){
		if(check_logged_in()){
			
			//$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			//$data["aside_template"] = "dfr/aside.php";
			//$data["content_template"] = "dfr/candidate_interview_report.php";
			
									
			$sqltxt ="SELECT inv.*, (Select name from dfr_interview_type_mas mas where mas.id =sch.interview_type ) as parameter , getInterviewerName(sch.interview_type,inv.interviewer_id) as interviewer  FROM dfr_interview_schedules sch Left Join dfr_interview_details inv on sch.id = inv.sch_id  where  sch.c_id='$c_id'";

			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($sqltxt);
			
			
			
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM femsdev.department d where rq.department_id = d.id )as dept  FROM femsdev.dfr_candidate_details cd INNER join  femsdev.dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			$data["candidate_details"]=   $this->Common_model->get_query_result_array($sqltxt);
			
			$data['c_id'] = $c_id; 
		
			 
			 $this->load->view('client/candidate_interview_report.php',$data);
			
			
		}
	}
	
	public function interview_pdf($c_id){ 
			
			if(check_logged_in()){
				
			//load mPDF library
			$this->load->library('m_pdf');
			
			$sqltxt ="SELECT inv.*,(Select name from dfr_interview_type_mas mas where mas.id =sch.interview_type ) as parameter , getInterviewerName(sch.interview_type,inv.interviewer_id) as interviewer  FROM dfr_interview_schedules sch Left Join dfr_interview_details inv on sch.id = inv.sch_id  where  sch.c_id='$c_id'";
			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($sqltxt);
			
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM femsdev.department d where rq.department_id = d.id )as dept  FROM femsdev.dfr_candidate_details cd INNER join  femsdev.dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			$data["candidate_details"]=   $this->Common_model->get_query_result_array($sqltxt);
			$data['c_id'] = $c_id;  
			
			  
			/* $this->pdf->load_view('generate_pdf',$data); 
			$this->pdf->render();  */
			
			$html=$this->load->view('client/generate_pdf', $data, true);

			//this the the PDF filename that user will get to download
			$pdfFilePath = "interview_". time() .".pdf";
			
			$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");		

		}
		
	}
		
//////////////DFR Part end//////////////	
	 
} 