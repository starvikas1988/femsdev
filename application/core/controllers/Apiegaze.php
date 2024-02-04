<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apiegaze extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
		
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		$this->load->model('email_model');
	 }
	
    public function index()
    {
		$uid = trim($this->input->post('uid'));
		$form_data = $this->input->post();
		
		if($uid==""){
			$uid=trim($this->input->get('uid'));
			$form_data = $this->input->get();
		}
		
		$token = trim($this->input->post('token'));
		if($token=="") $token=trim($this->input->get('token'));
		
		$cip = $this->input->post('cip');
		if($cip=="") $cip=trim($this->input->get('cip'));
		
		$retArray=array();
		
		if($uid!='' && $token!='' && $cip!=''){
			if($this->auth_model->check_token_credentials($uid,$token,$cip)==true){
				
				$qSql="Select id as value from api_access_token Where user_id='$uid' and access_token= '$token' and client_ip='$cip' and is_active = 1";
				$access_id=$this->Common_model->get_single_value($qSql);
				
				if($access_id!=""){
					
					$retArray['resp']="Error";
					$retArray['Details']="Please use proper URL";
					
				}else{
					
					$retArray['resp']="Expire";
					$retArray['details']="Invalid Tcken";
				}
				
			}else{
				
				$retArray['resp']="Expire";
				$retArray['details']="Invalid Tcken";
								
			}
		}else{
			
			$retArray['resp']="Failed";
			$retArray['details']="Invalid Input";
		}
		
	echo json_encode($retArray);
		
				
	}
	
	
	public function putactivities()
    {
      
		
		$uid = trim($this->input->post('uid'));
		$form_data = $this->input->post();
		$logs="EfficiencyXv1.0.1.0";
		
		
		if($uid==""){
			$uid=trim($this->input->get('uid'));
			$form_data = $this->input->get();
		}
		
		//log_record($uid,'putactivities','API',$form_data,$logs);
		
		$token = trim($this->input->post('token'));
		if($token=="") $token=trim($this->input->get('token'));
		
		$cip = $this->input->post('cip');
		if($cip=="") $cip=trim($this->input->get('cip'));
		
		$appname = $this->input->post('appname');
		if($appname=="") $appname=trim($this->input->get('appname'));
		
		$wtitle = $this->input->post('wtitle');
		if($wtitle=="") $wtitle=trim($this->input->get('wtitle'));
		
		$details = $this->input->post('details');
		if($details=="") $details=trim($this->input->get('details'));
		
		$timespent = $this->input->post('timespent');
		if($timespent=="") $timespent=trim($this->input->get('timespent'));
		
		
		$startdt = $this->input->post('startdt');
		if($startdt=="") $startdt=trim($this->input->get('startdt'));
		
		$enddt = $this->input->post('enddt');
		if($enddt=="") $enddt=trim($this->input->get('enddt'));
				
		$retArray=array();
		
		if($uid!='' && $token!='' && $cip!=''){
			
			$start_datetime_local = getEstToLocal($startdt,$uid);
			$end_datetime_local= getEstToLocal($enddt,$uid);
		
			if($this->auth_model->check_token_credentials($uid,$token,$cip)==true){
				
				$qSql="Select id as value from api_access_token Where user_id='$uid' and access_token= '$token' and client_ip='$cip' and is_active = 1";	
				$access_id=$this->Common_model->get_single_value($qSql);
				
				if($access_id!=""){
					try{
						
						$_field_array = array(
							"user_id" => $uid,
							"access_id" => $access_id,
							"app_name" => $appname,
							"window_title" => $wtitle,
							"details" => $details,
							"total_time_spent" => $timespent,
							"start_datetime" => $startdt,
							"start_datetime_local" => $start_datetime_local,
							"end_datetime" => $enddt,
							"end_datetime_local" => $end_datetime_local
						); 
						
						$ret = data_inserter('egaze_activities_details',$_field_array);
						if($ret!==false){		
							$retArray['resp']="Success";
							$retArray['dbid']=$ret;
						}else{
							$retArray['resp']="Error";
							$retArray['details']="Error to save data";
						}
						
						$logs= json_encode($_field_array);
						
						log_record($uid,'putactivities','API',$form_data,$logs);
					}catch (Exception $e) {
						$retArray['resp']="Error";
						$retArray['details']="Invalid Parameters. DB Error to save data. ". $e->getMessage();
						log_record($uid,'putactivities','API',$form_data,"FAIL");
					}						
				}else{
					
					$retArray['resp']="Expire";
					$retArray['details']="Invalid Tcken";
				}
				
				
				
			}else{
				
				$retArray['resp']="Expire";
				$retArray['details']="Invalid Tcken";
								
			}
		}else{
			
			$retArray['resp']="Failed";
			$retArray['details']="Invalid Input";
		}
		
	echo json_encode($retArray);
	
	}
	
	public function putevents()
    {
		$uid = trim($this->input->post('uid'));
		$form_data = $this->input->post();
		
		if($uid==""){
			$uid=trim($this->input->get('uid'));
			$form_data = $this->input->get();
		}
		
		$token = trim($this->input->post('token'));
		if($token=="") $token=trim($this->input->get('token'));
		
		$cip = $this->input->post('cip');
		if($cip=="") $cip=trim($this->input->get('cip'));
		
		$evtname = $this->input->post('evtname');
		if($evtname=="") $evtname=trim($this->input->get('evtname'));
		
		$timespent = $this->input->post('timespent');
		if($timespent=="") $timespent=trim($this->input->get('timespent'));
		
		$startdt = $this->input->post('startdt');
		if($startdt=="") $startdt=trim($this->input->get('startdt'));
		
		$enddt = $this->input->post('enddt');
		if($enddt=="") $enddt=trim($this->input->get('enddt'));
		
		
		
		$retArray=array();
		
		if($uid!='' && $token!='' && $cip!=''){
			
			$start_dt_local = getEstToLocal($startdt,$uid);
			$end_dt_local= getEstToLocal($enddt,$uid);
		
			if($this->auth_model->check_token_credentials($uid,$token,$cip)==true){
				
				$qSql="Select id as value from api_access_token Where user_id='$uid' and access_token= '$token' and client_ip='$cip' and is_active = 1";
				$access_id=$this->Common_model->get_single_value($qSql);
				
				if($access_id!=""){
					try{
						
						$_field_array = array(
							"user_id" => $uid,
							"access_id" => $access_id,
							"event_name" => $evtname,
							"total_time" => $timespent,
							"start_dt" => $startdt,
							"start_dt_local" => $start_dt_local,
							"end_dt" => $enddt,
							"end_dt_local" => $end_dt_local
						); 
						
						$ret = data_inserter('egaze_event_details',$_field_array);
						if($ret!==false){		
							$retArray['resp']="Success";
							$retArray['dbid']=$ret;
						}else{
							$retArray['resp']="Error";
							$retArray['details']="Error to save data";
						}
						
					}catch (Exception $e) {
						$retArray['resp']="Error";
						$retArray['details']="Invalid Parameters. DB Error to save data. " . $e->getMessage();
					}	
					
				}else{
					
					$retArray['resp']="Expire";
					$retArray['details']="Invalid Tcken";
				}
				
				
				
			}else{
				
				$retArray['resp']="Expire";
				$retArray['details']="Invalid Tcken";
								
			}
		}else{
			
			$retArray['resp']="Failed";
			$retArray['details']="Invalid Input";
		}
		
		echo json_encode($retArray);
		
	}
	
	
	public function tigger_notify()
    {
		$uid = trim($this->input->post('uid'));
		$form_data = $this->input->post();
		
		if($uid==""){
			$uid=trim($this->input->get('uid'));
			$form_data = $this->input->get();
		}
		
		$token = trim($this->input->post('token'));
		if($token=="") $token=trim($this->input->get('token'));
		
		$cip = $this->input->post('cip');
		if($cip=="") $cip=trim($this->input->get('cip'));
		
		$frm_dt = $this->input->post('frm_dt');
		if($frm_dt=="") $frm_dt=trim($this->input->get('frm_dt'));
		
		$dur = $this->input->post('dur');
		if($dur=="") $dur=trim($this->input->get('dur'));
				
		$retArray=array();
		
		if($uid!='' && $token!='' && $cip!='' && $frm_dt!="" && $dur!=""){
			
			$frm_dt_local = getEstToLocal($frm_dt,$uid);
					
			if($this->auth_model->check_token_credentials($uid,$token,$cip)==true){
				
				$qSql="Select id as value from api_access_token Where user_id='$uid' and access_token= '$token' and client_ip='$cip' and is_active = 1";
				$access_id=$this->Common_model->get_single_value($qSql);
				
				
				$qSql='SELECT role.name as role_name, department.shname as dept_name, signin.doj,role_organization.name as role_organization, info_personal.email_id_off, info_personal.email_id_per, concat(signin.fname," ",signin.lname) as name, get_client_names(signin.id) as client_name, get_process_names(signin.id) as process_name, info_personal.user_id, signin.fusion_id, signin.assigned_to, b.email_id_off as l1_email_off, b.email_id_per as l1_email_per FROM info_personal
				left join signin on signin.id=info_personal.user_id
				left join info_personal as b on b.user_id=signin.assigned_to
				left join role on role.id=signin.role_id
				left join department on department.id=signin.dept_id
				left join role_organization on role_organization.id=signin.org_role_id
				WHERE info_personal.user_id="'.$uid.'"';
				
				//echo $qSql;
				
				$uRow = $this->Common_model->get_query_row_array($qSql);	
				
				$role_name=$uRow["role_name"];
				$client_name=$uRow["client_name"];
				$dept_name=$uRow["dept_name"];
				$process_name=$uRow["process_name"];
				
				$doj=$uRow["doj"];
				
				$role_organization=$uRow["role_organization"];
				$email_id_off=$uRow["email_id_off"];
				$email_id_per=$uRow["email_id_per"];
				$name=$uRow["name"];
				
				$fusion_id=$uRow["fusion_id"];
				
				$l1_email_off=$uRow["l1_email_off"];
				$l1_email_per=$uRow["l1_email_per"];
				$l1_id=$uRow["assigned_to"];
				
				$qSql="SELECT email_id_off as value FROM info_personal WHERE user_id = (select assigned_to from signin where id='".$l1_id."');";
				$l2_email_off= $this->Common_model->get_single_value($qSql);
		
		
				if($access_id!="" && $name!=""){
					try{
						
						
						$email_subject = "No Activity  ".' - '.$name.' - '.$fusion_id;
						
						$etoarr = array();
						$etoarr[] = $l1_email_off;
						//$etoarr[] = $l2_email_off;
						$eto = array_filter($etoarr);
						
						$ecc = array();
						$ecc[] = $email_id_off;
						$ecc[] = $email_id_per;
						$cc = array_filter($ecc);
											
						$nbody="Dear, </br></br>
						<span>This is to inform you that <b>".$name."</b> (Fusion ID: <b>".$fusion_id."</b>) was Idle from <b>$frm_dt_local</b> for <b>$dur</b> minutes</br>
						Request to you to contact ".$name." and take appropriate action.</span><br><br>";
						
						$nbody .="Details of your team member:<br>";
						$nbody .='<table style="border-collapse: collapse; border:1px solid #000000">
							<thead>
								<tr>
									<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px;" >Employee ID</td>
									<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px;" >Employee Name</td>
									<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px;" >Client</td>
									<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px;" >Process</td>
									<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px;" >Department</td>
									<td style="background-color:#eeeeee; font-weight:bold; border:1px solid #000000; padding:5px;" >Designation</td>
								</tr>
							<thead>
							<tbody>
								<tr>
									<td style="border:1px solid #000000; padding:5px;">'.$fusion_id.'</td>
									<td style="border:1px solid #000000; padding:5px;" > '.$name.'</td>
									<td style="border:1px solid #000000; padding:5px;" >'.$client_name.'</td>
									<td style="border:1px solid #000000; padding:5px;" >'.$process_name.'</td>
									<td style="border:1px solid #000000; padding:5px;" >'.$dept_name.'</td>
									<td style="border:1px solid #000000; padding:5px;" >'.$role_name.'</td>
								</tr>
							</tbody>
						</table><br>';
					
					
					$nbody .= "<b>Regards,</b> </br>
					<b>Fusion - FEMS</b></br>";
								
				$ret =  $this->email_model->send_email_sox($uid, implode(',',$eto) , implode(',',$cc) , $nbody, $email_subject);	
				
						if($ret!==false){		
							$retArray['resp']="Success";
							$retArray['dbid']=$ret;
						}else{
							$retArray['resp']="Error";
							$retArray['details']="Error to save data";
						}
						
					}catch (Exception $e) {
						$retArray['resp']="Error";
						$retArray['details']="Invalid Parameters. DB Error to save data. " . $e->getMessage();
					}	
					
				}else{
					
					$retArray['resp']="Expire";
					$retArray['details']="2. Invalid Tcken";
				}
				
				
				
			}else{
				
				$retArray['resp']="Expire";
				$retArray['details']="1. Invalid Tcken";
								
			}
		}else{
			
			$retArray['resp']="Failed";
			$retArray['details']="Invalid Input";
		}
		
		echo json_encode($retArray);
		
	}
	
	
	
	
}

?>