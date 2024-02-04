<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activities extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->library('excel');
	}
	
	
	function index()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/monitoring.php";
			
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
			
			$data['user_now'] = $current_user;
			
			$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$current_user'  AND start_dt >= '$sdate'";
			$data['total_idle'] = $querytotal = $this->Common_model->get_single_value($sqltotal);
			
			$data['myactivities'] = $this->get_activities_records($current_user);
			$data['myevents'] = $this->get_events_records($current_user);
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	function monitor()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/monitoring2.php";
			
			$data['array_color'] = array(
				"ApplicationFrameHost.exe" => "t_blue",
				"ApplicationFrameHost" => "t_blue",
				"Application Frame Host" => "t_blue",
				"botframework-emulator" => "t_red",
				"chrome.exe" => "t_green",
				"devenv.exe" => "t_red",
				"EGaze.exe" => "t_red",
				"Explorer.EXE" => "t_blue",
				"Google Chrome" => "t_green",
				"Internet Explorer" => "t_red",
				"Microsoft Visual Studio 2017" => "t_red",
				"NOTEPAD.EXE" => "t_orange",
				"OUTLOOK.EXE" => "t_orange",
				"Postman" => "t_red",
				"Postman.exe" => "t_red",
				"Search and Cortana application" => "t_red",
				"Skype.exe" => "t_yellow",
				"SnippingTool.exe" => "t_red",
				"SSMS" => "t_red",
				"Windows Explorer" => "t_blue",
				"XRails-LoginUI.Example" => "t_red"				
			);
			
			
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
			
			$data['user_now'] = $current_user;
			
			$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$current_user'  AND start_dt >= '$sdate'";
			$data['total_idle'] = $querytotal = $this->Common_model->get_single_value($sqltotal);
			
			$data['myactivities'] = $this->get_activities_records($current_user);
			$data['myevents'] = $this->get_events_records($current_user);
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	 //================== GOOGLE TIMELINE EACH EMPLOYEE ACTIVITY DETAIL PAGE =======================//
	function monitor2()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "1";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/monitoring3.php";
						
			$sdate = date('Y-m-d 00:00:00');
			$edate = date('Y-m-d 59:59:59');
			
			//$sdate = date('Y-m-10 00:00:00');
			//$edate = date('Y-m-10 59:59:59');
			
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
			//$userget = "14951";
		    if($userget != ""){ $current_user = $userget; }
			
			$data['user_now'] = $current_user;
			
			$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$current_user'  AND start_dt >= '$sdate'";
			$data['total_idle'] = $querytotal = $this->Common_model->get_single_value($sqltotal);
			
			$data['myactivities'] = $this->get_activities_records($current_user, 0, $sdate, $edate);
			$data['myevents'] = $this->get_events_records($current_user, 0, $sdate, $edate);
			$data['mydetails'] = $mydetails = $this->get_user_details($current_user);
			
			$mydata = "";
			foreach($data['myactivities'] as $tokenr)
			{
				$s_hour = date('H', strtotime($tokenr['start_datetime']));
				$s_min = date('i', strtotime($tokenr['start_datetime']));
				$s_sec = date('s', strtotime($tokenr['start_datetime']));
				
				$e_hour = date('H', strtotime($tokenr['end_datetime']));
				$e_min = date('i', strtotime($tokenr['end_datetime']));
				$e_sec = date('s', strtotime($tokenr['end_datetime']));
				
				$mydata .= "[ '".$mydetails['fullname']."',  '".$tokenr['app_name']."',    new Date(0,0,0,".$s_hour.",".$s_min.",".$s_sec."),  new Date(0,0,0,".$e_hour.",".$e_min.",".$e_sec.") ],"; 
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
	
	
	
	function myteam()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "2";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/teammonitoring.php";
			
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
			
			$data['searchingq'] = $extrasearch = "";
			
			$userget = $this->input->get('qsearch');
		    if($userget != ""){ $extrasearch = $data['searchingq'] = $userget; }
						
			$data['myteam'] = $myteamd = $this->get_assigned_details($current_user, $extrasearch);
			foreach($myteamd as $tokend)
			{
				$uid = $tokend['user_id'];
				$activities_records = $this->get_activities_records('14951', '10');
								
				//$uid = "14951";
				$data['team'][$uid] = $this->get_activities_records($uid, '10');
				
				$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$uid' AND start_dt >= '$sdate'";
				$data['totalidle'][$uid] = $querytotal = $this->Common_model->get_single_value($sqltotal);
			}
			
			//echo $data['totalidle'][6468];die();
			
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	
	function myteam2()
	{
				
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "3";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/teammonitoring2.php";
			
			$sdate = date('Y-m-d 00:00:00');
			$edate = date('Y-m-d 59:59:59');
			//$sdate = date('Y-m-10 00:00:00');
			//$edate = date('Y-m-10 59:59:59');
			
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
			
			$data['searchingq'] = $extrasearch = "";
			
			$userget = $this->input->get('qsearch');
		    if($userget != ""){ $extrasearch = $data['searchingq'] = $userget; }
						
			$data['myteam'] = $myteamd = $this->get_assigned_details($current_user, $extrasearch);
			foreach($myteamd as $tokend)
			{
				$uid = $tokend['user_id'];
				$fid = $tokend['fusion_id'];
				$mydata = "";
				//$uid = "14951";
				$data['team'][$uid] = $activities_records = $this->get_activities_records($uid, '0', $sdate, $edate);
				
				$mydata .= "[ '".$tokend['fusion_id']."',  '".$tokend['fullname']."',    new Date(0,0,0,0,0,0),  new Date(0,0,0,0,0,0) ],"; 
				
				foreach($activities_records as $tokenr)
				{
					$s_hour = date('H', strtotime($tokenr['start_datetime']));
					$s_min = date('i', strtotime($tokenr['start_datetime']));
					$s_sec = date('s', strtotime($tokenr['start_datetime']));
					
					$e_hour = date('H', strtotime($tokenr['end_datetime']));
					$e_min = date('i', strtotime($tokenr['end_datetime']));
					$e_sec = date('s', strtotime($tokenr['end_datetime']));
					
					$mydata .= "[ '".$tokend['fusion_id']."',  '".$tokenr['app_name']."',    new Date(0,0,0,".$s_hour.",".$s_min.",".$s_sec."),  new Date(0,0,0,".$e_hour.",".$e_min.",".$e_sec.") ],"; 
					//echo $mydata. "<br/>";					
				}
				
				
				$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$uid' AND start_dt >= '$sdate'";
				$data['totalidle'][$uid] = $querytotal = $this->Common_model->get_single_value($sqltotal);
				
				$data['team']['chart'][$uid] = $mydata;
				
			}
			
			
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
    //=============================== GOOGLE TIMELINE TEAM ACTIVITIES ================================//
	function myteam3()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "4";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/teammonitoring3.php";
			
			$sdate = date('Y-m-d 00:00:00');
			$edate = date('Y-m-d 59:59:59');
			//$sdate = date('Y-m-13 00:00:00');
			//$edate = date('Y-m-13 59:59:59');
			
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
			
			$data['searchingq'] = $extrasearch = "";
			
			$userget = $this->input->get('qsearch');
		    if($userget != ""){ $extrasearch = $data['searchingq'] = $userget; }
			
			$sl = 1;
			$data['myteam'] = $myteamd = $this->get_assigned_details($current_user, $extrasearch);
			foreach($myteamd as $tokend)
			{
				$uid = $tokend['user_id'];
				$fname = $tokend['fullname'];
				$fid = $tokend['fusion_id'];
				$mydata = "";
				
				//$uid = "14951";
				$data['team'][$uid] = $activities_records = $this->get_activities_records($uid, '0', $sdate, $edate);
				$data['link'][$uid] = base_url() ."activities/myteam2?uid=" .$uid;
				
				//$mydata .= "[ '".$tokend['fullname']."',  '".$tokend['fullname']."',    new Date(0,0,0,0,0,0),  new Date(0,0,0,0,0,0) ],"; 
				
				foreach($activities_records as $tokenr)
				{
					$s_hour = date('H', strtotime($tokenr['start_datetime']));
					$s_min = date('i', strtotime($tokenr['start_datetime']));
					$s_sec = date('s', strtotime($tokenr['start_datetime']));
					
					$e_hour = date('H', strtotime($tokenr['end_datetime']));
					$e_min = date('i', strtotime($tokenr['end_datetime']));
					$e_sec = date('s', strtotime($tokenr['end_datetime']));
					
					$mydata .= "[ '".$sl .". " .$tokend['fullname']."',  '".$tokenr['app_name']."',    new Date(0,0,0,".$s_hour.",".$s_min.",".$s_sec."),  new Date(0,0,0,".$e_hour.",".$e_min.",".$e_sec.") ],"; 
					//echo $mydata. "<br/>";					
				}
				
				
				$sqltotal = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) as value from egaze_event_details WHERE user_id = '$uid' AND start_dt >= '$sdate'";
				$data['totalidle'][$uid] = $querytotal = $this->Common_model->get_single_value($sqltotal);
				
				$data['team']['chart'][$uid] = $mydata;
				
				if($mydata != ""){ $sl++; }
				
			}
			
			
			$data['mydetails'] = $this->get_user_details($current_user);
			
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
		$extrauser_filter = "";
		if($user != ""){ $extrauser_filter = " AND (s.fname LIKE '%$user%' OR s.lname LIKE '%$user%' OR s.fusion_id = '$user') "; }
		$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
					s.office_id, d.shname as department_name, r.name as designation from signin s 
					LEFT JOIN department d on s.dept_id = d.id
					LEFT JOIN role r on r.id = s.role_id
					WHERE s.assigned_to = '$uid' $extrauser_filter ORDER by s.fname ASC";
		$query = $this->Common_model->get_query_result_array($sqlusers);
		
		return $query;
	}
	
	private function get_activities_records($uid, $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate == ""){ $startdate = date('Y-m-d 00:00:00'); }
		if($enddate == ""){ $enddate = date('Y-m-d 23:59:59'); }
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
				
		$sql = "SELECT * from egaze_activities_details WHERE user_id = '$uid' AND start_datetime >= '$startdate' ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;
		
		
	}
	
	
	private function get_events_records($uid, $count = '0', $startdate = "", $enddate = "", $type = "")
	{
		if($startdate == ""){ $startdate = date('Y-m-d 00:00:00'); }
		if($enddate == ""){ $enddate = date('Y-m-d 23:59:59'); }
		$exralimit = "";
		if($count > 0){ $exralimit = " LIMIT " .$count; }
				
		$sql = "SELECT * from egaze_event_details WHERE user_id = '$uid' AND start_dt >= '$startdate' ORDER by id DESC $exralimit";
		$query = $this->Common_model->get_query_result_array($sql);
		
		return $query;
		
		
	}
	
	
	
	
    //=============================== MASTER APPS ================================//
	function config()
	{
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "5";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/config.php";
			
			$sdate = date('Y-m-d 00:00:00');
			$edate = date('Y-m-d 59:59:59');
			//$sdate = date('Y-m-13 00:00:00');
			//$edate = date('Y-m-13 59:59:59');
			
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
				redirect(base_url()."activities/config");
			}
			
			// PRODUCTIVE LINK
			$productive_link = $this->input->post('productive_link');
			if($productive_link != "")
			{
				$field_array = array( "url" => $productive_link );
				data_inserter('egaze_productive_web',$field_array);
				redirect(base_url()."activities/config");
			}
			
			// UNPRODUCTIVE LINK
			$unproductive_link = $this->input->post('unproductive_link');
			if($unproductive_link != "")
			{
				$field_array = array( "url" => $unproductive_link );
				data_inserter('egaze_unproductive_web',$field_array);
				redirect(base_url()."activities/config");
			}
			
			// UNPRODUCTIVE APP
			$unproductive_app = $this->input->post('unproductive_app');
			if($unproductive_app != "")
			{
				$field_array = array( "app_name" => $unproductive_app );
				data_inserter('egaze_unproductive_apps',$field_array);
				redirect(base_url()."activities/config");
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
	
	
	
	
	
	//=================== DASHBOARD ==================================//
	function dashboard()
	{
		
		
		exit(1);
		
		if(check_logged_in()){	
		    
			$_SESSION['pmenu'] = "6";
			$data["aside_template"] = "activities/aside.php";
			$data["content_template"] = "activities/dashboard.php";
			
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
			
			$filter_date = "2020-04-14 00:00:00";
			$data['myteam'] = $myteamd = $this->get_assigned_details($current_user);
			
			// TOP PRODUCTIVE APPS
			$sql_topproductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, app_name FROM egaze_activities_details WHERE start_datetime >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE assigned_to = '$current_user')
								  AND (app_name IN (SELECT app_name from egaze_productive_apps) OR app_name IN (SELECT url from egaze_productive_web))
								  GROUP BY app_name ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_productive'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive);
			
			// TOP UNPRODUCTIVE APPS
			$sql_tounpproductive = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent, app_name  FROM egaze_activities_details WHERE start_datetime >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE assigned_to = '$current_user')
								  AND (app_name IN (SELECT app_name from egaze_unproductive_apps) OR app_name IN (SELECT url from egaze_unproductive_web))
								  GROUP BY app_name ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_unproductive'] = $querytotal = $this->Common_model->get_query_result_array($sql_tounpproductive);
			
			// TOP EMPLOYEE ON PRODUCTIVE APPS
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE start_datetime >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE assigned_to = '$current_user')
								  AND (app_name IN (SELECT app_name from egaze_productive_apps) OR app_name IN (SELECT url from egaze_productive_web))
								  GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_productive_emp'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			// TOP EMPLOYEE ON UNPRODUCTIVE APPS
			$sql_topunproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE start_datetime >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE assigned_to = '$current_user')
								  AND (app_name IN (SELECT app_name from egaze_unproductive_apps) OR app_name IN (SELECT url from egaze_unproductive_web))
								  GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_unproductive_emp'] = $querytotal = $this->Common_model->get_query_result_array($sql_topunproductive_emp);
			
			
			// TOP MOST HOURS EMPLOYEE
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE start_datetime >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE assigned_to = '$current_user')
								  GROUP BY user_id ORDER BY totaltimespent DESC LIMIT 10";
			$data['top_emp_hours'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			// TOP LESS HOURS EMPLOYEE
			$sql_topproductive_emp = "SELECT SUM(TIME_TO_SEC(total_time_spent)) as totaltimespent FROM egaze_activities_details WHERE start_datetime >= '$filter_date' 
			                      AND user_id IN (SELECT id from signin WHERE assigned_to = '$current_user')
								  GROUP BY user_id ORDER BY totaltimespent ASC LIMIT 10";
			$data['less_emp_hours'] = $querytotal = $this->Common_model->get_query_result_array($sql_topproductive_emp);
			
			
			
			$data['myactivities'] = $this->get_activities_records($current_user);
			$data['myevents'] = $this->get_events_records($current_user);
			$data['mydetails'] = $this->get_user_details($current_user);
			
			$this->load->view('dashboard',$data);
		
		
		}
		
	}

	
	

}

