<?php 
 
 class Qa_credit_mantri extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function credit_mantri_upload_files($files,$path)
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
			$data["content_template"] = "Qa_credit_mantri/qa_credit_mantri_feedback.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,355) and is_assign_process(id,741) and status=1 order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_credit_mantri_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["credit_mantri"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_credit_mantri_referral_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["credit_mantri_referral"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_credit_mantri($loanxm_id){
		if(check_logged_in())
		{
			$data['controller'] = $this;
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "Qa_credit_mantri/add_edit_credit_mantri.php";
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
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,355) and is_assign_process(id,741) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_credit_mantri_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["credit_mantri"] = $this->Common_model->get_query_row_array($qSql);
			
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
					$a = $this->credit_mantri_upload_files($_FILES['attach_file'], $path='./qa_files/qa_loanxm/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_credit_mantri_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_credit_mantri_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_credit_mantri_feedback',$field_array1);
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
					$this->db->update('qa_credit_mantri_feedback',$edit_array);
					
				}
				redirect('Qa_credit_mantri');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	////////////////////////////////////////////////////////

	public function add_edit_credit_mantri_referral($loanxm_id){
		if(check_logged_in())
		{
			$data['controller'] = $this;
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "Qa_credit_mantri/add_edit_credit_mantri_referral.php";
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
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,355) and is_assign_process(id,741) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			// $qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_credit_mantri_referral_feedback where id='$loanxm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["credit_mantri_referral"] = $this->Common_model->get_query_row_array($qSql);
			
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
					$a = $this->credit_mantri_upload_files($_FILES['attach_file'], $path='./qa_files/qa_loanxm/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_credit_mantri_referral_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_credit_mantri_referral_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $loanxm_id);
					$this->db->update('qa_credit_mantri_referral_feedback',$field_array1);
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
					$this->db->update('qa_credit_mantri_referral_feedback',$edit_array);
					
				}
				redirect('Qa_credit_mantri');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function weekOfMonth($date) {
	    //Get the first day of the month.
	    $firstOfMonth = date("Y-m-01", strtotime($date));
	    //Apply above formula.
	    return $this->weekOfYear($date) - $this->weekOfYear($firstOfMonth) + 1;
	}

	public function weekOfYear($date) {
	    $weekOfYear = intval(date("W", strtotime($date)));
	    if (date('n', strtotime($date)) == "1" && $weekOfYear > 51) {
	        // It's the last week of the previos year.
	        return 0;
	    }
	    else if (date('n', strtotime($date)) == "12" && $weekOfYear == 1) {
	        // It's the first week of the next year.
	        return 53;
	    }
	    else {
	        // It's a "normal" week.
	        return $weekOfYear;
	    }
	}
	
/*------------------- Agent Part ---------------------*/
	public function agent_credit_mantri_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$campaign="";
			$campaign = $this->input->get_post('campaign');
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "Qa_credit_mantri/agent_credit_mantri_feedback.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "Qa_credit_mantri/agent_credit_mantri_feedback";
			
			
			$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user'";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";

				// if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["credit_mantri"] = $this->Common_model->get_query_result_array($qSql);
			
					
			}else{
	
				// $qSql = "SELECT * from
				// 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				// 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				// 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				// 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				// 	(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				// $data["credit_mantri"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
				$data["credit_mantri"] = $this->Common_model->get_query_result_array($qSql);
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['campaign']=$campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_credit_mantri_rvw($id){
		if(check_logged_in()){
			$data['controller'] = $this;
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "Qa_credit_mantri/agent_credit_mantri_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "Qa_credit_mantri/agent_credit_mantri_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_credit_mantri_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["credit_mantri"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_credit_mantri_feedback',$field_array1);
					
				redirect('Qa_credit_mantri/agent_credit_mantri_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_credit_mantri_referral_rvw($id){
		if(check_logged_in()){
			$data['controller'] = $this;
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$campaign="";
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "Qa_credit_mantri/agent_credit_mantri_referral_rvw.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["agentUrl"] = "Qa_credit_mantri/agent_credit_mantri_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_credit_mantri_referral_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["credit_mantri_referral"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$campaign = $this->input->post('campaign');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_credit_mantri_referral_feedback',$field_array1);
					
				redirect('Qa_credit_mantri/agent_credit_mantri_feedback');
				$data['campaign']=$campaign;
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	 public function qa_credit_mantri_report(){
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
			$data["content_template"] = "Qa_credit_mantri/qa_credit_mantri_report.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$from_date="";
			$to_date="";
			$audit_type="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$user="";
			$campaign = $this->input->get('campaign');
			$data["qa_credit_mantri_list"] = array();

			if($this->input->get('show')=='Show')
			{

				    $from_date = mmddyy2mysql($this->input->get('date_from'));
					$to_date = mmddyy2mysql($this->input->get('date_to'));
					$office_id = $this->input->get('office_id');
					$lob = $this->input->get('lob');

					if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";

					if($office_id=="All") $cond .= "";
					else $cond .=" and office_id='$office_id'";

					if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
						$ops_cond="";
					}else{
						if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
							$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
						}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
							$ops_cond=" Where assigned_to='$current_user'";
						}else{
							$ops_cond="";
						}
					}

					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $ops_cond order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_credit_mantri_list"] = $fullAray;
				$this->create_qa_credit_mantri_CSV($fullAray,$campaign);
				$dn_link = base_url()."Qa_credit_mantri/download_qa_credit_mantri_CSV/".$campaign;
			}

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $from_date;
			$data['date_to'] = $to_date;
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;

			$this->load->view('dashboard',$data);
		}
	}
	 

	public function download_qa_credit_mantri_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_credit_mantri_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header=array();
		
		if($campaign=='credit_mantri'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date","Call Duration","Agency","OIC Name","Lead ID","CRM ID","Audit Type", "Auditor Type", "Voc","Earned Score","Possible Score","Overall Score","Call Opening","Previous interactions","(Intro Pitch) On customers profile","Benefits Explanation / Creating Urgency / Call to action","Objection handling","CFP Process explanation","Rate of speech", "Call disposition in CRM","Summarize and Close","Fatal-Mis-Conduct/ Mis-Behavior","Fatal-Mis-Sell/ Wrong Information","Call Opening Comment 1","Previous interactions Comment 2","(Intro Pitch) On customers profile Comment 3","Objection handling 4","CFP Process explanation comment 6","Rate of speech Comment 7","Call disposition in CRM 8","Summarize and Close 9","Fatal-Mis-Conduct/ Mis-Behavior 10","Fatal-Mis-Sell/ Wrong Information Comment 10","Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='credit_mantri_referral'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date","Call Duration","Week","Agency","OIC Name","Lead ID","CRM ID","Agent Disposition","QA Disposition","Phone Number","Audit Type", "Auditor Type", "Voc","Earned Score","Possible Score","Overall Score","Call Opening"," Intro Pitch","Key Focus Areas","Ojection Handling","Urgency creation","Referral Closure process", "CRM disposition","Fatal(Misleading or misguide customer related to loan amount/ ROI / Documents.)","Call Opening Comment 1","Intro Pitch Comment 2","Key Focus Areas Comment 3","Ojection Handling Comment 4","Urgency creation comment 5","Referral Closure process Comment 6","CRM disposition comment 7","Fatal(Misleading or misguide customer related to loan amount/ ROI / Documents.) comment 8","Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}
		else if($campaign=='pre_booking_new'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super","Call Date","Actual Tagging","Agent Tagging","Campaign","Call Duration","Agent Tenure","Customer Contact Number","Audit Type", "Auditor Type", "Voc","Overall Score", "Audit Start Time", "Audit End Time", "Interval(in sec)",
			"Did the advisor open the call correctly?","Reason for No","Remarks", "Did the advisor follow the customer identification process?","Reason for No","Remarks", "Did the advisor share the purpose of the call with the customer?","Remarks", "Did the advisor ask appropriate fact-finding questions/do probing for the car booking?","Reason for No","Remarks", "Did the advisor use effective rebuttals/sales and objection handling to encourage the customer to confirm the booking?","Remarks", "Did the advisor answer all customer queries effectively/ understanding the customers concern/ comprehending well?","Reason for No","Remarks", "Did the advisor inform Comprehensive Warranty & CARS24 Quality Standards /7 day trial & Hassle-free RC transfer/CARS24 Consumer Finance & Benefits?","Reason for No","Remarks", "Did the advisor inform Car Details- Make/Model confirmed /Delivery Type Date & Location confirmation","Reason for No","Remarks", "Did the advisor inform RC Transfer documents & RTO Charges Information (If Applicable)?","rc ransfer documents no reason","cmt9","Did the advisor confirm/capture the customers Email-id confirmation/Whatsapp Opt-in pitching","Reason for No","Remarks", "Did the advisor share the Order link/Car link?","Reason for No","Remarks", "Did the advisor inform about the booking and final payment amount?","Reason for No","Remarks", "Did the advisor convince the customer to try to book a car on call?","Remarks", "Did the advisor share a pre-approved offer/ capture loan details?","Reason for No","Remarks", "Did the advisor inform about the loan documents and share the bank statement link?","Reason for No","Remarks", "Did the advisor inform you about the payment type?","Reason for No","Remarks", "Did the advisor speak clearly and concisely maintain appropriate ROS?","Reason for No","Remarks", "Did you observe any regional influence and was the advisor able to construct the sentences appropriately to ensure better customer understanding?","Reason for No","Remarks", "Did the advisor sound energetic confident and intonate well?","Reason for No","Remarks", "Did the advisor actively listen to the customer throughout the call avoid interruption avoid repeating himself/herself during the call and appropriately","Reason for No","Remarks", "Did the advisor avoid the usage of fillers and Jargon?","Reason for No","Remarks", "Did the advisor follow the correct Hold /Transfer Procedure Use Mute and avoid dead air during the call?","Reason for No","Remarks", "Did the advisor personalize over the call use pleasantries words and statements/adjust the conversation as per the customers requirements/circumstances in","Reason for No","Remarks", "Did the advisor use Service No techniques?","Remarks", "Did the advisor empathise/apologise to the customer wherever required?","Reason for No","Remarks", "Was the advisor professional on the call?","Reason for No","Remarks", "Did the advisor summarize/further assistance/close the call appropriately with CSAT link?","Reason for No","Remarks", "Did the advisor use the correct disposition/update all notes and details correctly on the call?","Reason for No","Remarks", "Did the advisor provide all accurate information and not mislead the customer provide incorrect information or make any false promises?","Reason for No","Remarks", "Did not find any non-adherence to wrong practices","Reason for No","Remarks", "Did the Advisor provide Customer Experience beyond expectation?","Reason for No","Remarks",
			"Opening script followed as per new Guidelines","Remarks", "Effective Objection handling was there or not- as per new guidelines","Remarks", "Different Car suggested or not","Remarks", "Booking probability as per QA","Remarks", "Did the call was having two way conversation?","Remarks", "Did the advisor followed replaced words or scripts?","Remarks", "Did the advisor followed the car finding flow process?","Remarks",
			"Advisor related observations / challenges noticed on call","other observations challenges","suggestion observations challenges", "Customer related observations / challenges noticed on call","other customer observations","suggestion customer observations", "Technical related observations / challenges noticed on call","other technical observations","suggestion technical observations", "Process related observations / challenges noticed on call","other process observations","suggestion process observations",
			"Call Summary", "Feedback","Probability of Booking basis the call","Factors that could impact Booking","Reasons for impact on Booking (WHY 1)","Reasons for impact on Booking (WHY 2)", "Overall feel of the call basis Sales Pitch","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		    }

		$row = "";
		// $header = "";

		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='credit_mantri'){
			
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
				// $row .= '"'.$user['Week'].'",';
				$row .= '"'.$user['Agency'].'",';
				$row .= '"'.$user['OIC'].'",';
				$row .= '"'.$user['Lead'].'",';
				$row .= '"'.$user['CRM'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['Opening'].'",';
				$row .= '"'.$user['interactions'].'",';
				$row .= '"'.$user['profile'].'",';
				$row .= '"'.$user['action'].'",';
				$row .= '"'.$user['handling'].'",';
				$row .= '"'.$user['explanation'].'",';
				$row .= '"'.$user['speech'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['Close'].'",';
				$row .= '"'.$user['Behavior'].'",';
				$row .= '"'.$user['Information'].'",';
				
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['cmt10'].'",';
				
                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($campaign=='credit_mantri_referral'){
			
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
				$row .= '"'.$user['Week'].'",';
				$row .= '"'.$user['Agency'].'",';
				$row .= '"'.$user['OIC'].'",';
				$row .= '"'.$user['Lead'].'",';
				$row .= '"'.$user['CRM'].'",';
				$row .= '"'.$user['agent_disposition'].'",';
				$row .= '"'.$user['qa_disposition'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['Opening'].'",';
				$row .= '"'.$user['intro_pitch'].'",';
				$row .= '"'.$user['key_focus_area'].'",';
				$row .= '"'.$user['objection_handling'].'",';
				$row .= '"'.$user['urgency_creation'].'",';
				$row .= '"'.$user['referral_closure_process'].'",';
				$row .= '"'.$user['crm_disposition'].'",';
				$row .= '"'.$user['missleading_customer'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['cmt8'].'",';
                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		else if($campaign=='pre_booking_new'){
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
				$row .= '"'.$user['actual_tagging'].'",';
				$row .= '"'.$user['agent_tagging'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['agen_tenure'].'",';
				$row .= '"'.$user['customer_contact_number'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				
				$row .= '"'.$user['opening_done_within'].'",';
				$row .= '"'.$user['opening_done_within_no_reason'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['self_introduction'].'",';
				$row .= '"'.$user['self_introduction_no_reason'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['customer_identification'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['purpose_of_the_call'].'",';
				$row .= '"'.$user['purpose_of_the_call_no_reason'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['effective_rebuttals'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['customer_concern'].'",';
				$row .= '"'.$user['customer_concern_no_reason'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['comprehensive_warranty'].'",';
				$row .= '"'.$user['comprehensive_warranty_no_reason'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['delivery_type'].'",';
				$row .= '"'.$user['delivery_type_no_reason'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['rc_ransfer_documents'].'",';
				$row .= '"'.$user['rc_ransfer_documents_no_reason'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['whats_app_opt'].'",';
				$row .= '"'.$user['whats_app_opt_no_reason'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'.$user['car_details_link'].'",';
				$row .= '"'.$user['car_details_link_no_reason'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['payment_type_confirmation'].'",';
				$row .= '"'.$user['payment_type_confirmation_no_reason'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['consumer_convince_finance'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['loan_details_capturing'].'",';
				$row .= '"'.$user['loan_details_capturing_no_reason'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['loan_documents_information'].'",';
				$row .= '"'.$user['loan_documents_information_no_reason'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['payment_type_inform'].'",';
				$row .= '"'.$user['payment_type_inform_no_reason'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['voice_clarity'].'",';
				$row .= '"'.$user['voice_clarity_no_reason'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['language_switching'].'",';
				$row .= '"'.$user['language_switching_no_reason'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['voice_modulation'].'",';
				$row .= '"'.$user['voice_modulation_no_reason'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'.$user['voice_repeating'].'",';
				$row .= '"'.$user['voice_repeating_no_reason'].'",';
				$row .= '"'.$user['cmt20'].'",';
				$row .= '"'.$user['filter_jardon'].'",';
				$row .= '"'.$user['filter_jardon_no_reason'].'",';
				$row .= '"'.$user['cmt21'].'",';
				$row .= '"'.$user['transfer_procedure'].'",';
				$row .= '"'.$user['transfer_procedure_no_reason'].'",';
				$row .= '"'.$user['cmt22'].'",';
				$row .= '"'.$user['personalize_call'].'",';
				$row .= '"'.$user['personalize_call_no_reason'].'",';
				$row .= '"'.$user['cmt23'].'",';
				$row .= '"'.$user['service_no_tech'].'",';
				$row .= '"'.$user['cmt24'].'",';
				$row .= '"'.$user['empathise'].'",';
				$row .= '"'.$user['empathise_no_reason'].'",';
				$row .= '"'.$user['cmt25'].'",';
				$row .= '"'.$user['rude_behaviour'].'",';
				$row .= '"'.$user['rude_behaviour_no_reason'].'",';
				$row .= '"'.$user['cmt26'].'",';
				$row .= '"'.$user['csat_link'].'",';
				$row .= '"'.$user['csat_link_no_reason'].'",';
				$row .= '"'.$user['cmt27'].'",';
				$row .= '"'.$user['correct_dispostion'].'",';
				$row .= '"'.$user['correct_dispostion_no_reason'].'",';
				$row .= '"'.$user['cmt28'].'",';
				$row .= '"'.$user['incorrect_information'].'",';
				$row .= '"'.$user['incorrect_information_no_reason'].'",';
				$row .= '"'.$user['cmt29'].'",';
				$row .= '"'.$user['unprofessional'].'",';
				$row .= '"'.$user['unprofessional_no_reason'].'",';
				$row .= '"'.$user['cmt30'].'",';
				$row .= '"'.$user['customer_experience'].'",';
				$row .= '"'.$user['customer_experience_reason'].'",';
				$row .= '"'.$user['cmt31'].'",';
				$row .= '"'.$user['opening_script_follow'].'",';
				$row .= '"'.$user['cmt44'].'",';
				$row .= '"'.$user['effective_objection_handling'].'",';
				$row .= '"'.$user['cmt45'].'",';
				$row .= '"'.$user['different_car_suggest_or_not'].'",';
				$row .= '"'.$user['cmt46'].'",';
				$row .= '"'.$user['booking_probably_as_qa'].'",';
				$row .= '"'.$user['cmt47'].'",';
				$row .= '"'.$user['call_having_tow_way_conversion'].'",';
				$row .= '"'.$user['cmt48'].'",';
				$row .= '"'.$user['advisor_follow_replace_words'].'",';
				$row .= '"'.$user['cmt49'].'",';
				$row .= '"'.$user['advisor_follow_car_finding_process'].'",';
				$row .= '"'.$user['cmt50'].'",';
				$row .= '"'.$user['observations_challenges'].'",';
				$row .= '"'.$user['other_observations_challenges'].'",';
				$row .= '"'.$user['suggestion_observations_challenges'].'",';
				$row .= '"'.$user['customer_observations'].'",';
				$row .= '"'.$user['other_customer_observations'].'",';
				$row .= '"'.$user['suggestion_customer_observations'].'",';
				$row .= '"'.$user['technical_observations'].'",';
				$row .= '"'.$user['other_technical_observations'].'",';
				$row .= '"'.$user['suggestion_technical_observations'].'",';
				$row .= '"'.$user['process_observations'].'",';
				$row .= '"'.$user['other_process_observations'].'",';
				$row .= '"'.$user['suggestion_process_observations'].'",';
				
                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['probability_of'].'",';
				$row .= '"'.$user['factors_that_could'].'",';
				$row .= '"'.$user['reasons_for_why1'].'",';
				$row .= '"'.$user['reasons_for_why2'].'",';
				$row .= '"'.$user['overall_feel_of_the'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
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
