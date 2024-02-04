<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {
    
    private $aside = "manager/aside.php";
	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
    
    public function index()
    {
		
			
        $this->Common_model->auto_disposition_update();
		
		$this->user_model->auto_logout_after_hrs();
			
		if(check_logged_in())
        {
			if(get_login_type() == "client") redirect(base_url().'client',"refresh");
			
            $filter_id=$this->uri->segment(3);
			
			$current_user = get_user_id();
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$ses_client_ids=get_client_ids();
			$ses_process_ids=get_process_ids();
			
			$user_oth_office=get_user_oth_office();
						
			/*
			if($user_site_id==""){
				echo "<center><br><b>Please login again</b></center>";
				exit();
			}
			*/
			//echo "filter_id :: " . $filter_id;
			
			if(get_role_dir()!="manager") redirect(base_url().get_role_dir()."/dashboard","refresh");
			
			$data["aside_template"] = get_aside_template();
            $data["content_template"] = "manager/dashboard.php";
            
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			if($dValue=="") $dValue=$ses_dept_id;
			//$dValue=$ses_dept_id;
			
			if($oValue=="") $oValue=$user_office_id;
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			$data['dValue']=$dValue;
			$data['oValue']=$oValue;
			
			$_filterCond="";
			
			
			//$_filterCond=" And role_id not in (0,1,11,17) And dept_id='$ses_dept_id'  And (site_id='$user_site_id' OR office_id='$user_office_id') ";
			//$_filterCond=" And role_id not in (0,1,11,17) And dept_id='$ses_dept_id'  And (site_id='$user_site_id' OR office_id='$user_office_id') ";			
			//$_filterCond=" And role_id not in (0) And (site_id='$user_site_id' OR office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
			//$_filterCond = " and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%')) ";
			
			
			//$_filterCond = " (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%')) ";
			
			$officeCond="";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " office_id='".$oValue."'";
				else $_filterCond .= " office_id='".$oValue."'";
				
				$officeCond = "  And office_id='".$oValue."'";
				
			}
			
			
			
			//$_filterCond .= " and dept_id='$ses_dept_id' ";
			
			$deptCond="";
			
			if($dValue!="ALL" && $dValue!=""){
				$_filterCond .= " And dept_id='".$dValue."'";
				$deptCond =  " And dept_id='".$dValue."'";
				
			}
			
			$clientCond="";
			
			//if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
			if($cValue!="ALL" && $cValue!=""){
				$_filterCond .= " And is_assign_client (b.id,$cValue)";
				$clientCond = " And is_assign_client (b.id,$cValue)";
			}
			
			$processCond="";
			
			//if($pValue!="ALL" && $pValue!="") $_filterCond .= " And process_id='".$pValue."'";
			if($pValue!="ALL" && $pValue!="" && $pValue!="0"){
				$_filterCond .= " And is_assign_process(b.id,$pValue)";
				$processCond = " And is_assign_process(b.id,$pValue)";
			}
			
			
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			
			if(get_dept_folder()=="rta" || get_dept_folder()=="wfm" || is_all_dept_access() ){
				
				$data['department_list'] = $this->Common_model->get_department_list();
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			}
			
			
			$assToCond ="";
			
			if(is_all_dept_access() == true){
				
				$assToCond = "  $officeCond $deptCond $clientCond $processCond ";
								
			}else{
				if(get_dept_folder()=="operations"){
					$assToCond = " AND ((assigned_to='$current_user' OR (is_assign_process(b.id,'$ses_process_ids')=1 AND dept_id='$ses_dept_id') OR (assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' ))) ) $officeCond $deptCond $clientCond $processCond ) ";
				}else{
					
					$assToCond = " AND ((dept_id='$ses_dept_id') $officeCond $deptCond $clientCond $processCond ) ";
					
				}
			}
						
			//$_filterCond = "  ( ".$_filterCond . " OR " . $assToCond .") ";
			$_filterCond = " And role_id in (SELECT id FROM role where folder !='super') ";
			$_filterCond .= "  $assToCond ";
				
			////////////
						
			$qSql="Select id,name from master_term_type where is_active=1";
			$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,name from master_sub_term_type where is_active=1";
			$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from master_resign_reason where is_active=1";
			$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			$data['disp_list'] = $this->Common_model->get_event_for_assign();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			if($pValue!="" && $pValue!="ALL") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
			else $data['sub_process_list']=array();
			
			$cond= " Where status in (1,4) $_filterCond ";	
						
			$data['total_agent'] = $this->Common_model->get_total("signin b",$cond);
						
			$cond= " where status in (1,4) And is_logged_in=0 $_filterCond ";	
			$data['total_offline'] = $this->Common_model->get_total("signin b",$cond);
						
			$cond= " where status in (1,4) And is_logged_in=1 $_filterCond ";	
			$data['total_online'] = $this->Common_model->get_total("signin b",$cond);
						
			$cond= " where status in (1,4) And is_logged_in=0 and disposition_id in(2,3,4,5)  $_filterCond ";	
			$data['total_leave'] = $this->Common_model->get_total("signin b",$cond);
			
			$qSQL="SELECT count(*) as total FROM terminate_users_pre, signin b where user_id=b.id and action_status = 'P' $_filterCond ";	
			$data['total_ncns_req'] = $this->Common_model->get_total2($qSQL);
			
			$qSQL="SELECT count(user_id) as total FROM suspended_users, signin b where user_id=b.id and is_complete = 'N' $_filterCond ";
			$data['total_suspended'] = $this->Common_model->get_total2($qSQL);
			
			$qSQL="SELECT count(id) as total FROM signin b where status = 2  $_filterCond ";
			
			//echo $qSQL . "\r\n\r\n";
			
			$data['total_term_sub'] = $this->Common_model->get_total2($qSQL);
			
			
			$data['filter_id'] = $filter_id;
			
			
			//////////////////////////////////////////////////
			
			if($filter_id==1) $data['user_list'] = $this->Common_model->get_user_list("All",$_filterCond);	
			else if($filter_id==2) $data['user_list'] = $this->Common_model->get_user_list("ONLINE",$_filterCond);	
			else if($filter_id==3){
				$data['user_list'] = $this->Common_model->get_user_list("OFFLINE",$_filterCond);
			}else if($filter_id==4){
				$mCond=" and disposition_id in(2,3,4,5) ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("OFFLINE",$mCond);	
			}else if($filter_id==5){
												
								
				//$qSql="SELECT a.*,fusion_id,office_id,dept_id,fname,lname,role_id,omuid, is_logged_in,status, (Select shname from client m where m.id=b.client_id) as client_name, (Select shname from department s where s.id=b.dept_id) as dept_name, (Select name from process y where y.id=b.process_id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name FROM terminate_users_pre a , signin b where a.user_id=b.id and a.action_status = 'P' $_filterCond ";
				
				$qSql="SELECT a.*,fusion_id,office_id,dept_id,fname,lname,role_id,omuid, is_logged_in,status, get_client_names(b.id) as client_name, (Select shname from department s where s.id=b.dept_id) as dept_name, get_process_names(b.id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name FROM terminate_users_pre a , signin b where a.user_id=b.id and a.action_status = 'P' $_filterCond ";
									
				$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
			
			}else if($filter_id==6){
								
								
				//$qSql="select * from (SELECT id,fusion_id,office_id,dept_id,omuid,fname,lname,role_id,site_id,process_id,status,assigned_to, (Select shname from client m where m.id=b.client_id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name, (Select name from event_master k where k.id=b.disposition_id) as disp_name,(Select name from process y where y.id=b.process_id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name FROM signin b where b.status = 2 )xx , (select terms_date,comments,user_id as duid from terminate_users where is_term_complete='N') d,( select max(logout_time) as llogout_time,user_id from logged_in_details group by user_id) c where xx.id=d.duid and xx.id=c.user_id $_filterCond ";
				
				//$qSql="select * from (SELECT id,fusion_id,office_id,dept_id,omuid,fname,lname,role_id,site_id,process_id,status,assigned_to, get_client_names(b.id) as client_name, (Select shname from department s where s.id=b.dept_id) as dept_name, (Select name from event_master k where k.id=b.disposition_id) as disp_name, get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name FROM signin b where b.status = 2 )xx , (select terms_date,comments,user_id as duid from terminate_users where is_term_complete='N') d,( select max(logout_time) as llogout_time,user_id from logged_in_details group by user_id) c where xx.id=d.duid and xx.id=c.user_id $_filterCond ";
				
				$qSql="select * from (select * from (SELECT id,fusion_id,office_id,dept_id,xpoid,omuid,fname,lname,role_id,site_id,status,assigned_to, get_client_names(s.id) as client_name,(Select shname from department d where d.id=s.dept_id) as dept_name,(Select name from sub_department sd where sd.id=s.sub_dept_id) as sub_dept_name,(Select name from event_master k where k.id=s.disposition_id) as disp_name, get_process_names(s.id) as process_name,(Select name from sub_process l where l.id=s.sub_process_id) as sub_process_name, (Select name from site z  where z.id=s.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=s.assigned_to) as asign_tl, (Select name from role a  where a.id=s.role_id) as role_name FROM signin s where s.status = 2) b , (select t_type, sub_t_type, lwd, terms_date,comments, user_id as duid, (Select CONCAT(fname,' ' ,lname) from signin ts where ts.id=t.terms_by) as raised_by, (Select name from master_term_type mtt where mtt.id=t.t_type) as t_type_name, (Select name from master_sub_term_type mstt where mstt.id=t.sub_t_type) as sub_t_type_name from terminate_users t where is_term_complete='N') trm  where b.id=trm.duid  $_filterCond ) yy LEFT JOIN ( select max(logout_time) as llogout_time,user_id from logged_in_details group by user_id) c on (yy.id=c.user_id)";
				
				//echo $qSql . "\r\n\r\n";
				
				$data['user_list'] = $this->Common_model->get_query_result_array($qSql);	
				
			
			}else if($filter_id==7){
				
				$qSql="SELECT a.*,(Select CONCAT(fname,' ' ,lname) from signin es where es.id=a.evt_by) as evt_by_name, fusion_id,xpoid,office_id,disposition_id, fname,lname,role_id,omuid,is_logged_in,status,assigned_to, get_client_names(b.id) as client_name, get_client_ids(b.id) as client_ids, (Select shname from department s where s.id=b.dept_id) as dept_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role k  where k.id=b.role_id) as role_name, (Select name from event_master k where k.id=b.disposition_id) as disp_name, get_process_names(b.id) as process_name,  (Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name FROM suspended_users a , signin b where a.user_id=b.id and a.is_complete = 'N' $_filterCond ";
				
				$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
				
			}else if($filter_id==8){
			
			
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("SCHEDULE",$mCond);
				
				
			}else if($filter_id==9){
				
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("ONBREAK",$mCond);
			
			}else{
				$mCond=" and role_id>0 and disposition_id =1 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("MIA",$mCond);	
			}
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			
            $this->load->view('dashboard',$data);
        }
    }
		   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // USERS - METHODS
    /////////////////////////////////////////////////////////////////////////////////////////////
  
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