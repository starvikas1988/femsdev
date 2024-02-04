<?php 

 class Qa_hsdl extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function hsdl_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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
				
				
            } else {
                return false;
            }
        }
        return $images;
    }
	
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hsdl/qa_hsdl_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,186) and is_assign_process (id,380) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			$ops_cond="";
			
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
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else if(get_login_type()=="client"){
				$ops_cond=" Where audit_type not in ('Operation Audit','Trainer Audit')";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hsdl_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["hsdl"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_hsdl($hsdl_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hsdl/add_edit_hsdl.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['hsdl_id']=$hsdl_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,186) and is_assign_process (id,380) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_hsdl_feedback where id='$hsdl_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hsdl"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					//"customer_no" => $this->input->post('customer_no'),
					"call_id" => $this->input->post('call_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"call_opening" => $this->input->post('call_opening'),
					"TC_send" => $this->input->post('TC_send'),
					"banned_practices" => $this->input->post('banned_practices'),
					"read_manufacture_warranty" => $this->input->post('read_manufacture_warranty'),
					"product_described" => $this->input->post('product_described'),
					"describe_replacement" => $this->input->post('describe_replacement'),
					"describe_PP_replacement" => $this->input->post('describe_PP_replacement'),
					"not_use_reinstate" => $this->input->post('not_use_reinstate'),
					"identified_signs" => $this->input->post('identified_signs'),
					"switch_over_process" => $this->input->post('switch_over_process'),
					"good_working_order" => $this->input->post('good_working_order'),
					"preexisting_fault" => $this->input->post('preexisting_fault'),
					"approximate_age_question" => $this->input->post('approximate_age_question'),
					"brand_not_known_asked" => $this->input->post('brand_not_known_asked'),
					"brand_practice_not_use" => $this->input->post('brand_practice_not_use'),
					"agent_matches_product" => $this->input->post('agent_matches_product'),
					"agent_provide_saving_info" => $this->input->post('agent_provide_saving_info'),
					"confirm_name_address" => $this->input->post('confirm_name_address'),
					"total_cost_confirm" => $this->input->post('total_cost_confirm'),
					"confirm_registered_card" => $this->input->post('confirm_registered_card'),
					"call_paused_payment" => $this->input->post('call_paused_payment'),
					"cost_of_plan_clear" => $this->input->post('cost_of_plan_clear'),
					"payment_frequency_confirm" => $this->input->post('payment_frequency_confirm'),
					"payment_frequency_understood" => $this->input->post('payment_frequency_understood'),
					"DD_script_read_customer" => $this->input->post('DD_script_read_customer'),
					"payment_unsuccessful" => $this->input->post('payment_unsuccessful'),
					"TC_sent_in_3_5_days" => $this->input->post('TC_sent_in_3_5_days'),
					"cancellation_rights_read" => $this->input->post('cancellation_rights_read'),
					"question_asked_statement_read" => $this->input->post('question_asked_statement_read'),
					"wording_of_policy_premium" => $this->input->post('wording_of_policy_premium'),
					"script_for_limited_cover_read" => $this->input->post('script_for_limited_cover_read'),
					"professional_throughout_call" => $this->input->post('professional_throughout_call'),
					"status_accurately_recorded" => $this->input->post('status_accurately_recorded'),
					"identify_clear_sign" => $this->input->post('identify_clear_sign'),
					"handle_vulnerable_customer" => $this->input->post('handle_vulnerable_customer'),
					"clear_its_not_insurance" => $this->input->post('clear_its_not_insurance'),
					"company_name_stated_3times" => $this->input->post('company_name_stated_3times'),
					"competitor_stated" => $this->input->post('competitor_stated'),
					"not_speak_negetive_manner" => $this->input->post('not_speak_negetive_manner'),
					"compliance_score" => $this->input->post('compliance_score'),
					"business_score" => $this->input->post('business_score'),
					"sales_score" => $this->input->post('sales_score'),
					"risk_cat1" => $this->input->post('risk_cat1'),
					"risk_cat2" => $this->input->post('risk_cat2'),
					"risk_cat3" => $this->input->post('risk_cat3'),
					"risk_cat4" => $this->input->post('risk_cat4'),
					"risk_cat5" => $this->input->post('risk_cat5'),
					"risk_cat6" => $this->input->post('risk_cat6'),
					"risk_cat7" => $this->input->post('risk_cat7'),
					"risk_cat8" => $this->input->post('risk_cat8'),
					"risk_cat9" => $this->input->post('risk_cat9'),
					"risk_cat10" => $this->input->post('risk_cat10'),
					"risk_cat11" => $this->input->post('risk_cat11'),
					"risk_cat12" => $this->input->post('risk_cat12'),
					"risk_cat13" => $this->input->post('risk_cat13'),
					"risk_cat14" => $this->input->post('risk_cat14'),
					"risk_cat15" => $this->input->post('risk_cat15'),
					"risk_cat16" => $this->input->post('risk_cat16'),
					"risk_cat17" => $this->input->post('risk_cat17'),
					"risk_cat18" => $this->input->post('risk_cat18'),
					"risk_cat19" => $this->input->post('risk_cat19'),
					"risk_cat20" => $this->input->post('risk_cat20'),
					"risk_cat21" => $this->input->post('risk_cat21'),
					"risk_cat22" => $this->input->post('risk_cat22'),
					"risk_cat23" => $this->input->post('risk_cat23'),
					"risk_cat24" => $this->input->post('risk_cat24'),
					"risk_cat25" => $this->input->post('risk_cat25'),
					"risk_cat26" => $this->input->post('risk_cat26'),
					"risk_cat27" => $this->input->post('risk_cat27'),
					"risk_cat28" => $this->input->post('risk_cat28'),
					"risk_cat29" => $this->input->post('risk_cat29'),
					"risk_cat30" => $this->input->post('risk_cat30'),
					"risk_cat31" => $this->input->post('risk_cat31'),
					"risk_cat32" => $this->input->post('risk_cat32'),
					"risk_cat33" => $this->input->post('risk_cat33'),
					"risk_cat34" => $this->input->post('risk_cat34'),
					"risk_cat35" => $this->input->post('risk_cat35'),
					"risk_cat36" => $this->input->post('risk_cat36'),
					"risk_cat37" => $this->input->post('risk_cat37'),
					"risk_cat38" => $this->input->post('risk_cat38'),
					"risk_cat39" => $this->input->post('risk_cat39'),
					"tier_cat1" => $this->input->post('tier_cat1'),
					"tier_cat2" => $this->input->post('tier_cat2'),
					"tier_cat3" => $this->input->post('tier_cat3'),
					"tier_cat4" => $this->input->post('tier_cat4'),
					"tier_cat5" => $this->input->post('tier_cat5'),
					"tier_cat6" => $this->input->post('tier_cat6'),
					"tier_cat7" => $this->input->post('tier_cat7'),
					"tier_cat8" => $this->input->post('tier_cat8'),
					"tier_cat9" => $this->input->post('tier_cat9'),
					"tier_cat10" => $this->input->post('tier_cat10'),
					"tier_cat11" => $this->input->post('tier_cat11'),
					"tier_cat12" => $this->input->post('tier_cat12'),
					"tier_cat13" => $this->input->post('tier_cat13'),
					"tier_cat14" => $this->input->post('tier_cat14'),
					"tier_cat15" => $this->input->post('tier_cat15'),
					"tier_cat16" => $this->input->post('tier_cat16'),
					"tier_cat17" => $this->input->post('tier_cat17'),
					"tier_cat18" => $this->input->post('tier_cat18'),
					"tier_cat19" => $this->input->post('tier_cat19'),
					"tier_cat20" => $this->input->post('tier_cat20'),
					"tier_cat21" => $this->input->post('tier_cat21'),
					"tier_cat22" => $this->input->post('tier_cat22'),
					"tier_cat23" => $this->input->post('tier_cat23'),
					"tier_cat24" => $this->input->post('tier_cat24'),
					"tier_cat25" => $this->input->post('tier_cat25'),
					"tier_cat26" => $this->input->post('tier_cat26'),
					"tier_cat27" => $this->input->post('tier_cat27'),
					"tier_cat28" => $this->input->post('tier_cat28'),
					"tier_cat29" => $this->input->post('tier_cat29'),
					"tier_cat30" => $this->input->post('tier_cat30'),
					"tier_cat31" => $this->input->post('tier_cat31'),
					"tier_cat32" => $this->input->post('tier_cat32'),
					"tier_cat33" => $this->input->post('tier_cat33'),
					"tier_cat34" => $this->input->post('tier_cat34'),
					"tier_cat35" => $this->input->post('tier_cat35'),
					"tier_cat36" => $this->input->post('tier_cat36'),
					"tier_cat37" => $this->input->post('tier_cat37'),
					"tier_cat38" => $this->input->post('tier_cat38'),
					"tier_cat39" => $this->input->post('tier_cat39'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($hsdl_id==0){
					
					$a = $this->hsdl_upload_files($_FILES['attach_file'], $path='./qa_files/qa_hsdl/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_hsdl_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_hsdl_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_hsdl_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $hsdl_id);
					$this->db->update('qa_hsdl_feedback',$field_array);
					/////////
					if(get_login_type()=="client"){
						$field_array1 = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$field_array1 = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $hsdl_id);
					$this->db->update('qa_hsdl_feedback',$field_array1);
					
				}
				
				redirect('qa_hsdl');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_hsdl_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hsdl/agent_hsdl_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_hsdl/agent_hsdl_feedback";
			
			
			$qSql="Select count(id) as value from qa_hsdl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_hsdl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hsdl_feedback $cond ) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hsdl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_hsdl_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hsdl/agent_hsdl_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_hsdl/agent_hsdl_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hsdl_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["hsdl"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_hsdl_feedback',$field_array1);
					
				redirect('Qa_hsdl/agent_hsdl_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_hsdl_report(){
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
			$data["content_template"] = "qa_hsdl/qa_hsdl_report.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_hsdl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if($audit_type=="All"){ 
					if(get_login_type()=="client"){
						$cond .= "audit_type not in ('Operation Audit','Trainer Audit')";
					}else{
						$cond .= "";
					}
				}else{ 
					$cond .=" and audit_type='$audit_type'";
				}
				
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if((get_role_dir()=='tl' && get_user_fusion_id()!='FMAN000616') && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
				
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_hsdl_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_hsdl_list"] = $fullAray;
				$this->create_qa_hsdl_CSV($fullAray);	
				$dn_link = base_url()."qa_hsdl/download_qa_hsdl_CSV";	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_hsdl_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA HSDL Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_hsdl_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Call ID", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score", "Call opening meets standards of engagement", "Risk Category", "Tier Category", "T&C sent in 3-5 working days", "Risk Category", "Tier Category", "Banned practices are not used", "Risk Category", "Tier Category", "Read Manufacturer Warranty script", "Risk Category", "Tier Category", "Products and services were accurately described", "Risk Category", "Tier Category", "may used for describing replacement", "Risk Category", "Tier Category", "aim used to describe PP and replacement service", "Risk Category", "Tier Category", "Did not use Reinstate or Renew", "Risk Category", "Tier Category", "Identified signs of cover in place", "Risk Category", "Tier Category", "Followed the switch over process", "Risk Category", "Tier Category", "Good working order question asked", "Risk Category", "Tier Category", "Identifying signs of a pre-existing fault", "Risk Category", "Tier Category", "Brand name and the approximate age question asked", "Risk Category", "Tier Category", "If Brand not known asked to call in within 14 days", "Risk Category", "Tier Category", "Banned practices are not used Discount not described", "Risk Category", "Tier Category", "Agent matches product to customer needs", "Risk Category", "Tier Category", "Agent provides accurate savings information", "Risk Category", "Tier Category", "Agent confirms name address", "Risk Category", "Tier Category", "Total Cost Confirmed", "Risk Category", "Tier Category", "Agent confirms the address the card is registered at", "Risk Category", "Tier Category", "Call paused at payment details", "Risk Category", "Tier Category", "Total Cost of plan clear and understood", "Risk Category", "Tier Category", "Payment Frequency confirmed", "Risk Category", "Tier Category", "Frequency of payments clear and understood", "Risk Category", "Tier Category", "DD script read verbatim or customer is referred to a confirmation letter", "Risk Category", "Tier Category", "Payment Unsuccessful Script read", "Risk Category", "Tier Category", "T&C sent in 3-5 working days", "Risk Category", "Tier Category", "Cancellation Rights read", "Risk Category", "Tier Category", "Opt in Question asked and Opt out statement read", "Risk Category", "Tier Category", "Wording of Policy and Premium", "Risk Category", "Tier Category", "Script for limited cover read if Premium plan price declined", "Risk Category", "Tier Category", "Agent is professional throughout the call", "Risk Category", "Tier Category", "Opt in status accurately recorded", "Risk Category", "Tier Category", "Identifying clear signs of vulnerability", "Risk Category", "Tier Category", "Followed procedure for handling vulnerable customers", "Risk Category", "Tier Category", "Made clear its not insurance", "Risk Category", "Tier Category", "Company name stated 3 times in a call", "Risk Category", "Tier Category", "No facts or assumptions about a competitor stated", "Risk Category", "Tier Category", "Did not speak in a negative manor towards a competitor", "Risk Category", "Tier Category", "Sales Score", "Business Score", "Compliance Score", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user){	
			if($user['entry_by']!=''){
				$auditorName = $user['auditor_name'];
			}else{
				$auditorName = $user['client_name'];
			}
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			//$row .= '"'.$user['customer_no'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['sales_score'].'%'.'",';
			$row .= '"'.$user['business_score'].'%'.'",';
			$row .= '"'.$user['compliance_score'].'%'.'",';
			$row .= '"'.$user['call_opening'].'",';
			$row .= '"'.$user['risk_cat1'].'",';
			$row .= '"'.$user['tier_cat1'].'",';
			$row .= '"'.$user['TC_send'].'",';
			$row .= '"'.$user['risk_cat2'].'",';
			$row .= '"'.$user['tier_cat2'].'",';
			$row .= '"'.$user['banned_practices'].'",';
			$row .= '"'.$user['risk_cat3'].'",';
			$row .= '"'.$user['tier_cat3'].'",';
			$row .= '"'.$user['read_manufacture_warranty'].'",';
			$row .= '"'.$user['risk_cat4'].'",';
			$row .= '"'.$user['tier_cat4'].'",';
			$row .= '"'.$user['product_described'].'",';
			$row .= '"'.$user['risk_cat5'].'",';
			$row .= '"'.$user['tier_cat5'].'",';
			$row .= '"'.$user['describe_replacement'].'",';
			$row .= '"'.$user['risk_cat6'].'",';
			$row .= '"'.$user['tier_cat6'].'",';
			$row .= '"'.$user['describe_PP_replacement'].'",';
			$row .= '"'.$user['risk_cat7'].'",';
			$row .= '"'.$user['tier_cat7'].'",';
			$row .= '"'.$user['not_use_reinstate'].'",';
			$row .= '"'.$user['risk_cat8'].'",';
			$row .= '"'.$user['tier_cat8'].'",';
			$row .= '"'.$user['identified_signs'].'",';
			$row .= '"'.$user['risk_cat9'].'",';
			$row .= '"'.$user['tier_cat9'].'",';
			$row .= '"'.$user['switch_over_process'].'",';
			$row .= '"'.$user['risk_cat10'].'",';
			$row .= '"'.$user['tier_cat10'].'",';
			$row .= '"'.$user['good_working_order'].'",';
			$row .= '"'.$user['risk_cat11'].'",';
			$row .= '"'.$user['tier_cat11'].'",';
			$row .= '"'.$user['preexisting_fault'].'",';
			$row .= '"'.$user['risk_cat12'].'",';
			$row .= '"'.$user['tier_cat12'].'",';
			$row .= '"'.$user['approximate_age_question'].'",';
			$row .= '"'.$user['risk_cat13'].'",';
			$row .= '"'.$user['tier_cat13'].'",';
			$row .= '"'.$user['brand_not_known_asked'].'",';
			$row .= '"'.$user['risk_cat14'].'",';
			$row .= '"'.$user['tier_cat14'].'",';
			$row .= '"'.$user['brand_practice_not_use'].'",';
			$row .= '"'.$user['risk_cat15'].'",';
			$row .= '"'.$user['tier_cat15'].'",';
			$row .= '"'.$user['agent_matches_product'].'",';
			$row .= '"'.$user['risk_cat16'].'",';
			$row .= '"'.$user['tier_cat16'].'",';
			$row .= '"'.$user['agent_provide_saving_info'].'",';
			$row .= '"'.$user['risk_cat17'].'",';
			$row .= '"'.$user['tier_cat17'].'",';
			$row .= '"'.$user['confirm_name_address'].'",';
			$row .= '"'.$user['risk_cat18'].'",';
			$row .= '"'.$user['tier_cat18'].'",';
			$row .= '"'.$user['total_cost_confirm'].'",';
			$row .= '"'.$user['risk_cat19'].'",';
			$row .= '"'.$user['tier_cat19'].'",';
			$row .= '"'.$user['confirm_registered_card'].'",';
			$row .= '"'.$user['risk_cat20'].'",';
			$row .= '"'.$user['tier_cat20'].'",';
			$row .= '"'.$user['call_paused_payment'].'",';
			$row .= '"'.$user['risk_cat21'].'",';
			$row .= '"'.$user['tier_cat21'].'",';
			$row .= '"'.$user['cost_of_plan_clear'].'",';
			$row .= '"'.$user['risk_cat22'].'",';
			$row .= '"'.$user['tier_cat22'].'",';
			$row .= '"'.$user['payment_frequency_confirm'].'",';
			$row .= '"'.$user['risk_cat23'].'",';
			$row .= '"'.$user['tier_cat23'].'",';
			$row .= '"'.$user['payment_frequency_understood'].'",';
			$row .= '"'.$user['risk_cat24'].'",';
			$row .= '"'.$user['tier_cat24'].'",';
			$row .= '"'.$user['DD_script_read_customer'].'",';
			$row .= '"'.$user['risk_cat25'].'",';
			$row .= '"'.$user['tier_cat25'].'",';
			$row .= '"'.$user['payment_unsuccessful'].'",';
			$row .= '"'.$user['risk_cat26'].'",';
			$row .= '"'.$user['tier_cat26'].'",';
			$row .= '"'.$user['T&C_sent_in_3_5_days'].'",';
			$row .= '"'.$user['risk_cat27'].'",';
			$row .= '"'.$user['tier_cat27'].'",';
			$row .= '"'.$user['cancellation_rights_read'].'",';
			$row .= '"'.$user['risk_cat28'].'",';
			$row .= '"'.$user['tier_cat28'].'",';
			$row .= '"'.$user['question_asked_statement_read'].'",';
			$row .= '"'.$user['risk_cat29'].'",';
			$row .= '"'.$user['tier_cat29'].'",';
			$row .= '"'.$user['wording_of_policy_premium'].'",';
			$row .= '"'.$user['risk_cat30'].'",';
			$row .= '"'.$user['tier_cat30'].'",';
			$row .= '"'.$user['script_for_limited_cover_read'].'",';
			$row .= '"'.$user['risk_cat31'].'",';
			$row .= '"'.$user['tier_cat31'].'",';
			$row .= '"'.$user['professional_throughout_call'].'",';
			$row .= '"'.$user['risk_cat32'].'",';
			$row .= '"'.$user['tier_cat32'].'",';
			$row .= '"'.$user['status_accurately_recorded'].'",';
			$row .= '"'.$user['risk_cat33'].'",';
			$row .= '"'.$user['tier_cat33'].'",';
			$row .= '"'.$user['identify_clear_sign'].'",';
			$row .= '"'.$user['risk_cat34'].'",';
			$row .= '"'.$user['tier_cat34'].'",';
			$row .= '"'.$user['handle_vulnerable_customer'].'",';
			$row .= '"'.$user['risk_cat35'].'",';
			$row .= '"'.$user['tier_cat35'].'",';
			$row .= '"'.$user['clear_its_not_insurance'].'",';
			$row .= '"'.$user['risk_cat36'].'",';
			$row .= '"'.$user['tier_cat36'].'",';
			$row .= '"'.$user['company_name_stated_3times'].'",';
			$row .= '"'.$user['risk_cat37'].'",';
			$row .= '"'.$user['tier_cat37'].'",';
			$row .= '"'.$user['competitor_stated'].'",';
			$row .= '"'.$user['risk_cat38'].'",';
			$row .= '"'.$user['tier_cat38'].'",';
			$row .= '"'.$user['not_speak_negetive_manner'].'",';
			$row .= '"'.$user['risk_cat39'].'",';
			$row .= '"'.$user['tier_cat39'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
	
	}
	

//////////////////////////////////////////////////////////////////
//////////////////// Compliance Dashboard ////////////////////////
//////////////////////////////////////////////////////////////////
	/* public function compliance_dashboard(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids(); 
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hsdl/hsdl_compliance_dashboard.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			//$process_id = $this->input->get('process_id');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			
			if($from_date=="") $from_date=CurrDate();
			else $from_date = mmddyy2mysql($from_date);
			
			if($to_date=="") $to_date=CurrDate();
			else $to_date = mmddyy2mysql($to_date);

			
			$data['risk_cat1'] = array();
			$data['risk_cat2'] = array();
			
			$rc1 = $this->Common_model->get_single_value('select count(risk_cat1) as value from qa_hsdl_feedback where risk_cat1='.$rkct1);
			$rc2 = $this->Common_model->get_single_value('select count(risk_cat2) as value from qa_hsdl_feedback where risk_cat2='.$rkct1);
			
			if($this->input->get('btnView')=='View')
			{
			
				$rkct1 .=' "Unfair Trading Regs 2008"';
				$data['risk_cat1'] = $rc1+$rc2;
				
			}
		
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			//$data["process_id"] = $process_id;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	} */
	
	
 }