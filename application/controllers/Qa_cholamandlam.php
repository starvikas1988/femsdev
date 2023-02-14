<?php

 class Qa_cholamandlam extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
/////////////////////////// Create Path for Upload Audio Files - Start ///////////////////////////////
	public function createPath($path){

		if (!empty($path)) {

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


	private function cholamandlam_upload_files($files,$path)
    {
    	$result=$this->createPath($path);
    	if($result){
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		//$config['detect_mime'] = FALSE;
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
/////////////////////////// Create Path for Upload Audio Files - End ///////////////////////////////


	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cholamandlam/qa_cholamandlam_feedback.php";
			$data["content_js"] = "qa_cholamandlam_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,266) and status=1 order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["cholamandlam"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_ibl_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["cholamandlam_ibl"] = $this->Common_model->get_query_result_array($qSql);

			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_cholamandlam($cholamandlam_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cholamandlam/cholamandlam/add_edit_cholamandlam.php";
			$data["content_js"] = "qa_cholamandlam_js.php";
			$data['cholamandlam_id']=$cholamandlam_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,266) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cholamandlam_feedback where id='$cholamandlam_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["cholamandlam"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){

				if($cholamandlam_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->cholamandlam_upload_files($_FILES['attach_file'], $path='./qa_files/qa_cholamandlam/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cholamandlam_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cholamandlam_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					if(!isset($field_array1['auditor_type'])){
						$field_array1['auditor_type'] = "";
					}
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $cholamandlam_id);
					$this->db->update('qa_cholamandlam_feedback',$field_array1);
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
					$this->db->where('id', $cholamandlam_id);
					$this->db->update('qa_cholamandlam_feedback',$edit_array);

				}
				redirect('Qa_cholamandlam');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_cholamandlam_ibl($cholamandlam_ibl_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cholamandlam/cholamandlam_ibl/add_edit_cholamandlam_ibl.php";
			$data["content_js"] = "qa_cholamandlam_js.php";
			$data['cholamandlam_ibl_id']=$cholamandlam_ibl_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,266) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_cholamandlam_ibl_feedback where id='$cholamandlam_ibl_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["cholamandlam_ibl"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){

				if($cholamandlam_ibl_id==0){

					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->cholamandlam_upload_files($_FILES['attach_file'], $path='./qa_files/qa_cholamandlam_ibl/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cholamandlam_ibl_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_cholamandlam_ibl_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					if(!isset($field_array1['auditor_type'])){
						$field_array1['auditor_type'] = "";
					}
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $cholamandlam_ibl_id);
					$this->db->update('qa_cholamandlam_ibl_feedback',$field_array1);
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
					$this->db->where('id', $cholamandlam_ibl_id);
					$this->db->update('qa_cholamandlam_ibl_feedback',$edit_array);

				}
				redirect('Qa_cholamandlam');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/*------------------- Agent Part ---------------------*/
	public function agent_cholamandlam_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cholamandlam/agent_cholamandlam_feedback.php";
			$data["content_js"] = "qa_cholamandlam_js.php";
			$data["agentUrl"] = "qa_cholamandlam/agent_cholamandlam_feedback";


			$qSql="Select count(id) as value from qa_cholamandlam_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_cholamandlam_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_cholamandlam_ibl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
			$data["tot_feedback_ibl"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_cholamandlam_ibl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
			$data["yet_rvw_ibl"] =  $this->Common_model->get_single_value($qSql);

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_ibl_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list_ibl"] = $this->Common_model->get_query_result_array($qSql);

			}else{

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_ibl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list_ibl"] = $this->Common_model->get_query_result_array($qSql);

			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}


	public function agent_cholamandlam_rvw($id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['cholamandlam_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cholamandlam/cholamandlam/agent_cholamandlam_rvw.php";
			$data["content_js"] = "qa_cholamandlam_js.php";
			$data["agentUrl"] = "qa_cholamandlam/agent_cholamandlam_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["cholamandlam"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_cholamandlam_feedback',$field_array1);

				redirect('qa_cholamandlam/agent_cholamandlam_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_cholamandlam_ibl_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['cholamandlam_ibl_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cholamandlam/cholamandlam_ibl/agent_cholamandlam_ibl_rvw.php";
			$data["content_js"] = "qa_cholamandlam_js.php";
			$data["agentUrl"] = "qa_cholamandlam/agent_cholamandlam_feedback";

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cholamandlam_ibl_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["cholamandlam_ibl"] = $this->Common_model->get_query_row_array($qSql);

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
				$this->db->update('qa_cholamandlam_ibl_feedback',$field_array1);

				redirect('qa_cholamandlam/agent_cholamandlam_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}



/*-------------- Report Part ---------------*/
	public function qa_cholamandlam_report()
	{
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
			$data["content_template"] = "qa_cholamandlam/qa_cholamandlam_report.php";
			$data["content_js"] = "qa_cholamandlam_js.php";

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

			$data["qa_cholamandlam_list"] = array();

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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_cholamandlam_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_stifel_list"] = $fullAray;
				$this->create_qa_cholamandlam_CSV($fullAray);
				$dn_link = base_url()."qa_cholamandlam/download_qa_cholamandlam_CSV/";
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

	public function download_qa_cholamandlam_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Cholamandlam Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_cholamandlam_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Call Duration", "Audit Type","Auditor Type", "Track ID", "Mobile No", "Language", "Week", "VOC", "Audit Start Date Time", "Audit End Date Time", "Earned Score", "Possible Score", "Interval1", "Overall Score",
		  
		 	"Appropriate Greeting/Time taken to Greet",
		 	"Self & Company Intro",
		 	"RPC - Right Party Contact",
		 	"Language Adherence",
		 	"Purpose of call",
		 	"Giving correct relevant information/ commitment",
		 	"Address & Landmark Confirmation",
		 	"Alternate Ph # & Cont person",
		 	"Date & Time",
		 	"Amount confirmation + Overdue Charges amount(fatal)",
		 	"Mininum Charges amount 1500 Rs/- to be pitched on call",
		 	"Chola App & Online payment Promotion",
		 	"Previous interaction to be pitched on follow up calls",
		 	"Proactive Information",
		 	"Mode of payment confirmation",
		 	"Payment details confirmation",
		 	"Effective Probing",
		 	"Exhibits good knowledge on product and process",
		 	"Exhibits call control and ownership",
			 "Creates urgency & Educates customer on charges",
			 "Pickup/Showroom confirmation",
			 "Exhibits negotiation skills as per customer profiling",
			 "Dead Air/Mute/Proper hold procedure",
			 "Thanking/Empathy/Apology",
			 "Active Listening/Interruption",
			 "Enthusiasm /Self confidence",
			 "Maintains Professionalism",
			 "Phone Etiquettes",
			 "Speech Clarity/Rate of Speech",
			 "Summarization",
			 "Receipt Details & Not to share Bank details Awareness Script was informed during closing",
			 "Proper Call closure",
			 "Documentation/Tagging",
			 "Disposition",
			 "Zero Tolerance Policy",
			 "Correct Disposition",
			 "Disposition selected by agent",
			 "Wrong Disposition -Failure Remarks",
			 "Maintain Professionalism - Failure Reason",
			 "Standard call opening Adherence",
			 "Pick up call validation",
			 "EMI Amount Confirmation",
			 "Address Confirmation",
			 "Invalid Pickup Remarks (If any)",
			 "Call Opening Comment",
			 "process_knowledge_comment",
			 "negotiation_skill_comment",
			 "forth_comment",
			 "call_closure_comment",
			 "system_knowledge_comment",
			 "ztp_comment",
		 	 "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

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

			$row = '"'.$auditorName.'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['track_id'].'",';
			$row .= '"'.$user['mobile_no'].'",';
			$row .= '"'.$user['language'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['appropriate_greeting'].'",';
			$row .= '"'.$user['self_company'].'",';
			$row .= '"'.$user['rpc'].'",';
			$row .= '"'.$user['language_adherence'].'",';
			$row .= '"'.$user['purpose'].'",';
			$row .= '"'.$user['relevant_information'].'",';
			$row .= '"'.$user['address_landmark'].'",';
			$row .= '"'.$user['alt_phone'].'",';
			$row .= '"'.$user['dates_times'].'",';
			$row .= '"'.$user['overdue_charges'].'",';
			$row .= '"'.$user['minimum_charges'].'",';
			$row .= '"'.$user['payment_promotion'].'",';
			$row .= '"'.$user['follow_up_call'].'",';
			$row .= '"'.$user['proactive_information'].'",';
			$row .= '"'.$user['payment_mode'].'",';
			$row .= '"'.$user['payment_details'].'",';
			$row .= '"'.$user['effective_probing'].'",';
			$row .= '"'.$user['product_process'].'",';
			$row .= '"'.$user['control_ownership'].'",';
			$row .= '"'.$user['educates_customer'].'",';
			$row .= '"'.$user['pickup_showroom'].'",';
			$row .= '"'.$user['negotiation_skills'].'",';
			$row .= '"'.$user['hold_procedure'].'",';
			$row .= '"'.$user['thanking'].'",';
			$row .= '"'.$user['listening_interruption'].'",';
			$row .= '"'.$user['enthusiasm'].'",';
			$row .= '"'.$user['professionalism'].'",';
			$row .= '"'.$user['phone_etiquettes'].'",';
			$row .= '"'.$user['speech_clarity'].'",';
			$row .= '"'.$user['summarization'].'",';
			$row .= '"'.$user['receipt_details'].'",';
			$row .= '"'.$user['call_closure'].'",';
			$row .= '"'.$user['documentation'].'",';
			$row .= '"'.$user['disposition'].'",';
			$row .= '"'.$user['tolerance_policy'].'",';
			$row .= '"'.$user['correct_disposition'].'",';
			$row .= '"'.$user['disposition_agent'].'",';
			$row .= '"'.$user['failure_remarks'].'",';
			$row .= '"'.$user['failure_reason'].'",';
			$row .= '"'.$user['standard_call'].'",';
			$row .= '"'.$user['call_validation'].'",';
			$row .= '"'.$user['emi_amount'].'",';
			$row .= '"'.$user['address'].'",';
			$row .= '"'.$user['pickup_remarks'].'",';
			$row .= '"'.$user['call_opening_comment'].'",';
			$row .= '"'.$user['process_knowledge_comment'].'",';
			$row .= '"'.$user['negotiation_skill_comment'].'",';
			$row .= '"'.$user['forth_comment'].'",';
			$row .= '"'.$user['call_closure_comment'].'",';
			$row .= '"'.$user['system_knowledge_comment'].'",';
			$row .= '"'.$user['ztp_comment'].'",';
			
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


	public function qa_cholamandlam_ibl_report()
	{
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
			$data["content_template"] = "qa_cholamandlam/qa_cholamandlam_ibl_report.php";
			$data["content_js"] = "qa_cholamandlam_js.php";

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

			$data["qa_cholamandlam_ibl_list"] = array();

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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_cholamandlam_ibl_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_stifel_list"] = $fullAray;
				$this->create_qa_cholamandlam_CSV($fullAray);
				$dn_link = base_url()."qa_cholamandlam/download_qa_cholamandlam_ibl_CSV/";
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




	public function download_qa_cholamandlam_ibl_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Cholamandlam IBL Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}



	public function create_qa_cholamandlam_ibl_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Call Duration", "Audit Type","Auditor Type", "Track ID", "Mobile No", "Language", "Week", "VOC", "Audit Start Date Time", "Audit End Date Time", "Earned Score", "Possible Score", "Interval1", "Overall Score",
		  
		 	"Standard Call opening (Opened the call without delay & with proper script & greeting)",
		 	"Necessary Probing Done",
		 	"Rate of speech/Empathy/Hold procedure",
		 	"Professional on call",
		 	"Active Listening / Interruption",
		 	"Display enthusiasm",
		 	"Closing",
		 	"Vehicle details and RED confirmation",
		 	"Product information",
		 	"Premium confirmation",
		 	"PTP date confirmation",
		 	"Urgency creation",
		 	"Objection handling , based on customer query",
		 	"Effort on call",
		 	"Alternate number confirmation",
		 	"Disposition",
		 	// "Effective Probing",
		 	// "Exhibits good knowledge on product and process",
		 	// "Exhibits call control and ownership",
			//  "Creates urgency & Educates customer on charges",
			//  "Pickup/Showroom confirmation",
			//  "Exhibits negotiation skills as per customer profiling",
			//  "Dead Air/Mute/Proper hold procedure",
			//  "Thanking/Empathy/Apology",
			//  "Active Listening/Interruption",
			//  "Enthusiasm /Self confidence",
			//  "Maintains Professionalism",
			//  "Phone Etiquettes",
			//  "Speech Clarity/Rate of Speech",
			//  "Summarization",
			//  "Receipt Details & Not to share Bank details Awareness Script was informed during closing",
			//  "Proper Call closure",
			//  "Documentation/Tagging",
			//  "Disposition",
			//  "Zero Tolerance Policy",
			 "Correct Disposition",
			 "Disposition selected by agent",
			 "Wrong Disposition -Failure Remarks",
			 "Maintain Professionalism - Failure Reason",
			 "Standard call opening Adherence",
			 "Pick up call validation",
			 "EMI Amount Confirmation",
			 "Address Confirmation",
			 "Invalid Pickup Remarks (If any)",
			 "Call Opening Comment",
			 "process_knowledge_comment",
			 "negotiation_skill_comment",
			 "forth_comment",
			 "call_closure_comment",
			 "system_knowledge_comment",
			 "ztp_comment",
		 	 "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

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

			$row = '"'.$auditorName.'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['track_id'].'",';
			$row .= '"'.$user['mobile_no'].'",';
			$row .= '"'.$user['language'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['call_opening'].'",';
			$row .= '"'.$user['necessary_probing'].'",';
			$row .= '"'.$user['hold_procedure'].'",';
			$row .= '"'.$user['professional_call'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['display_enthusiasm'].'",';
			$row .= '"'.$user['closing'].'",';
			$row .= '"'.$user['vehicle_details'].'",';
			$row .= '"'.$user['product_information'].'",';
			$row .= '"'.$user['premium_confirmation'].'",';
			$row .= '"'.$user['date_confirmation'].'",';
			$row .= '"'.$user['urgency_creation'].'",';
			$row .= '"'.$user['objection_handling'].'",';
			$row .= '"'.$user['effort_call'].'",';
			$row .= '"'.$user['alternate_number'].'",';
			$row .= '"'.$user['disposition'].'",';
			$row .= '"'.$user['correct_disposition'].'",';
			$row .= '"'.$user['disposition_agent'].'",';
			$row .= '"'.$user['failure_remarks'].'",';
			$row .= '"'.$user['failure_reason'].'",';
			$row .= '"'.$user['standard_call'].'",';
			$row .= '"'.$user['call_validation'].'",';
			$row .= '"'.$user['emi_amount'].'",';
			$row .= '"'.$user['address'].'",';
			$row .= '"'.$user['pickup_remarks'].'",';
			$row .= '"'.$user['soft_skill_comment'].'",';
			$row .= '"'.$user['sales_skill_comment'].'",';
			$row .= '"'.$user['documentation_comment'].'",';
						
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
