<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dfr_dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//$this->load->helper(array('form', 'url','dfr_functions'));
		$this->load->model('Common_model');
		$this->load->model('Dfr_model');
		$this->load->model('Candidate_model');
		$this->load->model('Profile_model');
		$this->load->model('user_model');
				
	}
	
	
	public function index()
	{
		if(check_logged_in())
		{
			if(get_login_type() == "client") redirect(base_url().'client',"refresh");
			
			//----- STORE REQUIRED INFO
			$current_user      = get_user_id();
			$user_office_id    = get_user_office_id();
			$user_oth_office   = get_user_oth_office();
			$is_global_access  = get_global_access();
			$user_site_id      = get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"]      = get_role_dir();
			$data['current_user']     = get_user_id();
			
			
			// MONTH YEAR SELECTION
			$start_date      = $this->input->get('start_date');
			$end_date        = $this->input->get('end_date');
			$select_office   = $this->input->get('select_office');
			
			if($start_date == ""){ $start_date = date('Y-m-01'); }
			if($end_date == ""){ $end_date = date('Y-m-d'); }
			
			
			//----- SELECT LOCATION
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{		
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['start_date']       = $start_date;
			$data['end_date']         = $end_date;
            if(empty($select_office)){ $select_office = $user_office_id; }
			$data['location']         = $select_office;
			
			//-- NO OF DAYS
			$date1     =  date_create($start_date);
			$date2     =  date_create($end_date);
			$noofdays  =  date_diff($date1,$date2);
			
			

			//----- TOTAL APPLICATION
			/*
			$sql_total = "SELECT count(*) as value from dfr_candidate_details as d
			LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
			WHERE r.rlocation = '$select_office' AND DATE(d.added_date) >= '$start_date' AND DATE(d.added_date) <= '$end_date'";
			*/
			
			$sql_total = "SELECT count(*) as value from dfr_candidate_details as d
			LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
			WHERE r.rlocation = '$select_office' AND d.added_date >= '$start_date' AND DATE(d.added_date) <= '$end_date'";
			
			//echo "xxxx: ". $sql_total;
			
			$data['total_application'] = $this->Common_model->get_single_value($sql_total);
			
			//----- INTERVIEW COMPLETED
			$sql_interview = 'SELECT COUNT(*) AS value FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%Y-%m-%d") >= "'.$start_date.'" AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%Y-%m-%d") <= "'.$end_date.'"  AND interview_type="1" AND interview_site="'.$select_office.'"';
			
			//echo "xxxx: ". $sql_interview . "\r\n\r\n";
			
			$data['interview_completed'] = $this->Common_model->get_single_value($sql_interview);
			
			//----- SHORTLISTED APPLICATION
			$sql_shortlisted = 'SELECT dfr_interview_schedules.c_id FROM dfr_interview_schedules LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL","CS","E") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%Y-%m-%d") >= "'.$start_date.'" AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%Y-%m-%d") <= "'.$end_date.'"  AND 
			interview_site="'.$select_office.'"  GROUP BY dfr_interview_schedules.c_id';
			$data['shortlisted_application'] = $this->db->query($sql_shortlisted)->num_rows();
			
			//----- OFFERED APPLICATION
			$sql_offer = "SELECT count(*) as value from dfr_candidate_details as d
			LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
			WHERE r.rlocation = '$select_office' AND DATE(d.added_date) >= '$start_date' AND DATE(d.added_date) <= '$end_date' AND d.candidate_status IN ('CS','E')";
			$data['offered_application'] = $this->Common_model->get_single_value($sql_offer);

			//----- HIRED APPLICATION
			$sql_hired = "SELECT count(*) as value from dfr_candidate_details as d
			LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
			WHERE r.rlocation = '$select_office' AND DATE(d.added_date) >= '$start_date' AND DATE(d.added_date) <= '$end_date' AND d.candidate_status = 'E'";
			$data['hired_application'] = $this->Common_model->get_single_value($sql_hired);
			
			
			
			//----- COST PER HIRE
			$sql_cost = "SELECT avg(gross_pay) as value from dfr_candidate_details as d
			LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
			WHERE r.rlocation = '$select_office' AND DATE(d.added_date) >= '$start_date' AND DATE(d.added_date) <= '$end_date'";
			$data['cost_per_hire'] = number_format(($this->Common_model->get_single_value($sql_cost)), 2);
			
			//----- OPENED POSITIONS
			$sql_opened = "SELECT sum(req_no_position) as value from dfr_requisition as r
			WHERE r.location = '$select_office' AND DATE(r.raised_date) >= '$start_date' AND DATE(r.due_date) <= '$end_date'";
			$data['opened_position'] = $this->Common_model->get_single_value($sql_opened);
			
			
			//----- APPS PER HIRED
			$data['apps_per_hire'] = "0";
			if($data['total_application'] > 0){
			$data['apps_per_hire'] = number_format(($data['hired_application']/$data['total_application']),2);
			}
			
			//----- DAYS TO HIRE
			$data['days_to_hire'] = round($data['hired_application']/$noofdays->format("%a"),2);
			
			//----- DAYS IN MKT
			//$sql_days = "SELECT floor(avg(datediff(date(due_date), date(raised_date)))) as value from dfr_requisition as r
			//WHERE r.location = '$select_office' AND DATE(r.raised_date) >= '$start_date' AND DATE(r.due_date) <= '$end_date'";
			//$data['days_in_mkt'] = $this->Common_model->get_single_value($sql_days);
			
			
			//----- DAYS IN MKT
			$sql_days = "SELECT floor(datediff(max(due_date),min(raised_date))) as value from dfr_requisition as r
			WHERE r.location = '$select_office' AND DATE(r.raised_date) >= '$start_date' AND DATE(r.due_date) <= '$end_date'";
			$data['days_in_mkt'] = $this->Common_model->get_single_value($sql_days);
			
			
			//----- TOTAL COST
			$sql_tcost = "SELECT sum(gross_pay) as value from dfr_candidate_details as d
			LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
			WHERE r.rlocation = '$select_office' AND DATE(d.added_date) >= '$start_date' AND DATE(d.added_date) <= '$end_date'";
			$data['total_cost'] = $this->Common_model->get_single_value($sql_tcost);
			
			
			// PAST 12 MONTHS RECORDS
			for($i=1; $i<=12;$i++)
			{
				$date_start = date("Y-m-01", strtotime(date('Y-m-01')."-$i months"));
				$date_end   = date("Y-m-31", strtotime($date_start));
				$month_data = "SELECT count(*) as value from dfr_candidate_details as d
				LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
				WHERE r.rlocation = '$select_office' AND DATE(d.added_date) >= '$date_start' AND DATE(d.added_date) <= '$date_end' AND d.candidate_status = 'E'";
				$month_hired = $this->Common_model->get_single_value($month_data);
				
				$dayshire = "SELECT floor(datediff(max(due_date), min(raised_date))) as value from dfr_requisition as r
			    WHERE r.location = '$select_office' AND DATE(r.raised_date) >= '$date_start' AND DATE(r.due_date) <= '$date_end'";
				$daystrue_hired = $this->Common_model->get_single_value($dayshire);
				
				$data['monthly_data'][$i]['month'] = date('F',strtotime($date_start));
				$data['monthly_data'][$i]['year'] = date('Y',strtotime($date_start));
				$data['monthly_data'][$i]['hired'] = $month_hired;
				$data['monthly_data'][$i]['hireddays'] = $daystrue_hired;
				
			}
			
			// APPLICATION SOURCES
			$sqlapp = "SELECT hiring_source, count(*) as count_hire from dfr_candidate_details as d
			LEFT JOIN (SELECT id as rid, location as rlocation from dfr_requisition) as r ON r.rid = d.r_id
			WHERE r.rlocation = '$select_office' AND DATE(d.added_date) >= '$start_date' AND DATE(d.added_date) <= '$end_date' AND d.candidate_status = 'E' GROUP BY hiring_source";
			$queryapp = $data['hiring_info'] = $this->Common_model->get_query_result_array($sqlapp);
			
			
			$data['color_pie'] = array('#4ddbff','#ff8533','#ffad33','#1a8cff','#39ac39'); 
			
			
			$data['monthly_max_data'] = max(array_map('floatval',array_column($data['monthly_data'], "hired")));
			$data['monthly_max_days'] = max(array_map('floatval',array_column($data['monthly_data'], "hireddays")));
			//echo "<pre>".print_r($data, true)."</pre>"; die();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/dfr_dashboard_view.php";
		
			$this->load->view('dashboard',$data);
		
		
		}
		
	}
	
	
	public function loginhour()
	{
		if(check_logged_in())
		{
			
			$getdate = $this->input->get('d');
			echo "<b>DATE : " .$getdate ."</b><br/><hr/><br/>";
			
			if($getdate != ""){
			for($i=0;$i<24;$i++){
				
				$start_hour = sprintf('%02d',$i).":00:00";
				$end_hour   = sprintf('%02d',$i).":59:59";
				
				$start_dhour = $getdate ." " .sprintf('%02d',$i).":00:00";
				$end_dhour   = $getdate ." " .sprintf('%02d',$i).":59:59";
				
				$sqllogin = "SELECT count(*) as countlogin, t.login, t.logout, GROUP_CONCAT(t.user_id) as users from 
				(SELECT user_id, max(login_time) as login, max(logout_time) as logout 
				from logged_in_details WHERE login_time <= '$end_dhour' GROUP BY user_id) as t 
				WHERE t.login >= '$start_dhour' OR t.logout >= '$start_dhour'";
				$querylogin = $this->Common_model->get_query_row_array($sqllogin);
				
				$data['hourdata']['record'][$i] = $querylogin;
				$data['hourdata']['count'][$i] = $querylogin['countlogin'];
				
				
				echo "<b>Slot " .sprintf('%02d',$i) ."</b> --> " .substr($start_hour,0,5) ." - " .substr($end_hour,0,5) ." == "; 
				echo "<b>" .$querylogin['countlogin'] ."</b>"; 
				echo "&nbsp;&nbsp;&nbsp; {".$querylogin['users'] ."}";
				echo "<br/><br/>";
			
			}
			}
			
			//echo "<pre>".print_r($data, true)."</pre>";
		}
	}
	
	
	
	public function login_roaster()
	{
		if(check_logged_in())
		{
			
			
		// --- INITIALIZE CSS
		echo "<title>FEMS Test Mode</title>";
		echo "<link rel='stylesheet' href='https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'>";
		echo "<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css'>";
		echo "<style>body{ font-size:12px!important; } table th, table td{ font-size:12px!important; }</style>";
		$type = $this->input->get('type');
			
			
			// ----------- START CODE -----------------------------------------------------------------------------------
			
			

			$start_date = $this->input->get('start');
			$end_date = $this->input->get('end');
			$department = $this->input->get('d');
			$sl = 0;
			
			echo "<b>DATE : " .$start_date ."</b><br/><hr/><br/>";
			
			$sqlusers = "SELECT id as user_id, fusion_id, concat(fname, ' ', lname) as fullname, office_id from signin s WHERE dept_id = '$department'";
			$query_users = $this->Common_model->get_query_result_array($sqlusers);
			
			$date1 = new DateTime($start_date);
			$date2 = new DateTime($end_date);
			$days  = $date2->diff($date1)->format('%a');
			
			echo "<table id='datasheet' class='display' style='width:100%'><thead><tr>";
			echo "<th>#</th>
				  <th>Fusion ID</th>
			      <th style='text-align:left'>Name</th>
			      <th>Site</th>";
				$hdate = new DateTime($start_date);
				for($i=1; $i<=$days; $i++){
				   echo "<th>Roastered Login Time</th>";
				   echo "<th>Actual Login Time</th>";
				   echo "<th>".$hdate->format('d-M-Y')."</th>";
				   $hdate->modify('+1 day');
				}
			echo "</tr></thead><tbody>";			
			
			
			foreach($query_users as $token)
			{
				++$sl;
				echo $getit = <<<STARTIT
				<tr>
					<td>{$sl}</td>
					<td>{$token['fusion_id']}</td>
					<td>{$token['fullname']}</td>
					<td>{$token['office_id']}</td>
STARTIT;
					$bdate = new DateTime($start_date);	
					for($i=1; $i<=$days; $i++){
					   $roast = $this->get_schedule_time($token['user_id'], $bdate->format('Y-m-d'));
					   echo "<td>".$roast['shdate'] ." " .$roast['in_time'] ."</td>";
					   echo "<td>".$roast['actual_login']."</td>";
					   echo "<td>".$i."</td>";
					   $bdate->modify('+1 day');
					}
				echo "</tr>";
			
			}
			
			echo "</tbody></table>";
			
			//echo "<pre>".print_r($data, true)."</pre>";
			
			
			
			// ----------- END OF CODE -----------------------------------------------------------------------------------
			
			
			
			
			
		// --- INITIALIZE JS
		
		echo "<script src='https://code.jquery.com/jquery-3.3.1.js'></script>";
		echo "<script src='https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js'></script>";
		$excelextra = "";
		if($type == 'excel')
		{
			$excelextra = "{ dom: 'Bfrtip',buttons:['copy', 'csv', 'excel', 'pdf', 'print'] }";
			echo "<script src='https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js'></script>";
			echo "<script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js'></script>";
			echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>";
			echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>";
			echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>";
			echo "<script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js'></script>";
			echo "<script src='https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js'></script>";
		}
		echo "<script>$('#datasheet').DataTable(".$excelextra.");</script>";
		
		// --- END OF INITIALIZE	
			
			
			
		}
	}
	
	
	
	private function get_schedule_time($uid, $date)
	{
		$sqlusers = "SELECT s.shdate, s.in_time, s.out_time, (SELECT l.login_time from logged_in_details l WHERE l.user_id = '$uid' AND DATE(l.login_time) = '$date' ORDER BY ID ASC LIMIT 1) as actual_login
               		FROM user_shift_schedule as s WHERE s.user_id = '$uid' AND s.shdate = '$date'";
		$query_users = $this->Common_model->get_query_row_array($sqlusers);
		return $query_users;
	}
	
	
	
	
	
}