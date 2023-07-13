<?php

 class Qa_defect extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}


	


/////////////////Home  vikas//////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_defect/qa_defect_feedback.php";
			$data["content_js"] = "qa_sea_world_js.php";
			

					$qSql = "SELECT qa.*,p.name as processName,cl.fullname as clientName from qa_defect qa LEFT JOIN process p ON p.id=qa.process_id LEFT JOIN client cl ON cl.id=qa.client_id where qa.is_active=1 order by qa.id ASC";

					$tabledata= $this->Common_model->get_query_result_array($qSql);

					//print_r($tabledata);
					
					foreach($tabledata as  $tablevalue){
						//echo $tablevalue['tablename'];

						$sql_last_auditdate = "SELECT ta.entry_date from ".$tablevalue['table_name']." ta  order by ta.id DESC LIMIT 0,1";
						
						 $last_auditdate[] = $this->Common_model->get_query_row_array($sql_last_auditdate);
					}


        $data["qa_defect_data"] = $tabledata;
        $data["qa_last_audit_date"] = $last_auditdate;

			$this->load->view("dashboard",$data);
		}
	}

	///////////////////vikas/////////////////////////////


	//////////////////////vikas ends///////////////////////
	

//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// QA Sea World REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	// public function qa_defect_report(){
	// 	if(check_logged_in()){

	// 		$office_id = "";
	// 		$user_office_id=get_user_office_id();
	// 		$current_user = get_user_id();
	// 		$is_global_access=get_global_access();
	// 		$role_dir=get_role_dir();
	// 		$data["show_download"] = false;
	// 		$data["download_link"] = "";
	// 		$data["show_table"] = false;
	// 		$data["show_table"] = false;

	// 		$data["aside_template"] = "reports_qa/aside.php";
	// 		$data["content_template"] = "qa_defect/qa_defect_report.php";
	// 		$data["content_js"] = "qa_defect_js.php";

	// 		$date_from="";
	// 		$date_to="";
	// 		$action="";
	// 		$dn_link="";
	// 		$cond="";
	// 		$cond1="";
	// 		$cond2="";
	// 		$audit_type="";

	// 		$date_from = ($this->input->get('from_date'));
	// 		$date_to = ($this->input->get('to_date'));

	// 		if($date_from==""){
	// 				$date_from=CurrDate();
	// 			}else{
	// 				$date_from = mmddyy2mysql($date_from);
	// 			}

	// 			if($date_to==""){
	// 				$date_to=CurrDate();
	// 			}else{
	// 				$date_to = mmddyy2mysql($date_to);
	// 		}

	// 		$data["qa_defect_list"] = array();
	// 		//if($this->input->get('show')=='Show') {
	// 		   // $campaign = $this->input->get('campaign');
				
	// 			$office_id = $this->input->get('office_id');
	// 			$audit_type = $this->input->get('audit_type');

	// 			if($office_id=="All") $cond .= "";
	// 			else $cond .=" and office_id='$office_id'";

	// 			if($audit_type=="All" || $audit_type=="") $cond2 .= "";
	// 			else $cond2 .=" and audit_type='$audit_type'";

				

	// 			if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";

	// 			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
	// 				$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
	// 			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
	// 				$cond1 .=" And assigned_to='$current_user'";
	// 			}else{
	// 				$cond1 .="";
	// 			}

              
	// 				 $qSql="SELECT * from
	// 				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
	// 				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_defect_feedback) xx Left Join
	// 				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2 order by audit_date";

	// 				$fullAray = $this->Common_model->get_query_result_array($qSql);
	// 				$data["qa_defect_list"] = $fullAray;
			 

	// 			$this->create_qa_defect_CSV($fullAray);

	// 			$dn_link = base_url()."qa_defect/download_qa_defect_CSV";


	// 		//}
	// 		$data['location_list'] = $this->Common_model->get_office_location_list();

	// 		$data['download_link']=$dn_link;
	// 		$data["action"] = $action;
	// 		$data['from_date'] = $date_from;
	// 		$data['to_date'] = $date_to;
	// 		$data['office_id']=$office_id;
	// 		$data['audit_type']=$audit_type;

	// 		$this->load->view('dashboard',$data);
	// 	}
	// }

 //   ////////////Norther ///////////////////////////////
	// public function download_qa_defect_CSV()
	// {
	// 	$currDate=date("Y-m-d");
	// 	$filename = "./assets/reports/Report".get_user_id().".csv";
	// 	$newfile="Sea World Audit List-'".$currDate."'.csv";

	// 	header('Content-Disposition: attachment;  filename="'.$newfile.'"');
	// 	readfile($filename);
	// }

	// public function create_qa_defect_CSV($rr)
	// {

	// 	$filename = "./assets/reports/Report".get_user_id().".csv";
	// 	$fopen = fopen($filename,"w+");
	
	// 	 $header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "ACPT","Phone Number","File/Call ID","Reason of the Call","Site", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Possible Score", "Earned Score", "Overall Score",
	// 	 	"1a. Uses Proper Greeting.",
	// 	 	"1b. Uses Proper Closing.",
	// 	 	"2a. Agent maintained proper tone pitch volume clarity and pace throughout the call.",
	// 	 	"2b. Agent used courteous words and phrases. Also was friendly polite and professional.",
	// 	 	"2c.The agent adapted their approach to the customer based on the customers unique needs personality and issues.",
	// 	 	"2d. Active Listening.",
	// 	 	"3.1.a. Agent takes ownership of the call and resolves all issues that arise throughout the call.",
	// 	 	"3.1.b. Agent follows all SOP/Policies as stated in SharePoint.",
	// 	 	"3.1.c. Agent does not blame parks or other departments for problem guest is calling about.",
	// 	 	"3.1.d.The agent asked pertinent questions to accurately diagnose the guest's need or problem.",
	// 	 	"3.1.e. Agent used appropropriate resources to address the issue.",
	// 	 	"3.2.a. Agent is familiar with our products and provides accurate information.",
	// 	 	"3.2.b. Agent sounds confident and knowledgeable.",
	// 	 	"3.2.c. Agent presents a sense of urgency whenever applicable.",
	// 	 	"3.3.a Agent handles call efficiently through effective navigation and by not going over irrelevant products/information.",
	// 	 	"3.3.b. Uses proper hold procedure - Agent asks guest permission to place them on hold - Agent checks back in on guest every 2 minutes while on hold - Agent does not place guest on any unnecessary holds.",
	// 	 	"3.3.c. Agent minimized or eliminated dead air.",
	// 	 	"1a. Uses Proper Greeting. - Remarks",
	// 	 	"1b. Uses Proper Closing. - Remarks",
	// 	 	"2a. Agent maintained proper tone pitch volume clarity and pace throughout the call. - Remarks",
	// 	 	"2b. Agent used courteous words and phrases. Also was friendly polite and professional. - Remarks",
	// 	 	"2c.The agent adapted their approach to the customer based on the customers unique needs personality and issues. - Remarks",
	// 	 	"2d. Active Listening. - Remarks",
	// 	 	"3.1.a. Agent takes ownership of the call and resolves all issues that arise throughout the call. - Remarks",
	// 	 	"3.1.b. Agent follows all SOP/Policies as stated in SharePoint. - Remarks",
	// 	 	"3.1.c. Agent does not blame parks or other departments for problem guest is calling about. - Remarks",
	// 	 	"3.1.d.The agent asked pertinent questions to accurately diagnose the guest's need or problem. - Remarks",
	// 	 	"3.1.e. Agent used appropropriate resources to address the issue. - Remarks",
	// 	 	"3.2.a. Agent is familiar with our products and provides accurate information. - Remarks",
	// 	 	"3.2.b. Agent sounds confident and knowledgeable. - Remarks",
	// 	 	"3.2.c. Agent presents a sense of urgency whenever applicable. - Remarks",
	// 	 	"3.3.a Agent handles call efficiently through effective navigation and by not going over irrelevant products/information. - Remarks",
	// 	 	"3.3.b. Uses proper hold procedure - Agent asks guest permission to place them on hold - Agent checks back in on guest every 2 minutes while on hold - Agent does not place guest on any unnecessary holds. - Remarks",
	// 	 	"3.3.c. Agent minimized or eliminated dead air. - Remarks",
	// 	 	"Asked if guest wants to use AMEX",
	// 	 	"Explains Ezpay Contract / Cxl Policies",
	// 	 	"Never rude to a guest",
	// 	 	"Leaves COMPLETE notes in all accounts/orders",
	// 	 	"Qualifies Park by city/state",
	// 	 	"Uses the correct disposition codes",
 //    "Call Summary/Observation","Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)",  "Feedback","Agent Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

		

	// 	$row = "";
	// 	foreach($header as $data) $row .= ''.$data.',';
	// 	fwrite($fopen,rtrim($row,",")."\r\n");
	// 	$searches = array("\r", "\n", "\r\n");

	// 		foreach($rr as $user){
	// 			 if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
	// 			 	$interval1 = '---';
	// 			 }else{
	// 			 	$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
	// 			 }

	// 			$row = '"'.$user['auditor_name'].'",';
	// 			$row .= '"'.$user['audit_date'].'",';
	// 			$row .= '"'.$user['fusion_id'].'",';
	// 			$row .= '"'.$user['fname']." ".$user['lname'].'",';
	// 			$row .= '"'.$user['tl_name'].'",';
	// 			$row .= '"'.$user['acpt'].'",';
	// 			$row .= '"'.$user['customer_phone'].'",';
	// 			$row .= '"'.$user['call_id'].'",';
	// 			$row .= '"'.$user['call_reason'].'",';
	// 			$row .= '"'.$user['site'].'",';
	// 			$row .= '"'.$user['call_date'].'",';
	// 			$row .= '"'.$user['call_duration'].'",';
	// 			$row .= '"'.$user['audit_type'].'",';
	// 			$row .= '"'.$user['auditor_type'].'",';
	// 			$row .= '"'.$user['voc'].'",';
	// 			$row .= '"'.$user['possible_score'].'",';
	// 			$row .= '"'.$user['earned_score'].'",';
	// 			$row .= '"'.$user['overall_score'].'",';
	// 			$row .= '"'.$user['use_proper_greeting'].'",';
	// 			$row .= '"'.$user['use_proper_closing'].'",';
	// 			$row .= '"'.$user['proper_tone'].'",';
	// 			$row .= '"'.$user['courteous_words'].'",';
	// 			$row .= '"'.$user['agent_adapted_approach'].'",';
	// 			$row .= '"'.$user['active_listening'].'",';
	// 			$row .= '"'.$user['agent_takes_ownership'].'",';
	// 			$row .= '"'.$user['follows_all_SOP'].'",';
	// 			$row .= '"'.$user['blame_parks'].'",';
	// 			$row .= '"'.$user['asked_pertinent_questions'].'",';
	// 			$row .= '"'.$user['used_appropropriate_resources'].'",';
	// 			$row .= '"'.$user['accurate_information'].'",';
	// 			$row .= '"'.$user['sounds_confident'].'",';
	// 			$row .= '"'.$user['sense_of_urgency'].'",';
	// 			$row .= '"'.$user['effective_navigation'].'",';
	// 			$row .= '"'.$user['proper_hold_procedure'].'",';
	// 			$row .= '"'.$user['eliminated_dead_air'].'",';
 //        $row .= '"'.$user['cmt1'].'",';
 //        $row .= '"'.$user['cmt2'].'",';
 //        $row .= '"'.$user['cmt3'].'",';
 //        $row .= '"'.$user['cmt4'].'",';
 //        $row .= '"'.$user['cmt5'].'",';
 //        $row .= '"'.$user['cmt6'].'",';
 //        $row .= '"'.$user['cmt7'].'",';
 //        $row .= '"'.$user['cmt8'].'",';
 //        $row .= '"'.$user['cmt9'].'",';
 //        $row .= '"'.$user['cmt10'].'",';
 //        $row .= '"'.$user['cmt11'].'",';
 //        $row .= '"'.$user['cmt12'].'",';
 //        $row .= '"'.$user['cmt13'].'",';
 //        $row .= '"'.$user['cmt14'].'",';
 //        $row .= '"'.$user['cmt15'].'",';
 //        $row .= '"'.$user['cmt16'].'",';
 //        $row .= '"'.$user['cmt17'].'",';
 //        $row .= '"'.$user['use_AMEX_cmt'].'",';
 //        $row .= '"'.$user['Cxl_Policies_cmt'].'",';
 //        $row .= '"'.$user['rude_to_guest_cmt'].'",';
 //        $row .= '"'.$user['leave_complete_notes_cmt'].'",';
 //        $row .= '"'.$user['qualifies_Park_cmt'].'",';
 //        $row .= '"'.$user['correct_disposition_codes_cmt'].'",';
	// 			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
	// 			$row .= '"'.$user['audit_start_time'].'",';
	//       $row .= '"'.$user['entry_date'].'",';
	//       $row .= '"'.$interval1.'",';
	// 			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
	// 			$row .= '"'.$user['agnt_fd_acpt'].'",';
	// 			$row .= '"'.$user['agent_rvw_date'].'",';
	// 			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
	// 			$row .= '"'.$user['mgnt_rvw_date'].'",';
	// 			$row .= '"'.$user['mgnt_rvw_name'].'",';
	// 			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
	// 			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_name'])).'",';
	// 			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';

 //  			$row .= '"'.$user['client_rvw_date'].'",';

	// 			fwrite($fopen,$row."\r\n");
	// 		}
	// 		fclose($fopen);
	// }
}
