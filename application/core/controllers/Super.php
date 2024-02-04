<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Super extends CI_Controller {

   
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
        
		$this->Common_model->auto_disposition_update();
		
		$this->user_model->auto_logout_after_hrs() ;
		
		
		if(check_logged_in())
        {
			if(get_login_type() == "client") redirect(base_url().'client',"refresh");
			
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			$user_site_id=get_user_site_id();
			$current_user = get_user_id();
			
			$filter_id=$this->uri->segment(3);
            
			if(get_role_dir()!="super" && get_global_access()!="1") redirect(base_url().get_role_dir()."/dashboard","refresh");
			
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "super/dashboard.php";
			 
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
			
			$sValue = "";
			
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
			
			$qSql="Select id,name from master_term_type where is_active=1";
			$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,name from master_sub_term_type where is_active=1";
			$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from master_resign_reason where is_active=1";
			$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
			
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
			
			
			$cond= " where status in  (1,4) and role_id>0 ".$_filterCond;
			$data['total_agent'] = $this->Common_model->get_total("signin b", $cond );
			
			$cond= " where status in  (1,4) and is_logged_in=0 and role_id>0 ".$_filterCond;
			$data['total_offline'] = $this->Common_model->get_total("signin b",$cond);
			
			$cond= " where status in  (1,4) and is_logged_in=1 and role_id>0 ".$_filterCond ;
			$data['total_online'] = $this->Common_model->get_total("signin b",$cond);
			
			$cond= " where status in  (1,4) and is_logged_in=0 and disposition_id in(2,3,4,5) and role_id>0 " . $_filterCond ;
			$data['total_leave'] = $this->Common_model->get_total("signin b",$cond);
			
			$qSQL="SELECT count(*) as total FROM terminate_users_pre, signin b where user_id=b.id and action_status = 'P' $_filterCond ";
			$data['total_ncns_req'] = $this->Common_model->get_total2($qSQL);
			
			$qSQL="SELECT count(id) as total FROM signin b where status = 2 $_filterCond ";
			$data['total_term_sub'] = $this->Common_model->get_total2($qSQL);
			
			$qSQL="SELECT count(user_id) as total FROM suspended_users, signin b where user_id=b.id and is_complete = 'N' $_filterCond ";
			$data['total_suspended'] = $this->Common_model->get_total2($qSQL);
			
			$data['filter_id'] = $filter_id;
			
			if($filter_id==1){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("All",$mCond);	
			}
			else if($filter_id==2){
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("ONLINE",$mCond);	
			}else if($filter_id==3){
				//$mCond=" disposition_id =0";
				$mCond=" and role_id>0 ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("OFFLINE",$mCond);
			}else if($filter_id==4){
				$mCond=" and disposition_id in(2,3,4,5) ".$_filterCond;
				$data['user_list'] = $this->Common_model->get_user_list("OFFLINE",$mCond);
				
				
			}else if($filter_id==5){
								
				//$qSql="SELECT a.*,fusion_id,office_id,dept_id,fname,lname,role_id,omuid,is_logged_in,status,(Select shname from client m where m.id=b.client_id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from process y where y.id=b.process_id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role k  where k.id=b.role_id) as role_name FROM terminate_users_pre a , signin b where a.user_id=b.id and a.action_status = 'P' $_filterCond ";
				
				$qSql="SELECT a.*,fusion_id,office_id,dept_id,fname,lname,role_id,omuid,is_logged_in,status, get_client_names(b.id) as client_name, get_client_ids(b.id) as client_ids, (Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, get_process_names(b.id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role k  where k.id=b.role_id) as role_name FROM terminate_users_pre a , signin b where a.user_id=b.id and a.action_status = 'P' $_filterCond ";
				
				$data['user_list'] = $this->Common_model->get_query_result_array($qSql);	
			
			}else if($filter_id==6){
								
				//$qSql="select * from (select * from (SELECT id,fusion_id,office_id,dept_id,omuid,fname,lname,role_id,site_id,process_id,status,assigned_to,(Select shname from client m where m.id=b.client_id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from event_master k where k.id=b.disposition_id) as disp_name,(Select name from process y where y.id=b.process_id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name FROM signin b where b.status = 2)xx , (select terms_date,comments,user_id as duid from terminate_users where is_term_complete='N') d  where xx.id=d.duid  $_filterCond ) yy LEFT JOIN ( select max(logout_time) as llogout_time,user_id from logged_in_details group by user_id) c on (yy.id=c.user_id)";
				
				$qSql="select * from (select * from (SELECT id,fusion_id, xpoid, office_id,dept_id,omuid,fname,lname,role_id,site_id,status,assigned_to, get_client_names(b.id) as client_name, get_client_ids(b.id) as client_ids, (Select shname from department s where s.id=b.dept_id) as dept_name, (Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name, (Select name from event_master k where k.id=b.disposition_id) as disp_name, get_process_names(b.id) as process_name,(Select name from sub_process l where l.id=b.sub_process_id) as sub_process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name FROM signin b where b.status = 2 $_filterCond)xx , (select t_type, sub_t_type, lwd, terms_date, comments, user_id as duid, (Select CONCAT(fname,' ' ,lname) from signin ts where ts.id=t.terms_by) as raised_by, (Select name from master_term_type mtt where mtt.id=t.t_type) as t_type_name,
				(Select name from master_sub_term_type mstt where mstt.id=t.sub_t_type) as sub_t_type_name from terminate_users t where is_term_complete='N') d  where xx.id=d.duid  ) yy LEFT JOIN ( select max(logout_time) as llogout_time,user_id from logged_in_details group by user_id) c on (yy.id=c.user_id)";
				
				//echo $qSql;
								
				//,( select max(logout_time) as llogout_time,user_id from logged_in_details group by user_id) c and xx.id=c.user_id
				
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
	
	//////////////////////////////////////////////////////

	
	
}

?>