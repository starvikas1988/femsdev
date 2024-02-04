<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dfr_test extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url','dfr_functions'));
		$this->load->model('Common_model');
		$this->load->model('Dfr_model');
		$this->load->model('Candidate_model');
		$this->load->model('Email_model');
		//$this->load->library('pdf_loader');
		$this->load->library('pdf');
		
	}
	

///////////////////////////////////////////////////////////////////////	
///////////////////////// Requisition part ////////////////////////////
///////////////////////////////////////////////////////////////////////

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
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/manage_requisition.php";
			
			
			$data["department_data"] = $this->Common_model->get_department_list();
			$data["role_data"] = $this->Common_model->get_rolls_for_assignment();
			$data["location_data"] = $this->Common_model->get_office_location_list();
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data["get_requisition"] = $this->Dfr_model->get_requisition_data($_filterCond);
			
			
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function add_requisition()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			//$requisition_id = trim($this->input->post('requisition_id'));
			$location = trim($this->input->post('location'));
			$department_id = trim($this->input->post('department_id'));
			$due_date = mmddyy2mysql(trim($this->input->post('due_date')));
			$curryear = date("Y");
			$raised_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($location!=""){
				$field_array = array(
					"requisition_id" => generate_requisition_id($location."".$department_id."".$curryear),
					"location" => $location,
					"department_id" => $department_id,
					"due_date" => $due_date,
					"business_unit" => trim($this->input->post('business_unit')),
					"role_id" => trim($this->input->post('role_id')),
					"priority" => trim($this->input->post('priority')),
					"employee_status" => trim($this->input->post('employee_status')),
					"req_qualification" => trim($this->input->post('req_qualification')),
					"req_exp_range" => trim($this->input->post('req_exp_range')),
					"req_no_position" => trim($this->input->post('req_no_position')),
					"filled_no_position" => trim($this->input->post('filled_no_position')),
					"job_title" => trim($this->input->post('job_title')),
					"job_desc" => trim($this->input->post('job_desc')),
					"req_skill" => trim($this->input->post('req_skill')),
					"additional_info" => trim($this->input->post('additional_info')),
					"raised_by" => $current_user,
					"raised_date" => $raised_date,
					"requisition_status" => 'P',
					"log" => $log
				);
				$rowid= data_inserter('dfr_requisition',$field_array);
				
				
				//$this->Email_model->send_email_requisition_raised($current_user,$field_array,$user_office_id);
				
				
				redirect("dfr");
			
			}	
		}
	}
	
	
	
	public function view_candidate_details($c_id){
		if(check_logged_in()){
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/candidate_details.php";
			
			
			 
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	public function view_candidate_interview($c_id){
		if(check_logged_in()){
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/candidate_interview_report.php";
			
			$qSql="SELECT *, (Select CONCAT(fname,' ',lname) as c  from signin s where s.id =dfr.interviewer_id ) as interviewer  FROM dfr_interview_details dfr where c_id='$c_id'";
			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$sqltxt ="SELECT interview_type, (SELECT office_name FROM office_location ol where abbr=sh.interview_site ) office_name FROM dfr_interview_schedules sh where c_id= '$c_id'";
			$data["interview_type"]=   $this->Common_model->get_query_result_array($sqltxt);
			
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM femsdev.department d where rq.department_id = d.id )as dept  FROM femsdev.dfr_candidate_details cd INNER join  femsdev.dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			$data["candidate_details"]=   $this->Common_model->get_query_result_array($sqltxt);
			$data['c_id'] = $c_id; 
		
			 
			 $this->load->view('dashboard',$data);
			
			
		}
	}
	
	
	public function view_requisition($id)
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/view_requisition.php";
			
			$data["view_reuisition"] = $this->Dfr_model->view_requisition_data($id);
			
		/////////////
			
			$qSql= "Select yy.*, ii.*,ii.id as sch_id from (Select r.id as rid, r.req_no_position, r.filled_no_position, r.department_id, r.role_id, r.location, c.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name from dfr_requisition r, dfr_candidate_details c where  r.id=c.r_id) yy Left Join (Select dis.* from dfr_interview_schedules dis where dis.id = (select max(id) from dfr_interview_schedules where c_id = dis.c_id)) ii ON (ii.c_id=yy.id) where r_id='$id' ";
			//echo $qSql;
			
			$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);
		/////////////////
			
			$qSql="Select abbr, office_name, location from office_location where is_active=1";
			$data["get_site_location"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT id,name, org_role  FROM role where is_active=1 and folder not in('super') ORDER BY name";
			$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			if(get_role_dir()!="super" && get_global_access()!=1){
				$tl_cnd=" and office_id='$user_office_id' ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}else{ 
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}
			
			$data["get_department_data"] = $this->Common_model->get_department_list();
			$data['organization_role'] = $this->Common_model->role_organization();
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			$data['payroll_type_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_type where is_active=1");
			$data['payroll_status_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_status where is_active=1");
			
		///////////////////
			$qSql = "Select id, concat(fname, ' ', lname) as name from signin where status=1 and role_id!='3' ";
			$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
		////////////

			
		////////////////////////////////////////////			
			$this->load->view('dashboard',$data);
		}
	}

	
	public function get_candidate_detail(){
		if(check_logged_in())
		{
			$c_id = $this->input->post('c_id');	
			$qSql="Select * from dfr_candidate_details where id='$c_id'";
			print json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	public function edit_requisition()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$requisition_id = trim($this->input->post('requisition_id'));
			$location = trim($this->input->post('location'));
			$due_date = mmddyy2mysql(trim($this->input->post('due_date')));
			$business_unit = trim($this->input->post('business_unit'));
			$department_id = trim($this->input->post('department_id'));
			$role_id = trim($this->input->post('role_id'));
			$priority = trim($this->input->post('priority'));
			$employee_status = trim($this->input->post('employee_status'));
			$req_qualification = trim($this->input->post('req_qualification'));
			$req_exp_range = trim($this->input->post('req_exp_range'));
			$req_no_position = trim($this->input->post('req_no_position'));
			$filled_no_position = trim($this->input->post('filled_no_position'));
			$job_title = trim($this->input->post('job_title'));
			$job_desc = trim($this->input->post('job_desc'));
			$req_skill = trim($this->input->post('req_skill'));
			$additional_info = trim($this->input->post('additional_info'));
			$raised_date = date('Y-m-d');
			$log=get_logs();
			
			if($r_id!=""){
				$field_array = array(
					"requisition_id" => $requisition_id,
					"due_date" => $due_date,
					"business_unit" => $business_unit,
					"department_id" => $department_id,
					"role_id" => $role_id,
					"priority" => $priority,
					"employee_status" => $employee_status,
					"req_qualification" => $req_qualification,
					"req_exp_range" => $req_exp_range,
					"req_no_position" => $req_no_position,
					"filled_no_position" => $filled_no_position,
					"job_title" => $job_title,
					"job_desc" => $job_desc,
					"req_skill" => $req_skill,
					"additional_info" => $additional_info,
					"raised_by" => $current_user,
					"raised_date" => $raised_date,
					"requisition_status" => 'P',
					"log" => $log
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("dfr");
		}
	}
	
	
	public function approved_requisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$r_status = trim($this->input->post('r_status'));
			$update_comment = trim($this->input->post('update_comment'));
			$update_date = date("Y-m-d h:i:sa");
			
			if($r_id!=""){
				$field_array = array(
					"update_by" => $current_user,
					"update_date" => $update_date,
					"update_comment" => $update_comment,
					"requisition_status" => 'A'
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
				//$this->Email_model->hiring_requis_approve($current_user,$r_id,$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;	
		}
	}
	
	public function decline_requisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$r_status = trim($this->input->post('r_status'));
			$update_comment = trim($this->input->post('update_comment'));
			$update_date = date("Y-m-d h:i:sa");
			
			if($r_id!=""){
				$field_array = array(
					"update_by" => $current_user,
					"update_date" => $update_date,
					"update_comment" => $update_comment,
					"requisition_status" => 'R'
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
				//$this->Email_model->hiring_requis_decline($current_user,$r_id,$field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;	
		}
	}
	
//////////////////////////////////////////////////////////////////////////////	
	
	public function add_candidate()
	{
		if(check_logged_in())
		{
			$ans="";
		
			$r_id = trim($this->input->post('r_id'));
			$current_user = get_user_id();
			//$requisition_id = trim($this->input->post('requisition_id'));
			$fname = trim($this->input->post('fname'));
			$dob = mmddyy2mysql(trim($this->input->post('dob')));
			$added_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($fname!=""){
				
				$config['upload_path'] = './uploads/candidate_resume/';
				$config['allowed_types'] = 'doc|docx|pdf';
				$config['max_size']     = '20240';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				$field_array = array(
					"r_id" => $r_id,
					"requisition_id" => trim($this->input->post('requisition_id')),
					"fname" => $fname,
					"lname" => trim($this->input->post('lname')),
					"hiring_source" => trim($this->input->post('hiring_source')),
					"dob" => $dob,
					"email" => trim($this->input->post('email')),
					"gender" => trim($this->input->post('gender')),
					"phone" => trim($this->input->post('phone')),
					"last_qualification" => trim($this->input->post('last_qualification')),
					"skill_set" => trim($this->input->post('skill_set')),
					"total_work_exp" => trim($this->input->post('total_work_exp')),
					"country" => trim($this->input->post('country')),
					"state" => trim($this->input->post('state')),
					"city" => trim($this->input->post('city')),
					"postcode" => trim($this->input->post('postcode')),
					"address" => trim($this->input->post('address')),
					"summary" => trim($this->input->post('summary')),
					"candidate_status" => 'P',
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				);
				
				if (!$this->upload->do_upload('attachment')){
					$error = $this->upload->display_errors();
					$data['message'] = $error;
					//echo $error;
				}else{
					$resume_file = $this->upload->data();
					//print_r($resume_file);
					$field_array["attachment"] = $resume_file['file_name'];
				
					
				}
				$rowid= data_inserter('dfr_candidate_details',$field_array);
				$ans="done";
				
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
	
	
	public function edit_candidate()
	{
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$dob = mmddyy2mysql(trim($this->input->post('dob')));
			$added_date = date("Y-m-d h:i:sa");
			$c_id = trim($this->input->post('c_id'));
			$r_id = trim($this->input->post('r_id'));
			$log=get_logs();
			
			if($c_id!=""){
				$config['upload_path'] = './uploads/candidate_resume/';
				$config['allowed_types'] = 'doc|docx|pdf';
				$config['max_size']     = '20240';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				$field_array = array(
					"requisition_id" => trim($this->input->post('requisition_id')),
					"fname" => trim($this->input->post('fname')),
					"lname" => trim($this->input->post('lname')),
					"hiring_source" => trim($this->input->post('hiring_source')),
					"dob" => $dob,
					"email" => trim($this->input->post('email')),
					"gender" => trim($this->input->post('gender')),
					"phone" => trim($this->input->post('phone')),
					"last_qualification" => trim($this->input->post('last_qualification')),
					"skill_set" => trim($this->input->post('skill_set')),
					"total_work_exp" => trim($this->input->post('total_work_exp')),
					"country" => trim($this->input->post('country')),
					"state" => trim($this->input->post('state')),
					"city" => trim($this->input->post('city')),
					"postcode" => trim($this->input->post('postcode')),
					"address" => trim($this->input->post('address')),
					"summary" => trim($this->input->post('summary')),
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				);
				
				if (!$this->upload->do_upload('attachment')){
					$error = $this->upload->display_errors();
					$data['message'] = $error;
					//echo $error;
				}else{
					$resume_file = $this->upload->data();
					//print_r($resume_file);
					$field_array["attachment"] = $resume_file['file_name'];
				}
				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array);
				
				$ans="done";
				
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("dfr/view_requisition/$r_id");
		}
	}
	

///////////////////////// Candidate	Experience & Qualification Part /////////////////////////////
	
	public function add_candidate_exp(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$added_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					"candidate_id" => $c_id,
					"company_name" => trim($this->input->post('company_name')),
					"designation" => trim($this->input->post('designation')),
					"from_date" => mmddyy2mysql(trim($this->input->post('from_date'))),
					"to_date" => mmddyy2mysql(trim($this->input->post('to_date'))),
					"contact" => trim($this->input->post('contact')),
					"work_exp" => trim($this->input->post('work_exp')),
					"job_desc" => trim($this->input->post('job_desc')),
					"address" => trim($this->input->post('address')),
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				);
				
				$rowid= data_inserter('dfr_experience_details',$field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("dfr/view_requisition/$r_id");
			
		}
	}
	
	public function edit_candidate_exp(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$c_exp_id = trim($this->input->post('c_exp_id'));
			$added_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					//"candidate_id" => $c_id,
					"company_name" => trim($this->input->post('company_name')),
					"designation" => trim($this->input->post('designation')),
					"from_date" => mmddyy2mysql(trim($this->input->post('from_date'))),
					"to_date" => mmddyy2mysql(trim($this->input->post('to_date'))),
					"contact" => trim($this->input->post('contact')),
					"work_exp" => trim($this->input->post('work_exp')),
					"job_desc" => trim($this->input->post('job_desc')),
					"address" => trim($this->input->post('address')),
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				);
				
				$this->db->where('id', $c_exp_id);
				$this->db->update('dfr_experience_details', $field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("dfr/view_requisition/$r_id");
		}	
	}

/////////////////////////////////

	public function add_candidate_qual(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$added_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					"candidate_id" => $c_id,
					"exam" => trim($this->input->post('exam')),
					"passing_year" => trim($this->input->post('passing_year')),
					"board_uv" => trim($this->input->post('board_uv')),
					"specialization" => trim($this->input->post('specialization')),
					"grade_cgpa" => trim($this->input->post('grade_cgpa')),
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				);
				
				$rowid= data_inserter('dfr_qualification_details',$field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("dfr/view_requisition/$r_id");
			
		}
	}
	
	
	public function edit_candidate_qual(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$c_qual_id = trim($this->input->post('c_qual_id'));
			$added_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					//"candidate_id" => $c_id,
					"exam" => trim($this->input->post('exam')),
					"passing_year" => trim($this->input->post('passing_year')),
					"board_uv" => trim($this->input->post('board_uv')),
					"specialization" => trim($this->input->post('specialization')),
					"grade_cgpa" => trim($this->input->post('grade_cgpa')),
					"added_by" => $current_user,
					"added_date" => $added_date,
					"log" => $log
				);
				
				$this->db->where('id', $c_qual_id);
				$this->db->update('dfr_qualification_details', $field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("dfr/view_requisition/$r_id");
		}	
	}
	
	
/////////////////////////////////Candidate interview Schedule part///////////////////////////////////////////////////	
	
	
	public function candidate_schedule(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$c_status = trim($this->input->post('c_status'));
			$creation_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					"c_id" => $c_id,
					"scheduled_on" => mdydt2mysql(trim($this->input->post('scheduled_on'))),
					"interview_site" => trim($this->input->post('interview_site')),
					"interview_type" => trim($this->input->post('interview_type')),
					"sh_status" => 'P',
					"remarks" => trim($this->input->post('remarks')),
					"creation_by" => $current_user,
					"creation_date" => $creation_date,
					"log" => $log
				);
				$rowid= data_inserter('dfr_interview_schedules',$field_array);
				
				if($c_id!=""){
					$field_array1 = array(
						"candidate_status" => 'IP'
					);
					$this->db->where('id', $c_id);
					$this->db->update('dfr_candidate_details', $field_array1);
				}
				//$this->Email_model->candidate_schedule($r_id,$field_array);
			}
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
	public function edit_candidate_schedule(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			$creation_date = date("Y-m-d h:i:sa");
			$log=get_logs();
			
			if($sch_id!=""){
				$field_array = array(
					"c_id" => $c_id,
					"scheduled_on" => mdydt2mysql(trim($this->input->post('scheduled_on'))),
					"interview_site" => trim($this->input->post('interview_site')),
					"interview_type" => trim($this->input->post('interview_type')),
					"remarks" => trim($this->input->post('remarks')),
					"creation_by" => $current_user,
					"creation_date" => $creation_date,
					"log" => $log
				);
				$this->db->where('id', $sch_id);
				$this->db->update('dfr_interview_schedules', $field_array);
				
				//$this->Email_model->candidate_schedule($r_id,$field_array);
			}
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
	/////////////////////////////
	
///////////////////////////////////////Cancel Interview Scheduled///////////////////////////////////////////////////

	public function cancel_interviewSchedule(){
		if(check_logged_in()){
			
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$sch_id=trim($this->input->post('sch_id'));
			$cancel_reason=trim($this->input->post('cancel_reason'));
			
			if($c_id!=""){
				$field_array = array(
					"sh_status" => 'R',
					"cancel_reason" => $cancel_reason
				);
				$this->db->where('id', $sch_id);
				$this->db->where('c_id', $c_id);
				$this->db->update('dfr_interview_schedules', $field_array);
			
			}
			
			redirect("dfr/view_requisition/$r_id");
		}
	}

//////////////////////////////////		
	
///////////////////////////////////////Candidate Interview part///////////////////////////////////////////////////

	public function add_candidate_interview(){
		
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			$sh_status = trim($this->input->post('sh_status'));
			$updated_date = date("Y-m-d h:i:sa");
			$interview_status=trim($this->input->post('interview_status'));
			$log=get_logs();
			
			$field_array = array(
				"c_id" => $c_id,
				"sch_id" => $sch_id,
				"interviewer_id" => trim($this->input->post('interviewer_id')),
				"result" => trim($this->input->post('result')),
				"interview_status" => $interview_status,
				"interview_date" => mdydt2mysql(trim($this->input->post('interview_date'))),
				"interview_remarks" => trim($this->input->post('interview_remarks')),
				"educationtraining_param" => trim($this->input->post('educationtraining_param')),
				"jobknowledge_param" => trim($this->input->post('jobknowledge_param')),
				"workexperience_param" => trim($this->input->post('workexperience_param')),
				"analyticalskills_param" => trim($this->input->post('analyticalskills_param')),
				"technicalskills_param" => trim($this->input->post('technicalskills_param')),
				"generalawareness_param" => trim($this->input->post('generalawareness_param')),
				"bodylanguage_param" => trim($this->input->post('bodylanguage_param')),
				"englishcomfortable_param" => trim($this->input->post('englishcomfortable_param')),
				"mti_param" => trim($this->input->post('mti_param')),
				"enthusiasm_param" => trim($this->input->post('enthusiasm_param')),
				"leadershipskills_param" => trim($this->input->post('leadershipskills_param')),
				"customerimportance_param" => trim($this->input->post('customerimportance_param')),
				"jobmotivation_param" => trim($this->input->post('jobmotivation_param')),
				"resultoriented_param" => trim($this->input->post('resultoriented_param')),
				"logicpower_param" => trim($this->input->post('logicpower_param')),
				"initiative_param" => trim($this->input->post('initiative_param')),
				"assertiveness_param" => trim($this->input->post('assertiveness_param')),
				"decisionmaking_param" => trim($this->input->post('decisionmaking_param')),
				"overall_assessment" => trim($this->input->post('overall_assessment')),
				"updated_by" => $current_user,
				"updated_date" => $updated_date,
				"log" => $log
			);
			
			$rowid= data_inserter('dfr_interview_details',$field_array);
			
			if($sch_id!=""){
				$field_array1 = array(
					"sh_status" => 'C'
				);
				$this->db->where('id', $sch_id);
				$this->db->update('dfr_interview_schedules', $field_array1);
			}
						
			if($interview_status=="R"){
				
				$field_array2 = array(
					"candidate_status" => 'R'
				);
				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array2);
				
			}else if($interview_status=="C"){
				$field_array3 = array(
					"candidate_status" => 'IP'
				);
				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array3);
				
			} 
			
			
			
			/* if($interview_status=="CNR"){
				$this->Email_model->send_email_candidate_further_review($current_user,$field_array,$user_office_id,$r_id,$c_id); ///required this part///
			} */
		
		
			redirect("dfr/view_requisition/$r_id");
		
		}
		
	}	
		
	public function edit_interview(){
		if(check_logged_in()){
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			
			if($sch_id!=""){
				$field_array = array(
					"interviewer_id" => trim($this->input->post('interviewer_id')),
					"result" => trim($this->input->post('result')),
					"educationtraining_param" => trim($this->input->post('educationtraining_param')),
					"jobknowledge_param" => trim($this->input->post('jobknowledge_param')),
					"workexperience_param" => trim($this->input->post('workexperience_param')),
					"analyticalskills_param" => trim($this->input->post('analyticalskills_param')),
					"technicalskills_param" => trim($this->input->post('technicalskills_param')),
					"generalawareness_param" => trim($this->input->post('generalawareness_param')),
					"bodylanguage_param" => trim($this->input->post('bodylanguage_param')),
					"englishcomfortable_param" => trim($this->input->post('englishcomfortable_param')),
					"mti_param" => trim($this->input->post('mti_param')),
					"enthusiasm_param" => trim($this->input->post('enthusiasm_param')),
					"leadershipskills_param" => trim($this->input->post('leadershipskills_param')),
					"customerimportance_param" => trim($this->input->post('customerimportance_param')),
					"jobmotivation_param" => trim($this->input->post('jobmotivation_param')),
					"resultoriented_param" => trim($this->input->post('resultoriented_param')),
					"logicpower_param" => trim($this->input->post('logicpower_param')),
					"initiative_param" => trim($this->input->post('initiative_param')),
					"assertiveness_param" => trim($this->input->post('assertiveness_param')),
					"decisionmaking_param" => trim($this->input->post('decisionmaking_param')),
					"overall_assessment" => trim($this->input->post('overall_assessment'))
				);
				$this->db->where('sch_id', $sch_id);
				$this->db->update('dfr_interview_details', $field_array);
			}
			redirect("dfr/view_requisition/$r_id");
		}
	}

//////////////////////////////////	

///////////////////////////////////////Candidate Final Interview Status///////////////////////////////////////////////////

	public function candidate_final_interviewStatus(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$candidate_status=trim($this->input->post('candidate_status'));
			
			if($c_id!=""){
				$field_array = array(
					"candidate_status" => $candidate_status
				);
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array);
			
			}
			
			redirect("dfr/view_requisition/$r_id");
		}
	}

//////////////////////////////////	

	
///////////////////////////////////////Candidate Final Selection///////////////////////////////////////////////////		
	
	public function candidate_final_approval(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$requisition_id=trim($this->input->post('requisition_id'));
			$c_status=trim($this->input->post('c_status'));
			
			if($c_id!=""){
				$field_array = array(
					"candidate_status" => 'CS',
					"approved_by" => $current_user,
					"approved_status" => 'C',
					"approved_comment" => trim($this->input->post('approved_comment')),
					"doj" => mmddyy2mysql(trim($this->input->post('doj')))
				);
				$this->db->where('id', $c_id);
				$this->db->where('candidate_status', $c_status);
				$this->db->update('dfr_candidate_details', $field_array);
			
				//$this->Email_model->send_email_candidate_final_selection($current_user,$field_array,$user_office_id,$r_id,$c_id);
			
			}
			
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
	
	public function  candidate_final_decline(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$c_status=trim($this->input->post('c_status'));
			
			if($c_id!=""){
				$field_array = array(
					"approved_by" => $current_user,
					"approved_status" => 'R',
					"approved_comment" => trim($this->input->post('approved_comment'))
				);
				$this->db->where('id', $c_id);
				$this->db->where('candidate_status', $c_status);
				$this->db->update('dfr_candidate_details', $field_array);
			}
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
////////////////////////////////
	
//////////////////////////Candidate select as Employee/////////////////////////	
	
	public function candidate_select_employee(){
		
		if(check_logged_in()){
			$current_user = get_user_id();
			
			//$r_pos=$this->input->post('req_no_position');
			///$f_pos=$this->input->post('filled_no_position');
			
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$fname=trim($this->input->post('fname'));
			$lname=trim($this->input->post('lname'));
			$office_id=trim($this->input->post('office_id'));
			$role_id = trim($this->input->post('role_id')); 
			$doj =trim($this->input->post('doj'));
			$dob=trim($this->input->post('dob'));
			$log=get_logs();
			$client_array = $this->input->post('client_id');
			$process_array = $this->input->post('process_id');
			$payroll_type=trim($this->input->post('payroll_type'));
			$payroll_status=trim($this->input->post('payroll_status'));
			$email_id_per = trim($this->input->post('email_id_per'));
			$email_id_off = trim($this->input->post('email_id_off'));
			$phone = trim($this->input->post('phone'));
			$phone_emar = trim($this->input->post('phone_emar'));
			$address = trim($this->input->post('address'));
			$country = trim($this->input->post('country'));
			$state = trim($this->input->post('state'));
			$city = trim($this->input->post('city'));
			$postcode = trim($this->input->post('postcode'));
			
			if($c_id!=""){
				
				$field_array = array(
					"xpoid" => trim($this->input->post('xpoid')),
					"omuid" => $fname.".".$lname,
					"passwd" => trim($this->input->post('passwd')),
					"fname" => $fname,
					"lname" => $lname,
					"sex" => trim($this->input->post('sex')),
					"hiring_source" => trim($this->input->post('hiring_source')),
					"dept_id" => trim($this->input->post('dept_id')),
					"sub_dept_id" => trim($this->input->post('sub_dept_id')),
					"batch_code" => trim($this->input->post('batch_code')),
					"office_id" => $office_id,
					"role_id" => $role_id,
					"org_role_id" => trim($this->input->post('org_role_id')),
					"assigned_to" => trim($this->input->post('assigned_to')),
					"status" => 1,
					"log" => $log
				);	
				
				if($doj!=""){
					 $doj=mmddyy2mysql($doj);
					 $field_array['doj']=$doj;
				}
				if($dob!=""){
					 $dob=mmddyy2mysql($dob);
					 $field_array['dob']=$dob;
				}
				
				$this->db->trans_begin();	//begin sql transaction
				
				$user_id= data_inserter('signin',$field_array);
					
					
				$evt_date = CurrMySqlDate();

				$role_his_array = array(
					"user_id" => $user_id,
					"role_id" => $role_id,
					"stdate" => $doj,
					"change_date" => $evt_date,
					"change_by" => $current_user,
					"log" => $log,
				); 
				
				$rowid= data_inserter('role_history',$role_his_array);	
				
				
				$fusion_id="";
				
				if($user_id!==FALSE)
				{
					$max_id=$this->Common_model->get_single_value("SELECT max(substr(fusion_id,5)) as value FROM signin where office_id='$office_id'");
					$max_id=$max_id+1;							
					$fusion_id="F".$office_id."".addLeadingZero($max_id,6);
					
					$Update_array = array(
							"fusion_id" => $fusion_id
					);
					$this->db->where('id', $user_id);
					$this->db->update('signin', $Update_array);
					
					foreach ($client_array as $key => $value){		
						$iClientArr = array(
							"user_id" => $user_id,
							"client_id" => $value,
							"log" => $log,
						); 
						$rowid= data_inserter('info_assign_client',$iClientArr);
					}
					
					foreach ($process_array as $key => $value){
						$iProcessArr = array(
							"user_id" => $user_id,
							"process_id" => $value,
							"log" => $log,
						);
						$rowid= data_inserter('info_assign_process',$iProcessArr);
					}
					
					if($payroll_type=="")$payroll_type='1';
					if($payroll_status=="")$payroll_status='1';
					
					$payroll_array = array(
						"user_id" => $user_id,
						"payroll_type" => $payroll_type,
						"payroll_status" => $payroll_status,
						"log" => $log
					);
					$rowid= data_inserter('info_payroll',$payroll_array);
					
					$personal_array = array(
						"user_id" => $user_id,
						"email_id_per" => $email_id_per,
						"email_id_off" => $email_id_off,
						"phone" => $phone,
						"phone_emar" => $phone_emar,
						"address_present" => $address,
						"pin" => $postcode,
						"city" => $city,
						"state" => $state,
						"country" => $country,
						"log" => $log
					);
					$rowid= data_inserter('info_personal',$personal_array);
				}
				
				$iSql="Insert into info_experience (user_id,org_name,desig,from_date,to_date,work_exp,contact,job_desc,address) select '$user_id' as user_id, company_name,designation,from_date,to_date,work_exp,contact,job_desc,address from dfr_experience_details where candidate_id = '$c_id'";
				$this->db->query($iSql);
				
				$iSql="Insert into info_education (user_id,exam,passing_year,board_uv,specialization,grade_cgpa) select '$user_id' as user_id, exam,passing_year,board_uv,specialization,grade_cgpa from dfr_qualification_details where candidate_id = '$c_id'";
				$this->db->query($iSql);
				
				
				$field_array1 = array(
					"final_comment_status" => 1
				);
				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array1);
								
				$this->db->trans_complete(); //sql transaction complete
				////////////////////	
				
				if($r_id!=""){
					
					$uSql = "Update dfr_requisition set filled_no_position = (filled_no_position+1) Where  id = $r_id ";
					$this->db->query($uSql);
				}
				
			}
			
			redirect("dfr/view_requisition/$r_id");
			
		}
	}
	
	
	public function select_process(){
		$set_array = array ();
		if(check_logged_in())
		{
			$client_id = $this->input->get('client_id');

			$SQLtxt = "SELECT id,name FROM process where client_id in($client_id) order by name";
			$fields = $this->db->query($SQLtxt);
			
			$process_data =  $fields->result_array();
			  
			echo  json_encode($process_data);
			 
		}
	}
	
	
	public function reschedule_candidate(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$c_status=trim($this->input->post('c_status'));
			
			if($c_id!=""){
				$field_array = array(
					"candidate_status" => 'IP',
					"approved_by" => $current_user,
					"approved_status" => '',
					"approved_comment" => trim($this->input->post('approved_comment'))
				);
				$this->db->where('id', $c_id);
				$this->db->where('candidate_status', $c_status);
				$this->db->update('dfr_candidate_details', $field_array);
			}
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
	////////////////////////////////////
	
/*----------------------------------------------------------*/	
////////////////////////////Create PDF for Candidate Interview Schedule/////////////////////////////////	
	
		/* public function create_pdf($c_id){
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "test.php";
			
			
			$qSql="SELECT *, (Select CONCAT(fname,' ',lname) as c  from signin s where s.id =dfr.interviewer_id ) as interviewer  FROM dfr_interview_details dfr where c_id='$c_id'";
			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$sqltxt ="SELECT interview_type, (SELECT office_name FROM office_location ol where abbr=sh.interview_site ) office_name FROM dfr_interview_schedules sh where c_id= '$c_id'";
			$data["interview_type"]=   $this->Common_model->get_query_result_array($sqltxt);
			
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM femsdev.department d where rq.department_id = d.id )as dept  FROM femsdev.dfr_candidate_details cd INNER join  femsdev.dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			$data["candidate_details"] =   $this->Common_model->get_query_result_array($sqltxt);
			$data['c_id'] = $c_id; 
			 
			 
			
			$this->load->view('dashboard',$data);
			
			
			
		}
 */
 
 

 
		public function mypdf($c_id){ 
		
			$qSql="SELECT *, (Select CONCAT(fname,' ',lname) as c  from signin s where s.id =dfr.interviewer_id ) as interviewer  FROM dfr_interview_details dfr where c_id='$c_id'";
			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$sqltxt ="SELECT interview_type, (SELECT office_name FROM office_location ol where abbr=sh.interview_site ) office_name FROM dfr_interview_schedules sh where c_id= '$c_id'";
			$data["interview_type"]=   $this->Common_model->get_query_result_array($sqltxt);
			
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM femsdev.department d where rq.department_id = d.id )as dept  FROM femsdev.dfr_candidate_details cd INNER join  femsdev.dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			$data["candidate_details"]=   $this->Common_model->get_query_result_array($sqltxt);
			$data['c_id'] = $c_id;  
			
			
			  
			/* $this->pdf->load_view('generate_pdf',$data); 
			$this->pdf->render();  */
			
			$html = $this->load->view('generate_test', $data, true);
			//$html = $this->load->view('generate_test', $data, true);
 
       //this the the PDF filename that user will get to download
			$pdfFilePath = "output_pdf_name.pdf";

			//load mPDF library
			$this->load->library('m_pdf');

		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);

			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");		 

		}
		
		
		
		
		
	
}	


?>