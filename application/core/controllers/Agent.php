<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CI_Controller {
    
    private $aside = "agent/aside.php";
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('reports_model');
		
	}

	public function index()
    {					
		$this->user_model->auto_logout_after_hrs() ;
		
        if(check_logged_in())
        {
			$current_user = get_user_id();
			
            $data["aside_template"] = get_aside_template();
			
            $data["content_template"] = "agent/dashboard.php";
			
			//$data['login_details'] = $this->user_model->get_user_list($current_user,'7 DAY');
			
			///////
				
				$user_site_id= get_user_site_id();
				$omuid=get_user_omuid();
				$fusion_id=get_user_fusion_id();
				
				$end_date=date("m/d/Y",time());
				$start_date= date("m/d/Y", strtotime('-15 days'));
				$filter_key="Agent";
				
				$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"filter_key" => $filter_key,
					"filter_value" => $fusion_id,
					"user_site_id"=> $user_site_id,
					"assigned_to"=> "",
				); 
				
				$currDate=CurrDate();	
				if(date('D', strtotime($currDate)) == "Mon") $shMonDate=$currDate;
				else $shMonDate=date('Y-m-d',strtotime($currDate.' -1 Monday'));
				if(date('D', strtotime($currDate)) == "Sun") $shSunDate=$currDate;
				else $shSunDate=date('Y-m-d',strtotime($currDate.' +1 Sunday'));
			
				$qSql="Select a.*,b.fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,status,(Select name from process y where y.id=b.process_id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name,(Select name from role x  where x.id=b.role_id) as role_name from user_shift_schedule a, signin b where a.user_id=b.id and status=1 and start_date='$shMonDate' and end_date='$shSunDate' and user_id='$current_user'";
				
				//echo $qSql;
				
				$data["sch_list"]= $this->Common_model->get_query_result_array($qSql);
				
				//$qSql="Select CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as value from user_shift_schedule where user_id='$current_user'";
				//$data["sch_date_range"]= $this->Common_model->get_single_value($qSql);
				
				$data["sch_date_range"]= mysql2mmddyy($shMonDate) . " To " . mysql2mmddyy($shSunDate);
						
				$qSql="Select start_date,end_date,CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as shrange from user_shift_schedule  group by start_date";
				
				$data["all_sch_date_range"]= $this->Common_model->get_query_result_array($qSql);
									 
				$data['login_details'] = array_reverse($this->reports_model->get_user_list_report($filterArray),true);
				
			////////
			
			$this->load->view('dashboard',$data);
        }
    }
	
	
	
	
	
	
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
		
		// Calculate Max Time adding 8 hours
		//$max_time = new DateTime(date("Y-m-d H:i:s", strtotime( "$date +1  minutes" )));
		
		// Get NOW time stamp
		$now = new DateTime(date("Y-m-d H:i:s"));
		
		// Get difference between now and max_time 
		$edate = $date->diff($now);
		return ($edate->h * 3600) + ($edate->i * 60) + ($edate->s);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Login-Stats
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function login_stats_now()
	{
		if(check_logged_in())
        {
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			$fusion_id=get_user_fusion_id();
			
            $data["aside_template"] = $this->aside;
            $data["content_template"] = "agent/agent_login_stats.php";
						
			$end_date=date("m/d/Y",time());
			$start_date= date("m/d/Y", strtotime('-31 days'));
			$filter_key="Agent";
			
			$filterArray = array(
				"start_date" => $start_date,
				"end_date" => $end_date,
				"filter_key" => $filter_key,
				"filter_value" => $fusion_id,
				"user_site_id"=> $user_site_id,
				"assigned_to"=> "",
				
			); 
					 
			$data['login_details'] = array_reverse($this->reports_model->get_user_list_report($filterArray),true);
						
			$this->load->view('dashboard',$data);
        }
	}

////////////////////////////////////////
	
//////////////////////////////////////////////////////////
//////////////////// User Resignation ////////////////////
//////////////////////////////////////////////////////////	
	
	/* public function agent_resignation(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			$fusion_id=get_user_fusion_id();
			
			$data["aside_template"] = $this->aside;
            $data["content_template"] = "agent/agent_resignation.php";
			
			
			
			$qSql="SELECT (select resign_period_day from office_location a where a.abbr=b.office_id) as value FROM signin b where b.status='1' and b.id='$current_user'";
			$data["resign_period_day"]= $this->Common_model->get_single_value($qSql);
			
			
			//$qSql="Select * from (SELECT b.id, (select resign_period_day from office_location a where a.abbr=b.office_id) as value FROM signin b where b.status='1' and b.id='$current_user') xx Left Join (Select * from user_resign) yy On (xx.id=yy.user_id)";
			
			$qSql="Select * from user_resign where user_id='$current_user' and resign_status!='R' ";
			//print_r($qSql);
			$data["get_resign_status"]= $this->Common_model->get_query_result_array($qSql);
			
			
			if($this->input->post('submit')== 'SAVE' )
			{
				$resign_date = mmddyy2mysql($this->input->post('resign_date'));
				$released_date = mmddyy2mysql($this->input->post('released_date'));
				
				$user_remarks = $this->input->post('user_remarks');
				$current_user_date = date('Y-m-d H:i:s');
				
				$field_array = array(
					"user_id" => $current_user,
					"resign_date" => $resign_date,
					"user_remarks" => $user_remarks,
					"current_user_date" => $current_user_date,
					"released_date" => $released_date,
					"resign_status" => "P"
				);
				$rowid = data_inserter('user_resign',$field_array);
				redirect('agent/agent_resignation');
			}	
			
			$this->load->view('dashboard',$data);
		}
	} */
	
	
	
}

?>