<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Profile_model');	
		$this->load->model('Reports_model');
		$this->load->model('Progression_model');
		$this->load->model('Email_model');
		$this->load->model('Schedule_adherence_model');
		$this->load->model('Leave_model');
		$this->load->model('Survey_model');
		
	 }
	 
    public function index()
    {
        //$this->load->view('loadingpage');
		
		// Automatically logout after 12 hrs
		$this->user_model->auto_logout_after_hrs() ;
		sleep(1);
		
		if($this->agent->is_mobile()) redirect(base_url(),"refresh");
		
		if(check_logged_in())
        {
			//$data["content_js"] = "home/home_js.php";
			
			if(get_login_type() == "client") redirect(base_url().'clientlogin/client_home',"refresh");
			
			if(is_disable_module()==true) redirect(base_url().'homecha',"refresh");
			
			$is_global_access = get_global_access();
			$current_user = get_user_id();
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			// var_dump($user_office_id);die;
			$ses_dept_id=get_dept_id();
			$get_client_id=get_client_ids();
			$get_process_id=get_process_ids();
			$get_l1_superviser= get_assigned_to();
			
			// var_dump($get_process_id);
			$role_id = get_role_id();
			$user_fusion_id = get_user_fusion_id();
			$user_oth_office=get_user_oth_office();
			
			$user_xpoid = get_user_omuid();
			
			$data['demo']='';
			$attchArrayD = array();
			$pu_id="";
			$data["error"] = '';
			$data['prof_fid']=$user_fusion_id;
			
			if($this->user_model->check_dialer_logged_in($current_user)===true){
				$data["is_logged_in_dialer"] = true;
				$data['is_loggedIn'] = "1";
			}else{
				$data["is_logged_in_dialer"] = false;
				$data['is_loggedIn'] = "0";
			}
			
			$data['dialer_countdown'] = $this->check_logged_in_dialer_remaining_time();
				
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$qSql="Select dob, DATE_FORMAT(dob, '%d') as b_date, DATE_FORMAT(dob, '%m') as b_month from signin where id='$current_user' ";
			$data['get_birthday'] = array();//$this->Common_model->get_query_result_array($qSql);
						
			$qSql="Select * from signin where id='$current_user'";
						
			$data['loggedin_countdown'] = $this->check_logged_in_dialer_remaining_time();
			
			if($this->user_model->check_break_on_ld($current_user)===true) $data["break_on_ld"] = true;
			else $data["break_on_ld"] = false;
			$data['break_countdown_ld'] = $this->check_break_remaining_time_ld();
			
			if($this->user_model->check_break_on($current_user)===true) $data["break_on"] = true;
			else $data["break_on"] = false;
			$data['break_countdown'] = $this->check_break_remaining_time();
			
			$data["dialer_logged_in_time"] = $this->user_model->get_dialer_logged_in_time($current_user);
		
		
		
		///////Dynamic Pop up
		$cur_date = date("Y-m-d h:i:s");
		$qSql = "SELECT * from dynamic_pop_up where '$cur_date' >= start_time and '$cur_date' <= end_time";
		$fetched_data = $this->Common_model->get_query_result_array($qSql);
			// var_dump($current_user);
		foreach ($fetched_data as $get_data) {
			switch ($get_data['preferances']) {
				case 'Location':
					$loc = explode(",",$get_data['location']);
					// $fetched_location = array();
					if (in_array($user_office_id,$loc)){
						$data['LocationWiseDynamicPopUp'][] = $get_data;
					}
					// var_dump($fetched_data);
					// $data['LocationWiseDynamicPopUp'][] = $fetched_location;
					

				break;
				case 'Individual':
					$femsid = explode(",",$get_data['femsid']);
					if (in_array($user_fusion_id,$femsid)){
						$data['IndividualWiseDynamicPopUp'][] = $get_data;
					}

				break;
				case 'Team':
					$team = explode(",",$get_data['team']);
					// $get_l1_id = explode(",",$current_user);
					if (in_array($current_user,$team)){
						$data['TeamWiseDynamicPopUp'][] = $get_data;
					}
					// if (!empty(array_intersect($get_l1_id, $team))){
					// 	$data['TeamWiseDynamicPopUp'][] = $get_data;
					// }

			    break;
				case 'Client':
					$client = explode(",",$get_data['client']);
					$client_list = explode("','",$get_client_id);
					if($client == 'ALL'){
						if (count($client_list)>0){
							$data['ClientWiseDynamicPopUp'][] = $get_data;
						}
					}else{
						if (!empty(array_intersect($client_list, $client))){
							$data['ClientWiseDynamicPopUp'][] = $get_data;
						}
					}
					

			    break;
				case 'Process':
					$client = explode(",",$get_data['client']);
					$process = explode(",",$get_data['process']);
					$client_list = explode(",",$get_client_id);
					$process_list = explode(",",$get_process_id);
				     
					if (!empty(array_intersect($client_list, $client)) && !empty(array_intersect($process_list, $process))){
						$data['ProcessWiseDynamicPopUp'][] = $get_data;
					}
					
			    break;
				case 'Global':
					$data['GlobalWiseDynamicPopUp'][] = $get_data;
				
				break;
				default:
					# code...
					break;
			}
		}
				
		
		
			
		///////Accouncement//////////	
			if($is_global_access==1 ){
				$qSql="Select * from fems_announcement where is_active=1 order by id desc";
				$data['get_announcement_desc'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$qSql="Select * from fems_announcement where is_active=1 and office_id in ('ALL','$user_office_id') order by id desc";
				$data['get_announcement_desc'] = $this->Common_model->get_query_result_array($qSql);
			}
			
		////////////
		
		//////////User Reference (23/07/2019)////////////
		
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			
			//$qSql="Select s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.hiring_source, s.hiring_sub_source, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, s.doj, (select id as rid from signin rs where (rs.xpoid=s.hiring_sub_source or rs.fusion_id=s.hiring_sub_source) ) as ref_id FROM signin s where s.hiring_source='Existing Employee' and s.status=1 having ref_id='$current_user' ";
						
			$qSql="Select * from (Select id, fusion_id, xpoid, fname, lname, hiring_source, hiring_sub_source,doj,status,get_client_names(id) as client_name , get_process_names(id) as process_name FROM signin where hiring_source='Existing Employee' and (hiring_sub_source='$user_fusion_id' OR hiring_sub_source='$user_xpoid') and hiring_sub_source!='') s LEFT Join (select user_id, date(terms_date) as terms_date,lwd,rejon_date from terminate_users WHERE is_term_complete in ('N','Y')) tdb  ON s.id = tdb.user_id";

			//echo $qSql;
			
			$data['get_references_user'] = $this->Common_model->get_query_result_array($qSql);
		////////////////////
		
		//////Organisation News////////
			if($is_global_access==1 ){
				$qSql="Select *, DATE_FORMAT(publish_date,'%m/%d/%Y') as publishDate from organisation_news where is_active=1 order by publish_date  desc";
				$data['get_org_news'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$qSql="Select *, DATE_FORMAT(publish_date,'%m/%d/%Y') as publishDate from organisation_news where is_active=1 and office_id in ('ALL','$user_office_id') order by publish_date desc";
				$data['get_org_news'] = $this->Common_model->get_query_result_array($qSql);
			}

		
		///////////Birth Notification News//////////
					
			$curr_date = date('m-d',strtotime(GetLocalTime()));
			
			//$next_date = date('m-d', strtotime(GetLocalTime() .' +1 day'));
									
			if($is_global_access==1){
				$qSql = "select fusion_id, fname, lname, office_id, dept_id,(Select shname from department d where d.id=s.dept_id) as dept_name from signin s where DATE_FORMAT(dob, '%m-%d') = '$curr_date' and status=1";
			}else if(get_role_dir()=="admin" || get_dept_folder()=="wfm"){
				$qSql = "select fusion_id, fname, lname, office_id, dept_id,(Select shname from department d where d.id=s.dept_id) as dept_name from signin s where DATE_FORMAT(dob, '%m-%d') = '$curr_date' and office_id='$user_office_id' and status=1";
			}else{	
				$qSql = "select fusion_id, fname, lname, office_id, dept_id,(Select shname from department d where d.id=s.dept_id) as dept_name from signin s where DATE_FORMAT(dob, '%m-%d') = '$curr_date' and office_id='$user_office_id' and dept_id='$ses_dept_id' and status=1";
			}
			
			$data['user_today_dob'] = $user_today_dob = $this->Common_model->get_query_result_array($qSql);
			
			$ppicArray=array();
			foreach($user_today_dob as $row):
				$f_id=$row['fusion_id'];
				$ppicArray[$f_id]=$this->Profile_model->get_profile_pic($f_id);
			endforeach;
			
			$data['user_today_dob_ppic']=$ppicArray;
						
			
			///////////// schedule ////
			
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
			
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			
			if( get_update_pswd() == "Y") $data["content_template"] = "home/home.php";
			else $data["content_template"] = "home/change_passwd.php";
			
			// QA
			
			$data['get_ijp_avail'] = $this->Progression_model->get_ijp_avail();
			
			$data['isAvilDipCheck'] = isAvilDipCheck();
			$data['isAvilKatExam'] = isAvilKatExam();
			$data['isAvilTrainingExam'] = isAvilTrainingExam();
			
			
		////////// Agent QA Notification //////////
			/* if(is_access_qa_agent_module()==true){	
				$notify_query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id='.$get_process_id.' Where FIND_IN_SET('.$get_process_id.',process_id) ');
				$notify_row = $notify_query->row();
				
				$data['agent_qa_notification'] = $this->Common_model->get_single_value("Select count(audit_date) as value from ".$notify_row->table_name." where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null ");
			} */
		//////////////////////////////
			
			
			///////////////////////////////////////////
			///////pending process & policy////////////
			///////////////////////////////////////////
		
			$policyArray = array();
			$processArray = array();
			
		//----- pending Policy -----		
				if(isDisableFusionPolicy()== true){
					
					$qSql="select * from ( select pl.*, pf.description as func_name, pf.dept_map as dept_map, (select count(id) from policy_acceptance pa where pl.id=pa.policy_id and user_id='$current_user') as is_accepted from policy_list pl, policy_function pf where pf.id=pl.function_id and pl.is_active=1 and office_id = '$user_office_id' and (pf.dept_map=0 OR pf.dept_map='$ses_dept_id')) temp where is_accepted =0";
					
				}else{
					
					$qSql="select * from ( select pl.*, pf.description as func_name, pf.dept_map as dept_map, (select count(id) from policy_acceptance pa where pl.id=pa.policy_id and user_id='$current_user') as is_accepted from policy_list pl, policy_function pf where pf.id=pl.function_id and pl.is_active=1 and (office_id = 'ALL' OR office_id = '$user_office_id') and (pf.dept_map=0 OR pf.dept_map='$ses_dept_id')) temp where is_accepted =0";
				}
				$data['policy_list'] = $policyArray = $this->Common_model->get_query_result_array($qSql);
				
				$attchArray=array();
						
				foreach($policyArray as $row): 
					$policy_id=$row['id'];
					$qSqlA="select * from policy_attach Where policy_id='$policy_id'  Order By id ";
					$query = $this->db->query($qSqlA);
					$attchArray[$policy_id]=$query->result_array();
				endforeach;
				
				$data['all_policy_attach'] = $attchArray;
				
				
				if( $get_client_id == "0" || $get_client_id == ""){
					
					$attchArray=array();
					$processArray = array();
					$data['process_updates'] = $processArray;
					$data['all_pu_attach'] = $attchArray;
								
				}else{
				
		//----- pending Process Update -----
					
					$cond="";
					
					$cond .=" and (office_id = 'ALL' OR office_id = '$user_office_id' ) ";
					
					if ($get_process_id == "") 	$cond .= " And process_id in (0) "; 
					else $cond .= " And process_id in (0, ".$get_process_id.") ";
										
					if( $get_client_id != "0" && $get_client_id != "") $cond .= " and client_id in ($get_client_id) ";
					
					
					$cond4 = " ( is_specific_access = 1 and pl.id in (SELECT pu_id FROM process_updates_specific_user where user_id = '$current_user' ) )";
					
					
					$qSql= "select * from (select pl.*, (select shname from client x where x.id=pl.client_id) as clientID, (select name from process y where y.id=pl.process_id) as processID, DATE_FORMAT(added_date,'%m/%d/%Y') as addedDate, (select count(id) from process_updates_acceptance pa where pl.id=pa.pu_id and user_id='$current_user') as is_accepted from process_updates pl where pl.is_active=1  AND ((is_specific_access = 0 $cond) OR  $cond4 )  ) temp where  is_accepted =0 order by id desc limit 1";
					
					//echo $qSql;
					
					$data['process_updates'] = $processArray = $this->Common_model->get_query_result_array($qSql);
				
				
					$attchArray=array();
					
					foreach($processArray as $row): 
						$pu_id=$row['id'];
						$qSqlA="select * from process_updates_attach Where pu_id='$pu_id' Order By id ";
						$query = $this->db->query($qSqlA);
						
						
						$attchArray[$pu_id]=$query->result_array();
						
						
					endforeach;
					$qSqlc="select * from process_updates_questions Where pu_id='$pu_id'";
						$queryc = $this->db->query($qSqlc);
						$attchArrayC[]=$queryc->result_array();
					
					$i = 0;
					foreach ($attchArrayC[$i] as $key => $value) {
						// print_r($value); exit;
						$qid = $value['id'];
						$pu_id=$value['pu_id'];
						$qSqld="select * from process_updates_questions_ans_options Where ques_id='$qid'";
						$queryd = $this->db->query($qSqld);
						$attchArrayD[$i]=$queryd->result_array();
						$i++;
					}
					// print_r($attchArrayD); exit;

					$data['all_pu_attach'] = $attchArray;
					$data['all_pu_questions_options'] = $attchArrayD;
					$data['all_pu_question_title'] = $attchArrayC;

				}
			
			
			//if($this->input->get('type') == 'test'){
				///////////////////////////////////////////
				/////// ATTENDANCE ABSENT CHECK ////////////
				///////////////////////////////////////////
				$ab_user_fusion_id = $user_fusion_id;
				//$ab_user_fusion_id = "FKOL005534";
				
				$ab_start_date = date('m-d-Y', strtotime('-1 month', time())); 
				$start_date = CurrDateMDY();
				$end_date = CurrDateMDY();
				$prevMonth = date('m', strtotime($currDate))-1;
				$currYear = strtolower(date('Y', strtotime($currDate)));
			
				if($prevMonth==12) $start_date =$prevMonth."-26-".($currYear-1);
				else $start_date =$prevMonth."-26-".$currYear;
				
				$ab_attendanceArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"client_id" => "",
						"office_id" => "",
						"site_id" => "",
						"user_site_id"=> "",
						"dept_id"=> "",
						"sub_dept_id" => "",
						"assigned_to" => "",
						"filter_key" => "Agent",
						"filter_value" => $ab_user_fusion_id
				 );
				$data['ab_attendanceArray'] = $this->Reports_model->get_user_list_report($ab_attendanceArray);
				$data['ab_leaveData'] = $this->get_leave_apply_list();
				$data["content_js"] = "home_additional_js.php";
			//}
			
			$data["leave_accessible"] = $this->Leave_model->get_leaves_accessible($user_office_id);	
				
				$data["my_team_leaves"] = $this->Leave_model->get_team_leaves($current_user, 0, "", "", "", "","");
				
			
			$qSql = "Select count(id) as value from payroll_popup_temp where fusion_id = '$user_fusion_id' and is_active='1' ";
			$data['isPayrollPopup'] = $this->Common_model->get_single_value($qSql);
			
			
			
			///////////////////////////////////////////	
		
			
			$qSql = "Select count(id) as value from work_shop_seed where user_id = '$current_user'";
			$data['isApplySeed'] = $this->Common_model->get_single_value($qSql);
			
			
	
			///////////////////////////////////////////
			///////pending payroll_popup_temp ////////////
			///////////////////////////////////////////
			
			$qSql = "Select count(id) as value from payroll_popup_temp where fusion_id = '$user_fusion_id' and is_active='1' ";
			$data['isPayrollPopup'] = $this->Common_model->get_single_value($qSql);
			
			///////////////////////////////////////////
			///////pending bankPayRow ////////////
			///////////////////////////////////////////
						
			$qSql = "Select count(id) as value from info_bank_payforvalid where fusion_id = '$user_fusion_id' and status like '%Processed%' ";
			$data['is_payOneRs'] = $this->Common_model->get_single_value($qSql);
			
			///////////////////////////////////////////
			///////pending Bank Details////////////
			///////////////////////////////////////////
			$qSql = "Select count(id) as value from info_bank where user_id = $current_user";
			$data['is_added_bank_details'] = $this->Common_model->get_single_value($qSql);
			
			$qSql = "Select * from info_bank where user_id = $current_user";
			$data['bank_row'] = $this->Common_model->get_query_row_array($qSql);
			
			
			if ( $data['is_payOneRs'] =='1' && $data['bank_row']['pay_varify'] == 'X' ){
				$data['is_OpenPayPopup'] = "Y";
			}else{
				$data['is_OpenPayPopup'] = "N";
			}
			
			// gross 
			$qSql = "Select gross_pay as value  FROM info_payroll where user_id = $current_user";
			$data['gross_pay'] = $gross_pay =  $this->Common_model->get_single_value($qSql);
			
			///////////////////////////////////////////
			///////PENDING ADHAAR CHECK ////////////
			///////////////////////////////////////////
			$qSql = "Select * from info_document_upload WHERE user_id = $current_user";
			$data['document_row'] = $document_row = $this->Common_model->get_query_row_array($qSql);
			$data['is_adhaar_doc_upload'] = 0;
			if(!empty($document_row['aadhar_doc'])){ $data['is_adhaar_doc_upload'] = 1; }
			
			//echo "is_OpenPayPopup :: ". $data['is_OpenPayPopup'];
			//echo "is_payOneRs::" .  $data['is_payOneRs'];
			
			//print_r( $data['bank_row'] );
			
			/////////////////
			
			
			/////////////////////////////////////////////////////////////////////////////
			///////Confirm DOB and Gender  form signin////////////
			/////////////////////////////////////////////////////////////////////////////
			//$skipPerInfo = "N";
			//$skipBankInfo = "N";
			$skipPerInfo  = $this->session->userdata('skipPerInfo');
			$skipBankInfo = $this->session->userdata('skipBankInfo');
			
			if(isDisableBankInfo()==true) $skipBankInfo = "Y";

			$data["skipPerInfo"]=$skipPerInfo;
			$data["skipBankInfo"]=$skipBankInfo;
			
						
			$qSql="Select dob, sex, doj from signin where id = $current_user";
			
			$data["hr_row"] = $this->Common_model->get_query_row_array($qSql);
			
			if($data['hr_row']['dob']=="" || $data['hr_row']['dob']=="0000-00-00"  || $data['hr_row']['sex']=="" ){
				$data["isUpdateHrInfo"]="Y";
			}else $data["isUpdateHrInfo"]="N";
			
		/////////////Holiday List/////////////	
			$qSql="Select *, DAYNAME(holiday_date) as day_name from master_holiday_list where is_active=1 and location='$user_office_id'";
			$data["holidaylist"] = $this->Common_model->get_query_result_array($qSql);
		//////////////////////////////////	
			
			/////////////////////////////////////////////////////////////////////////////
			///////pending email_id_per pan_no uan_no phone from personal Info////////////
			/////////////////////////////////////////////////////////////////////////////
			$qSql="Select * from info_personal where user_id = $current_user";
			
			$data["personal_row"] = $this->Common_model->get_query_row_array($qSql);
			
			if(empty($data["personal_row"]) || $data['personal_row']['is_correct_nos']==0){
				
				if($skipPerInfo=="Y") $data["isUpdateBasicInfo"]="N";
				else  $data["isUpdateBasicInfo"]="Y";
				
			}else $data["isUpdateBasicInfo"]="N";
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== BACKGROUND VERIFICATION =========================///
			////////////////////////////////////////////////////////////////////////////////
			$skipBgv    = $this->session->userdata('skipBgv'); 
			$skipAdhaar = $this->session->userdata('skipBgvAdhaar');
			
			if(isIndiaLocation($user_office_id)==true && (($data["personal_row"]['is_bgv'] != 1 && $skipBgv != 'Y') || ($data["personal_row"]['is_bgv_adhaar'] != 1  && $skipAdhaar != 'Y')))
			{
				redirect(base_url('bg_verification')); 
			}
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== FEEDBACK VERIFICATION =========================///
			////////////////////////////////////////////////////////////////////////////////
			$skipHiringFeedback_1 = $this->session->userdata('skipHiringFeedback_1');
			$skipHiringFeedback_2 = $this->session->userdata('skipHiringFeedback_2');
			$hiringDOJ = $data['hr_row']['doj']; $currentDay = CurrDate();	
			
			//if($this->input->get('type') == 'test'){
				
				$greater_7_Check = strtotime($currentDay) >= strtotime('+7 days', strtotime($hiringDOJ)) ? true : false;
				
				$less_10_Check = strtotime($currentDay) <= strtotime('+10 days', strtotime($hiringDOJ)) ? true : false;
				
				$greater_18_Check = strtotime($currentDay) >= strtotime('+18 days', strtotime($hiringDOJ)) ? true : false;
				
				$less_21_Check = strtotime($currentDay) <= strtotime('+30 days', strtotime($hiringDOJ)) ? true : false;
								
				//&& (($greater_7_Check == true && $less_10_Check == true) || ($greater_18_Check == true && $less_21_Check == true))
				
				if(isIndiaLocation($user_office_id)==true && !empty($hiringDOJ) && ($greater_7_Check == true && $less_21_Check == true)){
					 
					if($data["personal_row"]['is_hiring_feedback_1'] != 1 && $skipHiringFeedback_1 != 'Y'){
						redirect(base_url('new_joiners_feedback_form')); 
					} else {
						if($greater_18_Check == true && $data["personal_row"]['is_hiring_feedback_2'] != 1 && $skipHiringFeedback_2 != 'Y')
						{
							redirect(base_url('new_joiners_feedback_form/two')); 
						}
					}
				}
				
			//}
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== PHOTOGRAPH VERIFICATION =========================///
			////////////////////////////////////////////////////////////////////////////////
			/*$skipUploadPhotograph  = $this->session->userdata('skipUploadPhotograph');
			$is_photo = $data["personal_row"]['is_photo'];
			$is_photo_check = $data["personal_row"]['is_photo_check'];
			$is_idcard = $data["personal_row"]['is_idcard'];
			$is_photo_submit = $data["personal_row"]['is_photo_submit'];
			$is_photo_uploaded = $data["personal_row"]['is_photo_uploaded'];
			
			
			if(isIndiaLocation($user_office_id)==true && (empty($is_photo_check) || ($is_photo_check == 1 && $is_idcard != 'Yes' && $is_photo_submit != 'Yes' && $is_photo_uploaded != 'Yes')) && $skipUploadPhotograph != 'Y')
			{
				redirect(base_url('profile/photograph')); 
			}
			
			
			if(isIndiaLocation($user_office_id)==true && $is_idcard == "N1"){
				redirect(base_url('profile/ReceivedPhototograph')); 
			}*/
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== ID CARD CHECKUP =========================///
			////////////////////////////////////////////////////////////////////////////////
			$current_user = get_user_id();
			$skipUploadIDCard  = $this->session->userdata('skipUploadIDCard');
			$sql_IDCard = "SELECT count(*) as value from employee_id_card WHERE user_id = '$current_user' AND is_active = '1' AND status NOT IN ('R')";			
			$counter_IDCard = $this->Common_model->get_single_value($sql_IDCard);
			$is_idcard = $data["personal_row"]['is_idcard'];
			if(isIndiaLocation($user_office_id)==true && $counter_IDCard < 1 && ($is_idcard == 'No' || $is_idcard == 'N1')  && $skipUploadIDCard != 'Y'){
				redirect(base_url('employee_id_card/card/home')); 
			}
			
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== COVID SELF DECLARATION FORM CHECK =========================///
			////////////////////////////////////////////////////////////////////////////////
			$covid_current_user = get_user_id();
			//$covid_current_date = GetLocalDate();
			$covid_current_date = CurrDate();
			$covid_user_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, 
			         CONCAT(l.fname, ' ', l.lname) as l1_supervisor, lp.phone as supervisor_phone, d.description as department, r.name as designation
			         from signin as s 
					 LEFT JOIN department as d on d.id=s.dept_id
					 LEFT JOIN role as r on r.id=s.role_id
					 LEFT JOIN signin as l ON l.id = s.assigned_to
					 LEFT JOIN info_personal as lp ON lp.user_id = s.assigned_to
					 WHERE s.id = '$covid_current_user'";
			$data['covid_user_data'] = $this->Common_model->get_query_row_array($covid_user_sql);			
			$covid_start_date = $covid_current_date ." 00:00:00";  $covid_end_date = $covid_current_date ." 23:59:59"; 
			// $user_office_id = "CEB";
			$sql_covid_consent = "SELECT * from covid19_screening_checkup WHERE date_added >= '$covid_start_date' AND date_added <= '$covid_end_date' AND user_id = '$covid_current_user' ORDER by id DESC LIMIT 1";			
			$data['covid_consent_details'] = $covid_consent_details = $this->Common_model->get_query_row_array($sql_covid_consent);
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=== COVID SELF DECLARATION FORM CHECK PHILLIPINES =========================///
			////////////////////////////////////////////////////////////////////////////////
			$is_show_covid_phil = false;
			$covid_current_user = get_user_id();
			$covid_start_check = "2021-04-01 23:59:59";
			$sql_covid_consent = "SELECT * from covid19_screening_checkup_phil WHERE user_id = '$covid_current_user' ORDER by id DESC LIMIT 1";			
			$data['covid_consent_details_phil'] = $this->Common_model->get_query_result_array($sql_covid_consent);			
			if(strtotime(CurrMySqlDate()) <= strtotime('+10 days', strtotime($covid_start_check)) && empty($data['covid_consent_details_phil'])){
				$is_show_covid_phil = true;
			}
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=== AMERIDIAL PARTICIPANT SURVEY =========================///
			////////////////////////////////////////////////////////////////////////////////
			$is_show_ameridial_phil = false;
			$sruvey_current_user = get_user_id();
			$survey_start_check = "2021-04-06 23:59:59";
			$sql_covid_consent = "SELECT * from survey_ameridial_participant WHERE agent_id = '$sruvey_current_user'";			
			$data['ameridial_participant_survey'] = $this->Common_model->get_query_result_array($sql_covid_consent);			
			if(strtotime(CurrMySqlDate()) <= strtotime('+20 days', strtotime($survey_start_check)) && empty($data['ameridial_participant_survey'])){
				$is_show_ameridial_phil = true;
			}
			if($is_show_ameridial_phil == true && (isADLocation($user_office_id) || $user_office_id == 'ALT')){
				redirect('survey/ameridial_participant/check');
			}
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== ADDRESS VERIFICATION CHECK =========================///
			////////////////////////////////////////////////////////////////////////////////
			$current_user = get_user_id();
			$sql_AddressCard = "SELECT count(*) as value from survey_profile_validation WHERE agent_id = '$current_user'";			
			$counter_AddressCard = $this->Common_model->get_single_value($sql_AddressCard);
			if(isIndiaLocation($user_office_id)==true && $counter_AddressCard < 1){
				redirect(base_url('notification_home/profile/check')); 
			}
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== FNF CHECK =========================///
			////////////////////////////////////////////////////////////////////////////////
			$fnf_currentUser = get_user_id();
			$fnf_currentDate = CurrDate();
			$showUPFnf = false;
			if((isAccessFNFITHelpdesk() || isAccessFNFITSecurity() || isAccessFNFHr()) && !get_global_access() && isIndiaLocation($user_office_id)==true)
			{
				$fnf_sqlCheck = "SELECT fc.* from user_fnf_records as fc INNER JOIN signin as s ON s.id = fc.user_id WHERE fc.user_id = '$fnf_currentUser' AND DATE(fc.date_added) = '$fnf_currentDate' AND s.office_id IN ('KOL','HWH','BLR','CHE','NOI','MUM')";
				$fnf_queryCheck = $this->Common_model->get_query_result_array($fnf_sqlCheck);
				if(empty($fnf_queryCheck)){
					$showUPFnf = true;
				}
			}
			if($showUPFnf == true){
				redirect(base_url('fnf/fnf_info')); 
			}
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== SURVEY CEBU - FACILITIES DEPARTMENT =========================///
			////////////////////////////////////////////////////////////////////////////////
			if($user_office_id == 'CEB')
			{
				$sv_currentDate = CurrMySqlDate();
				$sv_currentMonth = date('m', strtotime($sv_currentDate));
				$sv_currentYear = date('Y', strtotime($sv_currentDate));
				$sv_currentMaxDay = cal_days_in_month(CAL_GREGORIAN, $sv_currentMonth, $sv_currentYear);		
				$sv_currentStartDate = date('Y-m-01', strtotime($sv_currentDate)) ." 00:00:00";
				$sv_currentEndDate = $sv_currentYear ."-" .$sv_currentMonth ."-" .$sv_currentMaxDay ." 23:59:59";
				$survey_sql = "SELECT * from survey_facilities_department WHERE agent_id = '$current_user' AND date_added >= '$sv_currentStartDate' AND date_added <= '$sv_currentEndDate'";
				$data['surveySubmission'] = $this->Common_model->get_query_result_array($survey_sql);
				if(empty($data['surveySubmission'])){ 
					redirect(base_url('survey/facilities_department/check')); 
				}
			}
			
			/////////////////////////////////////////////////////////////////////////////////
			//=== HR AUDIT SURVEY =========================///
			////////////////////////////////////////////////////////////////////////////////
			$survey_current_user = get_user_id();
			$sql_survey_check = "SELECT * from survey_hr_audit WHERE agent_id = '$survey_current_user'";			
			$data['hr_audit_survey'] = $this->Common_model->get_query_result_array($sql_survey_check);
			if($user_office_id == 'CEB' && empty($data['hr_audit_survey']) && !is_bypass_hr_aduit_sruvey()){
				redirect('survey/hr_audit/check');
			}
			
			
			/////////////////////////////////////////////////////////////////////////////////
			//=============== COPC FORM SURVEY =========================///
			////////////////////////////////////////////////////////////////////////////////
			$survey_user = get_user_id();
			$agent_sql = "SELECT * from signin WHERE id = '$survey_user'";
		    $data['agent_details'] = $this->Common_model->get_query_row_array($agent_sql);
			$data['surveySubmission'] = $surveySubmission = 0;
			$survey_sql = "SELECT count(*) as value from survey_copc WHERE agent_id = '$survey_user'";
			$data['surveySubmission'] = $surveySubmission = $this->Common_model->get_single_value($survey_sql);
		    if($data['surveySubmission'] > 0){ $data['surveySubmission'] = $surveySubmission = 1; }


			/////////////////////////////////////////////////////////////////////////////////
			//=============== SCHEDULE ROUTINE CHECK =========================///
			////////////////////////////////////////////////////////////////////////////////
			$schedule_current_user = get_user_id();				
			$sql_schedule_pending = "SELECT * from user_shift_schedule WHERE is_accept = '0' AND user_id = '$schedule_current_user'";
			$data['pending_schedules'] = $schedule_pending = $this->Common_model->get_query_result_array($sql_schedule_pending);

			
						
			/////////////////////////////////////////////////////////////////////////////
			///////is_certify_address from personal Info////////////
			/////////////////////////////////////////////////////////////////////////////
			
		
			$country_pre_Sql="Select * FROM master_countries ORDER BY name ASC";
			$data["get_countries"] = $this->Common_model->get_query_result_array($country_pre_Sql);
			
			$state_pre_Sql="Select * FROM master_states WHERE country_id=(select id from master_countries where name ='".$data["personal_row"]["country_pre"]."') ORDER BY name ASC";
			
			//echo $state_pre_Sql;
			
			$data["get_pre_states"] = $this->Common_model->get_query_result_array($state_pre_Sql);
			
			$city_pre_Sql="Select * FROM master_cities WHERE state_id in(select id from master_states where name ='".$data["personal_row"]["state_pre"]."') ORDER BY name ASC";
			$data["get_pre_cities"] = $this->Common_model->get_query_result_array($city_pre_Sql);
			
			$state_per_Sql="Select * FROM master_states WHERE country_id=(select id from master_countries where name ='".$data["personal_row"]["country"]."') ORDER BY name ASC";
			$data["get_per_states"] = $this->Common_model->get_query_result_array($state_per_Sql);
			
			$city_per_Sql="Select * FROM master_cities WHERE state_id in (select id from master_states where name ='".$data["personal_row"]["state"]."') ORDER BY name ASC";
			$data["get_per_cities"] = $this->Common_model->get_query_result_array($city_per_Sql);

			if(empty($data["personal_row"]) || $data['personal_row']['is_certify_address']==0){
				$data["isUpdateAddressInfo"]="Y";	
			}else $data["isUpdateAddressInfo"]="N";
			
			
			
			
			
			//////////user_mood
				
			if(isIndiaLocation($user_office_id)==true){
				$local_date=CurrDate();
				$qSql = "Select count(id) as value from user_mood where entry_by = '$current_user' and date(entry_date)='$local_date'";
			}else{
				$local_date=GetLocalDate();
				$qSql = "Select count(id) as value from user_mood where entry_by = '$current_user' and local_date='$local_date'";
			}
			
			$data['isMoodModel'] = $this->Common_model->get_single_value($qSql);
			
			$skipMoodSurvey="N";
			$skipMoodSurvey = $this->session->userdata('skipMoodSurvey');
			if($skipMoodSurvey=="Y"){
				$data['isMoodModel'] =1;
			}
			
			
			//==========================================================================//
			// Employees Sentiment - MOOD PULSE SURVEY
			//==========================================================================//
			//* commented by saikat for new requirement */
			/*
				$e_currentDate = CurrDate();
				$e_sql = "SELECT count(*) as value from survey_employee_mood WHERE agent_id = '$current_user' AND DATE(date_added) = '$e_currentDate'";
				$data['is_moodSurveyModal'] = $is_moodSurveyModal = $this->Common_model->get_single_value($e_sql);
				if(empty($is_moodSurveyModal)){
					$data['mood_surveyQuestions'] = $this->Survey_model->survey_mood_questions();
					$data['mood_surveyQuestionsSet'] = $this->Survey_model->survey_office_random_question_no($user_office_id);
				}
			*/
			
			$skipUserSentiment="N";
			$skipUserSentiment = $this->session->userdata('skipUserSentiment');
			$isUserSentimentModel = 1;
			
			if($skipUserSentiment!="Y"){
				
				$current_ques_id = $this->getSentimentQuestions();
				$current_quotes_id = $this->getSentimentQuotes();
							
				//$current_ques_id=3;
				//$current_quotes_id=3;
				//echo " 2nd:". $current_ques_id . " :: ";
				//echo $current_quotes_id;
				
				if($current_ques_id==0){
					
					$data['isUserSentimentModel']=1;
					$isUserSentimentModel=1;
					
				}else{
					
					$qSql = "Select * from user_sentiment_questions where id = $current_ques_id";
					$data['UserSentimentQuestions'] = $UserSentimentQuestions = $this->Common_model->get_query_row_array($qSql);
				
					$qSql = "Select * from user_sentiment_quotes where id = $current_quotes_id";
					$data['UserSentimentQuotes'] = $UserSentimentQuotes = $this->Common_model->get_query_row_array($qSql);
					
					if(!empty($UserSentimentQuestions)){
						
						$data['isUserSentimentModel']=0;
						$isUserSentimentModel=0;
					
					}else{
						
						$data['isUserSentimentModel']=1;
						$isUserSentimentModel=1;
						
					}
				}
				
			}
			
					
							
			//////////////////////
									
			if(get_update_pswd() == "N"){
				$data["content_template"] = "home/change_passwd.php";
			}else if(get_accept_consent() == "0" && ($user_office_id=="UKL" || $user_office_id=="ALB" )){
				
				$data["content_template"] = "home/consent.php";
				
			}else if((empty($covid_consent_details['id']) && isIndiaLocation($user_office_id)==true) || (!empty($covid_consent_details['id']) && $covid_consent_details['employee_consent'] == 0)){
				
				if(isIndiaLocation($user_office_id)==true) { $data["content_template"] = "home/covid_checkup.php"; }
				
			}else if($is_show_covid_phil == true && ($user_office_id=="CEB" || $user_office_id=="MAN")){
				
				$data["content_template"] = "home/covid_checkup_phil.php";
				
			}else if($surveySubmission < 1 && (get_role_dir() != 'agent' && (get_dept_folder() == 'qa' || get_dept_folder() == 'operations')) && $user_office_id!="CAS"){
				
				$data["content_template"] = "survey/copc_form.php";
			
			
			}else if(count($schedule_pending) > 0){
				
				$data["content_template"] = "home/pending_schedule_check.php";
				
			}else if(count($data["policy_list"])>0 || count($data["process_updates"])>0 || (($data["is_added_bank_details"] == 0 || $data['bank_row']['is_accept'] == 0 ) && (isIndiaLocation($user_office_id)==true || $user_office_id=="JAM" ) && $skipBankInfo!="Y") || ($user_office_id=="JAM" && ($data["isUpdateBasicInfo"] =="Y" || $data["isUpdateHrInfo"] =="Y" )) || (isIndiaLocation($user_office_id)==true && $data["isUpdateAddressInfo"]=="Y") || ($data['bank_row']['is_acpt_document']==0 && isIndiaLocation($user_office_id)==true && (get_role_dir()=="agent" || get_role_dir()=="tl")  && $skipBankInfo!="Y"  && ($gross_pay >0 && $gross_pay<21000) ) || ($data['is_adhaar_doc_upload'] == 0 && isIndiaLocation($user_office_id)==true && (get_role_dir()=="agent" || get_role_dir()=="tl") ) ){
				
				//$ses_dept_id!='6'
				
				if($role_id > 0 ){
															
					$data["content_template"] = "home/pending_process_policy.php";
					
					
				}else{
					$data["content_template"] = "home/home.php";
				}
						
			}else{
				$data["content_template"] = "home/home.php";
			}
			
			
			$data['unread'] = $this->un_read_count();
			
			
		//////////////IT Assessment//////////////	
			$qSql="Select count(user_id) as uid from it_assessment where user_id='$current_user'";
			$data["itAssessment"] = $this->Common_model->get_query_row_array($qSql);
		
		//////////////SURVEY WORK FROM HOME//////////////	
		$qSql="SELECT count(user_id) as isdonesurvey from survey_work_home where user_id='$current_user'";
		$data["survey_workhome"] = $this->Common_model->get_query_row_array($qSql);
		
			////////////////////////////	
			$qSql="SELECT * from asset_allocation_wfh where fusion_id = '$user_fusion_id'";
			$data["office_asset"] = $this->Common_model->get_query_row_array($qSql);
			
		//======================================
		// SCHEDULE ADHERENCE 
		//=========================================
		//if($user_fusion_id == 'FKOL000001'){ $user_fusion_id = "FKOL005534"; }
		if(!empty($this->input->get('select_month')) || !empty($this->input->get('select_year')))
		{
			$selected_month = $this->input->get('select_month');
			$selected_year = $this->input->get('select_year');
			$selected_fusion = $this->input->get('select_fusion');
			if(empty($selected_month)){ $selected_month = "01"; }
			if(!empty($selected_fusion)){ $user_fusion_id = $selected_fusion; }
			$currDate = $selected_year.'-'.$selected_month.'-01';
		}
		$data['individualData'] = $individualData = $this->Schedule_adherence_model->get_schedule_adherence_individual($currDate, $user_fusion_id);
		$data['selected_month'] = $selected_month = $individualData['selected_month'];
		$data['selected_fusion'] = $selected_fusion = $individualData['selected_fusion'];
		$data['selected_year'] = $selected_year = $individualData['selected_year'];
		$data['schedule_monthly'] = !empty($individualData['schedule_monthly']) ? $individualData['schedule_monthly'] : "";
		$data['schedule_weekly'] = !empty($individualData['schedule_weekly']) ? $individualData['schedule_weekly'] : "";
		//$data['schedule_user'] = $individualData['schedule_user'];			
		$data['colorsPieArray'] = ["#28eb86", "#ff5252", "#9ea2a3", "#18afe9", "#dcbc1d"];
		$data['colorsLoginArray1'] = ["#14c84b", "#d9ffed", "#5cff94"];
		$data['colorsLoginArray2'] = ["#d6d4d4", "#ff4141", "#ffc9c9"];
		$data['colorsLoginArray3'] = ["#18afe9", "#cae8f3", "#b2eaff"];
		$data['colorsLoginArray4'] = ["#ffac2e", "#f5dede", "#ffce83"];	
		$data['colorsLineArray'] = ["#efdb4c","#00c961", "#eb0000","#4877d4","#2AC773","#2AD1D1","#64A3AC"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff", "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];	
			
			
		//************************************************************************
		//COURSE NOTIFICATION
		//************************************************************************
		
		$SQLtxt = "SELECT count(*)as notification FROM course_assign_agents WHERE is_view = 0 AND agent_id=". $current_user ."";
		$data['course_notification'] = $this->Common_model->get_query_row_array($SQLtxt);
		
		//////////////////////////////////////////		
		
		$this->load->view('dashboard_single_col',$data);
			
			
        }
		
    }
	
	
	public function skipBankInfo(){
		
		$this->session->set_userdata('skipBankInfo', 'Y');
		redirect('home',"refresh");							
	}
	
	public function skipPerInfo(){
		$this->session->set_userdata('skipPerInfo', 'Y');
		redirect('home',"refresh");
	}
	
	////////////////////////////////////////////////////	
	public function change_password(){
		
		if(check_logged_in()){
						
			$current_user = get_user_id();
			$current_date = date('Y-m-d');
			
			$data["error"] = ''; 

			if($this->input->post('submit')=="Save")
			{
							
				$qSql="Select passwd as value from signin where id='$current_user'";
				$old_pswd = $this->Common_model->get_single_value($qSql);
			
				$oldpassword = trim($this->input->post('old_password'));
				$oldpassword = md5($oldpassword);
				
				$password = trim($this->input->post('new_password'));
				$repassword = trim($this->input->post('re_password'));
				
				if($old_pswd==$oldpassword){
					
					if($password!="" && $repassword!=""){
						if(strlen($password)>=8){
							if($password==$repassword){
									
									$password = md5($password);
									
									$_field_array = array(
											"passwd" => $password,
											"is_update_pswd" => 'Y',
											"pswd_update_date" => $current_date
									);
									////accept_consent_date
									
									$this->db->where('id', $current_user);
									$this->db->where('passwd', $oldpassword);
									$this->db->update('signin', $_field_array);
									
									/////////////////////////////
									$ses_array = $this->session->userdata('logged_in');
									$ses_array['is_update_pswd'] = "Y";
									//////////is_accept_consent////////////
									
									
									$this->session->set_userdata("logged_in",$ses_array);
									
									////// Update user Login //////
									$_field_array = array(
										"last_logged_date" => date("Y-m-d H:i:s"),
										"is_logged_in" => 1,
										"disposition_id" =>0
									);
								
									if($this->user_model->check_dialer_logged_in($current_user)===false)
									{
										$this->db->update("signin",$_field_array,array("id"=>$current_user));
									}
									
									////// Update user Login //////
									
									$data["error"] = show_msgbox('Password Update Successfully.',true);
									
										
							 }else{
									$data["error"] = show_msgbox('Mismatch Password.',true);
									
							 }
						
						}else{
					
							$data["error"] = show_msgbox('Password must be minimum 8 characters.',true);
							
						}
					}else{
						$data["error"] = show_msgbox('Password Or Confirm Password is Blank.',true);
						
					}
				
				}else{
					$data["error"] = show_msgbox('Old Password is Invalid.',true);
				}
				
			}
			
			redirect('home');
			
		}
	}
	
	
	
	
	public function accept_consent(){
		
		if(check_logged_in()){
						
			$current_user = get_user_id();
			$current_date = CurrMySqlDate();
			
			$data["error"] = ''; 

			if($this->input->post('submit')=="Save")
			{
				$consent_input = $this->input->post('check_consent');
				
				$qSql="Select * from signin where id='$current_user'";
				$data['consentdata'] = $checkconsent = $this->Common_model->get_query_result_array($qSql);
				
				if(!empty($consent_input))
				{
					$_field_array = array(
							"is_accept_consent" => '1',
							"accept_consent_date" => $current_date
					);
					$this->db->where('id', $current_user);
					$this->db->update('signin', $_field_array);
										
					/////////////////////////////
					$ses_array = $this->session->userdata('logged_in');
					$ses_array['is_accept_consent'] = "1";
			
					$this->session->set_userdata("logged_in",$ses_array);
										
					$data["error"] = show_msgbox('Consent Accepted Successfully',true);
				}
					
			}
							
			redirect('home');
			
		}
	}
	
	
	
	
	
	
	
	
	
	
///////////////Pending Policy and Process Update/////////////////

	public function pending_process_policy(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$added_date = date("Y-m-d h:i:sa");
			$log = get_logs();
			
			$adpid = trim($this->input->post('adpid'));
			// 
			
			if($adpid!=""){
				$field_array = array(
					"policy_id" => $adpid,
					"user_id" => $current_user,
					"accepted_datetime" => $added_date,
					"log" => $log
				);
				
				$rowid= data_inserter('policy_acceptance',$field_array);	
			}
			
			
			$process_id = trim($this->input->post('process_id'));
			
			// echo $process_id; exit;
			
			if($process_id!=""){
				$field_array1 = array(
					"pu_id" => $process_id,
					"user_id" => $current_user,
					"accepted_datetime" => $added_date,
					"log" => $log
				);
				
				$rowid= data_inserter('process_updates_acceptance',$field_array1);
			}
			
			redirect("home");
		}
	}




	public function check_q_ans(){

		// print_r($_POST);
		// exit;
		$process_id = trim($this->input->post('process_id'));

		$qSqlc="select * from process_updates_questions Where pu_id='$process_id'";
		$queryc = $this->db->query($qSqlc);
		$qarray=$queryc->result_array();

		$limit = count($qarray);
		// echo $limit;

		for ($i=0; $i <$limit ; $i++) { 
			
				$this->db->select('*');
				$this->db->from('process_updates_questions_ans_options');
				$this->db->where('ques_id',$this->input->post("q_id$i"));
				$this->db->where('text',$this->input->post("option$i"));
				$this->db->where('correct_answer',1);
				$query = $this->db->get();
				$result[] = $query->num_rows();
		}

			if(count(array_keys($result, 1)) == $limit){
					if(check_logged_in()){
						$current_user = get_user_id();
						$added_date = date("Y-m-d h:i:sa");
						$log = get_logs();
						
						
						$process_id = trim($this->input->post('process_id'));
						
						// echo $process_id; exit;
						
						if($process_id!=""){
							$field_array1 = array(
								"pu_id" => $process_id,
								"user_id" => $current_user,
								"accepted_datetime" => $added_date,
								"log" => $log
							);
							
							$rowid= data_inserter('process_updates_acceptance',$field_array1);
						}
						
						
					}
					$response = array('error'=>'no');
					echo json_encode($response);
			}
			else{
				$response = array('error'=>'error');
				echo json_encode($response);
			}
		
		
	}
///////////////////////////////////////////////////


	public function seedApplnSave()
	{
		if(check_logged_in())
		{
		
			$current_user = get_user_id();
			$curr_date = CurrMySqlDate();
			
			$log=get_logs();
			
			if($this->input->post('fusion_id') !="" && $this->input->post('phone') !="" ){
				
				$field_array = array(
					"user_id" => $current_user,
					"location_id" => trim($this->input->post('location_id')),
					"phone" => trim($this->input->post('phone')),
					"email_id" => trim($this->input->post('email_id')),
					"added_date" => $curr_date,
					"log" => $log
				);
				
				//print_r($field_array);
				$rowid = data_inserter('work_shop_seed',$field_array);
				
				$qSql="Select log from info_personal where user_id = '$current_user'";
				$prevLog=getDBPrevLogs($qSql);
				$log=get_logs($prevLog);
			
				$field_array = array(
					"phone" => trim($this->input->post('phone')),
					"email_id_per" => trim($this->input->post('email_id')),
					"log" => $log
				);
				
				$this->db->where('user_id', $current_user);
				$this->db->update('info_personal', $field_array);
				
				
				
			}
			
			echo "Done";
			
		}
	}
	
//////////////// IT Assessment (09/03/2020) //////////////////////	
	public function itAssessment(){
		if(check_logged_in()){
			$data["error"] = '';
			$current_user = get_user_id();
			
			$dekstop_laptop = trim($this->input->post('dekstop_laptop'));
			
			if($dekstop_laptop!=""){
				$field_array = array(
					"user_id" => $current_user,
					"dekstop_laptop" => $dekstop_laptop,
					"what_kind_dl_cpu" => trim($this->input->post('what_kind_dl_cpu')),
					"what_kind_dl_ram" => trim($this->input->post('what_kind_dl_ram')),
					"what_kind_dl_hdd" => trim($this->input->post('what_kind_dl_hdd')),
					"what_internet_conn" => trim($this->input->post('what_internet_conn')),
					"what_bandwith" => trim($this->input->post('what_bandwith')),
					"have_headset" => trim($this->input->post('have_headset')),
					"kind_power_backup" => trim($this->input->post('kind_power_backup')),
					"entry_date" => CurrMySqlDate()
				);
				$rowid = data_inserter('it_assessment',$field_array);
				
			}	
			//redirect("home");
		}
	}
	
	
//////////////// WORK FROM HOME SURVEY (27/03/2020) //////////////////////	
	public function survey_workfromhome(){
		if(check_logged_in()){
			$data["error"] = '';
			$current_user = get_user_id();
			
			$is_work_home = trim($this->input->post('is_work_home'));
			$log = get_logs();
			
			if($is_work_home!=""){
				$field_array = array(
					"user_id" => $current_user,
					"is_work_home" => $is_work_home,
					"is_shifted_happy" => trim($this->input->post('is_shifted_happy')),
					"how_shifted_happy" => trim($this->input->post('how_shifted_happy')),
					"hashtag" => trim($this->input->post('wfh_hashtag')),
					"remarks" => trim($this->input->post('wfh_comments')),
					"entry_date" => CurrMySqlDate(),
					"log" => $log
				);
				$rowid = data_inserter('survey_work_home',$field_array);
				
			}	
			redirect("home");
		}
	}
	
////////////////Add Referrals//////////////////////	
	public function addreferral(){
		if(check_logged_in()){
			$data["error"] = '';
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			
			$added_date = CurrMySqlDate();
			$name = trim($this->input->post('name'));
			$phone = trim($this->input->post('phone'));
			$email = trim($this->input->post('email'));
			
					
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"phone" => $phone,
					"email" => $email,
					"location" => $user_office_id,
					"comment" => trim($this->input->post('comment')),
					"added_by" => $current_user,
					"added_date" => $added_date
				);
				$rowid = data_inserter('dfr_employee_referral',$field_array);
				
			}	
			//redirect("home");
			
		}
	}
	
	
	public function getCurrentAttendance(){
		
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$user_fusion_id = get_user_fusion_id();	
			$currDate=CurrDate();
			
			$current_view = $this->input->get('attendance_type');
			if($current_view == ""){
				$data['current_view'] = $current_view = 1;
			}
			
			$extra = "";
			$start_date = CurrDateMDY();
			$end_date = CurrDateMDY();
			
			$prevMonth = date('m', strtotime($currDate))-1;
			$currYear = strtolower(date('Y', strtotime($currDate)));
			
			//echo "prevMonth :: " . $prevMonth;
			
			if($prevMonth==12) $start_date =$prevMonth."-26-".($currYear-1);
			else $start_date =$prevMonth."-26-".$currYear;
			
			//echo "start_date :: " . $start_date;
			//echo "\r\n end_date :: " . $currDate;
						
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"client_id" => "",
					"office_id" => "",
					"site_id" => "",
					"user_site_id"=> "",
					"dept_id"=> "",
					"sub_dept_id" => "",
					"assigned_to" => "",
					"filter_key" => "Agent",
					"filter_value" => $user_fusion_id
			 ); 
			 
			 //print_r($filterArray);
			 			 
			$data['attan_dtl'] = $this->Reports_model->get_user_list_report($filterArray, $extra, 'N', 'Y');
		 
			//print_r ($data['attan_dtl']);
			
			$this->load->view('home/current_attendance',$data);
			
			
		}
	}
	
		
	public function validate_referral_email(){
		if(check_logged_in()){
			$email = $this->input->post('email');
			$qSql="select email FROM dfr_employee_referral where email='$email' ";
			$fields1 = $this->db->query($qSql);
			
			$ref_email = $fields1->result();
			
			if($fields1->num_rows() > 0 ){ 
				echo "Email already referred";
			} else{
				echo "OK";
			}
		}
	}
	
	
	public function validate_referral_phone(){
		if(check_logged_in()){
			$phone = $this->input->post('phone');
			$qSql="select phone FROM dfr_employee_referral where phone='$phone' ";
			$fields = $this->db->query($qSql);
			
			$ref_phone = $fields->result();
			 
			
			if($fields->num_rows() > 0){
				echo "Phone number already referred";
			}else{
				echo "OK";
			}
		}
	}
	
	
	public function updateAddress(){
		if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$pre_pin = trim($this->input->post('pre_pin'));
			if($this->input->post('pre_city'))
			{
				$pre_city =	trim($this->input->post('pre_city'));
			}
			else
			{
				$pre_city =	trim($this->input->post('pre_city_other'));
			}
			
			$pre_state = trim($this->input->post('pre_state'));
			$pre_country = trim($this->input->post('pre_country'));
			$address_present = trim($this->input->post('address_present'));
			$per_pin = trim($this->input->post('per_pin'));
			
			if($this->input->post('per_city'))
			{
				$per_city =	trim($this->input->post('per_city'));
			}
			else
			{
				$per_city =	trim($this->input->post('per_city_other'));
			}
			$per_state = trim($this->input->post('per_state'));
			$per_country = trim($this->input->post('per_country'));
			$address_permanent = trim($this->input->post('address_permanent'));
			$is_certify_address = trim($this->input->post('is_certify_address'));
			if($is_certify_address=="") $is_certify_address=0;
			
			$same_addr = trim($this->input->post('same_addr'));
			
			
			$field_array = array(
					"user_id" => $current_user,
					"pin_pre" => $pre_pin,
					"city_pre" => $pre_city,
					"state_pre" => $pre_state,
					"country_pre" => $pre_country,
					"address_present" => $address_present,
					"pin" => $per_pin,
					"city" => $per_city,
					"state" => $per_state,
					"country" => $per_country,
					"address_permanent" => $address_permanent,
					"same_addr" => $same_addr,
					"is_certify_address" => $is_certify_address,
				);
			
				$this->db->where('user_id', $current_user);
				$this->db->update('info_personal', $field_array);			
		}
		
		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home';
		redirect($referer);
			
	}
	
	
	
	
	
	
	
///////////////	
	
	private function check_break_remaining_time_ld()
	{
		$current_user = get_user_id();
		
		// Get date from DB
		$date = $this->user_model->get_break_on_time_ld($current_user);
		$date = new DateTime($date);
		
		// Calculate Max Time adding 8 hours
		//$max_time = new DateTime(date("Y-m-d H:i:s", strtotime( "$date +1  minutes" )));
		
		// Get NOW time stamp
		$now = new DateTime(date("Y-m-d H:i:s"));
		
		// Get difference between now and max_time 
		$edate = $date->diff($now);
		return ($edate->h * 3600) + ($edate->i * 60) + ($edate->s);
	}
	
	private function check_break_remaining_time()
	{
		$current_user = get_user_id();
		
		// Get date from DB
		$date = $this->user_model->get_break_on_time($current_user);
		$date = new DateTime($date);
		
		// Calculate Max Time adding 8 hours
		//$max_time = new DateTime(date("Y-m-d H:i:s", strtotime( "$date +1  minutes" )));
		
		// Get NOW time stamp
		$now = new DateTime(date("Y-m-d H:i:s"));
		
		// Get difference between now and max_time 
		$edate = $date->diff($now);
		return ($edate->h * 3600) + ($edate->i * 60) + ($edate->s);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Check Logout counter/Timer
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	private function check_logged_in_dialer_remaining_time()
	{
		$current_user = get_user_id();
		
		// Get date from DB
		$date = $this->user_model->get_dialer_logged_in_time($current_user);
		$date = new DateTime($date);
		
				
		// Get NOW time stamp
		$now = new DateTime(date("Y-m-d H:i:s"));
		
		// Get difference between now and max_time 
		$edate = $date->diff($now);
		return ($edate->h * 3600) + ($edate->i * 60) + ($edate->s);
	}
	
	
	
	
	
	public function accepteGaze(){
		if(check_logged_in()){
			$log = get_logs();
			$current_user = get_user_id();
			$field_array = array(
				"user_id" => $current_user,
				"log" => $log
			);
			$rowid = data_inserter('egaze_acknowledge',$field_array);
				
		}
	}
	
	
	public function saveYourMood(){
		if(check_logged_in()){
			$txt = trim($this->input->get('txt'));
			$log = get_logs();
			$current_user = get_user_id();
			
			$local_date = GetLocalDate();
			$current_date = CurrMySqlDate();
			
			$field_array = array(
				"local_date" => $local_date,
				"mood" => $txt,
				"entry_by" => $current_user,
				"entry_date" => $current_date,
				"log" => $log
			);
			$rowid = data_replace_into('user_mood',$field_array);
				
		}
	}
	
	
	public function skipMoodSurvey(){
		
		$this->session->set_userdata('skipMoodSurvey', 'Y');
		redirect('home',"refresh");							
	}
	
	
	public function userSentiment(){
		
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$qSql = "Select * from user_sentiment_questions where location_id in ('ALL','$user_office_id') and is_active='1' order by id desc limit 1";
		$data['UserSentimentQuestions'] = $UserSurveyQuestions = $this->Common_model->get_query_row_array($qSql);
		
		$this->load->view("home/user_sentiment.php",$data);		
		
	}
	
	public function saveUserSentiment(){
		if(check_logged_in()){
			$ans = trim($this->input->post('ans'));
			$ques_id = trim($this->input->post('ques_id'));
			$quotes_id = trim($this->input->post('quotes_id'));
			$log = get_logs();
			$current_user = get_user_id();
			
			$local_date = GetLocalDate();
			$current_date = CurrMySqlDate();
			
			$field_array = array(
				"user_id" => $current_user,
				"question_id" => $ques_id,
				"quotes_id" => $quotes_id,
				"survey_answer" => $ans,
				"date_added" => $current_date,
				"date_added_local" => $local_date,
				"log" => $log
			);
			$rowid = data_replace_into('user_sentiment_answare',$field_array);
			
			//redirect(base_url().'home',"refresh");

		}
	}
	
	
	
	
	public function skipUserSentiment(){
		
		$this->session->set_userdata('skipUserSentiment', 'Y');
		redirect('home',"refresh");							
	}
	
	
	public function getSentimentQuestions(){
		
		$current_ques_id =0;
		$user_office_id=get_user_office_id();
		$current_user = get_user_id();
		
		$qSql = "Select max(id) as value from user_sentiment_questions";
		$total_ques = $this->Common_model->get_single_value($qSql);
		
		//$cDate=CurrDate();
		$cDate=GetLocalDate();
		
		//$qSql = "Select max(quotes_id) as value from user_sentiment_answare where date_added_local='$cDate'";
		//$current_quotes_id = $this->Common_model->get_single_value($qSql);
								
		$qSql = "Select question_id as value from user_sentiment_answare where user_id = '$current_user' order by id desc limit 1  ";
		$user_ques_id = $this->Common_model->get_single_value($qSql);
		
		$qSql = "Select question_id as value from user_sentiment_answare where date_added_local='$cDate' and user_id in (select id from signin where office_id='$user_office_id') order by id desc limit 1  ";
		
		$db_ques_id = $this->Common_model->get_single_value($qSql);
		
		//if($user_ques_id==$total_ques) $user_ques_id = 1;
		
		if($db_ques_id=="" && $user_ques_id==""){
			$current_ques_id = 1;
		}else if($db_ques_id==""){
			if($user_ques_id>=$total_ques) $current_ques_id = 1;
			else  $current_ques_id = $user_ques_id+1;
		}else if( $db_ques_id != $user_ques_id){
			$current_ques_id = $db_ques_id;
		}else{
			$current_ques_id = 0;
		}
		
		return $current_ques_id;
	}
	
	
	public function getSentimentQuotes(){
		
		$current_quotes_id =1;
		
		$user_office_id=get_user_office_id();
		$current_user = get_user_id();
		
		$qSql = "Select max(id) as value from user_sentiment_quotes";
		$total_quotes = $this->Common_model->get_single_value($qSql);
		
		$cDate=GetLocalDate();
		
		//$prev_date = date('Y-m-d', strtotime(date($cDate) .' -1 day'));
		//$prev_date2 = date('Y-m-d', strtotime(date($cDate) .' -2 day'));
		
		$qSql = "Select quotes_id as value from user_sentiment_answare where user_id = '$current_user' order by id desc limit 1  ";
		$user_quotes_id = $this->Common_model->get_single_value($qSql);
		
		$qSql = "Select quotes_id as value from user_sentiment_answare where date_added_local='$cDate' and user_id in (select id from signin where office_id='$user_office_id') order by id desc limit 1  ";
		$db_quotes_id = $this->Common_model->get_single_value($qSql);
				
		if($db_quotes_id=="" && $user_quotes_id==""){
			$current_quotes_id = 1;
		}else if($db_quotes_id==""){
			if($user_quotes_id>=$total_quotes) $current_quotes_id = 1;
			else  $current_quotes_id = $user_quotes_id+1;
		}else if( $db_quotes_id != $user_quotes_id){
			$current_quotes_id = $db_quotes_id;
		}else{
			$current_quotes_id = 1;
		}
		
				
		return $current_quotes_id;
	}
	
	
	
	
	
					
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function home_new(){
		if(check_logged_in()){
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$data["content_template"] = "home/home_test.php";
			
			 $this->load->view('dashboard_single_col',$data);
		}
	}
	
	private function un_read_count()
	{
		$get_client_id=get_client_ids();
		$current_user = get_user_id();
		$dept_ids = get_dept_id();
		$client_ids = get_client_ids();
		$process_ids = get_process_ids();
		$office_id = get_user_office_id();
		$query = array();
		if(get_global_access() != 1)
		{
			if($process_ids != '')
			{
				$query[] = 'process_id IN(0,'.$process_ids.')';
			}
			if($client_ids != '')
			{
				$query[] = 'client_id IN(0,'.$client_ids.')';
			}
			if($dept_ids != 0 && $dept_ids != '')
			{
				$query[] = 'department_id IN(0,'.$dept_ids.')';
			}
			$query[] = 'location_id="'.$office_id.'"';
			$query = '(SELECT faq_messageboard.id as message_id,faq_messageboard.*,GROUP_CONCAT(faq_msg_attach.file_name SEPARATOR ",") AS file_name,GROUP_CONCAT(faq_msg_attach.id SEPARATOR ",") AS attached_img_id FROM `faq_messageboard` LEFT JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id  LEFT JOIN faq_msg_attach ON faq_msg_attach.msgid=faq_messageboard.id WHERE faq_messageboard.id NOT IN(SELECT faq_messageboard.id as message_id FROM `faq_messageboard` INNER JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id AND faq_message_read_stat.user_id="'.$current_user.'") AND '.implode(' AND ',$query).' AND individual = 0 GROUP BY faq_messageboard.id ORDER BY faq_messageboard.id DESC)
			UNION
			(SELECT faq_messageboard.id as message_id,faq_messageboard.*,GROUP_CONCAT(faq_msg_attach.file_name SEPARATOR ",") AS file_name,GROUP_CONCAT(faq_msg_attach.id SEPARATOR ",") AS attached_img_id FROM `faq_messageboard` LEFT JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id  LEFT JOIN faq_msg_attach ON faq_msg_attach.msgid=faq_messageboard.id WHERE faq_messageboard.id NOT IN(SELECT faq_messageboard.id as message_id FROM `faq_messageboard` INNER JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id AND faq_message_read_stat.user_id="'.$current_user.'") AND '.implode(' AND ',$query).' AND individual = 1 AND find_in_set('.$current_user.',individual_ids) GROUP BY faq_messageboard.id ORDER BY faq_messageboard.id DESC)';
		}
		else
		{
			$query = 'SELECT faq_messageboard.id as message_id,faq_messageboard.* FROM `faq_messageboard` LEFT JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id WHERE faq_messageboard.id NOT IN(SELECT faq_messageboard.id as message_id FROM `faq_messageboard` INNER JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id AND faq_message_read_stat.user_id="'.$current_user.'") GROUP BY faq_messageboard.id';
		}

		$data["aside_template"] = "message/aside.php";
		$data["content_template"] = "message/unread_message.php";
		
		$query = $this->db->query($query);
		
		return $query->num_rows();
	}
	
	
	
	
	
	//============== SELF DECLARATION COVID SUBMISSION ================================================//
	
	public function covid_check_screening_submit_phillipines(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			
			$covid_submission_type = $this->input->post('covid_submission_type');
			
				$employee_will_vaccinated = $this->input->post('employee_will_vaccinated');
				$data_array = array(
					"user_id"     			   => $current_user,
					"employee_will_vaccinated"     => $employee_will_vaccinated,
					"employee_acceptance"      => 1,
					"date_added" => CurrMySqlDate(),
					"date_added_local" => GetLocalTime(),
					"added_by" => $current_user
				);
				$submission_id = data_inserter('covid19_screening_checkup_phil', $data_array);

			redirect('home');
			
		}
	}
	
	public function covid_check_screening_submit(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			
			$covid_submission_type = $this->input->post('covid_submission_type');
				if($covid_submission_type == 1)
				{
					$employee_temperature = $this->input->post('employee_temperature');
					$employee_is_outside = $this->input->post('employee_is_outside');
					$employee_is_symptom = $this->input->post('employee_is_symptom');
					$employee_symptoms = $this->input->post('employee_symptoms');
					$employee_is_exposed = $this->input->post('employee_is_exposed');
					$employee_is_family_covid = $this->input->post('employee_is_family_covid');
									
					$phone_number_update = $this->input->post('phone_number_update');
					if($phone_number_update == 1)
					{					
						$employee_phone = $this->input->post('employee_phone');				
						if(!empty($employee_phone))
						{
							$data_array = array(
								"phone" => $employee_phone
							);
							$this->db->where('user_id', $current_user);
							$this->db->update('info_personal', $data_array);
						}
					}
					
					$data_array = array(
						"user_id"     			   => $current_user,
						"employee_temperature"     => $employee_temperature,
						"employee_is_outside"      => $employee_is_outside,
						"employee_is_symptom"      => $employee_is_symptom,
						"employee_symptoms"        => $employee_symptoms,
						"employee_is_exposed" 	   => $employee_is_exposed,
						"employee_is_family_covid" => $employee_is_family_covid,
						"employee_acceptance"      => 1,
						"date_added" => CurrMySqlDate(),
						"date_added_local" => GetLocalTime(),
						"added_by" => $current_user,
						"logs" => $employee_is_family_covid
					);
					$submission_id = data_inserter('covid19_screening_checkup', $data_array);

					//CHECK IF CONCERNED CASE
					if($employee_is_outside == 'Y' || $employee_is_symptom == 'Y' || $employee_is_exposed == 'Y' || $employee_is_family_covid == 'Y')
					{
						$localDate = GetLocalDate();
						$this->send_email_covid_screening($submission_id, $current_user, $localDate);
						
					}
				}
				
				if($covid_submission_type == 2)
				{
					$employee_screening_covid_id = $this->input->post('employee_screening_covid_id');
					$employee_consent = $this->input->post('employee_consent');
					
					$data_array = array(
						"employee_consent" => 1
					);
					$this->db->where('id', $employee_screening_covid_id);
					$this->db->update('covid19_screening_checkup', $data_array);			
				}
			
			redirect($_SERVER['HTTP_REFERER']);
			
		}
	}

	public function send_email_covid_screening($submission_id, $current_user, $covid_current_date)
	{
		$eto="";
		$ecc="";
		$nbody="";
		
		$covid_start_date = $covid_current_date ." 00:00:00"; $covid_end_date = $covid_current_date ." 23:59:59"; 
		$sql_covid_consent = "SELECT * from covid19_screening_checkup WHERE date_added_local >= '$covid_start_date' AND date_added_local <= '$covid_end_date' AND user_id = '$current_user' ORDER by id DESC LIMIT 1";
		$covid_consent_details = $this->Common_model->get_query_row_array($sql_covid_consent);
				
		$covid_user_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, sp.phone as employee_phone,
			         CONCAT(l.fname, ' ', l.lname) as l1_supervisor, lp.phone as supervisor_phone, d.description as department, r.name as designation
			         from signin as s 
					 LEFT JOIN department as d on d.id=s.dept_id
					 LEFT JOIN role as r on r.id=s.role_id
					 LEFT JOIN signin as l ON l.id = s.assigned_to
					 LEFT JOIN info_personal as lp ON lp.user_id = s.assigned_to
					 LEFT JOIN info_personal as sp ON sp.user_id = s.id
					 WHERE s.id = '$current_user'";
		$contactQ = $this->Common_model->get_query_row_array($covid_user_sql);
		if(!empty($covid_consent_details['id']))
		{
			$email_subject = "Covid Screening | May Be Positive | " .$covid_consent_details['fusion_id'] ." | " .$covid_current_date;
			$eto = 'employee.connect@fusionbposervices.com';
			//$ecc = 'lalita.sinha@fusionbposervices.com';
			$ecc = '';
			$from_email="noreply.fems@fusionbposervices.com";
			$from_name="Fusion FEMS";
						
			$nbody='<b>CONCERNED CASE FOUND :</b><br/><br/>
					Please analyse this case, needs to be reviewed once : </br></br>  
					<b>Fusion ID :</b> '.$contactQ['fusion_id'] .'<br/>
					<b>Employee Name :</b> '.$contactQ['fullname'] .'<br/>
					<b>Employee Phone :</b> '.$contactQ['employee_phone'] .'<br/>
					<b>Department :</b> '.$contactQ['department'] .'<br/>
					<b>Designation :</b> '.$contactQ['designation'] .'<br/><br/>
					<b>Supervisor :</b> '.$contactQ['l1_supervisor'] .'<br/>
					<b>Supervisor Phone :</b> '.$contactQ['supervisor_phone'] .'<br/>
					</br>
					</br>
							
					<b>CASE Details :</b><br/></br>
					<table border="1" width="80%" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Temperature Measured :</td>
								<td style="padding:2px 0px 2px 8px">'.$covid_consent_details["employee_temperature"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">In the last 30 days have you traveled outside :</td>
								<td style="padding:2px 0px 2px 8px">'.$covid_consent_details["employee_is_outside"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Any Symptoms:</td>
								<td style="padding:2px 0px 2px 8px">'.$covid_consent_details["employee_is_symptom"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Entered Symptoms:</td>
								<td style="padding:2px 0px 2px 8px">'.$covid_consent_details["employee_symptoms"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Exposed to someone being tested for COVID-19 :</td>
								<td style="padding:2px 0px 2px 8px">'.$covid_consent_details["employee_is_exposed"].'</td>
							</tr>
							<tr>
								<td style="background-color:powderblue;padding:2px 0px 2px 8px">Any members or household in quarantine :</td>
								<td style="padding:2px 0px 2px 8px">'.$covid_consent_details["employee_is_family_covid"].'</td>
							</tr>
					</table>
									
				</br>
				</br>
				</br>
						
				<b>Regards, </br>
				Fusion - FEMS	</b></br>
				';
				
			$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "",$from_email,$from_name,'Y');	
			
		}
			
				
	}
	
		
	
	
	//============== SCHEDULE ROUTINE CHECK SUBMISSION ===================================//
	
	public function schedule_accept_submit(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			//echo "<pre>".print_r($_POST, 1)."</pre>";
			
			$schedule_submission_type = $this->input->post('schedule_submission_type');			
			$schedule_id_chekbox = $this->input->post('schedule_id_chekbox');
			
			foreach($schedule_id_chekbox as $scheduleID)
			{
				$data_array = [ "is_accept" => $schedule_submission_type ];
				$this->db->where('id', $scheduleID);
				$this->db->update('user_shift_schedule', $data_array);
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		
		}
	}


	public function viewdata()
	{
		if(check_logged_in()){
			
			$log            = get_logs();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			$curDateTime    = CurrMySqlDate();
			
			
			$file_id = trim($this->input->post('kid'));
			
			$file_sql  = "SELECT * from process_updates_attach WHERE id = '$file_id'";
			$fileArray = $this->Common_model->get_query_row_array($file_sql);
			
			$data['fileArray'] = $fileArray;
			$this->load->view('home/documentview',$data);
			
		
		}
	}


		//--- EXCEL READER -------//
	public function checkexcel()
	{
		$this->load->library('excel');
		
		$file_id = $this->uri->segment(3);
		$file_sql  = "SELECT * from process_updates_attach WHERE id = '$file_id'";
		$fileArray = $this->Common_model->get_query_row_array($file_sql);
		$data['fileArray'] = $fileArray;
		$file_dir = "uploads/process_updates/" .$fileArray['pu_id'] ."-" .$fileArray['id'] ."." .$fileArray['ext'];
		
		$file_path = $file_dir;
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		echo "<title>View File - ".$fileArray['file_name'] ."</title>";
		echo "<style>body{ cursor:cell; } th,td{ border:1px solid #ccc!important; } th:focus,th:active,td:focus,td:active{ background-color:#ccc; border:2px solid #222!important; } .selectedcell{ background-color : #3297FD!important; border:2px solid #222!important; color:#ffffff!important; } td::selection{ background-color:#3297FD; color:#ffffff; } .box{ text-align: right; } .alertbox{ display: none; position: absolute; background-color:#d4e6d4; color:#333; padding: 5px 10px; font-weight: 400; border-radius: 5px; } </style>";
		
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$sheetno = $this->uri->segment(4);
		$objPHPExcel = $objReader->load($file_path); 
		$sheetCount = $objPHPExcel->getSheetCount();
		$worksheetname = $objPHPExcel->getSheetNames();
		// $i=0;
		// foreach($worksheetname as $tokenn)
		// {
		// 	$mycolor = "#f6f7f9";
		// 	if($i == $sheetno){ $mycolor = "#d6e1f2"; }
		// 	echo "<a style='padding:4px 10px;background-color:".$mycolor.";color:#000;text-decoration:none;border-radius:2px;' href='".base_url()."/knowledge/checkexcel/".$file_id."/".$i."'> &#128206; ".$tokenn ."</a> ";
		// 	$i++;
		// }
		echo "<br/><br/><br/>";
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
		$objWriter->setSheetIndex($sheetno);
		header("Content-Type: text/html");
		$objWriter->save("php://output");
		
		echo "<div class='alertbox'>Selected Content Copied!</div><div style='display:block;opacity:0' id='contentselection'></div>";
		echo "<script src='".base_url()."libs/bower/jquery/dist/jquery.js'></script>";
		echo $checkscript = <<<SCR
		<script>
		$('td').on("click", function (evt){
			if (evt.ctrlKey){
				$(this).toggleClass("selectedcell");
		     }
			 else if (evt.shiftKey){
				$(this).toggleClass("selectedcell");
				f_td = $('.selectedcell').first().index();
				f_tr = $('.selectedcell').parent('tr').first().index();
				l_td = $('.selectedcell').last().index();
				l_tr = $('.selectedcell').parent('tr').last().index();				
				for(i=f_tr;i<=l_tr;i++){
				   totaltd = $('tr:eq('+i+') td').length;
				   for(j=0;j<=totaltd;j++){
					 if(((i==f_tr) && (j<f_td)) || ((i==l_tr) && (j>l_td))){ }
					 else { $('tr:eq('+i+') td:eq('+j+')').addClass('selectedcell'); }
				   }
				}
		     }
			 else {
				$('td').removeClass('selectedcell');
				$(this).addClass('selectedcell');
			 }

			mycontent = "";
			// GET ALL SELECTED CONTENT
			$('.selectedcell').each(function(){
				mycontent += $(this).html();
				mycontent += "&nbsp;&nbsp;";
			});
			
			$('#contentselection').html(mycontent);
			const referenceNode = document.getElementById('contentselection');
			var range = document.createRange();
			range.selectNodeContents(referenceNode);  
			var sel = window.getSelection(); 
			sel.removeAllRanges(); 
			sel.addRange(range);
			document.execCommand('copy');
			$(".alertbox").css({
				top: evt.pageY,
				left: evt.pageX
			}).toggle();
			$('.alertbox').show();
			$('.alertbox').delay(600).fadeOut();
		});
		</script>
SCR;
		
	}
	
	
	public function get_leave_apply_list($current_user = ""){
		
		$this->load->model('Leave_model');
		$this->load->helper('leave_functions_helper');
		
		$data["user_office_id"] = $user_office_id = get_user_office_id();
		if(empty($current_user)) $current_user = get_user_id();	
		
		$user_site_id = get_user_site_id();
		$role_id = get_role_id();			
		$ses_dept_id = get_dept_id();						
		$is_global_access = get_global_access();
		
		$personal = $this->Leave_model->get_personal_data($current_user);
		$data["date_of_joining"] = $personal->doj; 
		$leaves_available = $this->Leave_model->get_leaves_available($current_user);
		
		$var_js = array();		
		$_user_id = $current_user;			
		$_l_struct = json_decode(json_encode($leaves_available), true);
		
		foreach($leaves_available as $key => $leave){
			
			$_leave_accessible = "";
			if($leave->extra_config_query!=""){
				$_leave_criteria_id = $leave->leave_criteria_id;
				$rr = $leave->extra_config_query;
				if($q = $this->db->query(sprintf($rr, $_user_id,$_leave_criteria_id, $_user_id))){
					$res = $q->result();
					foreach($res as $_r){
						$_leave_accessible = $_r->leave_access;	
					}	
				}
			}			
			if(leave_probation_extended()){ 
				$_leave_accessible = "a";
			}
			
			$rr = array();
			if($leave->has_sub_category){
				$sub_sections = $this->Leave_model->get_leave_criteria_extra_config_data($leave->leave_criteria_id);
				foreach($sub_sections as $subs){
					$rr[$subs->id] = array(
						"sub_leave_description" => $subs->description,
						"sub_deduction" => $subs->deduction
					);
				}
			}
			
			$var_js[$leave->leave_criteria_id] = array($leave->leave_type_id, $leave->leaves_present, $_leave_accessible, $leave->criteria, $leave->can_also_use_leave_criteria, $leave->has_sub_category, $rr);		
		}
		
		$data["var_js"] = json_encode($var_js);
		//$data["leave_structure"] = $leaves_available; 
		$data["leave_structure"] = $_l_struct;
		return $data;		
	}



}

?>