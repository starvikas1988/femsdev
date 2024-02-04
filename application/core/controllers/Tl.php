<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tl extends CI_Controller {
           
    
	public function index()
    {
		$this->load->model('user_model');
		$this->load->model('Common_model');
			
		$this->Common_model->auto_disposition_update();
		
		$this->user_model->auto_logout_after_hrs();
		
	   if(check_logged_in())
        {
			if(get_login_type() == "client") redirect(base_url().'client',"refresh");
			
            $filter_id=$this->uri->segment(3);
			
			$current_user = get_user_id();
			$current_fusion_id = get_user_fusion_id();
			
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			
			/*
			if($user_site_id==""){
				echo "<center><br><b>Please login again</b></center>";
				exit();
			}
			*/
			
			//echo "filter_id :: " . $filter_id;
			
			if(get_role_dir()!="tl") redirect(base_url().get_role_dir()."/dashboard","refresh");
			$data["aside_template"] = get_aside_template();
            $data["content_template"] = "tl/dashboard.php";
     									
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			//$dValue = trim($this->input->post('dept_id'));
			//if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			//$sdValue = trim($this->input->post('sub_dept_id'));
			//if($sdValue=="") $sdValue = trim($this->input->get('sub_dept_id'));
				
			//$data['dValue']=$dValue;
			//$data['sdValue']=$sdValue;
			
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['pValue']=$pValue;
						
			$_filterCond="";
						
			//if($dValue!="ALL" && $dValue!="") $_filterCond .= " And dept_id='".$dValue."'";
			//if($sdValue!="ALL" && $sdValue!="") $_filterCond .= " And sub_dept_id='".$sdValue."'";
			
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And is_assign_client (b.id,$cValue)";
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " And office_id='".$oValue."'";				
			if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " And is_assign_process(b.id,$pValue)";
						
			$qSql="Select id,name from master_term_type where is_active=1";
			$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,name from master_sub_term_type where is_active=1";
			$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from master_resign_reason where is_active=1";
			$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			$data['client_list'] = $this->Common_model->get_client_list();
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['disp_list'] = $this->Common_model->get_event_for_assign();
						
			//$cond= " where status = 1 And (site_id='$user_site_id' OR office_id='$user_office_id') And assigned_to=".$current_user;
			//$cond= " where status=1 and ( id in (select user_id from info_repoting_head where level1='$current_fusion_id') OR id in (select user_id from info_repoting_head where level2='$current_fusion_id') OR id in (select user_id from info_repoting_head where level2='$current_fusion_id') )";
			
			//$assToCond= " (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
			
			$assToCond = " (assigned_to='$current_user' OR (assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' )))) ";
			
			
			$cond= " where status in  (1,4) And ". $assToCond ;
			$data['total_agent'] = $this->Common_model->get_total("signin b",$cond);
			
			//$cond= " where status = 1 and is_logged_in=0 And (site_id='$user_site_id' OR office_id='$user_office_id') And assigned_to=".$current_user;
			$cond= " where status in  (1,4) and is_logged_in=0 And ". $assToCond ;
			$data['total_offline'] = $this->Common_model->get_total("signin b",$cond);
			
			//$cond= " where status = 1 and is_logged_in=1 And (site_id='$user_site_id' OR office_id='$user_office_id') And assigned_to=".$current_user;
			$cond= " where status in  (1,4) and is_logged_in=1 And ". $assToCond ;
			$data['total_online'] = $this->Common_model->get_total("signin b",$cond);
			
			//$cond= " where status = 1 and is_logged_in=0 and disposition_id in(2,3,4,5) And (site_id='$user_site_id' OR office_id='$user_office_id') And assigned_to=".$current_user;
			
			$cond= " where status in  (1,4) and is_logged_in=0 and disposition_id in(2,3,4,5) And ". $assToCond ;
			$data['total_leave'] = $this->Common_model->get_total("signin b",$cond);
			
			$qSQL="SELECT count(*) as total FROM terminate_users_pre, signin b where user_id=b.id and action_status = 'P' And ". $assToCond ;
			
			$data['total_ncns_req'] = $this->Common_model->get_total2($qSQL);
			
			$qSQL="SELECT count(id) as total FROM signin b where status = 2 And ". $assToCond ;
			$data['total_term_sub'] = $this->Common_model->get_total2($qSQL);
			
			$qSQL="SELECT count(user_id) as total FROM suspended_users, signin b where user_id=b.id and is_complete = 'N' And  $assToCond ";
			
			$data['total_suspended'] = $this->Common_model->get_total2($qSQL);
			
			$data['filter_id'] = $filter_id;
			
			//$mCond=" and site_id='".$user_site_id."' and assigned_to=".$current_user." ".$_filterCond;
			//$mCond=" And (site_id='$user_site_id' OR office_id='$user_office_id') And assigned_to=".$current_user." ".$_filterCond;
			
			$mCond=" And ".$assToCond." ".$_filterCond;
			//////////////////////////////////////////////////
			
			if($filter_id==1) $data['user_list'] = $this->Common_model->get_user_list("All",$mCond);	
			else if($filter_id==2) $data['user_list'] = $this->Common_model->get_user_list("ONLINE",$mCond);	
			else if($filter_id==3){
				//$mCond=" disposition_id =0";
				$data['user_list'] = $this->Common_model->get_user_list("OFFLINE",$mCond);
			}else if($filter_id==4){
				//$mCond=" and disposition_id in(2,3,4,5) And (site_id='$user_site_id' OR office_id='$user_office_id') And assigned_to=".$current_user." ".$_filterCond;
				$mCond=" and disposition_id in(2,3,4,5) And ".$assToCond." ".$_filterCond;
				
				$data['user_list'] = $this->Common_model->get_user_list("OFFLINE",$mCond);	
				
			
			}else if($filter_id==5){
							
								
				$qSql="SELECT a.*,fusion_id,office_id,dept_id,fname,lname,role_id,omuid,is_logged_in,status, get_client_names(b.id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role k  where k.id=b.role_id) as role_name FROM terminate_users_pre a , signin b where a.user_id=b.id and a.action_status = 'P' $mCond ";
								
				$data['user_list'] = $this->Common_model->get_query_result_array($qSql);	
			
			}else if($filter_id==6){
								
				$qSql="select * from (select * from (SELECT id,fusion_id,office_id,dept_id,xpoid,omuid,fname,lname,role_id,site_id,status,assigned_to, get_client_names(b.id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from event_master k where k.id=b.disposition_id) as disp_name, get_process_names(b.id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name FROM signin b where b.status = 2)xx , (select t_type, sub_t_type, lwd, terms_date,comments, user_id as duid, (Select CONCAT(fname,' ' ,lname) from signin ts where ts.id=t.terms_by) as raised_by, (Select name from master_term_type mtt where mtt.id=t.t_type) as t_type_name, (Select name from master_sub_term_type mstt where mstt.id=t.sub_t_type) as sub_t_type_name from terminate_users t where is_term_complete='N') d  where xx.id=d.duid  $mCond ) yy LEFT JOIN ( select max(logout_time) as llogout_time,user_id from logged_in_details group by user_id) c on (yy.id=c.user_id)";
				
				//echo $qSql;
				
				$data['user_list'] = $this->Common_model->get_query_result_array($qSql);	
				
			
			}else if($filter_id==7){
				
				$qSql="SELECT a.*,(Select CONCAT(fname,' ' ,lname) from signin es where es.id=a.evt_by) as evt_by_name, fusion_id,xpoid,office_id,disposition_id, fname,lname,role_id,omuid,is_logged_in,status,assigned_to, get_client_names(b.id) as client_name, get_client_ids(b.id) as client_ids, (Select shname from department s where s.id=b.dept_id) as dept_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role k  where k.id=b.role_id) as role_name, (Select name from event_master k where k.id=b.disposition_id) as disp_name, get_process_names(b.id) as process_name,  (Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name FROM suspended_users a , signin b where a.user_id=b.id and a.is_complete = 'N' $mCond ";
				
				$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
				
			}else if($filter_id==8){
			
			
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("SCHEDULE",$mCond);
				
				
			}else if($filter_id==9){
				
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("ONBREAK",$mCond);
			
			}else{
				
				//$mCond=" and disposition_id =1 And (site_id='$user_site_id' OR office_id='$user_office_id') And assigned_to=".$current_user." ".$_filterCond;
				
				$mCond=" and role_id>0 and disposition_id =1 And ".$assToCond." ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("MIA",$mCond);	
			}
						
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			
			$currDate=CurrDate();	
			if(date('D', strtotime($currDate)) == "Mon") $shMonDate=$currDate;
			else $shMonDate=date('Y-m-d',strtotime($currDate.' -1 Monday'));
			if(date('D', strtotime($currDate)) == "Sun") $shSunDate=$currDate;
			else $shSunDate=date('Y-m-d',strtotime($currDate.' +1 Sunday'));
							
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
	
}

?>