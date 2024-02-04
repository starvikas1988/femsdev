<?php 

 class Qa_homeadvisor extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
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
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
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
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
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
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
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
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,17) and is_assign_process(id,213)  and status=1  order by name";
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
				
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				if(get_user_fusion_id()=='FELS000025'){
					$cond1 .="";
				}else{
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				if(get_user_fusion_id()=='FJAM004099'){
					$cond1 .=" And office_id='JAM'";
				}else{	
					$cond1 .=" And assigned_to='$current_user'";
				}
			}else{
				$cond1 .="";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_hcco_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_hcco_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
			$data["qa_hcco_data"] = $this->Common_model->get_query_result_array($qSql);			
			
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
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
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
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
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
	
	
	public function agent_hcco_feedback()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_homeadvisor/agent_hcco_feedback.php";
			$data["agentUrl"] = "qa_homeadvisor/agent_hcco_feedback";
			
			
			$qSql="Select count(id) as value from qa_hcco_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_hcco_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_hcco_feedback where id  not in (select fd_id from qa_hcco_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_hcco_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
		
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_hcco_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_hcco_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) order by audit_date";

				$data["agent_hcco_review_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{	
			
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_hcco_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_hcco_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_hcco_agent_rvw) order by audit_date";
				
				$data["agent_hcco_review_list"] = $this->Common_model->get_query_result_array($qSql);			
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
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
						
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_hcco_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) where id='$id'";
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
			
		////////////////////////	
			if($from_date!="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hcci_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			$data["hcci_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
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
				
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
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
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
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
			$data["agentUrl"] = "qa_homeadvisor/agent_hcci_feedback";
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$qSql="Select count(id) as value from qa_hcci_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_hcci_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
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
			}else{
				$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_hcci_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);
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
			
			/* $office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id; */
			
			
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
		$header = array("Auditor Name", "Audit Date", "Time of Call", "Fusion ID", "Agent Name", "L1 Supervisor", "Call Date", "Call Duration", "Consumer1", "Consumer2 (if applicable)", "Consumer3 (if applicable)", "Original SR ID", "New SR ID1", "New SR ID2", "EXT No", "Audit Type", "VOC", "Call Pass/Fail", "Verify Address if possible (Address required on IB Appts) Zip code & Email", "The business needs were met", "Offer to transfer the Consumer to the Service Professional", "Informed the consumer of features and benefits of Angi/HA", "Maintain proper tone word choice and rate of speech. Avoid interrupting in a non-collaborative conversation", "Properly presented pros and asked the consumer how many options they want ", "The advisor asked questions about the project and related projects & included detailed descriptions", "Make sure the Consumer knows what to expect after the call and Do what you said you would do. ", "The advisor accurately updated and noted all SRs", "The correct solution was provided", "The advisor asked for a cross sell", "Correct CTT was submitted and included a detailed description of the project", "Brand Angi/HA somewhere other than the Intro", "Your Name/Verify who you are speaking with HA/Angi Branding and stated recorded line", "Recorded line must be stated in the introduction of the call", "All SRs were submitted with the homeowners knowledge and approval ", "5 Star Rating If yes QA score will increase by 5 percent (manager must review and notify QA of 5 star Stella rating)", "Overall Score","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16","Comments 17", "Call Summary", "Feedback", "Agent Review Date","Agent Fd ACPT", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
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

	
 }