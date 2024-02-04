<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progression_email extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
	
	public function send_selection_email($location,$current_user,$eto)
	{
		$query = $this->db->query('SELECT * FROM `notification_info` WHERE office_id="'.$location.'" AND sch_for="REQUISITION_SELECT_MAIL"');
		$row = $query->row();
		echo $ebody = $row->email_body;
		return $this->send_email_sox($current_user,$eto,$row->cc_email_id,$ebody,$row->email_subject,"",$row->from_email,$row->from_name,"Y");
	}
	
	private function send_email_sox($uid,$eto,$ecc,$ebody,$esubject,$attch_file="",$from_email="noreply.fems@fusionbposervices.com",$from_name="Fusion FEMS", $isBcc="Y")
	{
		 
		$ebody .="<br/><br/><p style='font-size:9px'>Note: This is an automated system email, please do not reply.</p>";
		
		if(trim($from_email)=="")$from_email="noreply.fems@fusionbposervices.com";
		if(trim($from_name)=="")$from_name="Fusion FEMS";
		
		$esubject = " TEST " . $esubject;
		
		$eto = str_replace(';', ',', $eto);
		$ecc = str_replace(';', ',', $ecc);
				
		$this->load->library('email');
		
		$this->email->set_newline("\r\n");
		//$this->email->from('noreply.sox@fusionbposervices.com', 'Fusion SOX');
		$this->email->from($from_email, $from_name);
		
		$this->email->to($eto);
		
		if($ecc!="") $this->email->cc($ecc);
		
		//$this->email->bcc('kunal.bose@fusionbposervices.com, saikat.ray@fusionbposervices.com, manash.kundu@fusionbposervices.com, arif.anam@fusionbposervices.com, debkumar.dasgupta@fusionbposervices.com');
		
		if($isBcc=="Y") $this->email->bcc('manash.kundu@fusionbposervices.com, saikat.ray@fusionbposervices.com');
		
		$this->email->subject($esubject);
		$this->email->message($ebody);
		
		if($attch_file!="") $this->email->attach($attch_file);
		
		//-----------------------------------//
		$ebody=addslashes($ebody);
		$eto=addslashes($eto);
		$esubj=addslashes($esubject);
		
		$myCDate=CurrMySqlDate();
		
		$_insert_array = array(
				"email_to" => $eto,
				"subj" => $esubj,
				"body" => $ebody,
				"send_time"	=> $myCDate,
			);
			
		if($uid!="") $_insert_array['user_id']=$uid;
		if($ecc!="") $_insert_array['email_cc']=$ecc;
		if($attch_file!="") $_insert_array['attach_file']=$attch_file;
				
		$_table = "email_log";
		//-----------------------------------//
		
		if($eto!=""){
			if($this->email->send()){
				$_insert_array['is_send']="Y";
				$this->db->insert($_table,$_insert_array);
				return true;
				//echo 'Email sent.';
			}else{
				$_insert_array['is_send']="N";
				$this->db->insert($_table,$_insert_array);
				return false;
				//show_error($this->email->print_debugger());
			}
		}
	}
}