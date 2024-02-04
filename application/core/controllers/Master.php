<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE //
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	private $aside = "master/aside.php";
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Leave_model'); 		// Added by Lawrence Gandhar
	}
	
    public function index()
    {
        if(check_logged_in()){
			
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/master.php";
			$data["error"] = ''; 
			
			$this->load->view('dashboard',$data);
			
		}
    }

/////////////////// Process Master //////////////////////
	
	public function process()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "master/process.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
		//	if($srole_id<=1){			
            
				$qSql="SELECT a.id as pid,name,a.is_active,a.client_id,duration_training,duration_nest,shname as cname FROM `process` a, client b where a.client_id=b.id and b.is_active=1 order by a.client_id asc";
				$data['procrss_list'] = $this->Common_model->get_query_result_array($qSql);
				
        //     }else{
		//		$data['procrss_list'] = array();
		//	 }
			   
			   //$this->load->view('dashboard_ajax',$data);
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   


	public function addProcess()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$client_id = trim($this->input->post('client_id'));
			$name = trim($this->input->post('name'));
			$duration_training = trim($this->input->post('duration_training'));
			$duration_nest = trim($this->input->post('duration_nest'));
			$log=get_logs();
			
			if($client_id!="" && $name!="" && $duration_training!="" && $duration_nest!="" ){
				
				$field_array = array(
					"client_id" => $client_id,
					"name" => $name,
					"duration_training" => $duration_training,
					"duration_nest" => $duration_nest,
					"is_active" => '1',
					"log" => $log
				);
				
				$rowid= data_inserter('process',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateProcess()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$pid = trim($this->input->post('pid'));
			$client_id = trim($this->input->post('client_id'));
		
			$name = trim($this->input->post('name'));
			$duration_training = trim($this->input->post('duration_training'));
			$duration_nest = trim($this->input->post('duration_nest'));
			
			if($pid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"duration_training" => $duration_training,
					"duration_nest" => $duration_nest,
					"log" => $log
				); 
			
				$this->db->where('id', $pid);
				$this->db->update('process', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}

	 
	   
	public function processActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$pid = trim($this->input->post('pid'));
			$sid = trim($this->input->post('sid'));
			
			if($pid!=""){
				$this->db->where('id', $pid);
				$this->db->update('process', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	public function sub_process(){

			if(check_logged_in())
			{
				$this->check_access();
				
				$user_site_id= get_user_site_id();
				$srole_id= get_role_id();
				$current_user = get_user_id();
				
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "master/sub_process.php";
				$data["error"] = ''; 
				$data['srole_id']=$srole_id;
				
				$pid = trim($this->input->get('pid'));
				$data['pid'] = $pid;
				
				
			//	if($srole_id<=1){			
					$qSql="SELECT * from sub_process sp Where process_id='$pid'";
					$data['sub_procrss_list'] = $this->Common_model->get_query_result_array($qSql);
					
			//     }else{
			//		$data['sub_procrss_list'] = array();
			//	 }
				 
				 $qSql="select name as value from process where id='$pid'";
				 $data['process_name'] =$this->Common_model->get_single_value($qSql);
				 
				 
				 
				 $this->load->view('dashboard',$data);
									
				}                  
	}

	   
	public function addSubProcess()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$pid = trim($this->input->post('pid'));
			$name = trim($this->input->post('name'));
			$log=get_logs();
			
			if($pid!="" && $name!="" ){
				
				$field_array = array(
					"process_id" => $pid,
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				);
				
				$rowid= data_inserter('sub_process',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateSubProcess()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$spid = trim($this->input->post('spid'));
			$pid = trim($this->input->post('pid'));
		
			$name = trim($this->input->post('name'));
				
			if($spid!="" && $pid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $spid);
				$this->db->where('process_id', $pid);
				$this->db->update('sub_process', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}

	 
	   
	public function processSubActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$spid = trim($this->input->post('spid'));
			$sid = trim($this->input->post('sid'));
			
			if($spid!="" && $sid!=""){
				$this->db->where('id', $spid);
				$this->db->update('sub_process', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


//////////////////////// disposition //////////////////////////////////
   
	public function disposition()
	{
			if(check_logged_in())
			{
				$this->check_access();
				
				$user_site_id= get_user_site_id();
				$srole_id= get_role_id();
				$current_user = get_user_id();
				
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "master/disposition.php";
				$data["error"] = ''; 
				$data['srole_id']=$srole_id;
				
				//if($srole_id<=1){			
							 
					$qSql="SELECT  id,description,name,is_active FROM event_master order by id";
					$data['event_list'] = $this->Common_model->get_query_result_array($qSql);
									
				 //}else{
				//	$data['event_list'] = array();
				// }
				   
				   //$this->load->view('dashboard_ajax',$data);
				   $this->load->view('dashboard',$data);
									
				}                  
	   }
	   
	   
	public function addDisposition()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$description = trim($this->input->post('description'));
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($description!="" && $name!=""){
				
				$field_array = array(
					"description" => $description,
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('event_master',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateDisposition()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$did = trim($this->input->post('did'));
			$description = trim($this->input->post('description'));
			$name = trim($this->input->post('name'));
			
			
			if($did!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"description" => $description,
					"log" => $log
				); 
			
				$this->db->where('id', $did);
				$this->db->update('event_master', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

   
	public function dispositionActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$did = trim($this->input->post('did'));
			$sid = trim($this->input->post('sid'));
			
			if($did!=""){
				$this->db->where('id', $did);
				$this->db->update('event_master', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

////////////////////////////role ///////////////////////////////
      
    public function role()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "master/role.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;
			
			//if($srole_id<=1){			
            
				$qSql="SELECT  id,name,is_active,folder,org_role,(select name from role_organization where id=org_role)as org_name FROM role order by id";
				$data['role_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$SQLtxt =  "SELECT * FROM role_organization where is_active=1 order by id";
				$data['role_org'] = $this->Common_model->get_query_result_array($SQLtxt);
				
				
             //}else{
			//	$data['role_list'] = array();
			// }
			   
			   //$this->load->view('dashboard_ajax',$data);
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function addRole()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			$folder = trim($this->input->post('folder'));
			$role_org = trim($this->input->post('role_org'));
			
			$log=get_logs();
			
			if($name!="" && $folder!=""){
				
				$field_array = array(
					"name" => $name,
					"folder" => $folder,
					"org_role"=>$role_org,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('role',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateRole()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			$folder = trim($this->input->post('folder'));
			$role_org = trim($this->input->post('role_org'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"folder" => $folder,
					"org_role"=>$role_org,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('role', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function roleActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('role', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

///////////////////////////////////////////////////////////////
///////////////////// Client Master Section ///////////////////
///////////////////////////////////////////////////////////////


	public function client(){
		if(check_logged_in()){
			$this->check_access();
				
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/client.php";
			$data["error"] = ''; 
			$data['srole_id']=$srole_id;
			
			
			$qSql="SELECT * FROM client order by id";
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}


	public function addClient(){
		if(check_logged_in()){
			$this->check_access();
			$shname = trim($this->input->post('shname'));
			$fullname = trim($this->input->post('fullname'));
			$log=get_logs();
			
			if($shname!="" && $fullname!=""){
				
				$field_array = array(
					"shname" => $shname,
					"fullname" => $fullname,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('client',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	public function editClient(){
		if(check_logged_in()){
			$this->check_access();
			$cid = trim($this->input->post('cid'));
			$shname = trim($this->input->post('shname'));
			$fullname = trim($this->input->post('fullname'));
			$log=get_logs();
			
			if($cid!=""){
				$field_array = array(
					"shname" => $shname,
					"fullname" => $fullname,
					"log" => $log
				); 
				$this->db->where('id', $cid);
				$this->db->update('client', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


	public function clientActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$cid = trim($this->input->post('cid'));
			$sid = trim($this->input->post('sid'));
			
			if($cid!=""){
				$this->db->where('id', $cid);
				$this->db->update('client', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

//////////////////////////////////
 
 
	   private function check_access()
		{
			if(get_global_access()!='1' && get_dept_folder() !="hr" && get_role_dir()!="super") redirect(base_url()."home","refresh");
		}
		
		
///////////////////////////////////////////////////////////////
///////////////////// Client Master Section /////////////////////
///////////////////////////////////////////////////////////////		
		
		
	public function office(){
		if(check_logged_in()){
			$this->check_access();
				
			 $user_site_id= get_user_site_id();
			 $srole_id= get_role_id();
			 $current_user = get_user_id();
			
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/office.php";
			$data["error"] = ''; 
			$data['srole_id']=$srole_id;
			
			
			$qSql="SELECT * FROM office_location order by abbr";
			$data['office_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function check_is_exists($field){
		
		$SQLtxt ="SELECT abbr from office_location where abbr='".strtoupper($field)."'";
		$data['chk_exists'] = $this->Common_model->get_query_result_array($SQLtxt);
		
		if(!empty($data['chk_exists']) ){
			return FALSE;
		}else{
			return TRUE;
		}
		
	}
	
	
	public function addOffice(){
		if(check_logged_in()){
			$this->check_access();
			
			$abbr = trim($this->input->post('abbr_name'));
			$office = trim($this->input->post('office_name'));
			$location = trim($this->input->post('location'));
			$prov_period = trim($this->input->post('prov_period_day'));
			$resign_period = trim($this->input->post('resign_period_day'));
			
			
			$log=get_logs();
			
			
			if($this->check_is_exists($abbr)!= FALSE){
				echo "YES";
					if($abbr!="" && $office!="" && $location!="" && $prov_period!="" && $resign_period!=""){
						
						$field_array = array(
							"abbr" => $abbr,
							"office_name" => $office,
							"location"=>$location,
							"prov_period_day"=>$prov_period,
							"resign_period_day"=>$resign_period,
							"is_active" => '1',
							"log" => $log
						);
						$rowid= data_inserter('office_location',$field_array);
						$ans="done";
					}else{
						$ans="error";
					}
					echo $ans;
				
			}else{
				echo $ans="Already Exists";
			}
			
			
			
		}
	}
	
	
	public function editoffice(){
		if(check_logged_in()){
			$this->check_access();
			
			$abbr = trim($this->input->post('abbr_name'));
			$office = trim($this->input->post('office_name'));
			$location = trim($this->input->post('location'));
			$prov_period = trim($this->input->post('prov_period_day'));
			$resign_period = trim($this->input->post('resign_period_day'));
			
			$log=get_logs();
			
			if($abbr!=""){
				$field_array = array(
					"abbr" => $abbr,
					"office_name" => $office,
					"location"=>$location,
					"prov_period_day"=>$prov_period,
					"resign_period_day"=>$resign_period,
					"log" => $log
				); 
				$this->db->where('abbr', $abbr);
				$this->db->update('office_location', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	
	
	 
	
	public function OfficeActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$pid = trim($this->input->post('pid'));
			$sid = trim($this->input->post('sid'));
			
			if($pid!=""){
				$this->db->where('abbr', $pid);
				$this->db->update('office_location', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	

///////////////////////////////////////////////////////////////
///////////////// Department Master Section ///////////////////
///////////////////////////////////////////////////////////////
	
	public function department(){
		if(check_logged_in()){
			$this->check_access();
				
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/department.php";
			$data["error"] = ''; 
			
			$qSql="Select * from department ";
			$data['depatment_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function addDepartment(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$description = trim($this->input->post('description'));
			$shname = trim($this->input->post('shname'));
			$folder = trim($this->input->post('folder'));
			$log=get_logs();
			
			if($description!="" && $shname!=""){
				
				$field_array = array(
					"description" => $description,
					"shname" => $shname,
					"folder" => $folder,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('department',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/department");
		}
	}
	
	
	public function DepartmentActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$dept_id = trim($this->input->post('dept_id'));
			$sid = trim($this->input->post('sid'));
			
			if($dept_id!=""){
				$this->db->where('id', $dept_id);
				$this->db->update('department', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	public function editDepartment(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$dept_id = trim($this->input->post('dept_id'));
			$description = trim($this->input->post('description'));
			$shname = trim($this->input->post('shname'));
			$folder = trim($this->input->post('folder'));
			$log=get_logs();
			
			if($dept_id!=""){
				$field_array = array(
					"shname" => $shname,
					"description" => $description,
					"folder" => $folder,
					"log" => $log
				); 
				$this->db->where('id', $dept_id);
				$this->db->update('department', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/department");
		}
	}
	
/////////////////Sub Department Section/////////////////
///////////

	public function sub_department(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/sub_department.php";
			$data["error"] = ''; 
			
			$qSql="Select id, description from department where is_active=1";
			$data['dept_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select sd.*, (select description from department d where d.id=sd.dept_id) as dept_name from sub_department sd";
			$data['subdept_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function addSubDepartment(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$dept_id = trim($this->input->post('dept_id'));
			$name = trim($this->input->post('name'));
			$log=get_logs();
			
			if($dept_id!="" && $name!=""){
				
				$field_array = array(
					"dept_id" => $dept_id,
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('sub_department',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sub_department");
		}
	}
	
	
	public function subDepartmentActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$sd_id = trim($this->input->post('sd_id'));
			$sid = trim($this->input->post('sid'));
			
			if($sd_id!=""){
				$this->db->where('id', $sd_id);
				$this->db->update('sub_department', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	public function editSubDepartment(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$sd_id = trim($this->input->post('sd_id'));
			$dept_id = trim($this->input->post('dept_id'));
			$name = trim($this->input->post('name'));
			$log=get_logs();
			
			if($sd_id!=""){
				$field_array = array(
					"dept_id" => $dept_id,
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				); 
				$this->db->where('id', $sd_id);
				$this->db->update('sub_department', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sub_department");
		}
	}
	

/////////////////Site Section/////////////////
///////////

	public function site(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/site.php";
			$data["error"] = ''; 
			
			$qSql="Select * from site";
			$data['site_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}	
	
	
	public function addSite(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$name = trim($this->input->post('name'));
			$description = trim($this->input->post('description'));
			$timezone = trim($this->input->post('timezone'));
			$log=get_logs();
			
			if($name!="" && $description!=""){
				
				$field_array = array(
					"name" => $name,
					"description" => $description,
					"timezone" => $timezone,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('site',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/site");
		}
	}
	
	
	public function siteActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$site_id = trim($this->input->post('site_id'));
			$sid = trim($this->input->post('sid'));
			
			if($site_id!=""){
				$this->db->where('id', $site_id);
				$this->db->update('site', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	public function editSite(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$site_id = trim($this->input->post('site_id'));
			$name = trim($this->input->post('name'));
			$description = trim($this->input->post('description'));
			$timezone = trim($this->input->post('timezone'));
			$log=get_logs();
			
			if($site_id!=""){
				$field_array = array(
					"name" => $name,
					"description" => $description,
					"timezone" => $timezone,
					"is_active" => '1',
					"log" => $log
				); 
				$this->db->where('id', $site_id);
				$this->db->update('site', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/site");
		}
	}
	
	
////////////////////////////
	
///////////////////////////////////////////////////////////////
/////////////// Announcement Master Section ///////////////////
///////////////////////////////////////////////////////////////

	public function fems_announcement(){
		if(check_logged_in()){
			$this->check_access();
				
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/announcement.php";
			$data["error"] = ''; 
			
			$qSql="Select * from office_location where is_active=1";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM fems_announcement order by id";
			$data['announcement_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function addAnnouncement(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$description = trim($this->input->post('description'));
			$office_id = trim($this->input->post('office_id'));
			$added_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($description!="" && $office_id!=""){
				
				$field_array = array(
					"description" => $description,
					"office_id" => $office_id,
					"is_active" => '1',
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				);
				$rowid= data_inserter('fems_announcement',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/fems_announcement");
		}
	}
	
	
	public function editAnnouncement(){
		if(check_logged_in()){
			$this->check_access();
			$current_user = get_user_id();
			
			$al_id = trim($this->input->post('al_id'));
			$office_id = trim($this->input->post('office_id'));
			$description = trim($this->input->post('description'));
			$added_date = date("Y-m-d h:i:sa");			
			$log=get_logs();
			
			if($al_id!=""){
				$field_array = array(
					"office_id" => $office_id,
					"description"=>$description,
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				); 
				$this->db->where('id', $al_id);
				$this->db->update('fems_announcement', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/fems_announcement");
		}
	}
	
	
	public function AnnouncementActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$al_id = trim($this->input->post('al_id'));
			$sid = trim($this->input->post('sid'));
			
			if($al_id!=""){
				$this->db->where('id', $al_id);
				$this->db->update('fems_announcement', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	
///////////////////////////////////////////////////////////////
/////////////// Organization News Master Section //////////////
///////////////////////////////////////////////////////////////
	
	public function organization_news(){
		if(check_logged_in()){
			$this->check_access();
				
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "master/organization_news.php";
			$data["error"] = ''; 
			
			$qSql="Select * from office_location where is_active=1";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT *, DATE_FORMAT(publish_date, '%m/%d/%Y') as publishDate, DATE_FORMAT(closed_date, '%m/%d/%Y') as closedDate FROM organisation_news order by id";
			$data['org_news_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function addOrgNews(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$title = trim($this->input->post('title'));
			$publish_date = mmddyy2mysql(trim($this->input->post('publish_date')));
			$closed_date = mmddyy2mysql(trim($this->input->post('closed_date')));
			$description = trim($this->input->post('description'));
			$office_id = trim($this->input->post('office_id'));
			$log=get_logs();
			
			if($title!="" && $office_id!=""){
				
				$field_array = array(
					"description" => $description,
					"office_id" => $office_id,
					"title" => $title,
					"publish_date" => $publish_date,
					"closed_date" => $closed_date,
					"is_active" => '1',
					"added_by" => $current_user,
					"log" => $log
				);
				$rowid= data_inserter('organisation_news',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/organization_news");
		}
	}
	
	public function editOrgNews(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$on_id = trim($this->input->post('on_id'));
			$office_id = trim($this->input->post('office_id'));
			$description = trim($this->input->post('description'));			
			$title = trim($this->input->post('title'));			
			$publish_date = mmddyy2mysql(trim($this->input->post('publish_date')));			
			$closed_date = mmddyy2mysql(trim($this->input->post('closed_date')));			
			$log=get_logs();
			
			if($on_id!=""){
				$field_array = array(
					"office_id" => $office_id,
					"description"=>$description,
					"title" => $title,
					"publish_date" => $publish_date,
					"closed_date" => $closed_date,
					"added_by" => $current_user,
					"log" => $log
				); 
				$this->db->where('id', $on_id);
				$this->db->update('organisation_news', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/organization_news");
		}
	}
	
	
	public function orgNewsActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$on_id = trim($this->input->post('on_id'));
			$sid = trim($this->input->post('sid'));
			
			if($on_id!=""){
				$this->db->where('id', $on_id);
				$this->db->update('organisation_news', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

/*----------- SERVICE REQUEST(24.05.2019) ------------*/

//////////SR_Category//////////
/////
	public function sr_category(){
		if(check_logged_in()){
			$this->check_access();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/sr_category.php";
			$data["error"] = '';

			$qSql="Select * from office_location where is_active=1";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select *, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where status=1";
			$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select (select id from sr_category_tbl sct where sct.id=sct_id) as id,(select name from sr_category_tbl sct where sct.id=sct_id) as name,GROUP_CONCAT(office_id ORDER BY office_id ASC SEPARATOR ',') as location,is_active,log from sr_category_location_tbl GROUP BY sct_id";

			$data['sr_category_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function add_srCategory(){
		if(check_logged_in()){
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			$location = $this->input->post('location');
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"is_active" => 1,
					"log" => $log
				);
				$rowid= data_inserter('sr_category_tbl',$field_array);
				
				$cnt=count($location);

				for ($i=0; $i <$cnt ; $i++) { 
						
					$field_array1 = array(
					"sct_id" => $rowid,
					"office_id" => $location[$i],
					"is_active" => 1,
					"log" => $log
					);
				 	data_inserter('sr_category_location_tbl',$field_array1);

				}				

				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_category");
		}
	}
	
	public function edit_srCategory(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$c_id = trim($this->input->post('c_id'));
			$name = trim($this->input->post('name'));		
			$location = $this->input->post('location');		
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					"name" => $name,
					"is_active" => 1,
					"log" => $log
				); 
				$this->db->where('id', $c_id);
				$this->db->update('sr_category_tbl', $field_array);
					
				$cnt=count($location);
				$sqlTest="DELETE FROM sr_category_location_tbl WHERE sct_id=".$c_id."";
				$this->db->query($sqlTest);
				for ($i=0; $i <$cnt ; $i++) {
				$field_array1 = array(
					"sct_id" => $c_id,
					"office_id" => $location[$i],
					"is_active" => 1,
					"log" => $log
					);
				 	data_inserter('sr_category_location_tbl',$field_array1);
			}
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_category");
		}
	}
	
	
	public function srCategoryActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$c_id = trim($this->input->post('c_id'));
			$sid = trim($this->input->post('sid'));
			
			if($c_id!=""){
				$this->db->where('id', $c_id);
				$this->db->update('sr_category_tbl', array('is_active' => $sid));
				
				$this->db->where('sct_id', $c_id);
				$this->db->update('sr_category_location_tbl', array('is_active' => $sid));
				
				$this->db->where('cat_id', $c_id);
				$this->db->update('sr_category_pre_assign', array('is_active' => $sid));
				
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
/////////Category PreAssign////////////

	public function add_srCategoryPreassign(){
		if(check_logged_in()){
			$this->check_access();
			
			$c_id = $this->input->post('c_id');
			$office_id = $this->input->post('office_id');
			$user_id_array = $this->input->post('user_id');
			$log=get_logs();
			
			
			if($c_id!=""){
				
				foreach ($user_id_array as $value){
					$iProcessArr = array(
						"cat_id" => $c_id,
						"office_id" => $office_id,
						"user_id" => $value,
						"is_active" => 1
						//"log" => $log
					);
					$rowid= data_inserter('sr_category_pre_assign',$iProcessArr);
				}

			}
			redirect(base_url()."master/sr_category");
		}
	}

	public function manage_categoryPreassign($id){
		if(check_logged_in()){
			$this->check_access();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/manage_category_pre_assign.php";
			$data["error"] = '';
			
			
			$qSql="Select * from sr_category_tbl where is_active=1";
			$data['srcategory_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from office_location where is_active=1";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select *, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where status=1";
			$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select cpa.*, (select name from sr_category_tbl sct where sct.id=cpa.cat_id) as category_name, (select concat(fname, ' ', lname) as name from signin s where s.id=cpa.user_id) as user_name from sr_category_pre_assign cpa where cpa.cat_id='$id'";
			$data['categoryPreassign_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}	
	}
	
	
	public function edit_srCategoryPreassign(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$cp_id = trim($this->input->post('cp_id'));
			$cat_id = trim($this->input->post('cat_id'));			
			$office_id = trim($this->input->post('office_id'));
			$user_id = trim($this->input->post('user_id'));	
			$log=get_logs();
			
			if($cp_id!=""){
				$field_array = array(
					"cat_id" => $cat_id,
					"office_id" => $office_id,
					"user_id" => $user_id,
					"is_active" => 1,
					//"log" => $log
				); 
				$this->db->where('id', $cp_id);
				$this->db->update('sr_category_pre_assign', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/manage_categoryPreassign/$cat_id");
		}
	}
	
	
	public function srCategoryPreAssign(){
		if(check_logged_in()){
			$this->check_access();
			
			$cp_id = trim($this->input->post('cp_id'));
			$sid = trim($this->input->post('sid'));
			
			if($cp_id!=""){
				$this->db->where('id', $cp_id);
				$this->db->update('sr_category_pre_assign', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
//////////SR_Sub-Category//////////
/////
	public function sr_subcategory(){
		if(check_logged_in()){
			$this->check_access();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/sr_subcategory.php";
			$data["error"] = ''; 
			
			$qSql="Select * from sr_category_tbl where is_active=1";
			$data['srcategory_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from sr_category_sub_tbl where is_active=1";
			$data['srsubcategory_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from office_location where is_active=1";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select *, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where status=1";
			$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="Select scst.*,GROUP_CONCAT(scslt.office_id ORDER BY scslt.office_id ASC SEPARATOR ',') as location, (select name from sr_category_tbl sct where sct.id=scst.cat_id) as category_name from sr_category_sub_tbl scst inner join sr_category_sub_location_tbl scslt where scst.id=scslt.scst_id GROUP BY scslt.scst_id";
			$data['sr_subcategory_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function add_srSubCategory(){
		if(check_logged_in()){
			$this->check_access();
			
			$cat_id = trim($this->input->post('cat_id'));
			$name = trim($this->input->post('name'));
			$location = $this->input->post('location');
			$log=get_logs();
			
			if($cat_id!="" && $name!=""){
				
				$field_array = array(
					"cat_id" => $cat_id,
					"name" => $name,
					"is_active" => 1,
					"log" => $log
				);
				$rowid= data_inserter('sr_category_sub_tbl',$field_array);
				$cnt=count($location);

				for ($i=0; $i <$cnt ; $i++) {
				$field_array1 = array(
					"scst_id" => $rowid,
					"office_id" => $location[$i],
					"is_active" => 1,
					"log" => $log
					);
				data_inserter('sr_category_sub_location_tbl',$field_array1);

				}
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_subcategory");
		}
	}
	
	public function edit_srSubCategory(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$sc_id = trim($this->input->post('sc_id'));
			$cat_id = trim($this->input->post('cat_id'));		
			$name = trim($this->input->post('name'));	
			$location = $this->input->post('location');	
			$log=get_logs();
			
			if($sc_id!=""){
				$field_array = array(
					"cat_id" => $cat_id,
					"name" => $name,
					"is_active" => 1,
					"log" => $log
				); 
				$this->db->where('id', $sc_id);
				$this->db->update('sr_category_sub_tbl', $field_array);
				$cnt=count($location);
				$sqlTest="DELETE FROM sr_category_sub_location_tbl WHERE scst_id=".$sc_id."";
				$this->db->query($sqlTest);
				for ($i=0; $i <$cnt ; $i++) {
				$field_array1 = array(
					"scst_id" => $sc_id,
					"office_id" => $location[$i],
					"is_active" => 1,
					"log" => $log
					);
				data_inserter('sr_category_sub_location_tbl',$field_array1);

				}

				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_subcategory");
		}
	}
	
	
	public function srSubCategoryActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$sc_id = trim($this->input->post('sc_id'));
			$sid = trim($this->input->post('sid'));
			
			if($sc_id!=""){
				$this->db->where('id', $sc_id);
				$this->db->update('sr_category_sub_tbl', array('is_active' => $sid));
				$this->db->where('scst_id', $sc_id);
				$this->db->update('sr_category_sub_location_tbl', array('is_active' => $sid));
				
				$this->db->where('cat_sub_id', $sc_id);
				$this->db->update('sr_category_sub_pre_assign', array('is_active' => $sid));
				
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}	
	
///////////////////////////////////////////	
	
	public function add_srsubCategoryPreassign(){
		if(check_logged_in()){
			$this->check_access();
			
			$cat_id = trim($this->input->post('cat_id'));
			$cat_sub_id = trim($this->input->post('cat_sub_id'));
			$office_id = $this->input->post('office_id');
			$user_id_array = $this->input->post('user_id');
			$log=get_logs();
			
			if($cat_sub_id!="" && $cat_id!=""){
				
				foreach ($user_id_array as $value){
					$iProcessArr = array(
						"cat_sub_id" => $cat_sub_id,
						"office_id" => $office_id,
						"user_id" => $value,
						"is_active" => 1
						//"log" => $log
					);
					$rowid= data_inserter('sr_category_sub_pre_assign',$iProcessArr);

					//$this->check_previous_records_and_update($iProcessArr);

				}
			}
			redirect(base_url()."master/sr_subcategory");
		}
	}

	
	public function manage_subCategoryPreassign($id){
		if(check_logged_in()){
			$this->check_access();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/manage_subCategory_pre_assign.php";
			$data["error"] = '';
			
			
			$qSql="Select * from sr_category_tbl where is_active=1";
			$data['srcategory_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from sr_category_sub_tbl where is_active=1";
			$data['srsubcategory_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from office_location where is_active=1";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select *, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where status=1";
			$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="Select * from 
					(select cspa.*, (select name from sr_category_sub_tbl cst where cst.id=cspa.cat_sub_id) subcat_name, (select concat(fname, ' ', lname) as name from signin s where s.id=cspa.user_id) as user_name from sr_category_sub_pre_assign cspa where cspa.cat_sub_id='$id') xx 
					Left Join 
					(select cst.id as cst_id, cst.cat_id, (select name from sr_category_tbl ct where ct.id=cst.cat_id) as category_name from sr_category_sub_tbl cst where cst.is_active=1) yy 
					On (xx.cat_sub_id=yy.cst_id)";
				//echo $qSql;
			$data['subCategoryPreassign_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$this->load->view('dashboard',$data);
		}	
	}
	
	
	public function edit_srsubCategoryPreassign(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$scp_id = trim($this->input->post('scp_id'));
			$cat_sub_id = trim($this->input->post('cat_sub_id'));		
			$office_id = trim($this->input->post('office_id'));
			$user_id = trim($this->input->post('user_id'));	
			$log=get_logs();
			
			if($scp_id!=""){
				$field_array = array(
					"cat_sub_id" => $cat_sub_id,
					"office_id" => $office_id,
					"user_id" => $user_id,
					"is_active" => 1
					//"log" => $log
				); 
				$this->db->where('id', $scp_id);
				$this->db->update('sr_category_sub_pre_assign', $field_array);
			}
			redirect(base_url()."master/manage_subCategoryPreassign/$cat_sub_id");
		}
	}
	
	
	public function srsubCategoryPreAssign(){
		if(check_logged_in()){
			$this->check_access();
			
			$scp_id = trim($this->input->post('scp_id'));
			$sid = trim($this->input->post('sid'));
			
			if($scp_id!=""){
				$this->db->where('id', $scp_id);
				$this->db->update('sr_category_sub_pre_assign', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	
//////////SR_Priority//////////
/////
	public function sr_Priority(){
		if(check_logged_in()){
			$this->check_access();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/sr_priority.php";
			$data["error"] = ''; 
			
			
			$qSql="Select * from sr_priority_tbl";
			$data['sr_priority_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function add_srPriority(){
		if(check_logged_in()){
			$this->check_access();
			
			$priority_name = trim($this->input->post('priority_name'));
			$created_on = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($priority_name!=""){
				
				$field_array = array(
					"priority_name" => $priority_name,
					"created_on" => $created_on,
					"is_active" => 1,
					"log" => $log
				);
				$rowid= data_inserter('sr_priority_tbl',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_Priority");
		}
	}
	
	public function edit_srPriority(){
		if(check_logged_in()){
			$this->check_access();
			
			$pr_id = trim($this->input->post('pr_id'));
			$priority_name = trim($this->input->post('priority_name'));	
			$updated_on = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($pr_id!=""){
				$field_array = array(
					"priority_name" => $priority_name,
					"updated_on" => $updated_on,
					"is_active" => 1,
					"log" => $log
				); 
				$this->db->where('id', $pr_id);
				$this->db->update('sr_priority_tbl', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_Priority");
		}
	}
	
	
	public function srPriority(){
		if(check_logged_in()){
			$this->check_access();
			
			$pr_id = trim($this->input->post('pr_id'));
			$sid = trim($this->input->post('sid'));
			
			if($pr_id!=""){
				$this->db->where('id', $pr_id);
				$this->db->update('sr_priority_tbl', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


//////////SR_Status//////////
/////
	public function sr_Status(){
		if(check_logged_in()){
			$this->check_access();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/sr_status.php";
			$data["error"] = ''; 
			
			
			$qSql="Select * from sr_status_tbl";
			$data['sr_status_list'] = $this->Common_model->get_query_result_array($qSql);
				
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function add_srStatus(){
		if(check_logged_in()){
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"is_active" => 1,
					"log" => $log
				);
				$rowid= data_inserter('sr_status_tbl',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_Status");
		}
	}
	
	public function edit_srStatus(){
		if(check_logged_in()){
			$this->check_access();
			
			$st_id = trim($this->input->post('st_id'));
			$name = trim($this->input->post('name'));	
			$log=get_logs();
			
			if($st_id!=""){
				$field_array = array(
					"name" => $name,
					"is_active" => 1,
					"log" => $log
				); 
				$this->db->where('id', $st_id);
				$this->db->update('sr_status_tbl', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			redirect(base_url()."master/sr_Status");
		}
	}
	
	
	public function srStatus(){
		if(check_logged_in()){
			$this->check_access();
			
			$st_id = trim($this->input->post('st_id'));
			$sid = trim($this->input->post('sid'));
			
			if($st_id!=""){
				$this->db->where('id', $st_id);
				$this->db->update('sr_status_tbl', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////

//////////Assign Performance Metrics (30.05.2019)//////////
/////
	
	public function assign_performance_matrics(){
		if(check_logged_in()){
			$this->check_access();	
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/perf_matric_user_assign.php";
			$data["error"] = ''; 
			
			
			$qSql="Select * from pm_design where is_active=1 ";
			$data['pm_design_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="Select *, concat(fname, ' ', lname) as name from signin where status=1";
			$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
			
			//$qSql="Select pua.*, (select description from pm_design pd where pd.id=pua.did) as design_name, (select concat(fname, ' ', lname) as name from signin s where s.id=pua.user_id) as user_name from pm_upload_access pua ";
			
			$qSql="Select pua.*, (select office_id from pm_design pd where pd.id=pua.did) as office, (select description from pm_design pd where pd.id=pua.did) as design_name, (select concat(fname, ' ', lname) as name from signin s where s.id=pua.user_id) as user_name from pm_upload_access pua ";
			
			$data['assign_performance_metrics_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	public function add_pm_assign(){
		if(check_logged_in()){
			$this->check_access();
			
			$did = $this->input->post('did');
			$user_id_array = $this->input->post('user_id');
			$is_design_access = $this->input->post('is_design_access');
			$is_upload_access = $this->input->post('is_upload_access');
			$log=get_logs();
			
			if($did!=""){
				
				foreach ($user_id_array as $key => $value){
					$iProcessArr = array(
						"did" => $did,
						"user_id" => $value,
						"is_design_access" => $is_design_access,
						"is_upload_access" => $is_upload_access,
						"is_active" => 1,
						"log" => $log
					);
					$rowid= data_inserter('pm_upload_access',$iProcessArr);
				}
			}
			
			redirect(base_url()."master/assign_performance_matrics");
		}
	}
	
	
	public function edit_pm_assign(){
		if(check_logged_in()){
			$this->check_access();
			
			$pm_id = $this->input->post('pm_id');
			$did = $this->input->post('did');
			$user_id = $this->input->post('user_id');
			$log=get_logs();
			
			if($pm_id!=""){
				
				//foreach ($user_id_array as $key => $value){
					$iProcessArr = array(
						//"did" => $did,
						"user_id" => $user_id,
						"is_active" => 1,
						"log" => $log
					);
				
					$this->db->where('id', $pm_id);
					$this->db->update('pm_upload_access', $iProcessArr);
				
				//}
			}	
			redirect(base_url()."master/assign_performance_matrics");
		}
	}
	
	
	public function pmAssign(){
		if(check_logged_in()){
			$this->check_access();
			
			$pm_id = trim($this->input->post('pm_id'));
			$sid = trim($this->input->post('sid'));
			
			if($pm_id!=""){
				$this->db->where('id', $pm_id);
				$this->db->update('pm_upload_access', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////

//////////Fems Certification (13.06.2019)//////////
/////
	
	public function certification_questions_answers(){
		if(check_logged_in()){
			$this->check_access();	
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/certification_questions_answers.php";
			$data["error"] = ''; 
			
			$qSql="select id, question_name, is_active from train_fems_questions where is_active=1";
			$data['q_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from train_fems_questions";
			$data['certify_question_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$this->load->view('dashboard',$data);
		}
	}

	
	public function addQuestions(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$question_name = trim($this->input->post('question_name'));
			$log=get_logs();
			
			if($question_name!=""){
				
				$field_array = array(
					"question_name" => $question_name,
					"is_active" => 1,
					"added_by" => $current_user
					//"log" => $log
				);
				$rowid= data_inserter('train_fems_questions',$field_array);
			}
			redirect(base_url()."master/certification_questions_answers");
		}
	}
	
	public function editQuestions(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$q_id = trim($this->input->post('q_id'));		
			$question_name = trim($this->input->post('question_name'));		
			$log=get_logs();
			
			if($q_id!=""){
				$field_array = array(
					"question_name" => $question_name,
					"is_active" => 1
					//"log" => $log
				); 
				$this->db->where('id', $q_id);
				$this->db->update('train_fems_questions', $field_array);
			}
			redirect(base_url()."master/certification_questions_answers");
		}
	}
	
	
	public function questionsActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$q_id = trim($this->input->post('q_id'));
			$sid = trim($this->input->post('sid'));
			
			if($q_id!=""){
				$this->db->where('id', $q_id);
				$this->db->update('train_fems_questions', array('is_active' => $sid));
				
				$this->db->where('question_id', $q_id);
				$this->db->update('train_fems_answers', array('is_active' => $sid));
				
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}	
	
///////////////////////////////////////////	
	
	public function addAnswers(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$question_id = trim($this->input->post('question_id'));
			$answer = trim($this->input->post('answer'));
			$is_correct = trim($this->input->post('is_correct'));
			$log=get_logs();
			
			echo "Question No".$question_id;
			
			if($question_id!=""){
				
				$field_array = array(
					"question_id" => $question_id,
					"answer" => $answer,
					"is_correct" => $is_correct,
					"added_by" => $current_user,
					"is_active" => 1
					//"log" => $log
				);
				$rowid= data_inserter('train_fems_answers',$field_array);
			}
			redirect(base_url()."master/certification_questions_answers");
		}
	}

	
	public function certification_answers($qid){
		if(check_logged_in()){
			$this->check_access();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/certification_answers.php";
			$data["error"] = '';
			
			$qSql="select id, question_name, is_active from train_fems_questions where is_active=1";
			$data['q_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select *, (select question_name from train_fems_questions tq where tq.id=question_id) as ques_name from train_fems_answers where question_id='$qid'";
			$data['answers_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$this->load->view('dashboard',$data);
		}	
	}
	
	
	public function edit_answers(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$question_id = trim($this->input->post('question_id'));	
			$a_id = trim($this->input->post('a_id'));	
			$answer = trim($this->input->post('answer'));	
			$is_correct = trim($this->input->post('is_correct'));	
			$log=get_logs();
			
			if($a_id!=""){
				$field_array = array(
					"answer" => $answer,
					"is_correct" => $is_correct,
					"is_active" => 1
					//"log" => $log
				); 
				$this->db->where('id', $a_id);
				$this->db->update('train_fems_answers', $field_array);
			}
			redirect(base_url()."master/certification_answers/$question_id");
		}
	}
	
	
	public function answerActDeact(){
		if(check_logged_in()){
			$this->check_access();
			
			$a_id = trim($this->input->post('a_id'));
			$sid = trim($this->input->post('sid'));
			
			if($a_id!=""){
				$this->db->where('id', $a_id);
				$this->db->update('train_fems_answers', array('is_active' => $sid));				
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
/////////////////Open FEMS Certification/////////////////	
 	public function open_fusion_certification(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/open_fusion_certification.php";
			$data["error"] = '';
			
			$qSql="Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=user_id) as username from train_open_fems_certification";
			$data['user_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id, concat(fname, ' ', lname) as name from signin where status=1";
			$data['data_user'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from office_location where is_active=1";
			$data['user_location'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['set_style']= $this->session->flashdata('style');
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	
	public function addOpenFemsCerti(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$user_id = trim($this->input->post('user_id'));
			$log=get_logs();
			
			$SQltxt = "SELECT * FROM train_open_fems_certification WHERE user_id=". $user_id  ."";
			$data['is_recordExists'] = $this->Common_model->get_query_result_array($SQltxt);
			
			if(!count($data['is_recordExists']) > 0){
					if($user_id!=""){
					$field_array = array(
						"user_id" => $user_id,
						"added_by" => $current_user,
						"log" => $log
					);
					$rowid= data_inserter('train_open_fems_certification',$field_array);
				}
				$this->session->set_flashdata('style', '');
			}else{
				$this->session->set_flashdata('style', 'display:block');
				$this->session->set_flashdata('message', 'User already Assigned.');
			}
			redirect(base_url()."master/open_fusion_certification"); 
		}
	}
	
	
	public function editOpenFemsCerti(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$open_id = trim($this->input->post('open_id'));	
			$user_id = trim($this->input->post('user_id'));	
			
			if($open_id!=""){
				$field_array = array(
					"user_id" => $user_id
				); 
				$this->db->where('id', $open_id);
				$this->db->update('train_open_fems_certification', $field_array);
			}
			redirect(base_url()."master/open_fusion_certification");
		}
	}
	
	
///////////////////////////////////////////////////////////////////////
//////////Policy & Process Updates Manage Access (28.06.2019)//////////
///////////////////////////////////////////////////////////////////////

	public function manage_policy_access(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/policy_manage_access.php";
			$data["error"] = '';
			
			$qSql="Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=user_id) as username from policy_manage_access";
			$data['policy_manage_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select *, concat(fname, ' ', lname) as name, (select shname from department d where d.id=dept_id) as dept_name from signin where status=1";
			$data['data_user'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from office_location where is_active=1";
			$data['user_location'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function addManagePolicyAccess(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$user_id_array = $this->input->post('user_id');
			$log=get_logs();
			
			if($current_user!=""){
				foreach ($user_id_array as $key => $value){
					$field_array = array(
						"user_id" => $value,
						"added_by" => $current_user,
						"log" => $log
					);
					$rowid= data_inserter('policy_manage_access',$field_array);
				}
				
			}	
			
			redirect(base_url()."master/manage_policy_access");
		}
	}
	
	public function editManagePolicyAccess(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$access_id = trim($this->input->post('access_id'));	
			$user_id = trim($this->input->post('user_id'));	
			
			if($access_id!=""){
				$field_array = array(
					"user_id" => $user_id
				); 
				$this->db->where('id', $access_id);
				$this->db->update('policy_manage_access', $field_array);
			}
			redirect(base_url()."master/manage_policy_access");
		}
	}
	
////////////////////////

	public function manage_processupdate_access(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/processupdate_manage_access.php";
			$data["error"] = '';
			
			$qSql="Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=user_id) as username from process_update_manage_access";
			$data['processupdate_manage_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select *, concat(fname, ' ', lname) as name, (select shname from department d where d.id=dept_id) as dept_name from signin where status=1";
			$data['data_user'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from office_location where is_active=1";
			$data['user_location'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function addManageProcessupdateAccess(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$user_id_array = $this->input->post('user_id');
			$log=get_logs();
			
			if($current_user!=""){
				foreach ($user_id_array as $key => $value){
					$field_array = array(
						"user_id" => $value,
						"added_by" => $current_user,
						"log" => $log
					);
					$rowid= data_inserter('process_update_manage_access',$field_array);
				}
				
			}	
			
			redirect(base_url()."master/manage_processupdate_access");
		}
	}
	
	public function editManageProcessupdateAccess(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$pu_accessid = trim($this->input->post('pu_accessid'));	
			$user_id = trim($this->input->post('user_id'));	
			
			if($pu_accessid!=""){
				$field_array = array(
					"user_id" => $user_id
				); 
				$this->db->where('id', $pu_accessid);
				$this->db->update('process_update_manage_access', $field_array);
			}
			redirect(base_url()."master/manage_processupdate_access");
		}
	}
	
//////////////////////////////////////////	

	public function getsubcategory(){
		if(check_logged_in()){
			$cid=$this->input->post('cid');
			
			$qSql="Select * from sr_category_sub_tbl where cat_id='$cid' and is_active='1'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

	//=========================================================================
	// Section added by Lawrence Gandhar for leave portal
	// Date : 10th July 2019
	//

	public function leave_index(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/leave.php";
			$data["office_location"] = $this->Common_model->get_office_location_list();
			$data["leave_type_list"] = $this->Leave_model->leave_type_list();			
			$data["leave_criterias"] = $this->Leave_model->get_leave_criterias();

			$this->load->view('dashboard', $data);
		}
	} 

	public function add_leave_criteria(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$_field_array = array(
				"office_abbr" => $this->input->post("office_location"),
				"leave_type_id" => $this->input->post("leave_type"),
				"criteria" => $this->input->post("criteria"),
				"limit_per_month" => $this->input->post("limit_per_month"),
				"has_sub_category" => $this->input->post("has_sub_category"),
				"period_start" => $this->input->post("period_start"),
				"period_end" => $this->input->post("period_end"),
				"max_limit" => $this->input->post("max_limit"),
				"carry_forward" => $this->input->post("carry_forward"),
				"carry_forward_limit" => $this->input->post("carry_forward_limit"),
				"created_by" => $current_user,	
				"for_gender" => $this->input->post("for_gender"),		
				"for_dept" => $this->input->post("for_dept"),	
				"activate_after_days" => $this->input->post("activate_after_days"),		
				"show_in_dashboard" => $this->input->post("show_in_dashboard"),	
				"show_in_dropdown" => $this->input->post("show_in_dropdown"),	
				"show_after_days" => $this->input->post("show_after_days"),	
				"spl_leave" => $this->input->post("spl_leave")
			);

			$leave_criteria_id = data_inserter('leave_criteria',$_field_array);

			//===========================================================================
			// Auto assign to user
			//
			$location = $this->input->post("office_location");
			$for_gender = $this->input->post("for_gender");
			$activate_after_days = $this->input->post("activate_after_days");
			$for_dept = $this->input->post("for_dept");

			//$user_list = $this->Leave_model->assign_leave_criteria($leave_criteria_id, $location, $for_gender, $for_dept, $activate_after_days);

			redirect(base_url().'master/leave_index',"refresh");
		}
	}

	public function add_leave_type(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$_field_array = array(
				"abbr" => $this->input->post("abbr"),
				"description" => $this->input->post("full_form"),
				"created_by" => $current_user,
			);

			data_inserter('leave_type',$_field_array);
			redirect(base_url().'master/view_leave_types',"refresh");
		}
	}

	public function get_leave_criteria_data(){
		if(check_logged_in()){
			$this->check_access();

			if($this->input->post()){
				$row = $this->Leave_model->get_leave_criteria_data($this->input->post('id'));
				if($row !== false)	print(json_encode($row));
				else print 0;
			}
		}
	}

	public function edit_leave_criteria(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();
			
			$_field_array = array(
				"office_abbr" => $this->input->post("office_location"),
				"leave_type_id" => $this->input->post("leave_type"),
				"criteria" => $this->input->post("criteria"),
				"limit_per_month" => $this->input->post("limit_per_month"),
				"has_sub_category" => $this->input->post("has_sub_category"),
				"period_start" => $this->input->post("period_start"),
				"period_end" => $this->input->post("period_end"),
				"max_limit" => $this->input->post("max_limit"),
				"carry_forward" => $this->input->post("carry_forward"),
				"carry_forward_limit" => $this->input->post("carry_forward_limit"),
				"updated_on" => date("Y-m-d H:i:s"),
				"for_gender" => $this->input->post("for_gender"),	
				"for_dept" => $this->input->post("for_dept"),		
				"activate_after_days" => $this->input->post("activate_after_days"),
				"activate_after_days" => $this->input->post("activate_after_days"),		
				"show_in_dashboard" => $this->input->post("show_in_dashboard"),	
				"show_in_dropdown" => $this->input->post("show_in_dropdown"),	
				"show_after_days" => $this->input->post("show_after_days"),	
				"spl_leave" => $this->input->post("spl_leave"),
				"log" => get_logs()
			);

			$this->db->where('id', $this->input->post('id'));
			$this->db->update('leave_criteria', $_field_array);

			//$this->Leave_model->assign_leave_criteria($this->input->post('id'));
			
			redirect(base_url().'master/leave_index',"refresh");
		}
	}

	public function view_leave_types(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			$data["aside_template"] = $this->aside;
			$data["content_template"] = "master/manage_leave_types.php";
			$data["leave_type_list"] = $this->Leave_model->leave_type_list();
			$this->load->view('dashboard', $data);
		}
	}

	public function get_leave_type_data(){
		if(check_logged_in()){
			$this->check_access();
			
			if($this->input->post()){
				$row = $this->Leave_model->get_leave_type_data($this->input->post('id'));
				if($row !== false)	print(json_encode($row));
				else print 0;
			}
		}
	}

	public function edit_leave_type(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			if($this->input->post()){
				$_field_array = array(
					"abbr" => $this->input->post('abbr'),
					"description" => $this->input->post('full_form'),
					"updated_on" => date("Y-m-d H:i:s"),
					"log" => get_logs()
				);

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('leave_type', $_field_array);

				redirect(base_url().'master/view_leave_types',"refresh");
			}
		}
	}

	public function delete_leave_type(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			if($this->input->post()){
				$this->db->delete('leave_type', array('id'=>$this->input->post('id')));
				print 1;
			}
		}
	}

	public function delete_leave_criteria(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			if($this->input->post()){
				$this->db->query("update leave_criteria set status = 0 where id = ".$this->input->post('id'));
				$this->db->query("update leave_avl_emp set leave_access_allowed = 0, 
									leave_access_allowed_on = null, leave_access_denied_on = now()
									where leave_criteria_id =".$this->input->post('id'));
				print 1;
			}
		}
	}

	public function activate_leave_criteria(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			if($this->input->post()){
				$this->db->query("update leave_criteria set status = 1 where id = ".$this->input->post('id'));
				$this->db->query("update leave_avl_emp set leave_access_allowed = 1, 
									leave_access_allowed_on = now(), leave_access_denied_on = null
									where leave_criteria_id =".$this->input->post('id'));
				print 1;
			}
		}
	}

	function leave_criteria_sub_section($id = ''){
		if(check_logged_in()){

			if($id!=''){
				$this->check_access();
				$current_user=get_user_id();

				$data["aside_template"] = $this->aside;
				$data["content_template"] = "master/leave_criteria_sub_sections.php";
				$data["criteria_id"] = $id;
				$data["criteria_sub_sections"] = $this->Leave_model->get_leave_criteria_extra_config_data($id);
				
				if($this->input->post()){
					$criteria_id = $this->input->post('criteria_id');
					$description = $this->input->post('description');
					$deduction = $this->input->post('deduction');
	
					if($criteria_id!='' && $id == $criteria_id){
						$ret = count($description);

						if($ret > 0){
							for($i=0; $i<$ret; $i++){
								$_field_array = array(
									"leave_criteria_id" => $criteria_id,
									"description" => $description[$i],
									"deduction" => $deduction[$i]
								);
								
								data_inserter('leave_criteria_extra_config', $_field_array);								
							}
							redirect(base_url().'master/leave_criteria_sub_section/'.$id,"refresh");
						}					
					}
				}
				
				$this->load->view('dashboard', $data);
			}else{
				redirect(base_url().'master/leave_index',"refresh");
			}
		}
	}


	function get_leave_criteria_extra_config_data(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			$result = $this->Leave_model->get_leave_criteria_extra_config_data($this->input->post('id'));
			
			if(count($result) > 0){
				$html = '<form action="'.base_url().'master/save_leave_criteria_config" method="post">';
				$html .= '<table class="table table-responsive table-bordered">';				
				$html .= '<tr style="background-color:#eee; font-weight:bold; font-size:120%;"><td class="text-center">Full Form</td><td class="text-center">Deduction</td><td class="text-center" width="70px">Status</td><td class="text-center" width="61px">Action</td></tr>';

				foreach($result as $row){
					$html .= '<tr>'; 
					$html .= '<td style="line-height: 24px;"><input type="hidden" name="sub_category_id[]" value="'.$row->id.'">';
					$html .= '<input class="form-control" style="display:none" type="text" value="'.$row->description.'" name="description[]"><span>'.$row->description.'</span></td>';
					$html .= '<td style="line-height: 24px;"><input class="form-control" style="display:none" type="text" value="'.$row->deduction.'" name="deduction[]"><span>'.$row->deduction.'</span></td>';
					
					if($row->is_active == 1) $html .= '<td class="active-in-td text-center" style="line-height: 24px;"><span style="padding:2px 3px" class="bg-primary">Active</span></td>'; 
					else $html .= '<td class="active-in-td text-center" style="line-height: 24px;"><span style="padding:2px 3px" class="bg-danger">In-Active</span></td>';
					
					$html .= '<td>';
					$html .= '<button class="btn btn-success btn-xs" type="button" onclick="edit_leave_criteria_config($(this))"><i class="fa fa-pencil"></i></button>';

					if($row->is_active == 1){
						$html .= '<button title="Deactivate Sub-Section" class="btn btn-danger btn-xs button-deactive" type="button" onclick="deactivate_leave_criteria_config($(this),'.$row->id.')" style="margin-left:3px;"><i class="fa fa-times"></i></button>';
						$html .= '<button title="Activate Sub-Section" class="btn btn-primary btn-xs button-active" type="button" onclick="activate_leave_criteria_config($(this),'.$row->id.')" style="margin-left:3px; display:none"><i class="fa fa-check"></i></button>';
					}else{
						$html .= '<button title="Deactivate Sub-Section" class="btn btn-danger btn-xs button-deactive" type="button" onclick="deactivate_leave_criteria_config($(this),'.$row->id.')" style="margin-left:3px; display:none"><i class="fa fa-times"></i></button>';
						$html .= '<button title="Activate Sub-Section" class="btn btn-primary btn-xs button-active" type="button" onclick="activate_leave_criteria_config($(this),'.$row->id.')" style="margin-left:3px;"><i class="fa fa-check"></i></button>';
					}
					
					$html .= '</td>';
					$html .='</tr>';
				}
				$html .= '<tr><td colspan="4" class="text-center">'; 
				$html .= '<button type="submit" class="btn btn-success btn-xs button-save" disabled>Save</button>';
				$html .= '</td></tr>'; 
				$html .= '</table>';			
				$html .= '</form><hr/>';
			}else $html = '';				
			print $html;
		}
	}

	function save_leave_criteria_config(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			if($this->input->post()){
				$sub_category_id = $this->input->post('sub_category_id');
				$description = $this->input->post('description');
				$deduction = $this->input->post('deduction');

				$ret = count($sub_category_id);

				for($i = 0; $i < $ret; $i++){

					$_field_array = array(
						"description" => $description[$i],
						"deduction" => $deduction[$i]
					);

					$this->db->where('id', $sub_category_id[$i]);
					$this->db->update('leave_criteria_sub_category', $_field_array);
				}
			}
			redirect(base_url()."master/leave_index");
		}
	}

	function deactivate_leave_criteria_config(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			if($this->input->post()){
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('leave_criteria_sub_category', array("is_active"=>0));
			}
			print 1;
		}
	}

	function activate_leave_criteria_config(){
		if(check_logged_in()){
			$this->check_access();
			$current_user=get_user_id();

			if($this->input->post()){
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('leave_criteria_sub_category', array("is_active"=>1));
			}
			print 1;
		}
	}

	public function leave_user_management()
    {
        if(check_logged_in()){
									
			$is_global_access = get_global_access();
			$current_user = get_user_id();
			
			if($is_global_access){

				$data["aside_template"] = $this->aside;
				$data["content_template"] = "master/leave_user_assignment.php";

				$data["get_office_location_list"] = $this->Common_model->get_office_location_list();
				$data["get_department_list"] = $this->Common_model->get_department_list();
				
				$data["users_list"] = array();
				$data["get_leave_criterias_location_based"] = array();

				if($this->input->get()){
					$location = $this->input->get('location');
					$department = $this->input->get('department');
					$sub_department = $this->input->get('sub_department');

					$users_list = $this->Leave_model->user_lists($location, $department, $sub_department);
					$data["get_leave_criterias_location_based"] = $this->Leave_model->get_leave_criterias_for_location($location);

					$dict = array();

					foreach($users_list as $user){
						$arr = array(
							"user_id" => $user->id,
							"xpoid" => strtoupper($user->xpoid),
							"location" => $user->office_id,
							"name" => strtoupper($user->fname." ".$user->lname),
							"gender" => $user->sex,
							"dept" => strtoupper($user->department_name),
							"sub_dept" => strtoupper($user->sub_department_name),
							"leave_criteria" => array()
						);
						
						$get_leaves_access_for_employee = $this->Leave_model->get_leaves_access_for_employee($user->id);

						$get_leave_criterias_location_based = array();
						foreach($data["get_leave_criterias_location_based"] as $item){
							$get_leave_criterias_location_based[$item->l_criteria_id] = 0;
						}						
						
						$arr["leave_criteria"] = $get_leave_criterias_location_based; 
						
						if(count($get_leaves_access_for_employee) > 0){
							foreach($get_leaves_access_for_employee as $item){
								$arr["leave_criteria"][$item->leave_criteria_id] = $item->leave_access_allowed;
							}
						}

						$dict[] = $arr;
					}

					$data["users_list"] = $dict;										
				}			
			}

			$this->load->view('dashboard',$data);
			
		}
	}
	
	//=======================================================================================
	//	GET SUB-DEPARTMENT LIST
	//=======================================================================================

	public function get_sub_department_list(){
		if(check_logged_in() && $this->input->post()){
			$dep_id = $this->input->post('id');
			$subs = $this->Leave_model->get_sub_departments($dep_id);

			$html = "";
			foreach($subs as $item){
				$html .= "<option value=".$item->id.">".$item->name."</option>";
			}
			print $html;
		}
	}

	//=======================================================================================
	//	GRANT LEAVE ACCESS
	//=======================================================================================

	public function get_grant_leave_access_details(){
		if(check_logged_in() && $this->input->post()){
			$user_id = $this->input->post('user_id');
			print json_encode($this->Leave_model->leave_avl_emp_details($user_id));
		}
	}

	public function grant_leave_access(){
		if(check_logged_in() && $this->input->post()){

			$leave_criteria = $this->input->post('leave_criteria');
			$select = "select_";
			$record = "record_";

			$user_id = $this->input->post('user_id');
			$query_str = $this->input->post('query_str');

			foreach($leave_criteria as $id){
				$select_var = $select.$id;
				$record_var = $record.$id;

				$$select_var = $this->input->post($select_var);
				$$record_var = $this->input->post($record_var);

				if($$record_var != ""){

					$_field_data = array(
						"leave_access_allowed" => $$select_var,
						"leave_access_allowed_on" => "NULL",
						"leave_access_denied_on" => "NULL"
					);

					if($$select_var == "0") $_field_data["leave_access_denied_on"] = date("Y-m-d H:i:s");
					else $_field_data["leave_access_allowed_on"] = date("Y-m-d H:i:s");

					$this->db->where('id', $$record_var);
					$this->db->update('leave_avl_emp', $_field_data);
				}else{
					$_field_data = array(
						"user_id" => $user_id,
						"leave_criteria_id" => $id,	
						"leave_access_allowed" => $$select_var,					
					);
					if($$select_var == "0") $_field_data["leave_access_denied_on"] = date("Y-m-d H:i:s");
					else $_field_data["leave_access_allowed_on"] = date("Y-m-d H:i:s");

					data_inserter('leave_avl_emp', $_field_data);
				}
			}
			redirect(base_url()."master/leave_user_management".$query_str, "refresh");
		}
	}


	public function operation_leave_access_to_selected(){
		if(check_logged_in() && $this->input->post()){
			$user_ids = $this->input->post('user_ids');
			$query_str = $this->input->post('query_str');
			$operation_type = $this->input->post('operation_type');

			foreach($user_ids as $user_id){
				$l_c_ids = $this->Leave_model->get_leave_criterias_based_on_user_location($user_id);
				$records = $this->Leave_model->leave_avl_emp_details($user_id);

				$_update_recs = array();

				// Update Records
				foreach($records as $record){
					$_update_recs[] = $record->leave_criteria_id;

					$_field_data = array(
						"leave_access_allowed" => 1,
						"leave_access_allowed_on" => date("Y-m-d H:i:s"),
						"leave_access_denied_on" => "NULL"
					);

					if($operation_type == '0'){
						$_field_data["leave_access_allowed"] = 0;
						$_field_data["leave_access_allowed_on"] = "NULL";
						$_field_data["leave_access_denied_on"] = date("Y-m-d H:i:s");
					}

					$this->db->where('id', $record->id);
					$this->db->update('leave_avl_emp', $_field_data);
				}

				// Insert Records
				foreach($l_c_ids as $l_c_id){
					if(!in_array($l_c_id->id, $_update_recs)){
						$_field_data = array(
							"user_id" => $user_id,
							"leave_criteria_id" => $l_c_id->id,
							"leave_access_allowed" => 1,
							"leave_access_allowed_on" => date("Y-m-d H:i:s"),
							"leave_access_denied_on" => "NULL"
						);

						if($operation_type == '0'){
							$_field_data["leave_access_allowed"] = 0;
							$_field_data["leave_access_allowed_on"] = "NULL";
							$_field_data["leave_access_denied_on"] = date("Y-m-d H:i:s");
						}
						
						data_inserter('leave_avl_emp', $_field_data);
					}
				}					
			}
			return redirect(base_url()."master/leave_user_management".$query_str, "refresh");		
		}
	}

	



	//Section End : Lawrence Gandhar
	//=============================================================================

	
}

?>