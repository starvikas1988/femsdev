<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apisearchuser extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('auth_model');
		
	 }
	
    public function index()
    {
        	
				$_run = false;  
								
				$fid = trim($this->input->post('fid'));
				$usr_id = trim($this->input->post('uid'));
				
				//$dbCnt=$this->Common_model->get_single_value("Select count(id) as value from signin where fusion_id='$fid' and id='$usr_id'");
				
				$dbCnt=$this->Common_model->get_single_value("Select count(id) as value from signin where fusion_id='$fid'");
				$retArray=array();
				$dbCnt=1;
				
				if($dbCnt==1)
				{
					$fname = trim($this->input->post('fname'));
					$lname = trim($this->input->post('lname'));
					
					if($fname!="" && $lname!="" )
					{		
							$qSql='select fusion_id,fname,lname,office_id,dept_id,role_id,doj,status,get_client_names(b.id) as client_name, get_process_names(b.id) as process_name, (Select shname from department d where d.id=b.dept_id) as dept_name, (Select name from role k  where k.id=b.role_id) as role_name  from signin b where fname like "%'.$fname.'%" and lname like "%'.$lname.'%" ';
							$res=$this->Common_model->get_query_result_array($qSql);
							$retArray['resp']="OK";
							$retArray['data']=$res;					
					}else{
						$retArray['resp']="Failed";
						$retArray['details']="Invalid Data";
					}
				}else{
					$retArray['resp']="Failed";
					$retArray['details']="Auth";
				}
		echo json_encode($retArray);
	}
}

?>