<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_adherence extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->model('Schedule_adherence_model');	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){
				
		redirect(base_url()."schedule_adherence/overview");
	 
	}
	
	
    //=================================================================================================================
	//  INDIVIDUAL SCHEDULE ADHERENCE
	//=================================================================================================================
	
	public function overview()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = '9282';
		//$selected_fusion = "FKOL002079";
		//$current_user = '15261';
		//$selected_fusion = "FKOL005534";
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$data['todayDate1'] = $currDate1 = date("Y-m-d", strtotime("-1 day", strtotime(CurrDate())));
		$selected_date = date('m/d/Y', strtotime($currDate));
		if(!empty($this->input->get('search_date')) || !empty($this->input->get('search_fusion')))
		{
			$selected_date = $this->input->get('search_date');
			if(!empty($this->input->get('search_fusion'))){
			$selected_fusion = $this->input->get('search_fusion');
			}
		}		
		$data['selected_date'] = $selected_date;
		$data['selected_fusion'] = $selected_fusion;
		
		$data['reportType'] = $reportType = $this->uri->segment(3);
		
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$start_date = date('Y-m-d', strtotime($selected_date));
		$end_date   = date('Y-m-d', strtotime($selected_date));
		
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$sql_user = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, d.shname as department, r.name as designation,
		             CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor, getEstToLocal(s.last_logged_date, s.id) as last_logged_date from signin as s
					 LEFT JOIN signin as sp ON sp.id = s.assigned_to 
		             LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 WHERE s.fusion_id = '$selected_fusion'";
		$query_user = $this->Common_model->get_query_row_array($sql_user);
		$data['user']['fusion_id'] = $query_user['fusion_id'];
		$data['user']['name'] = $query_user['full_name'];
		$data['user']['department'] = $query_user['department'];
		$data['user']['role'] = $query_user['designation'];
		$data['user']['l1supervisor'] = $query_user['l1_supervisor'];
		$data['user']['last_logged_date'] = $query_user['last_logged_date'];
		
		$current_user_found = $query_user['id'];
			
		$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
								 CASE WHEN sh.is_local = 1
			                     THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
								 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
							     CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh 
								 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END >= CONCAT(sh.shdate, ' ', '$time_start') 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END <= CONCAT(sh.shdate, ' ', '$time_end')
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.fusion_id = '$selected_fusion' 
								 AND sh.shdate = '$start_date'
								 GROUP BY sh.shdate";
		$schedule_query = $this->Common_model->get_query_row_array($schedule_sql);
		$data['schedule_data'] = $schedule_query;
		
		$leave_sql = "SELECT l.user_id, l.leave_type_id,l.from_dt,l.to_dt,l.status, t.abbr as leave_type FROM leave_applied as l
					  LEFT JOIN leave_type as t ON t.id = l.leave_type_id 
					  WHERE l.from_dt >= '$start_date' and l.to_dt <= '$start_date' and user_id IN ($current_user_found)";
		$leave_array = $this->Common_model->get_query_result_array($leave_sql);
		foreach($leave_array as $tokenArray)
		{
			$currentDataGo = "reject";
			$currLeaveUser = $tokenArray['user_id'];
			$currLeaveFrom = $tokenArray['from_dt'];
			$currLeaveTo = $tokenArray['to_dt'];
			if($tokenArray['status'] == 1){ $currentDataGo = 'accept'; }
			$leaveAr['userid'][$currentDataGo][] = $currLeaveUser;
			$leaveAr['check'][$currentDataGo][$currLeaveUser][] = $currLeaveFrom ."," .$currLeaveTo;
			for($checkD = strtotime($tokenArray['from_dt']); $checkD <= strtotime($tokenArray['to_dt']); $checkD += (86400))
			{								  
				$curLeaveDate = date('Y-m-d', $checkD); 
				$leaveAr['dates'][$currentDataGo][$currLeaveUser][] = $curLeaveDate; 
				$leaveAr['alldates'][$currentDataGo][] = $curLeaveDate;
			} 
		}
		$data['leave_array'] = $leaveAr;		
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/agent_overview.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function dashboard()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = '9282';
		//$selected_fusion = "FKOL002079";
		//$current_user = '15261';
		//$selected_fusion = "FKOL005534";
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$selected_month = date('m'); 
		$selected_year = date('Y'); 
		$selected_fusion = get_user_fusion_id();
		if(!empty($this->input->get('select_month')) || !empty($this->input->get('select_year')))
		{
			$selected_month = $this->input->get('select_month');
			$selected_year = $this->input->get('select_year');
			if(!empty($this->input->get('select_fusion'))){
				$selected_fusion = $this->input->get('select_fusion');				
			}			
			if(empty($selected_month)){ $selected_month = "01"; }
			$currDate = $selected_year.'-'.$selected_month.'-01';
		}
		if(!isAccessAdherenceManagementView() && !get_global_access()){
			$selected_fusion = get_user_fusion_id();
		}
		
		$data['reportType'] = $reportType = $this->uri->segment(3);
		if(empty($reportType)){ $data['reportType'] = $reportType = 'monthly'; }
		
		$data['individualData']   = $individualData = $this->Schedule_adherence_model->get_schedule_adherence_individual($currDate, $selected_fusion, $reportType);
		$data['selected_month']   = $selected_month   = $individualData['selected_month'];
		$data['selected_fusion']  = $selected_fusion  = $individualData['selected_fusion'];
		$data['selected_year']    = $selected_year    = $individualData['selected_year'];
		$data['schedule_monthly'] = $individualData['schedule_monthly'];
		$data['schedule_weekly']  = $individualData['schedule_weekly'];
		$data['schedule_user']    = $individualData['schedule_user'];
		$data['user']             = $individualData['user'];
		
		//echo "<pre>".print_r($data['individualData'], 1) ."</pre>";die();
		
		$data['colorsLineArray'] = ["#efdb4c","#00c961", "#eb0000","#4877d4","#2AC773","#2AD1D1","#64A3AC"];
		
		$data['colorsPieArray'] = ["#00c961", "#eb0000","#4877d4", "#18afe9", "#dcbc1d"];		
		$data['colorsLoginArray1'] = ["#14c84b", "#d9ffed", "#0d8e35"];
		$data['colorsLoginArray2'] = ["#d6d4d4", "#d40000", "#c00101"];
		$data['colorsLoginArray3'] = ["#1285b1", "#cae8f3", "#0c7299"];
		$data['colorsLoginArray4'] = ["#eb1e1e", "#f5dede", "#eb1e1e"];
		
		$data['colorsPieArray'] = ["#28eb86", "#ff5252", "#9ea2a3", "#18afe9", "#dcbc1d"];
		$data['colorsLoginArray1'] = ["#14c84b", "#d9ffed", "#5cff94"];
		$data['colorsLoginArray2'] = ["#d6d4d4", "#ff4141", "#ffc9c9"];
		$data['colorsLoginArray3'] = ["#18afe9", "#cae8f3", "#b2eaff"];
		$data['colorsLoginArray4'] = ["#ffac2e", "#f5dede", "#ffce83"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#1BC720", "#FF4412","#0AA6D8"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/agent_dashboard.php";
		$data["content_js"] = "schedule_adherence/agent_dashboard_check_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	
    //=================================================================================================================
	//  TEAM SCHEDULE ADHERENCE
	//=================================================================================================================	
	
	public function team_overview()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = '10633';
		//$selected_fusion = "FKOL002779";
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$data['todayDate'] = $currDate = date("Y-m-d", strtotime("-1 day", strtotime(CurrDate())));
		$selected_date = date('m/d/Y', strtotime($currDate)); 
		if(!empty($this->input->get('search_date')) || !empty($this->input->get('search_fusion')))
		{
			$selected_date = $this->input->get('search_date');
			if(!empty($this->input->get('search_fusion'))){
			$selected_fusion = $this->input->get('search_fusion');
			}
		}		
		$data['selected_date'] = $selected_date;
		$data['selected_fusion'] = $selected_fusion;
		
		$data['reportType'] = $reportType = $this->uri->segment(3);
		
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$start_date = date('Y-m-d', strtotime($selected_date));
		$end_date   = date('Y-m-d', strtotime($selected_date));
		
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$sql_team = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, d.shname as department, r.name as designation,
		             GROUP_CONCAT(sp.id) as team_ids from signin as s
					 LEFT JOIN signin as sp ON sp.assigned_to = s.id 
		             LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 WHERE s.fusion_id = '$selected_fusion' AND sp.status IN (1,4)";
		$query_team = $this->Common_model->get_query_row_array($sql_team);
		$data['tl']['fusion_id'] = $query_team['fusion_id'];
		$data['tl']['name'] = $query_team['full_name'];
		$data['tl']['department'] = $query_team['department'];
		$data['tl']['role'] = $query_team['designation'];
		$data['tl']['team_id'] = $query_team['team_ids'];
		$data['tl']['search']['month'] = date('m', strtotime($selected_date));
		$data['tl']['search']['year'] = date('Y', strtotime($selected_date));
		$data['teamOverviewGraph'] = 1;
		
		$team_ids = $query_team['team_ids'];
		if(empty($team_ids)){ $team_ids = "0"; }
		$team_array = explode(',', $team_ids);
		$total_team_ids = count($team_array);
		
		$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
			                     CASE WHEN sh.is_local = 1
			                     THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
								 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
							     CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh 
								 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END >= CONCAT(sh.shdate, ' ', '$time_start') 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END <= CONCAT(sh.shdate, ' ', '$time_end')
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.user_id IN ($team_ids)
								 AND sh.shdate = '$start_date'
								 GROUP BY sh.shdate, sh.user_id";
		$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
		$data['schedule_data'] = $schedule_query;
		
		//====================  CALCULATIONS =========================================//
		$w_login = array_filter($schedule_query, function($n){
			if(!empty($n['login_time_local'])){
				return $n;
			}
		});
		$w_no_login = array_filter($schedule_query, function($n){
			if(empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))){
				return $n;
			}
		});
		
		$w_non_off = array_filter($schedule_query, function($n){
			if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
				return $n;
			}
		});

		$w_on_time = array_filter($w_non_off, function($n){
			$scheduled_login = $n['scheduled_login'];
			// for format - 0800
			if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
				$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
				$scheduled_login = $n['shdate'] ." " .$new_time .":00";
			}
			$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
			if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
				return $n;
			}
		});	
		
		$w_late_time = array_filter($w_non_off, function($n){
			$scheduled_login = $n['scheduled_login'];
			// for format - 0800
			if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
				$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
				$scheduled_login = $n['shdate'] ." " .$new_time .":00";
			}
			$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
			if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
				return $n;
			}
		});
		
		$w_off_time = array_filter($schedule_query, function($n) use ($currDate){
			//if(empty($n['login_time_local'])){ 
			if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
				if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }						
			}
		});
									
		$non_off_counter = count($w_non_off);
		$off_counter = count($schedule_query) - count($w_non_off);
		$others_counter = count($schedule_query) - (count($w_login) + count($w_no_login));
		
		$data['schedule_team']['counters']['date'] = $selected_date;
		$data['schedule_team']['counters']['scheduled'] = count($w_non_off);
		$data['schedule_team']['counters']['login'] = count($w_login);
		$data['schedule_team']['counters']['nologin'] = count($w_no_login);
		$data['schedule_team']['counters']['allnologin'] = count($schedule_query) - count($w_login);
		$data['schedule_team']['counters']['others'] = $others_counter;
		$data['schedule_team']['counters']['team'] = $total_team_ids;
		$data['schedule_team']['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
						
		$data['schedule_team']['counters']['total'] = count($schedule_query);
		$data['schedule_team']['counters']['nonoff'] = count($w_non_off);
		$data['schedule_team']['counters']['ontime'] = count($w_on_time);
		$data['schedule_team']['counters']['latetime'] = count($w_late_time);
		$data['schedule_team']['counters']['offtime'] = count($w_off_time);
		
		if(count($schedule_query) > 0){			
			$data['schedule_team']['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
			$data['schedule_team']['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
			$data['schedule_team']['percent']['allnologin'] = sprintf('%0.2f', ((count($schedule_query) - count($w_login) / count($schedule_query)) * 100));
			$data['schedule_team']['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($schedule_query)) * 100));
			
			$data['schedule_team']['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
			$data['schedule_team']['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
			$data['schedule_team']['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($w_login)) * 100));
			$data['schedule_team']['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($schedule_query)) * 100));
		} else {			
			$data['schedule_team']['percent']['login'] =  "0";
			$data['schedule_team']['percent']['nologin'] = "0";
			$data['schedule_team']['percent']['allnologin'] = "0";
			$data['schedule_team']['percent']['others'] = "0";
			
			$data['schedule_team']['percent']['adherence'] = "0";
			$data['schedule_team']['percent']['ontime'] =  "0";
			$data['schedule_team']['percent']['latetime'] = "0";
			$data['schedule_team']['percent']['offtime'] = "0";
		}
		
		
		
		
		//========================== TEAM OVERVIEW MONTHLY ===========================================//
		$data['selected_month'] = $selected_month = date('m', strtotime($start_date));
		$data['selected_year'] = $selected_year = date('Y', strtotime($end_date));
		$data['selected_fusion'] = $selected_fusion;
		
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		$start_loop = 1; $end_loop = 12;
		//if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		$currDate = CurrDate();
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end   = "23:59:59";
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
			                     CASE WHEN sh.is_local = 1
			                     THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
								 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
							     CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh 
								 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END >= CONCAT(sh.shdate, ' ', '$time_start') 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END <= CONCAT(sh.shdate, ' ', '$time_end')
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.user_id IN ($team_ids)
								 AND sh.shdate >= '$start_date' 
								 AND sh.shdate <= '$end_date'
								 GROUP BY sh.shdate, sh.user_id";
			$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
			
			$data['schedule_monthly'][$i]['data'] = $schedule_query;
			$data['schedule_monthly'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['schedule_monthly'][$i]['year'] = $selected_year;
			
			// LEAVE CALCULATIONS
			$leaveAr = array();
			$leaveAr['userid'] = array();
			$leaveAr['check'] = array();
			$leaveAr['dates'] = array();
			$leaveAr['alldates'] = array();
			$leave_sql = "SELECT l.user_id, l.leave_type_id,l.from_dt,l.to_dt,l.status, t.abbr as leave_type FROM leave_applied as l
						  LEFT JOIN leave_type as t ON t.id = l.leave_type_id 
						  WHERE l.from_dt >= '$start_date' and l.to_dt <= '$end_date' and user_id IN ($team_ids)";
			$leave_array = $this->Common_model->get_query_result_array($leave_sql);
			foreach($leave_array as $tokenArray)
			{
				$currentDataGo = "reject";
				$currLeaveUser = $tokenArray['user_id'];
				$currLeaveFrom = $tokenArray['from_dt'];
				$currLeaveTo = $tokenArray['to_dt'];
				if($tokenArray['status'] == 1){ $currentDataGo = 'accept'; }
				$leaveAr['userid'][$currentDataGo][] = $currLeaveUser;
				$leaveAr['check'][$currentDataGo][$currLeaveUser][] = $currLeaveFrom ."," .$currLeaveTo;
				for($checkD = strtotime($tokenArray['from_dt']); $checkD <= strtotime($tokenArray['to_dt']); $checkD += (86400))
				{								  
					$curLeaveDate = date('Y-m-d', $checkD); 
					$leaveAr['dates'][$currentDataGo][$currLeaveUser][] = $curLeaveDate; 
					$leaveAr['alldates'][$currentDataGo][] = $curLeaveDate;
				} 
			}
			$data['leave_array'][$i]['data'] = $leaveAr;
			//echo "<pre>".print_r($leaveAr, 1)."</pre>";
			
			//====================  MONTHLY CALCULATIONS =========================================//
				
			$w_non_off = array_filter($schedule_query, function($n) use ($currDate){
				if((strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
					return $n;
				}
			});
			$w_on_time = array_filter($w_non_off, function($n){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
					return $n;
				}
			});	
			
			$w_late_time = array_filter($w_non_off, function($n){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
					return $n;
				}
			});
			
			$w_off_time = array_filter($schedule_query, function($n) use ($currDate){
				//if(empty($n['login_time_local'])){ 
				if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
					if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }						
				}
			});
			
			$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
				} else {
					if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
				}
			});
			
			$w_leave_time = array_filter($schedule_query, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
					return $n;
				}
			});
			
			$non_off_counter = count($w_non_off);
			$off_counter = count($schedule_query) - count($w_non_off);
			
			$data['schedule_monthly'][$i]['counters']['total'] = count($schedule_query);
			$data['schedule_monthly'][$i]['counters']['scheduled'] = count($schedule_query);
			$data['schedule_monthly'][$i]['counters']['nonoff'] = count($w_non_off);
			$data['schedule_monthly'][$i]['counters']['ontime'] = count($w_on_time);
			$data['schedule_monthly'][$i]['counters']['latetime'] = count($w_late_time);
			$data['schedule_monthly'][$i]['counters']['offtime'] = count($w_off_time);
			$data['schedule_monthly'][$i]['counters']['leavetime'] = count($w_leave_time);
			$data['schedule_monthly'][$i]['counters']['absenttime'] = count($w_absent_time);
			$data['schedule_monthly'][$i]['percent']['ontime'] =  !empty($schedule_query) ? sprintf('%0.2f', ((count($w_on_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['latetime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_late_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['offtime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_off_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['leavetime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_leave_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['absenttime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_absent_time) / count($schedule_query)) * 100)) : '0';
			
			
			$d_allSchedule = count($w_non_off);
			$d_Present = count($w_on_time) + count($w_late_time);
			$d_Absent = count($w_absent_time);
			$d_Leave = count($w_leave_time);
			
			$data['schedule_monthly'][$i]['counters']['allschedule'] = count($w_non_off);
			$data['schedule_monthly'][$i]['counters']['present'] = $d_Present;
			$data['schedule_monthly'][$i]['counters']['absent'] = $d_Absent;
			$data['schedule_monthly'][$i]['counters']['leave'] = $d_Leave;
			$data['schedule_monthly'][$i]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
			$data['schedule_monthly'][$i]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', (($d_Absent / count($w_non_off)) * 100)) : '0';
			
		
			if($i == $selected_month)
			{					
				//========================= WEEKLY CALUCLATIONS =================================//
				$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
				//echo "<pre>".print_r($weekArray, 1) ."</pre>";

				$weekCounter = 0; $weekNo = 0;
				foreach($weekArray as $week)
				{
					$week_start = $week['week_start'];
					$week_end   = $week['week_end'];
					
					$date_start_w = $week_start;
					$date_end_w = $week_end;
					if(date('m', strtotime($week_start)) < date('m', strtotime($start_date))){ $date_start_w = $start_date; }
					if(date('m', strtotime($week_end)) > date('m', strtotime($end_date))){ $date_end_w = $end_date; }
					
					$weekData = array_filter($schedule_query, function($n) use($week_start, $week_end){
						if($n['shdate'] >= $week_start && $n['shdate'] <= $week_end){
							return $n;
						}
					});
					
					//====================  CALCULATIONS =========================================//			
					$w_non_off = array_filter($weekData, function($n){
						if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
							return $n;
						}
					});
					
					$w_on_time = array_filter($w_non_off, function($n){
						$scheduled_login = $n['scheduled_login'];
						// for format - 0800
						if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
							$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
							$scheduled_login = $n['shdate'] ." " .$new_time .":00";
						}
						$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
						if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
							return $n;
						}
					});	
					
					$w_late_time = array_filter($w_non_off, function($n){
						$scheduled_login = $n['scheduled_login'];
						// for format - 0800
						if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
							$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
							$scheduled_login = $n['shdate'] ." " .$new_time .":00";
						}
						$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
						if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
							return $n;
						}
					});
										
					$w_off_time = array_filter($weekData, function($n) use ($currDate){
						//if(empty($n['login_time_local'])){ 
						if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
							if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }						
						}
					});
					
					$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
						$n_user = $n['user_id'];
						if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
						} else {
							if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
						}
					});
					
					$w_leave_time = array_filter($weekData, function($n) use ($currDate, $leaveAr){
						$n_user = $n['user_id'];
						if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
							return $n;
						}
					});
												
					$non_off_counter = count($w_non_off);
					$off_counter = count($weekData) - count($w_non_off);
					
					$data['schedule_weekly'][$i][$weekCounter]['counters']['total'] = count($weekData);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['scheduled'] = count($weekData);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['nonoff'] = count($w_non_off);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['ontime'] = count($w_on_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['latetime'] = count($w_late_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['offtime'] = count($w_off_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['leavetime'] = count($w_leave_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['absenttime'] = count($w_absent_time);
					$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  !empty($weekData) ? sprintf('%0.2f', ((count($w_on_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] =  !empty($weekData) ? sprintf('%0.2f', ((count($w_late_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['offtime'] =  !empty($weekData) ? sprintf('%0.2f', ((count($w_off_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['leavetime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_leave_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['absenttime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_absent_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', (($d_Absent / count($w_non_off)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['data'] = $weekData;
					$data['schedule_weekly'][$i][$weekCounter]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
					$data['schedule_weekly'][$i][$weekCounter]['year'] = $selected_year;
					$data['schedule_weekly'][$i][$weekCounter]['weekInfo'] = $week;
					$data['schedule_weekly'][$i][$weekCounter]['week'] = ++$weekNo;
					$data['schedule_weekly'][$i][$weekCounter]['sdate'] = $date_start_w;
					$data['schedule_weekly'][$i][$weekCounter]['edate'] = $date_end_w;
					$weekCounter++;
					
				}

			}
		
		}
		
		
		
		//echo "<pre>".print_r($data, 1) ."</pre>";
		//die();
		
		
		
		$data['colorsLineArray'] = ["#efdb4c","#00c961", "#eb0000","#4877d4","#2AC773","#2AD1D1","#64A3AC"];		
		$data['colorsPieArray'] = ["#28eb86", "#ff5252", "#9ea2a3", "#18afe9", "#dcbc1d"];
		$data['colorsLoginArray1'] = ["#14c84b", "#d9ffed", "#5cff94"];
		$data['colorsLoginArray2'] = ["#d6d4d4", "#ff4141", "#ffc9c9"];
		$data['colorsLoginArray3'] = ["#18afe9", "#cae8f3", "#b2eaff"];
		$data['colorsLoginArray4'] = ["#ffac2e", "#f5dede", "#ffce83"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
		
		
		$data['colorsPieArray1'] = ["#8debba", "#e5e7e6","#4877d4"];
		$data['colorsPieArray2'] = ["#59f5a4", "#fbaeae","#4877d4"];
		$data['colorsPieLoginArray'] = ["#00c961", "#eb0000","#4877d4"];
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/team_overview.php";
		
		if($this->input->get('excel') == '1'){ $this-> generate_report_team($data); }
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	
	
	public function team()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = '10633';
		//$selected_fusion = "FKOL002779";
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$selected_month = date('m'); 
		$selected_year = date('Y'); 
		if(!empty($this->input->get('select_month')) || !empty($this->input->get('select_year')))
		{
			$selected_month = $this->input->get('select_month');
			$selected_year = $this->input->get('select_year');
			if(!empty($this->input->get('select_fusion'))){
			$selected_fusion = $this->input->get('select_fusion');
			}
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		$data['selected_fusion'] = $selected_fusion;
		
		
		$sql_team = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, d.shname as department, r.name as designation,
		             GROUP_CONCAT(sp.id) as team_ids from signin as s
					 LEFT JOIN signin as sp ON sp.assigned_to = s.id 
		             LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 WHERE s.fusion_id = '$selected_fusion'  AND sp.status IN (1,4)";
		$query_team = $this->Common_model->get_query_row_array($sql_team);
		
		$data['tl']['fusion_id'] = $query_team['fusion_id'];
		$data['tl']['name'] = $query_team['full_name'];
		$data['tl']['department'] = $query_team['department'];
		$data['tl']['role'] = $query_team['designation'];
		$data['tl']['team_id'] = $query_team['team_ids'];
		$data['tl']['search']['month'] = $selected_month;
		$data['tl']['search']['year'] = $selected_year;
		
		$team_ids = $query_team['team_ids'];
		if(empty($team_ids)){ $team_ids = "0"; }
		$team_array = explode(',', $team_ids);
		$total_team_ids = count($team_array);
		
		// TEAM USER DETAILS
		$sql_team_users = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, d.shname as department, r.name as designation, CONCAT(l1.fname, ' ', l1.lname) as l1_supervisor from signin as s
				 LEFT JOIN department as d ON d.id = s.dept_id
				 LEFT JOIN role as r ON r.id = s.role_id
				 LEFT JOIN signin as l1 ON l1.id = s.assigned_to
				 WHERE s.id IN ($team_ids) ORDER by full_name ASC";
		$data['team_users'] = $team_users = $this->Common_model->get_query_result_array($sql_team_users);
		
		$reportCheck = "daily";
		$data['reportType'] = $reportType = $this->uri->segment(3);
		
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly"){ $start_loop = 1; $end_loop = 12; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
			                     CASE WHEN sh.is_local = 1
			                     THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
								 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
							     CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh 
								 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END >= CONCAT(sh.shdate, ' ', '$time_start') 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END <= CONCAT(sh.shdate, ' ', '$time_end')
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.user_id IN ($team_ids) 
								 AND sh.shdate >= '$start_date' 
								 AND sh.shdate <= '$end_date'
								 GROUP BY sh.shdate, sh.user_id";
			$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
			$data['schedule_team'][$i]['data'] = $schedule_query;
			$data['schedule_team'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['schedule_team'][$i]['year'] = $selected_year;
			
			// LEAVE CALCULATIONS
			$leaveAr = array();
			$leaveAr['userid'] = array();
			$leaveAr['check'] = array();
			$leaveAr['dates'] = array();
			$leaveAr['alldates'] = array();
			$leave_sql = "SELECT l.user_id, l.leave_type_id,l.from_dt,l.to_dt,l.status, t.abbr as leave_type FROM leave_applied as l
						  LEFT JOIN leave_type as t ON t.id = l.leave_type_id 
						  WHERE l.from_dt >= '$start_date' and l.to_dt <= '$end_date' and user_id IN ($team_ids)";
		    $leave_array = $this->Common_model->get_query_result_array($leave_sql);
			foreach($leave_array as $tokenArray)
			{
				$currentDataGo = "reject";
				$currLeaveUser = $tokenArray['user_id'];
				$currLeaveFrom = $tokenArray['from_dt'];
				$currLeaveTo = $tokenArray['to_dt'];
				if($tokenArray['status'] == 1){ $currentDataGo = 'accept'; }
				$leaveAr['userid'][$currentDataGo][] = $currLeaveUser;
				$leaveAr['check'][$currentDataGo][$currLeaveUser][] = $currLeaveFrom ."," .$currLeaveTo;
				for($checkD = strtotime($tokenArray['from_dt']); $checkD <= strtotime($tokenArray['to_dt']); $checkD += (86400))
				{								  
					$curLeaveDate = date('Y-m-d', $checkD); 
					$leaveAr['dates'][$currentDataGo][$currLeaveUser][] = $curLeaveDate; 
					$leaveAr['alldates'][$currentDataGo][] = $curLeaveDate;
				} 
			}
			$data['leave_array'][$i]['data'] = $leaveAr;
			
		if($reportType != "weekly" || $reportType == "all"){
		
		if($reportCheck == 'userly' || $this->input->get('excel') == 1){
        foreach($team_array as $tokenUser)
		{
			//====================  CALCULATIONS =========================================//
			$current_query = array_filter($schedule_query, function($n) use ($tokenUser, $currDate){
				if($n['user_id'] == $tokenUser  && $n['shdate'] < $currDate){
					return $n;
				}
			});
			
			$w_login = array_filter($current_query, function($n) use ($tokenUser){
				if(!empty($n['login_time_local']) && $n['user_id'] == $tokenUser){
					return $n;
				}
			});
			$w_no_login = array_filter($current_query, function($n) use ($tokenUser){
				if((empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))) && $n['user_id'] == $tokenUser){
					return $n;
				}
			});
			
			$w_non_off = array_filter($current_query, function($n) use ($tokenUser){
				if((strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))) && $n['user_id'] == $tokenUser){
					return $n;
				}
			});

			$w_on_time = array_filter($w_non_off, function($n) use ($tokenUser){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['user_id'] == $tokenUser){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if(($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])) && $n['user_id'] == $tokenUser){
					return $n;
				}
			});	
			
			$w_late_time = array_filter($w_non_off, function($n) use ($tokenUser){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['user_id'] == $tokenUser){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if(($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])) && $n['user_id'] == $tokenUser){
					return $n;
				}
			});
			
			$w_off_time = array_filter($current_query, function($n) use ($tokenUser){
				//if(empty($n['login_time_local']) && $n['user_id'] == $tokenUser){ 
				if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
					if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }						
				}
			});				
						
			$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
				} else {
					if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
				}
			});
			
			$w_leave_time = array_filter($current_query, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
					return $n;
				}
			});
										
			$non_off_counter = count($w_non_off);
			$off_counter = count($current_query) - count($w_non_off);
			$others_counter = count($current_query) - (count($w_login) + count($w_no_login));
			
			$data['schedule_team'][$i][$tokenUser]['counters']['date'] = $selected_date;
			$data['schedule_team'][$i][$tokenUser]['counters']['scheduled'] = count($w_non_off);
			$data['schedule_team'][$i][$tokenUser]['counters']['login'] = count($w_login);
			$data['schedule_team'][$i][$tokenUser]['counters']['nologin'] = count($w_no_login);
			$data['schedule_team'][$i][$tokenUser]['counters']['allnologin'] = count($current_query) - count($w_login);
			$data['schedule_team'][$i][$tokenUser]['counters']['others'] = $others_counter;
			$data['schedule_team'][$i][$tokenUser]['counters']['team'] = $total_team_ids;
			$data['schedule_team'][$i][$tokenUser]['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
							
			$data['schedule_team'][$i][$tokenUser]['counters']['total'] = count($current_query);
			$data['schedule_team'][$i][$tokenUser]['counters']['nonoff'] = count($w_non_off);
			$data['schedule_team'][$i][$tokenUser]['counters']['ontime'] = count($w_on_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['latetime'] = count($w_late_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['offtime'] = count($w_off_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['leavetime'] = count($w_leave_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['absenttime'] = count($w_absent_time);
			
			$data['schedule_team'][$i][$tokenUser]['percent']['leavetime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_leave_time) / count($current_query)) * 100)) : '0';
			$data['schedule_team'][$i][$tokenUser]['percent']['absenttime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_absent_time) / count($current_query)) * 100)) : '0';
			$data['schedule_team'][$i][$tokenUser]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
			$data['schedule_team'][$i][$tokenUser]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_absent_time) / count($w_non_off)) * 100)) : '0';
				
			if(count($current_query) > 0){			
				$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = sprintf('%0.2f', ((count($current_query) - count($w_login) / count($current_query)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($current_query)) * 100));
				
				$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($current_query)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($current_query)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($current_query)) * 100));
			} else {			
				$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['others'] = "0";
				
				$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = "0";
			}
		}
		}
		
		
		if($reportCheck == 'daily'  || $reportType == "all"){
        for($j=1;$j<=$total_days;$j++)
		{
			$tokenUser = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
			//====================  CALCULATIONS =========================================//
			$current_query = array_filter($schedule_query, function($n) use ($tokenUser, $currDate){
				if($n['shdate'] == $tokenUser  && $n['shdate'] < $currDate){
					return $n;
				}
			});
			
			
			$w_non_off = array_filter($current_query, function($n) use ($tokenUser){
				if((strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))) && $n['shdate'] == $tokenUser){
					return $n;
				}
			});
			
			$w_login = array_filter($w_non_off, function($n) use ($tokenUser){
				if(!empty($n['login_time_local']) && $n['shdate'] == $tokenUser){
					return $n;
				}
			});
			$w_no_login = array_filter($w_non_off, function($n) use ($tokenUser){
				if((empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))) && $n['shdate'] == $tokenUser){
					return $n;
				}
			});

			$w_on_time = array_filter($w_non_off, function($n) use ($tokenUser){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['shdate'] == $tokenUser){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if(($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])) && $n['shdate'] == $tokenUser){
					return $n;
				}
			});	
			
			$w_late_time = array_filter($w_non_off, function($n) use ($tokenUser){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['shdate'] == $tokenUser){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if(($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])) && $n['shdate'] == $tokenUser){
					return $n;
				}
			});
			
			$w_off_time = array_filter($current_query, function($n) use ($tokenUser,$currDate){
				//if(empty($n['login_time_local']) && $n['shdate'] == $tokenUser){ 
				if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){	
						if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }
				}
			});
			
			$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
				} else {
					if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
				}
			});
			
			$w_leave_time = array_filter($current_query, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
					return $n;
				}
			});
										
			$non_off_counter = count($w_non_off);
			$off_counter = count($current_query) - count($w_non_off);
			$others_counter = count($current_query) - (count($w_login) + count($w_no_login));
			
			$data['schedule_team'][$i][$tokenUser]['counters']['date'] = $tokenUser;
			$data['schedule_team'][$i][$tokenUser]['counters']['scheduled'] = count($w_non_off);
			$data['schedule_team'][$i][$tokenUser]['counters']['login'] = count($w_login);
			$data['schedule_team'][$i][$tokenUser]['counters']['nologin'] = count($w_no_login);
			$data['schedule_team'][$i][$tokenUser]['counters']['allnologin'] = count($current_query) - count($w_login);
			$data['schedule_team'][$i][$tokenUser]['counters']['others'] = $others_counter;
			$data['schedule_team'][$i][$tokenUser]['counters']['team'] = $total_team_ids;
			$data['schedule_team'][$i][$tokenUser]['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
							
			$data['schedule_team'][$i][$tokenUser]['counters']['total'] = count($current_query);
			$data['schedule_team'][$i][$tokenUser]['counters']['nonoff'] = count($w_non_off);
			$data['schedule_team'][$i][$tokenUser]['counters']['ontime'] = count($w_on_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['latetime'] = count($w_late_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['offtime'] = count($w_off_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['leavetime'] = count($w_leave_time);
			$data['schedule_team'][$i][$tokenUser]['counters']['absenttime'] = count($w_absent_time);
			
			$data['schedule_team'][$i][$tokenUser]['percent']['leavetime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_leave_time) / count($current_query)) * 100)) : '0';
			$data['schedule_team'][$i][$tokenUser]['percent']['absenttime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_absent_time) / count($current_query)) * 100)) : '0';
			$data['schedule_team'][$i][$tokenUser]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
			$data['schedule_team'][$i][$tokenUser]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_absent_time) / count($w_non_off)) * 100)) : '0';
				
			if(count($current_query) > 0){			
				$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = sprintf('%0.2f', ((count($current_query) - count($w_login) / count($current_query)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($current_query)) * 100));
				
				$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($current_query)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($current_query)) * 100));
				$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($current_query)) * 100));
			} else {			
				$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['others'] = "0";
				
				$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = "0";
			}
			
			if(count($w_login) < 1)
			{					
				$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] = "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  "0";
				$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = "0";
			}
			
		}
		}

		}
		
		if($reportType == "weekly" || $reportType == "all"){
				
			if($i == $selected_month){
				
			//========================= GET WEEKLY CALUCLATIONS =================================//
			$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
			//echo "<pre>".print_r($weekArray, 1) ."</pre>";

			$weekCounter = 0; $weekNo = 0;
			foreach($weekArray as $week)
			{
				$week_start = $week['week_start'];
				$week_end   = $week['week_end'];
				
				$date_start_w = $week_start;
				$date_end_w = $week_end;
				if(date('m', strtotime($week_start)) < date('m', strtotime($start_date))){ $date_start_w = $start_date; }
				if(date('m', strtotime($week_end)) > date('m', strtotime($end_date))){ $date_end_w = $end_date; }
				
				$weekData = array_filter($schedule_query, function($n) use($date_start_w, $date_end_w){
					if($n['shdate'] >= $date_start_w && $n['shdate'] <= $date_end_w){
						return $n;
					}
				});
				
				//====================  CALCULATIONS =========================================//				
			
				$w_non_off = array_filter($weekData, function($n){
					if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
						return $n;
					}
				});
				
				$w_login = array_filter($w_non_off, function($n){
					if(!empty($n['login_time_local'])){
						return $n;
					}
				});
				$w_no_login = array_filter($w_non_off, function($n){
					if(empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))){
						return $n;
					}
				});
				
				$w_on_time = array_filter($w_non_off, function($n){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
						return $n;
					}
				});	
				
				$w_late_time = array_filter($w_non_off, function($n){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
						return $n;
					}
				});
				
				$w_off_time = array_filter($weekData, function($n) use ($currDate){
						//if(empty($n['login_time_local'])){ 
						if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){	
							if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }
						}
					});
				
				
				$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
					$n_user = $n['user_id'];
					if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
					} else {
						if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
					}
				});
				
				$w_leave_time = array_filter($weekData, function($n) use ($currDate, $leaveAr){
					$n_user = $n['user_id'];
					if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
						return $n;
					}
				});
											
				$non_off_counter = count($w_non_off);
				$off_counter = count($weekData) - count($w_non_off);
				$others_counter = count($weekData) - (count($w_login) + count($w_no_login));
			
				$data['schedule_weekly'][$i][$weekCounter]['counters']['date'] = $date_start_w;
				$data['schedule_weekly'][$i][$weekCounter]['counters']['scheduled'] = count($w_non_off);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['login'] = count($w_login);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['nologin'] = count($w_no_login);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['allnologin'] = count($weekData) - count($w_login);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['others'] = $others_counter;
				$data['schedule_weekly'][$i][$weekCounter]['counters']['team'] = $total_team_ids;
				$data['schedule_weekly'][$i][$weekCounter]['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
								
				$data['schedule_weekly'][$i][$weekCounter]['counters']['total'] = count($weekData);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['nonoff'] = count($w_non_off);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['ontime'] = count($w_on_time);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['latetime'] = count($w_late_time);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['offtime'] = count($w_off_time);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['leavetime'] = count($w_leave_time);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['absenttime'] = count($w_absent_time);
					
				$data['schedule_weekly'][$i][$weekCounter]['percent']['leavetime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_leave_time) / count($weekData)) * 100)) : '0';
				$data['schedule_weekly'][$i][$weekCounter]['percent']['absenttime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_absent_time) / count($weekData)) * 100)) : '0';					
				$data['schedule_weekly'][$i][$weekCounter]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
				$data['schedule_weekly'][$i][$weekCounter]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_absent_time) / count($w_non_off)) * 100)) : '0';
				
				if(count($weekData) > 0){			
					$data['schedule_weekly'][$i][$weekCounter]['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
					$data['schedule_weekly'][$i][$weekCounter]['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
					$data['schedule_weekly'][$i][$weekCounter]['percent']['allnologin'] = sprintf('%0.2f', ((count($weekData) - count($w_login) / count($weekData)) * 100));
					$data['schedule_weekly'][$i][$weekCounter]['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($weekData)) * 100));
					
					$data['schedule_weekly'][$i][$weekCounter]['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
					$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($weekData)) * 100));
					$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($weekData)) * 100));
					$data['schedule_weekly'][$i][$weekCounter]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($weekData)) * 100));
				} else {			
					$data['schedule_weekly'][$i][$weekCounter]['percent']['login'] =  "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['nologin'] = "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['allnologin'] = "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['others'] = "0";
					
					$data['schedule_weekly'][$i][$weekCounter]['percent']['adherence'] = "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] = "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['offtime'] = "0";
				}
				
				if(count($w_login) < 1)
				{					
					$data['schedule_weekly'][$i][$weekCounter]['percent']['adherence'] = "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  "0";
					$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] = "0";
				}
				
				$data['schedule_weekly'][$i][$weekCounter]['data'] = $weekData;
				$data['schedule_weekly'][$i][$weekCounter]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
				$data['schedule_weekly'][$i][$weekCounter]['year'] = $selected_year;
				$data['schedule_weekly'][$i][$weekCounter]['weekInfo'] = $week;
				$data['schedule_weekly'][$i][$weekCounter]['week'] = ++$weekNo;
				$data['schedule_weekly'][$i][$weekCounter]['sdate'] = $date_start_w;
				$data['schedule_weekly'][$i][$weekCounter]['edate'] = $date_end_w;
				$weekCounter++;
				
			}

			}
			
		}
			
			$data['schedule_user']['fusion_id'] = $schedule_query[0]['fusion_id'];
			$data['schedule_user']['name'] = $schedule_query[0]['full_name'];
			$data['schedule_user']['department'] = $schedule_query[0]['department'];
			$data['schedule_user']['role'] = $schedule_query[0]['designation'];
			$data['schedule_user']['l1supervisor'] = $schedule_query[0]['l1_supervisor'];
			
			
			
		}
		//echo "<pre>".print_r($data['schedule_weekly'], 1) ."</pre>";die();
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
		
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/team_level.php";
		
		if($this->input->get('excel') == '1'){ $this-> generate_report_team_full($data); }
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	//=========================================================================================================
	// MANAGER LEVEL ADHERENCE
	//==========================================================================================================
	
	public function manager_overview()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = '10633';
		//$selected_fusion = "FKOL002779";
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$data['todayDate'] = $currDate = date("Y-m-d", strtotime("-1 day", strtotime(CurrDate())));
		$selected_office = $user_office_id;
		$selected_month = date('m');
		$selected_year = date('Y');
		$selected_date = date('m/d/Y', strtotime($currDate));
		if(!empty($this->input->get('select_office')) || !empty($this->input->get('select_process')))
		{
			$selected_office = $this->input->get('select_office');
			$selected_client = $this->input->get('select_client');
			$selected_process = $this->input->get('select_process');
			$selected_department = $this->input->get('select_department');
			if($selected_process == 0){ $selected_process = 'ALL'; }
		}
		if(!empty($this->input->get('select_month')) || !empty($this->input->get('select_year')))
		{
			$selected_month = $this->input->get('select_month');
			$selected_year = $this->input->get('select_year');
		}
		if(!empty($this->input->get('search_date')))
		{
			$selected_date = $this->input->get('search_date');
		}
		$data['selected_office'] = $selected_office;
		$data['selected_process'] = $selected_process;
		$data['selected_client'] = $selected_client;
		$data['selected_department'] = $selected_department;
		//$data['selected_month'] = $selected_month;
		//$data['selected_year'] = $selected_year;
		
		$data['selected_date'] = date('Y-m-d', strtotime($selected_date));
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		
		
		$data['reportType'] = $reportType = $this->uri->segment(3);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		//$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $selected_month), $selected_year);
		//$start_date = $selected_year ."-". sprintf('%02d', $selected_month) ."-01";
		//$end_date   = $selected_year ."-". sprintf('%02d', $selected_month) ."-" .$total_days;
		$start_date = date('Y-m-d', strtotime($selected_date));
		$end_date   = date('Y-m-d', strtotime($selected_date));
		
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		// OFFICE & PROCESS LIST
		if(get_global_access() == 1 || get_dept_folder()=="wfm"){
			$data['location_list'] = $this->Common_model->get_office_location_list();			
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['client_list'] = $this->Common_model->get_client_list();
		$data['process_list'] = $this->Common_model->get_process_for_assign();
		if(!empty($selected_client) && $selected_client != "ALL"){ $data['process_list'] = $this->Common_model->get_process_list($selected_client); }
		$data['department_list'] = $this->Common_model->get_department_list();
		
		// FILTER CREATE
		$extraFilter = "";
		if((!empty($selected_client) && $selected_client != "ALL") && (empty($selected_process) || $selected_process == 'ALL'))
		{
			$extraFilter .= " AND is_assign_client(s.id, $selected_client)"; 
		} else {
			if(!empty($selected_process) && $selected_process != 'ALL'){ 
				$extraFilter .= " AND is_assign_process(s.id, $selected_process)"; 
			}
		}
		if(!empty($selected_department) && $selected_department != 'ALL'){ $extraFilter .= " AND s.dept_id = '$selected_department'"; }
		
		$data['searched']['office'] = $selected_office;
		$data['searched']['dept'] = 'ALL';
		$data['searched']['process'] = 'ALL';
		
		if(!empty($selected_process) && !empty($selected_office))
		{
			$sql_team = "SELECT s.id, p.name as process_name, o.office_name, d.shname as department from signin as s 
						 LEFT JOIN process as p ON p.id = '$selected_process'
						 LEFT JOIN office_location as o ON o.abbr = '$selected_office'
						 LEFT JOIN department as d ON d.id = s.dept_id
						 WHERE s.office_id = '$selected_office' $extraFilter AND s.status IN (1,4)";
			$query_team = $this->Common_model->get_query_result_array($sql_team);
			$data['tl']['team_id'] = $query_team[0]['team_ids'];
			$data['tl']['search']['month'] = $selected_month;
			$data['tl']['search']['year'] = $selected_year;
			$data['tl']['search']['office'] = $query_team[0]['office_name'];
			$data['tl']['search']['process'] = $query_team[0]['process_name'];
			
			if(!empty($selected_department) && $selected_department != 'ALL'){
			$data['searched']['dept'] = $query_team['department'];
			}
			if(!empty($selected_process) && $selected_process != 'ALL'){
			$data['searched']['process'] = $query_team['process_name'];
			}
			
			$team_ids = "0";
			$team_ids = implode(',', array_column($query_team, 'id'));
			if(empty($team_ids)){ $team_ids = "0"; }
			$team_array = explode(',', $team_ids);
			$total_team_ids = count($team_array);
			if(!empty($team_ids))
			{
				$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
										 d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
										 CASE WHEN sh.is_local = 1
										 THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
										 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
										 CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
										 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
										 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
										 END as scheduled_logout
										 from user_shift_schedule as sh 
										 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
										 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END >= CONCAT(sh.shdate, ' ', '$time_start') 
										 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END <= CONCAT(sh.shdate, ' ', '$time_end')
										 INNER JOIN signin as s ON s.id = sh.user_id
										 INNER JOIN signin as sl ON sl.id = s.assigned_to
										 LEFT JOIN department as d ON d.id = s.dept_id
										 LEFT JOIN role as r ON r.id = s.role_id
										 WHERE 
										 sh.user_id IN ($team_ids)
										 AND sh.shdate >= '$start_date' 
								         AND sh.shdate <= '$end_date'
										 GROUP BY sh.shdate, sh.user_id";
				$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
				$data['schedule_data'] = $schedule_query;
				
					
				//====================  CALCULATIONS =========================================//
				$w_login = array_filter($schedule_query, function($n){
					if(!empty($n['login_time_local'])){
						return $n;
					}
				});
				$w_no_login = array_filter($schedule_query, function($n){
					if(empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))){
						return $n;
					}
				});
				
				$w_non_off = array_filter($schedule_query, function($n){
					if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
						return $n;
					}
				});

				$w_on_time = array_filter($w_non_off, function($n){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
						return $n;
					}
				});	
				
				$w_late_time = array_filter($w_non_off, function($n){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
						return $n;
					}
				});
				
				$w_off_time = array_filter($schedule_query, function($n){
					if(empty($n['login_time_local'])){ 
						return $n;
					}
				});
											
				$non_off_counter = count($w_non_off);
				$off_counter = count($schedule_query) - count($w_non_off);
				$others_counter = count($schedule_query) - (count($w_login) + count($w_no_login));
				
				$data['schedule_team']['counters']['date'] = $selected_date;
				$data['schedule_team']['counters']['scheduled'] = count($w_non_off);
				$data['schedule_team']['counters']['login'] = count($w_login);
				$data['schedule_team']['counters']['nologin'] = count($w_no_login);
				$data['schedule_team']['counters']['allnologin'] = count($schedule_query) - count($w_login);
				$data['schedule_team']['counters']['others'] = $others_counter;
				$data['schedule_team']['counters']['team'] = $total_team_ids;
				$data['schedule_team']['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
								
				$data['schedule_team']['counters']['total'] = count($schedule_query);
				$data['schedule_team']['counters']['nonoff'] = count($w_non_off);
				$data['schedule_team']['counters']['ontime'] = count($w_on_time);
				$data['schedule_team']['counters']['latetime'] = count($w_late_time);
				$data['schedule_team']['counters']['offtime'] = count($w_off_time);
				
				if(count($schedule_query) > 0){			
					$data['schedule_team']['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
					$data['schedule_team']['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
					$data['schedule_team']['percent']['allnologin'] = sprintf('%0.2f', ((count($schedule_query) - count($w_login) / count($schedule_query)) * 100));
					$data['schedule_team']['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($schedule_query)) * 100));
					
					$data['schedule_team']['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
					$data['schedule_team']['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
					$data['schedule_team']['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($w_login)) * 100));
					$data['schedule_team']['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($schedule_query)) * 100));
				} else {			
					$data['schedule_team']['percent']['login'] =  "0";
					$data['schedule_team']['percent']['nologin'] = "0";
					$data['schedule_team']['percent']['allnologin'] = "0";
					$data['schedule_team']['percent']['others'] = "0";
					
					$data['schedule_team']['percent']['adherence'] = "0";
					$data['schedule_team']['percent']['ontime'] =  "0";
					$data['schedule_team']['percent']['latetime'] = "0";
					$data['schedule_team']['percent']['offtime'] = "0";
				}
				
				if(count($w_login) < 1)
				{					
					$data['schedule_team']['percent']['adherence'] = "0";
					$data['schedule_team']['percent']['ontime'] =  "0";
					$data['schedule_team']['percent']['latetime'] = "0";
				}
				
			}
		
		
		//========================== TEAM OVERVIEW MONTHLY ===========================================//
		$data['selected_month'] = $selected_month = date('m', strtotime($start_date));
		$data['selected_year'] = $selected_year = date('Y', strtotime($end_date));
		$data['selected_fusion'] = $selected_fusion;
		
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		$start_loop = 1; $end_loop = 12;
		//if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		$currDate = CurrDate();
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end   = "23:59:59";
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
			                     CASE WHEN sh.is_local = 1
			                     THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
								 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
							     CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh 
								 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END >= CONCAT(sh.shdate, ' ', '$time_start') 
								 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END <= CONCAT(sh.shdate, ' ', '$time_end')
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.user_id IN ($team_ids)
								 AND sh.shdate >= '$start_date' 
								 AND sh.shdate <= '$end_date'
								 GROUP BY sh.shdate, sh.user_id";
			$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
			
			$data['schedule_monthly'][$i]['data'] = $schedule_query;
			$data['schedule_monthly'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['schedule_monthly'][$i]['year'] = $selected_year;
			
			
			// LEAVE CALCULATIONS
			$leaveAr = array();
			$leaveAr['userid'] = array();
			$leaveAr['check'] = array();
			$leaveAr['dates'] = array();
			$leaveAr['alldates'] = array();
			$leave_sql = "SELECT l.user_id, l.leave_type_id,l.from_dt,l.to_dt,l.status, t.abbr as leave_type FROM leave_applied as l
						  LEFT JOIN leave_type as t ON t.id = l.leave_type_id 
						  WHERE l.from_dt >= '$start_date' and l.to_dt <= '$end_date' and user_id IN ($team_ids)";
		    $leave_array = $this->Common_model->get_query_result_array($leave_sql);
			foreach($leave_array as $tokenArray)
			{
				$currentDataGo = "reject";
				$currLeaveUser = $tokenArray['user_id'];
				$currLeaveFrom = $tokenArray['from_dt'];
				$currLeaveTo = $tokenArray['to_dt'];
				if($tokenArray['status'] == 1){ $currentDataGo = 'accept'; }
				$leaveAr['userid'][$currentDataGo][] = $currLeaveUser;
				$leaveAr['check'][$currentDataGo][$currLeaveUser][] = $currLeaveFrom ."," .$currLeaveTo;
				for($checkD = strtotime($tokenArray['from_dt']); $checkD <= strtotime($tokenArray['to_dt']); $checkD += (86400))
				{								  
					$curLeaveDate = date('Y-m-d', $checkD); 
					$leaveAr['dates'][$currentDataGo][$currLeaveUser][] = $curLeaveDate; 
					$leaveAr['alldates'][$currentDataGo][] = $curLeaveDate;
				} 
			}
			$data['leave_array'][$i]['data'] = $leaveAr;
			
			//====================  MONTHLY CALCULATIONS =========================================//
				
			$w_non_off = array_filter($schedule_query, function($n) use ($currDate){
				if((strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
					return $n;
				}
			});
			$w_on_time = array_filter($w_non_off, function($n){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
					return $n;
				}
			});	
			
			$w_late_time = array_filter($w_non_off, function($n){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
					return $n;
				}
			});
						
			$w_off_time = array_filter($schedule_query, function($n) use ($currDate){
				//if(empty($n['login_time_local'])){ 
				if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
					if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }						
				}
			});
						
			$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
				} else {
					if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
				}
			});
			
			$w_leave_time = array_filter($schedule_query, function($n) use ($currDate, $leaveAr){
				$n_user = $n['user_id'];
				if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
					return $n;
				}
			});
				
			$non_off_counter = count($w_non_off);
			$off_counter = count($schedule_query) - count($w_non_off);
			
			$data['schedule_monthly'][$i]['counters']['total'] = count($schedule_query);
			$data['schedule_monthly'][$i]['counters']['scheduled'] = count($schedule_query);
			$data['schedule_monthly'][$i]['counters']['nonoff'] = count($w_non_off);
			$data['schedule_monthly'][$i]['counters']['ontime'] = count($w_on_time);
			$data['schedule_monthly'][$i]['counters']['latetime'] = count($w_late_time);
			$data['schedule_monthly'][$i]['counters']['offtime'] = count($w_off_time);
			$data['schedule_monthly'][$i]['counters']['leavetime'] = count($w_leave_time);
			$data['schedule_monthly'][$i]['counters']['absenttime'] = count($w_absent_time);
			$data['schedule_monthly'][$i]['percent']['ontime'] =  !empty($schedule_query) ? sprintf('%0.2f', ((count($w_on_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['latetime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_late_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['offtime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_off_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['leavetime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_leave_time) / count($schedule_query)) * 100)) : '0';
			$data['schedule_monthly'][$i]['percent']['absenttime'] = !empty($schedule_query) ? sprintf('%0.2f', ((count($w_absent_time) / count($schedule_query)) * 100)) : '0';
			
			$d_allSchedule = count($w_non_off);
			$d_Present = count($w_on_time) + count($w_late_time);
			$d_Absent = count($w_absent_time);
			$d_Leave = count($w_leave_time);
			
			$data['schedule_monthly'][$i]['counters']['allschedule'] = count($w_non_off);
			$data['schedule_monthly'][$i]['counters']['present'] = $d_Present;
			$data['schedule_monthly'][$i]['counters']['absent'] = $d_Absent;
			$data['schedule_monthly'][$i]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
			$data['schedule_monthly'][$i]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', (($d_Absent / count($w_non_off)) * 100)) : '0';
			
		
			if($i == $selected_month)
			{					
				//========================= WEEKLY CALUCLATIONS =================================//
				$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
				//echo "<pre>".print_r($weekArray, 1) ."</pre>";

				$weekCounter = 0; $weekNo = 0;
				foreach($weekArray as $week)
				{
					$week_start = $week['week_start'];
					$week_end   = $week['week_end'];
					
					$date_start_w = $week_start;
					$date_end_w = $week_end;
					if(date('m', strtotime($week_start)) < date('m', strtotime($start_date))){ $date_start_w = $start_date; }
					if(date('m', strtotime($week_end)) > date('m', strtotime($end_date))){ $date_end_w = $end_date; }
					
					$weekData = array_filter($schedule_query, function($n) use($week_start, $week_end){
						if($n['shdate'] >= $week_start && $n['shdate'] <= $week_end){
							return $n;
						}
					});
					
					//====================  CALCULATIONS =========================================//			
					$w_non_off = array_filter($weekData, function($n){
						if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
							return $n;
						}
					});
					
					$w_on_time = array_filter($w_non_off, function($n){
						$scheduled_login = $n['scheduled_login'];
						// for format - 0800
						if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
							$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
							$scheduled_login = $n['shdate'] ." " .$new_time .":00";
						}
						$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
						if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
							return $n;
						}
					});	
					
					$w_late_time = array_filter($w_non_off, function($n){
						$scheduled_login = $n['scheduled_login'];
						// for format - 0800
						if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
							$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
							$scheduled_login = $n['shdate'] ." " .$new_time .":00";
						}
						$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
						if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
							return $n;
						}
					});
										
					$w_off_time = array_filter($weekData, function($n) use ($currDate){
						//if(empty($n['login_time_local'])){ 
						if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){	
							if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }
						}
					});
					
					$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
						$n_user = $n['user_id'];
						if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
						} else {
							if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
						}
					});
					
					$w_leave_time = array_filter($weekData, function($n) use ($currDate, $leaveAr){
						$n_user = $n['user_id'];
						if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
							return $n;
						}
					});
												
					$non_off_counter = count($w_non_off);
					$off_counter = count($weekData) - count($w_non_off);
					
					$data['schedule_weekly'][$i][$weekCounter]['counters']['total'] = count($weekData);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['scheduled'] = count($weekData);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['nonoff'] = count($w_non_off);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['ontime'] = count($w_on_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['latetime'] = count($w_late_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['offtime'] = count($w_off_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['leavetime'] = count($w_leave_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['absenttime'] = count($w_absent_time);
					$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  !empty($weekData) ? sprintf('%0.2f', ((count($w_on_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] =  !empty($weekData) ? sprintf('%0.2f', ((count($w_late_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['offtime'] =  !empty($weekData) ? sprintf('%0.2f', ((count($w_off_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['leavetime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_leave_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['absenttime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_absent_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['data'] = $weekData;
					$data['schedule_weekly'][$i][$weekCounter]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
					$data['schedule_weekly'][$i][$weekCounter]['year'] = $selected_year;
					$data['schedule_weekly'][$i][$weekCounter]['weekInfo'] = $week;
					$data['schedule_weekly'][$i][$weekCounter]['week'] = ++$weekNo;
					$data['schedule_weekly'][$i][$weekCounter]['sdate'] = $date_start_w;
					$data['schedule_weekly'][$i][$weekCounter]['edate'] = $date_end_w;
					$weekCounter++;
					
				}

			}
		
		}
		
		//echo "<pre>".print_r($data, 1) ."</pre>";
		//die();
		
		$data['colorsLineArray'] = ["#efdb4c","#00c961", "#eb0000","#4877d4","#2AC773","#2AD1D1","#64A3AC"];		
		$data['colorsPieArray'] = ["#28eb86", "#ff5252", "#9ea2a3", "#18afe9", "#dcbc1d"];
		$data['colorsLoginArray1'] = ["#14c84b", "#d9ffed", "#5cff94"];
		$data['colorsLoginArray2'] = ["#d6d4d4", "#ff4141", "#ffc9c9"];
		$data['colorsLoginArray3'] = ["#18afe9", "#cae8f3", "#b2eaff"];
		$data['colorsLoginArray4'] = ["#ffac2e", "#f5dede", "#ffce83"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
		
		
		$data['colorsPieArray1'] = ["#8debba", "#e5e7e6","#4877d4"];
		$data['colorsPieArray2'] = ["#59f5a4", "#fbaeae","#4877d4"];
		$data['colorsPieLoginArray'] = ["#00c961", "#eb0000","#4877d4"];
		
		}
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/manager_overview.php";
		
		if($this->input->get('excel') == '1'){ $this-> generate_report_management($data); }
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function manager_level()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = '10633';
		//$selected_fusion = "FKOL002779";
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$selected_office = $user_office_id;
		$selected_month = date('m');
		$selected_year = date('Y');
		$selected_date = date('m/d/Y');
		if(!empty($this->input->get('select_office')) || !empty($this->input->get('select_process')))
		{
			$selected_office = $this->input->get('select_office');
			$selected_process = $this->input->get('select_process');
			$selected_client = $this->input->get('select_client');
			$selected_department = $this->input->get('select_department');
			if($selected_process == 0){ $selected_process = 'ALL'; }
		}
		if(!empty($this->input->get('select_month')) || !empty($this->input->get('select_year')))
		{
			$selected_month = $this->input->get('select_month');
			$selected_year = $this->input->get('select_year');
		}
		if(!empty($this->input->get('search_date')))
		{
			$selected_date = $this->input->get('search_date');
		}
		$data['selected_office'] = $selected_office;
		$data['selected_process'] = $selected_process;
		$data['selected_client'] = $selected_client;
		$data['selected_department'] = $selected_department;
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		
	
		$data['reportType'] = $reportType = $this->uri->segment(3);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $selected_month), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $selected_month) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $selected_month) ."-" .$total_days;
		
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		// OFFICE & PROCESS LIST
		if(get_global_access() == 1 || get_dept_folder()=="wfm"){
			$data['location_list'] = $this->Common_model->get_office_location_list();			
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['client_list'] = $this->Common_model->get_client_list();
		$data['process_list'] = $this->Common_model->get_process_for_assign();
		if(!empty($selected_client) && $selected_client != "ALL"){ $data['process_list'] = $this->Common_model->get_process_list($selected_client); }
		$data['department_list'] = $this->Common_model->get_department_list();
		
		// FILTER CREATE
		$extraFilter = "";		
		if((!empty($selected_client) && $selected_client != "ALL") && (empty($selected_process) || $selected_process == 'ALL'))
		{
			$extraFilter .= " AND is_assign_client(s.id, $selected_client)"; 
		} else {
			if(!empty($selected_process) && $selected_process != 'ALL'){ 
				$extraFilter .= " AND is_assign_process(s.id, $selected_process)"; 
			}
		}
		if(!empty($selected_department) && $selected_department != 'ALL'){ $extraFilter .= " AND s.dept_id = '$selected_department'"; }
		
		if(!empty($selected_process) && !empty($selected_office))
		{
			$sql_team = "SELECT s.id, p.name as process_name, o.office_name from signin as s 
						 LEFT JOIN process as p ON p.id = '$selected_process'
						 LEFT JOIN office_location as o ON o.abbr = '$selected_office'
						 WHERE s.office_id = '$selected_office' $extraFilter AND s.status IN (1,4)";
			$query_team = $this->Common_model->get_query_result_array($sql_team);
			$data['tl']['team_id'] = $query_team[0]['team_ids'];
			$data['tl']['search']['month'] = $selected_month;
			$data['tl']['search']['year'] = $selected_year;
			$data['tl']['search']['office'] = $query_team[0]['office_name'];
			$data['tl']['search']['process'] = $query_team[0]['process_name'];
			$data['teamOverviewGraph'] = 1;
						
			$team_ids = "0";
			$team_ids = implode(',', array_column($query_team, 'id'));
			if(empty($team_ids)){ $team_ids = "0"; }
			$data['teamid_array'] = $team_array = explode(',', $team_ids);
			$total_team_ids = count($team_array);
			
			// TEAM USER DETAILS
			$sql_team_users = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, d.shname as department, r.name as designation, CONCAT(l1.fname, ' ', l1.lname) as l1_supervisor from signin as s
		             LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 LEFT JOIN signin as l1 ON l1.id = s.assigned_to
					 WHERE s.id IN ($team_ids) ORDER by full_name ASC";
		    $data['team_users'] = $team_users = $this->Common_model->get_query_result_array($sql_team_users);
			//echo "<pre>".print_r($team_users, 1)."</pre>"; die();
			
			$reportCheck = "daily";
			$data['reportType'] = $reportType = $this->uri->segment(3);
			if($reportType == 'userly'){ $reportCheck = "userly"; }
			$start_loop = round($selected_month); 
			$end_loop = round($selected_month);
			if($reportType == "yearly"){ $start_loop = 1; $end_loop = 12; }
			
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
				$time_start = "00:00:00";
				$time_end = "23:59:59";
				$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
				$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
				$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
				
				$start_date_full = $start_date ." " .$time_start;
				$end_date_full = $end_date ." " .$time_end;
				
				$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
									 d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
									 CASE WHEN sh.is_local = 1
									 THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
									 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
									 CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
									 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
									 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
									 END as scheduled_logout
									 from user_shift_schedule as sh 
									 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
									 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END >= CONCAT(sh.shdate, ' ', '$time_start') 
									 AND CASE WHEN sh.is_local = 1 THEN lg.login_time_local ELSE lg.login_time END <= CONCAT(sh.shdate, ' ', '$time_end')
									 INNER JOIN signin as s ON s.id = sh.user_id
									 INNER JOIN signin as sl ON sl.id = s.assigned_to
									 LEFT JOIN department as d ON d.id = s.dept_id
									 LEFT JOIN role as r ON r.id = s.role_id
									 WHERE 
									 sh.user_id IN ($team_ids) 
									 AND sh.shdate >= '$start_date' 
									 AND sh.shdate <= '$end_date'
									 GROUP BY sh.shdate, sh.user_id";
				$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
				//$data['schedule_team'][$i]['data'] = $schedule_query;
				$data['schedule_team'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
				$data['schedule_team'][$i]['year'] = $selected_year;
				
				// LEAVE CALCULATIONS
				$leaveAr = array();
				$leaveAr['userid'] = array();
				$leaveAr['check'] = array();
				$leaveAr['dates'] = array();
				$leaveAr['alldates'] = array();
				$leave_sql = "SELECT l.user_id, l.leave_type_id,l.from_dt,l.to_dt,l.status, t.abbr as leave_type FROM leave_applied as l
							  LEFT JOIN leave_type as t ON t.id = l.leave_type_id 
							  WHERE l.from_dt >= '$start_date' and l.to_dt <= '$end_date' and user_id IN ($team_ids)";
				$leave_array = $this->Common_model->get_query_result_array($leave_sql);
				foreach($leave_array as $tokenArray)
				{
					$currentDataGo = "reject";
					$currLeaveUser = $tokenArray['user_id'];
					$currLeaveFrom = $tokenArray['from_dt'];
					$currLeaveTo = $tokenArray['to_dt'];
					if($tokenArray['status'] == 1){ $currentDataGo = 'accept'; }
					$leaveAr['userid'][$currentDataGo][] = $currLeaveUser;
					$leaveAr['check'][$currentDataGo][$currLeaveUser][] = $currLeaveFrom ."," .$currLeaveTo;
					for($checkD = strtotime($tokenArray['from_dt']); $checkD <= strtotime($tokenArray['to_dt']); $checkD += (86400))
					{								  
						$curLeaveDate = date('Y-m-d', $checkD); 
						$leaveAr['dates'][$currentDataGo][$currLeaveUser][] = $curLeaveDate; 
						$leaveAr['alldates'][$currentDataGo][] = $curLeaveDate;
					} 
				}
				$data['leave_array'][$i]['data'] = $leaveAr;
				
			if($reportType != "weekly" || $reportType == "all"){
			
			if($reportCheck == 'userly' || $this->input->get('excel') == 1){
			$counterUid = 0;
			foreach($team_array as $tokenUser)
			{
				//====================  CALCULATIONS =========================================//
				$current_query = array_filter($schedule_query, function($n) use ($tokenUser, $currDate){
					if($n['user_id'] == $tokenUser  && $n['shdate'] < $currDate){
						return $n;
					}
				});
				
				$w_login = array_filter($current_query, function($n) use ($tokenUser){
					if(!empty($n['login_time_local']) && $n['user_id'] == $tokenUser){
						return $n;
					}
				});
				$w_no_login = array_filter($current_query, function($n) use ($tokenUser){
					if((empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))) && $n['user_id'] == $tokenUser){
						return $n;
					}
				});
				
				$w_non_off = array_filter($current_query, function($n) use ($tokenUser){
					if((strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))) && $n['user_id'] == $tokenUser){
						return $n;
					}
				});

				$w_on_time = array_filter($w_non_off, function($n) use ($tokenUser){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['user_id'] == $tokenUser){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if(($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])) && $n['user_id'] == $tokenUser){
						return $n;
					}
				});	
				
				$w_late_time = array_filter($w_non_off, function($n) use ($tokenUser){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['user_id'] == $tokenUser){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if(($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])) && $n['user_id'] == $tokenUser){
						return $n;
					}
				});
				
				$w_off_time = array_filter($current_query, function($n) use ($tokenUser){
					//if(empty($n['login_time_local']) && $n['user_id'] == $tokenUser){ 
					if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){
						if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }						
					}
				});				
							
				$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
					$n_user = $n['user_id'];
					if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
					} else {
						if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
					}
				});
				
				$w_leave_time = array_filter($current_query, function($n) use ($currDate, $leaveAr){
					$n_user = $n['user_id'];
					if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
						return $n;
					}
				});
											
				$non_off_counter = count($w_non_off);
				$off_counter = count($current_query) - count($w_non_off);
				$others_counter = count($current_query) - (count($w_login) + count($w_no_login));
				
				$data['schedule_team'][$i][$tokenUser]['counters']['date'] = $selected_date;
				$data['schedule_team'][$i][$tokenUser]['counters']['scheduled'] = count($w_non_off);
				$data['schedule_team'][$i][$tokenUser]['counters']['login'] = count($w_login);
				$data['schedule_team'][$i][$tokenUser]['counters']['nologin'] = count($w_no_login);
				$data['schedule_team'][$i][$tokenUser]['counters']['allnologin'] = count($current_query) - count($w_login);
				$data['schedule_team'][$i][$tokenUser]['counters']['others'] = $others_counter;
				$data['schedule_team'][$i][$tokenUser]['counters']['team'] = $total_team_ids;
				$data['schedule_team'][$i][$tokenUser]['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
								
				$data['schedule_team'][$i][$tokenUser]['counters']['total'] = count($current_query);
				$data['schedule_team'][$i][$tokenUser]['counters']['nonoff'] = count($w_non_off);
				$data['schedule_team'][$i][$tokenUser]['counters']['ontime'] = count($w_on_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['latetime'] = count($w_late_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['offtime'] = count($w_off_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['leavetime'] = count($w_leave_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['absenttime'] = count($w_absent_time);
				
				$data['schedule_team'][$i][$tokenUser]['percent']['leavetime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_leave_time) / count($current_query)) * 100)) : '0';
				$data['schedule_team'][$i][$tokenUser]['percent']['absenttime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_absent_time) / count($current_query)) * 100)) : '0';
				$data['schedule_team'][$i][$tokenUser]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
				$data['schedule_team'][$i][$tokenUser]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_absent_time) / count($w_non_off)) * 100)) : '0';
				
				if(count($current_query) > 0){			
					$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = sprintf('%0.2f', ((count($current_query) - count($w_login) / count($current_query)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($current_query)) * 100));
					
					$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($current_query)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($current_query)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($current_query)) * 100));
				} else {			
					$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['others'] = "0";
					
					$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = "0";
				}

				if(count($w_login) < 1)
				{					
					$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = "0";
				}				
				$counterUid++;
			}
			}
			
			
			if($reportCheck == 'daily'  || $reportType == "all"){
			for($j=1;$j<=$total_days;$j++)
			{
				$tokenUser = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
				//====================  CALCULATIONS =========================================//
				$current_query = array_filter($schedule_query, function($n) use ($tokenUser){
					if($n['shdate'] == $tokenUser){
						return $n;
					}
				});				
				
				$w_non_off = array_filter($current_query, function($n) use ($tokenUser){
					if((strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))) && $n['shdate'] == $tokenUser){
						return $n;
					}
				});
				
				$w_login = array_filter($w_non_off, function($n) use ($tokenUser){
					if(!empty($n['login_time_local']) && $n['shdate'] == $tokenUser){
						return $n;
					}
				});
				$w_no_login = array_filter($w_non_off, function($n) use ($tokenUser){
					if((empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))) && $n['shdate'] == $tokenUser){
						return $n;
					}
				});

				$w_on_time = array_filter($w_non_off, function($n) use ($tokenUser){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['shdate'] == $tokenUser){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if(($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])) && $n['shdate'] == $tokenUser){
						return $n;
					}
				});	
				
				$w_late_time = array_filter($w_non_off, function($n) use ($tokenUser){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if((strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")) && $n['shdate'] == $tokenUser){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if(($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])) && $n['shdate'] == $tokenUser){
						return $n;
					}
				});
				
				$w_off_time = array_filter($current_query, function($n) use ($tokenUser,$currDate){
					//if(empty($n['login_time_local']) && $n['shdate'] == $tokenUser){ 
					if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){	
							if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }
					}
				});
				
				$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
					$n_user = $n['user_id'];
					if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
					} else {
						if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
					}
				});
				
				$w_leave_time = array_filter($current_query, function($n) use ($currDate, $leaveAr){
					$n_user = $n['user_id'];
					if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
						return $n;
					}
				});
											
				$non_off_counter = count($w_non_off);
				$off_counter = count($current_query) - count($w_non_off);
				$others_counter = count($current_query) - (count($w_login) + count($w_no_login));
				
				$data['schedule_team'][$i][$tokenUser]['counters']['date'] = $tokenUser;
				$data['schedule_team'][$i][$tokenUser]['counters']['scheduled'] = count($w_non_off);
				$data['schedule_team'][$i][$tokenUser]['counters']['login'] = count($w_login);
				$data['schedule_team'][$i][$tokenUser]['counters']['nologin'] = count($w_no_login);
				$data['schedule_team'][$i][$tokenUser]['counters']['allnologin'] = count($current_query) - count($w_login);
				$data['schedule_team'][$i][$tokenUser]['counters']['others'] = $others_counter;
				$data['schedule_team'][$i][$tokenUser]['counters']['team'] = $total_team_ids;
				$data['schedule_team'][$i][$tokenUser]['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
								
				$data['schedule_team'][$i][$tokenUser]['counters']['total'] = count($current_query);
				$data['schedule_team'][$i][$tokenUser]['counters']['nonoff'] = count($w_non_off);
				$data['schedule_team'][$i][$tokenUser]['counters']['ontime'] = count($w_on_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['latetime'] = count($w_late_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['offtime'] = count($w_off_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['leavetime'] = count($w_leave_time);
				$data['schedule_team'][$i][$tokenUser]['counters']['absenttime'] = count($w_absent_time);
				
				$data['schedule_team'][$i][$tokenUser]['percent']['leavetime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_leave_time) / count($current_query)) * 100)) : '0';
				$data['schedule_team'][$i][$tokenUser]['percent']['absenttime'] = !empty($current_query) ? sprintf('%0.2f', ((count($w_absent_time) / count($current_query)) * 100)) : '0';
				$data['schedule_team'][$i][$tokenUser]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
				$data['schedule_team'][$i][$tokenUser]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_absent_time) / count($w_non_off)) * 100)) : '0';
				
				
				if(count($current_query) > 0){			
					$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = sprintf('%0.2f', ((count($current_query) - count($w_login) / count($current_query)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($current_query)) * 100));
					
					$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($current_query)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($current_query)) * 100));
					$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($current_query)) * 100));
				} else {			
					$data['schedule_team'][$i][$tokenUser]['percent']['login'] =  "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['nologin'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['allnologin'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['others'] = "0";
					
					$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['offtime'] = "0";
				}
				
				if(count($w_login) < 1)
				{					
					$data['schedule_team'][$i][$tokenUser]['percent']['adherence'] = "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['ontime'] =  "0";
					$data['schedule_team'][$i][$tokenUser]['percent']['latetime'] = "0";
				}
			}
			}

			}
			
			if($reportType == "weekly" || $reportType == "all"){
					
				if($i == $selected_month){
					
				//========================= GET WEEKLY CALUCLATIONS =================================//
				$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
				//echo "<pre>".print_r($weekArray, 1) ."</pre>";

				$weekCounter = 0; $weekNo = 0;
				foreach($weekArray as $week)
				{
					$week_start = $week['week_start'];
					$week_end   = $week['week_end'];
					
					$date_start_w = $week_start;
					$date_end_w = $week_end;
					if(date('m', strtotime($week_start)) < date('m', strtotime($start_date))){ $date_start_w = $start_date; }
					if(date('m', strtotime($week_end)) > date('m', strtotime($end_date))){ $date_end_w = $end_date; }
					
					$weekData = array_filter($schedule_query, function($n) use($date_start_w, $date_end_w){
						if($n['shdate'] >= $date_start_w && $n['shdate'] <= $date_end_w){
							return $n;
						}
					});
					
					//====================  CALCULATIONS =========================================//				
				
					$w_non_off = array_filter($weekData, function($n){
						if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
							return $n;
						}
					});
					
					$w_login = array_filter($w_non_off, function($n){
						if(!empty($n['login_time_local'])){
							return $n;
						}
					});
					$w_no_login = array_filter($w_non_off, function($n){
						if(empty($n['login_time_local']) && (strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time'])))){
							return $n;
						}
					});
					
					$w_on_time = array_filter($w_non_off, function($n){
						$scheduled_login = $n['scheduled_login'];
						// for format - 0800
						if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
							$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
							$scheduled_login = $n['shdate'] ." " .$new_time .":00";
						}
						$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
						if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
							return $n;
						}
					});	
					
					$w_late_time = array_filter($w_non_off, function($n){
						$scheduled_login = $n['scheduled_login'];
						// for format - 0800
						if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
							$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
							$scheduled_login = $n['shdate'] ." " .$new_time .":00";
						}
						$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
						if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
							return $n;
						}
					});
					
					$w_off_time = array_filter($weekData, function($n) use ($currDate){
						//if(empty($n['login_time_local'])){ 
						if((!strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && !is_numeric($n['in_time']))) && $n['shdate'] < $currDate){	
							if(trim(strtoupper($n['in_time'])) == 'OFF'){ return $n; }
						}
					});
					
					$w_absent_time = array_filter($w_non_off, function($n) use ($currDate, $leaveAr){
						$n_user = $n['user_id'];
						if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){								
						} else {
							if(empty($n['login_time_local']) && $n['shdate'] < $currDate){ return $n; }			
						}
					});
					
					$w_leave_time = array_filter($weekData, function($n) use ($currDate, $leaveAr){
						$n_user = $n['user_id'];
						if(in_array($n['shdate'], $leaveAr['dates']['accept'][$n_user]) && $n['shdate'] < $currDate){
							return $n;
						}
					});
												
					$non_off_counter = count($w_non_off);
					$off_counter = count($weekData) - count($w_non_off);
					$others_counter = count($weekData) - (count($w_login) + count($w_no_login));
				
					$data['schedule_weekly'][$i][$weekCounter]['counters']['date'] = $date_start_w;
					$data['schedule_weekly'][$i][$weekCounter]['counters']['scheduled'] = count($w_non_off);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['login'] = count($w_login);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['nologin'] = count($w_no_login);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['allnologin'] = count($weekData) - count($w_login);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['others'] = $others_counter;
					$data['schedule_weekly'][$i][$weekCounter]['counters']['team'] = $total_team_ids;
					$data['schedule_weekly'][$i][$weekCounter]['counters']['notscheduled'] = $total_team_ids - count($w_non_off);
									
					$data['schedule_weekly'][$i][$weekCounter]['counters']['total'] = count($weekData);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['nonoff'] = count($w_non_off);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['ontime'] = count($w_on_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['latetime'] = count($w_late_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['offtime'] = count($w_off_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['leavetime'] = count($w_leave_time);
					$data['schedule_weekly'][$i][$weekCounter]['counters']['absenttime'] = count($w_absent_time);
					
					$data['schedule_weekly'][$i][$weekCounter]['percent']['leavetime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_leave_time) / count($weekData)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['percent']['absenttime'] = !empty($weekData) ? sprintf('%0.2f', ((count($w_absent_time) / count($weekData)) * 100)) : '0';					
					$data['schedule_weekly'][$i][$weekCounter]['counters']['adherence'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_on_time) / count($w_non_off)) * 100)) : '0';
					$data['schedule_weekly'][$i][$weekCounter]['counters']['shrinkage'] = !empty($w_non_off) ? sprintf('%0.2f', ((count($w_absent_time) / count($w_non_off)) * 100)) : '0';
					
					if(count($weekData) > 0){			
						$data['schedule_weekly'][$i][$weekCounter]['percent']['login'] =  sprintf('%0.2f', ((count($w_login) / count($w_non_off)) * 100));
						$data['schedule_weekly'][$i][$weekCounter]['percent']['nologin'] = sprintf('%0.2f', ((count($w_no_login) / count($w_non_off)) * 100));
						$data['schedule_weekly'][$i][$weekCounter]['percent']['allnologin'] = sprintf('%0.2f', ((count($weekData) - count($w_login) / count($weekData)) * 100));
						$data['schedule_weekly'][$i][$weekCounter]['percent']['others'] = sprintf('%0.2f', ((count($others_counter) / count($weekData)) * 100));
						
						$data['schedule_weekly'][$i][$weekCounter]['percent']['adherence'] =  sprintf('%0.2f', ((count($w_on_time) / count($w_login)) * 100));
						$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($weekData)) * 100));
						$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($weekData)) * 100));
						$data['schedule_weekly'][$i][$weekCounter]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($weekData)) * 100));
					} else {			
						$data['schedule_weekly'][$i][$weekCounter]['percent']['login'] =  "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['nologin'] = "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['allnologin'] = "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['others'] = "0";
						
						$data['schedule_weekly'][$i][$weekCounter]['percent']['adherence'] = "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] = "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['offtime'] = "0";
					}
					
					if(count($w_login) < 1)
					{					
						$data['schedule_weekly'][$i][$weekCounter]['percent']['adherence'] = "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  "0";
						$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] = "0";
					}
					
					$data['schedule_weekly'][$i][$weekCounter]['data'] = $weekData;
					$data['schedule_weekly'][$i][$weekCounter]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
					$data['schedule_weekly'][$i][$weekCounter]['year'] = $selected_year;
					$data['schedule_weekly'][$i][$weekCounter]['weekInfo'] = $week;
					$data['schedule_weekly'][$i][$weekCounter]['week'] = ++$weekNo;
					$data['schedule_weekly'][$i][$weekCounter]['sdate'] = $date_start_w;
					$data['schedule_weekly'][$i][$weekCounter]['edate'] = $date_end_w;
					$weekCounter++;
					
				}

				}
				
			}
		}
			
			$data['schedule_user']['fusion_id'] = $schedule_query[0]['fusion_id'];
			$data['schedule_user']['name'] = $schedule_query[0]['full_name'];
			$data['schedule_user']['department'] = $schedule_query[0]['department'];
			$data['schedule_user']['role'] = $schedule_query[0]['designation'];
			$data['schedule_user']['l1supervisor'] = $schedule_query[0]['l1_supervisor'];
			
			
			
		}
		//echo "<pre>".print_r($data['schedule_team'], 1) ."</pre>";die();
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
		
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/manager_level.php";
		
		if($this->input->get('excel') == '1'){ $this-> generate_report_management_full($data); }
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	//=========================================================================================================
	// ONLY FOR TESTING PURPOSE
	//==========================================================================================================
		
	public function homeCheck()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$current_user = '15261';		
		$selected_fusion = "FKOL005534";		
		$current_date = date('Y-m-d');
		$current_date = CurrDate();
		if(!empty($this->input->get('select_month')) || !empty($this->input->get('select_year')))
		{
			$selected_month = $this->input->get('select_month');
			$selected_year = $this->input->get('select_year');
			if(!empty($this->input->get('select_fusion'))){
			$selected_fusion = $this->input->get('select_fusion');
			}
			if(empty($selected_month)){ $selected_month = "01"; }
			$current_date = $selected_year.'-'.$selected_month.'-01';
		}		
		//$current_user = $current_user;
		//$selected_fusion = get_user_fusion_id();
		
		
		$data['individualData'] = $individualData = $this->Schedule_adherence_model->get_schedule_adherence_individual($current_date, $selected_fusion);
		$data['selected_month'] = $selected_month = $individualData['selected_month'];
		$data['selected_fusion'] = $selected_fusion = $individualData['selected_fusion'];
		$data['selected_year'] = $selected_year = $individualData['selected_year'];
		$data['schedule_monthly'] = $individualData['schedule_monthly'];
		$data['schedule_weekly'] = $individualData['schedule_weekly'];
		$data['schedule_user'] = $individualData['schedule_user'];
		
		//echo "<pre>".print_r($data, true) ."</pre>";die();
			
		$data['colorsPieArray'] = ["#28eb86", "#ff5252", "#9ea2a3"];
		$data['colorsLoginArray1'] = ["#14c84b", "#d9ffed", "#5cff94"];
		$data['colorsLoginArray2'] = ["#d6d4d4", "#ff4141", "#ffc9c9"];
		$data['colorsLoginArray3'] = ["#18afe9", "#cae8f3", "#b2eaff"];
		$data['colorsLoginArray4'] = ["#ffac2e", "#f5dede", "#ffce83"];
		$data['colorsLineArray'] = ["#efdb4c","#00c961", "#eb0000","#4877d4","#2AC773","#2AD1D1","#64A3AC"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff", "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
								   
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/agent_dashboard_check.php";
		$data["content_js"] = "schedule_adherence/agent_dashboard_check_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	public function agent()
	{
		//$this->output->enable_profiler(TRUE);
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		//$current_user = '9282';
		//$selected_fusion = "FKOL002079";
		//$current_user = '15261';
		//$selected_fusion = "FKOL005534";
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$selected_month = date('m'); 
		$selected_year = date('Y'); 
		if(!empty($this->input->get('select_month')) || !empty($this->input->get('select_year')))
		{
			$selected_month = $this->input->get('select_month');
			$selected_year = $this->input->get('select_year');
			if(!empty($this->input->get('select_fusion'))){
			$selected_fusion = $this->input->get('select_fusion');
			}
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		$data['selected_fusion'] = $selected_fusion;
		
		
		$sql_user = "SELECT s.id, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, d.shname as department, r.name as designation,
		             CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor from signin as s
					 LEFT JOIN signin as sp ON sp.id = s.assigned_to 
		             LEFT JOIN department as d ON d.id = s.dept_id
					 LEFT JOIN role as r ON r.id = s.role_id
					 WHERE s.fusion_id = '$selected_fusion'";
		$query_user = $this->Common_model->get_query_row_array($sql_user);
		$data['user']['fusion_id'] = $query_user['fusion_id'];
		$data['user']['name'] = $query_user['full_name'];
		$data['user']['department'] = $query_user['department'];
		$data['user']['role'] = $query_user['designation'];
		$data['user']['l1supervisor'] = $query_user['l1_supervisor'];
			
		$data['reportType'] = $reportType = $this->uri->segment(3);
		
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			$schedule_sql = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, CONCAT(s.fname, ' ', s.lname) as full_name, s.fusion_id, 
			                     d.shname as department, r.name as designation, CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor,
			                     CASE WHEN sh.is_local = 1
			                     THEN SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time_local, lg.logout_time_local))) 
								 ELSE SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,lg.login_time, lg.logout_time))) END as totaltime,
							     CASE WHEN sh.is_local = 1 THEN min(lg.login_time_local) ELSE min(lg.login_time) END as login_time_local,
								 CASE WHEN in_time LIKE '%:%' THEN CONCAT(sh.shdate, ' ', sh.in_time,':00') ELSE sh.in_time END as scheduled_login,
								 CASE WHEN (sh.in_time > sh.out_time) THEN CONCAT(DATE_ADD(sh.shdate, INTERVAL 1 DAY), ' ', sh.out_time,':00') ELSE CONCAT(sh.shdate, ' ', sh.out_time,':00') 
								 END as scheduled_logout
								 from user_shift_schedule as sh 
								 LEFT JOIN logged_in_details as lg ON lg.user_id = sh.user_id 
								 AND lg.login_time_local >= CONCAT(sh.shdate, ' ', '$time_start') 
								 AND lg.login_time_local <= CONCAT(sh.shdate, ' ', '$time_end')
								 INNER JOIN signin as s ON s.id = sh.user_id
								 INNER JOIN signin as sl ON sl.id = s.assigned_to
								 LEFT JOIN department as d ON d.id = s.dept_id
								 LEFT JOIN role as r ON r.id = s.role_id
								 WHERE 
								 sh.fusion_id = '$selected_fusion' 
								 AND sh.shdate >= '$start_date' 
								 AND sh.shdate <= '$end_date'
								 GROUP BY sh.shdate";
			$schedule_query = $this->Common_model->get_query_result_array($schedule_sql);
			$data['schedule_monthly'][$i]['data'] = $schedule_query;
			$data['schedule_monthly'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['schedule_monthly'][$i]['year'] = $selected_year;
			
		if($reportType != "weekly" || $reportType == "all"){
			
			//====================  CALCULATIONS =========================================//
			
			$w_non_off = array_filter($schedule_query, function($n){
				if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
					return $n;
				}
			});
			$w_on_time = array_filter($w_non_off, function($n){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
					return $n;
				}
			});	
			
			$w_late_time = array_filter($w_non_off, function($n){
				$scheduled_login = $n['scheduled_login'];
				// for format - 0800
				if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
					$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
					$scheduled_login = $n['shdate'] ." " .$new_time .":00";
				}
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
				if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
					return $n;
				}
			});
			
			$w_off_time = array_filter($schedule_query, function($n){
				if(empty($n['login_time_local'])){ 
					return $n;
				}
			});
										
			$non_off_counter = count($w_non_off);
			$off_counter = count($schedule_query) - count($w_non_off);
			
			$data['schedule_monthly'][$i]['counters']['total'] = count($schedule_query);
			$data['schedule_monthly'][$i]['counters']['scheduled'] = count($schedule_query);
			$data['schedule_monthly'][$i]['counters']['nonoff'] = count($w_non_off);
			$data['schedule_monthly'][$i]['counters']['ontime'] = count($w_on_time);
			$data['schedule_monthly'][$i]['counters']['latetime'] = count($w_late_time);
			$data['schedule_monthly'][$i]['counters']['offtime'] = count($w_off_time);
			$data['schedule_monthly'][$i]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($schedule_query)) * 100));
			$data['schedule_monthly'][$i]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($schedule_query)) * 100));
			$data['schedule_monthly'][$i]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($schedule_query)) * 100));
			
		}

		
		if($reportType == "weekly"  || $reportType == "all"){
				
			if($i == $selected_month){
				
			//========================= GET WEEKLY CALUCLATIONS =================================//
			$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
			//echo "<pre>".print_r($weekArray, 1) ."</pre>";

			$weekCounter = 0; $weekNo = 0;
			foreach($weekArray as $week)
			{
				$week_start = $week['week_start'];
				$week_end   = $week['week_end'];
				
				$date_start_w = $week_start;
				$date_end_w = $week_end;
				if(date('m', strtotime($week_start)) < date('m', strtotime($start_date))){ $date_start_w = $start_date; }
				if(date('m', strtotime($week_end)) > date('m', strtotime($end_date))){ $date_end_w = $end_date; }
				
				$weekData = array_filter($schedule_query, function($n) use($week_start, $week_end){
					if($n['shdate'] >= $week_start && $n['shdate'] <= $week_end){
						return $n;
					}
				});
				
				//====================  CALCULATIONS =========================================//			
				$w_non_off = array_filter($weekData, function($n){
					if(strpos($n['in_time'], ":") || (strlen($n['in_time']) == 4 && is_numeric($n['in_time']))){
						return $n;
					}
				});
				
				$w_on_time = array_filter($w_non_off, function($n){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if($n['login_time_local'] <= $adherence_time && !empty($n['login_time_local'])){
						return $n;
					}
				});	
				
				$w_late_time = array_filter($w_non_off, function($n){
					$scheduled_login = $n['scheduled_login'];
					// for format - 0800
					if(strlen($n['in_time']) == 4 && is_numeric($n['in_time']) && !strpos($n['in_time'], ":")){
						$new_time = substr($n['in_time'],0,2).":".substr($n['in_time'],2,3);
						$scheduled_login = $n['shdate'] ." " .$new_time .":00";
					}
					$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($scheduled_login)));
					if($n['login_time_local'] > $adherence_time && !empty($n['login_time_local'])){
						return $n;
					}
				});
				
				$w_off_time = array_filter($weekData, function($n){
					if(empty($n['login_time_local'])){ 
						return $n;
					}
				});
											
				$non_off_counter = count($w_non_off);
				$off_counter = count($weekData) - count($w_non_off);
				
				$data['schedule_weekly'][$i][$weekCounter]['counters']['total'] = count($weekData);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['scheduled'] = count($weekData);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['nonoff'] = count($w_non_off);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['ontime'] = count($w_on_time);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['latetime'] = count($w_late_time);
				$data['schedule_weekly'][$i][$weekCounter]['counters']['offtime'] = count($w_off_time);
				$data['schedule_weekly'][$i][$weekCounter]['percent']['ontime'] =  sprintf('%0.2f', ((count($w_on_time) / count($weekData)) * 100));
				$data['schedule_weekly'][$i][$weekCounter]['percent']['latetime'] = sprintf('%0.2f', ((count($w_late_time) / count($weekData)) * 100));
				$data['schedule_weekly'][$i][$weekCounter]['percent']['offtime'] = sprintf('%0.2f', ((count($w_off_time) / count($weekData)) * 100));
				$data['schedule_weekly'][$i][$weekCounter]['data'] = $weekData;
				$data['schedule_weekly'][$i][$weekCounter]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
				$data['schedule_weekly'][$i][$weekCounter]['year'] = $selected_year;
				$data['schedule_weekly'][$i][$weekCounter]['weekInfo'] = $week;
				$data['schedule_weekly'][$i][$weekCounter]['week'] = ++$weekNo;
				$data['schedule_weekly'][$i][$weekCounter]['sdate'] = $date_start_w;
				$data['schedule_weekly'][$i][$weekCounter]['edate'] = $date_end_w;
				$weekCounter++;
				
			}

			}
			
		}
			
			$data['schedule_user']['fusion_id'] = $schedule_query[0]['fusion_id'];
			$data['schedule_user']['name'] = $schedule_query[0]['full_name'];
			$data['schedule_user']['department'] = $schedule_query[0]['department'];
			$data['schedule_user']['role'] = $schedule_query[0]['designation'];
			$data['schedule_user']['l1supervisor'] = $schedule_query[0]['l1_supervisor'];
			
			
			
		}
		//echo "<pre>".print_r($data['schedule_weekly'], 1) ."</pre>";die();
		
		$data['colorsPieArray'] = ["#00c961", "#eb0000","#4877d4"];
		$data['colorsLineArray'] = ["#efdb4c"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#1BC720", "#FF4412","#0AA6D8"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
		
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/agent_level.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	//=========================================================================================================
	// EXCEL REPORT
	//==========================================================================================================
	
	public function generate_report_team($data)
	{
		$selected_date = $data['selected_date'];
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$selected_fusion = $data['selected_fusion'];
		
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$worksheet_1 = "Monthly Adherence";
		$worksheet_2 = "Weekly Adherence";
		$worksheet_2 = "Team Adherence";
		
		//============ WORKSHEET 1 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Day Adherence";
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Schedule");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Login");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Status");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$title = "Day Adherence - Team - ".date('d M Y', strtotime($selected_date));
		
		// Merge Header
		$this->objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('D')->setWidth(45);
		$objWorksheet->getColumnDimension('E')->setWidth(30);
		$objWorksheet->getColumnDimension('F')->setWidth(40);
		$objWorksheet->getColumnDimension('G')->setWidth(25);
		$objWorksheet->getColumnDimension('H')->setWidth(25);
				
		// User Data
		$counter = 0;
		foreach($data['schedule_data'] as $token)
		{			
			$user_id = $token['user_id'];
			$current_date = $token['shdate'];
			$login_time_local = "";
			$schedule_login = "";
			$login_status = "N/A";
			$na_status = "-";			 
			$schedule_login = $token['in_time'];
			$login_status = $schedule_login;
			
			if(strpos($token['in_time'], ':') || (strlen($token['in_time']) == 4 && is_numeric($token['in_time'])))
			{
				$schedule_login = $token['scheduled_login'];
				$login_time_local = $token['login_time_local'];
				if(strlen($token['in_time']) == 4 && is_numeric($token['in_time']) && !strpos($token['in_time'], ":")){
					$new_time = substr($token['in_time'],0,2).":".substr($token['in_time'],2,3);
					$schedule_login = $token['shdate'] ." " .$new_time .":00";
				}
				
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($schedule_login)));
				if($login_time_local <= $adherence_time && !empty($login_time_local)){
					$login_status = "On Time";
				}
				if($login_time_local > $adherence_time && !empty($login_time_local)){
					$login_status = "Late Login";
				}
				if(empty($login_time_local)){ $login_status = "Absent"; }
				if(in_array($token['shdate'], $data['leave_array'][round($selected_month)]['data']['dates']['accept'][$user_id])){
					$login_status = "Leave";
				}
			}			
			if($current_date > $data['todayDate']){ $login_status = "-"; }
			
			$r=0; $c++;		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('d M Y', strtotime($token['shdate'])));			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['department']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['designation']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $schedule_login);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $login_time_local);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $login_status);
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		
		//============ WORKSHEET 2 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Monthly Adherence";
		$this->objPHPExcel->createSheet(1);
		$this->objPHPExcel->setActiveSheetIndex(1);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(1);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Year");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Month");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Team Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Total Team");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$title = "Monthly Schedule Adherence - Team - Year ".$selected_year;
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		$objWorksheet->getColumnDimension('E')->setWidth(30);
		
		// Monthly Data
		$counter = 0; $start_loop = 1; $end_loop = 12;
		for($i=$start_loop; $i<=$end_loop; $i++)
		{			
			$r=0; $c++;
			$monthlyData = $data['schedule_monthly'][$i];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['schedule_monthly'][$i]['year']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['schedule_monthly'][$i]['month']);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['tl']['name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['tl']['role']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['schedule_team']['counters']['team']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['leave']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['absent']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['shrinkage']);
		
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		$excel_Type = "Monthly_Adherence_Report";
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
		
	}
	
	
	public function generate_report_team_full($data)
	{
		$selected_date = $data['selected_date'];
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$selected_fusion = $data['selected_fusion'];
		
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$worksheet_1 = "Monthly Adherence";
		$worksheet_2 = "Weekly Adherence";
		$worksheet_2 = "Team Adherence";
		
		//============ WORKSHEET 1 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Monthly Adherence";
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$startdateForm = $selected_year ."-".$selected_month."-01";
		$title = "Month - ".date('F Y', strtotime($startdateForm));
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('C')->setWidth(45);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		$objWorksheet->getColumnDimension('E')->setWidth(40);
		$objWorksheet->getColumnDimension('F')->setWidth(45);
		
		// Monthly Data
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		//$start_loop = 1; $end_loop = 12;
		
		$counter = 0; 
		for($i=$start_loop; $i<=$end_loop; $i++)
		{	
			$counter = 0;		
			foreach($data['team_users'] as $tokenu)
			{				
			$r=0; $c++;	
			$tokenUid = $tokenu['id'];
			$monthlyData = $data['schedule_team'][$i][$tokenUid];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['department']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['designation']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['l1_supervisor']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['leavetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['absenttime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['shrinkage']);
			
			}
		
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		
		//============ WORKSHEET 2 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Daywise Adherence";
		$this->objPHPExcel->createSheet(1);
		$this->objPHPExcel->setActiveSheetIndex(1);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(1);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Day");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Total Team");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$startdateForm = $selected_year ."-".$selected_month."-01";
		$title = "Month - ".date('F Y', strtotime($startdateForm));
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('B')->setWidth(20);
		$objWorksheet->getColumnDimension('C')->setWidth(25);
		
		// Monthly Data
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		//$start_loop = 1; $end_loop = 12;
		
		$counter = 0; 
		for($i=$start_loop; $i<=$end_loop; $i++)
		{	
			$counter = 0;
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);			
			for($j=1;$j<=$total_days;$j++)
			{
			$r=0; $c++;
			$currDate = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
			$currDay = date('l', strtotime($currDate));
			$monthlyData = $data['schedule_team'][$i][$currDate];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $currDate);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $currDay);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['team']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['leavetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['absenttime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['shrinkage']);
			
			}
		
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		//============ WORKSHEET 3 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Weekly Adherence";
		$this->objPHPExcel->createSheet(2);
		$this->objPHPExcel->setActiveSheetIndex(2);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(2);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Month");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Week");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Start Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "End Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Total Team");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$title = "Month - ".date('F Y', strtotime("2020-".$selected_month."-01"));
		
		// Merge Header
		$this->objPHPExcel->getActiveSheet()->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
				
		// Weekly Data
		$counter = 0;
		$weekArray = $this->getWeekMonthly(sprintf('%02d', $selected_month), $selected_year);
		$weekCounter = 0; $weekNo = 0;
		foreach($weekArray as $week)
		{			
			$r=0; $c++; $currentLoop = round($selected_month);
			$weekData = $data['schedule_weekly'][$currentLoop][$weekCounter];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('F', strtotime($weekData['sdate'])));			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Week " .$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['sdate']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['edate']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['team']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['leavetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['absenttime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['shrinkage']);
			$weekCounter++;
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		$excel_Type = "Monthly_Adherence_Report";
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
		
	}
	
	
	//=========================================================================================================
	// EXCEL REPORT
	//==========================================================================================================
	
	public function generate_report_management($data)
	{
		$selected_date = $data['selected_date'];
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$selected_fusion = $data['selected_fusion'];
		
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$worksheet_1 = "Monthly Adherence";
		$worksheet_2 = "Weekly Adherence";
		$worksheet_2 = "Team Adherence";
		
		//============ WORKSHEET 1 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Day Adherence";
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Schedule");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Login");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Status");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$title = "Day Adherence - ".date('d M Y', strtotime($selected_date));
		
		// Merge Header
		$this->objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('D')->setWidth(45);
		$objWorksheet->getColumnDimension('E')->setWidth(30);
		$objWorksheet->getColumnDimension('F')->setWidth(40);
		$objWorksheet->getColumnDimension('G')->setWidth(25);
		$objWorksheet->getColumnDimension('H')->setWidth(25);
				
		// User Data
		$counter = 0;
		foreach($data['schedule_data'] as $token)
		{			
			$user_id = $token['user_id'];
			$current_date = $token['shdate'];
			$login_time_local = "";
			$schedule_login = "";
			$login_status = "N/A";
			$na_status = "-";			 
			$schedule_login = $token['in_time'];
			$login_status = $schedule_login;
			
			if(strpos($token['in_time'], ':') || (strlen($token['in_time']) == 4 && is_numeric($token['in_time'])))
			{
				$schedule_login = $token['scheduled_login'];
				$login_time_local = $token['login_time_local'];
				if(strlen($token['in_time']) == 4 && is_numeric($token['in_time']) && !strpos($token['in_time'], ":")){
					$new_time = substr($token['in_time'],0,2).":".substr($token['in_time'],2,3);
					$schedule_login = $token['shdate'] ." " .$new_time .":00";
				}
				
				$adherence_time = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime($schedule_login)));
				if($login_time_local <= $adherence_time && !empty($login_time_local)){
					$login_status = "On Time";
				}
				if($login_time_local > $adherence_time && !empty($login_time_local)){
					$login_status = "Late Login";
				}
				if(empty($login_time_local)){ $login_status = "Absent"; }
				if(in_array($token['shdate'], $data['leave_array'][round($selected_month)]['data']['dates']['accept'][$user_id])){
					$login_status = "Leave";
				}
			}			
			if($current_date > $data['todayDate']){ $login_status = "-"; }
			
			$r=0; $c++;		
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('d M Y', strtotime($token['shdate'])));			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['department']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['designation']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $schedule_login);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $login_time_local);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $login_status);
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		
		//============ WORKSHEET 2 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Monthly Adherence";
		$this->objPHPExcel->createSheet(1);
		$this->objPHPExcel->setActiveSheetIndex(1);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(1);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Year");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Month");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Total Team");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$title = "Monthly - Year ".$selected_year;
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		$objWorksheet->getColumnDimension('E')->setWidth(30);
		
		// Monthly Data
		$counter = 0; $start_loop = 1; $end_loop = 12;
		for($i=$start_loop; $i<=$end_loop; $i++)
		{			
			$r=0; $c++;
			$monthlyData = $data['schedule_monthly'][$i];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['schedule_monthly'][$i]['year']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['schedule_monthly'][$i]['month']);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['searched']['office']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['searched']['dept']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['searched']['process']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $data['schedule_team']['counters']['team']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['leavetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['absenttime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['shrinkage']);
		
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
		
	}
	
	
	public function generate_report_management_full($data)
	{
		$selected_date = $data['selected_date'];
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$selected_fusion = $data['selected_fusion'];
		
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$worksheet_1 = "Monthly Adherence";
		$worksheet_2 = "Weekly Adherence";
		$worksheet_2 = "Team Adherence";
		
		//============ WORKSHEET 1 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Monthly Adherence";
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$startdateForm = $selected_year ."-".$selected_month."-01";
		$title = "Month - ".date('F Y', strtotime($startdateForm));
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('C')->setWidth(45);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		$objWorksheet->getColumnDimension('E')->setWidth(40);
		$objWorksheet->getColumnDimension('F')->setWidth(45);
		
		// Monthly Data
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		//$start_loop = 1; $end_loop = 12;
		
		$counter = 0; 
		for($i=$start_loop; $i<=$end_loop; $i++)
		{	
			$counter = 0;		
			foreach($data['team_users'] as $tokenu)
			{				
			$r=0; $c++;	
			$tokenUid = $tokenu['id'];
			$monthlyData = $data['schedule_team'][$i][$tokenUid];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['department']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['designation']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenu['l1_supervisor']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['leavetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['absenttime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['shrinkage']);
			
			}
		
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		
		//============ WORKSHEET 2 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Daywise Adherence";
		$this->objPHPExcel->createSheet(1);
		$this->objPHPExcel->setActiveSheetIndex(1);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(1);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Day");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Total Team");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$startdateForm = $selected_year ."-".$selected_month."-01";
		$title = "Month - ".date('F Y', strtotime($startdateForm));
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('B')->setWidth(20);
		$objWorksheet->getColumnDimension('C')->setWidth(25);
		
		// Monthly Data
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		//$start_loop = 1; $end_loop = 12;
		
		$counter = 0; 
		for($i=$start_loop; $i<=$end_loop; $i++)
		{	
			$counter = 0;
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);			
			for($j=1;$j<=$total_days;$j++)
			{
			$r=0; $c++;
			$currDate = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
			$currDay = date('l', strtotime($currDate));
			$monthlyData = $data['schedule_team'][$i][$currDate];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $currDate);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $currDay);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['team']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['leavetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['absenttime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $monthlyData['counters']['shrinkage']);
			
			}
		
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		//============ WORKSHEET 3 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Weekly Adherence";
		$this->objPHPExcel->createSheet(2);
		$this->objPHPExcel->setActiveSheetIndex(2);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(2);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Month");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Week");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Start Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "End Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Total Team");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Scheduled");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "On Time");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Late");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Off");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Leave");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Absent");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Adherence (%)");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Shrinkage (%)");
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE	
		$title = "Month - ".date('F Y', strtotime("2020-".$selected_month."-01"));
		
		// Merge Header
		$this->objPHPExcel->getActiveSheet()->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
				
		// Weekly Data
		$counter = 0;
		$weekArray = $this->getWeekMonthly(sprintf('%02d', $selected_month), $selected_year);
		$weekCounter = 0; $weekNo = 0;
		foreach($weekArray as $week)
		{			
			$r=0; $c++; $currentLoop = round($selected_month);
			$weekData = $data['schedule_weekly'][$currentLoop][$weekCounter];
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('F', strtotime($weekData['sdate'])));			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Week " .$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['sdate']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['edate']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['team']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['scheduled']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['ontime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['latetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['offtime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['leavetime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['absenttime']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['adherence']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $weekData['counters']['shrinkage']);
			$weekCounter++;
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		$excel_Type = "Monthly_Adherence_Report";
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
		
	}
	
	public function team_overview_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$data['todayDate'] = $currDate = date("Y-m-d", strtotime("-1 day", strtotime(CurrDate())));
		$selected_date = date('m/d/Y', strtotime($currDate));		
		$data['selected_date'] = $selected_date;
		$data['selected_fusion'] = $selected_fusion;
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/team_overview_reports.php";
		$this->load->view('dashboard',$data);
	}
	
	
	public function team_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$selected_month = date('m'); 
		$selected_year = date('Y');		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		$data['selected_fusion'] = $selected_fusion;
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/team_level_reports.php";
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function management_overview_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$data['todayDate'] = $currDate = date("Y-m-d", strtotime("-1 day", strtotime(CurrDate())));
		$selected_office = $user_office_id;
		$selected_month = date('m');
		$selected_year = date('Y');
		$selected_date = date('m/d/Y', strtotime($currDate));
		$data['selected_date'] = date('Y-m-d', strtotime($selected_date));
		
		$data['selected_office'] = $selected_office;
		$data['selected_process'] = $selected_process;
		$data['selected_department'] = $selected_department;
		
		// OFFICE & PROCESS LIST
		if(get_global_access() == 1 || get_dept_folder()=="wfm"){
			$data['location_list'] = $this->Common_model->get_office_location_list();			
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['client_list'] = $this->Common_model->get_client_list();
		$data['process_list'] = $this->Common_model->get_process_for_assign();
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/manager_overview_reports.php";
		$this->load->view('dashboard',$data);
	
	}
	
	
	public function management_reports()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$selected_fusion = get_user_fusion_id();
		
		// INITITALIZE DATA
		$data['todayDate'] = $currDate = CurrDate();
		$selected_office = $user_office_id;
		$selected_month = date('m');
		$selected_year = date('Y');
		$selected_date = date('m/d/Y');
		
		$data['selected_office'] = $selected_office;
		$data['selected_process'] = $selected_process;
		$data['selected_department'] = $selected_department;
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		
		// OFFICE & PROCESS LIST
		if(get_global_access() == 1 || get_dept_folder()=="wfm"){
			$data['location_list'] = $this->Common_model->get_office_location_list();			
		} else {
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['client_list'] = $this->Common_model->get_client_list();
		$data['process_list'] = $this->Common_model->get_process_for_assign();
		$data['department_list'] = $this->Common_model->get_department_list();
		
		$data["aside_template"] = "schedule_adherence/aside.php";
		$data["content_template"] = "schedule_adherence/manager_level_reports.php";
		$this->load->view('dashboard',$data);
		
	}
	
	
	
	//=========================================================================================================
	// REQUIRED DEPENDENT FUNCTIONS
	//==========================================================================================================	
	
	public function saveImageOnServer()
	{
		$imgData = $_POST['filData'];
		$imgName = $_POST['fileName'];
		$img = str_replace('data:image/png;base64,', '', $imgData);
		$img = str_replace(' ', '+', $img);
		$fileData = base64_decode($img);		
		if(!empty($imgName))
		{
			$fileName = 'uploads/report_graph/schedule/' .$imgName;
			file_put_contents($fileName, $fileData);
		}
	}
	
	
	private function getWeekMonthly_old($month, $year)
	{
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$startDate = $year."-".$month."-01";
		$endDate   = $year.'-'.$month.'-'.$totalDays;
		$startWeek = date("W", strtotime($startDate));
		$endWeek = date("W", strtotime($endDate));
		$counter = 0; $weekArray = array();
		for($i=$startWeek; $i<=$endWeek; $i++)
		{
			$weekInfo = $this->getWeekInfo($i, $year);
			$weekArray[$counter] = $weekInfo;
			$weekArray[$counter]['week'] = sprintf('%02d',$i);
			$counter++;
		}		
		return $weekArray;
	}
	
	private function getWeekMonthly($month, $year)
	{
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$startDate = $year."-".$month."-01";
		$endDate   = $year.'-'.$month.'-'.$totalDays;
		$startWeek = date("W", strtotime($startDate));
		$endWeek = date("W", strtotime($endDate));
		$counter = 0; $weekArray = array();
		$counterStartWeek = $startWeek;
		if($startWeek > $endWeek){ $counterStartWeek = 0; }
		for($i=$counterStartWeek; $i<=$endWeek; $i++)
		{
			if($i == 0){
				$yearCheck = $year - 1;
				$weekInfo = $this->getWeekInfo($startWeek, $yearCheck);
				$weekArray[$counter] = $weekInfo;
				$weekArray[$counter]['week'] = sprintf('%02d',$startWeek);
			} else {
				$weekInfo = $this->getWeekInfo($i, $year);
				$weekArray[$counter] = $weekInfo;
				$weekArray[$counter]['week'] = sprintf('%02d',$i);
			}		
			$counter++;
		}		
		return $weekArray;
	}
	
	private function getWeekInfo($week, $year)
	{
	  $dto = new DateTime();
	  $ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
	  $ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
	  return $ret;
	}
	
	
	 

}