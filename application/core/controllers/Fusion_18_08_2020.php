<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fusion extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('user_model');
		$this->load->model('Common_model');
	
		
	}
	
	public function index()
	{
		
		$this->session->set_flashdata("error",'');
		
		//echo "isDayLightSaving:: ". isDayLightSaving("2020-04-10","ALB");
		//====================================================================
		// Automatically logout after 12 hrs
		
		$this->user_model->auto_logout_after_hrs();
		$this->load->view('loginnew');
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////
	// LOGIN CHECK AND PAGE RE-DIRECTIONS
	/////////////////////////////////////////////////////////////////////////////////////////
	
	public function login()
	{
		$type=strtoupper($this->uri->segment(2));
		$data["type"] = strtoupper($this->uri->segment(2));
		
		$data["error"] = '';
				
		//====================================================================
		// Submit Button Click
		//
		
		if($this->input->post('submit'))
		{
			
			if($this->agent->is_mobile()) redirect(base_url(),"refresh");
			///////////////////////////////////////////////////////////////
			
			$_omuid = $this->input->post('omuid');
			$_passwd = $this->input->post('passwd');
			
			
			$UserLocalIP = $this->input->post('UserLocalIP');
			$this->session->set_userdata('UserLocalIP', $UserLocalIP);
									
			$form_data = $this->input->post();
			unset($form_data["passwd"]); 
			
			if($_omuid!='' && $_passwd!='')
			{
				$_passwd=md5($_passwd);
				
				$this->load->model('auth_model');
				
				//
				// Check Credentials Anonymous Function 
				//
				
				$_check_credentials = function($_omuid,$_passwd)
				{
					return $this->auth_model->check_credentials($_omuid,$_passwd);
				};
				
					//
					// Set Session Data Anonymous Function 
					//
				
					$_set_session_data = function($_omuid){
										
						$_array = $this->auth_model->get_userdata($_omuid);
						
						//print_r($_array);
					
						if($_array!==false)
						{
							
							$_role_dir=$_array["folder"];
							$_role=$_array['role_id'];
							$dept_folder = $_array['dept_folder'];
							$status = $_array['status'];
							$user_id = $_array["id"];
							
							// special access to MIS MANGALDEEP nas atanu
					
							if($_array["is_site_admin"]=='1') $_role_dir="admin";
							if(is_access_as_hr($_array['fusion_id']) == true) $dept_folder = "hr";
							if($dept_folder == "rta") $dept_folder = "wfm";
							
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
							
							/*
								setcookie('uid',$_array["id"]);
								setcookie('aname',$_array["name"]);
								setcookie('omuid',$_omuid);
								setcookie('fusion_id',$_array["fusion_id"]);
								//setcookie('client_id',$_array["client_id"]);
								setcookie('client_ids',$_array["client_ids"]);
								//setcookie('process_id',$_array["process_id"]);
								setcookie('process_ids',$_array["process_ids"]);
								setcookie('dept_id',$_array["dept_id"]);
								setcookie('dept_name',$_array["dept_name"]);
								setcookie('dept_shname',$_array["dept_shname"]);
								setcookie('dept_folder',$_array["dept_folder"]);
								setcookie('office_id',$_array["office_id"]);
								setcookie('oth_office',$_array["oth_office"]);
								setcookie('role_id',$_array["role_id"]);
								setcookie('role',$_array["role"]);
								setcookie('role_dir',$_role_dir);
								setcookie('site_id',$_array["site_id"]);
								setcookie('is_accept_consent',$_array["is_accept_consent"]);
							*/
							
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
									
									log_message('FEMS', $_omuid.' - '.$_array["name"].' | Login Fail, user in termination  queue');
									
									
									$logs=get_logs(); 
									log_record($current_user,'Fail, user in termination  queue','Login',$form_data,$logs);
							
									return '2';
								}
								
							}
							///End PRE TERM
							
							
							log_message('FEMS', $_omuid.' - '.$_array["name"] .' | Login success');
							
							return true;
							
						}else return false;
						
				};
				
				$curr_date = CurrMySqlDate();
				
				if($_check_credentials($_omuid,$_passwd)===true){
					
					//$disp_id=$this->Common_model->get_single_value("Select disposition_id as value from signin where id='$current_user'");
					//////
					//if($disp_id!=2 && $disp_id!=3 && $disp_id!=4){
						
						$is_Ok =$_set_session_data($_omuid);
						
						
						
						if($is_Ok===true){
														
							//redirect(base_url().get_role_dir()."/dashboard","refresh");
							$current_user = get_user_id();
							$logs=get_logs(); 
							log_record($current_user,'Success','Login',$form_data,$logs);
							
							redirect(base_url()."home","refresh");
							
							
						}else if($is_Ok=='2'){
							
							$this->session->set_flashdata("error",show_msgbox("You are in termination  queue.<br>Please contact to your manager",true));
							//redirect($_SERVER['HTTP_REFERER'],"refresh");
							$this->load->view('loginnew',$data);
							
						}else
						{ 
							log_message('FEMS', $_omuid.' | Login Fail, Error to set session data');
							
							$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
							log_record("",'Fail, Wrong UserId or Password','Login',$form_data,$logs);
					
							$this->session->set_flashdata("error",show_msgbox("Error Occurred! Try Later",true));
							//redirect($_SERVER['HTTP_REFERER'],"refresh");
							$this->load->view('loginnew',$data);
						}
						
					//}else{
						
					//		$this->session->set_flashdata("error",show_msgbox("Your are in leave. Please contact to your manager",true));
					//		redirect($_SERVER['HTTP_REFERER'],"refresh");
					//}
					
				}else{
					
					log_message('FEMS', $_omuid.' | Login Fail, Wrong UserId or Password');
					
					$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
					log_record("",'Fail, Wrong UserId or Password','Login',$form_data,$logs);
							
							
					$this->session->set_flashdata("error",show_msgbox('Wrong UserId or Password',true));
					//redirect($_SERVER['HTTP_REFERER'],"refresh");
					$this->load->view('loginnew',$data);
					
				}
			}
			else
			{
				 $this->session->set_flashdata("error",show_msgbox("UserID and Password are required",true));
				 //redirect($_SERVER['HTTP_REFERER'],"refresh");
				 $this->load->view('loginnew',$data);
				 
			}
		}else{
			
			
			 $login_title="";
			 $login_view="";
			 $this->session->set_flashdata("error",'',true);
			
			$data['login_title']=$login_title;
			$this->load->view('loginnew',$data);
		
		
		}	
		
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////
	//  Logout
	////////////////////////////////////////////////////////////////////////////////////
	
	public function forcelogout()
	{
		$this->user_model->auto_logout_after_hrs();
		
		setcookie("iSOpenNotifi", "N", time() - 3600);
		
		$current_user = get_user_id();
		$log=get_logs();
		log_record($current_user,'Success','Logout',"",$log);
		
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT"); //Date in the past
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
				
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('skipBankInfo');
		$this->session->unset_userdata('skipPerInfo');
		$this->session->unset_userdata('UserLocalIP');
		$this->session->sess_destroy();
			
		redirect(base_url(),"refresh");
			
	}
	
	public function logout()
	{
		
		if(check_logged_in())
		{
			
			if(get_login_type()=="client"){
				
				if(get_login_type() == "client") redirect(base_url().'clientlogin/client_logout',"refresh");
				
			}else{
				
				$this->user_model->auto_logout_after_hrs();
							
				$current_user = get_user_id();
				$fusion_id = get_user_fusion_id();
				
				$log=get_logs();
				
				$currDate=CurrMySqlDate();	
				//"logout_time" => date("Y-m-d H:i:s"),
				$login_time = $this->user_model->get_dialer_logged_in_time($current_user);
				$login_time_local = getEstToLocalCurrUser($login_time);
				$logout_time_local= getEstToLocalCurrUser($currDate);
				
				$_insert_array = array(
					"user_id" => $current_user,
					"login_time" => $login_time,
					"login_time_local" => $login_time_local,
					"logout_time" => $currDate,
					"logout_time_local" => $logout_time_local,
					"logout_by"	=> $current_user,
					"log" => $log
				);
				
				$_table = "logged_in_details";			
				
				if($this->user_model->check_dialer_logged_in($current_user)===true)
				{
					$this->db->update("signin",array("last_logged_date"=>"","disposition_id"=>1,"is_logged_in" =>0),array("id"=>$current_user));
				
					$this->db->insert($_table,$_insert_array);
				}
				
				
				$token_expire_time=CurrMySqlDate();
				$Update_array = array(
					"is_active" => '0',
					"token_expire_time" =>$token_expire_time
				);
							
				$this->db->where('user_id', $current_user);
				$this->db->where('is_active ','1');
				$this->db->update('api_access_token', $Update_array);
								
				
				////LOG////////
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | User logout');
				////////
				
				//break_OFF
				$_table = "break_details_ld";
				
				$out_time = $this->user_model->get_break_on_time_ld($current_user);
				$out_time_local = getEstToLocalCurrUser($out_time);
				$in_time_local= getEstToLocalCurrUser($currDate);
				
				if($this->user_model->check_break_on_ld($current_user)===true)
				{
					
					$_insert_array = array(
						"user_id" => $current_user,
						"out_time" => $out_time,
						"out_time_local" => $out_time_local,
						"in_time" => $currDate,
						"in_time_local" => $in_time_local,
						"log" => $log
					);
					
					$this->db->update("signin",array("last_break_on_time_ld"=>"NULL","is_break_on_ld" =>0),array("id"=>$current_user));
					$this->db->insert($_table,$_insert_array);
				}
				
				$_table = "break_details";
				$out_time = $this->user_model->get_break_on_time($current_user);
				$out_time_local = getEstToLocalCurrUser($out_time);
				$in_time_local= getEstToLocalCurrUser($currDate);
				
				if($this->user_model->check_break_on($current_user)===true)
				{
					
					$_insert_array = array(
						"user_id" => $current_user,
						"out_time" => $out_time,
						"out_time_local" => $out_time_local,
						"in_time" => $currDate,
						"in_time_local" => $in_time_local,
						"log" => $log
					);
					
					$this->db->update("signin",array("last_break_on_time"=>"NULL","is_break_on" =>0),array("id"=>$current_user));
					$this->db->insert($_table,$_insert_array);
				} 
				
				
				log_record($current_user,'Success','Logout',"",$log);
								
				setcookie("iSOpenNotifi", "N", time() - 3600);
				
				$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT"); //Date in the past
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache");
						
				$this->session->unset_userdata('logged_in');
				$this->session->unset_userdata('skipBankInfo');
				$this->session->unset_userdata('skipPerInfo');
				$this->session->unset_userdata('UserLocalIP');
				
				$this->session->sess_destroy();
				
				redirect(base_url(),"refresh");
		
			}
			
		}
		
		
	}
	
	
	public function frm_change_password()
	{
	if(check_logged_in())
    {
		$cur_user = get_user_id();
		$data["aside_template"] = get_aside_template();
		
		$data["error"] = ''; 
		
		$curr_date=date('Y-m-d');
		
		if($this->input->post('submit')=="ChangePasswd")
        {
			$password = trim($this->input->post('password'));
			
            $repassword = trim($this->input->post('repassword'));
			
			 if($password!="" && $repassword!=""){
				
				if(strlen($password)>=8){
				
				
						 if($password==$repassword){
								
								$password = md5($password);
								
								$_field_array = array(
										"passwd" => $password,
										"pswd_update_date" => $curr_date
								);
								
								$this->db->update("signin",$_field_array,array("id"=>$cur_user));
								
								$data["content_template"] = "user/success.php";
								
								$Lfull_name=get_username();
								$LOMid=get_user_omuid();
								log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | User Changed Password');
			
									
						 }else{
								$data["error"] = show_msgbox('Mismatch Password Or Confirm Password.',true);
								$data["content_template"] = "user/change_password.php";
						 }
				}else{
				
					$data["error"] = show_msgbox('Password must be minimum 8 characters.',true);
					$data["content_template"] = "user/change_password.php";
				}
				 
			 }else{
				
				$data["error"] = show_msgbox('Password Or Confirm Password is Blank.',true);
				$data["content_template"] = "user/change_password.php";
			 }
		}else{
			$data["content_template"] = "user/change_password.php";
		}
		
		$this->load->view('dashboard',$data);
		
	}
}	
	
	
	
	
	
}

?>
