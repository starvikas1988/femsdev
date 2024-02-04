<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		
		
	}
	
	public function index()
	{
		if(!$this->session->userdata('logged_in')){
			$data["csrf_token"] = gen_csrf_token();
			$this->load->view('forgot_password_client/forgot_password.php',$data);
		}else{
			redirect(base_url()."home");
		}
		
		
		
	}

	public function check_fusion_id(){

		$email_id = $this->input->post('email_id');
		$_array = $this->auth_model->get_clientdata($email_id);

		$this->session->set_userdata('email_id', $email_id);

		if(!empty($_array['id'])){
			$status = $_array['status'];
			$name = $_array['name'];
			$user_id = $_array["id"];

			$startTime = CurrMySqlDate();
			$endTime = date('Y-m-d H:i:s', strtotime('+60 min', strtotime($startTime)));
			$isGenOTP = $this->GenLoginOTP($email_id,$name);
			
			if ($isGenOTP!=false){
				$otp  = $this->session->userdata('FEMSLOTP');
				$this->db->set("start_time",$startTime);
				$this->db->set("end_time",$endTime);
				$this->db->set("email_id",$email_id);
				$this->db->set("otp",$otp);
				// $this->db->set('fusion_id',$_omuid);
				$this->db->insert("forgot_password_otp");
				if($this->db->affected_rows()>0){
					$this->session->set_flashdata('error',"OTP Sent in mail!");
					// $this->session->set_userdata('fusion_id',$_omuid);
					redirect(base_url()."forgot_password/otp");
				}else{
					$this->session->set_flashdata('error',"Something Went Wromg,please try again later");
					redirect(base_url()."forgot_password");
				}	
				
			}else{
				$this->session->set_flashdata('error',"Something Went Wromg,please try again later");
				redirect(base_url()."forgot_password");
			}
		} else {
			$this->session->set_flashdata('error',"No User Found! Please Enter Your User ID Correctly!");
			redirect(base_url()."forgot_password");
		}
		//echo json_encode($ans);
	}


	private function GenLoginOTP($eto,$fullname)
	{				
			try
			{								
				$access_code = mt_rand(111111,999999); 
				$this->session->set_userdata('FEMSLOTP', $access_code);
				$UserLocalIP  = $this->session->userdata('UserLocalIP');
				//echo $UserLocalIP;
				
				// $eto = get_pre_email_id_per();
				// if(get_pre_email_id_off()!="") $eto .= ", ".get_pre_email_id_off();
				
				$subj="FEMS Client Login | One Time Password";
				
				$body="Dear $fullname, <br><br>
					   A forgot password request has been made from your FEMS Client Account.<br>
					   As an added level of security, you are requested to complete the process by entering the below 6 digit OTP.<br><br>";
					   
				$body .= "<div style='font-size: 20px;'> Your OTP : <b>$access_code </b></div>";
				$body .="<br>Please note: A new 6 digit OTP is generated each time a forgot password request made.";
				$body .="<br><b>The above OTP code is valid for only one hour.</b>";
				$body .="<br><br>Regards<br>FEMS	</br>";
				
				$ecc="";
				$user_id="";
				$this->Email_model->send_email_sox($user_id, $eto ,$ecc, $body, $subj, '', '', '', 'N');
				// sleep(1);
								
				$ret=true;
				
			}catch(Exception $e) {
				$ret=false;
			}
		
		return $ret;
	}

	public function otp(){
		$data["email_id"]=$this->session->userdata("email_id");
		$this->load->view('forgot_password_client/otp.php',$data);
	}

	public function verify_otp(){
		$email_id =$this->input->post('otp_fid');
		$otp =$this->input->post('otp');
		
		$currenTime = CurrMySqlDate();
		$sql = "SELECT * from forgot_password_otp WHERE '$currenTime' BETWEEN start_time AND end_time AND email_id = '$email_id' AND otp = '$otp' AND is_used = '0'";
		$query = $this->db->query($sql);
		
		$data = $query->num_rows();
		if($data > 0){			
			$updateArray = [ 'is_used' => 1 ];
			$this->db->where('otp', $otp);
			$this->db->where('email_id', $email_id);
			$this->db->update('forgot_password_otp', $updateArray);
			
			$this->session->set_flashdata('error',"Enter Your New Password");
			$this->session->set_userdata('email_id',$email_id);
			redirect(base_url()."forgot_password/update_password");
		} else {
			$this->session->set_flashdata('error',"OTP Mismatched");
			redirect(base_url()."forgot_password/otp");
		}
		echo json_encode($ans);
	}


	public function update_password(){
		$data["email_id"]=$this->session->userdata("email_id");
		$this->load->view('forgot_password_client/update_password.php',$data);
	}


	public function change_password(){

		$email_id = $this->input->post('fid');
		$password = $this->input->post('password');
		$curr_date = CurrMySqlDate();	
        $repassword = $this->input->post('repassword');
		
		 if($password!="" && $repassword!=""){
			
			if(strlen($password)>=8){
			
					 if($password==$repassword){
							
							// $password = md5($password);
							
							$_field_array = array(
								"is_logged_in" => 0,
								"passwd" => $password,
								"pswd_update_date" => $curr_date
							);
							
							$this->db->where("email_id",$email_id);
							$this->db->update("signin_client",$_field_array);
							$this->session->set_flashdata('error',"Password Updated Successfully");
							redirect(base_url()."clientlogin?psuccess");
					 }else{
					 		$this->session->set_flashdata('error',"Mismatch Password Or Confirm Password");
							redirect(base_url()."forgot_password/update_password");
					 }
			}else{
				$this->session->set_flashdata('error',"Password must be minimum 8 characters");
				redirect(base_url()."forgot_password/update_password");
			}
			 
		 }else{
			$this->session->set_flashdata('error',"Password Or Confirm Password is Blank");
			redirect(base_url()."forgot_password/update_password");
		 }
	}	

}
?>
