<?php 

 class Qa_unacademy extends CI_Controller{
	
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

	private function un_upload_files($files,$path)   // this is for file uploaging purpose
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
	
	// private function un_upload_files($files,$path)
 //    {
 //        $config['upload_path'] = $path;
	// 	$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
	// 	$config['max_size'] = '2024000';
	// 	$this->load->library('upload', $config);
	// 	$this->upload->initialize($config);
 //        $images = array();
 //        foreach ($files['name'] as $key => $image) {           
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
				
				
 //            } else {
 //                return false;
 //            }
 //        }
 //        return $images;
 //    }
	
////////////////////////////// Unacademy /////////////////////////////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_unacademy/qa_unacademy_feedback.php";
			//$data["content_js"] = "qa_audit_js.php";
			$data["content_js"] = "qa_unacademy_js.php";
			$from_date="";
			$to_date="";
			$agent_id="";
			$cond="";
			$ops_cond="";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,825) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["auditData"]=array();
			$data["auditData_v2"]=array();
			$data["unacademyActData"]=array();
			
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
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_activation_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
			//////////////////
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_v2_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				$data["auditData_v2"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_activation_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				$data["unacademyActData"] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_unacademy($un_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_unacademy/add_edit_unacademy.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['un_id']=$un_id;
			//$tl_mgnt_cond='';
			
			/* if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			} */
			
			/* $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,199) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql); */
			
			$qSql="Select *, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_unacademy_activation_feedback where id='$un_id'";
			$data["unacademy"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($un_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->un_upload_files($_FILES['attach_file'], $path='./qa_files/qa_unacademy/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_unacademy_activation_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_unacademy_activation_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $un_id);
					$this->db->update('qa_unacademy_activation_feedback',$field_array1);
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
					$this->db->where('id', $un_id);
					$this->db->update('qa_unacademy_activation_feedback',$edit_array);
					
				}
				redirect('qa_unacademy');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_audit($adt_id){ /* version 2 */
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_unacademy/add_edit_audit.php";
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
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,825) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_unacademy_v2_feedback where id='$adt_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($adt_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['call_end_date']=mmddyy2mysql($this->input->post('call_end_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->un_upload_files($_FILES['attach_file'], $path='./qa_files/qa_unacademy/');
						$field_array["attach_file"] = implode(',',$a);
					}
					$rowid= data_inserter('qa_unacademy_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_unacademy_v2_feedback',$add_array);
				/////////////
					$client_report_url = $this->Common_model->get_single_value('Select qa_report_url as value from client where id=377');
					if($client_report_url==""){
						$this->db->query("Update client set qa_report_url='qa_unacademy/qa_unacademy_report' where id=377");
					}
					
					$process_report_url = $this->Common_model->get_single_value('Select qa_url as value from process where id=825');
					if($process_report_url==""){
						$this->db->query("Update process set qa_url='qa_unacademy', qa_agent_url='qa_unacademy/agent_unacademy_feedback' where id=825");
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array1['call_end_date']=mmddyy2mysql($this->input->post('call_end_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->un_upload_files($_FILES['attach_file'], $path='./qa_files/qa_unacademy/');
						$field_array1["attach_file"] = implode(',',$a);
					}
					$this->db->where('id', $adt_id);
					$this->db->update('qa_unacademy_v2_feedback',$field_array1);
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
					$this->db->update('qa_unacademy_v2_feedback',$edit_array);
					
				}
				redirect('qa_unacademy');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_unacademy_activation($unacademy_activation_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_unacademy/add_edit_unacademy_activation.php";
			$data["content_js"] = "qa_unacademy_js.php";
		
			$data['unacademy_activation_id']=$unacademy_activation_id;
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

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,377) and is_assign_process(id,825) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_unacademy_activation_feedback where id='$unacademy_activation_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["unacademy_activation_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($unacademy_activation_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					
					$field_array['call_end_date']=mmddyy2mysql($this->input->post('call_end_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->un_upload_files($_FILES['attach_file'], $path='./qa_files/qa_unacademy/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_unacademy_activation_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_unacademy_activation_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array1['call_end_date']=mmddyy2mysql($this->input->post('call_end_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_unacademy/")){
							mkdir("./qa_files/qa_unacademy/");
						}
						$a = $this->un_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_unacademy/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $unacademy_activation_id);
					$this->db->update('qa_unacademy_activation_feedback',$field_array1);
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
					$this->db->where('id', $unacademy_activation_id);
					$this->db->update('qa_unacademy_activation_feedback',$edit_array);

						/* Randamiser section */
					if($rand_id!=0){
						$rand_cdr_array = array("audit_status" => 1);
						$this->db->where('id', $rand_id);
						$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
						
						$rand_array = array("is_rand" => 1);
						$this->db->where('id', $rowid);
						$this->db->update('qa_unacademy_activation_feedback',$rand_array);
					}

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('Qa_unacademy');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

/*--------------------------------------------------------------------------------------------------*/
/*------------------------------------------ Agent Part --------------------------------------------*/
/*--------------------------------------------------------------------------------------------------*/
	public function agent_unacademy_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_unacademy/agent_feedback.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_unacademy/agent_unacademy_feedback";
			$from_date = '';
			$to_date = '';
			$adtType = '';
			$cond="";
			
			$adtType .=" audit_type not in ('Calibration','Pre-Certificate Mock Call','Certification Audit','QA Supervisor Audit')";
			
			$qSql="Select count(id) as value from qa_unacademy_v2_feedback where agent_id='$current_user' and $adtType";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_unacademy_v2_feedback where agent_id='$current_user' and agent_rvw_date is Null and $adtType";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_unacademy_activation_feedback where agent_id='$current_user' and $adtType";
			$data["tot_act_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_unacademy_activation_feedback where agent_id='$current_user' and agent_rvw_date is Null and $adtType";
			$data["yet_act_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			if($this->input->get('btnView')=='Show')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_v2_feedback $cond and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_activation_feedback $cond and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["unacademy_activation_data"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_v2_feedback where agent_id='$current_user' and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["auditData"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_activation_feedback where agent_id='$current_user' and $adtType) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) ";
				//Where xx.agent_rvw_date is Null
				$data["unacademy_activation_data"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_unacademy_rvw($adt_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_unacademy/agent_rvw.php";
			$data["content_js"] = "qa_audit_js.php";
			$data["agentUrl"] = "qa_unacademy/agent_unacademy_feedback";
			$data["pnid"]=$adt_id;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_v2_feedback where id='$adt_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
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
				$this->db->update('qa_unacademy_v2_feedback',$field_array1);
					
				redirect('qa_unacademy/agent_unacademy_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_unacademy_activation_rvw($adt_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_unacademy/agent_unacademy_activation_rvw.php";
			$data["content_js"] = "qa_unacademy_js.php";
			$data["agentUrl"] = "qa_unacademy/agent_unacademy_feedback";
			$data["pnid"]=$adt_id;

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,377) and is_assign_process(id,825) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_unacademy_activation_feedback where id='$adt_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["unacademy_activation_data"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_unacademy_activation_feedback',$field_array1);
					
				redirect('qa_unacademy/agent_unacademy_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

////////////////////////////////// Report Part //////////////////////////////////////
	public function qa_unacademy_report(){
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
			$data["content_template"] = "qa_unacademy/qa_unacademy_report.php";
			$data["content_js"] = "qa_unacademy_js.php";
			
			//$data['location_list'] = $this->Common_model->get_office_location_list();
			
			//$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$campaign = $this->input->get('campaign');
			
			$data["qa_unacademy_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				//$office_id = $this->input->get('office_id');
				//$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";
		
				/* if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if($audit_type=="All"){ 
					if(get_login_type()=="client"){
						$cond .= "audit_type not in ('Operation Audit','Trainer Audit')";
					}else{
						$cond .= "";
					}
				}else{ 
					$cond .=" and audit_type='$audit_type'";
				}*/
				
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date"; 
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_unacademy_list"] = $fullAray;
				$this->create_qa_unacademy_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_unacademy/download_qa_unacademy_CSV/".$campaign;	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			//$data['office_id']=$office_id;
			//$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_unacademy_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_unacademy_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=="unacademy"){
			$header = array("Auditor Name", "Audit Date", "Educator Name", "L1 Super", "Date of Upload", "Category", "Channel Name", "Channel Link", "Video Link", "Video Duration", "Integration done?", "Integration time stamp when it starts", "Audit Start Time", "Audit End Time", "Interval (in sec)", "Duration Of Subscription Pitch In One Hour Content 90 sec To 6 Minutes", "Price Of Plus Subscription", "Contest Promotion Only If Applicable For The Category", "Plus Product Offering", "Free Test Promotion", "Iconic Promotion Only If Applicable For The Category", "Multiple Obs Screens", "Clear Audio", "Appropriate Frame Educator Window", "Windows Not Activated Error", "Quiz Conducted Using A Different Platform", "Handwritten Notes Used", "Educator Absent In Middle Of The Video", "Video Description Is Missing", "Spelling And Grammatical Errors In Title And Description", "Title And Thumbnail Mismatch", "Missing Links In Description", "Eating/Talking on The Phone During The Class", "A Direct Or Indirect Personal Attack Or Defamatory Remark Against Any Person Or Institution", "Instigating Learners Basis Political Or Religious Beliefs", "Comments Or Remarks Containing Profanity Sexual Innuendo Racial Or Gender Bias", "Seeking The Personal Information Of Unacademy Learners", "Missing Merchandise (T-Shirt Jacket)", "Sharing Personal Information", "Subscription & Promotions", "Tech Quality", "Content Quality", "Team Quality Issue", "Unacceptable Behaviour", "Consolidate data (To be used by Internal Team)", "Call Summary", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment");
		}
		else if($campaign=="unacademy_v2"){
			$header = array("Auditor", "Agent", "Employee MWP ID", "L1/TL Name", "Audit Date", "Ticket/Audit ID", "Call Start Date", "Email", "Call End Date", "Transaction ID For Paid leads only", "BDE Email ID", "Duration", "Time of Call", "Category", "Lead URL", "Audit Type", "Auditor Type", "Predictive CSAT", "Audit Start Date and Time", "Audit End Date and Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score",
			"Call Opening & State the Purpose of call in brief BDE needs to open the Call with- Greetings BDE Name Brand Name Confirmed Learners names Asked for RPC (Right party contact In case the learner name was not clear on lead squared) Informed right designation when asked by learner/parent Open the call within<3sec",
			"Effective probing/probed to profile the learner/eligibility-Profiling* - Which year are you planning to appear for the exam? 2021/2022/2023- Subjects/Exam learner is appearing for? - May I know which class are you in?",
			"Profiling & Eligibility - Need Identification* Learners challenges (Probe)", 
			"Objection Handling- Probed & handled efficiently Leading questions to be asked if the learner is raising any objections so that it can help the BDE to handle the objection in a better way (Only if required) Based on the Call scenario", 
			"Sales Pitch - Explain Iconic Features and Benefits* Mention all the Iconic feature & benefit solving the pain point of the learner", 
			"Sales Pitch - Explained Plus features and benefits as per call scenario Mention all the feature & benefit solving the pain point of the learner Must have - Live class PDF notes Live classes 4th classes are doubt clearing sessions ASK a doubt feature Test series Leaderboard Recorded classes Weekly mock test Live quizzes Good to have - Enrolling with multiple batches and educators Download classes on app PDF notes can be downloaded and printed DPP (Daily practice paper) Doubts can be solved at any time through ASK a doubt feature", 
			"Sales Pitch - Educator credibility:-Learner preference of Educators if anyone in specific other top educators along with educator & Suggested the right batches* BDE should talk about minimum 2 educators:- Educator name with Subject Brief introduction-Accomplishment and milestones achieved Suggestion:-Refer Pitch Assist BDE needs to inform:- Batch Name:- Start date Educator Language Schedule Promote new relevant batches of the popular educators (Ongoing/Upcoming)", 
			"Sales Pitch -Did the BDE pitch new launches/new educator or any promotional offers & Created urgency on the call* BDE needs to inform about the new offers or existing offer Eg: Extension offer etc... The below information to be provided on the call. - TAT for the offer Offer end date If any other conditions applicable If there are any new educators on the platform BDE should try discussing them Urgency Creation Asking few leading questions and guiding the learner with suitable answer", 
			"Sales Pitch - Explain the subscription price & Did the BDE ask if learner has Educator code and then pitch for other discount/referral* BDEs should explain:- Price saving and comparison between longer and shorter duration subscriptionProbe for discount code & then pitch accordingly", 
			"Explain subscription/payment details as per call scenario* BDE needs to check with the learner regarding Payment Option:- 1.By asking payment mode from the learner 2.Providing solutions around it. 3.From Which account learner wants to make the payment", 
			"Sales Pitch - Loan* Applicability If yes:-Entire loan process to be explained 1.Documents 2.Timelines 3.Eligibility Condition", 
			"Sales Pitch - Combo* As per applicability", 
			"PRCA - Pronunciation Rate of Speech Clarity Articulation * BDE should:- 1.Maintain proper tone 2.pitch volume and pace throughout the call", 
			"Documentation - Captured required notes in Nimbus* Complete & accurate notes to be captured in notes section after every connected call", 
			"Documentation - Send relevant Email as per templates* BDE should:- 1.Incorporate- batch details link(only) 2.Emails can be edited basis call scenario 3.Confirm email ID of the learner before sending email to avoid:-Email bounced cases - Reconfirmed with Learner (usage of phonetics to confirm email). Mark tps.quality@unacdemy.com in loop", 
			"Documentation - Follow up - Created/completed* - Need to check if the follow up was created and completed - Need to check if the BDE tried contacting the learner when the call was dropped - While creating follow up in the activity tab select date (Call Back Date) - Follow up to be created on the promise date (EOD)", 
			"Documentation - Correct lead stage selected as per call scenario* Lead stage selection must be accurate basis call conversation",
			"Referral Pitch", 
			"Price Hike", 
			"Male BDE calling female learner post 7:00 PM without taking consent", 
			"Rankers Pitch/Success Stories", 
			"Excessively persuasive or indulged in force selling - Fatal", 
			"Abrupt call closing/Hangup on learner/Inappropriate call closure", 
			"Rude/argumentative/Abusive on call/Mocking/Sarcastic", 
			"Asking/Sharing personal number", 
			"Talking ill about Unacademy & its employees or policies that impact either the learner or BDE", 
			"Deliberate - Malpractice to increase Productivity/Metrics - (Talktime Total dials etc..)", 
			"Financial Fraud - Asking learners bank account detials Card details CVV OTP etc", 
			"Mis-selling",
			"No of Calls Audited", "Lead Stage", "Detailed Comments for feedback", "PSA Date", "What was not pitched in ICONIC", "What was not pitched in PLUS", "Agent Feedback Acceptance", "Agent Review Date and Time", "Agent Review Comment", "Management Review By", "Management Review Date and Time", "Management Review Comment", "Client Review By", "Client Review Date and Time", "Client Review Comment");
			/* "Audit Link", */
		}else if($campaign=="unacademy_activation"){
			$header = array("Auditor", "Agent", "Employee MWP ID", "L1/TL Name", "Audit Date", "Ticket/Audit ID", "Call Start Date", "Email", "Call End Date", "BDE Email ID", "Duration", "Time of Call", "Category", "Lead URL","No of calls audited","KPI - ACPT", "Audit Type", "Auditor Type", "VOC", "Audit Start Date and Time", "Audit End Date and Time", "Interval(In Second)", "Earned Score", "Possible Score", "Overall Score",
				"Call Opening","Reason","Remarks",
				"Effective Probing/Probed to profile the learner/Check learners eligibility","Reason","Remarks",
				"Explain Features and Benefits","Reason","Remarks",
				"Explain Educators Credibility","Reason","Remarks",
				"Objection Handling/ Learner's Query","Reason","Remarks",
				"PRCA - Pronunciation Rate of Speech Clarity Articulation Grammar Sentence construction Fumbling Stammering Casual words Slang Fillers Interruption","Reason","Remarks",
				"Used empathy/Apology statements/Appreciate when required as per call flow","Reason","Remarks",
				"Hold/Dead air.","Reason","Remarks",
				"Customer connect/building rapport/Enthusiastic","Reason","Remarks",
				"Active listening /Understanding/Comprehension","Reason","Remarks",
				"Switch Language as per the Learner convenience","Reason","Remarks",
				"Usage of Jargons","Reason","Remarks",
				"Captured correct notes in LS","Reason","Remarks",
				"Send relevant Email as per templates","Reason","Remarks",
				"Follow up - Created/completed","Reason","Remarks",
				"Correct lead stage selected as per call scenario","Reason","Remarks",
				"Forcing/Begging about Website Navigation","Reason","Remarks",
				"Abrupt call closing/Hangup on learner/Inappropriate call closure/Mocking/ Scarstic/Abssive on the call/Rude","Reason","Remarks",
				"Asking/Sharing personal number","Reason","Remarks",
				"Profiling Form","Reason","Remarks",
				"Email etiquette - Upper case Bold Highlighted Colors etc..","Reason","Remarks",
				"Talking ill about Unacademy & its employees or policies that impact either the learner or BDE","Reason","Remarks",
				"Deliberate - Malpractice to increase Productivity/Metrics - (Talktime Total dials MIs activations etc..)","Reason","Remarks",
				"Not responding to the learner once the call is connected resulted in call drop by learner / side-talking or speaking to someone while the learner is on the line.","Reason","Remarks",
				"Website Navigation","Reason","Remarks",
				"Explianing the Wrong Website navagation Information","Reason","Remarks",
				"Call Closing","Reason","Remarks",
				"Call Summary","Feedback",
			 "Agent Feedback Acceptance", "Agent Review Date and Time", "Agent Review Comment", "Management Review By", "Management Review Date and Time", "Management Review Comment", "Client Review By", "Client Review Date and Time", "Client Review Comment");
			/* "Audit Link", */
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		if($campaign=='unacademy' || $campaign=='unacademy_v2'){
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
				
				$main_urls = base_url().'qa_unacademy/add_edit_audit/'.$user['id'];
				
				$row = '"'.$auditorName.'",';  
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.mysql2mmddyy($user['call_date']).'",';
				$row .= '"'.$user['email'].'",';
				$row .= '"'.mysql2mmddyy($user['call_end_date']).'",';
				$row .= '"'.$user['transaction_id_for_paid'].'",';
				$row .= '"'.$user['bde_email'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['time_of_call'].'",';
				$row .= '"'.$user['category'].'",';
				$row .= '"'.$user['lead_url'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				//$row .= '"'.$main_urls.'",';
				
				$row .= '"'.$user['call_openning'].'",';
				$row .= '"'.$user['effective_probing'].'",';
				$row .= '"'.$user['profilling_eligibility'].'",';
				$row .= '"'.$user['objection_handling'].'",';
				$row .= '"'.$user['explain_features_benefit'].'",';
				$row .= '"'.$user['explain_plus_features'].'",';
				$row .= '"'.$user['educator_credibility'].'",';
				$row .= '"'.$user['bde_pitch_new_launches'].'",';
				$row .= '"'.$user['explain_subscription_price'].'",';
				$row .= '"'.$user['call_scenario_payment_details'].'",';
				$row .= '"'.$user['sales_pitch_loan_applicability'].'",';
				$row .= '"'.$user['sales_pitch_combo'].'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['capture_required_note'].'",';
				$row .= '"'.$user['send_relavant_email'].'",';
				$row .= '"'.$user['follow_up_created'].'",';
				$row .= '"'.$user['correct_lead_stage'].'",';
				$row .= '"'.$user['referral_pitch'].'",';
				$row .= '"'.$user['price_hike'].'",';
				$row .= '"'.$user['male_bde_calling'].'",';
				$row .= '"'.$user['rankers_pitch'].'",';
				$row .= '"'.$user['indulged_force_selling'].'",';
				$row .= '"'.$user['abrupt_call_closing'].'",';
				$row .= '"'.$user['rude_on_call'].'",';
				$row .= '"'.$user['asking_personla_number'].'",';
				$row .= '"'.$user['talking_ill_unacademy'].'",';
				$row .= '"'.$user['increase_productivity'].'",';
				$row .= '"'.$user['financial_fraud'].'",';
				$row .= '"'.$user['mis_selling'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_audited_number'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['lead_stage'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['psa_date'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['not_picthed_iconic'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['not_pitched_plus'])).'",';
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
		}else if($campaign=='unacademy_activation'){
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
				
				$main_urls = base_url().'qa_unacademy/add_edit_audit/'.$user['id'];
				
				$row = '"'.$auditorName.'",';  
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.mysql2mmddyy($user['call_date']).'",';
				$row .= '"'.$user['email'].'",';
				$row .= '"'.mysql2mmddyy($user['call_end_date']).'",';
				$row .= '"'.$user['bde_email'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['time_of_call'].'",';
				$row .= '"'.$user['category'].'",';
				$row .= '"'.$user['lead_url'].'",';
				$row .= '"'.$user['calls_audited_count'].'",';
				$row .= '"'.$user['kpi_acpt'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				//$row .= '"'.$main_urls.'",';
				$row .= '"'.$user['call_openning'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks1'])).'",';
				$row .= '"'.$user['effective_probing'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks2'])).'",';
				$row .= '"'.$user['features_benefits'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks3'])).'",';
				$row .= '"'.$user['educators_credibility'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks4'])).'",';
				$row .= '"'.$user['objection_handling'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks5'])).'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks6'])).'",';
				$row .= '"'.$user['empathy'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks7'])).'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks8'])).'",';
				$row .= '"'.$user['rapport'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks9'])).'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks10'])).'",';
				$row .= '"'.$user['switch_language'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks11'])).'",';
				$row .= '"'.$user['used_Jargons'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks12'])).'",';
				$row .= '"'.$user['correct_notes'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks13'])).'",';
				$row .= '"'.$user['relevant_email'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks14'])).'",';
				$row .= '"'.$user['follow_up'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks15'])).'",';
				$row .= '"'.$user['lead_stage'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks16'])).'",';
				$row .= '"'.$user['forcing_website_navigation'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks17'])).'",';
				$row .= '"'.$user['call_hangup'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks18'])).'",';
				$row .= '"'.$user['sharing_personal_number'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks19'])).'",';
				$row .= '"'.$user['profiling_form'].'",';
				$row .= '"'.$user['cmt20'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks20'])).'",';
				$row .= '"'.$user['email_etiquette'].'",';
				$row .= '"'.$user['cmt21'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks21'])).'",';
				$row .= '"'.$user['talking_ill'].'",';
				$row .= '"'.$user['cmt22'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks22'])).'",';
				$row .= '"'.$user['deliberate_malpractice'].'",';
				$row .= '"'.$user['cmt23'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks23'])).'",';
				$row .= '"'.$user['not_responding'].'",';
				$row .= '"'.$user['cmt24'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks24'])).'",';
				$row .= '"'.$user['website_navigation'].'",';
				$row .= '"'.$user['cmt25'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks25'])).'",';
				$row .= '"'.$user['wrong_website_navagation'].'",';
				$row .= '"'.$user['cmt26'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks26'])).'",';
				$row .= '"'.$user['call_closing'].'",';
				$row .= '"'.$user['cmt27'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks27'])).'",';
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
