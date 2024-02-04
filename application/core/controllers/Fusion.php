<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fusion extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		
		
	}
	
	public function index()
	{
	//	if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata("error_dl",'');
			$this->session->set_flashdata("error",'');
			
			//echo "isDayLightSaving:: ". isDayLightSaving("2020-04-10","ALB");
			//====================================================================
			// Automatically logout after 12 hrs
			
			$this->user_model->auto_logout_after_hrs();
			$data["csrf_token"]=gen_csrf_token();
			$this->load->view('loginnew',$data);
		//}else{
		//	redirect(base_url()."home");
		//}
		
		
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////
	// LOGIN CHECK AND PAGE RE-DIRECTIONS
	/////////////////////////////////////////////////////////////////////////////////////////
	
	public function login()
	{

		if(!$this->session->userdata('logged_in')){
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
				$csrf_token = $this->input->post('csrf_token');
				
				$this->session->set_userdata('UserLocalIP', $UserLocalIP);
										
				$form_data = $this->input->post();
				unset($form_data["passwd"]); 
				$FEMSCSRFTOKEN  = $this->session->userdata('FEMSCSRFTOKEN');
				
				if($_omuid!='' && $_passwd!='' && ($csrf_token==$FEMSCSRFTOKEN))
				{
				  if(isDisableFemsLogin($_omuid)==false)
				  {
						
					$_passwd=md5($_passwd);
					
					$this->load->model('auth_model');
					
					$curr_date = CurrMySqlDate();
					$isAuth = $this->auth_model->check_credentials($_omuid,$_passwd);
					
					if($isAuth===true)
					{
						
						//$disp_id=$this->Common_model->get_single_value("Select disposition_id as value from signin where id='$current_user'");
						//////
						//if($disp_id!=2 && $disp_id!=3 && $disp_id!=4)
						//{
							
							$_array = $this->auth_model->get_userdata($_omuid);
							
							$status = $_array['status'];
							$user_id = $_array["id"];
							$is_varify_email = $_array["is_varify_email"];
							
							$email_id_per = $_array["email_id_per"];
							$email_id_off = $_array["email_id_off"];
							
							
							//$isSesOK = $this->set_session_data($_array);
							$isSesOK = $this->set_pre_session_data($_array);
							
							if($isSesOK===true)
							{
								
								$is_enable_2fa = $_array["is_enable_2fa"];							
								//$is_enable_2fa = get_pre_enable_2fa();
																						
								$browser = $_SERVER['HTTP_USER_AGENT'];	
								
								if($is_enable_2fa == "Y"  && $user_id>1)
								{
								
																		
									if($is_varify_email=='1'){	
									
										$isGenOTP=$this->GenLoginOTP();
										
										if ($isGenOTP===false){
											log_message('FEMS', $_omuid.' | Login Fail, Error to generate 2fa code');
											$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
											log_record("",'Fail, Error to generate 2fa code','Login',$form_data,$logs);
											
											$this->session->set_flashdata("error",show_msgbox("Error to generate 2fa code! Try Later",true));
											$data["csrf_token"]=gen_csrf_token();
											$this->load->view('loginnew',$data);
								
										}else{
																					
											redirect(base_url()."twofa","refresh");
										}
										
									}else{
										
										redirect(base_url()."verifyemail","refresh");

									}
									
								}else
								{
								
									
									$isSesOK = $this->set_session_data($_array);
									//$isCookOK = $this->set_cookie_data($_array);
									$isPreOK=$this->do_pre_login_process();
									
									if($isPreOK==1){
										
										$current_user = get_user_id();
										$logs=get_logs(); 
										log_record($current_user,'Success','Login',$form_data,$logs);
										redirect(base_url()."home","refresh");
									
									
									}else if($isPreOK==2){
										
										$this->session->set_flashdata("error",show_msgbox("You are in termination  queue.<br>Please contact to your manager",true));
										//redirect($_SERVER['HTTP_REFERER'],"refresh");
										$data["csrf_token"]=gen_csrf_token();
										$this->load->view('loginnew',$data);
										
									}else{
										
										log_message('FEMS', $_omuid.' | Login Fail, Error on pre login process');
										
										$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
										log_record("",'Fail, Wrong UserId or Password','Login',$form_data,$logs);
								
										$this->session->set_flashdata("error",show_msgbox("2. Error Occurred! on pre login process",true));
										//redirect($_SERVER['HTTP_REFERER'],"refresh");
										$data["csrf_token"]=gen_csrf_token();
										$this->load->view('loginnew',$data);
										
									}
																	
								}
							
							}else{
							
								log_message('FEMS', $_omuid.' | Login Fail, Error to set session data');
								
								$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
								log_record("",'Fail, Wrong UserId or Password','Login',$form_data,$logs);
						
								$this->session->set_flashdata("error",show_msgbox("1.Error Occurred! to set session data",true));
								//redirect($_SERVER['HTTP_REFERER'],"refresh");
								$data["csrf_token"]=gen_csrf_token();
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
						$data["csrf_token"]=gen_csrf_token();
						$this->load->view('loginnew',$data);
						
					}
					
				 }else{
					 
					 $this->session->set_flashdata("error_dl",show_msgbox("Your login for today is not recorded as there are some documents which are pending to be submitted to HR. Please contact HR immediately.",true));
					 $this->session->set_flashdata("error",'',true);
					 //redirect($_SERVER['HTTP_REFERER'],"refresh");
					 $data["csrf_token"]=gen_csrf_token();
					 $this->load->view('loginnew',$data);
					 
				 }
				
				}else
				{
					 $this->session->set_flashdata("error",show_msgbox("UserID and Password are required",true));
					$this->session->set_flashdata("error_dl",'',true);
					 //redirect($_SERVER['HTTP_REFERER'],"refresh");
					 $data["csrf_token"]=gen_csrf_token();
					 $this->load->view('loginnew',$data);
					 
				}
				
			}else{
				
				 $login_title="";
				 $login_view="";
				 $this->session->set_flashdata("error_dl",'',true);
				 $this->session->set_flashdata("error",'',true);
				 			
				$data['login_title']=$login_title;
				$data["csrf_token"]=gen_csrf_token();
				$this->load->view('loginnew',$data);
				
			}
		}else{
			redirect(base_url()."home");
		}
		

		
		
	}
	
	public function resend2facode()
	{
		
		if(check_pre_logged_in())
		{
			$isGenOTP=$this->GenLoginOTP();
			echo $isGenOTP;
			
		}
	}
	
	
	public function verifyemail()
	{
		
		if(check_pre_logged_in())
		{
			$data["error"] = '';
			
			//$str,$amount=2, $char='*'
			$data["email_id_off"] = get_pre_email_id_off();
			$data["email_id_per"] = get_pre_email_id_per();
			$data["phone"] = get_pre_phone();
									
			if($this->agent->is_mobile()) redirect(base_url(),"refresh");
			if(get_pre_varify_email()==1) redirect(base_url(),"refresh");
			
			if($this->input->post('submit') && get_pre_varify_email()==0)
			{
				
				$user_id=get_pre_user_id();
				
				///////////////////////////////////////////////////////////////
				
				$email_id_per = $this->input->post('email_id_per');
				$email_id_off = $this->input->post('email_id_off');		
				$no_email_off = $this->input->post('no_email_off');
				
				
				$Update_array = array(
					"email_id_per" => $email_id_per,
					"email_id_off" => $email_id_off,
					"is_varify_email" => '1'
				);
								
				$this->db->where('user_id', $user_id);
				$this->db->update('info_personal', $Update_array);
				
				$ses_array = $this->session->userdata('logged_in');
				$ses_array['email_id_per'] = $email_id_per;
				$ses_array['email_id_off'] = $email_id_off;
				$ses_array['is_varify_email'] = "1";
				$this->session->set_userdata("logged_in",$ses_array);
									
				sleep(1);
				$isGenOTP=$this->GenLoginOTP();
				
				sleep(1);
				redirect(base_url()."twofa","refresh");
				
			}else{
				
				 $login_title="";
				 $login_view="";
				 $this->session->set_flashdata("error",'',true);
				
				$data['login_title']=$login_title;
				$this->load->view('email_verify',$data);
				
			}
		}
	}
	
	public function twofa()
	{
		
		if(check_pre_logged_in())
		{
				
			$data["error"] = '';
			$data["email_id_off"] ="";
			if(get_pre_email_id_off()!=""){
				$data["email_id_off"] = mask_email(get_pre_email_id_off(),2,"*");
			}
			$data["email_id_per"] =  mask_email(get_pre_email_id_per(),2,"*");
			$data["phone"] = get_pre_phone();
			$FEMSLOTP  = $this->session->userdata('FEMSLOTP');
			
			if($this->agent->is_mobile()) redirect(base_url(),"refresh");
			if($FEMSLOTP=="") redirect(base_url(),"refresh");
			
			if($this->input->post('submit'))
			{
				
				
				///////////////////////////////////////////////////////////////
				$form_data = $this->input->post();
				
				$vcode_arr = $this->input->post('vcode');
				$vcode=implode("",$vcode_arr);
				$FEMSLOTP  = $this->session->userdata('FEMSLOTP');
				$UserLocalIP  = $this->session->userdata('UserLocalIP');
				
				if($FEMSLOTP==$vcode){

					$this->session->unset_userdata('FEMSLOTP');
					
					$fusion_id=get_pre_user_fusion_id();
					$_array = $this->auth_model->get_userdata($fusion_id);
					$isSesOK = $this->set_session_data($_array);
					$isPreOK=$this->do_pre_login_process();
									
						if($isPreOK==1){
													
							//redirect(base_url().get_role_dir()."/dashboard","refresh");
							$current_user = get_user_id();
							$logs=get_logs(); 
							log_record($current_user,'Success','Login code verification',$form_data,$logs);
							redirect(base_url()."home","refresh");
						
						
						}else if($isPreOK==2){
							
							$this->session->set_flashdata("error",show_msgbox("You are in termination  queue.<br>Please contact to your manager",true));
							//redirect($_SERVER['HTTP_REFERER'],"refresh");
							redirect(base_url()."login","refresh");
							
						}else{
							
							log_message('FEMS', $_omuid.' | Login Fail, Error on pre login process');
							
							$logs = "RemoteIP: " .getClientIP() . " LocalIP: ".$UserLocalIP;
							log_record("",'Fail, Wrong UserId or Password','Login',$form_data,$logs);
					
							$this->session->set_flashdata("error",show_msgbox("Error Occurred! on pre login process",true));
							//redirect($_SERVER['HTTP_REFERER'],"refresh");
							redirect(base_url()."login","refresh");
							
						}
								
								
				}else{
					$this->session->set_flashdata("error",show_msgbox("You enter Wrong Verification Code. Please Try Again",true));
					//redirect($_SERVER['HTTP_REFERER'],"refresh");
					$this->load->view('2fa',$data);
				}
				
			}else{
				
				 $login_title="";
				 $login_view="";
				 $this->session->set_flashdata("error",'',true);
				
				$data['login_title']=$login_title;
				$this->load->view('2fa',$data);
				
			}
		}
		
	}
	
	
	private function GenLoginOTP()
	{	
		$ret=true;
		$user_id=get_pre_user_id();
		$fullname = get_pre_username();
				
		if($user_id!="" )
		{
			try
			{
								
				$access_code = mt_rand(111111,999999); 
				$this->session->set_userdata('FEMSLOTP', $access_code);
				$UserLocalIP  = $this->session->userdata('UserLocalIP');
				//echo $UserLocalIP;
				/*
				
				
				$code_expire_time=CurrMySqlDate();
				$Update_array = array(
					"is_active" => '0',
					"code_expire_time" =>$code_expire_time
				);
							
				$this->db->where('user_id', $user_id);
				$this->db->where('is_active ','1');
				$this->db->update('access_code_2fa', $Update_array);
						
				$is_active=1;
				$code_gen_time=CurrMySqlDate();
				$session_id = session_id();
								
				$_field_array = array(
					"user_id" => $user_id,
					"session_id" => $session_id,
					"client_ip" => $UserLocalIP,
					"access_code" => $access_code,
					"code_gen_time" => $code_gen_time,
					"is_active" => $is_active
				); 
				
				$ret = data_inserter('access_code_2fa',$_field_array);
				*/
				
				
								
				$eto = get_pre_email_id_per();
				if(get_pre_email_id_off()!="") $eto .= ", ".get_pre_email_id_off();
				
				$subj="FEMS Login One Time Password";
				
				$body="Dear $fullname, <br><br>
					   A login request has been made from your FEMS account.<br>
					   As an added level of security, you are requested to complete the login process by entering the bellow 6 digit OTP.<br><br>";
					   
				$body .= "<div style='font-size: 20px;'> Your Login OTP : <b>$access_code </b></div>";
				$body .="<br>Please note: A new 6 digit OTP is generated each time a login request made.";
				$body .="<br><br>Regards<br>Fusion - FEMS	</br>";
				
				$this->Email_model->send_email_sox($user_id, $eto , "", $body, $subj);
				sleep(1);
								
				$ret=true;
				
			}catch(Exception $e) {
				$ret=false;
			}
		}else{
			$ret=false;
		}
		
		return $ret;
	}
		
	private function do_pre_login_process()
	{
		$ret=1;
		
		try {
			
			$current_user = get_user_id();
			$username = get_username();
			$curr_date = CurrMySqlDate();
			$is_update_pswd= get_update_pswd();
			$user_fusion_id=get_user_fusion_id();
			$user_fusion_id=get_user_fusion_id();
			$status=get_status();
			$LoginIP=getLoginIP();
			
			if($status==4){
				
				$_field_array = array(
						"status" => 1
				);
				$this->db->update("signin", $_field_array, array("id" => $current_user));
			}
			
			
			
			if($is_update_pswd=="Y"){
				$_field_array = array(
						"last_logged_date" => date("Y-m-d H:i:s"),
						"last_logged_log" => $LoginIP,
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
			
			///NCNS PRE TERM							
			$pre_term_info=$this->Common_model->get_query_result_array("Select id,action_status,term_time from terminate_users_pre where user_id='$current_user' and action_status='P'");
								
			if(!empty($pre_term_info)){
				
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
										
					$esubject="NCNS Pre terminate request of ".$username." is canceled on ".$curr_date;
					//$esubject=" Pre terminate request is canceled ";									
					$body="<b>Pre terminate request is canceled, because agent login on time (".$curr_date.").<b>";
					//send email reject 
					$this->Common_model->send_email_reject_pre_tarms($current_user,$pt_row_id,$body,$esubject);
										
				}else{
										
					log_message('FEMS', $user_fusion_id.' - '.$username.' | Login Fail, user in termination  queue');
					$logs=get_logs(); 
					log_record($current_user,'Fail, user in termination  queue','Login',$form_data,$logs);
					$ret=2;
				}
									
			}
			///End NCNS PRE TERM	
			log_message('FEMS', $user_fusion_id.' - '.$username .' | Login success');
			
		}catch(Exception $e) {
			$ret=0;
		}

		return $ret;
		
	}
	
	
	private function set_pre_session_data($_array)
	{	
		$ret=true;
				
		if($_array!==false)
		{
			try {
																
				$newdata = array(
					'id'=>$_array["id"],
					'status'=>$_array['status'],
					'login_type'=>'femsuser',
					'name'=>$_array["name"],
					"fusion_id" => $_array['fusion_id'],
					'omuid' => $_array['omuid'],
					'is_enable_2fa'=>$_array["is_enable_2fa"],
					'email_id_off'=>$_array["email_id_off"],
					'email_id_per'=>$_array["email_id_per"],
					'phone'=>$_array["phone"],
					'is_varify_email'=>$_array["is_varify_email"]
				);
				
				$this->session->set_userdata("pre_logged_in",$newdata);
				
				$ret=true;
				
			}catch(Exception $e) {
			
				$ret=false;
			}
		}else{
			
			$ret=false;
		}
		
		return $ret;
	}
	
	private function set_session_data($_array)
	{	
		$ret=true;
				
		if($_array!==false)
		{
			try {
				
				$_role_dir=$_array["folder"];
				$_role=$_array['role_id'];
				$dept_folder = $_array['dept_folder'];
				$status = $_array['status'];
				$user_id = $_array["id"];
				
				if($_array["is_site_admin"]=='1') $_role_dir="admin";
				if(is_access_as_hr($_array['fusion_id']) == true) $dept_folder = "hr";
				
				if(is_executive_access_as_supervisor($_array["id"],$_role_dir,$dept_folder) == true) $_role_dir = "tl";
				
				$newdata = array(
					'id'=>$_array["id"],
					'status'=>$status,
					'login_type'=>'femsuser',
					'client_ids'=>$_array["client_ids"],
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
					'role_dir_original'=>$_array["folder"],
					'assigned_to'=>$_array["assigned_to"],
					'is_global_access'=>$_array["is_global_access"],
					'is_site_admin'=>$_array["is_site_admin"],
					'is_update_pswd'=>$_array["is_update_pswd"],
					'is_enable_2fa'=>$_array["is_enable_2fa"],
					'email_id_off'=>$_array["email_id_off"],
					'email_id_per'=>$_array["email_id_per"],
					'phone'=>$_array["phone"],
					'is_varify_email'=>$_array["is_varify_email"],
					'is_accept_consent'=>$_array["is_accept_consent"]
				);
				
				$this->session->set_userdata("logged_in",$newdata);
				$this->session->unset_userdata('pre_logged_in');
				
				$ret=true;
				
			}catch(Exception $e) {
			
				$ret=false;
			}
		}else{
			
			$ret=false;
		}
		
		return $ret;
	}
	
	
	private function set_cookie_data($_array)
	{
		
		$ret=true;
		
		try {
			
			if($_array["is_site_admin"]=='1') $_role_dir="admin";
			if(is_access_as_hr($_array['fusion_id']) == true) $dept_folder = "hr";
			
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
			
			$ret=true;
		}catch(Exception $e) {
			$ret=false;
		}
		
		return $ret;
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
		$this->session->unset_userdata('pre_logged_in');
		
		$this->session->unset_userdata('skipBankInfo');
		$this->session->unset_userdata('skipPerInfo');
		$this->session->unset_userdata('UserLocalIP');
		
		$this->session->unset_userdata('FEMSLOTP');
		$this->session->unset_userdata('FEMSCSRFTOKEN');
		
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
				$last_logged_log=$this->Common_model->get_single_value("Select last_logged_log as value from signin where id='$current_user'");
				
				$login_time_local = getEstToLocalCurrUser($login_time);
				$logout_time_local= getEstToLocalCurrUser($currDate);
				
				$_insert_array = array(
					"user_id" => $current_user,
					"login_time" => $login_time,
					"login_time_local" => $login_time_local,
					"logout_time" => $currDate,
					"logout_time_local" => $logout_time_local,
					"logout_by"	=> $current_user,
					"login_log"	=> $last_logged_log,
					"log" => $log
				);
				
				
				
				$_table = "logged_in_details";			
				
				if($this->user_model->check_dialer_logged_in($current_user)===true)
				{
					$this->db->update("signin",array("last_logged_date"=>null,"last_logged_log"=>"","disposition_id"=>1,"is_logged_in" =>0),array("id"=>$current_user));
				
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
				$this->session->unset_userdata('pre_logged_in');
				$this->session->unset_userdata('skipBankInfo');
				$this->session->unset_userdata('skipPerInfo');
				$this->session->unset_userdata('UserLocalIP');
				$this->session->unset_userdata('FEMSLOTP');
				$this->session->unset_userdata('FEMSCSRFTOKEN');
		
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
