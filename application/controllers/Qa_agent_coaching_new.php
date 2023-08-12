<?php

 class Qa_agent_coaching_new extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	//	$this->load->helper('common_functions_helper');
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
	/////////////////////////////////////////////////

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
	public function index(){
		if(check_logged_in())
		{
			//error_reporting(E_ALL);
		    //ini_set('display_errors', 1);
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/qa_coaching_feedback.php";
			$data['sel']="pending";
			$client_id = get_client_ids();

			if(is_access_coach_module()==true){
				$qSQL="SELECT * FROM office_location WHERE is_active=1 ORDER BY office_name";
			}else{
				$qSQL="SELECT * FROM office_location where abbr=(select office_id from signin where id='$current_user') OR (select oth_office_access from signin where id='$current_user') like CONCAT('%',abbr,'%') ORDER BY office_name";
			}
			$data["off_loc"] = $this->Common_model->get_query_result_array($qSQL);
			
			$processSql="SELECT * FROM process where client_id=157 and is_active=1";
			$data["process"] = $this->Common_model->get_query_result_array($processSql);

			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$office_id=$this->input->get('office_id');
			$process_id=$this->input->get('process_id');
			$agent_feedback=$this->input->get('agent_feedback');

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


			$cond="";
			$cond1="";
			$ops_cond="";

			if($from_date!="" && $to_date!==""){
				$cond .= " And (C.audit_date >= '$from_date' and C.audit_date <= '$to_date')";
			}else{
				$cond .="";
			}

			if($office_id!=""){
				$cond .=" and S.office_id='$office_id'";
			}else{
				$cond .="";
			}
			
			if($process_id!=""){
				$cond .=" and is_assign_process(S.id,$process_id)";
			}else{
				$cond .="";
			}

			if($agent_feedback=="Acknowledged"){
				$cond1 .=" and agent_rvw_date is not null";
			}else if($agent_feedback=="Pending"){
				$cond1 .=" and agent_rvw_date is Null";
			}else{
				$cond1 .="";
			}

			if(is_access_coach_module()==true || (get_user_fusion_id()=='FCEB000155' || get_user_fusion_id()=='FCEB000386')){
				$ops_cond="";
			}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond .=" And ((S.assigned_to='$current_user' OR S.assigned_to in (SELECT id FROM signin where assigned_to ='$current_user')) or (C.entry_by='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond .=" And ((S.assigned_to='$current_user') or (C.entry_by='$current_user'))";
			}else{
				$ops_cond .=" And C.entry_by='$current_user'";
			}

			$qSql1="Select count(C.id) as value, S.office_id from qa_coaching_GRBM_feedback C Left Join signin S On S.id=C.agent_id where 1 $cond $ops_cond";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);

			$qSql2="Select count(C.id) as value, S.office_id from qa_coaching_GRBM_feedback C Left Join signin S On S.id=C.agent_id where 1 $cond $ops_cond and C.agent_rvw_date is Null";
			$data["pending_feedback"] =  $this->Common_model->get_single_value($qSql2);

		////////////
			$qSql="Select C.*, CONCAT(S.fname, ' ', S.lname) as agent_name, get_process_names(C.agent_id) AS process_name, S.fusion_id, S.office_id,
					(select CONCAT(fname, ' ', lname) as name from signin s where s.id=(select assigned_to from signin m where m.id=C.agent_id)) as tl_name,
					(select CONCAT(fname, ' ', lname) as name from signin a where a.id=C.entry_by) as auditor_name
					From qa_coaching_GRBM_feedback C
					Left Join signin S On C.agent_id=S.id
					where 1
					$cond $cond1 $ops_cond";
				
			$data["qa_agent_coaching_new_data"] = $this->Common_model->get_query_result_array($qSql);


			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["office_id"] = $office_id;
			$data["process_id"] = $process_id;
			$data["agent_feedback"] = $agent_feedback;
			$this->load->view("dashboard",$data);
		}
	}


	public function getAgentname(){
		if(check_logged_in()){
			$pid=$this->input->post('aid');
			$cid=$this->input->post('cid');
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id,(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=signin.id)) as department_name FROM `signin` where role_id in (select id from role where folder ='agent') and is_assign_client (id,$cid) and is_assign_process (id,$pid) and status=1  order by name";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$tlSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, dept_id,
			(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=signin.id)) as department_name,
			(select office_abbr from site where site.id=(SELECT site_id from signin where id='$aid')) as site_name,
			(select concat(fname, ' ', lname) from signin sc where sc.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($tlSql));
		}
	}

	public function get_client(){

		$client_id = get_client_ids();
		$qSql="SELECT * FROM client where id in ($client_id) and is_active=1";
		$value = $this->Common_model->get_query_result_array($qSql);
		echo  json_encode($value);
	}

	public function processName(){
		$client_id = $this->input->post('aid');
		$qSql="SELECT * FROM process where client_id = $client_id and is_active=1";
		$value = $this->Common_model->get_query_result_array($qSql);
		echo  json_encode($value);
	}


	public function add_edit_feedback($att_id)
	{
		if(check_logged_in()){
			$client_id = get_client_ids();
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/add_edit_feedback.php";
			$data['att_id']=$att_id;

			$cond='';
			if(get_global_access()=='1' || is_access_coach_module()==true){
				$cond .= '';
			}else{
				$cond .= " where id in ($client_id)";
			}
			$qSql="SELECT * FROM client $cond";
			$data['client']= $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent') and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			
				$qSql="SELECT Q.*, S.fusion_id, S.dept_id, CONCAT(S.fname, ' ', S.lname) as agent_name, S.assigned_to, CONCAT(T.fname, ' ', T.lname) as tl_name, get_client_ids(Q.agent_id) as client_id, get_client_names(Q.agent_id) as client_name, get_process_ids(Q.agent_id) AS process_id, get_process_names(Q.agent_id) AS process_name, CONCAT(A.fname, ' ', A.lname)  AS auditor_name, audit_date,
				(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=Q.agent_id)) as department_name,
				(SELECT office_name from office_location ol where ol.abbr=(SELECT office_id from signin sol where sol.id=Q.agent_id)) as location
				from qa_coaching_GRBM_feedback Q 
				Left Join signin S on Q.agent_id = S.id
				Left Join signin T on T.id = S.assigned_to
				Left Join signin A on Q.entry_by = A.id 
				WHERE Q.id=$att_id";
				$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
			


			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($att_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->edu_upload_files($_FILES['attach_file'], $path='./qa_files/qa_att/gbrm/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_coaching_GRBM_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_coaching_GRBM_feedback',$add_array);
					// echo"<pre>";
					// print_r($field_array);
					// echo"</pre>";
					// die();
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $att_id);
					$this->db->update('qa_coaching_GRBM_feedback',$field_array1);
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
					$this->db->where('id', $att_id);
					$this->db->update('qa_coaching_GRBM_feedback',$edit_array);
					
				}
				redirect('Qa_agent_coaching_new');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	public function agent_coaching_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_att/agent_coaching_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_att/agent_att_feedback";


			// $qSql="Select count(id) as value from qa_coaching_GRBM_feedback where agent_id='$current_user'";
			// $data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			// $qSql="Select count(id) as value from qa_coaching_GRBM_feedback where agent_rvw_date is null and agent_id='$current_user'";

			// $data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$from_date = ($this->input->get('from_date'));
			$to_date = ($this->input->get('to_date'));
			$cond="";
			$cond1="";
			$user="";

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

			if($from_date!="" && $to_date!==""){
				$cond1 .= " And (C.audit_date >= '$from_date' and C.audit_date <= '$to_date')";
			}else{
				$cond1 .="";
			}

			$qSql1="Select count(C.id) as value, S.office_id from qa_coaching_GRBM_feedback C Left Join signin S On S.id=C.agent_id  ";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);

			$qSql2="Select count(C.id) as value, S.office_id from qa_coaching_GRBM_feedback C Left Join signin S On S.id=C.agent_id where 1   and C.agent_rvw_date is Null";
			$data["pending_feedback"] =  $this->Common_model->get_single_value($qSql2);


			

			if($this->input->get('btnView')=='View')
			{
				

				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_coaching_GRBM_feedback $cond and agent_id ='$current_user') xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				
				

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_coaching_GRBM_feedback where agent_id='$current_user') xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}
	

	 public function agent_coaching_rvw($pnid){
    if(check_logged_in()){
      $current_user=get_user_id();
      $user_office_id=get_user_office_id();
      $client_id = get_client_ids();
			
      $data['pnid']=$pnid;
      $data["aside_template"] = "qa/aside.php";
      $data["content_template"] = "qa_att/agent_coaching_rvw.php";
     // $data["content_js"] = "qa_audit_js.php";
      $data["agentUrl"] = "qa_att/agent_att_feedback";

      $cond='';
			if(get_global_access()=='1' || is_access_coach_module()==true){
				$cond .= '';
			}else{
				$cond .= " where id in ($client_id)";
			}
      $qSql="SELECT * FROM client $cond";
			$data['client']= $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent') and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT Q.*, S.fusion_id, S.dept_id, CONCAT(S.fname, ' ', S.lname) as agent_name, S.assigned_to, CONCAT(T.fname, ' ', T.lname) as tl_name, get_client_ids(Q.agent_id) as client_id, get_client_names(Q.agent_id) as client_name, get_process_ids(Q.agent_id) AS process_id, get_process_names(Q.agent_id) AS process_name, CONCAT(A.fname, ' ', A.lname)  AS auditor_name, audit_date,
				(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=Q.agent_id)) as department_name,
				(SELECT office_name from office_location ol where ol.abbr=(SELECT office_id from signin sol where sol.id=Q.agent_id)) as location
				from qa_coaching_GRBM_feedback Q 
				Left Join signin S on Q.agent_id = S.id
				Left Join signin T on T.id = S.assigned_to
				Left Join signin A on Q.entry_by = A.id 
				WHERE Q.id=$pnid";

				$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
    

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
        $this->db->update('qa_coaching_GRBM_feedback',$field_array1);
        redirect('Qa_agent_coaching_new/agent_coaching_feedback');

      }else{
        $this->load->view('dashboard',$data);
      }
    }
  }


    //RCA Level 1
    public function rca_level1(){
      return array("system"=>"System","ability"=>"Ability","will"=>"Will","health"=>"Health","cap_issue"=>"Capacity Issue","environment"=>"Environment");
    }

    //RCA Level 2
    public function rca_level2(){
      return array(
        "system_limitation"=>"System Limitation",
        "system_downtime"=>"System Downtime",
        "know_gap"=>"Knowledge Gap",
        "comm_gap"=>"Communication Gap",
        "skill"=>"Skill",
        "identified_out"=>"Identified Outlier",
        "behavorial_issue"=>"Behavorial Issue",
        "lack_of_motive"=>"Lack of Motivation",
        "attend_issue"=>"Attendance Issue",
        "high_call_volume"=>"High Call Volume",
        "background_noise"=>"Background Noise",
        "location"=>"Location",
        "override_access"=>"Override Access",
        "client_acc_req"=>"Client Access Requirement",
        "internet_issue"=>"Internet Issue",
        "hard_issue"=>"Hardware Issue",
        "soft_inaccess"=>"Tool/Software Inaccessible",
        "ineffect_train"=>"Ineffective Training",
        "poor_retention"=>"Poor Retention",
        "poor_update_cascade"=>"Poor Update Cascade",
        "lang_barrier"=>"Language Barrier",
        "poor_comprehension"=>"Poor Comprehension",
        "poor_multi_task_sill"=>"Poor Multi-Tasking Skill"
      );
    }

    //RCA Level 3
    public function rca_level3(){
      return array(
        "client_acc_req"=>"Client Access Requirement",
        "override_access"=>"Override Access",
        "internet_issue"=>"Internet Issue",
        "hard_issue"=>"Hardware Issue",
        "soft_inaccess"=>"Tool/Software Inaccessible",
        "ineffect_train"=>"Ineffective Training",
        "poor_retention"=>"Poor Retention",
        "poor_update_cascade"=>"Poor Update Cascade",
        "lang_barrier"=>"Language Barrier",
        "poor_comprehension"=>"Poor Comprehension",
        "poor_multi_task_sill"=>"Poor Multi-Tasking Skill",
        "compensation"=>"Compensation",
        "lost_hours"=>"Lost Hours",
        "attrition"=>"Attrition"
      );
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// QA AGENT COACHING REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_agent_coaching_report(){
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
			$data["content_template"] = "qa_att/qa_agent_coaching_report.php";
			$data["content_js"] = "qa_audit_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$from_date="";
			$to_date="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";


			$data["qa_agent_coaching_list"] = array();

			if($this->input->get('show')=='Show')
			{
				$from_date = $this->input->get('date_from');
				$to_date = $this->input->get('date_to');
				$office_id = $this->input->get('office_id');
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

				if($from_date !="" && $to_date!=="" )  $cond= " Where (C.audit_date >= '$from_date' and C.audit_date <= '$to_date')";

				if($office_id=="All") $cond .= "";
				else $cond .=" and S.office_id='$office_id'";

				if(get_global_access()=='1' || $client_id==0 || get_user_fusion_id()=='FHIG000001' || get_user_fusion_id()=='FKOL002150'){
					$cond1="";
				}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (S.assigned_to='$current_user' OR S.assigned_to in (SELECT id FROM signin where S.assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And S.assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}


				$qSql="Select C.*, CONCAT(S.fname, ' ', S.lname) as agent_name, get_process_names(C.agent_id) AS process_name, S.fusion_id, S.office_id,
					(select CONCAT(fname, ' ', lname) as name from signin s where s.id=(select assigned_to from signin m where m.id=C.agent_id)) as tl_name,
					(select CONCAT(fname, ' ', lname) as name from signin a where a.id=C.entry_by) as auditor_name,
					(SELECT office_name from office_location ol where ol.abbr=(SELECT office_id from signin sol where sol.id=C.agent_id)) as location,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=C.mgnt_rvw_by) as mgnt_rvw_name,
					(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=C.agent_id)) as dept_name
					From qa_coaching_GRBM_feedback C
					Left Join signin S On C.agent_id=S.id
					$cond $cond1";

        //die;
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_agent_coaching_list"] = $fullAray;
				$this->create_qa_agent_coaching_CSV($fullAray);
				$dn_link = base_url()."qa_agent_coaching_new/download_qa_agent_coaching_CSV";

			}

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $from_date;
			$data['date_to'] = $to_date;
			$data['office_id']=$office_id;

			$this->load->view('dashboard',$data);
		}
	}


	public function download_qa_agent_coaching_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		$newfile="QA Agent Coaching List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_agent_coaching_CSV($rr){
		// print_r($rr);
		// exit;
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Process","site", "Call ID","Coaching Reason", "Coaching Department",
		"Call Type","Observation Method","For Follow Up?","Coaching Documentation",
		"QUALITY:Greeting",
		"QUALITY:comment1",
		"QUALITY:Make it Personal",
		"QUALITY:comment2",
		"QUALITY:Acknowledge",
		"QUALITY:comment3",
		"QUALITY:Empathy",
		"QUALITY:comment4",
		"QUALITY:Reassurance",
		"QUALITY:comment5",
		"QUALITY:CPNI",
		"QUALITY:comment6",
		"QUALITY:Positive Scripting/Positive Positioning",
		"QUALITY:comment7",
		"QUALITY:Hold & Dead Air",
		"QUALITY:comment8",
		"QUALITY:Transfer Procedures",
		"QUALITY:comment9",
		"QUALITY:Escalation Prevention",
		"QUALITY:comment10",
		"QUALITY:Ownership",
		"QUALITY:comment11",
		"QUALITY:Resolution Steps",
		"QUALITY:comment12",
		"QUALITY:Resource Utilization",
		"QUALITY:comment13",
		"QUALITY:Fully Resolve",
		"QUALITY:comment14",
		"QUALITY:Recap",
		"QUALITY:comment15",
		"QUALITY:Additional Assistance",
		"QUALITY:comment16",
		"QUALITY:Proper Closing",
		"QUALITY:comment17",
		"COMPLIANCE:Authentication",
		"COMPLIANCE:comment1",
		"COMPLIANCE:Call Recording Disclaimer",
		"COMPLIANCE:comment2",
		"COMPLIANCE:CPNI",
		"COMPLIANCE:comment3",
		"COMPLIANCE:Was the agent seen retaining collecting accessing and/or using CX information",
		"COMPLIANCE:comment4",
		"COMPLIANCE:Required disclosures",
		"COMPLIANCE:comment5",
		"COMPLIANCE:CBR Disclaimer",
		"COMPLIANCE:comment6",
		"COMPLIANCE:Hold >4 minutes",
		"COMPLIANCE:comment7",
		"COMPLIANCE:Documentation",
		"COMPLIANCE:comment8",
		"COMPLIANCE:Added to CX account without permission",
		"COMPLIANCE:comment9",
		"COMPLIANCE:Vulgar Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call",
		"COMPLIANCE:comment10",
		"COMPLIANCE:Derogatory references",
		"COMPLIANCE:comment11",
		"COMPLIANCE:Rude abusive or discourteous",
		"COMPLIANCE:comment12",
		"COMPLIANCE:Flirting or making social engagements",
		"COMPLIANCE:comment13",
		"COMPLIANCE:Hung up",
		"COMPLIANCE:comment14",
		"COMPLIANCE:Blind transferred",
		"COMPLIANCE:comment15",
		"COMPLIANCE:Intentionally transfer/reassign/redirect the call",
		"COMPLIANCE:comment16",
		"COMPLIANCE:Intentional disseminating of inaccurate information or troubleshooting steps to release the call",
		"COMPLIANCE:comment17",
		"COMPLIANCE:intentionally ignoring cx from the queue",
		"COMPLIANCE:comment18",
		"COMPLIANCE:Camping",
		"COMPLIANCE:comment19",
		"COMPLIANCE:Falsify AT&T’s or Cx records",
		"COMPLIANCE:comment20",
		"COMPLIANCE:Misrepresent or misleading",
		"COMPLIANCE:comment21",

		"Call Summary", "Feedback","Acceptance Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

		foreach($rr as $user)
		{
			$row = '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['agent_name'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['process_name'].'",';
			$row .= '"'.$user['office_id'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", strip_tags($user['coaching_reason']))).'",';
			$row .= '"'.$user['dept_name'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['observation_method'].'",';
			$row .= '"'.$user['for_follow_up'].'",';
			$row .= '"'.$user['coaching_docu'].'",';
			$row .= '"'.$user['greeting'].'",';
			$row .= '"'.$user['cmt1'].'",';
			$row .= '"'.$user['make_it_personal'].'",';
			$row .= '"'.$user['cmt2'].'",';
			$row .= '"'.$user['acknowledge'].'",';
			$row .= '"'.$user['cmt3'].'",';
			$row .= '"'.$user['empathy'].'",';
			$row .= '"'.$user['cmt4'].'",';
			$row .= '"'.$user['reassurance'].'",';
			$row .= '"'.$user['cmt5'].'",';
			$row .= '"'.$user['cpni'].'",';
			$row .= '"'.$user['cmt6'].'",';
			$row .= '"'.$user['positive_scripting'].'",';
			$row .= '"'.$user['cmt7'].'",';
			$row .= '"'.$user['hold_dead_air'].'",';
			$row .= '"'.$user['cmt8'].'",';
			$row .= '"'.$user['transfer_procedure'].'",';
			$row .= '"'.$user['cmt9'].'",';
			$row .= '"'.$user['escalation_prevention'].'",';
			$row .= '"'.$user['cmt10'].'",';
			$row .= '"'.$user['ownership'].'",';
			$row .= '"'.$user['cmt11'].'",';
			$row .= '"'.$user['resolution_steps'].'",';
			$row .= '"'.$user['cmt12'].'",';
			$row .= '"'.$user['resource_utilization'].'",';
			$row .= '"'.$user['cmt13'].'",';
			$row .= '"'.$user['fully_resolve'].'",';
			$row .= '"'.$user['cmt14'].'",';
			$row .= '"'.$user['recap'].'",';
			$row .= '"'.$user['cmt15'].'",';
			$row .= '"'.$user['aditional_assistance'].'",';
			$row .= '"'.$user['cmt16'].'",';
			$row .= '"'.$user['proper_closing'].'",';
			$row .= '"'.$user['cmt17'].'",';
			$row .= '"'.$user['authentication'].'",';
			$row .= '"'.$user['cmt18'].'",';
			$row .= '"'.$user['call_recording_disclamer'].'",';
			$row .= '"'.$user['cmt19'].'",';
			$row .= '"'.$user['compliance_cpni'].'",';
			$row .= '"'.$user['cmt20'].'",';
			$row .= '"'.$user['agent_seen_retaining'].'",';
			$row .= '"'.$user['cmt21'].'",';
			$row .= '"'.$user['required_disclosures'].'",';
			$row .= '"'.$user['cmt22'].'",';
			$row .= '"'.$user['cbr_disclaimer'].'",';
			$row .= '"'.$user['cmt23'].'",';
			$row .= '"'.$user['hold_4_min'].'",';
			$row .= '"'.$user['cmt24'].'",';
			$row .= '"'.$user['documentation'].'",';
			$row .= '"'.$user['cmt25'].'",';
			$row .= '"'.$user['added_cx_acount'].'",';
			$row .= '"'.$user['cmt26'].'",';
			$row .= '"'.$user['offensive_language'].'",';
			$row .= '"'.$user['cmt27'].'",';
			$row .= '"'.$user['derogatory_reference'].'",';
			$row .= '"'.$user['cmt28'].'",';
			$row .= '"'.$user['rude_abusive'].'",';
			$row .= '"'.$user['cmt29'].'",';
			$row .= '"'.$user['making_social_engagement'].'",';
			$row .= '"'.$user['cmt30'].'",';
			$row .= '"'.$user['hung_up'].'",';
			$row .= '"'.$user['cmt31'].'",';
			$row .= '"'.$user['blind_transfer'].'",';
			$row .= '"'.$user['cmt32'].'",';
			$row .= '"'.$user['intentionally_transfer'].'",';
			$row .= '"'.$user['cmt33'].'",';
			$row .= '"'.$user['intentionally_disseminating'].'",';
			$row .= '"'.$user['cmt34'].'",';
			$row .= '"'.$user['intentionally_ignoring'].'",';
			$row .= '"'.$user['cmt35'].'",';
			$row .= '"'.$user['camping'].'",';
			$row .= '"'.$user['cmt36'].'",';
			$row .= '"'.$user['falsify_att'].'",';
			$row .= '"'.$user['cmt37'].'",';
			$row .= '"'.$user['misrepresent'].'",';
			$row .= '"'.$user['cmt38'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
      $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';

			fwrite($fopen,$row."\r\n");
		}

		fclose($fopen);
	}

}
