<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Leave_model');
	}

	public function index(){
		if(check_logged_in()){

			$user_site_id = get_user_site_id();
			$role_id = get_role_id();
			$data["user_office_id"] = $user_office_id = get_user_office_id();
			$ses_dept_id = get_dept_id();						
			$is_global_access = get_global_access();
			$current_user = get_user_id();

			$personal = $this->Leave_model->get_personal_data($current_user);
			$data["date_of_joining"] = $personal->doj; 

			$data["aside_template"] = "leave/aside.php";
			$data["content_template"] = "leave/index.php";

			$data["leave_accessible"] = $this->Leave_model->get_leaves_accessible($user_office_id);

			$leaves_available = $this->Leave_model->get_leaves_available($current_user);
			
			$aa = array();
			$var_js = array();

			$_user_id = $current_user;			

			foreach($leaves_available as $leave){

				$_leave_accessible = "";

				if($leave->extra_config_query!=""){
					$_leave_criteria_id = $leave->leave_criteria_id;
					$rr = $leave->extra_config_query;

					if($q = $this->db->query(sprintf($rr, $_user_id,$_leave_criteria_id, $_user_id))){
						$res = $q->result();

						foreach($res as $_r){
							$_leave_accessible = $_r->leave_access;
						}						
					}
				}

				$aa[] = array(
					"leave_type" => $leave->description,
					"leave_details" => array(
						"leave_type_id" => $leave->leave_type_id,
						"leave_present" => $leave->leaves_present,
						"show_in_dashboard" => $leave->show_in_dashboard,
						"show_after_days" => $leave->show_after_days,
						"leave_accessible" => $_leave_accessible,
						"leave_allowed" => $leave->leave_access_allowed,
					)
				);

				$var_js[$leave->leave_criteria_id] = array($leave->leave_type_id, $leave->leaves_present, $_leave_accessible, $leave->criteria, $leave->can_also_use_leave_criteria);
			}

			$data["leaves_available"] = $aa;
			$data["var_js"] = json_encode($var_js);
			$data["leave_structure"] = $leaves_available; 
			$data["leaves_applied"] = $this->Leave_model->get_leaves_applied($current_user);

			$_ind_location = ['KOL', 'HWH', 'BLR'];
			$_jam_location = ['JAM'];

			if($this->input->post()){

				$data["error"] = "From Date and To Date are required fields";

				if($this->input->post('from_date')!="" && $this->input->post('to_date')!=""){

					$_from_date = strtotime($this->input->post('from_date'));
					$_to_date = strtotime($this->input->post('to_date'));

					if($_from_date == $_to_date) $diff = 1;
					else $diff = 1 + round(($_to_date - $_from_date)/60/60/24);

					if($var_js[$this->input->post('leave_criteria_id')][3] == 0){
						$diff = 0; 
					}

					if($diff <= $var_js[$this->input->post('leave_criteria_id')][1] && $diff>=0){

						$my_leave_availability = $this->Leave_model->get_my_leave_availability($current_user, $this->input->post('leave_criteria_id'));

						$diff = $my_leave_availability->leaves_present - $diff;
						
						$_field_array = array(
							"user_id" => get_user_id(),
							"leave_criteria_id" => $this->input->post('leave_criteria_id'),
							"leave_type_id" => $this->input->post('leave_type_id'),
							"from_dt" => mmddyy2mysql($this->input->post('from_date')),
							"to_dt" => mmddyy2mysql($this->input->post('to_date')),
							"reason" => $this->input->post('reason'),
							"contact_details" => $this->input->post('contact_details'),
						);	
						
						if($var_js[$this->input->post('leave_criteria_id')][4] != 0){

							if($this->input->post('apply_additional_leaves') !=""){
								$_field_array["additional_leave_criteria"] = $var_js[$this->input->post('leave_criteria_id')][4];
								$_field_array["no_of_additional_leaves"] = $this->input->post('no_of_additional_leaves');
							}else{
								$_field_array["additional_leave_criteria"] = null;
								$_field_array["no_of_additional_leaves"] = null;
							}							
						}
						
						$_leave_id = data_inserter("leave_applied", $_field_array);

						if($_leave_id){	
							$this->Email_model->leave_apply_emails(get_user_id(), $_leave_id);
													
							$this->db->where(array("user_id" => get_user_id(), 
									"leave_criteria_id" => $this->input->post('leave_criteria_id')));
							$this->db->update('leave_avl_emp', array("leaves_present" => $diff));

							if($this->input->post('apply_additional_leaves') !=""){		
								
								$_added_id = $var_js[$this->input->post('leave_criteria_id')][4];
								$diff = $var_js[$_added_id][1] - $this->input->post('no_of_additional_leaves');
								
								$this->db->where(array("user_id" => get_user_id(), "leave_criteria_id" => $_added_id));
								$this->db->update('leave_avl_emp', array("leaves_present" => $diff));
							}
						}					
					}else{
						$data["error"] = "In-Valid Number of days selected for leave";
					}

					redirect('/leave/','refresh');
				}	
			}
			$this->load->view('dashboard',$data);
		}
	}

	/* 
	//	LEAVE APPROVAL
	*/

	public function leave_approval(){
		if(check_logged_in()){
			$data["aside_template"] = "leave/aside.php";
			$data["content_template"] = "leave/leave_approval.php";

			$is_global_access=get_global_access();
			$user_office_id = get_user_office_id();
			$ses_dept_id=get_dept_id();
			$_status="";
			$_status = $this->input->get('status');
			$_emp_name = trim($this->input->get('emp_name'));
			$_dept_id = trim($this->input->get('dept_id'));
			$_fusion_id = trim($this->input->get('fusion_id'));
			$_applied_date = trim($this->input->get('applied_date'));
			$_office_id = trim($this->input->get('office_id'));
			if($_office_id=="") $_office_id = $user_office_id;
			
			$current_user_id = get_user_id();

			if(get_global_access()==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user_id);
			}
						
			if (is_access_all_leave_approve()==true) $current_user_id="";
			
			if($_fusion_id == "" && $_emp_name == "" && $_dept_id == "" && $_emp_name == "" && $_status == "" && $_applied_date == "" ) $_status = "0";
							
			if($user_office_id == 'JAM'){
				$data["employee_list"] = $this->Leave_model->my_team_list($current_user_id, False);
			}else{
				$data["employee_list"] = $this->Leave_model->my_team_list($current_user_id, True);
			}
			///$data["department_list"] = $this->Leave_model->department_list(get_dept_id());
			
			if (is_access_all_leave_approve()==true){
				
				$data['department_list'] = $this->Common_model->get_department_list();
				if($_dept_id=="ALL" || $_dept_id=="") $data['sub_department_list'] = array();
				else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($_dept_id);
				
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			}
				
			
			$data["status"] = $_status;
			$data["emp_name"] = $_emp_name;
			$data["dept_id"] = $_dept_id;
			$data["fusion_id"] = $_fusion_id;
			$data["applied_date"] = $_applied_date;
			$data["office_id"] = $_office_id;

			
			if($_applied_date!="") $_applied_date = mmddyy2mysql($_applied_date);
			
			//if (is_access_leave_manage()==true) $data["my_team_leaves"] = $this->Leave_model->get_team_leaves("",$_status);
			//else $data["my_team_leaves"] = $this->Leave_model->get_team_leaves(get_user_id(), $_status);
			
			$data["my_team_leaves"] = $this->Leave_model->get_team_leaves($current_user_id, $_status, $_emp_name, $_dept_id, $_fusion_id, $_applied_date, $_office_id);

			//pagination_config($_page_url , $_total_rows , $_per_page, $_uri_segment,$qStr)


			$this->load->view('dashboard',$data);
		}
	}

	/* 
	//	SET LEAVE STATUS		
    //  IF REJECTED, ADD DAYS DEDUCTED TO leave_avl_emp TABLE
    //  IF ACCEPTED AFTER A REJECT, DEDUCT FROM leave_avl_emp TABLE
	*/

	public function set_leave_status(){
		if(check_logged_in()){
			$leave_status = $this->input->post('status_id');
			$leave_id = $this->input->post('id');

			$ret = $this->Leave_model->get_leave_details($leave_id);
			$avl = $this->Leave_model->get_my_leave_availability($ret->user_id, $ret->leave_criteria_id);
			$leave_criteria = $this->Leave_model->get_leave_criteria_data($ret->leave_criteria_id);

			
			if($leave_status == '2'){
				//
				//	If leave is Rejected
				//	
				if($ret->additional_leave_criteria != null){
					// If addtional leave is availed
					// Check deductions for first leave leave criteria
					//
					if($leave_criteria->criteria == 0) $diff = 0;
					else{
						$_from_date = strtotime($ret->from_dt);
						$_to_date = strtotime($ret->to_dt);
	
						if($_from_date == $_to_date) $diff = 1;
						else $diff = 1 + round(($_to_date - $_from_date)/60/60/24);
					}

					$diff = (float)$avl->leaves_present + (float)$diff;

					$this->db->where('user_id', $ret->user_id);
					$this->db->where('leave_criteria_id', $ret->leave_criteria_id);
					$this->db->update('leave_avl_emp', array("leaves_present"=>$diff));
	
					//
					// check deductions for added leave criteria
					//
					$avl_2 = $this->Leave_model->get_my_leave_availability($ret->user_id, $ret->additional_leave_criteria);
					$leave_criteria_next = $this->Leave_model->get_leave_criteria_data($ret->additional_leave_criteria);
	
					if($leave_criteria_next->criteria == 0) $diff = 0;
					else $diff = $ret->no_of_additional_leaves;

					$diff = (float)$avl_2->leaves_present + (float)$diff;

					$this->db->where('user_id', $ret->user_id);
					$this->db->where('leave_criteria_id', $ret->additional_leave_criteria);
					$this->db->update('leave_avl_emp', array("leaves_present"=>$diff));
				}
				else{
					// If no additional leave

					if($leave_criteria->criteria == 0) $diff = 0;
					else{
						$_from_date = strtotime($ret->from_dt);
						$_to_date = strtotime($ret->to_dt);
		
						if($_from_date == $_to_date) $diff = 1;
						else $diff = 1 + round(($_to_date - $_from_date)/60/60/24);
					}

					$diff = (float)$avl->leaves_present + (float)$diff;
					
					$this->db->where('user_id', $ret->user_id);
					$this->db->where('leave_criteria_id', $ret->leave_criteria_id);
					$this->db->update('leave_avl_emp', array("leaves_present"=>$diff));
				}
				
				$data = array("status" => $leave_status,
							"approved_on" => NULL,
							"approved_by" => NULL,
							"rejected_on" => date('Y-m-d H:i:a'),
							"reject_reason" => trim($this->input->post('reject_reason')), 
							"rejected_by" => get_user_id(),
						);
				$this->db->where('id', $leave_id);
        		$this->db->update('leave_applied', $data);

			}else{
				$data = array("status" => $leave_status,
							"approved_on" => date('Y-m-d H:i:a'),
							"approved_by" => get_user_id(),
							"rejected_on" => NULL,
							"rejected_by" => NULL,
							"reject_reason" => NULL,
						);
				$this->db->where('id', $leave_id);
        		$this->db->update('leave_applied', $data);
			}
		}
	}

	//
	//	APPROVE ALL LEAVES
	//
	public function approve_all(){
		if(check_logged_in()){
			$leave_ids = $this->input->post('leave_ids');
			if(count($leave_ids)>0){
				for($i = 0; $i < count($leave_ids); $i++){
					$data = array("status" => 1,
								"approved_on" => date('Y-m-d H:i:a'),
								"approved_by" => get_user_id(),
								"rejected_on" => NULL,
								"rejected_by" => NULL,
								"reject_reason" => NULL,
							);
					$this->db->where('id', $leave_ids[$i]);
					$this->db->update('leave_applied', $data);
				}
			}
			print_r($leave_ids);
		}		
	}


	//
	//	Location Leave Access
	//
	public function leave_access_location(){
		if(check_logged_in()){

			$is_global_access = get_global_access();
			$current_user = get_user_id();
			
			if(is_access_leave_manage()==true){

				$data["aside_template"] = "leave/aside.php";
				$data["content_template"] = "leave/leave_access_location.php";

				$_leave_criteria = $this->Leave_model->get_leave_criterias_location();
				
				$_arr = array();
				foreach($_leave_criteria as $_lc){
					$_arr[$_lc->office_name]["leave_criteria"][] = $_lc->description;
					$_arr[$_lc->office_name]["status"] = $_lc->status;
					$_arr[$_lc->office_name]["abbr"] = $_lc->abbr;
				}
				
				$data["arr"] = $_arr;

				$this->load->view('dashboard',$data);
			}			
		}
	}


	//
	//	Location Leave Access -- ENABLE/DISABLE
	//

	public function location_access_status_change(){
		if(check_logged_in()){

			$is_global_access = get_global_access();
			$current_user = get_user_id();
			
			if(is_access_leave_manage()==true){
				$_status = $this->input->post('id'); 
				$_office_id = $this->input->post('abbr');

				$this->db->where("office_id", $_office_id);
				$this->db->update('leave_config', array("status" => $_status));

				print "1";
			}else print "0";
		}else print "0";
	}

	//
	//	SHOW ALL LEAVE BALANCE
	//
	public function leave_balance(){
		if(check_logged_in()){

			$location = 'KOL';

			if($this->input->get('location') !=""){
				$location = $this->input->get('location');
			}else{
				$location = get_user_office_id();
			}

			$is_global_access = get_global_access();
			$current_user = get_user_id();

			if(is_access_leave_manage()==true || leave_approvers_location_specify("JAM", FALSE, ['FJAM004129','FJAM002694','FJAM004503'])){

				$data["aside_template"] = "leave/aside.php";
				$data["content_template"] = "leave/leave_balance.php";

				$_leave_criteria = $this->Leave_model->get_leave_criterias_for_location($location);

				$_arr = array();
				foreach($_leave_criteria as $_lc){
					$_arr[] = $_lc->leave_type;
				}
				
				$data["arr"] = $_arr;

				if($is_global_access) $data["location_list"] = $this->Common_model->get_office_location_list();
				else $data["location_list"] = array(array("abbr"=>$location));
				
				$data["location"] = $location;

				$data["leave_balance"] = $this->Leave_model->leave_balance($location);

				$this->load->view('dashboard',$data);
			}
		}
	}


	public function team_leave_balance(){
		if(check_logged_in()){

			$data["aside_template"] = "leave/aside.php";
			$data["content_template"] = "leave/team_leave_balance.php";

			$current_user = get_user_id();

			$_leave_criteria = $this->Leave_model->get_leave_criterias_for_location(get_user_office_id());

			$_arr = array();
			foreach($_leave_criteria as $_lc){
				$_arr[] = $_lc->leave_type;
			}
			
			$data["arr"] = $_arr;

			$data["leave_balance"] = $this->Leave_model->team_leave_balance($current_user);

			$this->load->view('dashboard',$data);
		}
	}


	/* 
		REPORTS
	*/

	public function reports(){
		if(check_logged_in()){
			
			$data["aside_template"] = "leave/aside.php";
			$data["content_template"] = "leave/reports.php";

			$data["filename"] = "";
			
			$current_user_id=get_user_id();
			
			if(get_global_access()==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user_id);
			}
			
			if($this->input->post('from_date') !="" && $this->input->post('to_date') !="" && $this->input->post('downloadReport')=='Download CSV'){
					
				$_from_date = mmddyy2mysql($this->input->post('from_date'));
				$_to_date = mmddyy2mysql($this->input->post('to_date'));
				$_office_id = $this->input->post('location_id');

				$filename = "leave_report-".get_user_id()."-".date("Y-m-d").".csv";
				
				$data["filename"] = base_url()."leave_reports_path/reports/".$filename;
				$file_path = $this->config->item('LeaveReports')."/reports/".$filename;
				
				
				$fp = fopen($file_path,"w");

				//$content = "Emp_Id, Emp_Fusion_Id, Emp_Name, Emp_Dept, LeaveType, Leave From, Leave To, No of Leave, Applied Date, Reporting Head, Status, Approved By, Approved Date";
				
				$content = "FEMSID, Emp_Id, Emp_Name, Emp_Dept, Client, Process, Location, Leave Type, Leave Date, Leave From, Leave To, Applied Date, Reporting Head, Status, Approved/Rejected By, Approved/Rejected Date";	

				fwrite($fp, $content);
				$content = "\n";
				fwrite($fp, $content);
				

				$js = array();

				$_from_dt = strtotime($_from_date);
				$_to_dt = strtotime($_to_date);

				while($_from_dt <= $_to_dt){
					$_date_range[] = date("Y-m-d", $_from_dt);
					$_from_dt = strtotime('+1 day', $_from_dt);
				}

				foreach($_date_range as $_date){

					$reports = $this->Leave_model->get_reports($_date, $_office_id);
					
					foreach($reports as $row){
						$content = '"'.str_replace("\N","",trim($row->fusion_id)).'",';
						$content .= '"'.str_replace("\N","",trim($row->xpoid)).'",';
						$content .= '"'.str_replace("\N","",trim($row->emp_name)).'",';
						$content .= '"'.str_replace("\N","",trim($row->department)).'",';
						$content .= '"'.str_replace("\N","",trim($row->client_name)).'",';
						$content .= '"'.str_replace("\N","",trim($row->process_name)).'",';
						$content .= '"'.str_replace("\N","",trim($row->office_id)).'",';
						$content .= '"'.str_replace("\N","",trim($row->leave_type)).'",';
						$content .= '"'.str_replace("\N","",trim($_date)).'",';
						$content .= '"'.str_replace("\N","",trim($row->from_dt)).'",';
						$content .= '"'.str_replace("\N","",trim($row->to_dt)).'",';
						$content .= '"'.str_replace("\N","",trim($row->apply_date)).'",';
						$content .= '"'.str_replace("\N","",trim($row->reporting_head)).'",';

						if($row->status == '1') $_status = 'Accepted';
						else if($row->status == '2') $_status = 'Rejected';
						else $_status = 'Pending';

						$content .= '"'.$_status.'",';
						
						if($row->status == '2'){
							$content .= '"'.str_replace("\N","",trim($row->rejected_by)).'",';
							$content .= '"'.str_replace("\N","",trim($row->rejected_on)).'",';
						}
						else{
							$content .= '"'.str_replace("\N","",trim($row->approved_by)).'",';
							$content .= '"'.str_replace("\N","",trim($row->approved_on)).'",';
						}						

						$content .= "\n";
						fwrite($fp, $content);
					}					
				}

				
				fclose($fp);
				
				ob_end_clean();
								
				$newfile="leave_report-".$_from_date."to".$_to_date.".csv";
				header('Content-Disposition: attachment;  filename="'.$newfile.'"');
				readfile($file_path);
				exit();
			}

			$this->load->view('dashboard',$data);
		}
	}

	public function check_probabtion_leave(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$_lc_id = $this->input->post('lc_id');

			print $this->Leave_model->check_probabtion_leave($current_user, $_lc_id);
		}
	}

	public function check_probabtion_leave_date(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$_lc_id = $this->input->post('lc_id');
			$_from_dt = mmddyy2mysql($this->input->post('from_dt'));

			print $this->Leave_model->check_probabtion_leave_date($current_user, $_lc_id, $_from_dt);
		}
	}
	

	public function get_emlployee_list_based_on_dept(){
		if(check_logged_in()){
			$_dept_id = $this->input->post('id');
			$_office_id = $this->input->post('office_id');
			print_r(json_encode($this->Common_model->get_emlployee_list_based_on_dept($_dept_id, $_office_id)));
		}
	}


	//
	// FOR JAMAICA
}

?>