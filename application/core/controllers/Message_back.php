<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('reports_model');
		
	}
	public function index()
    {
        if(check_logged_in())
        {
			if(get_global_access() == 1)
			{
				redirect('/message/create_message', 'refresh');
			}
			else
			{
				redirect('/message/unread_message', 'refresh');
			}
		}
	}
	
	public function category()
	{
		if(check_logged_in())
        {
			$get_client_id=get_client_ids();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
	
			$data["aside_template"] = "message/aside.php";
			$data["content_template"] = "message/create_category.php";
			$data['client_list'] = $this->Common_model->get_client_list();
			
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$query = $this->db->query('SELECT faq_types.*,client.shname,process.name as process_name FROM `faq_types` LEFT JOIN client ON client.id=faq_types.assign_client LEFT JOIN process ON  process.id=faq_types.assign_process WHERE status = 1');
			$rows = $query->result_object();
			$data["faq_categories"] = $rows;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function process_category()
	{
		$form_data = $this->input->post();
		if(!isset($form_data['faq_types_id']))
		{
			redirect($_SERVER['REQUEST_URI'], 'refresh');
			die();
		}
		if($form_data['faq_types_id'] == '')
		{
			$query = $this->db->query('INSERT INTO faq_types(name,assign_client,assign_process,location) VALUE('.$this->db->escape($form_data['name']).','.$this->db->escape($form_data['assign_client']).','.$this->db->escape($form_data['assign_process']).','.$this->db->escape($form_data['assign_site']).')');
		}
		else
		{
			$query = $this->db->query('UPDATE faq_types SET name='.$this->db->escape($form_data['name']).',assign_client='.$this->db->escape($form_data['assign_client']).',assign_process='.$this->db->escape($form_data['assign_process']).',location='.$this->db->escape($form_data['assign_site']).' WHERE id='.$this->db->escape($form_data['faq_types_id']).'');
		}
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function faq_message()
	{
		if(check_logged_in())
        {
			$get_client_id=get_client_ids();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
	
			$data["aside_template"] = "message/aside.php";
			$data["content_template"] = "message/create_faq_message.php";
			
			$query = $this->db->query('SELECT faq_types.id,faq_types.name AS category,faq_types.location FROM `faq_types` WHERE faq_types.status = 1');
			$data['faq_categories'] = $rows = $query->result_object();
			
			/* $query = $this->db->query('SELECT * FROM `department` WHERE department.is_active = 1');
			$data['department'] = $rows = $query->result_object(); */
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$query = $this->db->query('SELECT faqs.*,faq_types.name AS category,faq_types.id AS category_id,faq_types.location FROM `faqs` LEFT JOIN faq_types ON faq_types.id=faqs.faq_type_id WHERE faqs.status=1');
			$rows = $query->result_object();
			$data["messages"] = $rows;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function process_message()
	{
		$form_data = $this->input->post();
		if($form_data['faq_id'] == '')
		{
			$query = $this->db->query('INSERT INTO `faqs`(`faq_type_id`, `title`, `text`) VALUES ("'.$form_data['faq_category'].'","'.$form_data['name'].'","'.$form_data['text'].'")');
		}
		else
		{
			$query = $this->db->query('UPDATE `faqs` SET `faq_type_id`="'.$form_data['faq_category'].'",`title`="'.$form_data['name'].'",`text`="'.$form_data['text'].'" WHERE id="'.$form_data['faq_id'].'"');
		}
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function faqs()
	{
		if(check_logged_in())
        {
			$get_client_id=get_client_ids();
			$current_user = get_user_id();
			$dept_ids = get_dept_id();
			$client_ids = get_client_ids();
			$process_ids = get_process_ids();
			$office_id = get_user_office_id();
			$query = array();
			if(get_global_access() != 1)
			{
				if($process_ids != 0 && $process_ids != '')
				{
					$query[] = 'faq_types.assign_process IN('.$process_ids.')';
				}
				if($client_ids != 0 && $client_ids != '')
				{
					$query[] = 'faq_types.assign_client IN('.$client_ids.')';
				}
				/* if($dept_ids != 0 && $dept_ids != '')
				{
					$query[] = 'faqs.department_id IN('.$dept_ids.')';
				} */
				$query[] = 'faq_types.location="'.$office_id.'"';
				$query = 'SELECT * FROM `faqs` LEFT JOIN faq_types ON faq_types.id=faqs.faq_type_id WHERE '.implode(' AND ',$query).'';
			}
			else
			{
				$query = 'SELECT * FROM `faqs` LEFT JOIN faq_types ON faq_types.id=faqs.faq_type_id';
			}
	
			$data["aside_template"] = "message/aside.php";
			$data["content_template"] = "message/faqs.php";
			
			$query = $this->db->query($query);
			$data['faqs'] = $query->result_object();
			
			$data['unread'] = $this->un_read_count();
			$this->load->view('dashboard',$data);
		}
	}
	
	public function create_message()
	{
		if(check_logged_in())
        {
			$get_client_id=get_client_ids();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
	
			$data["aside_template"] = "message/aside.php";
			$data["content_template"] = "message/create_message.php";
			
			$query = $this->db->query('SELECT faq_types.id,faq_types.name AS category,faq_types.location FROM `faq_types` WHERE faq_types.status = 1');
			$data['faq_categories'] = $rows = $query->result_object();
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			$query = $this->db->query('SELECT * FROM `department` WHERE department.is_active = 1');
			$data['department'] = $rows = $query->result_object();
			
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$query = $this->db->query('SELECT faq_messageboard.*,client.id AS client_id,client.shname AS client_name,office_location.abbr AS office_location,process.id AS process_id, process.name AS process_name,faq_messageboard.department_id AS dpt_id,department.shname AS department_name,GROUP_CONCAT(faq_msg_attach.file_name SEPARATOR ",") AS attached_img_name,GROUP_CONCAT(faq_msg_attach.id SEPARATOR ",") AS attached_img_id FROM `faq_messageboard` LEFT JOIN faq_msg_attach ON faq_msg_attach.msgid=faq_messageboard.id LEFT JOIN client ON client.id=faq_messageboard.client_id LEFT JOIN process ON process.id=faq_messageboard.process_id LEFT JOIN department ON department.id=faq_messageboard.department_id LEFT JOIN office_location ON office_location.abbr=faq_messageboard.location_id WHERE faq_messageboard.status=1 GROUP BY faq_messageboard.id');
			$rows = $query->result_object();
			$data["messages"] = $rows;
			$data["unread"] = $this->un_read_count();
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function proces_create_message()
	{
		$form_data = $this->input->post();
		if($form_data['faq_messageboard_id'] == '')
		{
			$query = $this->db->query('INSERT INTO `faq_messageboard`(`subject`, `message_body`, `location_id`, `client_id`, `process_id`, `department_id`) VALUES ("'.$form_data['name'].'","'.$form_data['text'].'","'.$form_data['location'].'","'.$form_data['client'].'","'.$form_data['process'].'","'.$form_data['department'].'")');
		}
		else
		{
			$query = $this->db->query('UPDATE `faq_messageboard` SET `subject`="'.$form_data['name'].'",`message_body`="'.$form_data['text'].'",`location_id`="'.$form_data['location'].'",`client_id`="'.$form_data['client'].'",`process_id`="'.$form_data['process'].'",`department_id`="'.$form_data['department'].'" WHERE id="'.$form_data['faq_messageboard_id'].'"');
		}
		
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function unread_message()
	{
		if(check_logged_in())
        {
			$get_client_id=get_client_ids();
			$current_user = get_user_id();
			$dept_ids = get_dept_id();
			$client_ids = get_client_ids();
			$process_ids = get_process_ids();
			$office_id = get_user_office_id();
			$query = array();
			if(get_global_access() != 1)
			{
				if($process_ids != '')
				{
					$query[] = 'process_id IN(0,'.$process_ids.')';
				}
				if($client_ids != '')
				{
					$query[] = 'client_id IN(0,'.$client_ids.')';
				}
				if($dept_ids != 0 && $dept_ids != '')
				{
					$query[] = 'department_id IN(0,'.$dept_ids.')';
				}
				$query[] = 'location_id="'.$office_id.'"';
				$query = 'SELECT faq_messageboard.id as message_id,faq_messageboard.*,GROUP_CONCAT(faq_msg_attach.file_name SEPARATOR ",") AS file_name,GROUP_CONCAT(faq_msg_attach.id SEPARATOR ",") AS attached_img_id FROM `faq_messageboard` LEFT JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id  LEFT JOIN faq_msg_attach ON faq_msg_attach.msgid=faq_messageboard.id WHERE faq_messageboard.id NOT IN(SELECT faq_messageboard.id as message_id FROM `faq_messageboard` INNER JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id AND faq_message_read_stat.user_id="'.$current_user.'") AND '.implode(' AND ',$query).' GROUP BY faq_messageboard.id ORDER BY faq_messageboard.id DESC';
			}
			else
			{
				$query = 'SELECT faq_messageboard.id as message_id,faq_messageboard.*,GROUP_CONCAT(faq_msg_attach.file_name SEPARATOR ",") AS file_name,GROUP_CONCAT(faq_msg_attach.id SEPARATOR ",") AS attached_img_id FROM `faq_messageboard` LEFT JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id  LEFT JOIN faq_msg_attach ON faq_msg_attach.msgid=faq_messageboard.id WHERE faq_messageboard.id NOT IN(SELECT faq_messageboard.id as message_id FROM `faq_messageboard` INNER JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id AND faq_message_read_stat.user_id="'.$current_user.'") GROUP BY faq_messageboard.id ORDER BY faq_messageboard.id DESC';
			}
			
	
			$data["aside_template"] = "message/aside.php";
			$data["content_template"] = "message/unread_message.php";
			
			$query = $this->db->query($query);
			$data['messages'] = $query->result_object();
			$data["unread"] = $query->num_rows();
			
			$this->load->view('dashboard',$data);
		}
	}
	
	private function un_read_count()
	{
		$get_client_id=get_client_ids();
		$current_user = get_user_id();
		$dept_ids = get_dept_id();
		$client_ids = get_client_ids();
		$process_ids = get_process_ids();
		$office_id = get_user_office_id();
		$query = array();
		if(get_global_access() != 1)
		{
			if($process_ids != '')
			{
				$query[] = 'process_id IN(0,'.$process_ids.')';
			}
			if($client_ids != '')
			{
				$query[] = 'client_id IN(0,'.$client_ids.')';
			}
			if($dept_ids != 0 && $dept_ids != '')
			{
				$query[] = 'department_id IN(0,'.$dept_ids.')';
			}
			$query[] = 'location_id="'.$office_id.'"';
			$query = 'SELECT faq_messageboard.id as message_id,faq_messageboard.* FROM `faq_messageboard` LEFT JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id WHERE faq_messageboard.id NOT IN(SELECT faq_messageboard.id as message_id FROM `faq_messageboard` INNER JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id AND faq_message_read_stat.user_id="'.$current_user.'") AND '.implode(' AND ',$query).' GROUP BY faq_messageboard.id';
		}
		else
		{
			$query = 'SELECT faq_messageboard.id as message_id,faq_messageboard.* FROM `faq_messageboard` LEFT JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id WHERE faq_messageboard.id NOT IN(SELECT faq_messageboard.id as message_id FROM `faq_messageboard` INNER JOIN faq_message_read_stat ON faq_message_read_stat.message_id=faq_messageboard.id AND faq_message_read_stat.user_id="'.$current_user.'") GROUP BY faq_messageboard.id';
		}

		$data["aside_template"] = "message/aside.php";
		$data["content_template"] = "message/unread_message.php";
		
		$query = $this->db->query($query);
		
		return $query->num_rows();
	}
	public function my_message()
	{
		if(check_logged_in())
        {
			$get_client_id=get_client_ids();
			$current_user = get_user_id();
			$dept_ids = get_dept_id();
			$client_ids = get_client_ids();
			$process_ids = get_process_ids();
			$office_id = get_user_office_id();
			$query = array();
			if(get_global_access() != 1)
			{
				if($process_ids != '')
				{
					$query[] = 'process_id IN(0,'.$process_ids.')';
				}
				if($client_ids != '')
				{
					$query[] = 'client_id IN(0,'.$client_ids.')';
				}
				if($dept_ids != 0 && $dept_ids != '')
				{
					$query[] = 'department_id IN(0,'.$dept_ids.')';
				}
				$query[] = 'location_id="'.$office_id.'"';
				$query = 'SELECT faq_messageboard.id as message_id,faq_messageboard.*,GROUP_CONCAT(faq_msg_attach.file_name SEPARATOR ",") AS file_name,GROUP_CONCAT(faq_msg_attach.id SEPARATOR ",") AS attached_img_id FROM `faq_messageboard` LEFT JOIN faq_msg_attach ON faq_msg_attach.msgid=faq_messageboard.id WHERE '.implode(' AND ',$query).' GROUP BY faq_messageboard.id ORDER BY faq_messageboard.id DESC';
			}
			else
			{
				$query = 'SELECT faq_messageboard.id as message_id,faq_messageboard.*,GROUP_CONCAT(faq_msg_attach.file_name SEPARATOR ",") AS file_name,GROUP_CONCAT(faq_msg_attach.id SEPARATOR ",") AS attached_img_id FROM `faq_messageboard` LEFT JOIN faq_msg_attach ON faq_msg_attach.msgid=faq_messageboard.id GROUP BY faq_messageboard.id ORDER BY faq_messageboard.id DESC';
			}
	
			$data["aside_template"] = "message/aside.php";
			$data["content_template"] = "message/all_message.php";
			
			$query = $this->db->query($query);
			$data['messages'] = $query->result_object();
			$data['unread'] = $this->un_read_count();
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function upload()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data_type = $this->input->post();
			$current_user_fusion_id = get_user_fusion_id();
	
			$config['upload_path']          = '../femsdev/uploads/';
			if (!is_dir($config['upload_path']))
			{
				mkdir($config['upload_path'], 0777, TRUE);
			}
			
			$config['allowed_types']        = 'pdf|jpg|png|doc|docx|xlx|xlsx';
			$config['max_size']             = 2048;

			$this->load->library('upload', $config);
			$response = array();
			if ( ! $this->upload->do_upload('myfile'))
			{
				$response = array('error' => $this->upload->display_errors());
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

				if(isset($data_type['exp_id']))
				{
					$query = $this->db->query('INSERT INTO `faq_msg_attach`(`msgid`, `file_name`) VALUES ("'.$data_type['exp_id'].'","'.$this->upload->data('file_name').'")');
					if(!$query)
					{
						$response = array('error'=>'query');
					}
					else
					{
						$response = array("success"=>"true","exp_id"=>$data_type['exp_id'],"file_name"=>$this->upload->data('file_name'));
					}
				}
			}
			echo json_encode($response);
		}
   }
   public function delete_attach()
   {
		$attachemtn_id = $this->input->post('attachemtn_id');
		$query = $this->db->query('DELETE FROM `faq_msg_attach` WHERE `faq_msg_attach`.`id` = '.$attachemtn_id.'');
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
   }
   
   public function read_msg()
   {
		$msg_id = $this->input->post('msg_id');
		$current_user = get_user_id();
		$query = $this->db->query('INSERT INTO `faq_message_read_stat`(`user_id`, `message_id`) VALUES ("'.$current_user.'","'.$msg_id.'")');
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
   }
}