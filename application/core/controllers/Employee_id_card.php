<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_id_card extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    private $aside = "Employee_id_card/aside.php";
	 
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->model('Email_model');
		
	 }
	
	public function index()
	{		 
		redirect('employee_id_card/card');	 
	}
	
	public function configure_idcard_mail($type="")
	{		 
		$mailArray = array();
		
		// PRRINTING REQUEST MAIL AFTER APPROVAL MAIL ID
		$mailArray['A'] = "sachin.paswan@fusionbposervices.com";
		$mailArray['C'] = $mailArray['A'];
		
		return !empty($mailArray[$type]) ? $mailArray[$type] : "";
	}
	
    public function card()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		$got_refer = "";
		if(!empty($this->uri->segment(3)) && $this->uri->segment(3) == 'home'){ 
			$got_refer = "home";
		}
		$data['id_refer'] = $got_refer;
		
		//============== IF TABLE NOT AVAILABLE CREATE
		$sqlCheck = "SELECT count(*) as value from info_document_upload WHERE user_id = '$current_user'";
		$counterCheck = $this->Common_model->get_single_value($sqlCheck);
		if($counterCheck < 1){
			$dataCounter = [ 'user_id' => $current_user ];
			data_inserter('info_document_upload', $dataCounter);
		}
		
		$sqlCheck = "SELECT count(*) as value from info_personal WHERE user_id = '$current_user'";
		$counterCheck = $this->Common_model->get_single_value($sqlCheck);
		if($counterCheck < 1){
			$dataCounter = [ 'user_id' => $current_user ];
			data_inserter('info_personal', $dataCounter);
		}
		
		
		// CHECK ID CARD REUEST STATUS
		$csql = "SELECT * FROM employee_id_card as c WHERE user_id = '$current_user' AND is_active = '1' ORDER BY ID DESC LIMIT 1";
		$check = $this->Common_model->get_query_row_array($csql);
		$count = 0;
		if(!empty($check['id'])){
			$count = 1;
		}
		$data['check_details'] = $check;
		$data['check_entry'] = $count;
		
		// ID CARD INFO
		$fusion_id = "";
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";		
		$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);
		if(!empty($agent_details['fusion_id'])){ $fusion_id = $agent_details['fusion_id']; }
		

		$data["aside_template"] = "employee_id_card/aside.php";
		$data["content_template"] = "employee_id_card/idcard.php";
		$data["content_js"] = "employee_id_card/idcard_js.php";
		
		if($got_refer == 'home'){  
			 $this->load->view('dashboard_single_col',$data);
		} else {
			$this->load->view('dashboard',$data);			
		}
		
	 
	}
	
	public function generateCard()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		
		//$this->load->library('m_pdf');
		require_once APPPATH.'/third_party/mpdf-5.7/mpdf.php';		
		$type = 'I';
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);		
		$fusion_id = $agent_details['fusion_id'];
		
		if(!empty($this->uri->segment(4))){ 
			$fusion_id = $this->uri->segment(4); 
			$agent_sql = "SELECT * from signin WHERE fusion_id = '$fusion_id'";
			$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);
		}
		
		if(is_view_profile($fusion_id)==false) redirect(base_url()."profile","refresh");
		
		if(!empty($this->uri->segment(3))){ 
			if($this->uri->segment(3) == 'download'){ $type = 'D'; } 
			if($this->uri->segment(3) == 'view'){ $type = 'I'; }
		}	
			
		$currentImage = "assets/idcard/profile.jpg";
		$idFolder = FCPATH ."uploads/id_card/";
		$agentCard = $fusion_id ."/" ."id_".$fusion_id.".png";
		if(file_exists($idFolder .$agentCard))
		{
			$currentImage = "uploads/id_card/".$agentCard;
		}
		$data['id_card'] = $currentImage;
		
		$html=$this->load->view('employee_id/template_1', $data,true);
	
		if((!empty($fusion_id) && $type == 'F') || $type == 'I' || $type == 'D')
		{
			//if($type == 'F')
			//{
				$pdfFilePath = "id_card_" .$fusion_id.".pdf";
				$uploadDir = FCPATH .'uploads/id_card/'.$fusion_id.'/';
				$finalDir = $uploadDir .$pdfFilePath;
				if (!file_exists($uploadDir)) {
					mkdir($uploadDir, 0777, true);
				}				
			//}			
			//$pdf = new m_pdf();
			//$pdf->pdf->AddPage('L');			
			//$pdf->pdf->shrink_tables_to_fit;;			
			//$pdf->pdf->WriteHTML($html);			
			//$pdf->pdf->Output($finalDir, $type);			
			
			$pdf = new mpdf('utf-8', array(80,115),0, '', 0, 0, 0, 0, 0, 0);			
			$pdf->SetHTMLFooter('
			<div style="width:100%;text-align:center;"><img src="assets/idcard/fusion-logo.png" style="max-width:100%;height:90px;" alt=""></div>
			<div style="width:100%;margin-top:10px"><img src="assets/idcard/bottom-divider.jpg" style="width:100%;margin:0 0 0px 0;" alt=""></div>
			');			
			$pdf->WriteHTML($html);
			$pdf->Output($finalDir, 'F');
			if($type != 'F'){
			$pdf->Output($pdfFilePath, $type);
			}
		}
	 
	}
		
	
	function imageCropping()
	{	
		$data = $_POST['image'];		
		$fusion_id = $this->input->post('fusionid');
		
		list($type, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
		
		// ID CARD DIRECTORY
		//$imageName = "id_" .$fusion_id ."_" .time().'.png';
		$imageName = "id_" .$fusion_id.'.png';		
		$idFolder = FCPATH ."uploads/id_card/";
		$idDir = $idFolder .$fusion_id;
		if(!file_exists($idDir)){ mkdir($idDir, 0777, true); }
		$uploadDir = $idDir ."/" .$imageName;		
		$imageName2 = "backup_" .$fusion_id.'_'.strtotime('now').'.png';
		$uploadDir2 = $idDir ."/" .$imageName2;
		
		// UPLOAD TO PHOTO DIRECTORY
		$setDir = FCPATH ."uploads/photo/";
		$uploadDirSet = $setDir .$imageName;
		file_put_contents($uploadDirSet, $data);
		
		// FOR PROFILE PHOTO
		$updatePhoto = [ "photograph" => $imageName ];
		$this->db->where('id', $querySubmit['id']);
		$this->db->where('user_id', $current_user);
		$this->db->update('info_document_upload', $updatePhoto);
		
		
		// FOR EMPLOYEE ID CARD		
		$link = $data;
		$current_user = get_user_id();
        $imglink = str_replace(FCPATH,"",$uploadDirSet);
		$datArray = array(
	         'user_id' => $current_user,
	         'status' => 'P',
	         'image_link' => $imglink,
	         'image_raw' => $imageName2,
	         'is_active' => 0,
	         'created_at' => CurrMySqlDate(),
	         'created_by' => $current_user,
	         'logs' => get_logs()
	    );
		
		$sqlSubmit = "SELECT * from employee_id_card WHERE user_id = '$current_user' AND is_active='0' ORDER BY ID DESC LIMIT 1";
		$querySubmit = $this->Common_model->get_query_row_array($sqlSubmit);
		if(!empty($querySubmit['id'])){			
			$this->db->where('id', $querySubmit['id']);
			$this->db->where('user_id', $current_user);
			$this->db->update('employee_id_card', $datArray);
			file_put_contents($uploadDir2, $data);		
		} else {		
			$rowid = data_inserter('employee_id_card',$datArray);
			file_put_contents($uploadDir2, $data);
		}		
		
		//$this->generateCard();
		
	}
	
	
	
	//==========================================================================================//
    //  CARD REQUEST
    //==========================================================================================//
	
	function requestCardSubmit()
	{	
		$currentUser = $this->input->post('agent_id');
		$is_idcard = $this->input->post('is_idcard');
		$is_refer = $this->input->post('is_refer');
		//$is_apply = $this->input->post('request_apply');
		if($is_idcard == 'Yes'){
			$dataUpdate = [ "is_idcard" => $is_idcard ];
			$this->db->where('user_id', $currentUser);
			$this->db->update('info_personal', $dataUpdate);
		} else {
			$sqlSubmit = "SELECT * from employee_id_card WHERE user_id = '$currentUser' AND is_active='0' ORDER BY ID DESC LIMIT 1";
			$querySubmit = $this->Common_model->get_query_row_array($sqlSubmit);
			if(!empty($querySubmit['id'])){
				$dataUpdate = [ "is_active" => 1 ];
				$this->db->where('id', $querySubmit['id']);
				$this->db->where('user_id', $currentUser);
				$this->db->update('employee_id_card', $dataUpdate);
				$this->send_notification_email($querySubmit['id'],'P', $currentUser);
			}
		}
		if(!empty($is_refer)){
			redirect(base_url('home'));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function skipCardRequest()
	{	
		$this->session->set_userdata('skipUploadIDCard', 'Y');
		redirect(base_url('home'));
	}
	
	
	function id_card_request()
	{	
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$got_refer = "";
		if(!empty($this->uri->segment(3)) && $this->uri->segment(3) == 'home'){ 
			$got_refer = "home";
		}
		$data['id_refer'] = $got_refer;
		
		$data["aside_template"] = "employee_id_card/aside.php";
		$data["content_template"] = "employee_id_card/id_card_request.php";
		$data["content_js"] = "employee_id_card/id_card_list_js.php";
		
		$data["cardStatus"] = $this->status_id_card();
		
		$sqlLocation = "SELECT * from office_location WHERE is_active = '1'";
		$data['locationList'] = $this->Common_model->get_query_result_array($sqlLocation);
		
		$extraOfficeFilter = "";		
		$officeID = $user_office_id;
		if(!empty($this->input->get('office_id')) && $this->input->get('office_id') != "ALL"){
			$officeID = $this->input->get('office_id');			
		}
		if(!empty($officeID)){
			$extraOfficeFilter = " AND s.office_id = '$officeID'";
		}
		$data['officeID'] = $officeID;
		
		
		$current = 'pending';
		$extraFilter = " AND e.status IN ('P')";
		if(!empty($this->uri->segment(3)) && $this->uri->segment(3) == 'all'){
			$current = 'all';
			$extraFilter = "";
		}
		$data['currentPage'] = $current;
		
		$myDownlines = $this->get_downlines();		
		$qSql = "SELECT e.*, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as employee_name, 
				CONCAT(sl.fname, ' ', sl.lname) as tl_name, sl.fusion_id as tl_fusion_id, r.name as designation, d.shname as department
				FROM employee_id_card as e
				INNER JOIN signin as s ON s.id = e.user_id
				LEFT JOIN department as d ON s.dept_id = d.id
				LEFT JOIN role as r ON r.id = s.role_id
				LEFT JOIN signin as sl ON sl.id = s.assigned_to
				WHERE e.is_active = '1' AND s.id IN ($myDownlines) $extraFilter $extraOfficeFilter";
		$data['main'] = $this->Common_model->get_query_result_array($qSql);		
		
		$this->load->view('dashboard',$data);
	}
	
	
	function id_card_list()
	{	
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$got_refer = "";
		if(!empty($this->uri->segment(3)) && $this->uri->segment(3) == 'home'){ 
			$got_refer = "home";
		}
		$data['id_refer'] = $got_refer;
		
		$data["aside_template"] = "employee_id_card/aside.php";
		$data["content_template"] = "employee_id_card/id_card_request.php";
		$data["content_js"] = "employee_id_card/id_card_list_js.php";
		
		$data["cardStatus"] = $this->status_id_card();
		
		$sqlLocation = "SELECT * from office_location WHERE is_active = '1'";
		$data['locationList'] = $this->Common_model->get_query_result_array($sqlLocation);
		
		$extraFilter = "";		
		$officeID = $user_office_id;
		if(!empty($this->input->get('office_id')) && $this->input->get('office_id') != "ALL"){
			$officeID = $this->input->get('office_id');			
		}
		if(!empty($officeID)){
			$extraFilter .= " AND s.office_id = '$officeID'";
		}
		$data['officeID'] = $officeID;
		
		$pageName = 'pending';
		$current = 'pending';
		if(!empty($this->uri->segment(3))){
			$current = $this->uri->segment(3);
		}
		$data['currentPage'] = $current;
		
		if($current == 'pending'){
			$extraFilter .= " AND e.status IN ('P')";
		}
		if($current == 'approved'){
			$pageName = 'Approved';
			$extraFilter .= " AND e.status IN ('A')";
		}
		if($current == 'printing'){
			$pageName = 'Printing Queue';
			$extraFilter .= " AND e.status IN ('T')";
		}
		if($current == 'distribute'){
			$pageName = 'Received Printed Copy';
			$extraFilter .= " AND e.status IN ('C')";
		}
		if($current == 'handover'){
			$pageName = 'Sent to HR';
			$extraFilter .= " AND e.status IN ('D')";
		}
		if($current == 'complete'){
			$pageName = 'Collected by Employee';
			$extraFilter .= " AND e.status IN ('H')";
		}
		if($current == 'rejected'){
			$pageName = 'Rejected';
			$extraFilter .= " AND e.status IN ('R')";
		}
		if($current == 'all'){
			$pageName = "";
			$extraFilter = "";
		}
		$data['pageName'] = $pageName;
		
		$qSql = "SELECT e.*, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as employee_name, 
				CONCAT(sl.fname, ' ', sl.lname) as tl_name, sl.fusion_id as tl_fusion_id, r.name as designation, d.shname as department
				FROM employee_id_card as e
				INNER JOIN signin as s ON s.id = e.user_id
				LEFT JOIN department as d ON s.dept_id = d.id
				LEFT JOIN role as r ON r.id = s.role_id
				LEFT JOIN signin as sl ON sl.id = s.assigned_to
				WHERE e.is_active = '1' $extraFilter";
		$data['main'] = $this->Common_model->get_query_result_array($qSql);
		
		$this->load->view('dashboard',$data);
	}
	
	
	//==========================================================================================//
    //  CARD REQUEST UPDATE LOGS
    //==========================================================================================//
	
	public function change_status() 
	{
		$remarks = '';
		$status_text='';
		$current_user = get_user_id();
		$created_at = date("Y-m-d");
		
	    $application_id = $this->input->post('application_id');
	    $remarks = $this->input->post('remarks');
	    $status = $this->input->post('status');
	    $status_text = $this->input->post('status_text');
	    $user_id = $this->input->post('user_id');

		//$application_id = "1";
		//$remarks = "Test";
		//$status = "A";
		
		// UPDATE STATUS
	    $qSql = "UPDATE employee_id_card SET status = '$status' WHERE id = $application_id";
	    $query=$this->db->query($qSql);

	    //SEND NOTIFICATION
	  	if($status == 'A' || $status == 'C' || $status == 'R'){
	  		$this->send_notification_email($application_id, $status, $current_user);	
	  	}
		
		if($status == 'H'){
			$dataUpdate = [ "is_idcard" => 'Yes' ];
			$this->db->where('user_id', $user_id);
			$this->db->update('info_personal', $dataUpdate);
	  	}

	    //if query successfull,update log table with remarks
		$logArray = [
			"application_id" => $application_id,
			"status" => $status,
			"remarks" => $remarks,
			"created_by" => $current_user,
			"created_at" => $created_at,
		];
		data_inserter('employee_id_card_log', $logArray);
		
	    echo true;
	    exit;
    }

	
	//==========================================================================================//
    //  NOTIFICATION MAIL
    //==========================================================================================//
	
    public function send_notification_email($application_id = '', $type = '', $user_id = '')
	{
		
		$from_email="noreply.fems@fusionbposervices.com";
		$from_name="Fusion FEMS";
		$nbody="";
		
		$sqlDetails = "SELECT e.*, s.office_id, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as employee_name, 
		               CONCAT(sl.fname, ' ', sl.lname) as tl_name, sl.fusion_id as tl_fusion_id, 
		               r.name as designation, d.shname as department, p.email_id_off, p.email_id_per, CONCAT(so.fname, ' ', so.lname) as sender_name, so.fusion_id as sender_fusion_id, pl.email_id_off, pl.email_id_per 
					   from employee_id_card as e
		               INNER JOIN signin as s ON s.id = e.user_id
					   LEFT JOIN info_personal as p ON p.user_id = s.id
					   LEFT JOIN department as d ON s.dept_id = d.id
					   LEFT JOIN role as r ON r.id = s.role_id
					   LEFT JOIN signin as sl ON sl.id = s.assigned_to
					   LEFT JOIN info_personal as pl ON pl.user_id = sl.id
					   LEFT JOIN signin as so ON so.id = '$user_id'
					   WHERE e.id = '$application_id'";
		$dataInfoAr = $this->Common_model->get_query_result_array($sqlDetails);
		
		if(!empty($dataInfoAr))
		{
			$dataInfo = $dataInfoAr[0];
			$currentDate = CurrDate();
			$currentDateTime = CurrMySqlDate();
			
			$attch_file = "";
			$email_subject = "Employee ID Card";
			$mail_cc = "";
			//$mail_to = 'sachin.paswan@fusionbposervices.com';
			
			$sender_FusionID = $dataInfo['sender_fusion_id'];
			$sender_Name = $dataInfo['sender_name'];
			
			$user_FusionID = $dataInfo['fusion_id'];
			$user_Name = $dataInfo['employee_name'];
			$user_Office = $dataInfo['office_id'];
			$user_Role = $dataInfo['designation'];
			$user_Dept = $dataInfo['department'];
			$user_TL = $dataInfo['tl_name'];
			
			$user_officeMail = $dataInfo['email_id_off'];
			$user_personalMail = $dataInfo['email_id_per'];
			$tl_officeMail = $dataInfo['email_id_off'];
			$tl_personalMail = $dataInfo['email_id_per'];
			
			$nEMployeeInfo = '<b>ID Card Employee Info :</b><br/></br>
						<table border="1" width="80%" cellpadding="0" cellspacing="0">
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Fusion ID :</td>
									<td style="padding:2px 0px 2px 8px">'.$user_FusionID.'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Name :</td>
									<td style="padding:2px 0px 2px 8px">'.$user_Name .'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Office :</td>
									<td style="padding:2px 0px 2px 8px">'.$user_Office.'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Designation :</td>
									<td style="padding:2px 0px 2px 8px">'.$user_Role.'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Department :</td>
									<td style="padding:2px 0px 2px 8px">'.$user_Dept.'</td>
								</tr>
								<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">L1 Supervisor :</td>
									<td style="padding:2px 0px 2px 8px">'.$user_TL.'</td>
								</tr>
						</table>';
			
			if($type == 'P'){
				$mail_to = !empty($tl_officeMail) ? $tl_officeMail : $tl_personalMail;
				$email_subject = "New ID Card Request | " .$user_FusionID ." | " .$user_Name ." | " .$currentDate;
				$nbody = '<b>NEW ID CARD REQUEST</b><br/><br/>
							ID Card request has been generated by ' .	$user_FusionID .' | ' .$user_Name .'
						</br>Please verify the request of the photograph accordingly.<br/><br/>
						</br>' .$nEMployeeInfo;			
			}
			if($type == 'A'){
				$mail_to = $this->configure_idcard_mail($type);
				$email_subject = "ID Card Printing Request | " .$user_FusionID ." | " .$user_Name ." | " .$currentDate;
				if(!empty($dataInfo['image_raw'])){
					$attch_file = FCPATH .$dataInfo['image_link'];
					//$attch_file = FCPATH .'uploads/id_card/'.$user_FusionID.'/id_card_'.$user_FusionID.'.pdf';
				}
				$nbody = '<b>New ID CARD Request</b><br/><br/>
							Printing Request for ID Card is approved by ' .	$sender_FusionID .' | ' .$sender_Name .'
						</br>
						</br>' .$nEMployeeInfo;			
			}
			if($type == 'C'){
				$mail_to = $this->configure_idcard_mail($type);
				$email_subject = "Printed ID Card Received | " .$user_FusionID ." | " .$user_Name ." | " .$currentDate;
				$nbody = '<b>ID CARD</b><br/><br/>
							Printed Copy for ID Card received by ' .	$sender_FusionID .' | ' .$sender_Name .'
						</br>
						</br>' .$nEMployeeInfo;	
			}
			if($type == 'R'){
				$mail_to = !empty($user_officeMail) ? $user_officeMail : $user_personalMail;
				$email_subject = "ID Card Photo Rejected | " .$user_FusionID ." | " .$user_Name ." | " .$currentDate;
				$nbody = '<b>Dear ' .$user_Name .',</b><br/><br/>
							 Your ID Card Photo has been rejected by ' .	$sender_FusionID .' | ' .$sender_Name .'. Kindly, Please reupload Again.
						</br>
						</br>' .$nEMployeeInfo;	
			}

			$nbody .= '</br><b>Regards, </br>Fusion - FEMS	</b></br>';
			
			//echo $email_subject ."<br/>" .$nbody;
			
			if(!empty($mail_to)){
				$this->Email_model->send_email_sox($user_id, $mail_to, $mail_cc, $nbody, $email_subject,  $attch_file, $from_email, $from_name,'N');
			}
		}
	}
	
	
	//==========================================================================================//
    //  USEFULL FUNCTIONS
    //==========================================================================================//
	
	// STATUS ARRAY
	public function status_id_card($status = ''){
		$statusArray = array(
			"P" => array("name" => 'Pending Approval', "color" => '#db021c'),
			"A" => array("name" => 'Approved By Manager', "color" => '#00e357'),
			"T" => array("name" => 'Sent for Printing', "color" => '#cc00e3'),
			"C" => array("name" => 'Received Printed Copy', "color" => '#0e04c7'),
			"D" => array("name" => 'Sent to HR', "color" => '#fabd23'),
			"H" => array("name" => 'Handed Over to Employee', "color" => '#07d934'),
			"R" => array("name" => 'Rejected', "color" => '#d1d1c5'),
		);
		if(!empty($status)){
			return $statusArray[$status];
		} else {
			return $statusArray;
		}		
	}
	
	
	// GET DOWNLINES
	public function get_downlines($current_uid = '')
	{
		  if(empty($current_uid)){ $current_uid = get_user_id();  }
		  $getdata = "ok";
		  $total_uid = NULL;
		  $total_uid[] = $current_uid;
		  $getnextlist = $current_uid;		  
		  while($getdata != "stop")
		  {
			  $sqlc = "SELECT id from signin WHERE assigned_to IN ($getnextlist)";
			  $queryc = $this->Common_model->get_query_result_array($sqlc);
			  if(!empty($queryc))
		      {			  
				  $got_uid = array_column($queryc, 'id');				  
				  $getnextlist = implode(',',$got_uid);
				  $total_uid[] = $getnextlist;
				  $getdata = "ok";
			  }
			  else 
			  {
				$getdata = "stop"; 
			  }			  
		  }		  
		  $getdlist = implode(',',$total_uid);
		  return $getdlist;		  
	}
	
}
?>