<?php

 class Qa_clever_care extends CI_Controller{

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

  private function clever_care_upload_files($files,$path)   // this is for file uploaging purpose
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

/////////////////Home Sea World vikas//////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_clever_care/qa_clever_care_feedback.php";
			$data["content_js"] = "qa_clever_care_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,381) and is_assign_process (id,904)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			//is_assign_client (id,374) and is_assign_process (id,818)

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_clever_care_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["clever_care_data"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	///////////////////vikas/////////////////////////////

	public function add_edit_clever_care($clever_care_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_clever_care/add_edit_clever_care.php";
			$data["content_js"] = "qa_clever_care_js.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data['clever_care_id']=$clever_care_id;
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

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,381) and is_assign_process(id,904) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_clever_care_feedback where id='$clever_care_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["clever_care_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($clever_care_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->clever_care_upload_files($_FILES['attach_file'], $path='./qa_files/clever_care/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_clever_care_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_clever_care_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/clever_care/")){
							mkdir("./qa_files/clever_care/");
						}
						$a = $this->clever_care_upload_files( $_FILES['attach_file'], $path = './qa_files/clever_care/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $clever_care_id);
					$this->db->update('qa_clever_care_feedback',$field_array1);
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
					$this->db->where('id', $clever_care_id);
					$this->db->update('qa_clever_care_feedback',$edit_array);

						/* Randamiser section */
					if($rand_id!=0){
						$rand_cdr_array = array("audit_status" => 1);
						$this->db->where('id', $rand_id);
						$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
						
						$rand_array = array("is_rand" => 1);
						$this->db->where('id', $rowid);
						$this->db->update('qa_clever_care_feedback',$rand_array);
					}

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('qa_clever_care');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}



  /////////////////Sea World  Agent part//////////////////////////

	public function agent_clever_care_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_clever_care/agent_clever_care_feedback.php";
			$data["content_js"] = "qa_clever_care_js.php";
			$data["agentUrl"] = "qa_clever_care/agent_clever_care_feedback";


			$qSql="Select count(id) as value from qa_clever_care_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_clever_care_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";

			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);


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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_clever_care_feedback $cond and agent_id ='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call','QA Supervisor Audit', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				
				

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_clever_care_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call','QA Supervisor Audit', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}
	
	//////////////////////vikas starts////////////////////////////

	public function agent_clever_care_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_clever_care/agent_clever_care_rvw.php";
			$data["agentUrl"] = "qa_clever_care/agent_clever_care_feedback";
			$data["content_js"] = "qa_clever_care_js.php";
			
			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,381) and is_assign_process(id,904) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );
	      
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_clever_care_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["clever_care_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["clever_care_id"]=$id;	

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
			
			if($this->input->post('clever_care_id'))
			{
				$clever_care_id=$this->input->post('clever_care_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $clever_care_id);
				$this->db->update('qa_clever_care_feedback',$field_array);
				
				redirect('qa_clever_care/agent_clever_care_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	//////////////////////vikas ends///////////////////////
	

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
////////////////////////////////////// QA Sea World REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_clever_care_report(){
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

			$data["aside_template"] = "reports_qa/aside.php";
			$data["content_template"] = "qa_clever_care/qa_clever_care_report.php";
			$data["content_js"] = "qa_clever_care_js.php";

			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$cond2="";
			$audit_type="";

			$date_from = ($this->input->get('from_date'));
			$date_to = ($this->input->get('to_date'));

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

			$data["qa_clever_care_list"] = array();
			//if($this->input->get('show')=='Show') {
			   // $campaign = $this->input->get('campaign');
				
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";

				if($audit_type=="All" || $audit_type=="") $cond2 .= "";
				else $cond2 .=" and audit_type='$audit_type'";

				

				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";

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
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_clever_care_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_clever_care_list"] = $fullAray;
			 

				$this->create_qa_clever_care_CSV($fullAray);

				$dn_link = base_url()."qa_clever_care/download_qa_clever_care_CSV";


			//}
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['from_date'] = $date_from;
			$data['to_date'] = $date_to;
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;

			$this->load->view('dashboard',$data);
		}
	}

   ////////////Norther ///////////////////////////////
	public function download_qa_clever_care_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Clever Care Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_clever_care_CSV($rr)
	{

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
	
		 $header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "KPI - ACPT","Call Link","Account","	Record Id","Disposition", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Possible Score", "Earned Score", "Overall Score",
		 	"Q1.Agent mentioned his/her name trading name and determined speaking to the correct person.",
		 	"Remarks1",
		 	"Q2.Agent mentioned the reason of the call through paraphrasing.",
		 	"Remarks2",
		 	"Q3.Demonstrated call control effectively throughout the call by listening and acknowledging the customers needs - explicit and implicit.",
		 	"Remarks3",
		 	"Q4.Maintained friendly demeanor built rapport and connected with the customer.",
		 	"Remarks4",
		 	"Q5.Agent communicates effectively and does not have a negative effect to overall customer experience.",
		 	"Remarks5",
		 	"Q6.The agents voice is clear and can be understood throughout the call.",
		 	"Remarks6",
		 	"Q7.The agent speaks with consistent speed or pace matching the customers?",
		 	"Remarks7",
		 	"Q8.Actively engaged with the customer.",
		 	"Remarks8",
		 	"Q9.Displayed knowledge of the product tied features to benefits/ demonstrates working knowledge of procedures and health.",
		 	"Remarks9",
		 	"Q10.Did the agent listen to the customer and addressed all concerns/questions?",
		 	"Remarks10",
		 	"Q11.Appropriately managed and handled objections - the agent used appropriate rebuttals and provides a solution removing obstacles in the wat to guide a purchase decision at the time.",
		 	"Remarks11",
		 	"Q12.Did the agent investigate the account properly?",
		 	"Remarks12",
		 	"Q13.Identified customer needs getting the facts on the table.",
		 	"Remarks13",
		 	"Q14.Did the agent understand the customers priorities?",
		 	"Remarks14",
		 	"Q15.Did the agent check the customers availabilty?",
		 	"Remarks15",
		 	"Q16.Did the agent check the customers readiness?",
		 	"Remarks16",
		 	"Q17.Did the agent check the customer's ability to make decisions?",
		 	"Remarks17",
		 	"Q18.Did the agent dispose the call properly?",
		 	"Remarks18",
		 	"Q19.Did the agent document the call properly? (Interaction).",
		 	"Remarks19",
		 	"Q20.Did the agent verify all the information (HIPAA Compliance).",
		 	"Remarks20",
		 	"Q21.Did the agent manipulate client/s information?",
		 	"Remarks21",
    "Call Summary/Observation","Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)",  "Feedback","Agent Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

		

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

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
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['call_link'].'",';
				$row .= '"'.$user['account'].'",';
				$row .= '"'.$user['record_id'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['trading_name'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['reason_of_call'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['acknowledging_customer'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['built_rapport'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['negative_effect'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['voice_clear'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['pace_matching'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['actively_engaged'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['features_to_benefits'].'",';
				$row .= '"'.$user['cmt9'].'",';
        $row .= '"'.$user['addressed_concerns'].'",';
        $row .= '"'.$user['cmt10'].'",';
        $row .= '"'.$user['handled_objections'].'",';
        $row .= '"'.$user['cmt11'].'",';
        $row .= '"'.$user['investigate_account'].'",';
        $row .= '"'.$user['cmt12'].'",';
        $row .= '"'.$user['getting_facts'].'",';
        $row .= '"'.$user['cmt13'].'",';
        $row .= '"'.$user['customers_priorities'].'",';
        $row .= '"'.$user['cmt14'].'",';
        $row .= '"'.$user['customers_availabilty'].'",';
        $row .= '"'.$user['cmt15'].'",';
        $row .= '"'.$user['customers_readiness'].'",';
        $row .= '"'.$user['cmt16'].'",';
        $row .= '"'.$user['make_decisions'].'",';
        $row .= '"'.$user['cmt17'].'",';
        $row .= '"'.$user['dispose_call_properly'].'",';
        $row .= '"'.$user['cmt18'].'",';
        $row .= '"'.$user['document_call_properly'].'",';
        $row .= '"'.$user['cmt19'].'",';
        $row .= '"'.$user['verify_information'].'",';
        $row .= '"'.$user['cmt20'].'",';
        $row .= '"'.$user['manipulate_information'].'",';
        $row .= '"'.$user['cmt21'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
	      $row .= '"'.$user['entry_date'].'",';
	      $row .= '"'.$interval1.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_name'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';

  			$row .= '"'.$user['client_rvw_date'].'",';

				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
	}
}
