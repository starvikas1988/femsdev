<?php 

 class Qa_contact_tracing extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();
	}
	 
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "covid19_case/aside.php";
			$data["content_template"] = "qa_contact_tracing/qa_contact_tracing_feedback.php";
			
			$extraCond = "";
			
			// DATE SEARCH CONDITIONS
			$from_date = CurrMySqlDate();
			$to_date = CurrMySqlDate();
			if(!empty($this->input->get('from_date')))
			{ 
				$from_date = date('Y-m-d',strtotime($this->input->get('from_date')));
				$to_date = date('Y-m-d',strtotime($this->input->get('to_date')));
				$extraCond .= " AND (qc.audit_date >= '$from_date' AND qc.audit_date <= '$to_date' ) ";
			}
			$data['from_date'] = date('Y-m-d',strtotime($from_date));
			$data['to_date'] = date('Y-m-d',strtotime($to_date));
			
			// SEARCH FEEDBACK QUERY
			$qSql = "SELECT qc.*, concat(s.fname,' ',s.lname) as ex_agent_name, concat(tl.fname,' ',tl.lname) as ex_tl_name, 
			         concat(e.fname,' ',e.lname) as ex_entry_by from qa_contact_tracer_feedback as qc
			         LEFT JOIN signin as s on s.id = qc.agent_id
					 LEFT JOIN signin as tl on tl.id = qc.tl_id
					 LEFT JOIN signin as e on e.id = qc.entry_by
					 WHERE 1 $extraCond";
			$data["tracing_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view("dashboard",$data);
			
		}
	}

	
	public function add_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "covid19_case/aside.php";
			$data["content_template"] = "qa_contact_tracing/add_feedback.php";
			
			$qSql = "SELECT c.added_by as agent_id, s.fusion_id as agent_fusion_id, concat(s.fname,' ',s.lname) as agent_name from covid19_case as c
			         LEFT JOIN signin as s ON s.id = c.added_by
					 GROUP BY c.added_by";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$data['tlname'] = "";
			
			$curDateTime=CurrMySqlDate();
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function view_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$aid = $this->uri->segment(3);
			
			$data["aside_template"] = "covid19_case/aside.php";
			$data["content_template"] = "qa_contact_tracing/view_feedback.php";
			
			$qSql = "SELECT qc.*, s.fusion_id, concat(s.fname,' ',s.lname) as ex_agent_name, concat(tl.fname,' ',tl.lname) as ex_tl_name, 
			         concat(e.fname,' ',e.lname) as ex_entry_by from qa_contact_tracer_feedback as qc
			         LEFT JOIN signin as s on s.id = qc.agent_id
					 LEFT JOIN signin as tl on tl.id = qc.tl_id
					 LEFT JOIN signin as e on e.id = qc.entry_by
					 WHERE qc.id = '$aid'";
			$data["tracing_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data['tlname'] = "";
			
			$curDateTime=CurrMySqlDate();
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
	
	public function store_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$curDateTime=CurrMySqlDate();
			$field_array=array(
				"audit_date" => CurrDate(),
				"agent_id" => $this->input->post('agent_id'),
				"agent_name" => $this->input->post('agent_name'),
				"tl_id" => $this->input->post('tl_id'),
				"call_number" => $this->input->post('call_number'),
				"call_type" => $this->input->post('call_type'),
				"caller_type" => $this->input->post('caller_type'),
				"call_score_date" => mmddyy2mysql($this->input->post('call_score_date')),
				"greeting_caller" => $this->input->post('greeting_caller'),
				"greeting_tone" => $this->input->post('greeting_tone'),
				"greeting_reason" => $this->input->post('greeting_reason'),
				"authentication_verify" => $this->input->post('authentication_verify'),
				"authentication_address" => $this->input->post('authentication_address'),
				"authentication_demographics" => $this->input->post('authentication_demographics'),
				"authentication_permission" => $this->input->post('authentication_permission'),
				"authentication_lhj" => $this->input->post('authentication_lhj'),
				"clinical_symtomps" => $this->input->post('clinical_symtomps'),
				"clinical_diagnosis" => $this->input->post('clinical_diagnosis'),
				"clinical_checklist" => $this->input->post('clinical_checklist'),
				"clinical_predisposing" => $this->input->post('clinical_predisposing'),
				"clinical_hospitalization" => $this->input->post('clinical_hospitalization'),
				"contacts_reason" => $this->input->post('contacts_reason'),
				"contacts_collect" => $this->input->post('contacts_collect'),
				"contacts_recall" => $this->input->post('contacts_recall'),
				"contacts_care" => $this->input->post('contacts_care'),
				"data_risk" => $this->input->post('data_risk'),
				"data_transmission" => $this->input->post('data_transmission'),
				"data_investigation" => $this->input->post('data_investigation'),
				"closing_tone" => $this->input->post('closing_tone'),
				"closing_ask" => $this->input->post('closing_ask'),
				"closing_backup" => $this->input->post('closing_backup'),
				"closing_explain" => $this->input->post('closing_explain'),
				"closing_additional" => $this->input->post('closing_additional'),
				"closing_thanks" => $this->input->post('closing_thanks'),
				"score_greeting" => $this->input->post('score_greeting'),
				"score_authentication" => $this->input->post('score_authentication'),
				"score_clinical" => $this->input->post('score_clinical'),
				"score_contacts" => $this->input->post('score_contacts'),
				"score_data" => $this->input->post('score_data'),
				"score_closing" => $this->input->post('score_closing'),
				"score_total" => $this->input->post('score_total'),
				"overall_score" => $this->input->post('overall_score'),
				"greeting_caller_comments" => $this->input->post('greeting_caller_comments'),
				"greeting_tone_comments" => $this->input->post('greeting_tone_comments'),
				"greeting_reason_comments" => $this->input->post('greeting_reason_comments'),
				"authentication_verify_comments" => $this->input->post('authentication_verify_comments'),
				"authentication_address_comments" => $this->input->post('authentication_address_comments'),
				"authentication_demographics_comments" => $this->input->post('authentication_demographics_comments'),
				"authentication_permission_comments" => $this->input->post('authentication_permission_comments'),
				"authentication_lhj_comments" => $this->input->post('authentication_lhj_comments'),
				"clinical_symtomps_comments" => $this->input->post('clinical_symtomps_comments'),
				"clinical_diagnosis_comments" => $this->input->post('clinical_diagnosis_comments'),
				"clinical_checklist_comments" => $this->input->post('clinical_checklist_comments'),
				"clinical_predisposing_comments" => $this->input->post('clinical_predisposing_comments'),
				"clinical_hospitalization_comments" => $this->input->post('clinical_hospitalization_comments'),
				"contacts_reason_comments" => $this->input->post('contacts_reason_comments'),
				"contacts_collect_comments" => $this->input->post('contacts_collect_comments'),
				"contacts_recall_comments" => $this->input->post('contacts_recall_comments'),
				"data_risk_comments" => $this->input->post('data_risk_comments'),
				"data_transmission_comments" => $this->input->post('data_transmission_comments'),
				"data_investigation_comments" => $this->input->post('data_investigation_comments'),
				"closing_tone_comments" => $this->input->post('closing_tone_comments'),
				"closing_ask_comments" => $this->input->post('closing_ask_comments'),
				"closing_backup_comments" => $this->input->post('closing_backup_comments'),
				"closing_explain_comments" => $this->input->post('closing_explain_comments'),
				"closing_additional_comments" => $this->input->post('closing_additional_comments'),
				"closing_thanks_comments" => $this->input->post('closing_thanks_comments'),
				"score_greeting" => $this->input->post('t_greeting_score'),
				"score_authentication" => $this->input->post('t_authentication_score'),
				"score_clinical" => $this->input->post('t_clinical_score'),
				"score_contacts" => $this->input->post('t_contacts_score'),
				"score_data" => $this->input->post('t_data_score'),
				"score_closing" => $this->input->post('t_closing_score'),
				"score_total" => $this->input->post('t_total_score'),
				"overall_score" => $this->input->post('t_overall_score'),
				"entry_by" =>  $current_user,
				"entry_date" => CurrMySqlDate(),
				"log" => get_logs()
			);
			
			data_inserter('qa_contact_tracer_feedback',$field_array);			
			redirect('qa_contact_tracing/add_feedback/success');
		}
	}
	
	
	public function qa_get_tl_filter(){
		if(check_logged_in())
		{
			$uid = $this->uri->segment(3);
			$sql = "SELECT tl.id as tl_id, concat(tl.fname,' ',tl.lname) as tl_name from signin as s
			        LEFT JOIN signin as tl ON tl.id = s.assigned_to
					WHERE s.id = '$uid'";
			$query = $this->Common_model->get_query_result_array($sql);
			
			$selectOptions = "<option value=''>--- Select L1 Supervisor ---</option>";
			foreach($query as $token)
			{
				$selectOptions .= "<option value='".$token['tl_id']."'>".$token['tl_name']."</option>";
			}
			echo $selectOptions;
		}
	}
	
	
	public function get_schedule()
	{
		///////////// schedule ////
			$current_user=get_user_id();
			$currDate=CurrDate();
			$currDay=strtolower(date('D', strtotime($currDate)));
			$TomDate = date('Y-m-d', strtotime(date($currDate) .' +1 day'));
			
			if(date('D', strtotime($currDate)) == "Mon") $shMonDate=$currDate;
			else $shMonDate=date('Y-m-d',strtotime($currDate.' -1 Monday'));
			if(date('D', strtotime($currDate)) == "Sun") $shSunDate=$currDate;
			else $shSunDate=date('Y-m-d',strtotime($currDate.' +1 Sunday'));
			
			//$qSql="Select * from user_shift_schedule a where user_id='$current_user' and (shdate>='$shMonDate' and shdate<='$shSunDate') order by shdate";
			
			$qSql="Select * from user_shift_schedule a where user_id='$current_user' and shdate>='$shMonDate' order by shdate";
			//echo $qSql;
			
			$data["currenDate"] = $currDay;
			$data["tomoDate"] = $TomDate;
			
			$data["curr_schedule"]= $this->Common_model->get_query_result_array($qSql);
			
			$data["aside_template"] = "covid19_case/aside.php";
			$data["content_template"] = "qa_contact_tracing/test.php";
			$this->load->view("dashboard",$data);
	}
	
	
	
	public function fems_master_database(){
		if(check_logged_in()){
			$office_id = "";
			$dept_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			//$date_from="";
			//$date_to="";
					
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$status = $this->input->get('status');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_contact_tracing/master_database.php";
			
			
			$data["role_dir"]=$role_dir;
			$action="";
			$dn_link="";
			
			//$data["get_master_database"] = $this->user_model->master_database_list();
			
			$data["get_master_database"]= array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['department_list'] = $this->Common_model->get_department_list();

			
			if($this->input->get('show')=='Show')
			{			
				$field_array = array(
						//"date_from" => mmddyy2mysql($this->input->get('date_from')),
						//"date_to" => mmddyy2mysql($this->input->get('date_to')),
						"office_id" => $office_id,
						"dept_id" => $dept_id,
						"status" => $status
					);
			
				$fullAray = $this->master_database_list($field_array);
				
				$data["get_master_database"] = $fullAray;
				
				
				
				//$this->create_master_datebase_CSV($fullAray);
				
				$this->generate_master_database_details_xls($fullAray);
					
				//$dn_link = base_url()."reports/download_master_databaseCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			$data['status']=$status;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function generate_master_database_details_xls($rr)
	{
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle('Master Database Details');
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->objPHPExcel->getActiveSheet()->getStyle('A1:AV1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
			
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
			$objWorksheet->getColumnDimension('O')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('P')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('Q')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('R')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('S')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('T')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('U')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('V')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('W')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('X')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('Y')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('Z')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AA')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AB')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AC')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AD')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AE')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AF')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AG')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AH')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AI')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AJ')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AK')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AL')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AM')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AN')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AO')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AP')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AQ')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AR')->setAutoSize(true); 	
			$objWorksheet->getColumnDimension('AS')->setAutoSize(true); 				
			$objWorksheet->getColumnDimension('AT')->setAutoSize(true);
			$objWorksheet->getColumnDimension('AU')->setAutoSize(true);
			$objWorksheet->getColumnDimension('AV')->setAutoSize(true);
			$objWorksheet->getColumnDimension('AW')->setAutoSize(true);
			$objWorksheet->getColumnDimension('AX')->setAutoSize(true);
			$objWorksheet->getColumnDimension('AY')->setAutoSize(true);
			$objWorksheet->getColumnDimension('AZ')->setAutoSize(true);
			$objWorksheet->getColumnDimension('BA')->setAutoSize(true);
			$objWorksheet->getColumnDimension('BB')->setAutoSize(true);
			$objWorksheet->getColumnDimension('BC')->setAutoSize(true);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:BC1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A1:BC1")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "F28A8C"
								)
							)
                );
       
			// CELL FONT AND FONT COLOR 
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'name'  => 'Algerian'
			));

		 	//$this->objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
			//$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			/* $sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 10, "MASTER DATABASE");
			$sheet->mergeCells('A1:AH1'); */
					
			
			
          $header = array("Fusion ID", "XPOID", "First Name", "Last Name", "Full Name", "Client", "Process", "Batch Code", "Designation", "Organization Role", "Location", "Department", "DOJ", "Rejoining Date", "Joining Month", "DOB", "Age", "Boss Name", "Official Email ID", "Personal Email ID", "Father's Name", "Gender", "Highest Qualification", "Present Address", "Permanent Address", "Pincode", "Mobile Number", "Blood Group", "Marital Status", "PAN Number", "UAN Number", "Aadhar Number", "Existing Bank A/C Number", "Existing ESI Number", "Bank IFSC CODE", "Hiring Source", "Hiring Sub Source", "Tenurity", "Experience", "Status", "Term Date", "Term Type", "Caste", "Payroll Type", "Resign Status", "Released Date","Furlough Date","Furlough Expiry Date","Furlough Revoke Date","Bench Date","Suspended Date", "certify_address","work_home","office_assets","specifications");

			$col=0;
			$row=1;
		
			foreach($header as  $excel_header){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $excel_header);	
					$col++; 
			}
			
			$row=2;
			foreach($rr as $user){

				$join_month = date('F', strtotime($user['doj']));
										
				$age_date1 = strtotime($user['dob']);
				$age_date2 = strtotime(CurrDate());
				$age = $age_date2 - $age_date1;
				$age_diff = floor($age / (60*60*24*365) );
				
				if($user['dob']!='0000-00-00'){
					$ageDiff=$age_diff;
				}else{
					$ageDiff=0;
				}
				
				
				$tenu_date1 = strtotime($user['doj']);
				$tenu_date2 = strtotime(CurrDate());
				$term_date = strtotime($user['terms_date']);
				$tenu_diff = floor(($tenu_date2 - $tenu_date1) / (60*60*24) );
				$termDateDiff = floor(($term_date-$tenu_date1) / (60*60*24));
				
				$rejoining_date = "";
				$rejoining_dates = $user['rejoining_dates'];
				if(!empty($rejoining_dates))
				{					
					$rejoinDateAr = explode(',', $rejoining_dates);
					$rejoining_date = $rejoinDateAr[count($rejoinDateAr) - 1];
					if(!empty($rejoining_date)){
					if(strtotime($rejoining_date) < $term_date)
					{
						$rejoining_date = "";
					}
					}
				}
				
				$tenureDays = $tenu_diff;
				$termin_dates = $user['term_dates'];
				if(!empty($termin_dates))
				{
					$tenureDays = 0; $currentJoinDate = strtotime($user['doj']);
					$terminDateAr = explode(',', $termin_dates);
					$checker = 0; $flagTenure = true; $countedTenure = 0;
					foreach($terminDateAr as $token)
					{						
						$currTermDate = date('Y-m-d', strtotime($token));
						$currTermDateCal = strtotime($currTermDate);
						if($currTermDateCal > $currentJoinDate)
						{
							if($flagTenure == true){
								$countDiffTerm = floor(($currTermDateCal-$currentJoinDate) / (60*60*24));
								$tenureDays = $tenureDays + $countDiffTerm;
								$countedTenure++;
							}
							$flagTenure = false;
							if(!empty($rejoining_dates))
							{
								if(!empty($rejoinDateAr[$checker]) && (strtotime($rejoinDateAr[$checker]) > $currTermDateCal))
								{
									$flagTenure = true;
									$currentJoinDate = strtotime($rejoinDateAr[$checker]);
								}
							}
						}						
						$checker++;
					}
					
					if($countedTenure == 0 && $flagTenure == true)
					{
						$countDiffTerm = floor((strtotime(CurrDate())-$currentJoinDate) / (60*60*24));
						$tenureDays = $tenureDays + $countDiffTerm;
					}
				}
				
				$experienceDays = !empty($user['exp_days']) ? $user['exp_days'] : 0;				
				$totalExpereience = $experienceDays + $tenureDays;				
				$experience = $totalExpereience ." Days";
				$experienceYear = sprintf('%.1f', round($totalExpereience / 365, 1));
				if($totalExpereience > 365){ $experience = $totalExpereience ." Days (" .$experienceYear ." Y)"; }
				
				
				
				if($user['doj']!='0000-00-00'){
					if($user['status']!=0){
						$tenureDiff=$tenu_diff;
					}else{
						$tenureDiff=$termDateDiff;
					}
				}else{
					$tenureDiff=0;
				}
				
				$susp_date='';
				$bench_date='';
				$furlough_date='';
				
				if($user['status']==0) $status='Term';
				else if($user['status']==1) $status='Active';
				else if($user['status']==2) $status='Pre-Term';
				else if($user['status']==3){
					$status='Suspended';
					$susp_date=$user['susp_date'];
				}else if($user['status']==4) $status='Active';
				else if($user['status']==5){
					$status='Bench-Paid';
					$bench_date=$user['bench_date'];
				}else if($user['status']==6){
					$status='Bench-Unpaid';
					$bench_date=$user['bench_date'];
				}else if($user['status']==7){
					$status='Furlough';
					$furlough_date=$user['furlough_date'];
					//$furlough_exp_date=$user['furlough_exp_date'];
					//$furlough_final_exp_date=$user['furlough_final_exp_date'];
					
				}else if($user['status']==9 || $user['status']==8) $status='Deactive';
				else $status='UN';
				
				if($user['furlough_date']!='' && $user['status']==7){
					$furlough_exp_date=$user['furlough_exp_date'];
				}else{
					$furlough_exp_date='';
				}
				
				
				if($user['resign_status']=='AC'){
					$resignStatus='Accepted By HR';
					$realsedDate=$user['accepted_released_date'];
				}else if($user['resign_status']=='A'){
					$resignStatus='Approved by L1';
					$realsedDate=$user['approved_released_date'];
				}else if($user['resign_status']=='C'){
					$resignStatus='Completed';
					$realsedDate=$user['accepted_released_date'];
				}else if($user['resign_status']=='R' && $user['approved_by']!=''){
					$resignStatus='Rejected by L1';
					$realsedDate=$user['released_date'];
				}else if($user['resign_status']=='R' && $user['accepted_by']!=''){
					$resignStatus='Rejected by HR';
					$realsedDate=$user['released_date'];
				}else if($user['resign_status']=='P'){
					$resignStatus='Pending';
					$realsedDate=$user['released_date'];
				}else{
					$resignStatus='';
					$realsedDate='';
				}
				
				$iColumn = 0;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row, $user['fusion_id']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['xpoid']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['fname']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['lname']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['fname']." ".$user['lname']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['client_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['process_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['batch_code'] );
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['role_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['org_role_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['office_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['dept_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['d_o_j']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $rejoining_date);
								
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $join_month);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['d_o_b']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $ageDiff);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['assigned_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['email_id_off']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['email_id_per']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['father_name']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['sex']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['lastQualification']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['address_present']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['address_parmanent']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['pin']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['phone']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['blood_group']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['marital_status']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['pan_no']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['uan_no']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['social_security_no']);
				
				$iColumn++; 
				$this->objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iColumn, $row)->setValueExplicit($user['acc_no'], PHPExcel_Cell_DataType::TYPE_STRING);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['esi_no']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['ifsc_code']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['hiring_source']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['hiring_sub_source']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $tenureDays." Days - " .$tenureDiff ." Days");
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $experience);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $status);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['terms_date']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['termType']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['caste']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['payrollltype']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $resignStatus);
				
				$iColumn++;								
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $realsedDate);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $furlough_date);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $furlough_exp_date);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['furlough_final_exp_date']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $bench_date);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $susp_date);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;						
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['is_certify_address']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['is_work_home']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['office_assets']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['specifications']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$row ++;
			
			}
		 
 
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="MASTER_DATABASE_DETAILS.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
            
	}
	
	
	
	public function master_database_list($field_array){
		
		$date_from = $field_array['date_from'];
		$date_to = $field_array['date_to'];
		$office_id =$field_array['office_id'];
		$dept_id =$field_array['dept_id'];
		$status =$field_array['status'];
		
		$cond="";
		
		/* if($date_from!="" && $date_to!=""){ 
			$cond .=" And ( doj >= '$date_from' and doj <='$date_to')";
		}else{
			$cond .="";
		} */
		
		if($office_id!="") $cond .=" where office_id='$office_id'";
		if($dept_id!="" && $dept_id!="ALL") $cond .=" and  dept_id='$dept_id'";
		
		if($status!=""){ 
			$cond .=" and  status in ($status)";
		}else{
			$cond .=" and  status not in (8,9)";
		}

				
		$qSql="SELECT * from 
			(SELECT * from
			(SELECT * FROM	
			(Select s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.sex, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, s.batch_code, s.role_id, s.org_role_id, s.office_id, s.dept_id, s.doj, DATE_FORMAT(s.doj,'%d-%b-%Y') as d_o_j, s.dob, DATE_FORMAT(s.dob,'%d-%b-%Y') as d_o_b, s.assigned_to, s.dfr_id, s.hiring_source, s.hiring_sub_source, s.status, (select name from role r where r.id=s.role_id) as role_name, (select name from role_organization ro where ro.id=s.org_role_id) as org_role_name, (select location from office_location o where o.abbr=s.office_id) as office_name, (select shname from department d where d.id=s.dept_id) as dept_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name, (select last_qualification from dfr_candidate_details cd where cd.id=s.dfr_id) as lastQualification from signin s $cond) xx 
			Left Join 
			(Select ip.user_id, ip.email_id_off, ip.email_id_per, ip.address_present, ip.address_permanent, ip.phone, ip.father_name, ip.blood_group, ip.marital_status, ip.pan_no, ip.uan_no, ip.social_security_no, ip.esi_no, ip.pin, ip.caste from info_personal ip) yy  ON
			(xx.id=yy.user_id)
			Left Join 
			(SELECT ib.user_id as ib_user_id, ib.acc_no, ib.ifsc_code from info_bank ib) ib  ON
			(xx.id=ib.ib_user_id)) zz 
			Left Join 
			(select user_id as term_userid, GROUP_CONCAT(COALESCE(rejon_date, 'NULL')) as rejoining_dates, GROUP_CONCAT(terms_date) as term_dates, Date_Format(max(terms_date), '%Y/%m/%d') as terms_date, (select name from master_term_type mtt where mtt.id=terminate_users.t_type) as termType from terminate_users group by user_id) ww ON
			(zz.id=ww.term_userid)
			Left Join
			(SELECT user_id as exp_uid, SUM(CASE WHEN to_date > from_date THEN DATEDIFF (to_date, from_date) ELSE 0 END) as exp_days from info_experience GROUP by user_id) exp ON
			(exp.exp_uid = zz.id)
			) mas
			Left Join 
			(select ipay.user_id as ipay_userid, ipay.payroll_type, ipay.payroll_status, (select name from master_payroll_type mpt where mpt.id=ipay.payroll_type) as payrollltype from info_payroll ipay ) aa on (mas.id=aa.ipay_userid) 
			Left Join
			(select user_id as reg_userid, resign_status, approved_by, accepted_by, released_date, approved_released_date, accepted_released_date from user_resign where id in (select max(id) from user_resign group by user_id) ) rr on (mas.id=rr.reg_userid) 
			Left Join
			(select fusion_id as wfh_userid, is_work_home, office_assets, office_headset, office_dongle, specifications, others_details from asset_allocation_wfh group by fusion_id ) wfh on (mas.fusion_id=wfh.wfh_userid)
			Left Join 
			(select user_id as furl_userid, is_on_furlough, max(furlough_date) as furlough_date, max(expiry_date) as furlough_exp_date, max(final_expiry_date) as furlough_final_exp_date from user_furlough  group by user_id) ff ON (mas.id=ff.furl_userid)
			Left Join 
			(select user_id as bench_userid, is_on_bench, max(bench_date) as bench_date, max(expiry_date) as bench_expiry_date  from user_bench where is_on_bench='Y' group by user_id ) bb ON (mas.id=bb.bench_userid) 
			Left Join 
			(select user_id as susp_userid, is_complete, max(from_date) as susp_date, max(to_date) as sus_expiry_date from suspended_users where is_complete='N' group by user_id ) sp ON (mas.id=sp.susp_userid) ";		/* where is_on_furlough='Y' */
						
		$query = $this->db->query($qSql);
        return $query->result_array();
	}
	
	
	
	
 }