<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientlogin extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('Client_model');
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
	 }
	 
	 
	public function index(){
		$data["csrf_token"]=gen_csrf_token();
		$this->load->view('clientlogin/client_login.php',$data);
    }
	
	
	
	public function clientAuth(){
		
		$data["error"] = '';
		
		//password expiry
		$this->Common_model->update_password_expiry();
		//////
		
		if($this->input->post('submit')){
			$_omuid = $this->input->post('omuid');
			$_passwd = $this->input->post('passwd');
			
			$UserLocalIP = $this->input->post('UserLocalIP');
			$this->session->set_userdata('UserLocalIP', $UserLocalIP);
			$csrf_token = $this->input->post('csrf_token');
			$FEMSCSRFTOKEN  = $this->session->userdata('FEMSCSRFTOKEN');
			
			$form_data = $this->input->post();
			unset($form_data["passwd"]); 
			
			if($_omuid!='' && $_passwd!='' && ($csrf_token==$FEMSCSRFTOKEN) ){
				
				$_check_credentials = function($_omuid,$_passwd)
				{
					return $this->Client_model->check_credentials($_omuid,$_passwd);
				};
				
				
					$_set_session_data = function($_omuid){
							
						$_array = $this->Client_model->get_userdata($_omuid);
					
						if($_array!==false)
						{
							$deptFolder = "client";
							$roleFolder = "client";
							if(!empty($_array['role'])){
								$deptFolder = $_array['role'];
								$roleFolder = $_array['role'];
							}
							
							$newdata = array(
								'id'=>$_array["id"],
								'login_type'=>'client',
								'status'=>$_array['status'],
								'name'=>$_array["name"],
								"office_id" => $_array['office_id'],
								"client_id" => $_array['client_id'],
								"client_ids" => $_array['client_id'],
								"client_name" => $_array['client_name'],
								"process_id" => $_array['process_id'],
								"process_ids" => $_array['process_id'],
								"phno" => $_array['phno'],
								"pic_ext" => $_array['pic_ext'],
								"allow_process_update" => $_array['allow_process_update'],
								"allow_qa_module" => $_array['allow_qa_module'],
								"allow_qa_audit" => $_array['allow_qa_audit'],
								"allow_qa_review" => $_array['allow_qa_review'],
								"allow_ba_module" => $_array['allow_ba_module'],
								"allow_knowledge" => $_array['allow_knowledge'],
								"allow_dfr_interview" => $_array['allow_dfr_interview'],
								"allow_dfr_report" => $_array['allow_dfr_report'],
								"allow_mind_faq" => $_array['allow_mind_faq'],
								"allow_qa_dashboard" => $_array['allow_qa_dashboard'],
								"allow_qa_dipcheck" => $_array['allow_qa_dipcheck'],
								"allow_qa_report" => $_array['allow_qa_report'],
								"allow_calibration" => $_array['allow_calibration'],
								"allow_kyt" => $_array['allow_kyt'],
								"allow_naps" => $_array['allow_naps'],
								'is_global_access'=>"0",
								'fusion_id'=>"client_".$_array["id"],
								"dept_folder" => $deptFolder,
								"dept_id" => "0",
								"dept_name" => "",
								"role" => $roleFolder,
								"role_dir" => "",
								"role_id" => "999999",
								"site_id" => "0",
								"oth_office" => "",
								'assigned_to'=>"0",
								'is_update_pswd'=>$_array["is_update_pswd"],
								'is_site_admin'=> "0",
							);
									
							$this->session->set_userdata("logged_in",$newdata);
							
							//$current_user = get_user_id();
							
							log_message('FEMS', $_omuid.' - '.$_array["name"] .' | Login success');
						
							return true;
							
						}else return false;
						
				};
				
				$curr_date = CurrMySqlDate();
				
				if($_check_credentials($_omuid,$_passwd)===true){
						
						
						$is_Ok =$_set_session_data($_omuid);
																		
						if($is_Ok===true){
							
							$isPreOK=$this->do_pre_login_process();
							
							if($isPreOK==1){
								$current_user = get_user_id();
								$logs=get_logs(); 
								log_record($current_user,'Success','Client Login',$form_data,$logs);
								
								redirect(base_url()."clientlogin/client_home","refresh");
								
							}else if($isPreOK==2){
								
								log_message('FEMS', $_omuid.' | Client Login Fail, Another User Already login');
							
								$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
								log_record("",'Fail, Another User Already login','Client Login',$form_data,$logs);
					
								$this->session->set_flashdata("error",show_msgbox("Error Occurred! Another User Already login.",true));
								redirect($_SERVER['HTTP_REFERER'],"refresh");
								
							}else{
								
								log_message('FEMS', $_omuid.' | Client Login Fail, Error to pre process');
							
								$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
								log_record("",'Fail, pre process','Client Login',$form_data,$logs);
						
								$this->session->set_flashdata("error",show_msgbox("Error Occurred! Try Later",true));
								redirect($_SERVER['HTTP_REFERER'],"refresh");
							
							}
							
						}else{ 
							log_message('FEMS', $_omuid.' | Client Login Fail, Error to set session data');
							
							$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
							log_record("",'Fail, Error to set session data','Client Login',$form_data,$logs);
					
							$this->session->set_flashdata("error",show_msgbox("Error Occurred! Try Later",true));
							redirect($_SERVER['HTTP_REFERER'],"refresh");
						}
					
				}else{
					
					log_message('FEMS', $_omuid.' | Client Login Fail, Wrong UserId or Password');
					
					$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
					log_record("",'Fail, Wrong UserId or Password','Client Login',$form_data,$logs);
					
					$this->session->set_flashdata("error",show_msgbox('Wrong UserId or Password',true));
					redirect($_SERVER['HTTP_REFERER'],"refresh");
				}
				
			}else{
				 $this->session->set_flashdata("error",show_msgbox("UserID and Password are required",true));
				 redirect($_SERVER['HTTP_REFERER'],"refresh");
			}
			
		}
	}
	
	
	private function do_pre_login_process()
	{
		$ret=1;
				
		try {
			
			$current_user = get_user_id();
						
			$qSql= "SELECT * FROM signin_client where id = '$current_user'";
			$signinDetails = $this->Common_model->get_query_row_array($qSql);
			
			// FOR MULTIPLE LOGIN ACCESS
			//if(!empty($signinDetails['login_type']) && $signinDetails['login_type'] == 2){
			//	$_field_array = array( "is_logged_in" => 0 );
			//	$this->db->update("signin_client",$_field_array,array("id"=>$current_user));
			//}
			
			//$qSql= "SELECT is_logged_in as value FROM signin_client where id = '$current_user' ";
			//$is_logged_in = $this->Common_model->get_single_value($qSql);
			
			$is_logged_in = $signinDetails['is_logged_in']; 
			
			if($is_logged_in==1){
				//Allow Multiple Login
				if(!empty($signinDetails['id']) && $signinDetails['allow_kyt'] == 1) $ret=1;
				else if(!empty($signinDetails['login_type']) && $signinDetails['login_type'] == 2) $ret=1;
				else $ret=2;
				
			}else{
				
				$_field_array = array(
						"last_logged_date" => date("Y-m-d H:i:s"),
						"is_logged_in" => 1
				);
				
				$this->db->update("signin_client",$_field_array,array("id"=>$current_user));
				
			}
			
		}catch(Exception $e) {
			$ret=0;
		}
		
		return $ret;
		
	}
	
	public function client_logout(){
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$logs=get_logs(); 
			log_record($current_user,'Success','Client Logout',"",$logs);
			$currDate=CurrMySqlDate();
			
			$qSql= "SELECT is_logged_in as value FROM signin_client where id = '$current_user' ";
			$is_logged_in = $this->Common_model->get_single_value($qSql);
			
			$qSql= "SELECT last_logged_date as value FROM signin_client where id = '$current_user' ";
			$login_time = $this->Common_model->get_single_value($qSql);
			
				$_insert_array = array(
					"user_id" => $current_user,
					"login_time" => $login_time,
					"logout_time" => $currDate,
					"logout_by"	=> $current_user,
					"log" => $logs
				);
				
				$_table = "logged_in_details_client";			
				
				if($is_logged_in==1)
				{
					
					$_field_array = array(
						"last_logged_date" => "",
						"is_logged_in" => 0
					);
				
					$this->db->update("signin_client",$_field_array,array("id"=>$current_user));
					$this->db->insert($_table,$_insert_array);
				}
				
				
			setcookie("iSOpenNotifi", "N", time() - 3600);
				
			$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT"); //Date in the past
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
					
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('skipBankInfo');
			$this->session->unset_userdata('skipPerInfo');
			$this->session->unset_userdata('UserLocalIP');
				
			$this->session->sess_destroy();
				
			redirect(base_url()."clientlogin","refresh");
		}	
	}
	
	
	
	public function change_password(){
		if(check_logged_in()){			
			$current_user = get_user_id();
			$current_date = date('Y-m-d');
			$data["error"] = ''; 
			
			if($this->input->post('submit')=="Save")
			{
				$old_pswd = trim($this->input->post('old_pswd'));
				$oldpassword = trim($this->input->post('old_password'));
				$password = trim($this->input->post('new_password'));
				$repassword = trim($this->input->post('re_password'));
					
				if($old_pswd==$oldpassword){
					
					if($password!="" && $repassword!=""){
						if(strlen($password)>=8){
							if($password==$repassword){

									$_field_array = array(
											"passwd" => $password,
											"is_update_pswd" => 'Y',
											"pswd_update_date" => $current_date
									);
									
									$this->db->where('id', $current_user);
									$this->db->where('passwd', $oldpassword);
									$this->db->update('signin_client', $_field_array);
									
									$ses_array = $this->session->userdata('logged_in');
									$ses_array['is_update_pswd'] = "Y";
									
									$this->session->set_userdata("logged_in",$ses_array);
									
									////// Update user Login //////
									/* $_field_array = array(
										"last_logged_date" => date("Y-m-d H:i:s"),
										"is_logged_in" => 1,
										"disposition_id" =>0
									);
								
									if($this->user_model->check_dialer_logged_in($current_user)===false)
									{
										$this->db->update("signin",$_field_array,array("id"=>$current_user));
									} */
									
									////// Update user Login //////
									
									$data["error"] = show_msgbox('Password Update Successfully.',true);
									redirect(base_url()."clientlogin/client_home");
										
							 }else{
									$data["error"] = show_msgbox('Mismatch Password.',true);
									redirect(base_url()."clientlogin/client_home");
							 }
						
						}else{
					
							$data["error"] = show_msgbox('Password must be minimum 8 characters.',true);
							redirect(base_url()."clientlogin/client_home");
						}
					}else{
						$data["error"] = show_msgbox('Password Or Confirm Password is Blank.',true);
						redirect(base_url()."clientlogin/client_home");
					}
				
				}else{
					$data["error"] = show_msgbox('Old Password is Invalid.',true);
					redirect(base_url()."clientlogin/client_home");
				}
				
			}else{
				redirect(base_url()."clientlogin/client_home");
			}
			$this->load->view('clientlogin/client_home.php',$data);
			
		}
	}
	
	
	public function client_home(){
		if(check_logged_in()){
			
			$current_user=get_user_id();
			$client_id=get_clients_client_id();
			$process_id=get_clients_process_id();
			if($client_id=="") $client_id="99999999";
			
			$data["error"] = '';
			
			$qSql = "SELECT id, concat(fname, ' ', lname) as name from signin_client where status=1 order by name asc ";
			$data["user_client"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from signin_client WHERE id='$current_user'";
			
			$data["client_info"] = $this->Common_model->get_query_row_array($qSql);
			
			$qSql= "SELECT mind_faq_url as value FROM client where id in ($client_id) and mind_faq_url!='' and is_active=1 ";
			$data["mind_faq_url"] = $this->Common_model->get_single_value($qSql);
			
			$process_id_array = explode("','",$process_id);
			
			if(in_array(266,$process_id_array)) $data["mind_faq_url"] ="mindfaq_affinity";
			else if(in_array(377,$process_id_array)) $data["mind_faq_url"] ="mindfaq_brightway";
						
			$qSql="Select passwd as value from signin_client where id='$current_user'";
			$data['old_pswd'][0]['passwd'] = $old_pswd = $this->Common_model->get_single_value($qSql);
			
			$qSql="Select yy.*, ii.*,ii.id as sch_id from (Select r.id as rid, r.requisition_id, r.req_no_position, r.filled_no_position, r.department_id, r.role_id, r.location, r.due_date, c.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name from dfr_requisition r, dfr_candidate_details c where r.id=c.r_id and c.candidate_status='IP') yy Right Join (Select dis.* from dfr_interview_schedules dis where interview_type='5' and assign_interviewer = '$current_user') ii ON (ii.c_id=yy.id)";
			
			$data["get_assigned_client"] = $this->Common_model->get_query_result_array($qSql);
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			
			if(get_update_pswd() == "Y"){
				$this->load->view('clientlogin/client_home.php',$data);
			}else{ 
				$this->load->view('clientlogin/change_passwd.php',$data);
			}
			
		}
    }
	
	
	public function changePasswd(){
		
		$current_user=get_user_id();
		
		$qSql = "SELECT * from signin_client WHERE id='$current_user'";
		$data["client_info"] = $this->Common_model->get_query_row_array($qSql);
		
		$qSql="Select passwd as value from signin_client where id='$current_user'";
		$data['old_pswd'][0]['passwd'] = $old_pswd = $this->Common_model->get_single_value($qSql);
			
		$this->load->view('clientlogin/change_passwd.php',$data);
		
	}
		 
} 