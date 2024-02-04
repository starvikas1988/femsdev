<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    private $aside = "reports/aside.php";
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
					
					//echo "<pre>";
					//print_r($fullArr);
					
					//////////LOG////////
					
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
						$dn_link = base_url()."reports/downloadCsv";
						
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
				
				$data["content_template"] = "reports/rep_main.php";
			    
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
			
			$header = array("Date", "Fusion ID", "Site/XPOID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time (EST)", "Login Time(Local)", "Logout Time (EST)", "Logout Time (Local)", "Logged In Hours (EST)", "Logged In Hours (Local)","Other Break (EST)", "Other Break (Local)", "Lunch/Dinner Break (EST)" ,"Lunch/Dinner Break (Local)", "Disposition (EST)", "Disposition (Local)", "Night Differential (Local)", "Schedule IN", "Schedule OUT", "Comments");		
		
		}else{
				$header = array("Date", "Fusion ID", "Site/XPOID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time ($time_zone)", "Logout Time ($time_zone)", "Logged In Hours ($time_zone)","Other Break ($time_zone)", "Lunch/Dinner Break ($time_zone)" , "Disposition ($time_zone)", "Night Differential", "Schedule IN", "Schedule OUT", "Comments");
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
											
			$row .= '"' . $comments .'"'; 
			
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
	
		
		$header = array("Fusion ID", "Site/XPOID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time (EST)", "Login Time(Local)", "Logout Time (EST)", "Logout Time (Local)", "Logged In Hours", "Night Differential (Local)", "Schedule IN", "Schedule OUT");		
		
		
		
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
			$row .= '"'.$user['sch_out'].'"'; 
						
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
	
	
	public function attrition()
	{
		
		if(check_logged_in())
        {
			$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$start_date="";
			$end_date="";
			$filter_key="";
			$filter_value="";
			$client_id="";
			$site_id="";
			$office_id="";
			$dept_id = "";
			
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				$data["content_template"] = "reports/attrition.php";
			    
				$this->load->model('Common_model');
				
				//$data['department_list'] = $this->Common_model->get_department_list();	
				
				$data['client_list'] = $this->Common_model->get_client_list();				
				$data['location_list'] = $this->Common_model->get_office_location_list();
				
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
								
				if(get_role_dir()=="super" || $is_global_access==1){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
				
				$data['user_list'] =array();
				
				$data['rep_done']="N";
				
				$data['timeframe_days']="";
				$data['year']="";
				$data['avg_days_month']="";
				$data['hired_count']="";
				$data['train_term_count']="";
				$data['nest_term_count']="";
				$data['prod_term_count']="";
				$data['active_count']="";
				$data['prod_term_tenure']="";
				$data['active_tenure']="";
				$data['timeframe_attrition']="";
				$data['active_monthly_attrition']="";
				$data['annualized_attrition']="";
							
				$_atitle="";
				
				if($this->input->post('showReports')=='Show')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						$office_id = $this->input->post('office_id');
						
						//$dept_id = $this->input->post('dept_id');
						//if($dept_id=="")  $dept_id=$ses_dept_id;
				 
						$filterArray = array(
									"start_date" => $start_date,
									"end_date" => $end_date,
									"client_id" => $client_id,
									"office_id" => $office_id,
									"site_id" => $site_id,
									"filter_key" => $filter_key,
									"user_site_id"=> $user_site_id,
							 ); 
							 
						$_cnd="";
						$site_cond="";
						$aof_cond="";
						
						if($filter_key!="" ){
								
							switch(trim($filter_key)){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									$_cnd = " and site_id = '".$filter_value."'";
									//$site_cond = " and id = '".$filter_value."'";
									
									$qSql="Select name as value from  site where id='$filter_value'";
									$_atitle = " - ".$this->Common_model->get_single_value($qSql);
									break;
									
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									$_cnd = " and  (omuid = '".$filter_value."' OR fusion_id='".$filter_value."') ";
									$_atitle = " - Agent-'".$filter_value."'";
									break;
											
								case 'Process':
									$filter_value = $this->input->post('process_id');
									if($filter_value !="0") $_cnd = " and process_id = '".$filter_value."'";
									
									$qSql="Select name as value from  process where id='$filter_value'";
									$_atitle = " - ".$this->Common_model->get_single_value($qSql);
						
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									$_cnd = " and role_id = '".$filter_value."'";
									
									$qSql="Select name as value from  role where id='$filter_value'";
									$_atitle = " - ".$this->Common_model->get_single_value($qSql);
						
									break;
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									$_cnd = " and assigned_to = '".$filter_value."'";
																		
									$qSql="Select CONCAT(fname,' ' ,lname) as value from  signin where id='$filter_value'";
									$_atitle = " - All Agents of ".$this->Common_model->get_single_value($qSql);
									break;	
							}
							
							if($filter_value=="") $filter_value = $this->input->get('filter_value');
										
						}
						
						$filterArray["filter_value"]=$filter_value;
						
						//if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
						if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 						
						else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
						else $filterArray["assigned_to"]="";		
										
						if(get_role_id()>1 && get_role_id()!=6){
							if($user_site_id!="" && $user_site_id!="0" && $user_site_id!="ALL" ) $_cnd .= " and site_id = '".$user_site_id."'";
						}
												
						if($client_id!=="" && $client_id!="ALL")  $_cnd .= " and client_id = '".$client_id."'";
						
						if($client_id=='1'){
							if($site_id!=="" && $site_id!="ALL")  $_cnd .= " and site_id = '".$site_id."'";
						}else{
							if($office_id!=="" && $office_id!="ALL")  $_cnd .= " and office_id = '".$office_id."'";
						}

						//if($dept_id!=="" && $dept_id!="ALL")  $_cnd .= " and dept_id = '".$dept_id."'";
												
											
						$attr_rep_title="Attrition Report ".$_atitle;
						$data['attr_rep_title']=$attr_rep_title;
										
						////////////
					
						//$currDate=CurrDate();
						//$currDate=date('Y-m-d',strtotime($currDate.' -1 day'));
						//echo "Current Date : ".CurrMySqlDate() ."\r\n";
						//echo "Current Date : ".$currDate ."\r\n";
						//echo "Month No: ".getMonthNumber($currDate) ."\r\n";	
						//echo "Year: ". getYear($currDate) ."\r\n";
						//echo "Month day: ". daysInMonth($currDate) ."\r\n";
						//echo "year days: ".daysInYear($year) ."\r\n";			
						//echo dateDiffCount("2016-03-15","2016-03-10");
						////
						
						$all_arr=$this->getAttritionData($filterArray,$_cnd);
						
						$this->createExcelAttrition($all_arr,$filterArray);
												
						//////////LOG////////
		
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download attrition Report with ". $all_params;
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
						
				}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			$data['filter_key']=$filter_key;
			$data['filter_value']=$filter_value;
			
			$data['ses_role_id']=$role_id;
			
			$data['cValue']=$client_id;
			$data['sValue']=$site_id;
			$data['oValue']=$office_id;
			$data['dept_id']=$dept_id;
						
			$data['dn_param']="";
			$data['dn_param2']="";
			$data['download_link']="";				
			$this->load->view('dashboard',$data);
			
	   }
	}
	
	
	
	
	public function sendMonthlyAttrition()
	{

				$cDateYmd=CurrDate();
				$start_date=date('m-01-Y', strtotime($cDateYmd));
				//$end_date =date("m-d-Y",time());
				$end_date=date('m-d-Y',strtotime($cDateYmd.' -1 day'));	
				
				//echo $start_date . " >> ".$end_date ."<br>";
				
				$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"filter_key" => "",
						"client_id" => '1',
						"assigned_to" => "",
						"user_site_id" => "",
						"filter_value" => "",
						"dept_id"=> "",
				 ); 
				 
				//$file_month=strtolower(date('F-Y', strtotime($cDateYmd)));
				//$file_name=$this->createExcelSummary($filterArray,'Y');
				$_cnd="";
				$_cnd = " and client_id = '1";
				
				$all_arr=$this->getAttritionData($filterArray,$_cnd);
										
				$file_name=$this->createExcelAttrition($all_arr,$filterArray,'Y');
				
				//echo "\r\n". $file_name ."\r\n";
				
				if($file_name!="ERROR"){
				
					$file_path =FCPATH."temp_files/attrition/".$file_name;
					
					//echo $file_path;
					
					$uid="";
					
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					
					$from_email="noreply.sox@fusionbposervices.com";
					$from_name="Fusion SOX";
				
					$ecc="";
					$ebody="Hi<br>Please check the attachment files.";
					$esubject="Test Email to Auto Send Attrition Report.";
					
					$email_resp=false;
					
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject,$file_path,$from_email,$from_name);
					if($email_resp==true){
						
						unlink($file_path);
						//$LogMSG="successfully Sent Attrition Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
						
					}else{
					
						$uid="";
						$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
						$ecc="";
						$ebody="Hi<br>Failure to send Attrition Report.";
						$esubject="Failure to Send Attrition Report.";
						
						// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
						//$LogMSG="successfully Sent Attrition Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
					}
					
				}else{
										
					//$LogMSG="Error To Sent Attrition Report of ".$file_month;	
					//log_message('FEMS', ' | '.$LogMSG );
					
					$uid="";
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					$ecc="";
					$ebody="Hi<br>Failure to Export Attrition Report.";
					$esubject="Failure to Export Attrition Report.";
					
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
				}
	}
			
	
	//////
	private function getAttritionData($filterArr,$_cnd)
	{
	
						
			$start_date=$filterArr['start_date'];
			$end_date=$filterArr['end_date'];		
			$filter_key=$filterArr['filter_key'];
			
			
			$stDate=mmddyy2mysql($start_date);
			$enDate=mmddyy2mysql($end_date);
								
			$year=getYear($stDate);
			$avg_days_month=daysInYear($year)/12;
			
			//$stDate=mmddyy2mysql($start_date);
			//$enDate=mmddyy2mysql($end_date);							
			
			$full_timeframe_days=dateDiffCount($stDate,$enDate);
								
			
			if($_cnd=="" ) $qSql="SELECT * FROM site where is_active=1 order by name";
			else $qSql="SELECT * FROM site where id in (SELECT DISTINCT site_id from signin where status=1 $_cnd) order by name";
			
			
			$site_list=$this->Common_model->get_query_result_array($qSql);
			
			$tot_site=count($site_list);
			if($filter_key=="Site" || $tot_site==1) $oatag=0;
			else $oatag=-1;
			
			$all_arr = array();
			
			//foreach($site_list as $sRow){
			for($i=$oatag;$i<$tot_site;$i++){
				
				$proc_arr = array();
				
				if($i==-1){
					$site_name="OVERALL";										
					$site_cond="";
					$site_cond2="";						
				}else{
					$sRow=$site_list[$i];
					$site_id=$sRow['id'];	
					$site_name=$sRow['name'];										
					$site_cond=" and site_id='$site_id'";
					$site_cond2=" where site_id='$site_id' $_cnd";
				}
				//$qSql="SELECT * FROM process  where is_active=1 order by name";
				$qSql="SELECT * from process where id in (SELECT DISTINCT process_id FROM `signin` $site_cond2 ) order by name";			
				$process_list=$this->Common_model->get_query_result_array($qSql);
				
				foreach($process_list as $row){
	
					$week_count_arr = array();
					$weekCnt=0;
					
					$process_id=$row['id'];	
					$process_name=$row['name'];								
					
					//echo $process_name. " (". $process_id .")\r\n";
					//////////
					
					$wStDate=mmddyy2mysql($start_date);
					$wEnDate=mmddyy2mysql($end_date);
					
					$is_overall=false;
												
					while(($wStDate <= $wEnDate) || ($is_overall==true && $weekCnt>1) ){
					
					$count_arr = array();
					
					
					$stDate=$wStDate;
					
					if($is_overall==false){
														
						if(date('D', strtotime($stDate)) == "Sun") $enDate=$stDate;
						else{
							$enDate=date('Y-m-d',strtotime($stDate.' +1 Sunday'));
							
							if($enDate>=$wEnDate){
								$enDate=$wEnDate;
								$is_overall=true;
							}
						}
					
					 $wStDate= date('Y-m-d',strtotime($enDate .' +1 day'));
						
					}else{
						$is_overall=false;
						$stDate=mmddyy2mysql($start_date);
						$enDate=mmddyy2mysql($end_date);
						
					}
					
				//	echo $wStDate . " >> ". $wStDate . " >> "  .$is_overall ."\r\n";
					
			
					$qSql="Select count(id) as value from signin where doj>='$stDate' and doj<='$enDate' and process_id='$process_id' $site_cond $_cnd";
					
					$hired_count=$this->Common_model->get_single_value($qSql);
					
					$qSql="Select count(user_id) as value from terminate_users a, signin b where a.user_id=b.id and role_id='7' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$train_term_count=$this->Common_model->get_single_value($qSql);
					
					$qSql="Select count(user_id) as value from terminate_users a, signin b where a.user_id=b.id and role_id='8' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$nest_term_count=$this->Common_model->get_single_value($qSql);
					
					$qSql="Select count(user_id) as value from terminate_users a, signin b where a.user_id=b.id and role_id='3' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$prod_term_count=$this->Common_model->get_single_value($qSql);
					
					
					// (Total number of Active Agents) - (Any Agent Hired after the last date entered)			
					//$qSql="Select count(id) as value from signin where status=1 and role_id='3' and doj<='$enDate' and process_id='$process_id' $site_cond $_cnd";
					
					// role_id in (3,7,9) 3-> agent ,7->Trainee, 8-> Nesting
					
					$qSql="Select count(id) as value from signin where id not in (Select user_id from terminate_users where cast(terms_date as date)<='$enDate' and is_term_complete='Y' and (rejon_date is null OR rejon_date>'$enDate')) and role_id='3' and status!='9'  and (doj is null OR doj<='$enDate') and process_id='$process_id' $site_cond $_cnd";
					$active_count=$this->Common_model->get_single_value($qSql);
								
					//Prod Term Tenure = average number of days between Hire Date and Term Date for Prod Term agents whose Term Date falls between the 2 Dates.
					
					$qSql="Select AVG(datediff(terms_date,doj)+1) as value from terminate_users a, signin b where a.user_id=b.id and role_id='3' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$prod_term_tenure =$this->Common_model->get_single_value($qSql);
								
					//average the difference between Hire Date and Last Date
					//$qSql="Select AVG(datediff(CONVERT('$enDate',DATE),doj)+1) as value from signin where status=1 and role_id='3' and doj<='$enDate' and process_id='$process_id' $site_cond $_cnd";
					
					$qSql="Select AVG(datediff(CONVERT('$enDate',DATE),doj)+1) as value from signin where id not in (Select user_id from terminate_users where cast(terms_date as date)<='$enDate' and is_term_complete='Y' and (rejon_date is null OR rejon_date>'$enDate')) and role_id='3' and status!='9' and (doj is null OR doj<='$enDate') and process_id='$process_id' $site_cond $_cnd";
					//echo $qSql;
					$active_tenure = $this->Common_model->get_single_value($qSql);
					
					//Attrition during the timeframe
												
					$timeframe_days=dateDiffCount($stDate,$enDate);
					
					$tot_count=$nest_term_count+$prod_term_count+$active_count;
					if($tot_count==0) $timeframe_attrition=0;
					else  $timeframe_attrition=($nest_term_count+$prod_term_count)/$tot_count;
								
					//Active Monthly Attrition = (Nest Term Count + Prod Term Count) / (Active Count + Nest Term Count + Prod Term Count) * (Days between From/To) / 30.42
					
					$active_monthly_attrition = $timeframe_attrition*($timeframe_days/$avg_days_month);
					
					$annualized_attrition = $active_monthly_attrition*12;
					
					if($full_timeframe_days==$timeframe_days && $weekCnt>1) $count_arr['TOTAL']='Y';
					else $count_arr['TOTAL']='N';
					
					$count_arr['Week']="Week-".($weekCnt+1);
					
					$count_arr['stdate']=$stDate;
					$count_arr['endate']=$enDate;
					
					$count_arr['timeframe_days']=$timeframe_days;
					$count_arr['year']=$year;
					$count_arr['avg_days_month']=$avg_days_month;
					
					$count_arr['hired_count']=$hired_count;
					$count_arr['train_term_count']=$train_term_count;
					$count_arr['nest_term_count']=$nest_term_count;
					$count_arr['prod_term_count']=$prod_term_count;
					$count_arr['active_count']=$active_count;
					$count_arr['prod_term_tenure']=round($prod_term_tenure,2);
					$count_arr['active_tenure']=round($active_tenure,2);
					$count_arr['timeframe_attrition']=$timeframe_attrition;
					$count_arr['active_monthly_attrition']=$active_monthly_attrition;
					$count_arr['annualized_attrition']=$annualized_attrition;
					//$process_name
					
					$week_count_arr[$weekCnt++]=$count_arr;
					
					}//week
					
					$proc_arr[$process_name]=$week_count_arr;
												
				} //process
				
				//////
				$all_arr[$site_name]=$proc_arr;
			} //site
			
			//$data['all_list']=$all_arr;
			//$data['rep_done']="Y";
			//print_r($all_arr);
						
			return $all_arr;
			
	}
	
	
	
	private function createExcelAttrition($all_list,$filterArr,$is_monthly='N')
	{
		
			$start_date =$filterArr['start_date'];
			$end_date =$filterArr['end_date'];		
			$filter_key =$filterArr['filter_key'];
			$assigned_to=$filterArr['assigned_to'];
			$user_site_id =$filterArr['user_site_id'];
			
			$client_id=$filterArr['client_id'];
			$client_name="";
			if($client_id!=="" && $client_id!="ALL"){
				$client_name="-".$this->Common_model->get_single_value("Select shname as value from  client where id='$client_id'");
			}
			
			
			$stDate=mmddyy2mysql($start_date);
			$enDate=mmddyy2mysql($end_date);
								
			$year=getYear($stDate);
			$avg_days_month=daysInYear($year)/12;
			
			//$stDate=mmddyy2mysql($start_date);
			//$enDate=mmddyy2mysql($end_date);
			
			$timeframe_days=dateDiffCount($stDate,$enDate);
			
			
			$filter_value="";
			$_atitle="";
			
			if($filter_key!=""){
			
				$filter_value =$filterArr['filter_value'];
				
				switch($filter_key){
					case 'Site':
						
						$qSql="Select name as value from  site where id='$filter_value'";
						$_atitle = " - All Agents in ".$this->Common_model->get_single_value($qSql);
					
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
						
			$start_date =str_replace("/","-",$start_date);
			$end_date =str_replace("/","-",$end_date);
			
			if($_atitle=="") $_atitle = " - All Agents";
			
			if($is_monthly!="Y"){
				
				$fn="attrition".$client_name.'-'.$start_date."_".$end_date.$_atitle.".xls";
				//$filename = "./assets/reports/".$fn;
			}else{
				$file_name="attrition".$client_name.'_'.strtolower(date('F', strtotime($stDate)));
				$fn=$file_name."_".$stDate."_".$enDate.".xls";
			}
			
			$filename =FCPATH."temp_files/attrition/".$fn;
			
			$sht_title=$start_date." To ".$end_date;
			
			
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
			
			$style_header_left = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'00008B'),
				),
				'font' => array(
					'bold' => true,
					'size' => 11,
					'color' => array('rgb'=>'FFFFFF'),
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
			
			$style_def_left = array(
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			/*
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
			*/
			//'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
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
			
			//$todayDate=CurrDate();
			//$stDate=mmddyy2mysql($start_date);
			//$enDate=mmddyy2mysql($end_date);
			//$dayDiff=dateDiffCount($stDate,$enDate);
			
			$shCnt=0;
			
			foreach ($all_list as $key => $proc_arr){
				
				
				$sht_title=$key;
				$title="Attrition Report From ". $start_date." To ".$end_date. $_atitle ." - ". $key;
				
								
				if($shCnt > 0) $this->excel->createSheet();
				$this->excel->setActiveSheetIndex($shCnt);
				$shCnt++;
				
				

				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				//merge cell A1 until D1
				$this->excel->getActiveSheet()->mergeCells('A1:L1');
				
				$r=3;
								
				$this->excel->getActiveSheet()->setCellValue('A'.$r, 'Formula Applied');
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$this->excel->getActiveSheet()->getStyle('A'.$r.':L'.$r)->applyFromArray($style_header_left);
				$r++;
				
				$txt="Train Term Count = a count of the number of agents with a Term Date tha falls on or between the dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Nest Term Count = a count of the number of agents with a Term Date tha falls on or between the dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Prod Term Count= a count of the number of agents with a Term Date tha falls on or between the dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Count = (Total number of Active Agents) - (Any Agent Hired after the last date entered).";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Hired Count = a count of the number of agents with a Hire Date between the 2 dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				
				$txt="Prod Term Tenure = average number of days between Hire Date and Term Date for Prod Term Agents.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Tenure = average number of days between Hire Date and the LAST DATE antered  for Active Count Agents.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Timeframe Attrition = (Nest Term Count + Prod Term Count) / (Active Count + Nest Term Count + Prod Term Count)";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Monthly Attrition = Active Timeframe Attrition * ((Days Entered Timeframe) / Days in a month)";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Annualized Attrition = Active Monthly Attrition * 12";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				
				$r+=3;
				
				$this->excel->getActiveSheet()->setCellValue('A'.$r, 'Date Range');
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('B'.$r, 'Days Timeframe');
				$this->excel->getActiveSheet()->getStyle('B'.$r)->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('C'.$r, 'Days in a month');
				$this->excel->getActiveSheet()->getStyle('C'.$r)->applyFromArray($style_header);
				$r++;
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $start_date." - " . $end_date);
				$this->excel->getActiveSheet()->setCellValue('B'.$r, $timeframe_days);
				$this->excel->getActiveSheet()->setCellValue('C'.$r, $avg_days_month);
								
				$r+=2;
				
				////////////////////////////				
				foreach ($proc_arr as $key => $week_arr){
				
					$r++;
					$cell=$letters[0].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $key);
					//$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_def );
					
					$this->excel->getActiveSheet()->getStyle($cell)->getFont()->setSize(12);
					//make the font become bold
					$this->excel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
					//merge cell A1 until D1
					$this->excel->getActiveSheet()->mergeCells('A'.$r.':J'.$r);
					
					$j=0;
					$r++;
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Weeks');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Date Range');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Days Timeframe');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Hired Count');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Train Term');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Nest Term');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Prod Term');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Count');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Prod Term Tenure');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Tenure');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Timeframe Attrition');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Monthly Attrition');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Annualized Attrition');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						
					//foreach ($week_arr as $key => $value){
					  foreach($week_arr as $value){
					  
						$j=0;
						$r++;
						
						$bg_style=$style_def;
						$weeknm=$value['Week'];
						
						if($value['TOTAL']=='Y'){
							$bg_style=$style_sum;
							$weeknm="Overall";
						}
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $weeknm);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['stdate'] .' - ' .$value['endate']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['timeframe_days']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['hired_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['train_term_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['nest_term_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['prod_term_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['active_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['prod_term_tenure']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['active_tenure']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['timeframe_attrition']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['active_monthly_attrition']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['annualized_attrition']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					
					}
					$r++;
				
				}
				
			}
			
			if($is_monthly!="Y"){
				header('Content-Type: application/vnd.ms-excel'); //mime type
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
												
				header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
			}		 
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			if($is_monthly!="Y"){
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
			}else{
				$objWriter->save($filename);
				return $fn;
			}
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
		$data["content_template"] = "reports/rep_terms.php";
		
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
				
			$dn_link = base_url()."reports/user_termCSV";
			
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
		$header = array("Fusion ID", "OM ID/XPOID", "Agent Name", "Site", "Process", "Role", "Ticket No", "Ticket Time", "Time Diff", "LWD", "Terms By", "Terms Date", "Terms Approved By", "Terms Approved Date", "User Phase", "Comments");
		
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
			$row .= '"'.$omuid.'",';  
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
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
		$data["content_template"] = "reports/cancel_term_req.php";
		
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/resign_report.php";
			
			
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
					
				$dn_link = base_url()."reports/downloadResignCsv";
					
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
		$header = array("Name", "Fusion ID", "XPOID", "OMUID", "Role", "Location", "Resign Date", "Released Date", "LWD", "Email", "Phone", "User Reason", "User Remarks", "Current Resign Date/Time", "Approved By", "Approved Remarks", "Approved Date/Time", "Approved Released Date", "HR Accepted By", "Accepted Date/Time", "Accepted Released Date", "Status", "Phase");
		
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
		
			$row = '"'.$user['name'].'",'; 
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['xpoid'].'",';
			$row .= '"'.$user['omuid'].'",';
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
		$data["content_template"] = "reports/rep_history.php";
		
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
			$dn_link = base_url()."reports/downloadCsv_2";
								
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/requisition_report.php";
			
			
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
					
				$dn_link = base_url()."reports/downloadRequisitionCsv";
					
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/candidate_report.php";
			
			
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
					
				$dn_link = base_url()."reports/downloadCandidateCsv";
					
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/candidate_interview_report.php";
			
			
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
					
				$dn_link = base_url()."reports/downloadCandidateInterviewCsv";
					
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
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/user_referral_report.php";
			
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
					
				$dn_link = base_url()."reports/downloadUserReferral";
					
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
	
	
///////////////////////////////////////////////////////////////////////////////////////////////	
/*-------------------Policy Acceptance-----------------------------*/	
	
	public function policy_acceptance_report_list(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$user_oth_office=get_user_oth_office();
			
			$ofc_id=="";
			if($user_oth_office!="") $ofc_id = "'".implode("','",explode(",",$user_oth_office))."'";
			
						
			$inOffice = "'".$user_office_id."'";
			if($ofc_id!="") $inOffice = $inOffice.",".$ofc_id;
						
			if(isDisableFusionPolicy()== false) $inOffice = "'ALL',".$inOffice;
				
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/policy_acceptance_report.php";
			
			$policy_id="";
			$action="";
			$dn_link="";
			
			if($is_global_access==1){
				$qSql="Select id, title ,office_id from policy_list where is_active=1 order by office_id ";
				$data['get_title'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				
				$qSql="Select id, title,office_id from policy_list where office_id in ($inOffice) and is_active=1 order by office_id ";
				//echo $qSql;
				$data['get_title'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["policy_acceptance_list"] = array();
			
			$policy_id = $this->input->get('policy_id');
			
			$qSql="Select title from policy_list where id='$policy_id'";
			$data['policy_title'] = $this->Common_model->get_query_result_array($qSql);
			
			
			if($this->input->get('show')=='Show')
			{
				
				$field_array = array(
						"policy_id" => $policy_id,
					);
			
				$fullAray = $this->reports_model->get_policy_acceptance_report($field_array);
				$data["policy_acceptance_list"] = $fullAray;
				
				$this->create_policyAcceptance_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadpolicyAcceptance";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['policy_id'] = $policy_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadpolicyAcceptance()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="policy_acceptance_report-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_policyAcceptance_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Title", "Accepted By", "Fusion ID", "XPOID", "OMUID", "Location", "Designation", "Acceptance Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['policy_titile'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['userRoleName'].'",'; 
			$row .= '"'.$user['accptdate'].'",'; 
			
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
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/process_update_acceptance_report.php";
			
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
					
				$dn_link = base_url()."reports/downloadprocessUpdateAcceptance";
					
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
		$header = array("Title", "Accepted By", "Fusion ID", "XPOID", "OMUID", "Location", "Client", "Process", "Acceptance Date");
		
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
			$row .= '"'.$user['omuid'].'",';  
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/change_user_password_report.php";
			
			
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
					
				$dn_link = base_url()."reports/download_is_updateCsv";
					
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/generate_bank_details.php";
			
			
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
				$dn_link = base_url()."reports/download_bank_csv/".$office_id;
					
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
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/fems_user_certification.php";
			
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
					$dn_link = base_url()."reports/download_user_certificationCsv";
					
					
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/generate_dfr_candidate_details.php";
			
			
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
					
				$dn_link = base_url()."reports/download_dfr_candidate_csv/".$office_id;
					
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/user_process_update_list.php";
			
			
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/add_referrals_report.php";
			
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
					
				$dn_link = base_url()."reports/download_add_referralCSV";
					
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
		$header = array("Name", "Location", "Phone", "Email", "Added By", "Fusion ID", "Added Date", "Comment");
		
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/fems_master_database.php";
			
			
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
			
			$objWorksheet->getStyle("A1:BE1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A1:BD1")->getFill()->applyFromArray(
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
					
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/user_break_stats.php";
			
			
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
					
				$dn_link = base_url()."reports/user_break_statsCSV";
					
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/dfr_candidate_history_list.php";
			
			
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
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/dfr_day_summ.php";
			
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
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/generate_bank_status.php";
			
			
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
				$dn_link = base_url()."reports/download_bank_csv/".$office_id;
					
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
	
	
	
	public function ijpapplntemp(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
						
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/ijpappln_temp.php";
			$office_id=$user_office_id;
			
			$cond .=" and location='$office_id'";
			
			$qSql="	SELECT i.*, s.fname, s.lname, s.fusion_id, s.xpoid, s.doj, get_client_names(i.user_id) AS client_name, get_process_names(i.user_id) AS process_name, d.shname AS dept_name, r.name as role_name FROM ijp_application_temp i
			LEFT JOIN signin s ON s.id=i.user_id
			LEFT JOIN department d ON d.id=s.dept_id
			LEFT JOIN role r ON r.id=s.role_id order by app_post ";
		
			$query = $this->db->query($qSql);
			$data["appln_list"] = $fullAray = $query->result_array();
			$this->Create_IJPApplnTemp_CSV($fullAray);
			
			$download_link = base_url()."reports/downloadIjpApplnCsv";
			$data["download_link"] =	$download_link;
			
			$this->load->view('dashboard',$data);
		
		}
	}
	
	
	public function downloadIjpApplnCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/IjpReport".get_user_id().".csv";
		$newfile="IjpReport-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
		
	public function Create_IJPApplnTemp_CSV($rr)
	{
		$filename = "./assets/reports/IjpReport".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("SL", "Post Applied", "Fusion ID", "XPOID", "Candidate Name", "Dept", "Designation", "Client", "Process", "DOJ", "phone", "Email","Appln. Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$cnt=1;
		foreach($rr as $user)
		{	
			$row = '"'.$cnt++.'",'; 
			$row .= '"'.$user['app_post'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['doj'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['email_id'].'",'; 
			$row .= '"'.$user['added_time'].'"'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
///////////////////////////////////////////////////////////////////////////
	
/*------------------QA OYO Report-----------------------------*/	
	public function qa_oyo_report(){
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
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/qa_oyo_report.php";
			
			
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$lob = trim($this->input->get('lob'));
			
			
			$data['pValue']=$pValue;
			$data['lob']=$lob;
			
			
			
			$data["qa_oyo_list"] = array();
			
			/* if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			} */
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"process_id" => $pValue,
						"lob" => $lob,
						"current_user" => $current_user
					);
					
				
				if($pValue=='OYO IBD'){
					$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
					$data["qa_oyo_list"] = $fullAray;
					$this->create_qa_oyo_ibd_CSV($fullAray);	
					$dn_link = base_url()."reports/download_qa_oyo_ibd_CSV";
				
				}else if($pValue=='OYO SIG'){
					
					$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
					$data["qa_oyo_list"] = $fullAray;
					$this->create_qa_oyo_sig_CSV($fullAray);	
					$dn_link = base_url()."reports/download_qa_oyo_sig_CSV";
					
				}else if($pValue=='OYO LIFE'){
					
					if($lob=='IB/OB'){
						$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
						$data["qa_oyo_list"] = $fullAray;
						$this->create_qa_oyolife_ibob_CSV($fullAray);	
						$dn_link = base_url()."reports/download_qa_oyolife_ibob_CSV";
					}else{
						$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
						$data["qa_oyo_list"] = $fullAray;
						$this->create_qa_oyolife_followup_CSV($fullAray,$lob);	
						$dn_link = base_url()."reports/download_qa_oyolife_followup_CSV/".$lob;
					}
				
				}else if($pValue=='Social Media RCA'){
					
					$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
					$data["qa_oyo_list"] = $fullAray;
					$this->create_qa_oyo_sme_rca_CSV($fullAray);	
					$dn_link = base_url()."reports/download_qa_oyo_sme_rca_CSV";
					
				}else if($pValue=='UK/US'){
					
					$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
					$data["qa_oyo_list"] = $fullAray;
					$this->create_qa_oyo_uk_us_CSV($fullAray);	
					$dn_link = base_url()."reports/download_qa_oyo_uk_us_CSV";
				
				}else if($pValue=='OYOINB'){
					
					$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
					$data["qa_oyo_list"] = $fullAray;
					$this->create_qa_oyoinb_new_CSV($fullAray);	
					$dn_link = base_url()."reports/download_qa_oyoinb_new_CSV";
					
				}else if($pValue=='OYO SIG New'){
					
					$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
					$data["qa_oyo_list"] = $fullAray;
					$this->create_qa_oyosig_new_CSV($fullAray);	
					$dn_link = base_url()."reports/download_qa_oyosig_new_CSV";
				
				}else{
				
					$fullAray = $this->reports_model->qa_oyo_report_model($field_array);
					$data["qa_oyo_list"] = $fullAray;
					$this->create_qa_oyo_dsat_rcasig_CSV($fullAray);	
					$dn_link = base_url()."reports/download_qa_oyo_dsat_rcasig_CSV";
				
				}
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	

/*---------OYO IBD CSS Part Start-----------*/	
	public function download_qa_oyo_ibd_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA OYO International List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_oyo_ibd_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Agent Name", "L1 Supervisor", "Phone", "Call Duration", "Recorded Date Time", "Mail ID", "Booking ID", "Audit Date", "Auditor Name", "Call Type", "Campiagn", "opening and Branding", "Acknowledgment", "Personalization", "Verification Process", "Politeness", "Empathy", "Overlapping", "Relevant Probing", "Enthusiasm", "Switch Language", "Voice Clarity", "Intonation", "Grammar", "Transfer", "Dead Air", "Complaint", "Selling Efforts", "Rebuttals", "USPS", " Payment Confirmation", "Retention", "Ownership", "Disclosure", "CRS", "Adherence", "Summarization", "IVR", "Further Assistance", "Closing", "Overall Result", "Overall Score","Call Summary", "Feedback", "Infraction Stat", "Remarks", "Agent Review Date", "Agent Review Comment", "Mgnt Review Date", "Mgnt Review Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['agent_name'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['agent_phone'].'",'; 
			$row .= '"'.$user['call_duration'].'",'; 
			$row .= '"'.$user['record_date_time'].'",'; 
			$row .= '"'.$user['mail_id'].'",'; 
			$row .= '"'.$user['booking_id'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['call_type'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['opening_and_branding'].'",'; 
			$row .= '"'.$user['acknowledgement'].'",'; 
			$row .= '"'.$user['personalization'].'",'; 
			$row .= '"'.$user['verification_process'].'",'; 
			$row .= '"'.$user['politeness'].'",'; 
			$row .= '"'.$user['empathy'].'",'; 
			$row .= '"'.$user['overlapping'].'",'; 
			$row .= '"'.$user['relevant_probing'].'",'; 
			$row .= '"'.$user['enthusiasm'].'",'; 
			$row .= '"'.$user['switch_language'].'",'; 
			$row .= '"'.$user['voice_clarity'].'",'; 
			$row .= '"'.$user['intonation'].'",'; 
			$row .= '"'.$user['grammar'].'",'; 
			$row .= '"'.$user['transfer'].'",'; 
			$row .= '"'.$user['dead_air'].'",'; 
			$row .= '"'.$user['complaint'].'",'; 
			$row .= '"'.$user['selling_efforts'].'",'; 
			$row .= '"'.$user['rebuttals'].'",'; 
			$row .= '"'.$user['usps'].'",'; 
			$row .= '"'.$user['payment_confirmation'].'",'; 
			$row .= '"'.$user['retention'].'",'; 
			$row .= '"'.$user['ownership'].'",'; 
			$row .= '"'.$user['disclosure'].'",'; 
			$row .= '"'.$user['crs'].'",'; 
			$row .= '"'.$user['adherence'].'",'; 
			$row .= '"'.$user['summarization'].'",'; 
			$row .= '"'.$user['ivr'].'",'; 
			$row .= '"'.$user['further_assistance'].'",'; 
			$row .= '"'.$user['closing'].'",'; 
			$row .= '"'.$user['overall_result'].'",'; 
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['infraction_stat'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_type'])).'",';
			$row .= '"'.$user['agent_rvw_dt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw'])).'",';
			$row .= '"'.$user['mgnt_rvw_dt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw'])).'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	

	
/*----------------OYO SIG CSS Part Start--------------------*/	
	public function download_qa_oyo_sig_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA OYO SIG List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_oyo_sig_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Agent Name", "Tenurity", "Batch Code", "C-zentrix", "L1 Supervisor", "Call Duration", "Recorded Date Time", "Booking ID", "Audit Date", "Auditor Name", "Call Type", "Ticket ID", "Phone", "Campaign", "Audit Type", "VOC", "Overall Score", "Overall Result", "Call Summary", "Feedback", "call Open 5sec", "call Open Self Intro", "call Open Score", "Probing Issue Indetify", "Probing Responce Positively", "Probing Effective", "Probing Score", "Soft Skill Apology", "Soft Skill Voice Intonation", "Soft Skill Active Listening", "Soft Skill Confidence", "Soft Skill Politeness", "Soft Skill Grammar", "Soft Skill Acknowledgment", "Soft Skill Score", "Hold Dead Ask Permission", "Hold Dead Unhold Procedure", "Hold Dead Took Guest Permission *", "Hold Dead do not Refresh *", "Hold Dead avoid Dead Air", "Hold Dead Score", "Resolution Fatal Correct Booking *", "Resolution Fatal Correct Information *", "Resolution Fatal Correct Refund *", "Resolution Fatal Proper Follow up *", "Resolution Fatal Recon Adjustment *", "Resolution Fatal Score", "Resolution Nonfatal gnc Closure", "Resolution Nonfatal Duplicate Ticket", "Resolution Nonfatal ccb Process", "Resolution Nonfatal case Library", "Resolution Nonfatal Email to Sent", "Resolution Nonfatal Score", "Fresh Desk Complete Notes", "Fresh Desk Tagging Issue *", "Fresh Desk Incorrect Shifting *", "Fresh Desk Correct Ticket Status *", "Fresh Desk did Agent Verify *", "Fresh Desk Agent meet Compliant *", "Fresh Desk Score", "Closing Further Assistance", "Closing Done Branding", "Closing G-sat Survey Pitched", "Closing G-sat Survey Avoidance *", "OYO Assist Pitch", "Closing Score", "Wow Factor Call Take Positive", "Agent Review Date", "Agent Comment", "Management Review Date", "Management Comment", "Coach Name");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['cl_open_5_sec']==2) $cl_open_5_sec='Pass';
			else if($user['cl_open_5_sec']==2.1) $cl_open_5_sec='N/A';
			else $cl_open_5_sec='Fail';
			
			if($user['cl_open_self_intro']==2) $cl_open_self_intro='Pass';
			else if($user['cl_open_self_intro']==2.1) $cl_open_self_intro='N/A';
			else $cl_open_self_intro='Fail';
			
			if($user['probing_issue_indetify']==2) $probing_issue_indetify='Pass';
			else if($user['probing_issue_indetify']==2.1) $probing_issue_indetify='N/A';
			else $probing_issue_indetify='Fail';
			
			if($user['probing_responce_positively']==2) $probing_responce_positively='Pass';
			else if($user['probing_responce_positively']==2.1) $probing_responce_positively='N/A';
			else $probing_responce_positively='Fail';
			
			if($user['probing_effective']==2) $probing_effective='Pass';
			else if($user['probing_effective']==2.1) $probing_effective='N/A';
			else $probing_effective='Fail';
			
			if($user['soft_skill_apology']==3) $soft_skill_apology='Pass';
			else if($user['soft_skill_apology']==3.1) $soft_skill_apology='N/A';
			else $soft_skill_apology='Fail';
			
			if($user['soft_skill_voice_intonation']==1) $soft_skill_voice_intonation='Pass';
			else if($user['soft_skill_voice_intonation']==1.1) $soft_skill_voice_intonation='N/A';
			else $soft_skill_voice_intonation='Fail';
			
			if($user['soft_skill_active_listening']==3) $soft_skill_active_listening='Pass';
			else if($user['soft_skill_active_listening']==3.1) $soft_skill_active_listening='N/A';
			else $soft_skill_active_listening='Fail';
			
			if($user['soft_skill_confidence']==2) $soft_skill_confidence='Pass';
			else if($user['soft_skill_confidence']==2.1) $soft_skill_confidence='N/A';
			else $soft_skill_confidence='Fail';
			
			if($user['soft_skill_politeness']==2) $soft_skill_politeness='Pass';
			else if($user['soft_skill_politeness']==2.1) $soft_skill_politeness='N/A';
			else $soft_skill_politeness='Fail';
			
			if($user['soft_skill_grammar']==2) $soft_skill_grammar='Pass';
			else if($user['soft_skill_grammar']==2.1) $soft_skill_grammar='N/A';
			else $soft_skill_grammar='Fail';
			
			if($user['soft_skill_acknowledgement']==2) $soft_skill_acknowledgement='Pass';
			else if($user['soft_skill_acknowledgement']==2.1) $soft_skill_acknowledgement='N/A';
			else $soft_skill_acknowledgement='Fail';
			
			if($user['hold_dead_ask_permission']==2) $hold_dead_ask_permission='Pass';
			else if($user['hold_dead_ask_permission']==2.1) $hold_dead_ask_permission='N/A';
			else $hold_dead_ask_permission='Fail';
			
			if($user['hold_dead_unhold_procedure']==2) $hold_dead_unhold_procedure='Pass';
			else if($user['hold_dead_unhold_procedure']==2.1) $hold_dead_unhold_procedure='N/A';
			else $hold_dead_unhold_procedure='Fail';
			
			if($user['hold_dead_took_guest_permission']==2) $hold_dead_took_guest_permission='Pass';
			else if($user['hold_dead_took_guest_permission']==2.1) $hold_dead_took_guest_permission='N/A';
			else $hold_dead_took_guest_permission='Fail';
			
			if($user['hold_dead_do_not_refresh']==2) $hold_dead_do_not_refresh='Pass';
			else if($user['hold_dead_do_not_refresh']==2.1) $hold_dead_do_not_refresh='N/A';
			else $hold_dead_do_not_refresh='Fail';
			
			if($user['hold_dead_avoid_dead_air']==2) $hold_dead_avoid_dead_air='Pass';
			else if($user['hold_dead_avoid_dead_air']==2.1) $hold_dead_avoid_dead_air='N/A';
			else $hold_dead_avoid_dead_air='Fail';
			
			if($user['resolution_fatal_correct_booking']==3) $resolution_fatal_correct_booking='Pass';
			else if($user['resolution_fatal_correct_booking']==3.1) $resolution_fatal_correct_booking='N/A';
			else $resolution_fatal_correct_booking='Fail';
			
			if($user['resolution_fatal_correct_information']==3) $resolution_fatal_correct_information='Pass';
			else if($user['resolution_fatal_correct_information']==3.1) $resolution_fatal_correct_information='N/A';
			else $resolution_fatal_correct_information='Fail';
			
			if($user['resolution_fatal_correct_refund']==3) $resolution_fatal_correct_refund='Pass';
			else if($user['resolution_fatal_correct_refund']==3.1) $resolution_fatal_correct_refund='N/A';
			else $resolution_fatal_correct_refund='Fail';
			
			if($user['resolution_fatal_proper_follow_up']==3) $resolution_fatal_proper_follow_up='Pass';
			else if($user['resolution_fatal_proper_follow_up']==3.1) $resolution_fatal_proper_follow_up='N/A';
			else $resolution_fatal_proper_follow_up='Fail';
			
			if($user['resolution_fatal_recon_adjustment']==3) $resolution_fatal_recon_adjustment='Pass';
			else if($user['resolution_fatal_recon_adjustment']==3.1) $resolution_fatal_recon_adjustment='N/A';
			else $resolution_fatal_recon_adjustment='Fail';
			
			if($user['resolution_nonfatal_gnc_closure']==3) $resolution_nonfatal_gnc_closure='Pass';
			else if($user['resolution_nonfatal_gnc_closure']==3.1) $resolution_nonfatal_gnc_closure='N/A';
			else $resolution_nonfatal_gnc_closure='Fail';
			
			if($user['resolution_nonfatal_gnc_closure']==3) $resolution_nonfatal_gnc_closure='Pass';
			else if($user['resolution_nonfatal_gnc_closure']==3.1) $resolution_nonfatal_gnc_closure='N/A';
			else $resolution_nonfatal_gnc_closure='Fail';
			
			if($user['resolution_nonfatal_duplicate_ticket']==3) $resolution_nonfatal_duplicate_ticket='Pass';
			else if($user['resolution_nonfatal_duplicate_ticket']==3.1) $resolution_nonfatal_duplicate_ticket='N/A';
			else $resolution_nonfatal_duplicate_ticket='Fail';
			
			if($user['resolution_nonfatal_ccb_process']==2) $resolution_nonfatal_ccb_process='Pass';
			else if($user['resolution_nonfatal_ccb_process']==2.1) $resolution_nonfatal_ccb_process='N/A';
			else $resolution_nonfatal_ccb_process='Fail';
			
			if($user['resolution_nonfatal_case_library']==4) $resolution_nonfatal_case_library='Pass';
			else if($user['resolution_nonfatal_case_library']==4.1) $resolution_nonfatal_case_library='N/A';
			else $resolution_nonfatal_case_library='Fail';
			
			if($user['resolution_nonfatal_email_to_sent']==4) $resolution_nonfatal_email_to_sent='Pass';
			else if($user['resolution_nonfatal_email_to_sent']==4.1) $resolution_nonfatal_email_to_sent='N/A';
			else $resolution_nonfatal_email_to_sent='Fail';
			
			if($user['fresh_desk_complete_notes']==6) $fresh_desk_complete_notes='Pass';
			else if($user['fresh_desk_complete_notes']==6.1) $fresh_desk_complete_notes='N/A';
			else $fresh_desk_complete_notes='Fail';
			
			if($user['fresh_desk_tagging_issue']==4) $fresh_desk_tagging_issue='Pass';
			else if($user['fresh_desk_tagging_issue']==4.1) $fresh_desk_tagging_issue='N/A';
			else $fresh_desk_tagging_issue='Fail';
			
			if($user['fresh_desk_incorrect_shifting']==3) $fresh_desk_incorrect_shifting='Pass';
			else if($user['fresh_desk_incorrect_shifting']==3.1) $fresh_desk_incorrect_shifting='N/A';
			else $fresh_desk_incorrect_shifting='Fail';
			
			if($user['fresh_desk_correct_ticket_status']==4) $fresh_desk_correct_ticket_status='Pass';
			else if($user['fresh_desk_correct_ticket_status']==4.1) $fresh_desk_correct_ticket_status='N/A';
			else $fresh_desk_correct_ticket_status='Fail';
			
			if($user['fresh_desk_did_agent_verify']==2) $fresh_desk_did_agent_verify='Pass';
			else if($user['fresh_desk_did_agent_verify']==2.1) $fresh_desk_did_agent_verify='N/A';
			else $fresh_desk_did_agent_verify='Fail';
			
			if($user['fresh_desk_agent_meet_compliant']==3) $fresh_desk_agent_meet_compliant='Pass';
			else if($user['fresh_desk_agent_meet_compliant']==3.1) $fresh_desk_agent_meet_compliant='N/A';
			else $fresh_desk_agent_meet_compliant='Fail';
			
			if($user['closing_further_assistance']==2) $closing_further_assistance='Pass';
			else if($user['closing_further_assistance']==2.1) $closing_further_assistance='N/A';
			else $closing_further_assistance='Fail';
			
			if($user['closing_done_branding']==2) $closing_done_branding='Pass';
			else if($user['closing_done_branding']==2.1) $closing_done_branding='N/A';
			else $closing_done_branding='Fail';
			
			if($user['closing_gsat_survey_pitched']==4) $closing_gsat_survey_pitched='Pass';
			else if($user['closing_gsat_survey_pitched']==4.1) $closing_gsat_survey_pitched='N/A';
			else $closing_gsat_survey_pitched='Fail';
			
			if($user['closing_gsat_survey_avoidance']==2) $closing_gsat_survey_avoidance='Pass';
			else if($user['closing_gsat_survey_avoidance']==2.1) $closing_gsat_survey_avoidance='N/A';
			else $closing_gsat_survey_avoidance='Fail';
			
			if($user['oyo_assist_pitch']==2) $oyo_assist_pitch='Pass';
			else if($user['oyo_assist_pitch']==2.1) $oyo_assist_pitch='N/A';
			else $oyo_assist_pitch='Fail';
			
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['agent_name'].'",'; 
			$row .= '"'.$user['tenurity'].'",'; 
			$row .= '"'.$user['batch_code'].'",'; 
			$row .= '"'.$user['czentrix'].'",';
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['call_duration'].'",'; 
			$row .= '"'.$user['record_date_time'].'",';
			$row .= '"'.$user['booking_id'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['call_type'].'",'; 
			$row .= '"'.$user['ticket_id'].'",'; 
			$row .= '"'.$user['guest_phone'].'",'; 
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'.$user['overall_result'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$cl_open_5_sec.'",'; 
			$row .= '"'.$cl_open_self_intro.'",'; 
			$row .= '"'.$user['cl_open_overall_score'].'",'; 
			$row .= '"'.$probing_issue_indetify.'",'; 
			$row .= '"'.$probing_responce_positively.'",'; 
			$row .= '"'.$probing_effective.'",'; 
			$row .= '"'.$user['probing_overall_score'].'",'; 
			$row .= '"'.$soft_skill_apology.'",'; 
			$row .= '"'.$soft_skill_voice_intonation.'",'; 
			$row .= '"'.$soft_skill_active_listening.'",'; 
			$row .= '"'.$soft_skill_confidence.'",'; 
			$row .= '"'.$soft_skill_politeness.'",'; 
			$row .= '"'.$soft_skill_grammar.'",'; 
			$row .= '"'.$soft_skill_acknowledgement.'",'; 
			$row .= '"'.$user['soft_skill_overall_score'].'",'; 
			$row .= '"'.$hold_dead_ask_permission.'",'; 
			$row .= '"'.$hold_dead_unhold_procedure.'",'; 
			$row .= '"'.$hold_dead_took_guest_permission.'",'; 
			$row .= '"'.$hold_dead_do_not_refresh.'",'; 
			$row .= '"'.$hold_dead_avoid_dead_air.'",'; 
			$row .= '"'.$user['hold_dead_overall_score'].'",'; 
			$row .= '"'.$resolution_fatal_correct_booking.'",'; 
			$row .= '"'.$resolution_fatal_correct_information.'",'; 
			$row .= '"'.$resolution_fatal_correct_refund.'",'; 
			$row .= '"'.$resolution_fatal_proper_follow_up.'",'; 
			$row .= '"'.$resolution_fatal_recon_adjustment.'",'; 
			$row .= '"'.$user['resolution_fatal_overall_score'].'",'; 
			$row .= '"'.$resolution_nonfatal_gnc_closure.'",'; 
			$row .= '"'.$resolution_nonfatal_duplicate_ticket.'",'; 
			$row .= '"'.$resolution_nonfatal_ccb_process.'",'; 
			$row .= '"'.$resolution_nonfatal_case_library.'",'; 
			$row .= '"'.$resolution_nonfatal_email_to_sent.'",'; 
			$row .= '"'.$user['resolution_nonfatal_overall_score'].'",'; 
			$row .= '"'.$fresh_desk_complete_notes.'",'; 
			$row .= '"'.$fresh_desk_tagging_issue.'",'; 
			$row .= '"'.$fresh_desk_incorrect_shifting.'",'; 
			$row .= '"'.$fresh_desk_correct_ticket_status.'",'; 
			$row .= '"'.$fresh_desk_did_agent_verify.'",'; 
			$row .= '"'.$fresh_desk_agent_meet_compliant.'",'; 
			$row .= '"'.$user['fresh_desk_overall_score'].'",'; 
			$row .= '"'.$closing_further_assistance.'",'; 
			$row .= '"'.$closing_done_branding.'",'; 
			$row .= '"'.$closing_gsat_survey_pitched.'",'; 
			$row .= '"'.$closing_gsat_survey_avoidance.'",'; 
			$row .= '"'.$oyo_assist_pitch.'",'; 
			$row .= '"'.$user['closing_overall_score'].'",'; 
			$row .= '"'.$user['wow_factor_cl_take_positive'].'",';
			$row .= '"'.$user['review_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agnt_comnt'])).'",';
			$row .= '"'.$user['mgnt_review_date'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_comnt'])).'",';
			$row .= '"'.$user['coach_name'].'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
/*---------OYO RCA CSS Part Start-----------*/	
	public function download_qa_oyo_dsat_rcasig_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA OYO DSAT SIG RCA List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_oyo_dsat_rcasig_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "Ticket ID", "Rating", "Czentrix ID", "Issue Category", "Issue Subcategory", "Guest Call Issue", "Control/Uncontrol", "ACPT", "WHY1", "WHY2", "Call Summary", "Feedback");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['agent_name'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['ticket_id'].'",'; 
			$row .= '"'.$user['rating'].'",'; 
			$row .= '"'.$user['czentrix_id'].'",'; 
			$row .= '"'.$user['sigrca_cat'].'",'; 
			$row .= '"'.$user['sigrca_subcat'].'",'; 
			$row .= '"'.$user['guest_call_issue'].'",'; 
			$row .= '"'.$user['control_uncontrol'].'",'; 
			$row .= '"'.$user['acpt'].'",'; 
			$row .= '"'.$user['why1'].'",'; 
			$row .= '"'.$user['why2'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
/*---------OYO  Social Media Escalation RCA CSS Part Start-----------*/	
	public function download_qa_oyo_sme_rca_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA OYO Social Media Escalation RCA List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_oyo_sme_rca_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "Campaign", "L1 Supervisor", "Booking ID", "Ticket1", "Ticket2", "Ticket3", "Caller No", "ORM Ticket", "Complaint Type", "Transaction", "Defective Transaction", "Escalated Date", "Week", "Call Date", "Fusion Prevent", "Monetory Loss", "Amount", "ACPT", "WHY1", "WHY2", "Action Policy", "Call Summary", "Feedback");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['agent_name'].'",'; 
			$row .= '"'.$user['campaign'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['booking_id'].'",';
			$row .= '"'.$user['ticket1'].'",'; 
			$row .= '"'.$user['ticket2'].'",'; 
			$row .= '"'.$user['ticket3'].'",'; 
			$row .= '"'.$user['caller_no'].'",'; 
			$row .= '"'.$user['orm_ticket'].'",'; 
			$row .= '"'.$user['complaint_type'].'",'; 
			$row .= '"'.$user['transaction'].'",'; 
			$row .= '"'.$user['defective_transaction'].'",'; 
			$row .= '"'.$user['escalated_date'].'",'; 
			$row .= '"'.$user['week'].'",'; 
			$row .= '"'.$user['call_date'].'",'; 
			$row .= '"'.$user['fusion_prevent'].'",'; 
			$row .= '"'.$user['monetory_loss'].'",'; 
			$row .= '"'.$user['amount'].'",'; 
			$row .= '"'.$user['acpt'].'",'; 
			$row .= '"'.$user['why1'].'",'; 
			$row .= '"'.$user['why2'].'",';
			$row .= '"'.$user['action_policy'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	
	

/*----------------OYO LIFE IB/OB CSS Part Start--------------------*/	
	public function download_qa_oyolife_ibob_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA OYO Life Inbound/Outbound List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_oyolife_ibob_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Agent Name", "L1 Supervisor", "Campaign", "Auditor", "Audit Date Time", "Call Date Time", "Call Duration", "Phone", "LOB", "Audit Type", "VOC", "Welcome the Customer", "WC Reason", "Know the Customer", "KYC Reason", "Effective Communication", "EC Reason", "Building Rapport", "BR Reason", "Maintain Courtesy", "MC Reason", "Probing Assistance *", "PA Reason *", "Significance of Information *", "SI Reason *", "Action for Solution *", "AS Reason *", "Proper Documentation", "PD Reason", "Zero Tolerance Policy *", "ZTP Reason *", "Overall Score", "Agent Disposition", "Actual Disposition", "Correct/Incorrect", "Opportunity/Non Opportunity", "Rebuttals/Probing Used", "ACPT", "Observation L1", "Audit Observations", "Agent informed the customer about creating a SAV?", "Customer agreed for a SAV?", "Correct property details & Pricing pitched?", "Valid / Invalid?", "Call Summary", "Feedback", "Agent Review Date", "Agent Review Comment", "Mgnt Reviewed By", "Mgnt Review Date", "Mgnt Review Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['welcome_customer']=='0') $welcome_customer='0%';
			else $welcome_customer='100%';
			if($user['know_customer']=='0') $know_customer='0%';
			else $know_customer='100%';
			if($user['effective_communication']=='0') $effective_communication='0%';
			else $effective_communication='100%';
			if($user['building_rapport']=='0') $building_rapport='0%';
			else $building_rapport='100%';
			if($user['maintain_courtesy']=='0') $maintain_courtesy='0%';
			else $maintain_courtesy='100%';
			if($user['probing_assistance']=='-1') $probing_assistance='0%';
			else $probing_assistance='100%';
			if($user['significance_info']=='-1') $significance_info='0%';
			else $significance_info='100%';
			if($user['action_solution']=='-1') $action_solution='0%';
			else $action_solution='100%';
			if($user['proper_docu']=='0') $proper_docu='0%';
			else $proper_docu='100%';
			
			
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_date_time'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['lob'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$welcome_customer.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['wc_reason'])).'",';
			$row .= '"'.$know_customer.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['kyc_reason'])).'",';
			$row .= '"'.$effective_communication.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['ec_reason'])).'",';
			$row .= '"'.$building_rapport.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['br_reason'])).'",';
			$row .= '"'.$maintain_courtesy.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mc_reason'])).'",';
			$row .= '"'.$probing_assistance.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['pa_reason'])).'",';
			$row .= '"'.$significance_info.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['si_reason'])).'",';
			$row .= '"'.$action_solution.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['as_reason'])).'",';
			$row .= '"'.$proper_docu.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['pd_reason'])).'",';
			$row .= '"'.$user['zero_tolerance'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['ztp_reason'])).'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_disposition'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['actual_dispo'])).'",';
			$row .= '"'.$user['correct_incorrect'].'",';
			$row .= '"'.$user['oppor_nonoppor'].'",';
			$row .= '"'.$user['rebuttals_probing'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['observation_l1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['audit_observe'])).'",';
			$row .= '"'.$user['agent_info'].'",';
			$row .= '"'.$user['customer_agreed'].'",';
			$row .= '"'.$user['correct_property'].'",';
			$row .= '"'.$user['valid_invalid'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	
	
/*----------------OYO LIFE FOLLOW UP CSS Part Start--------------------*/	
	public function download_qa_oyolife_followup_CSV($lob)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		
		if($lob=='Booking'){
			$newfile="QA OYO Life Booking List-'".$currDate."'.csv";
		}else{
			$newfile="QA OYO Life Follow Up List-'".$currDate."'.csv";
		}
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_oyolife_followup_CSV($rr,$lob)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Agent Name", "L1 Supervisor", "Auditor", "Audit Date Time", "Call Date Time", "Call Duration", "Phone", "Campaign", "Audit Type", "VOC", "Opening", "Opening Reason", "Product *", "Product Reason *", "Rebuttals *", "Rebuttals Reason *", "Sales Effort *", "Sales Effort Reason *", "Closing", "Closing Reason", "Compliance", "Compliance Reason", "Zero Tolerance Policy *", "ZTP Reason *", "Overall Score", "Agent Disposition", "Actual Disposition", "Correct/Incorrect", "ACPT", "Audit Observations", "L1 Observation", "Call Summary", "Feedback", "Agent Review Date", "Agent Review Comment", "Mgnt Reviewed By", "Mgnt Review Date", "Mgnt Review Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['opening']=='0') $opening='0%';
			else $opening='100%';
			if($user['product']=='-1') $product='0%';
			else $product='100%';
			if($user['rebuttals']=='-1') $rebuttals='0%';
			else $rebuttals='100%';
			if($user['sales_effort']=='-1') $sales_effort='0%';
			else $sales_effort='100%';
			if($user['closing']=='0') $closing='0%';
			else $closing='100%';
			if($user['compliance']=='0') $compliance='0%';
			else $compliance='100%';
			
			
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_date_time'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$opening.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['opening_reason'])).'",';
			$row .= '"'.$product.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['product_reason'])).'",';
			$row .= '"'.$rebuttals.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['rebuttals_reason'])).'",';
			$row .= '"'.$sales_effort.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['sales_effort_reason'])).'",';
			$row .= '"'.$closing.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['closing_reason'])).'",';
			$row .= '"'.$compliance.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['compliance_reason'])).'",';
			$row .= '"'.$user['zero_tolerance'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['ztp_reason'])).'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_dispo'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['actual_dispo'])).'",';
			$row .= '"'.$user['correct_incorrect'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['audit_observe'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_observe'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
/*----------------OYO UK / US CSS Part Start--------------------*/	
	public function download_qa_oyo_uk_us_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA OYO UK/US Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_oyo_uk_us_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Recording Date and Time", "Avaya ID", "Call Duration", "Phone", "Booking ID", "Geography to be audited", "Type of Audit", "Cancellation Sub Type", "ACPT", "Call Type", "Call Sub Type", "Tagging by Agent - Call Type", "agging by Agent - Call Sub Type", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Delayed Opening >10 sec", "Was the opening correct?", "Did the agent ask for further assistance?", "Was the closure correct?", "Was there any grammatical error on the call?", "Was there any MTI observed on the call?", "Did the agent display active listening skills on the call?", "Did the agent do relevant probing?", "Did the agent provide the correct tariff room category etc?", "Did the agent start from the lowest discount?", "Did the agent offer alternate property to the customer?", "Did the agent pitch for additional nights?", "Did the agent create urgency on call?", "Did the agent give the property details with the DID information?", "Did the agent check in lifeline with the right property?", "Did the agent check with the PM?", "Did the agent summarize the call?", "Did the agent effectively pitch for on-call payment?", "Was the tagging/disposition correct?", "Did the agent adhere to the SOP?", "Did the agent provide any incorrect or misleading information to the customer?", "Was there any ZTP observed on the call?", "Did the agent capture correct information of the customer?", "Did the agent give all the mandatory information?", "Did the agent create correct booking?", "Did the agent acknowledge the concern of the customer?", "Was the agent polite/courteous on the call?", "Did the agent show empathy/sympathy/apology when required?", "Did the agent take the name of the customer atleast twice on the call?", "Was there any dead air on the call?", "Did the agent follow hold procedure?", "Was the agent energetic throughout the call?", "Call Summary", "Feedback", "L1", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['entry_by']!=''){
				$auditorName = $user['auditor_name'];
			}else{
				$auditorName = $user['client_name'];
			}
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['avaya_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['booking_id'].'",';
			$row .= '"'.$user['geography_audit'].'",';
			$row .= '"'.$user['type_audit'].'",';
			$row .= '"'.$user['cancel_sub_audit_type'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['call_sub_type'].'",';
			$row .= '"'.$user['agent_call_type'].'",';
			$row .= '"'.$user['agent_call_sub_type'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['delayed_opening'].'",';
			$row .= '"'.$user['was_opening_correct'].'",';
			$row .= '"'.$user['agent_ask_further_assistance'].'",';
			$row .= '"'.$user['was_closure_correct'].'",';
			$row .= '"'.$user['grammatical_error'].'",';
			$row .= '"'.$user['MTI_observed_call'].'",';
			$row .= '"'.$user['display_active_listening'].'",';
			$row .= '"'.$user['agent_relevant_probing'].'",';
			$row .= '"'.$user['agent_provide_correct_tariff'].'",';
			$row .= '"'.$user['start_lowest_discount'].'",';
			$row .= '"'.$user['offer_alternate_property'].'",';
			$row .= '"'.$user['pitch_additional_night'].'",';
			$row .= '"'.$user['create_call_urgency'].'",';
			$row .= '"'.$user['give_property_details'].'",';
			$row .= '"'.$user['agent_check_lifeline'].'",';
			$row .= '"'.$user['check_with_PM'].'",';
			$row .= '"'.$user['agent_summarize_call'].'",';
			$row .= '"'.$user['pitch_for_on_call'].'",';
			$row .= '"'.$user['was_tagging_correct'].'",';
			$row .= '"'.$user['agent_adhere_to_SOP'].'",';
			$row .= '"'.$user['agent_provide_incorrect_info'].'",';
			$row .= '"'.$user['ZTP_call_observe'].'",';
			$row .= '"'.$user['capture_correct_information'].'",';
			$row .= '"'.$user['agent_give_mandatory_info'].'",';
			$row .= '"'.$user['create_correct_booking'].'",';
			$row .= '"'.$user['acknowlegde_the_concern'].'",';
			$row .= '"'.$user['agent_polite_on_call'].'",';
			$row .= '"'.$user['show_emphaty_when_required'].'",';
			$row .= '"'.$user['take_customer_name_twice'].'",';
			$row .= '"'.$user['any_dead_air_on_call'].'",';
			$row .= '"'.$user['follow_hold_procedure'].'",';
			$row .= '"'.$user['energetic_through_call'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['level1_comment'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
/*----------------OYO SIG New CSS Part Start--------------------*/	
	public function download_qa_oyosig_new_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA OYO SIG New Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_oyosig_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date/Time", "Czentrix ID", "Call Duration", "Phone", "Campaign", "Call Type", "Disconnection Source", "Call ID", "CONF Unique ID", "Monitor File Name", "Czentrix Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "1.1 Opening within 5 secs", "1.2 Opening with Self Introduction & OYO Branding", "2.1 Effective Probing Done", "2.2 Issue Identified and Paraphrased for guest confirmation", "3.1 Apology & Empathy", "3.2 Voice Intonation Modulation & Rate Of Speech", "3.3 Active Listening Avoid Interruption & Repetitions", "3.4 Confidence and Enthusiasm", "3.5 Politeness & Professionalism", "3.6 Grammar & Sentence Construction", "3.7 Acknowledgement of guest queries and offer assurance", "4.1 Did the agent adhere to Hold Protocol", "4.2 Did the agent adhere to dead air Protocol", "*** 4.3 Legitimate Hold used", "*** 5.1 Correct Information Resolution provided", "5.2 Correct refund", "*** 5.3 Proper follow up with PM/CM/OPS", "5.4 GNC Closure Procedure", "5.5 Agent Assist Adherence", "5.6 Account verification before cancellation/modification", "5.7 Ownership", "5.8 Send correct resolution email", "6.1 Complete and correct notes", "*** 6.2 Accurate Tagging of Issue Category and sub category", "6.3 Call Disposed accurately on Czentrix", "6.4 Correct Ticket Status and tagging of remaining fields in Oyo Desk", "7.1 Pitched Need Help for self help", "7.2 Further Assistance Asked", "7.3 G-Sat Survey Effectively Pitched", "*** 7.4 G- Sat Survey Avoidance", "7.5 Closing done with branding of OYO", "Drop Downs 1.1", "Drop Downs 1.2", "Drop Downs 2.1", "Drop Downs 2.2", "Drop Downs 3.1", "Drop Downs 3.2", "Drop Downs 3.3", "Drop Downs 3.4", "Drop Downs 3.5", "Drop Downs 3.6", "Drop Downs 3.7", "Drop Downs 4.1", "Drop Downs 4.2", "Drop Downs 4.3", "Drop Downs 5.1", "Drop Downs 5.2", "Drop Downs 5.3", "Drop Downs 5.4", "Drop Downs 5.5", "Drop Downs 5.6", "Drop Downs 5.7", "Drop Downs 5.8", "Drop Downs 6.1", "Drop Downs 6.2", "Drop Downs 6.3", "Drop Downs 6.4", "Drop Downs 7.1", "Drop Downs 7.2", "Drop Downs 7.3", "Drop Downs 7.4", "Drop Downs 7.5", "OD-Issue Category", "OD-Sub Category", "OD-Sub Sub Category", "Actual OD-Issue Category", "Actual OD-Sub Category", "Actual OD-Sub Sub Category", "Actual Czentrix Disposition", "Booking ID", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['entry_by']!=''){
				$auditorName = $user['auditor_name'];
			}else{
				$auditorName = $user['client_name'];
			}
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['czentrix_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['disconnection_source'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['conf_id'].'",';
			$row .= '"'.$user['monitor_file_name'].'",';
			$row .= '"'.$user['czentrix_disposition'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['call_opening_5sec'].'",';
			$row .= '"'.$user['call_opening_oyo_branding'].'",';
			$row .= '"'.$user['effective_probong'].'",';
			$row .= '"'.$user['issue_identified'].'",';
			$row .= '"'.$user['apology_empathy'].'",';
			$row .= '"'.$user['voice_intonation'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['confidence_enthusiasm'].'",';
			$row .= '"'.$user['politeness'].'",';
			$row .= '"'.$user['sentence_construction'].'",';
			$row .= '"'.$user['acknowledgement'].'",';
			$row .= '"'.$user['adhere_hold_protocol'].'",';
			$row .= '"'.$user['dead_air_protocol'].'",';
			$row .= '"'.$user['legitimate_hold'].'",';
			$row .= '"'.$user['correct_information'].'",';
			$row .= '"'.$user['correct_refund'].'",';
			$row .= '"'.$user['proper_followup'].'",';
			$row .= '"'.$user['gnc_closure'].'",';
			$row .= '"'.$user['assist_adherence'].'",';
			$row .= '"'.$user['account_verification'].'",';
			$row .= '"'.$user['ownership'].'",';
			$row .= '"'.$user['correct_email'].'",';
			$row .= '"'.$user['correct_notes'].'",';
			$row .= '"'.$user['accurate_tagging'].'",';
			$row .= '"'.$user['call_disposed'].'",';
			$row .= '"'.$user['correct_ticket_status'].'",';
			$row .= '"'.$user['piched_need_help'].'",';
			$row .= '"'.$user['further_assistance'].'",';
			$row .= '"'.$user['Gsat_survey_pitched'].'",';
			$row .= '"'.$user['Gsat_survey_avoidance'].'",';
			$row .= '"'.$user['closing_done_branding'].'",';
			$row .= '"'.$user['remarks1'].'",';
			$row .= '"'.$user['remarks2'].'",';
			$row .= '"'.$user['remarks3'].'",';
			$row .= '"'.$user['remarks4'].'",';
			$row .= '"'.$user['remarks5'].'",';
			$row .= '"'.$user['remarks6'].'",';
			$row .= '"'.$user['remarks7'].'",';
			$row .= '"'.$user['remarks8'].'",';
			$row .= '"'.$user['remarks9'].'",';
			$row .= '"'.$user['remarks10'].'",';
			$row .= '"'.$user['remarks11'].'",';
			$row .= '"'.$user['remarks12'].'",';
			$row .= '"'.$user['remarks13'].'",';
			$row .= '"'.$user['remarks14'].'",';
			$row .= '"'.$user['remarks15'].'",';
			$row .= '"'.$user['remarks16'].'",';
			$row .= '"'.$user['remarks17'].'",';
			$row .= '"'.$user['remarks18'].'",';
			$row .= '"'.$user['remarks19'].'",';
			$row .= '"'.$user['remarks20'].'",';
			$row .= '"'.$user['remarks21'].'",';
			$row .= '"'.$user['remarks22'].'",';
			$row .= '"'.$user['remarks23'].'",';
			$row .= '"'.$user['remarks24'].'",';
			$row .= '"'.$user['remarks25'].'",';
			$row .= '"'.$user['remarks26'].'",';
			$row .= '"'.$user['remarks27'].'",';
			$row .= '"'.$user['remarks28'].'",';
			$row .= '"'.$user['remarks29'].'",';
			$row .= '"'.$user['remarks30'].'",';
			$row .= '"'.$user['remarks31'].'",';
			$row .= '"'.$user['issue_category'].'",';
			$row .= '"'.$user['sub_category'].'",';
			$row .= '"'.$user['sub_sub_category'].'",';
			$row .= '"'.$user['actual_issue_category'].'",';
			$row .= '"'.$user['actual_sub_category'].'",';
			$row .= '"'.$user['actual_sub_sub_category'].'",';
			$row .= '"'.$user['actual_czentrix_dispo'].'",';
			$row .= '"'.$user['booking_id'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}


	/////////////////////////////////////OYOINB///////////////////////////
	
	public function headerDetails(){

		return $arrayName = array ("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Phone","Call Date","Call Duration","Campaign","Booking Id","APCT","Audit Type","Auditor Type","VOC","Czentrix","AT_calltype","AT_subtype","Correct Calltype","Correct Subtype","Lead conversion Done","Non Conversion Reason","L1","L2","Service Score","Soft Skill Score","Overall Result","Overall Score","Booking Details","Guest Understand","Complete Resolution","Objection Handling","Retention Efforts","Ownership Resolve","Customer Issue","Effective Probing","Sale Future","Selling Skills","Customer Objection","Hotel Amenities","Multiple Option","Whatsapp Option","Lifeline Compliance","OYO Assist","Escalation Metrix","SIG CID","Greet Customer Branding","Courtesy Confidence","Apology Empathy","Interruption","Active Listening","Switch Language","Grammar Sentence","Guest Permission","Verbiage Followed","Dead Air","Does Infraction Exist","Choose Reason","Tier","Attempt","Equivalent_to","Call Summary","BOD","Feedback","Entry By","Entry Date","Audit Start Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");

	}

	public function download_qa_oyoinb_new_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA oyo_inb New Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_oyoinb_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");		
		$header=$this->headerDetails();
		$field_name="SHOW FULL COLUMNS FROM qa_oyoinb_feedback WHERE Comment!=''";
		$field_name=$this->Common_model->get_query_result_array($field_name);
		$fld_cnt=count($field_name);
		for($i=0;$i<$fld_cnt;$i++){
						$val=$field_name[$i]['Field'];
						if($val!=""){
							$field_val[]=$val;
						}		
					 }
		
		array_unshift($field_val ,"auditor_name");
		$key = array_search ('agent_id', $field_val);
		array_splice($field_val, $key, 0, 'fusion_id');
		$field_val=array_values($field_val);

		$count_for_field=count($field_val);

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row = "";
		// print_r($rr);
		// die;
		foreach($rr as $user)
		{	
			for($z=0;$z<$count_for_field;$z++){
				
				if($field_val[$z]==="auditor_name"){
					$row = '"'.$user['auditor_name'].'",';
				}elseif($field_val[$z]==="fusion_id"){
					$row .= '"'.$user['fusion_id'].'",';
				}elseif($field_val[$z]==="agent_id"){
					$row .= '"'.$user['fname']." ".$user['lname'].'",';
				}elseif($field_val[$z]==="tl_id"){
					$row .= '"'.$user['tl_name'].'",';	
				}elseif(in_array($field_val[$z], array('call_summary','feedback','agent_rvw_note','mgnt_rvw_note'))) {
    			
    			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user[$field_val[$z]])).'",';

				}else{
					$row .= '"'.$user[$field_val[$z]].'",';	
				}
				
			}
				
				fwrite($fopen,$row."\r\n");
				$row = "";
		}
		
		fclose($fopen);
	}
	
	//****************************************************************************************//
	// CANDIDATE EXAMINATION REPORT ///
	//****************************************************************************************//
	
	public function dipcheck(){
		if(check_logged_in()){
			 
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/dipcheck.php";
			$data["content_js"] = "qa_dipcheck/dipcheck_js.php";
			
			$SQLtxt ="SELECT * FROM qa_dipcheck ORDER BY id ASC";
			$data_fields = $this->db->query($SQLtxt);
			
			$data['campaign'] = $data_fields->result();
			
			$this->load->view("dashboard",$data);
			
		}
	}
	
	public function download_dipcheck_rep(){
		if(check_logged_in()){
			if($_GET['process_download'] == "Download" &&  $_GET['campaign_id']!=""){ 

				$SQLtxt ="SELECT allotted_set_id, exam_status FROM lt_examination INNER JOIN lt_exam_schedule ON lt_examination.id = lt_exam_schedule.exam_id where lt_exam_schedule.exam_id=". $_GET['campaign_id'] ." GROUP BY allotted_set_id";
				
				$data_fields = $this->db->query($SQLtxt);
				$data['set_count'] = $data_fields->result_array();
											
				$this->generate_dipcheck_xls($_GET['campaign_id'],$_GET['desc'],$data['set_count']);
				
			}else{
				redirect('reports/dipcheck','refresh');
			}
		}
	}
	
	
	private function generate_dipcheck_xls($campaign_id, $heading, $set_count ){
		if(check_logged_in()){
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Exam Result Report");
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);	
			
	   
			$objWorksheet->getColumnDimension('A')->setWidth(15);
			$objWorksheet->getColumnDimension('B')->setWidth(15);
			$objWorksheet->getColumnDimension('C')->setWidth(15);
			$objWorksheet->getColumnDimension('D')->setWidth(15);
			$objWorksheet->getColumnDimension('E')->setWidth(50);
			$objWorksheet->getColumnDimension('F')->setWidth(50);
			$objWorksheet->getColumnDimension('G')->setWidth(50);
			$objWorksheet->getColumnDimension('H')->setWidth(50);
			$objWorksheet->getColumnDimension('I')->setWidth(50);
			$objWorksheet->getColumnDimension('J')->setWidth(50);
			$objWorksheet->getColumnDimension('K')->setWidth(50);
			$objWorksheet->getColumnDimension('L')->setWidth(50);
			$objWorksheet->getColumnDimension('M')->setWidth(50);
			$objWorksheet->getColumnDimension('N')->setWidth(50);
			$objWorksheet->getColumnDimension('O')->setWidth(50);
			$objWorksheet->getColumnDimension('P')->setWidth(50);
			$objWorksheet->getColumnDimension('Q')->setWidth(50);
			$objWorksheet->getColumnDimension('R')->setWidth(50);
			$objWorksheet->getColumnDimension('S')->setWidth(50);
			$objWorksheet->getColumnDimension('T')->setWidth(50);
			$objWorksheet->getColumnDimension('U')->setWidth(50);
			$objWorksheet->getColumnDimension('V')->setWidth(50);
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:P1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:O2")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "F28A8C"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
                );
       
			// CELL FONT AND FONT COLOR 
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14,
				'name'  => 'Algerian',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			));
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "Dip Check ".$heading);
			$sheet->mergeCells('A1:J1');
					
			
					foreach($set_count as $no_set){
						
					$col1=0;
					$row1=2; 	
						
						$SQLtxt = "Select * from lt_questions where set_id = ". $no_set['allotted_set_id'] ." order by id";
						$data_fields1 = $this->db->query($SQLtxt);
						$data['candidate'] = $data_fields1->result_array();
						
						$header_column = array("SL No","FUSION ID","AGENT NAME","TL Name");
						
							foreach($header_column as $val){
								if($col1 < 4){
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,2,$val);	
									$col1++;
								}
							}
							
							foreach($data['candidate'] as $excel_header){
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$excel_header['title']);	 
									$col1++; 
									 
							}
							
							/*$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,'Score');
							$fcol = $col1;
							$fcol = $col1+1; */
							$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,'Score Percentage');
							
					 /*
					    $SQLtxt="Select fusion_id,fname,lname,(Select CONCAT(fname,' ' ,lname) from signin where signin.id=s.assigned_to) as asign_tl, user_id,set_id,exam_id,exam_schedule_id,ques_id,ans_id, (SELECT text FROM lt_questions_ans_options QA_O WHERE QA_O.id = ua.ans_id )AS User_answer from lt_exam_schedule x inner JOIN lt_questions y on y.set_id = x.allotted_set_id
						inner JOIN lt_user_exam_answer ua on ua.exam_schedule_id = x.id and ua.ques_id = y.id
						left JOIN signin s on s.id = x.user_id
						where exam_id =". $campaign_id ." and allotted_set_id = ". $no_set['allotted_set_id'] ."
						order by user_id,ques_id";
					*/
						
					   $SQLtxt="Select fusion_id,fname,lname,(Select CONCAT(fname,' ' ,lname) from signin where signin.id=s.assigned_to) as asign_tl, user_id,set_id,exam_id,exam_schedule_id, ua.ques_id, no_of_question, ans_id, QA_O.text AS User_answer, QA_O.correct_answer from lt_exam_schedule x 
						inner JOIN lt_questions y on y.set_id = x.allotted_set_id
						inner JOIN lt_user_exam_answer ua on ua.exam_schedule_id = x.id and ua.ques_id = y.id
						LEFT JOIN lt_questions_ans_options QA_O ON QA_O.id=ua.ans_id
						left JOIN signin s on s.id = x.user_id
						where exam_id =". $campaign_id ." and allotted_set_id = ". $no_set['allotted_set_id'] ."
						order by user_id,ques_id";
						
						
						$data_fields1 = $this->db->query($SQLtxt); 
						$data['Questions'] = $data_fields1->result_array();
					
						
						$no_of_question=$data['Questions'][0]['no_of_question'];
						
						$col=0;
						$row=2; 
						$cnt=1; 
						
							$correct_answer=0;
							$old_fusion_id=''; 
							/* for($i=0;$i<count($data['Questions']);$i++){ */
							foreach($data['Questions'] as $recRow){
							 if($recRow['User_answer'] =='') $recRow['User_answer'] ="NA";
							 
								//if($data['Questions'][$i]['fusion_id'] != $old_fusion_id){
								if($recRow['fusion_id'] == $old_fusion_id ){
									
									$col++;
									$correct_answer += $recRow['correct_answer'];
									//FOR COLOR TEST LIGHT GREEN 
									if($recRow['correct_answer'] == 1){
										$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFF99');
									}
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['User_answer']  );
									 
									//$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row, ($correct_answer / $no_of_question));
									
									
								}else{
									
									
									$old_fusion_id =  $recRow['fusion_id'];
									$correct_answer=0;
									$col=0;
									$row++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $cnt++ );
									$col++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['fusion_id'] );
									$col++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['fname']." ".$recRow['lname'] );
									$col++;
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['asign_tl'] );
									$col++;
									//FOR COLOR TEST LIGHT GREEN 
									if($recRow['correct_answer'] == 1){
										$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFF99');
									}
									
									$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $recRow['User_answer']  );
									$correct_answer += $recRow['correct_answer'];  
									
									
								}
								
								
								  
							}
							
					}


  
		    ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="dipcheck_'.$heading.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
            	
		}
	}
	
	
		
	//----------------- PAYROLL REPORT --------------------//
	public function payroll(){
		if(check_logged_in()){
			 
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/payroll_report.php";
			
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
	
////////////////////------IT Assessment Report (09/03/2020)------/////////////////////
	public function itAssessment(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/it_assessment_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			$data["it_assessment_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond = " Where (date(entry_date) >= '$date_from' and date(entry_date) <= '$date_to' ) ";
				
				if($office_id=="All") $cond .= "";
				else $cond .= " And office_id='$office_id'";
				
				$qSql="SELECT * from
					(Select * from it_assessment) xx Left Join (Select id as sid, concat(fname, ' ', lname) as fullname, fusion_id, office_id from signin) yy on (xx.user_id=yy.sid) $cond";
					
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["it_assessment_list"] = $fullAray;
				$this->create_itAssessment_CSV($fullAray);	
				$dn_link = base_url()."reports/download_itAssessment_CSV/";			
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_itAssessment_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="IT Assessment List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_itAssessment_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Name", "Location", "Do you have Desktop or Laptop at Home", "What Kind of Laptop/ Desktop you Have Make / Model - CPU", "What Kind of Laptop/ Desktop you Have Make / Model - RAM", "What Kind of Laptop/ Desktop you Have Make / Model - HDD", "What Internet Connection do you have?", "What is the Bandwith?", "Do you have Headset?", "Do you any kind of Power Back up?", "Created Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row	=	"";
		foreach($rr as $user)
		{	
			$row = '"'.$user["fusion_id"].'",';
			$row .= '"'.$user["fullname"].'",';
			$row .= '"'.$user["office_id"].'",';
			$row .= '"'.$user["dekstop_laptop"].'",';
			$row .= '"'.$user["what_kind_dl_cpu"].'",';
			$row .= '"'.$user["what_kind_dl_ram"].'",';
			$row .= '"'.$user["what_kind_dl_hdd"].'",';
			$row .= '"'.$user["what_internet_conn"].'",';
			$row .= '"'.$user["what_bandwidth"].'",';
			$row .= '"'.$user["have_headset"].'",';
			$row .= '"'.$user["kind_power_backup"].'",';
			$row .= '"'.$user["entry_date"].'",';
					
			fwrite($fopen,$row."\r\n");
			$row	=	"";
		}
		fclose($fopen);
	}
	
	
	
////////////////////------WORK FROM HOME SURVEY (27/03/2020)------/////////////////////
	public function survey_wrokhomereport(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/survey_workhome_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			$data["survey_wfh_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond = " WHERE (date(xx.entry_date) >= '$date_from' and date(xx.entry_date) <= '$date_to' ) ";
				
				if($office_id=="All") $cond .= "";
				else $cond .= " AND yy.office_id='$office_id'";
				
				$qSql="SELECT * from survey_work_home xx 
				       LEFT JOIN (SELECT id as sid, concat(fname, ' ', lname) as fullname, fusion_id, office_id from signin) yy on (xx.user_id=yy.sid) $cond";
					
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["survey_wfh_list"] = $fullAray;
				$this->create_survey_wrokhomereport_CSV($fullAray);	
				$dn_link = base_url()."reports/download_survey_wrokhomereport_CSV/";			
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_survey_wrokhomereport_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/SurveyrReportWFH".get_user_id().".csv";
		$newfile="Survey Work from Home -'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_survey_wrokhomereport_CSV($rr)
	{
		$filename = "./assets/reports/SurveyrReportWFH".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Name", "Location", "Working from Home", "Are you happy that Fusion has shifted to a WAH setup", "Are you happy for How Fusion has handled the WAH deployment", "Choosen Hashtag", "Remarks/Suggestion", "Created Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row	=	"";
		foreach($rr as $user)
		{	
			$row = '"'.$user["fusion_id"].'",';
			$row .= '"'.$user["fullname"].'",';
			$row .= '"'.$user["office_id"].'",';
			$row .= '"'.$user["is_work_home"].'",';
			$row .= '"'.$user["is_shifted_happy"].'",';
			$row .= '"'.$user["how_shifted_happy"].'",';
			$row .= '"#'.$user["hashtag"].'",';
			$row .= '"'.$user["remarks"].'",';
			$row .= '"'.$user["entry_date"].'",';
					
			fwrite($fopen,$row."\r\n");
			$row	=	"";
		}
		fclose($fopen);
	}




//================ REPORTS CSV =========================================//	

    public function user_mood_reports()
	{    
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/user_mood_reports.php";
							
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
					
			//================ DATE FILTER				
			$sdate = GetLocalMDYDate();
			$edate = GetLocalMDYDate();
			
			$usergetdate_start = $this->input->post('start_date');
			$usergetdate_end = $this->input->post('end_date');

		    if($usergetdate_start != ""){ 
							
				$sdate = mmddyy2mysql($usergetdate_start);
				$edate = mmddyy2mysql($usergetdate_end);
			}
						
			$data['date_now'] = GetLocalMDYDate();
			$data['start_date'] = $sdate;
			$data['end_date'] = $edate;
		
		    //================ OFFICE FILTER
			$data['office_now'] = $user_office_id;
			$data['post_mood'] = "";
			
			//$report_start = $this->input->post('start_date');
			//$report_end = $this->input->post('end_date');
			$report_office = $this->input->post('office_id');
			$get_mood = $this->input->post('mood_id');
			
			if(!empty($get_mood)){ $data['post_mood'] = $get_mood; }
			if(!empty($report_office)){ $data['office_now'] = $report_office; }
			
			$_filterCond = "";			
			$_filterCond = " AND DATE(m.local_date) >= '$sdate' AND DATE(m.local_date) <= '$edate'";
			
			if($report_office!="") $_filterCond .= " AND s.office_id='".$data['office_now']."'";
			if($data['post_mood']!="ALL" && $data['post_mood']!="") $_filterCond .= " AND m.mood='".$data['post_mood']."'";
			
			
			//=============== DROPDOWN FILTER
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$sqlmood = "SELECT distinct(mood) as mood from user_mood";
			$data['all_mood'] = $this->Common_model->get_query_result_array($sqlmood);
			
			if(!empty($report_office))
			{
				//========= DOWNLOAD CSV
				$sqlReport = "SELECT m.*, s.fusion_id, concat(s.fname,' ',s.lname) as fullname, s.office_id, 
				d.description as department, r.name as designation
						from user_mood as m 
						LEFT JOIN signin as s ON s.id = m.entry_by
						LEFT JOIN department d on d.id=s.dept_id 
						LEFT JOIN role r on r.id=s.role_id 
						WHERE 1 $_filterCond";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				
				$this->user_mood_reports_excel($queryReport, $data['office_now']."_reports_mood", "User Mood Report");
				
			}
			
			$this->load->view('dashboard',$data);
	
	}
	
	
	
	
	public function user_mood_reports_excel($result_array, $xlName = "excel_report", $title="Report")
	{
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
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:H1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setWidth('25');
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1'); 
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', "User Mood");
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');	
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		//$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "user_id");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Office");
		//$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Department");
		//$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Designation");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Mood");
		$i = 1;
				
		foreach($result_array as $wk=>$wv)
		{				
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			//$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["entry_by"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["office_id"]);
			//$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["department"]);
			//$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["designation"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["local_date"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["mood"]);
			$i++;			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$xlName.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
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
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/document_upload_report.php";
			
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
				(select user_id as idu_uid,pan_doc,aadhar_doc,nis_doc,birth_certi_doc,marrige_certi_doc,photograph,resume_doc,nit_doc,isss_doc,afp_info_doc,background_local_doc, sss_no_doc,tin_no_doc,philhealth_no_doc,dependent_birth_certi_doc,bir_2316_doc,nbi_clearance_doc,offer_letter,employment_contract,profile_sketch,updated_cv from info_document_upload) ff On (masdt.id=ff.idu_uid)
				where status=1 $cond GROUP BY fusion_id";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["docu_upl_list"] = $fullAray;
				$this->create_docu_upl_CSV($fullAray, $office_id);	
				$dn_link = base_url()."reports/download_docu_upl_CSV/".$office_id;
				
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
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($off=='JAM'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Tax Registration Number ID", "National Insurance Scheme ID", "Birth Certificate", "Married", "Marriage Certificate", "Bank Info", "Education Info", "Passport", "Other Document Upload");
		}else if($off=='KOL' || $off=='HWH' || $off=='BLR' || $off=='NOI' || $off=='CHE'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Aadhar Card / Social Secuirity No", "PAN Card", "Photograph", "Covid-19 Declaration", "Education Info", "Passport", "Experience Info", "Other Document Upload");
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
///////////////////////////////	
	
	
	
	//========================== REPORTS SELF DECLARTAION COVID ================================//
	
	public function covid_self_declaration_reports()
	{
		
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/covid_self_declaration_report.php";
			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('covid_start_date');
			$end_date   = $this->input->get('covid_end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
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
			if($is_global_access=='1' || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			
			
			if($showreport == "Download Excel"){
				$this->generate_covid_self_declaration_excel_reports($start_date, $end_date, $dept_id, $office_id);
			} else {
				$this->load->view('dashboard',$data);
			}				
	}
	
	
	
	public function generate_covid_self_declaration_excel_reports($start_date, $end_date, $dept_id, $office_id)
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$extraWhere = "";
		if($office_id != "ALL"){ $extraWhere .= " AND s.office_id = '$office_id'"; }
		if($dept_id != "ALL"){ $extraWhere .= " AND s.dept_id = '$dept_id'"; }
		
		$covid_start_date = $start_date ." 00:00:00"; $covid_end_date = $end_date ." 23:59:59"; 
		$sql_covid_consent = "SELECT c.*, s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as my_office_location, sp.phone as employee_phone,
			                  CONCAT(l.fname, ' ', l.lname) as l1_supervisor, lp.phone as supervisor_phone, d.description as department, r.name as designation 
					          from covid19_screening_checkup as c
							  INNER JOIN signin as s ON s.id = c.user_id
							  LEFT JOIN department as d ON d.id=s.dept_id
							  LEFT JOIN role as r ON r.id=s.role_id
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  LEFT JOIN info_personal as lp ON lp.user_id = s.assigned_to
							  LEFT JOIN info_personal as sp ON sp.user_id = s.id
		                      WHERE c.date_added_local >= '$covid_start_date' AND c.date_added_local <= '$covid_end_date'
						      $extraWhere
							  ORDER by c.date_added_local, s.fname ASC";
		$covid_consent_details = $this->Common_model->get_query_result_array($sql_covid_consent);
		
		$title = "Covid Self Declaration";
		
		//$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:O1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setWidth('25');
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
		
		//$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:J1'); 
		//$this->objPHPExcel->getActiveSheet()->setCellValue('G1', "IT Checklist");
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:O2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$i=0;		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "SL");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Fusion ID");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Employee Name");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Employee Phone");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Site");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Department");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Designation");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "L1 Supervisor");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Date");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Temperature Measured");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Last 30 Days Travelled Outside");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Any Symptom Found");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Is Exposed in past 14 Days");
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Any Household Members in Quarantine");		
		$i++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,2, "Entered Symptoms");
		
			
		$i = 1;		
		foreach($covid_consent_details as $wk=>$wv)
		{	
						
			$j = 0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $i);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fusion_id"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["fullname"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_phone"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["my_office_location"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["department"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["designation"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["l1_supervisor"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, date('Y-m-d', strtotime($wv["date_added_local"])));
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_temperature"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_outside"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_symptom"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_exposed"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_is_family_covid"]);
			$j++;  $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+2, $wv["employee_symptoms"]);
			$i++;			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Covid_Self Declaration_'.$start_date.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
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
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "reports/upload_bank_reports.php";
		
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
								  WHERE 1 $extraOffice $extraDept $extraFusion";
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
		
		$excelUrl = base_url()."reports/dfr_pool_list?search_from_date=".$from_date."&search_to_date=".$to_date."&search_office_id=".$search_office_id."&excel=1";
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
		
		$data["aside_template"] = "reports/aside.php";
		$data["content_template"] = "reports/dfr_pool_list.php";
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
	
	
		
}

?>