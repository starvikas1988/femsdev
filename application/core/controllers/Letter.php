<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// FLAGS //
// 0 = AUTO HEADER AND FOOTER SETTING
// 1 = MANUAL HEADER FOOTER SETTING

class Letter extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Email_model');
		
	}
	
	private $is_success=0;
	
	public function index(){
		
	}
	
	
	public function view_confirmation_letter(){
			
						
			$filename = ''; 
			$user_id = $this->input->get('uid');
			$send_mail = $this->input->get('sm');
			
			//$SQLtxt = "SELECT *, (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(SELECT shname FROM department where signin.dept_id = department.id) as department_name from signin LEFT JOIN info_confirmation on info_confirmation.user_id = signin.id WHERE signin.id = '$user_id'";
			
			$SQLtxt = "SELECT *, (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(SELECT shname FROM department where signin.dept_id = department.id) as department_name from signin WHERE signin.id = '$user_id'";
			
			//echo $SQLtxt."<br/>";
						
			$data['individual_user']  = $crow = $this->Common_model->get_query_row_array($SQLtxt);
			
				$fname= $crow['fname'];
				$lname= $crow['lname'];
				//$total_score = $crow['total_score'];
				$filename = 'Confirmation_letter_'.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				$esubj='Confirmation Letter of '.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				
				$html = $this->load->view('letters/confirmation-letter', $data, TRUE); 
				
				//echo $crow['office_email'] . " >> ". $crow['personal_email'];
				
				$qSql="SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='".$user_id."');";
				$l1_email_off= $this->Common_model->get_single_value($qSql);
		
				$eto = array();
				$eto[] = $crow['personal_email'];
				$eto[] = $crow['office_email'];
				
				$ecc = array();
				$ecc[] = "employee.connect@fusionbposervices.com";
				$ecc[] = $l1_email_off;
				
				//implode(',',$eto)
				
				//if($total_score>=80){
					
					if($send_mail=="Y"){
						
						$attachment_path = $this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
						
												
						sleep(1);
						if (file_exists($attachment_path)){
																					
							$is_send=$this->Email_model->send_email_sox($crow['id'],implode(',',$eto),implode(',',$ecc),'Please find your attached Confirmation Letter',$esubj,$attachment_path);
							
							//echo $is_send;
							
							if($is_send == true){
								$SQLtxt ="UPDATE info_confirmation SET is_mail_sent ='Y' WHERE user_id=". $crow['id'] ."";
								$this->db->query($SQLtxt);
							}
						}
						
						$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "letter/confirmation_list";
						redirect($referer);
			
					}else{
						
						$this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
					}
					
					//redirect('Letter/view_confirmation_letter');
				//}else{
				//	
					//echo " Score less then 80";
				//}
	}

	public function view_ijp_letter(){
			
						
			$filename = ''; 
			$user_id = $this->input->get('uid');
			$send_mail = $this->input->get('sm');
			
			//$SQLtxt = "SELECT *, (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(SELECT shname FROM department where signin.dept_id = department.id) as department_name from signin LEFT JOIN info_confirmation on info_confirmation.user_id = signin.id WHERE signin.id = '$user_id'";
			
			$SQLtxt = "SELECT *, (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(SELECT shname FROM department where signin.dept_id = department.id) as department_name from signin WHERE signin.id = '$user_id'";
			
			//echo $SQLtxt."<br/>";
						
			$data['individual_user']  = $crow = $this->Common_model->get_query_row_array($SQLtxt);
						
			$role_id = $crow['role_id'];

			// $role = 

			$SQLtxt = "SELECT name FROM role WHERE id = '$role_id'";
			
			//echo $SQLtxt."<br/>"; 
						
			$data['role']  = $this->Common_model->get_query_row_array($SQLtxt);
			// print_r($data['role']);
			// exit;
			
				$fname= $crow['fname'];
				$lname= $crow['lname'];
				//$total_score = $crow['total_score'];
				$filename = 'IJP_letter_'.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				$esubj='IJP Letter of '.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				
				$html = $this->load->view('letters/ijp-letter', $data, TRUE); 
				
				//echo $crow['office_email'] . " >> ". $crow['personal_email'];
				
				$qSql="SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='".$user_id."');";
				$l1_email_off= $this->Common_model->get_single_value($qSql);
		
				$eto = array();
				$eto[] = $crow['personal_email'];
				$eto[] = $crow['office_email'];

				$ecc = array();
				$ecc[] = "employee.connect@fusionbposervices.com";
				$ecc[] = $l1_email_off;
				
				//implode(',',$eto)
				
				//if($total_score>=80){
					
					if($send_mail=="Y"){
						
						$attachment_path = $this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
						
												
						sleep(1);
						if (file_exists($attachment_path)){
																					
							$is_send=$this->Email_model->send_email_sox($crow['id'],implode(',',$eto),implode(',',$ecc),'Please find your attached IJP Letter',$esubj,$attachment_path);
							
							//echo $is_send;
							
						}
						
						$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "progression";
						redirect($referer);
			
						
					}else{
						
						$this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
					}
					
					//redirect('Letter/view_confirmation_letter');
				//}else{
				//	
					//echo " Score less then 80";
				//}
	}

	public function view_warning_letter(){
			
						
			$filename = ''; 
			$user_id = $this->input->get('uid');
			$send_mail = $this->input->get('sm');
			
						
			$SQLtxt = "SELECT *, (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(SELECT shname FROM department where signin.dept_id = department.id) as department_name from signin WHERE signin.id = '$user_id'";
			
			//echo $SQLtxt."<br/>";
						
			$data['individual_user']  = $crow = $this->Common_model->get_query_row_array($SQLtxt);
	
			$role_id = $crow['role_id'];

			// $role = 

			$SQLtxt = "SELECT name FROM role WHERE id = '$role_id'";
			
			//echo $SQLtxt."<br/>"; 
						
			$data['role']  = $this->Common_model->get_query_row_array($SQLtxt);
			// print_r($data['role']);
			// exit;
			
				$fname= $crow['fname'];
				$lname= $crow['lname'];
				//$total_score = $crow['total_score'];
				$filename = 'Warning_letter_'.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				$esubj='IJP Letter of '.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				
				$html = $this->load->view('letters/warning-letter', $data, TRUE); 
				
				//echo $crow['office_email'] . " >> ". $crow['personal_email'];
				
				$qSql="SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='".$user_id."');";
				$l1_email_off= $this->Common_model->get_single_value($qSql);
		
				$eto = array();
				$eto[] = $crow['personal_email'];
				$eto[] = $crow['office_email'];
				
				$ecc = array();
				$ecc[] = "employee.connect@fusionbposervices.com";
				$ecc[] = $l1_email_off;
				
				//implode(',',$eto)
				
				//if($total_score>=80){
					
					if($send_mail=="Y"){
						
						$attachment_path = $this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
						
												
						sleep(1);
						if (file_exists($attachment_path)){
																					
							$is_send=$this->Email_model->send_email_sox($crow['id'],implode(',',$eto),implode(',',$ecc),'Please find your attached Warning Letter',$esubj,$attachment_path);
							
							//echo $is_send;
						}
						
						$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "letter/confirmation_list";
						redirect($referer);
			
						
					}else{
						
						$this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
					}
		
	}		
	
	
	public function confirmation_list(){
		if(check_logged_in()){ 
			
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$data["aside_template"] = "letters/aside.php";
			$data["content_template"] = "letters/confirmation_form_new.php";
			
			$data["is_role_dir"]=$is_role_dir;
			$filter_id = $this->uri->segment(3);
			$condition ='';
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
		
			if($is_global_access!='1'){
				if($oValue=="") $oValue=$user_office_id;
			}
			$data['oValue']=$oValue;
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
			
			//if($is_global_access!=1) $_filterCond .=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%','KOL','HWH','BLR','CHE','NOI','%') )";
			
			if($oValue!="ALL IND" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and office_id='".$oValue."'";
				else $_filterCond .= " And office_id='".$oValue."'";
			}
			
			
			if($is_global_access=='1'){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
		$SQLtxt ="";
		
			if($is_global_access=='1' || get_role_dir() =="admin" || get_dept_folder()=="hr"){
				if($filter_id == 1){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}elseif($filter_id == 2){
					$condition .=" ";
				}else{
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}
				
				 $SQLtxt = "SELECT *,id,concat(fname,' ',lname)as name,(select fname from (SELECT * from signin) x where x.id = signin.assigned_to) as hod_name,
				    (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email, (select location from office_location WHERE signin.office_id = office_location.abbr )as location, fname,lname ,assigned_to ,
					doj, IF(doj IS NOT NULL ,(DATEDIFF(now(), doj)) ,0) as no_of_days from signin LEFT JOIN info_confirmation on info_confirmation.user_id = signin.id WHERE signin.status = 1 and office_id in('KOL','HWH','BLR','CHE','NOI') AND id NOT IN (select user_id from info_confirmation) AND id NOT IN (". $current_user .") $condition $_filterCond HAVING no_of_days >= 180 and no_of_days <=300";
				
			}else if(get_role_dir()=="tl" || get_dept_folder()=="trainer" || get_dept_folder()=="manager"){
				
				if($filter_id == 1){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}elseif($filter_id == 2){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}else{
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}
				
				$SQLtxt = "SELECT *,id,concat(fname,' ',lname)as name,(select fname from (SELECT * from signin) x where x.id = signin.assigned_to) as hod_name,
				    (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select location from office_location WHERE signin.office_id = office_location.abbr )as location,fname,lname ,assigned_to ,
				doj,IF(doj IS NOT NULL ,(DATEDIFF(now(), doj)) ,0) as no_of_days from signin LEFT JOIN info_confirmation on info_confirmation.user_id = signin.id  WHERE signin.status = 1 and office_id in('KOL','HWH','BLR','CHE','NOI') AND id NOT IN (select user_id from info_confirmation) $condition $_filterCond HAVING HAVING no_of_days >= 180 and no_of_days <=300";
				
			}
			
			$data["pending_confirmation_list"] = $this->Common_model->get_query_result_array($SQLtxt);
			
			// APPROVED CONFIRMATION LIST
			 $SQLtxt ="";
			if($is_global_access=='1' || get_role_dir() =="admin" || get_dept_folder()=="hr"){
				if($filter_id == 1){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}elseif($filter_id == 2){
					$condition .=" ";
				}else{
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}
				
				$SQLtxt = "SELECT *,id,concat(fname,' ',lname)as name,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = info_confirmation.added_by) as accepted_by,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as hod_name,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select location from office_location WHERE signin.office_id = office_location.abbr )as location,fname,lname ,assigned_to ,
					doj,IF(doj IS NOT NULL,(DATEDIFF(now(), doj)) ,0) as no_of_days from signin INNER JOIN info_confirmation on info_confirmation.user_id = signin.id
					WHERE 1 $condition $_filterCond ";
			
				//echo $SQLtxt;
			
			}else if(get_role_dir()=="tl" || get_dept_folder()=="trainer" || get_dept_folder()=="manager"){
				
				if($filter_id == 1){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}elseif($filter_id == 2){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}else{
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}
				
				$SQLtxt = "SELECT *,id,concat(fname,' ',lname)as name,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = info_confirmation.added_by) as accepted_by,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as hod_name,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select location from office_location WHERE signin.office_id = office_location.abbr )as location,fname,lname ,assigned_to ,
					doj,IF(doj IS NOT NULL,(DATEDIFF(now(), doj)) ,0) as no_of_days from signin INNER JOIN info_confirmation on info_confirmation.user_id = signin.id
					WHERE signin.status = 1 $condition $_filterCond ";
			}
			
			$data["approved_confirmation_list"] = $this->Common_model->get_query_result_array($SQLtxt);
			
			$data['oValue'] = $oValue;
			$this->load->view('dashboard',$data);
		
		}
	}
	
	
	public function confirmation(){
		if(check_logged_in()){ 
				 
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
		
			$data["is_role_dir"] = get_role_dir();
			$tbl=""; 
			
			$user_id = $this->input->post('user_id');
			$conf_date = $this->input->post('conf_date');
			$audit_date = date('Y-m-d');
			$score_1 = $this->input->post('score_1');
			$score_2 = $this->input->post('score_2');
			$score_3 = $this->input->post('score_3');
			$score_4 = $this->input->post('score_4');
			$score_5 = $this->input->post('score_5');
			$score_6 = $this->input->post('score_6');
			$score_7 = $this->input->post('score_7');
			$score_8 = $this->input->post('score_8');
			$score_9 = $this->input->post('score_9');
			$score_10 = $this->input->post('score_10');
			$total_score = $this->input->post('total_score'); 
			$remarks = $this->input->post('user_remarks');
			$is_confirmed=false;
			$isconfirmed =''; 
			
			$data["aside_template"] = "letters/aside.php";
            $data["content_template"] = "letters/confirmation_form.php";
			 
			$SQLtxt = "SELECT * ,IF(doj is not null ,(DATEDIFF(now(), doj)) ,0) as no_of_days ,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(SELECT shname FROM department where signin.dept_id = department.id) as department_name from signin WHERE signin.id=". $user_id ."";
						
			$data["individual_user"] = $agentData = $this->Common_model->get_query_row_array($SQLtxt);
			 
			if($this->input->post('btnconf')=='Save'){
				
				if($total_score >= 80 ){
					$is_confirmed = true;
					$isconfirmed = 1;
				}else{
					$is_confirmed = false;
					$isconfirmed = 0;
				}
							 				 
				
				$SQLtxt = "SELECT * FROM info_confirmation WHERE user_id=". $user_id ."";
				$fields = $this->Common_model->get_query_row_array($SQLtxt);
				
				if(empty($fields) && $fields['user_id'] != $user_id){
					$SQLtxt ="INSERT INTO info_confirmation (user_id,confirmation_date,score_1,score_2,score_3,score_4,score_5,score_6,score_7,score_8,score_9,score_10,total_score,remarks,is_confirmed,added_date,added_by)
						VALUES(". $user_id .",'". date("Y-m-d", strtotime($conf_date)) ."',". $score_1 .",". $score_2 .",". $score_3 .",". $score_4 .",". $score_5 .",". $score_6 .",". $score_7 .",". $score_8 .",". $score_9 .",". $score_10 .",". $total_score .",'". $remarks ."',". $isconfirmed .",'". date("Y-m-d") ."',". $current_user .")";
				}else{
					$SQLtxt = "UPDATE info_confirmation SET confirmation_date='". date("Y-m-d", strtotime($conf_date)) ."',score_1=". $score_1 .",score_2=". $score_2 .",score_3=". $score_3 .",score_4=". $score_4 .",score_5=". $score_5 .",score_6=". $score_6 .",score_7=". $score_7 .",score_8=". $score_8 .",score_9=". $score_9 .",score_10=". $score_10 .",total_score=". $total_score .",remarks='". $remarks ."',is_confirmed=". $isconfirmed .",added_date='". date("Y-m-d") ."',added_by=". $current_user ."";
				}
				
				$this->db->query($SQLtxt);
				
				if($is_confirmed == true ){
					
					
					$fname= $agentData['fname'];
					$lname= $agentData['lname'];
					$filename = 'Confirmation_letter_'.$fname.'_'.$lname.'_'.$agentData['fusion_id'];
					$esubj='Confirmation Letter of '.$fname.'_'.$lname.'_'.$agentData['fusion_id'];
					
					$eto = array();
					$eto[] = $agentData['personal_email'];
					$eto[] = $agentData['office_email'];
										
					$qSql="SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='".$user_id."');";
					$l1_email_off= $this->Common_model->get_single_value($qSql);					
					$ecc = array();
					$ecc[] = "employee.connect@fusionbposervices.com";
					$ecc[] = $l1_email_off;
					
					//implode(',',$eto)
					
					$html = $this->load->view('letters/confirmation-letter', $data, TRUE); 
					$attachment_path = $this->generate_pdf_files($html,$filename,$agentData,1,"Y");
					sleep(1);
					
					if(file_exists($attachment_path)){
					
						$is_send=$this->Email_model->send_email_sox($agentData['id'],implode(',',$eto),implode(',',$ecc),'Please find your attached Confirmation Letter',$esubj,$attachment_path);
						
						if($is_send == true){
							$SQLtxt ="UPDATE info_confirmation SET is_mail_sent ='Y' WHERE user_id=". $agentData['id'] ."";
							$this->db->query($SQLtxt);
						}
					}
							  
				 }
				 
				redirect('Letter/confirmation_list');
							
			}else{
				redirect('Letter/confirmation_list');
			}
			
			$this->load->view('dashboard',$data);
		
		}
	}
	

	public function get_agentdetail($agent_id){
		if(check_logged_in()){ 
		
			$SQltxt = "SELECT shname,doj from department INNER JOIN signin on signin.dept_id = department.id WHERE signin.id = ". $agent_id ."";
			$agent_detail = $this->Common_model->get_query_result_array($SQltxt);
			 
			echo json_encode($agent_detail);
			
		
		}
	}
	
	
	public function view_appointment_letter(){
			
			$filename = ''; 
			$user_id = $this->input->get('uid');
			$send_mail = $this->input->get('sm');
			
			
			$SQLtxt = "SELECT *,info_personal.user_id,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select name from role where role.id= signin.role_id) as designation,(select office_name from office_location WHERE signin.office_id = office_location.abbr )as location, signin.id, fusion_id, concat(fname,' ',lname)as fullname,
			   IF(doj IS NOT NULL,(DATEDIFF(now(), doj)) ,0) as no_of_days FROM signin
			   LEFT JOIN info_personal on info_personal.user_id = signin.id
			   LEFT JOIN info_payroll on info_payroll.user_id = signin.id
			   WHERE office_id in('KOL','HWH','BLR','CHE','NOI') AND signin.id = '$user_id'
			   HAVING no_of_days >= 16 order BY signin.id";
			
			
				$data['individual_user']  = $crow = $this->Common_model->get_query_row_array($SQLtxt);
				$org_role_id = $crow['org_role_id'];
			
				$fname = $crow['fname'];
				$lname = $crow['lname'];
				
				$filename = 'Appointment_letter_'.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				$esubj='Appointment Letter of '.$fname.'_'.$lname.'_'.$crow['fusion_id'];
				
				$eto = array();
				$eto[] = $crow['personal_email'];
				$eto[] = $crow['office_email'];
									
				//$qSql="SELECT email_id_off as value FROM `info_personal` WHERE user_id = (select assigned_to from signin where id='".$user_id."');";
				//$l1_email_off= $this->Common_model->get_single_value($qSql);					
				//$ecc = array();
				//$ecc[] = "employee.connect@fusionbposervices.com";
				//$ecc[] = $l1_email_off;
				
				$ecc = "employee.connect@fusionbposervices.com";
				
					//implode(',',$eto)
					
					if($org_role_id==13){					   
						$html = $this->load->view('letters/appointment-letter-agent_new', $data, TRUE); 
					}else{
						$html = $this->load->view('letters/appointment_letter_nonagents', $data, TRUE); 
						//echo $html;
					}
				
					if($send_mail=="Y"){
						
						$attachment_path = $this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
						sleep(1);
						
						if(file_exists($attachment_path)){
							$is_send=$this->Email_model->send_email_sox($crow['id'],implode(',',$eto),$ecc,'Please find your attached Appointment Letter',$esubj,$attachment_path);
							
							if($is_send == true){
								$SQLtxt ="UPDATE signin SET is_sent_appoint_letter='Y' WHERE id=". $crow['id'] ."";
								$this->db->query($SQLtxt);
							}
						}
						
						$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "users/manage";
						redirect($referer);
						
					}else{
						
						$this->generate_pdf_files($html,$filename,$crow,1,$send_mail);
					}
					
	}
	
	
	public function job_appointment_letter(){
			 
			$filename 		 = '';
			$attachment_path = '';
			//KOL,BLR,CHE,HWH,NOI
			$SQLtxt = "SELECT *,info_personal.user_id,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select name from role where role.id= signin.role_id) as designation,(select location from office_location WHERE signin.office_id = office_location.abbr )as location, signin.id, fusion_id, concat(fname,' ',lname)as fullname,
			   IF(doj IS NOT NULL,(DATEDIFF(now(), doj)) ,0) as no_of_days FROM signin
			   LEFT JOIN info_personal on info_personal.user_id = signin.id
			   LEFT JOIN info_payroll on info_payroll.user_id = signin.id
			   WHERE office_id in('KOL','HWH','BLR','CHE','NOI') and status in (1,7) and is_sent_appoint_letter='N' and gross_pay>0 and payroll_type not in (2,3,4,5,6) 
			   HAVING no_of_days >= 16 and no_of_days <= 180  order BY signin.id ";
			
			$data['appointment_letter']  = $this->Common_model->get_query_result_array($SQLtxt);
						
			foreach($data['appointment_letter'] as $getjoining){
				
				$org_role_id=$getjoining['org_role_id'];
				$fname= $getjoining['fname'];
				$lname= $getjoining['lname'];
				$gross_pay = $getjoining['gross_pay'];
									
				if($gross_pay>0){
					
					//$filename = 'Appointment_letter_'.$fname.'_'.$getjoining['fusion_id'];
					$filename = 'Appointment_letter_'.$getjoining['fusion_id'];
					$esubj='Appointment Letter of '.$fname.' '.$lname.' '.$getjoining['fusion_id'];
					$ebody='Please find your attached Appointment Letter';
					$data['individual_user'] = $getjoining;
															
					if($org_role_id==13){					   
						$html = $this->load->view('letters/appointment-letter-agent_new', $data, TRUE); 
					}else{
						$html = $this->load->view('letters/appointment_letter_nonagents', $data, TRUE); 
						//echo $html;
					}
					
					$attachment_path = $this->generate_pdf_files($html,$filename,$getjoining,1,'Y');
					sleep(2);
					chmod($attachment_path, 0777);
					sleep(5);
					if (file_exists($attachment_path)){
						
						//echo $attachment_path;
						
						$eto = array();
						$eto[] = $getjoining['personal_email'];
						$eto[] = $getjoining['office_email'];
						$ecc = "employee.connect@fusionbposervices.com";
												
						$is_send=$this->Email_model->send_email_sox($getjoining['user_id'],implode(',',$eto),$ecc,$ebody,$esubj,$attachment_path);
						
						if($is_send == true){
							$SQLtxt ="UPDATE signin SET is_sent_appoint_letter ='Y' WHERE id=". $getjoining['user_id'] ."";
							$this->db->query($SQLtxt);
						}
					}																									
				
				}else{
					echo "zero gross";
				}
			}
			
			echo "done";
	}
	
		
	public function generate_pdf_files($html,$filename,$individual_user,$flags,$isSave='Y'){
		
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
						
		// Open this send mail for Testing Purpous.... else use the email model for email sending.. as email logs is created there
		//$this->send_mail_withattachment($individual_user,$attachment_path,$subject,$smtp_from_name,$is_mail_info);
		
	}
	
	
	
	public function send_mail_withattachment($candiate_details,$attachments,$type_subject ='',$smtp_from_name='',$is_mail_info){
       $message = "Welcome to Fusion BPO Services.";
        
	  $this->email->set_newline("\r\n");

            $config['smtp_from_name'] = $smtp_from_name;
            $config['wordwrap'] = TRUE;
			$config['useragent'] = 'FEMS-DEV';
            $config['newline'] = "\r\n";
            $config['mailtype'] = 'html';  
            $config['smtp_timeout'] = '5';  
            $config['charset']    = 'utf-8';
 
        $this->email->initialize($config);

        $this->email->from('noreply.fems@fusionbposervices.com', $config['smtp_from_name']);
		//*********************************************************************************
		//  function send_mail_withattachment($candiate_details,$attachments,$type_subject ='',$smtp_from_name=''){
		//  candiate_details['office_email'] && candiate_details['personal_email'] to be added in send to section 
		
        $this->email->to('cybertechnologiesinfo@gmail.com,vivek.prasad@fusionbposervices.com');
        $this->email->cc('');
        $this->email->bcc('');
        $this->email->subject($type_subject);
        $this->email->message($message);
        $this->email->set_mailtype("html");
 
        $this->load->helper('path');
       // echo $path = set_realpath('./image/');
        
       $this->email->attach($attachments); 
        
        if($to == 1){
            $this->email->message($this->load->view('letters/templates/template.php',$data,true));
        }else {
            $this->email->message($this->load->view('letters/templates/template.php',$data,true));
        } 
        
       if ( !$this->email->send())
        { 
			echo "Mail Not send";
			$this->email->print_debugger();
			
        }else{
			if($is_mail_info['table_name'] != ''){
				
				$field =   $is_mail_info['table_name'] == 'signin' ? 'id' : 'user_id';
				
				echo $SQLtxt ="UPDATE ". $is_mail_info['table_name'] ." SET ". $is_mail_info['field_name'] ." ='Y' WHERE ". $field ."=". $is_mail_info['user_id'] ."";
				$this->db->query($SQLtxt);
			}
			
			$this->email->clear(TRUE);
			
		}
       
   }
	
	
	
	
}


?>