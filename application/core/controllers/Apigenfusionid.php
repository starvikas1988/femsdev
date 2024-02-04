<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apigenfusionid extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('auth_model');
		
	 }
	
    public function index()
    {
        	
				$_run = false;  
								
				$fid = trim($this->input->post('fid'));
				$pu_id = trim($this->input->post('uid'));
				
				//$dbCnt=$this->Common_model->get_single_value("Select count(id) as value from signin where fusion_id='$fid' and id='$usr_id'");
				
				$usr_id=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$fid'");
				$dbCnt=$this->Common_model->get_single_value("Select count(id) as value from signin where fusion_id='$fid'");
				
				if($dbCnt==1)
				{
					$office_id = trim($this->input->post('office_id'));
					
					$dept_id = trim($this->input->post('dept_id'));
					$sub_dept_id = trim($this->input->post('sub_dept_id'));
					
					$xpoid = trim($this->input->post('xpoid'));
					$_omuid = trim($this->input->post('omuid'));
					
					$red_login_id = trim($this->input->post('red_login_id'));
					
					//$_passwd = trim($this->input->post('passwd'));
					
					$_fname = $this->input->post('fname');
					$_lname = $this->input->post('lname'); 
					$client_id = trim($this->input->post('client_id'));
					
					$_role_id = trim($this->input->post('role_id')); 
					$_process_id = trim($this->input->post('process_id'));
					
					//$sub_process_id = trim($this->input->post('sub_process_id'));
					//$_site_id = trim($this->input->post('site_id'));
														
					$_assigned_to = trim($this->input->post('assigned_to'));
					
					$email_id = trim($this->input->post('email_id'));
					$phno = trim($this->input->post('phno')); 
					$doj = trim($this->input->post('doj'));
					$dob = trim($this->input->post('dob'));
					
					$sex=trim($this->input->post('sex'));
					$hiring_source=trim($this->input->post('hiring_source'));
					
					$log = trim($this->input->post('log')); 
					$log='Through Api | ' . $log;
					
					$_status= 1;
					$_disp_id= 1;
					
									
					if($_role_id!="" && $_fname!="" && $_lname!=""  && $office_id!="" && $dept_id!="" )
					{
						if($this->user_model->user_omid_exists($_omuid)===false) $_run = true;  
						else $_run = false;  
						
						if($this->user_model->user_xpoid_exists_off($xpoid,$office_id)===false) $_run = true;  
						else $_run = false;						
						
					} 
						
						if($_run===true)
						{
							//"passwd" => $_passwd,
							
							$_field_array = array(
								"office_id" => $office_id,
								"dept_id" => $dept_id,
								"sub_dept_id" => $sub_dept_id,
								"fname" => $_fname,
								"lname" => $_lname,
								"sex" => $sex,
								"role_id" => $_role_id,
								"disposition_id" => $_disp_id,
								"status" => $_status,
								"log" => $log,
								
							); 
							
							if($xpoid!="")$_field_array['xpoid']=$xpoid;
							if($_omuid!="") $_field_array['omuid']=$_omuid;
							if($red_login_id!="") $_field_array['red_login_id']=$red_login_id;
														
							if($doj!=""){
								 //$doj=mmddyy2mysql($doj);
								 $_field_array['doj']=$doj;
							}
							
							if($dob!=""){
								 //$dob=mmddyy2mysql($dob);
								 $_field_array['dob']=$dob;
							}
							
							
							if($_assigned_to!="") $_field_array['assigned_to']=$_assigned_to;
							if($hiring_source!="") $_field_array['hiring_source']=$hiring_source;
						
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
								"change_by" => $usr_id,
								"log" => $log,
							); 
							
							$rowid= data_inserter('role_history',$role_his_array);
							$fusion_id="";
							
							if($_user_id!==FALSE)
							{
								// will be change
								
								$max_id=$this->Common_model->get_single_value("SELECT max(substr(fusion_id,5)) as value FROM signin where office_id='$office_id'");
								$max_id=$max_id+1;								
								$fusion_id="F".$office_id."".addLeadingZero($max_id,6);
								
								$Update_array = array(
										"fusion_id" => $fusion_id,
										"passwd" => $fusion_id
								);
								
								$this->db->where('id', $_user_id);
								$this->db->update('signin', $Update_array);	
								
								if($client_id!=""){
									$iClientArr = array(
										"user_id" => $_user_id,
										"client_id" => $client_id,
										"log" => $log,
									); 
									$rowid= data_inserter('info_assign_client',$iClientArr);
								}
								
								if($_process_id!=""){
									$iProcessArr = array(
										"user_id" => $_user_id,
										"process_id" => $_process_id,
										"log" => $log,
									); 
									$rowid= data_inserter('info_assign_process',$iProcessArr);
								}
								
								
								$personal_array = array(
									"user_id" => $_user_id,
									"email_id_per" => $email_id,
									"phone" => $phno,
									"log" => $log
								);
								
								$rowid= data_inserter('info_personal',$personal_array);
								
							}
							
							$this->db->trans_complete();						
							////////////////////////////
						
							
							if($fusion_id=="" || $_user_id===FALSE || $this->db->trans_status() === FALSE){
								echo "Failed DB Error Try Again";								
							}else{
									//////////LOG////////
								
									$LogMSG="Added User $_fname $_lname ($_omuid), Fusion id: $fusion_id ";
									log_message('FEMS', ' Through Api | '.$LogMSG );
									echo $fusion_id;
									
									//////////
									//$this->session->set_flashdata("error",show_msgbox("User Added Successfully",false));
									//redirect(base_url().get_role_dir()."/manage_users");
									//redirect(base_url()."users/addsuccess?uid=$_user_id");
									//redirect(base_url()."admin/dashboard#users/manage");
							}
							
						}else echo "Failed Invalid Data";
						
				}else{
					echo "Failed Auth";
				}
   }
   
   
}

?>