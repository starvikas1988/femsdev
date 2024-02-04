<?php 

 class Bg_verification extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->library('excel');
	}
	 
	public function index(){
		if(check_logged_in())
		{
			redirect(base_url().'bg_verification/pre_employment_approval');
		}
	}	
	
	public function pre_employment_approval()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = "15261";
		$qSql = "SELECT * from info_personal WHERE user_id = $current_user";
		$data['personal_row'] = $personal_row = $this->Common_model->get_query_row_array($qSql);
		
		if(empty($personal_row['user_id']))
		{ 
			$data_array = ['user_id' => $current_user, "log" => get_logs() ]; 
			data_inserter('info_personal', $data_array); 
		}
		
		$skipBgv = $this->session->userdata('skipBgv'); 
		$skipAdhaar = $this->session->userdata('skipBgvAdhaar');
		
		$qSql = "SELECT * from info_experience WHERE user_id = $current_user";
		$data['experience_row'] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT s.*, d.aadhar_doc from signin as s LEFT JOIN info_document_upload as d ON d.user_id = s.id WHERE s.id = $current_user";
		$data['adhaar_row'] = $this->Common_model->get_query_row_array($qSql);
		
		$state_per_Sql="Select * FROM master_states WHERE country_id=(select id from master_countries where name ='india') ORDER BY name ASC";
		$data["get_per_states"] = $this->Common_model->get_query_result_array($state_per_Sql);
		
		$data['pre_approval'] = $pre_approval = 0;
		$data["content_template"] = "bg_verification/pre_employment_bgv.php";		
		if($personal_row['is_bgv'] == 1 || $skipBgv == 'Y' || $skipAdhaar == 'Y'){ $data['pre_approval'] = $pre_approval = 1; }
		if(($personal_row['is_bgv'] == 1 || $skipBgv == 'Y') && ($personal_row['is_bgv_adhaar'] == 1 || $skipAdhaar == 'Y'))
		{
			redirect(base_url('home')); 
		}
		
		//$data["aside_template"] = "covid19_case/aside.php";
		
		$this->load->view("dashboard_single_col",$data);
	
	}
	
	
	public function submit_background_verification()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//echo "<pre>".print_r($_POST, 1)."</pre>";die();
		$pre_submission_type 	= $this->input->post('pre_submission_type');
		$pre_user_id 			= $this->input->post('pre_user_id');
		$pre_user_skip 		    = $this->input->post('pre_user_skip');
		
		if($pre_submission_type == 1)
		{
			// COMPANY DETAILS
			$e_company 				= $this->input->post('e_company');
			$e_from 				= $this->input->post('e_from_date');
			$e_to 					= $this->input->post('e_to_date');
			$e_contact_name 		= $this->input->post('e_contact_name');
			$e_contact_designation  = $this->input->post('e_contact_designation');
			$e_contact_phone 		= $this->input->post('e_contact_phone');
			$e_contact_email 		= $this->input->post('e_contact_email');
			$e_experience_id 		= $this->input->post('e_experience_id');
			$e_user_id 				= $this->input->post('e_user_id');
			
			$is_educational 		= $this->input->post('is_educational');
			$is_residential 		= $this->input->post('is_residential');
			$is_criminal 			= $this->input->post('is_criminal');
			$employee_consent 		= $this->input->post('employee_consent');
			
			if(empty($pre_user_skip))
			{
				$count_companies = count($e_company);
				for($i=0; $i<$count_companies; $i++)
				{
					if(!empty($e_company[$i]) && !empty($e_contact_name[$i]))
					{
						$data_array = [
							"org_name" 			=> $e_company[$i],
							"from_date" 		=> $e_from[$i],
							"to_date" 			=> $e_to[$i],
							"contact" 			=> $e_contact_phone[$i],
							"contact_name" 		=> $e_contact_name[$i],
							"contact_designation" => $e_contact_designation[$i],
							"contact_email" 	=> $e_contact_email[$i],
						];
							
						if(!empty($e_experience_id[$i]))
						{						
							$this->db->where('id', $e_experience_id[$i]);
							$this->db->where('user_id', $e_user_id[$i]);
							$this->db->update('info_experience', $data_array);
							
						} else {
							
							$data_array += [ "user_id" 	=> $e_user_id[$i] ];					
							$data_array += [ "desig" 	=> '' ];					
							data_inserter('info_experience', $data_array);
						}
					}
					
				}
				
				if(!empty($pre_user_id) && !empty($employee_consent))
				{
					$data_array = [
						"is_bgv" 			 => $employee_consent,
						"is_bgv_educational" => $is_educational,
						"is_bgv_residential" => $is_residential,
						"is_bgv_criminal" 	 => $is_criminal,
					];
					$this->db->where('user_id', $pre_user_id);
					$this->db->update('info_personal', $data_array);
				}
			}
			
			if(!empty($pre_user_skip))
			{
				$data_array = [ "is_bgv" => $pre_user_skip, ];
				$this->db->where('user_id', $pre_user_id);
				$this->db->update('info_personal', $data_array);
				$this->session->set_userdata('skipBgv', 'Y');
			}		
		}
		
		if($pre_submission_type == 2)
		{
			$adhaar_no 				= $this->input->post('adhaar_no');
			$adhaar_name 			= $this->input->post('adhaar_name');
			$adhaar_fathers_name 	= $this->input->post('adhaar_fathers_name');
			$adhaar_dob 			= $this->input->post('adhaar_dob');
			$adhaar_address 		= $this->input->post('adhaar_address');
			$adhaar_pin 			= $this->input->post('adhaar_pin');
			$adhaar_city 			= $this->input->post('adhaar_city');
			$adhaar_state 			= $this->input->post('adhaar_state');
			if(!empty($pre_user_id) && !empty($adhaar_dob) && !empty($adhaar_name))
			{
				$data_array = [
					"social_security_no" => $adhaar_no,
					"father_name" 	    => $adhaar_fathers_name,
					"address_permanent" => $adhaar_address,
					"pin"               => $adhaar_pin,
					"state" 	        => $adhaar_state,
					"city" 	            => $adhaar_city,
				];
				$this->db->where('user_id', $pre_user_id);
				$this->db->update('info_personal', $data_array);
				
				$data_array = [ "dob" => $adhaar_dob ];
				$this->db->where('id', $pre_user_id);
				$this->db->update('signin', $data_array);
			}
			
		}
		
		if($pre_submission_type == 3)
		{
			$acknowledge_adhaar = $this->input->post('acknowledge_adhaar');
			if(empty($pre_user_skip))
			{
				if(!empty($pre_user_id) && !empty($acknowledge_adhaar))
				{
					$data_array = [ "is_bgv_adhaar" => $acknowledge_adhaar ];
					$this->db->where('user_id', $pre_user_id);
					$this->db->update('info_personal', $data_array);
				}
			}
			
			if(!empty($pre_user_skip))
			{
				$data_array = [ "is_bgv_adhaar" => $pre_user_skip, ];
				$this->db->where('user_id', $pre_user_id);
				$this->db->update('info_personal', $data_array);
				$this->session->set_userdata('skipBgvAdhaar', 'Y');
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function del_user_info_experience()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$did = $this->input->get('did');
		if(empty($did)){ $did = $this->uri->segment(4); }
		$uid = $this->input->get('uid');
		if(empty($uid)){ $uid = $this->uri->segment(3); }
		
		if(!empty($did) && !empty($uid))
		{
			$this->db->where('user_id', $uid);
			$this->db->where('id', $did);
			$this->db->delete('info_experience');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	
	
	
	
	//==================================== BACKGROUND VERIFICATION ====================================================//
	
	public function bgv_report()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
	
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "bg_verification/bgv_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->get('report_office_id')){
			
			$data['officeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');

			$get_office_id = $officeSelection; $extraOffice = "";
			if(($get_office_id != "") && ($get_office_id != "ALL")){
				$extraOffice = " AND s.office_id = '$get_office_id' ";
			}			
			$get_dept_id = $deptSelection; $extraDept = "";
			if(($get_dept_id != "") && ($get_dept_id != "ALL")){
				$extraDept = " AND s.dept_id = '$get_dept_id' ";
			}
					
			$reports_sql = "SELECT s.id as user_id, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, 
								  d.description as department, r.name as designation, s.office_id as office, 
								  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor, 
								  b.is_bgv, b.is_bgv_adhaar from signin as s
								  LEFT JOIN info_personal as b ON b.user_id = s.id
								  LEFT JOIN signin as ls ON ls.id = s.assigned_to
								  LEFT JOIN department as d on d.id=s.dept_id
								  LEFT JOIN role as r on r.id=s.role_id
								  WHERE 1 $extraOffice $extraDept";
			$report_list = $this->Common_model->get_query_result_array($reports_sql);
					
			$csvfile = $this->generate_bgv_report_xls($report_list, $officeSelection);
			$this->generate_download_archieve($report_list,$csvfile, $officeSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	public function generate_download_archieve($reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "bg_verification_".$office; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/bg_verification_report_.xlsx";
		$this->zip->read_file($csvfile, "bg_verification_report_".$office.".xlsx");
		
        foreach ($reportArray as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$department = $token["department"];
			$fileName = FCPATH.'/uploads/bg_verification/'.$fusionID.'/'.'bg_verification_' .$fusionID.'.pdf';
			
			$newFileName = $fusionID."_".$firstname."_".$office.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['is_bgv'] == 1){
				$this->zip->read_file($fileName, $newFileName);
			}			
        }
		
        $this->zip->download($zipFileName.'.zip');		
	}
	
	
	public function generate_bg_verification_pdf($uid = '1')
	{			
		if(check_logged_in()){
				
			$this->load->library('m_pdf');
			
			//$current_user = "15261";
			$current_user = $uid;
			$qSql = "SELECT p.*, concat(s.fname, ' ', s.lname) as fullname, s.fusion_id from info_personal as p LEFT JOIN signin as s ON s.id = p.user_id WHERE s.id = $current_user";
			$data['personal_row'] = $personal_row = $this->Common_model->get_query_row_array($qSql);
		
			$qSql = "SELECT * from info_experience WHERE user_id = $current_user";
			$data['experience_row'] = $this->Common_model->get_query_result_array($qSql);			
			
			$html=$this->load->view('bg_verification/pre_employement_bgv_pdf', $data,true);
			
			$fusionID   = $personal_row["fusion_id"];
			$pdfFilePath = "bg_verification_" .$fusionID.".pdf";
			$uploadDir = FCPATH.'/uploads/bg_verification/'.$fusionID.'/';
			$finalDir = $uploadDir .$pdfFilePath;
			if (!file_exists($uploadDir)) {
				mkdir($uploadDir, 0777, true);
			}			
			
			$pdf = new m_pdf();
			$pdf->pdf->AddPage('L');			
			//$pdf->pdf->shrink_tables_to_fit;;			
			$pdf->pdf->WriteHTML($html);			
			$pdf->pdf->Output($finalDir, "F");
			
		}			
	}
	
	
	public function generate_bgv_report_xls($reportArray, $office ='')
	{
		$current_user     = get_user_id();
		$user_site_id     = get_user_site_id();
		$user_office_id   = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir      = get_role_dir();
		$get_dept_id      = get_dept_id();
		
		$this->objPHPExcel = new PHPExcel();	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Background Verification Report');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:I1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Is Background");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Is Ahdhaar");
				
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
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 13 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 13 ));
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "Background Verification Report");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
			
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$report_files = array();		
		foreach($reportArray as $wk=>$wv)
		{
			$user_id = $wv['user_id'];
			$is_bgv = $wv['is_bgv'] == 1 ? 'Yes' : 'No';
			$is_adhaar = $wv['is_bgv_adhaar'] == 1 ? 'Yes' : 'No';
			
			$bgv_color = $wv['is_bgv'] == 1 ? $yesArray : $noArray;
			$adhaar_color = $wv['is_bgv_adhaar'] == 1 ? $yesArray : $noArray;
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_bgv);
			$this->objPHPExcel->getActiveSheet()->getStyle('I'.$c)->applyFromArray($bgv_color);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_adhaar);			
			$this->objPHPExcel->getActiveSheet()->getStyle('J'.$c)->applyFromArray($adhaar_color);
			
			
			if($wv['is_bgv'] == 1){ $this->generate_bg_verification_pdf($user_id); }			
			
		}
		
		
		/* ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="BG_Verification_Report_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); */
		
		$filename = "./assets/reports/BG_Verification_Report_".$office.".xlsx";
		ob_end_clean();
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);	
		$objWriter->save($filename);
		return $filename;
		
	}
	
	public function master_config()
	{
		$emailConfig = array();
		$emailConfig['path'] = "outlook.office365.com";
		$emailConfig['username'] = "sachin.paswan@omindtech.com";
		$emailConfig['password'] = "Fusion@1997";
		$emailConfig['protocol'] = "imap";
		$emailConfig['ssl'] = "/ssl";
		$emailConfig['cert'] = "/novalidate-cert";
		
		$emailConfig['search_text'] = "Support Ticket [ID:";
		$emailConfig['search_id'] = "## Ticket ID:";
		$emailConfig['search_reply'] = "## - REPLY ABOVE THIS LINE - ##";
		
		return $emailConfig;
	}
	
	public function ticket_fetch() 
	{
		$enable_debug = 0;
		$debug = "";
		include(APPPATH . "/libraries/IMap.php");
		
		$masterConfig = $this->master_config();
		$imapPath = $masterConfig['path'];
		$username = $masterConfig['username'];
		$password = $masterConfig['password'];
		$protocol = $masterConfig['protocol'];
		$ssl = $masterConfig['ssl'];
		$cert = $masterConfig['cert'];
		
		$host = $imapPath . "/" . $protocol . $ssl . $cert;
		
		$imap = new IMap("{" .$host. "}INBOX", $username, $password);
		$emails = $imap->search(array(
			"unseen" => 1
			)
		);
		arsort($emails);
		echo "<pre>".print_r($emails, 1)."</pre>";
		die();
		if($emails) {
			$debug .="Count: " . count($emails);
			$cn=0;
			foreach($emails as $mail) {
				$cn++;
				//if($cn>2){ break; }
				$header = $imap->get_header_info($mail);
				$message = $imap->getmsg($mail);
				if(isset($message['htmlmsg']) && !empty($message['htmlmsg'])) {
					$body = $message['htmlmsg'];
				} elseif(isset($message['plainmsg']) && !empty($message['plainmsg'])) {
					$body = $message['plainmsg'];
				} else {
					$body = "";
				}
				
				$header->subject = mb_decode_mimeheader($header->subject);				
				if($message['charset'] != "UTF-8") {
					$body = mb_convert_encoding($body, 'utf-8', $message['charset']);
				}
				
				if(strpos($header->subject, $masterConfig['search_text']) === false){					
					$pos = strpos($body, $masterConfig['search_id']);
					if($pos === false) {
						$debug .="Found new email. Creating ticket ...";
						$body = $imap->extract_gmail_message($body);
						$body = $imap->extract_outlook_message($body);

						$body = $this->strip_html_tags($body);
						$body = strip_tags($body, "<br><p>");
						
						// Ticket variables
						$title = $header->subject;
						$guest_email = $header->from;
					}					
				}
				
				echo "<hr/><h1>NEW EMAIL</h1><br/>";
				echo "<b>Subject : </b>" .$title ."<br/>";
				echo "<b>Guest :  </b>" .$guest_email ."<br/>";;
				echo "<b>Message :  </b><br/><hr/>" .$body;
				echo "<hr/><hr/>";
				//echo "<pre>".print_r($message, 1)."</pre>";
			}
		}

		if($enable_debug) {
			echo "DEBUG OUTPUT: <br />";
			echo $debug;
		}

		exit();
	}
	
	private function strip_html_tags($str){
	    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
	    $str = preg_replace(
	        array(// Remove invisible content
	            '@<head[^>]*?>.*?</head>@siu',
	            '@<style[^>]*?>.*?</style>@siu',
	            '@<script[^>]*?.*?</script>@siu',
	            '@<noscript[^>]*?.*?</noscript>@siu',
	            ),
	        "", //replace above with nothing
	        $str );
	    
	    return $str;
	}
	
	
 }