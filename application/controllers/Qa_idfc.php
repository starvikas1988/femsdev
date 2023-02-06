<?php 

 class Qa_idfc extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function idfc_upload_files($files,$path)
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
	
/////////////////////////////////////////////////////


	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/qa_idfc_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,144)  and status=1  order by name";
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
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["idfc_new"] = $this->Common_model->get_query_result_array($qSql);
		////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["idfc_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/add_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,144)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"week" => $this->input->post('week'),
					"cycle_date" => mmddyy2mysql($this->input->post('cycle_date')),
					"phone" => $this->input->post('phone'),
					"customer_name" => $this->input->post('customer_name'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"disposition" => $this->input->post('disposition'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"agentopencallin3sec" => $this->input->post('agentopencallin3sec'),
					"agentintroducehimself" => $this->input->post('agentintroducehimself'),
					"agentintroducecompany" => $this->input->post('agentintroducecompany'),
					"agentusedprescribedscript" => $this->input->post('agentusedprescribedscript'),
					"agentclearlyexplained" => $this->input->post('agentclearlyexplained'),
					"agentquotedpreviouscall" => $this->input->post('agentquotedpreviouscall'),
					"agentgetsagreement" => $this->input->post('agentgetsagreement'),
					"agentcreateurjency" => $this->input->post('agentcreateurjency'),
					"agentreiteratedtheimpact" => $this->input->post('agentreiteratedtheimpact'),
					"agentgaveeffectiverebruttal" => $this->input->post('agentgaveeffectiverebruttal'),
					"agentpromotedpaidC" => $this->input->post('agentpromotedpaidC'),
					"agentdidrightprobing" => $this->input->post('agentdidrightprobing'),
					"agentcheckrelevanttool" => $this->input->post('agentcheckrelevanttool'),
					"3rdpartydisclosure" => $this->input->post('3rdpartydisclosure'),
					"agentupdatedcalltime" => $this->input->post('agentupdatedcalltime'),
					"agentusedverbalnods" => $this->input->post('agentusedverbalnods'),
					"agentavoidspeakingover" => $this->input->post('agentavoidspeakingover'),
					"agentemphathizedappropiate" => $this->input->post('agentemphathizedappropiate'),
					"agentsoundedconfident" => $this->input->post('agentsoundedconfident'),
					"clearexpansion" => $this->input->post('clearexpansion'),
					"agentrateofspeech" => $this->input->post('agentrateofspeech'),
					"agentsoundedenergetic" => $this->input->post('agentsoundedenergetic'),
					"listeningandcomprehensive" => $this->input->post('listeningandcomprehensive'),
					"agentnotprovideinfo" => $this->input->post('agentnotprovideinfo'),
					"agentnotfollowincorrectprocedure" => $this->input->post('agentnotfollowincorrectprocedure'),
					"agentresponceonquestion" => $this->input->post('agentresponceonquestion'),
					"agentfollowHoldprocedure" => $this->input->post('agentfollowHoldprocedure'),
					"agentfollowtransferprocedure" => $this->input->post('agentfollowtransferprocedure'),
					"agentnotDisconnectcall" => $this->input->post('agentnotDisconnectcall'),
					"agentwasnotabuseonCall" => $this->input->post('agentwasnotabuseonCall'),
					"agentnotSitetakingonCall" => $this->input->post('agentnotSitetakingonCall'),
					"agentcompiledoncall" => $this->input->post('agentcompiledoncall'),
					"agenttoneappropiateonCall" => $this->input->post('agenttoneappropiateonCall'),
					"followupcallwiththeCustomer" => $this->input->post('followupcallwiththeCustomer'),
					"greetingscore" => $this->input->post('greetingscore'),
					"purposecallscore" => $this->input->post('purposecallscore'),
					"collectiontechniquescore" => $this->input->post('collectiontechniquescore'),
					"communicatioskillscore" => $this->input->post('communicatioskillscore'),
					"telephoneetiquettescore" => $this->input->post('telephoneetiquettescore'),
					"callclosingscore" => $this->input->post('callclosingscore'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->idfc_upload_files($_FILES['attach_file'],$path='./qa_files/qa_idfc/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_idfc_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_idfc_feedback',$field_array1);
			///////////	
				redirect('Qa_idfc');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_idfc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/mgnt_idfc_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,144)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"week" => $this->input->post('week'),
					"cycle_date" => mmddyy2mysql($this->input->post('cycle_date')),
					"phone" => $this->input->post('phone'),
					"customer_name" => $this->input->post('customer_name'),
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"disposition" => $this->input->post('disposition'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"agentopencallin3sec" => $this->input->post('agentopencallin3sec'),
					"agentintroducehimself" => $this->input->post('agentintroducehimself'),
					"agentintroducecompany" => $this->input->post('agentintroducecompany'),
					"agentusedprescribedscript" => $this->input->post('agentusedprescribedscript'),
					"agentclearlyexplained" => $this->input->post('agentclearlyexplained'),
					"agentquotedpreviouscall" => $this->input->post('agentquotedpreviouscall'),
					"agentgetsagreement" => $this->input->post('agentgetsagreement'),
					"agentcreateurjency" => $this->input->post('agentcreateurjency'),
					"agentreiteratedtheimpact" => $this->input->post('agentreiteratedtheimpact'),
					"agentgaveeffectiverebruttal" => $this->input->post('agentgaveeffectiverebruttal'),
					"agentpromotedpaidC" => $this->input->post('agentpromotedpaidC'),
					"agentdidrightprobing" => $this->input->post('agentdidrightprobing'),
					"agentcheckrelevanttool" => $this->input->post('agentcheckrelevanttool'),
					"3rdpartydisclosure" => $this->input->post('3rdpartydisclosure'),
					"agentupdatedcalltime" => $this->input->post('agentupdatedcalltime'),
					"agentusedverbalnods" => $this->input->post('agentusedverbalnods'),
					"agentavoidspeakingover" => $this->input->post('agentavoidspeakingover'),
					"agentemphathizedappropiate" => $this->input->post('agentemphathizedappropiate'),
					"agentsoundedconfident" => $this->input->post('agentsoundedconfident'),
					"clearexpansion" => $this->input->post('clearexpansion'),
					"agentrateofspeech" => $this->input->post('agentrateofspeech'),
					"agentsoundedenergetic" => $this->input->post('agentsoundedenergetic'),
					"listeningandcomprehensive" => $this->input->post('listeningandcomprehensive'),
					"agentnotprovideinfo" => $this->input->post('agentnotprovideinfo'),
					"agentnotfollowincorrectprocedure" => $this->input->post('agentnotfollowincorrectprocedure'),
					"agentresponceonquestion" => $this->input->post('agentresponceonquestion'),
					"agentfollowHoldprocedure" => $this->input->post('agentfollowHoldprocedure'),
					"agentfollowtransferprocedure" => $this->input->post('agentfollowtransferprocedure'),
					"agentnotDisconnectcall" => $this->input->post('agentnotDisconnectcall'),
					"agentwasnotabuseonCall" => $this->input->post('agentwasnotabuseonCall'),
					"agentnotSitetakingonCall" => $this->input->post('agentnotSitetakingonCall'),
					"agentcompiledoncall" => $this->input->post('agentcompiledoncall'),
					"agenttoneappropiateonCall" => $this->input->post('agenttoneappropiateonCall'),
					"followupcallwiththeCustomer" => $this->input->post('followupcallwiththeCustomer'),
					"greetingscore" => $this->input->post('greetingscore'),
					"purposecallscore" => $this->input->post('purposecallscore'),
					"collectiontechniquescore" => $this->input->post('collectiontechniquescore'),
					"communicatioskillscore" => $this->input->post('communicatioskillscore'),
					"telephoneetiquettescore" => $this->input->post('telephoneetiquettescore'),
					"callclosingscore" => $this->input->post('callclosingscore'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_idfc_feedback',$field_array);
				
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
				$this->db->update('qa_idfc_feedback',$field_array1);
			///////////	
				redirect('Qa_idfc');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////// IDFC (NEW) ///////////////////////////////////

	public function add_edit_idfc_new($idfc_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/add_edit_idfc_new.php";
			$data["content_js"] = "qa_idfc_js.php";
			$data['idfc_id']=$idfc_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,144)  and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_idfc_feedback where id='$idfc_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_new"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('btnSave') == "SAVE"){
				
				if($idfc_id==0){
					
					$field_array=$_POST['data'];
					$field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                    $field_array['call_date'] = mdydt2mysql($this->input->post('call_date'));
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );

					$a = $this->idfc_upload_files($_FILES['attach_file'], $path='./qa_files/qa_idfc/idfc_new/');
					$field_array["attach_file"] = implode(',',$a);
					
					$rowid= data_inserter('qa_idfc_feedback',$field_array);
				/////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_idfc_feedback',$field_array1);
				
				}else{
					
					$field_array2=$_POST['data'];
					$field_array2 = $this->input->post( 'data' );
                    $field_array2['call_date'] = mdydt2mysql($this->input->post('call_date'));
					
					$this->db->where('id', $idfc_id);
					$this->db->update('qa_idfc_feedback',$field_array2);
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
					$this->db->where('id', $idfc_id);
					$this->db->update('qa_idfc_feedback',$field_array1);
				}
				redirect('qa_idfc');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_idfc_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/agent_idfc_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_idfc/agent_idfc_feedback";
			
			
			$qSql="Select count(id) as value from qa_idfc_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_idfcNew"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_idfc_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_idfc_rvw"] =  $this->Common_model->get_single_value($qSql);
		///////////
			$qSql="Select count(id) as value from qa_idfc_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_idfc_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_idfc_new_list"] = $this->Common_model->get_query_result_array($qSql);
			/////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_idfc_new_list"] = $this->Common_model->get_query_result_array($qSql);
			//////////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_idfc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/agent_idfc_rvw.php";
			// $data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_idfc/agent_idfc_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
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
				$this->db->update('qa_idfc_feedback',$field_array1);
					
				redirect('Qa_idfc/agent_idfc_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_idfc_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_idfc/agent_idfc_new_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_idfc/agent_idfc_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_idfc_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["idfc_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
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
				$this->db->update('qa_idfc_new_feedback',$field_array1);
					
				redirect('Qa_idfc/agent_idfc_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////// 
///////////////////////////////// QA IDFC REPORT ////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_idfc_report(){
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
			$data["content_template"] = "qa_idfc/qa_idfc_report.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_idfc_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$campaign = $this->input->get('campaign');
				$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		
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
		
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_idfc_list"] = $fullAray;
				$this->create_qa_idfc_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_idfc/download_qa_idfc_CSV";	
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
	 

	public function download_qa_idfc_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA IDFC Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_idfc_CSV($rr,$campaign)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($campaign=='idfc_new'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date Time", "Week", "Cycle Date", "Phone", "Customer Name", "Disposition", "Call Duration","Agent Disposition","QA Disposition", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Agent opened the call with the desired enthusiasm in 3 seconds", "Agent clearly introduced himself/herself to the customer", "Agent introduced the company he/she is calling from", "Agent used the prescribed script as per previous disposition", "Agent clearly explained the objective of calling the customer", "Agent quoted the previous call commitment made my the customer", "Agent reminds and gets agreement of a customer on number of broken PTP or Already Paid as applicable", "Agent created the urgency in the call to collect the payment", "Agent reiterated the impact due to delay in payment like cibil adhar etc", "Agent gave appropriate and effective rebuttal when the payment was delayed or being differed", "Agent promoted paid C modes to the customer", "Agent did the right probing to gather information from the customer in case of already paid", "Agent checked relevent tools notes details and historry before call back", "Third party disclosure", "Agent updated correct time for call back customer details updated accurately in COSMOS and VICI dial", "Agent used verbal nods to display interest in customers avoids dead-air", "Agent avoided speaking over or interrupt the customer and apologized if interrupted", "Agent acknowledged and/or empathized where appropriate", "Agent sounded confident and showed no sign of hesitancy to convey information", "Clear Explanations - Articulation sentence construction grammar etc", "Agents rate of speech was moderate", "Agent sounded courteous and energetic", "Listening and comprehension", "Agent did not provide/ confirm Incorrect/ incomplete information", "Agent did not follow Incorrect procedure followed to resolve an issue raised by the customer or made No promise", "Agent responded on question or query raised by the customer", "Agent followed the correct Hold procedure", "Agent followed the correct transfer procedure", "Agent did not Disconnect call before the customer or hung up on customer", "Agent was not abusive during the call", "Agent was not side-talking or speaking to another colleague while customer on line", "Agent complied to the call closure script", "Agents tone was appropriate while closing the call", "Follow-up call and appointment fixed as agreed with the customer", "Greeting Score", "Purpose Call Score", "Collection Technique Score", "Communicatio Skill Score", "Telephone Etiquette Score", "Call Closing Score", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='idfc'){
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date Time", "Week", "Customer Phone", "Customer Name", "Loan ID", "Product Name", "Customer VOC", "Customer Sub VOC", "Campaign Name", "Objections", "Call Duration", "Agent Disposition","QA Disposition","Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", 
			"Greeting & Customer Identification","Remarks", "Self Introduction & Reaching RPC","Remarks", "Purpose of call","Remarks", "Complete & Correct information Minor Impact","Remarks", "** Incomplete or Incorrect information","Remarks", "** Incomplete or Wrong Information","Remarks", "Confirmed PU and PTP details","Remarks", "Referred the Trail remarks in CRM","Remarks", "Referred customers Payment history","Remarks", "** Use convincing skills for early payment","Remarks", "Follow appropriate and relevant probing as per the process","Remarks", "Identify accurate reasons of payment delay","Remarks", "Objection Handing","Remarks", "Online payment effectively pitched","Remarks", "Active Listening","Remarks", "Clarity of Speech & Rate of Speech","Remarks", "Tone and Voice Modulation","Remarks", "Empathy","Remarks", "Confidence","Remarks", "Language and Grammar","Remarks", "Telephone Etiquettes & Hold Procedure","Remarks", "** Rudeness or Unprofessionalism","Remarks", "CRM protocol","Remarks", "Capture Alternate number","Remarks", "CRM protocol - Field and Remark Updation","Remarks", "CRM protocol - Disposition","Remarks", "Summarization","Remarks", "Strong assurance on PU PTP","Remarks", "Closing","Remarks", 
			"Call Summary", "Feedback", "Agent Feedback Acceptance Status", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($campaign=='idfc_new'){
		
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
				
				if($user['agent_rvw_date']!="") $agent_rvw_date=ConvServerToLocal($user['agent_rvw_date']);
				else $agent_rvw_date="";
				
				if($user['mgnt_rvw_date']!="") $mgnt_rvw_date=ConvServerToLocal($user['mgnt_rvw_date']);
				else $mgnt_rvw_date="";
				
				if($user['client_rvw_date']!="") $client_rvw_date=ConvServerToLocal($user['client_rvw_date']);
				else $client_rvw_date="";
				
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date_time'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['cycle_date'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['property_code'].'",';
				$row .= '"'.$user['agent_disposition'].'",';
				$row .= '"'.$user['qa_disposition'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentopencallin3sec'].'",';
				$row .= '"'.$user['agentintroducehimself'].'",';
				$row .= '"'.$user['agentintroducecompany'].'",';
				$row .= '"'.$user['agentusedprescribedscript'].'",';
				$row .= '"'.$user['agentclearlyexplained'].'",';
				$row .= '"'.$user['agentquotedpreviouscall'].'",';
				$row .= '"'.$user['agentgetsagreement'].'",';
				$row .= '"'.$user['agentcreateurjency'].'",';
				$row .= '"'.$user['agentreiteratedtheimpact'].'",';
				$row .= '"'.$user['agentgaveeffectiverebruttal'].'",';
				$row .= '"'.$user['agentpromotedpaidC'].'",';
				$row .= '"'.$user['agentdidrightprobing'].'",';
				$row .= '"'.$user['agentcheckrelevanttool'].'",';
				$row .= '"'.$user['3rdpartydisclosure'].'",';
				$row .= '"'.$user['agentupdatedcalltime'].'",';
				$row .= '"'.$user['agentusedverbalnods'].'",';
				$row .= '"'.$user['agentavoidspeakingover'].'",';
				$row .= '"'.$user['agentemphathizedappropiate'].'",';
				$row .= '"'.$user['agentsoundedconfident'].'",';
				$row .= '"'.$user['clearexpansion'].'",';
				$row .= '"'.$user['agentrateofspeech'].'",';
				$row .= '"'.$user['agentsoundedenergetic'].'",';
				$row .= '"'.$user['listeningandcomprehensive'].'",';
				$row .= '"'.$user['agentnotprovideinfo'].'",';
				$row .= '"'.$user['agentnotfollowincorrectprocedure'].'",';
				$row .= '"'.$user['agentresponceonquestion'].'",';
				$row .= '"'.$user['agentfollowHoldprocedure'].'",';
				$row .= '"'.$user['agentfollowtransferprocedure'].'",';
				$row .= '"'.$user['agentnotDisconnectcall'].'",';
				$row .= '"'.$user['agentwasnotabuseonCall'].'",';
				$row .= '"'.$user['agentnotSitetakingonCall'].'",';
				$row .= '"'.$user['agentcompiledoncall'].'",';
				$row .= '"'.$user['agenttoneappropiateonCall'].'",';
				$row .= '"'.$user['followupcallwiththeCustomer'].'",';
				$row .= '"'.$user['greetingscore'].'",';
				$row .= '"'.$user['purposecallscore'].'",';
				$row .= '"'.$user['collectiontechniquescore'].'",';
				$row .= '"'.$user['communicatioskillscore'].'",';
				$row .= '"'.$user['telephoneetiquettescore'].'",';
				$row .= '"'.$user['callclosingscore'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$agent_rvw_date.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$mgnt_rvw_date.'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$client_rvw_date.'",';
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($campaign=='idfc'){
		
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
				
				if($user['agent_rvw_date']!="") $agent_rvw_date=ConvServerToLocal($user['agent_rvw_date']);
				else $agent_rvw_date="";
				
				if($user['mgnt_rvw_date']!="") $mgnt_rvw_date=ConvServerToLocal($user['mgnt_rvw_date']);
				else $mgnt_rvw_date="";
				
				if($user['client_rvw_date']!="") $client_rvw_date=ConvServerToLocal($user['client_rvw_date']);
				else $client_rvw_date="";
				
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['week'].'",';
				$row .= '"'.$user['customer_phone'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['loan_id'].'",';
				$row .= '"'.$user['product_name'].'",';
				$row .= '"'.$user['customer_voc'].'",';
				$row .= '"'.$user['customer_sub_voc'].'",';
				$row .= '"'.$user['campaign_name'].'",';
				$row .= '"'.$user['objections'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['agent_disposition'].'",';
				$row .= '"'.$user['qa_disposition'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
				$row .= '"'.ConvServerToLocal($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['customer_identification'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['self_introduction'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['purpose_of_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['complete_correct'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['incomplete_incorrect'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['incomplete_wrong'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['confirmed_pu'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['referred_the_trail'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['referred_customers_payment'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['use_convincing_skills'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['follow_appropriate'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['identify_accurate_reasons'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['objection_handling'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['online_payment'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['clarity_speech'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'.$user['tone_and_voice'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'.$user['empathy'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'.$user['confidence'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'.$user['language_and_grammar'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'.$user['telephone_etiquettes'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'.$user['rudeness_unprofessionalism'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'.$user['crm_protocol'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
				$row .= '"'.$user['capture_alternate'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
				$row .= '"'.$user['field_and_remark'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
				$row .= '"'.$user['crm_protocol_disposition'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
				$row .= '"'.$user['summarization'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
				$row .= '"'.$user['strong_assurance'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
				$row .= '"'.$user['closing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$agent_rvw_date.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$mgnt_rvw_date.'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'.$client_rvw_date.'",';
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}
		
	
	}
	
	
 }