<?php 

 class Qa_bsnl extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
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
    }
	
	
//////////////////////  BSNL /////////////////////////	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_bsnl/qa_bsnl.php";
			$data["content_js"] = "qa_bsnl_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,614) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
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
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["gds_prearrival"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["bsnl_new"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_bsnl($bsnl_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_bsnl/add_edit_bsnl.php";
			$data["content_js"] = "qa_bsnl_js.php";
			$data['bsnl_id']=$bsnl_id;
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
				$client_id=288;
				$pro_id = 614;
				$curDateTime=CurrMySqlDate();
				$upArr = array('distribution_opend_by' =>$current_user,'distribution_opened_datetime'=>$curDateTime);
				$this->db->where('id', $rand_id);
				$this->db->update('qa_randamiser_bsnl_data',$upArr);
				
				$randSql="Select srd.*,srd.aht as call_duration, S.id as sid, S.fname, S.lname, S.xpoid, S.assigned_to,
				(select concat(fname, ' ', lname) as name from signin s1 where s1.id=S.assigned_to) as tl_name,DATEDIFF(CURDATE(), S.doj) as tenure
				from qa_randamiser_bsnl_data srd Left Join signin S On srd.fusion_id=S.fusion_id where srd.audit_status=0 and srd.id='$rand_id'";
				$data["rand_data"] = $rand_data =  $this->Common_model->get_query_row_array($randSql);
				
			}
			//print_r($data["rand_data"]);
			/******** Randamiser Ends**********/
			
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,614) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_bsnl_feedback where id='$bsnl_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["bsnl"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($bsnl_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					// $field_array['week']=$this->input->post('week');
					// $field_array['mobile_no']=$this->input->post('mobile_no');
					// $field_array['circle']=$this->input->post('circle');
				
				
					// print_r($field_array);
					// die();
					$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_bsnl/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_bsnl_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_bsnl_feedback',$add_array);
					
					if($rand_id!=0){
					$rand_restore_array = array("audit_status" => 1);
					$this->db->where('randomiser_id', $rand_id);
					$this->db->update('qa_sampling_restore_data',$rand_restore_array);
					
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_bsnl_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_bsnl_feedback',$rand_array);
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					if(!isset($field_array1['auditor_type'])){
						$field_array1['auditor_type'] = "";
					}
					$this->db->where('id', $bsnl_id);
					$this->db->update('qa_bsnl_feedback',$field_array1);
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
					$this->db->where('id', $bsnl_id);
					$this->db->update('qa_bsnl_feedback',$edit_array);
					
				}
				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Qa_randamiser/data_distribute_freshdesk?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('qa_bsnl');
				}
				//redirect('qa_bsnl');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	

	public function add_edit_bsnl_outbound($bsnl_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_bsnl/add_edit_bsnl_outbound.php";
			$data["content_js"] = "qa_bsnl_js.php";
			$data['bsnl_id']=$bsnl_id;
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
				$client_id=288;
				$pro_id = 614;
				$curDateTime=CurrMySqlDate();
				$upArr = array('distribution_opend_by' =>$current_user,'distribution_opened_datetime'=>$curDateTime);
				$this->db->where('id', $rand_id);
				$this->db->update('qa_randamiser_bsnl_data',$upArr);
				
				$randSql="Select srd.*,srd.aht as call_duration, S.id as sid, S.fname, S.lname, S.xpoid, S.assigned_to,
				(select concat(fname, ' ', lname) as name from signin s1 where s1.id=S.assigned_to) as tl_name,DATEDIFF(CURDATE(), S.doj) as tenure
				from qa_randamiser_bsnl_data srd Left Join signin S On srd.fusion_id=S.fusion_id where srd.audit_status=0 and srd.id='$rand_id'";
				$data["rand_data"] = $rand_data =  $this->Common_model->get_query_row_array($randSql);
				
			}
			//print_r($data["rand_data"]);
			/******** Randamiser Ends**********/ 
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);



			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_bsnl_new_feedback where id='$bsnl_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["bsnl"] = $this->Common_model->get_query_row_array($qSql);


			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($bsnl_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_bsnl/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_bsnl_new_feedback',$field_array);

					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_bsnl_new_feedback',$add_array);

					if($rand_id!=0){
					
					
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_bsnl_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_bsnl_new_feedback',$rand_array);
					}
					}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $bsnl_id);
					$this->db->update('qa_bsnl_new_feedback',$field_array1);
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
					$this->db->where('id', $bsnl_id);
					$this->db->update('qa_bsnl_new_feedback',$edit_array);

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Qa_randamiser/data_distribute_freshdesk?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('qa_bsnl');
				}
				// redirect('qa_bsnl');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	

/////////////////////////////////////////////////////////////////////
/////////////////////////Agent part/////////////////////////////////	
public function agent_bsnl_feedback()
	{
		if(check_logged_in())
		{
			//$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
						
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_bsnl/agent_bsnl_feedback.php";
			$data["content_js"] = "qa_bsnl_js.php";
			$data["agentUrl"] = "Qa_bsnl/agent_bsnl_feedback";
			
			$qSql="Select count(id) as value from qa_bsnl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_bsnl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);


			$qSql="Select count(id) as value from qa_bsnl_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
			$data["tot_feedback1"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_bsnl_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
			$data["yet_rvw1"] =  $this->Common_model->get_single_value($qSql);
			$from_date = '';
			$to_date = '';
			$cond="";
			$user="";

			if(get_role_dir()=='agent'){
					$user .="where id ='$current_user'";
				}
			
			if($this->input->get('btnView')=='View')
			{
			
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin $user) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_new_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin $user) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list1"] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$from_date = date('Y-m-d');
				$to_date =  date('Y-m-d');
				
             $qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit' , 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and audit_date >= '$from_date' and audit_date <='$to_date') xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit' , 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and audit_date >= '$from_date' and audit_date <='$to_date') xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list1"] = $this->Common_model->get_query_result_array($qSql);

			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			// echo $qSql;
			// exit;
			
			$this->load->view('dashboard',$data);
		}
	}

	public function agent_bsnl_rvw($id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['gds_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_bsnl/agent_bsnl_rvw.php";
			$data["content_js"] = "qa_bsnl_js.php";
			$data["agentUrl"] = "Qa_bsnl/agent_bsnl_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["bsnl"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["bsnl_id"]=$id;
			
			if($this->input->post('bsnl_id'))
			{
				$pnid=$this->input->post('bsnl_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_bsnl_feedback',$field_array1);
					
				redirect('Qa_bsnl/agent_bsnl_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}



	public function agent_bsnl_rvw_new($id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['gds_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_bsnl/agent_bsnl_rvw_new.php";
			$data["content_js"] = "qa_bsnl_js.php";
			$data["agentUrl"] = "Qa_bsnl/agent_bsnl_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_bsnl_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["bsnl"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["bsnl_id"]=$id;
			
			if($this->input->post('bsnl_id'))
			{
				$pnid=$this->input->post('bsnl_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_bsnl_new_feedback',$field_array1);
					
				redirect('Qa_bsnl/agent_bsnl_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Report Part //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_bsnl_report_new(){
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
			$data["content_template"] = "reports_qa/qa_bsnl_report_new.php";
			$data["content_js"] = "qa_bsnl_js.php";
			
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
			$user="";
			
			$campaign ="bsnl";
			
			$data["bsnl_list"] = array();
			
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
               
				if(get_role_dir()=='agent'){
					$user .="where id ='$current_user'";
				}


				
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_bsnl_new_feedback) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["bsnl_list"] = $fullAray;
				$this->create_qa_bsnl_CSV($fullAray,$campaign);	
				$dn_link = base_url()."Qa_bsnl/download_qa_bsnl_CSV/".$campaign;	
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
	 

	public function download_qa_bsnl_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_bsnl_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Queue", "Call Type", "Sub-type of Call","Week","Mobile No","Circle", "Recording Track ID", "Category", "Sap ID", "Asst. Manager", "DNIS (VDN)", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC", "Earned Score", "Possible Score","Overall Score",
				"Opening",
				"Stated the purpose of the call",
				"Call handling skill",
				"Resolution",
				"Retention",
				"Closing",
				"Tagging",
				"Not a ZT call","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8",
				"Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment","Randamiser");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		// $randamiser_comment ="";
		
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

				// if($user['is_rand']==1){
				// 	$randamiser_comment .= 'Audit From Randamiser';
				// }else{
				// 	$randamiser_comment .= '';
				// }
				
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_queue'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['sub_type'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['mobile_no'].'",';
				$row .= '"'.$user['circle'].'",';
				$row .= '"'.$user['record_track'].'",';
				$row .= '"'.$user['category'].'",';
				$row .= '"'.$user['sap_id'].'",';
				$row .= '"'.$user['asst_manager'].'",';
				$row .= '"'.$user['dnis'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
			
								
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'",';

				
                $row .= '"'.$user['opening'].'",';
				$row .= '"'.$user['purpose_of_the_call'].'",';
				$row .= '"'.$user['call_handling'].'",';
				$row .= '"'.$user['resolution'].'",';
				$row .= '"'.$user['retention'].'",';
				$row .= '"'.$user['closing'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['zt_call'].'",';

				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				
                
                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				// $row = '"'.$randamiser_comment.'",';
				if($user['is_rand']==1){
					$row .= '"Audit From Randamiser",';
				}else{
					$row .= '"",';
				}

				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		

        }
	}
 
