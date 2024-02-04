<?php  
 
 class Qa_awareness_new extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
		$this->load->model('Qa_philip_model');
	}
	
	
    private function edu_upload_files($files,$path)
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
	
	
	
	public function index()
	{
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/qa_awareness_new_feedback.php";
			$data["content_js"] = "qa_awareness_js.php";		
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,22) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
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
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_awareness_chat_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["awereness_list"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_awareness_email_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["awereness_email_list"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_awareness_phone_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["awereness_phone_list"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_awareness_new($pre_booking_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/add_awareness_chat_new.php";
			// $data["content_js"] = "qa_awareness_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data['pre_booking_id']=$pre_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,22) and is_assign_process(id,34) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_awareness_chat_new_feedback where id='$pre_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["awareness"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			$b = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($pre_booking_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/awareness/');
					$field_array["attach_file"] = implode(',',$a);
				///////////
					$b = $this->edu_upload_files($_FILES['attach_img_file'], $path='./qa_files/awareness/');
					$field_array["attach_img_file"] = implode(',',$b);
					
					$rowid= data_inserter('qa_awareness_chat_new_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_awareness_chat_new_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_awareness_chat_new_feedback',$field_array1);
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
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_awareness_chat_new_feedback',$edit_array);
					
				}
				redirect('Qa_awareness_new');
			}
			$data["array"] = $a;
			$data["array"] = $b;
			$this->load->view("dashboard",$data);
		}
	}



	public function add_edit_awareness_email_new($pre_booking_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/add_awareness_email_new.php";
			// $data["content_js"] = "qa_awareness_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data['pre_booking_id']=$pre_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,22) and is_assign_process(id,34) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_awareness_email_new_feedback where id='$pre_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["awareness"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			$b = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($pre_booking_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/awareness/');
					$field_array["attach_file"] = implode(',',$a);
				///////////
					$b = $this->edu_upload_files($_FILES['attach_img_file'], $path='./qa_files/awareness/');
					$field_array["attach_img_file"] = implode(',',$b);
					
					$rowid= data_inserter('qa_awareness_email_new_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_awareness_email_new_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_awareness_email_new_feedback',$field_array1);
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
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_awareness_email_new_feedback',$edit_array);
					
				}
				redirect('Qa_awareness_new');
			}
			$data["array"] = $a;
			$data["array"] = $b; 
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_awareness_phone_new($pre_booking_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/add_awareness_phone_new.php";
			// $data["content_js"] = "qa_awareness_js.php";
			$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data['pre_booking_id']=$pre_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,22) and is_assign_process(id,34) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_awareness_phone_new_feedback where id='$pre_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["awareness"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($pre_booking_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/awareness/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_awareness_phone_new_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_awareness_phone_new_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_awareness_phone_new_feedback',$field_array1);
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
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_awareness_phone_new_feedback',$edit_array);
					
				}
				redirect('Qa_awareness_new');
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


/////////////////////////////////////////////////////////////


	public function agent_awareness_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/agent_awareness_feedback.php";
			$data["content_js"] = "qa_clio_js.php";	
			$data["agentUrl"] = "qa_awareness/process/agent";		
			$campaign="";
			$campaign = $this->input->get('campaign');
			$qSql="Select count(id) as value from qa_awareness_chat_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','WOW Call')";
			$data["tot_pre_feedback"] =  $this->Common_model->get_single_value($qSql);

			

			 $qSql="Select count(id) as value from qa_awareness_chat_new_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','WOW Call')";
			$data["yet_pre_rvw"] =  $this->Common_model->get_single_value($qSql);


			
			
			$from_date = '';
			$to_date = '';
			$cond="";

			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','WOW Call')";

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_awareness_chat_new_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["awareness_list"] = $this->Common_model->get_query_result_array($qSql);

				
				
			}else{
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_awareness_chat_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','WOW Call')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["awareness_list"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['campaign']=$campaign;
			$this->load->view("dashboard",$data);
		}
	}

	public function agent_awareness_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/agent_awareness_rvw.php";
			$data["agentUrl"] = "qa_awareness/process/agent";

			$data["pre_booking_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_awareness_chat_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["awareness"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('pre_booking_id'))
			{
				$pre_booking_id=$this->input->post('pre_booking_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pre_booking_id);
				$this->db->update('qa_awareness_chat_new_feedback',$field_array);
				redirect('qa_awareness/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}



	public function agent_awareness_email_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/agent_awareness_email_rvw.php";
			$data["agentUrl"] = "qa_awareness/process/agent";

			$data["pre_booking_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_awareness_email_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["awareness"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('pre_booking_id'))
			{
				$pre_booking_id=$this->input->post('pre_booking_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pre_booking_id);
				$this->db->update('qa_awareness_email_new_feedback',$field_array);
				redirect('qa_awareness/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


	public function agent_awareness_phone_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_awareness/agent_awareness_phone_rvw.php";
			$data["agentUrl"] = "qa_awareness/process/agent";

			$data["pre_booking_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_awareness_phone_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["awareness"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('pre_booking_id'))
			{
				$pre_booking_id=$this->input->post('pre_booking_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pre_booking_id);
				$this->db->update('qa_awareness_phone_new_feedback',$field_array);
				redirect('qa_awareness/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
	

	public function qa_awareness_new_report(){
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
			$data["content_template"] = "qa_awareness/qa_awareness_new_report.php";
			$data["content_js"] = "qa_clio_js.php";
			
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
			$data["qa_awareness_list"] = array();
			
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

					 $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_new_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $ops_cond order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_awareness_list"] = $fullAray;
				$this->create_qa_awareness_CSV($fullAray,$campaign);	
				$dn_link = base_url()."Qa_awareness_new/download_qa_awareness_CSV/".$campaign;	
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

	public function download_qa_awareness_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_awareness_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "Qa_awareness_new";
		
		$fopen = fopen($filename,"w+");
		    if($campaign=='awareness_chat'){

			$header = array("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Call Date","Audit Type ","ACPT","Case/Ticket","Product","Cust Rate","Auditor Type ","VOC ","Audit Link","Overall Score ","Possible Score ","Earned Score ","Customer Score ","Business Score ","Compliance Score ","Agent verify Username / Email Address for correct account.","Setting proper expectation to the customer.","Did the agent ask if there is anything that they can do to enhance customer experience before interaction ends?","Did the agent follow correct / proper procedure?","Did the agent create a case and document properly Agent put appropriate tagging to every interaction.","The agent greet and identified themselves to the customer.","The agent showed politeness courtesy and professionalism throughout interaction Showed empathy as appropriate.","Perform logical troubleshooting steps and uses targeted probing questions Pays attention to key words and phrases to quickly determine the issue and all questions are tailored fit to the customer.","The agent must thank the customer for contacting at the end of every chat session.","Agent verify Username / Email Address for correct account Comments ","Setting proper expectation to the customer Comments ","Did the agent ask if there is anything that they can do to enhance customer experience before interaction ends Comments","Did the agent follow correct / proper procedure Comments","Did the agent create a case and document properly Agent put appropriate tagging to every interaction Comments ","The agent greet and identified themselves to the customer Comments ","Showed empathy as appropriate Comments "," all questions are tailored fit to the customer Comments","The agent must thank the customer for contacting at the end of every chat session Comments","Call Summary ","Feedback ","Agent Feedback","Agent review note ","Mgnt review by ","Mgnt review note ","Client review by ","Client review note ","Client_rvw_date");
		    }else if($campaign=='awareness_email'){
			$header = array("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Call Date","Audit Type ","ACPT","Case/Ticket","Product","Cust Rate","Auditor Type ","VOC ","Audit Link","Overall Score ","Possible Score ","Earned Score ","Customer Score ","Business Score ","Compliance Score ","Setting proper expectation to the customer.","Did the agent tag the interaction accordingly?","Did the agent ask if there is anything that they can do to enhance customer experience before interaction ends?","Did the agent follow correct / proper procedure?","The agent showed politeness courtesy and professionalism throughout interaction.","Acknowledges and responds to the customer’s emotional statements Expresses empathy appropriately.","Must address all concern in an interaction if already provided by the customer without letting them to repeat it.","Accurately communicates to the customer Thought and sentence construction must be understandable enough not to confuse the customer.","Perform logical troubleshooting steps and uses targeted probing questions Pays attention to key words and phrases to quickly determine the issue and all questions are tailored fit to the customer.","Setting proper expectation to the customer Comments","Did the agent tag the interaction accordingly Comments","Did the agent ask if there is anything that they can do to enhance customer experience before interaction ends Comments","Did the agent follow correct / proper procedure Comments","professionalism throughout interaction Comments","Expresses empathy appropriately Comments","Must address all concern in an interaction if already provided by the customer without letting them to repeat it Comments ","Thought and sentence construction must be understandable enough not to confuse the customer Comments","all questions are tailored fit to the customer Comments","Call Summary ","Feedback ","Agent Feedback","Agent review note ","Mgnt review by ","Mgnt review note ","Client review by ","Client review note ","Client_rvw_date");
		      } else if($campaign=='awareness_phone'){
			$header = array("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Call Date","Audit Type ","ACPT","Case/Ticket","Product","Cust Rate","Auditor Type ","VOC ","Audit Link","Overall Score ","Possible Score ","Earned Score ","Customer Score ","Business Score ","Compliance Score ","Agent verify Username / Email Address for correct account.","Setting proper expectation to the customer.","Did the agent ask if there is anything that they can do to enhance customer experience before interaction ends?","Did the agent follow correct / proper procedure based on company policy and/or mandated guidelines?","The agent greet and identified themselves to the customer Warm and genuine tone of voice must be displayed to show willingness to assist.","Ask customer name and use it appropriately.","Paraphrase demonstrate active listening and acknowledge all statements / concerns.","Must display confidence and act professional throughout the call.","Acknowledges and responds to the customer’s emotional statements Expresses empathy appropriately.","Refrain from an excessive dead air or awkward silence.","The agent must thank the customer for contacting to properly end the call.","Agent verify Username / Email Address for correct account Comments","Setting proper expectation to the customer Comments","Did the agent ask if there is anything that they can do to enhance customer experience before interaction ends Comments"," proper procedure based on company policy and/or mandated guidelines Comments","Warm and genuine tone of voice must be displayed to show willingness to assist Comments","Ask customer name and use it appropriately Comments","acknowledge all statements / concerns Comments","Must display confidence and act professional throughout the call Comments","Expresses empathy appropriately Comments","Refrain from an excessive dead air or awkward silence Comments ","The agent must thank the customer for contacting to properly end the call Comments","Call Summary ","Feedback ","Agent Feedback","Agent review note ","Mgnt review by ","Mgnt review note ","Client review by ","Client review note ","Client_rvw_date");
		      } 
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		    if($campaign=='awareness_chat'){
		    	$edit_url = "add_edit_awareness_new";
		        $main_url =  $currentURL.''.$controller.'/'.$edit_url;
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
				
				$row = '"'.$auditorName.'",';
		        $row .= '"'.$user['audit_date'].'",';
		        $row .= '"'.$user['fusion_id'].'",';
		        $row .= '"'.$user['fname']." ".$user['lname'].'",';
		        $row .= '"'.$user['tl_name'].'",';
		        $row .= '"'.$user['call_date'].'",';
		        $row .= '"'.$user['audit_type'].'",';
		        
		        $row .= '"'.$user['acpt'].'",';
		        $row .= '"'.$user['caseTicket'].'",';
		        $row .= '"'.$user['product'].'",';
		        $row .= '"'.$user['cust_rate'].'",';
		        $row .= '"'.$user['auditor_type'].'",';
		        $row .= '"'.$user['voc'].'",';
		        $row .= '"'.$main_urls.'",';
		        $row .= '"'.$user['overall_score'].'"%,';
		        $row .= '"'.$user['possible_score'].'",';
		        $row .= '"'.$user['earned_score'].'",';

		        $row .= '"'.$user['cust_score'].'",';
		        $row .= '"'.$user['busi_score'].'",';
		        $row .= '"'.$user['comp_score'].'",';

		        $row .= '"'.$user['Category1'].'",';
		        $row .= '"'.$user['Category2'].'",';
		        $row .= '"'.$user['Category3'].'",';
		        $row .= '"'.$user['Category4'].'",';
		        $row .= '"'.$user['Category5'].'",';
		        $row .= '"'.$user['Category6'].'",';
		        $row .= '"'.$user['Category7'].'",';
		        $row .= '"'.$user['Category8'].'",';
		        $row .= '"'.$user['Category9'].'",';
		       

		        $row .= '"'.$user['cmt1'].'",';
		        $row .= '"'.$user['cmt2'].'",';
		        $row .= '"'.$user['cmt3'].'",';
		        $row .= '"'.$user['cmt4'].'",';
		        $row .= '"'.$user['cmt5'].'",';
		        $row .= '"'.$user['cmt6'].'",';
		        $row .= '"'.$user['cmt7'].'",';
		        $row .= '"'.$user['cmt8'].'",';
		        $row .= '"'.$user['cmt9'].'",';
		        
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';

				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		  }
		  if($campaign=='awareness_email'){
		  	$edit_url = "add_edit_awareness_email_new";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;
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
				
				$row = '"'.$auditorName.'",';
		        $row .= '"'.$user['audit_date'].'",';
		        $row .= '"'.$user['fusion_id'].'",';
		        $row .= '"'.$user['fname']." ".$user['lname'].'",';
		        $row .= '"'.$user['tl_name'].'",';
		        $row .= '"'.$user['call_date'].'",';
		        $row .= '"'.$user['audit_type'].'",';
		        
		        $row .= '"'.$user['acpt'].'",';
		        $row .= '"'.$user['caseTicket'].'",';
		        $row .= '"'.$user['product'].'",';
		        $row .= '"'.$user['cust_rate'].'",';
		        $row .= '"'.$user['auditor_type'].'",';
		        $row .= '"'.$user['voc'].'",';
		        $row .= '"'.$main_urls.'",';


		        $row .= '"'.$user['overall_score'].'"%,';
		        $row .= '"'.$user['possible_score'].'",';
		        $row .= '"'.$user['earned_score'].'",';

		        $row .= '"'.$user['cust_score'].'",';
		        $row .= '"'.$user['busi_score'].'",';
		        $row .= '"'.$user['comp_score'].'",';

		        $row .= '"'.$user['Category1'].'",';
		        $row .= '"'.$user['Category2'].'",';
		        $row .= '"'.$user['Category3'].'",';
		        $row .= '"'.$user['Category4'].'",';
		        // $row .= '"'.$user['Category5'].'",';
		        $row .= '"'.$user['Category6'].'",';
		        $row .= '"'.$user['Category7'].'",';
		        $row .= '"'.$user['Category8'].'",';
		        $row .= '"'.$user['Category9'].'",';
		        $row .= '"'.$user['Category10'].'",';
		       

		        $row .= '"'.$user['cmt1'].'",';
		        $row .= '"'.$user['cmt2'].'",';
		        $row .= '"'.$user['cmt3'].'",';
		        $row .= '"'.$user['cmt4'].'",';
		        // $row .= '"'.$user['cmt5'].'",';
		        $row .= '"'.$user['cmt6'].'",';
		        $row .= '"'.$user['cmt7'].'",';
		        $row .= '"'.$user['cmt8'].'",';
		        $row .= '"'.$user['cmt9'].'",';
		        $row .= '"'.$user['cmt10'].'",';
		        


               $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';

				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		  }
		  if($campaign=='awareness_phone'){
		  	$edit_url = "add_edit_awareness_phone_new";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;
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
				
				$row = '"'.$auditorName.'",';
		        $row .= '"'.$user['audit_date'].'",';
		        $row .= '"'.$user['fusion_id'].'",';
		        $row .= '"'.$user['fname']." ".$user['lname'].'",';
		        $row .= '"'.$user['tl_name'].'",';
		        $row .= '"'.$user['call_date'].'",';
		        $row .= '"'.$user['audit_type'].'",';
		        
		        $row .= '"'.$user['acpt'].'",';
		        $row .= '"'.$user['caseTicket'].'",';
		        $row .= '"'.$user['product'].'",';
		        $row .= '"'.$user['cust_rate'].'",';
		        $row .= '"'.$user['auditor_type'].'",';
		        $row .= '"'.$user['voc'].'",';
		        $row .= '"'.$main_urls.'",';


		        $row .= '"'.$user['overall_score'].'"%,';
		        $row .= '"'.$user['possible_score'].'",';
		        $row .= '"'.$user['earned_score'].'",';

		        $row .= '"'.$user['cust_score'].'",';
		        $row .= '"'.$user['busi_score'].'",';
		        $row .= '"'.$user['comp_score'].'",';

		        $row .= '"'.$user['Category1'].'",';
		        $row .= '"'.$user['Category2'].'",';
		        $row .= '"'.$user['Category3'].'",';
		        $row .= '"'.$user['Category4'].'",';
		        // $row .= '"'.$user['Category5'].'",';
		        $row .= '"'.$user['Category6'].'",';
		        $row .= '"'.$user['Category7'].'",';
		        $row .= '"'.$user['Category8'].'",';
		        $row .= '"'.$user['Category9'].'",';
		        $row .= '"'.$user['Category10'].'",';
		        $row .= '"'.$user['Category11'].'",';
		        $row .= '"'.$user['Category12'].'",';
		       

		        $row .= '"'.$user['cmt1'].'",';
		        $row .= '"'.$user['cmt2'].'",';
		        $row .= '"'.$user['cmt3'].'",';
		        $row .= '"'.$user['cmt4'].'",';
		        // $row .= '"'.$user['cmt5'].'",';
		        $row .= '"'.$user['cmt6'].'",';
		        $row .= '"'.$user['cmt7'].'",';
		        $row .= '"'.$user['cmt8'].'",';
		        $row .= '"'.$user['cmt9'].'",';
		        $row .= '"'.$user['cmt10'].'",';
		        $row .= '"'.$user['cmt11'].'",';
		        $row .= '"'.$user['cmt12'].'",';
		        
	
              	$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';

				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		  }

    }
	
	////////////////////////////////////////////////////////////////////

	function import_at_chat_excel_data(){
		
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
			$clmarr = array("audit_date","auditor_mwp_id","fusion_id","call_date","call_duration","Channel","caseTicket","product","acpt","cust_rate","call_id","call_type","audit_type","auditor_type","voc","busi_score","cust_score","comp_score","overall_score","possible_score","earned_score","Category1","Category2","Category3","Category4","Category5","Category6","Category7","Category8","Category9","Category10","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","call_summary","feedback");
			
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
						}else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->at_chat_data($user_list);
				redirect('Qa_awareness_new');
			}
		}
	}

	function import_at_email_excel_data(){
		
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
			$clmarr = array("audit_date","auditor_mwp_id","fusion_id","call_date","call_duration","Channel","caseTicket","product","acpt","cust_rate","call_id","call_type","audit_type","auditor_type","voc","busi_score","cust_score","comp_score","overall_score","possible_score","earned_score","Category1","Category2","Category3","Category4","Category5","Category6","Category7","Category8","Category9","Category10","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","call_summary","feedback");
			
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

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->at_email_data($user_list);
				redirect('Qa_awareness_new');
			}
		}
	}

	function import_at_voice_excel_data(){
		
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
			$clmarr = array("audit_date","auditor_mwp_id","fusion_id","call_date","call_duration","Channel","caseTicket","product","acpt","cust_rate","call_id","call_type","audit_type","auditor_type","voc","busi_score","cust_score","comp_score","overall_score","possible_score","earned_score","Category1","Category2","Category3","Category4","Category5","Category6","Category7","Category8","Category9","Category10","Category11","Category12","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","call_summary","feedback");
			
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

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->at_voice_data($user_list);
				redirect('Qa_awareness_new');
			}
		}
	}

	public function sample_at_chat_download(){
		if(check_logged_in()){ 
			 $file_name = base_url()."qa_files/qa_sycn/sample_at_chat_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_at_email_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_sycn/sample_at_email_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_at_voice_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_sycn/sample_at_voice_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
}