<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payslip extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE //
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	private $aside = "payslip/payslip_aside.php";
	
	 public function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Email_model');
		
	 }
	 
	 
	public function index()
	{
		if(check_logged_in())
		{
			
			
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			$ses_office_id=get_user_office_id();
			$filter_id=$this->uri->segment(2);
			$ses_office_id=get_user_office_id();
			
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "payslip/payslip_view.php";
			$data["error"] = ''; 
			
			$data['records'] =  $this->fetch_payslip();
									
			///inc_letters OYO SIG
			
			$latDir="/opt/lampp/htdocs/femsdev/payslip";
			
			$data['latFileName'] = "";
			$allFile = array();
			
			$this->getDirContents($latDir, $allFile);
			$i=0;
			
			for($i=0;$i<count($allFile);$i++){
				$filename =  basename($allFile[$i]);				
				$curUserArr = $this->fetch_xpoid_id($filename);
				
				if($curUserArr != NULL){
					$data['latFileName'] = $filename;
					break;
				}
			}
			$qSql = "Select email_id_per as value from info_personal where user_id = '$current_user'";
			$data['email_id_per'] = $this->Common_model->get_single_value($qSql);
			
			$this->load->view('dashboard',$data);	
		}	
	}
	
	
	private function fetch_payslip(){
		$current_user = get_user_id();
		
		$SQLtxt  = "SELECT * FROM payslip  where user_id = ". $current_user ." order by id desc ";
		$fields  = $this->db->query($SQLtxt);
		
		if($fields->num_rows()> 0){
			return $fields->result();
		}else{
			return FALSE;
		}	
	}
	
	
	public function send(){
		
		$current_user = get_user_id();
		
		$filename = trim($this->input->post('filename'));
		$email_to = trim($this->input->post('email_to'));
		$filename = base64_decode(urldecode($filename));
		
		$SQLtxt  = "SELECT * FROM payslip  where file_name = '". trim($filename)."'";
		$fields  = $this->db->query($SQLtxt);
		if($fields->num_rows() > 0){
			$rows = $fields->result();
			
			$date_stamp = $rows[0]->pay_desc;
						
			$filePath = $this->config->item('PayslipSavePath')."/".$rows[0]->file_name;
			
			$ebody="Please find the payslip of ".$date_stamp;
			$esubject = "Your Payslip of ".$date_stamp;
			$ret = $this->Email_model->send_email_sox($current_user, $email_to, "", $ebody,$esubject,$filePath,"","", "N");
			
			if($ret==true) echo "Your payslip has been sent successfully.";
			else echo "Error to sent Email";
			
		}else{
			echo "File Not Found";	
		}	
	}

	
	public	function getDirContents($dir, &$results = array()){
			$files = scandir($dir);

			foreach($files as $key => $value){
				$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
				if(!is_dir($path)) {
					$results[] = $value;
				} else if($value != "." && $value != "..") {
					$this->getDirContents($path, $results);
					//$results[] = $path;
				}
		}

		return $results;
	}
	
	
	public function fetch_xpoid_id($filename){
		
		$current_user = get_user_id();
		$file_id = substr( $filename, 0 , strpos($filename, "."));
						
		$SQLtxt ="SELECT * FROM  signin where id = '".$current_user."' and xpoid='". trim($file_id) ."' and status = 1";		
		$fields  = $this->db->query($SQLtxt);
		if($fields->num_rows() > 0){
			return  $fields->result();
		}else{
			return NULL;
		}
	}
	
	public function check_download($file_name,$view=''){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$file_id = base64_decode(urldecode($file_name));
			
			$SQLtxt  = "SELECT * FROM payslip  where file_name = '". trim($file_id)."'";
			$fields  = $this->db->query($SQLtxt);
			
			if($fields->num_rows() > 0){
				
				$rows = $fields->result();				
				if($rows[0]->user_id == $current_user){
					
				//echo $link = base_url().'user_payslip/'. $rows[0]->file_name;

				$file = $this->config->item('PayslipSavePath')."/".$rows[0]->file_name;
			 
				if(file_exists($file) && ($view != true || $view =='')) {
						header('Content-type: application/pdf');
						header('Content-Disposition: attachment; filename="'.basename($file).'"');
						readfile($file);
				}elseif(file_exists($file) && $view == true ) {
						header("Content-type: application/pdf");
						header('Content-Disposition: inline; filename="'.basename($file).'"');
						@readfile($file);
				}
			 }else{
				 echo "You are trying to view other payslip.<br/> Donot try again. Otherwise Your FEMS Account Will be blocked";
			 }
			}else{
				 echo "You are trying to view other payslip.<br/> Donot try again.";
			}
		}
	}
	
	
	
		
	public function checklatDownload($file_name,$view=''){
		
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$file_id = base64_decode(urldecode($file_name));
			
			
			$latDir="/opt/lampp/htdocs/femsdev/payslip";
			
			$file = $latDir."/".$file_id;
			
			echo $file;
			
			if(file_exists($file) && ($view != true || $view =='')) {
					header('Content-type: application/pdf');
					header('Content-Disposition: attachment; filename="'.basename($file).'"');
					readfile($file);
			}elseif(file_exists($file) && $view == true ) {
					header("Content-type: application/pdf");
					header('Content-Disposition: inline; filename="'.basename($file).'"');
					@readfile($file);
			}else{
				
				echo "file not found";
			}
				
		}
	}
	
		 
	 
}
?>	 