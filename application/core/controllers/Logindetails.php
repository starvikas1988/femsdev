<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logindetails extends CI_Controller {

    private $aside = "admin/aside.php";

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		
	 }
	 
    public function index()
    {
				
        if(check_logged_in())
        {
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$is_global_access=get_global_access();
			
			//echo $current_user;
			
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			
			if($this->is_access_reports($role_id)){
			
				$data["aside_template"] = get_aside_template();
				$data["content_template"] = "logindetails/main.php";
			    
				$data['user_list'] =array();
				
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				
				$client_id = "";
				$site_id = "";
				$office_id = "";
				$dept_id = "";
				$sdValue="";
				
				$dn_link="";
				if($office_id=="") $office_id=$user_office_id;
				
				if($this->input->get('showReports')=='Show')
				{
					$start_date = $this->input->get('start_date');
					$end_date = $this->input->get('end_date');
					$filter_key = $this->input->get('filter_key');
					
					$client_id = $this->input->get('client_id');
					$site_id = $this->input->get('site_id');
					$office_id = $this->input->get('office_id');
					
					$dept_id = $this->input->get('dept_id');
					if($dept_id=="")  $dept_id=$ses_dept_id;
					
					$sdValue = $this->input->get('sub_dept_id');
					
					//if(get_role_dir()!="super" && $is_global_access!=1){
						if($office_id=="") $office_id=$user_office_id;
					//}
			
					$filterArray = array(
                            "start_date" => $start_date,
							"end_date" => $end_date,
							"client_id" => $client_id,
							"office_id" => $office_id,
							"site_id" => $site_id,
							"filter_key" => $filter_key,
							"user_site_id"=> $user_site_id,
							"dept_id"=> $dept_id,
							"sub_dept_id"=> $sdValue,
                     ); 
					
					//print_r ($filterArray);
					
					if($filter_key!="" && $filter_key!="OfflineList" ){
					
						switch(trim($filter_key)){
							case 'Site':
								$filter_value = $this->input->get('site_id');
								break;
							case 'Agent':
								$filter_value = $this->input->get('agent_id');
								break;
							case 'Process':
								$filter_value = $this->input->get('process_id');
								break;
							case 'Disposition':
								$filter_value = $this->input->get('disp_id');
								break;
							case 'Role':
								$filter_value = $this->input->get('role_id');
								break;
							case 'AOF':
								$filter_value = $this->input->get('assign_id');
								break;	
						}
						
						if($filter_value=="") $filter_value = $this->input->get('filter_value');
					}
					
					$filterArray["filter_value"]=$filter_value;	
					
					//if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
					if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 					
					else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
					else $filterArray["assigned_to"]="";
					
					//print_r($filterArray);
					
					//$fullArr = $this->reports_model->get_user_list_report($filterArray);
					$fullArr = $this->reports_model->get_user_list_report_with_mld($filterArray);
					$data['user_list'] = $fullArr;
					
					$this->create_CSV($fullArr,$filterArray);					
					$dn_link = base_url()."logindetails/downloadCsv";
								
					//////////LOG////////
				
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					
					$LogMSG="View OR Download Main Report with ". $all_params;
					
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
					////////////////////////////////////////////////////////////////
				}
				
				$data['department_list'] = $this->Common_model->get_department_list();	
				$data['client_list'] = $this->Common_model->get_client_list();				
				
				//$data['location_list'] = $this->Common_model->get_office_location_list();
				//$data['site_list'] = $this->Common_model->get_sites_for_assign();
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="super" || $is_global_access==1){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
			
				$data['disp_list'] = $this->Common_model->get_event_for_assign();				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if(get_role_dir()=="super" || $is_global_access==1){		
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
			
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
								
				if($filter_key=="") $othVal="";
				else if($filter_key=="OfflineList") $othVal="OfflineList";
				else $othVal=$filter_key."-".$filter_value;
				
				$dn_param='sd='.$start_date.'&ed='.$end_date.'&oth='.$othVal; 
				$dn_param2=$_SERVER["QUERY_STRING"];
								
				$data['dn_param']=$dn_param;
				$data['dn_param2']=$dn_param2;
				$data['download_link']=$dn_link;
				
				$this->load->view('dashboard',$data);
			}
			
        }
    }
	
 


	public function downloadCsv()
	{		
		$s_date = $this->input->get('sd');
		$e_date = $this->input->get('ed');
		$oth = $this->input->get('oth');
		
		//////////LOG////////
		$Lfull_name=get_username();
		$LOMid=get_user_omuid();
		$LogMSG="Download Main Report";
		log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
		//////////
		
		$filename = "./assets/reports/login_details".get_user_id().".csv";
		$newfile="login_details-".$s_date."to".$e_date. "-" .$oth.".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_CSV($rr,$fArray)
	{
		
		
		$filter_key=$fArray["filter_key"];
		if($filter_key!="" && $filter_key!="OfflineList") $filter_value=$fArray["filter_value"];
		else $filter_value="";
		
		$filename = "./assets/reports/login_details".get_user_id().".csv";
		
		$fopen = fopen($filename,"w+");

				
		$header = array("Date", "Fusion ID", "Site/XPOID", "Avaya Red ID", "Agent Name","Dept","Client Name", "Site", "Process", "Designation", "L1 Supervisor", "Login Time (EST)", "Login Time(Local)", "Logout Time (EST)", "Logout Time (Local)", "Logged In Hours (EST)", "Logged In Hours (Local)","Other Break (EST)", "Other Break (Local)", "Lunch/Dinner Break (EST)" ,"Lunch/Dinner Break (Local)", "Disposition (EST)", "Disposition (Local)", "Comments");
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");

		foreach($rr as $user)
		{	
			$logged_in_hours=$user['logged_in_hours'];
			$logged_in_hours_local = $user['logged_in_hours_local'];
			
			$work_time=$user['logged_in_sec'];
			$work_time_local=$user['logged_in_sec_local'];
			
			$tBrkTime=$user['tBrkTime'];
			$tBrkTimeLocal=$user['tBrkTimeLocal'];
			
			$ldBrkTime=$user['ldBrkTime'];
			$ldBrkTimeLocal=$user['ldBrkTimeLocal'];
			
			$disposition=$user['disposition'];
			
			
			
			$todayLoginTime=$user['todayLoginTime'];
			$is_logged_in = $user['is_logged_in'];
						
			$office_id = $user['office_id'];
											
			$flogin_time = $user['flogin_time'];
			$flogin_time_local = $user['flogin_time_local'];
			
			$logout_time=$user['logout_time'];
			$logout_time_local=$user['logout_time_local'];
			
			$doj=$user['doj'];
			$rdate=$user['rDate'];
			
			$total_break=$tBrkTime+$ldBrkTime;
			$total_break_local=$tBrkTimeLocal+$ldBrkTimeLocal;
			
			$omuid= $user['omuid'];
			if($user['office_id']=="KOL") $omuid = $user['xpoid'];
			
			$leave_dtl = "";
			$leave_status = $user['leave_status'];
			
			if($user['leave_type'] !=""){
				if( $leave_status == '0') $leave_dtl = $user['leave_type'] . " Applied";
				else if( $leave_status == '1') $leave_dtl = $user['leave_type'] . "Approved";
				else if( $leave_status == '2') $leave_dtl = $user['leave_type'] . "Reject";
			}
			
			if($rdate < $doj) continue;
			
			$comments = $user['comments'];
			
			////////// For System Logout /////////////////////
			if($user['logout_by']=='0'){
				//$work_time=0;
				//$work_time_local = 0;
				//$logout_time="";
				$comments = "System Logout";
			}
			
			if($work_time == 0){
				$net_work_time="";
				$total_break = "";
				$tBrkTime = "";
				$ldBrkTime = "";
			}else{
				
				//$net_work_time=gmdate('H:i:s',$work_time);
				//$total_break = gmdate('H:i:s',$total_break);
				//$tBrkTime = gmdate('H:i:s',$tBrkTime);
				//$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
								
				$net_work_time = round(($work_time/3600),2) ;
				$total_break = round(($total_break/3600),2);
				$tBrkTime = round(($tBrkTime/3600),2);
				$ldBrkTime = round(($ldBrkTime/3600),2);
				
			}
			
			if($work_time_local==0){
				$net_work_time_local="";
				$total_break_local="";
				$tBrkTimeLocal = "";
				$ldBrkTimeLocal = "";
			
			}else{
				
				//$net_work_time_local=gmdate('H:i:s',$work_time_local);
				//$total_break_local = gmdate('H:i:s',$total_break_local);
				//$tBrkTimeLocal = gmdate('H:i:s',$tBrkTimeLocal);
				//$ldBrkTimeLocal = gmdate('H:i:s',$ldBrkTimeLocal);
				
				$net_work_time_local = round(($work_time_local/3600),2) ;
				$total_break_local = round(($total_break_local/3600),2);
				$tBrkTimeLocal = round(($tBrkTimeLocal/3600),2);
				$ldBrkTimeLocal = round(($ldBrkTimeLocal/3600),2);
				
			}
			
			if($is_logged_in == '1'){
				$todayLoginArray = explode(" ",$todayLoginTime);
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$flogin_time_local = ConvServerToLocalAny($todayLoginTime,$office_id);
					
					$disposition="online";
					
					$net_work_time="";
					$net_work_time_local="";
					
					$total_break = "";
					$total_break_local="";
					$tBrkTime = "";
					$tBrkTimeLocal = "";
					$ldBrkTime = "";
					$ldBrkTimeLocal = "";
					$logout_time="";
					$logout_time_local="";
				}
			}
			
			
			$disposition_est = "";
			if($logged_in_hours!="0"){
				if($user['user_disp_id']=="8") $disposition_est =  $disposition . " &  P";
				else if($user['user_disp_id']=="7") $disposition_est =  "P & ". $disposition;
				else $disposition_est =  "P";
			}else if($disposition!="") $disposition_est =  $disposition; 
			else if($rdate < $user['doj']) $disposition_est = "";
			else if($leave_dtl!="") $disposition_est = $leave_dtl;		
			else $disposition_est =  "Absent"; 
			
			$disposition_local="";
			
			if($logged_in_hours_local!="0"){
				if($user['user_disp_id']=="8") $disposition_local =  $disposition . " &  P";
				else if($user['user_disp_id']=="7") $disposition_local =  "P & ". $disposition;
				else $disposition_local =  "P";
			}else if($disposition!="") $disposition_local =  $disposition; 
			else if($rdate < $user['doj']) $disposition_local = "";
			else if($leave_dtl!="") $disposition_local = $leave_dtl;
			else $disposition_local =  "Absent"; 
			
			
			$row = '"'.$rdate.'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['omuid'].'",';
			$row .= '"'.$user['red_login_id'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['process_name'].' '.$user['sub_process_name'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
			$row .= '"'.$flogin_time.'",'; 
			$row .= '"'.$flogin_time_local.'",'; 
			$row .= '"'.$logout_time.'",'; 
			$row .= '"'.$logout_time_local.'",'; 
			
			$row .= '"'.$net_work_time.'",';
			$row .= '"'.$net_work_time_local.'",';
			
			$row .= '"'.$tBrkTime.'",';
			$row .= '"'.$tBrkTimeLocal.'",'; 
			
			$row .= '"'.$ldBrkTime.'",'; 
			$row .= '"'.$ldBrkTimeLocal.'",'; 
			
			$row .= '"'.$disposition_est.'",';
			$row .= '"'.$disposition_local.'",';
						
			$row .= '"'. $comments .'"'; 
			
			fwrite($fopen,$row."\r\n");
			
			$row = "";
			
			$is_manual_entry=$user['is_manual_entry'];
			
			if($is_manual_entry=="Y"){
											
				$manual_list=$user['manual_array'];
				foreach($manual_list as $mlist){
					
					$row = '"'.$rdate.'",'; 
					$row .= '"'.$user['fusion_id'].'",'; 
					$row .= '"'.$user['omuid'].'",';
					$row .= '"'.$user['red_login_id'].'",';
					$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
					$row .= '"'.$user['dept_name'].'",'; 
					$row .= '"'.$user['client_name'].'",'; 
					$row .= '"'.$user['site_name'].'",'; 
					$row .= '"'.$user['process_name'].'",'; 
					$row .= '"'.$user['role_name'].'",'; 
					$row .= '"'.$user['asign_tl'].'",'; 
					$row .= '"'.$mlist['mlogin_time'].'",'; 
					$row .= '"'.$mlist['mlogin_time_local'].'",'; 
					$row .= '"'.$mlist['mlogout_time'].'",'; 
					$row .= '"'.$mlist['mlogout_time_local'].'",'; 
					
					$row .= '"'.$mlist['mlogged_in_hours'].'",';
					$row .= '"'.$mlist['mlogged_in_hours'].'",';
					
					$row .= '"0",'; 
					$row .= '"0",';
					$row .= '"0",'; 
					$row .= '"0",'; 
					
					$row .= '"'.$mlist['mdisp_id'].'",';
					$row .= '"'.$mlist['mdisp_id'].'",';
					$row .= '"'.$mlist['madded_by']. ' - ' . $mlist['mcomments']. '"'; 
					
					fwrite($fopen,$row."\r\n");
				}
			}
			
		}
		
		fclose($fopen);
		
	}
	
	private function is_access_reports($_role_id) 
	{
		//$_dept_arr = array("hr"=>0,"admin"=>1,"tl"=>2,"manager"=>4,"trainer"=>5,"support"=>6,"trainee"=>7,"nesting"=>8,"supervisor"=>9);
		
		//if(in_array($_role_id,$_role_arr ))
		//{
			return true;
		//}else{
		//	return false;
		//}
	}
	
	private function redirectors()
	{
		$role = get_role_id();
		if($role==1) return "admin";
		else return "tl";
	}
    
    
    
}

?>