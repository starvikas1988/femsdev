<?php 

 class Qa_doubtnut extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Common_model');
	}
	
	
	private function dt_upload_files($files,$path)
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
            }else{
                return false;
            }
        }
        return $images;
    }
	
//////////////////////////////////////////////////////
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/qa_doubtnut_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,136) and is_assign_process (id,282) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			
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
			if($agent_id != "") $cond .= " and agent_id='$agent_id'";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_doubtnut_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["doubtnut_data"] = $this->Common_model->get_query_result_array($qSql);
			
		//////////////

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_doubtnut_p2p_scrubbed $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["doubtnut_p2p_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////// Doubtnut Call Audit ///////////////////////////	
//////
	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,136) and is_assign_process (id,282) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			//$data["startAuditTime"]=$startAuditTime;
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"emp_id" => $this->input->post('emp_id'),
					"disposition" => $this->input->post('disposition'),
					"sub_disposition" => $this->input->post('sub_disposition'),
					"call_duration" => $this->input->post('call_duration'),
					"partner" => $this->input->post('partner'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting" => $this->input->post('greeting'),
					"self_introduction" => $this->input->post('self_introduction'),
					"customer_introduction" => $this->input->post('customer_introduction'),
					"reason_for_call" => $this->input->post('reason_for_call'),
					"student_class" => $this->input->post('student_class'),
					"student_catagory" => $this->input->post('student_catagory'),
					"medium_schooling" => $this->input->post('medium_schooling'),
					"city_residence" => $this->input->post('city_residence'),
					"parent_profiling" => $this->input->post('parent_profiling'),
					"examination_prepare" => $this->input->post('examination_prepare'),
					"judgement_point" => $this->input->post('judgement_point'),
					"customer_analysis" => $this->input->post('customer_analysis'),
					"VMC_introduction" => $this->input->post('VMC_introduction'),
					"VOD_solution" => $this->input->post('VOD_solution'),
					"DN_titution" => $this->input->post('offering'),
					"product_explanation" => $this->input->post('product_explanation'),
					"alternate_contact" => $this->input->post('alternate_contact'),
					"product_price" => $this->input->post('product_price'),
					"payee_confirmation" => $this->input->post('payee_confirmation'),
					"probe_to_connect" => $this->input->post('probe_to_connect'),
					"student_course_view" => $this->input->post('student_course_view'),
					"buying_hesitation" => $this->input->post('buying_hesitation'),
					"urgency_creation" => $this->input->post('urgency_creation'),
					"approach_close_sale" => $this->input->post('approach_close_sale'),
					"introduction_payee_segment2" => $this->input->post('introduction_payee_segment2'),
					"student_weakness_segment2" => $this->input->post('student_weakness_segment2'),
					"product_explaination_segment2" => $this->input->post('product_explaination_segment2'),
					"product_price_segment2" => $this->input->post('product_price_segment2'),
					"payment_option_segment2" => $this->input->post('payment_option_segment2'),
					"parent_view_course_segment2" => $this->input->post('parent_view_course_segment2'),
					"buying_hesitation_segment2" => $this->input->post('buying_hesitation_segment2'),
					"creating_urgency_segment2" => $this->input->post('creating_urgency_segment2'),
					"closing_sale_segment2" => $this->input->post('closing_sale_segment2'),
					"summary_segment2" => $this->input->post('summary_segment2'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"cmt27" => $this->input->post('cmt27'),
					"cmt28" => $this->input->post('cmt28'),
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
					"cmt32" => $this->input->post('cmt32'),
					"cmt33" => $this->input->post('cmt33'),
					"cmt34" => $this->input->post('cmt34'),
					"cmt35" => $this->input->post('cmt35'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->dt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_doubtnut/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_doubtnut_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_doubtnut_feedback',$field_array1);
			///////////		
				redirect('Qa_doubtnut');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_doubtnut_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/mgnt_doubtnut_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,136) and is_assign_process (id,282) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_doubtnut_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["doubtnut_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"emp_id" => $this->input->post('emp_id'),
					"disposition" => $this->input->post('disposition'),
					"sub_disposition" => $this->input->post('sub_disposition'),
					"call_duration" => $this->input->post('call_duration'),
					"partner" => $this->input->post('partner'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting" => $this->input->post('greeting'),
					"self_introduction" => $this->input->post('self_introduction'),
					"customer_introduction" => $this->input->post('customer_introduction'),
					"reason_for_call" => $this->input->post('reason_for_call'),
					"student_class" => $this->input->post('student_class'),
					"student_catagory" => $this->input->post('student_catagory'),
					"medium_schooling" => $this->input->post('medium_schooling'),
					"city_residence" => $this->input->post('city_residence'),
					"parent_profiling" => $this->input->post('parent_profiling'),
					"examination_prepare" => $this->input->post('examination_prepare'),
					"judgement_point" => $this->input->post('judgement_point'),
					"customer_analysis" => $this->input->post('customer_analysis'),
					"VMC_introduction" => $this->input->post('VMC_introduction'),
					"VOD_solution" => $this->input->post('VOD_solution'),
					"DN_titution" => $this->input->post('offering'),
					"product_explanation" => $this->input->post('product_explanation'),
					"alternate_contact" => $this->input->post('alternate_contact'),
					"product_price" => $this->input->post('product_price'),
					"payee_confirmation" => $this->input->post('payee_confirmation'),
					"probe_to_connect" => $this->input->post('probe_to_connect'),
					"student_course_view" => $this->input->post('student_course_view'),
					"buying_hesitation" => $this->input->post('buying_hesitation'),
					"urgency_creation" => $this->input->post('urgency_creation'),
					"approach_close_sale" => $this->input->post('approach_close_sale'),
					"introduction_payee_segment2" => $this->input->post('introduction_payee_segment2'),
					"student_weakness_segment2" => $this->input->post('student_weakness_segment2'),
					"product_explaination_segment2" => $this->input->post('product_explaination_segment2'),
					"product_price_segment2" => $this->input->post('product_price_segment2'),
					"payment_option_segment2" => $this->input->post('payment_option_segment2'),
					"parent_view_course_segment2" => $this->input->post('parent_view_course_segment2'),
					"buying_hesitation_segment2" => $this->input->post('buying_hesitation_segment2'),
					"creating_urgency_segment2" => $this->input->post('creating_urgency_segment2'),
					"closing_sale_segment2" => $this->input->post('closing_sale_segment2'),
					"summary_segment2" => $this->input->post('summary_segment2'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"cmt27" => $this->input->post('cmt27'),
					"cmt28" => $this->input->post('cmt28'),
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
					"cmt32" => $this->input->post('cmt32'),
					"cmt33" => $this->input->post('cmt33'),
					"cmt34" => $this->input->post('cmt34'),
					"cmt35" => $this->input->post('cmt35'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_doubtnut_feedback',$field_array);
			//////////
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_doubtnut_feedback',$field_array1);
			/////////
				redirect('Qa_doubtnut');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
//////////////////// Doubtnut P2P Scrubbing ///////////////////////////	
//////
	
	public function add_p2p_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/add_p2p_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,136) and is_assign_process (id,282) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			//$data["startAuditTime"]=$startAuditTime;
			
			if($this->input->post('level1subcausedate')!=''){
				$level1subcausedate = mmddyy2mysql($this->input->post('level1subcausedate'));
			}
			if($this->input->post('level2subcausedate')!=''){
				$level2subcausedate = mmddyy2mysql($this->input->post('level2subcausedate'));
			}
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"student_id" => $this->input->post('student_id'),
					"partner" => $this->input->post('partner'),
					"phone" => $this->input->post('phone'),
					"level1generationdate" => mmddyy2mysql($this->input->post('level1generationdate')),
					"level1generationTMname" => $this->input->post('level1generationTMname'),
					"level1promisedate" => mmddyy2mysql($this->input->post('level1promisedate')),
					"level1cause" => $this->input->post('level1cause'),
					"level1subcause" => $this->input->post('level1subcause'),
					"level1subcausedate" => $level1subcausedate,
					"level1remarks" => $this->input->post('level1remarks'),
					"level2lastconnectdate" => mmddyy2mysql($this->input->post('level2lastconnectdate')),
					"level2lastpromisedate" => mmddyy2mysql($this->input->post('level2lastpromisedate')),
					"level2connectTMname" => $this->input->post('level2connectTMname'),
					"level2cause" => $this->input->post('level2cause'),
					"level2subcause" => $this->input->post('level2subcause'),
					"level2subcausedate" => $level2subcausedate,
					"level2remarks" => $this->input->post('level2remarks'),
					"entry_date" => CurrMySqlDate(),
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$rowid= data_inserter('qa_doubtnut_p2p_scrubbed',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_doubtnut_p2p_scrubbed',$field_array1);
			///////////		
				redirect('Qa_doubtnut');
			}
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_p2p_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/mgnt_p2p_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,136) and is_assign_process (id,282) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_doubtnut_p2p_scrubbed where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["p2p_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('level1subcausedate')!=''){
				$this->db->query('Update qa_doubtnut_p2p_scrubbed set level1subcause="" WHERE id = "'.$id.'"');
				$level1subcausedate = mmddyy2mysql($this->input->post('level1subcausedate'));
			}else if($this->input->post('level1subcause')!=''){
				$this->db->query('Update qa_doubtnut_p2p_scrubbed set level1subcausedate=""  WHERE id = "'.$id.'"');
				$level1subcause = $this->input->post('level1subcause');
			}
			
			if($this->input->post('level2subcausedate')!=''){
				$this->db->query('Update qa_doubtnut_p2p_scrubbed set level2subcause="" WHERE id = "'.$id.'"');
				$level2subcausedate = mmddyy2mysql($this->input->post('level2subcausedate'));
			}else if($this->input->post('level2subcause')!=''){
				$this->db->query('Update qa_doubtnut_p2p_scrubbed set level2subcausedate="" WHERE id = "'.$id.'"');
				$level2subcause = $this->input->post('level2subcause');
			}
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"student_id" => $this->input->post('student_id'),
					"partner" => $this->input->post('partner'),
					"phone" => $this->input->post('phone'),
					"level1generationdate" => mmddyy2mysql($this->input->post('level1generationdate')),
					"level1generationTMname" => $this->input->post('level1generationTMname'),
					"level1promisedate" => mmddyy2mysql($this->input->post('level1promisedate')),
					"level1cause" => $this->input->post('level1cause'),
					"level1subcause" => $level1subcause,
					"level1subcausedate" => $level1subcausedate,
					"level1remarks" => $this->input->post('level1remarks'),
					"level2lastconnectdate" => mmddyy2mysql($this->input->post('level2lastconnectdate')),
					"level2lastpromisedate" => mmddyy2mysql($this->input->post('level2lastpromisedate')),
					"level2connectTMname" => $this->input->post('level2connectTMname'),
					"level2cause" => $this->input->post('level2cause'),
					"level2subcause" => $level2subcause,
					"level2subcausedate" => $level2subcausedate,
					"level2remarks" => $this->input->post('level2remarks')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_doubtnut_p2p_scrubbed',$field_array);
			//////////
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_doubtnut_p2p_scrubbed',$field_array1);
			/////////
				redirect('Qa_doubtnut');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_doubtnut_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/agent_doubtnut_feedback.php";
			$data["agentUrl"] = "qa_doubtnut/agent_doubtnut_feedback";
			
			
			$qSql="Select count(id) as value from qa_doubtnut_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_doubtnut_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
		///////////////

			$qSql="Select count(id) as value from qa_doubtnut_p2p_scrubbed where agent_id='$current_user'";
			$data["tot_p2p_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_doubtnut_p2p_scrubbed where agent_id='$current_user' and agent_rvw_date is Null";
			$data["yet_p2p_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_doubtnut_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			///////////////	
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_doubtnut_p2p_scrubbed $cond and agent_id='$current_user') xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_p2p_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_doubtnut_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_doubtnut_p2p_scrubbed where agent_id='$current_user') xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_p2p_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_doubtnut_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/agent_doubtnut_rvw.php";
			$data["agentUrl"] = "qa_doubtnut/agent_doubtnut_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_doubtnut_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["doubtnut_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["dntid"]=$id;
		
			if($this->input->post('dntid'))
			{
				$dntid=$this->input->post('dntid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $dntid);
				$this->db->update('qa_doubtnut_feedback',$field_array1);	
				redirect('Qa_doubtnut/agent_doubtnut_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
//////////////////
	
	public function agent_p2p_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_doubtnut/agent_p2p_rvw.php";
			$data["agentUrl"] = "qa_doubtnut/agent_doubtnut_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_doubtnut_p2p_scrubbed where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["p2p_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["p2pid"]=$id;
		
			if($this->input->post('p2pid'))
			{
				$p2pid=$this->input->post('p2pid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $p2pid);
				$this->db->update('qa_doubtnut_p2p_scrubbed',$field_array1);	
				redirect('Qa_doubtnut/agent_doubtnut_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////////// QA Doubtnut REPORT //////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_doubtnut_report(){
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
			$data["content_template"] = "qa_doubtnut/qa_doubtnut_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$process="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$process = $this->input->get('process');
			if($process=="doubtnut"){
				$dn_table="qa_doubtnut_feedback";
			}else if($process=="doubtnut_p2p"){
				$dn_table="qa_doubtnut_p2p_scrubbed";
			}
			
			$data["qa_doubtnut_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
				
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from ".$dn_table.") xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_doubtnut_list"] = $fullAray;
				$this->create_qa_doubtnut_CSV($fullAray,$process);	
				$dn_link = base_url()."qa_doubtnut/download_qa_doubtnut_CSV/".$process;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['process']=$process;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_doubtnut_CSV($process)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		if($process=="doubtnut"){
			$title="Doubtnut";
		}else if($process=="doubtnut_p2p"){
			$title="Doubtnut P2P Scrubbed";
		}
		$newfile="QA ".$title." Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_doubtnut_CSV($rr,$process)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($process=='doubtnut'){
			$header = array("Auditor Name", "Evaluation Date", "Fusion ID", "Agent", "TL", "Call Date", "Call Duration", "Partner", "Emp ID", "Disposition", "Sub Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Greeting", "Self Introduction", "Customer Introduction", "Reason for Call", "Student Class", "Category of Student", "City of Residence", "Parents Profiling", "Examination Preparing for Future Goal", "Judgemnet Point", "Complete analysis of customer requirements", "VMC Introduction - Not applicable for DN Tutions", "VMC - VOD as a solution - Not applicable for DN Tutions", "DN Tutions - IF student is in 10th or 12th and not preparing JEE NEET", "Offerings", "Product Explanation", "Alternate Contact", "Product Price", "Payee Confirmation", "Probe to connect with Payee", "Student views regarding course", "Buying hesitation", "Urgency Creation", "Approach to close sale", "Segment2 - Urgency Creation", "Segment2 - Student Weaknesses", "Segment2 - Product Explanation", "Segment2 - Product Price", "Segment2 - Payment Options", "Segment2 - Parents views regarding course", "Segment2 - Buying hesitation", "Segment2 - Creating Urgency", "Segment2 - Closing the sale", "Segment2 - Summary", "Introduction Comment1", "Introduction Comment2", "Introduction Comment3", "Introduction Comment4", "Student Qualification Comment1", "Student Qualification Comment2", "Student Qualification Comment3", "Student Qualification Comment4", "Student Qualification Comment5", "Student Qualification Comment6", "Student Qualification Comment7", "Need Analysis Comment", "Product Comment1", "Product Comment2", "Product Comment3", "Product Comment4", "Product Comment5", "Pricing & Payment Comment1", "Pricing & Payment Comment2", "Pricing & Payment Comment3", "Pricing & Payment Comment4", "Objection Handling Comment1", "Objection Handling Comment2", "Closing Urgency Comment1", "Closing Urgency Comment2", "Segment2 Closing Urgency Comment", "Segment2 Product Comment1", "Segment2 Product Comment2", "Segment2 Pricing & Payment Comment1", "Segment2 Pricing & Payment Comment2", "Segment2 Objection Handling Comment1", "Segment2 Objection Handling Comment2", "Segment2 Closing & Summary Comment1", "Segment2 Closing & Summary Comment2", "Segment2 Closing & Summary Comment3", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($process=='doubtnut_p2p'){
			$header = array("Scrubbed By", "Lead Date", "Partner", "Student ID", "Student Name", "L1 Supervisor", "Phone", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "LEVEL1 - P2P Generation Date", "LEVEL1 - P2P Generation TM Name", "LEVEL1 - P2P Promise Date", "LEVEL1 - Cause", "LEVEL1 - SubCause", "LEVEL1 - Remarks", "LEVEL2 - Last Connect Date", "LEVEL2 - Last Promise Date", "LEVEL2 - Last Connect TM Name", "LEVEL2 - Cause", "LEVEL2 - SubCause", "LEVEL2 - Remarks", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($process=='doubtnut'){
			foreach($rr as $user){	
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				$row = '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['partner'].'",';
				$row .= '"'.$user['emp_id'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['sub_disposition'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greeting'].'",';
				$row .= '"'.$user['self_introduction'].'",';
				$row .= '"'.$user['customer_introduction'].'",';
				$row .= '"'.$user['reason_for_call'].'",';
				$row .= '"'.$user['student_class'].'",';
				$row .= '"'.$user['student_catagory'].'",';
				$row .= '"'.$user['medium_schooling'].'",';
				$row .= '"'.$user['city_residence'].'",';
				$row .= '"'.$user['parent_profiling'].'",';
				$row .= '"'.$user['examination_prepare'].'",';
				$row .= '"'.$user['judgement_point'].'",';
				$row .= '"'.$user['customer_analysis'].'",';
				$row .= '"'.$user['VMC_introduction'].'",';
				$row .= '"'.$user['VOD_solution'].'",';
				$row .= '"'.$user['DN_titution'].'",';
				$row .= '"'.$user['offering'].'",';
				$row .= '"'.$user['product_explanation'].'",';
				$row .= '"'.$user['alternate_contact'].'",';
				$row .= '"'.$user['product_price'].'",';
				$row .= '"'.$user['payee_confirmation'].'",';
				$row .= '"'.$user['probe_to_connect'].'",';
				$row .= '"'.$user['student_course_view'].'",';
				$row .= '"'.$user['buying_hesitation'].'",';
				$row .= '"'.$user['urgency_creation'].'",';
				$row .= '"'.$user['approach_close_sale'].'",';
				$row .= '"'.$user['introduction_payee_segment2'].'",';
				$row .= '"'.$user['student_weakness_segment2'].'",';
				$row .= '"'.$user['product_explaination_segment2'].'",';
				$row .= '"'.$user['product_price_segment2'].'",';
				$row .= '"'.$user['payment_option_segment2'].'",';
				$row .= '"'.$user['parent_view_course_segment2'].'",';
				$row .= '"'.$user['buying_hesitation_segment2'].'",';
				$row .= '"'.$user['creating_urgency_segment2'].'",';
				$row .= '"'.$user['closing_sale_segment2'].'",';
				$row .= '"'.$user['summary_segment2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt30'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt31'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt32'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt33'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt34'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt35'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}else if($process=='doubtnut_p2p'){
			foreach($rr as $user){
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				$row = '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['partner'].'",'; 
				$row .= '"'.$user['student_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['level1generationdate'].'",';
				$row .= '"'.$user['level1generationTMname'].'",';
				$row .= '"'.$user['level1promisedate'].'",';
				$row .= '"'.$user['level1cause'].'",';
				$row .= '"'.$user['level1subcause'].'",';
				$row .= '"'.$user['level1subcausedate'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['level1remarks'])).'",';
				$row .= '"'.$user['level2lastconnectdate'].'",';
				$row .= '"'.$user['level2lastpromisedate'].'",';
				$row .= '"'.$user['level2connectTMname'].'",';
				$row .= '"'.$user['level2cause'].'",';
				$row .= '"'.$user['level2subcause'].'",';
				$row .= '"'.$user['level2subcausedate'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['level2remarks'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}
		
	}
	
	
 }