<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_acpt_report_api extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->model('Email_model'); // Added Email model 
		
		$this->objPHPExcel = new PHPExcel();
	 }
	
	public function create_qa_digit_CSV()
	{
		$currDate=date("Y-m-d");
		$date_from = mmddyy2mysql($this->input->get('date_from'));
		$date_to = mmddyy2mysql($this->input->get('date_to'));
		$pid = $pValue = 'acpt';
		$cond1 = '';
		
		if($date_from !="" && $date_to!=="" )  $cond= " Where (date(audit_date) >= '$date_from' and date(audit_date) <= '$date_to' ) ";	
		
		
		$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(
		        SELECT
		           description
		        FROM
		            department d
		            LEFT JOIN signin sd ON sd.dept_id=d.id
		        WHERE
		            sd.id = entry_by
			    ) AS department_name ,
		(select office_name from office_location where abbr=(select office_id from signin ss where ss.id=agent_id)) as agent_location,
		(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as qa_location,
		(select email_id_off from info_personal ip where ip.user_id=entry_by) as auditor_email,
		(select email_id_off from info_personal ips where ips.user_id=agent_id) as agent_email,
		(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
		(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
		(select concat(fname, ' ', lname) as name from signin sqrm where sqrm.id=qa_mgnt_rebuttal_by) as qa_rebuttal_mgnt_name,
		(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_".$pValue."_feedback) xx 
		Left Join (Select id as sid, concat(fname, ' ', lname) as agent_name, xpoid, fusion_id, doj, assigned_to, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond";
		//exit();
		$fullAray = $this->Common_model->get_query_result_array($qSql);
		////////////////////////////////////////////////////////////////////////
		$filename = "./assets/reports/Report".$currDate.".csv";
		$fopen = fopen($filename,"w+");
		
	    if($pid=='acpt'){
			$header = array("QA name","Department", "QA Location", "Agent Name","Agent Location", "TL Name", "Tenure","Tenurity Bucket", "Week", "Audit Date", "Call/Ticket ID", "Interaction Date/Time", "AHT", "LOB/Capmaign", "Disposition", "Sub Disposition", "Sub Sub Disposition", "Disposition Accuracy", "Disposition Comment", "Auditor Disposition Comment", "Audit Type","Language", "Level-1", "Level-2", "Observation", "Opportunity Detail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Finding 1","Finding 2");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		
		if($pid=='acpt'){
		
			foreach($fullAray as $user)
			{	
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if(is_available_qa_feedback($user['entry_date'],72) == true){
					$agnt_fd_acpt = $user['agnt_fd_acpt'];
				}else{
					if($user['agent_rvw_date']!=""){
						$agnt_fd_acpt = $user['agnt_fd_acpt'];
					}else{
						//$agnt_fd_acpt = "Auto Accepted";
						$agnt_fd_acpt = "";
					}
				}
				
				if($user['week']!=""){
					$week=$user['week'];
				}else{
					$week='Week4';
				}
				
				if($user['qa_rebuttal_date']=="" || $user['qa_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_rebuttal_date='---';
				}else{
					$qa_rebuttal_date= $this->ConvServerToLocal_new($user['qa_rebuttal_date']);
				}
				
				if($user['qa_mgnt_rebuttal_date']=="" || $user['qa_mgnt_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_mgnt_rebuttal_date='---';
				}else{
					$qa_mgnt_rebuttal_date= $this->ConvServerToLocal_new($user['qa_mgnt_rebuttal_date']);
				}
				
				$adtdate= $this->ConvServerToLocal_new($user['entry_date']);
				$time = strtotime($adtdate);
				$auditDate = date('Y-m-d',$time);
				
				// AHT Convertion to sec
				$aht = $this->timeToSeconds($user['call_duration']);
				
				// Tenurity Bucket // 0-30 // 30-90 // 90-180 // 180+
				
				if($user['tenure']>=0 && $user['tenure']<=30){
					$bucket = "0-30";
				}else if($user['tenure']>30 && $user['tenure']<=90)
				{
					$bucket = "30-90";
				}
				else if($user['tenure']>90 && $user['tenure']<=180)
				{
					$bucket = "90-180";
				}else{
					$bucket = "180+";
				}
				
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['department_name'].'",';  
				$row .= '"'.$user['qa_location'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['agent_location'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$bucket.'",';
				$row .= '"'.$week.'",';
				$row .= '"'.$auditDate.'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['call_date'].'",';
				//$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$aht.'",';
				$row .= '"'.$user['lob_campaign'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['sub_disposition'].'",';
				$row .= '"'.$user['sub_sub_disposition'].'",';
				$row .= '"'.$user['disposition_accuracy'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['disposition_comment'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['auditor_disposition_comment'])).'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['language'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['acpt_l2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['observation'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['opportunity_details'])).'",';
				$row .= '"'.$this->ConvServerToLocal_new($user['audit_start_time']).'",';
				$row .= '"'.$this->ConvServerToLocal_new($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['finding_1'].'",';
				$row .= '"'.$user['finding_2'].'"';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".$currDate.".csv";
		$newfile="QA Digit Insurance ".$pid." List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
		//////////convert hrs min sec to sec ////////////
	public function timeToSeconds(string $time): int
	{
		$arr = explode(':', $time);
		if (count($arr) === 3) {
			return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
		}
		return $arr[0] * 60 + $arr[1];
	}
	////////// end ///////////

	public function ConvServerToLocal_new($dtTime)
	{
		global $CI;
		$query = $CI->db->query("SELECT time_zone_str, time_zone_str_ds FROM `office_location` where abbr='BLR'");

		$row = $query->row();

		if ($this->isDayLightSaving($dtTime) == 0)
			$serverTime = $row->time_zone_str;
		else
			$serverTime = $row->time_zone_str_ds;

		$xmasDay = new DateTime($dtTime . " " . $serverTime . "");

		return $xmasDay->format('Y-m-d H:i:s');
	}


	public function isDayLightSaving($anydt, $loc = "")
	{
		if ($loc == "")
			$loc = "BLR";
		$dat = date('Y-m-d', strtotime($anydt));
		$year = date('Y', strtotime($anydt));

		$count = 0;

		if (isValidMysqlDate($dat) == true) {

			global $CI;

			$qSql = "Select isDayLightSaving('$dat','$loc') as value";
			$query = $CI->db->query($qSql);
			$res = $query->row_array();
			$count = $res["value"];
		}
		return $count;
	}

///////////////////// AJAX Call ////////////////////////
	public function getLocation(){
		if(check_logged_in()){
			$pid=$this->input->post('pid');
			
			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$pid' and s.dept_id=6 and s.status=1 group by o.abbr";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
}
?>