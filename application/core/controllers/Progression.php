<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progression extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->model('user_model');
		$this->load->model('reports_model');
		
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
			
			/* $hiring_manager_id_array = explode(',',$hiring_manager_id);
			$hirging_manager = false;
			if (in_array($current_user, $hiring_manager_id_array)) {
				$hirging_manager = true;
			}
			$data["hirging_manager"] = $hirging_manager; */
			
			//loading aside template
			$data["aside_template"] = "progression/aside.php";
			
			//if user is WFM, HR, Super, Manager or Special Approval
			//|| get_role_dir()=="tl"
			
			if( get_dept_folder()=="wfm" || get_dept_folder()=="hr" || get_global_access() ==1  || get_role_dir()=="admin"  || get_role_dir()=="manager"  || is_approve_requisition()==true || is_create_progression()==true )
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
			$query = $this->db->query('SELECT * FROM `role` WHERE folder != "super" AND folder != "admin" AND is_active="1" ORDER BY name ASC');
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
		//close application
		$query = $this->db->query('SELECT ijp_requisitions.due_date,ijp_requisitions.requisition_id,ijp_requisitions.location_id FROM `ijp_requisitions`');
		$response['stat'] = true;
		$response['datas'] = '';
		$result = $query->result_object();
		
		//echo $value->due_date. " >> " . GetLocalTimeByOffice($value->location_id);
		//echo strtotime($value->due_date) ." >> " . strtotime(GetLocalTimeByOffice($value->location_id));
		
		$i=1;
		foreach($result as $key=>$value)
		{
			if(strtotime($value->due_date) <= strtotime(GetLocalDateByOffice($value->location_id)))
			{
				//set application closed to apply
				$this->db->query('UPDATE ijp_requisitions SET life_cycle="AC" WHERE requisition_id="'.$value->requisition_id.'" AND life_cycle IN("OPN","APR","HRV")');
			}
		}
		
		//close application
		
		
		$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,GROUP_CONCAT(process.name SEPARATOR ",") AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_org_designation, role.name AS new_designation, ijp_request_reason.request_reason,ijp_requisitions.life_cycle,(SELECT COUNT(*) FROM ijp_requisition_applications WHERE ijp_requisition_applications.status IS NOT NULL and ijp_requisition_applications.requisition_id=ijp_requisitions.requisition_id) as total_application FROM `ijp_requisitions`
		LEFT JOIN department ON department.id=ijp_requisitions.dept_id
		LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
		LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
		LEFT JOIN role ON role.id=ijp_requisitions.role_id
		LEFT JOIN client ON client.id=ijp_requisitions.client_id
		LEFT JOIN process ON FIND_IN_SET(process.id,ijp_requisitions.process_id)
		LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id '.$final_search_query.' GROUP BY ijp_requisitions.id ORDER BY id DESC');
		$response['stat'] = true;
		$response['datas'] = '';
		$result = $query->result_object();
		foreach($result as $key=>$value)
		{
			
			$trCss="";
			if($value->life_cycle=="JDD") $trCss="trJDD";
			if($value->life_cycle=="CLS") $trCss="trCLS";
			
			$response['datas'] .= '<tr class="'. $trCss .'">';
			$response['datas'] .= '<td>'.$i.'</td>';
			$response['datas'] .= '<td><a href="#" class="view_life_cycle">'.$value->requisition_id.'</a></td>';
				
			if($value->job_desc == '')
			{
				$response['datas'] .= '<td></td>';
			}else{
				$response['datas'] .= '<td data-job_desc="'.$value->job_desc.'"><a href="#" class="job_desc">View JD</a></td>';
			}
					
				$response['datas'] .= '<td>'.$value->requisition_date.'</td>';
				$response['datas'] .= '<td>'.$value->due_date.'</td>';
				$response['datas'] .= '<td>'.$value->ffunction.'</td>';
				$response['datas'] .= '<td>'.$value->location_id.'</td>';
				$response['datas'] .= '<td>'.$value->applicable_location.'</td>';
				$response['datas'] .= '<td>'.$value->client_name.'</td>';
				//$response['datas'] .= '<td>'.$value->process_name.'</td>';
				$response['datas'] .= '<td>'.$value->dept_name.'</td>';
				$response['datas'] .= '<td>'.$value->sub_dept_name.'</td>';
				if($value->role_id==0) $new_desig = $value->new_org_designation;
				else $new_desig = $value->new_designation;
				$response['datas'] .= '<td>'.$new_desig .'</td>';
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
				$response['datas'] .= '<td>'.$value->no_of_position.'</td>';
				$response['datas'] .= '<td>'.$value->total_application.'</td>';
				$response['datas'] .= $this->get_access_button(get_dept_folder(),$value->life_cycle,$value->requisition_id,$value->total_application,$value->filter_type,$value->location_id,$value->no_of_position,$value->hiring_manager_id,$value->ffunction, $value->due_date, $value->job_desc );
				
			$response['datas'] .= '</tr>';
			$response['datas'] .= '<tr class="application_container">';
				$response['datas'] .= '<td colspan="17">';
					$response['datas'] .= '<div class="table-responsive">';
						$response['datas'] .= '<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">';
							$response['datas'] .= '<thead>';
								$response['datas'] .= '<tr class="bg-warning">';
									$response['datas'] .= '<th>SL</th>';
									$response['datas'] .= '<th>Name</th>';
									$response['datas'] .= '<th>Fusion ID</th>';
									$response['datas'] .= '<th>XPO ID</th>';
									$response['datas'] .= '<th>Dept</th>';
									$response['datas'] .= '<th>Sub Dept</th>';
									$response['datas'] .= '<th>Client</th>';
									$response['datas'] .= '<th>Process</th>';
									$response['datas'] .= '<th>L1</th>';
									$response['datas'] .= '<th>DOJ</th>';
									$response['datas'] .= '<th>Tenure</th>';
									$response['datas'] .= '<th>Resume</th>';
									$response['datas'] .= '<th>Status</th>';
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
	
	public function get_access_button($dept,$life_cycle,$requisition_id,$total_application,$filter_test,$location,$no_of_position,$hiring_manager_id,$ffunction, $due_date, $job_desc)
	{
		$current_user = get_user_id();
		$is_global_access = get_global_access();
		$hiring_manager_id_array = explode(',',$hiring_manager_id);
		$hirging_manager = false;
		if (in_array($current_user, $hiring_manager_id_array)) {
			$hirging_manager = true;
		}
		$response = '';
		if($life_cycle == 'OPN')
		{
			if($dept=="wfm" || $is_global_access==1)
			{
				$response .= '<td><button class="btn btn-xs btn-success approve_progression" data-requisition_id="'.$requisition_id.'" title="Approve Progression"><i class="fa fa-check"></i></button>&nbsp;<button class="btn btn-xs btn-danger edit_progression" data-requisition_id="'.$requisition_id.'" title="Edit Progression"><i class="fa fa-edit"></i></button></td>';
			}
			else
			{
				$response .= '<td>Pending WFM Approval</td>';
			}
		}
		else if($life_cycle == 'APR')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="wfm")
			{
				if($filter_test == 0)
				{
					$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-danger edit_progression" data-requisition_id="'.$requisition_id.'" title="Edit Progression"><i class="fa fa-edit"></i></button></td>';
				}
				else
				{
					$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<a href="'.base_url("examination").'"><button class="btn btn-xs btn-default" data-requisition_id="'.$requisition_id.'" title="Create Exam"><i class="fa fa-wpforms"></i></button></a>&nbsp;<button class="btn btn-xs btn-danger edit_progression" data-requisition_id="'.$requisition_id.'" title="Edit Progression"><i class="fa fa-edit"></i></button></td>';
				}
				
			}
			else
			{
				$response .= '<td>Approved By WFM</td>';
			}
		}
		else if($life_cycle == 'HRV')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="hr" || $dept=="wfm")
			{
				if($filter_test == 0)
				{
					$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp; <button class="btn btn-xs btn-warning update_due_date" data-due_date="'.$due_date.'" data-job_desc="'.$job_desc.'" data-requisition_id="'.$requisition_id.'" title="Update JD & Due Date"><i class="fa fa-calendar"></i></button> </td>';
				}
				else
				{
					$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<a href="'.base_url("examination").'"><button class="btn btn-xs btn-default" data-requisition_id="'.$requisition_id.'" title="Create Exam"><i class="fa fa-wpforms"></i></button></a>&nbsp; <button class="btn btn-xs btn-warning update_due_date" data-due_date="'.$due_date.'" data-job_desc="'.$job_desc.'" data-requisition_id="'.$requisition_id.'" title="Update JD & Due Date"><i class="fa fa-calendar"></i></button> </td>';
				}
			}
			else
			{
				$response .= '<td>Approved By WFM</td>';
			}
		}
		else if($life_cycle == 'AC')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="wfm")
			{
				if($total_application != 0)
				{
					if($filter_test == 0)
					{
						$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-default schedule_interview" data-requisition_id="'.$requisition_id.'" title="Schedule Interview" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'"><i class="fa fa-calendar-plus-o"></i></button></td>';
					}
					else
					{
						$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-default schedule_filter_test" data-requisition_id="'.$requisition_id.'" title="Schedule Test" data-location="'.$location.'"><i class="fa fa-calendar-check-o"></i></button>&nbsp;<a href="'.base_url("examination").'"><button class="btn btn-xs btn-default" data-requisition_id="'.$requisition_id.'" title="Create Exam"><i class="fa fa-wpforms"></i></button></a></td>';
					}
				}
				else
				{
					$response .= '<td>No Application</td>';
				}
			}
			else if($dept=="hr")
			{
				if($total_application != 0)
				{
					
					$response .= '<td> <button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button></td>';
					
				}
				else
				{
					$response .= '<td>No Application</td>';
				}
				
			}
			else
			{
				
				if($filter_test == 0)
				{
					$response .= '<td>Interview Schedule Pending</td>';
				}
				else
				{
					$response .= '<td>Filter Test Schedule Pending</td>';
				}
			}
		}
		else if($life_cycle == 'AC1')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="wfm")
			{
				if($total_application != 0)
				{
					$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-default schedule_interview" data-requisition_id="'.$requisition_id.'" title="Schedule Interview" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'"><i class="fa fa-calendar-plus-o"></i></button></td>';
				}
				else
				{
					$response .= '<td>No Application</td>';
				}
			}
			else
			{
				$response .= '<td>Interview Schedule Pending</td>';
			}
		}
		else if($life_cycle == 'ISC')
		{
			$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button> <button class="btn btn-xs btn-success final_selection_basic" data-requisition_id="'.$requisition_id.'" data-no_of_position="'.$no_of_position.'" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'" title="View Feedback"><i class="fa fa-commenting"></i></button></td>';
		}
		else if($life_cycle == 'IMC')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="wfm")
			{
				$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-success final_selection" data-requisition_id="'.$requisition_id.'" data-no_of_position="'.$no_of_position.'" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'" title="Final Selection"><i class="fa fa-list-alt"></i></button></td>';
			}
			else
			{
				$response .= '<td>Pending Final Selection</td>';
			}
		}
		else if($life_cycle == 'SCRP')
		{
			//$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-success final_selection_basic" data-requisition_id="'.$requisition_id.'" data-no_of_position="'.$no_of_position.'" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'" title="View Feedback"><i class="fa fa-commenting"></i></button></td>';
			$response .= '<td>Position Scrapped</td>';
		}
		else if($life_cycle == 'CLS')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="wfm")
			{
				$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-success set_role_selection" data-requisition_id="'.$requisition_id.'" title="Role Selection" data-function="'.$ffunction.'"><i class="fa fa-building"></i></button>&nbsp;<button class="btn btn-xs btn-success final_selection_basic" data-requisition_id="'.$requisition_id.'" data-no_of_position="'.$no_of_position.'" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'" title="View Feedback"><i class="fa fa-commenting"></i></button></td>';
			}
			else
			{
				$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-success final_selection_basic" data-requisition_id="'.$requisition_id.'" data-no_of_position="'.$no_of_position.'" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'" title="View Feedback"><i class="fa fa-commenting"></i></button></td>';
			}
		}
		else if($life_cycle == 'FTSC')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="wfm")
			{
				$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-warning start_filter_test" data-requisition_id="'.$requisition_id.'" title="Start Filter Test"><i class="fa fa-hourglass-start"></i></button></td>';
			}
			else
			{
				$response .= '<td>Filter Test Scheduled</td>';
			}
		}
		else if($life_cycle == 'FTD')
		{
			if($hirging_manager == true || $is_global_access==1 || $dept=="wfm")
			{
				$response .= '<td><button class="btn btn-xs btn-danger close_progression_btn" data-requisition_id="'.$requisition_id.'" title="Close Progression"><i class="fa fa-cut"></i></button>&nbsp;<button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-warning select_threshold" data-requisition_id="'.$requisition_id.'" title="Select Threshold"><i class="fa fa-dashboard"></i></button></td>';
			}
			else
			{
				$response .= '<td>Pending Threshold Selection</td>';
			}
		}
		else if($life_cycle == 'JDD')
		{
			$response .= '<td><button class="btn btn-xs btn-primary view_applications" data-requisition_id="'.$requisition_id.'" data-life_cycle="'.$life_cycle.'" title="View Applications"><i class="fa fa-users"></i></button>&nbsp;<button class="btn btn-xs btn-success final_selection_basic" data-requisition_id="'.$requisition_id.'" data-no_of_position="'.$no_of_position.'" data-location="'.$location.'" data-hiring_manager_id="'.$hiring_manager_id.'" title="View Feedback"><i class="fa fa-commenting"></i></button></td>';
		}
		
		return $response;
	}
	
	public function get_hiring_manager()
	{
		$user_office_id=get_user_office_id();
		$is_global_access = get_global_access();
		$form_data = $this->input->post();
		$office_id = $form_data['office_id'];
		if( isIndiaLocation($office_id) == true)
		{
			$office_id = "'KOL','HWH','BLR','NOI','CHE'";
		}
		else
		{
			$office_id = "'".$office_id."'";
		}
		
		$hiring_manager_query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS name , office_id, (Select shname from department where department.id=signin.dept_id) as dept_name FROM `signin`
			LEFT JOIN role ON role.id=signin.role_id
			WHERE (role.folder in ("manager","admin") AND role.is_active=1 AND signin.status in (1,4) AND signin.office_id in ('. $office_id . ')) OR is_global_access=1 ');
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
			if($form_data['requisition_id'] == '')
			{
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
					else if($key=='process_id')
					{
						$value = implode(',',$value);
					}
					else if($key=='applicable_location')
					{
						$value = implode(',',$value);
					}
					
					$insert_values[] = $this->db->escape($value);
				}
				
				$current_user = get_user_id();
				$this->db->trans_start();
				
				$qSql='INSERT INTO `ijp_requisitions`('.implode(",",$insert_columns).', `raised_by`, `raised_date`) VALUES ('.implode(",",$insert_values).',"'.$current_user.'",now())';
				//echo $qSql;
				
				$query = $this->db->query($qSql);
			
			}
			else
			{
				$insert_columns = [];
				
				foreach($form_data as $key=>$value)
				{
					if($key == 'requisition_id')
					{
						$insert_columns[] = $key.'='.$this->db->escape($value);
					}
					else if($key=='hiring_manager_id')
					{
						$insert_columns[] = $key.'='.$this->db->escape(implode(',',$value));
					}
					else if($key=='process_id')
					{
						$insert_columns[] = $key.'='.$this->db->escape(implode(',',$value));
					}
					else if($key=='applicable_location')
					{
						$insert_columns[] = $key.'='.$this->db->escape(implode(',',$value));
					}
					else
					{
						$insert_columns[] = $key.'='.$this->db->escape($value);
					}
				}
				
				$current_user = get_user_id();
				$this->db->trans_start();
				
				$qSql='UPDATE `ijp_requisitions` SET '.implode(',',$insert_columns).' WHERE requisition_id="'.$form_data['requisition_id'].'"';
				//echo $qSql;
				
				$query = $this->db->query($qSql);
			}
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
				$query = $this->db->query('SELECT role_organization.id,role_organization.name,role_organization.controller,FLOOR(role_organization.rank) AS orank FROM `role_organization`
					LEFT JOIN role ON role.org_role=role_organization.id WHERE role.id='.get_role_id().'');
				$data["org_role_info"] = $query->row();
			}
			
			$data["aside_template"] = "progression/aside.php";
			$data["content_template"] = "progression/manage_progression_agent.php";
			$data["content_js"] = "progression/manage_progression_apply_js.php";
			$data['available_interview_count'] = $this->get_available_interview_count();
			
			
			$data['current_server_time'] = GetLocalTime();
			
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	private function get_user_tenure()
	{
		$current_user = get_user_id();
		$query = $this->db->query('SELECT TIMESTAMPDIFF(MONTH, doj, CURDATE()) AS tenure FROM `signin` WHERE id='.$current_user.'');
		$row = $query->row();
		return $row->tenure;
	}
	
	public function getCurrentAttendance(){
		
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$user_fusion_id = get_user_fusion_id();	
			$currDate=CurrDate();
			
			$start_date = CurrDateMDY();
			$end_date = CurrDateMDY();
			/*
			$prevMonth = date('m', strtotime($currDate))-1;
			$currYear = strtolower(date('Y', strtotime($currDate)));
			//echo "prevMonth :: " . $prevMonth;
			if($prevMonth==12) $start_date =$prevMonth."-26-".($currYear-1);
			else $start_date =$prevMonth."-26-".$currYear;
			*/
			
			//echo "start_date :: " . $start_date;
			//echo "\r\n end_date :: " . $currDate;
						
			$start_date = date('m-d-Y', strtotime('-2 month', time())); 
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => date('m-d-Y'),
					"client_id" => "",
					"office_id" => "",
					"site_id" => "",
					"user_site_id"=> "",
					"dept_id"=> "",
					"sub_dept_id" => "",
					"assigned_to" => "",
					"filter_key" => "Agent",
					"filter_value" => $user_fusion_id
			 );
			 			 
			return $this->get_attendence($this->reports_model->get_user_list_report($filterArray));
			
			
		}
	}
	
	public function get_attendence($attan_dtl)
	{
		$pDate=0;
		$absent['status'] = false;
		$absent['absent_dates'] = array();
		$absent['total_count'] = 0;
		
		foreach($attan_dtl as $user)
		{
		
		$cDate=$user['rDate'];
		
		$logged_in_hours=$user['logged_in_hours'];
		$logged_in_hours_local = $user['logged_in_hours_local'];
		
		
		$work_time=$user['logged_in_sec'];
		$work_time_local=$user['logged_in_sec_local'];
								
		$tBrkTime=$user['tBrkTime'];
		$tBrkTimeLocal=$user['tBrkTimeLocal'];
		
		$ldBrkTime=$user['ldBrkTime'];
		$ldBrkTimeLocal=$user['ldBrkTimeLocal'];
		
		$disposition=$user['disposition'];
		$office_id = $user['office_id'];
		
		$todayLoginTime=$user['todayLoginTime'];
		$is_logged_in = $user['is_logged_in'];
		
		$flogin_time=$user['flogin_time'];
		$flogin_time_local=$user['flogin_time_local'];
		
		$logout_time=$user['logout_time'];
		$logout_time_local = $user['logout_time_local'];
		
		$doj=$user['doj'];
		$rdate=$user['rDate'];
		
		$total_break=$tBrkTime+$ldBrkTime;
		$total_break_local=$tBrkTimeLocal+$ldBrkTimeLocal;
		
		$omuid= $user['omuid'];
		if($user['office_id']=="KOL") $omuid = $user['xpoid'];
		
		$comments = $user['comments'];
		
		
		$leave_dtl = "";
		$leave_status = $user['leave_status'];
		
		if($user['leave_type'] !=""){
			if( $leave_status == '0') $leave_dtl = $user['leave_type'] . " Applied";
			else if( $leave_status == '1') $leave_dtl = $user['leave_type'] . " Approved";
			else if( $leave_status == '2') $leave_dtl = $user['leave_type'] . " Reject";
		}
		
		
		if($rdate < $doj) continue;
			
		////////// For System Logout /////////////////////
		if($user['logout_by']=='0' && $logged_in_hours!="0"){
			//$work_time=0;
			//$logout_time="";
			$comments = "System Logout";
		}
		
		if($work_time == 0){
			$net_work_time="";
			$total_break = "";
			$tBrkTime = "";
			$ldBrkTime = "";
		}else{
			
			$net_work_time=gmdate('H:i:s',$work_time);
			
			$total_break = gmdate('H:i:s',$total_break);
			$tBrkTime = gmdate('H:i:s',$tBrkTime);
			$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
			
		}
		
		if($work_time_local==0){
			$net_work_time_local="";
			$total_break_local="";
			$tBrkTimeLocal = "";
			$ldBrkTimeLocal = "";
		
		}else{
			
			$net_work_time_local=gmdate('H:i:s',$work_time_local);
							
			$total_break_local = gmdate('H:i:s',$total_break_local);
			$tBrkTimeLocal = gmdate('H:i:s',$tBrkTimeLocal);
			$ldBrkTimeLocal = gmdate('H:i:s',$ldBrkTimeLocal);
		}

							
			if($is_logged_in == '1'){
				$todayLoginArray = explode(" ",$todayLoginTime);
				$todayLoginTime_local = ConvServerToLocalAny($todayLoginTime,$office_id);
				$todayLoginArray_local = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$disposition="online";
					$net_work_time="";
					$total_break = "";
					$tBrkTime = "";
					$ldBrkTime = "";
					$logout_time="";
				}
				
				if($rdate == $todayLoginArray_local[0]){
						$flogin_time_local=$todayLoginTime_local;
						$disposition="online";
						$net_work_time_local="";
						$total_break_local="";
						$tBrkTimeLocal = "";
						$ldBrkTimeLocal = "";
						$logout_time_local="";
				}
			}
	
		//echo "logged_in_sec:: " . $user['logged_in_sec'] ."<br>";
		//echo "logged_in_sec_local:: ". $user['logged_in_sec_local'] ."<br>";
		
		
			$disposition_est = "";
			if($logged_in_hours!="0"){
				if($user['user_disp_id']=="8" || $user['user_disp_id']=="7") $disposition_est =  " P &". $disposition;
				else $disposition_est =  "P";
			}else if($disposition!="") $disposition_est =  $disposition; 
			else if($rdate < $user['doj']) $disposition_est = "";
			else if($leave_dtl!="") $disposition_est = $leave_dtl;	
			else $disposition_est =  "Absent"; 
			
			$disposition_local="";
			
			if($logged_in_hours_local!="0"){
				if($user['user_disp_id']=="8" || $user['user_disp_id']=="7") $disposition_local =  " P &". $disposition;
				else $disposition_local =  "P";
			}else if($disposition!="") $disposition_local =  $disposition; 
			else if($rdate < $user['doj']) $disposition_local = "";
			else if($leave_dtl!="") $disposition_local = $leave_dtl;
			else $disposition_local =  "Absent"; 
			
			if($disposition_local == 'Absent')
			{
				$absent['status'] = true;
				$absent['absent_dates'][] = $cDate;
				$absent['total_count']++;
				
				
				//break;
			}
		}
		return $absent;
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
		$response['datas'] = '';
		$response['available_requisition'] = '';
		
		if($get_client_ids=="") $get_client_ids = 0;
		if($get_process_ids=="") $get_process_ids = 0;
		
		// ADDING EXTRA
		$extraFilterProcess = "";
		if($get_process_ids!=""){ 
			$splitProcess = explode(',', $get_process_ids);
			$extraFilterProcess = " ("; 
			$sn=0;			
			foreach($splitProcess as $tokenp)
			{
				$sn++;				
				if($sn == 1){ $extraFilterProcess .= " FIND_IN_SET($tokenp,ijp_requisitions.process_id)"; }
				if($sn > 1){ $extraFilterProcess .= " OR FIND_IN_SET($tokenp,ijp_requisitions.process_id)"; }				
			}
			$extraFilterProcess .=")";			
		}
		
		if($role_id != 0)
		{
			//get org role id
			$query = $this->db->query('SELECT role_organization.id,role_organization.name,role_organization.controller,FLOOR(role_organization.rank) AS orank FROM `role_organization`
				LEFT JOIN role ON role.org_role=role_organization.id WHERE role.id='.$role_id.'');
			$org_role_info = $query->row();
		}
		
		$query = $this->db->query('SELECT sub_dept_id FROM signin WHERE id="'.$current_user.'"');
		$row = $query->row();
		$sub_debt_id = $row->sub_dept_id;
		
		if($location != 'ALL')
		{
			if(get_dept_id() == 6)
			{
				//$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.client_id IN('.$get_client_ids.') and  FIND_IN_SET('.$get_process_ids.',ijp_requisitions.process_id)) OR (ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.')) OR ijp_requisitions.posting_type="E")';
				
				//$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.client_id IN('.$get_client_ids.') and  '.$extraFilterProcess.') OR (ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.')) OR ijp_requisitions.posting_type="E")';
				
				$search_query = ' AND FIND_IN_SET("'.$location.'",ijp_requisitions.applicable_location) AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.client_id IN('.$get_client_ids.') and  '.$extraFilterProcess.') OR (ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.')) OR ijp_requisitions.posting_type="E")';
				
			}
			else
			{
				//$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.') AND sub_debt_id='.$sub_debt_id.') OR ijp_requisitions.posting_type="E")';
				
				//$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.') ) OR ijp_requisitions.posting_type="E")';
				
				$search_query = ' AND FIND_IN_SET("'.$location.'",ijp_requisitions.applicable_location) AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.') ) OR ijp_requisitions.posting_type="E")';
			}
			
			$qSql='SELECT ijp_requisitions.*,client.shname AS client_name,GROUP_CONCAT(process.name SEPARATOR ",") AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_org_designation,role.name AS new_designation,FLOOR(role_organization.rank) as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN role ON role.id=ijp_requisitions.role_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON FIND_IN_SET(process.id,ijp_requisitions.process_id)
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
			WHERE ijp_requisitions.requisition_id NOT IN(SELECT requisition_id FROM ijp_requisition_applications WHERE user_id="'.$current_user.'")  AND life_cycle !="OPN" '.$search_query.' AND due_date >= "'.GetLocalDate().'" AND ijp_requisitions.is_active=1 GROUP BY ijp_requisitions.id ORDER BY id DESC';
			
			//echo $qSql;
			$query = $this->db->query($qSql);

		}
		else
		{
			$qSql='SELECT ijp_requisitions.*,client.shname AS client_name,GROUP_CONCAT(process.name SEPARATOR ",") AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_org_designation,role.name AS new_designation,FLOOR(role_organization.rank) as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN role ON role.id=ijp_requisitions.role_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON FIND_IN_SET(process.id,ijp_requisitions.process_id)
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
			WHERE ijp_requisitions.requisition_id NOT IN(SELECT requisition_id FROM ijp_requisition_applications WHERE user_id="'.$current_user.'")  AND life_cycle !="OPN" AND due_date >= "'.GetLocalDate().'" AND ijp_requisitions.is_active=1 GROUP BY ijp_requisitions.id  ORDER BY id DESC';
			
			$query = $this->db->query($qSql);
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
		/* if(!$this->getCurrentAttendance())
		{ */
			foreach($req_result as $key=>$value)
			{
				if($this->get_user_tenure() >= $value->set_tenurity)
				{
					if($role_id == 0)
					{
						$response['datas'] .= '<tr><td colspan="14">No Progression Available For You.</td></tr>';
						break;
					}
					if($value->movement_type == 'V')
					{
						if(!(($value->designation_rank + 1) == floor($org_role_info->orank)))
						{
							continue;
						}
					}
					else if($value->movement_type == 'L')
					{
						if(!($value->designation_rank == floor($org_role_info->orank)))
						{
							continue;
						}
					}
					else if($value->movement_type == 'B')
					{
						if(!($value->designation_rank == floor($org_role_info->orank)) && !(($value->designation_rank + 1) == floor($org_role_info->orank)))
						{
							continue;
						}
					}
					$avail++;
					$response['datas'] .= '<tr class="apply_req_'.$value->requisition_id.'">';
						$response['datas'] .= '<td>'.$i.'</td>';
						$response['datas'] .= '<td>'.$value->requisition_id.'</td>';
						if($value->job_desc == '')
						{
							$response['datas'] .= '<td></td>';
						}
						else
						{
							$response['datas'] .= '<td data-job_desc="'.$value->job_desc.'"><a href="#" class="job_desc">View Job Description</a></td>';
						}
						$response['datas'] .= '<td>'.$value->due_date.'</td>';
						$response['datas'] .= '<td>'.$value->ffunction.'</td>';
						$response['datas'] .= '<td>'.$value->location_id.'</td>';
						$response['datas'] .= '<td>'.$value->client_name.'</td>';
						$response['datas'] .= '<td>'.$value->process_name.'</td>';
						$response['datas'] .= '<td>'.$value->dept_name.'</td>';
						$response['datas'] .= '<td>'.$value->sub_dept_name.'</td>';
						
						if($value->role_id==0) $new_desig = $value->new_org_designation;
						else $new_desig = $value->new_designation;
						
						$response['datas'] .= '<td>'.$new_desig.'</td>';
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
						
						//if($value->location_id == $location){
							$response['datas'] .= '<td><a href="'.$value->requisition_id.'" class="appliy_requisition"><span class="label label-success">Apply</span></a></td>';
						/*} else {
							$response['datas'] .= '<td>
							<a href="javascipt:void(0)" rid="'.$value->requisition_id.'" class="appliy_consent_requisition"><span class="label label-danger"><i class="fa fa-warning"></i> Apply</span></a>
							<a style="display:none" href="'.$value->requisition_id.'" class="appliy_requisition"><span class="label label-success">Apply Now</span></a>
							</td>';
						}*/
						
					$response['datas'] .= '</tr>';
					$response['datas'] .= '<tr class="question_container">';
						$response['datas'] .= '<td colspan="16">';
							$response['datas'] .= '<div style="padding:15px;">';
								$response['datas'] .= '<form class="process_user_credential_form" enctype="multipart/form-data">';
									$response['datas'] .= '<table width="100%">';
										$response['datas'] .= '<tbody class="requisitionApplyConsent">';
											
											
											// CHECK LOCATION CONSENT CHECK
											$hideClassCheck = ''; $showClassCheck = 'style="display:none"';
											if($value->location_id == $location){ $hideClassCheck = 'style="display:none"'; $showClassCheck = ''; }
											
											$response['datas'] .= '<tr class="requisitionConsentCheckAccept" '.$hideClassCheck.'>';
												$response['datas'] .= '<td style="width:60%;font-size:12px">Are you sure you want to apply for other location, please confirm?</td>';
												$response['datas'] .= '<td style="padding-left: 20px;">
												<input type="hidden" name="consent_accept" value="0">
												<textarea name="consent_comments" class="form-control" placeholder="Enter Comments for Confirmation"></textarea>
												</td>';
											$response['datas'] .= '</tr>';
											
											$response['datas'] .= '<tr class="requisitionConsentCheckAccept" '.$hideClassCheck.'>';
												$response['datas'] .= '<td colspan="2" style="padding: 5px 0px;">
												<a href="javascipt:void(0)" rid="'.$value->requisition_id.'"  style="margin:2px 5px" class="btn btn-success requisitionConsentAccept">
												<i class="fa fa-check"></i> Yes</a>
												<a href="javascipt:void(0)" rid="'.$value->requisition_id.'"  style="margin:2px 5px" class="btn btn-danger requisitionConsentNo">
												<i class="fa fa-times"></i> No</a>
												</td>';
											$response['datas'] .= '</tr>';
											
											if($value->location_id != $location){
											$response['datas'] .= '<tr class="requisitionuploadResume" '.$showClassCheck.'>';
												$response['datas'] .= '<td style="width:60%;"><b>Yes, I confirm that I am ready to relocate.</b></td>';
												$response['datas'] .= '<td style="padding-left: 20px;">
												<span class="text-success"><i class="fa fa-check"></i></span>
												</td>';
											$response['datas'] .= '</tr>';
											}
											
											$response['datas'] .= '<tr class="requisitionuploadResume" '.$showClassCheck.'>';
												$response['datas'] .= '<input type="hidden" name="requisition_id" value="'.$value->requisition_id.'">';
												$response['datas'] .= '<input type="hidden" name="filter_type" value="'.$value->filter_type.'">';
												$response['datas'] .= '<td style="width:60%;">Upload Your Resume</td>';
												$response['datas'] .= '<td style="padding-left: 20px;"><input type="file" name="resume" class="form-control input-sm" required></td>';
											$response['datas'] .= '</tr>';
											
											$response['datas'] .= '<tr class="requisitionuploadResume" '.$showClassCheck.'>';
												$response['datas'] .= '<td colspan="2" style="padding: 5px 0px;"><button type="submit" class="btn btn-success">Submit Form</button></td>';
											$response['datas'] .= '</tr>';

										$response['datas'] .= '</tbody>';
									$response['datas'] .= '</table>';
								$response['datas'] .= '</form>';
							$response['datas'] .= '</div>';	
						$response['datas'] .= '</td>';
					$response['datas'] .= '</tr>';
					$i++;
				}
			}
			
		/* } */
		
		if($avail == 0)
		{
			$response['datas'] .= '<tr><td colspan="14">No Progression Available For You.</td></tr>';
		}
		
		$response['available_requisition'] .= $avail;
		
		
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
			$query = $this->db->query('SELECT role_organization.id,role_organization.name,role_organization.controller,FLOOR(role_organization.rank) AS orank FROM `role_organization`
				LEFT JOIN role ON role.org_role=role_organization.id WHERE role.id='.$role_id.'');
			$org_role_info = $query->row();
		}
		$query = $this->db->query('SELECT sub_dept_id FROM signin WHERE id="'.$current_user.'"');
		$row = $query->row();
		$sub_debt_id = $row->sub_dept_id;
		$response['datas'] = '';
	

		$query = $this->db->query('SELECT ijp_requisitions.*,ijp_requisition_applications.status as application_status, ijp_requisition_applications.message, ijp_requisition_applications.new_joining_date, ijp_requisition_applications.new_l1, client.shname AS client_name,GROUP_CONCAT(process.name SEPARATOR ",") AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,FLOOR(role_organization.rank) as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle,lt_exam_schedule.exam_start_time AS filter_test_scheduled,(lt_exam_schedule.exam_start_time + INTERVAL lt_exam_schedule.allotted_time MINUTE) as exam_end_time,lt_exam_schedule.id AS exam_schedule_id,lt_exam_schedule.exam_status FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON FIND_IN_SET(process.id,ijp_requisitions.process_id)
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
			INNER JOIN ijp_requisition_applications ON ijp_requisition_applications.requisition_id=ijp_requisitions.requisition_id
			LEFT JOIN lt_exam_schedule ON CONCAT(lt_exam_schedule.module_id,"",lt_exam_schedule.user_id)=CONCAT(ijp_requisitions.requisition_id,"",ijp_requisition_applications.user_id)
			WHERE ijp_requisition_applications.user_id ="'.$current_user.'" GROUP BY ijp_requisitions.id ORDER BY id DESC');

		
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
				if(!(($value->designation_rank + 1) == floor($org_role_info->orank)))
				{
					continue;
				}
			}
			else if($value->movement_type == 'L')
			{
				if(!($value->designation_rank == floor($org_role_info->orank)))
				{
					continue;
				}
			}
			else if($value->movement_type == 'B')
			{
				if(!($value->designation_rank == floor($org_role_info->orank)) && !(($value->designation_rank + 1) == floor($org_role_info->orank)))
				{
					continue;
				}
			}
			$response['datas'] .= '<tr>';
			$response['datas'] .= '<td>'.$i.'</td>';
			$response['datas'] .= '<td>'.$value->requisition_id.'</td>';
			if($value->job_desc == '')
			{
				$response['datas'] .= '<td></td>';
			}
			else
			{
				$response['datas'] .= '<td data-job_desc="'.$value->job_desc.'"><a href="#" class="job_desc">Job Description</a></td>';
			}
			$response['datas'] .= '<td>'.$value->due_date.'</td>';
			$response['datas'] .= '<td>'.$value->ffunction.'</td>';
			$response['datas'] .= '<td>'.$value->location_id.'</td>';
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
				$response['datas'] .= '<td></td>';
			}
			else if($value->application_status == 'Approved')
			{
				$response['datas'] .= '<td><span class="label label-success">Applied</span></td>';
				$response['datas'] .= '<td></td>';
			}
			else if($value->application_status == 'Approved1')
			{
				$response['datas'] .= '<td><span class="label label-success">Applied</span></td>';
				$response['datas'] .= '<td></td>';
			}
			else if($value->application_status == 'Rejected')
			{
				$response['datas'] .= '<td><span class="label label-danger">'.$value->message.'</span></td>';
				$response['datas'] .= '<td><button type="submit" class="btn btn-block btn-success btn-xs agent_final_selection_basic" data-requisition_id="'.$value->requisition_id.'"><i class="fa fa-commenting"></i></button></td>';
			}
			else if($value->application_status == 'AbsentRejected')
			{
					$response['datas'] .= '<td width="20%">'.$value->message.'</td>';
			}
			else if($value->application_status == 'FilterScheCompl')
			{
				if((strtotime(date('Y-m-d H:i:s')) > strtotime(ConvLocalToServer($value->exam_end_time))) && $value->exam_status == 0)
				{
					$response['datas'] .= '<td><span class="label label-danger">You Missed Filter Test</span></td>';
					$response['datas'] .= '<td></td>';
				}
				else if($value->exam_status == 2)
				{
					$response['datas'] .= '<td data-filter_test_time="'.$value->filter_test_scheduled.'" data-filter_test_end_time="'.$value->exam_end_time.'" data-exam_schedule_id="'.$value->exam_schedule_id.'"><span class="label label-success">Filter Test Active</span></td>';
					$response['datas'] .= '<td><form action="'.base_url('examination/exam_panel').'" method="POST"><input type="hidden" name="lt_exam_schedule_id" value="'.$value->exam_schedule_id.'"><button type="submit" class="btn btn-block btn-success btn-xs">Give Exam</button></form></td>';
				}
				else
				{
					
					if($value->exam_status == 3)
					{
						$response['datas'] .= '<td data-filter_test_time="'.$value->filter_test_scheduled.'" data-filter_test_end_time="'.$value->exam_end_time.'" data-exam_schedule_id="'.$value->exam_schedule_id.'"><span class="label label-success">Filter Test in Progress</span></td>';
						$response['datas'] .= '<td><form action="'.base_url('examination/exam_panel').'" method="POST"><input type="hidden" name="lt_exam_schedule_id" value="'.$value->exam_schedule_id.'"><button type="submit" class="btn btn-block btn-success btn-xs">Give Exam</button></form></td>';
					}
					else if(($value->exam_status == 2))
					{
						$response['datas'] .= '<td data-filter_test_time="'.$value->filter_test_scheduled.'" data-filter_test_end_time="'.$value->exam_end_time.'" data-exam_schedule_id="'.$value->exam_schedule_id.'"><span class="label label-success">Filter Test Active</span></td>';
						$response['datas'] .= '<td><form action="'.base_url('examination/exam_panel').'" method="POST"><input type="hidden" name="lt_exam_schedule_id" value="'.$value->exam_schedule_id.'"><button type="submit" class="btn btn-block btn-success btn-xs">Give Exam</button></form></td>';
					}
					else if(($value->exam_status == 0))
					{
						$response['datas'] .= '<td><span class="label label-success">Filter Test Schedule</span></td>';
						$response['datas'] .= '<td>'.$value->filter_test_scheduled.'</td>';
					}
					else if(($value->exam_status == 1))
					{
						$response['datas'] .= '<td><span class="label label-success">Filter Test Done</span></td>';
						$response['datas'] .= '<td>Scored '.$this->get_student_marks($value->requisition_id,$current_user).'</td>';
					}
				}
			}
			else if($value->application_status == 'FilterTestDone')
			{
				$response['datas'] .= '<td><span class="label label-success">Filter Test Done</span></td>';
				$response['datas'] .= '<td>Scored '.$this->get_student_marks($value->requisition_id,$current_user).'</td>';
			}
			else if($value->application_status == 'Selected')
			{
				$response['datas'] .= '<td><span class="label label-info">You are Selected For This Post</span></td>';
				$response['datas'] .= '<td><button type="submit" class="btn btn-block btn-success btn-xs agent_final_selection_basic" data-requisition_id="'.$value->requisition_id.'"><i class="fa fa-commenting"></i></button></td>';
			}
			else if($value->application_status == 'JoinDateDone')
			{
				$response['datas'] .= '<td><span class="label label-danger">**</span><span class="label label-info">Joining Date Done</span><span class="label label-danger">**</span></td>';
				$response['datas'] .= '<td>'.$value->new_joining_date.'</td>';
			}
			else if($value->application_status == 'ScheduleInterview')
			{
				$response['datas'] .= '<td><span class="label label-success">Final Interview Schedule</span></td>';
				$response['datas'] .= '<td></td>';
			}
			else if($value->application_status == 'InterviewMarksComplete')
			{
				$response['datas'] .= '<td>Interview Mark Given</td>';
				$response['datas'] .= '<td><button type="submit" class="btn btn-block btn-success btn-xs agent_final_selection_basic" data-requisition_id="'.$value->requisition_id.'"><i class="fa fa-commenting"></i></button></td>';
			}
			$i++;
		}
		echo json_encode($response);
	}
	
	public function get_student_marks($requisition_id,$user_id)
	{
		$query = $this->db->query('SELECT lt_exam_schedule.user_id,CONCAT(signin.fname," ",signin.lname) AS applicant_name,signin.fusion_id,SUM(lt_questions_ans_options.correct_answer) AS total_correct,lt_exam_schedule.no_of_question FROM `lt_user_exam_answer` LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.id=lt_user_exam_answer.ans_id 
			LEFT JOIN lt_exam_schedule ON lt_exam_schedule.id=lt_user_exam_answer.exam_schedule_id
			LEFT JOIN signin ON signin.id=lt_exam_schedule.user_id
			WHERE lt_exam_schedule.module_id="'.$requisition_id.'" AND signin.id="'.$user_id.'"
			GROUP BY lt_user_exam_answer.exam_schedule_id');
		if($query)
		{
			$row = $query->row();
			return (($row->total_correct / $row->no_of_question) * 100).'%';
		}
		else
		{
			return false;
		}
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
			$absent = $this->getCurrentAttendance();
			$is_consent = $form_data['consent_accept'];
			$consent_comments = $form_data['consent_comments'];
			
			//if(!$absent['status'])
			if($absent['total_count']>1 && $absent['status']==true)
			{
				$query = $this->db->query('INSERT INTO `ijp_requisition_applications`(`requisition_id`, `user_id`, `resume`, `status`,`is_consent`,`consent_comments`, `message`) VALUES ("'.$form_data['requisition_id'].'","'.$current_user.'","'.$file_name.'","Rejected","'.$is_consent.'","'.$consent_comments.'","Rejected for Absenteeism: ('.implode(',',$absent['absent_dates']).')")');
				
			}else{
				if($form_data['filter_type'] == 1)
				{
					$query = $this->db->query('INSERT INTO `ijp_requisition_applications`(`requisition_id`, `user_id`, `resume`, `status`,`is_consent`,`consent_comments`) VALUES ("'.$form_data['requisition_id'].'","'.$current_user.'","'.$file_name.'","Approved","'.$is_consent.'","'.$consent_comments.'")');
				}
				else
				{
					$query = $this->db->query('INSERT INTO `ijp_requisition_applications`(`requisition_id`, `user_id`, `resume`, `status`,`is_consent`,`consent_comments`) VALUES ("'.$form_data['requisition_id'].'","'.$current_user.'","'.$file_name.'","Approved1","'.$is_consent.'","'.$consent_comments.'")');
				}
			}
						
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
		
		$query = $this->db->query('SELECT ijp_requisition_applications.new_joining_date,ijp_requisition_applications.new_l1,CONCAT(new_l1.fname," ",new_l1.lname) AS new_l1_name,ijp_requisition_applications.requisition_id,ijp_requisition_applications.user_id,CONCAT(signin.fname," ",signin.lname) AS user_name,signin.fusion_id,signin.xpoid,department.shname AS dept_name,sub_department.name AS sub_department_name,get_client_names(signin.id) AS client_name,get_process_names(signin.id) AS process_name,CONCAT(l1.fname," ",l1.lname) AS l1_name,signin.doj,DATEDIFF(CURDATE(),signin.doj) AS tenure,ijp_requisitions.raised_by, ijp_requisitions.location_id, ijp_requisitions.hiring_manager_id, ijp_requisitions.filter_type, ijp_requisitions.life_cycle, ijp_requisitions.due_date,ijp_requisition_applications.resume,ijp_requisition_applications.status,lt_exam_schedule.exam_start_time,lt_exam_schedule.id as exam_schedule_id,ijp_interview_schedule.interviewers,ijp_requisition_applications.message FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			LEFT JOIN department ON department.id=signin.dept_id
			LEFT JOIN ijp_requisitions ON ijp_requisition_applications.requisition_id=ijp_requisitions.requisition_id
			LEFT JOIN sub_department ON sub_department.id=signin.sub_dept_id
			LEFT JOIN signin AS l1 ON l1.id=signin.assigned_to
			LEFT JOIN signin AS new_l1 ON new_l1.id=ijp_requisition_applications.new_l1
			LEFT JOIN ijp_interview_schedule ON CONCAT(ijp_requisition_applications.requisition_id,"",ijp_requisition_applications.user_id)=CONCAT(ijp_interview_schedule.requisition_id,"",ijp_interview_schedule.user_id)
			LEFT JOIN lt_exam_schedule ON CONCAT(lt_exam_schedule.module_id,"",lt_exam_schedule.user_id)=CONCAT(ijp_requisition_applications.requisition_id,"",ijp_requisition_applications.user_id)
			WHERE ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'"');
		/* $query = $this->db->query('SELECT ijp_requisition_applications.*,ijp_interview_schedule.interviewers,CONCAT(signin.fname," ",signin.lname) AS user_name,ijp_requisitions.raised_by,ijp_requisitions.hiring_manager_id,ijp_requisitions.filter_type,ijp_requisitions.life_cycle,ijp_requisitions.due_date,lt_exam_schedule.exam_start_time FROM ijp_requisition_applications LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			
			LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id
			LEFT JOIN ijp_interview_schedule ON CONCAT(ijp_requisition_applications.requisition_id,"",ijp_requisition_applications.user_id)=CONCAT(ijp_interview_schedule.requisition_id,"",ijp_interview_schedule.user_id)
			LEFT JOIN lt_exam_schedule ON CONCAT(lt_exam_schedule.module_id,"",lt_exam_schedule.user_id)=CONCAT(ijp_requisition_applications.requisition_id,"",ijp_requisition_applications.user_id)
			WHERE  ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'"'); */
		$rows = $query->result_object();
		
		
		$i=1;
		$response = '';
		foreach($rows as $key=>$value)
		{
			$is_global_access = get_global_access();
			$dept = get_dept_folder();
			$hiring_manager_id_array = explode(',',$value->hiring_manager_id);
			$hirging_manager = false;
			if (in_array($current_user, $hiring_manager_id_array)) {
				$hirging_manager = true;
			}
			
			$trCss="";
			if($value->status=="JoinDateDone") $trCss="trJDD";
						
				$response .= '<tr class="'.$trCss.'">';
				if($value->status == 'Applied')//if applicant applied
				{
					if($dept == 'hr' || $is_global_access == 1)
					{
						$response .= '<td><input type="checkbox" name="bulck_reject[]" class="bulck_reject" value="'.$value->user_id.'"><input type="hidden" name="applications_container_reject_requisition_id" value="'.$value->requisition_id.'" required></td>';
					}
				}
				else if($value->status == 'Approved' && !(strtotime($value->due_date) <= strtotime("now")))// if approved & due date > current date
				{
					if($dept == 'hr' || $is_global_access == 1)
					{
						$response .= '<td><input type="checkbox" name="bulck_reject[]" class="bulck_reject" value="'.$value->user_id.'"><input type="hidden" name="applications_container_reject_requisition_id" value="'.$value->requisition_id.'" required></td>';
					}
				}
				else if($value->status == 'Approved' && (strtotime($value->due_date) <= GetLocalDate() ))// if approved & due date < current date
				{
					if($value->filter_type == 0)
					{
						$response .= '<td><input type="checkbox" name="bulck_reject[]" class="bulck_reject" value="'.$value->user_id.'"><input type="hidden" name="applications_container_reject_requisition_id" value="'.$value->requisition_id.'" required></td>';
					}
					else
					{
						$response .= '<td><input type="checkbox" name="bulck_reject[]" class="bulck_reject" value="'.$value->user_id.'"><input type="hidden" name="applications_container_reject_requisition_id" value="'.$value->requisition_id.'" required></td>';
					}
				}
				else if($value->status == 'Approved1' && !(strtotime($value->due_date) <= GetLocalDate()))// if approved & due date > current date
				{
					$response .= '<td><input type="checkbox" name="bulck_reject[]" class="bulck_reject" value="'.$value->user_id.'"><input type="hidden" name="applications_container_reject_requisition_id" value="'.$value->requisition_id.'" required></td>';
				}
				else if($value->status == 'Approved1' && (strtotime($value->due_date) <= GetLocalDate() ))// if approved & due date < current date
				{
					$response .= '<td><input type="checkbox" name="bulck_reject[]" class="bulck_reject" value="'.$value->user_id.'"><input type="hidden" name="applications_container_reject_requisition_id" value="'.$value->requisition_id.'" required></td>';
				}
				else
				{
					$response .= '<td></td>';
				}
				$response .= '<td>'.$i.'</td>';
				$response .= '<td>'.$value->user_name.'</td>';
				$response .= '<td>'.$value->fusion_id.'</td>';
				$response .= '<td>'.$value->location_id.'</td>';
				$response .= '<td>'.$value->dept_name.'</td>';
				$response .= '<td>'.$value->sub_department_name.'</td>';
				$response .= '<td>'.$value->client_name.'</td>';
				$response .= '<td>'.$value->process_name.'</td>';
				$response .= '<td>'.$value->l1_name.'</td>';
				$response .= '<td>'.$value->doj.'</td>';
				$response .= '<td>'.$value->tenure.'</td>';
				$response .= '<td><a href="'.base_url("uploads/progression_resume/").'/'.$value->resume.'" target="_blank">'.$value->resume.'</a></td>';
				
				if($value->status == 'Applied')//if applicant applied
				{
					if($dept == 'hr' || $is_global_access == 1)
					{
						$response .= '<td><button class="btn btn-xs btn-success approve_application" title="Approve Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-check-square" aria-hidden="true"></i></button>&nbsp;<button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
					}
				}
				else if($value->status == 'Approved' && !(strtotime($value->due_date) <= GetLocalDate()))// if approved & due date > current date
				{
					if($dept == 'hr' || $is_global_access == 1)
					{
						$response .= '<td><button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
					}
				}
				else if($value->status == 'Approved' && (strtotime($value->due_date) <= GetLocalDate() ))// if approved & due date < current date
				{
					if($value->filter_type == 0)
					{
						//$response .= '<td>Waiting For Final Interview&nbsp;<button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
						//$response .= '<td>Waiting For Final Interview</td>';
						$response .= '<td><button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
					}
					else
					{
						//$response .= '<td>Waiting For Filter Test&nbsp;<button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
						//$response .= '<td>Waiting For Filter Test</td>';
						$response .= '<td><button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
					}
				}
				else if($value->status == 'Approved1' && !(strtotime($value->due_date) <= GetLocalDate()))// if approved & due date > current date
				{
					$response .= '<td><button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
				}
				else if($value->status == 'Approved1' && (strtotime($value->due_date) <= GetLocalDate()))// if approved & due date < current date
				{
					//$response .= '<td>Waiting For Final Interview</td>';
					$response .= '<td><button class="btn btn-xs btn-danger reject_application_btn" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
				}
				else if($value->status == 'Rejected' && !(strtotime($value->due_date) <= GetLocalDate() ))
				{
					if($dept == 'hr' || $is_global_access == 1)
					{
						//$response .= '<td><button class="btn btn-xs btn-success approve_application" title="Approve Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-check-square" aria-hidden="true"></i></button></td>';
					}
					$response .= '<td width="20%">'.$value->message.'</td>';
				}
				else if($value->status == 'Rejected' && (strtotime($value->due_date) <= GetLocalDate()))
				{
					$response .= '<td>Rejected</td>';
				}
				else if($value->status == 'AbsentRejected')
				{
					$response .= '<td width="20%">'.$value->message.'</td>';
				}
				else if($value->status == 'ScheduleInterview')
				{
					if($value->life_cycle == 'ISC')
					{
						$response .= '<td>Interview Marks Pending</td>';
					}
					else
					{
						$response .= '<td>Interview Scheduled</td>';
					}
				}
				else if($value->status == 'FilterScheCompl')
				{
					$response .= '<td>Filter Test Scheduled at <b>'.$value->exam_start_time.'</b>&nbsp;<button class="btn btn-xs btn-danger reject_filtertest_btn" title="Reject Filter Test" data-exam_schedule_id="'.$value->exam_schedule_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
					
				}
				else if($value->status == 'MisFiltTest')
				{
					$response .= '<td>Didn\'t Attend Filter Test</td>';
					
				}
				else if($value->status == 'FilterTestDone')
				{
					$response .= '<td>Filter Test Done</td>';
				}
				else if($value->status == 'Selected')
				{
					$response .= '<td>Candidate Selected</td>';
				}
				else if($value->status == 'JoinDateDone')
				{
					$response .= "<td>Joining Date <b>.$value->new_joining_date. ($value->new_l1_name)</b>";
										
					if(isIndiaLocation($value->location_id)==true){
						$response .= "&nbsp; <a href=". base_url() ."letter/view_ijp_letter?uid=". $value->user_id ."&sm=D title='Download IJP Confirmation Letter' class='btn btn-success btn-xs'><i class='fa fa-download' aria-hidden='true'></i></a>&nbsp <a href=". base_url() ."letter/view_ijp_letter?uid=". $value->user_id ."&sm=Y title='Email IJP  Confirmation Letter' class='btn btn-success btn-xs'><i class='fa fa-envelope' aria-hidden='true'></i></a>";
					}
					
					$response .= "</td>";
					
				}
				else if($value->status == 'InterviewMarksComplete')
				{
					if($hirging_manager == true || $is_global_access == 1)
					{
						//$response .= '<td>Waiting For Final Selection&nbsp;<button class="btn btn-xs btn-default re_schedule_interview" data-requisition_id="'.$value->requisition_id.'" title="Re-Schedule Interview" data-user_id="'.$value->user_id.'" data-filter_test="'.$value->filter_type.'">Re-Schedule Interview</button></td>';
						$response .= '<td>Waiting For Final Selection</td>';
					}
				}
				else if($value->status == 'FilterTestCompl')
				{
					if($hirging_manager == true || $is_global_access == 1)
					{
						//$response .= '<td>Filter Test Complete&nbsp;<button class="btn btn-xs btn-default re_schedule_filter_test" data-requisition_id="'.$value->requisition_id.'" title="Re-Schedule Filter Test" data-user_id="'.$value->user_id.'">Re-Schedule  Filter Test</button></td>';
						$response .= '<td>Filter Test Complete</td>';
					}
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
	
	public function bulck_reject()
	{
		$form_data = $this->input->post();
		foreach($form_data['bulck_reject'] as $key=>$value)
		{
			$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "Rejected", message="'.$form_data['applications_container_reject_comment'].'" WHERE requisition_id="'.$form_data['applications_container_reject_requisition_id'].'" and user_id="'.$value.'"');
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
				$value_array[] = '("'.$form_data['requisition_id'].'","'.$value.'","'.$form_data['interview_schedulue_time'].'","'.$current_user.'","'.date('Y-m-d').'","'.implode(',',$form_data['interviewers']).'")';
				
				$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="ScheduleInterview" WHERE user_id="'.$value.'" AND requisition_id="'.$form_data['requisition_id'].'"');
				foreach($form_data['interviewers'] as $ikey=>$ivalue)
				{
					$this->db->query('INSERT INTO `ijp_interview_score`(`requisition_id`, `user_id`, `interviewer_id`) VALUES ("'.$form_data['requisition_id'].'","'.$value.'","'.$ivalue.'")');
				}
				
			}
			$query = $this->db->query('INSERT INTO `ijp_interview_schedule`(`requisition_id`, `user_id`, `schedule_datetime`, `added_by`, `added_date`,`interviewers`) VALUES '.implode(',',$value_array).'');
			foreach($form_data['select_for_interview'] as $key=>$value)
			{
				$this->Email_model->send_interview_schedule_email($form_data['location_id'],$current_user,$value,$form_data['requisition_id'],$form_data['hiring_manager_id']);
			}
			foreach($form_data['interviewers'] as $ikey=>$ivalue)
			{
				$hm_array = explode(',',$form_data['hiring_manager_id']);
				if (!in_array($ivalue, $hm_array))
				{
					$this->Email_model->send_interview_panel_schedule_email($form_data['location_id'],$current_user,$ivalue,$form_data['requisition_id'],$form_data['hiring_manager_id'],$form_data['interview_schedulue_time']);
				}
			}
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
		
		$query_interview_status_left = $this->db->query('SELECT COUNT(*) AS interview_status_left FROM `ijp_interview_schedule` LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,"",ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,"",ijp_interview_schedule.user_id) WHERE ijp_interview_score.overall_interview_score IS NULL AND ijp_interview_score.requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function re_schedule_interview()
	{
		$form_data = $this->input->post();
		$this->db->trans_start();
		if($form_data['filter_test'] == 1)
		{
			$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="AC1" WHERE requisition_id="'.$form_data['requisition_id'].'"');
			$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="Approved1" WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		}
		else
		{
			$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`="AC" WHERE requisition_id="'.$form_data['requisition_id'].'"');
			$this->db->query('UPDATE `ijp_requisition_applications` SET `status`="Approved" WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		}
		
		//$this->db->query('UPDATE `ijp_interview_score` SET `overall_interview_score`= null, remarks=null WHERE user_id="'.$form_data['user_id'].'" AND requisition_id="'.$form_data['requisition_id'].'"');
		$this->db->query('DELETE FROM ijp_interview_schedule WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$form_data['user_id'].'"');
		$this->db->query('DELETE FROM ijp_interview_score WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$form_data['user_id'].'"');
		
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
		
			/* $query = $this->db->query('SELECT ijp_interview_schedule.*,CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id FROM `ijp_interview_schedule` LEFT JOIN signin ON signin.id=ijp_interview_schedule.user_id
				LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,ijp_interview_schedule.user_id)
				WHERE FIND_IN_SET('.$current_user.',ijp_interview_schedule.interviewers) AND ijp_interview_score.interviewer_id='.$current_user.' AND ijp_interview_score.overall_interview_score IS NULL AND ijp_interview_schedule.interview_status="0" ORDER BY ijp_interview_schedule.schedule_datetime DESC'); */
			
			
			//will be used the below query
			
			$qSql = 'SELECT ijp_interview_schedule.*,CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id FROM `ijp_interview_schedule` LEFT JOIN signin ON signin.id=ijp_interview_schedule.user_id
				LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,ijp_interview_schedule.user_id)
				WHERE FIND_IN_SET('.$current_user.',ijp_interview_schedule.interviewers) AND ijp_interview_score.interviewer_id='.$current_user.' AND ijp_interview_score.overall_interview_score IS NULL AND ijp_interview_schedule.interview_status="0" AND ijp_interview_schedule.schedule_datetime <= "'.ConvServerToLocal(date('Y-m-d H:i:s')).'" ORDER BY ijp_interview_schedule.schedule_datetime DESC';
				
			$query = $this->db->query($qSql);
			
			//echo $qSql;
		
		
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
		
			$query = $this->db->query('SELECT ijp_interview_schedule.*,CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id, role_organization.name AS new_org_designation, role.name AS new_designation, department.shname AS dept_name FROM `ijp_interview_schedule` 
				LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_interview_schedule.requisition_id
				LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
				LEFT JOIN role ON role.id=ijp_requisitions.role_id
				LEFT JOIN department ON department.id=ijp_requisitions.dept_id
				LEFT JOIN signin ON signin.id=ijp_interview_schedule.user_id
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
						
		if(get_global_access() ==1 || get_dept_folder()=="hr" || get_role_dir()=="admin"  || get_role_dir()=="manager" || get_role_dir()=="tl" ||  is_approve_requisition()==true )
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
		$query = $this->db->query('SELECT signin.id, office_id, CONCAT(signin.fname," ",signin.lname) as name FROM `signin` WHERE FIND_IN_SET(signin.id,(SELECT ijp_requisitions.hiring_manager_id FROM ijp_requisitions WHERE requisition_id="'.$form_data['requisition_id'].'"))');
		
		if(isIndiaLocation($form_data['office_id'])==true){
			$hr_query = $this->db->query('SELECT signin.id, office_id, CONCAT(signin.fname," ",signin.lname) as name FROM `signin` WHERE dept_id=3 AND office_id in ("'.$form_data['office_id'].'","KOL") and status=1 ');
		}else{
			$hr_query = $this->db->query('SELECT signin.id,office_id, CONCAT(signin.fname," ",signin.lname) as name FROM `signin` WHERE dept_id=3 AND office_id="'.$form_data['office_id'].'" and status=1 ');
		}
		
		$get_req_query = $this->db->query('SELECT client_id,dept_id FROM `ijp_requisitions` WHERE requisition_id="'.$form_data['requisition_id'].'"');

		$row = $get_req_query->row();
		if($row->client_id == '')
		{
			if(isIndiaLocation($form_data['office_id'])==true){
				$np_query = $this->db->query('SELECT signin.id, office_id, CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
				LEFT JOIN role ON role.id=signin.role_id
				WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id in ("'.$form_data['office_id'].'","KOL") AND dept_id != "'.$row->client_id.'" AND dept_id != "3" AND status=1 ');
			
			}else{
				$np_query = $this->db->query('SELECT signin.id, office_id, CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
				LEFT JOIN role ON role.id=signin.role_id
				WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id="'.$form_data['office_id'].'" AND dept_id != "'.$row->client_id.'" AND dept_id != "3" AND status=1 ');
			}
		}
		else
		{
			if(isIndiaLocation($form_data['office_id'])==true){
				$np_query = $this->db->query('SELECT signin.id, office_id, CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
				LEFT JOIN role ON role.id=signin.role_id
				WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id in ("'.$form_data['office_id'].'","KOL") AND NOT FIND_IN_SET('.$row->client_id.',get_client_ids(signin.id)) AND dept_id != "3" AND status=1');

			}else{
				$np_query = $this->db->query('SELECT signin.id,office_id, CONCAT(signin.fname," ",signin.lname) AS name FROM `signin`
				LEFT JOIN role ON role.id=signin.role_id
				WHERE role.folder="manager" AND role.is_active=1 AND signin.office_id="'.$form_data['office_id'].'" AND NOT FIND_IN_SET('.$row->client_id.',get_client_ids(signin.id)) AND dept_id != "3" AND status=1');
			}
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
		$query_interview_status_left = $this->db->query('SELECT COUNT(*) AS interview_status_left FROM `ijp_interview_schedule` LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,"",ijp_interview_score.user_id)=CONCAT(ijp_interview_schedule.requisition_id,"",ijp_interview_schedule.user_id) WHERE ijp_interview_score.overall_interview_score IS NULL AND ijp_interview_score.requisition_id="'.$form_data['requisition_id'].'"');
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
		
		/* $query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id,CONCAT(interviewer.fname," ",interviewer.lname) AS interviewer_name,ijp_interview_score.overall_interview_score,ijp_interview_score.remarks FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_requisition_applications.requisition_id,ijp_requisition_applications.user_id)
		LEFT JOIN signin AS interviewer ON interviewer.id=ijp_interview_score.interviewer_id WHERE ijp_requisition_applications.status="InterviewMarksComplete" AND ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'" ORDER BY ijp_requisition_applications.user_id ASC'); */

$query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id,CONCAT(interviewer.fname," ",interviewer.lname) AS interviewer_name,ijp_interview_score.overall_interview_score,ijp_interview_score.remarks,ijp_requisition_applications.status FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id INNER JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_requisition_applications.requisition_id,ijp_requisition_applications.user_id)
LEFT JOIN signin AS interviewer ON interviewer.id=ijp_interview_score.interviewer_id WHERE ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'" and ijp_requisition_applications.status !="Rejected" ORDER BY ijp_requisition_applications.user_id ASC');

		if($query)
		{
			$response['stat'] = true;
			$result = $query->result_object();
			$info_array = array();
			foreach($result as $key=>$value)
			{
								
				$info_array[$value->fusion_id]['id'] = $value->id;
				$info_array[$value->fusion_id]['status'] = $value->status;
				$info_array[$value->fusion_id]['name'] = $value->name;
				$info_array[$value->fusion_id]['fusion_id'] = $value->fusion_id;
				$info_array[$value->fusion_id]['interviewer_name'][] = $value->interviewer_name;
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
	
	public function get_final_selection_agent()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		/* $query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id,CONCAT(interviewer.fname," ",interviewer.lname) AS interviewer_name,ijp_interview_score.overall_interview_score,ijp_interview_score.remarks FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_requisition_applications.requisition_id,ijp_requisition_applications.user_id)
LEFT JOIN signin AS interviewer ON interviewer.id=ijp_interview_score.interviewer_id WHERE ijp_requisition_applications.status="InterviewMarksComplete" AND ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'" ORDER BY ijp_requisition_applications.user_id ASC'); */
$query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS name,signin.fusion_id,CONCAT(interviewer.fname," ",interviewer.lname) AS interviewer_name,ijp_interview_score.overall_interview_score,ijp_interview_score.remarks FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id LEFT JOIN ijp_interview_score ON CONCAT(ijp_interview_score.requisition_id,ijp_interview_score.user_id)=CONCAT(ijp_requisition_applications.requisition_id,ijp_requisition_applications.user_id)
LEFT JOIN signin AS interviewer ON interviewer.id=ijp_interview_score.interviewer_id WHERE ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'" AND ijp_requisition_applications.user_id="'.$current_user.'" ORDER BY ijp_requisition_applications.user_id ASC');
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
				$info_array[$value->fusion_id]['interviewer_name'][] = $value->interviewer_name;
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
		$current_user = get_user_id();
		if($scrp == true)
		{
			//"SCRP"=>NO selection but closed by hirging manager
			$query = $this->db->query('UPDATE ijp_requisitions SET life_cycle="SCRP" WHERE requisition_id="'.$form_data['requisition_id'].'"');
			$this->db->query('UPDATE ijp_requisition_applications SET status="Rejected",message="Position Scrap By Manager" WHERE requisition_id="'.$form_data['requisition_id'].'" AND status="InterviewMarksComplete"');
		}
		else
		{
			//"CLS"=>Selection and Close
			
			foreach($form_data['select_candidate'] as $key=>$value)
			{
				$qSql='UPDATE ijp_requisition_applications SET status="Selected" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$value.'"';
							
				$this->db->query($qSql);
				
				$query = $this->db->query('SELECT email_id_off,email_id_per FROM info_personal WHERE user_id="'.$value.'"');
				$row = $query->row();
				$this->Email_model->send_selection_email($form_data['location'],$current_user,$row->email_id_off,$value,$form_data['requisition_id'],$form_data['hiring_manager_id']);
				
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
		
		$query1 = $this->db->query('SELECT * FROM `lt_examination` WHERE location = "'.$form_data['location'].'" AND type="IJP" AND status=1');
		
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
		
		$query_set = $this->db->query('SELECT lt_question_set.id,count(lt_questions.id) AS available_question FROM lt_question_set INNER JOIN lt_questions ON lt_questions.set_id=lt_question_set.id WHERE lt_question_set.exam_id="'.$form_data['exam'].'" and lt_question_set.status=1 AND lt_question_set.id NOT IN(SELECT allotted_set_id FROM `lt_exam_schedule` WHERE lt_exam_schedule.module_id="'.$form_data['requisition_id'].'") GROUP BY lt_question_set.id ORDER BY RAND() LIMIT 1');
		
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
			$query_set = $this->db->query('SELECT lt_question_set.id,count(lt_questions.id) AS available_question FROM lt_question_set INNER JOIN lt_questions ON lt_questions.set_id=lt_question_set.id WHERE lt_question_set.exam_id="'.$form_data['exam'].'" and lt_question_set.status=1 GROUP BY lt_question_set.id ORDER BY RAND() LIMIT 1');
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
				$response['message'] = 'Set Available but no question under set';
			}
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
		
		$this->db->query('DELETE FROM `lt_user_exam_answer` WHERE exam_schedule_id="'.$row->id.'"');
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
		$thresh_hold_corssed = false;
		foreach($rows as $key=>$value)
		{
			if(round((($value->total_correct * 100)/$value->no_of_question),1) >= $form_data['limit'])
			{
				$thresh_hold_corssed = true;
				$this->db->query('UPDATE ijp_requisition_applications SET status="Approved1" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$value->user_id.'"');
			}
			else
			{
				$this->db->query('UPDATE ijp_requisition_applications SET status="Rejected", message="Filter Test Threshold Not Cleared" WHERE requisition_id="'.$form_data['requisition_id'].'" AND user_id="'.$value->user_id.'"');
			}
		}
		if($thresh_hold_corssed == true)
		{
			$this->db->query('UPDATE ijp_requisitions SET life_cycle="AC1" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		}
		else
		{
			$this->db->query('UPDATE ijp_requisitions SET life_cycle="SCRP" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function get_scheduled_time()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT id,exam_start_time FROM `lt_exam_schedule` WHERE exam_status = 0 and module_id="'.$form_data['requisition_id'].'" GROUP BY exam_start_time ' );
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
	public function get_scheduled_candidates()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT lt_exam_schedule.id,lt_exam_schedule.user_id,CONCAT(signin.fname," ",signin.lname) AS candidate_name,signin.fusion_id FROM `lt_exam_schedule` LEFT JOIN signin ON signin.id=lt_exam_schedule.user_id WHERE module_id="'.$form_data['requisition_id'].'" AND exam_start_time="'.$form_data['scheduled_exam_time'].'" AND exam_status=0');
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
	public function start_exam()
	{
		$form_data = $this->input->post();
		foreach($form_data['candiates'] as $key=>$value)
		{
			$query = $this->db->query('UPDATE lt_exam_schedule SET exam_status="2" WHERE module_id="'.$form_data['requisition_id'].'" AND user_id="'.$value.'"');
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
	
	public function get_selected_candidate()
	{
		$form_data = $this->input->post();
		
		$selected_candidate_query = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS candidate_name,signin.fusion_id FROM `ijp_requisition_applications`
			LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			WHERE ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'" AND ijp_requisition_applications.status="Selected"');
			
		$query = $this->db->query('SELECT * FROM ijp_requisitions WHERE requisition_id="'.$form_data['requisition_id'].'"');
		$row = $query->row();
		
		if($form_data['ffunction'] == "Support")
		{
			//$query_tl = $this->db->query('SELECT * FROM `signin` LEFT JOIN role_organization ON role_organization.id=signin.org_role_id WHERE signin.dept_id="'.$row->dept_id.'" AND signin.sub_dept_id="'.$row->sub_debt_id.'" AND role_organization.controller IN("tl","manager","super","admin")');
			$location = substr($form_data['requisition_id'],1,3);
			//$query_tl = $this->db->query('SELECT * FROM `signin` LEFT JOIN role_organization ON role_organization.id=signin.org_role_id WHERE signin.dept_id="'.$row->dept_id.'" AND role_organization.controller IN("tl","manager","super","admin") AND signin.office_id LIKE "%'.$location.'%"');
			$query_tl = $this->db->query('SELECT signin.*,department.shname FROM `signin` LEFT JOIN department ON department.id=signin.dept_id LEFT JOIN role_organization ON role_organization.id=signin.org_role_id WHERE role_organization.controller IN("tl","manager","super","admin") AND signin.office_id LIKE "%'.$location.'%"');
		}
		else
		{
			//$query_tl = $this->db->query('SELECT signin.id,signin.fname,signin.lname FROM `signin` LEFT JOIN role_organization ON role_organization.id=signin.org_role_id WHERE FIND_IN_SET('.$row->client_id.',get_client_ids(signin.id)) AND FIND_IN_SET('.$row->process_id.',get_process_ids(signin.id)) AND role_organization.controller IN("tl","manager","super","admin")');
			$location = substr($form_data['requisition_id'],1,3);
			//$query_tl = $this->db->query('SELECT signin.id,signin.fname,signin.lname,signin.fusion_id FROM `signin` LEFT JOIN role_organization ON role_organization.id=signin.org_role_id WHERE FIND_IN_SET('.$row->client_id.',get_client_ids(signin.id)) AND role_organization.controller IN("tl","manager","super","admin") AND signin.office_id LIKE "%'.$location.'%"');
			$query_tl = $this->db->query('SELECT signin.id,signin.fname,signin.lname,signin.fusion_id,department.shname FROM `signin` LEFT JOIN department ON department.id=signin.dept_id LEFT JOIN role_organization ON role_organization.id=signin.org_role_id WHERE role_organization.controller IN("tl","manager","super","admin") AND signin.office_id LIKE "%'.$location.'%"');
		}
		//$query = $this->db->query('UPDATE ijp_requisition_applications SET new_joining_date="2",new_l1 WHERE requisition_id="'.$form_data['requisition_id'].'"');
		
		if($query)
		{
			$response['stat'] = true;
			$response['datas']['user_list'] = $selected_candidate_query->result_object();
			$response['datas']['tl'] = $query_tl->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function set_joing_date()
	{
		$form_data = $this->input->post();
		$this->db->trans_begin();
		foreach($form_data['candiate_id'] as $key=>$value)
		{
			$this->db->query('UPDATE ijp_requisition_applications SET new_joining_date="'.$form_data['new_joining_date'][$key].'",new_l1="'.$form_data['new_l1'][$key].'",status="JoinDateDone" WHERE user_id="'.$value.'" AND requisition_id="'.$form_data['requisition_id'].'"');
		}
		$this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "JDD" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		if ($this->db->trans_status() === FALSE)
		{
			$response['stat'] = false;
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			$response['stat'] = true;
		}
		echo json_encode($response);
	}
	
	public function update_due_date()
	{
		$form_data = $this->input->post();
		
		$query = $this->db->query('UPDATE `ijp_requisitions` SET job_desc = "'.$form_data['job_desc'].'" , due_date = "'.$form_data['due_date'].'" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		
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
	
	public function get_edit_requisition_data()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT * FROM ijp_requisitions WHERE requisition_id="'.$form_data['requisition_id'].'"');
		$row = $query->row();
		
		if($row->client_id != null)
		{
			$query1 = $this->db->query('SELECT * FROM process WHERE client_id = "'.$row->client_id.'"');
		}
		else
		{
			$query1 = $this->db->query('SELECT * FROM sub_department WHERE dept_id = "'.$row->dept_id.'"');
		}
		
		$office_id = $row->location_id;
		
				
		if( isIndiaLocation($office_id) == true)
		{
			$office_id = "'KOL','HWH','BLR','NOI','CHE'";
		}
		else
		{
			$office_id = "'".$office_id."'";
		}
		
		$query2 = $this->db->query('SELECT signin.id, CONCAT(signin.fname," ",signin.lname) AS name , office_id, (Select shname from department where department.id=signin.dept_id) as dept_name FROM `signin`
			LEFT JOIN role ON role.id=signin.role_id
			WHERE (role.folder in ("manager","admin") AND role.is_active=1 AND signin.status in (1,4) AND signin.office_id in ('. $office_id . ')) OR is_global_access=1 ');
			
		if ($query)
		{
			$response['stat'] = true;
			$response['datas']['requistion_data'] = $row;
			$response['datas']['process_data'] = $query1->result_object();
			$response['datas']['hiring_manage_data'] = $query2->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		
		echo json_encode($response);
	}
	
	public function ijp_creation_email()
	{
		//$this->Email_model->new_ijp("KOL","IKOL2019001");
	}
	
	public function auto_role_change()
	{ 
		
		$queryString = 'SELECT ijp_requisition_applications.user_id,ijp_requisition_applications.new_l1,signin.assigned_to AS old_l1,ijp_requisitions.ffunction,l1_signin.dept_id AS l1_dept,l1_signin.sub_dept_id AS l1_sub_dept,get_client_ids(l1_signin.id) AS l1_client,get_process_ids(l1_signin.id) AS l1_process,ijp_requisitions.client_id AS requisition_client,ijp_requisitions.process_id AS requisition_process,ijp_requisitions.new_designation_id,signin.role_id as old_role_id,signin.org_role_id as old_org_role_id,signin.dept_id as old_dept_id,signin.sub_dept_id as old_sub_debt_id,get_client_ids(signin.id) as old_client_id, get_process_ids(signin.id) as old_process_id,ijp_requisitions.role_id as new_role_id FROM `ijp_requisition_applications`
		LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
		LEFT JOIN signin AS l1_signin ON l1_signin.id=signin.assigned_to
		LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id
		WHERE ijp_requisition_applications.new_joining_date="'.date('Y-m-d').'" AND ijp_requisition_applications.status="JoinDateDone"';
		
		$query = $this->db->query($queryString);
		if($query->num_rows() > 0)
		{
			$update_info = $query->result_object();
			foreach($update_info as $key=>$value)
			{
				$update_signin = $this->db->query('UPDATE signin SET assigned_to="'.$value->new_l1.'",dept_id="'.$value->l1_dept.'",sub_dept_id="'.$value->l1_sub_dept.'" WHERE id="'.$value->user_id.'"');
				if($update_signin)
				{
					$log=get_logs();
					$history_array = array(
						"user_id" => $value->user_id,
						"h_type" => 5,
						"from_id" => $value->old_l1,
						"to_id" => $value->new_l1,
						"affected_date" => date('Y-m-d'),
						"comments" => 'IJP',
						"event_date" => date('Y-m-d'),
						"event_by" => 'Cron Job',
						"log" => $log,
					);
					$rowid= data_inserter('history_emp_all',$history_array);
					
					$history_array = array(
						"user_id" => $value->user_id,
						"h_type" => 3,
						"from_id" => $value->old_dept_id,
						"to_id" => $value->l1_dept,
						"affected_date" => date('Y-m-d'),
						"comments" => 'IJP',
						"event_date" => date('Y-m-d'),
						"event_by" => 'Cron Job',
						"log" => $log,
					);
					$rowid= data_inserter('history_emp_all',$history_array);
					
					$history_array = array(
						"user_id" => $value->user_id,
						"h_type" => 3,
						"from_id" => $value->old_sub_debt_id,
						"to_id" => $value->l1_sub_dept,
						"affected_date" => date('Y-m-d'),
						"comments" => 'IJP',
						"event_date" => date('Y-m-d'),
						"event_by" => 'Cron Job',
						"log" => $log,
					);
					$rowid= data_inserter('history_emp_all',$history_array);
					
					$history_array = array(
						"user_id" => $value->user_id,
						"h_type" => 1,
						"from_id" => $value->old_role_id,
						"to_id" => $value->new_role_id,
						"affected_date" => date('Y-m-d'),
						"comments" => 'IJP',
						"event_date" => date('Y-m-d'),
						"event_by" => 'Cron Job',
						"log" => $log,
					);
					$rowid= data_inserter('history_emp_all',$history_array);
					
					$existing_client = $this->db->query('SELECT * FROM info_assign_client WHERE user_id="'.$value->user_id.'"');
					if($existing_client->num_rows() > 0)
					{
						$update_info_client = $this->db->query('UPDATE info_assign_client SET client_id="'.$value->requisition_client.'" WHERE user_id="'.$value->user_id.'"');
					}
					else
					{
						$update_info_client = $this->db->query('INSERT INTO info_assign_client(client_id,user_id) VALUES("'.$value->requisition_client.'","'.$value->user_id.'")');
					}
					if($update_info_client)
					{
						$log=get_logs();
						$history_array = array(
							"user_id" => $value->user_id,
							"h_type" => 4,
							"from_id" => $value->old_client_id,
							"to_id" => $value->requisition_client,
							"affected_date" => date('Y-m-d'),
							"comments" => 'IJP',
							"event_date" => date('Y-m-d'),
							"event_by" => 'Cron Job',
							"log" => $log,
						);
						$rowid= data_inserter('history_emp_all',$history_array);
						
						$existing_process = $this->db->query('SELECT * FROM info_assign_process WHERE user_id="'.$value->user_id.'"');
						if($existing_process->num_rows() > 0)
						{
							$update_info_process = $this->db->query('UPDATE info_assign_process SET process_id="'.$value->requisition_process.'" WHERE user_id="'.$value->user_id.'""');
						}
						else
						{
							$update_info_client = $this->db->query('INSERT INTO info_assign_process(process_id,user_id) VALUES("'.$value->requisition_process.'","'.$value->user_id.'")');
						}
						
						if($update_info_process)
						{
							$log=get_logs();
							$process_id_array = explode(',',$value->old_process_id);
							$history_array = array(
								"user_id" => $value->user_id,
								"h_type" => 2,
								"from_id" => $process_id_array[0],
								"to_id" => $value->requisition_process,
								"affected_date" => date('Y-m-d'),
								"comments" => 'IJP',
								"event_date" => date('Y-m-d'),
								"event_by" => 'Cron Job',
								"log" => $log,
							);
							$rowid= data_inserter('history_emp_all',$history_array);
						}
					}
				}
			}
		}
	}
	
	//=================== RELOCATION CONSENT ============================//
	public function ijp_consent_application()
	{
		$currentUser = get_user_id();
		$requistionID = $this->input->post('rid');
		
		$sqlConsentIds = "SELECT is_consent as value from ijp_requisitions WHERE requisition_id = '$requistionID'";
		$queryConsentIds = $this->Common_model->get_single_value($sqlConsentIds);
		if(!empty($requistionID)){
		if($queryConsentIds != "")
		{
			$consentIds = explode(',', $queryConsentIds);
			if(in_array($currentUser, $consentIds)){
			} else {
				$updateIds = $queryConsentIds."," .$currentUser;
				$sqlUpdate = "UPDATE ijp_requisitions SET is_consent = '$updateIds' WHERE  requisition_id = '$requistionID'";
				$this->db->query($sqlUpdate);
			}
		} else {
			$sqlUpdate = "UPDATE ijp_requisitions SET is_consent = '$currentUser' WHERE  requisition_id = '$requistionID'";
			$this->db->query($sqlUpdate);
		}
		}
		$response['stat'] = true;			
		$response['id'] = $requistionID;			
		echo json_encode($response);
	}
}
?>
