<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_digit extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('Common_model');
		//error_reporting(E_ERROR | E_WARNING | E_PARSE);
		error_reporting(E_ALL ^ E_WARNING);
		
	 }
	 
	
	public function audit_delete($table)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$curDateTime=CurrMySqlDate();
			$pid = trim($this->input->post('pid'));
			
			if($pid!=""){
				$this->db->query("Delete from ".$table."_feedback where id=$pid");
				$this->db->query("Delete from ".$table."_client_feedback where ss_id=$pid");
			/////////////////
				$delete_array = array(
					"audit_id" => $pid,
					"audit_table" => $table,
					"delete_by" => $current_user,
					"delete_date" => $curDateTime
				);
				$rowid= data_inserter('qa_delete_audit_record_logs',$delete_array);
				
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			/*  $qSql = "SELECT * from 
			(Select id, assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name, (select office_name from office_location ol where ol.abbr=office_id) as office_name, fusion_id, xpoid, get_process_names(id) as process_name, DATEDIFF(CURDATE(), doj) as tenure FROM signin m where id='$aid' and status='1') xx Left Join 
			(Select user_id, phone from info_personal) yy On (xx.id=yy.user_id) "; */
			$qSql = "SELECT * from 
			(Select id, assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name, (select office_name from office_location ol where ol.abbr=office_id) as office_name, (Select campaign from campaign c where c.id=m.assigned_campaign) as campaign_name, fusion_id, xpoid, get_process_names(id) as process_name, DATEDIFF(CURDATE(), doj) as tenure FROM signin m where id='$aid' and status='1') xx Left Join 
			(Select user_id, phone from info_personal) yy On (xx.id=yy.user_id) ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function getDisposition(){
		if(check_logged_in()){
			$lobid=$this->input->post('lobid');
			$qSql="Select dl.id, dl.campaign_id, dl.description, dl.is_active, lob.campaign from qa_disposition_list dl left join campaign lob on dl.campaign_id=lob.id
			where dl.is_active=1 and lob.campaign='$lobid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function getSubDisposition(){
		if(check_logged_in()){
			$dispo=$this->input->post('dispo');
			$lobid=$this->input->post('lobid');
			$qSql="Select sdl.id, sdl.dispo_id, sdl.description, sdl.is_active, dl.description as dispo_desc from qa_sub_disposition_list sdl 
			left join qa_disposition_list dl on sdl.dispo_id=dl.id
			left join campaign lob on dl.campaign_id=lob.id
			where sdl.is_active=1 and dl.description='$dispo' and lob.campaign='$lobid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function getSubSubDisposition(){
		if(check_logged_in()){
			$sub_dispo=$this->input->post('sub_dispo');
			$lobid=$this->input->post('lobid');
			//$qSql="Select ssdl.id, ssdl.sub_dispo_id, ssdl.description, ssdl.is_active, sdl.description as sub_dispo_desc from qa_sub_sub_disposition_list ssdl left join qa_sub_disposition_list sdl on ssdl.sub_dispo_id=sdl.id where ssdl.is_active=1 and sdl.description='$sub_dispo'";
			
			$qSql="Select ssdl.id, ssdl.sub_dispo_id, ssdl.description, ssdl.is_active, sdl.description as sub_dispo_desc from qa_sub_sub_disposition_list ssdl left join qa_sub_disposition_list sdl on ssdl.sub_dispo_id=sdl.id
			left join qa_disposition_list dl on dl.id=sdl.dispo_id 
			left join campaign lob on dl.campaign_id=lob.id
			where ssdl.is_active=1 and sdl.description='$sub_dispo' and lob.campaign='$lobid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	private function digit_upload_image_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }

        return $images;
    }
	
	
	private function digit_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }

        return $images;
    }
	
	/* private function snapdeal_upload_files($files,$path){
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        $images = array();
        foreach ($files['name'] as $key => $image) {           
			$_FILES['uFiles']['name']= $files['name'][$key];
			$_FILES['uFiles']['type']= $files['type'][$key];
			$_FILES['uFiles']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['uFiles']['error']= $files['error'][$key];
			$_FILES['uFiles']['size']= $files['size'][$key];

            if ($this->upload->do_upload('uFiles')) {
				$info = $this->upload->data();
				$ext = $info['file_ext'];
				$file_path = $info['file_path'];
				$full_path = $info['full_path'];
				$file_name = $info['file_name'];
				if(strtolower($ext)== '.wav'){
					$file_name = str_replace(".","_",$file_name).".mp3";
					$new_path = $file_path.$file_name;
					$comdFile=FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
					$output = shell_exec( $comdFile);
					sleep(2);
				}
				$images[] = $file_name;
            }else{
                return false;
            }
        }
        return $images;
    } */
	


/*-------------------------------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------- QA ---------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
///// SALES PART

	public function sales(){
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			//$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/sales/qa_sales_feedback.php";
			$data["content_js"] = "qa_digit_js.php";
			
			if(((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='operations') || get_dept_folder()=='training'){
				$data["rebuttal"]='';
			}else{
				if(get_global_access()=='1'){
					//$rebuttalSql="Select count(id) as value from qa_digit_sales_feedback where agnt_fd_acpt='Not Accepted'";
					$rebuttalSql="Select count(id) as value from qa_digit_sales_feedback where agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
				}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_digit_sales_feedback where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
				}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_digit_sales_feedback where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
				}
				$data["rebuttal"]=$this->Common_model->get_single_value($rebuttalSql);
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_digit_sales_feedback group by entry_by";
			$data["qaName"] = $this->Common_model->get_query_result_array($qaSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$qa_id = $this->input->get('qa_id');
			$cond="";
			$atacond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($qa_id !="")	$cond .=" and entry_by='$qa_id'";
			
			if(get_global_access()=='1'){
				$ops_cond="where 1";
			}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user') or entry_by='$current_user')";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' or entry_by='$current_user')";
			}else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
				$ops_cond=" Where entry_by='$current_user'";
			}else{
				$ops_cond="where 1";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_sales_feedback $cond) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				$ops_cond order by audit_date";
			$data["sales_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["qa_id"] = $qa_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function sales_operation_trainning(){
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			//$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			if(get_global_access()=='1' || get_dept_folder()=='qa'){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/sales/sales_operation_trainning.php";
			$data["content_js"] = "qa_digit_js.php";
			
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_digit_sales_feedback group by entry_by";
			$data["qaName"] = $this->Common_model->get_query_result_array($qaSql);
			
			$default_val[] = 'ALL';
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$audit_type = $this->input->get('audit_type')?$this->input->get('audit_type'):$default_val;
			$cond="";
			$auditcond="";
			$atacond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if($audit_type!=""){
				if (in_array("ALL",$audit_type, TRUE)){
					$auditcond ='audit_type in("Trainer Audit","Pre-Certificate Mock Call","Operation Audit","Certificate Audit")';
				}else{
					$all_audit=implode('","', $audit_type);
					$auditcond ='audit_type in ("'.$all_audit.'")';
				}
			}
			//echo $auditcond;die;
			
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_sales_feedback $cond) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				where $auditcond order by audit_date";
				//echo $qSql;die;
			$data["sales_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["audit_type"] = $audit_type;
			
			$this->load->view("dashboard",$data);
			}
		}
	}

	
	public function add_edit_sales($ss_id,$rand_ssid=Null){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			if (strpos($ss_id, 'optr') !== false) {
				$ss_id = filter_var($ss_id, FILTER_SANITIZE_NUMBER_INT);
				$data["content_template"] = "qa_digit/sales/review_audit_sales.php";
			}else{
				$data["content_template"] = "qa_digit/sales/add_edit_sales.php";
			}

			$data["aside_template"] = "qa/aside.php";
			
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			$data['rand_ssid']=$rand_ssid;

			if($rand_ssid!=0){
				$qSql = "Select SR.*,S.xpoid,C.campaign, S.id as user_id, S.fname, S.lname, S.office_id, S.assigned_to as tl_id, (select concat(fname, ' ', lname) as name from signin sc where sc.id=S.assigned_to) as tl_name, DATEDIFF(CURDATE(), S.doj) as tenure from convox_call_data SR Left Join signin S On SR.agent_id=S.red_login_id LEFT JOIN convox_process_lob_mapping CP on SR.process = CP.convox_process left join campaign C on CP.campaign_id = C.id where SR.id=$rand_ssid";
				$data['rand_data'] = $this->Common_model->get_query_row_array($qSql);
			}
			
			$qSql="Select office_name as value from office_location where abbr='$user_office_id'";
			$data["auditorLocation"] =  $this->Common_model->get_single_value($qSql);
			
			/* $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 AND id NOT IN (SELECT employee_id FROM employee_pip WHERE status NOT IN ('S','X')) order by name"; */
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 AND (is_pip_nominated=0 OR is_pip_nominated='' OR is_pip_nominated IS NULL) order by name";
			/* and is_assign_client (id,105) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */
			
			$lobSql="SELECT id, campaign, is_active FROM campaign where is_active=1";
			$data['lob_list']=$this->Common_model->get_query_result_array($lobSql);
			
			 $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as auditor_center,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sqmr where sqmr.id=qa_mgnt_rebuttal_by) as qa_mgnt_rebuttal_name
				from qa_digit_sales_feedback where id='$ss_id') xx 
				Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)
				Left Join (select ss_id as ata_audit_id from qa_digit_sales_client_feedback) zz On (xx.id=zz.ata_audit_id)";
			$data["sales"] = $this->Common_model->get_query_row_array($qSql);
			$data["sales"]['audit_status'];
			
			//Reason data list
			$sqlReason = "Select id,reason from digitdev_sale_opportunity_reason where is_active=1";
			$data['reasonList'] = $this->Common_model->get_query_result_array($sqlReason);
			
			//Company data list
			$sqlCompany = "Select id,company from digitdev_sale_opportunity_company where is_active=1";
			$data['companyList'] = $this->Common_model->get_query_result_array($sqlCompany);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			$b = array();
			
			if($ss_id!=0){
					//echo "Edit Audit";
					$lob_campaign = $data["sales"]['lob_campaign'];
					$disposition = $data["sales"]['disposition'];
					$subdisposition = $data["sales"]['sub_disposition'];
					
					// get disposition list while edit
					$dSql="Select dl.id, dl.campaign_id, dl.description, dl.is_active, lob.campaign from qa_disposition_list dl left join campaign lob on 		dl.campaign_id=lob.id
							where dl.is_active=1 and lob.campaign='$lob_campaign'";
					$data['dispo_list'] = $this->Common_model->get_query_result_array($dSql);
					
					// get sub disposition list while edit
					$subdSql="Select sdl.id, sdl.dispo_id, sdl.description, sdl.is_active, dl.description as dispo_desc from qa_sub_disposition_list sdl 
								left join qa_disposition_list dl on sdl.dispo_id=dl.id
								left join campaign lob on dl.campaign_id=lob.id
								where sdl.is_active=1 and dl.description='$disposition' and lob.campaign='$lob_campaign'";
					$data['sub_dispo_list'] = $this->Common_model->get_query_result_array($subdSql);

					// get sub sub disposition list while edit
					$subsubDSql="Select ssdl.id, ssdl.sub_dispo_id, ssdl.description, ssdl.is_active, sdl.description as sub_dispo_desc from qa_sub_sub_disposition_list ssdl left join qa_sub_disposition_list sdl on ssdl.sub_dispo_id=sdl.id
					left join qa_disposition_list dl on dl.id=sdl.dispo_id 
					left join campaign lob on dl.campaign_id=lob.id
					where ssdl.is_active=1 and sdl.description='$subdisposition' and lob.campaign='$lob_campaign'";
					$data['sub_sub_dispo_list'] = $this->Common_model->get_query_result_array($subsubDSql);
			}
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ss_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['overall_score']=$this->input->post('overall_score');
					if($rand_ssid!=0){
					$field_array['attach_file_convox']=$this->input->post('convox_audio');
					}
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->digit_upload_files($_FILES['attach_file'], $path='./qa_files/qa_digit/sales/');
						$field_array['attach_file'] = implode(',',$a);
					}
					
					if($_FILES['attach_img_file']['tmp_name'][0]!=''){
						$b = $this->digit_upload_image_files($_FILES['attach_img_file'], $path='./qa_files/qa_digit/sales/images/');
						$field_array['attach_img_file'] = implode(',',$b);
					}
					
					$rowid= data_inserter('qa_digit_sales_feedback',$field_array);
					////////////////////////
					$rand_array = array("audit_status" => 1);
					$this->db->where('id', $rand_ssid);
					$this->db->update('convox_call_data',$rand_array);
					$this->db->where('randomiser_id', $rand_ssid);
					$this->db->update('qa_sampling_restore',$rand_array);
					////////////////////////////////
					if($this->input->post('overall_score')=='100%'){
						$agnt_acpt_array = array(
							"agnt_fd_acpt" => 'Accepted',
							"agent_rvw_date" => $curDateTime,
							"agent_rvw_note" => 'Auto Accepted because Overall Score is 100'
						);
						$this->db->where('id', $rowid);
						$this->db->update('qa_digit_sales_feedback',$agnt_acpt_array);
					}
					//Check Agent's PIP Eligibility
					if(!in_array($field_array['audit_type'], array("OJT", "Certificate Audit", "Calibration", "Pre-Certificate Mock Call"))){
						$defect_params = getPip_EligibilityCheck($field_array, $field_array['agent_id'], "2");
						if(count($defect_params) > 0){
							if(isPIPApproved($field_array['agent_id']) == "Not Approved"){
								//Nominate Agent for PIP
								$nominate_data = array(
									"user_id"=>$field_array['agent_id'],
									"process_id"=>"2",
									"nomination_date"=>date("Y-m-d H:i:s"),
									"affected_parameters"=>implode(",", $defect_params)
								);
								$this->db->insert("pip_nomination", $nominate_data);
								//Disable Agent for further Audits
								$disable_data = array("is_pip_nominated"=>1);
								$this->db->where("id", $field_array['agent_id']);
								$this->db->set($disable_data);
								$this->db->update("signin");
							}
						}
					}
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array1['overall_score']=$this->input->post('overall_score');
					if($this->input->post('audit_status')==3){
						$field_array1['audit_status']=0;
						/* After edit if audio is uploaded */
						if($_FILES['attach_file']['tmp_name'][0]!=''){
							$a = $this->digit_upload_files($_FILES['attach_file'], $path='./qa_files/qa_digit/sales/');
							$field_array1['attach_file'] = implode(',',$a);
						}
						/* End */
					}
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_sales_feedback',$field_array1);
					/////////////
				
					if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
						if($this->input->post('qa_rebuttal')){
							$edit_array = array(
								"qa_rebuttal_by" => $current_user,
								"qa_rebuttal" => $this->input->post('qa_rebuttal'),
								"qa_rebuttal_comment" => $this->input->post('qa_rebuttal_comment'),
								"qa_rebuttal_date" => $curDateTime
							);
						}
					}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
						if($this->input->post('qa_mgnt_rebuttal')){
							$edit_array = array(
								"qa_mgnt_rebuttal_by" => $current_user,
								"qa_mgnt_rebuttal" => $this->input->post('qa_mgnt_rebuttal'),
								"qa_mgnt_rebuttal_comment" => $this->input->post('qa_mgnt_rebuttal_comment'),
								"qa_mgnt_rebuttal_date" => $curDateTime
							);
						}
					}else if(get_dept_folder()!='qa'){
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_acpt_fd" => $this->input->post('mgnt_acpt_fd'),
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					if(isset($edit_array) && !empty($edit_array)){
						$this->db->where('id', $ss_id);
						$this->db->update('qa_digit_sales_feedback',$edit_array);
					}
					//Check Agent's PIP Eligibility
					if(!in_array($field_array1['audit_type'], array("OJT", "Certificate Audit", "Calibration", "Pre-Certificate Mock Call"))){
						$defect_params = getPip_EligibilityCheck($field_array1, $field_array1['agent_id'], "2");
						if(count($defect_params) > 0){
							if(isPIPApproved($field_array1['agent_id']) == "Not Approved"){
								//Nominate Agent for PIP
								$nominate_data = array(
									"user_id"=>$field_array1['agent_id'],
									"process_id"=>"2",
									"nomination_date"=>date("Y-m-d H:i:s"),
									"affected_parameters"=>implode(",", $defect_params)
								);
								$this->db->insert("pip_nomination", $nominate_data);
								//Disable Agent for further Audits
								$disable_data = array("is_pip_nominated"=>1);
								$this->db->where("id", $field_array1['agent_id']);
								$this->db->set($disable_data);
								$this->db->update("signin");
							}
						}
					}
				}
				if ($rand_ssid!=0) {
					$rand_date = $data['rand_data'];
					$date_added = $rand_date['date_added'];
					$r_date = date("Y-m-d", strtotime($date_added));
					redirect(base_url().'Qa_sop_library/data_distribute_freshdesk?from_date='.$r_date.'&submit=Submit');
					//redirect('Qa_digit/sales');
				}else{
					redirect('Qa_digit/sales');
				}
			}
			$data["array"] = $a;
			$data["array"] = $b;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_sales_client($ss_id,$ata_edit){
		if(check_logged_in())
		{
			
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['prev_url'] = $_SERVER['HTTP_REFERER'];

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/sales/add_edit_sales_client.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			$data['ata_edit']=$ata_edit;
			
			/* $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 AND id NOT IN (SELECT employee_id FROM employee_pip WHERE status NOT IN ('S','X')) order by name"; */
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_meesho_ss_dispo_list where status=1";
			$data['l2_dispo'] = $this->Common_model->get_query_result_array($qSql); */
			
			if($ata_edit==0){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
					from qa_digit_sales_feedback where id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}else if($ata_edit==1){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=update_by) as update_name
					from qa_digit_sales_client_feedback where ss_id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}
			$data["sales"] = $this->Common_model->get_query_row_array($clientSql);
			
			//Reason data list
			$sqlReason = "Select id,reason from digitdev_sale_opportunity_reason where is_active=1";
			$data['reasonList'] = $this->Common_model->get_query_result_array($sqlReason);
			
			//Company data list
			$sqlCompany = "Select id,company from digitdev_sale_opportunity_company where is_active=1";
			$data['companyList'] = $this->Common_model->get_query_result_array($sqlCompany);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			//var_dump($_POST['data']['agent_id']);die;
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ata_edit==0){
					
					$field_array=$this->input->post('data');
					$field_array['ss_id']=$this->input->post('ss_id');
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['auditor_id']=$this->input->post('auditor_id');
					//$field_array['ticket_id']=$this->input->post('ticket_id');
					$field_array['audit_date']=mmddyy2mysql($this->input->post('audit_date'));
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					//$a = $this->snapdeal_upload_files($_FILES['attach_file'],$path='./qa_files/qa_meesho/supplier_support/');
					//$field_array['attach_file'] = implode(',',$a);
					$rowid= data_inserter('qa_digit_sales_client_feedback',$field_array);
					//echo $this->db->last_query();die;
				///////////
					$ata_array = array("ata_edit" => 1);
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_sales_feedback',$ata_array);
				
				}else if($ata_edit==1){
					
					$field_array1=$this->input->post('data');
					$field_array1['update_by']=$current_user;
					$field_array1['update_date']=$curDateTime;
					$field_array1['update_note']=$this->input->post('note');
					$this->db->where('ss_id', $ss_id);
					$this->db->update('qa_digit_sales_client_feedback',$field_array1);
					
				}
				$prev_url = $this->input->post('prev_url');
				redirect($prev_url);
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/*-------------------------------- QA Rebuttal --------------------------------*/
	public function qa_sales_rebuttal(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/sales/qa_sales_rebuttal.php";
			$data["content_js"] = "qa_digit_js.php";
			
			if(get_global_access()=='1'){
				//$ops_cond=" where agnt_fd_acpt='Not Accepted'";
				$ops_cond=" where agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
			}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
			}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
			}
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_sales_feedback) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				Left Join (select ss_id as ata_audit_id from qa_digit_sales_client_feedback) zz On (xx.id=zz.ata_audit_id)
				$ops_cond order by audit_date";
			$data["rebuttal_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
///// CALL PART

	public function call(){
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/call/qa_call_feedback.php";
			$data["content_js"] = "qa_digit_js.php";
			
			if(((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='operations') || get_dept_folder()=='training'){
				$data["rebuttal"]='';
			}else{
				if(get_global_access()=='1'){
					$rebuttalSql="Select count(id) as value from qa_digit_call_feedback where agnt_fd_acpt='Not Accepted'";
				}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_digit_call_feedback where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
				}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_digit_call_feedback where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
				}
				$data["rebuttal"]=$this->Common_model->get_single_value($rebuttalSql);
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_digit_call_feedback group by entry_by";
			$data["qaName"] = $this->Common_model->get_query_result_array($qaSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$qa_id = $this->input->get('qa_id');
			$cond="";
			$atacond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($qa_id !="")	$cond .=" and entry_by='$qa_id'";
			
			if(get_global_access()=='1'){
				$ops_cond="where 1";
			}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user') or entry_by='$current_user')";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' or entry_by='$current_user')";
			}else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
				$ops_cond=" Where entry_by='$current_user'";
			}else{
				$ops_cond="where 1";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_call_feedback $cond) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				$ops_cond order by audit_date";
			$data["call_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["qa_id"] = $qa_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_call($ss_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/call/add_edit_call.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			
			$qSql="Select office_name as value from office_location where abbr='$user_office_id'";
			$data["auditorLocation"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */
			
			/* $qSql = "SELECT * FROM qa_meesho_ss_dispo_list where status=1";
			$data['l2_dispo'] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as auditor_center,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sqmr where sqmr.id=qa_mgnt_rebuttal_by) as qa_mgnt_rebuttal_name
				from qa_digit_call_feedback where id='$ss_id') xx 
				Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)
				Left Join (select ss_id as ata_audit_id from qa_digit_call_client_feedback) zz On (xx.id=zz.ata_audit_id)";
			$data["call"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			$b = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ss_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['overall_score']=$this->input->post('overall_score');

					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->digit_upload_files($_FILES['attach_file'], $path='./qa_files/qa_digit/call/');
						$field_array['attach_file'] = implode(',',$a);
					}
					
					if($_FILES['attach_img_file']['tmp_name'][0]!=''){
						$b = $this->digit_upload_image_files($_FILES['attach_img_file'], $path='./qa_files/qa_digit/call/images/');
						$field_array['attach_img_file'] = implode(',',$b);
					}
					
					$rowid= data_inserter('qa_digit_call_feedback',$field_array);
				////////////////////////
					if($this->input->post('overall_score')=='100%'){
						$agnt_acpt_array = array(
							"agnt_fd_acpt" => 'Accepted',
							"agent_rvw_date" => $curDateTime,
							"agent_rvw_note" => 'Auto Accepted because Overall Score is 100'
						);
						$this->db->where('id', $rowid);
						$this->db->update('qa_digit_call_feedback',$agnt_acpt_array);
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array1['overall_score']=$this->input->post('overall_score');
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_call_feedback',$field_array1);
				/////////////
					if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
						if($this->input->post('qa_rebuttal')){
							$edit_array = array(
								"qa_rebuttal_by" => $current_user,
								"qa_rebuttal" => $this->input->post('qa_rebuttal'),
								"qa_rebuttal_comment" => $this->input->post('qa_rebuttal_comment'),
								"qa_rebuttal_date" => $curDateTime
							);
						}
					}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
						if($this->input->post('qa_mgnt_rebuttal')){
							$edit_array = array(
								"qa_mgnt_rebuttal_by" => $current_user,
								"qa_mgnt_rebuttal" => $this->input->post('qa_mgnt_rebuttal'),
								"qa_mgnt_rebuttal_comment" => $this->input->post('qa_mgnt_rebuttal_comment'),
								"qa_mgnt_rebuttal_date" => $curDateTime
							);
						}
					}else if(get_dept_folder()!='qa'){
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_acpt_fd" => $this->input->post('mgnt_acpt_fd'),
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_call_feedback',$edit_array);
					
				}
				redirect('Qa_digit/call');
			}
			$data["array"] = $a;
			$data["array"] = $b;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_call_client($ss_id,$ata_edit){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/call/add_edit_call_client.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			$data['ata_edit']=$ata_edit;
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_meesho_ss_dispo_list where status=1";
			$data['l2_dispo'] = $this->Common_model->get_query_result_array($qSql); */
			
			if($ata_edit==0){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
					from qa_digit_call_feedback where id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}else if($ata_edit==1){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=update_by) as update_name
					from qa_digit_call_client_feedback where ss_id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}
			$data["call"] = $this->Common_model->get_query_row_array($clientSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ata_edit==0){
					
					$field_array=$this->input->post('data');
					$field_array['ss_id']=$this->input->post('ss_id');
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['auditor_id']=$this->input->post('auditor_id');
					$field_array['ticket_id']=$this->input->post('ticket_id');
					$field_array['audit_date']=mmddyy2mysql($this->input->post('audit_date'));
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					$rowid= data_inserter('qa_digit_call_client_feedback',$field_array);
				///////////
					$ata_array = array("ata_edit" => 1);
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_call_feedback',$ata_array);
				
				}else if($ata_edit==1){
					
					$field_array1=$this->input->post('data');
					$field_array1['update_by']=$current_user;
					$field_array1['update_date']=$curDateTime;
					$field_array1['update_note']=$this->input->post('note');
					$this->db->where('ss_id', $ss_id);
					$this->db->update('qa_digit_call_client_feedback',$field_array1);
					
				}
				redirect('Qa_digit/call');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	} 


/*-------------------------------- QA Rebuttal --------------------------------*/
	public function qa_call_rebuttal(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/call/qa_call_rebuttal.php";
			$data["content_js"] = "qa_digit_js.php";
			
			if(get_global_access()=='1'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted'";
			}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
			}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
			}
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_call_feedback) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				Left Join (select ss_id as ata_audit_id from qa_digit_call_client_feedback) zz On (xx.id=zz.ata_audit_id)
				$ops_cond order by audit_date";
			$data["rebuttal_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
///// ACPT PART

	public function acpt(){
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/acpt/qa_acpt_feedback.php";
			$data["content_js"] = "qa_digit_js.php";
			
			if(((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='operations') || get_dept_folder()=='training'){
				$data["rebuttal"]='';
			}else{
				if(get_global_access()=='1'){
					$rebuttalSql="Select count(id) as value from qa_digit_acpt_feedback where agnt_fd_acpt='Not Accepted'";
				}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_digit_acpt_feedback where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
				}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_digit_acpt_feedback where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
				}
				$data["rebuttal"]=$this->Common_model->get_single_value($rebuttalSql);
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			//$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_digit_acpt_feedback group by entry_by";
			$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_digit_acpt_feedback LEFT JOIN signin ON qa_digit_acpt_feedback.entry_by=signin.id where signin.status=1 group by entry_by";
			$data["qaName"] = $this->Common_model->get_query_result_array($qaSql);
			
			
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$qa_id = $this->input->get('qa_id');
			$cond="";
			$atacond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($qa_id !="")	$cond .=" and entry_by='$qa_id'";
			
			if(get_global_access()=='1'){
				$ops_cond="where 1";
			}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user') or entry_by='$current_user')";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' or entry_by='$current_user')";
			}else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
				$ops_cond=" Where entry_by='$current_user'";
			}else{
				$ops_cond="where 1";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_acpt_feedback $cond) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				$ops_cond order by audit_date";
			$data["acpt_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["qa_id"] = $qa_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_acpt($ss_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/acpt/add_edit_acpt.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			
			$qSql="Select office_name as value from office_location where abbr='$user_office_id'";
			$data["auditorLocation"] =  $this->Common_model->get_single_value($qSql);
			
			//$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";	/* and is_assign_client (id,105) */
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder in ('agent','support')) and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";	
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */
			
			/* $qSql = "SELECT * FROM qa_meesho_ss_dispo_list where status=1";
			$data['l2_dispo'] = $this->Common_model->get_query_result_array($qSql); */
			
			$lobSql="SELECT id, campaign, is_active FROM campaign where is_active=1";
			$data['lob_list']=$this->Common_model->get_query_result_array($lobSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=agent_id)) as agent_location,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as auditor_center,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sqmr where sqmr.id=qa_mgnt_rebuttal_by) as qa_mgnt_rebuttal_name
				from qa_digit_acpt_feedback where id='$ss_id') xx 
				Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)
				Left Join (select ss_id as ata_audit_id from qa_digit_sales_client_feedback) zz On (xx.id=zz.ata_audit_id)";
			$data["acpt"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			$b = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ss_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->digit_upload_files($_FILES['attach_file'], $path='./qa_files/qa_digit/acpt/');
						$field_array['attach_file'] = implode(',',$a);
					}
					
					if($_FILES['attach_img_file']['tmp_name'][0]!=''){
						$b = $this->digit_upload_image_files($_FILES['attach_img_file'], $path='./qa_files/qa_digit/acpt/images/');
						$field_array['attach_img_file'] = implode(',',$b);
					}
					
					$rowid= data_inserter('qa_digit_acpt_feedback',$field_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_acpt_feedback',$field_array1);
				/////////////
					if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
						if($this->input->post('qa_rebuttal')){
							$edit_array = array(
								"qa_rebuttal_by" => $current_user,
								"qa_rebuttal" => $this->input->post('qa_rebuttal'),
								"qa_rebuttal_comment" => $this->input->post('qa_rebuttal_comment'),
								"qa_rebuttal_date" => $curDateTime
							);
						}
					}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
						if($this->input->post('qa_mgnt_rebuttal')){
							$edit_array = array(
								"qa_mgnt_rebuttal_by" => $current_user,
								"qa_mgnt_rebuttal" => $this->input->post('qa_mgnt_rebuttal'),
								"qa_mgnt_rebuttal_comment" => $this->input->post('qa_mgnt_rebuttal_comment'),
								"qa_mgnt_rebuttal_date" => $curDateTime
							);
						}
					}else if(get_dept_folder()!='qa'){
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_acpt_fd" => $this->input->post('mgnt_acpt_fd'),
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_acpt_feedback',$edit_array);
					
				}
				redirect('Qa_digit/acpt');
			}
			$data["array"] = $a;
			$data["array"] = $b;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_acpt_client($ss_id,$ata_edit){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/acpt/add_edit_acpt_client.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			$data['ata_edit']=$ata_edit;
			
			//$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder in ('agent','support')) and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_meesho_ss_dispo_list where status=1";
			$data['l2_dispo'] = $this->Common_model->get_query_result_array($qSql); */
			
			$lobSql="SELECT id, campaign, is_active FROM campaign where is_active=1";
			$data['lob_list']=$this->Common_model->get_query_result_array($lobSql);
			
			if($ata_edit==0){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select office_name from office_location where abbr=(select office_id from signin os where os.id=agent_id)) as agent_location,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
					from qa_digit_acpt_feedback where id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}else if($ata_edit==1){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select office_name from office_location where abbr=(select office_id from signin os where os.id=agent_id)) as agent_location,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=update_by) as update_name
					from qa_digit_acpt_client_feedback where ss_id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}
			$data["acpt"] = $this->Common_model->get_query_row_array($clientSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ata_edit==0){
					
					$field_array=$this->input->post('data');
					$field_array['ss_id']=$this->input->post('ss_id');
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['auditor_id']=$this->input->post('auditor_id');
					$field_array['ticket_id']=$this->input->post('ticket_id');
					$field_array['audit_date']=mmddyy2mysql($this->input->post('audit_date'));
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					//$a = $this->snapdeal_upload_files($_FILES['attach_file'],$path='./qa_files/qa_meesho/supplier_support/');
					//$field_array['attach_file'] = implode(',',$a);
					$rowid= data_inserter('qa_digit_acpt_client_feedback',$field_array);
				///////////
					$ata_array = array("ata_edit" => 1);
					$this->db->where('id', $ss_id);
					$this->db->update('qa_digit_acpt_feedback',$ata_array);
				
				}else if($ata_edit==1){
					
					$field_array1=$this->input->post('data');
					$field_array1['update_by']=$current_user;
					$field_array1['update_date']=$curDateTime;
					$field_array1['update_note']=$this->input->post('note');
					$this->db->where('ss_id', $ss_id);
					$this->db->update('qa_digit_acpt_client_feedback',$field_array1);
					
				}
				redirect('Qa_digit/acpt');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/*-------------------------------- QA Rebuttal --------------------------------*/
	public function qa_acpt_rebuttal(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/acpt/qa_acpt_rebuttal.php";
			$data["content_js"] = "qa_digit_js.php";
			
			if(get_global_access()=='1'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted'";
			}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
			}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
			}
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_acpt_feedback) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				Left Join (select ss_id as ata_audit_id from qa_digit_sales_client_feedback) zz On (xx.id=zz.ata_audit_id)
				$ops_cond order by audit_date";
			$data["rebuttal_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
/*-------------------------------- Agent Fatal Accepted by TL --------------------------------*/
	public function tl_fatal_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$curDateTime=CurrMySqlDate();
			$ss_id = $this->input->post('ss_id');
			$digit_tbl = $this->input->post('digit_tbl');
			$agnt_fatal_tl_fd = $this->input->post('agnt_fatal_tl_fd');
			$agnt_fatal_tl_note = $this->input->post('agnt_fatal_tl_note');
			
			if($ss_id!=""){
				$qa_array = array(
					"agnt_fatal_tl_fd" => $agnt_fatal_tl_fd,
					"agnt_fatal_tl_note" => $agnt_fatal_tl_note,
					"agnt_fatal_tl_date" => $curDateTime
				);
				$this->db->where('id', $ss_id);
				$this->db->update($digit_tbl,$qa_array);
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "qa_digit";
			redirect($referer);
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
///// AGENT Part
	
	public function agent_digit_feedback()
	{
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/agent_digit_feedback.php";
			$data["content_js"] = "qa_digit_js.php";
			$data["agentUrl"] = "qa_digit/agent_digit_feedback";

			$p_sql = "select * from qa_defect where is_active = 1";
			$p_data = $this->Common_model->get_query_result_array($p_sql);
			
			$data['p_data'] = $p_data;
				
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$campaign_table = '';
			$cond="";
			$acptcond="";
			
			$campaign_table = $this->input->get('campaign');
			
			if ($campaign_table != '') {
				$campaign = substr($campaign_table,9,-9);
			}else{
				$campaign = '';
			}
			
			if($campaign!=''){
				
				if($campaign!='acpt'){
					//$acptcond .=" and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','OJT')";
					$acptcond .="";
				}else{
					$acptcond="";
				}
				
				$qSql="Select count(id) as value from qa_digit_".$campaign."_feedback where agent_id='$current_user' $acptcond";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
					
				$qSql="Select count(id) as value from qa_digit_".$campaign."_feedback where agent_id='$current_user' $acptcond and agent_rvw_date is Null";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate !="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user'  ";
					}else{
						$cond= " Where agent_id='$current_user' ";
					}
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_".$campaign."_feedback $cond $acptcond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['tbl_name'] = $campaign_table;
			$data["campaign"] = $campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_digit_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			if (strpos($campaign, 'posp') !== false) {
				$data["content_template"] = "qa_digit/call/agent_".$campaign."_rvw.php";
			}else{
				$data["content_template"] = "qa_digit/agent_digit_rvw.php";
			}
			
			$data["aside_template"] = "qa/aside.php";
			//$data["content_template"] = "qa_digit/agent_digit_rvw.php";
			$data["content_js"] = "qa_digit_js.php";
			$data["agentUrl"] = "qa_digit/agent_digit_feedback";
			$data["campaign"]=$campaign;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_digit_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["digit_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			//Reason data list
			$sqlReason = "Select id,reason from digitdev_sale_opportunity_reason where is_active=1";
			$data['reasonList'] = $this->Common_model->get_query_result_array($sqlReason);
			
			//Company data list
			$sqlCompany = "Select id,company from digitdev_sale_opportunity_company where is_active=1";
			$data['companyList'] = $this->Common_model->get_query_result_array($sqlCompany);
		
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('agent_rvw_note'),
					"agent_rvw_date" => $curDateTime
				);				
				$this->db->where('id', $pnid);
				$this->db->update('qa_digit_'.$campaign.'_feedback',$field_array1);
				
				redirect('Qa_digit/agent_digit_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
///// QA REPORT

	public function qa_digit_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_digit/qa_digit_report.php";
			$data["content_js"] = "qa_digit_js.php";
			
			$p_sql = "select * from qa_defect where is_active = 1";
			$p_data = $this->Common_model->get_query_result_array($p_sql);
			$data['p_data'] = $p_data;

	
			// $pValue = trim($this->input->post('process_id'));
			// if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			
			
			if(get_global_access()==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$date_from="";
			$date_to="";
			$a_type="";
			$action="";
			$dn_link="";
			$cond='';
			$cond1='';
			$cond2='';
			$camp_cond='';
			
			$data["qa_digit_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$qa_defect_id = $this->input->get('process_id');
				if ($qa_defect_id != 'acpt') {
				$data['qa_defect_id']=$qa_defect_id;
				$tbl_sql = "select * from qa_defect where id = $qa_defect_id and is_active = 1";
				$tbl_data = $this->Common_model->get_query_row_array($tbl_sql);
				$pValue = substr($tbl_data['table_name'],9,-9);			
				}else{
					$pValue = 'acpt';
				}
				$data['pValue']=$pValue;

				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$a_type = $this->input->get('a_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (date(audit_date) >= '$date_from' and date(audit_date) <= '$date_to' ) ";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if($a_type=="All"){
					$cond2="";
				}else{
					$cond2 .=" and audit_type='$a_type'";
				}
					
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}	
				//echo $pValue;
				//echo "<br>";
				$subQ="";
				if($pValue == 'sales'){
					$subQ .= ",(select reason from digitdev_sale_opportunity_reason where digitdev_sale_opportunity_reason.id=sales_opportunity_reason) as reason,";
					$subQ .= "(select company from digitdev_sale_opportunity_company where digitdev_sale_opportunity_company.id=sales_opportunity_company) as company ";
				}
				
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select office_name from office_location where abbr=(select office_id from signin ss where ss.id=agent_id)) as agent_location,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as qa_location,
				(select email_id_off from info_personal ip where ip.user_id=entry_by) as auditor_email,
				(select email_id_off from info_personal ips where ips.user_id=agent_id) as agent_email,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sqrm where sqrm.id=qa_mgnt_rebuttal_by) as qa_rebuttal_mgnt_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name $subQ from qa_digit_".$pValue."_feedback) xx 
				Left Join (Select id as sid, concat(fname, ' ', lname) as agent_name, xpoid, fusion_id, doj, assigned_to, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_digit_list"] = $fullAray;
				//print_r($data["qa_digit_list"]);
				
				$this->create_qa_digit_CSV($fullAray,$pValue);	
				$dn_link = base_url()."qa_digit/download_qa_digit_CSV/".$pValue;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['a_type']=$a_type;
			
			$this->load->view('dashboard',$data);
		}
	}
	

	public function download_qa_digit_CSV($pid)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Digit Insurance ".$pid." List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_digit_CSV($rr,$pid)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$param_sql = "SELECT table_name,params_columns,param_coloum_desc FROM qa_defect where table_name = 'qa_digit_".$pid."_feedback' and is_active = 1";
		$defect_data = $this->Common_model->get_query_row_array($param_sql);
		$param_array = explode(',', $defect_data['param_coloum_desc']);
		$column_array = explode(',', $defect_data['params_columns']);
		$t_name = $defect_data['table_name'];
		
		foreach ($param_array as $key => $p_array) {
			$new_array[] = $p_array; 
			$new_array[] = 'Remarks'; 
		}
		$header_param = implode('","', $new_array);
		$a = 1;
		foreach ($column_array as $key => $c_array) {
			$c_field[] = $c_array; 
			$c_field[] = 'comm'.$a;
			$a++;
		}
		
		if (strpos($pid, 'posp') !== false) {
			$header1 = array("QA name", "QA Location", "Agent Name","Agent Location","Phone", "TL Name", "Tenure", "Earn Score", "Possible Score", "Quality Score","Soft Skill Score","Sales Skill Score", "PreFatal Score", "Fatal Count", "Week", "Audit Date", "Ticket ID", "Call Date", "AHT","LOB", "Disposition","Sub Disposition","Sub Sub Disposition", "Audit Type", "VOC","VOC Comment","No of Call Heard", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Audit Approved Date");
			$header2 = $new_array;
			$header3 = array("Call Summary", "Feedback","Certification Attempt","Certification Status", "QA Rebuttal By","QA Rebuttal","QA Rebuttal Date","QA Rebuttal Comment", "QA MGNT Rebuttal By","QA MGNT Rebuttal","QA MGNT Rebuttal Date","QA MGNT Rebuttal Comment",
			"Agent Review Date", "Agent Feedback Acceptance Status", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Attach Audio File");
			$header = array_merge($header1,$header2,$header3);
		}

		if($pid=='sales'){
			/* $header = array("QA name", "QA Location", "Agent Name","Agent Location","Phone", "TL Name", "Tenure", "Earn Score", "Possible Score", "Quality Score","Soft Skill Score","Sales Skill Score", "PreFatal Score", "Fatal Count", "Week", "Audit Date", "Ticket ID", "Call Date", "AHT","LOB", "Disposition","Sub Disposition","Sub Sub Disposition", "Audit Type", "VOC","VOC Comment","No of Call Heard", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Audit Approved Date",
			"Comprehension Skills","Remarks", "Communication Skills","Remarks", "Enthusiasm/Politeness/Personalization","Remarks", "Empathy & acknowledgment","Remarks", "Dead air","Remarks", "Script Adherence & Process Compliance","Remarks", "Documentation","Remarks", "Verification & Disclaimers","Remarks", "Mis-selling","Remarks", "Need Creation","Remarks", "FA-Bing","Remarks", "Probing & Positioning","Remarks", "Negotiation Skills","ZRemarks", "Objection handling","Remarks", "Urgency","Remarks", "Call Summary", "Feedback","Certification Attempt","Certification Status", "QA Rebuttal By","QA Rebuttal","QA Rebuttal Date","QA Rebuttal Comment", "QA MGNT Rebuttal By","QA MGNT Rebuttal","QA MGNT Rebuttal Date","QA MGNT Rebuttal Comment",
			"Agent Review Date", "Agent Feedback Acceptance Status", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Attach Audio File"); */
			$header = array("QA name", "QA Location", "Agent Name","Agent Location","Phone", "TL Name", "Tenure", "Earn Score", "Possible Score", "Quality Score","Soft Skill Score","Sales Skill Score", "PreFatal Score", "Fatal Count", "Week", "Audit Date", "Ticket ID", "Call Date", "AHT","LOB", "Disposition","Sub Disposition","Sub Sub Disposition", "Audit Type", "VOC","VOC Comment","No of Call Heard", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Audit Approved Date",
			"Comprehension Skills","Remarks", "Communication Skills","Remarks", "Enthusiasm/Politeness/Personalization","Remarks", "Empathy & acknowledgment","Remarks", "Dead air","Remarks", "Script Adherence & Process Compliance","Remarks", "Documentation","Remarks", "Verification & Disclaimers","Remarks", "Mis-selling","Remarks", "Need Creation","Remarks", "FA-Bing","Remarks", "Probing & Positioning","Remarks", "Negotiation Skills","ZRemarks", "Objection handling","Remarks", "Urgency","Remarks", "Call Summary", "Feedback","Sale Opportunity","Reason","TNI","Comment","Certification Attempt","Certification Status", "QA Rebuttal By","QA Rebuttal","QA Rebuttal Date","QA Rebuttal Comment", "QA MGNT Rebuttal By","QA MGNT Rebuttal","QA MGNT Rebuttal Date","QA MGNT Rebuttal Comment",
			"Agent Review Date", "Agent Feedback Acceptance Status", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Attach Audio File");
		}else if($pid=='acpt'){
			/* $header = array("QA name", "QA Location", "Agent Name", "TL Name", "Tenure", "Week", "Audit Date", "Call/Ticket ID", "Interaction Date/Time", "AHT", "LOB/Capmaign", "Disposition", "Sub Disposition", "Sub Sub Disposition", "Disposition Accuracy", "Disposition Comment", "Auditor Disposition Comment", "Audit Type", "Level-1", "Level-2", "Observation", "Opportunity Detail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)",
			"QA Rebuttal By","QA Rebuttal","QA Rebuttal Date","QA Rebuttal Comment", "QA MGNT Rebuttal By","QA MGNT Rebuttal","QA MGNT Rebuttal Date","QA MGNT Rebuttal Comment", "Agent Review Date", "Agent Feedback Acceptance Status", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Attach Audio File"); */
			$header = array("QA name", "QA Location", "Agent Name","Agent Location", "TL Name", "Tenure","Tenurity Bucket", "Week", "Audit Date", "Call/Ticket ID", "Interaction Date/Time", "AHT", "LOB/Capmaign", "Disposition", "Sub Disposition", "Sub Sub Disposition", "Disposition Accuracy", "Disposition Comment", "Auditor Disposition Comment", "Audit Type","Language", "Level-1", "Level-2", "Observation", "Opportunity Detail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Finding 1","Finding 2");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if (strpos($pid, 'posp') !== false) {
		
			foreach($rr as $user)
			{	
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if(is_available_qa_feedback($user['entry_date'],72) == true){
					$agnt_fd_acpt = $user['agnt_fd_acpt'];
				}else{
					if($user['agent_rvw_date']!=""){
						$agnt_fd_acpt = $user['agnt_fd_acpt'];
					}else{
						//$agnt_fd_acpt = "Auto Accepted";
						$agnt_fd_acpt = "";
					}
				}
				
				$fdbk_sts = $this->acceptance_status($t_name,$user['id']);
				
				if($user['week']!=""){
					$week=$user['week'];
				}else{
					$week='Week4';
				}
				
				if($user['audit_approved_date']=="" || $user['audit_approved_date']=='0000-00-00 00:00:00'){
					$audit_approved_date='---';
				}else{
					$audit_approved_date=ConvServerToLocal($user['audit_approved_date']);
				}

				if($user['qa_rebuttal_date']=="" || $user['qa_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_rebuttal_date='---';
				}else{
					$qa_rebuttal_date=ConvServerToLocal($user['qa_rebuttal_date']);
				}
				
				if($user['qa_mgnt_rebuttal_date']=="" || $user['qa_mgnt_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_mgnt_rebuttal_date='---';
				}else{
					$qa_mgnt_rebuttal_date=ConvServerToLocal($user['qa_mgnt_rebuttal_date']);
				}

				if($user['agent_rvw_date']!=""){
					$agent_rvw_date = ConvServerToLocal($user['agent_rvw_date']);
				}else{
					$agent_rvw_date = "";
				}
				
				if($user['certification_attempt']==1){
					$certification_attempt="First Attempt";
				}else if($user['certification_attempt']==2){
					$certification_attempt="Second Attempt";
				}else if($user['certification_attempt']==3){
					$certification_attempt="Third Attempt";
				}else{
					$certification_attempt="";
				}
				
				$adtdate=ConvServerToLocal($user['entry_date']);
				$time = strtotime($adtdate);
				$auditDate = date('Y-m-d',$time);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['qa_location'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['agent_location'].'",'; 
				$row .= '"'.$user['phone'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['earn_score'].'",'; 
				$row .= '"'.$user['possible_score'].'",'; 
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.$user['soft_skill_score'].'%'.'",';
				$row .= '"'.$user['sale_skill_score'].'%'.'",';
				$row .= '"'.$user['pre_fatal_score'].'",'; 
				$row .= '"'.$user['fatal_count'].'",'; 
				$row .= '"'.$week.'",';
				$row .= '"'.$auditDate.'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['lob_campaign'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['sub_disposition'].'",';
				$row .= '"'.$user['sub_sub_disposition'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['voc_comment'].'",';
				$row .= '"'.$user['no_of_call_heard'].'",';
				$row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
				$row .= '"'.ConvServerToLocal($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$audit_approved_date.'",';

				foreach ($c_field as $key => $value) {
					if (strpos($value, 'comm') !== false) {
						$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user[$value])).'",';
					}else{
						$row .= '"'.$user[$value].'",';
					}
					
				}

				// $row .= '"'.$user['comprehension_skill'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm1'])).'",';
				// $row .= '"'.$user['communication_skill'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm2'])).'",';
				// $row .= '"'.$user['enthusiasm_politeness'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm3'])).'",';
				// $row .= '"'.$user['empathy_acknowledgement'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm4'])).'",';
				// $row .= '"'.$user['dead_air'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm5'])).'",';
				// $row .= '"'.$user['script_adherence'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm6'])).'",';
				// $row .= '"'.$user['documentation'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm7'])).'",';
				// $row .= '"'.$user['verification'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm8'])).'",';
				// $row .= '"'.$user['mis_selling'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm9'])).'",';
				// $row .= '"'.$user['need_creation'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm10'])).'",';
				// $row .= '"'.$user['fa_bing'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm11'])).'",';
				// $row .= '"'.$user['probing_positioning'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm12'])).'",';
				// $row .= '"'.$user['negosiation_skill'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm13'])).'",';
				// $row .= '"'.$user['objection_handling'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm14'])).'",';
				// $row .= '"'.$user['urgency'].'",';
				// $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$certification_attempt.'",';
				$row .= '"'.$user['certification_status'].'",';
				$row .= '"'.$user['qa_rebuttal_name'].'",';
				$row .= '"'.$user['qa_rebuttal'].'",';
				$row .= '"'.$user['qa_rebuttal_date	'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_rebuttal_comment'])).'",';
				$row .= '"'.$user['qa_rebuttal_mgnt_name'].'",';
				$row .= '"'.$user['qa_mgnt_rebuttal'].'",';
				$row .= '"'.$user['qa_mgnt_rebuttal_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_mgnt_rebuttal_comment'])).'",';
				$row .= '"'.$agent_rvw_date.'",';
				//$row .= '"'.$agnt_fd_acpt.'",';
				$row .= '"'.$fdbk_sts.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['attach_file'])).'"';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}


		if($pid=='sales'){
		
			foreach($rr as $user)
			{	
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if(is_available_qa_feedback($user['entry_date'],72) == true){
					$agnt_fd_acpt = $user['agnt_fd_acpt'];
				}else{
					if($user['agent_rvw_date']!=""){
						$agnt_fd_acpt = $user['agnt_fd_acpt'];
					}else{
						//$agnt_fd_acpt = "Auto Accepted";
						$agnt_fd_acpt = "";
					}
				}
				
				$fdbk_sts = $this->acceptance_status($t_name,$user['id']);

				if($user['week']!=""){
					$week=$user['week'];
				}else{
					$week='Week4';
				}
				
				if($user['audit_approved_date']=="" || $user['audit_approved_date']=='0000-00-00 00:00:00'){
					$audit_approved_date='---';
				}else{
					$audit_approved_date=ConvServerToLocal($user['audit_approved_date']);
				}

				if($user['qa_rebuttal_date']=="" || $user['qa_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_rebuttal_date='---';
				}else{
					$qa_rebuttal_date=ConvServerToLocal($user['qa_rebuttal_date']);
				}
				
				if($user['qa_mgnt_rebuttal_date']=="" || $user['qa_mgnt_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_mgnt_rebuttal_date='---';
				}else{
					$qa_mgnt_rebuttal_date=ConvServerToLocal($user['qa_mgnt_rebuttal_date']);
				}
				
				if($user['certification_attempt']==1){
					$certification_attempt="First Attempt";
				}else if($user['certification_attempt']==2){
					$certification_attempt="Second Attempt";
				}else if($user['certification_attempt']==3){
					$certification_attempt="Third Attempt";
				}else{
					$certification_attempt="";
				}
				
				if($user['agent_rvw_date']!=""){
					$agent_rvw_date = ConvServerToLocal($user['agent_rvw_date']);
				}else{
					$agent_rvw_date = "";
				}
				
				$adtdate=ConvServerToLocal($user['entry_date']);
				$time = strtotime($adtdate);
				$auditDate = date('Y-m-d',$time);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['qa_location'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['agent_location'].'",'; 
				$row .= '"'.$user['phone'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['earn_score'].'",'; 
				$row .= '"'.$user['possible_score'].'",'; 
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.$user['soft_skill_score'].'%'.'",';
				$row .= '"'.$user['sale_skill_score'].'%'.'",';
				$row .= '"'.$user['pre_fatal_score'].'",'; 
				$row .= '"'.$user['fatal_count'].'",'; 
				$row .= '"'.$week.'",';
				$row .= '"'.$auditDate.'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['lob_campaign'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['sub_disposition'].'",';
				$row .= '"'.$user['sub_sub_disposition'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['voc_comment'].'",';
				$row .= '"'.$user['no_of_call_heard'].'",';
				$row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
				$row .= '"'.ConvServerToLocal($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$audit_approved_date.'",';
				$row .= '"'.$user['comprehension_skill'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm1'])).'",';
				$row .= '"'.$user['communication_skill'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm2'])).'",';
				$row .= '"'.$user['enthusiasm_politeness'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm3'])).'",';
				$row .= '"'.$user['empathy_acknowledgement'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm4'])).'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm5'])).'",';
				$row .= '"'.$user['script_adherence'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm6'])).'",';
				$row .= '"'.$user['documentation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm7'])).'",';
				$row .= '"'.$user['verification'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm8'])).'",';
				$row .= '"'.$user['mis_selling'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm9'])).'",';
				$row .= '"'.$user['need_creation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm10'])).'",';
				$row .= '"'.$user['fa_bing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm11'])).'",';
				$row .= '"'.$user['probing_positioning'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm12'])).'",';
				$row .= '"'.$user['negosiation_skill'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm13'])).'",';
				$row .= '"'.$user['objection_handling'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm14'])).'",';
				$row .= '"'.$user['urgency'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['sales_oppotunity'].'",';
				$row .= '"'.$user['reason'].'",';
				$row .= '"'.$user['company'].'",';
				$row .= '"'.str_replace('"',"'",str_replace($searches, "", $user['sales_opportunity_comment'])).'",';
				$row .= '"'.$certification_attempt.'",';
				$row .= '"'.$user['certification_status'].'",';
				$row .= '"'.$user['qa_rebuttal_name'].'",';
				$row .= '"'.$user['qa_rebuttal'].'",';
				$row .= '"'.$user['qa_rebuttal_date	'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_rebuttal_comment'])).'",';
				$row .= '"'.$user['qa_rebuttal_mgnt_name'].'",';
				$row .= '"'.$user['qa_mgnt_rebuttal'].'",';
				$row .= '"'.$user['qa_mgnt_rebuttal_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_mgnt_rebuttal_comment'])).'",';
				$row .= '"'.$agent_rvw_date.'",';
				//$row .= '"'.$agnt_fd_acpt.'",';
				$row .= '"'.$fdbk_sts.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['attach_file'])).'"';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='acpt'){
		
			foreach($rr as $user)
			{	
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if(is_available_qa_feedback($user['entry_date'],72) == true){
					$agnt_fd_acpt = $user['agnt_fd_acpt'];
				}else{
					if($user['agent_rvw_date']!=""){
						$agnt_fd_acpt = $user['agnt_fd_acpt'];
					}else{
						//$agnt_fd_acpt = "Auto Accepted";
						$agnt_fd_acpt = "";
					}
				}
				
				if($user['week']!=""){
					$week=$user['week'];
				}else{
					$week='Week4';
				}
				
				if($user['qa_rebuttal_date']=="" || $user['qa_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_rebuttal_date='---';
				}else{
					$qa_rebuttal_date=ConvServerToLocal($user['qa_rebuttal_date']);
				}
				
				if($user['qa_mgnt_rebuttal_date']=="" || $user['qa_mgnt_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_mgnt_rebuttal_date='---';
				}else{
					$qa_mgnt_rebuttal_date=ConvServerToLocal($user['qa_mgnt_rebuttal_date']);
				}
				
				$adtdate=ConvServerToLocal($user['entry_date']);
				$time = strtotime($adtdate);
				$auditDate = date('Y-m-d',$time);
				
				// AHT Convertion to sec
				$aht = $this->timeToSeconds($user['call_duration']);
				
				// Tenurity Bucket // 0-30 // 30-90 // 90-180 // 180+
				
				if($user['tenure']>=0 && $user['tenure']<=30){
					$bucket = "0-30";
				}else if($user['tenure']>30 && $user['tenure']<=90)
				{
					$bucket = "30-90";
				}
				else if($user['tenure']>90 && $user['tenure']<=180)
				{
					$bucket = "90-180";
				}else{
					$bucket = "180+";
				}
				
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['qa_location'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['agent_location'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$bucket.'",';
				$row .= '"'.$week.'",';
				$row .= '"'.$auditDate.'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['call_date'].'",';
				//$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$aht.'",';
				$row .= '"'.$user['lob_campaign'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['sub_disposition'].'",';
				$row .= '"'.$user['sub_sub_disposition'].'",';
				$row .= '"'.$user['disposition_accuracy'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['disposition_comment'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['auditor_disposition_comment'])).'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['language'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['acpt_l2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['observation'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['opportunity_details'])).'",';
				$row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
				$row .= '"'.ConvServerToLocal($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['finding_1'].'",';
				$row .= '"'.$user['finding_2'].'"';
				/* $row .= '"'.$user['qa_rebuttal_name'].'",';
				$row .= '"'.$user['qa_rebuttal'].'",';
				$row .= '"'.$user['qa_rebuttal_date	'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_rebuttal_comment'])).'",';
				$row .= '"'.$user['qa_rebuttal_mgnt_name'].'",';
				$row .= '"'.$user['qa_mgnt_rebuttal'].'",';
				$row .= '"'.$user['qa_mgnt_rebuttal_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_mgnt_rebuttal_comment'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$agnt_fd_acpt.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['attach_file'])).'"'; */
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}
		
	}
	//////////convert hrs min sec to sec ////////////
	function timeToSeconds(string $time): int
	{
		$arr = explode(':', $time);
		if (count($arr) === 3) {
			return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
		}
		return $arr[0] * 60 + $arr[1];
	}

	public function acceptance_status($table,$id){
		$accpt_sql = "select entry_date,audit_status,audit_approved_date,agnt_fd_acpt,agent_rvw_date from $table where id = $id";
		$acceptance_data = $this->Common_model->get_query_row_array($accpt_sql);
		$to_time = strtotime($acceptance_data['agent_rvw_date']);
		$from_time = strtotime($acceptance_data['audit_approved_date']);
		$time_diff = round(abs($to_time - $from_time) / 60,2);
		if ($acceptance_data['audit_status']==0) {
			$ac_status = 'Audit not approved';
		}elseif ($time_diff <= 24*60 && $acceptance_data['agnt_fd_acpt'] == 'Accepted') {
			$ac_status = 'Accepted within 24 hours';
		}elseif ($time_diff > 24*60 && $acceptance_data['agnt_fd_acpt'] == 'Accepted') {
			$ac_status = 'Accepted after 24 hours';
		}elseif($acceptance_data['agnt_fd_acpt'] == 'Not Accepted'){
			$ac_status = 'Rebuttal Raised';
		}elseif($acceptance_data['agnt_fd_acpt'] == ''){
			$ac_status = 'Not Accepted';
		}
		return $ac_status;
		//echo $ac_status;die;
	}
	////////// end ///////////
	
/*-------------------------------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------- QA ATA ---------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/
	
	public function qa_ata_audit()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/qa_ata/qa_ata_audit.php";
			$data["content_js"] = "qa_digit_js.php";
			
			$from_date = '';
			$to_date = '';
			
			$process_id = trim($this->input->post('process_id'));
			
			if($process_id!=""){
				
				$qSql="Select count(id) as value from qa_digit_".$process_id."_client_feedback where auditor_id='$current_user'";
				$data["tot_ata"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_digit_".$process_id."_client_feedback where auditor_id='$current_user' and qa_ata_date is Null";
				$data["yet_ata_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			
				if($this->input->get('btnView')=='View')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
						
					if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
					
					$qSql = "SELECT * from
					(Select *, date(entry_date) as ata_date, (select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin sc where sc.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_digit_".$process_id."_client_feedback $cond and auditor_id='$current_user') xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["ata_audit_list"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="SELECT * from
					(Select *, date(entry_date) as ata_date, (select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin sc where sc.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_digit_".$process_id."_client_feedback where auditor_id='$current_user') xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.qa_ata_date is Null";
					$data["ata_audit_list"] = $this->Common_model->get_query_result_array($qSql);			
				}
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["process_id"] = $process_id;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function view_ata_audit($ata_audit_id, $process_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/qa_ata/view_ata_audit.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ata_audit_id']=$ata_audit_id;
			$data['process_id']=$process_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as ata_auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=update_by) as update_name
				from qa_digit_".$process_id."_client_feedback where id='$ata_audit_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["ata_details"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('ata_audit_id'))
			{
				$ata_audit_id=$this->input->post('ata_audit_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"qa_ata_acpt" => $this->input->post('qa_ata_acpt'),
					"qa_ata_note" => $this->input->post('qa_ata_note'),
					"qa_ata_date" => $curDateTime
				);				
				$this->db->where('id', $ata_audit_id);
				$this->db->update('qa_digit_'.$process_id.'_client_feedback',$field_array);
				redirect('Qa_digit/qa_ata_audit');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	public function view_qa_audit($ss_id, $process_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/qa_ata/view_qa_audit.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			$data['process_id']=$process_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_digit_".$process_id."_feedback where id='$ss_id') xx 
				Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["qa_details"] = $this->Common_model->get_query_row_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
///// ATA REPORT

	/*---------Not Complete----------*/
	
	/* public function qa_digit_ata_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_digit/qa_ata/qa_digit_ata_report.php";
			
			if(get_global_access()==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			$cond1="";
			$date_from="";
			$date_to="";
			$office_id="";
			$action="";
			$dn_link="";
			
			$campaign = $this->input->get('campaign');
			
			$data["qa_meesho_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				//if($date_from !="" && $date_to!=="" )  $cond1 =" Where (date(ssc.audit_date)>='$date_from' and date(ssc.audit_date)<='$date_to') ";
		
				if($office_id=="All") $cond1="";
				else $cond1 .=" and S.office_id='$office_id'";	
				
				if($campaign=="supplier_support"){
					$qSql="Select ssc.ss_id, ssc.auditor_id, ssc.audit_date, ssc.agent_id, ssc.tl_id, ssc.entry_by, ssc.entry_date as ata_end_time, ssc.audit_start_time,
					ssc.ticket_id, ssc.order_id, ssc.call_date, ssc.overall_score, ssc.opening, ssc.validate_information, ssc.acknowledge, ssc.effective_probing, ssc.accurate_resolution, ssc.manage_delay_grace, ssc.provide_self_help, ssc.use_correct_template, ssc.use_necessary_template, ssc.use_correct_spelling, ssc.crm_accuracy, ssc.closing_statement, ssc.comm1, ssc.comm2, ssc.comm3, ssc.comm4, ssc.comm5, ssc.comm6, ssc.comm7, ssc.comm8, ssc.comm9, ssc.comm10, ssc.comm11, ssc.comm12, date(ssc.entry_date) as ata_entry_date, ssc.qa_ata_acpt, ssc.qa_ata_note, date(ssc.qa_ata_date) as ata_acpt_date,
					
					ss.id, ss.ticket_id as qa_ticket, ss.order_id as qa_order, ss.call_date as qa_calldate, ss.overall_score as qa_score, ss.opening as qa_opening, ss.validate_information as qa_validate, ss.acknowledge as qa_acknow, ss.effective_probing qa_effect, ss.accurate_resolution as qa_accurate, ss.manage_delay_grace as qa_manage, ss.provide_self_help as qa_provide, ss.use_correct_template as qa_correct, ss.use_necessary_template as qa_necessary, ss.use_correct_spelling as qa_spelling, ss.crm_accuracy as qa_crm, ss.closing_statement as qa_close, ss.comm1 as qa_cmt1, ss.comm2 as qa_cmt2, ss.comm3 as qa_cmt3, ss.comm4 as qa_cmt4, ss.comm5 as qa_cmt5, ss.comm6 as qa_cmt6, ss.comm7 as qa_cmt7, ss.comm8 as qa_cmt8, ss.comm9 as qa_cmt9, ss.comm10 as qa_cmt10, ss.comm11 as qa_cmt11, ss.comm12 as qa_cmt12, date(ss.entry_date) as qa_entry_date,
					
					S.fusion_id, S.xpoid, concat(S.fname, ' ', S.lname) as agent_name, S.office_id, concat(SE.fname, ' ', SE.lname) as ata_auditor_name, concat(SA.fname, ' ', SA.lname) as auditor_name, concat(SAS.fname, ' ', SAS.lname) as tl_name From
					qa_meesho_supplier_support_client_feedback ssc Left Join qa_meesho_supplier_support_feedback ss On ssc.ss_id=ss.id
					Left Join signin S On S.id=ssc.agent_id
					Left Join signin SE On SE.id=ssc.entry_by 
					Left Join signin SA On SA.id=ssc.auditor_id 
					Left Join signin SAS On SAS.id=ssc.tl_id  Where (date(ssc.audit_date)>='$date_from' and date(ssc.audit_date)<='$date_to') $cond1 order by ssc.audit_date ";
				}
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_meesho_list"] = $fullAray;
				$this->create_qa_meesho_ata_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_meesho/download_qa_meesho_ata_CSV/".$campaign;
				
			}
			
			$data['download_link'] = $dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id'] = $office_id;
			$data['campaign'] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function download_qa_meesho_ata_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Meesho ".$campaign." ATA List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_meesho_ata_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=="supplier_support"){
			$header = array("QA Name", "ATA Name", "Agent Name", "Employee ID", "TL Name", "Email Date/Time", "Ticket ID", "Order ID", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Q1 Opening /Personalization(5) - ATA", "ATA Comment1", "Q2 Validation of customer information(5) - ATA", "ATA Commen2", "Q3 Acknowledge Align & Assure(5) - ATA", "ATA Comment3", "Q4 Effective Probing(5) - ATA", "ATA Comment4", "Q5 Accurate Resolution(F)(10) - ATA", "ATA Comment5", "Q6 Managed delays with grace(5) - ATA", "ATA Comment6", "Q7 Additional information provided/ Self help(10) - ATA", "ATA Comment7", "Q8 Used templates correctly(F)(10) - ATA", "ATA Comment8", "Q9 Used necessary customization of Templates(F)(15) - ATA", "ATA Comment9", "Q10 Use correct spelling grammar and punctuation(15) - ATA", "ATA Comment10", "Q11 CRM accuracy(F)(10) - ATA", "ATA Comment11", "Q12 Closing Statement & Further help(5) - ATA", "ATA Comment12", "ATA Score", "ATA Entry Date", 
			"Q1 - Opening /Personalization(5)", "QA Comment1", "Q2 - Validation of customer information(5)", "QA Comment2", "Q3 - Acknowledge Align & Assure(5)", "QA Comment3", "Q4 - Effective Probing(5)", "QA Comment4", "Q5 - Accurate Resolution(F)(10)", "QA Comment5", "Q6 - Managed delays with grace(5)", "QA Comment6", "Q7 - Additional information provided/ Self help(10)", "QA Comment7", "Q8 - Used templates correctly(F)(10)", "QA Comment8", "Q9 - Used necessary customization of Templates(F)(15)", "QA Comment9", "Q10 - Use correct spelling grammar and punctuation(15)", "QA Comment10", "Q11 - CRM accuracy(F)(10)", "QA Comment11", "Q12 - Closing Statement & Further help(5)", "QA Comment12", "QA Score", "Auditor Entry Date", "ATA Variance(out of 12 parameters)", "ATA Variance Percentage", "ATA Feedback Acceptance Status", "Acceptance Date", "Acceptance Feedback");
		}else if($campaign=="chat"){
			$header = array("QA Name", "ATA Name", "Agent Name", "Employee ID", "TL Name", "Email Date/Time", "Ticket ID", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", 
			"Q1 Professional greeting - ATA", "ATA Comment1", "Q2 Acknowledgement - ATA", "ATA Commen2", "Q3 Effective probing - ATA", "ATA Comment3", "Q4 Communication Skills & Soft skills - ATA", "ATA Comment4", "Q5 Manage delays with grace - ATA", "ATA Comment5", "Q6 Complete and accurate resolution as per SOP - ATA", "ATA Comment6", "Q7 Documentation & Resource Management - ATA", "ATA Comment7", "Q8 Chat control and Script adherence - ATA", "ATA Comment8", "Q9 Zero Tolerance - ATA", "ATA Comment9", "Q10 Closing Salutation - ATA", "ATA Comment10", "ATA Score", "ATA Entry Date", 
			"Q1 - Professional greeting(8)", "Q1- Remarks", "Q2 - Acknowledgement(8)", "Q2- Reamarks", "Q3 - Effective probing(15)", "Q3- Remarks", "Q4 - Communication Skills & Soft skills(5)", "Q4- Remarks", "Q5 - Manage delays with grace(8)", "Q5- Remarks", "Q6 - Complete and accurate resolution as per SOP(F)(15)", "Q6- Remarks", "Q7 - Documentation & Resource Management(F)(15)", "Q7- Remarks", "Q8 - Chat control and Script adherence(8)", "Q8- Remarks", "Q9 - Zero Tolerance(10)", "Q9- Remarks", "Q10 - Closing Salutation(8)", "Q10- Remarks", "QA Score", "Auditor Entry Date", "ATA Variance(out of 12 parameters)", "ATA Variance Percentage", "ATA Feedback Acceptance Status", "Acceptance Date", "Acceptance Feedback");
		}else if($campaign=="cmb"){
			$header = array("QA Name", "ATA Name", "Agent Name", "Employee ID", "TL Name", "Email Date/Time", "Ticket ID", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", 
			"Q1 Call Opening - ATA", "ATA Comment1", "Q2 Security check - ATA", "ATA Commen2", "Q3 Hold Procedure - ATA", "ATA Comment3", "Q4 Closing Script - ATA", "ATA Comment4", "Q5 Active Listening - ATA", "ATA Comment5", "Q6 Effective Probing - ATA", "ATA Comment6", "Q7 Accurate Resolution as per the SOP(F) - ATA", "ATA Comment7", "Q8 Professionalism - ATA", "ATA Comment8", "Q9 Apology/Empathy - ATA", "ATA Comment9", "Q10 Politeness & Courtesy(F) - ATA", "ATA Comment10", "Q11 CRM accuracy(F) - ATA", "ATA Comment11", "Q12 Captured Order ID in Genesys (F) - ATA", "ATA Comment12", "ATA Score", "ATA Entry Date", 
			"Q1 - Call Opening(5)", "Q1- Remarks", "Q2 - Security check(10)", "Q2- Reamarks", "Q3 - Hold Procedure(10)", "Q3- Remarks", "Q4 - Closing Script(5)", "Q4- Remarks", "Q5 - Active Listening(5)", "Q5- Remarks", "Q6 - Effective Probing(5)", "Q6- Remarks", "Q7 - Accurate Resolution as per the SOP(F)(20)", "Q7- Remarks", "Q8 - Professionalism(10)", "Q8- Remarks", "Q9 - Apology/Empathy(5)", "Q9- Remarks", "Q10 - Politeness & Courtesy(F)(10)", "Q10- Remarks", "Q11 - CRM accuracy(F)(10)", "Q11- Remarks", "Q12 - Captured Order ID in Genesys(F)(5)", "Q12- Remarks", "QA Score", "Auditor Entry Date", "ATA Variance(out of 12 parameters)", "ATA Variance Percentage", "ATA Feedback Acceptance Status", "Acceptance Date", "Acceptance Feedback");
		}else if($campaign=="inbound"){
			$header = array("QA Name", "ATA Name", "Agent Name", "Employee ID", "TL Name", "Email Date/Time", "Ticket ID", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", 
			"Q1 Call Opening - ATA", "ATA Comment1", "Q2 Security check - ATA", "ATA Commen2", "Q3 Hold Procedure - ATA", "ATA Comment3", "Q4 Closing Script - ATA", "ATA Comment4", "Q5 Active Listening - ATA", "ATA Comment5", "Q6 Effective Probing - ATA", "ATA Comment6", "Q7 Accurate Resolution as per the SOP(F) - ATA", "ATA Comment7", "Q8 Professionalism - ATA", "ATA Comment8", "Q9 Apology/Empathy - ATA", "ATA Comment9", "Q10 Politeness & Courtesy(F) - ATA", "ATA Comment10", "Q11 CRM accuracy(F) - ATA", "ATA Comment11", "Q12 Captured Order ID in Genesys (F) - ATA", "ATA Comment12", "ATA Score", "ATA Entry Date", 
			"Q1 - Call Opening(5)", "Q1- Remarks", "Q2 - Security check(10)", "Q2- Reamarks", "Q3 - Hold Procedure(10)", "Q3- Remarks", "Q4 - Closing Script(5)", "Q4- Remarks", "Q5 - Active Listening(5)", "Q5- Remarks", "Q6 - Effective Probing(5)", "Q6- Remarks", "Q7 - Accurate Resolution as per the SOP(F)(20)", "Q7- Remarks", "Q8 - Professionalism(10)", "Q8- Remarks", "Q9 - Apology/Empathy(5)", "Q9- Remarks", "Q10 - Politeness & Courtesy(F)(10)", "Q10- Remarks", "Q11 - CRM accuracy(F)(10)", "Q11- Remarks", "Q12 - Captured Order ID in Genesys(F)(5)", "Q12- Remarks", "QA Score", "Auditor Entry Date", "ATA Variance(out of 12 parameters)", "ATA Variance Percentage", "ATA Feedback Acceptance Status", "Acceptance Date", "Acceptance Feedback");
		}else if($campaign=="email"){
			$header = array("QA Name", "ATA Name", "Agent Name", "Employee ID", "TL Name", "Email Date/Time", "Ticket ID", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", 
			"Q1 Opening /Personalization - ATA", "ATA Comment1", "Q2 Understanding the Issue and Probing accordingly(F) - ATA", "ATA Commen2", "Q3 Was agent able to provide an appropriate resolution to the user by addressing all the queries and validation(F) - ATA", "ATA Comment3", "Q4 Appropriate macro / Customization done according to the query(F) - ATA", "ATA Comment4", "Q5 Sentence Construction Punctuation Paraphrase Manage delay wherever required - ATA", "ATA Comment5", "Q6 Out calling process adhered with documentation(F) - ATA", "ATA Comment6", "Q7 CRM accuracy(F) - ATA", "ATA Comment7", "Q8 Closing Statement - ATA", "ATA Comment8", "Q9 Validation of previous threads(F) - ATA", "ATA Comment9", "Q10 Critical process Adherence(ZTP) - ATA", "ATA Comment10", "ATA Score", "ATA Entry Date", 
			"Q1 - Opening /Personalization(5)", "Q1- Remarks", "Q2 - Understanding the Issue and Probing accordingly(F)(10)", "Q2- Reamarks", "Q3 - Was agent able to provide an appropriate resolution to the user by addressing all the queries and validation(F)(20)", "Q3- Remarks", "Q4 - Appropriate macro/customization done according to the query(F)(10)", "Q4- Remarks", "Q5 - Sentence Construction Punctuation Paraphrase Manage delay wherever required(5)", "Q5- Remarks", "Q6 - Out calling process adhered with documentation(F)(5)", "Q6- Remarks", "Q7 - CRM accuracy(F)(20)", "Q7- Remarks", "Q8 - Closing Statement(5)", "Q8- Remarks", "Q9 - Validation of previous threads(F)(10)", "Q9- Remarks", "Q10 - Critical process Adherence(ZTP)(10)", "Q10- Remarks", "QA Score", "Auditor Entry Date", "ATA Variance(out of 12 parameters)", "ATA Variance Percentage", "ATA Feedback Acceptance Status", "Acceptance Date", "Acceptance Feedback");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		
		if($campaign=="supplier_support"){
			
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['ata_end_time']) - strtotime($user['audit_start_time']);
				}
				
				if($user['opening']!=$user['qa_opening']) $opening=1;
				else $opening=0;
				if($user['validate_information']!=$user['qa_validate']) $validate=1;
				else $validate=0;
				if($user['acknowledge']!=$user['qa_acknow']) $aknow=1;
				else $aknow=0;
				if($user['effective_probing']!=$user['qa_effect']) $effect=1;
				else $effect=0;
				if($user['accurate_resolution']!=$user['qa_accurate']) $accurt=1;
				else $accurt=0;
				if($user['manage_delay_grace']!=$user['qa_manage']) $manage=1;
				else $manage=0;
				if($user['provide_self_help']!=$user['qa_provide']) $provide=1;
				else $provide=0;
				if($user['use_correct_template']!=$user['qa_correct']) $correct=1;
				else $correct=0;
				if($user['use_necessary_template']!=$user['qa_necessary']) $necessary=1;
				else $necessary=0;
				if($user['use_correct_spelling']!=$user['qa_spelling']) $spelling=1;
				else $spelling=0;
				if($user['crm_accuracy']!=$user['qa_crm']) $crm=1;
				else $crm=0;
				if($user['closing_statement']!=$user['qa_close']) $close=1;
				else $close=0;
				
				$ata_varience = ($opening+$validate+$aknow+$effect+$accurt+$manage+$provide+$correct+$necessary+$spelling+$crm+$close);
				$ata_varience_percentage = round(((($ata_varience)/12)*100),2);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['ata_auditor_name'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['xpoid'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['call_date'].'",'; 
				$row .= '"'.$user['ticket_id'].'",'; 
				$row .= '"'.$user['order_id'].'",'; 
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['ata_end_time'].'",';
				$row .= '"'.$interval1.'",';
				
				$row .= '"'.$user['opening'].'",'; 
				$row .= '"'.$user['comm1'].'",'; 
				$row .= '"'.$user['validate_information'].'",'; 
				$row .= '"'.$user['comm2'].'",'; 
				$row .= '"'.$user['acknowledge'].'",'; 
				$row .= '"'.$user['comm3'].'",'; 
				$row .= '"'.$user['effective_probing'].'",'; 
				$row .= '"'.$user['comm4'].'",'; 
				$row .= '"'.$user['accurate_resolution'].'",'; 
				$row .= '"'.$user['comm5'].'",'; 
				$row .= '"'.$user['manage_delay_grace'].'",'; 
				$row .= '"'.$user['comm6'].'",'; 
				$row .= '"'.$user['provide_self_help'].'",'; 
				$row .= '"'.$user['comm7'].'",'; 
				$row .= '"'.$user['use_correct_template'].'",'; 
				$row .= '"'.$user['comm8'].'",'; 
				$row .= '"'.$user['use_necessary_template'].'",'; 
				$row .= '"'.$user['comm9'].'",'; 
				$row .= '"'.$user['use_correct_spelling'].'",'; 
				$row .= '"'.$user['comm10'].'",'; 
				$row .= '"'.$user['crm_accuracy'].'",'; 
				$row .= '"'.$user['comm11'].'",'; 
				$row .= '"'.$user['closing_statement'].'",'; 
				$row .= '"'.$user['comm12'].'",'; 
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['ata_entry_date'])).'",'; 			
				
				$row .= '"'.$user['qa_opening'].'",'; 
				$row .= '"'.$user['cmt1'].'",'; 
				$row .= '"'.$user['qa_validate'].'",'; 
				$row .= '"'.$user['cmt2'].'",'; 
				$row .= '"'.$user['qa_acknow'].'",'; 
				$row .= '"'.$user['cmt3'].'",'; 
				$row .= '"'.$user['qa_effect'].'",'; 
				$row .= '"'.$user['cmt4'].'",'; 
				$row .= '"'.$user['qa_accurate'].'",'; 
				$row .= '"'.$user['cmt5'].'",'; 
				$row .= '"'.$user['qa_manage'].'",'; 
				$row .= '"'.$user['cmt6'].'",'; 
				$row .= '"'.$user['qa_provide'].'",'; 
				$row .= '"'.$user['cmt7'].'",'; 
				$row .= '"'.$user['qa_correct'].'",'; 
				$row .= '"'.$user['cmt8'].'",'; 
				$row .= '"'.$user['qa_necessary'].'",'; 
				$row .= '"'.$user['cmt9'].'",'; 
				$row .= '"'.$user['qa_spelling'].'",'; 
				$row .= '"'.$user['cmt10'].'",'; 
				$row .= '"'.$user['qa_crm'].'",'; 
				$row .= '"'.$user['cmt11'].'",'; 
				$row .= '"'.$user['qa_close'].'",'; 
				$row .= '"'.$user['cmt12'].'",'; 
				$row .= '"'.$user['qa_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['qa_entry_date'])).'",'; 	
				
				$row .= '"'.$ata_varience.'",'; 
				$row .= '"'.$ata_varience_percentage.'%'.'",';
				
				$row .= '"'.$user['qa_ata_acpt'].'",'; 
				$row .= '"'.$user['ata_acpt_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_ata_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($campaign=="chat"){
			
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['ata_end_time']) - strtotime($user['audit_start_time']);
				}
				
				if($user['ata1']!=$user['qa1']) $opening=1;
				else $opening=0;
				if($user['ata2']!=$user['qa2']) $validate=1;
				else $validate=0;
				if($user['ata3']!=$user['qa3']) $aknow=1;
				else $aknow=0;
				if($user['ata4']!=$user['qa4']) $effect=1;
				else $effect=0;
				if($user['ata5']!=$user['qa5']) $accurt=1;
				else $accurt=0;
				if($user['ata6']!=$user['qa6']) $manage=1;
				else $manage=0;
				if($user['ata7']!=$user['qa7']) $provide=1;
				else $provide=0;
				if($user['ata8']!=$user['qa8']) $correct=1;
				else $correct=0;
				if($user['ata9']!=$user['qa9']) $necessary=1;
				else $necessary=0;
				if($user['ata10']!=$user['qa10']) $spelling=1;
				else $spelling=0;
				
				$ata_varience = ($opening+$validate+$aknow+$effect+$accurt+$manage+$provide+$correct+$necessary+$spelling);
				$ata_varience_percentage = round(((($ata_varience)/10)*100),2);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['ata_auditor_name'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['xpoid'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['call_date'].'",'; 
				$row .= '"'.$user['ticket_id'].'",'; 
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['ata_end_time'].'",';
				$row .= '"'.$interval1.'",';
				
				$row .= '"'.$user['ata1'].'",'; 
				$row .= '"'.$user['comm1'].'",'; 
				$row .= '"'.$user['ata2'].'",'; 
				$row .= '"'.$user['comm2'].'",'; 
				$row .= '"'.$user['ata3'].'",'; 
				$row .= '"'.$user['comm3'].'",'; 
				$row .= '"'.$user['ata4'].'",'; 
				$row .= '"'.$user['comm4'].'",'; 
				$row .= '"'.$user['ata5'].'",'; 
				$row .= '"'.$user['comm5'].'",'; 
				$row .= '"'.$user['ata6'].'",'; 
				$row .= '"'.$user['comm6'].'",'; 
				$row .= '"'.$user['ata7'].'",'; 
				$row .= '"'.$user['comm7'].'",'; 
				$row .= '"'.$user['ata8'].'",'; 
				$row .= '"'.$user['comm8'].'",'; 
				$row .= '"'.$user['ata9'].'",'; 
				$row .= '"'.$user['comm9'].'",'; 
				$row .= '"'.$user['ata10'].'",'; 
				$row .= '"'.$user['comm10'].'",';  
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['ata_entry_date'])).'",'; 			
				
				$row .= '"'.$user['qa1'].'",'; 
				$row .= '"'.$user['cmt1'].'",'; 
				$row .= '"'.$user['qa2'].'",'; 
				$row .= '"'.$user['cmt2'].'",'; 
				$row .= '"'.$user['qa3'].'",'; 
				$row .= '"'.$user['cmt3'].'",'; 
				$row .= '"'.$user['qa4'].'",'; 
				$row .= '"'.$user['cmt4'].'",'; 
				$row .= '"'.$user['qa5'].'",'; 
				$row .= '"'.$user['cmt5'].'",'; 
				$row .= '"'.$user['qa6'].'",'; 
				$row .= '"'.$user['cmt6'].'",'; 
				$row .= '"'.$user['qa7'].'",'; 
				$row .= '"'.$user['cmt7'].'",'; 
				$row .= '"'.$user['qa8'].'",'; 
				$row .= '"'.$user['cmt8'].'",'; 
				$row .= '"'.$user['qa9'].'",'; 
				$row .= '"'.$user['cmt9'].'",'; 
				$row .= '"'.$user['qa10'].'",'; 
				$row .= '"'.$user['cmt10'].'",'; 
				$row .= '"'.$user['qa_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['qa_entry_date'])).'",'; 	
				
				$row .= '"'.$ata_varience.'",'; 
				$row .= '"'.$ata_varience_percentage.'%'.'",';
				
				$row .= '"'.$user['qa_ata_acpt'].'",'; 
				$row .= '"'.$user['ata_acpt_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_ata_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($campaign=="cmb"){
			
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['ata_end_time']) - strtotime($user['audit_start_time']);
				}
				
				if($user['ata1']!=$user['qa1']) $opening=1;
				else $opening=0;
				if($user['ata2']!=$user['qa2']) $validate=1;
				else $validate=0;
				if($user['ata3']!=$user['qa3']) $aknow=1;
				else $aknow=0;
				if($user['ata4']!=$user['qa4']) $effect=1;
				else $effect=0;
				if($user['ata5']!=$user['qa5']) $accurt=1;
				else $accurt=0;
				if($user['ata6']!=$user['qa6']) $manage=1;
				else $manage=0;
				if($user['ata7']!=$user['qa7']) $provide=1;
				else $provide=0;
				if($user['ata8']!=$user['qa8']) $correct=1;
				else $correct=0;
				if($user['ata9']!=$user['qa9']) $necessary=1;
				else $necessary=0;
				if($user['ata10']!=$user['qa10']) $spelling=1;
				else $spelling=0;
				if($user['ata11']!=$user['qa11']) $crm=1;
				else $crm=0;
				if($user['ata12']!=$user['qa12']) $close=1;
				else $close=0;
				
				$ata_varience = ($opening+$validate+$aknow+$effect+$accurt+$manage+$provide+$correct+$necessary+$spelling+$crm+$close);
				$ata_varience_percentage = round(((($ata_varience)/12)*100),2);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['ata_auditor_name'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['xpoid'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['call_date'].'",'; 
				$row .= '"'.$user['ticket_id'].'",'; 
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['ata_end_time'].'",';
				$row .= '"'.$interval1.'",';
				
				$row .= '"'.$user['ata1'].'",'; 
				$row .= '"'.$user['comm1'].'",'; 
				$row .= '"'.$user['ata2'].'",'; 
				$row .= '"'.$user['comm2'].'",'; 
				$row .= '"'.$user['ata3'].'",'; 
				$row .= '"'.$user['comm3'].'",'; 
				$row .= '"'.$user['ata4'].'",'; 
				$row .= '"'.$user['comm4'].'",'; 
				$row .= '"'.$user['ata5'].'",'; 
				$row .= '"'.$user['comm5'].'",'; 
				$row .= '"'.$user['ata6'].'",'; 
				$row .= '"'.$user['comm6'].'",'; 
				$row .= '"'.$user['ata7'].'",'; 
				$row .= '"'.$user['comm7'].'",'; 
				$row .= '"'.$user['ata8'].'",'; 
				$row .= '"'.$user['comm8'].'",'; 
				$row .= '"'.$user['ata9'].'",'; 
				$row .= '"'.$user['comm9'].'",'; 
				$row .= '"'.$user['ata10'].'",'; 
				$row .= '"'.$user['comm10'].'",';  
				$row .= '"'.$user['ata11'].'",'; 
				$row .= '"'.$user['comm11'].'",';  
				$row .= '"'.$user['ata12'].'",'; 
				$row .= '"'.$user['comm12'].'",';  
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['ata_entry_date'])).'",'; 			
				
				$row .= '"'.$user['qa1'].'",'; 
				$row .= '"'.$user['cmt1'].'",'; 
				$row .= '"'.$user['qa2'].'",'; 
				$row .= '"'.$user['cmt2'].'",'; 
				$row .= '"'.$user['qa3'].'",'; 
				$row .= '"'.$user['cmt3'].'",'; 
				$row .= '"'.$user['qa4'].'",'; 
				$row .= '"'.$user['cmt4'].'",'; 
				$row .= '"'.$user['qa5'].'",'; 
				$row .= '"'.$user['cmt5'].'",'; 
				$row .= '"'.$user['qa6'].'",'; 
				$row .= '"'.$user['cmt6'].'",'; 
				$row .= '"'.$user['qa7'].'",'; 
				$row .= '"'.$user['cmt7'].'",'; 
				$row .= '"'.$user['qa8'].'",'; 
				$row .= '"'.$user['cmt8'].'",'; 
				$row .= '"'.$user['qa9'].'",'; 
				$row .= '"'.$user['cmt9'].'",'; 
				$row .= '"'.$user['qa10'].'",'; 
				$row .= '"'.$user['cmt10'].'",'; 
				$row .= '"'.$user['qa11'].'",'; 
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['qa12'].'",'; 
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['qa_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['qa_entry_date'])).'",'; 	
				
				$row .= '"'.$ata_varience.'",'; 
				$row .= '"'.$ata_varience_percentage.'%'.'",';
				
				$row .= '"'.$user['qa_ata_acpt'].'",'; 
				$row .= '"'.$user['ata_acpt_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_ata_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($campaign=="inbound"){
			
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['ata_end_time']) - strtotime($user['audit_start_time']);
				}
				
				if($user['ata1']!=$user['qa1']) $opening=1;
				else $opening=0;
				if($user['ata2']!=$user['qa2']) $validate=1;
				else $validate=0;
				if($user['ata3']!=$user['qa3']) $aknow=1;
				else $aknow=0;
				if($user['ata4']!=$user['qa4']) $effect=1;
				else $effect=0;
				if($user['ata5']!=$user['qa5']) $accurt=1;
				else $accurt=0;
				if($user['ata6']!=$user['qa6']) $manage=1;
				else $manage=0;
				if($user['ata7']!=$user['qa7']) $provide=1;
				else $provide=0;
				if($user['ata8']!=$user['qa8']) $correct=1;
				else $correct=0;
				if($user['ata9']!=$user['qa9']) $necessary=1;
				else $necessary=0;
				if($user['ata10']!=$user['qa10']) $spelling=1;
				else $spelling=0;
				if($user['ata11']!=$user['qa11']) $crm=1;
				else $crm=0;
				if($user['ata12']!=$user['qa12']) $close=1;
				else $close=0;
				
				$ata_varience = ($opening+$validate+$aknow+$effect+$accurt+$manage+$provide+$correct+$necessary+$spelling+$crm+$close);
				$ata_varience_percentage = round(((($ata_varience)/12)*100),2);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['ata_auditor_name'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['xpoid'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['call_date'].'",'; 
				$row .= '"'.$user['ticket_id'].'",'; 
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['ata_end_time'].'",';
				$row .= '"'.$interval1.'",';
				
				$row .= '"'.$user['ata1'].'",'; 
				$row .= '"'.$user['comm1'].'",'; 
				$row .= '"'.$user['ata2'].'",'; 
				$row .= '"'.$user['comm2'].'",'; 
				$row .= '"'.$user['ata3'].'",'; 
				$row .= '"'.$user['comm3'].'",'; 
				$row .= '"'.$user['ata4'].'",'; 
				$row .= '"'.$user['comm4'].'",'; 
				$row .= '"'.$user['ata5'].'",'; 
				$row .= '"'.$user['comm5'].'",'; 
				$row .= '"'.$user['ata6'].'",'; 
				$row .= '"'.$user['comm6'].'",'; 
				$row .= '"'.$user['ata7'].'",'; 
				$row .= '"'.$user['comm7'].'",'; 
				$row .= '"'.$user['ata8'].'",'; 
				$row .= '"'.$user['comm8'].'",'; 
				$row .= '"'.$user['ata9'].'",'; 
				$row .= '"'.$user['comm9'].'",'; 
				$row .= '"'.$user['ata10'].'",'; 
				$row .= '"'.$user['comm10'].'",';  
				$row .= '"'.$user['ata11'].'",'; 
				$row .= '"'.$user['comm11'].'",';  
				$row .= '"'.$user['ata12'].'",'; 
				$row .= '"'.$user['comm12'].'",';  
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['ata_entry_date'])).'",'; 			
				
				$row .= '"'.$user['qa1'].'",'; 
				$row .= '"'.$user['cmt1'].'",'; 
				$row .= '"'.$user['qa2'].'",'; 
				$row .= '"'.$user['cmt2'].'",'; 
				$row .= '"'.$user['qa3'].'",'; 
				$row .= '"'.$user['cmt3'].'",'; 
				$row .= '"'.$user['qa4'].'",'; 
				$row .= '"'.$user['cmt4'].'",'; 
				$row .= '"'.$user['qa5'].'",'; 
				$row .= '"'.$user['cmt5'].'",'; 
				$row .= '"'.$user['qa6'].'",'; 
				$row .= '"'.$user['cmt6'].'",'; 
				$row .= '"'.$user['qa7'].'",'; 
				$row .= '"'.$user['cmt7'].'",'; 
				$row .= '"'.$user['qa8'].'",'; 
				$row .= '"'.$user['cmt8'].'",'; 
				$row .= '"'.$user['qa9'].'",'; 
				$row .= '"'.$user['cmt9'].'",'; 
				$row .= '"'.$user['qa10'].'",'; 
				$row .= '"'.$user['cmt10'].'",'; 
				$row .= '"'.$user['qa11'].'",'; 
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['qa12'].'",'; 
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['qa_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['qa_entry_date'])).'",'; 	
				
				$row .= '"'.$ata_varience.'",'; 
				$row .= '"'.$ata_varience_percentage.'%'.'",';
				
				$row .= '"'.$user['qa_ata_acpt'].'",'; 
				$row .= '"'.$user['ata_acpt_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_ata_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($campaign=="email"){
			
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['ata_end_time']) - strtotime($user['audit_start_time']);
				}
				
				if($user['ata1']!=$user['qa1']) $opening=1;
				else $opening=0;
				if($user['ata2']!=$user['qa2']) $validate=1;
				else $validate=0;
				if($user['ata3']!=$user['qa3']) $aknow=1;
				else $aknow=0;
				if($user['ata4']!=$user['qa4']) $effect=1;
				else $effect=0;
				if($user['ata5']!=$user['qa5']) $accurt=1;
				else $accurt=0;
				if($user['ata6']!=$user['qa6']) $manage=1;
				else $manage=0;
				if($user['ata7']!=$user['qa7']) $provide=1;
				else $provide=0;
				if($user['ata8']!=$user['qa8']) $correct=1;
				else $correct=0;
				if($user['ata9']!=$user['qa9']) $necessary=1;
				else $necessary=0;
				if($user['ata10']!=$user['qa10']) $spelling=1;
				else $spelling=0;
				
				$ata_varience = ($opening+$validate+$aknow+$effect+$accurt+$manage+$provide+$correct+$necessary+$spelling+$crm+$close);
				$ata_varience_percentage = round(((($ata_varience)/10)*100),2);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['ata_auditor_name'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['xpoid'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['call_date'].'",'; 
				$row .= '"'.$user['ticket_id'].'",'; 
				$row .= '"'.$user['order_id'].'",'; 
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['ata_end_time'].'",';
				$row .= '"'.$interval1.'",';
				
				$row .= '"'.$user['ata1'].'",'; 
				$row .= '"'.$user['comm1'].'",'; 
				$row .= '"'.$user['ata2'].'",'; 
				$row .= '"'.$user['comm2'].'",'; 
				$row .= '"'.$user['ata3'].'",'; 
				$row .= '"'.$user['comm3'].'",'; 
				$row .= '"'.$user['ata4'].'",'; 
				$row .= '"'.$user['comm4'].'",'; 
				$row .= '"'.$user['ata5'].'",'; 
				$row .= '"'.$user['comm5'].'",'; 
				$row .= '"'.$user['ata6'].'",'; 
				$row .= '"'.$user['comm6'].'",'; 
				$row .= '"'.$user['ata7'].'",'; 
				$row .= '"'.$user['comm7'].'",'; 
				$row .= '"'.$user['ata8'].'",'; 
				$row .= '"'.$user['comm8'].'",'; 
				$row .= '"'.$user['ata9'].'",'; 
				$row .= '"'.$user['comm9'].'",'; 
				$row .= '"'.$user['ata10'].'",'; 
				$row .= '"'.$user['comm10'].'",';   
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['ata_entry_date'])).'",'; 			
				
				$row .= '"'.$user['qa1'].'",'; 
				$row .= '"'.$user['cmt1'].'",'; 
				$row .= '"'.$user['qa2'].'",'; 
				$row .= '"'.$user['cmt2'].'",'; 
				$row .= '"'.$user['qa3'].'",'; 
				$row .= '"'.$user['cmt3'].'",'; 
				$row .= '"'.$user['qa4'].'",'; 
				$row .= '"'.$user['cmt4'].'",'; 
				$row .= '"'.$user['qa5'].'",'; 
				$row .= '"'.$user['cmt5'].'",'; 
				$row .= '"'.$user['qa6'].'",'; 
				$row .= '"'.$user['cmt6'].'",'; 
				$row .= '"'.$user['qa7'].'",'; 
				$row .= '"'.$user['cmt7'].'",'; 
				$row .= '"'.$user['qa8'].'",'; 
				$row .= '"'.$user['cmt8'].'",'; 
				$row .= '"'.$user['qa9'].'",'; 
				$row .= '"'.$user['cmt9'].'",'; 
				$row .= '"'.$user['qa10'].'",'; 
				$row .= '"'.$user['cmt10'].'",'; 
				$row .= '"'.$user['qa_score'].'%'.'",'; 
				$row .= '"'.date('Y-m-d', strtotime($user['qa_entry_date'])).'",'; 	
				
				$row .= '"'.$ata_varience.'",'; 
				$row .= '"'.$ata_varience_percentage.'%'.'",';
				
				$row .= '"'.$user['qa_ata_acpt'].'",'; 
				$row .= '"'.$user['ata_acpt_date'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_ata_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		
		
	} */
	
	
/*--------------------------------------------------------------------------------------------------*/
///////////////////////////////////////// QA Create Audio File //////////////////////////////////////
	public function record_audio($ss_id){
		if(check_logged_in()){
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_snapdeal/record_audio.php";
			//$data["js"] = "qa_meesho/record_audio_js.php";
			if ($_SESSION['nonce'] === $_POST['nonce'] && !empty($_FILES['payload'])) {
        		$info = pathinfo($_FILES['payload']['name']);
        		echo $fname = $_FILES['payload']['tmp_name'];die;
        // new file must be less than 10mb
        		if (filesize($fname) < 10 * pow(1024, 2))
            		move_uploaded_file($fname, "./audio.wav");
        			$_SESSION['nonce'] = '';
    }


			$this->load->view('dashboard',$data);
		}
	}
	/* change Audit status */
	public function change_audit_status($audit_status, $audit_id){
		if(check_logged_in()){
			$current_user = get_user_id();
			$curDateTime=CurrMySqlDate();
			//$edit_array=array('audit_status'=>$audit_status);
			$edit_array=array('audit_status'=>$audit_status,'approved_by'=>$current_user,'audit_approved_date'=>$curDateTime);
			$this->db->where('id', $audit_id);
			$this->db->update('qa_digit_sales_feedback',$edit_array);
				if($audit_status==1){ 
					/* Send email to the agent for when audit approve */
					$tablename = "qa_digit_sales_feedback";
					$sql = "SELECT sales.*, ip.email_id_off, ip_tl.email_id_off as tl_email, ip_qa.email_id_off as qa_email, concat(s.fname, ' ', s.lname) as fullname 
							FROM $tablename sales
							LEFT JOIN info_personal ip ON ip.user_id=sales.agent_id 
							LEFT JOIN signin s ON s.id=sales.agent_id
							LEFT JOIN signin tl ON tl.id = sales.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = sales.tl_id
							LEFT JOIN signin sq on s.assigned_qa = sq.id 
							LEFT JOIN info_personal ip_qa on sq.id = ip_qa.user_id
							WHERE sales.id=$audit_id";

					$result= $this->Common_model->get_query_row_array($sql);
					// echo"<br>";
					// echo"<pre>";
					// print_r($result);
					// echo"</pre>";
					// echo"<br>";
					// die();
					$soft_skill_score = $result['soft_skill_score'];
					//echo"<br>";
					$soft_skill_score_per = number_format(($soft_skill_score/25)*100, 2, '.', '');
					//echo"<br>";
					$sale_skill_score = $result['sale_skill_score'];
					//echo"<br>";
					$sale_skill_score_per = number_format(($sale_skill_score/75)*100, 2, '.', '');
					
					$sqlParam ="SELECT params_columns, fatal_param FROM qa_defect where table_name='$tablename'"; 
					$resultParams = $this->Common_model->get_query_row_array($sqlParam);
					
					$params = explode(",", $resultParams['params_columns']);
					$fatal_params = explode(",", $resultParams['fatal_param']);
					
					$msgTable = "<Table BORDER=1>";
					$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH> <TH>QA Rating</TH><TH>QA Remarks</TH></TR>";
					
					$i=1;
					foreach($params as $par){
						//echo $str = str_replace('_', ' ', $par)."<BR>";
						$msgTable .= "<TR><TD>".$i."</TD><TD>". ucwords( str_replace('_', ' ', $par))."</TD><TD>".$result[$par]."</TD><TD>".$result['comm'.$i]."</TD></TR>";
						
						$i++;
					}
					
					//$j=1;
					foreach($fatal_params as $fatal_par){
						$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['comm'.($i-10)]."</TD></TR>";
						
						$i++;
					}

					$msgTable .= "<TR><TD colspan='3'>Soft skill score Percentage</TD> <TD>".$soft_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Sale skill score Percentage</TD> <TD>".$sale_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
					
					$msgTable .= "</Table>";
					$to = $result['email_id_off'];
					//$to = 'vikas.pandey@omindtech.com';
					//$to = 'sumitra.bagchi@omindtech.com';
					$ebody = "Hello ". $result['fullname']."<br><br><br>";
					$ebody .= "<p>As per phone No. ".$result['phone']."</p>";
					$ebody .= "<p>Total Call : ".$result['no_of_call_heard']."</p>";
					$ebody .= "<p>Total Talk time : ".$result['call_duration']."</p>";
					$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
					$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
					$ebody .= "<p>Please listen the call from the QMS Tool and share feedback acceptancy :</p>";
					$ebody .=  $msgTable;
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." New audit happened ";
				
					$ecc[]=$result['tl_email'];
					$ecc[]=$result['qa_email'];
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
				/* End */
				}else if($audit_status==3){
					/* Send email to the auditor for when edit access given */
				$sql = "SELECT entry_by, email_id_off,concat(s.fname, ' ', s.lname) as fullname FROM qa_digit_sales_feedback sales
						LEFT JOIN info_personal ip ON ip.user_id=sales.entry_by 
						LEFT JOIN signin s ON s.id=sales.entry_by
						WHERE sales.id=$audit_id";
				$result= $this->Common_model->get_query_row_array($sql);
				
					$to = $result['email_id_off'];
				//die();
					//exit;
					//$to = 'sumitra.bagchi@omindtech.com';
					$ebody = "Hello ". $result['fullname']."<br><br><br>";
					$ebody .= "<p>Edit permission granted.</p>";
					$ebody .= "<p>Now you can edit your audit.</p>";
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." Edit permission given";
				
					$ecc="";
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
				/* End */
				}
			redirect("qa_digit/sales");
		}
	} 
	public function bulk_change_audit_status(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$curDateTime=CurrMySqlDate();
			$auditArr = $this->input->post('audit_id');
			$arrchk = in_array('Select All', $auditArr);
			if($arrchk == true){
			$firstelement = array_shift($auditArr);
			}
			
			
			if(isset($_POST['edit']) && !empty($_POST['edit']) && $_POST['edit'] == 'edit'){
				$audit_status=3; // Edit access to QA
			}else if(isset($_POST['approve']) && !empty($_POST['approve']) && $_POST['approve'] == 'approve'){
				$audit_status=1; // Approve
			}
		
			//print_r($_POST);
			//echo $audit_status;
			//exit;
			foreach($auditArr as $audit){
				$edit_array=array('audit_status'=>$audit_status,'approved_by'=>$current_user,'audit_approved_date'=>$curDateTime);
				$this->db->where('id', $audit);
				$this->db->update('qa_digit_sales_feedback',$edit_array); 
				if($audit_status==1){
					/* Send email to the agent for when audit approve */
					$tablename = "qa_digit_sales_feedback";
					$sql = "SELECT sales.*, ip.email_id_off, ip_tl.email_id_off as tl_email, ip_qa.email_id_off as qa_email, concat(s.fname, ' ', s.lname) as fullname 
							FROM $tablename sales
							LEFT JOIN info_personal ip ON ip.user_id=sales.agent_id 
							LEFT JOIN signin s ON s.id=sales.agent_id
							LEFT JOIN signin tl ON tl.id = sales.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = sales.tl_id
							LEFT JOIN signin sq on s.assigned_qa = sq.id 
							LEFT JOIN info_personal ip_qa on sq.id = ip_qa.user_id
							WHERE sales.id=$audit";
					$result= $this->Common_model->get_query_row_array($sql);				
					$sqlParam ="SELECT params_columns, fatal_param FROM qa_defect where table_name='$tablename'"; 
					$resultParams = $this->Common_model->get_query_row_array($sqlParam);

					$soft_skill_score = $result['soft_skill_score'];
					//echo"<br>";
					$soft_skill_score_per = number_format(($soft_skill_score/25)*100, 2, '.', '');
					//echo"<br>";
					$sale_skill_score = $result['sale_skill_score'];
					//echo"<br>";
					$sale_skill_score_per = number_format(($sale_skill_score/75)*100, 2, '.', '');
					
					$params = explode(",", $resultParams['params_columns']);
					$fatal_params = explode(",", $resultParams['fatal_param']);
					
					$msgTable = "<Table BORDER=1>";
					$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
					
					$i=1;
					foreach($params as $par){
						//echo $str = str_replace('_', ' ', $par)."<BR>";
						$msgTable .= "<TR><TD>".$i."</TD><TD>". ucwords( str_replace('_', ' ', $par))."</TD> <TD>".$result[$par]."</TD><TD>".$result['comm'.$i]."</TD></TR>";
						
						$i++;
					}
					///////////////////////////
					//$j=1;
					foreach($fatal_params as $fatal_par){
						$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['comm'.($i-10)]."</TD></TR>";
						
						$i++;
					}

					$msgTable .= "<TR><TD colspan='3'>Soft skill score Percentage</TD> <TD>".$soft_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Sale skill score Percentage</TD> <TD>".$sale_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
					
					
					$msgTable .= "</Table>";
					
					//echo $msgTable;
					//exit;
					
					$eccA=array();
					$to = $result['email_id_off'];
					//$to = 'sumitra.bagchi@omindtech.com';
					//$to = 'siltu.koley@omindtech.com';
					$ebody = "Hello ". $result['fullname']."<br>";
					$ebody .= "<p>As per phone No. ".$result['phone']."</p>";
					$ebody .= "<p>Total Call : ".$result['no_of_call_heard']."</p>";
					$ebody .= "<p>Total Talk time : ".$result['call_duration']."</p>";
					$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
					$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
					$ebody .= "<p>Please listen the call from the QMS Tool and share feedback acceptancy :</p>";
					$ebody .=  $msgTable;
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." New audit happened ";
					
					//echo $ebody;
					//exit;
				
					$eccA[]=$result['tl_email'];
					$eccA[]=$result['qa_email'];
					$ecc = implode(',',$eccA);
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
					unset($eccA);
				/* End */
				}else if($audit_status==3){
					$sql = "SELECT entry_by, email_id_off,concat(s.fname, ' ', s.lname) as fullname FROM qa_digit_sales_feedback sales
						LEFT JOIN info_personal ip ON ip.user_id=sales.entry_by 
						LEFT JOIN signin s ON s.id=sales.entry_by
						WHERE sales.id=$audit";
					$result= $this->Common_model->get_query_row_array($sql);
				
					$to = $result['email_id_off'];
					$ebody = "Hello ". $result['fullname']."<br>";
					$ebody .= "<p>You have been given audit permission. </p>";
					$ebody .= "<p>Now you can edit your audit. </p><br><br>";
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." Edit permission given ";
				
					$ecc="";
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
				}
			}
			redirect("qa_digit/sales");
		}
	} 
	/* End */
	public function request_edit_permission($audit){
	 if(check_logged_in()){
		    $audit_status =2;
			$edit_array=array('audit_status'=>$audit_status);
			$this->db->where('id', $audit);
			$this->db->update('qa_digit_sales_feedback',$edit_array); 
			redirect("qa_digit/sales");
	 }
	}
	
	
	/////////////////////////////// Welcome //////////////////////////////
	public function posp($process){
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/call/welcome/qa_posp_feedback.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['process']=$process;

			$table_sql = "select table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			$sheet_name = substr($tablename, 14, -9);
			$data['p_name']=$sheet_name;
			$data["table"] = $tablename;
			//$data["content_template"] = "qa_digit/call/".$sheet_name."/qa_".$sheet_name."_feedback.php";
			//echo $data["content_template"];die;
			
			if(((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='operations') || get_dept_folder()=='training'){
				$data["rebuttal"]='';
			}else{
				if(get_global_access()=='1'){
					$rebuttalSql="Select count(id) as value from $tablename where agnt_fd_acpt='Not Accepted'";
				}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from $tablename where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
				}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from $tablename where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
				}
				$data["rebuttal"]=$this->Common_model->get_single_value($rebuttalSql);
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from $tablename group by entry_by";
			$data["qaName"] = $this->Common_model->get_query_result_array($qaSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$qa_id = $this->input->get('qa_id');
			$cond="";
			$atacond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($qa_id !="")	$cond .=" and entry_by='$qa_id'";
			
			if(get_global_access()=='1'){
				$ops_cond="where 1";
			}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user') or entry_by='$current_user')";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' or entry_by='$current_user')";
			}else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
				$ops_cond=" Where entry_by='$current_user'";
			}else{
				$ops_cond="where 1";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from $tablename $cond) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				$ops_cond order by audit_date";
			$data["posp_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["qa_id"] = $qa_id;
			
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_posp($ss_id,$process){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$table_sql = "select id,process_id,table_name,ata_table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			$ata_tablename = $table_data['ata_table_name'];
			$pip_process_id = $table_data['process_id'];
			$sheet_name = substr($tablename, 14, -9);
			if (strpos($ss_id, 'optr') !== false) {
				$ss_id = filter_var($ss_id, FILTER_SANITIZE_NUMBER_INT);
				$data["content_template"] = "qa_digit/sales/review_audit_sales.php";
				$data["content_template"] = "qa_digit/call/".$sheet_name."/review_audit_".$sheet_name.".php";
			}else{
				$data["content_template"] = "qa_digit/call/".$sheet_name."/add_edit_".$sheet_name.".php";
			}
			
			// $get_tbl_lob_sql = "select id from campaign where qa_defect_id = $process";
			// $get_tbl_lob_data = $this->Common_model->get_query_result_array($get_tbl_lob_sql);
			// $agnt_lob = implode("','", $get_tbl_lob_data['id']);
			// print_r($agnt_lob);die;

			$data["aside_template"] = "qa/aside.php";
			//$data["content_template"] = "qa_digit/call/welcome/add_edit_welcome.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			$data['process']=$process;
			
			$qSql="Select office_name as value from office_location where abbr='$user_office_id'";
			$data["auditorLocation"] =  $this->Common_model->get_single_value($qSql);
			
			//$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1') and status=1 AND assigned_campaign in (select id from campaign where qa_defect_id = $process) AND (is_pip_nominated=0 OR is_pip_nominated='' OR is_pip_nominated IS NULL) order by name";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder in ('agent','support')) and dept_id=6 and is_assign_process(id,'1') and status=1 AND assigned_campaign in (select id from campaign where qa_defect_id = $process) AND (is_pip_nominated=0 OR is_pip_nominated='' OR is_pip_nominated IS NULL) order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */
			
			/* $qSql = "SELECT * FROM qa_meesho_ss_dispo_list where status=1";
			$data['l2_dispo'] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as auditor_center,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sqmr where sqmr.id=qa_mgnt_rebuttal_by) as qa_mgnt_rebuttal_name
				from $tablename where id='$ss_id') xx 
				Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)
				Left Join (select ss_id as ata_audit_id from $ata_tablename) zz On (xx.id=zz.ata_audit_id)";
			$data["posp"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			$b = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ss_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['overall_score']=$this->input->post('overall_score');

					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->digit_upload_files($_FILES['attach_file'], $path='./qa_files/qa_digit/call/'.$sheet_name);
						$field_array['attach_file'] = implode(',',$a);
					}
					
					if($_FILES['attach_img_file']['tmp_name'][0]!=''){
						$b = $this->digit_upload_image_files($_FILES['attach_img_file'], $path='./qa_files/qa_digit/call/'.$sheet_name.'/images/');
						$field_array['attach_img_file'] = implode(',',$b);
					}
					
					$rowid= data_inserter($tablename,$field_array);
					//print_r($this->db->last_query());die;
				////////////////////////
					if($this->input->post('overall_score')=='100%'){
						$agnt_acpt_array = array(
							"agnt_fd_acpt" => 'Accepted',
							"agent_rvw_date" => $curDateTime,
							"agent_rvw_note" => 'Auto Accepted because Overall Score is 100'
						);
						$this->db->where('id', $rowid);
						$this->db->update($tablename,$agnt_acpt_array);

					}
					//Check Agent's PIP Eligibility
					if(!in_array($field_array['audit_type'], array("OJT", "Certificate Audit", "Calibration", "Pre-Certificate Mock Call"))){
						$defect_params = getPip_EligibilityCheck($field_array, $field_array['agent_id'], $pip_process_id);
						if(count($defect_params) > 0){
							if(isPIPApproved($field_array['agent_id']) == "Not Approved"){
								//Nominate Agent for PIP
								$nominate_data = array(
									"user_id"=>$field_array['agent_id'],
									"process_id"=>$pip_process_id,
									"nomination_date"=>date("Y-m-d H:i:s"),
									"affected_parameters"=>implode(",", $defect_params)
								);
								$this->db->insert("pip_nomination", $nominate_data);
								//Disable Agent for further Audits
								$disable_data = array("is_pip_nominated"=>1);
								$this->db->where("id", $field_array['agent_id']);
								$this->db->set($disable_data);
								$this->db->update("signin");
							}
						}
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array1['overall_score']=$this->input->post('overall_score');
					if($this->input->post('audit_status')==3){ 
						$field_array1['audit_status']=0;
						/* After edit if audio is uploaded */
						if($_FILES['attach_file']['tmp_name'][0]!=''){
							$a = $this->digit_upload_files($_FILES['attach_file'], $path='./qa_files/qa_digit/call/'.$sheet_name);
							$field_array1['attach_file'] = implode(',',$a);
						}
						/* End */
					} 
					$this->db->where('id', $ss_id);
					$this->db->update($tablename,$field_array1);
				/////////////
					if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
						if($this->input->post('qa_rebuttal')){
							$edit_array = array(
								"qa_rebuttal_by" => $current_user,
								"qa_rebuttal" => $this->input->post('qa_rebuttal'),
								"qa_rebuttal_comment" => $this->input->post('qa_rebuttal_comment'),
								"qa_rebuttal_date" => $curDateTime
							);
						}
					}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
						if($this->input->post('qa_mgnt_rebuttal')){
							$edit_array = array(
								"qa_mgnt_rebuttal_by" => $current_user,
								"qa_mgnt_rebuttal" => $this->input->post('qa_mgnt_rebuttal'),
								"qa_mgnt_rebuttal_comment" => $this->input->post('qa_mgnt_rebuttal_comment'),
								"qa_mgnt_rebuttal_date" => $curDateTime
							);
						}
					}else if(get_dept_folder()!='qa'){
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_acpt_fd" => $this->input->post('mgnt_acpt_fd'),
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					if(isset($edit_array) && !empty($edit_array)){
					$this->db->where('id', $ss_id);
					$this->db->update($tablename,$edit_array);
					}
					//Check Agent's PIP Eligibility
					if(!in_array($field_array1['audit_type'], array("OJT", "Certificate Audit", "Calibration", "Pre-Certificate Mock Call"))){
						$defect_params = getPip_EligibilityCheck($field_array1, $field_array1['agent_id'], $pip_process_id);
						if(count($defect_params) > 0){
							if(isPIPApproved($field_array1['agent_id']) == "Not Approved"){
								//Nominate Agent for PIP
								$nominate_data = array(
									"user_id"=>$field_array1['agent_id'],
									"process_id"=>$pip_process_id,
									"nomination_date"=>date("Y-m-d H:i:s"),
									"affected_parameters"=>implode(",", $defect_params)
								);
								$this->db->insert("pip_nomination", $nominate_data);
								//Disable Agent for further Audits
								$disable_data = array("is_pip_nominated"=>1);
								$this->db->where("id", $field_array1['agent_id']);
								$this->db->set($disable_data);
								$this->db->update("signin");
							}
						}
					}
					
				}
				redirect('Qa_digit/posp/'.$process);
			}
			$data["array"] = $a;
			$data["array"] = $b;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_posp_client($ss_id,$ata_edit,$process){
		if(check_logged_in())
		{
			
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['prev_url'] = $_SERVER['HTTP_REFERER'];

			$data["aside_template"] = "qa/aside.php";
			//$data["content_template"] = "qa_digit/call/welcome/add_edit_welcome_client.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['ss_id']=$ss_id;
			$data['ata_edit']=$ata_edit;
			$data['process']=$process;

			$table_sql = "select table_name,ata_table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			$ata_tablename = $table_data['ata_table_name'];
			$sheet_name = substr($tablename, 14, -9);
			$data["content_template"] = "qa_digit/call/".$sheet_name."/add_edit_".$sheet_name."_client.php";
			
			/* $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 AND id NOT IN (SELECT employee_id FROM employee_pip WHERE status NOT IN ('S','X')) order by name"; */
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM qa_meesho_ss_dispo_list where status=1";
			$data['l2_dispo'] = $this->Common_model->get_query_result_array($qSql); */
			
			if($ata_edit==0){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
					from $tablename where id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}else if($ata_edit==1){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=update_by) as update_name
					from $ata_tablename where ss_id='$ss_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}
			$data["posp"] = $this->Common_model->get_query_row_array($clientSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			//var_dump($_POST['data']['agent_id']);die;
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ata_edit==0){
					
					$field_array=$this->input->post('data');
					$field_array['ss_id']=$this->input->post('ss_id');
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['auditor_id']=$this->input->post('auditor_id');
					//$field_array['ticket_id']=$this->input->post('ticket_id');
					$field_array['audit_date']=mmddyy2mysql($this->input->post('audit_date'));
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					//$a = $this->snapdeal_upload_files($_FILES['attach_file'],$path='./qa_files/qa_meesho/supplier_support/');
					//$field_array['attach_file'] = implode(',',$a);
					$rowid= data_inserter($ata_tablename,$field_array);
					//echo $this->db->last_query();die;
				///////////
					$ata_array = array("ata_edit" => 1);
					$this->db->where('id', $ss_id);
					$this->db->update($tablename,$ata_array);
				
				}else if($ata_edit==1){
					
					$field_array1=$this->input->post('data');
					$field_array1['update_by']=$current_user;
					$field_array1['update_date']=$curDateTime;
					$field_array1['update_note']=$this->input->post('note');
					$this->db->where('ss_id', $ss_id);
					$this->db->update($ata_tablename,$field_array1);
					
				}
				$prev_url = $this->input->post('prev_url');
				redirect($prev_url);
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	/* change Audit status  call*/
	public function change_audit_status_call($audit_status, $audit_id,$process){
		if(check_logged_in()){
			$current_user = get_user_id();
			$curDateTime=CurrMySqlDate();
			$table_sql = "select table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			//echo $tablename;die;
			//$edit_array=array('audit_status'=>$audit_status);
			$edit_array=array('audit_status'=>$audit_status,'approved_by'=>$current_user,'audit_approved_date'=>$curDateTime);
			$this->db->where('id', $audit_id);
			$this->db->update($tablename,$edit_array);
				if($audit_status==1){ 
					/* Send email to the agent for when audit approve */
					//$tablename = "qa_digit_sales_feedback";
					$sql = "SELECT sales.*, ip.email_id_off, ip_tl.email_id_off as tl_email, ip_qa.email_id_off as qa_email, concat(s.fname, ' ', s.lname) as fullname 
							FROM $tablename sales
							LEFT JOIN info_personal ip ON ip.user_id=sales.agent_id 
							LEFT JOIN signin s ON s.id=sales.agent_id
							LEFT JOIN signin tl ON tl.id = sales.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = sales.tl_id
							LEFT JOIN signin sq on s.assigned_qa = sq.id 
							LEFT JOIN info_personal ip_qa on sq.id = ip_qa.user_id
							WHERE sales.id=$audit_id";

					$result= $this->Common_model->get_query_row_array($sql);
					// echo"<br>";
					// echo"<pre>";
					// print_r($result);
					// echo"</pre>";
					// echo"<br>";
					// die();
					$soft_skill_score = $result['soft_skill_score'];
					//echo"<br>";
					$soft_skill_score_per = number_format(($soft_skill_score/25)*100, 2, '.', '');
					//echo"<br>";
					$sale_skill_score = $result['sale_skill_score'];
					//echo"<br>";
					$sale_skill_score_per = number_format(($sale_skill_score/75)*100, 2, '.', '');
					
					$sqlParam ="SELECT params_columns, fatal_param FROM qa_defect where table_name='$tablename'"; 
					$resultParams = $this->Common_model->get_query_row_array($sqlParam);
					
					$params = explode(",", $resultParams['params_columns']);
					$fatal_params = explode(",", $resultParams['fatal_param']);
					
					$msgTable = "<Table BORDER=1>";
					$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH> <TH>QA Rating</TH><TH>QA Remarks</TH></TR>";
					
					$i=1;
					foreach($params as $par){
						//echo $str = str_replace('_', ' ', $par)."<BR>";
						$msgTable .= "<TR><TD>".$i."</TD><TD>". ucwords( str_replace('_', ' ', $par))."</TD><TD>".$result[$par]."</TD><TD>".$result['comm'.$i]."</TD></TR>";
						
						$i++;
					}
					
					//$j=1;
					foreach($fatal_params as $fatal_par){
						$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['comm'.($i-10)]."</TD></TR>";
						
						$i++;
					}

					$msgTable .= "<TR><TD colspan='3'>Soft skill score Percentage</TD> <TD>".$soft_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Sale skill score Percentage</TD> <TD>".$sale_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
					
					$msgTable .= "</Table>";
					
					$eccA=array();
					$to = $result['email_id_off'];
					
					//$to = 'sumitra.bagchi@omindtech.com';
					$ebody = "Hello ". $result['fullname']."<br><br><br>";
					$ebody .= "<p>As per phone No. ".$result['phone']."</p>";
					$ebody .= "<p>Total Call : ".$result['no_of_call_heard']."</p>";
					$ebody .= "<p>Total Talk time : ".$result['call_duration']."</p>";
					$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
					$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
					$ebody .= "<p>Please listen the call from the QMS Tool and share feedback acceptancy :</p>";
					$ebody .=  $msgTable;
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." New audit happened ";
				
					$eccA[]=$result['tl_email'];
					$eccA[]=$result['qa_email'];
					$ecc = implode(',',$eccA);
					//$ecc[]='siltu.koley@omindtech.com';
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
				/* End */
				}else if($audit_status==3){
					/* Send email to the auditor for when edit access given */
				$sql = "SELECT entry_by, email_id_off,concat(s.fname, ' ', s.lname) as fullname FROM qa_digit_sales_feedback sales
						LEFT JOIN info_personal ip ON ip.user_id=sales.entry_by 
						LEFT JOIN signin s ON s.id=sales.entry_by
						WHERE sales.id=$audit_id";
				$result= $this->Common_model->get_query_row_array($sql);
				
					$to = $result['email_id_off'];
				//die();
					//exit;
					//$to = 'sumitra.bagchi@omindtech.com';
					$ebody = "Hello ". $result['fullname']."<br><br><br>";
					$ebody .= "<p>Edit permission granted.</p>";
					$ebody .= "<p>Now you can edit your audit.</p>";
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." Edit permission given";
				
					$ecc="";
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
				/* End */
				}
			redirect("qa_digit/posp/".$process);
		}
	} 
	public function bulk_change_audit_status_posp(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$curDateTime=CurrMySqlDate();
			$process = $this->input->post('process');
			$auditArr = $this->input->post('audit_id');
			$arrchk = in_array('Select All', $auditArr);
			if($arrchk == true){
			$firstelement = array_shift($auditArr);
			}
			if(isset($_POST['edit']) && !empty($_POST['edit']) && $_POST['edit'] == 'edit'){
				$audit_status=3; // Edit access to QA
			}else if(isset($_POST['approve']) && !empty($_POST['approve']) && $_POST['approve'] == 'approve'){
				$audit_status=1; // Approve
			}
			//print_r($_POST);
			//echo $audit_status;
			//exit;
			$table_sql = "select table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			foreach($auditArr as $audit){
				$edit_array=array('audit_status'=>$audit_status,'approved_by'=>$current_user,'audit_approved_date'=>$curDateTime);
				$this->db->where('id', $audit);
				$this->db->update($tablename,$edit_array); 
				if($audit_status==1){
					/* Send email to the agent for when audit approve */
					//$tablename = "qa_digit_sales_feedback";
					$sql = "SELECT sales.*, ip.email_id_off, ip_tl.email_id_off as tl_email, ip_qa.email_id_off as qa_email, concat(s.fname, ' ', s.lname) as fullname 
							FROM $tablename sales
							LEFT JOIN info_personal ip ON ip.user_id=sales.agent_id 
							LEFT JOIN signin s ON s.id=sales.agent_id
							LEFT JOIN signin tl ON tl.id = sales.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = sales.tl_id
							LEFT JOIN signin sq on s.assigned_qa = sq.id 
							LEFT JOIN info_personal ip_qa on sq.id = ip_qa.user_id
							WHERE sales.id=$audit";
					$result= $this->Common_model->get_query_row_array($sql);				
					$sqlParam ="SELECT params_columns, fatal_param FROM qa_defect where table_name='$tablename'"; 
					$resultParams = $this->Common_model->get_query_row_array($sqlParam);

					$soft_skill_score = $result['soft_skill_score'];
					//echo"<br>";
					$soft_skill_score_per = number_format(($soft_skill_score/25)*100, 2, '.', '');
					//echo"<br>";
					$sale_skill_score = $result['sale_skill_score'];
					//echo"<br>";
					$sale_skill_score_per = number_format(($sale_skill_score/75)*100, 2, '.', '');
					
					$params = explode(",", $resultParams['params_columns']);
					$fatal_params = explode(",", $resultParams['fatal_param']);
					
					$msgTable = "<Table BORDER=1>";
					$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
					
					$i=1;
					foreach($params as $par){
						//echo $str = str_replace('_', ' ', $par)."<BR>";
						$msgTable .= "<TR><TD>".$i."</TD><TD>". ucwords( str_replace('_', ' ', $par))."</TD> <TD>".$result[$par]."</TD><TD>".$result['comm'.$i]."</TD></TR>";
						
						$i++;
					}
					///////////////////////////
					//$j=1;
					foreach($fatal_params as $fatal_par){
						$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['comm'.($i-10)]."</TD></TR>";
						
						$i++;
					}

					$msgTable .= "<TR><TD colspan='3'>Soft skill score Percentage</TD> <TD>".$soft_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Sale skill score Percentage</TD> <TD>".$sale_skill_score_per."%</TD></TR>";
					$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
					
					
					$msgTable .= "</Table>";
					
					//echo $msgTable;
					//exit;
					
					$eccA=array();
					$to = $result['email_id_off'];
					
					$ebody = "Hello ". $result['fullname']."<br>";
					$ebody .= "<p>As per phone No. ".$result['phone']."</p>";
					$ebody .= "<p>Total Call : ".$result['no_of_call_heard']."</p>";
					$ebody .= "<p>Total Talk time : ".$result['call_duration']."</p>";
					$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
					$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
					$ebody .= "<p>Please listen the call from the QMS Tool and share feedback acceptancy :</p>";
					$ebody .=  $msgTable;
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." New audit happened ";
					
					//echo $ebody;
					//exit;
				
					//$ecc[]='siltu.koley@omindtech.com';
					$eccA[]=$result['tl_email'];
					$eccA[]=$result['qa_email'];
					$ecc = implode(',',$eccA);
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
					unset($eccA);
				/* End */
				}else if($audit_status==3){
					$sql = "SELECT entry_by, email_id_off,concat(s.fname, ' ', s.lname) as fullname FROM $tablename sales
						LEFT JOIN info_personal ip ON ip.user_id=sales.entry_by 
						LEFT JOIN signin s ON s.id=sales.entry_by
						WHERE sales.id=$audit";
					$result= $this->Common_model->get_query_row_array($sql);
				
					$to = $result['email_id_off'];
					
					$ebody = "Hello ". $result['fullname']."<br>";
					$ebody .= "<p>You have been given audit permission. </p>";
					$ebody .= "<p>Now you can edit your audit. </p><br><br>";
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = $result['fullname']." Edit permission given ";
				
					$ecc="";
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
				}
			}
			redirect("qa_digit/posp/".$process);
		}
	} 

	public function qa_posp_rebuttal($process){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/call/welcome/qa_posp_rebuttal.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['process']=$process;

			$table_sql = "select table_name, ata_table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			$ata_tablename = $table_data['ata_table_name'];
			$sheet_name = substr($tablename, 14, -9);
			$data['p_name']=$sheet_name;
			//$data["content_template"] = "qa_digit/call/".$sheet_name."/qa_".$sheet_name."_feedback.php";
			
			if(get_global_access()=='1'){
				//$ops_cond=" where agnt_fd_acpt='Not Accepted'";
				$ops_cond=" where agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
			}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
			}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
			}
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from $tablename) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				Left Join (select ss_id as ata_audit_id from $ata_tablename) zz On (xx.id=zz.ata_audit_id)
				$ops_cond order by audit_date";
			$data["rebuttal_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	/* End */
	public function request_edit_permission_posp($audit,$process){
		if(check_logged_in()){
			$table_sql = "select table_name, ata_table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			   $audit_status =2;
			   $edit_array=array('audit_status'=>$audit_status);
			   $this->db->where('id', $audit);
			   $this->db->update($tablename,$edit_array); 
			   redirect("qa_digit/posp/".$process);
		}
	   }

	   public function posp_operation_trainning($process){
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			//$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			if(get_global_access()=='1' || get_dept_folder()=='qa'){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/call/welcome/posp_operation_trainning.php";
			$data["content_js"] = "qa_digit_js.php";
			$data["process"] = $process;

			$table_sql = "select table_name,ata_table_name from qa_defect where id = $process and is_active = 1";
			$table_data = $this->Common_model->get_query_row_array($table_sql);
			$tablename = $table_data['table_name'];
			$data["table"] = $tablename;
			$ata_tablename = $table_data['ata_table_name'];
			$sheet_name = substr($tablename, 14, -9);
			
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,'1,2') and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from $tablename group by entry_by";
			$data["qaName"] = $this->Common_model->get_query_result_array($qaSql);
			
			$default_val[] = 'ALL';
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$audit_type = $this->input->get('audit_type')?$this->input->get('audit_type'):$default_val;
			$cond="";
			$auditcond="";
			$atacond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if($audit_type!=""){
				if (in_array("ALL",$audit_type, TRUE)){
					$auditcond ='audit_type in("Trainer Audit","Pre-Certificate Mock Call","Operation Audit","Certificate Audit")';
				}else{
					$all_audit=implode('","', $audit_type);
					$auditcond ='audit_type in ("'.$all_audit.'")';
				}
			}
			//echo $auditcond;die;
			
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from $tablename $cond) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				where $auditcond order by audit_date";
				//echo $qSql;die;
			$data["posp_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["audit_type"] = $audit_type;
			
			$this->load->view("dashboard",$data);
			}
		}
	}
	/* Get Reason added 30-08-22 */
	public function getReason(){
		if(check_logged_in())
		{
			$sql = "Select id,reason from digitdev_sale_opportunity_reason where is_active=1";
			$reasonList = $this->Common_model->get_query_result_array($sql);
			echo json_encode($reasonList);
		}
	}
	public function getCompany(){
		if(check_logged_in())
		{
			$rID = $this->input->post('rID');
			$sql = "Select id,company from digitdev_sale_opportunity_company where is_active=1 and reason_id=$rID";
			$companyList = $this->Common_model->get_query_result_array($sql);
			echo json_encode($companyList);
		}
	}
	/* End */
	
/*-------------------------------------------------------------------------------------------------------------------*/
/*------------------------------------------ POSP Audit Feedback by Support -----------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/
	public function support_posp_audit_fd(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/support_posp_audit_fd.php";
			$data["content_js"] = "qa_digit_js.php";
			
			$from_date = '';
			$to_date = '';
			$process_id = '';
			
			$process_id = trim($this->input->get('process_id'));
			
			if($process_id!=""){
				
				$qSql="Select count(id) as value from qa_digit_".$process_id."_feedback where agent_id='$current_user' and audit_status=1";
				$data["tot_ata"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_digit_".$process_id."_feedback where agent_id='$current_user' and audit_status=1 and agent_rvw_date is Null";
				$data["yet_ata_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			
				if($this->input->get('btnView')=='View')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
						
					if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
					
					echo $qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin sc where sc.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name
					from qa_digit_".$process_id."_feedback $cond and agent_id='$current_user' and audit_status=1) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["audit_list"] = $this->Common_model->get_query_result_array($qSql);
				}
				
			}
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["process_id"] = $process_id;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function support_posp_audit_rvw($audit_id, $process_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_digit/support_posp_audit_rvw.php";
			$data["content_js"] = "qa_digit_js.php";
			$data['audit_id']=$audit_id;
			$data['process_id']=$process_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_digit_".$process_id."_feedback where id='$audit_id') xx 
				Left Join 
				(Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["audit_list"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('audit_id'))
			{
				$audit_id=$this->input->post('audit_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('agent_rvw_note'),
					"agent_rvw_date" => $curDateTime
				);				
				$this->db->where('id', $audit_id);
				$this->db->update('qa_digit_'.$process_id.'_feedback',$field_array);
				redirect('qa_digit/support_posp_audit_fd');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
}
?>	 