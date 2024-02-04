<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dfr extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//$this->load->helper(array('form', 'url','dfr_functions'));
		$this->load->model('Common_model');
		$this->load->model('Dfr_model');
		$this->load->model('Dfr_email_model');
		$this->load->model('Candidate_model');
		$this->load->model('Email_model');
		$this->load->model('Profile_model');
		$this->load->model('user_model');
				
	}
	

///////////////////////////////////////////////////////////////////////	
///////////////////////// Requisition part ////////////////////////////
///////////////////////////////////////////////////////////////////////

	public function index()
	{
		if(check_logged_in())
		{
			if(get_login_type() == "client") redirect(base_url().'client',"refresh");
			if(is_access_dfr_module() == false) redirect(base_url().'home',"refresh");
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			$data['current_user'] = get_user_id();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/manage_requisition.php";
			
			
			$data["department_data"] = $this->Common_model->get_department_list();
			
			$data["role_data"] = $this->Common_model->get_rolls_for_assignment();
			
			$data["location_data"] = $this->Common_model->get_office_location_list();
			
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$req_status = trim($this->input->post('req_status'));
			if($req_status=="") $req_status = trim($this->input->get('req_status'));
			if($req_status=="") $req_status=0;
			
			$_cond1="";
			
			if($req_status==0) $_cond1=" requisition_status in ('A')";
			else if($req_status==1) $_cond1=" requisition_status='CL'";
			else if($req_status==3) $_cond1=" requisition_status='P'";
			else $_cond1=" requisition_status in ('C','R')";
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$client_id = $this->input->get('client_id');
			$process_id = $this->input->get('process_id');
			
			$_filterCond="";
			
			if($is_global_access!=1 && $oValue=="" ) $oValue=$user_office_id;
			
			
			if( $is_global_access!=1) $_filterCond .=" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " and location='".$oValue."'";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
			
			if($client_id!="ALL" && $client_id!=""){
				if($_filterCond=="") $_filterCond .= " and client_id='".$client_id."'";
				else $_filterCond .= " and client_id='".$client_id."'";
			}
			
			if($process_id!="ALL" && $process_id!="" && $process_id!="0"){
				if($_filterCond=="") $_filterCond .= " and process_id='".$process_id."'";
				else $_filterCond .= " and process_id='".$process_id."'";
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($is_global_access==1){
				
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition where $_cond1 ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' and $_cond1 ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' and $_cond1 ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["get_requisition_list"] = $get_requisition_list = $this->Dfr_model->get_requisition_data($_filterCond,$_cond1);
			
			
			if($is_global_access==1){
				$qSql="select id, fusion_id, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name, (select name from role r where r.id=signin.role_id) as role_name from signin where ((dept_id =6 and role_id in (select id from role where folder in ('manager', 'tl'))) OR dept_id =11 ) and status=1 order by fname";
				
				$data["trainer_details"] = $this->Common_model->get_query_result_array($qSql);
			}else{	
				$trnCond=" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
				
				$qSql="select id, fusion_id, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name, (select name from role r where r.id=signin.role_id) as role_name from signin where ((dept_id = 6 and role_id in (select id from role where folder in ('manager', 'tl'))) OR dept_id =11 ) $trnCond and status=1 order by fname";
				$data["trainer_details"] = $this->Common_model->get_query_result_array($qSql);
			}	
			
			$data['req_status']=$req_status;
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			$data['client_id']=$client_id;
			$data['process_id']=$process_id;
			
			$this->load->view('dashboard',$data);
		}
	}


	public function getl1super(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			
			$roleFolder=$this->input->post('role_folder');
			
			if( $is_global_access==1){
				
				$qSql="select id, fusion_id, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name, (select name from role r where r.id=signin.role_id) as role_name from signin where (role_id in (select id from role where folder in ('manager', 'tl', 'admin', 'super')) OR dept_id=11) and status=1 and fusion_id!='FKOL000001' order by fname";
				
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			
			}else{
				
				if($roleFolder=='admin' || $roleFolder=='super'){
					
					//$trnCond=" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
					
					$qSql="select id, fusion_id, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name, (select name from role r where r.id=signin.role_id) as role_name from signin where (role_id in (select id from role where folder in ('admin', 'super')) OR dept_id=11) and status=1 and fusion_id!='FKOL000001' order by fname";
					//echo $qSql;
					
					echo json_encode($this->Common_model->get_query_result_array($qSql));
					
				}else{
					$trnCond=" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
					
					$qSql="select id, fusion_id, concat(fname, ' ', lname) as name, (select shname from department d where d.id=signin.dept_id) as dept_name, (select name from role r where r.id=signin.role_id) as role_name from signin where (role_id in (select id from role where folder in ('manager', 'tl')) OR dept_id=11) $trnCond and status=1 and fusion_id!='FKOL000001' order by fname";
					//echo $qSql;
					
					echo json_encode($this->Common_model->get_query_result_array($qSql));
				}
			}
		}
	}
////////////////////////////	
	
	public function add_requisition()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			//$requisition_id = trim($this->input->post('requisition_id'));
			$location = trim($this->input->post('location'));
			$department_id = trim($this->input->post('department_id'));
			//$due_date = mmddyy2mysql(trim($this->input->post('due_date')));
			$curryear = date("Y");
			$raised_date = CurrMySqlDate();
			$log=get_logs();
			
			if($department_id==6){
				$dueDate=date('y:m:d', strtotime("+28 days"));
			}else{
				$dueDate=date('y:m:d', strtotime("+45 days"));
			}
			
			//we remove department_id;
			//"requisition_id" => generate_requisition_id($location."".$department_id."".$curryear),
			
			if($location!=""){
				
				$field_array = array(
					"requisition_id" => generate_requisition_id($location."".$curryear),
					"req_type" => trim($this->input->post('req_type')),
					"location" => $location,
					"department_id" => $department_id,
					"due_date" => $dueDate,
					"role_id" => trim($this->input->post('role_id')),
					"client_id" => trim($this->input->post('client_id')),
					"process_id" => trim($this->input->post('process_id')),
					"employee_status" => trim($this->input->post('employee_status')),
					"req_qualification" => trim($this->input->post('req_qualification')),
					"req_exp_range" => trim($this->input->post('req_exp_range')),
					"req_no_position" => trim($this->input->post('req_no_position')),
					//"filled_no_position" => trim($this->input->post('filled_no_position')),
					"job_title" => trim($this->input->post('job_title')),
					"job_desc" => trim($this->input->post('job_desc')),
					"req_skill" => trim($this->input->post('req_skill')),
					"additional_info" => trim($this->input->post('additional_info')),
					"raised_by" => $current_user,
					"raised_date" => $raised_date,
					"requisition_status" => 'P',
					"log" => $log
				);
				
				//print_r($field_array);
				
				$rowid = data_inserter('dfr_requisition',$field_array);
				
				if($rowid!==FALSE){ 
					$this->Email_model->send_email_requisition_raised($current_user,$field_array);
					redirect("dfr?req_status=3");
					
				}else{
					echo "error to save requisition";
				}
			
			}	
		}
	}
	
	
	public function edit_requisition()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			//removed from model form
			//$requisition_id = trim($this->input->post('requisition_id'));

			
			$req_type = trim($this->input->post('req_type'));
			
			$location = trim($this->input->post('location'));
			$due_date = mmddyy2mysql(trim($this->input->post('due_date')));
			$department_id = trim($this->input->post('department_id'));
			$role_id = trim($this->input->post('role_id'));
			$employee_status = trim($this->input->post('employee_status'));
			$req_qualification = trim($this->input->post('req_qualification'));
			$req_exp_range = trim($this->input->post('req_exp_range'));
			$req_no_position = trim($this->input->post('req_no_position'));
			//$filled_no_position = trim($this->input->post('filled_no_position'));
			$job_title = trim($this->input->post('job_title'));
			$job_desc = trim($this->input->post('job_desc'));
			$req_skill = trim($this->input->post('req_skill'));
			$additional_info = trim($this->input->post('additional_info'));
			$updated_date = CurrMySqlDate();
			$log=get_logs();
			$curryear = date("Y");
			
			
			$qSql = "Select requisition_id as value from dfr_requisition where id = '$r_id'";
			$requisition_id = $this->Common_model->get_single_value($qSql);
						
			if( substr($requisition_id,0,3) == $location){
					// do not change the requisition_id
			}else{
				$requisition_id = generate_requisition_id($location."".$curryear);
			}
			// now we remove department_id;
			//"requisition_id" => generate_requisition_id($location."".$department_id."".$curryear),
			
			if($r_id!=""){
				$field_array = array(
					"requisition_id" => $requisition_id,
					"req_type" => $req_type,
					"location" => $location,
					"due_date" => $due_date,
					"department_id" => $department_id,
					"role_id" => $role_id,
					"employee_status" => $employee_status,
					"client_id" => trim($this->input->post('client_id')),
					"process_id" => trim($this->input->post('process_id')),
					"req_qualification" => $req_qualification,
					"req_exp_range" => $req_exp_range,
					"req_no_position" => $req_no_position,
					//"filled_no_position" => $filled_no_position,
					"job_title" => $job_title,
					"job_desc" => $job_desc,
					"req_skill" => $req_skill,
					"additional_info" => $additional_info,
					"updated_by" => $current_user,
					"updated_date" => $updated_date,
					"log" => $log
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			//echo $ans;
			//redirect("dfr");
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr";
			redirect($referer);
		}
	}
		
	public function cancelRequisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$requisition_id = trim($this->input->post('requisition_id'));
			$requisition_status = trim($this->input->post('requisition_status'));
			$cancel_comment = trim($this->input->post('cancel_comment'));
			$cancel_date = CurrMySqlDate();
			
			if($r_id!=""){
				$field_array = array(
					"cancel_by" => $current_user,
					"cancel_date" => $cancel_date,
					"cancel_comment" => $cancel_comment,
					"requisition_status" => 'C'
				);
				$this->db->where('id', $r_id);
				$this->db->where('requisition_status', $requisition_status);
				$this->db->update('dfr_requisition', $field_array);
				//$ans="done";
			}
			redirect("dfr");
		}
	}
	
//////////////Handover & Closed Requisition//////////////////
	public function assignTLRequisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$dept_id = trim($this->input->post('dept_id'));
			$role_folder = trim($this->input->post('role_folder'));
			
			if($dept_id=='6' && $role_folder=='agent'){
				$l1_supervisor = trim($this->input->post('assign_trainer'));
			}else{
				$l1_supervisor = trim($this->input->post('l1_supervisor'));
			}
			
			if($r_id!=""){
				$field_array = array(
					"l1_supervisor" => $l1_supervisor,
					"assign_tl_date" => CurrDate(),
					"assign_tl_by" => $current_user
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
			}
			redirect("dfr");
		}
	}
	
	
/////////////////Requisition Closed Section///////////////////////

	public function handover_dfr_requisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/handover_requisition.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$_filterCond="";
			
			$off_id = $this->input->get('off_id');
			if($off_id =='') $off_id="All";
			
			if( $is_global_access!=1){
				$_filterCond .=" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			}else{
				if($off_id=='All'){
					$_filterCond ="";
				}else{
					$_filterCond .=" and location='$off_id'";
				}
			}
			
			$qSql="Select b.*, DATE_FORMAT(due_date,'%m/%d/%Y') as dueDate,
					(select location from office_location o where o.abbr=b.location) as off_loc,
					(select shname from department d where d.id=b.department_id) as department_name, 
					(select name from role r where r.id=b.role_id) as role_name,
					(select concat(fname, ' ', lname) as name from signin x where x.id=b.raised_by) as raised_name,
					(select shname from client c where c.id=b.client_id) as client_name,
					(select name from process p where p.id=b.process_id) as process_name,
					(select count(id) from dfr_candidate_details dcd where dcd.r_id=b.id) as can_count, 
					(select concat(fname, ' ', lname) as name from signin x where x.id=b.l1_supervisor) as l1_sup_name,
					(select count(id) from dfr_candidate_details cd where cd.r_id=b.id and cd.candidate_status='E') as count_canasempl,
					(select folder from role rf where rf.id=b.role_id) as role_folder
					from dfr_requisition b where ( b.l1_supervisor!='' or (b.l1_supervisor='' or department_id!=6) ) and b.requisition_status!='CL' $_filterCond order by b.requisition_id asc";	
					
			$data["handover_requisition_list"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data['off_id'] = $off_id;
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
// Modifie by saikat on 08/11/19
	public function handover_closed_requisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$rid = trim($this->input->post('rid'));
			$handoverid = trim($this->input->post('handoverid'));
			$raised_by = trim($this->input->post('raised_by'));
			$dept_id = trim($this->input->post('dept_id'));
			$role_folder = trim($this->input->post('role_folder'));
			$phase_type = trim($this->input->post('phase_type'));
			$closed_date = CurrMySqlDate();
			$closeDate = CurrDate();
			$closed_comment = trim($this->input->post('closed_comment'));
			$log=get_logs();
			
			if($rid!="")
			{
				$this->db->trans_begin();
								
				if($handoverid!=''){
					
					$this->db->query("Update signin set assigned_to='$handoverid', phase='$phase_type' where dfr_id in (select id from dfr_candidate_details where r_id='$rid' and candidate_status='E')");
					
					$field_array = array(
						"closed_by" => $current_user,
						"closed_date" => $closed_date,
						"closed_comment" => $closed_comment,
						"requisition_status" => 'CL'
					);
					
					$this->db->where('id', $rid);
					$this->db->update('dfr_requisition', $field_array);
				
				}else{
					
					$this->db->query("Update signin set assigned_to='$raised_by', phase='$phase_type' where dfr_id in (select id from dfr_candidate_details where r_id='$rid' and candidate_status='E') ");
					
					$field_array = array(
						"l1_supervisor" => $raised_by,
						"assign_tl_date" => $closed_date,
						"assign_tl_by" => $current_user,
						"closed_by" => $current_user,
						"closed_date" => $closed_date,
						"closed_comment" => $closed_comment,
						"requisition_status" => 'CL'
					);
					
					$this->db->where('id', $rid);
					$this->db->update('dfr_requisition', $field_array);	
				}
				
				///////////
								
				$qSql = "Select * from dfr_requisition where id='$rid' ";
				$dfrRow = $this->Common_model->get_query_row_array($qSql);
				
				$client_id= $dfrRow['client_id'];
				$process_id= $dfrRow['process_id'];
				$trnBatchid="";
				$requisition_id = $dfrRow['requisition_id'];
				$dfr_office_id = $dfrRow['location'];
				$dfr_jobtitle = $dfrRow['job_title'];
				
				$trn_batch_name = $dfr_jobtitle ."-" .$requisition_id;
				$trn_note= "Handover from $requisition_id";
				
				if($dept_id=='6' && $role_folder=='agent' && $phase_type=='2'){
					
					$trnBatchArr = array(
						"trainer_id" => $handoverid,
						"trn_type" => $phase_type,
						"ref_type" => 'D',
						"ref_id" => $rid,
						"client_id" => $client_id,
						"process_id" => $process_id,
						"trn_start_date" => $closeDate,
						"trn_batch_status" => '1',
						"batch_name" => $trn_batch_name,						
						"batch_office_id" => $dfr_office_id,
						"hr_handover_by" => $current_user,
						"hr_handover_date" => $closed_date
					);
					
					$trnBatchid = data_inserter('training_batch',$trnBatchArr);
					
				}	
								
				
				///////Phase History///////
				$qSql="select id from signin where dfr_id in (select id from dfr_candidate_details where r_id='$rid' and candidate_status='E') order by id asc";
				$phaseHistory =  $this->Common_model->get_query_result_array($qSql);
				
				foreach ($phaseHistory as $value){
					
					$this->db->query("Update phase_history set end_date='$closeDate' where user_id=". $value['id'] ." and phase_type=1");
					
						$phaseArr = array(
							"user_id" => $value['id'],
							"phase_type" => $phase_type,
							"start_date" => $closeDate,
							"remarks" => $closed_comment,
							"event_by" => $current_user,
							"log" => $log
						);
						
						$rowid= data_inserter('phase_history',$phaseArr);
										
						if($dept_id=='6' && $role_folder=='agent' && $phase_type=='2' && $trnBatchid!==FALSE){
						
						$trn_detailsArr = array(
							"trn_batch_id" => $trnBatchid,
							"user_id" => $value['id'],
							"trn_status" => $phase_type,
							"trn_note" => $trn_note
						);
						
						$rowid = data_inserter('training_details',$trn_detailsArr);
						
						}	
					
				}// for phaseHistory
				
				
				
				//////////////////////
				$this->db->trans_complete();
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					$lastError = error_get_last();
					$msg=$lastError ? "Error: ".$lastError["message"]." on line ".$lastError["line"] : "  ";
					log_message('FEMS',  'Error On handover_closed_requisition:: ', $msg);
											
				}else{
					
					$this->db->trans_commit();
					
					if($dept_id=='6' && $role_folder=='agent'){
						$this->Email_model->send_email_operation_handover_requisition($rid, $raised_by);
					}else{
						$this->Email_model->send_email_support_handover_requisition($rid, $raised_by, $handoverid);
					}
					
				}
				
				redirect("dfr/handover_dfr_requisition");
				
			}
		}
	}
	
	
	
	public function handover_forced_closed_requisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$rid = trim($this->input->post('rid'));
			$raised_by = trim($this->input->post('raised_by'));
			$dept_id = trim($this->input->post('dept_id'));
			$role_folder = trim($this->input->post('role_folder'));
			$phase_type = trim($this->input->post('phase_type'));
			$closed_date = CurrMySqlDate();
			$closeDate = CurrDate();
			$closed_comment = trim($this->input->post('closed_comment'));
			
			$qSql= "SELECT log from dfr_requisition where id='$rid'";
			$Prev_Log=getDBPrevLogs($qSql);
			
			$log= "Forced Closed: ". get_logs($Prev_Log);
			
			if($rid!="")
			{
				$this->db->trans_begin();
				
								
				$field_array = array(
					"closed_by" => $current_user,
					"closed_date" => $closed_date,
					"closed_comment" => $closed_comment,
					"requisition_status" => 'CL',
					"log" => $log
				);
				
				$this->db->where('id', $rid);
				$this->db->update('dfr_requisition', $field_array);
						
				if($phase_type>0){
					
					$this->db->query("Update signin set phase='$phase_type' where dfr_id in (select id from dfr_candidate_details where r_id='$rid' and candidate_status='E')");
					
					///////Phase History///////
					$qSql="select id from signin where dfr_id in (select id from dfr_candidate_details where r_id='$rid' and candidate_status='E') order by id asc";
					$phaseHistory =  $this->Common_model->get_query_result_array($qSql);
					
					foreach ($phaseHistory as $value){
						
						$this->db->query("Update phase_history set end_date='$closeDate' where user_id=". $value['id'] ." and phase_type=1");
						
							$phaseArr = array(
								"user_id" => $value['id'],
								"phase_type" => $phase_type,
								"start_date" => $closeDate,
								"remarks" => $closed_comment,
								"event_by" => $current_user,
								"log" => $log
							);
							
							$rowid= data_inserter('phase_history',$phaseArr);
										
					}// for phaseHistory
				
				}
				
				//////////////////////
				$this->db->trans_complete();
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					$lastError = error_get_last();
					$msg=$lastError ? "Error: ".$lastError["message"]." on line ".$lastError["line"] : "  ";
					log_message('FEMS',  'Error On handover_closed_requisition:: ', $msg);		
				}else{
					$this->db->trans_commit();					
				}
				
				redirect("dfr");
				
			}
		}
	}
	
	
	
	
	
//////////////Reopen Requisition//////////////////
	public function reopenRequisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$reopen_comment = trim($this->input->post('reopen_comment'));
			$reopen_date = CurrMySqlDate();
			
			if($r_id!=""){
				$field_array = array(
					"reopen_by" => $current_user,
					"reopen_date" => $reopen_date,
					"reopen_comment" => $reopen_comment,
					"requisition_status" => 'A'
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
			}
			redirect("dfr");
		}
	}
	
	
//////////////////////////////////Create PDF Part Start/////////////////////////////////////////
//////////
	public function view_candidate_details($c_id){
		if(check_logged_in()){
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			//$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/candidate_details.php";
			
			$qSql="SELECT * from (Select *, DATE_FORMAT(added_date, '%m/%d/%Y') as addedDate from dfr_candidate_details where id='$c_id') xx Left Join (Select *, (select name from role r where r.id=dfr_requisition.role_id) as position_name from dfr_requisition) yy On (xx.r_id=yy.id)";
			$data["candidate_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="SELECT * FROM dfr_qualification_details where candidate_id='$c_id'";
			$data["can_education_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_experience_details where candidate_id='$c_id'";
			$data["can_experience_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_candidate_family_info where candidate_id='$c_id'";
			$data["can_family_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$data['c_id'] = $c_id;  
			 
			$this->load->view('dashboard_single_col',$data);
			
		}
	}
	
	
	public function candidate_details_pdf($c_id){
			
			if(check_logged_in()){
				
			//load mPDF library
			$this->load->library('m_pdf');
			
			
			$qSql="SELECT * from (Select *, DATE_FORMAT(added_date, '%m/%d/%Y') as addedDate from dfr_candidate_details where id='$c_id') xx Left Join (Select *, (select name from role r where r.id=dfr_requisition.role_id) as position_name from dfr_requisition) yy On (xx.r_id=yy.id)";
			
			$data["candidate_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="SELECT * FROM dfr_qualification_details where candidate_id='$c_id'";
			$data["can_education_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_experience_details where candidate_id='$c_id'";
			$data["can_experience_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * FROM dfr_candidate_family_info where candidate_id='$c_id'";
			$data["can_family_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data['c_id'] = $c_id;  
			
			
			$html=$this->load->view('dfr/candidatedetails_pdf', $data, true);

			//this the the PDF filename that user will get to download
			$pdfFilePath = "candidate_details.pdf";
			
			$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");		
		}
			
	}
	
	
	public function view_candidate_interview($c_id){
		if(check_logged_in()){
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			//$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/candidate_interview_report.php";
			
									
			$sqltxt ="SELECT inv.*, (Select name from dfr_interview_type_mas mas where mas.id =sch.interview_type ) as parameter , getInterviewerName(sch.interview_type,inv.interviewer_id) as interviewer  FROM dfr_interview_schedules sch Left Join dfr_interview_details inv on sch.id = inv.sch_id  where  sch.c_id='$c_id'";
			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($sqltxt);
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM  department d where rq.department_id = d.id )as dept  FROM  dfr_candidate_details cd INNER join   dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			//$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,pool_location,@dept=null AS dept  FROM  dfr_candidate_details cd where cd.id = $c_id";
			
			$data["candidate_details"]=   $this->Common_model->get_query_result_array($sqltxt);
			
			$data['c_id'] = $c_id; 
		
			 
			 $this->load->view('dashboard_single_col',$data);
			
			
		}
	}
	
	public function interview_pdf($c_id){ 
			if(check_logged_in())
			{
			
			//load mPDF library
			$this->load->library('m_pdf');
			
			$sqltxt ="SELECT inv.*,(Select name from dfr_interview_type_mas mas where mas.id =sch.interview_type ) as parameter , getInterviewerName(sch.interview_type,inv.interviewer_id) as interviewer  FROM dfr_interview_schedules sch Left Join dfr_interview_details inv on sch.id = inv.sch_id  where  sch.c_id='$c_id'";
			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($sqltxt);
			
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM  department d where rq.department_id = d.id )as dept  FROM  dfr_candidate_details cd INNER join   dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			$data["candidate_details"]=   $this->Common_model->get_query_result_array($sqltxt);
			$data['c_id'] = $c_id;  
			
			  
			/* $this->pdf->load_view('generate_pdf',$data); 
			$this->pdf->render();  */
			
			$html=$this->load->view('dfr/generate_pdf', $data, true);

			//this the the PDF filename that user will get to download
			$pdfFilePath = "interview_". time() .".pdf";
			
			$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");		
			
			}
			
		}
		
//////////////////////////////////End PDF Part///////////////////////////////////////////	
		
	
	
	public function view_requisition($id)
	{
		if(check_logged_in())
		{
			if(get_login_type() == "client") redirect(base_url().'client',"refresh");
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$user_oth_office=get_user_oth_office();
			

			$data["is_global_access"] = get_global_access();
			
			$data["is_role_dir"] = get_role_dir(); 
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/view_requisition.php";
			
			$country_Sql="Select * FROM master_countries ORDER BY name ASC";
			$data["get_countries"] = $this->Common_model->get_query_result_array($country_Sql);
			
			$data["view_reuisition"] = $this->Dfr_model->view_requisition_data($id);
			
			
			$sql_paytype = "SELECT * from master_payroll_type WHERE is_active = '1'";
			$data['paytype'] = $this->Common_model->get_query_result_array($sql_paytype);
			
			$sql_selected = "SELECT * from master_currency WHERE is_active = '1'";
			$data['mastercurrency'] = $this->Common_model->get_query_result_array($sql_selected);
			
			
			$qSql="select location as value from dfr_requisition cd where id='$id' ";
			$req_office_id = $this->Common_model->get_single_value($qSql);
			
			$CondOth=" OR (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
			$qSql="Select fusion_id, xpoid, fname,lname, office_id from signin where status=1 and office_id='$req_office_id' $CondOth and role_id > 0 order by fname";
			$data["user_list_ref"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, r.client_id, r.process_id , r.l1_supervisor, c.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name from dfr_requisition r, dfr_candidate_details c where  r.id=c.r_id and r_id='$id' ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
				//echo $qSql;
			$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="Select abbr, office_name, location from office_location where is_active=1";
			$data["get_site_location"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id, name from dfr_interview_type_mas where is_active=1";
			$data["dfr_interview_type_mas"] = $this->Common_model->get_query_result_array($qSql);
			
			if(get_global_access()==1 || ( get_dept_id()=="hr" && (get_role_dir()=="manager" || get_role_dir()=="admin" )) ){
				$qSql="SELECT id,name, org_role  FROM role where is_active=1 and id > 0 ORDER BY name";
			}else{
				$qSql="SELECT id,name, org_role  FROM role where is_active=1 and folder not in('super') ORDER BY name";
			}
			
			$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			$qSql="select count(id) as value from dfr_candidate_details cd where r_id='$id' and cd.candidate_status='E'";
			$data['filled_pos'] = $this->Common_model->get_single_value($qSql);
			
			if(get_role_dir()!="super" && get_global_access()!=1){
								
				$tl_cnd=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}else{ 
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}
			
			$data["role_data"] = $this->Common_model->get_rolls_for_assignment();
			
			if(get_role_dir()=="super" || get_global_access()==1 ){
				$data['location_data'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_data'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data["get_department_data"] = $this->Common_model->get_department_list();
			
			$data['organization_role'] = $this->Common_model->role_organization();
			
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			$data['payroll_type_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_type where is_active=1");
			$data['payroll_status_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_status where is_active=1");
			$cSql="Select * FROM master_countries ORDER BY name ASC";
			$data["get_countries"] = $this->Common_model->get_query_result_array($cSql);
			
			$rCond = " and ( role_id not in ( Select id from role where folder = 'agent' ) OR dept_id = 3 )";
			
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1  $rCond order by name asc ";
			$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
						
			if(get_global_access()!=1){
				if($user_office_id != 'CEB' && $user_office_id != 'MAN')
				{
					$qual_quary=$this->db->query("SELECT * FROM `master_qualifications` where location_id IS NULL");
				}
				else
				{
					$qual_quary=$this->db->query("SELECT * FROM `master_qualifications` where location_id='".$user_office_id."'");
				}
				
			}else{
				$qual_quary=$this->db->query("SELECT * FROM `master_qualifications`  GROUP BY qualification");
			}
			
			$data["qualification_list"] = $qual_quary->result_object();
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	public function approved_requisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$deptid = trim($this->input->post('deptid'));
			$raisedby = trim($this->input->post('raisedby'));
			$approved_comment = trim($this->input->post('approved_comment'));
			$approved_date = CurrMySqlDate();
			$assign_tl_date=CurrDate();
			
			if($r_id!=""){
				$field_array = array(
					"approved_by" => $current_user,
					"approved_date" => $approved_date,
					"approved_comment" => $approved_comment,
					"requisition_status" => 'A'
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
				
				/* if($deptid!=6){
					$this->db->query("Update dfr_requisition set l1_supervisor='$raisedby', assign_tl_date='$assign_tl_date', assign_tl_by='$current_user' where id='$r_id'");
				} */
				
				// CHECK REQUISITION TYPE
				$sqlCheck = "SELECT d.*, r.org_role from dfr_requisition as d LEFT JOIN role as r ON r.id = d.role_id WHERE d.id = '$r_id'";
				$dfrCheck = $this->Common_model->get_query_row_array($sqlCheck);
				if($dfrCheck['org_role'] != 13)
				{
					// for non-production hiring
					if(empty($dfrCheck['l1_supervisor'])){
						$updateArray = [
							"l1_supervisor" => $raisedby,
							"assign_tl_date" => $assign_tl_date,
							"assign_tl_by" => $current_user,
						];
						$this->db->where('id', $r_id);
						$this->db->update('dfr_requisition', $updateArray);
						$this->Dfr_email_model->send_email_notification_autosupervisor($dfrCheck['requisition_id']);
					}
				} else {
					// for production hiring
					if(empty($dfrCheck['l1_supervisor'])){
						$this->Dfr_email_model->send_email_notification_supervisor($dfrCheck['requisition_id']);
					}
				}
				
				$this->Email_model->hiring_requis_approve($current_user,$r_id,$field_array);
				redirect("dfr/view_requisition/$r_id");
				
			}	
		}
	}
	
	public function decline_requisition(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$approved_comment = trim($this->input->post('approved_comment'));
			$approved_date = CurrMySqlDate();
			
			if($r_id!=""){
				$field_array = array(
					"approved_by" => $current_user,
					"approved_date" => $approved_date,
					"approved_comment" => $approved_comment,
					"requisition_status" => 'R'
				);
				$this->db->where('id', $r_id);
				$this->db->update('dfr_requisition', $field_array);
				
				$this->Email_model->hiring_requis_decline($current_user,$r_id,$field_array);
				redirect("dfr");
				
			}
		}
	}
	
	/////////////////Pending, In-Progress, Shortlisted, Selected & Rejected Candidates ///////////////////////
	
	public function pending_candidate(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/pending_candidate.php";
						
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id, name from dfr_interview_type_mas where is_active=1";
			$data["dfr_interview_type_mas"] = $this->Common_model->get_query_result_array($qSql);
			
			$rCond = " and ( role_id not in ( Select id from role where folder = 'agent' ) OR dept_id = 3 )";
			
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1 $rCond order by name asc ";
			$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" And ( location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
						
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
						
			if(get_role_dir()=="super" || $is_global_access==1){
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
						
			$data["pending_candidate"] = $this->Dfr_model->get_pending_candidates($_filterCond);
			
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	public function inprogress_candidate(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/inprogress_candidate.php";
						
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id, name from dfr_interview_type_mas where is_active=1";
			$data["dfr_interview_type_mas"] = $this->Common_model->get_query_result_array($qSql);
			
			$rCond = " and ( role_id not in ( Select id from role where folder = 'agent' ) OR dept_id = 3 )";
			
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1 $rCond order by name asc ";
			$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" And ( location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
						
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
						
			if(get_role_dir()=="super" || $is_global_access==1){
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
						
			$data["inprogress_shortlisted"] = $this->Dfr_model->get_inprogress_candidates($_filterCond);
			
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	public function shortlisted_candidate(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/shortlisted_candidate.php";
			
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			$sql_paytype = "SELECT * from master_payroll_type WHERE is_active = '1'";
			$data['paytype'] = $this->Common_model->get_query_result_array($sql_paytype);
			
			$sql_selected = "SELECT * from master_currency WHERE is_active = '1'";
			$data['mastercurrency'] = $this->Common_model->get_query_result_array($sql_selected);
			
			$data['myoffice_id'] = $user_office_id;
			$data['setcurrency']['ALL'] = array('ALB');
			$data['setcurrency']['CAD'] = array('MON');
			$data['setcurrency']['EUR'] = array('');
			$data['setcurrency']['GBP'] = array('UKL');
			$data['setcurrency']['INR'] = array('HWH','KOL','BLR','CHE','NOI');
			$data['setcurrency']['JMD'] = array('JAM');
			$data['setcurrency']['PHP'] = array('CEB','MAN');
			$data['setcurrency']['USD'] = array('ELS','DRA');
			
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if(get_role_dir()=="super" || $is_global_access==1){
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["candidate_shortlisted"] = $this->Dfr_model->get_shortlisted_candidates($_filterCond);
			
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function selected_candidate(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$ses_dept_id=get_dept_id();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/selected_candidate.php";
			
			
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$data["get_department_data"] = $this->Common_model->get_department_list();
			$data['organization_role'] = $this->Common_model->role_organization();
			
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			
			$data['payroll_type_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_type where is_active=1");
			$data['payroll_status_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_status where is_active=1");
			
			if(get_global_access()==1 || ( get_dept_id()=="hr" && (get_role_dir()=="manager" || get_role_dir()=="admin" )) ){
				$qSql="SELECT id,name, org_role  FROM role where is_active=1 and id > 0 ORDER BY name";
			}else{
				$qSql="SELECT id,name, org_role  FROM role where is_active=1 and folder not in('super') ORDER BY name";
			}
			
			$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			
			if(get_role_dir()!="super" && get_global_access()!=1){
				//$tl_cnd=" and office_id='$user_office_id' ";
				$tl_cnd=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
				
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}else{ 
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}
			
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			$data["candidate_selected"] = $this->Dfr_model->get_selected_candidates($_filterCond);
			
			$cSql="Select * FROM master_countries ORDER BY name ASC";
			$data["get_countries"] = $this->Common_model->get_query_result_array($cSql);
			
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function rejected_candidate(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/rejected_candidate.php";
			
			
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			$data["candidate_rejected"] = $this->Dfr_model->get_rejected_candidates($_filterCond);
			
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
		}
	}

/////////////////////////////////////////////////////////////


public function view_uploaded_docs(){

		if(check_logged_in()){
	
		$data['c_id'] = $c_id = $this->input->get('c_id');

		$req_id = $this->input->get('requisition_id');
		$data['user_office_id']= substr($req_id, 0,3);
		
		// $data["captcha"] = $this->captcha();
		$personalSql="Select pan from dfr_candidate_details where id='$c_id'";
		$data["get_personal"] = $this->Common_model->get_query_result_array($personalSql);

		$personalSql="Select * from dfr_candidate_details where id='$c_id'";
		$data["get_person"] = $this->Common_model->get_query_result_array($personalSql);

		$expSql="Select * from dfr_experience_details where candidate_id ='$c_id'";
		$data["get_exp"] = $this->Common_model->get_query_result_array($expSql);
		
		$eduSql="Select * from dfr_qualification_details where candidate_id='$c_id'";
		$data["get_edu"] = $this->Common_model->get_query_result_array($eduSql);

		$this->load->view('dfr/documents',$data);
		
		}

}



/////////////////All Candidates List///////////////////////



	public function all_candidate_lists(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/candidates_list_all.php";
			
			
			$date_from=($this->input->get('date_from'));	
			$date_to=($this->input->get('date_to'));			
			
			
			if($date_from==""){ 
				$date_from=CurrDate();
			}else{
				$date_from = mmddyy2mysql($date_from);
			}
			
			if($date_to==""){ 
				$date_to=CurrDate();
			}else{
				$date_to = mmddyy2mysql($date_to);
			}
			
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if($date_from!="" && $date_to!=="") $_filterCond .=" And (date(added_date)>='$date_from' and date(added_date)<='$date_to')";
			
			
			//if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			//}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" And (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " And location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			
			$qSql="Select r.id as rid, r.requisition_id as req_id, r.req_no_position, r.department_id, r.role_id, r.location, r.requisition_status, c.*, concat(fname, ' ', lname) as name, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, (select count(id) from dfr_candidate_details cd where cd.r_id=r.id and cd.candidate_status='E') as filled_no_position from dfr_requisition r, dfr_candidate_details c where r.id=c.r_id $_filterCond";
				//echo $qSql;
			$data["list_candidates"] = $this->Common_model->get_query_result_array($qSql);
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
		}
	}


	public function process_upload()
	{
		$infos = $this->input->post();
		// print_r($_FILES); exit;
		$c_id = $this->input->post('c_id');
		$company_name = $this->input->post('company_name');
		$exam = $this->input->post('exam');
		// print_r($company_name);
		// exit;
		$exp = "";
		$edu = "";

		$personalSql="Select fname,lname from dfr_candidate_details where id='$c_id'";
		$infos = $this->Common_model->get_query_result_array($personalSql);
		// print_r($infos[0]['lname']);
		if(!empty($_FILES['pan'])){
			$this->upload_pan($infos);
		}
		if(!empty($_FILES['exp'])){
			$this->upload_expfile($infos);
		}
		if(!empty($_FILES['edu'])){
			$this->upload_edufile($infos);
		}
		$this->upload_adhar($infos);
		$this->upload_photo($infos);
		// print_r($this->upload_error);


		$path       = $_FILES['pan']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
        // print_r($this->upload_error);
		if(empty($this->upload_error)) $pan = $infos[0]['fname']."_".$infos[0]['lname']."_pan.".$ext;

		$path       = $_FILES['adhar']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		if(empty($this->upload_error)) $adhar = $infos[0]['fname']."_".$infos[0]['lname']."_adhar.".$ext;

		$path       = $_FILES['photo']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		if(empty($this->upload_error)) $photo = $infos[0]['fname']."_".$infos[0]['lname']."_photo.".$ext;

		$this->db->trans_start();

		$link_sub_time = CurrMySqlDate();
		$ip = getClientIP(); // $_SERVER['REMOTE_ADDR'];
		$browser = $_SERVER['HTTP_USER_AGENT'];	
		$link_sub_log = " Date: ".$link_sub_time." RemoteIP: " . $ip ." Browser:".$browser;

		$query = $this->db->query("SELECT * FROM dfr_candidate_details WHERE id = $c_id");
		$data = $query->row();
		if($data){
					$uparray = array(

						"photo" => $photo,
						"attachment_adhar" => $adhar,
						"attachment_pan" => $pan,
						"doc_link_sub_time" => $link_sub_time,
						"doc_link_sub_log" => $link_sub_log,
						"is_active_doc_token" => 'N',
					);
					
					$this->db->where('id', $c_id);
					$this->db->update('dfr_candidate_details',$uparray);
		}

		$query = $this->db->query("SELECT * FROM dfr_experience_details WHERE candidate_id = $c_id");
		$data = $query->row();
		if($data)
		{		
			foreach ($company_name as $key => $value) {
				$path       = $_FILES['exp']['name'][$key];
        		$ext        = pathinfo($path, PATHINFO_EXTENSION);
				$exp = $infos[0]['fname']."_".$infos[0]['lname']."_experience".$key.".".$ext;
				$this->db->set("experience_doc",$exp);
				$this->db->where('candidate_id', $c_id);
				$this->db->where('company_name', $value);
				$this->db->update('dfr_experience_details');
			}
		}

		$query = $this->db->query("SELECT * FROM dfr_qualification_details WHERE candidate_id = $c_id");
		$data = $query->row();
		if($data)
		{	
			foreach ($exam as $key => $value) {
				$path       = $_FILES['edu']['name'][$key];
    			$ext        = pathinfo($path, PATHINFO_EXTENSION);
				$edu = $infos[0]['fname']."_".$infos[0]['lname']."_education".$key.".".$ext;
				$this->db->set("education_doc",$edu);
				$this->db->where('candidate_id', $c_id);
				$this->db->where('exam', $value);
				$this->db->update('dfr_qualification_details');
			}
				
		}

					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$response = array('error'=>'query_error');
						echo json_encode($response);
					}
					else
					{
						$this->db->trans_commit();
						$response = array('error'=>'false','c_id'=>$c_id);
						echo json_encode($response);
					}
					

		// print_r($this->db->error());

	}



	private function upload_pan($infos)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = '../femsdev/uploads/pan/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$path       = $_FILES['pan']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_pan.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('pan'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
		}
	}	

	private function upload_photo($infos)
	{
		$config['upload_path'] = '../femsdev/uploads/photo/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$path       = $_FILES['photo']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_photo.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('photo'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
		}
	}

	private function upload_adhar($infos)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = '../femsdev/uploads/candidate_aadhar/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['adhar']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_adhar.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('adhar'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
		}
	}

	private function upload_expfile($infos)
	{
		
		foreach ($_FILES['exp']['name'] as $key => $value) {

			$config['upload_path'] = '../femsdev/uploads/experience_doc/';
			$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
			$path       = $_FILES['exp']['name'][$key];
	        $ext        = pathinfo($path, PATHINFO_EXTENSION);
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_experience".$key.".".$ext;
	        $config['overwrite']      = 0;
	        $config['max_size']       = 0;
	        $config['max_width']      = 0;
	        $config['max_height']     = 0;
			$this->load->library('upload');
			$this->upload->initialize($config);

			$_FILES['file_new']['name']     = $path;
			$_FILES['file_new']['type']     = $_FILES['exp']['type'][$key];
            $_FILES['file_new']['tmp_name'] = $_FILES['exp']['tmp_name'][$key];
            $_FILES['file_new']['error']    = $_FILES['exp']['error'][$key];
            $_FILES['file_new']['size']     = $_FILES['exp']['size'][$key];
			
			if ( ! $this->upload->do_upload('file_new'))
			{
				$this->upload_error = array('error' => $this->upload->display_errors());
				$this->file_name = $this->upload->data('file_name');
			}
			else
			{
				$this->file_name = $this->upload->data('file_name');
				$this->upload_error = array();
			}
			
		}


	}


	private function upload_edufile($infos)
	{
		foreach ($_FILES['edu']['name'] as $key => $value) {

			$config['upload_path'] = '../femsdev/uploads/education_doc/';
			$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
			$path       = $_FILES['edu']['name'][$key];
	        $ext        = pathinfo($path, PATHINFO_EXTENSION);
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_education".$key.".".$ext;
	        $config['overwrite']      = 0;
	        $config['max_size']       = 0;
	        $config['max_width']      = 0;
	        $config['max_height']     = 0;
			$this->load->library('upload');
			$this->upload->initialize($config);

			$_FILES['file_new']['name']     = $path;
			$_FILES['file_new']['type']     = $_FILES["edu"]['type'][$key];
            $_FILES['file_new']['tmp_name'] = $_FILES["edu"]['tmp_name'][$key];
            $_FILES['file_new']['error']    = $_FILES["edu"]['error'][$key];
            $_FILES['file_new']['size']     = $_FILES["edu"]['size'][$key];
			
			if ( ! $this->upload->do_upload('file_new'))
			{
				$this->upload_error = array('error' => $this->upload->display_errors());
				$this->file_name = $this->upload->data('file_name');
			}
			else
			{
				$this->file_name = $this->upload->data('file_name');
				$this->upload_error = array();
			}
			
		}

	

}



	
///////////////Assigned Interviewer//////////////////////

	public function assigned_interviewer(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/assigned_user_interviewer.php";
			
			$sh_status = trim($this->input->post('sh_status'));
			if($sh_status=="") $sh_status = trim($this->input->get('sh_status'));
			if($sh_status=="") $sh_status=0;
			
			$_cond1="";
			
			if($sh_status==0) $_cond1=" sh_status='P' ";
			else $_cond1=" sh_status!='' ";
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			$cond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%')) OR (pool_location='$user_office_id' OR '$user_oth_office' like CONCAT('%',pool_location,'%')) )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and (location='".$oValue."' OR pool_location='".$oValue."')";
				else $_filterCond .= " and (location='".$oValue."' OR pool_location='".$oValue."')";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			if(get_role_dir()=="super" || get_global_access()==1){
				$cond .= "";
			}else{
				$cond .= " and assign_interviewer='$current_user'";
			}
			
					
			//$qSql = "Select yy.*, ii.*,ii.id as sch_id from (Select c.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, (select location from dfr_requisition r where r.id=c.r_id) as location from dfr_candidate_details c where c.candidate_status='IP' ) yy Left Join (select id as r_id, location from dfr_requisition) xx On (yy.r_id=xx.r_id) Right Join (Select dis.* from dfr_interview_schedules dis where $_cond1 $cond) ii ON (ii.c_id=yy.id) $_filterCond";	
			
			/*
			$qSql="Select * from
					(select c_id, scheduled_on, interview_site, interview_type, assign_interviewer, sh_status, remarks from dfr_interview_schedules) ii Left Join
					(select *, id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=added_by) as added_name from dfr_candidate_details where candidate_status='IP') xx  On (ii.c_id=xx.id) Left Join
					(select id as r_id, requisition_id, location from dfr_requisition) yy On (xx.r_id=yy.r_id) where $_cond1 $cond  $_filterCond";
			*/	
			
			$qSql="Select * from
					(select c_id, scheduled_on, interview_site, interview_type, assign_interviewer, sh_status, remarks from dfr_interview_schedules) ii Left Join
					(select *, id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=added_by) as added_name from dfr_candidate_details) xx  On (ii.c_id=xx.id) Left Join
					(select id as r_id, requisition_id, location from dfr_requisition) yy On (xx.r_id=yy.r_id) where $_cond1 $cond  $_filterCond";
					
			//echo $qSql;
				
			$data["get_assigned_user_interview"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$rCond = " and ( role_id not in ( Select id from role where folder = 'agent' ) OR dept_id = 3 )";
			
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1 $rCond order by name asc ";
			$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
			
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			$data['sh_status']=$sh_status;
					
			$this->load->view('dashboard',$data);
		}
	}
	
//////////////////////////////////////////////////////////////////////////////	
	
	public function send_basic_link()
	{
		if(check_logged_in())
		{
			$ans="";
			
			$rid = trim($this->input->post('rid'));
			$requisition_id = trim($this->input->post('requisition_id'));
			if($requisition_id=="pool") $rid="";
						
			$current_user = get_user_id();
			$fname = trim($this->input->post('fname'));
			$lname = trim($this->input->post('lname'));
			$email = trim($this->input->post('email'));
			$role_id = trim($this->input->post('role_id'));
			$pool_location = trim($this->input->post('pool_location'));
			
			$added_date = CurrMySqlDate();
			$log=get_logs();
			
			if($fname!="" && $email !=""){
				
				$link_token= bin2hex(openssl_random_pseudo_bytes(12));
				$url_token=urlencode(base64_encode($requisition_id.$link_token));
				
				$linkURL = base_url()."applyjoblink?".$url_token;
				
				$field_array = array(
					"r_id" => $rid,
					"fname" => $fname,
					"lname" => $lname,
					"email" => trim($this->input->post('email')),
					"phone" => trim($this->input->post('phone')),
					"candidate_status" => 'P',
					"added_by" => $current_user,
					"added_date" => $added_date,
					"link_send_time" => $added_date,
					"link_send_by" => $current_user,
					"link_token" => $link_token,
					"is_active_link_token" => "Y",
					"log" => $log
				);
				
				if($requisition_id=="pool"){
					$field_array['pool_role_id']=$role_id;
				}
				if($pool_location!=""){
					$field_array['pool_location']=$pool_location;
				}
								
				$rowid= data_inserter('dfr_candidate_details',$field_array);
				
				$position_name="";
				if($requisition_id=="pool"){ 
					$office_id=$pool_location;
					$qSql="Select name from role  where id=$role_id";
					$position_name=$this->Common_model->get_single_value($qSql);
					
				}else{
					$office_id=$this->Common_model->get_single_value("Select location as value from dfr_requisition where id='$rid'");
					
					$qSql="SELECT (select name from role r where r.id=d.role_id) as value FROM `dfr_requisition` d where requisition_id ='$requisition_id'";
					$position_name=$this->Common_model->get_single_value($qSql);
				}
				
				$eto=$email;
				
				// $eto="amit.debnath@fusionbposervices.com";
				
				$is_send=$this->email_basic_link($office_id,$position_name,$fname,$lname,$eto,$linkURL);
				
				if($rowid!==FALSE){ 
						$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$rid;
					redirect($referer);	
				}else{
						echo "error to save candidate to send link";
				}
					
			}else{
				$ans="error";
				echo "error to save candidate fname is blank";
			}
			//echo $ans;
			
		}
	}
	
	private function email_basic_link($office_id,$position_name, $fname,$lname, $eto, $linkURL){
												
				$link_send_by_name = get_username();
				
				if(isIndiaLocation($office_id)==true) $office_id="KOL";
				$qSql="select * from notification_info where sch_for='APPLYLINK' and is_active=1 and office_id='$office_id'";
				$query = $this->db->query($qSql);
				
				if($query->num_rows() > 0)
				{
					$res=$query->row_array();
					//$esub="Fusion-Please Fill Your Application";
					$email_subject = $res["email_subject"].' - '.$fname;
				
				
					$body="Dear $fname $lname, <br><br>";
					
					$email_body=$res["email_body"];
					
					$link_html="<br><br> <a style='text-decoration: none; color:#FFF;padding-bottom:12px;padding-top:10px;padding-left:25px;padding-right:25px;display:inline-block;background-color:#0e3997;border-radius:5px' href='$linkURL'>Open Application Form </a>  ";
					
					$email_body = str_replace("#positiontitle#", $position_name, $email_body);
					$email_body = str_replace("#recruitername#", $link_send_by_name, $email_body);
					$email_body = str_replace("#linkurl#", $link_html, $email_body);
					
					if(isIndiaLocation($office_id)==true){
						$body .= $email_body;
						$body .= $link_html;
					}else{
						$body .= $email_body;
					}
										
					$body .= " <br><br> Regards,<br>Fusion - Global HR Shared Services";
				
					$ecc = array();
					$ecc[] = $res["email_id"];
					$ecc[] = $res["cc_email_id"];
					$cc = array_filter($ecc);
				
					$is_send=$this->Email_model->send_email_sox('',$eto,implode(',',$cc),$body,$email_subject);
					
					$ans=$is_send;
				}else{
					$ans=false;
					//echo "error to send  email";
				}
				
			return $ans;
	
	}
	
	public function resend_basic_link()
	{
		if(check_logged_in())
		{
			$ans="";
			$current_user = get_user_id();
			$r_id = trim($this->input->get('r_id'));
			$c_id = trim($this->input->get('c_id'));
						
			$added_date = CurrMySqlDate();
			$log=get_logs();
			
			if($r_id=="") $r_id="pool";
			
			if($r_id!="" && $c_id !=""){
				
				$qSql="select * from dfr_candidate_details where id='$c_id'";
				
				$can_dtl_row = $this->Common_model->get_query_row_array($qSql);
				$fname= $can_dtl_row['fname'];
				$lname= $can_dtl_row['lname'];
				$eto = $can_dtl_row['email'];
				$pool_role_id = $can_dtl_row['pool_role_id'];
				
				if($r_id=="pool"){
					$requisition_id="pool";
					$office_id=$can_dtl_row['pool_location'];
					$qSql="Select name from role  where id=$pool_role_id";
					$position_name=$this->Common_model->get_single_value($qSql);
					
				}else{
					$requisition_id=$this->Common_model->get_single_value("Select requisition_id as value from dfr_requisition where id='$r_id'");
					$office_id=$this->Common_model->get_single_value("Select location as value from dfr_requisition where id='$r_id'");
				}
				
				$link_token= bin2hex(openssl_random_pseudo_bytes(12));
				$url_token=urlencode(base64_encode($requisition_id.$link_token));
				$linkURL = base_url()."applyjoblink?".$url_token;
				
				$field_array = array(
					"link_send_time" => $added_date,
					"link_send_by" => $current_user,
					"link_token" => $link_token,
					"is_active_link_token" => "Y",
					"log" => $log
				);
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details',$field_array);
				
				$is_send=$this->email_basic_link($office_id,$position_name,$fname,$lname,$eto,$linkURL);
				$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
				redirect($referer);	
								
			}else{
				$ans="error";
				echo "error to update candidate fname is blank";
			}
			//echo $ans;
			
		}
	}
	
//////////////////

	public function add_candidate()
	{
		if(check_logged_in())
		{
			$ans="";
		
			$r_id = trim($this->input->post('r_id'));
			
			$current_user = get_user_id();
			$fname = trim($this->input->post('fname'));
			
			$dob = trim($this->input->post('dob'));
			
			if($dob!=""){
				if(isIndiaLocation(get_user_office_id())==true ){
					$dob=ddmmyy2mysql($dob);
				}
				else
				{
					$dob=mmddyy2mysql($dob);
				}
			}
					
			$added_date = CurrMySqlDate();
			$log=get_logs();
			
			if($fname!=""){
				
				$config['upload_path'] = './uploads/candidate_resume/';
				$config['allowed_types'] = 'doc|docx|pdf';
				$config['max_size']     = '20240';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if($this->input->post('city')) $city = trim($this->input->post('city'));
				else $city = trim($this->input->post('city_other'));
				
				$field_array = array(
					"r_id" => $r_id,
					//"requisition_id" => trim($this->input->post('requisition_id')),
					"fname" => $fname,
					"lname" => trim($this->input->post('lname')),
					"hiring_source" => trim($this->input->post('hiring_source')),
					"ref_name" => trim($this->input->post('ref_name')),
					"ref_dept" => trim($this->input->post('ref_dept')),
					"ref_id" => trim($this->input->post('ref_id')),
					"experience" => trim($this->input->post('experience')),
					"interest" => trim($this->input->post('interest')),
					"interest_desc" => trim($this->input->post('interest_desc')),
					"dob" => $dob,
					"email" => trim($this->input->post('email')),
					"gender" => trim($this->input->post('gender')),
					"phone" => trim($this->input->post('phone')),
					"alter_phone" => trim($this->input->post('alter_phone')),
					"last_qualification" => trim($this->input->post('last_qualification')),
					"skill_set" => trim($this->input->post('skill_set')),
					"total_work_exp" => trim($this->input->post('total_work_exp')),
					"country" => trim($this->input->post('country')),
					"state" => trim($this->input->post('state')),
					"city" => $city,
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
				
				if($rowid!==FALSE){ 
					$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
					redirect($referer);	
				
				}else{
					echo "error to save candidate";
				}
				
				$ans="done";
				
				
			}else{
				$ans="error";
				echo "error to save candidate fname is blank";
			}
			//echo $ans;
			
		}
	}
	
	
	
	public function edit_candidate()
	{
		if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$added_date = CurrMySqlDate();
			$c_id = trim($this->input->post('c_id'));
			$r_id = trim($this->input->post('r_id'));
			$log=get_logs();
			
			$dob = trim($this->input->post('dob'));
			
			if($dob!=""){
				if(isIndiaLocation(get_user_office_id())==true ){
					$dob=ddmmyy2mysql($dob);
				}
				else
				{
					$dob=mmddyy2mysql($dob);
				}
			}
			
			if($c_id!=""){
				$config['upload_path'] = './uploads/candidate_resume/';
				$config['allowed_types'] = 'doc|docx|pdf';
				$config['max_size']     = '20240';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				$field_array = array(
					//"requisition_id" => trim($this->input->post('requisition_id')),
					"fname" => trim($this->input->post('fname')),
					"lname" => trim($this->input->post('lname')),
					"hiring_source" => trim($this->input->post('hiring_source')),
					"ref_name" => trim($this->input->post('ref_name')),
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
					//"added_by" => $current_user,
					//"added_date" => $added_date,
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
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
			
		}
	}
	

///////////////////////// Candidate	Experience & Qualification Part /////////////////////////////
/////	
	public function add_candidate_exp(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$added_date = CurrMySqlDate();
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
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
			
		}
	}
	
	public function edit_candidate_exp(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$c_exp_id = trim($this->input->post('c_exp_id'));
			$added_date = CurrMySqlDate();
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
					//"added_by" => $current_user,
					//"added_date" => $added_date,
					"log" => $log
				);
				
				$this->db->where('id', $c_exp_id);
				$this->db->update('dfr_experience_details', $field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			redirect("dfr/view_requisition/$r_id");
		}	
	}

/////////////////////////////////

	public function add_candidate_qual(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$added_date = CurrMySqlDate();
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
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
	}
	
	
	public function edit_candidate_qual(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$c_qual_id = trim($this->input->post('c_qual_id'));
			$added_date = CurrMySqlDate();
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					//"candidate_id" => $c_id,
					"exam" => trim($this->input->post('exam')),
					"passing_year" => trim($this->input->post('passing_year')),
					"board_uv" => trim($this->input->post('board_uv')),
					"specialization" => trim($this->input->post('specialization')),
					"grade_cgpa" => trim($this->input->post('grade_cgpa')),
					//"added_by" => $current_user,
					//"added_date" => $added_date,
					"log" => $log
				);
				
				$this->db->where('id', $c_qual_id);
				$this->db->update('dfr_qualification_details', $field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}	
	}
	
	
/////////////////////////////////Candidate interview Schedule part///////////////////////////////////////////////////	
//////	
	
	public function candidate_schedule(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$c_status = trim($this->input->post('c_status'));
			$creation_date = CurrMySqlDate();
			$log=get_logs();
			
			if($c_id!=""){
				$field_array = array(
					"c_id" => $c_id,
					"scheduled_on" => mdydt2mysql(trim($this->input->post('scheduled_on'))),
					"interview_site" => trim($this->input->post('interview_site')),
					"interview_type" => trim($this->input->post('interview_type')),
					"assign_interviewer" => trim($this->input->post('assign_interviewer')),
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
				$this->Email_model->candidate_schedule($r_id,$field_array);
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
	}
	
	public function edit_candidate_schedule(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			$creation_date = CurrMySqlDate();
			$log=get_logs();
			
			if($sch_id!=""){
				$field_array = array(
					"c_id" => $c_id,
					"scheduled_on" => mdydt2mysql(trim($this->input->post('scheduled_on'))),
					"interview_site" => trim($this->input->post('interview_site')),
					"interview_type" => trim($this->input->post('interview_type')),
					"assign_interviewer" => trim($this->input->post('assign_interviewer')),
					"remarks" => trim($this->input->post('remarks'))
				);
				$this->db->where('id', $sch_id);
				$this->db->update('dfr_interview_schedules', $field_array);
				
				$this->Email_model->candidate_schedule($r_id,$field_array);
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
	}
	
////Cancel Interview Scheduled////////

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
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
	}

//////////////////////////////////		
	
///////////////////////////////////////Candidate Interview part///////////////////////////////////////////////////
//////

	public function add_candidate_interview(){
		
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			$sh_status = trim($this->input->post('sh_status'));
			$updated_date = CurrMySqlDate();
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
				"listen_skill" => trim($this->input->post('listen_skill')),
				"overall_assessment" => trim($this->input->post('overall_assessment')),
				"updated_by" => $current_user,
				"updated_date" => $updated_date,
				"log" => $log
			);
			
			$rowid= data_inserter('dfr_interview_details',$field_array);
			
			if($sch_id!=""){
				$field_array1 = array(
					"sh_status" => $interview_status
				);
				$this->db->where('id', $sch_id);
				$this->db->update('dfr_interview_schedules', $field_array1);
			}
						
			if($interview_status=="N" && $interview_status=="C"){
				
				$field_array2 = array(
					"candidate_status" => 'IP'
				);
				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array2);
				
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
		
	}	
		
	public function edit_interview(){
		if(check_logged_in()){
			$r_id = trim($this->input->post('r_id'));
			$c_id = trim($this->input->post('c_id'));
			$sch_id = trim($this->input->post('sch_id'));
			$interview_status = trim($this->input->post('interview_status'));
			
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
					"listen_skill" => trim($this->input->post('listen_skill')),
					"overall_assessment" => trim($this->input->post('overall_assessment')),
					"interview_remarks" => trim($this->input->post('interview_remarks')),
					"interview_status" => $interview_status
				);
				$this->db->where('sch_id', $sch_id);
				$this->db->update('dfr_interview_details', $field_array);
				
				
				$field_array1 = array(
					"sh_status" => $interview_status
				);
				$this->db->where('id', $sch_id);
				$this->db->update('dfr_interview_schedules', $field_array1);
				
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
	}	

///////////Candidate Final Interview Status////////////////

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
			
			if($interview_status=="SL"){
				$this->Email_model->send_email_candidate_further_review($current_user,$field_array,$user_office_id,$r_id,$c_id); ///required this part///
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
	}


	public function resend_doc_link(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			$r_id=trim($this->input->get('r_id'));

			$c_id=trim($this->input->get('c_id'));
			$requisition_id=trim($this->input->get('requisition_id'));
			// echo $requisition_id; exit;
			// echo $requisition_id; exit;
				
			$office_id=$this->Common_model->get_single_value("Select location as value from dfr_requisition where id='$r_id'");
			/////////////
			$linkURL="";
			
			if(isIndiaLocation($office_id)==true){
				
				$link_token= bin2hex(openssl_random_pseudo_bytes(12));
				$url_token=urlencode(base64_encode($requisition_id.$link_token));
				
				$linkURL = base_url()."documentuploadlink?".$url_token;
				// echo $linkURL; exit;
				
				
				//table update
				$added_date = CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
						"doc_link_send_time" => $added_date,
						"doc_link_send_by" => $current_user,
						"doc_link_token" => $link_token,
						"is_active_doc_token" => "Y",
						"log" => $log
				);
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details',$field_array);
				
				$this->Email_model->resend_doc_link($current_user,$r_id,$c_id,$linkURL);
			
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);	
			
			}

			
			
			
			//redirect("dfr/view_requisition/$r_id");
		}	

	
///////////////////////////////////////Candidate Final Selection///////////////////////////////////////////////////		
//////
	
	public function candidate_final_approval(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$r_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$requisition_id=trim($this->input->post('requisition_id'));
			// echo $requisition_id; exit;
			$c_status=trim($this->input->post('c_status'));
			$gross_amount = trim($this->input->post('gross_amount'));
			$doj = trim($this->input->post('doj'));
			$location_id = trim($this->input->post('location_id'));
			
			$pay_type = trim($this->input->post('pay_type'));
			$pay_currency = trim($this->input->post('pay_currency'));
			
			
			if($doj!=""){
				
				if(isIndiaLocation($location_id)==true ){
					$doj=ddmmyy2mysql($doj);
				}
				else
				{
					$doj=mmddyy2mysql($doj);
				}
			}
					
			if($c_id!=""){
				$field_array = array(
					"candidate_status" => 'CS',
					"gross_pay" => $gross_amount,
					"approved_by" => $current_user,
					"approved_comment" => trim($this->input->post('approved_comment')),
					"doj" => $doj,
					"pay_type" => $pay_type,
					"currency" => $pay_currency
				);
			    			
				$this->db->where('id', $c_id);
				$this->db->where('candidate_status', $c_status);
				
				$this->db->update('dfr_candidate_details', $field_array);
				
				$pdfFileName = $this->candidate_offer_pdf($c_id,'Y','Y');
				
				if($location_id=="CEB" || $location_id=="MAN") $offer_letter="";
				else $offer_letter = FCPATH."temp_files/offer_letter/".$pdfFileName;
				

			/////////////
			$linkURL="";
			
			 if(isIndiaLocation($location_id)==true){
				
				$link_token= bin2hex(openssl_random_pseudo_bytes(12));
				$url_token=urlencode(base64_encode($requisition_id.$link_token));
				
				$linkURL = base_url()."documentuploadlink?".$url_token;
				
				
				//table update
				$added_date = CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
						"doc_link_send_time" => $added_date,
						"doc_link_send_by" => $current_user,
						"doc_link_token" => $link_token,
						"is_active_doc_token" => "Y",
						"log" => $log
				);
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details',$field_array);
			
			 }

			///////////
			
				
				
			$this->Email_model->send_email_candidate_final_selection($current_user,$r_id,$c_id,$offer_letter,$linkURL);
			
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
		}
	}
	
	
	public function resend_offer_letter(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$r_id=trim($this->input->get('r_id'));
			$c_id=trim($this->input->get('c_id'));
			$qSql="Select *, (select name from role r where r.id=role_id) as role_name from dfr_requisition where id='".$r_id."' ";
			$query = $this->db->query($qSql);
			$dRow=$query->row_array();
			$location_id=$dRow["location"];
			
			$pdfFileName = $this->candidate_offer_pdf($c_id,'Y','Y');
				
			if($location_id=="CEB" || $location_id=="MAN") $offer_letter="";
			else $offer_letter = FCPATH."temp_files/offer_letter/".$pdfFileName;
			
			/////////////
			$linkURL="";
			
			///////////
							
			$this->Email_model->send_email_candidate_final_selection($current_user,$r_id,$c_id,$offer_letter,$linkURL);
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
			
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
					"candidate_status" => 'IP',
					"approved_by" => $current_user,
					"approved_comment" => trim($this->input->post('approved_comment'))
				);
				$this->db->where('id', $c_id);
				$this->db->where('candidate_status', $c_status);
				$this->db->update('dfr_candidate_details', $field_array);
			}
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
	
//////////////////////////Candidate select as Employee/////////////////////////	
///////

	public function candidate_select_employee(){
		
		if(check_logged_in()){
			$current_user = get_user_id();
			
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
			$nationality = trim($this->input->post('nationality'));
			$father_husband_name = trim($this->input->post('father_husband_name'));
			$relation = trim($this->input->post('relation'));
			$marital_status = trim($this->input->post('marital_status'));
			$nationality = trim($this->input->post('nationality'));
			$address = trim($this->input->post('address'));
			$country = trim($this->input->post('country'));
			$state = trim($this->input->post('state'));
			$city = trim($this->input->post('city'));
			$caste = trim($this->input->post('caste'));
			$postcode = trim($this->input->post('postcode'));
			$pan_no = trim($this->input->post('pan_no'));
			$uan_no = trim($this->input->post('uan_no'));
			$esi_no = trim($this->input->post('esi_no'));
			$grosspay = trim($this->input->post('grosspay'));
			$currency = trim($this->input->post('currency'));
			$social_security_no = trim($this->input->post('social_security_no'));
			
			$xpoid = trim($this->input->post('xpoid'));
			$xpoid = strtoupper($xpoid);
			
			$omuid="";
			if($office_id == 'KOL') $omuid = $xpoid;
			else $omuid = $fname.".".$lname;
			
			$qSql="Select ref_name as value from  dfr_candidate_details where id='$c_id'";
			$ref_name = $this->Common_model->get_single_value($qSql);
								
			//"passwd" => trim($this->input->post('passwd')),
			
			if($c_id!=""){
				
				$_run = false;
				
				if($this->user_model->user_xpoid_exists_off($xpoid,$office_id)===false) $_run = true;  
				else{
					$_run = false;
					$data["error"] = show_msgbox('User Creation Failed. Emp ID/XPO ID already present',true);
				}

				// echo $_run;
				// exit;
					
				if($_run)
                {	
					$field_array = array(
						"xpoid" => $xpoid,
						"omuid" => $omuid,
						"fname" => $fname,
						"lname" => $lname,
						"sex" => trim($this->input->post('sex')),
						"hiring_source" => trim($this->input->post('hiring_source')),
						"hiring_sub_source" => $ref_name,
						"dept_id" => trim($this->input->post('dept_id')),
						"sub_dept_id" => trim($this->input->post('sub_dept_id')),
						"batch_code" => trim($this->input->post('batch_code')),
						"office_id" => $office_id,
						"role_id" => $role_id,
						"org_role_id" => trim($this->input->post('org_role_id')),
						"assigned_to" => trim($this->input->post('assigned_to')),
						"status" => 4,
						"dfr_id" => $c_id,
						"log" => $log
					);	

					// print_r($field_array); exit();
					
					/*if($doj!=""){
						 $doj=mmddyy2mysql($doj);
						 $field_array['doj']=$doj;
					}*/
					if($doj!=""){
						if(isIndiaLocation($office_id)==true ){
							$doj=ddmmyy2mysql($doj);
						}
						else
						{
							$doj=mmddyy2mysql($doj);
						}
						$field_array['doj']=$doj;
					}
					
										
					
					if($dob!=""){
						
						if(isIndiaLocation($office_id)==true ){
							$dob=ddmmyy2mysql($dob);
						}
						else
						{
							$dob=mmddyy2mysql($dob);
						}
						$field_array['dob']=$dob;
					}
					
					$user_id=FALSE;
					// echo $doj;
					// echo isValidMysqlDate($doj,'Y-m-d');
					// exit();
					
					if(isValidMysqlDate($doj,'Y-m-d') == true){

						// echo "string";
						// exit;						
						///
						
						$this->db->trans_begin();	//begin sql transaction
						
						$user_id = data_inserter('signin',$field_array);
							
						$evt_date = CurrMySqlDate();

						$role_his_array = array(
							"user_id" => $user_id,
							"role_id" => $role_id,
							"stdate" => $doj,
							"change_date" => $evt_date,
							"change_by" => $current_user,
							"log" => $log,
						); 
						
						$fusion_id="";
						
						if($user_id!==FALSE)
						{
							// will be update
							
							$max_id=$this->Common_model->get_single_value("SELECT max(substr(fusion_id,5)) as value FROM signin where office_id='$office_id'");
							$max_id=$max_id+1;							
							$fusion_id="F".$office_id."".addLeadingZero($max_id,6);
							
							$passwd = md5($fusion_id);
							
							$Update_array = array(
									"fusion_id" => $fusion_id,
									"passwd" => $passwd
							);
							$this->db->where('id', $user_id);
							$this->db->update('signin', $Update_array);
							
							$rowid= data_inserter('role_history',$role_his_array);	
							
							if($payroll_type=="")$payroll_type='1';
							if($payroll_status=="")$payroll_status='1';
							
							$payroll_array = array(
								"user_id" => $user_id,
								"payroll_type" => $payroll_type,
								"payroll_status" => $payroll_status,
								"gross_pay" => $grosspay,
								"currency" => $currency,
								"log" => $log
							);
							$rowid= data_inserter('info_payroll',$payroll_array);
							
							
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
							
							
							
							$personal_array = array(
								"user_id" => $user_id,
								"caste"=> $caste,
								"email_id_per" => $email_id_per,
								"email_id_off" => $email_id_off,
								"phone" => $phone,
								"phone_emar" => $phone_emar,
								"address_present" => $address,
								"pin" => $postcode,
								"city" => $city,
								"state" => $state,
								"country" => $country,
								"nationality" => $nationality,
								"father_name" => $father_husband_name,
								"relation" => $relation,
								"marital_status" => $marital_status,
								"social_security_no" => $social_security_no,
								"pan_no" => $pan_no,
								"uan_no" => $uan_no,
								"esi_no" => $esi_no,
								"log" => $log
							);
							$rowid= data_inserter('info_personal',$personal_array);
							
							
						///////Phase History///////
							$phase_array = array(
								"user_id" => $user_id,
								"phase_type" => 1,
								"start_date" => CurrDate(),
								"event_by" => $current_user
							);
							$rowid= data_inserter('phase_history',$phase_array);
						////////////////
							
						}

						$personalSql ="SELECT * FROM dfr_candidate_details where id='$c_id'";
						$candidate_documents = $this->Common_model->get_query_result_array($personalSql);

						// print_r($candidate_documents);
						// exit;

						$destination_path = $this->config->item('profileUploadPath');
						if (!is_dir($destination_path.'/'.$fusion_id)) {
							mkdir($destination_path.'/'.$fusion_id, 0777, true);
						}
						if(!empty($candidate_documents[0]['attachment_pan'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/pan/'.$candidate_documents[0]['attachment_pan'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_pan']);
						}
						if(!empty($candidate_documents[0]['attachment_birth_certificate'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_birth/'.$candidate_documents[0]['attachment_birth_certificate'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_birth_certificate']);
						}
						if(!empty($candidate_documents[0]['attachment_Philhealth'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_insurence/'.$candidate_documents[0]['attachment_Philhealth'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_Philhealth']);
						}
						if(!empty($candidate_documents[0]['attachment_nbi_clearence'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_nbi_clearence/'.$candidate_documents[0]['attachment_nbi_clearence'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_nbi_clearence']);
						}
						if(!empty($candidate_documents[0]['attachment_sss'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_aadhar/'.$candidate_documents[0]['attachment_sss'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_sss']);
						}
						if(!empty($candidate_documents[0]['attachment_tin'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_pan/'.$candidate_documents[0]['attachment_tin'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_tin']);
						}
						if(!empty($candidate_documents[0]['attachment_tax'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_pan/'.$candidate_documents[0]['attachment_tax'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_tax']);
						}
						if(!empty($candidate_documents[0]['attachment_nis'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_insurence/'.$candidate_documents[0]['attachment_nis'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_nis']);
						}
						if(!empty($candidate_documents[0]['attachment_adhar'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/candidate_aadhar/'.$candidate_documents[0]['attachment_adhar'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['attachment_adhar']);
						}
						if(!empty($candidate_documents[0]['photo'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/photo/'.$candidate_documents[0]['photo'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['photo']);
						}

						$personalSql ="SELECT experience_doc FROM dfr_experience_details where candidate_id='$c_id'";
						$candidate_documents = $this->Common_model->get_query_result_array($personalSql);

						if(!empty($candidate_documents[0]['experience_doc'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/experience_doc/'.$candidate_documents[0]['experience_doc'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['experience_doc']);
						}
						// print_r($candidate_documents);

						$personalSql ="SELECT education_doc FROM dfr_qualification_details where candidate_id='$c_id'";
						$candidate_documents = $this->Common_model->get_query_result_array($personalSql);

						if(!empty($candidate_documents[0]['education_doc'])){
							rename('/opt/lampp/htdocs/femsdev/uploads/education_doc/'.$candidate_documents[0]['education_doc'], $destination_path.'/'.$fusion_id.'/'.$candidate_documents[0]['education_doc']);
						}
						// exit;
						

						$iSql="Insert into info_document_upload (user_id,pan_doc,aadhar_doc,nis_doc,birth_certi_doc,photograph,sss_no_doc,tin_no_doc,philhealth_no_doc,nbi_clearance_doc) select '$user_id' as user_id, attachment_pan,attachment_adhar,attachment_nis,attachment_birth_certificate,photo,attachment_sss,attachment_tin,attachment_Philhealth,attachment_nbi_clearence from dfr_candidate_details where id = '$c_id'";
						$this->db->query($iSql);
						
						$iSql="Insert into info_experience (user_id,org_name,desig,from_date,to_date,work_exp,contact,job_desc,address,job_doc) select '$user_id' as user_id, company_name,designation,from_date,to_date,work_exp,contact,job_desc,address,experience_doc from dfr_experience_details where candidate_id = '$c_id'";
						$this->db->query($iSql);
						
						$iSql="Insert into info_education (user_id,exam,passing_year,board_uv,specialization,grade_cgpa,education_doc) select '$user_id' as user_id, exam,passing_year,board_uv,specialization,grade_cgpa,education_doc from dfr_qualification_details where candidate_id = '$c_id'";
						$this->db->query($iSql);
						
						
						$field_array1 = array(
							"candidate_status" => 'E',
						);
						
						$this->db->where('id', $c_id);
						$this->db->update('dfr_candidate_details', $field_array1);
										
						$this->db->trans_complete(); //sql transaction complete
						////////////////////	
						
						/* if($r_id!=""){
							
							$uSql = "Update dfr_requisition set filled_no_position = (filled_no_position+1) Where  id = '$r_id' ";
							$this->db->query($uSql);
						} */
					
					
					}else{
						$this->session->set_flashdata("error",show_msgbox("Invalid Date of Join",true));
					}
				
				}/////////////
				
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/view_requisition/".$r_id;
			redirect($referer);
			
			//redirect("dfr/view_requisition/$r_id");
			
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
					"approved_comment" => trim($this->input->post('approved_comment'))
				);
				$this->db->where('id', $c_id);
				$this->db->where('candidate_status', $c_status);
				$this->db->update('dfr_candidate_details', $field_array);
			}
			redirect("dfr/view_requisition/$r_id");
		}
	}
	
///////////////////////////////////Transfer Candidates///////////////////////////////////
	public function CandidateTransfer(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$req_old_id=trim($this->input->post('r_id'));
			$c_id=trim($this->input->post('c_id'));
			$requisition_id=trim($this->input->post('requisition_id'));
			$req_new_id=trim($this->input->post('req_id'));
			$transfer_datetime = CurrMySqlDate();
			$c_status=trim($this->input->post('c_status'));
			
			
			if($c_id!="" && $req_new_id != "" && $req_new_id != 0){
				$field_array = array(
					"r_id" => $req_new_id,
					"old_requisition_id" => $req_old_id,
					"old_candidate_status" => $c_status,
					"transfer_comment" => trim($this->input->post('transfer_comment')),
					"transfer_by" => $current_user,
					"transfer_datetime" => $transfer_datetime
				);
				
				if($c_status=="R"){
					$field_array['candidate_status'] = 'IP';
				}
				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array);
			}
			else if(($c_id!="" && $req_new_id == "0"))
			{
				$query = $this->db->query('SELECT location FROM `dfr_requisition` WHERE id='.$req_old_id.'');
				$row = $query->row();
				$field_array = array(
					"old_requisition_id" => $req_old_id,
					"old_candidate_status" => $c_status,
					"transfer_comment" => trim($this->input->post('transfer_comment')),
					"transfer_by" => $current_user,
					"transfer_datetime" => $transfer_datetime,
					"pool_location" => $row->location,
					"pool_by" => $current_user,
					"pool_time" => $transfer_datetime
				);
				
				if($c_status=="R"){
					$field_array['candidate_status'] = 'IP';
				}
				$this->db->set('r_id', 'NULL', false);
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details', $field_array);
			}
						
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dfr/shortlisted_candidate";
			redirect($referer);
			
		}
	}
	
//////////////////////////
	
////////////////////////////
	
	public function getuserclientlist(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			
			$pid=$this->input->post('pid');
			$interview_site=$this->input->post('interview_site');
			
			$Cond = " OR (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%')) ";
			
			$rCond = "";
			
			if($pid == '1' ) $rCond = " and dept_id = 3 ";
			else $rCond = " and ( role_id not in ( Select id from role where folder = 'agent' ) OR dept_id = 3 )";
			
			if($pid=="5"){
				$qSql="Select id,concat(fname, ' ', lname) as name, office_id, '' as  dept_name from signin_client where status='1' order by name asc";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}else{
				$qSql="Select id,concat(fname, ' ', lname) as name, office_id, (select shname from department d where d.id=dept_id) as dept_name from signin where status='1'  and office_id='$interview_site' $Cond order by office_id, name asc";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
			
		}
	}
	
	
	public function getrequisitiondetails(){
		if(check_logged_in()){
			$rid=$this->input->post('rid');
			
			$qSql="Select id, (select shname from department d where d.id=department_id) as dept_name, (select name from role r where r.id=role_id) as role_name, req_no_position, job_title, (select shname from client c where c.id=client_id) as client_name, (select name from process p where p.id=process_id) as process_name, req_skill from dfr_requisition where id='$rid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}
	}
		
	
	//////////////////////Pool Requisition////////////////////////

	public function pool_requisition()
	{
		if(check_logged_in())
		{
			if(get_login_type() == "client") redirect(base_url().'client',"refresh");
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			$is_global_access = get_global_access();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			$user_oth_office=get_user_oth_office();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/view_pool_requisition.php";
			
			$qSql="Select fusion_id, xpoid, fname,lname, office_id from signin where status=1 and office_id='$user_office_id' and role_id > 0 order by fname";
			$data["user_list_ref"] = $this->Common_model->get_query_result_array($qSql);
			
						
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( pool_location='$user_office_id' OR '$user_oth_office' like CONCAT('%',pool_location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and pool_location='".$oValue."'";
				else $_filterCond .= " And pool_location='".$oValue."'";
			}
			
			
			if(get_role_dir()=="super" || get_global_access()==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select abbr, office_name, location from office_location where is_active=1";
			$data["get_site_location"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id, name from dfr_interview_type_mas where is_active=1";
			$data["dfr_interview_type_mas"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT id,name, org_role  FROM role where is_active=1 and folder not in('super') ORDER BY name";
			$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			if(get_role_dir()!="super" && get_global_access()!=1){
				
				//$tl_cnd=" and office_id='$user_office_id' ";
				$tl_cnd=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
				
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}else{ 
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}
			
			$data["role_data"] = $this->Common_model->get_rolls_for_assignment();
			$data["location_data"] = $this->Common_model->get_office_location_list();
			
			$data["get_department_data"] = $this->Common_model->get_department_list();
			$data['organization_role'] = $this->Common_model->role_organization();
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			$data['payroll_type_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_type where is_active=1");
			$data['payroll_status_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_status where is_active=1");
			
			
			//$qSql = "Select id, concat(fname, ' ', lname) as name from signin where status=1 and role_id in (Select id FROM role where folder not in ('trainer', 'tl', 'agent', 'support') and is_active=1) order by name asc ";
			
			
			
			$rCond = " and ( role_id not in ( Select id from role where folder = 'agent' ) OR dept_id = 3 )";
			
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1  $rCond order by name asc ";
			$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql= "Select c.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name from dfr_candidate_details c where  r_id IS NULL  $_filterCond  ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
			
						
			$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data['oValue']=$oValue;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function add_pool_candidate()
	{
		if(check_logged_in())
		{
			$ans="";
		
			$location = trim($this->input->post('location'));
			$current_user = get_user_id();
			$fname = trim($this->input->post('fname'));
			$dob = mmddyy2mysql(trim($this->input->post('dob')));
			$added_date = CurrMySqlDate();
			$log=get_logs();
			
			if($fname!=""){
				
				$config['upload_path'] = './uploads/candidate_resume/';
				$config['allowed_types'] = 'doc|docx|pdf';
				$config['max_size']     = '20240';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				$field_array = array(
					"pool_location" => $location,
					//"requisition_id" => trim($this->input->post('requisition_id')),
					"fname" => $fname,
					"lname" => trim($this->input->post('lname')),
					"hiring_source" => trim($this->input->post('hiring_source')),
					"ref_name" => trim($this->input->post('ref_name')),
					"ref_dept" => trim($this->input->post('ref_dept')),
					"ref_id" => trim($this->input->post('ref_id')),
					"experience" => trim($this->input->post('experience')),
					"interest" => trim($this->input->post('interest')),
					"interest_desc" => trim($this->input->post('interest_desc')),
					"dob" => $dob,
					"email" => trim($this->input->post('email')),
					"gender" => trim($this->input->post('gender')),
					"phone" => trim($this->input->post('phone')),
					"alter_phone" => trim($this->input->post('alter_phone')),
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
					"pool_by" => $current_user,
					"pool_time" => $added_date,
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
								
				if($rowid!==FALSE){ 					
					redirect("dfr/pool_requisition");
				}else{
					echo "error to save candidate";
				}
				
				$ans="done";
				
			}else{
				$ans="error";
				echo "error to save candidate fname is blank";
			}
		}
	}

	
	public function view_candidate_interview_pool($c_id){
		if(check_logged_in()){
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			//$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/candidate_interview_report.php";
			
									
			$sqltxt ="SELECT inv.*, (Select name from dfr_interview_type_mas mas where mas.id =sch.interview_type ) as parameter , getInterviewerName(sch.interview_type,inv.interviewer_id) as interviewer  FROM dfr_interview_schedules sch Left Join dfr_interview_details inv on sch.id = inv.sch_id  where  sch.c_id='$c_id'";

			$data["candidate_interview_details"] = $this->Common_model->get_query_result_array($sqltxt);
			
			//$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,location,(SELECT description FROM  department d where rq.department_id = d.id )as dept  FROM  dfr_candidate_details cd INNER join   dfr_requisition rq   on rq.id = cd.r_id where cd.id = '$c_id'";
			
			$sqltxt ="SELECT concat(fname,' ',lname)as name ,email,pool_location,@dept=null AS dept  FROM  dfr_candidate_details cd where cd.id = $c_id";
			
			$data["candidate_details"]=   $this->Common_model->get_query_result_array($sqltxt);
			
			$data['c_id'] = $c_id; 
		 
			$this->load->view('dashboard_single_col',$data);
			 
		}
	}
	
	public function getUserDetails()
	{
		if(check_logged_in())
		{
			$r_name=$this->input->post('r_name');
			
			$qSql = "Select CONCAT(fname,' ' ,lname) as name, dept_id, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where fusion_id='$r_name' ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	public function getRequisitionidstatus()
	{
		if(check_logged_in()){
			
			$offid=$this->input->post('offid');
			$req_status=$this->input->post('req_status');
			
			$_cond1="";
			
			if($req_status=='0') $_cond1=" requisition_status in ('A')";
			else if($req_status=='1') $_cond1=" requisition_status='CL'";
			else if($req_status=='3') $_cond1=" requisition_status='P'";
			else $_cond1=" requisition_status in ('C','R')";

			
			
			if($offid=='ALL'){
				$qSql="Select requisition_id FROM dfr_requisition where $_cond1 ORDER BY requisition_id ASC";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}else{
				$qSql="Select requisition_id FROM dfr_requisition where location='$offid' and $_cond1 ORDER BY requisition_id ASC";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
			
		}
	}
	
	public function getRequisitionid()
	{
		if(check_logged_in()){
			
			$offid=$this->input->post('offid');
			
			
			if($offid=='ALL'){
				$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}else{
				$qSql="Select requisition_id FROM dfr_requisition where location='$offid' ORDER BY requisition_id ASC";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
			
		}
	}
		
	public function getRefConsultant()
	{
		if(check_logged_in()){
			
			$refname=$this->input->post('refname');
			
			if($refname=='Job Portal'){
				$qSql="SELECT * from master_job_portal_list";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}else if($refname=='Consultancy'){
				$qSql="SELECT * from master_consultancy_list";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}else if($refname=='Call From HR'){
				$qSql="SELECT concat(fname,' ',lname)as fname  FROM `signin` WHERE `dept_id` = 3" ;
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
			else{
				echo json_encode(array());
			}
			
		}
	} 
	
	////////
	
	////////////////// Start Offer letter view /////////////////////////////////
	public function view_offer_letter($c_id){
		if(check_logged_in()){
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$qSql="SELECT * from (Select *, DATE_FORMAT(added_date, '%m/%d/%Y') as addedDate from dfr_candidate_details where id='$c_id') xx Left Join (Select id,location, requisition_id, (select name from role r where r.id=dfr_requisition.role_id) as position_name, (select org_role from role  where role.id = dfr_requisition.role_id ) as org_role from dfr_requisition) yy On (xx.r_id=yy.id) limit 1";
			
			//echo $qSql;
			
			$data["can_dtl_row"] = $can_dtl_row = $this->Common_model->get_query_row_array($qSql);
			//print_r($can_dtl_row);
			
			$location= $can_dtl_row['location'];
			if($location=="") $location = $can_dtl_row['pool_location'];
			$fname= $can_dtl_row['fname'];
			$lname= $can_dtl_row['lname'];
			
			$data['c_id'] = $c_id;  
			
			if($location=="HWH") $data["content_template"] = "dfr/candidate_offer_hwh.php";
			else if($location=="KOL" || $location=="BLR" || $location=="NOI" || $location=="CHE") $data["content_template"] = "dfr/candidate_offer_kol.php";
			else if($location=="CEB" ) $data["content_template"] = "dfr/candidate_offer_ceb.php";			
			else if($location=="ELS" ) $data["content_template"] = "dfr/candidate_offer_els.php";
			else if($location=="JAM" ) $data["content_template"] = "dfr/candidate_offer_jam.php";
			else if($location=="UKL" ) $data["content_template"] = "dfr/candidate_offer_uk.php";
			else $data["content_template"] = "dfr/candidate_offer_none.php";
			
			$this->load->view('dashboard_single_col',$data);
			
		}
	}
	
	
	
	public function candidate_offer_pdf($c_id,$isLHead='Y',$isSave='N'){ 
			
			if(check_logged_in()){
				
			//load mPDF library
			$this->load->library('m_pdf');
						
			$qSql="SELECT * from (Select *, DATE_FORMAT(added_date, '%m/%d/%Y') as addedDate from dfr_candidate_details where id='$c_id') xx Left Join (Select id,location, requisition_id, (Select location from office_location o where o.abbr=dfr.location) as location_name, (select name from role r where r.id=dfr.role_id) as position_name, (select org_role from role  where role.id = dfr.role_id ) as org_role from dfr_requisition dfr ) yy On (xx.r_id=yy.id) limit 1";
			
			$data["can_dtl_row"] = $can_dtl_row = $this->Common_model->get_query_row_array($qSql);
			$location= $can_dtl_row['location'];
			if($location=="") $location = $can_dtl_row['pool_location'];
			
			$fname= $can_dtl_row['fname'];
			$lname= $can_dtl_row['lname'];
			$pay_type= $can_dtl_row['pay_type'];
			$stipend_array = array(2,3,4,5,6);
			
			
			$data['c_id'] = $c_id;  
			$html="";
			
			//$location="HWH";
			
			$footer="";
			$header="";
			
			if(isIndiaLocation($location)==true){
			
				if($location=="HWH"){
					
					if(in_array($pay_type,$stipend_array)){
						$html=$this->load->view('dfr/candidateoffer_stipend_hwh_pdf.php', $data, true);
					} else {
						$html=$this->load->view('dfr/candidateoffer_hwh_pdf.php', $data, true);
					}
					
					$header="<div><img src='" . APPPATH . "/../assets/images/logohwr.png' height='70px;'></div>";
		
					$footer = "<p style='text-align:center; font-weight:lighter; '>
						<span style='font-size:14px'>WINDOW TECHNOLOGIES PVT LTD.</span><br>
							<span style='font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
							<span style='font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
							<span style='font-size:11px'>www.fusionbposervices.com</span>
						</p>";
				
				}else{
					
					if(in_array($pay_type,$stipend_array)){
						$html=$this->load->view('dfr/candidateoffer_stipend_kol_pdf.php', $data, true);
					} else {
						$html=$this->load->view('dfr/candidateoffer_kol_pdf.php', $data, true);
					}
					$header="<div><img src='" . APPPATH . "/../assets/images/logoxt.jpg' height='80px;'></div>";
					
					$footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>XPLORE-TECH SERVICES PRIVATE LIMITED</span><br>
					<span style='font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
					<span style='font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
					<span style='font-size:11px'>www. xplore-tech.com</span><br>
					<span style='font-size:11px'>www.fusionbposervices.com</span></p>";
					
				}
			
			}else if($location=="CEB" ){
				
				$html=$this->load->view('dfr/candidateoffer_ceb_pdf.php', $data, true);
				
				$header="<p style='text-align:center;'><img src='" . APPPATH . "/../assets/images/logoceb.png' height='80px;'><br>
				<span style='font-size:11px'>US: 1480 Vine Street | Suite 402 | Los Angeles | CA | 90028</span><br>
				<span style='font-size:11px'>PH: 7F Cybergate Bldg. | Fuente Osmeña | Cebu City | Cebu | PH | 6000</span><br>
				<span style='font-size:11px'>Phone: 310-734-8225 | Fax: 206-350-0106 | www.supportsave.com</span><br>
				</p>";
				
				$footer = "<p style='text-align:left; font-weight:lighter; '><span style='font-size:11px'>Issued by:  HR Organizational Development</span><br></p>";
				
			}			
			else if($location=="ELS" ){
				
				$html=$this->load->view('dfr/candidateoffer_els_pdf.php', $data, true);
				
				$header="<p style='text-align:left;'><img src='" . APPPATH . "/../assets/images/fusion-bpo.png' height='80px;'></p><br>";
				
				$footer = "";
				
			}
			else if($location=="JAM" ){
				
				$html=$this->load->view('dfr/candidateoffer_jam_pdf.php', $data, true);
				
				$header="<p style='text-align:left;'><img src='" . APPPATH . "/../assets/images/fusion-bpo.png' height='80px;'></p><br>";
				
				$footer = "";
				
			}
			else if($location=="UKL" ){
				
				$html=$this->load->view('dfr/candidateoffer_uk_pdf.php', $data, true);
				
				$header="";
				
				$footer = "";
				
			}
			else $html="";
			

			if($isLHead=="Y"){
				$this->m_pdf->pdf->SetHTMLHeader($header);
				$this->m_pdf->pdf->SetHTMLFooter($footer);	
			}
			
			
			//this the the PDF filename that user will get to download
			$pdfFileName = $fname."_".$lname."_offer_letter".$c_id.".pdf";
			
			$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			if($isSave=="Y") {
				$file_path =FCPATH."temp_files/offer_letter/".$pdfFileName;
				$this->m_pdf->pdf->Output($file_path, "F");
				return $pdfFileName;
			}
			else $this->m_pdf->pdf->Output($pdfFileName, "D");		
		}
			
	}
	///////////////// end offer letter //////////////////////////////////////
	
	
	
	
	/////////////////BENCH USER///////////////////////

	public function bench_user_list(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/bench_list.php";
			
			
			$qSql="SELECT * from user_bench as u
			       LEFT JOIN signin as s ON s.id = u.user_id
				   LEFT JOIN (SELECT id as depid, description as d_fullname, shname as d_shortname from department) as d ON d.depid = s.dept_id
				   LEFT JOIN (SELECT id as cid, shname as c_shortname, fullname as c_fullname from client) as c ON c.cid = s.client_id
				   LEFT JOIN (SELECT id as pid, name as p_fullname from process) as p ON p.pid = s.process_id
				   LEFT JOIN (SELECT abbr as shortform, office_name from office_location) as o ON o.shortform = s.office_id
				   LEFT JOIN (SELECT id as lid, concat(fname, ' ', lname) as lpname from signin) as a ON a.lid = s.assigned_to
				   LEFT JOIN (SELECT id as rid, name as rolename from role) as r ON r.rid = s.role_id
				   LEFT JOIN (SELECT id as roid, name as roleorgname from role_organization) as rg ON rg.roid = s.org_role_id";
					
			$data["benchlist"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	/////////////////BENCH USER///////////////////////

	public function CandidateDrop(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
						
			$r_id = $this->input->post('r_id');
			$c_id = $this->input->post('c_id');
			$is_drop = $this->input->post('is_drop');
			if($is_drop == 'Y')
			{
				$data_array = array( "candidate_status" => 'D' );
				$this->db->where('id',$c_id);		
				$this->db->where('r_id',$r_id);
				$this->db->update('dfr_candidate_details', $data_array);
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	public function dropped_candidate(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$is_global_access = get_global_access();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$data["is_global_access"] = get_global_access();
			$data["is_role_dir"] = get_role_dir();
			
			$data["aside_template"] = "dfr/aside.php";
			$data["content_template"] = "dfr/dropped_candidate.php";
			
			
			$qSql="Select id, req_no_position, concat(requisition_id, '-', ( Select name from process p where p.id = process_id ), ' - ', job_title) as req_desc, (select count(id) from dfr_candidate_details cd where cd.r_id=dfr_requisition.id and cd.candidate_status='E') as filled_position from dfr_requisition where requisition_status='A' ";
			$data["getrequisition"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$requisition_id = trim($this->input->get('requisition_id'));
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$_filterCond="";
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			if(get_role_dir()!="super" && $is_global_access!=1) $_filterCond .=" and ( location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}
			
			if($requisition_id!="") $_filterCond .=" and requisition_id='$requisition_id'";
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				if($oValue=='ALL' || $oValue==''){
					$qSql="Select requisition_id FROM dfr_requisition ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select requisition_id FROM dfr_requisition where location='$oValue' ORDER BY requisition_id ASC";
					$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
				}
			}else{
				$uOValue=$oValue;
				if($oValue=='ALL' || $oValue=='') $uOValue=$user_office_id;
				$qSql="Select requisition_id FROM dfr_requisition where location='$uOValue' ORDER BY requisition_id ASC";
				$data["get_requisition"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			$data["candidate_rejected"] = $this->Dfr_model->get_dropped_candidates($_filterCond);
			
			$data['requisition_id']=$requisition_id;
			$data['oValue']=$oValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
}	


?>