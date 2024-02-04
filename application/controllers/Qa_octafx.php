<?php 

 class Qa_octafx extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}
	
	
	public function getTenuarity(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select S.id,DATEDIFF(CURDATE(), S.doj) as tenure FROM signin S where S.id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

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

	private function audio_upload_files($files,$path)
    {
    	$result=$this->createPath($path);
    	if($result){
        $config['upload_path'] = $path;
		//$config['allowed_types'] = '*';
		//$config['detect_mime'] = FALSE;
		//$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
		$config['allowed_types'] = 'mp3|m4a|mp4|wav';
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
			$data["content_template"] = "qa_octafx/qa_octafx_feedback.php";
			$data["content_js"] = "qa_octafx_js.php";			

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,368) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);	
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
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
			if($from_date !="" && $to_date!=="")  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') ";
			if($agent_id!="") $cond .=" and agent_id=$agent_id";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_octafx_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["octafx"] = $this->Common_model->get_query_result_array($qSql);

			$qSql_outbound = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_octafx_outbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["octafx_outbound"] = $this->Common_model->get_query_result_array($qSql_outbound);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_octafx($oc_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_octafx/add_edit_octafx.php";
			$data["content_js"] = "qa_octafx_js.php";
			$data['oc_id']=$oc_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,368) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_octafx_feedback where id='$oc_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["octafx"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($oc_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/octafx/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_octafx_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_octafx_feedback',$add_array);
				//////////////
					$client_report_url = $this->Common_model->get_single_value('Select qa_report_url as value from client where id=368');
					if($client_report_url==""){
						$this->db->query("Update client set qa_report_url='qa_octafx/qa_report_url' where id=368");
					}
					
					$process_report_url = $this->Common_model->get_single_value('Select qa_url as value from process where id=790');
					if($process_report_url==""){
						$this->db->query("Update process set qa_url='qa_octafx', qa_agent_url='qa_octafx/agent_octafx_feedback' where id=790");
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $oc_id);
					$this->db->update('qa_octafx_feedback',$field_array1);
					/////////////
					if($current_user!=1){
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
					}
					$this->db->where('id', $oc_id);
					$this->db->update('qa_octafx_feedback',$edit_array);
					
				}
				redirect('qa_octafx');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_octafx_outbound($oc_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_octafx/add_edit_octafx_outbound.php";
			$data["content_js"] = "qa_octafx_js.php";
			$data['oc_id']=$oc_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,368) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_octafx_outbound_feedback where id='$oc_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["octafx_outbound"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($oc_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/octafx/');
						$field_array["attach_file"] = implode(',',$a);
					}
					
					$rowid= data_inserter('qa_octafx_outbound_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_octafx_outbound_feedback',$add_array);
				//////////////
					$client_report_url = $this->Common_model->get_single_value('Select qa_report_url as value from client where id=368');
					if($client_report_url==""){
						$this->db->query("Update client set qa_report_url='qa_octafx/qa_report_url' where id=368");
					}
					
					$process_report_url = $this->Common_model->get_single_value('Select qa_url as value from process where id=790');
					if($process_report_url==""){
						$this->db->query("Update process set qa_url='qa_octafx', qa_agent_url='qa_octafx/agent_octafx_feedback' where id=790");
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));

					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/octafx/")){
							mkdir("./qa_files/octafx/");
						}
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/octafx/');
						$field_array1["attach_file"] = implode(',',$a);
					}

					$this->db->where('id', $oc_id);
					$this->db->update('qa_octafx_outbound_feedback',$field_array1);
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
					$this->db->where('id', $oc_id);
					$this->db->update('qa_octafx_outbound_feedback',$edit_array);
					
				}
				redirect('qa_octafx');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	public function agent_octafx_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_octafx/agent_octafx_feedback.php";
			$data["content_js"] = "qa_octafx_js.php";	
			$data["agentUrl"] = "qa_octafx/agent_octafx_feedback";
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			$qSql="Select count(id) as value from qa_octafx_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_octafx_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_octafx_outbound_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["tot_feedback_outbound"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_octafx_outbound_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["yet_rvw_outbound"] =  $this->Common_model->get_single_value($qSql);

			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_octafx_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_octafx_outbound_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_rvw_list_outbound"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_octafx_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_octafx_outbound_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list_outbound"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function agent_octafx_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_octafx/agent_octafx_feedback_rvw.php";
			$data["content_js"] = "qa_octafx_js.php";
			$data["agentUrl"] = "qa_octafx/agent_octafx_feedback";
			$data["octafx_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_octafx_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["octafx"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('octafx_id'))
			{
				$octafx_id=$this->input->post('octafx_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $octafx_id);
				$this->db->update('qa_octafx_feedback',$field_array);
				redirect('qa_octafx/agent_octafx_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_octafx_outbound_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_octafx/agent_octafx_outbound_feedback_rvw.php";
			$data["content_js"] = "qa_octafx_js.php";
			$data["agentUrl"] = "qa_octafx/agent_octafx_feedback";
			$data["octafx_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_octafx_outbound_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["octafx_outbound"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('octafx_id'))
			{
				$octafx_id=$this->input->post('octafx_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $octafx_id);
				$this->db->update('qa_octafx_outbound_feedback',$field_array);
				redirect('qa_octafx/agent_octafx_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


	public function qa_octafx_report(){
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
			$data["content_template"] = "qa_octafx/qa_octafx_report.php";
			$data["content_js"] = "qa_octafx_js.php";

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";

			$date_from = ($this->input->get('date_from'));
			$date_to = ($this->input->get('date_to'));
			$campaign = ($this->input->get('campaign'));

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

			$data["qa_octa_list"] = array();

			if($this->input->get('show')=='Show')
			{
				//$date_from = mmddyy2mysql($this->input->get('date_from'));
				//$date_to = mmddyy2mysql($this->input->get('date_to'));
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

				if($campaign == 'octafx'){

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_octafx_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_octa_list"] = $fullAray;
					$this->create_qa_octafx_feedback_CSV($fullAray);
					$dn_link = base_url()."qa_octafx/download_qa_octafx_feedback_CSV";

				}else if($campaign = 'octafx_outbound'){
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from  qa_octafx_outbound_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_octa_list"] = $fullAray;
					$this->create_qa_octafx_outbound_feedback_CSV($fullAray);
					$dn_link = base_url()."qa_octafx/download_qa_octafx_outbound_feedback_CSV";
				}

				
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


	public function download_qa_octafx_feedback_CSV()
	{
		//die("okk");
		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		
		$newfile="QA OctaFX Audit List-'".$currDate."'.csv";
	
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_octafx_feedback_CSV($rr)
	{
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Ticket ID", "Call Duration", "Contact Dtails", "Team", "Language", "ACPT", "Week", "Call Type 1", "Call Type 2", "Audit Type", "Auditor Type", "VOC", "Audit Start Date/Time", "Audit End Date/Time", "Interval(in sec)", "Earned Score", "Possible Score", "Overall Score",
		"Preparation","Preparation Reason", "Introduction","Introduction Reason", "Profiling","Profiling Reason", "Delivery","Delivery Reason", "Objections","Objections Reason", "Closing","Closing Reason", "Conclusion","Conclusion Reason", "Follow up","Follow up Reason", "Clear explanation of products and services to client","Clear explanation of products and services to client Reason", "Rapport","Rapport Reason", "Clarity","Clarity Reason", "Enthusiasm","Enthusiasm Reason", "Goal driven","Goal driven Reason", "Dos and Don'ts (Call ethicate)","Dos and Donots(Call ethicate) Reason", "Giving trading advice","Giving trading advice Reason", "Profanity rudeness or sarcasm","Profanity rudeness or sarcasm Reason", "Asking details of payment option for example card details","Asking details of payment option for example card details Reason", "Using customers personal info for non official purpose","Using customers personal info for non official purpose Reason", "False commitment/Mislead the client for deposit","False commitment/Mislead the client for deposit Reason", "Login to clients trading platform/ personal area on behalf of the client","Login to client's trading platform/ personal area on behalf of the client Reason", "Client deposited during call","Client deposited during call Reason", "Client deposited during call above KPI","Client deposited during call above KPI Reason", "Client uploaded documents during call","Client uploaded documents during call Reason",
		"Audit Summary", "Audit Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

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
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['ticket_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['contact'].'",';
			$row .= '"'.$user['team'].'",';
			$row .= '"'.$user['language'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['week'].'",';
			$row .= '"'.$user['call_type1'].'",';
			$row .= '"'.$user['call_type2'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$$interval1.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['preparation'].'",';
			$row .= '"'.$user['preparation_reason'].'",';
			$row .= '"'.$user['introduction'].'",';
			$row .= '"'.$user['introduction_reason'].'",';
			$row .= '"'.$user['profiling'].'",';
			$row .= '"'.$user['profiling_reason'].'",';
			$row .= '"'.$user['delivary'].'",';
			$row .= '"'.$user['delivary_reason'].'",';
			$row .= '"'.$user['objection'].'",';
			$row .= '"'.$user['objection_reason'].'",';
			$row .= '"'.$user['closing'].'",';
			$row .= '"'.$user['closing_reason'].'",';
			$row .= '"'.$user['conclusion'].'",';
			$row .= '"'.$user['conclusion_reason'].'",';
			$row .= '"'.$user['follow_up'].'",';
			$row .= '"'.$user['follow_up_reason'].'",';
			$row .= '"'.$user['product_explanation'].'",';
			$row .= '"'.$user['product_explanation_reason'].'",';
			$row .= '"'.$user['rapport'].'",';
			$row .= '"'.$user['rapport_reason'].'",';
			$row .= '"'.$user['clarity'].'",';
			$row .= '"'.$user['clarity_reason'].'",';
			$row .= '"'.$user['enthusiasm'].'",';
			$row .= '"'.$user['enthusiasm_reason'].'",';
			$row .= '"'.$user['goal_driven'].'",';
			$row .= '"'.$user['goal_driven_reason'].'",';
			$row .= '"'.$user['do_dont_call_ethicate'].'",';
			$row .= '"'.$user['do_dont_call_ethicate_reason'].'",';
			$row .= '"'.$user['trading_advice'].'",';
			$row .= '"'.$user['trading_advice_reason'].'",';
			$row .= '"'.$user['profanity_rudeness'].'",';
			$row .= '"'.$user['profanity_rudeness_reason'].'",';
			$row .= '"'.$user['asking_details_payment_details'].'",';
			$row .= '"'.$user['asking_details_payment_details_reason'].'",';
			$row .= '"'.$user['use_customer_info'].'",';
			$row .= '"'.$user['use_customer_info_reason'].'",';
			$row .= '"'.$user['false_commitment'].'",';
			$row .= '"'.$user['false_commitment_reason'].'",';
			$row .= '"'.$user['login_client_trading'].'",';
			$row .= '"'.$user['login_client_trading_reason'].'",';
			$row .= '"'.$user['client_disposit_during_call'].'",';
			$row .= '"'.$user['client_disposit_during_call_reason'].'",';
			$row .= '"'.$user['client_disposit_during_call_kpi'].'",';
			$row .= '"'.$user['client_disposit_during_call_kpi_reason'].'",';
			$row .= '"'.$user['client_upload_document'].'",';
			$row .= '"'.$user['client_upload_document_reason'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
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
	
	public function download_qa_octafx_outbound_feedback_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./qa_files/octafx/Report".get_user_id().".csv";
		$newfile="QA OctaFX Outbound Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	////////////////////////////////////////////////////
	public function create_qa_octafx_outbound_feedback_CSV($rr)
	{
		$filename = "./qa_files/octafx/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "Supervisor", "Call Date", "Customer Id", "Call Duration", "Audit Week", "Conversion ACPT","Conversion ACPT Remarks","High AHT ACPT","High AHT ACPT Remarks","Call Reschedule ACPT","Call Reschedule ACPT Remarks", "Call Week", "AON", "Call Type", "Audit Type","Call Id", "VOC", "Audit Start Date/Time", "Audit End Date/Time", "Interval(in sec)", "Earned Score", "Possible Score", "Overall Score",
		"Preparation and Profile check on CRM","Preparation and Profile check on CRM - Reason",
		"Complete Introduction","Complete Introduction -  Reason",
		"Profiling to understand the clients background","Profiling to understand the client's background -  Reason",
		"Proper explanation of product and offer as per clients requirement","Proper explanation of product and offer as per clients requirement - Reason",
		"Skillfully driving the call towards deposit","Skillfully driving the call towards deposit - Reason",
		"Effective objection handling","Effective objection handling -  Reason",
		"Proper probing if client does not show interest or raises any concern","Proper probing if client does not show interest or raises any concern -  Reason", 
		"Building a two way communication to get clients engagement on call properly","Building a two way communication to get clients engagement on call properly - Reason",
		 "Urgency creation for deposit if client asks for time","Urgency creation for deposit if client asks for time -  Reason",
		 "Rebuttal used for higher amount of deposit if client is looking to start with low","Rebuttal used for higher amount of deposit if client is looking to start with low - Reason",
		  "Proper guidance about payment process and modes","Proper guidance about payment process and modes - Reason",
		  "Taking call back request (if required)","Taking call back request (if required) - Reason",
		  "Call was tagged properly","Call was tagged properly - Reason",
		  "Email was send as per call scenario","Email was send as per call scenario - Reason",
		  "Call was rescheduled in CRM (if required)","Call was rescheduled in CRM (if required) - Reason",
		  "Attentiveness (inactive or silent on call)","Attentiveness (inactive or silent on call) - Reason",
		  "Energetic and enthusiastic","Energetic and enthusiastic - Reason",
		  "Clarity and proper pace of speech","Clarity and proper pace of speech - Reason",
		  "Confident on call","Confident on call - Reason",
		  "Polite and friendly","Polite and friendly - Reason",
		  "No Interruption or Parallel talk","No Interruption or Parallel talk - Reason",
		  "Misleading client for deposit/account verification","CMisleading client for deposit/account verification - Reason",
		  "Asking for clients personal details (i.e account /payment mode details)","Asking for clients personal details (i.e account /payment mode details) - Reason",
		  "Using sarcastice/commanding/impolite tone","Using sarcastice/commanding/impolite tone - Reason",
		  "Using profranity or having unprofessional discussion","Using profranity or having unprofessional discussion - Reason",
		  "	Client has verified the account on agents request","Client has verified the account on agents request - Reason",
		  "Client has deposited on agents request","Client has deposited on agents request - Reason",
		  "Client has deposited above KPI on agents request","Client has deposited above KPI on agents request - Reason",
		"Audit Summary", "Audit Feedback", "Agent Review Date", "Agent Comment","Agent Feedback Acceptance", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

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
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['audit_week'].'",';
			$row .= '"'.$user['conversion_acpt'].'",';
			$row .= '"'.$user['conversion_acpt_remarks'].'",';
			$row .= '"'.$user['high_aht_acpt'].'",';
			$row .= '"'.$user['high_aht_acpt_remarks'].'",';
			$row .= '"'.$user['call_reschedule_acpt'].'",';
			$row .= '"'.$user['call_reschedule_remarks'].'",';
			$row .= '"'.$user['call_week'].'",';
			$row .= '"'.$user['tenuarity'].'",';
			$row .= '"'.$user['call_type2'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['preparation_profile_check'].'",';
			$row .= '"'.$user['preparation_profile_check_reason'].'",';
			$row .= '"'.$user['complete_introduction'].'",';
			$row .= '"'.$user['complete_introduction_reason'].'",';
			$row .= '"'.$user['profiling_background'].'",';
			$row .= '"'.$user['profiling_background_reason'].'",';
			$row .= '"'.$user['proper_explation'].'",';
			$row .= '"'.$user['proper_explation_reason'].'",';
			$row .= '"'.$user['skillfully_driving'].'",';
			$row .= '"'.$user['skillfully_driving_reason'].'",';
			$row .= '"'.$user['objection_handle'].'",';
			$row .= '"'.$user['objection_handle_reason'].'",';
			$row .= '"'.$user['proper_probing'].'",';
			$row .= '"'.$user['proper_probing_reason'].'",';
			$row .= '"'.$user['build_two_way_communication'].'",';
			$row .= '"'.$user['build_two_way_communication_reason'].'",';
			$row .= '"'.$user['urgency_creation'].'",';
			$row .= '"'.$user['urgency_creation_reason'].'",';
			$row .= '"'.$user['rebuttal_used'].'",';
			$row .= '"'.$user['rebuttal_used_reason'].'",';
			$row .= '"'.$user['proper_guidance'].'",';
			$row .= '"'.$user['proper_guidance_reason'].'",';
			$row .= '"'.$user['call_back'].'",';
			$row .= '"'.$user['call_back_reason'].'",';
			$row .= '"'.$user['tagged_properly'].'",';
			$row .= '"'.$user['tagged_properly_reason'].'",';
			$row .= '"'.$user['email_call_scenario'].'",';
			$row .= '"'.$user['email_call_scenario_reason'].'",';
			$row .= '"'.$user['call_rescheduled'].'",';
			$row .= '"'.$user['call_rescheduled_reason'].'",';
			$row .= '"'.$user['attentiveness'].'",';
			$row .= '"'.$user['attentiveness_reason'].'",';
			$row .= '"'.$user['energetic_enthusiastic'].'",';
			$row .= '"'.$user['energetic_enthusiastic_reason'].'",';
			$row .= '"'.$user['pace_of_speech'].'",';
			$row .= '"'.$user['pace_of_speech_reason'].'",';
			$row .= '"'.$user['confident_call'].'",';
			$row .= '"'.$user['confident_call_reason'].'",';
			$row .= '"'.$user['polite_friendly'].'",';
			$row .= '"'.$user['polite_friendly_reason'].'",';
			$row .= '"'.$user['parallel_talk'].'",';
			$row .= '"'.$user['parallel_talk_reason'].'",';
			$row .= '"'.$user['account_verification'].'",';
			$row .= '"'.$user['account_verification_reason'].'",';
			$row .= '"'.$user['clients_personal_details'].'",';
			$row .= '"'.$user['clients_personal_details_reason'].'",';
			$row .= '"'.$user['impolite_tone'].'",';
			$row .= '"'.$user['impolite_tone_reason'].'",';
			$row .= '"'.$user['unprofessional_discussion'].'",';
			$row .= '"'.$user['unprofessional_discussion_reason'].'",';
			$row .= '"'.$user['verified_account'].'",';
			$row .= '"'.$user['verified_account_reason'].'",';
			$row .= '"'.$user['deposited_request'].'",';
			$row .= '"'.$user['deposited_request_reason'].'",';
			$row .= '"'.$user['deposited_KPI'].'",';
			$row .= '"'.$user['deposited_KPI_reason'].'",';

			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
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

	////////////////////////////////////////////////////
 }