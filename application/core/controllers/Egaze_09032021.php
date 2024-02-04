<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Egaze extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		
		//error_reporting(1);
		//ini_set('display_errors', 1);
		//$this->db->db_debug=true;
		
		$this->load->model('Common_model');
		$this->load->library('excel');
	}
	
	function index()
	{
		redirect('egaze/individual');
		
	}
	
	
	/*=============  TEAM OVERVIEW DASHBOARD ===================*/
	function dashboard()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "2";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/mydashboard.php";
			
			//$sdate = GetLocalDate();
			//$edate = GetLocalDate();
			
			if($this->uri->segment(3) == 'last'){ 
				$this->output->enable_profiler(TRUE);
			}
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			//$filter_date = GetLocalDate();
			$filter_date = date('Y-m-d');
			
			$userget = $this->input->get('uid');
		    if($userget != ""){ $current_user = $userget; }
			
			$usergetoffice = $this->input->get('office');
		    if($usergetoffice != ""){ $user_office_id = $usergetoffice; }
			
			$usergetdept = $this->input->get('dept');
		    if($usergetdept != ""){ $ses_dept_id = $usergetdept; }
			
			$setclient = "ALL";
			$userclient = $this->input->get('client');
		    if($userclient != ""){ $setclient = $userclient; }
			
			$setprocess = "ALL";
			$userprocess = $this->input->get('process');
		    if($userprocess != ""){ $setprocess = $userprocess; }
			
			$usergetdate = $this->input->get('d');
		    if($usergetdate != ""){ $filter_date = $usergetdate; }
			
			
			$filter_date_start = $filter_date ." 00:00:00";
			$filter_date_end = $filter_date ." 23:59:59";
			
			$data['office_now'] = $user_office_id;
			$data['department_now'] = $ses_dept_id;
			$data['client_now'] = $setclient;
			$data['process_now'] = $setprocess;
			$data['user_now'] = $current_user;
			$data['date_now'] = $filter_date;
			
			$innrJoin = "";
			//$innrJoin = " inner join signin on signin.id = egaze_activities_details.user_id  ";
			
			
			if($is_global_access == 1 || get_site_admin()==1 || isAccessGlobalEGaze()==true){
				
				$data['myteam'] = $myteamd = $this->get_assigned_details('', '', $user_office_id, $ses_dept_id, $setclient, $setprocess);
				
				/*$AssCond=" AND office_id = '$user_office_id' ";
				if($ses_dept_id != "ALL" && !empty($ses_dept_id)){
					//$AssCond=" AND user_id IN (SELECT id from signin WHERE office_id = '$user_office_id' AND dept_id = '$ses_dept_id')";
					$AssCond=" AND office_id = '$user_office_id' AND dept_id = '$ses_dept_id' ";
				}								
				if((!empty($setclient)) && ($setclient != "ALL")){ $AssCond .= " AND is_assign_client(user_id, '".$setclient."')"; }
				if((!empty($setprocess)) && ($setprocess != "ALL")){ $AssCond .= " AND is_assign_process(user_id, '".$setprocess."')"; }
				*/
				
				$sqloffice = "SELECT abbr, location, is_active from office_location WHERE abbr IN (SELECT DISTINCT(office_id) from signin WHERE id IN (SELECT DISTINCT(user_id) from egaze_activities_details))";
				$data['location_list'] = $this->Common_model->get_query_result_array($sqloffice);
				
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($setclient);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
			}else{
				$data['myteam'] = $myteamd = $this->get_assigned_details($current_user, '', $user_office_id, $ses_dept_id, $setclient, $setprocess);
				
				/*$AssCond = " AND (s.assigned_to='$uid' OR s.assigned_to in (SELECT id FROM signin where  assigned_to ='$uid')) ";
				$AssCond=" AND user_id IN ( SELECT id from signin WHERE (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user') OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' )))  )) OR user_id = '$current_user' ";	
				if((!empty($setclient)) && ($setclient != "ALL")){ $AssCond .= " AND is_assign_client(user_id, '".$setclient."')"; }
				if((!empty($setprocess)) && ($setprocess != "ALL")){ $AssCond .= " AND is_assign_process(user_id, '".$setprocess."')"; }
				*/
				
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($setclient);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();

			}
			
			$myTeamUsers = array_column($myteamd, 'user_id');
			$myTeamUsersCheck = implode(',', $myTeamUsers);			
			if( empty($myTeamUsers)) $myTeamUsersCheck='0';
			$AssCond = " and user_id in ($myTeamUsersCheck) ";
			
			// GET APPS NAMES
			$deptFolder = "";
			if($ses_dept_id != 'ALL' && !empty($ses_dept_id)){
				$depSql = "SELECT folder as value from department WHERE id = '$ses_dept_id'";
				$deptFolder = $this->Common_model->get_single_value($depSql);
			}
			
			$filterArray = [
				"dept_id" => $ses_dept_id,
				"dept_folder" => $deptFolder,
				"office_id" => $user_office_id,
				"client_id" => $setclient,
				"process_id" => $setprocess,
			];
			$productiveApps = $this->get_user_filter_apps($filterArray, 'productive', 'pipe');
			$noncomplianceApps = $this->get_user_filter_apps($filterArray, 'noncompliance', 'pipe');
			
			
			// TOP PRODUCTIVE APPS
			$sql_topproductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, app_name FROM egaze_activities_details $innrJoin WHERE start_datetime >= '$filter_date_start' AND start_datetime <= '$filter_date_end'  $AssCond 
		    AND (app_name RLIKE '$productiveApps')
		    GROUP BY app_name ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_productive'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive);
			
			// TOP NON COMPLIANCE APPS
			$sql_tounpproductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, app_name  FROM egaze_activities_details $innrJoin WHERE start_datetime >= '$filter_date_start' AND start_datetime <= '$filter_date_end' 
			$AssCond
			AND (app_name RLIKE '$noncomplianceApps')
			GROUP BY app_name ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_unproductive'] = $querytotal = $this->Common_model->get_query_result_array($sql_tounpproductive);
			
			/*
			// TOP EMPLOYEE ON PRODUCTIVE APPS
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE start_datetime >= '$filter_date_start' AND start_datetime <= '$filter_date_end' $AssCond 
			  AND (app_name RLIKE '$productiveApps')
			  GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";			 
			$data['top_productive_emp'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
						
			// TOP EMPLOYEE ON NON COMPLIANCE APPS
			$sql_topunproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE start_datetime >= '$filter_date_start' AND start_datetime <= '$filter_date_end' $AssCond
			 AND (app_name RLIKE '$noncomplianceApps')
			 GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";			
			$data['top_unproductive_emp'] = $querytotal = $this->Common_model->get_query_result_array($sql_topunproductive_emp);
			*/
			
			// TOP MOST HOURS EMPLOYEE
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, user_id FROM egaze_activities_details $innrJoin WHERE start_datetime >= '$filter_date_start' AND start_datetime <= '$filter_date_end' $AssCond
			GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_emp_hours'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			// TOP LESS HOURS EMPLOYEE
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, user_id FROM egaze_activities_details $innrJoin WHERE start_datetime >= '$filter_date_start' AND start_datetime <= '$filter_date_end' $AssCond
			GROUP BY user_id ORDER BY totaltimespent ASC LIMIT 10";
			$data['less_emp_hours'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			//$data['myactivities'] = $this->get_activities_records($current_user);
			//$data['myevents'] = $this->get_events_records($current_user);
			$data['mydetails'] = $this->get_user_details($current_user);
			
			//$this->output->enable_profiler(TRUE);
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	

	
	/*============= REPORTS TEAM DASHBOARD ===================*/
	function reports()
	{
		if(check_logged_in()){	
		
			$_SESSION['pmenu'] = "4";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/dashboard.php";
			
			if($this->uri->segment(3) == 'last'){ 
				$this->output->enable_profiler(TRUE);
			}
			
			// GET USER DETAILS
			//$sdate = GetLocalDate();
			//$edate = GetLocalDate();
			
			$sdate = date('Y-m-d');
			$edate = date('Y-m-d');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			//if($current_user == "1"){  $current_user = "4"; }
			
			
			// CHECK DATE STATUS
			$current_date = $this->input->get('d');
			if(empty($current_date)){ $current_date = $sdate; /*$current_date = "2020-04-14";*/ }
			
			$usergetoffice = $this->input->get('office');
		    if($usergetoffice != ""){ $user_office_id = $usergetoffice; }
			
			$usergetdept = $this->input->get('dept');
		    if($usergetdept != ""){ $ses_dept_id = $usergetdept; }
			
			$setclient = "ALL";
			$userclient = $this->input->get('client');
		    if($userclient != ""){ $setclient = $userclient; }
			
			$setprocess = "ALL";
			$userprocess = $this->input->get('process');
		    if($userprocess != ""){ $setprocess = $userprocess; }
			
			$usergetdate = $this->input->get('d');
		    if($usergetdate != ""){ $current_date = $usergetdate; }
			
			$data['office_now'] = $user_office_id;
			$data['department_now'] = $ses_dept_id;
			$data['client_now'] = $setclient;
			$data['process_now'] = $setprocess;
			$data['user_now'] = $current_user;
			$data['date_now'] = $current_date;
			
			$current_start_date = $current_date ." 00:00:00";
			$current_end_date = $current_date ." 23:59:59";
			
			
			// CHECK TEAM STATUS			
			if($is_global_access == 1 || get_site_admin()==1 || isAccessGlobalEGaze()==true) {
				$getmyteam = $this->get_assigned_details('', '', $user_office_id, $ses_dept_id, $setclient, $setprocess);
				
				$sqloffice = "SELECT abbr, location, is_active from office_location 
				WHERE abbr IN (SELECT DISTINCT(office_id) from signin WHERE id IN (SELECT DISTINCT(user_id) from egaze_activities_details))";
				$data['location_list'] = $this->Common_model->get_query_result_array($sqloffice);
				
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($setclient);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
			} else { 
				$getmyteam = $this->get_assigned_details($current_user, '', $user_office_id);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);	
				
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($setclient);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
			}
	
			$myteam = implode(', ', array_column($getmyteam, 'user_id'));
			
			
			// CHECK BAR COLOUR
			$data['colour_array'] = array('bg-success', 'bg-danger', 'bg-primary', 'bg-warning');
			
			if($myteam == ""){ $myteam = '9999999'; }
				
			$sql = "SELECT e.user_id, concat(s.fname, ' ', s.lname) as fullname, s.is_logged_in, 
			        SUM(TIME_TO_SEC(e.total_time_spent)) as totaltimespent, i.idletime
					FROM egaze_activities_details as e
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time)) as idletime 
					FROM egaze_event_details WHERE date(end_dt) = '$current_date'
					GROUP BY user_id) as i ON i.user_id = e.user_id
					LEFT JOIN signin as s ON s.id = e.user_id
					WHERE 
					(start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date')
					AND e.user_id IN ($myteam)
					GROUP BY e.user_id
					ORDER BY fullname";		

			//echo	$sql;
			
			$data['activities'] = $activities = $this->Common_model->get_query_result_array($sql);
			
			foreach($activities as $tokenm){
				
				$e_userid = $tokenm['user_id'];
				$e_name = $tokenm['fullname'];
				$totaltime = $tokenm['totaltimespent'];
				$totalidle = $tokenm['idletime'];
				
				//======== PRODUCTIVE UNPORDUCTIVE APPS
				$data['apps'][$e_userid]['apps_productive'] = $productive_apps = $this->get_user_config_apps($e_userid, 'productive');
				$data['apps'][$e_userid]['apps_noncompliance'] = $unproductive_apps = $this->get_user_config_apps($e_userid, 'noncompliance');
				$productiveFilter = implode('|', $productive_apps);
				$unproductiveFilter = implode('|', $unproductive_apps);
				
				$productiveTime = 0;
				if(!empty($productiveFilter)){
				$sqlProductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as value 
					FROM egaze_activities_details WHERE (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date') AND
					(app_name RLIKE '$productiveFilter') AND user_id = '$e_userid'";
				$productiveTime =  $this->Common_model->get_single_value($sqlProductive);
				}
				
				$nonComplianceTime = 0;
				if(!empty($unproductiveFilter)){
				$sqlNonCompliance = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as value 
					FROM egaze_activities_details WHERE (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date') AND
					(app_name RLIKE '$unproductiveFilter') AND user_id = '$e_userid'";
				$nonComplianceTime =  $this->Common_model->get_single_value($sqlNonCompliance);
				}
				
				/*$extraFilter = "";
				if(!empty($productiveFilter) || !empty($unproductiveFilter)){ 
					if(!empty($productiveFilter)){ $extraFilter .= " AND app_name NOT RLIKE '$productiveFilter' "; }
					if(!empty($unproductiveFilter)){ $extraFilter .= " AND app_name NOT RLIKE '$unproductiveFilter' "; }
				}
				$sqlUnProductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as value 
					FROM egaze_activities_details WHERE (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date') $extraFilter AND user_id = '$e_userid'";
				$unproductiveTime =  $this->Common_model->get_single_value($sqlUnProductive);
				*/
				
				$unproductiveTime = $totaltime - ($productiveTime + $nonComplianceTime);
				
				$data['apps'][$e_userid]['user_id'] = $e_userid;
				$data['apps'][$e_userid]['user_name'] = $e_name;
				$data['apps'][$e_userid]['productive'] = round($productiveTime);
				$data['apps'][$e_userid]['noncompliance'] = round($nonComplianceTime);
				$data['apps'][$e_userid]['unproductive'] = round($unproductiveTime);
				$data['apps'][$e_userid]['idletime'] = round($totalidle);
				$data['apps'][$e_userid]['totaltime'] = round($totaltime);
			}		
			
			//echo "<pre>" .print_r($data['apps'] , 1) ."</pre>";
			
			if($this->input->get('csv') == 'yes'){
			    ob_start();
			    $this->reports_csv_download($data, $sdate ."_reports.csv");
				ob_get_clean;
			}
			
			$this->load->view('dashboard',$data);
		
		}			
	}
	
	
	

	function timeline()
	{
		if(check_logged_in()){	
		
			$_SESSION['pmenu'] = "3";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/timeline.php";
		
			
			// GET USER DETAILS
			$sdate = GetLocalDate() ." 00:00:00";
			$edate = GetLocalDate() ." 23:59:59";
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			//if($current_user == "1"){  $current_user = "4"; }
			
			
			// CHECK TEAM STATUS
			if($is_global_access==1 || get_site_admin()==1) $getmyteam = $this->get_assigned_details();
			else $getmyteam = $this->get_assigned_details($current_user);
			$myteam = implode(', ', array_column($getmyteam, 'user_id'));
			
			// CHECK DATE STATUS
			$current_date = $this->input->get('d');
			if(empty($current_date)){ $current_date = GetLocalDate(); /*$current_date = "2020-04-14";*/ }
			
			$current_start_date = $current_date ." 00:00:00";
			$current_end_date = $current_date ." 23:59:59";
			
			
			// CHECK BAR COLOUR
			$data['colour_array'] = array('bg-success', 'bg-danger', 'bg-primary', 'bg-warning');
						
			$data['my_date'] = $current_date;
				
			$sql = "SELECT e.user_id, concat(s.fname, ' ', s.lname) as fullname, s.is_logged_in, 
			        SUM(TIME_TO_SEC(e.total_time_spent)) as totaltimespent, 
					p.productiveapps, u.unproductiveapps, k.unknownapps, i.idletime
					FROM egaze_activities_details as e
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as productiveapps 
					FROM egaze_activities_details WHERE (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date') AND
					(app_name IN (SELECT app_name from egaze_productive_apps))
					GROUP BY user_id) as p ON p.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as unproductiveapps 
					FROM egaze_activities_details WHERE (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date') AND
					(app_name IN (SELECT app_name from egaze_noncompliance_apps))
					GROUP BY user_id) as u ON u.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as unknownapps 
					FROM egaze_activities_details WHERE (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date') AND
					(app_name NOT IN (SELECT app_name from egaze_noncompliance_apps)
					AND app_name NOT IN (SELECT app_name from egaze_productive_apps))
					GROUP BY user_id) as k ON k.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time)) as idletime 
					FROM egaze_event_details WHERE start_dt >= '$current_start_date' AND start_dt <= '$current_end_date'
					GROUP BY user_id) as i ON i.user_id = e.user_id
					LEFT JOIN signin as s ON s.id = e.user_id
					WHERE 
					date(start_datetime) = '$current_date' 
					AND e.user_id IN ($myteam)
					GROUP BY e.user_id
					ORDER BY fullname";
			$data['activities'] = $this->Common_model->get_query_result_array($sql);
			
			$this->load->view('dashboard',$data);
		
		}			
	}
	
	
	
    //=============================== GOOGLE TIMELINE TEAM ACTIVITIES ================================//
	function realtime_23()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "3";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/teammonitoring.php";
			
			if($this->uri->segment(3) == 'last'){ 
				$this->output->enable_profiler(TRUE);
			}
			
			//$sdate = GetLocalDate();
			//$edate = GetLocalDate();
			
			//-->FOR EST DATE
			$sdate = date('Y-m-d');
			$edate = date('Y-m-d');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			//--> FOR ADMIN DEMO USER
			//if($current_user == "1"){  $current_user = "4"; }
			
			$data['searchingq'] = $extrasearch = "";
			
			$userget = $this->input->get('qsearch');
		    if($userget != ""){ $extrasearch = $data['searchingq'] = $userget; }
			
			$usergetdept = $this->input->get('dept');
		    if($usergetdept != ""){ $ses_dept_id = $usergetdept; }
			
			$usergetoffice = $this->input->get('office');
		    if($usergetoffice != ""){ $user_office_id = $usergetoffice; }
			
			$setclient = "ALL";
			$userclient = $this->input->get('client');
		    if($userclient != ""){ $setclient = $userclient; }
			
			$setprocess = "ALL";
			$userprocess = $this->input->get('process');
		    if($userprocess != ""){ $setprocess = $userprocess; }
			
			$usergetdate = $this->input->get('d');
		    if($usergetdate != ""){ $sdate = $usergetdate; $edate = $usergetdate; }
			
			$data['office_now'] = $user_office_id;
			$data['department_now'] = $ses_dept_id;
			$data['client_now'] = $setclient;
			$data['process_now'] = $setprocess;
			$data['user_now'] = $current_user;
			$data['date_now'] = $sdate;
			
			$start_date = $sdate . " 00:00:00";
			$end_date = $sdate . " 23:59:59";
			
			// DROPDOWN FILTER LIST
			$sl = 1;
			if($is_global_access == 1 || get_site_admin()==1 || isAccessGlobalEGaze()==true){ 
				
				$sqloffice = "SELECT abbr, location, is_active from office_location 
				WHERE abbr IN (SELECT DISTINCT(office_id) from signin WHERE id IN (SELECT DISTINCT(user_id) from egaze_activities_details))";
				
				$data['location_list'] = $this->Common_model->get_query_result_array($sqloffice);
				
				$data['myteam'] = $myteamd = $this->get_assigned_details("", $extrasearch, $user_office_id, $ses_dept_id, $setclient, $setprocess);
				
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($setclient);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				
			}
			else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				
				$data['myteam'] = $myteamd = $this->get_assigned_details($current_user, $extrasearch, $user_office_id);
				
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				
			}
			
		    //echo "<pre>". print_r($myteamd, true) ."</pre>";die;
		    $data['found'] = 0; $errorsFound = "";
			foreach($myteamd as $tokend)
			{
				
				$uid = $tokend['user_id'];
				$fname = $tokend['fullname'];
				$fid = $tokend['fusion_id'];
				$mydata = "";
				
				//-> FOR DEMO CHECK 
				//$demo_uid = $uid;
				//if($uid == "6468"){ $demo_uid = "14951"; }
				//$data['team'][$uid] = $activities_records = $this->get_activities_records($demo_uid, '0', $sdate, $edate);
				
				$data['team'][$uid] = $activities_records = $this->get_activities_records($uid, '0', $sdate, $edate);
				$data['ideal'][$uid] = $events_records = $this->get_events_records($uid, '0', $sdate, $edate);
				$data['link'][$uid] = base_url() ."egaze/individual?uid=" .$uid;
				
				//======== PRODUCTIVE UNPORDUCTIVE APPS
				$data['myapp'] = $productive_apps = $this->get_user_config_apps($uid, 'productive');
				$data['myuapp'] = $unproductive_apps = $this->get_user_config_apps($uid, 'noncompliance');
				$productiveFilter = implode('|', $productive_apps);
				$unproductiveFilter = implode('|', $unproductive_apps);
				
				// FOR ALL USER NAMES DISPAY
				//$mydata .= "[ '".$tokend['fullname']."',  '".$tokend['fullname']."',    new Date(0,0,0,0,0,0),  new Date(0,0,0,0,0,0) ],"; 
				
				foreach($activities_records as $tokenr)
				{
					$s_date = date('d', strtotime($tokenr['start_datetime']));
					$s_month = date('m', strtotime($tokenr['start_datetime']));
					$s_year = date('Y', strtotime($tokenr['start_datetime']));
					$s_hour = date('H', strtotime($tokenr['start_datetime']));
					$s_min = date('i', strtotime($tokenr['start_datetime']));
					$s_sec = date('s', strtotime($tokenr['start_datetime']));
					
					$e_date = date('d', strtotime($tokenr['end_datetime']));
					$e_month = date('m', strtotime($tokenr['end_datetime']));
					$e_year = date('Y', strtotime($tokenr['end_datetime']));
					$e_hour = date('H', strtotime($tokenr['end_datetime']));
					$e_min = date('i', strtotime($tokenr['end_datetime']));
					$e_sec = date('s', strtotime($tokenr['end_datetime']));
					
					//GET ACTIVITY TYPE
					$colorchange = "color:#88BFB9";
					
					// SEARCH APPS
					$searchInput = preg_quote($tokenr['app_name'], '~');
					
					if(!empty($productive_apps)){
					$productiveSearch = preg_grep('~' . $searchInput . '~', $productive_apps);
					if(!empty($productiveSearch)){ $colorchange = "color:#2D8120"; }
					}
					
					if(!empty($unproductive_apps)){
					$noncomplianceSearch = preg_grep('~' . $searchInput . '~', $unproductive_apps);
					if(!empty($noncomplianceSearch)){ $colorchange = "color:#FF0202"; }
					}
					
					if($tokenr['start_datetime'] > $tokenr['end_datetime']){ $errorsFound .= "ERROR : egaze_activities_details - id(" .$tokenr['id'] .") - ".$tokenr['app_name'] ." | " .$tokend['fullname'] ." - " .$uid ." - " .$fid ." | Start Date : " .$tokenr['start_datetime'] ." - End Date : " .$tokenr['end_datetime'] ."<br/>"; }
					
					if($tokenr['start_datetime'] <= $tokenr['end_datetime']){ 
					$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['app_name']."',  '".$colorchange."',  new Date(".$s_year.",".$s_month.",".$s_date.",".$s_hour.",".$s_min.",".$s_sec."),  new Date(".$e_year.",".$e_month.",".$e_date.",".$e_hour.",".$e_min.",".$e_sec.") ],"; 
					
					}
					
				}			
				
				
				foreach($events_records as $tokenr)
				{
					$s_date = date('d', strtotime($tokenr['start_dt']));
					$s_month = date('m', strtotime($tokenr['start_dt']));
					$s_year = date('Y', strtotime($tokenr['start_dt']));
					$s_hour = date('H', strtotime($tokenr['start_dt']));
					$s_min = date('i', strtotime($tokenr['start_dt']));
					$s_sec = date('s', strtotime($tokenr['start_dt']));
					
					$e_date = date('d', strtotime($tokenr['end_dt']));
					$e_month = date('m', strtotime($tokenr['end_dt']));
					$e_year = date('Y', strtotime($tokenr['end_dt']));
					$e_hour = date('H', strtotime($tokenr['end_dt']));
					$e_min = date('i', strtotime($tokenr['end_dt']));
					$e_sec = date('s', strtotime($tokenr['end_dt']));
					
					//GET ACTIVITY TYPE
					$colorchange = "color:#000000";
					
					if($tokenr['start_dt'] > $tokenr['end_dt']){ $errorsFound .= "ERROR : egaze_event_details - id(" .$tokenr['id'] .") -".$tokenr['event_name'] ." | " .$tokend['fullname'] ." - " .$uid ." - " .$fid ." | Start Date : " .$tokenr['start_dt'] ." - End Date : " .$tokenr['end_dt'] ."<br/>"; }
					
					if($tokenr['start_dt'] <= $tokenr['end_dt']){
					$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['event_name']."',  '".$colorchange."',  new Date(".$s_year.",".$s_month.",".$s_date.",".$s_hour.",".$s_min.",".$s_sec."),  new Date(".$e_year.",".$e_month.",".$e_date.",".$e_hour.",".$e_min.",".$e_sec.") ],"; 
					}
					
				}
				
				
				$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$uid' AND (start_dt >= '$start_date' AND start_dt <= '$end_date')";
				$data['totalidle'][$uid] = $querytotal = $this->Common_model->get_single_value($sqltotal);
				
				$data['team']['chart'][$uid] = $mydata;
				
				if($mydata != ""){ $sl++; $data['found'] = $sl; }
				
			}
			
			$data['errorsFound'] = $errorsFound;
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	//=============================== GOOGLE TIMELINE TEAM ACTIVITIES ================================//
	function realtime()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "3";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/teammonitoring.php";
			
			//$this->output->enable_profiler(TRUE);
			
			//$sdate = GetLocalDate();
			//$edate = GetLocalDate();
			
			//-->FOR EST DATE
			$sdate = date('Y-m-d');
			$edate = date('Y-m-d');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			//--> FOR ADMIN DEMO USER
			//if($current_user == "1"){  $current_user = "4"; }
			
			$data['searchingq'] = $extrasearch = "";
			
			$userget = $this->input->get('qsearch');
		    if($userget != ""){ $extrasearch = $data['searchingq'] = $userget; }
			
			$usergetdept = $this->input->get('dept');
		    if($usergetdept != ""){ $ses_dept_id = $usergetdept; }
			
			$usergetoffice = $this->input->get('office');
		    if($usergetoffice != ""){ $user_office_id = $usergetoffice; }
			
			$setclient = "ALL";
			$userclient = $this->input->get('client');
		    if($userclient != ""){ $setclient = $userclient; }
			
			$setprocess = "ALL";
			$userprocess = $this->input->get('process');
		    if($userprocess != ""){ $setprocess = $userprocess; }
			
			$usergetdate = $this->input->get('d');
		    if($usergetdate != ""){ $sdate = $usergetdate; $edate = $usergetdate; }
			
			$data['office_now'] = $user_office_id;
			$data['department_now'] = $ses_dept_id;
			$data['client_now'] = $setclient;
			$data['process_now'] = $setprocess;
			$data['user_now'] = $current_user;
			$data['date_now'] = $sdate;
			
			$start_date = $sdate . " 00:00:00";
			$end_date = $sdate . " 23:59:59";
			
			// DROPDOWN FILTER LIST
			$sl = 1;
			if($is_global_access == 1 || get_site_admin()==1 || isAccessGlobalEGaze()==true){ 
				$sqloffice = "SELECT abbr, location, is_active from office_location 
				WHERE abbr IN (SELECT DISTINCT(office_id) from signin WHERE id IN (SELECT DISTINCT(user_id) from egaze_activities_details))";
				$data['location_list'] = $this->Common_model->get_query_result_array($sqloffice);
				
				$data['myteam'] = $myteamd = $this->get_assigned_details("", $extrasearch, $user_office_id, $ses_dept_id, $setclient, $setprocess);
				
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($setclient);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				
			}
			else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				
				$data['myteam'] = $myteamd = $this->get_assigned_details($current_user, $extrasearch, $user_office_id);
				
				$departmentlist = "SELECT * FROM department WHERE is_active = '1'";
				$data['department_list'] = $this->Common_model->get_query_result_array($departmentlist);
				
				
				$qSql=" Select id as client_id, shname from client where is_active='1' ";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($setclient!="ALL" && $setclient!="" && $setclient!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				
			}
			
			$myTeamUsers = array_column($myteamd, 'user_id');
			$myTeamUsersCheck = implode(',', $myTeamUsers);
			
			$data['allteam'] = $all_activities_records = $this->get_activities_records_all($myTeamUsersCheck, '0', $sdate, $edate);
			$data['allideal'] = $all_events_records = $this->get_events_records_all($myTeamUsersCheck, '0', $sdate, $edate);
			
			$ar_activity_records = array();
			foreach($all_activities_records as $token)
			{
				$ar_user_id = $token['user_id'];
				$ar_activity_records[$ar_user_id][] = $token;
			}
			
			$ar_event_records = array();
			foreach($all_events_records as $token)
			{
				$ar_user_id = $token['user_id'];
				$ar_event_records[$ar_user_id][] = $token;
			}
			
			
		    //echo "<pre>". print_r($all_activities_records, true) ."</pre>";die;
		    $data['found'] = 0; $errorsFound = "";
			foreach($myteamd as $tokend)
			{
				
				$uid = $tokend['user_id'];
				$fname = $tokend['fullname'];
				$fid = $tokend['fusion_id'];
				$mydata = "";
				
				//-> FOR DEMO CHECK 
				//$demo_uid = $uid;
				//if($uid == "6468"){ $demo_uid = "14951"; }
				//$data['team'][$uid] = $activities_records = $this->get_activities_records($demo_uid, '0', $sdate, $edate);
				
				//$data['team'][$uid] = $activities_records = $this->get_activities_records($uid, '0', $sdate, $edate);
				//$data['ideal'][$uid] = $events_records = $this->get_events_records($uid, '0', $sdate, $edate);
				
				$data['team'][$uid] = $activities_records = array();
				$data['ideal'][$uid] = $events_records = array();
				if(!empty($ar_activity_records[$uid])){ $data['team'][$uid] = $activities_records = $ar_activity_records[$uid]; }
				if(!empty($ar_event_records[$uid])){ $data['ideal'][$uid] = $events_records = $ar_event_records[$uid]; }
				
				$data['link'][$uid] = base_url() ."egaze/individual?uid=" .$uid;
				
				//======== PRODUCTIVE UNPORDUCTIVE APPS
				$data['myapp'] = $productive_apps = $this->get_user_config_apps($uid, 'productive');
				$data['myuapp'] = $unproductive_apps = $this->get_user_config_apps($uid, 'noncompliance');
				$productiveFilter = implode('|', $productive_apps);
				$unproductiveFilter = implode('|', $unproductive_apps);
				
				// FOR ALL USER NAMES DISPAY
				//$mydata .= "[ '".$tokend['fullname']."',  '".$tokend['fullname']."',    new Date(0,0,0,0,0,0),  new Date(0,0,0,0,0,0) ],"; 
				
				foreach($activities_records as $tokenr)
				{
					$s_date = date('d', strtotime($tokenr['start_datetime']));
					$s_month = date('m', strtotime($tokenr['start_datetime']));
					$s_year = date('Y', strtotime($tokenr['start_datetime']));
					$s_hour = date('H', strtotime($tokenr['start_datetime']));
					$s_min = date('i', strtotime($tokenr['start_datetime']));
					$s_sec = date('s', strtotime($tokenr['start_datetime']));
					
					$e_date = date('d', strtotime($tokenr['end_datetime']));
					$e_month = date('m', strtotime($tokenr['end_datetime']));
					$e_year = date('Y', strtotime($tokenr['end_datetime']));
					$e_hour = date('H', strtotime($tokenr['end_datetime']));
					$e_min = date('i', strtotime($tokenr['end_datetime']));
					$e_sec = date('s', strtotime($tokenr['end_datetime']));
					
					//GET ACTIVITY TYPE
					$colorchange = "color:#88BFB9";
					
					// SEARCH APPS
					$searchInput = preg_quote($tokenr['app_name'], '~');
					
					if(!empty($productive_apps)){
					$productiveSearch = preg_grep('~' . $searchInput . '~', $productive_apps);
					if(!empty($productiveSearch)){ $colorchange = "color:#2D8120"; }
					}
					
					if(!empty($unproductive_apps)){
					$noncomplianceSearch = preg_grep('~' . $searchInput . '~', $unproductive_apps);
					if(!empty($noncomplianceSearch)){ $colorchange = "color:#FF0202"; }
					}
					
					if($tokenr['start_datetime'] > $tokenr['end_datetime']){ $errorsFound .= "ERROR : egaze_activities_details - id(" .$tokenr['id'] .") - ".$tokenr['app_name'] ." | " .$tokend['fullname'] ." - " .$uid ." - " .$fid ." | Start Date : " .$tokenr['start_datetime'] ." - End Date : " .$tokenr['end_datetime'] ."<br/>"; }
					
					if($tokenr['start_datetime'] <= $tokenr['end_datetime']){ 
					$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['app_name']."',  '".$colorchange."',  new Date(".$s_year.",".$s_month.",".$s_date.",".$s_hour.",".$s_min.",".$s_sec."),  new Date(".$e_year.",".$e_month.",".$e_date.",".$e_hour.",".$e_min.",".$e_sec.") ],"; 
					}
					
				}			
				
				
				foreach($events_records as $tokenr)
				{
					$s_date = date('d', strtotime($tokenr['start_dt']));
					$s_month = date('m', strtotime($tokenr['start_dt']));
					$s_year = date('Y', strtotime($tokenr['start_dt']));
					$s_hour = date('H', strtotime($tokenr['start_dt']));
					$s_min = date('i', strtotime($tokenr['start_dt']));
					$s_sec = date('s', strtotime($tokenr['start_dt']));
					
					$e_date = date('d', strtotime($tokenr['end_dt']));
					$e_month = date('m', strtotime($tokenr['end_dt']));
					$e_year = date('Y', strtotime($tokenr['end_dt']));
					$e_hour = date('H', strtotime($tokenr['end_dt']));
					$e_min = date('i', strtotime($tokenr['end_dt']));
					$e_sec = date('s', strtotime($tokenr['end_dt']));
					
					//GET ACTIVITY TYPE
					$colorchange = "color:#000000";
					
					if($tokenr['start_dt'] > $tokenr['end_dt']){ $errorsFound .= "ERROR : egaze_event_details - id(" .$tokenr['id'] .") -".$tokenr['event_name'] ." | " .$tokend['fullname'] ." - " .$uid ." - " .$fid ." | Start Date : " .$tokenr['start_dt'] ." - End Date : " .$tokenr['end_dt'] ."<br/>"; }
					
					if($tokenr['start_dt'] <= $tokenr['end_dt']){
					$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['event_name']."',  '".$colorchange."',  new Date(".$s_year.",".$s_month.",".$s_date.",".$s_hour.",".$s_min.",".$s_sec."),  new Date(".$e_year.",".$e_month.",".$e_date.",".$e_hour.",".$e_min.",".$e_sec.") ],"; 
					}
					
				}
				
				
				$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$uid' AND (start_dt >= '$start_date' AND start_dt <= '$end_date')";
				$data['totalidle'][$uid] = $querytotal = $this->Common_model->get_single_value($sqltotal);
				
				$data['team']['chart'][$uid] = $mydata;
				
				if($mydata != ""){ $sl++; $data['found'] = $sl; }
				
			}
			
			$data['errorsFound'] = $errorsFound;
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	
	 //================== GOOGLE TIMELINE EACH EMPLOYEE ACTIVITY DETAIL PAGE =======================//
	function individual()
	{
		//$this->output->enable_profiler(TRUE);
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/individual.php";
						
			//$sdate = GetLocalDate();
			//$edate = GetLocalDate();
			
			$sdate = date('Y-m-d');
			$edate = date('Y-m-d');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			$data['user_now'] = "";
			if( get_role_dir()!="agent" ||  get_global_access()=='1'){ 
				$userget = $this->input->get('uid');
				if($userget != ""){ $current_user = $userget; }
				
			}
			
			$usergetdate = $this->input->get('d');
		    if($usergetdate != ""){ $sdate = $usergetdate; $edate = $usergetdate; }
						
			//$sdate = "2020-05-01";
			//$current_user = "6566";
			
			$data['date_now'] = $sdate;			
			$data['user_now'] = $current_user;
			
			$current_start_date = $sdate ." 00:00:00";
			$current_end_date = $sdate ." 23:59:59";
			
			
			//======== PRODUCTIVE UNPORDUCTIVE APPS
			$data['myapp'] = $productive_apps = $this->get_user_config_apps($current_user, 'productive');
			$data['myuapp'] = $unproductive_apps = $this->get_user_config_apps($current_user, 'noncompliance');
			$productiveFilter = implode('|', $productive_apps);
			$unproductiveFilter = implode('|', $unproductive_apps);
			
			//echo $productiveFilter ."<br/>" .$unproductiveFilter;
			//echo "<pre>".print_r($productive_apps, 1)."</pre>";
			//echo "<pre>".print_r($unproductiveFilter, 1)."</pre>";
			//die();
			
			//======== ACTIVITIES DETAILS 			
			$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$current_user' AND (start_dt >= '$current_start_date' AND start_dt <= '$current_end_date')";
			$data['total_idle'] = $querytotal = $this->Common_model->get_single_value($sqltotal);
			
			$sqlactivity = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details 
			WHERE user_id = '$current_user' AND (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date')";
			$data['total_time_activity'] = $querytotal = $this->Common_model->get_query_row_array($sqlactivity);
			
			$sqlproductivty = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details 
			WHERE user_id = '$current_user' AND (start_datetime >= '$current_start_date' AND start_datetime <= '$current_end_date') 
			AND ((app_name RLIKE '$productiveFilter'))";
			$data['total_time_productivity'] = $querytotal = $this->Common_model->get_query_row_array($sqlproductivty);
			
			$data['myactivities'] = $this->get_activities_records($current_user, 0, $sdate, $edate);
			$data['activities_group'] = $this->get_activities_records_classified($current_user, 0, $sdate, $edate);
			$data['myevents'] = $this->get_events_records($current_user, 0, $sdate, $edate);
			$data['mydetails'] = $mydetails = $this->get_user_details($current_user);
			
			
			//------ PREVIOUS WEEK RECORDS
			$start_date_week = date('Y-m-d', strtotime('monday this week', strtotime($sdate)));
			for($i=0;$i<7;$i++)
			{
				$start_date_week_start = $start_date_week ." 00:00:00";
				$start_date_week_end = $start_date_week ." 23:59:59";
				
				$sqldate = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details WHERE user_id IN ($current_user) AND (start_datetime >= '$start_date_week_start' AND start_datetime <= '$start_date_week_end')";
				$querydate = $this->Common_model->get_query_row_array($sqldate);
				
				
				$sqlp_date = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details 
				WHERE user_id IN ($current_user) AND (start_datetime >= '$start_date_week_start' AND start_datetime <= '$start_date_week_end') 
				AND ((app_name RLIKE '$productiveFilter'))";
				$queryp_date = $this->Common_model->get_query_row_array($sqlp_date);
				
				$data['date'][$i+1]['date'] = $start_date_week;
				$data['date'][$i+1]['seconds'] = round($querydate['total_seconds']);
				$data['date'][$i+1]['total'] = (($querydate['total_time']) != "") ? $querydate['total_time'] : "00:00:00";
				$data['date'][$i+1]['p_seconds'] = round($queryp_date['total_seconds']);
				$data['date'][$i+1]['p_total'] = (($queryp_date['total_time']) != "") ? $queryp_date['total_time'] : "00:00:00";
				
				$start_date_week = date('Y-m-d', strtotime("+1 day", strtotime($start_date_week)));
				
			}
			
			//echo "<pre>".print_r($data['date'], true)."</pre>";die;
			
			$mydata = "";
			foreach($data['myactivities'] as $tokenr)
			{
				$s_date = date('d', strtotime($tokenr['start_datetime']));
				$s_month = date('m', strtotime($tokenr['start_datetime']));
				$s_year = date('Y', strtotime($tokenr['start_datetime']));
				$s_hour = date('H', strtotime($tokenr['start_datetime']));
				$s_min = date('i', strtotime($tokenr['start_datetime']));
				$s_sec = date('s', strtotime($tokenr['start_datetime']));
				
				$e_date = date('d', strtotime($tokenr['end_datetime']));
				$e_month = date('m', strtotime($tokenr['end_datetime']));
				$e_year = date('Y', strtotime($tokenr['end_datetime']));
				$e_hour = date('H', strtotime($tokenr['end_datetime']));
				$e_min = date('i', strtotime($tokenr['end_datetime']));
				$e_sec = date('s', strtotime($tokenr['end_datetime']));
				
				// GET ACTIVITY TYPE
				$colorchange = "color:#88BFB9";
				
				// SEARCH APPS
				$searchInput = preg_quote($tokenr['app_name'], '~');
				
				if(!empty($productive_apps)){
				$productiveSearch = preg_grep('~' . $searchInput . '~', $productive_apps);
				if(!empty($productiveSearch)){ $colorchange = "color:#2D8120"; }
				}
				
				if(!empty($unproductive_apps)){
				$noncomplianceSearch = preg_grep('~' . $searchInput . '~', $unproductive_apps);
				if(!empty($noncomplianceSearch)){ $colorchange = "color:#FF0202"; }
				}
				
				// ADD DATA FOR ACTIVITIES TIMILEINE
				if($tokenr['start_datetime'] <= $tokenr['end_datetime']){ 
				$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['app_name']."',  '".$colorchange."',  new Date(".$s_year.",".$s_month.",".$s_date.",".$s_hour.",".$s_min.",".$s_sec."),  new Date(".$e_year.",".$e_month.",".$e_date.",".$e_hour.",".$e_min.",".$e_sec.") ],"; 
				}
				
			}
			
			foreach($data['myevents'] as $tokenr)
			{
				$s_date = date('d', strtotime($tokenr['start_dt']));
				$s_month = date('m', strtotime($tokenr['start_dt']));
				$s_year = date('Y', strtotime($tokenr['start_dt']));
				$s_hour = date('H', strtotime($tokenr['start_dt']));
				$s_min = date('i', strtotime($tokenr['start_dt']));
				$s_sec = date('s', strtotime($tokenr['start_dt']));
				
				$e_date = date('d', strtotime($tokenr['end_dt']));
				$e_month = date('m', strtotime($tokenr['end_dt']));
				$e_year = date('Y', strtotime($tokenr['end_dt']));
				$e_hour = date('H', strtotime($tokenr['end_dt']));
				$e_min = date('i', strtotime($tokenr['end_dt']));
				$e_sec = date('s', strtotime($tokenr['end_dt']));
				
				//GET ACTIVITY TYPE
				$colorchange = "color:#000000";
				
				// ADD DATA FOR IDLE TIMELINE
				if($tokenr['start_dt'] <= $tokenr['end_dt']){
				$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['event_name']."',  '".$colorchange."',  new Date(".$s_year.",".$s_month.",".$s_date.",".$s_hour.",".$s_min.",".$s_sec."),  new Date(".$e_year.",".$e_month.",".$e_date.",".$e_hour.",".$e_min.",".$e_sec.") ],";
				}
				
			}
			
			
			$myidle = "";				
			$data['myactivitieslist'] = $mydata;
			$data['myeventslist'] = $myidle;
				
					
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	
	
	 //================== DOWNLOAD REPORTS =======================//
	function download_reports()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "4";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/download_report.php";
							
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
			$sdate = GetLocalDate();
			$edate = GetLocalDate();
			
			$usergetdate_start = $this->input->post('start_date');
		    if($usergetdate_start != ""){ $sdate = $usergetdate_start; $edate = $usergetdate_start; }
			
			//$usergetdate_end = $this->input->post('end_date');
		    //if($usergetdate_end != ""){ $edate = $usergetdate_end; }
			
			$data['date_now'] = $sdate;
			
			$sdate_start = $sdate ." 00:00:00";
			$sdate_end = $sdate ." 23:59:59";
			
		    //================ OFFICE < CLIENT < PROCESS FILTER
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->post('office_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue="0";
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->post('process_id'));
			
			$_filterCond="";
			if($oValue!="ALL" && $oValue!="") $_filterCond = " AND s.office_id='".$oValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " AND is_assign_client(s.id, ".$cValue.")";
			if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " AND is_assign_process(s.id, ".$pValue.")";
			
			if($oValue!="ALL" && $oValue!="") $qSql="SELECT DISTINCT id as client_id, client.shname FROM client";
			else $qSql=" Select id as client_id, shname from client where is_active='1' ";	
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
			else $data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			//================ ID FILTER
			$userget = $this->input->post('fusion_id');
			if($userget != ""){ $_filterCond .= " AND s.fusion_id='".$userget."'"; }
			
			
			$report_type = $this->input->post('report_type');
			if($report_type == 1)
			{
				$sqlReport = "SELECT s.fusion_id as Fusion_ID, CONCAT(s.fname, ' ', s.lname) as Name, CONCAT(ls.fname, ' ', ls.lname) as L1_Supervisor,
				              s.office_id as Office, get_process_names(s.id) as Process, get_client_names(s.id) as Client, e.* 
				              from egaze_activities_details as e
				              LEFT JOIN signin as s ON e.user_id = s.id
				              LEFT JOIN signin as ls ON ls.id = s.assigned_to
				              WHERE (e.start_datetime >= '$sdate_start' AND e.start_datetime <= '$sdate_end') $_filterCond";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				$this->array_to_csv_download($queryReport, $sdate ."_activity_reports.csv");
			}
			
			if($report_type == 2)
			{
				$sqlReport = "SELECT s.fusion_id as Fusion_ID, CONCAT(s.fname, ' ', s.lname) as Name, CONCAT(ls.fname, ' ', ls.lname) as L1_Supervisor,
				              s.office_id as Office, get_process_names(s.id) as Process, get_client_names(s.id) as Client, e.* from egaze_event_details as e
				              LEFT JOIN signin as s ON e.user_id = s.id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
				              WHERE (e.end_dt >= '$sdate_start' AND e.end_dt <= '$sdate_end') $_filterCond";
				$queryReport = $this->Common_model->get_query_result_array($sqlReport);
				$this->array_to_csv_download($queryReport, $sdate ."_idle_reports.csv");				
			}
			
						
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	
	
	
    //=============================== MASTER APPS CONFIG ================================//
	function config()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "5";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/config.php";
			$data["content_js"] = "egaze/egaze_config_js.php";
						
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			// OFFICE FILTER
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// DEPARTMENT FILTER
			$data['department_list'] = $this->Common_model->get_department_list();
			
			// CLIENT FILTER
			$qSql="SELECT DISTINCT client.id as client_id, client.shname FROM client";
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			// PROCESS FILTER
			$data['process_list'] = $this->Common_model->get_process_list($cValue);
			
				
			//----- DATA PARAMETERS			
			$lastUrl = $this->uri->segment(3);
			if($lastUrl == 'productive')
			{
				$myapp = "SELECT e.*, c.shname as client_name, p.name as process_name, d.shname as department_name, CONCAT(s.fname, ' ', s.lname) as fullname 
			          from egaze_productive_apps as e
			          LEFT JOIN department as d ON d.id = e.dept_id
			          LEFT JOIN client as c ON c.id = e.client_id
			          LEFT JOIN process as p ON p.id = e.process_id
			          LEFT JOIN signin as s ON s.id = e.added_by
					  ";
				$data['myapp'] = $this->Common_model->get_query_result_array($myapp);	  
				$data["content_template"] = "egaze/config_productive.php";
			}
			
			if($lastUrl == 'noncompliance')
			{
				$myapp = "SELECT e.*, c.shname as client_name, p.name as process_name, d.shname as department_name, CONCAT(s.fname, ' ', s.lname) as fullname 
			          from egaze_noncompliance_apps as e
			          LEFT JOIN department as d ON d.id = e.dept_id
			          LEFT JOIN client as c ON c.id = e.client_id
			          LEFT JOIN process as p ON p.id = e.process_id
			          LEFT JOIN signin as s ON s.id = e.added_by
					  ";
				$data['myapp'] = $this->Common_model->get_query_result_array($myapp);
				$data["content_template"] = "egaze/config_noncompliance.php";
			}
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	public function submitConfig()
	{
		$current_user   = get_user_id();
		$app_name = $this->input->post('app_name');
		$app_type = $this->input->post('app_type');
		$is_global = $this->input->post('is_global');
		$office_id = $this->input->post('office_id');
		$dept_id = $this->input->post('department_id');
		$client_id = $this->input->post('client_id');
		$process_id = $this->input->post('process_id');
		
		if($is_global == 1){
			$dept_id = "0";
			$client_id = "0";
			$process_id = "0";
		}
		
		$data_array = [
			"app_name" => $app_name,	
			"office_id" => $office_id,	
			"dept_id" => $dept_id,	
			"client_id" => $client_id,	
			"process_id" => $process_id,	
			"is_global" => $is_global,	
			"date_added" => CurrMySqlDate(),	
			"added_by" => $current_user,	
			"logs" => get_logs(),
		];
		
		
		if($app_type == 'productive'){
			data_inserter('egaze_productive_apps', $data_array);
		}
		
		if($app_type == 'noncompliance'){
			data_inserter('egaze_noncompliance_apps', $data_array);
		}
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	public function deleteConfig()
	{
		$current_user   = get_user_id();
		
		if($this->input->get('del') == 1)
		{
			$delid = $this->input->get('did');
			if($this->input->get('type') == "papp")
			{
				$sql = "DELETE from egaze_productive_apps WHERE id = '$delid'";
			}
			
			if($this->input->get('type') == "uapp")
			{
				$sql = "DELETE from egaze_noncompliance_apps WHERE id = '$delid'";
			}
			$this->db->query($sql);
		}
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
	//=============================== GET ACTIVITIES DETAILS AJAX  ================================//
	public function activities_details_info()
	{
		$sid = $this->input->post('sid');
		$app = $this->input->post('appname');
		$date = $this->input->post('date');
		
		$startDate = $date ." 00:00:00";
		$endDate = $date ." 23:59:59";
		$sqlData = "SELECT * from egaze_activities_details  WHERE start_datetime >= '$startDate' AND end_datetime <= '$endDate' AND user_id = '$sid' AND app_name = '$app'";
		$queryData = $this->Common_model->get_query_result_array($sqlData);
		$data['current_records'] = $queryData;
		$this->load->view('egaze/individual_details', $data);
	}
	
	
	//=============================== USEFULL FUNCTIONS ================================//
	
	private function get_user_details($uid)
	{
		$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
					s.office_id, d.shname as department_name, r.name as designation from signin s 
					LEFT JOIN department d on s.dept_id = d.id
					LEFT JOIN role r on r.id = s.role_id
					WHERE s.id = '$uid'";
		$query = $this->Common_model->get_query_row_array($sqlusers);
		
		return $query;
	}
	
	
	//=============================== USER CONFIG APPS  ================================//
	
	public function get_user_config_apps($uid = "", $type="productive", $result="array")
	{
		if(empty($uid)){ $uid = get_user_id(); }
		$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, s.dept_id, s.role_id, 
		            get_client_ids(s.id) as client_ids, get_process_ids(s.id) as process_ids,
					s.office_id, d.shname as department_name, r.name as designation, r.folder as role_folder, d.folder as department_folder 
					from signin s 
					LEFT JOIN department d on s.dept_id = d.id
					LEFT JOIN role r on r.id = s.role_id
					WHERE s.id = '$uid'";
		$query = $this->Common_model->get_query_row_array($sqlusers);
		
		$role_id = $query['role_id'];
		$role_folder = $query['role_folder'];
		
		$dept_id = $query['dept_id'];		
		$dept_folder = $query['department_folder'];
		
		$office_id = $query['office_id'];
		$client_ids = $query['client_ids'];
		$process_ids = $query['process_ids'];
		$extraFilter = "";
		if($dept_folder != 'operations' )
		{
			if(!empty($dept_id) && $dept_id != "ALL"){
				$extraFilter .= " AND dept_id = '$dept_id'";
			}
		} else {
			if(!empty($dept_id) && $dept_id != "ALL"){
				$extraFilter .= " AND dept_id = '$dept_id'";
			}
			if(!empty($client_ids) && $client_ids != "ALL")
			{
				$extraFilter .= " AND client_id IN ($client_ids)";
			}
			if(!empty($process_ids) && $process_ids != "ALL")
			{
				$extraFilter .= " AND (process_id IN ($process_ids) OR process_id = 0)";
			}			
		}
		
		$appTable = "egaze_productive_apps";
	    if($type == 'productive'){ $appTable = "egaze_productive_apps"; }
	    if($type == 'noncompliance'){ $appTable = "egaze_noncompliance_apps"; }
		
		$sqlProductiveApps = "SELECT app_name from $appTable 
							  WHERE (is_global = 1 AND office_id = '0') OR (is_global = 1 AND office_id = '$office_id')
							  OR (is_global = 0 AND office_id = '$office_id' $extraFilter) 
							  OR (is_global = 1 AND office_id = 0 $extraFilter)";
		$queryApps = $this->Common_model->get_query_result_array($sqlProductiveApps);
		$resultApps = array_column($queryApps, 'app_name');
		if($result == 'comma'){ $resultApps = implode('","', $resultApps); }
		if($result == 'pipe'){ $resultApps = implode('|', $resultApps); }
		return $resultApps;
	}
	
	
	public function get_user_filter_apps($filterArray = array(), $type="productive", $result="array")
	{
		$dept_id = !empty($filterArray['dept_id']) ? $filterArray['dept_id'] : '0';
		$dept_folder = !empty($filterArray['dept_folder']) ? $filterArray['dept_folder'] : 'ALL';		
		$office_id = !empty($filterArray['office_id']) ? $filterArray['office_id'] : '0';
		$client_ids = !empty($filterArray['client_id']) ? $filterArray['client_id'] : '0';
		$process_ids = !empty($filterArray['process_id']) ? $filterArray['process_id'] : '0';
		
		$extraFilter = "";
		if($dept_folder != 'operations' )
		{
			if(!empty($dept_id) && $dept_id != "ALL"){
				$extraFilter .= " AND dept_id = '$dept_id'";
			}
		} else {
			if(!empty($dept_id) && $dept_id != "ALL"){
				$extraFilter .= " AND dept_id = '$dept_id'";
			}
			if(!empty($client_ids) && $client_ids != "ALL")
			{
				$extraFilter .= " AND client_id IN ($client_ids)";
			}
			if(!empty($process_ids) && $process_ids != "ALL")
			{
				$extraFilter .= " AND (process_id IN ($process_ids) OR process_id = 0)";
			}			
		}
		
		$appTable = "egaze_productive_apps";
	    if($type == 'productive'){ $appTable = "egaze_productive_apps"; }
	    if($type == 'noncompliance'){ $appTable = "egaze_noncompliance_apps"; }
		
		$sqlProductiveApps = "SELECT app_name from $appTable 
							  WHERE (is_global = 1 AND office_id = '0') OR (is_global = 1 AND office_id = '$office_id')
							  OR (is_global = 0 AND office_id = '$office_id' $extraFilter) 
							  OR (is_global = 1 AND office_id = 0 $extraFilter)";
		$queryApps = $this->Common_model->get_query_result_array($sqlProductiveApps);
		$resultApps = array_column($queryApps, 'app_name');
		if($result == 'comma'){ $resultApps = implode('","', $resultApps); }
		if($result == 'pipe'){ $resultApps = implode('|', $resultApps); }
		return $resultApps;
	}
	
	
	//=============================== GET TEAM DETAILS ================================//
	
	private function get_assigned_details($uid='', $user='', $customoffice = '', $customDept = '', $customClient = "", $customProcess = "")
	{
		$extrauser_filter = "";
		$user_office_id = get_user_office_id();
		$user_oth_office=get_user_oth_office();
		
		if($customoffice=="") $customoffice=$user_office_id;
		$AssCond = "";
		
		//$AssCond = " AND s.office_id = '$user_office_id'";
		//$AssCond = " AND (s.office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',s.office_id,'%')) ";
		
		if($uid !="" ){
			//$AssCond . =" AND s.assigned_to = '$uid' ";
			//$AssCond .= " AND (s.assigned_to='$uid' OR s.assigned_to in (SELECT id FROM signin where  assigned_to ='$uid')) ";
			
			$AssCond .= " AND (s.assigned_to='$uid' OR (s.assigned_to in (SELECT id FROM signin where  assigned_to ='$uid')) OR (s.assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$uid' )))) ";
			
		}
		
		if($customoffice != ""){ $AssCond .= " AND s.office_id = '$customoffice'"; }
		if($customDept != "" && $customDept != "ALL"){ $AssCond .= " AND s.dept_id = '$customDept'"; }
		
		if((!empty($customProcess)) && ($customProcess != "ALL") && ($customProcess != "0") ){ $AssCond .= " AND is_assign_process(s.id, '".$customProcess."')"; }
		if((!empty($customClient)) && ($customClient != "ALL") && ($customClient != "0") ){ $AssCond .= " AND is_assign_client(s.id, '".$customClient."')"; }
		
		if($user != ""){ $extrauser_filter = " AND (s.fname LIKE '%$user%' OR s.lname LIKE '%$user%' OR s.fusion_id = '$user') "; }
		
		//s.id in (select distinct user_id from egaze_activities_details ) 
		$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
					s.office_id, d.shname as department_name, r.name as designation from signin s 
					LEFT JOIN department d on s.dept_id = d.id
					LEFT JOIN role r on r.id = s.role_id
					INNER JOIN (select distinct user_id from egaze_activities_details) ead on ead.user_id = s.id
					WHERE 1 $AssCond $extrauser_filter ORDER by s.fname ASC";
		$query = $this->Common_model->get_query_result_array($sqlusers);
		
		return $query;
	}
	
	
	
	//=============================== GET ACTIVITIES RECORDS  ================================//
	
	private function get_activities_records($uid, $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate != ""){ $startdate = date('Y-m-d', strtotime($startdate)); }
		if($enddate != ""){ $enddate = date('Y-m-d', strtotime($enddate)); }
		
		if($startdate == ""){ $startdate = date('Y-m-d'); }
		if($enddate == ""){ $enddate = date('Y-m-d'); }
		
		$start_date = $startdate ." 00:00:00";
		$end_date = $startdate ." 23:59:59";
		
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
				
		$sql = "SELECT * from egaze_activities_details WHERE total_time_spent>0 and user_id = '$uid' AND (start_datetime >= '$start_date' AND start_datetime <= '$end_date') ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;
		
		
	}
	
	
	private function get_activities_records_all($uid = '', $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate != ""){ $startdate = date('Y-m-d', strtotime($startdate)); }
		if($enddate != ""){ $enddate = date('Y-m-d', strtotime($enddate)); }
		
		if($startdate == ""){ $startdate = date('Y-m-d'); }
		if($enddate == ""){ $enddate = date('Y-m-d'); }
		
		$start_date = $startdate ." 00:00:00";
		$end_date = $startdate ." 23:59:59";
		
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
		if($uid == ''){ $uid = 0; }
		$sql = "SELECT * from egaze_activities_details WHERE total_time_spent>0 and user_id IN ($uid) AND (start_datetime >= '$start_date' AND start_datetime <= '$end_date') ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;		
		
	}
	
	
	//=============================== GET ACTIVITIES RECORDS CLASSIFIED  ================================//
	
	private function get_activities_records_classified($uid, $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate != ""){ $startdate = date('Y-m-d', strtotime($startdate)); }
		if($enddate != ""){ $enddate = date('Y-m-d', strtotime($enddate)); }
		
		if($startdate == ""){ $startdate = date('Y-m-d'); }
		if($enddate == ""){ $enddate = date('Y-m-d'); }
		
		$start_date = $startdate ." 00:00:00";
		$end_date = $startdate ." 23:59:59";
		
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
				
		$sql = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as total_time, app_name, user_id, count(id) as count_records from egaze_activities_details 
		        WHERE total_time_spent>0 and user_id = '$uid' AND (start_datetime >= '$start_date' AND start_datetime <= '$end_date') 
		        GROUP BY app_name ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;
		
		
	}
	
	
	//=============================== GET EVENT RECORDS CLASSIFIED  ================================//
	
	private function get_events_records($uid, $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate != ""){ $startdate = date('Y-m-d', strtotime($startdate)); }
		if($enddate != ""){ $enddate = date('Y-m-d', strtotime($enddate)); }
		
		if($startdate == ""){ $startdate = date('Y-m-d'); }
		if($enddate == ""){ $enddate = date('Y-m-d'); }
		
		$start_date = $startdate ." 00:00:00";
		$end_date = $startdate ." 23:59:59";
		
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
				
		$sql = "SELECT * from egaze_event_details WHERE user_id = '$uid' AND (start_dt >= '$start_date' AND start_dt <= '$end_date') ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;
		
		
	}
	
	private function get_events_records_all($uid = '', $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate != ""){ $startdate = date('Y-m-d', strtotime($startdate)); }
		if($enddate != ""){ $enddate = date('Y-m-d', strtotime($enddate)); }
		
		if($startdate == ""){ $startdate = date('Y-m-d'); }
		if($enddate == ""){ $enddate = date('Y-m-d'); }
		
		$start_date = $startdate ." 00:00:00";
		$end_date = $startdate ." 23:59:59";
		
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
		if($uid == ''){ $uid = 0; }
		$sql = "SELECT * from egaze_event_details WHERE user_id IN ($uid) AND (start_dt >= '$start_date' AND start_dt <= '$end_date') ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;		
		
	}
	
	
	//=============================== GET REPORT CSV  ================================//
	
	private function reports_csv_download( $array, $filename = "export.csv", $delimiter="," )
	{
		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '";' );

		ob_end_clean();
		
		$handle = fopen( 'php://output', 'w' );
        
		$array_key = array("Sl", "Fusion ID", "Name", "L1 Supervisor", "Office", "Client", "Process", "Total Working Time", "Idle Time", "Productive", "Unproductive", "Unknown Apps");
		fputcsv($handle, $array_key);
        
		$sl = 0;
		foreach ($array['activities'] as $tokenm) {
			
			$fullname = $tokenm['fullname'];
			$user_id = $tokenm['user_id'];	
			
			$e_userid = $tokenm['user_id'];
			$totaltime = $array['apps'][$e_userid]['totaltime'];
			$totalidle = $array['apps'][$e_userid]['idletime'];
			$totalproductive = $array['apps'][$e_userid]['productive'];
			$totalunproductive = $array['apps'][$e_userid]['noncompliance'];
			$totalunknown = $array['apps'][$e_userid]['unproductive'];
			
			//$totaltimeoverall = $totaltime + $totalidle;
			$totaltimeoverall = $totaltime;		
			
			$addsym = "%";
			$idle_percent         = round(($totalidle/$totaltimeoverall) * 100);
			$productive_percent   = round(($totalproductive/$totaltimeoverall) * 100);
			$unproductive_percent = round(($totalunproductive/$totaltimeoverall) * 100);
			$unknown_percent      = round(($totalunknown/$totaltimeoverall) * 100);
			
			
			$sqluser = "SELECT s.fusion_id, CONCAT(ls.fname, ' ', ls.lname) as supervisor, s.office_id, get_process_names(s.id) as process_name, 
			            get_client_names(s.id) as client_name from signin as s 
			            LEFT JOIN signin as ls on ls.id = s.assigned_to
						WHERE s.id = '$user_id'";
			$udetails = $this->Common_model->get_query_row_array($sqluser);
			
			$array_values = array ( ++$sl, $udetails['fusion_id'], $fullname, $udetails['supervisor'], $udetails['office_id'], $udetails['client_name'], $udetails['process_name'], 
			                  $this->display_time_view($totaltimeoverall),  $this->display_time_view($totalidle), $this->display_time_view($totalproductive),
							  $this->display_time_view($totalunproductive), $this->display_time_view($totalunknown)  ); 
			
			fputcsv( $handle, $array_values , $delimiter );
		}

		fclose( $handle );
		ob_flush();
		exit();
	}
	
	private function display_time_view($seconds)
	{
		$diff = $seconds;
		$hours = floor($diff / (60*60));
		$minutes = floor(($diff - $hours*60*60)/ 60);
		$seconds = floor(($diff - $hours*60*60 - $minutes*60));
		
		$times = "";
		if($hours > 0){ $times .= $hours ." hr "; } 
		if($minutes > 0){ $times .= $minutes ." min "; } 
		if($seconds > 0){ if($minutes <= 0) { $times .= $seconds ." sec "; } } 
		return $times;
	}
	
	
	private function array_to_csv_download( $array, $filename = "export.csv", $delimiter="," )
	{
		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '";' );

		ob_end_clean();
		
		$handle = fopen( 'php://output', 'w' );

		fputcsv( $handle, array_keys( $array['0'] ) );

		foreach ( $array as $value ) {
			fputcsv( $handle, $value , $delimiter );
		}

		fclose( $handle );
		ob_flush();
		exit();
	}
  
	
	
	
		

}

	
?>