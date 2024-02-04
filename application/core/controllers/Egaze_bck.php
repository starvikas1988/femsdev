<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Egaze extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->library('excel');
	}
	
	function index()
	{
		redirect('egaze/dashboard');
		
	}
	
	
	
	
	/*=============  TEAM OVERVIEW DASHBOARD ===================*/
	function dashboard()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "6";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/mydashboard.php";
			
			$sdate = date('Y-m-d 00:00:00');
			$edate = date('Y-m-d 59:59:59');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			$userget = $this->input->get('uid');
		    if($userget != ""){ $current_user = $userget; }
			
			if($current_user == "1"){  $current_user = "4"; }
			$data['user_now'] = $current_user;
			
			//$filter_date = "2020-04-14 00:00:00";
			$filter_date = date('Y-m-d');
			$data['myteam'] = $myteamd = $this->get_assigned_details($current_user);
			
			//echo "<pre>".print_r($myteamd, true)."</pre>"; die;
			
			//================== USER ACCESS FILTER ======================================//
			$extrafilter = "";
			if($is_global_access == 1)
			{
				$extrafilter = "";
			}
			
			if($is_global_access != 1)
			{
				$extrafilter = " AND assigned_to = '$current_user'";
			}
			
			
			// TOP PRODUCTIVE APPS
			$sql_topproductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, app_name FROM egaze_activities_details WHERE DATE(start_datetime) >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE 1 $extrafilter)
								  AND (app_name IN (SELECT app_name from egaze_productive_apps) OR app_name IN (SELECT url from egaze_productive_web))
								  GROUP BY app_name ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_productive'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive);
			
			// TOP UNPRODUCTIVE APPS
			$sql_tounpproductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, app_name  FROM egaze_activities_details WHERE DATE(start_datetime) >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE 1 $extrafilter)
								  AND (app_name IN (SELECT app_name from egaze_unproductive_apps) OR app_name IN (SELECT url from egaze_unproductive_web))
								  GROUP BY app_name ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_unproductive'] = $querytotal = $this->Common_model->get_query_result_array($sql_tounpproductive);
			
			// TOP EMPLOYEE ON PRODUCTIVE APPS
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE DATE(start_datetime) >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE 1 $extrafilter)
								  AND (app_name IN (SELECT app_name from egaze_productive_apps) OR app_name IN (SELECT url from egaze_productive_web))
								  GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_productive_emp'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			// TOP EMPLOYEE ON UNPRODUCTIVE APPS
			$sql_topunproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE DATE(start_datetime) >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE 1 $extrafilter)
								  AND (app_name IN (SELECT app_name from egaze_unproductive_apps) OR app_name IN (SELECT url from egaze_unproductive_web))
								  GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_unproductive_emp'] = $querytotal = $this->Common_model->get_query_result_array($sql_topunproductive_emp);
			
			
			// TOP MOST HOURS EMPLOYEE
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, user_id FROM egaze_activities_details WHERE DATE(start_datetime) >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE 1 $extrafilter)
								  GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_emp_hours'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			// TOP LESS HOURS EMPLOYEE
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, user_id FROM egaze_activities_details WHERE DATE(start_datetime) >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE 1 $extrafilter)
								  GROUP BY user_id ORDER BY totaltimespent ASC LIMIT 10";
			$data['less_emp_hours'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			
			
			$data['myactivities'] = $this->get_activities_records($current_user);
			$data['myevents'] = $this->get_events_records($current_user);
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	

	
	/*============= REPORTS TEAM DASHBOARD ===================*/
	function reports()
	{
		if(check_logged_in()){	
		
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/dashboard.php";
		
			
			// GET USER DETAILS
			$sdate = date('Y-m-d 00:00:00');
			$edate = date('Y-m-d 59:59:59');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			if($current_user == "1"){  $current_user = "4"; }
			
			
			// CHECK TEAM STATUS
			$getmyteam = $this->get_assigned_details($current_user);
			$myteam = implode(', ', array_column($getmyteam, 'user_id'));
			
			// CHECK DATE STATUS
			$current_date = $this->input->get('d');
			if(empty($current_date)){ $current_date = CurrDate(); /*$current_date = "2020-04-14";*/ }
			
			// CHECK BAR COLOUR
			$data['colour_array'] = array('bg-success', 'bg-danger', 'bg-primary', 'bg-warning');
						
			$data['my_date'] = $current_date;
				
			$sql = "SELECT e.user_id, concat(s.fname, ' ', s.lname) as fullname, s.is_logged_in, 
			        SUM(TIME_TO_SEC(e.total_time_spent)) as totaltimespent, 
					p.productiveapps, u.unproductiveapps, k.unknownapps, i.idletime
					FROM egaze_activities_details as e
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as productiveapps 
					FROM egaze_activities_details WHERE date(start_datetime) = '$current_date' AND
					(app_name IN (SELECT app_name from egaze_productive_apps) 
					OR app_name IN (SELECT url from egaze_productive_web))
					GROUP BY user_id) as p ON p.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as unproductiveapps 
					FROM egaze_activities_details WHERE date(start_datetime) = '$current_date' AND
					(app_name IN (SELECT app_name from egaze_unproductive_apps)
					OR app_name IN (SELECT url from egaze_unproductive_web))
					GROUP BY user_id) as u ON u.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as unknownapps 
					FROM egaze_activities_details WHERE date(start_datetime) = '$current_date' AND
					(app_name NOT IN (SELECT app_name from egaze_unproductive_apps) 
					AND app_name NOT IN (SELECT url from egaze_unproductive_web)
					AND app_name NOT IN (SELECT app_name from egaze_productive_apps)
					AND app_name NOT IN (SELECT url from egaze_productive_web))
					GROUP BY user_id) as k ON k.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time)) as idletime 
					FROM egaze_event_details WHERE date(start_dt) = '$current_date'
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
	
	
	

	function timeline()
	{
		if(check_logged_in()){	
		
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/timeline.php";
		
			
			// GET USER DETAILS
			$sdate = date('Y-m-d 00:00:00');
			$edate = date('Y-m-d 59:59:59');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			if($current_user == "1"){  $current_user = "4"; }
			
			
			// CHECK TEAM STATUS
			$getmyteam = $this->get_assigned_details($current_user);
			$myteam = implode(', ', array_column($getmyteam, 'user_id'));
			
			// CHECK DATE STATUS
			$current_date = $this->input->get('d');
			if(empty($current_date)){ $current_date = CurrDate(); /*$current_date = "2020-04-14";*/ }
			
			// CHECK BAR COLOUR
			$data['colour_array'] = array('bg-success', 'bg-danger', 'bg-primary', 'bg-warning');
						
			$data['my_date'] = $current_date;
				
			$sql = "SELECT e.user_id, concat(s.fname, ' ', s.lname) as fullname, s.is_logged_in, 
			        SUM(TIME_TO_SEC(e.total_time_spent)) as totaltimespent, 
					p.productiveapps, u.unproductiveapps, k.unknownapps, i.idletime
					FROM egaze_activities_details as e
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as productiveapps 
					FROM egaze_activities_details WHERE date(start_datetime) = '$current_date' AND
					(app_name IN (SELECT app_name from egaze_productive_apps) 
					OR app_name IN (SELECT url from egaze_productive_web))
					GROUP BY user_id) as p ON p.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as unproductiveapps 
					FROM egaze_activities_details WHERE date(start_datetime) = '$current_date' AND
					(app_name IN (SELECT app_name from egaze_unproductive_apps)
					OR app_name IN (SELECT url from egaze_unproductive_web))
					GROUP BY user_id) as u ON u.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time_spent)) as unknownapps 
					FROM egaze_activities_details WHERE date(start_datetime) = '$current_date' AND
					(app_name NOT IN (SELECT app_name from egaze_unproductive_apps) 
					AND app_name NOT IN (SELECT url from egaze_unproductive_web)
					AND app_name NOT IN (SELECT app_name from egaze_productive_apps)
					AND app_name NOT IN (SELECT url from egaze_productive_web))
					GROUP BY user_id) as k ON k.user_id = e.user_id
					LEFT JOIN 
					(SELECT user_id, SUM(TIME_TO_SEC(total_time)) as idletime 
					FROM egaze_event_details WHERE date(start_dt) = '$current_date'
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
	function realtime()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "4";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/teammonitoring.php";
			
			$sdate = date('Y-m-d');
			$edate = date('Y-m-d');
			
			//-->FOR DEMO DATE
			//$sdate = date('Y-m-27');
			//$edate = date('Y-m-27');
			
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
			if($current_user == "1"){  $current_user = "4"; }
			
			$data['searchingq'] = $extrasearch = "";
			
			$userget = $this->input->get('qsearch');
		    if($userget != ""){ $extrasearch = $data['searchingq'] = $userget; }
			
			
			
			//----- DATA PARAMETERS
			$myapp = "SELECT * from egaze_productive_apps";
			$data['myapp'] = $productive_apps = $this->Common_model->get_query_result_array($myapp);
			
			$mylink = "SELECT * from egaze_productive_web";
			$data['mylink'] = $productive_links = $this->Common_model->get_query_result_array($mylink);
			
			$myuapp = "SELECT * from egaze_unproductive_apps";
			$data['myuapp'] = $unproductive_apps = $this->Common_model->get_query_result_array($myuapp);
			
			$myulink = "SELECT * from egaze_unproductive_web";
			$data['myulink'] = $unproductive_links = $this->Common_model->get_query_result_array($myulink);
			
			
			
			$sl = 1;
			$data['myteam'] = $myteamd = $this->get_assigned_details($current_user, $extrasearch);
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
				$data['link'][$uid] = base_url() ."egaze/individual?uid=" .$uid;
				
				// FOR ALL USER NAMES DISPAY
				//$mydata .= "[ '".$tokend['fullname']."',  '".$tokend['fullname']."',    new Date(0,0,0,0,0,0),  new Date(0,0,0,0,0,0) ],"; 
				
				foreach($activities_records as $tokenr)
				{
					$s_hour = date('H', strtotime($tokenr['start_datetime']));
					$s_min = date('i', strtotime($tokenr['start_datetime']));
					$s_sec = date('s', strtotime($tokenr['start_datetime']));
					
					$e_hour = date('H', strtotime($tokenr['end_datetime']));
					$e_min = date('i', strtotime($tokenr['end_datetime']));
					$e_sec = date('s', strtotime($tokenr['end_datetime']));
					
					//GET ACTIVITY TYPE
					$colorchange = "color:#88BFB9";
					
					$keyapp = array_search($tokenr['app_name'], array_column($productive_apps, 'app_name'));
					$keylink = array_search($tokenr['app_name'], array_column($productive_links, 'url'));
					if(($keyapp != "") || ($keylink != "")){ $colorchange = "color:#51D469"; }
					
					$ukeyapp = array_search($tokenr['app_name'], array_column($unproductive_apps, 'app_name'));
					$ukeylink = array_search($tokenr['app_name'], array_column($unproductive_links, 'url'));
					if(($ukeyapp != "") || ($ukeylink != "")){ $colorchange = "color:#FF0202"; }
					
					$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['app_name']."',  '".$colorchange."',  new Date(0,0,0,".$s_hour.",".$s_min.",".$s_sec."),  new Date(0,0,0,".$e_hour.",".$e_min.",".$e_sec.") ],"; 
					//echo $mydata. "<br/>";					
				}
				
				
				$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$uid' AND DATE(start_dt) = '$sdate'";
				$data['totalidle'][$uid] = $querytotal = $this->Common_model->get_single_value($sqltotal);
				
				$data['team']['chart'][$uid] = $mydata;
				
				if($mydata != ""){ $sl++; }
				
			}
			
			
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	
	 //================== GOOGLE TIMELINE EACH EMPLOYEE ACTIVITY DETAIL PAGE =======================//
	function individual()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/individual.php";
						
			$sdate = date('Y-m-d');
			$edate = date('Y-m-d');
			
			//$sdate = date('Y-m-25');
			//$edate = date('Y-m-25');
			
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			$userget = $this->input->get('uid');
			
			//-->FOR DEMO USER CHECK
			//if($userget == ""){ $userget = "14951"; }
			
		    if($userget != ""){ $current_user = $userget; }
			$data['user_now'] = $current_user;
			
			$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$current_user' AND DATE(start_dt) = '$sdate'";
			$data['total_idle'] = $querytotal = $this->Common_model->get_single_value($sqltotal);
			
			$sqlactivity = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details WHERE user_id = '$current_user' AND DATE(start_datetime) = '$sdate'";
			$data['total_time_activity'] = $querytotal = $this->Common_model->get_query_row_array($sqlactivity);
			
			$sqlproductivty = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details WHERE user_id = '$current_user' AND DATE(start_datetime) = '$sdate' AND (app_name IN (SELECT app_name from egaze_productive_apps)) OR (app_name IN (SELECT url from egaze_productive_web))";
			$data['total_time_productivity'] = $querytotal = $this->Common_model->get_query_row_array($sqlproductivty);
			
			$data['myactivities'] = $this->get_activities_records($current_user, 0, $sdate, $edate);
			$data['myevents'] = $this->get_events_records($current_user, 0, $sdate, $edate);
			$data['mydetails'] = $mydetails = $this->get_user_details($current_user);
			
			//----- DATA PARAMETERS
			$myapp = "SELECT * from egaze_productive_apps";
			$data['myapp'] = $productive_apps = $this->Common_model->get_query_result_array($myapp);
			
			$mylink = "SELECT * from egaze_productive_web";
			$data['mylink'] = $productive_links = $this->Common_model->get_query_result_array($mylink);
			
			$myuapp = "SELECT * from egaze_unproductive_apps";
			$data['myuapp'] = $unproductive_apps = $this->Common_model->get_query_result_array($myuapp);
			
			$myulink = "SELECT * from egaze_unproductive_web";
			$data['myulink'] = $unproductive_links = $this->Common_model->get_query_result_array($myulink);
			
			
			//------ PREVIOUS WEEK RECORDS
			$start_date_week = date('Y-m-d', strtotime('monday this week', strtotime($sdate)));
			for($i=0;$i<7;$i++)
			{
				$sqldate = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details WHERE user_id IN ($current_user) AND DATE(start_datetime) = '$start_date_week'";
				$querydate = $this->Common_model->get_query_row_array($sqldate);
				
				
				$sqlp_date = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time_spent))) as total_time, SUM(TIME_TO_SEC(total_time_spent)) as total_seconds from egaze_activities_details WHERE user_id IN ($current_user) AND DATE(start_datetime) = '$start_date_week' 
				AND (app_name IN (SELECT app_name from egaze_productive_apps)) OR (app_name IN (SELECT url from egaze_productive_web))";
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
				$s_hour = date('H', strtotime($tokenr['start_datetime']));
				$s_min = date('i', strtotime($tokenr['start_datetime']));
				$s_sec = date('s', strtotime($tokenr['start_datetime']));
				
				$e_hour = date('H', strtotime($tokenr['end_datetime']));
				$e_min = date('i', strtotime($tokenr['end_datetime']));
				$e_sec = date('s', strtotime($tokenr['end_datetime']));
				
				//GET ACTIVITY TYPE
				$colorchange = "color:#88BFB9";
				
				$keyapp = array_search($tokenr['app_name'], array_column($productive_apps, 'app_name'));
				$keylink = array_search($tokenr['app_name'], array_column($productive_links, 'url'));
				if(($keyapp != "") || ($keylink != "")){ $colorchange = "color:#51D469"; }
				
				$ukeyapp = array_search($tokenr['app_name'], array_column($unproductive_apps, 'app_name'));
				$ukeylink = array_search($tokenr['app_name'], array_column($unproductive_links, 'url'));
				if(($ukeyapp != "") || ($ukeylink != "")){ $colorchange = "color:#FF0202"; }
					
				$mydata .= "[ '".$mydetails['fullname']."',  '".$tokenr['app_name']."', '".$colorchange."', new Date(0,0,0,".$s_hour.",".$s_min.",".$s_sec."),  new Date(0,0,0,".$e_hour.",".$e_min.",".$e_sec.") ],"; 
				//echo $mydata. "<br/>";
			}
			
			
			$myidle = "";
			foreach($data['myevents'] as $tokene)
			{
				$s_hour = date('H', strtotime($tokene['start_dt']));
				$s_min = date('i', strtotime($tokene['start_dt']));
				$s_sec = date('s', strtotime($tokene['start_dt']));
				
				$e_hour = date('H', strtotime($tokene['end_dt']));
				$e_min = date('i', strtotime($tokene['end_dt']));
				$e_sec = date('s', strtotime($tokene['end_dt']));
				
				$myidle .= "[ '".$mydetails['fullname']."',  '".$tokene['event_name']."',    new Date(0,0,0,".$s_hour.",".$s_min.",".$s_sec."),  new Date(0,0,0,".$e_hour.",".$e_min.",".$e_sec.") ],"; 
				//echo $mydata. "<br/>";
			}
				
			$data['myactivitieslist'] = $mydata;
			$data['myeventslist'] = $myidle;
				
				
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	
	
	
    //=============================== MASTER APPS ================================//
	function config()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "2";
			$data["aside_template"] = "egaze/aside.php";
			$data["content_template"] = "egaze/config.php";
						
			$is_global_access=get_global_access();
			$role_id        = get_role_id();
			$current_user   = get_user_id();
			$role_dir       = get_role_dir();			
			$user_office_id = get_user_office_id();
			$ses_dept_id    = get_dept_id();	
			
			$get_client_id  = get_client_ids(); 
			$get_process_id = get_process_ids(); 
			$get_user_site_id = get_user_site_id();
			
			
			///------ DELETE PARAMETERS
			if($this->input->get('del') == 1)
			{
				$delid = $this->input->get('did');
				if($this->input->get('type') == "papp")
				{
					$sql = "DELETE from egaze_productive_apps WHERE id = '$delid'";
				}
				
				if($this->input->get('type') == "plink")
				{
					$sql = "DELETE from egaze_productive_web WHERE id = '$delid'";
				}
				
				if($this->input->get('type') == "uapp")
				{
					$sql = "DELETE from egaze_unproductive_apps WHERE id = '$delid'";
				}
				
				if($this->input->get('type') == "ulink")
				{
					$sql = "DELETE from egaze_unproductive_web WHERE id = '$delid'";
				}
				$this->db->query($sql);
				redirect(base_url()."activities/config");
			}
				
			///------ INSERT PARAMETERS
			// PRODUCTIVE APP
			$productive_app = $this->input->post('productive_app');
			if($productive_app != "")
			{
				$field_array = array( "app_name" => $productive_app );
				data_inserter('egaze_productive_apps',$field_array);
				redirect(base_url()."egaze/config");
			}
			
			// PRODUCTIVE LINK
			$productive_link = $this->input->post('productive_link');
			if($productive_link != "")
			{
				$field_array = array( "url" => $productive_link );
				data_inserter('egaze_productive_web',$field_array);
				redirect(base_url()."egaze/config");
			}
			
			// UNPRODUCTIVE LINK
			$unproductive_link = $this->input->post('unproductive_link');
			if($unproductive_link != "")
			{
				$field_array = array( "url" => $unproductive_link );
				data_inserter('egaze_unproductive_web',$field_array);
				redirect(base_url()."egaze/config");
			}
			
			// UNPRODUCTIVE APP
			$unproductive_app = $this->input->post('unproductive_app');
			if($unproductive_app != "")
			{
				$field_array = array( "app_name" => $unproductive_app );
				data_inserter('egaze_unproductive_apps',$field_array);
				redirect(base_url()."egaze/config");
			}
			
			
			//----- DATA PARAMETERS
			$myapp = "SELECT * from egaze_productive_apps";
			$data['myapp'] = $this->Common_model->get_query_result_array($myapp);
			
			$mylink = "SELECT * from egaze_productive_web";
			$data['mylink'] = $this->Common_model->get_query_result_array($mylink);
			
			$myuapp = "SELECT * from egaze_unproductive_apps";
			$data['myuapp'] = $this->Common_model->get_query_result_array($myuapp);
			
			$myulink = "SELECT * from egaze_unproductive_web";
			$data['myulink'] = $this->Common_model->get_query_result_array($myulink);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
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
	
	private function get_assigned_details($uid, $user='')
	{
		$extrauser_filter = ""; $extra_assign = " AND s.id IN (SELECT distinct(user_id) from egaze_activities_details)";
		if($user != ""){ $extrauser_filter = " AND (s.fname LIKE '%$user%' OR s.lname LIKE '%$user%' OR s.fusion_id = '$user') "; }
		if(get_global_access() != 1){ $extra_assign = " AND s.assigned_to = '$uid'"; } 
		
		$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
					s.office_id, d.shname as department_name, r.name as designation from signin s 
					LEFT JOIN department d on s.dept_id = d.id
					LEFT JOIN role r on r.id = s.role_id
					WHERE 1 $extra_assign $extrauser_filter ORDER by s.fname ASC";
		$query = $this->Common_model->get_query_result_array($sqlusers);
		
		return $query;
	}
	
	
	private function get_activities_records($uid, $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate != ""){ $startdate = date('Y-m-d', strtotime($startdate)); }
		if($enddate != ""){ $enddate = date('Y-m-d', strtotime($enddate)); }
		
		if($startdate == ""){ $startdate = date('Y-m-d'); }
		if($enddate == ""){ $enddate = date('Y-m-d'); }
		
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
				
		$sql = "SELECT * from egaze_activities_details WHERE user_id = '$uid' AND DATE(start_datetime) = '$startdate' ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;
		
		
	}
	
	private function get_events_records($uid, $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate != ""){ $startdate = date('Y-m-d', strtotime($startdate)); }
		if($enddate != ""){ $enddate = date('Y-m-d', strtotime($enddate)); }
		
		if($startdate == ""){ $startdate = date('Y-m-d'); }
		if($enddate == ""){ $enddate = date('Y-m-d'); }
		
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
				
		$sql = "SELECT * from egaze_event_details WHERE user_id = '$uid' AND DATE(start_dt) = '$startdate' ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;
		
		
	}
	
	
	
	
		

}

	
?>