<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avon extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    private $aside = "avon/aside.php";
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		
	 }

	private function check_access()
	{
		if(get_global_access()!='1' && get_dept_folder() !="hr" && get_role_dir()!="super") redirect(base_url()."home","refresh");
	} 
	
    public function index()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			$qSql="SELECT * FROM master_av_enquiry_sla";
			$data['types'] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT * FROM master_av_enquiry_sla_natures";
			$data['natures'] = $this->Common_model->get_query_result_array($qSql);

			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon/index.php";
            $data["content_js"] = "avon_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}


	public function get_nature(){

		$id = $this->input->post('type');
		$qSql="SELECT id,nature FROM master_av_enquiry_sla_natures where sla_id=".$id."";
		$data = $this->Common_model->get_query_result_array($qSql);
		// print_r($data);
		// exit;

		echo json_encode($data);
	}

	public function request()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			$qSql="SELECT * FROM master_av_request_sla";
			$data['types'] = $this->Common_model->get_query_result_array($qSql);

			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon/request.php";
            $data["content_js"] = "avon_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}

	public function insert_enqry()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();
        	$error = "0";
        	$infos = $this->input->post();
        	// print_r($_FILES);
        	// print_r($infos);
        	// exit;
        	if(!empty($_FILES['file1']['name'])){
				$file_name = $this->upload_file($infos);
				if($file_name==""){
				$error = "1";
				}
			}

			if(!empty($_FILES['file2']['name'])){
				$file_name2 = $this->upload_file2($infos);
				if($file_name2==""){
				$error = "1";
				}
			}

			if($error!=1){
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			$source = trim($this->input->post('source_'));
			$type = trim($this->input->post('type_'));
			$nature = trim($this->input->post('nature'));
			$branch_cd = trim($this->input->post('branch_cd'));
			$name = trim($this->input->post('name'));
			$email = trim($this->input->post('email'));
			$ph_no = trim($this->input->post('ph_no'));
			$details = trim($this->input->post('details'));
			$notes = trim($this->input->post('notes'));
				
				$field_array = array(
					"source" => $source,
					"type_id" => $type,
					"nature_id" => $nature,
					"branch_code" => $branch_cd,
					"name" => $name,
					"email" => $email,
					"ph_no" => $ph_no,
					"details" => $details,
					"notes" => $notes,
					"file1" => $file_name,
					"file2" => $file_name2
				);

			$rowid= data_inserter('av_enquiry',$field_array);
			$response = array('error'=>'false');
					echo json_encode($response);
			}
			else
			{
				$response = array('error'=>'file_error');
				echo json_encode($response);
			}
		}
					
	}



	public function insert_request()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();
        	$error = "0";
        	$infos = $this->input->post();
        	// print_r($_FILES);
        	// print_r($infos);
        	// exit;
        	if(!empty($_FILES['file1']['name'])){
				$file_name = $this->upload_file($infos);
				if($file_name==""){
				$error = "1";
				}
			}

			if(!empty($_FILES['file2']['name'])){
				$file_name2 = $this->upload_file2($infos);
				if($file_name2==""){
				$error = "1";
				}
			}

			if($error!=1){
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
			$source = trim($this->input->post('source_'));
			$type = trim($this->input->post('type_'));
			$branch_cd = trim($this->input->post('branch_cd'));
			$name = trim($this->input->post('name'));
			$email = trim($this->input->post('email'));
			$ph_no = trim($this->input->post('ph_no'));
			$details = trim($this->input->post('details'));
			$notes = trim($this->input->post('notes'));
				
				$field_array = array(
					"source" => $source,
					"type_id" => $type,
					"branch_code" => $branch_cd,
					"name" => $name,
					"email" => $email,
					"ph_no" => $ph_no,
					"details" => $details,
					"notes" => $notes,
					"file1" => $file_name,
					"file2" => $file_name2
				);
				$rowid= data_inserter('av_request',$field_array);
				$response = array('error'=>'false');
				echo json_encode($response);
			}
			else
			{
				$response = array('error'=>'file_error');
				echo json_encode($response);
			}
		}
					
	}



	private function upload_file($infos)
	{
		// print_r($_FILES);
		// exit;
		$path       = $_FILES['file1']['name'];
	    $ext        = pathinfo($path, PATHINFO_EXTENSION);
		if(isset($infos['nature'])){
			$config['upload_path'] = './uploads/enquiry/';
			$config['file_name']      = $infos['name']."_enquiry1.".$ext;
		}else{
			$config['upload_path'] = './uploads/request/';
			$config['file_name']      = $infos['name']."_request1.".$ext;
		}

		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('file1'))
		{
			return "";
		}
		else
		{
			return $this->upload->data('file_name');
		}
	}


	private function upload_file2($infos)
	{
		// print_r($_FILES);
		// exit;
		$path       = $_FILES['file2']['name'];
	    $ext        = pathinfo($path, PATHINFO_EXTENSION);
		if(isset($infos['nature'])){
			$config['upload_path'] = './uploads/enquiry/';
			$config['file_name']      = $infos['name']."_enquiry2.".$ext;
		}else{
			$config['upload_path'] = './uploads/request/';
			$config['file_name']      = $infos['name']."_request2.".$ext;
		}
		
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('file2'))
		{
			return "";
		}
		else
		{
			return $this->upload->data('file_name');
		}
	}


	public function alter_table(){
		$qSql = "ALTER TABLE `av_sr_additional_credit_line_taho` DROP `created_on`";
		$this->db->query($qSql);
		$qSql = "ALTER TABLE `av_sr_suspension_sl_atp` ADD `created_on` DATETIME NOT NULL AFTER `created_by`";
		$this->db->query($qSql);
	}

	
	
}

?>