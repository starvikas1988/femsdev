<?php

 class Qa_craftjack extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
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
	
	
	// private function craftjack_upload_files($files,$path)
 //    {
 //        $config['upload_path'] = $path;
	// 	$config['allowed_types'] = 'mp3|avi|mp4|wmv';
	// 	$config['max_size'] = '2024000';
	// 	$this->load->library('upload', $config);
	// 	$this->upload->initialize($config);
 //        $images = array();
 //        foreach ($files['name'] as $key => $image) {           
	// 		$_FILES['images[]']['name']= $files['name'][$key];
	// 		$_FILES['images[]']['type']= $files['type'][$key];
	// 		$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
	// 		$_FILES['images[]']['error']= $files['error'][$key];
	// 		$_FILES['images[]']['size']= $files['size'][$key];
 //            if ($this->upload->do_upload('images[]')) {
	// 			$info = $this->upload->data();
	// 			$images[] = $info['file_name'];
 //            } else {
 //                return false;
 //            }
 //        }
 //        return $images;
 //    }

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
   private function craftjack_upload_files($files,$path)   // this is for file uploaging purpose
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

/////////////////Home Craftjack vikas//////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/qa_craftjack_feedback.php";
			$data["content_js"] = "qa_avon_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process (id,31) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_craftjack_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["craftjack_new_data"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_craftjack_cebu_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["craftjack_cebu_data"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_craftjack_mtl_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["craftjack_mtl_data"] = $this->Common_model->get_query_result_array($qSql);


			/* $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_craftjack_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_craftjack_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_craftjack_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_craftjack_data"] = $this->Common_model->get_query_result_array($qSql); */

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_craftjack($craftjack_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/add_edit_craftjack.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['craftjack_id']=$craftjack_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process (id,31) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_craftjack_new_feedback where id='$craftjack_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["craftjack_new"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($craftjack_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->craftjack_upload_files($_FILES['attach_file'], $path='./qa_files/craftjack/qa_audio_files/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_craftjack_new_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_craftjack_new_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $craftjack_id);
					$this->db->update('qa_craftjack_new_feedback',$field_array1);
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
					$this->db->where('id', $craftjack_id);
					$this->db->update('qa_craftjack_new_feedback',$edit_array);

				}

				redirect('Qa_craftjack');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	///////////////////vikas/////////////////////////////

	public function add_edit_craftjack_mtl($craftjack_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/add_edit_craftjack_mtl.php";
			$data["content_js"] = "qa_avon_js.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data['craftjack_id']=$craftjack_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			// $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process (id,31) and status=1  order by name";
			// $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			 $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process(id,31) and status=1  order by name";
        $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			// $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_craftjack_mtl_feedback where id='$craftjack_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["craftjack_mtl"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($craftjack_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->craftjack_upload_files($_FILES['attach_file'], $path='./qa_files/craftjack/qa_audio_files/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_craftjack_mtl_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_craftjack_mtl_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/craftjack/qa_audio_files/")){
							mkdir("./qa_files/craftjack/qa_audio_files/");
						}
						$a = $this->craftjack_upload_files( $_FILES['attach_file'], $path = './qa_files/craftjack/qa_audio_files/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $craftjack_id);
					$this->db->update('qa_craftjack_mtl_feedback',$field_array1);
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
					$this->db->where('id', $craftjack_id);
					$this->db->update('qa_craftjack_mtl_feedback',$edit_array);

				}

				redirect('Qa_craftjack');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	/////////////////////////////////////////////////////

	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/add_feedback.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process (id,31) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"ext_no" => $this->input->post('ext_no'),
					"recording_id" => $this->input->post('recording_id'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"introduction" => $this->input->post('introduction'),
					"educate" => $this->input->post('educate'),
					"solution" => $this->input->post('solution'),
					"email_zip_code" => $this->input->post('email_zip_code'),
					"xm_mmr_ib" => $this->input->post('xm_mmr_ib'),
					"expectation" => $this->input->post('expectation'),
					"professionalism" => $this->input->post('professionalism'),
					"transfer" => $this->input->post('transfer'),
					"valid_ctt" => $this->input->post('valid_ctt'),
					"correct_dispo" => $this->input->post('correct_dispo'),
					"attitude" => $this->input->post('attitude'),
					"ownership" => $this->input->post('ownership'),
					"acknowledged" => $this->input->post('acknowledged'),
					"verbal_skill" => $this->input->post('verbal_skill'),
					"card_detail" => $this->input->post('card_detail'),
					"proper_closing" => $this->input->post('proper_closing'),
					"purpose_for_calling" => $this->input->post('purpose_for_calling'),
					"probe" => $this->input->post('probe'),
					"cross_sell" => $this->input->post('cross_sell'),
					"branding" => $this->input->post('branding'),
					"pass_fail_xm_mmr_ib" => $this->input->post('pass_fail_xm_mmr_ib'),
					"pass_fail_recorded_line" => $this->input->post('pass_fail_recorded_line'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$rowid= data_inserter('qa_craftjack_feedback',$field_array);
				redirect('Qa_craftjack');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

//////////////////////////////////////////////////////Riya/////////////////////////////////////////////////////////////

		public function add_edit_craftjack_cebu($craftjack_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/add_edit_craftjack_cebu.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['craftjack_id']=$craftjack_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process (id,31) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_craftjack_cebu_feedback where id='$craftjack_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["craftjack_new"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($craftjack_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					$a = $this->craftjack_upload_files($_FILES['attach_file'], $path='./qa_files/craftjack/');
                    $field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_craftjack_cebu_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_craftjack_cebu_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $craftjack_id);
					$this->db->update('qa_craftjack_cebu_feedback',$field_array1);
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
					$this->db->where('id', $craftjack_id);
					$this->db->update('qa_craftjack_cebu_feedback',$edit_array);

				}

				redirect('Qa_craftjack');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	public function mgnt_craftjack_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/mgnt_craftjack_feedback_rvw.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process (id,31) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_craftjack_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["cj_pa"] = $this->Common_model->get_query_row_array($qSql);

			$data["cjid"]=$id;

			$qSql="Select * FROM qa_craftjack_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE

			$qSql="Select * FROM qa_craftjack_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE

		///////Edit Part///////
			if($this->input->post('cj_id'))
			{
				$cj_id=$this->input->post('cj_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

				$field_array=array(
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"ext_no" => $this->input->post('ext_no'),
					"recording_id" => $this->input->post('recording_id'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"introduction" => $this->input->post('introduction'),
					"educate" => $this->input->post('educate'),
					"solution" => $this->input->post('solution'),
					"email_zip_code" => $this->input->post('email_zip_code'),
					"xm_mmr_ib" => $this->input->post('xm_mmr_ib'),
					"expectation" => $this->input->post('expectation'),
					"professionalism" => $this->input->post('professionalism'),
					"transfer" => $this->input->post('transfer'),
					"valid_ctt" => $this->input->post('valid_ctt'),
					"correct_dispo" => $this->input->post('correct_dispo'),
					"attitude" => $this->input->post('attitude'),
					"ownership" => $this->input->post('ownership'),
					"acknowledged" => $this->input->post('acknowledged'),
					"verbal_skill" => $this->input->post('verbal_skill'),
					"card_detail" => $this->input->post('card_detail'),
					"proper_closing" => $this->input->post('proper_closing'),
					"purpose_for_calling" => $this->input->post('purpose_for_calling'),
					"probe" => $this->input->post('probe'),
					"cross_sell" => $this->input->post('cross_sell'),
					"branding" => $this->input->post('branding'),
					"pass_fail_xm_mmr_ib" => $this->input->post('pass_fail_xm_mmr_ib'),
					"pass_fail_recorded_line" => $this->input->post('pass_fail_recorded_line'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				$this->db->where('id', $cj_id);
				$this->db->update('qa_craftjack_feedback',$field_array);

			////////////
				$field_array1=array(
					"fd_id" => $cj_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);

				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_craftjack_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $cj_id);
					$this->db->update('qa_craftjack_mgnt_rvw',$field_array1);
				}
			///////////
				redirect('Qa_craftjack');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


/////////////////craftjack Agent part//////////////////////////

	public function agent_craftjack_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/agent_craftjack_feedback.php";
			$data["content_js"] = "qa_avon_js.php";
			$data["agentUrl"] = "qa_craftjack/agent_craftjack_feedback";

			$qSql="Select count(id) as value from qa_craftjack_new_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["total_new_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_craftjack_new_feedback where id  not in (select fd_id from qa_craftjack_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["total_new_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_craftjack_mtl_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_mtl_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_craftjack_mtl_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";

			$data["tot_mtl_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		
			// $qSql="Select count(id) as value from qa_craftjack_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			// $data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			// $qSql="Select count(id) as value from qa_craftjack_feedback where id  not in (select fd_id from qa_craftjack_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			// $data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);

		 //   	$qSql="Select count(id) as value from qa_craftjack_cebu_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			// $data["tot_agent_cebu_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			// $qSql="Select count(id) as value from qa_craftjack_cebu_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			// $data["tot_agent_cebu_yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_craftjack_cebu_feedback where agent_id='$current_user'";
			$data["tot_agent_cebu_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_craftjack_cebu_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["tot_agent_cebu_yet_rvw"] =  $this->Common_model->get_single_value($qSql);


			$from_date = '';
			$to_date = '';
			$cond="";
			$user="";

			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));

				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_craftjack_new_feedback $cond and agent_id ='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_new_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_craftjack_mtl_feedback $cond and agent_id ='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_mtl_list"] = $this->Common_model->get_query_result_array($qSql);

				/* $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_craftjack_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_craftjack_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_craftjack_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql); */

				 // $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_craftjack_cebu_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_craftjack_cebu_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_craftjack_cebu_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				 // $data["agent_cebu_review_list"] = $this->Common_model->get_query_result_array($qSql);

				 $qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_craftjack_cebu_feedback $cond and agent_id ='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_cebu_review_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_craftjack_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_review_new_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_craftjack_mtl_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_mtl_list"] = $this->Common_model->get_query_result_array($qSql);

				/* $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_craftjack_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_craftjack_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_craftjack_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_craftjack_agent_rvw)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql); */

				// $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_craftjack_cebu_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_craftjack_cebu_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_craftjack_cebu_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_craftjack_cebu_agent_rvw)";
				// $data["agent_cebu_review_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_craftjack_cebu_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_cebu_review_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}

	
	public function agent_craftjack_new_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/agent_craftjack_new_feedback_rvw.php";
			$data["agentUrl"] = "qa_craftjack/agent_craftjack_feedback";
			$data["content_js"] = "qa_clio_js.php";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_craftjack_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["craftjack_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["craftjack_id"]=$id;			
			
			if($this->input->post('craftjack_id'))
			{
				$craftjack_id=$this->input->post('craftjack_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $craftjack_id);
				$this->db->update('qa_craftjack_new_feedback',$field_array);
				
				redirect('Qa_craftjack/agent_craftjack_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	//////////////////////vikas starts////////////////////////////

	public function agent_craftjack_mtl_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/agent_craftjack_mtl_feedback_rvw.php";
			$data["agentUrl"] = "qa_craftjack/agent_craftjack_feedback";
			$data["content_js"] = "qa_avon_js.php";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_craftjack_mtl_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["craftjack_mtl"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["craftjack_id"]=$id;			
			
			if($this->input->post('craftjack_id'))
			{
				$craftjack_id=$this->input->post('craftjack_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $craftjack_id);
				$this->db->update('qa_craftjack_mtl_feedback',$field_array);
				
				redirect('Qa_craftjack/agent_craftjack_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	//////////////////////vikas ends///////////////////////
	
	public function agent_craftjack_cebu_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_craftjack/agent_craftjack_cebu_feedback_rvw.php";
			$data["agentUrl"] = "qa_craftjack/agent_craftjack_feedback";
			$data["content_js"] = "qa_clio_js.php";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_craftjack_cebu_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["craftjack_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["craftjack_id"]=$id;			
			
			if($this->input->post('craftjack_id'))
			{
				$craftjack_id=$this->input->post('craftjack_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $craftjack_id);
				$this->db->update('qa_craftjack_cebu_feedback',$field_array);
				
				redirect('Qa_craftjack/agent_craftjack_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	





//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// QA craftjack REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_craftjack_report(){
		if(check_logged_in()){

			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;

			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_craftjack/qa_craftjack_report.php";

			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$campaign='';

			$data["qa_craftjack_list"] = array();
			if($this->input->get('show')=='Show') {
			    $campaign = $this->input->get('campaign');
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";

				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}

                //Nilkanta
                if($campaign=='craftjack_new'){
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_craftjack_new_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_craftjack_list"] = $fullAray;
			    }
				//Old Croaftjack
				if($campaign=='craftjack'){
				$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_craftjack_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_craftjack_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_craftjack_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_craftjack_list"] = $fullAray;
				}


				$this->create_qa_craftjack_CSV($fullAray,$campaign);

				$dn_link = base_url()."qa_craftjack/download_qa_craftjack_CSV";


			}
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;


			$data['office_id']=$office_id;
			$data['campaign']=$campaign;

			$this->load->view('dashboard',$data);
		}
	}

////////////Craftjack ///////////////////////////////
	public function download_qa_craftjack_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Craftjack Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_craftjack_CSV($rr,$campaign)
	{

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		if($campaign=='craftjack_new'){
		 $header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "Customer Name", "Customer Phone", "Call Date", "Call Duration", "Call Type", "Audit Type", "Auditor Type", "VOC", "Call Pass/Fail", "1. Did the agent  enthusiastically welcome or greet the caller/customer?", "2. Did the agent mentioned her name?", "3. Did the agent ask the caller's name?", "1. Did the agent understand the correct project Request?.", "2. Did the agent ask probing questions?", "3. Did the agent select the correct panel?.", "4. Did the agent follow the questions to the panel?.", "5. Did the agent ask for brief description about the project?", "6. Did the agent get all of the information? (Email- Optional).", "7. Did the agent mention this statement. Do you agree to Improvenet terms including that Improvenet our service professionals and partners will reach out to you via automated call or text at the phone number you provided for this project? before submitting the SR?.", "1. Active Listening Skills.", "2. Did the agent sound conversational?", "3. Did the agent use proper tone and speed?", "4. Did the agent avoid dead air?", "5. Was the agent polite?", "6. Did the agent ended the call with the closure greeting? Thank you for calling improvenet","Comment 1","Comment 2","Comment 3","Comment 4","Comment 5","Comment 6","Comment 7","Comment 8","Comment 9","Comment 10","Comment 11","Comment 12","Comment 13","Comment 14","Comment 15","Comment 16",
     "Possible Score", "Earned Score", "Overall Score","Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment" );

		} else if($campaign=='craftjack'){
         $header = array("Auditor Name", "Audit Date", "Call Duration", "Fusion ID", "Agent Name", "L1 Supervisor", "Call Date", "EXT Number", "Call Type", "Recording ID", "Audit Type", "VOC", "Call Pass/Fail", "Introduction - Your Name/Verify who you are speaking with/HomeAdvisor Branding","Educate -  Explain how Craft jack Project Advisor works","Solution -  You explained and offered appropriate solutions based on the consumer’s needs and the conversation","Location & Email - Verify Address if possible (Address required on IB Appts)- Zip code & Email","XM/MMR/IB -  Properly presented all XM/MMR/IB options","Expectations -  Make sure the Consumer knows what to expect after the call and Do what you said you would do","Professionalism -  Maintain proper tone - word choice and rate of speech. Avoid interrupting in a non collaborative conversation","Transfer -  Offer to transfer the Consumer to the Service Professional","Correct/Valid CTT -  Correct CTT was submitted and included a detailed description of the project","Correct Dispo -  Accurately updated and noted every SR submitted within the last 14 days","Displayed a Polite - positive & professional attitude – does not interrupt","Displayed -Ownership/Decisiveness/Call Control","Listened with interest and acknowledged statements","Verbal Skills (volume/pitch/tone/jargon/slang & avoided dead air)","Customer's Card details captured without repeating","Used proper closing","Purpose -  The advisor stated their purpose for calling","Probe -  The advisor asked questions about the project and related projects & included detailed descriptions","Cross Sell -  The advisor asked for a cross sell","Branding -  Brand HomeAdvisor somewhere other than the Intro", "Overall Score","Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment" );
		}

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

		if($campaign=='craftjack_new'){

			foreach($rr as $user){
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
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['customer_phone'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['pass_fail'].'",';

				$row .= '"'.$user['enthusiastically_welcome'].'",';
				$row .= '"'.$user['mentioned_her_name'].'",';
				$row .= '"'.$user['ask_the_caller'].'",';

				$row .= '"'.$user['understand_correct_project'].'",';
				$row .= '"'.$user['ask_probing_questions'].'",';
				$row .= '"'.$user['select_correct_panel'].'",';
				$row .= '"'.$user['follow_the_questions'].'",';
				$row .= '"'.$user['ask_brief_description'].'",';
				$row .= '"'.$user['get_all_the_information'].'",';
				$row .= '"'.$user['mention_this_statement'].'",';


				$row .= '"'.$user['active_listening_skills'].'",';
				$row .= '"'.$user['sound_conversational'].'",';
				$row .= '"'.$user['use_proper_tone'].'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'.$user['agent_polite'].'",';
				$row .= '"'.$user['agent_ended_call'].'",';
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

        $row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';


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

		} else if($campaign=='craftjack'){

			foreach($rr as $user)
		{

			if($user['introduction']==8) $introduction='Yes';
			else if($user['introduction']==0) $introduction='No';
			else if($user['introduction']==8.1) $introduction='N/A';

			if($user['educate']==4) $educate='Yes';
			else if($user['educate']==0) $educate='No';
			else if($user['educate']==4.1) $educate='N/A';

			if($user['solution']==10) $solution='Yes';
			else if($user['solution']==0) $solution='No';
			else if($user['solution']==10.1) $solution='N/A';

			if($user['email_zip_code']==10) $email_zip_code='Yes';
			else if($user['email_zip_code']==0) $email_zip_code='No';
			else if($user['email_zip_code']==10.1) $email_zip_code='N/A';

			if($user['xm_mmr_ib']==4) $xm_mmr_ib='Yes';
			else if($user['xm_mmr_ib']==0) $xm_mmr_ib='No';
			else if($user['xm_mmr_ib']==4.1) $xm_mmr_ib='N/A';
			else $xm_mmr_ib='N/A';

			if($user['expectation']==4) $expectation='Yes';
			else if($user['expectation']==0) $expectation='No';
			else if($user['expectation']==4.1) $expectation='N/A';
			else $expectation='N/A';

			if($user['professionalism']==4) $professionalism='Yes';
			else if($user['professionalism']==0) $professionalism='No';
			else if($user['professionalism']==4.1) $professionalism='N/A';
			else $professionalism='N/A';

			if($user['transfer']==4) $transfer='Yes';
			else if($user['transfer']==0) $transfer='No';
			else if($user['transfer']==4.1) $transfer='N/A';
			else $transfer='N/A';

			if($user['valid_ctt']==4) $valid_ctt='Yes';
			else if($user['valid_ctt']==0) $valid_ctt='No';
			else if($user['valid_ctt']==4.1) $valid_ctt='N/A';
			else $valid_ctt='N/A';

			if($user['correct_dispo']==4) $correct_dispo='Yes';
			else if($user['correct_dispo']==0) $correct_dispo='No';
			else if($user['correct_dispo']==4.1) $correct_dispo='N/A';
			else $correct_dispo='N/A';

			if($user['attitude']==8) $attitude='Yes';
			else if($user['attitude']==0) $attitude='No';
			else if($user['attitude']==8.1) $attitude='N/A';
			else $attitude='N/A';

			if($user['ownership']==4) $ownership='Yes';
			else if($user['ownership']==0) $ownership='No';
			else if($user['ownership']==4.1) $ownership='N/A';
			else $ownership='N/A';

			if($user['acknowledged']==10) $acknowledged='Yes';
			else if($user['acknowledged']==0) $acknowledged='No';
			else if($user['acknowledged']==10.1) $acknowledged='N/A';
			else $acknowledged='N/A';

			if($user['verbal_skill']==10) $verbal_skill='Yes';
			else if($user['verbal_skill']==0) $verbal_skill='No';
			else if($user['verbal_skill']==10.1) $verbal_skill='N/A';
			else $verbal_skill='N/A';

			if($user['card_detail']==10) $card_detail='Yes';
			else if($user['card_detail']==0) $card_detail='No';
			else if($user['card_detail']==10.1) $card_detail='N/A';
			else $card_detail='N/A';

			if($user['proper_closing']==8) $proper_closing='Yes';
			else if($user['proper_closing']==0) $proper_closing='No';
			else if($user['proper_closing']==8.1) $proper_closing='N/A';
			else $proper_closing='N/A';

			$row = '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['ext_no'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['recording_id'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['call_pass_fail'].'",';
			$row .= '"'.$introduction.'",';
			$row .= '"'.$educate.'",';
			$row .= '"'.$solution.'",';
			$row .= '"'.$email_zip_code.'",';
			$row .= '"'.$xm_mmr_ib.'",';
			$row .= '"'.$expectation.'",';
			$row .= '"'.$professionalism.'",';
			$row .= '"'.$transfer.'",';
			$row .= '"'.$valid_ctt.'",';
			$row .= '"'.$correct_dispo.'",';
			$row .= '"'.$attitude.'",';
			$row .= '"'.$ownership.'",';
			$row .= '"'.$acknowledged.'",';
			$row .= '"'.$verbal_skill.'",';
			$row .= '"'.$card_detail.'",';
			$row .= '"'.$proper_closing.'",';
			$row .= '"'.$user['purpose_for_calling'].'",';
			$row .= '"'.$user['probe'].'",';
			$row .= '"'.$user['cross_sell'].'",';
			$row .= '"'.$user['branding'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';

			fwrite($fopen,$row."\r\n");
		}

		fclose($fopen);

		}




	}

 }
