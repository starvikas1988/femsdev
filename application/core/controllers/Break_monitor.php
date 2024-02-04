<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Break_monitor extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE //
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	private $aside = "break_monitor/aside.php";
	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
	 
	public function index()
	{
		if(check_logged_in())
		{
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			$ses_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$user_site_id = get_user_site_id();
			
			$user_oth_office=get_user_oth_office();
			
			$filter_id=$this->uri->segment(2);
			
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "break_monitor/break_monitor.php";
			$data["error"] = ''; 
			
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$dValue = $this->input->get('dept_id');
			if($dValue=="")  $dValue=$ses_dept_id;
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			if($oValue=="") $oValue=$ses_office_id;
			
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['pValue']=$pValue;
			$data['dValue']=$dValue;
			
			$_filterCond="";
			
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And is_assign_client (s.id,$cValue)";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " And office_id='".$oValue."'";
			if($dValue!="ALL" && $dValue!="") $_filterCond .= " And dept_id='".$dValue."'";
			
			if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " And is_assign_process(s.id,$pValue)";
			
			
			if($is_global_access!=1 && get_role_dir()!="super"){
			
				$_filterCond .= " And role_id in (SELECT id FROM `role` where folder !='super') ";
				
				if ( get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" ){
					
					$_filterCond .=" And (office_id='$ses_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
					
				}else{
					
					if(get_role_dir()=="tl" || get_role_dir()=="trainer") $_filterCond .= " And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user'))";	
					
					if(get_role_dir()=="manager" || get_role_dir()=="admin")  $_filterCond .=" And (office_id='$ses_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
					
					if(get_role_dir()=="manager") $_filterCond .= " and dept_id='$ses_dept_id' ";
				
				}
				
			}			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['department_list'] = $this->Common_model->get_department_list();	
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			
			$cond= " where status = 1 and is_logged_in=1 and (is_break_on_ld=1 or is_break_on=1) and role_id>0 ".$_filterCond;
			$data['total_onbreak'] = $this->Common_model->get_total("signin s", $cond );
			
			$cond= " where status = 1 and role_id>0 ".$_filterCond;
			$data['total_agent'] = $this->Common_model->get_total("signin s", $cond );
			
			$cond= " where status = 1 and is_logged_in=0 and role_id>0 ".$_filterCond;
			$data['total_offline'] = $this->Common_model->get_total("signin s",$cond);
			
			$cond= " where status = 1 and is_logged_in=1 and role_id>0 ".$_filterCond;
			$data['total_online'] = $this->Common_model->get_total("signin s",$cond);
			
			$data['filter_id'] = $filter_id;
			
			if($filter_id==1){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_break_details("ONBREAK",$mCond, $oValue);	
			}else if($filter_id==2){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_break_details("ONLINE",$mCond, $oValue);
			}else if($filter_id==3){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_break_details("OFFLINE",$mCond, $oValue);
			}else if($filter_id==4){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_break_details("",$mCond, $oValue);
			}else{
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_break_details("ONBREAK",$mCond, $oValue);	
			}
			
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;

			
			$this->load->view('dashboard',$data);
		}
		
	}
	
	
	
	public function othBrkDetails(){
		if(check_logged_in()){
			$oth_uid = $this->input->post('oth_uid');
			$curr_date=date('Y-m-d');
			
			$qSql="Select *, TIME_TO_SEC(TIMEDIFF(in_time, out_time)) as oth_diff, DATE_FORMAT(out_time, '%H:%i:%s') as outtime, DATE_FORMAT(in_time, '%H:%i:%s') as intime from break_details where user_id='". $oth_uid ."' and date(out_time)='$curr_date'";
			//echo $qSql;
			$oth_brk_details = $this->Common_model->get_query_result_array($qSql);

			
			echo "<table id='default-datatable' data-plugin='DataTable' class='table table-striped skt-table' cellspacing='0' width='100%'>";
				echo "<thead><tr class='bg-info'><th>SL</th><th>Out Time</th><th>In Time</th><th>Duration</th></tr></thead>";
				
				echo "<tbody>";
			 	
				$i=1;
				foreach($oth_brk_details as $row){
					
					$oth_diff=$row['oth_diff'];
					$tot_oth_diff=gmdate("H:i:s", $oth_diff);
						 
					echo "<tr>";
						echo "<td>".$i++."</td>";
						echo "<td>".$row['outtime']."</td>";
						echo "<td>".$row['intime']."</td>";
						echo "<td>".$tot_oth_diff."</td>";
					echo "</tr>";
							
				}
							 
				echo "</tbody>";
			echo "</table>";
	
		}
	}
	
	
	public function ldBrkDetails(){
		if(check_logged_in()){
			$ld_uid = $this->input->post('ld_uid');
			$curr_date=date('Y-m-d');
			
			$qSql="Select *, TIME_TO_SEC(TIMEDIFF(in_time, out_time)) as ld_diff, DATE_FORMAT(out_time, '%H:%i:%s') as outtime, DATE_FORMAT(in_time, '%H:%i:%s') as intime from break_details_ld where user_id='". $ld_uid ."' and date(out_time)='$curr_date'";
			//echo $qSql;
			$ld_brk_details = $this->Common_model->get_query_result_array($qSql);
			
			
			echo "<table id='default-datatable' data-plugin='DataTable' class='table table-striped skt-table' cellspacing='0' width='100%'>";
				echo "<thead><tr class='bg-info'><th>SL</th><th>Out Time</th><th>In Time</th><th>Duration</th></tr></thead>";
				
				echo "<tbody>";
			 	
				$i=1;
				foreach($ld_brk_details as $row){
					
					$ld_diff=$row['ld_diff'];
					$tot_ld_diff=gmdate("H:i:s", $ld_diff);
					
					echo "<tr>";
						echo "<td>".$i++."</td>";
						echo "<td>".$row['outtime']."</td>";
						echo "<td>".$row['intime']."</td>";
						echo "<td>".$tot_ld_diff."</td>";
					echo "</tr>";
							
				}
							 
				echo "</tbody>";
			echo "</table>";
	
		}
	}
	
	 
	 
}
?>	 