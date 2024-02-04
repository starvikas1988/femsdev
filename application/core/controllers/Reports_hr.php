<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_hr extends CI_Controller {

    private $aside = "reports_hr/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Dfr_model');
		$this->reports_model->set_report_database("report");
		
		$this->objPHPExcel = new PHPExcel();
		
	 }
	 
    public function index()
    {
		
				
        if(check_logged_in())
        {
			$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
			
			$data["role_dir"]=$role_dir;
			
				
				$data['user_list'] =array();
								
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				
				$client_id = "";
				$site_id = "";
				$office_id = "";
				$dept_id = "";
				if($dept_id=="")  $dept_id=$ses_dept_id;
				
				$time_zone="";
				$sdValue="";
				
				$dn_link="";
				
								
				if($office_id=="")  $office_id=$user_office_id;
				
				if($this->input->get('showReports')=='Show' || $this->input->get('downloadReport')=='Download CSV' || $this->input->get('downloadRawDta')=='Download Login Raw Data')
				{
					$start_date = $this->input->get('start_date');
					$end_date = $this->input->get('end_date');
					
					$client_id = $this->input->get('client_id');
					$site_id = $this->input->get('site_id');
					$office_id = $this->input->get('office_id');
					if($office_id=="")  $office_id=$user_office_id;
					
					$dept_id = $this->input->get('dept_id');
					if($dept_id=="")  $dept_id=$ses_dept_id;
					
					$time_zone = $this->input->get('time_zone');
					if($time_zone=="") $time_zone="Local";
					
					$sdValue = $this->input->get('sub_dept_id');
										
					$filter_key = $this->input->get('filter_key');
										
					$filterArray = array(
                            "start_date" => $start_date,
							"end_date" => $end_date,
							"client_id" => $client_id,
							"office_id" => $office_id,
							"site_id" => $site_id,
							"filter_key" => $filter_key,
							"user_site_id"=> $user_site_id,
							"dept_id"=> $dept_id,
							"sub_dept_id"=> $sdValue,
							"time_zone"=> $time_zone,
                     ); 
					
					
					//print_r ($filterArray);
					
					if($filter_key!="" && $filter_key!="OfflineList" ){
					
						switch(trim($filter_key)){
							case 'Site':
								$filter_value = $this->input->get('site_id');
								break;
							case 'Agent':
								$filter_value = $this->input->get('agent_id');
								break;
							case 'Process':
								$filter_value = $this->input->get('process_id');
								
								break;
							case 'Disposition':
								$filter_value = $this->input->get('disp_id');
								break;
							case 'Role':
								$filter_value = $this->input->get('role_id');
								break;
							case 'AOF':
								$filter_value = $this->input->get('assign_id');
								break;	
						}
						
						if($filter_value=="") $filter_value = $this->input->get('filter_value');
						
									
					}
					
					$filterArray["filter_value"]=$filter_value;
					
					
					if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
					else $filterArray["assigned_to"]="";	
					
					$qSQL="SELECT id,name FROM process WHERE is_active=1 and client_id='$client_id' ORDER BY name";
										
								
					if ($this->input->get('downloadRawDta')=='Download Login Raw Data'){
						$rr = $fullArr = $this->reports_model->get_user_login_raw_data($filterArray,"");
					}else{
						$rr = $fullArr = $this->reports_model->get_user_list_report($filterArray,"","Y");
					}
					
					// echo "<pre>";
					// print_r($fullArr);
			
					//////////LOG////////
					//http_build_query($filterArray);die();
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					
					$LogMSG="View OR Download Main Report with ". $all_params;
					
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
					////////////////////////////////////////////////////////////////
					
					//
					// Pagination Module Start
					//
					
					if ($this->input->get('downloadRawDta')=='Download Login Raw Data'){
						
						$this->create_raw_CSV($fullArr,$filterArray,true);
						
					}else if ($this->input->get('downloadReport')=='Download CSV'){
												
						$this->create_CSV($fullArr,$filterArray,true);
						
					}else{
						
						$_total_rows = count($rr);
						
						$_per_page = 50;	// defaults for number of records to show
						$_uri_segment = 2;
						
						$_page_url = base_url()."reports";
						
						$qStr = array(
								"start_date" => $start_date,
								"end_date" => $end_date,
								"client_id" => $client_id,
								"office_id" => $office_id,
								"site_id" => $site_id,
								"dept_id"=> $dept_id,
								"sub_dept_id"=> $sdValue,
								"time_zone"=> $time_zone,
								"filter_value" => $filter_value,
								"filter_key" => $filter_key,
								"showReports" => "Show"
							); 
						
						//print_r($qStr);
						
						$res = pagination_config( $_page_url , $_total_rows , $_per_page, $_uri_segment,$qStr );
						
						$data['links'] = $res["links"];
						$data['total'] = $_total_rows;
						$data['start'] = $res['start'];
						$data['limit'] = $res['limit'];
						$data['no_records'] = ($_total_rows==0 ? true : false);
						
						if($res['start'] > $_total_rows) redirect($_page_url,"refresh");
						
						if((($res["page_number"]-1) * $_per_page) <= $_total_rows ) 
						{
							if(($res["page_number"] * $_per_page) - $_per_page < 0) $_start_limit = 0;
							else $_start_limit = ($res["page_number"] * $_per_page) - $_per_page;
							
							$data['user_list'] = array_splice($rr,$_start_limit,$_per_page);
							
						}
						else
						{
							$data['user_list'] = $rr;
							redirect($_page_url,"refresh");
						}
											
						//
						// Pagination Module End
						//
						
						//print $this->reports_model->get_user_list_report_count($filterArray);
						
						$this->create_CSV($fullArr,$filterArray);
						
						//$dn_link = "../assets/reports/Report".get_user_id().".csv";
						$dn_link = base_url()."reports_hr/downloadCsv";
						
						}
						
					}else{
						$data['links'] = "";
						$data['total'] = "";
						$data['start'] = "";
						$data['limit'] = "";
						$data['no_records'] = true;
					}
				
				
					
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['ses_role_id']=$role_id;
				$data['time_zone']=$time_zone;
				
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "reports_hr/rep_main.php";
			    
				$data['client_list'] = $this->Common_model->get_client_list();
				
				if(get_role_dir()=="super" || $is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
					
					
				if($client_id=="" || $client_id=="ALL") $data['process_list'] = array(); 
				else $data['process_list'] = $this->Common_model->get_process_list($client_id);
				
				$data['process_list'] = array();
				
				
				$data['disp_list'] = $this->Common_model->get_event_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if(get_role_dir()=="super" || $is_global_access==1 || get_dept_folder()=="rta"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
				
				$data['department_list'] = $this->Common_model->get_department_list();	
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					if($dept_id=="ALL" || $dept_id=="") $data['sub_department_list'] = array();
					else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
				}
			
				
				if($filter_key=="") $othVal="";
				else if($filter_key=="OfflineList") $othVal="OfflineList";
				else $othVal=$filter_key."-".$filter_value;
				
				$dn_param='sd='.$start_date.'&ed='.$end_date.'&oth='.$othVal; 
				$dn_param2=$_SERVER["QUERY_STRING"];
								
				$data['dn_param']=$dn_param;
				$data['dn_param2']=$dn_param2;
				$data['download_link']=$dn_link;
				
				$this->load->view('dashboard',$data);
			
        }
    }
	
	public function downloadCsv()
	{		
		$s_date = $this->input->get('sd');
		$e_date = $this->input->get('ed');
		$oth = $this->input->get('oth');
		
		//////////LOG////////
		$Lfull_name=get_username();
		$LOMid=get_user_omuid();
		$LogMSG="Download Main Report";
		log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
		//////////
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="report-".$s_date."to".$e_date. "-" .$oth.".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_CSV($rr,$fArray,$isDownload=false)
	{
				
		$filter_key=$fArray["filter_key"];
		$time_zone = $fArray["time_zone"];
		
		if($filter_key!="" && $filter_key!="OfflineList") $filter_value=$fArray["filter_value"];
		else $filter_value="";
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		
		$fopen = fopen($filename,"w+");
	
		//$header = array("Date", "OM ID", "Agent Name", "Site", "Process", "Role", "Team Leader", "Login Date", "Login Time", "Logout Time", "Logged In Hours", "Disposition", "Comments");
		
		if($time_zone=="Both"){
			
			$header = array("Date", "Fusion ID", "Site/XPOID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time (EST)", "Login Time(Local)", "Logout Time (EST)", "Logout Time (Local)", "Logged In Hours (EST)", "Logged In Hours (Local)","Other Break (EST)", "Other Break (Local)", "Lunch/Dinner Break (EST)" ,"Lunch/Dinner Break (Local)", "Disposition (EST)", "Disposition (Local)", "Night Differential (Local)", "Schedule IN", "Schedule OUT", "Comments","Log");		
		
		}else{
				$header = array("Date", "Fusion ID", "Site/XPOID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time ($time_zone)", "Logout Time ($time_zone)", "Logged In Hours ($time_zone)","Other Break ($time_zone)", "Lunch/Dinner Break ($time_zone)" , "Disposition ($time_zone)", "Night Differential", "Schedule IN", "Schedule OUT", "Comments","Log");
		}
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");
		
		//echo "<pre>";
		//print_r($rr);
		//echo "</pre>";
		
		foreach($rr as $user)
		{	
		
			$logged_in_hours=$user['logged_in_hours'];
			$logged_in_hours_local = $user['logged_in_hours_local'];
			
			$work_time=$user['logged_in_sec'];
			$work_time_local=$user['logged_in_sec_local'];
									
			$tBrkTime=$user['tBrkTime'];
			$tBrkTimeLocal=$user['tBrkTimeLocal'];
			
			$ldBrkTime=$user['ldBrkTime'];
			$ldBrkTimeLocal=$user['ldBrkTimeLocal'];
			
			$disposition=$user['disposition'];
						
			$todayLoginTime=$user['todayLoginTime'];
			$is_logged_in = $user['is_logged_in'];
						
			$office_id = $user['office_id'];
			$role_id=$user['role_id'];
			
			$flogin_time = $user['flogin_time'];
			$flogin_time_local = $user['flogin_time_local'];
			
			$logout_time=$user['logout_time'];
			$logout_time_local=$user['logout_time_local'];
			
			$login_log_est=$user['login_log_est'];
			if($login_log_est=="") $login_log_est=$user['logout_log_est'];
			
			$login_log_local=$user['login_log_local'];
			if($login_log_local=="") $login_log_local=$user['logout_log_local'];
			
			$doj=$user['doj'];
			$rdate=$user['rDate'];
			
			$total_break=$tBrkTime+$ldBrkTime;
			$total_break_local=$tBrkTimeLocal+$ldBrkTimeLocal;
			
			$omuid= $user['omuid'];
			$xpoid= $user['xpoid'];
			if($xpoid!="") $omuid = $xpoid;
			
			$leave_dtl = "";
			$leave_status = $user['leave_status'];
			if($user['leave_type'] !=""){
				if( $leave_status == '0') $leave_dtl = $user['leave_type'] . " Applied";
				else if( $leave_status == '1') $leave_dtl = $user['leave_type'] . " Approved";
				else if( $leave_status == '2') $leave_dtl = $user['leave_type'] . " Reject";
			}
			
			
			if($rdate < $doj) continue;
			
			$comments = $user['comments'];
			
			////////// For System Logout /////////////////////
			if($user['logout_by']=='0' && $logged_in_hours_local!="0"){
				//$net_work_time=0;
				//$net_work_time_local = 0;
				//$logout_time="";
				$comments = "System Logout";
			}
						
			if($work_time == 0){
				$net_work_time="";
				$total_break = "";
				$tBrkTime = "";
				$ldBrkTime = "";
			}else{
				
				$net_work_time=gmdate('H:i:s',$work_time);
				$total_break = gmdate('H:i:s',$total_break);
				$tBrkTime = gmdate('H:i:s',$tBrkTime);
				$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
			}
			
			if($work_time_local==0){
				$net_work_time_local="";
				$total_break_local="";
				$tBrkTimeLocal = "";
				$ldBrkTimeLocal = "";
			
			}else{
				
				$net_work_time_local=gmdate('H:i:s',$work_time_local);
								
				$total_break_local = gmdate('H:i:s',$total_break_local);
				$tBrkTimeLocal = gmdate('H:i:s',$tBrkTimeLocal);
				$ldBrkTimeLocal = gmdate('H:i:s',$ldBrkTimeLocal);
			}
			
									
				if($is_logged_in == '1'){
					$todayLoginArray = explode(" ",$todayLoginTime);
					$todayLoginTime_local = ConvServerToLocalAny($todayLoginTime,$office_id);
					$todayLoginArray_local = explode(" ",$todayLoginTime_local);
					
					if($rdate == $todayLoginArray[0]){
						
						$flogin_time = $todayLoginTime;
						$disposition="online";
						$net_work_time="";
						$total_break = "";
						$tBrkTime = "";
						$ldBrkTime = "";
						$logout_time="";
					}
					
					if($rdate == $todayLoginArray_local[0]){
							$flogin_time_local=$todayLoginTime_local;
							$disposition="online";
							$net_work_time_local="";
							$total_break_local="";
							$tBrkTimeLocal = "";
							$ldBrkTimeLocal = "";
							$logout_time_local="";
					}
				}

			
			
			
			$disposition_est = "";
			if($logged_in_hours!="0"){
				if($user['user_disp_id']=="8" || $user['user_disp_id']=="7") $disposition_est =  " P &". $disposition;
				else $disposition_est =  "P";
			}else if($disposition!="") $disposition_est =  $disposition; 
			else if($rdate < $user['doj']) $disposition_est = "";
			else if($leave_dtl!="") $disposition_est = $leave_dtl;	
			else $disposition_est =  "Absent"; 
			
			$disposition_local="";
			
			if($logged_in_hours_local!="0"){
				if($user['user_disp_id']=="8" || $user['user_disp_id']=="7") $disposition_local =  " P &". $disposition;
				else $disposition_local =  "P";
			}else if($disposition!="") $disposition_local =  $disposition; 
			else if($rdate < $user['doj']) $disposition_local = "";
			else if($leave_dtl!="") $disposition_local = $leave_dtl;
			else $disposition_local =  "Absent"; 
			
			$SkipRole="-#82#112#221#";
			$SkipLocation="-#ELS#JAM#";
			
			if( strpos($SkipRole,"#".$role_id."#") != false && strpos($SkipLocation,"#".$office_id."#") !=false){
				if($disposition_local=="Absent") $disposition_local = "LI";
				if($disposition_est=="Absent") $disposition_est = "LI";
			}
			
			//$night_login=gmdate('H:i:s', get_night_login($flogin_time_local,$logout_time_local,$user['office_id']));
			$night_login = gmdate('H:i:s', $user['NightLogin']);
			
			if($time_zone=="Local"){
				$flogin_time = $flogin_time_local;
				$logout_time = $logout_time_local;
				
				$net_work_time = $net_work_time_local;
				$tBrkTime = $tBrkTimeLocal;
				
				$ldBrkTime = $ldBrkTimeLocal;
				$disposition_est = $disposition_local;
				
				$iplog_est=$iplog_local;
						
			}
			
			if($time_zone=="EST") $night_login=0;
									
			$row = '"'.$rdate.'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$omuid.'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['process_name'].' '.$user['sub_process_name'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
			
			//$row .= '"'.$user['role_name'].'",'; 
			//$row .= '"'.$user['login_date'].'",'; 
			
			if($time_zone=="Both"){
				
				$row .= '"'.$flogin_time.'",';
				$row .= '"'.$flogin_time_local.'",'; 
				$row .= '"'.$logout_time.'",'; 
				$row .= '"'.$logout_time_local.'",'; 
				
				$row .= '"'.$net_work_time.'",';
				$row .= '"'.$net_work_time_local.'",';
				
				$row .= '"'.$tBrkTime.'",';
				$row .= '"'.$tBrkTimeLocal.'",'; 
				
				$row .= '"'.$ldBrkTime.'",'; 
				$row .= '"'.$ldBrkTimeLocal.'",'; 
				
				$row .= '"'.$disposition_est.'",';
				$row .= '"'.$disposition_local.'",';
				
			}else{
				$row .= '"'.$flogin_time.'",';
				$row .= '"'.$logout_time.'",'; 
				$row .= '"'.$net_work_time.'",';
				$row .= '"'.$tBrkTime.'",';			
				$row .= '"'.$ldBrkTime.'",'; 
				$row .= '"'.$disposition_est.'",';
			}
			
			$row .= '"'.$night_login.'",'; 
			
			$row .= '"'.$user['sch_in'].'",'; 
			$row .= '"'.$user['sch_out'].'",'; 
			
			if($filter_key=="OfflineList" || $filter_value=="2,3,4"){
				$row .= '"'.$user['ticket_no'].'",'; 
			} 
			
			$row .= '"' . $comments .'",'; 
			$row .= '"' . $login_log_local .'"'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
				
		fclose($fopen);
									
		if($isDownload==true){
			
			ob_end_clean();
			$s_date = $fArray["start_date"]; 
			$e_date = $fArray["end_date"]; 
			$newfile="report-".$s_date."to".$e_date.".csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
			exit();
		}
		
	}
	
	
	
	public function create_raw_CSV($rr,$fArray,$isDownload=false)
	{
		
		
		$filter_key=$fArray["filter_key"];
		$time_zone = $fArray["time_zone"];
		
		if($filter_key!="" && $filter_key!="OfflineList") $filter_value=$fArray["filter_value"];
		else $filter_value="";
		
		$filename = "./assets/reports/Report_raw_".get_user_id().".csv";
		
		$fopen = fopen($filename,"w+");
	
		
		$header = array("Fusion ID", "Site/XPOID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time (EST)", "Login Time(Local)", "Logout Time (EST)", "Logout Time (Local)", "Logged In Hours", "Night Differential (Local)", "Schedule IN", "Schedule OUT","Log");		
		
		
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");
		
		//echo "<pre>";
		//print_r($rr);
		//echo "</pre>";
		
		foreach($rr as $user)
		{	
		
			$Ltime= round(($user['Ltime']/3600),2);
						
			$omuid= $user['omuid'];
			$xpoid= $user['xpoid'];
			if($xpoid!="") $omuid = $xpoid;
			
			$login_time = $user['login_time'];
			$login_time_local = $user['login_time_local'];
			
			$logout_time=$user['logout_time'];
			$logout_time_local=$user['logout_time_local'];
			
			$login_log=$user['login_log'];
			if($login_log=="") $login_log = $user['loout_log'];
			
			$night_login= gmdate('H:i:s', get_night_login($login_time_local,$logout_time_local,$user['office_id']));
			
			$row = "";
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$omuid.'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['process_name'].' '.$user['sub_process_name'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
							
			$row .= '"'.$login_time.'",';
			$row .= '"'.$login_time_local.'",'; 
			$row .= '"'.$logout_time.'",'; 
			$row .= '"'.$logout_time_local.'",'; 
			$row .= '"'.$Ltime.'",'; 
			
			$row .= '"'.$night_login.'",'; 
			
			$row .= '"'.$user['sch_in'].'",'; 
			$row .= '"'.$user['sch_out'].'",'; 
			$row .= '"'.$login_log.'"'; 
						
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
									
		if($isDownload==true){
			
			ob_end_clean();
			$s_date = $fArray["start_date"]; 
			$e_date = $fArray["end_date"]; 
			$newfile="login_raw_report-".$s_date."to".$e_date.".csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
			exit();
		}
		
	}

		///============= Download Photograph ===============================================//
	
	public function photograph()
	{
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/photo_upload_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
									
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$office_id = "";
			$dept_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			
			$data["docu_upl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				$client_id = $this->input->get('client_id');
				$process_id = $this->input->get('process_id');
				$is_idcard = $this->input->get('is_idcard');
												
				$extraOffice = "";
				if($office_id!='ALL'){ $extraOffice = " AND s.office_id = '$office_id' "; }
				
				$extraDept = "";
				if($dept_id!='ALL'){ $extraDept = " AND s.dept_id = '$dept_id' "; }
				
				$extraClient = "";
				if($client_id!='ALL' && $client_id!='' && !empty($client_id)){ $extraClient .= " AND is_assign_client(s.id, $client_id) "; }
				
				if($process_id!='ALL' && $process_id!='' && !empty($process_id)){ $extraClient .= " AND is_assign_process(s.id, $process_id) "; }
				
				$extraIdcard="";
				if($is_idcard=="No") $extraIdcard .= " AND is_idcard = 'No' ";
				else if($is_idcard=="Yes") $extraIdcard .= " AND is_idcard = 'Yes' ";
								
				$extraFusion = "";
				$fusionSelection = $this->input->get('report_fusion_id');
				if(!empty($fusionSelection))
				{
					$extraOffice = ""; $extraDept = ""; $extraClient = "";
					$fusion_ids_ar = explode(',', $fusionSelection);
					$fusion_ids = implode("','", $fusion_ids_ar);
					$extraFusion = " AND s.fusion_id IN ('".$fusion_ids."') ";
				}
				
				$reports_sql = "SELECT s.*, d.photograph as myphotograph from signin as s
								  LEFT JOIN info_document_upload as d ON s.id = d.user_id
								  LEFT JOIN info_personal as ip ON s.id = ip.user_id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion $extraIdcard ";
				$report_list = $this->Common_model->get_query_result_array($reports_sql);
				
				$filename = "";
				$this->generate_photo_download_archieve($report_list, $filename, $office_id);
				exit();
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function generate_photo_download_archieve($reportArray, $csvfile='', $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "reports_archieve_photo"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/generate_photo_download.xlsx";
		$dataCounter = 0;
		
		// ADDED FOR ZIP SAVE TO DIRECTORY
		$zipfileDir = 'uploads/document_zip/photograph/';
		$zipfilename = $zipfileDir .'reports_archieve_photo_'.strtotime('now').'.zip';
		
		// DELETING OLD FILES
		$scanFiles = scandir($zipfileDir);
		$totalFilesAr = count($scanFiles);
		if($totalFilesAr > 10)
		{
			if(file_exists(FCPATH.$zipfileDir.$scanFiles[2])){
				unlink(FCPATH.$zipfileDir.$scanFiles[2]);
			}
		}
		
		// CREATING NEW ARCHIEVE
		$zip = new ZipArchive;
		if ($zip->open(FCPATH . $zipfilename, ZipArchive::CREATE) === TRUE) {
				
			//$this->zip->read_file($csvfile);
			//$zip->addFile($csvfile, "reports/mandatory_doc_reports.csv");		
						
			//========== PHOTO INFO =====//
			foreach($reportArray as $token)
			{
				$fusionID   = $token["fusion_id"];
				$firstname  = $token["fname"];
				$lastname  = $token["lname"];
				$office_id  = $token["office_id"];
				$photograph = $token["myphotograph"];
				$uploadDir = FCPATH.'uploads/photo/';
								
				$newFileName = $firstname ."_" .$lastname."_".$fusionID.".png";
				$newFileName = preg_replace('/\s/', '', $newFileName);
				
				$fileName = $uploadDir.$photograph;
				
				$found = false;
				if(file_exists($fileName) && !empty($photograph)){				
					$found = true;
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				if($found == false)
				{
					$checkFileName = $uploadDir .$newFileName;
					if(file_exists($checkFileName)){
						$found = true;
						$zip->addFile($checkFileName, $newFileName);
						$dataCounter++;
					}
				}
				if($found == false)
				{
					$checkFileName = $uploadDir .$firstname ."_" .$lastname."_".$fusionID.".png";
					if(file_exists($checkFileName)){
						$found = true;
						$zip->addFile($checkFileName, $newFileName);
						$dataCounter++;
					}
				}
			}
			
			$zip->close();
		
		}
		if($dataCounter > 0)
		{
			header('Location:'.base_url() . $zipfilename);
		} else {
			header('Location:'.base_url().'reports_hr/photograph?nodata=1');
		}
		
        //$this->zip->download($zipFileName.'.zip');		
	}


	public function prflphotograph()
	{
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/prfl_photo_upload_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$office_id = "";
			$dept_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			
			$data["docu_upl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				$client_id = $this->input->get('client_id');
				$process_id = $this->input->get('process_id');
												
				$extraOffice = "";
				if($office_id!='ALL'){ $extraOffice = " AND s.office_id = '$office_id' "; }
				
				$extraDept = "";
				if($dept_id!='ALL'){ $extraDept = " AND s.dept_id = '$dept_id' "; }
				
				$extraClient = "";
				if($client_id!='ALL' && $client_id!='' && !empty($client_id)){ $extraClient .= " AND is_assign_client(s.id, $client_id) "; }
				
				if($process_id!='ALL' && $process_id!='' && !empty($process_id)){ $extraClient .= " AND is_assign_process(s.id, $process_id) "; }
								
				$extraFusion = "";
				$fusionSelection = $this->input->get('report_fusion_id');
				if(!empty($fusionSelection))
				{
					$extraOffice = ""; $extraDept = ""; $extraClient = "";
					$fusion_ids_ar = explode(',', $fusionSelection);
					$fusion_ids = implode("','", $fusion_ids_ar);
					$extraFusion = " AND s.fusion_id IN ('".$fusion_ids."') ";
				}
				
				$reports_sql = "SELECT s.* from signin as s
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$report_list = $this->Common_model->get_query_result_array($reports_sql);


				$filename = "";
				$this->generate_profile_photo_download_archieve($report_list, $filename, $office_id);
				exit();
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function generate_profile_photo_download_archieve($reportArray, $csvfile='', $office ='', $zipfile = '')
	{

		// print_r($reportArray); exit;
		if(empty($zipFile)){ $zipFileName = "reports_archieve_profile_photo"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$dataCounter = 0;
		
		// ADDED FOR ZIP SAVE TO DIRECTORY
		$zipfileDir = 'uploads/document_zip/profile/';
		$zipfilename = $zipfileDir .'reports_archieve_profile_photo_'.strtotime('now').'.zip';
		
		// DELETING OLD FILES
		$scanFiles = scandir($zipfileDir);
		$totalFilesAr = count($scanFiles);
		if($totalFilesAr > 10)
		{
			if(file_exists(FCPATH.$zipfileDir.$scanFiles[2])){
				unlink(FCPATH.$zipfileDir.$scanFiles[2]);
			}
		}
		
		// CREATING NEW ARCHIEVE
		$zip = new ZipArchive;
		if ($zip->open(FCPATH . $zipfilename, ZipArchive::CREATE) === TRUE) {
				
			//$this->zip->read_file($csvfile);
			//$zip->addFile($csvfile, "reports/mandatory_doc_reports.csv");		
						
			//========== PHOTO INFO =====//
			foreach($reportArray as $token)
			{
				$fusionID   = $token["fusion_id"];
				$firstname  = $token["fname"];
				$lastname  = $token["lname"];
				$office_id  = $token["office_id"];
				// $photograph = $token["myphotograph"];
				$dir =FCPATH."pimgs/";

				$fileName = $dir.$fusionID."/".$fusionID.".".$token['pic_ext'];			
				$newFileName = $firstname ."_" .$lastname."_".$fusionID.".png";
				$newFileName = preg_replace('/\s/', '', $newFileName);
				// echo $filename;
				$found = false;
				if(file_exists($fileName)){				
					$found = true;
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				if($found == false)
				{
					if(file_exists($newFileName)){
						$found = true;
						$zip->addFile($newFileName, $newFileName);
						$dataCounter++;
					}
				}
			}
			
			$zip->close();
		
		}
		if($dataCounter > 0)
		{
			header('Location:'.base_url() . $zipfilename);
		} else {
			header('Location:'.base_url().'reports_hr/prflphotograph?nodata=1');
		}
		
        //$this->zip->download($zipFileName.'.zip');		
	}





		public function download_document(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/new_document_upload_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$office_id = "";
			$dept_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			
			$data["docu_upl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				//$fusion_id = $this->input->get('fusion_id');
				
				if($office_id=='All') $cond .= "";
				else $cond .= " and office_id='$office_id'";
				
				if($dept_id=='All') $cond .= "";
				else $cond .= " and dept_id='$dept_id'";
				
				if(strtolower($cValue)=='all' || $cValue=='') $cond .= "";
				else $cond .= " and client='$cValue'";
				
				if(strtolower($pValue)=='all' || $pValue=='') $cond .= "";
				else $cond .= " and process='$pValue'";
				
				
				$qSql="SELECT * from 
				(select id, fusion_id, office_id, dept_id, (select description from department d where d.id=dept_id) as dept_name, concat(fname, ' ', lname) as name, status, get_client_ids(id) as client, get_process_ids(id) as process, get_client_names(id) as client_name, get_process_names(id) as process_name, (select GROUP_CONCAT(iod.info_type) as other_info FROM info_others_doc iod where iod.user_id=signin.id) as other_docu_info from signin) masdt Left Join 
				(select user_id as ie_uid, max(job_doc) as job_doc from info_experience group by ie_uid) aa On (masdt.id=aa.ie_uid) Left Join
				(select user_id as ib_uid, max(bank_doc) as bank_doc from info_bank group by ib_uid) bb On (masdt.id=bb.ib_uid) Left join
				(select user_id as ip_uid, max(passport_doc) as passport_doc from info_passport group by ip_uid) cc On (masdt.id=cc.ip_uid) Left join
				(select user_id as ied_uid, max(education_doc) as education_doc from info_education group by ied_uid) dd On (masdt.id=dd.ied_uid) Left join
				(select user_id as uid, marital_status from info_personal group by uid) ee On (masdt.id=ee.uid) Left Join
				(select user_id as idu_uid,pan_doc,aadhar_doc,aadhar_doc_back,nis_doc,birth_certi_doc,marrige_certi_doc,photograph,resume_doc,nit_doc,isss_doc,afp_info_doc,background_local_doc, sss_no_doc,tin_no_doc,philhealth_no_doc,dependent_birth_certi_doc,bir_2316_doc,nbi_clearance_doc,offer_letter,employment_contract,profile_sketch,updated_cv from info_document_upload) ff On (masdt.id=ff.idu_uid)
				where status=1 $cond GROUP BY fusion_id";
				
				//$fullAray = $this->Common_model->get_query_result_array($qSql);
				//$data["docu_upl_list"] = $fullAray;
				//$this->create_docu_upl_CSV($fullAray, $office_id);
								
				$extraOffice = "";
				if($office_id!='All'){ $extraOffice = " AND s.office_id = '$office_id' "; }
				
				$extraDept = "";
				if($dept_id!='All'){ $extraDept = " AND s.dept_id = '$dept_id' "; }
				
				$extraClient = "";
				if(strtolower($cValue)!='all' && $cValue!='' && !empty($cValue)){ $extraClient .= " AND $cValue IN (get_client_ids(s.id)) "; }
				
				if(strtolower($pValue)!='all' && $pValue!='' && !empty($pValue)){ $extraClient .= " AND $pValue IN (get_process_ids(s.id)) "; }
								
				$extraFusion = "";
				$fusionSelection = $this->input->get('report_fusion_id');
				if(!empty($fusionSelection))
				{
					$extraOffice = ""; $extraDept = ""; $extraClient = "";
					$fusion_ids_ar = explode(',', $fusionSelection);
					$fusion_ids = implode("','", $fusion_ids_ar);
					$extraFusion = " AND s.fusion_id IN ('".$fusion_ids."') ";
				}
				
				$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_bank as b
								  LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$report_list = $this->Common_model->get_query_result_array($reports_sql);
				
				$info_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_document_upload as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$info_list = $this->Common_model->get_query_result_array($info_sql);

				$edu_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_education as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$edu_list = $this->Common_model->get_query_result_array($edu_sql);

				$exp_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_experience as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$exp_list = $this->Common_model->get_query_result_array($exp_sql);

				$other_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_others_doc as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$other_list = $this->Common_model->get_query_result_array($other_sql);

				$passport_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_passport as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$pass_list = $this->Common_model->get_query_result_array($passport_sql);
				
				$filename = "";
				// print_r($info_list); exit;
				//$filename = "./assets/reports/Report".get_user_id().".csv";
				$this->generate_document_download_archieve($info_list,$edu_list,$exp_list,$other_list,$pass_list,$report_list,$filename, $office_id);
				exit();
				// $dn_link = base_url()."reports/download_docu_upl_CSV/".$office_id
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_docu_upl_CSV2($off)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Profile Document Upload List-'".$off."' - '".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
		// return $filename;
	}
	
	public function create_docu_upl_CSV2($rr,$off)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($off=='JAM'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Tax Registration Number ID", "National Insurance Scheme ID", "Birth Certificate", "Married", "Marriage Certificate", "Bank Info", "Education Info", "Passport", "Other Document Upload");
		}else if(isIndiaLocation($off)==true){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Aadhar Card / Social Secuirity No", "PAN Card", "Photograph", "Covid-19 Declaration", "Education Info", "Passport", "Experience Info", "Bank Info", "Other Document Upload");
		}else if($off=='ELS'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Resume", "NIT", "ISSS Information", "AFP Information", "Background Local",  "Passport", "Other Document Upload");
		}else if($off=='CEB' || $off=='MAN'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "SSS Number", "TIN Number", "Birth Certificate", "Philhealth Number", "Dependents Birth Certificate",  "Married", "Marriage Certificate", "BIR 2316 from previous",  "NBI Clearance", "Offer Letter", "Employment Contract", "Profile Sketch", "Updated CV",  "Other Document Upload");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($off=='JAM'){
			
			foreach($rr as $user)
			{
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['nis_doc']!='') $nis_doc='Yes';
				else $nis_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bank_doc']!='') $bank_doc='Yes';
				else $bank_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
			
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$nis_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bank_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if(isIndiaLocation($off)==true){
		
			foreach($rr as $user)
			{
				if($user['aadhar_doc']!='') $aadhar_doc='Yes';
				else $aadhar_doc='No';
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['photograph']!='') $photograph='Yes';
				else $photograph='No';
				if($user['covid19declare_doc']!='') $covid19declare_doc='Yes';
				else $covid19declare_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				if($user['job_doc']!='') $experience_doc='Yes';
				else $experience_doc='No';
				if($user['bank_doc']!='') $bank_doc='Yes';
				else $bank_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$aadhar_doc.'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$photograph.'",';
				$row .= '"'.$covid19declare_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$experience_doc.'",';
				$row .= '"'.$bank_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='ELS'){
		
			foreach($rr as $user)
			{
				if($user['resume_doc']!='') $resume_doc='Yes';
				else $resume_doc='No';
				if($user['nit_doc']!='') $nit_doc='Yes';
				else $nit_doc='No';
				if($user['isss_doc']!='') $isss_doc='Yes';
				else $isss_doc='No';
				if($user['afp_info_doc']!='') $afp_info_doc='Yes';
				else $afp_info_doc='No';
				if($user['background_local_doc']!='') $background_local_doc='Yes';
				else $background_local_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$resume_doc.'",';
				$row .= '"'.$nit_doc.'",';
				$row .= '"'.$isss_doc.'",';
				$row .= '"'.$afp_info_doc.'",';
				$row .= '"'.$background_local_doc.'",';
				$row .= '"'.$passport_doc.'"';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='CEB' || $off=='MAN'){
		
			foreach($rr as $user)
			{
				if($user['sss_no_doc']!='') $sss_no_doc='Yes';
				else $sss_no_doc='No';
				if($user['tin_no_doc']!='') $tin_no_doc='Yes';
				else $tin_no_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['philhealth_no_doc']!='') $philhealth_no_doc='Yes';
				else $philhealth_no_doc='No';
				if($user['dependent_birth_certi_doc']!='') $dependent_birth_certi_doc='Yes';
				else $dependent_birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bir_2316_doc']!='') $bir_2316_doc='Yes';
				else $bir_2316_doc='No';
				if($user['nbi_clearance_doc']!='') $nbi_clearance_doc='Yes';
				else $nbi_clearance_doc='No';
				if($user['offer_letter']!='') $m_offer_doc='Yes';
				else $m_offer_doc='No';
				if($user['employment_contract']!='') $m_contract_doc='Yes';
				else $m_contract_doc='No';
				if($user['profile_sketch']!='') $m_profile_doc='Yes';
				else $m_profile_doc='No';
				if($user['updated_cv']!='') $m_updatedcv_doc='Yes';
				else $m_updatedcv_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$sss_no_doc.'",';
				$row .= '"'.$tin_no_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$philhealth_no_doc.'",';
				$row .= '"'.$dependent_birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bir_2316_doc.'",';
				$row .= '"'.$nbi_clearance_doc.'",';
				$row .= '"'.$m_offer_doc.'",';
				$row .= '"'.$m_contract_doc.'",';
				$row .= '"'.$m_profile_doc.'",';
				$row .= '"'.$m_updatedcv_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		
		fclose($fopen);
	}
///////////////////////////////	
	

	public function generate_document_download_archieve($info_list,$edu_list,$exp_list,$other_list,$pass_list,$reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "reports_archieve"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/Bank_Upload_Report_.xlsx";
		$dataCounter = 0;
		
		// ADDED FOR ZIP SAVE TO DIRECTORY
		$zipfileDir = 'uploads/manadatory_document_zip/';
		$zipfilename = $zipfileDir .'reports_archieve_'.strtotime('now').'.zip';
		
		// DELETING OLD FILES
		$scanFiles = scandir($zipfileDir);
		$totalFilesAr = count($scanFiles);
		if($totalFilesAr > 10)
		{
			if(file_exists(FCPATH.$zipfileDir.$scanFiles[2])){
				unlink(FCPATH.$zipfileDir.$scanFiles[2]);
			}
		}
		
		// CREATING NEW ARCHIEVE
		$zip = new ZipArchive;
		if ($zip->open(FCPATH . $zipfilename, ZipArchive::CREATE) === TRUE) {
		//	
			
		//$this->zip->read_file($csvfile);
		//$zip->addFile($csvfile, "reports/mandatory_doc_reports.csv");		
		
		
		// print_r($reportArray);
		// exit;
		
		//========== BANK INFO =====//
		$sl=0;
        foreach ($reportArray as $token)
		{
			$sl++;
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = FCPATH.'/uploads/bank_upload/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['upl_bank_info'];
			$newFileName = "bank/" .$fusionID."_".$firstname."_".$office."_bank_".$sl.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['upl_bank_info'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== INFO ODOCUMENT UPLOAD =======//

        foreach ($info_list as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			
			// FOR PHOTOPGRAPH
			$fileName = $uploadDir.$token['photograph'];
			$newFileName = "photo/" .$fusionID."_".$firstname."_".$office."_photograph.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['photograph'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}
			
			// FOR ADHAAR
			$fileName = $uploadDir.$token['aadhar_doc'];
			$newFileName = "adhaar/" .$fusionID."_".$firstname."_".$office."_aadhar.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['aadhar_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}

			// FOR ADHAAR Back
			$fileName = $uploadDir.$token['aadhar_doc_back'];
			$newFileName = "adhaar/" .$fusionID."_".$firstname."_".$office."_aadhar_back.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['aadhar_doc_back'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}

			// FOR PAN
			$fileName = $uploadDir.$token['pan_doc'];
			$newFileName = "pan/" .$fusionID."_".$firstname."_".$office."_pan.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['pan_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}
			
			// FOR COVID DECLARE
			$fileName = $uploadDir.$token['covid19declare_doc'];
			$newFileName = "covid19/" .$fusionID."_".$firstname."_".$office."_covid19declare.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['covid19declare_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}
			
			// MANDATORY DOC FOR JAMAICA
			if($office=='JAM'){
				// nis doc
				$fileName = $uploadDir.$token['nis_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_nis_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['nis_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// birth cert
				$fileName = $uploadDir.$token['birth_certi_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_birth_certif_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['birth_certi_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
			}
			
			// MANDATORY DOC FOR ELS
			if($office=='ELS'){
				// nit doc
				$fileName = $uploadDir.$token['nit_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_nit_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['nit_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// afp_info_doc
				$fileName = $uploadDir.$token['afp_info_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_afp_info_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['afp_info_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// isss_doc
				$fileName = $uploadDir.$token['isss_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_isss_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['isss_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// background_local_doc
				$fileName = $uploadDir.$token['background_local_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_background_local_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['background_local_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// resume_doc
				$fileName = $uploadDir.$token['resume_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_resume_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['resume_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
			}
			
			
			// MANDATORY DOC FOR CEBU & MANILA
			if($office=='CEB' || $office=='MAN'){
				
				// SS NO
				$fileName = $uploadDir.$token['sss_no_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_sss_no_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['sss_no_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}

				// tin_no_doc
				$fileName = $uploadDir.$token['tin_no_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_tin_no_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['tin_no_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}

				// birth_certi_doc
				$fileName = $uploadDir.$token['birth_certi_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_birth_certi_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['birth_certi_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// philhealth_no_doc
				$fileName = $uploadDir.$token['philhealth_no_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_philhealth_no_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['philhealth_no_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// dependent_birth_certi_doc
				$fileName = $uploadDir.$token['dependent_birth_certi_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_dependent_birth_certi_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['dependent_birth_certi_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// marrige_certi_doc
				$fileName = $uploadDir.$token['marrige_certi_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_marrige_certi_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['marrige_certi_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// bir_2316_doc
				$fileName = $uploadDir.$token['bir_2316_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_bir_2316_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['bir_2316_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// nbi_clearance_doc
				$fileName = $uploadDir.$token['nbi_clearance_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_nbi_clearance_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['nbi_clearance_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// offer_letter
				$fileName = $uploadDir.$token['offer_letter'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_offer_letter.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['offer_letter'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// offer_letter
				$fileName = $uploadDir.$token['offer_letter'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_offer_letter.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['offer_letter'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// employment_contract
				$fileName = $uploadDir.$token['employment_contract'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_employment_contract.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['employment_contract'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// profile_sketch
				$fileName = $uploadDir.$token['profile_sketch'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_profile_sketch.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['profile_sketch'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// updated_cv
				$fileName = $uploadDir.$token['updated_cv'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_updated_cv.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['updated_cv'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
			}
			
        }
		
		//==== EDUCATION DOC =========//
		$sl=0;
        foreach ($edu_list as $token)
		{	
			$sl++;
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['education_doc'];
			$newFileName = "education/" .$fusionID."_".$firstname."_".$office."_education_".$sl.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['education_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== EXPERIENCE DOC =========//
		$sl=0;
        foreach ($exp_list as $token)
		{
			$sl++;
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['job_doc'];
			$newFileName = "experience/" .$fusionID."_".$firstname."_".$office."_job_".$sl.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['job_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== OTHERS INFO DOC =========//
		$sl=0;
        foreach ($other_list as $token)
		{
			$sl++;
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['info_doc'];
			$newFileName = "others/" .$fusionID."_".$firstname."_".$office."_other_".$sl.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['info_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== PASSPORT DOC =========//
		$sl=0;
        foreach ($pass_list as $token)
		{
			$sl++;
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['passport_doc'];
			$newFileName = "passport/" .$fusionID."_".$firstname."_".$office."_passport_".$sl.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['passport_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		$zip->close();
		
		}
		
		if($dataCounter > 0)
		{
			header('Location:'.base_url() . $zipfilename);
		} else {
			header('Location:'.base_url().'reports_hr/download_document?nodata=1');
		}
		
        //$this->zip->download($zipFileName.'.zip');		
	}
	
    
	public function tramsUsers()
	{
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		
		$ses_dept_id=get_dept_id();
		$role_id= get_role_id();
		
		$user_office_id=get_user_office_id();
		
		$is_global_access=get_global_access();
		$data["show_download"] = false;
		$data["download_link"] = "";
		$data["show_table"] = false;
		$data["show_table"] = false;
		
		//////////////////////////////////
			
		//$data["aside_template"] = get_aside_template();
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "reports_hr/rep_terms.php";
		
		$start_date="";
		$end_date="";
		$office_id="";
		$dept_id="";
		$action="";
		$dn_link="";
		
		$data['department_list'] = $this->Common_model->get_department_list();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$sCond=" Where id = '$user_site_id'";
			$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		/* $data['download_link']="";
		$data['start_date']="";
		$data['end_date']="";
		$data['office_id']="";
		$data['dept_id']="";
		$data['ses_role_id']=""; */
		
		$data['user_list'] =array();
		
		if($this->input->get('showReports')=='Show')
		{
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$fusion_id = $this->input->get('xpoid');
			
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			//$dept_id = $this->input->get('dept_id');
			//if($dept_id=="") $dept_id=$ses_dept_id;
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"office_id" => $office_id,
					"dept_id" => $dept_id,
					"fusion_id" =>$fusion_id 
			 ); 
			 
			 
			$fullArr = $this->reports_model->get_terms_users($filterArray);
			
			$data["user_term_list"] = $fullArr;
				
			$this->user_term_CSV($fullArr);
				
			$dn_link = base_url()."reports_hr/user_termCSV";
			
		}	
			
		$data['user_list'] = $fullArr;
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		$data['dept_id']=$dept_id;
		$data['office_id']=$office_id;
		$data['download_link']=$dn_link;
		$data["action"] = $action;
			
		// Phase List
		$data['phaseList'] = $this->display_user_phase('', 'array');
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	public function user_termCSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="user_term.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function user_term_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Site ID", "Agent Name", "Site", "Process", "Role", "Ticket No", "Ticket Time", "Time Diff", "LWD", "Terms By", "Terms Date", "Terms Approved By", "Terms Approved Date", "User Phase", "Comments");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			$omuid= $user['omuid'];
			$xpoid= $user['xpoid'];
			if($xpoid!="") $omuid = $xpoid;
			
			
			if($user['rejon_date']!=null){
				$t_comment = $user['tcomments']."<br>Rejoin Date: ".$user['rejon_date'];
			}else{
				$t_comment = $user['tcomments'];
			}
			
			$phaseStatus = $this->display_user_phase($user['phase']);
			
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$xpoid.'",';  
			$row .= '"'.$xpoid.'",';
			$row .= '"'.$user['site_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['ticket_no'].'",'; 
			$row .= '"'.$user['ticket_date'].'",'; 
			$row .= '"'.$user['termDiff'].'",'; 
			$row .= '"'.$user['lwd'].'",'; 
			$row .= '"'.$user['terms_by_name'].'",'; 
			$row .= '"'.$user['terms_date'].'",'; 
			$row .= '"'.$user['update_by_name'].'",'; 
			$row .= '"'.$user['update_date'].'",'; 
			$row .= '"'.$phaseStatus.'",'; 
			$row .= '"'.$t_comment.'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
	public function cancelTramReq()
	{
		$role_id= get_role_id();
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$ses_dept_id=get_dept_id();
		$user_office_id=get_user_office_id();
		
		$is_global_access=get_global_access();
		
		//////////////////////////////////
			
		//$data["aside_template"] = get_aside_template();
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "reports_hr/cancel_term_req.php";
		
		$start_date="";
		$end_date="";
		$dept_id="";
		
		$data['download_link']="";
		$data['start_date']="";
		$data['end_date']="";
		$data['ses_role_id']="";
		
		$data['user_list'] =array();
		$data['department_list'] = $this->Common_model->get_department_list();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$sCond=" Where id = '$user_site_id'";
			$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		if($this->input->get('showReports')=='Show')
		{
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			//$dept_id = $this->input->get('dept_id');
			//if($dept_id=="") $dept_id=$ses_dept_id;
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"office_id" => $office_id,
					"dept_id" => $dept_id
			 ); 
			 
			$fullArr = $this->reports_model->get_cancel_term_request($filterArray);
			
		}else{
			
			//$data['dept_id']=$ses_dept_id;
			$data['office_id']=$user_office_id;
			
			$filterArray = array(
					"start_date" =>"",
					"end_date" => "",
					"office_id" => $user_office_id,
					"dept_id" => $dept_id
			 ); 
			 
			$fullArr = $this->reports_model->get_cancel_term_request($filterArray);
			$data['user_list'] = $fullArr;
			
		}
		
		$data['user_list'] = $fullArr;
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
		$data['dept_id']=$dept_id;
		$data['office_id']=$office_id;
		
		$this->load->view('dashboard',$data);
		
	}
	
		
	private function check_access()
	{
		if(isAccessReports()==false) redirect(base_url()."home","refresh");
		if(isDisableModule()==true) redirect(base_url()."home","refresh");
		
		
		//$is_global_access=get_global_access();
		//if(get_role_dir()=="agent" && $is_global_access!=1 ) redirect(base_url()."home","refresh");
		
	}
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Resignation Report-----------------------------*/	
	public function resign_report(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/resign_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			
			$data["resign_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id
					);
			
				$fullAray = $this->user_model->get_resign_list($field_array);
				$data["resign_list"] = $fullAray;
				
				$this->create_Resign_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/downloadResignCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			// Phase List
			$data['phaseList'] = $this->display_user_phase('', 'array');
		
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadResignCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="user_resign_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Resign_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Name", "Fusion ID", "Site ID", "Role", "Location", "Resign Date", "Released Date", "LWD", "Email", "Phone", "User Reason", "User Remarks", "Current Resign Date/Time", "Approved By", "Approved Remarks", "Approved Date/Time", "Approved Released Date", "HR Accepted By", "Accepted Date/Time", "Accepted Released Date", "Status", "Phase");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			
			if($user['resign_status']=="A") $resignStatus="Approved";
			else if ($user['resign_status']=="R") $resignStatus="Decline";
			else if ($user['resign_status']=="AC") $resignStatus="Accept by HR";
			else if ($user['resign_status']=="C") $resignStatus="Complete";
			else $resignStatus="Pending";
			
			$phaseStatus = $this->display_user_phase($user['phase']);
		
			$row = '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['xpoid'].'",';
			// $row .= '"'.$user['omuid'].'",';
			$row .= '"'.$user['role'].'",';
			$row .= '"'.$user['office_id'].'",';
			$row .= '"'.$user['resign_date'].'",';
			$row .= '"'.$user['released_date'].'",';
			$row .= '"'.$user['lwd'].'",';
			$row .= '"'.$user['user_email'].'",';
			$row .= '"'.$user['user_phone'].'",';
			$row .= '"'.$user['user_reason'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['user_remarks'])).'",';
			$row .= '"'.$user['submit_date'].'",';
			$row .= '"'.$user['approved_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['approved_remarks'])).'",';
			$row .= '"'.$user['approved_date'].'",';
			$row .= '"'.$user['approved_released_date'].'",';
			$row .= '"'.$user['accepted_name'].'",';
			$row .= '"'.$user['accepted_date'].'",';
			$row .= '"'.$user['accepted_released_date'].'",';
			$row .= '"'.$resignStatus.'",';
			$row .= '"'.$phaseStatus.'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	   
//////////////////////////////////////////////////////////	
	
	// CREATE USER REPORT HISTORY ADDED BY VIVEK PRASAD ON 30.11.2018
	
	
	
	public function user_history_rep(){
		
		$site_id = "";
		$office_id = "";
					
		$user_office_id=get_user_office_id();
		//////////////////////////////////
		$is_global_access=get_global_access();
		$office_id = $this->input->get('office_id');
		
		if($office_id=="")  $office_id=$user_office_id;
		
		//////////////////////////////////
		
		$role_id= get_role_id();
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		//////////////////////////////////
			
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "reports_hr/rep_history.php";
		
		$start_date="";
		$end_date="";
		$rof="";
		$dn_link="";
		$start_date="";
		$end_date="";
		$fullArr=array();
		$dn_param="";
		$site_id="";
		
		$data['start_date']="";
		$data['end_date']="";
		$data['ses_role_id']="";
		
		$data['user_list'] =array();
		$data['site_list'] = $this->Common_model->get_sites_for_assign();
		
				
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}

		
		if($this->input->get('showReports')=='Show')
		{
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"office_id" => $office_id
					
			 ); 
			
			$fullArr = $this->reports_model->gethistoryusernData($filterArray);
			
			$data['user_list'] = $fullArr;
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			
			$filename=$this->create_csv_2($fullArr);
			$dn_param='sd='.$start_date.'&ed='.$end_date; 
			$dn_link = base_url()."reports_hr/downloadCsv_2";
								
		}
		
		$data['office_id']=$office_id;
				
		$data['dn_param']=$dn_param;
		$data['download_link']=$dn_link;
		$this->load->view('dashboard',$data);
		
	}
	
	public function downloadCsv_2()
	{		
		
		$s_date = $this->input->get('sd');
		$e_date = $this->input->get('ed');
		
		//////////LOG////////
		$Lfull_name=get_username();
		$LOMid=get_user_omuid();
		$LogMSG="Download User History report";
		log_message('error', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
		//////////
		$filename="./assets/reports/userhistory-".get_user_id()."-".CurrDate().".csv";

		if($s_date!="" && $e_date!="") $newfile="userhistory-".$s_date." to ".$e_date. ".csv";
		else $newfile="userhistory-".CurrDate().".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	} 
	
	
	public function create_csv_2($rr)
	{
		
		$filename="userhistory-".get_user_id()."-".CurrDate().".csv";
		$filePath = "./assets/reports/".$filename;
		
		$fopen = fopen($filePath,"w+");
										
		$header = array("SL","Fusion ID", "XPOID", "OM ID", "First Name","Last Name","Site", "DOJ", "DOH", "Migration Date", "Migration Type","Migrated To", "Migrated From", "Remarks");
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");
		
		$cnt=1;
		
		foreach($rr as $user)
		{	
			//if($user['event_master_id']!=9) continue;
			
			$row = '"'.$cnt++.'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"' . $user['fname'] . '",';
			$row .= '"' . $user['lname'] . '",';
			$row .= '"' . $user['site_name'] . '",';  
			$row .= '"' . $user['doj'] . '",';
			$row .= '"' . $user['doj'] . '",';
			$row .= '"' . $user['affected_date'] . '",';
			$row .= '"' . $user['m_type_name'] . '",';
			$row .= '"' . $user['m_to_name'] . '",';
			$row .= '"' . $user['m_from_name'] . '",';
			$row .= '"' . $user['comments'] . '"';
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
		
	} 
	
	
 
	private function is_access_reports($_role_id) 
	{
		$_role_arr = array("super"=>0,"admin"=>1,"tl"=>2,"manager"=>4,"trainer"=>5,"support"=>6,"trainee"=>7,"nesting"=>8,"supervisor"=>9);
		
		return true;
		
		//if(in_array($_role_id,$_role_arr ))
		//{
			//return true;
		//}else{
			//return false;
		//}
	}
	
	private function redirectors()
	{
		$role = get_role_id();
		if($role==1) return "admin";
		else return "tl";
	}
    
	
//////////////////////////////////////////////////////////////
///////////////////DFR Report section/////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Requisition Report-----------------------------*/	
	public function requisition_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/requisition_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$requisition_id="";
			$action="";
			$dn_link="";
			
			
			/* if($office_id=="ALL"){
				$data["req_code"]=$this->Dfr_model->get_requisition_id();
			}else{
				$data["req_code"]=$this->Dfr_model->get_requisition_id_list($user_office_id);
			} */
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id();
			
			$data["requisition_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
				
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$requisition_id = $this->input->get('requisition_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"requisition_id" => $requisition_id,
						"client_id" => $cValue,
						"process_id" => $pValue
					);
			
				$fullAray = $this->Dfr_model->get_requisition_report($field_array);
				$data["requisition_list"] = $fullAray;
				
				$this->create_Requisition_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/downloadRequisitionCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['requisition_id']=$requisition_id;
			
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


	/* public function select_reqcode(){
		$set_array = array ();
		if(check_logged_in())
		{
			$office_id = $this->input->get('office_id');

			$SQLtxt = "SELECT requisition_id FROM dfr_requisition where location='$office_id' ";
			$fields = $this->db->query($SQLtxt);
			
			$process_data =  $fields->result_array();
			  
			echo  json_encode($process_data);
			 
		}
	} */
	
	public function getreqList()
	{
		if(check_logged_in())
		{
			$office_id = trim($this->input->get('office_id'));
			echo json_encode($this->Dfr_model->get_requisition_list($office_id));
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////	
	/*-------------------Candidate Report-----------------------------*/	
	public function candidate_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/candidate_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$requisition_id="";
			$action="";
			$dn_link="";
			
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id();
			
			$data["candidate_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
				
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$requisition_id = $this->input->get('requisition_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"requisition_id" => $requisition_id,
						"client_id" => $cValue,
						"process_id" => $pValue
					);
			
				$fullAray = $this->Dfr_model->get_candidate_report($field_array);
				$data["candidate_list"] = $fullAray;
				
				$this->create_Candidate_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/downloadCandidateCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['requisition_id']=$requisition_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadCandidateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="candidate_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Candidate_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition ID", "Batch Code", "Client", "Process", "Location", "Due Date", "Position Applied For", "Hiring Source", "Source Name", "Candidate Name", "DOB", "Email", "Gender", "Phone", "Qualification", "Skill", "Total Exp", "Address", "Country", "State", "City", "Postcode", "Attachment", "Summary", "Added By", "Candidate Status", "Fusion ID", "User Status", "Added Date", "Approved By", "Approved Comment", "DOJ");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$c_status=$user['candidate_status'];
			//$a_status=$user['approved_status'];
			
			if($c_status=='CS') $cstatus="Selected";
			else if($c_status=='SL') $cstatus="Shortlisted";
			else if($c_status=='IP') $cstatus="In Progress";
			else if($c_status=='P') $cstatus="Pending";
			else if($c_status=='E') $cstatus="Add as an Employee";
			else $cstatus="Rejected";
			
			$userstatus=$user['user_status'];							
			$status_str ="";
			 
			if($user['candidate_status']=='E'){
				if($userstatus=='1') $status_str =  'Active'; 
				else if($userstatus=='0')  $status_str = 'Terms';
				else if($userstatus=='2')  $status_str = 'Pre-Terms';
				else  $status_str = 'Deactive';
			}	
										
			$ref_name = $user['ref_name'];
			
			if($user['ref_id'] !="" ) $ref_name = $ref_name .", " . $user['ref_id'];
			
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['batchCode'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['off_loc'].'",'; 
			$row .= '"'.$user['due_date'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['hiring_source'].'",'; 
			$row .= '"'.$ref_name.'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
			$row .= '"'.$user['dob'].'",';
			$row .= '"'.$user['email'].'",';
			$row .= '"'.$user['gender'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['last_qualification'].'",';
			$row .= '"'.$user['skill_set'].'",';
			$row .= '"'.$user['total_work_exp'].'",';
			$row .= '"'.$user['address'].'",';
			$row .= '"'.$user['country'].'",';
			$row .= '"'.$user['state'].'",';
			$row .= '"'.$user['city'].'",';
			$row .= '"'.$user['postcode'].'",';
			$row .= '"'.$user['attachment'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['summary'])).'",';
			$row .= '"'.$user['added_name'].'",';
			$row .= '"'.$cstatus.'",';
			$row .= '"'.$user['fusionid'].'",';
			$row .= '"'.$status_str.'",';
			$row .= '"'.$user['added_date'].'",';
			$row .= '"'.$user['approved_name'].'",';
			//$row .= '"'.$astatus.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['approved_comment'])).'",';
			$row .= '"'.$user['doj'].'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////	
	/*-------------------Candidate Report-----------------------------*/	
	public function candidate_interview_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/candidate_interview_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$status="";
			$candidate_status="";
			$action="";
			$dn_link="";
			
			
			/* $cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id(); */
			
			$data["candidate_interview_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			/* $data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			*/
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$status = $this->input->get('status');
				$candidate_status = $this->input->get('candidate_status');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"status" => $status,
						"candidate_status" => $candidate_status
					);
			
				$fullAray = $this->Dfr_model->candidate_interview_report($field_array);
				$data["candidate_interview_list"] = $fullAray;
				
				$this->create_Candidate_interview_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/downloadCandidateInterviewCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['status']=$status;
			$data['candidate_status']=$candidate_status;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadCandidateInterviewCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="candidate_interview_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Candidate_interview_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition ID", "Candidate Name", "DOB", "Contact Number", "Client", "Process", "Interviewer Name", "Scheduled By", "Scheduled Date", "Scheduled Time", "Interview Type", "Interview Status", "Interview Date", "Interview Time", "Final Status");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			
			$scheduledDate=$user['scheduled_on'];																		
			$phpdate = strtotime($scheduledDate);
			$scheduled_date = date( 'Y-m-d', $phpdate );
			$scheduled_time = date( 'H:i:s', $phpdate );
			
			$interviewDate=$user['interview_date'];
			$phpdate_inter = strtotime($interviewDate);
			$interview_date = date( 'Y-m-d', $phpdate_inter );
			$interview_time = date( 'H:i:s', $phpdate_inter );
			
			if($user['sh_status']=='C'){
				$status='Cleared';
			}else if($user['sh_status']=='N'){
				$status='Not Cleared';
			}else if($user['sh_status']=='R'){
				$status='Cancel';
			}else{
				$status='Pending';
			}
			
			if($user['sh_status']=='P' || $user['sh_status']=='R'){
				$interview_date="";
				$interview_time="";
			}
			
			if($user['candidate_status']=='P'){
				$candidate_status='Pending';
			}else if($user['candidate_status']=='IP'){
				$candidate_status='In Progress';
			}else if($user['candidate_status']=='SL'){
				$candidate_status='Shortlisted';
			}else if($user['candidate_status']=='CS'){
				$candidate_status='Selected';
			}else if($user['candidate_status']=='E'){
				$candidate_status='Selected as Employee';
			}else{
				$candidate_status='Rejected';
			}
			
			
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['dob'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['client'].'",'; 
			$row .= '"'.$user['process'].'",'; 
			$row .= '"'.$user['interviewer'].'",'; 
			$row .= '"'.$user['schedule_by'].'",'; 
			$row .= '"'.$scheduled_date.'",'; 
			$row .= '"'.$scheduled_time.'",';
			$row .= '"'.$user['interviewType'].'",'; 
			$row .= '"'.$status.'",'; 
			$row .= '"'.$interview_date.'",'; 
			$row .= '"'.$interview_time.'",'; 
			$row .= '"'.$candidate_status.'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
/*------------------------------------------------*/	
/*-------------------User Referral Report (19.07.2019)--------------------*/	
	public function user_referral_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/user_referral_report.php";
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			$date_from="";
			$date_to="";
			$hiring_source="";
			$action="";
			$dn_link="";
			
			$data["user_referral_list"] = array();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$hiring_source = $this->input->get('hiring_source');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"hiring_source" => $hiring_source
					);
			
				$fullAray = $this->Dfr_model->user_referral_report($field_array);
				$data["user_referral_list"] = $fullAray;
				
				$this->create_userReferral_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/downloadUserReferral";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['hiring_source'] = $hiring_source;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}

	
	public function downloadUserReferral()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="user_referral_report-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_userReferral_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("XPOID", "Fusion ID", "Candidate Name", "Role Name", "DOJ", "Hiring Source", "Source Name", "Source ID", "Source Department");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['fusionid'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",'; 
			$row .= '"'.$user['rolename'].'",'; 
			$row .= '"'.$user['doj'].'",'; 
			$row .= '"'.$user['hiring_source'].'",'; 
			$row .= '"'.$user['ref_id'].'",'; 
			$row .= '"'.$user['ref_name'].'",';
			$row .= '"'.$user['ref_dept'].'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	

	
/////////////////////////////////////////////////////////////////////
	/*-------------------Process Updates Acceptance-----------------------------*/	
	
	public function process_update_acceptance_report_list(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/process_update_acceptance_report.php";
			
			$process_update_id="";
			$action="";
			$dn_link="";
			$cValue="";
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			/* if(get_role_dir()=="super" || $is_global_access==1 ){
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select shname from client c where c.id=process_updates.client_id) as client from process_updates ";
				$data['get_process_update_title'] = $this->Common_model->get_query_result_array($qSql);
			}else{
								
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select shname from client c where c.id=process_updates.client_id) as client from process_updates where office_id in ('ALL','$user_office_id') order by office_id ";
				$data['get_process_update_title'] = $this->Common_model->get_query_result_array($qSql);
			} */
			
			
			$data["process_update_acceptance_list"] = array();
			
			$process_update_id = $this->input->get('process_update_id');
			$user_id = $this->input->get('user_id');
			
			$qSql="Select title from process_updates where id='$process_update_id'";
			$data['pu_title'] = $this->Common_model->get_query_result_array($qSql);
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			$qSql="Select client_id as id, (select shname from client c where c.id=process_updates.client_id) as shname from process_updates group by client_id order by shname asc";
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select process_id as id, (select name from process p where p.id=process_updates.process_id) as shname from process_updates group by process_id order by shname asc";
			$data['process_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"client_id" => $cValue,
						"user_id" => $user_id,
						"process_update_id" => $process_update_id,
					);
			
				$fullAray = $this->reports_model->get_process_update_acceptance_report($field_array);
				$data["process_update_acceptance_list"] = $fullAray;
				
				$this->create_processUpdateAcceptance_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/downloadprocessUpdateAcceptance";
					
			}
			
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['cValue']=$cValue;
			$data['office_id']=$office_id;
			$data['process_update_id'] = $process_update_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function getProcessTitle(){
		if(check_logged_in()){
			$pid=$this->input->post('pid');
			$office_id=$this->input->post('office_id');
			
			if($pid!='ALL' && $office_id!=''){
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select name from process p where p.id=process_updates.process_id) as client from process_updates where office_id='$office_id' and process_id='$pid'";
			}else if($pid=='ALL' && $office_id!=''){
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select name from process p where p.id=process_updates.process_id) as client from process_updates where office_id='$office_id' ";
			}else{
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select name from process p where p.id=process_updates.process_id) as client from process_updates ";
			}
			
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}
	}
	
	
	public function downloadprocessUpdateAcceptance()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="process_update_acceptance_report-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_processUpdateAcceptance_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Title", "Accepted By", "Fusion ID", "Site ID", "Name", "Location", "Client", "Process", "Acceptance Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['pu_titile'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",';
			$row .= '"'.$user['fusion_id'].'",';  
			$row .= '"'.$user['xpoid'].'",';  
			$row .= '"'.$user['xpoid'].'",';  
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['accptdate'].'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Is Update Password Report-----------------------------*/	
	public function change_user_password(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/change_user_password_report.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["is_update_password_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$is_update = $this->input->get('is_update');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"is_update" => $is_update,
						"client_id" => $cValue
					);
			
				$fullAray = $this->user_model->get_is_update_psw($field_array);
				$data["is_update_password_list"] = $fullAray;
				
				$this->create_Update_password_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/download_is_updateCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function download_is_updateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="change_user_password_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Update_password_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID", "OMUID", "First Name", "Last Name", "Location", "Designation", "Client", "Process", "Assigned To", "Update Password");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			if($user['is_update_pswd']=="Y") $updatePassword="Yes";
			else $updatePassword="No";
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['assigned_name'].'",';
			$row .= '"'.$updatePassword.'",'; 
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	 
    
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Generate Bank Details-----------------------------*/	
	public function generate_bank_details(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/generate_bank_details.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["get_bank_detail_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show' || $this->input->get('download')=='download')
			{
				$office_id = $this->input->get('office_id');
				$is_dowloadable = $this->input->get('download');
				
				$field_array = array(
						"office_id" => $office_id
					);
			
				$fullAray = $this->user_model->get_bank_details($field_array);
				
				$data["get_bank_detail_list"] = $fullAray;
				
				if($is_dowloadable != '' || $is_dowloadable=='download'){
					$this->generate_bank_details_xls($fullAray);
				}
				
				//$this->generate_bank_details_csv($fullAray);
				$dn_link = base_url()."reports_hr/download_bank_csv/".$office_id;
					
			} 
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function generate_bank_details_csv($rr)
	{
		$filename = "./assets/reports/Bank-Details.csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID","First Name", "Last Name", "Designation", "Client", "Department", "Bank Name", "Branch", "Account No", "Account Type", "IFSC Code", "PAN/TRN", "NIS/SSN" , "Status");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['shname'].'",'; 
			$row .= '"'.$user['bank_name'].'",'; 
			$row .= '"'.$user['branch'].'",'; 
			$row .= '"'.$user['acc_no'].'",'; 
			$row .= '"'.$user['acc_type'].'",'; 
			$row .= '"'.$user['ifsc_code'].'",';
			$row .= '"'.$user['pan_no'].'",';
			$row .= '"'.$user['social_security_no'].'",';
			$row .= '"'.$user['status'].'"';
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	public function download_bank_csv($office_id='All')
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Bank-Details.csv";
		$newfile="Bank Details of ".$office_id.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	
	public function generate_bank_details_xls($rr)
	{
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle('Bank Details ');
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			 $this->objPHPExcel->getActiveSheet()->getStyle('A1:K1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())
       ->getAlignment()->setWrapText(true);
			
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
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:P1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:P2")->getFill()->applyFromArray(
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
				'size'  => 16,
				'name'  => 'Algerian'
			));

			$this->objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 1, "BANKING REPORT DETAILS");
			$sheet->mergeCells('A1:J1');
							
			
          $header = array("Fusion ID", "XPOID","OM ID", "First Name", "Last Name", "Designation", "Client", "Department", "Bank Name", "Branch", "Account No", "IFSC Code", "Account Type", "PAN/TRN", "NIS/SSN","Status");

			$col=0;
			$row=2;
		
			foreach($header as  $excel_header){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $excel_header);	
					$col++; 
			}
			
			$row=3;
			foreach($rr as $user){ 
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row, $user['fusion_id']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row, $user['xpoid']);
				
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$row, $user['omuid']); 
				
				
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row, $user['fname']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row, $user['lname']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$row, $user['role_name']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $user['client_name']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$row, $user['shname'] );
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(8, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$row, $user['bank_name']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(9, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$row, $user['branch']);
 
				$this->objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->setValueExplicit($user['acc_no'], PHPExcel_Cell_DataType::TYPE_STRING);

				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(11, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$row, $user['ifsc_code']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(12, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$row, $user['acc_type']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(13, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$row, $user['pan_no']);
				
				//$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(14, //$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$row, $user['social_security_no']);
				
				$this->objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $row)->setValueExplicit($user['social_security_no'], PHPExcel_Cell_DataType::TYPE_STRING);
			
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$row, $user['status']);
				
					
				$row ++;
			
			}
		 
 
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="bank_details.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
            
	}
	
	
	
	
	
	
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------FEMS CERTIFICATION-----------------------------*/	
	public function fems_user_certification(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/fems_user_certification.php";
			
			$action="";
			$dn_link="";
			
			if(get_role_dir()=="super" || $is_global_access==1){
					//$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					//$sCond=" Where id = '$user_site_id'";
					
					//$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
			
				if($this->input->post('showReports') == "Show" ){
					$action="do";
					$officeid  =  $this->input->post('office_id');
					$fems_result  =  $this->input->post('result');
					$fems_id  =  $this->input->post('fusion_id');
					
					if($fems_id == ''){
						if($fems_result == 1){
							$fems_result='PASS';
						}else{
							$fems_result='FAIL';
						}
					}else{
						$fems_result='ALL';
					}
					
					$data['oValue']  = $officeid;
					$data['fems_result'] = $fems_result;
					
					if($fems_id != ''){
						$fullAray = $this->user_model->user_certification_details('',$fems_id);
						$data["get_certification_details"] = $fullAray;	
					}else{
						
						$fullAray = $this->user_model->user_certification_details($officeid);
						$data["get_certification_details"] = $fullAray;
					}
					
					
					$this->create_user_certification_CSV($fullAray);
					$dn_link = base_url()."reports_hr/download_user_certificationCsv";
					
					
					//echo "<pre>";
					//print_r($data["get_certification_details"]);
				
				}
				  
					$data['download_link']=$dn_link;
					$data["action"] = $action;	
				
			
			 
			
			$this->load->view('dashboard',$data);
		}
	}

	
	public function download_user_certificationCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Users_certification_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_user_certification_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("User Name", "Total Questions", "Correct Answers", "Marks(%)");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			$tot_corr_ans=$user['tot_corr_ans'];
			$tot_answer=$user['total_question_attempted'];
			
			$percentage=round((($tot_corr_ans/$tot_answer)*100), 2);
		
			$row = '"'.$user['user_name'].'",'; 
			$row .= '"'.$user['total_question_attempted'].'",';
			$row .= '"'.$user['tot_corr_ans'].'",';
			$row .= '"'.$percentage.'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	///////////////////////////////Generate DFR Candidate Information//////////////////////
	
	public function dfr_candidate_info()
	{
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data['start_date']="";
			$data['end_date']="";
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/generate_dfr_candidate_details.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["get_candidate_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('showReports')=='Show')
			{
			
				$office_id = $this->input->get('office_id');
				$start_date = $this->input->get('start_date');
				$end_date = $this->input->get('end_date');
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['oValue']=$office_id;
				
				if($office_id == 'ALL')
				{
					$query = $this->db->query("SELECT dfr_candidate_details.*,dfr_requisition.raised_date, dfr_requisition.requisition_id FROM dfr_candidate_details LEFT JOIN dfr_requisition ON dfr_requisition.id=dfr_candidate_details.r_id WHERE (DATE_FORMAT(dfr_candidate_details.added_date,'%m/%d/%Y') BETWEEN '".$start_date."' AND '".$end_date."')");
				}
				else
				{
					$query = $this->db->query("SELECT dfr_candidate_details.*,dfr_requisition.raised_date, dfr_requisition.requisition_id FROM dfr_candidate_details LEFT JOIN dfr_requisition ON dfr_requisition.id=dfr_candidate_details.r_id WHERE dfr_requisition.location='KOL' AND (DATE_FORMAT(dfr_candidate_details.added_date,'%m/%d/%Y') BETWEEN '".$start_date."' AND '".$end_date."')");
				}
				
				
				$data["get_candidate_list"] = $query->result_array();
				
				$this->download_dfr_candidate_csv_array($data["get_candidate_list"]);
					
				$dn_link = base_url()."reports_hr/download_dfr_candidate_csv/".$office_id;
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function download_dfr_candidate_csv_array($rr)
	{
		$filename = "./assets/reports/DFR-Candidate-Details.csv";
		$fopen = fopen($filename,"w+");
		$header = array("Reference ID","Date Created","First Name","Last Name","Parmanent Address","Address for Correspondence","City","State","Zipcode","Country","Phone Number","Alternate Phone Number","Qualification","Total Exp","Email","From Where You Know About Us","Referer Info");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['raised_date'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['address'].'",'; 
			$row .= '"'.$user['correspondence_address'].'",'; 
			$row .= '"'.$user['city'].'",'; 
			$row .= '"'.$user['state'].'",'; 
			$row .= '"'.$user['postcode'].'",'; 
			$row .= '"'.$user['country'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['alter_phone'].'",';
			$row .= '"'.$user['last_qualification'].'",';
			$row .= '"'.$user['total_work_exp'].'",';
			$row .= '"'.$user['hiring_source'].'",';
			$rf_array = array();
			$rf_array[] = $user['ref_name'];
			$rf_array[] = $user['ref_dept'];
			$rf_array[] = $user['ref_id'];
			$c_rf_array = array_filter($rf_array);
			$row .= '"'.implode(',',$c_rf_array).'",';
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	public function download_dfr_candidate_csv($office_id='All')
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/DFR-Candidate-Details.csv";
		$newfile="DFR Candidate Details of ".$office_id.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	

//////////////////////////////////////////////////////////////

/*-------------------Process Update User Lists Report-----------------------------*/	
	public function user_process_update_list(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/user_process_update_list.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			/* $data["is_update_password_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$is_update = $this->input->get('is_update');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"is_update" => $is_update,
						"client_id" => $cValue
					);
			
				$fullAray = $this->user_model->get_is_update_psw($field_array);
				$data["is_update_password_list"] = $fullAray;
				
				$this->create_Update_password_CSV($fullAray);
					
				$dn_link = base_url()."reports/download_is_updateCsv";
					
			} */
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	/* public function download_is_updateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="change_user_password_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Update_password_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID", "OMUID", "First Name", "Last Name", "Location", "Designation", "Client", "Process", "Assigned To", "Update Password");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			if($user['is_update_pswd']=="Y") $updatePassword="Yes";
			else $updatePassword="No";
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['assigned_name'].'",';
			$row .= '"'.$updatePassword.'",'; 
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	 */ 
	
//////////////////////////////////////////////////////////////

/*-------------------Add Referral Lists Report-----------------------------*/	
	public function add_referrals_lists(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/add_referrals_report.php";
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			
			$data["add_referrals_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				$field_array = array(
						"date_from" => $date_from,
						"date_to" => $date_to,
						"office_id" => $office_id
					);
					
			
				$fullAray = $this->user_model->list_add_referral($field_array);
				$data["add_referrals_list"] = $fullAray;
				
				$this->create_add_referral_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/download_add_referralCSV";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from']=$date_from;
			$data['date_to']=$date_to;
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function download_add_referralCSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="add_referral_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_add_referral_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Name", "Location", "Phone", "Email", "Added By", "Fusion ID",  "Department",  "Client",  "Process", "Added Date", "Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			$row = '"'.$user['name'].'",'; 
			$row .= '"'.$user['off_loc'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['email'].'",'; 
			$row .= '"'.$user['added_name'].'",'; 
			$row .= '"'.$user['referral_fusionid'].'",'; 
			$row .= '"'.$user['department'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['added_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comment'])).'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	} 
    
	
////////////////////Master Database (19.07.2019)//////////////////////

	/*-------------------Master User Lists Report-----------------------------*/	
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
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/fems_master_database.php";
			
			
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
			
				$fullAray = $this->user_model->master_database_list($field_array);
				
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
			$objWorksheet->getColumnDimension('BD')->setAutoSize(true);
			$objWorksheet->getColumnDimension('BE')->setAutoSize(true);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:BD1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A1:BE1")->getFill()->applyFromArray(
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
					
			
			
           $header = array("Fusion ID", "XPOID", "First Name", "Last Name", "Full Name", "Client", "Process", "Batch Code", "Designation", "Organization Role", "Location", "Department", "DOJ", "Rejoining Date", "Joining Month", "DOB", "Age", "Boss Name", "Official Email ID", "Personal Email ID", "Father's Name", "Gender", "Highest Qualification", "Present Address", "Permanent Address", "Pincode", "Mobile Number","Emergency Phone", "Blood Group", "Marital Status", "PAN Number", "UAN Number", "Aadhar Number", "Existing Bank A/C Number", "Existing ESI Number", "Bank IFSC CODE", "Hiring Source", "Hiring Sub Source", "Tenurity", "Experience", "Status", "Phase", "Term Date", "Term Type", "Caste", "Payroll Type", "Resign Status", "Released Date","Furlough Date","Furlough Expiry Date","Furlough Revoke Date","Bench Date","Suspended Date", "certify_address","work_home","office_assets","specifications");

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
						if($currTermDateCal >= $currentJoinDate)
						{
							if($flagTenure == true){
								$countDiffTerm = floor(($currTermDateCal-$currentJoinDate) / (60*60*24));
								$tenureDays = $tenureDays + $countDiffTerm;
								$countedTenure++;
							}
							$flagTenure = false;
							if(!empty($rejoining_dates))
							{
								if(!empty($rejoinDateAr[$checker]) && (strtotime($rejoinDateAr[$checker]) >= $currTermDateCal))
								{
									$flagTenure = true;
									$currentJoinDate = strtotime($rejoinDateAr[$checker]);
								}
							}
						}						
						$checker++;
					}
					
					if(!empty($rejoinDateAr[count($termin_dates) - 1]) && $flagTenure == true)
					{
						if($user['status']!=0 && strtotime(CurrDate()) >= $currentJoinDate){
							$countDiffTerm = floor((strtotime(CurrDate()) - $currentJoinDate) / (60*60*24));
							$tenureDays = $tenureDays + $countDiffTerm;
							$countedTenure++;
						}
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
				
				$phaseStatus = $this->display_user_phase($user['phase']);
				
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
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['address_permanent']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['pin']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['phone']);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $user['phone_emar']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				
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
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $tenureDays." Days");
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $experience);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $status);
				
				$iColumn++;
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($iColumn, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColumn,$row, $phaseStatus);
				
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
	
	
	
	
	/* public function download_master_databaseCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="master_database_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_master_datebase_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID", "First Name", "Last Name", "Client", "Process", "Batch Code", "Role", "Organization Role", "Location", "Department", "DOJ", "Joining Month", "DOB", "Age", "Boss Name", "Official Email ID", "Personal Email ID", "Father's Name", "Gender", "Highest Qualification", "Present Address", "Permanent Address", "Mobile Number", "Blood Group", "Marital Status", "PAN Number", "UAN Number", "Aadhar Number", "Existing Bank A/C Number", "Bank IFSC CODE", "Hiring Source", "Hiring Sub Source", "Tenurity");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{
			
			$join_month = date('F', strtotime($user['doj']));
										
			$age_date1 = strtotime($user['dob']);
			$age_date2 = strtotime(CurrDate());
			$age = $age_date2 - $age_date1;
			$age_diff = floor($age / (60*60*24*365) );
			
			$tenu_date1 = strtotime($user['doj']);
			$tenu_date2 = strtotime(CurrDate());
			$interval = $tenu_date2 - $tenu_date1;
			$tenu_diff = floor($interval / (60*60*24) );
			
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",';
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['batch_code'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['org_role_name'].'",'; 
			$row .= '"'.$user['office_name'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['doj'].'",'; 
			$row .= '"'.$join_month.'",'; 
			$row .= '"'.$user['dob'].'",'; 
			$row .= '"'.$age_diff." Years".'",'; 
			$row .= '"'.$user['assigned_name'].'",'; 
			$row .= '"'.$user['email_id_off'].'",'; 
			$row .= '"'.$user['email_id_per'].'",'; 
			$row .= '"'.$user['father_name'].'",'; 
			$row .= '"'.$user['sex'].'",'; 
			$row .= '"'.$user['lastQualification'].'",'; 
			$row .= '"'.$user['address_present'].'",'; 
			$row .= '"'.$user['address_parmanent'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['blood_group'].'",'; 
			$row .= '"'.$user['marital_status'].'",'; 
			$row .= '"'.$user['pan_no'].'",'; 
			$row .= '"'.$user['uan_no'].'",'; 
			$row .= '"'.$user['social_secuirity_no'].'",'; 
			$row .= '"'.$user['acc_no'].'",'; 
			$row .= '"'.$user['ifsc_code'].'",'; 
			$row .= '"'.$user['hiring_source'].'",'; 
			$row .= '"'.$user['hiring_sub_source'].'",'; 
			$row .= '"'.$tenu_diff." Days".'",';
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}  */
    
//////////////////End Master Database Report//////////////////////	

/*-------------------User Break Status Report-----------------------------*/	
	public function user_break_stats(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$ses_dept_id=get_dept_id();
			
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			$dept_id = $this->input->get('dept_id');
			if($dept_id=="")  $dept_id=$ses_dept_id;
					
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/user_break_stats.php";
			
			
			$data["role_dir"]=$role_dir;
			$action="";
			$dn_link="";
			
			$date_from="";
			$date_to="";
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
						
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
				
			
			$data["user_break_list"] = array();
			
						
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				
				$field_array = array(
						"date_from" => $date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"dept_id"=> $dept_id,
				);
				
				$fullAray = $this->reports_model->user_break_stats($field_array);
				$data["user_break_list"] = $fullAray;
				
				$this->user_break_stats_CSV($fullAray);
					
				$dn_link = base_url()."reports_hr/user_break_statsCSV";
					
			}
			
			$data['date_from']=$date_from;
			$data['date_to']=$date_to;
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function user_break_statsCSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="user_break_stats.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function user_break_stats_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Date", "Fusion ID", "XPOID", "Name", "Department", "Client", "Process", "Location", "Designation", "L1 Supervisor", "Break Start (EST)", "Break Start (Local)", "Break End (EST)", "Break End (Local)", "Break Duration", "Break Type");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			$t_diff = strtotime($user['intime_est']) - strtotime($user['outtime_est']);
			$tDiff = gmdate("H:i:s", $t_diff);
		
			$row = '"'.$user['out_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['assigned_name'].'",'; 
			$row .= '"'.$user['outtime_est'].'",'; 
			$row .= '"'.$user['outtime_local'].'",'; 
			$row .= '"'.$user['intime_est'].'",'; 
			$row .= '"'.$user['intime_local'].'",'; 
			$row .= '"'.$tDiff.'",';
			$row .= '"'.$user['source'].'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	} 
    
///////////////////////////////////////////////////////////////////////////

	
/*------------------DFR Candidate History Report-----------------------------*/	
	public function dfr_candidate_history_list(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/dfr_candidate_history_list.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			
			//$data["add_referrals_list"] = $this->user_model->list_add_referral();
			
			//$data["add_referrals_list"] = array();
			
			/*$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$is_update = $this->input->get('is_update');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"is_update" => $is_update,
						"client_id" => $cValue
					);
					
			*/
			
				//$fullAray = $this->user_model->dfr_candidate_history_list();
				//$data["add_referrals_list"] = $fullAray;
				
				//$this->create_add_referral_CSV($fullAray);
					
				//$dn_link = base_url()."reports/download_add_referralCSV";
					
			//}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	/* public function download_add_referralCSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="add_referral_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_add_referral_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Name", "Location", "Phone", "Email", "Added By", "Fusion ID", "Added Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			$row = '"'.$user['name'].'",'; 
			$row .= '"'.$user['off_loc'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['email'].'",'; 
			$row .= '"'.$user['added_name'].'",'; 
			$row .= '"'.$user['referral_fusionid'].'",'; 
			$row .= '"'.$user['added_date'].'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	} */
	
//////////////////////////////////////////////////////////////	
	
	public function dfr_dashboard()
    {
				
        if(check_logged_in())
        {
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/dfr_day_summ.php";
			
			$start_date = mysql2mmddyy(CurrDate());
			
			//$start_date = mysql2mmddyy(GetLocalDate());
						
			$location=get_user_office_id();
			//$dept=get_dept_id();
						
			//$data['department_list'] = $this->Common_model->get_department_list();	
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if($this->input->get('showReports')=='Show')
			{
				$start_date = $this->input->get('start_date');
				$location = $this->input->get('location');
				//$dept = $this->input->get('dept');
				
			}
						
			$data['start_date'] = $start_date;
			
			$start_date= mmddyy2mysql($start_date);
			
			$st_date = $start_date." 00:00:00";
			$en_date = $start_date." 23:59:59";
			
			$qSql='SELECT COUNT(*) AS opened_requisation FROM `dfr_requisition` WHERE requisition_status="A" AND due_date >= "'.$start_date.'" AND location="'.$location.'"';
						
			$query = $this->db->query($qSql);
			
			$result = $query->row();
			$data["opened_requisation"] = $result->opened_requisation;
			
			
			//$qSql = 'SELECT COUNT(*) AS candidate_registered FROM `dfr_candidate_details` dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE getEstToLocalAbbr(added_date,location) >= "'.$st_date.'" AND getEstToLocalAbbr(added_date,location) <= "'.$en_date.'" AND dr.location="'.$location.'"';
			
			$qSql = 'SELECT COUNT(*) AS candidate_registered FROM `dfr_candidate_details` dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE added_date >= "'.$st_date.'" AND added_date <= "'.$en_date.'" AND dr.location="'.$location.'"';
			
			
			$query = $this->db->query($qSql);
			
			
			$result = $query->row();
			$data["candidate_registered"] = $result->candidate_registered;
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_scheduled FROM `dfr_interview_schedules`  WHERE getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_scheduled FROM `dfr_interview_schedules`  WHERE creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_scheduled"] = $result->total_scheduled;
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_pending FROM `dfr_interview_schedules` WHERE sh_status="P" AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_pending FROM `dfr_interview_schedules` WHERE sh_status="P" AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_pending"] = $result->total_pending;
			
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_inprogress FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("IP") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_inprogress FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("IP") AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_inprogress"] = $result->total_inprogress;
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_shortlisted FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
						
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_shortlisted FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_shortlisted"] = $result->total_shortlisted;
			
						
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_selected FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("CS") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_selected FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("CS") AND creation_date >= "'.$st_date.'" and creation_date  <= "'.$en_date.'" AND interview_site="'.$location.'" ';
			
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_selected"] = $result->total_selected;
			
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_employee FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("E") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) AS total_employee FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("E") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_candidate_selected_employee"] = $result->total_employee;
			
			
			//$qSql='SELECT COUNT(*) AS total_interview_scheduled FROM `dfr_interview_schedules` WHERE   getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS total_interview_scheduled FROM `dfr_interview_schedules` WHERE   creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["total_interview_scheduled"] = $result->total_interview_scheduled;
			
			
			//$qSql='SELECT COUNT(*) AS interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N")  AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N")  AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["interview_completed"] = $result->interview_completed;
					

			//$qSql='SELECT COUNT(*) AS interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P")  AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P")  AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["interview_pending"] = $result->interview_pending;
			
			
			$data["interview_cancel"] = $data["total_interview_scheduled"] - $data["interview_completed"]- $data["interview_pending"];
			
			
			//$qSql='SELECT COUNT(*) AS hr_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS hr_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_completed"] = $result->hr_interview_completed;
			
			//$qSql='SELECT COUNT(*) AS hr_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS hr_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_type="1" AND interview_site="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_cancel"] = $result->hr_interview_cancel;
			
			//$qSql='SELECT COUNT(*) AS hr_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="1"';
						
			$qSql='SELECT COUNT(*) AS hr_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="1"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["hr_interview_pending"] = $result->hr_interview_pending;
			
			//$qSql='SELECT COUNT(*) AS ops_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$qSql='SELECT COUNT(*) AS ops_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
						
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_completed"] = $result->ops_interview_completed;
			
			//$qSql='SELECT COUNT(*) AS ops_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$qSql='SELECT COUNT(*) AS ops_interview_cancel FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_cancel"] = $result->ops_interview_cancel;
			
			$qSql='SELECT COUNT(*) AS ops_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$qSql='SELECT COUNT(*) AS ops_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" AND interview_site="'.$location.'" AND interview_type="2"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["ops_interview_pending"] = $result->ops_interview_pending;
						
			//$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'"  and sh_status not in ("SL","E","CS") AND interview_site="'.$location.'" GROUP BY c_id');
								
			
			//$qSql='SELECT COUNT(DISTINCT(c_id)) as undefind_status FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE sh_status IN("C","N") AND  getEstToLocalAbbr(creation_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(creation_date,interview_site)  <= "'.$en_date.'"  and candidate_status not in ("SL","E","CS","R") AND interview_site="'.$location.'" ';
			
			$qSql='SELECT COUNT(DISTINCT(c_id)) as undefind_status FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE sh_status IN("C","N") AND  creation_date >= "'.$st_date.'" and creation_date <= "'.$en_date.'" and candidate_status not in ("SL","E","CS","R") AND interview_site="'.$location.'" ';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_undefind_status"] =$result->undefind_status;
			
			$qSql='SELECT COUNT(*) AS candidate_rejected FROM `dfr_candidate_details`  dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE getEstToLocalAbbr(added_date,interview_site) >= "'.$st_date.'" and getEstToLocalAbbr(added_date,interview_site)  <= "'.$en_date.'" AND candidate_status="R" AND dr.location="'.$location.'"';
			
			$qSql='SELECT COUNT(*) AS candidate_rejected FROM `dfr_candidate_details`  dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE added_date >= "'.$st_date.'" and added_date <= "'.$en_date.'" AND candidate_status="R" AND dr.location="'.$location.'"';
			
			$query = $this->db->query($qSql);
			$result = $query->row();
			$data["candidate_rejected"] = $result->candidate_rejected;
						
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" GROUP BY c_id');
			//$result = $query->row();
			$data["pending_cand_final_stat"] = $query->num_rows();
	
			
			$data['location'] = $location;
			//$data['dept'] = $dept;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function emp_bank_stat()
	{
		if(check_logged_in())
        {
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/generate_bank_status.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["get_bank_detail_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show' || $this->input->get('download')=='download')
			{
				$office_id = $this->input->get('office_id');
				$is_dowloadable = $this->input->get('download');
				
				$field_array = array(
						"office_id" => $office_id
					);
				$query = $this->db->query('SELECT info_bank_payforvalid.fusion_id,signin.fname, signin.lname,info_bank_payforvalid.status,info_bank_payforvalid.remarks,info_bank.bank_name,info_bank.branch,info_bank.acc_no,info_bank.ifsc_code,info_bank.pay_varify,info_bank.pay_varify_time FROM info_bank_payforvalid LEFT JOIN signin ON signin.fusion_id=info_bank_payforvalid.fusion_id
LEFT JOIN info_bank ON info_bank.user_id=signin.id WHERE signin.office_id="'.$office_id.'"');
				$fullAray = $query->result_array();
				
				$data["get_bank_detail_list"] = $fullAray;
				
				if($is_dowloadable != '' || $is_dowloadable=='download'){
					$this->generate_bank_status_xls($fullAray);
				}
				
				//$this->generate_bank_details_csv($fullAray);
				$dn_link = base_url()."reports_hr/download_bank_csv/".$office_id;
					
			} 
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function generate_bank_status_xls($rr)
	{
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle('Bank Status ');
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			 $this->objPHPExcel->getActiveSheet()->getStyle('A1:K1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
			
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
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:L1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:L2")->getFill()->applyFromArray(
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
				'size'  => 16,
				'name'  => 'Algerian'
			));

			$this->objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 1, "BANK VARIFY STATUS");
			$sheet->mergeCells('A1:J1');
					
			
			
          $header = array("Fusion ID", "First Name","Last Name","Bank Name","Branch Name","Accound No","IFSC Code","Pay Varify","Pay Varify Time","Status","Remarks");

			$col=0;
			$row=2;
		
			foreach($header as  $excel_header){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $excel_header);	
					$col++; 
			}
			
			$row=3;
			foreach($rr as $user){ 
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row, $user['fusion_id']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row, $user['fname']);
				
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$row, $user['lname']); 
				
				
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row, $user['bank_name']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row, $user['branch']);
				
				$this->objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->setValueExplicit($user['acc_no'], PHPExcel_Cell_DataType::TYPE_STRING);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $user['ifsc_code']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$row, $user['pay_varify'] );
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(8, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$row, $user['pay_varify_time']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(9, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$row, $user['status']);
 
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(10, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$row, $user['remarks']);
					
				$row ++;
			
			}
		 
 
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="bank_status.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
            
	}
	
	
	


	/////////////////////////////////////OYOINB///////////////////////////
	
	public function headerDetails(){

		return $arrayName = array ("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Phone","Call Date","Call Duration","Campaign","Booking Id","APCT","Audit Type","Auditor Type","VOC","Czentrix","AT_calltype","AT_subtype","Correct Calltype","Correct Subtype","Lead conversion Done","Non Conversion Reason","L1","L2","Service Score","Soft Skill Score","Overall Result","Overall Score","Booking Details","Guest Understand","Complete Resolution","Objection Handling","Retention Efforts","Ownership Resolve","Customer Issue","Effective Probing","Sale Future","Selling Skills","Customer Objection","Hotel Amenities","Multiple Option","Whatsapp Option","Lifeline Compliance","OYO Assist","Escalation Metrix","SIG CID","Greet Customer Branding","Courtesy Confidence","Apology Empathy","Interruption","Active Listening","Switch Language","Grammar Sentence","Guest Permission","Verbiage Followed","Dead Air","Does Infraction Exist","Choose Reason","Tier","Attempt","Equivalent_to","Call Summary","BOD","Feedback","Entry By","Entry Date","Audit Start Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");

	}
	//----------------- PAYROLL REPORT --------------------//
	public function payroll(){
		if(check_logged_in()){
			 
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/payroll_report.php";
			
			$role_id           = get_role_id();
			$current_user      = get_user_id();
			
			$user_site_id      = get_user_site_id();
			$ses_dept_id       = get_dept_id();
			$ses_office_id     = get_user_office_id();
			$is_global_access  = get_global_access();
			
			
			$data['get_office_id'] = $ses_office_id;
			
			$sql_paytype = "SELECT * from master_payroll_type WHERE is_active = '1'";
			$data['masterpaytype'] = $this->Common_model->get_query_result_array($sql_paytype);
			
			$sql_selected = "SELECT * from master_currency WHERE is_active = '1'";
			$data['mastercurrency'] = $this->Common_model->get_query_result_array($sql_selected);
			
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			} else {
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
			
			
			// GET SELECTED FILTER
			$get_office_id = $this->input->get('office_id');
			$get_depart_id = $this->input->get('dept_id');
			$get_pay_type = $this->input->get('pay_type');
						
			if(($get_office_id != "") && ($get_depart_id != ""))
			{
				$this->payroll_excel_download($get_office_id, $get_depart_id, $get_pay_type);
			}
					
			
			
			$this->load->view("dashboard",$data);
			
		}
	}
	
	
	private function payroll_excel_download($office, $dept, $paytype)
	{
		if(check_logged_in()){
		
		$extraoffice="";
		$extradept ="";
		$extrapaytype="";
		
		if($office != ""){ $extraoffice = " AND s.office_id = '$office'"; }	
		
		if($dept != "" && $dept != "ALL"){ $extradept = " AND s.dept_id = '$dept'"; }	
		if($paytype != "" && $paytype != "ALL"){ $extrapaytype = " AND ipay.payroll_type = '$paytype'"; }	
		//if($currency != "" && $currency != "ALL"){ $extracurrency = " AND ipay.currency = '$currency'"; }	
			
		$sql_payroll = "SELECT fusion_id,xpoid,fname,lname, doj, office_id, dept_id, d.shname as dept_name, role_id, org_role_id, r.name as desig, get_client_names(s.id) as client_names, get_process_names(s.id) as process_names, status, payroll_type, mpt.name as payroll_type_name, payroll_status, mps.name as payroll_status_name, gross_pay, ipay.currency FROM signin s 
		LEFT JOIN info_payroll ipay on s.id=ipay.user_id 
		LEFT JOIN department d on d.id=s.dept_id 
		LEFT JOIN role r on r.id=s.role_id 
		LEFT JOIN master_payroll_type mpt on mpt.id=ipay.payroll_type 
		LEFT JOIN master_payroll_status mps on mps.id=ipay.payroll_status 
		WHERE gross_pay>0 and gross_pay IS NOT NULL  $extraoffice $extradept $extrapaytype";
				
		
		$query_payroll = $this->Common_model->get_query_result_array($sql_payroll);
		
		$file_title = "PAYROLL_REPORT_" .date('Y-m-d');
		$sheet_title = "PAYROLL REPORT - " .$office ." - " .date('Y-m-d');
		
			// EXCEL TITLE
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle($file_title);
			$this->excel->getActiveSheet()->setCellValue('A1', $sheet_title);
			$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->mergeCells('A1:I1');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'FEMSID');
			$this->excel->getActiveSheet()->setCellValue('C2', 'XPOID');
			$this->excel->getActiveSheet()->setCellValue('D2', 'Name');
			$this->excel->getActiveSheet()->setCellValue('E2', 'Designation');
			$this->excel->getActiveSheet()->setCellValue('F2', 'Process');
			$this->excel->getActiveSheet()->setCellValue('G2', 'Department');
			$this->excel->getActiveSheet()->setCellValue('H2', 'Location');
			$this->excel->getActiveSheet()->setCellValue('I2', 'Pay Type');
			$this->excel->getActiveSheet()->setCellValue('J2', 'Currency');
			$this->excel->getActiveSheet()->setCellValue('K2', 'Total Earning (Gross Pay)');
			$this->excel->getActiveSheet()->setCellValue('L2', 'Basic');
			$this->excel->getActiveSheet()->setCellValue('M2', 'HRA');
			$this->excel->getActiveSheet()->setCellValue('N2', 'Conveyance');
			$this->excel->getActiveSheet()->setCellValue('O2', 'Other Allowance');
			$this->excel->getActiveSheet()->setCellValue('P2', "PF (Employer's)");
			$this->excel->getActiveSheet()->setCellValue('Q2', "ESIC (Employer's)");
			$this->excel->getActiveSheet()->setCellValue('R2', 'CTC');
			$this->excel->getActiveSheet()->setCellValue('S2', 'P.Tax');
			$this->excel->getActiveSheet()->setCellValue('T2', "PF (Employee's)");
			$this->excel->getActiveSheet()->setCellValue('U2', "ESIC (Employee's)");
			$this->excel->getActiveSheet()->setCellValue('V2', "Take Home");
			
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("15");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("30");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('E')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("22");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('F')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('G')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('H')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("10");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('I')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
			
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('J')->setAutoSize(false);			
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('K')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('L')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('M')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth("25");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('N')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth("10");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('0')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth("25");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('P')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('Q')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('R')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('S')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('T')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth("20");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('U')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth("25");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('V')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth("25");
			
			$this->excel->getActiveSheet()->getStyle('A2:V2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bcdbe7');
						
			$sl = "0";
			$cellid = "2";
			$cal_pay_componant = array(1,7,8);
			
			foreach($query_payroll as $token)
			{
				$sl++;
				$cellid++;	
				///////////////////
				$mypay_type_id = $token['payroll_type'];
				$mypay_type = $token['payroll_type_name'];
				$mypay_currency = $token['currency'];
				$gross_pay=$token['gross_pay'];
				$location = $token['office_id'];
				$org_role_id = $token['org_role_id'];
				
				
				$hra = 0; 
				$conveyance = 0;
				$other_allowance = 0;
				$pf = 0;
				$ptax = 0;
				$esi_employer = 0;
				$esi_employee = 0;
				//$basic = $gross_pay;
				$basic = 0;
				$ctc = $gross_pay;
				$tk_home = $gross_pay;
				
				// FOR Salaried USERS CHECK
				if(in_array($mypay_type_id, $cal_pay_componant)==true){
				  
					$basic = get_basic($gross_pay, $location, $org_role_id);
					$hra =  get_hra($basic, $location, $org_role_id);
					
					$conveyance = get_conveyance($gross_pay, $location);
					$other_allowance = get_allowance($gross_pay, $basic, $hra,$conveyance, $location);
					
					$pf = get_pf($basic, $location);
					$ptax = get_ptax($gross_pay, $location);
					
					$esi_employer = get_esi_employer($gross_pay, $location);
					$esi_employee = get_esi_employee($gross_pay, $location);
					
					if($mypay_type_id=="8"){
						$pf=0;
						$esi_employer=0;
						$esi_employee=0;
					}
					
					$ctc = $gross_pay + $esi_employer + $pf;
					$tk_home = round($gross_pay - ($pf + $esi_employee + $ptax ));
				
				}
				
				/////////////
				
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl);
				$this->excel->getActiveSheet()->setCellValue("B".$cellid, $token['fusion_id']);
				$this->excel->getActiveSheet()->setCellValue("C".$cellid, $token['xpoid']);	
				$this->excel->getActiveSheet()->setCellValue("D".$cellid, $token['fname'] ." " .$token['lname']);	
				$this->excel->getActiveSheet()->setCellValue("E".$cellid, $token['desig']);	
				$this->excel->getActiveSheet()->setCellValue("F".$cellid, $token['process_names']);	
				$this->excel->getActiveSheet()->setCellValue("G".$cellid, $token['dept_name']);	
				$this->excel->getActiveSheet()->setCellValue("H".$cellid, $token['office_id']);
				$this->excel->getActiveSheet()->setCellValue("I".$cellid, $mypay_type);
				$this->excel->getActiveSheet()->setCellValue("J".$cellid, $mypay_currency);
				$this->excel->getActiveSheet()->setCellValue("K".$cellid, $gross_pay);
				$this->excel->getActiveSheet()->setCellValue("L".$cellid, $basic);
				$this->excel->getActiveSheet()->setCellValue("M".$cellid, $hra);
				$this->excel->getActiveSheet()->setCellValue("N".$cellid, $conveyance);
				$this->excel->getActiveSheet()->setCellValue("O".$cellid, $other_allowance);
				$this->excel->getActiveSheet()->setCellValue("P".$cellid, $pf);
				$this->excel->getActiveSheet()->setCellValue("Q".$cellid, $esi_employer);
				$this->excel->getActiveSheet()->setCellValue("R".$cellid, $ctc);
				$this->excel->getActiveSheet()->setCellValue("S".$cellid, $ptax);
				$this->excel->getActiveSheet()->setCellValue("T".$cellid, $pf);
				$this->excel->getActiveSheet()->setCellValue("U".$cellid, $esi_employee);
				$this->excel->getActiveSheet()->setCellValue("V".$cellid, $tk_home);
				
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("B".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("C".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("E".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->setIndent('1');
				$this->excel->getActiveSheet()->getStyle("F".$cellid)->getAlignment()->setIndent('1');
				$this->excel->getActiveSheet()->getStyle("G".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("H".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("I".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
				$this->excel->getActiveSheet()->getStyle("J".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("K".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("L".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("M".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("N".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("O".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("P".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("Q".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("R".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("S".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("T".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("U".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("V".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
			}
			
			// CENTER FIELD
			$cellid = '2';
			$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->setIndent('1');
			$this->excel->getActiveSheet()->getStyle("F".$cellid)->getAlignment()->setIndent('1');
			$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("B".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("C".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("E".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("G".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("H".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("I".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("J".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("K".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("L".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("M".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("R".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->getStyle("V".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$file_title.'.xls"'); //tell browser what's the file name
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			ob_end_clean();
			$objWriter->save('php://output');
			
			} else {
				redirect(base_url());
			}
	}




////////////////// Profile Document Upload ///////////////////////////

	public function document_upload(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports_hr/document_upload_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$office_id = "";
			$dept_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			
			$data["docu_upl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				//$fusion_id = $this->input->get('fusion_id');
				
				if($office_id=='All') $cond .= "";
				else $cond .= " and office_id='$office_id'";
				
				if($dept_id=='All') $cond .= "";
				else $cond .= " and dept_id='$dept_id'";
				
				if($cValue=='All' || $cValue=='' || $cValue=='0' || $cValue=='ALL') $cond .= "";
				else $cond .= " and client='$cValue'";
				
				if($pValue=='All' || $pValue=='' || $pValue=='0' || $pValue=='ALL') $cond .= "";
				else $cond .= " and process='$pValue'";
				
				
				$qSql="SELECT * from 
				(select id, fusion_id, office_id, dept_id, (select description from department d where d.id=dept_id) as dept_name, concat(fname, ' ', lname) as name, status, get_client_ids(id) as client, get_process_ids(id) as process, get_client_names(id) as client_name, get_process_names(id) as process_name, (select GROUP_CONCAT(iod.info_type) as other_info FROM info_others_doc iod where iod.user_id=signin.id) as other_docu_info from signin) masdt Left Join 
				(select user_id as ie_uid, max(job_doc) as job_doc from info_experience group by ie_uid) aa On (masdt.id=aa.ie_uid) Left Join
				(select user_id as ib_uid, max(bank_doc) as bank_doc from info_bank group by ib_uid) bb On (masdt.id=bb.ib_uid) Left join
				(select user_id as ip_uid, max(passport_doc) as passport_doc from info_passport group by ip_uid) cc On (masdt.id=cc.ip_uid) Left join
				(select user_id as ied_uid, max(education_doc) as education_doc from info_education group by ied_uid) dd On (masdt.id=dd.ied_uid) Left join
				(select user_id as uid, marital_status from info_personal group by uid) ee On (masdt.id=ee.uid) Left Join
				(select user_id as idu_uid,pan_doc,aadhar_doc,aadhar_doc_back,nis_doc,birth_certi_doc,marrige_certi_doc,photograph,resume_doc,nit_doc,isss_doc,afp_info_doc,background_local_doc, sss_no_doc,tin_no_doc,philhealth_no_doc,dependent_birth_certi_doc,bir_2316_doc,nbi_clearance_doc,offer_letter,employment_contract,profile_sketch,updated_cv from info_document_upload) ff On (masdt.id=ff.idu_uid)
				where status=1 $cond GROUP BY fusion_id";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["docu_upl_list"] = $fullAray;
				$this->create_docu_upl_CSV($fullAray, $office_id);	
				$dn_link = base_url()."reports_hr/download_docu_upl_CSV/".$office_id;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_docu_upl_CSV($off)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Profile Document Upload List-'".$off."' - '".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_docu_upl_CSV($rr,$off)
	{
		// print_r($rr); exit;
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($off=='JAM'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Tax Registration Number ID", "National Insurance Scheme ID", "Birth Certificate", "Married", "Marriage Certificate", "Bank Info", "Education Info", "Passport", "Other Document Upload");
		}else if($off=='KOL' || $off=='HWH' || $off=='BLR' || $off=='NOI' || $off=='CHE'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Aadhar Card / Social Secuirity No","Aadhar Card Back / Social Secuirity No Back", "PAN Card", "Photograph", "Covid-19 Declaration", "Education Info", "Passport", "Experience Info", "Other Document Upload");
		}else if($off=='ELS'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Resume", "NIT", "ISSS Information", "AFP Information", "Background Local",  "Passport", "Other Document Upload");
		}else if($off=='CEB' || $off=='MAN'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "SSS Number", "TIN Number", "Birth Certificate", "Philhealth Number", "Dependents Birth Certificate",  "Married", "Marriage Certificate", "BIR 2316 from previous",  "NBI Clearance", "Offer Letter", "Employment Contract", "Profile Sketch", "Updated CV", "Other Document Upload");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($off=='JAM'){
			
			foreach($rr as $user)
			{
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['nis_doc']!='') $nis_doc='Yes';
				else $nis_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bank_doc']!='') $bank_doc='Yes';
				else $bank_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
			
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$nis_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bank_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='KOL' || $off=='HWH' || $off=='BLR' || $off=='NOI' || $off=='CHE'){
		
			foreach($rr as $user)
			{
				if($user['aadhar_doc']!='') $aadhar_doc='Yes';
				else $aadhar_doc='No';
				if($user['aadhar_doc_back']!='') $aadhar_doc_back='Yes';
				else $aadhar_doc='No';
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['photograph']!='') $photograph='Yes';
				else $photograph='No';
				if($user['covid19declare_doc']!='') $covid19declare_doc='Yes';
				else $covid19declare_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				if($user['job_doc']!='') $experience_doc='Yes';
				else $experience_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$aadhar_doc.'",';
				$row .= '"'.$aadhar_doc_back.'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$photograph.'",';
				$row .= '"'.$covid19declare_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$experience_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='ELS'){
		
			foreach($rr as $user)
			{
				if($user['resume_doc']!='') $resume_doc='Yes';
				else $resume_doc='No';
				if($user['nit_doc']!='') $nit_doc='Yes';
				else $nit_doc='No';
				if($user['isss_doc']!='') $isss_doc='Yes';
				else $isss_doc='No';
				if($user['afp_info_doc']!='') $afp_info_doc='Yes';
				else $afp_info_doc='No';
				if($user['background_local_doc']!='') $background_local_doc='Yes';
				else $background_local_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$resume_doc.'",';
				$row .= '"'.$nit_doc.'",';
				$row .= '"'.$isss_doc.'",';
				$row .= '"'.$afp_info_doc.'",';
				$row .= '"'.$background_local_doc.'",';
				$row .= '"'.$passport_doc.'"';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='CEB' || $off=='MAN'){
		
			foreach($rr as $user)
			{
				if($user['sss_no_doc']!='') $sss_no_doc='Yes';
				else $sss_no_doc='No';
				if($user['tin_no_doc']!='') $tin_no_doc='Yes';
				else $tin_no_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['philhealth_no_doc']!='') $philhealth_no_doc='Yes';
				else $philhealth_no_doc='No';
				if($user['dependent_birth_certi_doc']!='') $dependent_birth_certi_doc='Yes';
				else $dependent_birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bir_2316_doc']!='') $bir_2316_doc='Yes';
				else $bir_2316_doc='No';
				if($user['nbi_clearance_doc']!='') $nbi_clearance_doc='Yes';
				else $nbi_clearance_doc='No';
				if($user['offer_letter']!='') $m_offer_doc='Yes';
				else $m_offer_doc='No';
				if($user['employment_contract']!='') $m_contract_doc='Yes';
				else $m_contract_doc='No';
				if($user['profile_sketch']!='') $m_profile_doc='Yes';
				else $m_profile_doc='No';
				if($user['updated_cv']!='') $m_updatedcv_doc='Yes';
				else $m_updatedcv_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$sss_no_doc.'",';
				$row .= '"'.$tin_no_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$philhealth_no_doc.'",';
				$row .= '"'.$dependent_birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bir_2316_doc.'",';
				$row .= '"'.$nbi_clearance_doc.'",';
				$row .= '"'.$m_offer_doc.'",';
				$row .= '"'.$m_contract_doc.'",';
				$row .= '"'.$m_profile_doc.'",';
				$row .= '"'.$m_updatedcv_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		
		fclose($fopen);
	}
	

	
	//==================================== BANK REPORTS UPLOAD ====================================================//
	
	public function upload_bank_report()
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
		
		$data["aside_template"] = "reports_hr/aside.php";
		$data["content_template"] = "reports_hr/upload_bank_reports.php";
		
		$data['officeSelected'] = $user_office_id;
		$data['deptSelected'] = $get_dept_id;
		if($this->input->get('report_office_id')){
			
			$data['officeSelected'] = $officeSelection = $this->input->get('report_office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('report_dept_id');
			$data['fusionSelected'] = $fusionSelection = $this->input->get('report_fusion_id');

			$get_office_id = $officeSelection; $extraOffice = "";
			if(($get_office_id != "") && ($get_office_id != "ALL")){
				$extraOffice = " AND s.office_id = '$get_office_id' ";
			}			
			$get_dept_id = $deptSelection; $extraDept = "";
			if(($get_dept_id != "") && ($get_dept_id != "ALL")){
				$extraDept = " AND s.dept_id = '$get_dept_id' ";
			}
			$get_fusion_id = $fusionSelection; $extraFusion = "";
			if(($get_fusion_id != "")){
				$extraDept = "";
				$fusion_ids_ar = explode(',', $fusionSelection);
				$fusion_ids = implode("','", $fusion_ids_ar);
				$extraFusion = " AND s.fusion_id IN ('".$fusion_ids."') ";
			}
					
			$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, 
								  d.description as department, r.name as designation, s.office_id as office, 
								  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor, 
								  b.* from info_bank as b
								  LEFT JOIN signin as s ON b.user_id = s.id
								  LEFT JOIN signin as ls ON ls.id = s.assigned_to
								  LEFT JOIN department as d on d.id=s.dept_id
								  LEFT JOIN role as r on r.id=s.role_id
								  WHERE 1 AND s.status IN (1,4) $extraOffice $extraDept $extraFusion";
			$report_list = $this->Common_model->get_query_result_array($reports_sql);
			//echo FCPATH; die();
			//			
			$csvfile=$this->generate_upload_bank_report_xls($report_list, $officeSelection);
			$this->generate_download_archieve_2($report_list,$csvfile, $officeSelection);
		}
		
		
		$this->load->view('dashboard',$data);
	
	}
	
	public function generate_download_archieve($reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "reports_archieve"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/Bank_Upload_Report_.xlsx";
		$this->zip->read_file($csvfile, "Bank_Upload_Report_".$office.".xlsx");
		
        foreach ($reportArray as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$department = $token["department"];
			$uploadDir = FCPATH.'/uploads/bank_upload/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['upl_bank_info'];
			$newFileName = $fusionID."_".$firstname."_".$office.".".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['upl_bank_info'] != ""){
				$this->zip->read_file($fileName, $newFileName);
			}			
        }
		
        $this->zip->download($zipFileName.'.zip');		
	}
	
	public function generate_download_archieve_2($reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "reports_archieve"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/Bank_Upload_Report_.xlsx";
		$zipfilename = 'uploads/bank_upload_zip/Bank_Upload_Report_'.$office.'.zip';
		
		if(file_exists(FCPATH.$zipfilename)){
			unlink(FCPATH.$zipfilename);
		}
		//$this->zip->read_file($csvfile, "Bank_Upload_Report_".$office.".xlsx");
		$zip = new ZipArchive;
		if ($zip->open(FCPATH . $zipfilename, ZipArchive::CREATE) === TRUE) {			
			$zip->addFile($csvfile, "Bank_Upload_Report_".$office.".xlsx");		
			foreach ($reportArray as $token)
			{
				$fusionID   = $token["fusion_id"];
				$firstname  = $token["fullname"];
				$office     = $token["office"];
				$department = $token["department"];
				$uploadDir = FCPATH.'/uploads/bank_upload/'.$fusionID.'/';
				
				$fileName = $uploadDir.$token['upl_bank_info'];
				$newFileName = $fusionID."_".$firstname."_".$office.".".pathinfo($fileName, PATHINFO_EXTENSION);
				
				if(file_exists($fileName) && $token['upl_bank_info'] != ""){
					$zip->addFile($fileName, $newFileName);
					//$this->zip->read_file($fileName, $newFileName);
				}			
			}
			$zip->close();
		}
		header('Location:'.base_url() . $zipfilename);
        //$this->zip->download($zipFileName.'.zip');		
	}
	
	public function checksize()
	{
		$maxUpload      = (int)(ini_get('upload_max_filesize'));
		$maxPost        = (int)(ini_get('post_max_size'));
		echo $maxUpload ." | " .$maxPost;
		
	}
	
	public function generate_upload_bank_report_xls($reportArray, $office ='')
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
		$objWorksheet->setTitle('Bank Upload Report');
		
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
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Is Upload");
				
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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "Bank Upload Document Report");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
			
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$report_files = array();		
		foreach($reportArray as $wk=>$wv)
		{
			$user_id = $wv['user_id'];
			$is_upload = $wv['is_acpt_document'] > 0 ? 'Yes' : 'No';
			
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
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_upload);
			
		}
		
		$filename = "./assets/reports/Bank_Upload_Report_".$office.".xlsx";
		
		ob_end_clean();
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		////header('Content-Disposition: attachment;filename="Bank_Upload_Report_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		//$objWriter->save('php://output');	
		$objWriter->save($filename);
		
		return $filename;
	}
	
	
	//=================== DFR POOL REPORT ========================================//
	public function dfr_pool_list()
	{
		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		$extraFilter = "";
		$extraOffice = "";
		$ticket_no = "";
		$start_time = "00:00:00";
		$end_time = "23:59:59";
		
		// FILTER DATE CHECK 
		$month_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
		$from_date = date('m/01/Y', strtotime(CurrMySqlDate()));
		$to_date = date('m/' .$month_days."/Y");
		
		$search_from_date = date('Y-m-d', strtotime($from_date));
		$search_to_date = date('Y-m-d', strtotime($to_date));
		
		$search = false;
		if(!empty($this->input->get('search_from_date')))
		{
			$search = true;
			$from_date = $this->input->get('search_from_date');
			$to_date = $this->input->get('search_to_date');
			$search_from_date = date('Y-m-d', strtotime($from_date));
			$search_to_date = date('Y-m-d', strtotime($to_date));
			$from_date_full = $search_from_date ." ". $start_time;
			$to_date_full = $search_to_date ." ". $end_time;
			$extraFilter .= " AND (c.added_date >= '$from_date_full' AND c.added_date <= '$to_date_full') ";
		}	
		
		// FILTER OFFICE
		if(!empty($this->input->get('search_office_id')))
		{ 	
			$search = true;
			$search_office_id = $this->input->get('search_office_id');			
			if($search_office_id != "ALL" && !empty($search_office_id))
			{
				$extraFilter .= " AND c.pool_location='".$search_office_id."'";
			}
		}
		
		// FILTER EXEL
		$report_excel = false;
		if(!empty($this->input->get('excel')))
		{
			$search = true;
			$get_excel = $this->input->get('excel');			
			if($get_excel == 1)
			{
				$report_excel = true;
			}
		}
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['search_from_date'] = $search_from_date;
		$data['search_to_date'] = $search_to_date;
		$data['search_office'] = $search_office_id;
		$data['search'] = $search;
		
		// DROPDOWN FILTERS
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);			
		}
		
		$excelUrl = base_url()."reports_hr/dfr_pool_list?search_from_date=".$from_date."&search_to_date=".$to_date."&search_office_id=".$search_office_id."&excel=1";
		$data['excelURL'] = $excelUrl;
		
		$sqlSearch = "Select c.*, c.id as can_id, 
		             DATE_FORMAT(c.dob,'%m/%d/%Y') as d_o_b, 
					 DATE_FORMAT(c.doj,'%m/%d/%Y') as d_o_j, 
					 concat(s.fname, ' ', s.lname) as added_name 
					 from dfr_candidate_details c 
					 LEFT JOIN signin as s ON s.id = c.added_by 
					 WHERE  
					 c.r_id IS NULL $extraFilter  
					 ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R')";
		$querySearch = $this->Common_model->get_query_result_array($sqlSearch);
		$data['candidate_list'] = $querySearch;
		
		if($report_excel == true)
		{
			$this->generate_dfr_pool_report_xls($data);
		}
		
		$data["aside_template"] = "reports_hr/aside.php";
		$data["content_template"] = "reports_hr/dfr_pool_list.php";
		$data["content_js"] = "reports_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function generate_dfr_pool_report_xls($report_list)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$currOffice = $report_list['search_office'];
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('DFR Pool Report');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:H1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Candidate Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Phone");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Email");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Experience");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Added By");
				
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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "DFR POOL REPORTS");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$sl=0;
		foreach($report_list['candidate_list'] as $token)
		{
			$sl++;
			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['pool_location']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['fname']." ".$token['lname']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['phone']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['email']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['total_work_exp']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('d M, Y', strtotime($token['added_date'])));			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c,  $token['added_name']);			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DFR_Pool_'.$currOffice.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	
	
	//===== SIGNIN USER PHASE =======================//
	public function display_user_phase($phaseid="", $type="")
	{
		$phaseName = ""; 
		$phaseArr = array(
			'1' => "Hiring",
			'2' => "Training",
			'3' => "Nesting",
			'4' => "Production",
			'5' => "BENCH-PAID",
			'6' => "BENCH-UNPAID",
			'7' => "Recurisve Training",
		);
		foreach($phaseArr as $key => $value){
		  if($key == $phaseid){  $phaseName = $value; }
		}
		if($type == 'array'){ 
			return $phaseArr; 
		} else {
			return $phaseName;
		}		
	}
	 
    public function attendance()
    {
	
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
			//////////////////////////////////
						
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "reports_hr/att_main.php";
			    
				$data['user_list'] =array();
				
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				$client_id = "";
				$site_id = "";
				$office_id = "";
				$dept_id = "";
				$sdValue="";
				$data['error']="";
					
				
				if($office_id=="")  $office_id=$ses_office_id;
				
				if($this->input->post('exportReports')=='Export As Excel')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						
						$office_id = $this->input->post('office_id');
						if($office_id=="")  $office_id=$ses_office_id;
						
						$dept_id = $this->input->post('dept_id');
						if($dept_id=="")  $dept_id=$ses_dept_id;
						
						$sdValue = $this->input->post('sub_dept_id');
											
						$filterArray = array(
									"start_date" => $start_date,
									"end_date" => $end_date,
									"client_id" => $client_id,
									"office_id" => $office_id,
									"site_id" => $site_id,
									"filter_key" => $filter_key,
									"user_site_id"=> $user_site_id,
									"dept_id"=> $dept_id,
									"sub_dept_id"=> $sdValue,
							 ); 
								 
						if($filter_key!="" ){
								
							switch($filter_key){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									break;
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									break;
								case 'Process':
									$filter_value = $this->input->post('process_id');
									
									break;
								case 'Disposition':
									$filter_value = $this->input->post('disp_id');
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									break;
									
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									
								break;
						
							}
							if($filter_value=="") $filter_value = $this->input->post('filter_value');
						}
						
						$filterArray["filter_value"]=$filter_value;
						
					  
					  
					  //if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;	
					  if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					  else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"] = $current_user;
					  else $filterArray["assigned_to"]="";	
								 
					 $fullArr = $this->reports_model->get_user_list_report($filterArray);
					
					 //echo "<pre>" .print_r($fullArr, 1) ."</pre>"; die();
					
					if($fullArr!=null){
					
						//////////LOG////////
					
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download Attendance Report with ". $all_params;
						
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
						$this->createExcelFile($fullArr,$filterArray);
					
					}else{
						$data['error']="Not found any records";
					}
					
				}
				
				
				$data['client_list'] = $this->Common_model->get_client_list();			

				
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if($is_global_access==1 || get_dept_folder()=="rta"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}	

				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					if($dept_id=="ALL" || $dept_id=="") $data['sub_department_list'] = array();
					else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
				}
				
				
				
				
							
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
				
			
			
	   }
	   
    }
		
	private function createExcelFile($data,$fArray,$isLoginTime='N')
	{
		
		
		$filter_key =$fArray['filter_key'];
		
		$_atitle="";
		
		if($filter_key!="" && $filter_key!="OfflineList"){
		
			$filter_value =$fArray['filter_value'];
			
			switch($filter_key){
				case 'Site':
					
					$qSql="Select name as value from  site where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					break;
				case 'Agent':
					$_atitle = " - Agent-'".$filter_value."'";
					break;
				case 'Process':
					
					$qSql="Select name as value from  process where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					
					break;
				case 'Role':
				
					$qSql="Select name as value from  role where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					
					break;	
				case 'AOF':
				
					$qSql="Select CONCAT(fname,' ' ,lname) as value from  signin where id='$filter_value'";
					$_atitle = " - All Agents of ".$this->Common_model->get_single_value($qSql);				
					break;	
									
			}	
		}
		
				
		$start_date =$fArray['start_date'];
		$end_date =$fArray['end_date'];
		
		$title="Attendance From ".$start_date." To ".$end_date.$_atitle. " (All Time is in 'User Local Time')";
		
		$start_date =str_replace("/","-",$start_date);
		$end_date =str_replace("/","-",$end_date);
		
		//$process =$fArray['process'];	
		
		$fn="attendance-".$start_date."-".$end_date."".$_atitle.".xls";
		$filename = "./assets/reports/".$fn;
		
		$sht_title=$start_date." To ".$end_date." ";
		
		$default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb'=>'000000')
		);

		$style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFBCB2'),
			),
			'font' => array(
				'bold' => true,
				'size' => 11,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_p = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'68A368'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_l = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFFF00'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_trm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF0000'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_ptrm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF817F'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		
		$style_syslog = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'9ec2ff'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_gray = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'808080'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_def = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_def_left = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'size' => 10,
			)
		);
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
						
		//$letters = range('A', 'Z');
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}

		//print_r($letters);
		// start and end are seconds, so I convert it to days 
		
					
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$cell='A2';
		if($isLoginTime=="Y"){
			$cell='A2:A3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('B2', 'Fusion Id');
		$cell='B2';
		if($isLoginTime=="Y"){
			$cell='B2:B3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('C2', 'Site Id');
		$cell='C2';
		if($isLoginTime=="Y"){
			$cell='C2:C3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('D2', 'NAME');
		$cell='D2';
		if($isLoginTime=="Y"){
			$cell='D2:D3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('E2', 'Dept');
		$cell='E2';
		if($isLoginTime=="Y"){
			$cell='E2:E3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('F2', 'Designation');
		$cell='F2';
		if($isLoginTime=="Y"){
			$cell='F2:F3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$this->excel->getActiveSheet()->setCellValue('G2', 'DOJ');
		$cell='G2';
		if($isLoginTime=="Y"){
			$cell='G2:G3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$cell='H2';
		$this->excel->getActiveSheet()->setCellValue('H2', 'Location');
		if($isLoginTime=="Y"){
			$cell='H2:H3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='I2';
		$this->excel->getActiveSheet()->setCellValue('I2', 'Client');
		if($isLoginTime=="Y"){
			$cell='I2:I3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='J2';
		$this->excel->getActiveSheet()->setCellValue('J2', 'Process');
		if($isLoginTime=="Y"){
			$cell='J2:J3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='K2';
		$this->excel->getActiveSheet()->setCellValue('K2', 'L1 Supervisor');
		
		if($isLoginTime=="Y"){
			$cell='K2:K3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='L2';
		$this->excel->getActiveSheet()->setCellValue('L2', 'Status');
		
		if($isLoginTime=="Y"){
			$cell='L2:L3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='M2';
		$this->excel->getActiveSheet()->setCellValue('M2', 'Phase');
		
		if($isLoginTime=="Y"){
			$cell='M2:M3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		/*
		
		$start = strtotime($start_date);
		$end = strtotime($end_date);
		$diff = ($end - $start) / 86400; 
		$j=4;
		
		for ($i = 0; $i <= $diff; $i++) {
			$date = $start + ($i * 86400);
			$cDate= date('Y-m-d', $date);
			$cell=$letters[$j++]."2";
			$this->excel->getActiveSheet()->setCellValue($cell, $cDate);
		}
		*/
		//$this->excel->getActiveSheet()->getStyle('C2:'.$cell)->applyFromArray( $default_border ); // give style to header
 				
		if($isLoginTime=="Y") $r=3;
		else $r=2;
				
		$j=-1;
		$k=0;
		
		
		$allRowDone=false;
		$isFirst=true;
		
		$pevDate="";
		
		$cnt=1;
		
		foreach($data as $row)
		{
			$rdate=$row['rDate'];
			
			if($isFirst==false && $rdate!=$pevDate) $allRowDone=true;
			
			if($rdate!=$pevDate){
				
				if($isLoginTime=="Y"){ 
					$j+=8;
					$r=3;
				}else{
					//$j++;
					$j+=2;
					$r=3;
				}
			}
			
			$isFirst=false;
			
			if($allRowDone==false) $j = -1;
						
			$r++;
			
			$pevDate=$rdate;
			
			$disposition=$row['disposition'];
			$office_id = $row['office_id'];
			$role_id=$row['role_id'];
			
			$logged_in_hours = $row['logged_in_hours'];
			$logged_in_hours_local = $row['logged_in_hours_local'];
			
			$work_time=$row['logged_in_sec'];
			$work_time_local=$row['logged_in_sec_local'];
			
			$bg_style=$style_def;
			$bg_style_est=$style_def;
			$bg_style_local=$style_def;
			
			$att="";
			
			$isProperLogout = 'Y';
			
			$todayLoginTime = $row['todayLoginTime'] ;
			$todayLoginTime_local= ConvServerToLocalAny($todayLoginTime,$office_id);
			
			$is_logged_in = $row['is_logged_in'];
								
			$flogin_time = $row['flogin_time'];
			$flogin_time_local = $row['flogin_time_local'];
			
			$logout_time=$row['logout_time'];
			$logout_time_local=$row['logout_time_local'];
			
			$tBrkTime=$row['tBrkTime'];
			$tBrkTimeLocal=$row['tBrkTimeLocal'];
			
			$ldBrkTime=$row['ldBrkTime'];
			$ldBrkTimeLocal=$row['ldBrkTimeLocal'];
			
			$total_break=$tBrkTime+$ldBrkTime;
			$total_break_local=$tBrkTimeLocal+$ldBrkTimeLocal;
				
			$comments = $row['comments'];
			
						
			$omuid= $row['omuid'];
			$xpoid= $row['xpoid'];
			if($xpoid!="") $omuid = $xpoid;
			
			
			$leave_dtl = "";
			$leave_status = $row['leave_status'];
			if($row['leave_type'] !=""){
				if( $leave_status == '0') $leave_dtl = $row['leave_type'] . " Applied";
				else if( $leave_status == '1') $leave_dtl = $row['leave_type'] . " Approved";
				else if( $leave_status == '2') $leave_dtl = $row['leave_type'] . " Reject";
			}
			
			if($work_time == 0){
				$net_work_time="";
				$total_break = "";
				$tBrkTime = "";
				$ldBrkTime = "";
			}else{
				
				$net_work_time=gmdate('H:i:s',$work_time);
				$total_break = gmdate('H:i:s',$total_break);
				$tBrkTime = gmdate('H:i:s',$tBrkTime);
				$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
				
			}
			
			if($work_time_local==0){
				$net_work_time_local="";
				$total_break_local="";
				$tBrkTimeLocal = "";
				$ldBrkTimeLocal = "";
			
			}else{
				
				$net_work_time_local=gmdate('H:i:s',$work_time_local);
								
				$total_break_local = gmdate('H:i:s',$total_break_local);
				$tBrkTimeLocal = gmdate('H:i:s',$tBrkTimeLocal);
				$ldBrkTimeLocal = gmdate('H:i:s',$ldBrkTimeLocal);
			}
			
			
			/*
			
			if($is_logged_in == '1'){
				
				$todayLoginArray = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$flogin_time_local = $todayLoginTime_local;
					
					$disposition="online";
					
					$net_work_time="";
					$net_work_time_local="";
					
					$total_break = "";
					$total_break_local="";
					$tBrkTime = "";
					$tBrkTimeLocal = "";
					$ldBrkTime = "";
					$ldBrkTimeLocal = "";
					$logout_time="";
					$logout_time_local="";
				}
			}
			
			*/
			
					
			if($is_logged_in == '1'){
				$todayLoginArray = explode(" ",$todayLoginTime);
				$todayLoginTime_local = ConvServerToLocalAny($todayLoginTime,$office_id);
				$todayLoginArray_local = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$disposition="online";
					$net_work_time="";
					$total_break = "";
					$tBrkTime = "";
					$ldBrkTime = "";
					$logout_time="";
				}
				
				if($rdate == $todayLoginArray_local[0]){
						$flogin_time_local=$todayLoginTime_local;
						$disposition="online";
						$net_work_time_local="";
						$total_break_local="";
						$tBrkTimeLocal = "";
						$ldBrkTimeLocal = "";
						$logout_time_local="";
				}
			}

			$disposition_est =  $disposition;
			$disposition_local =  $disposition;
			
			if($logged_in_hours!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_est =  $disposition . " &  P";
						$bg_style_est=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_est =  "P & ". $disposition;
						$bg_style_est=$style_ptrm;
					}else{
						$disposition_est =  "P";
						$bg_style_est=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_est=="LI")$bg_style_est=$style_p;
				else if($disposition_est=="TERM" || $disposition_est=="X")$bg_style_est=$style_trm;
				else if($disposition_est!="Absent") $bg_style_est=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_est = ""; 
					$bg_style_est=$style_gray;
				}else $disposition_est =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_est = $leave_dtl;
			
			
			if($logged_in_hours_local!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_local =  $disposition . " &  P";
						$bg_style_local=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_local =  "P & ". $disposition;
						$bg_style_local=$style_ptrm;
					}else{
						$disposition_local =  "P";
						$bg_style_local=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_local=="LI")$bg_style_local=$style_p;
				else if($disposition_local=="TERM" || $disposition_local=="X")$bg_style_local=$style_trm;
				else if($disposition_local!="Absent") $bg_style_local=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_local = ""; 
					$bg_style_local=$style_gray;
				}else $disposition_local =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_local = $leave_dtl;
			
			/////////////////////////////////////////
			$SkipRole="-#82#112#221#";
			$SkipLocation="-#ELS#JAM#";
			if( strpos($SkipRole,"#".$role_id."#") != false && strpos($SkipLocation,"#".$office_id."#") !=false){
				if($disposition_local=="Absent") $disposition_local = "LI";
				if($disposition_est=="Absent") $disposition_est = "LI";
			}
			
			if($isLoginTime=="Y"){
				
				if($disposition_est!="" && $flogin_time=="") $flogin_time = $disposition_est;
				if($disposition_local!="" && $flogin_time_local=="") $flogin_time_local = $disposition_local;
				
				if($disposition_est!="" && $logout_time=="") $logout_time = $disposition_est;
				if($disposition_local!="" && $logout_time_local=="") $logout_time_local = $disposition_local;
				
			}
			
			
			
			////////// For System Logout /////////////////////
			if($row['logout_by']== "0" && $logged_in_hours!="0" ){
				
				//$net_work_time=0;
				//$net_work_time_local = 0;
				//$logout_time="";
				//$logout_time_local="";
				$isProperLogout = 'N';
				
				$comments = "System Logout";
				$bg_style_est =  $style_syslog;
			    $bg_style_local = $style_syslog;
			}
			
			
			
			if($allRowDone==false){
			
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['fusion_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['omuid']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$fullname=$row['fname'] . " ". $row['lname'];
				$this->excel->getActiveSheet()->setCellValue($cell, $row['omuid']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['dept_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['role_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
								
				$doj=$row['doj'];
				if($doj=="") $doj="NA";
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $doj);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['office_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['client_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['process_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['asign_tl']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_status($row['status']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_phase($row['phase']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+7)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+2)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+2)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+1)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
												
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
				}
				
			}else{
								
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+7)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+2)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+2)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+1)]."2";
					
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
				}
				
			
			}
	
		}
		
		
		$cell=$letters[$j]."1";
		$this->excel->getActiveSheet()->mergeCells('A1:'.$cell);
		//set aligment to center for that merged cell (A1 to N1)
		//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

		//$objWriter->save($filename);
	}
	
	
	public function attn_logintime()
	{
		
		if(check_logged_in())
        {
						
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
			
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "reports_hr/att_logintime.php";
			    
				$data['user_list'] =array();
				
				
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				
				$client_id="";
				$site_id="";
				$office_id="";
				$dept_id = "";
				if($dept_id=="")  $dept_id=$ses_dept_id;
				
				$sdValue="";
				
				$data['error']="";
				if($office_id=="")  $office_id=$ses_office_id;
				
				if($this->input->post('exportReports')=='Export As Excel')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						
						$office_id = $this->input->post('office_id');
						if($office_id=="")  $office_id=$ses_office_id;
						
						$dept_id = $this->input->post('dept_id');
						if($dept_id=="")  $dept_id=$ses_dept_id;
					
						$sdValue = $this->input->post('sub_dept_id');
					
						$filterArray = array(
								"start_date" => $start_date,
								"end_date" => $end_date,
								"client_id" => $client_id,
								"office_id" => $office_id,
								"site_id" => $site_id,
								"filter_key" => $filter_key,
								"user_site_id"=> $user_site_id,
								"dept_id"=> $dept_id,
								"sub_dept_id"=> $sdValue,
						); 
								 
						if($filter_key!="" ){
								
							switch($filter_key){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									break;
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									break;
								case 'Process':
									$filter_value = $this->input->post('process_id');
									
									break;
								case 'Disposition':
									$filter_value = $this->input->post('disp_id');
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									break;
									
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									
								break;
						
							}							
							
							if($filter_value=="") $filter_value = $this->input->post('filter_value');
							
						}
						
						$filterArray["filter_value"]=$filter_value;	
						
					  
					  //if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
					  if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					  else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
					  else $filterArray["assigned_to"]="";	
								 
					 $fullArr = $this->reports_model->get_user_list_report($filterArray);
					
					//print_r($fullArr);
					
					if($fullArr!=null){
					
						//////////LOG////////
					
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download Attendance & logged-in time Report with ". $all_params;
						
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
			
						$this->createExcelFile($fullArr,$filterArray,'Y');
						
					}else{
						$data['error']="Not found any records";
					}
				}
								
				$data['client_list'] = $this->Common_model->get_client_list();
								
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if($is_global_access==1 || get_dept_folder()=="rta"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
				
				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					if($dept_id=="ALL" || $dept_id=="") $data['sub_department_list'] = array();
					else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
				}
								
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
				
			
			
	   }
	   
	
	}
		
	public function summary()
	{
	
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$ses_dept_id=get_dept_id();
			$user_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "reports_hr/att_summary.php";
			    
				$data['department_list'] = $this->Common_model->get_department_list();	
				
				$data['client_list'] = $this->Common_model->get_client_list();
				
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				//$cond=" and id in(2,3,4,5,7,8)";
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
				//$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				if($is_global_access==1 || get_dept_folder()=="rta"){			
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
			
				
				$data['user_list'] =array();
				
					
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				
				$client_id="";
				$site_id="";
				$office_id="";
				$dept_id = "";
				
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
								
			
	   }
	   	
	}
	
	
	public function createAttnSummary()
	{
	
		$role_id= get_role_id();
		$current_user = get_user_id();
		$ses_dept_id=get_dept_id();
		
		//echo " xxxxx :: ". $current_user;
		//////////////////////////////////
		$user_site_id= get_user_site_id();
		//////////////////////////////////
		$user_office_id=get_user_office_id();
		
		$is_global_access=get_global_access();
		
		
		if($this->is_access_reports($role_id)){

			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			$client_id = $this->input->post('client_id');
			$site_id = $this->input->post('site_id');
			
			$office_id = $this->input->post('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			//$dept_id = $this->input->post('dept_id');
			//if($dept_id=="")  $dept_id=$ses_dept_id;
					
			$filter_key = $this->input->post('filter_key');
			$filter_value="";
			
			$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"client_id" => $client_id,
						"office_id" => $office_id,
						"site_id" => $site_id,
						"filter_key" => $filter_key,
						"user_site_id"=> $user_site_id,
				 ); 
					 
			if($filter_key!="" ){
					
				switch($filter_key){
					case 'Site':
						$filter_value = $this->input->post('site_id');
						break;
					case 'Agent':
						$filter_value = $this->input->post('agent_id');
						break;
					case 'Process':
						$filter_value = $this->input->post('process_id');
						
						break;
					case 'Role':
						$filter_value = $this->input->post('role_id');
						break;	
					case 'AOF':
						$filter_value = $this->input->post('assign_id');
						break;	
				}
								
				if($filter_value=="") $filter_value = $this->input->post('filter_value');
						
			}
			
			$filterArray["filter_value"]=$filter_value;	
			
			//print_r($filterArray);
			
			if($filter_key!="" && $filter_value==""){
				echo "ERROR";
			}else{
			
				//if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
				if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
				else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
				else $filterArray["assigned_to"]="";
		
				//print_r($filterArray);
							
				$file_path=$this->createExcelSummary($filterArray);
								
				//echo $file_path;
				
				if($file_path !="ERROR"){
					//////////LOG////////
			
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
				
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					$LogMSG="Download Attendance Summary Report with ". $all_params;	
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
					//////////
					
					echo $file_path;
					
				}else{
					echo "ERROR";
				}
			}
		}else{
				echo "SESSIONOUT";
		}
		
	}
	
	
	
	public function sendMonthlyAttnSummary()
	{
								
				$cDateYmd=CurrDate();
				$start_date=date('m-01-Y', strtotime($cDateYmd));
				//$end_date =date("m-d-Y",time());
				$end_date=date('m-d-Y',strtotime($cDateYmd.' -1 day'));	
				
				//echo $start_date . " >> ".$end_date ."<br>";
				/*
					$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"client_id" => $client_id,
						"office_id" => $office_id,
						"site_id" => $site_id,
						"filter_key" => $filter_key,
						"user_site_id"=> $user_site_id,
				 ); 
				 
				*/
				
				$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"client_id" => '1',
						"filter_key" => "",
						"assigned_to" => "",
						"user_site_id" => "",
						"filter_value" => "",
				 ); 
				 
				$file_month=strtolower(date('F-Y', strtotime($cDateYmd)));
				$file_name=$this->createExcelSummary($filterArray,'Y');
				
				//echo "\r\n". $file_name ."\r\n";
				
				if($file_name!="ERROR"){
				
					$file_path =FCPATH."temp_files/summary/".$file_name;
					
					//echo $file_path;
					
					$uid="";
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					
					$from_email="noreply.sox@fusionbposervices.com";
					$from_name="Fusion SOX";
					
					$ecc="";
					$ebody="Hi<br>Please check the attachment files.";
					$esubject="Test Email to Auto Send Attendance Summary Report.";
					
					$email_resp=false;
					
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject,$file_path,$from_email,$from_name);
					
					if($email_resp==true){
						unlink($file_path);
						
						//$LogMSG="successfully Sent Attendance Summary Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
						
					}else{
					
						$uid="";
						$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
						$ecc="";
						$ebody="Hi<br>Failure to send Attendance Summary Report.";
						$esubject="Failure to Send Attendance Summary Report.";
						
						// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
						//$LogMSG="successfully Sent Attendance Summary Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
					}
					
				}else{
										
					//$LogMSG="Error To Sent Attendance Summary Report of ".$file_month;	
					//log_message('FEMS', ' | '.$LogMSG );
					
					$uid="";
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					$ecc="";
					$ebody="Hi<br>Failure to Export Attendance Summary Report.";
					$esubject="Failure to Export Attendance Summary Report.";
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
				}
	}
	
	
	public function createExcelSummary($filterArr,$is_monthly='N')
	{
	
		try {
			$start_date =$filterArr['start_date'];
			$end_date =$filterArr['end_date'];
			//echo " >>>> " . $start_date . ">" . $end_date ."\r\n";			
			$filter_key="";
			$assigned_to="";
			$user_site_id="";
			$client_id="";
			
			if($is_monthly!="Y"){
						
				$filter_key =$filterArr['filter_key'];
				$assigned_to=$filterArr['assigned_to'];
				$user_site_id =$filterArr['user_site_id'];
				
			}
			
			$client_id=$filterArr['client_id'];
			
			//echo "<br>1." . $start_date . " > " .$end_date . " > ". $filter_key . " > ". $assigned_to ."<br>";

			$filter_value="";
			$_cnd="";
			$_atitle="";
			$site_cond="";
			
			if($filter_key!=""){
			
				$filter_value =$filterArr['filter_value'];
				
				switch($filter_key){
					case 'Site':
						$_cnd = " and site_id = '".$filter_value."'";
						$site_cond = " and id = '".$filter_value."'";
						
						$qSql="Select name as value from  site where id='$filter_value'";
						$_atitle = " - All Agents in ".$this->Common_model->get_single_value($qSql);
					
						break;
					case 'Agent':
						$_cnd = " and  (omuid = '".$filter_value."' OR fusion_id='".$filter_value."') ";
						$_atitle = " - Agent-'".$filter_value."'";
						
						break;
					case 'Process':
						if($filter_value !="0") $_cnd = " and 	process_id = '".$filter_value."'";
						
						$qSql="Select name as value from  process where id='$filter_value'";
						$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					
						break;
						
					/*
					case 'Role':
						$_cnd = " and 	role_id = '".$filter_value."'";
						
						$qSql="Select name as value from  role where id='$filter_value'";
						$_atitle = " - ".$this->Common_model->get_single_value($qSql);
						break;	
					*/
					
					case 'AOF':
						$_cnd = " and assigned_to = '".$filter_value."'";
						$qSql="Select CONCAT(fname,' ' ,lname) as value from  signin where id='$filter_value'";
						$_atitle = " - All Agents of ".$this->Common_model->get_single_value($qSql);
						break;	
				}	
			}
			
			$client_name="";
			if($client_id!=="" && $client_id!="ALL"){
				$_cnd .= " and client_id = '".$client_id."'";
				$client_name="-".$this->Common_model->get_single_value("Select shname as value from  client where id='$client_id'");
				
			}
						
			$_roleCnd="";
			
			if($filter_key=="Role") $_roleCnd = " and role_id = '".$filter_value."'";
			else $_roleCnd = " and role_id = '3'";
			
			if($is_monthly!="Y"){
				if(get_role_id()>1 && get_role_id()!=6){
					if($user_site_id!="" && $user_site_id!="0" && $user_site_id!="ALL" ) $_cnd .= " and site_id = '".$user_site_id."'";
				}
			}
			
			if($assigned_to!="" && $assigned_to!="ALL" ) $_cnd .= " and assigned_to = '".$assigned_to."'";
			
			//////////////////////
			
			//echo $_cnd ."<br>" .$_roleCnd ."<br>";
			
			$stDate=mmddyy2mysql($start_date);
			$enDate=mmddyy2mysql($end_date);
			
			if($is_monthly!="Y") $fn="absenteeism_summary".$client_name.'-'.$stDate."-".$enDate.$_atitle.".xlsx";
			else{
				$file_name="absenteeism_summary".$client_name.'_'.strtolower(date('F', strtotime($stDate)));
				$fn=$file_name."_".$stDate."_".$enDate.".xlsx";
			}
			
			//echo $fn ."<br>";

			//$filename =APPPATH."temp_files/summary/".$fn;
			$filename =FCPATH."temp_files/summary/".$fn;
			//echo $filename;
			 
			
			$default_border = array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'1006A3')
			);

			$style_header = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'E1E0F7'),
				),
				'font' => array(
					'bold' => true,
					'size' => 11,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_sum = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'00b0f0'),
				),
				'font' => array(
					'size' => 10,
					'bold' => true,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_p = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'68A368'),
				),
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_l = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFF00'),
				),
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			
			$style_def = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_trm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF0000'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
			
		
		$style_syslog = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFBCB2'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
				
		$style_ptrm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFB3B2'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_gray = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'808080'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
			$style_def_left = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
				
			//$letters = range('A', 'Z');
			
			$letters = array(); 
			$k=0;
			 for ($i = 'A'; $i !== 'ZZ'; $i++){
				$letters[$k++]=$i;
			}
		
		////////////////////////////////
			
		//$currDate=CurrDate();
		//$currDate=date('Y-m-d',strtotime($currDate.' -1 day'));			
		//echo "Current Date : ".CurrMySqlDate() ."\r\n";
		//echo "report On Date : ".$currDate ."\r\n";
		
		$todayDate=CurrDate();
		
		$stDate=mmddyy2mysql($start_date);
		$enDate=mmddyy2mysql($end_date);
		
		//echo "<br>2. ".$stDate . ">" . $enDate ."\r\n";
		
		$dayDiff=dateDiffCount($stDate,$enDate);
				
		//$qSql="SELECT * FROM site where is_active=1 $site_cond order by name";
		
		if($_cnd=="" ) $qSql="SELECT * FROM site where is_active=1 order by name";
		else $qSql="SELECT * FROM site where id in (SELECT DISTINCT site_id from signin where status=1 $_cnd) order by name";
					
		$site_list=$this->Common_model->get_query_result_array($qSql);
		
		$shCnt=0;
		
		foreach($site_list as $sRow){
			
			$site_id=$sRow['id'];	
			$site_name=$sRow['name'];		
				
			//$qSql="SELECT * FROM process  where is_active=1 order by name";
			
			$qSql="SELECT * from process where id in (SELECT DISTINCT process_id FROM `signin` where site_id='$site_id') order by name";			
			$process_list=$this->Common_model->get_query_result_array($qSql);
			
			//$count_arr = array();
			//$att_arr = array();
						
			foreach($process_list as $row){
				
			//	$pro_arr = array();
				
				$process_id=$row['id'];	
				$process_name=$row['name'];								
				
				//echo $process_name. " (". $process_id .")\r\n";
				//////////
				
				$sht_title=$site_name . " - " .$process_name;
				
				if($filter_key=="Site") $title=$process_name."".$_atitle;
				else $title=$site_name." - ".$process_name ."".$_atitle;
												
				if($shCnt > 0) $this->excel->createSheet();
				$this->excel->setActiveSheetIndex($shCnt);
				
				//echo $shCnt;
				
				//activate worksheet number 1
				
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				//merge cell A1 until D1
				$this->excel->getActiveSheet()->mergeCells('A1:E1');
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'Date');
				$this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('B2', 'Schdld Agents');
				$this->excel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('C2', 'Present');
				$this->excel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('D2', 'Absent');
				$this->excel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('E2', 'Absenteeism%');
				$this->excel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
				
				////////////////////////////
				
				$stTime=strtotime($stDate);
				
				$currDate= date('Y-m-d', $stTime);
				
				//echo "<br>3. ".$dayDiff." >> ".$stTime . ">" . $currDate ."\r\n";
								
				$r=3;
				
				$sch_total=0;
				$prsnt_total=0;
				$abs_total=0;
				
				for ($i = 1; $i <= $dayDiff; $i++){
					
					$j=-1;
					
				//	$arr = array();
					
					$currDate= date('Y-m-d', $stTime);
					
					if($currDate>=$todayDate) break;
					
					//echo $currDate  ." == " . $enDate . "\r\n";
					$stTime = strtotime($currDate .' +1 day');
					$currDay=strtolower(date('D', strtotime($currDate)));
					
					$fielsIn=$currDay."_in";
					$fielsOut=$currDay."_out";
					
					if(date('D', strtotime($currDate)) == "Mon") $shMonDate=$currDate;
					else $shMonDate=date('Y-m-d',strtotime($currDate.' -1 Monday'));
					if(date('D', strtotime($currDate)) == "Sun") $shSunDate=$currDate;
					else $shSunDate=date('Y-m-d',strtotime($currDate.' +1 Sunday'));
					
					
					$prv_term_cond=" (Select user_id from terminate_users where cast(terms_date as date)<'$currDate'  OR rejon_date>='$currDate'  ) and is_term_complete = 'Y' ";
					
					//Schedule
					//$qSql="Select count(a.id) as value from user_shift_schedule a, signin b where start_date='$shMonDate' and end_date='$shSunDate' and a.user_id=b.id and status=1 and process_id='$process_id' and $fielsIn not in ('OFF','RO','LOA','PL') and $fielsOut not in ('OFF','RO','LOA','PL') ";
					
					$qSql="Select count(a.id) as value from user_shift_schedule a, signin b where start_date='$shMonDate' and end_date='$shSunDate' and a.user_id=b.id and user_id not in $prv_term_cond and process_id='$process_id' and site_id='$site_id' and TIME($fielsIn)>0 and TIME($fielsOut)>0 $_roleCnd $_cnd";
					
					//echo $qSql ."\r\n";
					
					$sch_count=$this->Common_model->get_single_value($qSql);
					
										
					//$qSql="Select count(a.id) as value from logged_in_details a, signin b where cast(login_time as date) = '$currDate' and cast(logout_time as date) >= '$currDate' and a.user_id=b.id and status=1 and process_id='$process_id' and role_id >1";
					
					//$qSql="Select count(user_id) as value from (select distinct user_id from logged_in_details where cast(login_time as date) = '$currDate' and cast(logout_time as date) >= '$currDate') a, signin b where a.user_id=b.id and status=1 and process_id='$process_id' and site_id='$site_id' $_roleCnd $_cnd";
					
					$qSql="Select count(user_id) as value from (select distinct user_id from logged_in_details where cast(login_time as date) = '$currDate' and cast(logout_time as date) >= '$currDate') a, signin b where a.user_id=b.id and user_id not in $prv_term_cond and process_id='$process_id' and site_id='$site_id' $_roleCnd $_cnd";
										
					//echo $qSql ."\r\n";
					
					$prsnt_count=$this->Common_model->get_single_value($qSql);
					
					//$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <= '$currDate' and end_date >= '$currDate' and event_master_id in (6)) a, signin b where a.user_id=b.id and status=1 and process_id='$process_id'  and site_id='$site_id' $_roleCnd $_cnd";
					
					$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <= '$currDate' and end_date >= '$currDate' and event_master_id in (6)) a, signin b where a.user_id=b.id and user_id not in $prv_term_cond  and process_id='$process_id'  and site_id='$site_id' $_roleCnd $_cnd";
					
					$li_count=$this->Common_model->get_single_value($qSql);
					$prsnt_count= $prsnt_count+$li_count;
					
					
					
					//$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <='$currDate' and end_date >='$currDate' and event_master_id in (2,3)) a, signin b where a.user_id=b.id and status=1 and process_id='$process_id' and site_id='$site_id' and user_id not in (Select distinct user_id from logged_in_details where (cast(login_time as date) = '".$currDate."' and cast(login_time as date) >= '".$currDate."')) $_roleCnd $_cnd";
					
					$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <='$currDate' and end_date >='$currDate' and event_master_id in (2,3)) a, signin b where a.user_id=b.id and user_id not in $prv_term_cond and process_id='$process_id' and site_id='$site_id' and user_id not in (Select distinct user_id from logged_in_details where (cast(login_time as date) = '".$currDate."' and cast(login_time as date) >= '".$currDate."')) $_roleCnd $_cnd";
					
					//echo $qSql ."\r\n";
					
					$abs_count=$this->Common_model->get_single_value($qSql);
					
					if($sch_count==0)$abs_per=0;
					else $abs_per=($abs_count/$sch_count);
					
					//echo "Schdld Agents : ".$sch_count ."\r\n";
					//echo "Present Agents : ".$prsnt_count ."\r\n";
					//echo "Absent Agents : ".$abs_count ."\r\n";
					//echo "Absenteeism% : ".$abs_per ."%\r\n\r\n";
					
					//$arr["rDate"] = $currDate;
					//$arr["sch_count"] = $sch_count;
					//$arr["prsnt_count"] = $prsnt_count;
					//$arr["abs_count"] = $abs_count;
					//$arr["abs_per"] = $abs_per;
					//$pro_arr[] = $arr;
					
					////////
					
						$sch_total +=$sch_count;
						$prsnt_total +=$prsnt_count;
						$abs_total +=$abs_count;
				
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						$this->excel->getActiveSheet()->setCellValue($cell, $currDate);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						
						$this->excel->getActiveSheet()->setCellValue($cell, $sch_count);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $prsnt_count);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_count);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_per);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$r++;
					
					////////
					
					} //i date

						
						$abs_per_total=0;
						if($sch_total==0)$abs_per_total=0;
						else $abs_per_total=($abs_total/$sch_total);
					
						$j=-1;
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						$this->excel->getActiveSheet()->setCellValue($cell, "MTD");
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						
						$this->excel->getActiveSheet()->setCellValue($cell, $sch_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $prsnt_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_per_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$r++;
						
					
					//$count_arr[$process_name] = $pro_arr;
					$_cond= " and process_id='$process_id' and site_id='$site_id' $_roleCnd ";
					//echo $_cond ." \r\n";
					
					$all_att=array();
					
					//$att_arr[$process_name] = $this->reports_model->get_user_list_report($filterArr, $_cond);
					$all_att= $this->reports_model->get_user_list_report($filterArr, $_cond,'Y');
					
					//print_r($all_att);
					
					//////////// ATT////
						
						$r++;
						
						//$cell=$letters[++$j].$r;
						//$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
									
						$this->excel->getActiveSheet()->setCellValue('A'.$r, 'SLNo');
						$cell='A'.$r.":".'A'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						$this->excel->getActiveSheet()->setCellValue('B'.$r, 'OM ID/XPOID');
						$cell='B'.$r.":".'B'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
											
						$this->excel->getActiveSheet()->setCellValue('C'.$r, 'NAME');
						$cell='C'.$r.":".'C'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						$this->excel->getActiveSheet()->setCellValue('D'.$r, 'Role');
						$cell='D'.$r.":".'D'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						$this->excel->getActiveSheet()->setCellValue('E'.$r, 'DOJ');
						$cell='E'.$r.":".'E'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						/*
						$this->excel->getActiveSheet()->setCellValue('F'.$r, 'Site');
						$cell='F'.$r.":".'F'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
											
						$this->excel->getActiveSheet()->setCellValue('G'.$r, 'Process');
						$cell='G'.$r.":".'G'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						*/
						
						$r++;
						$stR=$r;
						
						$j=-1;
						$k=0;
												
						$allRowDone=false;
						$isFirst=true;
						
						$pevDate="";
						
						$cnt=1;
						
						$has_data=false;
						
							foreach($all_att as $row)
							{
								$has_data=true;
								$rdate=$row['rDate'];
								
								if($isFirst==false && $rdate!=$pevDate) $allRowDone=true;
								
								if($rdate!=$pevDate){
									$r=$stR;
									$j+=2;
								}
								
								$r++;
								
								
								$isFirst=false;
								
								if($allRowDone==false){
									$j=-1;
								}
															
								$pevDate=$rdate;
								
								$doj=$row['doj'];
								if($doj=="") $doj="NA";
									
								$disposition=$row['disposition'];
								$logged_in_hours = $row['logged_in_hours'];
								$bg_style=$style_def;
								
								$att="";
								if($logged_in_hours!="0"){
									$att = 'P'; 
									if($disposition=="TERM"){
										$att .=" & TERM";
										$bg_style=$style_ptrm;
									}else $bg_style=$style_p;
									
								}else if($disposition!=""){
									$att = $disposition;
									if($att=="LI")$bg_style=$style_p;
									else if($att=="TERM" || $att=="X")$bg_style=$style_trm;
									else if($att!="Absent") $bg_style=$style_l;
									
								}else{
									////else if($att=="-")$bg_style=$style_p;
									if($row['rDate']<$row['doj']){
										$bg_style=$style_gray;
										$att = ''; 
									}else $att = 'Absent'; 
								}
								
								
								$ac_sch="-";
								$sch_in=trim($row['sch_in']);
								$sch_out=trim($row['sch_out']);
								
								if($sch_in =="") $ac_sch="-";
								else if (($timestamp = strtotime($sch_in)) !== false) $ac_sch=$sch_in ." - ".$sch_out;
								else $ac_sch=$sch_in;
								
								if($allRowDone==false){
								
									$cell=$letters[++$j].$r;
									
									$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$this->excel->getActiveSheet()->setCellValue($cell, $row['omuid']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$fullname=$row['fname'] . " ". $row['lname'];
									$this->excel->getActiveSheet()->setCellValue($cell, $fullname);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$this->excel->getActiveSheet()->setCellValue($cell, $row['role_name']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
										
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$this->excel->getActiveSheet()->setCellValue($cell, $doj);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
									
									/*
									$cell=$letters[++$j].$r;
									$this->excel->getActiveSheet()->setCellValue($cell, $row['site_name']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
																	
									$cell=$letters[++$j].$r;
									$this->excel->getActiveSheet()->setCellValue($cell, $row['process_name']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
									*/
									
									$cell=$letters[++$j].($stR-1);
									$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
									$cell=$letters[$j].($stR-1) .":". $letters[($j+1)].($stR-1);
									$this->excel->getActiveSheet()->mergeCells($cell);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Schedule");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j+1].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Status");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									
									$cell=$letters[$j].$r;
									$this->excel->getActiveSheet()->setCellValue($cell, $ac_sch);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
									$cell=$letters[($j+1)].$r;
									//echo $cell ." >> ";
									$this->excel->getActiveSheet()->setCellValue($cell, $att);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
								}else{
																
									$cell=$letters[$j].($stR-1);
									$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
									$cell=$letters[$j].($stR-1) .":". $letters[($j+1)].($stR-1);						
									$this->excel->getActiveSheet()->mergeCells($cell);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Schedule");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j+1].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Status");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
																	
									$cell=$letters[$j].$r;
									//echo $cell ." - ";								
									$this->excel->getActiveSheet()->setCellValue($cell, $ac_sch);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
									$cell=$letters[($j+1)].$r;
									//echo $cell." >> ";
									$this->excel->getActiveSheet()->setCellValue($cell, $att);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
								}
						
							}
							
							if($has_data==false){
								$this->excel->removeSheetByIndex($shCnt);
								if($shCnt==0) $this->excel->createSheet();
							}else{
								$shCnt++;
							}
							
						//////////////////ATT//
					
					
					
					
										
				} // process
				
			} // site
			
			
			//echo "<br>\r\n\r\n <br>";
											
			//	header('Content-Type: application/vnd.ms-excel'); //mime type
			//	header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
			//	header('Cache-Control: max-age=0'); //no cache
						 
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			
			//$objWriter = new PHPExcel_Writer_Excel5($this->excel);
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
			$objWriter->save($filename);
			
			//ob_end_clean();
			//force user to download the Excel file without writing it to server's HD
			//$objWriter->save('php://output');
			
			return $fn;
			
		}catch (Exception $e){
			//echo 'Caught exception: ',  $e->getMessage(), "<br/><br/>";
			return "ERROR";
			
		}
	
	}
	
	
	public function downloadFile()
	{		
		$this->load->helper('download');
		
		$fn = $this->input->get('fn');
		$filename =FCPATH."temp_files/summary/".$fn;
		$data = file_get_contents($filename); 
		force_download($fn, $data); 
		
	}

	
	
	
	
	/*================================ ATTENDANCE ROASTER ===============================================================================*/
	
	
	public function attn_roaster()
    {
	
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
			//////////////////////////////////
						
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "reports_hr/att_main.php";
			    
				$data['user_list'] =array();
				
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				$client_id = "";
				$site_id = "";
				$office_id = "";
				$dept_id = "";
				$sdValue="";
				$data['error']="";
					
				
				if($office_id=="")  $office_id=$ses_office_id;
				
				if($this->input->post('exportReports')=='Export As Excel')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						
						$office_id = $this->input->post('office_id');
						if($office_id=="")  $office_id=$ses_office_id;
						
						$dept_id = $this->input->post('dept_id');
						if($dept_id=="")  $dept_id=$ses_dept_id;
						
						$sdValue = $this->input->post('sub_dept_id');
											
						$filterArray = array(
									"start_date" => $start_date,
									"end_date" => $end_date,
									"client_id" => $client_id,
									"office_id" => $office_id,
									"site_id" => $site_id,
									"filter_key" => $filter_key,
									"user_site_id"=> $user_site_id,
									"dept_id"=> $dept_id,
									"sub_dept_id"=> $sdValue,
							 ); 
								 
						if($filter_key!="" ){
								
							switch($filter_key){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									break;
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									break;
								case 'Process':
									$filter_value = $this->input->post('process_id');
									
									break;
								case 'Disposition':
									$filter_value = $this->input->post('disp_id');
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									break;
									
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									
								break;
						
							}
							if($filter_value=="") $filter_value = $this->input->post('filter_value');
						}
						
						$filterArray["filter_value"]=$filter_value;
						
					  
					  
					  //if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;	
					  if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					  else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"] = $current_user;
					  else $filterArray["assigned_to"]="";	
								 
					 $fullArr = $this->reports_model->get_user_list_report($filterArray, "", "Y","N");
					
					//print_r($fullArr);
					
					if($fullArr!=null){
					
						//////////LOG////////
					
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download Attendance Report with ". $all_params;
						
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
						//echo "<pre>" .print_r($fullArr,true) ."<pre>"; die();
						
						$this->createExcelFileRoaster($fullArr,$filterArray);
					
					}else{
						$data['error']="Not found any records";
					}
					
				}
				
				
				$data['client_list'] = $this->Common_model->get_client_list();			

				
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if($is_global_access==1 || get_dept_folder()=="rta"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}	

				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					if($dept_id=="ALL" || $dept_id=="") $data['sub_department_list'] = array();
					else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
				}
				
				
				
				
							
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
				
			
			
	   }
	   
    }
		
	private function createExcelFileRoaster($data,$fArray,$isLoginTime='N')
	{
		
		//echo "<pre>" .print_r($data,true) ."<pre>"; die();
		$filter_key =$fArray['filter_key'];
		
		$_atitle="";
		
		if($filter_key!="" && $filter_key!="OfflineList"){
		
			$filter_value =$fArray['filter_value'];
			
			switch($filter_key){
				case 'Site':
					
					$qSql="Select name as value from  site where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					break;
				case 'Agent':
					$_atitle = " - Agent-'".$filter_value."'";
					break;
				case 'Process':
					
					$qSql="Select name as value from  process where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					
					break;
				case 'Role':
				
					$qSql="Select name as value from  role where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					
					break;	
				case 'AOF':
				
					$qSql="Select CONCAT(fname,' ' ,lname) as value from  signin where id='$filter_value'";
					$_atitle = " - All Agents of ".$this->Common_model->get_single_value($qSql);				
					break;	
									
			}	
		}
		
				
		$start_date =$fArray['start_date'];
		$end_date =$fArray['end_date'];
		
		$title="Attendance From ".$start_date." To ".$end_date.$_atitle. " (All Time is in 'User Local Time')";
		
		$start_date =str_replace("/","-",$start_date);
		$end_date =str_replace("/","-",$end_date);
		
		//$process =$fArray['process'];	
		
		$fn="attendance-".$start_date."-".$end_date."".$_atitle.".xls";
		$filename = "./assets/reports/".$fn;
		
		$sht_title=$start_date." To ".$end_date." ";
		
		$default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb'=>'000000')
		);

		$style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFBCB2'),
			),
			'font' => array(
				'bold' => true,
				'size' => 11,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_p = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'68A368'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_l = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFFF00'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_trm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF0000'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_ptrm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF817F'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		
		$style_syslog = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'9ec2ff'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_gray = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'808080'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_def = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_def_left = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'size' => 10,
			)
		);
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
						
		//$letters = range('A', 'Z');
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}

		//print_r($letters);
		// start and end are seconds, so I convert it to days 
		
					
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$cell='A2';
		if($isLoginTime=="Y"){
			$cell='A2:A3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('B2', 'Fusion Id');
		$cell='B2';
		if($isLoginTime=="Y"){
			$cell='B2:B3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('C2', 'OM ID/XPOID');
		$cell='C2';
		if($isLoginTime=="Y"){
			$cell='C2:C3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('D2', 'NAME');
		$cell='D2';
		if($isLoginTime=="Y"){
			$cell='D2:D3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('E2', 'Dept');
		$cell='E2';
		if($isLoginTime=="Y"){
			$cell='E2:E3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('F2', 'Designation');
		$cell='F2';
		if($isLoginTime=="Y"){
			$cell='F2:F3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$this->excel->getActiveSheet()->setCellValue('G2', 'DOJ');
		$cell='G2';
		if($isLoginTime=="Y"){
			$cell='G2:G3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$cell='H2';
		$this->excel->getActiveSheet()->setCellValue('H2', 'Location');
		if($isLoginTime=="Y"){
			$cell='H2:H3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='I2';
		$this->excel->getActiveSheet()->setCellValue('I2', 'Client');
		if($isLoginTime=="Y"){
			$cell='I2:I3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='J2';
		$this->excel->getActiveSheet()->setCellValue('J2', 'Process');
		if($isLoginTime=="Y"){
			$cell='J2:J3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='K2';
		$this->excel->getActiveSheet()->setCellValue('K2', 'L1 Supervisor');
		
		if($isLoginTime=="Y"){
			$cell='K2:K3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='L2';
		$this->excel->getActiveSheet()->setCellValue('L2', 'Status');
		
		if($isLoginTime=="Y"){
			$cell='L2:L3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='M2';
		$this->excel->getActiveSheet()->setCellValue('M2', 'Phase');
		
		if($isLoginTime=="Y"){
			$cell='M2:M3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		/*
		
		$start = strtotime($start_date);
		$end = strtotime($end_date);
		$diff = ($end - $start) / 86400; 
		$j=4;
		
		for ($i = 0; $i <= $diff; $i++) {
			$date = $start + ($i * 86400);
			$cDate= date('Y-m-d', $date);
			$cell=$letters[$j++]."2";
			$this->excel->getActiveSheet()->setCellValue($cell, $cDate);
		}
		*/
		//$this->excel->getActiveSheet()->getStyle('C2:'.$cell)->applyFromArray( $default_border ); // give style to header
 				
		if($isLoginTime=="Y") $r=3;
		else $r=2;
				
		$j=-1;
		$k=0;
		
		
		$allRowDone=false;
		$isFirst=true;
		
		$pevDate="";
		
		$cnt=1;
		
		foreach($data as $row)
		{
			$rdate=$row['rDate'];
			
			if($isFirst==false && $rdate!=$pevDate) $allRowDone=true;
			
			if($rdate!=$pevDate){
				
				if($isLoginTime=="Y"){ 
					$j+=10;
					$r=3;
				}else{
					//$j++;
					$j+=4;
					$r=3;
				}
			}
			
			$isFirst=false;
			
			if($allRowDone==false) $j = -1;
						
			$r++;
			
			$pevDate=$rdate;
			
			$disposition=$row['disposition'];
			$office_id = $row['office_id'];
			$role_id=$row['role_id'];
			
			$logged_in_hours = $row['logged_in_hours'];
			$logged_in_hours_local = $row['logged_in_hours_local'];
			
			$work_time=$row['logged_in_sec'];
			$work_time_local=$row['logged_in_sec_local'];
			
			$bg_style=$style_def;
			$bg_style_est=$style_def;
			$bg_style_local=$style_def;
			
			$att="";
			
			$isProperLogout = 'Y';
			
			$todayLoginTime = $row['todayLoginTime'] ;
			$todayLoginTime_local= ConvServerToLocalAny($todayLoginTime,$office_id);
			
			$is_logged_in = $row['is_logged_in'];
								
			$flogin_time = $row['flogin_time'];
			$flogin_time_local = $row['flogin_time_local'];
			
			$logout_time=$row['logout_time'];
			$logout_time_local=$row['logout_time_local'];
			
			$tBrkTime=$row['tBrkTime'];
			$tBrkTimeLocal=$row['tBrkTimeLocal'];
			
			$ldBrkTime=$row['ldBrkTime'];
			$ldBrkTimeLocal=$row['ldBrkTimeLocal'];
			
			$total_break=$tBrkTime+$ldBrkTime;
			$total_break_local=$tBrkTimeLocal+$ldBrkTimeLocal;
				
			$comments = $row['comments'];
			
			
			$omuid= $row['omuid'];
			$xpoid= $row['xpoid'];
			
			if($xpoid!="") $omuid = $xpoid;
			
			
			$leave_dtl = "";
			$leave_status = $row['leave_status'];
			if($row['leave_type'] !=""){
				if( $leave_status == '0') $leave_dtl = $row['leave_type'] . " Applied";
				else if( $leave_status == '1') $leave_dtl = $row['leave_type'] . " Approved";
				else if( $leave_status == '2') $leave_dtl = $row['leave_type'] . " Reject";
			}
			
			if($work_time == 0){
				$net_work_time="";
				$total_break = "";
				$tBrkTime = "";
				$ldBrkTime = "";
			}else{
				
				$net_work_time=gmdate('H:i:s',$work_time);
				$total_break = gmdate('H:i:s',$total_break);
				$tBrkTime = gmdate('H:i:s',$tBrkTime);
				$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
				
			}
			
			if($work_time_local==0){
				$net_work_time_local="";
				$total_break_local="";
				$tBrkTimeLocal = "";
				$ldBrkTimeLocal = "";
			
			}else{
				
				$net_work_time_local=gmdate('H:i:s',$work_time_local);
								
				$total_break_local = gmdate('H:i:s',$total_break_local);
				$tBrkTimeLocal = gmdate('H:i:s',$tBrkTimeLocal);
				$ldBrkTimeLocal = gmdate('H:i:s',$ldBrkTimeLocal);
			}
			
			
			
			/*
			if($is_logged_in == '1'){
				
				$todayLoginArray = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$flogin_time_local = $todayLoginTime_local;
					
					$disposition="online";
					
					$net_work_time="";
					$net_work_time_local="";
					
					$total_break = "";
					$total_break_local="";
					$tBrkTime = "";
					$tBrkTimeLocal = "";
					$ldBrkTime = "";
					$ldBrkTimeLocal = "";
					$logout_time="";
					$logout_time_local="";
				}
			}
			*/
			
					
			if($is_logged_in == '1'){
				$todayLoginArray = explode(" ",$todayLoginTime);
				$todayLoginTime_local = ConvServerToLocalAny($todayLoginTime,$office_id);
				$todayLoginArray_local = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$disposition="online";
					$net_work_time="";
					$total_break = "";
					$tBrkTime = "";
					$ldBrkTime = "";
					$logout_time="";
				}
				
				if($rdate == $todayLoginArray_local[0]){
						$flogin_time_local=$todayLoginTime_local;
						$disposition="online";
						$net_work_time_local="";
						$total_break_local="";
						$tBrkTimeLocal = "";
						$ldBrkTimeLocal = "";
						$logout_time_local="";
				}
			}
			
			
			
			$disposition_est =  $disposition;
			$disposition_local =  $disposition;
			
			if($logged_in_hours!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_est =  $disposition . " &  P";
						$bg_style_est=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_est =  "P & ". $disposition;
						$bg_style_est=$style_ptrm;
					}else{
						$disposition_est =  "P";
						$bg_style_est=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_est=="LI")$bg_style_est=$style_p;
				else if($disposition_est=="TERM" || $disposition_est=="X")$bg_style_est=$style_trm;
				else if($disposition_est!="Absent") $bg_style_est=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_est = ""; 
					$bg_style_est=$style_gray;
				}else $disposition_est =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_est = $leave_dtl;
			
			
			if($logged_in_hours_local!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_local =  $disposition . " &  P";
						$bg_style_local=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_local =  "P & ". $disposition;
						$bg_style_local=$style_ptrm;
					}else{
						$disposition_local =  "P";
						$bg_style_local=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_local=="LI")$bg_style_local=$style_p;
				else if($disposition_local=="TERM" || $disposition_local=="X")$bg_style_local=$style_trm;
				else if($disposition_local!="Absent") $bg_style_local=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_local = ""; 
					$bg_style_local=$style_gray;
				}else $disposition_local =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_local = $leave_dtl;
			
			/////////////////
			$SkipRole="-#82#112#221#";
			$SkipLocation="-#ELS#JAM#";
			
			if( strpos($SkipRole,"#".$role_id."#") != false && strpos($SkipLocation,"#".$office_id."#") !=false){
				if($disposition_local=="Absent") $disposition_local = "LI";
				if($disposition_est=="Absent") $disposition_est = "LI";
			}
			
			if($isLoginTime=="Y"){
				
				if($disposition_est!="" && $flogin_time=="") $flogin_time = $disposition_est;
				if($disposition_local!="" && $flogin_time_local=="") $flogin_time_local = $disposition_local;
				
				if($disposition_est!="" && $logout_time=="") $logout_time = $disposition_est;
				if($disposition_local!="" && $logout_time_local=="") $logout_time_local = $disposition_local;
				
			}
			
			
			
			////////// For System Logout /////////////////////
			if($row['logout_by']== "0" && $logged_in_hours!="0" ){
				
				//$net_work_time=0;
				//$net_work_time_local = 0;
				//$logout_time="";
				//$logout_time_local="";
				$isProperLogout = 'N';
				
				$comments = "System Logout";
				$bg_style_est =  $style_syslog;
			    $bg_style_local = $style_syslog;
			}
			
			
			
			if($allRowDone==false){
			
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['fusion_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['omuid']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$fullname=$row['fname'] . " ". $row['lname'];
				$this->excel->getActiveSheet()->setCellValue($cell, $fullname);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['dept_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['role_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
								
				$doj=$row['doj'];
				if($doj=="") $doj="NA";
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $doj);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['office_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['client_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['process_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['asign_tl']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_status($row['status']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_phase($row['phase']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+9)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+8)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+9)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					
					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+8)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+9)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+3)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j+1]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
												
												
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					
					
					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+3].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
				}
				
			}else{
								
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+9)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );

					
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+8)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+9)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );

					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+8)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+9)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+3)]."2";
					
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j+1]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					
					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+3].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					 
				}
				
			
			}
	
		}
		
		
		$cell=$letters[$j]."1";
		$this->excel->getActiveSheet()->mergeCells('A1:'.$cell);
		
		//set aligment to center for that merged cell (A1 to N1)
		//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

		//$objWriter->save($filename);
	}
	
	
	
	

	
	
	
	
	
	
/*================================ LOGIN ADHERENCE ===============================================================================*/


	public function adherence()
    {
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "reports_hr/att_adherence.php";
			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('start_date');
			$end_date   = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$showtype = $this->input->get('showtype');
					
			if($office_id=="")  $office_id = $ses_office_id;
			if($dept_id=="")  $dept_id = $ses_dept_id;
			
			//------ LOCATION LIST
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//------ DEPARTMENT LIST
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['cValue']  = $client_id;
			$data['sValue']  = $site_id;
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			
			
			//-- FILTER SEARCH
			if($office_id == "ALL") $extraoffice = "";
			else $extraoffice = " AND s.office_id = '$office_id'";
			
			if($dept_id == "ALL") $extradepartment = "";
			else $extradepartment = " AND s.dept_id = '$dept_id'";
			
			//--------- USER LIST
			/*$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
			s.office_id, d.shname as department_name from signin s 
			LEFT JOIN department d on s.dept_id = d.id
			WHERE 1 $extraoffice $extradepartment";
			$data['myusers'] = $query_users = $this->Common_model->get_query_result_array($sqlusers);		
			*/	
			
			//-- DAY WISE DATA ARRAY
			$date1 = new DateTime($start_date);
			$date2 = new DateTime($end_date);
			$days  = $date2->diff($date1)->format('%a');
			$hdate = new DateTime($start_date);
			for($i=1; $i<=$days+1; $i++){
				$data['dayreport'][$hdate->format('Y-m-d')] = $this->get_login_data_inday_all($hdate->format('Y-m-d'), $dept_id, $office_id);
				$hdate->modify('+1 day');
			}
			
			if($showtype != ""){ $data['showtype'] = $showtype; }
			$data['urlform'] = "start_date=".$start_date ."&end_date=".$end_date."&office_id=".$office_id."&dept_id=".$dept_id;
			//echo "<pre>" .print_r($data, true) ."</pre>"; die();
			
			$data['dataViewType'] = "on";
			$this->load->view('dashboard',$data);
				
	   }
	
    }
	
	
	private function get_login_data_inday($getdate, $dept_id)
	{
		if($dept_id == "ALL"){ 
		
		$sqllogin = "SELECT d.user_id, d.logout_by, min(getEstToLocal(d.login_time,d.user_id)) as login_time_local, max(getEstToLocal(d.logout_time,d.user_id)) as logout_time_local,  SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(d.login_time,d.user_id), getEstToLocal(d.logout_time,d.user_id)))) as totaltime,
		s.shdate as scheduledate, s.scheduled_login, s.scheduled_logout, s.in_time as scheduled_in_time, s.out_time as scheduled_out_time from logged_in_details as d
		LEFT JOIN (SELECT user_id, shdate, in_time, out_time, CONCAT(shdate, ' ', in_time,':00') as scheduled_login, CONCAT(shdate, ' ', out_time,':00') as scheduled_logout FROM user_shift_schedule) as s ON s.user_id = d.user_id AND s.shdate = '$getdate'
		WHERE (date(getEstToLocal(d.login_time,d.user_id)) = '$getdate') GROUP BY d.user_id";
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		
		} else {
			
		$sqllogin = "SELECT d.user_id, d.logout_by, min(getEstToLocal(d.login_time,d.user_id)) as login_time_local, max(getEstToLocal(d.logout_time,d.user_id)) as logout_time_local ,  SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(d.login_time,d.user_id), getEstToLocal(d.logout_time,d.user_id)))) as totaltime, s.shdate as scheduledate, s.scheduled_login, s.scheduled_logout, s.in_time as scheduled_in_time, s.out_time as scheduled_out_time from logged_in_details as d
		LEFT JOIN (SELECT user_id, shdate, in_time, out_time, CONCAT(shdate, ' ', in_time,':00') as scheduled_login, CONCAT(shdate, ' ', out_time,':00') as scheduled_logout FROM user_shift_schedule) as s ON s.user_id = d.user_id AND s.shdate = '$getdate'
		WHERE (date(getEstToLocal(d.login_time,d.user_id)) = '$getdate') AND d.user_id IN (SELECT id from signin WHERE dept_id = '$dept_id') GROUP BY d.user_id";
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
	
		}
		
		return $querylogin;
		
	}
	
	
	//----- FUNCTION FOR DAY WISE DATA RECORDS
	private function get_login_data_inday_all($getdate, $dept_id, $office_id)
	{
		if($dept_id == "ALL"){ $addextradep = ""; } else { $addextradep = " AND sg.dept_id = '$dept_id'"; }
		if($office_id == "ALL"){ $addextraoffice = ""; } else { $addextraoffice = " AND sg.office_id = '$office_id'"; }
		
		$sqllogin = "SELECT 
					sg.fusion_id, sg.status, sg.phase,
					concat(sg.fname, ' ', sg.lname) as fullname,
					concat(lsg.fname, ' ', lsg.lname) as l1_supervisor,
					get_client_names(sg.id) as client_name,
					get_process_names(sg.id) as process_name,
					r.name as designation,
					sg.role_id, 					
					sg.office_id,
					dp.shname as department_name, 
					d.user_id, 
					d.logout_by, 
					min(d.login_time_local) as login_time_local, 
					max(d.logout_time_local) as logout_time_local,  
					SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,d.login_time_local, d.logout_time_local))) as totaltime, 
					s.shdate as scheduledate, 
					s.scheduled_login, s.scheduled_logout, s.in_time as scheduled_in_time, 
					s.out_time as scheduled_out_time, 
					TIMEDIFF(s.scheduled_logout, s.scheduled_login) as myinterval,
					CASE 
					WHEN (min(d.login_time_local) > s.scheduled_login) 
					THEN CONCAT('-', TIMEDIFF(min(d.login_time_local), s.scheduled_login))
					ELSE TIMEDIFF(s.scheduled_login, min(d.login_time_local))
					END as myloginadherence			
					from signin as sg
					LEFT JOIN (SELECT dg.user_id, dg.logout_by, dg.login_time_local, dg.logout_time_local from logged_in_details as dg WHERE date(dg.login_time_local) = '$getdate') as d on sg.id = d.user_id
					LEFT JOIN department dp on sg.dept_id = dp.id
					LEFT JOIN role r on r.id = sg.role_id
					LEFT JOIN signin lsg on lsg.id = sg.assigned_to
					LEFT JOIN (SELECT user_id, shdate, in_time, out_time, 
					CASE WHEN in_time LIKE '%:%'
					THEN CONCAT(shdate, ' ', in_time,':00')
					ELSE in_time
					END as scheduled_login,
					CASE WHEN (in_time > out_time)
					THEN CONCAT(DATE_ADD(shdate, INTERVAL 1 DAY), ' ', out_time,':00')
					ELSE CONCAT(shdate, ' ', out_time,':00') 
					END as scheduled_logout FROM user_shift_schedule) as s ON s.user_id = sg.id AND s.shdate = '$getdate'
					WHERE sg.status IN (1,4) and sg.id > 1 $addextradep $addextraoffice GROUP BY sg.id";
				
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		array_multisort(array_column($querylogin, 'office_id'), SORT_ASC, array_column($querylogin, 'fullname'), SORT_ASC, $querylogin);	
			
		return $querylogin;
		
	}
	
	
	private function get_roaster_inday($getdate, $user_id)
	{
		$sqllogin = "SELECT s.shdate, s.in_time, s.out_time, CONCAT(s.shdate, ' ', s.in_time) as scheduled_login, CONCAT(s.shdate, ' ', s.out_time) as scheduled_logout FROM user_shift_schedule as s WHERE s.user_id = '$user_id' AND s.shdate = '$getdate'";
		
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		return $querylogin;
		
	}
	
	
	//`````````````````````````````````````````````````````````````````````````````````````````````````````````````````
	//-------------- EXCEL VIEW -----------------------------------------------------------------------------------------
	
	public function adherence_check()
    {
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "reports_hr/att_adherence.php";
			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('start_date');
			$end_date   = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$showtype = $this->input->get('showtype');
			$showreport = $this->input->get('showReports');
					
			if($office_id=="")  $office_id = $ses_office_id;
			if($dept_id=="")  $dept_id = $ses_dept_id;
			
			//------ LOCATION LIST
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//------ DEPARTMENT LIST
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['cValue']  = $client_id;
			$data['sValue']  = $site_id;
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			
			$data['dataViewType'] = "off";
			
			if($showreport == "View"){
				$this->gen_excel_adherence_report($start_date, $end_date, $dept_id, $office_id);
			} else {
				$this->load->view('dashboard',$data);
			}				
	   }
	
    }
	
	
	//--------- EXCEL GENERATE ADHERENCE -------------------------------------//
	
	private function gen_excel_adherence_report($start_date, $end_date, $dept_id, $office_id)
    {
        
        //error_reporting(E_ALL);
        //ini_set('display_errors', TRUE);
        //ini_set('display_startup_errors', TRUE);
        require_once APPPATH . 'third_party/PHPExcel.php';
		
		
		//---------- SET DATA
		if($office_id == "ALL") $extraoffice = "";
		else $extraoffice = " AND office_id = '$office_id'";
		
		if($dept_id == "ALL") $extradepartment = "";
		else $extradepartment = " AND dept_id = '$dept_id'";
		
		//--------- USER LIST
		/*$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
		s.office_id, d.shname as department_name from signin s 
		LEFT JOIN department d on s.dept_id = d.id
		WHERE 1 $extraoffice $extradepartment";
		$myusers = $query_users = $this->Common_model->get_query_result_array($sqlusers);*/
			
		//-- DAY WISE DATA ARRAY
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
			$dayreport[$hdate->format('Y-m-d')] = $this->get_login_data_inday_all($hdate->format('Y-m-d'), $dept_id, $office_id);
			$hdate->modify('+1 day');
		}
		
		//echo "<pre>" .print_r($myusers, true) ."</pre>";
		//echo "<pre>" .print_r($dayreport, true) ."</pre>"; die();
		
		
		/*-----------### CREATE EXCEL ####------------------*/
		
        $objPHPExcel = new PHPExcel();
		
		//---------> CREATE WORKSHEETS
		$titles = array('Login Adherence', 'Auto Logout Count', 'Staffed Time');
		$sheet = 0;
		foreach($titles as $value){
			if($sheet > 0){
				$objPHPExcel->createSheet();
				$objPHPExcel->setActiveSheetIndex($sheet)->setTitle($value);
			}else{
				$objPHPExcel->setActiveSheetIndex(0)->setTitle("$value");
			}
			$sheet++;
		} 
		
		

		for($sh=0;$sh<3;$sh++){
		
        $objPHPExcel->setActiveSheetIndex($sh);
        $objPHPExcel->getActiveSheet()->freezePane('D2');
        $rowCount = 3;
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
				
		$c_col = "0";
		$c_row = "1";
		
		
		// COLUMNS SET
		$c_row++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(6);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, '#');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 		
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(14);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Fusion ID');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
        $objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Name');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(8);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Site');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Department');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Designation');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(25);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Client');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(25);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Process');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'L1 Supervisor');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Status');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Phase');
		//$objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setIndent(2);
		
		
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
		
		
		//--- FOR WORKSHEEET 1
		if($sh == 0){
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(22);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Rostered Login Time');
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Actual Login Time');
		}
		
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $hdate->format('d-M-Y'));
			
			$hdate->modify('+1 day');
		}
		
		$lastColName = "Late Login Count";
		if($sh == 1){ $lastColName = "System Logout Count"; }
		if($sh == 2){ $lastColName = "Shortage Count"; }
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $lastColName);
				
		// HEADER SET
        $objPHPExcel->getActiveSheet()->getStyle("A1:".$current_column."1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', $titles[$sh]);
        $objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		
		$colorArrayWhite = array('font'  => array('color' => array('rgb' => 'FFFFFF')));
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->applyFromArray($colorArrayWhite);
		$objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setIndent(2);
		
		$endingcol = $c_col;
		
		// -- SET EXCEL DATA
		$sl = 0;
		$ir = 0;
		$startdate = date('Y-m-d', strtotime($start_date));
        foreach($dayreport[$startdate] as $token)
        {
			$sl++;
			$c_row++;
			$fusion_id 			= $token['fusion_id'];
			$fullname 			= $token['fullname'];
			$office_id 			= $token['office_id'];
			$department_name 	= $token['department_name'];
			$designation 		= $token['designation'];
			$client_name 		= $token['client_name'];
			$process_name 		= $token['process_name'];
			$l1_supervisor 		= $token['l1_supervisor'];
			$user_status 		= $this->display_user_status($token['status']);
			$user_phase 		= $this->display_user_phase($token['phase']);
			
			$c_col = 0;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $sl);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fusion_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fullname);
			$objPHPExcel->getActiveSheet()->getStyle("C".$c_row)->getAlignment()->setIndent(2);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $office_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $department_name);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $designation);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $client_name);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $process_name);
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $l1_supervisor);
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $user_status);
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $user_phase);
			//$objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setIndent(2);
			
			$nextendingcol = $c_col;
			
			//------ SET DATEWISE DATA
			$latecount = 0;
			$bdate = new DateTime($start_date);	
			$nextendingcol = $c_col;
			$h = $m = $s = 0;
			for($i=1; $i<=$days+1; $i++){
				
				$scheduled_login  = "";
				$login_time_local = "";
				$interval = ""; $extrasign = ""; $colorclass = "";
				
				//$search_row = array_search($token['user_id'], array_column($dayreport[$bdate->format('Y-m-d')],'user_id'));
				//if($search_row != ""){
				//$set_user_array = $dayreport[$bdate->format('Y-m-d')][$search_row];
				
				$set_user_array = $dayreport[$bdate->format('Y-m-d')][$ir];
				$scheduled_login  = $set_user_array['scheduled_login'];
				$login_time_local = $set_user_array['login_time_local'];
				
				
				//--- FOR WORKSHEEET 1
				if($sh == 0){
				/*	
				if(strlen($set_user_array['scheduled_login']) > 5)
				{
					$t1 = strtotime( $set_user_array['scheduled_login'] );
					$t2 = strtotime( $set_user_array['login_time_local'] );
					
					if($t2 > $t1){
						$diff = abs($t2 - $t1);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
						$colorclass = "red"; $extrasign = "-";
						$latecount++;
					}
					if($t1 > $t2){
						$diff = abs($t1 - $t2);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
					}
					
					if($hours > 0){ $s_Hour =  floor($hours); } else { $s_Hour =  "00"; }
					if($minutes > 0){ $s_Minutes =  floor($minutes); } else { $s_Minutes =  "00"; }
					if($seconds > 0){ $s_Seconds =  floor($seconds); } else { $s_Seconds =  "00"; }
					
					$interval = $extrasign .sprintf('%02d', $s_Hour) .":" .sprintf('%02d', $s_Minutes) .":" .sprintf('%02d',$s_Seconds);
			
				}*/
				
				$interval = $set_user_array['myloginadherence'];
				if(strpos($interval, '.') != ""){ $interval = strstr($interval, '.', true); } 
				else { 
					if((empty($login_time_local)) && ($scheduled_login != "") && (!preg_match('/[0-9]/', $scheduled_login))){ 
						$interval = $scheduled_login; 
					} 
				}
				$fistletter = substr($interval,0,1);
				if($fistletter == "-"){ $colorclass = "red"; $latecount++; }
				
				
				}
				
				
				//--- FOR WORKSHEEET 2
				if($sh == 1){
					if(($set_user_array['logout_by'] == 0) && (!is_null($set_user_array['logout_by']))){ 
						$latecount++; $interval = "System Logout"; 
					}
				}
				
				
				//--- FOR WORKSHEEET 3
				if($sh == 2){
					$interval = $set_user_array['totaltime'];
					if((strlen($set_user_array['scheduled_login']) > 5) && (!empty($interval)))
					{
						if($set_user_array['myinterval'] > $set_user_array['totaltime']){ $latecount++; $colorclass = "red"; }
					}
				}
				
				//}
				
				
				if($sh == 0){
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $scheduled_login);
					
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $login_time_local);
				}
				
				$c_col++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $interval);
				
				if($colorclass != ""){
					$colorArray = array('font'  => array('color' => array('rgb' => 'FF0000')));
					$colorColumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
					$objPHPExcel->getActiveSheet()->getStyle($colorColumn.$c_row)->applyFromArray($colorArray);
				}
				
				$bdate->modify('+1 day');		
			}
			
			$c_col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $latecount);
			
			$ir++;
			
		}
		
		$lastcolumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
		$objPHPExcel->getActiveSheet()->getStyle("A1:B".$c_row)->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle("C1:C".$c_row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("D1:".$lastcolumn.$c_row)->applyFromArray($style);
		
		}
        
		$objPHPExcel->setActiveSheetIndex(0);
		
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="adherence_report.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);

        $objWriter->save('php://output');
		
    }
	
	
	
	
	
	
	
	
	
	
	
	//`````````````````````````````````````````````````````````````````````````````````````````````````````````````````
	//-------------- EXCEL VIEW 2 -----------------------------------------------------------------------------------------
	
	public function adherence_check_2()
    {
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "reports_hr/att_adherence.php";
			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('start_date');
			$end_date   = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$showtype = $this->input->get('showtype');
			$showreport = $this->input->get('showReports');
					
			if($office_id=="")  $office_id = $ses_office_id;
			if($dept_id=="")  $dept_id = $ses_dept_id;
			
			//------ LOCATION LIST
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//------ DEPARTMENT LIST
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['cValue']  = $client_id;
			$data['sValue']  = $site_id;
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			
			$data['dataViewType'] = "off";
			
			if($showreport == "View"){
				$this->gen_excel_adherence_report_2($start_date, $end_date, $dept_id, $office_id);
			} else {
				$this->load->view('dashboard',$data);
			}				
	   }
	
    }
	
	
	
	
	
	
	
	//----- FUNCTION FOR DAY WISE DATA RECORDS
	private function get_login_data_inday_all_2($getdate, $dept_id, $office_id)
	{
		if($dept_id == "ALL"){ $addextradep = ""; } else { $addextradep = " AND dept_id = '$dept_id'"; }
		if($office_id == "ALL"){ $addextraoffice = ""; } else { $addextraoffice = " AND office_id = '$office_id'"; }
		
		$sqllogin = "SELECT 
					d.user_id, 
					d.logout_by, 
					min(d.login_time_local) as login_time_local,  
					SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,d.login_time_local, d.logout_time_local))) as totaltime, 
					s.shdate as scheduledate, 
					s.scheduled_login, 
					s.scheduled_logout, 
					s.in_time as scheduled_in_time, 
					s.out_time as scheduled_out_time, 
					TIMEDIFF(s.scheduled_logout, s.scheduled_login) as myinterval, 
					CASE 
					WHEN (min(d.login_time_local) > s.scheduled_login) 
					THEN CONCAT('-', TIMEDIFF(min(d.login_time_local), s.scheduled_login))
					ELSE TIMEDIFF(s.scheduled_login, min(d.login_time_local))
					END as myloginadherence
					from logged_in_details as d 
					LEFT JOIN 
					(SELECT user_id, shdate, in_time, out_time, 
					CASE WHEN in_time LIKE '%:%'
					THEN CONCAT(shdate, ' ', in_time,':00')
					ELSE in_time
					END as scheduled_login,
					CASE WHEN (in_time > out_time)
					THEN CONCAT(DATE_ADD(shdate, INTERVAL 1 DAY), ' ', out_time,':00')
					ELSE CONCAT(shdate, ' ', out_time,':00') 
					END as scheduled_logout FROM user_shift_schedule) 
					as s ON 
					s.user_id = d.user_id 
					AND s.shdate = '$getdate'
					WHERE date(d.login_time_local) = '$getdate' 
					AND d.user_id IN (SELECT id from signin WHERE 1 AND status IN (1,4) $addextradep $addextraoffice)
					GROUP BY d.user_id";
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		
		
		return $querylogin;
		
	}
	
	
	
	
	
	//--------- EXCEL GENERATE ADHERENCE -------------------------------------//
	
	private function gen_excel_adherence_report_2($start_date, $end_date, $dept_id, $office_id)
    {
        
        //error_reporting(E_ALL);
        //ini_set('display_errors', TRUE);
        //ini_set('display_startup_errors', TRUE);
        require_once APPPATH . 'third_party/PHPExcel.php';
		
		
		//---------- SET DATA
		if($office_id == "ALL") $extraoffice = "";
		else $extraoffice = " AND office_id = '$office_id'";
		
		if($dept_id == "ALL") $extradepartment = "";
		else $extradepartment = " AND dept_id = '$dept_id'";
		
		//--------- USER LIST
		$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
		s.office_id, d.shname as department_name from signin s 
		LEFT JOIN department d on s.dept_id = d.id
		WHERE 1 AND status IN (1,4) $extraoffice $extradepartment ORDER by s.office_id, fullname";
		$myusers = $query_users = $this->Common_model->get_query_result_array($sqlusers);
			
		//-- DAY WISE DATA ARRAY
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
			$dayreport[$hdate->format('Y-m-d')] = $this->get_login_data_inday_all_2($hdate->format('Y-m-d'), $dept_id, $office_id);
			$hdate->modify('+1 day');
		}
		
		//echo "<pre>" .print_r($myusers, true) ."</pre>";
		//echo "<pre>" .print_r($dayreport, true) ."</pre>"; die();
		
		
		/*-----------### CREATE EXCEL ####------------------*/
		
        $objPHPExcel = new PHPExcel();
		
		//---------> CREATE WORKSHEETS
		$titles = array('Login Adherence', 'Auto Logout Count', 'Staffed Time');
		$sheet = 0;
		foreach($titles as $value){
			if($sheet > 0){
				$objPHPExcel->createSheet();
				$objPHPExcel->setActiveSheetIndex($sheet)->setTitle($value);
			}else{
				$objPHPExcel->setActiveSheetIndex(0)->setTitle("$value");
			}
			$sheet++;
		} 
		
		

		for($sh=0;$sh<3;$sh++){
		
        $objPHPExcel->setActiveSheetIndex($sh);
        $objPHPExcel->getActiveSheet()->freezePane('D2');
        $rowCount = 3;
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
				
		$c_col = "0";
		$c_row = "1";
		
		
		// COLUMNS SET
		$c_row++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(6);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, '#');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 		
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(14);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Fusion ID');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
        $objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Name');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(8);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Site');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Department');
		
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
		
		
		//--- FOR WORKSHEEET 1
		if($sh == 0){
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(22);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Rostered Login Time');
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Actual Login Time');
		}
		
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $hdate->format('d-M-Y'));
			
			$hdate->modify('+1 day');
		}
		
		$lastColName = "Late Login Count";
		if($sh == 1){ $lastColName = "System Logout Count"; }
		if($sh == 2){ $lastColName = "Shortage Count"; }
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $lastColName);
				
		// HEADER SET
        $objPHPExcel->getActiveSheet()->getStyle("A1:".$current_column."1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', $titles[$sh]);
        $objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		
		$colorArrayWhite = array('font'  => array('color' => array('rgb' => 'FFFFFF')));
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->applyFromArray($colorArrayWhite);
		$objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setIndent(2);
		
		$endingcol = $c_col;
		
		// -- SET EXCEL DATA
		$sl = 0;
		$ir = 0;
		$startdate = date('Y-m-d', strtotime($start_date));
        foreach($myusers as $token)
        {
			$sl++;
			$c_row++;
			$fusion_id = $token['fusion_id'];
			$fullname = $token['fullname'];
			$office_id = $token['office_id'];
			$department_name = $token['department_name'];
			
			$c_col = 0;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $sl);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fusion_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fullname);
			$objPHPExcel->getActiveSheet()->getStyle("C".$c_row)->getAlignment()->setIndent(2);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $office_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $department_name);
			
			$nextendingcol = $c_col;
			
			//------ SET DATEWISE DATA
			$latecount = 0;
			$bdate = new DateTime($start_date);	
			$nextendingcol = $c_col;
			$h = $m = $s = 0;
			for($i=1; $i<=$days+1; $i++){
				
				$scheduled_login  = "";
				$login_time_local = "";
				$interval = ""; $extrasign = ""; $colorclass = "";$fistletter= "";
				
				$search_row = array_search($token['user_id'], array_column($dayreport[$bdate->format('Y-m-d')],'user_id'));
				if($search_row != ""){
				$set_user_array = $dayreport[$bdate->format('Y-m-d')][$search_row];
				
				//$set_user_array = $dayreport[$bdate->format('Y-m-d')][$ir];
				$scheduled_login  = $set_user_array['scheduled_login'];
				$login_time_local = $set_user_array['login_time_local'];
				
				
				//--- FOR WORKSHEEET 1
				if($sh == 0){
				/*if(strlen($set_user_array['scheduled_login']) > 5)
				{
					$t1 = strtotime( $set_user_array['scheduled_login'] );
					$t2 = strtotime( $set_user_array['login_time_local'] );
					
					if($t2 > $t1){
						$diff = abs($t2 - $t1);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
						$colorclass = "red"; $extrasign = "-";
						$latecount++;
					}
					if($t1 > $t2){
						$diff = abs($t1 - $t2);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
					}
					
					if($hours > 0){ $s_Hour =  floor($hours); } else { $s_Hour =  "00"; }
					if($minutes > 0){ $s_Minutes =  floor($minutes); } else { $s_Minutes =  "00"; }
					if($seconds > 0){ $s_Seconds =  floor($seconds); } else { $s_Seconds =  "00"; }
					
					$interval = $extrasign .sprintf('%02d', $s_Hour) .":" .sprintf('%02d', $s_Minutes) .":" .sprintf('%02d',$s_Seconds);
			
				}*/
				
				$interval = $set_user_array['myloginadherence'];
				if(strpos($interval, '.') != ""){ $interval = strstr($interval, '.', true); } 
				else { 
					if((empty($login_time_local)) && ($scheduled_login != "") && (!preg_match('/[0-9]/', $scheduled_login))){ 
						$interval = $scheduled_login; 
					} 
				}
				$fistletter = substr($interval,0,1);
				if($fistletter == "-"){ $colorclass = "red"; $latecount++; }
				
				}
				
				
				//--- FOR WORKSHEEET 2
				if($sh == 1){
					if($set_user_array['logout_by'] == 0){ $latecount++; $interval = "System Logout"; }
				}
				
				
				//--- FOR WORKSHEEET 3
				if($sh == 2){
					$interval = $set_user_array['totaltime'];
					if((strlen($set_user_array['scheduled_login']) > 5) && (!empty($interval)))
					{
						if($set_user_array['myinterval'] > $set_user_array['totaltime']){ $colorclass = "red"; $latecount++; }
					}					
				}
				
				}
				
				
				if($sh == 0){
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $scheduled_login);
					
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $login_time_local);
				}
				
				$c_col++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $interval);
				
				if($colorclass != ""){
					$colorArray = array('font'  => array('color' => array('rgb' => 'FF0000')));
					$colorColumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
					$objPHPExcel->getActiveSheet()->getStyle($colorColumn.$c_row)->applyFromArray($colorArray);
				}
				
				$bdate->modify('+1 day');		
			}
			
			$c_col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $latecount);
			
			$ir++;
			
		}
		
		$lastcolumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
		$objPHPExcel->getActiveSheet()->getStyle("A1:B".$c_row)->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle("C1:C".$c_row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("D1:".$lastcolumn.$c_row)->applyFromArray($style);
		
		}
        
		$objPHPExcel->setActiveSheetIndex(0);
		
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="adherence_report.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);

        $objWriter->save('php://output');
		
    }
	
	
/*================================ LOGIN ADHERENCE ENDS ===============================================================================*/




/*================================ LEAVE REPORTS ===============================================================================*/
	public function leave_list()
	{ 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$office_list = "SELECT * FROM `office_location` WHERE is_active = 1  and abbr IN ('KOL', 'CHE', 'NOI', 'BLR','HWH') ORDER BY `abbr` ASC";
		$data['office_list'] = $this->Common_model->get_query_result_array($office_list);

		$dept_list = "SELECT id,shname FROM `department`WHERE is_active = 1";		
		$data['dept_list'] = $this->Common_model->get_query_result_array($dept_list);
		$leave_list = "SELECT abbr FROM `leave_type` WHERE abbr='PL' ORDER BY `abbr` ASC";
		$data['leave_list'] = $this->Common_model->get_query_result_array($leave_list);

		// var_dump($data);
		// FILTER 
		$data['searched'] = 0;
		$extraSearch = "";
		
		$search_Office_ID = $get_dept_id;
		if(!empty($this->input->get('office_abbr')))
		{ 
			$search_Office_ID = $this->input->get('office_abbr');			
			if($search_Office_ID != "ALL" && !empty($search_Office_ID)){
				$extraSearch .= " AND s.office_id = '$search_Office_ID'";
			}
			$data['searched'] = 1;
		}
		
		
		$search_department_id = $this->input->get('dept');			
		if(!empty($this->input->get('dept')))
		{ 
			$search_department_id = $this->input->get('dept');			
			if($search_department_id != "ALL" && !empty($search_department_id)){
				$extraSearch .= " AND s.dept_id = '$search_department_id'";
			}			
			$data['searched'] = 1;
		}
		
		$search_fusion_id = "";
		if(!empty($this->input->get('fusion_id')))
		{ 
			$search_fusion_idArr = $this->input->get('fusion_id');
			$search_fusion_id = implode("','", $search_fusion_idArr);
			$_SESSION['fusion_leave_reports_id'] = $search_fusion_id;
			if($search_fusion_id != "" && !empty($search_fusion_id)){
				$extraSearch .= " AND (s.fusion_id IN ('$search_fusion_id') OR s.xpoid IN ('$search_fusion_id')) ";
			}	
			// var_dump($extraSearch);exit;		
			$data['searched'] = 1;
		}
		
		$search_leave_type = "PL";
		if(!empty($this->input->get('leave_type')))
		{ 
			$search_leave_type = $this->input->get('leave_type');
			$data['searched'] = 1;
		}
		
		$data['office_abbr'] = $search_Office_ID;
		$data['dept'] = $search_department_id;
		$data['fusion_id'] = $search_fusion_id;
		$data['leave_type'] = $search_leave_type;
		
		$list_sql = "SELECT CONCAT(s.fname,' ', s.lname) as fullname, s.xpoid, s.office_id, r.name as designation, get_process_names(s.id) as process_name, ls.leaves_present from signin as s LEFT JOIN role as r ON s.role_id = r.id LEFT JOIN leave_avl_emp as ls ON ls.user_id = s.id AND leave_criteria_id in (SELECT LC.id FROM leave_criteria LC INNER JOIN leave_type LT ON LT.id = LC.leave_type_id WHERE LC.office_abbr = s.office_id AND LT.abbr = '$search_leave_type') WHERE 1 $extraSearch";	
		
		if($data['searched'] == 1){
			$data['details'] = $this->Common_model->get_query_result_array($list_sql);
		}
		
		$data["aside_template"] = "reports_hr/aside.php";
		$data["content_template"] = "reports_hr/leave_reports.php";
		$data["content_js"] = "leave_reports/leave_reports_hr_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	public function leave_dropdown_users(){
		if(check_logged_in())
		{
			$dept_id = $this->input->get('dept_id');
			$offc_id = $this->input->get('offc_id');
			
			$extraSearch = "";
			if($dept_id != "" && $dept_id != "ALL"){ $extraSearch .= " AND s.dept_id ='$dept_id' "; }
			if($offc_id != "" && $offc_id != "ALL"){ $extraSearch .= " AND s.office_id='$offc_id' "; }
			$SQLtxt = "SELECT s.fusion_id as id, CONCAT(s.fname,' ', s.lname) as name FROM signin as s where 1 $extraSearch";
			$fields = $this->db->query($SQLtxt);
			
			$result_data =  $fields->result_array();
			  
			echo  json_encode($result_data);
			 
		}
	}
	
	public function leave_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$extraSearch = "";
		if(!empty($this->input->get('office_abbr')))
		{ 
			$search_Office_ID = $this->input->get('office_abbr');
			if($search_Office_ID != "ALL" && !empty($search_Office_ID)){
				$extraSearch .= " AND s.office_id = '$search_Office_ID'";
			}
		}

		if(!empty($this->input->get('dept')))
		{ 
			$search_department_id = $this->input->get('dept');
			if($search_department_id != "ALL" && !empty($search_department_id)){
				$extraSearch .= " AND s.dept_id = '$search_department_id'";
			}	
		}

	//	if(!empty($this->input->get('fusion_id')))
		if(!empty($_SESSION['fusion_leave_reports_id']))
		{ 
			// $search_fusion_idArr = $this->input->get('fusion_id');
			// $search_fusion_id = implode("','", $search_fusion_idArr);
			$search_fusion_id = $_SESSION['fusion_leave_reports_id'] ;
			if($search_fusion_id != "" && !empty($search_fusion_id)){
				$extraSearch .= " AND (s.fusion_id IN ('$search_fusion_id') OR s.xpoid IN ('$search_fusion_id')) ";
			}	
		}
		if(!empty($this->input->get('leave_type')))
		{ 
			$search_leave_type = $this->input->get('leave_type');
		}
		

		$this->generate_leave_report_xls($search_Office_ID, $search_department_id, $search_fusion_id, $search_leave_type, $extraSearch);
	
	}
	
	
	public function generate_leave_report_xls($search_Office_ID="", $search_department_id="", $search_fusion_id="", $search_leave_type, $extraSearch)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$reports_sql = "SELECT s.xpoid,s.fusion_id, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, r.name as designation, get_process_names(s.id) as process_name, ls.leaves_present 
		from signin as s 
		LEFT JOIN role as r ON s.role_id = r.id 
		LEFT JOIN leave_avl_emp as ls ON ls.user_id = s.id AND leave_criteria_id in (SELECT LC.id FROM leave_criteria LC INNER JOIN leave_type LT ON LT.id = LC.leave_type_id WHERE LC.office_abbr = s.office_id AND LT.abbr = '$search_leave_type') 
		WHERE 1 $extraSearch";	
					 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);


		// print_r($report_list); exit;
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('Leave Reports');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:F1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Site ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leaves Present");
				
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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "LEAVE REPORTS");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;			
			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["xpoid"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["xpoid"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, round($wv["leaves_present"]));
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Leave_reports.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
/*================================ LEAVE REPORTS ENDS ===============================================================================*/
	

	
	
	//===== SIGNIN USER PHASE =======================//
	public function display_user_status($status="", $type="")
	{
		$phaseName = ""; 
		$phaseArr = array(
			'0' => "Term",
			'1' => "Active",
			'2' => "Pre Term",
			'3' => "Suspended",
			'4' => "New",
			'5' => "BENCH-PAID",
			'6' => "BENCH-UNPAID",
			'7' => "Furlough Leave",
			'8' => "Deactivate (Term MANUAL)",
			'9' => "Deactivate",
		);
		foreach($phaseArr as $key => $value){
		  if($key == $status){  $phaseName = $value; }
		}
		if($type == 'array'){ 
			return $phaseArr; 
		} else {
			return $phaseName;
		}		
	}
	
	
	public function new_joiners_feedback()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		$data["aside_template"] = "reports_hr/aside.php";
		$data["content_template"] = "new_joiners_feedback_form/new_joiners_feedback_form_reports.php";	
		$role = get_role_dir();			
		// var_dump($role);
		// die;
		$this->load->view('dashboard',$data);
	}
	
	
    public function process_reportform()
	{
		$startdate = date('Y-m-d');
		$enddate = date('Y-m-d');
		$maintype = '';
		if(!empty($this->input->post('startdate'))) {
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$maintype = $this->input->post('maintype');
		}
		$startdate = $startdate.' 00:00:00';
		$enddate = $enddate.' 00:00:00';
		// var_dump($startdate,$enddate);
		// die;
		switch ($maintype) {
			case 'typeone':
				$table = 'new_joiners_feedback';
				$title = 'Feedback Report for Form One';
				$this->generate_feedback_report_one($startdate, $enddate, $table, $title);
				break;

			case 'typetwo':
				$table = 'new_joiners_feedback_two';
				$title = 'Feedback Report for Form Two';
				$this->generate_feedback_report_two($startdate, $enddate, $table, $title);
				break;
			default:
				# code...
				break;
		}
	}


	public function generate_feedback_report_one($startdate="", $enddate="", $tablename="", $title="")
	{
		$current_user = get_user_id();
		$user_site_id = get_user_site_id();
		$user_office_id = get_user_office_id();
		$user_oth_office = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir = get_role_dir();
		$get_dept_id = get_dept_id();

		$reports_sql = "SELECT t.*,s.fusion_id, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id,r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(created_at) >= '$startdate' AND DATE(created_at) <= '$enddate' GROUP BY id ORDER by id DESC"; 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		$answerCheck = "understanding_role,recruiting_process,online_induction,joining_formalities,induction_kit,introduction,clarity_to_job,adequate_resources,adequate_support,technical_training";
		$answerArray = explode(',', $answerCheck);

		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Q1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");

		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Understand My Role");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Recruiting Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Induction Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Joining Formalities");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Induction Kit With Relevant Information");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Proper Introduction With Team");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Clarity From Manager About Job Profile");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adequate Resources");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adequate Support From Senior");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Required Technical Training");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Status");
				
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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "New Joiners Feedback Form One (7-10 days)");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];
			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["understanding_role"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["recruiting_process"]);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["online_induction"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["joining_formalities"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["induction_kit"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["introduction"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["clarity_to_job"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["adequate_resources"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["adequate_support"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["technical_training"]);

			// CHECK STATUS
			$currentStatus = "Somewhat Agree"; $noCheck = 0; $yesCheck = 0;
			foreach($answerArray as $token){
				if(strtolower($wv[$token]) == 'yes'){ $yesCheck++; }
				if(strtolower($wv[$token]) == 'no'){ $noCheck++; }
			}
			if(count($answerArray) == $noCheck){ $currentStatus = "Completely Disagree"; }
			if(count($answerArray) == $yesCheck){ $currentStatus = "Completely Agree"; }			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $currentStatus);

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="New_joiners_feedback_reports.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	public function generate_feedback_report_two($startdate="", $enddate="", $tablename="", $title="")
	{
		$current_user = get_user_id();
		$user_site_id = get_user_site_id();
		$user_office_id = get_user_office_id();
		$user_oth_office = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir = get_role_dir();
		$get_dept_id = get_dept_id();

		$reports_sql = "SELECT t.*,s.fusion_id, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id,r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(created_at) >= '$startdate' AND DATE(created_at) <= '$enddate' GROUP BY id ORDER by id DESC"; 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);
		$answerCheck = "previous_feedback,duties_and_responsibilities,id_and_biometric,device_and_email,received_hr_policy,training_policy,adequate_cooperation,work_culture";
		$answerArray = explode(',', $answerCheck);
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Q1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");

		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shared My Feedback After 7-10 Days Of Completion");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Understanding My Duties And Responsibilities");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Got My Employee Id and Biometric Access");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Got My Desktop/Laptop and Email Id");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Receive HR Policy");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Going Through Process Training");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Got A Warm Welcome From My Peers And I Am Getting Adequate Cooperation From Them");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "My Questions Related To The Organization And My Departmental Work Procedures Have Been Addressed By");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Days Needs To Showcase My Talent Through My Performance");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "I Have Started Liking The Work Culture Of Xplore-Tech And Wish To See Myself Growing Here");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "My Expression Being A Part Of Xplore-Tech");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Status");
				
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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "New Joiners Feedback Form One (7-10 days)");
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];			
			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["previous_feedback"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["duties_and_responsibilities"]);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["id_and_biometric"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["device_and_email"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["received_hr_policy"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["training_policy"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["adequate_cooperation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["questions_related_to_org"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["day_need_to_show"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["work_culture"]);	
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["technical_training"]);
			
			// CHECK STATUS
			$currentStatus = "Somewhat Agree"; $noCheck = 0; $yesCheck = 0;
			foreach($answerArray as $token){
				if(strtolower($wv[$token]) == 'yes'){ $yesCheck++; }
				if(strtolower($wv[$token]) == 'no'){ $noCheck++; }
			}
			if(count($answerArray) == $noCheck){ $currentStatus = "Completely Disagree"; }
			if(count($answerArray) == $yesCheck){ $currentStatus = "Completely Agree"; }			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $currentStatus);
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="New_joiners_feedback_reports_two.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	//====================================================================================//
	
	public function user_status_report()
	{
		error_reporting(1);
		ini_set('display_errors', 1);
		$this->db->db_debug=true;
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['location_list'] = $this->Common_model->get_office_location_list();
		$data['department_list'] = $this->Common_model->get_department_list();
		$data["aside_template"] = "reports_hr/aside.php";
		$data["content_template"] = "reports_hr/report_user_status.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		$data['deptSelected'] = $deptSelection = $get_dept_id;
		if(!empty($this->input->get('office_id'))){
			$data['OfficeSelected'] = $officeSelection = $this->input->get('office_id');
			$data['deptSelected'] = $deptSelection = $this->input->get('dept_id');
		}
		
		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
		$extraFilter .= " AND s.status IN (1,4)";
		
		//LEFT JOIN logged_in_details lg ON lg.user_id = s.id AND lg.id IN (SELECT max(id) from logged_in_details GROUP BY user_id)
		
		// GET VIEW TYPE
		$viewType = "";
		if($this->input->get('export') == 'excel'){
			$viewType = "download";
		}
		
		if($viewType != 'download'){
		
		$todayDate=CurrDate();		
		$todayLocalDate=GetLocalDate();		
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$todayLocalDate=GetLocalDateByOffice($officeSelection);
		}
		$data['localDate'] = $todayLocalDate;
		
		$todayDateTime=CurrMySqlDate();
		$todayLocalDateTime=GetLocalTime();
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$todayLocalDateTime=GetLocalTimeByOffice($officeSelection);
		}
		$data['localDateTime'] = $todayLocalDateTime;
		
		$sqlUsers = "SELECT s.*, o.office_name, st.name as site_name, r.name as designation, d.shname as department, 
		            CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor, CONCAT(s.fname, ' ', s.lname) as agent_name,
					 lg.logout_by, lg.logout_time_local as last_logout_time_local, lg.logout_time_local as last_logout_time, 
					 ld.f_login_time, ld.l_logout_time, ld.l_logout_time_local, ld.f_login_time_local, 
					 CASE WHEN (s.last_logged_date != '0000-00-00 00:00:00') THEN timediff(Now(),s.last_logged_date) ELSE '00:00:00' END as loggedHour, 
					 SEC_TO_TIME(ld.totalLoginTimes) as totalLoginTime, ld.totalLoginTimes as totalLoginTimeSeconds
		             from signin as s 
		             LEFT JOIN office_location as o ON o.abbr = s.office_id
		             LEFT JOIN site as st ON st.id = s.site_id
		             LEFT JOIN role as r ON r.id = s.role_id
		             LEFT JOIN department as d ON d.id = s.dept_id
		             LEFT JOIN signin as sl ON sl.id = s.assigned_to
					 LEFT JOIN logged_in_details lg ON lg.user_id = s.id AND lg.id IN (SELECT max(id) from logged_in_details GROUP BY user_id)		             
					 LEFT JOIN (SELECT user_id, MIN(login_time_local) as f_login_time_local, MIN(login_time) as f_login_time, MAX(logout_time_local) as l_logout_time_local, MAX(logout_time) as l_logout_time, SUM(TIME_TO_SEC(timediff(logout_time_local, login_time_local))) as totalLoginTimes from logged_in_details WHERE DATE(login_time) = '".$todayDate."' group by user_id) as ld ON s.id = ld.user_id
					 WHERE 1 $extraFilter
					 ORDER BY s.fname ASC";
		$data['userData'] = $queryUsers = $this->Common_model->get_query_result_array($sqlUsers);
		$userIDs = array_column($queryUsers, 'id');
		$gotIDs = "0";
		if(!empty($userIDs)){
			$gotIDs = implode(',', $userIDs);
		}
		
		$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.user_id IN ($gotIDs)
								 AND sh.shdate = '$todayDate'
								 GROUP BY sh.shdate, sh.user_id";
		$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
		$data['scheduleData'] = $this->array_indexed($schedule_query, 'user_id');
		
		
		} else {
			
			$this->generate_user_status_report_xls($officeSelection, $deptSelection);
			
		}
		
		
		$this->load->view('dashboard', $data);
	}
	
	private function array_indexed($dataArray = NULL, $column = "")
	{
		$result = array();
		if(!empty($dataArray) && !empty($column))
		{
			$arrOne = array_column($dataArray, $column);
			$arrTwo = $dataArray;
			$result = array_combine($arrOne, $arrTwo);
		}		
		return $result;
	}
	
	public function convert_time_view($seconds)
	{
		$diff = $seconds;
		$hours = floor($diff / (60*60));
		$minutes = floor(($diff - $hours*60*60)/ 60);
		$seconds = floor(($diff - $hours*60*60 - $minutes*60));									
		$times = array();
		$times[] = !empty($hours) ? sprintf('%02d', $hours) : "00"; 
		$times[] = !empty($minutes) ? sprintf('%02d', $minutes) : "00"; 
		$times[] = !empty($seconds) ? sprintf('%02d', $seconds) : "00";
		return implode(':', $times);
	}
	
	
	public function generate_user_status_report_xls($officeSelection='', $deptSelection='', $userData = NULL, $scheduleData= NULL)
	{
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		$extraFilter = "";
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$extraFilter .= " AND s.office_id = '$officeSelection' ";
		}
		if(!empty($deptSelection) && $deptSelection != "ALL"){
			$extraFilter .= " AND s.dept_id = '$deptSelection' ";
		}
		$extraFilter .= " AND s.status IN (1,4)";
		
		$todayDate=CurrDate();		
		$todayLocalDate=GetLocalDate();		
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$todayLocalDate=GetLocalDateByOffice($officeSelection);
		}
		$localDate = $todayLocalDate;
		
		$todayDateTime=CurrMySqlDate();
		$todayLocalDateTime=GetLocalTime();
		if(!empty($officeSelection) && $officeSelection != "ALL"){
			$todayLocalDateTime=GetLocalTimeByOffice($officeSelection);
		}
		$localDateTime = $todayLocalDateTime;
		
		$sqlUsers = "SELECT s.*, o.office_name, st.name as site_name, r.name as designation, d.shname as department, 
		            CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor, CONCAT(s.fname, ' ', s.lname) as agent_name,
					 lg.logout_by, lg.logout_time_local as last_logout_time_local, lg.logout_time_local as last_logout_time, 
					 ld.f_login_time, ld.l_logout_time, ld.l_logout_time_local, ld.f_login_time_local, 
					 CASE WHEN (s.last_logged_date != '0000-00-00 00:00:00') THEN timediff(Now(),s.last_logged_date) ELSE '00:00:00' END as loggedHour, 
					 SEC_TO_TIME(ld.totalLoginTimes) as totalLoginTime, ld.totalLoginTimes as totalLoginTimeSeconds
		             from signin as s 
		             LEFT JOIN office_location as o ON o.abbr = s.office_id
		             LEFT JOIN site as st ON st.id = s.site_id
		             LEFT JOIN role as r ON r.id = s.role_id
		             LEFT JOIN department as d ON d.id = s.dept_id
		             LEFT JOIN signin as sl ON sl.id = s.assigned_to
					 LEFT JOIN logged_in_details lg ON lg.user_id = s.id AND lg.id IN (SELECT max(id) from logged_in_details GROUP BY user_id)		             
					 LEFT JOIN (SELECT user_id, MIN(login_time_local) as f_login_time_local, MIN(login_time) as f_login_time, MAX(logout_time_local) as l_logout_time_local, MAX(logout_time) as l_logout_time, SUM(TIME_TO_SEC(timediff(logout_time_local, login_time_local))) as totalLoginTimes from logged_in_details WHERE DATE(login_time) = '".$todayDate."' group by user_id) as ld ON s.id = ld.user_id
					 WHERE 1 $extraFilter
					 ORDER BY s.fname ASC";
		$userData = $queryUsers = $this->Common_model->get_query_result_array($sqlUsers);
		$userIDs = array_column($queryUsers, 'id');
		$gotIDs = "0";
		if(!empty($userIDs)){
			$gotIDs = implode(',', $userIDs);
		}
		
		$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.user_id IN ($gotIDs)
								 AND sh.shdate = '$todayDate'
								 GROUP BY sh.shdate, sh.user_id";
		$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
		$scheduleData = $this->array_indexed($schedule_query, 'user_id');
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('User Status Report');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Z1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Site");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Today Login Status");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Last Logout Mode");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Last Logout Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Todays Login Duration");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Schedule Login Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "1st Login Time");

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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:N1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "USER STATUS REPORT - " .$todayLocalDate);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		
		$currentDate = CurrDate();
		$currentLocalDate = GetLocalDate();
		$currentDateTime = CurrMySqlDate();
		$currentLocalDate = $localDate;
		foreach($userData as $token){
		
			$i++;
			$logout_by = $token['logout_by'];
			$first_login_time = $token['f_login_time_local'];									
			$last_logout_time = $token['l_logout_time_local'];
			
			$first_login_time_est = $token['f_login_time'];
			$last_logout_time_est = $token['l_logout_time'];
			
			$is_logged_in = $token['is_logged_in'];
			$lastLoggedIn = $token['last_logged_date'];
			
			// 1st LOGGED IN
			//$dayChecker = $lastLoggedIn;
			$dayChecker = "";
			if(!empty($first_login_time)){
				$dayChecker = $first_login_time;
			} else {
				if($lastLoggedIn != "0000-00-00 00:00:00"){
					if(date('Y-m-d', strtotime($lastLoggedIn)) == $currentDate){
					$dayChecker = ConvServerToLocalAny($lastLoggedIn, $officeSelection);
					}
				}
			}

			// TODAY LOGGED IN CHECKER
			$dayCheckerEST = $lastLoggedIn;
			if(!empty($first_login_time_est)){
				$dayCheckerEST = $first_login_time_est;
			}									
			$is_login = "No"; $is_login_class = "danger";  $is_login_icon = "times";
			if(date('Y-m-d', strtotime($dayCheckerEST)) == $currentDate){
				$is_login = "Yes"; $is_login_class = "success"; $is_login_icon = "check";
			}
			$is_login_icon = "circle";
			
			
			// CHECK LOGGED OUT BY
			$is_logout = "System"; $is_logout_class = "secondary"; $is_logout_icon = "";
			if(!empty($logout_by)){
				$is_logout = "Self"; $is_logout_class = "primary"; $is_logout_icon = "<i class='fa fa-check'></i>";
			}
			
			// LAST LOGOUT DATE
			$last_logout_date = $token['last_logout_time'];
			$last_logout_date_local = $token['last_logout_time_local'];
			
			// LOGGED HOURS
			$gotLogged = 0;
			$loggedHour = $token['totalLoginTime'];
			if(empty($first_login_time) && !empty($dayChecker)){
				$gotLogged = 1;
				$loggedHour = $token['loggedHour'];
			}
			if(!$gotLogged){
				$gotSeconds = $token['totalLoginTimeSeconds'];
				if(strtotime($lastLoggedIn) > strtotime($last_logout_time_est)){
					if(!empty($dayChecker)){
					$extraSeconds = strtotime(CurrMySqlDate()) - strtotime($lastLoggedIn);
					$totalSeconds = $gotSeconds + $extraSeconds;
					$loggedHour = $this->convert_time_view($totalSeconds);
					}
				}
			}
			if(empty($loggedHour)){ $loggedHour = "-"; }
			
			// SCHEDULE DATA
			$currentUser = $token['id']; $scheduleLogin = "-";
			if(!empty($scheduleData[$currentUser]['scheduled_login']))
			{
				$scheduleLogin = $scheduleData[$currentUser]['scheduled_login'];
			}
			$dayChecker = !empty($dayChecker) ? $dayChecker : "-";
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["agent_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["office_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["site_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_login);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $is_logout);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $last_logout_date_local);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $loggedHour);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $scheduleLogin);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $dayChecker);

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="User_Status_Report'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	//=============== REQUIRED FUNCTIONS =================================//
	





	public function user_Language_report()
	{
		error_reporting(1);
		ini_set('display_errors', 1);
		$this->db->db_debug=true;
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['location_list'] = $this->Common_model->get_office_location_list();
		$qSql3="select * from master_language where is_active=1";
		$data['language_list'] = $this->Common_model->get_query_result_array($qSql3);
		$data["aside_template"] = "reports_hr/aside.php";
		$data["content_template"] = "reports_hr/report_language.php";
		
		$data['officeSelected'] = $officeSelection = $user_office_id;
		
		if($this->input->get('view') == "Export"){
			$data['langSelected'] = $langSelection = $this->input->get('dept_id');

			if(!empty($this->input->get('office_id'))){
				$data['OfficeSelected'] = $officeSelection = $this->input->get('office_id');
			}
			
			$extraFilter = "";
			if(!empty($officeSelection) && $officeSelection != "ALL"){
				$extraFilter .= " AND s.office_id = '$officeSelection' ";
			}
			if(!empty($langSelection) && $langSelection != "ALL"){
				$extraFilter .= " AND lg.type_of_lan_known LIKE '%$langSelection%' ";
			}
			
			$sqlUsers = "SELECT lg.*,s.*, o.office_name, st.name as site_name, r.name as designation, d.shname as department, 
			            CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor, CONCAT(s.fname, ' ', s.lname) as agent_name from signin as s 
			             LEFT JOIN office_location as o ON o.abbr = s.office_id
			             LEFT JOIN site as st ON st.id = s.site_id
			             LEFT JOIN role as r ON r.id = s.role_id
			             LEFT JOIN department as d ON d.id = s.dept_id
			             LEFT JOIN signin as sl ON sl.id = s.assigned_to
						 LEFT JOIN info_education lg ON lg.user_id = s.id 
						 WHERE 1 $extraFilter
						 ORDER BY s.fname ASC";
			$data['userData'] = $queryUsers = $this->Common_model->get_query_result_array($sqlUsers);
			
			// print_r($queryUsers); exit;
			$this->generate_user_lang_report_xls($queryUsers);
		}
		
		$this->load->view('dashboard', $data);
	}



	public function generate_user_lang_report_xls($userData)
	{
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
			
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('User Language Report');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:Z1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Site");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Language Known");

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
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "USER LANGUAGE REPORT - " .$todayLocalDate);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 12 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 12 ));
		$i = 0;
		
		$currentDate = CurrDate();
		$currentLocalDate = GetLocalDate();
		$currentDateTime = CurrMySqlDate();
		$currentLocalDate = $localDate;
		foreach($userData as $token){
		
			$i++;
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["agent_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["office_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["site_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token["type_of_lan_known"]);

		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="User_Language_Report'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
}

?>