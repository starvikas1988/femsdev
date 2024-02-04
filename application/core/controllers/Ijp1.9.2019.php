<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ijp extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->model('user_model');
		
		
	}
	

///////////////////////////////////////////////////////////////////////	
///////////////////////// Requisition part ////////////////////////////
///////////////////////////////////////////////////////////////////////

	public function process_ijp_requisition()
	{
		if(check_logged_in())
		{
			$form_data = $this->input->post();
			$insert_columns = [];
			$insert_values = [];
			$curryear = date("Y");
			
			foreach($form_data as $key=>$value)
			{
				$insert_columns[] = $key;
				
				if($key=='requisition_id')
				{
					$value = generate_ijp_requisition_id("I".$form_data['location_id']."".$curryear);
				}
				
				$insert_values[] = $this->db->escape($value);
			}
			
			$current_user = get_user_id();
			$this->db->trans_start();
			$query = $this->db->query('INSERT INTO `ijp_requisitions`('.implode(",",$insert_columns).', `raised_by`, `raised_date`) VALUES ('.implode(",",$insert_values).',"'.$current_user.'",now())');
			
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$response['stat'] = false;
			}
			else
			{
				$response['stat'] = true;
			}
			echo json_encode($response);
		}
	}

	public function index()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "ijp/aside.php";
			if(!get_dept_folder()=="wfm" && !get_role_dir()=="super"  && !get_role_dir()=="manager" && !is_approve_requisition()==true)
			{
				redirect('ijp/apply', 'refresh');
			}
			else
			{
				$data["content_template"] = "ijp/manage_ijp.php";
			}
			$data["content_js"] = "ijp/manage_ijp_js.php";
			
			$data["department_data"] = $this->Common_model->get_department_list();
			$data['client_list'] = $this->Common_model->get_client_list();
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$qSql="Select requisition_id FROM ijp_requisitions ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				$data['req_result'] = $this->get_requisition_result();
			}else{
				$qSql="Select requisition_id FROM ijp_requisitions where location_id='$user_office_id' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				$data['req_result'] = $this->get_requisition_result(false,$user_office_id);
			}
			
			$query = $this->db->query('SELECT * FROM `role_organization` WHERE controller != "super"');
			$data['new_desig'] = $query->result_object();
			
			$query = $this->db->query('SELECT * FROM ijp_request_reason ');
			$data['req_reason'] = $query->result_object();
			
			$query = $this->db->query('SELECT signin.id,CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
					LEFT JOIN role ON role.id=signin.role_id
					WHERE role.folder="manager"');
			$data['hiring_managers'] = $query->result_object();
			
			
			
			
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	
	
	
	
	
	public function get_requisition_result($ajax=false,$location="ALL")
	{
		$current_user = get_user_id();
		$get_client_ids = get_client_ids();
		$get_dept_id = get_dept_id();
		if($ajax == true)
		{
			$form_data = $this->input->post();
			$search_query = array();
			foreach($form_data as $key=>$value)
			{
				if($value != '')
				{
					$search_query[] = $key.'='.$this->db->escape($value);
				}
			}
			
			$final_search_query = '';
			if(count($search_query) > 0)
			{
				$final_search_query = 'WHERE '.implode(" AND ",$search_query);
			}
			
			$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id '.$final_search_query.' ORDER BY id DESC');
			$response['stat'] = true;
			$response['datas'] = '';
			$result = $query->result_object();
			
			$i=1;
			foreach($result as $key=>$value)
			{
				$response['datas'] .= '<tr>';
					$response['datas'] .= '<td>'.$i.'</td>';
					$response['datas'] .= '<td><a href="#" class="view_life_cycle">'.$value->requisition_id.'</a></td>';
					$response['datas'] .= '<td>'.$value->requisition_date.'</td>';
					$response['datas'] .= '<td>'.$value->function.'</td>';
					$response['datas'] .= '<td>'.$value->client_name.'</td>';
					$response['datas'] .= '<td>'.$value->process_name.'</td>';
					$response['datas'] .= '<td>'.$value->dept_name.'</td>';
					$response['datas'] .= '<td>'.$value->sub_dept_name.'</td>';
					$response['datas'] .= '<td>'.$value->new_designation.'</td>';
					$response['datas'] .= '<td>'.$value->request_reason.'</td>';
					
					if($value->posting_type == 'I')
					{
						$posting_type = 'Internal';
					}
					else
					{
						$posting_type = 'External';
					}
					if($value->movement_type == 'V')
					{
						$movement_type = 'Vertical';
					}
					else
					{
						$movement_type = 'Lateral';
					}
					if($value->filter_type == '1')
					{
						$filter_type = 'Yes';
					}
					else
					{
						$filter_type = 'No';
					}
					
					$response['datas'] .= '<td>'.$posting_type.'</td>';
					$response['datas'] .= '<td>'.$movement_type.'</td>';
					$response['datas'] .= '<td>'.$filter_type.'</td>';
					if(get_dept_folder()=="wfm")
					{
						if($value->life_cycle == 'OPN')
						{
							$response['datas'] .= '<td><button class="btn btn-xs btn-success approve_requisition" data-requisition_id="'.$value->requisition_id.'" title="Approve Requisition"><i class="fa fa-check-square" aria-hidden="true"></i></button></td>';
						}
					}
				$response['datas'] .= '</tr>';
				$i++;
			}
				
			
			echo json_encode($response);
			
		}
		else
		{
			$search_query = '';
			if($location != 'ALL')
			{
				/* if(get_dept_id() == 6)
				{
					$search_query = ' WHERE ijp_requisitions.location_id="'.$location.'" AND ijp_requisitions.client_id IN('.$get_client_ids.')';
				}
				else
				{
					$search_query = ' WHERE ijp_requisitions.location_id="'.$location.'" AND ijp_requisitions.dept_id IN('.$get_dept_id.')';
				} */
				$search_query = ' WHERE ijp_requisitions.location_id="'.$location.'"';
			}
			
			$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id '.$search_query.' ORDER BY id DESC');
			return $query->result_object();
		}
		
	}
	
	public function approve_requisition()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "APR" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		
		if ($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function submit_user_application()
	{
		$config['upload_path']          = './uploads/ijp_resume/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 1024;

		$this->load->library('upload', $config);
		$form_data = $this->input->post();
		$current_user = get_user_id();
		
		if ( ! $this->upload->do_upload('resume'))
		{
			$response['stat'] = false;
			//$error = array('error' => $this->upload->display_errors());

			//$this->load->view('upload_form', $error);
		}
		else
		{
			$upload_data = $this->upload->data();
			$file_name =   $upload_data['file_name'];
			
			$query = $this->db->query('INSERT INTO `ijp_requisition_applications`(`requisition_id`, `user_id`, `graduate`, `teniority`, `unauthorize_leave`, `disciplinary_action`, `last_rating`, `resume`, `status`) VALUES ("'.$form_data['requisition_id'].'","'.$current_user.'","'.$form_data['graduate'].'","'.$form_data['teniority'].'","'.$form_data['unauthorize_leave'].'","'.$form_data['disciplinary_action'].'","'.$form_data['last_rating'].'","'.$file_name.'","Applied")');
			$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "HRV" WHERE requisition_id="'.$form_data['requisition_id'].'"');
			if($query)
			{
				$response['stat'] = true;
			}
			else
			{
				$response['stat'] = false;
			}
			
			//$data = array('upload_data' => $this->upload->data());

			//$this->load->view('upload_success', $data);
		}
		echo json_encode($response);
	}
	
	public function apply()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "ijp/aside.php";
			
			$data["content_template"] = "ijp/manage_ijp_agent.php";
			$data["content_js"] = "ijp/manage_ijp_js.php";
			
			$data["department_data"] = $this->Common_model->get_department_list();
			$data['client_list'] = $this->Common_model->get_client_list();
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$qSql="Select requisition_id FROM ijp_requisitions ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				$data['req_result'] = $this->get_apply_ijp();
			}else{
				$qSql="Select requisition_id FROM ijp_requisitions where location_id='$user_office_id' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				$data['req_result'] = $this->get_apply_ijp($user_office_id);
			}
			
			$query = $this->db->query('SELECT * FROM `role_organization` WHERE controller != "super"');
			$data['new_desig'] = $query->result_object();
			
			$query = $this->db->query('SELECT * FROM ijp_request_reason ');
			$data['req_reason'] = $query->result_object();
			
			$query = $this->db->query('SELECT signin.id,CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
					LEFT JOIN role ON role.id=signin.role_id
					WHERE role.folder="manager"');
			$data['hiring_managers'] = $query->result_object();
			
			
			
			
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_apply_ijp($location='ALL')
	{
		$search_query = '';
		$get_client_ids = get_client_ids();
		$get_process_ids = get_process_ids();
		$get_dept_id = get_dept_id();
		$current_user = get_user_id();
		$query = $this->db->query('SELECT sub_dept_id FROM signin WHERE id="'.$current_user.'"');
		$row = $query->row();
		$sub_debt_id = $row->sub_dept_id;
		if($location != 'ALL')
		{
			if(get_dept_id() == 6)
			{
				$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.client_id IN('.$get_client_ids.') and ijp_requisitions.process_id IN('.$get_process_ids.')) OR ijp_requisitions.posting_type="E" OR ijp_requisitions.posting_type="B")';
			}
			else
			{
				$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.') AND sub_debt_id='.$sub_debt_id.') OR ijp_requisitions.posting_type="E" OR ijp_requisitions.posting_type="B")';
			}
		}
		$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
		LEFT JOIN department ON department.id=ijp_requisitions.dept_id
		LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
		LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
		LEFT JOIN client ON client.id=ijp_requisitions.client_id
		LEFT JOIN process ON process.id=ijp_requisitions.process_id
		LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
		
        WHERE ijp_requisitions.requisition_id NOT IN(SELECT requisition_id FROM ijp_requisition_applications WHERE user_id="'.$current_user.'")  AND life_cycle="APR" '.$search_query.' ORDER BY id DESC');
		return $query->result_object();
	}

	public function get_life_cycle()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT life_cycle FROM ijp_requisitions WHERE requisition_id="'.$form_data['requisition_id'].'"');
		$result = $query->row();
		if($result->life_cycle == 'OPN')
		{
			echo 'IJP Requisition Opened';
		}
		else if($result->life_cycle == 'APR')
		{
			echo 'IJP Requisition Approved By WFM';
		}
		else if($result->life_cycle == 'HRV')
		{
			echo 'Awaiting Validation From HR';
		}
	}
	
	public function application()
	{
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access = get_global_access();
		$user_site_id= get_user_site_id();
		$data["is_global_access"] = get_global_access();
		$data["is_role_dir"] = get_role_dir();
		
		$data["aside_template"] = "ijp/aside.php";
		
		$data["content_template"] = "ijp/manage_ijp_application.php";
		$data["content_js"] = "ijp/manage_ijp_js.php";
		
		if(get_role_dir()=="super" || $is_global_access==1){
		
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,ijp_request_reason.request_reason,ijp_requisitions.life_cycle,(SELECT COUNT(*) FROM ijp_requisition_applications WHERE ijp_requisition_applications.status IS NOT NULL and ijp_requisition_applications.requisition_id=ijp_requisitions.requisition_id) as total_application FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id WHERE location_id="'.$user_office_id.'"');
		$data["req_result"] = $query->result_object();
		
		$this->load->view('dashboard',$data);
	}
	
	public function get_application()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT ijp_requisition_applications.*,CONCAT(signin.fname," ",signin.lname) AS user_name,ijp_requisitions.raised_by FROM ijp_requisition_applications LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id WHERE (ijp_requisition_applications.status="Applied" OR ijp_requisition_applications.status="Approved") and ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'"');
		$rows = $query->result_object();
		
		foreach($rows as $key=>$value)
		{
			echo '<tr>';
				echo '<td>'.$value->user_name.'</td>';
				if($value->graduate == 1)
				{
					echo '<td>Yes</td>';
				}
				else
				{
					echo '<td>No</td>';
				}
				if($value->teniority == 1)
				{
					echo '<td>Yes</td>';
				}
				else
				{
					echo '<td>No</td>';
				}
				if($value->unauthorize_leave == 1)
				{
					echo '<td>Yes</td>';
				}
				else
				{
					echo '<td>No</td>';
				}
				if($value->disciplinary_action == 1)
				{
					echo '<td>Yes</td>';
				}
				else
				{
					echo '<td>No</td>';
				}
				echo '<td>'.$value->last_rating.'</td>';
				echo '<td><a href="'.base_url("uploads/ijp_resume/").'/'.$value->resume.'" target="_blank">'.$value->resume.'</a></td>';
				if($value->resume == 'Applied')
				{
					echo '<td><a href="" class="approve_application" data-user_id="'.$value->user_id.'" data-requisition_id="'.$value->requisition_id.'">Approve</a></td>';
				}
				else
				{
					if($value->raised_by == $current_user)
					{
						echo '<td>Select</td>';
					}
					else
					{
						echo 'Approved';
					}
				}
			echo '<tr>';
		}
	}
	
	public function approve_application()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "Approved" WHERE requisition_id="'.$form_data['requisition_id'].'" and user_id="'.$form_data['user_id'].'"');
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


?>