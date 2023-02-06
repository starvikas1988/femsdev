<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
    
      
	  
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$this->load->model('Email_model');
		
    }
	
	//public function get_user_list($_listOnly,$_min_logged_hour,$tl_id,$moreCond)
	
	public function get_user_list($_listOnly,$moreCond)
    {
		//echo 	$_listOnly . $_min_logged_hour . $tl_id . $moreCond;
		//if($_min_logged_hour=="") $_min_logged_hour=8;
		//if($_min_logged_hour===0) $_min_logged_hour=8;
		
		$todayDate=CurrDate();
		$currDay=strtolower(date('D', strtotime($todayDate)));		
		if(date('D', strtotime($todayDate)) == "Sun") $shSunDate=$todayDate;
		else $shSunDate=date('Y-m-d',strtotime($todayDate.' -1 Sunday'));
		if(date('D', strtotime($todayDate)) == "Sat") $shSatDate=$todayDate;
		else $shSatDate=date('Y-m-d',strtotime($todayDate.' +1 Saturday'));
				
		$shCond = " and b.id in (Select user_id from user_shift_schedule where start_date='$shSunDate' and end_date='$shSatDate' and shday='$currDay' and in_time not like '%OFF%' and in_time not like '%LEAVE%') ";
		
		$_cnd="";
		
		if($_listOnly=="ONLINE") $_cnd=" and is_logged_in=1";
		else if($_listOnly=='OFFLINE') $_cnd=" and is_logged_in=0";
		else if($_listOnly=='LOGGEDIN') $_cnd=" and is_logged_in=1 and TimeStampDiff(MINUTE,last_logged_date,Now())/60 >=9";
		else if($_listOnly=='SCHEDULE') $_cnd= $shCond;
		else if($_listOnly=='ONBREAK') $_cnd=" and (is_break_on=1 OR is_break_on_ld=1) ";
		else if($_listOnly=='MIA') $_cnd=" and is_logged_in=0 ";
		
		$_cnd2="";
						
		if($moreCond=="" || $moreCond=="ALL") $_cnd3="";
		else $_cnd3= $moreCond;
				
		$todayDate=CurrDate();
			
		
		//$qSQL="select * from (select *,(Select name from event_master y where y.id=b.disposition_id) as disp_name,(Select name from process y where y.id=b.process_id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, timediff(Now(),last_logged_date) as loggedHour from signin b where status = 1 ".$_cnd .$_cnd2 .$_cnd3 .") xx LEFT JOIN (select user_id,timediff(logout_time,login_time) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."') yy on (xx.id=yy.user_id) ";
		
		//$qSQL="select * from (((select *,(Select shname from client m where m.id=b.client_id) as client_name,(Select name from event_master y where y.id=b.disposition_id) as disp_name,(Select name from process k where k.id=b.process_id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, timediff(Now(),last_logged_date) as loggedHour from signin b where status = 1 ".$_cnd .$_cnd2 .$_cnd3 .") xx LEFT JOIN (select user_id,timediff(logout_time,login_time) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."') yy on (xx.id=yy.user_id)) LEFT JOIN (select start_date,end_date,user_id as duid from event_disposition where start_date <= '".$todayDate."' and end_date >= '".$todayDate."') d on (xx.id=d.duid)) LEFT JOIN ( select user_id as ptuid, is_update, term_time, action_status from terminate_users_pre where action_status='P' ) zz on (xx.id=zz.ptuid)";
		
		//Bakup Date 21-01-2022

		//$qSQL="select * from (((select *,get_client_names(b.id) as client_name, get_client_ids(b.id) as client_ids, (Select name from event_master y where y.id=b.disposition_id) as disp_name, (Select name from site s where s.id=b.site_id) as site_name, get_process_names(b.id) as process_name, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, timediff(Now(),last_logged_date) as loggedHour from signin b where status in(1,4) ".$_cnd .$_cnd2 .$_cnd3 .") xx LEFT JOIN (select user_id, min(login_time_local) as flogin_time_local, max(logout_time_local) as llogout_time_local, sum(TIME_TO_SEC(timediff(login_time_local,logout_time_local))) as tLtime from logged_in_details where date(login_time_local) = '".$todayDate."' group by user_id) yy on (xx.id=yy.user_id)) LEFT JOIN (select start_date,end_date,user_id as duid from event_disposition where start_date <= '".$todayDate."' and end_date >= '".$todayDate."' group by duid ) d on (xx.id=d.duid)) LEFT JOIN ( select user_id as ptuid, is_update, term_time, action_status from terminate_users_pre where action_status='P' ) zz on (xx.id=zz.ptuid) LEFT JOIN ( select user_id as shuid, in_time,out_time,shdate,shday from user_shift_schedule where shdate='$todayDate' and shday='$currDay' ) ush on (xx.id=ush.shuid) ";

		$qSQL="select * from (((select *,get_client_names(b.id) as client_name, get_client_ids(b.id) as client_ids, (Select name from event_master y where y.id=b.disposition_id) as disp_name, (Select name from site s where s.id=b.site_id) as site_name, get_process_names(b.id) as process_name, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, timediff(Now(),last_logged_date) as loggedHour , (select process_movement_date from info_personal ip where ip.user_id=b.id) as process_date from signin b where status in(1,4) ".$_cnd .$_cnd2 .$_cnd3 .") xx LEFT JOIN (select user_id, min(login_time_local) as flogin_time_local, max(logout_time_local) as llogout_time_local, sum(TIME_TO_SEC(timediff(login_time_local,logout_time_local))) as tLtime from logged_in_details where date(login_time_local) = '".$todayDate."' group by user_id) yy on (xx.id=yy.user_id)) LEFT JOIN (select start_date,end_date,user_id as duid from event_disposition where start_date <= '".$todayDate."' and end_date >= '".$todayDate."' group by duid ) d on (xx.id=d.duid)) LEFT JOIN ( select user_id as ptuid, is_update, term_time, action_status from terminate_users_pre where action_status='P' ) zz on (xx.id=zz.ptuid) LEFT JOIN ( select user_id as shuid, in_time,out_time,shdate,shday from user_shift_schedule where shdate='$todayDate' and shday='$currDay' ) ush on (xx.id=ush.shuid) ";
				
		if($_listOnly=='MIA') {
			$qSQL="Select * from (".$qSQL.") skt Where tLtime is null  Order By fname, lname";
		}else{
			$qSQL="Select * from (".$qSQL.") skt Order By fname, lname";
		}
		
		//and cast(logout_time as date) >= '".$todayDate."'
		
		//echo $qSQL."\r\n";die;
		
		$query = $this->db->query($qSQL);
		return $query->result_array();
		
    }

//////////////////////////////////////////////////////////

	public function get_user_break_details($_listOnly,$moreCond,$office_id="")
	{
		
		$_cnd="";
		
		if($_listOnly=='ONBREAK') $_cnd=" and s.is_logged_in=1 and (s.is_break_on_ld=1 or s.is_break_on=1)";
		else if($_listOnly=="ONLINE") $_cnd=" and s.is_logged_in=1";
		else if($_listOnly=='OFFLINE') $_cnd=" and s.is_logged_in=0";
		else $_cnd="";
				
		if($moreCond=="" || $moreCond=="ALL") $_cnd2="";
		else $_cnd2= $moreCond;
		
		$todayDate=CurrDate();
		
//		IF($office_id !="MAN"){
	
			if($office_id!="" && $office_id!="ALL") $todayDate = GetLocalDateByOffice($office_id);
			else $todayDate=CurrDate();
			
//		}
		
		/*
		$qSql="SELECT * from (
				(select s.*, getTodayLoginTime(s.id) as todayLoginTime , getTodayStaffTime(s.id) as todayStaffTime, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select concat(fname, ' ', lname) from signin x where x.id=s.assigned_to) as assigned_name, DATE_FORMAT(s.last_break_on_time_ld, '%H:%i:%s') as last_break_ld, DATE_FORMAT(s.last_break_on_time, '%H:%i:%s') as last_break_oth  FROM signin s WHERE s.status=1  ".$_cnd .$_cnd2 ." order by is_break_on desc, is_break_on_ld desc, is_logged_in desc, fusion_id ) xx 
				Left Join
				(select oth.user_id as oth_uid, count(oth.user_id) as cnt_oth_uid, DATE_FORMAT(max(oth.out_time), '%H:%i:%s') as oth_outtime, DATE_FORMAT(max(oth.in_time),'%H:%i:%s') as oth_intime, SUM(TIME_TO_SEC(TIMEDIFF(oth.in_time, oth.out_time))) as total_oth_diff from break_details oth where date(oth.out_time)='$todayDate' group by oth.user_id ) yy ON
				(xx.id=yy.oth_uid)
				Left Join
				(select ld.user_id as ld_uid, count(ld.user_id) as cnt_ld_uid, DATE_FORMAT(max(ld.out_time), '%H:%i:%s') as ld_outtime, DATE_FORMAT(max(ld.in_time), '%H:%i:%s') as ld_intime, SUM(TIME_TO_SEC(TIMEDIFF(ld.in_time, ld.out_time)) ) as total_ld_diff from break_details_ld ld where date(ld.out_time)='$todayDate' group by ld.user_id) zz ON
				(xx.id=zz.ld_uid))";
		*/
		
		/*
		
		$qSql="SELECT * from (
				(select s.*, getTodayLoginTime(s.id) as todayLoginTime , getTodayStaffTime(s.id) as todayStaffTime, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select concat(fname, ' ', lname) from signin x where x.id=s.assigned_to) as assigned_name, DATE_FORMAT(s.last_break_on_time_ld, '%H:%i:%s') as last_break_ld, DATE_FORMAT(s.last_break_on_time, '%H:%i:%s') as last_break_oth  FROM signin s WHERE s.status in (1,4)  ".$_cnd .$_cnd2 ." order by is_break_on desc, is_break_on_ld desc, is_logged_in desc, fusion_id ) xx 
				Left Join
				(select oth.user_id as oth_uid, count(oth.user_id) as cnt_oth_uid, DATE_FORMAT(getEstToLocal(max(oth.out_time),oth.user_id), '%H:%i:%s') as oth_outtime, DATE_FORMAT(getEstToLocal(max(oth.in_time),oth.user_id), '%H:%i:%s') as oth_intime, SUM(TIME_TO_SEC(TIMEDIFF(oth.in_time, oth.out_time))) as total_oth_diff from break_details oth where date(getEstToLocal(oth.out_time,oth.user_id)) ='$todayDate' group by oth.user_id ) yy ON
				(xx.id=yy.oth_uid)
				Left Join
				(select ld.user_id as ld_uid, count(ld.user_id) as cnt_ld_uid, DATE_FORMAT(getEstToLocal(max(ld.out_time),ld.user_id), '%H:%i:%s') as ld_outtime, DATE_FORMAT(getEstToLocal(max(ld.in_time),ld.user_id), '%H:%i:%s')  as ld_intime, SUM(TIME_TO_SEC(TIMEDIFF(ld.in_time, ld.out_time)) ) as total_ld_diff from break_details_ld ld where date(getEstToLocal(ld.out_time,ld.user_id)) = '$todayDate' group by ld.user_id) zz ON
				(xx.id=zz.ld_uid)) Order by office_id, is_break_on desc, is_break_on_ld desc , is_logged_in desc";
				
			*/
				
			$qSql="SELECT * from (
				(select s.*, getTodayLoginTime(s.id) as todayLoginTime , getTodayStaffTime(s.id) as todayStaffTime, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select concat(fname, ' ', lname) from signin x where x.id=s.assigned_to) as assigned_name, DATE_FORMAT(s.last_break_on_time_ld, '%H:%i:%s') as last_break_ld, DATE_FORMAT(s.last_break_on_time, '%H:%i:%s') as last_break_oth  FROM signin s WHERE s.status in (1,4)  ".$_cnd .$_cnd2 ." order by is_break_on desc, is_break_on_ld desc, is_logged_in desc, fusion_id ) xx 
				Left Join
				(select oth.user_id as oth_uid, count(oth.user_id) as cnt_oth_uid, DATE_FORMAT(max(oth.out_time_local), '%H:%i:%s') as oth_outtime, DATE_FORMAT(max(oth.in_time_local), '%H:%i:%s') as oth_intime, SUM(TIME_TO_SEC(TIMEDIFF(oth.in_time, oth.out_time))) as total_oth_diff from break_details oth where date(oth.out_time_local) ='$todayDate' group by oth.user_id ) yy ON
				(xx.id=yy.oth_uid)
				Left Join
				(select ld.user_id as ld_uid, count(ld.user_id) as cnt_ld_uid, DATE_FORMAT(max(ld.out_time_local), '%H:%i:%s') as ld_outtime, DATE_FORMAT(max(ld.in_time_local), '%H:%i:%s')  as ld_intime, SUM(TIME_TO_SEC(TIMEDIFF(ld.in_time, ld.out_time)) ) as total_ld_diff from break_details_ld ld where date(ld.out_time_local) = '$todayDate' group by ld.user_id) zz ON
				(xx.id=zz.ld_uid)) Order by office_id, is_break_on desc, is_break_on_ld desc , is_logged_in desc";
				
		
		//echo $qSql;		
		
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
/////////////////////////////////////////////	
	
/////////////////////////////////////////////////////////////////////////////
	

	public function get_manage_ulist($moreCond, $date_search="")
    {
		
		if($moreCond!="") $moreCond =" WHERE ".$moreCond;
		
		//$qSQL="select * from (Select b.*,(Select shname from client m where m.id=b.client_id) as client_name,(Select name from event_master y where y.id=b.disposition_id) as disp_name ,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from process k where k.id=b.process_id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name from signin b ".$moreCond .") xx LEFT JOIN ( select user_id, is_update, term_time, action_status from terminate_users_pre where action_status='P' ) yy on (xx.id=yy.user_id) Order By fname";
		
		 //$qSQL="select * from (Select b.*,b.id as uid,get_client_names(b.id) as client_name,(Select name from event_master y where y.id=b.disposition_id) as disp_name ,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select name from role_organization m where m.id=b.org_role_id) as org_name, (Select name from master_emp_status mes where mes.id=b.emp_status) as employee_status, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name from signin b ".$moreCond .") xx LEFT JOIN ( select user_id, is_update, term_time, action_status from terminate_users_pre where action_status='P' ) yy on (xx.id=yy.user_id) left join (select * from info_personal) zz on (xx.id=zz.user_id) Left Join (select user_id, is_term_complete, terms_date from terminate_users where is_term_complete='Y') ww ON (xx.id=ww.user_id) Order By fname ";
		 //, email_id_off, email_id_per

		//date 25-01-2022
		 		 
		  //$qSQL="select *, (Select name from master_payroll_type mpt where mpt.id=ipr.payroll_type) as payroll_type_name from (Select b.*,b.id as uid,get_client_names(b.id) as client_name,(Select name from event_master y where y.id=b.disposition_id) as disp_name ,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_process_names(b.id) as process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select name from role_organization m where m.id=b.org_role_id) as org_name, (Select name from master_emp_status mes where mes.id=b.emp_status) as employee_status, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name from signin b ".$moreCond .") xx LEFT JOIN ( select user_id, is_update, term_time, action_status from terminate_users_pre where action_status='P' ) yy on (xx.id=yy.user_id) Left Join (select user_id, is_term_complete, max(terms_date) as terms_date from terminate_users where is_term_complete='Y' group by user_id ) ww ON (xx.id=ww.user_id) Left Join (select user_id, is_on_furlough, max(furlough_date) as furlough_date, max(expiry_date) as furlough_expiry_date  from user_furlough where is_on_furlough='Y' group by user_id ) ff ON (xx.id=ff.user_id) Left Join (select user_id, is_on_bench, max(bench_date) as bench_date , max(expiry_date) as bench_expiry_date from user_bench where is_on_bench='Y' group by user_id ) bb ON (xx.id=bb.user_id) Left Join (select user_id, is_complete, max(from_date) as susp_date, max(to_date) as susp_expiry_date from suspended_users where is_complete='N' group by user_id ) sp ON (xx.id=sp.user_id) LEFT JOIN info_personal iper on iper.user_id=xx.id LEFT JOIN info_payroll ipr ON ipr.user_id=xx.id Order By fname ";
		
		$qSQL="select *,(Select name from master_payroll_type mpt where mpt.id=ipr.payroll_type) as payroll_type_name from (Select b.*,b.id as uid,get_client_names(b.id) as client_name,(Select name from event_master y where y.id=b.disposition_id) as disp_name ,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_process_names(b.id) as process_name, (select process_movement_date from info_personal ip where ip.user_id=b.id) as process_date, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select name from role_organization m where m.id=b.org_role_id) as org_name, (Select name from master_emp_status mes where mes.id=b.emp_status) as employee_status, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name,(Select mc.name from master_company mc  where mc.id=b.brand)as company_brand_name from signin b ".$moreCond .") xx LEFT JOIN ( select user_id, is_update, term_time, action_status from terminate_users_pre where action_status='P' ) yy on (xx.id=yy.user_id) Left Join (select user_id, is_term_complete, max(terms_date) as terms_date from terminate_users where is_term_complete='Y' group by user_id ) ww ON (xx.id=ww.user_id) Left Join (select user_id, is_on_furlough, max(furlough_date) as furlough_date, max(expiry_date) as furlough_expiry_date  from user_furlough where is_on_furlough='Y' group by user_id ) ff ON (xx.id=ff.user_id) Left Join (select user_id, is_on_bench, max(bench_date) as bench_date , max(expiry_date) as bench_expiry_date from user_bench where is_on_bench='Y' group by user_id ) bb ON (xx.id=bb.user_id) Left Join (select user_id, is_complete, max(from_date) as susp_date, max(to_date) as susp_expiry_date from suspended_users where is_complete='N' group by user_id ) sp ON (xx.id=sp.user_id) LEFT JOIN info_personal iper on iper.user_id=xx.id LEFT JOIN (select id,is_loi from dfr_candidate_details) dcd ON dcd.id=xx.dfr_id LEFT JOIN info_payroll ipr ON ipr.user_id=xx.id ".$date_search." Order By fname ";
		
		//echo $qSQL; exit;
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	
	public function get_audit_list($condArray)
    {
		
		$is_global_access=get_global_access();
		
		$client_id=$condArray['client_id'];
		$site_id=$condArray['site_id'];
		$office_id=$condArray['office_id'];
		$process_id=$condArray['process_id'];
		$sub_process_id=$condArray['sub_process_id'];
		$role_id=$condArray['role_id'];
		$user_role_id=$condArray['user_role_id'];
		$user_site_id=$condArray['user_site_id'];
		
		
		
		$Cond1="";
		$Cond2="";
			
		if($client_id!="ALL" && $client_id!=""){
			//$Cond1 = " client_id='".$client_id."'";
			$Cond1 = " is_assign_client (b.id,$client_id)";
		}
		
		if($process_id!="ALL" && $process_id!="" && $process_id!="0"){
				//if($Cond1=="") $Cond1 .= " process_id='".$process_id."'";
				//else $Cond1 .= " And process_id='".$process_id."'";
				
				if($Cond1=="") $Cond1 .= " is_assign_process(b.id,$process_id)";
				else $Cond1 .= " And is_assign_process(b.id,$process_id)";
				
		}
		
		if($sub_process_id!="ALL" && $sub_process_id!=""){
			if($Cond1=="") $Cond1 .= " sub_process_id='".$sub_process_id."'";
			else $Cond1 .= " And sub_process_id='".$sub_process_id."'";
		}
			
		if($site_id!="ALL" && $site_id!=""){
			if($Cond2=="") $Cond2 .= " site_id='".$site_id."'";
			else $Cond2 .= " And site_id='".$site_id."'";
		}
			
		if($office_id!="ALL" && $office_id!=""){
			if($Cond2=="") $Cond2 .= " office_id='".$office_id."'";
			else $Cond2 .= " And office_id='".$office_id."'";
		}
		
		if($role_id!="ALL" && $role_id!=""){
			if($Cond2=="") $Cond2 .= " role_id='".$role_id."'";
			else $Cond2 .= " And role_id='".$role_id."'";
		}
		
				
		if(get_role_dir()!="super" && $user_site_id!="" && $is_global_access!=1){
			if($Cond2=="") $Cond2 .= " site_id='$user_site_id'";	
			else $Cond2 .= " And site_id='$user_site_id'";	
		}	
		
		
		if($Cond1!="") $Cond1 =" WHERE ".$Cond1;
		if($Cond2!="") $Cond2 =" WHERE ".$Cond2;
		
		//$qSQL="select * from (((Select b.*,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name from signin b ".$Cond2 .") xx INNER JOIN (select d.*,audit_id as auditrowid, (Select shname from client m where m.id=d.client_id) as client_name, (Select name from process k where k.id=d.process_id) as process_name, (Select name from sub_process l where l.id=d.sub_process_id) as sub_process_name from audit_info d $Cond1 ) yy on xx.id=yy.agent_id) LEFT JOIN audit_score zz on yy.audit_id=zz.audit_id) LEFT JOIN (select e.*,(Select CONCAT(fname,' ' ,lname) from signin k where k.id=e.coach_id) as coach_name from coaching e ) cc on yy.audit_id=cc.audit_id Order By yy.audit_id ";
		
		$qSQL="select * from (((Select b.*,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name from signin b ".$Cond2 .") xx INNER JOIN (select d.*,audit_id as auditrowid, (Select shname from client m where m.id=d.client_id) as client_name, (Select name from process k where k.id=d.process_id) as process_name, (Select name from sub_process l where l.id=d.sub_process_id) as sub_process_name from audit_info d $Cond1 ) yy on xx.id=yy.agent_id) LEFT JOIN audit_score zz on yy.audit_id=zz.audit_id) Order By yy.audit_id ";
		
		//$qSqlC="select e.*,(Select CONCAT(fname,' ' ,lname) from signin k where k.id=e.coach_id) as coach_name from coaching e  Order By audit_id ";
				
		$query = $this->db->query($qSQL);
		
		return $query->result_array();
		
    }
	
	
	public function get_audit_coaching_list($condArray)
    {
		
		$is_global_access=get_global_access();
		
		$client_id=$condArray['client_id'];
		$site_id=$condArray['site_id'];
		$office_id=$condArray['office_id'];
		$process_id=$condArray['process_id'];
		$sub_process_id=$condArray['sub_process_id'];
		$role_id=$condArray['role_id'];
		$user_role_id=$condArray['user_role_id'];
		
		$user_site_id=$condArray['user_site_id'];
		
		$Cond1="";
		$Cond2="";
			
		if($client_id!="ALL" && $client_id!=""){
			//$Cond1 = " client_id='".$client_id."'";
			$Cond1 = " is_assign_client (b.id,$client_id)";
		}
		
		if($process_id!="ALL" && $process_id!="" && $process_id!="0"){
				//if($Cond1=="") $Cond1 .= " process_id='".$process_id."'";
				//else $Cond1 .= " And process_id='".$process_id."'";
				
				if($Cond1=="") $Cond1 .= " is_assign_process(b.id,$process_id)";
				else $Cond1 .= " And is_assign_process(b.id,$process_id)";
				
		}
		if($sub_process_id!="ALL" && $sub_process_id!=""){
			if($Cond1=="") $Cond1 .= " sub_process_id='".$sub_process_id."'";
			else $Cond1 .= " And sub_process_id='".$sub_process_id."'";
		}
			
		if($site_id!="ALL" && $site_id!=""){
			if($Cond2=="") $Cond2 .= " site_id='".$site_id."'";
			else $Cond2 .= " And site_id='".$site_id."'";
		}
			
		if($office_id!="ALL" && $office_id!=""){
			if($Cond2=="") $Cond2 .= " office_id='".$office_id."'";
			else $Cond2 .= " And office_id='".$office_id."'";
		}
		
		if($role_id!="ALL" && $role_id!=""){
			if($Cond2=="") $Cond2 .= " role_id='".$role_id."'";
			else $Cond2 .= " And role_id='".$role_id."'";
		}
		
		if(get_role_dir()!="super" && $user_site_id!="" && $is_global_access!=1){
			if($Cond2=="") $Cond2 .= " site_id='$user_site_id'";	
			else $Cond2 .= " And site_id='$user_site_id'";	
		}	
	
		if($Cond1!="") $Cond1 =" WHERE ".$Cond1;
		if($Cond2!="") $Cond2 =" WHERE ".$Cond2;
		
		
		
		$qSQL="select * from (((Select b.*,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name from signin b ".$Cond2 .") xx INNER JOIN (select d.*,audit_id as auditrowid, (Select shname from client m where m.id=d.client_id) as client_name, (Select name from process k where k.id=d.process_id) as process_name, (Select name from sub_process l where l.id=d.sub_process_id) as sub_process_name from audit_info d $Cond1 ) yy on xx.id=yy.agent_id) LEFT JOIN audit_score zz on yy.audit_id=zz.audit_id) Order By yy.audit_id ";
		
		
		$query = $this->db->query($qSQL);
		$auditArray=$query->result_array();
		
		$allArray=array();
		$coachArray=array();
		
		
		foreach($auditArray as $audit): 
			$audit_id=$audit['audit_id'];
			$qSqlC="select e.*,(Select CONCAT(fname,' ' ,lname) from signin k where k.id=e.coach_id) as coach_name from coaching e Where audit_id='$audit_id'  Order By audit_id ";
			$query = $this->db->query($qSqlC);
			$coachArray[$audit_id]=$query->result_array();
		endforeach; 
		
		$allArray[0]=$auditArray;
		$allArray[1]=$coachArray;
		
		//print_r($allArray);
		
		return $allArray;
		
    }
	
	
	
	public function get_total($table,$cond="")
    {
		$qSQL="SELECT count(*) as total FROM $table ".$cond;		
		$query = $this->db->query($qSQL);
		//$res=$query->result_array()[0];
		$res=$query->row_array();
		return $res["total"];
		
    }
	
	public function get_total2($qSql)
    {	
		$query = $this->db->query($qSql);
		//$res=$query->result_array()[0];
		$res=$query->row_array();
		return $res["total"];
		
    }
	
	
	public function get_single_value($qSql)
    {		
		//echo $qSql;
		$query = $this->db->query($qSql);
		$res=$query->row_array();
		if (isset($res)) return $res["value"];
		else return "";
		
    }
	
	public function get_query_result_array($qSql)
    {		
		$query = $this->db->query($qSql);
        return $query->result_array();
		
    }
	
	public function get_query_result($qSql)
    {		
		$query = $this->db->query($qSql);
        return $query->result();	
    }
	
	public function get_query_row_array($qSql)
    {		
		$query = $this->db->query($qSql);
        return $query->row_array();
		
    }
	
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // GET Rolls LIST - FOR DROPDOWN IN ADD USERS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
	public function get_rolls_for_assignment_all()
    {
        		
		$qSQL="SELECT id,name, folder FROM role where is_active=1 ORDER BY name";
		$query = $this->db->query($qSQL);
        return $query->result();
    }
	
    public function get_rolls_for_assignment()
    {
        		
		$qSQL="SELECT id,name FROM role where is_active=1 and id>0 ORDER BY name";
		$query = $this->db->query($qSQL);
        return $query->result();
    }
	
	public function get_rolls_for_assignment2($qSQL)
    {
		$query = $this->db->query($qSQL);
        return $query->result();
    }
	
	public function get_tls_for_assign()
    {
		//$qSQL="SELECT id,CONCAT(fname,' ' ,lname) as tl_name FROM `signin` where status=1 and role_id in (2,5,9) ORDER BY fname";
		
		$qSQL= "SELECT id, CONCAT(fname,' ' ,lname,' (', office_id ,')') as tl_name FROM `signin` where status in (1,4) and id>1 and role_id in (select id from role where folder <> 'agent') ORDER BY fname, lname";
		
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_tls_for_assign2($cond)
    {
		//$qSQL="SELECT id,CONCAT(fname,' ' ,lname,' (', office_id ,')') as tl_name FROM `signin` where status=1 and role_id in (2,5,9) ".$cond." ORDER BY office_id, fname";
		
		$qSQL="SELECT id,CONCAT(fname,' ' ,lname,' (', office_id , '- ', fusion_id, ')') as tl_name FROM `signin` where status in (1,4) and id>1 and role_id in (select id from role where folder <> 'agent') ".$cond. " ORDER BY fname, lname";
		
		
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_sites_for_assign()
    {
		$qSQL="SELECT id,name FROM site where is_active=1  ORDER BY name";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_sites_for_assign2($cond)
    {
		$qSQL="SELECT id,name FROM site ". $cond ."  ORDER BY name";
		//$qSQL="SELECT id,name FROM site where is_active=1  ORDER BY name";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_process_for_assign()
    {
		$qSQL="SELECT id,name FROM process WHERE is_active=1 ORDER BY name";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_process_list($cid)
    {
		$qSQL="SELECT id,name FROM process WHERE is_active=1 and client_id='$cid' ORDER BY name";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_sub_process_list($pid)
    {
		$qSQL="SELECT id,name FROM sub_process WHERE is_active=1 and process_id='$pid' ORDER BY name";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_assign_list($oid)
    {		
		//$qSQL="SELECT id,CONCAT(fname,' ' ,lname) as tl_name FROM `signin` where role_id in (2,5,9) and office_id='$oid' ORDER BY fname";
		//$qSQL="SELECT id,CONCAT(fname,' ' ,lname,' (', office_id ,')') as tl_name FROM signin where status=1 and role_id in (2,5,9) and office_id='$oid' ORDER BY fname";
		
		$qSQL="SELECT id,CONCAT(fname,' ' ,lname,' (', office_id ,')') as tl_name FROM signin where status in (1,4) and id>1 and role_id in (select id from role where folder <> 'agent') and office_id='$oid'  ORDER BY fname";
				
		$query = $this->db->query($qSQL);
		return $query->result();
		}
		
		public function get_assign_list_all($oid)
    {		
		//$qSQL="SELECT id,CONCAT(fname,' ' ,lname) as tl_name FROM `signin` where role_id in (2,5,9) and office_id='$oid' ORDER BY fname";
		//$qSQL="SELECT id,CONCAT(fname,' ' ,lname,' (', office_id ,')') as tl_name FROM signin where status=1 and role_id in (2,5,9) and office_id='$oid' ORDER BY fname";
		
		$qSQL="SELECT id,CONCAT(fname,' ' ,lname,' (', office_id ,')') as tl_name FROM signin where status in (1,4) and id>1 and office_id='$oid'  ORDER BY fname";
			
		print($qSQL);

		$query = $this->db->query($qSQL);
		return $query->result();
    }
		
	public function get_event_for_assign()
    {
		$qSQL="SELECT id,description FROM event_master WHERE is_active=1 ORDER BY description";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
		
	public function get_notification_list()
    {
		$qSQL="SELECT *,(select shname from client c where c.id=a.client_id) as client_name FROM notification_info a ORDER BY id";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_office_location_list()
    {
		$qSQL="SELECT * FROM office_location WHERE is_active=1 ORDER BY office_name";
		
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_office_location_session($abbr)
    {
		if( get_global_access()==1 || get_dept_folder_original()=="rta" ||  get_dept_folder_original()=="wfm"){
			$qSQL="SELECT * FROM office_location WHERE is_active=1 ORDER BY office_name";
		}else{
			$qSQL="SELECT * FROM office_location where abbr='$abbr' ORDER BY office_name";
		}
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_office_location_session_all($uid)
    {
		if( get_global_access()==1 || get_dept_folder_original()=="rta" ||  get_dept_folder_original()=="wfm"){
			
			$qSQL="SELECT * FROM office_location WHERE is_active=1 ORDER BY office_name";
			
		}else{
			$qSQL="SELECT * FROM office_location where abbr=(select office_id from signin where id='$uid') OR 
			(select oth_office_access from signin where id='$uid') like CONCAT('%',abbr,'%') ORDER BY office_name";
		}
		
		//echo $qSQL;
		
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_function_list()
    {
		$qSQL="SELECT * FROM policy_function WHERE is_active=1 ORDER BY id";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_department_list()
    {
		$qSQL="SELECT * FROM department WHERE is_active=1 ORDER BY description";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_department_session($id)
    {
		$qSQL="SELECT * FROM department where id='$id' ORDER BY description";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_department_session_withops($id)
    {
		$qSQL="SELECT * FROM department where id in ($id,6) ORDER BY description";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	
	public function get_sub_department_list($id)
    {
		$qSQL="SELECT * FROM sub_department where dept_id='$id' and is_active=1 ORDER BY name";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	
	public function get_client_list()
    {
		$qSQL="SELECT * FROM client where is_active=1 ORDER BY shname";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function get_assign_client_list($user_id)
    {
		$qSQL="SELECT * FROM client WHERE is_active=1 AND id IN (SELECT client_id FROM  info_assign_client WHERE user_id='$user_id' ) ORDER BY shname";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	
	public function get_notify_count()
    {
		return "0";	
    }
	
	
	public function get_user_client_ids($uid)
    {
       $qSql="Select client_id from info_assign_client where user_id='$uid'";
	   $query = $this->db->query($qSql);
       return $query->result_array();
    }
	
	public function get_user_process_ids($uid)
    {
       $qSql="Select process_id from info_assign_process where user_id='$uid'";
	   $query = $this->db->query($qSql);
       return $query->result_array();
    }
	
	/* -------------------------------------------------- */
	
	
	
	public function check_update_for_loa()
	{
		
		$current_user = get_user_id();
		$c_date = CurrDate();
		$loa_date = date('Y-m-d', strtotime(date($c_date) .' -1 day'));
		
		$qSql="Select * from event_disposition where user_id='$current_user' and event_master_id='4' and start_date <='$c_date' and end_date >='$c_date' and start_date != end_date ";
		//echo $qSql;
		
		$loa_info=$this->Common_model->get_query_result_array($qSql);
		
		$remarks=" User login on ".$c_date;
		
		if(!empty($loa_info)){
		
			$did=$loa_info[0]['id'];
			$user_id=$loa_info[0]['user_id'];
			$start_date=$loa_info[0]['start_date'];
			$end_date=$loa_info[0]['end_date'];
			
			$rSql="REPLACE INTO event_disposition_archive (SELECT * FROM event_disposition where id='$did' and user_id='$user_id')";
			$this->db->query($rSql);
			
			$Update_array = array(
				"end_date" => $loa_date,
				"log" => get_logs(),
				"remarks" => $remarks
			);
						
			$this->db->where('id', $did);
			$this->db->where('user_id ',$user_id);
			$this->db->update('event_disposition', $Update_array);
			
			return true;
		}else{
			return false;
		}
		
	}
	
	
	
	public function auto_Term_On30Days()
	{
	
		
		// Get all users how are logged in from the last 
		$evt_date=CurrMySqlDate();
		$event_by= 0;
		$log="System auto ncns update";
		$remarks="System Auto update";
		
		$cDate=CurrDate();
		$prev_date = date('Y-m-d', strtotime(date($cDate) .' -1 day'));
				
		$qSQL = $this->db->query("select id from signin where status in (1,4) and is_logged_in=0 and dept_id=6 and role_id in (SELECT id FROM `role` WHERE `folder` in ('agent','supervisor','tl','trainer'))");
		
				
		$rr = $qSQL->result();
		
		if($qSQL->num_rows() > 0)
		{
			foreach($rr as $res){
				$uid = $res->id;
				$this->termOn30DaysOffline($uid,$cDate);						
			}
		}
		
	}
	
	
	public function termOn30DaysOffline($uid,$cd_date)
	{
				
			$prev_date = date('Y-m-d', strtotime(date($cd_date) .' -1 day'));
			
			$qSql= "SELECT datediff(now(),max(login_time)) as value FROM logged_in_details where user_id ='$uid'";
			
			$daysDiff=$this->get_single_value($qSql);
			
			
			if($daysDiff>=30)
			{
						
					$evt_date = CurrMySqlDate();
										
					if($this->input->is_cli_request()){
						$event_by= "0";
						$log="System";
						$terms_date= $cd_date . " 23:57:" . rand(10,58);
					}else{
						$event_by= get_user_id();
						$log=get_logs();
						$terms_date=$evt_date;
					}
					
					$start_date=$cd_date;
					$end_date=$start_date;
					
					$ticket_no="";
					$remarks="Inactive Term for 30 days";
					$t_type=1;
					
					$_field_array = array(
						"user_id" => $uid,
						"event_time" => $evt_date,
						"event_by" => $event_by,
						"event_master_id" => '7',
						"start_date" => $start_date,
						"end_date" => $end_date,
						"ticket_no" => $ticket_no,
						"remarks" => $remarks,
						"log" => $log
					); 
				
					
					$this->db->trans_begin();
					
					$this->db->where('id', $uid);
					$this->db->update('signin', array('status' =>'2','disposition_id' => '7'));							
					$event_id = data_inserter('event_disposition',$_field_array);
					
					if($event_id!==false)
					{
							$_field_array = array(
								"user_id" => $uid,
								"terms_date" => $terms_date,
								"comments" => $remarks,
								"t_type" => $t_type,
								"terms_by" => $event_by,
								"is_term_complete" => "N",
								"evt_date" => $evt_date,
							); 
							data_inserter('terminate_users',$_field_array);
							
					}
					
					$this->db->trans_complete();						
					////////////////////////////
					
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$ans="error";
					}else{
						$this->db->trans_commit();
						
						$this->send_email_30DaysTerm($uid,$terms_date,$remarks);
						
					}
					////////////////////////////////////////////////////////////	
			}
	}
	
	
	
	public function send_email_30DaysTerm($uid,$cd_date,$comments)
	{
		
		
			//$this->load->library('email');
			
			$qSql="select a.fusion_id, a.omuid,max(login_time) as llogin_time,max(logout_time) as llogout_time,fname,lname,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";
			
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();
			
			$omuid=$uRow["omuid"];
			$fusion_id=$uRow["fusion_id"];
			$full_name=$uRow["full_name"];
			$fname=$uRow["fname"];
			$lname=$uRow["lname"];
			$site_name=$uRow["site_name"];
			$llogin_time=$uRow["llogin_time"];
			$llogout_time=$uRow["llogout_time"];
			$process_name=$uRow["process_name"];
			
			$qSql="select * from notification_info where sch_for='30DAYSTERM' and is_active=1";
			$query = $this->db->query($qSql);
			if($query->num_rows() > 0)
			{
				$res=$query->row_array();
				$eto=$res["email_id"];

				//$esubject=$site_name ." - ". $res["email_subject"] . " of " .$full_name. " (".$fusion_id.")";
				$newdt = explode(" ",$cd_date);
				$dtOnly=mysql2mmddyy($newdt[0]);
				//$esubject=$site_name ." - ".$process_name . " / Termination / ".$full_name." / ".$dtOnly;
				
				$esubject=$site_name ." - ".$process_name . " / ". $res["email_subject"] . " / ".$full_name." / ".$dtOnly;
				
				$ebody=$res["email_body"];
				
				
				$nbody="<br><table width='98%' cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
				$nbody .="<tr style='background-color: #FFCC00; text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>Fusion ID</td><td style='padding:5px; border:1px solid #ccc;'>OM ID</td><td style='padding:5px; border:1px solid #ccc;'>First Name</td> <td style='padding:5px; border:1px solid #ccc;'>Last Name</td> <td style='padding:5px; border:1px solid #ccc;'>Status</td> <td style='padding:5px; border:1px solid #ccc;'>Location</td> <td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td><td style='padding:5px; border:1px solid #ccc;'>Term Time</td><td style='padding:5px; border:1px solid #ccc;'>Comments</td></tr>";
				
				$nbody .="<tr style='text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>$fusion_id</td><td style='padding:5px; border:1px solid #ccc;'>$omuid</td><td style='padding:5px; border:1px solid #ccc;'>$fname</td> <td style='padding:5px; border:1px solid #ccc;'>$lname</td> <td style='padding:5px; border:1px solid #ccc;'>Term</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td><td style='padding:5px; border:1px solid #ccc;'>$cd_date</td><td style='padding:5px; border:1px solid #ccc;'>$comments</td></tr>";
				$nbody .="</table>";
				$nbody .="<p>$ebody</p>";
								
				//echo $nbody ."<br><br>";
				//echo $eto ."<br><br>";
				$ecc="";
				
				/*
				$qSql="Select email_id as value from signin where id ='$uid'";
				$ecc=$this->get_single_value($qSql);
				*/
				
				$this->send_email_sox($uid,$eto,$ecc,$nbody,$esubject);
					
			}
			
		
		
	}
	
	
	public function send_email_submit_ticket($uid,$cd_date,$comments)
	{
		
		
		//$this->load->library('email');
			
			$qSql="select a.fusion_id, a.omuid,max(login_time) as llogin_time,max(logout_time) as llogout_time,fname,lname,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";
			
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();
			
			$omuid=$uRow["omuid"];
			$fusion_id=$uRow["fusion_id"];
			
			$full_name=$uRow["full_name"];
			$fname=$uRow["fname"];
			$lname=$uRow["lname"];
			$site_name=$uRow["site_name"];
			$llogin_time=$uRow["llogin_time"];
			$llogout_time=$uRow["llogout_time"];
			$process_name=$uRow["process_name"];
			
			$qSql="select * from notification_info where sch_for='TERMTICKET' and is_active=1";
			$query = $this->db->query($qSql);
			if($query->num_rows() > 0)
			{
				$res=$query->row_array();
				$eto=$res["email_id"];

				//$esubject=$site_name ." - ". $res["email_subject"] . " of " .$full_name. " (".$fusion_id.")";
				$newdt = explode(" ",$cd_date);
				$dtOnly=mysql2mmddyy($newdt[0]);
				//$esubject=$site_name ." - ".$process_name . " / Termination / ".$full_name." / ".$dtOnly;
				
				$esubject=$site_name ." - ".$process_name . " / ". $res["email_subject"] . " / ".$full_name." / ".$dtOnly;
				
				$ebody=$res["email_body"];
				
				
				$nbody="<br><table width='98%' cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
				$nbody .="<tr style='background-color: #FFCC00; text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>Fusion ID</td><td style='padding:5px; border:1px solid #ccc;'>OM ID</td><td style='padding:5px; border:1px solid #ccc;'>First Name</td> <td style='padding:5px; border:1px solid #ccc;'>Last Name</td> <td style='padding:5px; border:1px solid #ccc;'>Status</td> <td style='padding:5px; border:1px solid #ccc;'>Location</td> <td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td><td style='padding:5px; border:1px solid #ccc;'>Term Time</td><td style='padding:5px; border:1px solid #ccc;'>Comments</td></tr>";
				
				$nbody .="<tr style='text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>$fusion_id</td><td style='padding:5px; border:1px solid #ccc;'>$omuid</td><td style='padding:5px; border:1px solid #ccc;'>$fname</td> <td style='padding:5px; border:1px solid #ccc;'>$lname</td> <td style='padding:5px; border:1px solid #ccc;'>Term</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td><td style='padding:5px; border:1px solid #ccc;'>$cd_date</td><td style='padding:5px; border:1px solid #ccc;'>$comments</td></tr>";
				$nbody .="</table>";
				$nbody .="<p>$ebody</p>";
								
				//echo $nbody ."<br><br>";
				//echo $eto ."<br><br>";
				$ecc="";
				
				/*
				$qSql="Select email_id as value from signin where id ='$uid'";
				$ecc=$this->get_single_value($qSql);
				*/
				
				$this->send_email_sox($uid,$eto,$ecc,$nbody,$esubject);
					
			}
			
		
		
	}
	
	
	public function send_email_tarms($uid,$ticket_no,$ticket_date,$comments)
	{
		
			//$this->load->library('email');
			
			$qSql="select a.fusion_id, a.omuid,max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";
			
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();
			
			$omuid=$uRow["omuid"];
			$fusion_id=$uRow["fusion_id"];
			$full_name=$uRow["full_name"];
			$site_name=$uRow["site_name"];
			$llogin_time=$uRow["llogin_time"];
			$llogout_time=$uRow["llogout_time"];
			
			$process_name=$uRow["process_name"];
			if($comments==""){
				$qSql1="Select comments as value from terminate_users where user_id='$uid' order by id desc limit 1";
				$comments=$this->get_single_value($qSql1);
			}
			
			$qSql="select * from notification_info where sch_for='TERMSUSER' and is_active=1";
			$query = $this->db->query($qSql);
			if($query->num_rows() > 0)
			{
				$res=$query->row_array();
				$eto=$res["email_id"];
				
				//$esubject=$site_name ." - ".$res["email_subject"] . " - " .$full_name. " (".$fusion_id.")";
				
				$esubject=$site_name ." - ".$process_name . " / ". $res["email_subject"] . " / ".$full_name." / ".$fusion_id;
				
				$ebody=$res["email_body"];
								
				$nbody="<br><table width='98%' cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
				$nbody .="<tr style='background-color: #FFCC00; text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>Fusion ID</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'>Ticket No</td><td style='padding:5px; border:1px solid #ccc;'>Ticket Date</td><td style='padding:5px; border:1px solid #ccc;'>Comments</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";
				
				$nbody .="<tr style='text-align:center;'><td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$fusion_id</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$ticket_no</td><td style='padding:5px; border:1px solid #ccc;'>$ticket_date</td><td style='padding:5px; border:1px solid #ccc;'>$comments</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td></tr>";
				$nbody .="</table>";
				$nbody .="<p>$ebody</p>";
								
				//echo $nbody ."<br><br>";
				//echo $eto ."<br><br>";
				$ecc="";
				
				/*
				$qSql="Select email_id as value from signin where id ='$uid'";
				$ecc=$this->get_single_value($qSql);
				*/
				
				$this->send_email_sox($uid,$eto,$ecc,$nbody,$esubject);
					
			}
		
	}
	
	
	public function auto_ncns_update()
	{
		// Get all users how are logged in from the last 
		$evt_date=CurrMySqlDate();
		$event_by= 0;
		$log="System auto ncns update";
		$remarks="System Auto update";
		
		$cDate=CurrDate();
		$prev_date = date('Y-m-d', strtotime(date($cDate) .' -1 day'));
				
		$qSQL = $this->db->query("select id from signin where status in ( 1,4) and is_logged_in=0 and dept_id=6 and role_id in (SELECT id FROM `role` WHERE `folder` in ('agent','supervisor','tl','trainer'))");
		$rr = $qSQL->result();
		
		if($qSQL->num_rows() > 0)
		{
			foreach($rr as $res){
				$uid = $res->id;
				$qSql = "select count(user_id) as value from event_disposition  where user_id = $uid and (start_date <= '".$prev_date."' and end_date >= '".$prev_date."')";
				
				//echo $qSql ."<br><br>";
				
				$last_disp_cnt=$this->get_single_value($qSql);
				
				$qSql="select count(user_id) as value from logged_in_details where user_id ='$uid' and (cast(login_time as date) >= '".$prev_date."' and cast(login_time as date) <= '".$prev_date."')";
				
				//echo $qSql ."<br><br>";
				
				$last_logged_in_cnt=$this->get_single_value($qSql);
				
				if($last_disp_cnt==0 && $last_logged_in_cnt==0){
				
					$_field_array = array(
						"user_id" => $uid,
						"event_time" => $evt_date,
						"event_by" => $event_by,
						"event_master_id" => '2',
						"start_date" => $prev_date,
						"end_date" => $prev_date,
						"ticket_no" => '',
						"remarks" => $remarks,
						"log" => $log
					); 
						
					$event_id = data_inserter('event_disposition',$_field_array);
					if($event_id!==false){
						
						
						// will be uncomment
						//$this->term_on_3ncns($uid,$prev_date);
						
						$this->send_email_ncns_agent($uid,$prev_date);
						
					}	
				}
			}
		}
		
	}
	
	
	public function send_email_ncns_agent($uid,$cd_date)
	{
												
			$qSql="select a.fusion_id, a.omuid,max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";
			
			$query = $this->db->query($qSql);			
			$uRow=$query->row_array();
			
			$omuid=$uRow["omuid"];
			$fusion_id=$uRow["fusion_id"];
			
			$full_name=$uRow["full_name"];
			$site_name=$uRow["site_name"];
			$llogin_time=$uRow["llogin_time"];
			$llogout_time=$uRow["llogout_time"];
			
			$process_name=$uRow["process_name"];
							
			$qSql="select * from notification_info where sch_for='NCNS' and is_active=1";
			
			$query = $this->db->query($qSql);
			if($query->num_rows() > 0)
			{
									
				$res=$query->row_array();
				
				$ecc=$res["email_id"];
				
				//$esubject=$site_name ." - ".$res["email_subject"] ." of ".$full_name." (".$fusion_id.")";

				$esubject=$site_name ." - ".$process_name . " / ". $res["email_subject"] . " / ".$full_name." / ".$fusion_id;
								
				$ebody=$res["email_body"];
				
				$nbody="<br><table width='98%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
				$nbody .="<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>Fusion ID</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";
				$nbody .="<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$fusion_id</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td></tr>";
				
				$nbody .="</table>";
				$nbody .="<p>$ebody</p>";
											
				$eto="";
								
				$qSql="Select email_id as value from signin where id ='$uid'";
				$eto=$this->get_single_value($qSql);
				
				$this->send_email_sox($uid,$eto,$ecc,$nbody,$esubject);
				
			  }
	}
	
	
	
	public function term_on_3ncns($uid,$cd_date)
	{
				
			$prev_date = date('Y-m-d', strtotime(date($cd_date) .' -1 day'));
			
			$qSql="select start_date,event_master_id from event_disposition where user_id ='$uid' and start_date <= '".$prev_date."' order by start_date desc limit 30";
			
			//echo $qSql ."\r\n";
			
			$allDisp=$this->get_query_result_array($qSql);
			//print_r($allDisp);
						
			$SendMailNcns=false;
			$lDisp_date="";
			$NcnsCount=1;
			
			foreach($allDisp as $dRow){
			
				$lDisp_date=$dRow['start_date'];
				
				$dis_id=$dRow['event_master_id'];
				if($dis_id=="2"){
					
					$NcnsCount++;
					if($NcnsCount>=3){
						$SendMailNcns=true;
						break;
					}
				}else if($dis_id!="5"){
					$SendMailNcns=false;
					break;
				}
				
			}
			
			if($SendMailNcns==true)
			{
				$qSql="select count(user_id) as value from logged_in_details where user_id ='$uid' and (cast(login_time as date) >= '".$lDisp_date."' and cast(login_time as date) <= '".$cd_date."')";
				
				//echo $qSql ."<br><br>";
				$last_logged_in_cnt=$this->get_single_value($qSql);
				
				if($last_logged_in_cnt==0){
				
					
					//////////////////////////////////////////////////////////
					
					$evt_date = CurrMySqlDate();
										
					if($this->input->is_cli_request()){
						$event_by= "0";
						$log="System";
						$terms_date= $cd_date . " 23:57:" . rand(10,58);
					}else{
						$event_by= get_user_id();
						$log=get_logs();
						$terms_date=$evt_date;
					}
					
					$start_date=$cd_date;
					$end_date=$start_date;
					
					$ticket_no="";
					$remarks="3rd NCNS TERM";
					$t_type=1;
					
					$_field_array = array(
						"user_id" => $uid,
						"event_time" => $evt_date,
						"event_by" => $event_by,
						"event_master_id" => '7',
						"start_date" => $start_date,
						"end_date" => $end_date,
						"ticket_no" => $ticket_no,
						"remarks" => $remarks,
						"log" => $log
					); 
				
					
					$this->db->trans_begin();
					
					$this->db->where('id', $uid);
					$this->db->update('signin', array('status' =>'2','disposition_id' => '7'));							
					$event_id = data_inserter('event_disposition',$_field_array);
					
					if($event_id!==false)
					{
							$_field_array = array(
								"user_id" => $uid,
								"terms_date" => $terms_date,
								"comments" => $remarks,
								"t_type" => $t_type,
								"terms_by" => $event_by,
								"is_term_complete" => "N",
								"evt_date" => $evt_date,
							); 
							data_inserter('terminate_users',$_field_array);
							
					}
					
					$this->db->trans_complete();						
					////////////////////////////
					
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$ans="error";
					}else{
						$this->db->trans_commit();
						
						// will be uncomment
						///$this->send_email_submit_ticket($uid,$terms_date,$remarks);		
						
					}
					////////////////////////////////////////////////////////////
				}
				
			}else{
				//will be uncomment
				//$this->send_email_loa_req($uid,$cd_date);
			}
			
	}
	
	
		
	
	public function auto_disposition_update()
	{
		
		///////////////////////////////////////
		
		// Get all users how are logged in from the last 
		$cDate=CurrDate();
		
		$qSQL = $this->db->query("select id from signin where disposition_id > 1 and status in (1,4)");
		$rr = $qSQL->result();
		
		if($qSQL->num_rows() > 0)
		{
			$where = "";
			
			foreach($rr as $res){
				$uid = $res->id;
				$qSql2 = "select * from event_disposition  where user_id = $uid and (start_date <= '".$cDate."' and end_date >= '".$cDate."')";
				//echo $qSql2 ."\r\n";
				
				$dQuery = $this->db->query($qSql2);
				
				if($dQuery->num_rows() <=0){
					$where .= $uid.",";
				}
			}
			
			$where = rtrim($where,",");
			
			if($where!=""){
				$uSql="update signin set disposition_id=1 where id in($where)";
				//echo $uSql ."\r\n";
				$uRes = $this->db->query($uSql);
			}
			
		}
		
		//shift to cronjob
		//$ret=$this->auto_update_roster_off();
		
		//shift to cronjob
		//$this->auto_resend_email();
		
	}
	
	
	public function send_email_loa_req($uid,$cd_date)
	{
		
		$prev_date = date('Y-m-d', strtotime(date($cd_date) .' -15 day'));
		
		$qSql="select count(user_id) as value from logged_in_details where user_id ='$uid' and (cast(login_time as date) >= '".$prev_date."' and cast(login_time as date) <= '".$cd_date."')";
		//echo $qSql ."<br><br>";
		$last_login_in_date=$this->get_single_value($qSql);
		
		$qSql="select count(user_id) as value from event_disposition where user_id ='$uid' and event_master_id in (10,11,12,13,6,9) and ((start_date >= '".$prev_date."' and start_date <= '".$cd_date."') OR (end_date >= '".$prev_date."' and end_date <= '".$cd_date."'))";
		
		//echo $qSql ."<br><br>";
		$li_count=$this->get_single_value($qSql);
		
		$created_date=$this->get_single_value("Select cast(created_date as date) as value from signin where id='$uid'");
		
		
		if($last_login_in_date==0 && $li_count==0 && $created_date<=$prev_date)
		{
			//$this->load->library('email');
			
			$qSql="select a.fusion_id, a.omuid,max(login_time) as llogin_time,max(logout_time) as llogout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `logged_in_details` b on a.id=b.user_id where a.id='$uid'";
			
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();
			
			$omuid=$uRow["omuid"];
			$fusion_id=$uRow["fusion_id"];
			$full_name=$uRow["full_name"];
			$site_name=$uRow["site_name"];
			$llogin_time=$uRow["llogin_time"];
			$llogout_time=$uRow["llogout_time"];
			
			$process_name=$uRow["process_name"];
			
			$qSql="select * from notification_info where sch_for='15DAYOFFLINE' and is_active=1";
			$query = $this->db->query($qSql);
			
			if($query->num_rows() > 0)
			{			
				$res=$query->row_array();
				$eto=$res["email_id"];
				
				//$esubject=$site_name ." - ".$res["email_subject"] . " of " .$full_name. " (".$fusion_id.")";
				
				$esubject=$site_name ." - ".$process_name . " / ". $res["email_subject"] . " / ".$full_name." / ".$fusion_id;
				
				$ebody=$res["email_body"];
				
				
				$nbody="<br><table width='98%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
				$nbody .="<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>Fusion ID</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";
				$nbody .="<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$fusion_id</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$llogout_time</td></tr>";
				$nbody .="</table>";
				$nbody .="<p>$ebody</p>";
								
				//echo $nbody ."<br><br>";
				//echo $eto ."<br><br>";
				$ecc="";
				
				//$qSql="Select email_id as value from signin where id ='$uid'";
				//$ecc=$this->get_single_value($qSql);
				$this->send_email_sox($uid,$eto,$ecc,$nbody,$esubject);
				
			}
		}
	}
	
		
	public function resend_email_sox($tid,$eto,$ecc,$ebody,$esubject,$attch_file="",$from_email="noreply.mwp@fusionbposervices.com",$from_name="Fusion MWP", $isBcc = "Y", $brand = '' )
	{

		//$ebody .="<br/><p style='font-size:10px'>Note: This is an automated system email, please do not reply.</p>";
		
		$eto = str_replace(';', ',', $eto);
		$ecc = str_replace(';', ',', $ecc);
		
		if($brand==""){
			
			$brand=get_brand_for_email($eto);
		}
		
		//echo'<br>'.$eto.$brand;die();
		if ($brand == '3') {
			$from_email = "noreply.mwp@omindtech.com";
			$from_name = "Omind MWP";
			//$ecc='souvik.mondal@omindtech.com';
		} else {
			$from_email = "noreply.mwp@fusionbposervices.com";
		}
			
		
		
		$this->load->library('email');
				
		$dt=get_mail_config($brand);
		$config['smtp_user']=$dt['email'];
		$config['smtp_pass'] = $dt['password'];
		$this->email->initialize($config); 
		
		$this->email->clear(TRUE);
		$this->email->set_newline("\r\n");
		//$this->email->from('noreply.sox@fusionbposervices.com', 'Fusion SOX');
		$this->email->from($from_email, $from_name);
		
		$this->email->to($eto);
		
		if($ecc!="") $this->email->cc($ecc);
		
		$this->email->bcc('saikat.ray@omindtech.com');
		
		$this->email->subject($esubject);
		$this->email->message($ebody);
		
		if($attch_file!="") $this->email->attach($attch_file);
			
				
		if($eto!=""){
			try{
			
				if($this->email->send()){
					$this->db->query("update email_log set is_send = 'S' where id='$tid'");
					//echo 'Email sent.';
					return true;
					
				}else{
					$log=addslashes($this->email->print_debugger());
					$this->db->query("update email_log set is_send = 'F', log='$log' where id='$tid'");
					//show_error($this->email->print_debugger());
					//echo $this->email->print_debugger();
					return false;
				}
				
			}catch (Exception $ex){
				$log=addslashes($this->email->print_debugger());
				$this->db->query("update email_log set is_send = 'F', log='$log' where id='$tid'");
				//echo 'Email Exception.';
				return false;
			}
			
		}
	}
	

	public function auto_resend_email()
	{
		$qSQL = $this->db->query("select * from email_log where is_send = 'N' order by id desc limit 5");
		$rr = $qSQL->result();	
		if($qSQL->num_rows() > 0)
		{		
			foreach($rr as $res){
				
				$tid=$res->id;
				$eto=stripslashes($res->email_to);
				$ecc=$res->email_cc;
				if($ecc!="")$ecc=stripslashes($ecc);
				
				$esubject=stripslashes($res->subj);
				$nbody=stripslashes($res->body);
				$attach_file=stripslashes($res->attach_file);
								
				$this->resend_email_sox($tid,$eto,$ecc,$nbody,$esubject,$attach_file);
				
				sleep(2);
				
			}	
		}
	}
	
	public function auto_update_roster_off()
	{
			
			$evt_date=CurrMySqlDate();
			 
			$currDate = CurrDate();
			
			$currDay=strtolower(date('D', strtotime($currDate)));
			
			$qSql="Select * from signin where id not in ( Select user_id from event_disposition where start_date <= '".$currDate."' and end_date>= '".$currDate."' ) and status in (1,4) and role_id>1 ";
						
			//echo $qSql ."\r\n<br><br>";
			
			$qRes=$this->db->query($qSql);
			$rr = $qRes->result();
			
			foreach($rr as $row){
				
				$user_id=$row->id;
				$fusion_id=$row->fusion_id;
				$omuid=$row->omuid;
				
				
				$currDay=strtolower(date('D', strtotime($currDate)));
				
				//$fielsIn=$currDay."_in";
				//$fielsOut=$currDay."_out";
				
				//$qSql="Select user_id,omuid,$fielsIn,$fielsOut from user_shift_schedule where user_id='$user_id' and start_date <= '$currDate' and end_date>= '$currDate' order by id limit 1";
				
				$qSql="Select user_id,in_time,out_time from user_shift_schedule where user_id='$user_id' and shdate='$currDate' and shday='$currDay' order by id limit 1";
								
				//echo $qSql ."<br><br>";
				
				$schRes=$this->db->query($qSql)->result();
				
				foreach($schRes as $row){
					
					
					$user_id=$row->user_id;
					
					//$shIn=$row->$fielsIn;
					//$shOut=$row->$fielsOut;
					
					$shIn= strtoupper($row->in_time);
					$shOut=strtoupper($row->out_time);
					
					//echo $shIn . " >> " .$shOut;
					
					try{
						
						$loaArray = array("SL", "LOA", "VL", "PL", "CL", "BEREAVEMENT","PTO","RTO");
						
						if( ( stripos($shIn, "OFF") !== FALSE && stripos($shOut, "OFF") !== FALSE ) || ($shIn=="RO" && $shOut=="RO") || ($shIn=="WO" && $shOut=="WO") ){
											
								$_field_array = array(
									"user_id" => $user_id,
									"event_time" => $evt_date,
									"event_by" => '0',
									"event_master_id" => '5',
									"start_date" => $currDate,
									"end_date" => $currDate
								);
								
							$this->db->where('id', $user_id);
							$this->db->update('signin', array('disposition_id' => '5'));
							
							data_inserter('event_disposition',$_field_array);
														
						}else if( (stripos($shIn, "LEAVE") !== FALSE && stripos($shOut, "LEAVE") !== FALSE ) || ( in_array($shIn, $loaArray) && in_array($shOut, $loaArray) )){
											
								$_field_array = array(
									"user_id" => $user_id,
									"event_time" => $evt_date,
									"event_by" => '0',
									"event_master_id" => '4',
									"start_date" => $currDate,
									"end_date" => $currDate
								);
								
							$this->db->where('id', $user_id);
							$this->db->update('signin', array('disposition_id' => '4'));
							
							data_inserter('event_disposition',$_field_array);
							
						}else if( (stripos($shIn, "WFH") !== FALSE && stripos($shOut, "WFH") !== FALSE ) ){
											
								$_field_array = array(
									"user_id" => $user_id,
									"event_time" => $evt_date,
									"event_by" => '0',
									"event_master_id" => '20',
									"start_date" => $currDate,
									"end_date" => $currDate
								);
								
							$this->db->where('id', $user_id);
							$this->db->update('signin', array('disposition_id' => '20'));
							
							data_inserter('event_disposition',$_field_array);
							
						}//end else
											
					}catch(Exception $ex){
						log_message('SOX',  'Caught exception: ',  $ex->getMessage());						
					}
					
				} //for
				
			}//for row
			
		return 'true';	
	}

	
	public function get_rolls_for_assignment3($cond='')
    {
        		
		//$qSQL="SELECT id,name FROM role where is_active=1 ".$cond." ORDER BY name";
		$qSQL="SELECT id,name FROM role where is_active=1 ORDER BY name";
		
		$query = $this->db->query($qSQL);
        return $query->result();
    }

 
	
	public function history_type()
    {
		$qSQL="SELECT * FROM history_type WHERE is_active=1";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function role_organization()
    {
		$qSQL="SELECT * FROM role_organization WHERE is_active=1";
		$query = $this->db->query($qSQL);
		return $query->result();
    }

	public function role_organization_details($id)
    {
		$qSQL="SELECT  FROM role_organization WHERE id='".$id."' AND is_active=1";
		$query = $this->db->query($qSQL);
		return $query->result();
    }
	
	public function info_assign_client($qSQL){
		 
		$query = $this->db->query($qSQL);
		return $query->result_array();
	}
	
	public function get_client_list_1()
    {
		$qSQL="SELECT id,shname,fullname FROM client where is_active=1 ORDER BY shname";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	public function get_process_list_1()
    {
		$qSQL="SELECT id,client_id,name FROM process where is_active=1 ORDER BY name";
		$query = $this->db->query($qSQL);
		return $query->result_array();
    }
	
	
	public function update_password_expiry(){
		$qSql = "Update signin set is_update_pswd = 'N' Where is_update_pswd = 'Y' and DATEDIFF(now(), pswd_update_date) >= 45";
		$query = $this->db->query($qSql);
	}
	
	public function auto_update_orgrole(){
		$qSql = "Update signin s, role r set s.org_role_id = r.org_role where s.role_id = r.id";
		$query = $this->db->query($qSql);
	}
	
	
	public function send_birthday_email(){
				
		$curr_date = date('m-d');
		
		$qSql = "Select s.id as suid, fusion_id, fname, lname, email_id, email_id_off, email_id_per, ( select email_id_off from info_personal ip where ip.user_id=s.assigned_to) as tl_email_off from signin s left join info_personal p ON p.user_id=s.id where DATE_FORMAT(dob, '%m-%d') = '$curr_date' and status in (1,4) ";
		
		//$qSql = "Select s.id as suid, fusion_id, fname, lname, email_id, email_id_off, email_id_per from signin s left join info_personal p ON p.user_id=s.id where s.id in (7)";
		
		$user_today_dob = $this->Common_model->get_query_result_array($qSql);
		
		foreach($user_today_dob as $row){
			$bName = $row['fname']. " " . $row['lname'];
			
			$eto =$row['email_id_per'];
			$eto = $eto . ", " . $row['email_id_off'];
			$ecc = $row['tl_email_off'];
			
			$email_id = $row['email_id'];
			$user_id = $row['suid'];
			$fusion_id = $row['fusion_id'];
			
			if( $eto == "" ) $eto = $email_id;
			
			//echo $eto . "<br><br>";
			//echo $ecc . "<br><br>";
			
			$CardBody = '<img alt="Happy Birthday '. $bName . '" src="'.create_birthday_card_url($bName,$fusion_id).'" /><br><br> Fusion Team<br><br>';
			
			//echo 	$CardBody;
		
			$esubject = "Happy Birthday ".$bName;
			$this->Email_model->send_email_sox($user_id,$eto,$ecc,$CardBody,$esubject);
			
			sleep(2);
			
		}
		
	}


	public function get_emlployee_list_based_on_dept($_dept_id, $_location_id){

		$query = "select id, upper(concat(trim(fname),' ',trim(lname),' (',fusion_id,')')) as fullname from signin 
					where status in (1,4) and dept_id = ".$_dept_id;

		if($_location_id != "") $query .= " and office_id = '".$_location_id."'";

		$query .=" order by fullname";

		$qSQL = $this->db->query($query);
		return $qSQL->result();
	}

 public function execQuery($sql) {
        $query = $this->db->query($sql);
        return $query;
    }
public function getApprovedAssets($dfr_id,$approve=''){
    
    $this->db->select("am.name,aa.assets_required");
    $this->db->where("aa.dfr_id",$dfr_id);
    if($approve==''){
    $this->db->where("aa.approve!=",'2');   
    }else{
    $this->db->where("aa.approve","$approve");   
    }
    $this->db->from("dfr_assets_approve aa");
    $this->db->join("dfr_assets_mst am",'am.id=aa.assets_id','left');
    return $this->db->get();
//    $this->db->get();
//    echo $this->db->last_query();
//    exit;
}	





function get_id_location($loc_title)  // this will give name for giving id 
{
  $this->db->select("office_name");
  $this->db->where("abbr", $loc_title);
  $result = $this->db->get("office_location")->row_array();
  return $result;
}








}

?>