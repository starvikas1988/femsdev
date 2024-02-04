<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progression extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->model('user_model');
		
		
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
			
			//loading aside template
			$data["aside_template"] = "progression/aside.php";
			
			//if user is WFM, HR, Super, Manager or Special Approval
			if( get_dept_folder()=="wfm" || get_dept_folder()=="hr" || get_role_dir()=="super"  || get_role_dir()=="manager"|| is_approve_requisition()==true )
			{
				//loading main content template
				$data["content_template"] = "progression/manage_progression.php";
			}else{
				//if not above condition then redirect to apply method
				redirect('progression/apply', 'refresh');
			}
			//loading progression javascript
			$data["content_js"] = "progression/manage_progression_js.php";
			
			//get all department list
			$data["department_data"] = $this->Common_model->get_department_list();
			
			//loading client list
			$data['client_list'] = $this->Common_model->get_client_list();
			
			//if user is super or has global access
			if(get_role_dir()=="super" || $is_global_access==1){
				//return all office location list
				$data['location_list'] = $this->Common_model->get_office_location_list();
				
				//get all available requistion id with active status 1
				$qSql="Select requisition_id FROM ijp_requisitions WHERE is_active=1 ORDER BY requisition_id ASC";
				$data["get_requisition_ids"] = $this->Common_model->get_query_result_array($qSql);
				
				
			}else{
				//return all office location list for particular list
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				
				//get active requisition with particular office location
				$qSql="Select requisition_id FROM ijp_requisitions where location_id='$user_office_id' and is_active=1 ORDER BY requisition_id ASC";
				$data["get_requisition_ids"] = $this->Common_model->get_query_result_array($qSql);
				
				
			}
			
			//loading organization role except controller super
			$query = $this->db->query('SELECT * FROM `role_organization` WHERE controller != "super"');
			$data['new_desig'] = $query->result_object();
			
			//loading progression requisition reasons
			$query = $this->db->query('SELECT * FROM ijp_request_reason ');
			$data['req_reason'] = $query->result_object();
			
			
			$data['available_interview_count'] = $this->get_available_interview_count();
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_requisition_result()
	{
		$current_user = get_user_id();
		$get_client_ids = get_client_ids();
		$get_dept_id = get_dept_id();
		$user_office_id=get_user_office_id();
		$is_global_access = get_global_access();
		
		$form_data = $this->input->post();
		$search_query = array();
		foreach($form_data as $key=>$value)
		{
			if($value != '')
			{
				$search_query[] = $key.'='.$this->db->escape($value);
			}
		}
		$search_query[] = 'ijp_requisitions.is_active != 0';
		
		$final_search_query = '';
		if(count($search_query) > 0)
		{
			$final_search_query = 'WHERE '.implode(" AND ",$search_query);
		}
		
		$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,ijp_request_reason.request_reason,ijp_requisitions.life_cycle,(SELECT COUNT(*) FROM ijp_requisition_applications WHERE ijp_requisition_applications.status IS NOT NULL and ijp_requisition_applications.requisition_id=ijp_requisitions.requisition_id) as total_application FROM `ijp_requisitions`
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
			if(strtotime($value->due_date) < strtotime("now"))
			{
				//set application closed to apply
				$this->db->query('UPDATE ijp_requisitions SET life_cycle="AC" WHERE requisition_id="'.$value->requisition_id.'" AND life_cycle IN("OPN","APR","HRV")');
			}
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
				else if($value->movement_type == 'L')
				{
					$movement_type = 'Lateral';
				}
				else
				{
					$movement_type = 'Vertical/Lateral';
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
				$response['datas'] .= '<td>'.$value->total_application.'</td>';
				$response['datas'] .= $this->get_access_button(get_dept_folder(),$value->life_cycle,$value->requisition_id,$value->total_application,$value->filter_type,$value->location_id,$value->no_of_position);
				
			$response['datas'] .= '</tr>';
			$response['datas'] .= '<tr class="application_container">';
				$response['datas'] .= '<td colspan="15">';
					$response['datas'] .= '<div class="table-responsive">';
						$response['datas'] .= '<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">';
							$response['datas'] .= '<thead>';
								$response['datas'] .= '<tr class="bg-warning">';
									$response['datas'] .= '<th>SL</th>';
									$response['datas'] .= '<th>Name</th>';
									$response['datas'] .= '<th>Graduate</th>';
									$response['datas'] .= '<th>Teniority morethen 4 months</th>';
									$response['datas'] .= '<th>Unauthorize Leave</th>';
									$response['datas'] .= '<th>Disciplinary Action</th>';
									$response['datas'] .= '<th>Last Appraisal Rating</th>';
									$response['datas'] .= '<th>Resume</th>';
									$response['datas'] .= '<th>Action</th>';
								$response['datas'] .= '</tr>';
							$response['datas'] .= '</thead>';
							$response['datas'] .= '<tbody class="applications">';
								
							$response['datas'] .= '</tbody>';
						$response['datas'] .= '</table>';
					$response['datas'] .= '</div>';
				$response['datas'] .= '</td>';
			$response['datas'] .= '</tr>';
			$i++;
		}
		
		if(get_role_dir()=="super" || $is_global_access==1){
			//get all available requistion id with active status 1
			$qSql="Select requisition_id FROM ijp_requisitions WHERE is_active=1 ORDER BY requisition_id ASC";
			$response["get_requisition_ids"] = $this->Common_model->get_query_result_array($qSql);
			
			
		}else{
			//get active requisition with particular office location
			$qSql="Select requisition_id FROM ijp_requisitions where location_id='$user_office_id' and is_active=1 ORDER BY requisition_id ASC";
			$response["get_requisition_ids"] = $this->Common_model->get_query_result_array($qSql);
			
			
			
		}
			
		
		echo json_encode($response);
		
	}
	
	public function get_access_button($dept,$life_cycle,$requisition_id,$total_application,$filter_test,$location,$no_of_position)
	{
		$is_global_access = get_global_access();
		$response = '';
		if($dept=="wfm")
		{
			if($life_cycle == 'OPN')
			{
				$response .= '<td><button class="btn btn-xs btn-success approve_progression" data-requisition_id="'.$requisition_id.'" title="Approve Progression">Approve Progression</button></td>';
			}
			else if($life_cycle == 'APR')
			{
				$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression">Close Progression</button></td>';
			}
			else if($life_cycle == 'HRV')
			{
				$response .= '<td>Application Approval Pending</td>';
			}
			else if($life_cycle == 'AC')
			{
				if($total_application != 0)
				{
					$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">View Applications</button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">View Applications</button></td>';
				}
				else
				{
					$response .= '<td>No Application</td>';
				}
			}
		}
		else if($dept=="hr")
		{
			if($life_cycle == 'OPN')
			{
				$response .= '<td>WFM Approval Pending</td>';
			}
			else if($life_cycle == 'APR')
			{
				$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression">Close Progression</button></td>';
			}
			else if($life_cycle == 'HRV')
			{
				$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">View Applications</button></td>';
			}
			else if($life_cycle == 'AC')
			{
				if($total_application != 0)
				{
					$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">View Applications</button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">View Applications</button></td>';
				}
				else
				{
					$response .= '<td>No Application</td>';
				}
			}
		}
		else if(get_role_dir()=="super" || $is_global_access==1)
		{
			if($life_cycle == 'OPN')
			{
				$response .= '<td><button class="btn btn-xs btn-success approve_progression" data-requisition_id="'.$requisition_id.'" title="Approve Progression">Approve Progression</button></td>';
			}
			else if($life_cycle == 'APR')
			{
				$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression">Close Progression</button></td>';
			}
			else if($life_cycle == 'HRV')
			{
				$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">View Applications</button></td>';
			}
			else if($life_cycle == 'AC')
			{
				if($total_application != 0)
				{
					if($filter_test == 0)
					{
						$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">Applications</button>&nbsp;<button class="btn btn-xs btn-default schedule_interview" data-requisition_id="'.$requisition_id.'" title="Schedule Interview" data-location="'.$location.'">Schedule Interview</button></td>';
					}
					else
					{
						$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">Applications</button>&nbsp;<button class="btn btn-xs btn-default schedule_filter_test" data-requisition_id="'.$requisition_id.'" title="Schedule Test" data-location="'.$location.'">Schedule Filter Test</button></td>';
					}
				}
				else
				{
					$response .= '<td>No Application</td>';
				}
			}
			else if($life_cycle == 'AC1')
			{
				if($total_application != 0)
				{
					$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">Applications</button>&nbsp;<button class="btn btn-xs btn-default schedule_interview" data-requisition_id="'.$requisition_id.'" title="Schedule Interview" data-location="'.$location.'">Schedule Interview</button></td>';
				}
				else
				{
					$response .= '<td>No Application</td>';
				}
			}
			else if($life_cycle == 'ISC')
			{
				$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">Applications</button></td>';
			}
			else if($life_cycle == 'IMC')
			{
				$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">Applications</button>&nbsp;<button class="btn btn-xs btn-success final_selection" data-requisition_id="'.$requisition_id.'" data-no_of_position="'.$no_of_position.'" title="Final Selection">Final Selection</button></td>';
			}
			else if($life_cycle == 'SCRP')
			{
				$response .= '<td>Progression Scrap by Manager</td>';
			}
			else if($life_cycle == 'CLS')
			{
				$response .= '<td>Candidate Selected and Progression Closed</td>';
			}
			else if($life_cycle == 'FTSC')
			{
				$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">Applications</button></td>';
			}
			else if($life_cycle == 'FTD')
			{
				$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications">Applications</button>&nbsp;<button class="btn btn-xs btn-warning select_threshold" data-requisition_id="'.$requisition_id.'" title="Select Threshold">Threshold</button></td>';
			}
		}
		return $response;
	}
	
	public function get_hiring_manager()
	{
		$user_office_id=get_user_office_id();
		$is_global_access = get_global_access();
		$form_data = $this->input->post();
		
		$hiring_manager_query = $this->db->query('SELECT signin.id,CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
			LEFT JOIN role ON role.id=signin.role_id
			WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id="'.$form_data['office_id'].'"');
		if($hiring_manager_query)
		{
			$response['stat'] = true;
			$response['datas'] = $hiring_manager_query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function process_progression_requisition()
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
				else if($key=='hiring_manager_id')
				{
					$value = implode(',',$value);
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
	
	public function approve_progression()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "APR", `approved_by`="'.$current_user.'" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		
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
	
	public function close_progression()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisitions` SET `is_active`= "0",application_cls_reason="'.$form_data['application_cls_reason'].'", `closed_by`="'.$current_user.'" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		
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
			$data["role_id"] = get_role_id();
			
			if($data["role_id"] != 0)
			{
				//get org role id
				$query = $this->db->query('SELECT role_organization.id,role_organization.name,role_organization.controller,FLOOR(role_organization.rank) AS rank FROM `role_organization`
					LEFT JOIN role ON role.org_role=role_organization.id WHERE role.id='.get_role_id().'');
				$data["org_role_info"] = $query->row();
			}
			
			$data["aside_template"] = "progression/aside.php";
			$data["content_template"] = "progression/manage_progression_agent.php";
			$data["content_js"] = "progression/manage_progression_apply_js.php";
			$data['available_interview_count'] = $this->get_available_interview_count();
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_apply_ijp()
	{
		$location = get_user_office_id();
		$search_query = '';
		$get_client_ids = get_client_ids();
		$get_process_ids = get_process_ids();
		$get_dept_id = get_dept_id();
		$current_user = get_user_id();
		$role_id = get_role_id();
		if($role_id != 0)
		{
			//get org role id
			$query = $this->db->query('SELECT role_organization.id,role_organization.name,role_organization.controller,FLOOR(role_organization.rank) AS rank FROM `role_organization`
				LEFT JOIN role ON role.org_role=role_organization.id WHERE role.id='.$role_id.'');
			$org_role_info = $query->row();
		}
		$query = $this->db->query('SELECT sub_dept_id FROM signin WHERE id="'.$current_user.'"');
		$row = $query->row();
		$sub_debt_id = $row->sub_dept_id;
		$response['datas'] = '';
		if($location != 'ALL')
		{
			if(get_dept_id() == 6)
			{
				$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.client_id IN('.$get_client_ids.') and ijp_requisitions.process_id IN('.$get_process_ids.')) OR ijp_requisitions.posting_type="E")';
			}
			else
			{
				$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.') AND sub_debt_id='.$sub_debt_id.') OR ijp_requisitions.posting_type="E")';
			}
			$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,FLOOR(role_organization.rank) as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id

			WHERE ijp_requisitions.requisition_id NOT IN(SELECT requisition_id FROM ijp_requisition_applications WHERE user_id="'.$current_user.'")  AND life_cycle !="OPN" '.$search_query.' AND due_date >= CURDATE() ORDER BY id DESC');

		}
		else
		{
			$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,FLOOR(role_organization.rank) as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
			
			WHERE ijp_requisitions.requisition_id NOT IN(SELECT requisition_id FROM ijp_requisition_applications WHERE user_id="'.$current_user.'")  AND life_cycle !="OPN" AND due_date >= CURDATE() ORDER BY id DESC');
		}
		$req_result = $query->result_object();
		if($req_result)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		
		$i=1;
		$avail = 0;
		foreach($req_result as $key=>$value)
		{
			if($role_id == 0)
			{
				$response['datas'] .= '<tr><td colspan="14">No Progression Available For You.</td></tr>';
				break;
			}
			if($value->movement_type == 'V')
			{
				if(!(($value->designation_rank + 1) == floor($org_role_info->rank)))
				{
					continue;
				}
			}
			else if($value->movement_type == 'L')
			{
				if(!($value->designation_rank == floor($org_role_info->rank)))
				{
					continue;
				}
			}
			else if($value->movement_type == 'B')
			{
				if(!($value->designation_rank == floor($org_role_info->rank)) && !(($value->designation_rank + 1) == floor($org_role_info->rank)))
				{
					continue;
				}
			}
			$avail++;
			$response['datas'] .= '<tr>';
				$response['datas'] .= '<td>'.$i.'</td>';
				$response['datas'] .= '<td>'.$value->requisition_id.'</td>';
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
				else if($value->movement_type=='L')
				{
					$movement_type = 'Lateral';
				}
				else
				{
					$movement_type = 'Both';
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
				$response['datas'] .= '<td><a href="'.$value->requisition_id.'" class="appliy_requisition">Apply</a></td>';
			$response['datas'] .= '</tr>';
			$response['datas'] .= '<tr class="question_container">';
				$response['datas'] .= '<td colspan="14">';
					$response['datas'] .= '<div style="padding:15px;">';
						$response['datas'] .= '<form class="process_user_credential_form" enctype="multipart/form-data">';
							$response['datas'] .= '<table width="100%">';
								$response['datas'] .= '<tbody>';
									$response['datas'] .= '<tr>';
										$response['datas'] .= '<td width="60%">Are you Graduate?</td>';
										$response['datas'] .= '<td style="padding-left: 20px;">';
											$response['datas'] .= '<input type="hidden" name="requisition_id" value="'.$value->requisition_id.'">';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="graduate" value="1" required>Yes</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="graduate" value="0" required>No</label>';
										$response['datas'] .= '</td>';
									$response['datas'] .= '</tr>';
									$response['datas'] .= '<tr>';
										$response['datas'] .= '<td>Is your teniority morethen 4 month?</td>';
										$response['datas'] .= '<td style="padding-left: 20px;">';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="teniority" value="1" required>Yes</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="teniority" value="0" required>No</label>';
										$response['datas'] .= '</td>';
									$response['datas'] .= '</tr>';
									$response['datas'] .= '<tr>';
										$response['datas'] .= '<td>Do you have any unauthorize leave in last 4 month?</td>';
										$response['datas'] .= '<td style="padding-left: 20px;">';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="unauthorize_leave" value="1" required>Yes</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="unauthorize_leave" value="0" required>No</label>';
										$response['datas'] .= '</td>';
									$response['datas'] .= '</tr>';
									$response['datas'] .= '<tr>';
										$response['datas'] .= '<td>Any pending disciplinary action against you?</td>';
										$response['datas'] .= '<td style="padding-left: 20px;">';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="disciplinary_action" value="1" required>Yes</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="disciplinary_action" value="0" required>No</label>';
										$response['datas'] .= '</td>';
									$response['datas'] .= '</tr>';
									$response['datas'] .= '<tr>';
										$response['datas'] .= '<td>Your Last appraisal rating?</td>';
										$response['datas'] .= '<td style="padding-left: 20px;">';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="last_rating" value="1" required>1</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="last_rating" value="2" required>2</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="last_rating" value="3" required>3</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="last_rating" value="4" required>4</label>';
											$response['datas'] .= '<label class="radio-inline input-sm"><input type="radio" name="last_rating"  value="5" required>5</label>';
										$response['datas'] .= '</td>';
									$response['datas'] .= '</tr>';
									$response['datas'] .= '<tr>';
										$response['datas'] .= '<td>Upload Your Resume</td>';
										$response['datas'] .= '<td style="padding-left: 20px;"><input type="file" name="resume" class="form-control input-sm" required></td>';
									$response['datas'] .= '</tr>';
									$response['datas'] .= '<tr>';
										$response['datas'] .= '<td colspan="2"><button type="submit" class="btn btn-block btn-success input-sm">Submit Form</button></td>';
									$response['datas'] .= '</tr>';

								$response['datas'] .= '</tbody>';
							$response['datas'] .= '</table>';
						$response['datas'] .= '</form>';
					$response['datas'] .= '</div>';	
				$response['datas'] .= '</td>';
			$response['datas'] .= '</tr>';
			$i++;
		}
		if($avail == 0)
		{
			$response['datas'] .= '<tr><td colspan="14">No Progression Available For You.</td></tr>';
		}
		echo json_encode($response);
	}
	
	public function applied_progression()
	{
		$location = get_user_office_id();
		$search_query = '';
		$get_client_ids = get_client_ids();
		$get_process_ids = get_process_ids();
		$get_dept_id = get_dept_id();
		$current_user = get_user_id();
		$role_id = get_role_id();
		if($role_id != 0)
		{
			//get org role id
			$query = $this->db->query('SELECT role_organization.id,role_organization.name,role_organization.controller,FLOOR(role_organization.rank) AS rank FROM `role_organization`
				LEFT JOIN role ON role.org_role=role_organization.id WHERE role.id='.$role_id.'');
			$org_role_info = $query->row();
		}
		$query = $this->db->query('SELECT sub_dept_id FROM signin WHERE id="'.$current_user.'"');
		$row = $query->row();
		$sub_debt_id = $row->sub_dept_id;
		$response['datas'] = '';
	
		$query = $this->db->query('SELECT ijp_requisitions.*,ijp_requisition_applications.status as application_status,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,FLOOR(role_organization.rank) as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
			INNER JOIN ijp_requisition_applications ON ijp_requisition_applications.requisition_id=ijp_requisitions.requisition_id
			WHERE ijp_requisition_applications.user_id ='.$current_user.' ORDER BY id DESC');

		
		$req_result = $query->result_object();
		
		if($req_result)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		
		$i=1;
		foreach($req_result as $key=>$value)
		{
			if($role_id == 0)
			{
				$response['datas'] .= '<tr><td colspan="14">No Progression Available For You.</td></tr>';
				break;
			}
			if($value->movement_type == 'V')
			{
				if(!(($value->designation_rank + 1) == floor($org_role_info->rank)))
				{
					continue;
				}
			}
			else if($value->movement_type == 'L')
			{
				if(!($value->designation_rank == floor($org_role_info->rank)))
				{
					continue;
				}
			}
			else if($value->movement_type == 'B')
			{
				if(!($value->designation_rank == floor($org_role_info->rank)) && !(($value->designation_rank + 1) == floor($org_role_info->rank)))
				{
					continue;
				}
			}
			$response['datas'] .= '<tr>';
			$response['datas'] .= '<td>'.$i.'</td>';
			$response['datas'] .= '<td>'.$value->requisition_id.'</td>';
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
			else if($value->movement_type=='L')
			{
				$movement_type = 'Lateral';
			}
			else
			{
				$movement_type = 'Both';
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
			if($value->application_status == 'Applied')
			{
				$response['datas'] .= '<td>Pending Approval</td>';
			}
			else if($value->application_status == 'Approved')
			{
				$response['datas'] .= '<td>Approved</td>';
			}
			else if($value->application_status == 'Rejected')
			{
				$response['datas'] .= '<td>Rejected</td>';
			}
			$i++;
		}
		echo json_encode($response);
	}
	
	public function submit_user_application()
	{
		$config['upload_path']          = './uploads/progression_resume/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 2024;

		$this->load->library('upload', $config);
		$form_data = $this->input->post();
		$current_user = get_user_id();
		
		if ( ! $this->upload->do_upload('resume'))
		{
			$response['stat'] = false;
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
		}
		echo json_encode($response);
	}
	
	public function get_application()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT ijp_requisition_applications.*,ijp_interview_schedule.interviewers,CONCAT(signin.fname," ",signin.lname) AS user_name,ijp_requisitions.raised_by,ijp_requisitions.hiring_manager_id,ijp_requisitions.filter_type,ijp_requisitions.life_cycle,ijp_requisitions.due_date FROM ijp_requisition_applications LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			
			LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id
			LEFT JOIN ijp_interview_schedule ON CONCAT(ijp_requisition_applications.requisition_id,"",ijp_requisition_applications.user_id)=CONCAT(ijp_interview_schedule.requisition_id,"",ijp_interview_schedule.user_id)
			WHERE  ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'"');
		$rows = $query->result_object();
		$i=1;
		$response = '';
		foreach($rows as $key=>$value)
		{
			$response .= '<tr>';
				$response .= '<td>'.$i.'</td>';
				$response .= '<td>'.$value->user_name.'</td>';
				if($value->graduate == 1)
				{
					$response .= '<td>Yes</td>';
				}
				else
				{
					$response .= '<td>No</td>';
				}
				if($value->teniority == 1)
				{
					$response .= '<td>Yes</td>';
				}
				else
				{
					$response .= '<td>No</td>';
				}
				if($value->unauthorize_leave == 1)
				{
					$response .= '<td>Yes</td>';
				}
				else
				{
					$response .= '<td>No</td>';
				}
				if($value->disciplinary_action == 1)
				{
					$response .= '<td>Yes</td>';
				}
				else
				{
					$response .= '<td>No</td>';
				}
				$response .= '<td>'.$value->last_rating.'</td>';
				$response .= '<td><a href="'.base_url("uploads/progression_resume/").'/'.$value->resume.'" target="_blank">'.$value->resume.'</a></td>';
				if($value->status == 'Applied')//if applicant applied
				{
					$response .= '<td><button class="btn btn-xs btn-success approve_application" title="Approve Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-check-square" aria-hidden="true"></i></button>&nbsp;<button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
				}
				else if($value->status == 'Approved' && !(strtotime($value->due_date) < strtotime("now")))// if approved & due date > current date
				{
					$response .= '<td><button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
				}
				else if($value->status == 'Approved' && (strtotime($value->due_date) < strtotime("now")))// if approved & due date < current date
				{
					if($value->filter_type == 0)
					{
						$response .= '<td>Waiting For Final Interview</td>';
					}
					else
					{
						$response .= '<td>Waiting For Filter Test</td>';
					}
				}
				else if($value->status == 'Approved1' && (strtotime($value->due_date) < strtotime("now")))// if approved & due date < current date
				{
					$response .= '<td>Waiting For Final Interview</td>';
				}
				else if($value->status == 'Rejected' && !(strtotime($value->due_date) < strtotime("now")))
				{
					$response .= '<td><button class="btn btn-xs btn-success approve_application" title="Approve Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-check-square" aria-hidden="true"></i></button></td>';
				}
				else if($value->status == 'Rejected' && (strtotime($value->due_date) < strtotime("now")))
				{
					$response .= '<td>Rejected</td>';
				}
				else if($value->status == 'ScheduleInterview')
				{
					if($value->life_cycle == 'ISC')
					{
						/* $interviewers = explode(',',$value->interviewers);
						$response .= '<td>';
						foreach($interviewers as $key=>$values)
						{
							$response .= '<button class="btn btn-xs btn-default give_interview_marks" title="Give Interview Marks" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'" data-interviewer_id="'.$values.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> &nbsp; ';
						}
						$response .= '</td>'; */
						$response .= '<td>Interview Marks Pending</td>';
					}
					else
					{
						$response .= '<td>Interview Scheduled</td>';
					}
				}
				else if($value->status == 'FilterScheCompl')
				{
					$response .= '<td>Filter Test Scheduled</td>';
				}
				else if($value->status == 'InterviewMarksComplete')
				{
					$response .= '<td>Waiting For Final Selection&nbsp;<button class="btn btn-xs btn-default re_schedule_interview" data-requisition_id="'.$value->requisition_id.'" title="Re-Schedule Interview" data-user_id="'.$value->user_id.'">Re-Schedule Interview</button></td>';
				}
				else if($value->status == 'FilterTestCompl')
				{
					$response .= '<td>Filter Test Complete&nbsp;<button class="btn btn-xs btn-default re_schedule_filter_test" data-requisition_id="'.$value->requisition_id.'" title="Re-Schedule Filter Test" data-user_id="'.$value->user_id.'">Re-Schedule  Filter Test</button></td>';
				}
			$response .= '</tr>';
			$i++;
		}
		echo json_encode($response);
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
	
	public function reject_application()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "Rejected", message="'.$form_data['message'].'" WHERE requisition_id="'.$form_data['requisition_id'].'" and user_id="'.$form_data['user_id'].'"');
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
	
	public function get_approved_applications()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id,signin.id,ijp_requisition_applications.status FROM `ijp_requisition_applications` LEFT JOIN signin ON ijp_requisition_applications.user_id=signin.id WHERE requisition_id="'.$form_data['requisition_id'].'" AND (ijp_requisition_applications.status = "Approved" OR ijp_requisition_applications.status = "Approved1")');
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
			
		echo json_encode($response);
	}
	
	public function process_schedule_interview()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		if(!empty($form_data['select_for_interview']))
		{
			$value_array = array();
			foreach($form_data['select_for_interview'] as $key=>$value)
			{
				$value_array[] = '("'.$form_data['requisition_id'].'","'.$value.'","'.$form_data['interview_schedulue_time'].'","'.$form_data['interview_schedulue_end_time'].'","'.$current_user.'","'.date('Y-m-d').'","'.implode(',',$form_data['interviewers']).'")';
				
				$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="ScheduleInterview" WHERE user_id="'.$value.'" AND requisition_id="'.$form_data['requisition_id'].'"');
				foreach($form_data['interviewers'] as $ikey=>$ivalue)
				{
					$this->db->query('INSERT INTO `ijp_interview_score`(`requisition_id`, `user_id`, `interviewer_id`) VALUES ("'.$form_data['requisition_id'].'","'.$value.'","'.$ivalue.'")');
				}
			}
			$query = $this->db->query('INSERT INTO `ijp_interview_schedule`(`requisition_id`, `user_id`, `schedule_datetime`,`schedule_end_datetime`, `added_by`, `added_date`,`interviewers`) VALUES '.implode(',',$value_array).'');
			if(isset($form_data['select_all']))
			{
				//"ISC" => Interview Schedule Complete
				$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="ISC" WHERE requisition_id="'.$form_data['requisition_id'].'"');
			}
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
	
	public function give_interview_marks()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		$query = $this->db->query('INSERT INTO `ijp_interview_score`(`requisition_id`, `user_id`, `overall_interview_score`, `remarks`, `added_by`, `added_date`) VALUES ("'.$form_data['requisition_id'].'","'.$form_data['user_id'].'","'.$form_data['overall_interview_score'].'","'.$form_data['remarks'].'","'.$current_user.'",now())');
		
		$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="InterviewMarksComplete" WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		
		$query_interview_status_left = $this->db->query('SELECT COUNT(*) AS interview_status_left FROM `ijp_interview_schedule` LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,"",ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,"",ijp_interview_schedule.user_id) WHERE ijp_interview_score.requisition_id IS NULL');
		$row = $query_interview_status_left->row();
		echo $interview_status_left = $row->interview_status_left;
		if($interview_status_left == 0)
		{
			//"IMC" => Interview Marks Complete
			$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="IMC" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function re_schedule_interview()
	{
		$form_data = $this->input->post();
		$this->db->trans_start();
		$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="AC" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		$this->db->query('UPDATE `ijp_interview_score` SET `overall_interview_score`= null, remarks=null WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="Approved",interview_status="0" WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$response['stat'] = false;
		}
		else
		{
			$this->db->trans_commit();
			$response['stat'] = true;
		}
			
		echo json_encode($response);
	}
	
	public function get_applicant_for_final_selection()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id,signin.id,ijp_requisition_applications.status FROM `ijp_requisition_applications` LEFT JOIN signin ON ijp_requisition_applications.user_id=signin.id WHERE requisition_id="'.$form_data['requisition_id'].'" AND ijp_requisition_applications.status = "Approved"');
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
			
		echo json_encode($response);
	}
	
	public function get_available_interview_count()
	{
		$current_user = get_user_id();
		$is_global_access = get_global_access();
		
			$query = $this->db->query('SELECT ijp_interview_schedule.*,CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id FROM `ijp_interview_schedule` LEFT JOIN signin ON signin.id=ijp_interview_schedule.user_id
				LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,ijp_interview_schedule.user_id)
				WHERE FIND_IN_SET('.$current_user.',ijp_interview_schedule.interviewers) AND ijp_interview_score.interviewer_id='.$current_user.' AND ijp_interview_score.overall_interview_score IS NULL AND ijp_interview_schedule.interview_status="0" ORDER BY ijp_interview_schedule.schedule_datetime DESC');
		
		if($query)
		{
			//$row = $query->row();
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}
	
	public function get_available_interview()
	{
		$current_user = get_user_id();
		$is_global_access = get_global_access();
		
			$query = $this->db->query('SELECT ijp_interview_schedule.*,CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id FROM `ijp_interview_schedule` LEFT JOIN signin ON signin.id=ijp_interview_schedule.user_id
				LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,ijp_interview_schedule.user_id)
				WHERE FIND_IN_SET('.$current_user.',ijp_interview_schedule.interviewers) AND ijp_interview_score.interviewer_id='.$current_user.' AND ijp_interview_score.overall_interview_score IS NULL AND ijp_interview_schedule.interview_status="0" ORDER BY ijp_interview_schedule.schedule_datetime DESC');
		
		if($query)
		{
			if($query->num_rows() > 0)
			{
				return $query->result_object();
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	
	public function interview()
	{
		$data['available_interview_count'] = $this->get_available_interview_count();
		$data['available_interview'] = $this->get_available_interview();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access = get_global_access();
		$user_site_id= get_user_site_id();
		$data["is_global_access"] = get_global_access();
		$data["is_role_dir"] = get_role_dir();
		
		
		$data["aside_template"] = "progression/aside.php";
		
		
		if(get_role_dir()=="super"  || get_role_dir()=="manager"|| is_approve_requisition()==true )
		{
			$data["content_template"] = "progression/manage_interview.php";
		}else{
			redirect('progression/apply', 'refresh');
		}
		//loading progression javascript
		$data["content_js"] = "progression/progression_interview_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	public function get_available_interviewer()
	{
		$user_office_id=get_user_office_id();
		$is_global_access = get_global_access();
		$form_data = $this->input->post();
		
		$hiring_manager_query = $this->db->query('SELECT signin.id,CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
			LEFT JOIN role ON role.id=signin.role_id
			WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id="'.$form_data['office_id'].'" AND signin.id NOT IN (SELECT signin.id FROM `signin` LEFT JOIN role ON role.id=signin.role_id LEFT JOIN ijp_interview_schedule ON FIND_IN_SET(signin.id,ijp_interview_schedule.interviewers) WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id="'.$form_data['office_id'].'" AND ijp_interview_schedule.schedule_datetime>="'.$form_data['interview_schedulue_time'].'" AND ijp_interview_schedule.schedule_end_datetime<="'.$form_data['interview_schedulue_end_time'].'" GROUP BY signin.id)');
		if($hiring_manager_query)
		{
			$response['stat'] = true;
			$response['datas'] = $hiring_manager_query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function get_requisition_hiring_manager()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) as name FROM `signin` WHERE FIND_IN_SET(signin.id,(SELECT ijp_requisitions.hiring_manager_id FROM ijp_requisitions WHERE requisition_id="'.$form_data['requisition_id'].'"))');
		
		
		$hr_query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) as name FROM `signin` WHERE dept_id=3 AND office_id="'.$form_data['office_id'].'"');
		
		
		$get_req_query = $this->db->query('SELECT client_id,dept_id FROM `ijp_requisitions` WHERE requisition_id="'.$form_data['requisition_id'].'"');
		$row = $get_req_query->row();
		if($row->client_id == '')
		{
			$np_query = $this->db->query('SELECT signin.id,CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
			LEFT JOIN role ON role.id=signin.role_id
			WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id="'.$form_data['office_id'].'" AND dept_id != "'.$row->client_id.'" AND dept_id != "3"');
		}
		else
		{
			$np_query = $this->db->query('SELECT signin.id,CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
			LEFT JOIN role ON role.id=signin.role_id
			WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id="'.$form_data['office_id'].'" AND NOT FIND_IN_SET('.$row->client_id.',get_client_ids(signin.id)) AND dept_id != "3"');
		}
		
		if($query)
		{
			$response['stat'] = true;
			$response['datas_hrigin_manager'] = $query->result_object();
			$response['datas_hr_manager'] = $hr_query->result_object();
			$response['datas_np_manager'] = $np_query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function update_interview_score()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		
		$query = $this->db->query('UPDATE ijp_interview_score SET overall_interview_score="'.$form_data['overall_interview_score'].'" , remarks="'.$form_data['remarks'].'" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$form_data['user_id'].'" AND interviewer_id="'.$current_user.'"');
		
		$query = $this->db->query('SELECT COUNT(*) remaining_indv_interview FROM `ijp_interview_score` WHERE overall_interview_score IS null AND user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		$count = $query->row();
		if($count->remaining_indv_interview == 0)
		{
			$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="InterviewMarksComplete" WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		}
		
		$query_interview_status_left = $this->db->query('SELECT COUNT(*) AS interview_status_left FROM `ijp_interview_schedule` LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,"",ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,"",ijp_interview_schedule.user_id) WHERE ijp_interview_score.overall_interview_score IS NULL');
		$row = $query_interview_status_left->row();
		$interview_status_left = $row->interview_status_left;
		if($interview_status_left == 0)
		{
			//"IMC" => Interview Marks Complete
			$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="IMC" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function get_final_selection()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id,ijp_interview_score.overall_interview_score,ijp_interview_score.remarks FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_requisition_applications.requisition_id,ijp_requisition_applications.user_id) WHERE ijp_requisition_applications.status="InterviewMarksComplete" AND ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'" ORDER BY ijp_requisition_applications.user_id ASC');
		if($query)
		{
			$response['stat'] = true;
			$result = $query->result_object();
			$info_array = array();
			foreach($result as $key=>$value)
			{
				$info_array[$value->fusion_id]['id'] = $value->id;
				$info_array[$value->fusion_id]['name'] = $value->name;
				$info_array[$value->fusion_id]['fusion_id'] = $value->fusion_id;
				$info_array[$value->fusion_id]['scores'][] = $value->overall_interview_score;
				$info_array[$value->fusion_id]['remarks'][] = $value->remarks;
			}
			
			$response['datas'] = $info_array;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function process_final_selection($scrp=false)
	{
		$form_data = $this->input->post();
		if($scrp == true)
		{
			//"SCRP"=>NO selection but closed by hirging manager
			$query = $this->db->query('UPDATE ijp_requisitions SET life_cycle="SCRP" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		}
		else
		{
			//"CLS"=>Selection and Close
			foreach($form_data['select_candidate'] as $key=>$value)
			{
				$this->db->query('UPDATE ijp_requisition_applications SET status="Selected" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$value.'"');
			}
			$query = $this->db->query('UPDATE ijp_requisitions SET life_cycle="CLS" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function get_un_assig_filter_test_users()
	{
		$form_data = $this->input->post();
		
		$query = $this->db->query('SELECT ijp_requisition_applications.*,CONCAT(signin.fname,"",signin.lname) AS applicant_name,signin.fusion_id,signin.id as user_id FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id WHERE requisition_id="'.$form_data['requisition_id'].'" AND ijp_requisition_applications.status != "Rejected" AND user_id NOT IN(SELECT user_id FROM `lt_exam_schedule` WHERE module_id="'.$form_data['requisition_id'].'")');
		
		$query1 = $this->db->query('SELECT * FROM `lt_examination` WHERE location = "'.$form_data['location'].'" AND status=1');
		
		if($query)
		{
			$response['stat'] = true;
			$response['datas']['users'] = $query->result_object();
			$response['datas']['avail_exam'] = $query1->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function schedule_filter_test()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		$query_set = $this->db->query('SELECT id FROM `lt_question_set` WHERE exam_id="'.$form_data['exam'].'" and status=1 ORDER BY RAND() LIMIT 1');
		
		if($query_set->num_rows() > 0)
		{
			if(isset($form_data['select_all']))
			{
				//FTSC => Filter Test Schedule Complete
				$this->db->query('UPDATE ijp_requisitions SET life_cycle="FTSC" WHERE requisition_id="'.$form_data['requisition_id'].'"');
			}
			foreach($form_data['select_for_filter_test'] as $key=>$value)
			{
				$rows = $query_set->row();
				$set = $rows->id;
				$query = $this->db->query('INSERT INTO `lt_exam_schedule`(`module_id`,`module_type`,`user_id`, `exam_id`, `allotted_time`, `allotted_set_id`, `exam_start_time`, `added_by`, `added_date`, `exam_status`,`no_of_question`) VALUES ("'.$form_data['requisition_id'].'","IJP","'.$value.'","'.$form_data['exam'].'","'.$form_data['allotted_time'].'","'.$set.'","'.$form_data['exam_start_time'].'","'.$current_user.'",now(),0,"'.$form_data['no_of_question'].'")');
				
				$this->db->query('UPDATE ijp_requisition_applications SET status="FilterScheCompl" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$value.'"');
			}
			if($query)
			{
				$response['stat'] = true;
			}
			else
			{
				$response['stat'] = false;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		
		echo json_encode($response);
	}
	
	public function re_schedule_filter_test()
	{
		$form_data = $this->input->post();
		$this->db->trans_start();
		$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="AC" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		
		$query = $this->db->query('SELECT id FROM lt_exam_schedule WHERE module_id="'.$form_data['requisition_id'].'" AND user_id="'.$form_data['user_id'].'"');
		$row = $query->row();
		
		$this->db->query('DELETE FROM `lt_user_exam_answer` WHERE user_exam_id="'.$row->id.'"');
		$this->db->query('DELETE FROM `lt_exam_schedule` WHERE module_id="'.$form_data['requisition_id'].'" AND user_id="'.$form_data['user_id'].'"');
		$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="Approved" WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$response['stat'] = false;
		}
		else
		{
			$this->db->trans_commit();
			$response['stat'] = true;
		}
			
		echo json_encode($response);
	}
	
	public function get_threshold()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT lt_exam_schedule.user_id,CONCAT(signin.fname," ",signin.lname) AS applicant_name,signin.fusion_id,SUM(lt_questions_ans_options.correct_answer) AS total_correct,lt_exam_schedule.no_of_question FROM `lt_user_exam_answer` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.id=lt_user_exam_answer.ans_id 
			LEFT JOIN lt_exam_schedule ON lt_exam_schedule.id=lt_user_exam_answer.exam_schedule_id
			LEFT JOIN signin ON signin.id=lt_exam_schedule.user_id
			WHERE lt_exam_schedule.module_id="'.$form_data['requisition_id'].'"
			GROUP BY lt_user_exam_answer.exam_schedule_id');
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function select_threshold_candidate()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT lt_exam_schedule.user_id,CONCAT(signin.fname," ",signin.lname) AS applicant_name,signin.fusion_id,SUM(lt_questions_ans_options.correct_answer) AS total_correct,lt_exam_schedule.no_of_question FROM `lt_user_exam_answer` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.id=lt_user_exam_answer.ans_id 
			LEFT JOIN lt_exam_schedule ON lt_exam_schedule.id=lt_user_exam_answer.exam_schedule_id
			LEFT JOIN signin ON signin.id=lt_exam_schedule.user_id
			WHERE lt_exam_schedule.module_id="'.$form_data['requisition_id'].'"
			GROUP BY lt_user_exam_answer.exam_schedule_id');
			
		$rows = $query->result_object();
		foreach($rows as $key=>$value)
		{
			if(round((($value->total_correct * 100)/$value->no_of_question),1) >= $form_data['limit'])
			{
				$this->db->query('UPDATE ijp_requisition_applications SET status="Approved1" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$value->user_id.'"');
			}
			else
			{
				$this->db->query('UPDATE ijp_requisition_applications SET status="Rejected", message="Filter Test Threshold Not Cleared" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$value->user_id.'"');
			}
		}
		$this->db->query('UPDATE ijp_requisitions SET life_cycle="AC1" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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