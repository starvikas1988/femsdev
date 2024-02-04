<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ijp extends CI_Controller {

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
			
			$data["aside_template"] = "ijp/aside.php";
			if( get_dept_folder()=="wfm" || get_dept_folder()=="hr" || get_role_dir()=="super"  || get_role_dir()=="manager"|| is_approve_requisition()==true )
			{
				$data["content_template"] = "ijp/manage_ijp.php";
			}
			else
			{
				redirect('ijp/apply', 'refresh');
				
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
				$search_query = ' WHERE ijp_requisitions.location_id="'.$location.'"';
			}
			
			$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,ijp_request_reason.request_reason,ijp_requisitions.life_cycle,(SELECT COUNT(*) FROM ijp_requisition_applications WHERE ijp_requisition_applications.status IS NOT NULL and ijp_requisition_applications.requisition_id=ijp_requisitions.requisition_id) as total_application FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id '.$search_query.' ORDER BY id DESC');
			return $query->result_object();
		}
		
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
			//get org role id
			$query = $this->db->query('SELECT role_organization.id,role_organization.name,role_organization.controller,role_organization.rank FROM `role_organization`
				LEFT JOIN role ON role.org_role=role_organization.id WHERE role.id='.get_role_id().'');
			$data["org_role_info"] = $query->row();
			
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
				$data['req_result'] = $this->get_apply_ijp('',$data["org_role_info"]->rank);
			}else{
				$data['req_result'] = $this->get_apply_ijp($user_office_id,$data["org_role_info"]->rank);
			}
			
			$query = $this->db->query('SELECT * FROM `role_organization` WHERE controller != "super"');
			$data['new_desig'] = $query->result_object();
			
			$query = $this->db->query('SELECT * FROM ijp_request_reason ');
			$data['req_reason'] = $query->result_object();
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function getCurrentAttendance(){
		
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$user_fusion_id = get_user_fusion_id();	
			$currDate=CurrDate();
			
			$start_date = CurrDateMDY();
			$end_date = CurrDateMDY();
			
			$prevMonth = date('m', strtotime($currDate))-1;
			$currYear = strtolower(date('Y', strtotime($currDate)));
			
			//echo "prevMonth :: " . $prevMonth;
			
			if($prevMonth==12) $start_date =$prevMonth."-26-".($currYear-1);
			else $start_date =$prevMonth."-26-".$currYear;
			
			//echo "start_date :: " . $start_date;
			//echo "\r\n end_date :: " . $currDate;
						
			$start_date = date('m-d-Y', strtotime('-6 month', time())); 
			
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
			 			 
			return get_attendence($this->reports_model->get_user_list_report($filterArray));
			
			
		}
	}
	
	public function get_attendence($attan_dtl)
	{
		$pDate=0;
		$absent = false;
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
			if($rdate == $todayLoginArray[0]){
				
				$flogin_time = $todayLoginTime;
				$flogin_time_local = ConvServerToLocalAny($todayLoginTime,$office_id);
				
				$disposition="online";
				
				$net_work_time="";
				
				$net_work_time_local="";
				
				$total_break = "";
				$total_break_local="";
				$tBrkTime = "";
				$tBrkTimeLocal = "";
				$ldBrkTime = "";
				$ldBrkTimeLocal = "";
				$logout_time="";
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
				$absent = true;
				break;
			}
		}
		return $absent;
	}
	
	public function get_apply_ijp($location='ALL',$current_user_rank)
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
				$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.client_id IN('.$get_client_ids.') and ijp_requisitions.process_id IN('.$get_process_ids.')) OR ijp_requisitions.posting_type="E")';
			}
			else
			{
				$search_query = ' AND ijp_requisitions.location_id="'.$location.'" AND ((ijp_requisitions.posting_type="I" and ijp_requisitions.dept_id IN('.$get_dept_id.') AND sub_debt_id='.$sub_debt_id.') OR ijp_requisitions.posting_type="E")';
			}
			$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,role_organization.rank as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id

			WHERE ijp_requisitions.requisition_id NOT IN(SELECT requisition_id FROM ijp_requisition_applications WHERE user_id="'.$current_user.'")  AND life_cycle !="OPN" '.$search_query.' ORDER BY id DESC');

		}
		else
		{
			$query = $this->db->query('SELECT ijp_requisitions.*,client.shname AS client_name,process.name AS process_name,department.shname AS dept_name,sub_department.name AS sub_dept_name,role_organization.name AS new_designation,role_organization.rank as designation_rank,ijp_request_reason.request_reason,ijp_requisitions.life_cycle FROM `ijp_requisitions`
			LEFT JOIN department ON department.id=ijp_requisitions.dept_id
			LEFT JOIN sub_department ON sub_department.id=ijp_requisitions.sub_debt_id
			LEFT JOIN role_organization ON role_organization.id=ijp_requisitions.new_designation_id
			LEFT JOIN client ON client.id=ijp_requisitions.client_id
			LEFT JOIN process ON process.id=ijp_requisitions.process_id
			LEFT JOIN ijp_request_reason ON ijp_request_reason.id=ijp_requisitions.request_reason_id
			
			WHERE ijp_requisitions.requisition_id NOT IN(SELECT requisition_id FROM ijp_requisition_applications WHERE user_id="'.$current_user.'")  AND life_cycle !="OPN" ORDER BY id DESC');
		}
		return $query->result_object();
	}
	
	
	public function submit_user_application()
	{
		$config['upload_path']          = './uploads/ijp_resume/';
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
		else if($result->life_cycle == 'IPN')
		{
			echo 'Interview Pending';
		}
		else if($result->life_cycle == 'AFTR')
		{
			echo 'Awaiting Filter Test Results';
		}
		else if($result->life_cycle == 'AR')
		{
			echo 'Awaiting Results';
		}
		else if($result->life_cycle == 'DON')
		{
			echo 'Requisition Complete';
		}
		else if($result->life_cycle == 'CLS')
		{
			echo 'Application Process Close';
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
		$query = $this->db->query('SELECT ijp_requisition_applications.*,CONCAT(signin.fname," ",signin.lname) AS user_name,ijp_requisitions.raised_by,ijp_requisitions.hiring_manager_id,ijp_requisitions.filter_type,ijp_requisitions.life_cycle FROM ijp_requisition_applications LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id
			
			LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id WHERE  ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'"');
		$rows = $query->result_object();
		$i=1;
		foreach($rows as $key=>$value)
		{
			echo '<tr>';
				echo '<td>'.$i.'</td>';
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
				if($value->life_cycle == 'DON')
				{
					if($value->status == 'Selected')
					{
						echo '<td>Selected</td>';
					}
					else
					{
						echo '<td>Not Selected</td>';
					}
				}
				else
				{
					if($value->status == 'Applied')
					{
						echo '<td><button class="btn btn-xs btn-success approve_application" title="Approve Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-check-square" aria-hidden="true"></i></button>&nbsp;<button class="btn btn-xs btn-danger reject_application" title="Reject Application" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
					}
					else if($value->status == 'Approved')
					{
						echo '<td>Approved</td>';
					}
					else if($value->status == 'Scheduled')
					{
						if(get_dept_folder()=="hr")
						{
							echo '<td><button class="btn btn-xs btn-primary interview_qualified" title="Interview Qualified?" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"  data-filter_type="'.$value->filter_type.'">Interview Qualified ?</button></td>'; 
						}
						else
						{
							echo '<td>Scheduled</td>';
						}
					}
					else if($value->status == 'FilterTest')
					{
						if($value->life_cycle == 'AFTR')
						{
							echo '<td><button class="btn btn-xs btn-danger filter_test_result" title="Filter Test Result" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'"  data-filter_type="'.$value->filter_type.'">Filter Test Result</button></td>';
						}
						else
						{
							echo '<td>Interview Cleared</td>';
						}
					}
					else if($value->status == 'NotClrInter')
					{
						echo '<td>Not Cleared Interview</td>';
					}
					else if($value->status == 'Cleared')
					{
						if($value->life_cycle == 'IPN')
						{
							echo '<td>Interview Cleared</td>';
						}
						else
						{
							if(get_dept_folder()=="hr" && $value->hiring_manager_id!=$current_user)
							{
								
								echo '<td>Sent to Hiring Manager</td>';
							}
							else if($value->hiring_manager_id==$current_user)
							{
								echo '<td><button class="btn btn-xs btn-danger final_selection" title="Interview Qualified?" data-requisition_id="'.$value->requisition_id.'" data-user_id="'.$value->user_id.'">Final Selection</button></td>';
							}
						}
					}
				}
				
			echo '<tr>';
			$i++;
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
	
	public function reject_application()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "Rejected" WHERE requisition_id="'.$form_data['requisition_id'].'" and user_id="'.$form_data['user_id'].'"');
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
	
	public function schedule_interview()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT ijp_requisition_applications.*,CONCAT(signin.fname," ",signin.lname) as name,signin.xpoid FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id WHERE ijp_requisition_applications.status = "Approved" AND ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'"');
		if($query)
		{
			if($query->num_rows() > 0)
			{
				$response['stat'] = true;
				$rows = $query->result_object();
				$i=1;
				$response['datas'] = '';
				foreach($rows as $key=>$value)
				{
					$response['datas'] .=  '<tr class="remove">';
						$response['datas'] .= '<td><input type="checkbox" name="select[]" value="'.$value->user_id.'"></td>';
						$response['datas'] .= '<td>'.$i.'</td>';
						$response['datas'] .= '<td>'.$value->name.'</td>';
						$response['datas'] .= '<td>'.$value->xpoid.'</td>';
					$response['datas'] .= '</tr>';
					$i++;
				}
				$response['datas'] .=  '<input type="hidden"  class="remove" name="requisition_id" value="'.$form_data['requisition_id'].'">';
				//$response['datas'] .=  '';
				$response['datas'] .=  '<tr class="remove">';
					$response['datas'] .=  '<td colspan="4">';
						$response['datas'] .=  '<input type="submit" class="btn btn-block btn-success" value="Schedule">';
					$response['datas'] .=  '</td>';
				$response['datas'] .=  '</tr>';
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
	
	public function schedule_interview_process()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		
		foreach($form_data['select'] as $key=>$value)
		{
			$query = $this->db->query('INSERT INTO `ijp_interview_schedule`(`requisition_id`, `user_id`, `schedule_datetime`, `added_by`, `added_date`) VALUES ("'.$form_data['requisition_id'].'","'.$value.'","'.$form_data['schedule_datetime'].'","'.$current_user.'",now())');
			$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "Scheduled" WHERE requisition_id="'.$form_data['requisition_id'].'" and user_id="'.$value.'"');
			$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "IPN" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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

	public function process_interview()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = $this->db->query('INSERT INTO `ijp_interview_score`(`requisition_id`,`user_id`, `interview_score`, `interview_status`, `remarks`, `added_by`, `added_date`) VALUES ("'.$form_data['requisition_id'].'","'.$form_data['user_id'].'","'.$form_data['interview_score'].'","'.$form_data['interview_status'].'","'.$form_data['remarks'].'","'.$current_user.'",now())');
		if($form_data['filter_type']=='1' && $form_data['interview_status']=='Cleared')
		{
			$form_data['interview_status'] = 'FilterTest';
		}
		if($form_data['filter_type']=='1' && $form_data['interview_status']=='NotCleared')
		{
			$form_data['interview_status'] = 'NotClrInter';
		}
		$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "'.$form_data['interview_status'].'" WHERE requisition_id="'.$form_data['requisition_id'].'" and user_id="'.$form_data['user_id'].'"');
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

	public function close_application()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "CLS" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function close_interview()
	{
		$form_data = $this->input->post();
		if($form_data['filter_type'] == 1)
		{
			$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "AFTR" WHERE requisition_id="'.$form_data['requisition_id'].'"');
		}
		else
		{
			$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "AR" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function filter_test_result_process()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$query = $this->db->query('INSERT INTO `ijp_filter_test_score`(`requisition_id`,`user_id`, `filter_score`, `filter_status`, `remarks`, `added_by`, `added_date`) VALUES ("'.$form_data['requisition_id'].'","'.$form_data['user_id'].'","'.$form_data['filter_score'].'","'.$form_data['filter_status'].'","'.$form_data['remarks'].'","'.$current_user.'",now())');
		if($form_data['filter_type']=='1' && $form_data['filter_status']=='Cleared')
		{
			$form_data['filter_status'] = 'Cleared';
		}
		if($form_data['filter_type']=='1' && $form_data['filter_status']=='NotCleared')
		{
			$form_data['filter_status'] = 'NotCleared';
		}
		$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "'.$form_data['filter_status'].'" WHERE requisition_id="'.$form_data['requisition_id'].'" and user_id="'.$form_data['user_id'].'"');
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
	
	public function close_filter_type()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "AR" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
	
	public function final_application()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT ijp_requisition_applications.*,CONCAT(signin.fname," ",signin.lname) as name,signin.xpoid,ijp_requisitions.no_of_position FROM `ijp_requisition_applications` LEFT JOIN signin ON signin.id=ijp_requisition_applications.user_id LEFT JOIN ijp_requisitions ON ijp_requisitions.requisition_id=ijp_requisition_applications.requisition_id WHERE ijp_requisition_applications.status = "Cleared" AND ijp_requisition_applications.requisition_id="'.$form_data['requisition_id'].'"');
		if($query)
		{
			if($query->num_rows() > 0)
			{
				$response['stat'] = true;
				$rows = $query->result_object();
				$i=1;
				$response['datas'] = '';
				foreach($rows as $key=>$value)
				{
					$no_of_position = $value->no_of_position;
					$response['datas'] .=  '<tr class="remove">';
						$response['datas'] .= '<td><input type="checkbox" name="select[]" value="'.$value->user_id.'"></td>';
						$response['datas'] .= '<td>'.$i.'</td>';
						$response['datas'] .= '<td>'.$value->name.'</td>';
						$response['datas'] .= '<td>'.$value->xpoid.'</td>';
					$response['datas'] .= '</tr>';
					$i++;
				}
				$response['datas'] .=  '<input type="hidden" name="requisition_id" value="'.$form_data['requisition_id'].'">';
				$response['datas'] .=  '<input type="hidden" name="no_of_position" id="no_of_position" value="'.$no_of_position.'">';
				$response['datas'] .=  '<tr class="remove">';
					$response['datas'] .=  '<td colspan="4">';
						$response['datas'] .=  '<input type="submit" class="btn btn-block btn-success" value="Final Selection">';
					$response['datas'] .=  '</td>';
				$response['datas'] .=  '</tr>';
				
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
	
	public function final_selection()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		
		foreach($form_data['select'] as $key=>$value)
		{
			$query = $this->db->query('UPDATE `ijp_requisition_applications` SET `status`= "Selected" WHERE requisition_id="'.$form_data['requisition_id'].'" and user_id="'.$value.'"');
			$query = $this->db->query('UPDATE `ijp_requisitions` SET `life_cycle`= "DON" WHERE requisition_id="'.$form_data['requisition_id'].'"');
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
}	


?>