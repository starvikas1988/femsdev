<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_center extends CI_Controller {

    private $aside = "reports/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Dfr_model');
		
		$this->objPHPExcel = new PHPExcel();
		
	}
	
	public function get_results()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		//print_r($form_data);
		$query = array();
		if($form_data['location'] != '')
		{
			$query[] = 'WHERE reporting_center.location_id = "'.$form_data['location'].'"';
		}
		if($form_data['department_id'] != '' && $form_data['department_id'] != '0' )
		{
				$query[] = '(reporting_center.dept_id = "'.$form_data['department_id'].'" OR reporting_center.dept_id = 0 )';
			
		}
		if($form_data['client_id'] != '' && $form_data['client_id'] != '0' )
		{
				$query[] = '(reporting_center.client_id = "'.$form_data['client_id'].'" OR reporting_center.client_id = 0)';
			
		}
		if($form_data['process_id'] != '' && $form_data['process_id'] != '0' )
		{
				$query[] = '(reporting_center.process_id = "'.$form_data['process_id'].'" OR reporting_center.process_id = 0)';
			
		}
		
		$query = $this->db->query('SELECT MD5(CONCAT(reporting_center.id,"","'.$current_user.'")) as i, reporting_center.*,department.shname AS department_name,client.shname AS client_name,process.name AS process_name FROM `reporting_center` LEFT JOIN department ON department.id=reporting_center.dept_id LEFT JOIN client ON client.id=reporting_center.client_id LEFT JOIN process ON process.id=reporting_center.process_id '.implode(" AND ",$query).'');
		if($query->num_rows() > 0)
		{
			$response['stat'] = true;
			$response['data'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	 
    public function index()
    {
				
        if(check_logged_in())
        {
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$client_id = get_client_ids();
			$process_id = get_process_ids();
			
			
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
				
			$data['ses_dept_id']=$ses_dept_id;
			$data['user_office_id']=$user_office_id;
			$data['client_id']=$client_id;
			$data['process_id']=$process_id;
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data["get_department_data"] = $this->Common_model->get_department_list();
			$data['client_list'] = $this->Common_model->get_client_list();
				
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "report_center/aside.php";
			
			if (get_role_dir() == "agent")
			{
				$query = $this->db->query('SELECT MD5(CONCAT(reporting_center.id,"","'.$current_user.'")) as i,reporting_center.*,department.shname AS department_name,client.shname AS client_name,process.name AS process_name FROM `reporting_center` LEFT JOIN department ON department.id=reporting_center.dept_id LEFT JOIN client ON client.id=reporting_center.client_id LEFT JOIN process ON process.id=reporting_center.process_id WHERE reporting_center.location_id = "'.$user_office_id.'" AND (reporting_center.dept_id IN('.$ses_dept_id.') OR reporting_center.dept_id = 0 ) AND (reporting_center.client_id IN('.$client_id.') OR reporting_center.client_id = 0) AND (reporting_center.process_id IN('.$process_id.') OR reporting_center.process_id = 0)');
				$data["infos"] = $query->result_object();
				$data["content_template"] = "report_center/report_center_agent.php";
			}
			else
			{
				
				
				
				$data["content_template"] = "report_center/report_center.php";
			}
			
			
			$this->load->view('dashboard',$data);
			
        }
    }
	
	public function process_upload_report_form()
    {
        if(check_logged_in())
        {
			$form_data = $this->input->post();
			$response = $this->do_upload($form_data['location']);
			if($response['stat'] == true)
			{
				$field_array['title']=$form_data['title'];
				$field_array['added_by']=get_user_id();
				$field_array['added_date']=date("Y-m-d H:i:s");
				$field_array['description']=$form_data['desc'];
				$field_array['location_id']=$form_data['location'];
				$field_array['dept_id']=$form_data['department_id'];
				$field_array['client_id']=$form_data['client_id'];
				$field_array['process_id']=$form_data['process_id'];
				$field_array['file_name']=$response['info']['file_name'];
				
				data_inserter('reporting_center',$field_array);
				echo json_encode($response);
			}
			else
			{
				echo json_encode($response);
			}
        }
    }
	
	private function do_upload($location)
	{
		if (!is_dir('uploads/report_center/'.$location)) {
			mkdir('./uploads/report_center/' . $location, 0777, TRUE);
		}
		$config['upload_path']          = './uploads/report_center/'.$location.'/';
		$config['file_name']          = round(microtime(true) * 1000);
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('upload'))
		{
			$response['stat'] = false;
			$response['error'] = array('error' => $this->upload->display_errors());
			return $response;
		}
		else
		{
			$response['stat'] = true;
			$response['info'] = $this->upload->data();
			return $response;
		}
	}
	
	public function download($id)
	{ 
		if(check_logged_in())
        {
			if(!isset($_SERVER['HTTP_REFERER'])){
				die('You can\'t access. <span style="font-size:100px">&#128540;</span>');
			}
			$current_user = get_user_id();
			$query = $this->db->query('SELECT file_name,location_id FROM reporting_center WHERE MD5(CONCAT(id,"","'.$current_user.'"))="'.$this->db->escape_str($id).'"');
			$row = $query->row();
			if($query->num_rows() > 0)
			{
				$info['file_name'] = $row->file_name;
				$file = APPPATH.'../uploads/report_center/'.$row->location_id.'/'.$row->file_name;
				if (file_exists($file)) {
					set_time_limit(0);
					header('Connection: Keep-Alive');
					header('Content-Description: File Transfer');
					//header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($file).'"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					ob_clean();
					flush();
					readfile($file);
				}
				else
				{
					die();
				}
			}
			else
			{
				die('You are not allowed to download this file.');
			}
		}
		
	}
}

?>