<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_monitor extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
				
	 }
	 
    public function index()
    {
        
			
		$this->user_model->auto_logout_after_hrs() ;
		
		
		if(check_logged_in())
        {
			
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			$user_site_id=get_user_site_id();
			$current_user = get_user_id();
			
			$filter_id=$this->uri->segment(3);
            
			
			$data["aside_template"] = "";
			$data["content_template"] = "monitor/dashboard.php";
			
			
			//$data["global_notify_count"] = $this->Common_model->get_notify_count();
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			
			$sdValue = trim($this->input->post('sub_dept_id'));
			if($sdValue=="") $sdValue = trim($this->input->get('sub_dept_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$spValue = trim($this->input->post('sub_process_id'));
			if($spValue=="") $spValue = trim($this->input->get('sub_process_id'));
			
			$aValue = trim($this->input->post('assigned_to'));
			if($aValue=="") $aValue = trim($this->input->get('assigned_to'));
			
			$fusionid = trim($this->input->post('fusionid'));
			if($fusionid=="") $fusionid = trim($this->input->get('fusionid'));
			
			if($dValue=="") $dValue=$ses_dept_id;
			if($oValue=="") $oValue=$ses_office_id;
			
			$data['dValue']=$dValue;
			$data['sdValue']=$sdValue;
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['aValue']=$aValue;
			$data['spValue']=$spValue;
			$data['fusionid']=$fusionid;
			
			$_filterCond="";
			
			if($dValue!="ALL" && $dValue!="") $_filterCond .= " And dept_id='".$dValue."'";
			if($sdValue!="ALL" && $sdValue!="") $_filterCond .= " And sub_dept_id='".$sdValue."'";
			
			//if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And is_assign_client (b.id,$cValue)";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " And office_id='".$oValue."'";
			if($sValue!="ALL" && $sValue!="") $_filterCond .= " And site_id='".$sValue."'";
			
			//if($pValue!="ALL" && $pValue!="") $_filterCond .= " And process_id='".$pValue."'";
			if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " And is_assign_process(b.id,$pValue)";
						
			if($aValue!="ALL" && $aValue!="") $_filterCond .= " And assigned_to='".$aValue."'";
			if($spValue!="ALL" && $spValue!="") $_filterCond .= " And sub_process_id='".$spValue."'";
			
			if($fusionid!=""){
				if($_filterCond=="") $_filterCond .= "And fusion_id='".$fusionid."'";
				else $_filterCond .= " And fusion_id='".$fusionid."'";
			}
						
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			$data['disp_list'] = $this->Common_model->get_event_for_assign();
			$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['department_list'] = $this->Common_model->get_department_list();
			
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
						
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			if($pValue!="" && $pValue!="ALL" && $pValue!="0") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
			else $data['sub_process_list']=array();
			
			
			$cond= " where status = 1 and role_id>0 ".$_filterCond;
			$data['total_agent'] = $this->Common_model->get_total("signin b", $cond );
			
			$cond= " where status = 1 and is_logged_in=0 and role_id>0 ".$_filterCond;
			$data['total_offline'] = $this->Common_model->get_total("signin b",$cond);
			
			$cond= " where status = 1 and is_logged_in=1 and role_id>0 ".$_filterCond ;
			$data['total_online'] = $this->Common_model->get_total("signin b",$cond);
			
			$cond= " where status = 1 and is_logged_in=0 and disposition_id in(2,3,4,5) and role_id>0 " . $_filterCond ;
			$data['total_leave'] = $this->Common_model->get_total("signin b",$cond);
			
			
			/////////
			$cDate=CurrDate();
			$currDay=strtolower(date('D', strtotime($cDate)));
			
			
			$qSQL="Select count(user_id) as total from user_shift_schedule, signin where user_id=signin.id and shdate='$cDate' and shday='$currDay' and in_time not like '%OFF%' and in_time not like '%Leave%' $_filterCond ";
			
			$data['total_schedule'] = $this->Common_model->get_total2($qSQL);
						
			$cond= " where status = 1 and (is_break_on=1 OR is_break_on_ld=1) and role_id>0 ".$_filterCond ;
			$data['total_break'] = $this->Common_model->get_total("signin",$cond);
					
			/////////////
			
			$data['filter_id'] = $filter_id;
			
			if($filter_id==1){

				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_monitor_data("SCHEDULE",$mCond);
				
			}else if($filter_id==2){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_monitor_data("ONLINE",$mCond);	
			
			}else if($filter_id==3){
				
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_monitor_data("ONBREAK",$mCond);
				
			}else if($filter_id==4){
				//$mCond=" disposition_id =0";
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_monitor_data("OFFLINE",$mCond);
				
			}else if($filter_id==5){ //on leave
				$mCond=" and disposition_id in(2,3,4,5) ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_monitor_data("OFFLINE",$mCond);
								
			}else{
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_monitor_data("All",$mCond);	
			}
			
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			
            $this->load->view('dashboard_single_col',$data);
        }
		
    }
	
	//////////////////////////////////////////////////////

	
	
}

?>