<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// FLAGS //
// 0 = AUTO HEADER AND FOOTER SETTING
// 1 = MANUAL HEADER FOOTER SETTING

class Letter extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		include_once APPPATH.'/third_party/mpdf-5.7/mpdf.php';
		$this->load->library('email');
		
	}
	
	private $is_success=0;
	
	public function index(){
		
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
			
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
		
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and office_id='".$oValue."'";
				else $_filterCond .= " And office_id='".$oValue."'";
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
		
			if($is_global_access=='1' || get_role_dir() =="admin" || get_dept_folder()=="hr"){
				if($filter_id == 1){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}elseif($filter_id == 2){
					$condition .=" ";
				}else{
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}
				
				$SQLtxt = "SELECT *,id,concat(fname,' ',lname)as name,(select fname from (SELECT * from signin) x where x.id = signin.assigned_to) as hod_name,
				    (select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select location from office_location WHERE signin.office_id = office_location.abbr )as location,fname,lname ,assigned_to ,
					doj,IF(doj <> '',(DATEDIFF(now(), doj)) ,0) as no_of_days from signin WHERE signin.status <> 0 HAVING no_of_days >= 180 
					AND id NOT IN (select user_id from info_confirmation) AND id NOT IN (". $current_user .") $condition $_filterCond ";
				
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
				doj,IF(doj <> '',(DATEDIFF(now(), doj)) ,0) as no_of_days from signin WHERE signin.status <> 0 HAVING no_of_days >= 180 
				AND id NOT IN (select user_id from info_confirmation) $condition $_filterCond ";
				
			}
			
			$data["pending_confirmation_list"] = $this->Common_model->get_query_result_array($SQLtxt);
			
			// APPROVED CONFIRMATION LIST
			
			if($is_global_access=='1' || get_role_dir() =="admin" || get_dept_folder()=="hr"){
				if($filter_id == 1){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}elseif($filter_id == 2){
					$condition .=" ";
				}else{
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}
				
				$SQLtxt = "SELECT *,id,concat(fname,' ',lname)as name,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = info_confirmation.added_by) as accepted_by,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as hod_name,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select location from office_location WHERE signin.office_id = office_location.abbr )as location,fname,lname ,assigned_to ,
					doj,IF(doj <> '',(DATEDIFF(now(), doj)) ,0) as no_of_days from signin INNER JOIN info_confirmation on info_confirmation.user_id = signin.id
					WHERE signin.status <> 0 HAVING no_of_days >= 180 $condition $_filterCond ";
			
			}else if(get_role_dir()=="tl" || get_dept_folder()=="trainer" || get_dept_folder()=="manager"){
				
				if($filter_id == 1){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}elseif($filter_id == 2){
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}else{
					$condition .=" AND signin.assigned_to= ". $current_user ."";
				}
				
				$SQLtxt = "SELECT *,id,concat(fname,' ',lname)as name,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = info_confirmation.added_by) as accepted_by,(select concat(fname,' ',lname) from (SELECT * from signin) x where x.id = signin.assigned_to) as hod_name,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select location from office_location WHERE signin.office_id = office_location.abbr )as location,fname,lname ,assigned_to ,
					doj,IF(doj <> '',(DATEDIFF(now(), doj)) ,0) as no_of_days from signin INNER JOIN info_confirmation on info_confirmation.user_id = signin.id
					WHERE signin.status <> 0 HAVING no_of_days >= 180 $condition $_filterCond ";
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
			 
			$SQLtxt = "SELECT * ,doj,IF(doj <> '',(DATEDIFF(now(), doj)) ,0) as no_of_days ,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(SELECT shname FROM department where signin.dept_id = department.id) as department_name from signin WHERE signin.id=". $user_id ."";
			$data["agentName"] = $this->Common_model->get_query_row_array($SQLtxt);
			 
			if($this->input->post('btnconf')=='Save'){
				
				if($total_score >= 80 ){
					$is_confirmed = true;
					$isconfirmed = 1;
				}else{
					$is_confirmed = false;
					$isconfirmed = 0;
				}
				
				 $is_mail_info = array('table_name' =>'info_confirmation',
									   'field_name'=>'is_mail_sent',
									   'user_id'=>$user_id);
				 
				 
				 if($is_confirmed == true ){
					$filename = 'Confirmation_'.$data["agentName"]['id'].'_'.$data["agentName"]['fusion_id'];
					$data['individual_user'] = $data["agentName"];
					
					$html = $this->load->view('letters/confirmation-letter', $data, TRUE); 
					$this->generate_pdf_files($html,$filename,$data['individual_user'],0,"Your Confirmation Letter",'Confirmation Letter',$is_mail_info);
					  					
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
				
				
				redirect('Letter/confirmation_list');
							
			}else{
				redirect('Letter/confirmation_list');
			}
			
			$this->load->view('dashboard',$data);
		
		}
	}
	
	
	
	//**********************************************************************8//
	//					CRON JOB BELOW
	//**********************************************************************8//
	
	public function get_agentdetail($agent_id){
		if(check_logged_in()){ 
		
			$SQltxt = "SELECT shname,doj from department INNER JOIN signin on signin.dept_id = department.id WHERE signin.id = ". $agent_id ."";
			$agent_detail = $this->Common_model->get_query_result_array($SQltxt);
			 
			echo json_encode($agent_detail);
			
		
		}
	}
	
	
	
	public function release_letter(){
			$filename = ''; 
			
			$SQLtxt = "select *,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select name from role where role.id= signin.role_id) as designation,(select location from office_location WHERE signin.office_id = office_location.abbr )as location,IF(released_date = '0000-00-00'|| released_date ='',0,(DATEDIFF(now(), released_date))) as no_of_days from user_resign INNER JOIN signin on signin.id = user_resign.user_id  INNER JOIN user_fnf ON signin.id =  user_fnf.user_id   WHERE office_id in ('KOL','HWH','BLR','GST') AND user_resign.resign_status in('AC') AND fnf_status='C' HAVING no_of_days=46";			
			$data['release_letter']  = $this->Common_model->get_query_result_array($SQLtxt);
			
			foreach($data['release_letter'] as $released_candidate){
				$filename = 'Release_letter_'.$released_candidate['id'].'_'.$released_candidate['fusion_id'];
				$data['individual_user'] = $released_candidate;
				
				$html = $this->load->view('letters/release_letter', $data, TRUE);
				
				$is_mail_info = array('table_name' =>'user_resign',
									   'field_name'=>'is_resign_email_sent',
									   'user_id'=>$released_candidate['user_id']);
				
				$this->generate_pdf_files($html,$filename,$released_candidate,0,'Your Release Letter is Attached','Release Letter',$is_mail_info);
		 
			}
	}
	
	
	
	public function appointment_letter_agents(){
			  
			$filename 		 = '';
			$attachment_path = '';
			
			$SQLtxt = "SELECT *,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select name from role where role.id= signin.role_id) as designation,(select location from office_location WHERE signin.office_id = office_location.abbr )as location, signin.id,fusion_id,(doj),concat(fname,' ',lname)as fullname,
					   (select name from role where role.id= signin.role_id) as designation,
					   IF(doj <> '',(DATEDIFF(now(), doj)) ,0) as no_of_days FROM signin
					   LEFT JOIN info_personal on info_personal.user_id = signin.id
					   LEFT JOIN info_payroll on info_payroll.user_id = signin.id
					   WHERE office_id in('KOL','HWH','BLR','GST')  AND signin.org_role_id =13
					   HAVING no_of_days = 16 order BY signin.id";
			
			$data['appointment_letter']  = $this->Common_model->get_query_result_array($SQLtxt);
			
			foreach($data['appointment_letter'] as $getjoining){ 
			
				$filename = 'Appointment_letter_'.$getjoining['id'].'_'.$getjoining['fusion_id'];
				$data['individual_user'] = $getjoining;
				$is_mail_info = array('table_name' =>'signin',
									   'field_name'=>'is_sent_appoint_letter',
									   'user_id'=>$getjoining['id']);
									   
				$html = $this->load->view('letters/appointment-letter-agent_new', $data, TRUE); 
				//echo $html;
				$this->generate_pdf_files($html,$filename,$getjoining,1,'Your Joining Letter is Attached','Appointment Letter Support',$is_mail_info);
				
		}
	}
	
	
	public function appointment_letter_nonagents(){
			 
		if(check_logged_in()){ 
			$filename 		 = '';
			$attachment_path = '';
			
			$SQLtxt = "SELECT *,(select email_id_off from info_personal WHERE info_personal.user_id = signin.id )as office_email,(select email_id_per from info_personal WHERE info_personal.user_id = signin.id )as personal_email,(select name from role where role.id= signin.role_id) as designation,(select location from office_location WHERE signin.office_id = office_location.abbr )as location, signin.id,fusion_id,(doj),concat(fname,' ',lname)as fullname,
					   (select name from role where role.id= signin.role_id) as designation,
					   IF(doj <> '',(DATEDIFF(now(), doj)) ,0) as no_of_days FROM signin
					   LEFT JOIN info_personal on info_personal.user_id = signin.id
					   LEFT JOIN info_payroll on info_payroll.user_id = signin.id
					   WHERE office_id in('KOL','HWH','BLR','GST')  AND signin.org_role_id <> 13
					   HAVING no_of_days = 16 order BY signin.id";
					   
			$data['appointment_letter']  = $this->Common_model->get_query_result_array($SQLtxt);
		    
			foreach($data['appointment_letter'] as $getjoining){
			
				$filename = 'Appointment_letter_'.$getjoining['id'].'_'.$getjoining['fusion_id'];
				$data['individual_user'] = $getjoining;
				$is_mail_info = array('table_name' =>'signin',
									   'field_name'=>'is_sent_appoint_letter',
									   'user_id'=>$getjoining['id']);
				
				$html = $this->load->view('letters/appointment_letter_nonagents', $data, TRUE); 
				//echo $html;
				$this->generate_pdf_files($html,$filename,$getjoining,1,'Your Joining Letter is Attached','Appointment Letter',$is_mail_info);
		
			}
		}
	}
	
	
	public function generate_pdf_files($html,$filename,$individual_user,$flags,$subject ='',$smtp_from_name='',$is_mail_info){
		
		ob_start();  // start output buffering
		$this->pdf = new mPDF(['mode' => 'utf-8', 'format' => 'A4-P']);
		$this->pdf->showImageErrors = true;
		
		$this->pdf->SetDisplayMode('fullwidth');
		/* $this->pdf->SetWatermarkText('FUSION BPO SERVICES');
		$this->pdf->showWatermarkText = true; */
		
		if($flags == 1){
			 if($individual_user['office_id'] == 'KOL' || $individual_user['office_id'] ==  'BLR' || $individual_user['office_id'] == 'GST'){
				$header_html = "<div class><img src='". APPPATH ."/../assets/images/logoxt.jpg' height='70px'></div>";
				
				$header_footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>XPLORE-TECH SERVICES PRIVATE LIMITED</span><br>
				<span style='text-align:center; font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
				<span style='text-align:center; font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
				<span style='text-align:center; font-size:11px'>www. xplore-tech.com</span><br>
				<span style='text-align:center; font-size:11px'>www.fusionbposervices.com</span></p>";
				
			 }else{
				$header_html = "<div><img src='". APPPATH ."/../assets/images/logohwr.png' height='70px'></div>";
				
				$header_footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>WINDOW TECHNOLOGIES PVT LTD.</span><br>
				<span style='text-align:center; font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
				<span style='text-align:center; font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
				<span style='text-align:center; font-size:11px'>www. xplore-tech.com</span><br>
				<span style='text-align:center; font-size:11px'>www.fusionbposervices.com</span></p>";
			 }
			
			$this->pdf->SetHTMLHeader($header_html,[], true);
			$this->pdf->SetHTMLFooter($header_footer,[], true);
		}
		
		
		$this->pdf->WriteHTML($html);
		
		$attachment_path = '/opt/lampp/htdocs/femsdev/uploads/letter_uploads/'.$filename.'.pdf';
		$this->pdf->Output($attachment_path, 'F');
		// Open this send mail for Testing Purpous.... else use the email model for email sending.. as email logs is created there
		//$this->send_mail_withattachment($individual_user,$attachment_path,$subject,$smtp_from_name,$is_mail_info);
		
		$this->Email_model->send_email_sox($individual_user['id'],$individual_user['office_email'],$individual_user['personal_email'],$ebody,$subject,$attachment_path,$from_email="noreply.fems@fusionbposervices.com",$from_name="Fusion FEMS", "Y",$is_mail_info);
		
		ob_clean();
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