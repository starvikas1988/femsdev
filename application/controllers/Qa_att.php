<?php 

 class Qa_att extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}

/////////////////////////// Create Path for Upload Audio Files - Start ///////////////////////////////
	 public function createPath($path)
	{

		if (!empty($path))
		{

	    	if(!file_exists($path)){

	    		$mainPath="./";
	    		$checkPath=str_replace($mainPath,'', $path);
	    		$checkPath=explode("/",$checkPath);
	    		$cnt=count($checkPath);
	    		for($i=0;$i<$cnt;$i++){

		    		$mainPath.=$checkPath[$i].'/';
		    		if (!file_exists($mainPath)) {
		    			$oldmask = umask(0);
						$mkdir=mkdir($mainPath, 0777);
						umask($oldmask);

						if ($mkdir) {
							return true;
						}else{
							return false;
						}
		    		}

	    		}

    		}else{
    			return true;
    		}
    	}
	}

    private function edu_upload_files($files,$path)   // this is for file uploaging purpose
  {
    $result=$this->createPath($path);
    if($result){
    $config['upload_path'] = $path;
    $config['allowed_types'] = '*';

	  $config['allowed_types'] = 'm4a|mp4|mp3|wav';
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
  }

	
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/feedback_att.php";
			$data["content_js"] = "qa_audit_js.php";			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			$cond1='';
			
			$qSql_agent="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql_agent);
			
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
			if($from_date !="" && $to_date!=="" )  $cond =" where (audit_date >= '$from_date' and audit_date <= '$to_date') ";
			if($agent_id!=""){
				$cond1 ="and agent_id='$agent_id'";
			}
			
			if(get_user_fusion_id()=='FFLO000546'){
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
		

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["att"] = $this->Common_model->get_query_result_array($qSql);

			/* $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_compliance_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["attcompliance"] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_collection_gbrm_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["gbrm"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_coaching_GRBM_feedback $cond $cond1) xx Left Join
				(Select id as sid, concat(fname, ' ', lname) as agent_name, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["coaching_gbrm"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_fiberconnect_whitespace_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["whitespace"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=agent_id) as agent_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_at_t_first_net_loyalty_coaching_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["firstnetloyalty"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_att($att_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/add_edit_att.php";
			//$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["content_js"] = "qa_att_js.php";
			$data['att_id']=$att_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_att_feedback where id='$att_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["att"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($att_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_att_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_att_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $att_id);
					$this->db->update('qa_att_feedback',$field_array1);
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
					$this->db->where('id', $att_id);
					$this->db->update('qa_att_feedback',$edit_array);
					
				}
				redirect('Qa_att');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_collection_gbrm($att_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/gbrm/add_edit_audit.php";
			$data["content_js"] = "qa_audit_js.php";
			$data['att_id']=$att_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			/* $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_att_collection_gbrm_feedback where id='$att_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($att_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/gbrm/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_att_collection_gbrm_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_att_collection_gbrm_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $att_id);
					$this->db->update('qa_att_collection_gbrm_feedback',$field_array1);
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
					$this->db->where('id', $att_id);
					$this->db->update('qa_att_collection_gbrm_feedback',$edit_array);
					
				}
				redirect('Qa_att');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_fiberconnect_whitespace($att_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/whitespace/add_edit_audit.php";
			$data["content_js"] = "qa_audit_js.php";
			$data['att_id']=$att_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,'157,322')  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_att_fiberconnect_whitespace_feedback where id='$att_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($att_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/whitespace/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_att_fiberconnect_whitespace_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_att_fiberconnect_whitespace_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $att_id);
					$this->db->update('qa_att_fiberconnect_whitespace_feedback',$field_array1);
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
					$this->db->where('id', $att_id);
					$this->db->update('qa_att_fiberconnect_whitespace_feedback',$edit_array);
					
				}
				redirect('Qa_att');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_attcompliance($attcompliance_id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/compliance/add_edit_attcompliance.php";
			//$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["content_js"] = "qa_att_js.php";
			$data['attcompliance_id']=$attcompliance_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_att_compliance_feedback where id='$attcompliance_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["att_compliance"] = $this->Common_model->get_query_row_array($qSql);
			// print_r($data["att_compliance"]);
			// die();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($attcompliance_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_att_compliance_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_att_compliance_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $attcompliance_id);
					$this->db->update('qa_att_compliance_feedback',$field_array1);
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
					$this->db->where('id', $attcompliance_id);
					$this->db->update('qa_att_compliance_feedback',$edit_array);
					
				}
				redirect('Qa_att');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////
//// Fiberconnect

	public function fiberconnect(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/fiberconnect/qa_feedback.php";
			//$data["content_js"] = "qa_att_js.php";		
			$data["content_js"] = "qa_fiberconnect_js.php";	
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			$cond1='';
			
			$qSql_agent="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,322) and is_assign_process(id,684) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql_agent);
			
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
			if($from_date !="" && $to_date!=="" )  $cond =" where (audit_date >= '$from_date' and audit_date <= '$to_date') ";
			if($agent_id!=""){
				$cond1 ="and agent_id='$agent_id'";
			}
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["fiberconnect"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_greenspace_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["greenspace"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_whitespace_v1_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["whitespace_v1"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_fiberconnect($fiberconnect_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/fiberconnect/add_edit_fiberconnect.php";
			//$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["content_js"] = "qa_fiberconnect_js.php";
			$data['fiberconnect_id']=$fiberconnect_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,322) and is_assign_process(id,684) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_fiberconnect_feedback where id='$fiberconnect_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["fiberconnect"] = $this->Common_model->get_query_row_array($qSql);
			
			 	// echo "<pre>";
     //            print_r($data["fiberconnect"]);
     //            die();
     //            exit;

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($fiberconnect_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_fiberconnect_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_fiberconnect_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $fiberconnect_id);
					$this->db->update('qa_fiberconnect_feedback',$field_array1);
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
					$this->db->where('id', $fiberconnect_id);
					$this->db->update('qa_fiberconnect_feedback',$edit_array);
					
				}
				redirect('Qa_att/fiberconnect');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_fiberconnect_greenspace($att_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/fiberconnect/add_edit_fiberconnect_greenspace.php";
			$data["content_js"] = "qa_fiberconnect_js.php";
		
			$data['att_id']=$att_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			/******** Randamiser Start***********/
			
			
			$rand_id=0;
			if(!empty($this->uri->segment(4))){
				$rand_id=$this->uri->segment(4);
			}
			$data['rand_id']=$rand_id;
			$data["rand_data"] = "";
			if($rand_id!=0){
				$sql = "SELECT client_id, process_id FROM qa_randamiser_general_data WHERE id=$rand_id";
				$dataClientProID = $this->Common_model->get_query_row_array($sql);
				//print_r($dataClientProID);
				//echo "<br>";
				$client_id = $dataClientProID['client_id'];
				$pro_id = $dataClientProID['process_id'];;
				$curDateTime=CurrMySqlDate();
				$upArr = array('distribution_opend_by' =>$current_user,'distribution_opened_datetime'=>$curDateTime);
				$this->db->where('id', $rand_id);
				$this->db->update('qa_randamiser_general_data',$upArr);
				
				$randSql="Select srd.*,srd.aht as call_duration, S.id as sid, S.fname, S.lname, S.xpoid, S.assigned_to,
				(select concat(fname, ' ', lname) as name from signin s1 where s1.id=S.assigned_to) as tl_name,DATEDIFF(CURDATE(), S.doj) as tenure
				from qa_randamiser_general_data srd Left Join signin S On srd.fusion_id=S.fusion_id where srd.audit_status=0 and srd.id='$rand_id'";
				$data["rand_data"] = $rand_data =  $this->Common_model->get_query_row_array($randSql);
				//print_r($rand_data);
				
			}
			/* Randamiser Code End */

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,322) and is_assign_process(id,684) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_fiberconnect_greenspace_feedback where id='$att_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["greenspace_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($att_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/greenspace');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_fiberconnect_greenspace_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_fiberconnect_greenspace_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/sea_world/")){
							mkdir("./qa_files/qa_att/greenspace/");
						}
						$a = $this->edu_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_att/greenspace/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $att_id);
					$this->db->update('qa_fiberconnect_greenspace_feedback',$field_array1);
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
					$this->db->where('id', $att_id);
					$this->db->update('qa_fiberconnect_greenspace_feedback',$edit_array);

						/* Randamiser section */
					if($rand_id!=0){
						$rand_cdr_array = array("audit_status" => 1);
						$this->db->where('id', $rand_id);
						$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
						
						$rand_array = array("is_rand" => 1);
						$this->db->where('id', $rowid);
						$this->db->update('qa_fiberconnect_greenspace_feedback',$rand_array);
					}

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('Qa_att/fiberconnect');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	//vikas - 29-12-2023//

	public function add_edit_fiberconnect_whitespace_v1($att_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/fiberconnect/add_edit_fiberconnect_whitespace_v1.php";
			$data["content_js"] = "qa_fiberconnect_js.php";
		
			$data['att_id']=$att_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			/******** Randamiser Start***********/
			
			
			$rand_id=0;
			if(!empty($this->uri->segment(4))){
				$rand_id=$this->uri->segment(4);
			}
			$data['rand_id']=$rand_id;
			$data["rand_data"] = "";
			if($rand_id!=0){
				$sql = "SELECT client_id, process_id FROM qa_randamiser_general_data WHERE id=$rand_id";
				$dataClientProID = $this->Common_model->get_query_row_array($sql);
				//print_r($dataClientProID);
				
				$client_id = $dataClientProID['client_id'];
				$pro_id = $dataClientProID['process_id'];;
				$curDateTime=CurrMySqlDate();
				$upArr = array('distribution_opend_by' =>$current_user,'distribution_opened_datetime'=>$curDateTime);
				$this->db->where('id', $rand_id);
				$this->db->update('qa_randamiser_general_data',$upArr);
				
				$randSql="Select srd.*,srd.aht as call_duration, S.id as sid, S.fname, S.lname, S.xpoid, S.assigned_to,
				(select concat(fname, ' ', lname) as name from signin s1 where s1.id=S.assigned_to) as tl_name,DATEDIFF(CURDATE(), S.doj) as tenure
				from qa_randamiser_general_data srd Left Join signin S On srd.fusion_id=S.fusion_id where srd.audit_status=0 and srd.id='$rand_id'";
				$data["rand_data"] = $rand_data =  $this->Common_model->get_query_row_array($randSql);
				//print_r($rand_data);
				
			}
			/* Randamiser Code End */

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,322) and is_assign_process(id,684) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_fiberconnect_whitespace_v1_feedback where id='$att_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["whitespace_v1_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($att_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/whitespace_v1');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_fiberconnect_whitespace_v1_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_fiberconnect_whitespace_v1_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_att/")){
							mkdir("./qa_files/qa_att/whitespace_v1/");
						}
						$a = $this->edu_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_att/whitespace_v1/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $att_id);
					$this->db->update('qa_fiberconnect_whitespace_v1_feedback',$field_array1);
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
					$this->db->where('id', $att_id);
					$this->db->update('qa_fiberconnect_whitespace_v1_feedback',$edit_array);

						/* Randamiser section */
					if($rand_id!=0){
						$rand_cdr_array = array("audit_status" => 1);
						$this->db->where('id', $rand_id);
						$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
						
						$rand_array = array("is_rand" => 1);
						$this->db->where('id', $rowid);
						$this->db->update('qa_fiberconnect_whitespace_v1_feedback',$rand_array);
					}

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('Qa_att/fiberconnect');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	/////////////////AT&T//////////////////////////	

	// public function agent_att_feedback(){
	// 	if(check_logged_in())
	// 	{
	// 		$current_user = get_user_id();
	// 		$data["aside_template"] = "qa/aside.php";
	// 		$data["content_template"] = "qa_att/agent_att_feedback.php";
	// 		// $data["content_js"] = "qa_ameridial_healthcare_js.php";	
	// 		$data["content_js"] = "qa_att_js.php";	
	// 		$data["agentUrl"] = "qa_att/agent_att_feedback";


	// 		$qSql="Select count(id) as value from qa_att_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
	// 		$data["tot_post_feedback"] =  $this->Common_model->get_single_value($qSql);

	// 		$qSql="Select count(id) as value from qa_att_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
	// 		$data["yet_post_rvw"] =  $this->Common_model->get_single_value($qSql);

	// 		$qSql="Select count(id) as value from qa_fiberconnect_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
	// 		$data["tot_post_feedback_fiber"] =  $this->Common_model->get_single_value($qSql);

	// 		$qSql="Select count(id) as value from qa_fiberconnect_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
	// 		$data["yet_post_rvw_fiber"] =  $this->Common_model->get_single_value($qSql);

	// 		$from_date = '';
	// 		$to_date = '';
	// 		$cond="";


	// 		if($this->input->get('btnView')=='View')
	// 		{
	// 			$from_date = mmddyy2mysql($this->input->get('from_date'));
	// 			$to_date = mmddyy2mysql($this->input->get('to_date'));

	// 			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";

	// 			$qSql = "SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
	// 			$data["att_list"] = $this->Common_model->get_query_result_array($qSql);

	// 			$qSql = "SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
	// 			$data["fiberconnect_list"] = $this->Common_model->get_query_result_array($qSql);

	// 		}else{

	// 			$qSql="SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
	// 			$data["att_list"] = $this->Common_model->get_query_result_array($qSql);

	// 			$qSql="SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
	// 			$data["fiberconnect_list"] = $this->Common_model->get_query_result_array($qSql);

	// 		}

	// 		$data["from_date"] = $from_date;
	// 		$data["to_date"] = $to_date;

	// 		$this->load->view('dashboard',$data);
	// 	}
	// }
	
	// public function agent_att_feedback()
	// {
	// 	if(check_logged_in())
	// 	{
	// 		$current_user = get_user_id();
	// 		$data["aside_template"] = "qa/aside.php";
	// 		$data["content_template"] = "qa_att/agent_att_feedback.php";
	// 		// $data["content_js"] = "qa_ameridial_healthcare_js.php";	
	// 		$data["content_js"] = "qa_att_js.php";	
	// 		$data["agentUrl"] = "qa_att/agent_att_feedback";		
			

	// 		// $qSql="Select count(id) as value from qa_att_feedback where agent_id='$current_user'";
	// 		// $data["tot_post_feedback"] =  $this->Common_model->get_single_value($qSql);
	// 		// $qSql="Select count(id) as value from qa_att_feedback where agent_rvw_date is null and agent_id='$current_user'";
	// 		// $data["yet_post_rvw"] =  $this->Common_model->get_single_value($qSql);

	// 		// $qSql="Select count(id) as value from qa_fiberconnect_feedback where agent_id='$current_user'";
	// 		// $data["tot_post_feedback_fiber"] =  $this->Common_model->get_single_value($qSql);
	// 		// $qSql="Select count(id) as value from qa_fiberconnect_feedback where agent_rvw_date is null and agent_id='$current_user'";
	// 		// $data["yet_post_rvw_fiber"] =  $this->Common_model->get_single_value($qSql);

	// 		$qSql="Select count(id) as value from qa_att_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
	// 		$data["tot_post_feedback"] =  $this->Common_model->get_single_value($qSql);

	// 		$qSql="Select count(id) as value from qa_att_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
	// 		$data["yet_post_rvw"] =  $this->Common_model->get_single_value($qSql);

	// 		$qSql="Select count(id) as value from qa_fiberconnect_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
	// 		$data["tot_post_feedback_fiber"] =  $this->Common_model->get_single_value($qSql);

	// 		$qSql="Select count(id) as value from qa_fiberconnect_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
	// 		$data["yet_post_rvw_fiber"] =  $this->Common_model->get_single_value($qSql);


			
	// 		$from_date = '';
	// 		$to_date = '';
	// 		$cond="";
	// 		$cond1="";
			
			
	// 		if($this->input->get('btnView')=='View')
	// 		{
	// 			$from_date = mmddyy2mysql($this->input->get('from_date'));
	// 			$to_date = mmddyy2mysql($this->input->get('to_date'));
				
	// 			if($from_date !="" && $to_date!=="" ){
	// 			  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
	// 			  $cond1=" And (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
	// 			}


	// 			// if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
	// 			$qSql = "SELECT * from
	// 				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_feedback $cond) xx Left Join
	// 				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
	// 			$data["att_list"] = $this->Common_model->get_query_result_array($qSql);

	// 			echo $qSql = "SELECT * from
	// 				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_feedback $cond1 ) xx Left Join
	// 				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)  Where xx.agent_rvw_date is Null";
	// 			$data["fiberconnect_list"] = $this->Common_model->get_query_result_array($qSql);
	// 			print_r($data["fiberconnect_list"]);
	// 			die;
				
	// 		}else
	// 		{
				
				
	// 			$qSql = "SELECT * from
	// 				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_feedback $cond) xx Left Join
	// 				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
	// 			$data["att_list"] = $this->Common_model->get_query_result_array($qSql);

	// 			$qSql = "SELECT * from
	// 				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_feedback where audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') $cond1) xx Left Join
	// 				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";

					
	// 			$data["fiberconnect_list"] = $this->Common_model->get_query_result_array($qSql);
				
	// 				//exit;
				
	// 		}
			
	// 		$data["from_date"] = $from_date;
	// 		$data["to_date"] = $to_date;
	// 		$this->load->view("dashboard",$data);
	// 	}
	// }

	public function agent_att_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/agent_att_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_att/agent_att_feedback";

			$campaign="";
			$campaign = $this->input->get('campaign');
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$data["att_list"]=array();
			
			if($campaign!=''){
				
				if($campaign == 'at_t_first_net_loyalty_coaching'){
						$qSql1="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user'";
						$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
						$qSql2="Select count(id) as value from qa_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user'";
						$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);
				}else{
					$qSql1="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' AND audit_type not in ('Calibration','Pre-Certificate Mock Call','Certification Audit','QA Supervisor Audit')";
					$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
					$qSql2="Select count(id) as value from qa_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' AND audit_type not in ('Calibration','Pre-Certificate Mock Call','Certification Audit','QA Supervisor Audit')";
					$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);
				}
				

				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);

					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($from_date !="" && $to_date!=="" )  $cond =" and (audit_date >= '$from_date' and audit_date <= '$to_date') ";
					if($campaign == 'at_t_first_net_loyalty_coaching'){
						$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback Where agent_id='$current_user' $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

					}else{
						$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback Where agent_id='$current_user' $cond And audit_type not in ('Calibration','Pre-Certificate Mock Call','Certification Audit','QA Supervisor Audit')) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
					}
					
					$data["att_list"] = $this->Common_model->get_query_result_array($qSql);

				}
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;


			$this->load->view('dashboard',$data);
		}
	}

   
  public function agent_att_feedback_rvw($id){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['att_id']=$id;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/agent_att_feedback_rvw.php";
      //$data["content_js"] = "qa_ameridial_healthcare_js.php";
      $data["content_js"] = "qa_att_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_feedback where id='$id') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["att"] = $this->Common_model->get_query_row_array($qSql);

      $data["att_id"]=$id;

      if($this->input->post('att_id'))
      {
        $att_id=$this->input->post('att_id');
        $curDateTime=CurrMySqlDate();
        $log=get_logs();

        $field_array1=array(
          "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
          "agent_rvw_note" => $this->input->post('note'),
          "agent_rvw_date" => $curDateTime
        );
        $this->db->where('id', $att_id);
        $this->db->update('qa_att_feedback',$field_array1);


        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }
  
  
  public function agent_compliance_feedback_rvw($id){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['attcompliance_id']=$id;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/compliance/agent_compliance_feedback_rvw.php";
      $data["content_js"] = "qa_att_js.php";
	  $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_compliance_feedback where id='$id') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["att_compliance"] = $this->Common_model->get_query_row_array($qSql);

      $data["attcompliance_id"]=$id;

      if($this->input->post('attcompliance_id'))
      {
        $attcompliance_id=$this->input->post('attcompliance_id');
        $curDateTime=CurrMySqlDate();
        $log=get_logs();

        $field_array1=array(
          "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
          "agent_rvw_note" => $this->input->post('note'),
          "agent_rvw_date" => $curDateTime
        );
        $this->db->where('id', $attcompliance_id);
        $this->db->update('qa_att_compliance_feedback',$field_array1);


        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }
  

  public function agent_fiberconnect_rvw($fiberconnect_id){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['fiberconnect_id']=$fiberconnect_id;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/fiberconnect/agent_fiberconnect_rvw.php";
      //$data["content_js"] = "qa_ameridial_healthcare_js.php";
      $data["content_js"] = "qa_fiberconnect_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_feedback where id='$fiberconnect_id') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["fiberconnect"] = $this->Common_model->get_query_row_array($qSql);

      $data["fiberconnect_id"]=$fiberconnect_id;

      if($this->input->post('fiberconnect_id'))
      {
        $fiberconnect_id=$this->input->post('fiberconnect_id');
        $curDateTime=CurrMySqlDate();
        $log=get_logs();

        $field_array1=array(
          "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
          "agent_rvw_note" => $this->input->post('note'),
          "agent_rvw_date" => $curDateTime
        );
        $this->db->where('id', $fiberconnect_id);
        $this->db->update('qa_fiberconnect_feedback',$field_array1);

        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }

  public function agent_acc_feedback_rvw($acc_id){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
    //  $data['fiberconnect_id']=$fiberconnect_id;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/agent_acc_feedback_rvw.php";
      //$data["content_js"] = "qa_ameridial_healthcare_js.php";
      $data["content_js"] = "qa_fiberconnect_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_feedback where id='$acc_id') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["acc"] = $this->Common_model->get_query_row_array($qSql);

      $data["acc_id"]=$acc_id;

      if($this->input->post('acc_id'))
      {
        $acc_id=$this->input->post('acc_id');
        $curDateTime=CurrMySqlDate();
        $log=get_logs();

        $field_array1=array(
          "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
          "agent_rvw_note" => $this->input->post('note'),
          "agent_rvw_date" => $curDateTime
        );
        $this->db->where('id', $acc_id);
        $this->db->update('qa_acc_feedback',$field_array1);

        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }
  
  
  public function agent_gbrm_rvw($pnid){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['pnid']=$pnid;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/gbrm/agent_gbrm_rvw.php";
      $data["content_js"] = "qa_audit_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_collection_gbrm_feedback where id='$pnid') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["auditData"] = $this->Common_model->get_query_row_array($qSql);

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
        $this->db->update('qa_att_collection_gbrm_feedback',$field_array1);
        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }

  // public function agent_coaching_rvw($pnid){
  //   if(check_logged_in()){
  //     $current_user=get_user_id();
  //     $user_office_id=get_user_office_id();
  //     $data['pnid']=$pnid;
  //     $data["aside_template"] = "qa/aside.php";
  //     $data["content_template"] = "qa_att/agent_coaching_rvw.php";
  //    // $data["content_js"] = "qa_audit_js.php";
  //     $data["agentUrl"] = "qa_att/agent_att_feedback";

  //     $qSql="SELECT * from
  //       (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
  //       (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
  //       (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
  //       (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_coaching_v1_feedback where id='$pnid') xx Left Join
  //       (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
  //     $data["auditData"] = $this->Common_model->get_query_row_array($qSql);

  //     if($this->input->post('pnid'))
  //     {
  //       $pnid=$this->input->post('pnid');
  //       $curDateTime=CurrMySqlDate();
  //       $log=get_logs();

  //       $field_array1=array(
  //         "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
  //         "agent_rvw_note" => $this->input->post('note'),
  //         "agent_rvw_date" => $curDateTime
  //       );
  //       $this->db->where('id', $pnid);
  //       $this->db->update('qa_coaching_v1_feedback',$field_array1);
  //       redirect('Qa_att/agent_att_feedback');

  //     }else{
  //       $this->load->view('dashboard',$data);
  //     }
  //   }
  // }
  
  
  public function agent_whitespace_rvw($pnid){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['pnid']=$pnid;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/whitespace/agent_whitespace_rvw.php";
      $data["content_js"] = "qa_audit_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_att_fiberconnect_whitespace_feedback where id='$pnid') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["auditData"] = $this->Common_model->get_query_row_array($qSql);

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
        $this->db->update('qa_att_fiberconnect_whitespace_feedback',$field_array1);
        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }

  public function agent_greenspace_rvw($pnid){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['pnid']=$pnid;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/greenspace/agent_greenspace_rvw.php";
      $data["content_js"] = "qa_fiberconnect_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_greenspace_feedback where id='$pnid') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["greenspace_data"] = $this->Common_model->get_query_row_array($qSql);

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
        $this->db->update('qa_fiberconnect_greenspace_feedback',$field_array1);
        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }

  //vikas//
  public function agent_whitespace_v1_rvw($pnid){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['pnid']=$pnid;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/fiberconnect/agent_whitespace_v1_rvw.php";
      $data["content_js"] = "qa_fiberconnect_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_fiberconnect_whitespace_v1_feedback where id='$pnid') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["whitespace_v1_data"] = $this->Common_model->get_query_row_array($qSql);

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
        $this->db->update('qa_fiberconnect_whitespace_v1_feedback',$field_array1);
        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }

  public function agent_at_t_first_net_loyalty_coaching_rvw($pnid){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['pnid']=$pnid;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/first_net_loyalty/agent_at_t_first_net_loyalty_coaching_rvw.php";
     // $data["content_js"] = "qa_fiberconnect_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $cond='';
			
			$cond .= " where id =157";
			
			$qSql="SELECT * FROM client $cond";
      $data['client']= $this->Common_model->get_query_row_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent') and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM process where client_id =157 and is_active = 1";
			$data['process']= $this->Common_model->get_query_result_array($qSql);

      // $qSql="SELECT * from
      //   (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
      //   (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
      //   (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
      //   (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_at_t_first_net_loyalty_coaching_feedback where id='$pnid') xx Left Join
      //   (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

        $qSql="SELECT Q.*, S.fusion_id, S.dept_id, CONCAT(S.fname, ' ', S.lname) as agent_name, S.assigned_to, CONCAT(T.fname, ' ', T.lname) as tl_name, get_client_ids(Q.agent_id) as client_id, get_client_names(Q.agent_id) as client_name, get_process_names(Q.agent_id) AS process_name, CONCAT(A.fname, ' ', A.lname)  AS auditor_name, audit_date,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=Q.agent_id)) as department_name,
				(SELECT office_name from office_location ol where ol.abbr=(SELECT office_id from signin sol where sol.id=Q.agent_id)) as location
				from qa_at_t_first_net_loyalty_coaching_feedback Q 
				Left Join signin S on Q.agent_id = S.id
				Left Join signin T on T.id = S.assigned_to
				Left Join signin A on Q.entry_by = A.id 
				WHERE Q.id=$pnid";

      $data["auditData"] = $this->Common_model->get_query_row_array($qSql);

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
        $this->db->update('qa_at_t_first_net_loyalty_coaching_feedback',$field_array1);
        redirect('Qa_att/agent_att_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }

// ///////////////////////////////////////////////////////////////////////////////////////////	 
// ////////////////////////////////////// QA oyo_inb REPORT //////////////////////////////////////	
// ///////////////////////////////////////////////////////////////////////////////////////////

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




	
	
 }