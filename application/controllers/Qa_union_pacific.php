<?php

 class Qa_union_pacific extends CI_Controller{

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

  private function union_pacific_upload_files($files,$path)   // this is for file uploaging purpose
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
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_union_pacific/qa_union_pacific_feedback.php";
	
			$data["content_js"] = "qa_union_pacific_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,417) and is_assign_process(id,900) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			$ops_cond="";

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

			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_user_fusion_id()=='FJAM005191' || get_user_fusion_id()=='FJAM004241'){
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

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_union_pacific_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["union_pacific_data"] = $this->Common_model->get_query_result_array($qSql);


			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	/////////////vikas starts///////////////////////

public function add_edit_union_pacific($union_pacific_data_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_union_pacific/add_edit_union_pacific.php";
			$data["content_js"] = "qa_union_pacific_js.php";
			$data['union_pacific_data_id']=$union_pacific_data_id;
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

			

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,417) and is_assign_process(id,900) and status=1  order by name";
	          $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_union_pacific_feedback where id='$union_pacific_data_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["union_pacific_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($union_pacific_data_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->union_pacific_upload_files($_FILES['attach_file'], $path='./qa_files/qa_union_pacific/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_union_pacific_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_union_pacific_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_union_pacific/")){
							mkdir("./qa_files/qa_union_pacific/");
						}
						$a = $this->union_pacific_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_union_pacific/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $union_pacific_data_id);
					$this->db->update('qa_union_pacific_feedback',$field_array1);
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
					$this->db->where('id', $union_pacific_data_id);
					$this->db->update('qa_union_pacific_feedback',$edit_array);

					/* Randamiser section */
				if($rand_id!=0){
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_union_pacific_feedback',$rand_array);
					}

				}
				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('Qa_union_pacific');
				}
				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
	}
}


	/////////////vikas ends/////////////////////////

/*------------------- Agent Part ---------------------*/

	public function agent_union_pacific_feedback(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_union_pacific/agent_union_pacific_feedback.php";
			$data["content_js"] = "qa_union_pacific_js.php";
			$data["agentUrl"] = "qa_union_pacific/agent_union_pacific_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign = 'union_pacific';
			$cond="";
			//$campaign = $this->input->get('campaign');

			$fromDate = $this->input->get('from_date');
			$toDate = $this->input->get('to_date');
			

			if($fromDate==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($fromDate);
			}
			
			if($toDate==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($toDate);
			}
			
		
				
				$qSql="Select count(id) as value from qa_union_pacific_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_union_pacific_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit') and agent_rvw_date is Null";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

				if($from_date!="" && $to_date!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit') ";
					}
				
				if($this->input->get('btnView')=='View')
				{
					
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_union_pacific_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
					
				}else{
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_union_pacific_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
			
			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}


	public function agent_union_pacific_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_union_pacific/agent_union_pacific_rvw.php";
			$data["content_js"] = "qa_union_pacific_js.php";
			$data["agentUrl"] = "qa_union_pacific/agent_union_pacific_feedback";

			$campaign = 'union_pacific';

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
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_union_pacific_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["union_pacific_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			//$data["campaign"]=$campaign;
			
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
				$this->db->update('qa_union_pacific_feedback',$field_array1);
					
				redirect('qa_union_pacific/agent_union_pacific_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


/*-------------- Report Part ---------------*/
	public function qa_union_pacific_report(){
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
			$data["content_template"] = "qa_union_pacific/qa_union_pacific_report.php";
			$data["content_js"] = "qa_union_pacific_js.php";

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";

			$data["qa_union_pacific_list"] = array();

			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');

				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";

				if($audit_type=="All"){
					if(get_login_type()=="client"){
						$cond .= "audit_type not in ('Operation Audit','Trainer Audit')";
					}else{
						$cond .= "";
					}
				}else{
					$cond .=" and audit_type='$audit_type'";
				}

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_union_pacific_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_union_pacific_list"] = $fullAray;
				$this->create_qa_union_pacific_CSV($fullAray);
				$dn_link = base_url()."qa_union_pacific/download_qa_union_pacific_CSV/";
			}

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$this->load->view('dashboard',$data);
		}
	}


	public function download_qa_union_pacific_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Union Pacific Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_union_pacific_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Supervisor", "Call Date", "Call Duration", "Call Link", "Account", "KPI - ACPT", "Audit Type","Auditor Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Earned Score","Possible Score", "Overall Score",
			"Opening: Identify himself/herself by first name and state that he/she is calling from Union Pacific or LOUP at the beginning of the call? **SQ** (Example: Hi this is Amity calling from Union Pacific)",
			"Opening : Provide the Quality Assurance Statement verbatim before any specific account information was discussed?**SQ** Recording disclosure: All calls are recorded and may be monitored for Quality Assurance.",
			"Opening: Did the agent get caller's name and then use that throughout the call?",
			"Opening: State the client name and the purpose of the communication?",
			"Opening: Did the rep ask for callback permission as per Reg F policy?",
			"Opening: Sate/Ask for balance due?",
			"Effort: Ask for a reason for delinquency/intention to resolve the account?",
			"Effort: Full and Complete information taken? Examples: Did the agent ask appropriate open/close ended probing questions?",
			"Effort: Followed the previous conversations on the account for the follow-up call.",
			"Effort: Able to take a promise to pay on the account by providing banking info as to where the RP can send their payment?",
			"Compliance: Did not Misrepresent their identity or authorization and status of the consumers account?",
			"Compliance: Did not Discuss or imply that any type of legal actions - will be taken or property repossessed also on time barred accounts amd Did not Threaten to take actions that VRS or the client cannot legally take?",
			"Compliance: Did not Make any false representations regarding the nature of the communication?",
			"Compliance: Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 5:00 pm CST? Note: Avoid calling customer's personal phone during evening/nightime.",
			"Compliance: Did not Communicate with the consumer after learning the consumer is represented by an attorney filed for bankruptcy unless a permissible reason exists? (account should be escalated back to UP if this conversation has occurred)",
			"Compliance: Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?",
			"Compliance: Did not Make any statement that could constitute unfair deceptive or abusive acts or practices that may raise UDAAP concerns?",
			"Compliance: Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?",
			"Compliance: Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint or offer to escalate the call?",
			"Compliance: Did not Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?",
			"Verification: Demonstrate Active Listening?",
			"Verification: Anticipate and overcome objections?",
			"Verification: Did the collector get connected with the consumer by building a rapport?",
			"Verification: Did the collector use system appropriately? Examples: Appropriate usage of system to provide accurate information / to provide a breakdown of balance (as required)",
			"Soft Skills / Telephone Etiquettes: Offer any apologies/empathy statement on RPs unfortunate situation",
			"Soft Skills / Telephone Etiquettes: 	Did collector hung up on RP? / Did collector interrupt or talked over RP? / Did collector has disrespectful attitude/tone?",
			"Soft Skills / Telephone Etiquettes: Did the agent avoid dead air on the call? Instead place on hold if necessary.",
			"Soft Skills / Telephone Etiquettes: Was the collector tone pleasant and accommodating? / Was the collector tone came across as confident and sounded knowledable?",
			"Closing: Summarize the call?",
			"Closing: Provided UP / LOUP call back number?",
			"Closing: Set appropriate timelines and expectations for follow up?",
			"Closing: Close the call Professionally with proper greeting? / Did collector ask if there are any further questions?",
			"Documentation: Document thoroughly the context of the conversation? Examples: All the important information happened during the conversation; Payment Promise information; Update information if changing the phone number; Update information if change staus is required.",
			"Documentation: Remove any phone numbers known to be incorrect?**SQ**",
			"Documentation: Escalate the account to a supervisor for handling if appropriate? / If required for further account handling escalate it to Union Pacific / LOUP.",
		 "Remarks1", "Remarks2", "Remarks3", "Remarks4", "Remarks5", "Remarks6", "Remarks7", "Remarks8", "Remarks9", "Remarks10", "Remarks11", "Remarks12", "Remarks13", "Remarks14", "Remarks15", "Remarks16", "Remarks17", "Remarks18", "Remarks19","Remarks20",
		 "Remarks21", "Remarks22","Remarks23", "Remarks24", "Remarks25", "Remarks26", "Remarks27", "Remarks28", "Remarks29", "Remarks30", "Remarks31", "Remarks32", "Remarks33", "Remarks34", "Remarks35",
		  "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment", "Client Review Date/Time", "Client Review Name", "Client Review Note");

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

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
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['call_link'].'",';
			$row .= '"'.$user['account'].'",';
			$row .= '"'.$user['KPI_ACPT'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['identify_himself'].'",';
			$row .= '"'.$user['provide_quality_assurance'].'",';
			$row .= '"'.$user['get_callers_name'].'",';
			$row .= '"'.$user['purpose_communication'].'",';
			$row .= '"'.$user['callback_permission'].'",';
			$row .= '"'.$user['balance_due'].'",';
			$row .= '"'.$user['intention_resolve'].'",';
			$row .= '"'.$user['complete_information'].'",';
			$row .= '"'.$user['previous_conversations'].'",';
			$row .= '"'.$user['promise_pay'].'",';
			$row .= '"'.$user['misrepresent_identity'].'",';
			$row .= '"'.$user['imply_leagal_actions'].'",';
			$row .= '"'.$user['nature_of_communication'].'",';
			$row .= '"'.$user['contact_consumer'].'",';
			$row .= '"'.$user['communicate_consumer'].'",';
			$row .= '"'.$user['status_code'].'",';
			$row .= '"'.$user['abusive_acts'].'",';
			$row .= '"'.$user['false_credit_information'].'",';
			$row .= '"'.$user['take_appropriate_action'].'",';
			$row .= '"'.$user['violation_ECOA_policy'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['overcome_objections'].'",';
			$row .= '"'.$user['building_rapport'].'",';
			$row .= '"'.$user['use_system_appropriately'].'",';
			$row .= '"'.$user['empathy_statement'].'",';
			$row .= '"'.$user['hung_up_RP'].'",';
			$row .= '"'.$user['dead_air'].'",';
			$row .= '"'.$user['pleasant_tone'].'",';
			$row .= '"'.$user['summarize_call'].'",';
			$row .= '"'.$user['provided_UP'].'",';
			$row .= '"'.$user['follow_up'].'",';
			$row .= '"'.$user['proper_greeting'].'",';
			$row .= '"'.$user['context_conversation'].'",';
			$row .= '"'.$user['remove_phone_no'].'",';
			$row .= '"'.$user['escalate_account'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm11'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm12'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm13'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm14'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm15'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm16'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm17'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm18'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm19'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm20'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm21'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm22'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm23'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm24'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm25'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm26'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm27'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm28'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm29'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm30'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm31'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm32'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm33'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm34'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['comm35'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);

	}

 }
