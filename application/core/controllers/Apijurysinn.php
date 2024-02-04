<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apijurysinn extends CI_Controller {
    
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
		$cip = getClientIP();
		
		$retArray['resp']="Failed";
		$retArray['details']="Invalid Input OR API URL";
		$retArray['cip']=$cip;
	
		echo json_encode($retArray);
		
		
	}
	
	
	public function putsearch()
    {
		$cip = getClientIP();
		$retArray=array();
		
		$form_data = $this->input->post();
		$fid = trim($this->input->post('fid'));
		
		if($fid==""){
			$fid=trim($this->input->get('fid'));
			$form_data = $this->input->get();
		}
		
		$qSql="SELECT id as value FROM signin where fusion_id='$fid'";
		$user_id = $this->Common_model->get_single_value($qSql);
		if($user_id !="" && $fid !=""){
			
			log_record($user_id,'putsearch','API JurysInn',$form_data,$cip);
			
			$qorg = trim($this->input->post('qorg'));
			if($qorg=="") $qorg=trim($this->input->get('qorg'));
			
			$qintent = $this->input->post('qintent');
			if($qintent=="") $qintent=trim($this->input->get('qintent'));
			
			$qintent = $this->input->post('qintent');
			if($qintent=="") $qintent=trim($this->input->get('qintent'));
			
			$answer = $this->input->post('answer');
			if($answer=="") $answer=trim($this->input->get('answer'));
			
			
			try{
									
				$_field_array = array(
					"fusion_id" => $fid,
					"question_org" => $qorg,
					"question_intent" => $qintent,
					"answer" => $answer
				); 
				
				$ret = data_inserter('jurysinn_search',$_field_array);
				if($ret!==false){		
					$retArray['resp']="Success";
					$retArray['dbid']=$ret;
				}else{
					$retArray['resp']="Error";
					$retArray['details']="Error to save data";
				}
				
				$logs= json_encode($_field_array);
				log_record($user_id,'putsearch','API JurysInn',$form_data,$logs);
				
			}catch (Exception $e) {
				$retArray['resp']="Error";
				$retArray['details']="Invalid Parameters. DB Error to save data. ". $e->getMessage();
			}
			
		}else{
			
			$retArray['resp']="Failed";
			$retArray['details']="Invalid Fusion ID";
						
		}
		
		echo json_encode($retArray);
	}
	
	
	public function putfeedback()
    {
		$cip = getClientIP();
		$retArray=array();
		
		$form_data = $this->input->post();
		$fid = trim($this->input->post('fid'));
		
		if($fid==""){
			$fid=trim($this->input->get('fid'));
			$form_data = $this->input->get();
		}
		
		$qSql="SELECT id as value FROM signin where fusion_id='$fid'";
		$user_id = $this->Common_model->get_single_value($qSql);
		if($user_id !="" && $fid !=""){
			
			log_record($user_id,'putfeedback','API JurysInn',$form_data,$cip);
			
			$qorg = trim($this->input->post('qorg'));
			if($qorg=="") $qorg=trim($this->input->get('qorg'));
			
			$qintent = $this->input->post('qintent');
			if($qintent=="") $qintent=trim($this->input->get('qintent'));
									
			$ans = $this->input->post('ans');
			if($ans=="") $ans=trim($this->input->get('ans'));
			
			$status = $this->input->post('status');
			if($status=="") $status=trim($this->input->get('status'));
			
			$comment = $this->input->post('comment');
			if($comment=="") $comment=trim($this->input->get('comment'));
			
			$promptreason = $this->input->post('promptreason');
			if($promptreason=="") $promptreason=trim($this->input->get('promptreason'));
			
					try{
						
						$_field_array = array(
							"fusion_id" => $fid,
							"question_org" => $qorg,
							"question_intent" => $qintent,
							"answer" => $ans,
							"feedback_status" => $status,
							"comment" => $comment,
							"prompt_reason" => $promptreason
							
						); 
						
						$ret = data_inserter('jurysinn_feedback',$_field_array);
						
						if($ret!==false){		
							$retArray['resp']="Success";
							$retArray['dbid']=$ret;
						}else{
							$retArray['resp']="Error";
							$retArray['details']="Error to save data";
						}
						
						$logs= json_encode($_field_array);
						log_record($user_id,'putfeedback','API JurysInn',$form_data,$logs);
						
					}catch (Exception $e) {
						$retArray['resp']="Error";
						$retArray['details']="Invalid Parameters. DB Error to save data. " . $e->getMessage();
					}	
		}else{
			
			$retArray['resp']="Failed";
			$retArray['details']="Invalid Fusion ID";
						
		}
		
		
		echo json_encode($retArray);
		
	}
	
	
	
	
}

?>