<?php 

 class Qa_vrs extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}
	
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

	private function vrs_upload_files($files,$path)   // this is for file uploaging purpose
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
	// private function vrs_upload_files($files,$path){
 //        $config['upload_path'] = $path;
 //        $config['allowed_types'] = 'm4a|mp4|mp3|wav';
	// 	$config['max_size'] = '2024000';
	// 	$this->load->library('upload', $config);
	// 	$this->upload->initialize($config);
 //        $images = array();
 //        foreach ($files['name'] as $key => $image){           
	// 		$_FILES['uFiles']['name']= $files['name'][$key];
	// 		$_FILES['uFiles']['type']= $files['type'][$key];
	// 		$_FILES['uFiles']['tmp_name']= $files['tmp_name'][$key];
	// 		$_FILES['uFiles']['error']= $files['error'][$key];
	// 		$_FILES['uFiles']['size']= $files['size'][$key];

 //            if ($this->upload->do_upload('uFiles')) {
	// 			$info = $this->upload->data();
	// 			$ext = $info['file_ext'];
	// 			$file_path = $info['file_path'];
	// 			$full_path = $info['full_path'];
	// 			$file_name = $info['file_name'];
	// 			if(strtolower($ext)== '.wav'){
	// 				$file_name = str_replace(".","_",$file_name).".mp3";
	// 				$new_path = $file_path.$file_name;
	// 				$comdFile=FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
	// 				$output = shell_exec( $comdFile);
	// 				sleep(2);
	// 			}
	// 			$images[] = $file_name;
 //            }else{
 //                return false;
 //            }
 //        }
 //        return $images;
 //    }
	
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/qa_vrs_feedback.php";
			
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
			
			$field_array = array(
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"current_user" => $current_user
			);
			
			$data["qa_vrs_rp_data"] = $this->Qa_vrs_model->get_vrs_rp_data($field_array);

			$data["qa_new_lm_vrs"] = $this->Qa_vrs_model->get_new_lm_vrs($field_array);

			$data["qa_vrs_lm_data"] = $this->Qa_vrs_model->get_vrs_lm_data($field_array);
			
			$data["qa_vrs_cav_data"] = $this->Qa_vrs_model->get_vrs_cav_data($field_array);
			
			$data["qa_vrs_jrpa_data"] = $this->Qa_vrs_model->get_vrs_jrpa_data($field_array);
			
			$data["qa_vrs_rp_analysis_data"] = $this->Qa_vrs_model->get_vrs_rp_analysis_data($field_array);
			
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_vrs_cpta_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_cpta_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_vrs_cpta_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["vrs_new_data"] = $this->Common_model->get_query_result_array($qSql);
			///////////vrs_rightparty_v2////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_right_party_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["vrs_rightparty_v2"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_thirdparty_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["vrs_thirdparty"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	//////////////right party version 2///////vikas starts/////
	public function add_edit_right_party_v2($right_party_v2_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_edit_right_party_v2.php";
			//$data["content_js"] = "qa_universal_js.php";
			//$data["content_js"] = "qa_vrs_right_party_v2_js.php";
			$data["content_js"] = "qa_vrs_2_js.php";
			$data['right_party_v2_id']=$right_party_v2_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			// $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,18) and is_assign_process(id,30) and status=1  order by name";

			// $data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,18) or is_assign_client (id,30)) and (is_assign_process (id,30) or is_assign_process (id,88)) and status=1  order by name";
			$data['agentName'] = $this->Common_model->get_query_result_array($qSql);
			// $query = $this->db->query($qSql);
			 //$data['agentName'] = $query->result_array();	

	          //$data['agentName'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_vrs_right_party_v2_feedback where id='$right_party_v2_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["right_party_v2_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($right_party_v2_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->vrs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_rp_vrs_v2/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_vrs_right_party_v2_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_vrs_right_party_v2_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_rp_vrs_v2/")){
							mkdir("./qa_files/qa_rp_vrs_v2/");
						}
						$a = $this->vrs_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_rp_vrs_v2/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $right_party_v2_id);
					$this->db->update('qa_vrs_right_party_v2_feedback',$field_array1);
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
					$this->db->where('id', $right_party_v2_id);
					$this->db->update('qa_vrs_right_party_v2_feedback',$edit_array);

				}

				redirect('Qa_vrs');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	//////////////////////vikas ends//////////////////////////
	public function add_edit_lm_vrs($lm_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_lm_vrs/add_edit_lm_vrs.php";
			$data["content_js"] = "qa_universal_js.php";
			$data['lm_id']=$lm_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,18) and is_assign_process (id,30) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_new_lm_feedback where id='$lm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["lm_data"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($lm_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					//$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['call_date']=$this->input->post('call_date');
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->vrs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_lm_vrs/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_new_lm_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_new_lm_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=$this->input->post('call_date');
					$this->db->where('id', $lm_id);
					$this->db->update('qa_new_lm_feedback',$field_array1);
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
					$this->db->where('id', $lm_id);
					$this->db->update('qa_new_lm_feedback',$edit_array);
					
				}
				redirect('Qa_vrs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
    ///////////////////////// VRS - Third Party ////////////////////////////
	public function add_edit_vrs_thirdparty($vrs_tp_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/vrs_thirdparty/add_edit_vrs_thirdparty.php";
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['vrs_tp_id']=$vrs_tp_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_vrs_thirdparty_feedback where id='$vrs_tp_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["vrs_thirdparty"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($vrs_tp_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					//$field_array['audit_date']=mmddyy2mysql($this->input->post('audit_date'));
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/thirdparty/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_vrs_thirdparty_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_vrs_thirdparty_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $vrs_tp_id);
					$this->db->update('qa_vrs_thirdparty_feedback',$field_array1);
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
					$this->db->where('id', $vrs_tp_id);
					$this->db->update('qa_vrs_thirdparty_feedback',$edit_array);
					
				}
				redirect('qa_vrs');
			
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

    //////////////////////VRS RP Audit//////////////////////////////
	
	public function add_rpaudit_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_rpaudit_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"opening_call" => $this->input->post('opening_call'),
					"opening_verbatim" => $this->input->post('opening_verbatim'),
					"opening_vrs" => $this->input->post('opening_vrs'),
					"opening_rightparty" => $this->input->post('opening_rightparty'),
					"opening_demographics" => $this->input->post('opening_demographics'),
					"opening_miranda" => $this->input->post('opening_miranda'),
					"opening_communication" => $this->input->post('opening_communication'),
					"opening_score" => $this->input->post('opening_score'),
					"opening_possible_scr" => $this->input->post('opening_possible_scr'),
					"effort_balance" => $this->input->post('effort_balance'),
					"effort_poe" => $this->input->post('effort_poe'),
					"effort_income" => $this->input->post('effort_income'),
					"effort_rent" => $this->input->post('effort_rent'),
					"effort_account" => $this->input->post('effort_account'),
					"effort_intension" => $this->input->post('effort_intension'),
					"effort_payment" => $this->input->post('effort_payment'),
					"effort_offer" => $this->input->post('effort_offer'),
					"effort_lump" => $this->input->post('effort_lump'),
					"effort_settlement" => $this->input->post('effort_settlement'),
					"effort_significant" => $this->input->post('effort_significant'),
					"effort_good" => $this->input->post('effort_good'),
					"effort_recoment" => $this->input->post('effort_recoment'),
					"effort_advise" => $this->input->post('effort_advise'),
					"effort_negotiate" => $this->input->post('effort_negotiate'),
					"effort_score" => $this->input->post('effort_score'),
					"effort_possible_scr" => $this->input->post('effort_possible_scr'),
					"callcontrol_demo" => $this->input->post('callcontrol_demo'),
					"callcontrol_anticipate" => $this->input->post('callcontrol_anticipate'),
					"callcontrol_question" => $this->input->post('callcontrol_question'),
					"callcontrol_establist" => $this->input->post('callcontrol_establist'),
					"callcontrol_timelines" => $this->input->post('callcontrol_timelines'),
					"callcontrol_task" => $this->input->post('callcontrol_task'),
					"callcontrol_company" => $this->input->post('callcontrol_company'),
					"callcontrol_escalate" => $this->input->post('callcontrol_escalate'),
					"callcontrol_score" => $this->input->post('callcontrol_score'),
					"callcontrol_possible_scr" => $this->input->post('callcontrol_possible_scr'),
					"compliance_mispresent" => $this->input->post('compliance_mispresent'),
					"compliance_threaten" => $this->input->post('compliance_threaten'),
					"compliance_account" => $this->input->post('compliance_account'),
					"compliance_faulse" => $this->input->post('compliance_faulse'),
					"compliance_contact" => $this->input->post('compliance_contact'),
					"compliance_communicate" => $this->input->post('compliance_communicate'),
					"compliance_consumer" => $this->input->post('compliance_consumer'),
					"compliance_policy" => $this->input->post('compliance_policy'),
					"compliance_location" => $this->input->post('compliance_location'),
					"compliance_dialer" => $this->input->post('compliance_dialer'),
					"compliance_unfair" => $this->input->post('compliance_unfair'),
					"compliance_credit" => $this->input->post('compliance_credit'),
					"compliance_disput" => $this->input->post('compliance_disput'),
					"compliance_obtain" => $this->input->post('compliance_obtain'),
					"compliance_imply" => $this->input->post('compliance_imply'),
					"compliance_legal" => $this->input->post('compliance_legal'),
					"compliance_barred" => $this->input->post('compliance_barred'),
					"compliance_fdcpa" => $this->input->post('compliance_fdcpa'),
					"compliance_consider" => $this->input->post('compliance_consider'),
					"compliance_collector" => $this->input->post('compliance_collector'),
					"compliance_score" => $this->input->post('compliance_score'),
					"compliance_possible_scr" => $this->input->post('compliance_possible_scr'),
					"closing_call" => $this->input->post('closing_call'),
					"closing_restate" => $this->input->post('closing_restate'),
					"closing_educate" => $this->input->post('closing_educate'),
					"closing_profession" => $this->input->post('closing_profession'),
					"closing_score" => $this->input->post('closing_score'),
					"closing_possible_scr" => $this->input->post('closing_possible_scr'),
					"document_action" => $this->input->post('document_action'),
					"document_result" => $this->input->post('document_result'),
					"document_context" => $this->input->post('document_context'),
					"document_remove" => $this->input->post('document_remove'),
					"document_update" => $this->input->post('document_update'),
					"document_change" => $this->input->post('document_change'),
					"document_escalate" => $this->input->post('document_escalate'),
					"document_score" => $this->input->post('document_score'),
					"document_possible_scr" => $this->input->post('document_possible_scr'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_rp/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_vrs_rp_feedback',$field_array);
				redirect('Qa_vrs');
				
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_vrs_rp_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/mgnt_vrs_rp_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["rpid"]=$id; 
			$a = array();
			
			$data["get_vrs_rp_feedback"] = $this->Qa_vrs_model->view_vrs_rp_feedback($id);
			$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_rp_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_rp_rvw($id);//MGNT PURPOSE
		
		///////Edit Part///////	
			if($this->input->post('rp_id'))
			{
				$rp_id=$this->input->post('rp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"opening_call" => $this->input->post('opening_call'),
					"opening_verbatim" => $this->input->post('opening_verbatim'),
					"opening_vrs" => $this->input->post('opening_vrs'),
					"opening_rightparty" => $this->input->post('opening_rightparty'),
					"opening_demographics" => $this->input->post('opening_demographics'),
					"opening_miranda" => $this->input->post('opening_miranda'),
					"opening_communication" => $this->input->post('opening_communication'),
					"opening_score" => $this->input->post('opening_score'),
					"opening_possible_scr" => $this->input->post('opening_possible_scr'),
					"effort_balance" => $this->input->post('effort_balance'),
					"effort_poe" => $this->input->post('effort_poe'),
					"effort_income" => $this->input->post('effort_income'),
					"effort_rent" => $this->input->post('effort_rent'),
					"effort_account" => $this->input->post('effort_account'),
					"effort_intension" => $this->input->post('effort_intension'),
					"effort_payment" => $this->input->post('effort_payment'),
					"effort_offer" => $this->input->post('effort_offer'),
					"effort_lump" => $this->input->post('effort_lump'),
					"effort_settlement" => $this->input->post('effort_settlement'),
					"effort_significant" => $this->input->post('effort_significant'),
					"effort_good" => $this->input->post('effort_good'),
					"effort_recoment" => $this->input->post('effort_recoment'),
					"effort_advise" => $this->input->post('effort_advise'),
					"effort_negotiate" => $this->input->post('effort_negotiate'),
					"effort_score" => $this->input->post('effort_score'),
					"effort_possible_scr" => $this->input->post('effort_possible_scr'),
					"callcontrol_demo" => $this->input->post('callcontrol_demo'),
					"callcontrol_anticipate" => $this->input->post('callcontrol_anticipate'),
					"callcontrol_question" => $this->input->post('callcontrol_question'),
					"callcontrol_establist" => $this->input->post('callcontrol_establist'),
					"callcontrol_timelines" => $this->input->post('callcontrol_timelines'),
					"callcontrol_task" => $this->input->post('callcontrol_task'),
					"callcontrol_company" => $this->input->post('callcontrol_company'),
					"callcontrol_escalate" => $this->input->post('callcontrol_escalate'),
					"callcontrol_score" => $this->input->post('callcontrol_score'),
					"callcontrol_possible_scr" => $this->input->post('callcontrol_possible_scr'),
					"compliance_mispresent" => $this->input->post('compliance_mispresent'),
					"compliance_threaten" => $this->input->post('compliance_threaten'),
					"compliance_account" => $this->input->post('compliance_account'),
					"compliance_faulse" => $this->input->post('compliance_faulse'),
					"compliance_contact" => $this->input->post('compliance_contact'),
					"compliance_communicate" => $this->input->post('compliance_communicate'),
					"compliance_consumer" => $this->input->post('compliance_consumer'),
					"compliance_policy" => $this->input->post('compliance_policy'),
					"compliance_location" => $this->input->post('compliance_location'),
					"compliance_dialer" => $this->input->post('compliance_dialer'),
					"compliance_unfair" => $this->input->post('compliance_unfair'),
					"compliance_credit" => $this->input->post('compliance_credit'),
					"compliance_disput" => $this->input->post('compliance_disput'),
					"compliance_obtain" => $this->input->post('compliance_obtain'),
					"compliance_imply" => $this->input->post('compliance_imply'),
					"compliance_legal" => $this->input->post('compliance_legal'),
					"compliance_barred" => $this->input->post('compliance_barred'),
					"compliance_fdcpa" => $this->input->post('compliance_fdcpa'),
					"compliance_consider" => $this->input->post('compliance_consider'),
					"compliance_collector" => $this->input->post('compliance_collector'),
					"compliance_score" => $this->input->post('compliance_score'),
					"compliance_possible_scr" => $this->input->post('compliance_possible_scr'),
					"closing_call" => $this->input->post('closing_call'),
					"closing_restate" => $this->input->post('closing_restate'),
					"closing_educate" => $this->input->post('closing_educate'),
					"closing_profession" => $this->input->post('closing_profession'),
					"closing_score" => $this->input->post('closing_score'),
					"closing_possible_scr" => $this->input->post('closing_possible_scr'),
					"document_action" => $this->input->post('document_action'),
					"document_result" => $this->input->post('document_result'),
					"document_context" => $this->input->post('document_context'),
					"document_remove" => $this->input->post('document_remove'),
					"document_update" => $this->input->post('document_update'),
					"document_change" => $this->input->post('document_change'),
					"document_escalate" => $this->input->post('document_escalate'),
					"document_score" => $this->input->post('document_score'),
					"document_possible_scr" => $this->input->post('document_possible_scr'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_rp/');
					$field_array['attach_file'] = implode(',',$a);
				}
				
				$this->db->where('id', $rp_id);
				$this->db->update('qa_vrs_rp_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $rp_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_rp_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rp_id);
					$this->db->update('qa_vrs_rp_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_vrs');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////// VRS (New) ///////////////////////////////	
	public function add_rp_new(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_rp_new.php";
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrMySqlDate(),
					//"audit_date" =>  mmddyy2mysql($this->input->post('audit_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"qa_type" => $this->input->post('qa_type'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"qa_type" => $this->input->post('qa_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"c_name" => $this->input->post('c_name'),
					"call_id" => $this->input->post('call_id'),
					"overall_score" => $this->input->post('overall_score'),
					"identifynameatbeginning" => $this->input->post('identifynameatbeginning'),
					"assurancetsatementverbatim" => $this->input->post('assurancetsatementverbatim'),
					"VRSwithnodeviation" => $this->input->post('VRSwithnodeviation'),
					"speakingtorightparty" => $this->input->post('speakingtorightparty'),
					"demographicsinformation" => $this->input->post('demographicsinformation'),
					"minimirandadisclosure" => $this->input->post('minimirandadisclosure'),
					"statetheclientname" => $this->input->post('statetheclientname'),
					"askforbalancedue" => $this->input->post('askforbalancedue'),
					"openingscore" => $this->input->post('openingscore'),
					"reasonfordelinquency" => $this->input->post('reasonfordelinquency'),
					"completeinformationtaken" => $this->input->post('completeinformationtaken'),
					"askforpaymentonphone" => $this->input->post('askforpaymentonphone'),
					"askforpostdelaypayment" => $this->input->post('askforpostdelaypayment'),
					"accountforfollowupcall" => $this->input->post('accountforfollowupcall'),
					"promisetopayaccount" => $this->input->post('promisetopayaccount'),
					"effortscore" => $this->input->post('effortscore'),
					"splitbalanceinpart" => $this->input->post('splitbalanceinpart'),
					"offersumsettlement" => $this->input->post('offersumsettlement'),
					"paymentplanwithpayment" => $this->input->post('paymentplanwithpayment'),
					"collectorfollowpropernegotiation" => $this->input->post('collectorfollowpropernegotiation'),
					"collectortrynegotiatepayment" => $this->input->post('collectortrynegotiatepayment'),
					"offergoodfaithpayment" => $this->input->post('offergoodfaithpayment'),
					"negotiationscore" => $this->input->post('negotiationscore'),
					"misrepresentidentity" => $this->input->post('misrepresentidentity'),
					"discussoflegalaction" => $this->input->post('discussoflegalaction'),
					"makeanyfalserepresentation" => $this->input->post('makeanyfalserepresentation'),
					"contactcustomerusualtime" => $this->input->post('contactcustomerusualtime'),
					"communicateconsumeratwork" => $this->input->post('communicateconsumeratwork'),
					"communicateconsumeranattorney" => $this->input->post('communicateconsumeranattorney'),
					"adheretocellphonepolicy" => $this->input->post('adheretocellphonepolicy'),
					"adhereto3rdpartypolicy" => $this->input->post('adhereto3rdpartypolicy'),
					"enterstatuscodecorrectly" => $this->input->post('enterstatuscodecorrectly'),
					"raiseUDAAPconcerns" => $this->input->post('raiseUDAAPconcerns'),
					"communicatefalsecreditinformation" => $this->input->post('communicatefalsecreditinformation'),
					"handleconsumerdispute" => $this->input->post('handleconsumerdispute'),
					"maketimebarredaccounts" => $this->input->post('maketimebarredaccounts'),
					"adhereFDCPAlaws" => $this->input->post('adhereFDCPAlaws'),
					"discriminatoryECOApolicy" => $this->input->post('discriminatoryECOApolicy'),
					"adherestaterestriction" => $this->input->post('adherestaterestriction'),
					"compliancescore" => $this->input->post('compliancescore'),
					"confirmauthoriseduser" => $this->input->post('confirmauthoriseduser'),
					"recapthecallverify" => $this->input->post('recapthecallverify'),
					"properpaymentscript" => $this->input->post('properpaymentscript'),
					"paymentprocessingfee" => $this->input->post('paymentprocessingfee'),
					"obtainpermissionfromconsumer" => $this->input->post('obtainpermissionfromconsumer'),
					"educatetheconsumer" => $this->input->post('educatetheconsumer'),
					"consumerconfirmationcode" => $this->input->post('consumerconfirmationcode'),
					"paymentscriptscore" => $this->input->post('paymentscriptscore'),
					"demonstrateactivelistening" => $this->input->post('demonstrateactivelistening'),
					"representclientandcompany" => $this->input->post('representclientandcompany'),
					"anticipateovercomeobjection" => $this->input->post('anticipateovercomeobjection'),
					"callcontrolscore" => $this->input->post('callcontrolscore'),
					"summarizethecall" => $this->input->post('summarizethecall'),
					"provideVRScallbacknumber" => $this->input->post('provideVRScallbacknumber'),
					"setappropiatetimeline" => $this->input->post('setappropiatetimeline'),
					"closecallprofessionally" => $this->input->post('closecallprofessionally'),
					"closingscore" => $this->input->post('closingscore'),
					"useproperactioncode" => $this->input->post('useproperactioncode'),
					"useproperresultcode" => $this->input->post('useproperresultcode'),
					"contextoftheconversation" => $this->input->post('contextoftheconversation'),
					"removeanyphonenumber" => $this->input->post('removeanyphonenumber'),
					"updateaddressinformation" => $this->input->post('updateaddressinformation'),
					"changestateofAccount" => $this->input->post('changestateofAccount'),
					"superviserforhandle" => $this->input->post('superviserforhandle'),
					"documentationscore" => $this->input->post('documentationscore'),
					"for_callback_permission" => $this->input->post('for_callback_permission'),
					"update_consumer_on_payment" => $this->input->post('update_consumer_on_payment'),
					"in_case_of_pdcs" => $this->input->post('in_case_of_pdcs'),
					"collector_ask_for_permission" => $this->input->post('collector_ask_for_permission'),
					"document_the_callback" => $this->input->post('document_the_callback'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_new/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_vrs_feedback',$field_array);
				redirect('Qa_vrs');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_vrs_rp_new($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/mgnt_vrs_rp_new.php";
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["vrs_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"qa_type" => $this->input->post('qa_type'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"qa_type" => $this->input->post('qa_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"c_name" => $this->input->post('c_name'),
					//"call_id" => $this->input->post('call_id'),
					"overall_score" => $this->input->post('overall_score'),
					"identifynameatbeginning" => $this->input->post('identifynameatbeginning'),
					"assurancetsatementverbatim" => $this->input->post('assurancetsatementverbatim'),
					"VRSwithnodeviation" => $this->input->post('VRSwithnodeviation'),
					"speakingtorightparty" => $this->input->post('speakingtorightparty'),
					"demographicsinformation" => $this->input->post('demographicsinformation'),
					"minimirandadisclosure" => $this->input->post('minimirandadisclosure'),
					"statetheclientname" => $this->input->post('statetheclientname'),
					"askforbalancedue" => $this->input->post('askforbalancedue'),
					"openingscore" => $this->input->post('openingscore'),
					"reasonfordelinquency" => $this->input->post('reasonfordelinquency'),
					"completeinformationtaken" => $this->input->post('completeinformationtaken'),
					"askforpaymentonphone" => $this->input->post('askforpaymentonphone'),
					"askforpostdelaypayment" => $this->input->post('askforpostdelaypayment'),
					"accountforfollowupcall" => $this->input->post('accountforfollowupcall'),
					"promisetopayaccount" => $this->input->post('promisetopayaccount'),
					"effortscore" => $this->input->post('effortscore'),
					"splitbalanceinpart" => $this->input->post('splitbalanceinpart'),
					"offersumsettlement" => $this->input->post('offersumsettlement'),
					"paymentplanwithpayment" => $this->input->post('paymentplanwithpayment'),
					"collectorfollowpropernegotiation" => $this->input->post('collectorfollowpropernegotiation'),
					"collectortrynegotiatepayment" => $this->input->post('collectortrynegotiatepayment'),
					"offergoodfaithpayment" => $this->input->post('offergoodfaithpayment'),
					"negotiationscore" => $this->input->post('negotiationscore'),
					"misrepresentidentity" => $this->input->post('misrepresentidentity'),
					"discussoflegalaction" => $this->input->post('discussoflegalaction'),
					"makeanyfalserepresentation" => $this->input->post('makeanyfalserepresentation'),
					"contactcustomerusualtime" => $this->input->post('contactcustomerusualtime'),
					"communicateconsumeratwork" => $this->input->post('communicateconsumeratwork'),
					"communicateconsumeranattorney" => $this->input->post('communicateconsumeranattorney'),
					"adheretocellphonepolicy" => $this->input->post('adheretocellphonepolicy'),
					"adhereto3rdpartypolicy" => $this->input->post('adhereto3rdpartypolicy'),
					"enterstatuscodecorrectly" => $this->input->post('enterstatuscodecorrectly'),
					"raiseUDAAPconcerns" => $this->input->post('raiseUDAAPconcerns'),
					"communicatefalsecreditinformation" => $this->input->post('communicatefalsecreditinformation'),
					"handleconsumerdispute" => $this->input->post('handleconsumerdispute'),
					"maketimebarredaccounts" => $this->input->post('maketimebarredaccounts'),
					"adhereFDCPAlaws" => $this->input->post('adhereFDCPAlaws'),
					"discriminatoryECOApolicy" => $this->input->post('discriminatoryECOApolicy'),
					"adherestaterestriction" => $this->input->post('adherestaterestriction'),
					"compliancescore" => $this->input->post('compliancescore'),
					"confirmauthoriseduser" => $this->input->post('confirmauthoriseduser'),
					"recapthecallverify" => $this->input->post('recapthecallverify'),
					"properpaymentscript" => $this->input->post('properpaymentscript'),
					"paymentprocessingfee" => $this->input->post('paymentprocessingfee'),
					"obtainpermissionfromconsumer" => $this->input->post('obtainpermissionfromconsumer'),
					"educatetheconsumer" => $this->input->post('educatetheconsumer'),
					"consumerconfirmationcode" => $this->input->post('consumerconfirmationcode'),
					"paymentscriptscore" => $this->input->post('paymentscriptscore'),
					"demonstrateactivelistening" => $this->input->post('demonstrateactivelistening'),
					"representclientandcompany" => $this->input->post('representclientandcompany'),
					"anticipateovercomeobjection" => $this->input->post('anticipateovercomeobjection'),
					"callcontrolscore" => $this->input->post('callcontrolscore'),
					"summarizethecall" => $this->input->post('summarizethecall'),
					"provideVRScallbacknumber" => $this->input->post('provideVRScallbacknumber'),
					"setappropiatetimeline" => $this->input->post('setappropiatetimeline'),
					"closecallprofessionally" => $this->input->post('closecallprofessionally'),
					"closingscore" => $this->input->post('closingscore'),
					"useproperactioncode" => $this->input->post('useproperactioncode'),
					"useproperresultcode" => $this->input->post('useproperresultcode'),
					"contextoftheconversation" => $this->input->post('contextoftheconversation'),
					"removeanyphonenumber" => $this->input->post('removeanyphonenumber'),
					"updateaddressinformation" => $this->input->post('updateaddressinformation'),
					"changestateofAccount" => $this->input->post('changestateofAccount'),
					"superviserforhandle" => $this->input->post('superviserforhandle'),
					"documentationscore" => $this->input->post('documentationscore'),
					"call_summary" => $this->input->post('call_summary'),

					"for_callback_permission" => $this->input->post('for_callback_permission'),
					"update_consumer_on_payment" => $this->input->post('update_consumer_on_payment'),
					"in_case_of_pdcs" => $this->input->post('in_case_of_pdcs'),
					"collector_ask_for_permission" => $this->input->post('collector_ask_for_permission'),
					"document_the_callback" => $this->input->post('document_the_callback'),
					
					"feedback" => $this->input->post('feedback')
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_new/');
					$field_array['attach_file'] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_vrs_feedback',$field_array);
			////////////	
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_vrs_feedback',$field_array1);
			///////////	
				redirect('Qa_vrs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
//////////////////////VRS RP Analysis Audit//////////////////////////////
	
	public function add_rpaudit_analysis_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_rpaudit_feedback_analysis.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'), 
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"opening_call" => $this->input->post('opening_call'),
					"opening_verbatim" => $this->input->post('opening_verbatim'),
					"opening_vrs" => $this->input->post('opening_vrs'),
					"opening_rightparty" => $this->input->post('opening_rightparty'),
					"opening_demographics" => $this->input->post('opening_demographics'),
					"opening_miranda" => $this->input->post('opening_miranda'),
					"opening_communication" => $this->input->post('opening_communication'),
					"opening_score" => $this->input->post('opening_score'),
					"opening_possible_scr" => $this->input->post('opening_possible_scr'),
					"effort_balance" => $this->input->post('effort_balance'),
					"effort_poe" => $this->input->post('effort_poe'),
					"effort_income" => $this->input->post('effort_income'),
					"effort_rent" => $this->input->post('effort_rent'),
					"effort_account" => $this->input->post('effort_account'),
					"effort_intension" => $this->input->post('effort_intension'),
					"effort_payment" => $this->input->post('effort_payment'),
					"effort_offer" => $this->input->post('effort_offer'),
					"effort_lump" => $this->input->post('effort_lump'),
					"effort_settlement" => $this->input->post('effort_settlement'),
					"effort_significant" => $this->input->post('effort_significant'),
					"effort_good" => $this->input->post('effort_good'),
					"effort_recoment" => $this->input->post('effort_recoment'),
					"effort_advise" => $this->input->post('effort_advise'),
					"effort_negotiate" => $this->input->post('effort_negotiate'),
					"effort_score" => $this->input->post('effort_score'),
					"effort_possible_scr" => $this->input->post('effort_possible_scr'),
					"callcontrol_demo" => $this->input->post('callcontrol_demo'),
					"callcontrol_anticipate" => $this->input->post('callcontrol_anticipate'),
					"callcontrol_question" => $this->input->post('callcontrol_question'),
					"callcontrol_establist" => $this->input->post('callcontrol_establist'),
					"callcontrol_timelines" => $this->input->post('callcontrol_timelines'),
					"callcontrol_task" => $this->input->post('callcontrol_task'),
					"callcontrol_company" => $this->input->post('callcontrol_company'),
					"callcontrol_escalate" => $this->input->post('callcontrol_escalate'),
					"callcontrol_score" => $this->input->post('callcontrol_score'),
					"callcontrol_possible_scr" => $this->input->post('callcontrol_possible_scr'),
					"compliance_mispresent" => $this->input->post('compliance_mispresent'),
					"compliance_threaten" => $this->input->post('compliance_threaten'),
					"compliance_account" => $this->input->post('compliance_account'),
					"compliance_faulse" => $this->input->post('compliance_faulse'),
					"compliance_contact" => $this->input->post('compliance_contact'),
					"compliance_communicate" => $this->input->post('compliance_communicate'),
					"compliance_consumer" => $this->input->post('compliance_consumer'),
					"compliance_policy" => $this->input->post('compliance_policy'),
					"compliance_location" => $this->input->post('compliance_location'),
					"compliance_dialer" => $this->input->post('compliance_dialer'),
					"compliance_unfair" => $this->input->post('compliance_unfair'),
					"compliance_credit" => $this->input->post('compliance_credit'),
					"compliance_disput" => $this->input->post('compliance_disput'),
					"compliance_obtain" => $this->input->post('compliance_obtain'),
					"compliance_imply" => $this->input->post('compliance_imply'),
					"compliance_legal" => $this->input->post('compliance_legal'),
					"compliance_barred" => $this->input->post('compliance_barred'),
					"compliance_fdcpa" => $this->input->post('compliance_fdcpa'),
					"compliance_consider" => $this->input->post('compliance_consider'),
					"compliance_collector" => $this->input->post('compliance_collector'),
					"compliance_score" => $this->input->post('compliance_score'),
					"compliance_possible_scr" => $this->input->post('compliance_possible_scr'),
					"closing_call" => $this->input->post('closing_call'),
					"closing_restate" => $this->input->post('closing_restate'),
					"closing_educate" => $this->input->post('closing_educate'),
					"closing_profession" => $this->input->post('closing_profession'),
					"closing_score" => $this->input->post('closing_score'),
					"closing_possible_scr" => $this->input->post('closing_possible_scr'),
					"document_action" => $this->input->post('document_action'),
					"document_result" => $this->input->post('document_result'),
					"document_context" => $this->input->post('document_context'),
					"document_remove" => $this->input->post('document_remove'),
					"document_update" => $this->input->post('document_update'),
					"document_change" => $this->input->post('document_change'),
					"document_escalate" => $this->input->post('document_escalate'),
					"document_score" => $this->input->post('document_score'),
					"document_possible_scr" => $this->input->post('document_possible_scr'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_rp_analysis/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_vrs_rp_analysis_feedback',$field_array);
				redirect('Qa_vrs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_vrs_rp_analysis_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/mgnt_vrs_rp_analysis_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["rpid"]=$id; 
			$a = array();
		
			$data["get_vrs_rp_analysis_feedback"] = $this->Qa_vrs_model->view_vrs_rp_analysis_feedback($id);
			
		///////Edit Part///////	
			if($this->input->post('rp_id'))
			{
				$rp_id=$this->input->post('rp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'), 
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"opening_call" => $this->input->post('opening_call'),
					"opening_verbatim" => $this->input->post('opening_verbatim'),
					"opening_vrs" => $this->input->post('opening_vrs'),
					"opening_rightparty" => $this->input->post('opening_rightparty'),
					"opening_demographics" => $this->input->post('opening_demographics'),
					"opening_miranda" => $this->input->post('opening_miranda'),
					"opening_communication" => $this->input->post('opening_communication'),
					"opening_score" => $this->input->post('opening_score'),
					"opening_possible_scr" => $this->input->post('opening_possible_scr'),
					"effort_balance" => $this->input->post('effort_balance'),
					"effort_poe" => $this->input->post('effort_poe'),
					"effort_income" => $this->input->post('effort_income'),
					"effort_rent" => $this->input->post('effort_rent'),
					"effort_account" => $this->input->post('effort_account'),
					"effort_intension" => $this->input->post('effort_intension'),
					"effort_payment" => $this->input->post('effort_payment'),
					"effort_offer" => $this->input->post('effort_offer'),
					"effort_lump" => $this->input->post('effort_lump'),
					"effort_settlement" => $this->input->post('effort_settlement'),
					"effort_significant" => $this->input->post('effort_significant'),
					"effort_good" => $this->input->post('effort_good'),
					"effort_recoment" => $this->input->post('effort_recoment'),
					"effort_advise" => $this->input->post('effort_advise'),
					"effort_negotiate" => $this->input->post('effort_negotiate'),
					"effort_score" => $this->input->post('effort_score'),
					"effort_possible_scr" => $this->input->post('effort_possible_scr'),
					"callcontrol_demo" => $this->input->post('callcontrol_demo'),
					"callcontrol_anticipate" => $this->input->post('callcontrol_anticipate'),
					"callcontrol_question" => $this->input->post('callcontrol_question'),
					"callcontrol_establist" => $this->input->post('callcontrol_establist'),
					"callcontrol_timelines" => $this->input->post('callcontrol_timelines'),
					"callcontrol_task" => $this->input->post('callcontrol_task'),
					"callcontrol_company" => $this->input->post('callcontrol_company'),
					"callcontrol_escalate" => $this->input->post('callcontrol_escalate'),
					"callcontrol_score" => $this->input->post('callcontrol_score'),
					"callcontrol_possible_scr" => $this->input->post('callcontrol_possible_scr'),
					"compliance_mispresent" => $this->input->post('compliance_mispresent'),
					"compliance_threaten" => $this->input->post('compliance_threaten'),
					"compliance_account" => $this->input->post('compliance_account'),
					"compliance_faulse" => $this->input->post('compliance_faulse'),
					"compliance_contact" => $this->input->post('compliance_contact'),
					"compliance_communicate" => $this->input->post('compliance_communicate'),
					"compliance_consumer" => $this->input->post('compliance_consumer'),
					"compliance_policy" => $this->input->post('compliance_policy'),
					"compliance_location" => $this->input->post('compliance_location'),
					"compliance_dialer" => $this->input->post('compliance_dialer'),
					"compliance_unfair" => $this->input->post('compliance_unfair'),
					"compliance_credit" => $this->input->post('compliance_credit'),
					"compliance_disput" => $this->input->post('compliance_disput'),
					"compliance_obtain" => $this->input->post('compliance_obtain'),
					"compliance_imply" => $this->input->post('compliance_imply'),
					"compliance_legal" => $this->input->post('compliance_legal'),
					"compliance_barred" => $this->input->post('compliance_barred'),
					"compliance_fdcpa" => $this->input->post('compliance_fdcpa'),
					"compliance_consider" => $this->input->post('compliance_consider'),
					"compliance_collector" => $this->input->post('compliance_collector'),
					"compliance_score" => $this->input->post('compliance_score'),
					"compliance_possible_scr" => $this->input->post('compliance_possible_scr'),
					"closing_call" => $this->input->post('closing_call'),
					"closing_restate" => $this->input->post('closing_restate'),
					"closing_educate" => $this->input->post('closing_educate'),
					"closing_profession" => $this->input->post('closing_profession'),
					"closing_score" => $this->input->post('closing_score'),
					"closing_possible_scr" => $this->input->post('closing_possible_scr'),
					"document_action" => $this->input->post('document_action'),
					"document_result" => $this->input->post('document_result'),
					"document_context" => $this->input->post('document_context'),
					"document_remove" => $this->input->post('document_remove'),
					"document_update" => $this->input->post('document_update'),
					"document_change" => $this->input->post('document_change'),
					"document_escalate" => $this->input->post('document_escalate'),
					"document_score" => $this->input->post('document_score'),
					"document_possible_scr" => $this->input->post('document_possible_scr'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"mgnt_rvw_note" => $this->input->post('note'),
					"mgnt_rvw_by" => $current_user,
					"mgnt_rvw_date" => $curDateTime
				);
				if($this->input->post('action') !=''){
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_rp_analysis/');
						$field_array['attach_file'] = implode(',',$a);
					}
					
					$this->db->where('id', $rp_id);
					$this->db->update('qa_vrs_rp_analysis_feedback',$field_array);
				}
				redirect('Qa_vrs');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
///////////////////VRS Left Message////////////////////////////
	
	public function add_lmaudit_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_lmaudit_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrMySqlDate(),
					//"audit_date" =>  mmddyy2mysql($this->input->post('audit_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"zortman_deviation" => $this->input->post('zortman_deviation'),
					"leave_message" => $this->input->post('leave_message'),
					"vrs_deviation" => $this->input->post('vrs_deviation'),
					"misprepresent_identity" => $this->input->post('misprepresent_identity'),
					"make_false" => $this->input->post('make_false'),
					"work_number" => $this->input->post('work_number'),
					"learning_attorney" => $this->input->post('learning_attorney'),
					"adhere_policy" => $this->input->post('adhere_policy'),
					"dialer_disposition" => $this->input->post('dialer_disposition'),
					"remove_number" => $this->input->post('remove_number'),
					"close_call" => $this->input->post('close_call'),
					"action_code" => $this->input->post('action_code'),
					"result_code" => $this->input->post('result_code'),
					"docu_account" => $this->input->post('docu_account'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_lm/');
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_vrs_lm_feedback',$field_array);
				redirect('Qa_vrs');
			}
			$data["array"] = $a;		
			$this->load->view("dashboard",$data);
		}
	}

	
	public function mgnt_vrs_lm_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/mgnt_vrs_lm_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);	
			
			$data["get_vrs_lm_feedback"] = $this->Qa_vrs_model->view_vrs_lm_feedback($id);
			
			$data["lmid"]=$id;
			$a = array();
			
			$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_lm_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_lm_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('lm_id'))
			{
				$lm_id=$this->input->post('lm_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"zortman_deviation" => $this->input->post('zortman_deviation'),
					"leave_message" => $this->input->post('leave_message'),
					"vrs_deviation" => $this->input->post('vrs_deviation'),
					"misprepresent_identity" => $this->input->post('misprepresent_identity'),
					"make_false" => $this->input->post('make_false'),
					"work_number" => $this->input->post('work_number'),
					"learning_attorney" => $this->input->post('learning_attorney'),
					"adhere_policy" => $this->input->post('adhere_policy'),
					"dialer_disposition" => $this->input->post('dialer_disposition'),
					"remove_number" => $this->input->post('remove_number'),
					"close_call" => $this->input->post('close_call'),
					"action_code" => $this->input->post('action_code'),
					"result_code" => $this->input->post('result_code'),
					"docu_account" => $this->input->post('docu_account'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_lm/');
					$field_array['attach_file'] = implode(',',$a);
				}
				
				$this->db->where('id', $lm_id);
				$this->db->update('qa_vrs_lm_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $lm_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_lm_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $lm_id);
					$this->db->update('qa_vrs_lm_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_vrs');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

/////////////////VRS Agent part//////////////////////////	

	public function agent_vrs_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_feedback.php";
			$data["content_js"] = "qa_vrs_2_js.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
			
			
			$qSql="Select count(id) as value from qa_vrs_rp_feedback where agent_id='$current_user'";
			$data["tot_agent_rp_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_vrs_rp_feedback where id  not in (select fd_id from qa_vrs_rp_agent_rvw) and agent_id='$current_user'";
			$data["tot_agent_rp_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		////////////
			
			$qSql="Select count(id) as value from qa_new_lm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_agent_lm_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_new_lm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["tot_agent_lm_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			////////////
			$qSql="Select count(id) as value from  	qa_vrs_cavalry_feedback where agent_id='$current_user'";
			$data["tot_agent_cav_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_vrs_cavalry_feedback where id  not in (select fd_id from qa_vrs_lm_agent_rvw) and agent_id='$current_user'";
			$data["tot_agent_cav_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		/////////////////
			$qSql="Select count(id) as value from qa_vrs_lm_feedback where agent_id='$current_user'";
			$data["tot_agent_jrpa_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_vrs_jrpa_feedback where id  not in (select fd_id from qa_vrs_jrpa_agent_rvw) and agent_id='$current_user'";
			$data["tot_agent_jrpa_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		///////////////
			$qSql="Select count(id) as value from qa_vrs_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_vrs_rp_new_fd"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_vrs_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_vrs_rp_new_fd"] =  $this->Common_model->get_single_value($qSql);
		////////////////
			$qSql="Select count(id) as value from qa_vrs_thirdparty_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_vrs_thirdparty"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_vrs_thirdparty_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_vrs_thirdparty"] =  $this->Common_model->get_single_value($qSql);

			////////////////////vikas//////////////////////////

			$qSql="Select count(id) as value from qa_vrs_right_party_v2_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["tot_feedback_vrs_right_party_v2"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_vrs_right_party_v2_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["yet_rvw_vrs_right_party_v2"] =  $this->Common_model->get_single_value($qSql);

			$from_date = '';
			$to_date = '';
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				$field_array = array(
					"from_date"=>$from_date,
					"to_date" => $to_date,
					"current_user" => $current_user
				);
				$data["agent_rp_review_list"] = $this->Qa_vrs_model->get_agent_rp_review_data($field_array);
				$data["agent_cav_review_list"] = $this->Qa_vrs_model->get_agent_cav_review_data($field_array);
				$data["agent_jrpa_review_list"] = $this->Qa_vrs_model->get_agent_jrpa_review_data($field_array);
			////////////////////	
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";

                //////////   
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_new_lm_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_lm_review_list"] = $this->Common_model->get_query_result_array($qSql);
			//////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_thirdparty_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["vrs_thirdparty"] = $this->Common_model->get_query_result_array($qSql);
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["vrs_new_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				//////////////vikas//////////////////////

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_right_party_v2_feedback $cond and agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["vrs_right_party_v2_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{	
				
				$data["agent_rp_review_list"] = $this->Qa_vrs_model->get_agent_not_rp_review_data($current_user);
				$data["agent_lm_review_list"] = $this->Qa_vrs_model->get_agent_not_lm_review_data($current_user);
				$data["agent_cav_review_list"] = $this->Qa_vrs_model->get_agent_not_cav_review_data($current_user); 
				$data["agent_jrpa_review_list"] = $this->Qa_vrs_model->get_agent_not_jrpa_review_data($current_user);
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_new_lm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";	
				$data["agent_lm_review_list"] = $this->Common_model->get_query_result_array($qSql);
			//////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["vrs_new_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
			////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_thirdparty_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["vrs_thirdparty"] = $this->Common_model->get_query_result_array($qSql);

				//////////////vikas/////////////////////	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_right_party_v2_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) ";
				//Where xx.agent_rvw_date is Null
				$data["vrs_right_party_v2_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}

	///////////////VRS RIGHT PARTY V2/////////////////////

	public function agent_vrs_right_party_v2_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_right_party_v2_feedback_rvw.php";
			$data["content_js"] = "qa_vrs_2_js.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
			$data["right_party_v2_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_vrs_right_party_v2_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["right_party_v2_data"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('right_party_v2_id'))
			{
				$right_party_v2_id=$this->input->post('right_party_v2_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $right_party_v2_id);
				$this->db->update('qa_vrs_right_party_v2_feedback',$field_array);
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
////////////////////VRS Right Party////////////////////////
	public function agent_vrs_rp_feedback_rvw($id){ //$form_id
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_rp_feedback_rvw.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
				
			$data["rpid"]=$id;		 
			 
				$data["get_vrs_rp_feedback"] = $this->Qa_vrs_model->view_vrs_rp_feedback($id);
				
				$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_rp_rvw($id);//AGENT PURPOSE
				$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_rp_rvw($id);//MGNT PURPOSE
			 
		
			if($this->input->post('rp_id'))
			{
				$rp_id=$this->input->post('rp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $rp_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
						$rowid= data_inserter('qa_vrs_rp_agent_rvw',$field_array1);
				}else{
						$this->db->where('fd_id', $rp_id);
						$this->db->update('qa_vrs_rp_agent_rvw',$field_array1);
				}	
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
////////////////////VRS Left Message////////////////////////

   public function agent_lm_vrs_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['lm_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_lm_vrs/agent_lm_vrs_feedback_rvw.php";
			$data["content_js"] = "qa_universal_js.php";
			$data["agentUrl"] = "Qa_vrs/agent_vrs_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_new_lm_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["lm_data"] = $this->Common_model->get_query_row_array($qSql);
			
		
			if($this->input->post('lm_id'))
			{
				$pnid=$this->input->post('lm_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_new_lm_feedback',$field_array1);
					
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}	
	public function agent_vrs_lm_feedback_rvw555($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_lm_feedback_rvw44.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
						
			
			$data["get_vrs_lm_feedback"] = $this->Qa_vrs_model->view_vrs_lm_feedback($id);
			
			$data["lmid"]=$id;
			
			$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_lm_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_lm_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('lm_id'))
			{
				$lm_id=$this->input->post('lm_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $lm_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_lm_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $lm_id);
					$this->db->update('qa_vrs_lm_agent_rvw',$field_array1);
				}	
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	////////////////////VRS Cavalry////////////////////////	
	public function agent_vrs_cav_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_cav_feedback_rvw.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
						
			
			$data["get_vrs_cav_feedback"] = $this->Qa_vrs_model->view_vrs_cav_feedback($id);
			
			$data["cav_id"]=$id;
			
			$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_cav_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_cav_rvw($id);//MGNT PURPOSE
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
			if($this->input->post('cav_id'))
			{
				$cav_id=$this->input->post('cav_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $cav_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_cavalry_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $cav_id);
					$this->db->update('qa_vrs_cavalry_agent_rvw',$field_array1);
				}	
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
/////////////// VRS (NEW) Agent Part ////////////////////	
	public function agent_vrs_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_new_rvw.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["vrs_new"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_vrs_feedback',$field_array1);
					
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
/////////////// VRS Third Party Agent Part ////////////////////	
	public function agent_vrs_thirdparty_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_thirdparty_rvw.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_thirdparty_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["vrs_thirdparty"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_vrs_thirdparty_feedback',$field_array1);
					
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	
//////////////////////////////////////////////////////////////////////////////
	// public function getTLname(){
	// 	if(check_logged_in()){
	// 		$aid=$this->input->post('aid');
	// 		$qSql = "Select id, assigned_to, office_id, fusion_id, get_process_names(id) as process_name, doj FROM signin where id = '$aid'";
	// 			//echo $qSql;
	// 		echo json_encode($this->Common_model->get_query_result_array($qSql));
	// 	}
	// }

	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name,doj, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA VRS REPORT //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_vrs_report(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["download_link1"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			/* $office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id; */
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_vrs/qa_vrs_report.php";
			
			
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$dn_link1="";
			$cond1='';
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			$data['pValue']=$pValue;
			$data["qa_vrs_list"] = array();
			$data["qa_vrs_cpta_data"] = array();
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				//$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond1= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
				
				$field_array = array(
					"date_from"=>$date_from,
					"date_to" => $date_to,
					//"office_id" => $office_id,
					"process_id" => $pValue,
					"current_user" => $current_user
				);
					
				if($pValue=='Right Party'){
					
					$fullAray = $this->Qa_vrs_model->qa_vrs_report_model($field_array);
					$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_rp_CSV($fullAray);
					$dn_link = base_url()."qa_vrs/download_qa_vrs_rp_CSV";
				
				}else if($pValue=='Left Message'){

				$fullAray = $this->Qa_vrs_model->qa_vrs_report_model($field_array);
				$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_lm_CSV($fullAray);	
					$dn_link = base_url()."qa_vrs/download_qa_vrs_lm_CSV";
				
				}else if($pValue=='Cavalry'){
					$fullAray = $this->Qa_vrs_model->qa_vrs_report_model($field_array);
					$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_cav_CSV($fullAray);	
					$dn_link = base_url()."qa_vrs/download_qa_vrs_cav_CSV";
				
				}else if($pValue=='CPTA'){
					$fullAray = $this->Qa_vrs_model->qa_vrs_report_model($field_array);
					$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_cpta_CSV($fullAray);	
					$dn_link = base_url()."qa_vrs/download_qa_vrs_cpta_CSV";
				///////////	
					$qSql="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_vrs_cpta_feedback $cond1) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_vrs_cpta_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) order by audit_date";
					$fullAray1 = $this->Common_model->get_query_result_array($qSql);
					$data["qa_vrs_cpta_data"] = $fullAray1;
					$this->create_qa_vrs_cptaAll_CSV($fullAray1);	
					$dn_link1 = base_url()."qa_vrs/download_qa_vrs_cptaAll_CSV";
					
				}else if($pValue=='JRPA'){
					$fullAray = $this->Qa_vrs_model->qa_vrs_report_model($field_array);
					$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_jrpa_CSV($fullAray);	
					$dn_link = base_url()."qa_vrs/download_qa_vrs_jrpa_CSV";
					
				}elseif($pValue=='Analysis'){
					$fullAray = $this->Qa_vrs_model->qa_vrs_report_model($field_array);
					$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_rp_anslysis_right_party_CSV($fullAray);	
					$dn_link = base_url()."qa_vrs/download_qa_vrs_rp_analysis_CSV";
				
				}elseif($pValue=='VRS New'){
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_new_CSV($fullAray);	
					$dn_link = base_url()."qa_vrs/download_qa_vrs_new_CSV";
				}elseif($pValue=='VRS Thirdparty'){
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_vrs_thirdparty_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_vrs_list"] = $fullAray;
					$this->create_qa_vrs_thirdparty_CSV($fullAray);	
					$dn_link = base_url()."qa_vrs/download_qa_vrs_thirdparty_CSV";
				}
			}
			
			$data['download_link']=$dn_link;
			$data['download_link1']=$dn_link1;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			//$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 
	
//////////////////Right Party///////////////////
	public function download_qa_vrs_rp_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS RP Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_rp_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Phone", "Contact Date", "Contact Duration", "VSI Account", "ACPT", "ACPT Option", "ACPT Others", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Identify himself/herself by first and last name at the beginning of the call?", "Provide the Quality Assurance Statement verbatim", "State Vital Recovery Services with no deviation?", "Verify that he/she was speaking to a right party according to the client requirements?", "Verify two pieces of demographics information on an outbound call", "Provide the Mini Miranda disclosure verbatim?", "State the client name and the purpose of the communication?", "Sate/Ask for balance due?", "Ask about consumers employment status and POE Information?", "Ask about income sources?", "Ask if the consumer rents or owns his/her home?", "Ask if the consumer a valid checking account or credit/debit card?", "Ask for a reason for delinquence/intention to resolve the account?", "Negotiate in order with discussion of each option?", "Offer a balance over time?", "Offer a one payment lump sum settlement appropriately?", "Offer a 3 to 12 month settlement appropriately?", "Offer a payment plan with significant down payment?", "Offer a small good faith payment?", "Recoment an urgency payment as the first payment option?", "Advise of the payment processing fee before the payment was taken", "Attempt to negotiate the first payment within 10 days?", "Demonstrate Active Listening?", "Anticipate and overcome objections?", "Ask open ended questions when appropriate?", "Establish a sence of urgency?", "Set appropriate timelines and expectations for follow up?", "Keep the call on task?", "Represent the company and the client in a positive manner?", "Escalate the call to a supervisor upon the first request of a consumer?", "Misrepresent their identity or authorization?", "Threaten to take actions that VRS or the client cannot legally take?", "Misrepresent the status of the consumers account?", "Make any faulse representations regarding the nature of the communication?", "Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumers location?", "Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?", "Communicate with the consumer after learning the consumer is represented by an attorney?", "Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell?", "Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?", "Enter dialer disposition codes correctly to ensure that inappropriate dialing does not take place?", "Make any statement that could constitute unfair?", "Communicate or threaten to communicate false credit information or information which should be known to be false?", "Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit?", "Obtain permission from the consumer to initiate electronic checking or credit /debit card transactions AND get supervisor verification if needed?", "Discuss or imply that any type of legal actions will be taken or property repossessed?", "Discuss legal action on time barred accounts?", "Make the required statement on time barred accounts", "Fully comply with any additional FDCPA requirements?", "Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?", "Did the collectors adhere to the State Restrictions?", "Summarize the call?", "Restate the payment arrangement to the consumer?", "Educate the consumer about correspondence being sent?", "Close the call Professionally?", "Use the proper action code?", "Use the proper result code?", "Document thoroughly the context of the conversation?", "Remove any phone numbers known to be incorrect?", "Update address information if appropriate?", "Change the status of the account if appropriate?", "Escalate the account to a supervisor for handling?", "Opening Score", "Opening Possible Score", "Effort Score", "Effort Possible Score", "Call Control Score", "Call Control Possible Score", "Compliance Score", "Compliance Possible Score", "Closing Score", "Closing Possible Score", "Document Score", "Document Possible Score", "Overall Score", "Point Earned", "Call Summary", "Feedback", "Audit Time", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['opening_call']==10) $opening_call='Yes';
			else if($user['opening_call']==-10) $opening_call='No';
			else $opening_call='N/A';
			
			if($user['opening_verbatim']==10) $opening_verbatim='Yes';
			else if($user['opening_verbatim']==-10) $opening_verbatim='No';
			else $opening_verbatim='N/A';
			
			if($user['opening_vrs']==10) $opening_vrs='Yes';
			else if($user['opening_vrs']==-10) $opening_vrs='No';
			else $opening_vrs='N/A';
			
			if($user['opening_rightparty']==10) $opening_rightparty='Yes';
			else if($user['opening_rightparty']==0) $opening_rightparty='No';
			else $opening_rightparty='N/A';
			
			if($user['opening_demographics']==10) $opening_demographics='Yes';
			else if($user['opening_demographics']==0) $opening_demographics='No';
			else $opening_demographics='N/A';
			
			if($user['opening_miranda']==10) $opening_miranda='Yes';
			else if($user['opening_miranda']==-10) $opening_miranda='No';
			else $opening_miranda='N/A';
			
			if($user['opening_communication']==10) $opening_communication='Yes';
			else if($user['opening_communication']==0) $opening_communication='No';
			else $opening_communication='N/A';
			
			if($user['effort_balance']==10) $effort_balance='Yes';
			else if($user['effort_balance']==0) $effort_balance='No';
			else $effort_balance='N/A';
			
			if($user['effort_poe']==10) $effort_poe='Yes';
			else if($user['effort_poe']==0) $effort_poe='No';
			else $effort_poe='N/A';
			
			if($user['effort_income']==10) $effort_income='Yes';
			else if($user['effort_income']==0) $effort_income='No';
			else $effort_income='N/A';
			
			if($user['effort_rent']==10) $effort_rent='Yes';
			else if($user['effort_rent']==0) $effort_rent='No';
			else $effort_rent='N/A';
			
			if($user['effort_account']==10) $effort_account='Yes';
			else if($user['effort_account']==0) $effort_account='No';
			else $effort_account='N/A';
			
			if($user['effort_intension']==10) $effort_intension='Yes';
			else if($user['effort_intension']==0) $effort_intension='No';
			else $effort_intension='N/A';
			
			if($user['effort_payment']==10) $effort_payment='Yes';
			else if($user['effort_payment']==0) $effort_payment='No';
			else $effort_payment='N/A';
			
			if($user['effort_offer']==10) $effort_offer='Yes';
			else if($user['effort_offer']==0) $effort_offer='No';
			else $effort_offer='N/A';
			
			if($user['effort_lump']==10) $effort_lump='Yes';
			else if($user['effort_lump']==0) $effort_lump='No';
			else $effort_lump='N/A';
			
			if($user['effort_settlement']==10) $effort_settlement='Yes';
			else if($user['effort_settlement']==0) $effort_settlement='No';
			else $effort_settlement='N/A';
			
			if($user['effort_significant']==10) $effort_significant='Yes';
			else if($user['effort_significant']==0) $effort_significant='No';
			else $effort_significant='N/A';
			
			if($user['effort_good']==10) $effort_good='Yes';
			else if($user['effort_good']==0) $effort_good='No';
			else $effort_good='N/A';
			
			if($user['effort_recoment']==10) $effort_recoment='Yes';
			else if($user['effort_recoment']==0) $effort_recoment='No';
			else $effort_recoment='N/A';
			
			if($user['effort_advise']==10) $effort_advise='Yes';
			else if($user['effort_advise']==-10) $effort_advise='No';
			else $effort_advise='N/A';
			
			if($user['effort_negotiate']==10) $effort_negotiate='Yes';
			else if($user['effort_negotiate']==0) $effort_negotiate='No';
			else $effort_negotiate='N/A';
			
			if($user['callcontrol_demo']==10) $callcontrol_demo='Yes';
			else if($user['callcontrol_demo']==0) $callcontrol_demo='No';
			else $callcontrol_demo='N/A';
			
			if($user['callcontrol_anticipate']==10) $callcontrol_anticipate='Yes';
			else if($user['callcontrol_anticipate']==0) $callcontrol_anticipate='No';
			else $callcontrol_anticipate='N/A';
			
			if($user['callcontrol_question']==10) $callcontrol_question='Yes';
			else if($user['callcontrol_question']==0) $callcontrol_question='No';
			else $callcontrol_question='N/A';
			
			if($user['callcontrol_establist']==10) $callcontrol_establist='Yes';
			else if($user['callcontrol_establist']==0) $callcontrol_establist='No';
			else $callcontrol_establist='N/A';
			
			if($user['callcontrol_timelines']==10) $callcontrol_timelines='Yes';
			else if($user['callcontrol_timelines']==0) $callcontrol_timelines='No';
			else $callcontrol_timelines='N/A';
			
			if($user['callcontrol_task']==10) $callcontrol_task='Yes';
			else if($user['callcontrol_task']==0) $callcontrol_task='No';
			else $callcontrol_task='N/A';
			
			if($user['callcontrol_company']==10) $callcontrol_company='Yes';
			else if($user['callcontrol_company']==0) $callcontrol_company='No';
			else $callcontrol_company='N/A';
			
			if($user['callcontrol_escalate']==10) $callcontrol_escalate='Yes';
			else if($user['callcontrol_escalate']==0) $callcontrol_escalate='No';
			else $callcontrol_escalate='N/A';
			
			if($user['compliance_mispresent']==10) $compliance_mispresent='No';
			else if($user['compliance_mispresent']==-10) $compliance_mispresent='Yes';
			else $compliance_mispresent='N/A';
			
			if($user['compliance_threaten']==10) $compliance_threaten='No';
			else if($user['compliance_threaten']==-10) $compliance_threaten='Yes';
			else $compliance_threaten='N/A';
			
			if($user['compliance_account']==10) $compliance_account='No';
			else if($user['compliance_account']==-10) $compliance_account='Yes';
			else $compliance_account='N/A';
			
			if($user['compliance_faulse']==10) $compliance_faulse='No';
			else if($user['compliance_faulse']==-10) $compliance_faulse='Yes';
			else $compliance_faulse='N/A';
			
			if($user['compliance_contact']==10) $compliance_contact='No';
			else if($user['compliance_contact']==-10) $compliance_contact='Yes';
			else $compliance_contact='N/A';
			
			if($user['compliance_communicate']==10) $compliance_communicate='No';
			else if($user['compliance_contact']==-10) $compliance_communicate='Yes';
			else $compliance_communicate='N/A';
			
			if($user['compliance_consumer']==10) $compliance_consumer='No';
			else if($user['compliance_consumer']==-10) $compliance_consumer='Yes';
			else $compliance_consumer='N/A';
			
			if($user['compliance_policy']==10) $compliance_policy='No';
			else if($user['compliance_policy']==-10) $compliance_policy='Yes';
			else $compliance_policy='N/A';
			
			if($user['compliance_location']==10) $compliance_location='No';
			else if($user['compliance_location']==-10) $compliance_location='Yes';
			else $compliance_location='N/A';
			
			if($user['compliance_dialer']==10) $compliance_dialer='No';
			else if($user['compliance_dialer']==-10) $compliance_dialer='Yes';
			else $compliance_dialer='N/A';
			
			if($user['compliance_unfair']==10) $compliance_unfair='Yes';
			else if($user['compliance_unfair']==-10) $compliance_unfair='No';
			else $compliance_unfair='N/A';
			
			if($user['compliance_credit']==10) $compliance_credit='No';
			else if($user['compliance_credit']==-10) $compliance_credit='Yes';
			else $compliance_credit='N/A';
			
			if($user['compliance_disput']==10) $compliance_disput='Yes';
			else if($user['compliance_disput']==-10) $compliance_disput='No';
			else $compliance_disput='N/A';
			
			if($user['compliance_obtain']==10) $compliance_obtain='Yes';
			else if($user['compliance_obtain']==-10) $compliance_obtain='No';
			else $compliance_obtain='N/A';
			
			if($user['compliance_imply']==10) $compliance_imply='Yes';
			else if($user['compliance_imply']==-10) $compliance_imply='No';
			else $compliance_imply='N/A';
			
			if($user['compliance_legal']==10) $compliance_legal='Yes';
			else if($user['compliance_legal']==-10) $compliance_legal='No';
			else $compliance_legal='N/A';
			
			if($user['compliance_barred']==10) $compliance_barred='Yes';
			else if($user['compliance_barred']==-10) $compliance_barred='No';
			else $compliance_barred='N/A';
			
			if($user['compliance_fdcpa']==10) $compliance_fdcpa='Yes';
			else if($user['compliance_fdcpa']==-10) $compliance_fdcpa='No';
			else $compliance_fdcpa='N/A';
			
			if($user['compliance_consider']==10) $compliance_consider='No';
			else if($user['compliance_consider']==-10) $compliance_consider='Yes';
			else $compliance_consider='N/A';
			
			if($user['compliance_collector']==10) $compliance_collector='Yes';
			else if($user['compliance_collector']==-10) $compliance_collector='No';
			else $compliance_collector='N/A';
			
			if($user['closing_call']==10) $closing_call='Yes';
			else if($user['closing_call']==0) $closing_call='No';
			else $closing_call='N/A';
			
			if($user['closing_restate']==10) $closing_restate='Yes';
			else if($user['closing_restate']==0) $closing_restate='No';
			else $closing_restate='N/A';
			
			if($user['closing_educate']==10) $closing_educate='Yes';
			else if($user['closing_educate']==0) $closing_educate='No';
			else $closing_educate='N/A';
			
			if($user['closing_profession']==10) $closing_profession='Yes';
			else if($user['closing_profession']==0) $closing_profession='No';
			else $closing_profession='N/A';
			
			if($user['document_action']==10) $document_action='Yes';
			else if($user['document_action']==-10) $document_action='No';
			else $document_action='N/A';
			
			if($user['document_result']==10) $document_result='Yes';
			else if($user['document_result']==-10) $document_result='No';
			else $document_result='N/A';
			
			if($user['document_context']==10) $document_context='Yes';
			else if($user['document_context']==0) $document_context='No';
			else $document_context='N/A';
			
			if($user['document_remove']==10) $document_remove='Yes';
			else if($user['document_remove']==-10) $document_remove='No';
			else $document_remove='N/A';
			
			if($user['document_update']==10) $document_update='Yes';
			else if($user['document_update']==-10) $document_update='No';
			else $document_update='N/A';
			
			if($user['document_change']==10) $document_change='Yes';
			else if($user['document_change']==-10) $document_change='No';
			else $document_change='N/A';
			
			if($user['document_escalate']==10) $document_escalate='Yes';
			else if($user['document_escalate']==0) $document_escalate='No';
			else $document_escalate='N/A';
			
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['contact_date'].'",';
			$row .= '"'.$user['contact_duration'].'",';
			$row .= '"'.$user['vsi_account'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['acpt_option'].'",';
			$row .= '"'.$user['acpt_other'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$opening_call.'",'; 
			$row .= '"'.$opening_verbatim.'",';
			$row .= '"'.$opening_vrs.'",';
			$row .= '"'.$opening_rightparty.'",';
			$row .= '"'.$opening_demographics.'",';
			$row .= '"'.$opening_miranda.'",';
			$row .= '"'.$opening_communication.'",';
			$row .= '"'.$effort_balance.'",';
			$row .= '"'.$effort_poe.'",';
			$row .= '"'.$effort_income.'",';
			$row .= '"'.$effort_rent.'",';
			$row .= '"'.$effort_account.'",';
			$row .= '"'.$effort_intension.'",';
			$row .= '"'.$effort_payment.'",';
			$row .= '"'.$effort_offer.'",';
			$row .= '"'.$effort_lump.'",';
			$row .= '"'.$effort_settlement.'",';
			$row .= '"'.$effort_significant.'",';
			$row .= '"'.$effort_good.'",';
			$row .= '"'.$effort_recoment.'",';
			$row .= '"'.$effort_advise.'",';
			$row .= '"'.$effort_negotiate.'",';
			$row .= '"'.$callcontrol_demo.'",';
			$row .= '"'.$callcontrol_anticipate.'",';
			$row .= '"'.$callcontrol_question.'",';
			$row .= '"'.$callcontrol_establist.'",';
			$row .= '"'.$callcontrol_timelines.'",';
			$row .= '"'.$callcontrol_task.'",';
			$row .= '"'.$callcontrol_company.'",';
			$row .= '"'.$callcontrol_escalate.'",';
			$row .= '"'.$compliance_mispresent.'",';
			$row .= '"'.$compliance_threaten.'",';
			$row .= '"'.$compliance_account.'",';
			$row .= '"'.$compliance_faulse.'",';
			$row .= '"'.$compliance_contact.'",';
			$row .= '"'.$compliance_communicate.'",';
			$row .= '"'.$compliance_consumer.'",';
			$row .= '"'.$compliance_policy.'",';
			$row .= '"'.$compliance_location.'",';
			$row .= '"'.$compliance_dialer.'",';
			$row .= '"'.$compliance_unfair.'",';
			$row .= '"'.$compliance_credit.'",';
			$row .= '"'.$compliance_disput.'",';
			$row .= '"'.$compliance_obtain.'",';
			$row .= '"'.$compliance_imply.'",';
			$row .= '"'.$compliance_legal.'",';
			$row .= '"'.$compliance_barred.'",';
			$row .= '"'.$compliance_fdcpa.'",';
			$row .= '"'.$compliance_consider.'",';
			$row .= '"'.$compliance_collector.'",';
			$row .= '"'.$closing_call.'",';
			$row .= '"'.$closing_restate.'",';
			$row .= '"'.$closing_educate.'",';
			$row .= '"'.$closing_profession.'",';
			$row .= '"'.$document_action.'",';
			$row .= '"'.$document_result.'",';
			$row .= '"'.$document_context.'",';
			$row .= '"'.$document_remove.'",';
			$row .= '"'.$document_update.'",';
			$row .= '"'.$document_change.'",';
			$row .= '"'.$document_escalate.'",';
			$row .= '"'.$user['opening_score'].'",';
			$row .= '"'.$user['opening_possible_scr'].'",';
			$row .= '"'.$user['effort_score'].'",';
			$row .= '"'.$user['effort_possible_scr'].'",';
			$row .= '"'.$user['callcontrol_score'].'",';
			$row .= '"'.$user['callcontrol_possible_scr'].'",';
			$row .= '"'.$user['compliance_score'].'",';
			$row .= '"'.$user['compliance_possible_scr'].'",';
			$row .= '"'.$user['closing_score'].'",';
			$row .= '"'.$user['closing_possible_scr'].'",';
			$row .= '"'.$user['document_score'].'",';
			$row .= '"'.$user['document_possible_scr'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['point_earned'].'",';
			
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['entry_time'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
/////////////////// VRS NEW /////////////////////
	public function download_qa_vrs_new_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS New Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Phone", "Fusion ID", "Agent Name", "L1 Super", "Client Name", "Contact Date", "Contact Duration", "VSI Account", "ACPT", "ACPT Option", "ACPT Others", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "QA Type", "Call ID", "Overall Score", "Identify himself/herself by first and last name at the beginning of the call?", "Provide the Quality Assurance Statement verbatim before any specific account information was discussed?", "State VRS with no deviation?", "Verify that he/she was speaking to a right party according to the client requirements?", "Verify one/two pieces of demographics information on an outbound call and one/two pieces on an inbound call?", "Provide the Mini Miranda disclosure verbatim before any specific account information was discussed?", "State the client name and the purpose of the communication?", "Sate/Ask for balance due?", "Ask for a reason for delinquency/intention to resolve the account?", "Full and Complete information taken?", "Ask for the payment over the phone?", "Ask for a post dated payment?", "Followed the previous conversations on the account for the follow-up call", "Able to take a promise to pay on the account?", "Offer to split the balance in part?", "Offer a one/three/lump sum settlement appropriately?", "Offer a payment plan with significant down payment?", "Did Collector follow proper negotiation sequence to provide settelment options?", "Did Collector try to negotiate effectively to convince the customer for payment?", "Offer a small good faith payment?", "Did not Misrepresent their identity or authorization and status of the consumers account?", "Did not Discuss or imply that any type of legal actions - will be taken or property repossessed?", "Did not Make any false representations regarding the nature of the communication?", "Did not Contact the consumer at any unusual times?", "Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?", "Did not Communicate with the consumer after learning the consumer is represented by an attorney?", "Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone email and fax?", "Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?", "Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?", "Did not Make any statement that could constitute unfair deceptive or abusive acts?", "Did not Communicate or threaten to communicate false credit information or information which should be known to be false?", "Handle the consumers dispute correctly and take appropriate action", "Did not Make the required statement on time barred accounts?", "Adhere to FDCPA laws?", "Did not Make any statement that could be considered discriminatory towards a consumer?", "Did the collectors adhere to the State Restrictions?", "Confirm with consumer if he/she is the authorized user of the debit or credit card/checking account?", "Recap the call by verifying consumers Name Address CC/AP information?", "Stated the proper payment script before processing payment?", "Advise of the payment processing fee before the payment was taken?", "Obtain permission from the consumer to initiate electronic credit /debit card transactions?", "Educate the consumer about correspondence being sent?", "Provide the consumer with the confirmation code?", "Demonstrate Active Listening?", "Represent the company and the client in a positive manner?", "Anticipate and overcome objections?", "Summarize the call?", "Provided VRS call back number?", "Set appropriate timelines and expectations for follow up?", "Close the call Professionally?", "Use the proper action code?", "Use the proper result code?", "Document thoroughly the context of the conversation?", "Remove any phone numbers known to be incorrect?", "Update address information if appropriate?", "Change the status of the account if appropriate?", "Escalate the account to a supervisor for handling if appropriate?", "Opening Score", "Effort Score", "Negotiation Score", "Compliance Score", "Payment Script Score", "Call Control Score", "Closing Score", "Documentation Score", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['c_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['vsi_account'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['acpt_option'].'",';
			$row .= '"'.$user['acpt_other'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['qa_type'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['identifynameatbeginning'].'",';
			$row .= '"'.$user['assurancetsatementverbatim'].'",';
			$row .= '"'.$user['VRSwithnodeviation'].'",';
			$row .= '"'.$user['speakingtorightparty'].'",';
			$row .= '"'.$user['demographicsinformation'].'",';
			$row .= '"'.$user['minimirandadisclosure'].'",';
			$row .= '"'.$user['statetheclientname'].'",';
			$row .= '"'.$user['askforbalancedue'].'",';
			$row .= '"'.$user['reasonfordelinquency'].'",';
			$row .= '"'.$user['completeinformationtaken'].'",';
			$row .= '"'.$user['askforpaymentonphone'].'",';
			$row .= '"'.$user['askforpostdelaypayment'].'",';
			$row .= '"'.$user['accountforfollowupcall'].'",';
			$row .= '"'.$user['promisetopayaccount'].'",';
			$row .= '"'.$user['splitbalanceinpart'].'",';
			$row .= '"'.$user['offersumsettlement'].'",';
			$row .= '"'.$user['paymentplanwithpayment'].'",';
			$row .= '"'.$user['collectorfollowpropernegotiation'].'",';
			$row .= '"'.$user['collectortrynegotiatepayment'].'",';
			$row .= '"'.$user['offergoodfaithpayment'].'",';
			$row .= '"'.$user['misrepresentidentity'].'",';
			$row .= '"'.$user['discussoflegalaction'].'",';
			$row .= '"'.$user['makeanyfalserepresentation'].'",';
			$row .= '"'.$user['contactcustomerusualtime'].'",';
			$row .= '"'.$user['communicateconsumeratwork'].'",';
			$row .= '"'.$user['communicateconsumeranattorney'].'",';
			$row .= '"'.$user['adheretocellphonepolicy'].'",';
			$row .= '"'.$user['adhereto3rdpartypolicy'].'",';
			$row .= '"'.$user['enterstatuscodecorrectly'].'",';
			$row .= '"'.$user['raiseUDAAPconcerns'].'",';
			$row .= '"'.$user['communicatefalsecreditinformation'].'",';
			$row .= '"'.$user['handleconsumerdispute'].'",';
			$row .= '"'.$user['maketimebarredaccounts'].'",';
			$row .= '"'.$user['adhereFDCPAlaws'].'",';
			$row .= '"'.$user['discriminatoryECOApolicy'].'",';
			$row .= '"'.$user['adherestaterestriction'].'",';
			$row .= '"'.$user['confirmauthoriseduser'].'",';
			$row .= '"'.$user['recapthecallverify'].'",';
			$row .= '"'.$user['properpaymentscript'].'",';
			$row .= '"'.$user['paymentprocessingfee'].'",';
			$row .= '"'.$user['obtainpermissionfromconsumer'].'",';
			$row .= '"'.$user['educatetheconsumer'].'",';
			$row .= '"'.$user['consumerconfirmationcode'].'",';
			$row .= '"'.$user['demonstrateactivelistening'].'",';
			$row .= '"'.$user['representclientandcompany'].'",';
			$row .= '"'.$user['anticipateovercomeobjection'].'",';
			$row .= '"'.$user['summarizethecall'].'",';
			$row .= '"'.$user['provideVRScallbacknumber'].'",';
			$row .= '"'.$user['setappropiatetimeline'].'",';
			$row .= '"'.$user['closecallprofessionally'].'",';
			$row .= '"'.$user['useproperactioncode'].'",';
			$row .= '"'.$user['useproperresultcode'].'",';
			$row .= '"'.$user['contextoftheconversation'].'",';
			$row .= '"'.$user['removeanyphonenumber'].'",';
			$row .= '"'.$user['updateaddressinformation'].'",';
			$row .= '"'.$user['changestateofAccount'].'",';
			$row .= '"'.$user['superviserforhandle'].'",';
			$row .= '"'.$user['openingscore'].'",';
			$row .= '"'.$user['effortscore'].'",';
			$row .= '"'.$user['negotiationscore'].'",';
			$row .= '"'.$user['compliancescore'].'",';
			$row .= '"'.$user['paymentscriptscore'].'",';
			$row .= '"'.$user['callcontrolscore'].'",';
			$row .= '"'.$user['closingscore'].'",';
			$row .= '"'.$user['documentationscore'].'",';
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

/////////////////// VRS Third Party /////////////////////
	public function download_qa_vrs_thirdparty_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS Third Party Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_thirdparty_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Phone", "Contact Date", "Contact Duration", "VSI Account", "QA Type", "Call ID", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the Collector identify themselves?", "Did the Quality Assurance Statement given on call?", "Did the Collector confirm that he/she is speaking with a Third Party?", "Did the Collector state Vital Recovery Services proactively on the call?", "Did the Collector provide any account related information to the Third Party or state on call regarding Consumer owes a Debt?", "Did the Collector confirm any location information", "Did the Collector Left Zortman Message with the Third Party?", "In case the Third Party wanted to make any payment did the collector disclose any account information?", "Did the collector follow payment processing script before processing the payment?", "Did the Collector make any statement that could constitute unfair?", "Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?", "Did not Contact the consumer at any unusual times?", "Did not discuss or imply that any type of legal actions will be taken also did not threaten to take actions that VRS or the client cannot legally take?", "Did not Misrepresent their identity or authorization as well as did not make any false representations?", "Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers?", "Adhere to FDCPA laws?", "Did not Make any statement that could be considered discriminatory towards a consumer?", "Did the collectors adhere to the State Restrictions?", "Did proper action code notated on the account?", "Did proper result code notated on the account?", "Did proper documentation done on the account?", "Did the Collector remove any phone numbers known to be incorrect?", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['vsi_account'].'",';
			$row .= '"'.$user['qa_type'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['collector_indentify_themselve'].'",';
			$row .= '"'.$user['quality_assurance_on_call'].'",';
			$row .= '"'.$user['collector_confirm_speaking_thirdparty'].'",';
			$row .= '"'.$user['collector_state_VRS_proactively'].'",';
			$row .= '"'.$user['collector_provide_account_info'].'",';
			$row .= '"'.$user['collector_confirm_location_info'].'",';
			$row .= '"'.$user['collector_left_zortman_message'].'",';
			$row .= '"'.$user['thirdparty_make_payment'].'",';
			$row .= '"'.$user['payment_made_on_account'].'",';
			$row .= '"'.$user['constitude_unfair_deceptive'].'",';
			$row .= '"'.$user['enter_state_code_correctly'].'",';
			$row .= '"'.$user['contact_customer_unusual_time'].'",';
			$row .= '"'.$user['discuss_legal_action'].'",';
			$row .= '"'.$user['misrepresent_identity'].'",';
			$row .= '"'.$user['adhere_cell_phone_policy'].'",';
			$row .= '"'.$user['adhere_FDCPA_law'].'",';
			$row .= '"'.$user['consider_customer_discriminatory'].'",';
			$row .= '"'.$user['adhere_state_restriction'].'",';
			$row .= '"'.$user['proper_action_code_noted'].'",';
			$row .= '"'.$user['proper_result_code_noted'].'",';
			$row .= '"'.$user['proper_documentation_done'].'",';
			$row .= '"'.$user['collector_remove_incorrect_number'].'",';
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


// VRS RP ANALYSIS RIGHT PARTY //////////////////////////////////////////////////////
	
	//////////////////Right Party///////////////////
	public function download_qa_vrs_rp_analysis_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS RP Analysis Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_rp_anslysis_right_party_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Phone", "Contact Date", "Contact Duration", "VSI Account", "ACPT", "ACPT Option", "ACPT Others", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Identify himself/herself by first and last name at the beginning of the call?", "Provide the Quality Assurance Statement verbatim", "State Vital Recovery Services with no deviation?", "Verify that he/she was speaking to a right party according to the client requirements?", "Verify two pieces of demographics information on an outbound call", "Provide the Mini Miranda disclosure verbatim?", "State the client name and the purpose of the communication?", "Sate/Ask for balance due?", "Ask about consumers employment status and POE Information?", "Ask about income sources?", "Ask if the consumer rents or owns his/her home?", "Ask if the consumer a valid checking account or credit/debit card?", "Ask for a reason for delinquence/intention to resolve the account?", "Negotiate in order with discussion of each option?", "Offer a balance over time?", "Offer a one payment lump sum settlement appropriately?", "Offer a 3 to 12 month settlement appropriately?", "Offer a payment plan with significant down payment?", "Offer a small good faith payment?", "Recoment an urgency payment as the first payment option?", "Advise of the payment processing fee before the payment was taken", "Attempt to negotiate the first payment within 10 days?", "Demonstrate Active Listening?", "Anticipate and overcome objections?", "Ask open ended questions when appropriate?", "Establish a sence of urgency?", "Set appropriate timelines and expectations for follow up?", "Keep the call on task?", "Represent the company and the client in a positive manner?", "Escalate the call to a supervisor upon the first request of a consumer?", "Misrepresent their identity or authorization?", "Threaten to take actions that VRS or the client cannot legally take?", "Misrepresent the status of the consumers account?", "Make any faulse representations regarding the nature of the communication?", "Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumers location?", "Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?", "Communicate with the consumer after learning the consumer is represented by an attorney?", "Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell?", "Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?", "Enter dialer disposition codes correctly to ensure that inappropriate dialing does not take place?", "Make any statement that could constitute unfair?", "Communicate or threaten to communicate false credit information or information which should be known to be false?", "Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit?", "Obtain permission from the consumer to initiate electronic checking or credit /debit card transactions AND get supervisor verification if needed?", "Discuss or imply that any type of legal actions will be taken or property repossessed?", "Discuss legal action on time barred accounts?", "Make the required statement on time barred accounts", "Fully comply with any additional FDCPA requirements?", "Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?", "Did the collectors adhere to the State Restrictions?", "Summarize the call?", "Restate the payment arrangement to the consumer?", "Educate the consumer about correspondence being sent?", "Close the call Professionally?", "Use the proper action code?", "Use the proper result code?", "Document thoroughly the context of the conversation?", "Remove any phone numbers known to be incorrect?", "Update address information if appropriate?", "Change the status of the account if appropriate?", "Escalate the account to a supervisor for handling?", "Opening Score", "Opening Possible Score", "Effort Score", "Effort Possible Score", "Call Control Score", "Call Control Possible Score", "Compliance Score", "Compliance Possible Score", "Closing Score", "Closing Possible Score", "Document Score", "Document Possible Score", "Overall Score", "Point Earned", "Call Summary", "Feedback", "Audit Time", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['opening_call']==10) $opening_call='Yes';
			else if($user['opening_call']==-10) $opening_call='No';
			else $opening_call='N/A';
			
			if($user['opening_verbatim']==10) $opening_verbatim='Yes';
			else if($user['opening_verbatim']==-10) $opening_verbatim='No';
			else $opening_verbatim='N/A';
			
			if($user['opening_vrs']==10) $opening_vrs='Yes';
			else if($user['opening_vrs']==-10) $opening_vrs='No';
			else $opening_vrs='N/A';
			
			if($user['opening_rightparty']==10) $opening_rightparty='Yes';
			else if($user['opening_rightparty']==0) $opening_rightparty='No';
			else $opening_rightparty='N/A';
			
			if($user['opening_demographics']==10) $opening_demographics='Yes';
			else if($user['opening_demographics']==0) $opening_demographics='No';
			else $opening_demographics='N/A';
			
			if($user['opening_miranda']==10) $opening_miranda='Yes';
			else if($user['opening_miranda']==-10) $opening_miranda='No';
			else $opening_miranda='N/A';
			
			if($user['opening_communication']==10) $opening_communication='Yes';
			else if($user['opening_communication']==0) $opening_communication='No';
			else $opening_communication='N/A';
			
			if($user['effort_balance']==10) $effort_balance='Yes';
			else if($user['effort_balance']==0) $effort_balance='No';
			else $effort_balance='N/A';
			
			if($user['effort_poe']==10) $effort_poe='Yes';
			else if($user['effort_poe']==0) $effort_poe='No';
			else $effort_poe='N/A';
			
			if($user['effort_income']==10) $effort_income='Yes';
			else if($user['effort_income']==0) $effort_income='No';
			else $effort_income='N/A';
			
			if($user['effort_rent']==10) $effort_rent='Yes';
			else if($user['effort_rent']==0) $effort_rent='No';
			else $effort_rent='N/A';
			
			if($user['effort_account']==10) $effort_account='Yes';
			else if($user['effort_account']==0) $effort_account='No';
			else $effort_account='N/A';
			
			if($user['effort_intension']==10) $effort_intension='Yes';
			else if($user['effort_intension']==0) $effort_intension='No';
			else $effort_intension='N/A';
			
			if($user['effort_payment']==10) $effort_payment='Yes';
			else if($user['effort_payment']==0) $effort_payment='No';
			else $effort_payment='N/A';
			
			if($user['effort_offer']==10) $effort_offer='Yes';
			else if($user['effort_offer']==0) $effort_offer='No';
			else $effort_offer='N/A';
			
			if($user['effort_lump']==10) $effort_lump='Yes';
			else if($user['effort_lump']==0) $effort_lump='No';
			else $effort_lump='N/A';
			
			if($user['effort_settlement']==10) $effort_settlement='Yes';
			else if($user['effort_settlement']==0) $effort_settlement='No';
			else $effort_settlement='N/A';
			
			if($user['effort_significant']==10) $effort_significant='Yes';
			else if($user['effort_significant']==0) $effort_significant='No';
			else $effort_significant='N/A';
			
			if($user['effort_good']==10) $effort_good='Yes';
			else if($user['effort_good']==0) $effort_good='No';
			else $effort_good='N/A';
			
			if($user['effort_recoment']==10) $effort_recoment='Yes';
			else if($user['effort_recoment']==0) $effort_recoment='No';
			else $effort_recoment='N/A';
			
			if($user['effort_advise']==10) $effort_advise='Yes';
			else if($user['effort_advise']==-10) $effort_advise='No';
			else $effort_advise='N/A';
			
			if($user['effort_negotiate']==10) $effort_negotiate='Yes';
			else if($user['effort_negotiate']==0) $effort_negotiate='No';
			else $effort_negotiate='N/A';
			
			if($user['callcontrol_demo']==10) $callcontrol_demo='Yes';
			else if($user['callcontrol_demo']==0) $callcontrol_demo='No';
			else $callcontrol_demo='N/A';
			
			if($user['callcontrol_anticipate']==10) $callcontrol_anticipate='Yes';
			else if($user['callcontrol_anticipate']==0) $callcontrol_anticipate='No';
			else $callcontrol_anticipate='N/A';
			
			if($user['callcontrol_question']==10) $callcontrol_question='Yes';
			else if($user['callcontrol_question']==0) $callcontrol_question='No';
			else $callcontrol_question='N/A';
			
			if($user['callcontrol_establist']==10) $callcontrol_establist='Yes';
			else if($user['callcontrol_establist']==0) $callcontrol_establist='No';
			else $callcontrol_establist='N/A';
			
			if($user['callcontrol_timelines']==10) $callcontrol_timelines='Yes';
			else if($user['callcontrol_timelines']==0) $callcontrol_timelines='No';
			else $callcontrol_timelines='N/A';
			
			if($user['callcontrol_task']==10) $callcontrol_task='Yes';
			else if($user['callcontrol_task']==0) $callcontrol_task='No';
			else $callcontrol_task='N/A';
			
			if($user['callcontrol_company']==10) $callcontrol_company='Yes';
			else if($user['callcontrol_company']==0) $callcontrol_company='No';
			else $callcontrol_company='N/A';
			
			if($user['callcontrol_escalate']==10) $callcontrol_escalate='Yes';
			else if($user['callcontrol_escalate']==0) $callcontrol_escalate='No';
			else $callcontrol_escalate='N/A';
			
			if($user['compliance_mispresent']==10) $compliance_mispresent='No';
			else if($user['compliance_mispresent']==-10) $compliance_mispresent='Yes';
			else $compliance_mispresent='N/A';
			
			if($user['compliance_threaten']==10) $compliance_threaten='No';
			else if($user['compliance_threaten']==-10) $compliance_threaten='Yes';
			else $compliance_threaten='N/A';
			
			if($user['compliance_account']==10) $compliance_account='No';
			else if($user['compliance_account']==-10) $compliance_account='Yes';
			else $compliance_account='N/A';
			
			if($user['compliance_faulse']==10) $compliance_faulse='No';
			else if($user['compliance_faulse']==-10) $compliance_faulse='Yes';
			else $compliance_faulse='N/A';
			
			if($user['compliance_contact']==10) $compliance_contact='No';
			else if($user['compliance_contact']==-10) $compliance_contact='Yes';
			else $compliance_contact='N/A';
			
			if($user['compliance_communicate']==10) $compliance_communicate='No';
			else if($user['compliance_contact']==-10) $compliance_communicate='Yes';
			else $compliance_communicate='N/A';
			
			if($user['compliance_consumer']==10) $compliance_consumer='No';
			else if($user['compliance_consumer']==-10) $compliance_consumer='Yes';
			else $compliance_consumer='N/A';
			
			if($user['compliance_policy']==10) $compliance_policy='No';
			else if($user['compliance_policy']==-10) $compliance_policy='Yes';
			else $compliance_policy='N/A';
			
			if($user['compliance_location']==10) $compliance_location='No';
			else if($user['compliance_location']==-10) $compliance_location='Yes';
			else $compliance_location='N/A';
			
			if($user['compliance_dialer']==10) $compliance_dialer='No';
			else if($user['compliance_dialer']==-10) $compliance_dialer='Yes';
			else $compliance_dialer='N/A';
			
			if($user['compliance_unfair']==10) $compliance_unfair='Yes';
			else if($user['compliance_unfair']==-10) $compliance_unfair='No';
			else $compliance_unfair='N/A';
			
			if($user['compliance_credit']==10) $compliance_credit='No';
			else if($user['compliance_credit']==-10) $compliance_credit='Yes';
			else $compliance_credit='N/A';
			
			if($user['compliance_disput']==10) $compliance_disput='Yes';
			else if($user['compliance_disput']==-10) $compliance_disput='No';
			else $compliance_disput='N/A';
			
			if($user['compliance_obtain']==10) $compliance_obtain='Yes';
			else if($user['compliance_obtain']==-10) $compliance_obtain='No';
			else $compliance_obtain='N/A';
			
			if($user['compliance_imply']==10) $compliance_imply='Yes';
			else if($user['compliance_imply']==-10) $compliance_imply='No';
			else $compliance_imply='N/A';
			
			if($user['compliance_legal']==10) $compliance_legal='Yes';
			else if($user['compliance_legal']==-10) $compliance_legal='No';
			else $compliance_legal='N/A';
			
			if($user['compliance_barred']==10) $compliance_barred='Yes';
			else if($user['compliance_barred']==-10) $compliance_barred='No';
			else $compliance_barred='N/A';
			
			if($user['compliance_fdcpa']==10) $compliance_fdcpa='Yes';
			else if($user['compliance_fdcpa']==-10) $compliance_fdcpa='No';
			else $compliance_fdcpa='N/A';
			
			if($user['compliance_consider']==10) $compliance_consider='No';
			else if($user['compliance_consider']==-10) $compliance_consider='Yes';
			else $compliance_consider='N/A';
			
			if($user['compliance_collector']==10) $compliance_collector='Yes';
			else if($user['compliance_collector']==-10) $compliance_collector='No';
			else $compliance_collector='N/A';
			
			if($user['closing_call']==10) $closing_call='Yes';
			else if($user['closing_call']==0) $closing_call='No';
			else $closing_call='N/A';
			
			if($user['closing_restate']==10) $closing_restate='Yes';
			else if($user['closing_restate']==0) $closing_restate='No';
			else $closing_restate='N/A';
			
			if($user['closing_educate']==10) $closing_educate='Yes';
			else if($user['closing_educate']==0) $closing_educate='No';
			else $closing_educate='N/A';
			
			if($user['closing_profession']==10) $closing_profession='Yes';
			else if($user['closing_profession']==0) $closing_profession='No';
			else $closing_profession='N/A';
			
			if($user['document_action']==10) $document_action='Yes';
			else if($user['document_action']==-10) $document_action='No';
			else $document_action='N/A';
			
			if($user['document_result']==10) $document_result='Yes';
			else if($user['document_result']==-10) $document_result='No';
			else $document_result='N/A';
			
			if($user['document_context']==10) $document_context='Yes';
			else if($user['document_context']==0) $document_context='No';
			else $document_context='N/A';
			
			if($user['document_remove']==10) $document_remove='Yes';
			else if($user['document_remove']==-10) $document_remove='No';
			else $document_remove='N/A';
			
			if($user['document_update']==10) $document_update='Yes';
			else if($user['document_update']==-10) $document_update='No';
			else $document_update='N/A';
			
			if($user['document_change']==10) $document_change='Yes';
			else if($user['document_change']==-10) $document_change='No';
			else $document_change='N/A';
			
			if($user['document_escalate']==10) $document_escalate='Yes';
			else if($user['document_escalate']==0) $document_escalate='No';
			else $document_escalate='N/A';
			
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['contact_date'].'",';
			$row .= '"'.$user['contact_duration'].'",';
			$row .= '"'.$user['vsi_account'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['acpt_option'].'",';
			$row .= '"'.$user['acpt_other'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$opening_call.'",'; 
			$row .= '"'.$opening_verbatim.'",';
			$row .= '"'.$opening_vrs.'",';
			$row .= '"'.$opening_rightparty.'",';
			$row .= '"'.$opening_demographics.'",';
			$row .= '"'.$opening_miranda.'",';
			$row .= '"'.$opening_communication.'",';
			$row .= '"'.$effort_balance.'",';
			$row .= '"'.$effort_poe.'",';
			$row .= '"'.$effort_income.'",';
			$row .= '"'.$effort_rent.'",';
			$row .= '"'.$effort_account.'",';
			$row .= '"'.$effort_intension.'",';
			$row .= '"'.$effort_payment.'",';
			$row .= '"'.$effort_offer.'",';
			$row .= '"'.$effort_lump.'",';
			$row .= '"'.$effort_settlement.'",';
			$row .= '"'.$effort_significant.'",';
			$row .= '"'.$effort_good.'",';
			$row .= '"'.$effort_recoment.'",';
			$row .= '"'.$effort_advise.'",';
			$row .= '"'.$effort_negotiate.'",';
			$row .= '"'.$callcontrol_demo.'",';
			$row .= '"'.$callcontrol_anticipate.'",';
			$row .= '"'.$callcontrol_question.'",';
			$row .= '"'.$callcontrol_establist.'",';
			$row .= '"'.$callcontrol_timelines.'",';
			$row .= '"'.$callcontrol_task.'",';
			$row .= '"'.$callcontrol_company.'",';
			$row .= '"'.$callcontrol_escalate.'",';
			$row .= '"'.$compliance_mispresent.'",';
			$row .= '"'.$compliance_threaten.'",';
			$row .= '"'.$compliance_account.'",';
			$row .= '"'.$compliance_faulse.'",';
			$row .= '"'.$compliance_contact.'",';
			$row .= '"'.$compliance_communicate.'",';
			$row .= '"'.$compliance_consumer.'",';
			$row .= '"'.$compliance_policy.'",';
			$row .= '"'.$compliance_location.'",';
			$row .= '"'.$compliance_dialer.'",';
			$row .= '"'.$compliance_unfair.'",';
			$row .= '"'.$compliance_credit.'",';
			$row .= '"'.$compliance_disput.'",';
			$row .= '"'.$compliance_obtain.'",';
			$row .= '"'.$compliance_imply.'",';
			$row .= '"'.$compliance_legal.'",';
			$row .= '"'.$compliance_barred.'",';
			$row .= '"'.$compliance_fdcpa.'",';
			$row .= '"'.$compliance_consider.'",';
			$row .= '"'.$compliance_collector.'",';
			$row .= '"'.$closing_call.'",';
			$row .= '"'.$closing_restate.'",';
			$row .= '"'.$closing_educate.'",';
			$row .= '"'.$closing_profession.'",';
			$row .= '"'.$document_action.'",';
			$row .= '"'.$document_result.'",';
			$row .= '"'.$document_context.'",';
			$row .= '"'.$document_remove.'",';
			$row .= '"'.$document_update.'",';
			$row .= '"'.$document_change.'",';
			$row .= '"'.$document_escalate.'",';
			$row .= '"'.$user['opening_score'].'",';
			$row .= '"'.$user['opening_possible_scr'].'",';
			$row .= '"'.$user['effort_score'].'",';
			$row .= '"'.$user['effort_possible_scr'].'",';
			$row .= '"'.$user['callcontrol_score'].'",';
			$row .= '"'.$user['callcontrol_possible_scr'].'",';
			$row .= '"'.$user['compliance_score'].'",';
			$row .= '"'.$user['compliance_possible_scr'].'",';
			$row .= '"'.$user['closing_score'].'",';
			$row .= '"'.$user['closing_possible_scr'].'",';
			$row .= '"'.$user['document_score'].'",';
			$row .= '"'.$user['document_possible_scr'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['point_earned'].'",';
			
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['entry_date'].'",'; 
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
//////////////////VRS Left Message///////////////////
	public function download_qa_vrs_lm_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS LM Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_lm_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Contact Date", "Contact Duration", "Client Name", "Phone", "VRS Account", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Overall Score", "Did the collector greet and open the call properly?", "Did the collector state his/her full name (first and last name) on the call?", "Did the collector state Vital recovery Services LLC with no deviation?", "Did the collector state the time [Eastern Time] of the call correctly?", "Did the collector state the date of the call correctly? ", "Did the collector state any of our customer service representatives correctly?", "Did the collector provided the call back number of the Consumer? ", "Did the collector advise of the office working hours as per eastern time correctly? ", "Did the collector left message with a Third Party?", "Did the collector left message at the POE of Consumer? ", "Did the collector Leave Message if voicemail has someone else name in it?", "Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place? ", "Did collector use the proper Action Code? ","Did collector use the proper Result Code? ", "Did Collector document the account thoroughly?", "Call Summary", "Feedback", "Agent Review Date", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['client'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['vrs_account'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['open_the_call_properly'].'",';
			$row .= '"'.$user['her_full_name'].'",';
			$row .= '"'.$user['vital_recovery_services'].'",';
			$row .= '"'.$user['the_call_correctly'].'",';
			$row .= '"'.$user['date_the_call_correctly'].'",';
			$row .= '"'.$user['customer_service_representatives'].'",';
			$row .= '"'.$user['all_back_number_of'].'",';
			$row .= '"'.$user['working_hours_as_per'].'",';
			$row .= '"'.$user['left_message_with'].'",';
			$row .= '"'.$user['the_poe_of_consumer'].'",';
			$row .= '"'.$user['voicemail_has_someone'].'",';
			$row .= '"'.$user['inappropriate_dialing'].'",';
			$row .= '"'.$user['proper_action_code'].'",';
			$row .= '"'.$user['proper_result_code'].'",';
			$row .= '"'.$user['account_thoroughly'].'",'; 
			
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
//////////////////VRS Cavalry///////////////////////////////////////////
	public function download_qa_vrs_cav_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS Cavalry Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_cav_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Call Date", "Call Length", "ACPT", "ACPT Option", "ACPT Others", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Point Earned", "Customer Service / Treated customer with courtesy and respect","Avoided third party disclosure/ properly verified identity","Gave all required disclosures effectively","Followed state or local requirements","Commented account according to call","Avoided making misleading or deceptive statements","Avoided improper credit report discussion","Avoided improper 3rd party communication","Avoided not honoring dispute or attorney representation","Avoided improper legal talk off or legal threats","Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['customer_service_with_respect']==10) $customer_service_with_respect='Yes';
			else if($user['customer_service_with_respect']==0) $customer_service_with_respect='No';
			else $customer_service_with_respect='N/A';
			if($user['avoided_third_party_disclosure']==10) $avoided_third_party_disclosure='Yes';
			else if($user['avoided_third_party_disclosure']==0) $avoided_third_party_disclosure='No';
			else $avoided_third_party_disclosure='N/A';
			if($user['gave_all_required_disclosures']==10) $gave_all_required_disclosures='Yes';
			else if($user['gave_all_required_disclosures']==0) $gave_all_required_disclosures='No';
			else $gave_all_required_disclosures='N/A';
			if($user['followed_local_requirement']==10) $followed_local_requirement='Yes';
			else if($user['followed_local_requirement']==0) $followed_local_requirement='No';
			else $followed_local_requirement='N/A';
			if($user['commented_account']==10) $commented_account='Yes';
			else if($user['commented_account']==0) $commented_account='No';
			else $commented_account='N/A';
			if($user['avoided_making_misleading']==10) $avoided_making_misleading='Yes';
			else if($user['avoided_making_misleading']==0) $avoided_making_misleading='No';
			else $avoided_making_misleading='N/A';
			if($user['avoided_improper_credit']==10) $avoided_improper_credit='Yes';
			else if($user['avoided_improper_credit']==0) $avoided_improper_credit='No';
			else $avoided_improper_credit='N/A';
			if($user['avoided_improper_3rd_party']==10) $avoided_improper_3rd_party='Yes';
			else if($user['avoided_improper_3rd_party']==0) $avoided_improper_3rd_party='No';
			else $avoided_improper_3rd_party='N/A';
			if($user['avoided_not_honoring']==10) $avoided_not_honoring='Yes';
			else if($user['avoided_not_honoring']==0) $avoided_not_honoring='No';
			else $avoided_not_honoring='N/A';
			if($user['avoided_improper_legal_talk']==10) $avoided_improper_legal_talk='Yes';
			else if($user['avoided_improper_legal_talk']==0) $avoided_improper_legal_talk='No';
			else $avoided_improper_legal_talk='N/A';
			
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_length'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['acpt_option'].'",';
			$row .= '"'.$user['acpt_other'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'.$user['point_earned'].'",'; 
			$row .= '"'.$customer_service_with_respect.'",'; 
			$row .= '"'.$avoided_third_party_disclosure.'",'; 
			$row .= '"'.$gave_all_required_disclosures.'",'; 
			$row .= '"'.$followed_local_requirement.'",'; 
			$row .= '"'.$commented_account.'",'; 
			$row .= '"'.$avoided_making_misleading.'",'; 
			$row .= '"'.$avoided_improper_credit.'",'; 
			$row .= '"'.$avoided_improper_3rd_party.'",'; 
			$row .= '"'.$avoided_not_honoring.'",'; 
			$row .= '"'.$avoided_improper_legal_talk.'",'; 
			
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
			$row = "";
		}
		
		fclose($fopen);
	}
	
//////////////////////VRS CPTA//////////////////////////////////////////
	public function download_qa_vrs_cpta_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS CPTA Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_cpta_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Audit Date", "Agent Audited", "Total Audit", "No. of Connect", "No. of Transfer", "Right Party Contact", "No of Correct Verbatim Given", "% of Correct Verbatim", "No of Incorrect Verbatim Given", "% of Incorrect Verbatim", "No. of Correct Transfer", "No. of Incorrect Transfer", "No. of Warm Transfer", "% of Warm Transfer", "No. of Cold Transfer", "% of Cold Transfer");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$correctVerbatim=round(($user['correct_verbatim'] / $user['total_audit']) * 100, 2);
			$incorrectVerbatim=round(($user['incorrect_verbatim'] / $user['total_audit']) * 100, 2);
			$warmTransfer=round(($user['warm_transfer'] / $user['total_audit']) * 100, 2);
			$coldTransfer=round(($user['cold_transfer'] / $user['total_audit']) * 100, 2);
			
			$row = '"'.$user['audit_date'].'",';
			$row .= '"'.$user['agent_audited'].'",'; 
			$row .= '"'.$user['total_audit'].'",'; 
			$row .= '"'.$user['no_connect'].'",'; 
			$row .= '"'.$user['no_transfer'].'",'; 
			$row .= '"'.$user['rp_contact'].'",'; 
			$row .= '"'.$user['correct_verbatim'].'",'; 
			$row .= '"'.$correctVerbatim.'%'.'",';
			$row .= '"'.$user['incorrect_verbatim'].'",';
			$row .= '"'.$incorrectVerbatim.'%'.'",';
			$row .= '"'.$user['correct_transfer'].'",';
			$row .= '"'.$user['incorrect_transfer'].'",';
			$row .= '"'.$user['warm_transfer'].'",';
			$row .= '"'.$warmTransfer.'%'.'",';
			$row .= '"'.$user['cold_transfer'].'",';
			$row .= '"'.$coldTransfer.'%'.'"';
			
			fwrite($fopen,$row."\r\n");
			$row = "";
		}
		
		fclose($fopen);
	}
	
//////////////////////VRS CPTA ALL Data//////////////////////////////////////////
	public function download_qa_vrs_cptaAll_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS CPTA All Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_cptaAll_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Audit Date", "Auditor Name", "Agent", "L1Super", "Call Date", "Customer Name", "Phone", "Call Duration", "Connect Type", "Correct Verbatim Given", "Correct/Incorrect Transfer", "Transfer Type", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "QA Note");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['audit_date'].'",';
			$row .= '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['customer'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['connect_type'].'",';
			$row .= '"'.$user['verbatim'].'",';
			$row .= '"'.$user['transfer'].'",';
			$row .= '"'.$user['transfer_type'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['qa_comment'].'",';
			
			fwrite($fopen,$row."\r\n");
			$row = "";
		}
		
		fclose($fopen);
	}
	
//////////////////JRPA Right Party///////////////////
	public function download_qa_vrs_jrpa_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA VRS JRPA Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vrs_jrpa_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Phone", "Contact Date", "Contact Duration", "VSI Account", "ACPT", "ACPT Option", "ACPT Others", "Call Type", "Can be Automated", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Identify himself/herself by first and last name at the beginning of the call?","Provide the Quality Assurance Statement verbatim before any specific account information was discussed?","State Vital Recovery Services with no deviation?","Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures?","Verify two pieces of demographics information on an outbound call and two pieces on an inbound call? 1) must abide by client requirements and 2) Consumer must provide information unless there is a resistance. 3)Must be completed before disclosures.","Provide the Mini Miranda disclosure verbatim before any specific account information was discussed?","State the client name and the purpose of the communication?","Sate/Ask for balance due?","Ask for a reason for delinquency/intention to resolve the account?","Full and Complete information taken?","Ask for the payment over the phone?","Ask for a post dated payment?","Able to take a promise to pay on the account?","Offer to split the balance in part?", "Offer a one/three/monthly payment lump sum settlement appropriately?", "Offer a payment plan with significant down payment?", "Offer a small good faith payment?","Did not  Misrepresent their identity or authorization?","Did not Threaten to take actions that VRS or the client cannot legally take?","Did not Misrepresent the status of the consumer's account?","Did not Make any faulse representations regarding the nature of the communication?","Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumer's location?","Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?","Did not Communicate with the consumer after learning the consumer is represented by an attorney unless a permissible reason exists?","Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone email and fax?","Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?","Enter dialer disposition codes correctly to ensure that inappropriate dialing does not take place?","Did not Make any statement that could constitute unfair deceptive or abusive acts or practices that may raise UDAAP concerns?","Did not Communicate or threaten to communicate false credit information or information which should be known to be false?","Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint or offer to escalate the call?","Did not Discuss or imply that any type of legal actions will be taken or property repossessed?","Did not Discuss legal action on time barred accounts?","Did not Make the required statement on time barred accounts indicating that the consumer cannot be pursued with legal action?","Adhere to FDCPA  laws?","Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?","Did the collectors adhere to the State Restrictions?","Recap the call by verifying Name Address CC/AP information?", "Followed the proper authorization script before processing payment?", "Advise of the payment processing fee before the payment was taken and take appropriate steps if the consumer pushed back?", "Educate the consumer about correspondence being sent (Receipts PIF SIF Confirmations etc)?", "Provide the consumer with the confirmation code?","Demonstrate Active Listening?","Anticipate and overcome objections?","Summarize the call?","Provided VRS call back number?", "Set appropriate timelines and expectations for follow up?","Close the call Professionally?", "Use the proper action code?","Use the proper result code?","Document thoroughly the context of the conversation?", "Remove any phone numbers known to be incorrect?","Update address information if appropriate?","Change the status of the account if appropriate?" , "Escalate the account to a supervisor for handling if appropriate?/ Escalate the account to a supervisor for handling if appropriate?", "Opening Score", "Opening Possible Score", "Effort Score", "Effort Possible Score", "Negotiation Score", "Negotiation Possible Score", "Compliance Score", "Compliance Possible Score", "Payment Script Score" , "Payment Script Possible" , "Call Control Score", "Call Control Possible Score", "Closing Score", "Closing Possible Score", "Document Score", "Document Possible Score", "Overall Score", "Point Earned", "Call Summary", "Feedback", "Audit Time", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['opening_call']==1.25) $opening_call='Yes';
			else if($user['opening_call']==0) $opening_call='No';
			else $opening_call='N/A';
			
			if($user['opening_verbatim']==1.25) $opening_verbatim='Yes';
			else if($user['opening_verbatim']==0) $opening_verbatim='No';
			else $opening_verbatim='N/A';
			
			if($user['opening_vrs']==1.25) $opening_vrs='Yes';
			else if($user['opening_vrs']==0) $opening_vrs='No';
			else $opening_vrs='N/A';
			
			if($user['opening_rightparty']==1.25) $opening_rightparty='Yes';
			else if($user['opening_rightparty']==0) $opening_rightparty='No';
			else $opening_rightparty='N/A';
			
			if($user['opening_demographics']==1.25) $opening_demographics='Yes';
			else if($user['opening_demographics']==0) $opening_demographics='No';
			else $opening_demographics='N/A';
			
			if($user['opening_miranda']==1.25) $opening_miranda='Yes';
			else if($user['opening_miranda']==0) $opening_miranda='No';
			else $opening_miranda='N/A';
			
			if($user['opening_communication']==1.25) $opening_communication='Yes';
			else if($user['opening_communication']==0) $opening_communication='No';
			else $opening_communication='N/A';
			
			if($user['opening_balance_due']==1.25) $opening_balance_due='Yes';
			else if($user['opening_balance_due']==0) $opening_balance_due='No';
			else $opening_balance_due='N/A';
			
			if($user['effort_delinquency']==5) $effort_delinquency='Yes';
			else if($user['effort_delinquency']==0) $effort_delinquency='No';
			else $effort_delinquency='N/A';
			
			if($user['effort_complete_information']==5) $effort_complete_information='Yes';
			else if($user['effort_complete_information']==0) $effort_complete_information='No';
			else $effort_complete_information='N/A';
			
			if($user['effort_payment_over_phone']==5) $effort_payment_over_phone='Yes';
			else if($user['effort_payment_over_phone']==0) $effort_payment_over_phone='No';
			else $effort_payment_over_phone='N/A';
			
			if($user['effort_post_dated_payment']==5) $effort_post_dated_payment='Yes';
			else if($user['effort_post_dated_payment']==0) $effort_post_dated_payment='No';
			else $effort_post_dated_payment='N/A';
			
			if($user['effort_promise_to_pay']==5) $effort_promise_to_pay='Yes';
			else if($user['effort_promise_to_pay']==0) $effort_promise_to_pay='No';
			else $effort_promise_to_pay='N/A';
 
			if($user['negotiation_split_balance']==5) $negotiation_split_balance='Yes';
			else if($user['negotiation_split_balance']==0) $negotiation_split_balance='No';
			else $negotiation_split_balance='N/A';
			
			if($user['negotiation_monthly_payment']==5) $negotiation_monthly_payment='Yes';
			else if($user['negotiation_monthly_payment']==0) $negotiation_monthly_payment='No';
			else $negotiation_monthly_payment='N/A';
			
			if($user['negotiation_payment_plan']==5) $negotiation_payment_plan='Yes';
			else if($user['negotiation_payment_plan']==0) $negotiation_payment_plan='No';
			else $negotiation_payment_plan='N/A';
			
			if($user['negotiation_faith_payment']==5) $negotiation_faith_payment='Yes';
			else if($user['negotiation_faith_payment']==0) $negotiation_faith_payment='No';
			else $negotiation_faith_payment='N/A';
			
 
			if($user['compliance_mispresent']==0.52) $compliance_mispresent='Yes';
			else if($user['compliance_mispresent']==0) $compliance_mispresent='No';
			else $compliance_mispresent='N/A';
			
			if($user['compliance_threaten']==0.52) $compliance_threaten='Yes';
			else if($user['compliance_threaten']==0) $compliance_threaten='No';
			else $compliance_threaten='N/A';
			
			if($user['compliance_faulse']==0.52) $compliance_faulse='Yes';
			else if($user['compliance_faulse']==0) $compliance_faulse='No';
			else $compliance_faulse='N/A';
			
			if($user['compliance_account']==0.52) $compliance_account='Yes';
			else if($user['compliance_account']==0) $compliance_account='No';
			else $compliance_account='N/A';
			 
			if($user['compliance_contact']==0.52) $compliance_contact='Yes';
			else if($user['compliance_contact']==0) $compliance_contact='No';
			else $compliance_contact='N/A';
			
			if($user['compliance_communicate']==0.52) $compliance_communicate='Yes';
			else if($user['compliance_contact']==0) $compliance_communicate='No';
			else $compliance_communicate='N/A';
			
			if($user['compliance_consumer']==0.52) $compliance_consumer='Yes';
			else if($user['compliance_consumer']==0) $compliance_consumer='No';
			else $compliance_consumer='N/A';
			
			if($user['compliance_policy']==0.52) $compliance_policy='Yes';
			else if($user['compliance_policy']==0) $compliance_policy='No';
			else $compliance_policy='N/A';
			
			if($user['compliance_location']==0.52) $compliance_location='Yes';
			else if($user['compliance_location']==0) $compliance_location='No';
			else $compliance_location='N/A';
			
			if($user['compliance_dialer']==0.52) $compliance_dialer='Yes';
			else if($user['compliance_dialer']==0) $compliance_dialer='No';
			else $compliance_dialer='N/A';
			
			if($user['compliance_unfair']==0.52) $compliance_unfair='No';
			else if($user['compliance_unfair']==0) $compliance_unfair='Yes';
			else $compliance_unfair='N/A';
			
			if($user['compliance_credit']==0.52) $compliance_credit='Yes';
			else if($user['compliance_credit']==0) $compliance_credit='No';
			else $compliance_credit='N/A';
			
			if($user['compliance_disput']==0.52) $compliance_disput='Yes';
			else if($user['compliance_disput']==0) $compliance_disput='No';
			else $compliance_disput='N/A';
			
			if($user['compliance_obtain']==0.52) $compliance_obtain='Yes';
			else if($user['compliance_obtain']==0) $compliance_obtain='No';
			else $compliance_obtain='N/A';
			
			if($user['compliance_imply']==0.52) $compliance_imply='Yes';
			else if($user['compliance_imply']==0) $compliance_imply='No';
			else $compliance_imply='N/A';
			
			if($user['compliance_legal']==0.52) $compliance_legal='Yes';
			else if($user['compliance_legal']==0) $compliance_legal='No';
			else $compliance_legal='N/A';
			
			if($user['compliance_barred']==0.52) $compliance_barred='Yes';
			else if($user['compliance_barred']==0) $compliance_barred='No';
			else $compliance_barred='N/A';
			
			if($user['compliance_fdcpa']==0.52) $compliance_fdcpa='Yes';
			else if($user['compliance_fdcpa']==0) $compliance_fdcpa='No';
			else $compliance_fdcpa='N/A';
			
			if($user['compliance_consider']==0.52) $compliance_consider='Yes';
			else if($user['compliance_consider']==0) $compliance_consider='No';
			else $compliance_consider='N/A';
			
		/* 	if($user['compliance_collector']==0.52) $compliance_collector='No';
			else if($user['compliance_collector']==0) $compliance_collector='Yes';
			else $compliance_collector='N/A';  */
			 
			if($user['payment_script_recap']==2) $payment_script_recap='No';
			else if($user['payment_script_recap']==0) $payment_script_recap='Yes';
			else $payment_script_recap='N/A';
			
			if($user['payment_script_authorization']==2) $payment_script_authorization='Yes';
			else if($user['payment_script_authorization']==0) $payment_script_authorization='No';
			else $payment_script_authorization='N/A';
			
			if($user['payment_script_advice']==2) $payment_script_advice='Yes';
			else if($user['payment_script_advice']==0) $payment_script_advice='No';
			else $payment_script_advice='N/A';
			
			if($user['payment_script_educate']==2) $payment_script_educate='Yes';
			else if($user['payment_script_educate']==0) $payment_script_educate='No';
			else $payment_script_educate='N/A';
			
			if($user['payment_script_confirmation_code']==2) $payment_script_confirmation_code='Yes';
			else if($user['payment_script_confirmation_code']==0) $payment_script_confirmation_code='No';
			else $payment_script_confirmation_code='N/A';
			
			 
			if($user['callcontrol_demo']==2.5) $callcontrol_demo='No';
			else if($user['callcontrol_demo']==0) $callcontrol_demo='Yes';
			else $callcontrol_demo='N/A';
			
			if($user['callcontrol_anticipate']==2.5) $callcontrol_anticipate='Yes';
			else if($user['callcontrol_anticipate']==0) $callcontrol_anticipate='No';
			else $callcontrol_anticipate='N/A';
			
			 
			
			if($user['closing_call']==1.25) $closing_call='Yes';
			else if($user['closing_call']==0) $closing_call='No';
			else $closing_call='N/A';
			
			if($user['closing_restate']==1.25) $closing_restate='Yes';
			else if($user['closing_restate']==0) $closing_restate='No';
			else $closing_restate='N/A';
			
			if($user['closing_educate']==1.25) $closing_educate='Yes';
			else if($user['closing_educate']==0) $closing_educate='No';
			else $closing_educate='N/A';
			
			if($user['closing_profession']==1.25) $closing_profession='Yes';
			else if($user['closing_profession']==0) $closing_profession='No';
			else $closing_profession='N/A';
			
			
			if($user['document_action']==1.42) $document_action='Yes';
			else if($user['document_action']==0) $document_action='No';
			else $document_action='N/A';
			
			if($user['document_result']==1.42) $document_result='Yes';
			else if($user['document_result']==0) $document_result='No';
			else $document_result='N/A';
			
			if($user['document_context']==1.42) $document_context='Yes';
			else if($user['document_context']==0) $document_context='No';
			else $document_context='N/A';
			
			if($user['document_remove']==1.42) $document_remove='Yes';
			else if($user['document_remove']==0) $document_remove='No';
			else $document_remove='N/A';
			
			if($user['document_update']==1.42) $document_update='Yes';
			else if($user['document_update']==0) $document_update='No';
			else $document_update='N/A';
			
			if($user['document_change']==1.42) $document_change='Yes';
			else if($user['document_change']==0) $document_change='No';
			else $document_change='N/A';
			
			if($user['document_escalate']==1.42) $document_escalate='Yes';
			else if($user['document_escalate']==0) $document_escalate='No';
			else $document_escalate='N/A';
			
			
			
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
			}
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['contact_date'].'",';
			$row .= '"'.$user['contact_duration'].'",';
			$row .= '"'.$user['vsi_account'].'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'.$user['acpt_option'].'",';
			$row .= '"'.$user['acpt_other'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['can_automated'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$opening_call.'",'; 
			$row .= '"'.$opening_verbatim.'",';
			$row .= '"'.$opening_vrs.'",';
			$row .= '"'.$opening_rightparty.'",';
			$row .= '"'.$opening_demographics.'",';
			$row .= '"'.$opening_miranda.'",';
			$row .= '"'.$opening_communication.'",';
			$row .= '"'.$opening_balance_due.'",';
			$row .= '"'.$effort_delinquency.'",';
			$row .= '"'.$effort_complete_information.'",';
			$row .= '"'.$effort_payment_over_phone.'",';
			$row .= '"'.$effort_post_dated_payment.'",';
			$row .= '"'.$effort_promise_to_pay.'",';
			$row .= '"'.$negotiation_split_balance.'",';
			$row .= '"'.$negotiation_monthly_payment.'",';
			$row .= '"'.$negotiation_payment_plan.'",';
			$row .= '"'.$negotiation_faith_payment.'",';
			$row .= '"'.$compliance_mispresent.'",';
			$row .= '"'.$compliance_threaten.'",';
			$row .= '"'.$compliance_account.'",';
			$row .= '"'.$compliance_faulse.'",';
			$row .= '"'.$compliance_contact.'",';
			$row .= '"'.$compliance_communicate.'",';
			$row .= '"'.$compliance_consumer.'",';
			$row .= '"'.$compliance_policy.'",';
			$row .= '"'.$compliance_location.'",';
			$row .= '"'.$compliance_dialer.'",';
			$row .= '"'.$compliance_unfair.'",';
			$row .= '"'.$compliance_credit.'",';
			$row .= '"'.$compliance_disput.'",';
			$row .= '"'.$compliance_obtain.'",';
			$row .= '"'.$compliance_imply.'",';
			$row .= '"'.$compliance_legal.'",';
			$row .= '"'.$compliance_barred.'",';
			$row .= '"'.$compliance_fdcpa.'",';
			$row .= '"'.$compliance_consider.'",';
			/*$row .= '"'.$compliance_collector.'",'; */
			$row .= '"'.$payment_script_recap.'",';
			$row .= '"'.$payment_script_authorization.'",';
			$row .= '"'.$payment_script_advice.'",';
			$row .= '"'.$payment_script_educate.'",';
			$row .= '"'.$payment_script_confirmation_code.'",';
			$row .= '"'.$callcontrol_demo.'",';
			$row .= '"'.$callcontrol_anticipate.'",';
			$row .= '"'.$closing_call.'",';
			$row .= '"'.$closing_restate.'",';
			$row .= '"'.$closing_educate.'",';
			$row .= '"'.$closing_profession.'",';
			$row .= '"'.$document_action.'",';
			$row .= '"'.$document_result.'",';
			$row .= '"'.$document_context.'",';
			$row .= '"'.$document_remove.'",';
			$row .= '"'.$document_update.'",';
			$row .= '"'.$document_change.'",';
			$row .= '"'.$document_escalate.'",';
			$row .= '"'.$user['opening_score'].'",';
			$row .= '"'.$user['opening_possible_scr'].'",';
			$row .= '"'.$user['effort_score'].'",';
			$row .= '"'.$user['effort_possible_scr'].'",';
			$row .= '"'.$user['negotiation_score'].'",';
			$row .= '"'.$user['negotiation_possible_score'].'",';
			$row .= '"'.$user['payment_script_score'].'",';
			$row .= '"'.$user['payment_script_possible_score'].'",';
			$row .= '"'.$user['compliance_score'].'",';
			$row .= '"'.$user['compliance_possible_scr'].'",';
			$row .= '"'.$user['callcontrol_score'].'",';
			$row .= '"'.$user['callcontrol_possible_scr'].'",';
			$row .= '"'.$user['closing_score'].'",';
			$row .= '"'.$user['closing_possible_scr'].'",';
			$row .= '"'.$user['document_score'].'",';
			$row .= '"'.$user['document_possible_scr'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['point_earned'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['entry_time'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
	
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////	
	public function add_cavalry_feedback()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_cavalry_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"cavarly_account" => $this->input->post('acc_no'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_length" => $this->input->post('call_length'),
					"audit_id" => $this->input->post('audit_id'),
					"extension" => $this->input->post('extension'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"cav_form_possible" => $this->input->post('cav_form_possible'),
					"customer_service_with_respect" => $this->input->post('customer_service_with_respect'),
					"avoided_third_party_disclosure" => $this->input->post('avoided_third_party_disclosure'),
					"gave_all_required_disclosures" => $this->input->post('gave_all_required_disclosures'),
					"followed_local_requirement" => $this->input->post('followed_local_requirement'),
					"commented_account" => $this->input->post('commented_account'),
					"avoided_making_misleading" => $this->input->post('avoided_making_misleading'),
					"avoided_improper_credit" => $this->input->post('avoided_improper_credit'),
					"avoided_improper_3rd_party" => $this->input->post('avoided_improper_3rd_party'),
					"avoided_not_honoring" => $this->input->post('avoided_not_honoring'),
					"avoided_improper_legal_talk" => $this->input->post('avoided_improper_legal_talk'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_cav/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_vrs_cavalry_feedback',$field_array);
				redirect('Qa_vrs');
			}
			$data["array"] = $a;		
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_vrs_cav_feedback_rvw($id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/mgnt_vrs_cav_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$data["agentName"] = $this->Qa_vrs_model->get_agent_id(18,71,30,88);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["get_vrs_cav_feedback"] = $this->Qa_vrs_model->view_vrs_cav_feedback($id);
			
			$data["cav_id"]=$id;
			$a = array();
			
			$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_cap_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_cap_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('cav_id'))
			{
				$cav_id=$this->input->post('cav_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"cavarly_account" => $this->input->post('acc_no'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_length" => $this->input->post('call_length'),
					"audit_id" => $this->input->post('audit_id'),
					"extension" => $this->input->post('extension'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					"cav_form_possible" => $this->input->post('cav_form_possible'),
					"customer_service_with_respect" => $this->input->post('customer_service_with_respect'),
					"avoided_third_party_disclosure" => $this->input->post('avoided_third_party_disclosure'),
					"gave_all_required_disclosures" => $this->input->post('gave_all_required_disclosures'),
					"followed_local_requirement" => $this->input->post('followed_local_requirement'),
					"commented_account" => $this->input->post('commented_account'),
					"avoided_making_misleading" => $this->input->post('avoided_making_misleading'),
					"avoided_improper_credit" => $this->input->post('avoided_improper_credit'),
					"avoided_improper_3rd_party" => $this->input->post('avoided_improper_3rd_party'),
					"avoided_not_honoring" => $this->input->post('avoided_not_honoring'),
					"avoided_improper_legal_talk" => $this->input->post('avoided_improper_legal_talk'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_cav/');
					$field_array['attach_file'] = implode(',',$a);
				}
				$this->db->where('id', $cav_id);
				$this->db->update('qa_vrs_cavalry_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $cav_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_cavalry_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $cav_id);
					$this->db->update('qa_vrs_cavalry_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_vrs');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////// VRS CPTA ///////////////////////
	public function add_cpta_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_cpta_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,18) OR is_assign_client (id,71)) and (is_assign_process (id,228) OR is_assign_process (id,88)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"customer" => $this->input->post('customer'),
					"connect_type" => $this->input->post('connect_type'),
					"verbatim" => $this->input->post('verbatim'),
					"transfer" => $this->input->post('transfer'),
					"transfer_type" => $this->input->post('transfer_type'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"qa_comment" => $this->input->post('qa_comment'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/cpta/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_vrs_cpta_feedback',$field_array);
				redirect('Qa_vrs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_vrs_cpta_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/mgnt_vrs_cpta_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,18) OR is_assign_client (id,71)) and (is_assign_process (id,228) OR is_assign_process (id,88)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_vrs_cpta_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["cpta_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["cptaid"]=$id;
			$a = array();
			
			$qSql="Select * FROM qa_vrs_cpta_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('cptaid'))
			{
				$cptaid=$this->input->post('cptaid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"customer" => $this->input->post('customer'),
					"connect_type" => $this->input->post('connect_type'),
					"verbatim" => $this->input->post('verbatim'),
					"transfer" => $this->input->post('transfer'),
					"transfer_type" => $this->input->post('transfer_type'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"qa_comment" => $this->input->post('qa_comment')
				);
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/cpta/');
					$field_array['attach_file'] = implode(',',$a);
				}
				$this->db->where('id', $cptaid);
				$this->db->update('qa_vrs_cpta_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $cptaid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_cpta_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $cptaid);
					$this->db->update('qa_vrs_cpta_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_vrs');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	//*********************************************************************************************************//
	//******************************** VRS JAMAICA RIGHT PARTY AUDIT ******************************************//
	//*********************************************************************************************************//
	
	
	public function add_jrpa_feedback(){
		if(check_logged_in())
		{  
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/add_jrpa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,71) and is_assign_process (id,88) and status=1 and office_id='JAM'  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"call_type" => $this->input->post('call_type'),
					"can_automated" => $this->input->post('can_automated'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					
					"opening_call" => $this->input->post('opening_1'),
					"opening_verbatim" => $this->input->post('opening_2'),
					"opening_vrs" => $this->input->post('opening_3'),
					"opening_rightparty" => $this->input->post('opening_4'),
					"opening_demographics" => $this->input->post('opening_5'),
					"opening_miranda" => $this->input->post('opening_6'),
					"opening_communication" => $this->input->post('opening_7'),
					"opening_balance_due" => $this->input->post('opening_8'),
					"opening_score" => $this->input->post('opening_score'),
					"opening_possible_scr" => $this->input->post('opening_possible_scr'),
					
					"effort_delinquency" => $this->input->post('effort_1'),
					"effort_complete_information" => $this->input->post('effort_2'),
					"effort_payment_over_phone" => $this->input->post('effort_3'),
					"effort_post_dated_payment" => $this->input->post('effort_4'),
					"effort_promise_to_pay" => $this->input->post('effort_5'),
					"effort_score" => $this->input->post('effort_score'),
					"effort_possible_scr" => $this->input->post('effort_possible_scr'),
					
					
					"negotiation_split_balance" => $this->input->post('negotiation_1'),
					"negotiation_monthly_payment" => $this->input->post('negotiation_2'),
					"negotiation_payment_plan" => $this->input->post('negotiation_3'),
					"negotiation_faith_payment" => $this->input->post('negotiation_4'),
					"negotiation_score" => $this->input->post('negotiation_score'),
					"negotiation_possible_score" => $this->input->post('negotiation_possible_scr'),
					
					"compliance_mispresent" => $this->input->post('compliance_1'),
					"compliance_threaten" => $this->input->post('compliance_2'),
					"compliance_account" => $this->input->post('compliance_3'),
					"compliance_faulse" => $this->input->post('compliance_4'),
					"compliance_contact" => $this->input->post('compliance_5'),
					"compliance_communicate" => $this->input->post('compliance_6'),
					"compliance_consumer" => $this->input->post('compliance_7'),
					"compliance_policy" => $this->input->post('compliance_8'),
					"compliance_location" => $this->input->post('compliance_9'),
					"compliance_dialer" => $this->input->post('compliance_10'),
					"compliance_unfair" => $this->input->post('compliance_11'),
					"compliance_credit" => $this->input->post('compliance_12'),
					"compliance_disput" => $this->input->post('compliance_13'),
					"compliance_obtain" => $this->input->post('compliance_14'),
					"compliance_imply" => $this->input->post('compliance_15'),
					"compliance_legal" => $this->input->post('compliance_16'),
					"compliance_barred" => $this->input->post('compliance_17'),
					"compliance_fdcpa" => $this->input->post('compliance_18'),
					"compliance_consider" => $this->input->post('compliance_19'),
					"compliance_score" => $this->input->post('compliance_score'),
					"compliance_possible_scr" => $this->input->post('compliance_possible_scr'),
					
					"payment_script_recap" => $this->input->post('payment_script_1'),
					"payment_script_authorization" => $this->input->post('payment_script_2'),
					"payment_script_advice" => $this->input->post('payment_script_3'),
					"payment_script_educate" => $this->input->post('payment_script_4'),
					"payment_script_confirmation_code" => $this->input->post('payment_script_5'),
					"payment_script_score" => $this->input->post('payment_script_score'),
					"payment_script_possible_score" => $this->input->post('payment_script_possible_scr'),
					
					"callcontrol_demo" => $this->input->post('call_control_1'),
					"callcontrol_anticipate" => $this->input->post('call_control_2'),
					"callcontrol_score" => $this->input->post('call_control_score'),
					"callcontrol_possible_scr" => $this->input->post('call_control_possible_scr'),
					
					"closing_call" => $this->input->post('closing_1'),
					"closing_restate" => $this->input->post('closing_2'),
					"closing_educate" => $this->input->post('closing_3'),
					"closing_profession" => $this->input->post('closing_4'),
					"closing_score" => $this->input->post('closing_score'),
					"closing_possible_scr" => $this->input->post('closing_possible_scr'),
					
					
					"document_action" => $this->input->post('document_1'),
					"document_result" => $this->input->post('document_2'),
					"document_context" => $this->input->post('document_3'),
					"document_remove" => $this->input->post('document_4'),
					"document_update" => $this->input->post('document_5'),
					"document_change" => $this->input->post('document_6'),
					"document_escalate" => $this->input->post('document_7'),
					"document_score" => $this->input->post('document_score'),
					"document_possible_scr" => $this->input->post('document_possible_scr'),
					
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_jrpa/');
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_vrs_jrpa_feedback',$field_array);
				redirect('Qa_vrs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_vrs_jrpa_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/mgnt_vrs_jrpa_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,71) and is_assign_process (id,88) and status=1 and office_id='JAM'  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["get_vrs_jrpa_feedback"] = $this->Qa_vrs_model->view_vrs_jrpa_feedback($id);
			
			$data["rpid"]=$id;
			$a = array();
			
			$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_jrpa_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_jrpa_rvw($id);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('rp_id'))
			{
				$rp_id=$this->input->post('rp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"phone" => $this->input->post('phone'),
					"contact_date" => mmddyy2mysql($this->input->post('contact_date')),
					"contact_duration" => $this->input->post('contact_duration'),
					"vsi_account" => $this->input->post('vsi_account'),
					"acpt" => $this->input->post('acpt'),
					"acpt_option" => $this->input->post('acpt_option'),
					"acpt_other" => $this->input->post('acpt_other'),
					"call_type" => $this->input->post('call_type'),
					"can_automated" => $this->input->post('can_automated'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_percent'),
					"point_earned" => $this->input->post('total_score'),
					
					"opening_call" => $this->input->post('opening_1'),
					"opening_verbatim" => $this->input->post('opening_2'),
					"opening_vrs" => $this->input->post('opening_3'),
					"opening_rightparty" => $this->input->post('opening_4'),
					"opening_demographics" => $this->input->post('opening_5'),
					"opening_miranda" => $this->input->post('opening_6'),
					"opening_communication" => $this->input->post('opening_7'),
					"opening_balance_due" => $this->input->post('opening_8'),
					"opening_score" => $this->input->post('opening_score'),
					"opening_possible_scr" => $this->input->post('opening_possible_scr'),
					
					"effort_delinquency" => $this->input->post('effort_1'),
					"effort_complete_information" => $this->input->post('effort_2'),
					"effort_payment_over_phone" => $this->input->post('effort_3'),
					"effort_post_dated_payment" => $this->input->post('effort_4'),
					"effort_promise_to_pay" => $this->input->post('effort_5'),
					"effort_score" => $this->input->post('effort_score'),
					"effort_possible_scr" => $this->input->post('effort_possible_scr'),
					
					
					"negotiation_split_balance" => $this->input->post('negotiation_1'),
					"negotiation_monthly_payment" => $this->input->post('negotiation_2'),
					"negotiation_payment_plan" => $this->input->post('negotiation_3'),
					"negotiation_faith_payment" => $this->input->post('negotiation_4'),
					"negotiation_score" => $this->input->post('negotiation_score'),
					"negotiation_possible_score" => $this->input->post('negotiation_possible_scr'),
					
					"compliance_mispresent" => $this->input->post('compliance_1'),
					"compliance_threaten" => $this->input->post('compliance_2'),
					"compliance_account" => $this->input->post('compliance_3'),
					"compliance_faulse" => $this->input->post('compliance_4'),
					"compliance_contact" => $this->input->post('compliance_5'),
					"compliance_communicate" => $this->input->post('compliance_6'),
					"compliance_consumer" => $this->input->post('compliance_7'),
					"compliance_policy" => $this->input->post('compliance_8'),
					"compliance_location" => $this->input->post('compliance_9'),
					"compliance_dialer" => $this->input->post('compliance_10'),
					"compliance_unfair" => $this->input->post('compliance_11'),
					"compliance_credit" => $this->input->post('compliance_12'),
					"compliance_disput" => $this->input->post('compliance_13'),
					"compliance_obtain" => $this->input->post('compliance_14'),
					"compliance_imply" => $this->input->post('compliance_15'),
					"compliance_legal" => $this->input->post('compliance_16'),
					"compliance_barred" => $this->input->post('compliance_17'),
					"compliance_fdcpa" => $this->input->post('compliance_18'),
					"compliance_consider" => $this->input->post('compliance_19'),
					"compliance_score" => $this->input->post('compliance_score'),
					"compliance_possible_scr" => $this->input->post('compliance_possible_scr'),
					
					"payment_script_recap" => $this->input->post('payment_script_1'),
					"payment_script_authorization" => $this->input->post('payment_script_2'),
					"payment_script_advice" => $this->input->post('payment_script_3'),
					"payment_script_educate" => $this->input->post('payment_script_4'),
					"payment_script_confirmation_code" => $this->input->post('payment_script_5'),
					"payment_script_score" => $this->input->post('payment_script_score'),
					"payment_script_possible_score" => $this->input->post('payment_script_possible_scr'),
					
					"callcontrol_demo" => $this->input->post('call_control_1'),
					"callcontrol_anticipate" => $this->input->post('call_control_2'),
					"callcontrol_score" => $this->input->post('call_control_score'),
					"callcontrol_possible_scr" => $this->input->post('call_control_possible_scr'),
					
					"closing_call" => $this->input->post('closing_1'),
					"closing_restate" => $this->input->post('closing_2'),
					"closing_educate" => $this->input->post('closing_3'),
					"closing_profession" => $this->input->post('closing_4'),
					"closing_score" => $this->input->post('closing_score'),
					"closing_possible_scr" => $this->input->post('closing_possible_scr'),
					
					
					"document_action" => $this->input->post('document_1'),
					"document_result" => $this->input->post('document_2'),
					"document_context" => $this->input->post('document_3'),
					"document_remove" => $this->input->post('document_4'),
					"document_update" => $this->input->post('document_5'),
					"document_change" => $this->input->post('document_6'),
					"document_escalate" => $this->input->post('document_7'),
					"document_score" => $this->input->post('document_score'),
					"document_possible_scr" => $this->input->post('document_possible_scr'),
					 
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				); 
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->vrs_upload_files($_FILES['attach_file'],$path='./qa_files/qa_vrs/vrs_jrpa/');
					$field_array['attach_file'] = implode(',',$a);
				}
				$this->db->where('id', $rp_id);
				$this->db->update('qa_vrs_jrpa_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $rp_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_jrpa_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rp_id);
					$this->db->update('qa_vrs_jrpa_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_vrs');
				$data["array"] = $a;
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
////////////////////VRS Right Party////////////////////////
	public function agent_vrs_jrpa_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_vrs/agent_vrs_jrpa_feedback_rvw.php";
			$data["agentUrl"] = "qa_vrs/agent_vrs_feedback";
						
			
			$data["get_vrs_jrpa_feedback"] = $this->Qa_vrs_model->view_vrs_jrpa_feedback($id);
			
			$data["rpid"]=$id;
			
			$data["row1"] = $this->Qa_vrs_model->view_agent_vrs_jrpa_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_vrs_model->view_mgnt_vrs_jrpa_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('rp_id'))
			{
				$rp_id=$this->input->post('rp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $rp_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_vrs_jrpa_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rp_id);
					$this->db->update('qa_vrs_jrpa_agent_rvw',$field_array1);
				}	
				redirect('Qa_vrs/agent_vrs_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
 }