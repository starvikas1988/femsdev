<?php

 class Qa_squad_stack extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
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

  private function squad_stack_upload_files($files,$path)   // this is for file uploaging purpose
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
			$data["content_template"] = "qa_squad_stack/qa_squad_stack_feedback.php";
			$data["content_js"] = "qa_squad_stack_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,359) and is_assign_process(id,757)  and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_squad_stack_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["squad_stack_data"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	///////////////////vikas/////////////////////////////

	public function add_edit_squad_stack($squad_stack_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_squad_stack/add_edit_squad_stack.php";
			$data["content_js"] = "qa_squad_stack_js.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data['squad_stack_id']=$squad_stack_id;
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

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,359) and is_assign_process(id,757) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_squad_stack_feedback where id='$squad_stack_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["squad_stack_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($squad_stack_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->squad_stack_upload_files($_FILES['attach_file'], $path='./qa_files/sea_world/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_squad_stack_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_squad_stack_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/sea_world/")){
							mkdir("./qa_files/sea_world/");
						}
						$a = $this->squad_stack_upload_files( $_FILES['attach_file'], $path = './qa_files/sea_world/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $squad_stack_id);
					$this->db->update('qa_squad_stack_feedback',$field_array1);
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
					$this->db->where('id', $squad_stack_id);
					$this->db->update('qa_squad_stack_feedback',$edit_array);

						/* Randamiser section */
					if($rand_id!=0){
						$rand_cdr_array = array("audit_status" => 1);
						$this->db->where('id', $rand_id);
						$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
						
						$rand_array = array("is_rand" => 1);
						$this->db->where('id', $rowid);
						$this->db->update('qa_squad_stack_feedback',$rand_array);
					}

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('qa_squad_stack');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}





  /////////////////Sea World  Agent part//////////////////////////

	public function agent_squad_stack_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_squad_stack/agent_squad_stack_feedback.php";
			$data["content_js"] = "qa_squad_stack_js.php";
			$data["agentUrl"] = "qa_squad_stack/agent_squad_stack_feedback";


			$qSql="Select count(id) as value from qa_squad_stack_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_squad_stack_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_squad_stack_feedback $cond and agent_id ='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call','QA Supervisor Audit', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				
				

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_squad_stack_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call','QA Supervisor Audit', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}
	
	//////////////////////vikas starts////////////////////////////

	public function agent_squad_stack_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_squad_stack/agent_squad_stack_rvw.php";
			$data["agentUrl"] = "qa_squad_stack/agent_squad_stack_feedback";
			$data["content_js"] = "qa_squad_stack_js.php";
			
			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,359) and is_assign_process(id,757) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );
	      
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_squad_stack_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["squad_stack_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["squad_stack_id"]=$id;	

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
			
			if($this->input->post('squad_stack_id'))
			{
				$squad_stack_id=$this->input->post('squad_stack_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $squad_stack_id);
				$this->db->update('qa_squad_stack_feedback',$field_array);
				
				redirect('qa_squad_stack/agent_squad_stack_feedback');
				
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

	public function qa_squad_stack_report(){
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
			$data["content_template"] = "qa_squad_stack/qa_squad_stack_report.php";
			$data["content_js"] = "qa_squad_stack_js.php";

			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$cond2="";
			$audit_type="";
			$campaign = "squad_stack";

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

			$data["qa_squad_stack_list"] = array();
			//if($this->input->get('show')=='Show') {
			  //$campaign = $this->input->get('campaign');
				
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
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_squad_stack_list"] = $fullAray;
			 

				$this->create_qa_squad_stack_CSV($fullAray,$campaign);

				$dn_link = base_url()."qa_squad_stack/download_qa_squad_stack_CSV/".$campaign;


			//}
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['from_date'] = $date_from;
			$data['to_date'] = $date_to;
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;

			$this->load->view('dashboard',$data);
		}
	}

   ////////////Norther ///////////////////////////////
	public function download_qa_squad_stack_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_squad_stack_CSV($rr,$campaign)
	{

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		if($campaign=="sea_world"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "ACPT", "Evaluation Link", "File/Call ID","Reason of the Call","Site", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Possible Score", "Earned Score", "Overall Score",
			"1a. Uses Proper Greeting.", "Remarks",
			"1b. Uses Proper Closing.", "Remarks",
			"2a. Agent maintained proper tone pitch volume clarity and pace throughout the call.","Remarks",
			"2b. Agent used courteous words and phrases. Also was friendly polite and professional.", "Remarks",
			"2c.The agent adapted their approach to the customer based on the customers unique needs personality and issues.", "Remarks",
			"2d. Active Listening.", "Remarks",
			"3.1.a. Agent takes ownership of the call and resolves all issues that arise throughout the call.", "Remarks",
			"3.1.b. Agent follows all SOP/Policies as stated in SharePoint.", "Remarks",
			"3.1.c. Agent does not blame parks or other departments for problem guest is calling about.", "Remarks",
			"3.1.d.The agent asked pertinent questions to accurately diagnose the guest's need or problem.", "Remarks",
			"3.1.e. Agent used appropropriate resources to address the issue.", "Remarks",
			"3.2.a. Agent is familiar with our products and provides accurate information.", "Remarks",
			"3.2.b. Agent sounds confident and knowledgeable.", "Remarks",
			"3.2.c. Agent presents a sense of urgency whenever applicable.", "Remarks",
			"3.3.a Agent handles call efficiently through effective navigation and by not going over irrelevant products/information.", "Remarks",
			"3.3.b. Uses proper hold procedure - Agent asks guest permission to place them on hold - Agent checks back in on guest every 2 minutes while on hold - Agent does not place guest on any unnecessary holds.", "Remarks",
			"3.3.c. Agent minimized or eliminated dead air.", "Remarks",
			"Ensures to speak with CC holder/authorized user on all accounts/orders prior to making any changes and/or providing private information", "Remarks",
			"Explains Ezpay Contract / Cxl Policies", "Remarks",
			"Never rude to a guest", "Remarks",
			"Leaves COMPLETE notes in all accounts/orders", "Remarks",
			"Qualifies Park by city/state", "Remarks",
			"Uses the correct disposition codes", "Remarks",
			"Call Summary/Observation", "Feedback", "Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)", "Agent Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

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
				$row .= '"'.$user['evaluation_link'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_reason'].'",';
				$row .= '"'.$user['site'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['use_proper_greeting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['use_proper_closing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['proper_tone'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['courteous_words'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['agent_adapted_approach'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['agent_takes_ownership'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['follows_all_SOP'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['blame_parks'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['asked_pertinent_questions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['used_appropropriate_resources'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['accurate_information'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['sounds_confident'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['sense_of_urgency'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['effective_navigation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['proper_hold_procedure'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'.$user['eliminated_dead_air'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';			
				$row .= '"'.$user['use_AMEX'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['use_AMEX_cmt'])).'",';
				$row .= '"'.$user['Cxl_Policies'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['Cxl_Policies_cmt'])).'",';
				$row .= '"'.$user['rude_to_guest'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['rude_to_guest_cmt'])).'",';
				$row .= '"'.$user['leave_complete_notes'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['leave_complete_notes_cmt'])).'",';
				$row .= '"'.$user['qualifies_Park'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qualifies_Park_cmt'])).'",';
				$row .= '"'.$user['correct_disposition_codes'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['correct_disposition_codes_cmt'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
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

		}else if($campaign=="squad_stack_chat"){
			////////////////////////////////////
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "KPI - ACPT", "Field/Call ID","Site", "Call Date", "Chat Duration", "Audit Type", "Auditor Type", "VOC","Skill","Ticket ID","Evaluation Link","Possible Score", "Earned Score", "Overall Score",
				"1a. Proper greeting","LEGEND","REMARKS",
				"1b. Proper Closing","LEGEND","REMARKS",
				"2a. Conversation was clearunderstood uses proper spelling as well as grammer.","LEGEND","REMARKS",
				"2b. Ambassador used courteous & professional words and phrases.","LEGEND","REMARKS",
				"2c. The agent adapted their approach to the customer based on the customer’s unique needs personality and issues.","LEGEND","REMARKS",
				"2d. Active Listening.","LEGEND","REMARKS",
				"3.1.a. Agent takes ownership of the Chat and resolves all issues that arise throughout the Chat.","LEGEND","REMARKS",
				"3.1.b. Agent follows all SOP/Policies as stated in SharePoint or provided by Leadership.","LEGEND","REMARKS",
				"3.1.c. Agent does not blame parks or other departments for problem.","LEGEND","REMARKS",
				"3.1.d. The agent asked pertinent questions to accurately diagnose the guest's need or problem.","LEGEND","REMARKS",
				"3.1.e. Agent used appropropriate resources to address the issue.","LEGEND","REMARKS",
				"3.2.a. Agent is familiar with ourproducts and provides accurate information.","LEGEND","REMARKS",
				"3.2.b. Agent presents a sense of urgency whenever applicable","LEGEND","REMARKS",
				"3.3.a. Agent handles chat efficiently through effective navigation and by not going over irrelevant products or information.","LEGEND","REMARKS",
				"3.3.b. Uses Proper Hold Procedures.","LEGEND","REMARKS",
				"3.3.c. Ambassador minimized or eliminated dead time on Chat.","LEGEND","REMARKS",
				"Qualifies park by city/state","REMARKS",
				"Explains EZpay Contract / Explains cancelation policies","REMARKS",
				"Customer focused at all times (Does not use Rude or Offensive langauge )","REMARKS",
				"Uses the correct Disposition Code","REMARKS",
				"Follows all PCI Policies ( Can't Share CC info )","REMARKS",
				"Leaves COMPLETE notes in all accounts/orders - Agent leaves all names of Leadership that they may have gotten direction from for the issue the guest is calling for - Agent leaves all details of the call on the account or order. - Agent should think of being the next agent contacted from the guest about the same issue. Being the next agent you will want to know what why and the solution was of the call.","REMARKS",
			"Call Summary/Observation", "Feedback", "Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)", "Agent Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

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
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['site'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['site'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['evaluation_link'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['proper_greeting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks1'])).'",';
				$row .= '"'.$user['proper_closing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks2'])).'",';
				$row .= '"'.$user['proper_spelling'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks3'])).'",';
				$row .= '"'.$user['professional_words'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks4'])).'",';
				$row .= '"'.$user['adapted_approach'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks5'])).'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks6'])).'",';
				$row .= '"'.$user['take_ownership'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks7'])).'",';
				$row .= '"'.$user['follows_all_SOP'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks8'])).'",';
				$row .= '"'.$user['blame_parks'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks9'])).'",';
				$row .= '"'.$user['pertinent_questions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks10'])).'",';
				$row .= '"'.$user['appropropriate_resources'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks11'])).'",';
				$row .= '"'.$user['accurate_information'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks12'])).'",';
				$row .= '"'.$user['sense_urgency'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks13'])).'",';
				$row .= '"'.$user['handles_chat_efficiently'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks14'])).'",';
				$row .= '"'.$user['hold_procedures'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks15'])).'",';
				$row .= '"'.$user['dead_time'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks16'])).'",';
				$row .= '"'.$user['qualifies_park'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks17'])).'",';		
				$row .= '"'.$user['cancelation_policies'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks18'])).'",';
				$row .= '"'.$user['customer_focused'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks19'])).'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks20'])).'",';
				$row .= '"'.$user['PCI_policies'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks21'])).'",';
				$row .= '"'.$user['complete_notes'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
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

			///////////////////////////////////
		}
	}

}
