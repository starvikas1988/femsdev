<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mindfaq_analytics extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();	
	}

	public function index(){
		if(check_logged_in()){
			
			$data['asideBarClients'] = $asideBarClients = $this->get_asidebar_clients();
			
			$data["aside_template"] = "mindfaq_analytics/aside.php";
			$data["content_template"] = "mindfaq_analytics/reports_dashboard.php";
			$this->load->view('dashboard',$data);			
		}
	}
		
	//==========================================================================================
	///=========================== MIND FAQ REPORTS SET ACCESS  ================================///
	
	public function get_asidebar_clients()
	{
		if(get_login_type()=="client") $client_ids = get_clients_client_id();
		else $client_ids = get_client_ids();
		$client_ids = $this->get_additional_client_ids($client_ids);
		
		$extraFilter = "";
		if(get_global_access() != 1 && is_access_global_mindfaq()==false)
		{ 
			//if(!empty($client_ids)){
				$extraFilter = " AND id IN ($client_ids)";
			//}
		}		
		$sqlClient = "SELECT * from client WHERE mind_faq_url IS NOT NULL AND mind_faq_url <> '' and is_active=1 $extraFilter";
		$queryClient = $this->Common_model->get_query_result_array($sqlClient);
		
		$additionalClient = $this->inc_additionalClient();
		$finalClients = array_merge($queryClient, $additionalClient);
		return $finalClients;
	}
	
	public function reports_access_users($client_id, $reportUrl = '', $selected_process = '')
	{
		$extraFilter = ""; $user_ids = "";
		if(!empty($selected_process) && $selected_process != "ALL"){ $extraFilter = " AND is_assign_process(s.id, $selected_process)"; }
		$sql = "SELECT s.id as user_ids from info_assign_client as i 
		        INNER JOIN signin as s ON s.id = i.user_id
				WHERE i.client_id IN ($client_id) $extraFilter";
		$user_idQ = $this->Common_model->get_query_result_array($sql);
		if(!empty($user_idQ)){
			$user_ids = implode(',', array_column($user_idQ, 'user_ids'));
		}
		if(empty($user_ids)){
			$user_ids = $this->inc_additionalUsers($reportUrl, $selected_process);
		}
		$access_ids = $user_ids;
		if(!empty($reportUrl)){
			
			// FOR ADDING EXTRA USERS
			if($reportUrl == 'jurysinnbot')
			{
				$additionalAccessIds = "";								
			}
			if($reportUrl == 'mindfaq_affinity')
			{
				//$additionalAccessIds = "1,4,16374,14951,8371";								
				$additionalAccessIds = "";								
			}
			if(!empty($access_ids) && !empty($additionalAccessIds)){ $access_ids .= "," .$additionalAccessIds; }
			if(empty($access_ids) && !empty($additionalAccessIds)){ $access_ids = $additionalAccessIds; }
		}		
		return $access_ids;
	}
	
	
	
	//==========================================================================================
	///=========================== MIND FAQ REPORTS ANALYTICS  ================================///

    public function reports_visitors()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['asideBarClients'] = $asideBarClients = $this->get_asidebar_clients();
		
		// GET CLIENT ID
		$clientURLName = $this->uri->segment(3);
		$sqlCheck = "SELECT * from client WHERE mind_faq_url = '$clientURLName' AND is_active = '1'";
		$queryCheck = $this->Common_model->get_query_row_array($sqlCheck);
		if(empty($queryCheck['id'])){
			$queryCheck = $this->inc_additionalClient($clientURLName);	
		}
		
		if($queryCheck['mind_faq_url'] ==  $clientURLName && !empty($queryCheck['mind_faq_feedback_table']) && !empty($queryCheck['mind_faq_search_table']))
		{
			
		// GET PROCESS LIST
		$clientID = $queryCheck['id'];
		$queryProcess = array();
		if(!empty($clientID)){
			$clientID = $this->get_additional_client_ids($queryCheck['id']);
			$sqlProcess = "SELECT * from process WHERE client_id IN ($clientID)";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
			if(empty($queryProcess)){
				$queryProcess = $this->inc_additionalProcess($clientURLName);
			}
			$data['processList'] = $queryProcess;
		}
		
		$data['mindFaqClientId'] = $mindFaqClientId = $clientID;
		$data['mindFaqClientName'] = $mindFaqClientName = $queryCheck['fullname'];
		$data['mindFaqUrl'] = $mindFaqUrl = $queryCheck['mind_faq_url'];
		$data['mindFaq_feedbackTable'] = $mindFaq_feedbackTable = $queryCheck['mind_faq_feedback_table'];
		$data['mindFaq_searchTable'] = $mindFaq_searchTable = $queryCheck['mind_faq_search_table'];
		
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
		}
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;

		$selected_process = "";
		if(!empty($this->input->get('p')) && $this->input->get('p') != "ALL")
		{
			$selected_process = $this->input->get('p');
		}
		$data['selected_process'] = $selected_process;		
		
		$data['reportType'] = $reportType = $this->uri->segment(4);
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_access_users($mindFaqClientId, $mindFaqUrl, $selected_process);
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			$sql_visitor = "SELECT jury.*, CONCAT(s.fname, ' ', s.lname) as full_name,
					d.shname as department, r.name as designation, 
					CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor from $mindFaq_searchTable as jury
					INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
					LEFT JOIN department as d ON d.id = s.dept_id
					LEFT JOIN role as r ON r.id = s.role_id
					LEFT JOIN signin as sp ON sp.id = s.assigned_to
					WHERE 
					jury.entry_date >= '$start_date_full' 
					AND jury.entry_date <= '$end_date_full' AND s.id IN ($jurys_inn_users)";
			$visitor_query = $this->Common_model->get_query_result_array($sql_visitor);
			
			//$data['visitors'][$i]['data'] = $visitor_query;
			$data['visitors'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['visitors'][$i]['year'] = $selected_year;
			
			if($reportType == "monthly" || $reportType == "all"){				
			for($j=1;$j<=$total_days;$j++)
			{
				$currentDay = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
				$startDay = $currentDay ." " .$time_start;
				$endDay = $currentDay ." " .$time_end;
				
				$visitor_day_query = array_filter($visitor_query, function($n) use ($startDay, $endDay){
					if($n['entry_date'] >= $startDay && $n['entry_date'] <= $endDay){
						return $n;
					}
				});
				$data['visitors_daily'][$i][$currentDay]['counters']['data'] = $visitor_day_query;
				$data['visitors_daily'][$i][$currentDay]['counters']['date'] = $currentDay;
			    $data['visitors_daily'][$i][$currentDay]['counters']['count'] = count($visitor_day_query);
			}
			}
			
			
			//========================= GET USERWISE VISITORS =================================//
			
			$sql_users = "SELECT jury.fusion_id, count(jury.id) as total_visits, CONCAT(s.fname, ' ', s.lname) as full_name,
						d.shname as department, r.name as designation, CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor 
						from $mindFaq_searchTable as jury
						INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
						LEFT JOIN department as d ON d.id = s.dept_id
						LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN signin as sp ON sp.id = s.assigned_to
						WHERE 
						jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
						AND s.id IN ($jurys_inn_users)
						group by jury.fusion_id 
						order by total_visits DESC LIMIT 25";
			$query_users = $this->Common_model->get_query_result_array($sql_users);
			
			
			//========================= GET FEEDBACK =================================//
			$sql_dislike = "SELECT count(jury.id) as value from $mindFaq_feedbackTable as jury 
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			                WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							AND jury.feedback_status = 'dislike' AND s.id IN ($jurys_inn_users)";
			$query_dislike = $this->Common_model->get_single_value($sql_dislike);
			
			$sql_like = "SELECT count(jury.id) as value from $mindFaq_feedbackTable as jury 
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			                WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							AND jury.feedback_status = 'like'  AND s.id IN ($jurys_inn_users)";
			$query_like = $this->Common_model->get_single_value($sql_like);
			$data['visitors'][$i]['feedback']['like'] = $query_like;
			$data['visitors'][$i]['feedback']['dislike'] = $query_dislike;
			
			$sqlLike = "SELECT count(jury.id) as feedbacks, jury.question_intent FROM $mindFaq_feedbackTable as jury
					 INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			         WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full' 
					 AND jury.feedback_status = 'like' AND s.id IN ($jurys_inn_users) 
		             GROUP by jury.question_intent ORDER BY feedbacks DESC";
			$data['visitors'][$i]['feedback']['data']['like'] = $queryLike = $this->Common_model->get_query_result_array($sqlLike);
			
			$sqlDisLike = "SELECT count(jury.id) as feedbacks, jury.question_intent FROM $mindFaq_feedbackTable as jury
					 INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
			         WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full' 
					 AND jury.feedback_status = 'dislike' AND s.id IN ($jurys_inn_users)  
		             GROUP by jury.question_intent ORDER BY feedbacks DESC";
			$data['visitors'][$i]['feedback']['data']['dislike'] = $queryDisLike = $this->Common_model->get_query_result_array($sqlDisLike);
			
			
			$weekArray = $this->getWeekMonthlyOnly(sprintf('%02d', $i), $selected_year);
			$data['visitors'][$i]['count'] = count($visitor_query);
			$data['visitors'][$i]['weeks'] = count($weekArray);
			$data['visitors'][$i]['weekdates'] = $weekArray;
			$data['visitors'][$i]['users'] = $query_users;
			
			//echo "<pre>".print_r($data['visitors'][$i]['weekdates'], 1) ."</pre>";
			
		}
		
		
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "visitors")
		{
			$this->generate_reports_visitors_xls($data);
		}
		
		if($this->input->get('ex') == "visitors_users")
		{
			$this->generate_reports_visitors_users_xls($data);
		}
		
		if($this->input->get('ex') == "visitors_feedback")
		{
			$this->generate_reports_questions_feedback_xls($data);
		}
		
		
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data["aside_template"] = "mindfaq_analytics/aside.php";
		$data["content_js"] = "mindfaq_analytics/reports_graph_js.php";
		$data["content_template"] = "mindfaq_analytics/reports_visitors.php";
		
		} else {
			
			$data['notfound'] = 'yes';
			$data["aside_template"] = "mindfaq_analytics/aside.php";
			$data["content_template"] = "mindfaq_analytics/reports_dashboard.php";
			
		}
				
		$this->load->view('dashboard',$data);
		
	}
	
	
	public function reports_questions()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['asideBarClients'] = $asideBarClients = $this->get_asidebar_clients();
		
		// GET CLIENT ID
		$clientURLName = $this->uri->segment(3);
		$sqlCheck = "SELECT * from client WHERE mind_faq_url = '$clientURLName' AND is_active = '1'";
		$queryCheck = $this->Common_model->get_query_row_array($sqlCheck);
		if(empty($queryCheck['id'])){
			$queryCheck = $this->inc_additionalClient($clientURLName);	
		}
		
		if($queryCheck['mind_faq_url'] ==  $clientURLName && !empty($queryCheck['mind_faq_feedback_table']) && !empty($queryCheck['mind_faq_search_table']))
		{
			
		// GET PROCESS LIST
		$clientID = $queryCheck['id'];
		$queryProcess = array();
		if(!empty($clientID)){
			$clientID = $this->get_additional_client_ids($queryCheck['id']);
			$sqlProcess = "SELECT * from process WHERE client_id IN ($clientID)";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
			if(empty($queryProcess)){
				$queryProcess = $this->inc_additionalProcess($clientURLName);
			}
			$data['processList'] = $queryProcess;
		}
		
		$data['mindFaqClientId'] = $mindFaqClientId = $clientID;
		$data['mindFaqClientName'] = $mindFaqClientName = $queryCheck['fullname'];
		$data['mindFaqUrl'] = $mindFaqUrl = $queryCheck['mind_faq_url'];
		$data['mindFaq_feedbackTable'] = $mindFaq_feedbackTable = $queryCheck['mind_faq_feedback_table'];
		$data['mindFaq_searchTable'] = $mindFaq_searchTable = $queryCheck['mind_faq_search_table'];
		
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		
		$selected_process = "";
		if(!empty($this->input->get('p')) && $this->input->get('p') != "ALL")
		{
			$selected_process = $this->input->get('p');
		}
		$data['selected_process'] = $selected_process;		
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_access_users($mindFaqClientId, $mindFaqUrl, $selected_process);
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		$data['reportType'] = $reportType = $this->uri->segment(4);
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			//========================= GET TOP QUESTIONS =================================//
			$sql_users = "SELECT jury.question_intent, count(jury.fusion_id) as total_users 
							from $mindFaq_searchTable as jury
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
							WHERE 
							jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							 AND s.id IN ($jurys_inn_users)
							group by jury.question_intent 
							order by total_users DESC LIMIT 10";
			$query_users = $this->Common_model->get_query_result_array($sql_users);
			
			//$data['search'][$i]['data'] = $query_users;
			$data['search'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['search'][$i]['year'] = $selected_year;
			
			$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);
			
			if($reportType == "monthly" || $reportType == "all"){
			$weekCheck = 0;
			foreach($weekArray as $tokenW)
			{
				$currentDay = $tokenW['week_start'];
				$startDay = $tokenW['week_start'] ." " .$time_start;
				$endDay = $tokenW['week_end'] ." " .$time_end;
				
				$sql_Week = "SELECT jury.question_intent, count(jury.fusion_id) as total_users 
							from $mindFaq_searchTable as jury
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
							WHERE 
							jury.entry_date >= '$startDay' AND jury.entry_date <= '$endDay'
							AND s.id IN ($jurys_inn_users)
							group by jury.question_intent 
							order by total_users DESC LIMIT 10";
				$query_Week = $this->Common_model->get_query_result_array($sql_Week);
			
				$data['questions'][$i]['weeklyQuestions'][$weekCheck]['data'] = $query_Week;
				$data['questions'][$i]['weeklyQuestions'][$weekCheck]['start'] = $tokenW['week_start'];
				$data['questions'][$i]['weeklyQuestions'][$weekCheck]['end'] = $tokenW['week_end'];
			    $data['questions'][$i]['weeklyQuestions'][$weekCheck]['count'] = count($query_Week);
				
				$weekCheck++;
			}
			
				$data['questions'][$i]['weekcount'] = count($weekArray);
			
			}
			
			$data['search'][$i]['count'] = count($query_users);
			$data['search'][$i]['weeks'] = count($weekArray);
			$data['search'][$i]['weekdates'] = $weekArray;
			$data['search'][$i]['questions'] = $query_users;
			
			//echo "<pre>".print_r($data['questions'], 1) ."</pre>";
			
		}
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "questions")
		{
			$this->generate_reports_questions_xls($data);
		}
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
								   
		$data['colorShades'] = ["#660000", "#CC0000","#FF0000","#FF3333",  "#FF6666", "#FF9933", "#FF9999", "#FFCC99", "#FFCCCC", "#FFE5CC"];
								   
		$data["aside_template"] = "mindfaq_analytics/aside.php";
		$data["content_js"] = "mindfaq_analytics/reports_graph_js.php";
		$data["content_template"] = "mindfaq_analytics/reports_questions.php";
		
		} else {
			
			$data['notfound'] = 'yes';
			$data["aside_template"] = "mindfaq_analytics/aside.php";
			$data["content_template"] = "mindfaq_analytics/reports_dashboard.php";
			
		}
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	
	public function reports_users()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['asideBarClients'] = $asideBarClients = $this->get_asidebar_clients();
		
		// GET CLIENT ID
		$clientURLName = $this->uri->segment(3);
		$sqlCheck = "SELECT * from client WHERE mind_faq_url = '$clientURLName' AND is_active = '1'";
		$queryCheck = $this->Common_model->get_query_row_array($sqlCheck);
		if(empty($queryCheck['id'])){
			$queryCheck = $this->inc_additionalClient($clientURLName);	
		}
		
		if($queryCheck['mind_faq_url'] ==  $clientURLName && !empty($queryCheck['mind_faq_feedback_table']) && !empty($queryCheck['mind_faq_search_table']))
		{
			
		// GET PROCESS LIST
		$clientID = $queryCheck['id'];
		$queryProcess = array();
		if(!empty($clientID)){
			$clientID = $this->get_additional_client_ids($queryCheck['id']);
			$sqlProcess = "SELECT * from process WHERE client_id IN ($clientID)";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
			if(empty($queryProcess)){
				$queryProcess = $this->inc_additionalProcess($clientURLName);
			}
			$data['processList'] = $queryProcess;
		}
		
		$data['mindFaqClientId'] = $mindFaqClientId = $clientID;
		$data['mindFaqClientName'] = $mindFaqClientName = $queryCheck['fullname'];
		$data['mindFaqUrl'] = $mindFaqUrl = $queryCheck['mind_faq_url'];
		$data['mindFaq_feedbackTable'] = $mindFaq_feedbackTable = $queryCheck['mind_faq_feedback_table'];
		$data['mindFaq_searchTable'] = $mindFaq_searchTable = $queryCheck['mind_faq_search_table'];
			
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		
		$selected_process = "";
		if(!empty($this->input->get('p')) && $this->input->get('p') != "ALL")
		{
			$selected_process = $this->input->get('p');
		}
		$data['selected_process'] = $selected_process;
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_access_users($mindFaqClientId, $mindFaqUrl, $selected_process);
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		$data['reportType'] = $reportType = $this->uri->segment(4);
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			//========================= GET USERS QUESTIONS =================================//
			$sql_users = "SELECT jury.fusion_id, count(jury.id) as total_quest, CONCAT(s.fname, ' ', s.lname) as full_name,
						d.shname as department, r.name as designation, CONCAT(sp.fname, ' ', sp.lname) as l1_supervisor 
						from $mindFaq_searchTable as jury
						INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
						LEFT JOIN department as d ON d.id = s.dept_id
						LEFT JOIN role as r ON r.id = s.role_id
						LEFT JOIN signin as sp ON sp.id = s.assigned_to
						WHERE 
						jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
						AND s.id IN ($jurys_inn_users)
						group by jury.fusion_id 
						order by total_quest DESC";
			$query_users = $this->Common_model->get_query_result_array($sql_users);
			
			//$data['search'][$i]['data'] = $query_users;
			$data['search'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['search'][$i]['year'] = $selected_year;
			
			$weekArray = $this->getWeekMonthly(sprintf('%02d', $i), $selected_year);			
			$data['search'][$i]['count'] = count($query_users);
			$data['search'][$i]['weeks'] = count($weekArray);
			$data['search'][$i]['weekdates'] = $weekArray;
			$data['search'][$i]['users'] = $query_users;
			
			//echo "<pre>".print_r($data['questions'], 1) ."</pre>";
			
		}
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "allusers")
		{
			$this->generate_reports_users_xls($data);
		}
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
								   
		$data['colorShades'] = ["#660000", "#CC0000","#FF0000","#FF3333",  "#FF6666", "#FF9933", "#FF9999", "#FFCC99", "#FFCCCC", "#FFE5CC"];
								   
		$data["aside_template"] = "mindfaq_analytics/aside.php";
		$data["content_js"] = "mindfaq_analytics/reports_graph_js.php";
		$data["content_template"] = "mindfaq_analytics/reports_users.php";
		
		} else {
			
			$data['notfound'] = 'yes';
			$data["aside_template"] = "mindfaq_analytics/aside.php";
			$data["content_template"] = "mindfaq_analytics/reports_dashboard.php";
			
		}
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	
	public function reports_overview()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['asideBarClients'] = $asideBarClients = $this->get_asidebar_clients();
		
		// GET CLIENT ID
		$clientURLName = $this->uri->segment(3);
		$sqlCheck = "SELECT * from client WHERE mind_faq_url = '$clientURLName' AND is_active = '1'";
		$queryCheck = $this->Common_model->get_query_row_array($sqlCheck);
		if(empty($queryCheck['id'])){
			$queryCheck = $this->inc_additionalClient($clientURLName);	
		}
		
		if($queryCheck['mind_faq_url'] ==  $clientURLName && !empty($queryCheck['mind_faq_feedback_table']) && !empty($queryCheck['mind_faq_search_table']))
		{
			
		// GET PROCESS LIST
		$clientID = $queryCheck['id'];
		$queryProcess = array();
		if(!empty($clientID)){
			$clientID = $this->get_additional_client_ids($queryCheck['id']);
			$sqlProcess = "SELECT * from process WHERE client_id IN ($clientID)";
			$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
			if(empty($queryProcess)){
				$queryProcess = $this->inc_additionalProcess($clientURLName);
			}
			$data['processList'] = $queryProcess;
		}
		
		$data['mindFaqClientId'] = $mindFaqClientId = $clientID;
		$data['mindFaqClientName'] = $mindFaqClientName = $queryCheck['fullname'];
		$data['mindFaqUrl'] = $mindFaqUrl = $queryCheck['mind_faq_url'];
		$data['mindFaq_feedbackTable'] = $mindFaq_feedbackTable = $queryCheck['mind_faq_feedback_table'];
		$data['mindFaq_searchTable'] = $mindFaq_searchTable = $queryCheck['mind_faq_search_table'];
		
		// INITITALIZE DATA
		$selected_month = date('m'); //$selected_month = "07"; 		
		$selected_year = date('Y'); 
		if(!empty($this->input->get('m')) || !empty($this->input->get('y')))
		{
			$selected_month = $this->input->get('m');
			$selected_year = $this->input->get('y');
		}		
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		
		$selected_process = "";
		if(!empty($this->input->get('p')) && $this->input->get('p') != "ALL")
		{
			$selected_process = $this->input->get('p');
		}
		$data['selected_process'] = $selected_process;		
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_access_users($mindFaqClientId, $mindFaqUrl, $selected_process);
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		$data['reportType'] = $reportType = $this->uri->segment(4);
		$start_loop = round($selected_month); 
		$end_loop = round($selected_month);
		if($reportType == "yearly" || $reportType == "all"){ $start_loop = 1; $end_loop = 12; }
		
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			$time_start = "00:00:00";
			$time_end = "23:59:59";
			$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
			
			$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
			$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
			
			$start_date_full = $start_date ." " .$time_start;
			$end_date_full = $end_date ." " .$time_end;
			
			//========================= GET QUESTIONS =================================//
			$extraSearch = "";
			if($mindFaq_searchTable == "jurysinn_search"){
				$extraSearch = "jury.answer,";
			}
			$sql_visitor = "SELECT DATE(jury.entry_date) as question_date, jury.question_intent, jury.question_org, $extraSearch count(jury.fusion_id) as total_users 
							from $mindFaq_searchTable as jury
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
							WHERE 
							jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							 AND s.id IN ($jurys_inn_users)
							group by DATE(jury.entry_date),jury.question_intent 
							order by question_date, total_users DESC";
			$visitor_query = $this->Common_model->get_query_result_array($sql_visitor);
			
			$sql_feedback = "SELECT jury.*, CONCAT(s.fname, ' ', s.lname) as added_by_name, s.office_id, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor 
			                from $mindFaq_feedbackTable as jury
							INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
							LEFT JOIN signin as ls ON ls.id = s.assigned_to
							WHERE 
							jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'
							 AND s.id IN ($jurys_inn_users) ORDER BY jury.question_intent ASC";
			$feedback_query = $this->Common_model->get_query_result_array($sql_feedback);
			
			//$data['overview'][$i]['data'] = $visitor_query;
			$data['overview'][$i]['month'] = date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01'));
			$data['overview'][$i]['year'] = $selected_year;
			
			
			if($reportType == "monthly" || $reportType == "all"){
				$dateArray = array();
				for($j=1;$j<=$total_days;$j++)
				{
					$currentDay = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
					$startDay = $currentDay ." " .$time_start;
					$endDay = $currentDay ." " .$time_end;
					$dateArray[] = $currentDay;
					
					$current_day_query = array_filter($visitor_query, function($n) use ($currentDay){
						if($n['question_date'] == $currentDay){
							return $n;
						}
					});
					
					$current_feedback_query = array_filter($feedback_query, function($n) use ($startDay, $endDay){
						if($n['entry_date'] >= $startDay && $n['entry_date'] <= $endDay){
							return $n;
						}
					});
					
					$data['feedback_daily'][$i][$currentDay]['counters']['data'] = $current_feedback_query;
					$data['feedback_daily'][$i][$currentDay]['counters']['date'] = $currentDay;
					$data['feedback_daily'][$i][$currentDay]['counters']['count'] = count($current_feedback_query);
					
					
					$data['overview_daily'][$i][$currentDay]['counters']['data'] = $current_day_query;
					$data['overview_daily'][$i][$currentDay]['counters']['date'] = $currentDay;
					$data['overview_daily'][$i][$currentDay]['counters']['count'] = count($current_day_query);				
				}
				$data['overview_dates'][$i]['count'] = $total_days;
				$data['overview_dates'][$i]['date'] = $dateArray;
			}
			
			
						
			//echo "<pre>".print_r($data['feedback_daily'], 1) ."</pre>";die();
		}
		
		// GENERATE EXCEL
		if($this->input->get('ex') == "overview")
		{
			$this->generate_reports_overview_questions_xls($data);
		}
		
		$data['colorDayWise'] = ["#539bb1", "#08be62", "#eb1212", "#efdb4c"];
		$data['colorWeeklyWise'] = ["#074676", "#84ed65", "#f5f0ca","#eb1212", "#cacac9"];
		
		$data['colorsArray'] = ["#E6CF6F", "#2AC773","#2AD1D1"];
		$data['colorsArray2'] = ["#0AA6D8", "#FF4412", "#1BC720","#FF12D7"];
		$data['colorsAllArray'] = ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff",
		                           "#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'];
								   
		$data['colorShades'] = ["#660000", "#CC0000","#FF0000","#FF3333",  "#FF6666", "#FF9933", "#FF9999", "#FFCC99", "#FFCCCC", "#FFE5CC"];
								   
		$data["aside_template"] = "mindfaq_analytics/aside.php";
		$data["content_js"] = "mindfaq_analytics/reports_graph_js.php";
		$data["content_template"] = "mindfaq_analytics/reports_overview.php";
		
		} else {
			
			$data['notfound'] = 'yes';
			$data["aside_template"] = "mindfaq_analytics/aside.php";
			$data["content_template"] = "mindfaq_analytics/reports_dashboard.php";
			
		}
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	public function generate_reports_overview_questions_xls($data)
	{
		$excel_Type = "Daily Overview Questions";
		$file_Type = "Daily Overview Questions";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$mindFaqUrl = $data['mindFaqUrl'];
		$mindFaq_feedbackTable = $data['mindFaq_feedbackTable'];
		$mindFaq_searchTable = $data['mindFaq_searchTable'];
		$mindFaqClientId = $data['mindFaqClientId'];
		$mindFaqClientName = $data['mindFaqClientName'];
		
		$additionalShow = false;
		if($mindFaq_searchTable == "jurysinn_search"){
			$additionalShow = true;
		}
		
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
				
		//$month = $data['search'][$i]['month'];
		//$year = $data['search'][$i]['year'];
		//$questions = $data['search'][$i]['questions'];
		$current_dataSet = $data['feedback_daily'][round($selected_month)];
		$current_dateSet = $data['overview_dates'][round($selected_month)];	
		$current_alldateSet = $data['overview_daily'][round($selected_month)];	
		
		$sheetActive = 0;			
		// OVERALL				
		$this->objPHPExcel->createSheet($sheetActive);
		$this->objPHPExcel->setActiveSheetIndex($sheetActive);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($sheetActive);
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A1:C1'.$this->objPHPExcel->getActiveSheet($sheetActive)->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Question Asked");
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Actual Question");
		if($additionalShow){
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Answer");
		}
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "No Of Search");
				
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
		
		$title = "Daily Overview Questions  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex($sheetActive)->mergeCells('A1:F1');
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A2:F2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(15); 
		$objWorksheet->getColumnDimension('C')->setWidth(50);
		$objWorksheet->getColumnDimension('D')->setWidth(50);
		$objWorksheet->getColumnDimension('E')->setWidth(80);
		$objWorksheet->getColumnDimension('F')->setWidth(30);

		$counter=0;	
		foreach($current_dateSet['date'] as $token){
			$currentDataGot = $current_alldateSet[$token]['counters']['data'];
			foreach($currentDataGot as $tokenu)
			{
				$c++; $r=0;
				$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, ++$counter);
				$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, date('d M, Y', strtotime($token)));
				$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['question_org']);
				$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['question_intent']);
				if($additionalShow){
				$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['answer']);
				}
				$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['total_users']);
			}
		}
		
		$sheetActive++;
		
		
		
		
		// MULTIPLE SHEET

		
		foreach($current_dateSet['date'] as $token){
		
		$currentDataGot = $current_alldateSet[$token]['counters']['data'];
		$currentDateName = date('d F', strtotime($token));
		
		$excel_Type = $currentDateName;				
		$this->objPHPExcel->createSheet($sheetActive);
		$this->objPHPExcel->setActiveSheetIndex($sheetActive);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($sheetActive);
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A1:C1'.$this->objPHPExcel->getActiveSheet($sheetActive)->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Question Asked");
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Actual Question");
		if($additionalShow){
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "Answer");
		}
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, "No Of Search");
				
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
		
		$title = "Daily Overview Questions  - " .date('d M, Y', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex($sheetActive)->mergeCells('A1:F1');
		$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A2:F2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($sheetActive)->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(15); 
		$objWorksheet->getColumnDimension('C')->setWidth(50);
		$objWorksheet->getColumnDimension('D')->setWidth(50);
		$objWorksheet->getColumnDimension('E')->setWidth(80);
		$objWorksheet->getColumnDimension('F')->setWidth(30);
		
		$counter=0;
		foreach($currentDataGot as $tokenu)
		{				
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, date('d M, Y', strtotime($token)));
			$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['question_org']);
			$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['question_intent']);
			if($additionalShow){
			$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['answer']);
			}
			$this->objPHPExcel->getActiveSheet($sheetActive)->setCellValueByColumnAndRow($r++,$c, $tokenu['total_users']);
		}
		
		$sheetActive++;
		
		}		
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_Type .'_'.date('F', strtotime($start_date)).'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	public function reports_overview_questions()
	{
		$this->load->view('reports_overview_questions',$data);
	}
	
	//==========================================================================================
	///=========================== MIND FAQ REPORTS EXCEL  ================================///
	
	
	public function generate_reports_visitors_xls($data)
	{
		$excel_Type = "Daily Visitors";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$mindFaqUrl = $data['mindFaqUrl'];
		$mindFaq_feedbackTable = $data['mindFaq_feedbackTable'];
		$mindFaq_searchTable = $data['mindFaq_searchTable'];
		$mindFaqClientId = $data['mindFaqClientId'];
		$mindFaqClientName = $data['mindFaqClientName'];		
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Date");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Chats");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Visitors");
				
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
		
		$title = "Daily Visitors  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(30); 
		$objWorksheet->getColumnDimension('C')->setWidth(30);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		
		$i = round($selected_month);
		$month = $data['visitors'][$i]['month'];
		$year = $data['visitors'][$i]['year'];
		
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_loop = 1; $end_loop = $total_days; $graphcheck = 0;
		for($j=$start_loop; $j<=$end_loop; $j++)
		{
			$graphcheck++;
			$currentDay = $selected_year ."-". sprintf('%02d', $i) ."-" .sprintf('%02d', $j);
			$date_visit = date('d M, Y', strtotime($data['visitors_daily'][$i][$currentDay]['counters']['date']));
			$all_visit = $data['visitors_daily'][$i][$currentDay]['counters']['count'];
			$userCountsAr = $this->array_indexed($data['visitors_daily'][$i][$currentDay]['counters']['data'], 'fusion_id');		
			$userCounts = !empty($userCountsAr) ? count($userCountsAr) : '0';		
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $j);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $date_visit);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $all_visit);			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $userCounts);
			
		}
		
		$c++; $r=0;
		
		if(!empty($graphcheck)){
		$fileImage = "uploads/report_graph/jurysinn_daily_visitors_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E6');        //set image to cell
			$objDrawing->setWidth(400);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function generate_reports_visitors_users_xls($data)
	{
		$excel_Type = "Top Users";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$mindFaqUrl = $data['mindFaqUrl'];
		$mindFaq_feedbackTable = $data['mindFaq_feedbackTable'];
		$mindFaq_searchTable = $data['mindFaq_searchTable'];
		$mindFaqClientId = $data['mindFaqClientId'];
		$mindFaqClientName = $data['mindFaqClientName'];
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "User");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Visits");
				
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
		
		$title = "Users Visits  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(30); 
		$objWorksheet->getColumnDimension('C')->setWidth(30);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		
		$i = round($selected_month);
		$month = $data['visitors'][$i]['month'];
		$year = $data['visitors'][$i]['year'];
		$users = $data['visitors'][$i]['users'];
		
		$counter=0;  $graphcheck = 0;
		foreach($users as $token)
		{	
			 $graphcheck++;
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['total_visits']);
			
		}
		
		if(!empty($graphcheck)){
		$fileImage = "uploads/report_graph/jurysinn_daily_visitors_users_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E6');        //set image to cell
			$objDrawing->setWidth(400);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	public function generate_reports_questions_feedback_xls($data)
	{
		$excel_Type = "Questions Feedback";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$mindFaqUrl = $data['mindFaqUrl'];
		$mindFaq_feedbackTable = $data['mindFaq_feedbackTable'];
		$mindFaq_searchTable = $data['mindFaq_searchTable'];
		$mindFaqClientId = $data['mindFaqClientId'];
		$mindFaqClientName = $data['mindFaqClientName'];
		
		$additionalShow = false;
		if($mindFaq_searchTable == "jurysinn_search"){
			$additionalShow = true;
		}
		
		$selected_process = $data['selected_process'];
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_access_users($mindFaqClientId, $mindFaqUrl, $selected_process);
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
		
		$sqlLike = "SELECT jury.question_intent, GROUP_CONCAT(jury.feedback_status) as feedbacks FROM $mindFaq_feedbackTable as jury
		INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
		WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full'  AND s.id IN ($jurys_inn_users)
		GROUP BY jury.question_intent";
		$queryLike = $this->Common_model->get_query_result_array($sqlLike);
				
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Question");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Likes");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Dislikes");
				
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
		
		$title = "Questions Feedback  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(100); 
		$objWorksheet->getColumnDimension('C')->setWidth(15);
		$objWorksheet->getColumnDimension('D')->setWidth(15);
				
		$month = $data['visitors'][$i]['month'];
		$year = $data['visitors'][$i]['year'];
		$users = $data['visitors'][$i]['users'];
		
		$counter=0; $graphcheck = 0;
		foreach($queryLike as $token)
		{	
			$graphcheck++;
			$feedbackC = explode(',', $token['feedbacks']);
			$likeC = array_filter($feedbackC, function($n){
				if($n == 'like'){ return $n; }
			});
			$no_of_likes = count($likeC);
			$no_of_dislikes = count($feedbackC) - $no_of_likes;
			
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $no_of_likes);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $no_of_dislikes);
			
		}
		
		if(!empty($graphcheck)){
		$fileImage = "uploads/report_graph/jurysinn_feedback_questions_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E3');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		}
		
		// JURYS INN USERS
		$jurys_inn_users = $this->reports_access_users($mindFaqClientId, $mindFaqUrl, $selected_process);
		if(empty($jurys_inn_users)){ $jurys_inn_users = '0'; }
		
		//========= EXCEL FEEDBACK ================================//
		$sqlLike = "SELECT jury.*, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id FROM $mindFaq_feedbackTable as jury
					INNER JOIN signin as s ON s.fusion_id = jury.fusion_id
		             WHERE jury.entry_date >= '$start_date_full' AND jury.entry_date <= '$end_date_full' 
		             AND s.id IN ($jurys_inn_users)
		             ORDER by jury.question_intent, jury.feedback_status ASC";
		$queryLike = $this->Common_model->get_query_result_array($sqlLike);		
		$likedArray = array_filter($queryLike, function ($var) { return (strtolower(trim($var['feedback_status'])) == 'like'); });
		$dislikedArray = array_filter($queryLike, function ($var) { return (strtolower(trim($var['feedback_status'])) == 'dislike'); });
		
		//=========== WORKSHEET 1 - DISLIKED FEEDBACK =====================//
		$excel_Type2 = "Disliked Feedbacks";
		$this->objPHPExcel->createSheet(1);
		$this->objPHPExcel->setActiveSheetIndex(1);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(1);
		$objWorksheet->setTitle($excel_Type2);		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);		
		$r=0; $c = 2; $counter=0;
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Question");
		//$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Answer");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Comments");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Feedback");		
		if($additionalShow){
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Prompt Reason");
		}
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Entry Date");
		$title = "Disliked Feedbacks  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:G1');
		$this->objPHPExcel->getActiveSheet(1)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet(1)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A1')->applyFromArray($headerArray);		
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A2:H2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(15);
		$objWorksheet->getColumnDimension('C')->setWidth(25);
		$objWorksheet->getColumnDimension('D')->setWidth(10);
		$objWorksheet->getColumnDimension('E')->setWidth(65); 
		$objWorksheet->getColumnDimension('F')->setWidth(50);
		$objWorksheet->getColumnDimension('G')->setWidth(15);	
		$objWorksheet->getColumnDimension('H')->setWidth(50);	
		$objWorksheet->getColumnDimension('I')->setWidth(15);	
		foreach($dislikedArray as $token)
		{
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, ++$counter);			
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['fullname']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['office_id']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			//$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['answer']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['comment']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, ucwords($token['feedback_status']));
			if($additionalShow){
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['prompt_reason']);
			}
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['entry_date']);
		}		
		$highestRow = $this->objPHPExcel->getActiveSheet(1)->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet(1)->getHighestColumn();
		$this->objPHPExcel->getActiveSheet(1)->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		//=========== WORKSHEET 1 - LIKED FEEDBACK =====================//
		$excel_Type2 = "Liked Feedbacks";
		$this->objPHPExcel->createSheet(2);
		$this->objPHPExcel->setActiveSheetIndex(2);
		$objWorksheet = $this->objPHPExcel->getActiveSheet(2);
		$objWorksheet->setTitle($excel_Type2);		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A1:D1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);		
		$r=0; $c = 2; $counter=0;
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Name");
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Question");
		//$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Answer");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Comments");
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Feedback");
		if($additionalShow){
		$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, "Prompt Reason");
		}
		$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, "Entry Date");
		$title = "Liked Feedbacks  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(2)->mergeCells('A1:G1');
		$this->objPHPExcel->getActiveSheet(2)->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet(2)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A1')->applyFromArray($headerArray);		
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A2:H2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(15);
		$objWorksheet->getColumnDimension('C')->setWidth(25);
		$objWorksheet->getColumnDimension('D')->setWidth(10);
		$objWorksheet->getColumnDimension('E')->setWidth(65); 
		$objWorksheet->getColumnDimension('F')->setWidth(50);
		$objWorksheet->getColumnDimension('G')->setWidth(15);		
		$objWorksheet->getColumnDimension('H')->setWidth(50);		
		$objWorksheet->getColumnDimension('I')->setWidth(15);		
		foreach($likedArray as $token)
		{
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['fullname']);
			$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['office_id']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			//$this->objPHPExcel->getActiveSheet(1)->setCellValueByColumnAndRow($r++,$c, $token['answer']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['comment']);
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, ucwords($token['feedback_status']));
			if($additionalShow){
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['prompt_reason']);
			}
			$this->objPHPExcel->getActiveSheet(2)->setCellValueByColumnAndRow($r++,$c, $token['entry_date']);
		}		
		$highestRow = $this->objPHPExcel->getActiveSheet(2)->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet(2)->getHighestColumn();
		$this->objPHPExcel->getActiveSheet(2)->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);	
		
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
	
	
	public function generate_reports_questions_xls($data)
	{
		$excel_Type = "Top 10 Questions";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$mindFaqUrl = $data['mindFaqUrl'];
		$mindFaq_feedbackTable = $data['mindFaq_feedbackTable'];
		$mindFaq_searchTable = $data['mindFaq_searchTable'];
		$mindFaqClientId = $data['mindFaqClientId'];
		$mindFaqClientName = $data['mindFaqClientName'];
		
		$i = round($selected_month);
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$total_days = cal_days_in_month(CAL_GREGORIAN, sprintf('%02d', $i), $selected_year);
		$start_date = $selected_year ."-". sprintf('%02d', $i) ."-01";
		$end_date   = $selected_year ."-". sprintf('%02d', $i) ."-" .$total_days;
		$start_date_full = $start_date ." " .$time_start;
		$end_date_full = $end_date ." " .$time_end;
						
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:C1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Question");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Users");
				
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
		
		$title = "Top 10 Questions  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(100); 
		$objWorksheet->getColumnDimension('C')->setWidth(15);
				
		$month = $data['search'][$i]['month'];
		$year = $data['search'][$i]['year'];
		$questions = $data['search'][$i]['questions'];
		
		$counter=0;
		foreach($questions as $token)
		{				
			$c++; $r=0;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['question_intent']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['total_users']);
			
		}
		
		$weekCheck = 0; $curentWeek = 0;
		foreach($data['search'][$i]['weekdates'] as $tokenW)
		{
			$curentWeek++;
			$currentDay = $tokenW['week_start'];
			$weekDates = date('d M', strtotime($tokenW['week_start'])) ." - " .date('d M Y', strtotime($tokenW['week_end']));
			
			$r=0; $c++;
			$r=0; $c++;
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$c.':C'.$c);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c)->applyFromArray($headerArray);
			$this->objPHPExcel->getActiveSheet()->getRowDimension($c)->setRowHeight(40);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, 'WEEK '.$curentWeek.' ('.$weekDates.')');
			
			$r=0; $c++; $startc = $c;
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':C'.$c)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#cccccc');
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Question");
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Users");
			
			$sl=0; $graphcheck=0;
			foreach($data['questions'][$i]['weeklyQuestions'][$weekCheck]['data'] as $tokenData)
			{
				$graphcheck++;
				$c++; $r=0; $sl++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $sl);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['question_intent']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $tokenData['total_users']);
			}
			$weekCheck++;
			
			if(!empty($graphcheck)){
			$fileImage = "uploads/report_graph/jurysinn_weekly_".$weekCheck."_top_questions_img.png";
			if(file_exists($fileImage))
			{
				$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
				$objDrawing->setName('Jurys Inn');        //set name to image
				$objDrawing->setDescription('Jurys Inn'); //set description to image
				$signature = $fileImage;    //Path to signature .jpg file
				$objDrawing->setPath($signature);
				$objDrawing->setOffsetX(25);                       //setOffsetX works properly
				$objDrawing->setOffsetY(10);                       //setOffsetY works properly
				$objDrawing->setCoordinates('E' .$startc);        //set image to cell
				$objDrawing->setWidth(350);                 //set width, height
				$objDrawing->setHeight(250);
				$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
			}
			}
			
		}
		
		
		$fileImage = "uploads/report_graph/jurysinn_monthly_top_questions_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('E1');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		for($j=1;$j<$weekCheck;$j++)
		{
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	public function generate_reports_users_xls($data)
	{
		$excel_Type = "Questions asked by users";
		$selected_year = $data['selected_year'];
		$selected_month = $data['selected_month'];
		$mindFaqUrl = $data['mindFaqUrl'];
		$mindFaq_feedbackTable = $data['mindFaq_feedbackTable'];
		$mindFaq_searchTable = $data['mindFaq_searchTable'];
		$mindFaqClientId = $data['mindFaqClientId'];
		$mindFaqClientName = $data['mindFaqClientName'];
		
		$full_month  = date('F', strtotime('2019-'.$selected_month .'-01'));
	
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($excel_Type);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:F1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		//$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		//$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		//$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Full Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "No of Questions");
				
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
		
		$title = "Questions asked by Users  - " .date('F', strtotime($selected_year.'-'.$selected_month.'-01')) ." " . $selected_year;
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
				
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		$objWorksheet->getColumnDimension('A')->setWidth(10);
		$objWorksheet->getColumnDimension('B')->setWidth(25); 
		$objWorksheet->getColumnDimension('C')->setWidth(40);
		$objWorksheet->getColumnDimension('D')->setWidth(40);
		$objWorksheet->getColumnDimension('E')->setWidth(30);
		$objWorksheet->getColumnDimension('F')->setWidth(20);
		
		$i = round($selected_month);
		$month = $data['search'][$i]['month'];
		$year = $data['search'][$i]['year'];
		$users = $data['search'][$i]['users'];
		
		$counter=0;  $graphcheck = 0;
		foreach($users as $token)
		{	
			$c++; $r=0;  $graphcheck++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['designation']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['l1_supervisor']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $token['total_quest']);
			
		}
		
		if(!empty($graphcheck)){
		$fileImage = "uploads/report_graph/jurysinn_users_questions_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('I3');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		
		
		$fileImage = "uploads/report_graph/jurysinn_users_histogram_img.png";
		if(file_exists($fileImage))
		{
			$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
			$objDrawing->setName('Jurys Inn');        //set name to image
			$objDrawing->setDescription('Jurys Inn'); //set description to image
			$signature = $fileImage;    //Path to signature .jpg file
			$objDrawing->setPath($signature);
			$objDrawing->setOffsetX(25);                       //setOffsetX works properly
			$objDrawing->setOffsetY(10);                       //setOffsetY works properly
			$objDrawing->setCoordinates('I22');        //set image to cell
			$objDrawing->setWidth(450);                 //set width, height
			$objDrawing->setHeight(300);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
		}
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type .'_'.$full_month.'_'.$year.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	public function saveImageOnServer()
	{
		$imgData = $_POST['filData'];
		$imgName = $_POST['fileName'];
		$img = str_replace('data:image/png;base64,', '', $imgData);
		$img = str_replace(' ', '+', $img);
		$fileData = base64_decode($img);		
		if(!empty($imgName))
		{
			$fileName = 'uploads/report_graph/' .$imgName;
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
	
	private function getWeekMonthlyOnly($month, $year)
	{
		$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$startDate = $year."-".$month."-01";
		$endDate   = $year.'-'.$month.'-'.$totalDays;
		$startWeek = date("W", strtotime($startDate));
		$endWeek = date("W", strtotime($endDate));
		$counter = 0; $weekArray = array();
		for($i=$startWeek; $i<=$endWeek; $i++)
		{
			$weekInfo = $this->getMonthWeekInfo($i, $month, $year);
			$weekArray[$counter] = $weekInfo;
			$weekArray[$counter]['week'] = sprintf('%02d',$i);
			$counter++;
		}		
		return $weekArray;
	}
	
	private function getMonthWeekInfo($week, $month, $year)
	{
	  $dto = new DateTime();
	  $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	  $start_date = $year ."-". $month ."-01";
	  $end_date   = $year ."-". $month ."-" .$total_days;
	  $ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
	  $ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
	  if(date('m', strtotime($ret['week_start'])) < $month){ $ret['week_start'] = $start_date; }
	  if(date('m', strtotime($ret['week_end'])) > $month){ $ret['week_end'] = $end_date; }
	  $ret['start_day'] = date('d', strtotime($ret['week_start']));
	  $ret['end_day'] = date('d', strtotime($ret['week_end']));
	  return $ret;
	}
	
	
	
	//=============== ADDITIONAL CLIENT =========================================//
	
	public function configureCustomClient($clientName = ''){
		$_resultArray = array();		
		$my_process_ids = get_process_ids();
		
		/*--- Add Custom Client Array ------*/
		
		// MINDFAQ AFFINITY
		if(is_access_affinity_modules()){
			$_resultArray['mindfaq_affinity'] = [
					"client_id" => 133,
					"process_id" => 266,
					"client_name" => 'Affinity',
					"mind_faq_url" => 'mindfaq_affinity',
					"mind_faq_feedback_table" => 'bot_affinity_feedback',
					"mind_faq_search_table" => 'bot_affinity_search',
			];
		}
		
		// MINDFAQ BRIGHTWAY
		if(is_access_brightway_modules()){
			$_resultArray['mindfaq_brightway'] = [
					"client_id" => 134,
					"process_id" => '377',
					"client_name" => 'Brightway',
					"mind_faq_url" => 'mindfaq_brightway',
					"mind_faq_feedback_table" => 'bot_brightway_feedback',
					"mind_faq_search_table" => 'bot_brightway_search',
			];
		}
		
		if(!empty($clientName)){ return $_resultArray[$clientName];	 }
		return $_resultArray;
	}
	
	public function inc_additionalClient($searchClient = '')
	{
		$startClientID = "9999";
		$_addditional = array();
		
		$extra_clientList = $this->configureCustomClient();		
		if(!empty($extra_clientList)){
			foreach($extra_clientList as $key=>$token){
				$_addditional[] = [
					"id" => ++$startClientID,
					"shname" => $token['client_name'],
					"fullname" => $token['client_name'],
					"is_active" => 1,
					"is_metrix" => 'N',
					"qa_report_url" =>  '',
					"mind_faq_url" => $token['mind_faq_url'],
					"mind_faq_feedback_table" => $token['mind_faq_feedback_table'],
					"mind_faq_search_table" => $token['mind_faq_search_table'],
					"log" => '',
				];
			}
		}		
		$_result = $_addditional;
		
		if(!empty($searchClient)){
			$_result_found = array();
			foreach($_addditional as $tokenSearch){
				if($tokenSearch['mind_faq_url'] == $searchClient || $tokenSearch['id'] == $searchClient){
					$_result_found[] = $tokenSearch;
				}
			}
			$_result = !empty($_result_found[0]) ? $_result_found[0] : array();
		}
		
		return $_result;
		
		//$sqlClient = "SELECT * from client WHERE mind_faq_url IS NOT NULL AND mind_faq_url <> '' $extraFilter";
		//$queryClient = $this->Common_model->get_query_result_array($sqlClient);
		//$arraynew = array_merge($queryClient, $_addditional);
		//echo "<pre>".print_r($arraynew, 1)."</pre>";
		
	}
	
	public function inc_additionalProcess($searchClient = '', $type='')
	{
		$processIDs = "";
		$_resultArray = array();
		
		if(!empty($this->configureCustomClient($searchClient))){
			$ClientInfo = $this->configureCustomClient($searchClient);
			$processIDs = $ClientInfo['process_id'];
		}
		if(empty($processIDs)){ $processIDs = 0; }
		$sqlProcess = "SELECT * FROM process WHERE id IN ($processIDs)";
		$queryProcess = $this->Common_model->get_query_result_array($sqlProcess);
		$_resultArray = $queryProcess;
		
		if(!empty($type)){ return $processIDs;	 }
		return $_resultArray;		
	}
	
	
	public function inc_additionalUsers($searchClient = '', $selected_process = '')
	{
		$user_ids = "";
		$getProcessID = $this->inc_additionalProcess($searchClient, 'data');
		if(!empty($selected_process) && $selected_process != 'ALL'){
			$getProcessID = $selected_process;
		}
		$sqlUsers = "SELECT s.id as user_ids from info_assign_process as i 
		               INNER JOIN signin as s ON s.id = i.user_id
				       WHERE i.process_id IN ($getProcessID)";
		$user_idQ = $this->Common_model->get_query_result_array($sqlUsers);
		if(!empty($user_idQ)){
			$user_ids = implode(',', array_column($user_idQ, 'user_ids'));
		}
		$_result = $user_ids;
		return $_result;		
	}
	
	
	//=============== ADDITIONAL CLIENT IDS =========================================//
	public function configure_additional_client_ids()
	{
		$extraArray = [
		
			// App Help, App Direct
			"7" => "12",
			"12" => "7",
		
		];
		return $extraArray;
	}

	public function get_additional_client_ids($clientID)
	{
		$currentClientID[] = $clientID;
		$extraIDs = $this->configure_additional_client_ids();
		if(!empty($extraIDs) && !empty($clientID)){
			$clientArray = explode(',', $clientID);
			foreach($clientArray as $token){
				if(!empty($extraIDs[$clientID])){
					$currentClientID[] = $extraIDs[$clientID];
				}
			}
		}
		$resultIDs = implode(',', $currentClientID);
		return $resultIDs;
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
	
	
	
}