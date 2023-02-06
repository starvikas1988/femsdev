<?php

 class Qa_agent_coaching extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}

	public function index(){
		if(check_logged_in())
		{
			//error_reporting(E_ALL);
		    //ini_set('display_errors', 1);
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_coaching/qa_coaching_feedback.php";
			$data['sel']="pending";
			$client_id = get_client_ids();

			if(get_dept_folder()=="qa" ||  get_global_access()=='1' || $client_id==0){
				$qSQL="SELECT * FROM office_location WHERE is_active=1 ORDER BY office_name";
			}else{
				$qSQL="SELECT * FROM office_location where abbr=(select office_id from signin where id='$current_user') OR (select oth_office_access from signin where id='$current_user') like CONCAT('%',abbr,'%') ORDER BY office_name";
			}
			$data["off_loc"] = $this->Common_model->get_query_result_array($qSQL);

			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$office_id=$this->input->get('office_id');
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

			if($agent_feedback=="Acknowledged"){
				$cond1 .=" and AC.cf_id is not null";
			}else if($agent_feedback=="Pending"){
				$cond1 .=" and AC.cf_id is null";
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

			$qSql1="Select count(C.id) as value, S.office_id from qa_coaching_feedback C Left Join signin S On S.id=C.agent_id where 1 $cond $ops_cond";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);

			$qSql2="Select count(C.id) as value, S.office_id from qa_coaching_feedback C Left Join signin S On S.id=C.agent_id where 1 $cond $ops_cond and C.id not in (select cf_id from qa_coaching_agent_rvw)";
			$data["pending_feedback"] =  $this->Common_model->get_single_value($qSql2);

		////////////
			$qSql="Select C.*, CONCAT(S.fname, ' ', S.lname) as agent_name, get_process_names(C.agent_id) AS process_name, S.fusion_id, S.office_id,
					(select CONCAT(fname, ' ', lname) as name from signin s where s.id=(select assigned_to from signin m where m.id=C.agent_id)) as tl_name,
					(select CONCAT(fname, ' ', lname) as name from signin a where a.id=C.entry_by) as auditor_name,
					AC.cf_id, AC.comment as agent_feedback, AC.entry_date
					From qa_coaching_feedback C
					Left Join signin S On C.agent_id=S.id
					Left Join qa_coaching_agent_rvw AC on C.id=AC.cf_id where 1
					$cond $cond1 $ops_cond";
				//echo $qSql;
			$data["qa_agent_coaching_data"] = $this->Common_model->get_query_result_array($qSql);


			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["office_id"] = $office_id;
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
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id, dept_id, (SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=signin.id)) as department_name FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
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


	public function add_feedback()
	{
		if(check_logged_in()){
			$client_id = get_client_ids();
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_coaching/add_feedback.php";

			$cond='';
			if(get_global_access()=='1' || is_access_coach_module()==true){
				$cond .= '';
			}else{
				$cond .= " where id in ($client_id)";
			}
			$qSql="SELECT * FROM client $cond";
			$data['client']= $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('agent_id')){

				$coaching_reason= $this->input->post('coaching_reason');
				if(!empty($coaching_reason)){
					$coaching_reason=implode(",", $coaching_reason);
				}

				$field_array=array(
					"audit_date" => CurrDate(),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"call_id" => $this->input->post('case_id'),
					"coaching_reason" => $coaching_reason,
          "rca_level1"=>$this->input->post("rca_level1"),
          "rca_level2"=>$this->input->post("rca_level2"),
          "rca_level3"=>$this->input->post("rca_level3"),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"log"=> get_logs()
				);
				$a = $this->mt_upload_files($_FILES['attach_file']);
				if($a==""){
					$field_array["attach_file"]="";
				}else{
					$field_array["attach_file"] = implode(',',$a);
				}
				$rowid= data_inserter('qa_coaching_feedback',$field_array);
			/////////
				$field_array1=array(
					"cf_id" => $rowid,
					"comment" => $this->input->post('coaching_comment'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					'log'=> get_logs()
				);
				data_inserter('qa_coaching_mgnt_rvw',$field_array1);
				redirect('Qa_agent_coaching');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	private function mt_upload_files($files){
        $config['upload_path'] = './qa_files/qa_agent_coaching/';
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
            }else{
                return false;
            }
        }
        return $images;
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

	public function mgnt_agent_coaching_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$client_id=get_client_ids();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_coaching/qa_agent_coaching_mgnt_rvw.php";

      $data['rca_level1']=$this->rca_level1();
      $data['rca_level2']=$this->rca_level2();
      $data['rca_level3']=$this->rca_level3();

			$qSql="select *,(SELECT concat(fname, ' ', lname)  from signin where id=agent_id and role_id in (select id from role where folder ='agent') and dept_id=6 )as name  from qa_coaching_feedback";
			$fields_data = $this->db->query($qSql);
			$data["agentName"] = $fields_data->row();

			$qSql="SELECT * FROM client where id in ($client_id)";
			$data['client']= $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			/*$qSql="SELECT id,agent_id,attach_file,call_date,call_id,(SELECT fusion_id from signin s where s.id=qa_coaching_feedback.agent_id) as fusion_id,(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=qa_coaching_feedback.agent_id)) as department_name,(select office_abbr from site where site.id=(SELECT site_id from signin where id=qa_coaching_feedback.agent_id)) as site_name,(SELECT client_id from info_assign_client where user_id=qa_coaching_feedback.agent_id) as client_id,(select fullname from client c where c.id=(SELECT client_id from info_assign_client where user_id=qa_coaching_feedback.agent_id)) as client_name,(select concat(fname, ' ', lname) as name from signin s where s.id=qa_coaching_feedback.entry_by) as auditor_name,audit_date,(select concat(fname, ' ', lname) from signin s where s.id=qa_coaching_feedback.agent_id) as agent_name,(SELECT `assigned_to` FROM `signin` WHERE id=qa_coaching_feedback.agent_id) as tl_id,(select concat(fname, ' ', lname) from signin s where s.id=(SELECT `assigned_to` FROM `signin` WHERE id=qa_coaching_feedback.agent_id)) as tl_name,(SELECT `process_id` FROM `info_assign_process` WHERE user_id=qa_coaching_feedback.agent_id) as process_id,(select name from process p where p.id=(SELECT `process_id` FROM `info_assign_process` WHERE user_id=qa_coaching_feedback.agent_id)) as process_name from qa_coaching_feedback WHERE id=$id";*/

			$qSql="SELECT Q.*, S.fusion_id, S.dept_id, CONCAT(S.fname, ' ', S.lname) as agent_name, S.assigned_to, CONCAT(T.fname, ' ', T.lname) as tl_name,get_client_ids(Q.agent_id) as client_id, get_client_names(Q.agent_id) as client_name, get_process_ids(Q.agent_id) AS process_id, get_process_names(Q.agent_id) AS process_name, CONCAT(A.fname, ' ', A.lname)  AS auditor_name,audit_date,(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=Q.agent_id)) as department_name from qa_coaching_feedback Q LEFT JOIN  signin S on Q.agent_id = S.id left join signin T on T.id = S.assigned_to left join signin A on Q.entry_by = A.id   WHERE Q.id=$id";
			$data["Qa_agent_coaching"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$id;

			$qSql="SELECT * FROM qa_coaching_agent_rvw where cf_id=$id";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE

			$qSql="SELECT *,(SELECT concat(fname,' ',lname) FROM signin s where s.id=qa_coaching_mgnt_rvw.entry_by) as mgnt_name,(SELECT name FROM role r where r.id=(SELECT role_id FROM signin s where s.id=qa_coaching_mgnt_rvw.entry_by)) as role_name FROM qa_coaching_mgnt_rvw where cf_id=$id";
			$data["row2"] = $this->Common_model->get_query_result_array($qSql);//MGNT PURPOSE

		///////Edit Part///////
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

			////////////
				$field_array1=array(
					"cf_id" => $pnid,
					"comment" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);

				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_coaching_mgnt_rvw',$field_array1);
				}else{
					data_inserter('qa_coaching_mgnt_rvw',$field_array1);
				}
			///////////
				redirect('Qa_agent_coaching');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////

	public function agent_coaching_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_coaching/agent_coaching_feedback.php";

			$data["agentUrl"] = $this->session->userdata('agentUrl');


			$qSql="Select count(id) as value from qa_coaching_feedback where agent_id='$current_user'";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_coaching_feedback where id not in (select cf_id from qa_coaching_agent_rvw) and agent_id='$current_user'";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');

			if($from_date!="") $from_date = mmddyy2mysql($from_date);
			if($to_date!="") $to_date = mmddyy2mysql($to_date);

			if($from_date !="" && $to_date!=="" ){
				$cond= " Where (Q.audit_date>='$from_date' and Q.audit_date<='$to_date' and Q.agent_id='$current_user')";
			}else{
				$cond= " Where Q.agent_id='$current_user'";
			}


			if($this->input->get('btnView')=='View')
			{

				//$qSql = "SELECT id,(select concat(fname, ' ', lname) as name from signin s where s.id=qa_coaching_feedback.entry_by) as auditor_name,audit_date,(select concat(fname, ' ', lname) from signin s where s.id=qa_coaching_feedback.agent_id) as agent_name,(select concat(fname, ' ', lname) from signin s where s.id=(SELECT `assigned_to` FROM `signin` WHERE id=qa_coaching_feedback.agent_id)) as tl_name,(select name from process p where p.id=(SELECT `process_id` FROM `info_assign_process` WHERE user_id=qa_coaching_feedback.agent_id)) as process_name,(select comment from qa_coaching_agent_rvw qag where qag.cf_id=qa_coaching_feedback.id) as agent_feedback,(select comment from qa_coaching_mgnt_rvw qmg where qmg.cf_id=qa_coaching_feedback.id order by id desc limit 1) as mgnt_feedback from qa_coaching_feedback $cond order by qa_coaching_feedback.entry_date desc";

				echo $qSql="SELECT Q.*, CONCAT(S.fname, ' ', S.lname) as agent_name, CONCAT(T.fname, ' ', T.lname) as tl_name, get_process_names(Q.agent_id) AS process_name,
						QC.entry_date as agent_rvw_date, QC.comment as agent_feedback, CONCAT(A.fname, ' ', A.lname)  AS auditor_name,audit_date
						from qa_coaching_feedback Q
						inner join  signin S on Q.agent_id = S.id
						inner join signin T on T.id = S.assigned_to
						left join qa_coaching_agent_rvw QC on QC.cf_id = Q.id
						inner join signin A on Q.entry_by = A.id
						$cond order by Q.entry_date desc";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{

				//$qSql = "SELECT id,(select concat(fname, ' ', lname) as name from signin s where s.id=qa_coaching_feedback.entry_by) as auditor_name,audit_date,(select concat(fname, ' ', lname) from signin s where s.id=qa_coaching_feedback.agent_id) as agent_name,(select concat(fname, ' ', lname) from signin s where s.id=(SELECT `assigned_to` FROM `signin` WHERE id=qa_coaching_feedback.agent_id)) as tl_name,(select name from process p where p.id=(SELECT `process_id` FROM `info_assign_process` WHERE user_id=qa_coaching_feedback.agent_id)) as process_name,(select comment from qa_coaching_agent_rvw qag where qag.cf_id=qa_coaching_feedback.id) as agent_feedback,(select comment from qa_coaching_mgnt_rvw qmg where qmg.cf_id=qa_coaching_feedback.id order by id desc limit 1) as mgnt_feedback from qa_coaching_feedback $cond order by qa_coaching_feedback.entry_date desc";

				$qSql="SELECT Q.*, CONCAT(S.fname, ' ', S.lname) as agent_name, CONCAT(T.fname, ' ', T.lname) as tl_name, get_process_names(Q.agent_id) AS process_name,
						QC.entry_date as agent_rvw_date, QC.comment as agent_feedback, CONCAT(A.fname, ' ', A.lname)  AS auditor_name,audit_date
						from qa_coaching_feedback Q
						inner join  signin S on Q.agent_id = S.id
						inner join signin T on T.id = S.assigned_to
						left join qa_coaching_agent_rvw QC on QC.cf_id = Q.id
						inner join signin A on Q.entry_by = A.id
						where Q.agent_id='$current_user' and QC.entry_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			}



			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}


	public function agent_coaching_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_coaching/qa_agent_coaching_agnt_rvw.php";

			$data["agentUrl"] = $this->session->userdata('agentUrl');

			//$qSql="SELECT id,agent_id,attach_file,call_date,call_id,(SELECT fusion_id from signin s where s.id=qa_coaching_feedback.agent_id) as fusion_id,(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=qa_coaching_feedback.agent_id)) as department_name,(select office_abbr from site where site.id=(SELECT site_id from signin where id=qa_coaching_feedback.agent_id)) as site_name,(SELECT client_id from info_assign_client where user_id=qa_coaching_feedback.agent_id) as client_id,(select fullname from client c where c.id=(SELECT client_id from info_assign_client where user_id=qa_coaching_feedback.agent_id)) as client_name,(select concat(fname, ' ', lname) as name from signin s where s.id=qa_coaching_feedback.entry_by) as auditor_name,audit_date,(select concat(fname, ' ', lname) from signin s where s.id=qa_coaching_feedback.agent_id) as agent_name,(SELECT `assigned_to` FROM `signin` WHERE id=qa_coaching_feedback.agent_id) as tl_id,(select concat(fname, ' ', lname) from signin s where s.id=(SELECT `assigned_to` FROM `signin` WHERE id=qa_coaching_feedback.agent_id)) as tl_name,(SELECT `process_id` FROM `info_assign_process` WHERE user_id=qa_coaching_feedback.agent_id) as process_id,(select name from process p where p.id=(SELECT `process_id` FROM `info_assign_process` WHERE user_id=qa_coaching_feedback.agent_id)) as process_name from qa_coaching_feedback WHERE id=$id";

			$qSql="SELECT Q.*, S.fusion_id, S.dept_id, CONCAT(S.fname, ' ', S.lname) as agent_name, S.assigned_to, CONCAT(T.fname, ' ', T.lname) as tl_name, get_client_ids(Q.agent_id) as client_id, get_client_names(Q.agent_id) as client_name, get_process_ids(Q.agent_id) AS process_id, get_process_names(Q.agent_id) AS process_name, CONCAT(A.fname, ' ', A.lname)  AS auditor_name,audit_date,
			(SELECT description from department d where d.id=(SELECT dept_id from signin s where s.id=Q.agent_id)) as department_name
				from qa_coaching_feedback Q
				inner join  signin S on Q.agent_id = S.id
				inner join signin T on T.id = S.assigned_to
				inner join signin A on Q.entry_by = A.id
				WHERE Q.id=$id";
			$data["agent_coaching"] = $this->Common_model->get_query_row_array($qSql);

			$data["pnid"]=$id;

			$qSql="SELECT * FROM qa_coaching_agent_rvw where cf_id=$id";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE

			$qSql="SELECT *,(SELECT concat(fname,' ',lname) FROM signin s where s.id=qa_coaching_mgnt_rvw.entry_by) as mgnt_name,(SELECT name FROM role r where r.id=(SELECT role_id FROM signin s where s.id=qa_coaching_mgnt_rvw.entry_by)) as role_name FROM qa_coaching_mgnt_rvw where cf_id=$id";
			$data["row2"] = $this->Common_model->get_query_result_array($qSql);//MGNT PURPOSE

			$string_length = str_word_count($this->input->post('note'), 0);
			//echo 'DEB - '.$string_length;

			if($this->input->post('pnid') && $string_length!=0)
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();

				$field_array1=array(
					"cf_id" => $pnid,
					"comment" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);

				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_coaching_agent_rvw',$field_array1);
				}
				// }else{
				// 	$this->db->where('fd_id', $pnid);
				// 	$this->db->update('qa_coaching_agent_rvw',$field_array1);
				// }

				redirect('Qa_agent_coaching/agent_coaching_feedback');

			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_agent_coaching/qa_agent_coaching_report.php";

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
				// $date_from = mmddyy2mysql($this->input->get('date_from'));
				// $date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');

				$from_date = $this->input->get('date_from');
				$to_date = $this->input->get('date_to');
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

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";

				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}

				$qSql="SELECT call_date,call_id,(select concat(fname, ' ', lname) from signin s where s.id=qa_coaching_mgnt_rvw.entry_by) as mgnt_name,qa_coaching_mgnt_rvw.comment as mgnt_note,qa_coaching_mgnt_rvw.entry_date as mgnt_feedback,(select office_abbr from site where site.id=(SELECT site_id from signin where id=qa_coaching_feedback.agent_id)) as site_name,(select fullname from client c where c.id=(SELECT client_id from info_assign_client where user_id=qa_coaching_feedback.agent_id)) as client_name,(select concat(fname, ' ', lname) as name from signin s where s.id=qa_coaching_feedback.entry_by) as auditor_name,audit_date,(select fusion_id from signin s where s.id=qa_coaching_feedback.agent_id) as fusion_id,(select concat(fname, ' ', lname) from signin s where s.id=qa_coaching_feedback.agent_id) as agent_name,(select concat(fname, ' ', lname) from signin s where s.id=(SELECT `assigned_to` FROM `signin` WHERE id=qa_coaching_feedback.agent_id)) as tl_name,(select name from process p where p.id=(SELECT `process_id` FROM info_assign_process as iap WHERE iap.user_id=qa_coaching_feedback.agent_id)) as process_name,(select entry_date from qa_coaching_agent_rvw qag where qag.cf_id=qa_coaching_feedback.id) as agent_feedback,(select comment from qa_coaching_agent_rvw qag where qag.cf_id=qa_coaching_feedback.id) as agent_note from qa_coaching_feedback INNER JOIN qa_coaching_mgnt_rvw on qa_coaching_feedback.id=qa_coaching_mgnt_rvw.cf_id $cond $cond1 order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				//print_r($fullAray);
				//die;
				$data["qa_agent_coaching_list"] = $fullAray;
				$this->create_qa_agent_coaching_CSV($fullAray);
				$dn_link = base_url()."Qa_agent_coaching/download_qa_agent_coaching_CSV";

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
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Agent Coaching List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_agent_coaching_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Process","site", "Call ID", "Coaching Reason", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");

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
			$row .= '"'.$user['site_name'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", strip_tags($user['coaching_reason']))).'",';
			$row .= '"'.$user['agent_feedback'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", strip_tags($user['agent_note']))).'",';
			$row .= '"'.$user['mgnt_feedback'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", strip_tags($user['mgnt_note']))).'"';

			fwrite($fopen,$row."\r\n");
		}

		fclose($fopen);
	}


 }
