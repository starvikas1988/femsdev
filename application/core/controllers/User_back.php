<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
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
		
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			
			$data["aside_template"] = get_aside_template();
			
			$data["content_template"] = "user/manage_users.php";
			$data["error"] = ''; 
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			
			$sdValue = trim($this->input->post('sub_dept_id'));
			if($sdValue=="") $sdValue = trim($this->input->get('sub_dept_id'));
			
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
			
			$status = trim($this->input->post('status'));
			if($status=="") $status = trim($this->input->get('status'));
			if($status=="") $status=1;
			
			
			
			if($dValue=="") $dValue=$ses_dept_id;

			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if($status==1) $_filterCond=" status in (1,2) ";
			else $_filterCond=" status=".$status;
			
			if(get_role_dir()!="super" && get_role_dir()!="admin"){
				if($_filterCond=="") $_filterCond .=" role_id>1 ";
				else $_filterCond .=" and role_id>1 ";
			}
			
			if($dValue!="ALL" && $dValue!=""){
				if($_filterCond=="") $_filterCond .= " dept_id='".$dValue."'";
				else $_filterCond .= " and dept_id='".$dValue."'";
			}
			
			//if(get_role_dir()!="admin" && get_role_dir()!="super" && get_role_dir()!="support" && get_role_dir()!="head" && get_dept_folder()=="hr" && get_dept_folder()=="rta" && get_dept_folder()=="wfm") $_filterCond .=" And (site_id='$user_site_id' OR office_id='$user_office_id') ";
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" And (site_id='$user_site_id' OR office_id='$user_office_id') ";
						
						
			if($sdValue!="ALL" && $sdValue!=""){
				if($_filterCond=="") $_filterCond .= " sub_dept_id='".$sdValue."'";
				else $_filterCond .= " and sub_dept_id='".$sdValue."'";
			}
			
			if($cValue!="ALL" && $cValue!=""){
				if($_filterCond=="") $_filterCond .= " client_id='".$cValue."'";
				else $_filterCond .= " and client_id='".$cValue."'";
			}
			
			if($sValue!="ALL" && $sValue!=""){
				if($_filterCond=="") $_filterCond .= " site_id='".$sValue."'";
				else $_filterCond .= " And site_id='".$sValue."'";
			}
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " office_id='".$oValue."'";
				else $_filterCond .= " And office_id='".$oValue."'";
			}
			
			if($pValue!="ALL" && $pValue!=""){
				if($_filterCond=="") $_filterCond .= " process_id='".$pValue."'";
				else $_filterCond .= " And process_id='".$pValue."'";
			}
			
			if($spValue!="ALL" && $spValue!=""){
				if($_filterCond=="") $_filterCond .= " sub_process_id='".$spValue."'";
				else $_filterCond .= " And sub_process_id='".$spValue."'";
			}
			
			if($rValue!="ALL" && $rValue!=""){
				if($_filterCond=="") $_filterCond .= " role_id='".$rValue."'";
				else $_filterCond .= " And role_id='".$rValue."'";
			}
			
			
			
			//if($role_id>'1' && $role_id<'6'){
			//if(get_role_dir()!="super" && get_role_dir()!="admin"){
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($_filterCond=="") $_filterCond .= " (site_id='$user_site_id' OR office_id='$user_office_id') ";
				else $_filterCond .= " And (site_id='$user_site_id' OR office_id='$user_office_id') ";
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1 || get_role_dir()=="admin"){
				
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super') ORDER BY name";	
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			}else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
			
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
			}else{
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			}
			
			//if($role_id>'1' && $role_id<'6'){
			//if(get_role_dir()!="super" && get_role_dir()!="admin"){
			if(get_role_dir()!="super" && $is_global_access!=1){
				
				//$tl_cnd=" and site_id=".$user_site_id;
				$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				
			}else $data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
						
						
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			
			/*
			if($is_global_access==1 || get_role_dir()=="super" ||  get_role_dir()=="admin"){
				
				$data['department_list'] = $this->Common_model->get_department_list();
				if($dValue=="ALL" || $dValue=="") $data['sub_department_list'] = array();
				else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
				
			}else{
				
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			}
			*/
		
			$data['client_list'] = $this->Common_model->get_client_list();
			
			$data['user_list'] = $this->Common_model->get_manage_ulist($_filterCond);
						
			if($pValue!="" && $pValue!="ALL") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
			else $data['sub_process_list']=array();
			
			
			$data['dValue']=$dValue;
			$data['sdValue']=$sdValue;
			
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['spValue']=$spValue;
			$data['rValue']=$rValue;
			$data['status']=$status;
			
			
			$this->load->view('dashboard',$data);
			
			
		}
    }
	
	
	public function add_users()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
								
			$is_global_access=get_global_access();
			
			
            $data["aside_template"] = get_aside_template();
			
            $data["content_template"] = "user/add_users.php";
            $data["error"] = ''; 
            
			//$data['role_list'] = $this->Common_model->get_rolls_for_assignment_all();
			//if($srole_id<='1'){
			
			if(get_role_dir()=="super" || get_role_dir()=="admin" || $is_global_access==1){
				
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super') ORDER BY name";	
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
			}else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
				//$cond=" and id not in(0,1,4,11)";
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
			}else{
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
						
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			/*
			if($srole_id>'1' && $srole_id<'6'){
				$tl_cnd=" and site_id=".$user_site_id;
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				
			}else $data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			*/
			//$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			
			/*
			if($is_global_access==1 || get_role_dir()=="super" ||  get_role_dir()=="admin"){
				
				$data['department_list'] = $this->Common_model->get_department_list();
				$data['sub_department_list'] = array();
				
			}else{
				
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			}
			*/
			
			
            if($this->input->post('submit')=="Add")
            {
                  
				$_run = false;  
				
				$log=get_logs();
				
				$office_id = trim($this->input->post('office_id'));
				
				$dept_id = trim($this->input->post('dept_id'));
				$sub_dept_id = trim($this->input->post('sub_dept_id'));
				
				$xpoid = trim($this->input->post('xpoid'));
                $_omuid = trim($this->input->post('omuid'));
				$red_login_id = trim($this->input->post('red_login_id'));
				
                $_passwd = trim($this->input->post('passwd'));
				
                $_fname = $this->input->post('fname');
                $_lname = $this->input->post('lname'); 
				
				$client_id = trim($this->input->post('client_id'));
				
				$_role_id = trim($this->input->post('role_id')); 
				$_site_id = trim($this->input->post('site_id'));
				$_process_id = trim($this->input->post('process_id'));
				
				$sub_process_id = trim($this->input->post('sub_process_id'));
								
				$_assigned_to = trim($this->input->post('assigned_to'));
				
				$email_id = trim($this->input->post('email_id'));
				$phno = trim($this->input->post('phno')); 
				$doj = trim($this->input->post('doj')); 
				
				$batch_code=trim($this->input->post('batch_code'));
				
				$_status= 1;
				$_disp_id= 1;
                
                				
                if($_role_id!="" && $_fname!="" && $_lname!=""  && $_passwd!="" && $office_id!="" && $dept_id!="" )
                {
                    if($this->user_model->user_omid_exists($_omuid)===false) $_run = true;  
                    else{
						
						$_run = false;  
						$data["error"] = show_msgbox('User Creation Failed. OM ID already present',true);
						
					}
					
					if($this->user_model->user_xpoid_exists($xpoid)===false) $_run = true;  
                    else{
						$_run = false;
						$data["error"] = show_msgbox('User Creation Failed. XPO ID already present',true);
					}
					
                } 
                    
                    if($_run===true)
                    {
                        $_field_array = array(
                            "office_id" => $office_id,
							"dept_id" => $dept_id,
							"sub_dept_id" => $sub_dept_id,
							"passwd" => $_passwd,
                            "fname" => $_fname,
                            "lname" => $_lname,
							"role_id" => $_role_id,
							"disposition_id" => $_disp_id,
							"status" => $_status,
							"log" => $log,
							
                        ); 
						
						if($xpoid!=""){
							 $_field_array['xpoid']=$xpoid;
						}
						
						if($_omuid!=""){
							 $_field_array['omuid']=$_omuid;
						}
						
						if($red_login_id!=""){
							 $_field_array['red_login_id']=$red_login_id;
						}
						
						if($phno!=""){
							 $_field_array['phno']=$phno;
						}
						
						if($doj!=""){
							 $doj=mmddyy2mysql($doj);
							 $_field_array['doj']=$doj;
						}
						
						if($email_id!=""){
							 $_field_array['email_id']=$email_id;
						}
						
						if($client_id!=""){
							 $_field_array['client_id']=$client_id;
						}
						
						if($_site_id!=""){
							 $_field_array['site_id']=$_site_id;
						}
						if($_process_id!=""){
							 $_field_array['process_id']=$_process_id;
						}
						
						if($sub_process_id!=""){
							 $_field_array['sub_process_id']=$sub_process_id;
						}
						
						if($_assigned_to!=""){
							 $_field_array['assigned_to']=$_assigned_to;
						}
						
						if($batch_code!="") $_field_array['batch_code']=$batch_code;
						
						$this->db->trans_start();
						////////////////////////////
						
                        $_user_id = data_inserter('signin',$_field_array);
                        
						////
						$evt_date = CurrMySqlDate();

						$role_his_array = array(
							"user_id" => $_user_id,
							"role_id" => $_role_id,
							"stdate" => $doj,
							"change_date" => $evt_date,
							"change_by" => $current_user,
                            "log" => $log,
                        ); 
						
						$rowid= data_inserter('role_history',$role_his_array);
												
						$fusion_id="";					
						
						if($_user_id!==FALSE)
                        {
							//$fusion_id="F".$office_id."".addLeadingZero($_user_id,6);
							
							$max_id=$this->Common_model->get_single_value("SELECT max(substr(fusion_id,5)) as value FROM signin where office_id='$office_id'");
							$max_id=$max_id+1;							
							$fusion_id="F".$office_id."".addLeadingZero($max_id,6);
							
							$Update_array = array(
									"fusion_id" => $fusion_id
							);
							
							$this->db->where('id', $_user_id);
							$this->db->update('signin', $Update_array);					   
                        }
						
						
						$this->db->trans_complete();						
						////////////////////////////
						
						
						if($fusion_id=="" || $_user_id===FALSE || $this->db->trans_status() === FALSE){
							$data['error'] = show_msgbox('User Creation Failed. Try Again',true);								
						}else{
								//////////LOG////////
							
								$Lfull_name=get_username();
								$LOMid=get_user_omuid();
								
								$LogMSG="Added User $_fname $_lname ($_omuid), Fusion id: $fusion_id";
								log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
											
								//////////
				
								$this->session->set_flashdata("error",show_msgbox("User Added Successfully",false));
							   
								//redirect(base_url().get_role_dir()."/manage_users");
								redirect(base_url()."users/addsuccess?uid=$_user_id");
								//redirect(base_url()."admin/dashboard#users/manage");
																			   
						}
							                        
                    }
					
               }
			   
			   //$this->load->view('dashboard_ajax',$data);
			   $this->load->view('dashboard',$data);
								
            }                  
   }
  
  
  
   
public function add_user_success()
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
		//echo $qSql;
		
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


public function getSubDepartmentList()
{
	if(check_logged_in())
    {
		$did = trim($this->input->post('did'));
		echo json_encode($this->Common_model->get_sub_department_list($did));
	}
}

public function getAssignList()
{
	if(check_logged_in())
    {
		$oid = trim($this->input->post('oid'));
		
		//echo json_encode($this->Common_model->get_assign_list($oid));
		
		echo json_encode($this->Common_model->get_tls_for_assign2(""));
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


public function getUserName()
{
	if(check_logged_in())
    {
		$fid = trim($this->input->post('fid'));
		if($fid!=="")
		{
			$qSql="Select CONCAT(fname,' ' ,lname) as value from signin Where fusion_id = '$fid' ";
			//echo $qSql;
			echo $this->Common_model->get_single_value($qSql);
			
		}else{
			echo "";
		}
	}
	
} 

 
 public function getUserList()
{
	if(check_logged_in())
    {
		$aname = trim($this->input->post('aname'));
		$aomuid = trim($this->input->post('aomuid'));
		$cond="";
		
		if($aname!="") $cond=" Where fname like '%$aname%' OR lname like '%$aname%' ";
		if($aomuid!=""){
			if($cond=="") $cond=" Where omuid like '%$aomuid%' ";
			else $cond .=" OR omuid like '%$aomuid%' ";
		}
		if($aname!=="" || $aomuid!="")
		{
			$qSql="Select id,fusion_id,omuid,fname,lname,status from signin $cond ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}else{
			json_encode(array());
		}
	}
	
} 

 
 
public function get_user_details()
{
	if(check_logged_in())
    {
		$_uid = trim($this->input->get('uid'));
		//$data["error"] = ''; 
		echo json_encode($this->user_model->get_user_details($_uid));
	}
	
} 


public function update_user()
{
	if(check_logged_in())
    {
		$srole_id= get_role_id();
		$current_user = get_user_id();
		
		$uid = trim($this->input->post('uid'));
		
		$fusion_id = trim($this->input->post('fusion_id'));
		$office_id = trim($this->input->post('office_id'));
		$dept_id = trim($this->input->post('dept_id'));
		$sub_dept_id = trim($this->input->post('sub_dept_id'));
		
		$xpoid = trim($this->input->post('xpoid'));
		$omuid = trim($this->input->post('omuid'));
		$red_login_id = trim($this->input->post('red_login_id'));
		
		$fname = trim($this->input->post('fname'));
		$lname = trim($this->input->post('lname'));
		
		$role_id = trim($this->input->post('role_id'));
		
		$old_role_id = trim($this->input->post('old_role_id'));
		
		$site_id = trim($this->input->post('site_id'));
		$process_id = trim($this->input->post('process_id')); 
		
		$assigned_to = trim($this->input->post('assigned_to'));
						
		$email_id = trim($this->input->post('email_id')); 
		
		$phno = trim($this->input->post('phno')); 
		$doj = trim($this->input->post('doj')); 
		
		$sub_process_id = trim($this->input->post('sub_process_id'));
		$client_id = trim($this->input->post('client_id'));
		
		$batch_code=trim($this->input->post('batch_code'));
		
		$_field_array = array(
			"fusion_id" => $fusion_id,
			"office_id" => $office_id,
			"dept_id" => $dept_id,
			"sub_dept_id" => $sub_dept_id,
			"fname" => $fname,
			"lname" => $lname,
			"role_id" => $role_id,
		); 
				
		
		$_field_array['xpoid']=$xpoid;
		$_field_array['omuid']=$omuid;
		$_field_array['red_login_id']=$red_login_id;
		
		if($phno!=""){
			 $_field_array['phno']=$phno;
		}
		
		if($doj!=""){
			 $doj=mmddyy2mysql($doj);
			 $_field_array['doj']=$doj;
		}
		
		if($email_id!=""){
			$_field_array['email_id']=$email_id;
		}
				
		$_field_array['site_id']=$site_id;
		$_field_array['process_id']=$process_id;
		$_field_array['assigned_to']=$assigned_to;
		
		$_field_array['client_id']=$client_id;
		$_field_array['sub_process_id']=$sub_process_id;
		$_field_array['batch_code']=$batch_code;
		
		if($uid!=""){
			
			$this->db->trans_start();
			/////////////////////////////////
			
			$this->db->where('id', $uid);
			$this->db->update('signin',$_field_array );
			
			if($old_role_id != $role_id){
				
				$log=get_logs();
				
				$evt_date = CurrMySqlDate();
				$cur_date = CurrDate();
				
				$up_his_array = array(
					"endate" => $cur_date,
				);
				
				$this->db->where('user_id', $uid);
				$this->db->where('role_id', $old_role_id);
				$this->db->update('role_history',$up_his_array );
							
				$role_his_array = array(
					"user_id" => $uid,
					"role_id" => $role_id,
					"stdate" => $cur_date,
					"change_date" => $evt_date,
					"change_by" => $current_user,
					"log" => $log,
				); 
						
				$rowid= data_inserter('role_history',$role_his_array);
				
			}
			
			$this->db->trans_complete();
			//////////////
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
		
			$LogMSG="Update User Info of $fname $lname ($fusion_id) ";
			log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}

public function update_disposition()
	{
	
		$this->load->model('Common_model');
	 
		if(check_logged_in())
		{		
			$uid = trim($this->input->post('uid'));
			$event_master_id = trim($this->input->post('event_master_id'));
			
			//$terms_date = trim($this->input->post('kterms_date'));
			
			$qSql="select count(user_id) as value from terminate_users_pre where user_id ='$uid' and action_status='P'";
			$is_in_preterm=$this->Common_model->get_single_value($qSql);
			
			$qSql="select count(user_id) as value from terminate_users where user_id ='$uid' and rejon_date is null";
			$is_in_knownterm=$this->Common_model->get_single_value($qSql);
			
			//$terms_date = trim($this->input->post('kterms_date'));
			
			if($is_in_preterm==0 && $is_in_knownterm==0){
				
				$evt_date=CurrMySqlDate();
				$terms_date=$evt_date;
				
				if($event_master_id==7){
				
					 //$start_date =mdyDateTime2MysqlDate($terms_date);
					 //$terms_date=mdydt2mysql($terms_date);
					 $start_date=CurrDate();
					 
				}else{
					$start_date = mmddyy2mysql(trim($this->input->post('start_date')));
				}
				
				$end_date = trim($this->input->post('end_date'));
				$ticket_no = trim($this->input->post('ticket_no'));
				$remarks = trim($this->input->post('remarks'));
				
				if($end_date=="") $end_date=$start_date;
				else $end_date=mmddyy2mysql($end_date);
						
										
				$event_by= get_user_id();
				$log=get_logs();
				
				$_field_array = array(
					"user_id" => $uid,
					"event_time" => $evt_date,
					"event_by" => $event_by,
					"event_master_id" => $event_master_id,
					"start_date" => $start_date,
					"end_date" => $end_date,
					"ticket_no" => $ticket_no,
					"remarks" => $remarks,
					"log" => $log
				); 
				
				if($uid!="" && $event_by!="" && $event_master_id!="" ){
					
					$this->db->trans_start();
					/////////////////////////////
					
					$this->db->where('id', $uid);
					$this->db->update('signin', array('disposition_id' => $event_master_id));
					
					$event_id = data_inserter('event_disposition',$_field_array);
					
					if($event_id!==false)
					{
						
						if($event_master_id==7){
							
							$this->db->where('id', $uid);
							$this->db->update('signin', array('status' =>'2'));
							
							$_field_array = array(
								"user_id" => $uid,
								"terms_date" => $terms_date,
								"comments" => $remarks,
								"terms_by" => $event_by,
								"is_term_complete" => "N",
								"evt_date" => $evt_date,
							); 
							data_inserter('terminate_users',$_field_array);
							
						}
						
					 $ans="done";
					 
					}else $ans="error";
					
					
					$this->db->trans_complete();
					///////////////////
					
				}else $ans="error";
				
				if($ans=="done"){
				
				///////////
					$disp_name=$this->Common_model->get_single_value("Select description as value from event_master where id='$event_master_id'");
					
					$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
					$query = $this->db->query($qSql);
					$uRow=$query->row_array();
					
					$omuid=$uRow["omuid"];
					$full_name=$uRow["full_name"];
					
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
					
					$LogMSG="Update Disposition of $full_name ($omuid) with $disp_name (DbId: $event_master_id)";
					log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
					
				//////////
					
					if($event_master_id==7){
						$this->Common_model->send_email_submit_ticket($uid,$terms_date,$remarks);
					}else if($event_master_id==2){
						$this->Common_model->send_email_ncns($uid,$start_date);
						$this->Common_model->send_email_ncns_agent($uid,$start_date);						
					}else{
						$this->Common_model->send_email_loa_req($uid,$start_date);					
					}	
				}
				
				echo $ans;
				
			}else{
				echo "PRETREM";
			}
		}	
	} 
	

public function update_disposition_bulk()
	{
	
		$this->load->model('Common_model');
	 
		if(check_logged_in())
		{		
			$uids = trim($this->input->post('uids'));
			$disp_id = trim($this->input->post('disp_id'));
			
			$start_date = CurrDate();
			$end_date = CurrDate();
			$event_by= get_user_id();
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
			$log=get_logs();
			
			if($uids!="" && $disp_id!=""){
			
				$arrUids = explode(",", $uids);
				for($i=0;$i<count($arrUids);$i++){
				
					$uid=$arrUids[$i];
					
					$_field_array = array(
						"user_id" => $uid,
						"event_time" => CurrMySqlDate(),
						"event_by" => $event_by,
						"event_master_id" => $disp_id,
						"start_date" => $start_date,
						"end_date" => $end_date,
						"log" => $log
					); 
					
					if($uid!="" && $event_by!="" && $disp_id!="" ){
						
						$this->db->where('id', $uid);
						$this->db->update('signin', array('disposition_id' => $disp_id));	
						
						if($this->db->affected_rows()>0){
						
							$event_id = data_inserter('event_disposition',$_field_array);
							
							///////////
							$disp_name=$this->Common_model->get_single_value("Select description as value from event_master where id='$disp_id'");
							
							$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
							$query = $this->db->query($qSql);
							$uRow=$query->row_array();
							
							$omuid=$uRow["omuid"];
							$full_name=$uRow["full_name"];
							
							$LogMSG="Update Disposition of $full_name ($omuid) with $disp_name (DbId: $disp_id)";
							log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
							//////////
							
							$this->Common_model->send_email_loa_req($uid,$start_date);
						}
						
					}
					
				}
				
				$ans="done";
				
			}else{
				$ans="error";
			}				
			echo $ans;
		}
		
	}
	
 

public function get_pre_term_user_info()
{
	if(check_logged_in())
    {
		
		$uid = trim($this->input->post('uid'));
		$uid=addslashes($uid);
		
		$preRowId = trim($this->input->post('preRowId'));
		$preRowId=addslashes($preRowId);
		
		$qSql="select a.omuid,pre_req_date,last_login_time,last_logout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join `terminate_users_pre` b on a.id=b.user_id where a.id='$uid' and b.id='$preRowId'";
		
		$query = $this->db->query($qSql);
		$uRow=$query->row_array();
		
		$omuid=$uRow["omuid"];
		$full_name=$uRow["full_name"];
		$site_name=$uRow["site_name"];
		$last_login_time=$uRow["last_login_time"];
		$last_logout_time=$uRow["last_logout_time"];
		$pre_req_date=$uRow["pre_req_date"];
		$process_name=$uRow["process_name"];
				
		$html="";
		$html .="<table width='100%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
		$html .="<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";
		
		$html .="<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$last_logout_time</td></tr>";
		$html .="</table>";
				
		echo $html;
	}
}

public function get_last_disposition()
{
	if(check_logged_in())
    {
		
		$uid = trim($this->input->post('uid'));
		$uid=addslashes($uid);
		
		$qSql="select * from event_disposition where user_id='$uid' order by id desc limit 1";
		
		$query = $this->db->query($qSql);
		$uRow=$query->row_array();
		
		$start_date=mysql2mmddyySls($uRow["start_date"]);
		//$disp_id=$uRow["event_master_id"];
		//$disp_name=$uRow["disp_name"];
		
		echo $start_date;
	}
}

public function update_pre_term_user_info()
{
	if(check_logged_in())
    {
	
		$uid = trim($this->input->post('pTermUid'));
		$uid=addslashes($uid);
		
		$preRowId = trim($this->input->post('preRowId'));
		$preRowId=addslashes($preRowId);
		
		$next_shift_time = mdydt2mysql(trim($this->input->post('next_shift_time')));
		$terms_time = mdydt2mysql(trim($this->input->post('terms_time')));
				
		$lastDispDt = trim($this->input->post('lastDispDt'));
		if($lastDispDt!=""){
			 $lastDispDt=mmddyy2mysql($lastDispDt);
		}
		
		$terms_by = get_user_id();
		$evt_date = CurrMySqlDate();
		
		$s_dt = date('Y-m-d', strtotime(date($lastDispDt) .'1 day'));
		$e_dt = date('Y-m-d', strtotime(date($next_shift_time) .'-1 day'));
		
		$start = strtotime($s_dt);
		$end = strtotime($e_dt);
	
		$diff = ($end - $start) / 86400; 
		//echo $diff;	
		
		for ($i = 0; $i <= $diff; $i++) {
			$date = $start + ($i * 86400);
			$cDate= date('Y-m-d', $date);
			
			
			$_field_array = array(
				"user_id" => $uid,
				"event_time" => $evt_date,
				"event_by" => $terms_by,
				"event_master_id" => '5',
				"start_date" => $cDate,
				"end_date" => $cDate
			); 
			data_inserter('event_disposition',$_field_array);
			
		}
		
		if($uid!="" && $terms_time!="" && $next_shift_time!=""){
		
			$Update_array = array(
					"is_update" => 'Y',
					"next_shift_time" => $next_shift_time,
					"term_time" => $terms_time,
				);
				
			$this->db->where('user_id', $uid);
			$this->db->where('id', $preRowId);
			$this->db->where('action_status ','P');
			
			$this->db->update('terminate_users_pre', $Update_array);
			
			if($this->db->affected_rows()>0){
			
				//////////LOG////////
							
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Pre terminate request of $full_name ($omuid) is Updated with NextShift: $next_shift_time and TermTime: $terms_time";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
				//////////
				$this->Common_model->send_email_tarms_pre($uid,$preRowId);
			
			}
			
			echo "done";
		}else
			echo "error";
	}
}


public function reject_pre_term_request()
{
	if(check_logged_in())
    {
		$uid = trim($this->input->post('rejPreTermUid'));
		
		$rejPreRowId = trim($this->input->post('rejPreRowId'));
		
		$action_desc = trim($this->input->post('action_desc'));
			
		if($uid!="" && $action_desc!="" && $rejPreRowId!=""){
			
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();
			$action_status="R";
			
			$Update_array = array(
					"action_status" =>$action_status,
					"action_desc" => $action_desc,
					"action_by" => $current_user,
					"action_time" => $evt_date,
				);
			
			$this->db->where('user_id', $uid);
			$this->db->where('id', $rejPreRowId);
			$this->db->where('action_status ','P');
			$this->db->update('terminate_users_pre', $Update_array);
			
			if($this->db->affected_rows()>0){
			
				$agent_name=$this->Common_model->get_single_value("Select CONCAT(fname,' ' ,lname) as value from signin where id='$uid'");
				$rej_by=$this->Common_model->get_single_value("Select CONCAT(fname,' ' ,lname) as value from signin where id='$current_user'");
				
				//$esubject="Pre terminate request of ".$agent_name." is canceled by ".$rej_by." on ".$evt_date;
				
				$esubject=" Pre terminate request is canceled ";
				
				$body="<b>Pre terminate request is canceled by ".$rej_by." on ".$evt_date."<br><br>".$action_desc."<b>";
				//send email reject 
				
				//////////LOG////////
							
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Pre terminate request of $full_name ($omuid) is canceled ";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
				//////////
					
				$this->Common_model->send_email_reject_pre_tarms($uid,$rejPreRowId,$body,$esubject);
			}
				
			echo "done";
		}else
			echo "error";
			
	}
	
}



public function user_act_deact()
{
	if(check_logged_in())
    {
		$_uid = trim($this->input->post('uid'));
		$_sid = trim($this->input->post('sid'));
		
		if($_uid!=""){
			$this->db->where('id', $_uid);
			$this->db->update('signin', array('status' => $_sid));
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}


public function setGlobalAccess()
{
	if(check_logged_in())
    {
		$_uid = trim($this->input->post('uid'));
		$cgval = trim($this->input->post('cgval'));
		if($cgval==1)$cgval=0;
		else $cgval=1;
		if($_uid!=""){
			$this->db->where('id', $_uid);
			$this->db->update('signin', array('is_global_access' => $cgval));
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}

public function reset_password()
{
	if(check_logged_in())
    {
		$_uid = trim($this->input->post('uid'));	
		if($_uid!=""){
			
			
			$uSql="Update signin set passwd=IFNULL(fusion_id,omuid) where id='".$_uid."'";
			
			$this->db->query($uSql);
			
			//////////LOG////////
						
			$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();			
			$omuid=$uRow["omuid"];
			$full_name=$uRow["full_name"];
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Reset Password of $full_name ($omuid) ";
			log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}







public function terminate_user()
{
	if(check_logged_in())
    {
		$current_user = get_user_id();
					
		$uid = trim($this->input->post('tuid'));
		
		$ticket_no = trim($this->input->post('ticket_no'));
		$comments = trim($this->input->post('comments'));
		
		$terms_date = trim($this->input->post('terms_date'));
		if($terms_date!=""){
		
			 $start_date =mdyDateTime2MysqlDate($terms_date);
			 $end_date=$start_date;
			 
			 $terms_date=mdydt2mysql($terms_date);
			 
		}
		
		$ticket_date = trim($this->input->post('ticket_date'));
		
		if($ticket_date!=""){
			 $ticket_date=mdydt2mysql($ticket_date);
		}
		
		
		
		$terms_by = $current_user;
		$evt_date = CurrMySqlDate();
		
			$_field_array = array(
				"user_id" => $uid,
				"terms_date" => $terms_date,
				"ticket_no" => $ticket_no,
				"ticket_date" => $ticket_date,
				"comments" => $comments,
				"terms_by" => $terms_by,
				"is_term_complete" => "Y",
				"evt_date" => $evt_date,
			); 
			
			if($uid!="" && $terms_date!=""){
				
				$Update_array = array(
					"action_status" => 'T',
					"action_desc" => $comments,
					"action_by" => $terms_by,
					"action_time" => $evt_date,
				);
			
				$this->db->where('user_id', $uid);
				$this->db->where('action_status ','P');
				$this->db->update('terminate_users_pre', $Update_array);
				
				if($this->db->affected_rows()>0){
				
					data_inserter('terminate_users',$_field_array);
					
					$this->db->where('id', $uid);
					$this->db->update('signin', array('status' =>'0','disposition_id' =>'7'));
					
					//////////////////////
					
					$_field_array = array(
						"user_id" => $uid,
						"event_time" => $evt_date,
						"event_by" => $terms_by,
						"event_master_id" => '7',
						"start_date" => $start_date,
						"end_date" => $end_date,
						"ticket_no" => $ticket_no,
						"remarks" => $comments,
					); 
					
					data_inserter('event_disposition',$_field_array);
					
					
					
							
						$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
						$query = $this->db->query($qSql);
						$uRow=$query->row_array();
						
						$omuid=$uRow["omuid"];
						$full_name=$uRow["full_name"];
						
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
								
						$LogMSG=" Terminate User $full_name ($omuid) Ticket no: $ticket_no";
						log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
						//////////
						$this->Common_model->send_email_tarms($uid,$ticket_no,$ticket_date,$comments);
						
					}
			
			$ans="done";
			
		}else{
			$ans="error";
		}
		echo $ans;
	}
}


public function update_termination_ticket()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		$uid = trim($this->input->post('ut_uid'));
		
		$ticket_no = trim($this->input->post('ut_ticket_no'));
				
		$ticket_date = trim($this->input->post('ut_ticket_date'));
		
		if($ticket_date!=""){
			 $ticket_date=mdydt2mysql($ticket_date);
		}
		
		//$comments = trim($this->input->post('ut_comments'));
		
		if($uid!="" && $ticket_no!="" && $ticket_date!=""){
			
			$update_by = $current_user;
			$update_date = CurrMySqlDate();
		
		$_Ufield_array = array(
			"user_id" => $uid,
			"ticket_no" => $ticket_no,
			"ticket_date" => $ticket_date,
			"update_by" => $update_by,
			"is_term_complete" => "Y",
			"update_date" => $update_date,
		); 
				
		$this->db->where('user_id', $uid);
		$this->db->where('is_term_complete ','N');
		$this->db->update('terminate_users', $_Ufield_array);
		
		if($this->db->affected_rows()>0){
		
				$this->db->where('id', $uid);
				$this->db->update('signin', array('status' =>'0'));
					
			///
				
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();
				
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
						
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG=" Upadete Terminate User info of $full_name ($omuid) Ticket no: $ticket_no";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			///
				$this->Common_model->send_email_tarms($uid,$ticket_no,$ticket_date,"");
				
			}
			
			$ans="done";
		}else{
			
			$ans="error";
		}
		
		echo $ans;
		
	}
	
}





public function rejoin_term_user()
{
	if(check_logged_in())
    {
		$uid = trim($this->input->post('rjuid'));
		$remarks = trim($this->input->post('remarks'));
		$rejoin_date=trim($this->input->post('rejoin_date'));
		
		if($uid!="" && $rejoin_date!=""){
							
				$evt_date=CurrMySqlDate();
				
				$start_date = mmddyy2mysql($rejoin_date);
				$end_date=$start_date;
				
				$event_by= get_user_id();
				$log=get_logs();
				
				$_field_array = array(
					"user_id" => $uid,
					"event_time" => $evt_date,
					"event_by" => $event_by,
					"event_master_id" => '8',
					"start_date" => $start_date,
					"end_date" => $end_date,
					"remarks" => $remarks,
					"log" => $log
				); 
				
				if($uid!="" && $event_by!="" ){
					
					$this->db->trans_start();
					/////////////////////////////
					
					$this->db->update("signin",array("status"=>1,"disposition_id" =>1),array("id"=>$uid));
					
					$this->db->update("terminate_users",array("rejon_date"=>$start_date),array("user_id"=>$uid,"rejon_date" =>null));
					
					$event_id = data_inserter('event_disposition',$_field_array);
					
					$this->db->trans_complete();
					
					$ans="done";
					$rj_msg="Rejoin ";
			}else{

				$rj_msg="Fail to Rejoin ";
				$ans="error";
			}
					
					
				//////////LOG////////
							
				$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG=$rj_msg." the $full_name ($omuid) ";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
				//////////
			
			
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}

	

public function save_manual_login_details_not_used()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		
		$uid = trim($this->input->post('uid'));
		$login_time = trim($this->input->post('login_time'));
		$logout_time = trim($this->input->post('logout_time'));
		$disp_id = trim($this->input->post('disp_id'));
		$comments = trim($this->input->post('comments'));
				
		if($uid!="" && $login_time!="" && $logout_time!=""){
			
			if($login_time!="")$login_time=mdydt2mysql($login_time);
			if($logout_time!="")$logout_time=mdydt2mysql($logout_time);
		
			$added_by = $current_user;
			$added_time = CurrMySqlDate();
			$log=get_logs();
			
		$_sfield_array = array(
			"user_id" => $uid,
			"login_time" => $login_time,
			"logout_time" => $logout_time,
			"disp_id" => $disp_id,
			"added_by" => $added_by,
			"added_time" => $added_time,
			"comments" => $comments,
			"log" => $log
		); 
			
		$rowid= data_inserter('logged_in_details_manual',$_sfield_array);
		if($rowid!=false){
				///
				
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();
				
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
						
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Added Manual Login Details of $full_name ";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );	
				
			}
			$ans="done";
		}else{			
			$ans="error";
		}
		echo $ans;
	}
	
}




public function save_manual_login_details()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		
		$uid = trim($this->input->post('uid'));
		$login_date = trim($this->input->post('login_date'));
		$login_time = trim($this->input->post('login_time'));
				
		$logout_date = trim($this->input->post('logout_date'));
		$logout_time = trim($this->input->post('logout_time'));
		
		$disp_id = trim($this->input->post('disp_id'));
		$comments = trim($this->input->post('comments'));
				
		if($uid!="" && $login_date!="" && $login_time!="" && $logout_date!="" && $logout_time!=""){
			
			if($login_date!="") $login_time=mmddyy2mysql($login_date).' '.$login_time;
			if($logout_date!="") $logout_time=mmddyy2mysql($logout_date).' '.$logout_time;
				
			$added_by = $current_user;
			$added_time = CurrMySqlDate();
			$log=get_logs();
			
		$_sfield_array = array(
			"user_id" => $uid,
			"login_time" => $login_time,
			"logout_time" => $logout_time,
			"disp_id" => $disp_id,
			"added_by" => $added_by,
			"added_time" => $added_time,
			"comments" => $comments,
			"log" => $log
		); 
		
		//print_r($_sfield_array);
		
		$rowid= data_inserter('logged_in_details_manual',$_sfield_array);
		if($rowid!=false){
				///
				
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();
				
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
						
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Added Manual Login Details of $full_name ";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );	
				
			}
			$ans="done";
		}else{			
			$ans="error";
		}
		echo $ans;
	}
	
}


public function save_manual_login_details_any()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		
		$agent_fusion_id = trim($this->input->post('agent_fusion_id'));
		$login_date = trim($this->input->post('mlogin_date'));
		$login_time = trim($this->input->post('mlogin_time'));
				
		$logout_date = trim($this->input->post('mlogout_date'));
		$logout_time = trim($this->input->post('mlogout_time'));
		
		$disp_id = trim($this->input->post('mdisp_id'));
		$comments = trim($this->input->post('mcomments'));
		
		if($agent_fusion_id!="" && $login_date!="" && $login_time!="" && $logout_date!="" && $logout_time!=""){
			
			$qSql="Select id as value from signin Where fusion_id = '$agent_fusion_id'";
			$user_id = $this->Common_model->get_single_value($qSql);
				
			if($login_date!="") $login_time=mmddyy2mysql($login_date).' '.$login_time;
			if($logout_date!="") $logout_time=mmddyy2mysql($logout_date).' '.$logout_time;
		
			$added_by = $current_user;
			$added_time = CurrMySqlDate();
			$log=get_logs();
			
		$_sfield_array = array(
			"user_id" => $user_id,
			"login_time" => $login_time,
			"logout_time" => $logout_time,
			"disp_id" => $disp_id,
			"added_by" => $added_by,
			"added_time" => $added_time,
			"comments" => $comments,
			"log" => $log
		); 
			
		$rowid= data_inserter('logged_in_details_manual',$_sfield_array);
		if($rowid!=false){
				///
				
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$user_id'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();
				
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
						
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Added Manual Login Details of $full_name ";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );	
				
			}
			$ans="done";
		}else{			
			$ans="error";
		}
		echo $ans;
	}
	
}



		
public function update_user_info()
{

	
	if(check_logged_in())
    {
	
		$data["aside_template"] = get_aside_template();
				
		$data["content_template"] = "user/update_user_info.php";
		$data["error"] = ''; 
		
		$sUid=get_user_id();
		
		if($this->input->post('submit')=="Update")
		{
				
				$uid = trim($this->input->post('uid'));
				$email_id = trim($this->input->post('email_id')); 
				$phno = trim($this->input->post('phno'));
				$xpoid = trim($this->input->post('xpoid')); 
				
				if($uid==$sUid){
				
					$_field_array = array(
						"phno" => $phno,
						"email_id" => $email_id,
						"xpoid" => $xpoid
					);
					
					//print_r($_field_array);
					
					if($uid!=""){
						$this->db->where('id', $uid);
						$this->db->update('signin',$_field_array );
						
						//////////LOG////////
						
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
					
						$LogMSG="Update Contacts Information with $email_id , $phno of user_id $uid ";
						log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );						
						//////////
						//$ans="done";
					}else{
						//$ans="error";
					}
					
					//echo $ans;
				}	
		}
		
		$qSql="Select id,phno,email_id,xpoid,doj from signin where id='$sUid'";
		$data['user_info'] = $this->Common_model->get_query_result_array($qSql);
		
		$this->load->view('dashboard',$data);
		 
	}
	
}

	
public function break_on()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$_field_array = array(
								"last_break_on_time" => date("Y-m-d H:i:s"),
								"is_break_on" => 1
							);
			
			$this->db->update("signin",$_field_array,array("id"=>$current_user));
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Others Break Timer on";
			log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			
			if($this->user_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}
	
	public function break_off()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$log=get_logs();
			
			$_insert_array = array(
								"user_id" => $current_user,
								"out_time" => $this->user_model->get_break_on_time($current_user),
								"in_time" => date("Y-m-d H:i:s"),
								"log" => $log
							);
			
			$_table = "break_details";			
			
			if($this->user_model->check_break_on($current_user)===true)
			{
				//$uSql="Update signin set last_logged_date=NULL,disposition_id=1,is_logged_in=0 where id=".$current_user;
				//$this->db->query($uSql);
				
				$this->db->update("signin",array("last_break_on_time"=>"NULL","is_break_on" =>0),array("id"=>$current_user));
				
				$this->db->insert($_table,$_insert_array);
				
				//////////LOG////////
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Others Break Timer off";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
				//////////
				
				if($this->db->affected_rows() > 0) print true;
				else print false;	
			} 
			else print false;
		}
		
	}
	
	
	public function break_on_ld()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$_field_array = array(
					"last_break_on_time_ld" => date("Y-m-d H:i:s"),
					"is_break_on_ld" => 1
				);
			
			$this->db->update("signin",$_field_array,array("id"=>$current_user));
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Lunch/Dinner Break Timer on";
			log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
						
			if($this->user_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}
	
	public function break_off_ld()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$log=get_logs();
			
			$_insert_array = array(
						"user_id" => $current_user,
						"out_time" => $this->user_model->get_break_on_time_ld($current_user),
						"in_time" => date("Y-m-d H:i:s"),
						"log" => $log
					);
			
			$_table = "break_details_ld";			
			
			if($this->user_model->check_break_on_ld($current_user)===true)
			{
				//$uSql="Update signin set last_logged_date=NULL,disposition_id=1,is_logged_in=0 where id=".$current_user;
				//$this->db->query($uSql);
				
				$this->db->update("signin",array("last_break_on_time_ld"=>"NULL","is_break_on_ld" =>0),array("id"=>$current_user));
				
				$this->db->insert($_table,$_insert_array);
				
				//////////LOG////////
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Lunch/Dinner Timer off";
				log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
				//////////
				
				if($this->db->affected_rows() > 0) print true;
				else print false;	
			} 
			else print false;
		}
		
	}
		
		

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Update login details
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function loggin_to_dialer()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
					
			$_field_array = array(
								"last_logged_date" => date("Y-m-d H:i:s"),
								"is_logged_in" => 1,
								"disposition_id" =>0
							);
			
			$this->db->update("signin",$_field_array,array("id"=>$current_user));
			
			if($this->user_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Update dialer logout details
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function logout_from_dialer()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$log=get_logs();
			
			$_insert_array = array(
								"user_id" => $current_user,
								"login_time" => $this->user_model->get_dialer_logged_in_time($current_user),
								"logout_time" => date("Y-m-d H:i:s"),
								"logout_by"	=> $current_user,
								"log" => $log
							);
			
			$_table = "logged_in_details";			
			
			if($this->user_model->check_dialer_logged_in($current_user)===true)
			{
				$this->db->update("signin",array("last_logged_date"=>"","disposition_id"=>1,"is_logged_in" =>0),array("id"=>$current_user));
			
				$this->db->insert($_table,$_insert_array);
				if($this->db->affected_rows() > 0) print true;
				else print false;	
			} 
			else print false;
		}
	}
	




   
}

?>