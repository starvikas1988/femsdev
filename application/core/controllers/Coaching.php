<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coaching extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$user_site_id= get_user_site_id();
			$user_role_id= get_role_id();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$is_global_access=get_global_access();
			
			$data["aside_template"] = get_aside_template();
			
			$data["content_template"] = "coaching/manage.php";
			$data["error"] = ''; 
			
			$start_date = trim($this->input->post('start_date'));
			if($start_date=="") $start_date = trim($this->input->get('start_date'));
			
			$end_date = trim($this->input->post('end_date'));
			if($end_date=="") $end_date = trim($this->input->get('end_date'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
									
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$spValue = trim($this->input->post('sub_process_id'));
			if($spValue=="") $spValue = trim($this->input->get('sub_process_id'));
			
			$rValue = trim($this->input->post('role_id'));
			if($rValue=="") $rValue = trim($this->input->get('role_id'));
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['spValue']=$spValue;
			$data['rValue']=$rValue;
			
			$condArray = array(
				"start_date" => $start_date,
				"end_date" => $end_date,
				"client_id" => $cValue,
				"site_id" => $sValue,
				"office_id" => $oValue,
				"process_id" => $pValue,
				"sub_process_id" => $spValue,
				"role_id" => $rValue,
				"user_role_id" => $user_role_id,
				"user_site_id" => $user_site_id
			); 
						
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
			
			//$data['location_list'] = $this->Common_model->get_office_location_list();
			//$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$data['department_list'] = $this->Common_model->get_department_list();
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('showReports')=='Show') $data['all_array'] = $this->Common_model->get_audit_coaching_list($condArray);
			else $data['all_array'] =array(array(),array());
						
			/////////////////////////////////////////////////////////////////////////
									
			if($pValue!="" && $pValue!="ALL") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
			else $data['sub_process_list']=array();
						
			$this->load->view('dashboard',$data);
			
			
		}
    }
	
	
	public function add()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			
            $data["aside_template"] = get_aside_template();
			
            $data["content_template"] = "coaching/add.php";
            $data["error"] = ''; 
            
			$audit_id = trim($this->input->get('aid'));	
			$data['audit_id']=$audit_id;
			
			$qSql="Select agent_id as value from audit_info where audit_id='$audit_id'";
			$agent_id = $this->Common_model->get_single_value($qSql);
			
			$qSql="Select office_id as value from signin where id='$agent_id'";
			$office_id = $this->Common_model->get_single_value($qSql);
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			$qSql="SELECT id,CONCAT(fname,' ' ,lname,' (',(Select name from role where id=b.role_id ),')') as name FROM `signin` b where role_id in (2,5,9) and status=1 and office_id='$office_id' ORDER BY fname";
			
			$data['coach_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['focus_area_list'] = $this->Common_model->get_query_result_array("select * from master_focus_area where is_active=1");
			
			
			
            if($this->input->post('submit')=="Add")
            {
				$_run = false;  
				$log=get_logs();
				$audit_id = trim($this->input->post('audit_id'));
				$qSql="Select agent_id as value from audit_info Where audit_id = '$audit_id'";
				$agent_id = $this->Common_model->get_single_value($qSql);
				$coach_id = trim($this->input->post('coach_id'));
				$coaching_date = trim($this->input->post('coaching_date'));
				$coaching_date=mdydt2mysql($coaching_date);
                $review_type = trim($this->input->post('review_type'));
                $best_part = trim($this->input->post('best_part'));
				
				$reDirectUrl = trim($this->input->post('reDirectUrl'));
				
				
				$focus_area_arr = $this->input->post('focus_area');
				//converting array into a string
				$focus_area = implode(', ',$focus_area_arr);
				
                $time_spent = $this->input->post('time_spent'); 			
				$next_coaching_date = trim($this->input->post('next_coaching_date'));
				$next_coaching_date=mdydt2mysql($next_coaching_date);
				$next_coaching_poa = trim($this->input->post('next_coaching_poa')); 				
				$comment = trim($this->input->post('comment'));
				
				
                if($audit_id!="" && $agent_id!="" && $coach_id!="" && $coaching_date!="")
                {
						$insert_date = CurrMySqlDate();
						
						$_field_array = array(
                            "audit_id" => $audit_id,
							"agent_id" => $agent_id,
							"coach_id" => $coach_id,
							"coaching_date" => $coaching_date,
                            "review_type" => $review_type,
                            "best_part" => $best_part,
							"focus_area" => $focus_area,
							"time_spent" => $time_spent,
							"next_coaching_date" => $next_coaching_date,
							"next_coaching_poa" => $next_coaching_poa,
							"next_coaching_poa" => $next_coaching_poa,
							"comment" => $comment,
							"added_by" => $current_user,							
							"insert_date" => $insert_date,
							"log" => $log
                        ); 
												
							$coaching_id = data_inserter('coaching',$_field_array);
                      	
							//////////LOG////////
							if($coaching_id){
								$Lfull_name=get_username();
								$LOMid=get_user_omuid();
								
								$LogMSG="Added Coaching audit rec : $audit_id ";
								log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							}
														
						    //redirect(base_url()."coaching");
							
							redirect($reDirectUrl);
							
							
						   
                        }else $data['error'] = show_msgbox('Error to save Coaching',true);
						
                    }
					
					$data["reDirectUrl"]=$_SERVER['HTTP_REFERER'];
											
               }
			   
			   //$this->load->view('dashboard_ajax',$data);
			   $this->load->view('dashboard',$data);
								
   }                  

  
  
  
/*   
public function add_success()
{
	if(check_logged_in())
    {
		
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$data["aside_template"] = get_aside_template();
						   
        $data["error"] = '';
		$user_id = $this->input->get('uid');
		$user_id=addslashes(trim($user_id));
		
		//$fusion_id = $this->input->get('fid');
		
		$qSql="SELECT id,fusion_id,omuid,fname,lname,office_id,role_id,(Select office_name from office_location b where b.abbr=a.office_id) as office_name, (Select name from role c where c.id=a.role_id) as role_name  from signin a WHERE id=\"$user_id\"";
		echo $qSql;
		
		$user_info=$this->Common_model->get_query_result_array($qSql);
							
		if(!empty($user_info)){
			
			$data["user_id"] =$user_id;
			$data["user_name"] =$user_info[0]['fname']." ".$user_info[0]['lname'];
			
			$data["fusion_id"] =$user_info[0]['fusion_id'];
			$data["office_id"] =$user_info[0]['office_id'];
			$data["office_name"] =$user_info[0]['office_name'];
			$data["role_name"] =$user_info[0]['role_name'];
			$data["omuid"] =$user_info[0]['omuid'];
						
		}else{
			 redirect(base_url()."users/manage");
		}
						
		$data["content_template"] = "user/adduser_success.php";
		$this->load->view('dashboard',$data);
		
		
	}
}
*/


public function getAssignList()
{
	if(check_logged_in())
    {
		$oid = trim($this->input->post('oid'));
		
		//echo $this->Common_model->get_process_list($cid);
		echo json_encode($this->Common_model->get_assign_list($oid));
	}
}

public function getProcessList()
{
	if(check_logged_in())
    {
		$cid = trim($this->input->post('cid'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->Common_model->get_process_list($cid));
	}
}

public function getSubProcessList()
{
	if(check_logged_in())
    {
		$pid = trim($this->input->post('pid'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->Common_model->get_sub_process_list($pid));
	}
}



public function update_coaching()
{
	if(check_logged_in())
    {
	
		$srole_id= get_role_id();
		$uid = trim($this->input->post('uid'));
		
		$fusion_id = trim($this->input->post('fusion_id'));
		$office_id = trim($this->input->post('office_id'));
		$dept_id = trim($this->input->post('dept_id'));
		
		$_field_array = array(
			"fusion_id" => $fusion_id,
			"office_id" => $office_id,
			"dept_id" => $dept_id,
			"fname" => $fname,
			"lname" => $lname,
			"role_id" => $role_id,
		); 
		
		if($omuid!=""){
			 $_field_array['omuid']=$omuid;
		}
				
		if($uid!=""){
			
			$this->db->where('id', $uid);
			$this->db->update('signin',$_field_array );
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
		
			$LogMSG="Update User Info of $fname $lname ($fusion_id) ";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}



public function reporttl()
{
	if(check_logged_in())
    {
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$user_office_id=get_user_office_id();
		$ses_dept_id=get_dept_id();
		$is_global_access=get_global_access();
		$current_user = get_user_id();
		
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "coaching/rep_tl.php";
			
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
					
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
						
			$aValue = trim($this->input->post('assigned_to'));
			if($aValue=="") $aValue = trim($this->input->get('assigned_to'));
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
				
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['aValue']=$aValue;
			
			
			$_filterCond="";
			
			if($start_date!="") $start_date = mmddyy2mysql($start_date);
			if($end_date!="") $end_date = mmddyy2mysql($end_date);
				
			if($start_date!="ALL" && $start_date!="") $_filterCond= " And coaching_date>='".$start_date."' ";
			if($end_date!="ALL" && $end_date!="") $_filterCond= " And coaching_date<='".$end_date."' ";
			
			if($cValue!="ALL" && $cValue!="") $_filterCond= " And is_assign_client (b.id,$cValue) ";
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " And office_id='".$oValue."'";
			if($sValue!="ALL" && $sValue!="") $_filterCond .= " And site_id='".$sValue."'";
			if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " And is_assign_process(b.id,$pValue)";
			if($aValue!="ALL" && $aValue!="") $_filterCond .= " And coach_id='".$aValue."'";
						
			$data['disp_list'] = $this->Common_model->get_event_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){		
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}else{
				$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}
			
			//$data['site_list'] = $this->Common_model->get_sites_for_assign();
			//$data['location_list'] = $this->Common_model->get_office_location_list();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array(); //$this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
														
				//$qSql="SELECT a.*,fusion_id,office_id,fname,lname,omuid,status,(Select shname from client m where m.id=b.client_id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from process y where y.id=b.process_id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.coach_id) as coach_name FROM coaching a , signin b  where a.agent_id=b.id $_filterCond order by coach_id, client_id ,coaching_date";
				
				$qSql="SELECT a.*,fusion_id,office_id,fname,lname,omuid,status, get_client_names(b.id) as client_name, (Select shname from department s where s.id=b.dept_id) as dept_name, get_process_names(b.id) as process_name ,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.coach_id) as coach_name FROM coaching a , signin b  where a.agent_id=b.id $_filterCond order by coach_id, client_id ,coaching_date";
				
				//echo $qSql ."\n\r";
				
				if($this->input->get('showReports')=='Show') $data['user_list'] = $this->Common_model->get_query_result_array($qSql);
				else $data['user_list'] =array();
			
						
				$qStrParam=$_SERVER["QUERY_STRING"];
				$data['qStrParam']=$qStrParam;
				$data['download_link']="";
				
			    $this->load->view('dashboard',$data);
				
	}
}



public function reportagent()
{
	if(check_logged_in())
    {
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$user_office_id=get_user_office_id();
		$ses_dept_id=get_dept_id();
		$is_global_access=get_global_access();
		$current_user = get_user_id();
		
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "coaching/rep_agent.php";
			
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			
			$fagent_id = trim($this->input->post('fagent_id'));
			if($fagent_id=="") $fagent_id = trim($this->input->get('fagent_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
						
			$aValue = trim($this->input->post('assigned_to'));
			if($aValue=="") $aValue = trim($this->input->get('assigned_to'));
			
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			$data['fagent_id']=$fagent_id;
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['aValue']=$aValue;
						
			$_filterCond="";
			
			if($start_date!="") $start_date = mmddyy2mysql($start_date);
			if($end_date!="") $end_date = mmddyy2mysql($end_date);
				
			if($start_date!="ALL" && $start_date!="") $_filterCond= " And coaching_date>='".$start_date."' ";
			if($end_date!="ALL" && $end_date!="") $_filterCond= " And coaching_date<='".$end_date."' ";
			
			if($fagent_id!="ALL" && $fagent_id!="") $_filterCond= " And fusion_id='".$fagent_id."' ";
			
			if($cValue!="ALL" && $cValue!="") $_filterCond= " And is_assign_client (b.id,$cValue) ";
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " And office_id='".$oValue."'";
			if($sValue!="ALL" && $sValue!="") $_filterCond .= " And site_id='".$sValue."'";
			if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " And is_assign_process(b.id,$pValue)";
			if($aValue!="ALL" && $aValue!="") $_filterCond .= " And assigned_to='".$aValue."'";
						
			$data['disp_list'] = $this->Common_model->get_event_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){	
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}else{
				$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}
			
			//$data['site_list'] = $this->Common_model->get_sites_for_assign();
			//$data['location_list'] = $this->Common_model->get_office_location_list();
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] =  array();//$this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
														
				//$qSql="SELECT a.*,fusion_id,office_id,fname,lname,omuid,status,(Select shname from client m where m.id=b.client_id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from process y where y.id=b.process_id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.coach_id) as coach_name FROM coaching a , signin b  where a.agent_id=b.id $_filterCond order by agent_id, client_id ,coaching_date,coach_id";
				
				$qSql="SELECT a.*,fusion_id,office_id,fname,lname,omuid,status, get_client_names(b.id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name, get_process_names(b.id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.coach_id) as coach_name FROM coaching a , signin b  where a.agent_id=b.id $_filterCond order by agent_id, client_id ,coaching_date,coach_id";
				
				
				//echo $qSql ."\n\r";
				
				if($this->input->get('showReports')=='Show') $data['user_list'] = $this->Common_model->get_query_result_array($qSql);
				else $data['user_list'] =array();
				
						
				$qStrParam=$_SERVER["QUERY_STRING"];
				$data['qStrParam']=$qStrParam;
				$data['download_link']="";
				
			    $this->load->view('dashboard',$data);
				
	}
}



public function rawdata()
{
	if(check_logged_in())
    {
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$user_office_id=get_user_office_id();
		$ses_dept_id=get_dept_id();
		$current_user = get_user_id();
		
		$is_global_access=get_global_access();
		
		
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "coaching/rawdata.php";
			
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			
			$fagent_id = trim($this->input->post('fagent_id'));
			if($fagent_id=="") $fagent_id = trim($this->input->get('fagent_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
						
			$aValue = trim($this->input->post('assigned_to'));
			if($aValue=="") $aValue = trim($this->input->get('assigned_to'));
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			$data['fagent_id']=$fagent_id;
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['aValue']=$aValue;
						
			$_filterCond="";
			
			if($start_date!="") $start_date = mmddyy2mysql($start_date);
			if($end_date!="") $end_date = mmddyy2mysql($end_date);
				
			if($start_date!="ALL" && $start_date!="") $_filterCond= " And coaching_date>='".$start_date."' ";
			if($end_date!="ALL" && $end_date!="") $_filterCond= " And coaching_date<='".$end_date."' ";
			
			if($fagent_id!="ALL" && $fagent_id!="") $_filterCond= " And fusion_id='".$fagent_id."' ";
			
			if($cValue!="ALL" && $cValue!="") $_filterCond= " And is_assign_client (b.id,$cValue) ";
			if($oValue!="ALL" && $oValue!="") $_filterCond .= " And office_id='".$oValue."'";
			if($sValue!="ALL" && $sValue!="") $_filterCond .= " And site_id='".$sValue."'";
			if($pValue!="ALL" && $pValue!="") $_filterCond .= " And is_assign_process(b.id,$pValue)";
			if($aValue!="ALL" && $aValue!="") $_filterCond .= " And assigned_to='".$aValue."'";
						
			$data['disp_list'] = $this->Common_model->get_event_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){		
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}else{
				$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}
			
			//$data['site_list'] = $this->Common_model->get_sites_for_assign();
			//$data['location_list'] = $this->Common_model->get_office_location_list();
			
			if($is_global_access==1){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($user_office_id);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] =  array();//$this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
																	
				//$qSql="SELECT a.*,fusion_id,office_id,fname,lname,omuid,status,(Select shname from client m where m.id=b.client_id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from process y where y.id=b.process_id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.coach_id) as coach_name FROM coaching a , signin b  where a.agent_id=b.id $_filterCond order by agent_id, client_id ,coaching_date,coach_id";
				
				$qSql="SELECT a.*,fusion_id,office_id,fname,lname,omuid,status, get_client_names(b.id) as client_name,(Select shname from department s where s.id=b.dept_id) as dept_name, get_process_names(b.id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.coach_id) as coach_name FROM coaching a , signin b  where a.agent_id=b.id $_filterCond order by agent_id, client_id ,coaching_date,coach_id";
								
				//echo $qSql ."\n\r";
				
				
			if($this->input->get('showReports')=='Export As CSV' && $start_date!="" && $end_date!="" ){
				
					$coach_list = $this->Common_model->get_query_result_array($qSql);
													
					if(!empty($coach_list)){
						$data['coach_list']=$coach_list;
						$this->create_CSV($coach_list,$data);
					}else{
						$data['coach_list']=array();
						$this->load->view('dashboard',$data);
					}
				
			}else $this->load->view('dashboard',$data);
			
	}
}

public function create_CSV($rr,$data)
{
			
		$start_date=$data["start_date"];
		$end_date=$data["end_date"];
		$st_date = mmddyy2mysql($start_date);
		$en_date = mmddyy2mysql($end_date);
				
		$filename = "./assets/reports/coaching-".$st_date." - ".$en_date.".csv";
		
		$fopen = fopen($filename,"w+");
										
		$header = array("SL","Agent","Fusion ID", "TL/Trainer", "Client", "Site", "Process", "Coach Name", "Coaching Date", "Time Spent","Review Type","Best Part", "Focus Area", "Next Coaching Date" , "Next Coaching POA", "Comments");
		
		$row = "";
		$cnt=1;
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");

		foreach($rr as $user)
		{	
			$row = '"'.$cnt++.'",';
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['site_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['coach_name'].'",'; 
			$row .= '"'.$user['coaching_date'].'",'; 
			$row .= '"'.$user['time_spent'].'",'; 
			$row .= '"'.$user['review_type'].'",'; 
			$row .= '"'.$user['best_part'].'",'; 
			$row .= '"'.$user['focus_area'].'",'; 
			$row .= '"'.$user['next_coaching_date'].'",'; 
			$row .= '"'.$user['next_coaching_poa'].'",'; 
			$row .= '"'.$user['comment'].'"'; 
 
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
		$newfile = "coaching-".$st_date." - ".$en_date.".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
}
	

}

?>