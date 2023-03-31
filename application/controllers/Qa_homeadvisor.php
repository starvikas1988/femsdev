<?php 

 class Qa_homeadvisor extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_philip_model');
	}
	 
	
	private function ha_upload_files($files,$path)
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
	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, (select concat(s.fname, ' ', s.lname) as name from signin s where s.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

//////////////////////////////////////////////////////////////////////////
///////////////////////////// Home Advisor //////////////////////////////
//////////////////////////////////////////////////////////////////////// 
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/qa_homeadvisor_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,17) or is_assign_client (id,69)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$office_id = $this->input->get('office_id');
			$agent_id = $this->input->get('agent_id');
			
			if($office_id=='') $office_id=get_user_office_id();
			
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
			
			$cond="";
			$cond1="";
		
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				if(get_user_fusion_id()=='FELS000025'){
					$cond1 .="";
				}else{
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$cond1 .=" And assigned_to='$current_user'";
			}else{
				$cond1 .="";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_homeadvisor_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_homeadvisor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_homeadvisor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
			$data["qa_homeadvisor_data"] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["office_id"] = $office_id;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,17) or is_assign_client (id,69)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"sale_date" => mmddyy2mysql($this->input->post('sale_date')),
					"ext_no" => $this->input->post('ext_no'),
					"phone" => $this->input->post('phone'),
					"sale_confirm" => $this->input->post('sale_confirm'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"product_communicate" => $this->input->post('product_communicate'),
					"product_explain" => $this->input->post('product_explain'),
					"product_money" => $this->input->post('product_money'),
					"product_lead" => $this->input->post('product_lead'),
					"product_background" => $this->input->post('product_background'),
					"product_look" => $this->input->post('product_look'),
					"product_rating" => $this->input->post('product_rating'),
					"product_email" => $this->input->post('product_email'),
					"product_reinforce" => $this->input->post('product_reinforce'),
					"product_tool" => $this->input->post('product_tool'),
					"product_download" => $this->input->post('product_download'),
					"auto_misconduct" => $this->input->post('auto_misconduct'),
					"auto_hanging" => $this->input->post('auto_hanging'),
					"auto_speaking" => $this->input->post('auto_speaking'),
					"auto_asking" => $this->input->post('auto_asking'),
					"auto_implying" => $this->input->post('auto_implying'),
					"auto_adding" => $this->input->post('auto_adding'),
					"auto_quality" => $this->input->post('auto_quality'),
					"auto_family" => $this->input->post('auto_family'),
					"auto_lead" => $this->input->post('auto_lead'),
					"auto_background" => $this->input->post('auto_background'),
					"auto_poc" => $this->input->post('auto_poc'),
					"auto_manner" => $this->input->post('auto_manner'),
					"auto_jobs" => $this->input->post('auto_jobs'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/homeadvisor_files/');
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_homeadvisor_feedback',$field_array);
				$this->db->last_query();
				die();
				redirect('Qa_homeadvisor');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_homeadvisor_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/mgnt_homeadvisor_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,17) or is_assign_client (id,69)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);		
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_homeadvisor_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["ha_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["haid"]=$id;
			
			$qSql="Select * FROM qa_homeadvisor_mgnt_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_homeadvisor_agent_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('ha_id'))
			{
				$ha_id=$this->input->post('ha_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()!='operations'){
					$field_array = array(
						"call_duration" => $this->input->post('call_duration'),
						"agent_id" => $this->input->post('agent_id'),
						"tl_id" => $this->input->post('tl_id'),
						"sale_date" => mmddyy2mysql($this->input->post('sale_date')),
						"ext_no" => $this->input->post('ext_no'),
						"phone" => $this->input->post('phone'),
						"sale_confirm" => $this->input->post('sale_confirm'),
						"call_type" => $this->input->post('call_type'),
						"audit_type" => $this->input->post('audit_type'),
						"auditor_type" => $this->input->post('auditor_type'),
						"voc" => $this->input->post('voc'),
						"call_pass_fail" => $this->input->post('call_pass_fail'),
						"overall_score" => $this->input->post('overall_score'),
						"product_communicate" => $this->input->post('product_communicate'),
						"product_explain" => $this->input->post('product_explain'),
						"product_money" => $this->input->post('product_money'),
						"product_lead" => $this->input->post('product_lead'),
						"product_background" => $this->input->post('product_background'),
						"product_look" => $this->input->post('product_look'),
						"product_rating" => $this->input->post('product_rating'),
						"product_email" => $this->input->post('product_email'),
						"product_reinforce" => $this->input->post('product_reinforce'),
						"product_tool" => $this->input->post('product_tool'),
						"product_download" => $this->input->post('product_download'),
						"auto_misconduct" => $this->input->post('auto_misconduct'),
						"auto_hanging" => $this->input->post('auto_hanging'),
						"auto_speaking" => $this->input->post('auto_speaking'),
						"auto_asking" => $this->input->post('auto_asking'),
						"auto_implying" => $this->input->post('auto_implying'),
						"auto_adding" => $this->input->post('auto_adding'),
						"auto_quality" => $this->input->post('auto_quality'),
						"auto_family" => $this->input->post('auto_family'),
						"auto_lead" => $this->input->post('auto_lead'),
						"auto_background" => $this->input->post('auto_background'),
						"auto_poc" => $this->input->post('auto_poc'),
						"auto_manner" => $this->input->post('auto_manner'),
						"auto_jobs" => $this->input->post('auto_jobs'),
						"call_summary" => $this->input->post('call_summary'),
						"feedback" => $this->input->post('feedback'),
						"updated_by" => $current_user,
						"updated_date" => $curDateTime
					);
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/homeadvisor_files/');
						$field_array["attach_file"] = implode(',',$a);
					}
				
					$this->db->where('id', $ha_id);
					$this->db->update('qa_homeadvisor_feedback',$field_array);
				}
				
			////////////	
				$field_array1=array(
					"fd_id" => $ha_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_homeadvisor_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $ha_id);
					$this->db->update('qa_homeadvisor_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_homeadvisor');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	

	public function agent_homeadvisor_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_homeadvisor_feedback.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_homeadvisor_feedback";
			
			
			$qSql="Select count(id) as value from qa_homeadvisor_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_homeadvisor_feedback where id  not in (select fd_id from qa_homeadvisor_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_homeadvisor_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_homeadvisor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_homeadvisor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_homeadvisor_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_homeadvisor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_homeadvisor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_homeadvisor_agent_rvw)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_homeadvisor_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_homeadvisor_feedback_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_homeadvisor_feedback";
						
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_homeadvisor_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["ha_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["haid"]=$id;
			
			$qSql="Select * FROM qa_homeadvisor_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_homeadvisor_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('ha_id'))
			{
				$ha_id=$this->input->post('ha_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $ha_id,
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_homeadvisor_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $ha_id);
					$this->db->update('qa_homeadvisor_agent_rvw',$field_array1);
				}	
				redirect('Qa_homeadvisor/agent_homeadvisor_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
//////////////////////////////////////////////////////////////////////////
//////////////////////////////// HCCO ///////////////////////////////////
//////////////////////////////////////////////////////////////////////// 
	public function qa_hcco_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/qa_hcco_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$office_id = $this->input->get('office_id');
			$agent_id = $this->input->get('agent_id');
			
			if($office_id=='') $office_id=get_user_office_id();
			
			$cond="";
			$cond1="";
			
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
		////////////////////
		
			if($from_date!="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
			
			if(get_user_fusion_id()=='FELS000025' || get_user_fusion_id()=='FJAM004099' || get_user_fusion_id()=='FJAM005935'){
				$cond1="";
			}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$cond1 .=" And assigned_to='$current_user'";
			}else{
				$cond1="";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_hcco_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_hcco_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
			$data["qa_hcco_data"] = $this->Common_model->get_query_result_array($qSql);	
		/////////////
			$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_v2_feedback) xx Left Join
			(Select id as sid, fname, lname, fusion_id, office_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
		$data["qa_hcco_v2_data"] = $this->Common_model->get_query_result_array($qSql);
		/////////////
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_sr_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$data["hcco_sr_data"] = $this->Common_model->get_query_result_array($qSql);
		/////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_sr_v2_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$data["hcco_sr_v2_data"] = $this->Common_model->get_query_result_array($qSql);
		////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_flex_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$data["hcco_flex"] = $this->Common_model->get_query_result_array($qSql);	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["office_id"] = $office_id;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_hcco_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_hcco_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"call_time" => $this->input->post('call_time'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"call_type" => $this->input->post('call_type'),
					"can_automated" => $this->input->post('can_automated'),
					"consumer1" => $this->input->post('consumer1'),
					"consumer2" => $this->input->post('consumer2'),
					"consumer3" => $this->input->post('consumer3'),
					"original_sr_id" => $this->input->post('original_sr_id'),
					"new_sr_id1" => $this->input->post('new_sr_id1'),
					"new_sr_id2" => $this->input->post('new_sr_id2'),
					"ext_no" => $this->input->post('ext_no'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"Location_email" => $this->input->post('Location_email'),
					"Business_expectations" => $this->input->post('Business_expectations'),
					"Transfer" => $this->input->post('Transfer'),
					"educate" => $this->input->post('educate'),
					"professionalism" => $this->input->post('professionalism'),
					"Proper_presentation" => $this->input->post('Proper_presentation'),
					"prob" => $this->input->post('prob'),
					"Customer_expectations" => $this->input->post('Customer_expectations'),
					"account_accuracy" => $this->input->post('account_accuracy'),
					"Solution" => $this->input->post('Solution'),
					"Cross_sell" => $this->input->post('Cross_sell'),
					"Correct_CTT" => $this->input->post('Correct_CTT'),
					"Branding" => $this->input->post('Branding'),
					"Introduction" => $this->input->post('Introduction'),
					"recorded_line" => $this->input->post('recorded_line'),
					"acknowledgement" => $this->input->post('acknowledgement'),
					"stella_survey" => $this->input->post('stella_survey'),
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
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"audit_start_time" => $this->input->post('audit_start_time'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/hcco_files/');
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_hcco_feedback',$field_array);
				redirect('Qa_homeadvisor/qa_hcco_feedback');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_hcco_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/mgnt_hcco_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);		
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) where id='$id'";
			$data["hcco_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["hcco_id"]=$id;
			
			$qSql="Select * FROM qa_hcco_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_hcco_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('hcco_id'))
			{
				$hcco_id=$this->input->post('hcco_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				if(get_dept_folder()=="qa"){ 

					$field_array = array(
						"call_time" => $this->input->post('call_time'),
						"agent_id" => $this->input->post('agent_id'),
						"tl_id" => $this->input->post('tl_id'),
						"call_date" => mmddyy2mysql($this->input->post('call_date')),
						"call_duration" => $this->input->post('call_duration'),
						"consumer1" => $this->input->post('consumer1'),
						"consumer2" => $this->input->post('consumer2'),
						"consumer3" => $this->input->post('consumer3'),
						"call_type" => $this->input->post('call_type'),
						"can_automated" => $this->input->post('can_automated'),
						"original_sr_id" => $this->input->post('original_sr_id'),
						"new_sr_id1" => $this->input->post('new_sr_id1'),
						"new_sr_id2" => $this->input->post('new_sr_id2'),
						"ext_no" => $this->input->post('ext_no'),
						"audit_type" => $this->input->post('audit_type'),
						"auditor_type" => $this->input->post('auditor_type'),
						"voc" => $this->input->post('voc'),
						"call_pass_fail" => $this->input->post('call_pass_fail'),
						"overall_score" => $this->input->post('overall_score'),
						"Location_email" => $this->input->post('Location_email'),
						"Business_expectations" => $this->input->post('Business_expectations'),
						"Transfer" => $this->input->post('Transfer'),
						"educate" => $this->input->post('educate'),
						"professionalism" => $this->input->post('professionalism'),
						"Proper_presentation" => $this->input->post('Proper_presentation'),
						"prob" => $this->input->post('prob'),
						"Customer_expectations" => $this->input->post('Customer_expectations'),
						"account_accuracy" => $this->input->post('account_accuracy'),
						"Solution" => $this->input->post('Solution'),
						"Cross_sell" => $this->input->post('Cross_sell'),
						"Correct_CTT" => $this->input->post('Correct_CTT'),
						"Branding" => $this->input->post('Branding'),
						"Introduction" => $this->input->post('Introduction'),
						"recorded_line" => $this->input->post('recorded_line'),
						"acknowledgement" => $this->input->post('acknowledgement'),
						"stella_survey" => $this->input->post('stella_survey'),
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
						"call_summary" => $this->input->post('call_summary'),
						"feedback" => $this->input->post('feedback'),
						"updated_by" => $current_user,
						"updated_date" => $curDateTime
					);
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/hcco_files/');
						$field_array["attach_file"] = implode(',',$a);
					}
				
					$this->db->where('id', $hcco_id);
					$this->db->update('qa_hcco_feedback',$field_array);	
				}
			////////////	
				$field_array1=array(
					"fd_id" => $hcco_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_hcco_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $hcco_id);
					$this->db->update('qa_hcco_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_homeadvisor/qa_hcco_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function add_edit_hcco_v2($hccov2_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_edit_hcco_v2.php";
			$data['hccov2_id']=$hccov2_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT id, concat(fname, ' ', lname) as name, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 order by name ASC";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_hcco_v2_feedback where id='$hccov2_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_v2"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($hccov2_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				//	$field_array['shift_date']=mmddyy2mysql($this->input->post('shift_date'));
					//$field_array['new_sr_date']=mmddyy2mysql($this->input->post('new_sr_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ha_upload_files($_FILES['attach_file'], $path='./qa_files/qa_homeadvisor/hcco_files/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_hcco_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_hcco_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
				//	$field_array1['shift_date']=mmddyy2mysql($this->input->post('shift_date'));
					//$field_array1['new_sr_date']=mmddyy2mysql($this->input->post('new_sr_date'));
					$this->db->where('id', $hccov2_id);
					$this->db->update('qa_hcco_v2_feedback',$field_array1);
				/////////////
					if(get_login_type()=="client"){
						$edit_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $hccov2_id);
					$this->db->update('qa_hcco_v2_feedback',$edit_array);
					
				}
				redirect('qa_homeadvisor/qa_hcco_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	} 

	public function add_edit_hcco_sr($hcco_sr_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_edit_hcco_sr.php";
			$data['hcco_sr_id']=$hcco_sr_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_hcco_sr_feedback where id='$hcco_sr_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_sr"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($hcco_sr_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['shift_date']=mmddyy2mysql($this->input->post('shift_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ha_upload_files($_FILES['attach_file'], $path='./qa_files/qa_homeadvisor/hcco_sr/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_hcco_sr_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_hcco_sr_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array1['shift_date']=mmddyy2mysql($this->input->post('shift_date'));
					$this->db->where('id', $hcco_sr_id);
					$this->db->update('qa_hcco_sr_feedback',$field_array1);
				/////////////
					if(get_login_type()=="client"){
						$edit_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $hcco_sr_id);
					$this->db->update('qa_hcco_sr_feedback',$edit_array);
					
				}
				redirect('qa_homeadvisor/qa_hcco_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	} 

	public function add_edit_hcco_sr_v2($hccosr_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_edit_hcco_sr_v2.php";
			$data['hccosr_id']=$hccosr_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql = "SELECT id, concat(fname, ' ', lname) as name, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 order by name ASC";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_hcco_sr_v2_feedback where id='$hccosr_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_sr"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($hccosr_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['shift_date']=mmddyy2mysql($this->input->post('shift_date'));
					$field_array['new_sr_date']=mmddyy2mysql($this->input->post('new_sr_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ha_upload_files($_FILES['attach_file'], $path='./qa_files/qa_homeadvisor/hcco_sr/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_hcco_sr_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_hcco_sr_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array1['shift_date']=mmddyy2mysql($this->input->post('shift_date'));
					$field_array1['new_sr_date']=mmddyy2mysql($this->input->post('new_sr_date'));
					$this->db->where('id', $hccosr_id);
					$this->db->update('qa_hcco_sr_v2_feedback',$field_array1);
				/////////////
					if(get_login_type()=="client"){
						$edit_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $hccosr_id);
					$this->db->update('qa_hcco_sr_v2_feedback',$edit_array);
					
				}
				redirect('qa_homeadvisor/qa_hcco_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	} 
	
	public function add_edit_hcco_flex($flex_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_edit_hcco_flex.php";
			$data['flex_id']=$flex_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_hcco_flex_feedback where id='$flex_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_flex"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($flex_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ha_upload_files($_FILES['attach_file'], $path='./qa_files/qa_homeadvisor/hcco_flex/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_hcco_flex_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_hcco_flex_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $flex_id);
					$this->db->update('qa_hcco_flex_feedback',$field_array1);
				/////////////
					if(get_login_type()=="client"){
						$edit_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $flex_id);
					$this->db->update('qa_hcco_flex_feedback',$edit_array);
					
				}
				redirect('qa_homeadvisor/qa_hcco_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function agent_hcco_feedback()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcco_feedback.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcco_feedback";
			$campaign='';
			$from_date = '';
			$to_date = '';
			$cond="";

			$campaign=$this->input->get('campaign');

			if($campaign){
			$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql1="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql1);
			
			// $qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			// $data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			// $qSql1="Select count(id) as value from qa_".$campaign."_feedback where id  not in (select fd_id from qa_hcco_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			// $data["yet_rvw"] =  $this->Common_model->get_single_value($qSql1);
		// /////////////
		// 	$sr_Sql1="Select count(id) as value from qa_hcco_sr_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
		// 	$data["tot_sr"] =  $this->Common_model->get_single_value($sr_Sql1);
			
		// 	$sr_Sql2="Select count(id) as value from qa_hcco_sr_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
		// 	$data["yet_sr"] =  $this->Common_model->get_single_value($sr_Sql2);
		// ////////////
		// 	$flex_Sql1="Select count(id) as value from qa_hcco_flex_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
		// 	$data["tot_flex"] =  $this->Common_model->get_single_value($flex_Sql1);
			
		// 	$flex_Sql2="Select count(id) as value from qa_hcco_flex_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
		// 	$data["yet_flex"] =  $this->Common_model->get_single_value($flex_Sql2);
				
			// $from_date = '';
			// $to_date = '';
			// $cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
				// $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_".$campaign."_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_hcco_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_hcco_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) order by audit_date";
			$srSql1 = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_hcco_review_list"] = $this->Common_model->get_query_result_array($srSql1);
			// ///////////
			// 	$srSql1 = "SELECT * from
			// 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			// 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			// 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			// 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_sr_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
			// 	(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			// 	$data["sr_agent_rvw"] = $this->Common_model->get_query_result_array($srSql1);	
			// ///////////
			// 	$flexSql1 = "SELECT * from
			// 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			// 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			// 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			// 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_flex_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
			// 	(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			// 	$data["flex_agent_rvw"] = $this->Common_model->get_query_result_array($flexSql1);
					
			}else{	
			
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_hcco_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_hcco_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_hcco_agent_rvw) order by audit_date";
				$data["agent_hcco_review_list"] = $this->Common_model->get_query_result_array($qSql);
			///////////
			// 	$srSql1="SELECT * from
			// 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			// 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			// 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			// 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_sr_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
			// 	(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
			// 	$data["sr_agent_rvw"] = $this->Common_model->get_query_result_array($srSql1);	
			// ///////////
			// 	$flexSql1="SELECT * from
			// 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			// 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			// 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			// 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_flex_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
			// 	(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
			// 	$data["flex_agent_rvw"] = $this->Common_model->get_query_result_array($flexSql1);
			
			}
		}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['campaign'] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_hcco_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcco_feedback_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcco_feedback";
						
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) where id='$id'";
			$data["hcco_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["hcco_id"]=$id;
			
			$qSql="Select * FROM qa_hcco_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_hcco_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('hcco_id'))
			{
				$hcco_id=$this->input->post('hcco_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $hcco_id,
					"note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_hcco_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $hcco_id);
					$this->db->update('qa_hcco_agent_rvw',$field_array1);
				}	
				redirect('Qa_homeadvisor/agent_hcco_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_hcco_v2_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcco_v2_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcco_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_v2_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_v2"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_hcco_v2_feedback',$field_array1);
					
				redirect('Qa_homeadvisor/agent_hcco_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	public function agent_hcco_flex_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcco_flex_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcco_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_flex_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_flex"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_hcco_flex_feedback',$field_array1);
					
				redirect('Qa_homeadvisor/agent_hcco_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_hcco_sr_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcco_sr_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcco_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_sr_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_sr"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_hcco_sr_feedback',$field_array1);
					
				redirect('Qa_homeadvisor/agent_hcco_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_hcco_sr_v2_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcco_sr_v2_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcco_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcco_sr_v2_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcco_sr"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_hcco_sr_v2_feedback',$field_array1);
					
				redirect('Qa_homeadvisor/agent_hcco_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
//////////////////////////////////////////////////////////////////////////
//////////////////////////////// HCCI ///////////////////////////////////
////////////////////////////////////////////////////////////////////////
	public function hcci(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/qa_hcci_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder='agent') and dept_id=6 and is_assign_client (id,17) and is_assign_process (id,295) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');			
			$office_id = $this->input->get('office_id');
			$agent_id = $this->input->get('agent_id');
			
			//if($office_id=='') $office_id=get_user_office_id();
			
			$cond="";
			$cond1="";
			
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
			
		////////////////////////	
			// if($from_date!="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			// if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if($office_id =='' || $office_id=="All"){
				$cond .= "";
			}else{
				$cond .=" and office_id='$office_id'";
			} 
				
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				if(get_user_fusion_id()=='FELS000025'){
					$cond1 .="";
				}else{
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$cond1 .=" And assigned_to='$current_user'";
			}else{
				$cond1 .="";
			}
		
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcci_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$data["hcci_data"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcci_feedback_new) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$data["hcci_data_new"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcci_core_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$data["hcci_core"] = $this->Common_model->get_query_result_array($qSql);
			
			// print_r($data["hcci_data_new"]);
			// die();
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["office_id"] = $office_id;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_hcci_feedback(){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_hcci_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,17) and is_assign_process (id,295) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
				
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/hcci_files/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_hcci_feedback',$field_array);
				redirect('Qa_homeadvisor/hcci');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	


	public function mgnt_hcci_feedback($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/mgnt_hcci_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,17) and is_assign_process (id,295) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcci_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcci_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/hcci_files/');
					$field_array["attach_file"] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_hcci_feedback',$field_array);
				
			////////////	
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
				$this->db->update('qa_hcci_feedback',$field_array1);
			///////////	
				redirect('Qa_homeadvisor/hcci');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
	public function agent_hcci_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcci_feedback.php";
			$data['content_js'] = 'qa_avon_js.php';
			$data["agentUrl"] = "qa_homeadvisor/agent_hcci_feedback";
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$qSql="Select count(id) as value from qa_hcci_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_hcci_feedback_new where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_new"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_hcci_core_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_core_v2"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_hcci_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_hcci_feedback_new where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw_new"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_hcci_core_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw_core_v2"] =  $this->Common_model->get_single_value($qSql);
				
			if($this->input->get('btnView')=='View')
			{
			
				$fromdate = $this->input->get('from_date');
				if($fromdate!="") $from_date = mmddyy2mysql($fromdate);
				
				$todate = $this->input->get('to_date');
				if($todate!="") $to_date = mmddyy2mysql($todate);
				
				if($from_date !=="" && $to_date!=="" ){ 
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				}else{
					$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				}
				
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_hcci_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_hcci_feedback_new $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list_new"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_hcci_core_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','Certificate Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list_core_v2"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_hcci_feedback where  agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);
				//agent_rvw_date is null and
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_hcci_feedback_new where  agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list_new"] = $this->Common_model->get_query_result_array($qSql);
				//agent_rvw_date is null and
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_hcci_core_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','Certificate Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list_core_v2"] = $this->Common_model->get_query_result_array($qSql);
				//agent_rvw_date is null and 
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_hcci_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcci_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcci_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_hcci_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_hcci_feedback',$field_array);
				
				redirect('Qa_homeadvisor/agent_hcci_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_hcci_rvw_core_v2($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcci_rvw_core_v2.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcci_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_hcci_core_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_hcci_core_feedback',$field_array);
				
				redirect('Qa_homeadvisor/agent_hcci_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


	////////////////////vikas starts/////////////////////////////////////////
	public function add_edit_hcci_core($hcci_id) {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data["content_template"] = "qa_homeadvisor/add_hcci_core_feedback.php";
            $data['content_js'] = 'qa_avon_js.php';
            $data['hcci_id'] = $hcci_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,17) and is_assign_process(id,295) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 order by fname ASC";
            $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT * from
                (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
                (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
                (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
                (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
                from qa_hcci_core_feedback where id='$hcci_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['hcci_data'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $hcci_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    echo"<pre>";
                    print_r($field_array);
                    echo"</pre>";
                    $field_array['audit_date'] = CurrDate();
                   // $field_array['audit_date'] = CurrDateTimeMDY();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_homeadvisor/hcci_files/")){
                        mkdir("./qa_files/qa_homeadvisor/hcci_files/");
                    }
                    $a = $this->ha_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_homeadvisor/hcci_files/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_hcci_core_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_hcci_core_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $hcci_id );
                    $this->db->update( 'qa_hcci_core_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $hcci_id );
                    $this->db->update( 'qa_hcci_core_feedback', $edit_array );

                }
                redirect('Qa_homeadvisor/hcci');
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    public function agent_hcci_core_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcci_core_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcci_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_hcci_core_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_hcci_core_feedback',$field_array);
				
				redirect('Qa_homeadvisor/agent_hcci_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	////////////////////vikas ends/////////////////////////////////////////

	public function add_hcci_feedback_new(){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/add_hcci_feedback_new.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,17) and is_assign_process (id,295) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
				
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/hcci_files/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_hcci_feedback_new',$field_array);
				redirect('Qa_homeadvisor/hcci');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	


	public function mgnt_hcci_feedback_new($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/mgnt_hcci_feedback_new.php";
			$data["content_js"] = "qa_homeadvisor_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,17) and is_assign_process (id,295) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcci_feedback_new where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["hcci_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->ha_upload_files($_FILES['attach_file'],$path='./qa_files/qa_homeadvisor/hcci_files/');
					$field_array["attach_file"] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_hcci_feedback_new',$field_array);
				
			////////////	
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
				$this->db->update('qa_hcci_feedback_new',$field_array1);
			///////////	
				redirect('Qa_homeadvisor/hcci');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_hcci_rvw_new($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcci_rvw_new.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcci_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_hcci_feedback_new where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_hcci_feedback_new',$field_array);
				
				redirect('Qa_homeadvisor/agent_hcci_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


/////////////////////////////////////////////////////////////////////////////////////////// 
	
	public function qa_homeadvisor_report(){
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
			$data["content_template"] = "qa_homeadvisor/qa_homeadvisor_report.php";
			
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$cond2="";
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			$data['pValue']=$pValue;
			
			$data["qa_homeadvisor_list"] = array();
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			
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
			
			$office_id = $this->input->get('office_id');
			
		/////////////////////	
			if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
	
			if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				if(get_user_fusion_id()=='FELS000025'){
					$cond1 .="";
				}else{
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				if(get_user_fusion_id()=='FJAM004099'){
					$cond1 .="";
					$cond2 .=" and office_id='JAM'";
				}else{
					$cond1 .=" And assigned_to='$current_user'";
				}
			}else{
				$cond1 .="";
			}
			
			if($this->input->get('show')=='Show'){
				
				if($pValue=='Home Advisor'){
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_homeadvisor_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_homeadvisor_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_homeadvisor_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
					
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_homeadvisor_list"] = $fullAray;
					$this->create_qa_homeadvisor_CSV($fullAray);	
					$dn_link = base_url()."qa_homeadvisor/download_qa_homeadvisor_CSV";
				
				}elseif($pValue=='HCCI'){
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcci_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_homeadvisor_list"] = $fullAray;
					// $header_arr=$this->Common_model->get_query_result_array("SELECT column_comment FROM information_schema.COLUMNS WHERE table_name = 'qa_hcci_feedback'");
					// $cnt=count($header_arr);

					//  for($i=0;$i<$cnt;$i++){
					// 	$val=$this->getval($header_arr[$i],'column_comment');
					// 	if($val!=""){
					// 		$header[]=$val;
					// 	}		
					//  }
					// array_unshift($header ,"Auditor Name");
					// $key = array_search ('Agent', $header);
					// array_splice($header, $key, 0, 'Fusion Id');
					// print_r($header);
					// die;
					$this->create_qa_hcci_CSV($fullAray);	
					$dn_link = base_url()."qa_homeadvisor/download_qa_hcci_CSV";
					
				}elseif($pValue=='HCCO FLEX'){
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_hcco_flex_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_homeadvisor_list"] = $fullAray;
					$this->create_qa_hcco_flex_CSV($fullAray);	
					$dn_link = base_url()."qa_homeadvisor/download_qa_hcco_flex_CSV";
					
					
				}elseif($pValue=='BCCI'){
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_bcci) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_homeadvisor_list"] = $fullAray;
					$this->qa_bcci_CSV($fullAray);	
					$dn_link = base_url()."qa_homeadvisor/download_qa_bcci_CSV";
				}else{
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_hcco_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_hcco_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 $cond2 order by audit_date";	
					
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_homeadvisor_list"] = $fullAray;
					$this->create_qa_hcco_CSV($fullAray);	
					$dn_link = base_url()."qa_homeadvisor/download_qa_hcco_CSV";
					
				}
				
			}	
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 
	// /////////////////// hcci NEW /////////////////////
	public function download_qa_hcci_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA HCCI Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_hcci_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");		
		$header=array ( "Auditor Name","Audit Date","Fusion Id","Agent","TL Name","Call Date/Time","Call Duration","SR NO.","Consumer No.","Call File","AUDIT TYPE","AUDITOR TYPE","VOC","Overall Score","Introduction must include company name","We attempted to overcome all homeowner objections","Kept call simple and brief by not extending the information provided","We educated homeowner on what will happen after their request is submit","Attempt to gather and accurately submit all SR information for the professional","Do you agree to HomeAdvisor's Terms including that HomeAdvisor","HomeAdvisor and our partners may offer discounts and other offers in the future","Note BETTI if homeowner does not agree to 2nd Consent","Suggestive cross sell offered","Offer contact information and a transfer to pro","Compliance Score","Customer Score","Business Score","Call Summary","Feedback","Entry By","Entry Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent Acceptance Feedback","Agent review note","Agent review date","Client review by","Client review note","Client rvw date");

		$field_name="SHOW FULL COLUMNS FROM qa_hcci_feedback WHERE Comment!=''";
		$field_name=$this->Common_model->get_query_result_array($field_name);
		$fld_cnt=count($field_name);
		for($i=0;$i<$fld_cnt;$i++){
						$val=$field_name[$i]['Field'];
						if($val!=""){
							$field_val[]=$val;
						}		
					 }
		
		array_unshift($field_val ,"auditor_name");
		$key = array_search ('agent_id', $field_val);
		array_splice($field_val, $key, 0, 'fusion_id');
		$field_val=array_values($field_val);

		$count_for_field=count($field_val);

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row = "";
		// print_r($rr);
		// die;
		foreach($rr as $user)
		{	
			for($z=0;$z<$count_for_field;$z++){
				
				if($field_val[$z]==="auditor_name"){
					$row = '"'.$user['auditor_name'].'",';
				}elseif($field_val[$z]==="fusion_id"){
					$row .= '"'.$user['fusion_id'].'",';
				}elseif($field_val[$z]==="agent_id"){
					$row .= '"'.$user['fname']." ".$user['lname'].'",';
				}elseif($field_val[$z]==="tl_id"){
					$row .= '"'.$user['tl_name'].'",';	
				}elseif(in_array($field_val[$z], array('call_summary','feedback','agent_rvw_note','mgnt_rvw_note'))) {
    			
    			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user[$field_val[$z]])).'",';

				}else{
					$row .= '"'.$user[$field_val[$z]].'",';	
				}
				
			}
				
				fwrite($fopen,$row."\r\n");
				$row = "";
		}
		
		fclose($fopen);
	}	

public function getval($arrs, $k) {
    foreach($arrs as $key=>$val) {
        if( $key === $k ) {
            return $val;
        }
        else {
            if(is_array($val)) {
                $ret = $this->getval($val, $k);
                if($ret !== NULL) {
                    return $ret;
                }
            }
        }
    }
    return NULL;
	}


////////////Home Advisor/////////////
	public function download_qa_homeadvisor_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Home Advisor Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_homeadvisor_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Call Duration", "Fusion ID", "Agent Name", "L1 Supervisor", "Sale Date", "EXT Number", "Phone", "Sale Confirmation", "Call Type", "Audit Type", "VOC", "Audit Start Date/Time", "Audit End Date/Time", "Interval(In Second)", "Call Pass/Fail", "Rep clearly communicated that these are leads and not guaranteed jobs", "Rep explains that  SP is only charged for leads they opt into", "Rep clearly communicates the value of opting into leads as the best way to make money with the service", "Rep clearly communicated that SP will be competing on these leads", "Background: Rep communicated the importance of the background check (for homeowners and HA brand)", "Background: Rep communicated what background check looks for (liens judgements bankruptcies felonies)", "Ratings and Reviews: Rep clearly communicated the importance of ratings and reviews and collecte a reference on the sales call", "Lead Response: Rep communicates that leads will be sent via email text message and via mobile app", "Lead Response: Rep reinforces the importance of responding to leads as quickly as possible", "HA Pro App: Rep clearly communicated the importance of the app as the most effective tool for success with HA", "HA Pro App: Rep sent the link to download the HA Pro app on their phone", "Misconduct: Intentionally skirting the screening process", "Falsifying VL: Pressing 1 without the SP specific consent or request OR intentionally hanging up/dropping VL after pressing 2", "Falsifying VL: Speaking over VL at all", "Falsifying VL: Asking SP to hold questions", "Suggesting or implying the SP sign up for multiple accounts", "Adding tasks outside SP scope of work to circumvent licensing requirements", "Misinterpreting lead quality or lead prices", "Implying that friends and family are acceptable for CVRs", "Referring to leads as guaranteed jobs", "Misleading over uses just the background check today", "POC Implies to SP that sales rep can help in any way with credits", "POC Refers to customer care org in a negative manner", "Overusing the word jobs", "Overall Score", "Call Summary", "Feedback", "Agent Review Date","Agent Acceptance Feedback", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['product_communicate']==6) $product_communicate='Yes';
			else if($user['product_communicate']==0) $product_communicate='No';
			else $product_communicate='N/A';
			
			if($user['product_explain']==10) $product_explain='Yes';
			else if($user['product_explain']==0) $product_explain='No';
			else $product_explain='N/A';
			
			if($user['product_money']==15) $product_money='Yes';
			else if($user['product_money']==0) $product_money='No';
			else $product_money='N/A';
			
			if($user['product_lead']==6) $product_lead='Yes';
			else if($user['product_lead']==0) $product_lead='No';
			else $product_lead='N/A';
			
			if($user['product_background']==8) $product_background='Yes';
			else if($user['product_background']==0) $product_background='No';
			else $product_background='N/A';
			
			if($user['product_look']==10) $product_look='Yes';
			else if($user['product_look']==0) $product_look='No';
			else $product_look='N/A';
			
			if($user['product_rating']==10) $product_rating='Yes';
			else if($user['product_rating']==0) $product_rating='No';
			else $product_rating='N/A';
			
			if($user['product_email']==7) $product_email='Yes';
			else if($user['product_email']==0) $product_email='No';
			else $product_email='N/A';
			
			if($user['product_reinforce']==10) $product_reinforce='Yes';
			else if($user['product_reinforce']==0) $product_reinforce='No';
			else $product_reinforce='N/A';
			
			if($user['product_tool']==8) $product_tool='Yes';
			else if($user['product_tool']==0) $product_tool='No';
			else $product_tool='N/A';
			
			if($user['product_download']==10) $product_download='Yes';
			else if($user['product_download']==0) $product_download='No';
			else $product_download='N/A';
			
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval = '---';
			}else{
				$interval = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_duration'].'",';			
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['sale_date'].'",';
			$row .= '"'.$user['ext_no'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['sale_confirm'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval.'",';
			$row .= '"'.$user['call_pass_fail'].'",';
			$row .= '"'.$product_communicate.'",';
			$row .= '"'.$product_explain.'",';
			$row .= '"'.$product_money.'",';
			$row .= '"'.$product_lead.'",';
			$row .= '"'.$product_background.'",';
			$row .= '"'.$product_look.'",';
			$row .= '"'.$product_rating.'",';
			$row .= '"'.$product_email.'",';
			$row .= '"'.$product_reinforce.'",';
			$row .= '"'.$product_tool.'",';
			$row .= '"'.$product_download.'",';
			$row .= '"'.$user['auto_misconduct'].'",';
			$row .= '"'.$user['auto_hanging'].'",';
			$row .= '"'.$user['auto_speaking'].'",';
			$row .= '"'.$user['auto_asking'].'",';
			$row .= '"'.$user['auto_implying'].'",';
			$row .= '"'.$user['auto_adding'].'",';
			$row .= '"'.$user['auto_quality'].'",';
			$row .= '"'.$user['auto_family'].'",';
			$row .= '"'.$user['auto_lead'].'",';
			$row .= '"'.$user['auto_background'].'",';
			$row .= '"'.$user['auto_poc'].'",';
			$row .= '"'.$user['auto_manner'].'",';
			$row .= '"'.$user['auto_jobs'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
////////////HCCO/////////////
	public function download_qa_hcco_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA HCCO Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_hcco_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Time of Call", "Fusion ID", "Agent Name", "L1 Supervisor", "Call Date", "Call Duration", "Consumer1", "Consumer2 (if applicable)", "Consumer3 (if applicable)", "Call Type", "Can be Automated", "Original SR ID", "New SR ID1", "New SR ID2", "EXT No", "Audit Type", "VOC", "Call Pass/Fail", "Verify Address if possible (Address required on IB Appts) Zip code & Email", "The business needs were met", "Offer to transfer the Consumer to the Service Professional", "Informed the consumer of features and benefits of Angi/HA", "Maintain proper tone word choice and rate of speech. Avoid interrupting in a non-collaborative conversation", "Properly presented pros and asked the consumer how many options they want ", "The advisor asked questions about the project and related projects & included detailed descriptions", "Make sure the Consumer knows what to expect after the call and Do what you said you would do. ", "The advisor accurately updated and noted all SRs", "The correct solution was provided", "The advisor asked for a cross sell", "Correct CTT was submitted and included a detailed description of the project", "Brand Angi/HA somewhere other than the Intro", "Your Name/Verify who you are speaking with HA/Angi Branding and stated recorded line", "Recorded line must be stated in the introduction of the call", "All SRs were submitted with the homeowners knowledge and approval ", "5 Star Rating If yes QA score will increase by 5 percent (manager must review and notify QA of 5 star Stella rating)", "Overall Score","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16","Comments 17", "Call Summary", "Feedback", "Agent Review Date","Agent Fd ACPT", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_time'].'",';			
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['consumer1'].'",';
			$row .= '"'.$user['consumer2'].'",';
			$row .= '"'.$user['consumer3'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['can_automated'].'",';
			$row .= '"'.$user['original_sr_id'].'",';
			$row .= '"'.$user['new_sr_id1'].'",';
			$row .= '"'.$user['new_sr_id2'].'",';
			$row .= '"'.$user['ext_no'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['call_pass_fail'].'",';
			$row .= '"'.$user['Location_email'].'",';
			$row .= '"'.$user['Business_expectations'].'",';
			$row .= '"'.$user['Transfer'].'",';
			$row .= '"'.$user['educate'].'",';
			$row .= '"'.$user['professionalism'].'",';
			$row .= '"'.$user['Proper_presentation'].'",';
			$row .= '"'.$user['prob'].'",';
			$row .= '"'.$user['Customer_expectations'].'",';
			$row .= '"'.$user['account_accuracy'].'",';
			$row .= '"'.$user['Solution'].'",';
			$row .= '"'.$user['Cross_sell'].'",';
			$row .= '"'.$user['Correct_CTT'].'",';
			$row .= '"'.$user['Branding'].'",';
			$row .= '"'.$user['Introduction'].'",';
			$row .= '"'.$user['recorded_line'].'",';
			$row .= '"'.$user['acknowledgement'].'",';
			//$row .= '"'.$user['stella_survey'].'",';
			$row .= '"'.$user['stella_survey'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
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
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	
	
	
	public function download_qa_hcco_flex_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA HCCO FLEX Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_hcco_flex_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "Call Date", "Call Duration", "SR Number", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Required all calls - INTRODUCTION", "Required all calls - VERIFICATION", "Required all calls - EXPECTATIONS", "Required all calls - RECORDED LINE", "Required all calls - XM/MMR/IB", "Required Filters - DISPO", "Required Filters - SUBMIT", "Required Filters - PURPOSE", "Required Filters - CROSS SELL", "Required Filters - EDUCATE", "Required Filters - VERIFICATION", "Required Credits - DISPO", "Required Credits - TICKET", "Required Credits - CROSS SELL", "Required Credits - EDUCATE", "Required Credits - PURPOSE", "Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16", "Call Summary", "Feedback", "Agent Review Date","Agent Feedback Acceptance Status", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
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
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['sr_number'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['include_ha_branding'].'",';
			$row .= '"'.$user['correct_contact_information'].'",';
			$row .= '"'.$user['consumer_expect_call'].'",';
			$row .= '"'.$user['call_introduction_recorded'].'",';
			$row .= '"'.$user['mmr_submitted'].'",';
			$row .= '"'.$user['filter_call_disposition'].'",';
			$row .= '"'.$user['appropiate_CTT_consumer'].'",';
			$row .= '"'.$user['call_purposr'].'",';
			$row .= '"'.$user['cross_cell_site'].'",';
			$row .= '"'.$user['educate_HA_work'].'",';
			$row .= '"'.$user['details_ensure_accuracy'].'",';
			$row .= '"'.$user['credit_call_appropiately'].'",';
			$row .= '"'.$user['credit_ticket_information'].'",';
			$row .= '"'.$user['cross_cell_project'].'",';
			$row .= '"'.$user['credit_HA_work'].'",';
			$row .= '"'.$user['credit_call_purpose'].'",';
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

	//Edited By Samrat 17/11/2021
	//BCCI
	public function bcci(){
		if(check_logged_in()){
			$current_user=get_user_id();
			$data['aside_template'] = 'qa/aside.php';
            $data['content_template']="qa_homeadvisor/qa_bcci_feedback.php";
            $data['content_js'] = 'qa_avon_js.php';

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id, 17) and is_assign_process(id,298) and status=1 order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $data['location_list'] = $this->Common_model->get_office_location_list();

            $from_date = $this->input->get( 'from_date' );
            $to_date = $this->input->get( 'to_date' );
            $agent_id = $this->input->get( 'agent_id' );
            $cond = '';
            $ops_cond = '';

            if ( $from_date == '' ) {
                $from_date = CurrDate();
            } else {
                $from_date = mmddyy2mysql( $from_date );
            }

            if ( $to_date == '' ) {
                $to_date = CurrDate();
            } else {
                $to_date = mmddyy2mysql( $to_date );
            }

            if ( $from_date != '' && $to_date !== '' )  $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
            if ( $agent_id != '' )	$cond .= " and agent_id='$agent_id'";

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $ops_cond = " Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $ops_cond = " Where assigned_to='$current_user'";
            } else if ( get_login_type() == 'client' ) {
                $ops_cond = " Where audit_type not in ('Operation Audit','Trainer Audit')";
            } else {
                $ops_cond = '';
            }

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bcci $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
            $data['bcci'] = $this->Common_model->get_query_result_array( $qSql );

            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['agent_id'] = $agent_id;

            $this->load->view( 'dashboard', $data );
		}
	}

	//Common Yes/No dropdown
    public function common_yes_no(){
        return array(
            "1"=>"Yes",
            "2"=>"No",
            "3"=>"N/A"
        );
    }
    //Common Pass Fail
    public function common_pass_fail(){
        return array(
            "1"=>"Pass",
            "2"=>"Fail"
        );
    }

	//Add/Edit BCCI Feedback
	public function add_edit_bcci_audit($bcci_id){
		if(check_logged_in()){
            $current_user = get_user_id();
            $data['aside_template'] = 'qa/aside.php';
            $data['content_template']="qa_homeadvisor/add_edit_bcci_audit.php";
            $data['content_js'] = 'qa_avon_js.php';
            $data['bcci_id'] = $bcci_id;
            $data['common_yes_no']=$this->common_yes_no();
            $data['common_pass_fail']=$this->common_pass_fail();
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id, 17) and is_assign_process(id,298) and status=1  order by name";
            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

            $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_bcci where id='$bcci_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['bcci'] = $this->Common_model->get_query_row_array( $qSql );
            // $data['infraction_types']=$this->infraction_type();
            // $data['aht_acpt']=$this->aht_acpt();

            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $bcci_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_homeadvisor/qa_bcci")){
                        mkdir("./qa_files/qa_homeadvisor/qa_bcci");
                    }
                    $a = $this->bcci_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_homeadvisor/qa_bcci/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_bcci', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_bcci', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $bcci_id );
                    $this->db->update( 'qa_bcci', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $bcci_id );
                    $this->db->update( 'qa_bcci', $edit_array );

                }
                redirect( 'qa_homeadvisor/bcci' );
            }
            $data['array'] = $a;

            $this->load->view( 'dashboard', $data );
        }
	}

	//BCCI Upload Files
    public function bcci_upload_files($files, $path){
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
        $config['max_size'] = '2024000';
        $this->load->library( 'upload', $config );
        $this->upload->initialize( $config );
        $images = array();
        foreach ( $files['name'] as $key => $image ) {
            $_FILES['uFiles']['name'] = $files['name'][$key];
            $_FILES['uFiles']['type'] = $files['type'][$key];
            $_FILES['uFiles']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['uFiles']['error'] = $files['error'][$key];
            $_FILES['uFiles']['size'] = $files['size'][$key];

            if ( $this->upload->do_upload( 'uFiles' ) ) {
                $info = $this->upload->data();
                $ext = $info['file_ext'];
                $file_path = $info['file_path'];
                $full_path = $info['full_path'];
                $file_name = $info['file_name'];
                if ( strtolower( $ext ) == '.wav' ) {

                    $file_name = str_replace( '.', '_', $file_name ).'.mp3';
                    $new_path = $file_path.$file_name;
                    $comdFile = FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
                    $output = shell_exec( $comdFile );
                    sleep( 2 );
                }

                $images[] = $file_name;

            } else {
                return false;
            }
        }
        return $images;
    }

	//BCCI Client Feedback
	public function bcci_qa_report(){
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
			$data["content_template"] = "qa_homeadvisor/bcci_client_report.php";
			$data["content_js"] = "qa_avon_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
            $qSql="";
			
			$data["qa_bcci_list"] = array();
			
			if($this->input->get('show')=='Show'){
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
                (Select *, get_user_name(entry_by) as auditor_name, get_user_name(client_entryby) as client_name, get_user_name(tl_id) as tl_name, get_user_name(mgnt_rvw_by) as mgnt_rvw_name,
                (select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_bcci) xx Left Join
                (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on
                (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
                $fullAray = $this->Common_model->get_query_result_array($qSql);

                $data["qa_bcci_list"] = $fullAray;
				
                $this->qa_bcci_CSV($fullAray);
                
                $dn_link = base_url()."qa_bcci/download_qa_bcci_CSV";
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

    //Download BCCI CSV Report
    public function download_qa_bcci_CSV(){
        $currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA BCCI Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
    }

    //Generate BCCI CSV
    public function qa_bcci_CSV($rr){
        $currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
        $common_yes_no=$this->common_yes_no();
        $common_pass_fail=$this->common_pass_fail();
        $header=array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "Call Duration", "Week", "Audit Type", "Auditor Type", "VOC",
        "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Call QA Score",
        "inContact ID Number",
        "Call File Number",

        "1. You showed willingness to help the customer",
        "2. You used active listening to fully engage and hear the customer out",
        "3. You provided a sincere apology for their pain points",
        "4. You used RRA to isolate and resolve the customers concerns",
        "5. You offered a concise explanation to provide clarity and assurances for the SP",
        "6. You showed appreciation to the professional that was not a part of the call closing",

        "7. You did not interrupt the customer",
        "8. You maintained proper tone word choice and rate of speech during the call",
        "9. You set correct expectations throughout the call",
        "10. You inform the SP of Self Serve options",
        "11. You mentioned all health triggers on the account before the call ended",

        "12. You showed additional willingness to help if the account was 45 days or younger (courtesy credit and/or sought out manager help looked at tenure/ratings/etc.)",
        
        "13. You informed the customer the call may be monitored or recorded if they did not hear it in the IVR",
        "14. Your notes included the name of whom we spoke with a brief professional and accurate summary of the conversation",
        "15. We verified the account by asking for their phone number personal name and business name",
        
        "16. Your introduction was pleasant",
        "17. You asked for permission to proceed with questions and make suggestions ",
        "18. You obtained a CRO",
        "19. During the conversation you mentioned any additional programs features or key points on an account to help provide assistance to the SP",
        "20. The closing was proper and included HA Branding",
        "21. If Stella Survey was received for this interaction did you receive a 5 star rating? If yes QA score will increase by 5 points (manager must review and notify QA of 5 star Stella rating)",
        
        "Call Summary", "Feedback", "Agent Feedback Acceptance",
        "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

        $row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

        foreach($rr as $user){
            $auditorName=($user['entry_by']!="")?$user['auditor_name']:$user['client_name'];
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
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['week'].'",';
            $row .= '"'.$user['audit_type'].'",';
            $row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
            $row .= '"'.$user['overall_score'].'%'.'",';
            $row .= '"'.$user['incontact_ID'].'",';
			$row .= '"'.$user['call_file_number'].'",';

            //BCCI Emotional Currencies QA 
            $row .= '"'.$common_yes_no[$user['willingness_to_help']].'",';
            $row .= '"'.$common_yes_no[$user['active_listening']].'",';
            $row .= '"'.$common_yes_no[$user['sincere_apology']].'",';
            $row .= '"'.$common_yes_no[$user['rra_isolate']].'",';
            $row .= '"'.$common_yes_no[$user['offered_concise']].'",';
            $row .= '"'.$common_yes_no[$user['appreciation_professional']].'",';

            //Engagement
            $row .= '"'.$common_yes_no[$user['interrupt_cust']].'",';
            $row .= '"'.$common_yes_no[$user['maintain_proper_tone']].'",';
            $row .= '"'.$common_yes_no[$user['correct_expect']].'",';
            $row .= '"'.$common_yes_no[$user['inform_sp']].'",';
            $row .= '"'.$common_yes_no[$user['mention_health']].'",';

            //Retention 
            $row .= '"'.$common_yes_no[$user['additional_willingness']].'",';

            //Required
            $row .= '"'.$common_pass_fail[$user['informed_cust_call']].'",';
            $row .= '"'.$common_pass_fail[$user['note_incl_name']].'",';
            $row .= '"'.$common_pass_fail[$user['verified_account']].'",';

            //Coaching
            $row .= '"'.$common_pass_fail[$user['intro_pleasant']].'",';
            $row .= '"'.$common_pass_fail[$user['asked_permission']].'",';
            $row .= '"'.$common_pass_fail[$user['obtain_cro']].'",';
            $row .= '"'.$common_pass_fail[$user['mention_additional_programs']].'",';
            $row .= '"'.$common_pass_fail[$user['proper_closing']].'",';
            $row .= '"'.$common_pass_fail[$user['stella_survey']].'",';

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

	//Agent BCCI Feedback
	public function agent_bcci_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_bcci_feedback.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_bcci_feedback";
			
			$flex_Sql1="Select count(id) as value from qa_bcci where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_bcci"] =  $this->Common_model->get_single_value($flex_Sql1);
			
			$flex_Sql2="Select count(id) as value from qa_bcci where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_bcci"] =  $this->Common_model->get_single_value($flex_Sql2);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			if($this->input->get('btnView')=='View'){
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";

				$bcci_sql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bcci $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["bcci_rvw"] = $this->Common_model->get_query_result_array($bcci_sql);
					
			}else{	
				$bcci_sql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bcci where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["bcci_rvw"] = $this->Common_model->get_query_result_array($bcci_sql);
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}

	//Agent BCCI Review
	public function agent_bcci_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_bcci_feedback_rvw.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_bcci_feedback";

			$data['common_yes_no']=$this->common_yes_no();
            $data['common_pass_fail']=$this->common_pass_fail();

			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_bcci) xx Left Join
			(Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) where id='$id'";
			$data["bcci"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["bcci_id"]=$id;
			
			$qSql="Select * FROM qa_bcci where agnt_fd_acpt!=' ' AND id=$id";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_bcci where mgnt_rvw_by!=' ' AND id=$id";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('bcci_id'))
			{
				$hcco_id=$this->input->post('bcci_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"agent_rvw_date"=>$curDateTime
				);
				$this->db->where('id', $id);
				$this->db->update('qa_bcci',$field_array1);
					
				redirect('Qa_homeadvisor/agent_bcci_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
}
//  }
//  $this->load->view('dashboard',$data);
//  //'dashboard',$data);
// 			}
// 		}
// 	}
// }
//  }$this->db->where('id', $id);
// 				$this->db->update('qa_bcci',$field_array1);
					
// 				redirect('Qa_homeadvisor/agent_bcci_feedback');
				
// 			}else{
// 				$this->load->view('dashboard',$data);
// 			}
// 		}
// 	}
//  }$this->load->view('dashboard',$data);
// 			}
// 		}
// 	}
//  }			$this->load->view('dashboard',$data);
// 			}
// 		}
// 	}
//  }			$this->load->view('dashboard',$data);
// 			}
// 		}
// 	}
//  }gent_bcci_feedback";

// 			$data['common_yes_no']=$this->common_yes_no();
//             $data['common_pass_fail']=$this->common_pass_fail();
// 			$data['commons_pass_fail']=$this->commons_pass_fail();

// 			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
// 			(select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_bcci) xx Left Join
// 			(Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) where id='$id'";
// 			$data["bcci"] = $this->Common_model->get_query_row_array($qSql);
			
// 			$data["bcci_id"]=$id;
			
// 			$qSql="Select * FROM qa_bcci where agnt_fd_acpt!=' ' AND id=$id";
// 			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
// 			$qSql="Select * FROM qa_bcci where mgnt_rvw_by!=' ' AND id=$id";
// 			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
// 			if($this->input->post('bcci_id'))
// 			{
// 				$hcco_id=$this->input->post('bcci_id');
// 				$curDateTime=CurrMySqlDate();
// 				$log=get_logs();
					
// 				$field_array1=array(
// 					"agent_rvw_note" => $this->input->post('note'),
// 					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
// 					"entry_by" => $current_user,
// 					"entry_date" => $curDateTime,
// 					"agent_rvw_date"=>$curDateTime
// 				);
// 				$this->db->where('id', $id);
// 				$this->db->update('qa_bcci',$field_array1);
					
// 				redirect('Qa_homeadvisor/agent_bcci_feedback');
				
// 			}else{
// 				$this->load->view('dashboard',$data);
// 			}
// 		}
// 	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////// Excel Upload Download Process //////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////

		function import_hccicore_excel_data(){
		
			$current_user = '';
			$audit_time = time();
			$audit_start_time = date("Y-m-d h:i:s", $audit_time);
			$this->load->library('excel');
			if(isset($_FILES["file"]["name"])){
			if(check_logged_in())
			{
				$current_user = get_user_id(); 
			}
				
				$path = $_FILES["file"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				$clmarr = array("audit_date","call_date","call_duration","fusion_id","sr_no","consumer_no","call_file","audit_type","auditor_type","voc","overall_score","intorductionIncludeCoName","overcomeAllHomeowner","keptCallSimpleBrief","homeOwnerRequestSubmit","submitAllSRinfo","homeAdvisorTerms","homeAdvisorPertners","noteBETTI","crossSellOfferd","OfferContactInfo","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","call_summary","feedback");
				
				foreach($object->getWorksheetIterator() as $worksheet){
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					
					$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$adjustedColumnIndex = $columnIndex + $adjustment;
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
				
					$dd = array();
					$user_list = array();
					
					for($col=0; $col<$adjustedColumnIndex; $col++){
						$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
						$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
					
						foreach($clmarr as $name){
							if($name == $colindex){
								 $dd[$colindex]  = $adjustedColumn;
							}
						}
					}
					
					//$random_row = round(($highestRow * (20/100)));				
					for($row=2; $row<=$highestRow; $row++){
						foreach($dd as $key=>$d){
							$audit_time1 = time();
							$audit_time_each = date("Y-m-d h:i:s", $audit_time1);
							
							if($key=="audit_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_duration"){
								$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
							}else if($key=="fusion_id"){
								$fusion_id = $worksheet->getCell($d.$row )->getValue();
								 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
								
								$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);
								$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
								$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
								$user_list[$row]['entry_by']   			=  $current_user;
								$user_list[$row]['entry_date']   		=  $audit_time_each;
								//$user_list[$row]['audit_start_time']   	=  $audit_start_time;
								// echo"<pre>";
								// print_r($tl_agent_ids);
								// echo"</pre>";
	
							}
							//else if($key=="actual_talk_time"){
							// 	$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
							// }
							else{
								$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
							}
						}	
					}
	
					// echo"<pre>";
					// print_r($user_list);
					// echo"</pre>";
					// die();
				
					$this->Qa_philip_model->hcci_core_insert_excel($user_list);
					redirect('Qa_homeadvisor/hcci');
				}
			}
		}
	
		function import_hccicx_excel_data(){
			
			$current_user = '';
			$audit_time = time();
			$audit_start_time = date("Y-m-d h:i:s", $audit_time);
			$this->load->library('excel');
			if(isset($_FILES["file"]["name"])){
			if(check_logged_in())
			{
				$current_user = get_user_id(); 
			}
				
				$path = $_FILES["file"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				$clmarr = array("audit_date","call_date","call_duration","fusion_id","sr_no","consumer_no","call_file","call_scenario","audit_type","auditor_type","voc","overall_score","HCCI_introduction","throughout_the_call","Use_RRA","word_choices","felt_found","customer_needs","issues_presented","next_steps","now_acronyms","when_required","brand_the_call","communicated_to_customer","out_of_policy","action_in_Dash","SR_in_BETTI","SR_question","Clear_Insults","CX_Agents","main_issue","tone_of_Voice","Dead_Air","option_available","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","call_summary","feedback");
				
				foreach($object->getWorksheetIterator() as $worksheet){
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					
					$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$adjustedColumnIndex = $columnIndex + $adjustment;
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
				
					$dd = array();
					$user_list = array();
					
					for($col=0; $col<$adjustedColumnIndex; $col++){
						$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
						$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
					
						foreach($clmarr as $name){
							if($name == $colindex){
								 $dd[$colindex]  = $adjustedColumn;
							}
						}
					}
					
					//$random_row = round(($highestRow * (20/100)));				
					for($row=2; $row<=$highestRow; $row++){
						foreach($dd as $key=>$d){
							$audit_time1 = time();
							$audit_time_each = date("Y-m-d h:i:s", $audit_time1);
							
							if($key=="audit_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_duration"){
								$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
							}else if($key=="fusion_id"){
								$fusion_id = $worksheet->getCell($d.$row )->getValue();
								 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
								
								$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);
								$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
								$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
								$user_list[$row]['entry_by']   			=  $current_user;
								$user_list[$row]['entry_date']   		=  $audit_time_each;
								//$user_list[$row]['audit_start_time']   	=  $audit_start_time;
								// echo"<pre>";
								// print_r($tl_agent_ids);
								// echo"</pre>";
	
							}
							//else if($key=="actual_talk_time"){
							// 	$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
							// }
							else{
								$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
							}
						}	
					}
	
					// echo"<pre>";
					// print_r($user_list);
					// echo"</pre>";
					// die();
				
					$this->Qa_philip_model->hcci_cx_insert_excel($user_list);
					redirect('Qa_homeadvisor/hcci');
				}
			}
		}
	
		function import_hcco_excel_data(){

				$current_user = '';
				$audit_time = time();
				//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
				//print_r($this->input->post());
				 $audit_start_time = $this->input->post('star_time');
				$this->load->library('excel');
				if(isset($_FILES["file"]["name"])){
				if(check_logged_in())
				{
					$current_user = get_user_id(); 
				}
		
					$path = $_FILES["file"]["tmp_name"];
					$object = PHPExcel_IOFactory::load($path);
					$clmarr = array("audit_date","call_date","call_duration","fusion_id","consumer1","consumer2","consumer3","original_sr_id","new_sr_id1","new_sr_id2","ext_no","call_type","can_automated","audit_type","auditor_type","voc","call_pass_fail","overall_score","Introduction","Business_expectations","Solution","Location_email","Proper_presentation","Customer_expectations","Cross_sell","Correct_CTT","Branding","Transfer","prob","educate","professionalism","account_accuracy","recorded_line","acknowledgement","stella_survey","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","call_summary","feedback","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent",);
				
				foreach($object->getWorksheetIterator() as $worksheet){
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
	
					$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$adjustedColumnIndex = $columnIndex + $adjustment;
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
	
					$dd = array();
					$user_list = array();
	
					for($col=0; $col<$adjustedColumnIndex; $col++){
						$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
						$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
	
						foreach($clmarr as $name){
							if($name == $colindex){
								 $dd[$colindex]  = $adjustedColumn;
							}
						}
					}
	
					//$random_row = round(($highestRow * (20/100)));                
					for($row=2; $row<=$highestRow; $row++){
						foreach($dd as $key=>$d){
							$audit_time1 = time();
							$audit_time_each = date("Y-m-d h:i:s", $audit_time1);
	
							if($key=="audit_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_duration"){
								$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
							}else if($key=="auditor_mwp_id"){
								$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
							}
							else if($key=="fusion_id"){
								$fusion_id = $worksheet->getCell($d.$row )->getValue();
								 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
	
								$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);
	
	 
	
								// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
								// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);
	
	 
	
								$user_list[$row]['agent_id']             =  $tl_agent_ids['agent_id'];
								$user_list[$row]['tl_id']                =  $tl_agent_ids['tl_id'];
								//$user_list[$row]['entry_by']               =  $current_user;
								//$user_list[$row]['auditor_name']           =  $qa_name['auditor_name'];
								$user_list[$row]['entry_date']           =  $audit_time_each;
								$user_list[$row]['audit_start_time']       =  $audit_start_time;
	
	 
	
							}
							else{
								$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
							}
						}    
					}
	
				
					$this->Qa_philip_model->hcco_insert_excel($user_list);
					redirect('Qa_homeadvisor/qa_hcco_feedback');
				}
			}
		}
	
		function import_hccoflex_excel_data(){
			
			$current_user = '';
				$audit_time = time();
				//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
				//print_r($this->input->post());
				 $audit_start_time = $this->input->post('star_time');
				$this->load->library('excel');
				if(isset($_FILES["file"]["name"])){
				if(check_logged_in())
				{
					$current_user = get_user_id(); 
				}
		
					$path = $_FILES["file"]["tmp_name"];
					$object = PHPExcel_IOFactory::load($path);
				$clmarr = array("audit_date","call_date","call_duration","fusion_id","sr_no","consumer_no","call_file","call_scenario","audit_type","auditor_type","voc","overall_score","HCCI_introduction","throughout_the_call","Use_RRA","word_choices","felt_found","customer_needs","issues_presented","next_steps","now_acronyms","when_required","brand_the_call","communicated_to_customer","out_of_policy","action_in_Dash","SR_in_BETTI","SR_question","Clear_Insults","CX_Agents","main_issue","tone_of_Voice","Dead_Air","option_available","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","call_summary","feedback");
				
				foreach($object->getWorksheetIterator() as $worksheet){
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
	
					$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$adjustedColumnIndex = $columnIndex + $adjustment;
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
	
					$dd = array();
					$user_list = array();
	
					for($col=0; $col<$adjustedColumnIndex; $col++){
						$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
						$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
	
						foreach($clmarr as $name){
							if($name == $colindex){
								 $dd[$colindex]  = $adjustedColumn;
							}
						}
					}
	
					//$random_row = round(($highestRow * (20/100)));                
					for($row=2; $row<=$highestRow; $row++){
						foreach($dd as $key=>$d){
							$audit_time1 = time();
							$audit_time_each = date("Y-m-d h:i:s", $audit_time1);
	
							if($key=="audit_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_date"){
								$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}else if($key=="call_duration"){
								$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
							}else if($key=="auditor_mwp_id"){
								$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
							}
							else if($key=="fusion_id"){
								$fusion_id = $worksheet->getCell($d.$row )->getValue();
								 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
	
								$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);
	
	 
	
								// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
								// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);
	
	 
	
								$user_list[$row]['agent_id']             =  $tl_agent_ids['agent_id'];
								$user_list[$row]['tl_id']                =  $tl_agent_ids['tl_id'];
								//$user_list[$row]['entry_by']               =  $current_user;
								//$user_list[$row]['auditor_name']           =  $qa_name['auditor_name'];
								$user_list[$row]['entry_date']           =  $audit_time_each;
								$user_list[$row]['audit_start_time']       =  $audit_start_time;
	
	 
	
							}
							else{
								$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
							}
						}    
					}
	
	
					// echo"<pre>";
					// print_r($user_list);
					// echo"</pre>";
					// die();
				
					$this->Qa_philip_model->hcco_flex_insert_excel($user_list);
					redirect('Qa_homeadvisor/qa_hcco_feedback');
				}
			}
		}

		/*******************************************************************/
		/*                        UPLOAD DATA                              */
		/*******************************************************************/
		
		public function sample_hccicore_download(){
			if(check_logged_in()){ 
				$file_name = base_url()."qa_files/qa_homeadvisor/hcci_files/hccicore_updated_file.xlsx";
				header("location:".$file_name);	
				exit();
			}
		}
		public function sample_hccicx_download(){
			if(check_logged_in()){ 
				$file_name = base_url()."qa_files/qa_homeadvisor/hcci_files/hccicx_updated_file.xlsx";
				header("location:".$file_name);	
				exit();
			}
		}
	
		public function qa_hccicore_upload_feedback(){
			if(check_logged_in()){
				$current_user = get_user_id(); 
				$user_office = get_user_office_id(); 
				$data["aside_template"] = "qa/aside.php";
				$data["content_template"] = "qa_homeadvisor/qa_hcci_feedback.php";
				$data["content_js"] = "qa_philip_js.php";
				
				$qSql = "Select count(*) as count, date(upload_date) as uplDate from qa_hcci_feedback group by date(upload_date)";
				$data["sampling"] = $this->Common_model->get_query_result_array($qSql);
				
				$this->load->view("dashboard",$data);
			}
		}

		public function qa_hcco_upload_feedback(){
			if(check_logged_in()){
				$current_user = get_user_id(); 
				$user_office = get_user_office_id(); 
				$data["aside_template"] = "qa/aside.php";
				$data["content_template"] = "qa_homeadvisor/qa_hcco_feedback.php";
				$data["content_js"] = "qa_philip_js.php";
				
				$qSql = "Select count(*) as count, date(upload_date) as uplDate from qa_hcco_feedback group by date(upload_date)";
				$data["sampling"] = $this->Common_model->get_query_result_array($qSql);
				
				$this->load->view("dashboard",$data);
			}
		}
	
		public function sample_hcco_download(){
			if(check_logged_in()){ 
				$file_name = base_url()."qa_files/qa_homeadvisor/hcco_files/hcco_updated_file.xlsx";
				header("location:".$file_name);	
				exit();
			}
		}
		public function sample_hcco_flex_download(){
			if(check_logged_in()){ 
				$file_name = base_url()."qa_files/qa_homeadvisor/hcco_files/hccoflex_updated_file.xlsx";
				header("location:".$file_name);	
				exit();
			}
		}
	
		// public function remove_data_loanxm_upload_freshdesk(){
		// 	if(check_logged_in()){
		// 		$up_date = $this->input->get('up_date');
		// 		$sql  = "DELETE FROM qa_randamiser_cdr_data WHERE DATE(upload_date)='".$up_date."'";
		// 		//echo $sql;exit;
		// 		$this->db->query($sql);
		// 		redirect('qa_sop_library/data_cdr_upload_freshdesk');
		// 	}
		// }


  }