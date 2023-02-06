<?php 
 
 class Qa_loanxm extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_philip_model');
	}
	
	
	private function loanxm_upload_files($files,$path)
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
			$data["content_template"] = "qa_loanxm/qa_loanxm_feedback.php";
			$data["content_js"] = "qa_loanxm_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,37) and is_assign_process(id,49) and status=1 order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["loanxm"] = $this->Common_model->get_query_result_array($qSql);
		///////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_voicemail_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["loanxm_voicemail"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_loanxm($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_loanxm/add_edit_loanxm.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data['loanxm_id']=$loanxm_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,37) and is_assign_process(id,49) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_loanxm_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["loanxm"] = $this->Common_model->get_query_row_array($qSql);
			
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
					$a = $this->loanxm_upload_files($_FILES['attach_file'], $path='./qa_files/qa_loanxm/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_loanxm_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_loanxm_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_loanxm_feedback',$field_array1);
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
					$this->db->update('qa_loanxm_feedback',$edit_array);
					
				}
				redirect('qa_loanxm');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_loanxm_voicemail($loanxm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_loanxm/add_edit_loanxm_voicemail.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data['loanxm_id']=$loanxm_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,37) and is_assign_process(id,49) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_loanxm_voicemail_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["loanxm_voicemail"] = $this->Common_model->get_query_row_array($qSql);
			
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
					$a = $this->loanxm_upload_files($_FILES['attach_file'], $path='./qa_files/qa_loanxm/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_loanxm_voicemail_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_loanxm_voicemail_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_loanxm_voicemail_feedback',$field_array1);
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
					$this->db->update('qa_loanxm_voicemail_feedback',$edit_array);
					
				}
				redirect('qa_loanxm');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/*------------------- Agent Part ---------------------*/
	public function agent_loanxm_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_loanxm/agent_loanxm_feedback.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data["agentUrl"] = "qa_loanxm/agent_loanxm_feedback";
			
			
			$qSql="Select count(id) as value from qa_loanxm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_loanxm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		//////////////////
			$qSql="Select count(id) as value from qa_loanxm_voicemail_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_voicemail_fd"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_loanxm_voicemail_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_voicemail_rvw"] =  $this->Common_model->get_single_value($qSql);
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			///////////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_voicemail_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_voicemail_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			///////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_voicemail_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_voicemail_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_loanxm_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_loanxm/agent_loanxm_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_loanxm/agent_loanxm_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["loanxm"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_loanxm_feedback',$field_array1);
					
				redirect('qa_loanxm/agent_loanxm_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	public function agent_loanxm_voicemail_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_loanxm/agent_loanxm_voicemail_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_loanxm/agent_loanxm_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_loanxm_voicemail_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["loanxm_voicemail"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_loanxm_voicemail_feedback',$field_array1);
					
				redirect('qa_loanxm/agent_loanxm_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
/*-------------- Report Part ---------------*/
	public function qa_loanxm_report(){
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
			$data["content_template"] = "qa_loanxm/qa_loanxm_report.php";
			$data["content_js"] = "qa_loanxm_js.php";
			
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
			$cond2="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign=="Voicemail"){
				$table='qa_loanxm_voicemail_feedback';
				$cond2 .= "";
			}else if($campaign=="Inbound"){
				$table='qa_loanxm_feedback';
				$cond2 .= " and call_type='Inbound'";
			}else if($campaign=="Outbound"){
				$table='qa_loanxm_feedback';
				$cond2 .= " and call_type='Outbound'";
			}
			
			$data["qa_loanxm_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from ".$table.") xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond2 $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_loanxm_list"] = $fullAray;
				$this->create_qa_loanxm_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_loanxm/download_qa_loanxm_CSV/".$campaign;	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_loanxm_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Debt Solution 123 ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_loanxm_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=="Voicemail"){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Call Duration", "Five9 Call ID", "Customer Name","Customer Contact number","Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(in sec)", "Pass/Fail", "Overall Score","Business Score","Customer Score", "Compliance Score", "Adherence to Voicemail script", "Uses appropriate tone pace and voice inflection", "Did the agent use proper word choice pronunciation and enunciation?", "Leaves voicemail immediately after the tone", "Dispositioned properly in Five9","Dispositioned properly in Livebox", "Quality","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=="Inbound" || $campaign=="Outbound"){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Call Duration", "Type of Call", "Five9 Call ID", "Customer Name","Customer Contact number","Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(in sec)", "Pass/Fail", "Overall Score","Business Score","Customer Score", "Compliance Score", "Opening/Introduction", "Qualifying Questions", "Conclusion - varies for a LT vs Post vs Call Backs", "Questions and Rebuttals", "Uses appropriate tone pace and voice inflection", "Did the agent use proper word choice pronunciation and enunciation?", "Listen actively and respond appropriately without interrupting customer?", "Used manual connector to pull up lead in Portal","Properly Identified client is the person on the call.", "All Portal Fields filled out correctly", "Dispostioned properly in Portal","Process lead properly with the portal.", "If Red Light - Did agent proceed to Credit Card page in Portal?", "Dispositioned properly in Five9", "Dispositioned properly in Livebox and the TMI","Proper phone system procedure to complete Live Transfer", "Did the agent use the prospects name at least twice?", "Did the agent reference to our Houston Office when applicable?", "Background sound quality","Proper script was used?", "Call Acknowledgement","Timely Response","Use of the TMI","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=="Voicemail"){
			
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
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['five9_id'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['customer_contact'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['pass_fail'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['business_score'].'%'.'",';
				$row .= '"'.$user['customer_score'].'%'.'",';
				$row .= '"'.$user['compliance_score'].'%'.'",';
				$row .= '"'.$user['adherence_voicemail_script'].'",';
				$row .= '"'.$user['use_appropiate_tone'].'",';
				$row .= '"'.$user['agent_use_proper_word_choice'].'",';
				$row .= '"'.$user['leave_voicemail'].'",';
				$row .= '"'.$user['disposition_in_Five9'].'",';
				$row .= '"'.$user['disposition_in_livebox'].'",';
				$row .= '"'.$user['quality'].'",';
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
		
		}else if($campaign=="Inbound" || $campaign=="Outbound"){
			
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
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['five9_id'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['customer_contact'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['pass_fail'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['business_score'].'%'.'",';
				$row .= '"'.$user['customer_score'].'%'.'",';
				$row .= '"'.$user['compliance_score'].'%'.'",';
				$row .= '"'.$user['opening_introduction'].'",';
				$row .= '"'.$user['qualifying_questions'].'",';
				$row .= '"'.$user['conclusion'].'",';
				$row .= '"'.$user['questions_rebuttals'].'",';
				$row .= '"'.$user['voice_quality'].'",';
				$row .= '"'.$user['pronunciation'].'",';
				$row .= '"'.$user['listen_actively'].'",';
				$row .= '"'.$user['lead_portal'].'",';
				$row .= '"'.$user['identified'].'",';
				$row .= '"'.$user['all_portal_fields'].'",';
				$row .= '"'.$user['disposition_in_portal'].'",';
				$row .= '"'.$user['process_lead'].'",';
				$row .= '"'.$user['red_creditcard_portal'].'",';
				$row .= '"'.$user['dispositioned_five9'].'",';
				$row .= '"'.$user['dispositioned_livebox'].'",';
				$row .= '"'.$user['live_transfer_phone'].'",';
				$row .= '"'.$user['agent_use_prospect_name'].'",';
				$row .= '"'.$user['agent_houston_office'].'",';
				$row .= '"'.$user['quality'].'",';
				$row .= '"'.$user['proper_script_use'].'",';
				$row .= '"'.$user['call_acknowledge'].'",';
				$row .= '"'.$user['timely_response'].'",';
				$row .= '"'.$user['TMI'].'",';
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
	
	}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////// Excel Upload Download Process //////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function import_loanxm_excel_data(){
		
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
			$clmarr = array("audit_date","call_date","call_duration","fusion_id","call_type","customer_name","customer_contact","five9_id","disposition","pass_fail","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","customer_score","business_score","compliance_score","opening_introduction","qualifying_questions","conclusion","questions_rebuttals","voice_quality","pronunciation","listen_actively","lead_portal","all_portal_fields","disposition_in_portal","red_creditcard_portal","dispositioned_five9","live_transfer_phone","agent_use_prospect_name","agent_houston_office","proper_script_use","quality","TMI","call_acknowledge","identified","process_lead","dispositioned_livebox","timely_response","call_summary","feedback");
			
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
						// if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
						// 	$interval1 = '---';
						// }else{
						// 	$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
						// }
						
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
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
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
			
				$this->Qa_philip_model->philip_insert_excel($user_list);
				redirect('Qa_loanxm');
			}
		}
	}

	/*******************************************************************/
	/*                        UPLOAD DATA                              */
	/*******************************************************************/
	
	public function sample_loanxm_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."course_uploads/loanxm_updated_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function qa_loanxm_upload_feedback(){
		if(check_logged_in()){
			$current_user = get_user_id(); 
			$user_office = get_user_office_id(); 
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_loanxm/qa_loanxm_feedback.php";
			$data["content_js"] = "qa_philip_js.php";
			
			$qSql = "Select count(*) as count, date(upload_date) as uplDate from qa_loanxm_feedback group by date(upload_date)";
			$data["sampling"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view("dashboard",$data);
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
