<?php 
  
 class Qa_premium extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function premium_upload_files($files,$path)
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
			$data["content_template"] = "qa_premium/qa_premium_feedback.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,343) and is_assign_process(id,717) and status=1 order by name";
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["premium"] = $this->Common_model->get_query_result_array($qSql);
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_sq_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["premium_sq"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_mc_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["premium_mc"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_vbc_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["premium_vbc"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_premium($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/add_edit_premium.php";
			// $data["content_js"] = "qa_loanxm_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data['loanxm_id']=$loanxm_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,343) and is_assign_process(id,717) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_premium_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["premium"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($loanxm_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->premium_upload_files($_FILES['attach_file'], $path='./qa_files/qa_premium/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_premium_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_premium_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_feedback',$field_array1);
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
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_feedback',$edit_array);
					
				}
				redirect('qa_premium');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_premium_sq($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/add_edit_premium_sq.php";
			// $data["content_js"] = "qa_loanxm_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data['loanxm_id']=$loanxm_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,343) and is_assign_process(id,746) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_premium_sq_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["premium_sq"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($loanxm_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->premium_upload_files($_FILES['attach_file'], $path='./qa_files/qa_premium/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_premium_sq_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_premium_sq_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_sq_feedback',$field_array1);
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
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_sq_feedback',$edit_array);
					
				}
				redirect('qa_premium');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_premium_mc($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/add_edit_premium_mc.php";
			// $data["content_js"] = "qa_loanxm_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data['loanxm_id']=$loanxm_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,343) and is_assign_process(id,747) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_premium_mc_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["premium_mc"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($loanxm_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->premium_upload_files($_FILES['attach_file'], $path='./qa_files/qa_premium/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_premium_mc_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_premium_mc_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_mc_feedback',$field_array1);
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
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_mc_feedback',$edit_array);
					
				}
				redirect('qa_premium');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_premium_vbc($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/add_edit_premium_vbc.php";
			// $data["content_js"] = "qa_loanxm_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data['loanxm_id']=$loanxm_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,343) and is_assign_process(id,748) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_premium_vbc_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["premium_vbc"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($loanxm_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->premium_upload_files($_FILES['attach_file'], $path='./qa_files/qa_premium/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_premium_vbc_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_premium_vbc_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_vbc_feedback',$field_array1);
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
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_premium_vbc_feedback',$edit_array);
					
				}
				redirect('qa_premium');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/*------------------- Agent Part ---------------------*/
	public function agent_premium_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/agent_premium_feedback.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_premium/agent_premium_feedback";
			$campaign="";
			$campaign = $this->input->get('campaign');
			
			
			$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['campaign']=$campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_premium_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/agent_premium_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_premium/agent_premium_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["premium"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_premium_feedback',$field_array1);
					
				redirect('qa_premium/agent_premium_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_premium_sq_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/agent_premium_sq_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_premium/agent_premium_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_sq_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["premium_sq"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_premium_sq_feedback',$field_array1);
					
				redirect('qa_premium/agent_premium_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_premium_mc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/agent_premium_mc_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_premium/agent_premium_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_mc_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["premium_mc"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_premium_mc_feedback',$field_array1);
					
				redirect('qa_premium/agent_premium_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_premium_vbc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_premium/agent_premium_vbc_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_premium/agent_premium_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_premium_vbc_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["premium_vbc"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_premium_vbc_feedback',$field_array1);
					
				redirect('qa_premium/agent_premium_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function qa_premium_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_qa/aside.php";
			$data["content_template"] = "reports_qa/qa_premium_report.php";
			$data["content_js"] = "qa_metropolis_js.php";

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$campaign = $this->input->get('campaign');
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";

			$data["qa_premium_list"] = array();

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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_premium_list"] = $fullAray;
				$this->create_qa_premium_CSV($fullAray,$campaign);
				$dn_link = base_url()."qa_premium/download_qa_premium_CSV/".$campaign;
			}

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			$data['office_id']=$office_id;
			$data['campaign']=$campaign;
			$this->load->view('dashboard',$data);
		}
	}


	public function download_qa_premium_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_premium_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "qa_premium";
		

		$fopen = fopen($filename,"w+");
		if($campaign == 'premium')
		{
		$edit_url = "add_edit_premium";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;

		$header = array( "Auditor Name","Audit Date",
		  "Chat Date",
		  "Fusion ID",
		  "Agent","L1 Super","Ticket ID","Call ID",
		  "Chat Duration",
		  "Audit Type",
		  "VOC",
		  "Audit Link",
		  "Audit Start Date Time",
		  "Audit End Date Time",
		  "Earned Score",
		  "Possible Score",
		  "Overall Score",
		  "Agents need to state their names and the company's name as it appears on the script","Comments 1",
		  "Agents need to be professional","Comments 2",
		  "Agents need to speak at a moderate pace","Comments 3",
		  "Agents need to listen to clients and address the questions","Comments 4",
		  "verifying personal information","Comments 5",
		  "properly qualifying the clients for the program query/concern","Comments 6",
		  "Agents MUST read the script verbatim Agents need to ask consumer if they understand benefits after presenting benefits accurately","Comments 7",
		  "Confirmation statement MUST be be read word for word as well as the hand-off script","Comments 8",
		  
		   "Call Summary",
		   "Feedback",
		   "Agent Feedback Acceptance",
		  "Agent review note","Agent review date","Mgnt review date","Mgnt review by","Mgnt review note");

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
			$main_urls = $main_url.'/'.$user['id'];
				$row = '"'.$user['auditor_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
        		$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
        		$row .= '"'.$user['tl_name'].'",';
        		$row .= '"'.$user['ticket_id'].'",';
        		$row .= '"'.$user['call_id'].'",';      		
        		$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				//$row .= '"'.$interval1.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['script'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['professional'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['pace'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['questions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['information'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['program'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['accurately'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['Confirmation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				
				
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
        		$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
		
	}elseif($campaign == 'premium_sq')
	{
		$edit_url = "add_edit_premium_sq";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;

		$header = array( "Auditor Name","Audit Date",
		"Chat Date",
		"Fusion ID",
		"Agent","L1 Super","Ticket ID","Call ID",
		"Chat Duration",
		"Audit Type",
		"VOC",
		"Audit Link",
		"Audit Start Date Time",
		"Audit End Date Time",
		"Earned Score",
		"Possible Score",
		"Overall Score",
		"Agent mentioned his/her name campaign and determined speaking to correct person","Comments 1",
		"Agent mentioned the reason for the call verbatim.","Comments 2",
		"Practiced extreme courtesy towards the customer showed Empathy/Sympathy as needed on the call","Comments 3",
		"Demonstrated call control effectively throughout the call by listening and acknowledging the customers needs  explicit and implicit","Comments 4",
		"Maintained friendly demeanor build rapport and connected with the customer","Comments 5",
		"Agent communicates effectively and doesnt have a negative effect to overall customer experience","Comments 6",
		"The agent voice is clear and can be understood throughout the call.","Comments 7",
		"The agent used appropriate use of transitional phases","Comments 8",
		"The agent speaks with a strong steady speed or pace. Mirroring the customers pace and avoided speaking over the customer","Comments 9",
		"Did the agent read the TPMO VERBATIM? strictly compliance","Comments 10",
		"Accurately prequalified customer if they dont have TRICARE and Retirement Plan and if the caller is ages between 64 1/2  78 and making sure they have active Medicare A&B","Comments 11",
		"Displayed knowledge of the product tied features to benefits","Comments 12",
		"Appropriate managed and handled objections the agent used appropriate rebuttals and provides a solution removing obstacles in the wat to guide a purchase decision at the time","Comments 13",
		"Agent successfully transfer the call and read the Confimation statement and hand-off verbatim. strictly compliance","Comments 14",
		"Properly disposed the call to keep track of the outcomes of the call.","Comments 15",
		"Compliance Score Percent",
		"Customer Score Percent",
		"Business Score Percent",
		 "Call Summary",
		 "Feedback",
		 "Agent Feedback Acceptance",
		"Agent review note","Agent review date","Mgnt review date","Mgnt review by","Mgnt review note");

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
		  $main_urls = $main_url.'/'.$user['id'];
			  $row = '"'.$user['auditor_name'].'",';
			  $row .= '"'.$user['audit_date'].'",';
			  $row .= '"'.$user['call_date'].'",';
			  $row .= '"'.$user['fusion_id'].'",';
			  $row .= '"'.$user['fname']." ".$user['lname'].'",';
			  $row .= '"'.$user['tl_name'].'",';
			  $row .= '"'.$user['ticket_id'].'",';
			  $row .= '"'.$user['call_id'].'",';      		
			  $row .= '"'.$user['call_duration'].'",';
			  $row .= '"'.$user['audit_type'].'",';
			  $row .= '"'.$user['voc'].'",';
			  $row .= '"'.$main_urls.'",';
			  $row .= '"'.$user['audit_start_time'].'",';
			  $row .= '"'.$user['entry_date'].'",';
			  //$row .= '"'.$interval1.'",';
			  $row .= '"'.$user['earned_score'].'",';
			  $row .= '"'.$user['possible_score'].'",';
			  $row .= '"'.$user['overall_score'].'%'.'",';
			  $row .= '"'.$user['script'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			  $row .= '"'.$user['professional'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			  $row .= '"'.$user['sympathy'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			  $row .= '"'.$user['pace'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			  $row .= '"'.$user['questions'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			  $row .= '"'.$user['information'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			  $row .= '"'.$user['throughout_call'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			  $row .= '"'.$user['transitional'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			  $row .= '"'.$user['program'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			  $row .= '"'.$user['accurately'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			  $row .= '"'.$user['retiree_plan'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			  $row .= '"'.$user['Confirmation'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			  $row .= '"'.$user['rebuttals'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			  $row .= '"'.$user['verbatim'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			  $row .= '"'.$user['outcomes_call'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			  $row .= '"'.$user['compliance_score_percent'].'%'.'",';
			  $row .= '"'.$user['customer_score_percent'].'%'.'",';
			  $row .= '"'.$user['business_score_percent'].'%'.'",';			  
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			  $row .= '"'.$user['agnt_fd_acpt'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			  $row .= '"'.$user['agent_rvw_date'].'",';
			  $row .= '"'.$user['mgnt_rvw_date'].'",';
			  $row .= '"'.$user['mgnt_rvw_name'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
		  fwrite($fopen,$row."\r\n");
	  }
	  fclose($fopen);

	}elseif($campaign == 'premium_mc')
	{
		$edit_url = "add_edit_premium_mc";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;

		$header = array( "Auditor Name","Audit Date",
		"Chat Date",
		"Fusion ID",
		"Agent","L1 Super","Ticket ID","Call ID",
		"Chat Duration",
		"Audit Type",
		"VOC",
		"Audit Link",
		"Audit Start Date Time",
		"Audit End Date Time",
		"Earned Score",
		"Possible Score",
		"Overall Score",
		"Agent mentioned his/her name campaign and determined speaking to correct person","Comments 1",
		"Agent mentioned the reason for the call verbatim.","Comments 2",
		"Practiced extreme courtesy towards the customer showed Empathy/Sympathy as needed on the call","Comments 3",
		"Demonstrated call control effectively throughout the call by listening and acknowledging the customers needs  explicit and implicit","Comments 4",
		"Maintained friendly demeanor build rapport and connected with the customer","Comments 5",
		"Agent communicates effectively and doesnt have a negative effect to overall customer experience","Comments 6",
		"The agent voice is clear and can be understood throughout the call.","Comments 7",
		"The agent used appropriate use of transitional phases","Comments 8",
		"The agent speaks with a strong steady speed or pace. Mirroring the customers pace and avoided speaking over the customer","Comments 9",
		"Did the agent read the TPMO VERBATIM? strictly compliance","Comments 10",
		"Accurately prequalified customer if they dont have TRICARE and Retirement Plan and if the caller is ages between 64 1/2  79 and making sure they have active Medicare A&B","Comments 11",
		"Displayed knowledge of the product tied features to benefits","Comments 12",
		"Appropriate managed and handled objections the agent used appropriate rebuttals and provides a solution removing obstacles in the wat to guide a purchase decision at the time","Comments 13",
		"Agent successfully transfer the call and read the Confimation statement and hand-off verbatim. strictly compliance","Comments 14",
		"Properly disposed the call to keep track of the outcomes of the call.","Comments 15",
		"Compliance Score Percent",
		"Customer Score Percent",
		"Business Score Percent",
		 "Call Summary",
		 "Feedback",
		 "Agent Feedback Acceptance",
		"Agent review note","Agent review date","Mgnt review date","Mgnt review by","Mgnt review note");

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
		      $main_urls = $main_url.'/'.$user['id'];
			  $row = '"'.$user['auditor_name'].'",';
			  $row .= '"'.$user['audit_date'].'",';
			  $row .= '"'.$user['call_date'].'",';
			  $row .= '"'.$user['fusion_id'].'",';
			  $row .= '"'.$user['fname']." ".$user['lname'].'",';
			  $row .= '"'.$user['tl_name'].'",';
			  $row .= '"'.$user['ticket_id'].'",';
			  $row .= '"'.$user['call_id'].'",';      		
			  $row .= '"'.$user['call_duration'].'",';
			  $row .= '"'.$user['audit_type'].'",';
			  $row .= '"'.$user['voc'].'",';
			  $row .= '"'.$main_urls.'",';
			  $row .= '"'.$user['audit_start_time'].'",';
			  $row .= '"'.$user['entry_date'].'",';
			  //$row .= '"'.$interval1.'",';
			  $row .= '"'.$user['earned_score'].'",';
			  $row .= '"'.$user['possible_score'].'",';
			  $row .= '"'.$user['overall_score'].'%'.'",';
			  $row .= '"'.$user['script'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			  $row .= '"'.$user['professional'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			  $row .= '"'.$user['sympathy'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			  $row .= '"'.$user['pace'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			  $row .= '"'.$user['questions'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			  $row .= '"'.$user['information'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			  $row .= '"'.$user['throughout_call'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			  $row .= '"'.$user['transitional'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			  $row .= '"'.$user['program'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			  $row .= '"'.$user['accurately'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			  $row .= '"'.$user['retiree_plan'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			  $row .= '"'.$user['Confirmation'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			  $row .= '"'.$user['rebuttals'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			  $row .= '"'.$user['verbatim'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			  $row .= '"'.$user['outcomes_call'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			  $row .= '"'.$user['compliance_score_percent'].'%'.'",';
			  $row .= '"'.$user['customer_score_percent'].'%'.'",';
			  $row .= '"'.$user['business_score_percent'].'%'.'",';	
			  
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			  $row .= '"'.$user['agnt_fd_acpt'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			  $row .= '"'.$user['agent_rvw_date'].'",';
			  $row .= '"'.$user['mgnt_rvw_date'].'",';
			  $row .= '"'.$user['mgnt_rvw_name'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
		  fwrite($fopen,$row."\r\n");
	  }
	  fclose($fopen);

	}elseif($campaign == 'premium_vbc')
	{
		$edit_url = "add_edit_premium_vbc";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;

		$header = array( "Auditor Name","Audit Date",
		"Chat Date",
		"Fusion ID",
		"Agent","L1 Super","Ticket ID","Call ID",
		"Chat Duration",
		"Audit Type",
		"VOC",
		"Audit Link",
		"Audit Start Date Time",
		"Audit End Date Time",
		"Earned Score",
		"Possible Score",
		"Overall Score",
		"Agent mentioned his/her name campaign and determined speaking to correct person","Comments 1",
		"Agent mentioned the reason for the call.","Comments 2",
		"Practiced extreme courtesy towards the customer showed Empathy/ Sympathy as needed on the call","Comments 3",
		"Demonstrated call control effectively throughout the call by listening and acknowledging the customers needs explicit and implicit","Comments 4",
		"Maintained friendly demeanor built rapport and connected with the customer","Comments 5",
		"The agent speaks with a strong steady speed or pace mirroring the customers pace and avoided speaking over the customer.","Comments 6",
		"The agents voice is clear and can be understood throughout the call.","Comments 7",
		"Did the agent read the confimation statement verbatim","Comments 8",
		"Accurately prequalified customer if they have medicare parts A&B and if they have secondary insurance.","Comments 9",
		"Displayed knowledge of the product tied features to benefits.","Comments 10",
		"Appropriately managed and handled objections The agent used appropriate rebuttals and provides a solution removing obstacles in the way to guide a purchase decision at that time","Comments 11",
		"Agent successfully transfer the call and read the hand off verbatim. strictly compliance","Comments 12",
		"Properly disposed the call to keep track of the outcomes of the call.","Comments 13",
		"Compliance Score Percent",
		"Customer Score Percent",
		"Business Score Percent",
		 "Call Summary",
		 "Feedback",
		 "Agent Feedback Acceptance",
		"Agent review note","Agent review date","Mgnt review date","Mgnt review by","Mgnt review note");

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
		  	  $main_urls = $main_url.'/'.$user['id'];
			  $row = '"'.$user['auditor_name'].'",';
			  $row .= '"'.$user['audit_date'].'",';
			  $row .= '"'.$user['call_date'].'",';
			  $row .= '"'.$user['fusion_id'].'",';
			  $row .= '"'.$user['fname']." ".$user['lname'].'",';
			  $row .= '"'.$user['tl_name'].'",';
			  $row .= '"'.$user['ticket_id'].'",';
			  $row .= '"'.$user['call_id'].'",';      		
			  $row .= '"'.$user['call_duration'].'",';
			  $row .= '"'.$user['audit_type'].'",';
			  $row .= '"'.$user['voc'].'",';
			  $row .= '"'.$main_urls.'",';
			  $row .= '"'.$user['audit_start_time'].'",';
			  $row .= '"'.$user['entry_date'].'",';
			  //$row .= '"'.$interval1.'",';
			  $row .= '"'.$user['earned_score'].'",';
			  $row .= '"'.$user['possible_score'].'",';
			  $row .= '"'.$user['overall_score'].'%'.'",';
			  $row .= '"'.$user['script'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			  $row .= '"'.$user['professional'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			  $row .= '"'.$user['sympathy'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			  $row .= '"'.$user['pace'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			  $row .= '"'.$user['questions'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			  $row .= '"'.$user['information'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			  $row .= '"'.$user['program'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			  $row .= '"'.$user['accurately'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			  $row .= '"'.$user['retiree_plan'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			  $row .= '"'.$user['Confirmation'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			  $row .= '"'.$user['verbatim'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			  $row .= '"'.$user['rebuttals'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			  $row .= '"'.$user['outcomes_call'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			  $row .= '"'.$user['compliance_score_percent'].'%'.'",';
			  $row .= '"'.$user['customer_score_percent'].'%'.'",';
			  $row .= '"'.$user['business_score_percent'].'%'.'",';	
			  
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			  $row .= '"'.$user['agnt_fd_acpt'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			  $row .= '"'.$user['agent_rvw_date'].'",';
			  $row .= '"'.$user['mgnt_rvw_date'].'",';
			  $row .= '"'.$user['mgnt_rvw_name'].'",';
			  $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
		  fwrite($fopen,$row."\r\n");
	  }
	  fclose($fopen);
	  
	
	  
	}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////

	
	
 }
