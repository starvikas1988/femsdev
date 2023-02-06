<?php 

 class Qa_india_moe extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
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

	private function india_moe_upload_files($files,$path)
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
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_india_moe/qa_india_moe_feedback.php";
			$data["content_js"] = "qa_add_india_moe_js.php";	
			//$data["content_js"] = "qa_india_moe_js.php";	
				

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,67) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_india_moe_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["india_moe_list"] = $this->Common_model->get_query_result_array($qSql);
			//qa_india_moe_feedback
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////Pre Booking Audit//////////////////////////////


	public function add_edit_india_moe_booking($india_moe_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_india_moe/add_edit_india_moe_booking.php";
			$data["content_js"] = "qa_add_india_moe_js.php";
			//$data["content_js"] = "qa_cars24_js.php";
			$data['india_moe_id']=$india_moe_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			//$data["agentName"] = $this->Qa_verso_model->get_agent_id(9,19,67);
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,9) and (is_assign_process (id,19) or is_assign_process (id,67)) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			//is_assign_process(id,529)
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_india_moe_feedback where id='$india_moe_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["india_moe"] = $this->Common_model->get_query_row_array($qSql);
			//qa_india_moe_feedback

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($india_moe_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->india_moe_upload_files($_FILES['attach_file'], $path='./qa_files/india_moe/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_india_moe_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_india_moe_feedback',$add_array);
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $india_moe_id);
					$this->db->update('qa_india_moe_feedback',$field_array1);
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
					$this->db->where('id', $india_moe_id);
					$this->db->update('qa_india_moe_feedback',$edit_array);
					
				}
				redirect('qa_verso/qa_verso_ob_fc_feedback');
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



/////////////////India Moe Agent part//////////////////////////	

	public function agent_india_moe_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_india_moe/agent_india_moe_feedback.php";
			$data["content_js"] = "qa_add_india_moe_js.php";	
			$data["agentUrl"] = "qa_india_moe/agent_india_moe_feedback";		
			//$campaign="";
			//$campaign = $this->input->get('campaign');
			$qSql="Select count(id) as value from qa_india_moe_feedback where agent_id='$current_user'";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_india_moe_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			
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
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_india_moe_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			}else{
				
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_india_moe_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			//$data['campaign']=$campaign;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function agent_india_moe_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_india_moe/agent_india_moe_feedback_rvw.php";
			$data["content_js"] = "qa_add_india_moe_js.php";
			$data["agentUrl"] = "qa_india_moe/agent_india_moe_feedback";
			$data["india_moe_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_india_moe_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["india_moe"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('india_moe_id'))
			{
				$india_moe_id=$this->input->post('india_moe_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $india_moe_id);
				$this->db->update('qa_india_moe_feedback',$field_array);
				redirect('qa_verso/agent_verso_ob_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
 }