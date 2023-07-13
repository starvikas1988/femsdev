<?php

 class Qa_romtech extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
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

	private function romtech_upload_files($files,$path)   // this is for file uploaging 
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




	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php"; // no change on this side bar

			$data["content_template"] = "qa_romtech/qa_romtech_feedback.php";
			$data["content_js"] = "qa_romtech_js.php";

    	 $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,344) and is_assign_process (id,718) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

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

			
			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond order by audit_date";

			$data["qa_romtech_admin"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_csat_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond order by audit_date";

			$data["qa_romtechcsat_admin"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_intro_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond order by audit_date";

			$data["qa_romtechintro_admin"] = $this->Common_model->get_query_result_array($qSql);

			//Romtech Inbound////
			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_inbound_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond order by audit_date";

			$data["qa_romtech_inbpound"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}


public function single_person()
{
	if(check_logged_in())
		{
			$current_user = get_user_id();
			 $data["aside_template"] = "qa/aside.php"; // no change on this sie bar

			$data["content_template"] = "qa_romtech/qa_romtech_feedback.php";


			$data["content_js"] = "qa_romtech_js.php";

		
     // $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";


	  $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,344) and status=1  order by name";


    	$data["agentName"] = $this->Common_model->get_query_result_array($qSql); // this will display id, name,assigned_to,fusion_id

			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');

		
			if($from_date!="")
			{
				$from_date = mmddyy2mysql($from_date);
			}

		
			if($to_date!="")
			{
				$to_date = mmddyy2mysql($to_date);
			}

			$agent_id = $this->input->get('agent_id');
				if($agent_id=='') // if no option is choosen
				{
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";

				}elseif($agent_id=='All'){
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
				}
				else{
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' and agent_id='$agent_id')";
				}

			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";

			$data["qa_romtech_admin"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_csat_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";

			$data["qa_romtechcsat_admin"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_intro_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";

			$data["qa_romtechintro_admin"] = $this->Common_model->get_query_result_array($qSql);

			//Romtech Inbound////
			$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_inbound_feedback ) xx Left Join (Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $cond  order by audit_date";

			$data["qa_romtech_inbpound"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
}


public function add_edit_romtech_inbound($romtech_inbound_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_romtech/add_edit_romtech_inbound.php";
			$data["content_js"] = "qa_romtech_js.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data['romtech_inbound_id']=$romtech_inbound_id;
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

			

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,344) and is_assign_process(id,718) and status=1  order by name";
	          $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_romtech_inbound_feedback where id='$romtech_inbound_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["romtech_inbound_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($romtech_inbound_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->romtech_upload_files($_FILES['attach_file'], $path='./qa_files/romtech_inbound/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_romtech_inbound_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_romtech_inbound_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/romtech_inbound/")){
							mkdir("./qa_files/romtech_inbound/");
						}
						$a = $this->romtech_upload_files( $_FILES['attach_file'], $path = './qa_files/romtech_inbound/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $romtech_inbound_id);
					$this->db->update('qa_romtech_inbound_feedback',$field_array1);
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
					$this->db->where('id', $romtech_inbound_id);
					$this->db->update('qa_romtech_inbound_feedback',$edit_array);

					/* Randamiser section */
				if($rand_id!=0){
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_romtech_inbound_feedback',$rand_array);
					}

				}
				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('Qa_romtech');
				}
				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

public function edit_qa_romtech($ajio_id)  // working file sougata

{
	if(check_logged_in()){

		$_SESSION['id'] = $ajio_id;


		if(isset($_POST['mgnt_rvw_by']) && $_POST['note'])
		{

			//$time_now=mktime(date('h')+5,date('i')+30,date('s'));
			date_default_timezone_set('Asia/Manila');
			$curDateTime = date('Y-m-d H:i');
			$mgnt_rvw_note=$this->input->post('note');
			$mgnt_rvw_note=ucwords($mgnt_rvw_note);
			$edit_array = array(
			"mgnt_rvw_by" => $this->input->post('mgnt_rvw_by'),
			"mgnt_rvw_note" =>$mgnt_rvw_note,
			"mgnt_rvw_date" => $curDateTime
		);

	$this->db->where('id', $ajio_id);
	$this->db->update('qa_romtech_feedback',$edit_array);

	redirect(base_url('qa_romtech'));
	}
   else{

	$qSql = " SELECT * from
	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_feedback where id='$ajio_id') xx Left Join
	(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";


	$data["romtech_edit"] = $this->Common_model->get_query_result_array($qSql);
	$data["aside_template"] = "qa/aside.php";



	$data["content_template"] = "qa_romtech/edit_qa_romtech.php"; // working disable for testing



	$data["content_js"] = "qa_romtech_js.php";// js file for this page

	$this->load->view('dashboard',$data);

   }

	}
}

	public function edit_qa_romtech_csat($ajio_id)  

	{
			if(check_logged_in()){

				$_SESSION['id'] = $ajio_id;


				if(isset($_POST['mgnt_rvw_by']) && $_POST['note'])
				{

					//$time_now=mktime(date('h')+5,date('i')+30,date('s'));
					date_default_timezone_set('Asia/Manila');
					$curDateTime = date('Y-m-d H:i');
					$mgnt_rvw_note=$this->input->post('note');
					$mgnt_rvw_note=ucwords($mgnt_rvw_note);
					$edit_array = array(
					"mgnt_rvw_by" => $this->input->post('mgnt_rvw_by'),
					"mgnt_rvw_note" =>$mgnt_rvw_note,
					"mgnt_rvw_date" => $curDateTime
				);


			$this->db->where('id', $ajio_id);
			$this->db->update('qa_romtech_csat_feedback',$edit_array);

			redirect(base_url('qa_romtech'));
			}
		else{

			$qSql = " SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_csat_feedback where id='$ajio_id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["romtech_csat_edit"] = $this->Common_model->get_query_result_array($qSql);
			$data["aside_template"] = "qa/aside.php";

			$data["content_template"] = "qa_romtech/edit_qa_romtech_csat.php"; // working disable for testing

			$data["content_js"] = "qa_romtech_js.php";// js file for this page

			$this->load->view('dashboard',$data);

		}

	}
}

	public function edit_qa_romtech_intro($ajio_id)  

	{
				if(check_logged_in()){

					$_SESSION['id'] = $ajio_id;


					if(isset($_POST['mgnt_rvw_by']) && $_POST['note'])
					{

						//$time_now=mktime(date('h')+5,date('i')+30,date('s'));
						date_default_timezone_set('Asia/Manila');
						$curDateTime = date('Y-m-d H:i');
						$mgnt_rvw_note=$this->input->post('note');
						$mgnt_rvw_note=ucwords($mgnt_rvw_note);
						$edit_array = array(
						"mgnt_rvw_by" => $this->input->post('mgnt_rvw_by'),
						"mgnt_rvw_note" =>$mgnt_rvw_note,
						"mgnt_rvw_date" => $curDateTime
					);


				$this->db->where('id', $ajio_id);
				$this->db->update('qa_romtech_intro_feedback',$edit_array);



				redirect(base_url('qa_romtech'));
				}
			else{

				$qSql = " SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_intro_feedback where id='$ajio_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

				$data["romtech_intro_edit"] = $this->Common_model->get_query_result_array($qSql);
				$data["aside_template"] = "qa/aside.php";



				$data["content_template"] = "qa_romtech/edit_qa_romtech_intro.php"; // working disable for testing



				$data["content_js"] = "qa_romtech_js.php";// js file for this page

				$this->load->view('dashboard',$data);

			}

		}
	}


     public function add_qa_romtech($ajio_id)  // working file sougata

	 {
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php"; // side bar of the page
			
			$data["content_template"] = "qa_romtech/curd_qa_romtech.php"; // working disable for testing


			$data["content_js"] = "qa_romtech_js.php";// js file for this page

			$data['ajio_id']=$ajio_id;


			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}


    //  $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";


			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,344) and status=1  order by name";



    		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);


           $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_feedback where id='1') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";


			$data["qa_romtech_curd"] = $this->Common_model->get_query_row_array($qSql);

			//$curDateTime=CurrMySqlDate();
			date_default_timezone_set('Asia/Manila');
			//date_default_timezone_set('Asia/Kolkata');
		
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
					$a = $this->romtech_upload_files($_FILES['attach_file'], $path='./qa_files/qa_romtech/inbound/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_romtech_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					
					$this->db->update('qa_romtech_feedback',$add_array);

			 }

				redirect('qa_romtech');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_qa_romtech_csat($ajio_id)  // working file sougata

	{
	   if(check_logged_in()){
		   $current_user=get_user_id();
		   $user_office_id=get_user_office_id();

		   $data["aside_template"] = "qa/aside.php"; // side bar of the page
		   
		   $data["content_template"] = "qa_romtech/curd_qa_romtech_csat.php"; // working disable for testing



		   $data["content_js"] = "qa_romtech_js.php";// js file for this page

		   $data['ajio_id']=$ajio_id;




		   $tl_mgnt_cond='';

		   if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			   $tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		   }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			   $tl_mgnt_cond=" and assigned_to='$current_user'";
		   }else{
			   $tl_mgnt_cond="";
		   }


   //  $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,157) and status=1  order by name";


		   $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,344) and status=1  order by name";



		   $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

		   $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
		   $data['tlname'] = $this->Common_model->get_query_result_array($qSql);


		  $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_csat_feedback where id='1') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";


		   $data["qa_romtechcsat_curd"] = $this->Common_model->get_query_row_array($qSql);

		   //$curDateTime=CurrMySqlDate();
		   date_default_timezone_set('Asia/Manila');
		   //date_default_timezone_set('Asia/Kolkata');
	   
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
				   $a = $this->romtech_upload_files($_FILES['attach_file'], $path='./qa_files/qa_romtech/inbound/');
				   $field_array["attach_file"] = implode(',',$a);
				   $rowid= data_inserter('qa_romtech_csat_feedback',$field_array);
			   ///////////
				   if(get_login_type()=="client"){
					   $add_array = array("client_entryby" => $current_user);
				   }else{
					   $add_array = array("entry_by" => $current_user);
				   }
				   $this->db->where('id', $rowid);
				   
				   $this->db->update('qa_romtech_csat_feedback',$add_array);

			}

			   redirect('qa_romtech');
		   }
		   $data["array"] = $a;
		   $this->load->view("dashboard",$data);
	   }
   }


   public function add_qa_romtech_intro($romint_id)
   {
	   if(check_logged_in()){
		   $current_user=get_user_id();
		   $user_office_id=get_user_office_id();
		   $data["aside_template"] = "qa/aside.php";
		   $data["content_template"] = "qa_romtech/curd_qa_romtech_intro.php";
		   $data["content_js"] = "qa_romtech_js.php";
		   $data['romint_id']=$romint_id;
		   $tl_mgnt_cond='';

		   if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			   $tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		   }else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			   $tl_mgnt_cond=" and assigned_to='$current_user'";
		   }else{
			   $tl_mgnt_cond="";
		   }

		   $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,344) and status=1  order by name";
		   $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

		   /* $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
		   $data['tlname'] = $this->Common_model->get_query_result_array($qSql); */


		  $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_intro_feedback where id='$romint_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		  $data["romtech_intro"] = $this->Common_model->get_query_row_array($qSql);

		   $curDateTime=CurrMySqlDate();
		   $a = array();

		   $field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
		   if($field_array['agent_id']){

			   if($romint_id==0){

				   $field_array=$this->input->post('data');
				   $field_array['audit_date']=CurrDate();
				   $field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
				   $field_array['entry_date']=$curDateTime;
				   $field_array['audit_start_time']=$this->input->post('audit_start_time');
				   $a = $this->romtech_upload_files($_FILES['attach_file'], $path='./qa_files/qa_romtech/inbound/');
				   $field_array["attach_file"] = implode(',',$a);
				   $rowid= data_inserter('qa_romtech_intro_feedback',$field_array);
			   ///////////
				   if(get_login_type()=="client"){
					   $add_array = array("client_entryby" => $current_user);
				   }else{
					   $add_array = array("entry_by" => $current_user);
				   }
				   $this->db->where('id', $rowid);
				   $this->db->update('qa_romtech_intro_feedback',$add_array);
				
				} else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $this->db->where('id', $romint_id );
                    $this->db->update('qa_romtech_intro_feedback', $field_array1 );
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
                    $this->db->where('id', $romint_id );
                    $this->db->update('qa_romtech_intro_feedback', $edit_array );
				}
			   redirect('qa_romtech');
		   }
		   $data["array"] = $a;
		   $this->load->view("dashboard",$data);
	   }
   }


/*------------------- Agent Part ---------------------*/

public function agent_romtech_feedback()
{
  if(check_logged_in())
  {
    $user_site_id= get_user_site_id();
    $role_id= get_role_id();
    $current_user = get_user_id();
    $data["aside_template"] = "qa/aside.php";
    $data["content_template"] = "qa_romtech/agent_qa_romtech_feedback.php";
    $data["agentUrl"] = "qa_romtech/agent_romtech_feedback";

  	$data["content_js"] = "qa_romtech_js.php";// js file for this page
	
	$campaign="";
	$from_date = '';
    $to_date = '';
    $cond="";
	$campaign = $this->input->get('campaign');
	$from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
	
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
	
	if($campaign!=""){
		$qSql1="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'WOW Call', 'Hygiene Audit')";
		$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
		
		$qSql2="Select count(id) as value from qa_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'WOW Call', 'Hygiene Audit')";
		$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);
		

		if($this->input->get('btnView')=='View')
		{
		  
		  if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";

			$qSql= "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback  $cond And agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'WOW Call', 'Hygiene Audit')) xx Inner Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			 $data["qa_romtech"] = $this->Common_model->get_query_result_array($qSql);

		/* }else{

			$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'WOW Call', 'Hygiene Audit')) xx Inner Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";

			 $data["qa_romtech"] = $this->Common_model->get_query_result_array($qSql); */
		}
	}

    $data["from_date"] = $from_date;
    $data["to_date"] = $to_date;
	$data['campaign']=$campaign;	

    $this->load->view('dashboard',$data);
  }
}


public function agent_romtech_feedback_rvw($id)

{
	if(check_logged_in()){
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
    $data["aside_template"] = "qa/aside.php";
    $data["content_template"] = "qa_romtech/agent_romtech_rvw.php";
    // $data["content_js"] = "qa_metropolis_js.php";
    $data["content_js"] = "qa_romtech_js.php";

		//$data["campaign"] = $campaign;
		$data["pnid"]=$id;

		$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_feedback where id='$id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["agent_romtech_rvw"] = $this->Common_model->get_query_row_array($qSql);

		if($this->input->post('pnid'))
		{
			$pnid=$this->input->post('pnid');
		//	$curDateTime=CurrMySqlDate();
		date_default_timezone_set('Asia/Manila');
		//date_default_timezone_set('Asia/Kolkata');
			
			$curDateTime = date('Y-m-d H:i');
			$log=get_logs();

			$field_array1=array(
				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
				"agent_rvw_note" => ucwords($this->input->post('note')),
				"agent_rvw_date" => $curDateTime
			);
			$this->db->where('id', $pnid);
			$this->db->update("qa_romtech_feedback",$field_array1);

		  redirect('qa_romtech/agent_romtech_feedback');

		}else{
			$this->load->view('dashboard',$data);
		}
	}
}

public function agent_romtech_csat_feedback_rvw($id)

{
	if(check_logged_in()){
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
    $data["aside_template"] = "qa/aside.php";
    $data["content_template"] = "qa_romtech/agent_romtech_csat_rvw.php";
    // $data["content_js"] = "qa_metropolis_js.php";
    $data["content_js"] = "qa_romtech_js.php";

		//$data["campaign"] = $campaign;
		$data["pnid"]=$id;

		$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_csat_feedback where id='$id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["agent_romtech_csat_rvw"] = $this->Common_model->get_query_row_array($qSql);

		if($this->input->post('pnid'))
		{
			$pnid=$this->input->post('pnid');
		//	$curDateTime=CurrMySqlDate();
		date_default_timezone_set('Asia/Manila');
		//date_default_timezone_set('Asia/Kolkata');
			
			$curDateTime = date('Y-m-d H:i');
			$log=get_logs();

			$field_array1=array(
				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
				"agent_rvw_note" => ucwords($this->input->post('note')),
				"agent_rvw_date" => $curDateTime
			);
			$this->db->where('id', $pnid);
			$this->db->update("qa_romtech_csat_feedback",$field_array1);

		  redirect('qa_romtech/agent_romtech_feedback');

		}else{
			$this->load->view('dashboard',$data);
		}
	}
}


public function agent_romtech_intro_feedback_rvw($id)

{
	if(check_logged_in()){
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_romtech/agent_romtech_intro_rvw.php";
		$data["content_js"] = "qa_romtech_js.php";
		$data["pnid"]=$id;

		$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_intro_feedback where id='$id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["romtech_intro"] = $this->Common_model->get_query_row_array($qSql);

		if($this->input->post('pnid'))
		{
			$pnid=$this->input->post('pnid');
		//	$curDateTime=CurrMySqlDate();
		date_default_timezone_set('Asia/Manila');
		//date_default_timezone_set('Asia/Kolkata');
			
			$curDateTime = date('Y-m-d H:i');
			$log=get_logs();

			$field_array1=array(
				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
				"agent_rvw_note" => ucwords($this->input->post('note')),
				"agent_rvw_date" => $curDateTime
			);
			$this->db->where('id', $pnid);
			$this->db->update("qa_romtech_intro_feedback",$field_array1);

		  redirect('qa_romtech/agent_romtech_feedback');

		}else{
			$this->load->view('dashboard',$data);
		}
	}
}

public function agent_romtech_inbound_feedback_rvw($id)

{
	if(check_logged_in()){
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_romtech/agent_romtech_inbound_feedback_rvw.php";
		$data["content_js"] = "qa_romtech_js.php";
		$data["pnid"]=$id;

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

		$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,344) and is_assign_process(id,718) and status=1  order by name";
	          $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );	

		$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_romtech_inbound_feedback where id='$id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["romtech_inbound_data"] = $this->Common_model->get_query_row_array($qSql);

		if($this->input->post('pnid'))
		{
			$pnid=$this->input->post('pnid');
		//	$curDateTime=CurrMySqlDate();
		date_default_timezone_set('Asia/Manila');
		//date_default_timezone_set('Asia/Kolkata');
			
			$curDateTime = date('Y-m-d H:i');
			$log=get_logs();

			$field_array1=array(
				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
				"agent_rvw_note" => ucwords($this->input->post('note')),
				"agent_rvw_date" => $curDateTime
			);
			$this->db->where('id', $pnid);
			$this->db->update("qa_romtech_inbound_feedback",$field_array1);

		  redirect('qa_romtech/agent_romtech_feedback');

		}else{
			$this->load->view('dashboard',$data);
		}
	}
}


////////////////////////////////////////////////////////////////////////////////////////////
/*------------------------------ Report Part ---------------------------*/
/////////////////////////////////////////////////////////////////////////////////////////////
	public function qa_romtech_report()
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
			$data["content_template"] = "qa_romtech/qa_romtech_report.php";
			$data["content_js"] = "qa_romtech_js.php";

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$from_date="";
			$to_date="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";

			$campaign = $this->input->get('campaign');
			$from_date = mmddyy2mysql($this->input->get('from_date'));
			$to_date = mmddyy2mysql($this->input->get('to_date'));
			$office_id = $this->input->get('office_id');
			
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

			$data["qa_romtech_list"] = array();

			if($this->input->get('show')=='Show')
			{
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";

				if($office_id=="") $cond .= "";
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx
				Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_romtech_list"]=$fullAray;
				$this->create_qa_romtech_CSV($fullAray,$campaign);
				$dn_link = base_url()."qa_romtech/download_qa_romtech_CSV/".$campaign;
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['office_id']=$office_id;
			$data['campaign']=$campaign;
			$this->load->view('dashboard',$data);
		}
	}



	public  function download_qa_romtech_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_romtech/Report".get_user_id().".csv";
		$newfile="QA romtech  List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_romtech_CSV($rr,$campaign)
 	{
		$currDate=date("Y-m-d");
 		$filename = FCPATH . "qa_files/qa_romtech/Report".get_user_id().".csv";
 		$fopen = fopen($filename,"w+");
		
		if($campaign=='romtech'){
			$header = array("Auditor Name", "Audit Date ", "Agent Name "," AHT RCA   ", "Fusion ID ", "L1 Supervisor ", "Call Date ", "Audit Type ", "Type of Auditor ","Call ID ", "Earned Score ", "Possible Score ", "Overall Score % ",  "VOC","L1 ","L2","Phone No ","Customer Call Out ","Hold Exceeded", "Used standard ROMTech greeting message (Hello  My name is xxxxx calling from the ROMTech customer service team Is XXXXX available)","Used standard ROMTech greeting message (Hello  My name is xxxxx calling from the ROMTech customer service team Is XXXXX available) Reason", "Consistent pleasantries used throughout the entire call (Please thank you Excuse me You're Welcome  May I) ","Consistent pleasantries used throughout the entire call (Please thank you Excuse me You're Welcome  May I) Reason", "All call notes documented in Odoo with the correct taxonomy", "All call notes documented in Odoo with the correct taxonomy Reason","The agent followed all company process and policies to resolve the problem","The agent followed all company process and policies to resolve the problem Reason","All internal resources (tools  managers) used to resolve the problem", "All internal resources (tools  managers) used to resolve the problem  Reason", "Overall Call Flow (Long hold times  Dead air)","Overall Call Flow (Long hold times  Dead air) Reason ",  "ROMTech knowledge","ROMTech knowledge Reason ", "Provide clear follow-up instructions (If applicable)","Provide clear follow-up instructions (If applicable) Reason ", "Verify if the patient has any other questions or concerns","Verify if the patient has any other questions or concerns Reason ","Used standard ROMTech closing message (Thank you for contacting ROMTech customer service department)","Used standard ROMTech closing message (Thank you for contacting ROMTech customer service department) Reason ", "Audit Start date and  Time ", "Audit End Date and  Time"," Call Interval",  "Call Summary ","Feedback ","Agent Feedback Status ", "Feedback Acceptance","Agent Review Date","Management Review Date ", "Management Review Name ","Management Review Note", "Client Review Name","Client Review Note","Client Review Date " );
		}else if($campaign=='romtech_intro'){
			$header = array("Auditor Name", "Audit Date/Time", "Agent Name", "Agent MWP ID", "Agent L1 Supervisor", "Call Date", "Customer Call Out", "Call ID", "AHT RCA", "Hold Exceeded", "L1", "L2", "Phone Number", "Type of Audit", "Auditor Type", "VOC", "Earned Score", "Possible Score", "Overall Score", "Audit Start Date/Time", "Audit End Date/Time","Interval(in sec)",
			"Used standard ROMTech greeting message","Reason", "Serving with Empathy-Active Listening","Reason", "Serving with Empathy-Positive Language/Plesantaries(Please thank you Excuse me You are Welcome and May I)","Reason", "Acknowledgements timely and effectively","Reason", "Rate of Speech","Reason", "Did the agent used effective engagement(Fatal)","Reason", "Ensuring all call notes are documented within ROMTech CRM system(Fatal)","Reason", "Ensured patient is educated on all areas of the ROMTech order process(Fatal)","Reason", "Has the agent raised a red flag in odoo whenever required?(Fatal)","Reason", "Ensure all internal processes are followed throughout the call","Reason", "Problem was clearly determined and explained due to having ROMTech knowledge","Reason", "Provide clear follow-up instructions (If applicable)","Reason", "Hold Policy (60 Seconds)","Reason", "Dead Air","Reason", "Hold Verbiage","Reason", "Unprofessionalism(Fatal)","Reason", "Verify if the patinet had any other areas of feedback they wanted to provide","Reason", "Has the agent selected a proper disposition after closing the call?","Reason", "Used standard ROMTech closing message (Thank you for contacting ROMTech customer service department)","Reason",
			"Compliance Score","Business Score","Customer Score",
			"Call Summary","Feedback", "Agent Feedback Status", "Agent Review Date/Time", "Agent Review Comment", "Management Review By", "Management Review Date/Time", "Management Review Note", "Client Review By", "Client Review Date/Time", "Client Review Note");
		}

 		$row = "";
 		foreach($header as $data) $row .= ''.$data.',';
 		fwrite($fopen,rtrim($row,",")."\r\n");
 		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='romtech'){
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

				$row = '"'.$auditorName.'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['aht_rca'].'",';
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
				$row .= '"'.$user['l1'].'",';
				$row .= '"'.$user['l2'].'",';
				$row .= '"'.$user['phone_no'].'",';
				$row .= '"'.$user['customer_call_out'].'",';
				$row .= '"'.$user['hold_exceeded'].'",';
				$row .= '"'.$user['greeting_message'].'",';
				$row .= '"'.$user['greeting_message_reason'].'",';
				$row .= '"'.$user['pleasantries'].'",';
				$row .= '"'.$user['pleasantries_reason'].'",';
				$row .= '"'.$user['documented'].'",';
				$row .= '"'.$user['documented_reason'].'",';
				$row .= '"'.$user['resolve'].'",';
				$row .= '"'.$user['resolve_reason'].'",';
				$row .= '"'.$user['internal_resources'].'",';
				$row .= '"'.$user['internal_resources_reason'].'",';
				$row .= '"'.$user['call_flow'].'",';
				$row .= '"'.$user['call_flow_reason'].'",';
				$row .= '"'.$user['knowledge'].'",';
				$row .= '"'.$user['knowledge_reason'].'",';
				$row .= '"'.$user['follow_up'].'",';
				$row .= '"'.$user['follow_up_reason'].'",';
				$row .= '"'.$user['questions'].'",';
				$row .= '"'.$user['questions_reason'].'",';
				$row .= '"'.$user['closing'].'",';
				$row .= '"'.$user['closing_reason'].'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
				$row .= '"'.$user['client_rvw_date'].'"';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}else if($campaign=='romtech_intro'){
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
			
				$row = '"'.$auditorName.'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['customer_call_out'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['aht_rca'].'",';
				$row .= '"'.$user['hold_exceeded'].'",';
				$row .= '"'.$user['l1'].'",';
				$row .= '"'.$user['l2'].'",';
				$row .= '"'.$user['phone_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'"% ,';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['standard_geeting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['empathy_active_listening'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['empathy_positive_language'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['acknowledgement_timely'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['agent_use_effective_engagement'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['ensure_call_notes_documented'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['ensure_patient_educated'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['agent_raised_red_flag'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['internal_process_followed'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['explain_problem_due_knowledge'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['provide_clear_followup'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['hold_policy_60sec'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['dear_air'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['hold_verbiage'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['unprofessionalism'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'.$user['patient_had_other_feedback'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'.$user['agent_select_proper_disposition'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'.$user['use_standard_closing_massage'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'.$user['compliance_score_percent'].'%'.'",';
				$row .= '"'.$user['business_score_percent'].'%'.'",';
				$row .= '"'.$user['customer_score_percent'].'%'.'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}


 	}






}
