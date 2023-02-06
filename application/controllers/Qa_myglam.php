<?php 
  
 class Qa_myglam extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function myglam_upload_files($files,$path)
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
			$data["content_template"] = "qa_myglam/qa_myglam_feedback.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,339) and is_assign_process(id,713) and status=1 order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["myglam"] = $this->Common_model->get_query_result_array($qSql);

			$qSql_new = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["myglam_new"] = $this->Common_model->get_query_result_array($qSql_new);
		
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_myglam($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_myglam/add_edit_myglam.php";
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
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,339) and is_assign_process(id,713) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_myglam_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["myglam"] = $this->Common_model->get_query_row_array($qSql);
			
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
					$a = $this->myglam_upload_files($_FILES['attach_file'], $path='./qa_files/qa_myglam/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_myglam_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_myglam_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_myglam_feedback',$field_array1);
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
					$this->db->update('qa_myglam_feedback',$edit_array);
					
				}
				redirect('qa_myglam');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_new_myglam($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_myglam/add_edit_new_myglam.php";
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
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,339) and is_assign_process(id,713) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_myglam_new_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["myglam"] = $this->Common_model->get_query_row_array($qSql);
			
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
					$a = $this->myglam_upload_files($_FILES['attach_file'], $path='./qa_files/qa_myglam/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_myglam_new_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_myglam_new_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_myglam_new_feedback',$field_array1);
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
					$this->db->update('qa_myglam_new_feedback',$edit_array);
					
				}
				redirect('qa_myglam');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
	
/*------------------- Agent Part ---------------------*/
	public function agent_myglam_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_myglam/agent_myglam_feedback.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_myglam/agent_myglam_feedback";
			
			
			$qSql="Select count(id) as value from qa_myglam_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_myglam_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_myglam_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_new_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_myglam_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_new_rvw"] =  $this->Common_model->get_single_value($qSql);
		
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql_new = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_new_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_new_list"] = $this->Common_model->get_query_result_array($qSql_new);
			
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql_new="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_new_list"] = $this->Common_model->get_query_result_array($qSql_new);
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_myglam_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_myglam/agent_myglam_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_myglam/agent_myglam_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["myglam"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_myglam_feedback',$field_array1);
					
				redirect('qa_myglam/agent_myglam_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_myglam_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_myglam/agent_myglam_new_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "qa_myglam/agent_myglam_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_myglam_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["myglam"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_myglam_new_feedback',$field_array1);
					
				redirect('qa_myglam/agent_myglam_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	


	public function qa_myglam_report(){
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
			$data["content_template"] = "qa_myglam/qa_myglam_report.php";
			$data["content_js"] = "qa_metropolis_js.php";

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_table="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$audit_table = $this->input->get('audit_table');

			$data["qa_myglam_list"] = array();

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

				if($audit_table == 'qa_myglam_new_feedback')
				{
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_myglam_new_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_myglam_list"] = $fullAray;
					$this->create_qa_myglam_new_CSV($fullAray);
					$dn_link = base_url()."qa_myglam/download_qa_myglam_new_CSV";
				}
				if($audit_table == 'qa_myglam_feedback'){
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_myglam_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_myglam_list"] = $fullAray;
					$this->create_qa_myglam_CSV($fullAray);
					$dn_link = base_url()."qa_myglam/download_qa_myglam_CSV";
				}
				
			}

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data["audit_table"] = $audit_table;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			$data['office_id']=$office_id;

			$this->load->view('dashboard',$data);
		}
	}


	public function download_qa_myglam_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Myglam Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_myglam_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array( "Auditor Name","Audit Date",
		  "Chat Date",
		  "Fusion ID",
		  "Agent","L1 Super","Objection","Campaign","Product","Chat ID","Customer Voc","Agent Disposition","QA Disposition",
		  "Chat Duration",
		  "Audit Type",
		  "VOC",
		  "Audit Start Date Time",
		  "Audit End Date Time",
		  "Possible Score", 
		  "Earned Score",
		  "QA Score",
		  "Did the Advisor open the chat correctly","Comments 1",
		  "Did the advisor greet the client in a timely manner","Comments 2",
		  "Did the Advisor seek permission from customer to keep the chat on hold and showed presence to keep conversation active","Comments 3",
		  "Did the Advisor understand the customer query","Comments 4",
		  "Did Advisor edit /use relevant canned responses","Comments 5",
		  "Did the Advisor provide correct/complete information to resolve customers' query/concern","Comments 6",
		  "Did the Advisor use upfront Empathy/Apology and correct choice of words","Comments 7",
		  "Did the Advisor personalize during chat conversation","Comments 8",
		  "Did the Advisor use accurate Sentence formation Grammar Punctuation Tenses Spellings & avoid usage of jargons during chat?","Comments 9",
		  "Did the Advisor switch the language as per the requirement","Comments 10",
		  "Did the advisor recommend the correct product as per the concern?","Comments 11",
		  "Did the advisor attempt for upselling?","Comments 12",
		  "Did the advisor share UTM link/correct UTM link?","Comments 13",
		  "Did the advisor shared relevant product usage and benefits?","Comments 14",
		  "Did the Advisor use the correct disposition/Tagging as per the conversation along with remarks?","Comments 15",
		  "Did the Advisor inform the correct TAT?","Comments 16",
		  "Did the Advisor ask for Further assistance","Comments 17",
		  "Did the adviser keep the chat open for more than five minutes?","Comments 18",
		  "Did the Advisor close the chat properly/ followed the closing procedure","Comments 19",
		  "Did the advisor share the reference Link","Comments 20",
		  "No instance of chat avoidance or wrong practice followed?","Comments 21",
		  "The Advisor was professional during chat?","Comments 22",
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

				$row = '"'.$user['auditor_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
        		$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
        		$row .= '"'.$user['tl_name'].'",';
        		$row .= '"'.$user['objection'].'",';
        		$row .= '"'.$user['campaign'].'",';
        		$row .= '"'.$user['Product'].'",';
        		$row .= '"'.$user['chat_id'].'",';
        		$row .= '"'.$user['customer_voc'].'",';
        		$row .= '"'.$user['agent_disposition'].'",';
        		$row .= '"'.$user['qa_disposition'].'",';
        		$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				//$row .= '"'.$interval1.'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['chat_correctly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['timely_manner'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['conversation_active'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['understand_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['canned_responses'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['query_concern'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['Communication1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['Communication2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['Communication3'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['Communication4'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['Communication5'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['Communication6'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['Communication7'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['Communication8'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['Documentation1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['Documentation2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'.$user['Closing1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'.$user['Closing2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'.$user['Closing3'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'.$user['Closing4'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'.$user['Practices1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'.$user['Practices2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';


				
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
 ////////////////////////////new///////////////////////////////////////

	public function download_qa_myglam_new_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Myglam Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_myglam_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array( "Auditor Name","Audit Date",
		  "Chat Date",
		  "Fusion ID",
		  "Agent","L1 Super","Objection","Campaign","Product","Chat ID","Customer Voc","Agent Disposition","QA Disposition",
		  "Chat Duration",
		  "Audit Type",
		  "VOC",
		  "Audit Start Date Time",
		  "Audit End Date Time",
		  "Possible Score", 
		  "Earned Score",
		  "QA Score",
		  "Did the Advisor open the chat correctly","Comments 1",
		  "Did the advisor greet the client in a timely manner","Comments 2",
		  "Did the Advisor seek permission from customer to keep the chat on hold and showed presence to keep conversation active","Comments 3",
		  "Did the Advisor understand the customer query","Comments 4",
		  "Did the advisor ask for a budget preferance before recommending","Comments 5",
		  "Did Advisor edit /use relevant canned responses","Comments 6",
		  "Did the Advisor provide correct/complete information to resolve customers' query/concern","Comments 7",
		  "Did the Advisor use upfront Empathy/Apology and correct choice of words","Comments 8",
		  "Did the Advisor personalize during chat conversation","Comments 9",
		  "Did the Advisor use accurate Sentence formation Grammar Punctuation Tenses Spellings & avoid usage of jargons during chat?","Comments 10",
		  "Did the Advisor switch the language as per the requirement","Comments 11",
		  "Did the advisor recommend the correct product as per the concern?","Comments 12",
		  "Did the advisor attempt for upselling?","Comments 13",
		  "Did the advisor share UTM link/correct UTM link?","Comments 14",
		  "Did the advisor help the customer with the product coupon code after product recommendation?","Comments 15",
		  "Did the advisor share relevant benefits or How to use of product where required?","Comments 16",
		  "Did the Advisor use the correct disposition/Tagging as per the conversation along with remarks?","Comments 17",
		  "Did the Advisor inform the correct TAT?","Comments 18",
		  "Did the Advisor ask for Further assistance","Comments 19",
		  "Did the adviser keep the chat open for more than five minutes?","Comments 20",
		  "Did the Advisor close the chat properly/ followed the closing procedure","Comments 21",
		  "Did the advisor share the reference link macro with the links?","Comments 22",
		  "Did the advisor assist the client with the current event as per the calendar sheet shared?","Comments 23",
		  "No instance of chat avoidance or wrong practice followed?","Comments 24",
		  "The Advisor was unprofessional during chat?","Comments 25",
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

				$row = '"'.$user['auditor_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
        		$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
        		$row .= '"'.$user['tl_name'].'",';
        		$row .= '"'.$user['objection'].'",';
        		$row .= '"'.$user['campaign'].'",';
        		$row .= '"'.$user['Product'].'",';
        		$row .= '"'.$user['chat_id'].'",';
        		$row .= '"'.$user['customer_voc'].'",';
        		$row .= '"'.$user['agent_disposition'].'",';
        		$row .= '"'.$user['qa_disposition'].'",';
        		$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				//$row .= '"'.$interval1.'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['chat_correctly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['timely_manner'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['conversation_active'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['understand_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['budget_preferance'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['canned_responses'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['query_concern'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['Communication1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['Communication2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['Communication3'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['Communication4'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['Communication5'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['Communication6'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['Communication7'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['Communication8'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['Communication9'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'.$user['Documentation1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'.$user['Documentation2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'.$user['Closing1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'.$user['Closing2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'.$user['Closing3'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'.$user['Closing4'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'.$user['Closing5'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
				$row .= '"'.$user['Practices1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
				$row .= '"'.$user['Practices2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';


				
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

	//////////////////////////////////////////////////////////////////////////////////////////////////

	
	
 }
