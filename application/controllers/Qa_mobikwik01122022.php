<?php 

 class Qa_mobikwik extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function mobikwik_upload_files($files,$path)
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
	
/////////////////////////////////////////////////////

    public function getDesignation(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			// $qSql = "Select id, assigned_to, fusion_id,get_process_ids(id)as process_id, get_process_names(id) as process_name, office_id, DATEDIFF(CURDATE(), doj) as tenure FROM signin where id = '$aid'";
				//echo $qSql;
			$qSql ="SELECT s.id, concat(s.fname, ' ', s.lname) as name, s.assigned_to, s.fusion_id,dept.description,r.folder as designation  FROM `signin` s LEFT JOIN department dept ON s.dept_id=dept.id LEFT JOIN role r ON s.role_id=r.id where role_id in (select id from role where folder in('agent','tl','trainer')) and dept_id=6 and is_assign_process(s.id,719) and status=1 and s.id = $aid order by name";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_mobikwik/qa_mobikwik_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,719)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			// print_r($data["agentName"]);
			// exit;
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwik_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["mobikwik_data"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwikemail_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["mobikwik_emaildata"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	

///////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////// Mobikwik ///////////////////////////////////

	public function add_edit_mobikwik($mobikwik_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_mobikwik/add_edit_mobikwik.php";
			$data["content_js"] = "qa_idfc_js.php";
			$data['mobikwik_id']=$mobikwik_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT s.id, concat(s.fname, ' ', s.lname) as name, s.assigned_to, s.fusion_id,dept.description,r.folder as designation FROM `signin` s
			LEFT JOIN department dept ON s.dept_id=dept.id
			LEFT JOIN role r ON s.role_id=r.id
			where role_id in (select id from role where folder in('agent','tl','trainer')) and dept_id=6 and is_assign_process(s.id,719) and status=1 and s.id!=$current_user order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_mobikwik_feedback where id='$mobikwik_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["mobikwik_new"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('btnSave') == "SAVE"){
				
				if($mobikwik_id==0){
					
					$field_array=$_POST['data'];
					$field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mdydt2mysql($this->input->post('call_date'));
                    $field_array['entry_date'] = getEstToLocalCurrUser($curDateTime);
                    $field_array['audit_start_time'] = getEstToLocalCurrUser($this->input->post( 'audit_start_time' ));

					$a = $this->mobikwik_upload_files($_FILES['attach_file'], $path='./qa_files/qa_mobikwik/');
					$field_array["attach_file"] = implode(',',$a);
					
					$rowid= data_inserter('qa_mobikwik_feedback',$field_array);
				/////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_mobikwik_feedback',$field_array1);
				
				}else{
					
					$field_array2=$_POST['data'];
					$field_array2 = $this->input->post( 'data' );
                    $field_array2['call_date'] = mdydt2mysql($this->input->post('call_date'));
					
					$this->db->where('id', $mobikwik_id);
					$this->db->update('qa_mobikwik_feedback',$field_array2);
				/////////
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
					$this->db->where('id', $mobikwik_id);
					$this->db->update('qa_mobikwik_feedback',$field_array1);
				}
				redirect('qa_mobikwik');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_email_mobikwik($mobikwik_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_mobikwik/add_edit_email_mobikwik.php";
			$data["content_js"] = "qa_idfc_js.php";
			$data['mobikwik_id']=$mobikwik_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			// $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder in('agent','tl','trainer')) and dept_id=6 and is_assign_process(id,719) and status=1  order by name";

			$qSql="SELECT s.id, concat(s.fname, ' ', s.lname) as name, s.assigned_to, s.fusion_id,dept.description,r.folder as designation FROM `signin` s
			LEFT JOIN department dept ON s.dept_id=dept.id
			LEFT JOIN role r ON s.role_id=r.id
			where role_id in (select id from role where folder in('agent','tl','trainer')) and dept_id=6 and is_assign_process(s.id,719) and status=1 and s.id!=$current_user order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_mobikwikemail_feedback where id='$mobikwik_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["mobikwik_new"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('btnSave') == "SAVE"){
				
				if($mobikwik_id==0){
					
					$field_array=$_POST['data'];
					$field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mdydt2mysql($this->input->post('call_date'));
                    $field_array['entry_date'] = getEstToLocalCurrUser($curDateTime);
                    $field_array['audit_start_time'] = getEstToLocalCurrUser($this->input->post( 'audit_start_time' ));

					$a = $this->mobikwik_upload_files($_FILES['attach_file'], $path='./qa_files/qa_mobikwik/');
					$field_array["attach_file"] = implode(',',$a);
					
					$rowid= data_inserter('qa_mobikwikemail_feedback',$field_array);
				/////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_mobikwikemail_feedback',$field_array1);
				
				}else{
					
					$field_array2=$_POST['data'];
					$field_array2 = $this->input->post( 'data' );
                    $field_array2['call_date'] = mdydt2mysql($this->input->post('call_date'));
					
					$this->db->where('id', $mobikwik_id);
					$this->db->update('qa_mobikwikemail_feedback',$field_array2);
				/////////
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
					$this->db->where('id', $mobikwik_id);
					$this->db->update('qa_mobikwikemail_feedback',$field_array1);
				}
				redirect('qa_mobikwik');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_mobikwik_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_mobikwik/agent_mobikwik_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_mobikwik/agent_mobikwik_feedback";
			
			
			
			$qSql="Select count(id) as value from qa_mobikwik_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Operation Audit', 'Trainer Audit')";
			$data["tot_mobikwik_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_mobikwik_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_mobikwik_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$qSql="Select count(id) as value from qa_mobikwikemail_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Operation Audit', 'Trainer Audit')";
			$data["tot_emailmobikwik_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_mobikwikemail_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_emailmobikwik_rvw"] =  $this->Common_model->get_single_value($qSql);
				

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwik_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_mobikwik_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwikemail_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_emailmobikwik_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
			
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwik_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_mobikwik_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwikemail_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_emailmobikwik_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_mobikwik_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_mobikwik/agent_mobikwik_rvw.php";
			$data["content_js"] = "qa_idfc_js.php";
			//$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_mobikwik/agent_mobikwik_feedback";
			$data['mobikwik_id']=$id;

			$qSql="SELECT s.id, concat(s.fname, ' ', s.lname) as name, s.assigned_to, s.fusion_id,dept.description,r.folder as designation FROM `signin` s
			LEFT JOIN department dept ON s.dept_id=dept.id
			LEFT JOIN role r ON s.role_id=r.id
			where role_id in (select id from role where folder in('agent','tl','trainer')) and dept_id=6 and is_assign_process(s.id,719) and status=1 and s.id!=$current_user order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwik_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["mobikwik_new"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_mobikwik_feedback',$field_array1);
					
				redirect('Qa_mobikwik/agent_mobikwik_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_email_mobikwik_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_mobikwik/agent_email_mobikwik_rvw.php";
			$data["content_js"] = "qa_idfc_js.php";
			//$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_mobikwik/agent_mobikwik_feedback";
			$data['mobikwik_id']=$id;
			
			$qSql="SELECT s.id, concat(s.fname, ' ', s.lname) as name, s.assigned_to, s.fusion_id,dept.description,r.folder as designation FROM `signin` s
			LEFT JOIN department dept ON s.dept_id=dept.id
			LEFT JOIN role r ON s.role_id=r.id
			where role_id in (select id from role where folder in('agent','tl','trainer')) and dept_id=6 and is_assign_process(s.id,719) and status=1 and s.id!=$current_user order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mobikwikemail_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["mobikwik_new"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_mobikwikemail_feedback',$field_array1);
					
				redirect('Qa_mobikwik/agent_mobikwik_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
 }