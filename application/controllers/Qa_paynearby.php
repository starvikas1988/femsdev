<?php

 class Qa_paynearby extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}

	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
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

	private function pnb_ob_sales_v1_upload_files($files,$path)
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

	private function pnb_upload_files($files,$path){
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
	
////////////// New Addition ////////////////
	private function audio_upl_files($files,$path)
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
////////////////////////////////////
	
	
	public function pnb_qa_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$curDateTime=CurrMySqlDate();
			$mpid = $this->input->post('mpid');
			$pnb_tbl = $this->input->post('pnb_tbl');
			$qa_feedback_type = $this->input->post('qa_feedback_type');
			$qa_feedback_note = $this->input->post('qa_feedback_note');
			
			if($mpid!=""){
				$qa_array = array(
					"qa_feedback_type" => $qa_feedback_type,
					"qa_feedback" => $qa_feedback_note,
					"qa_feedback_date" => $curDateTime
				);
				$this->db->where('id', $mpid);
				$this->db->update($pnb_tbl,$qa_array);
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "qa_paynearby";
			redirect($referer);
		}
	}

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/qa_paynearby_feedback.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name"; /*and is_assign_process(id,220)*/
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
			if($agent_id!=""){
				$agent_id_arr=implode("','", $agent_id);
				$cond .=" and agent_id in ('$agent_id_arr')";
			}

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else if(get_login_type()=="client"){
					$ops_cond=" Where audit_type not in ('Operation Audit','Trainer Audit')";
			}else{
				$ops_cond="";
			}
		   // Use for PNB Inbound
			// $qSql = "SELECT * from
			// 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			// 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			// 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			// 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_inbound_new_feedback $cond) xx Left Join
			// 	(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_new_inb_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_pnb_inbound_data"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_new_kyc_inb_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_pnb_kyc_inbound_data"] = $this->Common_model->get_query_result_array($qSql);
         ////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join
				(Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_paynearby_agent_rvw) zz on (xx.id=zz.fd_id) Left Join
				(Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name,
				note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_paynearby_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_paynearby_data"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_pnb_inbound($pnbinbound_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_inbound.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['pnbinbound_id']=$pnbinbound_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_pnb_inbound_new_feedback where id='$pnbinbound_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["pnbinbound"] = $this->Common_model->get_query_row_array($qSql);


			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($pnbinbound_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pnbinbound/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_pnb_inbound_new_feedback',$field_array);

					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_pnb_inbound_new_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'],$path='./qa_files/pnbinbound/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $pnbinbound_id);
					$this->db->update('qa_pnb_inbound_new_feedback',$field_array1);
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
					$this->db->where('id', $pnbinbound_id);
					$this->db->update('qa_pnb_inbound_new_feedback',$edit_array);

				}
				redirect('qa_paynearby');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_pnb_outbount($pnboutbound_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_outbount.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['pnboutbound_id']=$pnboutbound_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_pnb_outbound_new_feedback where id='$pnboutbound_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["pnboutbound"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($pnboutbound_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pnboutbound/');
                    $field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_pnb_outbound_new_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_pnb_outbound_new_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pnboutbound/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $pnboutbound_id);
					$this->db->update('qa_pnb_outbound_new_feedback',$field_array1);
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
					$this->db->where('id', $pnboutbound_id);
					$this->db->update('qa_pnb_outbound_new_feedback',$edit_array);

				}

				redirect('Qa_paynearby/paynearby_outbound');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}


	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_feedback.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('call_date')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer" => $this->input->post('customer'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"grade" => $this->input->post('grade'),
					"overall_score" => $this->input->post('overall_score'),
					"opening_greeting" => $this->input->post('opening_greeting'),
					"initial_empathy" => $this->input->post('initial_empathy'),
					"agent_query" => $this->input->post('agent_query'),
					"proper_telephone" => $this->input->post('proper_telephone'),
					"ivr_promotion" => $this->input->post('ivr_promotion'),
					"efective_rebuttal" => $this->input->post('efective_rebuttal'),
					"fraud_alert" => $this->input->post('fraud_alert'),
					"sentence_acknowledge" => $this->input->post('sentence_acknowledge'),
					"polite_call" => $this->input->post('polite_call'),
					"good_behaviour" => $this->input->post('good_behaviour'),
					"good_listening" => $this->input->post('good_listening'),
					"not_interrupt" => $this->input->post('not_interrupt'),
					"proper_empathy" => $this->input->post('proper_empathy'),
					"proper_pace" => $this->input->post('proper_pace'),
					"agent_patience" => $this->input->post('agent_patience'),
					"energy_enthusias" => $this->input->post('energy_enthusias'),
					"confident_level" => $this->input->post('confident_level'),
					"error_fumbling" => $this->input->post('error_fumbling'),
					"dead_air" => $this->input->post('dead_air'),
					"dragged_call" => $this->input->post('dragged_call'),
					"rude_language" => $this->input->post('rude_language'),
					"exact_tat" => $this->input->post('exact_tat'),
					"wrong_provide" => $this->input->post('wrong_provide'),
					"correct_tagging" => $this->input->post('correct_tagging'),
					"minor_error" => $this->input->post('minor_error'),
					"satisfy_rapport" => $this->input->post('satisfy_rapport'),
					"closing_script" => $this->input->post('closing_script'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);

				$a = $this->pnb_upload_files($_FILES['attach_file'],$path='./qa_files/qa_paynearby/');
				$field_array["attach_file"] = implode(',',$a);

				$rowid= data_inserter('qa_paynearby_feedback',$field_array);
				redirect('Qa_paynearby');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	public function mgnt_paynearby_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/mgnt_paynearby_rvw.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["paynearby_feedback"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$id;

			$qSql="Select * FROM qa_paynearby_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE

			$qSql="Select * FROM qa_paynearby_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE

		///////Edit Part///////
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

				$field_array = array(
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer" => $this->input->post('customer'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"grade" => $this->input->post('grade'),
					"overall_score" => $this->input->post('overall_score'),
					"opening_greeting" => $this->input->post('opening_greeting'),
					"initial_empathy" => $this->input->post('initial_empathy'),
					"agent_query" => $this->input->post('agent_query'),
					"proper_telephone" => $this->input->post('proper_telephone'),
					"ivr_promotion" => $this->input->post('ivr_promotion'),
					"efective_rebuttal" => $this->input->post('efective_rebuttal'),
					"fraud_alert" => $this->input->post('fraud_alert'),
					"sentence_acknowledge" => $this->input->post('sentence_acknowledge'),
					"polite_call" => $this->input->post('polite_call'),
					"good_behaviour" => $this->input->post('good_behaviour'),
					"good_listening" => $this->input->post('good_listening'),
					"not_interrupt" => $this->input->post('not_interrupt'),
					"proper_empathy" => $this->input->post('proper_empathy'),
					"proper_pace" => $this->input->post('proper_pace'),
					"agent_patience" => $this->input->post('agent_patience'),
					"energy_enthusias" => $this->input->post('energy_enthusias'),
					"confident_level" => $this->input->post('confident_level'),
					"error_fumbling" => $this->input->post('error_fumbling'),
					"dead_air" => $this->input->post('dead_air'),
					"dragged_call" => $this->input->post('dragged_call'),
					"rude_language" => $this->input->post('rude_language'),
					"exact_tat" => $this->input->post('exact_tat'),
					"wrong_provide" => $this->input->post('wrong_provide'),
					"correct_tagging" => $this->input->post('correct_tagging'),
					"minor_error" => $this->input->post('minor_error'),
					"satisfy_rapport" => $this->input->post('satisfy_rapport'),
					"closing_script" => $this->input->post('closing_script'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_paynearby_feedback',$field_array);

			////////////
				$field_array1=array(
					"fd_id" => $pnid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);

				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_paynearby_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pnid);
					$this->db->update('qa_paynearby_mgnt_rvw',$field_array1);
				}
			///////////
				redirect('Qa_paynearby');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////

	public function agent_paynearby_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/agent_paynearby_feedback.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";
			$data["content_js"] = "qa_pnb_outbound_sales_v1_js.php";


			$qSql="Select count(id) as value from qa_paynearby_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_paynearby_feedback where id not in (select fd_id from qa_paynearby_agent_rvw) and agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";

			$campaign = $this->input->get('campaign');

			if($campaign!=''){
				if($this->input->get('btnView')=='View'){

					if($campaign=='inbound'){
						$qSql1="Select count(id) as value from qa_paynearby_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_feedback where id not in (select fd_id from qa_paynearby_agent_rvw) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=='inbound_new'){
					$qSql1="Select count(id) as value from qa_pnb_inbound_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_pnb_inbound_new_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=='pnb_outbound_new'){
						$qSql1="Select count(id) as value from qa_pnb_outbound_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_pnb_outbound_new_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if ($campaign=="new_inb") {
						$qSql1="Select count(id) as value from qa_pnb_new_inb_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_pnb_new_inb_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=="new_kyc_inb"){
						$qSql1="Select count(id) as value from qa_pnb_new_kyc_inb_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_pnb_new_kyc_inb_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=="new_outbound"){
						$qSql1="Select count(id) as value from qa_paynearby_outbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_outbound_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=="new_one_outbound"){
						$qSql1="Select count(id) as value from qa_paynearby_outbound_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_outbound_new_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=="new_email"){
						$qSql1="Select count(id) as value from qa_paynearby_new_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_new_email_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=="new_social"){
						$qSql1="Select count(id) as value from qa_paynearby_new_social_media_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_new_social_media_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else if($campaign=="pnb_ob_sales_v1"){
						$qSql1="Select count(id) as value from qa_pnb_outbound_sales_v1_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
						$qSql2="Select count(id) as value from qa_pnb_outbound_sales_v1_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
					}else{
						$qSql1="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
						$qSql2="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}
					$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
					$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);

				///////////

					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);

					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);

					if($fromDate !="" && $toDate!=="" ){
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else{
						$cond= " Where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}


					if($campaign=='inbound'){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, agnt_fd_acpt, note as agent_rvw_note, date(entry_date) as agent_rvw_date from qa_paynearby_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_rvw_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_rvw_name from qa_paynearby_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
					}else if($campaign=='inbound_new'){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_inbound_new_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=='pnb_outbound_new'){
                       $agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_outbound_new_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=="new_inb"){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_new_inb_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=="new_kyc_inb"){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_new_kyc_inb_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=="new_outbound"){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_outbound_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=="new_one_outbound"){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_outbound_new_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=="new_email"){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_new_email_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=="new_social"){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_new_social_media_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else if($campaign=="pnb_ob_sales_v1"){
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_outbound_sales_v1_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else{
						$agnt_fd = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}

					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($agnt_fd);

				}
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;

			$this->load->view('dashboard',$data);
		}
	}


	public function agent_paynearby_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/agent_paynearby_rvw.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";

			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_paynearby_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["paynearby_feedback"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$id;

			$qSql="Select * FROM qa_paynearby_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE

			$qSql="Select * FROM qa_paynearby_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE


			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

				$field_array1=array(
					"fd_id" => $pnid,
					"note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);

				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_paynearby_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pnid);
					$this->db->update('qa_paynearby_agent_rvw',$field_array1);
				}
				redirect('Qa_paynearby/agent_paynearby_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_paynearby_ob_rvw($id,$campaign){

		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			if($campaign=='pnb_email'){
            $data["content_template"] = "qa_paynearby/agent_paynearby_ob_row_view.php";
			}else {
			$data["content_template"] = "qa_paynearby/agent_paynearby_ob_rvw.php";
		    }
			$data["campaign"]=$campaign;
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";
			if($campaign=='inbound_new'){
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_inbound_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			} else if($campaign=='pnb_outbound_new'){
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_outbound_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
		    }else if($campaign=='pnb_ob_sales_v1'){
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_outbound_sales_v1_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
		    }  else {
		    $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
		    }

			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$id;
		    //$data["campaign"]=$campaign;


			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				if($campaign=='inbound_new'){
				$this->db->update('qa_pnb_inbound_new_feedback',$field_array);
				}else if($campaign=='pnb_outbound_new'){
				$this->db->update('qa_pnb_outbound_new_feedback',$field_array);
				}else if($campaign=='pnb_ob_sales_v1'){
				$this->db->update('qa_pnb_outbound_sales_v1_feedback',$field_array);
				}else {
				$this->db->update('qa_paynearby_'.$campaign.'_feedback',$field_array);
			    }

				redirect('qa_paynearby/agent_paynearby_feedback'.'?from_date=&to_date=&campaign=pnb_email&btnView=View');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// CLOSELOOP //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function clientId(){
    	return $clientId= array(115);
    }

    public function processId(){
    	return $processId=array(459);
    }

    ///////////////// Process wise processName part//////////////////////////

    public function processName(){
    	return array("closeloop");
    }

    ///////////////// Process wise processName end part//////////////////////////



    ///////////////// Agent Name process part//////////////////////////


    public function agentName(){

    		$processId=$this->processId();
    		$clientId=$this->clientId();

    		$countClient=count($clientId);
    		$countProcess=count($processId);

    		$clientInAgent="";
    		$ProcessInAgent="";

    		if (!empty($clientId)) {
	    		if($countClient<=1){
	    			$clientInAgent=" and  is_assign_client (id,$clientId[0]) ";
			    }else{
	    			$clientInAgent=" and  is_assign_client (id,$clientId[0]) ";
		    		for($i=1;$i<$countClient;$i++){
		    			$clientInAgent.=" or is_assign_client (id,$clientId[$i])";
		    		}
		    	}
    		}

    		if (!empty($processId)) {
	    		if($countProcess<=1){
	    			$ProcessInAgent=" or  is_assign_process (id,$processId[0]) ";
			    }else{
	    			$ProcessInAgent=" or  is_assign_process (id,$processId[0]) ";
		    		for($i=1;$i<$countProcess;$i++){
		    			$ProcessInAgent.=" or is_assign_process (id,$processId[$i])";
		    		}
		    	}
    		}

    		if(check_logged_in())
		{
			$current_user = get_user_id();

    		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user')) and ";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" where assigned_to='$current_user' and ";
			}else{
				$ops_cond=" where ";
			}

    		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin`  ".$ops_cond." dept_id=6 ".$clientInAgent.$ProcessInAgent."  and status=1  order by name";
    	}

			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			return $this->Common_model->get_query_result_array($qSql);
    }

	///////////////// Agent Name process end part//////////////////////////

	    ///////////////// Dynamic process part//////////////////////////

    public function process($parm="",$formparam="",$table=""){

		if ($parm=="add") {
			$this->add_process($formparam,$table);
		}elseif ($parm=="mgnt_rvw") {
			$this->mgnt_process_rvw($formparam,$table);
		}elseif($parm=="agent"){
			$this->agent_process_feedback();
		}elseif($parm=="agnt_feedback"){
			$this->agent_process_rvw($formparam,$table);
		}

	}

		///////////////// Dynamic process end part//////////////////////////

    ///////////////// QA Feedback process part//////////////////////////

    public function serviceName(){
		return "closeloop";
	}


	public function closeloop(){
		if(check_logged_in())
		{
			$page=$this->serviceName();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/qa_".$page."_feedback.php";
			$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			$data['processName']=$this->processName();
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

			/* and is_assign_process (id,66) or is_assign_process (id,123) */

			$data["agentName"] = $this->agentName();
		////////////////////////
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id!=""){
				$agent_id_arr=implode("','", $agent_id);
				$cond .=" and agent_id in ('$agent_id_arr')";
			}

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}

		///////////////////

			$processName=$this->processName();
			$processCnt=count($processName);
			$page=$this->serviceName();
			if(!empty($processCnt)){

				if($processCnt<=1){

					$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$page."_feedback $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
					$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);

				}else{

					for($i=0;$i<$processCnt;$i++){

						$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$page."_".$processName[$i]."_feedback $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
						$data[$page."_".$processName[$i]."_new_data"] = $this->Common_model->get_query_result_array($qSql);

					}

				}

			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);

		}
	}

	///////////////// QA Feedback process end part//////////////////////////

	///////////////// ADD process part//////////////////////////

	public function add_process($stratAuditTime,$table){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/".$table."/add_".$table.".php";
			$data["content_js"] = "qa_".$page."_js.php";
			$processName=$this->processName();
			$data['titleVal']=$this->closeloopTitleVal();
			$data['rowspanVal']=$this->closeloopTitleRowSpanVal();
			$processCnt=count($processName);
			if(!empty($processCnt)){

				if($processCnt<=1){
						$table=$page;
						$tableTemp=$table;
						$data["page"]=$table;
						$columname=$page."_columnname";
						$scoreParametername="parameter_".$page."_scrorecard_details";
						$scoreVal=$page."ScoreVal";
						$scoreCardFunc=$page."ScoreCardFunc";
						$titleVal=$page."TitleVal";
						$rowspanVal=$page."TitleRowSpanVal";
						$autofail=$page."AutoFailParam";
						$busiCompCustScore=$page."BusiCompCustScore";
						$nonSelectTDDetails=$page."NonSelectTDDetails";
						$paramId=$page."ParamId";
						$data["paramId"]=$this->$paramId();
						$data["autofail"]=$this->$autofail();
						$data["busiCompCustScore"]=$this->$busiCompCustScore();
						$data["nonSelectTDDetails"]=$this->$nonSelectTDDetails();
						$data['titleVal']=$this->$titleVal();
						$data['rowspanVal']=$this->$rowspanVal();
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data['paramCount']=count($data["scoreParametername"]);
						$data["scoreVal"]=$this->$scoreVal();
						$data["scoreCardFunc"]=$this->$scoreCardFunc();
				}else{

					if(in_array($table, $processName)){
						$tableTemp=$table;
						$table=$page."_".$tableTemp;
						$data["page"]=$table;
						$columname=$tableTemp."_columnname";
						$scoreParametername="parameter_".$tableTemp."_scrorecard_details";
						$scoreVal=$tableTemp."ScoreVal";
						$scoreCardFunc=$tableTemp."ScoreCardFunc";
						$titleVal=$tableTemp."TitleVal";
						$rowspanVal=$tableTemp."TitleRowSpanVal";
						$autofail=$tableTemp."AutoFailParam";
						$busiCompCustScore=$tableTemp."BusiCompCustScore";
						$nonSelectTDDetails=$tableTemp."NonSelectTDDetails";
						$paramId=$tableTemp."ParamId";
						$data["paramId"]=$this->$paramId();
						$data["autofail"]=$this->$autofail();
						$data["busiCompCustScore"]=$this->$busiCompCustScore();
						$data["nonSelectTDDetails"]=$this->$nonSelectTDDetails();
						$data['titleVal']=$this->$titleVal();
						$data['rowspanVal']=$this->$rowspanVal();
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data['paramCount']=count($data["scoreParametername"]);
						$data["scoreVal"]=$this->$scoreVal();
						$data["scoreCardFunc"]=$this->$scoreCardFunc();
					}
				}
			}


			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->agentName();

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["stratAuditTime"]=$stratAuditTime;
			$curDateTime=CurrMySqlDate();
			$a = array();
			// print_r($data['scoreVal']);
			// die;
			$data["scoreCard1"]=$this->scoreCard1();
			$data["scoreCard2"]=$this->scoreCard2();
			$data["scoreCard3"]=$this->scoreCard3();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->mt_upload_files($_FILES['attach_file'],$tableTemp);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_paynearby_'.$table.'_feedback',$field_array);
				redirect('Qa_paynearby/'.$page);
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	///////////////// ADD process end part//////////////////////////

	///////////////// UPLOAD FILE with path existance checking part//////////////////////////

	private function mt_upload_files($files,$table)
    {
        $path = './qa_files/qa_paynearby/'.$table;
        $result=$this->createPath($path);
        // print_r($result);
        // die;
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

    ///////////////// UPLOAD FILE with path existance checking end part//////////////////////////

    ///////////////// Mgnt process part//////////////////////////

	public function mgnt_process_rvw($id,$table){

		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/".$table."/mgnt_".$table."_rvw.php";
			$data["content_js"] = "qa_".$page."_js.php";
			$data['titleVal']=$this->closeloopTitleVal();
			$data['rowspanVal']=$this->closeloopTitleRowSpanVal();
			$processName=$this->processName();
			$processCnt=count($processName);
			if(!empty($processCnt)){

				if($processCnt<=1){
						$table=$page;
						$tableTemp=$table;
						$data["page"]=$table;
						$columname=$page."_columnname";
						$scoreParametername="parameter_".$page."_scrorecard_details";
						$scoreVal=$page."ScoreVal";
						$scoreCardFunc=$page."ScoreCardFunc";
						$titleVal=$page."TitleVal";
						$rowspanVal=$page."TitleRowSpanVal";
						$autofail=$page."AutoFailParam";
						$busiCompCustScore=$page."BusiCompCustScore";
						$nonSelectTDDetails=$page."NonSelectTDDetails";
						$paramId=$page."ParamId";
						$data["paramId"]=$this->$paramId();
						$data["autofail"]=$this->$autofail();
						$data["busiCompCustScore"]=$this->$busiCompCustScore();
						$data["nonSelectTDDetails"]=$this->$nonSelectTDDetails();
						$data['titleVal']=$this->$titleVal();
						$data['rowspanVal']=$this->$rowspanVal();
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data['paramCount']=count($data["scoreParametername"]);
						$data["scoreVal"]=$this->$scoreVal();
						$data["scoreCardFunc"]=$this->$scoreCardFunc();
				}else{

					if(in_array($table, $processName)){
						$tableTemp=$table;
						$table=$page."_".$tableTemp;
						$data["page"]=$table;
						$columname=$tableTemp."_columnname";
						$scoreParametername="parameter_".$tableTemp."_scrorecard_details";
						$scoreVal=$tableTemp."ScoreVal";
						$scoreCardFunc=$tableTemp."ScoreCardFunc";
						$titleVal=$tableTemp."TitleVal";
						$rowspanVal=$tableTemp."TitleRowSpanVal";
						$autofail=$tableTemp."AutoFailParam";
						$busiCompCustScore=$tableTemp."BusiCompCustScore";
						$nonSelectTDDetails=$tableTemp."NonSelectTDDetails";
						$paramId=$tableTemp."ParamId";
						$data["paramId"]=$this->$paramId();
						$data["autofail"]=$this->$autofail();
						$data["busiCompCustScore"]=$this->$busiCompCustScore();
						$data["nonSelectTDDetails"]=$this->$nonSelectTDDetails();
						$data['titleVal']=$this->$titleVal();
						$data['rowspanVal']=$this->$rowspanVal();
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data['paramCount']=count($data["scoreParametername"]);
						$data["scoreVal"]=$this->$scoreVal();
						$data["scoreCardFunc"]=$this->$scoreCardFunc();
					}
				}
			}

			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->agentName();

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['scoreCard1']=$this->scoreCard1();
			$data['scoreCard2']=$this->scoreCard2();
			$data['scoreCard3']=$this->scoreCard3();

			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$table."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$table."_new"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$id;

		///////Edit Part///////
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				$file_str="";



				$field_array=$this->input->post('data');
				$this->db->where('id', $pnid);
				$this->db->update('qa_paynearby_'.$table.'_feedback',$field_array);

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
				$this->db->update('qa_paynearby_'.$table.'_feedback',$field_array1);

				redirect('Qa_paynearby/'.$page);

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	///////////////// Mgnt process end part//////////////////////////


	///////////////////////// Agent feedback RVW ////////////////////////////

	public function agent_process_rvw($id,$table){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/".$table."/agent_".$table."_rvw.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			$data['titleVal']=$this->closeloopTitleVal();
			$data['rowspanVal']=$this->closeloopTitleRowSpanVal();
			$processName=$this->processName();
			$processCnt=count($processName);
			if(!empty($processCnt)){

				if($processCnt<=1){
						$table=$page;
						$tableTemp=$table;
						$data["page"]=$table;
						$columname=$page."_columnname";
						$scoreParametername="parameter_".$page."_scrorecard_details";
						$scoreVal=$page."ScoreVal";
						$scoreCardFunc=$page."ScoreCardFunc";
						$titleVal=$page."TitleVal";
						$rowspanVal=$page."TitleRowSpanVal";
						$autofail=$page."AutoFailParam";
						$busiCompCustScore=$page."BusiCompCustScore";
						$nonSelectTDDetails=$page."NonSelectTDDetails";
						$paramId=$page."ParamId";
						$data["paramId"]=$this->$paramId();
						$data["autofail"]=$this->$autofail();
						$data["busiCompCustScore"]=$this->$busiCompCustScore();
						$data["nonSelectTDDetails"]=$this->$nonSelectTDDetails();
						$data['titleVal']=$this->$titleVal();
						$data['rowspanVal']=$this->$rowspanVal();
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data['paramCount']=count($data["scoreParametername"]);
						$data["scoreVal"]=$this->$scoreVal();
						$data["scoreCardFunc"]=$this->$scoreCardFunc();
				}else{

					if(in_array($table, $processName)){
						$tableTemp=$table;
						$table=$page."_".$tableTemp;
						$data["page"]=$table;
						$columname=$tableTemp."_columnname";
						$scoreParametername="parameter_".$tableTemp."_scrorecard_details";
						$scoreVal=$tableTemp."ScoreVal";
						$scoreCardFunc=$tableTemp."ScoreCardFunc";
						$titleVal=$tableTemp."TitleVal";
						$rowspanVal=$tableTemp."TitleRowSpanVal";
						$autofail=$tableTemp."AutoFailParam";
						$busiCompCustScore=$tableTemp."BusiCompCustScore";
						$nonSelectTDDetails=$tableTemp."NonSelectTDDetails";
						$paramId=$tableTemp."ParamId";
						$data["paramId"]=$this->$paramId();
						$data["autofail"]=$this->$autofail();
						$data["busiCompCustScore"]=$this->$busiCompCustScore();
						$data["nonSelectTDDetails"]=$this->$nonSelectTDDetails();
						$data['titleVal']=$this->$titleVal();
						$data['rowspanVal']=$this->$rowspanVal();
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data['paramCount']=count($data["scoreParametername"]);
						$data["scoreVal"]=$this->$scoreVal();
						$data["scoreCardFunc"]=$this->$scoreCardFunc();
					}
				}
			}

			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_paynearby_".$table."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";

			$data[$table."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$id;
			$data['scoreCard1']=$this->scoreCard1();
			$data['scoreCard2']=$this->scoreCard2();
			$data['scoreCard3']=$this->scoreCard3();

			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_paynearby_'.$table.'_feedback',$field_array);

				redirect('Qa_paynearby/agent_paynearby_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	////////////////////////  Agent feedback end RVW ///////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// OUTBOUND vikas //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function paynearby_outbound(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/qa_paynearby_outbound_feedback.php";
			$data["content_js"] = "qa_pnb_outbound_sales_v1_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
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
			if($agent_id!=""){
				$agent_id_arr=implode("','", $agent_id);
				$cond .=" and agent_id in ('$agent_id_arr')";
			}

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_outbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on
				(xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_outbound"] = $this->Common_model->get_query_result_array($qSql);

			$qSql_new = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_outbound_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on
				(xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_outbound_new"] = $this->Common_model->get_query_result_array($qSql_new);

			$qSql_new = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_pnb_outbound_sales_v1_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on
				(xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_outbound_sales_v1"] = $this->Common_model->get_query_result_array($qSql_new);

		//////////
			/* $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_sales_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_ob_sales"] = $this->Common_model->get_query_result_array($qSql);
		//////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_service_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_ob_service"] = $this->Common_model->get_query_result_array($qSql);
			//Nilkanta
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_pnb_outbound_new_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_pnb_outbound"] = $this->Common_model->get_query_result_array($qSql); */

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_ob_sales($sales_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_ob_sales.php";
			$data['sales_id']=$sales_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_sales_feedback where id='$sales_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ob_sales"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('agent_id')){

				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"customer" => $this->input->post('customer'),
					"call_duration" => $this->input->post('call_duration'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"standart_call_opening" => $this->input->post('standart_call_opening'),
					"explain_about_product" => $this->input->post('explain_about_product'),
					"correct_tagging" => $this->input->post('correct_tagging'),
					"necessary_probing" => $this->input->post('necessary_probing'),
					"sales_picher" => $this->input->post('sales_picher'),
					"active_listening" => $this->input->post('active_listening'),
					"assurance_acknowledge" => $this->input->post('assurance_acknowledge'),
					"tone_modulation" => $this->input->post('tone_modulation'),
					"dragging_stammering" => $this->input->post('dragging_stammering'),
					"closing_procedure" => $this->input->post('closing_procedure'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);


				if($sales_id==0){

					$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/outbound/sales/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_ob_sales_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array1);

				}else{
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/outbound/sales/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $sales_id);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array);
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
					$this->db->where('id', $sales_id);
					$this->db->update('qa_paynearby_ob_sales_feedback',$field_array1);

				}

				redirect('qa_paynearby/paynearby_outbound');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_ob_service($service_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_ob_service.php";
			$data['service_id']=$service_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_ob_service_feedback where id='$service_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ob_service"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('agent_id')){

				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"customer" => $this->input->post('customer'),
					"call_duration" => $this->input->post('call_duration'),
					"incoming_no" => $this->input->post('incoming_no'),
					"register_no" => $this->input->post('register_no'),
					"call_link" => $this->input->post('call_link'),
					"ticket_no" => $this->input->post('ticket_no'),
					"call_disconnect_by" => $this->input->post('call_disconnect_by'),
					"tagging" => $this->input->post('tagging'),
					"query_service" => $this->input->post('query_service'),
					"call_type" => $this->input->post('call_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"standard_call_opening" => $this->input->post('standard_call_opening'),
					"necessary_probing" => $this->input->post('necessary_probing'),
					"explain_about_BNB_Amazon" => $this->input->post('explain_about_BNB_Amazon'),
					"explain_about_Flipkart" => $this->input->post('explain_about_Flipkart'),
					"wrong_call_information" => $this->input->post('wrong_call_information'),
					"active_listening" => $this->input->post('active_listening'),
					"rappo_building" => $this->input->post('rappo_building'),
					"tone_modulation" => $this->input->post('tone_modulation'),
					"dragging_stammering" => $this->input->post('dragging_stammering'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);


				if($service_id==0){

					$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/outbound/service/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_ob_service_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array1);

				}else{
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/outbound/service/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $service_id);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array);
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
					$this->db->where('id', $service_id);
					$this->db->update('qa_paynearby_ob_service_feedback',$field_array1);

				}

				redirect('qa_paynearby/paynearby_outbound');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// EMAIL //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function paynearby_email(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/qa_paynearby_email_feedback.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
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
			if($agent_id!=""){
				$agent_id_arr=implode("','", $agent_id);
				$cond .=" and agent_id in ('$agent_id_arr')";
			}

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_new_email_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_email"] = $this->Common_model->get_query_result_array($qSql);
		/////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_new_social_media_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_social"] = $this->Common_model->get_query_result_array($qSql);
		//////////////////
			/* $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_email_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["paynearby_email"] = $this->Common_model->get_query_result_array($qSql); */
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

  //Edited By Samrat 30/12/2021
  public function add_edit_pnb_email($email_id){
    if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_new_email.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['email_id']=$email_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6  and status=1 and is_assign_client(id,115) order by name";
			/* and is_assign_client(id,134) and is_assign_process(id,377) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_new_email_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["pnb_email"] = $this->Common_model->get_query_row_array($qSql);


			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($email_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					if(!file_exists("./qa_files/qa_pnb_new_email/")){
						mkdir("./qa_files/qa_pnb_new_email/");
					}

					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_pnb_new_email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_new_email_feedback',$field_array);

					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_new_email_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->edu_upload_files($_FILES['attach_file'],$path='./qa_files/qa_pnb_new_email/');
					$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_new_email_feedback',$field_array1);
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
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_new_email_feedback',$edit_array);

				}
				redirect('Qa_paynearby/paynearby_email');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
  }

	public function add_edit_pbn_email($email_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pbn_email.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['email_id']=$email_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_pnb_email_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["pnb_email"] = $this->Common_model->get_query_row_array($qSql);


			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($email_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_pnb_email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_pnb_email_feedback',$field_array);

					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_pnb_email_feedback',$add_array);

				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->edu_upload_files($_FILES['attach_file'],$path='./qa_files/qa_pnb_email/');
					$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_pnb_email_feedback',$field_array1);
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
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_pnb_email_feedback',$edit_array);

				}
				redirect('Qa_paynearby/paynearby_email');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_email($email_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_email.php";
			$data['email_id']=$email_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_email_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["paynearby_email"] = $this->Common_model->get_query_row_array($qSql);

			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('agent_id')){

				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"mail_action_date" => mmddyy2mysql($this->input->post('mail_action_date')),
					"tat_replied_date" => mmddyy2mysql($this->input->post('tat_replied_date')),
					"status" => $this->input->post('status'),
					"tat" => $this->input->post('tat'),
					"email_no" => $this->input->post('email_no'),
					"msisdn" => $this->input->post('msisdn'),
					"email_id" => $this->input->post('email_id'),
					"interaction_id" => $this->input->post('interaction_id'),
					"category" => $this->input->post('category'),
					"sub_category" => $this->input->post('sub_category'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_query_answer" => $this->input->post('customer_query_answer'),
					"correct_process_follow" => $this->input->post('correct_process_follow'),
					"accurate_resolution_given" => $this->input->post('accurate_resolution_given'),
					"missing_details_for_CSE_call" => $this->input->post('missing_details_for_CSE_call'),
					"not_given_complete_solution" => $this->input->post('not_given_complete_solution'),
					"product_process_knowledge" => $this->input->post('product_process_knowledge'),
					"empathy_statement_use" => $this->input->post('empathy_statement_use'),
					"grammatical_error" => $this->input->post('grammatical_error'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);


				if($email_id==0){

					$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_paynearby_email_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_email_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_email_feedback',$field_array1);

				}else{
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->pnb_upload_files($_FILES['attach_file'], $path='./qa_files/qa_paynearby/email/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_email_feedback',$field_array);
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
					$this->db->where('id', $email_id);
					$this->db->update('qa_paynearby_email_feedback',$field_array1);

				}
				redirect('qa_paynearby/paynearby_email');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	// public function createPath($path){

	// 	if (!empty($path)) {

	//     	if(!file_exists($path)){

	//     		$mainPath="./";
	//     		$checkPath=str_replace($mainPath,'', $path);
	//     		$checkPath=explode("/",$checkPath);
	//     		$cnt=count($checkPath);
	//     		for($i=0;$i<$cnt;$i++){

	// 	    		$mainPath.=$checkPath[$i].'/';
	// 	    		if (!file_exists($mainPath)) {
	// 	    			$oldmask = umask(0);
	// 					$mkdir=mkdir($mainPath, 0777);
	// 					umask($oldmask);

	// 					if ($mkdir) {
	// 						return true;
	// 					}else{
	// 						return false;
	// 					}
	// 	    		}

	//     		}

 //    		}else{
 //    			return true;
 //    		}
 //    	}
	// }


	public function scoreCard1(){
    	return $arrayName = array('YES','NO');
    }

    public function scoreCard2(){
    	return $arrayName = array('YES','NO','N/A');
    }

    public function scoreCard3(){
    	return $arrayName = array('YES','NO','FATAL');
    }

    public function closeloopScoreVal(){
    	return $arrayName = array(2,3,3,5,0,10,5,12,15,0,0,0,10,5,10,10,5,5);
    }

    public function closeloopScoreCardFunc(){
    	return $arrayName = array(1,2,2,1,1,3,1,3,1,2,1,1,2,1,3,2,2,2);
    }

    public function closeloop_columnname(){
    	return array("Opening_Greeting","Agent_Probing","Telephone_Etiquettes","Listening_Skills","TAT_Team","Call_Arguments","Agent_Patience","Correct_provided","Tagging_Dispositions","Feedback_service","BO_Resolution","SR_not","Empathy_Required","Agent_Maintained","Raised_Ticket","Effective_Rebuttals","Informed_agent","Closing_Script");
    }

    public function closeloopTitleVal(){
    	return array(0=>"Paynear By Close looping CQ Audit Sheet");
    }

    public function closeloopTitleRowSpanVal(){
    	return array(0=>18);
    }

    public function closeloopAutoFailParam(){
    	return array("Call_Arguments","Correct_provided","Raised_Ticket");
    }

    public function closeloopBusiCompCustScore(){
    	return array();
    }

    public function closeloopParamId(){
    	return array();
    }

    public function closeloopNonSelectTDDetails(){
    	return array();
    }

    public function parameter_closeloop_comments_details(){
    	return array("Opening With Greeting (Incl Late Opening/Name Confirmation)","Did Agent Understood The Query & Necessary Probing Done","Followed Proper Telephone Etiquettes (Mute Hold Transfer)","Good In Listening/Repetition Not Happened Due To Lack In Listening Skills/Attentive","Was ticket closed with in TAT by BO Team","Did The Agent Was Polite On Call/Not Done Arguments/Professional","Did The Agent Have Patience","Correct and complete resolution provided on call","Tagging and Dispositions","Feedback on PNB service","BO Provide correct Resolution or not","Was customer proper SR raised or not","Proper Empathy Done Whenever Required","Did The Agent Maintained Proper Pace/Tone Modulation/Clarity In Speech","Was Correct Tagging Done/Raised Proper Ticket when ever required","Effective Rebuttals On Objection Handling/Convincing Skills","Was Exact Tat Informed by agent","Did The Agent Followed Proper Call Closing Script As Per Process");
    }

    public function parameter_closeloop_scrorecard_details(){
    	return array("Opening With Greeting (Incl Late Opening/Name Confirmation)","Did Agent Understood The Query & Necessary Probing Done","Followed Proper Telephone Etiquettes (Mute Hold Transfer)","Good In Listening/Repetition Not Happened Due To Lack In Listening Skills/Attentive","Was ticket closed with in TAT by BO Team","Did The Agent Was Polite On Call/Not Done Arguments/Professional","Did The Agent Have Patience","Correct and complete resolution provided on call","Tagging and Dispositions","Feedback on PNB service","BO Provide correct Resolution or not","Was customer proper SR raised or not","Proper Empathy Done Whenever Required","Did The Agent Maintained Proper Pace/Tone Modulation/Clarity In Speech","Was Correct Tagging Done/Raised Proper Ticket when ever required","Effective Rebuttals On Objection Handling/Convincing Skills","Was Exact Tat Informed by agent","Did The Agent Followed Proper Call Closing Script As Per Process");  /// not required for english lang
    }

	/* public function agent_paynearby_ob_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/agent_paynearby_ob_feedback.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_ob_feedback";

			$from_date = '';
			$to_date = '';
			$campaign='';
			$cond="";

			$campaign = $this->input->get('campaign');


			if($campaign!=''){

				$qSql="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				$data["tot_ob_feedback"] =  $this->Common_model->get_single_value($qSql);

				$qSql="Select count(id) as value from qa_paynearby_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				$data["yet_ob_rvw"] =  $this->Common_model->get_single_value($qSql);


				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);

					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);

					if($fromDate !="" && $toDate!=="" ){
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}

					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);
				}
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	} */



///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// QA Paynearby REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_paynearby_report(){
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
			$data["content_template"] = "qa_paynearby/qa_paynearby_report.php";

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";

			$campaign = $this->input->get('campaign');

			$data["qa_paynearby_list"] = array();

			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				//$dt_frm = getEstToLocal($date_from,agent_id);

				$date_to = mmddyy2mysql($this->input->get('date_to'));
				//$dt_to = getEstToLocal($date_to,agent_id);

				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');

				if($date_from !="" && $date_to!=="" )  $cond= " Where (getLocalToEST(audit_date,agent_id) >= '$date_from' and getLocalToEST(audit_date,agent_id) <= '$date_to' ) ";

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";

				if($audit_type=="All") $cond .= "";
				else $cond .=" and audit_type='$audit_type'";

				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else if(get_login_type()=="client"){
					$cond1 .=" And audit_type not in ('Operation Audit','Trainer Audit')";
				}else{
					$cond1 .="";
				}

				if($campaign=='inbound'){
					$qSql="SELECT P.*,
						CONCAT(CASE WHEN P.entry_by = S.id THEN S.fname END, ' ', CASE WHEN P.entry_by = S.id THEN S.lname END) AS auditor_name,
						CONCAT(CASE WHEN P.tl_id = S.id THEN S.fname END, ' ', CASE WHEN P.tl_id = S.id THEN S.lname END) AS tl_name,
						S.id AS sid, S.fname, S.lname, S.fusion_id, S.office_id, GET_PROCESS_NAMES(S.id) AS campaign, DATEDIFF(CURDATE(), S.doj) AS tenure, S.assigned_to, PAR.fd_id, PAR.agnt_fd_acpt, PAR.note AS agent_note, DATE(PAR.entry_date) AS agent_rvw_date, PMR.fd_id AS mgnt_fd_id, PMR.note AS mgnt_note,  DATE(PMR.entry_date) AS mgnt_rvw_date,  PMR.entry_by AS mgnt_entry_by,
						CONCAT(CASE WHEN PMR.entry_by = S.id THEN S.fname END, ' ', CASE WHEN PMR.entry_by = S.id THEN S.lname END) AS mgnt_name
						FROM
						qa_paynearby_feedback P LEFT JOIN
						signin S ON P.agent_id = S.id LEFT JOIN
						qa_paynearby_agent_rvw PAR ON P.id = PAR.fd_id LEFT JOIN
						qa_paynearby_mgnt_rvw PMR ON P.id = PMR.fd_id
						$cond $cond1 order by audit_date";
				}else if($campaign=='inbound_new'){
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_inbound_new_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";

                }else if($campaign=='outbound_new'){
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_outbound_new_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";

				}else if($campaign=="new_inb"){
          $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_new_inb_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
        }else if($campaign=="new_kyc_inb"){
          $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_pnb_new_kyc_inb_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
        }else if($campaign=="new_outbound"){
          $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_outbound_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
        }else if($campaign=="new_email"){
          $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_new_email_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
        }else if($campaign=="new_social"){
          $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_new_social_media_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
        }else{
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_paynearby_".$campaign."_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				}

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_paynearby_list"] = $fullAray;
				$this->create_qa_paynearby_CSV($fullAray,$campaign);
				$dn_link = base_url()."qa_paynearby/download_qa_paynearby_CSV/".$campaign;

			}

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			$data['office_id']=$office_id;
			$data['campaign']=$campaign;
			$data['audit_type']=$audit_type;

			$this->load->view('dashboard',$data);
		}
	}


	public function download_qa_paynearby_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		if($campaign=='inbound'){
			$pnb_hdr='Paynearby Inbound';
		}else if($campaign=='inbound_new'){
			$pnb_hdr='Paynearby Inbound [New]';
		}else if($campaign=='outbound_new'){
			$pnb_hdr='Paynearby Outbound [New]';
		}else if($campaign=='ob_sales'){
			$pnb_hdr='Paynearby Outbound - Sales';
		}else if($campaign=='ob_service'){
			$pnb_hdr='Paynearby Outbound - Service';
		}else if($campaign=='pnb_email'){
			$pnb_hdr='Paynearby PNB Email';
		}else if($campaign=='email'){
			$pnb_hdr='Paynearby Email(Old)';
		}else if($campaign=="new_inb"){
      $pnb_hdr="Paynearby Inbound";
    }else if($campaign=="new_kyc_inb"){
      $pnb_hdr="Paynearby KYC Inbound";
    }else if($campaign=="new_email"){
      $pnb_hdr="Paynearby Email";
    }else if($campaign=="new_social"){
      $pnb_hdr="Paynearby Social Media";
    }else if($campaign=="new_outbound"){
      $pnb_hdr="Paynearby Outbound";
    }

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$pnb_hdr." Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_paynearby_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		if($campaign=='inbound'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Opening with Greeting (incl late opening/Name confirmation)", "Initial Empathy with Assurance statement done", "DID AGENT UNDERSTOOD THE QUERY & NECESSARY PROBING DONE", "Followed proper Telephone etiquettes (mute hold transfer)", "IVR Promotion done", "Effective rebuttals on Objection Handling/Convincing skills", "Fraud Alert Message informed", "Appropriate sentences and acknowledgment used on call", "Did the Agent was Polite on call/Not done Arguments/Professional", "Good Behavior/Willingness", "Good in listening/Repetition not happened due to lack in listening skills/Attentive", "Not interrupted", "Proper Empathy done whenever required", "Did the agent maintained Proper Pace/tone modulation/clarity in speech", "Did the agent have Patience", "Energy/Enthusiasm", "Confidence Level", "Grammatical errors/Fumbling/Fillers", "No Dead Air found", "Not Dragged the call", "Rude flirting foul language Abusive with customer not happened", "Was Exact TAT informed (Not less than Actual)", "Not provided Wrong information on call", "Was Correct tagging done/raised proper ticket", "Not having (Minor Errors in Comments/Sub dispositions)", "Customer satisfied/Rapport building done", "Did the agent followed Proper call closing Script as per process", "Overall Score", "Grade", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='inbound_new'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Agent addressed and answered all customer queries.","Contextual Awareness: Agent checked the ticket history (parent-child if any)/referred to relevant attachments/ probing.","Agent shared the correct resolution.","Empathy/Apologies.","Assurance(Power Statement) / Paraphrasing/ Comprehension/ Acknowledgement.","Correct sentence Formation with appropriate salutation.","Rate of Speech/ Speech of Clarity/Tone & Manner.","Pronounciation/Fumbling/Stammering/Overlapping.","Agent called and cleared all customer queries if required.","Agent did utilize the system eficiently as per requirement to solve a query - CRM Remarks.","Agent did utilize the system eficiently as per requirement to solve a query - Proper CRM reports referred.","Update the Vertical/LOB Issue category & Sub Category/ Issue Category Reason/Order ID or Transaction ID (if any).","Ticket status is updated as per activity and assigned to correct group if solved - response was sent to the customer.","Policy and procedure followed by the agent as per ZTP (Rude Profanity etc).","Agent followed the opening and closing script (including asking for further assisstance)","Active listening/ interruption & no Dead air on call.","HMT protocol followed on call","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='outbound_new'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Agent addressed and answered all customer queries.","Contextual Awareness: Agent checked the ticket history (parent-child; if any)/referred to relevant attachments/ probing.","Agent shared the correct resolution.","Assurance(Power Statement) / Paraphrasing/ Comprehension/ Acknowledgement/Empathy/Apologies.","Correct sentence Formation with appropriate salutation","Rate of Speech/ Speech of Clarity/Tone & Manner/Pronounciation/Fumbling/Stammering/Overlapping.","Sales urgency was created/Selling opportunities were properly utilized.","Proper Rebuttal Given","All Product features mentioned.","Agent did utilize the system eficiently as per requirement to solve a query - CRM Remarks.","Agent did utilize the system eficiently as per requirement to solve a query - Proper CRM reports referred.","Update the Vertical/LOB Issue category & Sub Category/ Issue Category Reason/Order ID or Transaction ID (if any).","Ticket status is updated as per activity and assigned to correct group if solved - response was sent to the customer.","Policy and procedure followed by the agent as per ZTP (Rude and Profanity etc).","Agent followed the opening and closing script (including asking for further assisstance).","Active listening/ interruption & no Dead air on call.","Active listening/ interruption & no Dead air on call.","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='ob_sales'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "STANDARD CALL OPENING PROCEDURE", "** EXPLANATION ABOUT PRODUCT AND PROCESS WITH FULL INFORMATION", "**CORRECT TAGGINGS / WRONG INFORMATION", "NECESSARY PROBING DONE ON CALL BASED", "SALES PICHER POLITE PITCHING URGE FOR SALES & SERVICE", "ACTIVE LISTENING", "ASSURANCE ACKNOWLEDGEMENT STATEMENTS ON CALL", "TONE MODULATION", "DRAGGING / STAMMERING / JARGONS / FILLERS", "CLOSING PROCEDURE FOLLOWED", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='ob_service'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Tenurity (in Days)", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "STANDARD CALL OPENING WITH COMPANY NAME", "NECESSARY PROBING TO BE DONE & UNDERSTANDING THE CUSTOMER", "FOR BNB AND AMAZON EXPLAINATION ABOUT SHOP SET UP AS PER CHECK LIST", "**FOR FLIPKART- EXPLANATION ABOUT FLIPKART PROCESS WITH FULL INFORMATION", "**TAGGING / WRONG INFORAMTION ON CALL", "ACTIVE LISTENING", "RAPPO BUILDING / ASSURANCE", "TONE MODULATION", "DRAGGING / STAMMERING / JARGONS / FILLERS", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='pnb_email'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Call Date", "Campaign", "Call Duration", "Incoming No", "Register No.", "Customer Name", "Call Link", "Ticket No.", "Call Disconnect By", "Tagging/Disposition", "Query/Service", "Type of Call", "Audit Type", "Auditor Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Agent addressed and answered all customer queries", "Contextual Awareness: Agent checked the ticket history (parent-child if any)/referred to relevant attachments/ probing", "Agent shared the correct resolution", "Empathy/Apologies", "Assurance(Power Statement) / Paraphrasing/ Comprehension/ Acknowledgement", "Correct sentence Formation with appropriate salutation", "Rate of Speech/ Speech of Clarity/Tone & Manner", "Pronounciation/Fumbling/Stammering/Overlapping", "Agent called and cleared all customer queries if required", "Agent did utilize the system eficiently as per requirement to solve a query - CRM Remarks", "Agent did utilize the system eficiently as per requirement to solve a query - Proper CRM reports referred", "Update the Vertical/LOB Issue category & Sub Category/ Issue Category Reason/Order ID or Transaction ID (if any)", "Ticket status is updated as per activity and assigned to correct group if solved - response was sent to the customer", "Policy and procedure followed by the agent as per ZTP (Rude Profanity etc)", "Agent followed the opening and closing script (including asking for further assisstance)", "Active listening/ interruption & no Dead air on call", "HMT protocol followed on call", "Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=='email'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Date of Mail Received", "Date of Mail Action", "Status", "TAT", "Replied Date of TAT", "Email Number", "MSISDN", "Mail ID", "Interaction ID", "Category", "Sub Category", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Has all the queries of the customer answered", "Correct process followed", "Correct & Accurate Resolution given & completed on time", "For the missing details has the CSE called the customer to get those", "MINOR ERRORS - NOT GIVEN COMPLETE SOLUTION", "**Wrong or in complete information provided on mail", "Professional and Empathy statements used as per senario and acknowledge as per the query", "Email Etiquette Grammatical error punctuations font & spelling mistakes", "Email Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}else if($campaign=="new_inb" || $campaign=="new_kyc_inb"){
      $header=array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging/Disposition", "Query/Compaint/Others", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Digi KYC Done Post Call","Digi KYC Not Completed on Call Reason","Digi KYC Status","E-KYC Done Post Call","E-KYC Status","Ekyc Not Completed On Call Reason","Standard Call Opening","Appropriate Empathy/Apology Wherever Applicable","Assurance/Paraphrasing","Correct Sentence Formation With Appropriate Salutation","Feeling Confident/Well Mannered/Ros/Clarity Of Speech/Jargon","Active Listening/Attentiveness","Interruption & Parallel Talking","Closing on call","HMT Protocol","Effective Probing/System Check","Self help - IVR Promotion/Sales Pitch/Convincing skill","Security Check - Authentication","Agent Shared The Correct/Complete Information","Whether All The Information Collected And Recorded Properly","Update The Vertical/Lob Issue Category & Sub Category/ Issue Category Reason/Order Id Or Transaction Id","Policy And Procedure Followed By The Agent As Per Ztp (Rude And Profanity Etc)","Reason 1","Reason 2","Reason 3","Reason 4","Reason 5","Reason 6","Reason 7","Reason 8","Reason 9","Reason 10","Reason 11","Reason 12","Reason 13","Reason 14","Reason 15","Reason 16","Remark 1","Remark 2","Remark 3","Remark 4","Remark 5","Remark 6","Remark 7","Remark 8","Remark 9","Remark 10","Remark 11","Remark 12","Remark 13","Remark 14","Remark 15","Remark 16","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
    }else if($campaign=="new_outbound"){
      $header=array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Call Link", "Ticket Number", "Call Disconnect By", "Tagging/Disposition", "Query/Compaint/Others", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Standard Call Opening (Greeting With Company Name Right Party Confirmation)","Appropriate Empathy/Apology Wherever Applicable","Assurance / Paraphrasing","Correct Sentence Formation With Appropriate Salutation","Feeling Confident/Well Mannered/Ros/Clarity Of Speech/Jargons","Active Listening/Attentive On Call","Interruption & Parallel Talking","Closing On Call","HMT","Rapport Building & Effective Probing","Sales Urgency Was Created/Selling Opportunities Were Properly Utilized","Proper Rebuttal Given","Agent Shared The Correct/Complete Information","All Product Features Mentioned","Whether All The Information Collected And Recorded Properly","Update The Vertical/Lob Issue Category & Sub Category","Policy And Procedure Followed By The Agent","Reason 1","Reason 2","Reason 3","Reason 4","Reason 5","Reason 6","Reason 7","Reason 8","Reason 9","Reason 10","Reason 11","Reason 12","Reason 13","Reason 14","Reason 15","Reason 16","Remark 17","Remark 1","Remark 2","Remark 3","Remark 4","Remark 5","Remark 6","Remark 7","Remark 8","Remark 9","Remark 10","Remark 11","Remark 12","Remark 13","Remark 14","Remark 15","Remark 16","Remark 17","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
    }else if($campaign=="new_email" || $campaign=="new_social"){
      $header=array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Call Date/Time", "Call Duration", "Incoming Number", "Campaign", "Register No", "Customer Name", "Ticket Number", "Call Disconnect By", "Tagging/Disposition", "Query/Service", "Type Of Call", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Was the advisor fluent in his/her written communication skills?","Agent Shared The Correct/Complete Information (Email-Resolution)","Actioned the request/complaint/concern correctly","Did the agent follow prescribed template when replying","Did the agent call back to collect missing details?","Standard Call Opening","Assurance / Paraphrasing","Appropriate Empathy/Apology Wherever Applicable","Communication Skill of the associate during close-looping","Effective Probing/System utilization or navigation","Closing","Agent Shared The Correct/Complete Information (In-Call)","Tagging/Appropriate Remarks updation","Policy And Procedure Followed By The Agent","Reason 1","Reason 2","Reason 3","Reason 4","Reason 5","Reason 6","Reason 7","Reason 8","Reason 9","Reason 10","Reason 11","Reason 12","Reason 13","Reason 14","Remark 1","Remark 2","Remark 3","Remark 4","Remark 5","Remark 6","Remark 7","Remark 8","Remark 9","Remark 10","Remark 11","Remark 12","Remark 13","Remark 14","Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
    }

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

		if($campaign=='inbound'){

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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['opening_greeting'].'",';
				$row .= '"'.$user['initial_empathy'].'",';
				$row .= '"'.$user['agent_query'].'",';
				$row .= '"'.$user['proper_telephone'].'",';
				$row .= '"'.$user['ivr_promotion'].'",';
				$row .= '"'.$user['efective_rebuttal'].'",';
				$row .= '"'.$user['fraud_alert'].'",';
				$row .= '"'.$user['sentence_acknowledge'].'",';
				$row .= '"'.$user['polite_call'].'",';
				$row .= '"'.$user['good_behaviour'].'",';
				$row .= '"'.$user['good_listening'].'",';
				$row .= '"'.$user['not_interrupt'].'",';
				$row .= '"'.$user['proper_empathy'].'",';
				$row .= '"'.$user['proper_pace'].'",';
				$row .= '"'.$user['agent_patience'].'",';
				$row .= '"'.$user['energy_enthusias'].'",';
				$row .= '"'.$user['confident_level'].'",';
				$row .= '"'.$user['error_fumbling'].'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'.$user['dragged_call'].'",';
				$row .= '"'.$user['rude_language'].'",';
				$row .= '"'.$user['exact_tat'].'",';
				$row .= '"'.$user['wrong_provide'].'",';
				$row .= '"'.$user['correct_tagging'].'",';
				$row .= '"'.$user['minor_error'].'",';
				$row .= '"'.$user['satisfy_rapport'].'",';
				$row .= '"'.$user['closing_script'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['grade'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';

				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);

		}else if($campaign=='inbound_new'){

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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agent_addressed_customer_queries'].'",';
				$row .= '"'.$user['contextual_awareness'].'",';
				$row .= '"'.$user['agent_shared_resolution'].'",';
				$row .= '"'.$user['empathy_pologies'].'",';
				$row .= '"'.$user['power_statement'].'",';
				$row .= '"'.$user['correct_sentence_formation'].'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['pronunciation'].'",';
				$row .= '"'.$user['agent_called_and_cleared'].'",';
				$row .= '"'.$user['agent_utilize_the_system_crm_remark'].'",';
				$row .= '"'.$user['agent_utilize_the_system_crm_reports'].'",';
				$row .= '"'.$user['update_the_vertical_lob'].'",';
				$row .= '"'.$user['ticket_status_is_updated'].'",';
				$row .= '"'.$user['policy_and_procedure_followed'].'",';
				$row .= '"'.$user['agent_followed_the_opening'].'",';
				$row .= '"'.$user['active_listening_interruption'].'",';
				$row .= '"'.$user['hmt_protocol_followed'].'",';
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

		}else if($campaign=='outbound_new'){
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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agent_address'].'",';
				$row .= '"'.$user['contextual_awareness'].'",';
				$row .= '"'.$user['agent_shared_correct'].'",';
				$row .= '"'.$user['assurance'].'",';
				$row .= '"'.$user['correct_sentence_formation'].'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['sales_urgency'].'",';
				$row .= '"'.$user['proper_rebuttal'].'",';
				$row .= '"'.$user['all_product_features'].'",';
				$row .= '"'.$user['agent_did_utilize_remarks'].'",';
				$row .= '"'.$user['agent_did_utilize_reports'].'",';
				$row .= '"'.$user['update_the_vertical'].'",';
				$row .= '"'.$user['ticket_status'].'",';
				$row .= '"'.$user['policy_and_procedure'].'",';
				$row .= '"'.$user['agent_followed_opening'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['hmt_protocol'].'",';
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

		}else if($campaign=='ob_sales'){

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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['standart_call_opening'].'",';
				$row .= '"'.$user['explain_about_product'].'",';
				$row .= '"'.$user['correct_tagging'].'",';
				$row .= '"'.$user['necessary_probing'].'",';
				$row .= '"'.$user['sales_picher'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['assurance_acknowledge'].'",';
				$row .= '"'.$user['tone_modulation'].'",';
				$row .= '"'.$user['dragging_stammering'].'",';
				$row .= '"'.$user['closing_procedure'].'",';
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

		}else if($campaign=='ob_service'){

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
				$row .= '"'.$user['tenure'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['standard_call_opening'].'",';
				$row .= '"'.$user['necessary_probing'].'",';
				$row .= '"'.$user['explain_about_BNB_Amazon'].'",';
				$row .= '"'.$user['explain_about_Flipkart'].'",';
				$row .= '"'.$user['wrong_call_information'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['rappo_building'].'",';
				$row .= '"'.$user['tone_modulation'].'",';
				$row .= '"'.$user['dragging_stammering'].'",';
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

		}else if($campaign=='pnb_email'){

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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['type_of_call'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';


				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';


				$row .= '"'.$user['agent_addressed_answered'].'",';
				$row .= '"'.$user['contextual_awareness'].'",';
				$row .= '"'.$user['agent_shared_correct'].'",';
				$row .= '"'.$user['empathy_apologies'].'",';
				$row .= '"'.$user['assurance'].'",';
				$row .= '"'.$user['correct_sentence'].'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['pronounciation'].'",';
				$row .= '"'.$user['agent_called_cleared'].'",';
				$row .= '"'.$user['agent_utilize_crm_remark'].'",';
				$row .= '"'.$user['agent_utilize_crm_report'].'",';
				$row .= '"'.$user['update_the_vertical'].'",';
				$row .= '"'.$user['ticket_status_updated'].'",';
				$row .= '"'.$user['policy_and_procedure'].'",';
				$row .= '"'.$user['agent_followed_opening'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['hmt_protocol_followed'].'",';




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

		}else if($campaign=='email'){

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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['mail_action_date'].'",';
				$row .= '"'.$user['status'].'",';
				$row .= '"'.$user['tat'].'",';
				$row .= '"'.$user['tat_replied_date'].'",';
				$row .= '"'.$user['email_no'].'",';
				$row .= '"'.$user['msisdn'].'",';
				$row .= '"'.$user['email_id'].'",';
				$row .= '"'.$user['interaction_id'].'",';
				$row .= '"'.$user['category'].'",';
				$row .= '"'.$user['sub_category'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['customer_query_answer'].'",';
				$row .= '"'.$user['correct_process_follow'].'",';
				$row .= '"'.$user['accurate_resolution_given'].'",';
				$row .= '"'.$user['missing_details_for_CSE_call'].'",';
				$row .= '"'.$user['not_given_complete_solution'].'",';
				$row .= '"'.$user['product_process_knowledge'].'",';
				$row .= '"'.$user['empathy_statement_use'].'",';
				$row .= '"'.$user['grammatical_error'].'",';
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

		}else if($campaign=='new_inb' || $campaign=="new_kyc_inb"){

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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
        $row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';

        $row .= '"'.$user['kyc_done_post_call'].'",';
        $row .= '"'.$user['kyc_not_complete_reason'].'",';
        $row .= '"'.$user['kyc_status'].'",';
        $row .= '"'.$user['ekyc_post_call'].'",';
        $row .= '"'.$user['ekyc_status'].'",';
        $row .= '"'.$user['ekyc_not_complete_reason'].'",';

				$row .= '"'.$user['standard_call_opening'].'",';
				$row .= '"'.$user['appr_empathy_apology'].'",';
				$row .= '"'.$user['assurance_paraph'].'",';
				$row .= '"'.$user['correct_sentence_formation'].'",';
				$row .= '"'.$user['feeling_confident'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['interruption'].'",';
				$row .= '"'.$user['closing_on_call'].'",';
        $row .= '"'.$user['hmt_protocol'].'",';
        $row .= '"'.$user['effective_probing'].'",';
        $row .= '"'.$user['self_help'].'",';
        $row .= '"'.$user['security_check'].'",';
        $row .= '"'.$user['agent_shared_comp_info'].'",';
        $row .= '"'.$user['all_info_collected'].'",';
        $row .= '"'.$user['update_vertical_lob_issue'].'",';
        $row .= '"'.$user['policy_and_procedure'].'",';

        $row .= '"'.$user['sco_reason'].'",';
        $row .= '"'.$user['appr_emp_ap_reason'].'",';
        $row .= '"'.$user['assurance_paraph_reason'].'",';
        $row .= '"'.$user['correct_sentence_form_reason'].'",';
        $row .= '"'.$user['feeling_confident_reason'].'",';
        $row .= '"'.$user['active_listening_reason'].'",';
        $row .= '"'.$user['interruption_reason'].'",';
        $row .= '"'.$user['closing_on_call_reason'].'",';
        $row .= '"'.$user['hmt_protocol_reason'].'",';
        $row .= '"'.$user['effective_probing_reason'].'",';
        $row .= '"'.$user['self_help_reason'].'",';
        $row .= '"'.$user['security_check_reason'].'",';
        $row .= '"'.$user['agent_shared_comp_info_reason'].'",';
        $row .= '"'.$user['all_info_collected_reason'].'",';
        $row .= '"'.$user['update_vertical_lob_issue_reason'].'",';
        $row .= '"'.$user['policy_and_procedure_reason'].'",';

        $row .= '"'.$user['remark1'].'",';
        $row .= '"'.$user['remark2'].'",';
        $row .= '"'.$user['remark3'].'",';
        $row .= '"'.$user['remark4'].'",';
        $row .= '"'.$user['remark5'].'",';
        $row .= '"'.$user['remark6'].'",';
        $row .= '"'.$user['remark7'].'",';
        $row .= '"'.$user['remark8'].'",';
        $row .= '"'.$user['remark9'].'",';
        $row .= '"'.$user['remark10'].'",';
        $row .= '"'.$user['remark11'].'",';
        $row .= '"'.$user['remark12'].'",';
        $row .= '"'.$user['remark13'].'",';
        $row .= '"'.$user['remark14'].'",';
        $row .= '"'.$user['remark15'].'",';
        $row .= '"'.$user['remark16'].'",';
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

		}else if($campaign=='new_email' || $campaign=="new_social"){

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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['type_of_call'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
        $row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';

        $row .= '"'.$user['advisor_fluent'].'",';
        $row .= '"'.$user['agent_shared_comp_info'].'",';
        $row .= '"'.$user['action_req_correctly'].'",';
        $row .= '"'.$user['agent_follow_prescribed_temp'].'",';
        $row .= '"'.$user['agent_call_back'].'",';
        $row .= '"'.$user['standard_call_opening'].'",';

				$row .= '"'.$user['assurance_paraph'].'",';
				$row .= '"'.$user['appr_emp_ap'].'",';
				$row .= '"'.$user['communication_skill'].'",';
				$row .= '"'.$user['effective_probing'].'",';
				$row .= '"'.$user['closing'].'",';
				$row .= '"'.$user['agent_shared_in_call'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['ztp'].'",';

        //Reasons
        $row .= '"'.$user['advisor_fluent_reason'].'",';
        $row .= '"'.$user['asci_reason'].'",';
        $row .= '"'.$user['arc_reason'].'",';
        $row .= '"'.$user['afp_temp_reason'].'",';
        $row .= '"'.$user['acb_reason'].'",';
        $row .= '"'.$user['sco_reason'].'",';
        $row .= '"'.$user['assurance_paraph_reason'].'",';
        $row .= '"'.$user['appr_emp_ap_reason'].'",';
        $row .= '"'.$user['comm_skill_reason'].'",';
        $row .= '"'.$user['effective_probing_reason'].'",';
        $row .= '"'.$user['closing_reason'].'",';
        $row .= '"'.$user['agent_shared_in_call_reason'].'",';
        $row .= '"'.$user['tagging_reason'].'",';
        $row .= '"'.$user['ztp_reason'].'",';

        $row .= '"'.$user['remark1'].'",';
        $row .= '"'.$user['remark2'].'",';
        $row .= '"'.$user['remark3'].'",';
        $row .= '"'.$user['remark4'].'",';
        $row .= '"'.$user['remark5'].'",';
        $row .= '"'.$user['remark6'].'",';
        $row .= '"'.$user['remark7'].'",';
        $row .= '"'.$user['remark8'].'",';
        $row .= '"'.$user['remark9'].'",';
        $row .= '"'.$user['remark10'].'",';
        $row .= '"'.$user['remark11'].'",';
        $row .= '"'.$user['remark12'].'",';
        $row .= '"'.$user['remark13'].'",';
        $row .= '"'.$user['remark14'].'",';

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

		}else if($campaign=='new_outbound'){

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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['incoming_no'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['register_no'].'",';
				$row .= '"'.$user['customer'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['ticket_no'].'",';
				$row .= '"'.$user['call_disconnect_by'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['query_service'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
        $row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';

        $row .= '"'.$user['standard_call_opening'].'",';
        $row .= '"'.$user['appr_empathy_apology'].'",';
        $row .= '"'.$user['assurance_paraph'].'",';
        $row .= '"'.$user['correct_sentence_formation'].'",';
        $row .= '"'.$user['feeling_confident'].'",';
        $row .= '"'.$user['active_listening'].'",';

				$row .= '"'.$user['parallel_talking'].'",';
				$row .= '"'.$user['closing_on_call'].'",';
				$row .= '"'.$user['hmt'].'",';
				$row .= '"'.$user['rapport_building'].'",';
				$row .= '"'.$user['sales_urgency'].'",';
				$row .= '"'.$user['proper_rebuttal'].'",';
				$row .= '"'.$user['agent_shared_comp_info'].'",';
				$row .= '"'.$user['all_product_features'].'",';
        $row .= '"'.$user['all_info_collected'].'",';
        $row .= '"'.$user['update_the_vertical_lob'].'",';
        $row .= '"'.$user['ztp'].'",';

        //Reasons
        $row .= '"'.$user['sco_reason'].'",';
        $row .= '"'.$user['appr_emp_ap_reason'].'",';
        $row .= '"'.$user['assurance_paraph_reason'].'",';
        $row .= '"'.$user['csf_reason'].'",';
        $row .= '"'.$user['feeling_confident_reason'].'",';
        $row .= '"'.$user['active_listening_reason'].'",';
        $row .= '"'.$user['parallel_talking_reason'].'",';
        $row .= '"'.$user['coc_reason'].'",';
        $row .= '"'.$user['hmt_reason'].'",';
        $row .= '"'.$user['rapport_building_reason'].'",';
        $row .= '"'.$user['sales_urgency_reason'].'",';
        $row .= '"'.$user['proper_rebuttal_reason'].'",';
        $row .= '"'.$user['as_c_info_reason'].'",';
        $row .= '"'.$user['apf_reason'].'",';
        $row .= '"'.$user['aic_reason'].'",';
        $row .= '"'.$user['utvl_reason'].'",';
        $row .= '"'.$user['ztp_reason'].'",';

        $row .= '"'.$user['remark1'].'",';
        $row .= '"'.$user['remark2'].'",';
        $row .= '"'.$user['remark3'].'",';
        $row .= '"'.$user['remark4'].'",';
        $row .= '"'.$user['remark5'].'",';
        $row .= '"'.$user['remark6'].'",';
        $row .= '"'.$user['remark7'].'",';
        $row .= '"'.$user['remark8'].'",';
        $row .= '"'.$user['remark9'].'",';
        $row .= '"'.$user['remark10'].'",';
        $row .= '"'.$user['remark11'].'",';
        $row .= '"'.$user['remark12'].'",';
        $row .= '"'.$user['remark13'].'",';
        $row .= '"'.$user['remark14'].'",';
        $row .= '"'.$user['remark15'].'",';
        $row .= '"'.$user['remark16'].'",';
        $row .= '"'.$user['remark17'].'",';
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

	}

	//Inbound New (Start)
  //Edited By Samrat 20/12/2021
  public function common_rating_para(){
    return array(
      ""=>"-- SELECT --",
      "Good"=>"Good",
      "Needs Improvement"=>"Needs Improvement",
      "Poor"=>"Poor",
      "N/A"=>"N/A"
    );
  }
  public function common_fatal_rating(){
    return array(
      ""=>"-- SELECT --",
      "Good"=>"Good",
      "Fatal"=>"Fatal"
    );
  }
  public function add_edit_new_pnb_inbound($lob,$pnb_inb_id){
    if(check_logged_in()){
      $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_inbound_new.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['pnb_inb_id']=$pnb_inb_id;
			$data['lob']=$lob;

			$data['common_rating']=$this->common_rating_para();
			$data['common_fatal_rating']=$this->common_fatal_rating();
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			if($lob=="inb"){
			$qSql = "SELECT * from
  				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
  				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
  				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
  				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
  				from qa_pnb_new_inb_feedback where id='$pnb_inb_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			}else if($lob=="kyc"){
				$qSql = "SELECT * from
  				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
  				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
  				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
  				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
  				from qa_pnb_new_kyc_inb_feedback where id='$pnb_inb_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			}
			$data["pnbinbound"] = $this->Common_model->get_query_row_array($qSql);


			$curDateTime=CurrMySqlDate();
			$a = array();


			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($pnb_inb_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($lob=="inb"){
						if(!file_exists('./qa_files/pnbinbound_new/')){
							mkdir('./qa_files/pnbinbound_new/');
						}
						$a = $this->audio_upl_files($_FILES['attach_file'], $path='./qa_files/pnbinbound_new/');
						$field_array["attach_file"] = implode(',',$a);
						
						$rowid= data_inserter('qa_pnb_new_inb_feedback',$field_array);
					//////////
						if(get_login_type()=="client"){
							$add_array = array("client_entryby" => $current_user);
						}else{
							$add_array = array("entry_by" => $current_user);
						}
						$this->db->where('id', $rowid);
						$this->db->update('qa_pnb_new_inb_feedback',$add_array);
          
					}else if($lob=="kyc"){
						if(!file_exists('./qa_files/pnbinbound_new_kyc/')){
						  mkdir('./qa_files/pnbinbound_new_kyc/');
						}
						$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pnbinbound_new_kyc/');
						$field_array["attach_file"] = implode(',',$a);
						$rowid= data_inserter('qa_pnb_new_kyc_inb_feedback',$field_array);
					///////////
						if(get_login_type()=="client"){
							$add_array = array("client_entryby" => $current_user);
						}else{
							$add_array = array("entry_by" => $current_user);
						}
						$this->db->where('id', $rowid);
						$this->db->update('qa_pnb_new_kyc_inb_feedback',$add_array);
					  }
					  
				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));

					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if($lob=="inb"){
							if(!file_exists('./qa_files/pnbinbound_new/')){
								mkdir('./qa_files/pnbinbound_new/');
							}
							$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pnbinbound_new/');
						}else if($lob=="kyc"){
							if(!file_exists('./qa_files/pnbinbound_new_kyc/')){
								mkdir('./qa_files/pnbinbound_new_kyc/');
							}
							$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/pnbinbound_new_kyc/');
						}
						$field_array1['attach_file'] = implode(',',$a);
					}
          
					
					if($lob=="inb"){
						$this->db->where('id', $pnb_inb_id);
						$this->db->update('qa_pnb_new_inb_feedback',$field_array1);
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
						$this->db->where('id', $pnb_inb_id);
						$this->db->update('qa_pnb_new_inb_feedback',$edit_array);
						
					}else if($lob=="kyc"){
						$this->db->where('id', $pnb_inb_id);
						$this->db->update('qa_pnb_new_kyc_inb_feedback',$field_array1);
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
								$this->db->where('id', $pnb_inb_id);
								$this->db->update('qa_pnb_new_kyc_inb_feedback',$edit_array);
					  }
				}
				redirect('qa_paynearby');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
    }
  }

  //New Agent review
  public function agent_paynearby_rvw_new($lob,$review_id){ 
    if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["agentUrl"] = "qa_paynearby/agent_paynearby_feedback";
			$data["content_js"] = "qa_pnb_outbound_sales_v1_js.php";

      $data['common_rating']=$this->common_rating_para();
      $data['common_fatal_rating']=$this->common_fatal_rating();

      $data['lob']=$lob;

      if($lob=="inb"){
        $data["content_template"] = "qa_paynearby/agent_paynearby_rvw_new.php";
        $qSql="SELECT * from (Select *,
          (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
          (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name
          from qa_pnb_new_inb_feedback where id='$review_id') xx Left Join
          (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
      }else if($lob=="kyc"){
        $data["content_template"] = "qa_paynearby/agent_paynearby_rvw_new.php";
        $qSql="SELECT * from (Select *,
          (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
          (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name
          from qa_pnb_new_kyc_inb_feedback where id='$review_id') xx Left Join
          (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
      }else if($lob=="outbound"){
        $data["content_template"] = "qa_paynearby/agent_paynearby_outbound_rvw_new.php";
        $qSql="SELECT * from (Select *,
          (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
          (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name
          from qa_paynearby_outbound_feedback where id='$review_id') xx Left Join
          (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
      }else if($lob=="pnb_ob_sales_v1"){
        $data["content_template"] = "qa_paynearby/agent_paynearby_outbound_sales_v1_rvw_new.php";
        $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,115) and is_assign_process(id,287) and status=1  order by name";
			//and is_assign_process(id,908)
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

        $qSql="SELECT * from (Select *,
          (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
          (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name
          from qa_pnb_outbound_sales_v1_feedback where id='$review_id') xx Left Join
          (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid)";
      }else if($lob=="new_one_outbound"){
        $data["content_template"] = "qa_paynearby/agent_paynearby_outbound_rvw_new_one.php";
        $qSql="SELECT * from (Select *,
          (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
          (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name
          from qa_paynearby_outbound_new_feedback where id='$review_id') xx Left Join
          (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
      }else if($lob=="email"){
        $data["content_template"] = "qa_paynearby/agent_paynearby_email_rvw_new.php";
        $qSql="SELECT * from (Select *,
          (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
          (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name
          from qa_paynearby_new_email_feedback where id='$review_id') xx Left Join
          (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
      }else if($lob=="social"){
        $data["content_template"] = "qa_paynearby/agent_paynearby_social_rvw_new.php";
        $qSql="SELECT * from (Select *,
          (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
          (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name
          from qa_paynearby_new_social_media_feedback where id='$review_id') xx Left Join
          (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
      }
			$data["paynearby_feedback"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$review_id;

			// $qSql="Select * FROM qa_paynearby_agent_rvw where fd_id='$review_id'";
			// $data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
      //
			// $qSql="Select * FROM qa_paynearby_mgnt_rvw where fd_id='$review_id'";
			// $data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE


			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

				$field_array1=array(
					"id" => $pnid,
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_date" => $curDateTime
				);

				if($this->input->post('action')==''){
          if($lob=="inb"){
            $rowid= data_inserter('qa_pnb_new_inb_feedback',$field_array1);
          }else if($lob=="kyc"){
            $rowid= data_inserter('qa_pnb_new_kyc_inb_feedback',$field_array1);
          }else if($lob=="outbound"){
            $rowid= data_inserter('qa_paynearby_outbound_feedback',$field_array1);
          }else if($lob=="new_one_outbound"){
            $rowid= data_inserter('qa_paynearby_outbound_new_feedback',$field_array1);
          }else if($lob=="email"){
            $rowid= data_inserter('qa_paynearby_new_email_feedback',$field_array1);
          }else if($lob=="social"){
            $rowid= data_inserter('qa_paynearby_new_social_media_feedback',$field_array1);
          }else if($lob=="pnb_ob_sales_v1"){
          	$this->db->where('id', $pnid);
            $this->db->update("qa_pnb_outbound_sales_v1_feedback", $field_array1);
          }
				}else{
					$this->db->where('id', $pnid);
          if($lob=="inb"){
            $this->db->update('qa_pnb_new_inb_feedback',$field_array1);
          }else if($lob=="kyc"){
            $this->db->update('qa_pnb_new_kyc_inb_feedback',$field_array1);
          }else if($lob=="outbound"){
            $this->db->update("qa_paynearby_outbound_feedback", $field_array1);
          }else if($lob=="pnb_ob_sales_v1"){
            $this->db->update("qa_pnb_outbound_sales_v1_feedback", $field_array1);
          }else if($lob=="new_one_outbound"){
            $this->db->update("qa_paynearby_outbound_new_feedback", $field_array1);
          }else if($lob=="email"){
            $this->db->update("qa_paynearby_new_email_feedback", $field_array1);
          }else if($lob=="social"){
            $this->db->update("qa_paynearby_new_social_media_feedback", $field_array1);
          }
				}
				redirect('Qa_paynearby/agent_paynearby_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
  }

  public function add_edit_outbound($pnboutbound_id){
    if(check_logged_in()){
      $current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_new_outbound.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['pnboutbound_id']=$pnboutbound_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_outbound_feedback where id='$pnboutbound_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on
				(xx.agent_id=yy.sid)";
			$data["pnboutbound"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($pnboutbound_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					$a = $this->audio_upl_files($_FILES['attach_file'], $path='./qa_files/pnboutbound/');
					$field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_paynearby_outbound_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_outbound_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $pnboutbound_id);
					$this->db->update('qa_paynearby_outbound_feedback',$field_array1);
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
					$this->db->where('id', $pnboutbound_id);
					$this->db->update('qa_paynearby_outbound_feedback',$edit_array);

				}

				redirect('Qa_paynearby/paynearby_outbound');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
    }
  }

  ////////////////Bikash///////////////////////////

   public function add_edit_outbound_new($pnboutbound_id){
    if(check_logged_in()){
      $current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_new_one_outbound.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['pnboutbound_id']=$pnboutbound_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_outbound_new_feedback where id='$pnboutbound_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on
				(xx.agent_id=yy.sid)";
			$data["pnb_new_ob"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($pnboutbound_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					$a = $this->audio_upl_files($_FILES['attach_file'], $path='./qa_files/pnboutbound/');
					$field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_paynearby_outbound_new_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_outbound_new_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upl_files($_FILES['attach_file'], $path='./qa_files/pnboutbound/');
						$field_array1["attach_file"] = implode(',',$a);
					}
				
					$this->db->where('id', $pnboutbound_id);
					$this->db->update('qa_paynearby_outbound_new_feedback',$field_array1);
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
					$this->db->where('id', $pnboutbound_id);
					$this->db->update('qa_paynearby_outbound_new_feedback',$edit_array);

				}

				redirect('Qa_paynearby/paynearby_outbound');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
    }
  }

  ////////////////vikas PNB V1////////////////////

  public function add_edit_pnb_outbound_sales_v1($pnboutbound_v1_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_outbound_sales_v1.php";
			$data["content_js"] = "qa_pnb_outbound_sales_v1_js.php";

			$data['pnboutbound_v1_id']=$pnboutbound_v1_id;
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

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,115) and is_assign_process(id,287) and status=1  order by name";
			//and is_assign_process(id,908)
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_pnb_outbound_sales_v1_feedback where id='$pnboutbound_v1_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["pnb_outbound_sales_v1"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($pnboutbound_v1_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->pnb_ob_sales_v1_upload_files($_FILES['attach_file'], $path='./qa_files/pnb_outbound_sales_v1/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_pnb_outbound_sales_v1_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_pnb_outbound_sales_v1_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/pnb_outbound_sales_v1/")){
							mkdir("./qa_files/pnb_outbound_sales_v1/");
						}
						$a = $this->pnb_ob_sales_v1_upload_files( $_FILES['attach_file'], $path = './qa_files/pnb_outbound_sales_v1/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $pnboutbound_v1_id);
					$this->db->update('qa_pnb_outbound_sales_v1_feedback',$field_array1);
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
					$this->db->where('id', $pnboutbound_v1_id);
					$this->db->update('qa_pnb_outbound_sales_v1_feedback',$edit_array);

						/* Randamiser section */
					if($rand_id!=0){
						$rand_cdr_array = array("audit_status" => 1);
						$this->db->where('id', $rand_id);
						$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
						
						$rand_array = array("is_rand" => 1);
						$this->db->where('id', $rowid);
						$this->db->update('qa_pnb_outbound_sales_v1_feedback',$rand_array);
					}

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('Qa_paynearby/paynearby_outbound');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
  }
  /////////////////////////////////vikas pnb sales V1//////////////////////////////////////

  //PNB Social Media [Edited By Samrat 30/12/2021]
  public function add_edit_pnb_social($social_id){
    if(check_logged_in()){
      $current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_paynearby/add_edit_pnb_new_social.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['social_id']=$social_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,115) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_paynearby_new_social_media_feedback where id='$social_id') xx Left Join
        (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on
        (xx.agent_id=yy.sid)";
			$data["paynearby_social"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($social_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_pnb_social/');
					$field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_paynearby_new_social_media_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_paynearby_new_social_media_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $social_id);
					$this->db->update('qa_paynearby_new_social_media_feedback',$field_array1);
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
					$this->db->where('id', $social_id);
					$this->db->update('qa_paynearby_new_social_media_feedback',$edit_array);

				}

				redirect('Qa_paynearby/paynearby_email');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
    }
  }
  
 
/*--------------------------------------------------------------------------------------------------*/
///////////////////////////////////////// QA Create Audio File //////////////////////////////////////
	public function record_audio($ss_id){ 
		if(check_logged_in()){
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_payneraby/record_audio.php";
			

			$this->load->view('dashboard',$data);
		}
	}
/*--------------------------------------------------------------------------------------------------*/


  
  
 }
