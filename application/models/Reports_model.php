<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model {
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // CHECK USER CREDENTIALS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   	
	private $RepDB=null;
	
	public function set_report_database($group="default"){	
        $this->RepDB = $this->load->database($group,TRUE);
	}
	
	public function get_terms_users($filterArr)
    {
		
		if($this->RepDB==null) $this->set_report_database();
		
		$start_date =$filterArr['start_date'];
		$end_date =$filterArr['end_date'];
		
		$dept_id =$filterArr['dept_id'];
		$office_id =$filterArr['office_id'];
		
		$fusion_id =$filterArr['fusion_id'];	
		
		
		$cond=" Where is_term_complete in ('Y','N')";
		
		if($start_date!="" && $end_date!=""){
			$start_date = mmddyy2mysql($start_date);
			$end_date = mmddyy2mysql($end_date);
			if($fusion_id == '') $cond .=" and date(terms_date)>='".$start_date."' and date(terms_date)<='".$end_date."' ";
		}
		
		$cond2="";
		if($office_id!="" && $office_id!="ALL") $cond2 .=" Where office_id='$office_id'";
		if($dept_id!="" && $dept_id!="ALL"){
			if($cond2=="") $cond2 =" and dept_id='$dept_id' ";
			else $cond2 .=" and dept_id='$dept_id' ";
		}
		
		if($fusion_id!=""){
			$cond3="AND (fusion_id='$fusion_id' OR (xpoid='$fusion_id' or omuid='$fusion_id'))";
		}else{
			$cond3='';
		}
		
		//$qSQL="select * from (select *,time_format(timediff(ticket_date,terms_date),'%H:%i:%s') as termDiff from terminate_users $cond ) a, (select *,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (select name from process y where b.process_id = y.id) as process_name,(Select name from role k  where k.id=b.role_id) as role_name from signin b $cond2 ) t where a.user_id=t.id order by terms_date desc, a.id desc " ;
		
		//$qSQL="select * from (select *, comments as tcomments ,time_format(timediff(ticket_date,terms_date),'%H:%i:%s') as termDiff from terminate_users $cond ) a, (select *,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, get_process_names(b.id) as process_name,(Select name from role k  where k.id=b.role_id) as role_name from signin b $cond2 ) t where a.user_id=t.id order by terms_date desc, a.id desc " ;
		
		 $qSQL="SELECT * from (select *, comments as tcomments ,time_format(timediff(ticket_date,terms_date),'%H:%i:%s') as termDiff, (Select concat(fname, ' ', lname) as name from signin s where s.id=terms_by) as terms_by_name, (Select concat(fname, ' ', lname) as name from signin s where s.id=update_by) as update_by_name from terminate_users  $cond) a, (select *,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select d.description from department d where d.id=b.dept_id) as dept_name, get_process_names(b.id) as process_name,(Select name from role k  where k.id=b.role_id) as role_name from signin b $cond2 ) t where a.user_id=t.id $cond3 order by terms_date desc, a.id desc";
		
		// echo $qSQL;exit;
		$query = $this->RepDB->query($qSQL);
		return $query->result_array();
		
    }
	
	
	public function get_cancel_term_request($filterArr)
    {
		
		
		if($this->RepDB==null) $this->set_report_database();
		
		$start_date =$filterArr['start_date'];
		$end_date =$filterArr['end_date'];	
		$dept_id =$filterArr['dept_id'];	
		$office_id =$filterArr['office_id'];
		
		$cond=" Where action_status not in ('P','T') ";
		
		if($start_date!="" && $end_date!=""){
			$start_date = mmddyy2mysql($start_date);
			$end_date = mmddyy2mysql($end_date);
		
			$cond .=" and date(pre_req_date)>='".$start_date."' and date(pre_req_date)<='".$end_date."' ";
		}
		
		$cond2="";
		if($office_id!="" && $office_id!="ALL") $cond2 .=" Where office_id='$office_id' ";
		if($dept_id!="" && $dept_id!="ALL"){
			if($cond2=="") $cond2 =" Where dept_id='$dept_id' ";
			else $cond2 .=" and dept_id='$dept_id' ";
		}
		
		//$qSQL="select * from (select *,(Select CONCAT(fname,' ' ,lname) from signin d where d.id=c.action_by) as aby_name from terminate_users_pre c $cond ) a, (select *,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (select name from process y where b.process_id = y.id) as process_name,(Select name from role k  where k.id=b.role_id) as role_name from signin b $cond2 ) t where a.user_id=t.id order by pre_req_date desc, a.id desc " ;
		
		$qSQL="select * from (select *,(Select CONCAT(fname,' ' ,lname) from signin d where d.id=c.action_by) as aby_name from terminate_users_pre c $cond ) a, (select *,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, get_process_names(b.id) as process_name,(Select name from role k  where k.id=b.role_id) as role_name from signin b $cond2 ) t where a.user_id=t.id order by pre_req_date desc, a.id desc " ;
		//echo $qSQL;
		
		$query = $this->RepDB->query($qSQL);
		return $query->result_array();
		
    }
	
	public function get_user_login_raw_data($filterArr,$exCond="")
    {
		
		
		if($this->RepDB==null) $this->set_report_database();
		
		
				
		$start_date =$filterArr['start_date'];
		$end_date =$filterArr['end_date'];
		
		if(isset($filterArr['client_id'])) $client_id =$filterArr['client_id'];
		else $client_id="";
		
		if(isset($filterArr['office_id'])) $office_id =$filterArr['office_id'];
		else $office_id="";
		
		if(isset($filterArr['dept_id'])) $dept_id =$filterArr['dept_id'];
		else $dept_id="";
		
		if(isset($filterArr['sub_dept_id'])) $sub_dept_id =$filterArr['sub_dept_id'];
		else $sub_dept_id="";
				
		if(isset($filterArr['site_id'])) $site_id =$filterArr['site_id'];
		else $site_id="";
		
		$filter_key =$filterArr['filter_key'];
		
		$user_site_id =$filterArr['user_site_id'];
		$assigned_to=$filterArr['assigned_to'];
		
		$filter_value="";
				
		$_cnd="";
		
		if($client_id!="" && $client_id!="ALL")  $_cnd = " And is_assign_client (b.id,$client_id)";
		
		if($dept_id!="" && $dept_id!="ALL")  $_cnd .= " and dept_id = '".$dept_id."'";
		if($sub_dept_id!="" && $sub_dept_id!="ALL")  $_cnd .= " and sub_dept_id = '".$sub_dept_id."'";
		if($site_id!="" && $site_id!="ALL")  $_cnd .= " and site_id = '".$site_id."'";
		if($office_id!="" && $office_id!="ALL")  $_cnd .= " and office_id = '".$office_id."'";
		
		$filter_value =$filterArr['filter_value'];
		if($filter_key!="" && $filter_key!="OfflineList" && strtoupper($filter_value)!="ALL" && $filter_value!=""){
		
			switch($filter_key){
				case 'Site':
					$_cnd .= " and site_id = '".$filter_value."'";
					break;
				case 'Agent':
					
					$filter_value = implode("','",explode(',', $filter_value));
					$_cnd = " and  (omuid in ('".$filter_value."') OR b.fusion_id in ('".$filter_value."') ) ";
					
					break;
				case 'Process':
					if($filter_value !="0") $_cnd .= " and is_assign_process(b.id,$filter_value)";
					break;
				case 'Role':
					$_cnd .= " and 	role_id = '".$filter_value."'";
					break;
				case 'AOF':
					$_cnd .= " and 	assigned_to = '".$filter_value."'";
					break;		
			}	
		}
								
		if($assigned_to!="" && $assigned_to!="ALL" ){
			
			$assToCond = " (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
			$_cnd .= " and ". $assToCond;
		}
		
		if($exCond!="") $_cnd .= $exCond;
		
		//echo $_cnd;
						
				
		if($filter_key=="OfflineList") $_cnd .= " AND is_logged_in=0 ";
				
		if($filter_key=="Agent"){
			$stCond= " ";
		}else{
			$stCond = " and status not in (8,9) ";
		}
		
		
		//echo "2. ". $start_date . " >> " .	$end_date . "\r\n";
		$st_date = mmddyy2mysql($start_date);
		$en_date = mmddyy2mysql($end_date);
		
		$st_date_from = $st_date. " 00:00:00";
		$en_date_to = $en_date. " 23:59:59";
		
		
		$_discnd="";
		if($filter_key=="Disposition"){	
			if($filter_value=="1")
				$_discnd = " and is_logged_in=0 ";
			else 
				$_discnd = " and b.id in ( SELECT DISTINCT user_id FROM  event_disposition  where event_master_id in (".$filter_value.") and (start_date >= '".$st_date."' and end_date <= '".$en_date."')) ";
		}
		
		
		
		
		$role_check = " role_id > 0 and login_time_local>='$st_date_from' and login_time_local<='$en_date_to' ";
		
		//echo "3. ".$st_date . " >> " .	$en_date . "\r\n";
		//(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,
		
		$qSql = "Select ld.*, login_log, substring(ld.log, locate('RemoteIP', ld.log), length(ld.log)) as loout_log ,b.fusion_id, b.fname,b.lname,b.xpoid,b.omuid,in_time,out_time,b.office_id, TIMESTAMPDIFF(SECOND,login_time,logout_time) as Ltime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status  from logged_in_details  ld
		Left Join signin b ON ld.user_id = b.id
		Left Join user_shift_schedule uss ON ld.user_id = uss.user_id and date(ld.login_time_local) = uss.shdate 
		Where $role_check $stCond $_cnd $_discnd Order By login_time, fname, b.fusion_id";
		
		//echo $qSql;
		
		$query = $this->RepDB->query($qSql);
        return $query->result_array();
		
	}
	
	
	public function get_user_list_report($filterArr,$exCond="",$is_sch='N',$is_leave='Y')
    {
		
		if($this->RepDB==null) $this->set_report_database();
		
		$role_check = ""; 
		
		//if(get_role_id() !=1){ $role_check = " and role_id in (2,3,4,5)";}
		
		$role_check = " and role_id > 0";
				
		$start_date =$filterArr['start_date'];
		$end_date =$filterArr['end_date'];
		
		if(isset($filterArr['client_id'])) $client_id =$filterArr['client_id'];
		else $client_id="";
		
		if(isset($filterArr['office_id'])) $office_id =$filterArr['office_id'];
		else $office_id="";
		
		if(isset($filterArr['dept_id'])) $dept_id =$filterArr['dept_id'];
		else $dept_id="";
		
		if(isset($filterArr['sub_dept_id'])) $sub_dept_id =$filterArr['sub_dept_id'];
		else $sub_dept_id="";
				
		if(isset($filterArr['site_id'])) $site_id =$filterArr['site_id'];
		else $site_id="";
		
		$filter_key =$filterArr['filter_key'];
		
		$user_site_id =$filterArr['user_site_id'];
		$assigned_to=$filterArr['assigned_to'];
		
		$filter_value="";
				
		$_cnd="";
		
		//if($client_id!="" && $client_id!="ALL")  $_cnd = " and client_id = '".$client_id."'";
		if($client_id!="" && $client_id!="ALL")  $_cnd = " And is_assign_client (b.id,$client_id)";
		
		if($dept_id!="" && $dept_id!="ALL")  $_cnd .= " and dept_id = '".$dept_id."'";
		if($sub_dept_id!="" && $sub_dept_id!="ALL")  $_cnd .= " and sub_dept_id = '".$sub_dept_id."'";
		if($site_id!="" && $site_id!="ALL")  $_cnd .= " and site_id = '".$site_id."'";
		if($office_id!="" && $office_id!="ALL")  $_cnd .= " and office_id = '".$office_id."'";
		
		$filter_value =$filterArr['filter_value'];
               
		if($filter_key!="" && $filter_key!="OfflineList" && strtoupper($filter_value)!="ALL" && $filter_value!=""){
		
			switch($filter_key){
				case 'Site':
					$_cnd .= " and site_id = '".$filter_value."'";
					break;
				case 'Agent':
										
					$filter_value = implode("','",explode(',', $filter_value));
					$_cnd = " and  (omuid in ('".$filter_value."') OR fusion_id in ('".$filter_value."') ) ";
					break;
				case 'Process':
					//$_cnd .= " and 	process_id = '".$filter_value."'";
					if($filter_value !="0") $_cnd .= " and is_assign_process(b.id,$filter_value)";
					break;
				case 'Role':
					$_cnd .= " and 	role_id = '".$filter_value."'";
					break;
				case 'AOF':
					$_cnd .= " and 	assigned_to = '".$filter_value."'";
					break;		
			}	
		}
		
		
		/*
		if(get_global_access()==1 || get_role_dir()=="super" || get_role_dir()=="support" || get_dept_folder()=="mis" || get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm"){
			
			$_cnd .= "";
			
		}else{
			if($user_site_id!="" && $user_site_id!="0" && $user_site_id!="ALL" ) $_cnd .= " and site_id = '".$user_site_id."'";
		}
		*/
						
		if($assigned_to!="" && $assigned_to!="ALL" ){
			
			$assToCond = " (assigned_to='$assigned_to' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$assigned_to')) ";
			//$assToCond = " (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
			//$_cnd .= " and assigned_to = '".$assigned_to."'";
			$_cnd .= " and ". $assToCond;
		}
		
		if($exCond!="") $_cnd .= $exCond;
		
		//echo $_cnd;
		//echo "2. ". $start_date . " >> " .	$end_date . "\r\n";
		$st_date = mmddyy2mysql($start_date);
		$en_date = mmddyy2mysql($end_date);
		
		$st_date_from = $st_date. " 00:00:00";
		$en_date_to = $en_date. " 59:59:59";
		
		//echo "3. ".$st_date . " >> " .	$en_date . "\r\n";				
				
		if($filter_key=="OfflineList") $_cnd .= " AND is_logged_in=0 ";
		
		$prv_term_cond="";
		
		if($filter_key=="Agent"){
			//$stCond= " and status in (0,1,2,3,4,8,9)";
			$stCond= " ";
		}else{
			
			$stCond = " and status not in (8,9) ";
			//$stCond= " and status not in (4,9)";
						
			
			//$prv_term_cond=" and b.id not in (Select user_id from terminate_users where cast(terms_date as date)<='$st_date' AND ( rejon_date is null OR rejon_date>'$en_date' ) and is_term_complete = 'Y' ) ";
			
			
			$prv_term_cond=" (Select DISTINCT user_id from terminate_users where date(terms_date)<='$st_date' AND ( rejon_date is null OR rejon_date>'$en_date' ) and is_term_complete = 'Y' ) ";
			
		}
		
			$_discnd="";
			if($filter_key=="Disposition"){		
				if($filter_value=="1")
					$_discnd = " and is_logged_in=0 ";
				else 
					$_discnd = " and b.id in ( SELECT DISTINCT user_id FROM  event_disposition  where event_master_id in (".$filter_value.") and (start_date >= '".$st_date."' and end_date <= '".$en_date."')) ";
			}
				
				if($filter_key=="Agent"){
					//(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,
					
					$qSQL=" Select *, last_logged_date as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b Where (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ". $_cnd . " $_discnd Order By fname ";
				}else{
					//(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,
					$qSQL=" Select *, last_logged_date as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b LEFT JOIN $prv_term_cond tn ON b.id = tn.user_id Where tn.user_id IS NULL AND (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ".$role_check . $_cnd . " $_discnd Order By fname ";
					
				}
				
				//echo $qSQL . "\r\n\r\n";
				
				$ListQuery = $this->RepDB->query($qSQL);
				
				
		////////
		$start = strtotime($st_date);
		$end = strtotime($en_date);
					
		// start and end are seconds, so I convert it to days 
		$diff = ($end - $start) / 86400; 
		
		//echo "4. ". $diff ."\r\n";
		
		if($office_id!="" && $office_id!="ALL") $todayDate = GetLocalDateByOffice($office_id);
		else $todayDate=CurrDate();
		
		$new_arr = array();
		$disp_name="";
		
		$term_ids=" ,";
		
		//added
				
		for ($i = 0; $i <= $diff; $i++) {
			
			$cDate= date('Y-m-d', $start);
			//echo "5. " . $cDate  ." == " . $todayDate . "\r\n";
			$start = strtotime($cDate .' +1 day');
			
			/*
			$_discnd="";
			if($filter_key=="Disposition"){		
				if($filter_value=="1")
					$_discnd = " and is_logged_in=0 ";
				else 
					$_discnd = " and b.id in ( SELECT DISTINCT user_id FROM  event_disposition  where event_master_id in (".$filter_value.") and (start_date <= '".$cDate."' and end_date >= '".$cDate."')) ";
			}
			*/
			
			if($filter_key=="OfflineList" || $filter_key=="Disposition" || $filter_key=="Agent"){
				if($cDate>$todayDate) break;
			}else{
				if($cDate>$todayDate) break;
			}
						
			///////////// For Schedule ////
			
			$currDay=strtolower(date('D', strtotime($cDate)));
			
			/*
				$fielsIn=$currDay."_in";
				$fielsOut=$currDay."_out";
						
				if(date('D', strtotime($cDate)) == "Mon") $shMonDate=$cDate;
				else $shMonDate=date('Y-m-d',strtotime($cDate.' -1 Monday'));
				
				if(date('D', strtotime($cDate)) == "Sun") $shSunDate=$cDate;
				else $shSunDate=date('Y-m-d',strtotime($cDate.' +1 Sunday'));
			*/
			
			//////////////////////// 
				/*
				//$qSQL="select *,(select name from process where b.process_id = process.id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name from signin b where $stCond ".$role_check . $_cnd . " Order By fname";
		
				//$qSQL="select *, getTodayLoginTime(b.id) as todayLoginTime, b.fusion_id,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name from signin b where (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $prv_term_cond $stCond ".$role_check . $_cnd . " $_discnd Order By fname";
				
				
				//$qSQL=" Select * from (Select *, getTodayLoginTime(b.id) as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name from signin b where (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ".$role_check . $_cnd . " $_discnd ) sn LEFT JOIN $prv_term_cond tn ON sn.id = tn.user_id Where tn.user_id IS NULL Order By fname ";
				
				if($filter_key=="Agent"){
					$qSQL=" Select *, getTodayLoginTime(b.id) as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b Where (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ". $_cnd . " $_discnd Order By fname ";
				}else{
					$qSQL=" Select *, getTodayLoginTime(b.id) as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b LEFT JOIN $prv_term_cond tn ON b.id = tn.user_id Where tn.user_id IS NULL AND (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ".$role_check . $_cnd . " $_discnd Order By fname ";
					
				}
				
				//echo $qSQL . "\r\n\r\n";
				
				$ListQuery = $this->RepDB->query($qSQL);
				
				*/
				
				$res = $ListQuery->result();
							
				foreach($res as $row)
				{
					$arr = array();
					$arr['status'] = $row->status;
					$arr['phase'] = $row->phase;
					
					///////////// Schedule ////
					if($is_sch=="Y"){
					
						//$qSql="Select user_id,$fielsIn,$fielsOut from user_shift_schedule where start_date='$shMonDate' and end_date='$shSunDate' and user_id = $row->id";
						
						$qSql="Select user_id,in_time,out_time from user_shift_schedule where shdate='$cDate' and shday='$currDay' and user_id = $row->id";
												
						//echo $qSql ."\r\n";
						
						$sch_q = $this->RepDB->query($qSql);
						$sch_row = $sch_q->row_array();
						
						if (isset($sch_row)){
							//$arr['sch_in'] = $sch_row[$fielsIn];
							//$arr['sch_out'] = $sch_row[$fielsOut];
							$arr['sch_in'] = $sch_row['in_time'];
							$arr['sch_out'] = $sch_row['out_time'];	
							
						}else{
							$arr['sch_in'] = "";
							$arr['sch_out'] = "";	
						}
					}else{
						$arr['sch_in'] = "";
						$arr['sch_out'] = "";	
					}
					
					///////// end Schedule
					
					///////////// Leave ////
					if($is_leave=="Y"){
					
						
						 $qSql="SELECT user_id,leave_type_id,from_dt,to_dt,status, (select abbr from leave_type where leave_type.id=leave_type_id ) as leave_type FROM leave_applied where from_dt<='$cDate' and to_dt>='$cDate' and status in (0,1) and user_id = $row->id";
												
						//echo $qSql ."\r\n";
						
						$leave_q = $this->RepDB->query($qSql);
						$leave_row = $leave_q->row_array();
						
						if (isset($leave_row)){
							$arr['leave_status'] = $leave_row['status'];
							$arr['leave_type'] = $leave_row['leave_type'];	
							
						}else{
							$arr['leave_status'] = "";
							$arr['leave_type'] = "";	
						}
					}else{
						$arr['leave_status'] = "";
						$arr['leave_type'] = "";	
					}
					
					///////// end Leave
					
					
					///
					
					//$_dq = "select *,timediff(logout_time,login_time) as tLtime from logged_in_details where user_id = $row->id and cast(login_time as date) = '".$cDate."' and cast(logout_time as date) >= '".$cDate."'";
					
					//$_dq = "select user_id,logout_by,min(login_time) as flogin_time,max(logout_time) as llogout_time, SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,login_time,logout_time))) as tLtime from logged_in_details where user_id = $row->id and cast(login_time as date) = '".$cDate."'  group by user_id";
					
					//working login est 
					$LSqlEst = "select user_id,logout_by, min(login_time) as login_time_min, group_concat(login_time  separator ', ') as flogin_time, max(logout_time) as logout_time_max, group_concat(logout_time  separator ', ') as llogout_time, SUM(TIMESTAMPDIFF(SECOND,login_time,logout_time)) as tLtime, substring(log, locate('RemoteIP', log), length(log)) as logout_log_est, login_log as login_log_est  from logged_in_details where user_id = $row->id and date(login_time) = '".$cDate."'  group by user_id";
															
					////Using login Local Time 
										
					//$LSqlLocal = "select user_id, logout_by, min(getEstToLocal(login_time,user_id)) as flogin_time_local , max(getEstToLocal(logout_time,user_id)) as llogout_time_local ,  SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(login_time,user_id), getEstToLocal(logout_time,user_id))) as tLtimeLocal from logged_in_details where user_id = $row->id and date(getEstToLocal(login_time,user_id)) = '".$cDate."'  group by user_id";  ;
					
					$office_id=$row->office_id;
					
					$LSqlLocal = "select user_id, logout_by, min(login_time_local) as login_time_local_min , group_concat(login_time_local  separator ', ') as flogin_time_local ,  max(logout_time_local) as logout_time_local_max , group_concat(logout_time_local  separator ', ') as llogout_time_local ,  SUM(TIMESTAMPDIFF(SECOND,login_time_local, logout_time_local)) as tLtimeLocal, SUM(getNightLoginSec(login_time_local,logout_time_local,'$office_id')) tNightLogin, substring(log, locate('RemoteIP', log), length(log)) as logout_log_local, login_log as login_log_local  from logged_in_details where user_id = $row->id and date(login_time_local) = '".$cDate."'  group by user_id";
										
					$LResEst = $this->RepDB->query($LSqlEst);
					$LRowEst = $LResEst->row();
					
					//////////////////
					
					$LResLocal = $this->RepDB->query($LSqlLocal);
					$LRowLocal = $LResLocal->row();
					
					$est_login_time = $cDate;
					$est_logout_time = $cDate;
					
					if($LResEst->num_rows()>0){
						$est_login_time = $LRowEst->login_time_min;
						$est_logout_time = $LRowEst->logout_time_max;
					}
					
					$local_login_time = $cDate;
					$local_logout_time = $cDate;
					
					if($LResLocal->num_rows()>0){
						$local_login_time = $LRowLocal->login_time_local_min;
						$local_logout_time = $LRowLocal->logout_time_local_max;
					}
					
					//////////////////////////
					
					//echo $_dq ."\r\n"; 
					
					//TIME_FORMAT(SUM(TIMESTAMPDIFF(SECOND,login_time,logout_time)),'%T)
					//and cast(logout_time as date) >= '".$cDate."'
					
					
					//working break_details_ld est 
					//$ldSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as ldBrkTime from break_details_ld where user_id = $row->id and date(out_time) = '".$cDate."' group by user_id";
					
					$ldSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as ldBrkTime from break_details_ld where user_id = $row->id and out_time BETWEEN '".$est_login_time."' AND '".$est_logout_time."' group by user_id";
					
					$ldResEst = $this->RepDB->query($ldSqlEst);
					$ldRowEst = $ldResEst->row();
					
					//working break_details_ld Local Time 		 
					//$ldqSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as ldBrkTimeLocal from break_details_ld where user_id = $row->id and date(getEstToLocal(out_time,user_id)) = '".$cDate."' group by user_id";
					
					//$ldqSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as ldBrkTimeLocal from break_details_ld where user_id = $row->id and date(out_time_local) = '".$cDate."' group by user_id";
					
					$ldqSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as ldBrkTimeLocal from break_details_ld where user_id = $row->id and out_time_local BETWEEN '".$local_login_time."' AND '".$local_logout_time."' group by user_id";
					
						
					$ldResLocal = $this->RepDB->query($ldqSqlLocal);
					$ldRowLocal = $ldResLocal->row();
					
					//working break_details est 
					//$brkSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as tBrkTime from break_details where user_id = $row->id and date(out_time) = '".$cDate."' group by user_id";
					
					$brkSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as tBrkTime from break_details where user_id = $row->id and out_time BETWEEN '".$est_login_time."' AND '".$est_logout_time."' group by user_id";
					
					$brkResEst = $this->RepDB->query($brkSqlEst);
					$brkRowEst = $brkResEst->row();
					
					//working break_details Local Time 		 
					//$brkSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(out_time,user_id),getEstToLocal(in_time,user_id))) as tBrkTimeLocal from break_details where user_id = $row->id and date(getEstToLocal(out_time,user_id)) = '".$cDate."' group by user_id";
					
					//$brkSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as tBrkTimeLocal from break_details where user_id = $row->id and date(out_time_local) = '".$cDate."' group by user_id";
					
					$brkSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as tBrkTimeLocal from break_details where user_id = $row->id and out_time_local BETWEEN '".$local_login_time."' AND '".$local_logout_time."' group by user_id";
					
					
					$brkResLocal = $this->RepDB->query($brkSqlLocal);
					$brkRowLocal = $brkResLocal->row();
												
					///
					$dispSql = "select *,(select CONCAT(fname,' ' ,lname) from signin s where s.id=y.event_by) as evt_by_name ,(select name from event_master x where x.id=y.event_master_id )as disposition from event_disposition y where y.user_id = $row->id and (start_date <= '".$cDate."' and end_date >= '".$cDate."') Order by id desc limit 1";
					
					//echo $dispSql. "<br>";
					
					$dispRes = $this->RepDB->query($dispSql);
					$dispRow = $dispRes->row();
															
					if($filter_key=="Disposition" && $filter_value=="1"){
						if($LResLocal->num_rows() > 0){
							if($LRowLocal->tLtimeLocal!="" ) continue;
						}
						
						if($dispRes->num_rows() > 0){
							$disp_name=$dispRow->disposition;
							if($dispRow->disposition !="") continue;
						}
					}
					
					$term_date="";
					$term_msg="";
                                        
					if( $row->status ==0){
						$termSql = "SELECT date(terms_date) as terms_date FROM terminate_users where user_id = $row->id and is_term_complete ='Y' order by id desc limit 1";
						//echo $termSql;
						$termRes = $this->RepDB->query($termSql);
						$termRow = $termRes->row();
						$term_date= $termRow->terms_date;
						$term_msg = "Term on ". $term_date;
					}
					
					if($filter_key=="Agent"){
						if(stripos($disp_name, "TERM")!== false){
								
								$_sqlr = "select id from event_disposition  where user_id = $row->id and (start_date = '".$cDate."' and end_date = '".$cDate."')";
																								
								$_rqrj = $this->RepDB->query($_sqlr);
								if($_rqrj->num_rows() <= 0)	continue;
						}						
					}
										
					$disp_name="";
					$user_disp_id="";
					if($dispRes->num_rows() > 0){
							$disp_name=$dispRow->disposition;
							$user_disp_id=$dispRow->event_master_id;
					}
					
					if($term_date<=$cDate && $row->status ==0) $disp_name="TERM";
					//echo $term_date . ">>=". $cDate	. ">>" . $disp_name;
					
						if($user_disp_id==8) $term_ids=str_replace(",".$row->id.",", ",", $term_ids);
						//echo $term_ids. " " . $row->id. " >> ." . stripos($term_ids,$row->id) . " .\r\n";
						if(stripos($term_ids,",".$row->id.",")!== false && $user_disp_id!=8) $disp_name="X";
						else if(strtoupper($disp_name)=="TERM") $term_ids .=$row->id.",";
						//echo $term_ids ."\n\r";
						
						
						////
					
						$arr["rDate"] = $cDate;
						$arr["id"] = $row->id;
						$arr["client_name"] = $row->client_name;
						$arr["fusion_id"] = $row->fusion_id;
						$arr["omuid"] = $row->omuid;
						$arr["xpoid"] = $row->xpoid;
						
						$arr["office_id"] = $row->office_id;
						$arr["dept_name"] = $row->dept_name;
						$arr["sub_dept_name"] = $row->sub_dept_name;
						
						$arr["red_login_id"] = $row->red_login_id;
						//$arr["passwd"] = $row->passwd;
						$arr["fname"] = $row->fname;
						$arr["lname"] = $row->lname;
						$arr["site_id"] = $row->site_id;
						$arr["role_id"] = $row->role_id;
						//$arr["process_id"] = $row->process_id;
						$arr["assigned_to"] = $row->assigned_to;
						$arr["created_date"] = $row->created_date;
						$arr["process_name"] = $row->process_name;
						//$arr["sub_process_name"] = $row->sub_process_name;
						$arr["site_name"] = $row->site_name;
						$arr["asign_tl"] = $row->asign_tl;
						$arr["role_name"] = $row->role_name;
						$arr["doj"] = $row->doj;
						// $arr["doj"] = $row->status;
						$arr["user_disp_id"] = $user_disp_id;
						
						$arr["todayLoginTime"] = $row->todayLoginTime;
						$arr["is_logged_in"] = $row->is_logged_in;
						
						//$_ff = $this->
						///$cDate=CurrDate();
							
						if($LResEst->num_rows() > 0)
						{
							$arr["logout_by"] = $LRowEst->logout_by;
							
							$arr["login_time_min"] = $LRowEst->login_time_min;
							$arr["logout_time_max"] =$LRowEst->logout_time_max;
							
							$arr["flogin_time"] = $LRowEst->flogin_time;
							$arr["logout_time"] =$LRowEst->llogout_time;
							$arr["logged_in_hours"] = round(($LRowEst->tLtime/3600),2);
							$arr["logged_in_sec"] = $LRowEst->tLtime-1;
							
							$login_details = explode(" ",$LRowEst->flogin_time);
							$arr["login_date"] = $login_details[0];
							$arr["login_time"] = $login_details[1];
							$arr["logout_log_est"] = $LRowEst->logout_log_est;
							$arr["login_log_est"] = $LRowEst->login_log_est;
						}
						else
						{
							
							$arr["logout_by"] = "";
							
							$arr["login_time_min"] = "";
							$arr["logout_time_max"] = "";
							
							$arr["flogin_time"] ="";
							$arr["logout_time"] = "";
							$arr["logged_in_hours"] = "0";
							$arr["logged_in_sec"] = "0";
							$arr["login_date"] = "";
							$arr["login_time"] = "";
							$arr["iplog_est"] = "";
							$arr["logout_log_est"] = "";
							$arr["login_log_est"] = "";
							
						}
						
						if($LResLocal->num_rows() > 0)
						{	
							$arr["logout_by"] = $LRowLocal->logout_by;
							$arr["login_time_local_min"] = $LRowLocal->login_time_local_min;
							$arr["logout_time_local_max"] = $LRowLocal->logout_time_local_max;

							$arr["flogin_time_local"] = $LRowLocal->flogin_time_local;
							$arr["logout_time_local"] =$LRowLocal->llogout_time_local;
							$arr["logged_in_hours_local"] = round(($LRowLocal->tLtimeLocal/3600),2);
							$arr["logged_in_sec_local"] = $LRowLocal->tLtimeLocal -1;
							
							$login_detailsLocal = explode(" ",$LRowLocal->flogin_time_local);
							$arr["login_date_local"] = $login_detailsLocal[0];
							$arr["login_time_local"] = $login_detailsLocal[1];
							
							$arr["NightLogin"] = $LRowLocal->tNightLogin;
							
							$arr["logout_log_local"] = $LRowLocal->logout_log_local;
							$arr["login_log_local"] = $LRowLocal->login_log_local;
							
							
							
						}
						else
						{
							$arr["logout_by"] = "";
							$arr["login_time_local_min"] = "";
							$arr["logout_time_local_max"] = "";
							$arr["flogin_time_local"] ="";
							$arr["logout_time_local"] = "";
							$arr["logged_in_hours_local"] = 0;
							$arr["logged_in_sec_local"] = 0;
							$arr["login_date_local"] = "";
							$arr["login_time_local"] = "";
							$arr["NightLogin"] = 0;
							$arr["logout_log_local"] = "";
							$arr["login_log_local"] = "";
						}
																		
						if($ldResEst->num_rows() > 0) $arr["ldBrkTime"] = $ldRowEst->ldBrkTime;
						else $arr["ldBrkTime"] ="0";
						
						if($ldResLocal->num_rows() > 0) $arr["ldBrkTimeLocal"] = $ldRowLocal->ldBrkTimeLocal;
						else $arr["ldBrkTimeLocal"] ="0";
						
						
						if($brkResEst->num_rows() > 0) $arr["tBrkTime"] = $brkRowEst->tBrkTime;
						else $arr["tBrkTime"] ="0";
						
												
						if($brkResLocal->num_rows() > 0) $arr["tBrkTimeLocal"] = $brkRowLocal->tBrkTimeLocal;
						else $arr["tBrkTimeLocal"] ="0";
						
												
						if($dispRes->num_rows() > 0){
													
							$arr["event_date"] = $dispRow->event_time;
							$arr["event_by"] = $dispRow->evt_by_name;
							$arr["event_start_date"] = $dispRow->start_date;
							$arr["event_end_date"] = $dispRow->end_date;
							$arr["event_remarks"] = $dispRow->remarks;
							$arr["disposition"] = $disp_name;
							$arr["comments"] = $dispRow->remarks;
							$arr["ticket_no"] = $dispRow->ticket_no;
							
						}
						else
						{
							$arr["event_date"] = "";
							$arr["event_by"] = "";
							$arr["event_start_date"] = "";
							$arr["event_end_date"] = "";
							$arr["event_remarks"] = "";
							$arr["disposition"] = $disp_name;
							$arr["comments"] = "";
							$arr["ticket_no"] ="";
						}
						
						if($term_date<$cDate && $row->status ==0) {
							$arr["event_remarks"] = $term_msg;
							$arr["comments"] = $term_msg;
						}
							
						
						$new_arr[] = $arr;
					}
		}
		
		return $new_arr;
	}
	
	public function get_user_list_report_with_mld($filterArr,$exCond="",$is_sch='N',$is_leave='Y')
    {
		
		if($this->RepDB==null) $this->set_report_database();
		
		
		ini_set('precision',12);
		
		$role_check = ""; 
		
		//if(get_role_id() !=1){ $role_check = " and role_id in (2,3,4,5)";}
		
		$role_check = " and role_id > 0";
				
		$start_date =$filterArr['start_date'];
		$end_date =$filterArr['end_date'];
		
		if(isset($filterArr['client_id'])) $client_id =$filterArr['client_id'];
		else $client_id="";
		
		if(isset($filterArr['office_id'])) $office_id =$filterArr['office_id'];
		else $office_id="";
		
		if(isset($filterArr['dept_id'])) $dept_id =$filterArr['dept_id'];
		else $dept_id="";
		
		if(isset($filterArr['sub_dept_id'])) $sub_dept_id =$filterArr['sub_dept_id'];
		else $sub_dept_id="";
		
		if(isset($filterArr['site_id'])) $site_id =$filterArr['site_id'];
		else $site_id="";
		
		$filter_key =$filterArr['filter_key'];
		
		$user_site_id =$filterArr['user_site_id'];
		$assigned_to=$filterArr['assigned_to'];
		
		$filter_value="";
				
		$_cnd="";
		
		//if($client_id!=="" && $client_id!="ALL")  $_cnd = " and client_id = '".$client_id."'";
		if($client_id!="" && $client_id!="ALL")  $_cnd = " And is_assign_client (b.id,$client_id)";
					
		if($dept_id!="" && $dept_id!="ALL")  $_cnd .= " and dept_id = '".$dept_id."'";
		
		if($sub_dept_id!="" && $sub_dept_id!="ALL")  $_cnd .= " and sub_dept_id = '".$sub_dept_id."'";
				
		if($client_id=='1'){
				
				if($site_id!=="" && $site_id!="ALL")  $_cnd .= " and site_id = '".$site_id."'";
		}else{
				if($office_id!=="" && $office_id!="ALL")  $_cnd .= " and office_id = '".$office_id."'";
		}
		
		$filter_value =$filterArr['filter_value'];
		
		if($filter_key!="" && $filter_key!="OfflineList" && strtoupper($filter_value)!="ALL" && $filter_value!=""){
		
			
			
			switch($filter_key){
				case 'Site':
					$_cnd .= " and site_id = '".$filter_value."'";
					break;
				case 'Agent':
					$filter_value = implode("','",explode(',', $filter_value));
					$_cnd = " and  (omuid in ('".$filter_value."') OR fusion_id in ('".$filter_value."') ) ";
					//$_cnd .= " and  (omuid = '".$filter_value."' OR fusion_id='".$filter_value."') ";
					break;
				case 'Process':
					//$_cnd .= " and 	process_id = '".$filter_value."'";
					if($filter_value !="0") $_cnd .= " and is_assign_process(b.id,$filter_value)";
					break;
				case 'Role':
					$_cnd .= " and 	role_id = '".$filter_value."'";
					break;
				case 'AOF':
					$_cnd .= " and 	assigned_to = '".$filter_value."'";
					break;		
			}	
		}
							
		/*
		if(get_global_access()==1 || get_role_dir()=="super" || get_role_dir()=="support" || get_dept_folder()=="mis" || get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm"){
			
			$_cnd .= "";
			
		}else{
			if($user_site_id!="" && $user_site_id!="0" && $user_site_id!="ALL" ) $_cnd .= " and site_id = '".$user_site_id."'";
		}
		*/
				
		if($assigned_to!="" && $assigned_to!="ALL" ) $_cnd .= " and assigned_to = '".$assigned_to."'";
		
		if($exCond!="") $_cnd .= $exCond;
		
		//echo $_cnd;
		//echo "2. ". $start_date . " >> " .	$end_date . "\r\n";
		
		$st_date = mmddyy2mysql($start_date);
		$en_date = mmddyy2mysql($end_date);
		
		//echo "3. ".$st_date . " >> " .	$en_date . "\r\n";
		
		if($filter_key=="OfflineList") $_cnd .= " AND is_logged_in=0 ";
		
		$prv_term_cond="";
		if($filter_key=="Agent"){
			//$stCond= " and status in (0,1,2,3,4,8,9)";
			$stCond= " ";
			
		}else{
			
			$stCond = " and status not in (8,9) ";
			//$stCond= " and status not in (4,9)";
									
			//$prv_term_cond=" and b.id not in (Select user_id from terminate_users where cast(terms_date as date)<='$st_date' AND ( rejon_date is null OR rejon_date>'$en_date' ) and is_term_complete = 'Y' ) ";
			
			$prv_term_cond=" (Select DISTINCT user_id from terminate_users where date(terms_date)<='$st_date' AND ( rejon_date is null OR rejon_date>'$en_date' ) and is_term_complete = 'Y' ) ";
						
		}
		
		$_discnd="";
		if($filter_key=="Disposition"){		
			if($filter_value=="1")
				$_discnd = " and is_logged_in=0 ";
			else 
				$_discnd = " and b.id in ( SELECT DISTINCT user_id FROM  event_disposition  where event_master_id in (".$filter_value.") and (start_date >= '".$st_date."' and end_date <= '".$en_date."')) ";
		}
			
		if($filter_key=="Agent"){
			//(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,
			$qSQL=" Select *, last_logged_date as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name,  (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b Where (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ". $_cnd . " $_discnd Order By fname ";
		}else{
			//(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, 
			
			$qSQL=" Select *, last_logged_date as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b LEFT JOIN $prv_term_cond tn ON b.id = tn.user_id Where tn.user_id IS NULL AND (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ".$role_check . $_cnd . " $_discnd Order By fname ";
			
		}
		
		//echo $qSQL . "\r\n\r\n";
		$ListQuery = $this->RepDB->query($qSQL);
				
		///////////////////////////////////////////////////////////////////////////////////////////
		
		$start = strtotime($st_date);
		$end = strtotime($en_date);
					
		// start and end are seconds, so I convert it to days 
		$diff = ($end - $start) / 86400; 
		
		//echo "4. ". $diff ."\r\n";
		
		if($office_id!="" && $office_id!="ALL") $todayDate = GetLocalDateByOffice($office_id);
		else $todayDate=CurrDate();
		
		$new_arr = array();
		$disp_name="";
		
		$term_ids=" ,";
		
		//added
		
		
		for ($i = 0; $i <= $diff; $i++) {
			
			$cDate= date('Y-m-d', $start);
			//echo "5. " . $cDate  ." == " . $todayDate . "\r\n";
			$start = strtotime($cDate .' +1 day');
			
			/*
			$_discnd="";
			if($filter_key=="Disposition"){		
				if($filter_value=="1")
					$_discnd = " and is_logged_in=0 ";
				else 
					$_discnd = " and b.id in ( SELECT DISTINCT user_id FROM  event_disposition  where event_master_id in (".$filter_value.") and (start_date <= '".$cDate."' and end_date >= '".$cDate."')) ";
			}
			*/
			
			if($filter_key=="OfflineList" || $filter_key=="Disposition" || $filter_key=="Agent"){
				if($cDate>$todayDate) break;
			}else{
				if($cDate>=$todayDate) break;
			}
									
			///////////// For Schedule ////
			$currDay=strtolower(date('D', strtotime($cDate)));
			
			/*
				$fielsIn=$currDay."_in";
				$fielsOut=$currDay."_out";
						
				if(date('D', strtotime($cDate)) == "Mon") $shMonDate=$cDate;
				else $shMonDate=date('Y-m-d',strtotime($cDate.' -1 Monday'));
				if(date('D', strtotime($cDate)) == "Sun") $shSunDate=$cDate;
				else $shSunDate=date('Y-m-d',strtotime($cDate.' +1 Sunday'));
			*/
			
			//////////////////////// 
			
				//$qSQL="select *,(select name from process where b.process_id = process.id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name from signin b where $stCond ".$role_check . $_cnd . " Order By fname";
		
				
				/*
				if($filter_key=="Agent"){
					$qSQL=" Select *, last_logged_date as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b Where (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ". $_cnd . " $_discnd Order By fname ";
				}else{
					$qSQL=" Select *, last_logged_date as todayLoginTime, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_client_names(b.id) as client_name , get_process_names(b.id) as process_name, (Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, b.status from signin b LEFT JOIN $prv_term_cond tn ON b.id = tn.user_id Where tn.user_id IS NULL AND (doj<='$en_date' or doj IS NULL or doj = '0000-00-00' ) $stCond ".$role_check . $_cnd . " $_discnd Order By fname ";
					
				}
				*/
				//echo $qSQL . "\r\n<br><br>\r\n";
				//$ListQuery = $this->RepDB->query($qSQL);
				
				$res = $ListQuery->result();
				
				foreach($res as $row)
				{
					$arr = array();
					
					///////////// Schedule ////
					if($is_sch=="Y"){
					
						//$qSql="Select user_id,$fielsIn,$fielsOut from user_shift_schedule where start_date='$shMonDate' and end_date='$shSunDate' and user_id = $row->id";
						
						$qSql="Select user_id,in_time,out_time from user_shift_schedule where shdate='$cDate' and shday='$currDay' and user_id = $row->id";
						
						//echo $qSql ."\r\n";
						
						$sch_q = $this->RepDB->query($qSql);
						$sch_row = $sch_q->row_array();
						
						if (isset($sch_row)){
							//$arr['sch_in'] = $sch_row[$fielsIn];
							//$arr['sch_out'] = $sch_row[$fielsOut];

							$arr['sch_in'] = $sch_row['in_time'];
							$arr['sch_out'] = $sch_row['out_time'];	
							
						}else{
							$arr['sch_in'] = "";
							$arr['sch_out'] = "";	
						}
					}else{
						$arr['sch_in'] = "";
						$arr['sch_out'] = "";	
					}
					
					///////// end Schedule
					
					
					///////////// Leave ////
					if($is_leave=="Y"){
					
						
						$qSql="SELECT user_id,leave_type_id,from_dt,to_dt,status, (select abbr from leave_type where leave_type.id=leave_type_id ) as leave_type FROM leave_applied where from_dt<='$cDate' and to_dt>='$cDate' and status in (0,1) and user_id = $row->id";
												
						//echo $qSql ."\r\n";
						
						$leave_q = $this->RepDB->query($qSql);
						$leave_row = $leave_q->row_array();
						
						if (isset($leave_row)){
							$arr['leave_status'] = $leave_row['status'];
							$arr['leave_type'] = $leave_row['leave_type'];	
							
						}else{
							$arr['leave_status'] = "";
							$arr['leave_type'] = "";	
						}
					}else{
						$arr['leave_status'] = "";
						$arr['leave_type'] = "";	
					}
					
					///////// end Leave
					
					///
					
					//$_dq = "select *,timediff(logout_time,login_time) as tLtime from logged_in_details where user_id = $row->id and cast(login_time as date) = '".$cDate."' and cast(logout_time as date) >= '".$cDate."'";
					
					//$_dq = "select user_id,logout_by,min(login_time) as flogin_time,max(logout_time) as llogout_time, SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,login_time,logout_time))) as tLtime from logged_in_details where user_id = $row->id and cast(login_time as date) = '".$cDate."'  group by user_id";
					
					//working login est 
					//$LSqlEst = "select user_id,logout_by, min(login_time) as flogin_time, max(logout_time) as llogout_time, SUM(TIMESTAMPDIFF(SECOND,login_time,logout_time)) as tLtime from logged_in_details where user_id = $row->id and date(login_time) = '".$cDate."'  group by user_id";
					
					$LSqlEst = "select user_id,logout_by, min(login_time) as login_time_min, group_concat(login_time  separator ', ') as flogin_time, max(logout_time) as logout_time_max, group_concat(logout_time  separator ', ') as llogout_time, SUM(TIMESTAMPDIFF(SECOND,login_time,logout_time)) as tLtime, substring(log, locate('RemoteIP', log), length(log)) as logout_log_est, login_log as login_log_est from logged_in_details where user_id = $row->id and date(login_time) = '".$cDate."'  group by user_id";
					
					
					$LResEst = $this->RepDB->query($LSqlEst);
					$LRowEst = $LResEst->row();
					
					////Using login Local Time 
										
					//$LSqlLocal = "select user_id, logout_by, min(getEstToLocal(login_time,user_id)) as flogin_time_local , max(getEstToLocal(logout_time,user_id)) as llogout_time_local ,  SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(login_time,user_id), getEstToLocal(logout_time,user_id))) as tLtimeLocal from logged_in_details where user_id = $row->id and date(getEstToLocal(login_time,user_id)) = '".$cDate."'  group by user_id";
					
					$office_id=$row->office_id;
					
					$LSqlLocal = "select user_id, logout_by, min(login_time_local) as login_time_local_min , group_concat(login_time_local  separator ', ') as flogin_time_local ,  max(logout_time_local) as logout_time_local_max , group_concat(logout_time_local,  separator ', ') as llogout_time_local ,  SUM(TIMESTAMPDIFF(SECOND,login_time_local, logout_time_local)) as tLtimeLocal, SUM(getNightLoginSec(login_time_local,logout_time_local,'$office_id')) tNightLogin, substring(log, locate('RemoteIP', log), length(log)) as logout_log_local, login_log as login_log_local  from logged_in_details where user_id = $row->id and date(login_time_local) = '".$cDate."'  group by user_id";
					
					$LResLocal = $this->RepDB->query($LSqlLocal);
					$LRowLocal = $LResLocal->row();
					
					//////////////////////////// new update
					
					$est_login_time = $cDate;
					$est_logout_time = $cDate;
					if($LResEst->num_rows()>0){
						$est_login_time = $LRowEst->login_time_min;
						$est_logout_time = $LRowEst->logout_time_max;
						
					}
					
					$local_login_time = $cDate;
					$local_logout_time = $cDate;
					
					if($LResLocal->num_rows()>0){
						$local_login_time = $LRowLocal->login_time_local_min;
						$local_logout_time = $LRowLocal->logout_time_local_max;
					}
						
					//////////////////////
					
					//working login manual old 
					//$_mlsql = "select user_id,added_by as madded_by,disp_id as mdisp_id,comments as mcomments, login_time as mlogin_time,max(logout_time) as mlogout_time, SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,login_time,logout_time))) as tMLtime from logged_in_details_manual where user_id = $row->id and cast(login_time as date) = '".$cDate."'  group by user_id";
					
					////Using login manual Local Time 					
					$_mlsql = "select user_id,(select CONCAT(fname,' ' ,lname) from signin s where s.id=m.added_by) as madded_by ,disp_id as mdisp_id,comments as mcomments, login_time as mlogin_time, getLocalToEst(login_time,user_id) as mlogin_time_est, logout_time as mlogout_time, getLocalToEst(logout_time,user_id) as mlogout_time_est, TIMESTAMPDIFF(SECOND,login_time,logout_time) as tMLtime from logged_in_details_manual m where user_id = $row->id and date(login_time) = '".$cDate."' ";
					
					//echo $_mlsql ."\r\n";
					$_mlQuery= $this->RepDB->query($_mlsql);
					$_mlres = $_mlQuery->result();
					
					/////
					
					//working break_details_ld est 
					//$ldSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as ldBrkTime from break_details_ld where user_id = $row->id and date(out_time) = '".$cDate."' group by user_id";
					
					$ldSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as ldBrkTime from break_details_ld where user_id = $row->id and out_time BETWEEN '".$est_login_time."' AND '".$est_logout_time."' group by user_id";
					
					$ldResEst = $this->RepDB->query($ldSqlEst);
					$ldRowEst = $ldResEst->row();
					
					//working break_details_ld Local Time 		 
					//$ldqSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as ldBrkTimeLocal from break_details_ld where user_id = $row->id and date(getEstToLocal(out_time,user_id)) = '".$cDate."' group by user_id";
					
					// $ldqSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as ldBrkTimeLocal from break_details_ld where user_id = $row->id and date(out_time_local) = '".$cDate."' group by user_id";
					
					$ldqSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as ldBrkTimeLocal from break_details_ld where user_id = $row->id and out_time_local BETWEEN '".$local_login_time."' AND '".$local_logout_time."' group by user_id";
						
					$ldResLocal = $this->RepDB->query($ldqSqlLocal);
					$ldRowLocal = $ldResLocal->row();
					
					
					//working break_details est 
					//$brkSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as tBrkTime from break_details where user_id = $row->id and date(out_time) = '".$cDate."' group by user_id";
					
					$brkSqlEst ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time,in_time)) as tBrkTime from break_details where user_id = $row->id and out_time BETWEEN '".$est_login_time."' AND '".$est_logout_time."' group by user_id";
					
					$brkResEst = $this->RepDB->query($brkSqlEst);
					$brkRowEst = $brkResEst->row();
					
					//working break_details Local Time 		 
					//$brkSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(out_time,user_id),getEstToLocal(in_time,user_id))) as tBrkTimeLocal from break_details where user_id = $row->id and date(getEstToLocal(out_time,user_id)) = '".$cDate."' group by user_id";
					
					//$brkSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as tBrkTimeLocal from break_details where user_id = $row->id and date(out_time_local) = '".$cDate."' group by user_id";
					
					$brkSqlLocal ="select user_id, SUM(TIMESTAMPDIFF(SECOND,out_time_local,in_time_local)) as tBrkTimeLocal from break_details where user_id = $row->id and out_time_local BETWEEN '".$local_login_time."' AND '".$local_logout_time."' group by user_id";
										
					$brkResLocal = $this->RepDB->query($brkSqlLocal);
					$brkRowLocal = $brkResLocal->row();
												
					///
					$dispSql = "select *,(select CONCAT(fname,' ' ,lname) from signin s where s.id=y.event_by) as evt_by_name ,(select name from event_master x where x.id=y.event_master_id )as disposition from event_disposition y where y.user_id = $row->id and (start_date <= '".$cDate."' and end_date >= '".$cDate."') Order by id desc limit 1";
					
					//echo $dispSql. "<br>";
					
					$dispRes = $this->RepDB->query($dispSql);
					$dispRow = $dispRes->row();
					
					
														
					if($filter_key=="Disposition" && $filter_value=="1"){
						if($LResLocal->num_rows() > 0){
							if($LRowLocal->tLtimeLocal!="" ) continue;
						}
						
						if($dispRes->num_rows() > 0){
							$disp_name=$dispRow->disposition;
							if($dispRow->disposition !="") continue;
						}
					}
					
					
					$term_date="";
					if( $row->status ==0){
						$termSql = "SELECT date(terms_date) as terms_date FROM terminate_users where user_id = $row->id and is_term_complete ='Y' order by id desc limit 1";
						
						$termRes = $this->RepDB->query($termSql);
						$termRow = $termRes->row();
						$term_date= $termRow->terms_date;
						$term_msg = "Term on ". $term_date;
					}
					
					
					if($filter_key=="Agent"){
						
						if(stripos($disp_name, "TERM")!== false){
								$_sqlr = "select id from event_disposition  where user_id = $row->id and (start_date = '".$cDate."' and end_date = '".$cDate."')";	
								$_rqrj = $this->RepDB->query($_sqlr);
								if($_rqrj->num_rows() <= 0)	continue;
						}					
					}
					
					
					$disp_name="";
					$user_disp_id="";
					if($dispRes->num_rows() > 0){
							$disp_name=$dispRow->disposition;
							$user_disp_id=$dispRow->event_master_id;
								
					}
					
					if($term_date<=$cDate && $row->status ==0) $disp_name="TERM";
					
						
						if($user_disp_id==8) $term_ids=str_replace(",".$row->id.",", ",", $term_ids);
						//echo $term_ids. " " . $row->id. " >> ." . stripos($term_ids,$row->id) . " .\r\n";
						if(stripos($term_ids,",".$row->id.",")!== false && $user_disp_id!=8) $disp_name="X";
						else if(strtoupper($disp_name)=="TERM") $term_ids .=$row->id.",";
						//echo $term_ids ."\n\r";
						
						
						////
					
						$arr["rDate"] = $cDate;
						$arr["id"] = $row->id;
						$arr["client_name"] = $row->client_name;
						$arr["fusion_id"] = $row->fusion_id;
						$arr["omuid"] = $row->omuid;
						$arr["xpoid"] = $row->xpoid;
						
						$arr["office_id"] = $row->office_id;
						$arr["dept_name"] = $row->dept_name;
						$arr["sub_dept_name"] = $row->sub_dept_name;
						
						$arr["red_login_id"] = $row->red_login_id;
						//$arr["passwd"] = $row->passwd;
						$arr["fname"] = $row->fname;
						$arr["lname"] = $row->lname;
						$arr["site_id"] = $row->site_id;
						$arr["role_id"] = $row->role_id;
						//$arr["process_id"] = $row->process_id;
						$arr["assigned_to"] = $row->assigned_to;
						$arr["created_date"] = $row->created_date;
						$arr["process_name"] = $row->process_name;
						//$arr["sub_process_name"] = $row->sub_process_name;
						$arr["site_name"] = $row->site_name;
						$arr["asign_tl"] = $row->asign_tl;
						$arr["role_name"] = $row->role_name;
						$arr["doj"] = $row->doj;
						$arr["user_disp_id"] = $user_disp_id;
						
						$arr["todayLoginTime"] = $row->todayLoginTime;
						$arr["is_logged_in"] = $row->is_logged_in;
						
						//$_ff = $this->
						///$cDate=CurrDate();
											
						if($LResEst->num_rows() > 0)
						{
							$arr["logout_by"] = $LRowEst->logout_by;
							
							$arr["login_time_min"] = $LRowEst->login_time_min;
							$arr["logout_time_max"] =$LRowEst->logout_time_max;
							
							$arr["flogin_time"] = $LRowEst->flogin_time;
							$arr["logout_time"] =$LRowEst->llogout_time;
							$arr["logged_in_hours"] = round(($LRowEst->tLtime/3600),2);
							$arr["logged_in_sec"] = $LRowEst->tLtime-2;
							
							$login_details = explode(" ",$LRowEst->flogin_time);
							$arr["login_date"] = $login_details[0];
							$arr["login_time"] = $login_details[1];
							$arr["logout_log_est"] = $LRowEst->logout_log_est;
							$arr["login_log_est"] = $LRowEst->login_log_est;
							
																					
							
						}
						else
						{
							$arr["logout_by"] = "";
							$arr["login_time_min"] = "";
							$arr["logout_time_max"] = "";
							
							$arr["flogin_time"] ="";
							$arr["logout_time"] = "";
							$arr["logged_in_hours"] = "0";
							$arr["logged_in_sec"] = "0";
							$arr["login_date"] = "";
							$arr["login_time"] = "";
							$arr["logout_log_est"] = "";
							$arr["login_log_est"] = "";
														
							
						}
						
						
						if($LResLocal->num_rows() > 0)
						{
							
							$arr["logout_by"] = $LRowLocal->logout_by;
							
							$arr["login_time_local_min"] = $LRowLocal->login_time_local_min;
							$arr["logout_time_local_max"] = $LRowLocal->logout_time_local_max;
							
							$arr["flogin_time_local"] = $LRowLocal->flogin_time_local;
							$arr["logout_time_local"] =$LRowLocal->llogout_time_local;
							$arr["logged_in_hours_local"] = round(($LRowLocal->tLtimeLocal/3600),2);
							$arr["logged_in_sec_local"] = $LRowLocal->tLtimeLocal-1;
							
							$login_detailsLocal = explode(" ",$LRowLocal->flogin_time_local);
							$arr["login_date_local"] = $login_detailsLocal[0];
							$arr["login_time_local"] = $login_detailsLocal[1];
							
							$arr["NightLogin"] = $LRowLocal->tNightLogin;
							
							$arr["logout_log_local"] = $LRowEst->logout_log_local;
							$arr["login_log_local"] = $LRowEst->login_log_local;
							
							
						}
						else
						{
							$arr["login_time_local_min"] = "";
							$arr["logout_time_local_max"] = "";
							
							$arr["flogin_time_local"] ="";
							$arr["logout_time_local"] = "";
							$arr["logged_in_hours_local"] = 0;
							$arr["logged_in_sec_local"] = 0;
							$arr["login_date_local"] = "";
							$arr["login_time_local"] = "";
							$arr["NightLogin"] =0;
							$arr["iplog_local"] = "";
							
							$arr["logout_log_local"] = "";
							$arr["login_log_local"] = "";
							
							
						}
						
						
						if($_mlQuery->num_rows() > 0)
						{
							$arr["is_manual_entry"] = "Y";
							
							$m_array= array();
							foreach($_mlres as $_mlrow)
							{
								$tmp_array = array();
								
								$tmp_array["mlogin_time_local"] = $_mlrow->mlogin_time;
								$tmp_array["mlogout_time_local"] =$_mlrow->mlogout_time;
								
								$tmp_array["mlogin_time"] = $_mlrow->mlogin_time_est;
								$tmp_array["mlogout_time"] =$_mlrow->mlogout_time_est;
								
								$tmp_array["madded_by"] = $_mlrow->madded_by;
								$tmp_array["mdisp_id"] = $_mlrow->mdisp_id;
								$tmp_array["mcomments"] =$_mlrow->mcomments;
								$tmp_array["mlogged_in_hours"] = round(($_mlrow->tMLtime/3600),2);
								$tmp_array["mlogged_in_hours_sec"] = $_mlrow->tMLtime;
								
								$m_array[] = $tmp_array;
							}
							
							$arr['manual_array']= $m_array;
							
						}else $arr["is_manual_entry"] = "N";
						
						
						if($ldResEst->num_rows() > 0) $arr["ldBrkTime"] = $ldRowEst->ldBrkTime;
						else $arr["ldBrkTime"] ="0";
						
						if($ldResLocal->num_rows() > 0) $arr["ldBrkTimeLocal"] = $ldRowLocal->ldBrkTimeLocal;
						else $arr["ldBrkTimeLocal"] ="0";
						
						
												
						if($brkResEst->num_rows() > 0) $arr["tBrkTime"] = $brkRowEst->tBrkTime;
						else $arr["tBrkTime"] ="0";
						
												
						if($brkResLocal->num_rows() > 0) $arr["tBrkTimeLocal"] = $brkRowLocal->tBrkTimeLocal;
						else $arr["tBrkTimeLocal"] ="0";
						
						
						if($dispRes->num_rows() > 0){
													
							$arr["event_date"] = $dispRow->event_time;
							$arr["event_by"] = $dispRow->evt_by_name;
							$arr["event_start_date"] = $dispRow->start_date;
							$arr["event_end_date"] = $dispRow->end_date;
							$arr["event_remarks"] = $dispRow->remarks;
							$arr["disposition"] = $disp_name;
							$arr["comments"] = $dispRow->remarks;
							$arr["ticket_no"] = $dispRow->ticket_no;
							
						}
						else
						{
							$arr["event_date"] = "";
							$arr["event_by"] = "";
							$arr["event_start_date"] = "";
							$arr["event_end_date"] = "";
							$arr["event_remarks"] = "";
							$arr["disposition"] = $disp_name;
							$arr["comments"] = "";
							$arr["ticket_no"] ="";
						}
						
						if($term_date<$cDate && $row->status ==0) {
							$arr["event_remarks"] = $term_msg;
							$arr["comments"] = $term_msg;
						}
						
						$new_arr[] = $arr;
					}
		}
		
		
		return $new_arr;
	}
	
	///	
	
	
	public function getLoginTime($rDate,$uid)
    {
		
		$tLogedin=0;
		
		
		$qSql = "select sum(TIME_TO_SEC(timediff(logout_time,login_time))) as tLtime from logged_in_details where user_id = $uid and date(login_time) <= '".$rDate."' and date(logout_time) >= '".$rDate."'";
		
		$result = $this->db->query($qSql);
		if($result->num_rows()> 0){
			$tLogedin =$result->row()->tLtime;
		}else{
			$tLogedin=0;
		}
		return $tLogedin;
	}
	
	
	
		
	public function gethistoryusernData($filterArr)
    {
		
		if($this->RepDB==null) $this->set_report_database();
		
		$start_date =$filterArr['start_date'];
		$end_date =$filterArr['end_date'];	
		$office_id =$filterArr['office_id'];
		
		$evt_cond="";
		
		if($start_date!="" && $end_date!=""){
			$start_date = mmddyy2mysql($start_date);
			$end_date = mmddyy2mysql($end_date);
		
			$evt_cond .=" and affected_date>='".$start_date."' and affected_date<='".$end_date."' ";
		}
		
		$cond="";
		if($office_id!="") $cond .=" and office_id='$office_id'";
		 
 
		 $qSql="SELECT a.*, getHistryFormTo(h_type,from_id) as m_from_name,
			 getHistryFormTo(h_type,to_id) as m_to_name,
			 (Select name from history_type mt where mt.id=a.h_type) as m_type_name, 
			 fusion_id, office_id, fname, lname, role_id, omuid, xpoid, status,assigned_to,doj, 
			 (Select name from site z where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin
			 x where x.id=b.assigned_to) as asign_tl FROM 
			 history_emp_all a , signin b where a.user_id=b.id  $evt_cond $cond ";
					
		//and a.is_complete != 'R'
		//echo $qSql;
		
		$query = $this->RepDB->query($qSql);
		return $query->result_array();
		
	}
	
////////////////////////Policy Report///////////////////////////////
///////
		public function get_policy_acceptance_report($field_array){
			
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			
			if($this->RepDB==null) $this->set_report_database();
			
			$policy_id = $field_array['policy_id'];	
			
			$cond="";
			
			if($policy_id!=""){
				$cond .=" and policy_id='".$policy_id."' ";
			}
			
			if(get_global_access() !=1) $cond .= " and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%')) ";
			
			//$qSql="SELECT * from (Select * from policy_list where is_active=1 $cond ) xx Left Join (Select pa.policy_id, pa.user_id, pa.policy_datetime, DATE_FORMAT(policy_datetime,'%m/%d/%Y') as policyDate, (select concat(fname, ' ', lname) as name from signin x where x.id=pa.user_id) as user_name, (select office_id from signin o where o.id=pa.user_id) as user_office, (select role_id from signin r where r.id=pa.user_id) as user_role, (select name from role d where d.id=user_role) as userRoleName, (select client_id from info_assign_client iac where iac.user_id=pa.user_id) as user_clien_id, (select shname from client c where c.id=user_clien_id) as userClient from policy_acceptance pa) yy On (xx.id=yy.policy_id) ";	
			
			
			$qSql="Select pa.*, date(accepted_datetime)as accptdate, fname,lname,sn.fusion_id,sn.xpoid,sn.omuid,sn.office_id,sn.role_id, (Select title from policy_list pl where pl.id=pa.policy_id) as policy_titile, (select name from role r where r.id=sn.role_id) as userRoleName from policy_acceptance pa, signin sn where  pa.user_id=sn.id  $cond  group by user_id order by office_id, fname";
			
			//echo $qSql . "\r\n";
			
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}
	
	
//////////////////////////Process Update Report////////////////////////////////
///////
		public function get_process_update_acceptance_report($field_array){
			
			
			if($this->RepDB==null) $this->set_report_database();

			$process_update_id = $field_array['process_update_id'];	
			$user_id = $field_array['user_id'];
			$office_id =$field_array['office_id'];
			$cValue= $field_array['client_id'];			
			
			$cond="";
			
			if($process_update_id!=""){
				$cond .=" and pu_id='".$process_update_id."' ";
			}
			
			if(get_role_dir()!="super" || get_global_access()!=1 && get_role_dir()!="agent"){
				$cond .=" and user_id!='".$user_id."' ";
			}
			
			if($office_id!="") $cond .=" and office_id='$office_id'";
			
			if($cValue!="ALL" && $cValue!="") $cond .=" And is_assign_client (sn.id,$cValue)";
				
			//$qSql="Select *, (select fusion_id from signin x where x.id=pua.user_id) as fusion_id, (Select title from process_updates pu where pu.id=pua.pu_id) as pu_titile, (select concat(fname, ' ', lname) as name from signin x where x.id=pua.user_id) as user_name, (select office_id from signin o where o.id=pua.user_id) as user_office, (select client_id from process_updates puc where puc.id=pua.pu_id) as pu_client_id, (select shname from client c where c.id=pu_client_id) as pu_client, (select process_id from process_updates pup where pup.id=pua.pu_id) as pu_process_id, (select name from process p where p.id=pu_process_id) as pu_process, (select role_id from signin r where r.id=pua.user_id) as user_role, (select name from role d where d.id=user_role) as userRoleName from process_updates_acceptance pua $cond ";
			
			//$qSql="Select pa.*, date(accepted_datetime)as accptdate, fname,lname,sn.fusion_id,sn.omuid,sn.xpoid,sn.office_id,sn.role_id, get_client_ids(sn.id) as client_ids, get_process_ids(sn.id) as process_ids, get_client_names(sn.id) as client_name, get_process_names(sn.id) as process_name, (Select title from process_updates pu where pu.id=pa.pu_id) as pu_titile,(Select added_date from process_updates pu where pu.id=pa.pu_id) as Upload_Date, (select name from role r where r.id=sn.role_id) as userRoleName from process_updates_acceptance pa, signin sn where  pa.user_id=sn.id  $cond ";

			$qSql="Select pa.*, accepted_datetime as accptdate, fname,lname,sn.fusion_id,sn.omuid,sn.xpoid,sn.office_id,sn.role_id, get_client_ids(sn.id) as client_ids, get_process_ids(sn.id) as process_ids, get_client_names(sn.id) as client_name, get_process_names(sn.id) as process_name, (Select title from process_updates pu where pu.id=pa.pu_id) as pu_titile,(Select added_date from process_updates pu where pu.id=pa.pu_id) as Upload_Date, (select name from role r where r.id=sn.role_id) as userRoleName from process_updates_acceptance pa, signin sn where  pa.user_id=sn.id  $cond ";
			
			//echo $qSql;
			
			$query = $this->RepDB->query($qSql);
			return $query->result_array();	
		}
		

//////////////////////////User Break Stats////////////////////////////////
///////
	public function user_break_stats($field_array)
	{
		
		if($this->RepDB==null) $this->set_report_database();
		
		$date_from =$field_array['date_from'];
		$date_to =$field_array['date_to'];
		$office_id =$field_array['office_id'];

		if(isset($field_array['dept_id'])) $dept_id =$field_array['dept_id'];
		else $dept_id="";
		
		$cond="";
		
		
		if($date_from !="" && $date_to!=="" )  $cond= " and (date(out_time) >= '$date_from' and date(out_time) <= '$date_to' ) ";
		if($office_id!="" && $office_id!="ALL") $cond .=" and office_id='$office_id'";

		
		
		if($dept_id!="" && $dept_id!="ALL")  $cond .= " and dept_id = '".$dept_id."'";
		
		/*	
		$qSql="	select * from (
				(select t.user_id as t_userid, DATE_FORMAT(t.out_time,'%m/%d/%Y') as out_date, t.out_time as outtime_est, t.in_time as intime_est, 
				getEstToLocal(t.out_time,t.user_id) as outtime_local, getEstToLocal(t.in_time,t.user_id) as intime_local, 'Other' as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				FROM break_details t, signin s where t.user_id=s.id $cond order by out_date asc, fname asc )
				UNION
				(select ld.user_id as ld_userid, DATE_FORMAT(ld.out_time,'%m/%d/%Y') as out_date, ld.out_time as outtime_est, ld.in_time as intime_est, getEstToLocal(ld.out_time,ld.user_id) as outtime_local, getEstToLocal(ld.in_time,ld.user_id) as intime_local, 'Lunch/Dinner' as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				from break_details_ld ld, signin s where ld.user_id=s.id  $cond order by out_date asc, fname asc) ) as x order by fname, out_date ";	
		*/
		
		
				
		$qSql="	select * from (
				(select t.user_id as t_userid, DATE_FORMAT(t.out_time,'%m/%d/%Y') as out_date, t.out_time as outtime_est, t.in_time as intime_est, 
				t.out_time_local as outtime_local, t.in_time_local as intime_local, t.break_type as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				FROM break_details t, signin s where t.user_id=s.id $cond order by out_date asc, fname asc )
				UNION
				(select ld.user_id as ld_userid, DATE_FORMAT(ld.out_time,'%m/%d/%Y') as out_date, ld.out_time as outtime_est, ld.in_time as intime_est, ld.out_time_local as outtime_local, ld.in_time_local as intime_local, 'Coaching' as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				from break_details_cb ld, signin s where ld.user_id=s.id  $cond order by out_date asc, fname asc)
				UNION
				(select ld.user_id as ld_userid, DATE_FORMAT(ld.out_time,'%m/%d/%Y') as out_date, ld.out_time as outtime_est, ld.in_time as intime_est, ld.out_time_local as outtime_local, ld.in_time_local as intime_local, 'Lunch/Dinner' as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				from break_details_ld ld, signin s where ld.user_id=s.id  $cond order by out_date asc, fname asc) ) as x order by fname, out_date ";	
				
		if(get_user_office_id() == "CEB" || get_user_office_id() == "MAN"){
			$break_type =$field_array['break_type'];
			if($break_type!=""){
				
				if($break_type=="coaching"){
					$qSql = "select t.user_id as t_userid, DATE_FORMAT(t.out_time,'%m/%d/%Y') as out_date, t.out_time as outtime_est, t.in_time as intime_est, 
					t.out_time_local as outtime_local, t.in_time_local as intime_local, t.break_type as source,
					s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
					FROM break_details_cb t, signin s where t.user_id=s.id $cond order by out_date asc, fname asc";	
						
				}else{
					$qSql = "select t.user_id as t_userid, DATE_FORMAT(t.out_time,'%m/%d/%Y') as out_date, t.out_time as outtime_est, t.in_time as intime_est, 
					t.out_time_local as outtime_local, t.in_time_local as intime_local, t.break_type as source,
					s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
					FROM break_details t, signin s where t.user_id=s.id $cond order by out_date asc, fname asc";
				}
			}
		}
		
		//add 17-02-2022 18:12
		if(get_user_office_id() == "ELS"){
			$qSql = "select * from (
				(select t.user_id as t_userid, DATE_FORMAT(t.out_time,'%m/%d/%Y') as out_date, t.out_time as outtime_est, t.in_time as intime_est, 
				t.out_time_local as outtime_local, t.in_time_local as intime_local, t.break_type as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				FROM break_details t, signin s where t.user_id=s.id $cond order by out_date asc, fname asc )
				UNION
				(select ld.user_id as ld_userid, DATE_FORMAT(ld.out_time,'%m/%d/%Y') as out_date, ld.out_time as outtime_est, ld.in_time as intime_est, ld.out_time_local as outtime_local, ld.in_time_local as intime_local, 'Lunch/Dinner' as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				from break_details_ld ld, signin s where ld.user_id=s.id  $cond order by out_date asc, fname asc)
				UNION
				(select ld.user_id as ld_userid, DATE_FORMAT(ld.out_time,'%m/%d/%Y') as out_date, ld.out_time as outtime_est, ld.in_time as intime_est, ld.out_time_local as outtime_local, ld.in_time_local as intime_local, 'Coaching' as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				from break_details_cb ld, signin s where ld.user_id=s.id  $cond order by out_date asc, fname asc)
				UNION
				(select sd.user_id as ld_userid, DATE_FORMAT(sd.out_time,'%m/%d/%Y') as out_date, sd.out_time as outtime_est, sd.in_time as intime_est, sd.out_time_local as outtime_local, sd.in_time_local as intime_local, 'System Downtime' as source,
				s.id, s.fusion_id, s.xpoid, s.fname, s.lname, s.office_id, (select shname from department d where d.id=s.dept_id) as dept_name, get_client_names(s.id) as client_name, get_process_names(s.id) as process_name, (select name from role r where r.id=s.role_id) as role_name, (select concat(fname, ' ', lname) as name from signin sg where sg.id=s.assigned_to) as assigned_name
				from break_details_sd sd, signin s where sd.user_id=s.id  $cond order by out_date asc, fname asc) ) as x order by fname, out_date ";
		}		

		//echo $qSql;
				
		$query = $this->RepDB->query($qSql);
		return $query->result_array();	
		
	}	
    
///////////////////////QA OYO Report Model//////////////////////////

	public function qa_oyo_report_model($field_array){
		
		if($this->RepDB==null) $this->set_report_database();
		
		$date_from = $field_array['date_from'];
		$date_to = $field_array['date_to'];
		$office_id = $field_array['office_id'];
		$pValue = $field_array['process_id'];
		$lob = $field_array['lob'];
		$current_user = $field_array['current_user'];
		$cond="";
		$cond1="";
		
		if($pValue=='OYO LIFE'){
			if($date_from !="" && $date_to!=="" )  $cond= " Where (date(audit_date) >= '$date_from' and date(audit_date) <= '$date_to' ) ";
		}else{	
			if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		}
		
		if($office_id=="All") $cond .= "";
		else $cond .=" and office_id='$office_id'";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations' ){
			if(get_user_fusion_id()=='FKOL002879' || get_user_fusion_id()=='FKOL003095' || get_user_fusion_id()=='FKOL015177' || get_user_fusion_id()=='FKOL002155' || get_user_fusion_id()=='FKOL010351' || get_user_fusion_id()=='FKOL010683' || get_user_fusion_id()=='FKOL003923' || get_user_fusion_id()=='FKOL014331' || get_user_fusion_id()=='FKOL014738'){
				$cond1 .="";
			}else{
				$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$cond1 .=" And assigned_to='$current_user'";
		}else{
			$cond1 .="";
		}
		
		if($pValue=='OYO IBD'){
			
			$qSql="SELECT * from (Select ibd.*, (select concat(fname, ' ', lname) as name from signin s where s.id=ibd.team_leader_id) as tl_name, (select office_id from signin s where s.id=ibd.agent_id) as office_id from qa_oyo_inbound_sale_feedback ibd) xx Left Join (Select id as sid, assigned_to from signin) pp on (xx.agent_id=pp.sid) Left Join (select inbound_sale_feedback_id as agent_fid, review_date as agent_rvw_dt, review as agent_rvw from qa_oyo_inbound_sale_agent_review) yy On (xx.id=yy.agent_fid) Left Join (select inbound_sale_feedback_id as mgnt_fid, review_date as mgnt_rvw_dt, review as mgnt_rvw, coach_name from qa_oyo_inbound_sale_mngr_review) zz On (xx.id=zz.mgnt_fid) $cond $cond1";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		
		}else if($pValue=='OYO SIG'){
		
			$qSql="SELECT * from (Select sig.*, (select concat(fname, ' ', lname) as name from signin s where s.id=sig.agent_id) as agent_name, (select concat(fname, ' ', lname) as name from signin s where s.id=sig.tl_id) as tl_name, sig.duration_length as call_duration, sig.call_date_time as record_date_time, (select fusion_id from signin s where s.id=sig.agent_id) as fusion_id, (select office_id from signin s where s.id=sig.agent_id) as office_id from qa_oyosig_feedback sig) xx Left Join (Select id as sid, assigned_to from signin) pp on (xx.agent_id=pp.sid) left join 
			(Select oyo_fd_id as agent_rvw_id, review_date, remarks as agnt_comnt from qa_oyosig_agent_review) yy on (xx.id=yy.agent_rvw_id) left join 
			(Select oyo_fd_id as mgnt_rvw_id, mgnt_review_date, coach_name, note as mgnt_comnt from qa_oyosig_mgnt_review) zz on (xx.id=zz.mgnt_rvw_id) $cond $cond1";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}else if($pValue=='OYO LIFE'){
			
			if($lob=='IB/OB'){
				$qSql="SELECT * from
						(Select *, date(audit_date) as auditDate, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_oyolife_ib_ob_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left Join (select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_oyolife_ib_ob_mgnt_rvw) zz On (xx.id=zz.mgnt_fd_id) Left Join (select fd_id as agent_fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_oyolife_ib_ob_agent_rvw) ww On (xx.id=ww.agent_fd_id) $cond $cond1 order by audit_date";
				$query = $this->RepDB->query($qSql);
				return $query->result_array();
			}else if($lob=='Booking'){
				$qSql="SELECT * from
						(Select *, date(audit_date) as auditDate, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_oyolife_booking_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left Join (select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_oyolife_booking_mgnt_rvw) zz On (xx.id=zz.mgnt_fd_id) Left Join (select fd_id as agent_fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_oyolife_booking_agent_rvw) ww On (xx.id=ww.agent_fd_id) $cond $cond1 order by audit_date";
				$query = $this->RepDB->query($qSql);
				return $query->result_array();
			}else if($lob=='Booking_status_check'){
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_booking_status_check ) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			    $query = $this->RepDB->query($qSql);
				return $query->result_array();
			}else if($lob=='booking_lost_validation'){
				//work this $cond $cond
			 $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_booking_lost_validation ) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			    $query = $this->RepDB->query($qSql);
				return $query->result_array();
			}else{
				$qSql="SELECT * from
						(Select *, date(audit_date) as auditDate, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_oyolife_followup_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left Join (select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_oyolife_followup_mgnt_rvw) zz On (xx.id=zz.mgnt_fd_id) Left Join (select fd_id as agent_fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_oyolife_followup_agent_rvw) ww On (xx.id=ww.agent_fd_id) $cond $cond1 order by audit_date";
				$query = $this->RepDB->query($qSql);
				return $query->result_array();
			}
			
		}else if($pValue=='Social Media RCA'){	
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_oyosig_sme_rca) xx Left Join (Select id as sid, concat(fname, ' ', lname) as agent_name, fusion_id, get_process_names(id) as process, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();

		}else if($pValue=='OYO/WALLET/RECHARGE'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyo_wallet_recharge_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();

		}else if($pValue=='UK/US'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyo_uk_us_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();

		}else if($pValue=='UK/US/NEW'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyo_uk_us_new_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}else if($pValue=='OYOINB'){
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyoinb_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}else if($pValue=='OYOINB Hygiene'){
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyoinb_hygiene_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}else if($pValue=='OYO SIG New'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_new_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}else if($pValue=='oyo_sigchat_service'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_chat_service_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
			
		}else if($pValue=='oyo_sigchat_escalation'){
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyosig_chat_escalation_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		}else if($pValue=='Booking_status_check'){
		
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_booking_status_check ) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";	
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
        }else if($pValue=='booking_lost_validation'){
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_booking_lost_validation ) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";	
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		}else{
		
			$qSql="SELECT * from (Select *, date(audit_date_time) as audit_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,  (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select description from qa_oyosig_rca_category rc where rc.id=issue_category) as sigrca_cat, (select description from qa_oyosig_rca_subcategory rsc where rsc.id=issue_subcategory) as sigrca_subcat from qa_oyosig_rca) xx Left Join (Select id, fusion_id, concat(fname, ' ', lname) as agent_name, office_id, assigned_to from signin) yy On (xx.agent_id=yy.id) $cond $cond1 order by audit_date_time";
			$query = $this->RepDB->query($qSql);
			return $query->result_array();
		
		}
		
	}
	//===========================================Attration Report List==========================//
	public function get_attration_users($filterArr)
    {
		
		if($this->RepDB==null) $this->set_report_database();
		$start_date =$filterArr['start_date'];
		$end_date =$filterArr['end_date'];
		$dept_id =$filterArr['dept_id'];
		$office_id =$filterArr['office_id'];
		$fusion_id =$filterArr['fusion_id'];	
		
		$cond=" Where is_term_complete='Y' ";
		
		if($start_date!="" && $end_date!=""){
			$start_date = mmddyy2mysql($start_date);
			$end_date = mmddyy2mysql($end_date);
			if($fusion_id == '') $cond .=" and date(terms_date)>='".$start_date."' and date(terms_date)<='".$end_date."' ";
		}
		
		$cond2="";
		if($office_id!="" && $office_id!="ALL") $cond2 .=" AND office_id='$office_id'";
		if($dept_id!="" && $dept_id!="ALL"){
			if($cond2=="") $cond2 =" and dept_id='$dept_id' ";
			else $cond2 .=" and dept_id='$dept_id' ";
		}
		
		if($fusion_id!=""){
			$cond3="AND (fusion_id='$fusion_id' OR (xpoid='$fusion_id' or omuid='$fusion_id'))";
		}else{
			$cond3='';
		}
	
		 /*$qSQL="SELECT * from (select *, comments as tcomments ,time_format(timediff(ticket_date,terms_date),'%H:%i:%s') as termDiff, (Select concat(fname, ' ', lname) as name from signin s where s.id=terms_by) as terms_by_name, (Select concat(fname, ' ', lname) as name from signin s where s.id=update_by) as update_by_name from terminate_users  $cond) a, (select *,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, get_process_names(b.id) as process_name,(Select name from role k  where k.id=b.role_id) as role_name from signin b $cond2 ) t where a.user_id=t.id $cond3 order by terms_date desc, a.id desc";

		$qSQL1 ="Select b.*, DATE_FORMAT(resign_date,'%m/%d/%Y') AS resigndate, DATE_FORMAT(released_date,'%m/%d/%Y') AS releaseddate, a.id, a.fusion_id, a.xpoid, a.omuid, a.phase,  (select concat(fname, ' ', lname) as name from signin x where x.id=a.id) as name, (select name from role r where r.id=a.role_id) as role, a.office_id, (Select concat(fname, ' ', lname) as name from signin x where x.id=b.approved_by) as approved_name, (Select concat(fname, ' ', lname) as name from signin x where x.id=b.accepted_by) as accepted_name, (select date(max(login_time)) from logged_in_details ld where ld.user_id =  a.id) as lwd from signin a, user_resign b where a.id=b.user_id  $cond2";*/
		//echo $qSql1;die;
		$qSQL = "SELECT  a.fusion_id,get_user_name(a.id) as agent_name ,si.name as site_name,k.name as role_name,a.office_id,tu.terms_date,tu.ticket_no,tu.lwd,tu.ticket_date,get_user_name(tu.terms_by) as terms_by,get_user_name(tu.update_by) as update_by,tu.update_date,a.phase,tu.comments,get_process_names(a.id) as process_name,b.resign_date,b.released_date,get_user_name(b.approved_by) as approve_name,get_user_name(b.accepted_by) as accepted_name,b.user_remarks,b.resign_status,(select date(max(login_time)) from logged_in_details ld where ld.user_id =  a.id) as resign_lwd
From signin as a

		
		LEFT JOIN terminate_users as tu   ON   a.id=tu.user_id
        LEFT JOIN user_resign   as b   ON   b.user_id=a.id
		LEFT JOIN site   as si  ON   si.id=a.site_id
        LEFT JOIN role   as k   ON   k.id=a.role_id
        
Where ((`tu`.terms_date >= '$start_date' and tu.terms_date <= '$end_date') OR (`b`.resign_date >= '$start_date' and `b`.resign_date <= '$end_date')) $cond2 $cond3 ORDER BY a.id ";
		//echo $qSQL;die;
		
		$query = $this->RepDB->query($qSQL);
		return $query->result_array();
		
    }
    
        public function get_mediclaim_data($year,$office_id){
        $this->db->select("concat(sig.fname,' ',sig.lname)name,sig.fusion_id,sig.status,cl.fullname client_name,pr.name process_name,"
                . "concat(sup.fname,' ',sup.lname)supervisor,of.office_name location,med.log");
        $this->db->where("FIND_IN_SET(med.year,'" . $year . "')!=",0);
        $this->db->where("FIND_IN_SET(sig.office_id,'$office_id')!=",0);
        $this->db->from("mediclaim med");
        $this->db->join("signin sig","sig.id=med.user_id");
        $this->db->join("info_assign_client inc","inc.user_id=med.user_id","left");
        $this->db->join("info_assign_process inp","inp.user_id=med.user_id","left");
        $this->db->join("client cl","cl.id=inc.client_id","left");
        $this->db->join("process pr","pr.id=inp.process_id","left");
        $this->db->join("signin sup","sup.id=sig.assigned_to","left");
        $this->db->join("office_location of","of.abbr=sig.office_id","left");
         return $this->db->get();
//        $this->db->get();
//        echo $this->db->last_query();
//        exit;
    }
}

?>