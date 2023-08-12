<?php 

 class Qa_ossur extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	public function createPath($path){
		if(!empty($path)){
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
    }
	
	/* private function audio_upload_files($files,$path)
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
	
	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

/*--------------------------------------------------------------------------------------------------*/
/*------------------------------------------- QA Part ----------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function qa_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ossur/qa_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$from_date="";
			$to_date="";
			$agent_id="";
			$cond="";
			$ops_cond="";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,805) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			/* $qSql="Select count(blm.id) as audit_cnt, (select count(b1.id) from qa_ossur_feedback b1 where b1.id=blm.id and b1.agnt_fd_acpt='Acceptance') as agn_accepted, (select count(b2.id) from qa_ossur_feedback b2 where b2.id=blm.id and b2.agnt_fd_acpt='Not Acceptance') as agn_not_accepted from qa_ossur_feedback blm";
			$data["barChartData"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select AVG(blm.overall_score) as score from qa_ossur_feedback blm group by blm.audit_type";
			$data["pieChartData"] = $this->Common_model->get_query_row_array($qSql); */
			
			$data["auditData1"]=array();
			$data["auditData2"]=array();
			
			if($this->input->get('btnView')=='Show')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				$agent_id = $this->input->get('agent_id');
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
				if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$ops_cond=" Where assigned_to='$current_user'";
				}else if(get_login_type()=="client"){
					$ops_cond="";
				}else{
					$ops_cond="";
				}
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ossur_voice_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				$data["auditData1"] = $this->Common_model->get_query_result_array($qSql);
			///////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ossur_email_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				$data["auditData2"] = $this->Common_model->get_query_result_array($qSql);
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_voice($adt_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ossur/add_edit_voice.php";
			$data["content_js"] = "qa_audit_js.php";
			$data['adt_id']=$adt_id;
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
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,805) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ossur_voice_feedback where id='$adt_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"]= $adtsht = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$data['global_element'] = global_acpt_edit($adtsht);
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($adt_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ossur/voice/');
						$field_array["attach_file"] = implode(',',$a);
					}
					$rowid= data_inserter('qa_ossur_voice_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ossur_voice_feedback',$add_array);
				/////////////
				/* Randamiser section */
				if($rand_id!=0){
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_ossur_voice_feedback',$rand_array);
					}
				/* Randamiser section */
					$client_report_url = $this->Common_model->get_single_value('Select qa_report_url as value from client where id=369');
					if($client_report_url==""){
						$this->db->query("Update client set qa_report_url='qa_ossur/qa_report' where id=369");
					}
					
					$process_report_url = $this->Common_model->get_single_value('Select qa_url as value from process where id=805');
					if($process_report_url==""){
						$this->db->query("Update process set qa_url='qa_ossur/qa_feedback', qa_agent_url='qa_ossur/agent_ossur_feedback' where id=805");
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ossur/voice/');
						$field_array1["attach_file"] = implode(',',$a);
					}
					$this->db->where('id', $adt_id);
					$this->db->update('qa_ossur_voice_feedback',$field_array1);
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
					$this->db->where('id', $adt_id);
					$this->db->update('qa_ossur_voice_feedback',$edit_array);
					
				}
				
				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('qa_ossur/qa_feedback');
				}
				//redirect('qa_ossur/qa_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_email($adt_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ossur/add_edit_email.php";
			$data["content_js"] = "qa_audit_js.php";
			$data['adt_id']=$adt_id;
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
				
			}
			/* Randamiser Code End */
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,805) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ossur_email_feedback where id='$adt_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $adtsht = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$data['global_element'] = global_acpt_edit($adtsht);
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($adt_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ossur/email/');
						$field_array["attach_file"] = implode(',',$a);
					}
					$rowid= data_inserter('qa_ossur_email_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ossur_email_feedback',$add_array);
				/////////////
				/* Randamiser section */
				if($rand_id!=0){
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_ossur_email_feedback',$rand_array);
					}
				/* Randamiser section */
					$client_report_url = $this->Common_model->get_single_value('Select qa_report_url as value from client where id=369');
					if($client_report_url==""){
						$this->db->query("Update client set qa_report_url='qa_ossur/qa_report' where id=369");
					}
					
					$process_report_url = $this->Common_model->get_single_value('Select qa_url as value from process where id=805');
					if($process_report_url==""){
						$this->db->query("Update process set qa_url='qa_ossur/qa_feedback', qa_agent_url='qa_ossur/agent_ossur_feedback' where id=805");
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ossur/email/');
						$field_array1["attach_file"] = implode(',',$a);
					}
					$this->db->where('id', $adt_id);
					$this->db->update('qa_ossur_email_feedback',$field_array1);
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
					$this->db->where('id', $adt_id);
					$this->db->update('qa_ossur_email_feedback',$edit_array);
					
				}
				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('qa_ossur/qa_feedback');
				}
				//redirect('qa_ossur/qa_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/*--------------------------------------------------------------------------------------------------*/
/*------------------------------------------ Agent Part --------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function agent_ossur_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ossur/agent_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_ossur/agent_ossur_feedback";
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$adtType = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign!=""){
			
				$adtType .=" audit_type not in ('Calibration','Pre-Certificate Mock Call','Certification Audit','QA Supervisor Audit')";
				
				$qSql="Select count(id) as value from qa_ossur_".$campaign."_feedback where agent_id='$current_user' and $adtType";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_ossur_".$campaign."_feedback where agent_id='$current_user' and agent_rvw_date is Null and $adtType";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='Show')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
					
					if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ossur_".$campaign."_feedback $cond and $adtType) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
					$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
		
				}
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_ossur_rvw($adt_id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ossur/agent_rvw.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_ossur/agent_ossur_feedback";
			$data["pnid"]=$adt_id;
			$data["campaign"]=$campaign;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ossur_".$campaign."_feedback where id='$adt_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $adtsht = $this->Common_model->get_query_row_array($qSql);
			
			$data['global_element'] = global_acpt_edit($adtsht);
			
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
				$this->db->update('qa_ossur_'.$campaign.'_feedback',$field_array1);
					
				redirect('qa_ossur/agent_ossur_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
/*--------------------------------------------------------------------------------------------------*/
/*----------------------------------------- Report Part --------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function qa_ossur_report(){
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
			$data["content_template"] = "qa_ossur/qa_report.php";
			$data["content_js"] = "qa_audit_js.php";
			
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
			
			$campaign = $this->input->get('campaign');
			
			$data["auditData"] = array();
			
			if($campaign!=""){
				if($this->input->get('btnView')=='Show')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
					$office_id = $this->input->get('office_id');
					$audit_type = $this->input->get('audit_type');
					
					if($from_date!="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";
			
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
					}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
						$cond1 .=" And assigned_to='$current_user'";
					}else{
						$cond1 .="";
					}
					
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_ossur_".$campaign."_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date"; 
					
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["auditData"] = $fullAray;
					$this->create_qa_ossur_CSV($fullAray,$campaign);	
					$dn_link = base_url()."qa_ossur/download_qa_ossur_CSV/".$campaign;	
				}
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_ossur_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Ossur ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_ossur_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		if($campaign=="voice"){
			$header = array("Auditor", "Agent", "Employee MWP ID", "L1/TL Name", "Audit Date", "Ticket/File/Call ID", "Call Date", "Call Duration", "Phone Number", "Site/Location", "ACPT", "Call Type", "Reason of the Call", "Type of Violation", "Audit Type", "Auditor Type", "Predictive CSAT/VOC", "Audit Start Date and Time", "Audit End Date and Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score",
			"Did rep appropriately greet the caller?","Comment", "Did the rep understand and demonstrate willingness to assist?","Comment", "Did the agent offer Empathy/Apology? (if applicable)","Comment", "Did the rep pull the correct account?","Comment", "Did the rep ask for caller name PO number and enter the correct information?","Comment", "Was the shipping address correct?","Comment", "Did the agent select the correct product names and quantities?","Comment", "If caller called to cancel an order did the agent cancel the correct sales order number?","Comment", "Was the agent able to correctly process return authorization or return label?","Comment", "Was the agent able to provide the correct general information or tracking information? (if required)","Comment", "Did the rep apply free shipping? (if applicable)","Comment", "Did the rep call the correct dept and transfer appropriately? (If applicable)","Comment", "Did the rep refresh caller every 20 seconds to avoid long periods of silence through out the call?","Comment", "Did the rep abuse hold/put customer on hold for more than 4 minutes?","Comment", "Did the agent speak clearly concisely and at an appropriate pace and avoid interruption?","Comment", "Did the agent use thank you you are welcome I am sorry etc throughout the call?","Comment", "Was the agent courteous and professional during the call?","Comment", "Was the correct sales order number provided?","Comment", "Did the agent provide ETA for the order?","Comment", "Did the agent thank the customer for calling?","Comment",
			"Hygiene Sampling - Agent was not stella phishing?","Remarks","Hygiene Sampling - Agent was not avoiding Stella Survey?","Remarks","Hygiene Sampling - Attempted to Cross Sell?","Remarks","AHT Related Spot Check - Agent","Remarks","AHT Related Spot Check - Customer","Remarks","AHT Related Spot Check - Process","Remarks","AHT Related Spot Check - Technology","Remarks","Conversion Related Spot Check - Agent","Remarks","Conversion Related Spot Check - Customer","Remarks","Conversion Related Spot Check - Process","Remarks","Conversion Related Spot Check - Technology","Remarks","SR/HR Related Spot Check - Agent","Remarks","SR/HR Related Spot Check - Customer","Remarks","SR/HR Related Spot Check - Process","Remarks","SR/HR Related Spot Check - Technology","Remarks","CSAT Related Spot Check - Agent","Remarks","CSAT Related Spot Check - Customer","Remarks","CSAT Related Spot Check - Process","Remarks","CSAT Related Spot Check - Technology","Remarks",
			"Customer Critical Earn","Customer Critical Possible","Customer Critical Overall", "Business Critical Earn","Business Critical Possible","Business Critical Overall", "Compliance Critical Earn","Compliance Critical Possible","Compliance Critical Overall",
			"Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date and Time", "Agent Review Comment", "Management Review By", "Management Review Date and Time", "Management Review Comment", "Client Review By", "Client Review Date and Time", "Client Review Comment");
		}else if ($campaign=="email"){
			$header = array("Auditor", "Agent", "Employee MWP ID", "L1/TL Name", "Audit Date", "Ticket/Sales Oredr No", "Email Date", "Reason of the Email", "Type of Violation", "Audit Type", "Auditor Type", "Predictive CSAT", "Audit Start Date and Time", "Audit End Date and Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score",
			"Was the account number correct?","Comment", "Order received by - was fielded correct?","Comment", "Was the order placed by - correct?","Comment", "Was the PO number entered correctly?","Comment", "Was the shipping address correct?","Comment", "Were the correct items selected?","Comment", "Correct quantities added?","Comment", "Was the shipping method correct?","Comment", "Was the preferred DC selected properly?","Comment", "Was the free freight removed? (If applicable)","Comment", "Was the order released?","Comment",
			"Hygiene Sampling - Agent was not stella phishing?","Remarks","Hygiene Sampling - Agent was not avoiding Stella Survey?","Remarks","Hygiene Sampling - Attempted to Cross Sell?","Remarks","AHT Related Spot Check - Agent","Remarks","AHT Related Spot Check - Customer","Remarks","AHT Related Spot Check - Process","Remarks","AHT Related Spot Check - Technology","Remarks","Conversion Related Spot Check - Agent","Remarks","Conversion Related Spot Check - Customer","Remarks","Conversion Related Spot Check - Process","Remarks","Conversion Related Spot Check - Technology","Remarks","SR/HR Related Spot Check - Agent","Remarks","SR/HR Related Spot Check - Customer","Remarks","SR/HR Related Spot Check - Process","Remarks","SR/HR Related Spot Check - Technology","Remarks","CSAT Related Spot Check - Agent","Remarks","CSAT Related Spot Check - Customer","Remarks","CSAT Related Spot Check - Process","Remarks","CSAT Related Spot Check - Technology","Remarks",
			"Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date and Time", "Agent Review Comment", "Management Review By", "Management Review Date and Time", "Management Review Comment", "Client Review By", "Client Review Date and Time", "Client Review Comment");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=="voice"){
			foreach($rr as $user)
			{	
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
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['call_reason'].'",';
				$row .= '"'.$user['violation_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greet_caller_appropiately'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['demonstrate_willingness'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['empathy_apology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['pull_correct_account'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['ask_caller_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['shipping_address'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['select_correct_product'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['caller_cancel_order'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['correctly_process_return'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['provide_correct_info'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['apply_free_shipping'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['call_correct_dept'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['refresh_caller_20sec'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['put_customer_hold'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['agent_speak_clearly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['agent_use_thankyou'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'.$user['professional_during_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'.$user['correct_sales_order'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'.$user['provide_order_eta'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'.$user['thank_customer_calling'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'.$user['stella_phishing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt1'])).'",';
				$row .= '"'.$user['avoid_stella_survey'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt2'])).'",';
				$row .= '"'.$user['attempt_cross_sell'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt3'])).'",';
				$row .= '"'.$user['aht_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt4'])).'",';
				$row .= '"'.$user['aht_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt5'])).'",';
				$row .= '"'.$user['aht_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt6'])).'",';
				$row .= '"'.$user['aht_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt7'])).'",';
				$row .= '"'.$user['conversion_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt8'])).'",';
				$row .= '"'.$user['conversion_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt9'])).'",';
				$row .= '"'.$user['conversion_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt10'])).'",';
				$row .= '"'.$user['conversion_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt11'])).'",';
				$row .= '"'.$user['sr_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt12'])).'",';
				$row .= '"'.$user['sr_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt13'])).'",';
				$row .= '"'.$user['sr_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt14'])).'",';
				$row .= '"'.$user['sr_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt15'])).'",';
				$row .= '"'.$user['csat_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt16'])).'",';
				$row .= '"'.$user['csat_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt17'])).'",';
				$row .= '"'.$user['csat_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt18'])).'",';
				$row .= '"'.$user['csat_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt19'])).'",';
				$row .= '"'.$user['customer_score'].'",';
				$row .= '"'.$user['customer_scoreable'].'",';
				$row .= '"'.$user['customer_percentage'].'",';
				$row .= '"'.$user['business_score'].'",';
				$row .= '"'.$user['business_scoreable'].'",';
				$row .= '"'.$user['business_percentage'].'",';
				$row .= '"'.$user['compliance_score'].'",';
				$row .= '"'.$user['compliance_scoreable'].'",';
				$row .= '"'.$user['compliance_percentage'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'.$user['client_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}else if($campaign=="email"){
			foreach($rr as $user)
			{	
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
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['email_reason'].'",';
				$row .= '"'.$user['violation_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['coorect_account_number'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['order_recieved'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['correct_order_placed'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['correct_po_number'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['correct_shipping_address'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['correct_item_select'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['correct_quantity_added'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['shipping_method_correct'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['prefered_dc_select'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['free_freight_removed'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['order_released'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['stella_phishing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt1'])).'",';
				$row .= '"'.$user['avoid_stella_survey'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt2'])).'",';
				$row .= '"'.$user['attempt_cross_sell'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt3'])).'",';
				$row .= '"'.$user['aht_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt4'])).'",';
				$row .= '"'.$user['aht_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt5'])).'",';
				$row .= '"'.$user['aht_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt6'])).'",';
				$row .= '"'.$user['aht_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt7'])).'",';
				$row .= '"'.$user['conversion_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt8'])).'",';
				$row .= '"'.$user['conversion_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt9'])).'",';
				$row .= '"'.$user['conversion_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt10'])).'",';
				$row .= '"'.$user['conversion_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt11'])).'",';
				$row .= '"'.$user['sr_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt12'])).'",';
				$row .= '"'.$user['sr_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt13'])).'",';
				$row .= '"'.$user['sr_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt14'])).'",';
				$row .= '"'.$user['sr_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt15'])).'",';
				$row .= '"'.$user['csat_related_agent'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt16'])).'",';
				$row .= '"'.$user['csat_related_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt17'])).'",';
				$row .= '"'.$user['csat_related_process'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt18'])).'",';
				$row .= '"'.$user['csat_related_technology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['acpt_cmt19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'.$user['client_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}
		
	}
	
	
	
 }
