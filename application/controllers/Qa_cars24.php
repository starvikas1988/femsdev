<?php  
 
 class Qa_cars24 extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}
	
	
    /* private function edu_upload_files($files,$path)
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
    } */
	
	
	private function edu_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
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
			$data["content_template"] = "qa_cars24/qa_cars24_feedback.php";
			$data["content_js"] = "qa_cars24_js.php";		
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$cond='';
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_pre_booking_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["pre_booking_list"] = $this->Common_model->get_query_result_array($qSql);
		////////////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_cars_pre_booking_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["pre_booking_new_list"] = $this->Common_model->get_query_result_array($qSql);
		//////////////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_live_snooping_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["live_snooping"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_post_booking_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["post_booking_list"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_post_booking_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["post_booking_new_list"] = $this->Common_model->get_query_result_array($qSql);
		////////////////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_post_delivery_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["post_delivery_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////Pre Booking Audit//////////////////////////////
	public function add_edit_pre_booking($pre_booking_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/add_edit_pre_booking.php";
			$data["content_js"] = "qa_cars24_js.php";
			$data['pre_booking_id']=$pre_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,246) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cars24_pre_booking_feedback where id='$pre_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["pre_booking"] = $this->Common_model->get_query_row_array($qSql);
			

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
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cars24_pre_booking_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cars24_pre_booking_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_cars24_pre_booking_feedback',$field_array1);
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
					$this->db->update('qa_cars24_pre_booking_feedback',$edit_array);
					
				}
				redirect('qa_cars24');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////New Pre Booking Audit//////////////////////////////
	public function add_edit_pre_booking_new($pre_booking_id){

		if(check_logged_in())
		{
			// echo '<pre>'; print_r($this->input->post('data')); exit();
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/add_edit_pre_booking_new.php";
			$data["content_js"] = "qa_cars24_js_new.php";
			$data['pre_booking_id']=$pre_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,246) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			 $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cars24_pre_booking_new_feedback where id='$pre_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["pre_booking"] = $this->Common_model->get_query_row_array($qSql);
			

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
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cars24_pre_booking_new_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cars24_pre_booking_new_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_cars24_pre_booking_new_feedback',$field_array1);
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
					$this->db->update('qa_cars24_pre_booking_new_feedback',$edit_array);
					
				}
				redirect('qa_cars24');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}	


	public function add_edit_live_snooping($pre_booking_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/add_edit_live_snooping.php";
			// $data["content_js"] = "qa_cars24_js_new.php";
			$data["content_js"] = "qa_ameridial_js.php";
			$data['pre_booking_id']=$pre_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,246) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cars24_live_snooping_feedback where id='$pre_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["live_snooping"] = $this->Common_model->get_query_row_array($qSql);
			

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
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cars24_live_snooping_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cars24_live_snooping_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_cars24_live_snooping_feedback',$field_array1);
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
					$this->db->update('qa_cars24_live_snooping_feedback',$edit_array);
					
				}
				redirect('qa_cars24');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}



	public function add_edit_cars_pre_booking_new($pre_booking_id){

		if(check_logged_in())
		{	
			$data['controller'] = $this;
			//echo '<pre>'; print_r($this->input->post('data')); exit();
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/add_edit_cars_pre_booking_new.php";
			$data["content_js"] = "qa_cars24_js_new.php";
			$data['pre_booking_id']=$pre_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,246) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cars24_cars_pre_booking_new_feedback where id='$pre_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name, DATEDIFF(CURDATE(), created_date) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["pre_booking"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($pre_booking_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cars24_cars_pre_booking_new_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cars24_cars_pre_booking_new_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pre_booking/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $pre_booking_id);
					$this->db->update('qa_cars24_cars_pre_booking_new_feedback',$field_array1);
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
					$this->db->update('qa_cars24_cars_pre_booking_new_feedback',$edit_array);
					
				}

				// echo '<pre>'; print_r($this->input->post()); //exit();
				redirect('qa_cars24');
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

///////////////////////////////Post Booking Audit////////////////////////////////////

	public function add_edit_post_booking($post_booking_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/add_edit_post_booking.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['post_booking_id']=$post_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,246) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cars24_post_booking_feedback where id='$post_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["post_booking"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($post_booking_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/post_booking/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cars24_post_booking_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cars24_post_booking_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/post_booking/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $post_booking_id);
					$this->db->update('qa_cars24_post_booking_feedback',$field_array1);
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
					$this->db->where('id', $post_booking_id);
					$this->db->update('qa_cars24_post_booking_feedback',$edit_array);
					
				}
				redirect('qa_cars24');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}



//////////////////////////////////Post Booking New AUdit//////////////////////////////////

	public function add_edit_post_booking_new($post_booking_id){

		if(check_logged_in())
		{
			$data['controller'] = $this;
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/add_edit_post_booking_new.php";
			// $data["content_js"] = "qa_clio_js.php";
			$data["content_js"] = "qa_cars24_js_new.php";
			$data['post_booking_id']=$post_booking_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,246) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cars24_post_booking_new_feedback where id='$post_booking_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["post_booking"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($post_booking_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/post_booking/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cars24_post_booking_new_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cars24_post_booking_new_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/post_booking/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $post_booking_id);
					$this->db->update('qa_cars24_post_booking_new_feedback',$field_array1);
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
					$this->db->where('id', $post_booking_id);
					$this->db->update('qa_cars24_post_booking_new_feedback',$edit_array);
					
				}
				redirect('qa_cars24');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

   
//////////////////// Post Delivery ///////////////////////

	public function add_edit_post_delivery($post_delivery_id)
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/add_edit_post_delivery.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['post_delivery_id']=$post_delivery_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,246) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cars24_post_delivery_feedback where id='$post_delivery_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid)";
			$data["post_delivery"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($post_delivery_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/post_delivery/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cars24_post_delivery_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cars24_post_delivery_feedback',$add_array);
					
				}else{
					
					$field_array=$this->input->post('data');
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/post_delivery/');
						$field_array['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $post_delivery_id);
					$this->db->update('qa_cars24_post_delivery_feedback',$field_array);
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
					$this->db->where('id', $post_delivery_id);
					$this->db->update('qa_cars24_post_delivery_feedback',$edit_array);
					
				}
				redirect('qa_cars24');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
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
/////////////////Cars24 Agent part//////////////////////////	

	public function agent_cars24_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/agent_cars24_feedback.php";
			$data["content_js"] = "qa_clio_js.php";	
			$data["agentUrl"] = "qa_cars24/agent_cars24_feedback";		
			$campaign="";
			$campaign = $this->input->get('campaign');
			$qSql="Select count(id) as value from qa_cars24_pre_booking_new_feedback where agent_id='$current_user'";
			$data["tot_pre_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_cars24_pre_booking_new_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_pre_rvw"] =  $this->Common_model->get_single_value($qSql);


			$qSql="Select count(id) as value from qa_cars24_cars_pre_booking_new_feedback where agent_id='$current_user'";
			$data["tot_pre_new_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_cars24_cars_pre_booking_new_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_pre_new_rvw"] =  $this->Common_model->get_single_value($qSql);


			$qSql="Select count(id) as value from qa_cars24_live_snooping_feedback where agent_id='$current_user'";
			$data["tot_live_snooping_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_cars24_live_snooping_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_live_snooping_rvw"] =  $this->Common_model->get_single_value($qSql);


			$qSql="Select count(id) as value from qa_cars24_post_booking_feedback where agent_id='$current_user'";
			$data["tot_post_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_cars24_post_booking_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_post_rvw"] =  $this->Common_model->get_single_value($qSql);


			$qSql="Select count(id) as value from qa_cars24_post_delivery_feedback where agent_id='$current_user'";
			$data["tot_delivery_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_cars24_post_delivery_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_delivery_rvw"] =  $this->Common_model->get_single_value($qSql);

			
			$from_date = '';
			$to_date = '';
			$cond="";

			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_pre_booking_new_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["pre_booking_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_cars_pre_booking_new_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["pre_booking_new_list"] = $this->Common_model->get_query_result_array($qSql);


				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_live_snooping_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["live_snooping"] = $this->Common_model->get_query_result_array($qSql);
			///////////////////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_post_booking_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["post_booking_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////////////////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_post_delivery_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["post_delivery_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}else{
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_pre_booking_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["pre_booking_list"] = $this->Common_model->get_query_result_array($qSql);


				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_cars_pre_booking_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["pre_booking_new_list"] = $this->Common_model->get_query_result_array($qSql);


				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_live_snooping_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["live_snooping"] = $this->Common_model->get_query_result_array($qSql);
			///////////////////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_post_booking_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["post_booking_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////////////////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_post_delivery_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["post_delivery_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['campaign']=$campaign;
			$this->load->view("dashboard",$data);
		}
	}

	public function agent_post_delivery_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/agent_post_delivery_feedback_rvw.php";
			$data["agentUrl"] = "qa_cars24/agent_cars24_feedback";

			$data["post_delivery_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_cars24_post_delivery_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["post_delivery"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('post_delivery_id'))
			{
				$post_delivery_id=$this->input->post('post_delivery_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $post_delivery_id);
				$this->db->update('qa_cars24_post_delivery_feedback',$field_array);
				redirect('qa_cars24/agent_cars24_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
	public function agent_pre_booking_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/agent_pre_booking_feedback_rvw.php";
			$data["agentUrl"] = "qa_cars24/agent_cars24_feedback";
			$data["pre_booking_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_cars24_pre_booking_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["pre_booking"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_cars24_pre_booking_new_feedback',$field_array);
				redirect('qa_cars24/agent_cars24_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


	public function agent_live_snooping_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/agent_live_snooping_feedback_rvw.php";
			$data["agentUrl"] = "qa_cars24/agent_cars24_feedback";
			$data["pre_booking_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_cars24_live_snooping_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["live_snooping"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_cars24_live_snooping_feedback',$field_array);
				redirect('qa_cars24/agent_cars24_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}



	public function agent_pre_booking_new_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/agent_pre_booking_new_feedback_rvw.php";
			$data["agentUrl"] = "qa_cars24/agent_cars24_feedback";
			$data["pre_booking_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_cars24_cars_pre_booking_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["pre_booking"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_cars24_cars_pre_booking_new_feedback',$field_array);
				redirect('qa_cars24/agent_cars24_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_post_booking_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cars24/agent_post_booking_feedback_rvw.php";
			$data["agentUrl"] = "qa_cars24/agent_cars24_feedback";

			$data["post_booking_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_cars24_post_booking_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["post_booking"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('post_booking_id'))
			{
				$post_booking_id=$this->input->post('post_booking_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $post_booking_id);
				$this->db->update('qa_cars24_pre_booking_feedback',$field_array);
				redirect('qa_cars24/agent_cars24_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function qa_cars24_report(){
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
			$data["content_template"] = "qa_cars24/qa_cars24_report.php";
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
			$data["qa_pre_list"] = array();
			
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

					 $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cars24_".$campaign."_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $ops_cond order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_pre_list"] = $fullAray;
				$this->create_qa_pre_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_cars24/download_qa_pre_CSV/".$campaign;	
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

	public function download_qa_pre_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_pre_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		    if($campaign=='pre_booking'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date","Actual Tagging:","Agent Tagging","Campaign","Call Duration","Agent Tenure","Customer Contact Number","Audit Type", "Auditor Type", "Voc","Standardization","Sales Pitch/Resolution","Tagging","Communication","Critical Parameters","Overall Score","Opening done within 5 Secs as per the defined skill","Self Introduction/Company Name","Customer Identification","Purpose of the call", "Hold/Un-Hold Script followed","Dead Air","Call Summarization  for Interested Customers","Further assistance","Closing Script","Probing - On Car selection","Probing - Customer refusal reason","Probing - Customer refusal relevant alternatives (If Required)","Probing- Others","All customer queries addressed effectively","Effective Rebuttals and objection handling used to encourage the customer to confirm the booking","Comprehensive Warranty & CARS24 Quality Standards covered","7 day trial & Hassle-free RC transfer","CARS 24 Consumer Finance & Benefits","Car Details- Make/Model confirmed","Payment Type confirmation","Loan details capturing & offer sharing(If any)","Loan documents information & link triggering (If applicable)","Delivery Type Date & Location confirmation (Hub-Pick Up/ Home Delivery)","Shipping Charges & RTO Charges Information (If Applicable)","Booking and final payment amount confirmation","RC Transfer documents information","Customer Email-ID confirmation","Whats app Opt-in pitching (where required)","Correct Dispostion captured","Correct Remarks captured","Voice Modulation","Language switching as per the requirement","Interruption","Rate of Speech","Voice Clarity","MTI/ RTI /Pronuncation","Grammatical errors","Unprofessional Tone","Attentiveness","Forcefull Booking","Incorrect Information/Misleading information","Rude behaviour Profanity offensive /Abusive","Call Disconnection","Opening Comment 1","Opening Comment 2","Opening Comment 3","Opening Comment 4","Hold/On-Hold comment 1","Hold/On-Hold Comment 2","Closing Comment 1","Closing Comment 2","Closing Comment 3","Relevant probing done to understand the customer needs and concern Comment 1","Relevant probing done to understand the customer needs and concern Comment 2","Relevant probing done to understand the customer needs and concern Comment 3","Relevant probing done to understand the customer needs and concern Comment 4","Effective addressal of customer queries Comment 1","Effective Rebuttals Comment 1","USPs & Process Information Comment 1","USPs & Process Information Comment 2","USPs & Process Information Comment 3","Booking & Consumer finance Process Comment 1","Booking & Consumer finance Process Comment 2","Booking & Consumer finance Process Comment 3","Booking & Consumer finance Process Comment 4","Booking & Consumer finance Process Comment 5","Booking & Consumer finance Process Comment 6","Booking & Consumer finance Process Comment 7","Booking & Consumer finance Process Comment 8","Booking & Consumer finance Process Comment 9","Booking & Consumer finance Process Comment 10","Disposition/Remarks comment 1","Disposition/Remarks comment 2","Soft Skills Comment 1","Soft Skills Comment 2","Soft Skills Comment 3","Soft Skills Comment 4","Soft Skills Comment 5","Soft Skills Comment 6","Soft Skills Comment 7","Soft Skills Comment 8","Soft Skills Comment 9","Critical Error Comment 1","Critical Error Comment 2","ZTP Comment 1","ZTP Comment 2","Call Summary", "Feedback","Probability of Booking basis the call","Factors that could impact Booking","Reasons for impact on Booking (ACPT)","Reasons for impact on Booking (WHY 1)","Reasons for impact on Booking (WHY 2)", "Overall feel of the call basis Sales Pitch","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		    }else if($campaign=='pre_booking_new'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date","Actual Tagging:","Agent Tagging","Campaign","Call Duration","Agent Tenure","Customer Contact Number","Audit Type", "Auditor Type", "Voc","Overall Score","Did the advisor open the call correctly?","opening_done_within_no_reason","cmt1","Did the advisor follow the customer identification process?","self_introduction_no_reason","cmt2","Did the advisor share the purpose of the call with the customer?","cmt3","Did the advisor ask appropriate fact-finding questions/do probing for the car booking?","purpose_of_the_call_no_reason","cmt4","Did the advisor use effective rebuttals/sales and objection handling to encourage the customer to confirm the booking?","cmt5","Did the advisor answer all customer queries effectively/ understanding the customer's concern/ comprehending well?","customer_concern_no_reason","cmt6","Did the advisor inform Comprehensive Warranty & CARS24 Quality Standards /7 day trial & Hassle-free RC transfer/CARS24 Consumer Finance & Benefits?","comprehensive_warranty_no_reason","cmt7","Did the advisor inform Car Details- Make/Model confirmed /Delivery Type Date & Location confirmation (Hub-Pick Up/ Home Delivery)","delivery_type_no_reason","cmt8","Did the advisor inform RC Transfer documents & RTO Charges Information (If Applicable)?","rc_ransfer_documents_no_reason","cmt9","Did the advisor confirm/capture the customer's Email-id confirmation/Whatsapp Opt-in pitching (if required)","whats_app_opt_no_reason","cmt10","Did the advisor share the Order link/Car link?","car_details_link_no_reason","cmt11","Did the advisor inform about the booking and final payment amount?","payment_type_confirmation_no_reason","cmt12","Did the advisor convince the customer to try to book a car on call?","cmt13","Did the advisor share a pre-approved offer/ capture loan details (if applicable)?","loan_details_capturing_no_reason","cmt14","Did the advisor inform about the loan documents and share the bank statement link (if applicable)?","loan_documents_information_no_reason","cmt15","Did the advisor inform you about the payment type?","payment_type_inform_no_reason","cmt16","Did the advisor speak clearly and concisely, maintain appropriate ROS?","voice_clarity_no_reason","cmt17","Did you observe any regional influence and was the advisor able to construct the sentences appropriately to ensure better customer understanding?","language_switching_no_reason","cmt18","Did the advisor sound energetic, confident and intonate well?","voice_modulation_no_reason","cmt19","Did the advisor actively listen to the customer throughout the call, avoid interruption, avoid repeating himself/herself during the call and appropriately","voice_repeating_no_reason","cmt20","Did the advisor avoid the usage of fillers and Jargon?","filter_jardon_no_reason","cmt21","Did the advisor follow the correct Hold /Transfer Procedure (HMT), Use Mute(if required) and avoid dead air during the call?","transfer_procedure_no_reason","cmt22","Did the advisor personalize over the call, use pleasantries words and statements/adjust the conversation as per the customer's requirements/circumstances in","personalize_call_no_reason","cmt23","Did the advisor use Service No techniques?","cmt24","Did the advisor empathise/apologise to the customer wherever required?","empathise_no_reason","cmt25","Was the advisor professional on the call? (they harassed/misbehaved/was rude/abused the customer).","rude_behaviour_no_reason","cmt26","Did the advisor summarize/further assistance/close the call appropriately with CSAT link?","csat_link_no_reason","cmt27","Did the advisor use the correct disposition/update all notes and details correctly on the call?","correct_dispostion_no_reason","cmt28","Did the advisor provide all accurate information and not mislead the customer provide incorrect information or make any false promises?","incorrect_information_no_reason","cmt29","Did not find any non-adherence to wrong practices.","unprofessional_no_reason","cmt30","Did the Advisor provide Customer Experience beyond expectation ?","customer_experience_reason","cmt31","Advisor related observations / challenges noticed on call","other_observations_challenges","suggestion_observations_challenges","Customer related observations / challenges noticed on call","other_customer_observations","suggestion_customer_observations","Technical related observations / challenges noticed on call","other_technical_observations","suggestion_technical_observations","Process related observations / challenges noticed on call","other_process_observations","suggestion_process_observations","Call Summary", "Feedback","Probability of Booking basis the call","Factors that could impact Booking","Reasons for impact on Booking (WHY 1)","Reasons for impact on Booking (WHY 2)", "Overall feel of the call basis Sales Pitch","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		      } else if($campaign=='post_booking'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date","Associate Name","Team Leader","Campaign","Call Duration","Actual Disposition","Agent Tenure","Customer Contact Number","Evaluator Name","Audit Type", "Auditor Type", "Voc","Standardization Rating","Standardization Scores","Standardization CQ Score","Product Rating","Product Scores","Product CQ Score","Communication Rating","Communication Scores","Communication CQ Score","Critical Rating","Critical Scores","Critical CQ Score","Fatal Rating","Fatal Scores","Fatal CQ Score","Overall Score", "Possible Score", "Earned Score","Opening done in 5 Sec in English/ Regional Language","Greeting/ Self introduction/ Company Introduction/ Customer identification/Purpose of the call","Hold/On-Hold Procedure followed on call","No Dead Air","Call Summarization was done on the call","Associate asked for further assistance & closed the call properly","Relevant probing done to understand the customer needs and concern","All customer queries addressed effectively","Effective rebuttals and objection handling used to encourage the customer to confirm the Test Drive/ Helped in booking another car- If cancelled","Comprehensive Warranty & CARS24 Quality Standards covered","7 day trial & Hassle-free RC transfer covered","Consumer Financing & Benefits covered- If Required","Car Details- Make/Model confirmed", "Payment type confirmed & Loan offer pitched If - Pay On Delivery Scenario","Customer Eligibility Checked & link triggered for bank statement (if applicable)","Delivery Type Date & Location confirmed /Captured (Hub-Pick Up/ Home Delivery)","Final payment amount confirmed","RC Transfer documents informed","Customer Email-ID confirmed","Correct Dispostion and remarks captured","Whatsapp Opt-in pitched on call & consent taken If Applicable","First Call Resolution Provided to the customer","Customer concern raised on Zendesk- If Required","Correct Details & Remarks Captured against ticket","No Duplicate ticket created on Zendesk- If already available","Associate Personalized on call","Language switched as per customer ease","No interruption on call","Tone was appropriate throughout the call","Voice clarity and appropriate rate of speech","MTI/ RTI Error on call","Accurate sentence construction without any grammatical errors","No Pronunciation error","Active Listening and comprehension","Acknowledgement of customer inputs","Available tools used to help the customer (CRM/ Zendesk/ Knowledgebank etc)","Incorrect or Misleading information","No Rude behaviour Profanity offensive or Abusive remark or language found","No Disconnection found during the call","Call Summary", "Feedback","AOI (Area of improvement)","Process & Product Observations (If any)","Compliance (Special case study)","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		      } else if($campaign=='post_delivery'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date","Associate Name","Team Leader","Campaign","Call Duration","Actual Disposition","Agent Tenure","Customer Contact Number","Evaluator Name","Audit Type", "Auditor Type", "Voc","Standardization Rating","Standardization Scores","Standardization CQ Score","Product Rating","Product Scores","Product CQ Score","Communication Rating","Communication Scores","Communication CQ Score","Critical Rating","Critical Scores","Critical CQ Score","Fatal Rating","Fatal Scores","Fatal CQ Score","Overall Score", "Possible Score", "Earned Score","Opening done in 5 Sec in English/ Regional Language","Greeting/ Self introduction/ Company Introduction/ Customer identification/Purpose of the call","Hold/On-Hold Procedure followed on call","No Dead Air","Call Summarization was done on the call","Associate asked for further assistance & closed the call properly","Associate able to understand/identify the customer concern clearly","Relevant probing done to understand the customer needs and concern","All customer queries addressed effectively/ Effective rebuttals and objection handling used","Correct TAT informed (wherever applicable)","Warranty/Invoice/ RC-Receipt etc shared with customer(Wherever Applicable)","First Call Resolution Provided to the customer","Customer concern raised on Zendesk- If Required","Correct Details & Remarks Captured against ticket","No Duplicate ticket created on Zendesk- If already available","Correct Dispostion and remarks captured","Customer Email-ID confirmed/Captured","Associate Personalized on call","Language switched as per customer ease","No interruption on call","Showed Empathy/Apologized (Wherever required)","Tone was appropriate throughout the call","Voice clarity and appropriate rate of speech","MTI/ RTI Error on call","Accurate sentence construction without any grammatical errors","No Pronunciation error","Active Listening and comprehension","Acknowledgement of customer inputs","Available tools used to help the customer (CRM/ Zendesk/ Knowledgebank etc)","Incorrect or Misleading information","No Rude behaviour Profanity offensive or Abusive remark or language found","No Disconnection found during the call","Call Summary", "Feedback","AOI (Area of improvement)","Process & Product Observations (If any)","Compliance (Special case study)","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		        }
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		    if($campaign=='pre_booking'){
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

				$row .= '"'.$user['standardization'].'",';
				$row .= '"'.$user['sales_pitch'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['communication'].'",';
				$row .= '"'.$user['critical_overallScore'].'",';
				$row .= '"'.$user['overall_score'].'",';
				

				$row .= '"'.$user['opening_done_within'].'",';
				$row .= '"'.$user['self_ntroduction'].'",';
				$row .= '"'.$user['customer_identification'].'",';
				$row .= '"'.$user['purpose_of_the_call'].'",';
				$row .= '"'.$user['script_followed'].'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'.$user['call_summarization'].'",';
				$row .= '"'.$user['further_assistance'].'",';
				$row .= '"'.$user['closing_script'].'",';
				$row .= '"'.$user['on_car_selection'].'",';
				$row .= '"'.$user['customer_refusal_reason'].'",';
				$row .= '"'.$user['customer_refusal_relevant'].'",';
				$row .= '"'.$user['probing_others'].'",';
				$row .= '"'.$user['all_customer_queries'].'",';
				$row .= '"'.$user['effective_rebuttals'].'",';
				$row .= '"'.$user['comprehensive_warranty'].'",';
				$row .= '"'.$user['day_trial_hassle'].'",';
				$row .= '"'.$user['consumer_finance'].'",';
				$row .= '"'.$user['car_details_make'].'",';
				$row .= '"'.$user['payment_type_confirmation'].'",';
				$row .= '"'.$user['loan_details_capturing'].'",';
				$row .= '"'.$user['loan_documents_information'].'",';
				$row .= '"'.$user['delivery_type'].'",';
				$row .= '"'.$user['shipping_charges'].'",';
				$row .= '"'.$user['booking_and_final'].'",';
				$row .= '"'.$user['rc_ransfer_documents'].'",';
				$row .= '"'.$user['customer_email_id'].'",';
				$row .= '"'.$user['whats_app_opt'].'",';
				$row .= '"'.$user['correct_dispostion'].'",';
				$row .= '"'.$user['correct_remarks'].'",';
				$row .= '"'.$user['voice_modulation'].'",';
				$row .= '"'.$user['language_switching'].'",';
				$row .= '"'.$user['interruption'].'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['voice_clarity'].'",';
				$row .= '"'.$user['pronuncation'].'",';
				$row .= '"'.$user['grammatical_errors'].'",';
				$row .= '"'.$user['unprofessional'].'",';
				$row .= '"'.$user['attentiveness'].'",';
				$row .= '"'.$user['forcefull_booking'].'",';
				$row .= '"'.$user['incorrect_information'].'",';
				$row .= '"'.$user['rude_behaviour'].'",';
				$row .= '"'.$user['call_disconnection'].'",';
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
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'.$user['cmt20'].'",';
				$row .= '"'.$user['cmt21'].'",';
				$row .= '"'.$user['cmt22'].'",';
				$row .= '"'.$user['cmt23'].'",';
				$row .= '"'.$user['cmt24'].'",';
				$row .= '"'.$user['cmt25'].'",';
				$row .= '"'.$user['cmt26'].'",';
				$row .= '"'.$user['cmt27'].'",';
				$row .= '"'.$user['cmt28'].'",';
				$row .= '"'.$user['cmt29'].'",';
				$row .= '"'.$user['cmt30'].'",';
				$row .= '"'.$user['cmt31'].'",';
				$row .= '"'.$user['cmt32'].'",';
				$row .= '"'.$user['cmt33'].'",';
				$row .= '"'.$user['cmt34'].'",';
				$row .= '"'.$user['cmt35'].'",';
				$row .= '"'.$user['cmt36'].'",';
				$row .= '"'.$user['cmt37'].'",';
				$row .= '"'.$user['cmt38'].'",';
				$row .= '"'.$user['cmt39'].'",';
				$row .= '"'.$user['cmt40'].'",';
				$row .= '"'.$user['cmt41'].'",';
				$row .= '"'.$user['cmt42'].'",';
				$row .= '"'.$user['cmt43'].'",';

                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';

				$row .= '"'.$user['probability_of'].'",';
				$row .= '"'.$user['factors_that_could'].'",';
				$row .= '"'.$user['reasons_for_impact'].'",';
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
		  if($campaign=='pre_booking_new'){
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

				$row .= '"'.$user['observations_challenges'].'",';
				$row .= '"'.$user['other_observations_challenges'].'",';
				$row .= '"'.$user['suggestion_observations_challenges'].'",';

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
				$row .= '"'.$user['reasons_for_impact'].'",';
				$row .= '"'.$user['reasons_for_why1'].'",';
				$row .= '"'.$user['reasons_for_why2'].'",';
				$row .= '"'.$user['overall_feel_of_the'].'",';
				
				//$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		  }
		  if($campaign=='post_booking'){
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
				$row .= '"'.$user['associate_name'].'",';
				$row .= '"'.$user['team_leader'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['actual_disposition'].'",';
				$row .= '"'.$user['agen_tenure'].'",';
				$row .= '"'.$user['customer_contact_number'].'",';
				$row .= '"'.$user['evaluator_name'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['standardization_rating'].'",';
                $row .= '"'.$user['standardization_score'].'",';
                $row .= '"'.$user['standardization_cqscore'].'",';
                $row .= '"'.$user['product_possibleScore'].'",';
                $row .= '"'.$user['product_earnedScore'].'",';
                $row .= '"'.$user['product_overallScore'].'",';
                $row .= '"'.$user['communication_possibleScore'].'",';
                $row .= '"'.$user['communication_earnedScore'].'",';
                $row .= '"'.$user['communication_overallScore'].'",';
                $row .= '"'.$user['critical_possibleScore'].'",';
                $row .= '"'.$user['critical_earnedScore'].'",';
                $row .= '"'.$user['critical_overallScore'].'",';
                $row .= '"'.$user['fatal_possibleScore'].'",';
                $row .= '"'.$user['fatal_earnedScore'].'",';
                $row .= '"'.$user['fatal_overallScore'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';

				$row .= '"'.$user['opening_done_in'].'",';
				$row .= '"'.$user['greeting_self_introduction'].'",';
				$row .= '"'.$user['hold_procedure'].'",';
				$row .= '"'.$user['no_dead_air'].'",';

				$row .= '"'.$user['call_summarization'].'",';
				$row .= '"'.$user['associate_asked'].'",';
				$row .= '"'.$user['relevant_probing_done'].'",';

				$row .= '"'.$user['all_customer_queries'].'",';
				$row .= '"'.$user['effective_rebuttals'].'",';
				$row .= '"'.$user['comprehensive_warranty'].'",';

				$row .= '"'.$user['day_trial_hassle_free'].'",';
				$row .= '"'.$user['consumer_financing'].'",';
				$row .= '"'.$user['car_details_make'].'",';

				$row .= '"'.$user['payment_type_confirmed'].'",';
				$row .= '"'.$user['customer_eligibility_checked'].'",';
                $row .= '"'.$user['delivery_type'].'",';

                $row .= '"'.$user['booking_and_final'].'",';
				$row .= '"'.$user['rc_transfer_documents'].'",';
				$row .= '"'.$user['customer_email'].'",';

				$row .= '"'.$user['correct_dispostion'].'",';
				$row .= '"'.$user['whatsapp_opt_pitched'].'",';
				$row .= '"'.$user['first_Call_resolution'].'",';

				$row .= '"'.$user['customer_concern_raised'].'",';
				$row .= '"'.$user['correct_details_remarks'].'",';
				$row .= '"'.$user['no_duplicate_ticket'].'",';

				$row .= '"'.$user['associate_personalized'].'",';
				$row .= '"'.$user['language_switched'].'",';
				$row .= '"'.$user['no_interruption'].'",';
				$row .= '"'.$user['tone_was_appropriate'].'",';

				$row .= '"'.$user['voice_clarity_appropriate'].'",';
				$row .= '"'.$user['mit_rti_error'].'",';
				$row .= '"'.$user['accurate_sentence'].'",';

				$row .= '"'.$user['no_pronunciation_error'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['acknowledgement'].'",';

				$row .= '"'.$user['available_tools_used'].'",';
				$row .= '"'.$user['incorrect_or_misleading'].'",';
				$row .= '"'.$user['no_rude_behaviour'].'",';
				$row .= '"'.$user['no_disconnection'].'",';
	
                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['aoi'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['ppo'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['css'])).'",';
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

		  if($campaign=='post_delivery'){
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
				$row .= '"'.$user['associate_name'].'",';
				$row .= '"'.$user['team_leader'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['actual_disposition'].'",';
				$row .= '"'.$user['agen_tenure'].'",';
				$row .= '"'.$user['customer_contact_number'].'",';
				$row .= '"'.$user['evaluator_name'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
                $row .= '"'.$user['standardization_rating'].'",';
                $row .= '"'.$user['standardization_score'].'",';
                $row .= '"'.$user['standardization_cqscore'].'",';
                $row .= '"'.$user['product_possibleScore'].'",';
                $row .= '"'.$user['product_earnedScore'].'",';
                $row .= '"'.$user['product_overallScore'].'",';
                $row .= '"'.$user['communication_possibleScore'].'",';
                $row .= '"'.$user['communication_earnedScore'].'",';
                $row .= '"'.$user['communication_overallScore'].'",';
                $row .= '"'.$user['critical_possibleScore'].'",';
                $row .= '"'.$user['critical_earnedScore'].'",';
                $row .= '"'.$user['critical_overallScore'].'",';
                $row .= '"'.$user['fatal_possibleScore'].'",';
                $row .= '"'.$user['fatal_earnedScore'].'",';
                $row .= '"'.$user['fatal_overallScore'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['opening_done_in'].'",';
				$row .= '"'.$user['greeting_self_introduction'].'",';
				$row .= '"'.$user['hold_procedure'].'",';
				$row .= '"'.$user['no_dead_air'].'",';
				$row .= '"'.$user['call_summarization'].'",';
				$row .= '"'.$user['associate_asked'].'",';
				$row .= '"'.$user['associate_able_to'].'",';
				$row .= '"'.$user['relevant_probing_done'].'",';
				$row .= '"'.$user['all_customer_queries'].'",';
				$row .= '"'.$user['correct_tat_informed'].'",';
				$row .= '"'.$user['warranty_invoice'].'",';
				$row .= '"'.$user['first_Call_resolution'].'",';
				$row .= '"'.$user['customer_concern_raised'].'",';
				$row .= '"'.$user['correct_details_remark'].'",';
				$row .= '"'.$user['no_duplicate_ticket'].'",';
                $row .= '"'.$user['correct_dispostion'].'",';
                $row .= '"'.$user['customer_email_id'].'",';
				$row .= '"'.$user['associate_personalized'].'",';
				$row .= '"'.$user['language_switched'].'",';
				$row .= '"'.$user['no_interruption'].'",';
				$row .= '"'.$user['showed_empathy'].'",';
				$row .= '"'.$user['tone_was_appropriate'].'",';
				$row .= '"'.$user['voice_clarity_appropriate'].'",';
				$row .= '"'.$user['mit_rti_error'].'",';
				$row .= '"'.$user['accurate_sentence'].'",';
				$row .= '"'.$user['no_pronunciation_error'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['acknowledgement'].'",';
				$row .= '"'.$user['available_tools_used'].'",';
				$row .= '"'.$user['incorrect_or_misleading'].'",';
				$row .= '"'.$user['no_rude_behaviour'].'",';
				$row .= '"'.$user['no_disconnection'].'",';
                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['aoi'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['ppo'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['css'])).'",';
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