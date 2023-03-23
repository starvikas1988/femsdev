<?php

 class Qa_acc extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}

/////////////////////////// Create Path for Upload Audio Files - Start ///////////////////////////////
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
			$data["content_template"] = "qa_acc/feedback_acc.php";
			$data["content_js"] = "qa_att_js.php";
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			$cond1='';

			$qSql_agent="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql_agent);

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
			if($from_date !="" && $to_date!=="" )  $cond =" where (audit_date >= '$from_date' and audit_date <= '$to_date') ";
			if($agent_id!=""){
				$cond1 ="and agent_id='$agent_id'";
			}

			if(get_user_fusion_id()=='FFLO000546'){
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


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["acc"] = $this->Common_model->get_query_result_array($qSql);



			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_feedback_new $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["acc_new"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_acg"] = $this->Common_model->get_query_result_array($qSql);


			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

         ////////////////////////////////////////////////////////////////////////////////////////added   ////////////////////////////////////////////////

         $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";



       $data["agentName"] = $this->Common_model->get_query_result_array($qSql); // this will display id, name,assigned_to,fusion_id

       $from_date = $this->input->get('from_date');
       $to_date = $this->input->get('to_date');
       $agent_id = $this->input->get('agent_id');
       $cond="";
       $ops_cond="";

       if($from_date==""){
         $from_date=CurrDate(); // if from date is not given then current date will added else mmddyy format
       }else{
         $from_date = mmddyy2mysql($from_date);
       }

       if($to_date==""){
         $to_date=CurrDate(); //if to_date is not given then current date will added else mmddyy format
       }else{
         $to_date = mmddyy2mysql($to_date);
       }

       if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
       if($agent_id !="")	$cond .=" and agent_id='$agent_id'";

       if(get_user_fusion_id()=='FKOL009915'){
         $ops_cond="";
       }else{
         if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
           $ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
         }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
           $ops_cond=" Where assigned_to='$current_user'";
         }else if(get_login_type()=="client"){
           $ops_cond=" Where audit_type not in ('Operation Audit','Trainer Audit')";
         }else{
           $ops_cond="";
         }
       }


       //$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_inbound_v2_feedback $cond) xx Left Join(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";

       $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_new_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond order by audit_date";

       //$data["ajio_inb_v2"] = $this->Common_model->get_query_result_array($qSql); // original

       //echo $qSql;

       $data["qa_accs"] = $this->Common_model->get_query_result_array($qSql);

       $data["from_date"] = $from_date;
       $data["to_date"] = $to_date;
       $data["agent_id"] = $agent_id;














			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_acc($acc_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_acc/add_edit_acc.php";
			//$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["content_js"] = "qa_att_js.php";
			$data['acc_id']=$acc_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);



			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_acc_feedback where id='$acc_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["acc"] = $this->Common_model->get_query_row_array($qSql);


			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($acc_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_acc/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_acc_feedback',$field_array);

					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_acc_feedback',$add_array);

				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $acc_id);
					$this->db->update('qa_acc_feedback',$field_array1);
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
					$this->db->where('id', $acc_id);
					$this->db->update('qa_acc_feedback',$edit_array);

				}
				redirect('Qa_acc');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_acc_new($acc_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_acc/add_edit_acc_new.php";
			//$data["content_js"] = "qa_ameridial_healthcare_js.php";
			$data["content_js"] = "qa_att_js.php";
			$data['acc_id']=$acc_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);



			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_acc_feedback_new where id='$acc_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["acc"] = $this->Common_model->get_query_row_array($qSql);


			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($acc_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_acc/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_acc_feedback_new',$field_array);

					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_acc_feedback_new',$add_array);

				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $acc_id);
					$this->db->update('qa_acc_feedback_new',$field_array1);
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
					$this->db->where('id', $acc_id);
					$this->db->update('qa_acc_feedback_new',$edit_array);

				}
				redirect('Qa_acc');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	public function agent_acc_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_acc/agent_acc_feedback.php";
			$data["content_js"] = "qa_att_js.php";
			$data["agentUrl"] = "qa_at/agent_att_feedback";

			$campaign="";
			$campaign = $this->input->get('campaign');

			$from_date = '';
			$to_date = '';
			$cond="";

			$data["att_list"]=array();

			// if($campaign!=''){

				$qSql1="Select count(id) as value from qa_acc_feedback where agent_id='$current_user'";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
				$qSql2="Select count(id) as value from qa_acc_feedback where agent_rvw_date is null and agent_id='$current_user'";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);

				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);

					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);

					if($from_date !="" && $to_date!=="" )  $cond =" and (audit_date >= '$from_date' and audit_date <= '$to_date') ";

					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_feedback Where agent_id='$current_user' $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
					$data["att_list"] = $this->Common_model->get_query_result_array($qSql);

				}

		//	}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;


			$this->load->view('dashboard',$data);
		}
	}



	    public function agent_acc_feedback_new()
    {
        if (check_logged_in())
        {
            $role_id = get_role_id();
            $current_user = get_user_id();
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_acc/agent_acc_feedback_new.php";
            $data["content_js"] = "qa_mba_voice_js.php";
            $data["agentUrl"] = "Qa_acc/agent_acc_feedback_new";

            $qSql = "Select count(id) as value from qa_acc_feedback_new where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
            $data["tot_feedback"] = $this->Common_model->get_single_value($qSql);

            $qSql = "Select count(id) as value from qa_acc_feedback_new where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
            $data["yet_rvw"] = $this->Common_model->get_single_value($qSql);

            $from_date = '';
            $to_date = '';
            $cond = "";

            if ($this->input->get('btnView') == 'View')
            {

                $from_date = mmddyy2mysql($this->input->get('from_date'));
                $to_date = mmddyy2mysql($this->input->get('to_date'));

                if ($from_date != "" && $to_date !== "") $cond = " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' ";

                $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_feedback_new $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
                $data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

            }
            else
            {

                $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_feedback_new where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
                $data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

            }

            $data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
            $this->load->view('dashboard', $data);
        }
    }


  public function agent_acc_feedback_rvw($id){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $data['att_id']=$id;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_acc/agent_acc_feedback_rvw.php";
      //$data["content_js"] = "qa_ameridial_healthcare_js.php";
      $data["content_js"] = "qa_att_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $qSql="SELECT * from
        (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
        (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
        (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
        (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_feedback where id='$id') xx Left Join
        (Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
      $data["acc"] = $this->Common_model->get_query_row_array($qSql);
		// echo '<pre>';
		// print_r($data["acc"]);
		// die();

      $data["acc_id"]=$id;

      if($this->input->post('acc_id'))
      {
        $att_id=$this->input->post('acc_id');
        $curDateTime=CurrMySqlDate();
        $log=get_logs();

        $field_array1=array(
          "agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
          "agent_rvw_note" => $this->input->post('note'),
          "agent_rvw_date" => $curDateTime
        );
        $this->db->where('id', $acc_id);
        $this->db->update('qa_acc_feedback',$field_array1);


        redirect('Qa_acc/agent_acc_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////19 december 2022///////////////////

private function ajio_upload_files($files,$path)   // this is for file uploaging purpose
  {
    $result=$this->createPath($path);
    if($result){
      $config['upload_path'] = $path;
    $config['allowed_types'] = '*';

 //  $config['allowed_types'] = 'avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv';
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








  public function single_person()
  {
  	if(check_logged_in())
  		{
  			$current_user = get_user_id();
  			 $data["aside_template"] = "qa/aside.php"; // no change on this sie bar

  			$data["content_template"] = "qa_acc/qa_accs_feedback.php";


  			$data["content_js"] = "qa_accs_js.php";

  		//	$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,157) and status=1 order by name";
  			/* and is_assign_process(id,495) */

        $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";



      	$data["agentName"] = $this->Common_model->get_query_result_array($qSql); // this will display id, name,assigned_to,fusion_id

  			$from_date = $this->input->get('from_date');
  			$to_date = $this->input->get('to_date');


  		//	$fromDate = $this->input->get('from_date');
  			if($from_date!="")
  			{
  				$from_date = mmddyy2mysql($from_date);
  			}

  			//$toDate = $this->input->get('to_date');
  			if($to_date!="")
  			{
  				$to_date = mmddyy2mysql($to_date);
  			}

  			$agent_id = $this->input->get('agent_id');
  				if($agent_id=='') // if no option is choosen
  				{
  					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";

  				}else{
  					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' and agent_id='$agent_id')";
  				}




  			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_new_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";


  			//$data["ajio_inb_v2"] = $this->Common_model->get_query_result_array($qSql); // original
  			$data["qa_accs"] = $this->Common_model->get_query_result_array($qSql);

  			$data["from_date"] = $from_date;
  			$data["to_date"] = $to_date;
  			$data["agent_id"] = $agent_id;

  			$this->load->view("dashboard",$data);
  		}
  }

  public function single_person_acg()
  {
  	if(check_logged_in())
  		{
  			$current_user = get_user_id();
  			 $data["aside_template"] = "qa/aside.php"; // no change on this sie bar

  			$data["content_template"] = "qa_acc/qa_acg_feedback.php";


  			$data["content_js"] = "qa_accs_js.php";

  		//	$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,157) and status=1 order by name";
  			/* and is_assign_process(id,495) */

        $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";



      	$data["agentName"] = $this->Common_model->get_query_result_array($qSql); // this will display id, name,assigned_to,fusion_id

  			$from_date = $this->input->get('from_date');
  			$to_date = $this->input->get('to_date');


  		//	$fromDate = $this->input->get('from_date');
  			if($from_date!="")
  			{
  				$from_date = mmddyy2mysql($from_date);
  			}

  			//$toDate = $this->input->get('to_date');
  			if($to_date!="")
  			{
  				$to_date = mmddyy2mysql($to_date);
  			}

  			$agent_id = $this->input->get('agent_id');
  				if($agent_id=='') // if no option is choosen
  				{
  					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";

  				}else{
  					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' and agent_id='$agent_id')";
  				}




  			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";


  			//$data["ajio_inb_v2"] = $this->Common_model->get_query_result_array($qSql); // original
  			$data["qa_acg"] = $this->Common_model->get_query_result_array($qSql);

  			$data["from_date"] = $from_date;
  			$data["to_date"] = $to_date;
  			$data["agent_id"] = $agent_id;

  			$this->load->view("dashboard",$data);
  		}
  }





  public function edit_qa_accs($ajio_id)  // working file sougata

  {
  	if(check_logged_in()){

  		$_SESSION['id'] = $ajio_id;


  		if(isset($_POST['mgnt_rvw_by']) && $_POST['note'])
  		{

  			//$time_now=mktime(date('h')+5,date('i')+30,date('s'));
  		//	date_default_timezone_set('Asia/Jamaica');
  			//$curDateTime = date('d-m-Y H:i');

			  $curDateTime = date('Y-m-d H:i');
  			$mgnt_rvw_note=$this->input->post('note');
  			$mgnt_rvw_note=ucwords($mgnt_rvw_note);

			  $mgnt_rvw_by=$this->input->post('mgnt_rvw_by');






  			$edit_array = array(
  			"mgnt_rvw_by" => $mgnt_rvw_by,
  			"mgnt_rvw_note" =>$mgnt_rvw_note,
  			"mgnt_rvw_date" => $curDateTime
  		);




  	$this->db->where('id', $ajio_id);
  	$this->db->update('qa_acc_new_feedback',$edit_array);





  	redirect(base_url('qa_acc/single_person'));
  	}
     else{

  	$qSql = " SELECT * from
  	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
  	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
  	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
  	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_new_feedback where id='$ajio_id') xx Left Join
  	(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";






  	$data["accs_list"] = $this->Common_model->get_query_result_array($qSql);
  	$data["aside_template"] = "qa/aside.php";



  	$data["content_template"] = "qa_acc/edit_qa_accs.php"; // working disable for testing



  	$data["content_js"] = "qa_accs_js.php";// js file for this page

  	$this->load->view('dashboard',$data);

     }

  	}
  }



  public function add_qa_accs($ajio_id)  // working file sougata
 {
	 if(check_logged_in()){
	   $current_user=get_user_id();
	   $user_office_id=get_user_office_id();

	   $data["aside_template"] = "qa/aside.php"; // side bar of the page
	   //$data["content_template"] = "qa_ajio/add_edit_ajio_inb_v2.php"; // previuos task
	   $data["content_template"] = "qa_acc/curd_qa_accs.php"; // working disable for testing



	   $data["content_js"] = "qa_accs_js.php";// js file for this page

	   $data['ajio_id']=$ajio_id;




	   $tl_mgnt_cond='';

	   if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
	     $tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
	   }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
	     $tl_mgnt_cond=" and assigned_to='$current_user'";
	   }else{
	     $tl_mgnt_cond="";
	   }


	   $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";


	   $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

	   $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
	   $data['tlname'] = $this->Common_model->get_query_result_array($qSql);


	        $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_new_feedback where id='1') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";


	   $data["qa_accs_curd"] = $this->Common_model->get_query_row_array($qSql);

	   //$curDateTime=CurrMySqlDate();

	   $curDateTime = date('Y-m-d H:i');
	   $a = array();


	   $field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
	   if($field_array['agent_id']){

	     if($ajio_id==0){

	       $field_array=$this->input->post('data');



	       $field_array['audit_date']=CurrDate();
	       $field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
	       $field_array['entry_date']=$curDateTime;
	       $field_array['audit_start_time']=$this->input->post('audit_start_time');
	       $a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_accs/inbound/');
	       $field_array["attach_file"] = implode(',',$a);
	       $rowid= data_inserter('qa_acc_new_feedback',$field_array);
	     ///////////
	       if(get_login_type()=="client"){
	         $add_array = array("client_entryby" => $current_user);
	       }else{
	         $add_array = array("entry_by" => $current_user);
	       }
	       $this->db->where('id', $rowid);
	       //$this->db->update('qa_ajio_inbound_v2_feedback',$add_array);
	       $this->db->update('qa_acc_new_feedback',$add_array);

	    }

	     redirect('qa_acc');
	   }
	   $data["array"] = $a;
	   $this->load->view("dashboard",$data);
	 }
 }

////////////////////////VIKAS START///////////////////////////

 // public function add_edit_qa_acg($ajio_id)  // working file sougata
 // {
	//  if(check_logged_in()){
	//    $current_user=get_user_id();
	//    $user_office_id=get_user_office_id();

	//    $data["aside_template"] = "qa/aside.php"; // side bar of the page
	//    //$data["content_template"] = "qa_ajio/add_edit_ajio_inb_v2.php"; // previuos task
	//    $data["content_template"] = "qa_acc/add_edit_qa_acg"; // working disable for testing



	//    $data["content_js"] = "qa_accs_js.php";// js file for this page

	//    $data['ajio_id']=$ajio_id;




	//    $tl_mgnt_cond='';

	//    if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
	//      $tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
	//    }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
	//      $tl_mgnt_cond=" and assigned_to='$current_user'";
	//    }else{
	//      $tl_mgnt_cond="";
	//    }


	//    $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";


	//    $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

	//    $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
	//    $data['tlname'] = $this->Common_model->get_query_result_array($qSql);


	//         $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback where id='1') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";


	//    $data["qa_acg_curd"] = $this->Common_model->get_query_row_array($qSql);

	//    //$curDateTime=CurrMySqlDate();

	//    $curDateTime = date('Y-m-d H:i');
	//    $a = array();


	//    $field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
	//    if($field_array['agent_id']){

	//      if($ajio_id==0){

	//        $field_array=$this->input->post('data');



	//        $field_array['audit_date']=CurrDate();
	//        $field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
	//        $field_array['entry_date']=$curDateTime;
	//        $field_array['audit_start_time']=$this->input->post('audit_start_time');
	//        $a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_acg/');
	//        $field_array["attach_file"] = implode(',',$a);
	//        $rowid= data_inserter('qa_acg_feedback',$field_array);
	//      ///////////
	//        if(get_login_type()=="client"){
	//          $add_array = array("client_entryby" => $current_user);
	//        }else{
	//          $add_array = array("entry_by" => $current_user);
	//        }
	//        $this->db->where('id', $rowid);
	//        //$this->db->update('qa_ajio_inbound_v2_feedback',$add_array);
	//        $this->db->update('qa_acg_feedback',$add_array);

	//     }

	//      redirect('qa_acc');
	//    }
	//    $data["array"] = $a;
	//    $this->load->view("dashboard",$data);
	//  }
 // }

 public function add_edit_qa_acg( $ajio_id ) {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data["content_template"] = "qa_acc/add_edit_qa_acg.php";
            $data["content_js"] = "qa_accs_js.php";
            $data['ajio_id'] = $ajio_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";

            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );


            $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 order by fname ASC";
            $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT * from
                (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
                (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
                (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
                (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
                from qa_acg_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['qa_acg_curd'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $ajio_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                   // $field_array['audit_date'] = CurrDateTimeMDY();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_acg")){
                        mkdir("./qa_files/qa_acg");
                    }
                    $a = $this->ajio_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_acg/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_acg_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_acg_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where( 'id', $ajio_id );
                    $this->db->update( 'qa_acg_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $ajio_id );
                    $this->db->update( 'qa_acg_feedback', $edit_array );

                }
                redirect( 'qa_acc' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    ////////////////////AGENT PART START//////////////////

 public function agent_acg_feedback()
 {
   if(check_logged_in())
   {
     $user_site_id= get_user_site_id();
     $role_id= get_role_id();
     $current_user = get_user_id();

     $data["aside_template"] = "qa/aside.php";
     $data["content_template"] = "qa_acc/agent_qa_acg_feedback.php";
     //$data["content_template"] = "qa_acc/agent_qa_accs_feedback.php";
     $data["agentUrl"] = "qa_acc/agent_accs_feedback";

   	$data["content_js"] = "qa_accs_js.php";// js file for this page

     $qSql="Select count(id) as value from qa_acc_new_feedback where agent_id='$current_user'";
     $data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

     $qSql="Select count(id) as value from qa_acc_new_feedback where agent_id='$current_user' and agent_rvw_date=' '";
     $data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

     $from_date = '';
     $to_date = '';
     $cond="";
     $user="";

     if($this->input->get('btnView')=='View')
     {
       $from_date = mmddyy2mysql($this->input->get('from_date'));
       $to_date = mmddyy2mysql($this->input->get('to_date'));

       if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";

       if(get_role_dir()=='agent'){
         $user .="where id ='$current_user'";
       }


   	 $qSql= "SELECT * from
	 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback  $cond And agent_id='$current_user'  And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
	 (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

	       $data["qa_acg"] = $this->Common_model->get_query_result_array($qSql);
	     }else{

       $qSql = "SELECT * from
       (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
       (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
       (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
       (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
       (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";

       $data["qa_acg"] = $this->Common_model->get_query_result_array($qSql);
     }

     $data["from_date"] = $from_date;
     $data["to_date"] = $to_date;

     $this->load->view('dashboard',$data);
   }
 }


 public function agent_acg_feedback_rvw($id)
 {
	 	if(check_logged_in()){
	 		$current_user=get_user_id();
	 		$user_office_id=get_user_office_id();
	     $data["aside_template"] = "qa/aside.php";
	     $data["content_template"] = "qa_acc/agent_acg_rvw.php";
	     //$data["content_template"] = "qa_acc/agent_accs_rvw.php";
	     $data["content_js"] = "qa_accs_js.php";

	 		//$data["campaign"] = $campaign;
	 		$data["pnid"]=$id;

	 		$qSql="SELECT * from
	 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback where id='$id') xx Left Join
	 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
	 		$data["agent_acg_rvw"] = $this->Common_model->get_query_row_array($qSql);

	 		if($this->input->post('pnid'))
	 		{
	 			$pnid=$this->input->post('pnid');
	 		//	$curDateTime=CurrMySqlDate();

				 $curDateTime = date('Y-m-d H:i');
	 			$log=get_logs();

	 			$field_array1=array(
	 				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
	 				"agent_rvw_note" => ucwords($this->input->post('note')),
	 				"agent_rvw_date" => $curDateTime
	 			);
	 			$this->db->where('id', $pnid);
	 			$this->db->update("qa_acg_feedback",$field_array1);

	 		  redirect('qa_acc/agent_acg_feedback');

	 		}else{
	 			$this->load->view('dashboard',$data);
	 		}
	 	}
 }

    ////////////////////ENDS AGENT PART//////////////////

 //////////////////////VIKAS ENDS////////////////////////////




 public function agent_accs_feedback()
 {
   if(check_logged_in())
   {
     $user_site_id= get_user_site_id();
     $role_id= get_role_id();
     $current_user = get_user_id();

     $data["aside_template"] = "qa/aside.php";
     $data["content_template"] = "qa_acc/agent_qa_accs_feedback.php";
     $data["agentUrl"] = "qa_acc/agent_accs_feedback";

   	$data["content_js"] = "qa_accs_js.php";// js file for this page

     $qSql="Select count(id) as value from qa_acc_new_feedback where agent_id='$current_user'";
     $data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

     $qSql="Select count(id) as value from qa_acc_new_feedback where agent_id='$current_user' and agent_rvw_date=' '";
     $data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

     $from_date = '';
     $to_date = '';
     $cond="";
     $user="";

     if($this->input->get('btnView')=='View')
     {
       $from_date = mmddyy2mysql($this->input->get('from_date'));
       $to_date = mmddyy2mysql($this->input->get('to_date'));

       if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";

       if(get_role_dir()=='agent'){
         $user .="where id ='$current_user'";
       }


   $qSql= "SELECT * from
	 (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	 (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	 (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	 (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_new_feedback  $cond And agent_id='$current_user'  And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
	 (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

	       $data["qa_accs"] = $this->Common_model->get_query_result_array($qSql);
	     }else{

       $qSql = "SELECT * from
       (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
       (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
       (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
       (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
       (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";





       $data["qa_accs"] = $this->Common_model->get_query_result_array($qSql);
     }

     $data["from_date"] = $from_date;
     $data["to_date"] = $to_date;

     $this->load->view('dashboard',$data);
   }
 }


 public function agent_accs_feedback_rvw($id)
 {
	 	if(check_logged_in()){
	 		$current_user=get_user_id();
	 		$user_office_id=get_user_office_id();
	     $data["aside_template"] = "qa/aside.php";
	     $data["content_template"] = "qa_acc/agent_accs_rvw.php";
	     // $data["content_js"] = "qa_metropolis_js.php";
	     $data["content_js"] = "qa_accs_js.php";

	 		//$data["campaign"] = $campaign;
	 		$data["pnid"]=$id;

	 		$qSql="SELECT * from
	 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acc_new_feedback where id='$id') xx Left Join
	 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
	 		$data["agent_accs_rvw"] = $this->Common_model->get_query_row_array($qSql);

	 		if($this->input->post('pnid'))
	 		{
	 			$pnid=$this->input->post('pnid');
	 		//	$curDateTime=CurrMySqlDate();
	 	//	date_default_timezone_set('Asia/Manila');
	 		//date_default_timezone_set('Asia/Kolkata');

				 $curDateTime = date('Y-m-d H:i');
	 			$log=get_logs();

	 			$field_array1=array(
	 				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
	 				"agent_rvw_note" => ucwords($this->input->post('note')),
	 				"agent_rvw_date" => $curDateTime
	 			);
	 			$this->db->where('id', $pnid);
	 			$this->db->update("qa_acc_new_feedback",$field_array1);

	 		  redirect('qa_acc/agent_accs_feedback');

	 		}else{
	 			$this->load->view('dashboard',$data);
	 		}
	 	}
 }

 public function qa_accs_report() // working
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
 			$data["aside_template"] = "reports_qa/aside.php";
 			$data["content_template"] = "qa_acc/qa_accs_report.php";

 				$data["content_js"] = "qa_accs_js.php";// js file for this page


 			$data['location_list'] = $this->Common_model->get_office_location_list();

 			$office_id = "";
 			$date_from="";
 			$date_to="";
 			$campaign="";
 			$action="";
 			$dn_link="";
 			$cond="";
 			$cond1="";



 		//	$data["qa_ajio_list"] = array();


 				if($this->input->get('show')=='Show')
 				{
 					$date_from = mmddyy2mysql($this->input->get('date_from'));
 					$date_to = mmddyy2mysql($this->input->get('date_to'));
 					$office_id = $this->input->get('office_id');

 					if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";

 					if($office_id=="All") $cond .= "";
 					else $cond .=" and office_id='$office_id'";

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
 					(select d.description from department d left join signin sd on d.id=sd.dept_id where sd.id=entry_by) as auditor_dept,
 					(select r.name from role r left join signin sr on r.id=sr.role_id where sr.id=entry_by) as auditor_role,
 					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
 					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_acc_new_feedback) xx
 					Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

 					$fullAray = $this->Common_model->get_query_result_array($qSql);

 					$data["qa_accs_list"]=$fullAray;









 					$this->create_qa_accs_CSV($fullAray);
 					$dn_link = base_url()."qa_acc/download_qa_accs_CSV";
 				}



 			$data['download_link']=$dn_link;
 			$data["action"] = $action;
 			$data['date_from'] = $date_from;
 			$data['date_to'] = $date_to;




 			//$data['office_id']=$office_id;
 			//$data['campaign']=$campaign;
 			$this->load->view('dashboard',$data);
 		}
 	}



 	public  function download_qa_accs_CSV() // testing sougata
 	{
 		$currDate=date("Y-m-d");

 		$filename = "./qa_files/qa_accs/Report".get_user_id().".csv";
 		$newfile="QA accs  List-'".$currDate."'.csv";
 		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
 		readfile($filename);
 	}









public function create_qa_accs_CSV($rr)
{
		$currDate=date("Y-m-d");


 		$filename = FCPATH . "qa_files/qa_accs/Report".get_user_id().".csv";
 		$fopen = fopen($filename,"w+");


 		$header = array("Auditor Name", "Audit Date ", "Agent Name "," Infraction  ","Infraction Reason", "Fusion ID ", "L1 Supervisor ", "Call Date ", "Audit Type ", "Type of Auditor ","Call ID ", "Earned Score ", "Possible Score ", "Overall Score % ",  "VOC","Interaction Initial Call","Interaction Follow Up 1","Interaction Follow Up 2","Phone No ","Sales","Disposition","UCID", "Opening","Opening Reason", "Greeting ","Greeting Reason", "Owner Discovery", "Owner Discovery Reason","Professionalism","Professionalism Reason","Rebuttals", "Rebuttals  Reason", "Urgency","Urgency Reason ",  "Education regarding Change and improvement customer would get","Education regarding Change and improvement customer would get Reason ", "On call resolution","On call resolution Reason ", "Probing Question","Probing Question Reason ","Product Knowledge","Product Knowledge Reason ", "Resolution/Assistance if customer use any other provider	","Resolution/Assistance if customer use any other provider	Reason ", "Contract Prompt","Contract Prompt Reason "," closing  ", "closing reason","Correct Information","Correct Information Reason ","Audit Start date and  Time ", "Audit End Date and  Time"," Call Interval",  "Call Summary ","Feedback ","Agent Feedback Status ", "Feedback Acceptance","Agent Review Date","Management Review Date ", "Management Review Name ","Management Review Note", "Client Review Name","Client Review Note","Client Review Date " );




 		$row = "";
 		foreach($header as $data) $row .= ''.$data.',';
 		fwrite($fopen,rtrim($row,",")."\r\n");
 		$searches = array("\r", "\n", "\r\n");



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
 				$row .= '"'.$user['audit_date'].'",';
 				$row .= '"'.$user['fname']." ".$user['lname'].'",';
 				$row .= '"'.$user['form_submits'].'",';
         $row .= '"'.$user['extra'].'",';
 				$row .= '"'.$user['fusion_id'].'",';
 				$row .= '"'.$user['tl_name'].'",';
 				$row .= '"'.$user['call_date'].'",';
 				$row .= '"'.$user['audit_type'].'",';
 				$row .= '"'.$user['auditor_type'].'",';

 				$row .= '"'.$user['call_id'].'",';
 				$row .= '"'.$user['earned_score'].'",';
 				$row .= '"'.$user['possible_score'].'",';

 				$row .= '"'.$user['overall_score'].'"% ,';

 				$row .= '"'.$user['voc'].'",';
				 $row .= '"'.$user['Initial'].'",';
				 $row .= '"'.$user['up1'].'",';
				 $row .= '"'.$user['up2'].'",';
				 $row .= '"'.$user['phone_no'].'",';
				 $row .= '"'.$user['sales'].'",';
				 $row .= '"'.$user['Disposition'].'",';
				 $row .= '"'.$user['UCID'].'",';
				 $row .= '"'.$user['Opening'].'",';
				 $row .= '"'.$user['Opening_reason'].'",';
				 $row .= '"'.$user['Greeting'].'",';
				 		$row .= '"'.$user['Greeting_reason'].'",';
				 $row .= '"'.$user['Discovery'].'",';
				 $row .= '"'.$user['Discovery_reason'].'",';
				 $row .= '"'.$user['Professionalism'].'",';
				 $row .= '"'.$user['Professionalism_reason'].'",';
				 $row .= '"'.$user['Rebuttals'].'",';
				 $row .= '"'.$user['Rebuttals_reason'].'",';
				 $row .= '"'.$user['Urgency'].'",';
				 $row .= '"'.$user['Urgency_reason'].'",';



				 $row .= '"'.$user['Education'].'",';
				 $row .= '"'.$user['Education_reason'].'",';
				 		$row .= '"'.$user['Resolution'].'",';
				 $row .= '"'.$user['Resolution_reason'].'",';
				 $row .= '"'.$user['Probing'].'",';
				 $row .= '"'.$user['Probing_reason'].'",';
				 $row .= '"'.$user['Knowledge'].'",';
				 $row .= '"'.$user['Knowledge_reason'].'",';

				 $row .= '"'.$user['assistance'].'",';
				 $row .= '"'.$user['assistance_reason'].'",';
				 $row .= '"'.$user['prompt'].'",';
				 		$row .= '"'.$user['prompt_reason'].'",';
				 $row .= '"'.$user['Closing'].'",';
				 $row .= '"'.$user['Closing_reason'].'",';
				 $row .= '"'.$user['Information'].'",';
				 $row .= '"'.$user['Information_reason'].'",';



 				$row .= '"'.$user['audit_start_time'].'",';
 				$row .= '"'.$user['entry_date'].'",';
 				$row .= '"'.$interval1.'",';
 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
 				$row .= '"'.$user['agnt_fd_acpt'].'",';

 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
 				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
 				$row .= '"'.$user['mgnt_rvw_name'].'",';

 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';




 				$row .= '"'.$user['client_rvw_name'].'",';
 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

 				$row .= '"'.$user['client_rvw_date'].'",';




 				fwrite($fopen,$row."\r\n");
 			}
 			fclose($fopen);
}











  //////////////////////////////////////////////////////////////////////////////////////////////19 december 2022

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






 }
