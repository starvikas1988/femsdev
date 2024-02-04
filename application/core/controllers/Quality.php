<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quality extends CI_Controller {

    private $aside = "qa/aside.php";
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
	 }
	 
	public function index()
	{
					
		$client_id=get_client_ids();
		$process_id=get_process_ids();
		

		$currrentUser = get_user_id();
		$surveyCheck = "SELECT count(*) as value from survey_qa WHERE agent_id = '$currrentUser'";
		$queryCheck = $this->Common_model->get_single_value($surveyCheck);
		if($queryCheck < 1){
			redirect('survey/qa', 'refresh');
		}
		
		redirect('Qa_dashboard', 'refresh');
		
		/*
		if(get_dept_folder() == 'qa' || get_global_access() == 1 || get_role_dir() == 'manager' || get_role_dir() == 'admin' || is_access_qa_module()==true ){
			
			redirect('qa_graph/manager_level', 'refresh');
		} 
		else if(get_role_dir() == 'tl' && get_dept_folder() != 'qa'){
			
			redirect('qa_graph/tl_level', 'refresh');
			
		} 
		else if(get_role_dir() == 'agent'){
			
			redirect('qa_graph/agent_level', 'refresh');
			
		} else {
			
			redirect('qa_graph/agent_level', 'refresh');
		}
		*/
		
		/*
		$qSql="Select qa_agent_url as value from process where client_id='$client_id' and id in ($process_id) limit 1";
		$agentUrl= $this->Common_model->get_single_value($qSql);
		
		if(is_access_qa_module()==true || is_access_qa_operations_module()==true) redirect('Qa_dashboard', 'refresh');
		else if(is_access_qa_agent_module()==true) redirect($agentUrl, 'refresh');
		*/
	}
	
	
}