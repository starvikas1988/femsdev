<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH . "/libraries/IMap.php");

class Email_checkup extends CI_Controller{
	 
	var $emailMasters;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->library('excel');
		$this->load->helper('ld_programs_helper');
		$this->emailMasters = $this->master_config_all();
	}
	
	public function index()
	{
		redirect(base_url('email_checkup/master_email'));
	}
	
	//================== MASTER EMAILS ===========================================================// 	
	
	public function master_email()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$user_oth_office  = get_user_oth_office();
		$ses_dept_id    = get_dept_id();
		
		if($is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data['asideEmails'] = $this->emailMasters;
		
		$sql = "SELECT * from email_piping_mails_config";
		$data['category_list'] = $this->Common_model->get_query_result_array($sql);
		
		$data["aside_template"] = "email_piping/aside.php";
		$data["content_template"] = "email_piping/master_emails_config.php";
		//$data["content_js"] = "email_piping/email_piping_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function add_master_email()
	{
		if(check_logged_in())
		{						
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			$curDateTime      = CurrMySqlDate();
			
			$log = get_logs();						
			$edit_id  = trim($this->input->post('edit_id'));
			$email_name  = trim($this->input->post('email_name'));
			$email_id  = trim($this->input->post('email_id'));			
			$email_password = base64_encode($this->input->post('email_password'));			
			$email_type  = $this->input->post('email_type');			
			
			if($email_type == "outlook")
			{
				$protocol = "imap";
				$is_ssl = "/ssl";
				$is_cert = "/novalidate-cert";
				$path = "outlook.office365.com";
				$port = "993";
			}
			
			$field_array = array(
				"type"   => $email_type,
				"path"   => $path,
				"port" => $port,
				"email_name"   => $email_name,
				"email_id"   => $email_id,
				"password"   => $email_password,
				"protocol"   => $protocol,
				"is_ssl"   => $is_ssl,
				"is_cert"   => $is_cert,
				"logs" => get_logs()
			);
			
			if(empty($edit_id)){
				$field_array += [ "added_by" => $current_user ];
				$field_array += [ "date_added" => $curDateTime ];
				$insert_train = data_inserter('email_piping_mails_config',$field_array);	
			} else {
				$this->db->where('id', $edit_id);
				$this->db->update('email_piping_mails_config', $field_array);
			}			
								
		}		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	public function master_email_ajax()
	{
		if(check_logged_in())
		{						
			$category_id  = trim($this->input->get('eid'));
			$queryDetails = array();
			if(!empty($category_id)){
				$sqlDetails = "SELECT * from email_piping_mails_config WHERE id = '$category_id'";
				$queryDetails = $this->Common_model->get_query_row_array($sqlDetails);
			}
			echo json_encode($queryDetails);
		}
	}
	
	public function delete_master_email()
	{
		if(check_logged_in())
		{						
			$category_id  = trim($this->input->get('did'));
			$dataArray = [ 'is_active' => 0 ];
			$this->db->where('id', $category_id);
			//$this->db->update('email_piping_mails_config', $dataArray);
			$this->db->delete('email_piping_mails_config');
		}
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	
	
	//================== MASTER EMAILS CONFIG ===========================================================// 
	
	public function master_config_all()
	{
		$sql = "SELECT * from email_piping_mails_config";
		$config_all = $this->Common_model->get_query_result_array($sql);		
		return $config_all;
	}
	
	public function master_config($emailID = "")
	{
		$emailConfig = array();
		$emailConfig['path'] = "outlook.office365.com";
		$emailConfig['username'] = "sachin.paswan@omindtech.com";
		$emailConfig['password'] = "Fusion@1997";
		$emailConfig['protocol'] = "imap";
		$emailConfig['ssl'] = "/ssl";
		$emailConfig['cert'] = "/novalidate-cert";
		
		$emailConfig = array();
		if(!empty($emailID)){
			$sql = "SELECT * from email_piping_mails_config WHERE email_id = '$emailID'";
			$emailData = $this->Common_model->get_query_row_array($sql);
			if(!empty($emailData['id'])){
				$emailConfig['path'] = $emailData['path'];
				$emailConfig['username'] = $emailData['email_id'];
				$emailConfig['password'] = base64_decode($emailData['password']);
				$emailConfig['protocol'] = $emailData['protocol'];
				$emailConfig['ssl'] = $emailData['is_ssl'];
				$emailConfig['cert'] = $emailData['is_cert'];
			}
		}
		
		$emailConfig['search_text'] = "Support Ticket";
		$emailConfig['search_id'] = "## Ticket ID:";
		$emailConfig['search_reply'] = "## - REPLY ABOVE THIS LINE - ##";
		
		return $emailConfig;
	}
	
	
	public function view_mails() 
	{
		$enable_debug = 0;
		$debug = "";
		
		// GET EMAIL ID
		$u_emailID = "";
		if(!empty($this->uri->segment(3))){
			$u_emailID = $this->uri->segment(3);
			$u_emailID = hex2bin($u_emailID);			
		}
		$data['email_id'] = $u_emailID;
		
		// GET FOLDER
		$u_folder = "";
		if(!empty($this->uri->segment(4))){
			$u_folder = $this->uri->segment(4);
			$u_folder = str_replace("_", " ", $u_folder);
			if($u_folder == "ALL"){ $u_folder = ""; }
		}
		$data['email_folder'] = $u_folder;
		$data['email_folder_check'] = preg_replace('/\s+/', '_', $u_folder);
		
		// GET SEARCH
		$u_search_type = "";
		if(!empty($this->uri->segment(5))){
			$u_search_type = $this->uri->segment(5);
		}
		$data['eamil_type'] = $u_search_type;
		
		// GET EMAIL CONFIG
		$masterConfig = $this->master_config($u_emailID);
		$imapPath = $masterConfig['path'];
		$username = $masterConfig['username'];
		$password = $masterConfig['password'];
		$protocol = $masterConfig['protocol'];
		$ssl = $masterConfig['ssl'];
		$cert = $masterConfig['cert'];
		$host = $imapPath . "/" . $protocol . $ssl . $cert;
		
		// EMAIL CONNECTION
		$imap = new IMap("{" .$host. "}".$u_folder, $username, $password);
		$searchArray = array();
		if(!empty($u_search_type) && $u_search_type == "unseen"){
			$searchArray['unseen'] = 1;
		}
		$emails = $imap->search($searchArray);
		arsort($emails);
		//echo "<pre>".print_r($emails, 1)."</pre>"; die();
		
		// GET MAIL BOXES
		//$boxes = $imap->get_mailboxes($host);
		//echo "<pre>".print_r($boxes,1)."</pre>";die();
		
		
		// GET EMAILS
		$emailList = array();
		if($emails){
			$debug .="Count: " . count($emails);
			$cn=0;
			foreach($emails as $mail) {
				$cn++;								
				if($cn>30){ continue; }				
				$header = $imap->get_header_info($mail);
				$header->subject = mb_decode_mimeheader($header->subject);
				$body = "";
				/*
				$message = $imap->getmsg($mail);
				if(isset($message['htmlmsg']) && !empty($message['htmlmsg'])) {
					$body = $message['htmlmsg'];
				} elseif(isset($message['plainmsg']) && !empty($message['plainmsg'])) {
					$body = $message['plainmsg'];
				} else {
					$body = "";
				}
											
				if(isset($message['charset']) && $message['charset'] != "UTF-8") {
					$body = mb_convert_encoding($body, 'utf-8', $message['charset']);
				}
				*/
				
				// Ticket Variables	
				$title = $header->subject;
				$guest_email = $header->from;
					
				if(strstr($header->subject, $masterConfig['search_text']) !== false && ($u_folder == "INBOX")){					
					/*
					$pos = strpos($body, $masterConfig['search_id']);
					if($pos === false) {
						$debug .="Found new email. Creating ticket ...";
						$body = $imap->extract_gmail_message($body);
						$body = $imap->extract_outlook_message($body);
						$body = $this->strip_html_tags($body);
						$body = strip_tags($body, "<br><p>");
					}
					*/
					//$imap->move_to_folder($mail, 'Tickets');
										
				}
				
				$emailList[] = array(
					"subject" => $title,
					"guest" => $guest_email,
					"message" => $body,
					"ref" => $mail,
					"email" => $u_emailID,
				);
				
				if($enable_debug){
					echo "<hr/><h1>NEW EMAIL</h1><br/>";
					echo "<b>Subject : </b>" .$title ."<br/>";
					echo "<b>Guest :  </b>" .$guest_email ."<br/>";;
					echo "<b>Message :  </b><br/><hr/>" .$body;
					echo "<hr/><hr/>";
				}
				//echo "<pre>".print_r($message, 1)."</pre>";
			}
		}

		if($enable_debug) {
			echo "DEBUG OUTPUT: <br />";
			echo $debug;
		}
		
		$data['messageList'] = $emailList;
		
		$data['asideEmails'] = $this->emailMasters;
		$data["aside_template"] = "email_piping/aside.php";
		$data["content_template"] = "email_piping/view_mails.php";
		$data["content_js"] = "email_piping/email_piping_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function view_mails_message_details() 
	{
		$data['email_id'] = $email_id = hex2bin(trim($this->input->get('email')));
		$data['email_ref'] = $email_ref = trim($this->input->get('eid'));
		$data['email_folder'] = $email_folder = trim($this->input->get('efolder'));
		
		// GET EMAIL CONFIG
		$masterConfig = $this->master_config($email_id);
		$imapPath = $masterConfig['path'];
		$username = $masterConfig['username'];
		$password = $masterConfig['password'];
		$protocol = $masterConfig['protocol'];
		$ssl = $masterConfig['ssl'];
		$cert = $masterConfig['cert'];
		$host = $imapPath . "/" . $protocol . $ssl . $cert;
		
		// GET FOLDER
		$u_folder = "";
		if(!empty($email_folder)){
			$u_folder = $email_folder;
			$u_folder = str_replace("_", " ", $email_folder);
			if($u_folder == "ALL"){ $u_folder = ""; }
		}
		$data['email_folder'] = $u_folder;
		$data['email_folder_check'] = preg_replace('/\s+/', '_', $u_folder);
		
		// EMAIL CONNECTION
		$imap = new IMap("{" .$host. "}".$u_folder, $username, $password);
		
		// EMAIL DETAILS
		$header = $imap->get_header_info($email_ref);
		$message = $imap->getmsg($email_ref);
		
		if(isset($message['htmlmsg']) && !empty($message['htmlmsg'])){
			$body = $message['htmlmsg'];
		} elseif(isset($message['plainmsg']) && !empty($message['plainmsg'])){
			$body = $message['plainmsg'];
		} else {
			$body = "";
		}
		
		$header->subject = mb_decode_mimeheader($header->subject);				
		if($message['charset'] != "UTF-8") {
			$body = mb_convert_encoding($body, 'utf-8', $message['charset']);
		}
		
		$body = $imap->extract_gmail_message($body);
		$body = $imap->extract_outlook_message($body);

		$body = $this->strip_html_tags($body);
		$body = strip_tags($body, "<br><p>");
		
		$title = $header->subject;
		$guest_email = $header->from;
		
		$emailInfo = array(
			"subject" => $title,
			"guest" => $guest_email,
			"message" => $body,
			"ref" => $email_ref,
			"email" => $email_id,
		);		
		$data['emailDetails'] = $emailInfo;
		
		$this->load->view('email_piping/view_mails_message_details',$data);
		
	}
	
	
	private function strip_html_tags($str){
	    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
	    $str = preg_replace(
	        array(// Remove invisible content
	            '@<head[^>]*?>.*?</head>@siu',
	            '@<style[^>]*?>.*?</style>@siu',
	            '@<script[^>]*?.*?</script>@siu',
	            '@<noscript[^>]*?.*?</noscript>@siu',
	            ),
	        "", //replace above with nothing
	        $str );
	    
	    return $str;
	}
	
	
	
 }
 
 ?>