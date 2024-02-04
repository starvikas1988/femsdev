<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apihome extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
	 }
	
    public function index()
    {
        		
				$data["error"] = '';
				
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
				
				
				
				//
					// Set Session Data Anonymous Function 
					//
				
					$_set_session_data = function($fusion_id){
										
						$_array = $this->auth_model->get_userdata($fusion_id);
						
						//print_r($_array);
					
						if($_array!==false)
						{
							
							$_role_dir=$_array["folder"];
							$_role=$_array['role_id'];
							$dept_folder = $_array['dept_folder'];
							$status = $_array['status'];
							$user_id = $_array["id"];
							
							if($_array["is_site_admin"]=='1') $_role_dir="admin";
							if(is_access_as_hr($_array['fusion_id']) == true) $dept_folder = "hr";
							
							$newdata = array(
									'id'=>$_array["id"],
									'status'=>$status,
									'login_type'=>'femsuser',
									//'client_id'=>$_array["client_id"],
									'client_ids'=>$_array["client_ids"],
									//'process_id'=>$_array["process_id"],
									'process_ids'=>$_array["process_ids"],
									'name'=>$_array["name"],
									"fusion_id" => $_array['fusion_id'],
									'omuid' => $_array['omuid'],
									"dept_id" => $_array['dept_id'],
									"dept_name" => $_array['dept_name'],
									"dept_shname" => $_array['dept_shname'],
									"dept_folder" => $dept_folder,
									"office_id" => $_array['office_id'],
									"oth_office" => $_array['oth_office'],
									'role_id'=>$_array['role_id'],
									'role'=>$_array["role"],
									'site_id'=>$_array["site_id"],
									'role_dir'=>$_role_dir,
									'assigned_to'=>$_array["assigned_to"],
									'is_global_access'=>$_array["is_global_access"],
									'is_site_admin'=>$_array["is_site_admin"],
									'is_update_pswd'=>$_array["is_update_pswd"],
									'is_accept_consent'=>$_array["is_accept_consent"]
									
							);
									
							$this->session->set_userdata("logged_in",$newdata);
							
							
							
							$current_user = get_user_id();
							
							if($status==4){
								
								$_field_array = array(
										"status" => 1
								);
								$this->db->update("signin", $_field_array, array("id" => $current_user));
							}
							
							if($_array["is_update_pswd"]=="Y"){
								
								$_field_array = array(
										"last_logged_date" => date("Y-m-d H:i:s"),
										"is_logged_in" => 1,
										"disposition_id" =>0
								);
								
								if($this->user_model->check_dialer_logged_in($current_user)===false)
								{
									$this->db->update("signin",$_field_array,array("id"=>$current_user));
									//echo $current_user. " - 2 -. >> '".$this->user_model->check_dialer_logged_in($current_user);
								}
							}
							
							//Check and update FOR LOA
							$isloa=$this->Common_model->check_update_for_loa();
							
														
							///PRE TERM							
							$pre_term_info=$this->Common_model->get_query_result_array("Select id,action_status,term_time from terminate_users_pre where user_id='$current_user' and action_status='P'");
							
							if(!empty($pre_term_info)){
							
								$curr_date = CurrMySqlDate();
								
								//print_r($pre_term_info);
								
								$action_status=$pre_term_info[0]['action_status'];
								$term_time=$pre_term_info[0]['term_time'];
								$pt_row_id=$pre_term_info[0]['id'];
								
								//echo  $action_status . " >> " .$curr_date. ">>" .$term_time;
								
								if($action_status=="P" && ( is_null($term_time) || $curr_date<=$term_time)){
								
									$Update_array = array(
											"action_status" => 'L',
											"action_desc" => "Agent login on time",
											"action_by" => $current_user,
											"action_time" => $curr_date,
										);
										
									$this->db->where('user_id', $current_user);
									$this->db->where('action_status ','P');
									$this->db->update('terminate_users_pre', $Update_array);
									
									//$esubject="Pre terminate request of ".$_array["name"]." is canceled on ".$curr_date;
									
									$esubject=" Pre terminate request is canceled ";
									
									$body="<b>Pre terminate request is canceled, because agent login on time (".$curr_date.").<b>";
									
									//send email reject 
									$this->Common_model->send_email_reject_pre_tarms($current_user,$pt_row_id,$body,$esubject);
									
								}else{
									
									log_message('FEMS', $_omuid.' - '.$_array["name"].' | Home API, Login Fail, user in termination  queue');
									
									
									$logs=get_logs(); 
									log_record($current_user,'Home API, Fail, user in termination  queue','Login',$form_data,$logs);
							
									return '2';
								}
								
							}
							///End PRE TERM
							
							
							log_message('FEMS', $fusion_id.' - '.$_array["name"] .' | Home API, Login success');
							
							return true;
							
						}else return false;
						
				};
				
				
				$curr_date = CurrMySqlDate();
				//echo $uid .">". $token .">". $cip;
				
				if($uid!='' && $token!='' && $cip!=''){
					
					if($this->auth_model->check_token_credentials($uid,$token,$cip)==true){
						
						
						$qSql="Select fusion_id as value from signin where id='$uid' and status in (1,4)";
						$fusion_id=$this->Common_model->get_single_value($qSql);
						
						$is_Ok =$_set_session_data($fusion_id);
						
						
						if($is_Ok===true){
														
							//redirect(base_url().get_role_dir()."/dashboard","refresh");
							$current_user = get_user_id();
							$logs=get_logs(); 
							log_record($current_user,'Success','Home API ',$form_data,$logs);
							
							redirect(base_url()."home","refresh");
							
							
						}else if($is_Ok=='2'){
							
							$this->session->set_flashdata("error",show_msgbox("You are in termination  queue.<br>Please contact to your manager",true));
							//redirect($_SERVER['HTTP_REFERER'],"refresh");
							$this->load->view('loginnew',$data);
							
						}else
						{ 
							log_message('FEMS', $_omuid.' | Home API, Error to set session data');
							
							$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
							log_record("",'Fail, Wrong UserId or Password','Home API ',$form_data,$logs);
					
							$this->session->set_flashdata("error",show_msgbox("Error Occurred! Try Later",true));
							//redirect($_SERVER['HTTP_REFERER'],"refresh");
							$this->load->view('loginnew',$data);
						}
						
					}else{
					
						$this->session->set_flashdata("error",show_msgbox("Error Occurred! Invalid Token",true));
						//redirect($_SERVER['HTTP_REFERER'],"refresh");
						$this->load->view('loginnew',$data);
					
					}
					
				}else{
					$this->session->set_flashdata("error",show_msgbox("Error Occurred! Invalid Input",true));
					//redirect($_SERVER['HTTP_REFERER'],"refresh");
					$this->load->view('loginnew',$data);
				}
	}
	
	
	
}

?>