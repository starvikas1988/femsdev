<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autojob extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model');
	}

	public function index()
	{
		
	}
	
	public function send_birthday_email()
	{
		$this->Common_model->send_birthday_email();
		$evt_date=CurrMySqlDate();
		echo "Call send_birthday_email at " . $evt_date ."\r\n";
	}
	
	public function auto_Term_On30Days()
	{
		//$this->Common_model->auto_Term_On30Days();
		$evt_date=CurrMySqlDate();
		echo "Call auto_Term_On30Days at " . $evt_date ."\r\n";
	}
	
	public function update_password_expiry()
	{
		$this->Common_model->update_password_expiry();
		$evt_date=CurrMySqlDate();
		echo "Call update_password_expiry at " . $evt_date ."\r\n";
	}
		
	public function auto_mia_update()
	{
		$this->Common_model->auto_disposition_update();
		$evt_date=CurrMySqlDate();
		echo "Call auto_mia_update at " . $evt_date ."\r\n";
	}
	
	public function auto_update_roster_off()
	{
		$this->Common_model->auto_update_roster_off();
		$evt_date=CurrMySqlDate();
		echo "Call auto_update_roster_off at " . $evt_date ."\r\n";
	}
		
	public function auto_logout()
	{
		$this->user_model->auto_logout_after_hrs();
		
		$evt_date=CurrMySqlDate();
		echo "Call auto_logout_after_hrs at " . $evt_date ."\r\n";
		
	}
	
	public function auto_resend_email()
	{
		$this->Common_model->auto_resend_email();
		
		$evt_date=CurrMySqlDate();
		echo "Call auto_resend_email at " . $evt_date ."\r\n";
			
	}
	
	public function auto_update_orgrole()
	{
		$this->Common_model->auto_update_orgrole();
		$evt_date=CurrMySqlDate();
		echo "Call auto_update_orgrole at " . $evt_date ."\r\n";
			
	}
	
	public function auto_send_hmo_phil()
	{
		
		//$SQLtxt = "SELECT signin.id as user_id , fusion_id, office_id,fname, lname, doj, (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select name from role where role.id= signin.role_id) as designation,(select location from office_location WHERE signin.office_id = office_location.abbr )as location, concat(fname,' ',lname)as fullname, IF(doj IS NOT NULL,(DATEDIFF(now(), doj)) ,0) as no_of_days FROM signin LEFT JOIN info_personal on info_personal.user_id = signin.id WHERE office_id in('CEB','MAN') and status in (1,7) and is_sent_hmo_letter!='Y' HAVING no_of_days >= 180 and no_of_days <= 190  order BY signin.id ";
		
		$SQLtxt = "SELECT signin.id as user_id , fusion_id, office_id,fname, lname, doj, (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select name from role where role.id= signin.role_id) as designation,(select location from office_location WHERE signin.office_id = office_location.abbr )as location, concat(fname,' ',lname)as fullname, IF(doj IS NOT NULL,(DATEDIFF(now(), doj)) ,0) as no_of_days FROM signin LEFT JOIN info_personal on info_personal.user_id = signin.id WHERE signin.id=7 ";
		
	    $hmo_phil_data  = $this->Common_model->get_query_result_array($SQLtxt);
		foreach($hmo_phil_data as $row){
			$fusion_id=$row['fusion_id'];
			$fullname=$row['fullname'];
			$designation=$row['designation'];
			$fname= $row['fname'];
			$lname= $row['lname'];
			$user_id= $row['user_id'];
			$office_id= $row['office_id'];
			
			$eto = array();
			$eto[] = $row['personal_email'];
			$eto[] = $row['office_email'];
			
			if($office_id=="CEB") $ecc = "hr.cebu@fusionbposervices.com";
			else if($office_id=="MAN") $ecc = "hr.manila@fusionbposervices.com";
			else $ecc = "employee.connect@fusionbposervices.com";
			$ebody="Hello $fullname ($fusion_id),<br><br>
					We are pleased to inform you that you are eligible for the HMO package (Health + Life insurance) effective today until OCTOBER 31, 2021. Attached herewith is the e-HMO pamphlet so you will be guided on the health services due for you and you may review our recorded HMO orientation in FEMS under Knowledge base Icon. Furthermore, we will touch base with you one-by-one as soon as your insurance cards are available. Meanwhile, please make use of the COC (Certificate of Coverage) attached for urgent availment while we are still waiting for your cards to arrive. Also, kindly know that HR team will reach out to you as you are entitled to enroll ONE FREE DEPENDENT once you reach the regularization period on your 6th month of employment here in the company.<br>
					Should you have further concerns re your HMO, please approach any nurse-on duty. Kindly be guided accordingly. <br><br>
					Thank you. <br><br>
					Regards, <br>
					Fusion - Global HR Shared Services
					";
					
				$esubj="You are eligible for the HMO package ($fullname, $fusion_id )";
			
			$is_send=$this->Email_model->send_email_sox($user_id,implode(',',$eto),$ecc,$ebody,$esubj);
						
			if($is_send == true){
				$SQLtxt ="UPDATE signin SET is_sent_hmo_letter ='Y' WHERE id=". $user_id ."";
				$this->db->query($SQLtxt);
			}
						
			
		}
		
		$evt_date=CurrMySqlDate();
		echo "Call auto_send_hmo_phil at " . $evt_date ."\r\n";
			
	}
	
	
	
	public function update_target_monthly()
	{
		$year = date('Y');
		$month = date('m');
		
		$last_year = date("Y", strtotime("-1 months"));
		$last_month = date("m", strtotime("-1 months"));
		
		$next_year = date("Y", strtotime("+1 months"));
		$next_month = date("m", strtotime("+1 months"));
		
		//$query = $this->db->query('SELECT * FROM `pm_target_v2` WHERE month="'.$month.'" AND year="'.$year.'"');
		$last_month_grade_list = $this->db->query('SELECT * FROM `pm_target_v2` WHERE month="'.$last_month.'" AND year="'.$last_year.'" GROUP BY pm_target_v2.did');
		if($last_month_grade_list)
		{
			$last_month_grade_list_row = $last_month_grade_list->result_object();
			foreach($last_month_grade_list_row as $key=>$value)
			{
				$current_month_grade_list = $this->db->query('SELECT * FROM `pm_target_v2` WHERE did="'.$value->did.'" AND month="'.$month.'" AND year="'.$year.'" GROUP BY pm_target_v2.did');
				if($current_month_grade_list->num_rows() == 0)
				{
					$query = $this->db->query('INSERT INTO pm_target_v2(month, year, tenure_bucket_start, tenure_bucket_end,target, pm_design_kpi_id, did) SELECT "'.$month.'","'.$year.'",pm_target_v2.tenure_bucket_start,pm_target_v2.tenure_bucket_end,pm_target_v2.target,pm_target_v2.pm_design_kpi_id,pm_target_v2.did FROM pm_target_v2 WHERE did="'.$value->did.'" AND month="'.$last_month.'" AND year="'.$last_year.'"');
				}
			}
		}
	}

	public function update_grade_monthly()
	{
		$year = date('Y');
		$month = date('m');
		
		$last_year = date("Y", strtotime("-1 months"));
		$last_month = date("m", strtotime("-1 months"));
		
		$next_year = date("Y", strtotime("+1 months"));
		$next_month = date("m", strtotime("+1 months"));
		
		//$query = $this->db->query('SELECT * FROM `pm_target_v2` WHERE month="'.$month.'" AND year="'.$year.'"');
		$last_month_grade_list = $this->db->query('SELECT * FROM `pm_grade_v2` WHERE month="'.$last_month.'" AND year="'.$last_year.'" GROUP BY pm_grade_v2.did');
		if($last_month_grade_list)
		{
			$last_month_grade_list_row = $last_month_grade_list->result_object();
			foreach($last_month_grade_list_row as $key=>$value)
			{
				$current_month_grade_list = $this->db->query('SELECT * FROM `pm_grade_v2` WHERE did="'.$value->did.'" AND month="'.$month.'" AND year="'.$year.'" GROUP BY pm_grade_v2.did');
				if($current_month_grade_list->num_rows() == 0)
				{
					$query = $this->db->query('INSERT INTO pm_grade_v2(month, year, grade_start, grade_end,grade,did,process_id) SELECT "'.$month.'","'.$year.'",pm_grade_v2.grade_start,pm_grade_v2.grade_end,pm_grade_v2.grade,pm_grade_v2.did,pm_grade_v2.process_id FROM pm_grade_v2 WHERE did="'.$value->did.'" AND month="'.$last_month.'" AND year="'.$last_year.'"');
				}
			}
		}
	}
	
	
	//////////////////////////////////////////////////////////
	//////////////////// AUTO RELEASE TERM EMPLOYEE ////////////////////
	//////////////////////////////////////////////////////////			
		
		public function auto_release_term()
		{
			
			$current_date = CurrDate();
			$get_users_to_term_sql = "SELECT * FROM user_resign WHERE accepted_released_date < '$current_date' AND resign_status = 'AC'";
			$get_users_to_term = $this->Common_model->get_query_result_array($get_users_to_term_sql);
			foreach($get_users_to_term as $token_user)
			{
				$event_by          = "1"; //Default Administrator
				$evt_date          = CurrMySqlDate();
				$event_master_id   = 7;
				$log               = "Employee Exit - Auto Term ";
				
				$resign_id    = $token_user['id'];
				$term_user    = $token_user['user_id'];
				$term_remarks = "Auto Term by System";
				$term_date    = $token_user['accepted_released_date'];
				$is_rehire    = $token_user['is_rehire'];
				$start_date = $term_date;
				$end_date   = $term_date;
				
				
				if($term_user != "" && $term_date != "" && $term_date != "0000-00-00")
				{
											
					// DATA UPDATE START
					$this->db->trans_start();
					
					// UPDATE USER RESIGN TABLE
					$field_array = array(
						"term_remarks"  => $term_remarks,
						"resign_status" => 'C',
						"term_by"       => $event_by,
						"term_date"     => $term_date,
						"log"           => $log
					);
					$this->db->where('id', $resign_id);
					//$this->db->where('resign_status', 'AC');
					$this->db->update('user_resign', $field_array);
					
					
					// UPDATE SIGNIN TABLE
					$this->db->where('id', $term_user);
					$this->db->update('signin', array('status' =>'0', 'disposition_id' => $event_master_id));
					
					// LOG DISPOSITION
					$_field_array = array(
						"user_id"         => $term_user,
						"event_time"      => $evt_date,
						"event_by"        => $event_by,
						"event_master_id" => $event_master_id,
						"start_date"      => $start_date,
						"end_date"        => $end_date,
						"remarks"         => $term_remarks,
						"log"             => $log
					);
					data_inserter('event_disposition',$_field_array);
											
					// UPDATE TERMINATE USERS TABLE
					$_field_array = array(
						"user_id"      => $term_user,
						"terms_date"   => $term_date,
						"comments"     => $term_remarks,
						"t_type"       => '9',
						"sub_t_type"   => '2',
						"terms_by"     => $event_by,
						"is_term_complete" => "Y",
						"evt_date"     => $evt_date,
						"lwd"          => $term_date,
						"is_rehire"    => $is_rehire,
						"update_date"  => $evt_date,
						"update_remarks" => "Employee Exit",
						"update_by"    => $event_by
					);
					data_inserter('terminate_users',$_field_array);
					
					$accepted_date = CurrMySqlDate();
					$_field_array = array(
						    "resign_id" => $resign_id,
							"user_id" => $term_user,
							"it_helpdesk_status" => 'P',
							"it_security_status" => 'P',
							"payroll_status" => 'P',
							"fnf_status" => 'P',
							"updated" => $accepted_date,
							"date_added" => $accepted_date,
							"log" => $log
						);
						
					data_inserter('user_fnf',$_field_array);
						
						
					// DATA UPDATE COMPLETE
					$this->db->trans_complete();
					
					
					$this->user_model->update_after_term_l1_supervisor($term_user);
					
					
					
				}
				
			}
			
		}
		
		
	/////////////////////////////////////////////////////////////////////
	//////////////////// PROBATION COMPLETE AUTO MAIL ////////////////////
	/////////////////////////////////////////////////////////////////////
	
		public function get_probation_complete_users()
		{
			$current_date = date('Y-m-d');
			$next_date = date('Y-m-d', strtotime($current_date . " + 1 day"));
			
			$to_name = 'L1 Supervisor';
			$ecc[] = "er.india@fusionbposervices.com";
			
			$root_app_path = FCPATH;
			$file_location = $root_app_path ."assets/docs_master/confirmation_form.xlsx";
			
			$sqlp = "SELECT s.id as user_id, s.fusion_id, s.office_id, concat(s.fname, ' ', s.lname) as employee_name, d.description as department_name,
					o.prov_period_day as probation_period, s.doj as date_of_joining, 
					DATE_ADD(DATE(s.doj), INTERVAL o.prov_period_day DAY) as date_of_probation,
					s.assigned_to, concat(sg.fname, ' ', sg.lname) as assigned_to_name, p.email_id_off as assigned_to_email
					from signin as s
				    LEFT JOIN signin as sg ON sg.id = s.assigned_to
				    LEFT JOIN info_personal as p ON p.user_id = s.assigned_to
					LEFT JOIN department as d ON s.dept_id = d.id
					LEFT JOIN office_location as o ON o.abbr = s.office_id 
					WHERE (s.doj IS NOT NULL OR s.doj <> '' OR s.doj <> '0000-00-00') 
					AND (s.assigned_to IS NOT NULL OR s.assigned_to <> '') AND (p.email_id_off IS NOT NULL AND p.email_id_off <> '')
					AND (DATE_ADD(DATE(s.doj), INTERVAL o.prov_period_day DAY) = '$current_date')";
			$queryp = $this->Common_model->get_query_result_array($sqlp);
			
			//echo $sqlp ."<br/>Total Users - " .count($queryp) ."<br/><hr/><br/>";
						
			foreach($queryp as $token)
			{
				$user_id            = $token['user_id'];
				$office_id            = $token['office_id'];
				$assigned_to        = $token['assigned_to'];
				$fusion_id          = $token['fusion_id'];
				$employee_name      = $token['employee_name'];
				$employee_department = $token['department_name'];
				$probation_period   = $token['probation_period'];
				$employee_probation = $token['date_of_probation'];
				$employee_joining   = $token['date_of_joining'];
								
				$qSql="SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='".$l1_id."');";
				$l2_email_off= $this->Common_model->get_single_value($qSql);
		
				$qSql="select * from notification_info where sch_for='EMP_CONFIRMATION' and is_active=1 and office_id='".$office_id."' ";
				$query = $this->db->query($qSql);
				if($query->num_rows() > 0)
				{
					$res=$query->row_array();
					
					$to_email = $token['assigned_to_email'].", ".$l2_email_off;
					$ecc = array();
					$ecc[] = $res["cc_email_id"];
			
					//////////////////
					
					$email_subject = $res["email_subject"]. " " .$fusion_id.", " .$employee_name;
					$attach_file = "";
					
					$attach_file = $root_app_path ."assets/docs_master/".$fusion_id."_confirmation_form.xlsx";
					copy($file_location, $attach_file);
					
					$nbody   = 'Dear <b>'.$to_name.'</b>,</br></br>
								This is to notify you that below mentioned employee has completed '.round($probation_period/30).' months from your team. Kindly fill up the attached assessment sheet and score him on basis of their last '.round($probation_period/30).' months performance.
								Submit the file to ER/HR Team to get the confirmation status.		
								</br></br>';
					
					$nbody   .=	'Employee ID : ' .$fusion_id .'<br/>
								 Employee Name : ' .$employee_name .'<br/>
								 Department : ' .$employee_department .'<br/>
								 Date Of Joining : ' .$employee_joining .'<br/>
								 Probation Period : ' .round($probation_period/30) .' Months <br/>
								 Probation Ends : ' .$employee_probation .'<br/><br/>';
								
					$nbody   .=	'Regards, </br>
								<b>Fusion - Global HR Shared Services</b></br>';
								
					//echo  $nbody ."<br/><hr/><br/>";
					
					$this->Email_model->send_email_sox($user_id,$to_email,implode(',',$ecc),$nbody,$email_subject, $attach_file);
					
					sleep(2);
					
					unlink($attach_file);
				
				}
				
				
			}			
			
		}
		
		
		//*********************************************************************************************************************************
		// implement the option of auto removal from FEMS if a person does not join or login within 10 days after the ID is getting created 
		//*********************************************************************************************************************************
 
		public function term_new_hiring_drop_out(){
			
			$evt_date = CurrMySqlDate();
			$current_user=1;
			$event_master_id=7;
			$remarks="Hiring Drop Out";
			
			$uids='';
			
			$SQLtxt = "SELECT id,fusion_id,office_id,created_date,doj,fname,lname, datediff (now(), if(date(doj) IS NULL || date(doj) = '0000-00-00 00-00-00', date(created_date) ,date(doj)))as check_login_days FROM signin WHERE status = 4 HAVING check_login_days >=10 ";
			
			$result_query = $this->Common_model->get_query_result_array($SQLtxt);
			foreach($result_query as $crow){
					
					$log="System Auto Term. Not login 10 days from Hiring";
					
					$user_id=$crow['id'];
					$office_id=$crow['office_id'];
					$check_login_days=$crow['check_login_days'];
					
					if($office_id=="CEB" || $office_id=="MAN"){
						$log="System Auto Term. Not login 30 days from Hiring";
						if($check_login_days<30) continue;
					}
															
					//echo $user_id." / ";
					
					$start_date=CurrDate();
					$end_date = $start_date;
					$lwd = $this->Common_model->get_single_value("SELECT doj as value FROM signin where id='$user_id'");
					
					$_field_array = array(
						"user_id" => $user_id,
						"event_time" => $evt_date,
						"event_by" => $current_user,
						"event_master_id" => $event_master_id,
						"start_date" => $start_date,
						"end_date" => $end_date,
						"remarks" => $remarks,
						"log" => $log
					);
										
					$this->db->trans_start();
											/////////////////////////////
					$upData = array(
						'status' => '0',
						'disposition_id' => $event_master_id
					);
										
					$this->db->where('id', $user_id);
					$this->db->update('signin',$upData);
											
					//$this->db->delete('event_disposition', array('user_id' => $user_id,'event_master_id'=>'7', 'start_date'=>$start_date));
					$event_id = data_inserter('event_disposition',$_field_array);
					
					$_field_array = array(
						"user_id" => $user_id,
						"terms_date" => $evt_date,
						"comments" => $remarks,
						"t_type" => '9',
						"sub_t_type" => '2',
						"terms_by" => $current_user,
						"evt_date" => $evt_date,
						"lwd" => $lwd,
						"log" => $log
					);
					$_field_array['is_term_complete']="Y";
					$_field_array['update_by']=$current_user;
					$_field_array['update_date']=$evt_date;
					//$this->db->delete('terminate_users', array('user_id' => $user_id, 'terms_date'=>$evt_date));
					$row_id=data_inserter('terminate_users',$_field_array);
					
					$this->db->trans_complete();
			}
				
				
			// OR update users to deactivate 
			//$SQLtxt = "UPDATE signin SET status = '0', log='User deactivated as not logged in within 10 days' where id in(". $uids .")";
			//$this->db->query($SQLtxt);
			
		}
		
		
	
	
}

?>
