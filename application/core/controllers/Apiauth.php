<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apiauth extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
	 }
	
    public function index()
    {		
				$fid = trim($this->input->post('fid'));
				$form_data = $this->input->post();
				
				if($fid==""){
					$fid=trim($this->input->get('fid'));
					$form_data = $this->input->get();
				}
				
				$pswd = trim($this->input->post('pswd'));
				if($pswd=="") $pswd=trim($this->input->get('pswd'));
				
				$cip = $this->input->post('cip');
				if($cip=="") $cip=trim($this->input->get('cip'));
				
				$apps_ver = $this->input->post('ver');
				if($apps_ver=="") $apps_ver=trim($this->input->get('ver'));
				
				unset($form_data["pswd"]); 
				
				//echo $fid. ">>".$pswd." || ".$cip;
				$retArray=array();
				
				/*
				if($apps_ver !="EfficiencyXv1.0.1.0"){
					
					$retArray['resp']="Failed";
					$retArray['details']="Please Upgrade Your EfficiencyX Application With 1.0.1.0 Version.\r\n Please download again from https://fems.fusionbposervices.com/EfficiencyX/";
								
				}else{
				
				*/
				
					if($fid!='' && $pswd!='' && $cip!=''){
												
						if($this->auth_model->check_credentials($fid,$pswd)==true){
														
							$_array = $this->auth_model->get_userdata($fid);
							$user_id=$_array["id"];
							$dept_id=$_array["dept_id"];
							$dept_folder=$_array["dept_folder"];
							$client_ids=$_array["client_ids"];
							$process_ids=$_array["process_ids"];
							
							$ex_Idle_thld_min = $_array["ex_Idle_thld_min"];
							$ex_is_Idle_ntfy= $_array["ex_is_Idle_ntfy"];
							$ex_Idle_ntfy_thld_min= $_array["ex_Idle_ntfy_thld_min"];
							$ex_is_capture_ss =  $_array["ex_is_capture_ss"];
							$ex_capture_thld_min = $_array["ex_capture_thld_min"];
							$is_enable_2fa = $_array["is_enable_2fa"];
							
							if(strtolower($dept_folder)=="operations" && $client_ids!="" && $process_ids!="" ){
								
								try{
									
									$qSql = "Select * from process where client_id in ($client_ids) AND id in ($process_ids) limit 1";							
									$pConfigRow = $this->Common_model->get_query_row_array($qSql);
									
									if(!empty($pConfigRow)){			
										$ex_Idle_thld_min = $pConfigRow["ex_ideal_thld_min"];
										$ex_is_Idle_ntfy= $pConfigRow["ex_is_ideal_ntfy"];
										$ex_Idle_ntfy_thld_min= $pConfigRow["ex_ideal_ntfy_thld_min"];
										$ex_is_capture_ss =  $pConfigRow["ex_is_capture_ss"];
										$ex_capture_thld_min = $pConfigRow["ex_capture_thld_min"];
										$is_enable_2fa = $pConfigRow["is_enable_2fa"];
									}
									
								}catch(Exception $e){
									
								}
							}
							
						
							if($user_id!="" ){
								
								$token_expire_time=CurrMySqlDate();
								$Update_array = array(
									"is_active" => '0',
									"token_expire_time" =>$token_expire_time
								);
											
								$this->db->where('user_id', $user_id);
								$this->db->where('is_active ','1');
								$this->db->update('api_access_token', $Update_array);
										
								$is_active=1;
								$access_token = bin2hex(openssl_random_pseudo_bytes(8));
								$token_gen_time=CurrMySqlDate();
								
								$_field_array = array(
									"user_id" => $user_id,
									"client_ip" => $cip,
									"access_token" => $access_token,
									"token_gen_time" => $token_gen_time,
									"apps_ver" => $apps_ver,
									"is_active" => $is_active
								); 
								
								$ret = data_inserter('api_access_token',$_field_array);
								if ($ret===false){
									$retArray['resp']="Failed";
									$retArray['details']="Error to gen token";
								}else{
									$retArray['resp']="Success";
									$retArray['uid']=$user_id;
									$retArray['token']=$access_token;
									$retArray['femsid']=$_array["fusion_id"];
									$retArray['Idle_threshold_min']=$ex_Idle_thld_min;
									$retArray['is_Idle_notify']=$ex_is_Idle_ntfy;
									$retArray['Idle_notify_threshold_min']=$ex_Idle_ntfy_thld_min;
									$retArray['is_capture_screenshot']=$ex_is_capture_ss;
									$retArray['capture_threshold_min']=$ex_capture_thld_min;
									$retArray['is_enable_2fa_auth']=$is_enable_2fa;
									$retArray['is_verified_email']=$_array["is_varify_email"];
									$retArray['email_personal']=$_array["email_id_per"];
									$retArray['email_office']=$_array["email_id_off"];
								}
								
							}else{
								$retArray['resp']="Failed";
								$retArray['details']="Error to gen token";
							}
							
						}else{
							$retArray['resp']="Failed";
							$retArray['details']="Wrong UserId or Password";
						}
						
					}else{
						$retArray['resp']="Failed";
						$retArray['details']="Invalid Input";
					}
				//}
		echo json_encode($retArray);
	}
}

?>