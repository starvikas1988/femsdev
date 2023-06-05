<?php 

 class Qa_ajio extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}

	// public function getTLname(){
	// 	if(check_logged_in()){
	// 		$aid=$this->input->post('aid');
	// 		$current_user = get_user_id();
	// 		$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id,(select d.description from department d left join signin sd on d.id=sd.dept_id
	// 		 where sd.id='$current_user') as auditor_dept,
	// 				(select r.name from role r left join signin sr on r.id=sr.role_id 
	// 		 where sr.id='$current_user') as auditor_role,
	// 		 (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where id = '$aid'";
	// 		echo json_encode($this->Common_model->get_query_result_array($qSql));
	// 	}
	// }
	
	
	// private function ajio_upload_files($files,$path)
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

    public function createPath($path){

		if (!empty($path)) {

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

  private function ajio_upload_files($files,$path) // this is for file uploaging purpose
  {
    $result=$this->createPath($path);
    if($result){
    $config['upload_path'] = $path;
    $config['allowed_types'] = '*';
    //$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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


/////////////////////////////////////////////////////////////////////////
/////////////////////////////// INBOUND /////////////////////////////////
/////////////////////////////////////////////////////////////////////////
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/qa_ajio_inb_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and status=1 order by name";
			/* and is_assign_process(id,495) */
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
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_inbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ajio_inb"] = $this->Common_model->get_query_result_array($qSql);
		////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_inb_hygiene_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ajio_hygiene_inb"] = $this->Common_model->get_query_result_array($qSql);
		////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_inbound_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ajio_inb_v2"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
/*------------------------ VOICE V2 -----------------------------*/
	public function add_edit_ajio_inb_v2($ajio_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_inb_v2.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and status=1 order by name";
			/*  and is_assign_process(id,495) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_inbound_v2_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_inb_v2"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/inbound/');
						$field_array["attach_file"] = implode(',',$a);
					}
					
					$rowid= data_inserter('qa_ajio_inbound_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_inbound_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					
					if(!isset($field_array1['auditor_type'])){
						$field_array1['auditor_type'] = "";
					}
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_ajio/inbound/")){
							mkdir("./qa_files/qa_ajio/inbound/");
						}
						$a = $this->ajio_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_ajio/inbound/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}
										
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inbound_v2_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inbound_v2_feedback',$edit_array);
					
				}
				redirect('qa_ajio');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_ajio_inb_new($ajio_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_inb_new.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			$data['cust_satisfy_issue'] = $this->cust_satisfy_issue();
			$data['call_flow_adhered'] = $this->call_flow_adhered();
			$data['ownership_call'] = $this->ownership_call();
			$data['adv_inter_skill_satisfy'] = $this->adv_inter_skill_satisfy();
			$data['tagging_accuracy'] = $this->tagging_accuracy();
			$data['authentication_as_per_process'] = $this->authentication_as_per_process();
			$data['proper_hld_proced_followed_on_call'] = $this->proper_hld_proced_followed_on_call();
			$data['ztp'] = $this->ztp();
			$data['aht_optimize'] = $this->aht_optimize();
			$data['process_related_feedback'] = $this->process_related_feedback();
			$data['tech_relate_feedback'] = $this->tech_relate_feedback();
			$data['comp_check'] = $this->comp_check();

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,495) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_inbound_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_inb"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/inbound/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ajio_inbound_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_inbound_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inbound_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inbound_feedback',$edit_array);
					
				}
				redirect('qa_ajio');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function cust_satisfy_issue(){
		return array(
			"1"=>"Yes",
			"2"=>"Call flow not adhered",
			"3"=>"Asked to call back with additional info",
			"4"=>"Asked to call back - No suoervisors available",
			"5"=>"Asked to call back - System downtime",
			"6"=>"Authentication failed",
			"7"=>"Call Dropped / Blank Call",
			"8"=>"Call escalated to Supervisor",
			"9"=>"Follow up action required from the customer",
			"10"=>"KM_Information not available",
			"11"=>"Language skill issue",
			"12"=>"MIsguided by Supervisor",
			"13"=>"SR - Beyond SLA",
			"14"=>"SR - Within SLA, Asked to wait",
			"15"=>"SR Raised",
			"16"=>"Service not available"
		);
	}
	public function call_flow_adhered(){
		return array(
			"1"=>"Yes",
			"2"=>"Wrong C&R Raised",
			"3"=>"Wrong action",
			"4"=>"Inaccurate Information",
			"5"=>"Incomplete Information",
			"6"=>"Asking unnecessary Questions"
		);
	}
	public function ownership_call(){
		return array(
			"1"=>"Yes",
			"2"=>"Lack of Willingness to help",
			"3"=>"Impolite/Rude/Commanding tone",
			"4"=>"Disconnects call",
			"5"=>"Inappropriate Conduct",
			"6"=>"Escalation Denied"
		);
	}
	public function adv_inter_skill_satisfy(){
		return array(
			"1"=>"Yes",
			"2"=>"MTI",
			"3"=>"Fluency in the language selected",
			"4"=>"Did not sound confident",
			"5"=>"High rate of speech",
			"6"=>"Poor Objection Handling",
			"7"=>"Unable to Comprehend",
			"8"=>"Use of Jargons",
			"9"=>"Courtesy statement not used",
			"10"=>"Informal Language used when communicating",
			"11"=>"Not being crisp"
		);
	}
	public function tagging_accuracy(){
		return array(
			"1"=>"Yes",
			"2"=>"FCR Incorrect IM selected",
			"3"=>"FCR Not tagged",
			"4"=>"FCR Tagged on wrong account",
			"5"=>"FCR All queries not tagged / tagged inaccurately",
			"6"=>"SR Raised when not required",
			"7"=>"SR Not Tagged",
			"8"=>"SR Incorrect IM selected",
			"9"=>"SR Tagged on wrong account",
			"10"=>"SR Mandate details not captured / captured incorrectly",
			"11"=>"Additional tagging done"
		);
	}
	public function authentication_as_per_process(){
		return array(
			"1"=>"Yes",
			"2"=>"Authenticated when not required",
			"3"=>"Did not authenticate when required",
			"4"=>"Incorrect authentication"
		);
	}
	public function proper_hld_proced_followed_on_call(){
		return array(
			"1"=>"Yes",
			"2"=>"Hold not refreshed within stipulated timeline",
			"3"=>"Uninformed Hold",
			"4"=>"Dead air instead of Hold"
		);
	}
	public function ztp(){
		return array(
			"1"=>"No",
			"2"=>"Disconnects Call",
			"3"=>"Call Not Answered",
			"4"=>"Inappropriate Conduct by the advisor",
			"5"=>"Changes to Customer's Account without Permission"
		);
	}
	public function aht_optimize(){
		return array(
			"1"=>"No",
			"2"=>"Authenticated when not required",
			"3"=>"Not referring to the system and asking questions",
			"4"=>"Asking to repeat information already shared/inattentive",
			"5"=>"No probing leading to high AHT",
			"6"=>"Resolution Presentation",
			"7"=>"Tools Navigating Issue",
			"8"=>"Delayed Closing",
			"9"=>"Not using the right system",
			"10"=>"System Issue",
			"11"=>"Support staff not available",
			"12"=>"Information not available on KM",
			"13"=>"Not being crisp"
		);
	}
	public function process_related_feedback(){
		return array(
			"1"=>"NA",
			"2"=>"TAT Not Available",
			"3"=>"TAT too long",
			"4"=>"Data entry errors",
			"5"=>"Advisor not empowered",
			"6"=>"KM_Partial information",
			"7"=>"KM_Information not available",
			"8"=>"Notifications not received",
			"9"=>"Process_Complicated Process",
			"10"=>"Process_Resolution provided does not address customers concern",
			"11"=>"Process_Shortcode/SMS facility unavailable",
			"12"=>"Delay in Provisioning",
			"13"=>"Notifications_keep Customers informed",
			"14"=>"T2R_Incorrect/Incomplete/Wrong",
			"15"=>"T2R not available",
			"16"=>"Website not user-friendly",
			"17"=>"App_Content to be added",
			"18"=>"App_UI to be simplified",
			"19"=>"Self care_content to be added",
			"20"=>"Self care_UI to be simplified",
			"21"=>"Store Feedback",
			"22"=>"Contact Centre Feedback"
		);
	}
	public function tech_relate_feedback(){
		return array(
			"1"=>"NA",
			"2"=>"Blank Call/Disturbance on Call",
			"3"=>"Auto Disconnection/Call Drop on IVR",
			"4"=>"IVR issues",
			"5"=>"Details unavailable in Novelvox/SAP CRM",
			"6"=>"Systems not working",
			"7"=>"CTI Issues",
			"8"=>"UI related feedback",
			"9"=>"Error in Novelvox",
			"10"=>"JCP down",
			"11"=>"Tele verify option not available"
		);
	}
	public function comp_check(){
		return array(
			"1"=>"Compliant",
			"2"=>"Non-Compliant",
			"3"=>"NA"
		);
	}

	public function add_edit_ajio_inb($ajio_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_inb.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,495) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_inbound_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_inb"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/inbound/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ajio_inbound_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_inbound_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inbound_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inbound_feedback',$edit_array);
					
				}
				redirect('qa_ajio');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_edit_ajio_inb_hygiene($ajio_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_inb_hygiene.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,495) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_inb_hygiene_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_inb_hygiene"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ajio_inb_hygiene_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_inb_hygiene_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inb_hygiene_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_inb_hygiene_feedback',$edit_array);
					
				}
				redirect('qa_ajio');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////////////////////////////////////////////////////
/////////////////////////////// EMAIL ///////////////////////////////////
/////////////////////////////////////////////////////////////////////////
	public function ajio_email(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/qa_ajio_email_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,494) and status=1 order by name";
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
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ajio_email"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_email_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ajio_email_v2"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_ajio_email($ajio_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_email.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,494) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_email_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_email"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ajio_email_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_email_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_email_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_email_feedback',$edit_array);
					
				}
				redirect('qa_ajio/ajio_email');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_ajio_email_version2($ajio_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_email_version2.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,494) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qsql_department = "select d.description as department from department d left join signin sd on d.id=sd.dept_id
			 where sd.id='$current_user' ";
			 $data["department"] =  $this->Common_model->get_query_result_array($qsql_department);
			 //print_r($data["department"]);

			 $qsql_role = "select r.name as role from role r left join signin sr on r.id=sr.role_id 
			 where sr.id ='$current_user' ";
			 $data["role"] =  $this->Common_model->get_query_result_array($qsql_role);
			
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_email_v2_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_email_v2"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/email/');
					// $a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio_email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ajio_email_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_email_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_email_v2_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_email_v2_feedback',$edit_array);
					
				}
				redirect('qa_ajio/ajio_email');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////////////////////////////////////////////////////
/////////////////////////////// CHAT ////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
	public function ajio_chat(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/qa_ajio_chat_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,503) and status=1 order by name";
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
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_chat_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ajio_chat"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_chat_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ajio_chatV2"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_ajio_chat($ajio_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_chat.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,503) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_chat_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_chat"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio_email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ajio_email_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_email_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_email_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_email_feedback',$edit_array);
					
				}
				redirect('qa_ajio/ajio_email');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_ajio_chat_version2($ajio_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/add_edit_ajio_chat_version2.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['ajio_id']=$ajio_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and is_assign_process(id,503) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qsql_department = "select d.description as department from department d left join signin sd on d.id=sd.dept_id
			 where sd.id='$current_user' ";
			 $data["department"] =  $this->Common_model->get_query_result_array($qsql_department);
			 //print_r($data["department"]);

			 $qsql_role = "select r.name as role from role r left join signin sr on r.id=sr.role_id 
			 where sr.id ='$current_user' ";
			 $data["role"] =  $this->Common_model->get_query_result_array($qsql_role);
			
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ajio_chat_v2_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio_chatV2"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/chat/');
					// $a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio_email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ajio_chat_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ajio_chat_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_chat_v2_feedback',$field_array1);
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
					$this->db->where('id', $ajio_id);
					$this->db->update('qa_ajio_chat_v2_feedback',$edit_array);
					
				}
				redirect('qa_ajio/ajio_chat');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////////////////////////////////////////////////////
/////////////////////////////// CCSR Voice & Non-Voice ////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
public function ajio_ccsr(){
	if(check_logged_in())
	{
		$current_user = get_user_id();
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_ajio/qa_ajio_ccsr_feedback.php";
		$data["content_js"] = "qa_kabbage_js.php";
		
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and status=1 order by name";
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
	
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_ccsr_voice_feedback $cond) xx Left Join
			(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
		$data["ajio_ccsr_voice"] = $this->Common_model->get_query_result_array($qSql);

		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_ccsr_nonvoice_feedback $cond) xx Left Join
			(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
		$data["ajio_ccsr_nonvoice"] = $this->Common_model->get_query_result_array($qSql);
	
		
		$data["from_date"] = $from_date;
		$data["to_date"] = $to_date;
		$data["agent_id"] = $agent_id;
		
		$this->load->view("dashboard",$data);
	}
}


public function add_edit_ajio_ccsr_voice($ajio_id){
	if(check_logged_in())
	{
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_ajio/add_edit_ajio_ccsr_voice.php";
		$data["content_js"] = "qa_kabbage_js.php";
		$data['ajio_id']=$ajio_id;
		$tl_mgnt_cond='';
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$tl_mgnt_cond=" and assigned_to='$current_user'";
		}else{
			$tl_mgnt_cond="";
		}
		
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and status=1  order by name";
		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_ajio_ccsr_voice_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["ajio_ccsr_voice"] = $this->Common_model->get_query_row_array($qSql);
		
		//$currDate=CurrDate();
		$curDateTime=CurrMySqlDate();
		$a = array();
		
		
		$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
		if($field_array['agent_id']){
			
			if($ajio_id==0){
				
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$field_array['audit_start_time']=$this->input->post('audit_start_time');
				$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/ccsr/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_ajio_ccsr_voice_feedback',$field_array);
			///////////
				if(get_login_type()=="client"){
					$add_array = array("client_entryby" => $current_user);
				}else{
					$add_array = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_ajio_ccsr_voice_feedback',$add_array);
				
			}else{
				
				$field_array1=$this->input->post('data');
				$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
				$this->db->where('id', $ajio_id);
				$this->db->update('qa_ajio_ccsr_voice_feedback',$field_array1);
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
				$this->db->where('id', $ajio_id);
				$this->db->update('qa_ajio_ccsr_voice_feedback',$edit_array);
				
			}
			redirect('qa_ajio/ajio_ccsr');
		}
		$data["array"] = $a;
		$this->load->view("dashboard",$data);
	}
}

public function add_edit_ajio_ccsr_nonvoice($ajio_id){
	if(check_logged_in())
	{
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_ajio/add_edit_ajio_ccsr_nonvoice.php";
		$data["content_js"] = "qa_kabbage_js.php";
		$data['ajio_id']=$ajio_id;
		$tl_mgnt_cond='';
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$tl_mgnt_cond=" and assigned_to='$current_user'";
		}else{
			$tl_mgnt_cond="";
		}
		
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,245) and status=1  order by name";
		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

		$qsql_department = "select d.description as department from department d left join signin sd on d.id=sd.dept_id
		 where sd.id='$current_user' ";
		 $data["department"] =  $this->Common_model->get_query_result_array($qsql_department);
		 //print_r($data["department"]);

		 $qsql_role = "select r.name as role from role r left join signin sr on r.id=sr.role_id 
		 where sr.id ='$current_user' ";
		 $data["role"] =  $this->Common_model->get_query_result_array($qsql_role);
		
		
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_ajio_ccsr_nonvoice_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["ajio_ccsr_nonvoice"] = $this->Common_model->get_query_row_array($qSql);
		
		//$currDate=CurrDate();
		$curDateTime=CurrMySqlDate();
		$a = array();
		
		
		$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
		if($field_array['agent_id']){
			
			if($ajio_id==0){
				
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$field_array['audit_start_time']=$this->input->post('audit_start_time');
				if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/ccsr/');
						$field_array["attach_file"] = implode(',',$a);
				}

				$rowid= data_inserter('qa_ajio_ccsr_nonvoice_feedback',$field_array);
			///////////
				if(get_login_type()=="client"){
					$add_array = array("client_entryby" => $current_user);
				}else{
					$add_array = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_ajio_ccsr_nonvoice_feedback',$add_array);
				
			}else{
				
				$field_array1=$this->input->post('data');
				$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
				if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_ajio/ccsr/")){
							mkdir("./qa_files/qa_ajio/ccsr/");
						}
						$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ajio/ccsr/');
						$field_array1['attach_file'] = implode( ',', $a );
					}
				$this->db->where('id', $ajio_id);
				$this->db->update('qa_ajio_ccsr_nonvoice_feedback',$field_array1);
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
				$this->db->where('id', $ajio_id);
				$this->db->update('qa_ajio_ccsr_nonvoice_feedback',$edit_array);
				
			}
			redirect('qa_ajio/ajio_ccsr');
		}
		$data["array"] = $a;
		$this->load->view("dashboard",$data);
	}
}	

/*------------------- Agent Part ---------------------*/
	public function agent_ajio_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/agent_ajio_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_ajio/agent_ajio_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign = '';
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
			
			if($from_date !="" && $to_date!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
					}else{
						$cond= " Where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
					}

			
			if($campaign!=""){
			
				$qSql="Select count(id) as value from qa_ajio_".$campaign."_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_ajio_".$campaign."_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit') and agent_rvw_date is Null";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				
				if($this->input->get('btnView')=='View')
				{
					// $fromDate = $this->input->get('from_date');
					// if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					// $toDate = $this->input->get('to_date');
					// if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					// if($fromDate !="" && $toDate!=="" ){ 
					// 	$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
					// }else{
					// 	$cond= " Where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
					// }
					
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_".$campaign."_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
						
				}else{
		
					// $qSql="SELECT * from
					// (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					// (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					// (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					// (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_".$campaign."_feedback $cond) xx Left Join
					// (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_".$campaign."_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
		
				}
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_ajio_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ajio/agent_ajio_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_ajio/agent_ajio_feedback";
			$data["campaign"] = $campaign;
			$data["pnid"]=$id;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ajio_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ajio"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update("qa_ajio_".$campaign."_feedback",$field_array1);
					
				redirect('qa_ajio/agent_ajio_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
/*------------------------------ Report Part ---------------------------*/
	public function qa_ajio_report(){
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
			$data["content_template"] = "qa_ajio/qa_ajio_report.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";

			$campaign = $this->input->get('campaign');
			$date_from = ($this->input->get('date_from'));
			$date_to = ($this->input->get('date_to'));

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


			$data["qa_ajio_list"] = array();

			if($campaign!=""){
				if($this->input->get('show')=='Show')
				{
					// $date_from = mmddyy2mysql($this->input->get('date_from'));
					// $date_to = mmddyy2mysql($this->input->get('date_to'));
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
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_ajio_".$campaign."_feedback) xx 
					Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_ajio_list"] = $fullAray;
					$this->create_qa_ajio_CSV($fullAray,$campaign);
					$dn_link = base_url()."qa_ajio/download_qa_ajio_CSV/".$campaign;
				}
			}

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			$data['office_id']=$office_id;
			$data['campaign']=$campaign;
			$this->load->view('dashboard',$data);
		}
	}


	public function download_qa_ajio_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		$newfile="QA AJIO ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_ajio_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		if($campaign=="inbound"){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date/Time", "Champ BP ID", "Call Duration", "Complete ID", "Nature of Call/ Dispositions", "Opening", "Probing", "System Navigation", "Tagging", "Tagging L1", "KM Navigation", "Article Number", "Fatal/Non Fatal", "Resolution Validation", "L1 Drill Down", "L2 Drill Down", "Call/Chat Disconnection", "Call/Chat/Email Avoidance", "Flirting/Seeking personal details", "Rude Behavior/Mocking the customer", "Abusive Behavior", "Making Changes to customer account without permission or seeking confidential information such as password OTP etc or data privacy breach", "Incident ID", "TNPS Given", "Previous Interaction", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=="email"){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Email Date/Time", "Champ BP ID", "Call Duration", "Complete ID", "Nature of Call/ Dispositions", "Opening", "Closing", "Previous Interaction Checking", "Probing", "Communication (Grammar)", "Apology/ Empathy/ Assurance Given", "System Navigation", "Tagging", "Tagging L1", "KM Navigation", "Article Number", "TNPS Given", "Fatal/Non Fatal", "Resolution Validation", "L1 Drill Down", "L2 Drill Down", "Call/Chat Disconnection", "Call/Chat/Email Avoidance", "Flirting/Seeking personal details", "Rude Behavior/Mocking the customer", "Abusive Behavior", "Making Changes to customer account without permission or seeking confidential information such as password OTP etc or data privacy breach", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=="chat"){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Chat Date/Time", "Champ BP ID", "Call Duration", "Chat Link", "Nature of Call/ Dispositions", "Opening", "Closing", "Previous Interaction Checking", "Probing", "Hold", "Communication (Grammar)", "Response Time", "System Navigation", "Disposition", "Disposition L1", "KM Navigation", "Article Number", "TNPS Given", "Fatal/Non Fatal", "Resolution Validation", "L1 Drill Down", "L2 Drill Down", "Call/Chat Disconnection", "Call/Chat/Email Avoidance", "Flirting/Seeking personal details", "Rude Behavior/Mocking the customer", "Abusive Behavior", "Making Changes to customer account without permission or seeking confidential information such as password OTP etc or data privacy breach", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=="chat_v2"){
			$header = array("Auditor Name", "Auditor Department", "Auditor Role", "Audit Date", "Agent", "MWP ID", "L1 Super", "Call Date/Time", "Type of Audit", "Interaction ID","Call Duration", "Audit Type", "Auditor Type", "VOC","Tagging by Evaluator", "Overall Score", "Earned Score", "Possible Score", "Fatal Count", "Pre Fatal Score", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)",
			"Did the champ open the chat within 10 seconds and introduce himself properly?","L1 Reason1", "Remark1","Did the champ use appropriate acknowledgements re-assurance and apology wherever required", "L1 Reason2","Remark2","Did the champ follow Hold procedure as per SOP?", "L1 Reason3","Remark3","Was champ able to express/articulate himself and seamlessly converse with the customer","L1 Reason4","Remark4", "Did the champ offer further assistance and follow appropriate chat closure/supervisor transfer process.", "L1 Reason5","Remark5","Did the champ use appropriate canned response and customized it to ensure all concerns raised were answered appropriately", "L1 Reason6","Remark6","Did the champ maintain accuracy of written communication ensuring no grammatical errors SVAs Punctuation and sentence construction errors.","L1 Reason7", "Remark7","Did the champ refer to all relevant previous interactions when required to gather information about customers account and issue end to end", "L1 Reason8","Remark8","Was the champ able to identify and handle objections effectively and offer rebuttals wherever required", "L1 Reason9","Remark9","Did the champ refer to all releavnt articles/T2Rs correctly", "L1 Reason10","Remark10","Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.", "L1 Reason11","Remark11","Champ executed all necessary actions to ensure issue resolution", "L1 Reason12","Remark12","All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.","L1 Reason13", "Remark13","Did the champ document the case correctly and adhered to tagging guidelines.","L1 Reason14","Remark14", "As per AJIO ZTP guidelines","L1 Reason15","Remark15", 
			"Call Synopsis", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");	
		}else if($campaign=="inb_hygiene"){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date/Time", "BP ID", "Call Duration", "Complete ID", "Valid/Invalid", "Reason For Invalid", "Downtime Tracker Status", "Mentioned Reson in Downtime", "Hold /response Duration (mins)", "Hygiene Audit Type", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=="inbound_v2"){
			$header = array("Auditor Name", "Auditor Department", "Auditor Role", "Audit Date", "Agent", "MWP ID", "L1 Super", "Call Date/Time", "Call Duration","Audit Type", "Auditor Type", "VOC","Partner","Ticket Type","Auditor's BP ID","Interaction ID","Order ID","Ticket ID","Call Synopsis","Language",
			  "Tagging by Evaluator", "Overall Score", "Earned Score", "Possible Score", "Fatal Count", "Pre Fatal Score", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)",
			"Did the champ open the call within 4 seconds and introduce himself properly","L1 Reason 1","L2 Reason 1", "Did the champ address the customer by name","L1 Reason 2","L2 Reason 2", "Champ followed the hold procedure as per the SOP","L1 Reason 3","L2 Reason 3", "Did the champ offer further assistance and follow appropriate call closure/supervisor transfer process","L1 Reason 4","L2 Reason 4", "Was the champ polite and used apology and assurance wherever required","L1 Reason 5","L2 Reason 5", "Was the champ able to comprehend and paraphrase the customers concern","L1 Reason 6","L2 Reason 6", "Did the champ display active listening skills without making the customer repeat","L1 Reason 7","L2 Reason 7", "Was the champ able to handle objections effectively and offer rebuttals wherever required","L1 Reason 8","L2 Reason 8", "Was champ able to express/articulate himself and seamlessly converse with the customer","L1 Reason 9","L2 Reason 9", "Did the champ refer to all relevant articles/T2Rs correctly","L1 Reason 10","L2 Reason 10", "Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution","L1 Reason 11","L2 Reason 11", "Call/Interaction was authenticated wherever required","L1 Reason 12","L2 Reason 12", "Was the champ able to effectively navigate through and toggle between different tools/aids to wrap up the call in a timely manner","L1 Reason 13","L2 Reason 13", "Champ executed all necessary actions to ensure issue resolution","L1 Reason 14","L2 Reason 14", "All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer","L1 Reason 15","L2 Reason 15", "Did the champ document the case correctly and adhered to tagging guidelines","L1 Reason 16","L2 Reason 16", "As per AJIO ZTP guidelines","L1 Reason 17","L2 Reason 17",
			"Call Synopsis", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time", "Mgnt Review By", "Mgnt Comment", "Client Review Date/Time", "Client Review Name", "Client Review Note");
		}else if($campaign=="email_v2"){
			$header = array("Auditor Name", "Auditor Department", "Auditor Role", "Audit Date", "Agent", "MWP ID", "L1 Super", "Call Date/Time", "Type of Audit", "Interaction ID", "Audit Type", "Auditor Type", "VOC","Tagging by Evaluator", "Overall Score", "Earned Score", "Possible Score", "Fatal Count", "Pre Fatal Score", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)",	
			"Did the champ use appropriate acknowledgements re-assurance and apology wherever required","L1 Reason 1","Remarks 1", "Did the champ use font font size and formatting as per AJIOs brand guidelines","L1 Reason 2","Remarks 2", "Was the email response in line with AJIOs approved template/format","L1 Reason 3","Remarks 3", "Did the champ use appropriate template(s) and customized it to ensure all concerns raised were answered appropriately","L1 Reason 4","Remarks 4", "Did the champ maintain accuracy of written communication ensuring no grammatical errors SVAs Punctuation and sentence construction errors.","L1 Reason 5","Remarks 5", "Did the champ refer to all relevant previous interactions when required to gather information about customers account and issue end to end","L1 Reason 6","Remarks 6", "Was the champ able to identify and handle objections effectively and offer rebuttals wherever required","L1 Reason 7","Remarks7", "Did the champ refer to all releavnt articles/T2Rs correctly","L1 Reason 8","Remarks 8", "Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.","L1 Reason 9","Remarks 9", "Email/Interaction was authenticated wherever required","L1 Reason 10","Remarks10", "Did the champ take ownership and request for outcall/call back was addressed wherever required","L1 Reason 11","Remarks11", "Champ executed all necessary actions to ensure issue resolution","L1 Reason 12","Remarks 12", "All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.","L1 Reason 13","Remarks 13", "Did the champ document the case correctly and adhered to tagging guidelines.","L1 Reason 14","Remarks 14", "As per AJIO ZTP guidelines","L1 Reason 15","Remarks 15",
			"Call Synopsis", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=="ccsr_voice"){
			$header = array("Auditor Name", "Auditor Department", "Auditor Role", "Audit Date", "Agent", "MWP ID", "L1 Super", "Call Date/Time", "Type of Audit", "Interaction ID","Call Duration", "Audit Type", "Auditor Type", "VOC", "Tagging by Evaluator", "Overall Score", "Earned Score", "Possible Score", "Fatal Count", "Pre Fatal Score", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)",
			"Did the champ follow the OB call script and introduce himself properly.","L1 Reason1", "Remark1","Champ followed the 3 strike rule of customer contact", "L1 Reason2","Remark2","Did the champ offer further assistance and follow appropriate call closure.", "L1 Reason3","Remark3","Was the champ polite and used apology and assurance wherever required","L1 Reason4","Remark4", "Was the champ able to comprehend and articulate the resolution to the cusomer in a manner which was easily understood by the customer.", "L1 Reason5","Remark5","Did the champ display active listening skills without making the customer repeat", "L1 Reason6","Remark6","Was the champ able to handle objections effectively and offer rebuttals wherever required Especially in case of where the resolution is not in customers favour","L1 Reason7", "Remark7","Did the champ refer to different applications/portals/tools/SOP to identify the root cause of customer issue and enable resolution.", "L1 Reason8","Remark8","Did the champ check the previous complaint history. (repeat complaint, resolution provided on previous complaint. Reason of reopen) and took action acordingly.", "L1 Reason9","Remark9","Did the champ correctly redirect/reassign/reopen the complaint wherever required. Includes when the resolution provided by stakeholder is not valid", "L1 Reason10","Remark10","Any other underlying issue on the account was also addressed proactively.", "L1 Reason11","Remark11","All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer Any Information needed from Cx Follow up action reuired by customer Taking confirmation of the understadning of resolution", "L1 Reason12","Remark12","Did the champ document the case correctly and adhered to tagging guidelines. Includes closing the complaint appropariately by selecting the correct ICR reason","L1 Reason13", "Remark13","As per AJIO ZTP guidelines","L1 Reason14","Remark14", 
			"Call Synopsis", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");	
		}else if($campaign=="ccsr_nonvoice"){
			$header = array("Auditor Name", "Auditor Department", "Auditor Role", "Audit Date", "Agent", "MWP ID", "L1 Super", "Call Date/Time", "Type of Audit", "Interaction ID", "Audit Type", "Auditor Type", "VOC","Tagging by Evaluator", "Overall Score", "Earned Score", "Possible Score", "Fatal Count", "Pre Fatal Score", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)","Ticket Type","Order Id","Ticket Id","Partner",
			"Did the champ use appropriate acknowledgements re-assurance and apology wherever required","L1 Reason1", "Remark1",
			"Did the champ use font font size and formatting  as per AJIOs brand guidelines", "L1 Reason2","Remark2",
			"Was the email response in line with AJIOs approved template/format ", "L1 Reason3","Remark3",
			"Did the champ maintain accuracy of written communication ensuring no grammatical errors SVAs Punctuation and sentence construction errors.","L1 Reason4","Remark4",
			"Did the champ refer to all relevant previous interactions when required to gather information about customers account and issue end to end","L1 Reason5","Remark5",
			"Did the champ use appropriate template(s) and customized it to ensure all concerns raised were answered appropriately","L1 Reason6","Remark6",
			"Was the champ able to identify and handle objections effectively and offer rebuttals wherever required","L1 Reason7","Remark7",
			"Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.","L1 Reason8","Remark8",
			"Did the champ refer to all releavnt articles/T2Rs correctly","L1 Reason9","Remark9",
			"Email/Interaction was authenticated wherever required","L1 Reason10","Remark10",
			"Did the champ take ownership and request for outcall/call back was addressed wherever required","L1 Reason11","Remark11",
			"Champ executed all necessary actions to ensure issue resolution","L1 Reason12","Remark12",
			"All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.","L1 Reason13","Remark13",
			"Did the champ document the case correctly and adhered to tagging guidelines.","L1 Reason14","Remark14",
			"As per AJIO ZTP guidelines","L1 Reason15","Remark15",
			"Call Synopsis", "Call Observation", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");	
		}

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

		if($campaign=="inbound"){

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
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['agent_bp_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['complete_id'].'",';
				$row .= '"'.$user['call_nature'].'",';
				$row .= '"'.$user['opening'].'",';
				$row .= '"'.$user['probing'].'",';
				$row .= '"'.$user['system_navigation'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['tagging_l1'].'",';
				$row .= '"'.$user['km_navigation'].'",';
				$row .= '"'.$user['article_no'].'",';
				$row .= '"'.$user['fatal_nonfatal'].'",';
				$row .= '"'.$user['resolution_validation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_drill_down'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_drill_down'])).'",';
				$row .= '"'.$user['call_chat_disconnection'].'",';
				$row .= '"'.$user['call_chat_email_avoidance'].'",';
				$row .= '"'.$user['seeking_personal_details'].'",';
				$row .= '"'.$user['rude_behavior'].'",';
				$row .= '"'.$user['abuse_behavior'].'",';
				$row .= '"'.$user['change_customer_account_without_permission'].'",';
				$row .= '"'.$user['incident_id'].'",';
				$row .= '"'.$user['tnps_given'].'",';
				$row .= '"'.$user['previous_interaction'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
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

		}else if($campaign=="email"){

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
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['agent_bp_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['complete_id'].'",';
				$row .= '"'.$user['call_nature'].'",';
				$row .= '"'.$user['opening'].'",';
				$row .= '"'.$user['closing'].'",';
				$row .= '"'.$user['previous_interaction'].'",';
				$row .= '"'.$user['probing'].'",';
				$row .= '"'.$user['communication'].'",';
				$row .= '"'.$user['apology_empathy'].'",';
				$row .= '"'.$user['system_navigation'].'",';
				$row .= '"'.$user['tagging'].'",';
				$row .= '"'.$user['tagging_l1'].'",';
				$row .= '"'.$user['km_navigation'].'",';
				$row .= '"'.$user['article_no'].'",';
				$row .= '"'.$user['tnps_given'].'",';
				$row .= '"'.$user['fatal_nonfatal'].'",';
				$row .= '"'.$user['resolution_validation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_drill_down'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_drill_down'])).'",';
				$row .= '"'.$user['call_chat_disconnection'].'",';
				$row .= '"'.$user['call_chat_email_avoidance'].'",';
				$row .= '"'.$user['seeking_personal_details'].'",';
				$row .= '"'.$user['rude_behavior'].'",';
				$row .= '"'.$user['abuse_behavior'].'",';
				$row .= '"'.$user['change_customer_account_without_permission'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
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

		}else if($campaign=="chat"){

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
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['agent_bp_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['chat_link'].'",';
				$row .= '"'.$user['call_nature'].'",';
				$row .= '"'.$user['opening'].'",';
				$row .= '"'.$user['closing'].'",';
				$row .= '"'.$user['previous_interaction'].'",';
				$row .= '"'.$user['probing'].'",';
				$row .= '"'.$user['hold'].'",';
				$row .= '"'.$user['communication'].'",';
				$row .= '"'.$user['response_time'].'",';
				$row .= '"'.$user['system_navigation'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['disposition_l1'].'",';
				$row .= '"'.$user['km_navigation'].'",';
				$row .= '"'.$user['article_no'].'",';
				$row .= '"'.$user['tnps_given'].'",';
				$row .= '"'.$user['fatal_nonfatal'].'",';
				$row .= '"'.$user['resolution_validation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_drill_down'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_drill_down'])).'",';
				$row .= '"'.$user['call_chat_disconnection'].'",';
				$row .= '"'.$user['call_chat_email_avoidance'].'",';
				$row .= '"'.$user['seeking_personal_details'].'",';
				$row .= '"'.$user['rude_behavior'].'",';
				$row .= '"'.$user['abuse_behavior'].'",';
				$row .= '"'.$user['change_customer_account_without_permission'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
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

		}else if($campaign=="chat_v2"){

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
				
				$callId="_".$user['call_id'];

				$row = '"'.$auditorName.'",';
				$row .= '"'.$user['auditor_dept'].'",';
				$row .= '"'.$user['auditor_role'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['type_of_audit'].'",';
				$row .= '"'.$callId.'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['tagging_evaluator'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['pre_fatal_score'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['appropriate_acknowledgements'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['font_size_formatting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['email_response'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['seamlessly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['use_appropriate_template'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['communication'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['written_communication'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['relevant_previous_interactions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['handle_objections'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['releavnt_articles'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['applications_portals'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['ensure_issue_resolution'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['avoid_repeat_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['tagging_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['ztp_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_synopsis'])).'",';
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

		}else if($campaign=="ccsr_voice"){

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
				
				$callId="_".$user['call_id'];

				$row = '"'.$auditorName.'",';
				$row .= '"'.$user['auditor_dept'].'",';
				$row .= '"'.$user['auditor_role'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['type_of_audit'].'",';
				$row .= '"'.$callId.'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['tagging_evaluator'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['pre_fatal_score'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['appropriate_acknowledgements'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['font_size_formatting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['use_appropriate_template'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['seamlessly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['written_communication'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['listening_skills'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['communication'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['releavnt_articles'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['handle_objections'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['relevant_previous_interactions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['applications_portals'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['ensure_issue_resolution'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['tagging_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['ztp_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_synopsis'])).'",';
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

		}else if($campaign=="ccsr_nonvoice"){

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
				
				$callId="_".$user['call_id'];

				$row = '"'.$auditorName.'",';
				$row .= '"'.$user['auditor_dept'].'",';
				$row .= '"'.$user['auditor_role'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['type_of_audit'].'",';
				$row .= '"'.$callId.'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['tagging_evaluator'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['pre_fatal_score'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['ticket_type'].'",';
				$row .= '"'.$user['order_id'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['partner'].'",';
				$row .= '"'.$user['appropriate_acknowledgements'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['font_size_formatting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['approved_template'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['seamlessly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['gather_information'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['use_appropriate_template'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['offer_rebuttals'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['application_portals'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'.$user['relevant_previous_interactions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['email_interaction'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				
				$row .= '"'.$user['call_back_address'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'.$user['ensure_issue_resolution'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['avoid_repeat_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['tagging_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['ztp_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';

				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_synopsis'])).'",';
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

			

		}else if($campaign=="inb_hygiene"){

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
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['agent_bp_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['complete_id'].'",';
				$row .= '"'.$user['valid_invalid'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['reason_for_invalid'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['downtime_tracker_status'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['downtime_mension_reason'])).'",';
				$row .= '"'.$user['hold_responce_duration'].'",';
				$row .= '"'.$user['hygiene_audit_type'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
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

		}else if($campaign=="inbound_v2"){

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
				
				//$callId="_".$user['call_id'];

				$row = '"'.$auditorName.'",';
				$row .= '"'.$user['auditor_dept'].'",';
				$row .= '"'.$user['auditor_role'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				//$row .= '"'.$user['type_of_audit'].'",';
				//$row .= '"'.$callId.'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['partner'].'",';
				$row .= '"'.$user['ticket_type'].'",';
				$row .= '"'.$user['auditors_bp_id'].'",';
				$row .= '"'.$user['interaction_id'].'",';
				$row .= '"'.$user['order_id'].'",';
				$row .= '"'.$user['ticket_id'].'",';
				$row .= '"'.$user['call_synopsis_header'].'",';
				$row .= '"'.$user['language'].'",';
				$row .= '"'.$user['tagging_evaluator'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['pre_fatal_score'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['open_call_within_4sec'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason1'])).'",';
				$row .= '"'.$user['address_customer_by_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason2'])).'",';
				$row .= '"'.$user['follow_hold_procedure'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason3'])).'",';
				$row .= '"'.$user['follow_appropiate_call_closure'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason4'])).'",';
				$row .= '"'.$user['polite_use_appology'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason5'])).'",';
				$row .= '"'.$user['comprehend_customer_concern'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason6'])).'",';
				$row .= '"'.$user['display_active_listening_skill'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason7'])).'",';
				$row .= '"'.$user['handle_objection_effectively'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason8'])).'",';
				$row .= '"'.$user['express_himself_with_customer'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason9'])).'",';
				$row .= '"'.$user['refer_all_releavnt_article'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason10'])).'",';
				$row .= '"'.$user['refer_different_application'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason11'])).'",';
				$row .= '"'.$user['call_was_authenticated'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason12'])).'",';
				$row .= '"'.$user['effectively_navigate_through'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason13'])).'",';
				$row .= '"'.$user['executed_all_necessary'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason14'])).'",';
				$row .= '"'.$user['queries_answered_properly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason15'])).'",';
				$row .= '"'.$user['document_the_case_correctly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason16'])).'",';
				$row .= '"'.$user['ztp_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_synopsis'])).'",';
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
		}else if($campaign=="email_v2"){

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
				
				$callId="_".$user['call_id'];

				$row = '"'.$auditorName.'",';
				$row .= '"'.$user['auditor_dept'].'",';
				$row .= '"'.$user['auditor_role'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['type_of_audit'].'",';
				$row .= '"'.$callId.'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['tagging_evaluator'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['fatal_count'].'",';
				$row .= '"'.$user['pre_fatal_score'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['appropriate_acknowledgements'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason1'])).'",';
				$row .= '"'.$user['font_size_formatting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason2'])).'",';
				$row .= '"'.$user['email_response'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason3'])).'",';
				$row .= '"'.$user['use_appropriate_template'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason4'])).'",';
				$row .= '"'.$user['written_communication'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason5'])).'",';
				$row .= '"'.$user['relevant_previous_interactions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason6'])).'",';
				$row .= '"'.$user['handle_objections'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason7'])).'",';
				$row .= '"'.$user['all_relevant_articles'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason8'])).'",';
				$row .= '"'.$user['applications_portals'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason9'])).'",';
				$row .= '"'.$user['email_interaction'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason10'])).'",';
				$row .= '"'.$user['outcall_call_back'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason11'])).'",';
				$row .= '"'.$user['ensure_issue_resolution'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason12'])).'",';
				$row .= '"'.$user['avoid_repeat_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason13'])).'",';
				$row .= '"'.$user['tagging_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason14'])).'",';
				$row .= '"'.$user['ztp_guidelines'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1_reason15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2_reason15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_synopsis'])).'",';
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
}
